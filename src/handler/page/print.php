<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page();

if (!$this->has_access('read'))
{
	// redirect to show handler
	$this->show_must_go_on();
}

if (!$this->page['latest'])
{
	$tpl->rev_text = Ut::perc_replace($this->_t('RevisionHint'),
		$this->href(),
		$this->tag,
		$this->sql_time_formatted($this->page['modified']),
		$this->user_link($this->page['user_name'], true, false));
}

if (($user = $this->get_user())? $user['numerate_links'] : $this->db->numerate_links)
{
	// start enumerating links
	$this->numerate_links = [];
}

// set absolute URL
$this->canonical = true;

// build html body
$data = $this->format($this->page['body'], 'wiki', ['post_wacko' => true]);

// display page
$tpl->body	= $this->numerate_toc($data); //  numerate toc if needed
#$this->current_context--;

// display page title (action & theme wacko.all options)
if (!$this->hide_article_header)
{
	$tpl->h_title	= $this->page['title'];
}

// display comments
if (@$this->sess->show_comments[$this->page['page_id']] || $this->forum)
{
	$tpl->enter('c_cmt_');

	foreach ($this->load_comments($this->page['page_id']) as $comment)
	{
		if (!$comment['body_r'])
		{
			$comment['body_r'] = $this->format($comment['body']);
		}

		$tpl->user		= $this->user_link($comment['user_name']);
		$tpl->created	= $comment['created'];
		$comment['modified'] == $comment['created'] || $tpl->edit_time = $comment['modified'];
		$tpl->body		= $this->format($comment['body_r'], 'post_wacko');
	}

	$tpl->leave();
}

$this->canonical = false;

// numerated links
if ($this->numerate_links)
{
	$tpl->enter('n_link_');

	foreach ($this->numerate_links as $l => $n)
	{
		$tpl->n = $n;
		$tpl->l = $l;
	}

	$tpl->leave();
}
