<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}
// and for forum page
else if ($this->forum === true && !$this->is_admin())
{
	$this->redirect($this->href());
}

if ($this->is_owner() || $this->is_admin())
{
	// check who u are, can u upload?
	if ($user = $this->get_user())
	{
		$user_name	= strtolower($this->get_user_name());
	}
	else
	{
		$user_name		= GUEST;
	}

	// check if upload is allowed for user
	if (   $this->config['upload'] === true
		|| $this->config['upload'] == 1
		|| $this->check_acl($user_name, $this->config['upload'])
	)
	{
		$upload_allowed = true;
	}
	else
	{
		$upload_allowed = false;
	}

	if (!empty($_POST))
	{
		// check form token
		if (!$this->validate_form_token('set_permissions'))
		{
			$error = $this->get_translation('FormInvalid');
			$this->set_message($error, 'error');

			$this->redirect($this->href('permissions'));
		}
		else
		{
			$_read_acl		= isset($_POST['read_acl'])		? $_POST['read_acl']	: '';
			$_write_acl		= isset($_POST['write_acl'])	? $_POST['write_acl']	: '';
			$_comment_acl	= isset($_POST['comment_acl'])	? $_POST['comment_acl']	: '';
			$_create_acl	= isset($_POST['create_acl'])	? $_POST['create_acl']	: '';

			if ($upload_allowed == true)
			{
				$_upload_acl	= isset($_POST['upload_acl']) ? $_POST['upload_acl'] : '';
			}

			$_new_owner_id	= isset($_POST['new_owner_id']) ? $_POST['new_owner_id'] : '';

			// acls for page or entire cluster
			$need_massacls	= 0;

			if (isset($_POST['massacls']) && $_POST['massacls'] == 'on')
			{
				$need_massacls = 1;
			}

			// acls page
			if ($need_massacls == 0)
			{
				// store lists
				$this->save_acl($this->page['page_id'], 'read',		$_read_acl);
				$this->save_acl($this->page['page_id'], 'write',	$_write_acl);
				$this->save_acl($this->page['page_id'], 'comment',	$_comment_acl);
				$this->save_acl($this->page['page_id'], 'create',	$_create_acl);

				if ($upload_allowed == true)
				{
					$this->save_acl($this->page['page_id'], 'upload', $_upload_acl);
				}

				// log event
				$this->log(2, str_replace('%1', $this->page['tag']." ".$this->page['title'], $this->get_translation('LogACLUpdated', $this->config['language'])));

				// Change permissions for all comments on this page
				$comments = $this->load_all(
					"SELECT page_id ".
					"FROM ".$this->config['table_prefix']."page ".
					"WHERE comment_on_id = '".$this->page['page_id']."' ".
						"AND owner_id='".$this->get_user_id()."'");

				foreach ($comments as $num => $comment)
				{
					$this->save_acl($comment['page_id'], 'read',		$_read_acl);
					#$this->save_acl($comment['page_id'], 'write',		$_write_acl);
					#$this->save_acl($comment['page_id'], 'comment',	$_comment_acl);

					// change owner?
					// TODO: set optional new owner but only if the comment belongs to selected old user
					#if ($new_owner = $_new_owner)
					#{
					#	$new_owner_id = $this->get_user_id($new_owner);
					#	$this->set_page_owner($comment['page_id'], $new_owner_id);
					#}
				}

				$message = $this->get_translation('ACLUpdated');

				// change owner?
				if ($new_owner_id = $_new_owner_id)
				{
					// check user exists
					$user = $this->load_single(
						"SELECT u.user_id, u.user_name, u.email, u.email_confirm, s.user_lang ".
						"FROM {$this->config['user_table']} u ".
							"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
						"WHERE u.user_id = '".(int)$new_owner_id."' ".
						"LIMIT 1");

					if ($user == true)
					{
						$new_owner		= $user['user_name'];

						// update user statistics
						if ($owner_id = $this->page['owner_id'])
						{
							$this->sql_query(
								"UPDATE {$this->config['user_table']} SET ".
									"total_pages	= total_pages - 1 ".
								"WHERE user_id		= '".(int)$owner_id."' ".
								"LIMIT 1");
						}

						$this->sql_query(
							"UPDATE {$this->config['user_table']} SET ".
								"total_pages	= total_pages + 1 ".
							"WHERE user_id		= '".(int)$new_owner_id."' ".
							"LIMIT 1");

						$this->set_page_owner($this->page['page_id'], $new_owner_id);

						if (   $this->config['enable_email'] == true
							&& $this->config['enable_email_notification'] == true
							&& $user['email_confirm'] == '')
						{
							$subject	= $this->get_translation('NewPageOwnership');
							$body		.= str_replace('%2', $this->config['site_name'],
										   str_replace('%1', $this->get_user_name(), $this->get_translation('YouAreNewOwner')))."\n";
							$body		.= $this->href('', $this->tag, '')."\n\n";
							$body		.= $this->get_translation('PageOwnershipInfo')."\n";

							$this->send_user_email($new_owner, $user['email'], $subject, $body, $user['user_lang']);
						}

						// log event
						$this->log(2, str_replace('%2', $new_owner, str_replace('%1', $this->page['tag']." ".$this->page['title'], $this->get_translation('LogOwnershipChanged', $this->config['language']))));

						$message .= $this->get_translation('ACLGaveOwnership').'<code>'.$new_owner.'</code>';
					}
					else
					{
						// new owner doesn't exists
						$message .= str_replace('%1', $new_owner, $this->get_translation('ACLNoNewOwner'));
						$this->set_message($message);
						$this->redirect($this->href('permissions'));
					}
				}
			}

			// acls for entire cluster
			else if ($need_massacls == 1)
			{
				$pages = $this->load_all("
					SELECT p.page_id, p.tag, p.title ".
					"FROM ".$this->config['table_prefix']."page p ".
					"WHERE (p.supertag = '".quote($this->dblink, $this->supertag)."'".
						" OR p.supertag LIKE '".quote($this->dblink, $this->supertag."/%")."'".
						") ".
					($this->is_admin()
						? ""
						: "AND p.owner_id = '".$this->get_user_id()."'"));

				foreach ($pages as $num => $page)
				{
					// store lists
					$this->save_acl($page['page_id'], 'read',		$_read_acl);
					$this->save_acl($page['page_id'], 'write',		$_write_acl);
					$this->save_acl($page['page_id'], 'comment',	$_comment_acl);
					$this->save_acl($page['page_id'], 'create',		$_create_acl);

					if ($upload_allowed == true)
					{
						$this->save_acl($page['page_id'], 'upload', $_upload_acl);
					}

					// log event
					$this->log(2, str_replace('%1', $page['tag']." ".$page['title'], $this->get_translation('LogACLUpdated', $this->config['language'])));

					// Change permissions for all comments on this page
					$comments = $this->load_all(
						"SELECT page_id ".
						"FROM ".$this->config['table_prefix']."page ".
						"WHERE comment_on_id = '".$page['page_id']."' ".
							"AND owner_id='".$this->get_user_id()."'");

					foreach ($comments as $num => $comment)
					{
						$this->save_acl($comment['page_id'], 'read', $_read_acl);
						#$this->save_acl($comment['page_id'], 'write', $_write_acl);
						#$this->save_acl($comment['page_id'], 'comment', $_comment_acl);

						// change owner?
						// TODO: set optional new owner but only if the comment belongs to selected old user
						#if ($new_owner = $_new_owner)
						#{
						#	$new_owner_id = $this->get_user_id($new_owner);
						#	$this->set_page_owner($comment['page_id'], $new_owner_id);
						#}
					}

					// change owner?
					if ($new_owner_id = $_new_owner_id)
					{
						$this->set_page_owner($page['page_id'], $new_owner_id);
						$ownedpages .= $this->href('', $page['tag'])."\n";

						// log event
						$this->log(2, str_replace('%2', $user['user_name'], str_replace('%1', $page['tag']." ".$page['title'], $this->get_translation('LogOwnershipChanged', $this->config['language']))));
					}
				}

				$message = $this->get_translation('ACLUpdated');

				if ($new_owner_id = $_new_owner_id)
				{
					$user = $this->load_single(
						"SELECT u.user_id, u.user_name, u.email, u.email_confirm, s.userlang ".
						"FROM {$this->config['user_table']} u ".
							"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
						"WHERE u.user_id = '".(int)$new_owner_id."' ".
						"LIMIT 1");

					if ($this->config['enable_email'] == true && $this->config['enable_email_notification'] == true && $user['email_confirm'] == '')
					{
						$subject	= $this->get_translation('NewPageOwnership');
						$body		.= str_replace('%2', $this->config['site_name'],
									   str_replace('%1', $this->get_user_name(), $this->get_translation('YouAreNewOwner')))."\n";
						$body		.= $this->href('', $this->tag, '')."\n\n";
						$body		.= $this->get_translation('PageOwnershipInfo')."\n";

						$this->send_user_email($new_owner, $user['email'], $subject, $body, $user['user_lang']);
					}

					$message .= $this->get_translation('ACLGaveOwnership').$user['user_name'];
				}
			}

			// redirect back to page
			$this->set_message($message, 'success');

			// purge SQL queries cache
			if ($this->config['cache_sql'])
			{
				$this->cache->invalidate_sql_cache();
			}

			$this->redirect($this->href());
		}
	}
	else
	{
		// load acls
		$read_acl		= $this->load_acl($this->page['page_id'], 'read',		1, 0);
		$write_acl		= $this->load_acl($this->page['page_id'], 'write',		1, 0);
		$comment_acl	= $this->load_acl($this->page['page_id'], 'comment',	1, 0);
		$create_acl		= $this->load_acl($this->page['page_id'], 'create',		1, 0);

		if ($upload_allowed == true)
		{
			$upload_acl		= $this->load_acl($this->page['page_id'], 'upload', 1, 0);
		}

		// show form
?>
<h3><?php echo str_replace('%1', $this->compose_link_to_page($this->tag, '', '', 0), $this->get_translation('ACLFor')); ?></h3>
<?php
echo $this->form_open('set_permissions', 'permissions', '', true);

echo '<input type="checkbox" id="massacls" name="massacls" />';
echo '<label for="massacls">'.$this->get_translation('AclForEntireCluster').'</label>'; ?>
<br />
<div class="cssform">
<p>
	<label for="read_acl"><strong><?php echo $this->get_translation('ACLRead'); ?></strong></label>
	<textarea id="read_acl" name="read_acl" rows="4" cols="20"><?php echo $read_acl['list'] ?></textarea>
</p>
<p>
	<label for="write_acl"><strong><?php echo $this->get_translation('ACLWrite'); ?></strong></label>
	<textarea id="write_acl" name="write_acl" rows="4" cols="20"><?php echo $write_acl['list'] ?></textarea>
</p>
<p>
	<label for="comment_acl"><strong><?php echo $this->get_translation('ACLComment'); ?></strong></label>
	<textarea id="comment_acl" name="comment_acl" rows="4" cols="20"><?php echo $comment_acl['list'] ?></textarea>
</p>
<p>
	<label for="create_acl"><strong><?php echo $this->get_translation('ACLCreate'); ?></strong></label>
	<textarea id="create_acl" name="create_acl" rows="4" cols="20"><?php echo $create_acl['list'] ?></textarea>
</p>
<?php
// check if upload is available for user
if ($upload_allowed == true)
{ ?>
<p>
	<label for="upload_acl"><strong><?php echo $this->get_translation('ACLUpload'); ?></strong></label>
	<textarea id="upload_acl" name="upload_acl" rows="4" cols="20"><?php echo $upload_acl['list'] ?></textarea>
</p>
<?php } ?>
<p>
	<label for="new_owner_id"><strong><?php echo $this->get_translation('SetOwner'); ?></strong></label>
	<select id="new_owner_id" name="new_owner_id">
		<option value=""><?php echo $this->get_translation('OwnerDontChange'); ?></option>
	<?php
			if ($users = $this->load_users())
			{
				foreach($users as $user)
				{
					echo '<option value="'.$user['user_id'].'">'.htmlspecialchars($user['user_name'])."</option>\n";
				}
			}
	?>
	</select>
</p>
<p>
	<input type="submit" class="OkBtn" id="submit" value="<?php echo $this->get_translation('ACLStoreButton'); ?>" accesskey="s" /> &nbsp;
	<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" id="button" value="<?php echo $this->get_translation('ACLCancelButton'); ?>"/></a>
</p>
</div>
<?php
		echo $this->form_close();
	}
}
else
{
	$message = $this->get_translation('ACLAccessDenied');
	$this->show_message($message, 'info');
}

?>
</div>