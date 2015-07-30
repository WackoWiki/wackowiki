<?php

echo "<!--notypo-->";
$typo = $this->config['default_typografica'];
$this->config['default_typografica'] = false;
include($this->config['formatter_path'].'/wiki.php');
$this->config['default_typografica'] = $typo;
echo "<!--/notypo-->";

?>