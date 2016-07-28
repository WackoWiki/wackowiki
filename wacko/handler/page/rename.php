<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page();

echo '<h3>' . $this->_t('RenamePage') . ' ' . $this->compose_link_to_page($this->tag, '', '', 0) . "</h3>\n<br />\n";

if ($user = $this->get_user())
{
	$user_name	= strtolower($this->get_user_name());
	$user_id	= $this->get_user_id();
	$registered	= true;
}
else
{
	$user_name	= GUEST;
	$registered	= false;
}

$message = '';

if ($registered
&&
($this->check_acl($user_name, $this->db->rename_globalacl)
	|| $this->get_page_owner_id($this->page['page_id']) == $user_id)
)
{
	if (!$this->page)
	{
		$message .= Ut::perc_replace($this->_t('DoesNotExists'), $this->href('edit'));
	}
	else
	{
		if (@$_POST['_action'] === 'rename_page')
		{
			$new_name		= $_POST['newname'];

			if (($error = $this->sanitize_new_pagename($new_name, $super_new_name, $this->tag)))
			{
				$this->set_message($error, 'error');
				$this->reload_me();
			}

			// rename
			if (!isset($_POST['massrename']))
			{

				$message .= '<strong><code>'.$this->tag."</code></strong>\n";
				$message .= '<ol>';

				// Rename page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($this->remove_referrers($this->tag))
					{
						$message .= '<li>'.$this->_t('ReferrersRemoved')."</li>\n";
					}
				}

				if ($this->rename_page($this->tag, $new_name, $super_new_name))
				{
					$message .= '<li>'.$this->_t('PageRenamed')."</li>\n";
				}

				$this->clear_cache_wanted_page($new_name);
				$this->clear_cache_wanted_page($super_new_name);

				if ($need_redirect)
				{
					$this->cache_wanted_page($this->tag);
					$this->cache_wanted_page($this->supertag);

					if ($this->save_page($this->tag, '', '{{redirect page="/'.$new_name.'"}}', "-> $new_name"))
					{
						$message .= '<li>'.Ut::perc_replace($this->_t('RedirectCreated'), $this->link($this->tag))."</li>\n";
					}

					$this->clear_cache_wanted_page($this->tag);
					$this->clear_cache_wanted_page($this->supertag);
				}

				$message .= '<li>'.$this->_t('NewNameOfPage').$this->link('/'.$new_name)."</li>\n";

				// log event
				$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', $this->db->language), $this->tag, $new_name).
					($need_redirect? $this->_t('LogRenamedPage2', $this->db->language) : '' ));

				$message .= "</ol>\n";
			}
			else
			{
				//massrename
				$message .= '<p><strong>'.$this->_t('MassRenaming').'</strong><p>';   //!!!
				$message .= recursive_move($this, $this->tag, $new_name);
			}

			$this->config->invalidate_sql_cache();

			// update sitemap
			$this->update_sitemap();

			$this->set_message($message, 'success'); // TODO & error too

			$this->http->redirect($this->href('', $new_name));
		}
		else
		{
			echo $this->_t('NewName');
			echo $this->form_open('rename_page', ['page_method' => 'rename']);

			?>
			<input type="text" maxlength="250" name="newname" value="<?php echo $this->tag;?>" size="60" />
<br />
<br />
			<?php
			echo '<input type="checkbox" id="redirect" name="redirect" ';

			if ($this->db->default_rename_redirect == 1)
			{
				echo 'checked="checked"';
			};

			echo ' /><label for="redirect"> '.$this->_t('NeedRedirect').'</label>'; ?>
<br />
			<?php
			if ($this->check_acl($user_name, $this->db->rename_globalacl))
			{
				echo '<input type="checkbox" id="massrename" name="massrename" />';
				echo '<label for="massrename"> '.$this->_t('MassRename').'</label>';
			}
			?>
<br />
<br />
			<?php
			// show backlinks
			echo $this->action('backlinks', array('nomark' => 0));
			?>
<br />
<br />
<input type="submit" class="OkBtn" name="submit" value="<?php echo $this->_t('RenameButton'); ?>" /> &nbsp;
<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" value="<?php echo str_replace("\n"," ",$this->_t('EditCancelButton')); ?>"/></a>
<br />
<br />
			<?php echo $this->form_close();
		}
	}
}
else
{
	$this->show_message($this->_t('NotOwnerAndCantRename'), 'info');
}

