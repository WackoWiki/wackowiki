<?php
/*
Bad Behavior - detects and blocks unwanted Web accesses
Copyright (C) 2005,2006,2007,2008,2009,2010,2011,2012 Michael Hampton

Bad Behavior is free software; you can redistribute it and/or modify it under
the terms of the GNU Lesser General Public License as published by the Free
Software Foundation; either version 3 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along
with this program. If not, see <http://www.gnu.org/licenses/>.

Please report any problems to bad . bots AT ioerror DOT us
http://bad-behavior.ioerror.us/

WackoWiki implementation, 2015 WackoWiki Team
Version 0.2
http://wackowiki.sourceforge.net/doc/Dev/PatchesHacks/BadBehavior

*/

###############################################################################
###############################################################################

// This file is the entry point for Bad Behavior.
if (!defined('IN_WACKO'))
{
	die('I said no cheating!');
}

$bb2_mtime			= explode(' ', microtime());
$bb2_timer_start	= $bb2_mtime[1] + $bb2_mtime[0];

define('BB2_CWD', dirname(__FILE__));

// Settings you can adjust for Bad Behavior.
// Most of these are unused in non-database mode.
// DO NOT EDIT HERE; instead make changes in settings.ini.
// These settings are used when settings.ini is not present.
$bb2_settings_defaults = array(
	'log_table' => $init->config['table_prefix'] . 'bad_behavior',
	'display_stats' => false,
	'strict' => false,
	'verbose' => false,
	'logging' => true,
	'httpbl_key' => '',
	'httpbl_threat' => '25',
	'httpbl_maxage' => '30',
	'offsite_forms' => false,
	'eu_cookie' => false,
	'reverse_proxy' => false,
	'reverse_proxy_header' => 'X-Forwarded-For',
	'reverse_proxy_addresses' => array(),
);

// Bad Behavior callback functions.
// Our log table structure
function bb2_table_structure($name)
{
	// It's not paranoia if they really are out to get you.
	$name_escaped = bb2_db_escape($name);
	return "CREATE TABLE IF NOT EXISTS `$name_escaped` (
		`log_id` INT(11) NOT NULL auto_increment,
		`ip` VARCHAR(45) NOT NULL,
		`host` VARCHAR(2083) NOT NULL,
		`date` DATETIME NOT NULL default '0000-00-00 00:00:00',
		`request_method` VARCHAR(8) NOT NULL,
		`request_uri` VARCHAR(2083) NOT NULL,
		`server_protocol` VARCHAR(12) NOT NULL,
		`http_headers` TEXT NOT NULL,
		`user_agent` TEXT NOT NULL,
		`user_agent_hash` CHAR(40) NOT NULL,
		`request_entity` TEXT NOT NULL,
		`status_key` VARCHAR(10) NOT NULL,
		PRIMARY KEY (`log_id`),
		KEY `idx_staus_key` (`status_key`),
		KEY `idx_user_agent_hash` (`user_agent_hash`),
		KEY `idx_ip` (`ip`),
		KEY `idx_request_method` (`request_method`)
		);";	// TODO: INDEX might need tuning
}

// Insert a new record
function bb2_insert($settings, $package, $status_key)
{
	if (!$settings['logging']) return '';

	$ip					= bb2_db_escape($package['ip']);
	$host				= bb2_db_escape(@gethostbyaddr($package['ip']));
	$date				= bb2_db_date();
	$request_method		= bb2_db_escape($package['request_method']);
	$request_uri		= bb2_db_escape($package['request_uri']);
	$server_protocol	= bb2_db_escape($package['server_protocol']);
	$user_agent			= bb2_db_escape($package['user_agent']);
	$user_agent_hash	= hash('sha1', $user_agent);
	$headers			= "$request_method $request_uri $server_protocol\n";

	foreach ($package['headers'] as $h => $v) {
		$headers .= bb2_db_escape("$h: $v\n");
	}

	$request_entity = '';

	if (!strcasecmp($request_method, 'POST')) {
		foreach ($package['request_entity'] as $h => $v) {
			$request_entity .= bb2_db_escape("$h: $v\n");
		}
	}

	return "INSERT INTO `" . bb2_db_escape($settings['log_table']) . "`
		(`ip`, `host`, `date`, `request_method`, `request_uri`, `server_protocol`, `http_headers`, `user_agent`, `user_agent_hash`, `request_entity`, `status_key`) VALUES
		('$ip', '$host', '$date', '$request_method', '$request_uri', '$server_protocol', '$headers', '$user_agent', '$user_agent_hash', '$request_entity', '$status_key')";
}

