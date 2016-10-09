<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// NB to minimize amount of diff modes provided for user in menus - you
// can turn off some undesirables by setting text in lang/wacko.??.php
// files for unwanted DiffMode# to ''

if (!isset($_GET['a']) || !isset($_GET['b']) || !$this->page)
{
	$this->http->redirect($this->href());
}

$a			= (int)$_GET['a'];
$b			= (int)$_GET['b'];
$diffmode	= (int)@$_GET['diffmode'];

if ($a < 0) $a = 0;
if ($b < 0) $b = 0;

if ($a == $b)
{
	echo "<br />\n" . $this->_t('NoDifferences');
	return;
}

$load_diff_page = function ($id)
{
	// extracting
	if ($id > 0)
	{
		return $this->db->load_single(
			"SELECT r.page_id, r.revision_id, r.modified, r.body, r.page_lang, u.user_name ".
			"FROM ".$this->db->table_prefix."revision r ".
				"LEFT JOIN ".$this->db->table_prefix."user u ON (r.user_id = u.user_id) ".
			"WHERE r.revision_id = '".(int)$id."' ".
			"LIMIT 1");
	}
	else
	{
		return $this->db->load_single(
			"SELECT p.page_id, 0 AS revision_id, p.modified, p.body, p.page_lang, u.user_name ".
			"FROM ".$this->db->table_prefix."page p ".
				"LEFT JOIN ".$this->db->table_prefix."user u ON (p.user_id = u.user_id) ".
			"WHERE p.page_id = '".$this->get_page_id()."' ".
			"LIMIT 1");
	}
};

$page_a = $load_diff_page($b);
$page_b = $load_diff_page($a);

if ($page_a && $page_b && $this->page['page_id'] == $page_a['page_id'] &&
		$this->page['page_id'] == $page_b['page_id'] &&
		$this->has_access('read', $page_a['page_id']))
{
	$revisions = $this->load_revisions($this->page['page_id'], 1, $this->is_admin()); // TODO: $hide_minor_edit

	$revisions_menu = function ($rev, $page) use ($revisions, $diffmode, $a, $b)
	{
		$out = '<div class="diffdown">'; //<button class="diffbtn">';
		$out .= '<a href="' . $this->href('', '', ($page['revision_id'] > 0? 'revision_id=' . $page['revision_id'] : '')) . '">' .
			$this->get_time_formatted($page['modified']) .
			' <span class="dropdown_arrow">&#9660;</span></a>';
		//$out .= '</button><div class="diffdown-content">';
		$out .= '<div class="diffdown-content">';

		$out .= '<!--nomail-->';
		foreach ($revisions as $r)
		{
			$act = ($r['revision_id'] == $a || $r['revision_id'] == $b);
			if ($act)
			{
				$href = '#';
			}
			else
			{
				$params = ($a != $rev)? 'a=' . $r['revision_id'] . '&amp;b=' . $b : 'a=' . $a . '&amp;b=' . $r['revision_id'];
				$href = $this->href('diff', '', $params . '&amp;diffmode=' . $diffmode);
			}
			$out .= '<a href="' . $href . '">';
			$out .= '<span style="display: inline-block; width:40px;">' . $r['version_id'] . '.</span>';
			$out .= $this->get_time_formatted($r['modified']);
			$out .= '</a>';
		}
		$out .= '<!--/nomail-->';

		return $out . '</div></div>';
	};

	// print header
	echo Ut::perc_replace('<div class="diffinfo">' . $this->_t('Comparison'),
		$revisions_menu($a, $page_a),
		$revisions_menu($b, $page_b),
		//'<a href="' . $this->href('', '', ($a > 0 ? 'revision_id=' . $page_a['revision_id'] : '')) . '">' . $this->get_time_formatted($page_a['modified']) . '</a>',
		//'<a href="' . $this->href('', '', ($b > 0 ? 'revision_id=' . $page_b['revision_id'] : '')) . '">' . $this->get_time_formatted($page_b['modified']) . '</a>',
		$this->compose_link_to_page($this->tag, '', '', 0)) . "</div>\n";
	echo "<br />\n";

	echo "<br />\n";

	// print navigation
	echo '<!--nomail-->'.
		'<ul class="menu">';

	$params = 'a=' .$a . '&amp;b=' .$b . '&amp;diffmode=';
	for ($mode = 0; ($text = $this->_t('DiffMode' . $mode)) !== null; ++$mode)
	{
		if ($text)
		{
			echo ($diffmode != $mode
				?	'<li><a href="' . $this->href('diff', '', $params . $mode) . '">' . $text . '</a>'
				:	'<li class="active">' . $text) . '</li>';
		}
	}

	echo '</ul>'.
		'<!--/nomail-->';

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
			echo "<br />\n" . '<strong>' . $this->_t('SimpleDiffAdditions') . '</strong>' . "<br />\n\n";
			echo '<div class="additions">';
			echo $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $added), ENT_COMPAT | ENT_HTML401, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $added), 'wiki', ['diff' => true]);
			echo "</div>\n";
		}

		if ($deleted)
		{
			echo "<br />\n\n" . '<strong>' . $this->_t('SimpleDiffDeletions') . '</strong>' . "<br />\n\n";
			echo '<div class="deletions">';
			echo $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $deleted), ENT_COMPAT | ENT_HTML401, $charset), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $deleted), 'wiki', ['diff' => true]);
			echo "</div>\n";
		}

		if (!$added && !$deleted)
		{
			echo "<br />\n" . $this->_t('NoDifferences');
		}
		break;

	case 0:
		require_once Ut::join_path(HANDLER_DIR, 'page/_diff.php');
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

		echo '<br /><br />';
		echo $this->format($output, 'wiki', ['diff' => true]);
		break;

	case 3:
	case 4:
	case 5:
	case 6:
		$this->add_html_head('<link rel="stylesheet" href="' . $this->db->theme_url . 'css/diff.css" type="text/css"/>'); // STS

		// using nice lib/php-diff library..
		$diff = new Diff(explode("\n", $page_a['body']), explode("\n", $page_b['body']));

		echo '<br /><br />';

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
			echo htmlspecialchars($diff->render($renderer), ENT_NOQUOTES | ENT_HTML401, HTML_ENTITIES_CHARSET);
			echo '</pre>';
		}
		break;
	}
}
else
{
	$this->show_message($this->_t('ReadAccessDenied'), 'info');
}

$this->add_html_head('
<style>
.diffbtn {
    #background-color: #4CAF50;
    #color: white;
    padding: 2px 6px;
    font-size: 12px;
    border: none;
    cursor: pointer;
}

.diffdown {
    position: relative;
    display: inline-block;
}

.diffdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.diffdown-content a {
    color: black;
    padding: 2px 6px;
    text-decoration: none;
    display: block;
}

.diffdown-content a:hover {background-color: #f1f1f1}

.diffdown:hover .diffdown-content {
    display: block;
}

.diffdown:hover .diffbtn {
    #background-color: #3e8e41;
}
</style>
');

