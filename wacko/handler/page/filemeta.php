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
	$file = $this->db->load_single(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_lang, f.file_size, f.file_description, f.caption, f.uploaded_dt, f.modified_dt, f.picture_w, f.picture_h, f.file_ext, f.mime_type, u.user_name, p.supertag, p.title " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
		"WHERE f.file_id ='" . (int) $file_id . "' " .
		"LIMIT 1", true);

	return $file;
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
	#$string = $this->format($string, 'wacko'); //
	$string = $this->format($string, 'safehtml'); //
	#$string = htmlspecialchars($string, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET, $this->get_charset()); // breaks html unicode chars

	return $string;
};

$message		= '';
$error			= '';
$can_upload		= $this->can_upload();

$this->ensure_page(true); // TODO: upload for forums?

// check who u are, can u upload?
#if ($this->can_upload())
#{
	$file = $get_file((int) @$_GET['file_id']);

	$mod_selector	= 'm';
	// tab navigation
	$tabs['show']	= 'FileViewProperties';

	if ($this->is_admin()
		|| ($file['page_id']
			&& $this->page['owner_id'] == $this->get_user_id())
		|| $file['user_id'] == $this->get_user_id())
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
	echo $meta_navigation($can_upload);
	echo '<h3>' . $this->_t('File') . ' &raquo; ' . $this->_t($tabs[$mode]) . '</h3>';
	echo $this->tab_menu($tabs, $mode, 'filemeta', ['file_id' => $file['file_id']], $mod_selector);
	echo "<br>\n";

	// 1. SHOW FORMS
	if ($mode == 'remove' && isset($file))
	{
		// 1.a REMOVE FILE CONFIRMATION

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

				echo $this->form_open('remove_file', ['page_method' => 'filemeta']);
?>
			<div class="fileinfo"><?php
			echo '<h4>' . $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';
?>
			<table class="upload tbl_fixed">
				<tr>
					<th scope="row"><?php echo $this->_t('UploadBy'); ?>:</th>
					<td><?php echo $this->user_link($file['user_name'], '', true, false); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php echo $this->_t('FileAdded'); ?>:</th>
					<td><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php echo $this->_t('FileSize'); ?>:</th>
					<td><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></td>
				</tr>
				<tr>
					<th scope="row"><?php echo $this->_t('FileDesc'); ?>:</th>
					<td><?php echo $file['file_description']; ?></td>
				</tr>
				<tr>
					<th scope="row"><?php echo $this->_t('FileAttachedTo'); ?>:</th>
					<td><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php echo $this->_t('FileUsage'); ?>:</th>
					<td><?php echo $this->action('fileusage', ['file_id' => $file['file_id'], 'nomark' => 1]); ?></td>
				</tr>
			</table>

			<?php
			$this->show_message($this->_t('FileRemoveConfirm'), 'warning');
			?>

			<br>
			<input type="hidden" name="remove" value="">
			<input type="hidden" name="file_id" value="<?php echo $file['file_id'];?>">
			<?php
			if ($this->db->store_deleted_pages && $this->is_admin())
			{
				echo '<input type="checkbox" id="dontkeep" name="dontkeep">';
				echo '<label for="dontkeep">' . $this->_t('RemoveDontKeepFile') . '</label><br>';
				echo '<br>';
			}
			?>
			<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('RemoveButton'); ?>">
			&nbsp;
			<a href="<?php echo $this->href();?>" class="btn_link"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n"," ",$this->_t('EditCancelButton')); ?>"></a>
			<br>
			<br>
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
	else if ($mode == 'label' && isset($file))
	{
		// 1.b LABEL FILE

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

				// !!!!! patch link to not show pictures when not needed
				$path2 = str_replace('file:/', '_file:/', $path);

				echo '<h4>' . $this->link($path2 . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';

				echo $this->form_open('store_categories', ['page_method' => 'filemeta']);
				echo $this->show_category_form($file['file_id'], OBJECT_FILE, $file['file_lang'], false);
				echo '<input type="hidden" name="label" value="">';
				echo '<input type="hidden" name="file_id" value="' . $file['file_id'] . '">';
				echo $this->form_close();
			}
		}
		else
		{
			$message = $this->_t('FileNotFound');
			$this->show_message($message, 'info');
		}
	}
	else if (($mode == 'edit' || $mode == 'show') && isset($file))
	{

		if (count($file) > 0)
		{
			if ($file['page_id'])
			{
				$path	= 'file:/' . $file['supertag'] . '/';
				$url	= $this->href('file', trim($file['supertag'], '/'), 'get=' . $file['file_name']);
			}
			else
			{
				$path	= 'file:/';
				$url	= $this->db->base_url . Ut::join_path(UPLOAD_GLOBAL_DIR, $file['file_name']);
			}

			if ($mode == 'show')
			{
				// 1.c SHOW FILE PROPERTIES

				if ($this->has_access('read', $file['page_id']))
				{
					echo '<div class="fileinfo">';

					echo '<h4>' . $this->link($path . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';

					// show image
					if ($file['picture_w'] || $file['file_ext'] == 'svg')
					{
						echo '<span><a href="' . $url . '">' . $this->link($path . $file['file_name'], '', '', '', '', '', '', '', '', false) . '</a></span>';
					}
?>
					<table class="upload tbl_fixed">
						<tr>
							<th scope="row"><?php echo $this->_t('FileSyntax'); ?>:</th>
							<td><?php echo '<code>' . $path . $file['file_name'] . '</code>'; ?></td>
						</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('UploadBy'); ?>:</th>
							<td><?php echo $this->user_link($file['user_name'], '', true, false); ?></td>
						</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('FileAdded'); ?>:</th>
							<td><?php echo $this->get_time_formatted($file['uploaded_dt']); ?></td>
							</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('FileSize'); ?>:</th>
							<td><?php echo '' . $this->binary_multiples($file['file_size'], false, true, true) . ''; ?></td>
						</tr>
<?php
					// image dimension
					if ($file['picture_w'])
					{ ?>
						<tr>
							<th scope="row"><?php echo $this->_t('FileDimension'); ?>:</th>
							<td><?php echo $file['picture_w'] . ' &times; ' . $file['picture_h'] . 'px'; ?></td>
						</tr>
<?php
					} ?>
					<tr>
						<th scope="row"><?php echo $this->_t('MimeType'); ?>:</th>
						<td><?php echo '' . $file['mime_type'] . ''; ?></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $this->_t('FileDesc'); ?>:</th>
						<td><?php echo $format_desc($file['file_description'], $file['file_lang']); ?></td>
					</tr>
<?php
					// image dimension
					#if ($file['picture_w'])
					#{ ?>
						<tr>
							<th scope="row"><?php echo $this->_t('FileCaption'); ?>:</th>
							<td><?php echo $format_desc($file['caption'], $file['file_lang']); ?></td>
						</tr>
<?php
					#} ?>
						<tr>
							<th scope="row"><?php echo $this->_t('FileAttachedTo'); ?>:</th>
							<td><?php echo $file['supertag']? $this->link('/' . $file['supertag'], '', $file['title'], $file['supertag']) : $this->_t('UploadGlobal'); ?></td>
						</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('FileUsage'); ?>:</th>
							<td><?php echo $this->action('fileusage', ['file_id' => $file['file_id'], 'nomark' => 1]); ?></td>
						</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('Categories'); ?>:</th>
							<td><?php echo $this->get_categories($file['file_id'], OBJECT_FILE, 'attachments', '', ['files' => 'all']); ?></td>
						</tr>

				</table>

				<br>

			<?php

				echo '<a href="' . $this->href() . '" class="btn_link"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '"></a>' . "\n";?>
					<br>
					<br>
					</div>
<?php
				}

			}
			else if ($mode == 'edit')
			{
				if (   $this->is_admin()
					|| ($file['page_id']
						&& ($this->page['owner_id'] == $this->get_user_id()))
					|| ($file['user_id'] == $this->get_user_id()))
				{
					// 1.d EDIT FILE PROPERTIES

					// !!!!! patch link to not show pictures when not needed
					$path2 = str_replace('file:/', '_file:/', $path);

					echo $this->form_open('upload_file', ['page_method' => 'filemeta']);
?>
					<div class="fileinfo">
					<?php
					echo '<h4>' . $this->link($path2 . $file['file_name'], '', $this->shorten_string($file['file_name'])) . '</h4>';
					?>
					<table class="upload">
						<tr>
							<th scope="row"><?php echo $this->_t('FileDesc'); ?>:</th>
							<td><input type="text" maxlength="250" name="file_description" id="UploadDesc" size="80" value="<?php echo htmlspecialchars($file['file_description'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php echo $this->_t('FileCaption'); ?>:</th>
							<td><textarea id="file_caption" name="caption" rows="6" cols="70"><?php echo htmlspecialchars($file['caption'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?></textarea></td>
						</tr>
							<tr>
						<th scope="row">
							<label for="file_lang"><?php echo $this->_t('YourLanguage');?></label>
						</th>
						<td>
							<select id="file_lang" name="file_lang">
				<?php

					$languages = $this->_t('LanguageArray');

					if ($this->db->multilanguage)
					{
						$langs = $this->available_languages();
					}
					else
					{
						$langs = [$this->db->language];
					}

					foreach ($langs as $lang)
					{
						echo '<option value="' . $lang . '"' .
							($file['file_lang'] == $lang
								? ' selected '
								: (!isset($file['file_lang']) && $this->db->language == $lang
									? ' selected'
									: '')
							) . '>' . $languages[$lang] . ' (' . $lang . ")</option>\n";
					}
				?>
							</select>
						</td>
					</tr>
					</table>
					<br>

					<input type="hidden" name="edit" value="<?php #echo $_GET['edit']; ?>">
					<input type="hidden" name="file_id" value="<?php echo (int) $_GET['file_id']?>">
					<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('EditStoreButton'); ?>">
					&nbsp;
					<a href="<?php echo $this->href();?>" class="btn_link"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n", " ", $this->_t('EditCancelButton')); ?>"></a>
					<br>
					<br>
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

			$this->log(4, 'Updated page categories [[/' . $this->tag . ' ' . $this->page['title'] . ']]');
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
					$description	= substr($_POST['file_description'], 0, 250);
					$description	= $clean_text((string) $description);
					$caption		= $clean_text((string) $_POST['caption']);
					$file_lang		= isset($_POST['file_lang']) ? $_POST['file_lang'] : $file['file_lang'];

					// update file metadata
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "file SET " .
							"file_lang			= " . $this->db->q($file_lang) . ", " .
							"file_description	= " . $this->db->q($description) . ", " .
							"caption			= " . $this->db->q($caption) . ", " .
							"modified_dt		= UTC_TIMESTAMP() " .
						"WHERE file_id = '" . $file['file_id'] . "' " .
						"LIMIT 1");

					$message .= $this->_t('FileEditedMeta') . "<br>";

					if ($message)
					{
						$this->set_message($message, 'success');
					}

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
			// 3. show attachments for current page
			if ($this->has_access('read'))
			{
				$this->http->redirect($this->href('attachments'));
			}
		}
	}

#}

