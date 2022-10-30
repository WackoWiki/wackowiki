<?php

$dh = new JavaHighlighter();
$tpl->text = $dh->analyse_code($text);
unset($dh);
