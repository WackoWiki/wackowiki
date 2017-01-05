<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* TODO:
 - add mode to tag/label files -> faceted search
 - show for local files relative and absolute syntax (?)
 - split in attachments[local|global|all] and filemeta[view|edit|delete] handler
 - move all non GUI code in attachment and upload class
 - thumbnails
 */

$get_file = function ($file_id)
{
	$file = $this->db->load_single(
	"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_lang, f.file_size, f.file_description, f.caption, f.uploaded_dt, f.picture_w, f.picture_h, f.file_ext, u.user_name, p.supertag, p.title " .
	"FROM " . $this->db->table_prefix . "file f " .
		"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
	"WHERE f.file_id ='" . (int) $file_id . "' " .
	"LIMIT 1", true);

	return $file;
};

$format_desc = function($text, $file_lang)
{
	$desc		= $this->format($text, 'typografica' );

	if ($this->page['page_lang'] != $file_lang)
	{
		$desc	= $this->do_unicode_entities($text, $file_lang);
	}

	return $desc;
};

$clean_text = function ($string)
{
	$string = rtrim($string, '\\');

	// Make HTML in the description redundant
	$string = $this->format($string, 'pre_wacko');
	$string = $this->format($string, 'wacko'); //
	$string = $this->format($string, 'safehtml'); //
	#$string = htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET, $this->get_charset()); // breaks html unicode chars

	return $string;
};

$is_global		= '';
$is_image		= '';
$message		= '';
$error			= '';
$can_upload		= $this->can_upload();

$this->ensure_page(true); // TODO: upload for forums?

