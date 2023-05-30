<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows list with usergroups and their members.

Usage:
	{{groups}}

Options:
	[max=Number]
EOD;

// set defaults
$help		??= 0;
$max		??= null;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'groups']);
	return;
}

// args:
$max			= (int) @$max;
$logged_in		= $this->get_user();

$param			= [];
$groups			= '';

// display usergroup profile
if ($group = @$_GET['profile'])
{
	// hide article H1 header
	$this->hide_article_header = true;

	if (!($usergroup = $this->load_usergroup($group)))
	{
		$tpl->error_message = Ut::perc_replace($this->_t('GroupsNotFound'),
			$this->href(),
			'<code>' . Ut::html($group) . '</code>');
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
	$sql_order		= '';
	$params			= [];

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	if ($group = (string) @$_GET['group'])
	{
		// goto usergroup profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->load_usergroup($group))
		{
			$param['profile'] = $group;
			$this->http->redirect($this->href('', '', $param));
			// NEVER BEEN HERE
		}

		$where = 'WHERE group_name LIKE ' . $this->db->q('%' . $group . '%') . ' ';
		$param['group'] = $group;
	}

	$_sort = @$_GET['sort'];
	$sort_modes	=
	[
		'name'			=> 'g.group_name',
		'created'		=> 'g.created',
		'members'		=> 'members',
	];

	if (isset($sort_modes[$_sort]))
	{
		$_order			= @$_GET['order'];
		$order_modes	=
		[
			'asc'	=> 'ASC',
			'desc'	=> 'DESC'
		];

		if (!isset($order_modes[$_order]))
		{
			$_order = 'asc';
		}

		$params['sort']		= $_sort;
		$params['order']	= $_order;

		$sql_order = 'ORDER BY ' . $sort_modes[$_sort] . ' ' . $order_modes[$_order] . ' ';
	}
	else
	{
		$sql_order = 'ORDER BY members DESC ';
	}

	$count = $this->db->load_single(
		'SELECT COUNT(group_name) AS n ' .
		'FROM ' . $this->prefix . 'usergroup ' .
		$where);

	$pagination = $this->pagination($count['n'], $max, 'p', $param);

	// collect data
	$groups = $this->db->load_all(
		'SELECT g.group_name, g.description, g.created, u.user_name AS moderator, COUNT(m.user_id) AS members ' .
		'FROM ' . $this->prefix . 'usergroup g ' .
			'LEFT JOIN ' . $this->prefix . 'user u ON (g.moderator_id = u.user_id) ' .
			'LEFT JOIN ' . $this->prefix . 'usergroup_member m ON (m.group_id = g.group_id) ' .
		$where .
		($where ? 'AND ' : 'WHERE ') .
			'g.active = 1 ' .
		'GROUP BY g.group_id, g.group_name, g.description, g.created, u.user_name ' .
		$sql_order .
		$pagination['limit']);

	$tpl->enter('l_');

	// usergroup filter form
	$tpl->href	= $this->href();
	$tpl->group	= $group;

	$tpl->pagination_text = $pagination['text'];

	// change sorting order navigation bar
	$sort_link = function ($sort, $text) use ($params, &$tpl)
	{
		$tpl->s_what	= $this->_t($text);
		$order			= 'asc';

		if (@$params['sort'] == $sort)
		{
			if ($params['order'] == 'asc')
			{
				$order = 'desc';
			}

			$tpl->s_arrow_a = $order;
		}
		else
		{
			$params['sort'] = $sort;
		}

		$params['order'] = $order;

		$tpl->s_link = $this->href('', '', $params);
	};

	$sort_link('name',		'GroupsName');
	$sort_link('members',	'GroupsMembers');

	if ($logged_in)
	{
		$sort_link('created',		'GroupsCreated');
	}

	// list entries
	if (!$groups)
	{
		$tpl->none = true;
	}
	else
	{
		$tpl->enter('g_');

		foreach ($groups as $usergroup)
		{
			$tpl->profile	= $this->href('', '', ['profile' => $usergroup['group_name']]);
			$tpl->group		= $usergroup;

			if ($this->get_user())
			{
				$tpl->reg_group = $usergroup;
			}
		}

		$tpl->leave();	//	g_
	}

	$tpl->leave();	//	l_
}
