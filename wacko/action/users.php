<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($max)) $max = 0;

$logged_in = $this->get_user();

// display user profile
if (($profile = @$_REQUEST['profile']))
{
	// hide article H1 header
	$this->hide_article_header = true;

	// does requested user exists?
	if (!($user = $this->load_user($profile)))
	{
		$this->show_message(Ut::perc_replace($this->_t('UsersNotFound'),
				$this->supertag, htmlspecialchars($profile, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)));
	}
	else if (!$user['enabled'])
	{
		$this->show_message($this->_t('AccountDisabled'));
	}
	else
	{
		$profile = 'profile=' . rawurlencode($user['user_name']);

		// usergroups
		$user_groups = '';
		if (is_array($this->config['aliases']))
		{
			// collecting usergroup names where user takes membership
			$groups = [];
			foreach ($this->config['aliases'] as $group_name => $group_str)
			{
				$group_users = explode('\n', $group_str);

				if (in_array($user['user_name'], $group_users))
				{
					$groups[] = $this->group_link($group_name, '', true, false);
				}
			}

			$user_groups = implode(', ', $groups);
		}

		if ($this->page['page_lang'] != $user['account_lang'])
		{
			// $user['user_name'] = $this->do_unicode_entities($user['user_name'], $user['account_lang']);
			// $user['real_name'] = $this->do_unicode_entities($user['real_name'], $user['account_lang']);
		}

		// prepare and send personal message
		if ($this->config['enable_email']
			&& isset($_POST['send_pm'])
			&& @$_POST['mail_body']
			&& isset($_POST['mail_subject'])
			&& $logged_in
			&& $user['allow_intercom']
			&& $user['email']
			&& !$user['email_confirm'])
		{
			// check for errors
			$error = '';

			// message is too long
			if (strlen($_POST['mail_body']) > INTERCOM_MAX_SIZE)
			{
				$error = Ut::perc_replace($this->_t('UsersPMOversized'), strlen($_POST['mail_body']) - INTERCOM_MAX_SIZE);
			}
			// personal messages flood control
			else if (isset($this->sess->intercom_delay) && time() - $this->sess->intercom_delay < $this->config['intercom_delay'])
			{
				$error = Ut::perc_replace($this->_t('UsersPMFlooded'), $this->config['intercom_delay']);
			}

			// proceed if no error encountered
			if ($error)
			{
				$this->set_message($error, 'error');
			}
			else
			{
				// compose message
				$prefix		= rtrim(str_replace(array('https://www.', 'https://', 'http://www.', 'http://'), '', $this->config['base_url']), '/');
				$msg_id		= date('ymdHi').'.'.Ut::rand(100000, 999999).'@'.$prefix;
				$subject	= $_POST['mail_subject'];
				if ($subject === '')
				{
					$subject = '(no subject)';
				}
				if (strpos($subject, $prefix1 = '[' . $prefix . '] ') === false)
				{
					$subject = $prefix1 .  $subject;
				}
				$body = Ut::perc_replace($this->_t('UsersPMBody'),
						$this->get_user_name(),
						rtrim($this->config['base_url'], '/'),
						$this->href('', $this->tag, $profile.'&ref='.rawurlencode(base64_encode($msg_id.'@@'.$subject)).'#contacts'),
						$this->config['abuse_email'],
						$_POST['mail_body']);

				// compose headers
				$headers	= [];
				$headers[] = "Message-ID: <$msg_id>";
				if (isset($_POST['ref']) && ($ref = $_POST['ref']))
				{
					$headers[] = "In-Reply-To: <$ref>";
					$headers[] = "References: <$ref>";
				}

				$body .= "\n\n" . $this->_t('EmailGoodbye') . "\n" . $this->config['site_name'] . "\n" . $this->config['base_url'];

				// send email
				$this->send_mail($user['email'], $subject, $body, 'no-reply@'.$prefix, '', $headers, true);
				$this->set_message($this->_t('UsersPMSent'));
				$this->log(4, Ut::perc_replace($this->_t('LogPMSent', $this->config['language']), $this->get_user_name(), $user['user_name']));

				$this->sess->intercom_delay	= time();
				$_POST['mail_body']			= '';
				$_POST['mail_subject']		= '';
				$_POST['ref']				= '';
			}
		}

		// header and profile data
		echo '<h1>' . $user['user_name'] . '</h1>';
		echo '<small><a href="' . $this->href('', $this->tag) . '">&laquo; ' . $this->_t('UsersList') . "</a></small>\n";
		echo '<h2>' . $this->_t('UsersProfile') . "</h2>\n";

		// basic info
?>
		<table style="border-spacing: 3px; border-collapse: separate;">
			<tr class="lined">
				<td class="userprofil"><?php echo $this->_t('RealName'); ?></td>
				<td><?php echo $user['real_name']; ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->_t('UsersSignupDate'); ?></td>
				<td><?php echo $this->get_time_formatted($user['signup_time']); ?></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><?php echo $this->_t('UsersLastSession'); ?></td>
				<td><?php echo $user['hide_lastsession']
					? '<em>' . $this->_t('UsersSessionHidden') . '</em>'
					: ( $user['last_visit'] === SQL_DATE_NULL
						? '<em>' . $this->_t('UsersSessionNA') . '</em>'
						: $this->get_time_formatted($user['last_visit']) )
					; ?></td>
			</tr>
			<tr class="lined"><?php // Have all user pages as sub pages of the current Users page.
								?>
				<td class="userprofil"><?php echo $this->_t('UserSpace'); // TODO: this might be placed somewhere else, just put it here for testing ?></td>
				<td><a href="<?php echo $this->href('', ($this->config['users_page'] . '/' . $user['user_name'])); ?>"><?php echo $this->config['users_page'].'/'.$user['user_name']; ?></a></td>
			</tr>
			<tr class="lined">
				<td class="userprofil"><a href="<?php echo $this->href('', $this->config['groups_page']); ?>"><?php echo $this->_t('UsersGroupMembership'); ?></a></td>
				<td><?php echo ( $user_groups ? $user_groups : '<em>'.$this->_t('UsersNA2').'</em>' ); ?></td>
			</tr>
		</table>
<?php
		// hide contact form if profile is equal with current user
		if ($user['user_id'] != $this->get_user_id())
		{
			// contact form
			echo '<h2>' . $this->_t('UsersContact') . "</h2>\n";

			// only registered users can send PMs
			if ($logged_in)
			{
				$subject = &$_POST['mail_subject'];
				$ref = &$_POST['ref'];

				// decompose reply referrer
				if (isset($_GET['ref']) && $_GET['ref'])
				{
					list($ref, $subject) = explode('@@', base64_decode(rawurldecode($_GET['ref'])), 2);

					if (substr($subject, 0, 3) != 'Re:')
					{
						$subject = 'Re: ' . $subject;
					}
				}
?>
				<br />
				<?php echo $this->form_open('personal_message'); ?>
				<input type="hidden" name="profile" value="<?php echo htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
				<?php
				if (isset($ref))
				{
					echo '<input type="hidden" name="ref" value="'.htmlspecialchars($ref, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" />';
				}?>
				<table class="formation">
<?php
				// user must allow incoming messages, and needs confirmed email address set
				if ($this->config['enable_email'] && $user['allow_intercom'] && $user['email'] && !$user['email_confirm'])
				{
?>
				<tr>
					<td class="label" style="width:50px; white-space:nowrap;"><?php echo $this->_t('UsersIntercomSubject'); ?>:</td>
					<td>
						<input type="text" name="mail_subject" value="<?php echo (isset($subject) ? htmlspecialchars($subject, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ""); ?>" size="60" maxlength="200" />
						<?php
						if (isset($ref))
						{
							echo '&nbsp;&nbsp; <a href="'.$this->href('', '', $profile.'#contacts').'">'.$this->_t('UsersIntercomSubjectN').'</a>';
						} ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><textarea name="mail_body" cols="80" rows="15"><?php echo (isset($_POST['mail_body']) ? htmlspecialchars($_POST['mail_body'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ""); ?></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" id="submit" name="send_pm" value="<?php echo $this->_t('UsersIntercomSend'); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<small><?php echo $this->_t('UsersIntercomDesc');
						?></small>
					</td>
				</tr>
<?php
				}
				else
				{
					echo '<tr><td colspan="2" style="text-align:center;"><strong><em>'.$this->_t('UsersIntercomDisabled').'</em></strong></td></tr>';
				}
?>
			</table>
			<?php echo $this->form_close(); ?>
<?php
			}
			else
			{
				echo '<table class="formation"><tr><td colspan="2" style="text-align:center;"><em>'.$this->_t('UsersPMNotLoggedIn').'</em></td></tr></table>';
			}
		}

		// user-owned pages
		$limit = 10;

		echo '<h2 id="pages">' . $this->_t('UsersPages') . "</h2>\n";
		echo '<div class="indent"><small>' . $this->_t('UsersOwnedPages') . ': ' .  $user['total_pages'];
		echo '&nbsp;&nbsp;&nbsp; ' . $this->_t('UsersRevisionsMade') . ': ' . $user['total_revisions'] . "</small></div><br />\n";


		if ($user['total_pages'])
		{
			$sort_name = (isset($_GET['sort']) && $_GET['sort'] == 'name');
			$pagination = $this->pagination($user['total_pages'], $limit, 'd',
					$profile .  '&amp;sort=' . ($sort_name? 'name' : 'date') . '#pages');

			$pages = $this->db->load_all(
				"SELECT page_id, tag, title, created, page_lang ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE owner_id = '".$user['user_id']."' ".
					"AND comment_on_id = '0' ".
					"AND deleted <> '1' ".
				"ORDER BY ".($sort_name? 'tag ASC' : 'created DESC')." ".
				"LIMIT {$pagination['offset']}, $limit");

			// sorting and pagination
			echo '<small><a href="'.
				($sort_name? $this->href('', '', $profile . '&amp;sort=date') . '#pages">' . $this->_t('UsersDocsSortDate')
						   : $this->href('', '', $profile . '&amp;sort=name') . '#pages">' . $this->_t('UsersDocsSortName')
			    ) . '</a></small>';

			$this->print_pagination($pagination);

			// pages list itself
			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id'], $this->get_user_name()))
				{
					// check current page lang for different charset to do_unicode_entities() against
					$_lang = ($this->page['page_lang'] != $page['page_lang'])?  $page['page_lang'] : '';

					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					echo '<li class="lined"><small>' . $this->get_time_formatted($page['created']) . '</small>  &mdash; ';
					echo $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_lang) . "</li>\n";
				}
			}
			echo "</ul>\n";
		}
		else
		{
			echo '<em>' . $this->_t('UsersNA2') . '</em>';
		}

		// last user comments
		$limit = 10;

		echo '<h2 id="comments">' . $this->_t('UsersComments') . "</h2>\n";

		if ($this->user_allowed_comments())
		{
			echo '<div class="indent"><small>' . $this->_t('UsersCommentsPosted') . ': ' . $user['total_comments'] . "</small></div>\n";

			if ($user['total_comments'])
			{
				$pagination = $this->pagination($user['total_comments'], $limit, 'c', $profile . '#comments');
				$this->print_pagination($pagination);

				$comments = $this->db->load_all(
					"SELECT c.page_id, c.tag, c.title, c.created, c.comment_on_id, p.title AS page_title, p.tag AS page_tag, c.page_lang ".
					"FROM {$this->config['table_prefix']}page c ".
						"LEFT JOIN ".$this->config['table_prefix']."page p ON (c.comment_on_id = p.page_id) ".
					"WHERE c.owner_id = '".$user['user_id']."' ".
						"AND c.comment_on_id <> '0' ".
						"AND c.deleted <> '1' ".
						"AND p.deleted <> '1' ".
					"ORDER BY c.created DESC ".
					"LIMIT {$pagination['offset']}, $limit");

				// comments list itself
				echo '<ul class="ul_list">' . "\n";

				foreach ($comments as $comment)
				{
					if (!$this->config['hide_locked'] || $this->has_access('read', $comment['comment_on_id'], $this->get_user_name()))
					{
						// check current page lang for different charset to do_unicode_entities() against
						$_lang = ($this->page['page_lang'] != $comment['page_lang'])?  $comment['page_lang'] : '';

						// cache page_id for for has_access validation in link function
						$this->page_id_cache[$comment['tag']] = $comment['page_id'];

						echo '<li class="lined"><small>' . $this->get_time_formatted($comment['created']);
						echo '</small>  &mdash; ' . $this->link('/'.$comment['tag'], '', $comment['title'], $comment['page_tag'], 0, 1, $_lang) . "</li>\n";
					}
				}

				echo "</ul>\n";
			}
			else
			{
				echo '<em>' . $this->_t('UsersNA2') . '</em>';
			}
		}
		else
		{
			echo $this->_t('CommentsDisabled');
		}

		// last user uploads
		// show files only for registered users
		if ($logged_in)
		{
			$limit = 10;

			echo '<h2 id="uploads">' . $this->_t('UsersUploads') . "</h2>\n";

			if ($this->config['upload'] == 1 || $this->is_admin())
			{
				echo '<div class="indent"><small>' . $this->_t('UsersFilesUploaded') . ': ' . $user['total_uploads'] . "</small></div>\n";

				if ($user['total_uploads'])
				{
					$pagination = $this->pagination($user['total_uploads'], $limit, 'u', $profile . '#comments');
					$this->print_pagination($pagination);

					$uploads = $this->db->load_all(
							"SELECT u.page_id, u.user_id, u.file_name, u.file_description, u.uploaded_dt, u.hits, u.file_size, u.upload_lang, c.tag file_on_page ".
							"FROM {$this->config['table_prefix']}upload u ".
								"LEFT JOIN {$this->config['table_prefix']}page c ON (u.page_id = c.page_id) ".
							"WHERE u.user_id = '".$user['user_id']."' ".
							"AND u.deleted <> '1' ".
							// "AND p.deleted <> '1' ".
							"ORDER BY u.uploaded_dt DESC ".
							"LIMIT {$pagination['offset']}, $limit");

					// uploads list itself
					echo '<ul class="ul_list">'."\n";

					$separator	= ' . . . . . . . . . . . . . . . . ';

					foreach ($uploads as $upload)
					{
						if (!$this->config['hide_locked']
							|| !$upload['page_id']
							|| $this->has_access('read', $upload['page_id'], $this->get_user_name()))
						{
							// check current page lang for different charset to do_unicode_entities() against
							$_lang = ($this->page['page_lang'] != $upload['upload_lang'])?  $upload['upload_lang'] : '';

							if (($file_description = $upload['file_description']) !== '')
							{
								if ($_lang)
								{
									$file_description = $this->do_unicode_entities($file_description, $_lang);
								}

								$file_description = ' <span class="editnote">[' . $file_description . ']</span>';
							}

							preg_match('/^[^\/]+/', $upload['file_on_page'], $sub_tag);

							if ($upload['page_id']) // !$global
							{
								// cache page_id for for has_access validation in link function
								$this->page_id_cache[$upload['file_on_page']] = $upload['page_id'];

								$path2		= '_file:/' . $this->slim_url($upload['file_on_page']) . '/';
								$on_page	= $this->_t('To') . ' '.
									$this->link('/'. $upload['file_on_page'], '', $this->get_page_title('', $upload['page_id']), '', 0, 1, $_lang).
									' &nbsp;&nbsp;<span title="' . $this->_t("Cluster") . '">&rarr; ' . $sub_tag[0];
							}
							else
							{
								$path2		= '_file:';
								$on_page	= '<span title="">&rarr; global';
							}

							echo '<li class="lined"><small>' . $this->get_time_formatted($upload['uploaded_dt']);
							echo '</small>  &mdash; ' . $this->link($path2.$upload['file_name'], '', $upload['file_name'], '', 0, 1, $_lang);
							echo $separator . ' ' . $on_page . '</span>' . $file_description . "</li>\n";
						}
					}

					echo "</ul>\n";
				}
				else
				{
					echo '<em>'.$this->_t('UsersNA2').'</em>';
				}
			}
			else
			{
				// echo $this->_t('CommentsDisabled');
			}
		}
	}
}
// USERLIST
// display whole userlist instead of the particular profile
else
{
	$limit = $this->get_list_count($max);

	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	$sql_where = '';
	$sql_order = '';
	$_user0 = trim((string) @$_GET['user']);
	$_user = rawurlencode($_user0);
	if ($_user !== '')
	{
		// goto user profile directly if so desired
		if (isset($_GET['gotoprofile']) && $this->load_user($_user0))
		{
			$this->redirect($this->href('', '', 'profile=' . $_user));
		}
		else
		{
			$sql_where = "AND u.user_name LIKE " . $this->db->q('%' . $_user0 . '%') . " ";
		}
	}

	$params = function ($sort, $order) use ($_user)
	{
		$res = $sort? ("sort=" . $sort . '&amp;order=' . $order . ($_user !== ''? '&amp;' : '')) : '';
		if ($_user !== '')
		{
			$res .= "user=" . $_user;
		}
		return $res;
	};

	$_sort = @$_GET['sort'];
	$sort_modes =
	[
		'name' => 'user_name',
		'pages' => 'total_pages',
		'comments' => 'total_comments',
		'uploads' => 'total_uploads',
		'revisions' => 'total_revisions',
		'signup' => 'signup_time',
		'last_visit' => 'last_visit'
	];
	if (isset($sort_modes[$_sort]))
	{
		$_order = @$_GET['order'];
		$order_modes =
		[
			'asc' => 'ASC',
			'desc' => 'DESC'
		];
		if (!isset($order_modes[$_order]))
		{
			$_order = 'asc';
		}

		$sql_order = 'ORDER BY u.' . $sort_modes[$_sort] . ' ' . $order_modes[$_order] . ' ';
	}
	else
	{
		$_sort = $_order = '';
		$sql_order = 'ORDER BY u.total_pages DESC ';
	}

	$sql_where =
		"WHERE u.account_type = '0' ".
			"AND u.enabled = '1' ".
			$sql_where;

	$count = $this->db->load_single(
		"SELECT COUNT(u.user_name) AS n ".
		"FROM {$this->config['user_table']} u ".
		$sql_where);

	$pagination = $this->pagination($count['n'], $limit, 'p', $params($_sort, $_order));

	// collect data
	$users = $this->db->load_all(
		"SELECT u.user_name, u.account_lang, u.signup_time, u.last_visit, u.total_pages, u.total_revisions, u.total_comments, u.total_uploads, s.hide_lastsession ".
		"FROM {$this->config['user_table']} u ".
			"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
		$sql_where.
		$sql_order.
		"LIMIT {$pagination['offset']}, $limit");

	// user filter form
	echo $this->form_open('search_user', ['form_method' => 'get']);
	echo '<table class="formation"><tr><td class="label">';
	echo $this->_t('UsersSearch') . ': </td><td>';
	echo '<input type="search" required="required" name="user" maxchars="40" size="40" value="'.
			htmlspecialchars($_user0, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET). '" /> ';
	echo '<input type="submit" id="submit" value="' . $this->_t('UsersFilter') . '" /> ';
	//echo '<input type="submit" id="button" value="' . $this->_t('UsersOpenProfile') . '" name="gotoprofile" />';
	echo '</td></tr></table><br />'."\n";
	echo $this->form_close();

	$this->print_pagination($pagination);

	// print list
	echo "<table style=\"width:100%; white-space:nowrap; padding-right:20px;border-spacing: 3px;border-collapse: separate;\">\n";

	// change sorting order navigation bar
	$sort_link = function ($sort, $text) use ($_sort, $_order, $params)
	{
		$order = 'asc';
		$arrow = '';
		if ($_sort == $sort)
		{
			if ($_order == 'asc')
			{
				$order = 'desc';
				$arrow = '&nbsp;&uarr;';
			}
			else
			{
				$arrow = '&nbsp;&darr;';
			}
		}
		echo '<th><a href="' . $this->href('', '', $params($sort, $order)) . '">';
		echo $this->_t($text);
		echo $arrow;
		echo '</a></th>';
	};

	echo '<tr>';
	$sort_link('name', 'UsersName');
	$sort_link('pages', 'UsersPages');
	$sort_link('comments', 'UsersComments');
	$sort_link('revisions', 'UsersRevisions');
	if ($logged_in)
	{
		$sort_link('uploads', 'UsersUploads');
		$sort_link('signup', 'UsersSignup');
		$sort_link('last_visit', 'UsersLastSession');
	}
	echo "</tr>\n";

	// list entries
	if (!$users)
	{
		echo '<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>' .
				$this->_t('UsersNoMatching') . "</em></small></td></tr>\n";
	}
	else
	{
		foreach ($users as $user)
		{
			echo '<tr class="lined">';

			echo	'<td style="padding-left:5px;">' . $this->user_link($user['user_name'], $user['account_lang'], true, false) . '</td>'.
					'<td style="text-align:center;">' . $user['total_pages'] . '</td>'.
					'<td style="text-align:center;">' . $user['total_comments'] . '</td>'.
					'<td style="text-align:center;">' . $user['total_revisions'] . '</td>';
			if ($logged_in)
			{
				echo
					'<td style="text-align:center;">' . $user['total_uploads'] . '</td>'.
					'<td style="text-align:center;">' . $this->get_time_formatted($user['signup_time']) . '</td>'.
					'<td style="text-align:center;">' . ($user['hide_lastsession']
					? '<em>' . $this->_t('UsersSessionHidden') . '</em>'
					: ($user['last_visit'] === SQL_DATE_NULL
						? '<em>' . $this->_t('UsersSessionNA') . '</em>'
						: $this->get_time_formatted($user['last_visit']))
					).'</td>';
			}
			echo "</tr>\n";
		}
	}

	echo "</table>\n";

	$this->print_pagination($pagination);
}

?>
