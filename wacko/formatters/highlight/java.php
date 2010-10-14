<?php

$this->use_class('javahighlighter', 'formatters/classes/');

$DH = new JavaHighlighter();
echo "<!--no"."typo-->";
echo "<pre class=\"code\">";
echo $DH->analysecode($text);
echo "</pre>";
echo "<!--/no"."typo-->";
unset($DH);

?>