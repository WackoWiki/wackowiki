<?php

/*
	converts inline csv data into a table

	%%(csv
		[delim="comma|semicolon"]
		)
	content
	%%

	https://wackowiki.org/doc/Dev/PatchesHacks/CSV
*/

$options['delim']	??= 'comma';

$delim	= match($options['delim']) {
	'semicolon'	=> ';',
	default		=> ',',
};

$blanks		= 0;
$csv_lines	= preg_split('/[\n]/', $text);

// asserts what precedes the ; is not a backslash \\\\, doesn't account for \\; (escaped backslash semicolon)
// https://stackoverflow.com/questions/40479546/how-to-split-on-white-spaces-not-between-quotes

// split on delimiter but not between quotes
$regex_split	= '/(?<!\\\\)' . $delim . '(?=(?:[^\"]*([\"])[^\"]*\\1)*[^\"]*$)/';
$regex_escaped	= '/\\\\' . $delim . '/';

$tpl->enter('r_');

foreach ($csv_lines as $i => $line)
{
	if (preg_match('/^#|^\s*$/', $line))
	{
		$blanks++;
		continue;
	}

	$tpl->commit = true; // alternation hack

	$tpl->enter('c_');

	foreach (preg_split($regex_split, $line) as $r => $field)
	{
		$tpl->commit = true; // alternation hack

		if ($i == $blanks)
		{
			$class[$r] = ''; // 'padding: 1px 10px 1px 10px; ';
		}

		if (preg_match('/^\"?\s*==(.*)==\s*\"?$/', $field, $header))
		{
			$title[$r] = $header[1];

			if (preg_match('/([\/\\\\|])(.*)\\1$/', $title[$r], $align))
			{
				$class[$r] .= match($align[1]) {
					'/'		=> 't-right',
					'\\'	=> 't-left',
					'|'		=> 't-center',
				};

				$title[$r] = $align[2];
			}

			$tpl->h_class	= $class[$r];
			$tpl->h_title	= $title[$r];
			continue;
		}

		// if a cell is blank, echo &nbsp;
		if (preg_match('/^\s*$/', $field))
		{
			$tpl->t_class	= $class[$r];
			$tpl->t_cell	= '&nbsp;';
			continue;
		}
		// extract the cell out of it's quotes
		else if (preg_match('/^\s*(\"?)(.*?)\\1\s*$/', $field, $matches))
		{
			if ($matches[1] == '"')
			{
				#$style[$r]	= 'white-space: pre; ' . $style[$r];
				$cell		= $matches[2];
			}
			else
			{
				$cell		= preg_replace($regex_escaped, $delim, $matches[2]);
			}

			// [[wiki link]]
			if (preg_match_all('/\[\[([[:alnum:]]+)\]\]/', $cell, $all_links))
			{
				$linked = $cell;

				foreach ($all_links[1] as $n => $camel_link)
				{
					$linked = preg_replace('/\[\[' . $camel_link . '\]\]/', $this->link($camel_link), $linked);
				}
			}
			// [[url label]]
			else if (preg_match_all('/\[\[(.*?)\]\]/', $cell, $all_links))
			{
				$linked = $cell;

				foreach ($all_links[1] as $n => $url_link)
				{
					if(preg_match('/^(\S+)(\s+(.+))?$/us', $url_link, $matches))
					{
						$url	= $matches[1] ?? '';
						$text	= $matches[3] ?? '';
						$linked	= preg_replace('#\[\[' . $matches[0] . '\]\]#', $this->link($url, '', $text), $linked);
					}
				}
			}
			else
			{
				$linked = Ut::html($cell);
			}

			$tpl->t_class	= $class[$r];
			$tpl->t_cell	= $linked;
			continue;
		}

		$tpl->t_class	= $class[$r];
		$tpl->t_cell	= 'ERROR!';
	}

	$tpl->leave();	// c_
}

$tpl->leave();	// r_