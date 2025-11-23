<?php

/*
	%%(info
		[type="default | error | example | important | note | question | quote | success | warning"]
		[title="Title"]
		[icon=0|1]
		[style="no use"]
		)
	content
	%%
*/

$types			= ['default', 'error', 'example', 'important', 'note', 'question', 'quote', 'success', 'warning'];

// defaults
$options['type']	??= 'default';
$options['title']	??= null;
$options['icon']	??= 1;
$options['style']	??= false;

$options['tpl']		= true;

if (in_array($options['type'], $types))
{
	// info type-* in wacko.css
	$tpl->type = ' type-' . $options['type'];
}

if ($options['icon'])
{
	$tpl->icon	= true;
	$tpl->eicon	= true;
}

$tpl->style		= 'info';
$tpl->t_title	= $options['title'] ?? null;
$tpl->include	= include Ut::join_path(FORMATTER_DIR, 'wiki.php');
