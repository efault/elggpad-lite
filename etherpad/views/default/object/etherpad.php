<?php 

	$full = elgg_extract('full_view', $vars, FALSE);
	$etherpad = elgg_extract('entity', $vars, FALSE);
	
	if (!$etherpad || !elgg_instanceof($etherpad, 'object', 'etherpad')) {
		return true;
	}
	
	$etherpad = new ElggPad($etherpad->guid);
	
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
		
		try {
			$etherpad->startSession();
			$content .= elgg_view('output/iframe', array('value' => $etherpad->getPadPath(), 'type' => "etherpad"));
		} catch(Exception $e) {
			$content .= $e->getMessage();
		}
		
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
