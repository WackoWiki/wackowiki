<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$tpl->page = $this->compose_link_to_page($this->tag, '', '');

$this->ensure_page();

// TODO: config->owners_can_remove_comments ?
if (!($this->is_owner() || $this->is_admin()))
{
	$this->set_message('<em>' . $this->_t('NotOwnerAndCantPurge') . '</em>', 'error');
	$this->show_must_go_on();
}

// purge page
if (@$_POST['_action'] === 'purge_data')
{
	$dontkeep	= (isset($_POST['dontkeep']) && $this->is_admin());
	$title		= $this->tag . ' ' . $this->page['title'];

	if (isset($_POST['comments']))
	{
		$this->remove_comments($this->tag, false, $dontkeep);
		$this->log(1, Ut::perc_replace($this->_t('LogRemovedAllComments', SYSTEM_LANG), $title));
		$message[] = $this->_t('CommentsPurged');
	}

	if (isset($_POST['files']))
	{
		$this->remove_files_perpage($this->tag, false, $dontkeep);
		$this->log(1, Ut::perc_replace($this->_t('LogRemovedAllFiles', SYSTEM_LANG), $title));
		$message[] = $this->_t('FilesPurged');
	}

	if (isset($_POST['revisions']) && $this->is_admin())
	{
		$this->remove_revisions($this->tag, false, $dontkeep);
		$this->update_revisions_count($this->page['page_id']);
		$this->log(1, Ut::perc_replace($this->_t('LogRemovedAllRevisions', SYSTEM_LANG), $title));
		$message[] = $this->_t('RevisionsPurged');
	}

	// purge related page cache
	if ($this->http->invalidate_page($this->tag))
	{
		$message[] = $this->_t('PageCachePurged');
	}

	// purge SQL queries cache
	$this->db->invalidate_sql_cache();

	foreach ($message as $notice)
	{
		$tpl->p_l_notice = $notice;
	}
}
else
{
	// show purge form
	$tpl->f = true;

	if ($this->is_admin())
	{
		$tpl->f_admin = true;

		if ($this->db->store_deleted_pages)
		{
			$tpl->f_admin_dontkeep = true;
		}
	}
}
