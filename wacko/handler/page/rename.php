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
($this->check_acl($user_name, $this->config['rename_globalacl'])
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
				$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', $this->config['language']), $this->tag, $new_name).
					($need_redirect? $this->_t('LogRenamedPage2', $this->config['language']) : '' ));

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

			$this->redirect($this->href('', $new_name));
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

			if ($this->config['default_rename_redirect'] == 1)
			{
				echo 'checked="checked"';
			};

			echo ' /><label for="redirect"> '.$this->_t('NeedRedirect').'</label>'; ?>
<br />
			<?php
			if ($this->check_acl($user_name, $this->config['rename_globalacl']))
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

function recursive_move(&$parent, $root, $new_root)
{
	$message	= '';
	$new_root	= trim($new_root, '/');

	if($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	// FIXME: missing $owner_id -> rename_globalacl || owner
	$owner_id	= '';
	$_root		= $parent->translit($root);
	$pages		= $parent->load_all(
		"SELECT page_id, tag, supertag ".
		"FROM ".$parent->config['table_prefix']."page ".
		"WHERE (supertag LIKE '".quote($parent->dblink, $_root)."/%' ".
			" OR supertag = '".quote($parent->dblink, $_root)."') ".
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

		$message .= move($parent, $page, $new_name);

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
			$message .= '<li>'.$parent->_t('InvalidWikiName')."</li>\n";
		}
		// if ($old_page['supertag'] == $super_new_name)
		else if ($old_page['tag'] == $new_name)
		{
			$message .= '<li>'.Ut::perc_replace($parent->_t('AlreadyNamed'), $parent->link($new_name))."</li>\n";
		}
		else
		{
			if ($old_page['supertag'] != $super_new_name && $page = $parent->load_page($super_new_name, 0, '', LOAD_CACHE, LOAD_META))
			{
				$message .= '<li>'.Ut::perc_replace($parent->_t('AlredyExists'), $parent->link($new_name))."</li>\n";
			}
			else
			{
				// Rename page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($parent->remove_referrers($old_page['tag']))
					{
						$message .= '<li>'.$parent->_t('ReferrersRemoved')."</li>\n";
					}
				}

				if ($parent->rename_page($old_page['tag'], $new_name, $super_new_name))
				{
					$message .= '<li>'.$parent->_t('PageRenamed')."</li>\n";
				}

				$parent->clear_cache_wanted_page($new_name);
				$parent->clear_cache_wanted_page($super_new_name);

				if ($need_redirect)
				{
					$parent->cache_wanted_page($old_page['tag']);
					$parent->cache_wanted_page($old_page['supertag']);

					if ($parent->save_page($old_page['tag'], '', '{{redirect page="/'.$new_name.'"}}', "-> $new_name"))
					{
						$message .= '<li>'.Ut::perc_replace($parent->_t('RedirectCreated'), $parent->link($old_page['tag']))."</li>\n";
					}

					$parent->clear_cache_wanted_page($old_page['tag']);
					$parent->clear_cache_wanted_page($old_page['supertag']);
				}

				$message .= '<li>'.$parent->_t('NewNameOfPage').$parent->link('/'.$new_name)."</li>\n";

				// log event
				$parent->log(3, Ut::perc_replace($parent->_t('LogRenamedPage', $parent->config['language']), $old_page['tag'], $new_name).
					($need_redirect? $parent->_t('LogRenamedPage2', $parent->config['language']) : '' ));
			}
		}

		$message .= "</ul>\n";

		return $message;
	}
}
