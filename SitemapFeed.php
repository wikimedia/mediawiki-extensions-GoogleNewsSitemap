<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SitemapFeed extends FeedSMItem {
	private $writer;

	function __construct() {
		global $wgOut;
		$this->writer = new XMLWriter();
		$wgOut->disable();
	}
	/**
	 * Output feed headers
	 **/
	function outHeader() {
		global $wgOut;
		global $wgRequest;

		// FIXME: Why can't we just pick one mime type and always send that?
		$ctype = $wgRequest->getVal( 'ctype', 'application/xml' );
		$allowedctypes = array( 'application/xml', 'text/xml', 'application/rss+xml', 'application/atom+xml' );
		$mimetype = in_array( $ctype, $allowedctypes ) ? $ctype : 'application/xml';
        header( "Content-type: $mimetype; charset=UTF-8" );
        $wgOut->sendCacheControl();

		$this->writer->openURI( 'php://output' );
		$this->writer->setIndent( true );
		$this->writer->startDocument( "1.0", "UTF-8" );
		$this->writer->startElement( "urlset" );
		$this->writer->writeAttribute( "xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9" );
		$this->writer->writeAttribute( "xmlns:news", "http://www.google.com/schemas/sitemap-news/0.9" );
		$this->writer->flush();
	}
	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedSMItem item to be output
	 **/
	function outItem( $item ) {

		$this->writer->startElement( "url" );
		$this->writer->startElement( "loc" );
		$this->writer->text( $item->getUrl() );
		$this->writer->endElement();
		$this->writer->startElement( "news:news" );
		$this->writer->startElement( "news:publication_date" );
		$this->writer->text( $item->getPubDate() );
		$this->writer->endElement();
		if ( $item->getKeywords() ) {
			$this->writer->startElement( "news:keywords" );
			$this->writer->text( $item->getKeywords() );
			$this->writer->endElement();
		}
		$this->writer->endElement(); // end news:news
		if ( $item->getLastMod() ) {
			$this->writer->startElement( "lastmod" );
			$this->writer->text( $item->getLastMod() );
			$this->writer->endElement();
		}
		if ( $item->getPriority() ) {
			$this->writer->startElement( "priority" );
			$this->writer->text( $item->getPriority() );
			$this->writer->endElement();
		}
		$this->writer->endElement(); // end url
	}

	/**
	 * Output SiteMap 0.9 footer
	 **/
	function outFooter() {
		$this->writer->endDocument();
		$this->writer->flush();
	}
}
