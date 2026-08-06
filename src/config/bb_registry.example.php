<?php
/**
 * Bad Behaviour — Bot Registry Configuration (Example)
 *
 * Copy this file to config/bb_registry.php and customize.
 * If bb_registry.php doesn't exist, the full default registry is used.
 *
 * === SCHEMA ===
 *
 * ```php
 * return [
 *     'preset'             => 'minimal',                  // see below
 *     'exclude_categories' => ['seo_crawler'],            // optional
 *     'include_categories' => ['cloud_infrastructure'],   // optional (overrides exclude)
 *     'exclude_bots'       => ['petal'],                  // optional
 *     'additions'          => [                           // optional
 *         'my_bot' => [/* BotDefinition schema *\/],
 *     ],
 *     'bots'               => [/* ... *\/],               // only when preset='custom'
 * ];
 * ```
 *
 * === AVAILABLE PRESETS ===
 *
 *   - 'full'           — All ~100 shipped bots (default if file is absent)
 *   - 'minimal'        — ~30 most common bots (3x faster matching)
 *   - 'verified-only'  — Only bots with DNS verification or IP ranges
 *   - 'no-ai'          — Everything except AI crawlers
 *   - 'no-seo'         — Everything except SEO crawlers
 *   - 'eu-only'        — European search engines + EU-relevant bots
 *   - 'human-only'     — Empty registry (combine with additions)
 *   - 'custom'         — Use ONLY the bots defined in 'bots' below
 *
 * === FILTER EXECUTION ORDER ===
 *
 *   1. Load preset
 *   2. Apply exclude_categories
 *   3. Apply include_categories (overrides exclude)
 *   4. Apply exclude_bots
 *   5. Merge additions on top
 *
 * === CLOUD INFRASTRUCTURE SAFETY ===
 *
 * If you exclude a category that includes cloud_infrastructure, your CDN's
 * health probes will be blocked → origin marked unhealthy → you go offline.
 * ALWAYS add 'cloud_infrastructure' to include_categories as a safety net.
 */

return [
	// ===== PRESET =====
	//
	// Pick the starting set. Common choices:
	//   'minimal'    — high-traffic sites, want speed
	//   'full'       — small/medium sites, want coverage
	//   'no-ai'      — publishers blocking AI training crawlers
	//   'eu-only'    — GDPR-conscious, prefer EU search engines
	'preset' => 'minimal',

	// ===== CATEGORY FILTERS =====

	// Remove entire categories
	'exclude_categories' => [
		// 'seo_crawler',
		// 'shopping_crawler',
	],

	// Force-include (overrides exclude). CRITICAL for cloud_infrastructure.
	'include_categories' => [
		'cloud_infrastructure',
	],

	// Remove specific bots by ID
	'exclude_bots' => [
		// 'petal',  // Exclude specific bots that you don't want
	],

	// ===== CUSTOM BOTS =====
	//
	// Added on top of the preset selection.
	// Useful for internal monitoring, niche crawlers, etc.

	'additions' => [
		// 'internal_uptime_monitor' => [
		//     'name' => 'Internal Uptime Monitor',
		//     'user_agent_patterns' => ['InternalMonitor/1.0'],
		//     'host_patterns' => ['monitor.internal'],
		//     'ip_ranges' => ['10.0.0.0/8'],
		//     'verify_dns' => true,
		//     'dns_suffixes' => ['monitor.internal'],
		//     'category' => 'monitoring',
		//     'robots_txt_token' => null,
		//     'default_action' => 'allow',
		//     'description' => 'Our internal uptime checker',
		// ],
	],

	// ===== CUSTOM REGISTRY (only when preset = 'custom') =====
	//
	// Define the complete bot set here. The 'additions' key is ignored
	// when preset='custom'.
	//
	// You MUST include cloud_infrastructure bots manually in custom mode.
	// Otherwise you'll block your CDN's health probes → downtime.

	// 'bots' => [
	//     'your_bot' => [
	//         'name' => 'Your Bot',
	//         'user_agent_patterns' => ['YourBot'],
	//         'host_patterns' => ['yourdomain.com'],
	//         'ip_ranges' => ['192.0.2.0/24'],
	//         'verify_dns' => true,
	//         'dns_suffixes' => ['example.com'],
	//         'category' => 'search_engine',
	//         'robots_txt_token' => 'YourBot',
	//         'default_action' => 'allow',
	//     ],
	// ],
];
