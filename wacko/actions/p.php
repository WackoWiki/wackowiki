<?php
/*
	{{P style="BEFORE|after|left|right"				// table-type "left/right" don't implemented yet
	// styles can be found in /classes/wacko.php
	name="absolute|toc-relative|DOCUMENT-RELATIVE"  // "toc-relative" don't implemented yet
	}}
*/

$name			= '';
$style			= '';
$start_depth	= '';
$end_depth		= '';
$numerate		= '';
$link			= '';

$page			= '';
$ppage			= '';
$context		= $this->tag;
$_page			= $this->page;


if (!$name)  $name  = 'document-relative';
if (!$style) $style = 'before';

// there's only preparsing, all output is not here
{
	if (isset($this->post_wacko_toc)) $toc = &$this->post_wacko_toc;
	else
	$toc = $this->build_toc( $context, $start_depth, $end_depth, $numerate, $link );

	{ // ---------------------- p numeration ------------------------
		// clarifying, what numbers where is placed
		$toc_len = sizeof($toc);
		$numbers = array(); $depth = 0; $pnum=0;
		for($i = 0; $i < $toc_len; $i++)
		if ($toc[$i][2] > 66666)
		{
			// normalizing submersion depth
			$pnum++;
			if ($name == 'document-relative')	$num = $pnum;
			else								$num = str_replace('-', "&#0150;&sect;",
			str_replace("p", "¹", $toc[$i][0] ));
			// editing TOC @66 contains
			$toc[$i][66] = $num;
		}
		// page was changed a little - writing it to the cache is not a bad idea
		$this->tocs[ $context ] = &$toc;
		// now we need to set up a (small) flag, that's page source should be
		// twisty-beasty changed in post-wacko and some dygits could be added
		// (dygits -> digits, here is a misspell in Russian source - I don't know
		// is it a typo or next joke :) twisty-beasty™ change - Russian "êóðî÷èòü" :)
		$this->post_wacko_toc = &$toc; $this->post_wacko_action['p'] = $style;
		$this->post_wacko_maxp = $pnum;
	} // --------------------------------------------------------------
}

?>