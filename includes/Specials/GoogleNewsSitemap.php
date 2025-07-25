<?php

namespace MediaWiki\Extension\GoogleNewsSitemap\Specials;

use MediaWiki\Extension\GoogleNewsSitemap\FeedSMItem;
use MediaWiki\Extension\GoogleNewsSitemap\Hooks\HookRunner;
use MediaWiki\Feed\ChannelFeed;
use MediaWiki\Feed\FeedUtils;
use MediaWiki\HookContainer\HookContainer;
use MediaWiki\Language\Language;
use MediaWiki\Languages\LanguageNameUtils;
use MediaWiki\Linker\LinksMigration;
use MediaWiki\MainConfigNames;
use MediaWiki\SpecialPage\SpecialPage;
use MediaWiki\Title\NamespaceInfo;
use MediaWiki\Title\Title;
use RuntimeException;
use Wikimedia\ObjectCache\WANObjectCache;
use Wikimedia\Rdbms\ILoadBalancer;
use Wikimedia\Rdbms\IResultWrapper;

/**
 * Class GoogleNewsSitemap creates Atom/RSS feeds for Wikinews
 *
 * Simple feed using Atom/RSS coupled to DynamicPageList category searching.
 *
 * To use: http://wiki.url/Special:GoogleNewsSitemap?[parameter=value][&parameter2=value]&...
 *
 * Implemented parameters are marked with an @
 *
 * Parameters
 *	  * categories = string ; default = Published
 *	  * notcategories = string ; default = null
 *	  * namespace = string ; default = 0 (main)
 *	  * count = integer ; default = $wgGNSMmaxResultCount = 50
 *	  * hourcont = integer ; default -1 (disabled), how many hours before cutoff
 *	  * order = string ; default = descending
 *	  * ordermethod = string ; default = categoryadd
 *	  * redirects = string ; default = exclude
 *	  * stablepages = string ; default = only
 *	  * qualitypages = string ; default = include
 *	  * feed = string ; default = sitemap
 */

class GoogleNewsSitemap extends SpecialPage {
	/** @var int 12 hours. Chosen rather arbitrarily for now. Might want to tweak. */
	public $maxCacheTime = 43200;

	public const OPT_INCLUDE = 0;
	public const OPT_ONLY = 1;
	public const OPT_EXCLUDE = 2;

	private NamespaceInfo $namespaceInfo;
	private Language $contentLanguage;
	private WANObjectCache $mainWANObjectCache;
	private ILoadBalancer $loadBalancer;
	private HookRunner $hookRunner;
	private LanguageNameUtils $languageNameUtils;
	private LinksMigration $linksMigration;

	/**
	 * @param NamespaceInfo $namespaceInfo
	 * @param Language $contentLanguage
	 * @param WANObjectCache $mainWANObjectCache
	 * @param ILoadBalancer $loadBalancer
	 * @param HookContainer $hookContainer
	 * @param LanguageNameUtils $languageNameUtils
	 * @param LinksMigration $linksMigration
	 */
	public function __construct(
		NamespaceInfo $namespaceInfo,
		Language $contentLanguage,
		WANObjectCache $mainWANObjectCache,
		ILoadBalancer $loadBalancer,
		HookContainer $hookContainer,
		LanguageNameUtils $languageNameUtils,
		LinksMigration $linksMigration
	) {
		parent::__construct( 'GoogleNewsSitemap' );
		$this->namespaceInfo = $namespaceInfo;
		$this->contentLanguage = $contentLanguage;
		$this->mainWANObjectCache = $mainWANObjectCache;
		$this->loadBalancer = $loadBalancer;
		$this->hookRunner = new HookRunner( $hookContainer );
		$this->languageNameUtils = $languageNameUtils;
		$this->linksMigration = $linksMigration;
	}

