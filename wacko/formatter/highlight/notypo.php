<?php

/**
 * Supressed typografica in formated text.
 */

echo "<!--notypo-->";
$typo = $this->config['default_typografica'];
$this->config['default_typografica'] = false; // STS: touching config considered a hack
include(join_path(FORMATTER_DIR, 'wiki.php'));
$this->config['default_typografica'] = $typo;
echo "<!--/notypo-->";

?>
