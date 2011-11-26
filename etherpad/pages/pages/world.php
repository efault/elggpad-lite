<?php
/**
 * List all pages
 *
 * @package ElggPages
 */

$title = elgg_echo('pages:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('pages'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => array('page_top', 'etherpad'),
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('pages:none') . '</p>';
}

if (elgg_is_logged_in()) {
	$url = "etherpad/add/" . elgg_get_logged_in_user_guid();
	elgg_register_menu_item('title', array(
			'name' => 'elggpad',
			'href' => $url,
			'text' => elgg_echo('etherpad:new'),
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 200,
	));
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('pages/sidebar'),
));

echo elgg_view_page($title, $body);
