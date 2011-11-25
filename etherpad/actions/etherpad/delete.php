<?php
/**
 * Delete a etherpad
 *
 * @package etherpad
 */

elgg_load_library('elgg:etherpad-client');

$guid = get_input('guid');
$etherpad = get_entity($guid);
$apikey = elgg_get_plugin_setting('etherpad_key', 'etherpad');
$apiurl = elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/api";
$instance = new EtherpadLiteClient($apikey,$apiurl);


if (elgg_instanceof($etherpad, 'object', 'etherpad') && $etherpad->canEdit()) {
	$container = $etherpad->getContainerEntity();
	
  	
	try {
  		$instance->deletePad($etherpad->pname);
  	} catch (Exception $e) {
  		echo $e->getMessage();
  	}

	if ($etherpad->delete()) {
		system_message(elgg_echo("etherpad:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("etherpad/group/$container->guid/all");
		} else {
			forward("etherpad/owner/$container->username");
		}
	}
}

register_error(elgg_echo("etherpad:delete:failed"));
forward(REFERER);
?>
