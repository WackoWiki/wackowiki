<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo ADD_NO_DIV . '<article id="page-show" class="page" data-dbclick1="page">' . "\n";
$include_tail = '</article>';

// redirect from comment page to the commented one
if ($this->page['comment_on_id'] && !$this->page['deleted'])
{
	// count previous comments
	$count = $this->db->load_single(
		"SELECT COUNT(tag) AS n ".
		"FROM {$this->db->table_prefix}page ".
		"WHERE comment_on_id = '" . $this->page['comment_on_id'] . "' ".
			"AND created <= " . $this->db->q($this->page['created']) . " ".
			"AND deleted <> '1' ".
		"GROUP BY comment_on_id ".
		"LIMIT 1", true);

	// determine comments page number where this comment is located
	$p = ceil($count['n'] / $this->db->comments_count);

	// forcibly open page
	$this->http->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), ['show_comments' => 1, 'p' => $p, '#' => $this->page['tag']]));
}

// display page body
if ($this->has_access('read'))
{
	if (!$this->page)
	{
		$this->http->status(404);

		$message = $this->_t('DoesNotExists') . " " . ( $this->has_access('create') ?  Ut::perc_replace($this->_t('PromptCreate'), $this->href('edit', '', '', 1)) : '');
		$this->show_message($message, 'notice');
	}
	else
	{
		if ($this->page['deleted'])
		{
			$this->http->status(404);

			if ($this->is_admin())
			{
				$message = $this->_t('PageDeletedInfo'); // TODO: add description: to restore the page you ...
				$message .= '<br /><br />';
				$message .= $this->form_open('restore_page', ['page_method' => 'restore']);
				#$message .= '<input type="hidden" name="previous" value="' . $latest['modified'] . '" />';
				$message .= '<input type="hidden" name="id" value="' . $this->page['page_id'] . '" />';
				#$message .= '<input type="hidden" name="body" value="' . htmlspecialchars($this->page['body'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '" />';
				$message .= '<input type="submit" value="' . $this->_t('RestoreButton') . '" />';
				#$message .= '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" name="cancel" id="button" value="' . $this->_t('EditCancelButton') . '"/></a>';
				$message .= $this->form_close();
			}
			else
			{
				$message = $this->_t('PageDeletedInfo'); // TODO: add description: to restore the page you ...
				$message .= '<br />';
			}

			$this->show_message($message, 'warning');
		}

		// revision header
		if ($this->page['latest'] == 0)
		{
			$message = Ut::perc_replace($this->_t('Revision'),
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
				else
				{
					// load also deleted pages
					$latest = $this->load_page($this->tag, '', '', '', '', true);
				}

				if ($latest['deleted'] && $this->is_admin() == false)
				{
					$this->show_message($this->_t('PageDeletedInfo'), 'info');
				}
				else
				{
					$message .= '<br /><br />';
					$message .= $this->form_open('edit_revision', ['page_method' => 'edit']);
					$message .= '<input type="hidden" name="previous" value="' . $latest['modified'] . '" />';
					$message .= '<input type="hidden" name="id" value="' . $this->page['page_id'] . '" />';
					$message .= '<input type="hidden" name="body" value="' . htmlspecialchars($this->page['body'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '" />';
					$message .= '<input type="submit" value="' . $this->_t('ReEditOldRevision') . '" />';
					$message .= '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" name="cancel" id="button" value="' . $this->_t('EditCancelButton') . '"/></a>';
					$message .= $this->form_close();
				}
			}

			$this->show_message($message, 'revisioninfo');
		}

		// count page hit (we don't count for page owner)
		if ($this->get_user_id() != $this->page['owner_id'])
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page SET ".
					"hits = hits + 1 ".
				"WHERE page_id = '" . $this->page['page_id'] . "'");
		}

		$user			= $this->get_user();
		$noid_protect	= $this->get_user_setting('noid_protect');

		// clear new edits for watched page
		if ($user && $this->page['latest'] != 0 && !$noid_protect)
		{
			$this->db->sql_query(
				"UPDATE {$this->db->table_prefix}watch SET ".
					"pending = '0' ".
				"WHERE page_id = '" . $this->page['page_id'] . "' ".
					"AND user_id = '" . $user['user_id'] . "'");
		}

		$this->set_language($this->page_lang);

		// recompile if necessary
		if (($this->page['body_r'] == '')
			|| (($this->page['body_toc'] == '') && $this->db->paragrafica))
		{
			// build html body
			$this->page['body_r'] = $this->format($this->page['body'], 'wacko');

			// build toc
			if ($this->db->paragrafica)
			{
				$this->page['body_r']	= $this->format($this->page['body_r'], 'paragrafica');
				$this->page['body_toc']	= $this->body_toc;
			}

			// store to DB
			if ($this->page['latest'] != 0)
			{
				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "page SET ".
						"body_r		= " . $this->db->q($this->page['body_r']) . ", ".
						"body_toc	= " . $this->db->q($this->page['body_toc']) . " ".
					"WHERE page_id = '" . $this->page['page_id'] . "' ".
					"LIMIT 1");
			}
		}

		// parse page body
		$data = $this->format($this->page['body_r'], 'post_wacko', ['bad' => 'good']);
		$data = $this->numerate_toc($data); //  numerate toc if needed

		// display page title
		if (!$this->hide_article_header)
		{
			echo "<header>\n".
				 '<h1>';
			echo isset($this->page['title']) && $this->has_access('read')
				? $this->page['title']
				: $this->get_page_path();

			echo "</h1>\n".
				 "</header>\n";
		}

		echo '<section id="section-content">';

		// display page body
		echo $data;

		$this->set_language($this->user_lang);

		// edit via double click
		echo '<script>var dbclick = "page";</script>'."\n";

		// end section-content
		echo "</section>\n";
	}
}
else
{
	$this->http->status(403);

	$message = $this->_t('ReadAccessDenied');
	$this->show_message($message, 'info');

	if ($this->has_access('read', '', GUEST) === false)
	{
		$message = $this->_t('ReadAccessDeniedHintGuest');
		$this->show_message($message, 'hint');
	}
}

// show category tags
if ($this->forum
	|| ($this->has_access('read') && $this->page && $this->db->footer_tags == 1
	|| ($this->db->footer_tags == 2 && $this->get_user())))
{
	if ($categories = $this->action('categories', ['page' => '/' . $this->page['tag'], 'list' => 0, 'nomark' => 1], 1))
	{
		echo '<nav class="category">' . $categories . "</nav>\n";
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
