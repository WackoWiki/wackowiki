<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page" class="page">
<h3><?php echo $this->get_translation('CreateNewPage'); ?></h3>
<br />
<?php

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
		$this->set_message(str_replace('%1', $result, $this->get_translation('PageReservedWord')));
	}
	// check target page existance
	else if ($page = $this->load_page($prefix.$new_tag, 0, '', LOAD_CACHE, LOAD_META))
	{
		$message = $this->get_translation('PageAlreadyExists')." &laquo;".$page['tag']."&raquo;. ";

		// check existing page write access
		if ($this->has_access('write', $this->get_page_id($prefix.$new_tag)))
		{
			$message .= str_replace('%1', "<a href=\"".$this->href('edit', $prefix.$new_tag)."\">".$this->get_translation('PageAlreadyExistsEdit2')." </a>?", $this->get_translation('PageAlreadyExistsEdit'));
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
			// str_replace: fixed newPage&amp;add=1
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
echo $this->form_open('sub_page', 'new');
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

	echo $this->form_open('parent_cluster_page', 'new');
	echo '<input type="hidden" name="option" value="2" />';
	echo '<label for="create_pageparentcluster">'.$this->get_translation('CreatePageParentCluster').':</label><br />';

	if ($this->has_access('create', $this->get_page_id($parent)))
	{
		echo '<code>'.( strlen($parent) > 50 ? '...'.substr($parent, -50) : $parent ).'/</code>'.
			'<input type="text" id="create_pageparentcluster" name="tag" value="'.( isset($_POST['option']) && $_POST['option'] === 2 ? htmlspecialchars($new_tag, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="20" maxlength="255" /> '.
			'<input type="submit" id="submit_pageparentcluster" value="'.$this->get_translation('CreatePageButton').'" />';
	}
	else
	{
		$message = '<em>'.$this->get_translation('CreatePageDenied').'</em>';
		$this->show_message($message, 'info');
	}

	echo $this->form_close();
	echo '<br />';
}

//
echo $this->form_open('random_page', 'new');
echo '<input type="hidden" name="option" value="3" />';
echo '<label for="create_randompage">'.$this->get_translation('CreateRandomPage').':</label><br />';
echo '<input type="text" id="create_randompage" name="tag" value="'.( isset($_POST['option']) && $_POST['option'] === 3 ? htmlspecialchars($new_tag, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="60" maxlength="255" /> '.
	 '<input type="submit" id="submit_randompage" value="'.$this->get_translation('CreatePageButton').'" />';
echo $this->form_close();

?>
</div>