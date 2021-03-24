<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page();

$tpl->page = $this->compose_link_to_page($this->tag, '', '');

if ($user = $this->get_user())
{
	$user_name	= mb_strtolower($this->get_user_name());
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
			$log			= $tpl->massLog();
			$new_tag		= $_POST['new_tag'];
			$old_tag		= $this->page['tag'];

			if (($error = $this->sanitize_new_page_tag($new_tag, $this->tag)))
			{
				$this->set_message($error, 'error');
				$this->reload_me();
			}

			// rename
			if (!isset($_POST['massrename']))
			{
				$log->mode		= $this->_t('RenamePage');
				$log->log_n_h	= $this->tag;

				// rename single page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($this->remove_referrers($this->tag))
					{
						$log->log_n_l_message = $this->_t('ReferrersRemoved');
					}
				}

				if ($this->rename_page($this->tag, $new_tag))
				{
					$log->log_n_l_message = $this->_t('PageRenamed');
				}

				// unset object cache
				$this->page_id_cache[$this->tag] = null;

				$this->clear_cache_wanted_page($new_tag);

				if ($need_redirect && ($old_tag != $new_tag))
				{
					$this->cache_wanted_page($this->tag);

					// set redirect on original page
					if ($this->save_page($this->tag, '{{redirect page="/' . $new_tag . '"}}', '', $this->_t('RedirectedTo') . ' ' . $new_tag))
					{
						$log->log_n_l_message = Ut::perc_replace($this->_t('RedirectCreated'), $this->link('/' . $this->tag));
						// TODO: clone and set ACLs for non-public pages
						$this->set_noindex($this->get_page_id($this->tag));
					}

					$this->clear_cache_wanted_page($this->tag);
				}

				$log->log_n_l_message = $this->_t('NewNameOfPage') . $this->link('/' . $new_tag);

				// log event
				$this->log(3, Ut::perc_replace($this->_t('LogRenamedPage', SYSTEM_LANG), $this->tag, $new_tag) .
					($need_redirect? $this->_t('LogRenamedPage2', SYSTEM_LANG) : '' ));
			}
			else
			{
				// massrename
				$log->mode		= $this->_t('MassRenaming');
				recursive_move($this, $this->tag, $new_tag, $log);
			}

			$this->db->invalidate_sql_cache();

			// update sitemap
			$this->update_sitemap();

			$this->set_message($log, 'success'); // TODO & error too
			$this->http->redirect($this->href('', $new_tag));
		}
		else
		{
			if ($this->db->multilanguage)
			{
				$languages			= $this->_t('LanguageArray');

				$tpl->l_language	= $languages[$this->page_lang];
				$tpl->l_lang		= $this->page_lang;
				$tpl->l_charset		= $this->get_charset();
			}

			$user_lang			= $user['user_lang'] ?: $this->db->language;

			// avoid charset conflict
			if ($this->get_charset($this->page['page_lang']) != $this->get_charset($user_lang))
			{
				$tpl->m_warning		= Ut::perc_replace($this->_t('RenameCharsetConflict'), '[<code>' . $user_lang . '</code>]', '[<code>' . $this->page['page_lang'] . '</code>]');
			}
			else
			{
				$tpl->enter('f_');

				// show rename form
				$tpl->tag	= $this->tag;

				if ($this->db->default_rename_redirect == 1)
				{
					$tpl->checked	= ' checked';
				}

				if ($this->check_acl($user_name, $this->db->rename_globalacl))
				{
					$tpl->global = true;
				}

				// show backlinks
				$tpl->backlinks	= $this->action('backlinks', ['nomark' => 0]);

				// show sub-pages
				$tpl->tree		= $this->action('tree', ['depth' => 3]);

				$tpl->leave();	// f_
			}
		}
	}
}
else
{
	$tpl->denied = true;
}

