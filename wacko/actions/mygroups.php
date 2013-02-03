<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// actions/mygroups.php

if (!isset($nomark)) $nomark = '';

if (!function_exists('MyGroups'))
{
	function my_groups($user_name, $alias)
	{
		$my_groups_count = 0;

		foreach($alias as $usergroup => $members)
		{
			$groupmembers = explode("\\n", $members);

			if(in_array ($user_name, $groupmembers))
			{
				echo $usergroup.'<br />';
				$my_groups_count++;
			}
		}
		return $my_groups_count;
	}
}

if($user = $this->get_user())
{
	$alias = $this->config['aliases'];

	if (!$nomark)
	{
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$user['user_name'].": ".$this->get_translation('MyGroups')."</span></p>\n";
	}

	$groups_count = my_groups($user['user_name'], $alias);
	echo "<em>".$groups_count." ".($groups_count == 1 ? $this->get_translation('Group') : $this->get_translation('Groups'))."</em><br />\n";

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
?>