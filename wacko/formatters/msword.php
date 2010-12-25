<?php
$text = preg_replace('/{{(tableofcontents|toc).*?}}/i', '', $text);
$data = $this->format($text, "wiki");
$data = preg_replace('/<br\s*\/>/', '</p><p>', $data);

echo $data;
?>