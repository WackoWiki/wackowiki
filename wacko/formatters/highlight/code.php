<?php
$num = substr_count($text, "\n") + 2;

if ($this->method != 'print' && $num >= 20) $num = 20;

if ($this->method != 'print')
	$wrap = 'off';
else
	$wrap = 'on';

echo "<!--notypo--><pre class=\"code\">".htmlspecialchars($text)."</pre><!--/notypo-->";
?>