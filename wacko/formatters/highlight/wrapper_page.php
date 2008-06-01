<?php

if (!$options["wrapper_width"]) $options["wrapper_width"] = "800";

echo '<div style="width:'.$options["wrapper_width"].'px">';
echo $text;
echo '</div>';
?>