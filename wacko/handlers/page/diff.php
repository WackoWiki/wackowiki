<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

	$a = $_GET["a"];
	$b = $_GET["b"];

// If asked, call original diff
if ($this->HasAccess("read")) {

	$pageA = $this->LoadPageById($b);
	$pageB = $this->LoadPageById($a);

	if ($this->HasAccess("read", $pageA["tag"]) && $this->HasAccess("read", $pageB["tag"]) ) {

		if ($_GET["fastdiff"]) {

			// This is a really cheap way to do it.

			// prepare bodies
			$bodyA = explode("\n", $pageB["body"]);
			$bodyB = explode("\n", $pageA["body"]);

			$added = array_diff($bodyA, $bodyB);
			$deleted = array_diff($bodyB, $bodyA);

			$output .=
			str_replace("%1", "<a href=\"".$this->href("", "", ($b!=-1?"time=".urlencode($pageA["time"]):""))."\">".$pageA["time"]."</a>",
			str_replace("%2", "<a href=\"".$this->href("", "", ($a!=-1?"time=".urlencode($pageB["time"]):""))."\">".$pageB["time"]."</a>",
			str_replace("%3", $this->ComposeLinkToPage($this->tag, "", "", 0),
			$this->GetTranslation("Comparison"))))."<br />\n";

			if ($added)
			{
				// remove blank lines
				$output .= "<br />\n".$this->GetTranslation("SimpleDiffAdditions")."<br />\n";
				$output .= "<div class=\"additions\">".$this->Format(implode("\n", $added), "wakka", array("diff"=>1))."</div>";
			}

			if ($deleted)
			{
				$output .= "<br />\n".$this->GetTranslation("SimpleDiffDeletions")."<br />\n";
				$output .= "<div class=\"deletions\">".$this->Format(implode("\n", $deleted), "wakka", array("diff"=>1))."</div>";
			}

			if (!$added && !$deleted)
			{
				$output .= "<br />\n".$this->GetTranslation("NoDifferences");
			}
			print($output);

		}

		else {

			require_once("handlers/page/_diff.php");
			// load pages

			// extract text from bodies
			$textA = $pageA["body"];
			$textB = $pageB["body"];

			$sideA = new Side($textA);
			$sideB = new Side($textB);

			$bodyA='';
			$sideA->split_file_into_words($bodyA);

			$bodyB='';
			$sideB->split_file_into_words($bodyB);

			// diff on these two file
			$diff = new Diff(split("\n",$bodyA),split("\n",$bodyB));

			// format output
			$fmt = new DiffFormatter();

			$sideO = new Side($fmt->format($diff));

			$resync_left=0;
			$resync_right=0;

			$count_total_right=$sideB->getposition() ;

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

					if ($letter=='d' || $letter=='c') {// deleted word
						$sideA->copy_whitespace($output);
						$output .="<!--markup:1:begin-->";
						$sideA->copy_word($output);
						$sideA->copy_until_ordinal($argument[1],$output);
						$output .="<!--markup:1:end-->";
					}

					if ($letter == 'a' || $letter == 'c') {// inserted word
						$sideB->copy_whitespace($output);
						$output .="<!--markup:2:begin-->";
						$sideB->copy_word($output);
						$sideB->copy_until_ordinal($argument[3],$output);
						$output .="<!--markup:2:end-->";
					}
				}
			}

			$sideB->copy_until_ordinal($count_total_right,$output);
			$sideB->copy_whitespace($output);
			$out=$this->Format($output);
			$out = str_replace("%1", "<a href=\"".$this->href("", "", "time=".urlencode($pageB["time"]))."\">".$pageB["time"]."</a>",
			str_replace("%2", "<a href=\"".$this->href("", "", "time=".urlencode($pageA["time"]))."\">".$pageA["time"]."</a>",
			str_replace("%3", $this->ComposeLinkToPage($this->tag, "", "", 0),
			$this->GetTranslation("Comparison"))))."<br />\n<br />\n".$out;
			print $out;

		}
	} else {
		print($this->GetTranslation("ReadAccessDenied"));
	}
} else {
	print($this->GetTranslation("ReadAccessDenied"));
}
?>
</div>
