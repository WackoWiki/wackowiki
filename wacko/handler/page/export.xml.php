<?php
if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

$tpl->charset	= $this->get_charset();
$tpl->tag		= $this->tag;
$tpl->date		= date('r');
$tpl->lang		= $this->page_lang;

if ($this->has_access('read'))
{
	$num_slashes = mb_substr_count($this->tag, '/');

	$pages = $this->db->load_all(
		"SELECT page_id, owner_id, tag, title, created, body " .
		"FROM " . $this->db->table_prefix . "page " .
		"WHERE (tag = " . $this->db->q($this->tag) . " " .
		" OR tag LIKE " . $this->db->q($this->tag . '/%') . ")" .
		" AND comment_on_id = 0");

	$tpl->enter('p_');

	foreach ($pages as $num => $page)
	{
		// check ACLS
		if (!$this->has_access('write', $page['page_id']))
		{
			continue;
		}
		// output page
		$tag = $page['tag'];

		if ($num_slashes == mb_substr_count($tag, '/'))
		{
			$tag = '';
		}
		else
		{
			$_tag = explode('/', $tag);
			$tag = '';

			for ($i = 0; $i < count($_tag); $i++)
			{
				if ($i > $num_slashes) $tag .= $_tag[$i] . '/';
			}
		}

		$tpl->tag		= rtrim($tag, '/');
		$tpl->title		= Ut::html($page['title']);
		$tpl->ptag		= $page['tag'];
		$tpl->body		= str_replace(']]>', ']]&gt;', $page['body']);
		$tpl->owner		= $page['owner_id'];
		$tpl->date		= Ut::http_date(strtotime($page['created']));
	}

	$tpl->leave();
}
else
{
	$tpl->denied = true;
}

