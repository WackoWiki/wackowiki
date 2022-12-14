<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = preg_replace('/{{(toc).*?}}/ui', '', $text);
$data = $this->format($text, 'wiki', ['post_wacko' => true]);

// paragraphs
$data = preg_replace('/<br\s*>/u', '</p><p>', $data);

echo $data;
