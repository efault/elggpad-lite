<?php
/**
 * New etherpad river entry
 *
 * @package etherpad
 */

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt,
));
