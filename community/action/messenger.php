<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 * messenger action:
 * https://wackowiki.org/doc/Dev/PatchesHacks/WikiMessenger
 * modify the script for your needs, please contribute your improvements
 *
 * {{messenger}} (without parameters)
 *
 * requires messenger & messenger_info table in MySQL-Database
 *
 * TODO: add sorting, filters, search
 */

$prefix = $this->prefix;

$create_table = function() use ($prefix)
{
	$this->db->sql_query(
		"CREATE TABLE IF NOT EXISTS {$prefix}messenger (
			message_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_to_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			repliedto TINYINT(1) UNSIGNED DEFAULT '0',
			folder VARCHAR(255) NOT NULL DEFAULT '',
			user_from_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			urgent TINYINT(1) UNSIGNED DEFAULT NULL,
			subject VARCHAR(255) NOT NULL DEFAULT '',
			message TEXT NOT NULL,
			status TINYINT(1) UNSIGNED DEFAULT '0',
			datesent DATETIME NULL DEFAULT NULL,
			viewrecipient TINYINT(1) UNSIGNED DEFAULT '1',
		PRIMARY KEY (message_id),
		KEY idx_user_to_id (user_to_id),
		KEY idx_user_from_id (user_from_id)
	);");

	$this->db->sql_query(
		"CREATE TABLE IF NOT EXISTS {$prefix}messenger_info (
			msg_info_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			type VARCHAR(255) NOT NULL DEFAULT '',
			info VARCHAR(255) NOT NULL DEFAULT '',
			notes VARCHAR(255) NOT NULL DEFAULT '',
		PRIMARY KEY (msg_info_id),
		KEY idx_owner_id (owner_id)
	);");
};

