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

header('Content-type: text/xml; charset=utf-8');

$tpl->charset	= $this->get_charset();
$tpl->tag		= $this->tag;
$tpl->date		= date('r');
$tpl->lang		= $this->page_lang;
$tpl->logo		= Ut::join_path(IMAGE_DIR, $this->db->site_logo);

if ($this->has_access('read'))
{
	// load revisions for this page except minor edits
	if ([$revisions, $pagination] = $this->load_revisions($this->page['page_id'], true))
	{
		$max				= 10;
		$c					= 0;
		$_GET['diffmode']	= 2; // 2 - source diff

		$tpl->enter('p_');

		foreach ($revisions as $page)
		{
			$c++;

			if (($c <= $max) && $c > 1)
			{
				$_GET['b']		= $_GET['a'] ?? -1;			// subsequent	(-1 recent -> or previous)
				$_GET['a']		= $page['revision_id']; 	// previous

				$etag			= str_replace('%2F', '/', rawurlencode($page['tag']));
				$date			= ($page['modified'] == '' ? $this->page['modified'] : $page['modified']);

				$tpl->user		= $page['user_id'] ? $page['user_name'] : $this->_t('Guest');
				$tpl->note		= $page['edit_note'];
				$tpl->link		= $this->href('', '', ['revision_id' => (int) $_GET['a']]);
				$tpl->perma		= $this->href('', $etag);

				// get diff
				$diff			= $this->include_buffered('page/diff.php', 'oops', '', HANDLER_DIR);

				// remove diff type navigation
				$diff			= preg_replace('/(<!--nomail-->.*?<!--\/nomail-->)/usi', '', $diff);

				$tpl->diff		= str_replace(']]>', ']]&gt;', $diff);
				$tpl->date		= date ('r', strtotime ($date));
			}
		}

		$tpl->leave();
	}
}
else
{
	$tpl->denied = true;
}
