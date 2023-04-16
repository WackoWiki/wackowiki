<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Import the svgSanitize class into the global namespace
use svgSanitize\Sanitizer;

// TODO:
// - thumbnails


$can_upload		= $this->can_upload();
$error			= '';
$is_duplicate	= false;
$is_global		= null;
$is_image		= null;
$prefix			= $this->prefix;

$this->ensure_page(true);

// functions
$can_replace = function($file_name, $page_id, $user)
{
	$result = false;

	if ($file_record = $this->check_file_record($file_name, $page_id))
	{
		if ($file_record['user_id'] == $user['user_id'] || $this->is_admin())
		{
			$result = true;
		}
		else
		{
			$result = false;
			$this->set_message(
				Ut::perc_replace(
					$this->_t('UploadOverwriteDenied'),
					'<code>' . $file_record['file_name'] . '</code>'),
				'error');
		}
	}

	return $result;
};

$translit_filename = function($name)
{
	// prepare for translit
	$name	= str_replace(['@', '%20', '+'], '_', $name);
	$name	= preg_replace('/[\r\n\t ]+/u', '_', $name);

	// remove multi full stop, spacing underscore and hyphen-minus
	$name	= preg_replace('/(-{2,})/u', '-', $name);
	$name	= preg_replace('/(_{2,})/u', '_', $name);
	$name	= preg_replace('/(\.{2,})/u', '.', $name);

	// remove consecutive occurrences (.- / -.)
	$name	= str_replace(['.-', '-.'], '', $name);
	$name	= utf8_trim($name, ' .-_');

	$name	= Ut::normalize($name);
	$name	= preg_replace('/[^' . self::PATTERN['ALPHANUM_P'] . '\.]/u', '', $name);

	// file name transliteration
	if ($this->db->upload_translit)
	{
		$t_name	= Ut::translit($name);
		$t_name	= preg_replace('/[\p{Z}]+/u', '_', $t_name);
	}
	else
	{
		$t_name	= $name;
	}

	return $t_name;
};

$duplicate_file = function($file, $file_hash)
{
	$file_hash_exists	= sha1_file($file);

	if ($file_hash_exists === $file_hash)
	{
		$this->set_message($this->_t('FileIsDuplicate'), 'hint');

		return true;
	}

	return false;
};

$duplicate_files = function($file_hash) use ($prefix)
{
	$files	= $this->db->load_all(
		"SELECT file_id " .
		"FROM " . $prefix . "file " .
		"WHERE file_hash = " . $this->db->q($file_hash) . " ");

	$file_ids = [];

	foreach($files as $file)
	{
		$file_ids[] = $file['file_id'];
	}

	return $file_ids;
};


