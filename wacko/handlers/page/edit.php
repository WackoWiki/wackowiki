<?php

$edit_note		= '';
$minor_edit		= '';
$reviewed		= '';
$error			= '';
$output			= '';

// invoke autocomplete if needed
if ((isset($_GET['_autocomplete'])) && $_GET['_autocomplete'])
{
	include( dirname(__FILE__).'/_autocomplete.php' );
	return;
}

?>
<div id="pageedit">
<?php

if ($this->has_access('read') && (($this->page && $this->has_access('write')) || (!$this->page && $this->has_access('create'))))
{
	$user	= $this->get_user();

	if ($_POST)
	{
		$textchars	= strlen($_POST['body']);

		// watch page
		if ($this->page && isset($_POST['watchpage']) && $_POST['noid_publication'] != $this->tag && $user && $this->iswatched !== true)
		{
			$this->set_watch($user['user_id'], $this->page['page_id']);
			$this->iswatched = true;
		}

		// only if saving:
		if (isset($_POST['save']) && $_POST['body'] != '')
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

			// check for overwriting
			if ($this->page && $this->page['modified'] != $_POST['previous'])
			{
				$error = $this->get_translation('OverwriteAlert');
			}

			// check text length
			#if ($textchars > $maxchars)
			#{
			#	$error .= str_replace('%1', $textchars - $maxchars, $this->get_translation('TextDBOversize')).' ';
			#}

			// check for edit note
			if (($this->config['edit_summary'] == 2) && $_POST['edit_note'] == '' && $this->page['comment_on_id'] == 0)
			{
				$error .= $this->get_translation('EditNoteMissing');
			}

			// check categories
			#if (!$this->page && $this->get_categories_list($this->page_lang, 1) && $this->save_categories_list($this->page['page_id'], 1) !== true)
			#{
			#	$error .= 'Select at least one referring category (field) to the page. ';
			#}

			// captcha code starts
			if (($this->page && $this->config['captcha_edit_page']) || (!$this->page && $this->config['captcha_new_page']))
			{
				// Don't load the captcha at all if the GD extension isn't enabled
				if (extension_loaded('gd'))
				{
					// check whether anonymous user
					// anonymous user has no name
					// if false, we assume it's anonymous
					if ($this->get_user_name() == false)
					{
						//anonymous user, check the captcha
						if (!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
						{
							if ($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
							{
								// reset freecap session vars
								// cannot stress enough how important it is to do this
								// defeats re-use of known image with spoofed session id
								$_SESSION['freecap_attempts'] = 0;
								$_SESSION['freecap_word_hash'] = false;

								// now process form
								$word_ok = true;
							}
							else
							{
								$word_ok = false;
							}
						}
						else
						{
							$word_ok = false;
						}

						if (!$word_ok)
						{
							//not the right word
							$error = $this->get_translation('SpamAlert');
						}
					}
				}
			}

			$body = str_replace("\r", '', $_POST['body']);

			// You're not allowed to have empty comments as they would be kinda pointless.
			if (!$body && $this->page['comment_on_id'] != 0)
			{
				$error .= $this->get_translation('EmptyComment');
			}

			// store
			if (!$error)
			{
				// publish anonymously
				if (isset($_POST['noid_publication']) && $_POST['noid_publication'] == $this->tag)
				{
					// undefine username
					$remember_name = $this->get_user_name();
					$this->set_user_setting('user_name', null);
				}

				// add page (revisions)
				$body_r = $this->save_page($this->tag, $title, $body, $edit_note, $minor_edit, $reviewed, $this->page['comment_on_id']);

				// log event
				if ($this->page['comment_on_id'] != 0)
				{
					// comment modified
					$this->log(6, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogCommentEdited', $this->config['language'])));
				}
				else
				{
					// log event, save categories
					if ($this->page == false)
					{
						// new page created
						$this->save_categories_list($this->get_page_id($this->tag));
						$this->log(4, str_replace('%1', $this->tag." ".$_POST['title'], $this->get_translation('LogPageCreated', $this->config['language'])));
					}
					else
					{
						// old page modified
						$this->log(6, str_replace('%1', $this->tag." ".$this->page['title'], $this->get_translation('LogPageEdited', $this->config['language'])));
					}

					// restore username after anonymous publication
					if ($_POST['noid_publication'] == $this->tag)
					{
						$this->set_user_setting('user_name', $remember_name);
						unset($remember_name);

						if ($body_r)
						{
							$this->set_user_setting('noid_protect', true);
						}
					}

					// now we render it internally so we can write the updated link table.
					$this->clear_link_table();
					$this->start_link_tracking();
					$dummy = $this->format($body_r, 'post_wacko');
					$this->stop_link_tracking();
					$this->write_link_table($this->page['page_id']);
					$this->clear_link_table();
				}

				// forward
				$this->page_cache['supertag'][$this->supertag]			= '';
				$this->page_cache['page_id'][$this->page['page_id']]	= '';

				if ($this->page['comment_on_id'] != 0)
				{
					$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1#'.$this->page['tag']));
				}
				else
				{
					$this->redirect($this->href());
				}
			}
		}
		// saving blank document
		else if ($_POST['body'] == '')
		{
			$this->redirect($this->href());
		}
	}

	$this->no_cache();

	// fetch fields
	$previous	= isset($_POST['previous']) ? $_POST['previous'] : $this->page['modified'];
	$body		= isset($_POST['body']) ? $_POST['body'] : $this->page['body'];
	$body		= html_entity_decode($body);
	$title		= isset($_POST['title']) ? $_POST['title'] : $this->page['title'];
	$title		= html_entity_decode($title);

	if (isset($_POST['edit_note']))		$edit_note	= $_POST['edit_note'];
	if (isset($_POST['minor_edit']))	$minor_edit	= $_POST['minor_edit'];

	// display form
	if ($error)
	{
		$this->set_message("<div class=\"error\">$error</div>\n");
	}

	// "cf" attribute: it is for so called "critical fields" in the form. It is used by some javascript code, which is launched onbeforeunload and shows a pop-up dialog "You are going to leave this page, but there are some changes you made but not saved yet." Is used by this script to determine which changes it need to monitor.
	$output .= $this->form_open('edit', '', 'post', 'edit', ' cf="true" ');

	if (isset($_REQUEST['add']))
	{
		$output .=	'<input name="lang" type="hidden" value="'.$this->page_lang.'" />'.
					'<input name="tag" type="hidden" value="'.$this->tag.'" />'.
					'<input name="add" type="hidden" value="1" />';
	}

	echo $output;

	$output		= '';
	$preview	= '';

	// preview?
	if (isset($_POST['preview']))
	{
?>
		<input name="save" type="submit" value="<?php echo $this->get_translation('EditStoreButton'); ?>" />
		&nbsp;
		<input name="preview" type="submit" value="<?php echo $this->get_translation('EditPreviewButton'); ?>" />
		&nbsp;
		<input type="button" value="<?php echo $this->get_translation('EditCancelButton'); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
<?php
		$preview = $this->format($body, 'pre_wacko');
		$preview = $this->format($preview, 'wacko');
		$preview = $this->format($preview, 'post_wacko');

		$output = "<div class=\"preview\"><p class=\"preview\"><span>".$textchars." ".$this->get_translation('EditPreview')."</span></p>\n";

		if ($this->config['edit_summary'] != 0)
		{
			$output .= "<div class=\"commenttitle\">\n<a href=\"#\">".$title."</a>\n</div>\n";
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
		$body = $_SESSION['body'];
		$_SESSION['body'] = '';
	}

	if (isset($_SESSION['title']) && $_SESSION['title'] != '')
	{
		$title = $_SESSION['title'];
		$_SESSION['title'] = '';
	}
	else if (isset($_POST['title']) && $_POST['title'] == true)
	{
		$title = $_POST['title'];
	}
	else
	{
		$title = $this->page['title'];
	}
?>
		<input name="save" type="submit" value="<?php echo $this->get_translation('EditStoreButton'); ?>" />
		&nbsp;
		<input name="preview" type="submit" value="<?php echo $this->get_translation('EditPreviewButton'); ?>" />
		&nbsp;
		<input type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes($this->href('', '', '', 1))?>';" />
		<br />
		<noscript><div class="errorbox_js"><?php echo $this->get_translation('WikiEditInactiveJs'); ?></div></noscript>
<?php
		$output .= "<input type=\"hidden\" name=\"previous\" value=\"".htmlspecialchars($previous)."\" /><br />";
		$output .= "<textarea id=\"postText\" name=\"body\" rows=\"40\" cols=\"60\" class=\"TextArea\">";
		$output .= htmlspecialchars($body)."</textarea><br />\n";

		// comment title
		if ($this->page['comment_on_id'] != 0)
		{
			$output .= "<label for=\"addcomment_title\">".$this->get_translation('AddCommentTitle').":</label><br />";
			$output .= "<input id=\"addcomment_title\" maxlength=\"100\" value=\"".htmlspecialchars($title)."\" size=\"60\" name=\"title\" />";
			$output .= "<br />";
		}
		else
		{
			if (!$this->page)
			{
				// new page title field
				$output .= "<label for=\"addpage_title\">".$this->get_translation('MetaTitle').":</label><br />";
				$output .= "<input id=\"addpage_title\" value=\"".htmlspecialchars($title)."\" size=\"60\" maxlength=\"100\" name=\"title\" /><br />";
			}

			// edit note
			if ($this->config['edit_summary'] != 0)
			{
				$output .= "<label for=\"edit_note\">".$this->get_translation('EditNote').":</label><br />";
				$output .= "<input id=\"edit_note\" maxlength=\"200\" value=\"".htmlspecialchars($edit_note)."\" size=\"60\" name=\"edit_note\"/>";
				$output .= "&nbsp;&nbsp;&nbsp;"; // "<br />";
			}

			// minor edit
			if ($this->page && $this->config['minor_edit'] != 0)
			{
				$output .= "<input id=\"minor_edit\" type=\"checkbox\" value=\"1\" name=\"minor_edit\"/>";
				$output .= "<label for=\"minor_edit\">".$this->get_translation('EditMinor')."</label>";
				$output .= "<br />";
			}

			if ($user)
			{
				// reviewed
				if ($this->page && $this->config['review'] != 0 && $this->is_reviewer())
				{
					$output .= "<input id=\"reviewed\" type=\"checkbox\" value=\"1\" name=\"reviewed\"/>";
					$output .= "<label for=\"reviewed\">".$this->get_translation('Reviewed')."</label>";
					$output .= "<br />";
				}

				// publish anonymously
				if (($this->page && $this->has_access('write', '', GUEST)) || (!$this->page && $this->has_access('create', '', GUEST)))
				{
					$output .= "<input type=\"checkbox\" name=\"noid_publication\" id=\"noid_publication\" value=\"".htmlspecialchars($this->tag)."\"".( $this->get_user_setting('noid_pubs', 1) == 1 ? "checked=\"checked\"" : "" )." /> <small><label for=\"noid_publication\">".$this->get_translation('PostAnonymously')."</label></small>";
					$output .= "<br />";
				}

				// watch a page
				if ($this->page && $this->iswatched !== true)
				{
					$output .= "<input type=\"checkbox\" name=\"watchpage\" id=\"watchpage\" value=\"1\"".( $this->get_user_setting('send_watchmail', 1) == 1 ? "checked=\"checked\"" : "" )." /> <small><label for=\"watchpage\">".$this->get_translation('NotifyMe')."</label></small>";
					$output .= "<br />";
				}
			}
			else
			{
				$output .= "<br />";
			}
		}

		if (!$this->page && $words = $this->get_categories_list($this->page_lang, 1))
		{
			foreach ($words as $id => $word)
			{
				$_words[] = '<br /><span class="nobr">&nbsp;&nbsp;<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent'].'" value="set"'.( isset($_POST['category'.$id.'|'.$word['parent']]) && $_POST['category'.$id.'|'.$word['parent']] == 'set' ? ' checked="checked"' : '' ).' /><label for="category'.$id.'"><strong>'.htmlspecialchars($word['category']).'</strong></label></span> ';

				if (isset($word['childs']) && $word['childs'] == true)
				{
					foreach ($word['childs'] as $id => $word)
					{
						$_words[] = '<span class="nobr">&nbsp;&nbsp;&nbsp;<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent'].'" value="set"'.( isset($_POST['category'.$id.'|'.$word['parent']]) && $_POST['category'.$id.'|'.$word['parent']] == 'set' ? ' checked="checked"' : '' ).' /><label for="category'.$id.'">'.htmlspecialchars($word['category']).'</label></span> ';
					}
				}
			}

			$output .= "<br />".$this->get_translation('Categories').':<div class="setcategory"><small><br /><br />'.substr(implode(' ', $_words), 6).'</small></div><br /><br />';
		}
		echo $output;

		// captcha code starts

		// Only show captcha if the admin enabled it in the config file
		if (($this->page && $this->config['captcha_edit_page']) || (!$this->page && $this->config['captcha_new_page']))
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if (extension_loaded('gd'))
			{
				// check whether anonymous user
				// anonymous user has no name
				// if false, we assume it's anonymous
				if ($this->get_user_name() == false)
				{
?>
		<label for="captcha"><?php echo $this->get_translation('Captcha');?>:</label>
		<br />
		<img src="<?php echo $this->config['base_url'];?>lib/captcha/freecap.php" id="freecap" alt="<?php echo $this->get_translation('Captcha');?>" /> <a href="" onclick="this.blur(); new_freecap(); return false;" title="<?php echo $this->get_translation('CaptchaReload'); ?>"><img src="<?php echo $this->config['base_url'];?>images/reload.png" width="18" height="17" alt="<?php echo $this->get_translation('CaptchaReload'); ?>" /></a>
		<br />
		<input id="captcha" type="text" name="word" maxlength="6" style="width: 273px;" />
		<br />
		<br />
<?php
				}
			}
		}
		// end captcha
?>
		<script type="text/javascript">
			wE = new WikiEdit();
<?php
	if ($user = $this->get_user())

		if ($user['autocomplete'])
		{
?>
			if (AutoComplete)
			{
				 wEaC = new AutoComplete( wE, "<?php echo $this->href('edit');?>" );
			}
<?php
		}
?>
			wE.init('postText','WikiEdit','edname-w','<?php echo $this->config['base_url'];?>images/wikiedit/');
		</script><br />
		<input name="save" type="submit" value="<?php echo $this->get_translation('EditStoreButton'); ?>" />
		&nbsp;
		<input name="preview" type="submit" value="<?php echo $this->get_translation('EditPreviewButton'); ?>" />
		&nbsp;
		<input type="button" value="<?php echo $this->get_translation('EditCancelButton'); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
<?php
		echo $this->form_close();
	}
	else
	{
		echo "<div id=\"page\">";
		echo $this->get_translation('WriteAccessDenied');
		echo "</div>";
	}

?>
</div>