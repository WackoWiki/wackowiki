<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO:
// - mode to tag files -> faceted search
// - show for local files relative and absolute syntax (?)

$get_file = function ($file_id)
{
	$file = $this->db->load_single(
	"SELECT f.upload_id, f.page_id, f.user_id, f.file_name, f.file_size, f.file_description, f.uploaded_dt, f.picture_w, f.picture_h, u.user_name, p.supertag, p.title " .
	"FROM " . $this->db->table_prefix . "upload f " .
		"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
	"WHERE f.upload_id ='" . (int) $file_id . "' " .
	"LIMIT 1", true);

	return $file;
};

$is_global		= '';
$is_image		= '';
$message		= '';
$error			= '';

$this->ensure_page(true); // TODO: upload for forums?

# echo '<h3>' . $this->_t('UploadFiles') . "</h3>\n<br />\n";

// check who u are, can u upload?
if ($this->can_upload() === true)
{
	// 1. SHOW FORMS
	if (isset($_GET['remove'])) // show the form
	{
		// 1.a REMOVE FILE CONFIRMATION
		echo '<h3>' . $this->_t('UploadFiles') . ' &raquo; ' . $this->_t('UploadRemoveFile') . '</h3>';
		echo '<ul class="menu">
				<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
				<li><a href="' . $this->href('upload', '', ['show', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadViewProperties') . '</a></li>
				<li><a href="' . $this->href('upload', '', ['edit', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadEditProperties') . '</a></li>

				<li class="active">' . $this->_t('UploadRemoveFile') . "</li>
			</ul><br /><br />\n";

		$file = $get_file((int) $_GET['file_id']);

		if (count($file) > 0)
		{
			if ($this->is_admin()
				|| ($file['page_id']
					&& ($this->page['owner_id'] == $this->get_user_id()))
				|| ($file['user_id'] == $this->get_user_id()))
			{
				$message = '<strong>' . $this->_t('UploadRemoveConfirm') . '</strong>';
				$this->show_message($message, 'warning');

				if ($file['page_id'])
				{
					$path = 'file:/' . $file['supertag'] . '/';
				}
				else
				{
					$path = 'file:/';
				}

				echo $this->form_open('remove_file', ['page_method' => 'upload']);
				// !!!!! place here a reference to delete files
?>
	<ul class="upload">
		<li><h4><?php echo $this->link($path . $file['file_name']); ?></h4>
			<br /><br />
			<table>
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('FileSyntax'); ?>:</th>
					<td><?php echo '<code>' . $path . $file['file_name'] . '</code>'; ?></td>
				</tr>
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('UploadBy'); ?>:</th>
					<td><?php echo $this->user_link($file['user_name'], '', true, false); ?></td>
				</tr>
				<tr class="lined">
					<th class="form_left" scope="row"><?php echo $this->_t('FileAdded'); ?>:</th>
					<td><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></td>
				</tr>
				<tr class="">
					<th class="form_left" scope="row"><?php echo $this->_t('FileSize'); ?>:</th>
					<td><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></td>
				</tr>
<?php
			// image dimension
			if ($file['picture_w'])
			{ ?>
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('FileDimension'); ?>:</th>
					<td><?php echo '' . $file['picture_w'] . ' × ' . $file['picture_h'] . 'px'; ?></td>
				</tr>
<?php
			} ?>
				<tr class="">
					<th class="form_left" scope="row"><?php echo $this->_t('FileName'); ?>:</th>
					<td><?php echo $file['file_name']; ?></td>
				</tr>
				<tr class="lined">
					<th class="form_left" scope="row"><?php echo $this->_t('UploadDesc'); ?>:</th>
					<td><?php echo $file['file_description']; ?></td>
				</tr>
				<tr class="">
					<th class="form_left" scope="row"><?php echo $this->_t('FileAttachedTo'); ?>:</th>
					<td><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></td>
				</tr>
				<tr class="lined">
					<th class="form_left" scope="row"><?php echo $this->_t('FileUsage'); ?>:</th>
					<td><?php echo $this->action('fileusage', ['file_id' => $file['upload_id'], 'nomark' => 1]); ?></td>
				</tr>
			</table>
		</li>
	</ul>
	<br />
	<input type="hidden" name="remove" value="<?php echo $_GET['remove'];?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id'];?>" />
	<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('RemoveButton'); ?>" />
	&nbsp;
	<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n"," ",$this->_t('EditCancelButton')); ?>"/></a>
	<br />
	<br />
<?php
				echo $this->form_close();
			}
			else
			{
				$this->set_message($this->_t('UploadRemoveDenied'), 'error');
			}
		}
		else
		{
			$message = $this->_t('UploadFileNotFound');
			$this->show_message($message, 'info');
		}

		return true;
	}
	else if (isset($_GET['edit']) || isset($_GET['show'])) // show the form
	{
		$file = $get_file((int) $_GET['file_id']);

		if (count($file) > 0)
		{
			if (   $this->is_admin()
				|| ($file['page_id']
					&& ($this->page['owner_id'] == $this->get_user_id()))
				|| ($file['user_id'] == $this->get_user_id()))
			{
				if ($file['page_id'])
				{
					$path = 'file:/' . $file['supertag'] . '/';
				}
				else
				{
					$path = 'file:/';
				}

				echo $this->form_open('upload_file', ['page_method' => 'upload']);
				// !!!!! place here a reference to delete files

				if (isset($_GET['show']))
				{
					// 1.b SHOW FILE PROPERTIES

					echo '<h3>' . $this->_t('UploadFiles') . ' &raquo; ' . $this->_t('UploadViewProperties') . '</h3>';
					echo '<ul class="menu">
							<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
							<li class="active">' . $this->_t('UploadViewProperties') . '</li>
							<li><a href="' . $this->href('upload', '', ['edit', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadEditProperties') . '</a></li>

							<li><a href="' . $this->href('upload', '', ['remove', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadRemoveFile') . "</a></li>
						</ul><br /><br />\n";
?>
	<ul class="upload">
		<li><?php echo $this->link($path . $file['file_name'] ); ?>
			<ul>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileSyntax'); ?>:</span><?php echo '<code>' . $path . $file['file_name'] . '</code>'; ?></li>
				<li><span class="info_title"><?php echo $this->_t('UploadBy'); ?>:</span><?php echo $this->user_link($file['user_name'], '', true, false); ?></li>
				<li><span class="info_title"><?php echo $this->_t('FileAdded'); ?>:</span><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></li>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileSize'); ?>:</span><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></li>
<?php
			// image dimension
			if ($file['picture_w'])
			{ ?>
				<li><span class="info_title"><?php echo $this->_t('FileDimension'); ?>:</span><?php echo '' . $file['picture_w'] . ' × ' . $file['picture_h'] . 'px'; ?></li>
<?php
			} ?>
				<li><span class="info_title"><?php echo $this->_t('FileName'); ?>:</span><?php echo $this->shorten_string($file['file_name']); ?></li>
				<li><span class="info_title"><?php echo $this->_t('UploadDesc'); ?>:</span><?php echo $file['file_description']; ?></li>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileAttachedTo'); ?>:</span><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></li>
			</ul>
		</li>
	</ul>
	<br />

	<input type="hidden" name="edit" value="<?php echo $_GET['edit']?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
	<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('EditStoreButton'); ?>" />
	&nbsp;

	<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n", " ", $this->_t('EditCancelButton')); ?>"/></a>
<?php	echo '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";
?>
 	<br />
	<br />
<?php
				}
				else if (isset($_GET['edit']))
				{
					// 1.c EDIT FILE PROPERTIES
					echo '<h3>' . $this->_t('UploadFiles') . ' &raquo; ' . $this->_t('UploadEditProperties') . '</h3>';
					echo '<ul class="menu">
							<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UserSettingsGeneral') . '</a></li>
							<li><a href="' . $this->href('upload', '', ['show', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadViewProperties') . '</a></li>
							<li class="active">' . $this->_t('UploadEditProperties') . '</li>

							<li><a href="' . $this->href('upload', '', ['remove', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('UploadRemoveFile') . "</a></li>
						</ul><br /><br />\n";

?>
	<ul class="upload">
		<li><?php echo $this->link($path . $file['file_name'] ); ?>
			<ul>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileSyntax'); ?>:</span><?php echo '<code>' . $path . $file['file_name'] . '</code>'; ?></li>
				<li><span class="info_title"><?php echo $this->_t('UploadBy'); ?>:</span><?php echo $this->user_link($file['user_name'], '', true, false); ?></li>
				<li><span class="info_title"><?php echo $this->_t('FileAdded'); ?>:</span><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></li>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileSize'); ?>:</span><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></li>
<?php
			// image dimension
			if ($file['picture_w'])
			{ ?>
				<li><span class="info_title"><?php echo $this->_t('FileDimension'); ?>:</span><?php echo '' . $file['picture_w'] . ' × ' . $file['picture_h'] . 'px'; ?></li>
<?php
			} ?>
				<li><span class="info_title"><?php echo $this->_t('FileName'); ?>:</span><?php echo $this->shorten_string($file['file_name']); ?></li>
				<li><span class="info_title"><?php echo $this->_t('UploadDesc'); ?>:</span><input type="text" maxlength="250" name="file_description" id="UploadDesc" size="80" value="<?php echo $file['file_description']; ?>"/></li>
				<li><span>&nbsp;</span></li>
				<li><span class="info_title"><?php echo $this->_t('FileAttachedTo'); ?>:</span><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></li>
			</ul>
		</li>
	</ul>
	<br />

	<input type="hidden" name="edit" value="<?php echo $_GET['edit']?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
	<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('EditStoreButton'); ?>" />
	&nbsp;
	<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n", " ", $this->_t('EditCancelButton')); ?>"/></a>
	<br />
	<br />
<?php
				}

				echo $this->form_close();
			}
			else
			{
				$this->set_message($this->_t('UploadEditDenied'));
			}
		}
		else
		{
			$message = $this->_t('UploadFileNotFound');
			$this->show_message($message, 'info');
		}

		return true;
	}
	else
	{
		// 2 PROCESS POSTS
		if (isset($_POST['remove']))
		{
			// 2.a DELETE FILE

			$file = $get_file((int) $_POST['file_id']);

			if (count($file) > 0)
			{
				if ($this->is_admin()
					|| ($file['page_id']
						&& ($this->page['owner_id'] == $this->get_user_id()))
					|| ($file['user_id'] == $this->get_user_id()))
				{
					// remove from DB
					$this->db->sql_query(
						"DELETE FROM " . $this->db->table_prefix . "upload " .
						"WHERE upload_id = '" . $file['upload_id'] . "'" );

					// update user uploads count
					$this->db->sql_query(
						"UPDATE {$this->db->user_table} SET " .
							"total_uploads = total_uploads - 1 " .
						"WHERE user_id = '" . $file['user_id'] . "' " .
						"LIMIT 1");

					$message .= $this->_t('UploadRemovedFromDB') . '<br />';

					// remove from FS
					$real_filename = ($file['page_id']
						? UPLOAD_PER_PAGE_DIR . '/@' . $file['page_id'] . '@'
						: UPLOAD_GLOBAL_DIR . '/') .
						$file['file_name'];

					if (@unlink($real_filename))
					{
						$message .= $this->_t('UploadRemovedFromFS');
					}
					else
					{
						$this->set_message($this->_t('UploadRemovedFromFSError'), 'error');
					}

					if ($message)
					{
						$this->set_message($message, 'success');
					}

					// log event
					$this->log(1, Ut::perc_replace($this->_t('LogRemovedFile', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));
				}
				else
				{
					$this->set_message($this->_t('UploadRemoveDenied'));
				}
			}
			else
			{
				$this->set_message($this->_t('UploadRemoveNotFound'));
			}
		}
		else if (isset($_POST['edit']))
		{
			// 2.b UPDATE CHANGED FILE PROPERTIES

			$file = $get_file((int) $_POST['file_id']);

			if (count($file) > 0)
			{
				if ($this->is_admin()
					|| ($file['page_id']
						&& ($this->page['owner_id'] == $this->get_user_id()))
					|| ($file['user_id'] == $this->get_user_id()))
				{
					$description = substr($_POST['file_description'], 0, 250);
					$description = rtrim( $description, '\\' );

					// Make HTML in the description redundant
					$description = $this->format($description, 'pre_wacko');
					$description = $this->format($description, 'safehtml');
					$description = htmlspecialchars($description, ENT_COMPAT, $this->get_charset());

					// update file metadata
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "upload SET " .
							"upload_lang		= " . $this->db->q($this->page['page_lang']) . ", " .
							"file_description	= " . $this->db->q($description) . " " .
						"WHERE upload_id = '" . $file['upload_id'] . "' " .
						"LIMIT 1");

					$message .= $this->_t('UploadEditedMeta') . "<br />";

					if ($message)
					{
						$this->set_message($message, 'success');
					}

					// log event
					$this->log(1, Ut::perc_replace($this->_t('LogUpdatedFileMeta', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));
					$this->http->redirect($this->href('upload', '', ['show', 'file_id=' . (int) $file['upload_id']]));
				}
				else
				{
					$this->set_message($this->_t('UploadEditDenied'));
				}
			}
			else
			{
				$this->set_message($this->_t('UploadRemoveNotFound'));
			}
		}
		else if (isset($_POST['upload']))
		{
			// 2.c PROCESS FILE UPLOAD

			$user		= $this->get_user();

			// TODO: set user used_quota in user table (?)
			$user_files	= $this->db->load_single(
				"SELECT SUM(file_size) AS used_user_quota " .
				"FROM " . $this->db->table_prefix . "upload " .
				"WHERE user_id = '" . $user['user_id'] . "' " .
				"LIMIT 1");

			// TODO: set used_quota in config table (?)
			$files		= $this->db->load_single(
				"SELECT SUM(file_size) AS used_quota " .
				"FROM " . $this->db->table_prefix . "upload " .
				"LIMIT 1");

			// Checks

			// 1. upload quota
			if ( (!$this->db->upload_quota_per_user
					|| ($user_files['used_user_quota'] < $this->db->upload_quota_per_user))
				 && (!$this->db->upload_quota
					|| ($files['used_quota'] < $this->db->upload_quota)) )
			{
				if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) // there is file
				{
					// 1. check out $data
					$_data	= explode('.', $_FILES['file']['name']);
					$ext	= $_data[count($_data) - 1];
					unset($_data[count($_data) - 1]);

					// 3. extensions
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
					$name = $this->format($name, 'translit');

					// 1.5. +write @page_id@ to name
					if (isset($_POST['to']) && $_POST['to'] != 'global')
					{
						$name = '@' . $this->page['page_id'] . '@' . $name;
					}
					else
					{
						$is_global = 1;
					}

					if ($is_global)
					{
						$dir = UPLOAD_GLOBAL_DIR . '/';
					}
					else
					{
						$dir = UPLOAD_PER_PAGE_DIR . '/';
					}

					if (is_writable($dir))
					{
						$_name	= $name;
						$count	= 1;

						while (file_exists($dir . $name . '.' . $ext))
						{
							if ($name === $_name)
							{
								$name = $_name . $count;
							}
							else
							{
								$name = $_name . (++$count);
							}
						}

						$result_name	= $name . '.' . $ext;
						$file_size		= $_FILES['file']['size'];

						// 1.6. check filesize, if asked
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

								if ($is_global)
								{
									$small_name		= $result_name;
									$path			= 'file:/';
									$syntax_file	= 'file:/' . $small_name;
								}
								else
								{
									$small_name		= explode('@', $result_name);
									$small_name		= $small_name[count($small_name) - 1];
									$path			= 'file:/' . $this->page['supertag'] . '/';
									$syntax_file	= 'file:' . $small_name;
								}

								$file_size_ft	= $this->binary_multiples($file_size, false, true, true);
								$uploaded_dt	= $this->db->date();

								$description	= substr($_POST['file_description'], 0, 250);
								$description	= rtrim( $description, '\\' );

								// Make HTML in the description redundant
								$description	= $this->format($description, 'pre_wacko');
								$description	= $this->format($description, 'safehtml');
								$description	= htmlspecialchars($description, ENT_COMPAT, $this->get_charset());

								// 5. insert line into DB
								$this->db->sql_query(
									"INSERT INTO " . $this->db->table_prefix . "upload SET " .
										"page_id			= '" . ($is_global ? "0" : $this->page['page_id']) . "', " .
										"user_id			= '" . $user['user_id'] . "'," .
										"file_name			= " . $this->db->q($small_name) . ", " .
										"upload_lang		= " . $this->db->q($this->page['page_lang']) . ", " .
										"file_description	= " . $this->db->q($description) . ", " .
										"file_size			= '" . (int) $file_size . "'," .
										"picture_w			= '" . (int) $size[0] . "'," .
										"picture_h			= '" . (int) $size[1] . "'," .
										"file_ext			= " . $this->db->q(substr($ext, 0, 10)) . "," .
										"uploaded_dt		= " . $this->db->q($uploaded_dt) . " ");

								// update user uploads count
								$this->db->sql_query(
									"UPDATE {$this->db->user_table} SET " .
										"total_uploads = total_uploads + 1 " .
									"WHERE user_id = '" . $user['user_id'] . "' " .
									"LIMIT 1");

								$file_id = $this->db->load_single(
									"SELECT upload_id " .
									"FROM " . $this->db->table_prefix . "upload " .
									"WHERE file_name = " . $this->db->q($small_name) . " " .
									"LIMIT 1");

								// 4. output link to file
								// !!!!! write after providing filelink syntax
								$this->set_message($this->_t('UploadDone'), 'success');

								// log event
								if ($is_global)
								{
									$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedGlobal', SYSTEM_LANG), '', $small_name, $file_size_ft));
								}
								else
								{
									$this->log(4, Ut::perc_replace($this->_t('LogFileUploadedLocal', SYSTEM_LANG), $this->page['tag'] . ' ' . $this->page['title'], $small_name, $file_size_ft));
								}

		echo '<h3>' . $this->_t('UploadFiles') . ' &raquo; ' . $this->_t('UserSettingsGeneral') . '</h3>';
		echo '<ul class="menu">
				<li class="active">' . $this->_t('UserSettingsGeneral') . '</li>
				<li><a href="' . $this->href('upload', '', ['show', 'file_id=' . (int) $file_id['upload_id']]) . '">' . $this->_t('UploadViewProperties') . '</a></li>
				<li><a href="' . $this->href('upload', '', ['edit', 'file_id=' . (int) $file_id['upload_id']]) . '">' . $this->_t('UploadEditProperties') . '</a></li>

				<li><a href="' . $this->href('upload', '', ['remove', 'file_id=' . (int) $file_id['upload_id']]) . '">' . $this->_t('UploadRemoveFile') . "</a></li>
			</ul><br /><br />\n";
		?>
		<ul class="upload">
			<li><?php echo $this->link($path . $small_name); ?>
				<ul>
					<li><span>&nbsp;</span></li>
					<li><span class="info_title"><?php echo $this->_t('FileSyntax'); ?>:</span><?php echo '<code>' . $syntax_file . '</code>'; ?></li>
					<li><span class="info_title"><?php echo $this->_t('UploadBy'); ?>:</span><?php echo $this->user_link($user['user_name'], '', true, false); ?></li>
					<li><span class="info_title"><?php echo $this->_t('FileAdded'); ?>:</span><?php echo $this->get_time_formatted($uploaded_dt); ?></li>
					<li><span>&nbsp;</span></li>
					<li><span class="info_title"><?php echo $this->_t('FileSize'); ?>:</span><?php echo '' . $file_size_ft . ''; ?></li>
					<?php
					// image dimension
					if (isset($size))
					{ ?>
					<li><span class="info_title"><?php echo $this->_t('FileDimension'); ?>:</span><?php echo '' . $size[0] . ' × ' . $size[1] . 'px'; ?></li>
					<?php
					} ?>

					<li><span class="info_title"><?php echo $this->_t('FileName'); ?>:</span><?php echo $small_name; ?></li>
					<li><span class="info_title"><?php echo $this->_t('UploadDesc'); ?>:</span><?php echo $description; ?></li>
					<li><span>&nbsp;</span></li>
					<li><span class="info_title"><?php echo $this->_t('FileAttachedTo'); ?>:</span><?php echo !$is_global? $this->link('/' . $this->page['supertag'], '', $this->page['title'], $this->page['supertag']) : $this->_t('UploadGlobal'); ?></li>
				</ul>
			</li>
		</ul>
		<br />
	<?php
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
		}

		if ($error)
		{
			$this->set_message($error, 'error');
		}

		echo '<h3>' . $this->_t('UploadFiles') . '</h3>';
		echo "<br /><br />\n";

		echo $this->action('upload', []) . '<br />';
	}
}
else
{
	$this->set_message($this->_t('UploadForbidden'));
}

// show uploaded files for current page
if ($this->has_access('read'))
{
	echo $this->action('files', []) . '<br />';
}

echo '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";
