<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO:
// - thumbnails


$clean_text = function ($string)
{
	$string = utf8_rtrim($string, '\\');

	// Make HTML in the description redundant
	$string = $this->format($string, 'pre_wacko');
	$string = $this->format($string, 'wacko');
	$string = $this->format($string, 'safehtml');

	return $string;
};

$can_upload		= $this->can_upload();
$error			= '';
$is_global		= '';
$is_image		= '';
$prefix			= $this->db->table_prefix;

$this->ensure_page(true); // TODO: upload for forums?

// check who u are, can u upload?
if (isset($_POST['upload']) & $can_upload)
{
	// PROCESS FILE UPLOAD

	$user		= $this->get_user();

	// TODO: set user used_quota in user table (?)
	$user_files	= $this->db->load_single(
		"SELECT SUM(file_size) AS used_user_quota " .
		"FROM " . $prefix . "file " .
		"WHERE user_id = " . (int) $user['user_id'] . " " .
		"LIMIT 1");

	// TODO: set used_quota in config table (?)
	$files		= $this->db->load_single(
		"SELECT SUM(file_size) AS used_quota " .
		"FROM " . $prefix . "file " .
		"LIMIT 1");

	// Checks

	// upload quota
	if ((!$this->db->upload_quota_per_user
			|| ($user_files['used_user_quota'] < $this->db->upload_quota_per_user))
		 && (!$this->db->upload_quota
			|| ($files['used_quota'] < $this->db->upload_quota)))
	{
		// file there is
		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']))
		{
			// check out $data
			$orig_name	= basename($_FILES['file']['name']);
			$tmp_name	= $_FILES['file']['tmp_name'];
			$mime_type	= mime_content_type($tmp_name);

			$_data		= explode('.', $orig_name);
			$ext		= $_data[count($_data) - 1];
			unset($_data[count($_data) - 1]);

			$ext	= mb_strtolower($ext);
			$banned	= explode('|', $this->db->upload_banned_exts);

			if (in_array($ext, $banned))
			{
				$ext = $ext . '.txt';
			}

			$image = ['avif', 'gif', 'jpeg', 'jpe', 'jpg', 'png', 'webp'];

			if (in_array($ext, $image))
			{
				$is_image = true;
			}

			// user given file name
			$dest_name	= (string) ($_POST['file_dest_name'] ?? null);

			if ($dest_name && $dest_name != '')
			{
				$name	= basename($dest_name);
			}
			else
			{
				$name	= implode('.', $_data);
			}

			// prepare for translit
			$name	= str_replace(['@', '%20', '+'], '-', $name);
			$name	= preg_replace('/[\r\n\t -]+/u', '_', $name);
			$name	= utf8_trim($name, ' .-_');
			$name	= Ut::normalize($name);
			$name	= preg_replace('/[^' . $this->lang['ALPHANUM_P'] . '\.]/u', '', $name);

			// here would be place for transliteration
			if ($this->db->upload_translit)
			{
				$t_name	= Ut::translit($name);
				$t_name	= preg_replace('/\p{Z}+/u', '_', $t_name);
			}
			else
			{
				$t_name	= $name;
			}

			// +write @page_id@ to name
			if (isset($_POST['upload_to']) && $_POST['upload_to'] != 'global')
			{
				$is_global	= 0;
				$fs_name	= '@' . $this->page['page_id'] . '@' . $t_name;
			}
			else
			{
				$is_global	= 1;
				$fs_name	= $t_name;
			}

			if ($is_global)
			{
				$page_id	= 0;
				$dir		= UPLOAD_GLOBAL_DIR . '/';
			}
			else
			{
				$page_id	= $this->page['page_id'];
				$dir		= UPLOAD_PER_PAGE_DIR . '/';
			}

			// file must be in file table!
			// TODO: check against file owner, Admin is always allowed
			// + check for file / page owner
			if (isset($_POST['file_overwrite'])
				&& $this->check_file_record($t_name . '.' . $ext, $page_id))
			{
				$replace = true;
			}
			else
			{
				$replace = false;
			}

			if (is_writable($dir))
			{
				$new_fs_name	= $fs_name;
				$count			= 1;

				if (file_exists($dir . $fs_name . '.' . $ext)
					&& $replace)
				{
					// TODO:
					// + do file revision (add config option)
				}
				else
				{
					while (file_exists($dir . $fs_name . '.' . $ext))
					{
						if ($fs_name === $new_fs_name)
						{
							$fs_name = $new_fs_name . $count;
						}
						else
						{
							$fs_name = $new_fs_name . (++$count);
						}
					}
				}

				$result_name	= $fs_name . '.' . $ext;
				$file_size		= $_FILES['file']['size'];

				// check filesize
				$max_filesize	= $this->db->upload_max_size;
				$maxsize		= (int) ($_POST['maxsize'] ?? null);

				if ($maxsize && ($max_filesize > 1 * $maxsize))
				{
					$max_filesize = 1 * $maxsize;
				}

				// Admins can upload unlimited
				if (($file_size < $max_filesize) || $this->is_admin())
				{
					// check is image, if asked
					$forbid		= 0;
					$size		= [0, 0];

					if ($is_image === true)
					{
						$size	= @getimagesize($tmp_name);
					}

					if ($this->db->upload_images_only)
					{
						if ($size[0] == 0)
						{
							$forbid = 1;
						}
					}

					if (!$forbid)
					{
						// save to permanent location
						move_uploaded_file($tmp_name, $dir . $result_name);
						chmod($dir . $result_name, CHMOD_FILE);

						// replace
						# clearstatcache();

						if ($is_global)
						{
							$file_name		= $result_name;
							$path			= 'file:/';
							$syntax_file	= 'file:/' . $file_name;
						}
						else
						{
							$small_name		= explode('@', $result_name);
							$file_name		= $small_name[count($small_name) - 1];
							$path			= 'file:/' . $this->page['tag'] . '/';
							$syntax_file	= 'file:' . $file_name;
						}

						$file_size_ft	= $this->binary_multiples($file_size, false, true, true);
						$uploaded_dt	= $this->db->date();
						$page_id		= $is_global ? 0 : $this->page['page_id'];

						// replace option: keep old data if new entry is empty
						$description	= mb_substr($_POST['file_description'], 0, 250);
						$description	= $this->sanitize_text_field((string) $description, true);
						# $caption		= $clean_text((string) $_POST['caption']);

						if ($replace)
						{
							$this->db->sql_query(
								"UPDATE " . $prefix . "file SET " .
									"user_id			= " . (int) $user['user_id'] . "," .
									"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
									(!empty($description)
										? "file_description	= " . $this->db->q($description) . ", "
										: "") .
									# "caption			= " . $this->db->q($caption) . ", " .
									"file_size			= " . (int) $file_size . "," .
									"picture_w			= " . (int) $size[0] . "," .
									"picture_h			= " . (int) $size[1] . "," .
									"file_ext			= " . $this->db->q(mb_substr($ext, 0, 10)) . "," .
									"mime_type			= " . $this->db->q($mime_type) . "," .
									"uploaded_dt		= " . $this->db->q($uploaded_dt) . ", " .
									"modified_dt		= UTC_TIMESTAMP() " .
								"WHERE " .
									"page_id			= " . (int) $page_id . " AND " .
									"file_name			= " . $this->db->q($file_name) . " " .
								"LIMIT 1");
						}
						else
						{
							// insert line into DB
							$this->db->sql_query(
								"INSERT INTO " . $prefix . "file SET " .
									"page_id			= " . (int) $page_id . ", " .
									"user_id			= " . (int) $user['user_id'] . "," .
									"file_name			= " . $this->db->q($file_name) . ", " .
									"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
									"file_description	= " . $this->db->q($description) . ", " .
									# "caption			= " . $this->db->q($caption) . ", " .
									"file_size			= " . (int) $file_size . "," .
									"picture_w			= " . (int) $size[0] . "," .
									"picture_h			= " . (int) $size[1] . "," .
									"file_ext			= " . $this->db->q(mb_substr($ext, 0, 10)) . "," .
									"mime_type			= " . $this->db->q($mime_type) . "," .
									"uploaded_dt		= " . $this->db->q($uploaded_dt) . "," .
									"modified_dt		= UTC_TIMESTAMP() ");

							// update user uploads count
							$this->update_files_count($page_id, $user['user_id']);
						}

						// get file_id of uploaded file
						$file = $this->db->load_single(
							"SELECT file_id " .
							"FROM " . $prefix . "file " .
							"WHERE " .
								"file_name		= " . $this->db->q($file_name) . " AND " .
								"page_id		= " . (int) $page_id . " " .
							"LIMIT 1");

						$this->set_message($this->_t('UploadDone'), 'success');
						$this->notify_upload($page_id, $file['file_id'], $this->page['tag'], $file_name, $user['user_id'], $user['user_name'], $replace);

						// log event
						if ($is_global)
						{
							$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedGlobal', SYSTEM_LANG), '', $file_name, $file_size_ft));
						}
						else
						{
							$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedLocal', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title'], $file_name, $file_size_ft));
						}

						$this->http->redirect($this->href('filemeta', '', ['m' => 'show', 'file_id' => (int) $file['file_id']]));
					}
					else //forbid
					{
						$error = $this->_t('UploadNotAPicture');
					}
				}
				else //maxsize
				{
					$error = $this->_t('UploadMaxSizeReached');
				}
			}
			else // is_writable
			{
				$error = $this->_t('UploadDirNotWritable');
			}
		} // !is_uploaded_file
		else
		{
			if (isset($_FILES['file']['error'])
				&& (   $_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE
					|| $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE))
			{
				$error = $this->_t('UploadMaxSizeReached');
			}
			else if (isset($_FILES['file']['error'])
				&& (   $_FILES['file']['error'] == UPLOAD_ERR_PARTIAL
					|| $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE))
			{
				$error = $this->_t('UploadNoFile');
			}
			else
			{
				$error = '';
			}
		}
	}
	else
	{
		if ($this->db->upload_quota_per_user > 0)
		{
			$error =
				$this->_t('UploadMaxFileQuota') . '. <br>' .
				$this->_t('UploadUsedStorage') . ' ' . $this->binary_multiples($user_files['used_user_quota'], false, true, true) .
				' (' . round(($user_files['used_user_quota'] / ($this->db->upload_quota_per_user) * 100), 2) . '%) of ' . $this->binary_multiples(($this->db->upload_quota_per_user), true, true, true);
		}

		if ($this->db->upload_quota > 0)
		{
			$error .=
				'<br>' . $this->_t('UploadMaxFileQuota') . '. <br>' .
				$this->_t('UploadUsedStorage') . ' ' . $this->binary_multiples($files['used_quota'], false, true, true) .
				' (' . round(($files['used_quota'] / ($this->db->upload_quota) * 100), 2) . '%) of ' . $this->binary_multiples(($this->db->upload_quota), true, true, true);
		}
	}

	if ($error)
	{
		$this->set_message($error, 'error');
		$this->reload_me();
	}
}
else
{
	// UPLOAD FILES

	// show navigation for attachments handler
	if ((  $this->db->attachments_handler == 2 && $this->get_user())
		|| $this->db->attachments_handler == 1)
	{
		$tpl->handler = true;
	}

	if ($can_upload)
	{
		$tpl->upload = $this->action('upload', []);
	}
	else
	{
		$this->set_message($this->_t('UploadForbidden'));
	}

}
