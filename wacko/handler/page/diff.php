<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Import the PHPDiff class into the global namespace
use PHPDiff\ {
	Diff,
	Diff\Renderer\Html\Inline,
	Diff\Renderer\Html\SideBySide,
	Diff\Renderer\Text\Context,
	Diff\Renderer\Text\Unified,
};

/*
 * DiffMode
 *	0	Full diff			(rendered/html)		diff library
 *	1	Simple diff			(rendered/html)		array_diff()
 *	2	Source				(text/plain)		...
 *	3	Side by side		(text/html)			php-diff library
 *	4	Inline				(text/html)			...
 *	5	Unified				(text/plain)		...
 *	6	Context				(text/plain)		...
 *
 * default setting
 *	page/revisions.xml		=> 2
 *	notify_watcher()		=> 2 (source -> text/plain)
 *
 * config settings
 *	db->diff_modes			sets the available diff modes for the user in secondary config
 *	db->notify_diff_mode	sets diff mode for email notifications
 *
*/

if (!isset($_GET['a']) || !isset($_GET['b']) || !$this->page || $this->hide_revisions)
{
	$this->http->redirect($this->href());
}

$a					= (int) $_GET['a'];
$b					= (int) $_GET['b'];
$diffmode			= (int) @$_GET['diffmode'];
$notification		= (int) ($_GET['notification'] ?? 0);
$hide_minor_edit	= (int) @$_GET['minor_edit'];

if ($a < 0) $a = 0;
if ($b < 0) $b = 0;

if ($a == $b)
{
	$tpl->nodiff = true;
	return;
}

$load_diff_page = function ($revision_id)
{
	// extracting
	if ($revision_id > 0)
	{
		return $this->db->load_single(
			"SELECT r.page_id, r.version_id, r.revision_id, r.modified, r.body, r.edit_note, r.minor_edit, r.page_lang, u.user_name " .
			"FROM " . $this->db->table_prefix . "revision r " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (r.user_id = u.user_id) " .
			"WHERE r.revision_id = " . (int) $revision_id . " " .
			"LIMIT 1");
	}
	else
	{
		return $this->db->load_single(
			"SELECT p.page_id, p.version_id, 0 AS revision_id, p.modified, p.body, p.edit_note, p.minor_edit, p.page_lang, u.user_name " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"WHERE p.page_id = " . (int) $this->get_page_id() . " " .
			"LIMIT 1");
	}
};

$page_a = $load_diff_page($a);
$page_b = $load_diff_page($b);

