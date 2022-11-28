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
if (!$to)		$to		= 'h6';

$start_depth	= (int) $from[1];
$end_depth		= (int) $to[1];

// 3. output
if (!$nomark)
{
	$tpl->mark			= true;
	$tpl->mark_cluster	= $this->link($ppage, '', $legend);
	$tpl->emark			= true;
}

if ($_page)
{
	if (!$this->has_access('read', $_page['page_id']))
	{
		$tpl->message = $this->_t('ReadAccessDenied');
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
						$level = $toc[$i][2];

						// if dive deeper, reset the meter for new depths
						while ($level > $depth)
						{
							// uses $start for numbering
							if ($start && $numbers[$level] == $numbers[1])
							{
								$numbers[$level] = $start - 1;
							}
							else
							{
								$numbers[$level] = 0;
							}

							$level--;
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
								if (!isset($numbers[$_depth]) || ($numbers[$_depth] == 0))
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
						$toc[$i][5] = $num;						// toc number, e.g. 2.4.1
						$toc[$i][6] = $toc[$i][1];				// toc title

						$toc[$i][1] = $num . ' ' . $toc[$i][1];	// toc number + toc title

					}
					else
					{
						$toc[$i][6] = $toc[$i][1];				// toc title
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

		$i				= 0;
		$ul				= 1;
		$prev_level		= 0;

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
								$tpl->enter('li_'); // (one)
								$tpl->commit = true;
							}

							// open nested list
							$tpl->enter('ul_'); // (one)
							$tpl->commit = true;

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
							if ($k == 0)
							{
								// close nested <li> tag
								$tpl->leave(); // li_ (two nested)
							}

							$tpl->leave(); // ul_ (two)
							$tpl->leave(); // li_ (two)

							$diff++;
							$ul--;
							$k++;
						}
					}
					else
					{
						# THREE
						// close opened <li> tag
						$tpl->leave(); // li_ (three)
					}
				}

				# FOUR
				// open list item element
				$tpl->enter('li_'); // (four)
				$tpl->commit = true;

				$tpl->enter('toc_');

				$tpl->href = $toc_item[3] . '#' . $toc_item[0];
				$tpl->i_item = strip_tags($toc_item[6]);

				if (!empty($numerate))
				{
					$tpl->n_number = $toc_item[5];
				}

				$tpl->leave(); // toc_

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
					$tpl->leave(); // li_ (five nested)
				}

				// close nested <ul> tag
				$tpl->leave(); // ul_ (five)

				// close nested <li> tag
				$tpl->leave(); // li_ (five)

				$ul--;
				$m++;
			}
		}
		else
		{
			# SIX
			// close open <li> tag
			$tpl->leave(); // li_ (six)
		}

		// end list
	}
}
else
{
	$tpl->message = $this->_t('DoesNotExists');
}
