<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// You have to be logged in to use this action

if (!isset($nomark)) $nomark = '';
if (!isset($cols)) $cols = '';

if($user = $this->get_user())
{
	if (!$cols)
	{
		$cols = 4; //number of table columns
	}
	else
	{
		$cols = intval($cols);
	}

	if (is_array($this->config['aliases']))
	{
		if (!$nomark)
		{
			echo '<div class="layout-box"><p class="layout-box"><span>'.$this->get_translation('UserGroups').':</span></p>';
		}

		echo '<table style="border-spacing: 5px; border-collapse: separate; padding: 5px;"><tr>';

		$i = 1;

		foreach($this->config['aliases'] as $group_name => $group_members)
		{
			if ($i == $cols + 1)
			{
				echo "</tr><tr>";
				$i = 1;
			}

			$arr			= explode("\\n", $group_members);
			$allowed_groups	= array();

			sort($arr);

			/*
			 If they are an Admin show them all users in all groups
			 Else they are a normal logged in user so just show them groups they belong to
			 */
			if($this->is_admin() || in_array($user['user_name'], $arr))
			{
				echo '<td valign="top">';

				foreach ($arr as $k => $user_name)
				{
					$allowed_groups[] = '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$user_name).'">'.$user_name.'</a>';
				}

				sort($allowed_groups);

				$group_members = implode('<br />', $allowed_groups);

				// Print out the usergroup name and then a list of the users under it
				echo '<strong>'.'<a href="'.$this->href('', ($this->config['groups_page']), 'profile='.htmlspecialchars($group_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'">'.$group_name.'</a>'.'</strong>:<br />'.str_replace("\n","<br />",$group_members).'<br />';
				echo '</td>';

				$i++;
			}
		}

		echo '</tr></table>';

		if(!$nomark)
		{
			echo '</div>';
		}
	}
}

?>