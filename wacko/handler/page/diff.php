<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<div id="page">';
$include_tail = '</div>';

if (!isset($_GET['a']) || !isset($_GET['b']) || !isset($_GET['diffmode']))
{
	$this->redirect($this->href());
}

$a			= (int)$_GET['a'];
$b			= (int)$_GET['b'];
$diff_mode	= $_GET['diffmode'];

$load_diff_page = function ($id)
{
	// extracting
	if ($id > 0)
	{
		return $this->load_single(
			"SELECT r.page_id, r.revision_id, r.modified, r.body, u.user_name ".
			"FROM ".$this->config['table_prefix']."revision r ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (r.user_id = u.user_id) ".
			"WHERE r.revision_id = '".(int)$id."' ".
			"LIMIT 1");
	}
	else
	{
		return $this->load_single(
			"SELECT p.page_id, 0 AS revision_id, p.modified, p.body, u.user_name ".
			"FROM ".$this->config['table_prefix']."page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"WHERE p.page_id = '".$this->get_page_id()."' ".
			"LIMIT 1");
	}
};

$page_a = $load_diff_page($b); // STS: why page_a <- b ?!
$page_b = $load_diff_page($a);

if ($this->has_access('read', $page_a['page_id']) && $this->has_access('read', $page_b['page_id']) )
{
	// diffmode
	// 0 - full diff
	// 1 - simple diff
	// 2 - source diff

	// print header
	echo perc_replace('<div class="diffinfo">' . $this->get_translation('Comparison'),
		'<a href="' . $this->href('', '', ($b > 0 ? 'revision_id=' . $page_a['revision_id'] : '')) . '">' . $this->get_time_formatted($page_a['modified']) . '</a>',
		'<a href="' . $this->href('', '', ($a > 0 ? 'revision_id=' . $page_b['revision_id'] : '')) . '">' . $this->get_time_formatted($page_b['modified']) . '</a>',
		$this->compose_link_to_page($this->tag, '', '', 0)) . "</div>\n";

	// print navigation
	$params = 'a=' .$a . '&amp;b=' .$b . '&amp;diffmode=';
	echo '<!--nomail-->'.
	'<ul class="menu">'.
		($diff_mode != 0
			?	'<li><a href="' . $this->href('diff', '', $params . '0') . '">' . $this->get_translation('FullDiff') . '</a>'
			:	'<li class="active">' . $this->get_translation('FullDiff')) . '</li>'.
		($diff_mode != 1
			?	'<li><a href="' . $this->href('diff', '', $params . '1') . '">' . $this->get_translation('SimpleDiff') . '</a>'
			:	'<li class="active">' . $this->get_translation('SimpleDiff')) . '</li>'.
		($diff_mode != 2
			?	'<li><a href="' . $this->href('diff', '', $params . '2') . '">' . $this->get_translation('SourceDiff') . '</a>'
			:	'<li class="active">' . $this->get_translation('SourceDiff')) . '</li>'.
	'</ul>'.
	'<!--/nomail-->';

	$output = '';
	if ($diff_mode >= 1)
	{
		$source = ($diff_mode == 2);

		// This is a really cheap way to do it.
		// prepare bodies
		$body_a		= explode("\n", $page_b['body']);
		$body_b		= explode("\n", $page_a['body']);

		$added		= array_diff($body_a, $body_b);
		$deleted	= array_diff($body_b, $body_a);

		if ($added)
		{
			// remove blank lines
			$output .= "<br />\n" . $this->get_translation('SimpleDiffAdditions') . "<br />\n\n";
			$output .= '<div class="additions">';
			$output .= $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $added), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $added), 'wiki', array('diff' => true));
			$output .= "</div>\n";
		}

		if ($deleted)
		{
			$output .= "<br />\n\n" . $this->get_translation('SimpleDiffDeletions') . "<br />\n\n";
			$output .= '<div class="deletions">';
			$output .= $source
					? '<pre>' . wordwrap(htmlentities(implode("\n", $deleted), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET), 70, "\n", 1) . '</pre>'
					: $this->format(implode("\n", $deleted), 'wiki', array('diff' => true));
			$output .= "</div>\n";
		}

		if (!$added && !$deleted)
		{
			$output .= "<br />\n" . $this->get_translation('NoDifferences');
		}

		echo $output;
	}
	else
	{
		require_once($this->config['handler_path'] . '/page/_diff.php');
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
		$diff		= new Diff(explode("\n", $body_a), explode("\n", $body_b));

		// format output
		$fmt = new DiffFormatter();

		$side_o = new Side($fmt->format($diff));

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
		echo $this->format($output, 'wiki', array('diff' => true));
	}
}
else
{
	$this->show_message($this->get_translation('ReadAccessDenied'), 'info');
}
