<?php

if (!$options["wrapper_align"]) $options["wrapper_align"] = "right";
if (!$options["wrapper_width"]) $options["wrapper_width"] = "250";

echo '<div class="action" style="float:'.$options["wrapper_align"].'; width:'.$options["wrapper_width"].'px">';
echo '<div class="action-content">';
echo $text;
echo '</div></div>';
?>