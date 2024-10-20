<?php

namespace Elgg\Developers\Menus;

/**
 * Event callbacks for menus
 *
 * @since 5.0
 *
 * @internal
 */
class AdminHeader {

	/**
	 * Register item to menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function register(\Elgg\Event $event) {
		if (!elgg_in_context('admin') || !elgg_is_admin_logged_in()) {
			return;
		}
		
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'develop',
			'text' => elgg_echo('menu:page:header:develop'),
			'href' => false,
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'dev_settings',
			'text' => elgg_echo('settings'),
			'href' => 'admin/developers/settings',
			'priority' => 10,
			'parent_name' => 'develop',
		]);
	
		$return[] = \ElggMenuItem::factory([
			'name' => 'error_log',
			'text' => elgg_echo('admin:develop_tools:error_log'),
			'href' => 'admin/develop_tools/error_log',
			'parent_name' => 'develop',
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'develop_tools:entity_explorer',
			'text' => elgg_echo('admin:develop_tools:entity_explorer'),
			'href' => 'admin/develop_tools/entity_explorer',
			'parent_name' => 'develop',
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'develop_tools:sandbox',
			'text' => elgg_echo('admin:develop_tools:sandbox'),
			'href' => 'theme_sandbox/intro',
			'parent_name' => 'develop',
			'target' => '_blank',
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'inspect',
			'text' => elgg_echo('admin:inspect'),
			'href' => false,
			'parent_name' => 'develop',
		]);
		
		$inspect_options = self::getInspectOptions();
		foreach ($inspect_options as $key => $value) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'dev_inspect_' . elgg_get_friendly_title($key),
				'text' => $value,
				'href' => elgg_http_add_url_query_elements('admin/develop_tools/inspect', [
					'inspect_type' => $key,
				]),
				'parent_name' => 'inspect',
			]);
		}
		
		return $return;
	}
	
	/**
	 * Get the available inspect options
	 *
	 * @return array
	 */
	protected static function getInspectOptions() {
		$options = [
			'Actions' => elgg_echo('developers:inspect:actions'),
			'Events' => elgg_echo('developers:inspect:events'),
			'Menus' => elgg_echo('developers:inspect:menus'),
			'Routes' => elgg_echo('developers:inspect:routes'),
			'Services' => elgg_echo('developers:inspect:services'),
			'Simple Cache' => elgg_echo('developers:inspect:simplecache'),
			'Views' => elgg_echo('developers:inspect:views'),
			'Widgets' => elgg_echo('developers:inspect:widgets'),
		];
		
		ksort($options);
		
		return $options;
	}
}
