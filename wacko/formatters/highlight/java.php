<?php

$this->UseClass("JavaHighlighter", "formatters/classes/");

$DH = &new JavaHighlighter();
echo "<!--no"."typo-->";
echo "<div class=\"code\"><pre>";
echo $DH->analysecode($text);
echo "</pre></div>";
echo "<!--/no"."typo-->";
unset($DH);

?>