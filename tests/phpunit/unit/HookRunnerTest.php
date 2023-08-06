<?php

namespace MediaWiki\Extension\GoogleNewsSitemap\Tests\Unit;

use MediaWiki\Extension\GoogleNewsSitemap\Hooks\HookRunner;
use MediaWiki\Tests\HookContainer\HookRunnerTestBase;

/**
 * @covers \MediaWiki\Extension\GoogleNewsSitemap\Hooks\HookRunner
 */
class HookRunnerTest extends HookRunnerTestBase {

	public static function provideHookRunners() {
		yield HookRunner::class => [ HookRunner::class ];
	}
}
