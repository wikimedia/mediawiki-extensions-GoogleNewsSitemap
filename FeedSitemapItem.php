<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * FeedSitemapItem Class
 **
 * Base class for basic SiteMap support, for building url containers.
 **/
class FeedSitemapItem {
	/**
	 * Var string
	 **/
	var $url, $pubDate, $keywords, $lastMod, $priority;

	function __construct( $url, $pubDate, $keywords = '', $lastMod = '', $priority = '' ) {
		$this->url = $url;
		$this->pubDate = $pubDate;
		$this->keywords = $keywords;
		$this->lastMod = $lastMod;
		$this->priority = $priority;
	}

	public function xmlEncode( $string ) {
		$string = str_replace( "\r\n", "\n", $string );
		$string = preg_replace( '/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $string );
		return htmlspecialchars( $string );
	}

	public function getUrl() {
		return $this->url;
	}

	public function getPriority() {
		return $this->priority;
	}

	public function getLastMod() {
		return $this->lastMod;
	}

	public function getKeywords () {
		return $this->xmlEncode( $this->keywords );
	}

	public function getPubDate() {
		return $this->pubDate;
	}

	function formatTime( $ts ) {
		// need to use RFC 822 time format at least for rss2.0
		return gmdate( 'Y-m-d\TH:i:s', wfTimestamp( TS_UNIX, $ts ) );
	}

	/**
	 * Setup and send HTTP headers. Don't send any content;
	 * content might end up being cached and re-sent with
	 * these same headers later.
	 *
	 * This should be called from the outHeader() method,
	 * but can also be called separately.
	 *
	 * @public
	 **/
	function httpHeaders() {
		global $wgOut;
		# We take over from $wgOut, excepting its cache header info
		$wgOut->disable();
		$mimetype = $this->contentType();
		header( "Content-type: $mimetype; charset=UTF-8" );
		$wgOut->sendCacheControl();

	}

	function outXmlHeader() {
		$this->httpHeaders();
		echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	}

	/**
	 * Return an internet media type to be sent in the headers.
	 *
	 * @return string
	 * @private
	 **/
	function contentType() {
		global $wgRequest;
		$ctype = $wgRequest->getVal( 'ctype', 'application/xml' );
		$allowedctypes = array( 'application/xml', 'text/xml', 'application/rss+xml', 'application/atom+xml' );
		return ( in_array( $ctype, $allowedctypes ) ? $ctype : 'application/xml' );
	}
}

class SitemapFeed extends FeedSitemapItem {
	/**
	 * Output feed headers
	 **/
	function outHeader() {
		$this->outXmlHeader();
		?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
		<?php
	}
	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedSitemapItem item to be output
	 **/
	function outItem( $item ) {
		?>
<url>
<loc>
		<?php print $item->getUrl() ?>
</loc>
<news:news>
	<news:publication_date>
	<?php print $item->getPubDate() ?>
	</news:publication_date>
	<?php if ( $item->getKeywords() ) {
		echo '<news:keywords>' . $item->getKeywords() . "</news:keywords>\n";
	}
	?>
</news:news>
	<?php	 if ( $item->getLastMod() ) { ?>
<lastmod>
	<?php print $item->getLastMod(); ?>
</lastmod>
	<?php } ?>
	<?php	 if ( $item->getPriority() ) { ?>
<priority>
	<? print $item->getPriority(); ?>
</priority>
	<?php } ?>
</url>
	<?php
	}

	/**
	 * Output SiteMap 0.9 footer
	 **/
	function outFooter() {
		echo '</urlset>';
	}
}
