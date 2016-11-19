<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// args:
$max = (int) @$max;

$order			= '';
$param			= [];
$groups			= '';
$usergroups		= '';
$error			= '';

// display usergroup profile
if (($group = @$_GET['profile']))
{
	// hide article H1 header
	$this->hide_article_header = true;

	if (!($usergroup = $this->load_usergroup($group)))
	{
		$tpl->error_message = Ut::perc_replace($this->_t('GroupsNotFound'),
			$this->href(),
			htmlspecialchars($group, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET));
	}
	else
	{
		$tpl->p_group		= $usergroup;
		$tpl->p_link		= $this->href();
		$tpl->p_groupspace	= $this->href('', $this->db->groups_page . '/' . $usergroup['group_name']);
		$tpl->p_include		= $this->action('users', ['max' => $max, 'group_id' => $usergroup['group_id']]);
	}
}
// display whole usergroup list instead of the particular profile
else
{
	$where			= '';

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	if (($group = (string) @$_GET['group']))
	{
		// goto usergroup profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->load_usergroup($group))
		{
			$param['profile'] = $group;
			$this->http->redirect($this->href('', '', $param));
			// NEVER BEEN HERE
		}

		$where = "WHERE group_name LIKE " . $this->db->q('%' . $group . '%') . " ";
		$param['group'] = $group;
	}

	$param['sort'] = $sort = @$_GET['sort'];

	if ($sort == 'name')
	{
		$order = "ORDER BY group_name ";
	}
	else if ($sort == 'members')
	{
		$order = "ORDER BY members ";
	}
	else if ($sort == 'created')
	{
		$order = "ORDER BY created ";
	}
	else
	{
		unset($param['sort']);
	}

	$param['order'] = $_order = @$_GET['order'];

	if ($_order == 'asc')
	{
		$order .= "ASC ";
	}
	else if ($_order == 'desc')
	{
		$order .= "DESC ";
	}
	else
	{
		unset($param['order']);
	}

	$count = $this->db->load_single(
		"SELECT COUNT(group_name) AS n " .
		"FROM {$this->db->table_prefix}usergroup " .
		$where);

	$pagination = $this->pagination($count['n'], $max, 'p', $param);

	// collect data
	$groups = $this->db->load_all(
		"SELECT g.group_name, g.description, g.created, u.user_name AS moderator, COUNT(m.user_id) AS members " .
		"FROM {$this->db->table_prefix}usergroup g " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (g.moderator_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "usergroup_member m ON (m.group_id = g.group_id) " .
		$where.
		( $where ? 'AND ' : "WHERE ") .
			"g.active = '1' " .
		"GROUP BY g.group_id " .
		( $order ? $order : "ORDER BY members DESC " ) .
		$pagination['limit']);

	// usergroup filter form
	$tpl->l_href = $this->href();
	$tpl->l_group = $group;

	$tpl->l_pagination_text = $pagination['text'];

	// list header
	// TODO STS refactor, like in users
	$tpl->l_head_a = '<a href="' . $this->href('', '', 'sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ) . '">' . $this->_t('GroupsName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['group']) && $_REQUEST['group'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '') . '</a>';
	$tpl->l_head_a = '<a href="' . $this->href('', '', 'sort=members'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ) . '">' . $this->_t('GroupsMembers').( (isset($_GET['sort']) && $_GET['sort'] == 'members') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '') . '</a>';
	if ($this->get_user())
	{
		$tpl->l_head_a = '<a href="' . $this->href('', '', 'sort=created'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ) . '">' . $this->_t('GroupsCreated').( isset($_GET['sort']) && $_GET['sort'] == 'created' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '') . '</a>';
	}

	// list entries
	if (!$groups)
	{
		$tpl->l_none = true;
	}
	else
	{
		foreach ($groups as $usergroup)
		{
			$tpl->l_line_profile = $this->href('', '', ['profile' => $usergroup['group_name']]);
			$tpl->l_line_group = $usergroup;
			if ($this->get_user())
			{
				$tpl->l_line_reg_group = $usergroup;
			}
		}
	}
}
