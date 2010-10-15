<?php

/*
Random Page Action

 All arguments are optional

 {{randompage
  [for|page="PageName"] // page name to start from in the page hierarchy
 }}
 */

if (!isset($for)) $for = '';
if (!isset($page)) $page = '';
if (!isset($max)) $max = 500;

if ($page) $for = $page;
else $page = $for;

$tag = $for;

if ($max > 1000) $max = 1000;

$query = "SELECT p.supertag ".
		"FROM ". $this->config['table_prefix']."page p, ". $this->config['table_prefix']."acl a ".
		"WHERE p.owner_id != (SELECT user_id FROM wacko_user WHERE user_name = 'System' LIMIT 1) ".
			($for
				? "AND p.tag LIKE '".quote($this->dblink, $tag."/%")."' "
				: ""
			).
			"AND p.comment_on_id = '0' ".
			"AND a.privilege = 'read' ".
			"AND a.list = '*' ".
			"AND p.page_id = a.`page_id` ".
			#"AND p.body != '{{randompage}}' ". // very expensive
			"LIMIT {$max}";

$pages = $this->load_all($query, 1);

is_array ( $pages )
	? $page = array_rand ( $pages )
	: $page = $this->config['root_page'];

if (isset($test) || ($user = $this->get_user()))
{
	if (isset($test) || $user['dont_redirect'] == 1 || $_POST['redirect'] == 'no')
	{
		// show only result
		echo $this->compose_link_to_page($pages[$page]['supertag']);
	}
	else
	{
		// redirect to random page
		$this->redirect($this->href('', $pages[$page]['supertag']));
	}
}
else
{
	// redirect to random page
	$this->redirect($this->href('', $pages[$page]['supertag']));
}

?>