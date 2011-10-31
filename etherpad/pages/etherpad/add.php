<?php
    // Load Elgg engine
    include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
 
    // make sure only logged in users can see this page	
    gatekeeper();
 
    // set the title
    $title = elgg_echo('etherpad:add');
    elgg_push_breadcrumb('new');
    // start building the main column of the page
    $area2 = elgg_view_title($title);
 
    // Add the form to this section
    $area2 .= elgg_view_form("etherpad/save");
   
    // layout the page
    $body = elgg_view_layout('content', array('sidebar' => elgg_view('etherpad/sidebar'), 'content' => $area2, 'filter' => false,));
 
    // draw the page
    echo elgg_view_page($title,$body);
?>
