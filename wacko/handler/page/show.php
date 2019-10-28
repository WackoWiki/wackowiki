<?php

if (!defined('IN_WACKO'))
{
	exit;
}

#$include_tail = '</article>';

// redirect from comment page to the commented one
if ($this->page['comment_on_id'] && !$this->page['deleted'])
{
	// count previous comments
	$count = $this->db->load_single(
		"SELECT COUNT(tag) AS n " .
		"FROM " . $this->db->table_prefix . "page " .
		"WHERE comment_on_id = " . (int) $this->page['comment_on_id'] . " " .
			"AND created <= " . $this->db->q($this->page['created']) . " " .
			"AND deleted <> 1 " .
		"GROUP BY comment_on_id " .
		"LIMIT 1", true);

	// determine comments page number where this comment is located
	$p = ceil($count['n'] / $this->db->comments_count);

	if ($parent_tag = $this->get_page_tag($this->page['comment_on_id']))
	{
		// forcibly open page
		$this->http->redirect($this->href('', $parent_tag, ['show_comments' => 1, 'p' => $p, '#' => $this->page['tag']]));
	}
	else
	{
		$message = $this->_t('AbandonedComment');
		$tpl->n_message = $this->show_message($message, 'error', false);
	}
}

// display page body
if ($this->has_access('read'))
{
	if (!$this->page)
	{
		$this->http->status(404);

		$message = $this->_t('DoesNotExists') . ' ' . ( $this->has_access('create') ?  Ut::perc_replace($this->_t('PromptCreate'), $this->href('edit', '', '', 1)) : '');
		$tpl->n_message = $this->show_message($message, 'notice', false);
	}
	else
	{
		if ($this->page['latest'] == 0)
		{
			// load also deleted pages
			$latest = $this->load_page($this->tag, '', '', '', '', true);
		}

		if ($this->page['deleted'] || !empty($latest['deleted']))
		{
			$this->http->status(404);

			if ($this->is_admin())
			{
				$tpl->restore			= true;
				$tpl->restore_pageid	= $this->page['page_id'];
			}
			else
			{
				$message = $this->_t('PageDeletedInfo'); // TODO: add description: to restore the page you ...
				$message .= '<br>';
				$tpl->n_message = $this->show_message($message, 'warning', false);

				return;
			}
		}

		// revision header
		if ($this->page['latest'] == 0)
		{
			$message = Ut::perc_replace($this->_t('RevisionHint'),
				$this->href(),
				$this->tag,
				$this->get_time_formatted($this->page['modified']),
				$this->user_link($this->page['user_name'], '', true, false));

			// if this is an old revision, display ReEdit button
			if ($this->has_access('write'))
			{
				// check against latest edit for overwrite warning
				if ($this->page['deleted'])
				{
					$latest['modified'] = date('Y-m-d H:i:s');
				}

				if ($latest['deleted'] && $this->is_admin() == false)
				{
					$message .= $this->_t('PageDeletedInfo');
				}
				else
				{
					// reedit form
					$tpl->reedit_href		= $this->href('edit', '', ['revision_id' => (int) $this->page['revision_id']]);
					$tpl->reedit_modified	= $latest['modified'];
					$tpl->reedit_pageid		= $this->page['page_id'];
					$tpl->reedit_message	= $message;
				}
			}
			else
			{
				$tpl->n_message = $this->show_message($message, 'revision-info', false);
			}
		}

		// count page hit (we don't count for page owner)
		if ($this->get_user_id() != $this->page['owner_id'])
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page SET " .
					"hits = hits + 1 " .
				"WHERE page_id = " . (int) $this->page['page_id'] . " " .
				"LIMIT 1");
		}

		$user			= $this->get_user();
		$noid_protect	= $this->get_user_setting('noid_protect');

		// clear new edits for watched page
		if ($user && $this->page['latest'] != 0 && $this->watch['pending'] && !$noid_protect)
		{
			$this->clear_watch_pending($user['user_id'], $this->page['page_id']);
		}

		$this->set_language($this->page_lang);

		// recompile if necessary
		if (($this->page['body_r'] == '')
			|| (($this->page['body_toc'] == '') && $this->db->paragrafica))
		{
			// store to DB (0 -> revision)
			$store					= ($this->page['latest'] ? true : false);
			$this->page['body_r']	= $this->compile_body($this->page['body'], $this->page['page_id'], true, $store);

			$this->http->invalidate_page($this->supertag);
			$this->http->no_cache(false);
		}

		// parse page body
		$data = $this->format($this->page['body_r'], 'post_wacko', ['stripnotypo' => true]);
		$data = $this->numerate_toc($data); //  numerate toc if needed

		// display page title (action & theme wacko.all options)
		if (!$this->hide_article_header)
		{
			$tpl->h_title = isset($this->page['title']) && $this->has_access('read')
				? $this->page['title']
				: $this->get_page_path();
		}

		// display page body
		$tpl->data = $data;

		$this->set_language($this->user_lang);
	}
}
else
{
	$this->http->status(403);

	$message = $this->_t('ReadAccessDenied');
	$tpl->n_message = $this->show_message($message, 'info', false);

	// user might want to login
	/* if ($this->has_access('read', '', GUEST) === false)
	{
		$message = $this->_t('ReadAccessDeniedHintGuest');
		$tpl->n_message = $this->show_message($message, 'hint', false);
	} */
}

// show category tags
if ($this->forum
	|| ($this->has_access('read') && $this->page && $this->db->footer_tags == 1
	|| ($this->db->footer_tags == 2 && $this->get_user())))
{
	if ($categories = $this->action('categories', ['list' => 0, 'nomark' => 1, 'label' => 0], 1))
	{
		$tpl->p_category = $categories;
	}
}

// page comments and files
if ($this->method == 'show' && $this->page['latest'] > 0 && !$this->page['comment_on_id'])
{
	// revoking payload
	if (isset($this->sess->body))
	{
		$payload				= $this->sess->body;
		$this->sess->body		= '';
	}

	if (isset($this->sess->title))
	{
		$title					= $this->sess->title;
		$this->sess->title		= '';
	}

	if (isset($this->sess->preview))
	{
		$preview				= $this->sess->preview;
		$this->sess->preview	= '';
	}

	// places footer inside, to include the footer in the themes footer
	// set $this->db->footer_inside = 0; in theme/lang/wacko.all.php
	if (!isset($this->db->footer_inside))
	{
		// files code starts
		if ($this->db->footer_files == 1 || ($this->db->footer_files == 2 && $this->get_user()))
		{
			require_once Ut::join_path(HANDLER_DIR, 'page/_files.php');
		}

		// comments form output  starts
		if (($this->db->footer_comments == 1 || ($this->db->footer_comments == 2 && $this->get_user()) ) && $this->user_allowed_comments())
		{
			require_once Ut::join_path(HANDLER_DIR, 'page/_comments.php');
		}

		// rating form output begins
		if ($this->has_access('read') && $this->page && $this->db->footer_rating == 1 || ($this->db->footer_rating == 2 && $this->get_user()))
		{
			require_once Ut::join_path(HANDLER_DIR, 'page/_rating.php');
		}
	}
}
