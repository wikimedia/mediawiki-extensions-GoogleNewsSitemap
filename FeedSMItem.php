<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * FeedSMItem Class
 **
 * Base class for basic SiteMap support, for building url containers.
 **/
class FeedSMItem {
	/**
	 * Var string
	 **/
	var $url = '';
	var $pubDate = '';
	var $keywords = '';
	var $lastMod = '';
	var $priority = '';

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
}