function recursive_move(&$engine, $root, $new_root)
{
	$message	= '';
	$new_root	= trim($new_root, '/');

	if($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	// FIXME: missing $owner_id -> rename_globalacl || owner
	$owner_id	= '';
	$_root		= $engine->translit($root);
	$pages		= $engine->db->load_all(
		"SELECT page_id, tag, supertag ".
		"FROM ".$engine->db->table_prefix."page ".
		"WHERE (supertag LIKE " . $engine->db->q($_root . '/%') . " ".
			" OR supertag = " . $engine->db->q($_root) . ") ".
		($owner_id
			? " AND owner_id ='".(int)$owner_id."'"
			: "").
		" AND comment_on_id = '0'");

	$message .= "<ol>\n";

	foreach($pages as $page)
	{
		$message .= '<li><strong>'.$page['tag']."</strong>\n";

		// $new_name = str_replace( $root, $new_root, $page['tag'] );
		$new_name = preg_replace('/'.preg_quote($root, '/').'/', preg_quote($new_root), $page['tag'], 1);

		// FIXME: preg_quote is not universally suitable for escaping the replacement string. A single . will become \. and the preg_replace call will not undo the escaping.
		$new_name = stripslashes($new_name);

		$message .= move($engine, $page, $new_name);

		$message .= "</li>\n";
	}

	$message .= "</ol>\n";

	return $message;
}

function move(&$engine, $old_page, $new_name)
{
	$message	= '';
	$user		= $engine->get_user();
	$user_id	= $engine->get_user_id();

	if (($engine->check_acl($user['user_name'], $engine->db->rename_globalacl)
	|| $engine->get_page_owner_id($old_page['page_id']) == $user_id))
	{
		$super_new_name = $engine->translit($new_name);

		$message .= "<ul>\n";

		if (!preg_match('/^([\_\.\-'.$engine->language['ALPHANUM_P'].']+)$/', $new_name))
		{
			$message .= '<li>'.$engine->_t('InvalidWikiName')."</li>\n";
		}
		// if ($old_page['supertag'] == $super_new_name)
		else if ($old_page['tag'] == $new_name)
		{
			$message .= '<li>'.Ut::perc_replace($engine->_t('AlreadyNamed'), $engine->link($new_name))."</li>\n";
		}
		else
		{
			if ($old_page['supertag'] != $super_new_name && $page = $engine->load_page($super_new_name, 0, '', LOAD_CACHE, LOAD_META))
			{
				$message .= '<li>'.Ut::perc_replace($engine->_t('AlreadyExists'), $engine->link($new_name))."</li>\n";
			}
			else
			{
				// Rename page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($engine->remove_referrers($old_page['tag']))
					{
						$message .= '<li>'.$engine->_t('ReferrersRemoved')."</li>\n";
					}
				}

				if ($engine->rename_page($old_page['tag'], $new_name, $super_new_name))
				{
					$message .= '<li>'.$engine->_t('PageRenamed')."</li>\n";
				}

				$engine->clear_cache_wanted_page($new_name);
				$engine->clear_cache_wanted_page($super_new_name);

				if ($need_redirect)
				{
					$engine->cache_wanted_page($old_page['tag']);
					$engine->cache_wanted_page($old_page['supertag']);

					if ($engine->save_page($old_page['tag'], '', '{{redirect page="/'.$new_name.'"}}', "-> $new_name"))
					{
						$message .= '<li>'.Ut::perc_replace($engine->_t('RedirectCreated'), $engine->link($old_page['tag']))."</li>\n";
					}

					$engine->clear_cache_wanted_page($old_page['tag']);
					$engine->clear_cache_wanted_page($old_page['supertag']);
				}

				$message .= '<li>'.$engine->_t('NewNameOfPage').$engine->link('/'.$new_name)."</li>\n";

				// log event
				$engine->log(3, Ut::perc_replace($engine->_t('LogRenamedPage', $engine->db->language), $old_page['tag'], $new_name).
					($need_redirect? $engine->_t('LogRenamedPage2', $engine->db->language) : '' ));
			}
		}

		$message .= "</ul>\n";

		return $message;
	}
}
