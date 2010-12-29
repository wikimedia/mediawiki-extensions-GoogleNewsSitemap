<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class googlenewssitemap creates Atom/RSS feeds for Wikinews
 **
 * Simple feed using Atom/RSS coupled to DynamicPageList category searching.
 *
 * To use: http://wiki.url/Special:GoogleNewsSitemap/[paramter=value][...]
 *
 * Implemented parameters are marked with an @
 **
 * Parameters
 *	  * category = string ; default = Published
 *	  * notcategory = string ; default = null
 *	  * namespace = string ; default = null
 *	  * count = integer ; default = $wgDPLmaxResultCount = 50
 *	  * order = string ; default = descending
 *	  * ordermethod = string ; default = categoryadd
 *	  * redirects = string ; default = exclude
 *	  * stablepages = string ; default = null
 *	  * qualitypages = string ; default = null
 *	  * feed = string ; default = atom
 *	usenamespace = bool ; default = false
 *	usecurid = bool ; default = false
 *	suppresserrors = bool ; default = false
 **/

class GoogleNewsSitemap extends IncludableSpecialPage {
	/**
	 * FIXME: Some of this might need a config eventually
	 * @var string
	 **/
	var $Title = '';
	var $Description = '';
	var $Url = '';
	var $Date = '';
	var $Author = '';
	var $pubDate = '';
	var $keywords = '';
	var $lastMod = '';
	var $priority = '';

	/**
	 * Script default values - correctly spelt, naming standard.
	 **/
	var $wgDPlminCategories = 1;				   // Minimum number of categories to look for
	var $wgDPlmaxCategories = 6;				   // Maximum number of categories to look for
	var $wgDPLminResultCount = 1;			   // Minimum number of results to allow
	var $wgDPLmaxResultCount = 50;			   // Maximum number of results to allow
	var $wgDPLallowUnlimitedResults = true;	   // Allow unlimited results
	var $wgDPLallowUnlimitedCategories = false; // Allow unlimited categories

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
		global $wgUser, $wgLang, $wgContLang, $wgRequest, $wgOut,
			$wgSitename, $wgServer, $wgScriptPath, $wgFeedClasses,
			$wgLocaltimezone;

		// Not sure how clean $wgLocaltimezone is
		// In fact, it's default setting is null...
		if ( null == $wgLocaltimezone ) {
			$wgLocaltimezone = date_default_timezone_get();
		}
		date_default_timezone_set( $wgLocaltimezone );
		// $url = __FILE__;

		$this->unload_params(); // populates this->params as a side effect

		// if there's an error parsing the params, bail out and return 
		if ( isset( $this->param['error'] ) ) {
			if ( false == $this->params['suppressErrors'] ) {
				$wgOut->disable();
				echo $this->param['error'];
			}
			return;
		}


		$wgFeedClasses['sitemap'] = 'SitemapFeed' ;

		$feed = new $wgFeedClasses[ $this->params['feed'] ](
				$wgSitename,
				$wgSitename . ' ' . $this->params['feed'] . ' feed',
				$wgServer . $wgScriptPath,
				date( DATE_ATOM ),
				$wgSitename
			);

		$feed->outHeader();

		$dbr = wfGetDB( DB_SLAVE );
		$sql = $this->dpl_buildSQL();
		// Debug line
		// echo "\n<p>$sql</p>\n";
		$res = $dbr->query ( $sql );

		// FIXME: figure out how to fail with no results gracefully
		if ( $dbr->numRows( $res ) == 0 ) {
			$feed->outFooter();
			if ( false == $this->params['suppressErrors'] ) {
				echo htmlspecialchars( wfMsg( 'googlenewssitemap_noresults' ) );
				return;
			} else {
				return '';
			}
		}

		while ( $row = $dbr->fetchObject( $res ) ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );

			if ( !$title ) {
				$feed->outFooter();
				return;
			}

			$titleText = ( true == $this->params['nameSpace'] ) ? $title->getPrefixedText() : $title->getText();

