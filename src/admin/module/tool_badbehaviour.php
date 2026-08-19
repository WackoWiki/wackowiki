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
	'order'		=> 800,
	'cat'		=> 'extension',
	'status'	=> !RECOVERY_MODE,
];

##########################################################
function admin_tool_badbehaviour($engine, $module)
{
	/**
	 * Build a lookup table: status_code => ['response', 'explanation', 'log'].
	 * All ResultCode enum values are pre-populated; legacy 2.x hex codes
	 * fall back to a '__unknown__' entry.
	 *
	 * @return array<string, array{response: int, explanation: string, log: string}>
	 */
	function bb_get_responses($engine): array
	{
		$map = [];

		foreach (ResultCode::cases() as $code)
		{
			$localized_key = 'BbStatus_' . $code->value;
			$translated = $engine->_t($localized_key);

			$explanation = ($translated === $localized_key)
				? ($code->getMessage() ?? '')
				: $translated;

			$map[$code->value] = [
				'response'	=> $code->http_status(),
				'explanation' => $explanation,
				'log'		 => $code->value,
			];
		}

		$map['__unknown__'] = ['response' => 403, 'explanation' => 'Unknown error', 'log' => '__unknown__'];

		return $map;
	}

	function bb_get_response($engine, string $key): array
	{
		$map = bb_get_responses($engine);
		return $map[$key] ?? $map['__unknown__'];
	}

	#$action = $_POST['_action'] ?? null;
	$action = $_POST['_action'] ?? $_GET['_action'] ?? null;

	// ============================================================
	// URL helpers — allowlist + sanitizer
	// ============================================================

	/**
	 * Whitelist of URL parameters allowed to propagate through links,
	 * pagination, and form actions. Anything not on this list is dropped.
	 * Prevents transient state (reveal_*, _action, id, _back, _nonce, p, _action,
	 * accidental $_GET bleed, …) from leaking into URLs and producing malformed
	 * query strings like
	 *   ?&_action=bb_resolve&id=522&_action=bb_resolve&id=525
	 *
	 * Add a key here only if it represents persistent filter/view state that
	 * the user explicitly set and expects to carry forward.
	 */
	function bb_url_allowlist(): array
	{
		return [
			// Filter state (user-selected)
			'search', 'bot_category', 'request_method', 'blocked', 'status_code',
			'ip', 'user_agent', 'request_uri', 'date_from', 'date_to', 'slow', 'resolved', 'check',
			// Sort + pagination state
			'sort', 'dir', 'p',
			// View state
			'view_content',
			// WackoWiki admin routing
			'setting', 'mode',
			// Time window selector
			'since',
		];
	}

	/**
	 * Strip every URL parameter not on the allowlist AND drop empty values.
	 * Use this anywhere a URL is built for the manage view (sort headers,
	 * filter chips, pagination, per-row actions, time-window tabs, bulk-form
	 * _back hidden input, etc.).
	 */
	function bb_clean_url_args(array $args): array
	{
		return array_intersect_key(
			array_filter($args, fn($v) => $v !== '' && $v !== null),
			array_flip(bb_url_allowlist())
			);
	}

	// ============================================================
	// Helpers — settings
	// ============================================================

	function var_representation($value, int $indent = 0): string
	{
		if (is_array($value))
		{
			if ($value === []) return '[]';

			$is_list   = array_is_list($value);
			$pad	   = str_repeat("\t", $indent);
			$inner_pad = str_repeat("\t", $indent + 1);

			$items = [];

			foreach ($value as $k => $v)
			{
				$rendered = var_representation($v, $indent + 1);

				if ($is_list)
				{
					$items[] = $inner_pad . $rendered;
				}
				else
				{
					$items[] = $inner_pad . var_export($k, true) . ' => ' . $rendered;
				}
			}

			return "[\n" . implode(",\n", $items) . "\n" . $pad . ']';
		}

		return var_export($value, true);
	}

	function bb_read_settings($engine): array
	{
		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		$user_config = $adapter->get_settings();

		// Sparse bb_config.php means user_config only has overrides.
		// Merge with defaults so callers always get a complete shape.
		if (class_exists(\BadBehaviour\Configuration::class))
		{
			$defaults = \BadBehaviour\Configuration::get_defaults();
			$merged = array_replace_recursive($defaults, $user_config);
			// Preserve any adapter-injected keys (log_table, etc.) that may
			// not be in defaults.
			return array_replace($user_config, $merged);
		}

		return $user_config;
	}

	function bb_write_settings($engine, array $settings): array
	{
		unset(
			$settings['adapter'],
			$settings['log_table'],
			$settings['_safe_mode'],
			$settings['_custom_rules_parse_errors']
		);

		// Hard guard: NEVER overwrite an existing bb_config.php with an empty
		// override array. If the caller has nothing to write, they shouldn't
		// be here in the first place — return success-without-write so the
		// dispatcher's existing flow continues normally.
		//
		// This protects against the historical bug where toggling the master
		// enable radio caused the options form to submit all-default fields,
		// which diffed against get_defaults() to produce [], which then wiped
		// the operator's bb_config.php.
		if (empty($settings))
		{
			return [
				'success' => true,
				'skipped' => true,
				'reason'  => 'empty_overrides',
				'file'	=> null,
				'bytes'   => 0,
			];
		}

		$config_dir = defined('CONFIG_DIR') ? CONFIG_DIR : 'config';

		if (! is_dir($config_dir)) { @mkdir($config_dir, 0755, true); }

		if (! is_writable($config_dir))
		{
			return ['success' => false, 'error' => "Config directory not writable: {$config_dir}"];
		}

		$file = $config_dir . '/bb_config.php';

		// Build the file content.
		//
		// === SPARSE OUTPUT ===
		//
		// We only write keys that differ from Configuration::get_defaults().
		// The lib will fill in everything else from its own defaults.
		$body = var_representation($settings);
		$header = "<?php\n/**\n * Bad Behaviour 3.0 — site overrides\n *\n"
			. " * This file contains ONLY settings that differ from\n"
			. " * Configuration::get_defaults(). Everything else is filled in\n"
			. " * by the library at load time.\n *\n"
			. " * Last saved by WackoWiki admin module: " . date('c') . "\n */\n\n"
			. "return " . $body . ";\n";

		$tmp = $file . '.tmp.' . bin2hex(random_bytes(4));
		$bytes = @file_put_contents($tmp, $header, LOCK_EX);

		if ($bytes === false)
		{
			$err = error_get_last();

			return ['success' => false, 'error' => "Failed to write temp: {$tmp} — " . ($err['message'] ?? 'unknown')];
		}

		if (! @rename($tmp, $file))
		{
			@unlink($tmp);
			$err = error_get_last();

			return ['success' => false, 'error' => "Failed to rename → {$file} — " . ($err['message'] ?? 'unknown')];
		}

		@chmod($file, 0644);

		// === Invalidate opcache for this file ===
		//
		// If opcache is enabled (typical in production), it caches the
		// compiled bytecode of bb_config.php and reuses it on subsequent
		// require() calls without re-reading the file from disk. After
		// we write new contents, opcache still serves the OLD compiled
		// array — which is exactly the symptom you're seeing: the form
		// shows stale values until a reload (fresh worker = fresh
		// opcache).
		//
		// opcache_invalidate() marks the file as stale; the next require()
		// re-reads it from disk and recompiles. This is the correct place
		// to invalidate — right after the atomic rename, before any code
		// path that might require() this file.
		if (function_exists('opcache_invalidate'))
		{
			@opcache_invalidate($file, true);
		}

		return ['success' => true, 'file' => $file, 'bytes' => $bytes];
	}

	function bb_save_settings($engine): array
	{
		// === Step 1: Detect "enable-only" submit ===
		//
		// The options form submits both ext_bad_behaviour AND every other field.
		// If the user only flipped the On/Off radio, we must NOT rebuild
		// bb_config.php from POST — doing so diffs every field against defaults
		// and writes `return [];`, wiping the operator's existing overrides.
		//
		// We detect enable-only submits via a hidden sentinel that bb_options()
		// emits only on the master-enable form variant. When that's set, OR when
		// bb_collect_settings_from_post() returns no library-level overrides,
		// we leave bb_config.php untouched.
		$enable_only = !empty($_POST['_bb_enable_only']);

		// === Step 2: Collect settings from POST into a sparse override array ===
		//
		// bb_collect_settings_from_post() reads every Basic + Advanced field,
		// diffs against Configuration::get_defaults(), and returns ONLY the
		// keys that differ. Empty array = "user accepts all defaults".
		$overrides = bb_collect_settings_from_post($_POST);

		// === Step 3: Check for parse errors (currently only custom_rules JSON) ===
		//
		// bb_collect_settings_from_post() sets a sentinel if any custom_rules
		// line failed JSON parsing. We can't partially write — bail out.
		if (!empty($overrides['_custom_rules_parse_errors']))
		{
			$error_lines = $overrides['_custom_rules_parse_errors'];
			return [
				'success' => false,
				'error'   => 'Invalid JSON in custom_rules: ' . implode(' | ', array_map(
					fn($l) => Ut::html(substr($l, 0, 80)),
					$error_lines
					)),
				'payload' => $_POST,
			];
		}

		// === Step 4: Write bb_config.php ONLY if there are real overrides ===
		//
		// Two conditions short-circuit the write:
		//   (a) The form flagged itself as "enable-only" via the sentinel.
		//   (b) bb_collect_settings_from_post() returned no overrides
		//	   AND the user didn't touch the file in this submit.
		//
		// In both cases we leave bb_config.php exactly as it was. If no file
		// existed, none is created. If the operator hand-edited it, those edits
		// survive a plain On/Off toggle.
		if ($enable_only || empty($overrides))
		{
			return [
				'success' => true,
				'skipped' => true,
				'reason'  => $enable_only
				? 'enable_only_submit'
				: 'no_library_overrides',
				'file'	=> null,
				'bytes'   => 0,
			];
		}

		// === Step 5: Write bb_config.php ===
		$write = bb_write_settings($engine, $overrides);

		if (!$write['success'])
		{
			return [
				'success' => false,
				'error'   => $write['error'],
				'payload' => $overrides,
			];
		}

		return [
			'success' => true,
			'file'	=> $write['file'],
			'bytes'   => $write['bytes'],
		];
	}


	// Inside admin_tool_badbehaviour(), BEFORE bb_options() or bb_save_settings()

	/**
	 * Convert a POST array into a sparse bb_config.php override array.
	 *
	 * === PURPOSE ===
	 *
	 * Reads every form field (Basic + Advanced), compares each value against
	 * Configuration::get_defaults(), and returns ONLY the keys that differ.
	 * The result is what we write to bb_config.php — a minimal override file
	 * that the lib merges over its own defaults.
	 *
	 * === WHY SPARSE? ===
	 *
	 * The lib's merge order is:
	 *   defaults -> strictness_overrides($strictness) -> user bb_config.php
	 *
	 * So we don't need to repeat what defaults() already say. If the operator
	 * is happy with the default preset ('minimal'), we don't write it. If they
	 * don't enable head_request_detection, we don't write it. The lib fills
	 * everything in from defaults.
	 *
	 * This makes bb_config.php:
	 *   - Easy to read (only what was deliberately set)
	 *   - Forward-compatible (new defaults land automatically)
	 *   - Diff-friendly (git shows only intentional changes)
	 *
	 * === INPUT CONTRACT ===
	 *
	 * Caller passes the POST array (or any associative array shaped like one).
	 * Test code passes a synthetic array; production passes $_POST.
	 *
	 * === OUTPUT CONTRACT ===
	 *
	 * Nested array using bb_config.php dotted/nested format:
	 *   ['reverse_proxy' => ['enabled' => true], 'rate_limits' => [...], ...]
	 *
	 * Only keys that differ from get_defaults() are present. To verify the
	 * result against the lib, the operator can do:
	 *
	 *   $final = array_merge_recursive(
	 *	   Configuration::get_defaults(),
	 *	   Configuration::strictness_overrides($sparse['strictness'] ?? 'normal'),
	 *	   $sparse
	 *   );
	 *
	 * === BASIC vs ADVANCED ===
	 *
	 * The Basic section has 5 controls (preset, strictness, logging, behind_proxy).
	 * Everything else is Advanced. Both sections write to the SAME flat output
	 * — there's no "basic" namespace in bb_config.php.
	 *
	 * The Basic-to-Advanced translations:
	 *   - behind_proxy checkbox (bool) -> reverse_proxy.enabled (nested bool)
	 *   - logging 3-way radio -> logging (bool) + verbose (bool)
	 *
	 * @param array<string, mixed> $post Raw POST data (or test fixture)
	 * @return array<string, mixed> Sparse override array for bb_config.php
	 */
	function bb_collect_settings_from_post(array $post): array
	{
		// === Load defaults for diff comparison ===
		// We do this defensively — if the lib isn't available, we still
		// produce a valid (non-diffed) result.
		$defaults = class_exists(\BadBehaviour\Configuration::class)
		? \BadBehaviour\Configuration::get_defaults()
		: [];

		// === Output accumulator ===
		$out = [];

		// ============================================================
		// BASIC SECTION
		// ============================================================

		// preset (string, enum)
		if (isset($post['preset']))
		{
			$valid = ['minimal','full','verified-only','no-ai','no-seo','eu-only','human-only','custom'];
			$preset = (string)$post['preset'];
			if (in_array($preset, $valid, true) && $preset !== ($defaults['preset'] ?? 'minimal'))
			{
				$out['preset'] = $preset;
			}
		}

		// strictness (string, enum)
		if (isset($post['strictness']))
		{
			$valid = ['monitor-only','normal','strict'];
			$strictness = (string)$post['strictness'];
			if (in_array($strictness, $valid, true) && $strictness !== ($defaults['strictness'] ?? 'normal'))
			{
				$out['strictness'] = $strictness;
			}
		}

		// logging: 3-way radio -> (logging bool, verbose bool)
		//   'normal'  -> logging=true,  verbose=false
		//   'verbose' -> logging=true,  verbose=true
		//   'off'	 -> logging=false, verbose=*
		// We only write keys that differ from defaults.
		if (isset($post['logging_mode']))
		{
			$mode = (string)$post['logging_mode'];
			if (in_array($mode, ['off','normal','verbose'], true))
			{
				$logging  = ($mode !== 'off');
				$verbose  = ($mode === 'verbose');
				$def_log  = (bool)($defaults['logging']  ?? true);
				$def_verb = (bool)($defaults['verbose']  ?? false);

				if ($logging !== $def_log)
				{
					$out['logging'] = $logging;
				}
				if ($verbose !== $def_verb)
				{
					$out['verbose'] = $verbose;
				}
			}
		}

		// behind_proxy (bool) -> reverse_proxy (nested)
		//   true  -> reverse_proxy.enabled=true, header='X-Forwarded-For', addresses=[]
		//   false -> reverse_proxy.enabled=false (only if default was true)
		//
		// We write the FULL nested shape (not just 'enabled') when enabled,
		// so the lib can't accidentally fall back to a different header
		// if its defaults change. The user can override header/addresses
		// in the Advanced section — those edits will appear as further
		// overrides in the same nested key.
		if (isset($post['behind_proxy']))
		{
			$behind = (bool)$post['behind_proxy'];
			$def_rp = (bool)($defaults['reverse_proxy']['enabled'] ?? false);

			if ($behind !== $def_rp)
			{
				if ($behind)
				{
					$out['reverse_proxy'] = [
						'enabled'   => true,
						'header'	=> 'X-Forwarded-For',
						'addresses' => [],
					];
				}
				else
				{
					// User explicitly disabled — only write the explicit false
					// if the default was true. (Default is false, so usually
					// we don't write anything for false.)
						$out['reverse_proxy'] = ['enabled' => false];
				}
			}
		}

		// ============================================================
		// ADVANCED SECTION — boolean toggles
		// ============================================================

		// Each entry: POST key => [defaults key, expected type]
		$bool_toggles = [
			'strict'							=> 'strict',
			'offsite_forms'						=> 'offsite_forms',
			'show_detailed_block_page'			=> 'show_detailed_block_page',
			'show_contact_info'					=> 'show_contact_info',
			'dnsbl_enabled'						=> ['path' => ['dnsbl','enabled']],
			'block_unverified_ai'				=> ['path' => ['ai_crawlers','block_unverified']],
			'strict_ai'							=> ['path' => ['ai_crawlers','strict']],
			'strict_search_engines'				=> 'strict_search_engines',
			'rate_limit_enabled'				=> ['path' => ['rate_limits','enabled']],
			'geoip_enabled'						=> ['path' => ['geoip','enabled']],
			'challenge_enabled'					=> ['path' => ['challenge','enabled']],
			'enable_fingerprinting'				=> 'enable_fingerprinting',
			'inspect_json_body'					=> 'inspect_json_body',
			'inspect_multipart_body'			=> 'inspect_multipart_body',
			'enable_behavioral_analysis'		=> 'enable_behavioral_analysis',
			'enable_client_hints_validation'	=> 'enable_client_hints_validation',
			'enable_agentic_detection'			=> 'enable_agentic_detection',
			'enable_dynamic_ip_ranges'			=> ['path' => ['dynamic_ip_ranges','enabled']],
			'enable_head_request_detection'		=> 'enable_head_request_detection',
			'head_require_referer'				=> 'head_require_referer',
			'enable_asset_scraping_detection'	=> 'enable_asset_scraping_detection',
			'on_demand_ip_refresh_enabled'		=> ['path' => ['on_demand_ip_refresh','enabled']],
		];

		foreach ($bool_toggles as $post_key => $spec)
		{
			// Path resolution
			$path = is_string($spec) ? [$spec] : $spec['path'];
			$defaults_key_exists = true;
			$def = $defaults;
			foreach ($path as $segment)
			{
				if (!is_array($def) || !array_key_exists($segment, $def))
				{
					$defaults_key_exists = false;
					break;
				}
				$def = $def[$segment];
			}
			if (!$defaults_key_exists) continue;

			$def_bool = (bool)$def;
			$form_val = !empty($post[$post_key]);

			if ($form_val !== $def_bool)
			{
				bb_set_nested($out, $path, $form_val);
			}
		}

		// ============================================================
		// ADVANCED — rate_limits nested buckets
		// ============================================================

		// Each bucket: [requests, window] clamped to >= 1.
		// Only emitted if EITHER field differs from defaults.
		$rate_buckets = ['global','per_minute','post','login'];
		$rl_changes = [];

		foreach ($rate_buckets as $bucket)
		{
			$req_key = 'rate_' . $bucket . '_requests';
			$win_key = 'rate_' . $bucket . '_window';

			$req = isset($post[$req_key]) ? max(1, (int)$post[$req_key]) : null;
			$win = isset($post[$win_key]) ? max(1, (int)$post[$win_key]) : null;

			$def_req = (int)($defaults['rate_limits'][$bucket]['requests'] ?? 0);
			$def_win = (int)($defaults['rate_limits'][$bucket]['window']   ?? 0);

			$bucket_out = [];
			if ($req !== null && $req !== $def_req) $bucket_out['requests'] = $req;
			if ($win !== null && $win !== $def_win) $bucket_out['window']   = $win;

			if (!empty($bucket_out))
			{
				$rl_changes[$bucket] = $bucket_out;
			}
		}

		// If ANY bucket changed AND rate_limit_enabled was set differently
		// from default, we need to emit 'enabled' too — otherwise the lib
		// would default to true and the operator might not realize rate
		// limits are active.
		//
		// The 'enabled' toggle is already handled in $bool_toggles above.
		// Here we only handle the per-bucket overrides.
		if (!empty($rl_changes))
		{
			$out['rate_limits'] = $rl_changes;
		}

		// ============================================================
		// ADVANCED — bot_categories (4 lists)
		// ============================================================

		// Each list is multi-select; values are category strings.
		// We accept either an array (multi-checkbox) or a string
		// (single value, defensive). Empty/missing = use default.
		$cat_lists = ['blocked','challenge','log_only','allowed'];
		$cat_changes = [];

		foreach ($cat_lists as $list)
		{
			$post_key = 'bot_category_' . $list;
			if (!isset($post[$post_key])) continue;

			$values = is_array($post[$post_key])
			? array_values(array_filter(array_map('trim', $post[$post_key])))
			: [trim((string)$post[$post_key])];

			$def_values = (array)($defaults['bot_categories'][$list] ?? []);
			sort($values);
			sort($def_values);

			if ($values !== $def_values)
			{
				$cat_changes[$list] = $values;
			}
		}

		if (!empty($cat_changes))
		{
			$out['bot_categories'] = $cat_changes;
		}

		// ============================================================
		// ADVANCED — http:BL
		// ============================================================

		$httpbl_changes = [];

		if (isset($post['httpbl_key']))
		{
			$key = trim((string)$post['httpbl_key']);
			// Must be exactly 12 lowercase letters (per Project Honeypot)
			if (!preg_match('/^[a-z]{12}$/', $key)) $key = '';
			$def_key = (string)($defaults['httpbl']['key'] ?? '');
			if ($key !== $def_key) $httpbl_changes['key'] = $key;
		}

		if (isset($post['httpbl_threat']))
		{
			$threat = max(0, min(255, (int)$post['httpbl_threat']));
			$def_threat = (int)($defaults['httpbl']['threat'] ?? 25);
			if ($threat !== $def_threat) $httpbl_changes['threat'] = $threat;
		}

		if (isset($post['httpbl_maxage']))
		{
			$maxage = max(0, (int)$post['httpbl_maxage']);
			$def_maxage = (int)($defaults['httpbl']['maxage'] ?? 30);
			if ($maxage !== $def_maxage) $httpbl_changes['maxage'] = $maxage;
		}

		if (!empty($httpbl_changes))
		{
			$out['httpbl'] = $httpbl_changes;
		}

		// ============================================================
		// ADVANCED — DNSBL lists (textarea, one per line)
		// ============================================================

		if (isset($post['dnsbl_lists']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['dnsbl_lists']))
				));
			$def_values = (array)($defaults['dnsbl']['lists'] ?? []);
			sort($values);
			sort($def_values);
			if ($values !== $def_values)
			{
				$out['dnsbl'] = $out['dnsbl'] ?? [];
				$out['dnsbl']['lists'] = $values;
			}
		}

		// ============================================================
		// ADVANCED — AI crawlers.allowed (textarea)
		// ============================================================

		if (isset($post['allowed_ai_crawlers']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['allowed_ai_crawlers']))
				));
			$def_values = (array)($defaults['ai_crawlers']['allowed'] ?? []);
			sort($values);
			sort($def_values);
			if ($values !== $def_values)
			{
				$out['ai_crawlers'] = $out['ai_crawlers'] ?? [];
				$out['ai_crawlers']['allowed'] = $values;
			}
		}

		// ============================================================
		// ADVANCED — challenge provider/keys
		// ============================================================

		$challenge_changes = [];

		if (isset($post['challenge_provider']))
		{
			$provider = (string)$post['challenge_provider'];
			$valid = ['builtin','hcaptcha','recaptcha','turnstile'];
			if (!in_array($provider, $valid, true)) $provider = 'builtin';
			$def_provider = (string)($defaults['challenge']['provider'] ?? 'builtin');
			if ($provider !== $def_provider) $challenge_changes['provider'] = $provider;
		}

		foreach (['site_key' => 'challenge_site_key', 'secret_key' => 'challenge_secret_key'] as $def_key => $post_key)
		{
			if (isset($post[$post_key]))
			{
				$val = trim((string)$post[$post_key]);
				$def_val = (string)($defaults['challenge'][$def_key] ?? '');
				if ($val !== $def_val)
				{
					$challenge_changes[$def_key] = $val;
				}
			}
		}

		if (isset($post['recaptcha_min_score']))
		{
			$score = max(0.0, min(1.0, (float)$post['recaptcha_min_score']));
			$def_score = (float)($defaults['challenge']['recaptcha_min_score'] ?? 0.5);
			if ($score !== $def_score)
			{
				$challenge_changes['recaptcha_min_score'] = $score;
			}
		}

		if (!empty($challenge_changes))
		{
			$out['challenge'] = $challenge_changes;
		}

		// ============================================================
		// ADVANCED — geoip
		// ============================================================

		$geoip_changes = [];

		if (isset($post['geoip_database_path']))
		{
			$path = trim((string)$post['geoip_database_path']);
			$def_path = (string)($defaults['geoip']['database_path'] ?? '');
			if ($path !== $def_path) $geoip_changes['database_path'] = $path;
		}

		foreach (['blocked_countries' => 'blocked_countries', 'blocked_asns' => 'blocked_asns'] as $post_key => $def_key)
		{
			if (isset($post[$post_key]))
			{
				$values = array_values(array_filter(
					array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post[$post_key]))
					));
				$def_values = (array)($defaults['geoip'][$def_key] ?? []);
				sort($values);
				sort($def_values);
				if ($values !== $def_values)
				{
					$geoip_changes[$def_key] = $values;
				}
			}
		}

		if (!empty($geoip_changes))
		{
			$out['geoip'] = $geoip_changes;
		}

		// ============================================================
		// ADVANCED — fingerprints (4 lists)
		// ============================================================

		$fp_changes = [];

		$fp_map = [
			'bad_ja3'			=> 'bad_ja3_fingerprints',
			'bad_h2'			=> 'bad_h2_fingerprints',
			'bot_header_orders' => 'bot_header_orders',
			'expected_ja3'		=> 'expected_ja3',
		];

		foreach ($fp_map as $def_key => $post_key)
		{
			if (isset($post[$post_key]))
			{
				$values = array_values(array_filter(
					array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post[$post_key]))
					));
				$def_values = (array)($defaults['fingerprints'][$def_key] ?? []);
				sort($values);
				sort($def_values);
				if ($values !== $def_values)
				{
					$fp_changes[$def_key] = $values;
				}
			}
		}

		if (!empty($fp_changes))
		{
			$out['fingerprints'] = $fp_changes;
		}

		// ============================================================
		// ADVANCED — performance (skip_extensions, skip_paths)
		// ============================================================

		$perf_changes = [];

		foreach ([
			'skip_extensions'	=> 'skip_static_extensions',
			'skip_paths'		=> 'skip_static_paths',
		] as $def_key => $post_key)
		{
			if (isset($post[$post_key]))
			{
				$values = array_values(array_filter(
					array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post[$post_key]))
					));
				$def_values = (array)($defaults['performance'][$def_key] ?? []);
				sort($values);
				sort($def_values);
				if ($values !== $def_values)
				{
					$perf_changes[$def_key] = $values;
				}
			}
		}

		if (!empty($perf_changes))
		{
			$out['performance'] = $perf_changes;
		}

		// ============================================================
		// ADVANCED — custom_rules (JSON, one per line)
		// ============================================================

		if (isset($post['custom_rules']))
		{
			$rules = [];
			$raw = (string)$post['custom_rules'];
			$errors = [];

			foreach (preg_split('/\r\n|\r|\n/', $raw) as $line)
			{
				$line = trim($line);
				if ($line === '') continue;

				$decoded = json_decode($line, true);
				if (is_array($decoded) && isset($decoded['type'], $decoded['action']))
				{
					$rules[] = $decoded;
				}
				else
				{
					$errors[] = substr($line, 0, 80);
				}
			}

			// If ANY line failed to parse, skip writing custom_rules entirely.
			// Caller (bb_save_settings) will surface the error.
			// (We can't partially write — the lib would reject the rest on load.)
			if (!empty($errors))
			{
				// Surface via a sentinel key; bb_save_settings checks for this.
				$out['_custom_rules_parse_errors'] = $errors;
			}
			else
			{
				$def_rules = (array)($defaults['custom_rules'] ?? []);
				// Stable comparison: serialize both
				if (json_encode($rules) !== json_encode($def_rules))
				{
					$out['custom_rules'] = $rules;
				}
			}
		}

		// ============================================================
		// ADVANCED — body_scan_skip_fields (textarea)
		// ============================================================

		if (isset($post['body_scan_skip_fields']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['body_scan_skip_fields']))
				));
			sort($values);
			$def_values = (array)($defaults['body_scan_skip_fields'] ?? []);
			$def_sorted = $def_values; sort($def_sorted);
			if ($values !== $def_sorted)
			{
				$out['body_scan_skip_fields'] = $values;
			}
		}

		// ============================================================
		// ADVANCED — reverse_proxy header + addresses (when behind_proxy=true)
		// ============================================================
		//
		// If behind_proxy=true was set in Basic, the header/addresses fields
		// appear in Advanced (so the operator can configure Cloudflare ranges).
		// We merge those with the basic behind_proxy output above.
		//
		// bb_set_nested() merges into existing 'reverse_proxy' key rather
		// than overwriting it.

		$rp_changes = [];

		if (isset($post['reverse_proxy_header']))
		{
			$header = trim((string)$post['reverse_proxy_header']) ?: 'X-Forwarded-For';
			$def_header = (string)($defaults['reverse_proxy']['header'] ?? 'X-Forwarded-For');
			if ($header !== $def_header)
			{
				$rp_changes['header'] = $header;
			}
		}

		if (isset($post['reverse_proxy_addresses']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['reverse_proxy_addresses']))
				));
			sort($values);
			$def_values = (array)($defaults['reverse_proxy']['addresses'] ?? []);
			$def_sorted = $def_values; sort($def_sorted);
			if ($values !== $def_sorted)
			{
				$rp_changes['addresses'] = $values;
			}
		}

		if (!empty($rp_changes))
		{
			// Merge into existing reverse_proxy (set by behind_proxy Basic) or create new
			if (isset($out['reverse_proxy']) && is_array($out['reverse_proxy']))
			{
				$out['reverse_proxy'] = array_merge($out['reverse_proxy'], $rp_changes);
			}
			else
			{
				$out['reverse_proxy'] = array_merge(
					['enabled' => !empty($post['behind_proxy'])],
					$rp_changes
					);
			}
		}

		// ============================================================
		// ADVANCED — head detection thresholds
		// ============================================================

		foreach ([
			'head_flood_threshold' => ['int', 1],
			'head_probe_threshold' => ['int', 1],
		] as $key => [$type, $min])
		{
			if (isset($post[$key]))
			{
				$val = max($min, (int)$post[$key]);
				$def_val = (int)($defaults[$key] ?? 0);
				if ($val !== $def_val)
				{
					$out[$key] = $val;
				}
			}
		}

		if (isset($post['head_referer_exempt_paths']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['head_referer_exempt_paths']))
				));
			$def_values = (array)($defaults['head_referer_exempt_paths'] ?? []);
			sort($values); sort($def_values);
			if ($values !== $def_values)
			{
				$out['head_referer_exempt_paths'] = $values;
			}
		}

		// ============================================================
		// ADVANCED — asset scraping
		// ============================================================

		foreach ([
			'asset_no_referer_threshold'	=> 1,
			'asset_only_session_threshold'	=> 1,
			'asset_pattern_threshold'		=> 1,
		] as $key => $min)
		{
			if (isset($post[$key]))
			{
				$val = max($min, (int)$post[$key]);
				$def_val = (int)($defaults[$key] ?? 0);
				if ($val !== $def_val)
				{
					$out[$key] = $val;
				}
			}
		}

		if (isset($post['asset_extensions']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['asset_extensions']))
				));
			$def_values = (array)($defaults['asset_extensions'] ?? []);
			sort($values); sort($def_values);
			if ($values !== $def_values)
			{
				$out['asset_extensions'] = $values;
			}
		}

		// ============================================================
		// ADVANCED — DNS verification
		// ============================================================

		$dns_changes = [];

		foreach ([
			'dns_verification_timeout_ms'			=> ['int', 50, 2000],
			'dns_verification_positive_ttl'			=> ['int', 3600, PHP_INT_MAX],
			'dns_verification_negative_ttl'			=> ['int', 60, PHP_INT_MAX],
		] as $key => [$type, $min, $max])
		{
			if (isset($post[$key]))
			{
				$val = max($min, min($max, (int)$post[$key]));
				$def_val = (int)($defaults['dns_verification'][str_replace('dns_verification_','', $key)] ?? 0);
				if ($val !== $def_val)
				{
					$dns_changes[str_replace('dns_verification_','', $key)] = $val;
				}
			}
		}

		// require_forward_confirm is a bool nested under dns_verification
		// (not in $bool_toggles above because of the nested path)
		if (isset($post['dns_verification_require_forward_confirm']))
		{
			$val = (bool)$post['dns_verification_require_forward_confirm'];
			$def_val = (bool)($defaults['dns_verification']['require_forward_confirm'] ?? false);
			if ($val !== $def_val)
			{
				$dns_changes['require_forward_confirm'] = $val;
			}
		}

		if (!empty($dns_changes))
		{
			$out['dns_verification'] = $dns_changes;
		}

		// ============================================================
		// ADVANCED — dynamic IP ranges (ttl + feeds)
		// ============================================================

		$dir_changes = [];

		if (isset($post['dynamic_ip_ranges_ttl']))
		{
			$val = max(3600, (int)$post['dynamic_ip_ranges_ttl']);
			$def_val = (int)($defaults['dynamic_ip_ranges']['ttl'] ?? 86400);
			if ($val !== $def_val)
			{
				$dir_changes['ttl'] = $val;
			}
		}

		if (isset($post['dynamic_ip_ranges_feeds']))
		{
			$values = array_values(array_filter(
				array_map('trim', preg_split('/\r\n|\r|\n/', (string)$post['dynamic_ip_ranges_feeds']))
				));
			$def_values = (array)($defaults['dynamic_ip_ranges']['feeds'] ?? []);
			sort($values); sort($def_values);
			if ($values !== $def_values)
			{
				$dir_changes['feeds'] = $values;
			}
		}

		if (!empty($dir_changes))
		{
			$out['dynamic_ip_ranges'] = $dir_changes;
		}

		// ============================================================
		// ADVANCED — on-demand IP refresh (cron-less alternative)
		// ============================================================

		$od_changes = [];

		foreach ([
			'on_demand_ip_refresh_probability_denominator'	=> ['int', 1, PHP_INT_MAX],
			'on_demand_ip_refresh_min_age_seconds'			=> ['int', 0, PHP_INT_MAX],
			'on_demand_ip_refresh_lock_ttl'					=> ['int', 1, PHP_INT_MAX],
			'on_demand_ip_refresh_cache_ttl'				=> ['int', 3600, PHP_INT_MAX],
		] as $key => [$type, $min, $max])
		{
			if (isset($post[$key]))
			{
				$val = max($min, min($max, (int)$post[$key]));
				$short = str_replace('on_demand_ip_refresh_', '', $key);
				$def_val = (int)($defaults['on_demand_ip_refresh'][$short] ?? 0);
				if ($val !== $def_val)
				{
					$od_changes[$short] = $val;
				}
			}
		}

		if (isset($post['on_demand_ip_refresh_feed_timeout_seconds']))
		{
			$val = (float)$post['on_demand_ip_refresh_feed_timeout_seconds'];
			if ($val < 0.1) $val = 0.1;
			$def_val = (float)($defaults['on_demand_ip_refresh']['feed_timeout_seconds'] ?? 5);
			if ($val !== $def_val)
			{
				$od_changes['feed_timeout_seconds'] = $val;
			}
		}

		// ============================================================
		// ADVANCED — dns_verification (master switch + sub-fields)
		// ============================================================
		//
		// Master switch + 4 sub-fields. Already handled sub-fields
		// (timeout_ms, require_forward_confirm, positive_ttl, negative_ttl)
		// above — we just need to ADD 'enabled' to the handling.
		//
		// The sub-fields use a dotted-nested path: 'dns_verification.enabled'
		// so we treat this as a special case (not in $bool_toggles because
		// the path is nested but the form field is also nested).

		$dns_verification_changes = [];

		// Master switch
		if (isset($post['dns_verification_enabled']))
		{
			$val = (bool)$post['dns_verification_enabled'];
			$def_val = (bool)($defaults['dns_verification']['enabled'] ?? true);
			if ($val !== $def_val)
			{
				$dns_verification_changes['enabled'] = $val;
			}
		}

		// timeout_ms (int, clamped 50–2000)
		if (isset($post['dns_verification_timeout_ms']))
		{
			$val = max(50, min(2000, (int)$post['dns_verification_timeout_ms']));
			$def_val = (int)($defaults['dns_verification']['timeout_ms'] ?? 300);
			if ($val !== $def_val)
			{
				$dns_verification_changes['timeout_ms'] = $val;
			}
		}

		// positive_ttl (int, min 3600)
		if (isset($post['dns_verification_positive_ttl']))
		{
			$val = max(3600, (int)$post['dns_verification_positive_ttl']);
			$def_val = (int)($defaults['dns_verification']['positive_ttl'] ?? 604800);
			if ($val !== $def_val)
			{
				$dns_verification_changes['positive_ttl'] = $val;
			}
		}

		// negative_ttl (int, min 60)
		if (isset($post['dns_verification_negative_ttl']))
		{
			$val = max(60, (int)$post['dns_verification_negative_ttl']);
			$def_val = (int)($defaults['dns_verification']['negative_ttl'] ?? 3600);
			if ($val !== $def_val)
			{
				$dns_verification_changes['negative_ttl'] = $val;
			}
		}

		// require_forward_confirm (bool)
		if (isset($post['dns_verification_require_forward_confirm']))
		{
			$val = (bool)$post['dns_verification_require_forward_confirm'];
			$def_val = (bool)($defaults['dns_verification']['require_forward_confirm'] ?? false);
			if ($val !== $def_val)
			{
				$dns_verification_changes['require_forward_confirm'] = $val;
			}
		}

		if (!empty($dns_verification_changes))
		{
			$out['dns_verification'] = $dns_verification_changes;
		}

		// ============================================================
		// ADVANCED — on_demand_ip_refresh: bot_ids + cloud_providers
		// ============================================================
		//
		// These two fields accept NULL (refresh all) OR a non-empty array
		// (refresh only the listed items). An empty form submission means
		// "use default" (= null = all). An unchecked checkbox means "all".
		//
		// We render 4 cloud_provider checkboxes in the UI (aws, cloudflare,
		// fastly, gcp). If NONE are checked, we write null (refresh all).
		// If SOME are checked, we write the array of checked values.
		//
		// For bot_ids, the UI is a multi-select with ~10 known bots. Same
		// semantics: none checked = null = all bots.

		$od_extra_changes = [];

		// cloud_providers: array<string> | null
		if (isset($post['on_demand_ip_refresh_cloud_providers']))
		{
			// Defensive: accept array OR null OR empty
			$raw = $post['on_demand_ip_refresh_cloud_providers'];
			$values = is_array($raw)
			? array_values(array_filter(array_map('trim', $raw)))
			: [];

			$valid_providers = ['aws', 'cloudflare', 'fastly', 'gcp'];
			$values = array_values(array_intersect($values, $valid_providers));

			// Default is empty [] which means "all" per the lib docs
			// Actually re-checking get_defaults(): 'cloud_providers' => []
			// So default is empty array, NOT null. Empty = "all providers".
			// User-submitted empty = same as default, no override needed.
			$def_values = (array)($defaults['on_demand_ip_refresh']['cloud_providers'] ?? []);
			sort($values); sort($def_values);

			if ($values !== $def_values)
			{
				$od_extra_changes['cloud_providers'] = $values;
			}
		}

		// bot_ids: array<string> | null
		// (UI will be a multi-select; empty means "all bots")
		if (isset($post['on_demand_ip_refresh_bot_ids']))
		{
			$raw = $post['on_demand_ip_refresh_bot_ids'];
			$values = is_array($raw)
			? array_values(array_filter(array_map('trim', $raw)))
			: [];

			// No hard validation — bots are configurable via registry.
			// Just dedupe and trim.
			$values = array_values(array_unique($values));

			$def_values = (array)($defaults['on_demand_ip_refresh']['bot_ids'] ?? []);
			sort($values); sort($def_values);

			if ($values !== $def_values)
			{
				$od_extra_changes['bot_ids'] = $values;
			}
		}

		if (!empty($od_extra_changes))
		{
			// Merge into existing on_demand_ip_refresh (set by scalar fields above)
			// or create new
			if (isset($out['on_demand_ip_refresh']) && is_array($out['on_demand_ip_refresh']))
			{
				$out['on_demand_ip_refresh'] = array_merge($out['on_demand_ip_refresh'], $od_extra_changes);
			}
			else
			{
				$out['on_demand_ip_refresh'] = $od_extra_changes;
			}
		}

		if (!empty($od_changes))
		{
			$out['on_demand_ip_refresh'] = $od_changes;
		}

		// ============================================================
		// ADVANCED — log_retention (automatic cleanup of old log rows)
		// ============================================================

		$log_retention_changes = [];

		// enabled (bool, nested)
		if (isset($post['log_retention_enabled']))
		{
			$val = (bool)$post['log_retention_enabled'];
			$def_val = (bool)($defaults['log_retention']['enabled'] ?? true);
			if ($val !== $def_val)
			{
				$log_retention_changes['enabled'] = $val;
			}
		}

		// max_age_days (int, min 1)
		if (isset($post['log_retention_max_age_days']))
		{
			$val = max(1, (int)$post['log_retention_max_age_days']);
			$def_val = (int)($defaults['log_retention']['max_age_days'] ?? 7);
			if ($val !== $def_val)
			{
				$log_retention_changes['max_age_days'] = $val;
			}
		}

		// max_rows (int, min 0 — 0 disables)
		if (isset($post['log_retention_max_rows']))
		{
			$val = max(0, (int)$post['log_retention_max_rows']);
			$def_val = (int)($defaults['log_retention']['max_rows'] ?? 0);
			if ($val !== $def_val)
			{
				$log_retention_changes['max_rows'] = $val;
			}
		}

		// probability_denominator (int, min 1)
		if (isset($post['log_retention_probability_denominator']))
		{
			$val = max(1, (int)$post['log_retention_probability_denominator']);
			$def_val = (int)($defaults['log_retention']['probability_denominator'] ?? 1000);
			if ($val !== $def_val)
			{
				$log_retention_changes['probability_denominator'] = $val;
			}
		}

		// min_interval_seconds (int, min 0)
		if (isset($post['log_retention_min_interval_seconds']))
		{
			$val = max(0, (int)$post['log_retention_min_interval_seconds']);
			$def_val = (int)($defaults['log_retention']['min_interval_seconds'] ?? 21600);
			if ($val !== $def_val)
			{
				$log_retention_changes['min_interval_seconds'] = $val;
			}
		}

		// lock_ttl (int, min 0)
		if (isset($post['log_retention_lock_ttl']))
		{
			$val = max(0, (int)$post['log_retention_lock_ttl']);
			$def_val = (int)($defaults['log_retention']['lock_ttl'] ?? 600);
			if ($val !== $def_val)
			{
				$log_retention_changes['lock_ttl'] = $val;
			}
		}

		if (!empty($log_retention_changes))
		{
			$out['log_retention'] = $log_retention_changes;
		}

		return $out;
	}

	/**
	 * Set a nested array value by path, creating intermediates as needed.
	 *
	 * Used to build nested config like ['reverse_proxy' => ['enabled' => true]]
	 * from a flat path like ['reverse_proxy', 'enabled'].
	 *
	 * @param array<string, mixed> &$arr  Array to modify (by reference)
	 * @param string[]			$path  Path segments, e.g. ['rate_limits', 'global', 'requests']
	 * @param mixed				$value Value to set
	 */
	function bb_set_nested(array &$arr, array $path, mixed $value): void
	{
		$cursor = &$arr;
		$last = array_pop($path);

		foreach ($path as $segment)
		{
			if (!isset($cursor[$segment]) || !is_array($cursor[$segment]))
			{
				$cursor[$segment] = [];
			}
			$cursor = &$cursor[$segment];
		}

		$cursor[$last] = $value;
	}

	function bb_read_whitelist($engine)
	{
		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		return $adapter->get_whitelist();
	}

	// ============================================================
	// Helper — http:BL lookup (unchanged)
	// ============================================================

	function bb_httpbl_lookup($engine, $ip): string
	{
		$settings = bb_read_settings($engine);
		$key = $settings['httpbl']['key'] ?? '';

		if (!preg_match('/^[a-z]{12}$/', $key)) return '';
		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return '';

		$cache = $engine->sess->httpbl ?? [];

		if (isset($cache[$ip]) && $cache[$ip] !== '')
		{
			$r = $cache[$ip];
		}
		else
		{
			$find = implode('.', array_reverse(explode('.', $ip)));
			$query = "{$key}.{$find}.dnsbl.httpbl.org.";
			$resp = @gethostbynamel($query);

			if (empty($resp))
			{
				$cache[$ip] = '';
				$engine->sess->httpbl = $cache;
				return '';
			}

			$r = $resp[0];
			$cache[$ip] = $r;
			$engine->sess->httpbl = $cache;
		}

		$parts = explode('.', $r);
		if (count($parts) !== 4 || $parts[0] !== '127') return '';

		$activity = (int)$parts[1];
		$threat   = (int)$parts[2];
		$type	 = (int)$parts[3];

		$out = [];
		if ($type === 0)		$out[] = 'Search engine (whitelist candidate)';
		if ($type & 1)			$out[] = 'Suspicious';
		if ($type & 2)			$out[] = 'Harvester';
		if ($type & 4)			$out[] = 'Comment spammer';
		if ($type & 7)			$out[] = "Threat level {$threat}";
		if ($activity > 0)		$out[] = "Age {$activity} days";

		return implode('<br>', $out);
	}

	// ============================================================
	// Helper — time window (Lynx-safe: pure links)
	// ============================================================

	function bb_time_window($engine): array
	{
		// Use the allowlist-cleaned GET params, not raw $_GET
		$clean_args = bb_clean_url_args($_GET);
		$since = $clean_args['since'] ?? '24h';  // ← Use cleaned args

		$windows = [
			'24h' => ['seconds' =>   86400, 'label' => 'Last 24 hours'],
			'7d'  => ['seconds' =>  604800, 'label' => 'Last 7 days'],
			'30d' => ['seconds' => 2592000, 'label' => 'Last 30 days'],
			'all' => ['seconds' =>       0, 'label' => 'All time'],
		];

		$w = $windows[$since] ?? $windows['24h'];

		if ($w['seconds'] === 0)
		{
			return ['sql' => '', 'label' => $w['label'], 'seconds' => 0, 'key' => $since];
		}

		$driver = '';
		if (isset($engine->db->db_driver)) $driver = strtolower($engine->db->db_driver);
		elseif (isset($engine->db->driver)) $driver = strtolower($engine->db->driver);

		$is_sqlite = ($driver === 'sqlite' || $driver === 'sqlite3' || str_contains($driver, 'sqlite'));

		$sql = $is_sqlite
			? "AND `date` >= datetime('now', '-{$w['seconds']} seconds') "
			: "AND `date` >= DATE_SUB(NOW(), INTERVAL {$w['seconds']} SECOND) ";

		return ['sql' => $sql, 'label' => $w['label'], 'seconds' => $w['seconds'], 'key' => $since];
	}

	function bb_render_time_selector($engine, string $current, string $target = '', array $filter_args = []): string
	{
		$tabs = [
			'24h' => $engine->_t('BbWindow24h'),
			'7d'  => $engine->_t('BbWindow7d'),
			'30d' => $engine->_t('BbWindow30d'),
			'all' => $engine->_t('BbWindowAll'),
		];

		// Build the base args: any caller-provided filter state (already
		// allowlist-cleaned by bb_clean_url_args) + setting + mode.
		$base = bb_clean_url_args($filter_args);

		if ($target !== '')
		{
			$base['setting'] = $target;
		}

		if (!isset($base['mode']))
		{
			$base['mode'] = 'tool_badbehaviour';
		}

		$html = '<nav class="bb-time-selector" aria-label="Time window">';

		foreach ($tabs as $key => $label)
		{
			// Only emit `since` when it's not the default (24h) — keeps URLs short.
			$args = $base;
			if ($key !== '24h')
			{
				$args['since'] = $key;
			}

			$href = $engine->href('', '', $args);
			$active = ($current === $key) ? ' class="active" aria-current="true"' : '';
			$html .= '<a href="' . $href . '"' . $active . '>' . $label . '</a>';
		}

		$html .= '</nav>';

		return $html;
	}

	// ============================================================
	// Helper — view modes (full / teaser / hidden) WITHOUT JavaScript.
	// Three pure-HTML/CSS modes via <details>, no JS, Lynx-safe.
	// ============================================================

	/**
	 * Returns one of: 'full' | 'teaser' | 'hidden' from GET/POST.
	 * 'full' is the default for headers; 'teaser' for body.
	 */
	function bb_get_view_mode(string $column, string $default): string
	{
		// GET (filter form) takes precedence; POST (bulk) doesn't carry it
		$value = $_GET['view_' . $column] ?? $default;
		return in_array($value, ['full', 'teaser', 'hidden'], true) ? $value : $default;
	}

	function bb_render_view_mode($engine, array $row, string $column, string $mode): string
	{
		$content = $row[$column] ?? '';
		if ($content === '' || $content === null)
		{
			return '<span class="bb-empty">—</span>';
		}

		$summary_label = ($column === 'http_headers')
			? $engine->_t('BbViewHeaders')
			: $engine->_t('BbViewBody');

		// The .bb-pre class is defined in badbehaviour.css
		$pre = '<pre class="bb-pre">' . Ut::html($content) . '</pre>';

		if ($mode === 'full')
		{
			return $pre;
		}

		if ($mode === 'hidden')
		{
			// Hide via CSS by default; show via :target or a server-side
			// "show" link that adds ?show_headers=1 to the URL.
			// We use a server-side approach: a "show" link renders the
			// content for THIS request only via ?reveal_<column>=<log_id>.
			$reveal_id = (int)($row['log_id'] ?? 0);
			$current_reveal = (int)($_GET['reveal_' . $column] ?? 0);
			if ($reveal_id === $current_reveal)
			{
				return $pre
					. ' <a href="' . Ut::html(strtok($_SERVER['REQUEST_URI'] ?? '', '?')) . '?'
					. http_build_query(array_diff_key($_GET, ['reveal_' . $column => true]))
					. '">[' . $engine->_t('BbHide') . ']</a>';
			}

			$params = $_GET + ['reveal_' . $column => $reveal_id];
			$hide = ['reveal_' . $column => null];
			$params = array_filter($params, fn($v) => $v !== null);

			return '<a href="?' . http_build_query($params) . '">['
				. $summary_label . ' — ' . strlen($content) . ' ' . $engine->_t('BbChars') . ']</a>';
		}

		// teaser: native <details> — Lynx-friendly (shows summary, expands on Enter)
		return '<details class="bb-collapsed"><summary>' . $summary_label . '</summary>'
			. $pre . '</details>';
	}

	// ============================================================
	// SUMMARY view
	// ============================================================

	function bb_insert_stats($engine)
	{
		$result = $engine->db->load_single(
			"SELECT COUNT(log_id) AS n FROM " . $engine->prefix . 'bad_behaviour ' .
			" WHERE `status_code` NOT LIKE 'allowed'"
		);
		return $engine->number_format($result['n'] ?: 0);
	}

	function bb_top_blocked($engine, string $window_sql, int $limit = 10): array
	{
		$sql = 'SELECT `ip`, COUNT(*) AS hits, MIN(`date`) AS first_seen, MAX(`date`) AS last_seen, '
			. "GROUP_CONCAT(DISTINCT `status_code`) AS codes, "
			. "GROUP_CONCAT(DISTINCT `bot_category`) AS categories "
			. 'FROM ' . $engine->prefix . 'bad_behaviour '
			. "WHERE `status_code` != 'allowed' " . $window_sql
			. 'GROUP BY `ip` ORDER BY hits DESC LIMIT ' . (int)$limit;
		return $engine->db->load_all($sql, true) ?: [];
	}

	function bb_status_severity($engine, string $window_sql): array
	{
		$sql = 'SELECT `status_code`, COUNT(*) AS n '
			. 'FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE 1=1 ' . $window_sql
			. 'GROUP BY `status_code` ORDER BY n DESC';
		$rows = $engine->db->load_all($sql, true) ?: [];

		$groups = [
			'blocked'   => ['label' => $engine->_t('BbSevAttackPatterns'), 'icon' => '●', 'class' => 'sev-bad',  'count' => 0, 'codes' => []],
			'challenge' => ['label' => $engine->_t('BbSevChallenges'),	 'icon' => '○', 'class' => 'sev-warn', 'count' => 0, 'codes' => []],
			'allowed'   => ['label' => $engine->_t('BbSevPermitted'),	  'icon' => '◌', 'class' => 'sev-ok',   'count' => 0, 'codes' => []],
			'error'     => ['label' => $engine->_t('BbSevErrors'),		 'icon' => '✕', 'class' => 'sev-bad',  'count' => 0, 'codes' => []],
		];

		foreach ($rows as $row)
		{
			$code = $row['status_code'] ?? '';
			$severity = explode('.', $code)[0] ?? 'unknown';
			if (!isset($groups[$severity]))
			{
				$groups[$severity] = ['label' => ucfirst($severity), 'icon' => '?', 'class' => '', 'count' => 0, 'codes' => []];
			}
			$groups[$severity]['count'] += (int)$row['n'];
			$groups[$severity]['codes'][$code] = (int)$row['n'];
		}

		return $groups;
	}

	function bb_bot_breakdown($engine, string $window_sql): array
	{
		$sql = 'SELECT `bot_category`, COUNT(*) AS n, '
			. 'SUM(CASE WHEN `bot_verified` = 1 THEN 1 ELSE 0 END) AS verified_count '
			. 'FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE `bot_category` IS NOT NULL AND `bot_category` != \'\'' . $window_sql
			. 'GROUP BY `bot_category` ORDER BY n DESC';
		return $engine->db->load_all($sql, true) ?: [];
	}

	function bb_geo_summary($engine, string $window_sql): array
	{
		$out = ['countries' => [], 'asns' => []];

		$has_geo = $engine->db->load_single(
			'SELECT COUNT(log_id) AS n FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE `country` IS NOT NULL AND `country` != \'\'' . $window_sql
		);
		if (!$has_geo || (int)$has_geo['n'] === 0) return $out;

		$out['countries'] = $engine->db->load_all(
			'SELECT `country`, COUNT(*) AS n FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE `country` IS NOT NULL AND `country` != \'\'' . $window_sql
			. 'GROUP BY `country` ORDER BY n DESC LIMIT 10', true
		) ?: [];

		$out['asns'] = $engine->db->load_all(
			'SELECT `asn`, COUNT(*) AS n FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE `asn` IS NOT NULL AND `asn` != \'\'' . $window_sql
			. 'GROUP BY `asn` ORDER BY n DESC LIMIT 10', true
		) ?: [];

		return $out;
	}

	/**
	 * Per-ResultCode counts split by enforcement bucket.
	 *
	 * Returns three buckets that map 1:1 to the three summary boxes:
	 *   - 'enforced'  → actually blocked/challenged (403 served)
	 *   - 'monitored' → would-have-blocked in monitor-only mode (logged, no 403)
	 *   - 'allowed'   → no detection matched; logged only when verbose=true
	 *
	 * Each bucket is sorted by count DESC for at-a-glance triage.
	 *
	 * @return array{enforced: array<string,int>, monitored: array<string,int>, allowed: array<string,int>}
	 */
	function bb_result_breakdown($engine, string $window_sql): array
	{
		$sql = 'SELECT `status_code`, `enforcement_action`, COUNT(*) AS n '
			. 'FROM ' . $engine->prefix . 'bad_behaviour '
			. 'WHERE 1=1 ' . $window_sql
			. 'GROUP BY `status_code`, `enforcement_action`';

		try {
			$rows = $engine->db->load_all($sql, true) ?: [];
		} catch (\Throwable $e) {
			return ['enforced' => [], 'monitored' => [], 'allowed' => []];
		}

		$out = [
			'enforced'  => [],
			'monitored' => [],
			'allowed'   => [],
		];

		foreach ($rows as $row) {
			$code   = (string)($row['status_code'] ?? '');
			$action = (string)($row['enforcement_action'] ?? 'enforced');
			$n	  = (int)($row['n'] ?? 0);

			if ($n <= 0 || $code === '') continue;

			// Bucket by enforcement_action. The status_code prefix
			// (blocked./monitored./allowed) should agree with the action,
			// but we trust the action column because it's the recorded
			// ground truth (log_request() writes both).
			switch ($action) {
				case 'allowed':
					$out['allowed'][$code]   = ($out['allowed'][$code]   ?? 0) + $n;
					break;

				case 'monitored':
					// Guard: if the code prefix doesn't match (corrupted row),
					// still record under 'monitored' bucket — better than dropping.
					$out['monitored'][$code] = ($out['monitored'][$code] ?? 0) + $n;
					break;

				case 'enforced':
				default:
					// Legacy/safe path: code 'allowed' logged with enforcement=enforced
					// shouldn't happen with current log_request(), but handle it.
					if ($code === 'allowed') {
						$out['allowed'][$code] = ($out['allowed'][$code] ?? 0) + $n;
					} else {
						$out['enforced'][$code] = ($out['enforced'][$code] ?? 0) + $n;
					}
					break;
			}
		}

		// Sort each bucket: highest count first.
		foreach ($out as &$bucket) {
			arsort($bucket, SORT_NUMERIC);
		}
		unset($bucket);

		return $out;
	}

	/**
	 * Render a single breakdown box.
	 *
	 * @param array<string,int> $codes				Code => count
	 * @param string			$bucket_filter_value  'true' for blocked+monitored boxes,
	 *											   'false' for allowed box
	 * @param array<string,string> $filter_args	   Optional URL state to propagate
	 */
	function bb_render_breakdown_box(
		$engine,
		?string $title,
		string $icon,
		string $css_class,
		array $codes,
		string $bucket_filter_value,
		string $window_key,
		array $filter_args = []
		): string {
		$total = array_sum($codes);
		$responses = bb_get_responses($engine);

		$html  = '<div class="bb-breakdown-box ' . Ut::html($css_class) . '">';
		$html .= '<header class="bb-bb-header">';
		$html .= '<span class="bb-sev">' . $icon . '</span> ';
		$html .= '<strong>' . Ut::html($title) . '</strong> ';
		$html .= '<span class="bb-bb-total">' . $engine->number_format($total) . ' '
			. $engine->_t('BbHits') . '</span>';
		$html .= '</header>';

		if (empty($codes)) {
			$html .= '<p class="bb-bb-empty"><em>' . Ut::html($engine->_t('BbNoData')) . '</em></p>';
		} else {
			$html .= '<table class="bb-bb-codes">';

			foreach ($codes as $code => $n) {
				// Per-code drill-down link: status_code=<code> + blocked=<bucket>.
				// bb_manage()'s WHERE clause checks status_code FIRST when non-empty,
				// so the per-code filter is precise.
				$code_args = bb_clean_url_args($filter_args + [
					'setting'	 => 'bb_manage',
					'mode'		=> 'tool_badbehaviour',
					'status_code' => $code,
					'blocked'	 => $bucket_filter_value,
					'since'	   => $window_key,
				]);
				$code_link = $engine->href('', '', $code_args);

				// Short label: strip the bucket prefix so the row reads
				// "attack_pattern" instead of "blocked.attack_pattern"
				// (the box header already tells you which bucket you're in).
				$short = preg_replace('/^(blocked|monitored)\./', '', $code);
				if ($short === $code && $code !== 'allowed') {
					// Unknown prefix — keep as-is rather than silently mangling
					$short = $code;
				}

				// Human-friendly label from ResultCode enum (falls back to short).
				$label = $responses[$code]['explanation'] ?? $short;

				$html .= '<tr>';
				$html .= '<td class="bb-bb-code">'
					. '<a href="' . $code_link . '" title="'
						. Ut::html($label) . '">' . Ut::html($short) . '</a></td>';
						$html .= '<td class="bb-bb-count">'
							. '<a href="' . $code_link . '">'
								. $engine->number_format($n) . '</a></td>';
								$html .= '</tr>';
			}

			$html .= '</table>';

			// Bucket-level "View all" link — uses blocked= filter to catch
			// ALL codes in the bucket even if a specific code isn't in the
			// current window (operator can widen the time window from there).
			$bucket_args = bb_clean_url_args($filter_args + [
				'setting' => 'bb_manage',
				'mode'	=> 'tool_badbehaviour',
				'blocked' => $bucket_filter_value,
				'since'   => $window_key,
			]);
			$html .= '<footer class="bb-bb-footer">';
			$html .= '<a href="' . $engine->href('', '', $bucket_args) . '">'
				. Ut::html($engine->_t('BbViewAllInLog')) . ' →</a>';
				$html .= '</footer>';
		}

		$html .= '</div>';
		return $html;
	}

	function bb_summary($engine)
	{
		$window = bb_time_window($engine);

		echo $engine->form_open('bb_manage', ['form_more' => 'setting=bb_manage']);
		?>
		<div class="alignleft">
		<?php echo Ut::perc_replace($engine->_t('BbStats'), '<strong>' . bb_insert_stats($engine) . '</strong>');?>
		</div>

		<?php echo bb_render_time_selector($engine, $window['key'], ''); ?>

		<div class="bb-summary-grid">
			<div class="bb-summary-col">
				<?php $blocked = bb_top_blocked($engine, $window['sql'], 10); ?>
				<h3><?php echo $engine->_t('BbTopBlocked');?> <small>(<?php echo $window['label']; ?>)</small></h3>
				<?php if ($blocked): ?>
				<table class="bb-summary formation lined">
					<thead>
						<tr>
							<th scope="col"><?php echo $engine->_t('BbIp');?></th>
							<th scope="col"><?php echo $engine->_t('BbHits');?></th>
							<th scope="col"><?php echo $engine->_t('BbLastSeen');?></th>
							<th scope="col"><?php echo $engine->_t('BbCategories');?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($blocked as $row): ?>
						<tr>
							<td class="label">
								<a href="<?php echo $engine->href('', '', ['setting' => 'bb_manage', 'ip' => $row['ip'], 'since' => $window['key']]); ?>">
									<?php echo Ut::html($row['ip']); ?>
								</a>
							</td>
							<td><?php echo $engine->number_format((int)$row['hits']); ?></td>
							<td><?php echo Ut::html($row['last_seen']); ?></td>
							<td><?php echo Ut::html($row['categories'] ?? ''); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php else: ?>
					<p><em><?php echo $engine->_t('BbNoData');?></em></p>
				<?php endif; ?>
			</div>

			<div class="bb-summary-col">
				<?php $bots = bb_bot_breakdown($engine, $window['sql']); ?>
				<h3><?php echo $engine->_t('BbBotBreakdown');?> <small>(<?php echo $window['label']; ?>)</small></h3>
				<?php if ($bots): ?>
				<table class="bb-summary formation lined">
					<thead>
						<tr>
							<th scope="col"><?php echo $engine->_t('BbCategory');?></th>
							<th scope="col"><?php echo $engine->_t('BbHits');?></th>
							<th scope="col"><?php echo $engine->_t('BbVerifiedPct');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$max = max(array_column($bots, 'n'));
					foreach ($bots as $row):
						$n = (int)$row['n'];
						$v = (int)$row['verified_count'];
						$pct = $n > 0 ? round(($v / $n) * 100) : 0;
						$bar_width = $max > 0 ? round(($n / $max) * 100) : 0;
					?>
						<tr>
							<td class="label">
								<a href="<?php echo $engine->href('', '', ['setting' => 'bb_manage', 'bot_category' => $row['bot_category'], 'since' => $window['key']]); ?>">
									<?php echo Ut::html($row['bot_category']); ?>
								</a>
							</td>
							<td>
								<?php echo $engine->number_format($n); ?>
								<span class="bb-bar"><span class="bb-bar-fill" style="width: <?php echo $bar_width; ?>%;"></span></span>
							</td>
							<td><?php echo $pct; ?>%</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php else: ?>
					<p><em><?php echo $engine->_t('BbNoData');?></em></p>
				<?php endif; ?>
			</div>
		</div>

		<?php
		$breakdown = bb_result_breakdown($engine, $window['sql']);
		$settings_for_breakdown = bb_read_settings($engine);
		?>
		<h3><?php echo $engine->_t('BbResultBreakdown');?> <small>(<?php echo $window['label']; ?>)</small></h3>
		<div class="bb-breakdown-row">

		<?php
			echo bb_render_breakdown_box(
				$engine,
				$engine->_t('BbBreakdownBlocked'),
				'●',
				'sev-bad',
				$breakdown['enforced'],
				'true',
				$window['key']
			);

			echo bb_render_breakdown_box(
				$engine,
				$engine->_t('BbBreakdownMonitored'),
				'◌',
				'sev-warn',
				$breakdown['monitored'],
				'true',
				$window['key']
			);

			echo bb_render_breakdown_box(
				$engine,
				$engine->_t('BbBreakdownAllowed'),
				'✓',
				'sev-ok',
				$breakdown['allowed'],
				'false',
				$window['key']
			);
			?>

		</div>

		<?php
		$settings = bb_read_settings($engine);
		if (!empty($settings['geoip']['enabled']))
		{
			$geo = bb_geo_summary($engine, $window['sql']);
			if ($geo['countries'] || $geo['asns']):
			?>
			<h3><?php echo $engine->_t('BbGeoSummary');?> <small>(<?php echo $window['label']; ?>)</small></h3>
			<?php if ($geo['countries']): ?>
			<table class="bb-summary formation lined">
				<thead><tr><th><?php echo $engine->_t('BbCountry');?></th><th><?php echo $engine->_t('BbHits');?></th></tr></thead>
				<tbody>
				<?php foreach ($geo['countries'] as $row): ?>
					<tr><td class="label"><?php echo Ut::html($row['country']);?></td><td><?php echo (int)$row['n'];?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
			<?php if ($geo['asns']): ?>
			<table class="bb-summary formation lined">
				<thead><tr><th><?php echo $engine->_t('BbAsn');?></th><th><?php echo $engine->_t('BbHits');?></th></tr></thead>
				<tbody>
				<?php foreach ($geo['asns'] as $row): ?>
					<tr><td class="label"><?php echo Ut::html($row['asn']);?></td><td><?php echo (int)$row['n'];?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
			<?php endif; ?>
		<?php } ?>
		<?php
	}

	// ============================================================
	// MANAGE view — JS-free, sortable, bulk actions, resolved workflow
	// ============================================================

	function bb_manage($engine)
	{
		$bb_table = $engine->prefix . 'bad_behaviour';

		// === Filter reads ===
		$g_search		 = trim((string)($_GET['search']		 ?? ''));
		$g_bot_category   = trim((string)($_GET['bot_category']   ?? ''));
		$g_request_method = trim((string)($_GET['request_method'] ?? ''));
		$g_blocked		= trim((string)($_GET['blocked']		?? ''));
		$g_key			= trim((string)($_GET['status_code']	?? ''));
		$g_ip			 = trim((string)($_GET['ip']			 ?? ''));
		$g_user_agent	 = trim((string)($_GET['user_agent']	 ?? ''));
		$g_request_uri	= trim((string)($_GET['request_uri']	?? ''));
		$g_date_from	  = trim((string)($_GET['date_from']	  ?? ''));
		$g_date_to		= trim((string)($_GET['date_to']		?? ''));
		$g_slow		   = !empty($_GET['slow']);
		$g_resolved	   = $_GET['resolved'] ?? 'active';
		$g_check		  = $_GET['check'] ?? '';
		$g_sort		   = in_array($_GET['sort'] ?? '', ['log_id','ip','status_code','bot_category','request_time_ms'], true)
		? $_GET['sort'] : 'log_id';
		$g_dir			= (($_GET['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

		// MERGED: Single view mode for both headers and body
		$g_view_content   = bb_get_view_mode('content', 'full');
		$g_mark_all	   = ($_GET['mark_all'] ?? '') === '1';

		$window = bb_time_window($engine);

		// === Build WHERE clause ===
		$where = $window['sql'];

		if ($g_search !== '')
		{
			if (preg_match('/^[0-9a-f]{4}(-[0-9a-f]{4}){2,}$/i', $g_search))
			{
				$where .= 'AND `support_key` = ' . $engine->db->q($g_search) . ' ';
			}
			else
			{
				$search_escaped = str_replace(['\\','%','_'], ['\\\\','\\%','\\_'], $g_search);
				$like = $engine->db->q('%' . $search_escaped . '%');
				$where .= 'AND ('
	 	. '`user_agent`  LIKE ' . $like . ' OR '
	 	. '`request_uri` LIKE ' . $like . ' OR '
	 	. '`host`		LIKE ' . $like . ' OR '
	 	. '`ip`		  LIKE ' . $like . ' OR '
	 	. '`status_code` LIKE ' . $like . ' OR '
	 	. '`support_key` LIKE ' . $like
	 	. ') ';
			}
		}

		$valid_categories = [
			'search_engine','ai_crawler','social_crawler','seo_crawler','archive_crawler',
			'monitoring','feed_reader','shopping_crawler','cloud_infrastructure',
			'security_scanner','residential_proxy','malicious','unknown',
		];
		if ($g_bot_category !== '' && in_array($g_bot_category, $valid_categories, true))
		{
			$where .= 'AND `bot_category` = ' . $engine->db->q($g_bot_category) . ' ';
		}

		$valid_methods = ['GET','POST','HEAD','PUT','PATCH','DELETE','OPTIONS','TRACE'];
		if ($g_request_method !== '' && in_array($g_request_method, $valid_methods, true))
		{
			$where .= 'AND `request_method` = ' . $engine->db->q($g_request_method) . ' ';
		}

		if (!empty($g_key))
		{
			$where .= 'AND `status_code` = ' . $engine->db->q($g_key) . ' ';
		}
		elseif ($g_blocked === 'true')
		{
			$where .= "AND `status_code` != 'allowed' ";
		}
		elseif ($g_blocked === 'false')
		{
			$where .= "AND `status_code`  = 'allowed' ";
		}

		if (!empty($g_ip))			$where .= 'AND `ip` = ' . $engine->db->q($g_ip) . ' ';
		if (!empty($g_user_agent))	$where .= 'AND `user_agent_hash` = ' . $engine->db->q($g_user_agent) . ' ';
		if (!empty($g_request_uri))   $where .= 'AND `request_uri_hash` = ' . $engine->db->q($g_request_uri) . ' ';
		if ($g_date_from !== '' && preg_match('/^\d{4}-\d{2}-\d{2}/', $g_date_from))
			$where .= 'AND `date` >= ' . $engine->db->q($g_date_from) . ' ';
			if ($g_date_to !== '' && preg_match('/^\d{4}-\d{2}-\d{2}/', $g_date_to))
				$where .= 'AND `date` <= ' . $engine->db->q($g_date_to . ' 23:59:59') . ' ';
		if ($g_slow)				  $where .= 'AND `request_time_ms` > 1000 ';

		// Resolved filter
		if ($g_resolved === 'active')
		{
			$where .= 'AND `resolved_at` IS NULL ';
		}
		elseif ($g_resolved === 'resolved')
		{
			$where .= 'AND `resolved_at` IS NOT NULL ';
		}

		// Check filter
		if ($g_check === '1')
		{
			$where .= 'AND `check` = 1 ';
		}
		elseif ($g_check === '0')
		{
			$where .= 'AND `check` = 0 ';
		}

		// === Pagination ===
		$limit = 100;

		$count = $engine->db->load_single(
			'SELECT COUNT(log_id) AS n FROM ' . $engine->prefix . 'bad_behaviour l WHERE 1=1 ' . $where
		);

		// Build filter_args WITHOUT the removed fields
		$filter_args = array_filter([
		'search'		 => $g_search,
		'bot_category'   => $g_bot_category,
		'request_method' => $g_request_method,
		'blocked'		=> $g_blocked,
		'status_code'	=> $g_key,
		'ip'			 => $g_ip,
		'user_agent'	 => $g_user_agent,
		'request_uri'	=> $g_request_uri,
		'date_from'	  => $g_date_from,
		'date_to'		=> $g_date_to,
		'slow'		   => $g_slow ? '1' : '',
		'resolved'	   => $g_resolved !== 'active' ? $g_resolved : '',
		'check'		  => $g_check,
		'sort'		   => $g_sort !== 'log_id' ? $g_sort : '',
		'dir'			=> $g_dir !== 'DESC' ? strtolower($g_dir) : '',
		'since'		  => $window['key'] !== '24h' ? $window['key'] : '',
		// MERGED: single view_content instead of view_headers/view_body
		'view_content'   => $g_view_content !== 'full' ? $g_view_content : '',
		], fn($v) => $v !== '');

		// Sanitize via allowlist (which no longer includes removed fields)
		$filter_args = bb_clean_url_args($filter_args);

		if (isset($_GET['p']) && (int)$_GET['p'] > 1)
		{
			$filter_args['p'] = (int)$_GET['p'];
		}

		$pagination = $engine->pagination(
			$count['n'], $limit, 'p',
			$filter_args + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour'],
			'', 'admin.php'
		);

		$totalcount = $engine->db->load_single(
			'SELECT COUNT(log_id) AS n FROM ' . $engine->prefix . 'bad_behaviour l'
		);

		$results = $engine->db->load_all(
			'SELECT log_id, ip, host, date, request_method, request_uri, server_protocol, '
			. 'http_headers, user_agent, user_agent_hash, request_entity, status_code, '
			. 'status_message, bot_category, bot_verified, support_key, ja3, request_time_ms, '
			. 'resolved_at, `check` '
			. 'FROM `' . $bb_table . '` '
			. 'WHERE 1=1 ' . $where
			. 'ORDER BY `' . $g_sort . '` ' . $g_dir . ', `log_id` DESC '
			. $pagination['limit']
			);

		// === Sortable headers ===
		$next_dir_for = function(string $col) use ($g_sort, $g_dir) {
			return ($col === $g_sort) ? (($g_dir === 'ASC') ? 'desc' : 'asc') : 'desc';
		};
		$sort_args_for = function(string $col) use ($filter_args, $next_dir_for) {
			return $filter_args + [
				'setting' => 'bb_manage',
				'mode'	=> 'tool_badbehaviour',
				'sort'	=> $col,
				'dir'	 => $next_dir_for($col),
			];
		};
		$arrow_for = function(string $col) use ($g_sort, $g_dir) {
			if ($col !== $g_sort) return '';
			return ($g_dir === 'ASC') ? ' ▲' : ' ▼';
		};

		// === Filter form (GET) ===
		echo $engine->form_open('bb_manage', [
			'href_param' => [
				'setting' => 'bb_manage',
				'mode'    => 'tool_badbehaviour',
				'since'   => $window['key']
			],
			'form_method' => 'get'
		]);
		echo '<input type="hidden" name="setting" value="bb_manage">';
		echo '<input type="hidden" name="mode" value="tool_badbehaviour">';
		echo '<input type="hidden" name="since" value="' . Ut::html($window['key']) . '">';
		?>

	<div class="alignleft">
		<?php echo Ut::perc_replace($engine->_t('BbRecordsFiltered'),
			'<strong>' . $engine->number_format($count['n']) . '</strong>',
			'<strong>' . $engine->number_format($totalcount['n']) . '</strong>'
		) . ':'; ?>
	</div>

	<?php echo bb_render_time_selector($engine, $window['key'], 'bb_manage', $filter_args); ?>

	<div class="bb-filter-bar">
		<input type="search" name="search"
			placeholder="<?php echo Ut::html($engine->_t('BbSearchPlaceholder') ?? ''); ?>"
			value="<?php echo Ut::html($g_search); ?>"
			autocomplete="off" class="bb-filter-search">

		<select name="bot_category" class="bb-filter-select">
			<option value=""><?php echo $engine->_t('BbFilterAnyCategory'); ?></option>
			<?php
			$bot_categories = [
				'search_engine'		=> $engine->_t('BbCatSearchEngine'),
				'ai_crawler'		   => $engine->_t('BbCatAiCrawler'),
				'social_crawler'	   => $engine->_t('BbCatSocialCrawler'),
				'seo_crawler'		  => $engine->_t('BbCatSeoCrawler'),
				'archive_crawler'	  => $engine->_t('BbCatArchiveCrawler'),
				'monitoring'		   => $engine->_t('BbCatMonitoring'),
				'feed_reader'		  => $engine->_t('BbCatFeedReader'),
				'shopping_crawler'	 => $engine->_t('BbCatShoppingCrawler'),
				'cloud_infrastructure' => $engine->_t('BbCatCloudInfra'),
				'security_scanner'	 => $engine->_t('BbCatSecurityScanner'),
				'residential_proxy'	=> $engine->_t('BbCatResidentialProxy'),
				'malicious'			=> $engine->_t('BbCatMalicious'),
				'unknown'			  => $engine->_t('BbCatUnknown'),
			];
			foreach ($bot_categories as $value => $label): ?>
				<option value="<?php echo Ut::html($value); ?>"<?php echo ($g_bot_category === $value ? ' selected' : ''); ?>><?php echo Ut::html($label); ?></option>
			<?php endforeach; ?>
		</select>

		<select name="request_method" class="bb-filter-select">
			<option value=""><?php echo $engine->_t('BbFilterAnyMethod'); ?></option>
			<?php foreach (['GET','POST','HEAD','PUT','PATCH','DELETE','OPTIONS','TRACE'] as $method): ?>
				<option value="<?php echo $method; ?>"<?php echo ($g_request_method === $method ? ' selected' : ''); ?>><?php echo $method; ?></option>
			<?php endforeach; ?>
		</select>

		<select name="blocked" class="bb-filter-select">
			<option value="" <?php echo ($g_blocked === '' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterAnyStatus'); ?></option>
			<option value="true" <?php echo ($g_blocked === 'true' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterBlockedOnly'); ?></option>
			<option value="false" <?php echo ($g_blocked === 'false' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterPermittedOnly'); ?></option>
		</select>

		<select name="resolved" class="bb-filter-select">
			<option value="active" <?php echo ($g_resolved === 'active' ? 'selected' : ''); ?>><?php echo $engine->_t('BbResolvedActive'); ?></option>
			<option value="resolved" <?php echo ($g_resolved === 'resolved' ? 'selected' : ''); ?>><?php echo $engine->_t('BbResolvedOnly'); ?></option>
			<option value="all" <?php echo ($g_resolved === 'all' ? 'selected' : ''); ?>><?php echo $engine->_t('BbResolvedAll'); ?></option>
		</select>

		<select name="check" class="bb-filter-select">
			<option value="" <?php echo ($g_check === '' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterAnyCheck'); ?></option>
			<option value="1" <?php echo ($g_check === '1' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterCheckedOnly'); ?></option>
			<option value="0" <?php echo ($g_check === '0' ? 'selected' : ''); ?>><?php echo $engine->_t('BbFilterUncheckedOnly'); ?></option>
		</select>

		<button type="submit" class="button"><?php echo $engine->_t('BbFilterApply');?></button>
		<?php if ($g_search !== '' || $g_bot_category !== '' || $g_request_method !== '' || $g_blocked !== '' || $g_resolved !== 'active'): ?>
			<a href="<?php echo $engine->href('', '', ['setting' => 'bb_manage']); ?>" class="button"><?php echo $engine->_t('BbFilterClear');?></a>
		<?php endif; ?>
	</div>

	<details class="bb-advanced-filters">
		<summary><?php echo $engine->_t('BbAdvancedFilters');?></summary>
		<div class="bb-filter-bar" style="margin-top: 0.5rem;">
			<label><?php echo $engine->_t('BbDateFrom');?>
				<input type="date" name="date_from" value="<?php echo Ut::html($g_date_from); ?>" class="bb-filter-input">
			</label>
			<label><?php echo $engine->_t('BbDateTo');?>
				<input type="date" name="date_to" value="<?php echo Ut::html($g_date_to); ?>" class="bb-filter-input">
			</label>
			<label>
				<input type="checkbox" name="slow" value="1"<?php echo ($g_slow ? ' checked' : ''); ?>>
				<?php echo $engine->_t('BbSlowOnly');?>
			</label>
		</div>
		<div class="bb-filter-bar">
			<!-- MERGED: Single view mode for Headers + Body -->
			<label><?php echo $engine->_t('BbViewContentLabel');?>:
				<select name="view_content" class="bb-filter-select">
					<option value="teaser"<?php echo ($g_view_content === 'teaser' ? ' selected' : ''); ?>><?php echo $engine->_t('BbViewModeTeaser');?></option>
					<option value="full"<?php echo ($g_view_content === 'full' ? ' selected' : ''); ?>><?php echo $engine->_t('BbViewModeFull');?></option>
					<option value="hidden"<?php echo ($g_view_content === 'hidden' ? ' selected' : ''); ?>><?php echo $engine->_t('BbViewModeHidden');?></option>
				</select>
			</label>
		</div>
	</details>

	<?php
	// === Filter chips (WITHOUT removed fields) ===
	$active_chips = [];

	if ($g_search !== '')
	{
		$args = $filter_args; unset($args['search']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipSearch') . ': ' . Ut::html(mb_strimwidth($g_search, 0, 30, '…')),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_bot_category !== '')
	{
		$args = $filter_args; unset($args['bot_category']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipCategory') . ': ' . Ut::html($g_bot_category),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_request_method !== '')
	{
		$args = $filter_args; unset($args['request_method']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipMethod') . ': ' . Ut::html($g_request_method),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_blocked !== '')
	{
		$args = $filter_args; unset($args['blocked']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipStatus') . ': ' . ($g_blocked === 'true' ? $engine->_t('BbBlocked') : $engine->_t('BbPermitted')),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_key !== '')
	{
		$args = $filter_args; unset($args['status_code']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipStatusCode') . ': ' . Ut::html($g_key),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_ip !== '')
	{
		$args = $filter_args; unset($args['ip']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipIp') . ': ' . Ut::html($g_ip),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_user_agent !== '')
	{
		$args = $filter_args; unset($args['user_agent']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipUa') . ': ' . Ut::html(mb_strimwidth($g_user_agent, 0, 16, '…')),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_request_uri !== '')
	{
		$args = $filter_args; unset($args['request_uri']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipUri') . ': ' . Ut::html(mb_strimwidth($g_request_uri, 0, 30, '…')),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_slow)
	{
		$args = $filter_args; unset($args['slow']);
		$active_chips[] = ['label' => $engine->_t('BbChipSlow'), 'link' => $engine->href('', '', ['setting' => 'bb_manage'] + $args)];
	}
	if ($g_date_from !== '' || $g_date_to !== '')
	{
		$args = $filter_args; unset($args['date_from'], $args['date_to']);
		$range = trim($g_date_from . ' → ' . $g_date_to, ' →');
		$active_chips[] = ['label' => $engine->_t('BbChipDate') . ': ' . Ut::html($range), 'link' => $engine->href('', '', ['setting' => 'bb_manage'] + $args)];
	}
	if ($g_resolved !== 'active')
	{
		$args = $filter_args; unset($args['resolved']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipResolved') . ': ' . $engine->_t('BbResolved' . ucfirst($g_resolved)),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}
	if ($g_check !== '')
	{
		$args = $filter_args; unset($args['check']);
		$active_chips[] = [
			'label' => $engine->_t('BbChipCheck') . ': ' . ($g_check === '1' ? $engine->_t('BbChecked') : $engine->_t('BbUnchecked')),
			'link'  => $engine->href('', '', ['setting' => 'bb_manage'] + $args),
		];
	}

	if ($active_chips): ?>
		<div class="bb-filter-chips">
		<?php foreach ($active_chips as $chip): ?>
			<span class="bb-chip"><?php echo $chip['label']; ?> <a href="<?php echo $chip['link']; ?>" title="<?php echo $engine->_t('BbChipRemove'); ?>">×</a></span>
		<?php endforeach; ?>
		</div>
	<?php endif;

	// === Bulk-action form ===
	echo $engine->form_close();

	echo $engine->form_open('bb_bulk', [
		'href_param'  => ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour'],
		'form_method' => 'post',
		'form_id'	 => 'bb-bulk-form',
	]);
	echo '<input type="hidden" name="setting" value="bb_manage">';
	echo '<input type="hidden" name="mode" value="tool_badbehaviour">';

	$back_url = $engine->href('', '', $filter_args + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);
	echo '<input type="hidden" name="_back" value="' . Ut::html($back_url) . '">';
	?>

	<div class="bb-bulk-bar">
		<button type="submit" name="submit_action" value="bb_bulk_delete" class="button"><?php echo $engine->_t('BbBulkDeleteSelected');?></button>
		<button type="submit" name="submit_action" value="bb_bulk_whitelist" class="button"><?php echo $engine->_t('BbBulkWhitelistSelected');?></button>
		<button type="submit" name="submit_action" value="bb_bulk_resolve" class="button"><?php echo $engine->_t('BbBulkResolveSelected');?></button>
		<button type="submit" name="submit_action" value="bb_bulk_unresolve" class="button"><?php echo $engine->_t('BbBulkUnresolveSelected');?></button>
		<button type="submit" name="submit_action" value="bb_bulk_check" class="button"><?php echo $engine->_t('BbBulkCheckSelected');?></button>
		<button type="submit" name="submit_action" value="bb_bulk_uncheck" class="button"><?php echo $engine->_t('BbBulkUncheckSelected');?></button>
		<small class="bb-bulk-hint"><?php echo $engine->_t('BbBulkHint');?></small>
	</div>

	<?php $engine->print_pagination($pagination); ?>

	<table class="formation hl-line bb-log">
		<thead>
			<tr>
				<th scope="col" class="check-column"><?php
					$toggle_args  = $filter_args + [
						'setting' => 'bb_manage',
						'mode'	=> 'tool_badbehaviour',
					];

					if ($g_mark_all)
					{
						$toggle_args['mark_all'] = '0';
						$toggle_label = '☐';
						$toggle_title = $engine->_t('BbMarkNone');
					}
					else
					{
						$toggle_args['mark_all'] = '1';
						$toggle_label = '☑';
						$toggle_title = $engine->_t('BbMarkAll');
					}

					echo '<a href="' . $engine->href('', '', $toggle_args) . '#bb-bulk-form"'
						. ' title="' . Ut::html($toggle_title) . '"'
						. ' aria-label="' . Ut::html($toggle_title) . '">'
						. $toggle_label . '</a>';
				?></th>
				<th scope="col">
					<a href="<?php echo $engine->href('', '', $sort_args_for('log_id')); ?>">
						<?php echo $engine->_t('BbIpDateStatus'); echo $arrow_for('log_id'); ?>
					</a>
				</th>
				<th scope="col">
					<a href="<?php echo $engine->href('', '', $sort_args_for('bot_category')); ?>">
						<?php echo $engine->_t('BbCategory'); echo $arrow_for('bot_category'); ?>
					</a>
				</th>
				<th scope="col"><?php echo $engine->_t('BbHeaders');?></th>
				<th scope="col"><?php echo $engine->_t('BbEntity');?></th>
				<th scope="col">
					<a href="<?php echo $engine->href('', '', $sort_args_for('request_time_ms')); ?>">
						<?php echo $engine->_t('BbResponseTime'); echo $arrow_for('request_time_ms'); ?>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
	<?php
	$responses = bb_get_responses($engine);

	if ($results):
		foreach ($results as $result):
			$status_code = $responses[$result['status_code']] ?? $responses['__unknown__'];
			$is_resolved = !empty($result['resolved_at']);
			$is_checked  = !empty($result['check']);
			$row_class = 'bb-row'
				. ($is_resolved ? ' bb-resolved' : '')
				. ($is_checked ? ' bb-checked' : '');

			echo '<tr id="request-' . $result['log_id'] . '" class="' . $row_class . '">';
			echo '<td class="check-column">';
			echo '<input type="checkbox" name="submit[]" value="' . $result['log_id'] . '"'
			. ' aria-label="' . $engine->_t('BbSelectRow') . ' #' . $result['log_id'] . '"'
			. ($g_mark_all ? ' checked' : '')
			. '>';
			echo '</td>';

			$httpbl = bb_httpbl_lookup($engine, $result['ip']);

			if (empty($result['host']))
			{
				$host = @gethostbyaddr($result['ip']);
				$engine->db->sql_query(
					'UPDATE ' . $engine->prefix . 'bad_behaviour SET host = ' . $engine->db->q($host) . ' '
					. 'WHERE log_id = ' . (int)$result['log_id'] . ' ' . $engine->db->limit()
				);
			}

			$host = $result['host'];
			if (!strcmp($host, $result['ip'])) $host = '';
			else $host .= '<br>';

			$time_tz = $engine->sql2precisetime($result['date']);
			$rel_time = method_exists($engine, 'sql2relativetime')
				? $engine->sql2relativetime($result['date'])
				: $time_tz;

			echo '<td class="bb-meta">';
			echo '<a href="' . $engine->href('', '', ['setting' => 'bb_manage', 'ip' => $result['ip'], 'since' => $window['key']]) . '">' . Ut::html($result['ip']) . '</a><br>';
			echo $host;
			echo '<abbr title="' . Ut::html($time_tz) . '">' . Ut::html($rel_time) . '</abbr><br>';
			echo '<a href="' . $engine->href('', '', ['setting' => 'bb_manage', 'status_code' => $result['status_code']])
				. '" title="[' . $status_code['response'] . '] ' . Ut::html($status_code['explanation']) . '">'
				. Ut::html($status_code['log']) . '</a>';

			if (!empty($result['status_message']))
			{
				echo '<br><small>' . Ut::html($result['status_message']) . '</small>';
			}

			if ($httpbl)
			{
				echo '<br><a href="https://www.projecthoneypot.org/ip_' . Ut::html($result['ip']) . '">http:BL</a>:<br>' . $httpbl;
			}
			echo '</td>';

			echo '<td>';
			if (!empty($result['bot_category']))
			{
				$cat_link = $engine->href('', '', $filter_args + ['bot_category' => $result['bot_category']]);
				echo '<a href="' . $cat_link . '" class="bb-cat-badge" title="' . $engine->_t('BbFilterByCategory') . '">' . Ut::html($result['bot_category']) . '</a>';
				if (isset($result['bot_verified']))
				{
					$v_label = $result['bot_verified'] ? '✓ ' . $engine->_t('BbVerified') : '✗ ' . $engine->_t('BbUnverified');
					echo '<br><small>' . $v_label . '</small>';
				}
			}
			echo '</td>';

			echo '<td>' . bb_render_view_mode($engine, $result, 'http_headers', $g_view_content) . '</td>';
			echo '<td>' . bb_render_view_mode($engine, $result, 'request_entity', $g_view_content) . '</td>';

			// Response time + per-row actions
			echo '<td class="bb-ms">';
			if (!empty($result['request_time_ms']))
			{
				$ms = (int)$result['request_time_ms'];
				$bar_pct = min(100, ($ms / 1000) * 100);
				$bar_class = $ms > 1000 ? 'bb-ms-slow' : ($ms > 500 ? 'bb-ms-warn' : 'bb-ms-ok');
				echo '<span class="bb-ms-bar"><span class="bb-ms-fill ' . $bar_class . '" style="width: ' . $bar_pct . '%;"></span></span> ';
				echo '<small>' . $ms . ' ms</small>';
			}
			echo '<div class="bb-row-actions">';

			$action_args = $filter_args + [
				'setting' => 'bb_manage',
				'mode'	=> 'tool_badbehaviour',
				'_action' => $is_resolved ? 'bb_unresolve' : 'bb_resolve',
				'id'	  => (int)$result['log_id'],
			];

			$action_label = $is_resolved
				? $engine->_t('BbActionUnresolve')
				: $engine->_t('BbActionResolve');

			echo '<a href="' . $engine->href('', '', $action_args) . '">[' . $action_label . ']</a>';

			$check_action = $is_checked ? 'bb_uncheck' : 'bb_check';
			$check_label  = $is_checked
				? $engine->_t('BbActionUncheck')
				: $engine->_t('BbActionCheck');
			$check_class  = $is_checked ? ' bb-row-checked' : '';

			echo '<a href="' . $engine->href('', '', $filter_args + [
				'setting' => 'bb_manage',
				'mode'	=> 'tool_badbehaviour',
				'_action' => $check_action,
				'id'	  => (int)$result['log_id'],
			]) . '" class="bb-row-check' . $check_class . '" title="'
				. Ut::html($is_checked
					? $engine->_t('BbRowCheckedHint')
					: $engine->_t('BbRowUncheckedHint'))
				. '">[' . $check_label . ']</a>';

			echo '</div>';
			echo '</td>';

			echo '</tr>';
		endforeach;
	endif;
	?>
		</tbody>
	</table>

	<?php
	$engine->print_pagination($pagination);
	echo $engine->form_close();
}

	// ============================================================
	// Whitelist editor (unchanged)
	// ============================================================

	function bb_whitelist($engine)
	{
		$whitelists = bb_read_whitelist($engine);
		if (empty($whitelists))
		{
			$whitelists = ['ip' => [], 'url' => [], 'useragent' => []];
		}

		if ($_POST)
		{
			$whitelists['ip']		 = $_POST['ip']		 ? array_filter(preg_split('/\s+/m', $_POST['ip']))		 : [];
			$whitelists['url']		= $_POST['url']		? array_filter(preg_split('/\s+/m', $_POST['url']))		: [];
			$whitelists['useragent']  = $_POST['useragent']  ? array_filter(preg_split("/[\r\n]+/m", $_POST['useragent'])) : [];
			?>
			<div id="message" class="updated fade"><p><strong><?php echo $engine->_t('BbOptionsSaved');?></strong></p></div>
			<?php
		}

		echo $engine->form_open('bb_whitelist', ['form_more' => 'setting=bb_whitelist']);
		?>
		<p><?php echo $engine->_t('BbWhitelistHint');?></p>
		<table class="setting formation">
			<tr><th colspan="2"><br><?php echo $engine->_t('BbWhitelist');?></th></tr>
			<tr class="hl-setting">
				<td class="label"><label for="whitelists_ip"><strong><?php echo $engine->_t('BbIpAddress');?>:</strong></label><br><small><?php echo $engine->_t('BbIpAddressInfo');?></small></td>
				<td><textarea cols="30" rows="6" id="whitelists_ip" name="ip"><?php echo Ut::html(implode("\n", $whitelists['ip'])); ?></textarea></td>
			</tr>
			<tr class="lined"><td colspan="2"></td></tr>
			<tr class="hl-setting">
				<td class="label"><label for="whitelists_url"><strong><?php echo $engine->_t('BbUrl');?>:</strong></label><br><small><?php echo $engine->_t('BbUrlInfo');?></small></td>
				<td><textarea cols="50" rows="6" id="whitelists_url" name="url"><?php echo Ut::html(implode("\n", $whitelists['url'])); ?></textarea></td>
			</tr>
			<tr class="lined"><td colspan="2"></td></tr>
			<tr class="hl-setting">
				<td class="label"><label for="whitelists_useragent"><strong><?php echo $engine->_t('BbUserAgent');?>:</strong></label><br><small><?php echo $engine->_t('BbUserAgentInfo');?></small></td>
				<td><textarea cols="50" rows="6" id="whitelists_useragent" name="useragent"><?php echo Ut::html(implode("\n", $whitelists['useragent'])); ?></textarea></td>
			</tr>
		</table>
		<br>
		<div class="center"><button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button></div>
		<?php
		echo $engine->form_close();
	}

	// ============================================================
	// Options editor
	// ============================================================
	function bb_options($engine, array $settings = null)
	{
		if ($settings === null) $settings = bb_read_settings($engine);

		if (!empty($_GET['bb_save_error']))
		{
			echo '<div id="message" class="error fade"><p><strong>'
	 	. $engine->_t('BbSettingsSaveFailed') . ':</strong> '
	 	. Ut::html(base64_decode($_GET['bb_save_error'])) . '</p></div>';
		}

		// === Derived state ===
		// Reconstruct "behind_proxy" from reverse_proxy.enabled
		$behind_proxy = !empty($settings['reverse_proxy']['enabled'] ?? $settings['reverse_proxy'] ?? false);

		// Reconstruct logging_mode from logging + verbose
		$logging_on  = (bool)($settings['logging'] ?? true);
		$verbose_on  = (bool)($settings['verbose'] ?? false);
		$logging_mode = !$logging_on ? 'off' : ($verbose_on ? 'verbose' : 'normal');

		?>
	<div class="wrap">
		<!-- ========================================================== -->
		<!-- MASTER ENABLE — separate form, posts to bb_options_enable  -->
		<!-- ========================================================== -->
	<?php echo $engine->form_open('bb_options_enable', ['form_more' => 'setting=bb_options_enable']); ?>
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr class="lined"><td colspan="2"></td></tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('BbEnable');?></strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('BbEnableInfo'), '<code>bb_config.php</code>');?></small>
				</td>
				<td>
					<input type="radio" id="enable_bad-behaviour_on" name="ext_bad_behaviour" value="1"<?php echo ($engine->db->ext_bad_behaviour ? ' checked' : '');?>>
					<label for="enable_bad-behaviour_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_bad-behaviour_off" name="ext_bad_behaviour" value="0"<?php echo (!$engine->db->ext_bad_behaviour ? ' checked' : '');?>>
					<label for="enable_bad-behaviour_off"><?php echo $engine->_t('Off');?></label>
					<button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button>
				</td>
			</tr>
		</table>
		<?php echo $engine->form_close(); ?>

		<?php echo $engine->form_open('bb_options', ['form_more' => 'setting=bb_options']); ?>
		<!-- ========================================================== -->
		<!-- BASIC SECTION											   -->
		<!-- ========================================================== -->
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
		<tr><th colspan="2"><br><?php echo $engine->_t('BbBasicSection');?></th></tr>

		<tr class="hl-setting">
			<td class="label">
				<label for="bb_preset"><strong><?php echo $engine->_t('BbPreset');?></strong></label><br>
				<small><?php echo $engine->_t('BbPresetInfo');?></small>
			</td>
			<td>
				<select id="bb_preset" name="preset">
					<?php foreach ([
						'minimal'		=> $engine->_t('BbPresetMinimal'),
						'full'		   => $engine->_t('BbPresetFull'),
						'verified-only'  => $engine->_t('BbPresetVerifiedOnly'),
						'no-ai'		  => $engine->_t('BbPresetNoAi'),
						'no-seo'		 => $engine->_t('BbPresetNoSeo'),
						'eu-only'		=> $engine->_t('BbPresetEuOnly'),
						'human-only'	 => $engine->_t('BbPresetHumanOnly'),
						'custom'		 => $engine->_t('BbPresetCustom'),
					] as $val => $label): ?>
						<option value="<?php echo $val; ?>"<?php echo (($settings['preset'] ?? 'minimal') === $val ? ' selected' : ''); ?>>
							<?php echo $label; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<tr class="hl-setting">
			<td class="label">
				<label for="bb_strictness"><strong><?php echo $engine->_t('BbStrictness');?></strong></label><br>
				<small><?php echo $engine->_t('BbStrictnessInfo');?></small>
			</td>
			<td>
				<select id="bb_strictness" name="strictness">
					<?php foreach ([
						'monitor-only' => $engine->_t('BbStrictnessMonitorOnly'),
						'normal'	   => $engine->_t('BbStrictnessNormal'),
						'strict'	   => $engine->_t('BbStrictnessStrict'),
					] as $val => $label): ?>
						<option value="<?php echo $val; ?>"<?php echo (($settings['strictness'] ?? 'normal') === $val ? ' selected' : ''); ?>>
							<?php echo $label; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<tr class="hl-setting">
			<td class="label">
				<label for="bb_logging_mode"><strong><?php echo $engine->_t('BbLoggingMode');?></strong></label><br>
				<small><?php echo $engine->_t('BbLoggingModeInfo');?></small>
			</td>
			<td>
				<input type="radio" id="log_normal" name="logging_mode" value="normal"<?php echo ($logging_mode === 'normal' ? ' checked' : ''); ?>>
				<label for="log_normal"><?php echo $engine->_t('BbLogModeNormal');?></label>

				<input type="radio" id="log_verbose" name="logging_mode" value="verbose"<?php echo ($logging_mode === 'verbose' ? ' checked' : ''); ?>>
				<label for="log_verbose"><?php echo $engine->_t('BbLogModeVerbose');?></label>

				<input type="radio" id="log_off" name="logging_mode" value="off"<?php echo ($logging_mode === 'off' ? ' checked' : ''); ?>>
				<label for="log_off"><?php echo $engine->_t('BbLogModeOff');?></label>
			</td>
		</tr>

	</table>

	<!-- ============================================================== -->
	<!-- ADVANCED SECTION — collapsed by default						 -->
	<!-- ============================================================== -->
	<details class="bb-advanced">
		<summary><strong><?php echo $engine->_t('BbAdvancedSection');?></strong></summary>
		<p><small><?php echo $engine->_t('BbAdvancedHint');?></small></p>

		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>

			<!-- ====================================================== -->
			<!-- CORE (strict, offsite_forms, block_page)				-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvCore');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_strict"><strong><?php echo $engine->_t('BbStrict');?></strong><br>
					<small><?php echo $engine->_t('BbStrictInfo');?></small></label>
				</td>
				<td><input type="checkbox" id="bb_strict" name="strict" value="1"<?php echo (!empty($settings['strict']) ? ' checked' : '');?>></td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_offsite_forms"><strong><?php echo $engine->_t('BbOffsiteForms');?></strong><br>
					<small><?php echo $engine->_t('BbOffsiteFormsInfo');?></small></label>
				</td>
				<td><input type="checkbox" id="bb_offsite_forms" name="offsite_forms" value="1"<?php echo (!empty($settings['offsite_forms']) ? ' checked' : '');?>></td>
			</tr>

			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvBlockPage');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_show_detailed"><strong><?php echo $engine->_t('BbShowDetailedBlockPage');?></strong><br>
					<small><?php echo $engine->_t('BbShowDetailedBlockPageInfo');?></small></label>
				</td>
				<td><input type="checkbox" id="bb_show_detailed" name="show_detailed_block_page" value="1"<?php echo (!empty($settings['show_detailed_block_page']) ? ' checked' : '');?>></td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_show_contact"><strong><?php echo $engine->_t('BbShowContactInfo');?></strong><br>
					<small><?php echo $engine->_t('BbShowContactInfoInfo');?></small></label>
				</td>
				<td><input type="checkbox" id="bb_show_contact" name="show_contact_info" value="1"<?php echo (!empty($settings['show_contact_info']) ? ' checked' : '');?>></td>
			</tr>

			<!-- ====================================================== -->
			<!-- BEHAVIORAL ANALYSIS									 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbBehavioral');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_enable_behavioral"><strong><?php echo $engine->_t('BbEnableBehavioral');?></strong><br>
					<small><?php echo $engine->_t('BbEnableBehavioralInfo');?></small></label>
			   </td>
				<td>
					<input type="checkbox" id="bb_enable_behavioral"
						   name="enable_behavioral_analysis" value="1"
						<?php echo (!empty($settings['enable_behavioral_analysis']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_inspect_json"><strong><?php echo $engine->_t('BbInspectJson');?></strong><br>
					<small><?php echo $engine->_t('BbInspectJsonInfo');?></small></label>
			   </td>
				<td>
					<input type="checkbox" id="bb_inspect_json"
						   name="inspect_json_body" value="1"
						<?php echo (!empty($settings['inspect_json_body']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_inspect_multipart"><strong><?php echo $engine->_t('BbInspectMultipart');?></strong><br>
					<small><?php echo $engine->_t('BbInspectMultipartInfo');?></small></label>
			   </td>
				<td>
					<input type="checkbox" id="bb_inspect_multipart"
						   name="inspect_multipart_body" value="1"
						<?php echo (!empty($settings['inspect_multipart_body']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_enable_client_hints"><strong><?php echo $engine->_t('BbEnableClientHints');?></strong><br>
					<small><?php echo $engine->_t('BbEnableClientHintsInfo');?></small></label>
			   </td>
				<td>
					<input type="checkbox" id="bb_enable_client_hints"
						   name="enable_client_hints_validation" value="1"
						<?php echo (!empty($settings['enable_client_hints_validation']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_enable_agentic"><strong><?php echo $engine->_t('BbEnableAgentic');?></strong><br>
					<small><?php echo $engine->_t('BbEnableAgenticInfo');?></small></label>
			   </td>
				<td>
					<input type="checkbox" id="bb_enable_agentic"
						   name="enable_agentic_detection" value="1"
						<?php echo (!empty($settings['enable_agentic_detection']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_strict_search_engines"><strong><?php echo $engine->_t('BbStrictSearchEngines');?></strong><br>
					<small><?php echo $engine->_t('BbStrictSearchEnginesInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_strict_search_engines"
						   name="strict_search_engines" value="1"
						<?php echo (!empty($settings['strict_search_engines']) ? ' checked' : '');?>>
			   </td>
		   </tr>

			<!-- ====================================================== -->
			<!-- LOG RETENTION (automatic cleanup of old log entries)	-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvLogRetention');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_enabled"><strong><?php echo $engine->_t('BbLogRetentionEnabled');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionEnabledInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_log_retention_enabled" name="log_retention_enabled" value="1"
						<?php echo (!empty($settings['log_retention']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_max_age_days"><strong><?php echo $engine->_t('BbLogRetentionMaxAgeDays');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionMaxAgeDaysInfo');?></small></label>
				</td>
				<td>
					<input type="number" size="5" min="1" max="3650" step="1"
						   id="bb_log_retention_max_age_days" name="log_retention_max_age_days"
						   value="<?php echo intval($settings['log_retention']['max_age_days'] ?? 7); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_max_rows"><strong><?php echo $engine->_t('BbLogRetentionMaxRows');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionMaxRowsInfo');?></small></label>
				</td>
				<td>
					<input type="number" size="10" min="0" step="1000"
						   id="bb_log_retention_max_rows" name="log_retention_max_rows"
						   value="<?php echo intval($settings['log_retention']['max_rows'] ?? 0); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_probability"><strong><?php echo $engine->_t('BbLogRetentionProbability');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionProbabilityInfo');?></small></label>
				</td>
				<td>
					<input type="number" size="8" min="0" step="100"
						   id="bb_log_retention_probability" name="log_retention_probability_denominator"
						   value="<?php echo intval($settings['log_retention']['probability_denominator'] ?? 1000); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_min_interval"><strong><?php echo $engine->_t('BbLogRetentionMinInterval');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionMinIntervalInfo');?></small></label>
				</td>
				<td>
					<input type="number" size="8" min="0" step="60"
						   id="bb_log_retention_min_interval" name="log_retention_min_interval_seconds"
						   value="<?php echo intval($settings['log_retention']['min_interval_seconds'] ?? 21600); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_log_retention_lock_ttl"><strong><?php echo $engine->_t('BbLogRetentionLockTtl');?></strong><br>
					<small><?php echo $engine->_t('BbLogRetentionLockTtlInfo');?></small></label>
				</td>
				<td>
					<input type="number" size="8" min="0" step="60"
						   id="bb_log_retention_lock_ttl" name="log_retention_lock_ttl"
						   value="<?php echo intval($settings['log_retention']['lock_ttl'] ?? 600); ?>">
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- REVERSE PROXY										   -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvReverseProxy');?></th></tr>

			<tr class="hl-setting">
				<td colspan="2">
					<small><?php echo Ut::perc_replace(
						$engine->_t('BbReverseProxyInfo'),
						'<code><a href="https://en.wikipedia.org/wiki/X-Forwarded-For" rel="noreferrer">X-Forwarded-For</a></code>',
						'<code>X-Real-Ip</code> (nginx)',
						'<code>Cf-Connecting-Ip</code> (CloudFlare)'
					);?></small>
				</td>
			</tr>

		<tr class="hl-setting">
			<td class="label">
				<label for="bb_behind_proxy"><strong><?php echo $engine->_t('BbBehindProxy');?></strong><br>
				<small><?php echo $engine->_t('BbBehindProxyInfo');?></small></label>
			</td>
			<td>
				<input type="checkbox" id="bb_behind_proxy" name="behind_proxy" value="1"<?php echo ($behind_proxy ? ' checked' : ''); ?>>
			</td>
		</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_reverse_proxy_header"><?php echo $engine->_t('BbReverseProxyHeader');?></label>
				</td>
				<td>
					<input type="text" size="32" id="bb_reverse_proxy_header" name="reverse_proxy_header"
						   value="<?php echo Ut::html($settings['reverse_proxy']['header'] ?? 'X-Forwarded-For'); ?>"
						   <?php echo (!$behind_proxy ? 'disabled' : ''); ?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_reverse_proxy_addresses"><?php echo $engine->_t('BbReverseProxyAddresses');?></label>
				</td>
				<td>
					<textarea cols="30" rows="6" id="bb_reverse_proxy_addresses" name="reverse_proxy_addresses"
							  <?php echo (!$behind_proxy ? 'disabled' : ''); ?>><?php
						echo Ut::html(implode("\n", $settings['reverse_proxy']['addresses'] ?? []));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- BOT CATEGORIES (4 multi-checkbox groups)				-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvBotCategories');?></th></tr>

			<?php
			// Categories in display order. The 4 list keys map to the
			// bb_config.php nested structure.
			$category_labels = [
				'search_engine'		=> $engine->_t('BbCatSearchEngine'),
				'ai_crawler'		   => $engine->_t('BbCatAiCrawler'),
				'social_crawler'	   => $engine->_t('BbCatSocialCrawler'),
				'seo_crawler'		  => $engine->_t('BbCatSeoCrawler'),
				'archive_crawler'	  => $engine->_t('BbCatArchiveCrawler'),
				'monitoring'		   => $engine->_t('BbCatMonitoring'),
				'feed_reader'		  => $engine->_t('BbCatFeedReader'),
				'shopping_crawler'	 => $engine->_t('BbCatShoppingCrawler'),
				'cloud_infrastructure' => $engine->_t('BbCatCloudInfra'),
				'security_scanner'	 => $engine->_t('BbCatSecurityScanner'),
				'residential_proxy'	=> $engine->_t('BbCatResidentialProxy'),
				'malicious'			=> $engine->_t('BbCatMalicious'),
				'unknown'			  => $engine->_t('BbCatUnknown'),
			];
			$list_titles = [
				'blocked'   => $engine->_t('BbListBlocked'),
				'challenge' => $engine->_t('BbListChallenge'),
				'log_only'  => $engine->_t('BbListLogOnly'),
				'allowed'   => $engine->_t('BbListAllowed'),
			];
			foreach ($list_titles as $list_key => $list_title):
				$current = (array)($settings['bot_categories'][$list_key] ?? []);
				?>
				<tr class="hl-setting">
					<td class="label">
						<strong><?php echo Ut::html($list_title); ?></strong><br>
						<small><?php echo $engine->_t('BbListHint');?></small>
					</td>
					<td>
						<?php foreach ($category_labels as $cat_value => $cat_label): ?>
							<label style="display:block; margin: 2px 0;">
								<input type="checkbox"
									   name="bot_category_<?php echo $list_key; ?>[]"
									   value="<?php echo Ut::html($cat_value); ?>"
									   <?php echo (in_array($cat_value, $current, true) ? 'checked' : ''); ?>>
								<?php echo Ut::html($cat_label); ?>
							</label>
						<?php endforeach; ?>
					</td>
				</tr>
			<?php endforeach; ?>

			<!-- ====================================================== -->
			<!-- AI CRAWLERS											 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvAiCrawlers');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_block_unverified_ai"><strong><?php echo $engine->_t('BbBlockUnverifiedAi');?></strong><br>
					<small><?php echo $engine->_t('BbBlockUnverifiedAiInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_block_unverified_ai" name="block_unverified_ai" value="1"
						<?php echo (!empty($settings['ai_crawlers']['block_unverified']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_strict_ai"><strong><?php echo $engine->_t('BbStrictAi');?></strong><br>
					<small><?php echo $engine->_t('BbStrictAiInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_strict_ai" name="strict_ai" value="1"
						<?php echo (!empty($settings['ai_crawlers']['strict']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_allowed_ai"><strong><?php echo $engine->_t('BbAllowedAiCrawlers');?></strong><br>
					<small><?php echo $engine->_t('BbAllowedAiCrawlersInfo');?></small></label>
				</td>
				<td>
					<textarea cols="50" rows="4" id="bb_allowed_ai" name="allowed_ai_crawlers"><?php
						echo Ut::html(implode("\n", $settings['ai_crawlers']['allowed'] ?? []));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- DNS VERIFICATION (NEW UI — never existed before)		-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvDnsVerification');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dns_verification_enabled"><strong><?php echo $engine->_t('BbDnsVerificationEnabled');?></strong><br>
					<small><?php echo $engine->_t('BbDnsVerificationInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_dns_verification_enabled" name="dns_verification_enabled" value="1"
						<?php echo (!empty($settings['dns_verification']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dns_verification_timeout"><?php echo $engine->_t('BbDnsTimeoutMs');?></label>
				</td>
				<td>
					<input type="number" size="5" min="50" max="2000" step="10"
						   id="bb_dns_verification_timeout" name="dns_verification_timeout_ms"
						   value="<?php echo intval($settings['dns_verification']['timeout_ms'] ?? 300); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dns_verification_positive_ttl"><?php echo $engine->_t('BbDnsPositiveTtl');?></label>
				</td>
				<td>
					<input type="number" size="8" min="3600" step="3600"
						   id="bb_dns_verification_positive_ttl" name="dns_verification_positive_ttl"
						   value="<?php echo intval($settings['dns_verification']['positive_ttl'] ?? 604800); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dns_verification_negative_ttl"><?php echo $engine->_t('BbDnsNegativeTtl');?></label>
				</td>
				<td>
					<input type="number" size="8" min="60" step="60"
						   id="bb_dns_verification_negative_ttl" name="dns_verification_negative_ttl"
						   value="<?php echo intval($settings['dns_verification']['negative_ttl'] ?? 3600); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dns_verification_require_forward"><?php echo $engine->_t('BbDnsRequireForward');?><br>
					<small><?php echo $engine->_t('BbDnsRequireForwardInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_dns_verification_require_forward"
						   name="dns_verification_require_forward_confirm" value="1"
						<?php echo (!empty($settings['dns_verification']['require_forward_confirm']) ? ' checked' : '');?>>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- RATE LIMITS											 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvRateLimits');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_rate_limit_enabled"><strong><?php echo $engine->_t('BbRateLimitEnabled');?></strong></label>
				</td>
				<td>
					<input type="checkbox" id="bb_rate_limit_enabled" name="rate_limit_enabled" value="1"
						<?php echo (!empty($settings['rate_limits']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>
<?php
			// Format: [POST label keys, defaults]
			$rate_buckets = [
				'global'	 => [
					'req_label' => 'BbRateGlobalRequests',
					'win_label' => 'BbRateGlobalWindow',
					'req_def'   => 1000,
					'win_def'   => 3600,
				],
				'per_minute' => [
					'req_label' => 'BbRatePerMinuteRequests',
					'win_label' => 'BbRatePerMinuteWindow',
					'req_def'   => 60,
					'win_def'   => 60,
				],
				'post'	   => [
					'req_label' => 'BbRatePostRequests',
					'win_label' => 'BbRatePostWindow',
					'req_def'   => 30,
					'win_def'   => 3600,
				],
				'login'	  => [
					'req_label' => 'BbRateLoginRequests',
					'win_label' => 'BbRateLoginWindow',
					'req_def'   => 10,
					'win_def'   => 900,
				],
			];

			foreach ($rate_buckets as $bucket => $cfg):
				$req_label = $cfg['req_label'];
				$win_label = $cfg['win_label'];
				$req_def   = $cfg['req_def'];
				$win_def   = $cfg['win_def'];

				// Defensive read: if $settings['rate_limits'][$bucket] is missing
				// or sparse, fall back to the hard-coded default.
				$req_val = $settings['rate_limits'][$bucket]['requests'] ?? $req_def;
				$win_val = $settings['rate_limits'][$bucket]['window']   ?? $win_def;
			?>
				<tr class="hl-setting">
					<td class="label">
						<label for="bb_rate_<?= $bucket ?>_requests"><?= $engine->_t($req_label) ?></label>
					</td>
					<td>
						<input type="number" size="6" min="1"
							   id="bb_rate_<?= $bucket ?>_requests"
							   name="rate_<?= $bucket ?>_requests"
							   value="<?= (int)$req_val ?>">
					</td>
				</tr>
				<tr class="hl-setting">
					<td class="label">
						<label for="bb_rate_<?= $bucket ?>_window"><?= $engine->_t($win_label) ?></label>
					</td>
					<td>
						<input type="number" size="6" min="1"
							   id="bb_rate_<?= $bucket ?>_window"
							   name="rate_<?= $bucket ?>_window"
							   value="<?= (int)$win_val ?>">
					</td>
				</tr>
			<?php endforeach; ?>

			<!-- ====================================================== -->
			<!-- HEAD REQUEST DETECTION								  -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvHeadDetection');?></th></tr>

			<tr class="hl-setting">
				<td class="label"><strong><?php echo $engine->_t('BbEnableHeadRequest');?></strong></td>
				<td>
					<input type="checkbox" name="enable_head_request_detection" value="1"
						<?php echo (!empty($settings['enable_head_request_detection']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><strong><?php echo $engine->_t('BbHeadRequireReferer');?></strong></td>
				<td>
					<input type="checkbox" name="head_require_referer" value="1"
						<?php echo (!empty($settings['head_require_referer']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label><?php echo $engine->_t('BbHeadFloodThreshold');?></label></td>
				<td>
					<input type="number" size="4" min="1" name="head_flood_threshold"
						   value="<?php echo intval($settings['head_flood_threshold'] ?? 20); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label><?php echo $engine->_t('BbHeadProbeThreshold');?></label></td>
				<td>
					<input type="number" size="4" min="1" name="head_probe_threshold"
						   value="<?php echo intval($settings['head_probe_threshold'] ?? 50); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label><?php echo $engine->_t('BbHeadRefererExemptPaths');?></label><br>
					<small><?php echo $engine->_t('BbHeadRefererExemptInfo');?></small>
				</td>
				<td>
					<textarea cols="50" rows="3" name="head_referer_exempt_paths"><?php
						echo Ut::html(implode("\n", $settings['head_referer_exempt_paths'] ?? ['/api/', '/wp-json/', '/health', '/status']));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- ASSET SCRAPING										  -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvAssetScraping');?></th></tr>

			<tr class="hl-setting">
				<td class="label"><strong><?php echo $engine->_t('BbEnableAssetScraping');?></strong></td>
				<td>
					<input type="checkbox" name="enable_asset_scraping_detection" value="1"
						<?php echo (!empty($settings['enable_asset_scraping_detection']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label><?php echo $engine->_t('BbAssetExtensionsLabel');?><br>
					<small><?php echo $engine->_t('BbAssetExtensionsInfo');?></small></label>
				</td>
				<td>
					<textarea cols="40" rows="4" name="asset_extensions"><?php
						echo Ut::html(implode("\n", $settings['asset_extensions'] ?? [
							'png', 'jpg', 'jpeg', 'gif', 'webp', 'avif', 'svg',
							'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
							'mp3', 'mp4', 'wav', 'ogg', 'webm',
						]));
					?></textarea>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label><?php echo $engine->_t('BbAssetNoRefererThreshold');?></label></td>
				<td>
					<input type="number" size="4" min="1" name="asset_no_referer_threshold"
						   value="<?php echo intval($settings['asset_no_referer_threshold'] ?? 10); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label><?php echo $engine->_t('BbAssetOnlySessionThreshold');?></label></td>
				<td>
					<input type="number" size="4" min="1" name="asset_only_session_threshold"
						   value="<?php echo intval($settings['asset_only_session_threshold'] ?? 20); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label><?php echo $engine->_t('BbAssetPatternThreshold');?></label></td>
				<td>
					<input type="number" size="4" min="1" name="asset_pattern_threshold"
						   value="<?php echo intval($settings['asset_pattern_threshold'] ?? 100); ?>">
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- DYNAMIC IP RANGES									   -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvDynamicIp');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_enable_dynamic_ip"><strong><?php echo $engine->_t('BbEnableDynamicIpRanges');?></strong><br>
					<small><?php echo $engine->_t('BbEnableDynamicIpInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_enable_dynamic_ip" name="enable_dynamic_ip_ranges" value="1"
						<?php echo (!empty($settings['dynamic_ip_ranges']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_dynamic_ip_ttl"><?php echo $engine->_t('BbDynamicIpTtl');?></label></td>
				<td>
					<input type="number" size="8" min="3600" step="3600"
						   id="bb_dynamic_ip_ttl" name="dynamic_ip_ranges_ttl"
						   value="<?php echo intval($settings['dynamic_ip_ranges']['ttl'] ?? 86400); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dynamic_ip_feeds"><?php echo $engine->_t('BbDynamicIpFeeds');?></label>
				</td>
				<td>
					<textarea cols="30" rows="4" id="bb_dynamic_ip_feeds" name="dynamic_ip_ranges_feeds"><?php
						echo Ut::html(implode("\n", $settings['dynamic_ip_ranges']['feeds'] ?? ['aws', 'cloudflare', 'fastly', 'gcp']));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- ON-DEMAND IP REFRESH (NEW UI)						   -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvOnDemandRefresh');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_on_demand_enabled"><strong><?php echo $engine->_t('BbEnableOnDemandRefresh');?></strong><br>
					<small><?php echo $engine->_t('BbOnDemandRefreshInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_on_demand_enabled" name="on_demand_ip_refresh_enabled" value="1"
						<?php echo (!empty($settings['on_demand_ip_refresh']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label><?php echo $engine->_t('BbCloudProvidersInfo');?></label>
				</td>
				<td>
					<?php
					$checked_providers = (array)($settings['on_demand_ip_refresh']['cloud_providers'] ?? []);
					// Default is empty array = "all four" — so we show none checked by default
					foreach (['aws' => 'BbCloudProviderAws', 'cloudflare' => 'BbCloudProviderCloudflare',
							  'fastly' => 'BbCloudProviderFastly', 'gcp' => 'BbCloudProviderGcp'] as $prov => $label_key): ?>
						<label style="display:inline-block; margin-right: 12px;">
							<input type="checkbox" name="on_demand_ip_refresh_cloud_providers[]"
								   value="<?php echo $prov; ?>"
								   <?php echo (in_array($prov, $checked_providers, true) ? ' checked' : ''); ?>>
							<?php echo $engine->_t($label_key); ?>
						</label>
					<?php endforeach; ?>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label><?php echo $engine->_t('BbOnDemandBotIds');?><br>
					<small><?php echo $engine->_t('BbOnDemandBotIdsInfo');?></small></label>
				</td>
				<td>
					<textarea cols="40" rows="3" name="on_demand_ip_refresh_bot_ids" placeholder="<?php echo Ut::html($engine->_t('BbOnDemandBotIdsPlaceholder')); ?>"><?php
						echo Ut::html(implode("\n", (array)($settings['on_demand_ip_refresh']['bot_ids'] ?? [])));
					?></textarea>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_on_demand_probability"><?php echo $engine->_t('BbOnDemandProbability');?></label></td>
				<td>
					<input type="number" size="8" min="1"
						   id="bb_on_demand_probability" name="on_demand_ip_refresh_probability_denominator"
						   value="<?php echo intval($settings['on_demand_ip_refresh']['probability_denominator'] ?? 1000); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_on_demand_min_age"><?php echo $engine->_t('BbOnDemandMinAge');?></label></td>
				<td>
					<input type="number" size="8" min="0" step="60"
						   id="bb_on_demand_min_age" name="on_demand_ip_refresh_min_age_seconds"
						   value="<?php echo intval($settings['on_demand_ip_refresh']['min_age_seconds'] ?? 21600); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_on_demand_lock_ttl"><?php echo $engine->_t('BbOnDemandLockTtl');?></label></td>
				<td>
					<input type="number" size="8" min="0" step="60"
						   id="bb_on_demand_lock_ttl" name="on_demand_ip_refresh_lock_ttl"
						   value="<?php echo intval($settings['on_demand_ip_refresh']['lock_ttl'] ?? 600); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_on_demand_cache_ttl"><?php echo $engine->_t('BbOnDemandCacheTtl');?></label></td>
				<td>
					<input type="number" size="8" min="3600" step="3600"
						   id="bb_on_demand_cache_ttl" name="on_demand_ip_refresh_cache_ttl"
						   value="<?php echo intval($settings['on_demand_ip_refresh']['cache_ttl'] ?? 604800); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_on_demand_feed_timeout"><?php echo $engine->_t('BbOnDemandFeedTimeout');?></label></td>
				<td>
					<input type="number" size="4" min="0.1" step="0.1"
						   id="bb_on_demand_feed_timeout" name="on_demand_ip_refresh_feed_timeout_seconds"
						   value="<?php echo Ut::html($settings['on_demand_ip_refresh']['feed_timeout_seconds'] ?? 5); ?>">
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- HTTP:BL												 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvHttpbl');?></th></tr>

			<tr class="hl-setting">
				<td colspan="2">
					<p><?php echo Ut::perc_replace($engine->_t('BbHttpblInfo'), '<a href="https://www.projecthoneypot.org/faq.php" rel="noreferrer">http:BL Access Key</a>');?></p>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_httpbl_key"><?php echo $engine->_t('BbHttpblKey');?></label></td>
				<td>
					<input type="text" size="12" maxlength="12" id="bb_httpbl_key" name="httpbl_key"
						   value="<?php echo Ut::html($settings['httpbl']['key'] ?? ''); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_httpbl_threat"><?php echo $engine->_t('BbHttpblThreat');?></label></td>
				<td>
					<input type="number" size="3" min="0" max="255"
						   id="bb_httpbl_threat" name="httpbl_threat"
						   value="<?php echo intval($settings['httpbl']['threat'] ?? 25); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_httpbl_maxage"><?php echo $engine->_t('BbHttpblMaxage');?></label></td>
				<td>
					<input type="number" size="3" min="0"
						   id="bb_httpbl_maxage" name="httpbl_maxage"
						   value="<?php echo intval($settings['httpbl']['maxage'] ?? 30); ?>">
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- DNSBL												   -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvDnsbl');?></th></tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_dnsbl_enabled"><strong><?php echo $engine->_t('BbDnsblEnabled');?></strong></label></td>
				<td>
					<input type="checkbox" id="bb_dnsbl_enabled" name="dnsbl_enabled" value="1"
						<?php echo (!empty($settings['dnsbl']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_dnsbl_lists"><strong><?php echo $engine->_t('BbDnsblLists');?></strong><br>
					<small><?php echo $engine->_t('BbDnsblListsInfo');?></small></label>
				</td>
				<td>
					<textarea cols="50" rows="4" id="bb_dnsbl_lists" name="dnsbl_lists"><?php
						echo Ut::html(implode("\n", $settings['dnsbl']['lists'] ?? []));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- CHALLENGE / CAPTCHA									 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvChallenge');?></th></tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_challenge_enabled"><strong><?php echo $engine->_t('BbChallengeEnabled');?></strong></label></td>
				<td>
					<input type="checkbox" id="bb_challenge_enabled" name="challenge_enabled" value="1"
						<?php echo (!empty($settings['challenge']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_challenge_provider"><?php echo $engine->_t('BbChallengeProvider');?></label></td>
				<td>
					<select id="bb_challenge_provider" name="challenge_provider">
						<?php foreach ([
							'builtin'   => $engine->_t('BbChallengeProviderBuiltin'),
							'hcaptcha'  => $engine->_t('BbChallengeProviderHcaptcha'),
							'recaptcha' => $engine->_t('BbChallengeProviderRecaptcha'),
							'turnstile' => $engine->_t('BbChallengeProviderTurnstile'),
						] as $val => $label): ?>
							<option value="<?php echo $val; ?>"<?php echo (($settings['challenge']['provider'] ?? 'builtin') === $val ? ' selected' : '');?>>
								<?php echo $label; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_challenge_site_key"><?php echo $engine->_t('BbChallengeSiteKey');?></label></td>
				<td>
					<input type="text" size="40" id="bb_challenge_site_key" name="challenge_site_key"
						   value="<?php echo Ut::html($settings['challenge']['site_key'] ?? ''); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_challenge_secret_key"><?php echo $engine->_t('BbChallengeSecretKey');?></label></td>
				<td>
					<input type="text" size="40" id="bb_challenge_secret_key" name="challenge_secret_key"
						   value="<?php echo Ut::html($settings['challenge']['secret_key'] ?? ''); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_recaptcha_min_score"><?php echo $engine->_t('BbRecaptchaMinScore');?></label></td>
				<td>
					<input type="number" size="4" min="0" max="1" step="0.1"
						   id="bb_recaptcha_min_score" name="recaptcha_min_score"
						   value="<?php echo Ut::html($settings['challenge']['recaptcha_min_score'] ?? 0.5); ?>">
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- PERFORMANCE											 -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvPerformance');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_skip_extensions"><strong><?php echo $engine->_t('BbSkipExtensions');?></strong></label>
				</td>
				<td>
					<textarea cols="50" rows="3" id="bb_skip_extensions" name="skip_static_extensions"><?php
						echo Ut::html(implode("\n", $settings['performance']['skip_extensions'] ?? []));
					?></textarea>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_skip_paths"><strong><?php echo $engine->_t('BbSkipPaths');?></strong></label>
				</td>
				<td>
					<textarea cols="50" rows="3" id="bb_skip_paths" name="skip_static_paths"><?php
						echo Ut::html(implode("\n", $settings['performance']['skip_paths'] ?? []));
					?></textarea>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_body_scan_skip"><strong><?php echo $engine->_t('BbBodyScanSkipFields');?></strong><br>
					<small><?php echo $engine->_t('BbBodyScanSkipFieldsInfo');?></small></label>
				</td>
				<td>
					<textarea cols="60" rows="4" id="bb_body_scan_skip" name="body_scan_skip_fields"><?php
						echo Ut::html(implode("\n", $settings['body_scan_skip_fields'] ?? []));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- GEOIP												   -->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvGeoip');?></th></tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_geoip_enabled"><strong><?php echo $engine->_t('BbGeoipEnabled');?></strong></label></td>
				<td>
					<input type="checkbox" id="bb_geoip_enabled" name="geoip_enabled" value="1"
						<?php echo (!empty($settings['geoip']['enabled']) ? ' checked' : '');?>>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_geoip_path"><?php echo $engine->_t('BbGeoipDbPath');?></label></td>
				<td>
					<input type="text" size="60" id="bb_geoip_path" name="geoip_database_path"
						   value="<?php echo Ut::html($settings['geoip']['database_path'] ?? ''); ?>">
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_blocked_countries"><?php echo $engine->_t('BbBlockedCountries');?></label></td>
				<td>
					<textarea cols="30" rows="3" id="bb_blocked_countries" name="blocked_countries"><?php
						echo Ut::html(implode("\n", $settings['geoip']['blocked_countries'] ?? []));
					?></textarea>
				</td>
			</tr>

			<tr class="hl-setting">
				<td class="label"><label for="bb_blocked_asns"><?php echo $engine->_t('BbBlockedAsns');?></label></td>
				<td>
					<textarea cols="30" rows="3" id="bb_blocked_asns" name="blocked_asns"><?php
						echo Ut::html(implode("\n", $settings['geoip']['blocked_asns'] ?? []));
					?></textarea>
				</td>
			</tr>

			<!-- ====================================================== -->
			<!-- FINGERPRINTS											-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvFingerprints');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_enable_fingerprinting"><strong><?php echo $engine->_t('BbEnableFingerprinting');?></strong><br>
					<small><?php echo $engine->_t('BbEnableFingerprintingInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="bb_enable_fingerprinting" name="enable_fingerprinting" value="1"
						<?php echo (!empty($settings['enable_fingerprinting']) ? ' checked' : '');?>>
				</td>
			</tr>

			<?php foreach ([
				'bad_ja3'		   => ['key' => 'BbFpBadJa3',		  'post' => 'bad_ja3_fingerprints'],
				'bad_h2'			=> ['key' => 'BbFpBadH2',		   'post' => 'bad_h2_fingerprints'],
				'bot_header_orders' => ['key' => 'BbFpBotHeaderOrders', 'post' => 'bot_header_orders'],
				'expected_ja3'	  => ['key' => 'BbFpExpectedJa3',	 'post' => 'expected_ja3'],
			] as $def_key => $fp): ?>
				<tr class="hl-setting">
					<td class="label">
						<label><?php echo $engine->_t($fp['key']); ?></label>
					</td>
					<td>
						<textarea cols="50" rows="3" name="<?php echo $fp['post']; ?>"><?php
							echo Ut::html(implode("\n", $settings['fingerprints'][$def_key] ?? []));
						?></textarea>
					</td>
				</tr>
			<?php endforeach; ?>

			<!-- ====================================================== -->
			<!-- CUSTOM RULES											-->
			<!-- ====================================================== -->
			<tr><th colspan="2"><br><?php echo $engine->_t('BbAdvCustomRules');?></th></tr>

			<tr class="hl-setting">
				<td class="label">
					<label for="bb_custom_rules"><strong><?php echo $engine->_t('BbCustomRulesLabel');?></strong><br>
					<small><?php echo $engine->_t('BbCustomRulesInfo');?></small></label>
				</td>
				<td>
					<textarea cols="60" rows="8" id="bb_custom_rules" name="custom_rules"
							  placeholder='{"type":"ua_regex","value":"/Googlebot/i","action":"log","id":"audit_googlebot"}'><?php
						$rendered = [];
						foreach (($settings['custom_rules'] ?? []) as $rule)
						{
							$rendered[] = json_encode($rule, JSON_UNESCAPED_SLASHES);
						}
						echo Ut::html(implode("\n", $rendered));
					?></textarea>
				</td>
			</tr>
		</table>
	</details>

	<br>
	<div class="center">
		<button type="submit" class="button" name="submit"><?php echo $engine->_t('UpdateButton');?></button>
	</div>
	<?php
	echo $engine->form_close();
	?>
	</div>
	<?php
}

	// ============================================================
	// DISPATCHERS — POST handlers (must run BEFORE the page renders)
	// ============================================================

	// Bulk-action form: its _action field is the FORM NAME (bb_bulk), not the
	// action to run. The clicked button's name="submit_action" carries the real
	// action. Check it FIRST so we override the (non-)action stored in _action.
	//
	// Without this, the bulk buttons silently no-op because:
	//   - $action becomes 'bb_bulk' (from form_open()'s _action hidden field)
	//   - none of the `if ($action == 'bb_bulk_*')` branches match
	//   - the dispatcher falls through, the redirect-to-back happens, nothing changes
	if (isset($_POST['submit_action']) && is_string($_POST['submit_action']))
	{
		$action = $_POST['submit_action'];
	}

	if ($action == 'bb_options')
	{
		$save = bb_save_settings($engine);
		if ($save['success'])
		{
			$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
			$engine->set_message($engine->_t('BbSettingsUpdated'));
			$engine->http->redirect($engine->href('', '', [
				'setting' => 'bb_options',
				'mode'	=> 'tool_badbehaviour',
			]));
		}
		else
		{
			$engine->log(3, '!!' . $engine->_t('BbSettingsSaveFailed') . ': ' . $save['error'] . '!!');
			$engine->http->redirect($engine->href('', '', [
				'setting'	   => 'bb_options',
				'mode'		  => 'tool_badbehaviour',
				'bb_save_error' => base64_encode($save['error']),
			]));
		}
	}

	if ($action == 'bb_options_enable')
	{
		$config['ext_bad_behaviour'] = (int)($_POST['ext_bad_behaviour'] ?? 0);
		$engine->db->_set($config);
		$engine->log(1, '!!' . $engine->_t('BbSettingsUpdated') . '!!');
		$engine->set_message($engine->_t('BbSettingsUpdated'));
		$engine->http->redirect($engine->href('', '', [
			'setting' => 'bb_options',
			'mode'	=> 'tool_badbehaviour',
		]));
	}

	if ($action == 'purge_badbehaviour')
	{
		$sql = 'TRUNCATE ' . $engine->prefix . 'bad_behaviour';
		$engine->db->sql_query($sql);
		$engine->db->invalidate_sql_cache();
	}

	// Bulk delete
	if ($action == 'bb_bulk_delete')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		if ($adapter->delete_log_bulk($ids))
		{
			$engine->db->invalidate_sql_cache();
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkDeleted'), '<strong>' . count($ids) . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkFailed'));
		}

		$engine->http->redirect($back);
	}

	// Bulk whitelist
	if ($action == 'bb_bulk_whitelist')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		$added = $adapter->whitelist_ips_from_logs_bulk($ids);

		if ($added > 0)
		{
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkWhitelisted'), '<strong>' . $added . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkWhitelistedNone'));
		}

		$engine->http->redirect($back);
	}

	// Bulk resolve
	if ($action == 'bb_bulk_resolve')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		if ($adapter->set_log_resolved_bulk($ids, true))
		{
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkResolved'), '<strong>' . count($ids) . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkFailed'));
		}

		$engine->http->redirect($back);
	}

	// Bulk unresolve
	if ($action == 'bb_bulk_unresolve')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		if ($adapter->set_log_resolved_bulk($ids, false))
		{
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkUnresolved'), '<strong>' . count($ids) . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkFailed'));
		}

		$engine->http->redirect($back);
	}

	// Bulk check
	if ($action == 'bb_bulk_check')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		if ($adapter->set_log_check_bulk($ids, true))
		{
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkChecked'), '<strong>' . count($ids) . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkFailed'));
		}

		$engine->http->redirect($back);
	}

	// Bulk uncheck
	if ($action == 'bb_bulk_uncheck')
	{
		$ids = $_POST['submit'] ?? [];
		$back = $_POST['_back'] ?? $engine->href('', '', bb_clean_url_args($_GET) + ['setting' => 'bb_manage', 'mode' => 'tool_badbehaviour']);

		if (!is_array($ids) || empty($ids))
		{
			$engine->set_message($engine->_t('BbNoItemsSelected'));
			$engine->http->redirect($back);
		}

		$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
		if ($adapter->set_log_check_bulk($ids, false))
		{
			$engine->set_message(Ut::perc_replace($engine->_t('BbBulkUnchecked'), '<strong>' . count($ids) . '</strong>'));
		}
		else
		{
			$engine->set_message($engine->_t('BbBulkFailed'));
		}

		$engine->http->redirect($back);
	}

	// Single-row resolve / unresolve (clicked from per-row action)
	if ($action == 'bb_resolve' || $action == 'bb_unresolve')
	{
		$id = (int)($_GET['id'] ?? 0);

		if ($id > 0)
		{
			if ($action === 'bb_resolve')
			{
				$engine->db->sql_query(
					'UPDATE ' . $engine->prefix . 'bad_behaviour SET resolved_at = ' . $engine->db->q(gmdate('Y-m-d H:i:s'))
					. ' WHERE log_id = ' . $id
					);
				$engine->set_message($engine->_t('BbRowResolved'));
			}
			else
			{
				$engine->db->sql_query(
					'UPDATE ' . $engine->prefix . 'bad_behaviour SET resolved_at = NULL '
					. ' WHERE log_id = ' . $id
					);
				$engine->set_message($engine->_t('BbRowUnresolved'));
			}
		}

		// Build redirect target from cleaned $_GET — no REQUEST_URI regex hacking.
		// Drops reveal_*, _action, id, _back, _nonce, p>1 (uses default page 1)
		// automatically via the allowlist.
		$back = $engine->href('', '', bb_clean_url_args($_GET));
		$engine->http->redirect($back);
	}

	// Single-row check / uncheck
	if ($action == 'bb_check' || $action == 'bb_uncheck')
	{
		$id = (int)($_GET['id'] ?? 0);

		if ($id > 0)
		{
			$adapter = new \BadBehaviour\Adapter\WackoWikiAdapter($engine->db);
			$new_state = ($action === 'bb_check');
			$adapter->set_log_check($id, $new_state);
			$engine->set_message($new_state
				? $engine->_t('BbRowChecked')
				: $engine->_t('BbRowUnchecked'));
		}

		$back = $engine->href('', '', bb_clean_url_args($_GET));
		$engine->http->redirect($back);
	}

	#######################################################################################################


	?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<?php echo Ut::perc_replace($engine->_t('BbInfo'), '<a href="https://github.com/Bad-Behaviour/badbehaviour" rel="noreferrer">Bad Behaviour</a>');?>
	<br><br>
	<?php
	$mode_selector = 'setting';
	$mode = $_GET[$mode_selector] ?? '';

	$tabs = [
		''			  => 'BbSummary',
		'bb_manage'	=> 'BbLog',
		'bb_options'   => 'BbSettings',
		'bb_whitelist' => 'BbWhitelist',
	];

	if (!array_key_exists($mode, $tabs)) $mode = '';

	echo '<h2>' . $engine->_t($tabs[$mode]) . '</h2>';
	echo '<nav>' . $engine->tab_menu($tabs, $mode, '', [], $mode_selector) . '</nav><br>';

	if (!empty($engine->db->ext_bad_behaviour))
	{
		if (isset($_GET['setting']) && $_GET['setting'] == 'bb_options')		bb_options($engine);
		elseif (isset($_GET['setting']) && $_GET['setting'] == 'bb_whitelist')  bb_whitelist($engine);
		elseif (isset($_GET['setting']) && $_GET['setting'] == 'bb_manage')	 bb_manage($engine);
		else																	  bb_summary($engine);
	}
	else
	{
		// Disabled state — show only the master enable switch
		echo $engine->form_open('bb_options_enable', ['form_more' => 'setting=bb_options_enable']);
		?>
		<br>
		<table class="formation">
			<tbody>
				<tr class="hl-setting">
					<th scope="row" class="label">
						<strong><?php echo $engine->_t('BbEnable');?></strong><br>
						<small><?php echo Ut::perc_replace($engine->_t('BbEnableInfo'), '<code>bb_config.php</code>');?></small>
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
