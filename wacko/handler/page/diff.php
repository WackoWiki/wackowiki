<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<div id="page">';
$include_tail = '</div>';

if (!isset($_GET['a']) || !isset($_GET['b']))
{
	$this->redirect($this->href());
}

$a			= (int)$_GET['a'];
$b			= (int)$_GET['b'];
$diffmode	= (int)@$_GET['diffmode'];

if ($a == $b)
{
	echo "<br />\n" . $this->get_translation('NoDifferences');
	return;
}

$load_diff_page = function ($id)
{
	// extracting
	if ($id > 0)
	{
		return $this->load_single(
			"SELECT r.page_id, r.revision_id, r.modified, r.body, r.page_lang, u.user_name ".
			"FROM ".$this->config['table_prefix']."revision r ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (r.user_id = u.user_id) ".
			"WHERE r.revision_id = '".(int)$id."' ".
			"LIMIT 1");
	}
	else
	{
		return $this->load_single(
			"SELECT p.page_id, 0 AS revision_id, p.modified, p.body, p.page_lang, u.user_name ".
			"FROM ".$this->config['table_prefix']."page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"WHERE p.page_id = '".$this->get_page_id()."' ".
			"LIMIT 1");
	}
};

$page_a = $load_diff_page($b); // STS: why page_a <- b ?!
$page_b = $load_diff_page($a);

