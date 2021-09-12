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

$name			??= 'document-relative';
$style			??= 'before';
$start_depth	= '';
$end_depth		= '';
$numerate		= '';
$link			= '';

$context		= $this->tag;

// there's only preparsing, all output is not here
{
	$toc = $this->post_wacko_toc ?? $this->build_toc($context, $start_depth, $end_depth, $link);

	// ---------------------- p numeration ------------------------
	// clarifying, what numbers where is placed
	$toc_len	= count($toc);
	$p_num		= 0;

	for ($i = 0; $i < $toc_len; $i++)
	{
		if ($toc[$i][2] > 66666)
		{
			// normalizing submersion depth
			$p_num++;

			if ($name == 'document-relative')
			{
				$num = $p_num;
			}
			else
			{
				$num = str_replace('-', "&#0150;§",
						str_replace('p', '¹', $toc[$i][0] ));
			}

			// editing TOC containing @66
			$toc[$i][66] = $num;
		}
	}

	// page was changed a little - writing it to the cache is not a bad idea
	$this->tocs[$context]			= &$toc;

	// now we need to set up a (small) flag, that's page source should be
	// twisty-beasty changed in post-wacko and some digits could be added
	$this->post_wacko_toc			= &$toc;
	$this->post_wacko_action['p']	= $style;
	$this->post_wacko_maxp			= $p_num;
	// --------------------------------------------------------------
}
