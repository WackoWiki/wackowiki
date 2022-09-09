<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Bad Behavior										##
##########################################################

$module['tool_badbehavior'] = [
		'order'	=> 800,
		'cat'	=> 'extension',
		'status'=> !RECOVERY_MODE,
	];

##########################################################
function admin_tool_badbehavior(&$engine, $module)
{
	if (!empty($engine->db->ext_bad_behavior))
	{
		require_once 'lib/bad_behavior/bad-behavior/responses.inc.php';
	}

	#Ut::debug_print_r($_POST);

	function bb2_httpbl_lookup(&$engine, $ip)
	{
		// NB: Many of these are defunct
		$engines = [
			1 => 'AltaVista',
			2 => 'Teoma/Ask Crawler',
			3 => 'Baidu Spide',
			4 => 'Excite',
			5 => 'Googlebot',
			6 => 'Looksmart',
			7 => 'Lycos',
			8 => 'msnbot',
			9 => 'Yahoo! Slurp',
			10 => 'Twiceler',
			11 => 'Infoseek',
			12 => 'Minor Search Engine',
		];

		$settings		= bb2_read_settings();
		$httpbl_key		= $settings['httpbl_key'];

		if (!$httpbl_key) return false;

		$r = $engine->sess->httpbl[$ip];
		$d = '';

		if (!$r)
		{
			// Lookup
			$find		= implode('.', array_reverse(explode('.', $ip)));
			$result		= gethostbynamel("${httpbl_key}.${find}.dnsbl.httpbl.org.");

			if (!empty($result))
			{
				$r = $result[0];
				$engine->sess->httpbl[$ip] = $r;
			}
		}

		if ($r)
		{	// Interpret
			$ip = explode('.', $r);

			if ($ip[0] == 127)
			{
				if ($ip[3] == 0)
				{
					if ($engines[$ip[2]])
					{
						$d .= $engines[$ip[2]];
					}
					else
					{
						$d .= "Search engine ${ip[2]}<br>\n";
					}
				}

				if ($ip[3] & 1)
				{
					$d .= "Suspicious<br>\n";
				}

				if ($ip[3] & 2)
				{
					$d .= "Harvester<br>\n";
				}

				if ($ip[3] & 4)
				{
					$d .= "Comment Spammer<br>\n";
				}

				if ($ip[3] & 7)
				{
					$d .= "Threat level ${ip[2]}<br>\n";
				}

				if ($ip[3] > 0)
				{
					$d .= "Age ${ip[1]} days<br>\n";
				}
			}
		}

		return $d;
	}

	function bb2_summary(&$engine)
	{
		echo $engine->form_open('bb2_manage', ['form_more' => 'setting=bb2_manage']);
		?>

		<div class="alignleft">
		<?php echo Ut::perc_replace($engine->_t('BbStats'), '<strong>' . bb2_insert_stats(true) . '</strong>');?>
		</div>
		<?php
		// select arguments
		$arguments = [
			'status_key',
			'request_method',
			#'ip',
			#'user_agent',
			'request_uri'
		];

		foreach ($arguments as $argument)
		{
			if ($argument == 'request_uri')
			{
				$additional_fields = 'MAX(request_uri_hash) as request_uri_hash, ';
			}
			else
			{
				$additional_fields = '';
			}

			// Query the DB based on variables selected
			$results = $engine->db->load_all(
				"SELECT BINARY {$argument} as group_type, {$additional_fields} COUNT({$argument}) AS n " .
				"FROM " . $engine->prefix . "bad_behavior " .
				"GROUP BY BINARY {$argument} " .
				"ORDER BY n DESC " .
				"LIMIT 10", true);

		// Display rows to the user

		?>
		<table class="bb-summary formation lined">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<thead>
				<tr>
					<th scope="col"><?php echo $engine->_t('BbHits');?></th>
					<th scope="col"><?php echo $argument; ?></th>
				</tr>
			</thead>
			<tbody>
		<?php
			// all ip related host names

			if ($results)
			{
				foreach ($results as $result)
				{
					echo '<tr>' . "\n";
					echo '<td class="label">' . $result['n'] . '</td>' . "\n";
					# echo '<td>' . str_replace("\n", "<br>\n", Ut::html($result['request_entity'])) . '</td>' . "\n";

					if ($argument == 'status_key')
					{
						$status_key	= bb2_get_response($result['group_type']);
						$link		= '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'status_key' => $result['group_type']]) . '" title="' . '[' . $status_key['response'] . '] ' . $status_key['explanation'] . '">' . $status_key['log'] . '</a>';
					}
					else if ($argument == 'request_uri')
					{
						$link		= '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', $argument => $result['request_uri_hash']]) . '">' . $result['group_type'] . '</a>';
					}
					else
					{
						$link		= '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', $argument => $result['group_type']]) . '">' . $result['group_type'] . '</a>';
					}

					echo '<td>' . $link . '</td>' . "\n";
					echo '</tr>' . "\n";
				}
			}
	?>
		</tbody>
	</table>
	<?php
		}
	}

	function bb2_manage(&$engine)
	{
		$bb_table		= $engine->prefix . 'bad_behavior';
		$settings		= bb2_read_settings();

		$where			= '';

		// entries to display
		$limit = 100;

		// Get query variables desired by the user with input validation
		if (!empty($_GET['status_key']))			$where .= "AND `status_key`			= " . $engine->db->q($_GET['status_key']) . " ";
		if (!empty($_GET['blocked']))				$where .= "AND `status_key` 		!= '00000000' ";
		else if (!empty($_GET['permitted']))		$where .= "AND `status_key`			= '00000000' ";

		if (!empty($_GET['ip']))					$where .= "AND `ip` 				= " . $engine->db->q($_GET['ip']) . " ";
		if (!empty($_GET['user_agent']))			$where .= "AND `user_agent_hash`	= " . $engine->db->q($_GET['user_agent']) . " ";
		if (!empty($_GET['request_method']))		$where .= "AND `request_method`		= " . $engine->db->q($_GET['request_method']) . " ";
		if (!empty($_GET['request_uri']))			$where .= "AND `request_uri_hash`	= " . $engine->db->q($_GET['request_uri']) . " ";

		// collecting data
		$count = $engine->db->load_single(
			"SELECT COUNT(log_id) AS n " .
			"FROM " . $engine->prefix . "bad_behavior l " .
			"WHERE 1=1 " . ( $where ?: '' ));

		$key_pagination				= ($_GET['status_key']		?? '');
		$blocked_pagination			= ($_GET['blocked']			?? '');
		$permitted_pagination		= ($_GET['permitted']		?? '');
		$ip_pagination				= ($_GET['ip']				?? '');
		$user_agent_pagination		= ($_GET['user_agent']		?? '');
		$request_method_pagination	= ($_GET['request_method']	?? '');
		$request_uri_pagination		= ($_GET['request_uri']		?? '');

		$pagination				= $engine->pagination($count['n'], $limit, 'p', ['mode' => 'tool_badbehavior', 'setting' => 'bb2_manage']
									+ (!empty($blocked_pagination)			? ['blocked'		=> Ut::html($blocked_pagination)] : [])
									+ (!empty($permitted_pagination)		? ['permitted'		=> Ut::html($permitted_pagination)] : [])
									+ (!empty($key_pagination)				? ['status_key'		=> Ut::html($key_pagination)] : [])
									+ (!empty($ip_pagination)				? ['ip'				=> Ut::html($ip_pagination)] : [])
									+ (!empty($request_method_pagination)	? ['request_method'	=> Ut::html($request_method_pagination)] : [])
									+ (!empty($request_uri_pagination)		? ['request_uri'	=> Ut::html($request_uri_pagination)] : [])
									+ (!empty($user_agent_pagination)		? ['user_agent'		=> Ut::html($user_agent_pagination)] : []), '', 'admin.php');

		// Query the DB based on variables selected

		$totalcount		= $engine->db->load_single(
			"SELECT COUNT(log_id) AS n " .
			"FROM " . $engine->prefix . "bad_behavior l ");

		$results		= $engine->db->load_all(
			"SELECT log_id, ip, host, date, request_method, request_uri, server_protocol, http_headers, user_agent, user_agent_hash, request_entity, status_key " .
			"FROM `" . $bb_table . "` " .
			"WHERE 1=1 " .
			$where .
			"ORDER BY `log_id` DESC " .
			$pagination['limit']);

		// Display rows to the user

		echo $engine->form_open('bb2_manage');
		?>

		<div class="alignleft">
		<?php
		echo Ut::perc_replace($engine->_t('BbRecordsFiltered'), '<strong>' . $count['n'] . '</strong>', '<strong>' . $totalcount['n'] . '</strong>') . ':<br>';
		echo $engine->_t('BbShow') . ' ';

		if ($count['n'] < $totalcount['n'])
		{
			$link = '[<a href="' .	$engine->href('', '', ['setting' => 'bb2_manage']) . '">X</a>]';

			if (!empty($_GET['status_key']))		echo '<strong>' . $engine->_t('BbStatus')		. '</strong> ' . $link . ' ';
			if (!empty($_GET['blocked']))			echo '<strong>' . $engine->_t('BbBlocked')		. '</strong> ' . $link . ' ';
			if (!empty($_GET['permitted']))			echo '<strong>' . $engine->_t('BbPermitted')	. '</strong> ' . $link . ' ';
			if (!empty($_GET['ip']))				echo '<strong>' . $engine->_t('BbIp')			. '</strong> ' . $link . ' ';
			if (!empty($_GET['user_agent']))		echo '<strong>' . $engine->_t('BbUserAgent')	. '</strong> ' . $link . ' ';
			if (!empty($_GET['request_method']))	echo '<strong>' . $engine->_t('BbGetPost')		. '</strong> ' . $link . ' ';
			if (!empty($_GET['request_uri']))		echo '<strong>' . $engine->_t('BbUri')			. '</strong> ' . $link . ' ';
		}

		if (!isset($_GET['status_key']))
		{
			if (!isset($_GET['blocked']))
			{
				echo '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'blocked' => 'true']) . '">' . $engine->_t('BbBlocked') . '</a> ';
			}

			if (!isset($_GET['permitted']))
			{
				echo ' <a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'permitted' => 'true']) . '">' . $engine->_t('BbPermitted') . '</a>';
			}
		}
		?>
		</div>

		<?php
		$engine->print_pagination($pagination);
		?>
		<table class="formation hl-line">
			<thead>
				<tr>
					<th scope="col" class="check-column"></th>
					<th scope="col"><?php echo $engine->_t('BbIpDateStatus');?></th>
					<th scope="col"><?php echo $engine->_t('BbHeaders');?></th>
					<th scope="col"><?php echo $engine->_t('BbEntity');?></th>
				</tr>
			</thead>
			<tbody>
		<?php
		// all ip related host names
		if ($results)
		{
			foreach ($results as $result)
			{
				$status_key = bb2_get_response($result['status_key']);

				echo '<tr id="request-' . $result['log_id'] . '">' . "\n";
				echo '<td class="check-column label">' .
						'<input type="checkbox" name="submit[]" value="' . $result['log_id'] . '">' .
					'</td>' . "\n";

				$httpbl	= bb2_httpbl_lookup($engine, $result['ip']);

				// avoid redundant lookups
				if (empty($result['host']))
				{
					$host = @gethostbyaddr($result['ip']);
					$engine->db->sql_query(
						"UPDATE " . $engine->prefix . "bad_behavior SET " .
							"host		= " . $engine->db->q($host) . " " .
						"WHERE log_id	= " . (int) $result['log_id'] . " " .
						"LIMIT 1");
				}

				$host = $result['host'];

				if (!strcmp($host, $result['ip']))
				{
					$host = '';
				}
				else
				{
					$host .= "<br>\n";
				}

				$time_tz = $engine->sql2precisetime($result['date']);

				echo '<td>' .
						'<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'ip' => $result['ip']]) . '">' . $result['ip'] . '</a><br>' .
						$host . '<br>' . "\n" .
						$time_tz . '<br><br>' .
						'<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'status_key' => $result['status_key']]) . '" title="' .'[' . $status_key['response'] . '] ' . $status_key['explanation']. '">' . $status_key['log'] . '</a>' . "\n";

				if ($httpbl)
				{
					echo "<br><br><a href=\"https://www.projecthoneypot.org/ip_{$result['ip']}\">http:BL</a>:<br>$httpbl\n";
				}

				echo '</td>' . "\n";

				$headers = str_replace("\n", "<br>\n", Ut::html($result['http_headers']));

				if (@strpos($headers, $result['user_agent']) !== false)
				{
					$headers = substr_replace($headers, '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'user_agent' => rawurlencode($result['user_agent_hash'])]) . '">' . $result['user_agent'] . '</a>', strpos($headers, $result['user_agent']), strlen($result['user_agent']));
				}

				if (@strpos($headers, $result['request_method']) !== false)
				{
					$headers = substr_replace($headers, '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'request_method' => rawurlencode($result['request_method'])]) . '">' . $result['request_method'] . '</a>', strpos($headers, $result['request_method']), strlen($result['request_method']));
				}

				echo '<td>' . $headers . '</td>' . "\n";
				echo '<td>' . str_replace("\n", "<br>\n", Ut::html($result['request_entity'])) . '</td>' . "\n";
				echo '</tr>' . "\n";
			}
		}
	?>
		</tbody>
	</table>

	<?php
		$engine->print_pagination($pagination);

		echo $engine->form_close();
	}

	function bb2_whitelist(&$engine)
	{
		$whitelists = bb2_read_whitelist();

		if (empty($whitelists))
		{
			$whitelists					= [];
			$whitelists['ip']			= [];
			$whitelists['url']			= [];
			$whitelists['useragent']	= [];
		}

		if ($_POST)
		{
			#$_POST = array_map('stripslashes_deep', $_POST);

			if ($_POST['ip'])
			{
				$whitelists['ip'] = array_filter(preg_split("/\s+/m", $_POST['ip']));
			}
			else
			{
				$whitelists['ip'] = [];
			}

			if ($_POST['url'])
			{
				$whitelists['url'] = array_filter(preg_split("/\s+/m", $_POST['url']));
			}
			else
			{
				$whitelists['url'] = [];
			}

			if ($_POST['useragent'])
			{
				$whitelists['useragent'] = array_filter(preg_split("/[\r\n]+/m", $_POST['useragent']));
			}
			else
			{
				$whitelists['useragent'] = [];
			}

			#update_option('bad_behavior_whitelist', $whitelists);
		?>
		<div id="message" class="updated fade"><p><strong><?php echo $engine->_t('BbOptionsSaved');?></strong></p></div>
		<?php
		}

		echo $engine->form_open('bb2_whitelist', ['form_more' => 'setting=bb2_whitelist']);
		?>
		<p><?php echo $engine->_t('BbWhitelistHint');?></p>

		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('BbWhitelist');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="whitelists_ip"><strong><?php echo $engine->_t('BbIpAddress');?>:</strong><br>
					<small><?php echo $engine->_t('BbIpAddressInfo');?></small></label>
				</td>
				<td>
					<textarea cols="24" rows="6" id="whitelists_ip" name="ip"><?php echo implode("\n", $whitelists['ip']); ?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="whitelists_url"><strong><?php echo $engine->_t('BbUrl');?>:</strong><br>
					<small><?php echo $engine->_t('BbUrlInfo');?></small></label>
				</td>
				<td>
					<textarea cols="48" rows="6" id="whitelists_url" name="url"><?php echo implode("\n", $whitelists['url']); ?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="whitelists_useragent"><strong><?php echo $engine->_t('BbUserAgent');?>:</strong><br>
					<small><?php echo $engine->_t('BbUserAgentInfo');?></small></label>
				</td>
				<td>
					<textarea cols="48" rows="6" id="whitelists_useragent" name="useragent"><?php echo implode("\n", $whitelists['useragent']); ?></textarea>
				</td>
			</tr>
		</table>
		<br>
		<div class="center"><button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button></div>

	<?php
		echo $engine->form_close();
	}

function bb2_options(&$engine)
{
	$settings = bb2_read_settings();

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['ext_bad_behavior']				= (int) $_POST['ext_bad_behavior'];

		/*
		$config['display_stats']				= (string) $_POST['display_stats'];
		$config['strict']						= (string) $_POST['strict'];
		$config['verbose']						= (string) $_POST['verbose'];
		$config['logging']						= (string) $_POST['logging'];
		$config['httpbl_key']					= (string) $_POST['httpbl_key'];
		$config['httpbl_threat']				= (string) $_POST['httpbl_threat'];
		$config['httpbl_maxage']				= (int) $_POST['httpbl_maxage'];
		$config['offsite_forms']				= (string) $_POST['offsite_forms'];
		$config['reverse_proxy']				= (int) $_POST['reverse_proxy'];
		$config['reverse_proxy_header']			= $_POST['reverse_proxy_header'];
		$config['reverse_proxy_addresses']		= (string) $_POST['reverse_proxy_addresses'];
		*/

		$engine->config->_set($config);

		$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
		$engine->set_message($engine->_t('BbSettingsUpdated'));
		$engine->http->redirect($engine->href());
	}

	if ($_POST)
	{
		#$_POST = array_map('stripslashes_deep', $_POST);

		if ($_POST['strict'])
		{
			$settings['strict'] = true;
		}
		else
		{
			$settings['strict'] = false;
		}

		if ($_POST['verbose'])
		{
			$settings['verbose'] = true;
		}
		else
		{
			$settings['verbose'] = false;
		}

		if ($_POST['logging'])
		{
			if ($_POST['logging'] == 'verbose')
			{
				$settings['verbose'] = true;
				$settings['logging'] = true;
			}
			else if ($_POST['logging'] == 'normal')
			{
				$settings['verbose'] = false;
				$settings['logging'] = true;
			}
			else
			{
				$settings['verbose'] = false;
				$settings['logging'] = false;
			}
		}
		else
		{
			$settings['verbose'] = false;
			$settings['logging'] = false;
		}

		if ($_POST['httpbl_key'])
		{
			if (preg_match("/^[a-z]{12}$/", $_POST['httpbl_key']))
			{
				$settings['httpbl_key'] = $_POST['httpbl_key'];
			}
			else
			{
				$settings['httpbl_key'] = '';
			}
		}
		else
		{
			$settings['httpbl_key'] = '';
		}

		if ($_POST['httpbl_threat'])
		{
			$settings['httpbl_threat'] = intval($_POST['httpbl_threat']);
		}
		else
		{
			$settings['httpbl_threat'] = '25';
		}

		if ($_POST['httpbl_maxage'])
		{
			$settings['httpbl_maxage'] = intval($_POST['httpbl_maxage']);
		}
		else
		{
			$settings['httpbl_maxage'] = '30';
		}

		if ($_POST['offsite_forms'])
		{
			$settings['offsite_forms'] = true;
		}
		else
		{
			$settings['offsite_forms'] = false;
		}

		if ($_POST['reverse_proxy'])
		{
			$settings['reverse_proxy'] = true;
		}
		else
		{
			$settings['reverse_proxy'] = false;
		}

		if ($_POST['reverse_proxy_header'])
		{
			$settings['reverse_proxy_header'] = uc_all($_POST['reverse_proxy_header']);
		}
		else
		{
			$settings['reverse_proxy_header'] = 'X-Forwarded-For';
		}

		if ($_POST['reverse_proxy_addresses'])
		{
			$settings['reverse_proxy_addresses'] = preg_split("/[\s,]+/m", $_POST['reverse_proxy_addresses']);
			$settings['reverse_proxy_addresses'] = array_map('sanitize_text_field', $settings['reverse_proxy_addresses']);
		}
		else
		{
			$settings['reverse_proxy_addresses'] = [];
		}

		bb2_write_settings($settings);
?>
	<div id="message" class="updated fade"><p><strong><?php echo $engine->_t('BbOptionsSaved');?></strong></p></div>
<?php
	}
?>
	<div class="wrap">

<?php
	echo $engine->form_open('bb2_options', ['form_more' => 'setting=bb2_options']);
?>
	<input type="hidden" name="action" value="bb2_options">

	<table class="setting formation">
		<colgroup>
			<col span="1">
			<col span="1">
		</colgroup>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label"><strong><?php echo $engine->_t('BbEnable');?></strong><br>
				<small><?php echo Ut::perc_replace($engine->_t('BbEnableInfo'), '<code>bb_settings.conf</code>');?></small></td>
			<td>
				<input type="radio" id="enable_bad-behavior_on" name="enable_bad-behavior" value="1"<?php echo ($engine->db->ext_bad_behavior ? ' checked' : '');?>>
				<label for="enable_bad-behavior_on"><?php echo $engine->_t('On');?></label>
				<input type="radio" id="enable_bad-behavior_off" name="enable_bad-behavior" value="0"<?php echo ( !$engine->db->ext_bad_behavior ? ' checked' : '');?>>
				<label for="enable_bad-behavior_off"><?php echo $engine->_t('Off');?></label>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<br>
				<?php echo $engine->_t('BbLogRequest');?>
			</th>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="logging_verbose"><?php echo $engine->_t('BbLogVerbose');?></label>
			</td>
			<td>
				<input type="radio" id="logging_verbose" name="logging" value="verbose" <?php if ($settings['verbose'] && $settings['logging']) { ?>checked <?php } ?>>
			</td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="logging_normal"><?php echo $engine->_t('BbLogNormal');?></label>
			</td>
			<td>
				<input type="radio" id="logging_normal" name="logging" value="normal" <?php if ($settings['logging'] && !$settings['verbose']) { ?>checked <?php } ?>>
			</td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="logging_false"><?php echo $engine->_t('BbLogOff');?></label>
			</td>
			<td>
				<input type="radio" id="logging_false" name="logging" value="false" <?php if (!$settings['logging']) { ?>checked <?php } ?>>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<br>
				<?php echo $engine->_t('BbSecurity');?>
			</th>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="strict_checking"><strong><?php echo $engine->_t('BbStrict');?></strong><br>
				<?php echo $engine->_t('BbStrictInfo');?></label>
			</td>
			<td><input type="checkbox" id="strict_checking" name="strict" value="true" <?php if ($settings['strict']) { ?>checked <?php } ?>/></td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="offsite_forms"><strong><?php echo $engine->_t('BbOffsiteForms');?></strong><br>
				<?php echo $engine->_t('BbOffsiteFormsInfo');?></label>
			</td>
			<td>
				<input type="checkbox" id="offsite_forms" name="offsite_forms" value="true" <?php if ($settings['offsite_forms']) { ?>checked <?php } ?>>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<br>
				<?php echo $engine->_t('BbHttpbl');?>
			</th>
		</tr>
		<tr class="hl-setting">
			<td colspan="2">
				<p><?php echo Ut::perc_replace(
							$engine->_t('BbHttpblInfo'),
							'<a href="https://www.projecthoneypot.org/httpbl_configure.php?rf=24694" rel="noreferrer">http:BL Access Key</a>'
						);?>
				</p>
				<br>
			</td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="httpbl_key"><?php echo $engine->_t('BbHttpblKey');?></label>
			</td>
			<td>
				<input type="text" size="12" maxlength="12" id="httpbl_key" name="httpbl_key" value="<?php echo $settings['httpbl_key']; ?>">
			</td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="httpbl_threat"><?php echo $engine->_t('BbHttpblThreat');?></label>
			</td>
			<td>
				<input type="text" size="3" maxlength="3" id="httpbl_threat" name="httpbl_threat" value="<?php echo intval($settings['httpbl_threat']); ?>">
			</td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="httpbl_maxage"><?php echo $engine->_t('BbHttpblMaxage');?></label>
			</td>
			<td>
				<input type="text" size="3" maxlength="3" id="httpbl_maxage" name="httpbl_maxage" value="<?php echo intval($settings['httpbl_maxage']); ?>">
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<br>
				<?php echo $engine->_t('BbReverseProxy');?>
			</th>
		</tr>
		<tr class="hl-setting">
			<td colspan="2">
				<div>
					<?php echo Ut::perc_replace(
							$engine->_t('BbReverseProxyInfo'),
							'<code><a href="https://en.wikipedia.org/wiki/X-Forwarded-For" rel="noreferrer">X-Forwarded-For</a></code>',
							'<code>X-Real-Ip</code> (nginx)',
							'<code>Cf-Connecting-Ip</code> (CloudFlare)'
						);?>
					<br>
				</div>
			</td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="reverse_proxy"><?php echo $engine->_t('BbReverseProxyEnable');?></label>
			</td>
			<td>
				<input type="checkbox" id="reverse_proxy" name="reverse_proxy" value="true" <?php if ($settings['reverse_proxy']) { ?>checked <?php } ?>>
			</td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="reverse_proxy_header"><?php echo $engine->_t('BbReverseProxyHeader');?></label>
			</td>
			<td>
				<input type="text" size="32" id="reverse_proxy_header" name="reverse_proxy_header" value="<?php echo $settings['reverse_proxy_header']; ?>">
			</td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="reverse_proxy_addresses"><?php echo $engine->_t('BbReverseProxyAddresses');?></label>
			</td>
			<td>
				<textarea cols="24" rows="6" id="reverse_proxy_addresses" name="reverse_proxy_addresses"><?php echo implode("\n", $settings['reverse_proxy_addresses']); ?></textarea>
			</td>
		</tr>
	</table>
	<br>
	<div class="center"><button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button></div>
	<?php
		echo $engine->form_close();
	?>
		</div>
	<?php
	}

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'bb2_options')
	{
		$config['ext_bad_behavior'] = (int) $_POST['ext_bad_behavior'];

		$engine->config->_set($config);

		$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
		$engine->set_message($engine->_t('BbSettingsUpdated'));
		$engine->http->redirect($engine->href());
	}

	if (isset($_POST['action']) && $_POST['action'] == 'purge_badbehavior')
	{
		$sql = "TRUNCATE " . $engine->prefix . "badbehavior";
		$engine->db->sql_query($sql);

		// queries
		$engine->config->invalidate_sql_cache();
	}


	#######################################################################################################


	?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<?php echo Ut::perc_replace($engine->_t('BbInfo'), '<a href="https://bad-behavior.ioerror.us/" rel="noreferrer">Bad Behavior</a>');?>
	<br><br>
	<?php
	$mode_selector	= 'setting';
	$mode			= @$_GET[$mode_selector];

	// navigation
	$tabs	= [
		''					=> 'BbSummary',
		'bb2_manage'		=> 'BbLog',
		'bb2_options'		=> 'BbSettings',
		'bb2_whitelist'		=> 'BbWhitelist',
	];

	if (!array_key_exists($mode, $tabs))
	{
		$mode = '';
	}

	echo '<h2>' . $engine->_t($tabs[$mode]) . "</h2>";
	echo '<p>' . $engine->tab_menu($tabs, $mode, '', [], $mode_selector) . '</p><br>';

	if (!empty($engine->db->ext_bad_behavior))
	{
		if (isset($_GET['setting']) && $_GET['setting'] == 'bb2_options')
		{
			bb2_options($engine);
		}
		else if (isset($_GET['setting']) && $_GET['setting'] == 'bb2_whitelist')
		{
			bb2_whitelist($engine);
		}
		else if (isset($_GET['setting']) && $_GET['setting'] == 'bb2_manage')
		{
			bb2_manage($engine);
		}
		else
		{
			bb2_summary($engine);
		}
	}
	else
	{
		echo $engine->form_open('bb2_options', ['form_more' => 'setting=bb2_options']);
	?>
		<br>
		<input type="hidden" name="action" value="bb2_options">

		<table class="formation">
			<colgroup>
				<col span="1">
				<col span="1" style="width:50%;">
			</colgroup>
			<tbody>
				<tr class="hl-setting">
					<th scope="row" class="label">
						<strong><?php echo $engine->_t('BbEnable');?></strong><br>
						<small><?php echo Ut::perc_replace($engine->_t('BbEnableInfo'), '<code>bb_settings.conf</code>');?></small>
					</th>
					<td>
						<input type="radio" id="enable_bad-behavior_on" name="ext_bad_behavior" value="1" <?php echo ($engine->db->ext_bad_behavior ? ' checked' : '');?>>
						<label for="enable_bad-behavior_on"><?php echo $engine->_t('On');?></label>
						<input type="radio" id="enable_bad-behavior_off" name="ext_bad_behavior" value="0" <?php echo (!$engine->db->ext_bad_behavior ? ' checked' : '');?>>
						<label for="enable_bad-behavior_off"><?php echo $engine->_t('Off');?></label>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<div class="center"><button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button></div>
	<?php
		echo $engine->form_close();
	}
}