$select_user = function($user_id, $to) use ($prefix, &$tpl)
{
	$users = $this->db->load_all(
		"SELECT user_id, user_name
		FROM {$prefix}user
		WHERE account_type = 0
		ORDER BY user_name ASC", true);

	foreach ($users as $user)
	{
		if ($user['user_id'] == $user_id)
		{
			continue;
		}

		$tpl->o_userid		= $user['user_id'];
		$tpl->o_username	= $user['user_name'];

		if ($to == $user['user_id'])
		{
			$tpl->o_selected	= ' selected';
		}
	}
};

$select_folder = function($user_id, $folder = '') use ($prefix, &$tpl)
{
	$result = $this->db->load_all(
		"SELECT DISTINCT info
		FROM {$prefix}messenger_info
		WHERE type = 'folder'
			AND owner_id = " . (int) $user_id . "
		ORDER BY info ASC", true);

	foreach ($result as $row)
	{
		$tpl->o_info = $row['info'];

		if ($folder == $row['info'])
		{
			$tpl->o_selected = ' selected';
		}
	}
};

$get_message = function($user_id, $message_id) use ($prefix)
{
	return $this->db->load_single(
		"SELECT *
		FROM {$prefix}messenger
		WHERE user_to_id = " . (int) $user_id . "
			AND message_id = " . (int) $message_id);
};

$get_contacts = function($user_id) use ($prefix)
{
	return $this->db->load_all(
		"SELECT i.info, u.user_name
		FROM {$prefix}messenger_info i
			LEFT JOIN {$prefix}user u ON (i.info = u.user_id)
		WHERE i.type = 'contact'
			AND i.owner_id = " . (int) $user_id . "
		ORDER BY i.info ASC");
};

if ($user_id = $this->get_user_id())
{
	# $create_table();
	$this->doubleclick = false;

	// needed for pagination
	$limit = 10;

	$folder			= (string)	($_GET['folder']			?? '');
	$r_msg_folder	= (string)	($_REQUEST['msg_folder']	?? '');
	$message_id		= (int)		($_GET['message_id']		?? null);
	$move2folder	= (string)	($_REQUEST['move2folder']	?? '');
	$action			= (string)	($_GET['action']			?? '');
	$to				= (int)		($_GET['to']				?? null);

	if (!$folder) {$folder = $r_msg_folder;}

	$tpl->style_n	= true;
	$tpl->enter('x_');

	$mod_selector	= 'action';
	$modes			= [
		'inbox'		=> 'Inbox',
		'compose'	=> 'Compose',
		'sent'		=> 'SentItems',
		'folders'	=> 'Folders',
		'contacts'	=> 'Contacts',
		#'users'		=> 'Users',
		#'help'		=> 'Help',
	];
	$mode			= @$_GET[$mod_selector];

	if (!array_key_exists($mode, $modes))
	{
		$mode = '';
	}

	#$tpl->h_header		= $this->_t($modes[$mode]);

	foreach ($modes as $i => $text)
	{
		if ($mode == $i)
		{
			$tpl->h_header = $this->_t($text);
			break;
		}
	}

	// print navigation
	$tpl->menu = $this->tab_menu($modes, $mode, '', [], $mod_selector);

	// drop down box to select a specific folder
	$select_folder($user_id, $r_msg_folder);

	if (! in_array($action, ['compose', 'contacts', 'delete', 'folders', 'forward', 'help', 'inbox', 'reply', 'sent', 'store', 'users']))
	{
		if ((  $action == ''
			|| $action == 'view_inbox')
			&& $r_msg_folder == '' && $folder == '')
		{
			$nav_folder		= '<a href="' . $this->href('', '', ['action' => 'inbox']) . '">' . $this->_t('Inbox') . '</a>' . ' » ' . $this->_t('Message');
		}
		else if ($action == 'view_sent')
		{
			$nav_folder		= '<a href="' . $this->href('', '', ['action' => 'sent']) . '">' . $this->_t('SentItems') . '</a>' . ' » ' . $this->_t('Message');
		}
		else if ($folder != '')
		{
			$msg_folder		= $folder;
			$nav_folder		= '<a href="' . $this->href('', '', ['action' => 'inbox']) . '">' . $this->_t('Inbox') . '</a>' .
								' » <a href="' . $this->href('', '', ['folder' => $folder]) . '" title="' . $this->_t('Folder') . '">' . Ut::html($msg_folder) . '</a>' .
								($action == 'view_inbox' ? ' » ' . $this->_t('Message') : '');
		}

		$tpl->h_header = $nav_folder;
	}

	$tpl->leave(); // x_

	// IDs PROCESSING (COMMON PROCEDURES)
	$set = [];

	if (isset($_POST['id']))
	{
		// keep currently selected list items
		foreach ($_POST['id'] as $key => $val)
		{
			if (!in_array($val, $set) && !empty($val))
			{
				$set[] = (int) $val;
			}
		}

		unset($key, $val);
	}

	// [A] code for moving messages to folders
	if ($move2folder && $set)
	{
		foreach ($set as $msg_id)
		{
			$rs = $this->db->sql_query(
			"UPDATE {$prefix}messenger SET
				folder = " . $this->db->q($move2folder) . "
			WHERE message_id = " . (int) $msg_id . "
				AND user_to_id = " . (int) $user_id);
		}

		$tpl->a_message = $rs
			? '<br>' . Ut::perc_replace($this->_t('MessageMoved'), '<b>' . Ut::html($move2folder) . '</b>')
			: $this->_t('MessageNotMoved');
	}

	// [B] shows inbox
	else if (($action == '' || $action == 'inbox')
		&& $r_msg_folder == '' && (!$folder))
	{
		$search = '';

		$selector =
			"FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . " " .
			$search . "
				AND m.folder = 'inbox'
				AND m.viewrecipient = '1' ";

		$count = $this->db->load_single(
			"SELECT COUNT(message_id) AS n " .
			$selector
			, true);

		$pagination = $this->pagination($count['n'], $limit, 'm' , ['action' => 'inbox']);

		$result = $this->db->load_all(
			"SELECT m.*, u.user_name " .
			$selector .
			"ORDER BY m.datesent DESC " .
			$pagination['limit']);

		$tpl->enter('b_');

		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $n => $row)
		{
			// sets mark for status of message (important/read/answered)
			if ($row['status'] == 1)
			{
				$tpl->status = '<span class="cite" title="' . $this->_t('MessageNotRead') . '">*</span>';
			}

			if ($row['urgent'])
			{
				$tpl->urgent = '<span class="cite" title="' . $this->_t('UrgentMessage') . '"><strong>!</strong></span>';
			}

			if ($row['repliedto'])
			{
				$tpl->replied = '<span title="' . $this->_t('MessageReplied') . '" style="color: grey;"> <strong>' . $this->_t('RepliedTo') . '</strong></span>';
			}

			$tpl->n				= $n;
			$tpl->time			= $row['datesent'];
			$tpl->msgid			= $row['message_id'];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->user_link($row['user_name'], true, false);
			$tpl->hrefview		= $this->href('', '', ['action' => 'view_inbox', 'message_id' => $row['message_id']]);

			$tpl->i_info		= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);
			$tpl->i_title		= $this->_t('Delete');
			$tpl->i_class		= 'delete';
		}

		$tpl->leave(); // n_

		// drop down box to move to a new folder
		$tpl->enter('d_');
		$select_folder($user_id);
		$tpl->leave(); // d_

		if ($count['n'] == 0)
		{
			$tpl->none = true;
		}

		$tpl->leave(); // b_
	}
	// [C] send a new message to a user
	else if ($action == 'compose')
	{
		$tpl->enter('c_');

		$tpl->hrefform		= $this->href('', '', ['action' => 'store']);
		$tpl->hrefusers		= $this->href('', '', ['action' => 'users']);
		$tpl->textarea		= true;

		$select_user($user_id, $to);

		$contacts = $get_contacts($user_id);

		foreach ($contacts as $row)
		{
			$tpl->u_username	= $row['user_name'];
			$tpl->u_hrefcompose	= $this->href('', '', ['action' => 'compose', 'to' => (int) $row['info']]);
		}

		$tpl->leave(); // c_
	}

	// [D] Send reply to the sender of a message
	else if ($action == 'reply')
	{
		$row = $get_message($user_id, $message_id);

		$user = $this->db->load_single(
			"SELECT user_id, user_name
			FROM {$prefix}user
			WHERE user_id = " . (int) $to . "
				LIMIT 1");

		$tpl->enter('d_');

		$tpl->subject			= $this->_t('Re') . ' ' . $row['subject'];
		$tpl->userid			= $user['user_id'];
		$tpl->username			= $user['user_name'];
		$tpl->hrefform			= $this->href('', '', ['action' => 'store', 'replyto' => $message_id]);
		$tpl->textarea_origmsg	=	"\n\n-------- " . $this->_t('OriginalMessage') . " --------\n" .
									strip_tags($row['message']) .
									"\n--------------------------------\n";

		$tpl->leave(); // d_
	}

	// [E] Forward message
	else if ($action == 'forward' && $message_id != '')
	{
		$row = $get_message($user_id, $message_id);

		$tpl->enter('e_');

		$tpl->subject			= $this->_t('Fwd') . ' ' . $row['subject'];
		$tpl->hrefusers			= $this->href('', '', ['action' => 'users']);
		$tpl->hrefform			= $this->href('', '', ['action' => 'store']);
		$tpl->textarea_origmsg	=	"\n\n-------- " . $this->_t('ForwardedMessage') . " --------\n" .
									strip_tags($row['message']) .
									"\n--------------------------------\n";

		$select_user($user_id, $to);

		$contacts = $get_contacts($user_id);

		foreach ($contacts as $row)
		{
			$tpl->u_username	= $row['user_name'];
			$tpl->u_hrefforward	= $this->href('', '', ['action' => 'forward', 'message_id' => $message_id, 'to' => (int) $row['info']]);
		}

		$tpl->leave(); // e_
	}

	// [F] writes sent messages (original/forwarded) to the database
	if ($action == 'store')
	{
		$urgent		= (int)		($_POST['urgent']	?? null);
		$to			= (int)		($_POST['to']		?? null);
		$replyto	= (int)		($_GET['replyto']	?? null);
		$subject	= (string)	($_POST['subject']	?? '');
		$message	= (string)	($_POST['message']	?? '');

		$subject	= strip_tags($subject);
		$message	= strip_tags($message);
		$date		= date('YmdHis');

		$tpl->enter('f_');

		// checks if the user exists and sends the message
		if ($subject == '' || $message == '' || $to == '')
		{
			$tpl->x_hrefcompose	= $this->href('', '', ['action' => 'compose']);
		}
		else
		{
			if ($this->load_user('', $to))
			{
				$user = $this->db->load_single(
					"SELECT user_id, user_name
					FROM {$prefix}user
					WHERE user_id = " . (int) $to . "
					LIMIT 1");

				$this->db->sql_query(
					"INSERT INTO {$prefix}messenger (
						user_to_id,
						folder,
						user_from_id,
						subject,
						message,
						datesent,
						status,
						urgent
					)
					VALUES (" .
						(int) $to . ", " .
						$this->db->q('inbox') . ", " .
						(int) $user_id . ", " .
						$this->db->q($subject) . ", " .
						$this->db->q($message) . ", " .
						$this->db->q($date) . ", " .
						'1' . ", " .
						(int) $urgent . "
					)");

				$tpl->sendto	= Ut::perc_replace($this->_t('MessageSentTo'), $user['user_name']);

				$this->db->sql_query(
					"UPDATE {$prefix}messenger SET
						repliedto = '1'
					WHERE message_id = " . (int) $replyto . "
						AND user_to_id = " . (int) $user_id);
			}
			else
			{
				$tpl->e_hrefcompose	= $this->href('', '', ['action' => 'compose']);
			}
		}

		$tpl->leave(); // f_
	}
	// [G] shows the "sent messages" folder
	else if ($action == 'sent')
	{
		$selector =
			"FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_to_id = u.user_id)
			WHERE m.user_from_id = " . (int) $user_id . " ";

		// count pages
		$count = $this->db->load_single(
			"SELECT COUNT(message_id) AS n " .
			$selector
			, true);

		$pagination = $this->pagination($count['n'], $limit, 'm' , ['action' => 'sent']);

		$result = $this->db->load_all(
			"SELECT m.*, u.user_name " .
			$selector .
			"ORDER BY m.datesent DESC " .
			$pagination['limit']);

		$tpl->enter('g_');

		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $row)
		{
			$tpl->time			= $row['datesent'];
			$tpl->status		= $this->_t('MessageStatus')[$row['status']];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->user_link($row['user_name'], true, false);
			$tpl->hrefview		= $this->href('', '', ['action' => 'view_sent', 'message_id' => $row['message_id']]);
		}

		$tpl->leave(); // n_
		$tpl->leave(); // g_
	}

	// [H] show selected folder
	else if (($r_msg_folder != '' || $folder) && ($action != 'view_inbox'))
	{
		$search = '';

		if ($r_msg_folder != '')
		{
			$show_folder = $r_msg_folder;
		}
		else
		{
			$show_folder = $folder;
		}

		$selector =
			"FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . " " .
			$search . "
				AND m.folder = " . $this->db->q($show_folder);

		// count pages
		$count = $this->db->load_single(
			"SELECT COUNT(message_id) AS n " .
			$selector
			, true);

		$pagination = $this->pagination($count['n'], $limit, 'm' , ['action' => 'message_folder', 'msg_folder' => $show_folder]);

		$result = $this->db->load_all(
			"SELECT m.*, u.user_name " .
			$selector .
			"ORDER BY m.datesent DESC " .
			$pagination['limit']);

		$tpl->enter('h_');

		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $n => $row)
		{
			if ($row['status'] == 1)
			{
				$tpl->status = '<span class="cite" title="' . $this->_t('MessageNotRead') . '">*</span>';
			}

			if ($row['urgent'])
			{
				$tpl->urgent = '<span class="cite" title="' . $this->_t('UrgentMessage') . '"><strong>!</strong></span>';
			}

			if ($row['repliedto'])
			{
				$tpl->replied = '<span class="cl-green" title="' . $this->_t('MessageReplied') . '"><strong>↶</strong></span>';
			}

			$tpl->n				= $n;
			$tpl->time			= $row['datesent'];
			$tpl->msgid			= $row['message_id'];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->user_link($row['user_name'], true, false);
			$tpl->hrefview		= $this->href('', '', ['action' => 'view_inbox', 'message_id' => $row['message_id'], 'folder' => $msg_folder]);

			$tpl->i_info		= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);
			$tpl->i_title		= $this->_t('Delete');
			$tpl->i_class		= 'delete';
		}

		$tpl->leave(); // n_

		// drop down box to move to a new folder
		$tpl->enter('d_');
		$select_folder($user_id);
		$tpl->leave(); // d_

		if ($count['n'] == 0)
		{
			$tpl->nomessages = '<br>' . $this->_t('NoMessagesFolder') . '<br><br>';
		}

		$tpl->leave(); // h_
	}
	// [I] view individual messages
	else if ($action == 'view_inbox')
	{
		$row = $this->db->load_single(
			"SELECT m.*, u.user_name
			FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . "
				AND m.message_id = " . (int) $message_id);

		if ($row['repliedto'])
		{
			$tpl->replied = '<span title="' . $this->_t('MessageReplied') . '"> <small>' . $this->_t('RepliedTo') . '</small></span>';
		}

		$tpl->enter('i_');

		if ($row['user_to_id'] == $user_id)
		{
			$tpl->time			= $row['datesent'];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->user_link($row['user_name'], true, false);
			$tpl->message		= strip_tags($row['message']);

			#$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_from_id']]);
			$tpl->hrefreply		= $this->href('', '', ['action' => 'reply', 'message_id' => $row['message_id'], 'to' => $row['user_from_id']]);
			$tpl->hrefforward	= $this->href('', '', ['action' => 'forward', 'message_id' => $row['message_id']]);
			$tpl->hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);

			$rs = $this->db->sql_query(
				"UPDATE {$prefix}messenger SET
					status = '2'
				WHERE message_id = " . (int) $message_id);
		}
		else
		{
			$tpl->forbidden		= $this->_t('NotYourPost');
		}

		$tpl->leave(); // i_
	}

	// [J] viewing folder sent messages
	else if ($action == 'view_sent')
	{
		$row = $this->db->load_single(
			"SELECT m.*, u.user_name
			FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_to_id = u.user_id)
			WHERE m.user_from_id = " . (int) $user_id . "
				AND m.message_id = " . (int) $message_id);

		$tpl->enter('j_');

		if ($row['user_from_id'] == $user_id)
		{
			$tpl->time			= $row['datesent'];
			$tpl->status		= $this->_t('MessageStatus')[$row['status']];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->user_link($row['user_name'], true, false);
			$tpl->message		= strip_tags($row['message']);
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_to_id']]);
		}

		$tpl->leave(); // j_
	}

	// [K] Delete messages
	else if ($action == 'delete')
	{
		if ($_POST['_action'] == 'delete_message')
		{
			$rs = $this->db->sql_query(
				"DELETE FROM {$prefix}messenger
				WHERE message_id = " . (int) $message_id);

			$this->set_message($rs
				? $this->_t('MessageDeleted')
				: $this->_t('MessageNotDeleted'));

			$this->http->redirect($this->href('', '', ['action' => 'inbox', 'folder' => $msg_folder]));
		}
		else
		{
			$tpl->k_hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $message_id]);
		}
	}

	// [L] Manage contacts list
	else if ($action == 'contacts')
	{
		$add_contact	= (int)		($_GET['contact']			?? null);
		$delete_contact	= (int)		($_GET['delete_contact']	?? null);
		$field1_value	= (string)	($_POST['field1_value']		?? '');
		$field2_value	= (string)	($_POST['field2_value']		?? '');

		$insert			= $field1_value ? true : false;
		$type			= 'contact';
		$in_list		= [];

		if ($insert)
		{
			if ($this->load_user('', $field1_value))
			{
				$this->db->sql_query(
					"INSERT INTO {$prefix}messenger_info (
						owner_id,
						info,
						notes,
						type
					)
					VALUES (" .
						(int) $user_id . ", " .
						$this->db->q($field1_value) . ", " .
						$this->db->q($field2_value) . ", " .
						$this->db->q($type) . "
					)");
			}
		}

		if ($delete_contact)
		{
			$this->db->sql_query(
				"DELETE FROM {$prefix}messenger_info
				WHERE msg_info_id = " . (int) $delete_contact . "
					AND owner_id = " . (int) $user_id);
		}

		$users = $this->db->load_all(
			"SELECT user_id, user_name
			FROM {$prefix}user
			ORDER BY user_name ASC");

		$contacts = $this->db->load_all(
			"SELECT i.msg_info_id, i.owner_id, i.type, i.info, i.notes, u.user_name
			FROM {$prefix}messenger_info i
				LEFT JOIN {$prefix}user u ON (i.info = u.user_id)
			WHERE i.owner_id = " . (int) $user_id . "
				AND i.type = " . $this->db->q($type) . "
			ORDER BY i.info ASC");

		$tpl->enter('l_');

		$tpl->hrefform		= $this->href('', '', ['action' => 'contacts']);
		$tpl->hrefusers		= $this->href('', '', ['action' => 'users']);

		foreach ($contacts as $contact)
		{
			$in_list[]				= $contact['info'];
			$tpl->c_username		= $contact['user_name'];
			$tpl->c_notes			= strip_tags($contact['notes']);
			$tpl->c_hrefcompose		= $this->href('', '', ['action' => 'compose', 'to' => $contact['info']]);
			$tpl->c_hrefdelete		= $this->href('', '', ['action' => 'contacts', 'delete_contact' => $contact['msg_info_id']]);
		}

		foreach ($users as $user)
		{
			if (!in_array($user['user_id'], $in_list))
			{
				$tpl->o_userid		= $user['user_id'];
				$tpl->o_username	= $user['user_name'];

				if ($add_contact == $user['user_id'])
				{
					$tpl->o_selected	= ' selected';
				}
			}
		}

		$tpl->leave(); // l_
	}

	// [M] Manage folders
	else if ($action == 'folders')
	{
		$delete_folder	= (int)		($_GET['delete_folder']		?? null);
		$folder			= (string)	($_GET['folder']			?? '');
		$field1_value	= (string)	($_POST['field1_value']		?? '');
		$field2_value	= (string)	($_POST['field2_value']		?? '');

		$insert			= $field1_value ? true : false;
		$type			= 'folder';

		if ($insert)
		{
			$this->db->sql_query(
				"INSERT INTO {$prefix}messenger_info (
					owner_id,
					info,
					notes,
					type
				)
				VALUES (" .
					(int) $user_id . ", " .
					$this->db->q($field1_value) . ", " .
					$this->db->q($field2_value) . ", " .
					$this->db->q($type) . "
				)");
		}

		if ($delete_folder)
		{
			// delete folder name from messenger_info
			$this->db->sql_query(
				"DELETE FROM {$prefix}messenger_info
				WHERE msg_info_id = " . (int) $delete_folder . "
					AND owner_id = " . (int) $user_id . "
					AND type = 'folder'");

			// change files from being stored in folder being deleted to being stored in inbox
			$this->db->sql_query(
				"UPDATE {$prefix}messenger SET
					folder = 'inbox'
				WHERE folder = " . $this->db->q($folder) . "
					AND user_to_id = " . (int) $user_id);
		}

		$result	= $this->db->load_all(
			"SELECT msg_info_id, owner_id, type, info, notes
			FROM {$prefix}messenger_info
			WHERE owner_id = " . (int) $user_id . "
				AND type = " . $this->db->q($type) . "
			ORDER BY info ASC");

		$tpl->enter('m_');

		$tpl->hrefform			= $this->href('', '', ['action' => 'folders']);

		foreach ($result as $row)
		{
			$tpl->f_info		= strip_tags($row['info']);
			$tpl->f_notes		= strip_tags($row['notes']);
			$tpl->f_hreffolder	= $this->href('', '', ['folder' => strip_tags($row['info'])]);
			$tpl->f_hrefdelete	= $this->href('', '', ['folder' => strip_tags($row['info']), 'action' => 'folders', 'delete_folder' => $row['msg_info_id']]);
		}

		$tpl->leave(); // m_
	}

	// [N] code to display user list
	else if ($action == 'users')
	{
		$tpl->enter('n_');

		$sql_where =
			"WHERE account_type = 0 " .
				"AND enabled = 1 ";

		$count = $this->db->load_single(
			"SELECT COUNT(u.user_name) AS n " .
			"FROM {$prefix}user u " .
			$sql_where, true);

		$pagination = $this->pagination($count['n'], null, 'u', ['action' => 'users']);
		$tpl->pagination_text = $pagination['text'];

		$users = $this->db->load_all(
			"SELECT user_id, user_name
			FROM {$prefix}user " .
			$sql_where . "
			ORDER BY user_name ASC " .
			$pagination['limit']);

		foreach ($users as $user)
		{
			$tpl->u_username	= $user['user_name'];
			$tpl->u_hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $user['user_id']]);
		}

		$tpl->leave(); // n_
	}

	// [O] help
	else if ($action == 'help')
	{
		$tpl->z = true;
	}
}
else
{
	$tpl->forbidden = $this->show_message($this->_t('MessagingForbidden'), 'note', false);
}
