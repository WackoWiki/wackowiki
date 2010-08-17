<?php

// actions/mygroups.php

if (!isset($nomark)) $nomark = "";

if (!function_exists('MyGroups'))
{
	function MyGroups($username, $al)
	{
		$my_groups_count = 0;
		foreach($al as $group => $members)
		{
			$groupmembers = explode("\\n", $members);
			if(in_array ($username, $groupmembers))
			{
				print $group.'<br />';
				$my_groups_count++;
			}
		}
		return $my_groups_count;
	}
}

if($user = $this->GetUser())
{
	$al = $this->config['aliases'];

	if (!$nomark)
	print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$user['user_name'].": ".$this->GetTranslation("MyGroups")."</span></p>\n");

	$groups_count = MyGroups($user['user_name'],$al);
	echo "<i>".$groups_count." ".($groups_count == 1 ? $this->GetTranslation("Group") : $this->GetTranslation("Groups"))."</i><br />\n";

	if (!$nomark)
	echo "</div>\n";
}
?>