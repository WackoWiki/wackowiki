<?php

/*
 * scheduler action:
 * https://wackowiki.org/doc/Dev/PatchesHacks/Scheduler
 * modify the script for your needs, please contribute your improvements
 *
 * {{scheduler mode="[day|month|default]"]}}
 *
 * requires scheduler table in MySQL-Database
 * uses 2022-01-01 format
 */

$prefix = $this->prefix;

$create_table = function() use ($prefix)
{
	$this->db->sql_query(
		"CREATE TABLE IF NOT EXISTS {$prefix}scheduler (
			scheduler_id INT(10) NOT NULL AUTO_INCREMENT,
			user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			date VARCHAR(10) NOT NULL DEFAULT '',
			schedule TEXT,
		PRIMARY KEY (scheduler_id),
		KEY idx_user_id (user_id),
		KEY idx_date (date)
		UNIQUE KEY idx_time (user_id, date);
	);");
};

// FIXME: leading zero patch
$zero_prefix = function($string)
{
	return
		(in_array($string, range(1, 9))
			? '0'
			: '') .
		$string;
};

$weekdays = function($pattern = 'EEEE'): array
{
	$formatter = new IntlDateFormatter(
		$this->get_user()['user_lang'] ?? $this->lang['locale'],
		IntlDateFormatter::NONE,
		IntlDateFormatter::NONE,
		'UTC',
		IntlDateFormatter::GREGORIAN,
		$pattern
	);

	$days = array_map(
		function($dow) use ($formatter) {
			return $formatter->format(strtotime('next Sunday +' . $dow . ' days'));
		},
		[2, 3, 4, 5, 6, 7, 1] #range(1, 7)
	);

	return $days;
};

$months = function($pattern = 'MMMM')
{
	$formatter = \IntlDateFormatter::create(
		$this->get_user()['user_lang'] ?? $this->lang['locale'],
		\IntlDateFormatter::LONG,
		\IntlDateFormatter::NONE,
		'UTC',
		\IntlDateFormatter::GREGORIAN,
		$pattern
	);

	$months = array_map(
		function($m) use ($formatter){
			return $formatter->format(mktime(0, 0, 0, $m, 2, 1970));
		},
		range(1, 12)
	);

	return $months;
};

// get the last day of the month
$get_last_day_of_month	= function ($mon, $year)
{
	for ($tday = 28; $tday <= 31; $tday++)
	{
		$tdate = getdate(mktime(0, 0, 0, $mon, $tday, $year));

		if ($tdate['mon'] != $mon) break;
	}

	$tday--;
	return $tday;
};

$mode_month		= 'month';
$mode_day		= 'day';
$mode_default	= 'default';
$mod_selector	= 'mode';
$today_date		= date('Y-m-d', time());

$mode			= $_GET[$mod_selector]	?? $mode_default;
$date			= $_GET['date']			?? date('Y-m-d', time());

if ($date && !$this->validate_date($date))
{
	$date = date('Y-m-d', time());
}

[$year, $month, $day] = explode('-', $date);

// check for table
# $create_table();

// navigation
$tabs	= [
	'default'	=> 'SchedMonthlyView',
	'day'		=> 'SchedDailyView',
	'week'		=> 'SchedWeeklyView',
	'month'		=> 'SchedMonthlyCalendar',
];

if (!array_key_exists($mode, $tabs))
{
	$mode = '';
}

// print navigation
$tpl->tabs		= $this->tab_menu($tabs, $mode, '', ['date' => $date], $mod_selector);
$tpl->mode		= $mode;

// $month_name = $month;
$last_day		= $get_last_day_of_month($month, $year);
$tmpd			= getdate(mktime(0, 0, 0, $month, 1, $year));
#$month_name		= $tmpd['month'];
$firstw_day		= $tmpd['wday'];

	$month_loc		= $months();
	$month_name		= $month_loc[(int) $month - 1];

	$display_date	= $day . '. ' . $month_name . ' ' . $year . ':';

$user_name		= $this->get_user_name();
$user_id		= $this->get_user_id();

$schedule		= $_POST['schedule'] ?? '';

