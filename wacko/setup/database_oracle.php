<?php

/*
 Wacko Wiki Oracle Table Creation Script
 Oracle 8i and above
 */

$pref = $config["table_prefix"];

$table_acls = "CREATE TABLE {$pref}acls (".
					"page_id number(10) default 0 not null,".
					"privilege varchar2(10) not null,".
					"list clob,".
					"constraint {$pref}acls_pk primary key (page_id, privilege)".
				")";

$table_cache = "CREATE TABLE {$pref}cache (".
					"name varchar2(32) not null,".
					"method varchar2(20) not null,".
					"query varchar2(100) not null,".
					"cache_time date not null,".
					"/*INDEX (name),*/". // TODO
					"constraint {$pref}cache_pk primary key (cache_time)".
				")";

$table_config = "CREATE TABLE {$pref}config (".
					"config_id number(10) not null /*AUTO_INCREMENT*/,".
					"config_name varchar2(100) not null,".
					"value clob,".
					// "updated date not null default CURRENT_date,".
					"constraint {$pref}config_pk primary key (config_id),".
					"constraint {$pref}config_uk unique (config_name)".
				")";

$table_groups = "CREATE TABLE {$pref}groups (".
					"group_id number(10) not null /*AUTO_INCREMENT*/,".
					"group_name varchar2(100) not null,".
					"description varchar2(255) not null,".
					"moderator number(10) default 0 not null,".
					"created date default sysdate not null,".
					"open number(1) not null,".
					"active number(1) not null,".
					// "special number(1) not null,".
					"constraint {$pref}groups_pk primary key (group_id),".
					"constraint {$pref}groups_uk unique (group_name)".
				")";

$table_groups_members = "CREATE TABLE {$pref}groups_members (".
					"group_id number(10) not null,".
					"user_id number(10) not null,".
					"constraint {$pref}groups_members_pk primary key (group_id, user_id)".
				")";

$table_keywords = "CREATE TABLE {$pref}keywords (".
					"keyword_id number(10) not null /*AUTO_INCREMENT*/,".
					"parent number(10) not null,".
					"lang varchar2(2) not null,".
					"keyword varchar2(100) not null,".
					"constraint {$pref}keywords_pk primary key (keyword_id),".
					"constraint {$pref}keywords_uk unique (lang, keyword)".
				")";

$table_keywords_pages = "CREATE TABLE {$pref}keywords_pages (".
						"keyword_id number(10) not null,".
						"page_id number(10) not null,".
						"constraint {$pref}keywords_pages_pk primary key (keyword_id, page_id)".
					")";

$table_links = "CREATE TABLE {$pref}links (".
					"link_id number(10) not null /*AUTO_INCREMENT*/,".
					"from_page_id number(10) default 0 not null,".
					"to_page_id number(10) default 0 not null,".
					"to_tag varchar2(250) not null,".
					"to_supertag varchar2(250) not null,".
					"constraint {$pref}links_pk primary key (link_id)/*,".
					"KEY from_tag (from_page_id,to_tag(78)),". // TODO
					"KEY idx_from_page_id (from_page_id),".
					"KEY idx_to (to_tag)*/".
				")";

$table_log = "CREATE TABLE {$pref}log (".
					"log_id number(10) not null /*AUTO_INCREMENT*/,".
					"log_time date not null,".
					"log_level number(1) not null,". // level is reserved word
					"user_id number(10) default 0 not null,".
					"ip varchar2(15) not null,".
					"message clob,".
					"constraint {$pref}log_pk primary key (log_id)/*,".
					"KEY idx_level (level),".  // TODO
					"KEY idx_user_id (user_id),".
					"KEY idx_ip (ip),".
					"KEY idx_time (log_time)*/".
				")";

$table_pages = "CREATE TABLE {$pref}pages (".
					"page_id number(10) not null /*AUTO_INCREMENT*/,".
					"owner_id number(10) default 0 not null,".
					"user_id number(10) default 0 not null,".
					"tag varchar2(250) not null,".
					"supertag varchar2(250) not null,".
					"title varchar2(100) not null,".
					"created date default sysdate not null,".
					"modified date default sysdate not null,".
					"body clob,".
					"body_r clob,".
					"body_toc clob,".
					"edit_note varchar2(100) not null,".
					"minor_edit number(1) default 0,".
					"ip varchar2(15) not null,".
					"latest number(1) default 1,".
					"handler varchar2(30) default 'page' not null,".
					"comment_on_id number(10) default 0 not null,".
					"comments number(4) default 0 not null,".
					"hits number(10) default 0 not null,".
					"lang varchar2(2) not null,".
					"commented date default sysdate not null,".
					"description varchar2(250) not null,".
					"keywords varchar2(250) not null,".
					"more varchar2(255) not null,".
					"constraint {$pref}pages_pk primary key (page_id)/*,".
					"KEY idx_user_id (user_id),".      // TODO
					"KEY idx_owner_id (owner_id),".
					"FULLTEXT KEY body (body)*/,".
					"constraint {$pref}pages_uk unique (tag)/*,".
					"KEY idx_supertag (supertag),".    // TODO
					"KEY idx_created (created),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_comment_on_id (comment_on_id),".
					"KEY idx_commented (commented),".
					"KEY idx_title (title)*/".
				");";

