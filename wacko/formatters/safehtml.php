<?php

$this->use_class('safehtml', 'lib/safehtml/');

$safehtml = new safehtml();
echo ($safehtml->parse($text));

?>