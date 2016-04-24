<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$edit_note		= '';
$error			= '';
$minor_edit		= 0;
$output			= '';
$reviewed		= 0;
$title			= '';

// invoke autocomplete if needed
if ((isset($_GET['_autocomplete'])) && $_GET['_autocomplete'])
{
	include( dirname(__FILE__).'/_autocomplete.php' );
	return;
}

?>
<div id="pageedit">
<?php

if ($this->has_access('read')
	&& (($this->page && $this->has_access('write'))
	|| ($this->page['comment_on_id'] && $this->is_owner())
	|| ($this->page['comment_on_id'] && $this->is_admin())
	|| (!$this->page && $this->has_access('create'))))
{
	// check for reserved word
	if ($result = $this->validate_reserved_words($this->tag))
	{
		$message = str_replace('%1', $result, $this->get_translation('PageReservedWord'));
		$this->set_message($message);
		$this->redirect($this->href('new', $this->config['root_page'])); // $this->tag is reserved word
	}

	$user	= $this->get_user();

	// comment header?
	if ($this->page['comment_on_id'])
	{
		$message = $this->get_translation('ThisIsCommentOn').' '.$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', $this->get_page_title('', $this->page['comment_on_id']), 0, $this->get_page_tag($this->page['comment_on_id'])).', '.$this->get_translation('PostedBy').' '.$this->user_link($this->page['user_name'], $lang = '', true, false).' '.$this->get_translation('At').' '.$this->get_time_formatted($this->page['modified']);
		$this->show_message($message, 'commentinfo');
	}

	// TODO: add values to post in show handler
	/* if ($this->page['latest'] == 0)
	{
		$message =
		str_replace('%1', $this->href(),
				str_replace('%2', $this->tag,
						str_replace('%3', $this->get_time_formatted($this->page['modified']),
								str_replace('%4', $this->user_link($this->page['user_name'], $lang = '', true, false),
										$this->get_translation('Revision')))));
		$this->show_message($message, 'revisioninfo');
	} */

	if (isset($_POST))
	{
		$_body		= isset($_POST['body']) ? $_POST['body'] : '';

		// watch page
		if ($this->page && isset($_POST['watchpage']) && $_POST['noid_publication'] != $this->page['page_id'] && $user && $this->is_watched !== true)
		{
			$this->set_watch($user['user_id'], $this->page['page_id']);
			$this->is_watched = true;
		}

		// only if saving:
		if (isset($_POST['save']) && (isset($_POST['body']) && $_POST['body'] != ''))
		{
			if(isset($_POST['edit_note']))
			{
				$edit_note = trim($_POST['edit_note']);
			}

			if(isset($_POST['minor_edit']))
			{
				$minor_edit = (int)$_POST['minor_edit'];
			}

			if(isset($_POST['reviewed']))
			{
				$reviewed = (int)$_POST['reviewed'];
			}

			$title = $this->page['title'];

			if(isset($_POST['title']))
			{
				$title = trim($_POST['title']);
			}

			// check for reserved word
			if ($result = $this->validate_reserved_words($this->tag))
			{
				$message = $result;
				$this->set_message($message , 'error');
				$error = true;
			}

			// TODO: if captcha .. else
			// check form token
			if (!$this->validate_form_token('edit_page'))
			{
				$message = $this->get_translation('FormInvalid');
				$this->set_message($message , 'error');
				$error = true;
			}

			// check for overwriting
			if ($this->page && $this->page['modified'] != $_POST['previous'])
			{
				$message = $this->get_translation('OverwriteAlert');
				$this->set_message($message , 'error');
				$error = true;
			}

			// check text length
			#if ($textchars > $maxchars)
			#{
				#$message = str_replace('%1', $textchars - $maxchars, $this->get_translation('TextDBOversize')).' ';
				#$this->set_message($message , 'error');
			#	$error = true;
			#}

			// check for edit note
			if (($this->config['edit_summary'] == 2) && $_POST['edit_note'] == '' && $this->page['comment_on_id'] == 0)
			{
				$message = $this->get_translation('EditNoteMissing');
				$this->set_message($message , 'error');
				$error = true;
			}

			// check categories
			#if (!$this->page && $this->get_categories_list($this->page_lang, 1) && $this->save_categories_list($this->page['page_id'], 1) !== true)
			#{
				#$message = 'Select at least one referring category (field) to the page. ';
				#$this->set_message($message , 'error');
			#	$error = true;
			#}

			// captcha code starts
			if (($this->page && $this->config['captcha_edit_page']) || (!$this->page && $this->config['captcha_new_page']))
			{
				// captcha validation
				if ($this->validate_captcha() === false)
				{
					$message = $this->get_translation('CaptchaFailed');
					$this->set_message($message , 'error');
					$error = true;
				}
			}

			$body = str_replace("\r", '', $_POST['body']);

			// You're not allowed to have empty comments as they would be kinda pointless.
			if (!$body && $this->page['comment_on_id'] != 0)
			{
				$message = $this->get_translation('EmptyComment');
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
						$this->save_categories_list($this->get_page_id($this->tag));
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

					// now we render it internally so we can write the updated link table.
					$this->update_link_table($this->page['page_id'], $body_r);
				}

				// forward
				$this->page_cache['supertag'][$this->supertag]			= '';
				$this->page_cache['page_id'][$this->page['page_id']]	= '';

				$this->redirect($this->href());
			}
		}
		// saving blank document
		else if (isset($_POST['body']) && $_POST['body'] == '')
		{
			$message = $this->get_translation('EmptyPage');
			$this->set_message($message, 'error');
			$this->redirect($this->href());
		}
	}

	$this->no_cache();

	// fetch fields
	$previous	= isset($_POST['previous'])	? $_POST['previous']	: $this->page['modified'];
	$body		= isset($_POST['body'])		? $_POST['body']		: $this->page['body'];
	$body		= html_entity_decode($body, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
	$title		= isset($_POST['title'])
					? $_POST['title']
					: isset($this->page['title'])
						? $this->page['title']
						: isset($_SESSION['title'])
							? $_SESSION['title']
							: '';
	$title		= html_entity_decode($title, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);

	if (isset($_POST['edit_note']))		$edit_note	= $_POST['edit_note'];
	if (isset($_POST['minor_edit']))	$minor_edit	= $_POST['minor_edit'];

	// display form

	// "cf" attribute: it is for so called "critical fields" in the form. It is used by some javascript code, which is launched onbeforeunload and shows a pop-up dialog "You are going to leave this page, but there are some changes you made but not saved yet." Is used by this script to determine which changes it need to monitor.
	$output .= $this->form_open('edit_page', 'edit', 'post', true, '', ' cf="true" ');

	if ((isset($_GET['add']) && $_GET['add'] == 1) || (isset($_POST['add']) && $_POST['add'] == 1))
	{
		$output .=	'<input type="hidden" name="page_lang"	value="'.$this->page_lang.'" />'."\n".
					'<input type="hidden" name="tag"		value="'.$this->tag.'" />'."\n".
					'<input type="hidden" name="add"		value="1" />'."\n";
	}

	echo $output;

	$output			= '';
	$preview		= '';
	$form_buttons	=	'<input type="submit" class="OkBtn_Top" name="save" value="'.$this->get_translation('EditStoreButton').'" />&nbsp;'.
						'<input type="submit" class="OkBtn_Top" name="preview" value="'.$this->get_translation('EditPreviewButton').'" />&nbsp;'.
						'<a href="'.$this->href().'" style="text-decoration: none;"><input type="button" class="CancelBtn_Top" value="'.$this->get_translation('EditCancelButton').'" /></a>'."\n"; // $this->href('', '', '', 1)

	// preview?
	if (isset($_POST['preview']))
	{
		echo $form_buttons;

		$text_chars	= number_format(strlen($_body), 0, ',', '.');
		$preview	= $this->format($body,		'pre_wacko');
		$preview	= $this->format($preview,	'wacko');
		$preview	= $this->format($preview,	'post_wacko');

		$output = '<div class="preview"><p class="preview"><span>'.$this->get_translation('EditPreview').' ('.$text_chars.' '.$this->get_translation('Chars').")</span></p>\n";

		if ($this->config['edit_summary'] != 0)
		{
			$output .= '<div class="commenttitle">'."\n".'<a href="#">'.$title."</a>\n</div>\n";
		}

		$output .= $preview;
		$output .= "</div><br />\n";

		echo $output;

		// edit
		$output = '';
		#$title	= $_POST['title'];
	}

	if (isset($_SESSION['body']) && $_SESSION['body'] != '')
	{
		$body				= $_SESSION['body'];
		$_SESSION['body']	= '';
	}

	if (isset($_SESSION['title']) && $_SESSION['title'] != '')
	{
		$title				= $_SESSION['title'];
		$_SESSION['title']	= '';
	}
	else if (isset($_POST['title']) && $_POST['title'] == true)
	{
		$title				= $_POST['title'];
	}
	else if (isset($this->page['title']))
	{
		$title				= $this->page['title'];
	}

	echo $form_buttons;
?>
	<br />
	<noscript><div class="errorbox_js"><?php echo $this->get_translation('WikiEditInactiveJs'); ?></div></noscript>
<?php
	// comment title
	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] != 0)
	{
		$output .= '<br />'."\n";
		$output .= '<label for="addcomment_title">'.$this->get_translation('AddCommentTitle').'</label><br />';
		$output .= '<input type="text" id="addcomment_title" maxlength="100" value="'.htmlspecialchars($title, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" size="60" name="title" />';
		$output .= '<br />'."\n";
	}
	else if (!$this->page)
	{
		// new page title field
		$output .= '<br />'."\n";
		$output .= '<label for="addpage_title">'.$this->get_translation('MetaTitle').':</label><br />';
		$output .= '<input type="text" id="addpage_title" value="'.htmlspecialchars($title, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" size="60" maxlength="100" name="title" />';
		$output .= '<br />'."\n";
	}

	$output .= '<input type="hidden" name="previous" value="'.htmlspecialchars($previous, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" /><br />'."\n";
	$output .= '<textarea id="postText" name="body" rows="40" cols="60" class="TextArea">';
	$output .= htmlspecialchars($body, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)."</textarea>\n";
	$output .= '<br />'."\n";

	if (isset($this->page['comment_on_id']) && $this->page['comment_on_id'] == false)
	{
		// edit note
		if ($this->config['edit_summary'] != 0)
		{
			$output .= '<label for="edit_note">'.$this->get_translation('EditNote').':</label><br />';
			// briefly describe your changes (corrected spelling, fixed grammar, improved formatting)
			$output .= '<input type="text" id="edit_note" maxlength="200" value="'.htmlspecialchars($edit_note, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" size="60" name="edit_note"/>';
			$output .= "&nbsp;&nbsp;&nbsp;"; // "<br />";
		}

		// minor edit
		if ($this->page && $this->config['minor_edit'] != 0)
		{
			$output .= '<input type="checkbox" id="minor_edit" value="1" name="minor_edit"/>';
			$output .= '<label for="minor_edit">'.$this->get_translation('EditMinor').'</label>';
			$output .= '<br />'."\n";
		}
		else
		{
			$output .= '<br />'."\n";
		}

		if ($user)
		{
			// reviewed
			if ($this->page && $this->config['review'] != 0 && $this->is_reviewer())
			{
				$output .= '<input type="checkbox" id="reviewed" value="1" name="reviewed"/>';
				$output .= '<label for="reviewed">'.$this->get_translation('Reviewed').'</label>';
				$output .= '<br />'."\n";
			}

			// publish anonymously
			if (($this->page && $this->config['publish_anonymously'] != 0 && $this->has_access('write', '', GUEST)) || (!$this->page && $this->has_access('create', '', GUEST)))
			{
				$output .= '<input type="checkbox" name="noid_publication" id="noid_publication" value="'.$this->page['page_id'].'"'.( $this->get_user_setting('noid_pubs') == 1 ? ' checked="checked"' : '' ).' />';
				$output .= '<label for="noid_publication">'.$this->get_translation('PostAnonymously').'</label>';
				$output .= '<br />'."\n";
			}

			// watch a page
			if ($this->page && $this->is_watched !== true)
			{
				$output .= '<input type="checkbox" name="watchpage" id="watchpage" value="1"'.( $this->get_user_setting('send_watchmail') == 1 ? ' checked="checked"' : '' ).' />';
				$output .= '<label for="watchpage">'.$this->get_translation('NotifyMe').'</label>';
				$output .= '<br />'."\n";
			}
		}
	}

	if (!$this->page && $words = $this->get_categories_list($this->page_lang, 1))
	{
		foreach ($words as $id => $word)
		{
			$_words[] = '<br /><span class="nobr">&nbsp;&nbsp;<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent_id'].'" value="set"'.( isset($_POST['category'.$id.'|'.$word['parent_id']]) && $_POST['category'.$id.'|'.$word['parent_id']] == 'set' ? ' checked="checked"' : '' ).' />'.
						'<label for="category'.$id.'"><strong>'.htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</strong></label></span>'."\n";

			if (isset($word['childs']) && $word['childs'] == true)
			{
				foreach ($word['childs'] as $id => $word)
				{
					$_words[] = '<span class="nobr">&nbsp;&nbsp;&nbsp;<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent_id'].'" value="set"'.( isset($_POST['category'.$id.'|'.$word['parent_id']]) && $_POST['category'.$id.'|'.$word['parent_id']] == 'set' ? ' checked="checked"' : '' ).' />'.
								'<label for="category'.$id.'">'.htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</label></span>'."\n";
				}
			}
		}

		$output .= '<br />'.$this->get_translation('Categories').':'."\n".'<div class="setcategory"><br />'."\n".substr(implode(' ', $_words), 6).'</div>'."\n";
		$output .= '<br />'."\n";
	}

	echo $output;

	// captcha code starts

	// Only show captcha if the admin enabled it in the config file
	if (($this->page && $this->config['captcha_edit_page']) || (!$this->page && $this->config['captcha_new_page']))
	{
		$this->show_captcha(false);
	}
	// end captcha

?>
	<script>
		wE = new WikiEdit();
<?php
	if ($user = $this->get_user())
	{
		if ($user['autocomplete'])
		{
?>
			if (AutoComplete)
			{
				 wEaC = new AutoComplete( wE, "<?php echo $this->href('edit');?>" );
			}
<?php
		}
	}
?>
		wE.init('postText','WikiEdit','edname-w','<?php echo $this->config['base_url'];?>image/wikiedit/');
	</script>
	<br />

<?php
	echo $form_buttons;
	echo $this->form_close();
}
else
{
	$message = $this->get_translation('WriteAccessDenied');
	$this->show_message($message, 'info');
}

?>
</div>