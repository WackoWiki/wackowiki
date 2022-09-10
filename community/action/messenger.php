<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* messenger action:
 * https://wackowiki.org/doc/Dev/PatchesHacks/WikiMessenger
 * modify the script for your needs, please conribute your improvements
 */

// Aufrufen: {{messenger}} (ohne parameter). Benötigt: 2 Tabellen in MYSQL-Datenbank & sowie diese Datei, welche in den Ordner "action" eingefügt werden muss.

$prefix = $this->prefix;

$create_table = function() use ($prefix)
{
	$this->db->sql_query(
		"CREATE TABLE IF NOT EXISTS {$prefix}messenger (
			message_id INT(10) NOT NULL AUTO_INCREMENT,
			user_to_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			repliedto TINYINT(1) DEFAULT '0',
			folder TINYTEXT NOT NULL,
			user_from_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			urgent TINYINT(1) DEFAULT NULL,
			subject MEDIUMTEXT NOT NULL,
			message LONGTEXT NOT NULL,
			status TEXT NOT NULL,
			datesent DATETIME NULL DEFAULT NULL,
			viewrecipient TINYINT(1) DEFAULT '1',
		PRIMARY KEY (message_id)
	);");

	$this->db->sql_query(
		"CREATE TABLE IF NOT EXISTS {$prefix}messenger_info (
			msg_info_id INT(80) NOT NULL AUTO_INCREMENT,
			owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			type TINYTEXT NOT NULL,
			info TINYTEXT NOT NULL,
			notes TINYTEXT,
		PRIMARY KEY (msg_info_id)
	);");
};

