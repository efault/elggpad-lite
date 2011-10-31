<?php
/**
 * Display a page in an embedded window
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value'] Source of the page.
 * @uses $vars['type'] type of iframe.
 */
  
  
  $fullsrc = "\"" . $vars['value'] . "\"";
  $type = $vars['type']; 
  if($type){
    switch($type) {
	case "etherpad" :
        	$fullsrc .= " width=728 height=405";
        	break;
	default :
		break;
    }
  }
?>
<iframe src=<?php echo $fullsrc; ?>>
</iframe>
