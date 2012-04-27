<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// get number of user's pages, revisions and comments
function handler_show_get_user_stats(&$engine, $user_id)
{
	if ($user_id == 0)
	{
		return array();
	}
	else if (isset($engine->cached_stats[$user_id]))
	{
		return $engine->cached_stats[$user_id];
	}

	$stats = $engine->load_single(
		"SELECT user_name, ".
			"total_pages AS pages, ".
			"total_revisions AS revisions, ".
			"total_comments AS comments ".
		"FROM {$engine->config['user_table']} ".
		"WHERE user_id = '".quote($engine->dblink, $user_id)."' ".
		"LIMIT 1");

	$engine->cached_stats[$user_id] = $stats;

	return $stats;
}

// pagination
$pagination = $this->pagination($this->get_comments_count(), $this->config['comments_count'], 'p', 'show_comments=1#commentsheader');

// comments form output begins
if ($this->has_access('read'))
{
	// load comments for this page
	$comments = $this->load_comments($this->page['page_id'], $pagination['offset'], $this->config['comments_count']);

	// store comments display in session
	if (!isset($_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']]))
	{
		$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = ($this->user_wants_comments() ? '1' : '0');
	}

	if(isset($_GET['show_comments']))
	{
		switch($_GET['show_comments'])
		{
			case '0':
				$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = 0;
				break;
			case '1':
				$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = 1;
				break;
		}
	}

	// display comments
	if ($this->page && $_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] || $this->forum === true)
	{
		$user			= $this->get_user();
		$admin			= $this->is_admin();
		$moder			= $this->is_moderator();
		$noid_protect	= $this->get_user_setting('noid_protect');

		// clear new comments for watched page
		if ($user && $comments && !$noid_protect)
		{
			$this->sql_query(
						"UPDATE {$this->config['table_prefix']}watch ".
						"SET comment_id = '0' ".
						"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
						"AND user_id = '".quote($this->dblink, $user['user_id'])."'");
		}

		// clear anonymous publication uncorrelator
		if ($noid_protect === true)
		{
			$this->set_user_setting('noid_protect', false);
		}

		// display comments header
		echo '<div id="commentsheader">';

		if (isset($pagination['text']))
		{
			echo '<div class="pagination"><small>'.$pagination['text'].'</small></div>';
		}

		echo "<a href=\"".$this->href('', '', 'show_comments=0')."\" title=\"".$this->get_translation('HideComments')."\">".$this->get_translation('Comments_all')."</a>";
		echo "</div>\n";

		// display comments themselves
		if ($comments)
		{
			echo "<ol id=\"comments\">\n";

			foreach ($comments as $comment)
			{
				echo "<li id=\"".$comment['tag']."\" class=\"comment\">\n";
				$del = '';

				// show remove comment button
				if ($this->is_admin() || $this->user_is_owner($comment['page_id']) || ($this->config['owners_can_remove_comments'] && $this->user_is_owner($this->page['page_id'])))
				{
					echo "<a href=\"".$this->href('remove', $comment['tag'])."\"><img src=\"".$this->config['theme_url']."icons/delete_comment.gif\" title=\"".$this->get_translation('DeleteCommentTip')."\" alt=\"".$this->get_translation('DeleteText')."\" align=\"right\" border=\"0\" /></a>";
				}

				// show edit comment button
				if ($this->is_admin() || $this->user_is_owner($comment['page_id']))
				{
					echo "<a href=\"".$this->href('edit', $comment['tag'])."\"><img src=\"".$this->config['theme_url']."icons/edit.gif\" title=\"".$this->get_translation('EditCommentTip')."\" alt=\"".$this->get_translation('EditComment')."\" align=\"right\" border=\"0\" /></a>";
				}

				if ($comment['body_r'])
				{
					$strings = $comment['body_r'];
				}
				else
				{
					$strings = $this->format($comment['body'], 'wacko');
				}

				# $user_stats = handler_show_get_user_stats($this, $comment['user_id']);

				// print comment
				// header
				echo "<div class=\"commenttext\">\n";
				echo "<div class=\"commenttitle\">\n<a href=\"".$this->href('', $comment['tag'])."\">".$comment['title']."</a>\n</div>\n";
				echo $this->format($strings, 'post_wacko')."\n";
				echo "</div>\n";
				echo "<ul class=\"commentinfo\">\n".
				"<li>".($comment['owner_name']
				? "<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$comment['owner_name'])."\">".$comment['owner_name']."</a>"
										: $this->get_translation('Guest')).
								"<li>".$this->get_time_string_formatted($comment['created'])."</li>\n".
								($comment['modified'] != $comment['created']
									? "<li>".$this->get_time_string_formatted($comment['modified'])." ".$this->get_translation('CommentEdited')."</li>\n"
									: '').
								/*($user_stats == true
				? "<li>".$this->get_translation('UsersComments').': '.$user_stats['comments'].'&nbsp;&nbsp; '.$this->get_translation('UsersPages').': '.$user_stats['pages'].'&nbsp;&nbsp; '.$this->get_translation('UsersRevisions').': '.$user_stats['revisions']."</li>\n"
				: '').*/
				"</ul>\n";
				echo "</li>";
			}

			echo "</ol>";
		}

		if (isset($pagination['text']))
		{
			echo '<div class="commentspagination"><span class="pagination"><small>'.$pagination['text'].'</small></span></div>';
		}

		// display comment form
		if ($this->has_access('comment'))
		{
			echo "<div class=\"commentform\">\n";

			echo $this->form_open('addcomment');

			// preview
			if (!empty($preview))
			{
				$preview = $this->format($preview, 'pre_wacko');
				$preview = $this->format($preview, 'wacko');
				$preview = $this->format($preview, 'post_wacko');

				echo "<a name=\"preview\"></a><div class=\"preview\"><p class=\"preview\"><span>".$this->get_translation('EditPreviewSlim')."</span></p>\n".
						 '<div class="commentpreview">'."\n".
						 '<div class="commenttitle">'.$title."</div>\n".
						 $preview.
						 "</div></div><br />\n";
			}

			// load WikiEdit
			echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
				echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit.js\"></script>\n";
				echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/autocomplete.js\"></script>\n";
			?>
				<noscript><div class="errorbox_js"><?php echo $this->get_translation('WikiEditInactiveJs'); ?></div></noscript>

				<label for="addcomment"><?php echo $this->get_translation('AddComment');?></label><br />
				<textarea id="addcomment" name="body" rows="6" cols="7" style="width: 100%"><?php if (isset($_SESSION['freecap_old_comment'])) echo $_SESSION['freecap_old_comment']; ?><?php if (isset($payload)) echo htmlspecialchars($payload) ?></textarea>

				<label for="addcomment_title"><?php echo $this->get_translation('AddCommentTitle');?></label><br />
				<input id="addcomment_title" name="title" size="60" maxlength="100" value="<?php if (isset($title)) echo $title; ?>" ><br />

			<?php
			if ($user)
			{
				$output			= '';

				// publish anonymously
				if (($this->page && $this->config['publish_anonymously'] != 0 && $this->has_access('comment', '', GUEST)) || (!$this->page && $this->has_access('create', '', GUEST)))
				{
					$output .= "<input type=\"checkbox\" name=\"noid_publication\" id=\"noid_publication\" value=\"".htmlspecialchars($this->tag)."\"".( $this->get_user_setting('noid_pubs') == 1 ? "checked=\"checked\"" : "" )." /> <small><label for=\"noid_publication\">".$this->get_translation('PostAnonymously')."</label></small>";
					$output .= "<br />";
				}

				// watch a page
				if ($this->page && $this->iswatched !== true)
				{
					$output .= "<input type=\"checkbox\" name=\"watchpage\" id=\"watchpage\" value=\"1\"".( $this->get_user_setting('send_watchmail') == 1 ? "checked=\"checked\"" : "" )." /> <small><label for=\"watchpage\">".$this->get_translation('NotifyMe')."</label></small>";
					$output .= "<br />";
				}

				echo '<br />'.$output;
			}

			// captcha code starts

			// Only show captcha if the admin enabled it in the config file
			if ($this->config['captcha_new_comment'])
			{
				$this->show_captcha(false);
			}
			// end captcha
		?>
		<script type="text/javascript">
		wE = new WikiEdit();
<?php
		if ($user = $this->get_user())
		if ($user['autocomplete'])
		{
?>
			if (AutoComplete) { wEaC = new AutoComplete( wE, "<?php echo $this->href('edit');?>" ); }
<?php
		}
?>
		wE.init('addcomment','WikiEdit','edname-w','<?php echo $this->config['base_url'];?>images/wikiedit/');
		</script><br />
		<input name="save" type="submit" value="<?php echo $this->get_translation('AddCommentButton'); ?>" accesskey="s" />
		<input name="preview" type="submit" value="<?php echo $this->get_translation('EditPreviewButton'); ?>" />
		<?php echo $this->form_close();
				echo "</div>\n";
				}
			// end comment form
	}
	else
	{
		echo '<div id="commentsheader">';

		$c = (int)$this->page['comments'];

		if		($c  <  1)	$show_comments = $this->get_translation('Comments_0');
		else if	($c === 1)	$show_comments = $this->get_translation('Comments_1');
		else if	($c  >  1)	$show_comments = str_replace('%1', $c, $this->get_translation('Comments_n'));

		//TODO: show link to show comment only if there is one or/and user has the right to add a new one
		echo "<a href=\"".$this->href('', '', 'show_comments=1#commentsheader')."\" title=\"".$this->get_translation('ShowComments')."\">".$show_comments."</a></div>";
	}
}

?>