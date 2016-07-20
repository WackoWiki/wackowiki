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

echo '<a href="'.$this->href('', $this->config['permalink_page'], 'page_id='.$this->page['page_id'].
		(isset($revision_id)
			? '&amp;rev_id='.$revision_id
			: '')
		).'" title="'.$this->_t('PermaLinkTip').'" rel="nofollow">'.$this->_t('PermaLink').'</a>';

?>