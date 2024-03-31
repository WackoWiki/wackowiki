<?php

if (!defined('IN_WACKO'))
{
	exit;
}

//
/* requires SimplePie: https://simplepie.org

	TODO:
	* local image cache
	* feed_acl
*/

$info = <<<EOD
Description:
	RSS/Atom Feed Integration.

Usage:
	{{feed url="https://...[|https://...|https://...]"}}

Options:
	[title="News feed title|no"]
		"text" - displayed as title
		"no" - means show no title
		empty title - title taken from feed
	[images=0] - text only for better readability
	[max=Number]
	[time=1]
	[nomark=1]
		1 - makes feed header h3 and feed-items headers h4
		0 - makes it all default
EOD;

// set defaults
$help		??= 0;
$images		??= 1;
$max		??= 5;
$nomark		??= 0;
$noxml		??= 0;
$time		??= 1;
$title		??= '';
$url		??= null;

if ($help)
{
	$tpl->help	= $this->help($info, 'feed');
	return;
}

$error		= null;
$p_mode		= [];

// load SimplePie classes
include_once 'lib/SimplePie/autoloader.php';

if (!$url)
{
	$tpl->nourl = true;
}
else
{
	$urlset = explode('|', $url);

	if (count($urlset) == 1)
	{
		$urlset			= $urlset[0];
		$count_feeds	= 1;
	}
	else
	{
		$count_feeds	= count($urlset);
	}

	// strip images from an item, do profanity censoring, customize it for your requirements
	$item_content = function ($content)
	{
		// replace all images in the content
		return preg_replace('/<img([^>]*)>/ui', '', $content);
	};

	// Initialize SimplePie (ONLY ONCE PER ACTION!!!! DO NOT WRITE IT AGAIN PLEASE)
	// Thus all configs will be same for all RSS-feeds
	$feed = new \SimplePie\SimplePie();
	$feed->set_feed_url($urlset);
	// Set where the cache files should be stored.
	$feed->set_cache_location('./' . CACHE_FEED_DIR);

	// Make sure that we're sending the right character set headers, etc.
	$feed->set_output_encoding('utf-8');
	$feed->strip_comments(true);

	$feed->init();

	// Handle it all - goes after init()
	$feed->handle_content_type();


	if ($feed->error())
	{
		$error = $feed->error();
	}

	if (!$nomark)
	{
		$tpl->mark		= true;
		$tpl->emark		= true;
	}

	if (!$feed->get_title() && $count_feeds == 1)
	{
		$tpl->error			= true;
		$tpl->error_message	= $error;
	}
	else
	{
		$tpl->error_message	= $error;

		$class = ' class="feed-element-title"';

		if ($title != 'no')
		{
			if ($nomark)
			{
				$tpl->enter('nomark_');

				if ($title != '' && $count_feeds == 1)
				{
					$tpl->header	= $this->link($feed->get_permalink(), '', $title, '', false, true);
					$tpl->class		= $class;
				}
				if ($title != '' && $count_feeds > 1)
				{
					$tpl->header	= $title;
				}
				else if (!$title && $count_feeds == 1)
				{
					$tpl->header	= $this->link($feed->get_permalink(), '', $feed->get_title(), '', false, true);
					$tpl->class		= $class;
				}
				else if (!$title && $count_feeds > 1)
				{
					$tpl->header	= $this->_t('FeedMulti');
				}
			}
			// default
			else
			{
				$tpl->enter('mark_');

				if ($title != '' && $count_feeds == 1)
				{
					$tpl->header	= $this->_t('FeedTitle');
					$tpl->title		= $this->link($feed->get_permalink(), '', $title, '', false, true);
				}

				if ($title != '' && $count_feeds > 1)
				{
					$tpl->header	= $this->_t('FeedTitle');
					$tpl->title		= $title;
				}
				else if (!$title && $count_feeds == 1)
				{
					$tpl->header	= $this->_t('FeedTitle');
					$tpl->title		= $this->link($feed->get_permalink(), '', $feed->get_title(), '', false, true);
				}
				else if (!$title && $count_feeds > 1)
				{
					$tpl->header	= $this->_t('FeedMulti');
				}
			}

			$tpl->leave();
		}

		// we're using a parameter token here to sort out multiple instances
		$param_token	= substr(hash('sha1', $url . $nomark . $time . $max), 0, 8);
		$count			= $feed->get_item_quantity();
		$pagination		= $this->pagination(($count ?? null), $max, 'p', $p_mode + ['#' => $param_token]);

		if (!(int) $noxml && $count_feeds == 1)
		{
			$tpl->xml_href = $urlset;
		}

		// pagination
		$tpl->pagination_text	= $pagination['text'];
		$tpl->token				= $param_token;

		$tpl->enter('i_');

		// go through all the items in the feed
		foreach ($feed->get_items($pagination['offset'], (int) $max) as $item)
		{
			if ($item->get_date())
			{
				// should have proper Unix time - 'U'
				$date = $item->get_date('U');
			}
			else
			{
				$date = 0;
			}

			if ($nomark)
			{
				$tpl->class		= $class;
			}

			// headline
			$tpl->link		= $this->link($item->get_permalink(), '', $item->get_title(), '', false, true);

			if ($count_feeds > 1)
			{
				// Here, we'll use the $item->get_feed() method to gain access to the parent feed-level data for the specified item.
				$xfeed = $item->get_feed();

				$tpl->m_href	= $xfeed->get_permalink();
				$tpl->m_title	= $xfeed->get_title();
			}

			if (($time == 1) && ($date))
			{
				$tpl->t_date		= $item->get_date('d.m.Y G:i');
				$tpl->t_utime		= $item->get_date('U');
				$tpl->t_interval	= $this->get_time_interval($date);
			}

			$tpl->content = $images
				? $item->get_content()
				: $item_content($item->get_content());

			if ($enclosure = $item->get_enclosure())
			{
				if ($enclosure->get_link() && stristr($enclosure->get_type(), 'image/'))
				{
					$tpl->e_img_link = $enclosure->get_link();
				}
				else if (!empty($enclosure->get_link()))
				{
					$e_href		= str_replace(' ', '%20', $enclosure->get_link());
					$e_title	= basename(parse_url($enclosure->get_link(), PHP_URL_PATH));

					$tpl->e_f_link = $this->link($e_href, '', $e_title, '', 0, 1);
					$tpl->e_f_size = $enclosure->get_size();
					$tpl->e_f_type = $enclosure->get_type();
				}
			}
		}

		$tpl->leave();
	}
}
