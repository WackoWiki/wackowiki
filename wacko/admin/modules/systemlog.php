<?php

########################################################
##   System Log                                       ##
########################################################

$module['systemlog'] = array(
		'order'	=> 1,
		'cat'	=> 'Basic functions',
		'mode'	=> 'systemlog',
		'name'	=> 'System log',
		'title'	=> 'Log system events',
	);

########################################################

function admin_systemlog(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
<?php
	if (isset($_POST['reset']))
	{
		$engine->Redirect(rawurldecode($engine->href('', 'admin.php?mode='.$module['mode'])));
	}

	if (isset($_POST['update']))
	{
		// level filtering
		switch ($_POST['level_mod'])
		{
			case 'not_lower':
				$mod = '<=';
				break;
			case 'not_higher':
				$mod = '>=';
				break;
			case 'equal':
				$mod = '=';
				break;
		}
		$where = "WHERE l.level $mod ".(int)$_POST['level'].' ';


	}

	// set time ordering
	if (isset($_GET['order']) && $_GET['order'] == 'time_asc')
	{
		$order		= 'ORDER BY l.log_time ASC ';
		$ordertime	= 'time_desc';
	}
	else if (isset($_GET['order']) && $_GET['order'] == 'time_desc')
	{
		$order		= 'ORDER BY l.log_time DESC ';
		$ordertime	= 'time_asc';
	}
	else
	{
		$ordertime	= 'time_asc';
	}

	// set level ordering
	if (isset($_GET['order']) && $_GET['order'] == 'level_asc')
	{
		$order		= 'ORDER BY l.level DESC ';		// we make level sorting
		$orderlevel	= 'level_desc';					// in reverse orber because
	}												// higher level is denoted
	else if (isset($_GET['order']) && $_GET['order'] == 'level_desc')		// by lower value (e.g.
	{												// 1 = critical, 2 = highest,
		$order		= 'ORDER BY l.level ASC ';		// and so on)
		$orderlevel	= 'level_asc';
	}
	else
	{
		$orderlevel	= 'level_desc';
	}

	// filter by username or user ip
	if (isset($_GET['user']))
	{
		$where = "WHERE u.user_name = '".quote($engine->dblink, $_GET['user'])."' ";
	}
	else if (isset($_GET['ip']))
	{
		$where = "WHERE l.ip = '".quote($engine->dblink, $_GET['ip'])."' ";
	}

	// entries to display
	$limit = 100;

	// set default level
	if (!isset($level)) $level = $engine->config['log_default_show'];
	if (!isset($where)) $where = "";
	if (!isset($order)) $order = "";

	// collecting data
	$count = $engine->LoadSingle(
		"SELECT COUNT(message) AS n ".
		"FROM {$engine->config['table_prefix']}log ".
		( $where ? $where : 'WHERE level <= '.(int)$level.' ' ));

	$pagination	= $engine->Pagination($count['n'], $limit, 'p', 'mode=systemlog&order='.htmlspecialchars(isset($_GET['order']) && $_GET['order']), '', 'admin.php');

	$log = $engine->LoadAll(
		"SELECT l.log_id, l.log_time, l.level, l.message, u.user_name as user, l.ip ".
		"FROM {$engine->config['table_prefix']}log l ".
			"LEFT JOIN {$engine->config['table_prefix']}users u ON (l.user_id = u.user_id) ".
		( $where ? $where : 'WHERE l.level <= '.(int)$level.' ' ).
		( $order ? $order : 'ORDER BY l.log_id DESC ' ).
		"LIMIT {$pagination['offset']}, $limit");
?>
	<form action="admin.php" method="post" name="systemlog">
		<input type="hidden" name="mode" value="systemlog" />
		<div>
			<h4>Filter events by criteria:</h4><br />
			Level
			<select name="level_mod">
				<option value="not_lower"<?php echo ( !isset($_POST['level_mod']) || (isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_lower') ? ' selected="selected"' : '' ); ?>>not less than</option>
				<option value="not_higher"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_higher' ? ' selected="selected"' : '' ); ?>>not higher than</option>
				<option value="equal"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'equal' ? ' selected="selected"' : '' ); ?>>corresponds</option>
			</select>
			<select name="level">
<?php
	for ($i = 1; $i <= 7; $i++)
	{
		echo '<option value="'.$i.'"'.( (!$_POST['level'] && $level == $i) || $_POST['level'] == $i ? ' selected="selected"' : '' ).'>'.strtolower($engine->GetTranslation('LogLevel'.$i)).'</option>'."\n";
	}
?>
			</select>

			<input name="update" id="submit" type="submit" value="update" />
			<input name="reset" id="submit" type="submit" value="reset" />
		</div>
		<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '&nbsp;' ).'</div>'."\n"; ?>
		<table border="0" cellspacing="5" cellpadding="3" class="formation">
			<tr>
				<th style="width:5px;">ID</th>
				<th style="width:20px;"><a href="?mode=systemlog&order=<?php echo $ordertime;  ?>">Date</a></th>
				<th style="width:20px;"><a href="?mode=systemlog&order=<?php echo $orderlevel; ?>">Level</a></th>
				<th>Event</th>
				<th style="width:20px;">Username</th>
			</tr>
<?php
	if ($log)
	{
		foreach ($log as $row)
		{
			// level highlighting
			if ($row['level'] == 1)
			{
				$row['level'] = '<strong class="cite">'.$engine->GetTranslation('LogLevel1').'</strong>';
			}
			else if ($row['level'] == 2)
			{
				$row['level'] = '<span class="cite">'.$engine->GetTranslation('LogLevel2').'</span>';
			}
			else if ($row['level'] == 3)
			{
				$row['level'] = '<strong>'.$engine->GetTranslation('LogLevel3').'</strong>';
			}
			else if ($row['level'] == 4)
			{
				$row['level'] = $engine->GetTranslation('LogLevel'.$row['level']);
			}
			else if ($row['level'] == 5)
			{
				$row['level'] = '<small>'.$engine->GetTranslation('LogLevel'.$row['level']).'</small>';
			}
			else if ($row['level'] > 5)
			{
				$row['level'] = '<small class="cl-grey">'.$engine->GetTranslation('LogLevel'.$row['level']).'</small>';
			}

			echo '<tr class="lined">'."\n".
					'<td valign="top" align="center">'.$row['log_id'].'</td>'.
					'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['log_time'])).'</small></td>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$row['level'].'</td>'.
					'<td valign="top">'.$engine->Format($row['message'], 'post_wacko').'</td>'.
					'<td valign="top" align="center"><small>'.
						'<a href="?mode=systemlog&user='.$row['user'].'">'.( $row['user'] == GUEST ? '<em>'.$engine->GetTranslation('Guest').'</em>' : $row['user'] ).'</a>'.
						'<br />'.'<a href="?mode=systemlog&ip='.$row['ip'].'">'.$row['ip'].'</a>'.
					'</small></td>'.
				'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="5" align="center"><br /><em>No events that meet the criteria</em></td></tr>';
	}
?>
		</table>
		<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</div>'."\n"; ?>
	</form>
<?php
}

?>