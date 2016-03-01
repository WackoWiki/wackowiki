<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->use_class('pre_wacko', $this->config['formatter_path'].'/class/');

$parser	= new preformatter($this);
$text	= preg_replace_callback($parser->PREREGEXP, array(&$parser, 'precallback'), $text);

echo $text;

?>