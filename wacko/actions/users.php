<?php

// display user profile
if ($_GET['profile'] == true)
{
	// does requested user exists?
	if (false == $user = $this->LoadUser($_GET['profile']))
	{
		echo '<div class="info">'.str_replace('%2', htmlspecialchars($_GET['profile']), str_replace('%1', $this->supertag, $this->GetTranslation('UsersNotFound'))).'</div>';
	}
	else
	{
		// extract all user info
		$user['options'] = $this->DecomposeOptions($user['more']);
		unset($user['more']);

		// usergroups
		if (is_array($this->config['aliases']))
		{
			// collecting group names where user takes membership
			foreach ($this->config['aliases'] as $group_name => $group_str)
			{
				$group_users = explode("\n", $group_str);

				if (in_array($user['name'], $group_users)) $groups[] = $group_name;
			}

			if ($groups == true) $usergroups = implode(', ', $groups);

			unset($group_name, $group_str, $groups);
		}

		// prepare and send personal message
		if (isset($_POST['send_pm']) && $_POST['mail_body'] == true && $this->GetUser() &&
		$user['options']['allow_intercom'] == '1' && $user['email'] && !$user['email_confirm'])
		{
			// check for errors
			// message is too long
			if (strlen($_POST['mail_body']) > INTERCOM_MAX_SIZE)
				$error = str_replace('%1', strlen($_POST['mail_body']) - INTERCOM_MAX_SIZE, $this->GetTranslation('UsersPMOversized'));
			// personal messages flood control
			else if ($_SESSION['intercom_delay'] && ((time() - $_SESSION['intercom_delay']) < $this->config['intercom_delay']))
				$error = str_replace('%1', $this->config['intercom_delay'], $this->GetTranslation('UsersPMFlooded'));

			// proceed if no error encountered
			if ($error)
			{
				$this->SetMessage($error);
			}
			else
			{
				// compose message
				$prefix		= rtrim(str_replace(array('https://www.', 'https://', 'http://www.', 'http://'), '', $this->config['base_url']), '/');
				$msgID		= date('ymdHi').'.'.mt_rand(100000, 999999).'@'.$prefix;
				$subject	= ( strpos($_POST['mail_subject'], '['.$prefix.'] ') === false ? '['.$prefix.'] ' : '' ).( $_POST['mail_subject'] ? $_POST['mail_subject'] : '(no subject)' );
				$message	= str_replace('%1', $this->GetUserName(), $this->GetTranslation('UsersPMBody'));
				$message	= str_replace('%2', rtrim($this->config['base_url'], '/'), $message);
				$message	= str_replace('%3', $this->href('', $this->tag, 'profile='.$this->GetUserName().'&ref='.rawurlencode(base64_encode($msgID.'@@'.$subject)).'#contacts'), $message);
				$message	= str_replace('%4', $this->config['abuse_email'], $message);
				$message	= str_replace('%5', $_POST['mail_body'], $message);

				// compose headers
				$headers	= array("Message-ID: <$msgID>");
				if ($_POST['ref'] == true)
				{
					$headers[] = "In-Reply-To: <{$_POST['ref']}>";
					$headers[] = "References: <{$_POST['ref']}>";
				}

				else
				{
					$notice = $this->GetTranslation('UsersPMSent');
				}

				// proceed if no error encountered
				if ($error)
				{
					$this->SetMessage($error);
				}
				else
				{
					$message .= "\n\n".$this->GetTranslation('MailGoodbye')."\n".$this->config['wacko_name']."\n".$this->config['base_url'];

					$this->SendMail($user['email'], $subject, $message, 'no-reply@'.$prefix, '', $headers, true);
					$this->SetMessage($notice);
					$this->Log(4, str_replace('%2', $user['name'], str_replace('%1', $this->GetUserName(), $this->GetTranslation('LogPMSent'))));
					$_SESSION['intercom_delay']	= time();
					$_POST['mail_body']			= '';
					$_POST['mail_subject']		= '';
					$_POST['ref']				= '';
				}
			}

			unset($error, $notice, $message, $subject, $referrer, $prefix, $headers, $msgID);
		}

		// header and profile data
		echo '<h1>'.$user['name'].'</h1>';
		echo '<small><a href="'.$this->href('', $this->tag).'">&laquo '.$this->GetTranslation('UsersList')."</a></small>\n";
		echo '<a name="profile"></a><h2>'.$this->GetTranslation('UsersProfile').'</h2><br />'."\n";

		// basic info
?>
		<table border="0" cellspacing="3">
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('RealName'); ?></strong></td>
				<td><?php echo $user['real_name']; ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('UsersSignupDate'); ?></strong></td>
				<td><?php echo $this->GetTimeStringFormatted($user['signuptime']); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;" valign="top"><strong><?php echo $this->GetTranslation('UsersLastSession'); ?></strong></td>
				<td><?php echo ( $user['options']['hide_lastsession'] == '1'
					? '<em>'.$this->GetTranslation('UsersSessionHidden').'</em>'
					: ( !$user['session_time'] || $user['session_time'] == SQL_NULLDATE
						? '<em>'.$this->GetTranslation('UsersSessionNA').'</em>'
						: $this->GetTimeStringFormatted($user['session_time']) )
					); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;" valign="top"><strong><?php echo $this->GetTranslation('ProfileOccupation'); ?></strong></td>
				<td><?php echo ( $user['options']['occupation'] ? htmlspecialchars($user['options']['occupation']) : '<em>'.$this->GetTranslation('UsersNA').'</em>' ); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;" valign="top"><strong><?php echo $this->GetTranslation('ProfileInterests'); ?></strong></td>
				<td><?php echo ( $user['options']['interests'] ? htmlspecialchars($user['options']['interests']) : '<em>'.$this->GetTranslation('UsersNA').'</em>' ); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('ProfileWebsite'); ?></strong></td>
				<td><?php echo ( $user['options']['website'] ? htmlspecialchars($user['options']['website']) : '<em>'.$this->GetTranslation('UsersNA').'</em>' ); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('ProfileICQUIN'); ?></strong></td>
				<td><?php echo ( $user['options']['icq'] ? htmlspecialchars($user['options']['icq']) : '<em>'.$this->GetTranslation('UsersNA').'</em>' ); ?></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('ProfileJabberID'); ?></strong></td>
				<td><?php echo ( $user['options']['jid'] ? htmlspecialchars($user['options']['jid']) : '<em>'.$this->GetTranslation('UsersNA').'</em>' ); ?></td>
			</tr>
			<tr><?php // Have all user pages as sub pages of the current Users page. ?>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><?php echo $this->GetTranslation('UserSpace'); // TODO: this might be placed somewhere else, jut put it here for testing ?></strong></td>
				<td><a href="<?php echo $this->href('', ($this->config['users_page'].'/'.$user['name'])); ?>"><?php echo $this->config['users_page'].'/'.$user['name']; ?></a></td>
			</tr>
			<tr>
				<td style="width:100px; white-space:nowrap; padding-right:20px;"><strong><a href="<?php echo $this->href('', $this->config['groups_page']); ?>"><?php echo $this->GetTranslation('UsersGroupMembership'); ?></a></strong></td>
				<td><?php echo ( $usergroups == true ? $usergroups : '<em>'.$this->GetTranslation('UsersNA2').'</em>' ); ?></td>
			</tr>
		</table>
<?php
		// user wiki-style info
		if ($user['motto'] == true)
		{
			$this->StopLinkTracking();
			echo '<a name="info"></a><h3>'.$this->GetTranslation('UsersPersonalInfo').'</h3><br />'."\n";
			echo $this->Format($this->Format($user['motto'], 'wacko'), 'post_wacko')."\n";
			$this->StartLinkTracking();
		}

		// contact form
		echo '<a name="contacts"></a><h2>'.$this->GetTranslation('UsersContact').'</h2><br />'."\n";

		// only registered users can send PMs
		if ($this->GetUser())
		{
			// decompose reply referrer
			if ($_GET['ref'] == true)
			{
				list($_POST['ref'], $_POST['mail_subject']) = explode('@@', base64_decode(rawurldecode($_GET['ref'])), 2);
				if (substr($_POST['mail_subject'], 0, 3) != 'Re:') $_POST['mail_subject'] = 'Re: '.$_POST['mail_subject'];
			}
?>
		<br />
		<?php echo $this->FormOpen(); ?>
		<input type="hidden" name="profile" value="<?php echo htmlspecialchars($user['name']); ?>" />
		<?php if ($_POST['ref']) echo '<input type="hidden" name="ref" value="'.htmlspecialchars($_POST['ref']).'" />'; ?>
		<table cellspacing="3" class="formation">
<?php
			// user must allow incoming messages, and needs confirmed email address set
			if ($user['options']['allow_intercom'] == '1' && $user['email'] && !$user['email_confirm'])
			{
?>
			<tr>
				<td class="label" style="width:50px; white-space:nowrap;"><?php echo $this->GetTranslation('UsersIntercomSubject'); ?>:</td>
				<td>
					<input name="mail_subject" value="<?php echo htmlspecialchars($_POST['mail_subject']); ?>" size="60" maxlength="200" />
					<?php if ($_POST['ref']) echo '&nbsp;&nbsp; <a href="'.$this->href('', '', 'profile='.$user['name'].'#contacts').'">'.$this->GetTranslation('UsersIntercomSubjectN').'</a>'; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><textarea name="mail_body" cols="80" rows="15"><?php echo htmlspecialchars($_POST['mail_body']); ?></textarea></td>
			</tr>
			<tr>
				<td><input id="submit" type="submit" name="send_pm" value="<?php echo $this->GetTranslation('UsersIntercomSend'); ?>" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<small><?php echo $this->GetTranslation('UsersIntercomDesc');
					?></small>
				</td>
			</tr>
<?php
			}
			else
			{
				echo '<tr><td colspan="2" align="center"><strong><em>'.$this->GetTranslation('UsersIntercomDisabled').'</em></strong></td></tr>';
			}
?>
		</table>
		<?php echo $this->FormClose(); ?>
<?php
		}
		else
		{
			echo '<table cellspacing="3" class="formation"><tr><td colspan="2" align="center"><em>'.$this->GetTranslation('UsersPMNotLoggedIn').'</em></td></tr></table>';
		}

		// user-owned pages
		$limit = 20;
		echo '<a name="documents"></a><h2>'.$this->GetTranslation('UsersDocuments').'</a></h2>'."\n";
		echo '<div class="indent"><small>'.$this->GetTranslation('UsersOwnedPages').': '.$user['total_pages'].'&nbsp;&nbsp;&nbsp; '.$this->GetTranslation('UsersRevisionsMade').': '.$user['total_revisions']."</small></div><br />\n";

		$pagination = $this->Pagination($user['total_pages'], $limit, 'd', 'profile='.$user['name'].'&amp;sort='.( $_GET['sort'] != 'name' ? 'date' : 'name' ).'#documents');

		if ($user['total_pages'])
		{
			$pages = $this->LoadAll(
				"SELECT page_id, tag, title, created ".
				"FROM {$this->config['table_prefix']}pages ".
				"WHERE owner_id = '".quote($this->dblink, $user['user_id'])."' ".
					"AND comment_on_id = '0' ".
				"ORDER BY ".( $_GET['sort'] == 'name' ? 'tag ASC' : 'created DESC' )." ".
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination
			echo '<table><tr><td><small>'.( $_GET['sort'] == 'name' ? '<a href="'.$this->href('', '', 'profile='.$user['name'].'&amp;sort=date').'#documents">'.$this->GetTranslation('UsersDocsSortDate').'</a>' : '<a href="'.$this->href('', '', 'profile='.$user['name'].'&amp;sort=name').'#documents">'.$this->GetTranslation('UsersDocsSortName').'</a>' ).'</small></td>'.
				 '<td align="right"><small>'.$pagination['text']."</small></td></tr></table>\n";

			// pages list itself
			echo '<div>'."\n";
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->HasAccess('read', $page['page_id'], $this->GetUserName()) === true)
				{
					echo '<small>'.$this->GetTimeStringFormatted($page['created']).'</small>  &mdash; '.$this->Link('/'.$page['tag'], '', $page['title'], 0)."<br />\n";

					if (++$i >= $limit) break 1;
				}
			}
			echo "</div>\n";

			unset($pages, $page, $limit, $i);
		}
		else
		{
			echo '<em>'.$this->GetTranslation('UsersNA2').'</em>';
		}

		// last user comments
		$limit = 20;
		echo '<a name="comments"></a><h2>'.$this->GetTranslation('UsersComments').'</h2>'."\n";
		echo '<div class="indent"><small>'.$this->GetTranslation('UsersCommentsPosted').': '.$user['total_comments']."</small></div>\n";

		$pagination = $this->Pagination($user['total_comments'], $limit, 'c', 'profile='.$user['name'].'#comments');

		if ($user['total_comments'])
		{
			$comments = $this->LoadAll(
				"SELECT page_id, tag, created, comment_on_id ".
				"FROM {$this->config['table_prefix']}pages ".
				"WHERE owner_id = '".quote($this->dblink, $user['user_id'])."' ".
					"AND comment_on_id <> '0' ".
				"ORDER BY created DESC ".
				"LIMIT {$pagination['offset']}, $limit");

			// pagination
			echo '<table><tr><td align="right"><small>'.$pagination['text']."</small></td></tr></table>\n";

			// comments list itself
			echo '<div>'."\n";
			foreach ($comments as $comment)
			{
				if (!$this->config['hide_locked'] || $this->HasAccess('read', $comment['comment_on_id'], $this->GetUserName()) === true)
				{
					echo '<small>'.$this->GetTimeStringFormatted($comment['created']).'</small>  &mdash; '.$this->Link('/'.$comment['tag'], '', $this->GetPageTitle(0, $comment['comment_on_id']))."<br />\n";

					if (++$i >= $limit) break 1;
				}
			}
			echo "</div>\n";

			unset($comments, $comment, $limit, $i);
		}
		else
		{
			echo '<em>'.$this->GetTranslation('UsersNA2').'</em>';
		}
	}
}
// display whole userlist instead of the particular profile
else
{
	$limit = 50;

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	if ($_GET['user'] == true && strlen($_GET['user']) > 2)
	{
		// goto user profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->LoadUser($_GET['user']) == true)
		{
			$this->Redirect($this->href('', '', 'profile='.htmlspecialchars($_GET['user'])));
		}
		else
		{
			$where = "WHERE name LIKE '%".quote($this->dblink, $_GET['user'])."%' ";
			$param = "user=".htmlspecialchars($_GET['user']);
		}
	}
	else if ($_GET['sort'] == 'name')
	{
		$order = "ORDER BY name ";
		$param = "sort=".$_GET['sort'];
	}
	else if ($_GET['sort'] == 'pages')
	{
		$order = "ORDER BY total_pages DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if ($_GET['sort'] == 'comments')
	{
		$order = "ORDER BY total_comments DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if ($_GET['sort'] == 'revisions')
	{
		$order = "ORDER BY total_revisions DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if ($_GET['sort'] == 'signup')
	{
		$order = "ORDER BY signuptime DESC ";
		$param = "sort=".$_GET['sort'];
	}
	else if ($_GET['sort'] == 'session')
	{
		$order = "ORDER BY session_time DESC ";
		$param = "sort=".$_GET['sort'];
	}

	$count = $this->LoadSingle(
		"SELECT COUNT(name) AS n ".
		"FROM {$this->config['user_table']} ".
		( $where == true ? $where : '' ));

	$pagination = $this->Pagination($count['n'], $limit, 'p', $param);

	// collect data
	$users = $this->LoadAll(
		"SELECT name, signuptime, session_time, total_pages, total_revisions, total_comments ".
		"FROM {$this->config['user_table']} ".
		( $where == true ? $where : '' ).
		( $order == true ? $order : "ORDER BY total_pages DESC " ).
		"LIMIT {$pagination['offset']}, $limit");

	// user filter form
	echo '<table border="0" cellspacing="3" class="formation"><tr><td class="label">';
	echo $this->FormOpen('', '', 'get');
	echo $this->GetTranslation('UsersSearch').': </td><td>';
	echo '<input name="user" maxchars="40" size="40" value="'.htmlspecialchars($_GET['user']).'" /> ';
	echo '<input id="submit" type="submit" value="'.$this->GetTranslation('UsersFilter').'" /> ';
	echo '<input id="button" type="submit" value="'.$this->GetTranslation('UsersOpenProfile').'" name="gotoprofile" />';
	echo $this->FormClose();
	echo '</td></tr></table><br />'."\n";

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;\">\n";

	// pagination
	if ($pagination['text'] == true)
	{
		echo '<tr><td colspan="5"><small><small>'.$pagination['text'].'</small></small></td></tr>'."\n";
	}

	// list header
	echo '<tr>'.
			'<th><a href="?sort=name">'.$this->GetTranslation('UsersName').( $_GET['sort'] == 'name' || $_REQUEST['user'] == true ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="?sort=pages">'.$this->GetTranslation('UsersPages').( $_GET['sort'] == 'pages' || $_GET['sort'] == false ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="?sort=comments">'.$this->GetTranslation('UsersPosts').( $_GET['sort'] == 'comments' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="?sort=revisions">'.$this->GetTranslation('UsersRevisions').( $_GET['sort'] == 'revisions' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="?sort=signup">'.$this->GetTranslation('UsersSignup').( $_GET['sort'] == 'signup' ? '&nbsp;&darr;' : '' ).'</a></th>'.
			'<th><a href="?sort=session">'.$this->GetTranslation('UsersLastSession').( $_GET['sort'] == 'session' ? '&nbsp;&darr;' : '' ).'</a></th>'.
		"</tr>\n";

	// list entries
	if ($users == false)
	{
		echo '<tr class="lined"><td colspan="5" align="center" style="padding:10px;"><small><em>'.$this->GetTranslation('UsersNoMatching')."</em></small></td></tr>\n";
	}
	else
	{
		foreach ($users as $user)
		{
			echo '<tr class="lined">'.
					'<td style="padding-left:5px;"><a href="?profile='.htmlspecialchars($user['name']).'">'.$user['name'].'</a></td>'.
					'<td align="center">'.$user['total_pages'].'</td>'.
					'<td align="center">'.$user['total_comments'].'</td>'.
					'<td align="center">'.$user['total_revisions'].'</td>'.
					'<td align="center">'.$this->GetTimeStringFormatted($user['signuptime']).'</td>'.
					'<td align="center">'.$this->GetTimeStringFormatted($user['session_time']).'</td>'.
			"</tr>\n";
		}
	}

	// pagination
	if ($pagination['text'] == true)
	{
		echo '<tr><td colspan="5"><small><small>'.$pagination['text'].'</small></small></td></tr>'."\n";
	}

	echo "</table>\n";
}

?>