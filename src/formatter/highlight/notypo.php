<?php

/**
 * Suppressed typografica in formatted text.
 */

echo '<!--notypo-->';

$typo = $this->db->typografica;
$this->db->typografica = false;
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
$this->db->typografica = $typo;

echo '<!--/notypo-->';
