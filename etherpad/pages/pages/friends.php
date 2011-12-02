<?php
/**
 * List a user's friends' pages
 *
 * @package ElggPages
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('pages/all');
}

elgg_push_breadcrumb($owner->name, "pages/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('pages:friends');

$content = list_user_friends_objects($owner->guid, array('page_top', 'etherpad'), 10, false);
if (!$content) {
	$content = elgg_echo('pages:none');
}

if (elgg_is_logged_in()) {
	$url = "etherpad/add/" . elgg_get_logged_in_user_guid();
	elgg_register_menu_item('title', array(
			'name' => 'elggpad',
			'href' => $url,
			'text' => elgg_echo('etherpad:add'),
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 200,
	));
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
