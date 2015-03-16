<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{toc page|for="!/SubTag" from="h2" to="h4" numerate=[0|1] legend="alternate legend" nomark=[0|1] }}
*/
// 1. check for first param (for what table of content is built)

if (!isset($nomark))	$nomark = '';
if (!isset($for))		$for = '';
if (!isset($page))		$page = '';
if (!isset($numerate))	$numerate = '';
if (!isset($from))		$from = '';
if (!isset($to))		$to = '';
if (!isset($legend))	$legend = '';
if (!isset($debug))		$debug = false;

if ($for)				$page = $for;
if ($page)
{
	$page		= $this->unwrap_link($page);
	$ppage		= '/'.$page;
	$context	= $page;
	$_page		= $this->load_page($page);

	if (!$legend)	$legend = $page;
	if ($_page)		$link	= $this->href('', $_page['tag']);
}
else
{
	$page		= '';
	$ppage		= '';
	$context	= $this->tag;
	$_page		= $this->page;
	$link		= '';
}

if (!$from)		$from	= 'h2';
if (!$to)		$to		= 'h9';

$start_depth	= $from[1];
$end_depth		= $to[1];

// 3. output
if (!$nomark)
{
	echo '<div class="layout-box"><p class="layout-box"><span> '.$this->get_translation('TOCTitle').' '.$this->link($ppage, '', $legend).' </span></p>';
}

