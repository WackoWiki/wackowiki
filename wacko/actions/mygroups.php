<?php

// actions/mygroups.php
// written by Adrian Walmsley

function MyGroups($username, $al)
{
	$my_groups_count = 0;
	foreach($al as $group => $members)
	{
		$groupmembers = explode("\n", $members);
		if(in_array ($username, $groupmembers))
		{
			print $group.'<br />';
			$my_groups_count++;
		}
	}
	return $my_groups_count;
}

if($user = $this->GetUser())
{
	$al = $this->config['aliases'];

	if (!$nomark)
	print("<fieldset><legend>".$user["name"].": ".$this->GetResourceValue("MyGroups")."</legend>\n");

	$groups_count = MyGroups($user["name"],$al);
	echo "<i>".$groups_count." ".($groups_count == 1 ? $this->GetResourceValue("Group") : $this->GetResourceValue("Groups"))."</i><br />\n";

	if (!$nomark)
	echo "</fieldset>\n";
}
?>