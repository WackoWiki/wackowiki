<div id="page"><?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}
// and for forum page
else if ($this->forum === true && !$this->is_admin())
{
	$this->redirect($this->href());
}

if ($user = $this->get_user())
{
	$user = strtolower($this->get_user_name());
	$registered = true;
}
else
{
	$user = GUEST;
}

if ($registered
&&
($this->check_acl($user, $this->config['rename_globalacl']) || strtolower($this->get_page_owner($this->tag)) == $user)
)
{
	if (!$this->page)
	{
		print(str_replace('%1', $this->href('edit'), $this->get_translation('DoesNotExists')));
	}
	else
	{
		if (isset($_POST['newname']) && $_POST['rename'] == 1)
		{
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
				$new_name		= preg_replace('/\s+/', '', $_POST['newname']);
				$new_name		= trim($new_name, '/');
				$supernewname	= $this->npj_translit($new_name);

				if (!preg_match('/^([\_\.\-'.$this->language['ALPHANUM_P'].']+)$/', $new_name))
				{
					print($this->get_translation('BadName')."<br />\n");
				}
				//     if ($this->supertag == $supernewname)
				else if ($this->tag == $new_name)
				{
					print(str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlreadyNamed'))."<br />\n");
				}
				else
				{
					if ($this->supertag != $supernewname && $page=$this->load_page($supernewname, 0, '', LOAD_CACHE, LOAD_META))
					{
						print(str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlredyExists'))."<br />\n");
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
								print(str_replace('%1', $this->tag, $this->get_translation('ReferrersRemoved'))."<br />\n");
							}

							if ($this->rename_page($this->tag, $new_name, $supernewname))
							{
								print(str_replace('%1', $this->tag, $this->get_translation('PageRenamed'))."<br />\n");
							}

							$this->clear_cache_wanted_page($new_name);
							$this->clear_cache_wanted_page($supernewname);
						}
						if ($need_redirect == 1)
						{
							$this->cache_wanted_page($this->tag);
							$this->cache_wanted_page($this->supertag);

							if ($this->save_page($this->tag, '', '{{redirect page="/'.$new_name.'"}}'))
							{
								print(str_replace('%1', $this->tag, $this->get_translation('RedirectCreated'))."<br />\n");
							}

							$this->clear_cache_wanted_page($this->tag);
							$this->clear_cache_wanted_page($this->supertag);
						}

						print("<br />".$this->get_translation('NewNameOfPage').$this->link('/'.$new_name));

						// log event
						$this->log(3, str_replace('%2', $new_name, str_replace('%1', $this->tag, $this->get_translation('LogRenamedPage', $this->config['language']))).( $need_redirect == 1 ? $this->get_translation('LogRenamedPage2', $this->config['language']) : '' ));
					}
				}
			}

			//massrename
			if ($need_massrename == 1)
			{
				print "<p><b>".$this->get_translation('MassRenaming')."</b><p>";   //!!!
				recursive_move($this, $this->tag );
			}
		}
		else
		{
			echo $this->get_translation('NewName');
			echo $this->form_open('rename');

			?> <input type="hidden" name="rename" value="1" /><input type="text"
	name="newname" value="<?php echo $this->tag;?>" size="40" /><br />
<br />
			<?php echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" "; if ($this->config['default_rename_redirect'] == 1){echo "checked=\"checked\"";}; echo " /> <label for=\"redirect\">".$this->get_translation('NeedRedirect')."</label>"; ?>
<br />
			<?php if ($this->check_acl($user,$this->config['rename_globalacl']))
			{
				echo "<input type=\"checkbox\" id=\"massrename\" name=\"massrename\" "; echo " /> <label for=\"massrename\">".$this->get_translation('SettingsMassRename')."</label>";
			}
			?> <br />
<br />
			<?php
			// show backlinks
			echo $this->action('backlinks', array('nomark' => 0));
			?> <br />
<br />
<input name="submit" type="submit" value="<?php echo $this->get_translation('RenameButton'); ?>" /> &nbsp;
<input type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>"
	onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
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

function recursive_move(&$parent, $root)
{
	$new_root = trim($_POST['newname'], '/');

	if($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	$query = "'".quote($parent->dblink, $parent->npj_translit($root))."%'";
	$pages = $parent->load_all(
		"SELECT page_id, tag, supertag ".
		"FROM ".$parent->config['table_prefix']."page ".
		"WHERE supertag LIKE ".$query.
		($owner_id
			? " AND owner_id ='".quote($parent->dblink, $owner_id)."'"
			: "").
		" AND comment_on_id = '0'");

	foreach( $pages as $page )
	{
		// $new_name = str_replace( $root, $new_root, $page['tag'] );
		$new_name = preg_replace('/'.preg_quote($root, '/').'/', preg_quote($new_root), $page['tag'], 1);
		move( $parent, $page, $new_name );
	}
}

function move(&$parent, $old_page, $new_name )
{
	//     $new_name = trim($_POST['newname'], '/');
	$user = $parent->get_user();

	if (($parent->check_acl($user,$parent->config['rename_globalacl'])
	|| strtolower($parent->get_page_owner($old_page['tag'])) == $user))
	{
		$supernewname = $parent->npj_translit($new_name);

		if (!preg_match('/^([\_\.\-'.$parent->language['ALPHANUM_P'].']+)$/', $new_name))
		{
			print($parent->get_translation('BadName')."<br />\n");
		}
		//     if ($old_page['supertag'] == $supernewname)
		else if ($old_page['tag'] == $new_name)
		{
			print(str_replace('%1', $parent->link($new_name), $parent->get_translation('AlreadyNamed'))."<br />\n");
		}
		else
		{
			if ($old_page['supertag'] != $supernewname && $page=$parent->load_page($supernewname, 0, '', LOAD_CACHE, LOAD_META))
			{
				print(str_replace('%1', $parent->link($new_name), $parent->get_translation('AlredyExists'))."<br />\n");
			}
			else
			{
				// Rename page
				$need_redirect = 0;

				if ($_POST['redirect'] == 'on')
				{
					$need_redirect = 1;
				}

				if ($need_redirect == 0)
				{
					if ($parent->remove_referrers($old_page['tag']))
					{
						print("<br />".str_replace('%1', $old_page['tag'], $parent->get_translation('ReferrersRemoved'))."<br />\n");
					}

					if ($parent->rename_page($old_page['tag'], $new_name, $supernewname))
					{
						print(str_replace('%1', $old_page['tag'], $parent->get_translation('PageRenamed'))."<br />\n");
					}

					$parent->clear_cache_wanted_page($new_name);
					$parent->clear_cache_wanted_page($supernewname);
				}
				if ($need_redirect == 1)
				{
					$parent->cache_wanted_page($old_page['tag']);
					$parent->cache_wanted_page($old_page['supertag']);

					if ($parent->save_page($old_page['tag'], '', '{{redirect page="/'.$new_name.'"}}'))
					{
						print(str_replace('%1', $old_page['tag'], $parent->get_translation('RedirectCreated'))."<br />\n");
					}

					$parent->clear_cache_wanted_page($old_page['tag']);
					$parent->clear_cache_wanted_page($old_page['supertag']);
				}

				print("<br />".$parent->get_translation('NewNameOfPage').$parent->link('/'.$new_name));

				// log event
				$engine->log(3, str_replace('%2', $new_name, str_replace('%1', $old_page['tag'], $engine->get_translation('LogRenamedPage', $this->config['language']))).( $need_redirect == 1 ? $engine->get_translation('LogRenamedPage2', $this->config['language']) : '' ));
			}
		}
	}
}

?>