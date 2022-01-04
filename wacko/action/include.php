<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* USAGE:
	{{include
		[page="cluster"]
		[nomark=1]
		[notoc=1]
		[nowarning=1]
		[first_anchor="anchor1"]
		[last_anchor="anchor2"]
	}}
*/

if (!isset($page))			return;

// set defaults
$nomark			??= 0;
$nowarning		??= 0;
$revision_id	??= null;
$first_anchor	??= '';
$last_anchor	??= '';
$track			??= 0;

// notoc=1 gets processed via regex in Paragrafica class

$tag = $this->unwrap_link($page);

if ($track && $this->link_tracking())
{
	$this->track_link($tag, LINK_PAGE);
}

// prevent include loop!
if (in_array($tag, $this->context))
{
	return;
}

if ($tag == $this->tag)
{
	return;
}

$page_id = $this->get_page_id($tag);

if (!$this->has_access('read', $page_id))
{
	if ($nowarning != 1)
	{
		$tpl->forbidden = true;
	}
}
else
{
	if (!$inc_page = $this->load_page($tag, 0, $revision_id))
	{
		$tpl->none_link = $this->link('/' . $tag);
	}
	else
	{
		if (!empty($inc_page['body_r']))
		{
			$body = $inc_page['body_r'];
		}
		else
		{
			// recompile body, build HTML body
			$body = $this->compile_body($inc_page['body'], null, false, false);
		}

		// cleaning up
		$body = preg_replace('/<!--action:begin-->toc(.*?)<!--action:end-->/ui', '', $body);
		$body = preg_replace('/<!--action:begin-->paragraphs(.*?)<!--action:end-->/ui', '', $body);
		$body = preg_replace('/<!--action:begin-->redirect(.*?)<!--action:end-->/ui', '', $body);
		$body = preg_replace("/.*<!--action:begin-->anchor name=\"?$first_anchor\"?<!--action:end-->(.*)<!--action:begin-->anchor name=\"?$last_anchor\"?<!--action:end-->.*$/uis", "\$1", $body);

		// header
		if (($this->method != 'print')
			&& ($nomark != 1)
			&& ($nomark != 2 || $this->has_access('write', $page_id)))
		{
			$tpl->mark		= true;

			if ($this->page['page_lang'] != $inc_page['page_lang'])
			{
				$tpl->mark_lang	= ' lang="' . $inc_page['page_lang'] . '"';
				$tpl->mark_dir	= ' dir="' . $this->get_direction($inc_page['page_lang']) . '"';
			}

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

		$tpl->data = $this->format($body, 'post_wacko');

		$this->context[$this->current_context] = '~~'; // clean stack
		$this->current_context--;
		$this->start_link_tracking();
	}
}