<?php

/**
 * noautolinks formatter suppressed links detection in wacko text
 */

$this->_formatter_noautolinks = true;
//echo $this->format($text, 'wiki');
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
$this->_formatter_noautolinks = false;
