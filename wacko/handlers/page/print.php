<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->page['tag']));
}

if ($this->has_access('read'))
{
	if (!$this->page)
	{
		echo str_replace('%1',$this->href('edit'),$this->get_translation('DoesNotExists'));
	}
	else
	{
		/* obsolete code - or do we need an ability to print old revisions?
		if ($this->page['latest'] == 0)
		{
			echo "<div class=\"revisioninfo\">".
			str_replace('%1',$this->href(),
			str_replace('%2',$this->tag,
			str_replace('%3',$this->page['modified'],
			$this->get_translation('Revision')))).".</div>";
		}*/

		if ($user = $this->get_user())
		{
			if ($user['numerate_links'] == 0 || $this->config['numerate_links'] == 0)
			{
				$_numerate_links = false;
			}
			else
			{
				$_numerate_links = true;
			}
		}
		else
		{
			$_numerate_links = true;
		}

		if ($_numerate_links == true)
		{
			// start enumerating links
			$this->numerate_links = array();
		}

		// build html body
		$data = $this->format($this->page['body'], 'wacko');

		// display page
		$data = $this->format($data, 'post_wacko', array('bad' => 'good'));
		$data = $this->numerate_toc($data); //  numerate toc if needed
		echo $data;

		// display comments
		if ( (isset($_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->tag]) && $_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->tag] == 1) || $this->forum)
		{
			if ($comments = $this->load_comments($this->page['page_id']));
			{
				if (!empty($comments))
				{
					// display comments header
					echo "<br /><br />";
					echo "<div id=\"commentsfiles\">";
					echo "<div class=\"commentsheader\">";
					echo $this->get_translation('Comments_all');
					echo "</div>\n";

					foreach ($comments as $comment)
					{
						if (!$comment['body_r'])
						{
							$comment['body_r'] = $this->format($comment['body']);
						}

						echo "<div class=\"comment\">".
								"<span class=\"commentinfo\">".
									"<strong>&#8212; ".( $comment['user'] == GUEST ? "<em>".$this->get_translation('Guest')."</em>" : $comment['user'] )."</strong> (".$this->get_time_string_formatted($comment['created']).
									($comment['modified'] != $comment['created'] ? ", ".$this->get_translation('CommentEdited')." ".$this->get_time_string_formatted($comment['modified']) : "").")".
								"&nbsp;&nbsp;&nbsp;</span><br />".
								$this->format($comment['body_r'], 'post_wacko').
							"</div>\n";
					}
					echo "</div>\n";
				}
			}
		}

		if ($_numerate_links == true)
		{
			// numerated links
			if (($c = count($this->numerate_links)) > 0)
			{
				if (!isset($comments)) echo "<br />";

				echo "<br />";
				echo "<div id=\"commentsfiles\">";
				echo "<div class=\"linksheader\">";
				echo $this->get_translation('Links');
				echo "</div>\n";

				$i = 0;

				foreach ($this->numerate_links as $l => $n)
				{
					echo "<small><strong><sup><a name=\"reflink\">$n</a></sup></strong> $l</small>\n";

					if (++$i < $c)
					{
						echo "<br /><br />\n";
					}
				}

				echo "</div>\n";
			}

			// stop enumerating links
			$this->numerate_links = null;
		}
	}
}
else
{
	echo $this->get_translation('ReadAccessDenied');
}
?>
</div>