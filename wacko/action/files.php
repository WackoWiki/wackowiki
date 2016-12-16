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
// - add option to select all files: all=1 (?)
// - add option to filter by tags

$page_id = '';

if (!isset($nomark))	$nomark = '';
if (!isset($order))		$order = '';
if (!isset($global))	$global = '';
if (!isset($all))		$all = '';
if (!isset($tag))		$tag = ''; // FIXME: $tag == $page
if (!isset($owner))		$owner = '';
if (!isset($page))		$page = '';
if (!isset($ppage))		$ppage = '';
if (!isset($legend))	$legend = '';
if (!isset($method))	$method = ''; // for use in page handler
if (!isset($params))	$params = null; //for $_GET parameters to be passed with the page link
if (!isset($deleted))	$deleted = 0;
if (!isset($track))		$track = 0;
if (!isset($picture))	$picture = null;
if (!isset($max))		$max = null;

$order_by			= "file_name ASC";
$file_name_maxlen	= 80;

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

	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE ".
			($all
				? "f.page_id IS NOT NULL "
				: "f.page_id = '" . ($global ? 0 : $filepage['page_id']) . "' "
				) . " " .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '') .
			($deleted != 1
				? "AND f.deleted <> '1' "
				: ""), true);

	$pagination = $this->pagination($count['n'], $max, 'f', $params, $method);

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, f.hits, p.tag, u.user_name " .
		"FROM " . $this->db->table_prefix . "file f " .
			"LEFT JOIN  " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE ".
			($all
				? "f.page_id IS NOT NULL "
				: "f.page_id = '" . ($global ? 0 : $filepage['page_id']) . "' "
				) . " " .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '') . " " .
			($deleted != 1
			? "AND f.deleted <> '1' "
					: "") .
		"ORDER BY f." . $order_by . " " .
		$pagination['limit']);

	if (!is_array($files))
	{
		$files = [];
	}

	// display
	$info_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('UploadView') . '" alt="' . $this->_t('UploadView') . '" class="btn-info"/>';
	$edit_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('UploadEdit') . '" alt="' . $this->_t('UploadEdit') . '" class="btn-edit"/>';
	$del_icon	= '<img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('UploadRemove') . '" alt="' . $this->_t('UploadRemove') . '" class="btn-delete"/>';

	// use absolute path
	if (!$global)
	{
		$path2 = 'file:/' . ($this->slim_url($page)) . '/';
	}
	else
	{
		$path2 = 'file:/';
	}

	// !!!!! patch link to not show pictures when not needed
	if ($picture == false)
	{
		$path2 = str_replace('file:/', '_file:/', $path2);
		$style = 'upload';
	}
	else
	{
		$style = 'upload tbl_fixed';
	}

	$this->print_pagination($pagination);

	$results = count($files);

	if (!$nomark)
	{
		$title = $this->_t('UploadTitle'.($global ? 'Global' : '') ) . ' ' . ($page ? $this->link($ppage, '', $legend) : '');
		echo '<div class="layout-box"><p class="layout-box"><span>' . $results . ' of ' . '' . $count['n'] . ' ' . $title . ": </span></p>\n";
	}

	if ($results)
	{
		echo '<table class="' . $style . '" >';

		foreach ($files as $file)
		{
			// path hack for $all parameter, to refactor!
			if ($all)
			{
				// use absolute path
				if ($file['page_id'])
				{
					$path2	= 'file:/' . ($this->slim_url($file['tag'])) . '/';
					$page	= $file['tag'];
				}
				else
				{
					$path2	= 'file:/';
				}
			}

			$this->files_cache[$file['page_id']][$file['file_name']] = $file;

			$dt			= $file['uploaded_dt'];
			$desc		= $this->format($file['file_description'], 'typografica' );

			if ($this->page['page_lang'] != $file['file_lang'])
			{
				$desc	= $this->do_unicode_entities($desc, $file['file_lang']);
			}

			if ($desc == '')
			{
				$desc = "&nbsp;";
			}

			$file_id	= $file['file_id'];
			$file_name	= $file['file_name'];
			$shown_name = $this->shorten_string($file_name, $file_name_maxlen);
			$text		= ($picture == false
							? $shown_name
							: ($file['picture_w'] || $file['file_ext'] == 'svg'
								? ''
								: $shown_name));
			$file_size	= $this->binary_multiples($file['file_size'], false, true, true);
			$file_ext	= $file['file_ext'];
			$link		= $this->link($path2 . $file_name, '', $text, '', $track);

			if ($file_ext != 'gif' && $file_ext != 'jpg' && $file_ext != 'png'&& $file_ext != 'svg')
			{
				$hits	= ', ' . $file['hits'] . ' ' . $this->_t('SettingsHits');
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

			$href_info		= $this->href('attachments', $page, 'show' . "&amp;file_id=" . $file_id);
			$href_edit		= $this->href('attachments', $page, 'edit' . "&amp;file_id=" . $file_id);
			$href_remove	= $this->href('attachments', $page, 'remove' . "&amp;file_id=" . $file_id);

			echo '<tr>' .
					'<td class="file-">' . $link . '</td>';

			if ($picture == false)
			{
				echo '<td class="desc-">' . $desc . '</td>' .
					'<td class="size-">
						<span class="size2-">' . $file_size . $hits . '</span>&nbsp;'.
					'</td>' .
					'<td class="dt-">' .
						'<span class="dt2-">' . $this->get_time_formatted($dt) . '</span>&nbsp;'.
					'</td>';
			}
			else
			{
				echo '<td class="desc-">' .
					'<strong>' . $this->shorten_string($file['file_name'], $file_name_maxlen) . '</strong><br /><br />' .
					$desc . '<br /><br />' .

					($file['picture_w']
						? $file['picture_w'] . ' � ' . $file['picture_h'] . 'px<br />'
						: $hits . '<br />'
					) .

					$file_size . '<br /><br />' .
					$this->user_link($file['user_name'], '', true, false) . '<br />' .
					$this->get_time_formatted($dt) .
				'</td>';
			}


				echo '<td class="tool-">' .
						'<span class="dt2-">' .
							'<a href="' . $href_info . '" class="tool2-">' . $info_icon . '</a>' .
							($operation_mode
							? '<a href="' . $href_edit . '" class="tool2-">' . $edit_icon . '</a>' .
							  '<a href="' . $href_remove . '" class="tool2-">' . $del_icon . '</a>'
							: '') .
						'</span>' .
					 '</td>' . "\n";

	?>


		</tr>
	<?php
			unset($link);
			unset($desc);
		}

			echo '</table>';
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
