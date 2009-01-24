<?php
$num = substr_count($text, "\n") + 2;

if ($this->method != "print" && $num >= 20) $num = 20;

if ($this->method != "print")
	$wrap = "off";
else
	$wrap = "on";

print("<!--notypo--><textarea class=\"code\" rows=\"".$num."\" wrap=\"".$wrap."\" readonly=\"readonly\">".htmlspecialchars($text)."</textarea><!--/notypo-->");
?>