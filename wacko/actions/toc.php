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
		$ul			= 0;
		$tabs		= '';
		$prev_level	= $start_depth + 1;

		foreach ($toc as $toc_item)
		{
			if (isset($toc_item[4]) && $toc_item[4])
			{
				// check page level
				$cur_level	= $toc_item[4];

				// indents (sublevels)
				if ($i >= 0)
				{
					// levels difference
					$diff = $cur_level - $prev_level;

					#echo '  ['.$i.'] '.$cur_level.' - '.$prev_level.' = '.$diff.'<br />';

					if ($diff > 0)
					{
						while ($diff > 0)
						{
							echo "\t<li>\n\t\t<ul>\n";	// open nested list
							$diff--;
							$ul++;
						}
					}
					else if (($diff < 0) && ($i == 0))
					{
						while ($diff < 0)
						{
							echo "\t<li>\n\t\t<ul>\n";	// open nested list
							$diff++;
							$ul++;
						}
					}
					else if ($diff < 0)
					{
						while ($diff < 0)
						{
							echo $tabs."</li>\n\t\t</ul>\n\t</li>\n\n\n";	// close nested list
							$diff++;
							$ul--;
						}
					}
					else
					{
						echo "\t</li>\n";
					}
				}

				// begin element
				while ($ul +1 > 0)
				{
					$tabs .= "\t";
					$ul--;
				}
				echo $tabs."<li>\n";

					echo $tabs."\t".'<a href="'.$toc_item[3].'#'.$toc_item[0].'">'.
							(!empty($numerate)
								?	'<span class="tocnumber">'.$toc_item[5].'</span>'
								:	'').
							'<span class="toctext">'.strip_tags($toc_item[6]).'</span></a>'."\n";

				// recheck page level
				$prev_level	= $toc_item[4];

				$i++;
			}
		}

		// close all opened <ul> tags
		if ($ul > 0)
		{
			while ($ul > 0)
			{
				echo "\n\t\t</ul>\n\t</li>\n\n";
				$ul--;
			}
		}
		else
		{
			echo $tabs."</li>\n";
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