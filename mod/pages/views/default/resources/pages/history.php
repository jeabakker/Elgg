<?php
/**
 * History of revisions of a page
 */

$page_guid = (int) elgg_extract('guid', $vars);

elgg_entity_gatekeeper($page_guid, 'object', 'page', true);

$page = get_entity($page_guid);

$container = elgg_get_page_owner_entity();

elgg_push_collection_breadcrumbs('object', 'page', $container);

pages_prepare_parent_breadcrumbs($page);

elgg_push_breadcrumb($page->getDisplayName(), $page->getURL());

$title = "{$page->getDisplayName()}: " . elgg_echo('pages:history');

$content = elgg_list_annotations([
	'guid' => $page_guid,
	'annotation_name' => 'page',
	'limit' => max(20, elgg_get_config('default_limit')),
	'order_by' => [
		new \Elgg\Database\Clauses\OrderByClause('n_table.time_created', 'desc'),
		new \Elgg\Database\Clauses\OrderByClause('n_table.id', 'desc'),
	],
	'no_results' => elgg_echo('pages:none'),
]);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'pages/history',
	'filter_value' => 'history',
]);
