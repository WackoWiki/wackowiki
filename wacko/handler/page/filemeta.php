<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* TODO:
 - show for local files relative and absolute syntax (?)
 - move all non GUI code in attachment and upload class
 - thumbnails
 */

$get_file = function ($file_id)
{
	return $this->db->load_single(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_lang, f.file_size, f.file_description, f.caption, f.author, f.source, f.source_url, f.license_id, f.uploaded_dt, f.modified_dt, f.picture_w, f.picture_h, f.file_ext, f.mime_type, u.user_name, p.tag, p.title " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
		"WHERE f.file_id = " . (int) $file_id . " " .
		"LIMIT 1", true);
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

$format_desc = function($text)
{
	return $this->format($text, 'typografica');
};

$clean_text = function ($string)
{
	$string = utf8_rtrim($string, '\\');

	// Make HTML in the description redundant
	$string = $this->format($string, 'pre_wacko');
	#$string = $this->format($string, 'wacko'); //
	$string = $this->format($string, 'safehtml'); //
	#$string = Ut::html($string, true); // breaks html unicode chars

	return $string;
};

$message		= '';
$error			= '';
$can_upload		= $this->can_upload();

$this->ensure_page(true); // TODO: upload for forums?

$file = $get_file((int) @$_GET['file_id']);

$mod_selector	= 'm';
// tab navigation
$tabs['show']	= 'FileViewProperties';

if ($this->is_admin()
	|| (isset($file['page_id']) && $file['page_id']
		&& $this->page['owner_id'] == $this->get_user_id())
	|| (isset($file['user_id']) && $file['user_id'] == $this->get_user_id()))
{
	$tabs['edit']	= 'FileEditProperties';
	$tabs['label']	= 'FileLabel';
	$tabs['remove']	= 'FileRemove';
}

#Ut::debug_print_r($tabs);

$mode	= @$_GET[$mod_selector];

if (!array_key_exists($mode, $tabs))
{
	$mode = 'show';
}

// print tabs
$tpl->navigation	= $meta_navigation($can_upload);
$tpl->mode			= $this->_t($tabs[$mode]);
$tpl->tabs			= $this->tab_menu($tabs, $mode, 'filemeta', ['file_id' => ($file['file_id'] ?? null)], $mod_selector);

// 1. SHOW FORMS
if ($mode == 'remove' && isset($file))
{
	// 1.a REMOVE FILE CONFIRMATION
	$tpl->enter('r_');

	if (count($file) > 0)
	{
		if ($this->is_admin()
			|| ($file['page_id']
				&& ($this->page['owner_id'] == $this->get_user_id()))
			|| ($file['user_id'] == $this->get_user_id()))
		{
			if ($file['page_id'])
			{
				$path = 'file:/' . $file['tag'] . '/';
			}
			else
			{
				$path = 'file:/';
			}

			$tpl->link		= $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name']));
			$tpl->file		= $file; // array -> [ ' file.field ' ]
			$tpl->size		= $this->binary_multiples($file['file_size'], false, true, true);
			$tpl->user		= $this->user_link($file['user_name'], true, false);

			$tpl->location	= $file['tag']? $this->link('/' . $file['tag'], '', $file['title'], $file['tag']) : $this->_t('UploadGlobal');
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
	}
	else
	{
		#$this->show_message($this->_t('FileNotFound'));
	}

	$tpl->leave();

	return true;
}
else if ($mode == 'label' && isset($file))
{
	// 1.b LABEL FILE
	$tpl->enter('l_');

	if (count($file) > 0)
	{
		if ($this->is_admin()
			|| ($file['page_id']
				&& ($this->page['owner_id'] == $this->get_user_id()))
			|| ($file['user_id'] == $this->get_user_id()))
		{
			if ($file['page_id'])
			{
				$path = 'file:/' . $file['tag'] . '/';
			}
			else
			{
				$path = 'file:/';
			}

			// !!!!! patch link to not show pictures when not needed
			$path2 = str_replace('file:/', '_file:/', $path);

			$tpl->link		= $this->link($path2 . $file['file_name'], '', $this->shorten_string($file['file_name']));
			$tpl->category	= $this->show_category_form($file['file_id'], OBJECT_FILE, $file['file_lang'], false);
			$tpl->fileid	= $file['file_id'];
		}
	}
	else
	{
		#$this->show_message($this->_t('FileNotFound'));
	}

	$tpl->leave();
}
else if (($mode == 'edit' || $mode == 'show') && isset($file))
{
	if (count($file) > 0)
	{
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

		if ($mode == 'show')
		{
			// 1.c SHOW FILE PROPERTIES
			$tpl->enter('s_');

			if ($this->has_access('read', $file['page_id']))
			{
				$tpl->link			= $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name']));

				// show image
				if (in_array($file['file_ext'], ['gif', 'jpg', 'jpe', 'jpeg', 'png', 'svg', 'webp']))
				{
					$tpl->i_href		= $href;
					$tpl->i_image		= $this->link($path . $file['file_name'], '', '', '', '', '', '', false);
				}
				// show audio & video
				else if (in_array($file['file_ext'], ['mp4', 'ogv', 'webm', 'm4a' , 'mp3', 'ogg', 'opus']))
				{
					$tpl->m_image		= $this->link($path . $file['file_name'], '', '', '', '', '', '', false);
				}

				$tpl->syntax		= $path . $file['file_name'];
				$tpl->desc			= $format_desc($file['file_description']);
				$tpl->caption		= $format_desc($file['caption']);
				$tpl->size			= $this->binary_multiples($file['file_size'], false, true, true);

				// image dimension
				if ($file['picture_w'])
				{
					$tpl->p_width	= $file['picture_w'];
					$tpl->p_height	= $file['picture_h'];
				}

				$tpl->mime			= $file['mime_type'];
				$tpl->user			= $this->user_link($file['user_name'], true, false);
				$tpl->time			= $this->get_time_formatted($file['uploaded_dt']);

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

				$tpl->location		= $file['tag']? $this->link('/' . $file['tag'], '', $file['title'], $file['tag']) : $this->_t('UploadGlobal');
				$tpl->fileusage		= $this->action('filelinks', ['file_id' => $file['file_id'], 'nomark' => 1]);
				$tpl->c_categories	= $this->get_categories($file['file_id'], OBJECT_FILE, 'attachments', '', ['files' => 'all']);
			}

			$tpl->leave();
		}
		else if ($mode == 'edit')
		{
			// 1.d EDIT FILE PROPERTIES
			$tpl->enter('e_');

			if (   $this->is_admin()
				|| ($file['page_id']
					&& ($this->page['owner_id'] == $this->get_user_id()))
				|| ($file['user_id'] == $this->get_user_id()))
			{
				// !!!!! patch link to not show pictures when not needed
				$path2 = str_replace('file:/', '_file:/', $path);

				$tpl->link			= $this->link($path2 . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';
				$tpl->desc			= $file['file_description'];
				$tpl->caption		= Ut::html($file['caption']); // -> [ ' caption | pre ' ]

				$file_license	= $file['license_id'] ?? 0;
				$tpl->license	= $this->show_select_license('file_license', $file_license, false);

				$tpl->author	= $file['author'];
				$tpl->source	= $file['source'];
				$tpl->url		= $file['source_url'];

				$file_lang		= $file['file_lang'] ?: $this->db->language;
				$tpl->lang		= $this->show_select_lang('file_lang', $file_lang, false);

				$tpl->fileid	= (int) $_GET['file_id'];
			}
			else
			{
				$this->set_message($this->_t('FileEditDenied'));
			}
		}

			$tpl->leave();
	}
	else
	{
		$this->show_message($this->_t('FileNotFound'));
	}

	return true;
}
else
{
	// 2 PROCESS POSTS

	if (isset($_POST['remove']))
	{
		// 2.a DELETE FILE
		$dontkeep	= (isset($_POST['dontkeep']) && $this->is_admin());
		$file		= $get_file((int) $_POST['file_id']);

		if (count($file) > 0)
		{
			if ($this->is_admin()
				|| ($file['page_id']
					&& ($this->page['owner_id'] == $this->get_user_id()))
				|| ($file['user_id'] == $this->get_user_id()))
			{
				$this->remove_file($file['file_id'], $dontkeep);

				// log event
				$this->log(1, Ut::perc_replace($this->_t('LogRemovedFile', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));

				$this->db->invalidate_sql_cache(); // TODO: check if sql cache is enabled plus purge page cache
				$this->http->redirect($this->href('attachments'));
			}
			else
			{
				$this->set_message($this->_t('FileRemoveDenied'));
			}
		}
		else
		{
			$this->set_message($this->_t('FileRemoveNotFound'));
		}
	}
	else if (isset($_POST['label']))
	{
		// update Categories list for the current page

		$file = $get_file((int) $_POST['file_id']);
		// clear old list
		$this->remove_category_assigments($file['file_id'], OBJECT_FILE);

		// save new list
		$this->save_categories_list($file['file_id'], OBJECT_FILE);

		$this->log(4, Ut::perc_replace($this->_t('LogUpdatedFileCategories', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));
		$this->set_message($this->_t('CategoriesUpdated'), 'success');
		$this->http->redirect($this->href('filemeta', '', ['m' => 'label', 'file_id' => (int) $file['file_id']]));
	}
	else if (isset($_POST['edit']))
	{
		// 2.b UPDATE FILE PROPERTIES

		$file = $get_file((int) $_POST['file_id']);

		if (count($file) > 0)
		{
			if ($this->is_admin()
				|| ($file['page_id']
					&& ($this->page['owner_id'] == $this->get_user_id()))
				|| ($file['user_id'] == $this->get_user_id()))
			{
				$description	= mb_substr($_POST['file_description'], 0, 250);
				$description	= $this->sanitize_text_field((string) $description, true);
				$caption		= $clean_text((string) $_POST['caption']);
				$author			= $this->sanitize_text_field(mb_substr($_POST['author'], 0, 250), true);
				$source			= $this->sanitize_text_field(mb_substr($_POST['source'], 0, 250), true);
				$source_url		= filter_var($_POST['source_url'], FILTER_VALIDATE_URL);
				$license_id		= $_POST['license'] ?? 0;
				$file_lang		= $_POST['file_lang'] ?? $file['file_lang'];

				// update file metadata
				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "file SET " .
						"file_lang			= " . $this->db->q($file_lang) . ", " .
						"file_description	= " . $this->db->q($description) . ", " .
						"caption			= " . $this->db->q($caption) . ", " .
						"author				= " . $this->db->q($author) . ", " .
						"source				= " . $this->db->q($source) . ", " .
						"source_url			= " . $this->db->q($source_url) . ", " .
						"license_id			= " . (int) $license_id . ", " .
						"modified_dt		= UTC_TIMESTAMP() " .
					"WHERE file_id = " . (int) $file['file_id'] . " " .
					"LIMIT 1");

				$this->set_message($this->_t('FileEditedMeta'), 'success');

				// log event
				$this->log(4, Ut::perc_replace($this->_t('LogUpdatedFileMeta', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));
				$this->db->invalidate_sql_cache();
				$this->http->redirect($this->href('filemeta', '', ['m' => 'show', 'file_id' => (int) $file['file_id']]));
			}
			else
			{
				$this->set_message($this->_t('FileEditDenied'));
			}
		}
		else
		{
			$this->set_message($this->_t('FileNotFound'));
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
}
