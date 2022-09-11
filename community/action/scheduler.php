
<?php

/*
 * scheduler action:
 * https://wackowiki.org/doc/Dev/PatchesHacks/Scheduler
 * modify the script for your needs, please conribute your improvements
 *
 * {{scheduler mode="[day|month|default]"]}}
 *
 * requires scheduler table in MySQL-Database
 */

$prefix			= $this->prefix;

$create_table = function() use ($prefix)
{
	$this->db->sql_query(
		"CREATE TABLE wacko_scheduler (
			scheduler_id INT(10) NOT NULL AUTO_INCREMENT,
			user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
			day TINYINT(2) NOT NULL DEFAULT '0',
			month TINYINT(2) NOT NULL DEFAULT '0',
			year MEDIUMINT(4) NOT NULL DEFAULT '0',
			schedule TEXT,
		PRIMARY KEY (scheduler_id),
		KEY idx_user_id (user_id)
	);");
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

$mode			= $_GET[$mod_selector]	?? $mode_default;
$year			= $_GET['year']			?? date('Y', time());
$month			= $_GET['month']		?? date('m', time());
$today			= $_GET['day']			?? date('d', time());


// navigation
$tabs	= [
			'default'	=> 'SchedMonthlyView',
			'day'		=> 'SchedDailyView',
			'month'		=> 'SchedMonthlyCalendar',
		];

if (!array_key_exists($mode, $tabs))
{
	$mode = '';
}

// print navigation
$tpl->tabs		= $this->tab_menu($tabs, $mode, '', ['month' => $month, 'day' => $today, 'year' => $year], $mod_selector);
$tpl->mode		= $mode;

// $monthname = $month;
$lastday		= $get_last_day_of_month($month, $year);
$tmpd			= getdate(mktime(0, 0, 0, $month, 1, $year));
#$monthname		= $tmpd['month'];
$firstwday		= $tmpd['wday'];

	$month_loc		= $months();
	$monthname		= $month_loc[(int) $month - 1];

	$display_date	= $today . '. ' . $monthname . ' ' . $year . ':';

$username		= $this->get_user_name();
$user_id		= $this->get_user_id();

$schedule		= $_POST['schedule'] ?? '';

if (isset($_POST['save']))
{
	$update			= 0;

	$result = $this->db->load_single(
		"SELECT scheduler_id
		FROM {$prefix}scheduler
		WHERE user_id	= '" . (int) $user_id . "'
			AND day		= '" . (int) $today . "'
			AND month	= '" . (int) $month . "'
			AND year	= '" . (int) $year . "'");

	// added to delete the empty schedule
	$this->db->sql_query(
		"DELETE
		FROM {$prefix}scheduler
		WHERE schedule = ''");

	if (!empty($result['scheduler_id']))
	{
		$update			= 1;
		$scheduler_id	= $result['scheduler_id'];
	}

	if ($update)
	{
		$this->db->sql_query(
			"UPDATE {$prefix}scheduler SET
				schedule = " . $this->db->q($schedule) . "
			WHERE user_id = '" . (int) $user_id . "'
				AND scheduler_id = '" . (int) $scheduler_id . "'");
	}
	else
	{
		$this->db->sql_query(
			"INSERT INTO {$prefix}scheduler (
				user_id,
				schedule,
				month,
				day,
				year
			)
			VALUES (" .
				(int) $user_id . ", " .
				$this->db->q($schedule) . ", " .
				(int) $month . ", " .
				(int) $today . ", " .
				(int) $year . "
			)");
	}
}
// end

// OUTPUT
$result = $this->db->load_single(
	"SELECT schedule
	FROM {$prefix}scheduler
	WHERE user_id	= '" . (int) $user_id . "'
		AND day		= '" . (int) $today . "'
		AND month	= '" . (int) $month . "'
		AND year	= '" . (int) $year . "'");

$schedule	= $result['schedule'] ?? '';

$href_prev_day		= $this->href('', '', ['mode' => $mode, 'day' => (($today - 1) < 1) ? $lastday : $today - 1, 'year' => $year, 'month' => $month]);
$href_next_day		= $this->href('', '', ['mode' => $mode, 'day' => (($today + 1) > $lastday) ? 1 : $today + 1, 'year' => $year, 'month' => $month]);
$href_prev_month	= $this->href('', '', ['mode' => $mode, 'month' => (($month - 1) < 1) ? 12 : $month - 1, 'year' => (($month - 1) < 1) ? $year - 1 : $year]);
$href_next_month	= $this->href('', '', ['mode' => $mode, 'month' => (($month + 1) > 12) ? 1 : $month + 1, 'year' => (($month + 1) > 12) ? $year + 1 : $year]);

if ($mode == 'day')
{
	$tpl->enter('day_');
	$printout		= str_replace("\n", '<hr></td></tr><tr align="left"><td>', $schedule);
	$printowner		= $username . ' ' . $this->_t('SchedLabel');

	$tpl->prevday	= $href_prev_day;
	$tpl->nextday	= $href_next_day;
	$tpl->label		= $printowner . ' ' . $display_date;

	if ($user = $this->get_user())
	{
		$tpl->tasks = $printout ?: $this->_t('SchedNoEntries');
	}

	$tpl->leave(); // day_
}
else if ($mode == 'month')
{
	$tpl->enter('month_');

	// get what weekday the first is on

	$tpl->prevmonth	= $href_prev_month;
	$tpl->nextmonth	= $href_next_month;
	$tpl->label		= $username . ' ' . $this->_t('SchedCalendarLabel') . ' ' . $monthname . ' ' . $year;

	foreach ($weekdays() as $weekday)
	{
		$tpl->n_weekday	= $weekday;
	}

	//shift one left circular, now we calculate with 1..7
	if ($firstwday == 0)
	{
		$firstwday = 7;
	}

	//$firstwday = (($firstwday + 7) % 7);
	$wday			= $firstwday;
	$firstweek		= true;
	$day			= 1;

	$tpl->enter('d_');

	// loop through all the days of the month
	while ($day <= $lastday)
	{
		// set up blank days for first week
		if ($firstweek)
		{
			$tpl->first = true;

			// firstwday contains the starting day of the current month
			for ($i = 1; $i < $firstwday; $i++)
			{
				$tpl->first_b_n = true;
			}

			$firstweek = false;
		}

		// check for event
		$tag		= $year . ':' . $month . ':' . $day;
		$todaydate	= date('Y:m:d', time());

		if ($tag == $todaydate)
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

		// code to determine what data should be entered into each cell
		$result = $this->db->load_single(
			"SELECT schedule
			FROM {$prefix}scheduler
			WHERE user_id	= '" . (int) $user_id . "'
				AND day		= '" . (int) $day . "'
				AND month	= '" . (int) $month . "'
				AND year	= '" . (int) $year . "'");

		$dayoutput	= $result['schedule'] ?? '';
		// replace <some text>@...\n with <some text> \n
		$dayoutput	= preg_replace("/(.*?\w+?.*?)@(.*?)\n+?/", "$1\n", $dayoutput);
		// replace @...\n with nothing
		$dayoutput	= preg_replace("/(.*?)@(.*?)\n/", "", $dayoutput);
		$dayoutput	= preg_replace("/(.*?)@(.*)/", "$1", $dayoutput);
		// replace <newline> with <br>
		$dayoutput	= str_replace("\n", "<br>", $dayoutput);

		if ($token)
		{
			# $printme = '<a href="' . $this->href('', '', ['mode' => $mode_day, 'day' => $day, 'month' => $month, 'year' => $year, '#' => 'entry-box']) . '"><small>[Print Day]</small></a>';
		}
		else
		{
			$printme = '';
		}

		$tpl->href			= $this->href('', '', ['day' => $day, 'month' => $month, 'year' => $year, '#' => 'entry-box']);
		$tpl->day			= $style1 . $day . $style2 ;
		$tpl->print			= $printme;
		$tpl->schedule	= $dayoutput;

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
		$day++;
	}

	$tpl->leave(); // d_

	$tpl->prevday		= $href_prev_day;
	$tpl->nextday		= $href_next_day;
	$tpl->dlabel		= $username . ' ' . $this->_t('SchedDayLabel') . ' ' . $display_date;

	$tpl->hrefform		= $this->href('', '', ['mode' => $mode_month, 'month' => $month, 'day' => $today, 'year' => $year]);
	$tpl->schedule		= $schedule;

	$tpl->leave(); // month_
}
else if ($mode == 'default')
{
	$tpl->enter('default_');

	$tpl->month		= $monthname . ' ' . $year;
	$tpl->prevmonth	= $href_prev_month;
	$tpl->nextmonth	= $href_next_month;

	foreach ($weekdays('EEEEEE') as $weekday)
	{
		$tpl->n_weekday	= $weekday;
	}


	//shift one left circular, now we calculate with 1..7
	if ($firstwday == 0)
	{
		$firstwday = 7;
	}

	$wday			= $firstwday;
	$firstweek		= true;
	$day			= 1;

	$tpl->enter('d_');

	// loop through all the days of the month
	while ($day <= $lastday)
	{
		// set up blank days for first week
		if ($firstweek)
		{
			$tpl->first = true;

			for ($i = 1; $i < $firstwday; $i++)
			{
				$tpl->first_b_n = true;
			}

			$firstweek = false;
		}

		// check for event
		$tag		= $year . ':' . $month . ':' . $day;
		$todaydate	= date('Y:m:d', time());

		if ($tag == $todaydate)
		{
			$style1 = '<span style="color: #FF0000"><b>';
			$style2 = '</b></span>';
		}
		else
		{
			$style1 = '';
			$style2 = '';
		}

		$tpl->href		= $this->href('', '', ['day' => $day, 'month' => $month, 'year' => $year]);
		$tpl->day		= $style1 . $day . $style2;

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
		$day++;
	}

	$tpl->leave(); // d_

	$tpl->enter('f_');

	// title over textarea box
	$printowner			= $username . ' ' . $this->_t('SchedLabel');

	$tpl->label			= $printowner . ' ' . $display_date;
	$tpl->prevday		= $href_prev_day;
	$tpl->nextday		= $href_next_day;

	$tpl->hrefform		= $this->href('', '', ['mode' => $mode_default, 'month' => $month, 'day' => $today, 'year' => $year]);
	$tpl->schedule		= $schedule;

	$tpl->leave(); // f_
	$tpl->leave(); // default_
}
else
{
	$tpl->mustlogin = true;
}

