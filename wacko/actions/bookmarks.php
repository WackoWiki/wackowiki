<?php

if (!function_exists('bookmark_sorting'))
{
	function bookmark_sorting ($a, $b)
	{
		if ($a["bm_position"] == $b["bm_position"])
			return 0;
		return ($a["bm_position"] < $b["bm_position"])
			? -1
			: 1;
	}
}
if (!function_exists('LoadUserBookmarks'))
{
	function LoadUserBookmarks(&$wacko, $user_id)
	{
		$_bookmarks = $wacko->LoadAll(
							"SELECT p.tag, p.title, b.bookmark_id, b.user_id, b.bm_title, b.lang, b.bm_position ".
							"FROM ".$wacko->config["table_prefix"]."bookmarks b ".
								"LEFT JOIN ".$wacko->config["table_prefix"]."pages p ON (b.page_id = p.page_id) ".
							"WHERE b.user_id = '".quote($wacko->dblink, $user_id)."' ".
							"ORDER BY b.bm_position", 0);

		return $_bookmarks;
	}
}

$user = $this->GetUser();

/// Processing of our special form
if (isset($_POST["_user_bookmarks"]))
{
	$_bookmarks = LoadUserBookmarks($this, $user["user_id"]);
	$a = $_bookmarks;
	$b = array();

	foreach($a as $k=>$v)
	{
		$b[$k]["user_id"]		= $v["user_id"];
		$b[$k]["bookmark_id"]	= $v["bookmark_id"];
		$b[$k]["bm_position"]	= $v["bm_position"];
		$b[$k]["bm_title"]		= $v["bm_title"];
		$b[$k]["tag"]			= $v["tag"];
	}
	$object->data["user_menu"] = &$b;

	if (isset($_POST["update_bookmarks"]))
	{
		// repos
		$data = array();
		foreach( $object->data["user_menu"] as $k => $item )
			$data[] = array( "bookmark_id" => $item["bookmark_id"], "bm_position"=> 1 * $_POST["pos_".$item["bookmark_id"]] );
		usort ($data, "bookmark_sorting");
		foreach( $data as $k => $item )
			$data[$k]["bm_position"] = $k + 1;
		// save
		foreach( $data as $item )
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."bookmarks SET ".
				"bm_position = '".quote($this->dblink, $item["bm_position"])."', ".
				"bm_title = '".quote($this->dblink, substr($_POST["title_".$item["bookmark_id"]],0,250))."' ".
				"WHERE bookmark_id = '".quote($this->dblink, $item["bookmark_id"])."' ".
				"LIMIT 1");
		}
	}
	else if (isset($_POST["delete_bookmarks"]))
	{
		$deletion = "";
		foreach( $object->data["user_menu"] as $item )
		{
			if (isset($_POST["delete_".$item["bookmark_id"]]))
			{
				if ($deletion != "") $deletion.=", ";
				$deletion.= quote($this->dblink, $item["bookmark_id"]);
			}
			if ($deletion != "")
			{
				$this->Query(
					"DELETE FROM ".$this->config["table_prefix"]."bookmarks ".
					"WHERE bookmark_id IN (".$deletion.")");
			}
		}
	}
	// reload user data
	$this->SetUser($this->LoadUser($user["user_name"]), 0, 1);
	$this->SetBookmarks(BM_USER);
}
if ($user)
{
	$_bookmarks = LoadUserBookmarks($this, $user["user_id"]);

	if ($_bookmarks)
	{
		// echo "<h4>".$this->GetTranslation("YourBookmarks")."</h4>";

		// user is logged in; display config form
		echo $this->FormOpen();
		echo "<input type=\"hidden\" name=\"_user_bookmarks\" value=\"yes\" />";

		echo "<table>";
		echo "<tr><th>No.</th><th>Bookmark Title</th><th>Page</th><th>X</th><!--<th>Display</th><th>Lang</th>--></tr>";

		foreach($_bookmarks as $_bookmark)
		{
			echo "<tr class=\"lined\">\n
			<td class=\"\">
			<input name=\"pos_".$_bookmark["bookmark_id"]."\" type=\"text\" size=\"2\" value=\"".$_bookmark["bm_position"]."\" />
			</td><td>
			<input name=\"title_".$_bookmark["bookmark_id"]."\" type=\"text\" size=\"40\" value=\"".$_bookmark["bm_title"]."\" />
			</td><td>
			<!--<input type=\"radio\" id=\"bookmark".$_bookmark["bookmark_id"]."\" name=\"change\" value=\"".$_bookmark["bookmark_id"]."\" /> -->
			<label for=\"bookmark".$_bookmark["bookmark_id"]."\">&raquo ".$_bookmark["tag"]."</label>
			</td><td>
			<input id=\"bookmark".$_bookmark["bookmark_id"]."\" name=\"delete_".$_bookmark["bookmark_id"]."\" type=\"checkbox\" />
			</td><!--<td>

			".(!empty($_bookmark["bm_title"]) ? $_bookmark["bm_title"] : $_bookmark["title"])."
			</td><td>
			".(!empty($_bookmark["lang"]) ? $_bookmark["lang"] : "")."-->
			</td>\n</tr>\n";
		}
		echo "<tfoot>";
		echo "<tr>\n<td colspan=\"2\">\n";
		echo "<input name=\"update_bookmarks\" type=\"submit\" value=\"Save Changes\" />";
		echo "</td><td>";
		echo "<input name=\"delete_bookmarks\" type=\"submit\" value=\"Delete Selected\" />";
		echo "</td>\n</tr>\n";
		echo "</tfoot>";
		echo "</table>";

		echo $this->FormClose();
	}
}

?>