<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page(true); // allow forums

$show_backlinks = function () use (&$tpl)
{
	$tpl->b_links = $this->action('backlinks', ['nomark' => 1]);
};

// fast lane: show backlinks for those who don't deserve further service ;)
// enable_referrers == 1 for all logged-in users, == 2 for admins only
if (
	(   $this->db->enable_referrers == 0)
	|| ($this->db->enable_referrers == 1 && !$this->get_user())
	|| ($this->db->enable_referrers == 2 && !$this->is_admin()))
{
	$show_backlinks();
	return;
}

// set up for main show
$url_maxlen		= 80;
$mod_selector	= 'o';
$modes			= [
					''			=> 'ViewReferrersPage',
					'perpage'	=> 'ViewReferrersPerPage',
					'bytime'	=> 'ViewReferrersByTime',
					'global'	=> 'ViewReferrersGlobal'
				];
$mode			= @$_GET[$mod_selector];

if (!array_key_exists($mode, $modes))
{
	$mode = '';
}

// set up for main show
$purge_time = (($t = $this->db->referrers_purge_time)
	? ($t == 1
		? $this->_t('Last24Hours')
		: Ut::perc_replace($this->_t('LastDays'), $t))
	: '');

if ($mode)
{
	$title = Ut::perc_replace($this->_t('ExternalPagesGlobal'),
		$this->href('referrers_sites', '', ['o' => $mode]),
		$purge_time);
}

$prefix = $this->prefix;

if ($mode == 'perpage')
{
	$query =
		"SELECT r.page_id, COUNT(r.referrer) AS num, p.owner_id, p.user_id, p.tag, p.title, p.page_lang " .
		"FROM " . $prefix . "referrer r " .
			"LEFT JOIN " . $prefix . "page p ON ( p.page_id = r.page_id ) " .
		"GROUP BY r.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang " .
		"ORDER BY num DESC, p.tag ASC";
}
else if ($mode == 'bytime')
{
	$query =
		"SELECT r.page_id, r.referrer_time, r.referrer, p.owner_id, p.user_id, p.tag, p.title, p.page_lang " .
		"FROM " . $prefix . "referrer r " .
			"LEFT JOIN " . $prefix . "page p ON ( p.page_id = r.page_id ) " .
		"ORDER BY r.referrer_time DESC";
}
else if ($mode == 'global')
{
	$query =
		"SELECT referrer, COUNT(referrer) AS num " .
		"FROM " . $prefix . "referrer " .
		"GROUP BY referrer " .
		"ORDER BY num DESC, referrer ASC";
}
else
{
	$title = Ut::perc_replace($this->_t('ExternalPages'),
		$this->compose_link_to_page($this->tag),
		$purge_time,
		$this->href('referrers_sites'));

	$query =
		"SELECT referrer, COUNT(referrer) AS num " .
		"FROM " . $prefix . "referrer " .
		"WHERE page_id = " . (int) $this->page['page_id'] . " " .
		"GROUP BY referrer " .
		"ORDER BY num DESC";
}

// let's start: print header
// TODO: rewrite with template

foreach ($modes as $i => $text)
{
	if ($mode == $i)
	{
		$tpl->header = $this->_t($text);
		break;
	}
}

// print navigation
$tpl->menu = $this->tab_menu($modes, $mode, 'referrers', [], $mod_selector);

// in default mode we show intra-wiki backlinks before external referrers
if (!$mode)
{
	$show_backlinks();
}

// referrers header
$tpl->title = $title;

$print_ref = function ($ref, $val, $vclass, $link = '') use (&$tpl, $url_maxlen)
{
	// shorten url name if too long
	$trunc = $this->shorten_string($ref, $url_maxlen);

	$tpl->l_vclass	= $vclass;
	$tpl->l_val		= $val;
	$tpl->l_ref		= $ref;
	$tpl->l_trunc	= $trunc;

	if ($link)
	{
		$tpl->l_l_link = $link;
	}
};

$preload_acl = function ($referrers)
{
	$page_ids	= [];

	foreach ($referrers as $referrer)
	{
		$this->cache_page($referrer, true);
		$page_ids[]	= $referrer['page_id'];
	}

	$this->preload_acl($page_ids);
	return $page_ids;
};

// check referrer permissions, and return link to referral wikipage, or '' if none available/accessible
$check_ref = function ($ref)
{
	if (!($page_id = (int) $ref['page_id']))
	{
		$link = '404';
	}
	else if ($this->db->hide_locked && !$this->has_access('read', $page_id))
	{
		$link = '';
	}
	else
	{
		$this->page_id_cache[$ref['tag']] = $page_id;

		$link = $this->link('/' . $ref['tag'], '', $ref['title'], '', '', 1, 0);
	}

	return $link;
};

// load data from db
$referrers = $this->db->load_all($query);

if (!$referrers)
{
	$tpl->none = true;
	return;
}

$pagination	= $this->pagination(count($referrers), @$max, 'r', ($mode? ['o' => $mode] : ''), 'referrers');
$referrers	= array_slice($referrers, $pagination['offset'], $pagination['perpage']);

// main show!

$tpl->pagination_text = $pagination['text'];

if ($mode == 'perpage')
{
	$page_ids	= $preload_acl($referrers);
	$referrers2	= $this->load_referrers($page_ids);

	$tpl->enter('p_');

	foreach ($referrers as $referrer)
	{
		if ($link = $check_ref($referrer))
		{
			$tpl->link	= $link;
			$tpl->num	= $referrer['num'];

			// filter referrers for page
			$ref_perpage = array_filter($referrers2, function ($var) use ($referrer)
			{
				return ($var['page_id'] == $referrer['page_id']);
			});

			foreach ($ref_perpage as $ref2)
			{
				$print_ref($ref2['referrer'], $ref2['num'], 'list-count');
			}
		}
	}

	$tpl->leave();
}
else if ($mode == 'bytime')
{
	$curday		= '';
	$page_ids	= $preload_acl($referrers);

	$tpl->enter('t_');

	foreach ($referrers as $referrer)
	{
		if ($link = $check_ref($referrer))
		{
			$this->sql2datetime($referrer['referrer_time'], $day, $time);

			if ($day != $curday)
			{
				$tpl->day = $curday = $day;
			}

			$print_ref($referrer['referrer'], $time, 'list-dt', $link);
		}
	}

	$tpl->leave();
}
else
{
	$tpl->enter('g_');

	foreach ($referrers as $referrer)
	{
		$print_ref($referrer['referrer'], $referrer['num'], 'list-count');
	}

	$tpl->leave();
}