$sanitize_svg = function($svg_file)
{
	$sanitizer = new Sanitizer();

	// set options
	$sanitizer->removeRemoteReferences(true);
	$sanitizer->minify(true);

	$dirty_svg = file_get_contents($svg_file);

	return $sanitizer->sanitize($dirty_svg);
};

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

	// A. upload quota
	if ((!$this->db->upload_quota_per_user
			|| ($user_files['used_user_quota'] < $this->db->upload_quota_per_user))
		&& (!$this->db->upload_quota
			|| ($files['used_quota'] < $this->db->upload_quota)))
	{
		// B. file there is
		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']))
		{
			// check out $data
			$orig_name	= basename($_FILES['file']['name']);
			$tmp_name	= $_FILES['file']['tmp_name'];
			$mime_type	= mime_content_type($tmp_name);

			// check file extension
			$_data		= explode('.', $orig_name);
			$ext		= $_data[count($_data) - 1];
			unset($_data[count($_data) - 1]);

			$ext		= mb_strtolower($ext);

			if (in_array($ext, self::EXT['bitmap']))
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

			// sanitize & translit file name
			$t_name	= $translit_filename($name);

			// C. the file name and also the extension should not be empty at all
			if ($t_name && preg_match('/[a-zA-Z0-9]{1,10}/u', $ext))
			{
				// write @page_id@ to file name
				if (isset($_POST['upload_to']) && $_POST['upload_to'] != 'global')
				{
					$is_global	= false;
					$fs_name	= '@' . $this->page['page_id'] . '@' . $t_name;
					$page_id	= $this->page['page_id'];
					$dir		= UPLOAD_LOCAL_DIR;
				}
				else
				{
					$is_global	= true;
					$fs_name	= $t_name;
					$page_id	= 0;
					$dir		= UPLOAD_GLOBAL_DIR;
				}

				// overwrite file
				// + file must be in file table
				// + allow only file owner or admin
				$replace	= isset($_POST['file_overwrite']) && $can_replace($t_name . '.' . $ext, $page_id, $user);
				$file_hash	= sha1_file($tmp_name);

				// D. check if folder is writable
				if (is_writable($dir . '/'))
				{
					$new_fs_name	= $fs_name;
					$count			= 1;

					if ($file_ids = $duplicate_files($file_hash))
					{
						$this->set_message(
							$this->_t('FileHasDuplicate') . '<br>' .
							$this->action('files', ['file_ids' => $file_ids, 'media' => 0, 'nomark' => 1]),
							'hint');
					}

					// replace exising file
					if (file_exists($dir . '/' . $fs_name . '.' . $ext)
						&& $replace)
					{
						// do nothing
						$is_duplicate = $duplicate_file($dir . '/' . $fs_name . '.' . $ext, $file_hash);

						// TODO:
						// + do file revision (add config option)
					}
					// check for already existing files and add denominator to file name via counter
					// e.g. file.txt -> file3.txt
					else
					{
						while (file_exists($dir . '/' . $fs_name . '.' . $ext))
						{
							if ($is_duplicate = $duplicate_file($dir . '/' . $fs_name . '.' . $ext, $file_hash))
							{
								break;
							}

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

					// join again file name and extension
					$result_name	= $fs_name . '.' . $ext;

					// get filesize
					$file_size		= (int) $_FILES['file']['size'];
					$maxsize		= (int) ($_POST['maxsize'] ?? null);
					$max_filesize	= (int) $this->get_max_upload_size();

					// form allows only a smaller files size than upload_max_size
					if ($maxsize && ($max_filesize > $maxsize))
					{
						$max_filesize = $maxsize;
					}

					// E. check filesize (Admins can upload unlimited)
					if (($file_size < $max_filesize) || $this->is_admin())
					{
						// check is image, if asked
						$forbid		= false;
						$size		= [0, 0];

						if ($is_image === true)
						{
							$size	= @getimagesize($tmp_name);
						}

						if ($this->db->upload_images_only
							&& !$this->is_admin()
							&& $size[0] == 0)
						{
							$forbid	= true;
							$error	= $this->_t('UploadNotAPicture');
						}
						// file_name is max 255 bytes, restrict file name to 240 bytes.
						else if (strlen($result_name) > 240)
						{
							$forbid	= true;
							$error	= $this->_t('FilenameTooLong');
						}
						else if (!$this->file_extension_check($result_name))
						{
							$forbid	= true;
							$error	= Ut::perc_replace($this->_t('BannedFiletype'), '<code>.' . $ext . '</code>');
						}
						else if ($this->db->check_mimetype)
						{
							if (in_array($mime_type, $this->db->mime_type_exclusions))
							{
								$forbid	= true;
								$error	= Ut::perc_replace($this->_t('UploadBadMime'), '<code>' . $mime_type . '</code>');
							}
							else if (!$this->verify_extension($mime_type, $ext))
							{
								$forbid	= true;
								$error	= Ut::perc_replace(
									$this->_t('UploadMimeMismatch'),
									'<code>' . $ext . '</code>',
									'<code>' . $mime_type . '</code>');
							}
						}

						// F. check for upload only images and forbidden MIME types
						if (!$forbid)
						{
							$safe_file	= Ut::join_path($dir, $result_name);

							if ($this->db->svg_sanitizer
								&& ($ext == 'svg' || $mime_type == 'image/svg+xml'))
							{
								if ($clean_svg = $sanitize_svg($tmp_name))
								{
									// save clean SVG/XML data
									@file_put_contents($safe_file, $clean_svg);
								}
							}
							else if (!$is_duplicate)
							{
								// save to permanent location
								move_uploaded_file($tmp_name, $safe_file);
							}

							chmod($safe_file, CHMOD_FILE);

							// replace
							# clearstatcache();

							if ($is_global)
							{
								$file_name		= $result_name;
							}
							else
							{
								$small_name		= explode('@', $result_name);
								$file_name		= $small_name[count($small_name) - 1];
							}

							$file_size_ft	= $this->binary_multiples($file_size, false, true, true);
							$page_id		= $is_global ? 0 : $this->page['page_id'];

							// replace option: keep old data if new entry is empty
							$description	= mb_substr($_POST['file_description'], 0, 250);
							$description	= $this->sanitize_text_field((string) $description, true);

							if ($replace)
							{
								$this->db->sql_query(
									"UPDATE " . $prefix . "file SET " .
										"user_id			= " . (int) $user['user_id'] . "," .
										"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
										(!empty($description)
											? "file_description	= " . $this->db->q($description) . ", "
											: "") .
										"file_size			= " . (int) $file_size . "," .
										"picture_w			= " . (int) $size[0] . "," .
										"picture_h			= " . (int) $size[1] . "," .
										"file_ext			= " . $this->db->q(mb_substr($ext, 0, 10)) . "," .
										"mime_type			= " . $this->db->q($mime_type) . "," .
										"created			= UTC_TIMESTAMP(), " .
										"modified			= UTC_TIMESTAMP(), " .
										"file_hash			= " . $this->db->q($file_hash) . " " .
									"WHERE " .
										"page_id			= " . (int) $page_id . " AND " .
										"file_name			= " . $this->db->q($file_name) . " " .
									"LIMIT 1");
							}
							else if (!$is_duplicate)
							{
								$this->db->sql_query(
									"INSERT INTO " . $prefix . "file SET " .
										"page_id			= " . (int) $page_id . ", " .
										"user_id			= " . (int) $user['user_id'] . "," .
										"file_name			= " . $this->db->q($file_name) . ", " .
										"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
										"file_description	= " . $this->db->q($description) . ", " .
										"file_size			= " . (int) $file_size . "," .
										"picture_w			= " . (int) $size[0] . "," .
										"picture_h			= " . (int) $size[1] . "," .
										"file_ext			= " . $this->db->q(mb_substr($ext, 0, 10)) . "," .
										"mime_type			= " . $this->db->q($mime_type) . "," .
										"created			= UTC_TIMESTAMP()," .
										"modified			= UTC_TIMESTAMP()," .
										"file_hash			= " . $this->db->q($file_hash) . " ");

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

							if (!$is_duplicate)
							{
								$this->set_message($this->_t('UploadDone'), 'success');
							}

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
						} // [F] forbid
					}
					else // [E] maxsize
					{
						$error = $this->_t('UploadMaxSizeReached');
					}
				}
				else //[D] is_writable
				{
					$error = $this->_t('UploadDirNotWritable');
				}
			}
			else // [C] empty file extension
			{
				$error = $this->_t('UploadEmptyExtension');
			}
		}
		else // [B] !is_uploaded_file
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
		}
	}
	else // [A] upload quota
	{
		if ($this->db->upload_quota_per_user > 0)
		{
			$error =
				$this->_t('UploadMaxFileQuota') . '. <br>' .
				$this->_t('UploadUsedStorage') . ' ' . $this->binary_multiples($user_files['used_user_quota'], false, true, true) .
				' (' . round(($user_files['used_user_quota'] / ($this->db->upload_quota_per_user) * 100), 2) . '%) of ' . $this->binary_multiples((int) $this->db->upload_quota_per_user, true, true, true);
		}

		if ($this->db->upload_quota > 0)
		{
			$error .=
				'<br>' . $this->_t('UploadMaxFileQuota') . '. <br>' .
				$this->_t('UploadUsedStorage') . ' ' . $this->binary_multiples($files['used_quota'], false, true, true) .
				' (' . round(($files['used_quota'] / ($this->db->upload_quota) * 100), 2) . '%) of ' . $this->binary_multiples((int) $this->db->upload_quota, true, true, true);
		}
	}

	// set error message and reload
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
