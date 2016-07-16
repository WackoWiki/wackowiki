<?php

/**
 * Supressed typografica in formated text.
 */

echo "<!--notypo-->";
$typo = $this->config['default_typografica'];
$this->config['default_typografica'] = false;
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
$this->config['default_typografica'] = $typo;
echo "<!--/notypo-->";
