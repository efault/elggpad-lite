<?php
/**
 * etherpad fullscreen entity menu button. 
 *
 * @uses $vars['entity']
 */

if (!isset($vars['entity'])) {
	return true;
}
if($vars['entity']->getSubtype() == 'etherpad'){
	
$guid = $vars['entity']->getGUID();

$url = $vars['entity']->paddress . "?userName=" . get_loggedin_user()->username;

	//controls
	if (elgg_get_plugin_setting('show_controls', 'etherpad') == 'no') {
    	    $url .= "&showControls=false";
    	} else {
	    $url .= "&showControls=true";
	}
	
	//monospace font
	if (elgg_get_plugin_setting('monospace_font', 'etherpad') == 'no') {
    	    $url .= "&useMonospaceFont=false";
    	} else {
	    $url .= "&useMonospaceFont=true";
	}

	//chat
    	if (elgg_get_plugin_setting('show_chat', 'etherpad') == 'no') {
    	    $url .= "&showChat=false";
    	} else {
	    $url .= "&showChat=true";
	}

    	//line numbers
    	if (elgg_get_plugin_setting('line_numbers', 'etherpad') == 'no') {
    		$url .= "&showLineNumbers=false";
    	} else {
		$url .= "&showLineNumbers=true";
	}

$params = array(
	'href' => $url,
	'text' => elgg_echo('etherpad:fullscreen'),
	'title' => elgg_echo('etherpad:fullscreen'),
	'is_action' => true,
	);
$fsbutton = elgg_view('output/url', $params);

echo $fsbutton;
}
