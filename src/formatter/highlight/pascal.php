<?php

$dh = new DelphiHightlighter();
$tpl->text = $dh->analyse_code($text);
unset($dh);
