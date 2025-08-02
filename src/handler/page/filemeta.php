<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* TODO:
 - move all non GUI code in attachment and upload class
 - thumbnails
 */

// LOCAL FUNCTIONS

$get_file = function ($file_id)
{
	return $this->db->load_single(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_lang, f.file_size, f.file_description, f.caption, f.author, f.source, f.source_url, f.license_id, f.uploaded_dt, f.modified_dt, f.picture_w, f.picture_h, f.file_ext, f.mime_type, u.user_name, p.tag, p.title " .
		"FROM " . $this->prefix . "file f " .
			"INNER JOIN " . $this->prefix . "user u ON (f.user_id = u.user_id) " .
			"LEFT JOIN " . $this->prefix . "page p ON (f.page_id = p.page_id) " .
		"WHERE f.file_id = " . (int) $file_id . " " .
		"LIMIT 1", true);
};

$file_access = function ($file)
{
	return
		$this->is_admin()
		|| ($file['page_id']
			&& ($this->page['owner_id'] == $this->get_user_id()))
		|| ($file['user_id'] == $this->get_user_id());
};

$meta_navigation = function ($can_upload)
{
	return '<ul class="menu">' .
			(( $this->db->attachments_handler == 2 && $this->get_user())
			|| $this->db->attachments_handler == 1
				? '<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('Attachments') . '</a></li>'
				: '') .
			($can_upload
				? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
				: '') .
		 "</ul>\n";
};

$format_desc = function($text, $lang)
{
	return $this->format($text, 'typografica', ['lang' => $lang]);
};

$clean_text = function ($string)
{
	$string = utf8_rtrim($string, '\\');

	// Make HTML in the description redundant
	$string = $this->format($string, 'pre_wacko');
	$string = $this->format($string, 'safehtml'); //

	return $string;
};

// END FUNCTIONS

$this->ensure_page(true);

$action			= $_POST['_action'] ?? null;
$can_upload		= $this->can_upload();
$file_id		= (int) ($_POST['file_id'] ?? @$_GET['file_id']);
$file			= $get_file($file_id);

$mod_selector	= 'm';
// tab navigation
$tabs['show']	= 'FileViewProperties';

if (!empty($file) && $file_access($file))
{
	$tabs['edit']	= 'FileEditProperties';
	$tabs['label']	= 'FileLabel';
	$tabs['remove']	= 'FileRemove';
}

# Ut::debug_print_r($tabs);

$mode	= $_GET[$mod_selector] ?? null;

if (!array_key_exists($mode, $tabs))
{
	$mode = 'show';
}

// print tabs
$tpl->navigation	= $meta_navigation($can_upload);
$tpl->mode			= $this->_t($tabs[$mode]);
$tpl->tabs			= $this->tab_menu($tabs, $mode, 'filemeta', ['file_id' => ($file['file_id'] ?? null)], $mod_selector);

