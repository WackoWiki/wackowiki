<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{permalink}}

if (isset($_GET['revision_id']))
{
	$revision_id = (int)$_GET['revision_id'];
}

echo '<a href="'.$this->href('', $this->config['permalink_page'], 'page_id='.$this->page['page_id'].(isset($revision_id) ? '&rev_id='.$revision_id : '')).'" title="'.$this->get_translation('PermaLinkTip').'" rel="nofollow">'.$this->get_translation('PermaLink').'</a>';

?>