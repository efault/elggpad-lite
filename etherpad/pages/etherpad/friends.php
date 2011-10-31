<?php
/**
 * Elgg etherpad plugin friends page
 *
 * @package Elggetherpad
 */

$owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($owner->name, "etherpad/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('etherpad:friends');

$content = list_user_friends_objects($owner->guid, 'etherpad', 10, false);
if (!$content) {
	$content = elgg_echo('etherpad:none');
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
