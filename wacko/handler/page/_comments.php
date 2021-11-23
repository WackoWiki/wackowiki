<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// get number of user's pages, revisions and comments
$get_user_stats = function ($user_id)
{
	if ($user_id == 0)
	{
		return [];
	}
	else if (isset($this->cached_stats[$user_id]))
	{
		return $this->cached_stats[$user_id];
	}

	$stats = $this->db->load_single(
		"SELECT user_name, " .
			"total_pages AS pages, " .
			"total_revisions AS revisions, " .
			"total_comments AS comments " .
		"FROM {$this->db->user_table} " .
		"WHERE user_id = " . (int) $user_id . " " .
		"LIMIT 1");

	$this->cached_stats[$user_id] = $stats;

	return $stats;
};

// pagination
$pagination = $this->pagination($this->page['comments'], $this->db->comments_count, 'p', ['show_comments' => 1, '#' => 'header-comments']);

// comments form output begins
if ($this->has_access('read'))
{
	// sorting comments ASC / DESC
	$sort_comment	= null;
	$sort_comment	= $this->get_user_setting('sorting_comments');
	$sort_comment	??= $this->db->sorting_comments;

	$show_comments	= (int) ($_GET['show_comments'] ?? null);

	$tpl->enter('cp_s_');

	// store comments display in session
	$this->sess->show_comments[$this->page['page_id']] ??= ($this->get_user_setting('show_comments') ? 1 : 0);

	if (isset($show_comments))
	{
		$this->sess->show_comments[$this->page['page_id']] = match ($show_comments) {
			0 => 0,
			1 => 1,
		};
	}

	// display comments
	if ($this->page && $this->sess->show_comments[$this->page['page_id']] || $this->forum === true)
	{
		$user			= $this->get_user();
		$admin			= $this->is_admin();
		$moder			= $this->is_moderator();
		$noid_protect	= $this->get_user_setting('noid_protect');

		// load comments for this page
		$comments		= $this->load_comments($this->page['page_id'], $pagination['offset'], $this->db->comments_count, $sort_comment);

		// clear new comments for watched page
		if ($user && $comments && isset($this->watch['comment_id']) && $this->watch['comment_id'] && !$noid_protect)
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "watch SET " .
					"comment_id = 0 " .
				"WHERE page_id = " . (int) $this->page['page_id'] . " " .
					"AND user_id = " . (int) $user['user_id']);
		}

		// clear anonymous publication uncorrelator
		if ($noid_protect === true)
		{
			$this->set_user_setting('noid_protect', false);
		}

		$tpl->pagination_text = $pagination['text'];

		$tpl->href		= $this->href('', '', ['show_comments' => 0]);
		$tpl->title		= $this->_t('HideComments');
		$tpl->text		= $this->_t('Comments');

		// display comments themselves
		if ($comments)
		{
			// TODO: evaluate -> option / array to handle nested comments
			// display relation as @link to an extra handler which filters / shows only the current tree

			$tpl->enter('ol_l_');

			foreach ($comments as $comment)
			{
				$this->cache_page($comment, true);

				$tpl->href	= $this->href('', $comment['tag']);
				$tpl->tag	= $comment['tag'];
				$tpl->title	= $comment['title'];

				// show remove comment button
				if ($this->is_admin()
					|| (!$this->db->remove_onlyadmins
						&& ($this->is_owner($comment['page_id'])
						|| ($this->db->owners_can_remove_comments && $this->is_owner($this->page['page_id']))
				)))
				{
					$tpl->b_remove_href = $this->href('remove', $comment['tag']);
				}

				// show edit comment button
				if ($this->is_admin() || $this->is_owner($comment['page_id']))
				{
					$tpl->b_edit_href = $this->href('edit', $comment['tag']);
				}
				else if ((	$this->db->source_handler == 2 && $this->get_user())
					||		$this->db->source_handler == 1)
				{
					$tpl->b_source_href = $this->href('source', $comment['tag']);
				}

				// recompile if necessary
				if (!$comment['body_r'])
				{
					$comment['body_r'] = $this->compile_body($comment['body'], $comment['page_id'], false, true);
				}

				$tpl->comment	= $this->format($comment['body_r'], 'post_wacko', ['strip_notypo' => true]);
				$tpl->owner		= $this->user_link($comment['owner_name']);
				$tpl->created	= $comment['created'];

				($comment['modified'] != $comment['created']
					? $tpl->m_modified = $comment['modified']
					: '');

				/* if ($user_stats = $get_user_stats($comment['owner_id']))
				{
					$tpl->s_comments	= $user_stats['comments'];
					$tpl->s_pages		= $user_stats['pages'];
					$tpl->s_revisions	= $user_stats['revisions'];
				} */
			}

			$tpl->leave(); // ol_l_
		}

		// display comment form
		if ($this->has_access('comment'))
		{
			// invoke autocomplete if needed
			if ((isset($_GET['_autocomplete'])) && $_GET['_autocomplete'])
			{
				include __DIR__ . '/_autocomplete.php';
				return;
			}

			$tpl->enter('f_');

			$title			= $this->forum && empty($title)
								? $this->_t('CommentTitleRe') . ' ' . $this->page['title']
								: ($title ?? '');
			$parent_id		= (int) ($_GET['parent_id'] ?? 0);

			$tpl->parent	= $parent_id;

			// preview
			if (!empty($preview))
			{
				$preview = $this->format($preview, 'pre_wacko');
				$preview = $this->format($preview, 'wacko');
				$preview = $this->format($preview, 'post_wacko', ['strip_notypo' => true, 'strip_ignore' => true]);

				$tpl->p_title		= $title ?? '';
				$tpl->p_preview		= $preview;
			}

			$tpl->userlang	= $this->user_lang;
			$tpl->title		= $this->sess->freecap_old_title
								?? ($title
									?? '');

			$tpl->payload	= Ut::html(
								$this->sess->freecap_old_comment
									?? ($payload
										?? '')
							); // -> [ ' payload | pre ' ]

			if ($user)
			{
				// publish anonymously
				if (($this->page && $this->db->publish_anonymously != 0 && $this->has_access('comment', '', GUEST))
					|| (!$this->page && $this->has_access('create', '', GUEST)))
				{
					$tpl->a_pageid	= $this->page['page_id'];
					$tpl->a_checked	= $this->get_user_setting('noid_pubs') == 1 ? 'checked' : '';
				}

				// watch a page
				if ($this->page && !$this->is_watched)
				{
					$tpl->w_checked	= $this->get_user_setting('send_watchmail') == 1 ? 'checked' : '';
				}
			}

			if ($this->db->captcha_new_comment)
			{
				$tpl->captcha = $this->show_captcha(false);
			}

			// WikiEdit
			if ($user = $this->get_user())
			{
				if ($user['autocomplete'])
				{
					$tpl->autocomplete = true;
				}

				// session heartbeat timeout = wiki session timeout - 40 second
				$tpl->user_heartbeat = $this->sess->cf_gc_maxlifetime - 40;
			}

			$tpl->wikiedit = $this->db->base_path . Ut::join_path(IMAGE_DIR, 'wikiedit') . '/';

			$tpl->leave();
		}
		// end comment form
	}
	else
	{
		$c = $this->page['comments'];

		if ($c < 1)
		{
			if ($this->has_access('comment'))
			{
				$show_comments = $this->_t('Comments0');
			}
		}
		else if	($c == 1)
		{
			$show_comments = $this->_t('Comments1');
		}
		else
		{
			$show_comments = Ut::perc_replace($this->_t('CommentsN'), $c);
		}

		// show link to show comment only if there is one or/and user has the right to add a new one
		if (!empty($show_comments))
		{
			$tpl->href		= $this->href('', '', ['show_comments' => 1, '#' => 'header-comments']);
			$tpl->title		= $this->_t('ShowComments');
			$tpl->text		= $show_comments;
		}
		else
		{
			// TODO: add message if registered users can comment this page
			// e.g. 'Log in or create an account to post a comment.'
		}
	}

	$tpl->leave();
}
