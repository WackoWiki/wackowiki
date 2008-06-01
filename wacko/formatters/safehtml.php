<?php

$this->UseClass("safehtml", "lib/safehtml/");

$safehtml =& new safehtml();
echo ($safehtml->parse($text));

?>