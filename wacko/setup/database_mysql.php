<?php
/*
 Wacko Wiki MySQL Table Creation Script
 */

$table_pages = "CREATE TABLE ".$config["table_prefix"]."pages (".
					"id int(10) unsigned NOT NULL auto_increment,".
					"tag varchar(250) NOT NULL DEFAULT '',".
					"supertag varchar(250) NOT NULL DEFAULT '',".
					"created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body mediumtext NOT NULL,".
					"body_r mediumtext NOT NULL,".
					"body_toc text NOT NULL,".
					"owner varchar(50) NOT NULL DEFAULT '',".
					"user varchar(50) NOT NULL DEFAULT '',".
					"latest enum('Y','N') NOT NULL DEFAULT 'N',".
					"handler varchar(30) NOT NULL DEFAULT 'page',".
					"comment_on varchar(250) binary NOT NULL DEFAULT '',".
					"super_comment_on varchar(250) NOT NULL DEFAULT '',".
					"hits int(11) NOT NULL DEFAULT '0',".
					"lang varchar(20) NOT NULL DEFAULT '',".
					"title varchar(100) NOT NULL DEFAULT '',".
					"description varchar(250) NOT NULL DEFAULT '',".
					"keywords varchar(250) binary NOT NULL DEFAULT '',".
					"PRIMARY KEY (id),".
					"FULLTEXT KEY body (body),".
					"UNIQUE KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_created (created),".
					"KEY idx_time (time),".
					"KEY idx_latest (latest),".
					"KEY idx_comment_on (comment_on),".
					"KEY idx_super_comment_on (super_comment_on),".
					"KEY idx_title (title)".
				") TYPE=MyISAM;";

$table_revisions = "CREATE TABLE ".$config["table_prefix"]."revisions (".
						"id int(10) unsigned NOT NULL auto_increment,".
						"tag varchar(250) binary NOT NULL DEFAULT '',".
						"supertag varchar(250) binary NOT NULL DEFAULT '',".
						"created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"body mediumtext NOT NULL,".
						"body_r mediumtext NOT NULL,".
						"owner varchar(50) NOT NULL DEFAULT '',".
						"user varchar(50) NOT NULL DEFAULT '',".
						"latest enum('Y','N') NOT NULL DEFAULT 'N',".
						"handler varchar(30) NOT NULL DEFAULT 'page',".
						"comment_on varchar(250) binary NOT NULL DEFAULT '',".
						"super_comment_on varchar(250) NOT NULL DEFAULT '',".
						"lang varchar(20) NOT NULL DEFAULT '',".
						"description varchar(250) NOT NULL DEFAULT '',".
						"keywords varchar(250) binary NOT NULL DEFAULT '',".
						"PRIMARY KEY (id),".
						"KEY idx_tag (tag),".
						"KEY idx_supertag (supertag),".
						"KEY idx_time (time),".
						"KEY idx_latest (latest),".
						"KEY idx_comment_on (comment_on)".
					") TYPE=MyISAM;";

$table_acls = "CREATE TABLE ".$config["table_prefix"]."acls (".
					"page_tag varchar(250) binary NOT NULL DEFAULT '',".
					"supertag varchar(250) NOT NULL DEFAULT '',".
					"privilege varchar(20) NOT NULL DEFAULT '',".
					"list text NOT NULL,".
					"PRIMARY KEY  (page_tag,privilege),".
					"KEY supertag (supertag)".
				") TYPE=MyISAM";

$table_links = "CREATE TABLE ".$config["table_prefix"]."links (".
					"from_tag varchar(250) binary NOT NULL DEFAULT '',".
					"to_tag varchar(250) binary NOT NULL DEFAULT '',".
					"to_supertag VARCHAR(250) NOT NULL,".
					"KEY from_tag (from_tag,to_tag(78)),".
					"KEY idx_from (from_tag),".
					"KEY idx_to (to_tag)".
				") TYPE=MyISAM";

