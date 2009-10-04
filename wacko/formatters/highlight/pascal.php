<?php

$this->UseClass("delphihightlighter", "formatters/classes/");

$DH = new DelphiHightlighter();
echo "<!--no"."typo-->";
echo "<pre class=\"code\">";
echo $DH->analysecode($text);
echo "</pre>";
echo "<!--/no"."typo-->";
unset($DH);

?>