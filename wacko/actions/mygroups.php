<?php

// actions/mygroups.php

if (!isset($nomark)) $nomark = '';

if (!function_exists('MyGroups'))
{
	function MyGroups($user_name, $al)
	{
		$my_groups_count = 0;
		foreach($al as $group => $members)
		{
			$groupmembers = explode("\\n", $members);
			if(in_array ($user_name, $groupmembers))
			{
				echo $group.'<br />';
				$my_groups_count++;
			}
		}
		return $my_groups_count;
	}
}

if($user = $this->get_user())
{
	$al = $this->config['aliases'];

	if (!$nomark)
	echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$user['user_name'].": ".$this->get_translation('MyGroups')."</span></p>\n";

	$groups_count = MyGroups($user['user_name'],$al);
	echo "<i>".$groups_count." ".($groups_count == 1 ? $this->get_translation('Group') : $this->get_translation('Groups'))."</i><br />\n";

	if (!$nomark)
	echo "</div>\n";
}
?>