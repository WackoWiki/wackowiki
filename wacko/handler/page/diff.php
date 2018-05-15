<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// NB to minimize amount of diff modes provided for user in menus - you
// can turn off some undesirables by setting diff_modes in secondary config

/*
 * DiffMode
 *	0	Full diff
 *	1	Simple diff
 *	2	Source			(text/plain)
 *	3	Side by side
 *	4	Inline
 *	5	Unified			(text/plain)
 *	6	Context			(text/plain)
 *
 * default setting
 *	page/revisions.xml	=> 2
 *	notify_watcher()	=> 2 (source -> text/plain)
 *
 * TODO: make diff modes acceccible via config
 * - to change mode for cases above
 * add navigation to move to next of previous diff
 * add revision meta headers
*/

if (!isset($_GET['a']) || !isset($_GET['b']) || !$this->page)
{
	$this->http->redirect($this->href());
}

$a					= (int) $_GET['a'];
$b					= (int) $_GET['b'];
$diffmode			= (int) @$_GET['diffmode'];
$hide_minor_edit	= (int) @$_GET['minor_edit'];

if ($a < 0) $a = 0;
if ($b < 0) $b = 0;

if ($a == $b)
{
	echo "<br>\n" . $this->_t('NoDifferences');
	return;
}

$load_diff_page = function ($revision_id)
{
	// extracting
	if ($revision_id > 0)
	{
		return $this->db->load_single(
			"SELECT r.page_id, r.revision_id, r.modified, r.body, r.page_lang, u.user_name " .
			"FROM " . $this->db->table_prefix . "revision r " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (r.user_id = u.user_id) " .
			"WHERE r.revision_id = " . (int) $revision_id . " " .
			"LIMIT 1");
	}
	else
	{
		return $this->db->load_single(
			"SELECT p.page_id, 0 AS revision_id, p.modified, p.body, p.page_lang, u.user_name " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"WHERE p.page_id = " . (int) $this->get_page_id() . " " .
			"LIMIT 1");
	}
};

$page_a = $load_diff_page($b);
$page_b = $load_diff_page($a);

