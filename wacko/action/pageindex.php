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
if (!isset($for))		$for = '';
$limit = $this->get_list_count(@$max);
$title = (int)$title;

$_alnum = '/'.$this->language['ALPHANUM'].'/';
$get_letter = function ($ch) use (&$_alnum)
{
	$ch = strtoupper(substr($ch, 0, 1));
	if ($ch !== '' && !preg_match($_alnum, $ch))
	{
		$ch = '#';
	}
	return $ch;
};

$letter = $get_letter(isset($_GET['letter'])? $_GET['letter'] : $letter);

// get letters of alphabet with existing pages, and cache them in _SESSION
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
			($title
				? "title ASC "
				: "tag ASC ")
			, true);

	$abc = [];
	foreach ($pages as $page)
	{
		if (($ch = $get_letter(($title)?  $page['title'] : $page['tag'])) !== '')
		{
			if (array_key_exists($ch, $abc))
			{
				++$abc[$ch];
			}
			else
			{
				$abc[$ch] = 1;
			}
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
		($letter !== ''
			? "AND ".
				($title
					? "title "
					: "tag ").
				"LIKE '".$letter."%' "
			: "")
	, true);

$this->dbg('counted pages', $count['n']);

$pagination = $this->pagination($count['n'], $limit, 'p', ($letter !== ''? 'letter=' . $letter : ''));

// collect data for index
$pages_to_display = [];
if (($pages = $this->load_all(
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
		($letter !== ''
			? "AND ".
				($title
					? "title "
					: "tag ").
				"LIKE '".$letter."%' "
			: "").
	"ORDER BY ".
		($title
			? "title ASC "
			: "tag ASC ").
	"LIMIT {$pagination['offset']}, ".(2 * $limit), true)))
{
	$cnt = 0;
	foreach ($pages as $page)
	{
		if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
		{
			if (($ch = $get_letter($title?  $page['title'] : $page['tag'])) !== '')
			{
				if (!array_key_exists($ch, $letters))
				{
					$letters[$ch] = 1;
				}
				$pages_to_display[$page['page_id']] = $page;
				if (++$cnt >= $limit) break;
			}
		}

	}
}

// display navigation
$this->print_pagination($pagination);

// create the top links menu
if ($letters)
{
	// all
	echo '<ul class="ul_letters">' . "\n";
	echo '<li><a href="' . $this->href() . '">' . $this->get_translation('Any') . "</a></li>\n";

	foreach ($letters as $ch => $letter_count)
	{
		if ($ch === $letter)
		{
			echo '<li class="active"><strong>' . $ch . "</strong></li>\n";
		}
		else
		{
			echo '<li><a href="' . $this->href('', '', 'letter=') . $ch . '">' . $ch . "</a></li>\n";
		}
	}

	echo "</ul><br /><br />\n";
}

if (!$pages_to_display)
{
	echo $this->get_translation('NoPagesFound');
	return;
}

echo '<ul class="ul_list">'."\n";

// display collected data
$cur_char = '';
foreach ($pages_to_display as $page)
{
	// do unicode entities
	$page_lang = ($this->page['page_lang'] != $page['page_lang'])?  $page['page_lang'] : '';

	$ch = $get_letter($title?  $page['title'] : $page['tag']);

	if ($ch !== $cur_char)
	{
		if ($cur_char !== '')
		{
			echo "</ul></li>\n";
		}

		echo "\n<li><strong>" . $ch . "</strong>\n<ul>\n";

		$cur_char = $ch;
	}

	echo "<li>";

	if ($title)
	{
		echo $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $page_lang, 0);
	}
	else
	{
		echo $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], 0, 1, $page_lang, 0);
	}

	echo "</li>\n";
}

// close list
echo "</ul>\n</li>\n";
echo "</ul>\n";

$this->print_pagination($pagination);
