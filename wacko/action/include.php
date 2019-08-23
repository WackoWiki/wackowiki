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
	$this->track_link($page, LINK_PAGE);
}

// prevent include loop!
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
	if ($nowarning != 1)
	{
		$tpl->forbidden = true;
	}
}
else
{
	if (!$inc_page = $this->load_page($page, 0, $revision_id))
	{
		$tpl->none_link = $this->link('/' . $page);
	}
	else
	{
		if (!empty($inc_page['body_r']))
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
		$strings = preg_replace('/<!--action:begin-->paragraphs(.*?)<!--action:end-->/i', '', $strings);
		$strings = preg_replace('/<!--action:begin-->redirect(.*?)<!--action:end-->/i', '', $strings);
		$strings = preg_replace("/.*<!--action:begin-->anchor name=\"?$first_anchor\"?<!--action:end-->(.*)<!--action:begin-->anchor name=\"?$last_anchor\"?<!--action:end-->.*$/is", "\$1", $strings);

		// header
		if (($this->method != 'print')
			&& ($nomark != 1)
			&& ($nomark != 2 || $this->has_access('write', $page_id)))
		{
			$tpl->mark		= true;
			$tpl->emark		= true;

			// show page link
			$tpl->nav_link = $this->link('/' . $inc_page['tag']);

			// show edit link
			if ($this->has_access('write', $page_id))
			{
				$tpl->nav_edit_href = $this->href('edit', $inc_page['tag']);
			}
		}

		// body
		$this->stop_link_tracking();
		$this->context[++$this->current_context] = $inc_page['tag'];

		$tpl->data = $this->format($strings, 'post_wacko');

		$this->context[$this->current_context] = '~~'; // clean stack
		$this->current_context--;
		$this->start_link_tracking();
	}
}

