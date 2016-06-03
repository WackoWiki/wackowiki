<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action/feed.php - WackoWiki Action to integrate RSS/Atom Feeds
// requires SimplePie: http://simplepie.org
/* USAGE:

	{{feed
		url="http://...[|http://...|http://...]"
		[title="News feed title|no"]
			"text" - displayed as title
			"no" - means show no title
			empty title - title taken from feed
		[max=x]
		[time=1]
		[nomark=1]
			1 - makes feed header h3 and feed-items headers h4
			0 - makes it all default
	}}

*/
// TODO:
//   * pagination
//   * local image cache
//   * feed_acl

if (!isset($nomark))	$nomark	= '';
if (!isset($title))		$title	= '';
if (!isset($max))		$max	= 5;
if (!isset($time))		$time	= '';

// Include SimplePie
#include_once('lib/SimplePie/autoloader.php');
include_once('lib/SimplePie/simplepie.class.php');

if (!$url)
{
	echo '<p><em>'.$this->get_translation('FeedNoURL')."</em></p>\n";
}
else
{
	$urlset = explode('|', $url);

	if (count($urlset) == 1)
	{
		$urlset = $urlset[0];
	}

	// Initialize SimplePie (ONLY ONCE PER ACTION!!!! DO NOT WRITE IT AGAIN PLEASE;))
	// Thus all configs will be same for all RSS-feeds
	$feed = new SimplePie();
	$feed->set_feed_url($urlset);
	// Set where the cache files should be stored.
	$feed->set_cache_location('./'.$this->config['cache_dir'].'feeds');

	// Make sure that we're sending the right character set headers, etc.
	$feed->set_output_encoding($this->languages[$this->config['language']]['charset']);
	$feed->strip_comments(true);


	// Experiments here

	//$feed->force_feed(true); -- grab it all

	// Experiments here ^

	$feed->init();

	// Handle it all - goes after init()
	$feed->handle_content_type();

	if (!$nomark)
	{
		echo '<div class="layout-box">'."\n";
	}

	$counturlset = count($urlset);

	if (!$feed->get_title() && $counturlset == 1)
	{
		echo '<p><em>'.$this->get_translation('FeedError')."</em></p>\n";
		#break;
	}
	else
	{
		$header_feed = 'h1';
		$header_item = 'h2';

		if ($title != 'no')
		{
			if (($max) && ($max > 0))
			{
				$lastitems = ' (last '.$max.' items)';
			}

			// Make nice if $nomark == 1
			if ($nomark)
			{
				if ($title != '' && $counturlset == 1)
				{
					echo '<'.$header_feed.' class="feed_element_title">'.$this->link($feed->get_permalink(), '', $title, '', 1, 1).'</'.$header_feed.">\n";
				}
				if ($title != '' && $counturlset > 1)
				{
					echo '<'.$header_feed.'>'.$title.'</'.$header_feed.">\n";
				}
				else if (!$title && $counturlset == 1)
				{
					echo '<'.$header_feed.' class="feed_element_title">'.$this->link($feed->get_permalink(), '', $feed->get_title(), '', 1, 1).'</'.$header_feed.">\n";
				}
				else if (!$title && $counturlset > 1)
				{
					echo '<'.$header_feed.'>'.$this->get_translation('FeedMulti').'</'.$header_feed.">\n";
				}

				echo $lastitems;
			}

			// Default
			else
			{
				if ($title != '' && $counturlset == 1)
				{
					echo '<p class="layout-box"><span>'.$this->get_translation('FeedTitle').': <strong>'.$this->link($feed->get_permalink(), '', $title, '', 1, 1).'</strong>'.$lastitems."<span></p>\n";
				}

				if ($title != '' && $counturlset > 1)
				{
					echo '<p class="layout-box"><span>'.$this->get_translation('FeedTitle').': <strong>'.$title.'</strong>'.$lastitems."</span></p>\n";
				}
				else if (!$title && $counturlset == 1)
				{
					echo '<p class="layout-box"><span>'.$this->get_translation('FeedTitle').': <strong>'.$this->link($feed->get_permalink(), '', $feed->get_title(), '', 1, 1).'</strong>'.$lastitems."</span></p>\n";
				}
				else if (!$title && $counturlset > 1)
				{
					echo '<p class="layout-box"><span><strong>'.$this->get_translation('FeedMulti').'</strong>'.$lastitems."</span></p>\n";
				}
			}
		}

		$current = 1;

		if ($counturlset > 1)
		{
			foreach ($feed->get_items() as $item)
			{
				/* Here, we'll use the $item->get_feed() method to gain access to the parent feed-level data for the specified item. */
				$xfeed = $item->get_feed();

				if ($item->get_date())
				{
					// should have proper Unix time - 'U'
					$date = $item->get_date('U');
				}
				else
				{
					$date = 0;
				}

				echo '<article class="feed">';
				echo '<'.$header_item;

				if($nomark)
				{
					echo ' class="feed_element_title"';
				}

				echo '>'.$this->link($item->get_permalink(), '', $item->get_title(), '', 1, 1).'</'.$header_item.'>';
				echo '<p class="note"><span>'.$this->get_translation('FeedSource').' '.$this->link($xfeed->get_permalink(), '', $xfeed->get_title(), '', 1, 1).' | '.$item->get_date('d.m.Y g:i').' | ';

				if (($time == 1) && ($date != 0))
				{
					echo $this->get_time_interval($date);
				}

				echo "</span></p>\n";
				echo '<div class="feed-content">'.$item->get_content()."</div>\n";
				echo "</article>\n";

				if (($max) && ($current == $max))
				{
					break;
				}
				else
				{
					$current++;
				}
			}
		}
		else
		{
			// Go through all of the items in the feed
			foreach ($feed->get_items() as $item)
			{
				// get strings
				$href	= $item->get_permalink();
				$title	= $item->get_title();

				if ($item->get_date())
				{
					// should have proper Unix time - 'U'
					$date = $item->get_date('U');
				}
				else
				{
					$date = 0;
				}

				echo '<article class="feed">'."\n";

				// headline
				#echo '<a target="_blank" href="'.$href.'" class="outerlink">'.$title.'</a>';
				echo '<'.$header_item.'>'.$this->link($href, '', $title, '', 1, 1).'</'.$header_item.">\n";

				if (($time == 1) && ($date != 0))
				{
					echo '<p class="note"><span>'.$this->get_time_interval($date)."</span></p>\n";
				}

				echo '<div class="feed-content">'.$item->get_content()."</div>\n";

				if ($enclosure = $item->get_enclosure())
				{
					if (!empty($enclosure->get_link()))
					{
						echo '<img src="' . $enclosure->get_link() . '">'."\n";
					}
				}

				// item-paragraph ending
				echo "</article>\n";

				if (($max) && ($current == $max))
				{
					break;
				}
				else
				{
					$current++;
				}
			}
		}
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}
}
?>