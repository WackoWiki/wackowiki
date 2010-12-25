<?php

echo "<!--notypo-->";
$typo = $this->config['default_typografica'];
$this->config['default_typografica'] = false;
include('formatters/wiki.php');
$this->config['default_typografica'] = $typo;
echo "<!--/notypo-->";

?>