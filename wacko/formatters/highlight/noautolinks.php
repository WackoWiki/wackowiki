<?php

$this->_formatter_noautolinks = true;
//print($this->format($text, 'wiki'));
include('formatters/wiki.php');
$this->_formatter_noautolinks = false;

?>