	/**
	 * main()
	 * @param string|null $par
	 */
	public function execute( $par ) {
		[ $params, $categories, $notCategories ] = $this->getParams();

		// if there's an error parsing the params, bail out and return
		if ( isset( $params['error'] ) ) {
			wfHttpError( 500, 'Internal Server Error', $params['error'] );
			return;
		}

		// Check to make sure that feed type is supported.
		if ( !FeedUtils::checkFeedOutput( $params['feed'], $this->getOutput() ) ) {
			// FeedUtils outputs an error if wrong feed type.
			// So nothing else to do at this point
			return;
		}

		$msg = $this->msg( 'feed-' . $params['feed'] )->inContentLanguage();
		if ( $msg->exists() ) {
			// This seems a little icky since
			// its re-using another message in a
			// different context.
			// uses feed-rss and feed-atom messages.
			$feedType = $msg->text();
		} else {
			$feedType = $this->contentLanguage->uc( $params['feed'] );
		}

		$contentLangCode = $this->getContentLanguage()->getCode();

		$feedClasses = $this->getConfig()->get( MainConfigNames::FeedClasses );
		$feed = new $feedClasses[ $params['feed'] ](
			$this->msg( 'googlenewssitemap_feedtitle',
				$this->languageNameUtils->getLanguageName(
					$contentLangCode,
					$this->contentLanguage->getCode()
				),
				$feedType,
				$contentLangCode
			)->inContentLanguage()->text(),
			$this->msg( 'tagline' )->inContentLanguage()->text(),
			Title::newMainPage()->getFullURL()
		);

		$this->getOutput()->setCdnMaxage( $this->getConfig()->get( 'GNSMsmaxage' ) );

		$cacheInvalidationInfo = $this->getCacheInvalidationInfo( $params,
			$categories, $notCategories );

		$cacheKey = $this->getCacheKey( $params, $categories, $notCategories );

		// The way this does caching is based on ChangesFeed::execute.
		$cached = $this->getCachedVersion( $cacheKey, $cacheInvalidationInfo );
		if ( $cached !== false ) {
			$feed->httpHeaders();
			echo $cached;
			echo "<!-- From cache: $cacheKey -->";
		} else {
			$res = $this->getCategories( $params, $categories, $notCategories );
			ob_start();
			$this->makeFeed( $feed, $res );
			$output = ob_get_contents();
			ob_end_flush();
			echo "<!-- Not cached. Saved as: $cacheKey -->";
			$this->mainWANObjectCache->set( $cacheKey,
				[ $cacheInvalidationInfo, $output ],
				$this->maxCacheTime
			);
		}
	}

	/**
	 * Get the cache key to cache this request.
	 * @param array $params
	 * @param array $categories
	 * @param array $notCategories
	 * @return string the key.
	 */
	private function getCacheKey( $params, $categories, $notCategories ) {
		// Note, the implode relies on Title::__toString, which needs PHP > 5.2
		// Which I think is above the minimum we support.
		$sum = md5( serialize( $params )
			. implode( '|', $categories ) . '||'
			. implode( '|', $notCategories )
		);
		return $this->mainWANObjectCache->makeKey(
			'GNSM-feed',
			$sum,
			$this->getConfig()->get( MainConfigNames::RenderHashAppend )
		);
	}

	/**
	 * Get the cached version of the feed if possible.
	 * Checks to see if the cached version is still valid.
	 *
	 * Note, this doesn't take into account changes to the keyword
	 * mapping message (See getKeywords). I don't think that's a major issue.
	 *
	 * @param string $key Cache key
	 * @param string $invalidInfo String to check if cache is clean from getCacheInvalidationInfo.
	 * @return string|bool The cached feed (from makeFeed()), or false.
	 * @return-taint escaped
	 */
	private function getCachedVersion( $key, $invalidInfo ) {
		$action = $this->getRequest()->getVal( 'action', 'view' );
		if ( $action === 'purge' ) {
			return false;
		}

		$cached = $this->mainWANObjectCache->get( $key );

		if ( !$cached
			|| ( count( $cached ) !== 2 )
			|| ( $cached[0] !== $invalidInfo ) ) {
			// Cache is dirty or doesn't exist.
			return false;
		}
		return $cached[1];
	}

