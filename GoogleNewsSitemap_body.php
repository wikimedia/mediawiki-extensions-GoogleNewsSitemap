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
 *	  * count = integer ; default = $wgGNSMmaxResultCount = 50
 *	  * hourcont = integer ; default -1 (disabled), how many hours before cutoff
 *	  * order = string ; default = descending
 *	  * ordermethod = string ; default = categoryadd
 *	  * redirects = string ; default = exclude
 *	  * stablepages = string ; default = null
 *	  * qualitypages = string ; default = null
 *	  * feed = string ; default = sitemap
 **/

class GoogleNewsSitemap extends SpecialPage {

	var $maxCacheTime = 43200; // 12 hours. Chosen rather arbitrarily for now. Might want to tweak.

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
		global $wgContLang, $wgSitename, $wgFeedClasses, $wgLanguageCode, $wgMemc;

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
				wfMsgExt( 'tagline', array( 'parsemag', 'content') ),
				Title::newMainPage()->getFullUrl()
			);
		} else {
			// FeedUtils outputs an error if wrong feed type.
			// So nothing else to do at this point
			return;
		}

		$cacheInvalidationInfo = $this->getCacheInvalidationInfo();

		$cacheKey = $this->getCacheKey();

		// The way this does caching is based on ChangesFeed::execute.
		$cached = $this->getCachedVersion( $cacheKey, $cacheInvalidationInfo );
		if ( $cached !== false ) {
			$feed->httpHeaders();
			echo $cached;
			echo "<!-- From cache: $cacheKey -->";
		} else {
			$res = $this->doQuery();
			ob_start();
			$this->makeFeed( $feed, $res );
			$output = ob_get_contents();
			ob_end_flush();
			echo "<!-- Not cached. Saved as: $cacheKey -->";
			$wgMemc->set( $cacheKey,
				array( $cacheInvalidationInfo, $output ),
				$this->maxCacheTime
			);
		}

	}

	/**
	 * Get the cache key to cache this request.
	 * @return String the key.
	 */
	private function getCacheKey() {
		global $wgRenderHashAppend;
		// Note, the implode relies on Title::__toString, which needs php > 5.2
		// Which I think is above the minimum we support.
		$sum = md5( serialize( $this->params )
			. implode( "|", $this->categories ) . "||"
			. implode( "|", $this->notCategories )
		);
		return wfMemcKey( "GNSM", $sum, $wgRenderHashAppend );
	}

	/**
	 * Get the cached version of the feed if possible.
	 * Checks to see if the cached version is still valid.
	 * @param $key String Cache key
	 * @param $invalidInfo String String to check if cache is clean from getCacheInvalidationInfo.
	 * @return Mixed String or Boolean: The cached feed, or false.
	 */
	private function getCachedVersion ( $key, $invalidInfo ) {
		global $wgMemc, $wgRequest;
		$action = $wgRequest->getVal( 'action', 'view' );
		if ( $action === 'purge' ) {
			return false;
		}

		$cached = $wgMemc->get( $key );

		if ( !$cached 
			|| ( count( $cached ) !== 2 ) 
			|| ( $cached[0] !== $invalidInfo ) )
		{
			// Cache is dirty or doesn't exist.
			return false;
		}
		return $cached[1];
	}
	/**
	 * Actually output a feed.
	 * @param ChannelFeed $feed Feed object.
	 * @param $res Result of sql query
	 */

	private function makeFeed( $feed, $res ) {
		global $wgGNSMcommentNamespace;
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
				$this->getKeywords( $title ),
				$wgGNSMcommentNamespace
			);
			$feed->outItem( $feedItem );
		}
		$feed->outFooter();
	}

	/**
	 * Tries to determine if the cached version of the feed is still
	 * good. Does this by checking the cl_timestamp of the latest article
	 * in each category we're using (Which will be different if category added)
	 * and the total pages in Category (Protect against an article being removed)
	 * The first check (cl_timestamp) is needed to protect against someone removing
	 * one article and adding another article (the page count would stay the same).
	 *
	 * When we save to cache, we save a two element array with this value and the feed.
	 * If the value from this function doesn't match the value from the cache, we throw
	 * out the cache.
	 *
	 * @return String All the above info concatenated.
	 */
	private function getCacheInvalidationInfo () {
		$dbr = wfGetDB( DB_SLAVE );
		$cacheInfo = '';
		$categories = array();
		$tsQueries = array();

		// This would perhaps be nicer just using a Category object,
		// but this way can do all at once.

		// Add each category and notcategory to the query.
		for ( $i = 0; $i < $this->params['catCount']; $i++ ) {
			$key = $this->categories[$i]->getDBkey();
			$categories[] = $key;
			$tsQueries[] = $dbr->selectSQLText(
				'categorylinks',
				'MAX(cl_timestamp) as ts',
				array( 'cl_to' => $key ),
				__METHOD__
			);
		}
		for ( $i = 0; $i < $this->params['notCatCount']; $i++ ) {
			$key = $this->notCategories[$i]->getDBkey();
			$categories[] = $key;
			$tsQueries[] = $dbr->selectSQLText(
				'categorylinks',
				'MAX(cl_timestamp) AS ts',
				array( 'cl_to' => $key ),
				__METHOD__
			);
		}

		// phase 1: How many pages in each cat.
		// cat_pages includes all pages (even images/subcats).
		$res = $dbr->select( 'category', 'cat_pages',
			array( 'cat_title' => $categories ),
			__METHOD__,
			array( 'ORDER BY' => 'cat_title' )
		);

		foreach ( $res as $row ) {
			$cacheInfo .= $row->cat_pages . '!';
		}

		$cacheInfo .= '|';

		// Part 2: cl_timestamp:
		// TODO: Double check that the order of the result of union queries
		// is one after another from the order you specified the queries in.
		$res2 = $dbr->query($dbr->unionQueries( $tsQueries, true ), __METHOD__);

		foreach ( $res2 as $row ) {
			if ( is_null($row->ts) ) {
				$ts = "empty";
			} else {
				$ts = wfTimestamp( TS_MW, $row->ts );
			}
			$cacheInfo .= $ts . '!';
		}

		return $cacheInfo;
	}
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

		if ( $this->params['nameSpace'] !== false ) {
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
		global $wgContLang, $wgRequest, $wgGNSMmaxCategories,
			$wgGNSMmaxResultCount, $wgGNSMfallbackCategory;

		$this->params = array();

		$this->categories = $this->getCatRequestArray( 'categories', $wgGNSMfallbackCategory, $wgGNSMmaxCategories );
		$this->notCategories = $this->getCatRequestArray( 'notcategories', '', $wgGNSMmaxCategories );

		$this->params['nameSpace'] = $this->getNS( $wgRequest->getVal( 'namespace', 0 ) );

		$this->params['count'] = $wgRequest->getInt( 'count', $wgGNSMmaxResultCount );
		$this->params['hourCount'] = $wgRequest->getInt( 'hourcount', -1 );

		if ( ( $this->params['count'] > $wgGNSMmaxResultCount )
				|| ( $this->params['count'] < 1 ) )
		{
			$this->params['count'] = $wgGNSMmaxResultCount;
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

		if ( $this->params['catCount'] < 1 ) {
			// Always require at least one include category.
			// Without an include category, cl_timestamp will be null.
			// Which will probably manifest as a weird bug.
			$fallBack = Title::newFromText( $wgGNSMfallbackCategory, NS_CATEGORY );
			if ( $fallBack ) {
				$this->categories[] = $fallBack;
				$this->params['catCount'] = count( $this->categories );
			} else {
				throw new MWException( 'Default fallback category ($wgGNSMfallbackCategory) is not a valid title!' );
			}
		}

		if ( $totalCatCount > $wgGNSMmaxCategories ) {
			// Causes a 500 error later on.
			$this->params['error'] = htmlspecialchars( wfMsg( 'googlenewssitemap_toomanycats' ) );
		}
	}
	/**
	 * Decode the namespace url parameter.
	 * @param $ns String Either numeric ns number, ns name, or special value :all:
	 * @return Mixed Integer or false Namespace number or false for no ns filtering.
	 */
	private function getNS ( $ns ) {
		global $wgContLang;

		$nsNumb = $wgContLang->getNsIndex( $ns );

		if ( $nsNumb !== false ) {
			// If they specified something like Talk or Image.
			return $nsNumb;
		} else if ( is_numeric( $ns ) ) {
			// If they specified a number.
			$nsVal = intval( $ns );
			if ( $nsVal >= 0 && MWNamespace::exists( $nsVal ) ) {
				return $nsVal;
			} else {
				wfDebug( __METHOD__ . ' Invalid numeric ns number. Using main.' );
				return 0;
			}
		} else if ( $ns === ':all:' ) {
			// Need someway to denote no namespace filtering,
			// This seems as good as any since a namespace can't
			// have colons in it.
			return false;
		} else {
			// Default of main only if user gives bad input.
			// Note, this branch is only reached on bad input. Omitting
			// the namespace parameter is like saying namespace=0.
			wfDebug( __METHOD__ . ' Invalid (non-numeric) ns. Using main.' );
			return 0;
		}

	}

	/**
	 * Turn a pipe-separated list from a url parameter into an array.
	 * Verifying each element would be a valid title in Category namespace.
	 * @param String $name Parameter to retrieve from web reqeust.
	 * @param String $default
	 * @param Integer $max Maximum size of resulting array.
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
	 * @return String Comma separated list of keywords
	 */
	function getKeywords ( $title ) {
		$cats = $title->getParentCategories();
		$str = '';

		# the following code is based (stolen) from r56954 of flagged revs.
		$catMap = array();
		$catMask = array();
		$msg = wfMsg( 'googlenewssitemap_categorymap' );
		if ( !wfEmptyMsg( 'googlenewssitemap_categorymap' ) ) {
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