// Return current time in the format preferred by your database.
function bb2_db_date() {
	return gmdate('Y-m-d H:i:s');	// Example is MySQL format
}

// Return affected rows from most recent query.
function bb2_db_affected_rows($result) {
	global $init;
	return affected_rows($init->dblink, $result);
}

// Escape a string for database usage
function bb2_db_escape($string) {
	global $init;
	return quote($init->dblink, $string);
#	return $string;	// No-op when database not in use.
}

// Return the number of rows in a particular query.
function bb2_db_num_rows($result) {
	if ($result !== FALSE)
		return count($result);
	return 0;
}

// Run a query and return the results, if any.
// Should return FALSE if an error occurred.
// Bad Behavior will use the return value here in other callbacks.
function bb2_db_query($query) {
	global $init;
	return sql_query($init->dblink, $query, 0);
}

// Return all rows in a particular query.
// Should contain an array of all rows generated by calling mysql_fetch_assoc()
// or equivalent and appending the result of each call to an array.
function bb2_db_rows($result) {
	$data = array();

	while ($row = fetch_assoc($result))
	{
		$data[] = $row;
	}

	free_result($result);
	return $data;
}

// Return emergency contact email address.
function bb2_email() {
	global $init;
	return $init->config['abuse_email'];	// You need to change this.
}

// retrieve whitelist
function bb2_read_whitelist() {
	return @parse_ini_file('config/bb_whitelist.conf'); // dirname(BB2_CORE) . 'whitelist.ini'
}

// retrieve settings from database
// Settings are hard-coded for non-database use
function bb2_read_settings() {
	global $bb2_settings_defaults;
	$settings = @parse_ini_file('config/bb_settings.conf'); // dirname(__FILE__) . 'settings.ini'
	if (!$settings) $settings = array();
	return @array_merge($bb2_settings_defaults, $settings);
}

// write settings to database
function bb2_write_settings($settings) {
	return false;
}

// installation
function bb2_install() {
	$settings = bb2_read_settings();
	if (defined('BB2_NO_CREATE')) return;
	if (!$settings['logging']) return;
	bb2_db_query(bb2_table_structure($settings['log_table']));
}

// Screener
// Insert this into the <head> section of your HTML through a template call
// or whatever is appropriate. This is optional we'll fall back to cookies
// if you don't use it.
function bb2_insert_head() {
	global $bb2_timer_total;
	global $bb2_javascript;
	echo "\n<!-- Bad Behavior " . BB2_VERSION . " run time: " . number_format(1000 * $bb2_timer_total, 3) . " ms -->\n";
	echo $bb2_javascript;
}

// Display stats? This is optional.
function bb2_insert_stats($force = false) {
	$settings = bb2_read_settings();

	if ($force || $settings['display_stats'])
	{
		$blocked = bb2_db_query("SELECT COUNT(log_id) as n FROM " . $settings['log_table'] . " WHERE `status_key` NOT LIKE '00000000'");
		$blocked = bb2_db_rows($blocked);

		if ($blocked !== FALSE)
		{
			echo sprintf('<p>%1$s %2$s <strong>%3$s</strong> %4$s</p>', 'Bad Behavior', 'has blocked', $blocked[0]['n'], 'access attempts in the last 7 days.');
		}
	}
}


// Return the top-level relative path of wherever we are (for cookies)
// You should provide in $url the top-level URL for your site.
function bb2_relative_path() {
	global $init;

	return $init->config['cookie_path'];
}

// Calls inward to Bad Behavor itself.
require_once(BB2_CWD . '/bad-behavior/core.inc.php');
bb2_install();	// FIXME: see above

bb2_start(bb2_read_settings());

$bb2_mtime			= explode(' ', microtime());
$bb2_timer_stop		= $bb2_mtime[1]		+ $bb2_mtime[0];
$bb2_timer_total	= $bb2_timer_stop	- $bb2_timer_start;

?>