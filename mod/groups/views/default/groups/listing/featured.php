<?php
/**
 * Renders a list of featured groups
 *
 * Note: this view has a corresponding view in the rss view type, changes should be reflected
 *
 * @uses $vars['options'] Additional listing options
 */

$options = (array) elgg_extract('options', $vars);

$featured_options = [
	'metadata_name' => 'featured_group',
	'metadata_value' => 'yes',
	'no_results' => elgg_echo('groups:nofeatured'),
];

$vars['options'] = array_merge($options, $featured_options);

echo elgg_view('groups/listing/all', $vars);
