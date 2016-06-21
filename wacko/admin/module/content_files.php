<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Uploaded Files                                   ##
########################################################

$module['content_files'] = array(
		'order'	=> 360,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_files',
		'name'	=> 'Files',
		'title'	=> 'Manage uploaded files',
	);

########################################################

function admin_content_files(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	$user = $engine->get_user_id();

	if (isset($_GET['remove'])) // show the form
	{
		$file = $engine->load_single(
			"SELECT user_id, upload_id, file_name, file_size, upload_lang, file_description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND upload_id = '".(int)$_GET['file_id']."' ".
			"LIMIT 1");

		if (count($file) > 0)
		{
			echo '<strong>'.$engine->get_translation('UploadRemoveConfirm').'</strong>';
			echo $engine->form_open();
?>
	<br />
	<ul>
		<li><?php echo $engine->link( 'file:'.$file['file_name'] ); ?></li>
	</ul>
	<br />
	<input type="hidden" name="remove" value="<?php echo $_GET['remove']?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
	<input type="submit" id="submit" name="submit" value="<?php echo $engine->get_translation('RemoveButton'); ?>" />
	<a href="<?php echo rawurldecode($engine->href('upload'));?>" style="text-decoration: none;"><input type="button" id="button" value="<?php echo str_replace("\n", ' ', $engine->get_translation('EditCancelButton')); ?>"/></a>
	<br /><br />
<?php
			echo $engine->form_close();
		}
		else
		{
			$engine->show_message($engine->get_translation('UploadFileNotFound'));
		}

		echo '</div>';
		return true;
	}
	else if (isset($_POST['remove'])) // delete
	{
		// 1. where, existence
		$file = $engine->load_single(
			"SELECT user_id, upload_id, file_name, file_size, upload_lang, file_description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND upload_id = '".(int)$_POST['file_id']."' ".
			"LIMIT 1");

		if (count($file) > 0)
		{
			// 2. remove from DB
			$engine->sql_query(
				"DELETE FROM ".$engine->config['table_prefix']."upload ".
				"WHERE upload_id = '". $file['upload_id']."'");

			// update user uploads count
			$engine->sql_query(
				"UPDATE {$engine->config['user_table']} ".
				"SET total_uploads = total_uploads - 1 ".
				"WHERE user_id = '".$file['user_id']."' ".
				"LIMIT 1");

			echo '<br />';
			$message =  '<em>'.$engine->get_translation('UploadRemovedFromDB').'</em><br />';

			// 3. remove from FS
			$real_filename = $engine->config['upload_path'].'/'.$file['file_name'];

			if (@unlink($real_filename))
			{
				$message .= '<em>'.$engine->get_translation('UploadRemovedFromFS').'</em>';
				$engine->show_message($message);
			}
			else
			{
				$message = $engine->get_translation('UploadRemovedFromFSError');
				$engine->show_message($message, 'error');
			}

			$engine->log(1, str_replace('%2', $file['file_name'], str_replace('%1', $engine->tag.' global storage', $engine->get_translation('LogRemovedFile', $engine->config['language']))));
		}
		else
		{
			$message = $engine->get_translation('UploadRemoveNotFound');
			$engine->show_message($message);
		}

	}
	else // process upload
	{
		$user	= $engine->get_user();
		$files	= $engine->load_all(
			"SELECT upload_id ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE user_id = '".$user['user_id']."'");

		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) // there is file
		{
			// 1. check out $data
			$_data	= explode('.', $_FILES['file']['name'] );
			$ext	= $_data[ count($_data)-1 ];
			unset($_data[ count($_data)-1 ]);
			$name	= implode( '.', $_data );
			$name	= str_replace('@', '_', $name);
			// here would be place for translit
			$name = $engine->format($name, 'translit');

			$dir	= $engine->config['upload_path'].'/';
			$banned	= explode('|', $engine->config['upload_banned_exts']);

			if (in_array(strtolower($ext), $banned))
			{
				$ext = $ext.'.txt';
			}

			$_name	= $name;
			$count	= 1;

			while (file_exists($dir.$name.'.'.$ext))
			{
				if ($name === $_name)
				{
					$name	= $_name.$count;
				}
				else
				{
					$name	= $_name.(++$count);
				}
			}

			$result_name	= $name.'.'.$ext;
			$file_size		= $_FILES['file']['size'];

			// 1.6. check filesize, if asked
			$maxfilesize	= $engine->config['upload_max_size'];

			if (isset($_POST['maxsize']))
				if ($maxfilesize > 1 * $_POST['maxsize'])
					$maxfilesize = 1 * $_POST['maxsize'];

			// 1.7. check is image, if asked
			$size	= array(0, 0);
			$src	= $_FILES['file']['tmp_name'];
			$size	= @getimagesize($src);

			// 3. save to permanent location
			move_uploaded_file($_FILES['file']['tmp_name'], $dir.$result_name);
			chmod( $dir.$result_name, 0744 );

			$small_name  = $result_name;
			$description = substr(quote($engine->dblink, $_POST['file_description']), 0, 250);
			$description = rtrim( $description, '\\' );
			$description = str_replace(array('"', "'", '<', '>'), '', $description);
			$description = htmlspecialchars($description, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);

			// 5. insert line into DB
			$engine->sql_query("INSERT INTO {$engine->config['table_prefix']}upload SET ".
				"page_id			= '".'0'."', ".
				"file_name			= '".quote($engine->dblink, $small_name)."', ".
				"upload_lang				= '".quote($engine->dblink, $engine->config['language'])."', ".
				"file_description	= '".quote($engine->dblink, $description)."', ".
				"file_size			= '".(int)$file_size."',".
				"picture_w			= '".(int)$size[0]."',".
				"picture_h			= '".(int)$size[1]."',".
				"file_ext			= '".quote($engine->dblink, substr($ext, 0, 10))."',".
				"user_id			= '".(int)$user['user_id']."',".
				"uploaded_dt		= '".quote($engine->dblink, date('Y-m-d H:i:s'))."' ");

			// 4. output link to file
			// !!!!! write after providing filelink syntax
			echo '<strong>'.$engine->get_translation('UploadDone').'</strong>';

			// log event
			$engine->log(4, str_replace('%3', $engine->binary_multiples($file_size, false, true, true), str_replace('%2', $small_name, $engine->get_translation('LogFileUploadedGlobal', $engine->config['language']))));
?>
<br /><ul>
<li><?php echo $engine->link( 'file:'.$small_name ); ?></li>
</ul><br />
<?php

		} //!is_uploaded_file
		else
		{
			if (isset($_FILES['file']['error']))
			{
				if ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE)
				{
					$error = $engine->get_translation('UploadMaxSizeReached');
				}
				else if ($_FILES['file']['error'] == UPLOAD_ERR_PARTIAL || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
				{
					$error = $engine->get_translation('UploadNoFile');
				}
			}

			else
			{
				$error = '';
			}
		}
	}
	if ($error)
	{
		$engine->show_message($error, 'error');
	}

	// displaying
	echo $engine->form_open('files', '', 'post', true, '', ' enctype="multipart/form-data" ');

