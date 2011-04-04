<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('bookmark_sorting'))
{
	function bookmark_sorting ($a, $b)
	{
		if ($a['menu_position'] == $b['menu_position'])
		{
			return 0;
		}
		return ($a['menu_position'] < $b['menu_position'])
			? -1
			: 1;
	}
}

if (!function_exists('load_user_bookmarks'))
{
	function load_user_bookmarks(&$wacko, $user_id)
	{
		$_bookmarks = $wacko->load_all(
							"SELECT p.tag, p.title, b.menu_id, b.user_id, b.menu_title, b.lang, b.menu_position ".
							"FROM ".$wacko->config['table_prefix']."menu b ".
								"LEFT JOIN ".$wacko->config['table_prefix']."page p ON (b.page_id = p.page_id) ".
							"WHERE b.user_id = '".quote($wacko->dblink, $user_id)."' ".
							"ORDER BY b.menu_position", 0);

		return $_bookmarks;
	}
}

// {{bookmarks system=[0|1]}}

if (!isset($system)) $system = 0;
$message	= '';

// get default bookmarks
if ($this->is_admin() && $system == true)
{
	$_user_id	= $this->get_user_id('System');
}
else
{
	$user		= $this->get_user();
	$_user_id	= $user['user_id'];
}

/// Processing of our special form
if (isset($_POST['_user_bookmarks']))
{
	$_bookmarks	= load_user_bookmarks($this, $_user_id);
	$a			= $_bookmarks;
	$b			= array();

	foreach($a as $k => $v)
	{
		$b[$k]['user_id']		= $v['user_id'];
		$b[$k]['menu_id']		= $v['menu_id'];
		$b[$k]['menu_position']	= $v['menu_position'];
		$b[$k]['menu_title']	= $v['menu_title'];
		$b[$k]['tag']			= $v['tag'];
	}

	$object->data['user_menu'] = &$b;

	if (isset($_POST['update_bookmarks']))
	{
		// repos
		$data = array();

		foreach( $object->data['user_menu'] as $k => $item )
		{
			$data[] = array(
				'menu_id'		=> $item['menu_id'],
				'menu_position'	=> 1 * $_POST['pos_'.$item['menu_id']]
			);
		}

		usort ($data, "bookmark_sorting");

		foreach( $data as $k => $item )
		{
			$data[$k]['menu_position'] = $k + 1;
		}

		// save
		foreach( $data as $item )
		{
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."menu SET ".
					"menu_position	= '".quote($this->dblink, $item['menu_position'])."', ".
					"menu_title		= '".quote($this->dblink, substr(trim($_POST['title_'.$item['menu_id']]),0,250))."' ".
				"WHERE menu_id = '".quote($this->dblink, $item['menu_id'])."' ".
				"LIMIT 1");
		}
	}
	else if (isset($_POST['add_bookmarks']))
	{
		// process input
		if (!empty($_POST['tag']))
		{
			$new_tag = trim($_POST['tag'], '/ ');

			// check target page existance
			if ($page = $this->load_page($new_tag, 0, '', LOAD_CACHE, LOAD_META))
			{
				$_page_id = $this->get_page_id($new_tag);

				// check existing page write access
				if ($this->has_access('write', $_page_id))
				{
					// check if bookmark already exists
					if ($this->load_single(
						"SELECT menu_id ".
						"FROM ".$this->config['table_prefix']."menu ".
						"WHERE user_id = '".quote($this->dblink, $_user_id)."' ".
							"AND page_id = '".quote($this->dblink, $_page_id)."' ".
						"LIMIT 1"))
					{
						$message .= $this->get_translation('BookmarkAlreadyExists');
					}
					else
					{
						// writing bookmark
						$_bookmark_page_ids = $this->get_bookmark_links();

						if (!in_array($_page_id, $_bookmark_page_ids))
						{
							$bookmarks[] = array(
								$_page_id,
								'(('.$page['tag'].' '.$this->get_page_title($page['tag']).($user['lang'] != $page['lang'] ? ' @@'.$page['lang'] : '').'))'
								);

							$_menu_position = $this->load_all(
								"SELECT b.menu_id ".
								"FROM ".$this->config['table_prefix']."menu b ".
								"WHERE b.user_id = '".quote($this->dblink, $_user_id)."' ", 0);

							$_bookmark_count = count($_menu_position);

							$this->sql_query(
								"INSERT INTO ".$this->config['table_prefix']."menu SET ".
								"user_id			= '".quote($this->dblink, $_user_id)."', ".
								"page_id			= '".quote($this->dblink, $_page_id)."', ".
								"lang				= '".quote($this->dblink, ($user['lang'] != $page['lang'] ? $page['lang'] : ""))."', ".
								"menu_position		= '".quote($this->dblink, ($_bookmark_count + 1))."'");
						}

						// parsing bookmarks into link table
						foreach ($bookmarks as $_bookmark)
						{
							$bookmark_page_ids[] = $_bookmark[0];
							$bookmark_formatted[] = array ($_bookmark[0], $_bookmark[1], $this->format($_bookmark[1], 'wacko'));
						}

						$_SESSION[$this->config['session_prefix'].'_'.'bookmark_link']	= $bookmark_page_ids;
						$_SESSION[$this->config['session_prefix'].'_'.'bookmark']		= $bookmark_formatted;
					}
				}
				else
				{
					// no access rights
					$message .= $this->get_translation('ReadAccessDenied');
				}
			}
			else
			{
				// page does not exits
				$message .= $this->get_translation('DoesNotExists');
			}
		}
		else
		{
			// no page given
			#$message .= $this->get_translation('PageAlreadyExistsEditDenied');
		}

		$this->set_message($message);
	}
	else if (isset($_POST['delete_bookmarks']))
	{
		$deletion = '';

		foreach( $object->data['user_menu'] as $item )
		{
			if (isset($_POST['delete_'.$item['menu_id']]))
			{
				if ($deletion != '')
				{
					$deletion .= ", ";
				}

				$deletion.= quote($this->dblink, $item['menu_id']);
			}
			if ($deletion != '')
			{
				$this->sql_query(
					"DELETE FROM ".$this->config['table_prefix']."menu ".
					"WHERE menu_id IN (".$deletion.")");
			}
		}
	}

	// reload user data
	$this->set_user($this->load_user('', $_user_id, '', true), 0, 1, true);
	$this->set_bookmarks(BOOKMARK_USER);
}

