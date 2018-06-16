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
	$num_slashes = substr_count($this->tag, '/');

	$pages = $this->db->load_all(
		"SELECT page_id, owner_id, tag, supertag, title, created, body " .
		"FROM " . $this->db->table_prefix . "page " .
		"WHERE (supertag = " . $this->db->q($this->supertag) . " " .
		" OR supertag LIKE " . $this->db->q($this->supertag . '/%') . ")" .
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

		if ($num_slashes == substr_count($tag, '/'))
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
		$tpl->supertag	= $page['supertag'];
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

