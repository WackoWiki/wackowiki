<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: per cluster, pagination

if (!isset($max)) $max = '';
if (!isset($noxml)) $noxml = '';
if (!isset($printed)) $printed = '';
if (!isset($curday)) $curday = '';

if (!$max || $max > 100) $max = 100;

$admin	= $this->is_admin();
$user	= $this->get_user();

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

// loading new pages/comments
$pages1 = $this->load_all(
	"SELECT p.page_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.created AS date, c.tag as comment_on_page, user_name, 1 AS ctype ".
	"FROM {$this->config['table_prefix']}page p ".
		"LEFT JOIN {$this->config['table_prefix']}page c ON (p.comment_on_id = c.page_id) ".
		"LEFT JOIN {$this->config['table_prefix']}user u ON (p.user_id = u.user_id) ".
	"WHERE u.account_type = '0' ".
	"ORDER BY p.created DESC ".
	"LIMIT ".($max * 2), 1);

// loading revisions
$pages2 = $this->load_all(
	"SELECT p.page_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.modified AS date, c.tag as comment_on_page, user_name, 1 AS ctype ".
	"FROM {$this->config['table_prefix']}page p ".
		"LEFT JOIN {$this->config['table_prefix']}page c ON (p.comment_on_id = c.page_id) ".
		"LEFT JOIN {$this->config['table_prefix']}user u ON (p.user_id = u.user_id) ".
	"WHERE p.comment_on_id = '0' ".
	"AND u.account_type = '0' ".
	"ORDER BY modified DESC ".
	"LIMIT ".($max * 2), 1);

// loading uloads
$files = $this->load_all(
	"SELECT f.page_id, c.tag, f.uploaded_dt as created, f.uploaded_dt as modified, f.file_name as title, f.page_id as comment_on_id, f.hits as ip, f.uploaded_dt AS date, c.tag as comment_on_page, user_name, 2 AS ctype ".
	"FROM {$this->config['table_prefix']}upload f ".
		"LEFT JOIN {$this->config['table_prefix']}page c ON (f.page_id = c.page_id) ".
		"LEFT JOIN {$this->config['table_prefix']}user u ON (f.user_id = u.user_id) ".
	"WHERE u.account_type = '0' ".
	"ORDER BY f.uploaded_dt DESC ".
	"LIMIT ".($max * 2), 1);

if ($pages = array_merge($pages1, $pages2, $files))
{
	// sort by dates
	$sort_dates = create_function(
		'$a, $b',	// func params
		'if ($a["date"] == $b["date"]) '.
			'return 0;'.
		'return ($a["date"] < $b["date"] ? 1 : -1);');
	usort($pages, $sort_dates);

	$count	= 0;

	if ($user == true)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}

	if (!(int)$noxml)
	{
		echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/changes_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation('RecentChangesXMLTip')."\" alt=\"XML\" /></a></span><br /><br />\n";
	}
