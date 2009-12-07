<?php
# error_reporting(E_ALL);

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

// Include SimplePie
require_once("lib/SimplePie/simplepie.inc");
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
			if ($interval == 1) $interval.= $engine->GetTranslation("FeedMonthAgo");
			else $interval.= $engine->GetTranslation("FeedMonthsAgo");
		}
		elseif ($interval_secs > 604800)
		{
			$interval = (($interval_secs - ($interval_secs%604800))/604800);
			if ($interval == 1) $interval.= $engine->GetTranslation("FeedWeekAgo");
			else $interval.= $engine->GetTranslation("FeedWeeksAgo");
		}
		elseif ($interval_secs > 86400)
		{
			$interval = (($interval_secs - ($interval_secs%86400))/86400);
			if ($interval == 1) $interval.= $engine->GetTranslation("FeedDayAgo");
			else $interval.= $engine->GetTranslation("FeedDaysAgo");
		}
		elseif ($interval_secs > 3600)
		{
			$interval = (($interval_secs - ($interval_secs%3600))/3600);
			if ($interval == 1) $interval.= $engine->GetTranslation("FeedHourAgo");
			else $interval.= $engine->GetTranslation("FeedHoursAgo");
		}
		elseif ($interval_secs > 60)
		{
			$interval = (($interval_secs - ($interval_secs%60))/60);
			if ($interval == 1) $interval.= $engine->GetTranslation("FeedMinuteAgo");
			else $interval.= $engine->GetTranslation("FeedMinutesAgo");
		}
		return  $interval;

	}
}

if (!$url)
	echo "<p><i>".$this->GetTranslation("FeedNoURL")."</i></p>\n";
else
{
	$urlset = explode("|",$url);
	if (count($urlset)==1) $urlset = $urlset[0];
	// Initialize SimplePie (ONLY ONCE PER ACTION!!!! DO NOT WRITE IT AGAIN PLEASE;))
	// Thus all configs will be same for all RSS-feeds
	$feed = new SimplePie($urlset);

	// Set where the cache files should be stored.
	$feed->set_cache_location('./'.$this->GetConfigValue("cache_dir").'feeds');

	// Make sure that we're sending the right character set headers, etc.
	$feed->set_output_encoding($this->languages[$this->GetConfigValue('language')]['charset']);
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
		echo "<p><i>".$this->GetTranslation("FeedError")."</i></p>\n";
		break;
	}

	$headertag = "h4";

	if ($title != "no")
	{
		if (($max)&&($max > 0)) $lastitems = " (last ".$max." items)";

		// Make nice if $nomark == 1
		if ($nomark)
		{
			if ($title != "" && $counturlset == 1)
			{
				echo "<h3 class=\"feed_element_title\" style=\"background-image:url(".$feed->get_favicon().");\">".$this->Link($feed->get_permalink(), "", $title, 1, 1)."</h3>";
			}
			if ($title != "" && $counturlset > 1)
			{
				echo "<h3>".$title."</h3>";
			}
			elseif (!$title && $counturlset == 1)
			{
				echo "<h3 class=\"feed_element_title\" style=\"background-image:url(".$feed->get_favicon().");\">".$this->Link($feed->get_permalink(), "", $feed->get_title(), 1, 1)."</h3>";
			}
			elseif (!$title && $counturlset > 1)
			{
				echo "<h3>".$this->GetTranslation('FeedMulti')."</h3>";
			}
			echo $lastitems;
		}

		// Default
		else
		{
			if ($title != "" && $counturlset == 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->GetTranslation('FeedTitle').": <strong>".$this->Link($feed->get_permalink(), "", $title, 1, 1)."</strong>".$lastitems."<span></p>";
			}
			if ($title != "" && $counturlset > 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->GetTranslation('FeedTitle').": <strong>".$title."</strong>".$lastitems."</span></p>";
			}
			elseif (!$title && $counturlset == 1)
			{
				echo "<p class=\"layout-box\"><span>".$this->GetTranslation('FeedTitle').": <strong>".$this->Link($feed->get_permalink(), "", $feed->get_title(), 1, 1)."</strong>".$lastitems."</span></p>";
			}
			elseif (!$title && $counturlset > 1)
			{
				echo "<p class=\"layout-box\"><span><strong>".$this->GetTranslation('FeedMulti')."</strong>".$lastitems."</span></p>";
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
				echo " class=\"feed_element_title\" style=\"background-image:url(".$xfeed->get_favicon().");\"";

			echo ">".$this->Link($item->get_permalink(), "", $item->get_title(), 1, 1)."</".$headertag.">";
			echo "<p class=\"note\"><span>".$this->GetTranslation("FeedSource")." ".$this->Link($xfeed->get_permalink(), "", $xfeed->get_title(), 1, 1)." | ".$item->get_date('d.m.Y g:i')." | ";

			if (($time == "yes")&&($date != 0))
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
			echo "<".$headertag.">".$this->Link($href, "", $title, 1, 1)."</".$headertag.">";

			if (($time == "yes")&&($date != 0))
				echo "<p class=\"note\"><span>".intervalCalc($date)."</span></p>";

			echo "<p class=\"feed-content\">".$item->get_content()."</p>";

			// item-paragraph ending
			echo "</div>";

			if (($max)&&($current == $max))
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