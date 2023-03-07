<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action args:

$group_id	= (int) @$group_id;
$logged_in	= $this->get_user();
$max		= (int) @$max;
$prefix		= $this->prefix;
$tab_mode	= $_GET['mode'] ?? '';

// display user profile
if (!$group_id && ($profile = @$_REQUEST['profile'])) // not GET so personal message can POST here
{
	// hide H1 article header
	$this->hide_article_header = true;

	// does requested user exists?
	if (!($user = $this->load_user($profile)))
	{
		$tpl->not_found = Ut::perc_replace($this->_t('UsersNotFound'),
			$this->href(),
			'<code>' . Ut::html($profile) . '</code>');
	}
	else if (!$user['enabled'])
	{
		$tpl->disabled = true;
	}
	else
	{
		$tpl->enter('u_');

		$profile			= ['profile' => $user['user_name']];
		$default_tab		= false;
		$tpl->username		= $user['user_name'];
		$tpl->href			= $this->href();

		if ($tab_mode == '')
		{
			$default_tab	= true;
		}

		$tpl->enter('tab_');

		// profile navigation
		if ($user['user_id'] == $this->get_user_id())
		{
			// [0] - tab link
			// [1] - tab item text
			// [2] - tab heading
			// [3] - action
			$tabs = [
				''					=>	[$this->href('', '', $profile),
										'UsersProfile',
										'UsersProfile',
										''
				],
				'mypages'			=>	[$this->href('', '', $profile + ['mode' => 'mypages']),
										'UsersPages',
										'ListMyPages',
										'mypages'
				],
				'mychanges'			=>	[$this->href('', '', $profile + ['mode' => 'mychanges']),
										'UsersChanges',
										'ListMyChanges',
										'mychanges'
				],
				'mywatches'			=>	[$this->href('', '', $profile + ['mode' => 'mywatches']),
										'UsersSubscription',
										'ListMyWatches',
										'mywatches'
				],
				'mychangeswatches'	=>	[$this->href('', '', $profile + ['mode' => 'mychangeswatches']),
										'UsersWatches',
										'ListMyChangesWatches',
										'mychangeswatches'
				],
			];

			foreach ($tabs as $k => $tab)
			{
				$tpl->li_commit = true;

				if ($k == $tab_mode)
				{
					$tpl->li_active_item	= $this->_t($tab[1]);
					$tpl->heading			= $this->_t($tab[2]);

					if ($tab[3])
					{
						$tpl->action		= $this->action($tab[3], $profile);
					}
				}
				else
				{
					$tpl->li_href_item	= [$tab[0], $this->_t($tab[1])];
				}
			}
		}
		else
		{
			$tpl->heading = $this->_t('UsersProfile');
		}

		$tpl->leave();	//	tab_
		$tpl->enter('prof_');

		// user profile
		if ($default_tab)
		{
			$tpl->user	= $user;

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
						$groups[] = $this->group_link($group_name, true, false);
					}
				}

				$tpl->userGroups_list = implode(', ', $groups);
			}
			else
			{
				$tpl->userGroups_na = true;
			}

			$allow_intercom = ($this->db->enable_email
				&& $logged_in && $user['email']
				&& (($this->is_admin() || $user['allow_intercom'])
					&& !$user['email_confirm']));

			// prepare and send personal message
			if (@$_POST['_action'] === 'personal_message' && $allow_intercom && $_POST['mail_body'])
			{
				// check for errors
				$error		= '';
				$pm_size	= strlen($_POST['mail_body']); // bytes!

				// message is too long
				if ($pm_size > INTERCOM_MAX_SIZE)
				{
					$error = Ut::perc_replace($this->_t('UsersPMOversized'),
						$this->binary_multiples(($pm_size - INTERCOM_MAX_SIZE)));
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
					$prefix		= utf8_rtrim(str_replace(['https://www.', 'https://', 'http://www.', 'http://'], '', $this->db->base_url), '/');
					$msg_id		= date('ymdHi') . '.' . Ut::rand(100000, 999999) . '@' . $prefix;
					$subject	= $_POST['mail_subject'];
					$body		= $_POST['mail_body'];

					if ($subject === '')
					{
						$subject = '(no subject)';
					}

					// compose headers
					$headers				= [];
					$headers['Message-ID']	= '<' . $msg_id . '>';

					if ($ref = @$_POST['ref'])
					{
						$headers['In-Reply-To']	= '<' . $ref . '>';
						$headers['References']	= '<' . $ref . '>';
					}

					// send notification
					$this->notify_pm($user, $subject, $body, $headers, $msg_id);

					$this->set_message($this->_t('UsersPMSent'), 'success');
					$this->log(4, Ut::perc_replace($this->_t('LogPMSent', SYSTEM_LANG), $this->get_user_name(), $user['user_name']));

					$this->sess->intercom_delay	= time();
					$this->http->redirect($this->href('', '', $profile + ['#' => 'contacts']));
				}
			}

			// header and profile data

			// basic info
			if ($user['hide_lastsession'])
			{
				$tpl->last_hidden	= true;
			}
			else if ($this->db->is_null_date($user['last_visit']))
			{
				$tpl->last_na		= true;
			}
			else
			{
				$tpl->last_last_visit = $user['last_visit'];
			}

			$tpl->userPage_text	= $home = $this->db->users_page . '/' . $user['user_name'];
			$tpl->userPage_href	= $this->href('', $home);
			$tpl->groupsPage	= $this->href('', $this->db->groups_page);

			// hide contact form if profile is equal with current user
			if ($user['user_id'] != $this->get_user_id())
			{
				$tpl->enter('pm_');

				// only registered users can send PMs
				if ($logged_in)
				{
					$tpl->enter('pm_');

					$subject	= (string) ($_POST['mail_subject']	?? '');
					$ref		= (string) ($_POST['ref']			?? '');
					$body		= (string) ($_POST['mail_body']		?? '');

					// decompose reply referrer
					if ($ref0 = @$_GET['ref'])
					{
						$ref0 = @gzinflate(Ut::http64_decode($ref0)); // suppress ALL errors on parsing user supplied data!

						if ($ref0 && strpos($ref0, '@@') !== false)
						{
							// TODO sanitize? someone can inject something into
							[$ref, $subject] = explode('@@', Ut::strip_controls($ref0), 2);

							if (strncmp($subject, 'Re:', 3))
							{
								$subject = 'Re: ' . $subject;
							}
						}
					}

					$tpl->href		= $this->href();
					$tpl->username	= $user['user_name'];

					if ($ref)
					{
						$tpl->ref_ref = $ref;
					}

					// user must allow incoming messages, and needs confirmed email address set
					if ($allow_intercom)
					{
						$tpl->ic_subj = $subject;

						if ($ref)
						{
							$tpl->ic_ref_href = $this->href('', '', $profile + ['#' => 'contacts']);
						}

						$tpl->ic_body = $body;
					}
					else
					{
						$tpl->disabled = true;
					}

					$tpl->leave();	// pm_
				}
				else
				{
					$tpl->not = true;

					if ($ref0 = @$_GET['ref'])
					{
						$tpl->hint = true;
					}
				}

				$tpl->leave();	// pm_
			}

			// user-owned pages
			if ($user['total_pages'])
			{
				$sort_name	= (isset($_GET['sort']) && $_GET['sort'] == 'name');
				$pagination	= $this->pagination($user['total_pages'], 10, 'd',
					$profile + ['sort' => ($sort_name? 'name' : 'date'), '#' => 'pages']);

				$pages = $this->db->load_all(
					"SELECT page_id, owner_id, user_id, tag, title, created, page_lang " .
					"FROM " . $prefix . "page " .
					"WHERE owner_id = " . (int) $user['user_id'] . " " .
						"AND comment_on_id = 0 " .
						"AND deleted <> 1 " .
					"ORDER BY " .
						($sort_name
							? 'tag COLLATE utf8mb4_unicode_520_ci ASC'
							: 'created DESC') . " " .
					$pagination['limit']);

				$page_ids = [];

				foreach ($pages as $page)
				{
					$page_ids[]	= $page['page_id'];

					$this->cache_page($page, true);
					$this->page_id_cache[$page['tag']] = $page['page_id'];
					$this->owner_id_cache[$page['page_id']] = $page['owner_id'];
				}

				// cache acls
				$this->preload_acl($page_ids);

				// sorting and pagination
				if ($sort_name)
				{
					$tpl->pages_date_href = $this->href('', '', $profile + ['sort' => 'date']);
				}
				else
				{
					$tpl->pages_name_href = $this->href('', '', $profile + ['sort' => 'name']);
				}

				$tpl->pages_pagination_text = $pagination['text'];

				// pages list itself
				foreach ($pages as $page)
				{
					if (!$this->db->hide_locked || $this->has_access('read', $page['page_id'], $this->get_user_name()))
					{
						$tpl->pages_li_created	= $page['created'];
						$tpl->pages_li_link		= $this->link('/' . $page['tag'], '', $page['title'], '', false, true);
					}
				}
			}
			else
			{
				$tpl->nopages = true;
			}

			// user-changed pages
			if ($user['total_revisions'])
			{
				$sort_modified	= (isset($_GET['sort']) && $_GET['sort'] == 'modified');
				$pagination	= $this->pagination($user['total_pages'], 10, 'e',
					$profile + ['sort' => ($sort_modified? 'modified' : ''), '#' => 'changes']);

				$pages = $this->db->load_all(
					"SELECT page_id, owner_id, user_id, tag, title, modified, page_lang, edit_note " .
					"FROM " . $prefix . "page " .
					"WHERE user_id = " . (int) $user['user_id'] . " " .
						"AND comment_on_id = 0 " .
						"AND deleted <> 1 " .
					"ORDER BY " .
						($sort_modified
							? 'modified ASC'
							: 'modified DESC') . " " .
					$pagination['limit']);

				$page_ids = [];

				foreach ($pages as $page)
				{
					$page_ids[]	= $page['page_id'];

					$this->cache_page($page, true);
					$this->page_id_cache[$page['tag']] = $page['page_id'];
					$this->owner_id_cache[$page['page_id']] = $page['owner_id'];
				}

				// cache acls
				$this->preload_acl($page_ids);

				$tpl->enter('changes_');

				// sorting and pagination
				if ($sort_modified)
				{
					$tpl->desc_href = $this->href('', '', $profile);
				}
				else
				{
					$tpl->asc_href = $this->href('', '', $profile + ['sort' => 'modified']);
				}

				$tpl->pagination_text = $pagination['text'];

				// pages list itself
				foreach ($pages as $page)
				{
					if (!$this->db->hide_locked || $this->has_access('read', $page['page_id'], $this->get_user_name()))
					{
						$tpl->li_modified	= $page['modified'];
						$tpl->li_link		= $this->link('/' . $page['tag'], '', $page['title'], '', false, true);

						if ($page['edit_note'])
						{
							$tpl->li_edit_note	= $page['edit_note'];
						}
					}
				}

				$tpl->leave();	// changes_
			}
			else
			{
				$tpl->nochanges = true;
			}

			// last user comments
			if ($this->user_allowed_comments())
			{
				$tpl->enter('comments_');

				$tpl->n = $user['total_comments'];

				if ($user['total_comments'])
				{
					$pagination = $this->pagination($user['total_comments'], 10, 'c', $profile + ['#' => 'comments']);
					$tpl->c_pagination_text = $pagination['text'];

					$comments = $this->db->load_all(
						"SELECT c.page_id, c.owner_id, c.user_id, c.tag, c.title, c.created, c.comment_on_id, c.page_lang, p.title AS page_title, p.tag AS page_tag, p.owner_id AS page_owner_id " .
						"FROM " . $prefix . "page c " .
							"LEFT JOIN " . $prefix . "page p ON (c.comment_on_id = p.page_id) " .
						"WHERE c.owner_id = " . (int) $user['user_id'] . " " .
							"AND c.comment_on_id <> 0 " .
							"AND c.deleted <> 1 " .
							"AND p.deleted <> 1 " .
						"ORDER BY c.created DESC " .
						$pagination['limit']);

					$page_ids = [];

					foreach ($comments as $comment)
					{
						$page_ids[]	= $comment['comment_on_id'];	// page
						$page_ids[]	= $comment['page_id'];			// comment

						$this->cache_page($comment, true);
						$this->page_id_cache[$comment['tag']] = $comment['page_id'];
						$this->owner_id_cache[$comment['comment_on_id']] = $comment['page_owner_id'];
					}

					// cache acls
					$this->preload_acl($page_ids);

					// comments list itself
					foreach ($comments as $comment)
					{
						if (!$this->db->hide_locked || $this->has_access('read', $comment['comment_on_id'], $this->get_user_name()))
						{
							$tpl->c_li_created	= $comment['created'];
							$tpl->c_li_link		= $this->link('/' . $comment['tag'], '', $comment['title'], $comment['page_tag'], false, true);
						}
					}
				}
				else
				{
					$tpl->none = true;
				}

				$tpl->leave();	// comments_
			}
			else
			{
				$tpl->cmtdisabled = true;
			}

			// last user uploads
			// show files only for registered users
			if ($logged_in)
			{
				if ($this->db->attachments_handler == 2 || $this->db->upload == 1 || $this->is_admin())
				{
					$tpl->enter('files_');

					$tpl->u_n = $user['total_uploads'];

					if ($user['total_uploads'])
					{
						$pagination = $this->pagination($user['total_uploads'], 10, 'u', $profile + ['#' => 'uploads']);

						$tpl->u_u2_pagination_text = $pagination['text'];

						$files = $this->db->load_all(
							"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_description, f.uploaded_dt, f.file_size, f.file_lang, p.owner_id, p.tag file_on_page, p.title file_on_title " .
							"FROM " . $prefix . "file f " .
								"LEFT JOIN " . $prefix . "page p ON (f.page_id = p.page_id) " .
							"WHERE f.user_id = " . (int) $user['user_id'] . " " .
								"AND f.deleted <> 1 " .
							// "AND p.deleted <> 1 " .
							"ORDER BY f.uploaded_dt DESC " .
							$pagination['limit']);

						$page_ids = [];

						foreach ($files as $file)
						{
							if ($file['page_id'] && ! in_array($file['page_id'], $page_ids))
							{
								$page_ids[]	= $file['page_id'];

								#$this->cache_page($file, true);
								$this->page_id_cache[$file['file_on_page']] = $file['page_id'];
								$this->owner_id_cache[$file['page_id']] = $file['owner_id'];
							}
						}

						// cache acls
						$this->preload_acl($page_ids);

						// uploads list itself
						foreach ($files as $file)
						{
							if (!$this->db->hide_locked
								|| !$file['page_id']
								|| $this->has_access('read', $file['page_id']))
							{
								if (($file_description = $file['file_description']) !== '')
								{
									$file_description = ' <span class="editnote">[' . $file_description . ']</span>';
								}

								preg_match('/^[^\/]+/u', ($file['file_on_page'] ?? ''), $sub_tag);

								// TODO needs to be redone, moving to tpl
								if ($file['page_id']) // !$global
								{
									$path2		= '_file:/' . $file['file_on_page'] . '/';
									$on_tag		= $file['file_on_page'];
									$on_page	= $this->_t('To') . ' ' .
												  $this->link('/' . $file['file_on_page'], '', $file['file_on_title'], '', false, true) .
												  ' ' . NBSP . NBSP . '<span title="' . $this->_t('Cluster') . '">→ ' . $sub_tag[0];
								}
								else
								{
									$path2		= '_file:/';
									$on_tag		= '';
									$on_page	= '<span title="">→ ' . $this->_t('UploadGlobal');
								}

								$tpl->u_u2_li_created	= $file['uploaded_dt'];
								# $tpl->u_u2_li_link	= $this->link($path2 . $upload['file_name'], '', Ut::shorten_string($upload['file_name']), '', 0, 1);
								$tpl->u_u2_li_link		= '<a href="' . $this->href('filemeta', $on_tag, ['m' => 'show', 'file_id' => (int) $file['file_id']]) . '">' . Ut::shorten_string($file['file_name']) . '</a>';
								$tpl->u_u2_li_onpage	= $on_page;
								$tpl->u_u2_li_descr		= $file_description;
							}
						}
					}
					else
					{
						$tpl->u_none = true;
					}

					$tpl->leave();	// files_
				}
				else
				{
					$tpl->files = true;
				}
			}
		}

		$tpl->leave();	//	prof_
		$tpl->leave();	//	u_
	}
}
// USERLIST
// display whole userlist instead of the particular profile
else
{
	// defining WHERE and ORDER clauses
	// $param is passed to the pagination links
	$sql_where	= '';
	$sql_order	= '';
	$_user		= Ut::strip_spaces((string) @$_GET['user']);
	$params		= [];

	if ($_user !== '')
	{
		// goto user profile directly if exact user name specified
		if (!$group_id && $this->load_user($_user))
		{
			$params['profile'] = $_user;
			$this->http->redirect($this->href('', '', $params));
			// NEVER BEEN HERE
		}

		$params['user']	= $_user;
		$sql_where		= "AND u.user_name LIKE " . $this->db->q('%' . $_user . '%') . " ";
	}

	if (isset($_GET['profile']))
	{
		// it's for Groups
		$params['profile'] = $_GET['profile'];
	}

	$_sort		= $_GET['sort'] ?? null;
	$sort_modes	=
	[
		'name'			=> 'user_name',
		'pages'			=> 'total_pages',
		'comments'		=> 'total_comments',
		'uploads'		=> 'total_uploads',
		'revisions'		=> 'total_revisions',
		'signup'		=> 'signup_time',
		'last_visit'	=> 'last_visit'
	];

	if (isset($sort_modes[$_sort]))
	{
		$_order			= $_GET['order'] ?? null;
		$order_modes	=
		[
			'asc'	=> 'ASC',
			'desc'	=> 'DESC'
		];

		if (!isset($order_modes[$_order]))
		{
			$_order = 'asc';
		}

		$params['sort']		= $_sort;
		$params['order']	= $_order;

		$sql_order = 'ORDER BY u.' . $sort_modes[$_sort] . ' ' . $order_modes[$_order] . ' ';
	}
	else
	{
		$sql_order = 'ORDER BY u.total_pages DESC ';
	}

	$sql_where =
		($group_id
			? "LEFT JOIN " . $prefix . "usergroup_member m ON (u.user_id = m.user_id) "
			: "") .
		"WHERE u.account_type = 0 " .
			"AND u.enabled = 1 " .
			($group_id
				? "AND m.group_id = " . (int) $group_id . " "
				: "") .
			$sql_where;

	$count = $this->db->load_single(
		"SELECT COUNT(u.user_name) AS n " .
		"FROM " . $prefix . "user u " .
		$sql_where, true);

	$tpl->enter('l_');

	if ($group_id)
	{
		$tpl->groups_members = $count['n'];
	}
	else
	{
		// user filter form
		$tpl->form_href = $this->href();
		$tpl->form_user = $_user;

		// hide params into search form fields
		foreach ($params as $param => $value)
		{
			$tpl->form_hid_param = $param;
			$tpl->form_hid_value = $value;
		}
	}

	$pagination = $this->pagination($count['n'], $max, 'p', $params);

	// collect data
	$users = $this->db->load_all(
		"SELECT u.user_name, u.signup_time, u.last_visit, u.total_pages, u.total_revisions, u.total_comments, u.total_uploads, s.hide_lastsession " .
		"FROM " . $prefix . "user u " .
			"LEFT JOIN " . $prefix . "user_setting s ON (u.user_id = s.user_id) " .
		$sql_where .
		$sql_order .
		$pagination['limit'], true);

	$tpl->pagination_text = $pagination['text'];

	// change sorting order navigation bar
	$sort_link = function ($sort, $text) use ($params, &$tpl)
	{
		$tpl->s_what	= $this->_t($text);
		$order			= 'asc';

		if (@$params['sort'] == $sort)
		{
			if ($params['order'] == 'asc')
			{
				$order = 'desc';
			}

			$tpl->s_arrow_a = $order;
		}
		else
		{
			$params['sort'] = $sort;
		}

		$params['order'] = $order;

		$tpl->s_link = $this->href('', '', $params);
	};

	$sort_link('name',		'UsersName');
	$sort_link('pages',		'UsersPages');
	$sort_link('comments',	'UsersComments');
	$sort_link('revisions',	'UsersRevisions');

	if ($logged_in)
	{
		$sort_link('uploads',		'UsersUploads');
		$sort_link('signup',		'UsersSignup');
		$sort_link('last_visit',	'UsersLastSession');
	}

	// list entries
	if (!$users)
	{
		$tpl->none = true;
	}
	else
	{
		$tpl->enter('u_');

		foreach ($users as $user)
		{
			$tpl->user = $user;
			$tpl->link = $this->user_link($user['user_name'], true, false);

			if ($logged_in)
			{
				$tpl->reg_user = $user;

				if ($user['hide_lastsession'])
				{
					$tpl->reg_sess_hidden = true;
				}
				else if ($this->db->is_null_date($user['last_visit']))
				{
					$tpl->reg_sess_na = true;
				}
				else
				{
					$tpl->reg_sess_last_visit = $user['last_visit'];
				}
			}
		}

		$tpl->leave();	//	u_
	}

	$tpl->leave();	//	l_
}
