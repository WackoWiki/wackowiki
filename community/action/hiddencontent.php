<?php
/*
	{{Hidden Content Wrapper

	Version 1.4
	David Millington aka Tann San

	Shows hidden content based on user group or user name

	[$username	=<comma deliminated list of user names>] - optional - $username="TannSan,BillyBob"
	[$usergroup	=a single user group name] - optional - $usergroup="Admins"
	[$text		=text to display if user meets login requirements]
	[$alt		=alternative text to display to users who do not meet the login requirements] - optional

	https://wackowiki.org/doc/Dev/PatchesHacks/HiddenContent
	}}
	*/

if (!defined('IN_WACKO'))
{
	exit;
}

// set defaults
$usergroup	??= '';
$username	??= '';
$text		??= '';
$alt		??= '';

if ($usergroup !== '' || $username !== '')
{
	$show_content = false;

	// Check if user is the named user
	if (in_array($this->get_user_name(), explode(',', $username)))
	{
		$show_content = true;
	}
	else if (is_array($this->db->aliases))
	{
		// Check if current user is in the specified $usergroup
		// don't bother if we already identified the user as having access
		foreach ($this->db->aliases as $group => $members)
		{
			if ($group === $usergroup)
			{
				if (in_array($this->get_user_name(), explode(',', $members)))
				{
					$show_content = true;
					break;
				}
			}
		}
	}

	if ($show_content)
	{
		echo $this->format($text);
	}
}
else if ($alt !== '')
{
	echo $this->format($alt);
}
