<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: exclude service and system pages
//		either by user 'SYSTEM' or better via service: namespace

// process input
if (isset($_POST['tag']) && $new_tag = utf8_trim($_POST['tag'], '.-/ '))
{
	switch ((int) $_POST['option'])
	{
		case 1:
			$prefix = $this->tag . '/';
			break;
		case 2:
			$prefix = mb_substr($this->tag, 0, mb_strrpos($this->tag, '/') + 1);
			break;
		default:
			$prefix = '';
	}

	$this->sanitize_page_tag($new_tag);

	if (!preg_match('#^([-/\'_.' . $this->language['ALPHANUM_P'] . ']+)$#u', $new_tag))
	{
		$this->set_message($this->_t('InvalidWikiName'));
	}

	// check reserved word
	if ($result = $this->validate_reserved_words($new_tag))
	{
		$this->set_message(Ut::perc_replace($this->_t('PageReservedWord'), '<code>' . $result . '</code>'));
	}
	// check target page existence
	else if ($page = $this->load_page($prefix . $new_tag, 0, '', LOAD_CACHE, LOAD_META))
	{
		$message = Ut::perc_replace($this->_t('PageAlreadyExists'), '<code>' . $page['tag'] . '</code>') . ' ';

		// check existing page write access
		if ($this->has_access('write', $this->get_page_id($prefix . $new_tag)))
		{
			$message .= Ut::perc_replace(
				$this->_t('PageAlreadyExistsEdit'),
				'<a href="' . $this->href('edit', $prefix . $new_tag) . '">' . $this->_t('PageAlreadyExistsEdit2') . '</a>');
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
			// keep the original input for page title
			$this->sess->title = $this->create_title_from_tag($new_tag);

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
	$tpl->p_f_base		= (mb_strlen($this->tag) > 50 ? '...' . mb_substr($this->tag, -50) : $this->tag);
	$tpl->p_f_tag		= (isset($_POST['option']) && $_POST['option'] === 1 ? $new_tag : '');
}
else
{
	$message			= '<em>' . $this->_t('CreatePageDenied') . '</em>';
	$tpl->p_d_message	= $this->show_message($message, 'note', false);
}

// create a child page. only inside a cluster
if (mb_substr_count($this->tag, '/') > 0)
{
	$parent = mb_substr($this->tag, 0, mb_strrpos($this->tag, '/'));

	if ($this->has_access('create', $this->get_page_id($parent)))
	{
		// hide users cluster
		if ($parent != $this->db->users_page)
		{
			$tpl->c_f_base	= (mb_strlen($parent) > 50 ? '...' . mb_substr($parent, -50) : $parent);
			$tpl->c_f_tag	= (isset($_POST['option']) && $_POST['option'] === 2 ? $new_tag : '');
		}
	}
	else
	{
		$message			= '<em>' . $this->_t('CreatePageDenied') . '</em>';
		$tpl->c_d_message	= $this->show_message($message, 'note', false);
	}
}

// create a random page
$tpl->tag;

