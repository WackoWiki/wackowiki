<?php

/* {{ calendar [year=2012|2013...] [month="1|2|..."] [highlight="today|1|2|..."] [daywidth="3"]}} */

/* stylesheet parameters:
	.calendar			(table container class)
	.calendar_month		(month heading format)
	.calendar th		(day of week headings)
	.calendar tr td
*/

if (!isset($year)) $year = '';
if (!isset($month)) $month = '';
if (!isset($highlight)) $highlight = '';
if (!isset($daywidth)) $daywidth = '';
if (!isset($days)) $days = '';


$time			= time();
$current_year	= date('Y', $time);
$current_month	= date('n', $time);
$current_day	= date('j', $time);

if (!$year)
{
	$year = $current_year;
}

if (!$month)
{
	$month = $current_month;
}

if ($highlight == 'today')
{
	$days = array($current_day => array(NULL, NULL, '<span style="color: red; font-weight: bold;">'.$current_day.'</span>'));
}
else if ($highlight)
{
	$days = array($highlight => array(NULL, NULL, '<span style="color: red; font-weight: bold;">'.$highlight.'</span>'));
}

if (!$daywidth)
{
	$daywidth = 3;
}

if (!isset($range))
{
	$range = 1;
}

if (($range > 1) && ($month > 1))
{
	$_range = $range + $month - 1;
}
else if (($range == 1) || ($month > 1))
{
	$_range = $month;
}
else
{
	$_range = $range;
}

if (function_exists('generate_calendar') == false)
{
	function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array())
	{
		$first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
		// remember that mktime will automatically correct if invalid dates are entered
		// for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
		// this provides a built in "rounding" feature to generate_calendar()

		$day_names = array(); // generate all the day names according to the current locale

		for($n = 0, $t = (3 + $first_day) * 86400; $n < 7; $n++, $t+=86400) // January 4, 1970 was a Sunday
		{
			$day_names[$n] = ucfirst(gmstrftime('%A',$t)); // %A means full textual day name
		}

		list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));

		$weekday	= ($weekday + 7 - $first_day) % 7; // adjust for $first_day
		$title		= htmlentities(ucfirst($month_name), ENT_COMPAT | ENT_HTML401, $this->charset).'&nbsp;'.$year;  // note that some locales don't capitalize month and day names

		// Begin calendar. Uses a real <caption>.
		@list($p, $pl) = each($pn);
		@list($n, $nl) = each($pn); // previous and next links, if applicable

		if($p)
		{
			$p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl, ENT_COMPAT | ENT_HTML401, $this->charset).'">'.$p.'</a>' : $p).'</span>&nbsp;';
		}

		if($n)
		{
			$n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl, ENT_COMPAT | ENT_HTML401, $this->charset).'">'.$n.'</a>' : $n).'</span>';
		}
		$calendar = '<table class="calendar">'."\n".
			'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href, ENT_COMPAT | ENT_HTML401, $this->charset).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

		if($day_name_length)
		{
			// if the day names should be shown ($day_name_length > 0)
			// if day_name_length is >3, the full name of the day will be printed
			foreach($day_names as $d)
			{
				$calendar .= '<th abbr="'.htmlentities($d, ENT_COMPAT | ENT_HTML401, $this->charset).'">'.htmlentities(($day_name_length < 4 ? substr($d, 0, $day_name_length) : $d), ENT_COMPAT | ENT_HTML401, $this->charset).'</th>';
			}

			$calendar .= "</tr>\n<tr>";
		}

		if($weekday > 0)
		{
			$calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; // initial 'empty' days
		}

		for($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++)
		{
			if($weekday == 7)
			{
				$weekday   = 0; // start a new week
				$calendar .= "</tr>\n<tr>";
			}

			if(isset($days[$day]) and is_array($days[$day]))
			{
				@list($link, $classes, $content) = $days[$day];

				if(is_null($content))
				{
					$content  = $day;
				}

				$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes, ENT_COMPAT | ENT_HTML401, $this->charset).'">' : '>').
					($link
						? '<a href="'.htmlspecialchars($link, ENT_COMPAT | ENT_HTML401, $this->charset).'">'.$content.'</a>'
						: $content).'</td>';
			}
			else
			{
				$calendar .= "<td>$day</td>";
			}
		}

		if($weekday != 7)
		{
			$calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; // remaining "empty" days
		}

		$calendar .= "</tr>\n</table>\n";

		return $calendar;
	}
}

$oldlocale = setlocale(LC_TIME, NULL); // save current locale
setlocale(LC_TIME, array('de_DE@euro', 'de_DE', 'deu_deu'));

echo "<table style=\"margin: auto\">";
echo "<tr>";



#echo "_range:".$_range."<br />";
#echo "month:".$month;

for($month; $month <= $_range; $month++)
{
		echo "<td style=\"vertical-align: top\">";
		echo generate_calendar($year, $month, $days, $daywidth);

		echo "</td>";

		if($month%3 == 0 and $month < $_range)
		{
			echo "</tr>\n<tr>";
		}
}
echo "</tr>";
echo "</table>";


#echo generate_calendar($year, $month, $days, $daywidth);

setlocale(LC_TIME, $oldlocale);

?>