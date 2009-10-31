<?php

/*
 Wacko Wiki MySQL Table Creation Script
 */
$pref = $config["table_prefix"];

$table_acls = "CREATE TABLE {$pref}acls (".
					"page_tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"supertag VARCHAR(250) NOT NULL DEFAULT '',".
					"privilege VARCHAR(10) NOT NULL DEFAULT '',".
					"list TEXT NOT NULL,".
					"PRIMARY KEY  (page_tag,privilege),".
					"KEY supertag (supertag)".
				") TYPE=MyISAM";

$table_cache = "CREATE TABLE {$pref}cache (".
					"name VARCHAR(32) NOT NULL,".
					"method VARCHAR(20) NOT NULL,".
					"query VARCHAR(100) NOT NULL,".
					"time TIMESTAMP NOT NULL,".
					"INDEX (name),".
					"KEY timestamp (time)".
				") TYPE=MyISAM";

$table_config = "CREATE TABLE {$pref}config (".
				"id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
				"name VARCHAR(100) NOT NULL DEFAULT '',".
				"value TEXT,".
				// "updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
				"PRIMARY KEY (id),".
				"UNIQUE KEY name (name)".
			") TYPE=MyISAM";

$table_links = "CREATE TABLE {$pref}links (".
					"id INT(10) UNSIGNED NOT NULL auto_increment,".
					"from_tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"from_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"to_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_supertag VARCHAR(250) NOT NULL,".
					"PRIMARY KEY (id),".
					"KEY from_tag (from_tag,to_tag(78)),".
					"KEY idx_from (from_tag),".
					"KEY idx_to (to_tag)".
				") TYPE=MyISAM";

$table_log = "CREATE TABLE {$pref}log (".
				"id INT(10) UNSIGNED NOT NULL auto_increment,".
				"time TIMESTAMP NOT NULL,".
				"level TINYINT(1) NOT NULL,".
				"user VARCHAR(100) NOT NULL,".
				"ip VARCHAR(15) NOT NULL,".
				"message TEXT NOT NULL,".
				"PRIMARY KEY (id),".
				"KEY idx_level (level),".
				"KEY idx_user (user),".
				"KEY idx_ip (ip),".
				"KEY idx_time (time)".
			") TYPE=MyISAM";

$table_pages = "CREATE TABLE {$pref}pages (".
					"id INT(10) UNSIGNED NOT NULL auto_increment,".
					"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"tag VARCHAR(250) NOT NULL DEFAULT '',".
					"supertag VARCHAR(250) NOT NULL DEFAULT '',".
					"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body MEDIUMTEXT NOT NULL,".
					"body_r MEDIUMTEXT NOT NULL,".
					"body_toc TEXT NOT NULL,".
					"owner VARCHAR(50) NOT NULL DEFAULT '',".
					"user VARCHAR(50) NOT NULL DEFAULT '',".
					"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
					"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
					"latest TINYINT(1) UNSIGNED DEFAULT '1',".
					"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
					"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"comments INT(4) UNSIGNED NOT NULL DEFAULT '0',".
					"hits INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"title VARCHAR(100) NOT NULL DEFAULT '',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"PRIMARY KEY (id),".
					"FULLTEXT KEY body (body),".
					"UNIQUE KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_created (created),".
					"KEY idx_time (time),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_comment_on_id (comment_on_id),".
					"KEY idx_title (title)".
				") TYPE=MyISAM;";

$table_referrers = "CREATE TABLE {$pref}referrers (".
						"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"referrer CHAR(150) NOT NULL DEFAULT '',".
						"time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"KEY idx_page_id (page_id),".
						"KEY idx_time (time)".
					") TYPE=MyISAM";

$table_revisions = "CREATE TABLE {$pref}revisions (".
						"id INT(10) UNSIGNED NOT NULL auto_increment,".
						"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
						"supertag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
						"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"body MEDIUMTEXT NOT NULL,".
						"body_r MEDIUMTEXT NOT NULL,".
						"owner VARCHAR(50) NOT NULL DEFAULT '',".
						"user VARCHAR(50) NOT NULL DEFAULT '',".
						"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
						"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
						"latest TINYINT(1) UNSIGNED DEFAULT '0',".
						"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
						"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"lang VARCHAR(2) NOT NULL DEFAULT '',".
						"title VARCHAR(100) NOT NULL DEFAULT '',".
						"description VARCHAR(250) NOT NULL DEFAULT '',".
						"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
						"PRIMARY KEY (id),".
						"KEY idx_tag (tag),".
						"KEY idx_supertag (supertag),".
						"KEY idx_time (time),".
						"KEY idx_minor_edit (minor_edit),".
						"KEY idx_comment_on_id (comment_on_id)".
					") TYPE=MyISAM;";

$table_upload = "CREATE TABLE {$pref}upload (".
					"id INT(10) UNSIGNED NOT NULL auto_increment,".
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
					"PRIMARY KEY (id),".
					"KEY page_id (page_id,filename),".
					"KEY page_id_2 (page_id,uploaded_dt),".
					"KEY idx_user_id (user_id)".
				") TYPE=MyISAM";

$table_users = "CREATE TABLE {$pref}users (".
					"id INT(10) UNSIGNED NOT NULL auto_increment,".
					"name VARCHAR(80) NOT NULL DEFAULT '',".
					"password VARCHAR(32) NOT NULL DEFAULT '',".
					"email VARCHAR(50) NOT NULL DEFAULT '',".
					"motto TEXT NOT NULL,".
					"revisioncount INT(10) UNSIGNED NOT NULL DEFAULT '20',".
					"changescount INT(10) UNSIGNED NOT NULL DEFAULT '50',".
					"doubleclickedit TINYINT(1) NOT NULL DEFAULT '1',".
					"signuptime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"show_comments TINYINT(1) NOT NULL DEFAULT '1',".
					"bookmarks TEXT NOT NULL,".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"show_spaces TINYINT(1) NOT NULL DEFAULT '1',".
					"show_datetime TINYINT(1) NOT NULL DEFAULT '1',".
					"typografica TINYINT(1) NOT NULL DEFAULT '1',".
					"more TEXT NOT NULL,".
					"changepassword VARCHAR(100) NOT NULL,".
					"email_confirm VARCHAR(40) NOT NULL DEFAULT '',".
					"total_pages INT(10) UNSIGNED NOT NULL,".
					"total_revisions INT(10) UNSIGNED NOT NULL,".
					"total_comments INT(10) UNSIGNED NOT NULL,".
					"PRIMARY KEY (id),".
					"KEY idx_name (name),".
					"KEY idx_signuptime (signuptime)".
				") TYPE=MyISAM";

$table_watches = "CREATE TABLE {$pref}watches (".
						"id INT(10) UNSIGNED NOT NULL auto_increment,".
						"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
						"time TIMESTAMP NOT NULL,".
						"PRIMARY KEY (id)".
					") TYPE=MyISAM";

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$table_pages_drop = "DROP TABLE {$pref}pages";
$table_revisions_drop = "DROP TABLE {$pref}revisions";
$table_acls_drop = "DROP TABLE {$pref}acls";
$table_links_drop = "DROP TABLE {$pref}links";
$table_referrers_drop = "DROP TABLE {$pref}referrers";
$table_users_drop = "DROP TABLE {$pref}users";
$table_watches_drop = "DROP TABLE {$pref}watches";
$table_upload_drop = "DROP TABLE {$pref}upload";
$table_cache_drop = "DROP TABLE {$pref}cache";
$table_log_drop = "DROP TABLE {$pref}log";
$table_config_drop = "DROP TABLE {$pref}config";

?>