if (isset($_POST['save']))
{
	// added to delete the empty schedule
	$this->db->sql_query(
		"DELETE
		FROM {$prefix}scheduler
		WHERE schedule = ''");

	// insert / update
	$this->db->sql_query(
		"INSERT INTO {$prefix}scheduler (
			user_id,
			schedule,
			date
		)
		VALUES (" .
			(int) $user_id . ", " .
			$this->db->q($schedule) . ", " .
			$this->db->q($date) . "
		)
		ON DUPLICATE KEY UPDATE
			user_id		= VALUES(user_id),
			date		= VALUES(date),
			schedule	= VALUES(schedule)");
}
// end

// OUTPUT
$result = $this->db->load_single(
	"SELECT schedule
	FROM {$prefix}scheduler
	WHERE user_id	= '" . (int) $user_id . "'
		AND date	= " . $this->db->q($date) . "");

$schedule	= $result['schedule'] ?? '';

// dates
$prev_day		= $year . '-' . $month . '-' . $zero_prefix(((($day - 1) < 1) ? $last_day : $day - 1));
$next_day		= $year . '-' . $month . '-' . $zero_prefix(((($day + 1) > $last_day) ? 1 : $day + 1));

$prev_week		= $year . '-' . $month . '-' . $zero_prefix(((($day - 1) < 1) ? $last_day : $day - 7));
$next_week		= $year . '-' . $month . '-' . $zero_prefix(((($day + 1) > $last_day) ? 1 : $day + 7));

$prev_month		= ((($month - 1) <  1) ? $year - 1 : $year) . '-' . $zero_prefix(((($month - 1) <  1) ? 12 : $month - 1)) . '-' . $day;
$next_month		= ((($month + 1) > 12) ? $year + 1 : $year) . '-' . $zero_prefix(((($month + 1) > 12) ?  1 : $month + 1)) . '-' . $day;

// href
$href_prev_day		= $this->href('', '', ['mode' => $mode, 'date' => $prev_day]);
$href_next_day		= $this->href('', '', ['mode' => $mode, 'date' => $next_day]);

$href_prev_week		= $this->href('', '', ['mode' => $mode, 'date' => $prev_week]);
$href_next_week		= $this->href('', '', ['mode' => $mode, 'date' => $next_week]);

$href_prev_month	= $this->href('', '', ['mode' => $mode, 'date' => $prev_month]);
$href_next_month	= $this->href('', '', ['mode' => $mode, 'date' => $next_month]);

if(!$user_id)
{
	$tpl->mustlogin = true;
}
else if ($mode == 'day')
{
	$tpl->enter('day_');
	$printout		= str_replace("\n", '<hr></td></tr><tr align="left"><td>', $schedule);
	$print_owner	= $user_name . ' ' . $this->_t('SchedLabel');

	$tpl->prevday	= $href_prev_day;
	$tpl->nextday	= $href_next_day;
	$tpl->label		= $print_owner . ' ' . $display_date;

	if ($user = $this->get_user())
	{
		$tpl->tasks = $printout ?: $this->_t('SchedNoEntries');
	}

	$tpl->leave(); // day_
}
// TODO: add week mode & tab
else if ($mode == 'month')
{
	$tpl->enter('month_');

	// get what weekday the first is on

	$tpl->prevmonth	= $href_prev_month;
	$tpl->nextmonth	= $href_next_month;
	$tpl->label		= $user_name . ' ' . $this->_t('SchedCalendarLabel') . ' ' . $month_name . ' ' . $year;

	foreach ($weekdays() as $weekday)
	{
		$tpl->n_weekday	= $weekday;
	}

	// shift one left circular, now we calculate with 1..7
	if ($firstw_day == 0)
	{
		$firstw_day = 7;
	}

	//$firstw_day = (($firstw_day + 7) % 7);
	$wday			= $firstw_day;
	$first_week		= true;
	$_day			= 1;

	// code to determine what data should be entered into each cell
	$results = $this->db->load_all(
		"SELECT date, schedule
		FROM {$prefix}scheduler
		WHERE user_id	= '" . (int) $user_id . "'
			AND date	>= " . $this->db->q($year . '-' . $month .     '-' . '01') . "
			AND date	<  " . $this->db->q($year . '-' . $zero_prefix($month + 1) . '-' . '01') . " ");

	foreach ($results as $record)
	{
		$result[$record['date']] = $record['schedule'];
	}

	$tpl->enter('d_');

	// loop through all the days of the month
	while ($_day <= $last_day)
	{
		// set up blank days for first week
		if ($first_week)
		{
			$tpl->first = true;

			// firstw_day contains the starting day of the current month
			for ($i = 1; $i < $firstw_day; $i++)
			{
				$tpl->first_b_n = true;
			}

			$first_week = false;
		}

		// check for event
		$tag		= $year . '-' . $month . '-' . $_day;

		if ($tag == $today_date)
		{
			$style1	= '<span style="color: #FF0000"><b>';
			$style2	= '</b></span>';
			$token	= true;
		}
		else
		{
			$style1	= '';
			$style2	= '';
			$token	= false;
		}

		$dayoutput	= $result[$tag] ?? '';
		// replace <some text>@...\n with <some text> \n
		$dayoutput	= preg_replace("/(.*?\w+?.*?)@(.*?)\n+?/", "$1\n", $dayoutput);
		// replace @...\n with nothing
		$dayoutput	= preg_replace("/(.*?)@(.*?)\n/", "", $dayoutput);
		$dayoutput	= preg_replace("/(.*?)@(.*)/", "$1", $dayoutput);
		// replace <newline> with <br>
		$dayoutput	= str_replace("\n", "<br>", $dayoutput);

		if ($token)
		{
			# $printme = '<a href="' . $this->href('', '', ['mode' => $mode_day, 'date' => $date, '#' => 'entry-box']) . '"><small>[Print Day]</small></a>';
		}
		else
		{
			$printme = '';
		}

		$tpl->href			= $this->href('', '', ['date' => $date, '#' => 'entry-box']);
		$tpl->day			= $style1 . $_day . $style2 ;
		$tpl->print			= $printme;
		$tpl->schedule		= $dayoutput;

		// nn Monday (0) start a new row
		if ($wday == 1)
		{
			$tpl->tr2 = true;
		}

		// Sunday -> next row
		if ($wday == 7)
		{
			$tpl->etr = true;
		}

		$wday = ($wday % 7) + 1;
		$_day++;
	}

	$tpl->leave(); // d_

	$tpl->prevday		= $href_prev_day;
	$tpl->nextday		= $href_next_day;
	$tpl->dlabel		= $user_name . ' ' . $this->_t('SchedDayLabel') . ' ' . $display_date;

	$tpl->form_href		= $this->href('', '', ['mode' => $mode_month, 'date' => $date]);
	$tpl->form_schedule	= $schedule;
	$tpl->form_cols		= 90;
	$tpl->form_rows		= 10;

	$tpl->leave(); // month_
}
else if ($mode == 'default')
{
	$tpl->enter('default_');

	$tpl->month		= $month_name . ' ' . $year;
	$tpl->prevmonth	= $href_prev_month;
	$tpl->nextmonth	= $href_next_month;

	foreach ($weekdays('EEEEEE') as $weekday)
	{
		$tpl->n_weekday	= $weekday;
	}

	// shift one left circular, now we calculate with 1..7
	if ($firstw_day == 0)
	{
		$firstw_day = 7;
	}

	$wday			= $firstw_day;
	$first_week		= true;
	$_day			= 1;

	$tpl->enter('d_');

	// loop through all the days of the month
	while ($_day <= $last_day)
	{
		// set up blank days for first week
		if ($first_week)
		{
			$tpl->first = true;

			for ($i = 1; $i < $firstw_day; $i++)
			{
				$tpl->first_b_n = true;
			}

			$first_week = false;
		}

		// check for event
		$tag		= $year . '-' . $month . '-' . $_day;

		if ($tag == $today_date)
		{
			$style1 = '<span style="color: #FF0000"><b>';
			$style2 = '</b></span>';
		}
		else
		{
			$style1 = '';
			$style2 = '';
		}

		$tpl->href		= $this->href('', '', ['date' => $year . '-' . $month . '-' . $_day]);
		$tpl->day		= $style1 . $_day . $style2;

		// Sunday start week with <tr>
		if ($wday == 1)
		{
			$tpl->tr2	= true;
		}

		// Sunday week with </tr>
		if ($wday == 7)
		{
			$tpl->etr	= true;
		}

		$wday = ($wday % 7) + 1;
		$_day++;
	}

	$tpl->leave(); // d_

	$tpl->enter('f_');

	// title over textarea box
	$print_owner		= $user_name . ' ' . $this->_t('SchedLabel');

	$tpl->label			= $print_owner . ' ' . $display_date;
	$tpl->prevday		= $href_prev_day;
	$tpl->nextday		= $href_next_day;

	$tpl->form_href		= $this->href('', '', ['mode' => $mode_default, 'date' => $date]);
	$tpl->form_schedule	= $schedule;
	$tpl->form_cols		= 65;
	$tpl->form_rows		= 12;

	$tpl->leave(); // f_
	$tpl->leave(); // default_
}
