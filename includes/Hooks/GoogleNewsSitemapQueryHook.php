<?php

// phpcs:disable MediaWiki.NamingConventions.LowerCamelFunctionsName.FunctionName

namespace MediaWiki\Extension\GoogleNewsSitemap\Hooks;

/**
 * This is a hook handler interface, see docs/Hooks.md in core.
 * Use the hook name "GoogleNewsSitemap::Query" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface GoogleNewsSitemapQueryHook {
	/**
	 * @param array $params
	 * @param array &$joins
	 * @param array &$conditions
	 * @param array &$tables
	 * @return bool|void True or no return value to continue or false to abort
	 */
	public function onGoogleNewsSitemap__Query( array $params, array &$joins, array &$conditions, array &$tables );
}
