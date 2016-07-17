<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['content_pages'] = array(
		'order'	=> 300,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_pages',
		'name'	=> 'Pages',
		'title'	=> 'Manage pages',
	);

########################################################

function admin_content_pages(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />

	TODO: filter pages: page_lang, hits, last_commented, owner, user, published, drafts, with no title, with no description, with no keywords, by date modified, category, theme, acls, approved, size ...

<?php
	if (isset($_POST['reset']))
	{
		$engine->redirect(rawurldecode($engine->href('', 'admin.php', 'mode='.$module['mode'])));
	}

	if (isset($_POST['update']) || isset($_GET['level_mod']))
	{
		$_level_mod	= isset($_POST['level_mod']) ? $_POST['level_mod'] : (isset($_GET['level_mod']) ? $_GET['level_mod'] : '');
		$_level		= isset($_POST['level']) ? $_POST['level'] : (isset($_GET['level']) ? $_GET['level'] : '');

		// level filtering
		switch ($_level_mod)
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

		$where = "WHERE l.page_lang $mod '".quote($engine->dblink, $_level)."'  ";
	}

	// set time ordering
	if (isset($_GET['order']) && $_GET['order'] == 'time_asc')
	{
		$order		= 'ORDER BY l.modified ASC ';
		$ordertime	= 'time_desc';
	}
	else if (isset($_GET['order']) && $_GET['order'] == 'time_desc')
	{
		$order		= 'ORDER BY l.modified DESC ';
		$ordertime	= 'time_asc';
	}
	else
	{
		$ordertime	= 'time_asc';
	}

	// set level ordering
	if (isset($_GET['order']) && $_GET['order'] == 'level_asc')
	{
		$order		= 'ORDER BY l.supertag DESC ';		// we make level sorting
		$orderlevel	= 'level_desc';					// in reverse orber because
	}												// higher level is denoted
	else if (isset($_GET['order']) && $_GET['order'] == 'level_desc')		// by lower value (e.g.
	{												// 1 = critical, 2 = highest,
		$order		= 'ORDER BY l.supertag ASC ';		// and so on)
		$orderlevel	= 'level_asc';
	}
	else
	{
		$orderlevel	= 'level_desc';
	}

	// set level ordering
	if (isset($_GET['order']) && $_GET['order'] == 'size_asc')
	{
		$order		= 'ORDER BY page_size DESC ';		// we make level sorting
		$ordersize	= 'size_desc';					// in reverse orber because
	}												// higher level is denoted
	else if (isset($_GET['order']) && $_GET['order'] == 'size_desc')		// by lower value (e.g.
	{												// 1 = critical, 2 = highest,
		$order		= 'ORDER BY page_size ASC ';		// and so on)
		$ordersize	= 'size_asc';
	}
	else
	{
		$ordersize	= 'size_desc';
	}

	// filter by username or user ip
	if (isset($_GET['user_id']))
	{
		$where = "WHERE l.user_id = '".(int)$_GET['user_id']."' ";
	}
	else if (isset($_GET['ip']))
	{
		$where = "WHERE l.ip = '".quote($engine->dblink, $_GET['ip'])."' ";
	}

	// entries to display
	$limit = 100;

	// set default level
	if (!isset($level)) $level = $engine->config['log_default_show'];
	if (!isset($where)) $where = '';
	else  $where .= "AND l.comment_on_id = '0' ";
	if (!isset($order)) $order = '';

	// collecting data
	$count = $engine->load_single(
		"SELECT COUNT(page_id) AS n ".
		"FROM {$engine->config['table_prefix']}page l ".
		( $where ? $where : "WHERE comment_on_id = '0' " ));

	$order_pagination		= isset($_GET['order'])		? $_GET['order']		: '';
	$level_pagination		= isset($_GET['level'])		? $_GET['level']		: (isset($_POST['level'])		? $_POST['level']		: '');
	$level_mod_pagination	= isset($_GET['level_mod'])	? $_GET['level_mod']	: (isset($_POST['level_mod'])	? $_POST['level_mod']	: '');
	$pagination				= $engine->pagination($count['n'], $limit, 'p', 'mode='.$module['mode'].(!empty($order_pagination) ? '&amp;order='.htmlspecialchars($order_pagination, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '').(!empty($level_pagination) ? '&amp;level='.htmlspecialchars($level_pagination, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '').(!empty($level_mod_pagination) ? '&amp;level_mod='.htmlspecialchars($level_mod_pagination, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ''), '', 'admin.php');

	$pages = $engine->load_all(
		"SELECT p.*, length(body) as page_size, u.* ".
		"FROM {$engine->config['table_prefix']}page p ".
			"LEFT JOIN {$engine->config['table_prefix']}user u ON (l.user_id = u.user_id) ".
		( $where ? $where : "WHERE l.comment_on_id = '0' " ).
		( $order ? $order : 'ORDER BY l.page_id DESC ' ).
		"LIMIT {$pagination['offset']}, $limit");

	echo $engine->form_open('content_pages', '', 'post', true, '', '');

?>
		<div>
			<h4><?php echo $engine->get_translation('LogFilterTip'); ?>:</h4><br />
			<?php echo $engine->get_translation('LogLevel'); ?>

			<select name="level_mod">
				<option value="not_lower"<?php echo ( !isset($_POST['level_mod']) || (isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_lower') ? ' selected="selected"' : '' ); ?>><?php echo $engine->get_translation('LogLevelNotLower'); ?></option>
				<option value="not_higher"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_higher' ? ' selected="selected"' : '' ); ?>><?php echo $engine->get_translation('LogLevelNotHigher'); ?></option>
				<option value="equal"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'equal' ? ' selected="selected"' : '' ); ?>><?php echo $engine->get_translation('LogLevelEqual'); ?></option>
			</select>

<?php
		// FIXME: add a common function for this?
		echo '<select id="level" name="level">';

		$languages = $engine->get_translation('LanguageArray');

		if ($engine->config['multilanguage'])
		{
			$langs = $engine->available_languages();
		}
		else
		{
			$langs[] = $engine->config['language'];
		}

		if ($langs)
		{
			foreach ($langs as $lang)
			{
				echo '<option value="'.$lang.'" '.($_level == $lang ? 'selected="selected" ' : '').'>'.$languages[$lang].' ('.$lang.")</option>\n";
			}
		}

		echo "</select>\n";
?>

			<input type="submit" name="update" id="submit" value="update" />
			<input type="submit" name="reset" id="submit" value="reset" />
		</div>
<?php
		$engine->print_pagination($pagination);
?>
		<table style="padding: 3px;" class="formation">
			<tr>
				<th style="width:5px;">ID</th>
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'].'&amp;order='.$ordertime; ?>"><?php echo $engine->get_translation('LogDate'); ?></a></th>
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'].'&amp;order='.$orderlevel; ?>"><?php echo $engine->get_translation('LogLevel'); ?></a></th>
				<th><?php echo $engine->get_translation('LogEvent'); ?></th>
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'].'&amp;order='.$ordersize; ?>"><?php echo $engine->get_translation('LogLevel'); ?></a></th>
				<th style="width:20px;"><?php echo $engine->get_translation('LogUsername'); ?></th>
			</tr>
<?php
	if ($pages)
	{
		foreach ($pages as $row)
		{
			// level highlighting
			/* if ($row['level'] == 1)
			{
				$row['level'] = '<strong class="red">'.$engine->get_translation('LogLevel1').'</strong>';
			}
			else if ($row['level'] == 2)
			{
				$row['level'] = '<span class="red">'.$engine->get_translation('LogLevel2').'</span>';
			}
			else if ($row['level'] == 3)
			{
				$row['level'] = '<strong>'.$engine->get_translation('LogLevel3').'</strong>';
			}
			else if ($row['level'] == 4)
			{
				$row['level'] = $engine->get_translation('LogLevel'.$row['level']);
			}
			else if ($row['level'] == 5)
			{
				$row['level'] = '<small>'.$engine->get_translation('LogLevel'.$row['level']).'</small>';
			}
			else if ($row['level'] > 5)
			{
				$row['level'] = '<small class="grey">'.$engine->get_translation('LogLevel'.$row['level']).'</small>';
			}
 */
			// tz offset
			$time_tz = $engine->sql2precisetime($row['modified']);

			echo '<tr class="lined">'."\n".
					'<td style="vertical-align:top; text-align:center;">'.$row['page_id'].'</td>'.
					'<td style="vertical-align:top; text-align:center;"><small>'.$time_tz.'</small></td>'.
					'<td style="vertical-align:top; padding-left:5px; padding-right:5px;">'.$row['tag'].'</td>'.
					'<td style="vertical-align:top;">'.$row['title'].'</td>'.
					'<td style="vertical-align:top;">'.$engine->binary_multiples($row['page_size'], false, true, true).'</td>'.
					'<td style="vertical-align:top; text-align:center;"><small>'.
						'<a href="'.$engine->href().'&amp;user_id='.$row['user_id'].'">'.( $row['user_id'] == 0 ? '<em>'.$engine->get_translation('Guest').'</em>' : $row['user_name'] ).'</a>'.
						'<br />'.'<a href="'.$engine->href().'&amp;ip='.$row['ip'].'">'.$row['ip'].'</a>'.
					'</small></td>'.
				'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="5" style="text-align:center;"><br /><em>'.$engine->get_translation('LogNoMatch').'</em></td></tr>';
	}
?>
		</table>
<?php
	$engine->print_pagination($pagination);

	echo $engine->form_close();
}

?>
