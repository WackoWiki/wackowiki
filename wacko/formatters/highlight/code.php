<?php
$num=substr_count($text, "\n")+2;
if ($this->method!="print" && $num>=15) $num=15;
print("<!--no"."typo--><textarea class=\"code\" rows=\"".$num."\" readonly=\"readonly\">".htmlspecialchars($text)."</text"."area><!--/no"."typo-->");
?>