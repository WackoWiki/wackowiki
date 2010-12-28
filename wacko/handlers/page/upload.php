<div id="page">
<?php

$is_global		= '';
$message		= '';
$error			= '';
$registered		= '';

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}

if ($user = $this->get_user())
{
	$user = strtolower($this->get_user_name());
	$registered = true;
}
else
{
	$user = GUEST;
}

if ($registered
	&&
	(
	($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
	($this->check_acl($user, $this->config['upload']))
	)
	&&
	($this->has_access('write') && $this->has_access('read') || ($_POST['to'] == 'global'))
	)
{
	if (isset($_GET['remove'])) // show the form
	{
		if ($_GET['remove'] == 'global')
		{
			$page_id = 0;
		}
		else
		{
			$page_id = $this->page['page_id'];
		}

		$what = $this->load_all(
			"SELECT f.user_id, u.user_name AS user, f.upload_id, f.file_name, f.file_size, f.description, f.uploaded_dt ".
			"FROM ".$this->config['table_prefix']."upload f ".
				"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
			"WHERE f.page_id = '".quote($this->dblink, $page_id)."'".
				"AND f.upload_id ='".quote($this->dblink, $_GET['file_id'])."'");

		if (sizeof($what) > 0)
		{
			if ($this->is_admin() || (
				$page_id && (
				$this->page['owner_id'] == $this->get_user_id())) || (
				$what[0]['user_id'] == $this->get_user_id()))
			{
				echo "<strong>".$this->get_translation('UploadRemoveConfirm')."</strong>";
				echo $this->form_open('upload');
				// !!!!! place here a reference to delete files
?>
	<br />
	<ul class="upload">
		<li><?php echo $this->link('file:'.$what[0]['file_name'] ); ?>
			<ul>
				<li><?php echo $this->get_time_string_formatted($what[0]['uploaded_dt']); ?></li>
				<li><?php echo "(".$this->binary_multiples($what[0]['file_size'], true, true, true).")"; ?></li>
				<li><?php echo $what[0]['file_name']; ?></li>
				<li><?php echo $what[0]['description']; ?></li>
			</ul>
		</li>
	</ul>
	<br />
	<input type="hidden" name="remove" value="<?php echo $_GET['remove']?>" />
	<input type="hidden" name="file_id" value="<?php echo $_GET['file_id']?>" />
	<input name="submit" type="submit" value="<?php echo $this->get_translation('RemoveButton'); ?>" />
	&nbsp;
	<input type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
	<br />
	<br />
<?php
				echo $this->form_close();
			}
			else
			{
				$this->set_message($this->get_translation('UploadRemoveDenied'));
			}
		}
		else
		{
			echo $this->get_translation('UploadFileNotFound');
		}

		echo "</div>";
		return true;
	}
	else
	{
		if (isset($_POST['remove'])) // delete
		{
			// 1. where, existence
			if ($_POST['remove'] == 'global')
			{
				$page_id = 0;
			}
			else
			{
				$page_id = $this->page['page_id'];
			}

			$what = $this->load_all(
				"SELECT f.user_id, u.user_name AS user, f.upload_id, f.file_name, f.file_size, f.description ".
				"FROM ".$this->config['table_prefix']."upload f ".
					"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
				"WHERE f.page_id = '".quote($this->dblink, $page_id)."'".
					"AND f.upload_id ='".quote($this->dblink, $_POST['file_id'])."'");

			if (sizeof($what) > 0)
			{
				if ($this->is_admin() || (
					$page_id && (
					$this->page['owner_id'] == $this->get_user_id())) || (
					$what[0]['user_id'] == $this->get_user_id()))
				{
					// 2. remove from DB
					$this->query(
						"DELETE FROM ".$this->config['table_prefix']."upload ".
						"WHERE upload_id = '". quote($this->dblink, $what[0]['upload_id'])."'" );

					$message .= $this->get_translation('UploadRemovedFromDB')."<br />";

					// 3. remove from FS
					$real_filename = ($page_id
						? ($this->config['upload_path_per_page'].'/@'.$page_id.'@')
						: ($this->config['upload_path'].'/')).
						$what[0]['file_name'];

					if (@unlink($real_filename))
					{
						$message .= $this->get_translation('UploadRemovedFromFS');
					}
					else
					{
						$message .= "<div class=\"error\">".$this->get_translation('UploadRemovedFromFSError')."</div>";
					}

					if ($message)
					{
						$this->set_message($message);
					}

					// log event
					$this->log(1, str_replace('%2', $what[0]['file_name'], str_replace('%1', $this->tag.' '.$this->page['title'], $this->get_translation('LogRemovedFile', $this->config['language']))));
				}
				else
				{
					$this->set_message($this->get_translation('UploadRemoveDenied'));
				}
			}
			else
			{
				$this->set_message($this->get_translation('UploadRemoveNotFound'));
			}
		}
		else // process upload
		{
			$user = $this->get_user();
			$files = $this->load_all(
				"SELECT SUM(file_size) AS used_quota ".
				"FROM ".$this->config['table_prefix']."upload ".
				"WHERE user_id = '".quote($this->dblink, $user['user_id'])."'");

			// Checks
			if (!isset($this->config['upload_path_per_page']))
			{
			}
			if (!isset($this->config['upload_path']))
			{
			}

			// 1. upload quota
			if (!$this->config['upload_quota_per_user'] || ($files[0]['used_quota'] < $this->config['upload_quota_per_user']))
			{
				if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) // there is file
				{
					// 1. check out $data
					$_data	= explode('.', $_FILES['file']['name']);
					$ext	= $_data[ sizeof($_data)-1 ];
					unset($_data[ sizeof($_data)-1 ]);

					// 3. extensions
					$ext	= strtolower($ext);
					$banned = explode('|', $this->config['upload_banned_exts']);

					if (in_array($ext, $banned))
					{
						$ext = $ext.'.txt';
					}

					$name	= implode( '.', $_data );
					$name	= str_replace('@', '_', $name);

					// here would be place for translit
					$name = $this->format($name, 'translit');

					// 1.5. +write @page_id@ to name
					if (isset($_POST['to']) && $_POST['to'] != 'global')
					{
						$name = '@'.$this->page['page_id'].'@'.$name;
					}
					else
					{
						$is_global = 1;
					}

					if ($is_global)
					{
						$dir = $this->config['upload_path'].'/';
					}
					else
					{
						$dir = $this->config['upload_path_per_page'].'/';
					}

					$_name = $name;
					$count = 1;
					while (file_exists($dir.$name.'.'.$ext))
					{
						if ($name === $_name)
						{
							$name = $_name.$count;
						}
						else
						{
							$name = $_name.(++$count);
						}
					}

					$result_name	= $name.'.'.$ext;
					$file_size		= $_FILES['file']['size'];

					// 1.6. check filesize, if asked
					$maxfilesize = $this->config['upload_max_size'];

					if (isset($_POST['maxsize']))
					{
						if ($maxfilesize > 1 * $_POST['maxsize'])
						{
							$maxfilesize = 1 * $_POST['maxsize'];
						}
					}

					if ($file_size < $maxfilesize * 1024)
					{
						// 1.7. check is image, if asked
						$forbid		= 0;
						$size		= array(0, 0);
						$src		= $_FILES['file']['tmp_name'];
						$size		= @getimagesize($src);

						if ($this->config['upload_images_only'])
						{
							if ($size[0] == 0)
							{
								$forbid = 1;
							}
						}
						if (!$forbid)
						{
							// 3. save to permanent location
							move_uploaded_file($_FILES['file']['tmp_name'],
							$dir.$result_name);
							chmod( $dir.$result_name, 0644 );

							if ($is_global)
							{
								$small_name = $result_name;
							}
							else
							{
								$small_name = explode('@', $result_name);
								$small_name = $small_name[ sizeof($small_name) -1 ];
							}

							$file_size_kb	= ceil($file_size / 1024);
							$uploaded_dt	= date('Y-m-d H:i:s');

							$description = substr(quote($this->dblink, $_POST['description']),0,250);
							$description = rtrim( $description, '\\' );

							// Make HTML in the description redundant ;¬)
							$description = $this->format($description, 'pre_wacko');
							$description = $this->format($description, 'safehtml');
							$description = htmlentities($description, ENT_COMPAT, $this->get_charset());

							// 5. insert line into DB
							$this->query(
								"INSERT INTO ".$this->config['table_prefix']."upload SET ".
									"page_id		= '".quote($this->dblink, $is_global ? "0" : $this->page['page_id'])."', ".
									"user_id		= '".quote($this->dblink, $user['user_id'])."',".
									"file_name		= '".quote($this->dblink, $small_name)."', ".
									"description	= '".quote($this->dblink, $description)."', ".
									"file_size		= '".quote($this->dblink, $file_size)."',".
									"picture_w		= '".quote($this->dblink, $size[0])."',".
									"picture_h		= '".quote($this->dblink, $size[1])."',".
									"file_ext		= '".quote($this->dblink, substr($ext, 0, 10))."',".
									"uploaded_dt	= '".quote($this->dblink, $uploaded_dt)."' ");

							// 4. output link to file
							// !!!!! write after providing filelink syntax
							$this->set_message("<strong>".$this->get_translation('UploadDone')."</strong>");

							// log event
							if ($is_global)
							{
								$this->log(4, str_replace('%3', $file_size_kb, str_replace('%2', $small_name, $this->get_translation('LogFileUploadedGlobal', $this->config['language']))));
							}
							else
							{
								$this->log(4, str_replace('%3', $file_size_kb, str_replace('%2', $small_name, str_replace('%1', $this->page['tag']." ".$this->page['title'], $this->get_translation('LogFileUploadedLocal', $this->config['language'])))));
							}
							?>
		<br />
		<ul class="upload">
			<li><?php echo $this->link('file:'.$small_name); ?>
				<ul>
					<li><?php echo $this->get_time_string_formatted($uploaded_dt); ?></li>
					<li><?php echo "(".$file_size_kb." ".$this->get_translation('UploadKB').")"; ?></li>
					<li><?php echo $small_name; ?></li>
					<li><?php echo $description; ?></li>
				</ul>
			</li>
		</ul>
		<br />
	<?php

						}
						else //forbid
						{
							$error = $this->get_translation('UploadNotAPicture');
						}
					}
					else //maxsize
					{
						$error = $this->get_translation('UploadMaxSizeReached');
					}
				} //!is_uploaded_file
				else
				{
					if (isset($_FILES['file']['error']) && ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE))
					{
						$error = $this->get_translation('UploadMaxSizeReached');
					}
					else if (isset($_FILES['file']['error']) && ($_FILES['file']['error'] == UPLOAD_ERR_PARTIAL || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE))
					{
						$error = $this->get_translation('UploadNoFile');
					}
					else
					{
						$error = '';
					}
				}
			}
			else
			{
				$error = $this->get_translation('UploadMaxFileQuota').'. <br />Storage in use '.$this->binary_multiples($files[0]['used_quota'], true, true, true).' ('.round(($files[0]['used_quota']/$this->config['upload_quota_per_user']*100), 2).'%) of '.$this->binary_multiples($this->config['upload_quota_per_user'], true, true, true);
			}
		}
		if ($error)
		{
			$this->set_message("<div class=\"error\">".$error."</div>");
		}

		echo $this->action('upload', array())."<br />";

	// if (!$error) echo "<br /><hr />".$this->action('upload', array())."<hr /><br />";
	}
}
else
{
	$this->set_message($this->get_translation('UploadForbidden'));
}
// show uploaded files for current page
if ($this->has_access('read'))
{
	echo $this->action('files', array())."<br />";
}

if (!$this->config['revisions_hide_cancel'])
{
	echo "<input type=\"button\" value=\"".$this->get_translation('CancelDifferencesButton')."\" onclick=\"document.location='".addslashes($this->href(''))."';\" />\n";
}

?>
</div>