// check who u are, can u upload?
#if ($this->can_upload())
#{
	// 1. SHOW FORMS
	if (isset($_GET['remove']) & $can_upload) // show the form
	{
		// 1.a REMOVE FILE CONFIRMATION
		echo '<ul class="menu">' .
				'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('Attachments') . '</a></li>' .
				($can_upload
					? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
					: '') .
			"</ul>\n";

		echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('FileRemove') . '</h3>';
		echo '<ul class="menu">' .
					'<li><a href="' . $this->href('attachments', '', ['show', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('FileViewProperties') . '</a></li>' .
					'<li><a href="' . $this->href('attachments', '', ['edit', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('FileEditProperties') . '</a></li>' .
					// file revisions here
					'<li class="active">' . $this->_t('FileRemove') . '</li>' .
				"</ul><br /><br />\n";

		$file = $get_file((int) $_GET['file_id']);

		if (count($file) > 0)
		{
			if ($this->is_admin()
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

				echo $this->form_open('remove_file', ['page_method' => 'attachments']);
?>
			<div class="fileinfo"><?php
			echo '<h4>' . $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';
?>
			<table class="upload tbl_fixed">
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('UploadBy'); ?>:</th>
					<td><?php echo $this->user_link($file['user_name'], '', true, false); ?></td>
				</tr>
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('FileAdded'); ?>:</th>
					<td><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></td>
				</tr>
				<tr class="">
					<th class="form_left" scope="row"><?php echo $this->_t('FileSize'); ?>:</th>
					<td><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></td>
				</tr>
				<tr>
					<th class="form_left" scope="row"><?php echo $this->_t('FileDesc'); ?>:</th>
					<td><?php echo $file['file_description']; ?></td>
				</tr>
				<tr class="">
					<th class="form_left" scope="row"><?php echo $this->_t('FileAttachedTo'); ?>:</th>
					<td><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></td>
				</tr>
				<tr class="lined">
					<th class="form_left" scope="row"><?php echo $this->_t('FileUsage'); ?>:</th>
					<td><?php echo $this->action('fileusage', ['file_id' => $file['file_id'], 'nomark' => 1]); ?></td>
				</tr>
			</table>

			<?php
			$this->show_message($this->_t('UploadRemoveConfirm'), 'warning');
			?>

			<br />
			<input type="hidden" name="remove" value="<?php echo $_GET['remove'];?>" />
			<input type="hidden" name="file_id" value="<?php echo $_GET['file_id'];?>" />
			<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('RemoveButton'); ?>" />
			&nbsp;
			<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n"," ",$this->_t('EditCancelButton')); ?>"/></a>
			<br />
			<br />
			</div>
<?php
				echo $this->form_close();
			}
			else
			{
				$this->set_message($this->_t('FileRemoveDenied'), 'error');
			}
		}
		else
		{
			$message = $this->_t('FileNotFound');
			$this->show_message($message, 'info');
		}

		return true;
	}
	else if (isset($_GET['edit']) || isset($_GET['show'])) // show the form
	{
		$file = $get_file((int) $_GET['file_id']);

		if (count($file) > 0)
		{
			if ($file['page_id'])
			{
				$path = 'file:/' . $file['supertag'] . '/';
			}
			else
			{
				$path = 'file:/';
			}

			if (isset($_GET['show']))
			{
				// 1.b SHOW FILE PROPERTIES
				echo '<ul class="menu">' .
						'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('Attachments') . '</a></li>' .
						($can_upload
							? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
							: '') .
					"</ul>\n";

				echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('FileViewProperties') . '</h3>';
				echo '<ul class="menu">' .
							'<li class="active">' . $this->_t('FileViewProperties') . '</li>' .
							($can_upload
								?	'<li><a href="' . $this->href('attachments', '', ['edit', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('FileEditProperties') . '</a></li>' .
									// TODO: file revisions here
									'<li><a href="' . $this->href('attachments', '', ['remove', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('RemoveFile') . '</a></li>'
								: '') .
						"</ul><br />\n";

				if ($this->has_access('read', $file['page_id']))
				{
					echo '<div class="fileinfo">';

				echo '<h4>' . $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';

					// show image
					if ($file['picture_w'] || $file['file_ext'] == 'svg')
					{ ?>
						<span><?php echo $this->link($path . $file['file_name']); ?></span>
						<?php
					} ?>

					<table class="upload tbl_fixed">
						<tr>
							<th><?php echo $this->_t('FileSyntax'); ?>:</th>
							<td><?php echo '<code>' . $path . $file['file_name'] . '</code>'; ?></td>
						</tr>
						<tr>
							<th><?php echo $this->_t('UploadBy'); ?>:</th>
							<td><?php echo $this->user_link($file['user_name'], '', true, false); ?></td>
						</tr>
						<tr>
						<th><?php echo $this->_t('FileAdded'); ?>:</th>
							<td><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></td>
							</tr>
						<tr>
							<th><?php echo $this->_t('FileSize'); ?>:</th>
							<td><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></td>
						</tr>
<?php
					// image dimension
					if ($file['picture_w'])
					{ ?>
						<tr>
							<th><?php echo $this->_t('FileDimension'); ?>:</th>
							<td><?php echo $file['picture_w'] . ' × ' . $file['picture_h'] . 'px'; ?></td>
						</tr>
<?php
					} ?>
					<tr>
						<th><?php echo $this->_t('FileDesc'); ?>:</th>
						<td><?php echo $format_desc($file['file_description'], $file['file_lang']); ?></td>
					</tr>
<?php
					// image dimension
					#if ($file['picture_w'])
					#{ ?>
						<tr>
							<th><?php echo $this->_t('FileCaption'); ?>:</th>
							<td><?php echo $format_desc($file['caption'], $file['file_lang']); ?></td>
						</tr>
<?php
					#} ?>
						<tr>
							<th><?php echo $this->_t('FileAttachedTo'); ?>:</th>
							<td><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></td>
						</tr>
						<tr class="lined">
							<th class="form_left" scope="row"><?php echo $this->_t('FileUsage'); ?>:</th>
							<td><?php echo $this->action('fileusage', ['file_id' => $file['file_id'], 'nomark' => 1]); ?></td>
						</tr>
				</table>

				<br />

			<?php

				echo '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";?>
					<br />
					<br />
					</div>
<?php
				}

			}
			else if (isset($_GET['edit']))
			{
				if (   $this->is_admin()
					|| ($file['page_id']
						&& ($this->page['owner_id'] == $this->get_user_id()))
					|| ($file['user_id'] == $this->get_user_id()))
				{
					// 1.c EDIT FILE PROPERTIES

					echo '<ul class="menu">' .
							'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('Attachments') . '</a></li>' .
							($can_upload
								? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
								: '') .
						"</ul>\n";

					echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('FileEditProperties') . '</h3>';
					echo '<ul class="menu">' .
							'<li><a href="' . $this->href('attachments', '', ['show', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('FileViewProperties') . '</a></li>' .
							'<li class="active">' . $this->_t('FileEditProperties') . '</li>' .
							// file revisions here
							'<li><a href="' . $this->href('attachments', '', ['remove', 'file_id=' . (int) $_GET['file_id']]) . '">' . $this->_t('FileRemove') . '</a></li>' .
						"</ul><br />\n";

					// !!!!! patch link to not show pictures when not needed
					$path2 = str_replace('file:/', '_file:/', $path);

					echo $this->form_open('upload_file', ['page_method' => 'attachments']);
?>
					<div class="fileinfo">
					<?php
					echo '<h4>' . $this->link($path2 . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';
					?>
					<table class="upload">
						<tr>
							<th><?php echo $this->_t('FileDesc'); ?>:</th>
							<td><input type="text" maxlength="250" name="file_description" id="UploadDesc" size="80" value="<?php echo htmlspecialchars($file['file_description'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>"/></td>
						</tr>
						<tr>
							<th><?php echo $this->_t('FileCaption'); ?>:</th>
							<td><textarea id="file_caption" name="caption" rows="6" cols="70"><?php echo htmlspecialchars($file['caption'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?></textarea></td>
						</tr>
					</table>
					<br />

					<input type="hidden" name="edit" value="<?php echo $_GET['edit']?>" />
					<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
					<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('EditStoreButton'); ?>" />
					&nbsp;
					<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n", " ", $this->_t('EditCancelButton')); ?>"/></a>
					<br />
					<br />
					</div>
<?php
					echo $this->form_close();
				}
				else
				{
					$this->set_message($this->_t('FileEditDenied'));
				}
			}
		}
		else
		{
			$message = $this->_t('FileNotFound');
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
						"DELETE FROM " . $this->db->table_prefix . "file " .
						"WHERE file_id = '" . $file['file_id'] . "'" );

					// update user uploads count
					$this->db->sql_query(
						"UPDATE " . $this->db->user_table . " SET " .
							"total_uploads = total_uploads - 1 " .
						"WHERE user_id = '" . $file['user_id'] . "' " .
						"LIMIT 1");

					$message .= $this->_t('FileRemovedFromDB') . '<br />';

					// remove from FS
					$real_filename = ($file['page_id']
						? UPLOAD_PER_PAGE_DIR . '/@' . $file['page_id'] . '@'
						: UPLOAD_GLOBAL_DIR . '/') .
						$file['file_name'];

					if (@unlink($real_filename))
					{
						$message .= $this->_t('FileRemovedFromFS');
					}
					else
					{
						$this->set_message($this->_t('FileRemovedFromFSError'), 'error');
					}

					if ($message)
					{
						$this->set_message($message, 'success');
					}

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
					$description	= substr($_POST['file_description'], 0, 250);
					$description	= $clean_text((string) $description);
					$caption		= $clean_text((string) $_POST['caption']);

					// update file metadata
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "file SET " .
							"file_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
							"file_description	= " . $this->db->q($description) . ", " .
							"caption			= " . $this->db->q($caption) . " " .
						"WHERE file_id = '" . $file['file_id'] . "' " .
						"LIMIT 1");

					$message .= $this->_t('FileEditedMeta') . "<br />";

					if ($message)
					{
						$this->set_message($message, 'success');
					}

					// log event
					$this->log(1, Ut::perc_replace($this->_t('LogUpdatedFileMeta', SYSTEM_LANG), $this->tag . ' ' . $this->page['title'], $file['file_name']));
					$this->db->invalidate_sql_cache();
					$this->http->redirect($this->href('attachments', '', ['show', 'file_id=' . (int) $file['file_id']]));
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
			// 3. show attachments for current page
			if ($this->has_access('read'))
			{
				echo '<ul class="menu">' .
						#'<li class="active">' . $this->_t('Attachments') . '</li>' .
						($can_upload
							? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
							: '') .
					"</ul>\n";

				if (isset($_GET['files']) && $_GET['files'] == 'global')
				{
					echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsGlobal') . '</h3>';
					echo '<ul class="menu">' .
							'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('AttachmentsToPage') . '</a></li>' .
							'<li class="active">' . $this->_t('AttachmentsGlobal') . '</li>' .
							'<li><a href="' . $this->href('attachments', '', ['files=all']) . '">' . $this->_t('AttachmentsAll') . '</a></li>' .
						"</ul><br /><br />\n";

					echo $this->action('files', ['global' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'global']]) . '<br />';
				}
				else if (isset($_GET['files']) && $_GET['files'] == 'all')
				{
					echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsAll') . '</h3>';
					echo '<ul class="menu">' .
							'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('AttachmentsToPage') . '</a></li>' .
							'<li><a href="' . $this->href('attachments', '', ['files=global']) . '">' . $this->_t('AttachmentsGlobal') . '</a></li>' .
							'<li class="active">' . $this->_t('AttachmentsAll') . '</li>' .
						"</ul><br /><br />\n";

					echo $this->action('files', ['all' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'all']]) . '<br />';
				}
				else
				{
					echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsToPage') . '</h3>';
					echo '<ul class="menu">' .
							'<li class="active">' . $this->_t('AttachmentsToPage') . '</li>' .
							'<li><a href="' . $this->href('attachments', '', ['files=global']) . '">' . $this->_t('AttachmentsGlobal') . '</a></li>' .
							'<li><a href="' . $this->href('attachments', '', ['files=all']) . '">' . $this->_t('AttachmentsAll') . '</a></li>' .
						"</ul><br /><br />\n";

					echo $this->action('files', ['picture' => 1, 'nomark' => 1, 'method' => 'attachments']) . '<br />';
				}

				echo '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";
			}
		}
	}

#}

