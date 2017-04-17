<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action/mygroups.php

if (!isset($nomark)) $nomark = '';

if (!function_exists('MyGroups'))
{
	function my_groups(&$wacko, $user_id, $groups)
	{
		$my_groups_count = 0;

		foreach ($groups as $group_name => $members)
		{
			if (in_array ($user_id, $members))
			{
				echo $wacko->group_link($group_name, '', true, false) . '<br />';

				$my_groups_count++;
			}
		}

		return $my_groups_count;
	}
}

if ($user = $this->get_user())
{
	if (!$nomark)
	{
		echo '<div class="layout-box"><p><span>' . $user['user_name'] . ": " . $this->_t('MyGroups') . "</span></p>\n";
	}

	$groups_count = my_groups($this, $user['user_id'], $this->db->groups);

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
?>