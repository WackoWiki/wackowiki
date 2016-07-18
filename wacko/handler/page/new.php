<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo ADD_NO_DIV . '<div id="page" class="page">' . "\n";
$include_tail = '</div>';

echo '<h3>' . $this->get_translation('CreateNewPage') . "</h3>\n<br />\n";

// process input
if (isset($_POST['tag']) && $new_tag = trim($_POST['tag'], '/ '))
{
	switch ((int)$_POST['option'])
	{
		case 1:
			$prefix = $this->tag.'/';
			break;
		case 2:
			$prefix = substr($this->tag, 0, strrpos($this->tag, '/') + 1);
			break;
		default:
			$prefix = '';
	}

	// check if reserved word
	if($result = $this->validate_reserved_words($new_tag))
	{
		$this->set_message(Ut::perc_replace($this->get_translation('PageReservedWord'), $result));
	}
	// check target page existance
	else if ($page = $this->load_page($prefix.$new_tag, 0, '', LOAD_CACHE, LOAD_META))
	{
		$message = $this->get_translation('PageAlreadyExists')." &laquo;".$page['tag']."&raquo;. ";

		// check existing page write access
		if ($this->has_access('write', $this->get_page_id($prefix.$new_tag)))
		{
			$message .= Ut::perc_replace($this->get_translation('PageAlreadyExistsEdit'), "<a href=\"".$this->href('edit', $prefix.$new_tag)."\">".$this->get_translation('PageAlreadyExistsEdit2')." </a>?");
		}
		else
		{
			$message .= $this->get_translation('PageAlreadyExistsEditDenied');
		}

		$this->set_message($message);
	}
	else
	{
		// check new page write access
		if ($this->has_access('create', $this->get_page_id($prefix.$new_tag)))
		{
			// keep the original input for page titel
			$this->sess->title = $new_tag;

			// str_replace: fixes newPage&amp;add=1
			$this->redirect(str_replace('&amp;', '&', ($this->href('edit', $prefix.$new_tag, '', 1))));
		}
		else
		{
			$this->set_message($this->get_translation('CreatePageDeniedAddress'));
		}
	}
}

// show form

// create a peer page
echo $this->form_open('sub_page', ['page_method' => 'new']);
echo '<input type="hidden" name="option" value="1" />';
echo '<label for="create_subpage">'.$this->get_translation('CreateSubPage').':</label><br />';

if ($this->has_access('create', $this->get_page_id($this->tag)))
{
	echo '<code>'.( strlen($this->tag) > 50 ? '...'.substr($this->tag, -50) : $this->tag ).'/</code>'.
		'<input type="text" id="create_subpage" name="tag" value="'.( isset($_POST['option']) && $_POST['option'] === 1 ? htmlspecialchars($new_tag, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="20" maxlength="255" /> '.
		'<input type="submit" id="submit_subpage" value="'.$this->get_translation('CreatePageButton').'" />';
}
else
{
	$message = '<em>'.$this->get_translation('CreatePageDenied').'</em>';
	$this->show_message($message, 'info');
}

echo $this->form_close();
echo '<br />';

// create a child page. only inside a cluster
if (substr_count($this->tag, '/') > 0)
{
	$parent = substr($this->tag, 0, strrpos($this->tag, '/'));

	if ($this->has_access('create', $this->get_page_id($parent)))
	{
		// hide users cluster
		if ($parent != $this->config['users_page'])
		{
			echo $this->form_open('parent_cluster_page', ['page_method' => 'new']);
			echo '<input type="hidden" name="option" value="2" />';
			echo '<label for="create_pageparentcluster">'.$this->get_translation('CreatePageParentCluster').':</label><br />';
			echo '<code>'.( strlen($parent) > 50 ? '...'.substr($parent, -50) : $parent ).'/</code>'.
				 '<input type="text" id="create_pageparentcluster" name="tag" value="'.( isset($_POST['option']) && $_POST['option'] === 2 ? htmlspecialchars($new_tag, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="20" maxlength="255" /> '.
				 '<input type="submit" id="submit_pageparentcluster" value="'.$this->get_translation('CreatePageButton').'" />';
			echo $this->form_close();
		}
	}
	else
	{
		$message = '<em>'.$this->get_translation('CreatePageDenied').'</em>';
		$this->show_message($message, 'info');
	}


	echo '<br />';
}

//
echo $this->form_open('random_page', ['page_method' => 'new']);
echo '<input type="hidden" name="option" value="3" />';
echo '<label for="create_randompage">'.$this->get_translation('CreateRandomPage').':</label><br />';
echo '<input type="text" id="create_randompage" name="tag" value="'.( isset($_POST['option']) && $_POST['option'] === 3 ? htmlspecialchars($new_tag, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="60" maxlength="255" /> '.
	 '<input type="submit" id="submit_randompage" value="'.$this->get_translation('CreatePageButton').'" />';
echo $this->form_close();
