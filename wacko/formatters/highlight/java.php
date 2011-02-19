<?php

$this->use_class('javahighlighter', 'formatters/classes/');

$dh = new JavaHighlighter();
echo "<!--no"."typo-->";
echo "<pre class=\"code\">";
echo $dh->analysecode($text);
echo "</pre>";
echo "<!--/no"."typo-->";
unset($dh);

?>