<?php
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$address = elgg_extract('address', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$message = elgg_echo("etherpad:access:message");
?>

<div>
    <label><?php echo elgg_echo("title"); ?></label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'title', 'value' => $title)); ?>
</div>
<div>
    <label><?php echo elgg_echo("description"); ?></label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'description', 'value' => $desc)); ?>
</div> 
<div>
    <label><?php echo elgg_echo("tags"); ?></label><br />
    <?php echo elgg_view('input/tags',array('internalname' => 'tags', 'value' => $tags)); ?>
</div>
<?php
echo elgg_view('output/text', array('value' => $message));
$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
<?php echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
} ?>
</div>
<div>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>

