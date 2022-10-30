<?php

/*
	%%(details
		[title="Title"]
		[open=0|1]
		)
	content
	%%
*/

// defaults
if (!isset($options['title']))		$options['title']	= null;
if (!isset($options['open']))		$options['open']	= 0;

$options['tpl'] = true;

$title	= $options['title'] ?? $this->_t('ShowHideDetails');
$open	= $options['open'] ? ' open' : '';

$tpl->open		= $open;
$tpl->s_title	= $title;
$tpl->include	= include Ut::join_path(FORMATTER_DIR, 'wiki.php');