if ($user_id = $this->get_user_id())
{
	$folder			= $_GET['folder'] ?? null;
	$which			= $_REQUEST['whichfolder'] ?? null;
	if (!$folder) {$folder = $which;}
	$message_id		= (int) ($_GET['message_id'] ?? null);
	$move2folder	= $_REQUEST['move2folder'] ?? null;
	$action			= $_GET['action'] ?? null;
	$to				= (int) ($_GET['to'] ?? null);

	// table
	$tpl->hrefinbox		= $this->href('', '', ['action' => 'inbox']);
	$tpl->hrefcompose	= $this->href('', '', ['action' => 'compose']);
	$tpl->hrefsend		= $this->href('', '', ['action' => 'sent']);
	$tpl->hreffolders	= $this->href('', '', ['action' => 'folders']);
	$tpl->hrefcontacts	= $this->href('', '', ['action' => 'contacts']);
	$tpl->hrefusers		= $this->href('', '', ['action' => 'users']);
	$tpl->hrefhelp		= $this->href('', '', ['action' => 'help']);

	$results = $this->db->load_all(
		"SELECT DISTINCT info
		FROM {$prefix}messenger_info
		WHERE type = 'folder'
			AND owner_id = " . (int) $user_id . "
		ORDER BY info ASC");

	foreach ($results as $row)
	{
		$tpl->o_info	= $row['info'];

		if ($_REQUEST['whichfolder'] == $row['info'])
		{
			$tpl->o_selected = ' selected';
		}
	}

	if (! in_array($action, ['compose', 'forward', 'contacts', 'folders', 'users', 'help', 'reply', 'delete', 'store']))
	{
		if ($action == 'inbox' || (($action == '' || $action == 'view')
			&& @$_REQUEST['whichfolder'] == '' && $folder == ''))
		{
			$which2 = '<b>' . $this->_t('Inbox') . '</b>';
		}
		else if ($action == 'sent' || $action == 'view2')
		{
			$which2 = '<b>' . $this->_t('SentItems') . '</b>';
		}
		else if ($folder != '')
		{
			$which	= $folder;
			$which2	= '<a href="' . $this->href('', '', ['folder' => $folder]) . '">' . $which . '</a>';
		}

		$tpl->folder = '<br><b>' . $this->_t('Folder') . ': </b>' . $which2;
	}

	// [A] code for moving messages to folders
	if ($move2folder)
	{
		$rs = $this->db->sql_query(
			"UPDATE {$prefix}messenger SET
				folder = " . $this->db->q($move2folder) . "
			WHERE message_id = " . (int) $message_id . "
				AND user_to_id = " . (int) $user_id);

		$tpl->a_message = $rs
			? '<br>' . Ut::perc_replace($this->_t('MessageMoved'), '<b>' . $move2folder . '</b>')
			: $this->_t('MessageNotMoved');
	}

	// [B] shows inbox
	else if (($action == '' || $action == 'inbox')
		&& @$_REQUEST['whichfolder'] == '' && (!$folder))
	{
		$search = '';

		//needed for pagination of sent box
		$limit = 10;

		$selector =
			"FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . " " .
			$search . "
				AND m.folder = 'inbox'
				AND m.viewrecipient = '1' ";

		// count pages
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

		// to paginate the "inbox" page messeges
		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $row )
		{
			// setzt Zeichen für Status der Nachricht (wichtig/gelesen/beantwortet)
			if ($row['status'] == 'pending')
			{
				$status = '<a title="' . $this->_t('MessageNotRead') . '"><span class="cite">*</span></a>';
			}
			else
			{
				$status = '';
			}

			if ($row['urgent'] == 1)
			{
				$urgent_flag = '<a title="' . $this->_t('UrgentMessage') . '"><span class="cite"><strong>!</strong></span></a>';
			}
			else
			{
				$urgent_flag = '';
			}

			if ($row['repliedto'] == 1)
			{
				$replied = '<a title="' . $this->_t('MessageReplied') . '"><font color="grey"><strong> beantwortet am: </strong></grey></a>';
			}
			else
			{
				$replied = '';
			}

			$tpl->time			= $row['datesent'];
			$tpl->status		= $status;
			$tpl->urgent		= $urgent_flag;
			$tpl->replied		= $replied;
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->format($row['user_name']);
			$tpl->hrefview		= $this->href('', '', ['action' => 'view', 'message_id' => $row['message_id'], 'page' => 'viewmessage']);
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_from_id']]);
			$tpl->hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);
			$tpl->hrefform		= $this->href('', '', ['message_id' => $row['message_id']]);

			// code to put in drop down box to move to a new folder
			$resultdrop2 = $this->db->load_all(
				"SELECT DISTINCT info
				FROM {$prefix}messenger_info
				WHERE type='folder'
					AND owner_id = " . (int) $user_id . "
				ORDER BY info ASC");

			foreach ($resultdrop2 as $row2)
			{
				$tpl->o_info = $row2['info'];
			}
		}

		$tpl->leave(); // n_

		if ($count['n'] == 0)
		{
			echo '<br>' . $this->_t('NoMessagesInbox') . '<br><br>';
		}

		$tpl->leave(); // b_
	}
	// [C] send a new message to a user
	else if ($action == 'compose')
	{
		$users = $this->db->load_all(
			"SELECT user_id, user_name
			FROM {$prefix}user
			ORDER BY user_name ASC");

		$tpl->enter('c_');

		$tpl->hrefform		= $this->href('', '', ['action' => 'store']);
		$tpl->hrefusers		= $this->href('', '', ['action' => 'users']);

		foreach ($users as $user)
		{
			$tpl->o_userid		= $user['user_id'];
			$tpl->o_username	= $user['user_name'];

			if ($to == $user['user_id'])
			{
				$tpl->o_selected	= ' selected';
			}
		}

		$contacts = $this->db->load_all(
			"SELECT i.info, u.user_name
			FROM {$prefix}messenger_info i
				LEFT JOIN {$prefix}user u ON (i.info = u.user_id)
			WHERE i.type = 'contact'
				AND i.owner_id = " . (int) $user_id . "
			ORDER BY i.info ASC");

		foreach ($contacts as $row)
		{
			$tpl->u_username	= $row['user_name'];
			$tpl->u_hrefcompose	= $this->href('', '', ['action' => 'compose', 'to' => (int) $row['info']]);
		}

		$tpl->leave(); // c_
	}

	// [D] Antwort an den Absender einer Nachricht schicken
	else if ($action == 'reply')
	{
		$row = $this->db->load_single(
			"SELECT *
			FROM {$prefix}messenger
			WHERE user_to_id = " . (int) $user_id . "
				AND message_id = " . (int) $message_id);

		$user = $this->db->load_single(
			"SELECT user_id, user_name
			FROM {$prefix}user
			WHERE user_id = " . (int) $to . "
				LIMIT 1");

		$tpl->enter('d_');

		$tpl->subject	= $row['subject'];
		$tpl->userid	= $user['user_id'];
		$tpl->username	= $user['user_name'];
		$tpl->hrefform	= $this->href('', '', ['action' => 'store', 'replyto' => $message_id]);
		$tpl->origmsg	= 	"\n\n++++++++++ " . $this->_t('OriginalMessage') . " ++++++++++\n" .
							strip_tags($row['message']) .
							"\n+++++++++++++++++++++++++++++++++";

		$tpl->leave(); // d_
	}

	// [E] Nachricht weiterleiten
	else if ($action == 'forward' && $message_id != '')
	{
		$row = $this->db->load_single(
			"SELECT *
			FROM {$prefix}messenger
			WHERE user_to_id = " . (int) $user_id . "
				AND message_id = " . (int) $message_id);

		$users = $this->db->load_all(
			"SELECT user_id, user_name
			FROM {$prefix}user
			ORDER BY user_name ASC");

		$tpl->enter('e_');

		$tpl->subject	= 'FWD: ' . $row['subject'];
		$tpl->hrefusers	= $this->href('', '', ['action' => 'users']);
		$tpl->hrefform	= $this->href('', '', ['action' => 'store']);
		$tpl->origmsg	=	"\n\n++++++++++++ " . $this->_t('Forward') . " ++++++++++++++\n" .
							strip_tags($row['message']) .
							"\n+++++++++++++++++++++++++++++++++";

		foreach ($users as $user)
		{
			$tpl->o_userid		= $user['user_id'];
			$tpl->o_username	= $user['user_name'];

			if ($to == $user['user_id'])
			{
				$tpl->o_selected	= ' selected';
			}
		}

		$contacts = $this->db->load_all(
			"SELECT i.info, u.user_name
			FROM {$prefix}messenger_info i
				LEFT JOIN {$prefix}user u ON (i.info = u.user_id)
			WHERE i.type='contact'
				AND i.owner_id = " . (int) $user_id . "
			ORDER BY i.info ASC");

		foreach ($contacts as $row)
		{
			$tpl->u_username	= $row['user_name'];
			$tpl->u_hrefforward	= $this->href('', '', ['action' => 'forward', 'to' => (int) $row['info'], 'message_id' => $message_id]);
		}

		$tpl->leave(); // e_
	}

	// [F] schreibt versendete Nachrichten (original/weitergeleitet) in die Datenbank
	if ($action == 'store')
	{
		$urgent		= (int) ($_POST['urgent'] ?? null);
		$to			= (int) ($_POST['to'] ?? null);
		$subject	= $_POST['subject'] ?? null;
		$message	= $_POST['message'] ?? null;
		$message	= strip_tags($message);
		$replyto	= $_GET['replyto'] ?? null;
		$date		= date('YmdHis');

		$tpl->enter('f_');

		// prüft ob der Nutzer existiert und versendet die Nachricht
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
						$this->db->q('pending') . ", " .
						(int) $urgent . "
					)");

				$tpl->sendto	= Ut::perc_replace($this->_t('MessageSentTo'), $user['user_name']);

				// to set the database so that the message has been replied to
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
	// [G] zeigt den Ordner "versendete Nachrichten"
	else if ($action == 'sent')
	{
		// needed for pagination of sent box
		$limit = 10;

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

		// to paginate the "sent" page messages
		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $row)
		{
			$tpl->time			= $row['datesent'];
			$tpl->status		= $row['status'];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->format($row['user_name']);
			$tpl->hrefview2		= $this->href('', '', ['action' => 'view2', 'message_id' => $row['message_id'], 'page' => 'view2']);
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_to_id']]);
		}

		$tpl->leave(); // n_
		$tpl->leave(); // g_
	}

	// [H] show selected folder
	else if (((@$_REQUEST['whichfolder'] != '') || ($folder)) && ($action != 'view'))
	{
		$search = '';

		if (isset($_REQUEST['whichfolder']) && $_REQUEST['whichfolder'] != '')
		{
			$showfolder = $_REQUEST['whichfolder'];
		}
		else
		{
			$showfolder = $folder;
		}

		$result = $this->db->load_all(
			"SELECT message_id
			FROM {$prefix}messenger
			WHERE user_to_id = " . (int) $user_id . " " .
			$search . "
				AND folder = " . $this->db->q($folder) . "
				AND viewrecipient = '1'
			ORDER BY datesent DESC");

		//needed for pagination of sent box
		$limit = 10;

		$selector =
			"FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . " " .
			$search . "
				AND m.folder = " . $this->db->q($showfolder);

		// count pages
		$count = $this->db->load_single(
			"SELECT COUNT(message_id) AS n " .
			$selector
			, true);

		$pagination = $this->pagination($count['n'], $limit, 'm' , ['action' => 'message_folder', 'whichfolder' => $showfolder]);

		$result = $this->db->load_all(
			"SELECT m.*, u.user_name " .
			$selector .
			"ORDER BY m.datesent DESC " .
			$pagination['limit']);

		$tpl->enter('h_');

		// to paginate the "inbox" page messeges
		$tpl->pagination_text = $pagination['text'];

		$tpl->enter('n_');

		foreach ($result as $row)
		{
			if ($row['status'] == 'unread')
			{
				$status = '<a title="' . $this->_t('MessageNotRead') . '"><span class="cite">*</span></a>';
			}
			else
			{
				$status = '';
			}

			if ($row['urgent'] == 1)
			{
				$urgent_flag = '<a title="' . $this->_t('UrgentMessage') . '"><span class="cite"><strong>!</strong></span></a>';
			}
			else
			{
				$urgent_flag = '';
			}

			if ($row['repliedto'] == 1)
			{
				$replied = '<a title="' . $this->_t('MessageReplied') . '"><strong>+</strong></a>';
			}
			else
			{
				$replied = ' ';
			}

			$tpl->time			= $row['datesent'];
			$tpl->status		= $status;
			$tpl->urgent		= $urgent_flag;
			$tpl->replied		= $replied;
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->format($row['user_name']);
			$tpl->hrefview		= $this->href('', '', ['action' => 'view', 'message_id' => $row['message_id'], 'folder' => $which]);
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_from_id']]);
			$tpl->hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);
			$tpl->hrefform		= $this->href('', '', ['message_id' => $row['message_id'], 'folder' => $which]);

			// code to put in drop down box to move to a new folder
			$resultdrop2 = $this->db->load_all(
				"SELECT DISTINCT info
				FROM {$prefix}messenger_info
				WHERE type = 'folder'
					AND owner_id = " . (int) $user_id . "
				ORDER BY info ASC");

			foreach ($resultdrop2 as $row2)
			{
				$tpl->o_info = $row2['info'];
			}
		}

		$tpl->leave(); // n_

		if ($count['n'] == 0)
		{
			$tpl->nomessages = '<br>' . $this->_t('NoMessagesFolder') . '<br><br>';
		}

		$tpl->leave(); // h_
	}
	// [I] view individual messages
	else if ($action == 'view')
	{
		$row = $this->db->load_single(
			"SELECT m.*, u.user_name
			FROM {$prefix}messenger m
				LEFT JOIN {$prefix}user u ON (m.user_from_id = u.user_id)
			WHERE m.user_to_id = " . (int) $user_id . "
				AND m.message_id = " . (int) $message_id);

		if ($row['repliedto'] == 1)
		{
			$replied = '<a title="' . $this->_t('MessageReplied') . '"><small>replied to<small></a>';
		}
		else
		{
			$replied = ' ';
		}

		$tpl->enter('i_');

		// code to set filter in database
		if ($row['user_to_id'] == $user_id)
		{
			$tpl->time			= $row['datesent'];
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->format($row['user_name']);
			$tpl->message		= strip_tags($row['message']);
			$tpl->replied		= $replied;
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_from_id']]);
			$tpl->hrefreply		= $this->href('', '', ['action' => 'reply', 'to' => $row['user_from_id'], 'message_id' => $row['message_id']]);
			$tpl->hrefforward	= $this->href('', '', ['action' => 'forward', 'message_id' => $row['message_id']]);
			$tpl->hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);

			$rs = $this->db->sql_query(
				"UPDATE {$prefix}messenger SET
					status = 'gelesen'
				WHERE message_id = " . (int) $message_id);
		}
		else
		{
			$tpl->forbidden = 'Das ist nicht Deine Post!';
		}

		$tpl->leave(); // i_
	}

	// [J] added filter for viewing "folder sorted" messages
	else if ($action == 'view2')
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
			$tpl->subject		= strip_tags($row['subject']);
			$tpl->username		= $this->format($row['user_name']);
			$tpl->message		= strip_tags($row['message']);
			$tpl->hrefcontact	= $this->href('', '', ['action' => 'contacts', 'contact' => $row['user_from_id']]);
		}

		$tpl->leave(); // j_
	}

	// [K] Nachrichten löschen (geändert - Nachrichten werden jetzt komplett aus Datenbank entfernt)
	else if ($action == 'delete')
	{
		if ($_POST['delete_message'])
		{
			$rs = $this->db->sql_query(
				"DELETE FROM {$prefix}messenger
				WHERE message_id = " . (int) $message_id);

			$tpl->k_message	= ($rs
				? $this->_t('MessageDeleted')
				: $this->_t('MessageNotDeleted'));
		}
		else
		{
			$tpl->k_hrefdelete	= $this->href('', '', ['action' => 'delete', 'message_id' => $row['message_id']]);
		}
	}

	// [L] Kontaktliste verwalten
	else if ($action == 'contacts')
	{
		$add_contact	= $_GET['contact'] ?? '';
		$delete_contact	= $_GET['delete_contact'] ?? null;
		$field1_value	= $_POST['field1_value'] ?? null;
		if ($field1_value)
		{$insert = '1';}
		else {$insert = '';}
		$field2_value	= $_POST['field2_value'] ?? null;
		$category		= 'contact';

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
						$this->db->q($category) . "
					)");
			}
		}

		if ($delete_contact)
		{
			$this->db->sql_query(
				"DELETE FROM {$prefix}messenger_info
				WHERE msg_info_id = $delete_contact
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
				AND i.type = " . $this->db->q($category) . "
			ORDER BY i.info ASC");

		$tpl->enter('l_');

		$tpl->hrefform			= $this->href('', '', ['action' => 'contacts']);
		$tpl->hrefusers			= $this->href('', '', ['action' => 'users']);

		foreach ($contacts as $contact)
		{
			$in_list[] 				= $contact['info'];
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

	// [M] Ordner verwalten
	else if ($action == 'folders')
	{
		$delete_folder	= $_GET['delete_folder'] ?? null;
		$folder			= $_GET['folder'] ?? null;
		$field1_value	= $_POST['field1_value'] ?? null;
		if ($field1_value) {$insert = '1';}
		else {$insert = '';}
		$field2_value	= $_POST['field2_value'] ?? null;
		$category		= 'folder';

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
					$this->db->q($category) . "
				)");
		}

		if ($delete_folder)
		{
			// delete folder name from messenger_info
			$this->db->sql_query(
				"DELETE FROM {$prefix}messenger_info
				WHERE msg_info_id = '$delete_folder'
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
				AND type = " . $this->db->q($category) . "
			ORDER BY info ASC");

		$tpl->enter('m_');

		$tpl->hrefform			= $this->href('', '', ['action' => 'folders']);

		foreach ($result as $row)
		{
			$tpl->f_info		= strip_tags($row['info']);
			$tpl->f_notes		= strip_tags($row['notes']);
			$tpl->f_hreffolder	= $this->href('', '', ['folder' => strip_tags($row['info'])]);
			$tpl->f_hrefdelete	= $this->href('', '', ['action' => 'folders', 'delete_folder' => $row['msg_info_id'], 'folder' => $row['info']]);
		}

		$tpl->leave(); // m_
	}

	// [N] code to display user list
	else if ($action == 'users')
	{
		$users = $this->db->load_all(
			"SELECT user_id, user_name
			FROM {$prefix}user
			ORDER BY user_name ASC");

		$tpl->enter('n_');

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
	$tpl->forbidden = $this->_t('MessagingForbidden');
}