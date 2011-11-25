<?php 

	$full = elgg_extract('full_view', $vars, FALSE);
	$etherpad = elgg_extract('entity', $vars, FALSE);

	if (!$etherpad) {
		return;
	}
	
	if ($full) {
		if(elgg_is_logged_in()){
	        elgg_load_library('elgg:etherpad-client');
	  
	        // Etherpad: Create an instance
	        $apikey = elgg_get_plugin_setting('etherpad_key', 'etherpad');
	        $apiurl = elgg_get_plugin_setting('etherpad_host', 'etherpad') . "/api";
			$instance = new EtherpadLiteClient($apikey,$apiurl);
	  
			//Etherpad: Create a group for logged in user
			try { 
				$mappedGroup = $instance->createGroupIfNotExistsFor("elggpad");//(get_loggedin_user()->username); 
				$groupID = $mappedGroup->groupID;
			} catch (Exception $e) {echo $e.getMessage();}
	
			//Etherpad: Create an author(etherpad user) for logged in user
			try {
	    	   $author = $instance->createAuthorIfNotExistsFor(elgg_get_logged_in_user_entity()->username);
	    	   $authorID = $author->authorID;
			} catch (Exception $e) {
	    	  echo "\n\ncreateAuthorIfNotExistsFor Failed with message ". $e->getMessage();
			}
			
			//Etherpad: Create session
			$validUntil = mktime(date("H"), date("i")+5, 0, date("m"), date("d"), date("y")); // 5 minutes in the future
			$sessionID = $instance->createSession($groupID, $authorID, $validUntil);
			$sessionID = $sessionID->sessionID;
			
			if(setcookie('sessionID', $sessionID, $validUntil, '/')){
				
			}
		}
	}
	
    $owner = $etherpad->getOwnerEntity();
    $owner_icon = elgg_view_entity_icon($owner, 'tiny');
    $container = $etherpad->getContainerEntity();
    $categories = elgg_view('output/categories', $vars);
    $owner_link = elgg_view('output/url', array(
	'href' => "etherpad/owner/$owner->username",
	'text' => $owner->name,
    ));
    $author_text = elgg_echo('byline', array($owner_link));
    $date = elgg_view_friendly_time($etherpad->time_created);

    $metadata = elgg_view_menu('entity', array(
	'entity' =>$etherpad,
	'handler' => 'etherpad',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
    ));

    $subtitle = "$author_text $date $categories";

    // do not show the metadata and controls in widget view
    if (elgg_in_context('widgets')) {
		$metadata = '';
    }
	
    $title = $etherpad->title;

    if($full){
		$argcount = 0;
		$padpath = $etherpad->paddress;
		//$padpath .= "?sessionID=" . $sessionID;
		if (elgg_is_logged_in()){	
			$padpath .= "?userName=" . elgg_get_logged_in_user_entity()->username;
		} else {
			$padpath .= "?userName=undefined";
		}
		//controls
		if (elgg_get_plugin_setting('show_controls', 'etherpad') == 'no') {
    	    $padpath .= "&showControls=false";
    	} else {
			$padpath .= "&showControls=true";
		}
	
		//monospace font
		if (elgg_get_plugin_setting('monospace_font', 'etherpad') == 'no') {
    	    $padpath .= "&useMonospaceFont=false";
    	} else {
			$padpath .= "&useMonospaceFont=true";
		}

		//chat
    	if (elgg_get_plugin_setting('show_chat', 'etherpad') == 'no') {
    	    $padpath .= "&showChat=false";
    	} else {
			$padpath .= "&showChat=true";
		}

    	//line numbers
    	if (elgg_get_plugin_setting('line_numbers', 'etherpad') == 'no') {
    		$padpath .= "&showLineNumbers=false";
    	} else {
			$padpath .= "&showLineNumbers=true";
		}	
		
	
		$params = array(		
			'entity' => $etherpad,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'title' => $title,
			'filter' => false,
			'tags' => false,
			);
		$list_body = elgg_view('object/elements/summary', $params);
		$content .= elgg_view_image_block($owner_icon, $list_body);
		$content .= elgg_view('output/iframe', array('value' => $padpath, 'type' => "etherpad"));
		echo $content;
		
		//Display description if it exists.
		if($etherpad->description){
			$desctitle = elgg_echo('etherpad:description');
			echo "<p></p><h3>$desctitle</h3><div class=\"elgg-content\">$etherpad->description</div></p>";
		}

    } else {

		$url = $etherpad->address;
		$display_text = $url;
		$excerpt = elgg_get_excerpt($etherpad->description);

        $content = $excerpt;
		$params = array(
			'entity' => $etherpad,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'content' => $content,
			'tags' => false,
		);
		$params = $params + $vars;
		$body = elgg_view('object/elements/summary', $params);
	
		echo elgg_view_image_block($owner_icon, $body);

    }           
?>
