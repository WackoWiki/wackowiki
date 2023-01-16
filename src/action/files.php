<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$load_mime = function ()
{
	return $this->db->load_all(
		"SELECT DISTINCT mime_type " .
		"FROM " . $this->prefix . "file", true);
};

$load_categories = function ()
{
	return $this->db->load_all(
		"SELECT category_id, category, category_lang " .
		"FROM " . $this->prefix . "category", true);
};

/*
	Showing uploaded by {{upload}} files

	{{files
		[page="PageName" or global=1 or all=1]
		[order="ext|name_desc|size|size_desc|time|time_desc"]
		[form=1]
		[options=1]
		[owner="UserName"]
		[media=1]
		[max=number]
	}}
*/

// TODO:
// - add option to filter by facets (user, language, category, type, type class, license)
// - add reset button

$file_name_maxlen	= 80;
$files		= [];
$object_ids	= [];
$page_id	= '';
$prefix		= $this->prefix;
$ppage		= '';

// set defaults
$all		??= 0;	// all attachments
$cluster	??= 0;	// cluster attachments
$deleted	??= false;
$dir		??= 'asc';
$form		??= 0;	// show search form
$global		??= 0;	// global attachments
$lang		??= '';
$legend		??= '';
$linked		??= '';	// file link in page
$max		??= null;
$media		??= null;
$method		??= '';	// for use in page handler
$mime		??= '';
$nomark		??= 0;
$options	??= 0;
$order		??= 'name';
$owner		??= '';
$page		??= '';
$params		??= null;	// for $_GET parameters to be passed with the page link
$track		??= 0;
$type_id	??= null;
$user_id	??= null;

// filter
$category_id	= (int)		@$_GET['category_id'];
$dir			= (string)	($_GET['dir']		?? $dir);
$filter			= $_GET['files'] ?? null;
$lang			= (string)	($_GET['lang']		?? $lang);
$media			= (int)		($_GET['media']		?? $media);
$mime			= (string)	($_GET['mime']		?? $mime);
$options		= (int)		($_GET['options']	?? $options);
$order			= (string)	($_GET['order']		?? $order);
$phrase			= (string)	($_GET['phrase']	?? '');
$type_id		= (int)		($_GET['type_id']	?? $type_id);
$user_id		= (int)		($_GET['user_id']	?? $user_id);

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	$this->set_message($this->_t('FilterLangNotAvailable'));
}

$sql_sort	= $order . ($dir == 'desc' ? '_' . $dir : '');


$file_link			= (int)		$linked;

