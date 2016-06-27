<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Page Index Action
 {{pageindex
	[for="Cluster"]		// show page index only for a certain cluster
	[max=50]			// number of pages to show at one time, if there are more pages then this the next/prev buttons are shown
	[letter="a"]		// only display pages whose name starts with this letter
	[title=1]			// takes title inplace of tag
	[lang="ru"]			// show pages only in specified language
 }}
 */

if (!isset($title))		$title = '';
if (!isset($letter))	$letter = '';
if (!isset($lang))		$lang = '';
if (!isset($for))		$for = isset($vars['for'])? $this->unwrap_link($vars['for']) : 0;
$limit = $this->get_list_count(@$max);

$_letter = isset($_GET['letter'])? $_GET['letter'] : $letter;
$_letter = strtoupper(substr($_letter, 0, 1));
$_alnum = '/'.$this->language['ALPHANUM'].'/';

// get letters of alphabet with existing pages
$letters = &$_SESSION['pi_letters'];
if (!isset($letters)
	|| $_SESSION['pi_for'] != $for
	|| $_SESSION['pi_lang'] != $lang
	|| $_SESSION['pi_title'] != $title
	|| time() > $_SESSION['pi_time'])
{
	$_SESSION['pi_for'] = $for;
	$_SESSION['pi_lang'] = $lang;
	$_SESSION['pi_title'] = $title;
	$_SESSION['pi_time'] = time() + 600;

	$pages = $this->load_all(
		"SELECT tag, title ".
		"FROM {$this->config['table_prefix']}page ".
		"WHERE comment_on_id = '0' ".
			"AND deleted = '0' ".
			($for
				? "AND supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
				: "").
			($lang
				? "AND page_lang = '".quote($this->dblink, $lang)."' "
				: "").
		"ORDER BY ".
			($title == 1
				? "title ASC "
				: "tag ASC ")
			, true);

	$abc = [];
	foreach ($pages as $page)
	{
		$ch = ($title)?  $page['title'] : $page['tag'];
		if (($ch = strtoupper(substr($ch, 0, 1))) !== '')
		{
			if (!preg_match($_alnum, $ch))
			{
				$ch = '#';
			}
			$abc[$ch] = 0;
		}
	}

	$letters = $abc;
}


$count = $this->load_single(
	"SELECT COUNT(page_id) AS n ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		"AND deleted = '0' ".
		($for
			? "AND supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
			: "").
		($lang
			? "AND page_lang = '".quote($this->dblink, $lang)."' "
			: "").
		($_letter
			? "AND ".
				($title == 1
					? "title "
					: "tag ").
				"LIKE '".$_letter."%' "
			: "")
	, true);

$pagination = $this->pagination($count['n'], $limit, 'p', ($_letter? 'letter=' . $_letter : ''));


// collect data for index
$pages_to_display	= [];
if ($pages = $this->load_all(
	"SELECT page_id, tag, title, page_lang ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		"AND deleted = '0' ".
		($for
			? "AND supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
			: "").
		($lang
			? "AND page_lang = '".quote($this->dblink, $lang)."' "
			: "").
		($_letter
			? "AND ".
				($title == 1
					? "title "
					: "tag ").
				"LIKE '".$_letter."%' "
			: "").
	"ORDER BY ".
		($title == 1
			? "title ASC "
			: "tag ASC ").
	"LIMIT {$pagination['offset']}, ".(2 * $limit), true))
{
	$cnt				= '';
	foreach ($pages as $page)
	{
		$letter = '';
		if ($title == 1)
		{
			if ($page['title'])
			{
				$letter = strtoupper( $page['title'][0] );
			}
		}
		else
		{
			$letter = strtoupper( $page['tag'][0] );
		}

		if ( array_key_exists( $letter, $letters ) )
		{
			++ $letters[$letter];
		}

		if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
		{
			$pages_to_display[$page['page_id']] = $page;
			if (++$cnt >= $limit) break;
		}

	}
}

// display navigation
if ($pages_to_display)
{
	$top_links = '';
	$cur_char = '';

	$this->print_pagination($pagination);

	// create the top links menu
	if ($letters)
	{
		// all
		$top_links .= '<ul class="ul_letters">'."\n";
		$top_links .= '<li><a href="'.$this->href('', '', '').'">'.$this->get_translation('Any')."</a></li>\n";

		foreach ($letters as $letter => $letter_count)
		{
			if ( $letter_count > 0 )
			{
				if ($letter === $_letter)
				{
					$top_links .= '<li class="active"><strong>'.$letter."</strong></li>\n";
				}
				else
				{
					$top_links .= '<li><a href="'.$this->href('', '', 'letter=').$letter.'">'.$letter."</a></li>\n";
				}
			}
			else
			{
				$top_links .= '<li><a href="'.$this->href('', '', 'letter=').$letter.'">'.$letter."</a></li>\n";
			}
		}

		echo $top_links."</ul><br /><br />\n";
	}

	echo '<ul class="ul_list">'."\n";

	// display collected data
	$first_char = '';
	foreach ($pages_to_display as $page)
	{
		// do unicode entities
		if ($this->page['page_lang'] != $page['page_lang'])
		{
			$page_lang = $page['page_lang'];
		}
		else
		{
			$page_lang = '';
		}

		$first_char = $title?  $page['title'] : $page['tag'];

		if (($first_char = strtoupper(substr($first_char, 0, 1))) === '')
		{
			continue;
		}
		if (!preg_match($_alnum, $first_char))
		{
			$first_char = '#';
		}

		if ($first_char != $cur_char)
		{
			if ($cur_char)
			{
				echo "</ul></li>\n";
			}

			echo "\n<li><strong>".$first_char."</strong>\n<ul>\n";

			$cur_char = $first_char;
		}

		echo "<li>";

		if ($title == 1)
		{
			echo $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, $page_lang, 0);
		}
		else
		{
			echo $this->link('/'.$page['tag'], '', $page['tag'], $page['title'], 0, 1, $page_lang, 0);
		}

		echo "</li>\n";
	}

	// close list
	if ($cur_char)
	{
		echo "</ul>\n</li>\n";
	}

	echo "</ul>\n";

	$this->print_pagination($pagination);
}
else
{
	echo $this->get_translation('NoPagesFound');
}

?>
