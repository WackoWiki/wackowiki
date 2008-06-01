<?php

$text = htmlspecialchars($text);

$text = preg_replace("/\b(https?|ftp|file|nntp|telnet):\/\/\S+/","<a href='\\0'>\\0</a>", $text);

$text = str_replace("&gt;", ">", $text);
$text = preg_replace("/^([^\s\n>]*?(>{2})*>)([^>].*)$/m","<span class=\"email1\">\\1\\3</span>",$text);
$text = preg_replace("/^([^\s\n>]*?(>{2})+)([^>].*)$/m", "<span class=\"email2\">\\1\\3</span>",$text);
echo "<div class=\"code\"><pre>";
echo $text;
echo "</pre></div>";

?>