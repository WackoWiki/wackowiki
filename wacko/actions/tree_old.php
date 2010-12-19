<?php
if (!isset($page)) $page = $this->page['tag'];
$root = (isset($vars[$page]) ? $vars[$page] : '');

// input
if (!isset($owner)) $owner = '';
$owner_id = $this->get_user_id_by_name($owner);
if (!isset($nomark)) $nomark = '';
if (!isset($abc)) $abc = '';
if (!isset($filter)) $filter = '';
if (!isset($style)) $style = 'indent';
if (!isset($root) && !isset($page))
					$root = '/'.$this->page['tag'];
if ($page)			$root = $page;
if ($root == '/') 	$root = '';
if ($root) 			$root = $this->unwrap_link($root);

if (!isset($depth)) $depth = 0;
if (!is_numeric($depth)) $depth = 0;
if ($depth == 0) $depth = 2147483647; //Which means unlimitedly
if (!in_array($style, array('br', 'ul', 'ol', 'indent'))) $style = 'indent';

global $tree_pages_array;

if (!function_exists('create_cluster_tree'))
{
	function create_cluster_tree(&$wacko, $supertag, $tag, $depth)
	{
		global $tree_pages_array;

		while (! ( current($tree_pages_array) === FALSE))
		{
			$page_supertag = key($tree_pages_array);
			$page_tag = pos($tree_pages_array);

			//Itself we do not sketch, the parent must care about this
			if ($supertag == $page_supertag)
			{
				next($tree_pages_array);
				continue;
			}

			if ( $supertag <> '/' && !( strpos($page_supertag,$supertag.'/') === 0) )
			{
				//Ended “our” leaves.
				break;
			}

			//We believe supertag sub

			//Relative
			if ($supertag != '/'){
				$rel_supertag = substr($page_supertag,strlen($supertag) + 1);
			}
			else
			{
				$rel_supertag = substr($page_supertag,1);
			}

			if (!strpos($rel_supertag, '/') === FALSE){$rel_supertag = substr($rel_supertag, 0, strpos($rel_supertag, '/'));};
			//And the absolute
			if ($supertag != '/')
			{
				$sub_supertag = $supertag."/".$rel_supertag;
			}
			else
			{
				$sub_supertag = '/'.$rel_supertag;
			}

			if ($depth > 0)
			{
				//We have to calculate tag for this supertag
				$sub_tag = '';
				$exists = 0;

				if ($tree_pages_array[$sub_supertag])
				{
					//This page is, take her tag.
					$sub_tag = $tree_pages_array[$sub_supertag];
					$exists = 1;
				}
				else
				{
					//This page does not have its sub. We will consider the likely tags.
					$sub_sub_tag = $page_tag;

					//Searches for backslashes so long as there is in supertag
					$scount = substr_count($sub_supertag,"/");
					for ($i = 0; $i < $scount - 1; $i++)
					{
						$sub_tag = $sub_tag.substr($sub_sub_tag, 0, strpos($sub_sub_tag, '/') + 1);;
						$sub_sub_tag = substr($sub_sub_tag, strpos($sub_sub_tag, '/') + 1);
					}
					//Reject everything after the next slash.
					$sub_tag = $sub_tag.substr($sub_sub_tag, 0, strpos($sub_sub_tag, '/'));
				}

				$sub_pages_tree[$sub_tag]['supertag'] = $sub_supertag;
				$sub_pages_tree[$sub_tag]['exists'] = $exists;
			}

			$sub_tree = create_cluster_tree($wacko, $sub_supertag, '', $depth - 1);

			if ($depth > 0)
			{
				$sub_pages_tree[$sub_tag]['subtree'] = $sub_tree;
			}

		}
		if (isset($sub_pages_tree))
			return $sub_pages_tree;
		else
			return null;
	}
}

if (!function_exists('test_page_existance'))
{
	function test_page_existance($page_array)
	{
		if ($page_array['exists']) return true;
			$sub_tree = $page_array['subtree'];
		if (is_array($sub_tree))
		{
			foreach ( $sub_tree as $sub_tag => $sub_page_array )
			{
				if ( test_page_existance($sub_page_array) ) return true;
			}
		}
		return false;
	}
}

