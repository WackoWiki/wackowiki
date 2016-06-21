<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('comment') && $this->has_access('read'))
{
	$body		= str_replace("\r", '', $_POST['body']);
	$body		= trim($_POST['body']);
	$error		= '';
	$title		= '';
	$parent_id	= '';

	if(isset($_POST['title']))
	{
		$title = trim($_POST['title']);
	}

	if(isset($_POST['parent_id']))
	{
		$parent_id = (int)$_POST['parent_id'];
	}

	// check form token
	if (!$this->validate_form_token('add_comment'))
	{
		if (!$user)
		{
			$this->cache->invalidate_page_cache($this->supertag);
		}

		$_SESSION['body']		= $body;
		$_SESSION['title']		= $title;

		$this->set_message($this->get_translation('FormInvalid'), 'error');
		$this->redirect($this->href('', '', 'show_comments=1&p=last'));
	}

	// find number
	if ($latest_comment = $this->load_single(
		"SELECT tag, page_id
		FROM ".$this->config['table_prefix']."page
		WHERE comment_on_id <> '0'
		ORDER BY page_id DESC
		LIMIT 1"))
	{
		preg_match('/^Comment([0-9]+)$/', $latest_comment['tag'], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = 1;
	}

	$user = $this->get_user();

	// watch page
	if ($this->page
		&& (isset($_POST['watchpage']) && ($_POST['watchpage']))
		&& ($_POST['noid_publication'] != $this->page['page_id'])
		&& $user && $this->is_watched !== true)
	{
		$this->set_watch($user['user_id'], $this->page['page_id']);
	}

	if (!$body)
	{
		if (!$user)
		{
			$this->cache->invalidate_page_cache($this->supertag);
		}

		$this->set_message($this->get_translation('EmptyComment'));
	}
	else if (isset($_POST['preview']))
	{
		// comment preview
		if (!$user)
		{
			$this->cache->invalidate_page_cache($this->supertag);
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
			$this->cache->invalidate_page_cache($this->supertag);
		}

		$_SESSION['body']			= $body;
		$_SESSION['title']			= $title;
		$_SESSION['comment_delay']	= time();

		$message = str_replace('%1', $this->config['comment_delay'], $this->get_translation('CommentFlooded'));
		$this->set_message($message, 'error');
		$this->redirect($this->href('', '', 'show_comments=1&p=last'));
	}
	else if ($bad_words = $this->bad_words($body))
	{
		$_SESSION['body']			= $body;
		$_SESSION['title']			= $title;
		$_SESSION['comment_delay']	= time();

		$message = $bad_words;
		$this->set_message($message , 'error');
		#$error = true;

		$this->redirect($this->href('', '', 'show_comments=1&p=last'));
	}
	else
	{
		// Start Comment Captcha

		// Only show captcha if enabled
		if ($this->config['captcha_new_comment'])
		{
			// captcha validation
			if ($this->validate_captcha() === false)
			{
				//not the right word
				$error = $this->get_translation('CaptchaFailed');
				$this->set_message($error, 'error');
				$_SESSION['freecap_old_comment'] = $body;
			}
			else
			{
				// captcha passed, empty session
				$_SESSION['freecap_old_comment'] = '';
			}
		}

		// everything's okay
		$_SESSION['preview']		= '';
		$_SESSION['body']			= '';
		$_SESSION['title']			= '';
		$_SESSION['guest']			= '';
		$_SESSION['comment_delay']	= time();

		// publish anonymously
		if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->page['page_id'])
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
			$body_r	= $this->save_page('Comment'.$num, $title, $body, $edit_note = '', $minor_edit = 0, $reviewed = 0, $comment_on_id, $parent_id);

			// log event
			$this->log(5, str_replace('%2', $this->tag.' '.$this->page['title'], str_replace('%1', 'Comment'.$num, $this->get_translation('LogCommentPosted', $this->config['language']))));

			// restore username after anonymous publication
			if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->page['page_id'])
			{
				$this->set_user_setting('user_name', $remember_name);
				unset($remember_name);

				if ($body_r)
				{
					$this->set_user_setting('noid_protect', true);
				}
			}

			// now we render it internally so we can write the updated link table.
			$this->update_link_table($this->get_page_id('Comment'.$num), $body_r);

			$this->set_message($this->get_translation('CommentAdded'), 'success');
		}

		// End Comment Captcha
	}

	// redirect to page
	$this->redirect($this->href('', '', 'show_comments=1&p=last').'#Comment'.$num);
}
else
{
	$message =  $this->get_translation('CommentAccessDenied');

	echo '<div id="page">'.$this->show_message($message, 'info')."</div>\n";
}

?>