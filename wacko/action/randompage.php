<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
Random Page Action

 {{randompage
  [page="PageName"]		// page name to start from in the page hierarchy
  [test]				// show, don't redirect
 }}
 */

// do not cache random page!
$this->http->no_cache(false);

$page		??= '';

$tag = $this->unwrap_link($page);

$query =
	"FROM ". $this->db->table_prefix . "page p, ". $this->db->table_prefix . "acl a " .
	"WHERE p.owner_id != " . (int) $this->db->system_user_id . " " .
		($tag
			? "AND p.tag LIKE " . $this->db->q($tag . '/%') . " "
			: ""
		) .
		"AND p.comment_on_id = 0 " .
		"AND p.page_id <> " . (int) $this->page['page_id'] . " " .
		"AND a.privilege = 'read' " .
		"AND a.list = '*' " .
		"AND p.page_id = a.page_id ";

$count = $this->db->load_single(
	"SELECT COUNT(p.tag) AS n " .
	$query, true);

if ($count['n'] > 1)
{
	$result = $this->db->load_single(
		"SELECT p.tag " .
		$query .
		"LIMIT " . Ut::rand(0, $count['n'] - 1) . ", 1"
		, true);
}

if (empty($result))
{
	$result['tag'] = $this->db->root_page;
}

if (isset($test) || $this->get_user_setting('dont_redirect') || @$_POST['redirect'] == 'no')
{
	echo $this->compose_link_to_page($result['tag']);
}
else
{
	$this->http->redirect($this->href('', $result['tag']));
}
