<?php

/**
 * Outputs feed xml
 **
 * A Special Page extension to produce:
 *  Google News sitemap output
 *      - http://www.google.com/support/news_pub/bin/answer.py?hl=en&answer=74288
 *      - http://www.sitemaps.org/protocol.php
 *  RSS feed output - 2.0 http://www.rssboard.org/rss-specification
 *                  - 0.92 http://www.rssboard.org/rss-0-9-2
 *  Atom feed output - 2005 http://tools.ietf.org/html/rfc4287
 **
 * This page can be accessed from Special:GoogleNewsSitemap?[categories=Catname]
 *      [&notcategories=OtherCatName][&namespace=0]
 *      [&feed=sitemap][&count=10][&ordermethod=lastedit]
 *      [&order=ascending]
 **
 *  This program is free software; you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License as published by the Free
 *  Software Foundation; either version 2 of the License, or (at your option)
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT
 *  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 *  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with
 *  this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 *  Place - Suite 330, Boston, MA 02111-1307, USA.
 *  http://www.gnu.org/copyleft/gpl.html
 **
 * Contributors
 *  This script is based on Extension:DynamicPageList (Wikimedia), originally
 *  developed by:
 *      wikt:en:User:Amgine        http://en.wiktionary.org/wiki/User:Amgine
 *      n:en:User:IlyaHaykinson http://en.wikinews.org/wiki/User:IlyaHaykinson
 **
 * FIXME requests
 *  use=Mediawiki:GoogleNewsSitemap_Feedname     Parameter to allow on-site control of feed
 **
 * @addtogroup Extensions
 *
 * @author Amgine <amgine.saewyc@gmail.com>
 * @copyright Copyright © 2009, Amgine
 * @license GPL-2.0-or-later
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'GoogleNewsSitemap' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['GoogleNewsSitemap'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['GoogleNewsSitemapAlias'] = __DIR__ . '/GoogleNewsSitemap.alias.php';
	/*wfWarn(
		'Deprecated PHP entry point used for GoogleNewsSitemap extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);*/
	return;
} else {
	die( 'This version of the GoogleNewsSitemap extension requires MediaWiki 1.25+' );
}
