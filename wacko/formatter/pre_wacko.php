<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser	= new preformatter($this);
$text	= preg_replace_callback($parser->PREREGEXP, array(&$parser, 'precallback'), $text);

echo $text;

?>
