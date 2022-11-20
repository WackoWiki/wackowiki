<?php

/*
	converts inline data into a timeline

	%%(timeline
		[order="asc|desc"]
		[delim="comma|semicolon"]
		)
	content
	%%

	[0] direction: 'l|r'	(left|right)
	[1] flag: 'Amsterdam'
	[2] time: 'July 1 & 2, 2022'
	[3] description: 'Dutch PHP Conference 2022'

	e.g.
	l | Moscow | September 12-13, 2022 | PHP Russia 2022
	r | Amsterdam | July 1 & 2, 2022 | Dutch PHP Conference 2022

	https://wackowiki.org/doc/Dev/PatchesHacks/Timeline
*/

// set defaults
$options['delim']	??= 'pipe';
$options['order']	??= 'asc';

$delim	= match($options['delim']) {
	'semicolon'	=> ';',
	default		=> '|',
};

// set CSS styles once
if (!isset($this->timline))
{
	$this->timline	= true;
	$tpl->style_n	= true;
}

// get data
$lines	= preg_split('/[\n]/u', $text);

if ($options['order'] == 'desc')
{
	$lines = array_reverse($lines);
}

foreach ($lines as $line)
{
	// blank
	if (preg_match('/^#|^\s*$/u', $line))
	{
		continue;
	}

	$tpl->enter('n_');

	$_item = explode('|', $line);
	{
		$item			= array_map('trim', $_item);
		// debug
		#Ut::debug_print_r($item);

		$direction	= match($item[0]) {
			'r'			=> 'r',
			default		=> 'l',
		};

		// further string processing here (links, filter, ...)
		$flag			= $item[1] ?? '';
		$time			= $item[2] ?? '';
		$description	= $item[3] ?? '';

		if ($flag)
		{
			$tpl->direction		= $direction;
			$tpl->flag			= $flag;
			$tpl->time			= $time;
			$tpl->description	= $this->format($description, 'wiki', ['post_wacko' => true]);
		}
	}

	$tpl->leave(); // n_
}
