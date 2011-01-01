<?php

/*
 Page Index Action
 {{pageindex
	[for="Cluster"] // optional - show page index only for a certain cluster
	[max=50] // optional - number of pages to show at one time, if there are more pages then this the next/prev buttons are shown
	[letter="a"] // optional - only display pages whose name starts with this letter
	[title=1] // optional - takes title inplace of tag
 }}
 */

$cnt		= '';
$first_char	= '';
$cur_char	= '';
if (!isset($title))		$title = '';
if (!isset($letter))	$letter = '';
$_letter	= ( isset($_GET['letter']) ) ? $_GET['letter'] : $letter;
if(isset($_letter))		$_letter = strtoupper(substr($_letter, 0, 1));
if (!isset($for)) $for = (isset($vars['for']) ? $this->unwrap_link($vars['for']) : '');
if (!isset($for)) $for = $this->page['tag'];
if (!isset($max))		$max = '';
if ($max)				$limit = $max;
else $limit	= 50;

$count = $this->load_single(
	"SELECT COUNT(tag) AS n ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		($for
			? "AND supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
			: "").
		($_letter
			? "AND ".
				($title == 1
					? "title "
					: "tag ").
				"LIKE '{$_letter}%' "
			: "")
	, 1);

$pagination = $this->pagination($count['n'], $limit, $name = 'p', (!empty($_letter) ? 'letter='.$_letter : ''));

// get letters of alphabet with existing pages
if ($pages = $this->load_all(
	"SELECT page_id, tag, title ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		($for
			? "AND supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
			: "").
	"ORDER BY ".
		($title == 1
			? "title ASC "
			: "tag ASC ")
		, 1))
{
	foreach ($pages as $page)
	{
		if ($title == 1)
		{
			if ($page['title'])
			{
				$first_char = strtoupper($page['title'][0]);
			}
		}
		else
		{
			$first_char = strtoupper($page['tag'][0]);
		}

		if(!preg_match('/'.$this->language['ALPHANUM'].'/', $first_char))
		{
			$first_char = '#';
		}

		// Create alphabet links at top of page - Don't display this menu if the user specified a particluar letter
		if($first_char != $cur_char)
		{
			$this->letter[] = $first_char;
			$old_char = $cur_char;
			$cur_char = $first_char;
		}
	}
	#$this->debug_print_r($this->letter);
	$this->letters = array_combine( $this->letter, array_fill( 0, count( $this->letter ), 0 ) );
	#$this->debug_print_r($this->letters);
}

// collect data for index
if ($pages = $this->load_all(
	"SELECT page_id, tag, title ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		($for
			? "AND supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
			: "").
		($_letter
			? "AND ".
				($title == 1
					? "title "
					: "tag ").
				"LIKE '{$_letter}%' "
			: "").
	"ORDER BY ".
		($title == 1
			? "title ASC "
			: "tag ASC ").
	"LIMIT {$pagination['offset']}, ".(2 * $limit), 1))
{
	foreach ($pages as $page)
	{
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

		if ( array_key_exists( $letter, $this->letters ) )
		{
			++ $this->letters[$letter];
		}

		if ($this->config['hide_locked'])
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access)
		{
			$pages_to_display[$page['page_id']] = $page;
			$cnt++;
		}

		if ($cnt >= $limit) break;
	}
	#$this->debug_print_r($this->letters);
	#$this->debug_print_r($pages_to_display);
}

// display navigation
if ($pages_to_display)
{
	$top_links = '';
	$cur_char = '';

	// pagination
	if (isset($pagination['text']))
	{
		echo "<span class=\"pagination\">{$pagination['text']}</span><br />\n";
	}

	// create the top links menu
	if($this->letters)
	{
		// all
		$top_links .= "<ul class=\"ul_letters\">\n";
		$top_links .= "<li><a href=\"".$this->href('', '', '')."\">".$this->get_translation('Any')."</a></li>\n";

		foreach($this->letters as $letter => $letter_count)
		{
			if ( $letter_count > 0 )
			{
				if ($letter === $_letter)
				{
					$top_links.="<li class=\"active\"><strong>".$letter."</strong></li>\n";
				}
				else
				{
					$top_links.="<li><a href=\"".$this->href('', '', 'letter=').$letter."\">".$letter."</a></li>\n";
				}
			}
			else
			{
				$top_links.="<li><a href=\"".$this->href('', '', 'letter=').$letter."\">".$letter."</a></li>\n";
			}
		}

		echo $top_links."</ul><br /><br />\n";
	}

	echo "<ul class=\"ul_list\">\n";

	// display collected data
	foreach ($pages_to_display as $page)
	{
		if ($title == 1)
		{
			if ($page['title'])
			{
				$first_char = strtoupper($page['title'][0]);
			}
		}
		else
		{
			$first_char = strtoupper($page['tag'][0]);
		}

		if (preg_match('/[\W\d]/', $first_char))
		{
			$first_char = '#';
		}

		if ($first_char != $cur_char)
		{
			if ($cur_char)
			{
				echo "</ul></li>\n";
			}

			echo "\n<li><strong>$first_char</strong>\n<ul>\n";

			$cur_char = $first_char;
		}

		echo "<li>";

		if ($title == 1)
		{
			echo $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, '', 0);
		}
		else
		{
			echo $this->link('/'.$page['tag'], '', $page['tag'], $page['title'], 0, 1, '', 0);
			#echo $this->compose_link_to_page($page['tag'], '', $page['tag'], 0);
		}

		echo "</li>\n";
	}

	// close list
	if ($cur_char)
	{
		echo "</ul>\n</li>\n";
	}

	echo "</ul>\n";

	// pagination
	if (isset($pagination['text']))
	{
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
	}
}
else
{
	echo $this->get_translation('NoPagesFound');
}

?>