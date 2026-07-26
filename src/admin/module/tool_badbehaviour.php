<?php

if (!defined('IN_WACKO'))
{
	exit;
}

use BadBehaviour\Core\ResultCode;

##########################################################
##	Bad Behaviour										##
##########################################################

$module['tool_badbehaviour'] = [
		'order'	=> 800,
		'cat'	=> 'extension',
		'status'=> !RECOVERY_MODE,
	];

##########################################################
function admin_tool_badbehaviour($engine, $module)
{
	if (!empty($engine->db->ext_bad_behaviour))
	{
		// REMOVE: require_once 'vendor/badbehaviour/badbehaviour/src/responses.inc.php';
		// USE NEW API INSTEAD:
	}

	// Replace bb2_get_response() function with new implementation:
	function bb2_get_response($key)
	{
		// Map legacy hex codes to new ResultCode enum
		$legacy_map = [
			'00000000' => ['response' => 200, 'explanation' => '', 'log' => 'Permitted'],
			'17566707' => ['response' => 403, 'explanation' => 'An invalid request was received from your browser. This may be caused by a malfunctioning proxy server or browser privacy software.', 'log' => 'Required header \'Accept\' missing'],
			'17f4e8c8' => ['response' => 403, 'explanation' => 'You do not have permission to access this server.', 'log' => 'User-Agent was found on blacklist'],
			'2b021b1f' => ['response' => 403, 'explanation' => 'You do not have permission to access this server. Before trying again, run anti-virus and anti-spyware software and remove any viruses and spyware from your computer.', 'log' => 'IP address found on http:BL blacklist'],
			'96c0bd29' => ['response' => 403, 'explanation' => 'You do not have permission to access this server.', 'log' => 'URL pattern found on blacklist'],
			'a1084bad' => ['response' => 403, 'explanation' => 'You do not have permission to access this server.', 'log' => 'User-Agent claimed to be MSIE, with invalid Windows version'],
			'cd361abb' => ['response' => 403, 'explanation' => 'You do not have permission to access this server. Data may not be posted from offsite forms.', 'log' => 'Referer did not point to a form on this site'],
			'dfd9b1ad' => ['response' => 403, 'explanation' => 'You do not have permission to access this server.', 'log' => 'Request contained a malicious JavaScript or SQL injection attack'],
			'f0dcb3fd' => ['response' => 403, 'explanation' => 'You do not have permission to access this server. Before trying again, run anti-virus and anti-spyware software and remove any viruses and spyware from your computer.', 'log' => 'Web browser attempted to send a trackback'],
			'f9f2b8b9' => ['response' => 403, 'explanation' => 'You do not have permission to access this server. This may be caused by a malfunctioning proxy server or browser privacy software.', 'log' => 'A User-Agent is required but none was provided.'],
		];

		// Check new semantic codes first
		try {
			$code = ResultCode::from($key);
			return [
				'response' => $code->http_status(),
				'explanation' => $code->getMessage() ?? '',
				'log' => $code->value,
			];
		} catch (\ValueError $e) {
			// Fall back to legacy map
			return $legacy_map[$key] ?? ['response' => 403, 'explanation' => 'Unknown error', 'log' => $key];
		}
	}

	$action = $_POST['_action'] ?? null;

	function bb2_read_settings($engine)
	{
		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);

		return $adapter->get_settings();
	}

	function bb2_read_whitelist($engine)
	{
		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);

		return $adapter->get_whitelist();
	}

	function bb2_httpbl_lookup($engine, $ip)
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

		$settings		= bb2_read_settings($engine);
		$httpbl_key		= $settings['httpbl_key'];

		if (!$httpbl_key) return false;

		$r = $engine->sess->httpbl[$ip];
		$d = '';

		if (!$r)
		{
			// Lookup
			$find		= implode('.', array_reverse(explode('.', $ip)));
			$result		= gethostbynamel("{$httpbl_key}.{$find}.dnsbl.httpbl.org.");

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
						$d .= "Search engine {$ip[2]}<br>\n";
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
					$d .= "Threat level {$ip[2]}<br>\n";
				}

				if ($ip[3] > 0)
				{
					$d .= "Age {$ip[1]} days<br>\n";
				}
			}
		}

		return $d;
	}

	function bb2_insert_stats($engine)
	{
		$result = $engine->db->load_single(
			"SELECT COUNT(log_id) AS n FROM " . $engine->prefix . 'bad_behaviour ' .
			" WHERE `status_code` NOT LIKE '00000000'"
		);

		return $result['n'] ?: '';
	}

	function bb2_summary($engine)
	{
		echo $engine->form_open('bb2_manage', ['form_more' => 'setting=bb2_manage']);
		?>

		<div class="alignleft">
		<?php echo Ut::perc_replace($engine->_t('BbStats'), '<strong>' . bb2_insert_stats($engine) . '</strong>');?>
		</div>
		<?php
		// select arguments
		$arguments = [
			'status_code',
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
			$binary		= $engine->db->binary();
			$results	= $engine->db->load_all(
				'SELECT ' .
					'CAST(' . $argument . ' AS ' . $binary . ') AS group_type, ' .
					$additional_fields .
					' COUNT(' . $argument . ') AS n ' .
				'FROM ' . $engine->prefix . 'bad_behaviour ' .
				'GROUP BY CAST(' . $argument . ' AS ' . $binary . ') ' .
				'ORDER BY n DESC ' .
				'LIMIT 10', true);

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

					if ($argument == 'status_code')
					{
						$status_code	= bb2_get_response($result['group_type']);
						$link		= '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'status_code' => $result['group_type']]) . '" title="' . '[' . $status_code['response'] . '] ' . $status_code['explanation'] . '">' . $status_code['log'] . '</a>';
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

	function bb2_manage($engine)
	{
		$bb_table		= $engine->prefix . 'bad_behaviour';
		$settings		= bb2_read_settings($engine);

		$where			= '';

		$g_key				= ($_GET['status_code']		?? '');
		$g_blocked			= ($_GET['blocked']			?? '');
		$g_permitted		= ($_GET['permitted']		?? '');
		$g_ip				= ($_GET['ip']				?? '');
		$g_user_agent		= ($_GET['user_agent']		?? '');
		$g_request_method	= ($_GET['request_method']	?? '');
		$g_request_uri		= ($_GET['request_uri']		?? '');

		// entries to display
		$limit = 100;

		// Get query variables desired by the user with input validation
		if (!empty($g_key))					$where .= 'AND `status_code`			= ' . $engine->db->q($g_key) . ' ';
		if (!empty($g_blocked))				$where .= "AND `status_code` 		!= '00000000' ";
		else if (!empty($g_permitted))		$where .= "AND `status_code`			= '00000000' ";

		if (!empty($g_ip))					$where .= 'AND `ip` 				= ' . $engine->db->q($g_ip) . ' ';
		if (!empty($g_user_agent))			$where .= 'AND `user_agent_hash`	= ' . $engine->db->q($g_user_agent) . ' ';
		if (!empty($g_request_method))		$where .= 'AND `request_method`		= ' . $engine->db->q($g_request_method) . ' ';
		if (!empty($g_request_uri))			$where .= 'AND `request_uri_hash`	= ' . $engine->db->q($g_request_uri) . ' ';

		// collecting data
		$count = $engine->db->load_single(
			'SELECT COUNT(log_id) AS n ' .
			'FROM ' . $engine->prefix . 'bad_behaviour l ' .
			'WHERE 1=1 ' . ( $where ?: '' ));



		$pagination			= $engine->pagination($count['n'], $limit, 'p', ['mode' => 'tool_badbehaviour', 'setting' => 'bb2_manage']
								+ (!empty($g_blocked)			? ['blocked'		=> Ut::html($g_blocked)] : [])
								+ (!empty($g_permitted)			? ['permitted'		=> Ut::html($g_permitted)] : [])
								+ (!empty($g_key)				? ['status_code'		=> Ut::html($g_key)] : [])
								+ (!empty($g_ip)				? ['ip'				=> Ut::html($g_ip)] : [])
								+ (!empty($g_request_method)	? ['request_method'	=> Ut::html($g_request_method)] : [])
								+ (!empty($g_request_uri)		? ['request_uri'	=> Ut::html($g_request_uri)] : [])
								+ (!empty($g_user_agent)		? ['user_agent'		=> Ut::html($g_user_agent)] : []), '', 'admin.php');

		// Query the DB based on variables selected

		$totalcount		= $engine->db->load_single(
			'SELECT COUNT(log_id) AS n ' .
			'FROM ' . $engine->prefix . 'bad_behaviour l ');

		$results		= $engine->db->load_all(
			'SELECT log_id, ip, host, date, request_method, request_uri, server_protocol, http_headers, user_agent, user_agent_hash, request_entity, status_code ' .
			'FROM `' . $bb_table . '` ' .
			'WHERE 1=1 ' .
			$where .
			'ORDER BY `log_id` DESC ' .
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

			if (!empty($g_key))				echo '<strong>' . $engine->_t('BbStatus')		. '</strong> ' . $link . ' ';
			if (!empty($g_blocked))			echo '<strong>' . $engine->_t('BbBlocked')		. '</strong> ' . $link . ' ';
			if (!empty($g_permitted))		echo '<strong>' . $engine->_t('BbPermitted')	. '</strong> ' . $link . ' ';
			if (!empty($g_ip))				echo '<strong>' . $engine->_t('BbIp')			. '</strong> ' . $link . ' ';
			if (!empty($g_user_agent))		echo '<strong>' . $engine->_t('BbUserAgent')	. '</strong> ' . $link . ' ';
			if (!empty($g_request_method))	echo '<strong>' . $engine->_t('BbGetPost')		. '</strong> ' . $link . ' ';
			if (!empty($g_request_uri))		echo '<strong>' . $engine->_t('BbUri')			. '</strong> ' . $link . ' ';
		}

		if (!isset($_GET['status_code']))
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
				$status_code = bb2_get_response($result['status_code']);

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
						'UPDATE ' . $engine->prefix . 'bad_behaviour SET ' .
							'host		= ' . $engine->db->q($host) . ' ' .
						'WHERE log_id	= ' . (int) $result['log_id'] . ' ' .
						$engine->db->limit());
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
						'<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'status_code' => $result['status_code']]) . '" title="' .'[' . $status_code['response'] . '] ' . $status_code['explanation']. '">' . $status_code['log'] . '</a>' . "\n";

				if ($httpbl)
				{
					echo "<br><br><a href=\"https://www.projecthoneypot.org/ip_{$result['ip']}\">http:BL</a>:<br>$httpbl\n";
				}

				echo '</td>' . "\n";

				$headers = str_replace("\n", "<br>\n", Ut::html($result['http_headers']));

				if (@str_contains($headers, $result['user_agent']))
				{
					$headers = substr_replace($headers, '<a href="' . $engine->href('', '', ['setting' => 'bb2_manage', 'user_agent' => rawurlencode($result['user_agent_hash'])]) . '">' . $result['user_agent'] . '</a>', strpos($headers, $result['user_agent']), strlen($result['user_agent']));
				}

				if (@str_contains($headers, $result['request_method']))
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

	function bb2_whitelist($engine)
	{
		$whitelists = bb2_read_whitelist($engine);

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
				$whitelists['ip'] = array_filter(preg_split('/\s+/m', $_POST['ip']));
			}
			else
			{
				$whitelists['ip'] = [];
			}

			if ($_POST['url'])
			{
				$whitelists['url'] = array_filter(preg_split('/\s+/m', $_POST['url']));
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

			#update_option('bad_behaviour_whitelist', $whitelists);
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
					<textarea cols="30" rows="6" id="whitelists_ip" name="ip"><?php echo implode("\n", $whitelists['ip']); ?></textarea>
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
					<textarea cols="50" rows="6" id="whitelists_url" name="url"><?php echo implode("\n", $whitelists['url']); ?></textarea>
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
					<textarea cols="50" rows="6" id="whitelists_useragent" name="useragent"><?php echo implode("\n", $whitelists['useragent']); ?></textarea>
				</td>
			</tr>
		</table>
		<br>
		<div class="center"><button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button></div>

	<?php
		echo $engine->form_close();
	}

	function bb2_options($engine)
	{
		$settings = bb2_read_settings($engine);

		// update settings
		if (isset($_POST['action']) && $_POST['action'] == 'update')
		{
			$config['ext_bad_behaviour'] = (int) $_POST['ext_bad_behaviour'];
			$engine->db->_set($config);
			$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
			$engine->set_message($engine->_t('BbSettingsUpdated'));
			$engine->http->redirect($engine->href());
		}

		if ($_POST)
		{
			// Core
			$settings['strict']        = isset($_POST['strict']);
			$settings['verbose']       = isset($_POST['verbose']);
			$settings['logging']       = isset($_POST['logging']);
			$settings['offsite_forms'] = isset($_POST['offsite_forms']);

			// Reverse proxy
			$settings['reverse_proxy']            = isset($_POST['reverse_proxy']);
			$settings['reverse_proxy_header']     = $_POST['reverse_proxy_header'] ?? 'X-Forwarded-For';
			$settings['reverse_proxy_addresses']  = array_filter(array_map('trim', explode("\n", $_POST['reverse_proxy_addresses'] ?? '')));

			// http:BL
			$settings['httpbl_key']       = preg_match('/^[a-z]{12}$/', $_POST['httpbl_key'] ?? '') ? $_POST['httpbl_key'] : '';
			$settings['httpbl_threat']    = (int)($_POST['httpbl_threat'] ?? 25);
			$settings['httpbl_maxage']    = (int)($_POST['httpbl_maxage'] ?? 30);

			// NEW: DNSBL
			$settings['dnsbl_enabled']    = isset($_POST['dnsbl_enabled']);
			$settings['dnsbl_lists']      = array_filter(array_map('trim', explode("\n", $_POST['dnsbl_lists'] ?? '')));

			// NEW: AI Crawlers
			$settings['block_unverified_ai'] = isset($_POST['block_unverified_ai']);
			$settings['strict_ai']         = isset($_POST['strict_ai']);
			$settings['allowed_ai_crawlers'] = array_filter(array_map('trim', explode("\n", $_POST['allowed_ai_crawlers'] ?? '')));

			// NEW: Behavioral
			$settings['enable_behavioral_analysis'] = isset($_POST['enable_behavioral_analysis']);
			$settings['enable_fingerprinting']      = isset($_POST['enable_fingerprinting']);
			$settings['inspect_json_body']          = isset($_POST['inspect_json_body']);
			$settings['inspect_multipart_body']     = isset($_POST['inspect_multipart_body']);

			// NEW: Rate limits
			$settings['rate_limit_enabled'] = isset($_POST['rate_limit_enabled']);
			$settings['rate_limits']['global']['requests']     = (int)($_POST['rate_global_requests'] ?? 1000);
			$settings['rate_limits']['global']['window']       = (int)($_POST['rate_global_window'] ?? 3600);
			$settings['rate_limits']['per_minute']['requests'] = (int)($_POST['rate_per_minute_requests'] ?? 60);
			$settings['rate_limits']['per_minute']['window']   = (int)($_POST['rate_per_minute_window'] ?? 60);
			$settings['rate_limits']['post']['requests']       = (int)($_POST['rate_post_requests'] ?? 30);
			$settings['rate_limits']['post']['window']         = (int)($_POST['rate_post_window'] ?? 3600);
			$settings['rate_limits']['login']['requests']      = (int)($_POST['rate_login_requests'] ?? 10);
			$settings['rate_limits']['login']['window']        = (int)($_POST['rate_login_window'] ?? 900);

			// NEW: Challenge
			$settings['challenge_enabled']     = isset($_POST['challenge_enabled']);
			$settings['challenge_provider']    = $_POST['challenge_provider'] ?? 'builtin';
			$settings['challenge_site_key']    = $_POST['challenge_site_key'] ?? '';
			$settings['challenge_secret_key']  = $_POST['challenge_secret_key'] ?? '';
			$settings['recaptcha_min_score']   = (float)($_POST['recaptcha_min_score'] ?? 0.5);

			// NEW: Performance
			$settings['skip_static_extensions'] = array_filter(array_map('trim', explode("\n", $_POST['skip_static_extensions'] ?? '')));
			$settings['skip_static_paths']      = array_filter(array_map('trim', explode("\n", $_POST['skip_static_paths'] ?? '')));

			// NEW: GeoIP
			$settings['geoip_enabled']     = isset($_POST['geoip_enabled']);
			$settings['geoip_database_path'] = $_POST['geoip_database_path'] ?? '';
			$settings['blocked_countries'] = array_filter(array_map('trim', explode("\n", $_POST['blocked_countries'] ?? '')));
			$settings['blocked_asns']      = array_filter(array_map('trim', explode("\n", $_POST['blocked_asns'] ?? '')));

			bb2_write_settings($engine, $settings);
			?>
    <div id="message" class="updated fade"><p><strong><?php echo $engine->_t('BbOptionsSaved');?></strong></p></div>
<?php
    }
?>
    <div class="wrap">
<?php
    echo $engine->form_open('bb2_options', ['form_more' => 'setting=bb2_options']);
?>
    <table class="setting formation">
        <colgroup>
            <col span="1">
            <col span="1">
        </colgroup>

        <!-- ENABLE/DISABLE -->
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><strong><?php echo $engine->_t('BbEnable');?></strong><br>
                <small><?php echo Ut::perc_replace($engine->_t('BbEnableInfo'), '<code>bb_settings.conf</code>');?></small></td>
            <td>
                <input type="radio" id="enable_bad-behaviour_on" name="ext_bad_behaviour" value="1"<?php echo ($engine->db->ext_bad_behaviour ? ' checked' : '');?>>
                <label for="enable_bad-behaviour_on"><?php echo $engine->_t('On');?></label>
                <input type="radio" id="enable_bad-behaviour_off" name="ext_bad_behaviour" value="0"<?php echo (!$engine->db->ext_bad_behaviour ? ' checked' : '');?>>
                <label for="enable_bad-behaviour_off"><?php echo $engine->_t('Off');?></label>
            </td>
        </tr>

        <!-- LOGGING -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbLogRequest');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="logging_verbose"><?php echo $engine->_t('BbLogVerbose');?></label></td>
            <td><input type="checkbox" id="logging_verbose" name="verbose" value="1"<?php echo ($settings['verbose'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="logging_normal"><?php echo $engine->_t('BbLogNormal');?></label></td>
            <td><input type="checkbox" id="logging_normal" name="logging" value="1"<?php echo ($settings['logging'] ? ' checked' : '');?>></td>
        </tr>

        <!-- SECURITY -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbSecurity');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="strict_checking"><strong><?php echo $engine->_t('BbStrict');?></strong><br><?php echo $engine->_t('BbStrictInfo');?></label></td>
            <td><input type="checkbox" id="strict_checking" name="strict" value="1"<?php echo ($settings['strict'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="offsite_forms"><strong><?php echo $engine->_t('BbOffsiteForms');?></strong><br><?php echo $engine->_t('BbOffsiteFormsInfo');?></label></td>
            <td><input type="checkbox" id="offsite_forms" name="offsite_forms" value="1"<?php echo ($settings['offsite_forms'] ? ' checked' : '');?>></td>
        </tr>

        <!-- NEW: BEHAVIORAL ANALYSIS -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbBehavioral');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="enable_behavioral"><strong><?php echo $engine->_t('BbEnableBehavioral');?></strong><br><?php echo $engine->_t('BbEnableBehavioralInfo');?></label></td>
            <td><input type="checkbox" id="enable_behavioral" name="enable_behavioral_analysis" value="1"<?php echo ($settings['enable_behavioral_analysis'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="enable_fingerprinting"><strong><?php echo $engine->_t('BbEnableFingerprinting');?></strong><br><?php echo $engine->_t('BbEnableFingerprintingInfo');?></label></td>
            <td><input type="checkbox" id="enable_fingerprinting" name="enable_fingerprinting" value="1"<?php echo ($settings['enable_fingerprinting'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="inspect_json"><strong><?php echo $engine->_t('BbInspectJson');?></strong><br><?php echo $engine->_t('BbInspectJsonInfo');?></label></td>
            <td><input type="checkbox" id="inspect_json" name="inspect_json_body" value="1"<?php echo ($settings['inspect_json_body'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="inspect_multipart"><strong><?php echo $engine->_t('BbInspectMultipart');?></strong><br><?php echo $engine->_t('BbInspectMultipartInfo');?></label></td>
            <td><input type="checkbox" id="inspect_multipart" name="inspect_multipart_body" value="1"<?php echo ($settings['inspect_multipart_body'] ? ' checked' : '');?>></td>
        </tr>

        <!-- NEW: AI CRAWLERS -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbAiCrawlers');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="block_unverified_ai"><strong><?php echo $engine->_t('BbBlockUnverifiedAi');?></strong><br><?php echo $engine->_t('BbBlockUnverifiedAiInfo');?></label></td>
            <td><input type="checkbox" id="block_unverified_ai" name="block_unverified_ai" value="1"<?php echo ($settings['block_unverified_ai'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="strict_ai"><strong><?php echo $engine->_t('BbStrictAi');?></strong><br><?php echo $engine->_t('BbStrictAiInfo');?></label></td>
            <td><input type="checkbox" id="strict_ai" name="strict_ai" value="1"<?php echo ($settings['strict_ai'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="allowed_ai_crawlers"><strong><?php echo $engine->_t('BbAllowedAiCrawlers');?></strong><br><?php echo $engine->_t('BbAllowedAiCrawlersInfo');?></label></td>
            <td>
                <textarea cols="50" rows="4" id="allowed_ai_crawlers" name="allowed_ai_crawlers"><?php echo implode("\n", $settings['allowed_ai_crawlers'] ?? []); ?></textarea>
            </td>
        </tr>

        <!-- HTTP:BL -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbHttpbl');?></th></tr>
        <tr class="hl-setting"><td colspan="2"><p><?php echo Ut::perc_replace($engine->_t('BbHttpblInfo'), '<a href="https://www.projecthoneypot.org/httpbl_configure.php?rf=24694" rel="noreferrer">http:BL Access Key</a>');?><br></p></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="httpbl_key"><?php echo $engine->_t('BbHttpblKey');?></label></td>
            <td><input type="text" size="12" maxlength="12" id="httpbl_key" name="httpbl_key" value="<?php echo $settings['httpbl_key']; ?>"></td>
        </tr>
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="httpbl_threat"><?php echo $engine->_t('BbHttpblThreat');?></label></td>
            <td><input type="text" size="3" maxlength="3" id="httpbl_threat" name="httpbl_threat" value="<?php echo intval($settings['httpbl_threat']); ?>"></td>
        </tr>
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="httpbl_maxage"><?php echo $engine->_t('BbHttpblMaxage');?></label></td>
            <td><input type="text" size="3" maxlength="3" id="httpbl_maxage" name="httpbl_maxage" value="<?php echo intval($settings['httpbl_maxage']); ?>"></td>
        </tr>

        <!-- NEW: DNSBL -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbDnsbl');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="dnsbl_enabled"><strong><?php echo $engine->_t('BbDnsblEnabled');?></strong></label></td>
            <td><input type="checkbox" id="dnsbl_enabled" name="dnsbl_enabled" value="1"<?php echo ($settings['dnsbl_enabled'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="dnsbl_lists"><strong><?php echo $engine->_t('BbDnsblLists');?></strong><br><?php echo $engine->_t('BbDnsblListsInfo');?></label></td>
            <td><textarea cols="50" rows="4" id="dnsbl_lists" name="dnsbl_lists"><?php echo implode("\n", $settings['dnsbl_lists'] ?? []); ?></textarea></td>
        </tr>

        <!-- NEW: RATE LIMITS -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbRateLimits');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_limit_enabled"><strong><?php echo $engine->_t('BbRateLimitEnabled');?></strong></label></td>
            <td><input type="checkbox" id="rate_limit_enabled" name="rate_limit_enabled" value="1"<?php echo ($settings['rate_limit_enabled'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_global_requests"><?php echo $engine->_t('BbRateGlobalRequests');?></label></td>
            <td><input type="text" size="6" id="rate_global_requests" name="rate_global_requests" value="<?php echo $settings['rate_limits']['global']['requests']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_global_window"><?php echo $engine->_t('BbRateGlobalWindow');?></label></td>
            <td><input type="text" size="6" id="rate_global_window" name="rate_global_window" value="<?php echo $settings['rate_limits']['global']['window']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_per_minute_requests"><?php echo $engine->_t('BbRatePerMinuteRequests');?></label></td>
            <td><input type="text" size="6" id="rate_per_minute_requests" name="rate_per_minute_requests" value="<?php echo $settings['rate_limits']['per_minute']['requests']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_per_minute_window"><?php echo $engine->_t('BbRatePerMinuteWindow');?></label></td>
            <td><input type="text" size="6" id="rate_per_minute_window" name="rate_per_minute_window" value="<?php echo $settings['rate_limits']['per_minute']['window']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_post_requests"><?php echo $engine->_t('BbRatePostRequests');?></label></td>
            <td><input type="text" size="6" id="rate_post_requests" name="rate_post_requests" value="<?php echo $settings['rate_limits']['post']['requests']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_post_window"><?php echo $engine->_t('BbRatePostWindow');?></label></td>
            <td><input type="text" size="6" id="rate_post_window" name="rate_post_window" value="<?php echo $settings['rate_limits']['post']['window']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_login_requests"><?php echo $engine->_t('BbRateLoginRequests');?></label></td>
            <td><input type="text" size="6" id="rate_login_requests" name="rate_login_requests" value="<?php echo $settings['rate_limits']['login']['requests']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="rate_login_window"><?php echo $engine->_t('BbRateLoginWindow');?></label></td>
            <td><input type="text" size="6" id="rate_login_window" name="rate_login_window" value="<?php echo $settings['rate_limits']['login']['window']; ?>"></td>
        </tr>

        <!-- NEW: CHALLENGE -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbChallenge');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="challenge_enabled"><strong><?php echo $engine->_t('BbChallengeEnabled');?></strong></label></td>
            <td><input type="checkbox" id="challenge_enabled" name="challenge_enabled" value="1"<?php echo ($settings['challenge_enabled'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="challenge_provider"><?php echo $engine->_t('BbChallengeProvider');?></label></td>
            <td>
                <select id="challenge_provider" name="challenge_provider">
                    <option value="builtin"<?php echo ($settings['challenge_provider'] === 'builtin' ? ' selected' : '');?>>Builtin (PoW)</option>
                    <option value="hcaptcha"<?php echo ($settings['challenge_provider'] === 'hcaptcha' ? ' selected' : '');?>>hCaptcha</option>
                    <option value="recaptcha"<?php echo ($settings['challenge_provider'] === 'recaptcha' ? ' selected' : '');?>>reCAPTCHA v3</option>
                    <option value="turnstile"<?php echo ($settings['challenge_provider'] === 'turnstile' ? ' selected' : '');?>>Cloudflare Turnstile</option>
                </select>
            </td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="challenge_site_key"><?php echo $engine->_t('BbChallengeSiteKey');?></label></td>
            <td><input type="text" size="40" id="challenge_site_key" name="challenge_site_key" value="<?php echo $settings['challenge_site_key']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="challenge_secret_key"><?php echo $engine->_t('BbChallengeSecretKey');?></label></td>
            <td><input type="text" size="40" id="challenge_secret_key" name="challenge_secret_key" value="<?php echo $settings['challenge_secret_key']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="recaptcha_min_score"><?php echo $engine->_t('BbRecaptchaMinScore');?></label></td>
            <td><input type="text" size="4" step="0.1" id="recaptcha_min_score" name="recaptcha_min_score" value="<?php echo $settings['recaptcha_min_score']; ?>"></td>
        </tr>

        <!-- NEW: PERFORMANCE -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbPerformance');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="skip_static_extensions"><strong><?php echo $engine->_t('BbSkipExtensions');?></strong></label></td>
            <td><textarea cols="50" rows="3" id="skip_static_extensions" name="skip_static_extensions"><?php echo implode("\n", $settings['skip_static_extensions'] ?? []); ?></textarea></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="skip_static_paths"><strong><?php echo $engine->_t('BbSkipPaths');?></strong></label></td>
            <td><textarea cols="50" rows="3" id="skip_static_paths" name="skip_static_paths"><?php echo implode("\n", $settings['skip_static_paths'] ?? []); ?></textarea></td>
        </tr>

        <!-- NEW: GEOIP -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbGeoip');?></th></tr>
        <tr class="hl-setting">
            <td class="label"><label for="geoip_enabled"><strong><?php echo $engine->_t('BbGeoipEnabled');?></strong></label></td>
            <td><input type="checkbox" id="geoip_enabled" name="geoip_enabled" value="1"<?php echo ($settings['geoip_enabled'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="geoip_database_path"><?php echo $engine->_t('BbGeoipDbPath');?></label></td>
            <td><input type="text" size="60" id="geoip_database_path" name="geoip_database_path" value="<?php echo $settings['geoip_database_path']; ?>"></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="blocked_countries"><?php echo $engine->_t('BbBlockedCountries');?></label></td>
            <td><textarea cols="30" rows="3" id="blocked_countries" name="blocked_countries"><?php echo implode("\n", $settings['blocked_countries'] ?? []); ?></textarea></td>
        </tr>
        <tr class="hl-setting">
            <td class="label"><label for="blocked_asns"><?php echo $engine->_t('BbBlockedAsns');?></label></td>
            <td><textarea cols="30" rows="3" id="blocked_asns" name="blocked_asns"><?php echo implode("\n", $settings['blocked_asns'] ?? []); ?></textarea></td>
        </tr>

        <!-- REVERSE PROXY -->
        <tr><th colspan="2"><br><?php echo $engine->_t('BbReverseProxy');?></th></tr>
        <tr class="hl-setting"><td colspan="2"><div><?php echo Ut::perc_replace($engine->_t('BbReverseProxyInfo'), '<code><a href="https://en.wikipedia.org/wiki/X-Forwarded-For" rel="noreferrer">X-Forwarded-For</a></code>', '<code>X-Real-Ip</code> (nginx)', '<code>Cf-Connecting-Ip</code> (CloudFlare)');?><br></div></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="reverse_proxy"><?php echo $engine->_t('BbReverseProxyEnable');?></label></td>
            <td><input type="checkbox" id="reverse_proxy" name="reverse_proxy" value="1"<?php echo ($settings['reverse_proxy'] ? ' checked' : '');?>></td>
        </tr>
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="reverse_proxy_header"><?php echo $engine->_t('BbReverseProxyHeader');?></label></td>
            <td><input type="text" size="32" id="reverse_proxy_header" name="reverse_proxy_header" value="<?php echo $settings['reverse_proxy_header']; ?>"></td>
        </tr>
        <tr class="lined"><td colspan="2"></td></tr>
        <tr class="hl-setting">
            <td class="label"><label for="reverse_proxy_addresses"><?php echo $engine->_t('BbReverseProxyAddresses');?></label></td>
            <td><textarea cols="30" rows="6" id="reverse_proxy_addresses" name="reverse_proxy_addresses"><?php echo implode("\n", $settings['reverse_proxy_addresses'] ?? []); ?></textarea></td>
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
	if ($action == 'bb2_options')
	{
		$config['ext_bad_behaviour'] = (int) $_POST['ext_bad_behaviour'];

		$engine->db->_set($config);

		$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
		$engine->set_message($engine->_t('BbSettingsUpdated'));
		$engine->http->redirect($engine->href());
	}

	if ($action == 'purge_badbehaviour')
	{
		$sql = 'TRUNCATE ' . $engine->prefix . 'badbehaviour';
		$engine->db->sql_query($sql);

		// queries
		$engine->db->invalidate_sql_cache();
	}


	#######################################################################################################


	?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<?php echo Ut::perc_replace($engine->_t('BbInfo'), '<a href="https://github.com/Bad-Behaviour/badbehaviour" rel="noreferrer">Bad Behaviour</a>');?>
	<br><br>
	<?php
	$mode_selector	= 'setting';
	$mode			= $_GET[$mode_selector] ?? '';

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

	echo '<h2>' . $engine->_t($tabs[$mode]) . '</h2>';
	echo '<p>' . $engine->tab_menu($tabs, $mode, '', [], $mode_selector) . '</p><br>';

	if (!empty($engine->db->ext_bad_behaviour))
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
						<input type="radio" id="enable_bad-behaviour_on" name="ext_bad_behaviour" value="1" <?php echo ($engine->db->ext_bad_behaviour ? ' checked' : '');?>>
						<label for="enable_bad-behaviour_on"><?php echo $engine->_t('On');?></label>
						<input type="radio" id="enable_bad-behaviour_off" name="ext_bad_behaviour" value="0" <?php echo (!$engine->db->ext_bad_behaviour ? ' checked' : '');?>>
						<label for="enable_bad-behaviour_off"><?php echo $engine->_t('Off');?></label>
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
