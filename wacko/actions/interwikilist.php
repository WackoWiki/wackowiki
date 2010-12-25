<?php

$file = implode('', file('config/interwiki.conf', 1));
echo $this->format('%%'.$file.'%%');

?>