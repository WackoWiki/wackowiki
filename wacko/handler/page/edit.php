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

// invoke autocomplete if needed
if ((isset($_GET['_autocomplete'])) && $_GET['_autocomplete'])
{
	include dirname(__FILE__) . '/_autocomplete.php';
	return;
}

if ($this->has_access('read')
	&& (($this->page && $this->has_access('write'))
	#		|| $this->is_admin() // XXX: Only for testing - comment out afterwards!
	|| ($this->page['comment_on_id'] && $this->is_owner())
	|| ($this->page['comment_on_id'] && $this->is_admin())
	|| (!$this->page && $this->has_access('create'))))
{
	// check for reserved word
	if (($result = $this->validate_reserved_words($this->tag)))
	{
		// $this->tag is reserved word
		$message = Ut::perc_replace($this->_t('PageReservedWord'), $result);
		$this->set_message($message);
		$this->http->redirect($this->href('new', $this->db->root_page));
	}

	$user	= $this->get_user();

	// comment header?
	if ($this->page['comment_on_id'])
	{
		$comment_on = $this->load_page('', $this->page['comment_on_id'], '', '', LOAD_META);
		$message = $this->_t('ThisIsCommentOn') . ' ' .
			$this->compose_link_to_page($comment_on['tag'], '', $comment_on['title'], $comment_on['tag']) . ', ' .
			$this->_t('PostedBy') . ' ' .
			$this->user_link($this->page['user_name'], '', true, false) . ' ' .
			$this->_t('At') . ' ' . $this->get_time_formatted($this->page['modified']);
		$tpl->message = $this->show_message($message, 'comment-info', false);
	}

	// revision header
	if ($this->page['latest'] == 0 && !!$this->page)
	{
		// add also hint:
		// [en] You are editing an old revision of this page. If you publish it, any changes made since then will be removed. You may wish to edit the current revision instead.
		// [de] Du bearbeitest nicht die aktuelle, sondern eine ältere Version dieser Seite. Wenn du speicherst, wird diese als aktuelle Version neu gespeichert. Eventuell später hinzugekommene Änderungen werden damit gelöscht.
		$message = Ut::perc_replace($this->_t('Revision'),
			$this->href(),
			$this->tag,
			$this->get_time_formatted($this->page['modified']),
			$this->user_link($this->page['user_name'], '', true, false));
		$tpl->message = $this->show_message($message, 'revision-info', false);
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
			#$this->set_message('watch page' , 'info');
			$this->set_watch($user['user_id'], $this->page['page_id']);
			$this->is_watched = true;
		}

		// only if saving:
		if (isset($_POST['save']) && (isset($_POST['body']) && $_POST['body'] != ''))
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

				// is page ..
				if ($this->page['comment_on_id'] == 0)
				{
					// save categories
					if ($this->page == false)
					{
						// new page created
						$this->save_categories_list($this->get_page_id($this->tag), OBJECT_PAGE);
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

					// this is a new page, get page_id via tag for the new created page
					if (!$this->page)
					{
						$this->page['page_id'] = $this->get_page_id($this->tag);
					}

					// now we render it internally so we can write the updated link tables.
					$this->update_link_table($this->page['page_id'], $body_r);
				}

				// forward
				$this->page_cache['supertag'][$this->supertag]			= '';
				$this->page_cache['page_id'][$this->page['page_id']]	= '';

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
	$previous	= $_POST['previous']	?? $this->page['modified'];
	$body		= $_POST['body']		?? $this->page['body'];
	$body		= html_entity_decode($body, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
	$title		= $_POST['title']
					?? $this->page['title']
						?? (isset($this->sess->title)
							? (empty($this->sess->title)
								? $this->get_page_title($this->tag)
								: $this->sess->title)
							: $this->get_page_title($this->tag)
						);
	$title		= html_entity_decode($title, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

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
		$tpl->new_tag	= $this->tag;
		$tpl->new_lang	= $this->page_lang;
	}

	$preview		=	'';

	// preview?
	if (isset($_POST['preview']))
	{
		$text_chars	= number_format(strlen($_body), 0, ',', '.');
		$preview	= $this->format($body,		'pre_wacko');
		$preview	= $this->format($preview,	'wacko');
		$preview	= $this->format($preview,	'post_wacko');

		$tpl->p_chars		= $text_chars;
		$tpl->p_title		= $title;
		$tpl->p_preview		= $preview;
		$tpl->p_buttons		= true;
	}

	if (isset($this->sess->body) && $this->sess->body != '')
	{
		$body				= $this->sess->body;
		$this->sess->body	= '';
	}

	if (isset($this->sess->title) && $this->sess->title != '')
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

	$tpl->buttons= true;

	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] != 0)
	{
		// comment title
		$tpl->e_title = Ut::html($title);
		$tpl->e_label = $this->_t('AddCommentTitle');
	}
	else if (!$this->page || $this->is_owner() || $this->is_admin())
	{
		// edit page title
		$tpl->e_title = Ut::html($title);
		$tpl->e_label = $this->_t('MetaTitle');
	}
	else
	{
		// show page title
		$tpl->r_title = $this->page['title'];
	}

	$tpl->previous	= Ut::html($previous);

	// FIXME: \n gets stripped by assign() function in TemplatestSetter class, see line 117
	// -> workaround: [ ' body | pre ' ]
	$tpl->body		= Ut::html($body);  // -> [ ' body | pre ' ]

	// XXX: only for \n issue testing
	# echo '<textarea id="postText" name="body" rows="40" cols="60" class="TextArea">'. Ut::html($body) . "</textarea>\n";

	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] == false)
	{
		// edit note
		if ($this->db->edit_summary != 0)
		{
			// briefly describe your changes (corrected spelling, fixed grammar, improved formatting)
			$tpl->n_note = Ut::html($edit_note);
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
		$tpl->c_categories = $this->show_category_form('', OBJECT_PAGE, $this->page_lang, false);
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
	}

	$tpl->wikiedit = $this->db->base_url . Ut::join_path(IMAGE_DIR, 'wikiedit') . '/';

	$tpl->leave();
}
else
{
	$tpl->message = $this->show_message($this->_t('WriteAccessDenied'), 'error', false);
}
