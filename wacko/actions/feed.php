<?php

// actions/feed.php - WackoWiki Action to integrate RSS/Atom Feeds
// requires SimplePie: http://simplepie.org
/* USAGE:

	{{feed
		url="http://...[|http://...|http://...]"
		[title="News feed title|no"]
			"text" - displayed as title
			"no" - means show no title
			empty title - title taken from feed
		[max="x"]
		[time=yes]
		[nomark="1"]
			"1" - makes feed header h3 and feed-items headers h4
			"0" - makes it all default
	}}

*/
// TODO:
//   * pagination
//   * local image cache
//   * feed_acl

if (!isset($nomark)) $nomark = '';
if (!isset($title)) $title = '';
if (!isset($max)) $max = '';
if (!isset($time)) $time = '';

// Include SimplePie
include_once('lib/SimplePie/simplepie.class.php');
# include_once('lib/SimplePie/idn/idna_convert.class.php');

if (!function_exists('intervalCalc'))
{
	function intervalCalc($postedtime)
	{
	global $engine;

		$now = time();
		$interval_secs = $now  - $postedtime;

		if ($interval_secs > 2592000)
		{
			$interval = (($interval_secs - ($interval_secs%2592000))/2592000);
			if ($interval == 1) $interval.= $engine->get_translation('FeedMonthAgo');
			else $interval.= $engine->get_translation('FeedMonthsAgo');
		}
		elseif ($interval_secs > 604800)
		{
			$interval = (($interval_secs - ($interval_secs%604800))/604800);
			if ($interval == 1) $interval.= $engine->get_translation('FeedWeekAgo');
			else $interval.= $engine->get_translation('FeedWeeksAgo');
		}
		elseif ($interval_secs > 86400)
		{
			$interval = (($interval_secs - ($interval_secs%86400))/86400);
			if ($interval == 1) $interval.= $engine->get_translation('FeedDayAgo');
			else $interval.= $engine->get_translation('FeedDaysAgo');
		}
		elseif ($interval_secs > 3600)
		{
			$interval = (($interval_secs - ($interval_secs%3600))/3600);
			if ($interval == 1) $interval.= $engine->get_translation('FeedHourAgo');
			else $interval.= $engine->get_translation('FeedHoursAgo');
		}
		elseif ($interval_secs > 60)
		{
			$interval = (($interval_secs - ($interval_secs%60))/60);
			if ($interval == 1) $interval.= $engine->get_translation('FeedMinuteAgo');
			else $interval.= $engine->get_translation('FeedMinutesAgo');
		}
		return  $interval;

	}
}

if (!$url)
	echo "<p><i>".$this->get_translation('FeedNoURL')."</i></p>\n";
else
{
	$urlset = explode("|",$url);
	if (count($urlset)==1) $urlset = $urlset[0];
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
	echo "<div class='layout-box'>\n";
}
	$counturlset=count($urlset);

	if (!$feed->get_title() && $counturlset == 1)
	{
		echo "<p><i>".$this->get_translation('FeedError')."</i></p>\n";
		break;
	}

	$headertag = 'h4';

	if ($title != 'no')
	{
		if (($max)&&($max > 0)) $lastitems = " (last ".$max." items)";

		// Make nice if $nomark == 1
		if ($nomark)
		{
			if ($title != '' && $counturlset == 1)
			{
				echo "<h3 class=\"feed_element_title\">".$this->link($feed->get_permalink(), '', $title, '', 1, 1)."</h3>";
			}
			if ($title != '' && $counturlset > 1)
			{
				echo "<h3>".$title."</h3>";
			}
			elseif (!$title && $counturlset == 1)
			{
				echo "<h3 class=\"feed_element_title\">".$this->link($feed->get_permalink(), '', $feed->get_title(), '', 1, 1)."</h3>";
			}
			elseif (!$title && $counturlset > 1)
			{
				echo "<h3>".$this->get_translation('FeedMulti')."</h3>";
			}
			echo $lastitems;
		}

		// Default
		else
		{
			if ($title != '' && $counturlset == 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->get_translation('FeedTitle').": <strong>".$this->link($feed->get_permalink(), '', $title, '', 1, 1)."</strong>".$lastitems."<span></p>";
			}
			if ($title != '' && $counturlset > 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->get_translation('FeedTitle').": <strong>".$title."</strong>".$lastitems."</span></p>";
			}
			elseif (!$title && $counturlset == 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->get_translation('FeedTitle').": <strong>".$this->link($feed->get_permalink(), '', $feed->get_title(), '', 1, 1)."</strong>".$lastitems."</span></p>";
			}
			elseif (!$title && $counturlset > 1)
			{
				echo "<p class=\"layout-box\"><span><strong>".$this->get_translation('FeedMulti')."</strong>".$lastitems."</span></p>";
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
				//Should have proper Unix time - 'U'
				$date = $item->get_date('U');
			else
				$date = 0;

			echo "<div class=\"feed\">";
			echo "<".$headertag;

			if($nomark)
				echo " class=\"feed_element_title\"";

			echo ">".$this->link($item->get_permalink(), '', $item->get_title(), '', 1, 1)."</".$headertag.">";
			echo "<p class=\"note\"><span>".$this->get_translation('FeedSource')." ".$this->link($xfeed->get_permalink(), '', $xfeed->get_title(), '', 1, 1)." | ".$item->get_date('d.m.Y g:i')." | ";

			if (($time == 'yes') && ($date != 0))
				echo intervalCalc($date);

			echo "</span></p>";
			echo "<p class=\"feed-content\">".$item->get_content()."</p>";
			echo "</div>";

			if (($max)&&($current == $max))
				break;
			else
				$current++;
		}
	}
	else
	{
		// Go through all of the items in the feed
		foreach ($feed->get_items() as $item)
		{
			// get strings
			$href = $item->get_permalink();
			$title = $item->get_title();

			if ($item->get_date())
				//Should have proper Unix time - 'U'
				$date = $item->get_date('U');
			else
				$date = 0;

			echo "<div class=\"feed\">";

			// headline
			#echo "<a target=\"_blank\" href=\"$href\" class=\"outerlink\">$title</a>";
			echo "<".$headertag.">".$this->link($href, '', $title, '', 1, 1)."</".$headertag.">";

			if (($time == 'yes') && ($date != 0))
				echo "<p class=\"note\"><span>".intervalCalc($date)."</span></p>";

			echo "<p class=\"feed-content\">".$item->get_content()."</p>";

			// item-paragraph ending
			echo "</div>";

			if (($max) && ($current == $max))
				break;
			else
				$current++;
		}
	}
}
if (!$nomark)
{
	echo "</div>\n";
}

?>