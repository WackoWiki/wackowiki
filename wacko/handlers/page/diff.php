<div id="page">
<?php

$output = "";
$source = "";

if (!function_exists('handler_diff_load_page_by_id'))
{
	function handler_diff_load_page_by_id($wacko, $id)
	{
		// extracting
		if ($id != "-1")
		{
			return $wacko->load_single(
				"SELECT page_id, modified, body ".
				"FROM ".$wacko->config['table_prefix']."revision ".
				"WHERE revision_id = '".quote($wacko->dblink, $id)."' ".
				"LIMIT 1");
		}
		else
		{
			return $wacko->load_single(
				"SELECT page_id, modified, body ".
				"FROM ".$wacko->config['table_prefix']."page ".
				"WHERE page_id = '".quote($wacko->dblink, $wacko->get_page_id())."' ".
				"LIMIT 1");
		}
	}
}

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href("show"));

	$a = $_GET["a"];
	$b = $_GET["b"];

// If asked, call original diff
if ($this->has_access("read")) {

	$pageA = handler_diff_load_page_by_id($this, $b);
	$pageB = handler_diff_load_page_by_id($this, $a);

	if ($this->has_access("read", $pageA['page_id']) && $this->has_access("read", $pageB['page_id']) ) {

		if (isset($_GET["source"])) $source = 1;

		if (isset($_GET["fastdiff"]) || $source == 1) {

			// This is a really cheap way to do it.

			// prepare bodies
			$bodyA = explode("\n", $pageB['body']);
			$bodyB = explode("\n", $pageA['body']);

			$added = array_diff($bodyA, $bodyB);
			$deleted = array_diff($bodyB, $bodyA);

			$output .=
			str_replace("%1", "<a href=\"".$this->href("", "", ($b != -1 ? "time=".urlencode($pageA['modified']) : ""))."\">".$this->get_time_string_formatted($pageA['modified'])."</a>",
			str_replace("%2", "<a href=\"".$this->href("", "", ($a != -1 ? "time=".urlencode($pageB['modified']) : ""))."\">".$this->get_time_string_formatted($pageB['modified'])."</a>",
			str_replace("%3", $this->compose_link_to_page($this->tag, "", "", 0),
			"<div class=\"diffinfo\">".$this->get_translation("Comparison"))))."</div><br />\n";

			if ($added)
			{
				// remove blank lines
				$output .= "<br />\n".$this->get_translation("SimpleDiffAdditions")."<br />\n\n";
				$output .= "<div class=\"additions\">".($source == 1
															? '<pre>'.wordwrap(implode("\n", $added), 70, "\n", 1).'</pre>'
															: $this->format(implode("\n", $added))
														)."</div>";
			}

			if ($deleted)
			{
				$output .= "<br />\n\n".$this->get_translation("SimpleDiffDeletions")."<br />\n\n";
				$output .= "<div class=\"deletions\">".($source == 1
															? '<pre>'.wordwrap(implode("\n", $deleted), 70, "\n", 1).'</pre>'
															: $this->format(implode("\n", $deleted))
														)."</div>";
			}

			if (!$added && !$deleted)
			{
				$output .= "<br />\n".$this->get_translation("NoDifferences");
			}
			print($output);

		}

		else {

			require_once("handlers/page/_diff.php");
			// load pages

			// extract text from bodies
			$textA = $pageA['body'];
			$textB = $pageB['body'];

			$sideA = new Side($textA);
			$sideB = new Side($textB);

			$bodyA = '';
			$sideA->split_file_into_words($bodyA);

			$bodyB='';
			$sideB->split_file_into_words($bodyB);

			// diff on these two file
			$diff = new Diff(explode("\n", $bodyA), explode("\n", $bodyB));

			// format output
			$fmt = new DiffFormatter();

			$sideO = new Side($fmt->format($diff));

			$resync_left = 0;
			$resync_right = 0;

			$count_total_right = $sideB->getposition();

			$sideA->init();
			$sideB->init();

			$output='';

			while (1) {

				$sideO->skip_line();
				if ($sideO->isend()) break;

				if ($sideO->decode_directive_line()) {
					$argument=$sideO->getargument();
					$letter=$sideO->getdirective();
					switch ($letter) {
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

					$sideA->skip_until_ordinal($resync_left);
					$sideB->copy_until_ordinal($resync_right,$output);

					if ($letter == 'd' || $letter == 'c') {// deleted word
						$sideA->copy_whitespace($output);
						$output .= "<!--markup:1:begin-->";
						$sideA->copy_word($output);
						$sideA->copy_until_ordinal($argument[1],$output);
						$output .= "<!--markup:1:end-->";
					}

					if ($letter == 'a' || $letter == 'c') {// inserted word
						$sideB->copy_whitespace($output);
						$output .= "<!--markup:2:begin-->";
						$sideB->copy_word($output);
						$sideB->copy_until_ordinal($argument[3],$output);
						$output .= "<!--markup:2:end-->";
					}
				}
			}

			$sideB->copy_until_ordinal($count_total_right,$output);
			$sideB->copy_whitespace($output);
			$out=$this->format($output);
			$out = str_replace("%1", "<a href=\"".$this->href("", "", "time=".urlencode($pageB['modified']))."\">".$this->get_time_string_formatted($pageB['modified'])."</a>",
			str_replace("%2", "<a href=\"".$this->href("", "", "time=".urlencode($pageA['modified']))."\">".$this->get_time_string_formatted($pageA['modified'])."</a>",
			str_replace("%3", $this->compose_link_to_page($this->tag, "", "", 0),
			"<div class=\"diffinfo\">".$this->get_translation("Comparison"))))."</div><br />\n<br />\n".$out;
			print $out;

		}
	}
	else
	{
		print($this->get_translation("ReadAccessDenied"));
	}
}
else
{
	print($this->get_translation("ReadAccessDenied"));
}
?>
</div>