$table_rating = "CREATE TABLE {$pref}rating (".
					"page_id number(10) not null,".
					"value number(11) not null,".
					"voters number(10) not null,".
					"rating_time date not null,".
					"constraint {$pref}rating_pk primary key (page_id)/*,".
					"KEY idx_voters_rate (voters)*/". // TODO
				")";

$table_referrers = "CREATE TABLE {$pref}referrers (".
					"page_id number(10) default 0 not null,".
					"referrer varchar2(150) not null,".
					"referrer_time date default sysdate not null/*,".
					"KEY idx_page_id (page_id),".           // TODO
					"KEY idx_referrer_time (referrer_time)*/".
				")";

$table_revisions = "CREATE TABLE {$pref}revisions (".
					"revision_id number(10) not null /*AUTO_INCREMENT*/,".
					"page_id number(10) default 0 not null,".
					"owner_id number(10) default 0 not null,".
					"user_id number(10) default 0 not null,".
					"tag varchar2(250) not null,".
					"supertag varchar2(250) not null,".
					"title varchar2(100) not null,".
					"created date default sysdate not null,".
					"modified date default sysdate not null,".
					"body clob,".
					"body_r clob,".
					"edit_note varchar2(100) not null,".
					"minor_edit number(1) default 0,".
					"latest number(1) default 0,".
					"ip varchar2(15) not null,".
					"handler varchar2(30) default 'page' not null,".
					"comment_on_id number(10) default 0 not null,".
					"lang varchar2(2) not null,".
					"description varchar2(250) not null,".
					"keywords varchar2(250) not null,".
					"constraint {$pref}revisions_pk primary key (revision_id)/*,".
					"KEY idx_user_id (user_id),".       // TODO
					"KEY idx_owner_id (owner_id),".
					"KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_comment_on_id (comment_on_id)*/".
				");";

$table_upload = "CREATE TABLE {$pref}upload (".
					"upload_id number(10) not null /*AUTO_INCREMENT*/,".
					"page_id number(10) default 0 not null,".
					"user_id number(10) default 0 not null,".
					"filename varchar2(250) not null,".
					"description varchar2(250) not null,".
					"uploaded_dt date default sysdate not null,".
					"filesize number(11) default 0 not null,".
					"picture_w number(11) default 0 not null,".
					"picture_h number(11) default 0 not null,".
					"file_ext varchar2(10) not null,".
					"hits number(10) default 0 not null,".
					"constraint {$pref}upload_pk primary key (upload_id)/*,".
					"KEY page_id (page_id,filename),".   // TODO
					"KEY page_id_2 (page_id,uploaded_dt),".
					"KEY idx_user_id (user_id)*/".
				")";

$table_users = "CREATE TABLE {$pref}users (".
					"user_id number(10) not null /*AUTO_INCREMENT*/,".
					"user_name varchar2(80) not null,".
					"real_name varchar2(80) not null,".
					"password varchar2(40) not null,".
					"salt varchar2(40) not null,".
					"email varchar2(50) not null,".
					"enabled number(1) default 1 not null,".
					"motto varchar2(4000) not null,".
					"revisions_count number(10) default 20 not null,".
					"changes_count number(10) default 50 not null,".
					"doubleclick_edit number(1) default 1 not null,".
					"signup_time date default sysdate not null,".
					"show_comments number(1) default 1 not null,".
					"bookmarks clob not null,".
					"lang varchar2(2) not null,".
					"show_spaces number(1) default 1 not null,".
					"typografica number(1) default 1 not null,".
					"more clob not null,".
					"change_password varchar2(100) not null,".
					"email_confirm varchar2(40) not null,".
					"session_time date default sysdate not null,".
					"session_expire number(10) not null,".
					"total_pages number(10) not null,".
					"total_revisions number(10) not null,".
					"total_comments number(10) not null,".
					"constraint {$pref}users_pk primary key (user_id),".
					"constraint {$pref}users_uk unique (user_name)/*,".
					"KEY idx_enabled (enabled),".       // TODO
					"KEY idx_signup_time (signup_time)*/".
				")";

$table_watches = "CREATE TABLE {$pref}watches (".
					"watch_id number(10) not null /*AUTO_INCREMENT*/,".
					"user_id number(10) default 0 not null,".
					"page_id number(10) default 0 not null,".
					"watch_time date not null,".
					"constraint {$pref}watches_pk primary key (watch_id)".
				")";

/*
 Wacko Wiki Oracle Table Deletion Script
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
$table_polls_drop = "DROP TABLE {$pref}polls";
$table_rating_drop = "DROP TABLE {$pref}rating";
$table_referrers_drop = "DROP TABLE {$pref}referrers";
$table_revisions_drop = "DROP TABLE {$pref}revisions";
$table_upload_drop = "DROP TABLE {$pref}upload";
$table_users_drop = "DROP TABLE {$pref}users";
$table_watches_drop = "DROP TABLE {$pref}watches";

?>