<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// You have to be logged in to use this action

// set defaults
$cols		??= '';
$nomark		??= 0;

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
			echo '<div class="layout-box"><p><span>' . $this->_t('UserGroups') . ':</span></p>';
		}

		echo '<table style="border-spacing: 5px; border-collapse: separate; padding: 5px;"><tr>';

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

		foreach ($ug as $group_name => $group_members)
		{
			if ($i == $cols + 1)
			{
				echo "</tr><tr>";
				$i = 1;
			}

			$allowed_groups	= [];

			sort($group_members);

			/*
			 If they are an Admin show them all users in all groups
			 Else they are a normal logged in user so just show them groups they belong to
			 */
			if ($this->is_admin() || in_array($user['user_id'], $group_members))
			{
				echo '<td class="a-top">';

				foreach ($group_members as $k => $user_name)
				{
					$allowed_groups[] = $this->user_link($user_name, true, false);
				}

				sort($allowed_groups);

				$group_members = implode('<br>', $allowed_groups);

				// Print out the usergroup name and then a list of the users under it
				echo '<strong>' . $this->group_link($group_name, true, false) . '</strong>:<br>' . str_replace("\n","<br>",$group_members) . '<br>';
				echo '</td>';

				$i++;
			}
		}

		echo '</tr></table>';

		if (!$nomark)
		{
			echo '</div>';
		}
	}
}
