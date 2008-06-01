<?php
require_once("lib/Text_Highlighter/Highlighter.php");

if ($options["_default"])
{
	$hl =& Text_Highlighter::factory(strtoupper($options["_default"]),array('numbers'=>false));
	if (!is_object($hl))
	{
		echo $hl;
	}
	else
	{
		echo "<!--no"."typo-->";
		echo "<div class=\"code\">";
		echo "<pre>".$hl->highlight($text)."</pre>";
		echo "</div>";
		echo "<!--/no"."typo-->";
	}
}
else
echo htmlspecialchars($text);

?>