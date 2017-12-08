<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Showing uploaded by {{upload}} files

	{{files
		[page="PageName" or global=1 or all=1]
		[order="time|FILENAME|size|size_desc|ext"]
		[owner="UserName"]
		[picture=1]
		[max=number]
	}}
 */

// TODO:
// - add option to select all files: all=1 (?) -> DONE
// - add option to select used files -> file_link table & page_id -> DONE
// - add option to filter by tags -> DONE

$page_id	= '';
$ppage		= '';
$files		= [];
$object_ids	= [];

if (!isset($nomark))	$nomark		= 0;
if (!isset($order))		$order		= '';
if (!isset($global))	$global		= 0;	// global attachments
if (!isset($all))		$all		= 0;	// all attachments
if (!isset($linked))	$linked		= '';	// file link in page
if (!isset($tag))		$tag		= '';	// FIXME: $tag == $page
if (!isset($owner))		$owner		= '';
if (!isset($page))		$page		= '';
if (!isset($legend))	$legend		= '';
if (!isset($method))	$method		= '';	// for use in page handler
if (!isset($params))	$params		= null;	//for $_GET parameters to be passed with the page link
if (!isset($deleted))	$deleted	= 0;
if (!isset($track))		$track		= 0;
if (!isset($picture))	$picture	= null;
if (!isset($max))		$max		= null;
if (!isset($type_id))	$type_id	= null;

$order_by			= "file_name ASC";
$file_name_maxlen	= 80;

// filter categories
$type_id			= (int) ($_GET['type_id'] ?? $type_id);
$category_id		= (int) @$_GET['category_id'];
$file_link			= (int) $linked;


if ($order == 'time')		$order_by = "uploaded_dt DESC";
if ($order == 'size')		$order_by = "file_size ASC";
if ($order == 'size_desc')	$order_by = "file_size DESC";
if ($order == 'ext')		$order_by = "file_ext ASC";

// check against standard_handlers
#if (! in_array($method, ))
#{
#	$method = '';
#}

