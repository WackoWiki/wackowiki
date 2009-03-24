<?php
/*
 Wacko Wiki MySQL Table Creation Script
 */

$table_pages = "CREATE TABLE ".$config["table_prefix"]."pages (".
                 "id int(10) unsigned NOT NULL auto_increment,".
                 "tag varchar(250) character set latin1 collate latin1_swedish_ci NOT NULL default '',".
                 "supertag varchar(250) NOT NULL default '',".
                 "time datetime NOT NULL default '0000-00-00 00:00:00',".
                 "body mediumtext NOT NULL,".
                 "body_r mediumtext NOT NULL,".
                 "body_toc text NOT NULL,".
                 "owner varchar(50) NOT NULL default '',".
                 "user varchar(50) NOT NULL default '',".
                 "latest enum('Y','N') NOT NULL default 'N',".
                 "handler varchar(30) NOT NULL default 'page',".
                 "comment_on varchar(250) binary NOT NULL default '',".
                 "super_comment_on varchar(250) NOT NULL default '',".
                 "hits int(11) NOT NULL default '0',".
                 "lang varchar(20) NOT NULL default '',".
                 "description varchar(250) NOT NULL default '',".
                 "keywords varchar(250) binary NOT NULL default '',".
                 "PRIMARY KEY  (id),".
                 "FULLTEXT KEY body (body),".
                 "UNIQUE KEY idx_tag (tag),".
                 "KEY idx_supertag (supertag),".
                 "KEY idx_time (time),".
                 "KEY idx_latest (latest),".
                 "KEY idx_comment_on (comment_on),".
                 "KEY idx_super_comment_on (super_comment_on)".
               ") TYPE=MyISAM;";

$table_revisions = "CREATE TABLE ".$config["table_prefix"]."revisions (".
                    "id int(10) unsigned NOT NULL auto_increment,".
                    "tag varchar(250) binary NOT NULL default '',".
                    "supertag varchar(250) binary NOT NULL default '',".
                    "time datetime NOT NULL default '0000-00-00 00:00:00',".
                    "body mediumtext NOT NULL,".
                    "body_r mediumtext NOT NULL,".
                    "owner varchar(50) NOT NULL default '',".
                    "user varchar(50) NOT NULL default '',".
                    "latest enum('Y','N') NOT NULL default 'N',".
                    "handler varchar(30) NOT NULL default 'page',".
                    "comment_on varchar(250) binary NOT NULL default '',".
                    "super_comment_on varchar(250) NOT NULL default '',".
                    "lang varchar(20) NOT NULL default '',".
                    "description varchar(250) NOT NULL default '',".
                    "keywords varchar(250) binary NOT NULL default '',".
                    "PRIMARY KEY  (id),".
                    "KEY idx_tag (tag),".
                    "KEY idx_supertag (supertag),".
                    "KEY idx_time (time),".
                    "KEY idx_latest (latest),".
                    "KEY idx_comment_on (comment_on)".
                  ") TYPE=MyISAM;";

$table_acls = "CREATE TABLE ".$config["table_prefix"]."acls (".
                 "page_tag varchar(250) binary NOT NULL default '',".
                 "supertag varchar(250) NOT NULL default '',".
                 "privilege varchar(20) NOT NULL default '',".
                 "list text NOT NULL,".
                 "PRIMARY KEY  (page_tag,privilege),".
                 "KEY supertag (supertag)".
              ") TYPE=MyISAM";

$table_links = "CREATE TABLE ".$config["table_prefix"]."links (".
                 "from_tag varchar(250) binary NOT NULL default '',".
                 "to_tag varchar(250) binary NOT NULL default '',".
                 "to_supertag VARCHAR(250) NOT NULL,".
                 "KEY from_tag (from_tag,to_tag(78)),".
                 "KEY idx_from (from_tag),".
                 "KEY idx_to (to_tag)".
               ") TYPE=MyISAM";

$table_referrers = "CREATE TABLE ".$config["table_prefix"]."referrers (".
                    "page_tag char(250) binary NOT NULL default '',".
                    "referrer char(150) NOT NULL default '',".
                    "time datetime NOT NULL default '0000-00-00 00:00:00',".
                    "KEY idx_page_tag (page_tag),".
                    "KEY idx_time (time)".
                  ") TYPE=MyISAM";

$table_users = "CREATE TABLE ".$config["table_prefix"]."users (".
                 "name varchar(80) NOT NULL default '',".
                 "password varchar(32) NOT NULL default '',".
                 "email varchar(50) NOT NULL default '',".
                 "motto text NOT NULL,".
                 "revisioncount int(10) unsigned NOT NULL default '20',".
                 "changescount int(10) unsigned NOT NULL default '50',".
                 "doubleclickedit enum('Y','N') NOT NULL default 'Y',".
                 "signuptime datetime NOT NULL default '0000-00-00 00:00:00',".
                 "show_comments enum('Y','N') NOT NULL default 'N',".
                 "bookmarks text NOT NULL,".
                 "lang varchar(20) NOT NULL default '',".
                 "show_spaces enum('Y','N') NOT NULL default 'Y',".
                 "showdatetime enum('Y','N') NOT NULL default 'Y',".
                 "typografica enum('Y','N') NOT NULL default 'Y',".
                 "more text NOT NULL,".
                 "changepassword VARCHAR(100) NOT NULL,".
                 "email_confirm varchar(40) NOT NULL default '',".
                 "PRIMARY KEY  (name),".
                 "KEY idx_name (name),".
                 "KEY idx_signuptime (signuptime)".
               ") TYPE=MyISAM";

$table_pagewatches = "CREATE TABLE ".$config["table_prefix"]."pagewatches (".
                        "id int(10) NOT NULL auto_increment,".
                        "user varchar(80) NOT NULL default '',".
                        "tag varchar(250) binary NOT NULL default '',".
                        "time timestamp(14) NOT NULL,".
                        "PRIMARY KEY  (id)".
                     ") TYPE=MyISAM";

$table_upload = "CREATE TABLE ".$config["table_prefix"]."upload (".
                  "id int(11) NOT NULL auto_increment,".
                  "page_id int(11) NOT NULL default '0',".
                  "filename varchar(250) NOT NULL default '',".
                  "description varchar(250) NOT NULL default '',".
                  "uploaded_dt datetime NOT NULL default '0000-00-00 00:00:00',".
                  "filesize int(11) NOT NULL default '0',".
                  "picture_w int(11) NOT NULL default '0',".
                  "picture_h int(11) NOT NULL default '0',".
                  "file_ext varchar(10) NOT NULL default '',".
                  "user varchar(80) NOT NULL default '0',".
                  "PRIMARY KEY  (id),".
                  "KEY page_id (page_id,filename),".
                  "KEY page_id_2 (page_id,uploaded_dt),".
                  "KEY user_id (user,page_id)".
               ") TYPE=MyISAM";

$table_cache = "CREATE TABLE ".$config["table_prefix"]."cache (".
                  "name VARCHAR( 32 ) NOT NULL,".
                  "method VARCHAR( 20 ) NOT NULL,".
                  "query VARCHAR( 100 ) NOT NULL,".
                  "INDEX (name)".
               ") TYPE=MyISAM";
?>
