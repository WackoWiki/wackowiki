<?php

if (!isset($options['wrapper_align'])) $options['wrapper_align'] = "right";
if (!isset($options['wrapper_width'])) $options['wrapper_width'] = "250";

if ($options['wrapper_align'] == 'center')
	$align_style = "margin:0 auto;";
else
	$align_style = "float:".$options['wrapper_align'].";";

echo '<div class="action" style="'.$align_style.'; width:'.$options['wrapper_width'].'px">';
echo '<div class="action-content">';
echo $text;
echo '</div></div>';

?>