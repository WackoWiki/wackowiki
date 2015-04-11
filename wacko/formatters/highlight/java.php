<?php

$this->use_class('javahighlighter', 'formatters/classes/');

$dh = new JavaHighlighter();
echo '<!--notypo-->';
echo '<pre class="code">';
echo $dh->analysecode($text);
echo "</pre>";
echo '<!--/notypo-->';
unset($dh);

?>