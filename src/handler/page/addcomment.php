<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('comment') && $this->has_access('read'))
{
	// === AJAX LIVE PREVIEW (for WikiEdit side-by-side pane) ===
	if (isset($_POST['ajax_preview']) && $_POST['ajax_preview'] === '1')
	{
		$_body      = $_POST['body'] ?? '';
		$title      = $_POST['title'] ?? ($this->page['title'] ?? $this->get_page_title($this->tag));
		#$section_id = (int) ($_POST['section'] ?? 0);

		$preview = '';
		$text_chars = '0';

		if ($_body !== '')
		{
			$text_chars = $this->number_format(mb_strlen($_body));

			$preview = $this->format($_body, 'pre_wacko');
			$preview = $this->format($preview, 'wacko');
			$preview = $this->format($preview, 'post_wacko', ['strip_marker' => true]);
		}

		$new_form_token = $this->sess->create_nonce('add_comment', max(30, $this->db->form_token_time));

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([
			'preview_html'   => $preview,
			'new_form_token' => $new_form_token,
			'chars'          => $text_chars
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		exit;   // important – do not continue with normal form rendering
	}

	// === AJAX FILE UPLOAD (for WikiEdit drag & drop + paste) ===
	// Triggered when JS sends FormData with action=upload + $_FILES['file']
	if (isset($_POST['action']) && $_POST['action'] === 'upload' && isset($_FILES['file']))
	{
		$file = $_FILES['file'];

		// Use WackoWiki's built-in upload method (respects all permissions, file types, quotas, etc.)
		$result = $this->upload_file(
			$file,
			$this->tag,                     // current page tag
			$this->page['page_id'] ?? 0     // page_id (0 for new pages)
			);

		header('Content-Type: application/json; charset=utf-8');

		if ($result && !empty($result['filename']))
		{
			echo json_encode(['filename' => $result['filename']]);
		}
		else
		{
			echo json_encode(['error' => $result['error'] ?? 'Upload failed']);
		}

		exit;
	}

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
