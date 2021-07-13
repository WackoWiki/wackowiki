<?php

/*
	%%(details
		[title="Title"]
		[open=0|1]
		)
	content
	%%
*/

$options['title']	??= null;
$options['open']	??= 0;

$title	= $options['title'] ?? $this->_t('ShowHideDetails');
$open	= $options['open'] ? ' open' : '';

echo	'<ignore><details' . $open . '>' . "\n";
echo	($title
			? '<summary>' . Ut::html($title) . '</summary>' . "\n"
			: '');
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
echo	'</details></ignore>' . "\n";
