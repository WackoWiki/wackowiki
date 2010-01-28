<?php

// You have to be logged in to use this action

if (!isset($nomark)) $nomark = "";
if (!isset($cols)) $cols = "";

if($user = $this->GetUser())
{
	if (!$cols) $cols = 4; //number of table columns
	else $cols = intval($cols);

	if (is_array($this->config['aliases']))
	{
		if (!$nomark)
		print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("UserGroups").":</span></p>");

		print ("<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\"><tr>");

		$i = 1;

		foreach($this->config['aliases'] as $gname => $gusers)
		{
			if($i == $cols + 1)
			{
				print "</tr><tr>";
				$i = 1;
			}

			$arr = explode("\n", $gusers);
			$allowed_groups = array();

			sort($arr);

			/*
			 If they are an Admin show them all users in all groups
			 Else they are a normal logged in user so just show them groups they belong to
			 */
			if($this->IsAdmin() || in_array($user["user_name"], $arr))
			{
				print "<td valign=\"top\">";

				foreach ($arr as $k => $v)
				$allowed_groups[] = $this->Link("/".$v,"",$v);

				sort($allowed_groups);

				$gusers = implode("<br />", $allowed_groups);

				// Print out the group name and then a list of the users under it
				print "<strong>$gname</strong>:<br />".str_replace("\n","<br />",$gusers)."<br />";
				print "</td>";

				$i++;
			}
		}

		print ("</tr></table>");

		if(!$nomark)
		print ("</div>");
	}
}

?>