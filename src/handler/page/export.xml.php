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

if ($this->has_access('read')
	&& ((	$this->db->export_handler == 2 && $this->get_user())
		||	$this->db->export_handler == 1)
)
{
	$num_slashes = mb_substr_count($this->tag, '/');

	$pages = $this->db->load_all(
		"SELECT p.page_id, p.owner_id, p.tag, p.title, p.created, p.body, u.user_name " .
		"FROM " . $this->prefix . "page p " .
			"LEFT JOIN " . $this->prefix . "user u ON (p.owner_id = u.user_id) " .
		"WHERE (tag = " . $this->db->q($this->tag) . " " .
			"OR tag LIKE " . $this->db->q($this->tag . '/%') . ") " .
			"AND comment_on_id = 0");

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
			$tag	= '';
		}
		else
		{
			$_tag	= explode('/', $tag);
			$tag	= '';

			for ($i = 0; $i < count($_tag); $i++)
			{
				if ($i > $num_slashes)
				{
					$tag .= $_tag[$i] . '/';
				}
			}
		}

		$tpl->tag		= utf8_rtrim($tag, '/');
		$tpl->title		= Ut::html($page['title']);
		$tpl->ptag		= $page['tag'];
		$tpl->body		= str_replace(']]>', ']]&gt;', $page['body']);
		$tpl->owner		= $page['user_name'];
		$tpl->date		= Ut::http_date(strtotime($page['created']));
	}

	$tpl->leave();
}
else
{
	$tpl->denied = true;
}