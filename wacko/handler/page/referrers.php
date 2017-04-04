<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page(true); // allow forums

$show_backlinks = function ()
{
	echo '<strong>' . $this->_t('ReferringPages') . ":</strong><br /><br />\n";

	// show backlinks
	if (($pages = $this->load_pages_linking_to($this->tag)))
	{
		echo "<ol>\n";

		$anchor = $this->translit($this->tag);

		foreach ($pages as $page)
		{
			if ($page['tag'])
			{
				if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
				{
					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					echo '<li>' . $this->link('/' . $page['tag'] . "#a-" . $anchor, '', $page['tag'], $page['title']) . "</li>\n";
				}
			}
		}

		echo "</ol>\n";
	}
	else
	{
		echo $this->_t('NoReferringPages');
	}
	echo '<p></p>';
};

// fast lane: show backlinks for those who don't deserve further service ;)
// enable_referrers == 1 for all logged-in users, == 2 for admins only
if (
	(   $this->db->enable_referrers == 0)
	|| ($this->db->enable_referrers == 1 && !$this->get_user())
	|| ($this->db->enable_referrers == 2 && !$this->is_admin()))
{
	echo "<br /><br />\n";
	$show_backlinks();
	return;
}

// set up for main show
$url_maxlen = 80;
$spacer		= '&nbsp;&nbsp;&rarr;&nbsp;&nbsp;';
$modes		=  ['ViewReferrersPage'		=> '',
				'ViewReferrersPerPage'	=> 'perpage',
				'ViewReferrersByTime'	=> 'bytime',
				'ViewReferrersGlobal'	=> 'global'];
$mode		= @$_GET['o'];

if (!in_array($mode, $modes))
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
		$this->href('referrers_sites', '', 'o=' . $mode),
		$purge_time);
}

$px = $this->db->table_prefix;

if ($mode == 'perpage')
{
	$query =
		"SELECT r.page_id, COUNT(r.referrer) AS num, p.tag, p.title, p.page_lang " .
		"FROM " . $px."referrer r " .
			"LEFT JOIN " . $px."page p ON ( p.page_id = r.page_id ) " .
		"GROUP BY r.page_id " .
		"ORDER BY num DESC";
}
else if ($mode == 'bytime')
{
	$query =
		"SELECT r.page_id, r.referrer_time, r.referrer, p.tag, p.title, p.page_lang " .
		"FROM " . $px."referrer r " .
			"LEFT JOIN " . $px."page p ON ( p.page_id = r.page_id ) " .
		"ORDER BY r.referrer_time DESC";
}
else if ($mode == 'global')
{
	$query =
		"SELECT referrer, COUNT(referrer) AS num " .
		"FROM " . $px."referrer " .
		"GROUP BY referrer " .
		"ORDER BY num DESC";
}
else
{
	$title = Ut::perc_replace($this->_t('ExternalPages'),
		$this->compose_link_to_page($this->tag),
		$purge_time,
		$this->href('referrers_sites'));

	$query =
		"SELECT referrer, COUNT(referrer) AS num " .
		"FROM " . $px."referrer " .
		"WHERE page_id = '" . (int) $this->page['page_id'] . "' " .
		"GROUP BY referrer " .
		"ORDER BY num DESC";
}

// let's start: print header
// TODO: rewrite with template
echo '<h3>' . $this->_t('ReferrersText') . ' &raquo; ';

foreach ($modes as $text => $i)
{
	if ($mode == $i)
	{
		echo $this->_t($text);
	}
}

echo "</h3>\n";

// print navigation
echo '<ul class="menu">';

foreach ($modes as $text => $i)
{
	if ($mode != $i)
	{
		echo '<li><a href="' . $this->href('referrers', '', ($i? 'o=' . $i : '')) . '">';
	}
	else
	{
		echo '<li class="active">';
	}

	echo $this->_t($text);

	if ($mode != $i)
	{
		echo '</a>';
	}

	echo '</li>';
}

echo "</ul><br /><br />\n";

// in default mode we show intra-wiki backlinks before external referrers
if (!$mode)
{
	$show_backlinks();
}

// referrers header
echo '<strong>' . $title . "</strong><br /><br />\n";

$print_ref = function ($ref, $val, $vclass, $link = '') use ($url_maxlen, $spacer)
{
	// shorten url name if too long
	$trunc = $this->shorten_string($ref, $url_maxlen);

	echo '<li>';
	echo '<span class="' . $vclass . '">' . $val . '</span>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<span class=""><a title="' . htmlspecialchars($ref, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) .
		'" href="' . htmlspecialchars($ref, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) .
		'" rel="nofollow noreferrer">' . htmlspecialchars($trunc, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</a></span>';

	if ($link)
	{
		echo $spacer . '<small>' . $link . '</small>';
	}

	echo "</li>\n";
};

// check referrer permissions, and return link to referal wikipage, or '' if none available/accessible
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
		// check current page lang for different charset to do_unicode_entities() against
		// - page lang
		$lang = ($this->page['page_lang'] != $ref['page_lang'])?  $ref['page_lang'] : '';

		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$ref['tag']] = $page_id;

		$link = $this->link('/' . $ref['tag'], '', $ref['title'], '', '', '', $lang, 0);
	}

	return $link;
};

// load data from db
$referrers = $this->db->load_all($query);

if (!$referrers)
{
	echo $this->_t('NoneReferrers') . "<br /><br />\n" ;
	return;
}

$pagination	= $this->pagination(count($referrers), @$max, 'r', ($mode? ['o' => $mode] : ''), 'referrers');
$referrers	= array_slice($referrers, $pagination['offset'], $pagination['perpage']);

// main show!

$this->print_pagination($pagination);
echo '<ul class="ul_list">' . "\n";

if ($mode == 'perpage')
{
	foreach ($referrers as $referrer)
	{
		if (($link = $check_ref($referrer)))
		{
			echo '<li><strong>' . $link . '</strong> (' . $referrer['num'] . ')' .
				 '<ul class="lined">' . "\n";

			foreach ($this->load_referrers($referrer['page_id']) as $ref2)
			{
				$print_ref($ref2['referrer'], $ref2['num'], 'list_count');
			}

			echo "</ul>\n<br /></li>\n";
		}
	}
}
else if ($mode == 'bytime')
{
	$curday = '';

	foreach ($referrers as $referrer)
	{
		if (($link = $check_ref($referrer)))
		{
			$this->sql2datetime($referrer['referrer_time'], $day, $time);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}

				echo '<li><strong>' . $day . "</strong>\n" .
					 '<ul class="lined">' . "\n";

				$curday = $day;
			}

			$print_ref($referrer['referrer'], $time, '', $link);
		}
	}
}
else
{
	foreach ($referrers as $referrer)
	{
		$print_ref($referrer['referrer'], $referrer['num'], 'list_count');
	}
}

echo "</ul>\n";

$this->print_pagination($pagination);

