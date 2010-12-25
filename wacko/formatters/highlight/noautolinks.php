<?php

$this->_formatter_noautolinks = true;
//echo $this->format($text, 'wiki');
include('formatters/wiki.php');
$this->_formatter_noautolinks = false;

?>