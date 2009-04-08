<?php
/*
 Wacko Wiki PostgreSQL Table Creation Script
 */

$table_pages = "CREATE TABLE ".$config["table_prefix"]."pages (".
                  "id serial,".
                  "tag character varying(250) NOT NULL DEFAULT '',".
                  "supertag character varying(250) NOT NULL DEFAULT '',".
                  "\"time\" timestamp without time zone NOT NULL DEFAULT now(),".
                  "body text NOT NULL,".
                  "body_r text NOT NULL,".
                  "body_toc text NOT NULL,".
                  "\"owner\" character varying(80) NOT NULL DEFAULT '',".
                  "\"user\" character varying(80) NOT NULL DEFAULT '',".
                  "latest character(1) NOT NULL DEFAULT 'N',".
                  "\"handler\" character varying(30) NOT NULL DEFAULT 'page',".
                  "comment_on character varying(250) NOT NULL DEFAULT '',".
                  "super_comment character varying(250) NOT NULL DEFAULT '',".
                  "hits integer NOT NULL DEFAULT 0,".
                  "lang character varying(20) NOT NULL DEFAULT '',".
                  "description character varying(250) NOT NULL DEFAULT '',".
                  "keywords character varying(250) NOT NULL DEFAULT '',".
                  "CONSTRAINT pk_pages_id PRIMARY KEY (id),".
                  "CONSTRAINT idx_pages_tag UNIQUE (tag)".
               ") WITH (OIDS=FALSE);";

$table_revisions = "CREATE TABLE ".$config["table_prefix"]."revisions (".
                     "id serial,".
                     "tag character varying(250) NOT NULL DEFAULT '',".
                     "supertag character varying(250) NOT NULL DEFAULT '',".
                     "\"time\" timestamp without time zone NOT NULL DEFAULT now(),".
                     "body text NOT NULL DEFAULT '',".
                     "body_r text NOT NULL DEFAULT '',".
                     "\"owner\" character varying(80) NOT NULL DEFAULT '',".
                     "\"user\" character varying(80) NOT NULL DEFAULT '',".
                     "latest character(1) NOT NULL DEFAULT 'N',".
                     "\"handler\" character varying(30) NOT NULL DEFAULT 'page',".
                     "comment_on character varying(250) NOT NULL DEFAULT '',".
                     "super_comment_on character varying(250) NOT NULL DEFAULT '',".
                     "lang character varying(20) NOT NULL DEFAULT '',".
                     "description character varying(250) NOT NULL DEFAULT '',".
                     "keywords character varying(250) NOT NULL DEFAULT '',".
                     "CONSTRAINT pk_revisions_id PRIMARY KEY (id)".
                  ") WITH (OIDS=FALSE);";


$table_acls = "CREATE TABLE ".$config["table_prefix"]."acls (".
                     "page_tag character varying(250) NOT NULL DEFAULT '',".
                     "supertag character varying(250) NOT NULL DEFAULT '',".
                     "privilege character varying(20) NOT NULL DEFAULT '',".
                     "list text NOT NULL DEFAULT '',".
                     "CONSTRAINT pk_acls_page_tag_privilege PRIMARY KEY (page_tag, privilege)".
                  ") WITH (OIDS=FALSE);";

$table_links = "CREATE TABLE ".$config["table_prefix"]."links (".
                     "from_tag character varying(250) NOT NULL DEFAULT '',".
                     "to_tag character varying(250) NOT NULL DEFAULT '',".
                     "to_supertag character varying(250) NOT NULL DEFAULT ''".
                  ") WITH (OIDS=FALSE);";


$table_referrers = "CREATE TABLE ".$config["table_prefix"]."referrers (".
                     "page_tag character varying(250) NOT NULL DEFAULT '',".
                     "referrer character varying(150) NOT NULL DEFAULT '', ".
                     "\"time\" timestamp without time zone NOT NULL DEFAULT now()".
                  ") WITH (OIDS=FALSE);";

$table_users = "CREATE TABLE ".$config["table_prefix"]."users (".
                     "name character varying(80) NOT NULL DEFAULT '',".
                     "\"password\" character varying(32) NOT NULL DEFAULT '',".
                     "email character varying(320) NOT NULL DEFAULT '',".
                     "motto text NOT NULL DEFAULT '',".
                     "revisioncount integer NOT NULL DEFAULT 20,".
                     "changescount integer NOT NULL DEFAULT 50,".
                     "doubleclickedit character(1) NOT NULL DEFAULT 'Y',".
                     "signuptime timestamp without time zone NOT NULL DEFAULT now(),".
                     "show_comments character(1) NOT NULL DEFAULT 'N',".
                     "bookmarks text NOT NULL DEFAULT '',".
                     "lang character varying(20) NOT NULL DEFAULT '',".
                     "show_spaces character(1) NOT NULL DEFAULT 'Y',".
                     "showdatetime character(1) NOT NULL DEFAULT 'Y',".
                     "typografica character(1) NOT NULL DEFAULT 'Y',".
                     "more text NOT NULL DEFAULT '',".
                     "changepassword character varying(100) NOT NULL DEFAULT '',".
                     "email_confirm character varying(40) NOT NULL DEFAULT '',".
                     "CONSTRAINT pk_users_name PRIMARY KEY (name)".
                  ") WITH (OIDS=FALSE);";

$table_pagewatches = "CREATE TABLE ".$config["table_prefix"]."pagewatches (".
                     "id serial,".
                     "\"user\" character varying(80) NOT NULL DEFAULT '',".
                     "tag character varying(250) NOT NULL DEFAULT '',".
                     "\"time\" timestamp without time zone NOT NULL DEFAULT now(),".
                     "CONSTRAINT pk_pagewatches_id PRIMARY KEY (id)".
                  ") WITH (OIDS=FALSE);";

$table_upload = "CREATE TABLE ".$config["table_prefix"]."upload (".
                     "id serial,".
                     "page_id integer NOT NULL DEFAULT 0,".
                     "filename character varying(250) NOT NULL DEFAULT '',".
                     "description character varying(250) NOT NULL DEFAULT '',".
                     "uploaded_dt timestamp without time zone NOT NULL DEFAULT now(),".
                     "filesize integer NOT NULL DEFAULT 0,".
                     "picture_w integer NOT NULL DEFAULT 0,".
                     "picture_h integer NOT NULL DEFAULT 0,".
                     "file_ext character varying(10) NOT NULL DEFAULT '',".
                     "\"user\" character varying(80) NOT NULL DEFAULT '0',".
                     "CONSTRAINT pk_upload_id PRIMARY KEY (id)".
                  ") WITH (OIDS=FALSE);";

$table_cache = "CREATE TABLE ".$config["table_prefix"]."cache (".
                     "name character varying(32) NOT NULL DEFAULT '',".
                     "method character varying(20) NOT NULL DEFAULT '',".
                     "query character varying(100) NOT NULL DEFAULT '',".
                     "CONSTRAINT pk_cache_name PRIMARY KEY (name)".
                  ") WITH (OIDS=FALSE);";
?>