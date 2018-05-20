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
	$hide_minor_edit = (int) @$_GET['minor_edit'];
}
else
{
	$hide_minor_edit = 0;
}

// show deleted pages
$show_deleted = $this->is_admin();

// get page_id for deleted but stored page
if ($this->page['deleted'])
{
	$tpl->message = $this->show_message($this->_t('PageDeletedInfo'), 'info', false);
}

if ($this->has_access('read'))
{
	// load revisions for this page
	if (list ($revisions, $pagination) = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $show_deleted))
	{
		$this->context[++$this->current_context] = '';

		$user			= $this->get_user();
		$default_mode	= $user['diff_mode'] ?: $this->db->default_diff_mode;
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

		$diff_class			= '';
		$this->parent_size	= 0;

		// get size diff to parent version
		$r_revisions = array_reverse($revisions);

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
			if ($page['deleted'])
			{
				$tpl->del	= true;
				$tpl->edel	= true;
			}

			$tpl->value			= (!$num && !$pagination['offset'] ? '-1' : $page['revision_id']);
			$tpl->checkedA		= $num == 0 ? 'checked' : '';
			$tpl->checkedB		= $num == 1 ? 'checked' : '';

			// page_size change
			$tpl->delta			= $this->delta_formatted($this->rev_delta[$page['revision_id']]);
			$tpl->size			= $this->binary_multiples($page['page_size'], false, true, true);
			$tpl->version		= $page['version_id'];
			$tpl->href			= $this->href('show', '', ['revision_id' => $page['revision_id']]);
			$tpl->modified		= $page['modified'];

			$tpl->user			= $this->user_link($page['user_name'], '', true, false);
			if ($page['edit_note'])
			{
				$tpl->n_note		= $page['edit_note'];
			}
			$tpl->minor			= ($page['minor_edit'] ? 'm' : '');

			// review
			if ($this->db->review)
			{
				if ($page['reviewed'])
				{
					$tpl->r_x_user = $this->user_link($page['reviewer'], '', true, false);
				}
				else if ($this->is_reviewer())
				{
					if (!$num)
					{
						$tpl->r_review = true;
					}
				}
			}
		}

		$tpl->leave();
	}

	$this->current_context--;
}
else
{
	$tpl->message = $this->show_message($this->_t('ReadAccessDenied'), 'error', false);
}
