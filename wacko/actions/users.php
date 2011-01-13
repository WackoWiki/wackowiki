<?php

$where = '';
$order = '';
$param = '';
$groups = '';
$usergroups = '';

// display user profile
if (isset($_GET['profile']) && $_GET['profile'] == true)
{
	// does requested user exists?
	if (false == $user = $this->load_user($_GET['profile']))
	{
		echo '<div class="info">'.str_replace('%2', htmlspecialchars($_GET['profile']), str_replace('%1', $this->supertag, $this->get_translation('UsersNotFound'))).'</div>';
	}
	else
	{
		// usergroups
		if (is_array($this->config['aliases']))
		{
			// collecting group names where user takes membership
			foreach ($this->config['aliases'] as $group_name => $group_str)
			{
				$group_users = explode("\n", $group_str);

				if (in_array($user['user_name'], $group_users)) $groups[] = $group_name;
			}

			if ($groups == true) $usergroups = implode(', ', $groups);

			unset($group_name, $group_str, $groups);
		}

		// prepare and send personal message
		if (isset($_POST['send_pm']) && $_POST['mail_body'] == true && $this->get_user() &&
		$user['allow_intercom'] == 1 && $user['email'] && !$user['email_confirm'])
		{
			// check for errors
			// message is too long
			if (strlen($_POST['mail_body']) > INTERCOM_MAX_SIZE)
				$error = str_replace('%1', strlen($_POST['mail_body']) - INTERCOM_MAX_SIZE, $this->get_translation('UsersPMOversized'));
			// personal messages flood control
			else if ($_SESSION['intercom_delay'] && ((time() - $_SESSION['intercom_delay']) < $this->config['intercom_delay']))
				$error = str_replace('%1', $this->config['intercom_delay'], $this->get_translation('UsersPMFlooded'));

			// proceed if no error encountered
			if ($error)
			{
				$this->set_message($error);
			}
			else
			{
				// compose message
				$prefix		= rtrim(str_replace(array('https://www.', 'https://', 'http://www.', 'http://'), '', $this->config['base_url']), '/');
				$msgID		= date('ymdHi').'.'.mt_rand(100000, 999999).'@'.$prefix;
				$subject	= ( strpos($_POST['mail_subject'], '['.$prefix.'] ') === false ? '['.$prefix.'] ' : '' ).( $_POST['mail_subject'] ? $_POST['mail_subject'] : '(no subject)' );
				$body	= str_replace('%1', $this->get_user_name(), $this->get_translation('UsersPMBody'));
				$body	= str_replace('%2', rtrim($this->config['base_url'], '/'), $body);
				$body	= str_replace('%3', $this->href('', $this->tag, 'profile='.$this->get_user_name().'&ref='.rawurlencode(base64_encode($msgID.'@@'.$subject)).'#contacts'), $body);
				$body	= str_replace('%4', $this->config['abuse_email'], $body);
				$body	= str_replace('%5', $_POST['mail_body'], $body);

				// compose headers
				$headers	= array('Message-ID: <$msgID>');
				if ($_POST['ref'] == true)
				{
					$headers[] = "In-Reply-To: <{$_POST['ref']}>";
					$headers[] = "References: <{$_POST['ref']}>";
				}

				else
				{
					$notice = $this->get_translation('UsersPMSent');
				}

				// proceed if no error encountered
				if ($error)
				{
					$this->set_message($error);
				}
				else
				{
					$body .= "\n\n".$this->get_translation('MailGoodbye')."\n".$this->config['wacko_name']."\n".$this->config['base_url'];

					$this->send_mail($user['email'], $subject, $body, 'no-reply@'.$prefix, '', $headers, true);
					$this->set_message($notice);
					$this->log(4, str_replace('%2', $user['user_name'], str_replace('%1', $this->get_user_name(), $this->get_translation('LogPMSent', $this->config['language']))));
					$_SESSION['intercom_delay']	= time();
					$_POST['mail_body']			= '';
					$_POST['mail_subject']		= '';
					$_POST['ref']				= '';
				}
			}

			unset($error, $notice, $body, $subject, $referrer, $prefix, $headers, $msgID);
		}

		// header and profile data
		echo '<h1>'.$user['user_name'].'</h1>';
		echo '<small><a href="'.$this->href('', $this->tag).'">&laquo; '.$this->get_translation('UsersList')."</a></small>\n";
		echo '<h2>'.$this->get_translation('UsersProfile').'</h2>'."\n";

		// basic info
?>
		<table border="0" cellspacing="3">
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->get_translation('RealName'); ?></strong></td>
				<td><?php echo $user['real_name']; ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->get_translation('UsersSignupDate'); ?></strong></td>
				<td><?php echo $this->get_time_string_formatted($user['signup_time']); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;" valign="top"><strong><?php echo $this->get_translation('UsersLastSession'); ?></strong></td>
				<td><?php echo ( $user['hide_lastsession'] == 1
					? '<em>'.$this->get_translation('UsersSessionHidden').'</em>'
					: ( !$user['session_time'] || $user['session_time'] == SQL_NULLDATE
						? '<em>'.$this->get_translation('UsersSessionNA').'</em>'
						: $this->get_time_string_formatted($user['session_time']) )
					); ?></td>
			</tr>
			<tr><?php // Have all user pages as sub pages of the current Users page. ?>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->get_translation('UserSpace'); // TODO: this might be placed somewhere else, just put it here for testing ?></strong></td>
				<td><a href="<?php echo $this->href('', ($this->config['users_page'].'/'.$user['user_name'])); ?>"><?php echo $this->config['users_page'].'/'.$user['user_name']; ?></a></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><a href="<?php echo $this->href('', $this->config['groups_page']); ?>"><?php echo $this->get_translation('UsersGroupMembership'); ?></a></strong></td>
				<td><?php echo ( $usergroups == true ? $usergroups : '<em>'.$this->get_translation('UsersNA2').'</em>' ); ?></td>
			</tr>
		</table>
<?php
		// contact form
		echo '<h2>'.$this->get_translation('UsersContact').'</h2>'."\n";

		// only registered users can send PMs
		if ($this->get_user())
		{
			// decompose reply referrer
			if (isset($_GET['ref']) && $_GET['ref'] == true)
			{
				list($_POST['ref'], $_POST['mail_subject']) = explode('@@', base64_decode(rawurldecode($_GET['ref'])), 2);
				if (substr($_POST['mail_subject'], 0, 3) != 'Re:') $_POST['mail_subject'] = 'Re: '.$_POST['mail_subject'];
			}
?>
		<br />
		<?php echo $this->form_open(); ?>
		<input type="hidden" name="profile" value="<?php echo htmlspecialchars($user['user_name']); ?>" />
		<?php if (isset($_POST['ref'])) echo '<input type="hidden" name="ref" value="'.htmlspecialchars($_POST['ref']).'" />'; ?>
		<table cellspacing="3" class="formation">
<?php
			// user must allow incoming messages, and needs confirmed email address set
			if ($user['allow_intercom'] == 1 && $user['email'] && !$user['email_confirm'])
			{
?>
			<tr>
				<td class="label" style="width:50px; white-space:nowrap;"><?php echo $this->get_translation('UsersIntercomSubject'); ?>:</td>
				<td>
					<input name="mail_subject" value="<?php echo (isset($_POST['mail_subject']) ? htmlspecialchars($_POST['mail_subject']) : ""); ?>" size="60" maxlength="200" />
					<?php if (isset($_POST['ref'])) echo '&nbsp;&nbsp; <a href="'.$this->href('', '', 'profile='.$user['user_name'].'#contacts').'">'.$this->get_translation('UsersIntercomSubjectN').'</a>'; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><textarea name="mail_body" cols="80" rows="15"><?php echo (isset($_POST['mail_body']) ? htmlspecialchars($_POST['mail_body']) : ""); ?></textarea></td>
			</tr>
			<tr>
				<td><input id="submit" type="submit" name="send_pm" value="<?php echo $this->get_translation('UsersIntercomSend'); ?>" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<small><?php echo $this->get_translation('UsersIntercomDesc');
					?></small>
				</td>
			</tr>
<?php
			}
			else
			{
				echo '<tr><td colspan="2" align="center"><strong><em>'.$this->get_translation('UsersIntercomDisabled').'</em></strong></td></tr>';
			}
?>
		</table>
		<?php echo $this->form_close(); ?>
<?php
		}
		else
		{
			echo '<table cellspacing="3" class="formation"><tr><td colspan="2" align="center"><em>'.$this->get_translation('UsersPMNotLoggedIn').'</em></td></tr></table>';
		}

		// user-owned pages
		$limit = 20;
		echo '<h2 id="pages">'.$this->get_translation('UsersPages').'</a></h2>'."\n";
		echo '<div class="indent"><small>'.$this->get_translation('UsersOwnedPages').': '.$user['total_pages'].'&nbsp;&nbsp;&nbsp; '.$this->get_translation('UsersRevisionsMade').': '.$user['total_revisions']."</small></div><br />\n";

		$pagination = $this->pagination($user['total_pages'], $limit, 'd', 'profile='.$user['user_name'].'&amp;sort='.( isset($_GET['sort']) && $_GET['sort'] != 'name' ? 'date' : 'name' ).'#pages');

		if ($user['total_pages'])
		{
			$pages = $this->load_all(
				"SELECT page_id, tag, title, created ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE owner_id = '".quote($this->dblink, $user['user_id'])."' ".
					"AND comment_on_id = '0' ".
				"ORDER BY ".( isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'tag ASC' : 'created DESC' )." ".
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination
			echo '<small>'.( isset($_GET['sort']) && $_GET['sort'] == 'name' ? '<a href="'.$this->href('', '', 'profile='.$user['user_name'].'&amp;sort=date').'#pages">'.$this->get_translation('UsersDocsSortDate').'</a>' : '<a href="'.$this->href('', '', 'profile='.$user['user_name'].'&amp;sort=name').'#pages">'.$this->get_translation('UsersDocsSortName').'</a>' ).'</small>';
			if (isset($pagination['text']))
				echo " <span class=\"pagination\">".$pagination['text']."</span>\n";

			// pages list itself
			echo '<div>'."\n";
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id'], $this->get_user_name()) === true)
				{
					echo '<small>'.$this->get_time_string_formatted($page['created']).'</small>  &mdash; '.$this->link('/'.$page['tag'], '', $page['title'], '', 0)."<br />\n";

					$i = 0;
					if (++$i >= $limit) break 1;
				}
			}
			echo "</div>\n";

			unset($pages, $page, $limit, $i);
		}
		else
		{
			echo '<em>'.$this->get_translation('UsersNA2').'</em>';
		}

		// last user comments
		$limit = 20;
		echo '<h2 id="comments">'.$this->get_translation('UsersComments').'</h2>'."\n";
		echo '<div class="indent"><small>'.$this->get_translation('UsersCommentsPosted').': '.$user['total_comments']."</small></div>\n";

		$pagination = $this->pagination($user['total_comments'], $limit, 'c', 'profile='.$user['user_name'].'#comments');

		if ($user['total_comments'])
		{
			$comments = $this->load_all(
				"SELECT page_id, tag, created, comment_on_id ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE owner_id = '".quote($this->dblink, $user['user_id'])."' ".
					"AND comment_on_id <> '0' ".
				"ORDER BY created DESC ".
				"LIMIT {$pagination['offset']}, $limit");

			// pagination
			if (isset($pagination['text']))
				echo "<span class=\"pagination\">".$pagination['text']."</span>\n";

			// comments list itself
			echo '<div>'."\n";
			foreach ($comments as $comment)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $comment['comment_on_id'], $this->get_user_name()) === true)
				{
					echo '<small>'.$this->get_time_string_formatted($comment['created']).'</small>  &mdash; '.$this->link('/'.$comment['tag'], '', $this->get_page_title(0, $comment['comment_on_id']))."<br />\n";

					$i = 0;
					if (++$i >= $limit) break 1;
				}
			}
			echo "</div>\n";

			unset($comments, $comment, $limit, $i);
		}
		else
		{
			echo '<em>'.$this->get_translation('UsersNA2').'</em>';
		}
	}
}
// display whole userlist instead of the particular profile
else
{
	$limit = 50;

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	if (isset($_GET['user']) && $_GET['user'] == true && strlen($_GET['user']) > 2)
	{
		// goto user profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->load_user($_GET['user']) == true)
		{
			$this->redirect($this->href('', '', 'profile='.htmlspecialchars($_GET['user'])));
		}
		else
		{
			$where = "WHERE user_name LIKE '%".quote($this->dblink, $_GET['user'])."%' ";
			$param = "user=".htmlspecialchars($_GET['user']);
		}
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'name')
	{
		$order = "ORDER BY user_name ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'pages')
	{
		$order = "ORDER BY total_pages DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'comments')
	{
		$order = "ORDER BY total_comments DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'revisions')
	{
		$order = "ORDER BY total_revisions DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'signup')
	{
		$order = "ORDER BY signup_time DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'session')
	{
		$order = "ORDER BY session_time DESC ";
		$param = "sort=".$_GET['sort'];
	}

	$count = $this->load_single(
		"SELECT COUNT(user_name) AS n ".
		"FROM {$this->config['user_table']} ".
		( $where == true ? $where : '' ));

	$pagination = $this->pagination($count['n'], $limit, 'p', $param);

	// collect data
	$users = $this->load_all(
		"SELECT u.user_name, u.signup_time, u.session_time, u.total_pages, u.total_revisions, u.total_comments, p.hide_lastsession ".
		"FROM {$this->config['user_table']} u ".
			"LEFT JOIN ".$this->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
		( $where == true ? $where : '' ).
		( $where ? 'AND ' : "WHERE ").
			"u.account_type = '0' ".
		( $order == true ? $order : "ORDER BY u.total_pages DESC " ).
		"LIMIT {$pagination['offset']}, $limit");

	// user filter form
	echo '<table border="0" cellspacing="3" class="formation"><tr><td class="label">';
	echo $this->form_open('', '', 'get');
	echo $this->get_translation('UsersSearch').': </td><td>';
	echo '<input name="user" maxchars="40" size="40" value="'.htmlspecialchars(isset($_GET['user']) && $_GET['user']).'" /> ';
	echo '<input id="submit" type="submit" value="'.$this->get_translation('UsersFilter').'" /> ';
	echo '<input id="button" type="submit" value="'.$this->get_translation('UsersOpenProfile').'" name="gotoprofile" />';
	echo $this->form_close();
	echo '</td></tr></table><br />'."\n";

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";

	// pagination
	if (isset($pagination['text']))
	{
		echo '<tr><td colspan="5"><small>'.$pagination['text'].'</small></td></tr>'."\n";
	}

	// list header
	echo '<tr>'.
			'<th><a href="'.$this->href('', '', 'sort=name').'">'.$this->get_translation('UsersName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['user']) && $_REQUEST['user'] == true) ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=pages').'">'.$this->get_translation('UsersPages').( (isset($_GET['sort']) && $_GET['sort'] == 'pages') || (isset($_GET['sort']) && $_GET['sort'] == false) ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=comments').'">'.$this->get_translation('UsersComments').( isset($_GET['sort']) && $_GET['sort'] == 'comments' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=revisions').'">'.$this->get_translation('UsersRevisions').( isset($_GET['sort']) && $_GET['sort'] == 'revisions' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=signup').'">'.$this->get_translation('UsersSignup').( isset($_GET['sort']) && $_GET['sort'] == 'signup' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=session').'">'.$this->get_translation('UsersLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'session' ? '&nbsp;&darr;' : '' ).'</a></th>'.
		"</tr>\n";

	// list entries
	if ($users == false)
	{
		echo '<tr class="lined"><td colspan="5" align="center" style="padding:10px;"><small><em>'.$this->get_translation('UsersNoMatching')."</em></small></td></tr>\n";
	}
	else
	{
		foreach ($users as $user)
		{
			// Users inactive for ONE year - highlighted stricken through and with pink background on hover
			if ((time()-strtotime($user['session_time']))>=31536000)  echo '<tr class="lined-strike">';
			else  echo '<tr class="lined">';

			echo	'<td style="padding-left:5px;"><a href="'.$this->href('', '', 'profile='.htmlspecialchars($user['user_name']).'').'">'.$user['user_name'].'</a></td>'.
					'<td align="center">'.$user['total_pages'].'</td>'.
					'<td align="center">'.$user['total_comments'].'</td>'.
					'<td align="center">'.$user['total_revisions'].'</td>'.
					'<td align="center">'.$this->get_time_string_formatted($user['signup_time']).'</td>'.
					'<td align="center">'.( $user['hide_lastsession'] == 1
					? '<em>'.$this->get_translation('UsersSessionHidden').'</em>'
					: ( !$user['session_time'] || $user['session_time'] == SQL_NULLDATE
						? '<em>'.$this->get_translation('UsersSessionNA').'</em>'
						: $this->get_time_string_formatted($user['session_time']) )
					).'</td>'.
			"</tr>\n";
		}
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo "<tr><td colspan=\"5\"><span class=\"pagination\">".$pagination['text']."</span></td></tr>"."\n";
	}

	echo "</table>\n";
}

?>