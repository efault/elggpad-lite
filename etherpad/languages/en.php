<?php
/**
 * Etherpads English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'etherpad' => "Etherpads",
	'etherpad:add' => "New etherpad",
	'etherpad:edit' => "Edit etherpad",
	'etherpad:owner' => "%s's etherpads",
	'etherpad:friends' => "Friends' etherpads",
	'etherpad:everyone' => "All etherpads",
	'etherpad:new' => "A new etherpad",
	'etherpad:via' => "via etherpad",
	'etherpad:address' => "Address of the resource to etherpad",
	'etherpad:none' => 'No etherpads',
	'etherpad:write' => 'Add etherpad',
	'etherpad:delete:confirm' => "Are you sure you want to delete this resource?",
	'etherpad:fullscreen' => 'Fullscreen',
	'etherpad:numbertodisplay' => 'Number of etherpad to display',

	'etherpad:visit' => "Visit resource",
	'etherpad:recent' => "Recent etherpad",
	'etherpad:access:message' => "All etherpads are currently set to pubilc, this will be fixed it a later release.",
	'river:create:object:etherpad' => '%s created a new etherpad %s',
	'river:comment:object:etherpad' => '%s commented on an etherpad %s',
	'etherpad:river:annotate' => 'a comment on this etherpad',

	'item:object:etherpad' => 'Etherpads',

	'etherpad:group' => 'Group etherpads',
	'etherpad:enabletherpads' => 'Enable group etherpads',
	'etherpad:nogroup' => 'This group does not have any etherpads yet',
	'etherpad:more' => 'More etherpads',
	'etherpad:description' => 'Description',
	'etherpad:no_title' => 'No title',

	/**
	 * Status messages
	 */

	'etherpad:save:success' => "Your pad was successfully saved.",
	'etherpad:delete:success' => "Your pad was successfully deleted.",

	/**
	 * Error messages
	 */

	'etherpad:save:failed' => "Your pad could not be saved. Make sure you've entered a title and then try again.",
	'etherpad:delete:failed' => "Your pad could not be deleted. Please try again.",

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
);

add_translation('en', $english);
