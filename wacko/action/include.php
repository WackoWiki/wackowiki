<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($page))			$page			= null;
if (!isset($page))			return;
if (!isset($nomark))		$nomark			= 0;
if (!isset($nowarning))		$nowarning		= 0;
if (!isset($revision_id))	$revision_id	= null;

$page = $this->unwrap_link($page);

if (!isset($first_anchor))	$first_anchor	= '';
if (!isset($last_anchor))	$last_anchor	= '';
if (!isset($track))			$track			= 0;

if ($track && $this->link_tracking())
{
	$this->track_link_to($page, LINK_PAGE);
}

if (in_array($page, $this->context))
{
	return;
}

if ($page == $this->tag)
{
	return;
}

$page_id = $this->get_page_id($page);

if (!$this->has_access('read', $page_id))
{
	if ($nowarning != 1) echo $this->_t('NoAccessToSourcePage');
}
else
{
	/*if (isset($_GET['revision_id']))
	{
		// ??? how this could construct a relation to the included pages?
		$revision_id = $_GET['revision_id'];
	}*/

	if (!$inc_page = $this->load_page($page, 0, $revision_id))
	{
		echo '<em> ' . $this->_t('SourcePageDoesntExist') . ' (' . $this->link('/' . $page) . ")</em>\n";
	}
	else
	{
		if ($inc_page['body_r'])
		{
			$strings = $inc_page['body_r'];
		}
		else
		{
			// recompile body
			// build html body
			$strings = $this->compile_body($inc_page['body'], null, false, false);
		}

		// cleaning up
		$strings = preg_replace('/<!--action:begin-->toc(.*?)<!--action:end-->/i', '', $strings);
		$strings = preg_replace('/<!--action:begin-->paragraphs<!--action:end-->/i', '', $strings);
		$strings = preg_replace('/<!--action:begin-->redirect<!--action:end-->/i', '', $strings);
		$strings = preg_replace("/.*<!--action:begin-->anchor name=\"?$first_anchor\"?<!--action:end-->(.*)<!--action:begin-->anchor name=\"?$last_anchor\"?<!--action:end-->.*$/is", "\$1", $strings);

		// header
		if (($this->method != 'print')
			&& ($nomark != 1)
			&& ($nomark != 2 || $this->has_access('write', $page_id)))
		{
			$edit_link = '<nav class="include-meta">' .

				// show page link
				$this->link('/' . $inc_page['tag']) .

				// show edit link
				($this->has_access('write', $page_id)
					? '&nbsp;&nbsp;::&nbsp;' .
					  '<a href="' . $this->href('edit', $inc_page['tag']) . '">' . $this->_t('EditIcon') . '</a>'
					: '') .

				"</nav>\n";

			echo "\n" . '<section class="include-page">' . "\n" . $edit_link;
		}

		// body
		$this->stop_link_tracking();
		$this->context[++$this->current_context] = $inc_page['tag'];

		echo $this->format($strings, 'post_wacko');

		$this->context[$this->current_context] = '~~'; // clean stack
		$this->current_context--;
		$this->start_link_tracking();

		// footer
		if (($this->method != 'print')
			&& ($nomark != 1)
			&& ($nomark != 2 || $this->has_access('write', $page_id)))
		{
			echo "\n" . $edit_link . "\n</section>\n";
		}
	}
}

?>
