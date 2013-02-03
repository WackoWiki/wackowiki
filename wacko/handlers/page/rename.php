<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page"><?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}
// and for forum page
else if ($this->forum === true && !$this->is_admin())
{
	$this->redirect($this->href());
}

if ($user = $this->get_user())
{
	$user_name	= strtolower($this->get_user_name());
	$user_id	= $this->get_user_id();
	$registered	= true;
}
else
{
	$user_name		= GUEST;
}

$message = '';

if ($registered
&&
($this->check_acl($user_name, $this->config['rename_globalacl']) || $this->get_page_owner_id($this->page['page_id']) == $user_id)
)
{
	if (!$this->page)
	{
		$message .= str_replace('%1', $this->href('edit'), $this->get_translation('DoesNotExists'));
	}
	else
	{
		if (isset($_POST['newname']) && $_POST['rename'] == 1)
		{
			$new_root		= $_POST['newname'];
			// rename or massrename
			$need_massrename = 0;

			if (isset($_POST['massrename']) && $_POST['massrename'] == 'on')
			{
				$need_massrename = 1;
			}

			// rename
			if ($need_massrename == 0)
			{
				// strip whitespaces
				$new_name		= preg_replace('/\s+/', '', $new_root);
				$new_name		= trim($new_name, '/');
				$super_new_name	= $this->translit($new_name);

				$message .= '<b>'.$this->tag."</b>\n";
				$message .= '<ol>';

				// check if reserved word
				if($result = $this->validate_reserved_words($new_name))
				{
					$message .= "<li>".str_replace('%1', $result, $this->get_translation('PageReservedWord'))."</li>\n";
				}
				else if (!preg_match('/^([\_\.\-'.$this->language['ALPHANUM_P'].']+)$/', $new_name))
				{
					$message .= "<li>".$this->get_translation('InvalidWikiName')."</li>\n";
				}
				// if ($this->supertag == $super_new_name)
				else if ($this->tag == $new_name)
				{
					$message .= "<li>".str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlreadyNamed'))."</li>\n";
				}
				else
				{
					if ($this->supertag != $super_new_name && $page=$this->load_page($super_new_name, 0, '', LOAD_CACHE, LOAD_META))
					{
						$message .= "<li>".str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlredyExists'))."</li>\n";
					}
					else
					{
						// Rename page
						$need_redirect = 0;

						if (isset($_POST['redirect']) && $_POST['redirect'] == 'on')
						{
							$need_redirect = 1;
						}

						if ($need_redirect == 0)
						{
							if ($this->remove_referrers($this->tag))
							{
								$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('ReferrersRemoved'))."</li>\n";
							}
						}

						if ($this->rename_page($this->tag, $new_name, $super_new_name))
						{
							$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('PageRenamed'))."</li>\n";
						}

						$this->clear_cache_wanted_page($new_name);
						$this->clear_cache_wanted_page($super_new_name);

						if ($need_redirect == 1)
						{
							$this->cache_wanted_page($this->tag);
							$this->cache_wanted_page($this->supertag);

							// TODO: set message also in edit_note
							if ($this->save_page($this->tag, '', '{{redirect page="/'.$new_name.'"}}'))
							{
								$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('RedirectCreated'))."</li>\n";
							}

							$this->clear_cache_wanted_page($this->tag);
							$this->clear_cache_wanted_page($this->supertag);
						}

						$message .= "<li>".$this->get_translation('NewNameOfPage').$this->link('/'.$new_name)."</li>\n";

						// log event
						$this->log(3, str_replace('%2', $new_name, str_replace('%1', $this->tag, $this->get_translation('LogRenamedPage', $this->config['language']))).( $need_redirect == 1 ? $this->get_translation('LogRenamedPage2', $this->config['language']) : '' ));
					}
				}

				$message .= "</ol>\n";
			}

			//massrename
			if ($need_massrename == 1)
			{
				$message .= '<p><b>'.$this->get_translation('MassRenaming').'</b><p>';   //!!!
				recursive_move($this, $this->tag, $new_root);
			}

			$this->show_message($message, 'info');
		}
		else
		{
			echo $this->get_translation('NewName');
			echo $this->form_open('rename');

			?> <input type="hidden" name="rename" value="1" /><input type="text" name="newname" value="<?php echo $this->tag;?>" size="40" /><br />
<br />
			<?php
			echo '<input type="checkbox" id="redirect" name="redirect" ';

			if ($this->config['default_rename_redirect'] == 1)
			{
				echo 'checked="checked"';
			};

			echo ' /> <label for="redirect">'.$this->get_translation('NeedRedirect').'</label>'; ?>
<br />
			<?php
			if ($this->check_acl($user_name, $this->config['rename_globalacl']))
			{
				echo '<input type="checkbox" id="massrename" name="massrename" />';
				echo '<label for="massrename">'.$this->get_translation('MassRename').'</label>';
			}
			?> <br />
<br />
			<?php
			// show backlinks
			echo $this->action('backlinks', array('nomark' => 0));
			?> <br />
<br />
<input class="OkBtn" name="submit" type="submit" value="<?php echo $this->get_translation('RenameButton'); ?>" /> &nbsp;
<input class="CancelBtn" type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
<br />
<br />
			<?php echo $this->form_close();
		}
	}
}
else
{
	echo $this->get_translation('NotOwnerAndCantRename');
}
?></div>
<?php

