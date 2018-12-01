<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: exclude service and system pages
//		either by user 'SYSTEM' or better via service: namespace

// process input
if (isset($_POST['tag']) && $new_tag = trim($_POST['tag'], '/ '))
{
	switch ((int) $_POST['option'])
	{
		case 1:
			$prefix = $this->tag . '/';
			break;
		case 2:
			$prefix = substr($this->tag, 0, strrpos($this->tag, '/') + 1);
			break;
		default:
			$prefix = '';
	}

	// check reserved word
	if ($result = $this->validate_reserved_words($new_tag))
	{
		$this->set_message(Ut::perc_replace($this->_t('PageReservedWord'), $result));
	}
	// check target page existance
	else if ($page = $this->load_page($prefix . $new_tag, 0, '', LOAD_CACHE, LOAD_META))
	{
		$message = Ut::perc_replace($this->_t('PageAlreadyExists'), '<code>' . $page['tag'] . '</code>') . ' ';

		// check existing page write access
		if ($this->has_access('write', $this->get_page_id($prefix . $new_tag)))
		{
			$message .= Ut::perc_replace($this->_t('PageAlreadyExistsEdit'), '<a href="' . $this->href('edit', $prefix . $new_tag) . '">' . $this->_t('PageAlreadyExistsEdit2') . '</a>');
		}
		else
		{
			$message .= $this->_t('PageAlreadyExistsEditDenied');
		}

		$this->set_message($message);
	}
	else
	{
		// check new page write access
		if ($this->has_access('create', $this->get_page_id($prefix . $new_tag)))
		{
			// keep the original input for page titel
			$this->sess->title = $new_tag;

			// str_replace: fixes newPage&amp;add=1
			$this->http->redirect(str_replace('&amp;', '&', ($this->href('edit', $prefix . $new_tag, '', 1))));
		}
		else
		{
			$this->set_message($this->_t('CreatePageDeniedAddress'));
		}
	}
}

// create a peer page
if ($this->has_access('create', $this->get_page_id($this->tag)))
{
	$tpl->p_f_base	= (strlen($this->tag) > 50 ? '...' . substr($this->tag, -50) : $this->tag);
	$tpl->p_f_tag	= (isset($_POST['option']) && $_POST['option'] === 1 ? Ut::html($new_tag) : '');
}
else
{
	$message = '<em>' . $this->_t('CreatePageDenied') . '</em>';
	$tpl->p_d_message	= $this->show_message($message, 'info', false);
}

// create a child page. only inside a cluster
if (substr_count($this->tag, '/') > 0)
{
	$parent = substr($this->tag, 0, strrpos($this->tag, '/'));

	if ($this->has_access('create', $this->get_page_id($parent)))
	{
		// hide users cluster
		if ($parent != $this->db->users_page)
		{
			$tpl->c_f_base	= (strlen($parent) > 50 ? '...' . substr($parent, -50) : $parent);
			$tpl->c_f_tag	= (isset($_POST['option']) && $_POST['option'] === 2 ? Ut::html($new_tag) : '');
		}
	}
	else
	{
		$message = '<em>' . $this->_t('CreatePageDenied') . '</em>';
		$tpl->c_d_message	= $this->show_message($message, 'info', false);
	}
}

// create a random page
$tpl->tag;

