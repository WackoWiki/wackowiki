<?php

if (!$options["wrapper_align"]) $options["wrapper_align"] = "right";

echo '<div style="float:'.$options["wrapper_align"].'; text-align:'.$options["wrapper_align"].'">';
echo $text;
echo '</div>';
?>
