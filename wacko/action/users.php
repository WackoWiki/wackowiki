<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$where			= '';
$order			= '';
$param			= '';
$groups			= '';
$user_groups	= '';
$error			= '';

// display user profile
if (isset($_REQUEST['profile']) && $_REQUEST['profile'] == true)
{
	$profile = isset($_GET['profile']) ? $_GET['profile'] : (isset($_POST['profile']) ? $_POST['profile'] : '');

	// does requested user exists?
	if (false == $user = $this->load_user($profile))
	{
		$this->show_message( str_replace('%2', htmlspecialchars($_user_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET), str_replace('%1', $this->supertag, $this->get_translation('UsersNotFound'))) );
	}
	else
	{
		// usergroups
		if (is_array($this->config['aliases']))
		{
			// collecting usergroup names where user takes membership
			foreach ($this->config['aliases'] as $group_name => $group_str)
			{
				$group_users = explode('\n', $group_str);

				if (in_array($user['user_name'], $group_users))
				{
					$groups[] = '<a href="'.$this->href('', ($this->config['groups_page']), 'profile='.htmlspecialchars($group_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'').'" class="group-link"><span class="icon"></span>'.$group_name.'</a>';
				}
			}

			if ($groups == true)
			{
				$user_groups = implode(', ', $groups);
			}

			unset($group_name, $group_str, $groups);
		}

		if ($this->page['page_lang'] != $user['account_lang'])
		{
			#$user['user_name'] = $this->do_unicode_entities($user['user_name'], $user['account_lang']);
			#$user['real_name'] = $this->do_unicode_entities($user['real_name'], $user['account_lang']);
		}

		// prepare and send personal message
		if ($this->config['enable_email'] == true
			&& isset($_POST['send_pm'])
			&& $_POST['mail_body'] == true
			&& $this->get_user()
			&& $user['allow_intercom'] == 1
			&& $user['email']
			&& !$user['email_confirm'])
		{
			// check for errors
			// message is too long
			if (strlen($_POST['mail_body']) > INTERCOM_MAX_SIZE)
			{
				$error = str_replace('%1', strlen($_POST['mail_body']) - INTERCOM_MAX_SIZE, $this->get_translation('UsersPMOversized'));
			}
			// personal messages flood control
			else if (isset($_SESSION['intercom_delay']) && ((time() - $_SESSION['intercom_delay']) < $this->config['intercom_delay']))
			{
				$error = str_replace('%1', $this->config['intercom_delay'], $this->get_translation('UsersPMFlooded'));
			}

			// proceed if no error encountered
			if ($error)
			{
				$this->set_message($error);
			}
			else
			{
				// compose message
				$prefix		= rtrim(str_replace(array('https://www.', 'https://', 'http://www.', 'http://'), '', $this->config['base_url']), '/');
				$msg_id		= date('ymdHi').'.'.mt_rand(100000, 999999).'@'.$prefix;
				$subject	= ( strpos($_POST['mail_subject'], '['.$prefix.'] ') === false ? '['.$prefix.'] ' : '' ).( $_POST['mail_subject'] ? $_POST['mail_subject'] : '(no subject)' );
				$body		= str_replace('%1', $this->get_user_name(), $this->get_translation('UsersPMBody'));
				$body		= str_replace('%2', rtrim($this->config['base_url'], '/'), $body);
				$body		= str_replace('%3', $this->href('', $this->tag, 'profile='.$this->get_user_name().'&ref='.rawurlencode(base64_encode($msg_id.'@@'.$subject)).'#contacts'), $body);
				$body		= str_replace('%4', $this->config['abuse_email'], $body);
				$body		= str_replace('%5', $_POST['mail_body'], $body);

				// compose headers
				$headers	= array('Message-ID: <$msg_id>');

				if (isset($_POST['ref']) && $_POST['ref'] == true)
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
					$body .= "\n\n".$this->get_translation('MailGoodbye')."\n".$this->config['site_name']."\n".$this->config['base_url'];

					$this->send_mail($user['email'], $subject, $body, 'no-reply@'.$prefix, '', $headers, true);
					$this->set_message($notice);
					$this->log(4, str_replace('%2', $user['user_name'], str_replace('%1', $this->get_user_name(), $this->get_translation('LogPMSent', $this->config['language']))));
					$_SESSION['intercom_delay']	= time();
					$_POST['mail_body']			= '';
					$_POST['mail_subject']		= '';
					$_POST['ref']				= '';
				}
			}

			unset($error, $notice, $body, $subject, $referrer, $prefix, $headers, $msg_id);
		}

		// header and profile data
		echo '<h1>'.$user['user_name'].'</h1>';
		echo '<small><a href="'.$this->href('', $this->tag).'">&laquo; '.$this->get_translation('UsersList')."</a></small>\n";
		echo '<h2>'.$this->get_translation('UsersProfile').'</h2>'."\n";

		// basic info
?>
		<table style="border-spacing: 3px; border-collapse: separate;">
			<tr class="lined">
				<td class="userprofil"><?php echo $this->get_translation('RealName'); ?></td>
				<td><?php echo $user['real_name']; ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->get_translation('UsersSignupDate'); ?></td>
				<td><?php echo $this->get_time_formatted($user['signup_time']); ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->get_translation('UsersLastSession'); ?></td>
				<td><?php echo ( $user['hide_lastsession'] == 1
					? '<em>'.$this->get_translation('UsersSessionHidden').'</em>'
					: ( !$user['last_visit'] || $user['last_visit'] == SQL_NULLDATE
						? '<em>'.$this->get_translation('UsersSessionNA').'</em>'
						: $this->get_time_formatted($user['last_visit']) )
					); ?></td>
			</tr>
			<tr class="lined"><?php // Have all user pages as sub pages of the current Users page. ?>
				<td class="userprofil"><?php echo $this->get_translation('UserSpace'); // TODO: this might be placed somewhere else, just put it here for testing ?></td>
				<td><a href="<?php echo $this->href('', ($this->config['users_page'].'/'.$user['user_name'])); ?>"><?php echo $this->config['users_page'].'/'.$user['user_name']; ?></a></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><a href="<?php echo $this->href('', $this->config['groups_page']); ?>"><?php echo $this->get_translation('UsersGroupMembership'); ?></a></td>
				<td><?php echo ( $user_groups == true ? $user_groups : '<em>'.$this->get_translation('UsersNA2').'</em>' ); ?></td>
			</tr>
		</table>
<?php
		// hide contact form if profil is equal with user
		if ($user['user_id'] != $this->get_user_id())
		{
			// contact form
			echo '<h2>'.$this->get_translation('UsersContact').'</h2>'."\n";

			// only registered users can send PMs
			if ($this->get_user())
			{
				// decompose reply referrer
				if (isset($_GET['ref']) && $_GET['ref'] == true)
				{
					list($_POST['ref'], $_POST['mail_subject']) = explode('@@', base64_decode(rawurldecode($_GET['ref'])), 2);

					if (substr($_POST['mail_subject'], 0, 3) != 'Re:')
					{
						$_POST['mail_subject'] = 'Re: '.$_POST['mail_subject'];
					}
				}
?>
			<br />
			<?php echo $this->form_open('personal_message'); ?>
			<input type="hidden" name="profile" value="<?php echo htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
			<?php
			if (isset($_POST['ref']))
			{
				echo '<input type="hidden" name="ref" value="'.htmlspecialchars($_POST['ref'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" />';
			}?>
			<table class="formation">
<?php
				// user must allow incoming messages, and needs confirmed email address set
				if ($this->config['enable_email'] == true && $user['allow_intercom'] == 1 && $user['email'] && !$user['email_confirm'])
				{
?>
				<tr>
					<td class="label" style="width:50px; white-space:nowrap;"><?php echo $this->get_translation('UsersIntercomSubject'); ?>:</td>
					<td>
						<input name="mail_subject" value="<?php echo (isset($_POST['mail_subject']) ? htmlspecialchars($_POST['mail_subject'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ""); ?>" size="60" maxlength="200" />
						<?php
						if (isset($_POST['ref']))
						{
							echo '&nbsp;&nbsp; <a href="'.$this->href('', '', 'profile='.$user['user_name'].'#contacts').'">'.$this->get_translation('UsersIntercomSubjectN').'</a>';
						} ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><textarea name="mail_body" cols="80" rows="15"><?php echo (isset($_POST['mail_body']) ? htmlspecialchars($_POST['mail_body'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ""); ?></textarea></td>
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
					echo '<tr><td colspan="2" style="text-align:center;"><strong><em>'.$this->get_translation('UsersIntercomDisabled').'</em></strong></td></tr>';
				}
?>
			</table>
			<?php echo $this->form_close(); ?>
<?php
			}
			else
			{
				echo '<table class="formation"><tr><td colspan="2" style="text-align:center;"><em>'.$this->get_translation('UsersPMNotLoggedIn').'</em></td></tr></table>';
			}
		}

		// user-owned pages
		$limit = 10;

		echo '<h2 id="pages">'.$this->get_translation('UsersPages').'</h2>'."\n";
		echo '<div class="indent"><small>'.$this->get_translation('UsersOwnedPages').': '.$user['total_pages'].'&nbsp;&nbsp;&nbsp; '.$this->get_translation('UsersRevisionsMade').': '.$user['total_revisions']."</small></div><br />\n";

		$pagination = $this->pagination($user['total_pages'], $limit, 'd', 'profile='.$user['user_name'].'&amp;sort='.( isset($_GET['sort']) && $_GET['sort'] != 'name' ? 'date' : 'name' ).'#pages');

		if ($user['total_pages'])
		{
			$pages = $this->load_all(
				"SELECT page_id, tag, title, created, page_lang ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE owner_id = '".$user['user_id']."' ".
					"AND comment_on_id = '0' ".
					"AND deleted <> '1' ".
				"ORDER BY ".( isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'tag ASC' : 'created DESC' )." ".
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination
			echo '<small>'.( isset($_GET['sort']) && $_GET['sort'] == 'name' ? '<a href="'.$this->href('', '', 'profile='.$user['user_name'].'&amp;sort=date').'#pages">'.$this->get_translation('UsersDocsSortDate').'</a>' : '<a href="'.$this->href('', '', 'profile='.$user['user_name'].'&amp;sort=name').'#pages">'.$this->get_translation('UsersDocsSortName').'</a>' ).'</small>';
			if (isset($pagination['text']))
				echo '<span class="pagination">'.$pagination['text']."</span>\n";

			// pages list itself
			echo '<div>'."\n";

			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id'], $this->get_user_name()) === true)
				{
					// check current page lang for different charset to do_unicode_entities() against
					if ($this->page['page_lang'] != $page['page_lang'])
					{
						$_lang = $page['page_lang'];
					}
					else
					{
						$_lang = '';
					}

					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					echo '<small>'.$this->get_time_formatted($page['created']).'</small>  &mdash; '.$this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, $_lang)."<br />\n";

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
		$limit = 10;

		echo '<h2 id="comments">'.$this->get_translation('UsersComments').'</h2>'."\n";

		if ($this->user_allowed_comments())
		{
			echo '<div class="indent"><small>'.$this->get_translation('UsersCommentsPosted').': '.$user['total_comments']."</small></div>\n";

			$pagination = $this->pagination($user['total_comments'], $limit, 'c', 'profile='.$user['user_name'].'#comments');

			if ($user['total_comments'])
			{
				$comments = $this->load_all(
					"SELECT c.page_id, c.tag, c.title, c.created, c.comment_on_id, p.title AS page_title, p.tag AS page_tag, c.page_lang ".
					"FROM {$this->config['table_prefix']}page c ".
						"LEFT JOIN ".$this->config['table_prefix']."page p ON (c.comment_on_id = p.page_id) ".
					"WHERE c.owner_id = '".$user['user_id']."' ".
						"AND c.comment_on_id <> '0' ".
						"AND c.deleted <> '1' ".
						"AND p.deleted <> '1' ".
					"ORDER BY c.created DESC ".
					"LIMIT {$pagination['offset']}, $limit");

				// pagination
				if (isset($pagination['text']))
				{
					echo '<span class="pagination">'.$pagination['text']."</span>\n";
				}

				// comments list itself
				echo '<div>'."\n";

				foreach ($comments as $comment)
				{
					if (!$this->config['hide_locked'] || $this->has_access('read', $comment['comment_on_id'], $this->get_user_name()) === true)
					{
						// check current page lang for different charset to do_unicode_entities() against
						if ($this->page['page_lang'] != $comment['page_lang'])
						{
							$_lang = $comment['page_lang'];
						}
						else
						{
							$_lang = '';
						}

						// cache page_id for for has_access validation in link function
						$this->page_id_cache[$comment['tag']] = $comment['page_id'];

						echo '<small>'.$this->get_time_formatted($comment['created']).'</small>  &mdash; '.$this->link('/'.$comment['tag'], '', $comment['title'], $comment['page_tag'], 0, 1, $_lang)."<br />\n";

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
		else
		{
			echo $this->get_translation('CommentsDisabled');
		}

		// last user uploads
		// show files only for registered users
		if ($this->get_user())
		{
			$limit = 10;

			echo '<h2 id="uploads">'.$this->get_translation('UsersUploads').'</h2>'."\n";

			if ($this->config['upload'] == 1 || $this->is_admin())
			{
				echo '<div class="indent"><small>'.$this->get_translation('UsersFilesUploaded').': '.$user['total_uploads']."</small></div>\n";

				$pagination = $this->pagination($user['total_uploads'], $limit, 'u', 'profile='.$user['user_name'].'#comments');

				if ($user['total_uploads'])
				{
					$uploads = $this->load_all(
							"SELECT u.page_id, u.user_id, u.file_name, u.file_description, u.uploaded_dt, u.hits, u.file_size, u.upload_lang, c.tag file_on_page ".
							"FROM {$this->config['table_prefix']}upload u ".
							"LEFT JOIN {$this->config['table_prefix']}page c ON (u.page_id = c.page_id) ".
							"WHERE u.user_id = '".$user['user_id']."' ".
							"AND u.deleted <> '1' ".
							#"AND p.deleted <> '1' ".
							"ORDER BY u.uploaded_dt DESC ".
							"LIMIT {$pagination['offset']}, $limit");

					// pagination
					if (isset($pagination['text']))
					{
						echo '<span class="pagination">'.$pagination['text']."</span>\n";
					}

					// uploads list itself
					echo '<div>'."\n";

					$separator	= ' . . . . . . . . . . . . . . . . ';

					foreach ($uploads as $upload)
					{
						if (!$this->config['hide_locked']
							|| ($upload['page_id'] && $this->has_access('read', $upload['page_id'], $this->get_user_name()) === true)
							||	!$upload['page_id'])
						{
							// check current page lang for different charset to do_unicode_entities() against
							if ($this->page['page_lang'] != $upload['upload_lang'])
							{
								$_lang = $upload['upload_lang'];
							}
							else
							{
								$_lang = '';
							}

							if ($upload['file_description'])
							{
								if ($_lang)
								{
									$upload['file_description'] = $this->do_unicode_entities($upload['file_description'], $_lang);
								}

								$file_description = ' <span class="editnote">['.$upload['file_description'].']</span>';
							}
							else
							{
								$file_description = '';
							}

							preg_match('/^[^\/]+/', $upload['file_on_page'], $sub_tag);

							if ($upload['page_id']) // !$global
							{
								// cache page_id for for has_access validation in link function
								$this->page_id_cache[$upload['file_on_page']] = $upload['page_id'];

								$path2		= '_file:/'.($this->slim_url($upload['file_on_page'])).'/';
								$on_page	= $this->get_translation('To').' '.$this->link('/'.$upload['file_on_page'], '', $this->get_page_title('', $upload['page_id']), '', 0, 1, $_lang).' &nbsp;&nbsp;<span title="'.$this->get_translation("Cluster").'">&rarr; '.$sub_tag[0];
							}
							else
							{
								$path2		= '_file:';
								$on_page	= '<span title="">&rarr; '.'global';
							}

							echo '<small>'.$this->get_time_formatted($upload['uploaded_dt']).'</small>  &mdash; '.$this->link($path2.$upload['file_name'], '', $upload['file_name'], '', 0, 1, $_lang).$separator.' '.$on_page.'</span>'.$file_description."<br />\n";

							$i = 0;

							if (++$i >= $limit) break 1;
						}
					}

					echo "</div>\n";

					unset($uploads, $upload, $limit, $i);
				}
				else
				{
					echo '<em>'.$this->get_translation('UsersNA2').'</em>';
				}
			}
			else
			{
				echo $this->get_translation('CommentsDisabled');
			}
		}
	}
}
// USERLIST
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
			$this->redirect($this->href('', '', 'profile='.htmlspecialchars($_GET['user'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)));
		}
		else
		{
			$where = "WHERE user_name LIKE '%".quote($this->dblink, $_GET['user'])."%' ";
			$param = "user=".htmlspecialchars($_GET['user'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
		}
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'name')
	{
		$order = "ORDER BY user_name ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'pages')
	{
		$order = "ORDER BY total_pages ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'comments')
	{
		$order = "ORDER BY total_comments ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'uploads')
	{
		$order = "ORDER BY total_uploads ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'revisions')
	{
		$order = "ORDER BY total_revisions ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'signup')
	{
		$order = "ORDER BY signup_time ";
		$param = "sort=".$_GET['sort'];
	}
	else if (isset($_GET['sort']) && $_GET['sort'] == 'last_visit')
	{
		$order = "ORDER BY last_visit ";
		$param = "sort=".$_GET['sort'];
	}

	if (isset($_GET['order']) && $_GET['order'] == 'asc')
	{
		$order .= "ASC ";
		$param .= "&amp;order=asc";
	}
	else if (isset($_GET['order']) && $_GET['order'] == 'desc')
	{
		$order .= "DESC ";
		$param .= "&amp;order=desc";
	}

	$count = $this->load_single(
		"SELECT COUNT(user_name) AS n ".
		"FROM {$this->config['user_table']} ".
		($where == true ? $where : ''));

	$pagination = $this->pagination($count['n'], $limit, 'p', $param);

	// collect data
	$users = $this->load_all(
		"SELECT u.user_name, u.account_lang, u.signup_time, u.last_visit, u.total_pages, u.total_revisions, u.total_comments, u.total_uploads, s.hide_lastsession ".
		"FROM {$this->config['user_table']} u ".
			"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
		($where == true ? $where : '').
		($where ? 'AND ' : "WHERE ").
			"u.account_type = '0' ".
		($order == true ? $order : "ORDER BY u.total_pages DESC ").
		"LIMIT {$pagination['offset']}, $limit");

	// user filter form
	echo $this->form_open('search_user', '', 'get');
	echo '<table class="formation"><tr><td class="label">';
	echo $this->get_translation('UsersSearch').': </td><td>';
	echo '<input type="search" name="user" maxchars="40" size="40" value="'.(isset($_GET['user']) ? htmlspecialchars($_GET['user'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '').'" /> ';
	echo '<input id="submit" type="submit" value="'.$this->get_translation('UsersFilter').'" /> ';
	echo '<input id="button" type="submit" value="'.$this->get_translation('UsersOpenProfile').'" name="gotoprofile" />';
	echo '</td></tr></table><br />'."\n";
	echo $this->form_close();

	// pagination
	if (isset($pagination['text']))
	{
		echo '<br /><span class="pagination">'.$pagination['text']."</span>\n";
	}

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;border-spacing: 3px;border-collapse: separate;\">\n";

	// list header
	echo '<tr>'.
			'<th><a href="'.$this->href('', '', 'sort=name'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersName').( (isset($_GET['sort']) && $_GET['sort'] == 'name') || (isset($_REQUEST['user']) && $_REQUEST['user'] == true) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=pages'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersPages').( (isset($_GET['sort']) && $_GET['sort'] == 'pages') || (isset($_GET['sort']) && $_GET['sort'] == false) ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=comments'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersComments').( isset($_GET['sort']) && $_GET['sort'] == 'comments' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=revisions'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersRevisions').( isset($_GET['sort']) && $_GET['sort'] == 'revisions' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
		($this->get_user()
			?
			'<th><a href="'.$this->href('', '', 'sort=uploads'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersUploads').( isset($_GET['sort']) && $_GET['sort'] == 'uploads' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=signup'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersSignup').( isset($_GET['sort']) && $_GET['sort'] == 'signup' ? (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'.
			'<th><a href="'.$this->href('', '', 'sort=last_visit'.(isset($_GET['order']) && $_GET['order'] == 'asc' ? '&amp;order=desc' : '&amp;order=asc') ).'">'.$this->get_translation('UsersLastSession').( isset($_GET['sort']) && $_GET['sort'] == 'last_visit' ?  (isset($_GET['order']) && $_GET['order'] == 'asc' ? '&nbsp;&uarr;' : '&nbsp;&darr;' ) : '').'</a></th>'
			: '').
		"</tr>\n";

	// list entries
	if ($users == false)
	{
		echo '<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>'.$this->get_translation('UsersNoMatching')."</em></small></td></tr>\n";
	}
	else
	{
		foreach ($users as $user)
		{
			echo '<tr class="lined">';

			echo	'<td style="padding-left:5px;">'.$this->user_link($user['user_name'], $user['account_lang'], true, false).'</td>'.
					'<td style="text-align:center;">'.$user['total_pages'].'</td>'.
					'<td style="text-align:center;">'.$user['total_comments'].'</td>'.
					'<td style="text-align:center;">'.$user['total_revisions'].'</td>'.
				($this->get_user()
					?
					'<td style="text-align:center;">'.$user['total_uploads'].'</td>'.
					'<td style="text-align:center;">'.$this->get_time_formatted($user['signup_time']).'</td>'.
					'<td style="text-align:center;">'.( $user['hide_lastsession'] == 1
					? '<em>'.$this->get_translation('UsersSessionHidden').'</em>'
					: (!$user['last_visit'] || $user['last_visit'] == SQL_NULLDATE
						? '<em>'.$this->get_translation('UsersSessionNA').'</em>'
						: $this->get_time_formatted($user['last_visit']))
					).'</td>'
					: '').
			"</tr>\n";
		}
	}

	echo "</table>\n";

	// pagination
	if (isset($pagination['text']))
	{
		echo '<br /><span class="pagination">'.$pagination['text']."</span>\n";
	}
}

?>