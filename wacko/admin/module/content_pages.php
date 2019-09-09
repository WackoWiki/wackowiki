<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Pages												##
##########################################################
$_mode = 'content_pages';

$module[$_mode] = [
		'order'	=> 300,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true) && (WACKO_ENV < 3),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Pages
		'title'	=> $engine->_t($_mode)['title'],	// Manage pages
	];

##########################################################

function admin_content_pages(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>

	TODO: filter pages: page_lang, hits, last_commented, owner, user, published, drafts, with no title, with no description, with no keywords, by date modified, category, theme, acls, approved, size ...

<?php
	if (isset($_POST['reset']))
	{
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	if (isset($_POST['update']))
	{
		$_lang		= ($_POST['level'] ?? $_GET['level'] ?? '');

		$where = "WHERE p.page_lang = " . $engine->db->q($_lang) . " ";
	}

	// set time ordering
	if (isset($_GET['order']) && $_GET['order'] == 'time_asc')
	{
		$order		= 'ORDER BY p.modified ASC ';
		$ordertime	= 'time_desc';
	}
	else if (isset($_GET['order']) && $_GET['order'] == 'time_desc')
	{
		$order		= 'ORDER BY p.modified DESC ';
		$ordertime	= 'time_asc';
	}
	else
	{
		$ordertime	= 'time_asc';
	}

	// set level ordering
	if (isset($_GET['order']) && $_GET['order'] == 'tag_asc')
	{
		$order		= 'ORDER BY p.tag DESC ';			// we make level sorting
		$ordertag	= 'tag_desc';						// in reverse orber because
	}													// higher level is denoted
	else if (isset($_GET['order']) && $_GET['order'] == 'tag_desc')		// by lower value (e.g.
	{													// 1 = critical, 2 = highest,
		$order		= 'ORDER BY p.tag ASC ';			// and so on)
		$ordertag	= 'tag_asc';
	}
	else
	{
		$ordertag	= 'tag_desc';
	}

	// set page size ordering
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
		$where = "WHERE p.user_id = " . (int) $_GET['user_id'] . " ";
	}
	else if (isset($_GET['ip']))
	{
		$where = "WHERE p.ip = " . $engine->db->q($_GET['ip']) . " ";
	}

	// entries to display
	$limit = 100;

	// set default level
	if (!isset($level)) $level = $engine->db->log_default_show;
	if (!isset($where)) $where = '';
	else $where .= "AND p.comment_on_id = 0 ";
	if (!isset($order)) $order = '';

	// collecting data
	$count = $engine->db->load_single(
		"SELECT COUNT(page_id) AS n " .
		"FROM " . $engine->db->table_prefix . "page p " .
		( $where ?: "WHERE comment_on_id = 0 " ));

	$_order					= $_GET['order']	?? '';
	$_lang					= $_GET['level']	?? ($_POST['level']		?? '');
	$order_pagination		= !empty($_order)	? ['order' => Ut::html($_order)] : [];
	$tag_pagination			= !empty($_lang)	? ['level' => (int) $_lang] : [];

	$pagination				= $engine->pagination($count['n'], $limit, 'p', ['mode' => $module['mode']] + $order_pagination + $tag_pagination, '', 'admin.php');

	$pages = $engine->db->load_all(
		"SELECT p.*, length(body) as page_size, u.* " .
		"FROM " . $engine->db->table_prefix . "page p " .
			"LEFT JOIN " . $engine->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
		($where ?: "WHERE p.comment_on_id = 0 " ) .
		($order ?: 'ORDER BY p.page_id DESC ' ) .
		$pagination['limit']);

	echo $engine->form_open('content_pages');

?>
		<div>
			<h4><?php echo $engine->_t('LogFilterTip'); ?>:</h4><br>

<?php
		// FIXME: add a common function for this?
		echo '<select id="level" name="level">';

		$languages = $engine->_t('LanguageArray');

		if ($engine->db->multilanguage)
		{
			$langs = $engine->http->available_languages();
		}
		else
		{
			$langs[] = $engine->db->language;
		}

		if ($langs)
		{
			foreach ($langs as $lang)
			{
				echo '<option value="' . $lang . '" ' . ($_lang == $lang ? 'selected ' : '') . '>' . $languages[$lang] . ' (' . $lang.")</option>\n";
			}
		}

		echo "</select>\n";
?>
			<input type="submit" name="update" id="submit" value="update">
			<input type="submit" name="reset" id="submit" value="reset">
		</div>
<?php
		$engine->print_pagination($pagination);
?>
		<table class="formation lined">
			<tr>
				<th style="width:5px;">ID</th>
				<th style="width:20px;"><a href="<?php echo $engine->href('', '', ['order' => $ordertime]);?>"><?php echo $engine->_t('LogDate'); ?></a></th>
				<th style="width:20px;"><a href="<?php echo $engine->href('', '', ['order' => $ordertag]);?>"><?php echo $engine->_t('MetaTag'); ?></a></th>
				<th><?php echo $engine->_t('MetaTitle'); ?></th>
				<th style="width:20px;"><a href="<?php echo $engine->href('', '', ['order' => $ordersize]);?>"><?php echo $engine->_t('SettingsSize'); ?></a></th>
				<th style="width:20px;"><?php echo $engine->_t('LogUsername'); ?></th>
			</tr>
<?php
	if ($pages)
	{
		foreach ($pages as $row)
		{
			// tz offset
			$time_tz = $engine->sql2precisetime($row['modified']);

			echo '<tr>' . "\n" .
					'<td class="t-center a-top">' . $row['page_id'] . '</td>' .
					'<td class="t-center a-top"><small>' . $time_tz . '</small></td>' .
					'<td class="a-top" style="padding-left:5px; padding-right:5px;">' . $row['tag'] . '</td>' .
					'<td class="a-top">' . $row['title'] . '</td>' .
					'<td class="a-top">' . $engine->binary_multiples($row['page_size'], false, true, true) . '</td>' .
					'<td class="t-center a-top"><small>' .
						'<a href="' . $engine->href('', '', ['user_id' => $row['user_id']]) . '">' . ($row['user_id'] == 0 ? '<em>' . $engine->_t('Guest') . '</em>' : $row['user_name'] ) . '</a>' .
						'<br>' . '<a href="' . $engine->href('', '', ['ip' => $row['ip']]) . '">' . $row['ip'] . '</a>' .
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

	echo $engine->form_close();
}

?>
