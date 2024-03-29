<?php

$text = Ut::html($text);

$text = preg_replace("/\b(https?|ftp|file|nntp|telnet):\/\/\S+/u", "<a href='\\0'>\\0</a>", $text);

$text = str_replace("&gt;", ">", $text);
$text = preg_replace("/^([^\s\n>]*?(>{2})*>)([^>].*)$/um", "<span class=\"email1\">\\1\\3</span>", $text);
$text = preg_replace("/^([^\s\n>]*?(>{2})+)([^>].*)$/um", "<span class=\"email2\">\\1\\3</span>", $text);

// output source
$tpl->text = $text;