<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO:
// - thumbnails


$clean_text = function ($string)
{
	$string = rtrim($string, '\\');

	// Make HTML in the description redundant
	$string = $this->format($string, 'pre_wacko');
	$string = $this->format($string, 'wacko'); //
	$string = $this->format($string, 'safehtml'); //
	#$string = htmlspecialchars($string, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET, $this->get_charset()); // breaks html unicode chars

	return $string;
};

$is_global		= '';
$is_image		= '';
$message		= '';
$error			= '';
$can_upload		= $this->can_upload();

$this->ensure_page(true); // TODO: upload for forums?

// check who u are, can u upload?
if (isset($_POST['upload']) & $can_upload)
{
	// 2.c PROCESS FILE UPLOAD

	$user		= $this->get_user();

	// TODO: set user used_quota in user table (?)
	$user_files	= $this->db->load_single(
		"SELECT SUM(file_size) AS used_user_quota " .
		"FROM " . $this->db->table_prefix . "file " .
		"WHERE user_id = '" . $user['user_id'] . "' " .
		"LIMIT 1");

	// TODO: set used_quota in config table (?)
	$files		= $this->db->load_single(
		"SELECT SUM(file_size) AS used_quota " .
		"FROM " . $this->db->table_prefix . "file " .
		"LIMIT 1");

	// Checks

	// 1. upload quota
	if ((!$this->db->upload_quota_per_user
			|| ($user_files['used_user_quota'] < $this->db->upload_quota_per_user))
		 && (!$this->db->upload_quota
			|| ($files['used_quota'] < $this->db->upload_quota)))
	{
		// file there is
		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']))
		{
			// 1. check out $data
			#$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$src		= $_FILES['file']['tmp_name'];
			$mime_type	= mime_content_type($src);

			$_data		= explode('.', $_FILES['file']['name']);
			$ext		= $_data[count($_data) - 1];
			unset($_data[count($_data) - 1]);

			// TODO: filter against banned and then allowed file extentions / mime type
			// see file_extension_check()
			#php5", ".pht", ".phtml", ".shtml", ".asa", ".cer", ".asax", ".swf", or ".xap"

			// 3. extensions
			$upload_banned_exts = [
				// HTML may contain cookie-stealing JavaScript and web bugs
				'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
				// PHP scripts may execute arbitrary code on the server
				'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
				// Other types that may be interpreted by some servers
				'shtml', 'jhtml', 'pl', 'py', 'cgi',
				// May contain harmful executables for Windows victims
				'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl'
			];

			$upload_banned_mime = [
				// HTML may contain cookie-stealing JavaScript and web bugs
				'text/html', 'text/javascript', 'text/x-javascript', 'application/x-shellscript',
				// PHP scripts may execute arbitrary code on the server
				'application/x-php', 'text/x-php',
				// Other types that may be interpreted by some servers
				'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
				// Client-side hazards on Internet Explorer
				'text/scriptlet', 'application/x-msdownload',
				// Windows metafile, client-side vulnerability on some systems
				'application/x-msmetafile',
			];

			$ext	= strtolower($ext);
			$banned	= explode('|', $this->db->upload_banned_exts);

			if (in_array($ext, $banned))
			{
				$ext = $ext . '.txt';
			}

			$image = ['gif', 'jpeg', 'jpe', 'jpg', 'png'];

			if (in_array($ext, $image))
			{
				$is_image = true;
			}

			// TODO: check MIME for extension, e.g.
			// File extension ".pdf" does not match the detected MIME type of the file (image/jpeg).
			if (isset($_POST['file_dest_name']) && $_POST['file_dest_name'] != '')
			{
				$name = $_POST['file_dest_name'];
			}
			else
			{
				$name	= implode('.', $_data);
			}

			$name	= str_replace('@', '_', $name);

			// here would be place for translit
			$t_name = $this->format($name, 'translit');



			// 1.5. +write @page_id@ to name
			if (isset($_POST['to']) && $_POST['to'] != 'global')
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

				// 1.6. check filesize
				$max_filesize	= $this->db->upload_max_size;

				if (isset($_POST['maxsize']))
				{
					if ($max_filesize > 1 * $_POST['maxsize'])
					{
						$max_filesize = 1 * $_POST['maxsize'];
					}
				}

				// Admins can upload unlimited
				if (($file_size < $max_filesize) || $this->is_admin())
				{
					// 1.7. check is image, if asked
					$forbid		= 0;
					$size		= [0, 0];
					$src		= $_FILES['file']['tmp_name'];

					if ($is_image === true)
					{
						$size	= @getimagesize($src);
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
						// 3. save to permanent location
						move_uploaded_file($_FILES['file']['tmp_name'], $dir . $result_name);
						chmod($dir . $result_name, 0644);

						// replace
						#clearstatcache();

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
							$path			= 'file:/' . $this->page['supertag'] . '/';
							$syntax_file	= 'file:' . $file_name;
						}

						$file_size_ft	= $this->binary_multiples($file_size, false, true, true);
						$uploaded_dt	= $this->db->date();

						// replace option: keep old data if new entry is empty
						$description	= substr($_POST['file_description'], 0, 250);
						$description	= $clean_text((string) $description);
						# $caption		= $clean_text((string) $_POST['caption']);

						if ($replace)
						{
							$this->db->sql_query(
								"UPDATE " . $this->db->table_prefix . "file SET " .
									#"page_id			= '" . ($is_global ? "0" : $this->page['page_id']) . "', " .
									"user_id			= '" . $user['user_id'] . "'," .
									#"file_name			= " . $this->db->q(file_name) . ", " .
									"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
									(!empty($description)
										? "file_description	= " . $this->db->q($description) . ", "
										: "") .
									# "caption			= " . $this->db->q($caption) . ", " .
									"file_size			= '" . (int) $file_size . "'," .
									"picture_w			= '" . (int) $size[0] . "'," .
									"picture_h			= '" . (int) $size[1] . "'," .
									"file_ext			= " . $this->db->q(substr($ext, 0, 10)) . "," .
									"mime_type			= " . $this->db->q($mime_type) . "," .
									"uploaded_dt		= " . $this->db->q($uploaded_dt) . ", " .
									"modified_dt		= UTC_TIMESTAMP() " .
								"WHERE " .
									(!$is_global
										? "page_id		= '" . $this->page['page_id'] . "' AND "
										: "" ) .
									"file_name			= '" . $file_name . "' " .
								"LIMIT 1");
						}
						else
						{
							// 5. insert line into DB
							$this->db->sql_query(
								"INSERT INTO " . $this->db->table_prefix . "file SET " .
									"page_id			= '" . ($is_global ? "0" : $this->page['page_id']) . "', " .
									"user_id			= '" . $user['user_id'] . "'," .
									"file_name			= " . $this->db->q($file_name) . ", " .
									"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
									"file_description	= " . $this->db->q($description) . ", " .
									# "caption			= " . $this->db->q($caption) . ", " .
									"file_size			= '" . (int) $file_size . "'," .
									"picture_w			= '" . (int) $size[0] . "'," .
									"picture_h			= '" . (int) $size[1] . "'," .
									"file_ext			= " . $this->db->q(substr($ext, 0, 10)) . "," .
									"mime_type			= " . $this->db->q($mime_type) . "," .
									"uploaded_dt		= " . $this->db->q($uploaded_dt) . "," .
									"modified_dt		= UTC_TIMESTAMP() ");

							// update user uploads count
							$this->db->sql_query(
								"UPDATE " . $this->db->user_table . " SET " .
									"total_uploads = total_uploads + 1 " .
								"WHERE user_id = '" . $user['user_id'] . "' " .
								"LIMIT 1");
						}

						$file = $this->db->load_single(
							"SELECT file_id " .
							"FROM " . $this->db->table_prefix . "file " .
							"WHERE file_name = " . $this->db->q($file_name) . " " .
							"LIMIT 1");

						$this->set_message($this->_t('UploadDone'), 'success');
						$this->notify_upload($this->page['page_id'], $this->page['tag'], $file_name, $user['user_id'], $user['user_name'], $replace);

						// log event
						if ($is_global)
						{
							$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedGlobal', SYSTEM_LANG), '', $file_name, $file_size_ft));
						}
						else
						{
							$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedLocal', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title'], $file_name, $file_size_ft));
						}

						$this->http->redirect($this->href('filemeta', '', ['show', 'file_id' => (int) $file['file_id']]));
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
		} //!is_uploaded_file
		else
		{
			if (isset($_FILES['file']['error']) && ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE))
			{
				$error = $this->_t('UploadMaxSizeReached');
			}
			else if (isset($_FILES['file']['error']) && ($_FILES['file']['error'] == UPLOAD_ERR_PARTIAL || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE))
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
			$error = $this->_t('UploadMaxFileQuota') . '. <br />' .
					 'Storage in use ' . $this->binary_multiples($user_files['used_user_quota'], false, true, true) . ' (' . round(($user_files['used_user_quota'] / ($this->db->upload_quota_per_user) * 100), 2) . '%) of ' . $this->binary_multiples(($this->db->upload_quota_per_user), true, true, true);
		}

		if ($this->db->upload_quota > 0)
		{
			$error .= '<br />' . $this->_t('UploadMaxFileQuota') . '. <br />' .
					  'Storage in use ' . $this->binary_multiples($files['used_quota'], false, true, true) . ' (' . round(($files['used_quota'] / ($this->db->upload_quota) * 100), 2) . '%) of ' . $this->binary_multiples(($this->db->upload_quota), true, true, true);
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
	// 1.d UPLOAD FILES

	echo '<ul class="menu">
			<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('Attachments') . '</a></li>' .
		"</ul>\n";

	echo '<h3>' . $this->_t('UploadFiles') . '</h3>';

	if ($can_upload)
	{
		echo $this->action('upload', []) . '<br />';
	}
	else
	{
		$this->set_message($this->_t('UploadForbidden'));
	}

	echo "<br /><br />\n";
	echo '<a href="' . $this->href() . '" class="btn_link"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";

}