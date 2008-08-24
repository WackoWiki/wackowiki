<?php

// actions/feed.php - WackoWiki Action to integrate RSS/Atom Feeds
// requires SimplePie: http://simplepie.org
// {{feed url="http://..." [title=no] [max="x"] [style="css-style"] [time=yes]}}
// alpha - still needs work!
// TODO:
//   * multifeed
//   * charset issue 
//   * charset issue 

// Include SimplePie
require_once("lib/SimplePie/simplepie.inc");
# include_once('lib/SimplePie/idn/idna_convert.class.php');

if (!function_exists('intervalCalc'))
{
function intervalCalc($postedtime)
{
	$now = time();
	$interval_secs = $now  - $postedtime;

	if ($interval_secs > 2592000)
	{
		$interval = (($interval_secs - ($interval_secs%2592000))/2592000);
		if ($interval == 1) $interval.= " month ago";
		else $interval.= " months ago";
	}
	else if ($interval_secs > 604800)
	{
		$interval = (($interval_secs - ($interval_secs%604800))/604800);
		if ($interval == 1) $interval.= " week ago";
		else $interval.= " weeks ago";
	}
	elseif ($interval_secs > 86400)
	{
		$interval = (($interval_secs - ($interval_secs%86400))/86400);
		if ($interval == 1) $interval.= " day ago";
		else $interval.= " days ago";
	}
	elseif ($interval_secs > 3600)
	{
		$interval = (($interval_secs - ($interval_secs%3600))/3600);
		if ($interval == 1) $interval.= " hour ago";
		else $interval.= " hours ago";
	}
	elseif ($interval_secs > 60)
	{
		$interval = (($interval_secs - ($interval_secs%60))/60);
		if ($interval == 1) $interval.= " minute ago";
		else $interval.= " minutes ago";
	}
	return  $interval;
}
}

#$url = "http://del.icio.us/rss/seebi/ldap";
#$url = "http://sebastian.dietzold.de/b2/xmlsrv/rdf.php?blog=5";
#$max=5;
#$time="yes";

// Initialize SimplePie

$feed = new SimplePie($url);
	
// Make sure that we're sending the right character set headers, etc.
$feed->handle_content_type();


if ($divclass) // the new div-way
{
	echo "<div class='$divclass'><div class='inner'>\n";
}
else // the taditional fieldset-table-way
{
	echo "<fieldset>";
}

if (!$url)
	echo "<p><i>".$this->GetResourceValue("FeedNoURL")."</i></p>\n";
else
{
	$feed = new SimplePie( $url );
	if (!$feed->get_title())
		echo "<p><i>".$this->GetResourceValue("FeedError")."</i></p>\n";
	else
	{
		if ($title!="no")
			if ($divclass) // the new div-way
				if ($title!="")
					echo "<div class='legend'>$title</div>\n";
				else
				{
					echo "<div class='legend'>".$feed->get_title();
					if (($max)&&($max>0)) echo " (last $max items)";
					echo "</div>\n";
				}
			else
			{
				echo "<legend>".$this->GetResourceValue('FeedTitle').": <strong>".$this->Link($feed->get_permalink(), "", $feed->get_title(), 1, 1)."</strong>";
				if (($max)&&($max>0)) echo " (last $max items)";
				echo "</legend>\n";			
			}

		$current=1;
		
		// Set up some variables we'll use.
$stored_date = '';
$list_open = false;
 
// Go through all of the items in the feed
foreach ($feed->get_items() as $item)


		{
			// get strings
			$href = $item->get_permalink();
			$title = $item->get_title();

			if ($item->get_date())
				// gmmktime( $hours, $minutes, $seconds, $month, $day, $year)'H, m, s, m, d, Y'
				$date = $item->get_date('H, m, s, m, d, Y');
			else
				$date=0;

			if ($item->get_content())
				$desc = "\n<br />".$item->get_content();
			else
				unset($desc);

			// Style setzen und Item-Absatz starten
			if ($style)
				echo "<p style=\"$style\"";
			else
				echo "<p>";

			// headline
			#echo "<a target=\"_blank\" href=\"$href\" class=\"outerlink\">$title</a>";
			echo $this->Link($href, "", $title, 1, 1);

			if (($time == "yes")&&($date!=0))
				echo " (" .intervalCalc($date) .")";
				#echo $date;
				#echo time();
						
			echo $desc;
			
			// item-paragraph ending
			echo "</p>";
			
			if (($max)&&($current == $max))
				break;
			else
				$current++;
		}
	}
}

if ($divclass) // the new div-way
	echo "</div></div>\n";
else // the taditional fieldset-table-way
	echo "</fieldset>";

?>