<?php
/*
 Wacko Wiki PostgreSQL Table Creation Script
 */

$pref = $config["table_prefix"];

$table_pages = "CREATE TABLE {$pref}pages (".
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
					"CONSTRAINT pk_pages_id PRIMARY KEY (page_id),".
					"CONSTRAINT idx_pages_tag UNIQUE (tag)".
				") WITH (OIDS=FALSE);";

$table_revisions = "CREATE TABLE {$pref}revisions (".
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
						"CONSTRAINT pk_revisions_id PRIMARY KEY (revision_id)".
					") WITH (OIDS=FALSE);";


$table_acls = "CREATE TABLE {$pref}acls (".
					"page_id integer NOT NULL DEFAULT 0,".
					"privilege character varying(10) NOT NULL DEFAULT '',".
					"list text NOT NULL DEFAULT '',".
					"CONSTRAINT pk_acls_page_id_privilege PRIMARY KEY (page_id, privilege)".
				") WITH (OIDS=FALSE);";

$table_links = "CREATE TABLE {$pref}links (".
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

$table_referrers = "CREATE TABLE {$pref}referrers (".
						"page_id integer NOT NULL DEFAULT 0,".
						"referrer character varying(150) NOT NULL DEFAULT '', ".
						"\"referrer_time\" timestamp without time zone NOT NULL DEFAULT now()".
					") WITH (OIDS=FALSE);";

$table_users = "CREATE TABLE {$pref}users (".
					"user_id serial,".
					"name character varying(80) NOT NULL DEFAULT '',".
					"real_name character varying(80) NOT NULL DEFAULT '',".
					"\"password\" character varying(40) NOT NULL DEFAULT '',".
					"salt character varying(40) NOT NULL DEFAULT '',".
					"email character varying(50) NOT NULL DEFAULT '',".
					"motto text NOT NULL DEFAULT '',".
					"revisions_count integer NOT NULL DEFAULT 20,".
					"changes_count integer NOT NULL DEFAULT 50,".
					"doubleclick_edit int(1) NOT NULL DEFAULT '1',".
					"signup_time timestamp without time zone NOT NULL DEFAULT now(),".
					"show_comments int(1) NOT NULL DEFAULT '1',".
					"bookmarks text NOT NULL DEFAULT '',".
					"lang character varying(2) NOT NULL DEFAULT '',".
					"show_spaces int(1) NOT NULL DEFAULT '1',".
					"typografica int(1) NOT NULL DEFAULT '1',".
					"more text NOT NULL DEFAULT '',".
					"change_password character varying(100) NOT NULL DEFAULT '',".
					"email_confirm character varying(40) NOT NULL DEFAULT '',".
					"CONSTRAINT pk_users_name PRIMARY KEY (user_id),".
					"CONSTRAINT idx_users_name UNIQUE (name)".
				") WITH (OIDS=FALSE);";

$table_watches = "CREATE TABLE {$pref}watches (".
					"watch_id serial,".
					"page_id integer NOT NULL DEFAULT 0,".
					"user_id integer NOT NULL DEFAULT 0,".
					"\"watch_time\" timestamp without time zone NOT NULL DEFAULT now(),".
					"CONSTRAINT pk_watches_id PRIMARY KEY (watch_id)".
				") WITH (OIDS=FALSE);";

$table_upload = "CREATE TABLE {$pref}upload (".
					"upload_id serial,".
					"page_id integer NOT NULL DEFAULT 0,".
					"user_id integer NOT NULL DEFAULT 0,".
					"filename character varying(250) NOT NULL DEFAULT '',".
					"description character varying(250) NOT NULL DEFAULT '',".
					"uploaded_dt timestamp without time zone NOT NULL DEFAULT now(),".
					"filesize integer NOT NULL DEFAULT 0,".
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