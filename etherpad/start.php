<?php
/**
 * Elgg Etherpad lite plugin
 *
 * @package etherpad
 */
 
elgg_register_event_handler('init', 'system', 'etherpad_init');


function etherpad_init() {
	
	// override pages library
	elgg_register_library('elgg:pages', elgg_get_plugins_path() . 'etherpad/lib/pages.php');
	
	$actions_base = elgg_get_plugins_path() . 'etherpad/actions/etherpad';
	elgg_register_action("etherpad/save", "$actions_base/save.php");
	elgg_register_action("etherpad/delete", "$actions_base/delete.php");
	
	elgg_register_page_handler('pages', 'etherpad_page_handler');
	elgg_register_page_handler('etherpad', 'etherpad_page_handler');
	
	// Language short codes must be of the form "etherpad:key"
	// where key is the array key below
	elgg_set_config('etherpad', array(
		'title' => 'text',
		'tags' => 'tags',
		'access_id' => 'access',
		'write_access_id' => 'write_access',
	));
	
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'etherpad_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'etherpad_entity_menu');
	
	elgg_register_entity_type('object', 'etherpad', 'ElggPad');
	
	//Widget
	elgg_register_widget_type('etherpad', elgg_echo('etherpad'), elgg_echo('etherpad:profile:widgetdesc'));
	
	// Register a URL handler for bookmarks
	elgg_register_entity_url_handler('object', 'etherpad', 'pages_url');
	
	// icon url override
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'etherpad_icon_url_override');
	
	 //Groups @TODO: groups
	 //add_group_tool_option('etherpad', elgg_echo('etherpad:enabletherpads'), true);
	 //elgg_extend_view('groups/tool_latest', 'etherpad/group_module');
}


function etherpad_page_handler($page, $handler) {
	
	elgg_load_library('elgg:pages');
	
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');

	$base_dir = elgg_get_plugins_path() . "etherpad/pages/$handler";

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			include "$base_dir/owner.php";
			break;
		case 'history':
			set_input('guid', $page[1]);
			include "$base_dir/history.php";
			break;
		case 'revision':
			set_input('id', $page[1]);
			include "$base_dir/revision.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Add fullscreen to entity menu
 */
function etherpad_entity_menu($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = new ElggPad($params['entity']->guid);

	// fullscreen button
	$options = array(
		'name' => 'etherpad-fullscreen',
		'text' => elgg_echo('etherpad:fullscreen'),
		'href' => $entity->getPadPath(),
		'priority' => 200,
	);
	$return[] = ElggMenuItem::factory($options);

	return $return;
}


/**
 * Add a menu item to an ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function etherpad_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "etherpad/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('etherpad', elgg_echo('etherpad'), $url);
		$return[] = $item;
	} else { //TODO: finish group support before uncommenting. 
		/*if ($params['entity']->etherpad_enable != 'no') {
			$url = "etherpad/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('etherpad', elgg_echo('etherpad:group'), $url);
			$return[] = $item;
		} */
	}

	return $return;
}

/**
* Returns a more meaningful message
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function etherpad_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && (($entity->getSubtype() == 'etherpad'))) {
		$descr = $entity->description;
		$title = $entity->title;
		//@todo why?
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' ' . elgg_echo("etherpad:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
	}
	return null;
}

/**
 * Populates the ->getUrl() method for bookmarked objects
 *
 * @param ElggEntity $entity The bookmarked object
 * @return string bookmarked item URL
 */
function etherpad_url($entity) {
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return elgg_get_site_url() . "pages/view/" . $entity->getGUID() . "/" . $title;
}

/**
 * Override the default entity icon for pads
 *
 * @return string Relative URL
 */
function etherpad_icon_url_override($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'etherpad') ||
		elgg_instanceof($entity, 'object', 'subpad')) {
		switch ($params['size']) {
			case 'small':
				return 'mod/etherpad/images/etherpad.gif';
				break;
			case 'medium':
				return 'mod/etherpad/images/etherpad_lrg.gif';
				break;
		}
	}
}
