<?php
/**
 * Delete a etherpad
 *
 * @package etherpad
 */

$guid = get_input('guid');
$etherpad = new ElggPad($guid);

if (elgg_instanceof($etherpad, 'object', 'etherpad') && $etherpad->canEdit()) {

	if ($etherpad->delete()) {
		system_message(elgg_echo("etherpad:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("etherpad/group/$container->guid/all");
		} else {
			forward("etherpad/owner/$container->username");
		}
	}
}

register_error(elgg_echo("etherpad:delete:failed"));
forward(REFERER);
?>
