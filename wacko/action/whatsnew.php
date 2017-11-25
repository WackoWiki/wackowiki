<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: per cluster, pagination, hard coded icons

if (!isset($max)) $max = '';
if (!isset($noxml)) $noxml = '';
if (!isset($printed)) $printed = [];

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
$pages1 = $this->db->load_all(
	"SELECT p.page_id, p.tag, p.supertag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.created AS date, p.edit_note, p.page_lang, c.page_lang AS cf_lang, c.tag as comment_on_page, c.title as title_on_page, user_name, 1 AS ctype, p.deleted " .
	"FROM " . $this->db->table_prefix . "page p " .
		"LEFT JOIN " . $this->db->table_prefix . "page c ON (p.comment_on_id = c.page_id) " .
		"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
	"WHERE (u.account_type = '0' OR p.user_id = '0') " .
	"ORDER BY p.created DESC " .
	"LIMIT " . ($max * 2), true);

// loading revisions
$pages2 = $this->db->load_all(
	"SELECT p.page_id, p.tag, p.supertag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.modified AS date, p.edit_note, p.page_lang, c.page_lang AS cf_lang, c.tag as comment_on_page, c.title as title_on_page, user_name, 1 AS ctype, p.deleted " .
	"FROM " . $this->db->table_prefix . "page p " .
		"LEFT JOIN " . $this->db->table_prefix . "page c ON (p.comment_on_id = c.page_id) " .
		"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
	"WHERE p.comment_on_id = '0' " .
		"AND p.deleted = '0' " .
		"AND (u.account_type = '0' OR p.user_id = '0') " .
	"ORDER BY modified DESC " .
	"LIMIT " . ($max * 2), true);

// loading uloads
$files = $this->db->load_all(
	"SELECT f.page_id, c.tag, c.supertag, f.uploaded_dt as created, f.uploaded_dt as modified, f.file_name as title, f.file_id as comment_on_id, f.hits as ip, f.uploaded_dt AS date, f.file_description AS edit_note, c.page_lang, f.file_lang AS cf_lang, c.tag as comment_on_page, c.title as title_on_page, user_name, 2 AS ctype, f.deleted " .
	"FROM " . $this->db->table_prefix . "file f " .
		"LEFT JOIN " . $this->db->table_prefix . "page c ON (f.page_id = c.page_id) " .
		"LEFT JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
	"WHERE u.account_type = '0' " .
		"AND f.deleted = '0' " .
	"ORDER BY f.uploaded_dt DESC " .
	"LIMIT " . ($max * 2), true);

