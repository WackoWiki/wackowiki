<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 shows table of content

	{{toc
		page="!/SubTag"
		from="h2"
		to="h4"
		numerate=[0|1]
		start=[0|100]
		legend="alternate legend"
		nomark=[0|1]
	}}

 requires activated paragrafica formatter
 toc is generated in paragrafica format
*/

// set defaults
$from		??= '';
$legend		??= '';
$nomark		??= 0;
$numerate	??= 0;
$page		??= '';
$start		??= 0;
$to			??= '';

if ($page)
{
	$tag		= $this->unwrap_link($page);
	$ppage		= '/' . $tag;
	$context	= $tag;
	$_page		= $this->load_page($tag);

	if (!$legend)	$legend = $tag;
	if ($_page)		$link	= $this->href('', $_page['tag']);
}
else
{
	$tag		= '';
	$ppage		= '';
	$context	= $this->tag;
	$_page		= $this->page;
	$link		= '';
}

if ($start)		$start	= (int) $start;

if (!$from)		$from	= 'h2';
if (!$to)		$to		= 'h9';

$start_depth	= $from[1];
$end_depth		= $to[1];

// 3. output
if (!$nomark)
{
	echo '<nav class="layout-box">' .
			'<p><span> ' . $this->_t('TocTitle') . ' ' . $this->link($ppage, '', $legend) . ' </span></p>';
}

if ($_page)
{
	if (!$this->has_access('read', $_page['page_id']))
	{
		echo $this->_t('ReadAccessDenied');
	}
	else
	{
		if ($toc = $this->build_toc($context, $start_depth, $end_depth, $link))
		{
			// ---------------------- toc numeration ------------------------
			// find out which numbers are where
			$toc_len	= count($toc);
			$numbers	= [];
			$depth		= 0;

			for ($i = 0; $i < $toc_len; $i++)
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
							// uses $start for numbering
							if ($start && $numbers[$_level] == $numbers[1])
							{
								$numbers[$_level] = $start - 1;
							}
							else
							{
								$numbers[$_level] = 0;
							}

							$_level--;
						}

						// if left lower level, nothing else to do
						// store and increase the depth meter item
						$depth = $toc[$i][4];

						$numbers[$depth]++;

						// add missing levels, if level starts with missing parent level
						if ($depth > 0)
						{
							$_depth = $depth;

							while ($_depth > 0)
							{
								if (!isset($numbers[$_depth]) || (isset($numbers[$_depth]) && $numbers[$_depth] == 0))
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

						for ($j = 1; $j <= $depth; $j++)
						{
							if (isset($numbers[$j]) && $numbers[$j] > 0)
							{
								$num .= $numbers[$j] . '.';
							}
						}

						// human content TOC
						$toc[$i][5] = $num;					// toc number, e.g. 2.4.1
						$toc[$i][6] = $toc[$i][1];			// toc title

						$toc[$i][1] = $num . ' ' . $toc[$i][1]; // toc number + toc title

					}
					else
					{
						$toc[$i][6] = $toc[$i][1];			// toc title
					}
				}
			}

			// cache similar version
			$this->tocs[$context] = &$toc;

			// it is now necessary to set flag about the fact that good to in post_wacko source,
			// adding the numbers there
			if (!$ppage)
			{
				$this->post_wacko_toc			= &$toc;
				$this->post_wacko_action['toc']	= 1;
			}
		} // --------------------------------------------------------------

		// display!
		// begin list
		echo "\n" . '<ul id="toc">' . "\n";

		$i				= 0;
		$il				= [];	// ident level
		$il['li']		= 1;
		$il['ul']		= 1;
		$tab			= "\t";
		$ul				= 1;

		$prev_level		= 0;

		// properly indent list elements (start at level 2)
		$tabs = function ($level)
		{
			return ($level > 1
				? str_repeat("\t", $level - 1)
				: '');
		};

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
								echo $tabs(($il['li'] + $il['ul'] - 1)) . $tab .
									'<li>' . "\n";
									#"<!--ONE: [" . $ul . "]: (" . $j . ") open nested list item-->" .

								$il['li']++;
							}

							echo $tabs(($il['ul'] + $ul - 1)) . $tab . $tab .
								"<ul>" . "\n";
								#"<!--ONE: [" . $ul . ']: ' . $diff . '->(' . $j . ") open nested list-->" .

							$il['ul']++;
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
							if (($diff < 0 || $ul != 1) && $k == 0)
							{
								// close nested <li> tag
								echo $tabs(($il['li'] + $il['ul'] - 1)) .
									'</li>' . "\n";
									#"<!--TWO: close list item-->" .

								$il['li']--;
							}

							echo $tabs(($il['ul'] + $ul - 1)) .
								'</ul>' . "\n";
								#"<!--TWO: [" . $ul . ']: ' . $diff . '->(' . $k . ") close nested list-->" .

							$il['ul']--;

							echo $tabs(($il['li'] + $il['ul'] - 1)) .
								'</li>' . "\n";

							$il['li']--;
							$diff++;
							$ul--;
							$k++;
						}
					}
					else
					{
						# THREE
						// close opened <li> tag
						echo $tabs(($il['li'] + $il['ul'] - 1)) .
							'</li>' . "\n";
							#"<!--THREE: [" . $ul . ']: ' . "-->" .

						$il['li']--;
					}
				}

				# FOUR
				// open list item element
				echo $tabs(($il['li'] + $il['ul'] - 1)) . $tab .
					'<li>' . "\n";
					#"<!--FOUR: [" . $ul . "]: (" . $i . ")" . $il['li'] . " begin element-->" .

				echo $tabs(($il['li'] + $il['ul'] - 1)) . $tab . $tab .
					'<a href="' . $toc_item[3] . '#' . $toc_item[0] . '">' .
						(!empty($numerate)
							?	'<span class="tocnumber">' . $toc_item[5] . '</span>'
							:	'') .
						'<span class="toctext">' . strip_tags($toc_item[6]) . '</span></a>' . "\n";

					$il['li']++;

				// re-check page level
				$prev_level	= $toc_item[4];

				$i++;
			}
		}

		// close all nested <ul> tags
		if ($ul > 1)
		{
			$m = 0;

			while ($ul > 1)
			{
				# FIVE
				if ($m == 0)
				{
					// close nested <li> tag
					echo $tabs(($il['li'] + $il['ul'] - 1)) .
						'</li>' . "\n";
						#"<!--FIVE: [" . $ul . ']: (' . $m . ") close nested <li> tag-->" .

					$il['li']--;
				}

				echo $tabs(($il['ul'] + $ul - 1)) .
					'</ul>' . "\n";
					#"<!--FIVE: [" . $ul . ']: (' . $m . ") close nested <ul> tag-->" .

				$il['ul']--;

				echo $tabs(($il['li'] + $il['ul'] - 1)) .
					'</li>' . "\n";
					#"<!--FIVE: [" . $ul . ']: (' . $m . ") close nested <li> tag-->" .

				$il['li']--;
				$ul--;
				$m++;
			}
		}
		else
		{
			# SIX
			// close open <li> tag
			echo $tabs($il['li']) .
				'</li>' . "\n";
				#"<!--SIX:  [" . $ul . ']: ' . "-->" .

			$il['li']--;
		}

		// end list
		echo '</ul>' . "\n";
	}
}
else
{
	echo $this->_t('DoesNotExists');
}

if (!$nomark)
{
	echo "</nav>\n";
}

