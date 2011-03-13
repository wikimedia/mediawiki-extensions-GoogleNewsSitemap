<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SitemapFeed extends ChannelFeed {
	private $writer;

	function __construct() {
		$this->writer = new XMLWriter();
	}

	function contentType() {
		return 'application/xml';
	}

	/**
	 * Output feed headers.
	 */
	function outHeader() {
		$this->httpHeaders();

		$this->writer->openURI( 'php://output' );
		$this->writer->setIndent( true );
		$this->writer->startDocument( "1.0", "UTF-8" );
		$this->writer->startElement( "urlset" );
		$this->writer->writeAttribute( "xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9" );
		$this->writer->writeAttribute( "xmlns:news", "http://www.google.com/schemas/sitemap-news/0.9" );
	}

	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedSMItem $item to be output
	 */
	function outItem( $item ) {

		if ( !( $item instanceof FeedItem ) ) {
			throw new MWException( "Requires a FeedItem or subclass." );
		}
		if ( !( $item instanceof FeedSMItem ) ) {
			$item = FeedSMItem::newFromFeedItem( $item );
		}

		$this->writer->startElement( "url" );

		$this->writer->startElement( "loc" );
		$this->writer->text( $item->getUrl() );
		$this->writer->endElement();

		$this->writer->startElement( "news:news" );

		$this->writer->startElement( "news:publication_date" );
		$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getDate() ) );
		$this->writer->endElement();

		$this->writer->startElement( "news:title" );
		$this->writer->text( $item->getTitle() );
		$this->writer->endElement();

		if ( $item->getKeywords() ) {
			$this->writer->startElement( "news:keywords" );
			$this->writer->text( $item->getKeywords() );
			$this->writer->endElement();
		}

		$this->writer->endElement(); // end news:news
		if ( $item->getLastMod() ) {
			$this->writer->startElement( "lastmod" );
			$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getLastMod() ) );
			$this->writer->endElement();
		}
		$this->writer->endElement(); // end url
	}

	/**
	 * Output SiteMap 0.9 footer
	 */
	function outFooter() {
		$this->writer->endDocument();
		$this->writer->flush();
	}
}