// 1. PROCESS POSTS
if ($action && !empty($file))
{
	if ($action == 'edit_file')
	{
		// 1.a UPDATE FILE PROPERTIES

		if ($file_access($file))
		{
			$description	= mb_substr($_POST['file_description'], 0, 250);
			$description	= $this->sanitize_text_field((string) $description, true);
			$caption		= $clean_text((string) $_POST['caption']);
			$author			= $this->sanitize_text_field(mb_substr($_POST['author'], 0, 250), true);
			$source			= $this->sanitize_text_field(mb_substr($_POST['source'], 0, 250), true);
			$source_url		= filter_var($_POST['source_url'], FILTER_VALIDATE_URL);
			$license_id		= (int) ($_POST['license'] ?? 0);
			$file_lang		= $this->validate_language($_POST['file_lang'] ?? $file['file_lang']);

			// update file metadata
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'file SET ' .
					'file_lang			= ' . $this->db->q($file_lang) . ', ' .
					'file_description	= ' . $this->db->q($description) . ', ' .
					'caption			= ' . $this->db->q($caption) . ', ' .
					'author				= ' . $this->db->q($author) . ', ' .
					'source				= ' . $this->db->q($source) . ', ' .
					'source_url			= ' . $this->db->q($source_url) . ', ' .
					'license_id			= ' . (int) $license_id . ', ' .
					'modified			= UTC_TIMESTAMP() ' .
				'WHERE file_id = ' . (int) $file['file_id'] . ' ' .
				'LIMIT 1');

			$this->set_message($this->_t('FileEditedMeta'), 'success');

			$this->log(4, Ut::perc_replace(
				$this->_t('LogUpdatedFileMeta', SYSTEM_LANG),
				$this->tag . ' ' . $this->page['title'],
				$file['file_name']));
			$this->db->invalidate_sql_cache();

			$this->http->redirect($this->href('filemeta', '', ['m' => 'show', 'file_id' => (int) $file['file_id']]));
		}
		else
		{
			$this->set_message($this->_t('FileEditDenied'));
		}
	}
	else if ($action == 'assign_categories')
	{
		// 1.b UPDATE FILE CATEGORIES ASSIGNMENTS

		// clear old list
		$this->remove_category_assignments($file['file_id'], OBJECT_FILE);

		// save new list
		$this->save_categories_list($file['file_id'], OBJECT_FILE);

		$this->log(4, Ut::perc_replace(
			$this->_t('LogUpdatedFileCategories', SYSTEM_LANG),
			$this->tag . ' ' . $this->page['title'],
			$file['file_name']));
		$this->set_message($this->_t('CategoriesUpdated'), 'success');

		$this->http->redirect($this->href('filemeta', '', ['m' => 'label', 'file_id' => (int) $file['file_id']]));
	}
	else if ($action == 'remove_file')
	{
		// 1.c DELETE FILE
		$dontkeep	= (isset($_POST['dontkeep']) && $this->is_admin());

		if ($file_access($file))
		{
			$this->remove_file($file['file_id'], $dontkeep);

			$this->log(1, Ut::perc_replace(
				$this->_t('LogRemovedFile', SYSTEM_LANG),
				$this->tag . ' ' . $this->page['title'],
				$file['file_name']));

			$this->db->invalidate_sql_cache(); // TODO: purge related page cache

			$this->http->redirect($this->href('attachments'));
		}
		else
		{
			$this->set_message($this->_t('FileRemoveDenied'));
		}
	}
}
// 2. SHOW FORMS
else if ($mode && !empty($file))
{
	// get path
	if ($file['page_id'])
	{
		$path	= 'file:/' . $file['tag'] . '/';
		$href	= $this->href('file', utf8_trim($file['tag'], '/'), 'get=' . $file['file_name']);
	}
	else
	{
		$path	= 'file:/';
		$href	= $this->db->base_path . Ut::join_path(UPLOAD_GLOBAL_DIR, $file['file_name']);
	}

	$file_tag = $path . $file['file_name'];

	if ($mode == 'show')
	{
		// 2.a SHOW FILE PROPERTIES
		$tpl->enter('s_');

		if ($this->has_access('read', $file['page_id']))
		{
			$tpl->link			= $this->link($file_tag, '', Ut::shorten_string($file['file_name']));

			// show image
			if (in_array($file['file_ext'], array_merge(self::EXT['bitmap'], self::EXT['drawing'])))
			{
				$tpl->i_href		= $href;
				$tpl->i_image		= $this->link($file_tag, '', '', '', null, null, null, false);
			}
			// show audio & video
			else if (in_array($file['file_ext'], array_merge(self::EXT['audio'], self::EXT['video'])))
			{
				$tpl->m_image		= $this->link($file_tag, '', '', '', null, null, null, false);
			}

			if ($file['page_id'])
			{
				// relative path
				$tpl->s_syntax		= 'file:' . $file['file_name'];
				// absolute path (<details>)
				$tpl->s_d_syntax	= $file_tag;
			}
			else
			{
				// absolute path
				$tpl->s_syntax		= $file_tag;
			}

			$tpl->desc			= $format_desc($file['file_description'], $file['file_lang']);
			$tpl->caption		= $format_desc($file['caption'], $file['file_lang']);
			$tpl->size			= $this->binary_multiples($file['file_size'], false, true, true);

			// image dimension
			if ($file['picture_w'])
			{
				$tpl->p_width	= $file['picture_w'];
				$tpl->p_height	= $file['picture_h'];
			}

			$tpl->mime			= $file['mime_type'];
			$tpl->user			= $this->user_link($file['user_name'], true, false);
			$tpl->created		= $this->sql_time_formatted($file['uploaded_dt']);

			if ($file['license_id'])
			{
				$tpl->l_license	= $this->action('license', ['license_id' => $file['license_id'], 'icon' => 1, 'intro' => 0]);
			}

			// file author
			if ($file['author'] || $file['source'])
			{
				$tpl->enter('a_');

				$tpl->author		= $file['author'];
				$tpl->source		= $file['source'];

				if ($file['source_url'] && $file['source'])
				{
					$tpl->url_href		= $file['source_url'];
					$tpl->chref			= true;
				}

				$tpl->leave();
			}

			$tpl->location		= $file['tag']
									? $this->link('/' . $file['tag'], '', $file['title'], $file['tag'])
									: $this->_t('UploadGlobal');
			$tpl->fileusage		= $this->action('filelinks', ['file_id' => $file['file_id'], 'nomark' => 1, 'params' => ['file_id' => $file['file_id'], 'm' => 'show']]);
			$tpl->c_categories	= $this->get_categories($file['file_id'], OBJECT_FILE, 'attachments', '', ['files' => 'all']);
		}

		$tpl->leave(); // s_
	}
	else if ($mode == 'edit')
	{
		// 2.b EDIT FILE PROPERTIES
		$tpl->enter('e_');

		if ($file_access($file))
		{
			$tpl->link		= $this->link($file_tag, '', Ut::shorten_string($file['file_name'])) . '</h4>';
			$tpl->desc		= $file['file_description'];
			$tpl->caption	= Ut::html($file['caption']); // -> [ ' caption | pre ' ]

			$file_license	= $file['license_id'] ?? 0;
			$tpl->license	= $this->show_select_license('file_license', $file_license, false);

			$tpl->author	= $file['author'];
			$tpl->source	= $file['source'];
			$tpl->url		= $file['source_url'];

			$file_lang		= $file['file_lang'] ?: $this->db->language;
			$tpl->lang		= $this->show_select_lang('file_lang', $file_lang, false);

			$tpl->fileid	= $file['file_id'];
		}
		else
		{
			$this->set_message($this->_t('FileEditDenied'));
		}

		$tpl->leave(); // e_
	}
	else if ($mode == 'label')
	{
		// 2.c LABEL FILE
		$tpl->enter('l_');

		if ($file_access($file))
		{
			$tpl->link		= $this->link($file_tag, '', Ut::shorten_string($file['file_name']));
			$tpl->category	= $this->show_category_form($file['file_lang'], $file['file_id'], OBJECT_FILE, false);
			$tpl->fileid	= $file['file_id'];
		}

		$tpl->leave(); // l_
	}
	else if ($mode == 'remove')
	{
		// 2.d REMOVE FILE CONFIRMATION
		$tpl->enter('r_');

		if ($file_access($file))
		{
			$tpl->link		= $this->link($file_tag, '', Ut::shorten_string($file['file_name']));
			$tpl->file		= $file; // array -> [ ' file.field ' ]
			$tpl->size		= $this->binary_multiples($file['file_size'], false, true, true);
			$tpl->user		= $this->user_link($file['user_name'], true, false);

			$tpl->location	= $file['tag']
								? $this->link('/' . $file['tag'], '', $file['title'], $file['tag'])
								: $this->_t('UploadGlobal');
			$tpl->fileusage	= $this->action('filelinks', ['file_id' => $file['file_id'], 'nomark' => 1]);
			$tpl->notice	= $this->show_message($this->_t('FileRemoveConfirm'), 'warning', false);

			if ($this->db->store_deleted_pages && $this->is_admin())
			{
				$tpl->dontkeep = true;
			}
		}
		else
		{
			$this->set_message($this->_t('FileRemoveDenied'), 'error');
		}

		$tpl->leave(); // r_

		return true;
	}
}
else
{
	$this->set_message($this->_t('FileNotFound'));

	// 3. show attachments for current page
	if ($this->has_access('read')
		&& ((	$this->db->attachments_handler == 2 && $this->get_user())
			||	$this->db->attachments_handler == 1))
	{
		$this->http->redirect($this->href('attachments'));
	}
}