function recursive_move(&$engine, $root, $new_root, $log)
{
	$new_root	= utf8_trim($new_root, '/');
	$user		= $engine->get_user();
	$user_lang	= $user['user_lang'] ?: $engine->db->language;

	if ($root == '/')
	{
		exit; // who and where did intend to move root???
	}

	// FIXME: missing $owner_id -> rename_globalacl || owner
	$owner_id	= '';
	$_root		= $root;
	$pages		= $engine->db->load_all(
					"SELECT page_id, tag, page_lang " .
					"FROM " . $engine->db->table_prefix . "page " .
					"WHERE (tag LIKE " . $engine->db->q($_root . '/%') . " " .
						" OR tag = " . $engine->db->q($_root) . ") " .
					($owner_id
						? "AND owner_id = " . (int) $owner_id . " "
						: "") .
					"AND comment_on_id = 0");

	foreach ($pages as $page)
	{
		$log->log_n_h	= $page['tag'];

		// avoid charset conflict
		if ($engine->get_charset($page['page_lang']) != $engine->get_charset($user_lang))
		{
			$log->log_n_l_message =  Ut::perc_replace($engine->_t('SkipCharsetConflict'), $engine->link('/' . $page['tag']), '<code>' . $page['page_lang'] . ' (' . $engine->get_charset($page['page_lang']) . ')</code>');

			continue;
		}

		// $new_tag = str_replace( $root, $new_root, $page['tag'] );
		$new_tag = preg_replace('/' . preg_quote($root, '/') . '/', preg_quote($new_root), $page['tag'], 1);

		// FIXME: preg_quote is not universally suitable for escaping the replacement string. A single . will become \. and the preg_replace call will not undo the escaping.
		$new_tag = stripslashes($new_tag);

		move($engine, $page, $new_tag, $log);
	}
}

function move(&$engine, $old_page, $new_tag, $log)
{
	$user		= $engine->get_user();
	$user_id	= $engine->get_user_id();

	if (($engine->check_acl($user['user_name'], $engine->db->rename_globalacl)
	|| $engine->get_page_owner_id($old_page['page_id']) == $user_id))
	{
		if (!preg_match('/^([' . $engine->language['TAG_P'] . ']+)$/u', $new_tag))
		{
			$log->log_n_l_message = $engine->_t('InvalidWikiName');
		}
		else if ($old_page['tag'] == $new_tag)
		{
			$log->log_n_l_message = Ut::perc_replace($engine->_t('AlreadyNamed'), '<strong>' . $engine->link($new_tag) . '</strong>');
		}
		else
		{
			if ($old_page['tag'] != $new_tag && $engine->load_page($new_tag, 0, '', LOAD_CACHE, LOAD_META))
			{
				$log->log_n_l_message = Ut::perc_replace($engine->_t('AlreadyExists'), '<strong>' . $engine->link($new_tag) . '</strong>');
			}
			else
			{
				// Rename page
				$need_redirect = @$_POST['redirect'] == 'on';

				if (!$need_redirect)
				{
					if ($engine->remove_referrers($old_page['tag']))
					{
						$log->log_n_l_message = $engine->_t('ReferrersRemoved');
					}
				}

				if ($engine->rename_page($old_page['tag'], $new_tag))
				{
					$log->log_n_l_message = $engine->_t('PageRenamed');
				}

				// unset object cache for current page
				$engine->page_id_cache[$engine->tag] = null;

				$engine->clear_cache_wanted_page($new_tag);

				if ($need_redirect && ($old_page['tag'] != $new_tag))
				{
					$engine->cache_wanted_page($old_page['tag']);

					if ($engine->save_page($old_page['tag'], '{{redirect page="/' . $new_tag . '"}}', '', $engine->_t('RedirectedTo') . ' ' . $new_tag))
					{
						$log->log_n_l_message = Ut::perc_replace($engine->_t('RedirectCreated'), $engine->link('/' . $old_page['tag']));
						// TODO: clone and set ACLs for non-public pages
						$engine->set_noindex($engine->get_page_id($old_page['tag']));
					}

					$engine->clear_cache_wanted_page($old_page['tag']);
				}

				$log->log_n_l_message = $engine->_t('NewNameOfPage') . $engine->link('/' . $new_tag);

				// log event
				$engine->log(3, Ut::perc_replace($engine->_t('LogRenamedPage', SYSTEM_LANG), $old_page['tag'], $new_tag) .
					($need_redirect? $engine->_t('LogRenamedPage2', SYSTEM_LANG) : '' ));
			}
		}
	}
}
