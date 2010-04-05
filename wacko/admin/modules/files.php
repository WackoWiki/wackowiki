<?php

########################################################
##   Global Files                                     ##
########################################################

$module['files'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'files',
		'name'	=> 'Global files',
		'title'	=> 'Manage the global configuration file',
	);

########################################################

function admin_files(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	$user = strtolower($engine->GetUserId());

	if (isset($_GET['remove'])) // show the form
	{
		$what = $engine->LoadAll(
			"SELECT user_id, upload_id, filename, filesize, description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND filename='".quote($engine->dblink, $_GET['file'])."'");

		if (sizeof($what) > 0)
		{
			echo '<strong>'.$engine->GetTranslation('UploadRemoveConfirm').'</strong>';
			echo $engine->FormOpen();
?>
	<br />
	<ul>
		<li><?php echo $engine->Link( 'file:'.$_GET['file'] ); ?></li>
	</ul>
	<br />
	<input type="hidden" name="remove" value="<?php echo $_GET["remove"]?>" />
	<input type="hidden" name="file" value="<?php echo $_GET["file"]?>" />
	<input id="submit" name="submit" type="submit" value="<?php echo $engine->GetTranslation('RemoveButton'); ?>" />
	<input id="button" type="button" value="<?php echo str_replace("\n", ' ', $engine->GetTranslation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes(rawurldecode($engine->href('upload')))?>';" />
	<br /><br />
<?php
			echo $engine->FormClose();
		}
		else print($engine->GetTranslation('UploadFileNotFound'));

		echo '</div>';
		return true;

	}
	else if (isset($_POST['remove'])) // delete
	{
		// 1. where, existence
		$what = $engine->LoadAll(
			"SELECT user_id, upload_id, filename, filesize, description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND filename='".quote($engine->dblink, $_POST['file'])."'");

		if (sizeof($what) > 0)
		{
			// 2. remove from DB
			$engine->Query(
				"DELETE FROM ".$engine->config['table_prefix']."upload ".
				"WHERE upload_id = '". quote($engine->dblink, $what[0]['upload_id'])."'");

			print('<br />');
			print('<div><em>'.$engine->GetTranslation('UploadRemovedFromDB').'</em></div>');

			// 3. remove from FS
			$real_filename = $engine->config['upload_path'].'/'.$what[0]['filename'];

			if (@unlink($real_filename))
				print('<div><em>'.$engine->GetTranslation('UploadRemovedFromFS').'</em></div><br /><br /> ');
			else
				print('<div class="error">'.$engine->GetTranslation('UploadRemovedFromFSError').'</div><br /><br /> ');

			$engine->Log(1, str_replace('%2', $what[0]['filename'], str_replace('%1', $engine->tag.' global storage', $engine->GetTranslation('LogRemovedFile'))));
		}
		else
		{
			print($engine->GetTranslation('UploadRemoveNotFound'));
		}

	}
	else // process upload
	{
		$user	= $engine->GetUserId();
		$files	= $engine->LoadAll(
			"SELECT upload_id ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE user_id = '".quote($engine->dblink, $user['user_id'])."'");

		if (is_uploaded_file($_FILES['file']['tmp_name'])) // there is file
		{
			// 1. check out $data
			$_data	= explode('.', $_FILES['file']['name'] );
			$ext	= $_data[ sizeof($_data)-1 ];
			unset($_data[ sizeof($_data)-1 ]);
			$name	= implode( '.', $_data );
			$name	= str_replace('@', '_', $name);
			$dir	= $engine->config['upload_path'].'/';
			$banned	= explode('|', $engine->config['upload_banned_exts']);

			if (in_array(strtolower($ext), $banned)) $ext = $ext.'.txt';

			$_name	= $name;
			$count	= 1;
			while (file_exists($dir.$name.'.'.$ext))
			{
				if ($name === $_name)
					$name	= $_name.$count;
				else
					$name	= $_name.(++$count);
			}

			$result_name	= $name.'.'.$ext;
			$file_size		= $_FILES['file']['size'];

			// 1.6. check filesize, if asked
			$maxfilesize	= $engine->config['upload_max_size'];

			if ($_POST['maxsize'])
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
			$description = substr(quote($engine->dblink, $_POST['description']),0,250);
			$description = rtrim( $description, '\\' );
			$description = str_replace(array('"', "'", '<', '>'), '', $description);
			$description = htmlspecialchars($description);

			// 5. insert line into DB
			$engine->Query("INSERT INTO {$engine->config['table_prefix']}upload SET ".
				"page_id		= '".quote($engine->dblink, '0')."', ".
				"filename		= '".quote($engine->dblink, $small_name)."', ".
				"description	= '".quote($engine->dblink, $description)."', ".
				"filesize		= '".quote($engine->dblink, $file_size)."',".
				"picture_w		= '".quote($engine->dblink, $size[0])."',".
				"picture_h		= '".quote($engine->dblink, $size[1])."',".
				"file_ext		= '".quote($engine->dblink, substr($ext, 0, 10))."',".
				"user_id		= '".quote($engine->dblink, $user['user_id'])."',".
				"uploaded_dt	= '".quote($engine->dblink, date('Y-m-d H:i:s'))."' ");

			// 4. output link to file
			// !!!!! write after providing filelink syntax
			echo '<strong>'.$engine->GetTranslation('UploadDone').'</strong>';

			// log event
			$engine->Log(4, str_replace('%3', ceil($file_size / 1024), str_replace('%2', $small_name, $engine->GetTranslation('LogFileUploadedGlobal'))));
?>
<br /><ul>
<li><?php echo $engine->Link( 'file:'.$small_name ); ?></li>
</ul><br />
<?php

		} //!is_uploaded_file
		else
		{
			if ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE)
				$error = $engine->GetTranslation('UploadMaxSizeReached');
			else if ($_FILES['file']['error'] == UPLOAD_ERR_PARTIAL || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
				$error = $engine->GetTranslation('UploadNoFile');
			else
				$error = ' ';
		}
	}
	if ($error)
		echo $error.'<br /><br />';

	// displaying
	echo $engine->FormOpen('', '', 'post', '', ' enctype="multipart/form-data" ');

?>
	<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?php echo $engine->GetTranslation('UploadFor');?>:&nbsp;</td>
			<td nowrap="nowrap"><input name="file" type="file"  />&nbsp;(Unlimited)</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="font-size:11px">
				<div>
				<input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="toUploadGlobalDisabled" />
				<input type="hidden" name="to" value="global" />
				<?php echo $engine->GetTranslation('UploadGlobalText'); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $engine->GetTranslation('UploadDesc');?>:&nbsp;</td>
			<td><input name="description" type="text" size="40" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div style="padding-top:5px">
				<input id="submit" type="submit" value="<?php echo $engine->GetTranslation('UploadButtonText'); ?>" />
				</div>
			</td>
		</tr>
	</table>
<?php
	echo $engine->FormClose();

	echo '<br />';

	$orderby = 'filename ASC';
	if ($order == 'time')		$orderby = 'uploaded_dt DESC';
	if ($order == 'size')		$orderby = 'filesize ASC';
	if ($order == 'size_desc')	$orderby = 'filesize DESC';
	if ($order == 'ext')		$orderby = 'file_ext ASC';

	// load files list
	$files = $engine->LoadAll(
		"SELECT upload_id, page_id, user_id, filesize, picture_w, picture_h, filename, description, uploaded_dt ".
		"FROM {$engine->config['table_prefix']}upload ".
		"WHERE page_id = 0 ".
		"ORDER BY ".$orderby);

	if (!is_array($files)) $files = array();

	print('<fieldset><legend>'.$engine->GetTranslation('UploadTitleGlobal').":</legend>\n");

	// display
	$kb		= $engine->GetTranslation('UploadKB');
	$del	= $engine->GetTranslation('UploadRemove');
	$path	= '';
	$path2	= 'file:';

	// !!!!! patch link not to show pictures when not needed
	if (!$pictures)	$path2 = str_replace('file:', '_file:', $path2);

	if (count($files))
	{
?>
		<table class="upload" cellspacing="0" cellpadding="0" border="0">
<?php
	}

	foreach($files as $file)
	{
		$engine->filesCache[$file['page_id']][$file['filename']] = &$file;

		$dt		= $file['uploaded_dt'];
		$desc	= $engine->Format($file['description'], 'typografica');

		if ($desc == '') $desc = '&nbsp;';

		$filename	= $file['filename'];
		$filesize	= ceil($file['filesize'] / 1024);
		$fileext	= substr($filename, strrpos($filename, '.') + 1);
		$link		= $engine->Link($path2.$filename, '', $filename);
		$remove_href = $engine->tag.'&amp;remove=global&amp;file='.$filename;
?>
		<tr>
			<td style=""><?php echo $link; ?> (<?php echo $filesize; ?> <?php echo $kb; ?>)</td>
			<td><?php echo $desc ?></td>
			<td style="white-space:nowrap;"><?php echo $dt ?></td>
			<td><a href="<?php echo $remove_href; ?>"><?php echo $engine->GetTranslation('RemoveButton') ?></a></td>
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

	echo "</fieldset>\n";

}

?>