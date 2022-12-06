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
		[media=1]
		[max=number]
	}}
*/

// TODO:
// - add option to filter by facets

$page_id	= '';
$ppage		= '';
$files		= [];
$object_ids	= [];

if (!isset($nomark))	$nomark		= 0;
if (!isset($form))		$form		= 0;	// show search form
if (!isset($order))		$order		= '';
if (!isset($cluster))	$cluster	= 0;	// cluster attachments
if (!isset($global))	$global		= 0;	// global attachments
if (!isset($all))		$all		= 0;	// all attachments
if (!isset($linked))	$linked		= '';	// file link in page
if (!isset($owner))		$owner		= '';
if (!isset($page))		$page		= '';
if (!isset($legend))	$legend		= '';
if (!isset($method))	$method		= '';	// for use in page handler
if (!isset($params))	$params		= null;	// for $_GET parameters to be passed with the page link
if (!isset($deleted))	$deleted	= 0;
if (!isset($track))		$track		= 0;
if (!isset($media))		$media		= ($picture ?? null); // replaces depreciated picture with media
if (!isset($max))		$max		= null;
if (!isset($type_id))	$type_id	= null;

$file_name_maxlen	= 80;

// filter categories
$phrase				= (string)	($_GET['phrase'] ?? '');
$type_id			= (int)		($_GET['type_id'] ?? $type_id);
$category_id		= (int)		@$_GET['category_id'];
$filter				= $_GET['files'] ?? null;
$file_link			= (int)		$linked;

							$order_by = "file_name ASC";
