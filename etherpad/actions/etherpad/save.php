<?php

  elgg_load_library('elgg:etherpad-client');
  
  // Etherpad: Create an instance
  $apikey = elgg_get_plugin_setting('etherpad_key', 'etherpad');
  $apiurl = elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/api";
  $instance = new EtherpadLiteClient($apikey,$apiurl);
  
  
try { 
	//Etherpad: Create a group for elggpad.
	$mappedGroup = $instance->createGroupIfNotExistsFor("elggpad");//(elgg_get_logged_in_user_entity()->username);
	$groupID = $mappedGroup->groupID;

	//Etherpad: Create an author(etherpad user) for logged in user
	$author = $instance->createAuthorIfNotExistsFor(elgg_get_logged_in_user_entity()->username);
	$authorID = $author->authorID;

	//Etherpad: Create session
	$validUntil = mktime(0, 0, 0, date("m"), date("d")+1, date("y")); // One day in the future
	$sessionID = $instance->createSession($groupID, $authorID, $validUntil);
	$sessionID = $sessionID->sessionID;
	if(!setcookie("sessionID", $sessionID)){ // Set a cookie
		throw new Exception();
	}
	
	//generate pad name
	function genRandomString() { // A funtion to generate a random name
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
	
	$name = genRandomString();
	$padID = $groupID . "$" . $name;
	
	//Create new pad
	//TODO : Access control, private pads. 
	$instance->createGroupPad($groupID,$name, elgg_get_plugin_setting('new_pad_text', 'etherpad'));
	
} catch (Exception $e) {
	register_error($e->getMessage());
	forward(REFERER);
}
  
  // get the form input
  $title = get_input('title');
  $padurl = elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/p/". $padID;
  $body = get_input('description');
  $tags = string_to_tag_array(get_input('tags'));
  $access = get_input('access_id');
  //set etherpad permissions
  if($access == '2') {
		$instance->setPublicStatus($padID,"true");
	} else {
		$instance->setPublicStatus($padID,"false"); 
  }
  // create a new etherpad object
  $etherpad = new ElggObject();
  $etherpad->subtype = "etherpad";
  $etherpad->title = $title;
  $etherpad->description = $body;
  $etherpad->paddress = $padurl;
  $etherpad->access_id = $access;
  $etherpad->pname = $padID;
  // owner is logged in user
  $etherpad->owner_guid = elgg_get_logged_in_user_guid();
  // save tags as metadata
  $etherpad->tags = $tags;
  $guid = get_input('guid');

  // save to database
  if ($etherpad->save()) {
	//add to river only if new
	if ($guid == 0) {
		add_to_river('river/object/etherpad/create','create', elgg_get_logged_in_user_guid(), $etherpad->getGUID());
		$etherpad->container_guid = (int)get_input('container_guid', elgg_get_logged_in_user_guid());
	}
	system_message(elgg_echo('etherpad:save:success'));
	 
  } else {
	if (!$etherpad->canEdit()) {
		system_message(elgg_echo('etherpad:save:failed'));
		forward(REFERRER);
	}	
}
  // forward user to a page that displays the post
  $instance->deleteSession($sessionID);
  forward($etherpad->getURL());
  
