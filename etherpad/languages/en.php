<?php
/**
 * Etherpads English language file
 * 
 * package ElggPad
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	 
	'etherpad' => "Collaborative pages",
	'etherpad:add' => "Add pad",
	'etherpad:timeslider' => 'History',
	
	/**
	 * River
	 */
	'river:create:object:etherpad' => '%s created a new collaborative page %s',
	'river:create:object:subpad' => '%s created a new collaborative page %s',
	'river:update:object:etherpad' => '%s updated the collaborative page %s',
	'river:update:object:subpad' => '%s updated the collaborative page %s',
	'river:comment:object:etherpad' => '%s commented on the collaborative page %s',
	'river:comment:object:subpad' => '%s commented on the collaborative page %s',
	
	'item:object:etherpad' => 'Pads',
	'item:object:subpad' => 'Subpads',

	/**
	 * Status messages
	 */

	'etherpad:saved' => "Your pad was successfully saved.",
	'etherpad:delete:success' => "Your pad was successfully deleted.",
	'etherpad:delete:failure' => "Your pad could not be deleted. Please try again.",
	
	/**
	 * Edit page
	 */
	 
	 'etherpad:title' => "Title",
	 'etherpad:tags' => "Tags",
	 'etherpad:access_id' => "Read access",
	 'etherpad:write_access_id' => "Write access",

	/**
	 * Admin settings
	 */

	'etherpad:etherpadhost' => "Etherpad lite host address:",
	'etherpad:etherpadkey' => "Etherpad lite api key:",
	'etherpad:showchat' => "Show chat?",
	'etherpad:linenumbers' => "Show line numbers?",
	'etherpad:showcontrols' => "Show controls?",
	'etherpad:monospace' => "Use monospace font?",
	'etherpad:showcomments' => "Show comments?",
	'etherpad:newpadtext' => "New pad text:",
	'etherpad:pad:message' => 'New pad created successfully.',
	
	/**
	 * Widget
	 */
	'etherpad:profile:numbertodisplay' => "Number of pads to display",
    'etherpad:profile:widgetdesc' => "Display your latest pads",
    
    /**
	 * Sidebar items
	 */
	'etherpad:newchild' => "Create a sub-pad",
);

add_translation('en', $english);
