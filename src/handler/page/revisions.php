<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if hide_revisions is true
if ($this->hide_revisions)
{
	$this->http->redirect($this->href());
}

$this->ensure_page(true);

// show minor edits
if ($this->db->minor_edit)
{
	$hide_minor_edit = (bool) ($_GET['minor_edit'] ?? false);
}
else
{
	$hide_minor_edit = false;
}

// show deleted pages
$show_deleted = $this->is_admin();

// get page_id for deleted but stored page
if ($this->page['deleted'])
{
	$tpl->message = $this->show_message($this->_t('PageDeletedInfo'), 'note', false);
}

$tpl->head = Ut::perc_replace($this->_t('RevisionsFor'), $this->compose_link_to_page($this->tag, '', ''));

if ($this->has_access('read'))
{
	// purge link (shows only for page owner if allowed or Admin)
	if (($this->is_owner() && !$this->db->remove_onlyadmins) || $this->is_admin())
	{
		$tpl->remove = true;
	}

	// load revisions for this page
	if ([$revisions, $pagination] = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $show_deleted))
	{
		$this->context[++$this->current_context] = '';

		$user			= $this->get_user();
		$default_mode	= $user['diff_mode'] ?? $this->db->default_diff_mode;
		$diff_modes		= $this->_t('DiffMode');
		$diff_mode_list	= explode(',', $this->db->diff_modes);

		foreach($diff_mode_list as $mode)
		{
			$tpl->r_d_mode		= $mode;
			$tpl->r_d_diffmode	= $diff_modes[$mode];
			$tpl->r_d_checked	= $mode == $default_mode ? ' checked' : '';
		}

		if ($this->db->minor_edit)
		{
			// STS: ?!..
			// filter minor edits
			$tpl->r_m_minor		= $hide_minor_edit;
			$tpl->r_m_href		= $this->href('revisions', '', ['minor_edit' => ($hide_minor_edit ? 0 : 1)]);
			$tpl->r_m_text		= $hide_minor_edit ? $this->_t('MinorEditShow') : $this->_t('MinorEditHide');
		}

		$tpl->r_pagination_text = $pagination['text'];

		$this->parent_size	= 0;

		// get size diff to parent version
		$r_revisions		= array_reverse($revisions);

		foreach ($r_revisions as $r)
		{
			// page_size change
			$size_delta			= $r['page_size'] - $this->parent_size;
			$this->parent_size	= $r['page_size'];

			$this->rev_delta[$r['revision_id']] = $size_delta;
		}

		$tpl->enter('r_l_');

		foreach ($revisions as $num => $page)
		{
			$tpl->value			= (!$num && !$pagination['offset'] ? '-1' : $page['revision_id']);
			$tpl->checkedA		= $num == 1 ? 'checked' : '';
			$tpl->checkedB		= $num == 0 ? 'checked' : '';

			// page_size change
			$tpl->delta			= $this->delta_formatted($this->rev_delta[$page['revision_id']]);
			$tpl->size			= $this->binary_multiples($page['page_size'], false, true, true);
			$tpl->version		= $page['version_id'];
			$tpl->href			= $this->href('show', '', ['revision_id' => $page['revision_id']]);
			$tpl->modified		= $page['modified'];

			$tpl->user			= $this->user_link($page['user_name'], true, false);

			if ($page['edit_note'])
			{
				$tpl->n_note	= $page['edit_note'];
			}

			$tpl->m_minor		= ($page['minor_edit'] ? 'm' : null);

			// review
			if ($this->db->review)
			{
				if ($page['reviewed'])
				{
					$tpl->r_x_user = $this->user_link($page['reviewer'], true, false);
				}
				else if ($this->is_reviewer())
				{
					if (!$num && !$pagination['offset'])
					{
						$tpl->r_review = true;
					}
				}
			}

			if ($page['deleted'])
			{
				$tpl->del	= true;
				$tpl->edel	= true;
			}
		}

		$tpl->leave(); // r_l_
	}

	$this->current_context--;
}
else
{
	$this->http->status(403);

	$tpl->message = $this->show_message($this->_t('ReadAccessDenied'), 'error', false);
}
