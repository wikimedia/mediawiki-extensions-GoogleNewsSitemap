<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * FeedSMItem Class
 **
 * Base class for basic SiteMap support, for building url containers.
 **/
class FeedSMItem extends FeedItem {

	private $keywords = '';

	/**
	 * @var Title
	 */
	private $title;

	/**
	 * @param Title $title Title object that this entry is for.
	 * @param String $pubDate Publish date formattable by wfTimestamp.
	 * @param String $keywords Comma separated list of keywords
	 * @param Mixed Boolean or Integer. Namespace containing comments page for entry.
	 *   True for the corresponding talk page of $title
	 *   False for none
	 *   An integer for the page name of $title in the specific namespace denoted by that integer.
	 */
	function __construct( $title, $pubDate, $keywords = '', $comment = true ) {

		if ( !$title ) {
			// Paranoia
			throw new MWException( "Invalid title object passed to FeedSMItem" );
		}

		$commentsURL = '';
		if ( $comment === true ) {
			// The comment ns is this article's talk namespace.
			$commentsURL = $title->getTalkPage()->getFullUrl();
		} else if ( is_int( $comment ) ) {
			// There's a specific comments namespace.
			$commentsTitle = Title::makeTitle( $comment, $title->getDBkey() );
			if ( $commentsTitle ) {
				$commentsURL = $commentsTitle->getFullUrl();
			}
		}

		$this->title = $title;
		$this->keywords = $keywords;

		parent::__construct( $title->getText(), '' /* Description */,
			$title->getFullUrl(), $pubDate, '' /* Author */, $commentsURL  );
	}

	/**
	 * Convert a FeedItem to an FeedSMItem.
	 * This is to make sitemap feed get along with normal MediaWiki feeds.
	 * @param FeedItem Original item.
	 * @return FeedSMItem Converted item.
	 */
	static function newFromFeedItem( FeedItem $item ) {
		// FIXME: This is borked (esp. on history), but better than a fatal (not by much).
		// maybe try and get title from url?
		$title = Title::newFromText( $item->getTitle() );
		if ( !$title ) {
			throw new MWException( "Error getting title object from string in FeedItem." );
		}
		$date = $item->getDate();
		return new FeedSMItem( $title, $date );
	}

	public function getLastMod() {
		return $this->title->getTouched();
	}

	public function getKeywords() {
		return $this->xmlEncode( $this->keywords );
	}

	/**
	 * Overrides parent class. Meant to be used in rss feed.
	 * Currently return the article, its debatable if thats a good idea
	 * or not, but not sure of what better to do. Could regex the wikitext
	 * and try to return the first paragraph, but thats iffy.
	 *
	 * Note, this is only called by the atom/rss feed output, not by
	 * the sitemap output.
	 * @return String
	 */
	public function getDescription() {
		// This is probably rather inefficient to do for several pages
		// but not much worse than the rest of this extension.
		$req = new FauxRequest( array(
			'action' => 'parse',
			'page' => $this->title->getPrefixedDBKey(),
			'prop' => 'text',
		) );
		$main = new ApiMain( $req );
		$main->execute();
		$data = $main->getResultData();
		if ( isset( $data['parse']['text']['*'] ) ) {
			return $this->xmlEncode(
				$data['parse']['text']['*']
			);
		} else {
			return '';
		}
	}
}

