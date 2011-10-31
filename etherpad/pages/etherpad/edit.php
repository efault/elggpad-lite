<?php
/**
 * Edit a etherpad
 *
 * @package etherpad
 */

gatekeeper();

$etherpad_guid = (int)get_input('guid');
$etherpad = get_entity($etherpad_guid);
if (!$etherpad) {
	
}

$container = $etherpad->getContainerEntity();
if (!$container) {
	
}

/**
 * etherpad function library
 */

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $etherpad
 * @return array
 */
function etherpad_prepare_form_vars($etherpad = null, $parent_guid = 0) {
	
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'write_access_id' => ACCESS_DEFAULT,
		'paddress' => '',
		'address' => '',
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $etherpad,
		'parent_guid' => $parent_guid,
	);
	
	if ($etherpad) {
		foreach (array_keys($values) as $field) {
			if (isset($etherpad->$field)) {
				$values[$field] = $etherpad->$field;
			}
		}
	}
	
	if (elgg_is_sticky_form('etherpad')) {
		$sticky_values = elgg_get_sticky_values('etherpad');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('etherpad');
	
	return $values;
}

elgg_set_page_owner_guid($container->getGUID());

elgg_push_breadcrumb($etherpad->title, $etherpad->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo("etherpad:edit");

if ($etherpad->canEdit()) {

	$vars = etherpad_prepare_form_vars($etherpad);

	$content = elgg_view_form('etherpad/save', array(), $vars);

} else {
	$content = elgg_echo("etherpad:noaccess");
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('etherpad/sidebar'),
));

echo elgg_view_page($title, $body);


?>
