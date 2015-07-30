<?php

$this->_formatter_noautolinks = true;
//echo $this->format($text, 'wiki');
include($this->config['formatter_path'].'/wiki.php');
$this->_formatter_noautolinks = false;

?>