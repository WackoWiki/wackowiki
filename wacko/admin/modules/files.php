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
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	$user = strtolower($engine->get_user_id());

	if (isset($_GET['remove'])) // show the form
	{
		$what = $engine->load_all(
			"SELECT user_id, upload_id, file_name, file_size, description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND file_name='".quote($engine->dblink, $_GET['file'])."'");

		if (sizeof($what) > 0)
		{
			echo '<strong>'.$engine->get_translation('UploadRemoveConfirm').'</strong>';
			echo $engine->form_open();
?>
	<br />
	<ul>
		<li><?php echo $engine->link( 'file:'.$_GET['file'] ); ?></li>
	</ul>
	<br />
	<input type="hidden" name="remove" value="<?php echo $_GET['remove']?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
	<input id="submit" name="submit" type="submit" value="<?php echo $engine->get_translation('RemoveButton'); ?>" />
	<input id="button" type="button" value="<?php echo str_replace("\n", ' ', $engine->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes(rawurldecode($engine->href('upload')))?>';" />
	<br /><br />
<?php
			echo $engine->form_close();
		}
		else
		{
			print($engine->get_translation('UploadFileNotFound'));
		}

		echo '</div>';
		return true;
	}
	else if (isset($_POST['remove'])) // delete
	{
		// 1. where, existence
		$what = $engine->load_all(
			"SELECT user_id, upload_id, file_name, file_size, description ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = 0 ".
				"AND file_name='".quote($engine->dblink, $_POST['file_id'])."'");

		if (sizeof($what) > 0)
		{
			// 2. remove from DB
			$engine->query(
				"DELETE FROM ".$engine->config['table_prefix']."upload ".
				"WHERE upload_id = '". quote($engine->dblink, $what[0]['upload_id'])."'");

			print('<br />');
			print('<div><em>'.$engine->get_translation('UploadRemovedFromDB').'</em></div>');

			// 3. remove from FS
			$real_filename = $engine->config['upload_path'].'/'.$what[0]['filename'];

			if (@unlink($real_filename))
			{
				print('<div><em>'.$engine->get_translation('UploadRemovedFromFS').'</em></div><br /><br /> ');
			}
			else
			{
				print('<div class="error">'.$engine->get_translation('UploadRemovedFromFSError').'</div><br /><br /> ');
			}

			$engine->log(1, str_replace('%2', $what[0]['file_name'], str_replace('%1', $engine->tag.' global storage', $engine->get_translation('LogRemovedFile', $engine->config['language']))));
		}
		else
		{
			print($engine->get_translation('UploadRemoveNotFound'));
		}

	}
	else // process upload
	{
		$user	= $engine->get_user_id();
		$files	= $engine->load_all(
			"SELECT upload_id ".
			"FROM {$engine->config['table_prefix']}upload ".
			"WHERE user_id = '".quote($engine->dblink, $user['user_id'])."'");

		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) // there is file
		{
			// 1. check out $data
			$_data	= explode('.', $_FILES['file']['name'] );
			$ext	= $_data[ sizeof($_data)-1 ];
			unset($_data[ sizeof($_data)-1 ]);
			$name	= implode( '.', $_data );
			$name	= str_replace('@', '_', $name);
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
			$description = substr(quote($engine->dblink, $_POST['description']),0,250);
			$description = rtrim( $description, '\\' );
			$description = str_replace(array('"', "'", '<', '>'), '', $description);
			$description = htmlspecialchars($description);

			// 5. insert line into DB
			$engine->query("INSERT INTO {$engine->config['table_prefix']}upload SET ".
				"page_id		= '".quote($engine->dblink, '0')."', ".
				"file_name		= '".quote($engine->dblink, $small_name)."', ".
				"description	= '".quote($engine->dblink, $description)."', ".
				"file_size		= '".quote($engine->dblink, $file_size)."',".
				"picture_w		= '".quote($engine->dblink, $size[0])."',".
				"picture_h		= '".quote($engine->dblink, $size[1])."',".
				"file_ext		= '".quote($engine->dblink, substr($ext, 0, 10))."',".
				"user_id		= '".quote($engine->dblink, $user['user_id'])."',".
				"uploaded_dt	= '".quote($engine->dblink, date('Y-m-d H:i:s'))."' ");

			// 4. output link to file
			// !!!!! write after providing filelink syntax
			echo '<strong>'.$engine->get_translation('UploadDone').'</strong>';

			// log event
			$engine->log(4, str_replace('%3', ceil($file_size / 1024), str_replace('%2', $small_name, $engine->get_translation('LogFileUploadedGlobal', $engine->config['language']))));
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
		echo $error.'<br /><br />';
	}

	// displaying
	echo $engine->form_open('', '', 'post', '', ' enctype="multipart/form-data" ');

?>
	<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?php echo $engine->get_translation('UploadFor');?>:&nbsp;</td>
			<td nowrap="nowrap"><input name="file" type="file"  />&nbsp;(Unlimited)</td>
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
			<td><input name="description" type="text" size="40" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div style="padding-top:5px">
				<input id="submit" type="submit" value="<?php echo $engine->get_translation('UploadButtonText'); ?>" />
				</div>
			</td>
		</tr>
	</table>
<?php
	echo $engine->form_close();

	echo '<br />';

	$orderby = 'file_name ASC';
	if ($order == 'time')		$orderby = 'uploaded_dt DESC';
	if ($order == 'size')		$orderby = 'file_size ASC';
	if ($order == 'size_desc')	$orderby = 'file_size DESC';
	if ($order == 'ext')		$orderby = 'file_ext ASC';

	// load files list
	$files = $engine->load_all(
		"SELECT upload_id, page_id, user_id, file_size, picture_w, picture_h, file_ext, file_name, description, uploaded_dt ".
		"FROM {$engine->config['table_prefix']}upload ".
		"WHERE page_id = 0 ".
		"ORDER BY ".$orderby);

	if (!is_array($files)) $files = array();

	print('<fieldset><legend>'.$engine->get_translation('UploadTitleGlobal').":</legend>\n");

	// display
	$del	= $engine->get_translation('UploadRemove');
	$path	= '';
	$path2	= 'file:';

	// !!!!! patch link not to show pictures when not needed
	if (!isset($pictures))	$path2 = str_replace('file:', '_file:', $path2);

	if (count($files))
	{
?>
		<table class="upload" cellspacing="0" cellpadding="0" border="0">
<?php
	}

	foreach($files as $file)
	{
		$engine->filesCache[$file['page_id']][$file['file_name']] = &$file;

		$dt		= $file['uploaded_dt'];
		$desc	= $engine->format($file['description'], 'typografica');

		if ($desc == '') $desc = '&nbsp;';

		$file_id	= $file['upload_id'];
		$file_name	= $file['file_name'];
		$file_size	= $engine->binary_multiples($file['file_size'], true, true, true);
		$file_ext	= substr($file_name, strrpos($file_name, '.') + 1);
		$link		= $engine->link($path2.$file_name, '', $file_name);
		$remove_href = $engine->tag.'&amp;remove=global&amp;file_id='.$file_name;
?>
		<tr>
			<td style=""><?php echo $link; ?></td>
			<td>(<?php echo $file_size; ?>)</td>
			<td><?php echo $desc ?></td>
			<td style="white-space:nowrap;"><?php echo $dt ?></td>
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

	echo "</fieldset>\n";

}

?>