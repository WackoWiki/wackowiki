<?php
/*
 Wacko Wiki PostgreSQL Table Creation Script
 */

$pref = $config['table_prefix'];

$table_page = "CREATE TABLE {$pref}page (".
					"page_id serial,".
					"\"owner_id\" integer NOT NULL DEFAULT '',".
					"\"user_id\" integer NOT NULL DEFAULT '',".
					"tag character varying(250) NOT NULL DEFAULT '',".
					"supertag character varying(250) NOT NULL DEFAULT '',".
					"title character varying(100) NOT NULL DEFAULT '',".
					"\"created\" timestamp without time zone NOT NULL DEFAULT now(),".
					"\"modified\" timestamp without time zone NOT NULL DEFAULT now(),".
					"body text NOT NULL,".
					"body_r text NOT NULL,".
					"body_toc text NOT NULL,".
					"edit_note character varying(100) NOT NULL DEFAULT '',".
					"minor_edit int(1) NOT NULL DEFAULT '0',".
					"ip character varying(15) NOT NULL,".
					"latest int(1) NOT NULL DEFAULT '1',".
					"\"handler\" character varying(30) NOT NULL DEFAULT 'page',".
					"comment_on_id integer NOT NULL DEFAULT '0',".
					"hits integer NOT NULL DEFAULT 0,".
					"lang character varying(2) NOT NULL DEFAULT '',".
					"description character varying(250) NOT NULL DEFAULT '',".
					"keywords character varying(250) NOT NULL DEFAULT '',".
					"CONSTRAINT pk_page_id PRIMARY KEY (page_id),".
					"CONSTRAINT idx_page_tag UNIQUE (tag)".
				") WITH (OIDS=FALSE);";

$table_revision = "CREATE TABLE {$pref}revision (".
						"revision_id serial,".
						"page_id integer NOT NULL DEFAULT 0,".
						"\"owner_id\" integer NOT NULL DEFAULT '',".
						"\"user_id\" integer NOT NULL DEFAULT '',".
						"tag character varying(250) NOT NULL DEFAULT '',".
						"supertag character varying(250) NOT NULL DEFAULT '',".
						"title character varying(100) NOT NULL DEFAULT '',".
						"\"created\" timestamp without time zone NOT NULL DEFAULT now(),".
						"\"modified\" timestamp without time zone NOT NULL DEFAULT now(),".
						"body text NOT NULL DEFAULT '',".
						"body_r text NOT NULL DEFAULT '',".
						"edit_note character varying(100) NOT NULL DEFAULT '',".
						"minor_edit int(1) NOT NULL DEFAULT '0',".
						"ip character varying(15) NOT NULL,".
						"latest int(1) NOT NULL DEFAULT '0',".
						"\"handler\" character varying(30) NOT NULL DEFAULT 'page',".
						"comment_on_id integer NOT NULL DEFAULT '0',".
						"lang character varying(2) NOT NULL DEFAULT '',".
						"description character varying(250) NOT NULL DEFAULT '',".
						"keywords character varying(250) NOT NULL DEFAULT '',".
						"CONSTRAINT pk_revision_id PRIMARY KEY (revision_id)".
					") WITH (OIDS=FALSE);";


$table_acl = "CREATE TABLE {$pref}acl (".
					"page_id integer NOT NULL DEFAULT 0,".
					"privilege character varying(10) NOT NULL DEFAULT '',".
					"list text NOT NULL DEFAULT '',".
					"CONSTRAINT pk_acl_page_id_privilege PRIMARY KEY (page_id, privilege)".
				") WITH (OIDS=FALSE);";

$table_link = "CREATE TABLE {$pref}link (".
					"link_id serial,".
					"from_tag character varying(250) NOT NULL DEFAULT '',".
					"to_tag character varying(250) NOT NULL DEFAULT '',".
					"to_supertag character varying(250) NOT NULL DEFAULT ''".
				") WITH (OIDS=FALSE);";

$table_log = "CREATE TABLE {$pref}log (".
				"log_id serial,".
				"\"time\" timestamp without time zone NOT NULL DEFAULT NOW(),".
				"level int(1) NOT NULL,".
				"\"user_id\" integer NOT NULL DEFAULT '',".
				"ip character varying(15) NOT NULL DEFAULT '',".
				"message text NOT NULL DEFAULT '',".
				"CONSTRAINT pk_log_id PRIMARY KEY (log_id)".
			") WITH (OIDS=FALSE);";

