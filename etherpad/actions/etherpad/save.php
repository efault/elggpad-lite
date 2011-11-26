<?php
  // get the form input
  $title = get_input('title');
  $body = get_input('description');
  $tags = string_to_tag_array(get_input('tags'));
  $access = get_input('access_id');
  
  // create a new etherpad object
  $etherpad = new ElggPad();
  $etherpad->title = $title;
  $etherpad->description = $body;
  $etherpad->access_id = $access;
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
  forward($etherpad->getURL());
  
