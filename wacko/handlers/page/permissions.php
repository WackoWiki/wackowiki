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
	$this->redirect($this->href('show'));
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

if ($this->user_is_owner() || $this->is_admin())
{
	if ($_POST)
	{
		$_read_acl		= isset($_POST['read_acl']) ? $_POST['read_acl'] : '';
		$_write_acl		= isset($_POST['write_acl']) ? $_POST['write_acl'] : '';
		$_comment_acl	= isset($_POST['comment_acl']) ? $_POST['comment_acl'] : '';
		$_create_acl	= isset($_POST['create_acl']) ? $_POST['create_acl'] : '';
		$_upload_acl	= isset($_POST['upload_acl']) ? $_POST['upload_acl'] : '';
		$_new_owner		= isset($_POST['new_owner']) ? $_POST['new_owner'] : '';

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
			$this->save_acl($this->page['page_id'], 'read', $_read_acl);
			$this->save_acl($this->page['page_id'], 'write', $_write_acl);
			$this->save_acl($this->page['page_id'], 'comment', $_comment_acl);
			$this->save_acl($this->page['page_id'], 'create', $_create_acl);
			$this->save_acl($this->page['page_id'], 'upload', $_upload_acl);

			// log event
			$this->log(2, str_replace('%1', $this->page['tag']." ".$this->page['title'], $this->get_translation('LogACLUpdated', $this->config['language'])));

			// Change permissions for all comments on this page
			$comments = $this->load_all(
				"SELECT page_id ".
				"FROM ".$this->config['table_prefix']."page ".
				"WHERE comment_on_id = '".quote($this->dblink, $this->page['page_id'])."' ".
					"AND owner_id='".quote($this->dblink, $this->get_user_id())."'");

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

			$message = $this->get_translation('ACLUpdated');

			// change owner?
			if ($new_owner = $_new_owner)
			{
				// check user exists
				$user = $this->load_single(
					"SELECT user_id, user_name, email, email_confirm ".
					"FROM {$this->config['user_table']} ".
					"WHERE user_id = '".quote($this->dblink, $new_owner)."' ".
					"LIMIT 1");

				if ($user == true)
				{
					$new_owner		= $user['user_name'];
					$new_owner_id	= $user['user_id'];

					// update user statistics
					if ($owner_id = $this->page['owner_id'])
					{
						$this->sql_query(
							"UPDATE {$this->config['user_table']} ".
							"SET total_pages	= total_pages		- 1 ".
							"WHERE user_id		= '".quote($this->dblink, $owner_id)."' ".
							"LIMIT 1");
					}

					$this->sql_query(
						"UPDATE {$this->config['user_table']} ".
						"SET total_pages	= total_pages		+ 1 ".
						"WHERE user_id		= '".quote($this->dblink, $new_owner_id)."' ".
						"LIMIT 1");

					$this->set_page_owner($this->page['page_id'], $new_owner_id);

					if ($this->config['enable_email'] == true && $this->config['enable_email_notification'] == true && $user['email_confirm'] == '')
					{
						$subject = $this->config['site_name'].'. '.$this->get_translation('NewPageOwnership');
						$body  = $this->get_translation('EmailHello').$new_owner.".\n\n";
						$body .= str_replace('%2', $this->config['site_name'], str_replace('%1', $this->get_user_name(), $this->get_translation('YouAreNewOwner')))."\n";
						$body .= $this->href('', $this->tag, '')."\n\n";
						$body .= $this->get_translation('PageOwnershipInfo')."\n";
						//$email .= $this->href('', '', '')."\n\n";
						$body .= $this->get_translation('EmailGoodbye')."\n".$this->config['site_name']."\n".$this->config['base_url'];
						$this->send_mail($user['email'], $subject, $body);
					}

					// log event
					$this->log(2, str_replace('%2', $new_owner, str_replace('%1', $this->page['tag']." ".$this->page['title'], $this->get_translation('LogOwnershipChanged', $this->config['language']))));

					$message .= $this->get_translation('ACLGaveOwnership').$new_owner;
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
					: "AND p.owner_id = '".quote($this->dblink, $this->get_user_id())."'"));

			foreach ($pages as $num => $page)
			{
				// store lists
				$this->save_acl($page['page_id'], 'read', $_read_acl);
				$this->save_acl($page['page_id'], 'write', $_write_acl);
				$this->save_acl($page['page_id'], 'comment', $_comment_acl);
				$this->save_acl($page['page_id'], 'create', $_create_acl);
				$this->save_acl($page['page_id'], 'upload', $_upload_acl);

				// log event
				$this->log(2, str_replace('%1', $page['tag']." ".$page['title'], $this->get_translation('LogACLUpdated', $this->config['language'])));

				// Change permissions for all comments on this page
				$comments = $this->load_all(
					"SELECT page_id ".
					"FROM ".$this->config['table_prefix']."page ".
					"WHERE comment_on_id = '".quote($this->dblink, $page['page_id'])."' ".
						"AND owner_id='".quote($this->dblink, $this->get_user_id())."'");

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
				if ($new_owner = $_new_owner)
				{
					$new_owner_id = $this->get_user_id($new_owner);
					$this->set_page_owner($page['page_id'], $new_owner_id);
					$ownedpages .= $this->href('', $page['tag'])."\n";

					// log event
					$this->log(2, str_replace('%2', $user['user_name'], str_replace('%1', $page['tag']." ".$page['title'], $this->get_translation('LogOwnershipChanged', $this->config['language']))));
				}
			}

			$message = $this->get_translation('ACLUpdated');

			if ($new_owner = $_new_owner)
			{
				$message .= $this->get_translation('ACLGaveOwnership').$new_owner;

				$user = $this->load_single(
					"SELECT email, email_confirm ".
					"FROM {$this->config['user_table']} ".
					"WHERE user_name = '".quote($this->dblink, $new_owner)."' ".
					"LIMIT 1");

				if ($this->config['enable_email'] == true && $this->config['enable_email_notification'] == true && $user['email_confirm'] == '')
				{
					$subject = $this->config['site_name'].'. '.$this->get_translation('NewPageOwnership');
					$body  = $this->get_translation('EmailHello').$new_owner.".\n\n";
					$body .= str_replace('%2', $this->config['site_name'], str_replace('%1', $this->get_user_name(), $this->get_translation('YouAreNewOwner')))."\n";
					$body .= $ownedpages."\n";
					$body .= $this->get_translation('PageOwnershipInfo')."\n";
					//$body .= $this->href('', '', '')."\n\n";
					$body .= $this->get_translation('EmailGoodbye')."\n".$this->config['site_name']."\n".$this->config['base_url'];
					$this->send_mail($user['email'], $subject, $body);
				}
			}
		}

		// redirect back to page
		$this->set_message($message.'!');

		// purge SQL queries cache
		if ($this->config['cache_sql'])
		{
			$this->cache->invalidate_sql_cache();
		}

		$this->redirect($this->href());
	}
	else
	{
		// load acls
		$read_acl		= $this->load_acl($this->page['page_id'], 'read', 1, 0);
		$write_acl		= $this->load_acl($this->page['page_id'], 'write', 1, 0);
		$comment_acl	= $this->load_acl($this->page['page_id'], 'comment', 1, 0);
		$create_acl		= $this->load_acl($this->page['page_id'], 'create', 1, 0);
		$upload_acl		= $this->load_acl($this->page['page_id'], 'upload', 1, 0);

		// show form
?>
<h3><?php echo str_replace('%1', $this->compose_link_to_page($this->tag, '', '', 0), $this->get_translation('ACLFor')); ?></h3>
<?php echo $this->form_open('permissions') ?> <?php echo "<input type=\"checkbox\" id=\"massacls\" name=\"massacls\" "; echo " /> <label for=\"massacls\">".$this->get_translation('AclForEntireCluster')."</label>"; ?>
<br />
<div class="cssform">
<p>
	<label for="read_acl"><?php echo $this->get_translation('ACLRead'); ?></label>
	<textarea id="read_acl" name="read_acl" rows="4" cols="20"><?php echo $read_acl['list'] ?></textarea>
</p>
<p>
	<label for="write_acl"><?php echo $this->get_translation('ACLWrite'); ?></label>
	<textarea id="write_acl" name="write_acl" rows="4" cols="20"><?php echo $write_acl['list'] ?></textarea>
</p>
<p>
	<label for="comment_acl"><?php echo $this->get_translation('ACLComment'); ?></label>
	<textarea id="comment_acl" name="comment_acl" rows="4" cols="20"><?php echo $comment_acl['list'] ?></textarea>
</p>
<p>
	<label for="create_acl"><?php echo $this->get_translation('ACLCreate'); ?></label>
	<textarea id="create_acl" name="create_acl" rows="4" cols="20"><?php echo $create_acl['list'] ?></textarea>
</p>
<p>
	<label for="upload_acl"><?php echo $this->get_translation('ACLUpload'); ?></label>
	<textarea id="upload_acl" name="upload_acl" rows="4" cols="20"><?php echo $upload_acl['list'] ?></textarea>
</p>

<p>
	<label for="new_owner"><?php echo $this->get_translation('SetOwner'); ?></label>
	<select id="new_owner" name="new_owner">
		<option value=""><?php echo $this->get_translation('OwnerDontChange'); ?></option>
	<?php
			if ($users = $this->load_users())
			{
				foreach($users as $user)
				{
					echo "<option value=\"".$user['user_id']."\">".htmlspecialchars($user['user_name'])."</option>\n";
				}
			}
	?>
	</select>
</p>
<p>
	<input class="OkBtn" id="submit" type="submit" value="<?php echo $this->get_translation('ACLStoreButton'); ?>" accesskey="s" /> &nbsp;
	<input class="CancelBtn" id="button" type="button" value="<?php echo $this->get_translation('ACLCancelButton'); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
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