<?php

namespace MediaWiki\Extension\GoogleNewsSitemap;

use ChannelFeed;
use Exception;
use MediaWiki\Feed\FeedItem;
use XMLWriter;

class SitemapFeed extends ChannelFeed {
	private $writer;
	private $publicationName;
	private $publicationLang;

	public function __construct() {
		global $wgSitename, $wgLanguageCode;

		$this->writer = new XMLWriter();
		$this->publicationName = $wgSitename;
		$this->publicationLang = $wgLanguageCode;
	}

	/**
	 * Set the publication language code. Only used if different from
	 * $wgLanguageCode, which could happen if Google disagrees with us
	 * on say what code zh gets.
	 * @param string $lang Language code (like en)
	 */
	public function setPublicationLang( $lang ) {
		$this->publicationLang = $lang;
	}

	/**
	 * Set the publication name. Normally $wgSitename, but could
	 * need to be changed, if Google gives the publication a different
	 * name then $wgSitename.
	 * @param string $name The name of the publication
	 */
	public function setPublicationName( $name ) {
		$this->publicationName = $name;
	}

	public function contentType() {
		return 'application/xml';
	}

	/**
	 * Output feed headers.
	 */
	public function outHeader() {
		$this->httpHeaders();

		$this->writer->openURI( 'php://output' );
		$this->writer->setIndent( true );
		$this->writer->startDocument( '1.0', 'UTF-8' );
		$this->writer->startElement( 'urlset' );
		$this->writer->writeAttribute( 'xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9' );
		$this->writer->writeAttribute( 'xmlns:news', 'http://www.google.com/schemas/sitemap-news/0.9' );
	}

	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedItem $item to be output
	 * @throws Exception
	 */
	public function outItem( $item ) {
		if ( !( $item instanceof FeedItem ) ) {
			throw new Exception( 'Requires a FeedItem or subclass.' );
		}

		if ( !( $item instanceof FeedSMItem ) ) {
			$item = FeedSMItem::newFromFeedItem( $item );
		}

		$this->writer->startElement( 'url' );

		$this->writer->startElement( 'loc' );
		$this->writer->text( $item->getUrl() );
		$this->writer->endElement();

		$this->writer->startElement( 'news:news' );

		$this->writer->startElement( 'news:publication_date' );
		$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getDate() ) );
		$this->writer->endElement();

		$this->writer->startElement( 'news:title' );
		$this->writer->text( $item->getTitle() );
		$this->writer->endElement();

		$this->writer->startElement( 'news:publication' );
		$this->writer->startElement( 'news:name' );
		$this->writer->text( $this->publicationName );
		$this->writer->endElement();
		$this->writer->startElement( 'news:language' );
		$this->writer->text( $this->publicationLang );
		$this->writer->endElement();
		// @phan-suppress-next-line PhanPluginDuplicateAdjacentStatement
		$this->writer->endElement();

		if ( $item->getKeywords() ) {
			$this->writer->startElement( 'news:keywords' );
			$this->writer->text( $item->getKeywords() );
			$this->writer->endElement();
		}

		// end news:news
		$this->writer->endElement();
		if ( $item->getLastMod() ) {
			$this->writer->startElement( 'lastmod' );
			$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getLastMod() ) );
			$this->writer->endElement();
		}
		// end url
		$this->writer->endElement();
	}

	/**
	 * Output SiteMap 0.9 footer
	 */
	public function outFooter() {
		$this->writer->endDocument();
		$this->writer->flush();
	}
}