$table_referrer = "CREATE TABLE {$pref}referrer (".
						"page_id integer NOT NULL DEFAULT 0,".
						"referrer character varying(150) NOT NULL DEFAULT '', ".
						"\"referrer_time\" timestamp without time zone NOT NULL DEFAULT now()".
					") WITH (OIDS=FALSE);";

$table_user = "CREATE TABLE {$pref}user (".
					"user_id serial,".
					"name character varying(80) NOT NULL DEFAULT '',".
					"real_name character varying(80) NOT NULL DEFAULT '',".
					"\"password\" character varying(40) NOT NULL DEFAULT '',".
					"salt character varying(40) NOT NULL DEFAULT '',".
					"email character varying(50) NOT NULL DEFAULT '',".
					"revisions_count integer NOT NULL DEFAULT 20,".
					"changes_count integer NOT NULL DEFAULT 50,".
					"doubleclick_edit int(1) NOT NULL DEFAULT '1',".
					"signup_time timestamp without time zone NOT NULL DEFAULT now(),".
					"show_comments int(1) NOT NULL DEFAULT '1',".
					"bookmarks text NOT NULL DEFAULT '',".
					"lang character varying(2) NOT NULL DEFAULT '',".
					"show_spaces int(1) NOT NULL DEFAULT '1',".
					"typografica int(1) NOT NULL DEFAULT '1',".
					"change_password character varying(40) NOT NULL DEFAULT '',".
					"email_confirm character varying(40) NOT NULL DEFAULT '',".
					"CONSTRAINT pk_user_name PRIMARY KEY (user_id),".
					"CONSTRAINT idx_user_name UNIQUE (name)".
				") WITH (OIDS=FALSE);";

$table_watch = "CREATE TABLE {$pref}watch (".
					"watch_id serial,".
					"page_id integer NOT NULL DEFAULT 0,".
					"user_id integer NOT NULL DEFAULT 0,".
					"\"watch_time\" timestamp without time zone NOT NULL DEFAULT now(),".
					"CONSTRAINT pk_watch_id PRIMARY KEY (watch_id)".
				") WITH (OIDS=FALSE);";

$table_upload = "CREATE TABLE {$pref}upload (".
					"upload_id serial,".
					"page_id integer NOT NULL DEFAULT 0,".
					"user_id integer NOT NULL DEFAULT 0,".
					"file_name character varying(250) NOT NULL DEFAULT '',".
					"description character varying(250) NOT NULL DEFAULT '',".
					"uploaded_dt timestamp without time zone NOT NULL DEFAULT now(),".
					"file_size integer NOT NULL DEFAULT 0,".
					"picture_w integer NOT NULL DEFAULT 0,".
					"picture_h integer NOT NULL DEFAULT 0,".
					"file_ext character varying(10) NOT NULL DEFAULT '',".
					"hits integer NOT NULL DEFAULT 0,".
					"CONSTRAINT pk_upload_id PRIMARY KEY (id)".
				") WITH (OIDS=FALSE);";

$table_cache = "CREATE TABLE {$pref}cache (".
					"name character varying(32) NOT NULL DEFAULT '',".
					"method character varying(20) NOT NULL DEFAULT '',".
					"query character varying(100) NOT NULL DEFAULT '',".
					"\"cache_time\" timestamp without time zone NOT NULL DEFAULT now(),".
					"CONSTRAINT pk_cache_name PRIMARY KEY (name)".
				") WITH (OIDS=FALSE);";

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$table_acl_drop = "DROP TABLE {$pref}acl";
$table_bookmark_drop = "DROP TABLE {$pref}bookmark";
$table_cache_drop = "DROP TABLE {$pref}cache";
$table_config_drop = "DROP TABLE {$pref}config";
$table_group_drop = "DROP TABLE {$pref}group";
$table_group_member_drop = "DROP TABLE {$pref}group_member";
$table_category_drop = "DROP TABLE {$pref}category";
$table_category_page_drop = "DROP TABLE {$pref}category_page";
$table_link_drop = "DROP TABLE {$pref}link";
$table_log_drop = "DROP TABLE {$pref}log";
$table_page_drop = "DROP TABLE {$pref}page";
$table_poll_drop = "DROP TABLE {$pref}poll";
$table_rating_drop = "DROP TABLE {$pref}rating";
$table_referrer_drop = "DROP TABLE {$pref}referrer";
$table_revision_drop = "DROP TABLE {$pref}revision";
$table_upload_drop = "DROP TABLE {$pref}upload";
$table_user_drop = "DROP TABLE {$pref}user";
$table_user_setting_drop = "DROP TABLE {$pref}user_setting";
$table_watch_drop = "DROP TABLE {$pref}watch";

?>