if (!function_exists('print_cluster_tree'))
{
	function print_cluster_tree(&$wacko, $tree, $style, $current_depth, $abc, $filter)
	{
		if (is_array($tree))
		{
			ksort ( $tree, SORT_STRING );

			static $letter = '';
			static $need_letter = 0;
			static $newletter = "!";

			if ($style == 'ul')
				print "<ul>";
			if ($style == 'ol')
				print "<ol>";
			if ($style == 'indent')
				print "<div class=\"indent\">";

			foreach ($tree as $sub_tag => $sub_tag_array )
			{
				$sub_supertag = $sub_tag_array['supertag'];
				$sub_exists = $sub_tag_array['exists'];

				$linktext = $sub_tag;
				if ($style != 'br' && (!strpos($linktext, '/') === false))
				{
					//Displaying only the last word
					$linktext = substr($linktext, strrpos($linktext, '/') + 1);
				}

				if ($abc && ( $current_depth == 1 ))
				{
					$newletter = strtoupper(substr($linktext, 0, 1));
					if (!preg_match('/['.$wacko->language['ALPHA_P'].']/', $newletter)) { $newletter = '#'; }
					if ($newletter == '') $newletter = $linktext[0];
					if ($letter <> $newletter)
					{
						$need_letter = 1; //Print at the first opportunity
					}
				};

				if ($sub_exists || ($style != 'br' && ( $filter == 'all' || test_page_existance($sub_tag_array))))
				{
					if ($need_letter == 1)
					{ //Convenient case to print the letter
						if (($style == 'ul' || $style == 'ol' ) && $letter)
							print "<br />";
						if ($letter)
							print "<br />";
						$letter = $newletter;
						print "<strong>".$letter."</strong><br />";
						$need_letter = 0;
					}

					if ($style == 'ul' || $style == 'ol')
						print "<li>";

					$_page = $wacko->load_page(ltrim($sub_supertag, '/'));
					if ($_page['tag'])
						$_tag = $_page['tag'];
					else
						$_tag = $sub_supertag;

					print($wacko->link('/'.$_tag, '', $linktext)."\n");

					if ($style == 'indent' || $style == 'br')
						print "<br />";
				}

				print_cluster_tree($wacko, $sub_tag_array['subtree'], $style, $current_depth + 1, $abc, $filter);
			}

			if ($style == 'ul') print "</ul>";
			if ($style == 'ol') print "</ol>";
			if ($style == 'indent') print "</div>";
		}
	}
}

// header
if ($root)
{
	if (!$nomark)
	{
		$title = $this->get_translation('TreeClusterTitle');
		$title = str_replace('%1',  $this->link('/'.$root, '', $root), $title);
		print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.":</span></p>\n");
	}
	$query = "'".quote($this->dblink, $this->npj_translit($root))."/%'";
}
else
{
	if (!$nomark)  print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('TreeSiteTitle')."</span></p>\n");
	$query = "'%'";
}

$pages = $this->load_all(
	"SELECT ".$this->pages_meta." ".
	"FROM ".$this->config['table_prefix']."page ".
	"WHERE supertag LIKE ".$query.
		($owner_id
			? " AND owner_id='".quote($this->dblink, $owner_id)."'"
			: "").
		" AND comment_on_id = '0'", 1);

if ($pages)
{
	//Check the pages, according to the desired depth ($depth)  at all to be displayed
	$i = 0;
	$current_depth = count(explode('/', $query));
	foreach($pages as $page)
	{
		$page_depth = count(explode('/', $page['supertag']));
		if ($page_depth <= $depth + $current_depth - 1)
		{
			$new_pages[$i] = $page;
			$i++;
		}
	}
	$pages = $new_pages;

	//Cache page and prepare a list for caching acl
	foreach($pages as $page)
	{
		$this->cache_page($page, 0, 1);
		$page_id_list[] = $page['page_id'];
	}

	$acl_str = '';

	//Constituent line request for acl
	for ($i = 0; $i < count($page_id_list); $i++)
	{

		$acl_str .= "'".quote($this->dblink, $page_id_list[$i])."', ";
	}

	$acl_str = substr($acl_str, 0, strlen($acl_str) - 2);

	//Cache access rights
	if ( $read_acls = $this->load_all("SELECT * FROM ".$this->config['table_prefix']."acl WHERE page_id IN (".$acl_str.") AND privilege = 'read'", 1))
	{
		for ($i = 0; $i < count($read_acls); $i++)
		{
			$this->cache_acl($read_acls[$i]['page_id'], "read", 1, $read_acls[$i]);
		}
	}

	//Get an array of pages
	$tree_pages_array = array();
	foreach($pages as $page)
	{
		if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
		{
			$tree_pages_array['/'.$page['supertag']] = $page['tag'];
		}
	}

	//Sort in order supertag
	ksort ( $tree_pages_array, SORT_STRING );

	$tree = create_cluster_tree($this, '/'.$this->npj_translit($root), $root, $depth);

	print_cluster_tree($this, $tree, $style, 1, $abc, $filter);

	// footer
	if (!$nomark) echo "</div>\n";
}
else
{
	$empty_string = $this->get_translation('TreeEmpty');
	$empty_string = str_replace('%1', $this->link('/'.$root, '', $root), $empty_string);
	print($empty_string."<br />");
}

?>