?>
	<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
	<table >
		<tr>
			<td><?php echo $engine->get_translation('UploadFor');?>:&nbsp;</td>
			<td nowrap="nowrap"><input type="file" name="file" />&nbsp;(Unlimited)</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="font-size:11px">
				<div>
				<input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="toUploadGlobalDisabled" />
				<input type="hidden" name="to" value="global" />
				<?php echo $engine->get_translation('UploadGlobalText'); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $engine->get_translation('UploadDesc');?>:&nbsp;</td>
			<td><input type="text" name="file_description" size="40" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div style="padding-top:5px">
				<input type="submit" id="submit" value="<?php echo $engine->get_translation('UploadButtonText'); ?>" />
				</div>
			</td>
		</tr>
	</table>
<?php
	echo $engine->form_close();

	echo '<br />';

	$order_by = 'file_name ASC';
	if ($order == 'time')		$order_by = 'uploaded_dt DESC';
	if ($order == 'size')		$order_by = 'file_size ASC';
	if ($order == 'size_desc')	$order_by = 'file_size DESC';
	if ($order == 'ext')		$order_by = 'file_ext ASC';
	$limit	= 50;
	$owner = ''; // TODO: show owner in list and add filter
	$global = true;

	$count = $engine->load_all(
			"SELECT f.upload_id ".
			"FROM ".$engine->config['table_prefix']."upload f ".
				"INNER JOIN ".$engine->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
			"WHERE f.page_id = '". ($global ? 0 : '')."' ".
	($owner
	? "AND u.user_name = '".quote($engine->dblink, $owner)."' "
	: ''), true);

	$count		= count($count);
	$pagination = $engine->pagination($count, $limit, 'f','mode='.$module['mode'], '', 'admin.php');

	// load files list
	$files = $engine->load_all(
		"SELECT upload_id, page_id, user_id, file_size, picture_w, picture_h, file_ext, file_name, file_description, uploaded_dt ".
		"FROM {$engine->config['table_prefix']}upload ".
		"WHERE page_id = 0 ".
		"ORDER BY ".$order_by." ".
		"LIMIT {$pagination['offset']}, {$limit}");

	if (!is_array($files))
	{
		$files = array();
	}

	echo '<fieldset><legend>'.$engine->get_translation('UploadTitleGlobal').":</legend>\n";

	// display
	$del	= $engine->get_translation('UploadRemove');
	$path	= '';
	$path2	= 'file:';

	// !!!!! patch link not to show pictures when not needed
	if (!isset($picture))	$path2 = str_replace('file:', '_file:', $path2);

	// pagination
	$show_pagination = $engine->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

	// pagination
	echo $show_pagination;

	if (count($files))
	{
?>
		<table class="upload" >
<?php
	}

	foreach($files as $file)
	{
		$engine->files_cache[$file['page_id']][$file['file_name']] = $file;

		$dt		= $file['uploaded_dt'];
		$desc	= $engine->format($file['file_description'], 'typografica');

		if ($desc == '') $desc = '&nbsp;';

		$file_id	= $file['upload_id'];
		$file_name	= $file['file_name'];
		$file_size	= $engine->binary_multiples($file['file_size'], false, true, true);
		$file_ext	= substr($file_name, strrpos($file_name, '.') + 1);
		$link		= $engine->link($path2.$file_name, '', $file_name);
		$remove_href = $engine->tag.'&amp;remove=global&amp;file_id='.$file['upload_id'];
?>
		<tr class="hl_setting">
			<td style=""><?php echo $link; ?></td>
			<td>(<?php echo $file_size; ?>)</td>
			<td><?php echo $desc ?></td>
			<td style="white-space:nowrap;"><?php echo $engine->get_time_formatted($dt) ?></td>
			<td><a href="<?php echo $remove_href; ?>"><?php echo $engine->get_translation('RemoveButton') ?></a></td>
		</tr>
		<tr class="lined">
			<td colspan="4"></td>
		</tr>
<?php
	}

	if (count($files))
	{
?>
		</table>
<?php
	}

	// pagination
	echo $show_pagination;

	echo "</fieldset>\n";

}

?>