<?php

namespace Elgg\Bookmarks;

/**
 * @group Router
 * @group BookmarksRoutes
 */
class RouteResponseTest extends \Elgg\Plugins\Integration\RouteResponseTestCase {

	public function getSubtype() {
		return 'bookmarks';
	}
	
	public function groupRoutesProtectedByToolOption() {
		return [
			[
				'route' => "collection:object:{$this->getSubtype()}:group",
				'tool' => 'bookmarks',
			],
		];
	}
}