			if ( 'sitemap' == $this->params['feed'] ) {

				$this->pubDate = isset( $row->cl_timestamp ) ? $row->cl_timestamp : date( DATE_ATOM );
				$feedArticle = new Article( $title );

				$feedItem = new FeedSMItem(
				   trim( $title->getFullURL() ),
				   wfTimeStamp( TS_ISO_8601, $this->pubDate ),
				   $this->getKeywords( $title ),
				   wfTimeStamp( TS_ISO_8601, $feedArticle->getTouched() ),
				   $feed->getPriority( $this->priority )
				);

			} elseif ( ( 'atom' == $this->params['feed'] ) || ( 'rss' == $this->params['feed'] ) ) {

				$this->Date = isset( $row->cl_timestamp ) ? $row->cl_timestamp : date( DATE_ATOM );
				if ( isset( $row->comment ) ) {
					$comments = htmlspecialchars( $row->comment );
				} else {
					$talkpage = $title->getTalkPage();
					$comments = $talkpage->getFullURL();
				}
				$titleText = ( true === $this->params['nameSpace'] ) ? $title->getPrefixedText() : $title->getText();
				$feedItem = new FeedItem(
								$titleText,
								$this->feedItemDesc( $row ),
								$title->getFullURL(),
								$this->Date,
								$this->feedItemAuthor( $row ),
								$comments );
			}
			$feed->outItem( $feedItem );
		}// end while fetchobject
		$feed->outFooter();
	} // end public function execute

	/**
	 * Build sql
	 **/
	public function dpl_buildSQL() {

		$sqlSelectFrom = 'SELECT page_namespace, page_title, page_id, c1.cl_timestamp FROM ' . $this->params['dbr']->tableName( 'page' );

		if ( $this->params['nameSpace'] ) {
			$sqlWhere = ' WHERE page_namespace=' . $this->params['nameSpace'] . ' ';
		} else {
			$sqlWhere = ' WHERE 1=1 ';
		}

		// If flagged revisions is in use, check which options selected.
		// FIXME: double check the default options in function::dpl_parm; what should it default to?
		if ( function_exists( 'efLoadFlaggedRevs' ) ) {
			$flaggedPages = $this->params['dbr']->tableName( 'flaggedpages' );
			$filterSet = array( 'only', 'exclude' );
			# Either involves the same JOIN here...
			if ( in_array( $this->params['stable'], $filterSet ) || in_array( $this->params['quality'], $filterSet ) ) {
				$sqlSelectFrom .= " LEFT JOIN $flaggedPages ON page_id = fp_page_id";
				}
				switch( $this->params['stable'] ) {
				case 'only':
					$sqlWhere .= ' AND fp_stable IS NOT NULL ';
					break;
				case 'exclude':
					$sqlWhere .= ' AND fp_stable IS NULL ';
					break;
				}
				switch( $this->params['quality'] ) {
				case 'only':
							$sqlWhere .= ' AND fp_quality >= 1';
					break;
				case 'exclude':
					$sqlWhere .= ' AND fp_quality = 0';
					break;
				}
			}

			switch ( $this->params['redirects'] ) {
				case 'only':
					$sqlWhere .= ' AND page_is_redirect = 1 ';
				break;
				case 'exclude':
					$sqlWhere .= ' AND page_is_redirect = 0 ';
				break;
			}

			$currentTableNumber = 0;

			for ( $i = 0; $i < $this->params['catCount']; $i++ ) {
				$sqlSelectFrom .= ' INNER JOIN ' . $this->params['dbr']->tableName( 'categorylinks' );
					$sqlSelectFrom .= ' AS c' . ( $currentTableNumber + 1 ) . ' ON page_id = c';
				$sqlSelectFrom .= ( $currentTableNumber + 1 ) . '.cl_from AND c' . ( $currentTableNumber + 1 );

				$sqlSelectFrom .= '.cl_to=' . $this->params['dbr']->addQuotes( $this->categories[$i]->getDBkey() );

				$currentTableNumber++;
			}

			for ( $i = 0; $i < $this->params['notCatCount']; $i++ ) {
				// echo "notCategory parameter $i<br />\n";
				$sqlSelectFrom .= ' LEFT OUTER JOIN ' . $this->params['dbr']->tableName( 'categorylinks' );
				$sqlSelectFrom .= ' AS c' . ( $currentTableNumber + 1 ) . ' ON page_id = c' . ( $currentTableNumber + 1 );
				$sqlSelectFrom .= '.cl_from AND c' . ( $currentTableNumber + 1 );
				$sqlSelectFrom .= '.cl_to=' . $this->params['dbr']->addQuotes( $this->notCategories[$i]->getDBkey() );

				$sqlWhere .= ' AND c' . ( $currentTableNumber + 1 ) . '.cl_to IS NULL';

				$currentTableNumber++;
			}

			if ( 'lastedit' == $this->params['orderMethod'] ) {
				$sqlWhere .= ' ORDER BY page_touched ';
			} else {
				$sqlWhere .= ' ORDER BY c1.cl_timestamp ';
			}

			if ( 'descending' == $this->params['order'] ) {
				$sqlWhere .= 'DESC';
			} else {
				$sqlWhere .= 'ASC';
			}

			// FIXME: Note: this is not a boolean type check - will also trap count = 0 which may
			// accidentally give unlimited returns
			if ( 0 < $this->params['count'] ) {
				$sqlWhere .= ' LIMIT ' . $this->params['count'];
			}

			// debug line
			// echo "<p>$sqlSelectFrom$sqlWhere;</p>\n";

			return $sqlSelectFrom . $sqlWhere;
	} // end buildSQL

	/**
	 * Parse parameters, populates $this->params
	 **/
	public function unload_params() {
		global $wgContLang;
		global $wgRequest;

		$this->params = array();
		$parser = new Parser;
		$poptions = new ParserOptions;
		$category =    $wgRequest->getArray( 'category', 'Published' );
		// $title = Title::newFromText( $parser->transformMsg( $category, $poptions ) );
		// if ( is_object( $title ) ){
		//	   $this->categories[] = $title;
		// }
		// FIXME:notcats
		// $this->notCategories[] = $wgRequest->getArray('notcategory');
		$this->params['nameSpace'] =   $wgContLang->getNsIndex( $wgRequest->getVal( 'namespace', 0 ) );
		$this->params['count'] =	   $wgRequest->getInt( 'count', $this->wgDPLmaxResultCount );
		if ( ( $this->params['count'] > $this->wgDPLmaxResultCount )
				|| ( $this->params['count'] < $this->wgDPLminResultCount ) ) {
			$this->params['count'] = $this->wgDPLmaxResultCount;
		}

		$this->params['order'] =	   $wgRequest->getVal( 'order', 'descending' );
		$this->params['orderMethod'] = $wgRequest->getVal( 'ordermethod', 'categoryadd' );
		$this->params['redirects'] =   $wgRequest->getVal( 'redirects', 'exclude' );
		$this->params['stable'] =	   $wgRequest->getVal( 'stable', 'only' );
		$this->params['quality'] =	   $wgRequest->getVal( 'qualitypages', 'only' );
		$this->params['suppressErrors'] = $wgRequest->getBool( 'supresserrors', false );
		$this->params['useNameSpace'] = $wgRequest->getBool( 'usenamespace', false );
		$this->params['useCurId'] =		$wgRequest->getBool( 'usecurid', false );
		$this->params['feed'] = $wgRequest->getVal( 'feed', 'sitemap' );

		$this->params['catCount'] = count( $this->categories );
		$this->params['notCatCount'] = count( $this->notCategories );
		$totalCatCount = $this->params['catCount'] + $this->params['notCatCount'];
		if ( ( $this->params['catCount'] < 1 && false == $this->params['nameSpace'] ) || ( $totalCatCount < $this->wgDPlminCategories ) ) {
		// echo "Boom on catCount\n";
			$parser = new Parser;
			$poptions = new ParserOptions;
			$feed =  Title::newFromText( $parser->transformMsg( 'Published', $poptions ) );
			if ( is_object( $feed ) ) {
				$this->categories[] = $feed;
				$this->params['catCount'] = count( $this->categories );
			} else {
				$this->params['error'] = htmlspecialchars( wfMsg( 'googlenewssitemap_badfeedobject' ) );
				// continue;
			}
		}

		if ( ( $totalCatCount > $this->wgDPlmaxCategories ) && ( !$this->wgDPLallowUnlimitedCategories ) ) {
			$this->params['error'] = htmlspecialchars( wfMsg( 'googlenewssitemap_toomanycats' ) ); // "!!too many categories!!";
		}

			// disallow showing date if the query doesn't have an inclusion category parameter
		if ( $this->params['count'] < 1 ) {
			$this->params['addFirstCategoryDate'] = false;
		}

		$this->params['dbr'] =& wfGetDB( DB_SLAVE );
		// print_r($this->notCategories);
		// print_r($this->categories);
	}

	function feedItemAuthor( $row ) {
		return isset( $row->user_text ) ? $row->user_text : 'Wikinews';
	}

	function feedItemDesc( $row ) {
		return isset( $row->comment ) ? htmlspecialchars( $row->comment ) : '';
	}

	function getKeywords ( $title ) {
		$cats = $title->getParentCategories();
		$str = '';
			# the following code is based (stolen) from r56954 of flagged revs.
		$catMap = Array();
		$catMask = Array();
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
