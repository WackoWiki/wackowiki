<?php

/*
 Page Index Action
 {{pageindex
 [max="50"] // optional - number of pages to show at one time, if there are more pages then this the next/prev buttons are shown
 [letter="a"] // optional - only display pages whose name starts with this letter
 }}
 */

if ($max) $limit = $max;

$offset = ( isset($_GET['offset']) ) ? (int)$_GET['offset'] : 0;
if(!$limit) $limit = 50;
if (!isset($letter)) $letter = '';
if(isset($letter)) $letter = strtoupper(substr($letter, 0, 1));

// Get tags for all the pages, even if they're not being displayed on this index page
$sql = "SELECT page_id, tag FROM ".$this->config['table_prefix']."page WHERE comment_on_id = '0' ORDER BY tag";
$pages = $this->load_all($sql, 1);

$total = 0;
$total_visible = 0;
$top_links = '';
$top_links_array = array();
$page_links = '';
$letter_count = 0;

$page_links .= "<ul>\n";
foreach($pages as $page)
{
	$firstChar = strtoupper($page['tag'][0]);
	if(!preg_match('/'.$this->language['ALPHA'].'/', $firstChar)) { $firstChar = '#'; }

	// Create alphabet links at top of page - Don't display this menu if the user specified a particluar letter
	if($firstChar != $curChar)
	{
		$top_links_array[] = array('char' => $firstChar, 'ind' => $total, 'link' => $letter_count);

		$oldChar = $curChar;
		$curChar = $firstChar;
		$letter_count++;
	}

	// Display the actual page link
	if($this->config['hide_locked'])
		$access = $this->has_access('read',$page['page_id']);
	else
		$access = true;

	if($access)
	{

		if($total >= $offset)
		{
			if($total < $offset + $limit)
			{
				if(!$letter || $firstChar == $letter)
				{

					if($firstChar != $oldChar)
					{
						if ($oldChar && !$letter)
						{
							$page_links .= "</ul>\n<br /></li>\n";
						}
						$page_links .= "<li><a name=\"letter_".($letter_count - 1)."\"></a><strong>".$firstChar."</strong><ul>\n";
						$oldChar = $firstChar;
					}

					$page_links .= "<li>".$this->link('/'.$page['tag'], '', $page['tag'])."</li>\n";

					$total_visible++;
				}

			}
		}

		if(!$letter || $firstChar == $letter)
		{
			$total++;
		}
	}
}
$page_links .= "</ul>\n</li>\n";
$page_links .= "</ul>\n";

// Display prev/next navigation links?
if ($limit >= $total) $no_arr = true;

// Create the top links menu
if(!$letter)
{
	if(!$no_arr)
	{
		foreach($top_links_array as $link_data)
		{
			$top_links.="<a href=\"".$this->href('', '', 'offset=').(floor($link_data['ind'] / $limit) * $limit)."#letter_".$link_data['link']."\"><strong>".$link_data['char']."</strong></a>\n";
		}
	}
	else
	{
		foreach($top_links_array as $link_data)
		{
			$top_links.="<a href=\"#letter_".$link_data['link']."\"><li><strong>".$link_data['char']."</strong></a>\n";
		}
	}

	print($top_links."<br /><br />\n");
}

print($page_links);

if($page_links != '')
{
	if(!$no_arr)
	{
		// Prev
		if($offset + $total_visible > $limit)
		{
			$prev_page_link = '<a href="'.$this->href('', '', 'offset=').($offset - $limit > 0 ? $offset - $limit : 0).'">&lt; '.$this->get_translation('Prev').'</a> |';
		}
		else
		{
			$prev_page_link = "&lt; ".$this->get_translation('Prev')." |";
		}

		// Next
		if($offset + $total_visible < $total)
		{
			$next_page_link = '<a href="'.$this->href('', '', 'offset=').($offset + $total_visible).'">'.$this->get_translation('Next').' &gt;</a>';
		}
		else
		{
			$next_page_link = $this->get_translation('Next')." &gt;";
		}

		print "<p class='logBtn'>$prev_page_link $next_page_link</p>\n";
	}
}
else
{
	print $this->get_translation('NoPagesFound');
}

?>