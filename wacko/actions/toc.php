<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{toc page|for="!/SubTag" from="h2" to="h4" numerate=[0|1] legend="alternate legend" nomark=[0|1] }}
*/
// 1. check for first param (for what TOC is built)

if (!isset($nomark))	$nomark = '';
if (!isset($for))		$for = '';
if (!isset($from))		$from = '';
if (!isset($page))		$page = '';
if (!isset($numerate))	$numerate = '';
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

			for($i = 0; $i < $toc_len; $i++)
			{
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
						$numbers[ $depth ]++;
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
						$toc[$i][5] = $num;
					}
				}
			}

			// not bad in a cache write similar version
			$this->tocs[ $context ] = &$toc;

			// it is now necessary to place flag about the fact that good to [iskurochit] in Post-[vake]
			// the source page, adding there [tsyfirki]
			if (!$ppage)
			{
				$this->post_wacko_toc			= &$toc;
				$this->post_wacko_action['toc']	= 1;
			}
		} // --------------------------------------------------------------

		#$this->debug_print_r($toc);

		// display!

		// XXX: only for reference
		/* foreach($toc as $toc_item)
		{
			if (isset($toc_item[4]) && $toc_item[4])
			{
				echo '<div class="toc'.$toc_item[4].'">';
				echo '<a href="'.$toc_item[3].'#'.$toc_item[0].'">'.$toc_item[5].' '.strip_tags($toc_item[1]).'</a>';
				echo '</div>';
			}
		} */
		//$this->tocRecursion( ($ppage ? $this->href('', $ppage) : ''), $toc_body, 2 );

		// begin list
		echo "\n<ul id=\"toc\">\n";

		$i	= 0;
		$ul	= 0;

		foreach ($toc as $toc_item)
		{
			if (isset($toc_item[4]) && $toc_item[4])
			{
				// check page level
				$curlevel	= $toc_item[4];

				// indents (sublevels)
				if ($i > 0)
				{
					// levels difference
					$diff = $curlevel - $prevlevel;

					if ($diff > 0)
					{
						while ($diff > 0)
						{
							echo "\n<ul>\n";	// open nested list
							$diff--;
							$ul++;
						}
					}
					else if ($diff < 0)
					{
						while ($diff < 0)
						{
							echo "\n</ul>\n</li>\n";	// close nested list
							$diff++;
							$ul--;
						}
					}
					else
					{
						echo "</li>\n";
					}
				}

				// begin element
				echo '<li>';

					echo '<a href="'.$toc_item[3].'#'.$toc_item[0].'"><span class="tocnumber">'.$toc_item[5].'</span><span class="toctext">'.strip_tags($toc_item[1]).'</span></a>';

				// recheck page level
				$prevlevel	= $toc_item[4];

				$i++;
			}
		}

		// close all opened <ul> tags
		if ($ul > 0)
		{
			while ($ul > 0)
			{
				echo "</ul>\n</li>\n";
				$ul--;
			}
		}
		else
		{
			echo "</li>\n";
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