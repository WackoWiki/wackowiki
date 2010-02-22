<?php

/*
 Wacko Wiki MySQL Table Creation Script

 TODO: add COMMENT 'field description'
 */

$pref = $config["table_prefix"];

$table_acls = "CREATE TABLE {$pref}acls (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"privilege VARCHAR(10) NOT NULL DEFAULT '',".
					"list TEXT NOT NULL,".
					"UNIQUE KEY idx_page_id (page_id,privilege)".
				") TYPE=MyISAM";

$table_cache = "CREATE TABLE {$pref}cache (".
					"name VARCHAR(32) NOT NULL,".
					"method VARCHAR(20) NOT NULL,".
					"query VARCHAR(100) NOT NULL,".
					"cache_time TIMESTAMP NOT NULL,".
					"INDEX (name),".
					"KEY timestamp (cache_time)".
				") TYPE=MyISAM";

$table_config = "CREATE TABLE {$pref}config (".
					"config_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"config_name VARCHAR(100) NOT NULL DEFAULT '',".
					"value TEXT,".
					// "updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
					"PRIMARY KEY (config_id),".
					"UNIQUE KEY idx_config_name (config_name)".
				") TYPE=MyISAM";

$table_groups = "CREATE TABLE {$pref}groups (".
					"group_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"group_name VARCHAR(100) NOT NULL,".
					"description VARCHAR(255) NOT NULL,".
					"moderator INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"created DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,".
					"open TINYINT(1) UNSIGNED NOT NULL,".
					"active TINYINT(1) UNSIGNED NOT NULL,".
					// "special TINYINT(1) UNSIGNED NOT NULL,".
					"PRIMARY KEY (group_id),".
					"UNIQUE KEY idx_name (group_name)".
				") TYPE=MyISAM";

$table_groups_members = "CREATE TABLE {$pref}groups_members (".
					"group_id INTEGER(10) UNSIGNED NOT NULL,".
					"user_id INTEGER(10) UNSIGNED NOT NULL,".
					"UNIQUE KEY idx_group_id (group_id, user_id)".
				")ENGINE=MyISAM";

$table_keywords = "CREATE TABLE {$pref}keywords (".
					"keyword_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"parent INT(10) UNSIGNED NOT NULL,".
					"lang VARCHAR(2) NOT NULL,".
					"keyword VARCHAR(100) NOT NULL,".
					"PRIMARY KEY (keyword_id),".
					"UNIQUE KEY idx_keywords (lang,keyword)".
				") TYPE=MyISAM";

$table_keywords_pages = "CREATE TABLE {$pref}keywords_pages (".
						"keyword_id INT(10) unsigned NOT NULL,".
						"page_id INT(10) unsigned NOT NULL,".
						"UNIQUE KEY idx_pageword (keyword_id,page_id)".
					") ENGINE=MyISAM";

$table_links = "CREATE TABLE {$pref}links (".
					"link_id INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT,".
					"from_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"to_supertag VARCHAR(250) NOT NULL,".
					"PRIMARY KEY (link_id),".
					"KEY from_tag (from_page_id,to_tag(78)),".
					"KEY idx_from_page_id (from_page_id),".
					"KEY idx_to (to_tag)".
				") TYPE=MyISAM";

$table_log = "CREATE TABLE {$pref}log (".
					"log_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"log_time TIMESTAMP NOT NULL,".
					"level TINYINT(1) NOT NULL,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL,".
					"message TEXT NOT NULL,".
					"PRIMARY KEY (log_id),".
					"KEY idx_level (level),".
					"KEY idx_user_id (user_id),".
					"KEY idx_ip (ip),".
					"KEY idx_time (log_time)".
				") TYPE=MyISAM";

$table_pages = "CREATE TABLE {$pref}pages (".
					"page_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"tag VARCHAR(250) NOT NULL DEFAULT '',".
					"supertag VARCHAR(250) NOT NULL DEFAULT '',".
					"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body MEDIUMTEXT NOT NULL,".
					"body_r MEDIUMTEXT NOT NULL,".
					"body_toc TEXT NOT NULL,".
					"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
					"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL,".
					"latest TINYINT(1) UNSIGNED DEFAULT '1',".
					"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
					"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"comments INT(4) UNSIGNED NOT NULL DEFAULT '0',".
					"hits INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"title VARCHAR(100) NOT NULL DEFAULT '',".
					"commented DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"more VARCHAR(255) NOT NULL,".
					"PRIMARY KEY (page_id),".
					"KEY idx_user_id (user_id),".
					"KEY idx_owner_id (owner_id),".
					"FULLTEXT KEY body (body),".
					"UNIQUE KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_created (created),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_comment_on_id (comment_on_id),".
					"KEY idx_commented (commented),".
					"KEY idx_title (title)".
				") TYPE=MyISAM;";