	/**
	 * Actually output a feed (HTML).
	 * @param ChannelFeed $feed Feed object.
	 * @param IResultWrapper $res Result of sql query
	 */
	private function makeFeed( $feed, $res ) {
		$commentNamespace = $this->getConfig()->get( 'GNSMcommentNamespace' );
		$feed->outHeader();
		foreach ( $res as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );

			// @todo FIXME: Under what circumstance would cl_timestamp not be set?
			// possibly worth an exception if that happens.
			$pubDate = $row->cl_timestamp ?? wfTimestampNow();

			$feedItem = new FeedSMItem(
				$title,
				$pubDate,
				$this->getKeywords( $title ),
				$commentNamespace
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
	 * @param array $params Parsed url parameters
	 * @param Title[] $categories Array of Title
	 * @param Title[] $notCategories Array of Title
	 *
	 * @return string All the above info concatenated.
	 */
	private function getCacheInvalidationInfo( $params, $categories, $notCategories ) {
		$dbr = $this->loadBalancer->getConnection( DB_REPLICA );
		$cacheInfo = '';
		$categoriesKey = [];
		$tsQueries = [];

		$queryInfo = $this->linksMigration->getQueryInfo( 'categorylinks' );

		// This would perhaps be nicer just using a Category object,
		// but this way can do all at once.

		// Add each category and notcategory to the query.
		for ( $i = 0; $i < $params['catCount']; $i++ ) {
			$categoriesKey[] = $categories[$i]->getDBkey();
			$linksCondition = $this->linksMigration->getLinksConditions( 'categorylinks', $categories[$i] );
			$tsQueries[] = $dbr->newSelectQueryBuilder()
				->select( [ 'ts' => 'MAX(cl_timestamp)' ] )
				->tables( $queryInfo['tables'] )
				->joinConds( $queryInfo['joins'] )
				->where( $linksCondition )
				->caller( __METHOD__ );
		}
		for ( $i = 0; $i < $params['notCatCount']; $i++ ) {
			$categoriesKey[] = $notCategories[$i]->getDBkey();
			$linksCondition = $this->linksMigration->getLinksConditions( 'categorylinks', $notCategories[$i] );
			$tsQueries[] = $dbr->newSelectQueryBuilder()
				->select( [ 'ts' => 'MAX(cl_timestamp)' ] )
				->tables( $queryInfo['tables'] )
				->joinConds( $queryInfo['joins'] )
				->where( $linksCondition )
				->caller( __METHOD__ );
		}

		// phase 1: How many pages in each cat.
		// cat_pages includes all pages (even images/subcats).
		$res = $dbr->newSelectQueryBuilder()
			->select( 'cat_pages' )
			->from( 'category' )
			->where( [ 'cat_title' => $categoriesKey ] )
			->orderBy( 'cat_title' )
			->caller( __METHOD__ )
			->fetchResultSet();

		foreach ( $res as $row ) {
			$cacheInfo .= $row->cat_pages . '!';
		}

		$cacheInfo .= '|';

		// Part 2: cl_timestamp:
		// TODO: Double check that the order of the result of union queries
		// is one after another from the order you specified the queries in.
		$uqb = $dbr->newUnionQueryBuilder();
		foreach ( $tsQueries as $query ) {
			$uqb->add( $query );
		}
		$res2 = $uqb->all()->caller( __METHOD__ )->fetchResultSet();

		foreach ( $res2 as $row ) {
			if ( $row->ts === null ) {
				$ts = 'empty';
			} else {
				$ts = wfTimestamp( TS_MW, $row->ts );
			}
			$cacheInfo .= $ts . '!';
		}

		return $cacheInfo;
	}

	/**
	 * Build and execute sql
	 * @param array $params All the parameters except cats/notcats
	 * @param array $categories
	 * @param array $notCategories
	 * @return IResultWrapper
	 */
	public function getCategories( $params, $categories, $notCategories ) {
		$dbr = $this->loadBalancer->getConnection( DB_REPLICA );

		$tables = [ 'page' ];
		$conditions = [];
		$joins = [];

		if ( $params['namespace'] !== false ) {
			$conditions['page_namespace'] = $params['namespace'];
		}

		$this->hookRunner->onGoogleNewsSitemap__Query( $params, $joins, $conditions, $tables );

		$queryBuilder = $dbr->newSelectQueryBuilder()
			// this is a little hacky, c1 is dynamically defined as the first category
			// so this can't ever work with uncategorized articles
			->select( [ 'page_namespace', 'page_title', 'page_id', 'c1.cl_timestamp' ] )
			->tables( $tables )
			->joinConds( $joins )
			->where( $conditions );

		switch ( $params['redirects'] ) {
			case self::OPT_ONLY:
				$queryBuilder->andWhere( [ 'page_is_redirect' => 1 ] );
				break;
			case self::OPT_EXCLUDE:
				$queryBuilder->andWhere( [ 'page_is_redirect' => 0 ] );
				break;
		}

		if ( $params['hourCount'] > 0
			&& $params['orderMethod'] !== 'lastedit' ) {
			// Limit to last X number of hours added to category,
			// if hourcont is positive and we're sorting by
			// category add date.
			// This feature is here because the Google News
			// Sitemap usecase is only supposed to have
			// articles published in last 2 days on it.
			// Don't do anything with lastedit, since this option
			// doesn't make sense with it (Do we even need that order method?)
			$timeOffset = (int)wfTimestamp( TS_UNIX ) - ( $params['hourCount'] * 3600 );
			$MWTimestamp = wfTimestamp( TS_MW, $timeOffset );
			if ( $MWTimestamp ) {
				$queryBuilder->andWhere( [ $dbr->expr( 'c1.cl_timestamp', '>', $MWTimestamp ) ] );
			}
		}

		$currentTableNumber = 1;

		$migrationStage = $this->getConfig()->get( MainConfigNames::CategoryLinksSchemaMigrationStage );

		for ( $i = 0; $i < $params['catCount']; $i++ ) {
			$currentCategorylinksAlias = "c$currentTableNumber";
			$currentLinktargetAlias = "linktarget$currentTableNumber";
			if ( $migrationStage & SCHEMA_COMPAT_READ_OLD ) {
				$queryBuilder->join( 'categorylinks', $currentCategorylinksAlias, [
					"page_id = {$currentCategorylinksAlias}.cl_from",
					"{$currentCategorylinksAlias}.cl_to" => $categories[$i]->getDBKey(),
				] );
			} else {
				$queryBuilder->join( 'categorylinks', $currentCategorylinksAlias, [
					"page_id = {$currentCategorylinksAlias}.cl_from",
				] );
				$queryBuilder->join( 'linktarget', $currentLinktargetAlias, [
					"{$currentCategorylinksAlias}.cl_target_id = {$currentLinktargetAlias}.lt_id",
					"{$currentLinktargetAlias}.lt_title" => $categories[$i]->getDBKey(),
					"{$currentLinktargetAlias}.lt_namespace" => $categories[$i]->getNamespace(),
				] );
			}
			$currentTableNumber++;
		}

		for ( $i = 0; $i < $params['notCatCount']; $i++ ) {
			$currentCategorylinksAlias = "c$currentTableNumber";
			if ( $migrationStage & SCHEMA_COMPAT_READ_OLD ) {
				$queryBuilder->leftJoin( 'categorylinks', $currentCategorylinksAlias, [
					"page_id = {$currentCategorylinksAlias}.cl_from",
					"{$currentCategorylinksAlias}.cl_to" => $notCategories[$i]->getDBKey(),
				] );
				$queryBuilder->andWhere( [ "{$currentCategorylinksAlias}.cl_to" => null ] );
			} else {
				$subquery = $dbr->newSelectQueryBuilder()
					->select( 'cl_from' )
					->from( 'categorylinks' )
					->join( 'linktarget', null, [ 'cl_target_id=lt_id' ] )
					->where( [
						'lt_title' => $notCategories[$i]->getDBKey(),
						'lt_namespace' => $notCategories[$i]->getNamespace(),
					] )
					->caller( __METHOD__ );
				$queryBuilder->leftJoin( $subquery, "excluded_pages{$currentTableNumber}", [
					"page_id = excluded_pages{$currentTableNumber}.cl_from",
				] );
				$queryBuilder->where( [ "excluded_pages{$currentTableNumber}.cl_from" => null ] );
			}
			$currentTableNumber++;
		}

		if ( $params['order'] === 'descending' ) {
			$sortOrder = 'DESC';
		} else {
			$sortOrder = 'ASC';
		}

		if ( $params['orderMethod'] === 'lastedit' ) {
			$queryBuilder->orderBy( 'page_touched', $sortOrder );
		} else {
			$queryBuilder->orderBy( 'c1.cl_timestamp', $sortOrder );
		}

		// earlier validation logic ensures this is a reasonable number
		$queryBuilder->limit( $params['count'] );

		return $queryBuilder->caller( __METHOD__ )->fetchResultSet();
	}

	/**
	 * Parse parameters, populates $params
	 * @return array containing the $params, $categories and $notCategories
	 *   variables that make up the request.
	 */
	public function getParams() {
		$params = [];
		$request = $this->getRequest();
		$config = $this->getConfig();
		$maxCategories = $config->get( 'GNSMmaxCategories' );
		$maxResultCount = $config->get( 'GNSMmaxResultCount' );
		$fallbackCategory = $config->get( 'GNSMfallbackCategory' );

		$categories = $this->getCatRequestArray( 'categories',
			$fallbackCategory, $maxCategories );
		$notCategories = $this->getCatRequestArray( 'notcategories', '', $maxCategories );

		$params['namespace'] = $this->getNS( $request->getVal( 'namespace', '0' ) );

		$params['count'] = $request->getInt( 'count', $maxResultCount );
		$params['hourCount'] = $request->getInt( 'hourcount', -1 );

		if ( ( $params['count'] > $maxResultCount )
				|| ( $params['count'] < 1 ) ) {
			$params['count'] = $maxResultCount;
		}

		$params['order'] = $request->getVal( 'order', 'descending' );
		$params['orderMethod'] = $request->getVal( 'ordermethod', 'categoryadd' );

		$params['redirects'] = $this->getIEOVal( 'redirects', self::OPT_EXCLUDE );
		$params['stable'] = $this->getIEOVal( 'stablepages', self::OPT_ONLY );
		$params['quality'] = $this->getIEOVal( 'qualitypages', self::OPT_INCLUDE );

		// feed parameter is validated later in the execute method.
		$params['feed'] = $request->getVal( 'feed', 'sitemap' );

		$params['catCount'] = count( $categories );
		$params['notCatCount'] = count( $notCategories );
		$totalCatCount = $params['catCount'] + $params['notCatCount'];

		if ( $params['catCount'] < 1 ) {
			// Always require at least one include category.
			// Without an include category, cl_timestamp will be null.
			// Which will probably manifest as a weird bug.
			$fallBack = Title::newFromText( $fallbackCategory, NS_CATEGORY );
			if ( $fallBack ) {
				$categories[] = $fallBack;
				$params['catCount'] = count( $categories );
			} else {
				throw new RuntimeException(
					'Default fallback category ($wgGNSMfallbackCategory) is not a valid title!' );
			}
		}

		if ( $totalCatCount > $maxCategories ) {
			// Causes a 500 error later on.
			$params['error'] = $this->msg( 'googlenewssitemap_toomanycats' )->text();
		}
		return [ $params, $categories, $notCategories ];
	}

	/**
	 * Turn an include, exclude, or only (I, E, or O) parameter into
	 * a class constant.
	 * @param string $valName the name of the url parameter
	 * @param int $default Class constant to return if none match
	 * @return int Class constant corresponding to value.
	 */
	private function getIEOVal( $valName, $default = self::OPT_INCLUDE ) {
		$val = $this->getRequest()->getVal( $valName );

		switch ( $val ) {
			case 'only':
				return self::OPT_ONLY;
			case 'include':
				return self::OPT_INCLUDE;
			case 'exclude':
				return self::OPT_EXCLUDE;
			default:
				return $default;
		}
	}

	/**
	 * Decode the namespace URL parameter.
	 * @param string $ns Either numeric NS number, NS name, or special value :all:
	 * @return mixed Integer or false Namespace number or false for no NS filtering.
	 */
	private function getNS( $ns ) {
		$nsNumb = $this->contentLanguage->getNsIndex( $ns );

		if ( $nsNumb !== false ) {
			// If they specified something like Talk or Image.
			return $nsNumb;
		} elseif ( is_numeric( $ns ) ) {
			// If they specified a number.
			$nsVal = intval( $ns );
			if ( $nsVal >= 0 && $this->namespaceInfo->exists( $nsVal ) ) {
				return $nsVal;
			} else {
				wfDebug( __METHOD__ . ' Invalid numeric ns number. Using main.' );
				return 0;
			}
		} elseif ( $ns === ':all:' ) {
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
	 * @param string $name Parameter to retrieve from web reqeust.
	 * @param string $default
	 * @param int $max Maximum size of resulting array.
	 * @return array of Title objects. The Titles passed in the parameter $name.
	 */
	private function getCatRequestArray( $name, $default, $max ) {
		$value = $this->getRequest()->getText( $name, $default );
		$arr = explode( '|', $value, $max + 2 );
		$res = [];
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
	 *
	 * The format of this message is *Category name|What to map to
	 * or *Category name|__MASK__ to hide the category completely.
	 *
	 * @see http://www.google.com/support/news_pub/bin/answer.py?answer=116037
	 * @param Title $title
	 * @return string[] list of keywords
	 */
	public function getKeywords( Title $title ) {
		$cats = $this->getVisibleCategories( $title );
		$res = [];

		# the following code is based (stolen) from r56954 of flagged revs.
		$catMap = [];
		$catMask = [];
		$msg = $this->msg( 'googlenewssitemap_categorymap' );
		if ( !$msg->isDisabled() ) {
			$msg = $msg->inContentLanguage()->text();
			$list = explode( "\n*", "\n$msg" );
			foreach ( $list as $item ) {
				$mapping = explode( '|', $item, 2 );
				if ( count( $mapping ) == 2 ) {
					$targetTitle = Title::newFromText( $mapping[0], NS_CATEGORY );
					if ( !$targetTitle ) {
						continue;
					}
					$target = $targetTitle->getDBkey();
					$mapTo = trim( $mapping[1] );

					if ( $mapTo === '__MASK__' ) {
						$catMask[$target] = true;
					} else {
						$catMap[$target] = $mapTo;
					}
				}
			}
		}
		foreach ( $cats as $cat ) {
			if ( !isset( $catMask[$cat] ) ) {
				if ( isset( $catMap[$cat] ) ) {
					// Its mapped.
					$res[] = $catMap[$cat];
				} else {
					// No mapping, so use just page name sans namespace.
					$cTitle = Title::newFromText( $cat );
					$res[] = $cTitle->getText();
				}
			}
		}
		return $res;
	}

	/**
	 * Get all non-hidden categories for a title.
	 *
	 * Kind of similar to title::getParentCategories.
	 *
	 * @param Title $title Which title to get the categories for.
	 * @return array of String's that are the (non-prefixed) db-keys of the cats.
	 */
	private function getVisibleCategories( Title $title ) {
		$dbr = $this->loadBalancer->getConnection( DB_REPLICA );
		return $dbr->newSelectQueryBuilder()
			->select( 'cl_to' )
			->from( 'categorylinks' )
			->leftJoin( 'page', null, [ 'page_namespace' => NS_CATEGORY, 'page_title=cl_to' ] )
			->leftJoin( 'page_props', null, [ 'pp_page=page_id', 'pp_propname' => 'hiddencat' ] )
			->where( [
				'cl_from' => $title->getArticleID(),
				'pp_propname' => null,
			] )
			->caller( __METHOD__ )
			->fetchFieldValues();
	}
}
