<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	System Log											##
##########################################################
$_mode = 'system_log';

$module[$_mode] = [
		'order'	=> 140,
		'cat'	=> 'basics',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_system_log(&$engine, &$module)
{
	# $whois = 'https://www.db.ripe.net/whois?searchtext=';
?>
	<h1><?php echo $engine->_t($module['mode'])['title']; ?></h1>
<?php
	if (isset($_POST['reset']))
	{
		$engine->http->redirect($engine->href());
	}

	if (@$_POST['action'] == 'purge_log')
	{
		$sql = "TRUNCATE " . $engine->db->table_prefix . "log";
		$engine->db->sql_query($sql);

		// queries
		$engine->config->invalidate_sql_cache();
	}

	if (isset($_POST['update']) || isset($_GET['level_mod']))
	{
		$_level_mod	= (int) ($_POST['level_mod']	?? ($_GET['level_mod']	?? ''));
		$_level		= (int) ($_POST['level']		?? ($_GET['level']		?? ''));

		// level filtering
		$mod = match ($_level_mod) {
			1 => '<=',	// not_lower
			2 => '>=',	// not_higher
			3 => '=',	// equal
		};

		$where = "WHERE l.level " . $mod . " " . (int) $_level . " ";
	}

	$_order			= (string)	($_GET['order']		?? '');
	$_level			= (int)		($_GET['level']		?? ($_POST['level']		?? ''));
	$_level_mod		= (int)		($_GET['level_mod']	?? ($_POST['level_mod']	?? ''));
	$_ip			= (string)	($_GET['ip']		?? '');
	$_user_id		= (int)		($_GET['user_id']	?? '');

	// we make level sorting in reverse order because higher level is denoted
	// by lower value (e.g. 1 = critical, 2 = highest, and so on)
	$order = match($_order) {
		'time_asc'		=> 'l.log_time ASC ',
		'time_desc'		=> 'l.log_time DESC ',
		'level_asc'		=> 'l.level DESC ',
		'level_desc'	=> 'l.level ASC ',
		default			=> 'l.log_id DESC ',
	};

	// set time ordering
	$order_time = match($_order) {
		'time_asc'		=> 'time_desc',
		default			=> 'time_asc',
	};

	// set level ordering
	$order_level = match($_order) {
		'level_asc'		=> 'level_desc',
		default			=> 'level_asc',
	};

	// filter by username or user ip
	if ($_user_id)
	{
		$where = "WHERE l.user_id = " . (int) $_user_id . " ";
	}
	else if ($_ip)
	{
		$where = "WHERE l.ip = " . $engine->db->q($_ip) . " ";
	}

	// entries to display
	$limit = 100;

	// set default level
	$level	??= $engine->db->log_default_show;
	$where	??= '';

	// collecting data
	$count = $engine->db->load_single(
		"SELECT COUNT(log_id) AS n " .
		"FROM " . $engine->db->table_prefix . "log l " .
		($where ?: 'WHERE level <= ' . (int) $level . ' '));

	$order_pagination		= !empty($_order)		? ['order' => Ut::html($_order)] : [];
	$level_pagination		= !empty($_level)		? ['level' => (int) $_level] : [];
	$level_mod_pagination	= !empty($_level_mod)	? ['level_mod' => (int) $_level_mod] : [];

	$pagination				= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination + $level_pagination + $level_mod_pagination, '', 'admin.php');

	$log = $engine->db->load_all(
		"SELECT l.log_id, l.log_time, l.level, l.user_id, l.message, u.user_name, l.ip " .
		"FROM " . $engine->db->table_prefix . "log l " .
			"LEFT JOIN " . $engine->db->table_prefix . "user u ON (l.user_id = u.user_id) " .
		($where ?: 'WHERE l.level <= ' . (int) $level . ' ') .
		"ORDER BY " . $order .
		$pagination['limit']);

	echo $engine->form_open('systemlog');
?>
		<div>
			<h4><?php echo $engine->_t('LogFilterTip'); ?></h4><br>
			<?php echo $engine->_t('LogLevel'); ?>
			<select name="level_mod">
			<?php
				$log_filters = $engine->_t('LogLevelFilters');

				foreach ($log_filters as $mode => $log_filter)
				{
					$selected =
						($mode === 1
							? (!isset($_POST['level_mod']) || (int) @$_POST['level_mod'] == $mode)
							: ((int) ($_POST['level_mod'] ?? $_GET['level_mod'] ?? '') == $mode)
					);

					echo
						'<option value="' . $mode . '" ' . ($selected ? ' selected' : '') . '>' .
							$log_filter .
						'</option>' . "\n";
				}
			?>
			</select>
			<select name="level">
			<?php
				$log_levels = $engine->_t('LogLevels');

				foreach ($log_levels as $mode => $log_level)
				{
					$selected =
						(	!isset($_POST['level']) && (int) $level == $mode)
						|| ((int) ($_POST['level'] ?? $_GET['level'] ?? '') == $mode);

					echo
						'<option value="' . $mode . '" ' . ($selected ? ' selected' : '') . '>' .
							$mode . ': ' . $log_level .
						'</option>' . "\n";
				}
			?>
			</select>

			<button type="submit" name="update" id="submit"><?php echo $engine->_t('UpdateButton');?></button>
			<button type="submit" name="reset" id="submit"><?php echo $engine->_t('ResetButton');?></button>

<?php
		$engine->print_pagination($pagination);
?>
		<table class="syslog formation lined">
			<tr>
				<th>ID</th>
				<th><a href="<?php echo $engine->href('', '', ['order' => $order_time]); ?>"><?php echo $engine->_t('LogDate'); ?></a></th>
				<th><a href="<?php echo $engine->href('', '', ['order' => $order_level]); ?>"><?php echo $engine->_t('LogLevel'); ?></a></th>
				<th><?php echo $engine->_t('LogEvent'); ?></th>
				<th><?php echo $engine->_t('LogUsername'); ?></th>
			</tr>
<?php
	if ($log)
	{
		foreach ($log as $row)
		{
			// level highlighting
			$row['level'] = match((int) $row['level']) {
				1		=> '<strong class="red">' . $engine->_t('LogLevels')[1] . '</strong>',
				2		=> '<span class="red">' . $engine->_t('LogLevels')[2] . '</span>',
				3		=> '<strong>' . $engine->_t('LogLevels')[3] . '</strong>',
				4		=> $engine->_t('LogLevels')[$row['level']],
				5		=> '<small>' . $engine->_t('LogLevels')[$row['level']] . '</small>',
				6, 7	=> '<small class="grey">' . $engine->_t('LogLevels')[$row['level']] . '</small>',
			};

			// tz offset
			$time_tz = $engine->sql2precisetime($row['log_time']);

			echo
				'<tr>' . "\n" .
					'<td>' . $row['log_id'] . '</td>' .
					'<td><small>' . $time_tz . '</small></td>' .
					'<td>' . $row['level'] . '</td>' .
					'<td>' . $engine->format($row['message'], 'post_wacko') . '</td>' .
					'<td><small>' .
						'<a href="' . $engine->href('', '', ['user_id' => $row['user_id']]) . '">' . ($row['user_id'] == 0 ? '<em>' . $engine->_t('Guest') . '</em>' : $row['user_name'] ) . '</a>' . '<br>' .
						'<a href="' . $engine->href('', '', ['ip' => $row['ip']]) . '">' . $row['ip'] . '</a>' .
					'</small></td>' .
				'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="5"><br><em>' . $engine->_t('LogNoMatch') . '</em></td></tr>';
	}
?>
		</table>
<?php
	$engine->print_pagination($pagination);
}
