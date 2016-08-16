<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
Random Page Action

 {{randompage
  [page="PageName"] // page name to start from in the page hierarchy
  [test]				// show, don't redirect
 }}
 */

$tag = isset($page)? $page : '';

$query = // "SELECT p.supertag ".
		"FROM ". $this->db->table_prefix."page p, ". $this->db->table_prefix."acl a ".
		"WHERE p.owner_id != (SELECT user_id FROM ". $this->db->table_prefix."user WHERE user_name = 'System' LIMIT 1) ".
			($tag
				? "AND p.tag LIKE ".$this->db->q($tag.'/%')." "
				: ""
			).
			"AND p.comment_on_id = '0' ".
			"AND p.page_id <> '{$this->page['page_id']}' ".
			"AND a.privilege = 'read' ".
			"AND a.list = '*' ".
			"AND p.page_id = a.`page_id` ";
			// "AND p.body != '{{randompage}}' ". // very expensive

$count = $this->db->load_single(
		"SELECT COUNT(p.supertag) AS n ".
		$query, true);

$page = $this->db->load_single(
		"SELECT p.supertag, p.tag ".
		$query.
		"LIMIT " . Ut::rand(0, $count['n'] - 1) . ", 1"
		, true);

if (!$page)
{
	$page = $this->db->root_page;
}

if (isset($test) || $this->get_user_setting('dont_redirect') || @$_POST['redirect'] == 'no')
{
	echo $this->compose_link_to_page($page['tag']);
}
else
{
	$this->http->redirect($this->href('', $page['supertag']));
}
