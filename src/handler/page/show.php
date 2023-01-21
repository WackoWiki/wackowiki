<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect from comment page to the commented one
if (isset($this->page['latest']) && $this->page['comment_on_id'] && !$this->page['deleted'])
{
	// count previous comments
	$count = $this->db->load_single(
		"SELECT COUNT(tag) AS n " .
		"FROM " . $this->prefix . "page " .
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

		$message = $this->_t('DoesNotExists') . ' ' .
			($this->has_access('create')
				?  Ut::perc_replace($this->_t('PromptCreate'), $this->href('edit', '', '', true))
				: '');
		$tpl->n_message = $this->show_message($message, 'notice', false);
	}
	else
	{
		if ($this->page['latest'] == 0)
		{
			// load also deleted pages
			$latest = $this->load_page($this->tag, null, null, null, LOAD_ALL, true);
		}

		if ($this->page['deleted'] || !empty($latest['deleted']))
		{
			$this->http->status(404);

			if ($this->is_admin())
			{
				$tpl->restore			= true;
				$tpl->restore_pageid	= $this->page['page_id'];

				if ($this->page['latest'] == 0)
				{
					$tpl->restore_revisionid	= $this->page['revision_id'];
				}

				$tpl->restore_message	= $this->page['comment_on_id']
											? $this->_t('CommentDeletedInfo')
											: (!$this->page['latest']
												? $this->_t('RevisionDeletedInfo')
												: $this->_t('PageDeletedInfo'));
			}
			else
			{
				// TODO: it never reaches this point, currently only admins can see pages/comments marked as deleted
				// TODO: add description: to restore the page you ...
				$message = $this->page['comment_on_id']
					? $this->_t('CommentDeletedInfo')
					: $this->_t('PageDeletedInfo');
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
				$this->sql_time_formatted($this->page['modified']),
				$this->user_link($this->page['user_name'], true, false));

			// if this is an old revision, display ReEdit button
			if ($this->has_access('write'))
			{
				// check against latest edit for overwrite warning
				if ($this->page['deleted'])
				{
					$latest['modified'] = date('Y-m-d H:i:s');
				}

				if ($latest['deleted'] && !$this->is_admin())
				{
					$message .= $this->_t('PageDeletedInfo');
				}
				else
				{
					$tpl->enter('tools_');
					$tpl->message			= $message;

					if(!$this->page['deleted'])
					{
						// re-edit form
						$tpl->reedit_href		= $this->href('edit', '', ['revision_id' => (int) $this->page['revision_id']]);
						$tpl->reedit_modified	= $latest['modified'];
						$tpl->reedit_pageid		= $this->page['page_id'];
					}

					// delete revision form
					if (($this->is_admin()
						|| (!$this->db->remove_onlyadmins
							&& ($this->get_page_owner_id($this->page['page_id']) == $this->get_user_id())))
						&& !$this->page['deleted']
					)
					{
						$tpl->remove_href		= $this->href('remove', '', ['revision_id' => (int) $this->page['revision_id']]);
						$tpl->remove_pageid		= $this->page['page_id'];
					}

					$tpl->leave();	// tools_
				}
			}
			else
			{
				$tpl->n_message = $this->show_message($message, 'revision-info', false);
			}

			// revision navigation
			$tpl->enter('nav_');

			[$revisions, $pagination] = $this->load_revisions($this->page['page_id'], false, $this->is_admin());

			$revision_menu = function ($side) use ($revisions, &$tpl)
			{
				$tpl->enter($side . '_');

				$tpl->href		= $this->href('', '', ($this->page['revision_id'] > 0? ['revision_id' => $this->page['revision_id']] : ''));
				$tpl->version	= Ut::perc_replace($this->_t('RevisionAsOf'), '<strong>' . $this->page['version_id'] . '</strong>');
				$tpl->modified	= $this->page['modified'];
				$tpl->username	= $this->user_link($this->page['user_name'], true, true);
				$tpl->n_note	= $this->page['edit_note'] ?: null;
				$tpl->m_minor	= $this->page['minor_edit'] ? 'm' : null;

				// previous & next revision navigation
				$revision_id	= $this->page['revision_id'];
				$key			= array_search($revision_id, array_column($revisions, 'revision_id'));
				$diffmode		= $this->db->default_diff_mode;

				if (array_key_exists($key + 1, $revisions))
				{
					$tpl->prev_href		= $this->href('', '', ['revision_id' => $revisions[$key + 1]['revision_id']]);
					$tpl->prev_diff		= $this->href('diff', '', ['a' => $revisions[$key + 1]['revision_id'], 'b' => $this->page['revision_id'], 'diffmode' => $diffmode]);
				}

				if (array_key_exists($key, $revisions))
				{
					$tpl->latest_href	= $this->href('', '', ['revision_id' => 0]);
					$tpl->latest_diff	= $this->href('diff', '', ['a' => $this->page['revision_id'], 'b' => 0, 'diffmode' => $diffmode]);
				}

				if (array_key_exists($key - 1, $revisions))
				{
					$tpl->next_href		= $this->href('', '', ['revision_id' => $revisions[$key - 1]['revision_id']]);
					$tpl->next_diff		= $this->href('diff', '', ['a' => $this->page['revision_id'], 'b' => $revisions[$key - 1]['revision_id'], 'diffmode' => $diffmode]);
				}

				// dropdown navigation
				$tpl->enter('r_');

				foreach ($revisions as $r)
				{
					if ($r['revision_id'] == $this->page['revision_id'])
					{
						$href	= '#';
						$class	= ' class="active"';
					}
					else
					{
						$params	= ['revision_id' => $r['revision_id']];
						$href	= $this->href('', '', $params);
						$class	= '';
					}

					$tpl->href		= $href;
					$tpl->class		= $class;
					$tpl->version	= $r['version_id'];
					$tpl->modified	= $r['modified'];
					$tpl->username	= $r['user_name'] ?: $this->_t('Guest');
					$tpl->editnote	= $r['edit_note'] ?: null;
				}

				$tpl->leave();	// r_
				$tpl->leave();	// side_
			};

			$revision_menu('a');

			$tpl->leave();	// nav
		}

		// count page hit (we don't count for page owner)
		if ($this->db->enable_counters
			&& ($this->get_user_id() != $this->page['owner_id']))
		{
			$this->db->sql_query(
				"UPDATE " . $this->prefix . "page SET " .
					"hits = hits + 1 " .
				"WHERE page_id = " . (int) $this->page['page_id'] . " " .
				"LIMIT 1");
		}

		$user			= $this->get_user();
		$noid_protect	= $this->get_user_setting('noid_protect');

		// clear new edits for watched page
		if ($user
			&& (isset($this->page['latest']) && $this->page['latest'])
			&& (isset($this->watch['pending']) && $this->watch['pending'])
			&& !$noid_protect)
		{
			$this->clear_watch_pending($user['user_id'], $this->page['page_id']);
		}

		$this->set_language($this->page_lang);

		// recompile if necessary
		if (($this->page['body_r'] == '')
			|| (($this->page['body_toc'] == '') && $this->db->paragrafica))
		{
			// store to DB (0 -> revision)
			$store					= (bool) $this->page['latest'];
			$this->page['body_r']	= $this->compile_body($this->page['body'], $this->page['page_id'], true, $store);

			$this->http->invalidate_page($this->tag);
			$this->http->no_cache(false);
		}

		// parse page body
		$data = $this->format($this->page['body_r'], 'post_wacko', ['strip_marker' => true]);
		$data = $this->numerate_toc($data); //  numerate toc if needed

		// display page title (action & theme wacko.all options)
		if (!$this->hide_article_header)
		{
			$tpl->h_title = isset($this->page['title']) && $this->has_access('read')
				? $this->page['title']
				: $this->get_page_path();

			if ($this->db->section_edit && $this->has_access('write'))
			{
				// show edit link
				$tpl->h_edit = true;
			}
		}

		// display page body
		$tpl->data = $data;

		$this->set_language($this->user_lang);
	}
}
else
{
	$this->http->status(403);

	$message		= $this->_t('ReadAccessDenied');
	$tpl->n_message	= $this->show_message($message, 'note', false);

	// user might want to login
	/* if ($this->has_access('read', '', GUEST) === false)
	{
		$message = $this->_t('ReadAccessDeniedHintGuest');
		$tpl->n_message = $this->show_message($message, 'hint', false);
	} */
}

// show category tags
if ($this->forum
	|| ($this->has_access('read') && $this->page
		&&  $this->db->footer_tags == 1
		|| ($this->db->footer_tags == 2 && $this->get_user())))
{
	if ($categories = $this->action('categories', ['list' => 0, 'nomark' => 1, 'label' => 0], true))
	{
		$tpl->p_category		= $categories;
	}
}

// page comments and files
if ($this->method == 'show' && (isset($this->page['latest']) && $this->page['latest'] > 0) && !$this->page['comment_on_id'])
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
		if (    $this->db->footer_files == 1
			|| ($this->db->footer_files == 2 && $this->get_user()))
		{
			require_once Ut::join_path(HANDLER_DIR, 'page/_files.php');
		}

		// comments form output starts
		if ((   $this->db->footer_comments == 1
			|| ($this->db->footer_comments == 2 && $this->get_user()) )
			&& $this->user_allowed_comments())
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
