<?php

$file = implode("", file("config/interwiki.conf", 1));
print($this->Format("%%".$file."%%"));

?>