if ($order == 'ext')		$order_by = "file_ext ASC";
if ($order == 'name_desc')	$order_by = "file_name DESC";
if ($order == 'size')		$order_by = "file_size ASC";
if ($order == 'size_desc')	$order_by = "file_size DESC";
if ($order == 'time')		$order_by = "uploaded_dt DESC";

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
		$tag		= $this->tag;
		$page_id	= $this->page['page_id'];
	}
	else
	{
		$tag		= $this->unwrap_link($page);
		$ppage		= '/' . $tag;

		if ($_page_id = $this->get_page_id($tag))
		{
			$page_id	= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
}
else
{
	$can_view	= 1;
	$tag		= $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $this->tag))
	{
		$filepage = $this->page;
	}
	else
	{
		$filepage = $this->load_page($tag, 0, '', LOAD_CACHE, LOAD_META);
	}

	if (!$global && !isset($filepage['page_id']))
	{
		return;
	}

	$selector =
		($category_id
			? "INNER JOIN " . $this->prefix . "category_assignment AS k ON (k.object_id = f.file_id) "
			: "") . " " .
		($file_link
			? "INNER JOIN " . $this->prefix . "file_link AS l ON (f.file_id = l.file_id) "
			: "") . " " .
			"WHERE ".
		($all || $file_link
			? "f.page_id IS NOT NULL "
			: ($cluster
				? "p.tag LIKE " . $this->db->q($tag . '/%') . " "
				: "f.page_id = " . ($global ? 0 : (int) $filepage['page_id']) . " "
				)
			) . " " .
		($phrase
			? "AND (f.file_name LIKE " . $this->db->q('%' . $phrase . '%') . " " .
				"OR f.file_description LIKE " . $this->db->q('%' . $phrase . '%') . " " .
				"OR f.caption LIKE " . $this->db->q('%' . $phrase . '%') . ") "
			: '') .
		($owner
			? "AND u.user_name = " . $this->db->q($owner) . " "
			: '') .
		($deleted != 1
			? "AND f.deleted <> 1 "
			: "");

	if ($category_id)
	{
		$selector .= "AND k.category_id IN ( " . (int) $category_id . " ) " .
					 "AND k.object_type_id = " . OBJECT_FILE . " ";
	}

	if ($file_link)
	{
		$selector .= "AND l.page_id = " . (int) $filepage['page_id'] . " ";
	}

	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		"FROM " . $this->prefix . "file f " .
			"LEFT JOIN  " . $this->prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $this->prefix . "user u ON (f.user_id = u.user_id) " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $max, 'f', $params, $method);

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, p.owner_id, p.tag, u.user_name " .
		"FROM " . $this->prefix . "file f " .
			"LEFT JOIN  " . $this->prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $this->prefix . "user u ON (f.user_id = u.user_id) " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		$pagination['limit']);

	$page_ids			= [];

	foreach ($files as $file)
	{
		if ($file['page_id'])
		{
			$page_ids[]							= $file['page_id'];
			$this->page_id_cache[$file['tag']]	= $file['page_id'];
		}

		$this->cache_page($file, true);

		$object_ids[]												= $file['file_id'];
		$this->file_cache[$file['page_id']][$file['file_name']]		= $file;
	}

	$this->preload_categories($object_ids, OBJECT_FILE);
	$this->preload_acl($page_ids);

	if ($media)
	{
		$path1 = 'file:/';
		$style = 'file tbl-fixed';
	}
	else
	{
		// !!!!! patch link to not show pictures when not needed
		$path1 = '_file:/';
		$style = 'file';
	}

	$tpl->pagination_text = $pagination['text'];

	$results = count($files);

	if (($results || $phrase) && $form)
	{
		// search
		$files_filter		= (isset($filter) && in_array($filter, ['all', 'local', 'cluster', 'global', 'linked'])) ? $filter : '';

		$tpl->s_filter		= $files_filter;
		$tpl->s_phrase		= Ut::html($phrase);
	}

	if (!$nomark)
	{
		$tpl->mark			= true;
		$tpl->emark			= true;
		$title				= $this->_t('UploadTitle' . ($global ? 'Global' : '') ) . ' ' . ($page ? $this->link($ppage, '', $legend) : '');
		$tpl->mark_results	= $results . ' of ' . $count['n'] . ' ' . $title;
	}

	if ($results)
	{
		// get context for filter
		$method_filter		= $this->method == 'show' ? '' : $this->method;
		$param_filter		= (isset($filter) && in_array($filter, ['all', 'local', 'cluster', 'global', 'linked'])) ? ['files' => $filter] : [];

		$tpl->enter('r_');
		$tpl->style = $style;

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
				$path2	= $path1 . ($file['tag']) . '/';
				$page	= $file['tag'];
			}
			else
			{
				// global file
				$path2	= $path1;
			}

			$dt			= $this->sql_time_formatted($file['uploaded_dt']);
			$desc		= $this->format($file['file_description'], 'typografica', ['lang' => $file['file_lang']]);

			if ($desc == '')
			{
				$desc = NBSP;
			}

			$file_id	= $file['file_id'];
			$file_name	= $file['file_name'];
			$shown_name	= $this->shorten_string($file_name, $file_name_maxlen);
			$text		= ($media
							? ($file['picture_w'] || in_array($file['file_ext'], ['m4a', 'mp3', 'ogg', 'opus', 'avif', 'gif', 'jpg', 'jpe', 'jpeg', 'png', 'svg', 'webp', 'mp4', 'ogv', 'webm'])
								? ''					// parses image, audio and video links into their media tags
								: $shown_name)			// shows file link
							: $shown_name);
			$file_size	= $this->binary_multiples($file['file_size'], false, true, true);

			$link		= $this->link($path2 . $file_name, '', $text, '', $track);

			$tpl->enter('n_');

			// display file
			$tpl->link = $link;

			if ($media)
			{
				// display picture meta data
				#$tpl->p_file		= $file; // result array: [ ' file.file_id ' ]
				$tpl->p_name		= $this->shorten_string($file['file_name'], $file_name_maxlen);
				$tpl->p_desc		= $desc;
				$tpl->p_meta		= ($file['picture_w']
										? number_format($file['picture_w'], 0, ',', '.') . ' × ' . number_format($file['picture_h'], 0, ',', '.') . ' px'
										: '');
				$tpl->p_size		= $file_size;
				$tpl->p_user		= $this->user_link($file['user_name'], true, false);
				$tpl->p_dt			= $dt;
				$tpl->p_categories	= $this->get_categories($file['file_id'], OBJECT_FILE, $method_filter, '', $param_filter);
			}
			else
			{
				// display file meta data
				$tpl->g_desc		= $desc;
				$tpl->g_meta		= $file_size;
				$tpl->g_dt			= $dt;
			}

			// icons ['handler' => ['title, class]]
			$icons['show']		= ['FileViewProperties', 'info'];

			// display file tools
			if ($this->is_admin()
				|| (!isset($is_global)
					&& $this->get_page_owner_id($page_id) == $this->get_user_id())
				|| $file['user_id'] == $this->get_user_id())
			{
				$icons['edit']		= ['FileEditProperties', 'edit'];
				$icons['remove']	= ['FileRemove', 'delete'];
			}

			foreach ($icons as $handler => $icon)
			{
				$tpl->i_info		= $this->href('filemeta', $page, ['m' => $handler, 'file_id' => $file_id]);
				$tpl->i_title		= $this->_t($icon[0]);
				$tpl->i_class		= $icon[1];
			}

			$tpl->leave(); // n_

			unset($link, $desc);
		}

		$tpl->leave(); // r_
	}
	else
	{
		$tpl->message = '<em>' . $this->_t('NoAttachments') . '</em><br>';
	}

	unset($files);
}
else
{
	$tpl->message = '<em>' . $this->_t('ActionDenied') . '</em>';
}
