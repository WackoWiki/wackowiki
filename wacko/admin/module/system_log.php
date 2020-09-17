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
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// System log
		'title'	=> $engine->_t($_mode)['title'],	// Log system events
	];

##########################################################

function admin_system_log(&$engine, &$module)
{
	$whois = 'https://www.db.ripe.net/whois?searchtext=';
?>
	<h1><?php echo $module['title']; ?></h1>
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
		switch ($_level_mod)
		{
			case 1:
				$mod = '<=';	// not_lower
				break;
			case 2:
				$mod = '>=';	// not_higher
				break;
			case 3:
				$mod = '=';		// equal
				break;
		}

		$where = "WHERE l.level " . $mod . " " . (int) $_level . " ";
	}

	$_order			= (string)	($_GET['order']		?? '');
	$_level			= (int)		($_GET['level']		?? ($_POST['level']		?? ''));
	$_level_mod		= (int)		($_GET['level_mod']	?? ($_POST['level_mod']	?? ''));
	$_ip			= (string)	($_GET['ip']		?? '');
	$_user_id		= (int)		($_GET['user_id']	?? '');

	// set time ordering
	if ($_order == 'time_asc')
	{
		$order		= 'ORDER BY l.log_time ASC ';
		$ordertime	= 'time_desc';
	}
	else if ($_order == 'time_desc')
	{
		$order		= 'ORDER BY l.log_time DESC ';
		$ordertime	= 'time_asc';
	}
	else
	{
		$ordertime	= 'time_asc';
	}

	// set level ordering
	if ($_order == 'level_asc')
	{
		$order		= 'ORDER BY l.level DESC ';		// we make level sorting
		$orderlevel	= 'level_desc';					// in reverse orber because
	}												// higher level is denoted
	else if ($_order == 'level_desc')				// by lower value (e.g.
	{												// 1 = critical, 2 = highest,
		$order		= 'ORDER BY l.level ASC ';		// and so on)
		$orderlevel	= 'level_asc';
	}
	else
	{
		$orderlevel	= 'level_desc';
	}

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
	if (!isset($level)) $level = $engine->db->log_default_show;
	if (!isset($where)) $where = '';
	if (!isset($order)) $order = '';

	// collecting data
	$count = $engine->db->load_single(
		"SELECT COUNT(log_id) AS n " .
		"FROM " . $engine->db->table_prefix . "log l " .
		( $where ?: 'WHERE level <= ' . (int) $level . ' ' ));

	$order_pagination		= !empty($_order)		? ['order' => Ut::html($_order)] : [];
	$level_pagination		= !empty($_level)		? ['level' => (int) $_level] : [];
	$level_mod_pagination	= !empty($_level_mod)	? ['level_mod' => (int) $_level_mod] : [];

	$pagination				= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination + $level_pagination + $level_mod_pagination, '', 'admin.php');

	$log = $engine->db->load_all(
		"SELECT l.log_id, l.log_time, l.level, l.user_id, l.message, u.user_name, l.ip " .
		"FROM " . $engine->db->table_prefix . "log l " .
			"LEFT JOIN " . $engine->db->table_prefix . "user u ON (l.user_id = u.user_id) " .
		( $where ?: 'WHERE l.level <= ' . (int) $level . ' ' ) .
		( $order ?: 'ORDER BY l.log_id DESC ' ) .
		$pagination['limit']);

	echo $engine->form_open('systemlog');

?>
		<div>
			<h4><?php echo $engine->_t('LogFilterTip'); ?>:</h4><br>
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

					echo '<option value="' . $mode . '" ' . ($selected ? ' selected' : '') . '>' . $log_filter . '</option>' . "\n";
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

					echo '<option value="' . $mode . '" ' . ($selected ? ' selected' : '') . '>' . $mode . ': ' . $log_level . '</option>' . "\n";
				}
			?>
			</select>

			<input type="submit" name="update" id="submit" value="<?php echo $engine->_t('UpdateButton');?>">
			<input type="submit" name="reset" id="submit" value="<?php echo $engine->_t('ResetButton');?>">

<?php
		$engine->print_pagination($pagination);
?>
		<table class="formation lined">
			<tr>
				<th style="width:5px;">ID</th>
				<th style="width:20px;"><a href="<?php echo $engine->href('', '', ['order' => $ordertime]); ?>"><?php echo $engine->_t('LogDate'); ?></a></th>
				<th style="width:20px;"><a href="<?php echo $engine->href('', '', ['order' => $orderlevel]); ?>"><?php echo $engine->_t('LogLevel'); ?></a></th>
				<th><?php echo $engine->_t('LogEvent'); ?></th>
				<th style="width:20px;"><?php echo $engine->_t('LogUsername'); ?></th>
			</tr>
<?php
	if ($log)
	{
		foreach ($log as $row)
		{
			// level highlighting
			if ($row['level'] == 1)
			{
				$row['level'] = '<strong class="red">' . $engine->_t('LogLevels')[1] . '</strong>';
			}
			else if ($row['level'] == 2)
			{
				$row['level'] = '<span class="red">' . $engine->_t('LogLevels')[2] . '</span>';
			}
			else if ($row['level'] == 3)
			{
				$row['level'] = '<strong>' . $engine->_t('LogLevels')[3] . '</strong>';
			}
			else if ($row['level'] == 4)
			{
				$row['level'] = $engine->_t('LogLevels')[$row['level']];
			}
			else if ($row['level'] == 5)
			{
				$row['level'] = '<small>' . $engine->_t('LogLevels')[$row['level']] . '</small>';
			}
			else if ($row['level'] > 5)
			{
				$row['level'] = '<small class="grey">' . $engine->_t('LogLevels')[$row['level']] . '</small>';
			}

			// tz offset
			$time_tz = $engine->sql2precisetime($row['log_time']);

			echo '<tr>' . "\n" .
					'<td class="t-center a-top">' . $row['log_id'] . '</td>' .
					'<td class="t-center a-top"><small>' . $time_tz . '</small></td>' .
					'<td class="t-center a-top" style="padding-left:5px; padding-right:5px;">' . $row['level'] . '</td>' .
					'<td class="a-top">' . $engine->format($row['message'], 'post_wacko') . '</td>' .
					'<td class="t-center a-top"><small>' .
						'<a href="' . $engine->href('', '', ['user_id' => $row['user_id']]) . '">' . ($row['user_id'] == 0 ? '<em>' . $engine->_t('Guest') . '</em>' : $row['user_name'] ) . '</a>' . '<br>' .
						'<a href="' . $engine->href('', '', ['ip' => $row['ip']]) . '">' . $row['ip'] . '</a>' .
					'</small></td>' .
				'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="5" class="t-center"><br><em>' . $engine->_t('LogNoMatch') . '</em></td></tr>';
	}
?>
		</table>
<?php
	$engine->print_pagination($pagination);
}

