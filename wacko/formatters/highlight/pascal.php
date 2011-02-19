<?php

$this->use_class('delphihightlighter', 'formatters/classes/');

$dh = new DelphiHightlighter();
echo "<!--no"."typo-->";
echo "<pre class=\"code\">";
echo $dh->analysecode($text);
echo "</pre>";
echo "<!--/no"."typo-->";
unset($dh);

?>