<?php

/**
 * Suppressed typografica in formatted text.
 */

echo '<!--notypo-->';

$typo = $this->db->default_typografica;
$this->db->default_typografica = false;
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
$this->db->default_typografica = $typo;

echo '<!--/notypo-->';