function recursive_move(&$parent, $root, $new_root)
{
	$message	= '';
	$new_root	= trim($new_root, '/');

	if($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	// FIXME: missing $owner_id -> rename_globalacl || owner
	$owner_id = '';
	$query = "'".quote($parent->dblink, $parent->translit($root))."%'";
	$pages = $parent->load_all(
		"SELECT page_id, tag, supertag ".
		"FROM ".$parent->config['table_prefix']."page ".
		"WHERE supertag LIKE ".$query.
		($owner_id
			? " AND owner_id ='".quote($parent->dblink, $owner_id)."'"
			: "").
		" AND comment_on_id = '0'");

	$message .= "<ol>\n";

	foreach($pages as $page)
	{
		$message .= "<li><b>".$page['tag']."</b>\n";

		// $new_name = str_replace( $root, $new_root, $page['tag'] );
		$new_name = preg_replace('/'.preg_quote($root, '/').'/', preg_quote($new_root), $page['tag'], 1);

		// FIXME: preg_quote is not universally suitable for escaping the replacement string. A single . will become \. and the preg_replace call will not undo the escaping.
		$new_name = stripslashes($new_name);

		move($parent, $page, $new_name);

		$message .= "</li>\n";
	}

	$message .= "</ol>\n";

	return $message;
}

function move(&$parent, $old_page, $new_name)
{
	$message	= '';
	$user		= $parent->get_user();
	$user_id	= $parent->get_user_id();

	if (($parent->check_acl($user['user_name'], $parent->config['rename_globalacl'])
	|| $parent->get_page_owner_id($old_page['page_id']) == $user_id))
	{
		$super_new_name = $parent->translit($new_name);

		$message .= "<ul>\n";

		if (!preg_match('/^([\_\.\-'.$parent->language['ALPHANUM_P'].']+)$/', $new_name))
		{
			$message .= "<li>".$parent->get_translation('InvalidWikiName')."</li>\n";
		}
		// if ($old_page['supertag'] == $super_new_name)
		else if ($old_page['tag'] == $new_name)
		{
			$message .= "<li>".str_replace('%1', $parent->link($new_name), $parent->get_translation('AlreadyNamed'))."</li>\n";
		}
		else
		{
			if ($old_page['supertag'] != $super_new_name && $page=$parent->load_page($super_new_name, 0, '', LOAD_CACHE, LOAD_META))
			{
				$message .= "<li>".str_replace('%1', $parent->link($new_name), $parent->get_translation('AlredyExists'))."</li>\n";
			}
			else
			{
				// Rename page
				$need_redirect = 0;

				if (isset($_POST['redirect']) && $_POST['redirect'] == 'on')
				{
					$need_redirect = 1;
				}

				if ($need_redirect == 0)
				{
					if ($parent->remove_referrers($old_page['tag']))
					{
						$message .= "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('ReferrersRemoved'))."</li>\n";
					}
				}

				if ($parent->rename_page($old_page['tag'], $new_name, $super_new_name))
				{
					$message .= "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('PageRenamed'))."</li>\n";
				}

				$parent->clear_cache_wanted_page($new_name);
				$parent->clear_cache_wanted_page($super_new_name);

				if ($need_redirect == 1)
				{
					$parent->cache_wanted_page($old_page['tag']);
					$parent->cache_wanted_page($old_page['supertag']);

					if ($parent->save_page($old_page['tag'], '', '{{redirect page="/'.$new_name.'"}}'))
					{
						$message .= "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('RedirectCreated'))."</li>\n";
					}

					$parent->clear_cache_wanted_page($old_page['tag']);
					$parent->clear_cache_wanted_page($old_page['supertag']);
				}

				$message .= "<li>".$parent->get_translation('NewNameOfPage').$parent->link('/'.$new_name)."</li>\n";

				// log event
				$parent->log(3, str_replace('%2', $new_name, str_replace('%1', $old_page['tag'], $parent->get_translation('LogRenamedPage', $parent->config['language']))).( $need_redirect == 1 ? $parent->get_translation('LogRenamedPage2', $parent->config['language']) : '' ));
			}
		}

		$message .= "</ul>\n";

		return $message;
	}
}

?>