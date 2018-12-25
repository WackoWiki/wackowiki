<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// allow only sane page - not comment or forum - in
$this->ensure_page();

if (!($this->is_owner() || $this->is_admin()))
{
	$this->set_message($this->_t('ACLAccessDenied'), 'error');
	$this->show_must_go_on();
}

// check if upload is allowed for user
$upload = $this->db->upload;
$upload_allowed = ($upload === true || $upload == 1 || $this->check_acl($this->get_user_name(), $upload));

if (@$_POST['_action'] === 'set_permissions')
{
	if (($uid = $_POST['new_owner_id']))
	{
		if ($this->is_admin())
		{
			// admin can benefit to any possible user
			$new_owner = $this->db->load_single(
				"SELECT u.user_id, u.user_name, u.email, u.email_confirm, u.enabled, s.user_lang " .
				"FROM " . $this->db->user_table . " u " .
					"LEFT JOIN " . $this->db->table_prefix . "user_setting s ON (u.user_id = s.user_id) " .
				"WHERE u.user_id = " . (int) $uid . " " .
				"LIMIT 1");
		}
		else
		{
			$new_owner = $this->load_user('', $uid);
		}

		if (!$new_owner)
		{
			$this->set_message(Ut::perc_replace($this->_t('ACLNoNewOwner'), $uid), 'error');
			$this->reload_me();
		}

		// assigned as system page, forward message to Admin
		if ($new_owner['user_name'] === 'System')
		{
			$new_owner['email']		= $this->db->admin_email;
			$new_owner['user_lang']	= $this->db->language;
		}

		// where we collect new pages for emailing to user
		$new_owner['owned'] = '';
	}
	else
	{
		$new_owner = false;
	}

	$uid = $this->get_user_id();

	$update_page = function ($page) use (&$new_owner, $upload_allowed, $uid)
	{
		$pid = $page['page_id'];

		// store lists
		$this->save_acl($pid, 'read',		$_POST['read_acl']);
		$this->save_acl($pid, 'write',		$_POST['write_acl']);
		$this->save_acl($pid, 'comment',	$_POST['comment_acl']);
		$this->save_acl($pid, 'create',		$_POST['create_acl']);

		if ($upload_allowed)
		{
			$this->save_acl($pid, 'upload', $_POST['upload_acl']);
		}

		// log event
		$this->log(2, Ut::perc_replace($this->_t('LogACLUpdated', SYSTEM_LANG), $page['tag'] . ' ' . $page['title']));

		// Change permissions for all comments on this page
		// TODO: need to rethink/redo
		$comments = $this->db->load_all(
			"SELECT page_id " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE comment_on_id = " . (int) $pid . " " .
				"AND owner_id= " . (int) $uid); // STS ?? for admin too?

		foreach ($comments as $comment)
		{
			$this->save_acl($comment['page_id'], 'read', $_POST['read_acl']);
			# $this->save_acl($comment['page_id'], 'write', );
			# $this->save_acl($comment['page_id'], 'comment', );

			// change owner?
			// TODO: set optional new owner but only if the comment belongs to selected old user
			# if ($new_owner = $_new_owner)
			# {
			# 	$new_owner_id = $this->get_user_id($new_owner);
			#	$this->set_page_owner($comment['page_id'], $new_owner_id);
			# }
		}

		// change owner?
		if ($new_owner && ($new_id = (int) $new_owner['user_id']) != ($former_id = (int) $page['owner_id']))
		{
			// update user statistics
			$this->db->sql_query(
				"UPDATE " . $this->db->user_table . " SET " .
					"total_pages	= total_pages - 1 " .
				"WHERE user_id		= " . (int) $former_id . " " .
				"LIMIT 1");

			$this->db->sql_query(
				"UPDATE " . $this->db->user_table . " SET " .
					"total_pages	= total_pages + 1 " .
				"WHERE user_id		= " . (int) $new_id." " .
				"LIMIT 1");

			// set new owner
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page SET " .
					"owner_id = " . (int) $new_id . " " .
				"WHERE page_id = " . (int) $pid . " " .
				"LIMIT 1");

			$new_owner['owned'] .= $this->href('', $page['tag']) . "\n";

			// log event
			$this->log(2, Ut::perc_replace($this->_t('LogOwnershipChanged', SYSTEM_LANG),
					$page['tag'] . ' ' . $page['title'],
					$new_owner['user_name']));
		}
	};


	if (!isset($_POST['massacls']))
	{
		$update_page($this->page);
	}
	else
	{
		$pages = $this->db->load_all(
			"SELECT page_id, tag, title, owner_id " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE (supertag = " . $this->db->q($this->supertag) .
				" OR supertag LIKE " . $this->db->q($this->supertag . '/%') .
				") " .
			($this->is_admin()
				? ""
				: "AND owner_id = " . (int) $uid));

		foreach ($pages as $page)
		{
			$update_page($page);
		}
	}

	$message = $this->_t('ACLUpdated');

	if ($new_owner && $new_owner['owned'])
	{
		if ($this->db->enable_email
			&& $this->db->enable_email_notification
			&& $new_owner['enabled']
			&& !$new_owner['email_confirm'])
		{
			$this->notify_new_owner($new_owner);
		}

		$message .= $this->_t('ACLGaveOwnership') . '<code>' . $new_owner['user_name'] . '</code>';
	}

	// purge SQL queries cache
	$this->db->invalidate_sql_cache();

	$this->set_message($message, 'success');
	$this->show_must_go_on();
}

$pid = $this->page['page_id'];

// load acls
$read_acl		= $this->load_acl($pid, 'read',		1, 0);
$write_acl		= $this->load_acl($pid, 'write',	1, 0);
$comment_acl	= $this->load_acl($pid, 'comment',	1, 0);
$create_acl		= $this->load_acl($pid, 'create',	1, 0);

if ($upload_allowed)
{
	$upload_acl	= $this->load_acl($pid, 'upload',	1, 0);
}

// show form
$tpl->title		= Ut::perc_replace($this->_t('ACLFor'), $this->compose_link_to_page($this->tag, '', ''));

$tpl->read		= Ut::html($read_acl['list']);
$tpl->write		= Ut::html($write_acl['list']);
$tpl->comment	= Ut::html($comment_acl['list']);
$tpl->create	= Ut::html($create_acl['list']);

// check if upload is available for user
if ($upload_allowed)
{
	$tpl->u_upload = $upload_acl['list'];
}

if (($users = $this->load_users()))
{
	// TODO and if there're TONS of users? maybe simple text entry, not menu?
	foreach ($users as $user)
	{
		$tpl->l_user = $user;
	}
}