if ($page_a && $page_b
	&& $this->page['page_id'] == $page_a['page_id']
	&& $this->page['page_id'] == $page_b['page_id']
	&& $this->has_access('read', $page_a['page_id']))
{
	// TODO: $hide_minor_edit
	list ($revisions, $pagination) = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $this->is_admin());

	$revisions_menu = function ($rev, $page) use ($revisions, $diffmode, $a, $b)
	{
		$out = '<div class="diffdown">' . "\n"; //<button class="diffbtn">';
		$out .= '<a href="' . $this->href('', '', ($page['revision_id'] > 0? ['revision_id' => $page['revision_id']] : '')) . '">' .
				$this->get_time_formatted($page['modified']) .
				' <span class="dropdown_arrow">&#9660;</span></a>' . "\n";
		//$out .= '</button><div class="diffdown-content">';
		$out .= '<div class="diffdown-content">' . "\n";

		foreach ($revisions as $r)
		{
			$act = ($r['revision_id'] == $a || $r['revision_id'] == $b);

			if ($act)
			{
				$href = '#';
			}
			else
			{
				$params	= ($a != $rev)
							? ['a' => $r['revision_id'],	'b' => $b]
							: ['a' => $a,					'b' => $r['revision_id']];
				$href	= $this->href('diff', '', $params + ['diffmode' => $diffmode]);
			}

			$out .= '<a href="' . $href . '">';
			$out .= '<span>' . $r['version_id'] . '.</span>';
			$out .= $this->get_time_formatted($r['modified']);
			$out .= '</a>' . "\n";
		}

		return $out . '</div></div>' . "\n";
	};

	// print header
	echo "<!--nomail-->\n";
	echo Ut::perc_replace('<div class="diffinfo">' . $this->_t('Comparison'),
		$revisions_menu($a, $page_a),
		$revisions_menu($b, $page_b),
		//'<a href="' . $this->href('', '', ($a > 0 ? ['revision_id' => $page_a['revision_id']] : '')) . '">' . $this->get_time_formatted($page_a['modified']) . '</a>',
		//'<a href="' . $this->href('', '', ($b > 0 ? ['revision_id' => $page_b['revision_id']] : '')) . '">' . $this->get_time_formatted($page_b['modified']) . '</a>',
		$this->compose_link_to_page($this->tag, '', '')) . "</div>\n";
	echo "<br>\n<br>\n";

	// print navigation
	echo '<ul class="menu">';

	$params = ['a' => $a, 'b' => $b];

	$diff_modes		= $this->_t('DiffMode');
	$diff_mode_list	= explode(',', $this->db->diff_modes);

	foreach($diff_mode_list as $mode)
	{
		echo ($diffmode != $mode
			? '<li><a href="' . $this->href('diff', '', $params + ['diffmode' => $mode]) . '">' . $diff_modes[$mode] . '</a>'
			: '<li class="active">' . $diff_modes[$mode]) . '</li>';
	}

	echo "</ul>\n" .
		"<!--/nomail-->\n";

	// do diffs
	switch ($diffmode)
	{
	case 1:
	case 2:
		$source = ($diffmode == 2);

		// This is a really cheap way to do it.
		// prepare bodies
		$body_a		= explode("\n", $page_b['body']);
		$body_b		= explode("\n", $page_a['body']);

		$added		= array_diff($body_a, $body_b);
		$deleted	= array_diff($body_b, $body_a);
		$charset	= $this->get_charset($page_a['page_lang']);

		if ($added)
		{
			// remove blank lines
			echo "<br>\n" . '<strong>' . $this->_t('SimpleDiffAdditions') . '</strong>' . "<br>\n\n";
			echo '<div class="additions">';
			echo $source
					? '<pre>' . wordwrap(Ut::html(implode("\n", $added), true, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $added), 'wiki', ['diff' => true]);
			echo "</div>\n";
		}

		if ($deleted)
		{
			echo "<br>\n\n" . '<strong>' . $this->_t('SimpleDiffDeletions') . '</strong>' . "<br>\n\n";
			echo '<div class="deletions">';
			echo $source
					? '<pre>' . wordwrap(Ut::html(implode("\n", $deleted), true, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $deleted), 'wiki', ['diff' => true]);
			echo "</div>\n";
		}

		if (!$added && !$deleted)
		{
			echo "<br>\n" . $this->_t('NoDifferences');
		}

		break;

	case 0:
		require_once 'lib/diff/diff.php';
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

		echo '<br><br>';
		echo $this->format($output, 'wiki', ['diff' => true]);
		break;

	case 3:
	case 4:
	case 5:
	case 6:
		$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->theme_url . 'css/diff.css">'); // STS

		// using nice lib/php-diff library..
		$diff = new Diff(explode("\n", $page_a['body']), explode("\n", $page_b['body']));

		echo '<br><br>';

		if (!$diff->getGroupedOpcodes())
		{
			echo $this->_t('NoDifferences');
			break;
		}

		if ($diffmode == 3)
		{
			$renderer = new Diff_Renderer_Html_SideBySide;
			$renderer->thead = '';
			echo $diff->Render($renderer);
		}
		else if ($diffmode == 4)
		{
			$renderer = new Diff_Renderer_Html_Inline;
			$renderer->thead = '';
			echo $diff->render($renderer);
		}
		else
		{
			if ($diffmode == 5)
			{
				// standard unified diff, useful for sending in emails or what
				$renderer = new Diff_Renderer_Text_Unified;
			}
			else
			{
				$renderer = new Diff_Renderer_Text_Context;
			}

			echo '<pre>';
			echo Ut::html($diff->render($renderer), ENT_NOQUOTES | ENT_HTML5, HTML_ENTITIES_CHARSET);
			echo '</pre>';
		}

		break;
	}
}
else
{
	$this->show_message($this->_t('ReadAccessDenied'), 'info');
}
