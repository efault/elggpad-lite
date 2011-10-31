<?php
/**
 * etherpad sidebar.
 * @TODO : Add something to sidebar, its too empty. but what??
 */
if(elgg_get_plugin_setting('show_comments', 'etherpad') == 'yes'){
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'etherpad',
		'owner_guid' => elgg_get_page_owner_guid(),
	));
}
?>

