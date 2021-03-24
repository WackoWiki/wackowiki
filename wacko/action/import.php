<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{import}}
	http://example.com/somecluster/import --> {{import}}, to = "Test" .
	Will be imported at: http://example.com/Test/*

	i.e. no relative addressing
*/

// TODO:
//	add a step for warning / confirmation (do you want overwrite? / Will add Import under ... [submit] [cancel])
//	add better description

if ($this->is_admin())
{
	// show FORM
	if (!isset($_POST['_to']) || empty($_POST['_to']))
	{
		if (isset($_POST['_to']))
		{
			$tpl->f_hint = $this->_t('ImportHint');
		}
		else
		{
			$tpl->f_hint = $this->_t('ImportAttention');
		}
	}

	if (!empty($_POST['_to']))
	{
		if ($_FILES['_import']['error'] == 0)
		{
			$fd = fopen($_FILES['_import']['tmp_name'], 'r');

			if (!$fd)
			{
				echo '<pre>';
				print_r($_FILES);
				print_r($_POST);
				die('</pre><br>'. $this->_t('ImportFailed'));
			}

			// check for false and empty strings
			if (($contents = fread($fd, filesize($_FILES['_import']['tmp_name']))) === '')
			{
				return false;
			}

			fclose($fd);

			$items = explode('<item>', $contents);

			array_shift($items);

			if ($items)
			{
				$sanitize_tag = function ($tag)
				{
					$this->sanitize_page_tag($tag);

					return utf8_trim($tag, '/ ');
				};

				$root_tag	= $sanitize_tag($_POST['_to']);
				$t			= 0;

				foreach ($items as $item)
				{
					// get data
					$rel_tag	= $sanitize_tag(Ut::untag($item, 'guid'));
					$tag		= $root_tag . ($root_tag && $rel_tag ? '/' : '') . $rel_tag;

					$body		= str_replace(']]&gt;', ']]>', Ut::untag($item, 'description'));
					$title		= html_entity_decode(Ut::untag($item, 'title'), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

					// save imported page
					$body_r		= $this->save_page($tag, $body, $title);
					$page_id	= $this->get_page_id($tag);

					// now we render it internally in the context of imported
					// page so we can write the updated link table
					$this->context[++$this->current_context] = $tag;
					$this->update_link_table($page_id, $body_r);
					$this->current_context--;

					// summary link
					$tpl->i_l_page = $this->link('/' . $tag, '', '', '', 0);

					// log import
					$this->log(4, Ut::perc_replace($this->_t('LogPageImported', SYSTEM_LANG), $tag));

					// count page
					$t++;
				}

				$tpl->i_message = Ut::perc_replace($this->_t('ImportSuccess'), $t);
			}
		}
		else
		{
			echo '<pre>';
			print_r($_FILES);
			print_r($_POST);
			die('</pre><br>'. $this->_t('ImportFailed'));
		}
	}
}
