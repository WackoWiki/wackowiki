<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo ADD_NO_DIV . '<article class="page">';
$include_tail = '</article>';

// redirect to show method if page don't exists
if (!$this->page || !$this->has_access('read'))
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->page['tag']));
}

if ($this->has_access('read'))
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

	$_numerate_links = (($user = $this->get_user()))? $user['numerate_links'] : $this->config['numerate_links'];

	if ($_numerate_links)
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
	if (@$this->sess->show_comments[$this->page['page_id']] || $this->forum)
	{
		if (($comments = $this->load_comments($this->page['page_id'])))
		{
			echo '<br /><br />';
			echo '<section id="comments">';
			echo '<header class="header-comments">';
			echo $this->get_translation('Comments_all');
			echo "</header>\n";

			foreach ($comments as $comment)
			{
				if (!$comment['body_r'])
				{
					$comment['body_r'] = $this->format($comment['body']);
				}

				echo '<article class="comment">' .
						'<span class="comment-info">' .
							'<strong>&#8212; ' . $this->user_link($comment['user_name']) . '</strong> (' .
							$this->get_time_formatted($comment['created']) .
							($comment['modified'] != $comment['created'] ? ', ' . $this->get_translation('CommentEdited') . ' ' .
							$this->get_time_formatted($comment['modified']) : '') . ')'.
						'&nbsp;&nbsp;&nbsp;</span><br />' .
						$this->format($comment['body_r'], 'post_wacko') .
					"</article>\n";
			}
			echo "</section>\n";
		}
	}

	if ($_numerate_links)
	{
		// numerated links
		if ($this->numerate_links)
		{
			if (!isset($comments)) echo '<br />';

			echo '<br />';
			echo '<section id="links">';
			echo '<header class="linksheader">';
			echo $this->get_translation('Links');
			echo "</header>\n";

			$i = 0;

			foreach ($this->numerate_links as $l => $n)
			{
				if ($i++)
				{
					echo "<br /><br />\n";
				}

				echo '<span class="reflink"><sup>' . $n. '</sup> ' . $l . "</span>\n";
			}

			echo "</section>\n";
		}

		// stop enumerating links
		$this->numerate_links = null;
	}
}
else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}
