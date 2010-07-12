<?php
$text = preg_replace("/{{(tableofcontents|toc).*?}}/i", "", $text);
$data = $this->Format($text, "wiki");
$data = preg_replace("/<br\s*\/>/", "</p><p>", $data);

print $data;
?>