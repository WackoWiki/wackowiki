<?php

if ($this->has_access('comment') && $this->has_access('read'))
{
	// find number
	if ($latestComment = $this->load_single(
	"SELECT tag, page_id
	FROM ".$this->config['table_prefix']."page
	WHERE comment_on_id != '0'
	ORDER BY page_id DESC
	LIMIT 1"))
	{
		preg_match('/^Comment([0-9]+)$/', $latestComment['tag'], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = 1;
	}

	$user = $this->get_user();
	$body = str_replace("\r", '', $_POST['body']);
	$body = trim($_POST['body']);

	if(isset($_POST['title']))
	{
		$title = trim($_POST['title']);
	}

	// watch page
	if ($this->page && isset($_POST['watchpage']) && $_POST['noid_publication'] != $this->tag && $user && $this->iswatched !== true)
	{
		$this->set_watch($user['user_id'], $this->page['page_id']);
	}

	if (!$body)
	{
		if (!$user) $this->cache->cache_invalidate($this->supertag);
		$this->set_message($this->get_translation('EmptyComment'));
	}
	else if (isset($_POST['preview']))
	{
		// comment preview
		if (!$user)
		{
			$this->cache->cache_invalidate($this->supertag);
		}

		$_SESSION['preview']	= $body;
		$_SESSION['body']		= $body;
		$_SESSION['title']		= $title;
		$_SESSION['guest']		= $guest;
		$this->redirect($this->href('', '', 'show_comments=1&p=last').'#preview');
	}
	else if (isset($_SESSION['comment_delay']) && ((time() - $_SESSION['comment_delay']) < $this->config['comment_delay']))
	{
		// posting flood protection
		if (!$user)
		{
			$this->cache->cache_invalidate($this->supertag);
		}

		$this->set_message('<div class="error">'.str_replace('%1', $this->config['comment_delay'], $this->get_translation('CommentFlooded')).'</div>');
		$_SESSION['body']			= $body;
		$_SESSION['comment_delay']	= time();
		$this->redirect($this->href('', '', 'show_comments=1&p=last'));
	}
	else
	{
		// Start Comment Captcha

		// Only show captcha if the admin enabled it in the config file
		if ($this->config['captcha_new_comment'])
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if (extension_loaded('gd'))
			{
				//check whether anonymous user
				//anonymous user has the IP or host name as name
				//if name contains '.', we assume it's anonymous
				#if (strpos($this->get_user_name(), '.'))
				if ($this->get_user_name()== false)
				{
					//anonymous user, check the captcha
					if (!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
					{
						echo '++++++++';

						if ($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
						{
							// reset freecap session vars
							// cannot stress enough how important it is to do this
							// defeats re-use of known image with spoofed session id
							$_SESSION['freecap_attempts'] = 0;
							$_SESSION['freecap_word_hash'] = false;
							$_SESSION['freecap_old_comment'] = '';

							// now process form
							$word_ok = true;
						}
						else
						{
							$word_ok = false;
						}
					}
					else
					{
						$word_ok = false;
					}

					if (!$word_ok)
					{
						//not the right word
						$error = $this->get_translation('SpamAlert');
						$this->set_message($this->get_translation('SpamAlert'));
						$_SESSION['freecap_old_comment'] = $body;
					}
				}
			}
		}

		// everything's okay
		$_SESSION['preview']		= '';
		$_SESSION['body']			= '';
		$_SESSION['title']			= '';
		$_SESSION['guest']			= '';
		$_SESSION['comment_delay']	= time();

		// publish anonymously
		if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->tag)
		{
			// undefine username
			$remember_name = $this->get_user_name();
			$this->set_user_setting('user_name', null);
		}

		if (!$error)
		{
			// find number
			$comment_on_id = $this->page['page_id'];

			// store new comment
			$body_r	= $this->save_page('Comment'.$num, $title, $body, $edit_note = '', $minor_edit = 0, $reviewed = 0, $comment_on_id);

			// log event
			$this->log(5, str_replace('%2', $this->tag.' '.$this->page['title'], str_replace('%1', 'Comment'.$num, $this->get_translation('LogCommentPosted', $this->config['language']))));

			// restore username after anonymous publication
			if ($_POST['noid_publication'] == $this->tag)
			{
				$this->set_user_setting('user_name', $remember_name);
				unset($remember_name);

				if ($body_r)
				{
					$this->set_user_setting('noid_protect', true);
				}
			}

			// now we render it internally so we can write the updated link table.
			$this->clear_link_table();
			$this->start_link_tracking();
			$dummy = $this->format($body_r, 'post_wacko');
			$this->stop_link_tracking();
			$this->write_link_table('Comment'.$num);
			$this->clear_link_table();

			$this->set_message($this->get_translation('CommentAdded'));
		}

		// End Comment Captcha
	}

	// redirect to page
	$this->redirect($this->href('', '', 'show_comments=1&p=last').'#Comment'.$num);
}
else
{
	echo "<div id=\"page\">".$this->get_translation('CommentAccessDenied')."</div>\n";
}

?>