$order_by = match($sql_sort) {
	'ext'			=> 'file_ext ASC',
	'ext_desc'		=> 'file_ext DESC',
	'name_desc'		=> 'file_name DESC',
	'size'			=> 'file_size ASC',
	'size_desc'		=> 'file_size DESC',
	'time'			=> 'created ASC',
	'time_desc'		=> 'created DESC',
	default			=> 'file_name ASC',
};

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
		$filepage = $this->load_page($tag, 0, null, LOAD_CACHE, LOAD_META);
	}

	if (!$global && !isset($filepage['page_id']))
	{
		return;
	}

	$selector =
		($category_id
			? "INNER JOIN " . $prefix . "category_assignment AS k ON (k.object_id = f.file_id) "
			: "") . " " .
		($file_link
			? "INNER JOIN " . $prefix . "file_link AS l ON (f.file_id = l.file_id) "
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
		($mime
			? "AND f.mime_type = " . $this->db->q($mime) . " "
			: '') .
		($user_id
			? "AND f.user_id = " . (int) $user_id . " "
			: '') .
		($lang
			? "AND f.file_lang = " . $this->db->q($lang) . " "
			: "") .
		($deleted
			? ""
			: "AND f.deleted <> 1 ");

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
		"FROM " . $prefix . "file f " .
			"LEFT JOIN  " . $prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $prefix . "user u ON (f.user_id = u.user_id) " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $max, 'f',
		  (!empty($params)			? $params								: [])
		+ (!empty($category_id)		? ['category_id'	=> $category_id]	: [])
		+ (!empty($dir)				? ['dir'			=> $dir]			: [])
		+ (!empty($lang)			? ['lang'			=> $lang]			: [])
		+ (!empty($mime)			? ['mime'			=> $mime]			: [])
		+ (!empty($order)			? ['order'			=> $order]			: [])
		+ (!empty($user_id)			? ['user_id'		=> $user_id]		: [])
		, $method);

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.created, p.owner_id, p.tag, u.user_name " .
		"FROM " . $prefix . "file f " .
			"LEFT JOIN  " . $prefix . "page p ON (f.page_id = p.page_id) " .
			"INNER JOIN " . $prefix . "user u ON (f.user_id = u.user_id) " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		$pagination['limit']);

	$page_ids = [];

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

		$tpl->enter('s_');
		$tpl->filter		= $files_filter;
		$tpl->href			= $this->href($this->method);
		$tpl->phrase		= Ut::html($phrase);

		// sort & filter
		if ($options)
		{
			$tpl->enter('options_');

			// SORT
			$orders = [
				'ext'	=> 'FileSortExt',
				'name'	=> 'FileSortName',
				'size'	=> 'FileSortSize',
				'time'	=> 'FileSortTime',
			];

			$dirs = [
				'asc'	=> 'Ascending',
				'desc'	=> 'Decending',
			];

			// select order column
			foreach ($orders as $value => $_order)
			{
				$tpl->l_o_value	= $value;
				$tpl->l_o_lang	= $this->_t($_order);

				if ($value == $order)
				{
					$tpl->l_o_selected	= ' selected';
				}
			}

			// select order direction
			foreach ($dirs as $value => $_dir)
			{
				$tpl->l_d_value	= $value;
				$tpl->l_d_lang	= $this->_t($_dir);

				if ($value == $dir)
				{
					$tpl->l_d_selected	= ' selected';
				}
			}

			// FILTER
			// language
			if ($this->db->multilanguage)
			{
				$langs		= $this->http->available_languages();
				$languages	= $this->_t('LanguageArray');

				foreach ($langs as $_lang)
				{
					$tpl->lang_o_lang	= $_lang;
					$tpl->lang_o_name	= $languages[$_lang];
					$tpl->lang_o_sel	= (int) ($lang == $_lang);
				}
			}

			// user
			if ($users = $this->load_users())
			{
				foreach ($users as $user)
				{
					$tpl->u_user	= $user;
					$tpl->u_sel		= (int) ($user_id == $user['user_id']);
				}
			}

			// MIME
			if ($mime_types = $load_mime())
			{
				foreach ($mime_types as $value)
				{
					$tpl->m_mime	= $value;
					$tpl->m_sel		= (int) ($mime == $value['mime_type']);
				}
			}

			// categories
			if ($categories = $load_categories())
			{
				foreach ($categories as $value)
				{
					$tpl->c_category	= $value;
					$tpl->c_sel			= (int) ($category_id == $value['category_id']);
				}
			}

			$tpl->leave(); // options_
		}

		$tpl->leave(); // s_
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

			$created	= $this->sql_time_formatted($file['created']);
			$desc		= $this->format($file['file_description'], 'typografica', ['lang' => $file['file_lang']]);

			if ($desc == '')
			{
				$desc = NBSP;
			}

			$file_id	= $file['file_id'];
			$file_name	= $file['file_name'];
			$shown_name	= Ut::shorten_string($file_name, $file_name_maxlen);
			$text		= ($media
							? ($file['picture_w'] || in_array($file['file_ext'], ['m4a', 'mp3', 'ogg', 'opus', 'avif', 'gif', 'jpg', 'jpe', 'jpeg', 'jxl', 'png', 'svg', 'webp', 'mp4', 'ogv', 'webm'])
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
				$tpl->p_name		= Ut::shorten_string($file['file_name'], $file_name_maxlen);
				$tpl->p_desc		= $desc;
				$tpl->p_meta		= ($file['picture_w']
										? number_format($file['picture_w'], 0, ',', '.') . ' × ' . number_format($file['picture_h'], 0, ',', '.') . ' px'
										: '');
				$tpl->p_size		= $file_size;
				$tpl->p_user		= $this->user_link($file['user_name'], true, false);
				$tpl->p_created		= $created;
				$tpl->p_categories	= $this->get_categories($file['file_id'], OBJECT_FILE, $method_filter, '', $param_filter);
			}
			else
			{
				// display file meta data
				$tpl->g_desc		= $desc;
				$tpl->g_meta		= $file_size;
				$tpl->g_created		= $created;
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
