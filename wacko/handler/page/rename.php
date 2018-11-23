<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page();

$tpl->page = $this->compose_link_to_page($this->tag, '', '');

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
			$new_tag		= $_POST['new_tag'];
			$new_supertag	= $this->translit($new_tag);
			$old_supertag	= $this->page['supertag'];

			if (($error = $this->sanitize_new_pagename($new_tag, $new_supertag, $this->tag)))
			{
				$this->set_message($error, 'error');
				$this->reload_me();
			}

			// rename
			if (!isset($_POST['massrename']))
			{
				$message .= '<strong><code>' . $this->tag . "</code></strong>\n";
				$message .= '<ol>';

				// rename single page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($this->remove_referrers($this->tag))
					{
						$message .= '<li>' . $this->_t('ReferrersRemoved') . "</li>\n";
					}
				}

				if ($this->rename_page($this->tag, $new_tag, $new_supertag))
				{
					$message .= '<li>' . $this->_t('PageRenamed') . "</li>\n";
				}

				// unset object cache
				$this->page_id_cache[$this->tag] = null;

				$this->clear_cache_wanted_page($new_tag);
				$this->clear_cache_wanted_page($new_supertag);

				if ($need_redirect && ($old_supertag != $new_supertag))
				{
					$this->cache_wanted_page($this->tag);
					$this->cache_wanted_page($this->supertag);

					// set redirect on original page
					if ($this->save_page($this->tag, '', '{{redirect page="/' . $new_tag . '"}}', $this->_t('RedirectedTo') . ' ' . $new_tag))
					{
						$message .= '<li>' . Ut::perc_replace($this->_t('RedirectCreated'), $this->link($this->tag)) . "</li>\n";
					}

					$this->clear_cache_wanted_page($this->tag);
					$this->clear_cache_wanted_page($this->supertag);
				}

				$message .= '<li>' . $this->_t('NewNameOfPage') . $this->link('/' . $new_tag) . "</li>\n";

				// log event
				$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $this->tag, $new_tag) .
					($need_redirect? $this->_t('LogRenamedPage2', SYSTEM_LANG) : '' ));

				$message .= "</ol>\n";
			}
			else
			{
				// massrename
				$message .= '<p><strong>' . $this->_t('MassRenaming') . '</strong><p>';   //!!!
				$message .= recursive_move($this, $this->tag, $new_tag);
			}

			$this->db->invalidate_sql_cache();

			// update sitemap
			$this->update_sitemap();

			$this->set_message($message, 'success'); // TODO & error too

			$this->http->redirect($this->href('', $new_tag));
		}
		else
		{
			// show rename form
			$tpl->f_tag	= $this->tag;

			if ($this->db->default_rename_redirect == 1)
			{
				$tpl->f_checked	= ' checked';
			}

			if ($this->check_acl($user_name, $this->db->rename_globalacl))
			{
				$tpl->f_global = true;
			}

			// show backlinks
			$tpl->f_backlinks	= $this->action('backlinks', ['nomark' => 0]);

			// show sub-pages
			$tpl->f_tree 		= $this->action('tree', ['depth' => 3]);
		}
	}
}
else
{
	$tpl->denied = true;
}

function recursive_move(&$engine, $root, $new_root)
{
	$message	= '';
	$new_root	= trim($new_root, '/');

	if ($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	// FIXME: missing $owner_id -> rename_globalacl || owner
	$owner_id	= '';
	$_root		= $engine->translit($root);
	$pages		= $engine->db->load_all(
					"SELECT page_id, tag, supertag " .
					"FROM " . $engine->db->table_prefix . "page " .
					"WHERE (supertag LIKE " . $engine->db->q($_root . '/%') . " " .
						" OR supertag = " . $engine->db->q($_root) . ") " .
					($owner_id
						? "AND owner_id = " . (int) $owner_id . " "
						: "") .
					"AND comment_on_id = 0");

	$message .= "<ol>\n";

	foreach ($pages as $page)
	{
		$message .= '<li><strong>' . $page['tag'] . "</strong>\n";

		// $new_tag = str_replace( $root, $new_root, $page['tag'] );
		$new_tag = preg_replace('/' . preg_quote($root, '/') . '/', preg_quote($new_root), $page['tag'], 1);

		// FIXME: preg_quote is not universally suitable for escaping the replacement string. A single . will become \. and the preg_replace call will not undo the escaping.
		$new_tag = stripslashes($new_tag);

		$message .= move($engine, $page, $new_tag);

		$message .= "</li>\n";
	}

	$message .= "</ol>\n";

	return $message;
}

function move(&$engine, $old_page, $new_tag)
{
	$message	= '';
	$user		= $engine->get_user();
	$user_id	= $engine->get_user_id();

	if (($engine->check_acl($user['user_name'], $engine->db->rename_globalacl)
	|| $engine->get_page_owner_id($old_page['page_id']) == $user_id))
	{
		$new_supertag = $engine->translit($new_tag);

		$message .= "<ul>\n";

		if (!preg_match('/^([\_\.\-' . $engine->language['ALPHANUM_P'] . ']+)$/', $new_tag))
		{
			$message .= '<li>' . $engine->_t('InvalidWikiName') . "</li>\n";
		}
		else if ($old_page['tag'] == $new_tag)
		{
			$message .= '<li>' . Ut::perc_replace($engine->_t('AlreadyNamed'), $engine->link($new_tag)) . "</li>\n";
		}
		else
		{
			if ($old_page['supertag'] != $new_supertag && $page = $engine->load_page($new_supertag, 0, '', LOAD_CACHE, LOAD_META))
			{
				$message .= '<li>' . Ut::perc_replace($engine->_t('AlreadyExists'), $engine->link($new_tag)) . "</li>\n";
			}
			else
			{
				// Rename page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($engine->remove_referrers($old_page['tag']))
					{
						$message .= '<li>' . $engine->_t('ReferrersRemoved') . "</li>\n";
					}
				}

				if ($engine->rename_page($old_page['tag'], $new_tag, $new_supertag))
				{
					$message .= '<li>' . $engine->_t('PageRenamed') . "</li>\n";
				}

				// unset object cache for current page
				$engine->page_id_cache[$engine->tag] = null;

				$engine->clear_cache_wanted_page($new_tag);
				$engine->clear_cache_wanted_page($new_supertag);

				if ($need_redirect && ($old_page['supertag'] != $new_supertag))
				{
					$engine->cache_wanted_page($old_page['tag']);
					$engine->cache_wanted_page($old_page['supertag']);

					if ($engine->save_page($old_page['tag'], '', '{{redirect page="/' . $new_tag . '"}}', $engine->_t('RedirectedTo') . ' ' . $new_tag))
					{
						$message .= '<li>' . Ut::perc_replace($engine->_t('RedirectCreated'), $engine->link($old_page['tag'])) . "</li>\n";
					}

					$engine->clear_cache_wanted_page($old_page['tag']);
					$engine->clear_cache_wanted_page($old_page['supertag']);
				}

				$message .= '<li>' . $engine->_t('NewNameOfPage') . $engine->link('/' . $new_tag) . "</li>\n";

				// log event
				$engine->log(3, Ut::perc_replace($engine->_t('LogRenamedPage', SYSTEM_LANG), $old_page['tag'], $new_tag) .
					($need_redirect? $engine->_t('LogRenamedPage2', SYSTEM_LANG) : '' ));
			}
		}

		$message .= "</ul>\n";

		return $message;
	}
}
