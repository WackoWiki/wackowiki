<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = preg_replace('/{{(toc).*?}}/ui', '', $text);
$data = $this->format($text, 'wiki');
$data = preg_replace('/<br\s*>/u', '</p><p>', $data);

echo $data;