#$this->debug_print_r($pages);
#echo count($pages);
	echo "<ul class=\"ul_list\">\n";

	foreach ($pages as $page)
	{
		if ($this->config['hide_locked'])
		{
			$access = ( $page['comment_on_id'] ? $this->has_access('read', $page['comment_on_id']) : $this->has_access('read', $page['page_id']) );
		}
		else
		{
			$access = true;
		}

		if (!isset($printed[$page['tag']])) $printed[$page['tag']] = '';

		if ($access && ($printed[$page['tag']] != $page['date']) && ($count++ < $max))
		{
			$printed[$page['tag']] = $page['date'];	// ignore duplicates

			// tz offset
			$time_tz = $this->get_time_tz( strtotime($page['date']) );
			$time_tz = date('Y-m-d H:i:s', $time_tz);

			// day header
			list($day, $time) = explode(' ', $time_tz);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}

				echo '<li><strong>'.date($this->config['date_format'],strtotime($day)).":</strong>\n<ul>\n";
				$curday = $day;
			}

			// print entry
			$separator	= ' . . . . . . . . . . . . . . . . ';
			$author		= ( $page['user_name'] == GUEST ? '<em title="'.( $admin ? $page['ip'] : '' ).'">'.$this->get_translation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['user_name']).'" title="'.( $admin ? $page['ip'] : '' ).'">'.$page['user_name'].'</a>' );
			$viewed		= ( $user['last_mark'] == true && $page['user_name'] != $user['user_name'] && $page['date'] > $user['last_mark'] ? ' viewed' : '' );
			$revisions	= ($this->hide_revisions === false || $this->is_admin()
								? ' ('.$this->link('/'.$page['tag'], 'revisions', $this->get_translation('History'), 0, 1).')'
								: ''
							);

			echo '<li class="lined'.$viewed.'"><span class="dt">'.date($this->config['time_format_seconds'], strtotime($time)).'&nbsp;&nbsp;</span>';

			// new file
			if ($page['ctype'] == 2)
			{
				preg_match('/^[^\/]+/', $page['comment_on_page'], $sub_tag);

				if ($page['page_id']) // !$global
				{
					$path2		= '_file:/'.($this->slim_url($page['tag'])).'/';
					$on_page	= $this->get_translation('To').' '.$this->link('/'.$page['comment_on_page'], '', $this->get_page_title('', $page['comment_on_id']), '', 0, 1).' &nbsp;&nbsp;<span title="'.$this->get_translation("Cluster").'">&rarr; '.$sub_tag[0];
				}
				else
				{
					$path2 = '_file:';
					$on_page	= '&rarr; '.'global';
				}

				echo "<img src=\"".$this->config['theme_url']."icons/attachment.png"."\" title=\"".$this->get_translation('NewFileAdded')."\" alt=\"[file]\" /> ".''.$this->link($path2.$page['title'], '', $page['title'], '', 0, 1).' '.$on_page.$separator.$author.'</span>';
			}
			// new comment
			else if ($page['comment_on_id'])
			{
				preg_match('/^[^\/]+/', $page['comment_on_page'], $sub_tag);
				echo "<img src=\"".$this->config['theme_url']."icons/comment.png"."\" title=\"".$this->get_translation('NewCommentAdded')."\" alt=\"[comment]\" /> ".''.$this->link('/'.$page['tag'], '', $page['title'], '', 0, 1).' '.$this->get_translation('To').' '.$this->link('/'.$page['comment_on_page'], '', $this->get_page_title('', $page['comment_on_id']), '', 0, 1).' &nbsp;&nbsp;<span title="'.$this->get_translation("Cluster").'">&rarr; '.$sub_tag[0].$separator.$author.'</span>';
			}
			// new page
			else if ($page['created'] == $page['modified'])
			{
				preg_match('/^[^\/]+/', $page['tag'], $sub_tag);
				echo "<img src=\"".$this->config['theme_url']."icons/add_page.gif"."\" title=\"".$this->get_translation('NewPageCreated')."\" alt=\"[new]\" /> ".''.$this->link('/'.$page['tag'], '', $page['title'], '', 0, 1).' &nbsp;&nbsp;<span title="'.$this->get_translation("Cluster").'">&rarr; '.$sub_tag[0].$separator.$author.'</span>';
			}
			// new revision
			else
			{
				preg_match('/^[^\/]+/', $page['tag'], $sub_tag);
				echo "<img src=\"".$this->config['theme_url']."icons/edit.png"."\" title=\"".$this->get_translation('NewRevisionAdded')."\" alt=\"[changed]\" /> ".''.$this->link('/'.$page['tag'], '', $page['title'], '', 0, 1).$revisions.' &nbsp;&nbsp;<span title="'.$this->get_translation("Cluster").'">&rarr; '.$sub_tag[0].$separator.$author.'</span>';
			}

			echo "</li>\n";
		}
	}

	echo "</ul>\n</li>\n</ul>\n";
}

?>