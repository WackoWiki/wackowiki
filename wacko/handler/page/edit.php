<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$edit_note		= '';
$error			= '';
$minor_edit		= 0;
$reviewed		= 0;
$title			= '';

if ($this->has_access('read')
	&& (($this->page && $this->has_access('write'))
	#		|| $this->is_admin() // XXX: Only for testing - comment out afterwards!
	|| (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] && $this->is_owner())
	|| (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] && $this->is_admin())
	|| (!$this->page && $this->has_access('create'))))
{
	// check for reserved word
	if (($result = $this->validate_reserved_words($this->tag)))
	{
		// $this->tag is reserved word
		$message = Ut::perc_replace($this->_t('PageReservedWord'), '<code>' . $result . '</code>');
		$this->set_message($message);
		$this->http->redirect($this->href('new', $this->db->root_page));
	}

	// invoke autocomplete if needed
	if ((isset($_GET['_autocomplete'])) && $_GET['_autocomplete'])
	{
		include dirname(__FILE__) . '/_autocomplete.php';
		return;
	}

	$user	= $this->get_user();

	// is comment?
	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'])
	{
		$comment_on = $this->load_page('', $this->page['comment_on_id'], '', '', LOAD_ALL); // TODO: LOAD_META only plus 'allow_rawhtml' and 'disable_safehtml'

		// formatter needs these values from parent page
		$this->db->allow_rawhtml	= $comment_on['allow_rawhtml'];
		$this->db->disable_safehtml	= $comment_on['disable_safehtml'];

		// comment header
		$message = $this->msg_is_comment_on(
			$comment_on['tag'],
			$comment_on['title'],
			$this->page['user_name'],
			$this->page['modified']);
		$tpl->message = $this->show_message($message, 'comment-info', false);
	}

	// revision header
	if (isset($this->page['latest']) && $this->page['latest'] == 0 && !!$this->page)
	{
		$message = Ut::perc_replace($this->_t('RevisionHint'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], true, false));
		$tpl->message = $this->show_message($message, 'revision-info', false);
		$tpl->warning = $this->show_message($this->_t('EditingRevisionWarning'), 'warning', false);
	}

	// has similar pages
	if (!$this->page && $results = $this->similar_page_exists($this->tag))
	{
		$log	= $tpl->similarTags();

		foreach ($results as $result)
		{
			if ($result['tag'] != $this->tag)
			{
				$log->l_page	= $this->link('/' . $result['tag']);
			}
		}

		$message = Ut::perc_replace($this->_t('SimilarPagesExists'), '<code>' . $this->tag . '</code>') . '<br>' . $log;
		$tpl->message = $this->show_message($message, 'notice', false);
	}

	if (isset($_POST))
	{
		$_body	= $_POST['body'] ?? '';

		// watch page
		if ($this->page
			&& isset($_POST['watchpage'])
			&& !isset($_POST['noid_publication'])
			&& $user
			&& !$this->is_watched)
		{
			#$this->set_message('watch page');
			$this->set_watch($user['user_id'], $this->page['page_id']);
			$this->is_watched = true;
		}

		// only if saving:
		if (isset($_POST['save']) && !empty($_POST['body']))
		{
			$edit_note	= trim(	($_POST['edit_note']	?? ''));
			$minor_edit	= (int)	($_POST['minor_edit']	?? 0);
			$reviewed	= (int)	($_POST['reviewed']		?? 0);
			$title		= trim(	($_POST['title']		?? $this->page['title']));

			// check for reserved word
			if ($result = $this->validate_reserved_words($this->tag))
			{
				$message = $result;
				$this->set_message($message , 'error');
				$error = true;
			}

			// TODO: if captcha .. else

			// check for overwriting
			if ($this->page && $this->page['modified'] != $_POST['previous'])
			{
				$message = $this->_t('OverwriteAlert');
				$this->set_message($message , 'error');
				$error = true;
			}

			// check text length
			/* if ($textchars > $maxchars)
			{
				$message = Ut::perc_replace($this->_t('TextDBOversize'), $textchars - $maxchars) . ' ';
				$this->set_message($message , 'error');
				$error = true;
			} */

			// check for edit note
			if (($this->db->edit_summary == 2) && $_POST['edit_note'] == '' && $this->page['comment_on_id'] == 0)
			{
				$message = $this->_t('EditNoteMissing');
				$this->set_message($message , 'error');
				$error = true;
			}

			// check categories
			/* if (!$this->page && $this->get_categories_list($this->page_lang, true) && $this->save_categories_list($this->page['page_id'], OBJECT_PAGE, 1) !== true)
			{
				$message = 'Select at least one referring category (field) to the page. ';
				$this->set_message($message , 'error');
				$error = true;
			} */

			// captcha validation
			if (($this->page? $this->db->captcha_edit_page : $this->db->captcha_new_page)
				&& !$this->validate_captcha())
			{
				$this->set_message($this->_t('CaptchaFailed'), 'error');
				$error = true;
			}

			$body = str_replace("\r", '', $_POST['body']);

			// You're not allowed to have empty comments as they would be kinda pointless.
			if (!$body && $this->page['comment_on_id'] != 0)
			{
				$message = $this->_t('EmptyComment');
				$this->set_message($message , 'error');
				$error = true;
			}

			if ($bad_words = $this->bad_words($body))
			{
				$message = $bad_words;
				$this->set_message($message , 'error');
				$error = true;
			}

			// store
			if (!$error)
			{
				// publish anonymously
				if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->page['page_id'])
				{
					// undefine username
					$remember_name = $this->get_user_name();
					$this->set_user_setting('user_name', null);
				}

				// add page (revisions)
				$body_r = $this->save_page($this->tag, $title, $body, $edit_note, $minor_edit, $reviewed, $this->page['comment_on_id']);

				// new page created
				if (!$this->page)
				{
					// this is a new page, get page_id via tag for the new created page
					$this->page['page_id'] = $this->get_page_id($this->tag);

					// save categories
					$this->save_categories_list($this->page['page_id'], OBJECT_PAGE);
				}

				// restore username after anonymous publication
				if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->page['page_id'])
				{
					$this->set_user_setting('user_name', $remember_name);
					unset($remember_name);

					if ($body_r)
					{
						$this->set_user_setting('noid_protect', true);
					}
				}

				// now we render it internally to the update the link tables.
				$this->update_link_table($this->page['page_id'], $body_r);

				$this->page_cache[$this->page['page_id']]	= '';

				// show success message (too much visual clutter)
				/* $message	= $this->page['comment_on_id']
					? $this->_t('CommentSaved')
					: Ut::perc_replace($this->_t('PageSaved'), ($this->page['version_id'] + 1));
				$this->set_message($message, 'success'); */

				// forward to show handler
				$this->http->redirect($this->href());
			}
		}
		// saving blank document
		else if (isset($_POST['body']) && $_POST['body'] == '')
		{
			$message = $this->_t('EmptyPage');
			$this->set_message($message, 'error');
			$this->http->redirect($this->href());
		}
	}

	// fetch fields
	$previous	= $_POST['previous']	?? ($this->page['modified']	?? null);
	$body		= $_POST['body']		?? ($this->page['body']		?? null);
	$title		= $_POST['title']
					?? $this->page['title']
						?? (isset($this->sess->title)
							? (empty($this->sess->title)
								? $this->get_page_title($this->tag)
								: $this->sess->title)
							: $this->get_page_title($this->tag)
						);

	$edit_note	= (string)	($_POST['edit_note']	?? '');
	$minor_edit	= (int)		($_POST['minor_edit']	?? 0);

	// display form
	$tpl->enter('f_');

	// "cf" attribute: it is for so called "critical fields" in the form.
	// It is used by some javascript code, which is launched onbeforeunload and shows a pop-up dialog
	// "You are going to leave this page, but there are some changes you made but not saved yet."
	// Is used by this script to determine which changes it needs to monitor.
	// e.g. $this->form_open('edit_page', ['page_method' => 'edit', 'form_more' => ' cf="true" ']);

	if ((isset($_GET['add']) && $_GET['add'] == 1) || (isset($_POST['add']) && $_POST['add'] == 1))
	{
		$tpl->new_tag		= $this->tag;
		$tpl->new_lang		= $this->page_lang;
	}

	if ($this->db->multilanguage)
	{
		$languages			= $this->_t('LanguageArray');

		$tpl->l_language	= $languages[$this->page_lang];
		$tpl->l_lang		= $this->page_lang;
		$tpl->l_charset		= $this->get_charset();
	}

	$tpl->l_accessmode		= $this->show_access_mode();

	$preview		=	'';

	// preview?
	if (isset($_POST['preview']))
	{
		$text_chars			= number_format(mb_strlen($_body), 0, ',', '.');
		$preview			= $this->format($body,		'pre_wacko');
		$preview			= $this->format($preview,	'wacko');
		$preview			= $this->format($preview,	'post_wacko', ['stripnotypo' => true]);

		$tpl->p_chars		= $text_chars;
		$tpl->p_title		= $title;
		$tpl->p_preview		= $preview;
		$tpl->p_buttons		= true;
	}

	if (!empty($this->sess->body))
	{
		$body				= $this->sess->body;
		$this->sess->body	= '';
	}

	if (!empty($this->sess->title))
	{
		$title				= $this->sess->title;
		$this->sess->title	= '';
	}
	else if (isset($_POST['title']) && $_POST['title'] == true)
	{
		$title				= $_POST['title'];
	}
	else if (isset($this->page['title']))
	{
		$title				= $this->page['title'];
	}

	$tpl->buttons = true;

	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] != 0)
	{
		// comment title
		$tpl->e_title = $title;
		$tpl->e_label = $this->_t('AddCommentTitle');
	}
	else if (!$this->page || $this->is_owner() || $this->is_admin())
	{
		// edit page title
		$tpl->e_title = $title;
		$tpl->e_label = $this->_t('MetaTitle');
	}
	else
	{
		// show page title
		$tpl->r_title = $this->page['title'];
	}

	$tpl->previous	= $previous; // -> [ ' previous | e attr ' ]

	// FIXME: \n gets stripped by assign() function in TemplatestSetter class, see line 117
	// -> workaround: [ ' body | pre ' ]
	$tpl->body		= Ut::html($body);  // -> [ ' body | pre ' ]

	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] == false)
	{
		// edit note
		if ($this->db->edit_summary != 0)
		{
			// briefly describe your changes (corrected spelling, fixed grammar, improved formatting)
			$tpl->n_note = $edit_note;
		}

		if ($user)
		{
			// minor edit
			if ($this->page && $this->db->minor_edit != 0)
			{
				$tpl->minor = true;
			}

			// reviewed
			if ($this->page && $this->db->review != 0 && $this->is_reviewer())
			{
				$tpl->reviewed = true;
			}

			// publish anonymously
			if (($this->page
					&& $this->db->publish_anonymously != 0
					&& $this->has_access('write', '', GUEST))
				|| (!$this->page && $this->has_access('create', '', GUEST)))
			{
				$tpl->a_pageid	= $this->page['page_id'];
				$tpl->a_checked	= $this->get_user_setting('noid_pubs') == 1 ? ' checked' : '';
			}

			// watch a page
			if ($this->page && !$this->is_watched)
			{
				$tpl->w_checked = $this->get_user_setting('send_watchmail') == 1 ? ' checked' : '';
			}
		}
	}

	if (!$this->page && $words = $this->get_categories_list($this->page_lang, true))
	{
		$tpl->c_categories = $this->show_category_form($this->page_lang, '', OBJECT_PAGE, false);
	}

	if ($this->page? $this->db->captcha_edit_page : $this->db->captcha_new_page)
	{
		$tpl->captcha = $this->show_captcha(false);
	}

	// WikiEdit
	if ($user = $this->get_user())
	{
		if ($user['autocomplete'])
		{
			$tpl->autocomplete = true;
		}

		// session heartbeat timeout = wiki session timeout - 40 second to let the request heartbeat and response go without fuss
		$tpl->user_heartbeat = $this->sess->cf_gc_maxlifetime - 40;
	}

	$tpl->wikiedit = $this->db->base_path . Ut::join_path(IMAGE_DIR, 'wikiedit') . '/';

	$tpl->leave();
}
else
{
	$this->http->status(403);

	$tpl->message = $this->show_message($this->_t('WriteAccessDenied'), 'error', false);
}