if (($pages = array_merge($pages1, $pages2, $files)))
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
		echo '<small><a href="' . $this->href('', '', ['markread' => 1]) . '">' . $this->_t('MarkRead') . '</a></small>';
	}

	if (!(int) $noxml)
	{
		echo '<span class="desc_rss_feed"><a href="' . $this->db->base_url . XML_DIR . '/changes_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)) . '.xml"><img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('RecentChangesXMLTip') . '" alt="XML" class="btn-feed"></a></span><br><br>' . "\n";
	}

	echo '<ul class="ul_list">' . "\n";

	$curday = '';

	$pagination	= $this->pagination(count($pages), @$max, 'n', ($mode? ['o' => $mode] : ''), '');
	$pages		= array_slice($pages, $pagination['offset'], $pagination['perpage']);

	//
	foreach ($pages as $page)
	{
		if ($page['ctype'] == 2)
		{
			$file_ids[] = $page['comment_on_id'];
		}
		else
		{
			$page_ids[] = $page['page_id'];

			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, 0, 1);
		}
	}

	if ($files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, f.hits, p.tag, p.supertag, u.user_name " .
		"FROM " . $this->db->table_prefix . "file f " .
			"LEFT JOIN  " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE f.file_id IN ( " . implode(', ', $file_ids) . " ) " .
		" "))
	{
		foreach ($files as $file)
		{
			$this->files_cache[$file['page_id']][$file['file_name']] = $file;
		}
	}

	// cache acls
	$this->preload_acl($page_ids);

	$this->print_pagination($pagination);

	foreach ($pages as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = ($page['comment_on_id'] && $page['ctype'] != 2
					? $this->has_access('read', $page['comment_on_id'])
					: $this->has_access('read', $page['page_id']));
		}
		else
		{
			$access = true;
		}

		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$page['tag']] = $page['page_id'];

		if (!isset($printed[$page['tag']]))
		{
			$printed[$page['tag']] = '';
		}

		if ($access && $printed[$page['tag']] != $page['date'] && ($count++ < $max))
		{
			$printed[$page['tag']] = $page['date'];	// ignore duplicates

			$this->sql2datetime($page['date'], $day, $time);

			// day header
			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br></li>\n";
				}

				echo '<li><strong>' . $day . "</strong>\n<ul>\n";
				$curday = $day;
			}

			// check current page lang for different charset to do_unicode_entities() against
			// - page lang
			if ($this->page['page_lang'] != $page['page_lang'])
			{
				$_lang = $page['page_lang'];
			}
			else
			{
				$_lang = '';
			}

			// - comment lang / file description lang
			if ($this->page['page_lang'] != $page['cf_lang'])
			{
				$_cf_lang = $page['cf_lang'];
			}
			else
			{
				$_cf_lang = '';
			}

			// print entry
			$separator		= ' . . . . . . . . . . . . . . . . ';
			$author			= $this->user_link($page['user_name'], '', true, false);
			$viewed			= ( isset($user['last_mark']) && $user['last_mark'] && $page['user_name'] != $user['user_name'] && $page['date'] > $user['last_mark'] ? ' viewed' : '' );
			$time_modified	= (!$this->hide_revisions && ($page['ctype'] != 2 || $page['comment_on_id'] === 0))
								? $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip'))
								: $time;

			if (($edit_note = $page['edit_note']))
			{
				if ($_lang)
				{
					$edit_note = $this->do_unicode_entities($edit_note, $_lang);
				}
				else if ($_cf_lang)
				{
					$edit_note = $this->do_unicode_entities($edit_note, $_cf_lang);
				}

				$edit_note = ' <span class="editnote">[' . $edit_note . ']</span>';
			}

			// time
			echo '<li class="lined' . $viewed . '"><span class="dt">' . $time_modified . '&nbsp;&nbsp;</span>';

			// new file
			if ($page['ctype'] == 2)
			{
				preg_match('/^[^\/]+/', $page['comment_on_page'], $sub_tag);

				if ($page['page_id']) // !$global
				{
					$path2		= '_file:/'.($this->slim_url($page['tag'])) . '/';
					$on_page	= $this->_t('To') . ' '.
						$this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1, $_lang) .
						' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0];
				}
				else
				{
					$path2		= '_file:';
					$on_page	= '<span title="">&rarr; ' . $this->_t('UploadGlobal');
				}

				echo '<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('NewFileAdded') .
					'" alt="[file]" class="btn-attachment"> '.'' . $this->link($path2 . $page['title'], '', $this->shorten_string($page['title']), '', 0, 1, $_lang) .
					' ' . $on_page . $separator . $author . '</span>' . $edit_note;
			}
			// deleted
			else if ($page['deleted'])
			{
				if ($page['comment_on_page'])
				{
					preg_match('/^[^\/]+/', $page['comment_on_page'], $sub_tag);
				}
				else
				{
					preg_match('/^[^\/]+/', $page['tag'], $sub_tag);
				}

				echo '<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('NewCommentAdded') . '" alt="[deleted]" class="btn-delete"> '.'' . $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_cf_lang) . ' ' . $this->_t('To') . ' ' . $this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1, $_cf_lang) . ' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0] . $separator . $author . '</span>' . $edit_note;
			}
			// new comment
			else if ($page['comment_on_id'])
			{
				preg_match('/^[^\/]+/', $page['comment_on_page'], $sub_tag);
				echo '<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('NewCommentAdded') . '" alt="[comment]" class="btn-comment"> '.'' . $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_cf_lang) . ' ' . $this->_t('To') . ' ' . $this->link('/' . $page['comment_on_page'], '', $page['title_on_page'], '', 0, 1, $_cf_lang) . ' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0] . $separator . $author . '</span>' . $edit_note;
			}
			// new page
			else if ($page['created'] == $page['date'])
			{
				preg_match('/^[^\/]+/', $page['tag'], $sub_tag);
				echo '<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('NewPageCreated') . '" alt="[new]" class="btn-add_page"> '.'' . $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_lang) . ' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0] . $separator . $author . '</span>' . $edit_note;
			}
			// new revision
			else
			{
				preg_match('/^[^\/]+/', $page['tag'], $sub_tag);
				echo '<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('NewRevisionAdded') . '" alt="[changed]" class="btn-edit"> '.'' . $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_lang) . ' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0] . $separator . $author . '</span>' . $edit_note;
			}

			echo "</li>\n";
		}
	}

	echo "</ul>\n</li>\n</ul>\n";

	$this->print_pagination($pagination);
}

?>
