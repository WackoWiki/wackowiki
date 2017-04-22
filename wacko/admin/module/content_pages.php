<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################
$_mode = 'content_pages';

$module[$_mode] = [
		'order'	=> 300,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Pages
		'title'	=> $engine->_t($_mode)['title'],	// Manage pages
	];

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
		$engine->http->redirect(rawurldecode($engine->href('', 'admin.php', 'mode=' . $module['mode'])));
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

		$where = "WHERE l.page_lang $mod " . $engine->db->q($_level) . " ";
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
		$where = "WHERE l.user_id = '" . (int) $_GET['user_id'] . "' ";
	}
	else if (isset($_GET['ip']))
	{
		$where = "WHERE l.ip = " . $engine->db->q($_GET['ip']) . " ";
	}

	// entries to display
	$limit = 100;

	// set default level
	if (!isset($level)) $level = $engine->db->log_default_show;
	if (!isset($where)) $where = '';
	else  $where .= "AND l.comment_on_id = '0' ";
	if (!isset($order)) $order = '';

	// collecting data
	$count = $engine->db->load_single(
		"SELECT COUNT(page_id) AS n " .
		"FROM " . $engine->db->table_prefix . "page l " .
		( $where ? $where : "WHERE comment_on_id = '0' " ));

	$_order					= isset($_GET['order'])		? $_GET['order']		: '';
	$_level					= isset($_GET['level'])		? $_GET['level']		: (isset($_POST['level'])		? $_POST['level']		: '');
	$_level_mod				= isset($_GET['level_mod'])	? $_GET['level_mod']	: (isset($_POST['level_mod'])	? $_POST['level_mod']	: '');
	$order_pagination		= !empty($_order)		? ['order' => htmlspecialchars($_order, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)] : [];
	$level_pagination		= !empty($_level)		? ['level' => (int) $_level] : [];
	$level_mod_pagination	= !empty($_level_mod)	? ['level_mod' => (int) $_level_mod] : [];

	$pagination				= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination + $level_pagination + $level_mod_pagination, '', 'admin.php');

	$pages = $engine->db->load_all(
		"SELECT p.*, length(body) as page_size, u.* " .
		"FROM " . $engine->db->table_prefix . "page p " .
			"LEFT JOIN " . $engine->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
		( $where ? $where : "WHERE p.comment_on_id = '0' " ) .
		( $order ? $order : 'ORDER BY p.page_id DESC ' ) .
		$pagination['limit']);

	echo $engine->form_open('content_pages');

?>
		<div>
			<h4><?php echo $engine->_t('LogFilterTip'); ?>:</h4><br />
			<?php echo $engine->_t('LogLevel'); ?>

			<select name="level_mod">
				<option value="not_lower"<?php echo ( !isset($_POST['level_mod']) || (isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_lower') ? ' selected' : '' ); ?>><?php echo $engine->_t('LogLevelNotLower'); ?></option>
				<option value="not_higher"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'not_higher' ? ' selected' : '' ); ?>><?php echo $engine->_t('LogLevelNotHigher'); ?></option>
				<option value="equal"<?php echo ( isset($_POST['level_mod']) && $_POST['level_mod'] == 'equal' ? ' selected' : '' ); ?>><?php echo $engine->_t('LogLevelEqual'); ?></option>
			</select>

<?php
		// FIXME: add a common function for this?
		echo '<select id="level" name="level">';

		$languages = $engine->_t('LanguageArray');

		if ($engine->db->multilanguage)
		{
			$langs = $engine->available_languages();
		}
		else
		{
			$langs[] = $engine->db->language;
		}

		if ($langs)
		{
			foreach ($langs as $lang)
			{
				echo '<option value="' . $lang . '" '.($_level == $lang ? 'selected ' : '') . '>' . $languages[$lang] . ' (' . $lang.")</option>\n";
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
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'] . '&amp;order=' . $ordertime; ?>"><?php echo $engine->_t('LogDate'); ?></a></th>
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'] . '&amp;order=' . $orderlevel; ?>"><?php echo $engine->_t('LogLevel'); ?></a></th>
				<th><?php echo $engine->_t('LogEvent'); ?></th>
				<th style="width:20px;"><a href="?mode=<?php echo $module['mode'] . '&amp;order=' . $ordersize; ?>"><?php echo $engine->_t('LogLevel'); ?></a></th>
				<th style="width:20px;"><?php echo $engine->_t('LogUsername'); ?></th>
			</tr>
<?php
	if ($pages)
	{
		foreach ($pages as $row)
		{
			// level highlighting
			/* if ($row['level'] == 1)
			{
				$row['level'] = '<strong class="red">' . $engine->_t('LogLevel1') . '</strong>';
			}
			else if ($row['level'] == 2)
			{
				$row['level'] = '<span class="red">' . $engine->_t('LogLevel2') . '</span>';
			}
			else if ($row['level'] == 3)
			{
				$row['level'] = '<strong>' . $engine->_t('LogLevel3') . '</strong>';
			}
			else if ($row['level'] == 4)
			{
				$row['level'] = $engine->_t('LogLevel' . $row['level']);
			}
			else if ($row['level'] == 5)
			{
				$row['level'] = '<small>' . $engine->_t('LogLevel' . $row['level']) . '</small>';
			}
			else if ($row['level'] > 5)
			{
				$row['level'] = '<small class="grey">' . $engine->_t('LogLevel' . $row['level']) . '</small>';
			}
 */
			// tz offset
			$time_tz = $engine->sql2precisetime($row['modified']);

			echo '<tr class="lined">' . "\n" .
					'<td class="t_center a_top">' . $row['page_id'] . '</td>' .
					'<td class="t_center a_top"><small>' . $time_tz . '</small></td>' .
					'<td class="a_top" style="padding-left:5px; padding-right:5px;">' . $row['tag'] . '</td>' .
					'<td class="a_top">' . $row['title'] . '</td>' .
					'<td class="a_top">' . $engine->binary_multiples($row['page_size'], false, true, true) . '</td>' .
					'<td class="t_center a_top"><small>' .
						'<a href="' . $engine->href() . '&amp;user_id=' . $row['user_id'] . '">' . ($row['user_id'] == 0 ? '<em>' . $engine->_t('Guest') . '</em>' : $row['user_name'] ) . '</a>' .
						'<br />' . '<a href="' . $engine->href() . '&amp;ip=' . $row['ip'] . '">' . $row['ip'] . '</a>' .
					'</small></td>' .
				'</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="5" class="t_center"><br /><em>' . $engine->_t('LogNoMatch') . '</em></td></tr>';
	}
?>
		</table>
<?php
	$engine->print_pagination($pagination);

	echo $engine->form_close();
}

?>
