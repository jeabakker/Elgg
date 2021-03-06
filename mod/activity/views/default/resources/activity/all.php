<?php
/**
 * Show all site river activity
 */

// get filter options
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));

// build page content
$content = elgg_view('river/listing/all', [
	'entity_type' => $type,
	'entity_subtype' => $subtype,
	'options' => [
		'responses' => $type === 'all' ? false : null,
	],
	'show_filter' => true,
]);

// draw page
echo elgg_view_page(elgg_echo('river:all'), [
	'content' =>  $content,
	'sidebar' => elgg_view('river/sidebar'),
	'filter_value' => 'all',
	'class' => 'elgg-river-layout',
]);
