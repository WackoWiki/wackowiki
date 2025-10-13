<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Creates a blog in the namespace of your choice.

Usage:
	{{blog}}

Options:
	[page="Cluster"]
	[mode="latest|week|from"]
	[date="YYYY-MM-DD"]
	[order="time|tag"]
	[max=Number]
	[title=1]
	[noxml=1]
EOD;

// set defaults
$help		??= 0;
$page		??= '/' . $this->tag;
$date		??= $_GET['date'] ?? '';

if ($help)
{
	$tpl->help	= $this->help($info, 'blog');
	return;
}

$tag		= $this->unwrap_link($page);
$error		= '';

if (!empty($tag))
{
	if (isset($_GET['category_id']))
	{
		$mode			= 'category';
		$category_id	= (int) $_GET['category_id'];
	}

	$max	??= 10;
	$order	??= '';
	$mode	??= 'latest';
	$title	??= 1;
	$noxml	??= 1;

	$pages				= [];
	$p_mode				= [];
	$prefix				= $this->prefix;
	$blog_levels		= '/.+'; // see $this->db->news_levels;
	$action				= $_POST['_action'] ?? null;

	if ($date && !$this->validate_date($date))
	{
		$date			= '';
	}

	$order_by = match($order) {
		'tag'		=> 'p.tag DESC',
		default		=> 'p.created DESC ',
	};

	// check privilege
	$access = $this->has_access('create');

	if ($action === 'add_topic' && $access)
	{
		// checking user input
		if (isset($_POST['title']))
		{
			$name		= utf8_trim($_POST['title'], ". \t");
			$namehead	= $name;
			$name		= utf8_ucwords($name);
			$this->sanitize_page_tag($name);
			$name		= preg_replace('/[^- \\w]/u', '', $name);
			$name		= str_replace([' ', "\t"], '', $name);

			if ($name == '')
			{
				$error = $this->_t('NewsNoName');
			}
		}
		else
		{
			$error = $this->_t('NewsNoName');
		}

		// if errors were found - return, else continue
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->http->redirect($this->href());
		}
		else
		{
			// building news template
			$template	= '';

			// redirecting to the edit form
			$this->sess->body	= $template;
			$this->sess->title	= $namehead;

			$this->http->redirect($this->href('edit', $tag . '/' . $name, '', 1));
		}
	}

	// collect data
	// heavy lifting here (watch out for REGEXPs!)
	$select_count =
		'SELECT COUNT(p.page_id) AS n ' .
		"FROM {$prefix}page p ";

	$select_mode =
		'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ' .
		"FROM {$prefix}page p " .
			"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ";

	$order_by_mode =
		'ORDER BY ' . $order_by . ' ';

	if ($mode == 'latest')
	{
		$p_mode = ['mode' => 'latest'];

		$selector =
			"WHERE p.tag REGEXP '^{$tag}{$blog_levels}$' " .
				'AND p.comment_on_id = 0 ' .
				'AND p.deleted <> 1 ';

		$sql_count	=
			$select_count .
			$selector;

		$sql_mode	=
			$select_mode .
			$selector .
			$order_by_mode;
	}
	else if ($mode == 'category')
	{
		$p_mode = ['category' => $category_id];

		$selector =
				"INNER JOIN {$prefix}category_assignment c ON (c.object_id = p.page_id) " .
			"WHERE p.tag REGEXP '^{$tag}{$blog_levels}$' " .
				'AND c.category_id = ' . (int) $category_id . ' ' .
				'AND c.object_type_id = 1 ' .
				'AND p.comment_on_id = 0 ' .
				'AND p.deleted <> 1 ';

		$sql_count	=
			$select_count .
			$selector;

		$sql_mode	=
			$select_mode .
			$selector .
			$order_by_mode;

		$category_title	= $this->db->load_single(
			'SELECT category ' .
			"FROM {$prefix}category " .
			'WHERE category_id = ' . (int) $category_id . ' ', false);
	}
	else if ($mode == 'week')
	{
		$p_mode = ['mode' => 'week'];

		$selector =
			"WHERE p.tag REGEXP '^{$tag}{$blog_levels}$' " .
				'AND p.created > ' . $this->db->date_sub(7, 'days') . ' ' .
				'AND p.comment_on_id = 0 ' .
				'AND p.deleted <> 1 ';

		$sql_count	=
			$select_count .
			$selector;

		$sql_mode	=
			$select_mode .
			$selector .
			$order_by_mode;
	}
	else if ($mode == 'from' && $date)
	{
		$p_mode = ['mode' => 'week'];
		$date	= $this->db->date($date);

		$selector =
			"WHERE p.tag REGEXP '^{$tag}{$blog_levels}$' " .
				'AND p.created > ' . $this->db->q($date) . ' ' .
				'AND p.comment_on_id = 0 ' .
				'AND p.deleted <> 1 ';

		$sql_count	=
			$select_count .
			$selector;

		$sql_mode	=
			$select_mode .
			$selector .
			$order_by_mode;
	}

	$count		= $this->db->load_single($sql_count, true);
	$pagination	= $this->pagination(($count['n'] ?? null), $max, 'p', $p_mode);
	$pages		= $this->db->load_all($sql_mode . $pagination['limit'], true);

	// start output

	if ($title == 1)
	{
		// hide article H1 header
		$this->hide_article_header = true;

		if (isset($category_title))
		{
			$_category_title	= ' ' . $this->_t('For') . ' ' . $this->_t('Category') . ' «' . $category_title['category'] . '»';
			$_title				= $this->compose_link_to_page($tag, '', $this->page['title']) . $_category_title;
		}
		else
		{
			$_category_title	= '';
			$_title				= $this->page['title'] . $_category_title;
		}

		$tpl->n_title = $_title;
	}

	// displaying XML icon
	if (!(int) $noxml)
	{
		$tpl->n_xml_href = $this->get_xml_file('news');
	}

	// displaying articles
	if ($pages)
	{
		// pagination
		$tpl->n_pagination_text = $pagination['text'];

		foreach ($pages as $page)
		{
			$page_ids[]	= $page['page_id'];
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		// cache acls
		$this->preload_acl($page_ids, ['read', 'write']);
		$this->preload_categories($page_ids);
		$this->preload_links($page_ids);

		$tpl->enter('n_l_');

		foreach ($pages as $page)
		{
			$_category		= $this->get_categories($page['page_id'], OBJECT_PAGE);
			$_category		= !empty($_category) ? $_category . ' | ' : '';

			$tpl->page		= $page;
			$tpl->href		= $this->href('', $page['tag'], '');
			$tpl->user		= $this->user_link($page['owner'], true, false);
			$tpl->include	= $this->action('include', ['page' => '/' . $page['tag'], 'notoc' => 0, 'nomark' => 1], true);
			$tpl->icon		= !empty($_category);
			$tpl->category	= $_category;
			$tpl->comments	= $this->href('', $page['tag'], ['show_comments' => 1]);

			// show edit link & button
			if ($this->has_access('write', $page['page_id']))
			{
				$tpl->edit		= $this->compose_link_to_page($page['tag'], 'edit', $this->_t('EditText')) . ' | ';
				$tpl->b_href	= $this->href('edit', $page['tag']);
			}

			unset ($_category);
		}

		$tpl->leave();
	}
	else
	{
		$tpl->n_nopages = true;
	}

	if ($access)
	{
		$tpl->n_access = true;
		$tpl->n_f_href = $this->href();
	}
}
else
{
	$tpl->nocluster = true;
}
