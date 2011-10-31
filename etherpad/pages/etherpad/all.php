<?php
/**
 * Elgg etherpad plugin everyone page
 *
 * @package etherpad
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('etherpad'));
elgg_push_breadcrumb(elgg_echo('all'));
elgg_register_title_button();


$offset = (int)get_input('offset', 0);
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'etherpad',
	'limit' => 10,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false
));

$title = elgg_echo('etherpad:everyone');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('etherpad/sidebar'),
));

echo elgg_view_page($title, $body);
