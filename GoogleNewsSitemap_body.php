<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class googlenewssitemap creates Atom/RSS feeds for Wikinews
 **
 * Simple feed using Atom/RSS coupled to DynamicPageList category searching.
 *
 * To use: http://wiki.url/Special:GoogleNewsSitemap?[paramter=value][&parameter2=value]&...
 *
 * Implemented parameters are marked with an @
 **
 * Parameters
 *	  * categories = string ; default = Published
 *	  * notcategories = string ; default = null
 *	  * namespace = string ; default = null
 *	  * count = integer ; default = $wgDPLmaxResultCount = 50
 *	  * hourcont = integer ; default -1 (disabled), how many hours before cutoff
 *	  * order = string ; default = descending
 *	  * ordermethod = string ; default = categoryadd
 *	  * redirects = string ; default = exclude
 *	  * stablepages = string ; default = null
 *	  * qualitypages = string ; default = null
 *	  * feed = string ; default = sitemap
 **/

class GoogleNewsSitemap extends SpecialPage {

	/**
	 * Script default values - correctly spelt, naming standard.
	 * @todo These should be configurable. Perhaps be $wg globals (?)
	 **/
	var $wgDPlminCategories = 1;   // Minimum number of categories to look for
	var $wgDPlmaxCategories = 6;   // Maximum number of categories to look for
	var $wgDPLmaxResultCount = 50; // Maximum number of results to allow

	var $fallbackCategory = 'Published';