// do we allowed to see?
if (!$global)
{
	if ($page == '')
	{
		$page		= $this->tag;
		$page_id	= $this->page['page_id'];
	}
	else
	{
		$page	= $this->unwrap_link($page);
		$ppage	= '/' . $page;

		if ($_page_id = $this->get_page_id($page))
		{
			$page_id	= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
	$can_delete	= $this->is_admin() || $this->is_owner($page_id);
}
else
{
	$can_view	= 1;
	$page		= $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $page))
	{
		$filepage = $this->page;
	}
	else
	{
		$filepage = $this->load_page($page);
	}

	if (!$global && !isset($filepage['page_id']))
	{
		return;
	}

	$selector =
		($category_id
			? "INNER JOIN " . $this->db->table_prefix . "category_assignment AS k ON (k.object_id = f.file_id) "
			: "") . " " .
		($file_link
			? "INNER JOIN " . $this->db->table_prefix . "file_link AS l ON (f.file_id = l.file_id) "
			: "") . " " .
			"WHERE ".
		($all || $file_link
			? "f.page_id IS NOT NULL "
			: "f.page_id = " . ($global ? 0 : (int) $filepage['page_id']) . " "
			) . " " .
		($owner
			? "AND u.user_name = " . $this->db->q($owner) . " "
			: '') .
		($deleted != 1
			? "AND f.deleted <> 1 "
			: "");

	if ($category_id)
	{
		$selector .= "AND k.category_id IN ( " . $this->db->q($category_id) . " ) " .
					 "AND k.object_type_id = " . OBJECT_FILE . " ";
	}

	if ($file_link)
	{
		$selector .= "AND l.page_id = " . $filepage['page_id'] . " ";
	}

	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $max, 'f', $params, $method);

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, f.hits, p.tag, p.supertag, u.user_name " .
		"FROM " . $this->db->table_prefix . "file f " .
			"LEFT JOIN  " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		$pagination['limit']);

	foreach ($files as $file)
	{
		$object_ids[]	= $file['file_id'];
		$this->file_cache[$file['page_id']][$file['file_name']] = $file;
	}

	// cache categories
	$this->preload_categories($object_ids, OBJECT_FILE);

	// display
	$info_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('FileViewProperties') . '" alt="' . $this->_t('FileViewProperties') . '" class="btn-info"/>';
	$edit_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('FileEditProperties') . '" alt="' . $this->_t('FileEditProperties') . '" class="btn-edit"/>';
	$del_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('FileRemove') . '" alt="' . $this->_t('FileRemove') . '" class="btn-delete"/>';

	if ($picture)
	{
		$path1 = 'file:/';
		$style = 'upload tbl_fixed';
	}
	else
	{
		// !!!!! patch link to not show pictures when not needed
		$path1 = '_file:/';
		$style = 'upload';
	}

	$this->print_pagination($pagination);

	$results = count($files);

	if (!$nomark)
	{
		$title = $this->_t('UploadTitle'.($global ? 'Global' : '') ) . ' ' . ($page ? $this->link($ppage, '', $legend) : '');
		echo '<div class="layout-box"><p><span>' . $results . ' of ' . '' . $count['n'] . ' ' . $title . ": </span></p>\n";
	}

	if ($results)
	{
		echo '<table class="' . $style . '" >' . "\n";

		/* echo '<colgroup>
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
		</colgroup>'; */

		foreach ($files as $file)
		{
			// check for local file
			if ($file['page_id'])
			{
				// skip if user has no access rights for page
				if ($all
					&& !($this->has_access('read', $file['page_id'])
						|| $this->is_admin()
						|| $this->is_owner($file['page_id'])))
				{
					continue;
				}

				// absolute file path: file:/path/
				$path2	= $path1 . ($this->slim_url($file['tag'])) . '/';
				$page	= $file['tag'];
				$url	= $this->href('file', trim($file['supertag'], '/'), ['get' => $file['file_name']]);
			}
			else
			{
				// global file
				$path2	= $path1;
				$url	= $this->db->base_url . Ut::join_path(UPLOAD_GLOBAL_DIR, $file['file_name']);
			}

			$dt			= $this->get_time_formatted($file['uploaded_dt']);
			$desc		= $this->format($file['file_description'], 'typografica' );
			$desc		= $this->get_unicode_entities($desc, $file['file_lang']);

			if ($desc == '')
			{
				$desc = "&nbsp;";
			}

			$file_id	= $file['file_id'];
			$file_name	= $file['file_name'];
			$shown_name	= $this->shorten_string($file_name, $file_name_maxlen);
			$text		= ($picture
							? ($file['picture_w'] || $file['file_ext'] == 'svg'
								? ''
								: $shown_name)
							: $shown_name);
			$file_size	= $this->binary_multiples($file['file_size'], false, true, true);
			$file_ext	= $file['file_ext'];

			$link		= $this->link($path2 . $file_name, '', $text, '', $track);

			if ($picture && ($file['picture_w'] || $file['file_ext'] == 'svg'))
			{
				// XXX: now done in link funtion
				#$link		= '<a href="' . $url . '">' . $link . '</a>';
			}

			if (!in_array($file_ext, ['gif', 'jpeg', 'jpe', 'jpg', 'png', 'svg', 'webp']))
			{
				$hits	= $file['hits'] . ' ' . $this->_t('SettingsHits');
			}
			else
			{
				$hits	= '';
			}

			if ($this->is_admin()
				|| (!isset($is_global)
					&& $this->get_page_owner_id($page_id) == $this->get_user_id())
				|| $file['user_id'] == $this->get_user_id())
			{
				$operation_mode = 1;
			}
			else
			{
				$operation_mode = 0;
			}

			$href_info		= $this->href('filemeta', $page, ['m' => 'show', 'file_id' => $file_id]);
			$href_edit		= $this->href('filemeta', $page, ['m' => 'edit', 'file_id' => $file_id]);
			$href_remove	= $this->href('filemeta', $page, ['m' => 'remove', 'file_id' => $file_id]);

			// display file
			echo '<tr>' . "\n" .
					'<td class="file-">' . $link . '</td>' . "\n";

			if ($picture)
			{
				// get context for filter
				$method_filter	= $this->method == 'show' ? '' : $this->method;
				$param_filter	= (isset($_GET['files']) && in_array($_GET['files'], ['all', 'global'])) ? ['files' => $_GET['files']] : [];

				// display picture meta data
				echo '<td class="desc-">' .
					'<strong>' . $this->shorten_string($file['file_name'], $file_name_maxlen) . '</strong><br><br>' .
					$desc . '<br><br>' .

					($file['picture_w']
						? $file['picture_w'] . ' &times; ' . $file['picture_h'] . 'px<br>'
						: $hits . '<br>'
					) .

					$file_size . '<br><br>' .
					$this->user_link($file['user_name'], '', true, false) . '<br>' .
					$dt . '<br><br>' .
					$this->get_categories($file['file_id'], OBJECT_FILE, $method_filter, '', $param_filter) .

					'</td>' . "\n";
			}
			else
			{
				// display file meta data
				echo '<td class="desc-">' . $desc . '</td>' .
					'<td class="size-">
						<span class="size2-">' . $file_size . ', ' . $hits . '</span>&nbsp;'.
					'</td>' . "\n" .
					'<td class="dt-">' .
						'<span class="dt2-">' . $dt . '</span>&nbsp;'.
					'</td>' . "\n";
			}

			// display file tools
			echo '<td class="tool-">' .
					'<span class="dt2-">' .
						'<a href="' . $href_info . '" class="tool2-">' . $info_icon . '</a>' .
						($operation_mode
							? '<a href="' . $href_edit . '" class="tool2-">' . $edit_icon . '</a>' .
							  '<a href="' . $href_remove . '" class="tool2-">' . $del_icon . '</a>'
							: '') .
					'</span>' .
				 '</td>' . "\n";

			echo '</tr>' . "\n";

			unset($link);
			unset($desc);
		}

		echo '</table>' . "\n";
	}
	else
	{
		echo '<em>' . $this->_t('NoAttachments') . '</em><br><br>';
	}

	unset($files);

	if (!$nomark)
	{
		echo "</div>\n";
	}

	$this->print_pagination($pagination);
}
else
{
	echo '<em>' . $this->_t('ActionDenied') . '</em>';
}
