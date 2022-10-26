<?php

namespace MediaWiki\Extension\GoogleNewsSitemap;

use ApiMain;
use Exception;
use FauxRequest;
use MediaWiki\Feed\FeedItem;
use Title;

/**
 * FeedSMItem Class
 *
 * Base class for basic SiteMap support, for building url containers.
 */
class FeedSMItem extends FeedItem {

	private $keywords = [];

	/**
	 * @var Title
	 */
	private $titleObj;

	/**
	 * @param Title $title Title object that this entry is for.
	 * @param string $pubDate Publish date formattable by wfTimestamp.
	 * @param string[] $keywords list of keywords
	 * @param bool|int $comment Namespace containing comments page for entry.
	 *   True for the corresponding talk page of $title
	 *   False for none
	 *   An integer for the page name of $title in the specific namespace denoted by that integer.
	 * @throws Exception
	 */
	public function __construct( $title, $pubDate, $keywords = [], $comment = true ) {
		if ( !$title || !$title instanceof Title ) {
			// Paranoia
			throw new Exception( 'Invalid title object passed to FeedSMItem' );
		}

		$commentsURL = '';
		if ( $comment === true && $title->canHaveTalkPage() ) {
			// The comment ns is this article's talk namespace.
			$commentsURL = $title->getTalkPage()->getCanonicalURL();
		} elseif ( is_int( $comment ) ) {
			// There's a specific comments namespace.
			$commentsTitle = Title::makeTitle( $comment, $title->getDBkey() );
			if ( $commentsTitle ) {
				$commentsURL = $commentsTitle->getCanonicalURL();
			}
		}

		$this->keywords = $keywords;
		$this->titleObj = $title;

		parent::__construct( $title->getText(), '' /* Description */,
			$title->getCanonicalURL(), $pubDate, '' /* Author */, $commentsURL );
	}

	/**
	 * Convert a FeedItem to an FeedSMItem.
	 * This is to make sitemap feed get along with normal MediaWiki feeds.
	 * @param \FeedItem $item Original item.
	 * @throws Exception
	 * @return FeedSMItem Converted item.
	 */
	public static function newFromFeedItem( FeedItem $item ) {
		// @todo FIXME: This is borked (esp. on history), but better than a fatal (not by much).
		// maybe try and get title from url?
		$title = Title::newFromText( $item->getTitle() );
		if ( !$title ) {
			throw new Exception( 'Error getting title object from string in FeedItem.' );
		}
		$date = $item->getDate();
		return new FeedSMItem( $title, $date );
	}

	public function getLastMod() {
		return $this->titleObj->getTouched();
	}

	public function getKeywords() {
		// Note, not using Language::commaList(), as this is for
		// computers not humans, so we don't want to vary with
		// language conventions.
		return $this->xmlEncode( implode( ', ', $this->keywords ) );
	}

	/**
	 * Overrides parent class. Meant to be used in rss feed.
	 * Currently return the article, its debatable if thats a good idea
	 * or not, but not sure of what better to do. Could regex the wikitext
	 * and try to return the first paragraph, but thats iffy.
	 *
	 * Note, this is only called by the atom/rss feed output, not by
	 * the sitemap output.
	 * @return string
	 */
	public function getDescription() {
		// This is probably rather inefficient to do for several pages
		// but not much worse than the rest of this extension.

		$result = '';
		$req = new FauxRequest( [
			'action' => 'parse',
			'page' => $this->titleObj->getPrefixedDBKey(),
			'prop' => 'text',
		] );
		$main = new ApiMain( $req );
		$main->execute();
		$data = $main->getResult()->getResultData( null, [ 'BC' => [] ] );

		if ( isset( $data['parse']['text']['*'] ) ) {
			$result = $this->xmlEncode(
				$data['parse']['text']['*']
			);
		}
		return $result;
	}
}
