<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* {{calendar
		[year=2012|2013...] 		- year to display
		[month=1|2|...]				- month to display
		[highlight=today|1|2|...]	- date to highlight
		[daywidth=3]				- length of weekday name
		[range=1|2|...]				- number of month displayed starting with "month to display" parameter
		[firstday=0|1]				- week satrts on: 0 - Sunday, 1 - Monday
  }}
 */

/* stylesheet parameters:
	.calendar			(table container class)
	.calendar-month		(month heading format)
	.calendar th		(day of week headings)
	.calendar td
	.calendar-hl		(highlight)
*/

if (!isset($year))		$year		= '';
if (!isset($month))		$month		= '';
if (!isset($days))		$days		= '';
if (!isset($daywidth))	$daywidth	= '';
if (!isset($range))		$range		= 1;
if (!isset($firstday))	$firstday	= 1;
if (!isset($highlight))	$highlight	= 'today';

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

// TODO: missing context -> year, month
if ($highlight == 'today')
{
	$days = [$current_day => [null, null, $current_day]];
}
else if ($highlight)
{
	$days = [$highlight => [null, null, $highlight]];
}

if (!$daywidth)
{
	$daywidth = 2;
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

$generate_calendar = function ($year, $month, $days = [], $day_name_length = 3, $month_href = null, $first_day = 0, $pn = []) use (&$tpl)
{
	$first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
	// remember that mktime will automatically correct if invalid dates are entered
	// for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
	// this provides a built in "rounding" feature to generate_calendar()

	$day_names = []; // generate all the day names according to the current locale

	$day_pattern = ($day_name_length == 2
		? "cccccc"	// cccccc - 2-letter textual day name
		: "ccc");	// ccc    - 3-letter textual day name, see https://unicode-org.github.io/icu/userguide/format_parse/datetime/

	$fmt = new IntlDateFormatter($this->language['locale'], IntlDateFormatter::FULL, IntlDateFormatter::FULL, null, null, $day_pattern);

	for ($n = 0, $t = (3 + $first_day) * DAYSECS; $n < 7; $n++, $t += DAYSECS) // January 4, 1970 was a Sunday
	{
		$day_names[$n] = utf8_ucfirst($fmt->format($t));
	}

	$fmt = new IntlDateFormatter($this->language['locale'], IntlDateFormatter::FULL, IntlDateFormatter::FULL, null, null, "MM,yyyy,LLLL");
	[$month, $year, $month_name]	= explode(',', $fmt->format($first_of_month));
	$weekday						= date('w', $first_of_month);

	$weekday	= ($weekday + 7 - $first_day) % 7; // adjust for $first_day
	$title		= Ut::html(utf8_ucfirst($month_name)) . NBSP . $year;
	// begin calendar

	// TODO: fix navigation array handling
	@[$prev, $pl] = $pn;
	@[$next, $nl] = $pn; // previous and next links, if applicable

	if ($prev)
	{
		$tpl->p_text	= ($pl ? '<a href="' . Ut::html($pl) . '">' . $prev . '</a>' : $prev);
		$tpl->p_class	= 'calendar-prev';
	}

	if ($next)
	{
		$tpl->n_text	= ($nl ? '<a href="' . Ut::html($nl) . '">' . $next . '</a>' : $next);
		$tpl->n_class	= 'calendar-next';
	}

	$tpl->title		= ($month_href ? '<a href="' . Ut::html($month_href) . '">' . $title . '</a>' : $title);
	$tpl->href		= $month_href;
	$tpl->prev		= $prev;
	$tpl->next		= $next;

	if ($day_name_length)
	{
		// if the day names should be shown ($day_name_length > 0)
		// if day_name_length is > 3, the full name of the day will be printed
		foreach ($day_names as $d)
		{
			$tpl->h_abbr	= $d;
			$tpl->h_day		= $day_name_length < 4 ? mb_substr($d, 0, $day_name_length) : $d;
		}
	}

	if ($weekday > 0)
	{
		$tpl->first_colspan	= $weekday; // initial 'empty' days
	}

	$tpl->enter('d_');

	for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++)
	{
		if (isset($days[$day]) && is_array($days[$day]))
		{
			[$link, $classes, $content] = $days[$day];

			if (is_null($content))
			{
				$content = $day;
			}

			$tpl->class		= $classes ? ' class="' . Ut::html($classes) . '"' : '';
			$content		= ($link ? '<a href="' . Ut::html($link) . '">' . $content . '</a>' : $content);
			$tpl->content	= '<span class="calendar-hl">' . $content . '</span>';
		}
		else
		{
			$tpl->content = $day;
		}

		if ($weekday == 7)
		{
			$weekday	= 0; // start a new week
			$tpl->next	= true;
		}
	}

	$tpl->leave();	//	d_

	if ($weekday != 7)
	{
		$tpl->last_colspan	= (7 - $weekday); // remaining "empty" days
	}
};

$save	= $this->set_language($this->user_lang, true);
$n		= 1;

for ($month; $month <= $_range; $month++)
{
	$tpl->enter('m_month_');

	$generate_calendar($year, $month, $days, $daywidth, null, $firstday, []);
	$days = []; // reset highlight array as we highlight only once per range

	if ($n % 3 == 0 && $month < $_range)
	{
		$tpl->next = true;
	}

	$tpl->leave();	//	m_month_
	$n++;
}

$this->set_language($save, true);