$table_rating = "CREATE TABLE {$pref}rating (".
					"page_id int(10) UNSIGNED NOT NULL,".
					"value INT(11) NOT NULL,".
					"voters INT(10) UNSIGNED NOT NULL,".
					"rating_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (page_id),".
					"KEY idx_voters_rate (voters)".
				") TYPE=MyISAM";

$table_referrers = "CREATE TABLE {$pref}referrers (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"referrer CHAR(150) NOT NULL DEFAULT '',".
					"referrer_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"KEY idx_page_id (page_id),".
					"KEY idx_referrer_time (referrer_time)".
				") TYPE=MyISAM";

$table_revisions = "CREATE TABLE {$pref}revisions (".
					"revision_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"supertag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body MEDIUMTEXT NOT NULL,".
					"body_r MEDIUMTEXT NOT NULL,".
					"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
					"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
					"latest TINYINT(1) UNSIGNED DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL,".
					"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
					"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"title VARCHAR(100) NOT NULL DEFAULT '',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"PRIMARY KEY (revision_id),".
					"KEY idx_user_id (user_id),".
					"KEY idx_owner_id (owner_id),".
					"KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_comment_on_id (comment_on_id)".
				") TYPE=MyISAM;";

$table_upload = "CREATE TABLE {$pref}upload (".
					"upload_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"filename VARCHAR(250) NOT NULL DEFAULT '',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"uploaded_dt DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"filesize INT(11) UNSIGNED NOT NULL DEFAULT '0',".
					"picture_w INT(11) UNSIGNED NOT NULL DEFAULT '0',".
					"picture_h INT(11) UNSIGNED NOT NULL DEFAULT '0',".
					"file_ext VARCHAR(10) NOT NULL DEFAULT '',".
					"hits INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"PRIMARY KEY (upload_id),".
					"KEY page_id (page_id,filename),".
					"KEY page_id_2 (page_id,uploaded_dt),".
					"KEY idx_user_id (user_id)".
				") TYPE=MyISAM";

$table_users = "CREATE TABLE {$pref}users (".
					"user_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_name VARCHAR(80) NOT NULL DEFAULT '',".
					"real_name VARCHAR(80) NOT NULL DEFAULT '',".
					"password VARCHAR(40) NOT NULL DEFAULT '',".
					"email VARCHAR(50) NOT NULL DEFAULT '',".
					"enabled TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"motto TEXT NOT NULL,".
					"revisions_count INT(10) UNSIGNED NOT NULL DEFAULT '20',".
					"changes_count INT(10) UNSIGNED NOT NULL DEFAULT '50',".
					"doubleclick_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"signup_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"show_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"bookmarks TEXT NOT NULL,".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"show_spaces TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"typografica TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"more TEXT NOT NULL,".
					"change_password VARCHAR(100) NOT NULL,".
					"email_confirm VARCHAR(40) NOT NULL DEFAULT '',".
					"session_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"session_expire INT(10) UNSIGNED NOT NULL,".
					"total_pages INT(10) UNSIGNED NOT NULL,".
					"total_revisions INT(10) UNSIGNED NOT NULL,".
					"total_comments INT(10) UNSIGNED NOT NULL,".
					"PRIMARY KEY (user_id),".
					"UNIQUE KEY idx_user_name (user_name),".
					"KEY idx_enabled (enabled),".
					"KEY idx_signup_time (signup_time)".
				") TYPE=MyISAM";

$table_watches = "CREATE TABLE {$pref}watches (".
					"watch_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"watch_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (watch_id)".
				") TYPE=MyISAM";

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$table_acls_drop = "DROP TABLE {$pref}acls";
$table_cache_drop = "DROP TABLE {$pref}cache";
$table_config_drop = "DROP TABLE {$pref}config";
$table_groups_drop = "DROP TABLE {$pref}groups";
$table_groups_members_drop = "DROP TABLE {$pref}groups_members";
$table_keywords_drop = "DROP TABLE {$pref}keywords";
$table_keywords_pages_drop = "DROP TABLE {$pref}keywords_pages";
$table_links_drop = "DROP TABLE {$pref}links";
$table_log_drop = "DROP TABLE {$pref}log";
$table_pages_drop = "DROP TABLE {$pref}pages";
$table_rating_drop = "DROP TABLE {$pref}rating";
$table_referrers_drop = "DROP TABLE {$pref}referrers";
$table_revisions_drop = "DROP TABLE {$pref}revisions";
$table_upload_drop = "DROP TABLE {$pref}upload";
$table_users_drop = "DROP TABLE {$pref}users";
$table_watches_drop = "DROP TABLE {$pref}watches";

?>