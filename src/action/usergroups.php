<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// You have to be logged in to use this action

if (!isset($nomark))	$nomark = 0;
if (!isset($cols))		$cols = '';

if ($user = $this->get_user())
{
	if (!$cols)
	{
		$cols = 4; //number of table columns
	}
	else
	{
		$cols = intval($cols);
	}

	if (is_array($this->db->groups))
	{
		if (!$nomark)
		{
			$tpl->mark			= true;
			$tpl->emark			= true;
		}

		$result = $this->db->load_all(
			"SELECT
				g.group_name,
				u.user_id,
				u.user_name
			FROM
				" . $this->prefix . "usergroup_member gm
					INNER JOIN " . $this->prefix . "user u ON (gm.user_id = u.user_id)
					INNER JOIN " . $this->prefix . "usergroup g ON (gm.group_id = g.group_id)", true);

		foreach ($result as $row)
		{
			$ug[$row['group_name']][] = $row['user_name'];
		}

		$i = 1;

		$tpl->enter('group_');

		foreach ($ug as $group_name => $group_members)
		{
			sort($group_members);

			if ($i == $cols + 1)
			{
				$tpl->next	= true;
				$i = 1;
			}
			/*
			 If they are an Admin show them all users in all groups
			 Else they are a normal logged in user so just show them groups they belong to
			 */
			if ($this->is_admin() || in_array($user['user_id'], $group_members))
			{

				$tpl->group	= $this->group_link($group_name, true, false);

				foreach ($group_members as $k => $user_name)
				{
					$tpl->n_member = $this->user_link($user_name, true, false);
				}

				$i++;
			}
		}

		$tpl->leave(); // group_
	}
}