if ($_user_id)
{
	$_bookmarks = load_user_bookmarks($this, $_user_id);

	if ($_bookmarks)
	{
		// echo "<h4>".$this->get_translation('YourBookmarks')."</h4>";

		// user is logged in; display config form
		echo $this->form_open();
		echo "<input type=\"hidden\" name=\"_user_bookmarks\" value=\"yes\" />";

		echo "<table>";
		echo "<tr><th>".$this->get_translation('BookmarkNumber')."</th><th>".$this->get_translation('BookmarkTitle')."</th><th>".$this->get_translation('BookmarkPage')."</th><th>".$this->get_translation('BookmarkMark')."</th><!--<th>Display</th><th>Lang</th>--></tr>";

		foreach($_bookmarks as $_bookmark)
		{
			echo "<tr class=\"lined\">
			<td class=\"\">
			<input name=\"pos_".$_bookmark['menu_id']."\" type=\"text\" size=\"2\" value=\"".$_bookmark['menu_position']."\" />
			</td><td>
			<input name=\"title_".$_bookmark['menu_id']."\" type=\"text\" size=\"40\" value=\"".$_bookmark['menu_title']."\" />
			</td><td>
			<!--<input type=\"radio\" id=\"bookmark".$_bookmark['menu_id']."\" name=\"change\" value=\"".$_bookmark['menu_id']."\" /> -->
			<label for=\"bookmark".$_bookmark['menu_id']."\" title=\"".$_bookmark['title']."\">&raquo; ".$_bookmark['tag']."</label>
			</td><td>
			<input id=\"bookmark".$_bookmark['menu_id']."\" name=\"delete_".$_bookmark['menu_id']."\" type=\"checkbox\" />
			</td><!--<td>

			".(!empty($_bookmark['menu_title']) ? $_bookmark['menu_title'] : $_bookmark['title'])."
			</td>-->";

			if ($system)
			{
				echo '<td>'.(!empty($_bookmark['lang']) ? $_bookmark['lang'] : "");
			}

			echo "</td>\n</tr>\n";
		}

		echo "<tfoot>";
		echo "<tr>\n<td colspan=\"2\">\n";
		echo "<input name=\"update_bookmarks\" type=\"submit\" value=\"".$this->get_translation('BookmarkSaveChanges')."\" />";
		echo "</td><td>";
		echo "<input name=\"delete_bookmarks\" type=\"submit\" value=\"".$this->get_translation('BookmarkDeleteSelected')."\" />";
		echo "</td>\n</tr>\n";
		echo "</tfoot>";
		echo "</table>";
	}
	else
	{
		echo $this->get_translation('BookmarkNone');
	}

	echo $this->form_open();
	echo "<input type=\"hidden\" name=\"_user_bookmarks\" value=\"yes\" />";
	echo "<br /><br />";
	echo "<label for=\"add_bookmark\">".$this->get_translation('BookmarksAddPage').":</label><br />";
	echo "<input id=\"add_bookmark\" name=\"tag\" value=\"\" size=\"60\" maxlength=\"255\" /> ".
		"<input name=\"add_bookmarks\" type=\"submit\" value=\"".$this->get_translation('CreatePageButton')."\" />";

	echo $this->form_close();
}

?>