<?php

/**
 * Suppressed wacko text on included page
 */

echo '<!--noinclude-->';

include Ut::join_path(FORMATTER_DIR, 'wiki.php');

echo '<!--/noinclude-->';