$table_referrers = "CREATE TABLE ".$config["table_prefix"]."referrers (".
						"page_id int(10) NOT NULL DEFAULT '0',".
						"referrer char(150) NOT NULL DEFAULT '',".
						"time datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"KEY idx_page_id (page_id),".
						"KEY idx_time (time)".
					") TYPE=MyISAM";

$table_users = "CREATE TABLE ".$config["table_prefix"]."users (".
					"id int(10) NOT NULL auto_increment,".
					"name varchar(80) NOT NULL DEFAULT '',".
					"password varchar(32) NOT NULL DEFAULT '',".
					"email varchar(50) NOT NULL DEFAULT '',".
					"motto text NOT NULL,".
					"revisioncount int(10) unsigned NOT NULL DEFAULT '20',".
					"changescount int(10) unsigned NOT NULL DEFAULT '50',".
					"doubleclickedit enum('Y','N') NOT NULL DEFAULT 'Y',".
					"signuptime datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"show_comments enum('Y','N') NOT NULL DEFAULT 'N',".
					"bookmarks text NOT NULL,".
					"lang varchar(20) NOT NULL DEFAULT '',".
					"show_spaces enum('Y','N') NOT NULL DEFAULT 'Y',".
					"showdatetime enum('Y','N') NOT NULL DEFAULT 'Y',".
					"typografica enum('Y','N') NOT NULL DEFAULT 'Y',".
					"more text NOT NULL,".
					"changepassword VARCHAR(100) NOT NULL,".
					"email_confirm varchar(40) NOT NULL DEFAULT '',".
					"PRIMARY KEY (id),".
					"KEY idx_name (name),".
					"KEY idx_signuptime (signuptime)".
				") TYPE=MyISAM";

$table_pagewatches = "CREATE TABLE ".$config["table_prefix"]."pagewatches (".
						"id int(10) NOT NULL auto_increment,".
						"user varchar(80) NOT NULL DEFAULT '',".
						"tag varchar(250) binary NOT NULL DEFAULT '',".
						"time timestamp(14) NOT NULL,".
						"PRIMARY KEY (id)".
					") TYPE=MyISAM";

$table_upload = "CREATE TABLE ".$config["table_prefix"]."upload (".
					"id int(11) NOT NULL auto_increment,".
					"page_id int(11) NOT NULL DEFAULT '0',".
					"filename varchar(250) NOT NULL DEFAULT '',".
					"description varchar(250) NOT NULL DEFAULT '',".
					"uploaded_dt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"filesize int(11) NOT NULL DEFAULT '0',".
					"picture_w int(11) NOT NULL DEFAULT '0',".
					"picture_h int(11) NOT NULL DEFAULT '0',".
					"file_ext varchar(10) NOT NULL DEFAULT '',".
					"user varchar(80) NOT NULL DEFAULT '0',".
					"PRIMARY KEY (id),".
					"KEY page_id (page_id,filename),".
					"KEY page_id_2 (page_id,uploaded_dt),".
					"KEY user_id (user,page_id)".
				") TYPE=MyISAM";

$table_cache = "CREATE TABLE ".$config["table_prefix"]."cache (".
					"name VARCHAR(32) NOT NULL,".
					"method VARCHAR(20) NOT NULL,".
					"query VARCHAR(100) NOT NULL,".
					"time TIMESTAMP NOT NULL,".
					"INDEX (name),".
					"KEY timestamp (time)".
				") TYPE=MyISAM";

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$table_pages_drop = "DROP TABLE ".$config["table_prefix"]."pages";
$table_revisions_drop = "DROP TABLE ".$config["table_prefix"]."revisions";
$table_acls_drop = "DROP TABLE ".$config["table_prefix"]."acls";
$table_links_drop = "DROP TABLE ".$config["table_prefix"]."links";
$table_referrers_drop = "DROP TABLE ".$config["table_prefix"]."referrers";
$table_users_drop = "DROP TABLE ".$config["table_prefix"]."users";
$table_pagewatches_drop = "DROP TABLE ".$config["table_prefix"]."pagewatches";
$table_upload_drop = "DROP TABLE ".$config["table_prefix"]."upload";
$table_cache_drop = "DROP TABLE ".$config["table_prefix"]."cache";

?>