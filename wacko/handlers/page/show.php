<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page" class="page">
<?php

if (!isset ($this->config['comments_count']))
{
	$this->config['comments_count'] = 15;
}

if ($this->config['hide_rating'] != 1 && ($this->config['hide_rating'] != 2 || $this->get_user()))
{
	// registering local functions
	// determine if user has rated a given page
	function handler_show_page_is_rated(&$engine, $id)
	{
		$cookie	= $engine->get_cookie('rating');
		$ids	= explode(';', $cookie);

		if ($id = array_search($id, $ids))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
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

// redirect from comment page to the commented one
if ($this->page['comment_on_id'])
{
	// count previous comments
	$count = $this->load_single(
		"SELECT COUNT(tag) AS n ".
		"FROM {$this->config['table_prefix']}page ".
		"WHERE comment_on_id = '".quote($this->dblink, $this->page['comment_on_id'])."' ".
			"AND created <= '".quote($this->dblink, $this->page['created'])."' ".
		"GROUP BY comment_on_id ".
		"LIMIT 1", 1);

	// determine comments page number where this comment is located
	$p = ceil($count['n'] / $this->config['comments_count']);

	// forcibly open page
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1&p='.$p).'#'.$this->page['tag']);
}

// display page body
if ($this->has_access('read'))
{
	if (!$this->page)
	{
		// Not sure what the point of wrapping it in the conditional was
		// if (function_exists('virtual')) header('HTTP/1.0 404 Not Found');
		header('HTTP/1.0 404 Not Found');

		echo '<br /><div class="notice">'.
			$this->get_translation('DoesNotExists') ." ".( $this->has_access('create') ?  str_replace('%1', $this->href('edit', '', '', 1), $this->get_translation('PromptCreate')) : '').
			'</div>';
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			echo "<div class=\"commentinfo\">".$this->get_translation('ThisIsCommentOn')." ".$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', '', 0).", ".$this->get_translation('PostedBy')." ".($this->is_wiki_name($this->page['user_name']) ? $this->link($this->page['user_name']) : $this->page['user_name'])." ".$this->get_translation('At')." ".$this->get_time_string_formatted($this->page['modified'])."</div>";
		}

		// revision header
		if ($this->page['latest'] == 0)
		{
			echo "<div class=\"revisioninfo\">".
			str_replace('%1', $this->href(),
			str_replace('%2', $this->tag,
			str_replace('%3', $this->get_page_time_formatted(),
			str_replace('%4', '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>',
			$this->get_translation('Revision')))));

			// if this is an old revision, display ReEdit button
			if ($this->has_access('write'))
			{
				$latest = $this->load_page($this->tag);
				?>
				<br />
				<?php echo $this->form_open('edit') ?>
				<input type="hidden" name="previous" value="<?php echo $latest['modified'] ?>" />
				<input type="hidden" name="id" value="<?php echo htmlspecialchars($this->page['page_id']) ?>" />
				<input type="hidden" name="body" value="<?php echo htmlspecialchars($this->page['body']) ?>" />
				<input type="submit" value="<?php echo $this->get_translation('ReEditOldRevision') ?>" />
				<input name="cancel" id="button" type="button" value="<?php echo $this->get_translation('EditCancelButton') ?>" onclick="document.location='<?php echo addslashes($this->href()) ?>';" />
				<?php echo $this->form_close(); ?>
				<?php
			}

			echo "</div>";
		}

		// count page hit (we don't count for page owner)
		if ($this->get_user_id() != $this->page['owner_id'])
		{
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."page ".
				"SET hits = hits + 1 ".
				"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."'");
		}

		$this->set_language($this->page_lang);

		// recompile if necessary
		if (($this->page['body_r'] == '') ||
		(($this->page['body_toc'] == '') && $this->config['paragrafica']))
		{
			// build html body
			$this->page['body_r'] = $this->format($this->page['body'], 'wacko');

			// build toc
			if ($this->config['paragrafica'])
			{
				$this->page['body_r']	= $this->format($this->page['body_r'], 'paragrafica');
				$this->page['body_toc']	= $this->body_toc;
			}

			// store to DB
			if ($this->page['latest'] != 0)
			{
				$this->sql_query(
					"UPDATE ".$this->config['table_prefix']."page SET ".
						"body_r		= '".quote($this->dblink, $this->page['body_r'])."', ".
						"body_toc	= '".quote($this->dblink, $this->page['body_toc'])."' ".
					"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
					"LIMIT 1");
			}
		}

		// display page
		$data = $this->format($this->page['body_r'], 'post_wacko', array('bad' => 'good'));
		$data = $this->numerate_toc( $data ); //  numerate toc if needed
		echo $data;

		$this->set_language($this->user_lang);
		?>
		<script type="text/javascript">
			var dbclick = "page";
		</script>
		<?php
	}
}
else
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header('HTTP/1.0 403 Forbidden');
	header('HTTP/1.0 403 Forbidden');

	echo $this->get_translation('ReadAccessDenied');
}
?>
<br style="clear: both" />&nbsp;</div>
<?php
// page comments and files
if ($this->method == 'show' && $this->page['latest'] > 0 && !$this->page['comment_on_id'])
{
	// revoking payload
	if (isset($_SESSION['guest']))
	{
		$guest					= $_SESSION['guest'];
		$_SESSION['guest']		= '';
	}
	else
	{
		$guest					= $this->get_cookie('guest');
	}

	if (isset($_SESSION['body']))
	{
		$payload				= $_SESSION['body'];
		$_SESSION['body']		= '';
	}

	if (isset($_SESSION['title']))
	{
		$title					= $_SESSION['title'];
		$_SESSION['title']		= '';
	}

	if (isset($_SESSION['preview']))
	{
		$preview				= $_SESSION['preview'];
		$_SESSION['preview']	= '';
	}

	// files code starts
	if ($this->config['footer_files'])
	{
		if ($this->has_access('read') && $this->config['hide_files'] != 1 && ($this->config['hide_files'] != 2 || $this->get_user()))
		{
			// store files display in session
			if (!isset($_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']]))
			{
				$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = ($this->user_wants_files() ? '1' : '0');
			}

			if(isset($_GET['show_files']))
			{
				switch($_GET['show_files'])
				{
					case '0':
						$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 0;
						break;
					case '1':
						$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 1;
						break;
				}
			}

			// display files!
			if ($this->page && $_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']])
			{
				// display files header
				?>
	<div id="filesheader">
	<?php echo "<a href=\"".$this->href('', '', 'show_files=0')."\" title=\"".$this->get_translation('HideFiles')."\">".$this->get_translation('Files_all')."</a>"; ?>
	</div>

				<?php
				echo "<div class=\"files\">";
				echo $this->action('files', array('nomark' => 1));
				echo "</div>";

				// display form
				if ($user = $this->get_user())
				{
					$user_name = strtolower($this->get_user_name());
					$registered = true;
				}
				else
				{
					$user_name = GUEST;
				}

				if (isset($registered)
					&&
						(
							($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
							($this->check_acl($user_name, $this->config['upload']))
						)
					)
				{
					echo "<div class=\"filesform\">\n";
					echo $this->action('upload', array('nomark' => 1));
					echo "</div>\n";
				}
			}
			else
			{
				echo "<div id=\"filesheader\">";

				if ($this->page['page_id'])
				{
					// load files for this page
					$files = $this->load_all(
						"SELECT upload_id ".
						"FROM ".$this->config['table_prefix']."upload ".
						"WHERE page_id = '". quote($this->dblink, $this->page['page_id']) ."'");
				}
				else
				{
					$files = array();
				}

				switch ($c = count($files))
				{
					case 0:
						$show_files = $this->get_translation('Files_0');
						break;
					case 1:
						$show_files = $this->get_translation('Files_1');
						break;
					default:
						$show_files = str_replace('%1', $c, $this->get_translation('Files_n'));
				}

				echo "<a href=\"".$this->href('', '', 'show_files=1#filesheader')."\" title=\"".$this->get_translation('ShowFiles')."\">".$show_files."</a>";
				echo "</div>\n";
			}
		}
	}
	// files form output ends
	if ($this->config['footer_comments'])
	{
		// pagination
		$pagination = $this->pagination($this->get_comments_count(), $this->config['comments_count'], 'p', 'show_comments=1#commentsheader');

		// comments form output begins
		if ($this->has_access('read') && $this->config['hide_comments'] != 1 && ($this->config['hide_comments'] != 2 || $this->get_user()))
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
				if ($user && $comments && !$noid_protect) $this->sql_query(
					"UPDATE {$this->config['table_prefix']}watch ".
					"SET comment_id = '0' ".
					"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
						"AND user_id = '".quote($this->dblink, $user['user_id'])."'");

				// clear anonymous publication uncorrelator
				if ($noid_protect === true) $this->get_user_setting('noid_protect', false);

				// display comments header
				echo '<div id="commentsheader">';

				if (isset($pagination['text']))
				{
					echo '<div style="float:right; letter-spacing:normal;"><small>'.$pagination['text'].'</small></div>';
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

					if ($this->is_admin() || $this->user_is_owner($comment['page_id']) || ($this->config['owners_can_remove_comments'] && $this->user_is_owner($this->page['page_id'])))
					{
						echo "<a href=\"".$this->href('remove', $comment['tag'])."\"><img src=\"".$this->config['theme_url']."icons/delete_comment.gif\" title=\"".$this->get_translation('DeleteCommentTip')."\" alt=\"".$this->get_translation('DeleteText')."\" align=\"right\" border=\"0\" /></a>";
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
								"<li>".($comment['user_name']
										? "<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$comment['user_name'])."\">".$comment['user_name']."</a>"
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
				echo '<div style="text-align:right;padding-right:10px;border-top:solid 1px #BABFC7;"><small>'.$pagination['text'].'</small></div>';
			}

			// display comment form
			if ($this->has_access('comment'))
			{
				echo "<div class=\"commentform\">\n";

				echo $this->form_open('addcomment');

				// preview
				if (!empty($preview))
				{
					$preview = $this->Format($preview);

					echo "<a name=\"preview\"></a><div class=\"preview\"><p class=\"preview\"><span>".$this->get_translation('EditPreviewSlim')."</span></p>\n".
						 '<div class="commentpreview">'."\n".
						 '<div class="commenttitle">'.$title."</div>\n".
						 $preview.
						 "</div></div><br />\n";
				}

				// load WikiEdit
					echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
					echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit2.js\"></script>\n";
					echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/autocomplete.js\"></script>\n";
				?>
					<noscript><div class="errorbox_js"><?php echo $this->get_translation('WikiEditInactiveJs'); ?></div></noscript>

					<label for="addcomment"><?php echo $this->get_translation('AddComment');?></label><br />
					<textarea id="addcomment" name="body" rows="6" cols="7" style="width: 100%"><?php if (isset($_SESSION['freecap_old_comment'])) echo $_SESSION['freecap_old_comment']; ?><?php if (isset($payload)) echo $payload ?></textarea>

					<label for="addcomment_title"><?php echo $this->get_translation('AddCommentTitle');?></label><br />
					<input id="addcomment_title" name="title" size="60" maxlength="100" value="<?php if (isset($title)) echo $title; ?>" ><br />
		<?php
					// captcha code starts

					// Only show captcha if the admin enabled it in the config file
					if ($this->config['captcha_new_comment'])
					{
						// Don't load the captcha at all if the GD extension isn't enabled
						if (extension_loaded('gd'))
						{
							// check whether anonymous user
							// anonymous user has no name
							// if false, we assume it's anonymous
							if ($this->get_user_name() == false)
							{
		?>
		<br />
		<br />
		<label for="captcha"><?php echo $this->get_translation('Captcha');?>:</label>
		<br />
		<img src="<?php echo $this->config['base_url'];?>lib/captcha/freecap.php" id="freecap" alt="<?php echo $this->get_translation('Captcha');?>" /> <a href="" onclick="this.blur(); new_freecap(); return false;" title="<?php echo $this->get_translation('CaptchaReload'); ?>"><img src="<?php echo $this->config['base_url'];?>images/reload.png" width="18" height="17" alt="<?php echo $this->get_translation('CaptchaReload'); ?>" /></a>
		<br />
		<input id="captcha" type="text" name="word" maxlength="6" style="width: 273px;" />
		<br />
		<br />
		<?php
							}
						}
					}
					// end captcha
		?><script type="text/javascript">
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
		?>
		<div id="commentsheader">
		<?php
				$c = (int)$this->page['comments'];

				if		($c  <  1)	$show_comments = $this->get_translation('Comments_0');
				else if	($c === 1)	$show_comments = $this->get_translation('Comments_1');
				else if	($c  >  1)	$show_comments = str_replace('%1', $c, $this->get_translation('Comments_n'));

				//TODO: show link to show comment only if there is one or/and user has the right to add a new one
				echo "<a href=\"".$this->href('', '', 'show_comments=1#commentsheader')."\" title=\"".$this->get_translation('ShowComments')."\">".$show_comments."</a></div>";
			}
		}
	}

	// rating form output begins
	if ($this->has_access('read') && $this->page && $this->config['hide_rating'] != 1 && ($this->config['hide_rating'] != 2 || $this->get_user()))
	{
		// determine if user has rated this page
		if (handler_show_page_is_rated($this, $this->page['page_id']) === false && (isset($_GET['show_rating']) && $_GET['show_rating'] != 1) )
		{
			// display rating header
			echo '<a name="rating"></a>';
			echo '<div id="rateheader">';
			echo $this->get_translation('RatingHeader').' [<a href="'.$this->href('', '', 'show_rating=1').'#rating">'.$this->get_translation('RatingResults').'</a>]';
			echo "</div>\n";

			// display rating form
			echo '<div class="rating">'.$this->form_open('rate').'';
			echo '<input id="minus3" name="value" type="radio" value="-3" /><label for="minus3">-3</label>'.
				 '<input id="minus2" name="value" type="radio" value="-2" /><label for="minus2">-2</label>'.
				 '<input id="minus1" name="value" type="radio" value="-1" /><label for="minus1">-1</label>'.
				 '<input id="plus0" name="value" type="radio" value="0" /><label for="plus0"> 0</label>'.
				 '<input id="plus1" name="value" type="radio" value="1" /><label for="plus1">+1</label>'.
				 '<input id="plus2" name="value" type="radio" value="2" /><label for="plus2">+2</label>'.
				 '<input id="plus3" name="value" type="radio" value="3" /><label for="plus3">+3</label>'.
				 '<input name="rate" id="submit" type="submit" value="'.$this->get_translation('RatingSubmit').'" />';
			echo ''.$this->form_close().'</div>';
		}
		else
		{
			$results = $this->load_single(
				"SELECT page_id, value, voters ".
				"FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = {$this->page['page_id']} ".
				"LIMIT 1");

			if ($results['voters'] > 0)			$results['ratio'] = $results['value'] / $results['voters'];
			if (is_float($results['ratio']))	$results['ratio'] = round($results['ratio'], 2);
			if ($results['ratio'] > 0)			$results['ratio'] = '+'.$results['ratio'];

			// display rating header
			echo '<a name="rating"></a>';
			echo '<div id="rateheader">';
			echo $this->get_translation('RatingHeaderResults').
				(handler_show_page_is_rated($this, $this->page['page_id']) === false
					? ' [<a href="'.$this->href('', '', 'show_rating=0').'#rating">'.$this->get_translation('RatingForm').'</a>]'
					: '');
			echo "</div>\n";

			// display rating results
			if (isset($results['ratio']))
			{
				echo '<div class="rating">';
				echo ''.$this->get_translation('RatingTotal').': <strong>'.$results['ratio'].'</strong>'.
					 ' '.
					 ''.$this->get_translation('RatingVoters').': <strong>'.$results['voters'].'</strong>';
				echo '</div>';
			}
			else
			{
				echo '<div class="rating">';
				echo '<em>'.$this->get_translation('RatingNotRated').'</em>';
				echo '</div>';
			}
		}
	}
}

?>