if ($_page)
{
	if (!$this->has_access('read', $_page['page_id']))
	{
		echo $this->get_translation('ReadAccessDenied');
	}
	else
	{
		$toc = $this->build_toc($context, $start_depth, $end_depth, $numerate, $link);
		{
			// ---------------------- toc numeration ------------------------
			// identify what size where faces
			$toc_len	= count($toc);
			$numbers	= array();
			$depth		= 0;

			for($i = 0; $i < $toc_len; $i++)
			{
				// neither '(p)' nor '(include)'
				if ($toc[$i][2] < 66666)
				{
					// normalized depth immersion
					$toc[$i][4] = $toc[$i][2] - $start_depth + 1;

					if ($numerate)
					{
						$_level = $toc[$i][2];

						// if dive deeper, reset the meter for new depths
						while ($_level > $depth)
						{
							$numbers[ $_level] = 0;

							$_level--;
						}

						// if left lower level, nothing else to do.
						// store and increase the depth meter item
						$depth = $toc[$i][4];

						$numbers[$depth]++;

						// add missing levels if level starts with missing parent level
						if ($depth > 0)
						{
							$_depth = $depth;

							while ($_depth > 0)
							{
								if (!isset($numbers[$_depth]) || (isset($numbers[$_depth]) && $numbers[$_depth] == 0 ))
								{
									$numbers[$_depth]		= 1;
									$this->_depth[$_depth]	= 1;
								}

								ksort($numbers);

								$_depth--;
							}
						}

						// collect numbering on the array of $ numbers from start to the current depth, allowing zero
						$num = '';

						for($j = 1; $j <= $depth; $j++)
						{
							if (isset($numbers[$j]) && $numbers[$j] > 0)
							{
								$num .= $numbers[$j].'.';
							}
						}

						// Human content TOC
						$toc[$i][5] = $num;					// toc number, e.g. 2.4.1
						$toc[$i][6] = $toc[$i][1];			// toc title

						$toc[$i][1] = $num.' '.$toc[$i][1]; // toc number + toc title

					}
					else
					{
						$toc[$i][6] = $toc[$i][1];			// toc title
					}
				}
			}

			// not bad in a cache write similar version
			$this->tocs[$context] = &$toc;

			// it is now necessary to place flag about the fact that good to in post_wacko
			// the source page, adding there
			if (!$ppage)
			{
				$this->post_wacko_toc			= &$toc;
				$this->post_wacko_action['toc']	= 1;
			}
		} // --------------------------------------------------------------

		// display!

		// begin list
		echo "\n<ul id=\"toc\">\n";

		$i			= 0;
		$ul			= 1;
		$li			= 0;
		$tabs		= '';
		$_tabs		= "\t";
		$_array_debug = '';

		// TODO: properly indent list elements
		$tabs[0]	= "";
		$tabs[1]	= "";
		$tabs[2]	= "\t";
		$tabs[3]	= "\t\t";
		$tabs[4]	= "\t\t\t";
		$tabs[5]	= "\t\t\t\t";
		$tabs[6]	= "\t\t\t\t\t";
		$tabs[7]	= "\t\t\t\t\t\t";
		$tabs[8]	= "\t\t\t\t\t\t\t";
		$tabs[9]	= "\t\t\t\t\t\t\t\t";
		$tabs[10]	= "\t\t\t\t\t\t\t\t\t";

		$ident_level['li'] = 1;
		$ident_level['ul'] = 1;

		foreach ($toc as $toc_item)
		{
			if (isset($toc_item[4]) && $toc_item[4])
			{
				if (!isset($prev_level)) $prev_level	= 0;

				// check page level
				$cur_level	= $toc_item[4];

				// indents (sublevels)
				if ($i >= 0)
				{
					// levels difference
					$diff = $cur_level - $prev_level;

					if ($diff > 0)
					{
						$j = 0;

						while ($diff > 0 && !(($diff == 1) && ($i == 0)))
						{
							# ONE
							// open nested list
							if (($diff !== 1 && $j !== 0) || ($j == 0 && $i == 0) || $j > 0)
							{
								// open nested <li> tag
								echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs.
									"<li>".
									#"<!--ONE: [".$ul."]: (".$j.") open nested list item-->".
									"\n";

									$ident_level['li']++;
							}

							echo $tabs[($ident_level['ul'] + $ul - 1)].$_tabs."\t".
								"<ul>".
								#"<!--ONE: [".$ul.']: '.$diff.'->('.$j.") open nested list-->".
								"\n";

								$ident_level['ul']++;

							$diff--;
							$ul++;
							$j++;
						}
					}
					else if ($diff < 0)
					{
						$k = 0;

						while ($diff < 0)
						{
							# TWO
							// close nested list
							if (($diff < 0 || $ul != 1) && $k == 0 )
							{
								// close nested <li> tag
								echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].
									"</li>".
									#"<!--TWO: close  list item-->".
									"\n";

									$ident_level['li']--;
							}

							echo $tabs[($ident_level['ul'] + $ul - 1)].
								"</ul>".
								#"<!--TWO: [".$ul.']: '.$diff.'->('.$k.") close nested list-->".
								"\n";

								$ident_level['ul']--;

							echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].
								"</li>\n";

								$ident_level['li']--;

							$diff++;
							$ul--;
							$k++;
						}
					}
					else
					{
						# THREE
						// close opened <li> tag
						echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].
							"</li>".
							#"<!--THREE: [".$ul.']: '."-->".
							"\n";

							$ident_level['li']--;
					}
				}

				# FOUR
				// open list item element
				echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs.
					"<li>".
					#"<!--FOUR: [".$ul."]: (".$i.")".$ident_level['li']." begin element-->".
					"\n";
				echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs."\t".
					'<a href="'.$toc_item[3].'#'.$toc_item[0].'">'.
						(!empty($numerate)
							?	'<span class="tocnumber">'.$toc_item[5].'</span>'
							:	'').
						'<span class="toctext">'.strip_tags($toc_item[6]).'</span></a>'."\n";

					$ident_level['li']++;

				// recheck page level
				$prev_level	= $toc_item[4];

				$i++;
			}
		}

		// close all opened nested <ul> tags
		if ($ul > 1)
		{
			$m = 0;

			while ($ul > 1)
			{
				# FIVE
				if ($m == 0)
				{
					// close nested <li> tag
					echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].
						"</li>".
						#"<!--FIVE: [".$ul.']: ('.$m.") close all nested <li> tags-->".
						"\n";

						$ident_level['li']--;
				}

				echo $tabs[($ident_level['ul'] + $ul - 1)].
					"</ul>".
					#"<!--FIVE: [".$ul.']: ('.$m.") close all opened <ul> tags-->".
					"\n";

					$ident_level['ul']--;

				echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].
					"</li>".
					#"<!--FIVE: [".$ul.']: ('.$m.") close all opened <li> tags-->".
					"\n";

					$ident_level['li']--;

				$ul--;
				$m++;
			}
		}
		else
		{
			# SIX
			// close opened <li> tag
			echo $tabs[$ident_level['li']].
				"</li>".
				#"<!--SIX:  [".$ul.']: '."-->".
				"\n";

				$ident_level['li']--;
		}

		// end list
		echo "</ul>\n";
	}
}
else
{
	echo $this->get_translation('DoesNotExists');
}

if (!$nomark)
{
	echo '</div>';
}

?>