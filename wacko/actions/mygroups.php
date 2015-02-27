<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// actions/mygroups.php

if (!isset($nomark)) $nomark = '';

if (!function_exists('MyGroups'))
{
	function my_groups(&$wacko, $user_name, $alias)
	{
		$my_groups_count = 0;

		foreach($alias as $group_name => $members)
		{
			$group_members = explode("\\n", $members);

			if(in_array ($user_name, $group_members))
			{
				echo '<a href="'.$wacko->href('', ($wacko->config['groups_page']), 'profile='.htmlspecialchars($group_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'">'.$group_name.'</a>'.'<br />';

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

	$groups_count = my_groups($this, $user['user_name'], $alias);

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
?>