if ($this->has_access('read', $page_a['page_id']) && $this->has_access('read', $page_b['page_id']) )
{
	// diffmode
	// 0 - full diff
	// 1 - simple diff
	// 2 - source diff

	// print header
	echo perc_replace('<div class="diffinfo">' . $this->get_translation('Comparison'),
		'<a href="' . $this->href('', '', ($b > 0 ? 'revision_id=' . $page_a['revision_id'] : '')) . '">' . $this->get_time_formatted($page_a['modified']) . '</a>',
		'<a href="' . $this->href('', '', ($a > 0 ? 'revision_id=' . $page_b['revision_id'] : '')) . '">' . $this->get_time_formatted($page_b['modified']) . '</a>',
		$this->compose_link_to_page($this->tag, '', '', 0)) . "</div>\n";

	// print navigation
	$params = 'a=' .$a . '&amp;b=' .$b . '&amp;diffmode=';

	$show_mode = function($mode, $text) use ($diffmode, $params)
	{
		if (($text1 = $this->get_translation($text))) // STS
			$text = $text1;
		return ($diffmode != $mode
			?	'<li><a href="' . $this->href('diff', '', $params . $mode) . '">' . $text . '</a>'
			:	'<li class="active">' . $text) . '</li>';
	};

	echo '<!--nomail-->'.
	'<ul class="menu">'.
		$show_mode(0, 'FullDiff').
		$show_mode(1, 'SimpleDiff').
		$show_mode(2, 'SourceDiff').
		$show_mode(3, 'side by side'). // TODO: texts
		$show_mode(4, 'inline').
		$show_mode(5, 'unified').
	'</ul>'.
	'<!--/nomail-->';

	switch ($diffmode)
	{
	case 1:
	case 2:
		$source = ($diffmode == 2);

		// This is a really cheap way to do it.
		// prepare bodies
		$body_a		= explode("\n", $page_b['body']);
		$body_b		= explode("\n", $page_a['body']);

		$added		= array_diff($body_a, $body_b);
		$deleted	= array_diff($body_b, $body_a);
		$charset	= $this->get_charset($page_a['page_lang']);

		if ($added)
		{
			// remove blank lines
			echo "<br />\n" . $this->get_translation('SimpleDiffAdditions') . "<br />\n\n";
			echo '<div class="additions">';
			echo $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $added), ENT_COMPAT | ENT_HTML401, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $added), 'wiki', array('diff' => true));
			echo "</div>\n";
		}

		if ($deleted)
		{
			echo "<br />\n\n" . $this->get_translation('SimpleDiffDeletions') . "<br />\n\n";
			echo '<div class="deletions">';
			echo $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $deleted), ENT_COMPAT | ENT_HTML401, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $deleted), 'wiki', array('diff' => true));
			echo "</div>\n";
		}

		if (!$added && !$deleted)
		{
			echo "<br />\n" . $this->get_translation('NoDifferences');
		}
		break;

	case 0:
		require_once($this->config['handler_path'] . '/page/_diff.php');
		// load pages

		// extract text from bodies
		$text_a		= $page_a['body'];
		$text_b		= $page_b['body'];

		$side_a		= new Side($text_a);
		$side_b		= new Side($text_b);

		$body_a		= '';
		$side_a->split_file_into_words($body_a);

		$body_b		= '';
		$side_b->split_file_into_words($body_b);

		// diff on these two file
		$diff		= new Diff2(explode("\n", $body_a), explode("\n", $body_b));

		// format output
		$fmt		= new DiffFormatter();

		$side_o		= new Side($fmt->format($diff));

		$resync_left	= 0;
		$resync_right	= 0;

		$count_total_right = $side_b->getposition();

		$side_a->init();
		$side_b->init();

		while (1)
		{
			$side_o->skip_line();

			if ($side_o->isend())
			{
				break;
			}

			if ($side_o->decode_directive_line())
			{
				$argument	= $side_o->getargument();
				$letter		= $side_o->getdirective();

				switch ($letter)
				{
					case 'a':
						$resync_left	= $argument[0];
						$resync_right	= $argument[2] - 1;
						break;

					case 'd':
						$resync_left	= $argument[0] - 1;
						$resync_right	= $argument[2];
						break;

					case 'c':
						$resync_left	= $argument[0] - 1;
						$resync_right	= $argument[2] - 1;
						break;
				}

				$side_a->skip_until_ordinal($resync_left);
				$side_b->copy_until_ordinal($resync_right, $output);

				if ($letter == 'd' || $letter == 'c')
				{
					// deleted word
					$side_a->copy_whitespace($output);
					$output .= '<!--markup:1:begin-->';
					$side_a->copy_word($output);
					$side_a->copy_until_ordinal($argument[1], $output);
					$output .= '<!--markup:1:end-->';
				}

				if ($letter == 'a' || $letter == 'c')
				{
					// inserted word
					$side_b->copy_whitespace($output);
					$output .= '<!--markup:2:begin-->';
					$side_b->copy_word($output);
					$side_b->copy_until_ordinal($argument[3], $output);
					$output .= '<!--markup:2:end-->';
				}
			}
		}

		$side_b->copy_until_ordinal($count_total_right, $output);
		$side_b->copy_whitespace($output);

		echo '<br /><br />';
		echo $this->format($output, 'wiki', array('diff' => true));
		break;

	case 3:
	case 4:
	case 5:
		$this->add_html_head('<link rel="stylesheet" href="' . $this->config['theme_url'] . 'css/diff.css" type="text/css"/>'); // STS

		$diff = new Diff(explode("\n", $page_a['body']), explode("\n", $page_b['body']));
		$changes = $diff->render(new Diff_Renderer_Html_Array);

		echo '<br /><br />';

		if (empty($changes)) {
			echo $this->get_translation('NoDifferences');
			break;
		}

		// html generator code inlined from php-diff library which copyrights can be found in lib/php-diff folder
		if ($diffmode == 3)
		{
			echo '<table class="Differences DifferencesSideBySide">';
			/*echo '<thead>';
			echo '<tr>';
			echo '<th colspan="2">' . $this->get_time_formatted($page_a['modified']) . '</th>';
			echo '<th colspan="2">' . $this->get_time_formatted($page_b['modified']) . '</th>';
			echo '</tr>';
			echo '</thead>';*/
			foreach ($changes as $i => $blocks)
			{
				if ($i > 0)
				{
					echo '<tbody class="Skipped">';
					echo '<th>&hellip;</th><td>&nbsp;</td>';
					echo '<th>&hellip;</th><td>&nbsp;</td>';
					echo '</tbody>';
				}

				foreach ($blocks as $change)
				{
					echo '<tbody class="Change'.ucfirst($change['tag']).'">';
					// Equal changes should be shown on both sides of the diff
					if ($change['tag'] == 'equal')
					{
						foreach ($change['base']['lines'] as $no => $line)
						{
							$fromLine = $change['base']['offset'] + $no + 1;
							$toLine = $change['changed']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>'.$fromLine.'</th>';
							echo '<td class="Left"><span>'.$line.'</span>&nbsp;</span></td>';
							echo '<th>'.$toLine.'</th>';
							echo '<td class="Right"><span>'.$line.'</span>&nbsp;</span></td>';
							echo '</tr>';
						}
					}
					// Added lines only on the right side
					else if ($change['tag'] == 'insert')
					{
						foreach ($change['changed']['lines'] as $no => $line)
						{
							$toLine = $change['changed']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>&nbsp;</th>';
							echo '<td class="Left">&nbsp;</td>';
							echo '<th>'.$toLine.'</th>';
							echo '<td class="Right"><ins>'.$line.'</ins>&nbsp;</td>';
							echo '</tr>';
						}
					}
					// Show deleted lines only on the left side
					else if ($change['tag'] == 'delete')
					{
						foreach ($change['base']['lines'] as $no => $line)
						{
							$fromLine = $change['base']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>'.$fromLine.'</th>';
							echo '<td class="Left"><del>'.$line.'</del>&nbsp;</td>';
							echo '<th>&nbsp;</th>';
							echo '<td class="Right">&nbsp;</td>';
							echo '</tr>';
						}
					}
					// Show modified lines on both sides
					else if ($change['tag'] == 'replace')
					{
						if (count($change['base']['lines']) >= count($change['changed']['lines']))
						{
							foreach ($change['base']['lines'] as $no => $line)
							{
								$fromLine = $change['base']['offset'] + $no + 1;
								echo '<tr>';
								echo '<th>'.$fromLine.'</th>';
								echo '<td class="Left"><span>'.$line.'</span>&nbsp;</td>';
								if (!isset($change['changed']['lines'][$no]))
								{
									$toLine = '&nbsp;';
									$changedLine = '&nbsp;';
								}
								else
								{
									$toLine = $change['base']['offset'] + $no + 1;
									$changedLine = '<span>'.$change['changed']['lines'][$no].'</span>';
								}
								echo '<th>'.$toLine.'</th>';
								echo '<td class="Right">'.$changedLine.'</td>';
								echo '</tr>';
							}
						}
						else
						{
							foreach ($change['changed']['lines'] as $no => $changedLine)
							{
								if (!isset($change['base']['lines'][$no]))
								{
									$fromLine = '&nbsp;';
									$line = '&nbsp;';
								}
								else
								{
									$fromLine = $change['base']['offset'] + $no + 1;
									$line = '<span>'.$change['base']['lines'][$no].'</span>';
								}
								echo '<tr>';
								echo '<th>'.$fromLine.'</th>';
								echo '<td class="Left"><span>'.$line.'</span>&nbsp;</td>';
								$toLine = $change['changed']['offset'] + $no + 1;
								echo '<th>'.$toLine.'</th>';
								echo '<td class="Right">'.$changedLine.'</td>';
								echo '</tr>';
							}
						}
					}
					echo '</tbody>';
				}
			}
			echo '</table>';
		}
		else if ($diffmode == 4)
		{
			echo '<table class="Differences DifferencesInline">';
			/*echo '<thead>';
			echo '<tr>';
			echo '<th>Old</th>';
			echo '<th>New</th>';
			echo '<th>Differences</th>';
			echo '</tr>';
			echo '</thead>';*/
			foreach ($changes as $i => $blocks)
			{
				// If this is a separate block, we're condensing code so output ...,
				// indicating a significant portion of the code has been collapsed as
				// it is the same
				if ($i > 0)
				{
					echo '<tbody class="Skipped">';
					echo '<th>&hellip;</th>';
					echo '<th>&hellip;</th>';
					echo '<td>&nbsp;</td>';
					echo '</tbody>';
				}

				foreach ($blocks as $change)
				{
					echo '<tbody class="Change'.ucfirst($change['tag']).'">';
					// Equal changes should be shown on both sides of the diff
					if ($change['tag'] == 'equal')
					{
						foreach ($change['base']['lines'] as $no => $line)
						{
							$fromLine = $change['base']['offset'] + $no + 1;
							$toLine = $change['changed']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>'.$fromLine.'</th>';
							echo '<th>'.$toLine.'</th>';
							echo '<td class="Left">'.$line.'</td>';
							echo '</tr>';
						}
					}
					// Added lines only on the right side
					else if ($change['tag'] == 'insert')
					{
						foreach ($change['changed']['lines'] as $no => $line)
						{
							$toLine = $change['changed']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>&nbsp;</th>';
							echo '<th>'.$toLine.'</th>';
							echo '<td class="Right"><ins>'.$line.'</ins>&nbsp;</td>';
							echo '</tr>';
						}
					}
					// Show deleted lines only on the left side
					else if ($change['tag'] == 'delete')
					{
						foreach ($change['base']['lines'] as $no => $line)
						{
							$fromLine = $change['base']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>'.$fromLine.'</th>';
							echo '<th>&nbsp;</th>';
							echo '<td class="Left"><del>'.$line.'</del>&nbsp;</td>';
							echo '</tr>';
						}
					}
					// Show modified lines on both sides
					else if ($change['tag'] == 'replace')
					{
						foreach ($change['base']['lines'] as $no => $line)
						{
							$fromLine = $change['base']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>'.$fromLine.'</th>';
							echo '<th>&nbsp;</th>';
							echo '<td class="Left"><span>'.$line.'</span></td>';
							echo '</tr>';
						}

						foreach ($change['changed']['lines'] as $no => $line)
						{
							$toLine = $change['changed']['offset'] + $no + 1;
							echo '<tr>';
							echo '<th>&nbsp;</th>';
							echo '<th>'.$toLine.'</th>';
							echo '<td class="Right"><span>'.$line.'</span></td>';
							echo '</tr>';
						}
					}
					echo '</tbody>';
				}
			}
			echo '</table>';
		}
		else
		{
			// standard unified diff, useful for sending in emails or what
			echo '<pre>';
			foreach ($diff->getGroupedOpcodes() as $group)
			{
				$lastItem = count($group)-1;
				$i1 = $group[0][1];
				$i2 = $group[$lastItem][2];
				$j1 = $group[0][3];
				$j2 = $group[$lastItem][4];

				if ($i1 == 0 && $i2 == 0)
				{
					$i1 = -1;
					$i2 = -1;
				}

				echo '@@ -' . ($i1 + 1) . ',' . ($i2 - $i1) . ' +' . ($j1 + 1) . ',' . ($j2 - $j1) . " @@\n";
				foreach ($group as $code)
				{
					list($tag, $i1, $i2, $j1, $j2) = $code;
					if ($tag == 'equal')
					{
						echo ' ' . implode("\n ", $diff->GetA($i1, $i2)) . "\n";
					}
					else
					{
						if ($tag == 'replace' || $tag == 'delete')
						{
							echo '-' . implode("\n-", $diff->GetA($i1, $i2)) . "\n";
						}

						if ($tag == 'replace' || $tag == 'insert')
						{
							echo '+' . implode("\n+", $diff->GetB($j1, $j2)) . "\n";
						}
					}
				}
			}
			echo '</pre>';
		}
		break;
	}
}
else
{
	$this->show_message($this->get_translation('ReadAccessDenied'), 'info');
}
