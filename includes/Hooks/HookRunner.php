<?php

// phpcs:disable MediaWiki.NamingConventions.LowerCamelFunctionsName.FunctionName

namespace MediaWiki\Extension\GoogleNewsSitemap\Hooks;

use MediaWiki\HookContainer\HookContainer;

/**
 * This is a hook runner class, see docs/Hooks.md in core.
 * @internal
 */
class HookRunner implements
	GoogleNewsSitemapQueryHook
{
	private HookContainer $hookContainer;

	public function __construct( HookContainer $hookContainer ) {
		$this->hookContainer = $hookContainer;
	}

	/**
	 * @inheritDoc
	 */
	public function onGoogleNewsSitemap__Query( array $params, array &$joins, array &$conditions, array &$tables ) {
		return $this->hookContainer->run(
			'GoogleNewsSitemap::Query',
			[ $params, &$joins, &$conditions, &$tables ]
		);
	}
}
