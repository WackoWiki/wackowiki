<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page['comment_on_id']) $this->Redirect($this->href("", $this->page['tag']));

if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		/* obsolete code - or do we need an ability to print old revisions?
		if ($this->page['latest'] == "0")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->tag,
			str_replace("%3",$this->page['modified'],
			$this->GetTranslation("Revision")))).".</div>");
		}*/

		// start enumerating links
		$this->numerate_links = array();

		// build html body
		$data = $this->Format($this->page['body'], "wacko");

		// display page
		$data = $this->Format($data, "post_wacko", array("bad" => "good"));
		$data = $this->NumerateToc($data); //  numerate toc if needed
		echo $data;

		// display comments
		if ($_SESSION[$this->config['session_prefix'].'_'."show_comments"][$this->tag] || $this->forum)
		{
			if ($comments = $this->LoadComments($this->GetPageId()));
			{
				// display comments header
				echo "<br /><br />";
				echo "<div id=\"commentsfiles\">";
				echo "<div class=\"commentsheader\">";
				echo $this->GetTranslation("Comments_all");
				echo "</div>\n";

				foreach ($comments as $comment)
				{
					if (!$comment['body_r']) $comment['body_r'] = $this->Format($comment['body']);

					echo "<div class=\"comment\">".
							"<span class=\"commentinfo\">".
								"<strong>&#8212; ".( $comment['user'] == GUEST ? "<em>".$this->GetTranslation("Guest")."</em>" : $comment['user'] )."</strong> (".$this->GetTimeStringFormatted($comment['created']).
								($comment['modified'] != $comment['created'] ? ", ".$this->GetTranslation("CommentEdited")." ".$this->GetTimeStringFormatted($comment['modified']) : "").")".
							"&nbsp;&nbsp;&nbsp;</span><br />".
							$this->Format($comment['body_r'], "post_wacko").
						"</div>\n";
				}
				echo "</div>\n";
			}
		}

		// numerated links
		if (($c = count($this->numerate_links)) > 0)
		{
			if (!isset($comments)) echo "<br />";

			echo "<br />";
			echo "<div id=\"commentsfiles\">";
			echo "<div class=\"linksheader\">";
			echo $this->GetTranslation("Links");
			echo "</div>\n";

			$i = 0;

			foreach ($this->numerate_links as $l => $n)
			{
				echo "<small><strong><sup><a name=\"reflink\">$n</a></sup></strong> $l</small>\n";
				if (++$i < $c) echo "<br /><br />\n";
			}

			echo "</div>\n";
		}

		// stop enumerating links
		$this->numerate_links = NULL;
	}
}
else
{
	print($this->GetTranslation("ReadAccessDenied"));
}
?>
</div>
