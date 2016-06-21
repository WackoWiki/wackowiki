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
		"WHERE user_id = '".(int)$user_id."' ".
		"LIMIT 1");

	$engine->cached_stats[$user_id] = $stats;

	return $stats;
}

// pagination
$pagination = $this->pagination($this->get_comments_count(), $this->config['comments_count'], 'p', 'show_comments=1#header-comments');

// comments form output begins
if ($this->has_access('read'))
{
	// sorting comments ASC / DESC
	$sort_comment = null;
	$sort_comment = $this->get_user_setting('sorting_comments');

	if (!isset($sort_comment))
	{
		$sort_comment	= $this->config['sorting_comments'];
	}

	// load comments for this page
	$comments		= $this->load_comments($this->page['page_id'], $pagination['offset'], $this->config['comments_count'], $sort_comment);

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
				"WHERE page_id = '".$this->page['page_id']."' ".
					"AND user_id = '".$user['user_id']."'");
		}

		// clear anonymous publication uncorrelator
		if ($noid_protect === true)
		{
			$this->set_user_setting('noid_protect', false);
		}

		// display comments section
		echo '<section id="section-comments">'."\n";

		// display comments header
		echo '<header id="header-comments">'."\n";

		$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

		// pagination
		echo $show_pagination;

		echo '<h1><a href="'.$this->href('', '', 'show_comments=0').'" title="'.$this->get_translation('HideComments').'">'.$this->get_translation('Comments_all').'</a></h1>';
		echo "</header>\n";

		// display comments themselves
		if ($comments)
		{
			// TODO: evaluate -> option / array to handle nested comments
			// display relation as @link to an extra handler which filters / shows only the current tree

			echo '<ol id="comments">'."\n";

			foreach ($comments as $comment)
			{
				#$i ++;
				$handler_button = '';

				echo '<li id="'.$comment['tag'].'" class="comment">'."\n";

				// print comment
				// header
				echo '<article class="comment-text">'."\n";

				// show remove comment button
				if ($this->is_admin() ||
				(!$this->config['remove_onlyadmins']
					&& ($this->is_owner($comment['page_id'])
					|| ($this->config['owners_can_remove_comments'] && $this->is_owner($this->page['page_id']))
				)))
				{
					$handler_button .= '<a href="'.$this->href('remove', $comment['tag']).'"><img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->get_translation('DeleteCommentTip').'" alt="'.$this->get_translation('DeleteText').'" style="float: right; padding: 2px;" class="btn-delete"/></a>';
				}

				// show edit comment button
				if ($this->is_admin() || $this->is_owner($comment['page_id']))
				{
					$handler_button .= '<a href="'.$this->href('edit', $comment['tag']).'"><img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->get_translation('EditCommentTip').'" alt="'.$this->get_translation('EditComment').'" style="float: right; padding: 2px;" class="btn-edit"/></a>';
				}

				if (!empty($handler_button))
				{
					echo '<nav>'.$handler_button."</nav>\n";
				}

				if ($comment['body_r'])
				{
					$pre_body = $comment['body_r'];
				}
				else
				{
					$pre_body = $this->format($comment['body'], 'wacko');
				}

				# $user_stats = handler_show_get_user_stats($this, $comment['user_id']);


				echo '<header class="comment-title">'."\n".
						'<h2><a href="'.$this->href('', $comment['tag']).'">'.$comment['title']."</a></h2>\n".
					 "</header>\n";

				echo '<p>'.$this->format($pre_body, 'post_wacko')."</p>\n";

				echo '<footer>'.
						'<ul class="comment-info">'."\n".
						"<li>".
							$this->user_link($comment['owner_name']).
						"</li>\n".
						'<li><time datetime="'.$comment['created'].'">'.$this->get_time_formatted($comment['created'])."</time></li>\n".
						($comment['modified'] != $comment['created']
							? '<li><time datetime="'.$comment['modified'].'">'.$this->get_time_formatted($comment['modified'])."</time> ".$this->get_translation('CommentEdited')."</li>\n"
							: '').
						/*($user_stats == true
							? "<li>".$this->get_translation('UsersComments').': '.$user_stats['comments'].'&nbsp;&nbsp; '.$this->get_translation('UsersPages').': '.$user_stats['pages'].'&nbsp;&nbsp; '.$this->get_translation('UsersRevisions').': '.$user_stats['revisions']."</li>\n"
							: '').*/
					"</ul>\n".
					"</footer>\n";
				echo "</article>\n";

				// comment footer
				/* echo '<div class="comment-tool">'."\n";
				echo '<ul class="" style="padding-left: 0px;">'."\n".
						"".
						'<li class="voting">
							<a title="Vote up" class="vote-up  count-0" href="'.$this->href('rate', '', 'vote=1').'">
								<span class="updatable count">0</span>
								<span class="control">&and;</span>
							</a>
							<a title="Vote down" class="vote-down  count-0" href="'.$this->href('rate', '', 'vote=0').'">
								<span class="control">&or;</span>
							</a>
						</li>
						<li class="bullet">.</li>
						<li class="reply">';

						// reply button
						if ($this->is_admin() || $this->is_owner($comment['page_id']))
						{
							echo '<a href="'.$this->href('', '', 'parent_id='.$comment['page_id'].'#commentform').'">'.$this->get_translation('ReplyComment').'</a>';
						}

						echo '</li>'.
						"</ul>\n";

				echo "</div>\n"; */
			}

			echo "</ol>\n";
		}

		// pagination
		echo $show_pagination;

		// display comment form
		if ($this->has_access('comment'))
		{
			$parent_id = (isset($_GET['parent_id']) && $_GET['parent_id'] ? (int)$_GET['parent_id'] : 0);
			echo '<div class="commentform" id="commentform">'."\n";

			echo $this->form_open('add_comment', 'addcomment', '', true);
			echo '<input type="hidden" name="parent_id" value="'.$parent_id.'" />'."\n";

			// preview
			if (!empty($preview))
			{
				$preview = $this->format($preview, 'pre_wacko');
				$preview = $this->format($preview, 'wacko');
				$preview = $this->format($preview, 'post_wacko');

				echo '<div id="preview" class="preview"><p class="preview"><span>'.$this->get_translation('EditPreviewSlim').'</span></p>'."\n".
						'<div class="comment-preview">'."\n".
						'<header class="comment-title">'.
							'<h2>'.$title."</h2>'.
						'</header>\n".
						'<p>'.$preview.'</p>'.
						"</div>\n</div><br />\n";
			}

			// load WikiEdit
			echo '<script src="'.$this->config['base_url'].'js/protoedit.js"></script>'."\n";
			echo '<script src="'.$this->config['base_url'].'js/lang/wikiedit.'.$this->user_lang.'.js"></script>'."\n";
			echo '<script src="'.$this->config['base_url'].'js/wikiedit.js"></script>'."\n";
			echo '<script src="'.$this->config['base_url'].'js/autocomplete.js"></script>'."\n";
			?>
				<noscript><div class="errorbox_js"><?php echo $this->get_translation('WikiEditInactiveJs'); ?></div></noscript>

				<label for="addcomment_title"><?php echo $this->get_translation('AddCommentTitle');?></label><br />
				<input type="text" id="addcomment_title" name="title" size="60" maxlength="100" value="<?php if (isset($title)) echo $title; ?>" /><br />
				<br />
				<label for="addcomment"><?php echo $this->get_translation('AddComment');?></label><br />
				<textarea id="addcomment" name="body" rows="6" cols="7"><?php if (isset($_SESSION['freecap_old_comment'])) echo $_SESSION['freecap_old_comment']; ?><?php if (isset($payload)) echo htmlspecialchars($payload, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ?></textarea>

			<?php
			if ($user)
			{
				$output		= '';

				// publish anonymously
				if (($this->page && $this->config['publish_anonymously'] != 0 && $this->has_access('comment', '', GUEST)) || (!$this->page && $this->has_access('create', '', GUEST)))
				{
					$output .= '<input type="checkbox" name="noid_publication" id="noid_publication" value="'.$this->page['page_id'].'" '.( $this->get_user_setting('noid_pubs') == 1 ? 'checked="checked"' : '' )."/>\n";
					$output .= '<label for="noid_publication">'.$this->get_translation('PostAnonymously')."</label>\n";
					$output .= '<br />';
				}

				// watch a page
				if ($this->page && $this->is_watched !== true)
				{
					$output .= '<input type="checkbox" name="watchpage" id="watchpage" value="1"'.( $this->get_user_setting('send_watchmail') == 1 ? 'checked="checked"' : '' )." />\n";
					$output .= '<label for="watchpage">'.$this->get_translation('NotifyMe')."</label>\n";
					$output .= '<br />';
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

			<script>
			wE = new WikiEdit();

			<?php
			if ($user = $this->get_user())
			{
				if ($user['autocomplete'])
				{
				?>
					if (AutoComplete) { wEaC = new AutoComplete( wE, "<?php echo $this->href('edit');?>" ); }
				<?php
				}
			}
			?>

			wE.init('addcomment','WikiEdit','edname-w','<?php echo $this->config['base_url'];?>image/wikiedit/');
			</script>

			<br />
			<input type="submit" name="save" value="<?php echo $this->get_translation('AddCommentButton'); ?>" accesskey="s" />
			<input type="submit" name="preview" value="<?php echo $this->get_translation('EditPreviewButton'); ?>" />
			<?php echo $this->form_close();

			echo "</div>\n";
		}
		// end comment form

		echo "</section>\n";
	}
	else
	{
		$c = $this->page['comments'];

		if		($c  <  1)
		{
			if ($this->has_access('comment'))
			{
				$show_comments = $this->get_translation('Comments_0');
			}
		}
		else if	($c == 1)
		{
			$show_comments = $this->get_translation('Comments_1');
		}
		else if	($c  >  1)
		{
			$show_comments = str_replace('%1', $c, $this->get_translation('Comments_n'));
		}

		// show link to show comment only if there is one or/and user has the right to add a new one
		if (!empty($show_comments))
		{
			// display comments section
			echo '<section id="section-comments">';
			echo '<header id="header-comments">';
			echo '<h1><a href="'.$this->href('', '', 'show_comments=1#header-comments').'" title="'.$this->get_translation('ShowComments').'">'.$show_comments.'</a></h1>';
			echo '</header>'."\n";
			echo "</section>\n";
		}
		else
		{
			// TODO: add message if registered users can comment this page
			// e.g. 'Log in or create an account to post a comment.'
		}
	}
}

?>