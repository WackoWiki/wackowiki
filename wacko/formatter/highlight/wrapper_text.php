<?php

if (!isset($options['wrapper_align'])) $options['wrapper_align'] = 'right';

echo '<div style="float:'.$options['wrapper_align'].'; text-align:'.$options['wrapper_align'].'">'."\n";
echo $text;
echo "</div>\n";

?>