	/**
	 * @var array Parameters array
	 **/
	var $params = array();
	var $categories = array();
	var $notCategories = array();

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct( 'GoogleNewsSitemap' );
	}

	/**
	 * main()
	 **/
	public function execute( $par ) {
		global $wgContLang, $wgSitename, $wgFeedClasses, $wgLanguageCode;

		$this->unload_params(); // populates this->params as a side effect

		// if there's an error parsing the params, bail out and return
		if ( isset( $this->params['error'] ) ) {
			wfHttpError( 500, "Internal Server Error", $this->params['error'] );
			return;
		}

		// Check to make sure that feed type is supported.
		if ( FeedUtils::checkFeedOutput( $this->params['feed'] ) ) {
			$feed = new $wgFeedClasses[ $this->params['feed'] ](
				wfMsgExt( 'googlenewssitemap_feedtitle',
					array( 'parsemag', 'content' ),
					$wgContLang->getLanguageName( $wgLanguageCode ),
					$wgContLang->uc( $this->params['feed'] ),
					$wgLanguageCode
				),
				wfMsgExt( 'tagline', 'parsemag' ),
				Title::newMainPage()->getFullUrl()
			);
		} else {
			// FeedUtils outputs an error if wrong feed type.
			// So nothing else to do at this point
			return;
		}

		$res = $this->doQuery();

		$feed->outHeader();
		foreach ( $res as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );

			if ( !$title ) {
				$feed->outFooter();
				return;
			}

			// Fixme: Under what circumstance would cl_timestamp not be set?
			// possibly worth an exception if that happens.
			$this->pubDate = isset( $row->cl_timestamp ) ? $row->cl_timestamp : wfTimestampNow();

			$feedItem = new FeedSMItem(
				$title,
				$this->pubDate,
				$this->getKeywords( $title )
			);
			$feed->outItem( $feedItem );

		} // end while fetchobject

		$feed->outFooter();

	} // end public function execute

	/**
	 * Build sql
	 **/
	public function doQuery() {

		$dbr = wfGetDB( DB_SLAVE );

		$tables[] = $dbr->tableName( 'page' );

		// this is a little hacky, c1 is dynamically defined as the first category
		// so this can't ever work with uncategorized articles
		$fields = array( 'page_namespace', 'page_title', 'page_id', 'c1.cl_timestamp' );
		$conditions = array();

		if ( $this->params['nameSpace'] ) {
			$conditions['page_namespace'] = $this->params['nameSpace'];
		}

		// If flagged revisions is in use, check which options selected.
		// FIXME: double check the default options; what should it default to?
		if ( function_exists( 'efLoadFlaggedRevs' ) ) {
			$filterSet = array( 'only', 'exclude' );
			# Either involves the same JOIN here...
			if ( in_array( $this->params['stable'], $filterSet ) || in_array( $this->params['quality'], $filterSet ) ) {
				$joins['flaggedpages'] = array( 'LEFT JOIN', 'page_id = fp_page_id' );
			}

			switch( $this->params['stable'] ) {
				case 'only':
					$conditions[] = 'fp_stable IS NOT NULL ';
					break;
				case 'exclude':
					$conditions['fp_stable'] = null;
					break;
			}
			switch( $this->params['quality'] ) {
				case 'only':
					$conditions[] = 'fp_quality >= 1';
					break;
				case 'exclude':
					$conditions['fp_quality'] = 0;
					break;
			}
		}

		switch ( $this->params['redirects'] ) {
			case 'only':
				$conditions['page_is_redirect'] = 1;
			break;
			case 'exclude':
				$conditions['page_is_redirect'] = 0;
			break;
		}

		if ( $this->params['hourCount'] > 0
			&& $this->params['orderMethod'] !== 'lastedit' )
		{
			// Limit to last X number of hours added to category,
			// if hourcont is positive and we're sorting by
			// category add date.
			// This feature is here because the Google News
			// Sitemap usecase is only supposed to have
			// articles published in last 2 days on it.
			// Don't do anything with lastedit, since this option
			// doesn't make sense with it (Do we even need that order method?)
			$timeOffset = wfTimestamp( TS_UNIX ) - ( $this->params['hourCount'] * 3600 );
			$MWTimestamp = wfTimestamp( TS_MW, $timeOffset );
			if ( $MWTimestamp ) {
				$conditions[] = 'c1.cl_timestamp > ' . $MWTimestamp;
			}
		}

		$currentTableNumber = 1;
		$categorylinks = $dbr->tableName( 'categorylinks' );

		$joins = array();
		for ( $i = 0; $i < $this->params['catCount']; $i++ ) {
			$joins["$categorylinks AS c$currentTableNumber"] = array( 'INNER JOIN',
				array( "page_id = c{$currentTableNumber}.cl_from",
					"c{$currentTableNumber}.cl_to={$dbr->addQuotes( $this->categories[$i]->getDBKey() ) }"
				)
			);
			$tables[] = "$categorylinks AS c$currentTableNumber";
			$currentTableNumber++;
		}

		for ( $i = 0; $i < $this->params['notCatCount']; $i++ ) {
			$joins["$categorylinks AS c$currentTableNumber"] = array( 'LEFT OUTER JOIN',
				array( "page_id = c{$currentTableNumber}.cl_from",
					"c{$currentTableNumber}.cl_to={$dbr->addQuotes( $this->notCategories[$i]->getDBKey() ) }"
				)
			);
			$tables[] = "$categorylinks AS c$currentTableNumber";
			$conditions[] = "c{$currentTableNumber}.cl_to IS NULL";
			$currentTableNumber++;
		}

		if ( $this->params['order'] === 'descending' ) {
			$sortOrder = 'DESC';
		} else {
			$sortOrder = 'ASC';
		}

		if ( $this->params['orderMethod'] === 'lastedit' ) {
			$options['ORDER BY'] = 'page_touched ' . $sortOrder;
		} else {
			$options['ORDER BY'] = 'c1.cl_timestamp ' . $sortOrder;
		}


		// earlier validation logic ensures this is a reasonable number
		$options['LIMIT'] = $this->params['count'];

		return $dbr->select( $tables, $fields, $conditions, __METHOD__, $options, $joins );
	}

	/**
	 * Parse parameters, populates $this->params
	 **/
	public function unload_params() {
		global $wgContLang;
		global $wgRequest;

		$this->params = array();

		$this->categories = $this->getCatRequestArray( 'categories', $this->fallbackCategory, $this->wgDPlmaxCategories );
		$this->notCategories = $this->getCatRequestArray( 'notcategories', '', $this->wgDPlmaxCategories );

		// FIXME:notcats
		// $this->notCategories[] = $wgRequest->getArray('notcategory');
		$this->params['nameSpace'] = $wgContLang->getNsIndex( $wgRequest->getVal( 'namespace', 0 ) );
		$this->params['count'] = $wgRequest->getInt( 'count', $this->wgDPLmaxResultCount );
		$this->params['hourCount'] = $wgRequest->getInt( 'hourcount', -1 );

		if ( ( $this->params['count'] > $this->wgDPLmaxResultCount )
				|| ( $this->params['count'] < 1 ) )
		{
			$this->params['count'] = $this->wgDPLmaxResultCount;
		}

		$this->params['order'] = $wgRequest->getVal( 'order', 'descending' );
		$this->params['orderMethod'] = $wgRequest->getVal( 'ordermethod', 'categoryadd' );
		$this->params['redirects'] = $wgRequest->getVal( 'redirects', 'exclude' );
		$this->params['stable'] = $wgRequest->getVal( 'stable', 'only' );
		$this->params['quality'] = $wgRequest->getVal( 'qualitypages', 'only' );
		$this->params['feed'] = $wgRequest->getVal( 'feed', 'sitemap' );

		$this->params['catCount'] = count( $this->categories );
		$this->params['notCatCount'] = count( $this->notCategories );
		$totalCatCount = $this->params['catCount'] + $this->params['notCatCount'];

		if ( ( $this->params['catCount'] < 1 && !$this->params['nameSpace'] )
			|| ( $totalCatCount < 1 ) )
		{
			$fallBack = Title::newFromText( $this->fallbackCategory, NS_CATEGORY );
			if ( $fallBack ) {
				$this->categories[] = $fallBack;
				$this->params['catCount'] = count( $this->categories );
			} else {
				throw new MWException( "Default fallback category is not a valid title!" );
			}
		}

		if ( $totalCatCount > $this->wgDPlmaxCategories ) {
			$this->params['error'] = htmlspecialchars( wfMsg( 'googlenewssitemap_toomanycats' ) );
		}

		// Disallow showing date if the query doesn't have an inclusion category parameter.
		if ( $this->params['count'] < 1 ) {
			$this->params['addFirstCategoryDate'] = false;
		}

	}

	/**
	 * Turn a pipe-seperated list from a url parameter into an array.
	 * Verifying each element would be a valid title in Category namespace.
	 * @param String $name Parameter to retrieve from web reqeust.
	 * @param String $default
	 * @param Integer $max Maximuin size of resulting array.
	 * @return Array of Title objects. The Titles passed in the parameter $name.
	 */
	private function getCatRequestArray( $name, $default, $max ) {
		global $wgRequest;

		$value = $wgRequest->getText( $name, $default );
		$arr = explode( "|", $value, $max + 2 );
		$res = array();
		foreach ( $arr as $name ) {
			$catTitle = Title::newFromText( $name, NS_CATEGORY );
			if ( $catTitle ) {
				$res[] = $catTitle;
			}
		}
		return $res;
	}

	/**
	 * Given a title, figure out what keywords. Use the message googlenewssitemap_categorymap
	 * to map local categories to Google News Keywords.
	 * @see http://www.google.com/support/news_pub/bin/answer.py?answer=116037
	 * @param Title $title
	 * @return string Comma seperated list of keywords
	 */
	function getKeywords ( $title ) {
		$cats = $title->getParentCategories();
		$str = '';

		# the following code is based (stolen) from r56954 of flagged revs.
		$catMap = array();
		$catMask = array();
		$msg = wfMsg( 'googlenewssitemap_categorymap' );
		if ( !wfEmptyMsg( 'googlenewssitemap_categorymap', $msg ) ) {
			$list = explode( "\n*", "\n$msg" );
			foreach ( $list as $item ) {
				$mapping = explode( '|', $item, 2 );
				if ( count( $mapping ) == 2 ) {
					if ( trim( $mapping[1] ) == '__MASK__' ) {
						$catMask[trim( $mapping[0] )] = true;
					} else {
						$catMap[trim( $mapping[0] )] = trim( $mapping[1] );
					}
				}
			}
		}
		foreach ( $cats as $key => $val ) {
			$cat = str_replace( '_', ' ', trim( substr( $key, strpos( $key, ':' ) + 1 ) ) );
				if ( !isset( $catMask[$cat] ) ) {
					if ( isset( $catMap[$cat] ) ) {
					   $str .= ', ' . str_replace( '_', ' ', trim ( $catMap[$cat] ) );
					} else {
						$str .= ', ' . $cat;
					}
				}
		}
		$str = substr( $str, 2 ); # to remove leading ', '
		return $str;
	}
}
