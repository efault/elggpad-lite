<?php
/**
 * View a etherpad
 *
 * @package etherpad
 */

$etherpad = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($page_owner->name, "etherpad/group/$page_owner->guid/all");
} 
$title = $etherpad->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($etherpad, array('full_view' => true));

//show comments
if(elgg_get_plugin_setting('show_comments', 'etherpad') == 'yes'){
	$content .= elgg_view_comments($etherpad);
}

$content .= elgg_view('output/tags', array('tags' => $etherpad->tags));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'header' => '',
	'sidebar' => elgg_view('etherpad/sidebar'),
));

echo elgg_view_page($title, $body);
