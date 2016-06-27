<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<div id="page">';
$include_tail = '</div>';

// redirect to show method if no page exists
if (!$this->page)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1') . '#' . $this->page['tag']);
}

// let's start: print header
echo '<h3>' . $this->get_translation('ReferrersText') . ' &raquo; ' . $this->get_translation('ViewReferrersGlobal') . '</h3>';

$show_backlinks = function ()
{
	echo '<strong>' . $this->get_translation('ReferringPages') . ":</strong><br /><br />\n";

	// show backlinks
	if (($pages = $this->load_pages_linking_to($this->tag)))
	{
		echo "<ol>\n";

		$anchor = $this->translit($this->tag);

		foreach ($pages as $page)
		{
			if ($page['tag'])
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
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
		echo $this->get_translation('NoReferringPages');
	}
	echo '<p></p>';
};

// fast lane: show backlinks for those who don't deserve further service ;)
// enable_referrers == 1 for all logged-in users, == 2 for admins only
if (
	($this->config['enable_referrers'] == 0) ||
	($this->config['enable_referrers'] == 1 && !$this->get_user()) ||
	($this->config['enable_referrers'] == 2 && !$this->is_admin()))
{
	echo "<br /><br />\n";
	$show_backlinks();
	return;
}

// set up for main show
$url_maxlen = 80;
$spacer		= '&nbsp;&nbsp;&rarr;&nbsp;&nbsp;'; // ' . . . . . . . . . . . . . . . . '
$modes		= ['ViewReferrersPage' => '', 'ViewReferrersPerPage' => 'perpage', 'ViewReferrersByTime' => 'bytime', 'ViewReferrersGlobal' => 'global'];
$max		= $this->get_list_count(@$max);
$mode		= @$_GET['o'];
if (!in_array($mode, $modes))
{
	$mode = '';
}

// set up for main show
$purge_time = (($t = $this->config['referrers_purge_time'])
	? ($t == 1
		? $this->get_translation('Last24Hours')
		: perc_replace($this->get_translation('LastDays'), $t))
	: '');

if ($mode)
{
	$title = perc_replace($this->get_translation('ExternalPagesGlobal'),
		$this->href('referrers_sites', '', 'o=' . $mode),
		$purge_time);
}

$px = $this->config['table_prefix'];
if ($mode == 'perpage')
{
	$query = "SELECT r.page_id, COUNT(r.referrer) AS num, p.tag, p.title, p.page_lang ".
		"FROM ".$px."referrer r ".
		"LEFT JOIN ".$px."page p ON ( p.page_id = r.page_id ) ".
		"GROUP BY r.page_id ".
		"ORDER BY num DESC";
}
else if ($mode == 'bytime')
{
	$query = "SELECT r.page_id, r.referrer_time, r.referrer, p.tag, p.title, p.page_lang ".
		"FROM ".$px."referrer r ".
		"LEFT JOIN ".$px."page p ON ( p.page_id = r.page_id ) ".
		"ORDER BY r.referrer_time DESC";
}
else if ($mode == 'global')
{
	$query = "SELECT referrer, COUNT(referrer) AS num ".
		"FROM ".$px."referrer ".
		"GROUP BY referrer ".
		"ORDER BY num DESC";
}
else
{
	$title = perc_replace($this->get_translation('ExternalPages'),
		$this->compose_link_to_page($this->tag),
		$purge_time,
		$this->href('referrers_sites'));

	$query =
		"SELECT referrer, COUNT(referrer) AS num ".
		"FROM ".$px."referrer ".
			"WHERE page_id = '".(int)$this->page['page_id']."' ".
		"GROUP BY referrer ".
		"ORDER BY num DESC";
}

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
	echo $this->get_translation($text);
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
	$trunc = (strlen($ref) > $url_maxlen)?  substr($ref, 0, 30) . '[..]' . substr($ref, -20) : $ref;

	echo '<li class="lined">';
	echo '<span class="' . $vclass . '">' . $val . '</span>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<span class=""><a title="' . htmlspecialchars($ref, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).
		'" href="' . htmlspecialchars($ref, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).
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
	if (!($id = (int)$ref['page_id']))
	{
		$link = '404';
	}
	else if ($this->config['hide_locked'] && !$this->has_access('read', $id))
	{
		$link = '';
	}
	else
	{
		// check current page lang for different charset to do_unicode_entities() against
		// - page lang
		$lang = ($this->page['page_lang'] != $ref['page_lang'])?  $ref['page_lang'] : '';

		// cache page_id for for has_access validation in link function
		$this->page_id_cache[$ref['tag']] = $id;

		//$page_link = $this->compose_link_to_page($referrer['tag']);
		$link = $this->link('/' . $ref['tag'], '', $ref['title'], '', '', '', $lang, 0);
	}

	return $link;
};

// load data from db
$referrers = $this->load_all($query);
if (!$referrers)
{
	echo $this->get_translation('NoneReferrers') . "<br /><br />\n" ;
	return;
}
$pagination = $this->pagination(count($referrers), $max, 'r', ($mode? 'o=' . $mode : ''), 'referrers');
$referrers = array_slice($referrers, $pagination['offset'], $max);

// main show!

$this->print_pagination($pagination);
echo '<ul class="ul_list">' . "\n";

if ($mode == 'perpage')
{
	foreach ($referrers as $referrer)
	{
		if (($link = $check_ref($referrer)))
		{
			echo '<li><strong>' . $link . '</strong> (' . $referrer['num'] . ')';

			echo "<ul>\n";

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
			// tz offset
			$time_tz = $this->get_time_tz(strtotime($referrer['referrer_time']));
			$day = date($this->config['date_format'], $time_tz);
			$time = date($this->config['time_format_seconds'], $time_tz);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}

				echo '<li><strong>' . $day . "</strong>\n<ul>\n";
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

