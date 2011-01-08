<div id="page">
<?php

$output = '';
$source = '';

if (!function_exists('handler_diff_load_page_by_id'))
{
	function handler_diff_load_page_by_id($wacko, $id)
	{
		// extracting
		if ($id != "-1")
		{
			return $wacko->load_single(
				"SELECT page_id, revision_id, modified, body ".
				"FROM ".$wacko->config['table_prefix']."revision ".
				"WHERE revision_id = '".quote($wacko->dblink, $id)."' ".
				"LIMIT 1");
		}
		else
		{
			return $wacko->load_single(
				"SELECT page_id, page_id AS revision_id, modified, body ".
				"FROM ".$wacko->config['table_prefix']."page ".
				"WHERE page_id = '".quote($wacko->dblink, $wacko->get_page_id())."' ".
				"LIMIT 1");
		}
	}
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

$a = $_GET['a'];
$b = $_GET['b'];

// If asked, call original diff
if ($this->has_access('read'))
{
	$page_a = handler_diff_load_page_by_id($this, $b);
	$page_b = handler_diff_load_page_by_id($this, $a);

	if ($this->has_access('read', $page_a['page_id']) && $this->has_access('read', $page_b['page_id']) )
	{
		if (isset($_GET['source']))
		{
			$source = 1;
		}

		if (isset($_GET['fastdiff']) || $source == 1)
		{
			// This is a really cheap way to do it.

			// prepare bodies
			$body_a = explode("\n", $page_b['body']);
			$body_b = explode("\n", $page_a['body']);

			$added = array_diff($body_a, $body_b);
			$deleted = array_diff($body_b, $body_a);

			$output .=
			str_replace('%1', "<a href=\"".$this->href('', '', ($b != -1 ? 'revision_id='.$page_a['revision_id'] : ''))."\">".$this->get_time_string_formatted($page_a['modified'])."</a>",
			str_replace('%2', "<a href=\"".$this->href('', '', ($a != -1 ? 'revision_id='.$page_b['revision_id'] : ''))."\">".$this->get_time_string_formatted($page_b['modified'])."</a>",
			str_replace('%3', $this->compose_link_to_page($this->tag, "", "", 0),
			"<div class=\"diffinfo\">".$this->get_translation('Comparison'))))."</div><br />\n";

			if ($added)
			{
				// remove blank lines
				$output .= "<br />\n".$this->get_translation('SimpleDiffAdditions')."<br />\n\n";
				$output .= "<div class=\"additions\">".($source == 1
															? '<pre>'.wordwrap(implode("\n", $added), 70, "\n", 1).'</pre>'
															: $this->format(implode("\n", $added))
														)."</div>";
			}

			if ($deleted)
			{
				$output .= "<br />\n\n".$this->get_translation('SimpleDiffDeletions')."<br />\n\n";
				$output .= "<div class=\"deletions\">".($source == 1
															? '<pre>'.wordwrap(implode("\n", $deleted), 70, "\n", 1).'</pre>'
															: $this->format(implode("\n", $deleted))
														)."</div>";
			}

			if (!$added && !$deleted)
			{
				$output .= "<br />\n".$this->get_translation('NoDifferences');
			}

			echo $output;
		}
		else
		{
			require_once('handlers/page/_diff.php');
			// load pages

			// extract text from bodies
			$text_a = $page_a['body'];
			$text_b = $page_b['body'];

			$side_a = new Side($text_a);
			$side_b = new Side($text_b);

			$body_a = '';
			$side_a->split_file_into_words($body_a);

			$body_b = '';
			$side_b->split_file_into_words($body_b);

			// diff on these two file
			$diff = new Diff(explode("\n", $body_a), explode("\n", $body_b));

			// format output
			$fmt = new DiffFormatter();

			$side_o = new Side($fmt->format($diff));

			$resync_left = 0;
			$resync_right = 0;

			$count_total_right = $side_b->getposition();

			$side_a->init();
			$side_b->init();

			$output = '';

			while (1)
			{
				$side_o->skip_line();

				if ($side_o->isend())
				{
					break;
				}

				if ($side_o->decode_directive_line())
				{
					$argument = $side_o->getargument();
					$letter = $side_o->getdirective();

					switch ($letter)
					{
						case 'a':
							$resync_left = $argument[0];
							$resync_right = $argument[2] - 1;
							break;

						case 'd':
							$resync_left = $argument[0] - 1;
							$resync_right = $argument[2];
							break;

						case 'c':
							$resync_left = $argument[0] - 1;
							$resync_right = $argument[2] - 1;
							break;
					}

					$side_a->skip_until_ordinal($resync_left);
					$side_b->copy_until_ordinal($resync_right,$output);

					if ($letter == 'd' || $letter == 'c')
					{
						// deleted word
						$side_a->copy_whitespace($output);
						$output .= "<!--markup:1:begin-->";
						$side_a->copy_word($output);
						$side_a->copy_until_ordinal($argument[1],$output);
						$output .= "<!--markup:1:end-->";
					}

					if ($letter == 'a' || $letter == 'c')
					{
						// inserted word
						$side_b->copy_whitespace($output);
						$output .= "<!--markup:2:begin-->";
						$side_b->copy_word($output);
						$side_b->copy_until_ordinal($argument[3],$output);
						$output .= "<!--markup:2:end-->";
					}
				}
			}

			$side_b->copy_until_ordinal($count_total_right,$output);
			$side_b->copy_whitespace($output);
			$out = $this->format($output);
			$out = str_replace('%1', "<a href=\"".$this->href('', '', 'revision_id='.$page_b['revision_id'])."\">".$this->get_time_string_formatted($page_b['modified'])."</a>",
			str_replace('%2', "<a href=\"".$this->href('', '', 'revision_id='.$page_a['revision_id'])."\">".$this->get_time_string_formatted($page_a['modified'])."</a>",
			str_replace('%3', $this->compose_link_to_page($this->tag, "", "", 0),
			"<div class=\"diffinfo\">".$this->get_translation('Comparison'))))."</div><br />\n<br />\n".$out;
			echo $out;
		}
	}
	else
	{
		echo $this->get_translation('ReadAccessDenied');
	}
}
else
{
	echo $this->get_translation('ReadAccessDenied');
}

?>
</div>