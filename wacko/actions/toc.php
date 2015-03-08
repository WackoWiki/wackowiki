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

if (!$from)	$from	= 'h2';
if (!$to)	$to		= 'h9';

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

			#$this->debug_print_r($toc);

			for($i = 0; $i < $toc_len; $i++)
			{
				// neither '(p)' nor '(include)'
				if ($toc[$i][2] < 66666)
				{
					// normalized depth immersion
					$toc[$i][4] = $toc[$i][2] - $start_depth + 1;

					if ($numerate)
					{
						// if dive deeper, reset the meter for new depths
						if ($toc[$i][2] > $depth)
						{
							$numbers[ $toc[$i][2] ] = 0;
						}

						// if left lower level, nothing else to do.
						// store and increase the depth meter item
						$depth = $toc[$i][2];

						// add missing levels if level starts with missing parent level
						if ($depth > 0)
						{
							$_depth = $depth;

							while ($_depth > 0 && !isset($this->_depth[$_depth]))
							{
								if (!isset($numbers[$_depth]))
								{
									$numbers[$_depth] = 1;
									$this->_depth[$_depth] = 1;
								}

								$_depth--;
							}
						}

						$numbers[$depth]++;

						#echo $numbers[$depth].'-'.$depth.'<br />';
						#$this->debug_print_r($numbers);

						// collect numbering on the array of $ numbers from start to the current depth, allowing zero
						$num = '';

						for($j = 1; $j <= $depth; $j++)
						{
							#echo $depth.'->>'.$numbers[$j].'<br />';

							if (isset($numbers[$j]) && $numbers[$j] > 0)
							{
								$num .= $numbers[$j].'.';

								#echo $depth.'->>'.$num.'<br />';
							}
						}

						// Human content TOC
						$toc[$i][5] = $num; // toc number
						$toc[$i][6] = $toc[$i][1]; // toc text

						$toc[$i][1] = $num.' '.$toc[$i][1];

					}
					else
					{
						$toc[$i][6] = $toc[$i][1];
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

		#$this->debug_print_r($toc);

		// display!

		// begin list
		echo "\n<ul id=\"toc\">\n";

		$i			= 0;
		$ul			= 1;
		$li			= 0;
		$tabs		= '';
		$_array_debug = '';

		// TODO: properly indent list elements?
		$tabs[0] = "";
		$tabs[1] = "";
		$tabs[2] = "\t";
		$tabs[3] = "\t\t";
		$tabs[4] = "\t\t\t";
		$tabs[5] = "\t\t\t\t";
		$tabs[6] = "\t\t\t\t\t";
		$tabs[7] = "\t\t\t\t\t\t";
		$tabs[8] = "\t\t\t\t\t\t\t";
		$tabs[9] = "\t\t\t\t\t\t\t\t";
		$tabs[10] = "\t\t\t\t\t\t\t\t\t";
		$_tabs = "\t";

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

					$_array_debug .= '<br />  ['.$i.'] '.$cur_level.' - '.$prev_level.' = '.$diff."<br />\n"; // debug

					if ($diff > 0)
					{
						$j = 0;

						while ($diff > 0 && !(($diff == 1) && ($i == 0)))
						{
							if ($ul > 1)
							{
								#$_tabs = "\t\t\t"; #<!--[".$ul."]: (".$i.") only-->
							}

							# ONE
							// open nested list
							if (($diff !== 1 && $j !== 0) || ($j == 0 && $i == 0) || $j > 0)
							{
								// open nested <li> tag
								echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs."<li><!--ONE: [".$ul."]: (".$j.") open nested list item-->\n";

								$ident_level['li']++;
							}

							echo		$tabs[($ident_level['ul'] + $ul - 1)].$_tabs."\t<ul><!--ONE: [".$ul.']: '.$diff.'->('.$j.") open nested list-->\n";

							$diff--;
							$ul++;
							$j++;

							$ident_level['ul']++;
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
								echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)]."</li><!--TWO: close  list item-->\n";

								$ident_level['li']--;
							}

							echo	$tabs[($ident_level['ul'] + $ul - 1)]."</ul><!--TWO: [".$ul.']: '.$diff.'->('.$k.") close nested list-->\n";
							$ident_level['ul']--;

							echo		$tabs[($ident_level['li'] + $ident_level['ul'] - 1)]."</li>\n";
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
						echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)]."</li><!--THREE: [".$ul.']: '."-->\n";

						$ident_level['li']--;
					}
				}

				# FOUR
				// open list item element

				if ($ul > 1)
				{
					#$_tabs = "\t\t"; #<!--[".$ul."]: (".$i.") only-->
				}

				echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs."<li><!--FOUR: [".$ul."]: (".$i.")".$ident_level['li']." begin element-->\n";
				echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)].$_tabs."\t".'<a href="'.$toc_item[3].'#'.$toc_item[0].'">'.
							(!empty($numerate)
								?	'<span class="tocnumber">'.$toc_item[5].'</span>'
								:	'').
							'<span class="toctext">'.strip_tags($toc_item[6]).'</span></a>'."\n";

				// recheck page level
				$prev_level	= $toc_item[4];

				$i++;

				$ident_level['li']++;
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
					echo $tabs[($ident_level['li'] + $ident_level['ul'] - 1)]."</li><!--FIVE: [".$ul.']: ('.$m.") close all nested <li> tags-->\n";

					$ident_level['li']--;
				}

				echo	$tabs[($ident_level['ul'] + $ul - 1)]."</ul><!--FIVE: [".$ul.']: ('.$m.") close all opened <ul> tags-->\n";
				$ident_level['ul']--;
				echo	$tabs[($ident_level['li'] + $ident_level['ul'] - 1)]."</li><!--FIVE: [".$ul.']: ('.$m.") close all opened <li> tags-->\n";
				$ident_level['li']--;

				$ul--;
				$m++;
			}
		}
		else
		{
			# SIX
			// close opened <li> tag
			echo $tabs[$ident_level['li']]."</li><!--SIX:  [".$ul.']: '."-->\n";

			$ident_level['li']--;
		}

		// end list
		echo "</ul>\n";

		#echo $_array_debug;
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