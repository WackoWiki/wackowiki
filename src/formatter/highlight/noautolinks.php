<?php

/**
 * noautolinks formatter suppressed links detection in wacko text
 */

$this->noautolinks = true;

include Ut::join_path(FORMATTER_DIR, 'wiki.php');

$this->noautolinks = false;
