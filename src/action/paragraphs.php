<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{paragraphs
		style="before|after|left|right"
		name="absolute|toc-relative|document-relative"
	}}

	table-type "left/right" not implemented yet
	styles can be found in /class/wacko.php
	"toc-relative" not implemented yet
*/

$info = <<<EOD
Description:
	It enters numeration for the paragraphs.

Usage:
	{{paragraphs}}

Options:
	[style="before|after|left|right"]
		The style affects where paragraph numbers will be displayed.
	[name="absolute|document-relative"]
EOD;

// set defaults
$help			??= 0;
$name			??= 'document-relative';
$style			??= 'before';

if ($help)
{
	echo $this->help($info, 'paragraphs');
	return;
}

$start_depth	= '';
$end_depth		= '';
$link			= '';

$context		= $this->tag;

// there's only preparsing, all output is not here
{
	$toc = $this->post_wacko_toc ?? $this->build_toc($context, $start_depth, $end_depth, $link);

	// ---------------------- p numeration ------------------------
	// clarifying, what numbers and where it is placed
	$toc_len	= count($toc);
	$p_num		= 0;

	for ($i = 0; $i < $toc_len; $i++)
	{
		if ($toc[$i][2] > IS_HEADING)
		{
			// normalizing submersion depth
			$p_num++;

			if ($name == 'document-relative')
			{
				$num = $p_num;
			}
			else
			{
				$num = str_replace('-', '–§',
						str_replace('p', '¹', $toc[$i][0] ));
			}

			// editing TOC containing @66
			$toc[$i][66] = $num;
		}
	}

	// page was changed a little - writing it to the cache is not a bad idea
	$this->tocs[$context]			= &$toc;

	// now we need to set up a (small) flag, that the page source should be
	// changed in post-wacko and some digits could be added
	$this->post_wacko_toc			= &$toc;
	$this->post_wacko_action['p']	= $style;
	$this->post_wacko_maxp			= $p_num;
	// --------------------------------------------------------------
}