if ($page_a && $page_b
	&& $this->page['page_id'] == $page_a['page_id']
	&& $this->page['page_id'] == $page_b['page_id']
	&& $this->has_access('read', $page_a['page_id']))
{
	if ($notification == 0)
	{
		$tpl->enter('nav_');
		// TODO: $hide_minor_edit
		[$revisions, $pagination] = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $this->is_admin());

		$revisions_menu = function ($rev, $page, $side) use ($revisions, $diffmode, $page_a, $page_b, &$tpl)
		{
			$tpl->enter($side . '_');

			$tpl->href		= $this->href('', '', ($page['revision_id'] > 0? ['revision_id' => $page['revision_id']] : ''));
			$tpl->version	= Ut::perc_replace($this->_t('RevisionAsOf'), '<strong>' . $page['version_id'] . '</strong>');
			$tpl->modified	= $page['modified'];
			$tpl->username	= $this->user_link($page['user_name'], '', true, true);
			$tpl->n_note	= $page['edit_note'] ?: null;
			$tpl->m_minor	= $page['minor_edit'] ? 'm' : null;

			// previous & next diff navigation
			$revision_id	= ($side == 'a' ? $page_a['revision_id'] : $page_b['revision_id']);
			$key			= array_search($revision_id, array_column($revisions, 'revision_id'));

			if ($side == 'a' && array_key_exists($key + 1, $revisions))
			{
				$tpl->prev_href	= $this->href('diff', '', ['a' => $revisions[$key + 1]['revision_id'], 'b' => $page_a['revision_id'], 'diffmode' => $diffmode]);
			}
			else if ($side == 'b' && array_key_exists($key - 1, $revisions))
			{
				$tpl->next_href	= $this->href('diff', '', ['a' => $page_b['revision_id'], 'b' => $revisions[$key - 1]['revision_id'], 'diffmode' => $diffmode]);
			}

			// dropdown navigation
			$tpl->enter('r_');

			foreach ($revisions as $r)
			{
				if (   ($side == 'a' && $r['revision_id'] == $page_a['revision_id'])
					|| ($side == 'b' && $r['revision_id'] == $page_b['revision_id']))
				{
					$href	= '#';
					$class	= ' class="active"';
				}
				else if (  ($side == 'a' && $r['version_id'] >= $page_b['version_id'])
						|| ($side == 'b' && $r['version_id'] <= $page_a['version_id']))
				{
					// skip all revisions out of a -> b scope
					continue;
				}
				else
				{
					$params	= ($page_a['revision_id'] != $rev)
						? ['a' => $page_a['revision_id'],	'b' => $r['revision_id']]
						: ['a' => $r['revision_id'],		'b' => $page_b['revision_id']];
					$href	= $this->href('diff', '', $params + ['diffmode' => $diffmode]);
					$class	= '';
				}

				$tpl->href		= $href;
				$tpl->class		= $class;
				$tpl->version	= $r['version_id'];
				$tpl->modified	= $r['modified'];
				$tpl->username	= $r['user_name'];
				$tpl->editnote	= $r['edit_note'] ?: null;
			}

			$tpl->leave();	// r_
			$tpl->leave();	// side_
		};

		// print header
		$tpl->head = Ut::perc_replace($this->_t('Comparison'), $this->compose_link_to_page($this->tag, '', ''));

		$revisions_menu($a, $page_a, 'a');
		$revisions_menu($b, $page_b, 'b');

		$params = ['a' => $a, 'b' => $b];

		$diff_modes		= $this->_t('DiffMode');
		$diff_mode_list	= explode(',', $this->db->diff_modes);

		foreach($diff_mode_list as $mode)
		{
			$tpl->l_diffmode =
				($diffmode != $mode
					? '<li><a href="' . $this->href('diff', '', $params + ['diffmode' => $mode]) . '">' . $diff_modes[$mode] . '</a>'
					: '<li class="active">' . $diff_modes[$mode]) . '</li>';
		}

		$tpl->leave();	// nav
	}

	$tpl->enter('diff_');

	// do diffs
	switch ($diffmode)
	{
		case 1:
		case 2:
			$source = ($diffmode == 2);

			// This is a really cheap way to do it.
			// prepare bodies
			$body_a		= explode("\n", $page_a['body']);
			$body_b		= explode("\n", $page_b['body']);

			$added		= array_diff($body_b, $body_a);
			$deleted	= array_diff($body_a, $body_b);

			$tpl->enter('m2_');

			if ($added)
			{
				$notification
					? $tpl->added_email		= true
					: $tpl->added_browser	= true;
				$tpl->added_diff = $source
					? '<pre>' . utf8_wordwrap(Ut::html(implode("\n", $added)), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $added), 'wiki', ['diff' => true]);
			}

			if ($deleted)
			{
				$notification
					? $tpl->deleted_email	= true
					: $tpl->deleted_browser	= true;
				$tpl->deleted_diff  = $source
					? '<pre>' . utf8_wordwrap(Ut::html(implode("\n", $deleted)), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $deleted), 'wiki', ['diff' => true]);
			}

			if (!$added && !$deleted)
			{
				$tpl->nodiff = true;
			}

			$tpl->leave();

			break;

		case 0:
			// load pages

			// extract text from bodies
			$text_a		= $page_a['body'];
			$text_b		= $page_b['body'];

			$side_a		= new Side($text_a);
			$side_b		= new Side($text_b);

			$body_a		= '';
			$side_a->split_file_into_words($body_a);

			$body_b		= '';
			$side_b->split_file_into_words($body_b);

			// diff on these two file
			$diff		= new Diff2(explode("\n", $body_a), explode("\n", $body_b));

			// format output
			$fmt		= new DiffFormatter();

			$side_o		= new Side($fmt->format($diff));

			$resync_left	= 0;
			$resync_right	= 0;

			$count_total_right = $side_b->getposition();

			$side_a->init();
			$side_b->init();

			while (1)
			{
				$side_o->skip_line();

				if ($side_o->isend())
				{
					break;
				}

				if ($side_o->decode_directive_line())
				{
					$argument	= $side_o->getargument();
					$letter		= $side_o->getdirective();

					switch ($letter)
					{
						case 'a':
							$resync_left	= $argument[0];
							$resync_right	= $argument[2] - 1;
							break;

						case 'd':
							$resync_left	= $argument[0] - 1;
							$resync_right	= $argument[2];
							break;

						case 'c':
							$resync_left	= $argument[0] - 1;
							$resync_right	= $argument[2] - 1;
							break;
					}

					$side_a->skip_until_ordinal($resync_left);
					$side_b->copy_until_ordinal($resync_right, $output);

					if ($letter == 'd' || $letter == 'c')
					{
						// deleted word
						$side_a->copy_whitespace($output);
						$output .= '<!--markup:1:begin-->';
						$side_a->copy_word($output);
						$side_a->copy_until_ordinal($argument[1], $output);
						$output .= '<!--markup:1:end-->';
					}

					if ($letter == 'a' || $letter == 'c')
					{
						// inserted word
						$side_b->copy_whitespace($output);
						$output .= '<!--markup:2:begin-->';
						$side_b->copy_word($output);
						$side_b->copy_until_ordinal($argument[3], $output);
						$output .= '<!--markup:2:end-->';
					}
				}
			}

			$side_b->copy_until_ordinal($count_total_right, $output);
			$side_b->copy_whitespace($output);

			$tpl->m0_diff = $this->format($output, 'wiki', ['diff' => true]);
			break;

		case 3:
		case 4:
		case 5:
		case 6:
			$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->theme_url . 'css/diff.css">'); // STS

			// using nice lib/php-diff library..
			$diff = new Diff(explode("\n", $page_a['body']), explode("\n", $page_b['body']));

			if (!$diff->getGroupedOpcodes())
			{
				$tpl->m6_nodiff = true;
				break;
			}

			if ($diffmode == 3)
			{
				$renderer = new SideBySide;
				$renderer->thead = '';
				$tpl->m6_diff = $diff->Render($renderer);
			}
			else if ($diffmode == 4)
			{
				$renderer = new Inline;
				$renderer->thead = '';
				$tpl->m6_diff = $diff->render($renderer);
			}
			else
			{
				if ($diffmode == 5)
				{
					// standard unified diff, useful for sending in emails or what
					$renderer = new Unified;
				}
				else
				{
					$renderer = new Context;
				}

				$tpl->m6_diff =
					'<pre>' .
						htmlspecialchars($diff->render($renderer), ENT_NOQUOTES | ENT_HTML5, HTML_ENTITIES_CHARSET) .
					'</pre>';
			}

			break;
	}

	$tpl->leave();
}
else
{
	$this->http->status(403);

	$tpl->denied = $this->show_message($this->_t('ReadAccessDenied'), 'note', false);
}
