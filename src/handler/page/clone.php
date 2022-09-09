<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$tpl->headLink = $this->compose_link_to_page($this->tag, '', '');

// ensure that's not forum or comment
$this->ensure_page();

if (!$this->has_access('read'))
{
	$this->set_message($this->_t('ReadAccessDenied'), 'error');
	$this->show_must_go_on();
}

$from		= $this->tag;
$edit_note	= Ut::perc_replace($this->_t('ClonedFrom'), $this->tag);


if (@$_POST['_action'] === 'clone_page')
{
	$to = (string) ($_POST['clone_name'] ?? '');

	if ($error = $this->sanitize_new_page_tag($to, $from))
	{
		$this->set_message($error, 'error');
		$this->reload_me();
	}

	if (isset($_POST['edit_note']))
	{
		$edit_note = $_POST['edit_note'];
	}

	$jump = $to;

	if (!isset($_POST['massclone']))
	{
		$this->clone_page($from, $to, $edit_note);
		$this->log(4, Ut::perc_replace($this->_t('LogClonedPage', SYSTEM_LANG), $from, $to));
		$log = Ut::perc_replace($this->_t('PageCloned'), $this->link('/' . $to));
	}
	else
	{
		//massclone
		$log = $tpl->massLog();

		$pages = $this->db->load_all(
			"SELECT page_id, tag " .
			"FROM " . $this->prefix . "page " .
			"WHERE (tag LIKE " . $this->db->q($from . '/%') . " " .
				"OR tag = " . $this->db->q($from) . ") " .
				"AND comment_on_id = 0");

		$slashes	= (int) @utf8_count_chars($from, 1)['/']; // @ to return 0 when no slashes used
		$work		= [];

		foreach ($pages as $page)
		{
			// rebase page to cloned root
			$src = $page['tag'];

			for ($pos = 0, $i = $slashes; ($pos = mb_strpos($src, '/', $pos)) !== false && $i--; ++$pos);
			$dst = $to . ($pos? mb_substr($src, $pos) : '');

			if ($this->load_page($dst, 0, '', LOAD_CACHE, LOAD_META))
			{
				$log->err_a_error = Ut::perc_replace($this->_t('AlreadyExists'), '<strong>' . $this->compose_link_to_page($dst, '', '') . '</strong>');
			}
			else if (!$this->has_access('read', $page['page_id']))
			{
				$this->set_message(
					Ut::perc_replace($this->_t('CloneCannotRead'), '<strong>' . $this->compose_link_to_page($src, '', '') . '</strong>'),
					'error');

				if ($dst === $to)
				{
					$jump = '';
				}

				continue;
			}
			else if (!$this->has_access('create', '', '', 1, $dst))
			{
				$log->err_a_error = Ut::perc_replace($this->_t('CloneCannotCreate'), '<strong>' . $this->compose_link_to_page($dst, '', '') . '</strong>');
			}

			$work[$src] = $dst;
		}

		if ($log->err_a)
		{
			$this->set_message($log, 'error');
			$this->reload_me();
		}

		foreach ($work as $src => $dst)
		{
			$this->clone_page($src, $dst, '', $edit_note);
			$this->log(4, Ut::perc_replace($this->_t('LogClonedPage', SYSTEM_LANG), $src, $dst));
			$log->log_l_message = Ut::perc_replace($this->_t('PageCloned'), $this->link('/' . $dst));
		}

		if ($log->log_l)
		{
			$log->log_h_to = $to;
		}
	}

	$this->set_message($log);

	// jump to new clone
	$this->http->redirect($this->href('', $jump));
}

$tpl->enter('form_');

if ($this->check_acl($this->get_user_name(), $this->db->rename_global_acl))
{
	$klusterwerks = $this->db->load_single(
		"SELECT COUNT(*) AS n " .
		"FROM " . $this->prefix . "page " .
		"WHERE (tag LIKE " . $this->db->q($from . '/%') . ") " .
			"AND comment_on_id = 0");

	if ((int) $klusterwerks['n'])
	{
		$tpl->doCluster = true;
	}
}

// STS $add = (@$_GET['add'] || @$_POST['add']);
$tpl->href = $this->href('clone');

// edit note
if ($this->db->edit_summary)
{
	$tpl->e_note = $edit_note;
}

$tpl->show			= $this->href();
$tpl->placeholder	= $this->tag;

$tpl->leave();	// form_
