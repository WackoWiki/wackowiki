<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('comment') && $this->has_access('read'))
{
	$body				= str_replace("\r", '', rtrim(($_POST['body'] ?? '')));
	$error				= '';
	$title				= trim(($_POST['title'] ?? ''));
	$parent_id			= (int) ($_POST['parent_id'] ?? 0);
	$watchpage			= (int) ($_POST['watchpage'] ?? 0);
	$noid_publication	= (int) ($_POST['noid_publication'] ?? 0);

	$user		= $this->get_user();

	// if form token failed
	if (!$_POST)
	{
		if (!$user)
		{
			$this->http->invalidate_page($this->tag);
		}

		$this->sess->body	= $body;
		$this->sess->title	= $title;

		$this->http->redirect($this->href('', '', ['show_comments' => 1, 'p' => 'last']));
	}

	// find last comment number
	if ($latest_comment = $this->db->load_single(
		'SELECT tag, page_id
		FROM ' . $this->prefix . 'page
		WHERE comment_on_id <> 0
		ORDER BY page_id DESC
		LIMIT 1'))
	{
		preg_match('/^Comment(\d+)$/', $latest_comment['tag'], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = 1;
	}

	// watch page
	if ($this->page
		&& ($watchpage)
		&& ($noid_publication != $this->page['page_id'])
		&& $user
		&& !$this->is_watched)
	{
		$this->set_watch($user['user_id'], $this->page['page_id']);
	}

	if (!$body)
	{
		if (!$user)
		{
			$this->http->invalidate_page($this->tag);
		}

		$this->set_message($this->_t('EmptyComment'));
	}
	else if (isset($_POST['preview']))
	{
		// comment preview
		if (!$user)
		{
			$this->http->invalidate_page($this->tag);
		}

		$this->sess->preview	= $body;
		$this->sess->body		= $body;
		$this->sess->title		= $title;

		$this->http->redirect($this->href('', '', ['show_comments' => 1, 'p' => 'last']) . '#preview');
	}
	else if (isset($this->sess->comment_delay) && time() - $this->sess->comment_delay < $this->db->comment_delay)
	{
		// posting flood protection
		if (!$user)
		{
			$this->http->invalidate_page($this->tag);
		}

		$this->sess->body			= $body;
		$this->sess->title			= $title;
		$this->sess->comment_delay	= time();

		$message = Ut::perc_replace($this->_t('CommentFlooded'), $this->db->comment_delay);
		$this->set_message($message, 'error');
		$this->http->redirect($this->href('', '', ['show_comments' => 1, 'p' => 'last']));
	}
	else if ($bad_words = $this->bad_words($body))
	{
		$this->sess->body			= $body;
		$this->sess->title			= $title;
		$this->sess->comment_delay	= time();

		$message = $bad_words;
		$this->set_message($message , 'error');

		$this->http->redirect($this->href('', '', ['show_comments' => 1, 'p' => 'last']));
	}
	else
	{
		// captcha validation
		if (isset($this->sess->freecap_old_title))
		{
			unset($this->sess->freecap_old_title);
		}

		if (isset($this->sess->freecap_old_comment))
		{
			unset($this->sess->freecap_old_comment);
		}

		if ($this->db->captcha_new_comment && !$this->validate_captcha())
		{
			$error = $this->_t('CaptchaFailed');
			$this->set_message($error, 'error');
			$this->sess->freecap_old_title		= $title;
			$this->sess->freecap_old_comment	= $body;
		}

		// everything's okay
		$this->sess->preview		= '';
		$this->sess->body			= '';
		$this->sess->title			= '';
		$this->sess->comment_delay	= time();

		// publish anonymously
		if ($noid_publication == $this->page['page_id'])
		{
			// undefine username
			$remember_name = $this->get_user_name();
			$this->set_user_setting('user_name', null);
		}

		if (!$error)
		{
			// find number
			$comment_on_id		= $this->page['page_id'];
			$tag				= 'Comment' . $num;
			$this->section_tag	= $tag;
			$this->new_comment	= true;

			// store new comment
			$body_r = $this->save_page($tag, $body, $title, '', false, 0, $comment_on_id, $parent_id);

			// log event
			$this->log(5, Ut::perc_replace($this->_t('LogCommentPosted', SYSTEM_LANG), $tag, $this->tag . ' ' . $this->page['title']));

			// restore username after anonymous publication
			if ($noid_publication == $this->page['page_id'])
			{
				$this->set_user_setting('user_name', $remember_name);
				unset($remember_name);

				if ($body_r)
				{
					$this->set_user_setting('noid_protect', true);
				}
			}

			// now we render it internally, so we can write the updated page_link table.
			$this->update_link_table($this->get_page_id($tag), $body_r);

			$this->set_message($this->_t('CommentAdded'), 'success');
		}
	}

	// redirect to page
	$this->http->redirect($this->href('', '', ['show_comments' => 1, 'p' => 'last']) . '#Comment' . $num);
}
else
{
	$this->show_message($this->_t('CommentAccessDenied'));
}
