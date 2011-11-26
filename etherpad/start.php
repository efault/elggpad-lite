<?php
/**
 * Elgg Etherpad lite plugin
 *
 * @package etherpad
 */
 
elgg_register_event_handler('init', 'system', 'etherpad_init');


function etherpad_init() {
	$actions_base = elgg_get_plugins_path() . 'etherpad/actions/etherpad';
	elgg_register_action("etherpad/save", "$actions_base/save.php");
	elgg_register_action("etherpad/delete", "$actions_base/delete.php");
	
	elgg_register_page_handler('etherpad', 'etherpad_page_handler');
	
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'etherpad_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'etherpad_entity_menu');
	
	elgg_register_entity_type('object', 'etherpad', 'ElggPad');
	// menus
	elgg_register_menu_item('site', array(
		'name' => 'etherpad',
		'text' => elgg_echo('etherpad'), 
		'href' => 'etherpad/all'
	));
	
	//Widget
	elgg_register_widget_type('etherpad', elgg_echo('etherpad'), elgg_echo('etherpad:profile:widgetdesc'));
	
	// Register a URL handler for bookmarks
	elgg_register_entity_url_handler('object', 'etherpad', 'etherpad_url');
	
	// Register entity type for search
	elgg_register_entity_type('object', 'etherpad');
	
	 //Groups @TODO: groups
	 //add_group_tool_option('etherpad', elgg_echo('etherpad:enabletherpads'), true);
	 //elgg_extend_view('groups/tool_latest', 'etherpad/group_module');
}


function etherpad_page_handler($page) {
	
	if (!isset($page[0])) {
		$page[0] = 'all';
	}
	
	elgg_push_breadcrumb(elgg_echo('etherpad'), 'etherpad/all');
	
	$base_dir = elgg_get_plugins_path() . 'etherpad/pages/etherpad';

	$page_type = $page[0];
	switch ($page_type) {
		case "add" :
			set_input('guid', $page[1]);
        	include "$base_dir/add.php";
			break;

		case "all" :
			include "$base_dir/all.php";
			break;
		
		case "edit" :
			gatekeeper();
			set_input('guid', $page[1]);
        	include "$base_dir/edit.php";
			break;

		case "owner" :
			include "$base_dir/owner.php";
			break;

		case "friends" :
			include "$base_dir/friends.php";
			break;

		case "view":
			set_input('guid', $page[1]);
			include "$base_dir/view.php";
			break;
		case 'group':
			group_gatekeeper();
			include "$base_dir/owner.php";
			break;

		default: 
			include "$base_dir/all.php";
			break;
			
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

	$entity = $params['entity'];

	// fullscreen button
	$options = array(
		'name' => 'etherpadfs',
		'text' => elgg_view('etherpad/button', array('entity' => $entity)),
		'href' => $entity->paddress,
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
	return elgg_get_site_url() . "etherpad/view/" . $entity->getGUID() . "/" . $title;
}
?>
