<?php

if (!function_exists('bookmark_sorting'))
{
	function bookmark_sorting ($a, $b)
	{
		if ($a['bm_position'] == $b['bm_position'])
		{
			return 0;
		}
		return ($a['bm_position'] < $b['bm_position'])
			? -1
			: 1;
	}
}
if (!function_exists('load_user_bookmarks'))
{
	function load_user_bookmarks(&$wacko, $user_id)
	{
		$_bookmarks = $wacko->load_all(
							"SELECT p.tag, p.title, b.bookmark_id, b.user_id, b.bm_title, b.lang, b.bm_position ".
							"FROM ".$wacko->config['table_prefix']."bookmark b ".
								"LEFT JOIN ".$wacko->config['table_prefix']."page p ON (b.page_id = p.page_id) ".
							"WHERE b.user_id = '".quote($wacko->dblink, $user_id)."' ".
							"ORDER BY b.bm_position", 0);

		return $_bookmarks;
	}
}

$user = $this->get_user();

/// Processing of our special form
if (isset($_POST['_user_bookmarks']))
{
	$_bookmarks	= load_user_bookmarks($this, $user['user_id']);
	$a			= $_bookmarks;
	$b			= array();

	foreach($a as $k => $v)
	{
		$b[$k]['user_id']		= $v['user_id'];
		$b[$k]['bookmark_id']	= $v['bookmark_id'];
		$b[$k]['bm_position']	= $v['bm_position'];
		$b[$k]['bm_title']		= $v['bm_title'];
		$b[$k]['tag']			= $v['tag'];
	}
	$object->data['user_menu'] = &$b;

	if (isset($_POST['update_bookmarks']))
	{
		// repos
		$data = array();

		foreach( $object->data['user_menu'] as $k => $item )
		{
			$data[] = array( "bookmark_id" => $item['bookmark_id'], "bm_position"=> 1 * $_POST['pos_'.$item['bookmark_id']] );
		}

		usort ($data, "bookmark_sorting");

		foreach( $data as $k => $item )
		{
			$data[$k]['bm_position'] = $k + 1;
		}

		// save
		foreach( $data as $item )
		{
			$this->query(
				"UPDATE ".$this->config['table_prefix']."bookmark SET ".
					"bm_position	= '".quote($this->dblink, $item['bm_position'])."', ".
					"bm_title		= '".quote($this->dblink, substr(trim($_POST['title_'.$item['bookmark_id']]),0,250))."' ".
				"WHERE bookmark_id = '".quote($this->dblink, $item['bookmark_id'])."' ".
				"LIMIT 1");
		}
	}
	if (isset($_POST['add_bookmarks']))
	{
		// process input
		if (isset($_POST['tag']) && $newtag = trim($_POST['tag'], '/ '))
		{
			switch ((int)$_POST['option'])
			{
				case 1:
					$prefix = $this->tag.'/';
					break;
				case 2:
					$prefix = substr($this->tag, 0, strrpos($this->tag, '/') + 1);
					break;
				default:
					$prefix = '';
			}
			// check target page existance
			if ($page = $this->load_page($prefix.$newtag, 0, '', LOAD_CACHE, LOAD_META))
			{
				$message = $this->get_translation('PageAlreadyExists')." &laquo;".$page['tag']."&raquo;. ";

				// check existing page write access
				if ($this->has_access('write', $this->get_page_id($prefix.$newtag)))
				{
					$message .= str_replace('%1', "<a href=\"".$this->href('edit', $prefix.$newtag)."\">".$this->get_translation('PageAlreadyExistsEdit2')." </a>?", $this->get_translation('PageAlreadyExistsEdit'));

					$this->set_bookmarks();
				}
				else
				{
					$message .= $this->get_translation('PageAlreadyExistsEditDenied');
				}
				$this->set_message($message);
			}
		}

		// repos
		$data = array();

		foreach( $object->data['user_menu'] as $k => $item )
		{
			$data[] = array( "bookmark_id" => $item['bookmark_id'], "bm_position"=> 1 * $_POST['pos_'.$item['bookmark_id']] );
		}

		usort ($data, "bookmark_sorting");

		foreach( $data as $k => $item )
		{
			$data[$k]['bm_position'] = $k + 1;
		}

		// save
		foreach( $data as $item )
		{
			$this->query(
				"UPDATE ".$this->config['table_prefix']."bookmark SET ".
					"bm_position	= '".quote($this->dblink, $item['bm_position'])."', ".
					"bm_title		= '".quote($this->dblink, substr(trim($_POST['title_'.$item['bookmark_id']]),0,250))."' ".
				"WHERE bookmark_id = '".quote($this->dblink, $item['bookmark_id'])."' ".
				"LIMIT 1");
		}
	}
	else if (isset($_POST['delete_bookmarks']))
	{
		$deletion = '';

		foreach( $object->data['user_menu'] as $item )
		{
			if (isset($_POST['delete_'.$item['bookmark_id']]))
			{
				if ($deletion != '')
				{
					$deletion .= ", ";
				}

				$deletion.= quote($this->dblink, $item['bookmark_id']);
			}
			if ($deletion != '')
			{
				$this->query(
					"DELETE FROM ".$this->config['table_prefix']."bookmark ".
					"WHERE bookmark_id IN (".$deletion.")");
			}
		}
	}
	// reload user data
	$this->set_user($this->load_user($user['user_name']), 0, 1);
	$this->set_bookmarks(BM_USER);
}
if ($user)
{
	$_bookmarks = load_user_bookmarks($this, $user['user_id']);

	if ($_bookmarks)
	{
		// echo "<h4>".$this->get_translation('YourBookmarks')."</h4>";

		// user is logged in; display config form
		echo $this->form_open();
		echo "<input type=\"hidden\" name=\"_user_bookmarks\" value=\"yes\" />";

		echo "<table>";
		echo "<tr><th>".$this->get_translation('BookmarkNo')."</th><th>".$this->get_translation('BookmarkTitle')."</th><th>".$this->get_translation('BookmarkPage')."</th><th>".$this->get_translation('BookmarkMark')."</th><!--<th>Display</th><th>Lang</th>--></tr>";

		foreach($_bookmarks as $_bookmark)
		{
			echo "<tr class=\"lined\">\n
			<td class=\"\">
			<input name=\"pos_".$_bookmark['bookmark_id']."\" type=\"text\" size=\"2\" value=\"".$_bookmark['bm_position']."\" />
			</td><td>
			<input name=\"title_".$_bookmark['bookmark_id']."\" type=\"text\" size=\"40\" value=\"".$_bookmark['bm_title']."\" />
			</td><td>
			<!--<input type=\"radio\" id=\"bookmark".$_bookmark['bookmark_id']."\" name=\"change\" value=\"".$_bookmark['bookmark_id']."\" /> -->
			<label for=\"bookmark".$_bookmark['bookmark_id']."\" title=\"".$_bookmark['title']."\">&raquo; ".$_bookmark['tag']."</label>
			</td><td>
			<input id=\"bookmark".$_bookmark['bookmark_id']."\" name=\"delete_".$_bookmark['bookmark_id']."\" type=\"checkbox\" />
			</td><!--<td>

			".(!empty($_bookmark['bm_title']) ? $_bookmark['bm_title'] : $_bookmark['title'])."
			</td><td>
			".(!empty($_bookmark['lang']) ? $_bookmark['lang'] : "")."-->
			</td>\n</tr>\n";
		}
		echo "<tfoot>";
		echo "<tr>\n<td colspan=\"2\">\n";
		echo "<input name=\"update_bookmarks\" type=\"submit\" value=\"".$this->get_translation('BookmarkSaveChanges')."\" />";
		echo "</td><td>";
		echo "<input name=\"delete_bookmarks\" type=\"submit\" value=\"".$this->get_translation('BookmarkDeleteSelected')."\" />";
		echo "</td>\n</tr>\n";
		echo "</tfoot>";
		echo "</table>";

		echo $this->form_close();

		echo "<br /><br />";
		echo $this->form_open();
		echo "<input type=\"hidden\" name=\"_user_bookmarks\" value=\"yes\" />";
		echo "<input type=\"hidden\" name=\"option\" value=\"3\" />";
		echo "<label for=\"add_bookmarks\">".$this->get_translation('CreateRandomPage').":</label><br />";
		echo "<input id=\"add_bookmarks\" name=\"tag\" value=\"".( isset($_POST['option']) && $_POST['option'] === 3 ? htmlspecialchars($newtag) : "" )."\" size=\"60\" maxlength=\"255\" /> ".
			"<input id=\"add_bookmarks\" type=\"submit\" value=\"".$this->get_translation('CreatePageButton')."\" />";
		echo "";
		echo $this->form_close();
	}
}

?>