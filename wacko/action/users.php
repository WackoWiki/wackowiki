<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action args:
$max = (int) @$max;
$group_id = (int) @$group_id;

$logged_in = $this->get_user();

// display user profile
if (!$group_id && ($profile = @$_REQUEST['profile'])) // not GET so private message can POST here
{
	// hide article H1 header
	$this->hide_article_header = true;

	// does requested user exists?
	if (!($user = $this->load_user($profile)))
	{
		$tpl->not_found = Ut::perc_replace($this->_t('UsersNotFound'),
				$this->href(), htmlspecialchars($profile, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET));
	}
	else if (!$user['enabled'])
	{
		$tpl->disabled = true;
	}
	else
	{
		$profile = ['profile' => $user['user_name']];

		// usergroups
		if (is_array($this->db->aliases))
		{
			// collecting usergroup names where user takes membership
			$groups = [];
			foreach ($this->db->aliases as $group_name => $group_str)
			{
				$group_users = explode('\n', $group_str);

				if (in_array($user['user_name'], $group_users))
				{
					$groups[] = $this->group_link($group_name, '', true, false);
				}
			}

			$tpl->u_userGroups_list = implode(', ', $groups);
		}
		else
		{
			$tpl->u_userGroups_na = true;
		}

		if ($this->page['page_lang'] != $user['account_lang'])
		{
			// $user['user_name'] = $this->do_unicode_entities($user['user_name'], $user['account_lang']);
			// $user['real_name'] = $this->do_unicode_entities($user['real_name'], $user['account_lang']);
		}

		$allow_intercom = ($this->db->enable_email && $logged_in && $user['email'] && ($this->is_admin() || ($user['allow_intercom'] && !$user['email_confirm'])));

		// prepare and send personal message
		if (@$_POST['_action'] === 'personal_message' && $allow_intercom && $_POST['mail_body'])
		{
			// check for errors
			$error = '';

			// message is too long
			if (strlen($_POST['mail_body']) > INTERCOM_MAX_SIZE)
			{
				$error = Ut::perc_replace($this->_t('UsersPMOversized'), strlen($_POST['mail_body']) - INTERCOM_MAX_SIZE);
			}
			// personal messages flood control
			else if (time() - @$this->sess->intercom_delay < $this->db->intercom_delay)
			{
				$error = Ut::perc_replace($this->_t('UsersPMFlooded'), $this->db->intercom_delay);
			}

			// proceed if no error encountered
			if ($error)
			{
				$this->set_message($error, 'error');
			}
			else
			{
				// compose message
				$prefix		= rtrim(str_replace(['https://www.', 'https://', 'http://www.', 'http://'], '', $this->db->base_url), '/');
				$msg_id		= date('ymdHi') . '.' . Ut::rand(100000, 999999) . '@' . $prefix;
				$subject	= $_POST['mail_subject'];
				if ($subject === '')
				{
					$subject = '(no subject)';
				}
				if (strpos($subject, $prefix1 = '[' . $prefix . ']') === false)
				{
					$subject = $prefix1 . ' ' . $subject;
				}

				$save = $this->set_language($user['user_lang'], true);

				$body =
					$this->_t('EmailHello') . $user['user_name'] . ",\n\n".
					Ut::perc_replace($this->_t('UsersPMBody'),
							$this->get_user_name(),
							rtrim($this->db->base_url, '/'),
							Ut::amp_decode($this->href('', '',
								['profile' => $this->get_user_name(),
								'ref' => Ut::http64_encode(gzdeflate($msg_id.'@@'.$subject, 9)),
								'#' => 'contacts'])),
							$this->db->abuse_email,
							$_POST['mail_body']);

				// compose headers
				$headers = [];
				$headers['Message-ID'] = "<$msg_id>";
				if (($ref = @$_POST['ref']))
				{
					$headers['In-Reply-To'] = "<$ref>";
					$headers['References'] = "<$ref>";
				}

				$body .= "\n\n" . $this->_t('EmailGoodbye') . "\n" . $this->db->site_name . "\n" . $this->db->base_url;

				// send email
				$this->send_mail($user['user_name'] . ' <' . $user['email'] . '>', $subject, $body, 'no-reply@' . $prefix, '', $headers, true);
				$this->set_language($save, true);

				$this->set_message($this->_t('UsersPMSent'));
				$this->log(4, Ut::perc_replace($this->_t('LogPMSent', SYSTEM_LANG), $this->get_user_name(), $user['user_name']));

				$this->sess->intercom_delay	= time();
				$this->http->redirect($this->href('', '', $profile + ['#' => 'contacts']));
			}
		}

		// header and profile data
		$tpl->u_user = $user;
		//$tpl->u_href = $this->href('', $this->tag);
		$tpl->u_href = $this->href(); // STS let's test - tag here is by default

		// basic info
		if ($user['hide_lastsession'])
		{
			$tpl->u_last_hidden = true;
		}
		else if ($user['last_visit'] === SQL_DATE_NULL)
		{
			$tpl->u_last_na = true;
		}
		else
		{
			$tpl->u_last_last_visit = $user['last_visit'];
		}

		$tpl->u_userPage_href = $this->href('', ($this->db->users_page . '/' . $user['user_name']));
		$tpl->u_userPage_text = $this->db->users_page.'/'.$user['user_name'];

		// hide contact form if profile is equal with current user
		if ($user['user_id'] != $this->get_user_id())
		{
			// only registered users can send PMs
			if ($logged_in)
			{
				$subject = (string) @$_POST['mail_subject'];
				$ref = (string) @$_POST['ref'];
				$body = (string) @$_POST['mail_body'];

				// decompose reply referrer
				if (($ref0 = @$_GET['ref']))
				{
					$ref0 = @gzinflate(Ut::http64_decode($ref0)); // suppress ALL errors on parsing user supplied data!
					if ($ref0 && strpos($ref0, '@@') !== false)
					{
						// TODO sanitize? someone can inject something into
						list($ref, $subject) = explode('@@', Ut::strip_controls($ref0), 2);

						if (strncmp($subject, 'Re:', 3))
						{
							$subject = 'Re: ' . $subject;
						}
					}
				}

				$tpl->u_pm_pm_href = $this->href();
				$tpl->u_pm_pm_username = $user['user_name'];
				if ($ref)
				{
					$tpl->u_pm_pm_ref_ref = $ref;
				}

				// user must allow incoming messages, and needs confirmed email address set
				if ($allow_intercom)
				{
					$tpl->u_pm_pm_ic_subj = $subject;
					if ($ref)
					{
						$tpl->u_pm_pm_ic_ref_href = $this->href('', '', $profile + ['#' => 'contacts']);
					}
					$tpl->u_pm_pm_ic_body = $body;
				}
				else
				{
					$tpl->u_pm_pm_disabled = true;
				}
			}
			else
			{
				$tpl->u_pm_not = true;
			}
		}

		// user-owned pages
		if ($user['total_pages'])
		{
			$sort_name = (isset($_GET['sort']) && $_GET['sort'] == 'name');
			$pagination = $this->pagination($user['total_pages'], 10, 'd',
					$profile + ['sort' => ($sort_name? 'name' : 'date'), '#' => 'pages']);

			$pages = $this->db->load_all(
				"SELECT page_id, tag, title, created, page_lang ".
				"FROM {$this->db->table_prefix}page ".
				"WHERE owner_id = '".$user['user_id']."' ".
					"AND comment_on_id = '0' ".
					"AND deleted <> '1' ".
				"ORDER BY ".($sort_name? 'tag ASC' : 'created DESC')." ".
				$pagination['limit']);

			// sorting and pagination
			if ($sort_name)
			{
				$tpl->u_pages_date_href = $this->href('', '', $profile + ['sort' => 'date']);
			}
			else
			{
				$tpl->u_pages_name_href = $this->href('', '', $profile + ['sort' => 'name']);
			}

			$tpl->u_pages_pagination_text = $pagination['text'];

			// pages list itself
			foreach ($pages as $page)
			{
				if (!$this->db->hide_locked || $this->has_access('read', $page['page_id'], $this->get_user_name()))
				{
					// check current page lang for different charset to do_unicode_entities() against
					$_lang = ($this->page['page_lang'] != $page['page_lang'])?  $page['page_lang'] : '';

					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					$tpl->u_pages_li_created = $page['created'];
					$tpl->u_pages_li_link = $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, $_lang);
				}
			}
		}
		else
		{
			$tpl->u_nopages = true;
		}

		// last user comments
		if ($this->user_allowed_comments())
		{
			$tpl->u_cmt_n = $user['total_comments'];

			if ($user['total_comments'])
			{
				$pagination = $this->pagination($user['total_comments'], 10, 'c', $profile + ['#' => 'comments']);
				$tpl->u_cmt_c_pagination_text = $pagination['text'];

				$comments = $this->db->load_all(
					"SELECT c.page_id, c.tag, c.title, c.created, c.comment_on_id, p.title AS page_title, p.tag AS page_tag, c.page_lang ".
					"FROM {$this->db->table_prefix}page c ".
						"LEFT JOIN ".$this->db->table_prefix."page p ON (c.comment_on_id = p.page_id) ".
					"WHERE c.owner_id = '".$user['user_id']."' ".
						"AND c.comment_on_id <> '0' ".
						"AND c.deleted <> '1' ".
						"AND p.deleted <> '1' ".
					"ORDER BY c.created DESC ".
					$pagination['limit']);

				// comments list itself
				foreach ($comments as $comment)
				{
					if (!$this->db->hide_locked || $this->has_access('read', $comment['comment_on_id'], $this->get_user_name()))
					{
						// check current page lang for different charset to do_unicode_entities() against
						$_lang = ($this->page['page_lang'] != $comment['page_lang'])?  $comment['page_lang'] : '';

						// cache page_id for for has_access validation in link function
						$this->page_id_cache[$comment['tag']] = $comment['page_id'];

						$tpl->u_cmt_c_li_created = $comment['created'];
						$tpl->u_cmt_c_li_link = $this->link('/'.$comment['tag'], '', $comment['title'], $comment['page_tag'], 0, 1, $_lang);
					}
				}
			}
			else
			{
				$tpl->u_cmt_none = true;
			}
		}
		else
		{
			$tpl->u_cmtdisabled = true;
		}

		// last user uploads
		// show files only for registered users
		if ($logged_in)
		{
			if ($this->db->upload == 1 || $this->is_admin())
			{
				$tpl->u_up_u_n = $user['total_uploads'];

				if ($user['total_uploads'])
				{
					$pagination = $this->pagination($user['total_uploads'], 10, 'u', $profile + ['#' => 'comments']);

					$tpl->u_up_u_u2_pagination_text = $pagination['text'];

					$uploads = $this->db->load_all(
							"SELECT u.page_id, u.user_id, u.file_name, u.file_description, u.uploaded_dt, u.hits, u.file_size, u.upload_lang, c.tag file_on_page ".
							"FROM {$this->db->table_prefix}upload u ".
								"LEFT JOIN {$this->db->table_prefix}page c ON (u.page_id = c.page_id) ".
							"WHERE u.user_id = '".$user['user_id']."' ".
							"AND u.deleted <> '1' ".
							// "AND p.deleted <> '1' ".
							"ORDER BY u.uploaded_dt DESC ".
							$pagination['limit']);

					// uploads list itself
					foreach ($uploads as $upload)
					{
						if (!$this->db->hide_locked
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

							// TODO need to be redone, moving to tpl
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

							$tpl->u_up_u_u2_li_t = $upload['uploaded_dt'];
							$tpl->u_up_u_u2_li_link = $this->link($path2.$upload['file_name'], '', $upload['file_name'], '', 0, 1, $_lang);
							$tpl->u_up_u_u2_li_onpage = $on_page;
							$tpl->u_up_u_u2_li_descr = $file_description;
						}
					}
				}
				else
				{
					$tpl->u_up_u_none = true;
				}
			}
			else
			{
				$tpl->u_up = true;
				// $this->_t('CommentsDisabled');
			}
		}
	}
}
// USERLIST
// display whole userlist instead of the particular profile
else
{
	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	$sql_where = '';
	$sql_order = '';
	$_user = Ut::strip_spaces((string) @$_GET['user']);
	$params = [];
	if ($_user !== '')
	{
		// goto user profile directly if exact user name specified
		if (!$group_id && $this->load_user($_user))
		{
			$params['profile'] = $_user;
			$this->http->redirect($this->href('', '', $params));
			// NEVER BEEN HERE
		}
		$params['user'] = $_user;
		$sql_where = "AND u.user_name LIKE " . $this->db->q('%' . $_user . '%') . " ";
	}

	if (isset($_GET['profile']))
	{
		// it's for Groups
		$params['profile'] = $_GET['profile'];
	}

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
		$params['sort'] = $_sort;
		$params['order'] = $_order;

		$sql_order = 'ORDER BY u.' . $sort_modes[$_sort] . ' ' . $order_modes[$_order] . ' ';
	}
	else
	{
		$sql_order = 'ORDER BY u.total_pages DESC ';
	}

	$sql_where =
			($group_id? "LEFT JOIN {$this->db->table_prefix}usergroup_member m ON (u.user_id = m.user_id) " : "").
		"WHERE u.account_type = '0' ".
			"AND u.enabled = '1' ".
			($group_id? "AND m.group_id = '$group_id' " : "").
			$sql_where;

	$count = $this->db->load_single(
		"SELECT COUNT(u.user_name) AS n ".
		"FROM {$this->db->user_table} u ".
		$sql_where, true);

	if ($group_id)
	{
		$tpl->l_groups_members = $count['n'];
	}
	else
	{
		// user filter form
		$tpl->l_form_href = $this->href();
		$tpl->l_form_user = $_user;

		// hide params into search form fields
		foreach ($params as $param => $value)
		{
			$tpl->l_form_hid_param = $param;
			$tpl->l_form_hid_value = $value;
		}
	}

	$pagination = $this->pagination($count['n'], $max, 'p', $params);

	// collect data
	$users = $this->db->load_all(
		"SELECT u.user_name, u.account_lang, u.signup_time, u.last_visit, u.total_pages, u.total_revisions, u.total_comments, u.total_uploads, s.hide_lastsession ".
		"FROM {$this->db->user_table} u ".
			"LEFT JOIN ".$this->db->table_prefix."user_setting s ON (u.user_id = s.user_id) ".
		$sql_where.
		$sql_order.
		$pagination['limit'], true);

	$tpl->l_pagination_text = $pagination['text'];

	// change sorting order navigation bar
	$sort_link = function ($sort, $text) use ($params, &$tpl)
	{
		$tpl->l_s_what = $this->_t($text);
		$order = 'asc';
		if (@$params['sort'] == $sort)
		{
			if ($params['order'] == 'asc')
			{
				$order = 'desc';
			}
			$tpl->l_s_arrow_a = $order;
		}
		else
		{
			$params['sort'] = $sort;
		}
		$params['order'] = $order;

		$tpl->l_s_link = $this->href('', '', $params);
	};

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

	// list entries
	if (!$users)
	{
		$tpl->l_none = true;
	}
	else
	{
		foreach ($users as $user)
		{
			$tpl->l_u_user = $user;
			$tpl->l_u_link = $this->user_link($user['user_name'], $user['account_lang'], true, false);
			if ($logged_in)
			{
				$tpl->l_u_reg_user = $user;
				if ($user['hide_lastsession'])
				{
					$tpl->l_u_reg_sess_hidden = true;
				}
				else if ($user['last_visit'] === SQL_DATE_NULL)
				{
					$tpl->l_u_reg_sess_na = true;
				}
				else
				{
					$tpl->l_u_reg_sess_last_visit = $user['last_visit'];
				}
			}
		}
	}
}
