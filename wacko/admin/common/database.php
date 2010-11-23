<?php

########################################################
##   Common database backup variables and functions   ##
########################################################

// define db tables
// we really want this up to date
if (isset($tables, $directories) !== true)
{
	$tables	= array(
			$engine->config['table_prefix'].'acl' => array(
				'name'	=> $engine->config['table_prefix'].'acl',
				'where'	=> 'page_id',
				'order'	=> 'page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'bookmark' => array(
				'name'	=> $engine->config['table_prefix'].'bookmark',
				'where'	=> false,
				'order'	=> 'bookmark_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'cache' => array(
				'name'	=> $engine->config['table_prefix'].'cache',
				'where'	=> false,
				'order'	=> 'name',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'config' => array(
				'name'	=> $engine->config['table_prefix'].'config',
				'where'	=> false,
				'order'	=> 'config_id',
				'limit' => 500
			),
			$engine->config['table_prefix'].'group' => array(
				'name'	=> $engine->config['table_prefix'].'group',
				'where'	=> false,
				'order'	=> 'group_name',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'group_member' => array(
				'name'	=> $engine->config['table_prefix'].'group_member',
				'where'	=> false,
				'order'	=> 'group_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'category' => array(
				'name'	=> $engine->config['table_prefix'].'category',
				'where'	=> false,
				'order'	=> 'category_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'category_page' => array(
				'name'	=> $engine->config['table_prefix'].'category_page',
				'where'	=> 'page_id',
				'order'	=> 'page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'link' => array(
				'name'	=> $engine->config['table_prefix'].'link',
				'where'	=> 'from_page_id',
				'order'	=> 'from_page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'log' => array(
				'name'	=> $engine->config['table_prefix'].'log',
				'where'	=> false,
				'order'	=> 'log_time',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'page' => array(
				'name'	=> $engine->config['table_prefix'].'page',
				'where'	=> true,
				'order'	=> 'tag',
				'limit' => 500
			),
			$engine->config['table_prefix'].'watch' => array(
				'name'	=> $engine->config['table_prefix'].'watch',
				'where'	=> 'page_id',
				'order'	=> 'page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'poll' => array(
				'name'	=> $engine->config['table_prefix'].'poll',
				'where'	=> false,
				'order'	=> 'poll_id, v_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'rating' => array(
				'name'	=> $engine->config['table_prefix'].'rating',
				'where'	=> false,
				'order'	=> 'page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'referrer' => array(
				'name'	=> $engine->config['table_prefix'].'referrer',
				'where'	=> 'page_id',
				'order'	=> 'page_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'revision' => array(
				'name'	=> $engine->config['table_prefix'].'revision',
				'where'	=> 'tag',
				'order'	=> 'tag',
				'limit' => 500
			),
			$engine->config['table_prefix'].'upload' => array(
				'name'	=> $engine->config['table_prefix'].'upload',
				'where'	=> false,
				'order'	=> 'upload_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'user' => array(
				'name'	=> $engine->config['table_prefix'].'user',
				'where'	=> false,
				'order'	=> 'user_name',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'user_setting' => array(
				'name'	=> $engine->config['table_prefix'].'user_setting',
				'where'	=> false,
				'order'	=> 'user_id',
				'limit' => 1000
			)
		);

	// define files dirs
	$directories = array(
			$engine->config['cache_dir'].CACHE_FEED_DIR,
			$engine->config['cache_dir'].CACHE_PAGE_DIR,
			$engine->config['cache_dir'].CACHE_SQL_DIR,
			$engine->config['upload_path'],
			$engine->config['upload_path_per_page']
		);
}
else
{
	die('Error in admin module "database.php": unable to register '.
		'common variables: already defined.');
}

// set backup directory
function SetPackDir(&$engine, $time)
{
	// check dir name and create if not exists
	$pack = date('Ymd_His', $time);

	clearstatcache();
	if (is_dir($engine->config['upload_path_backup'].'/'.$pack) !== true)
		 mkdir($engine->config['upload_path_backup'].'/'.$pack);

	chmod($engine->config['upload_path_backup'].'/'.$pack, 0755);

	return $engine->config['upload_path_backup'].'/'.$pack.'/';
}

// delete backup pack from the server
function RemovePack(&$engine, $pack)
{
	$packdir = $engine->config['upload_path_backup'].'/'.$pack.'/';

	// read log
	$log = str_replace("\n", '', file($packdir.BACKUP_FILE_LOG));

	// get subdirs list (in reverse order)
	$subdirs = explode(';', $log[5]);
	rsort($subdirs);

	// remove subdirs contents
	if ($subdirs == true)
	{
		foreach ($subdirs as $subdir)
		{
			$dh = opendir($packdir.$subdir);

			while (false !== ($file = readdir($dh)))
			{
				if (is_file($packdir.$subdir.'/'.$file) === true)
					unlink($packdir.$subdir.'/'.$file);
			}

			closedir($dh);

			// recursively remove subdirs in path
			if (strpos($subdir, '/'))
			{
				while ($pathdir != $subdir)
				{
					$offlen = strpos($subdir, '/', $offset);
					$offset = $offlen + 1;

					if ($offlen > 0)	$pathdir = substr($subdir, 0, $offlen);
					else				$pathdir = $subdir;

					$pathdirs[] = $packdir.$pathdir;
				}

				rsort($pathdirs);

				foreach ($pathdirs as $pathdir)
				{
					@rmdir($pathdir);
				}
			}
			else
			{
				rmdir($packdir.$subdir);
			}
		}
	}

	// remove pack contents and directory
	if (is_dir(rtrim($packdir, '/')) === true)
	{
		$dh = opendir(rtrim($packdir, '/'));

		while (false !== ($file = readdir($dh)))
		{
			if (is_file($packdir.$file) === true)
				unlink($packdir.$file);
		}

		closedir($dh);

		rmdir(rtrim($packdir, '/'));
	}

	return true;
}

// adapted and updated from phpBB 2.x
// construct sql for table recreataion
function GetTable(&$engine, $table, $drop = true)
{
	/***************************************************************************
	*                             admin_db_utilities.php
	*                              -------------------
	*     begin                : Thu May 31, 2001
	*     copyright            : (C) 2001 The phpBB Group
	*     email                : support@phpbb.com
	*
	*
	****************************************************************************/

	/***************************************************************************
	 *
	 *   This program is free software; you can redistribute it and/or modify
	 *   it under the terms of the GNU General Public License as published by
	 *   the Free Software Foundation; either version 2 of the License, or
	 *   (at your option) any later version.
	 *
	 ***************************************************************************/

	/***************************************************************************
	*	We will attempt to create a file based backup of all of the data in the
	*	users WackoWiki database. The resulting file should be able to be imported by
	*	the db_restore.php function, or by using the mysql command_line
	*
	*	Some functions are adapted from the upgrade_20.php script and others
	*	adapted from the unoficial phpMyAdmin 2.2.0.
	***************************************************************************/

	$schema_create	= "";
	$field_query	= "SHOW FIELDS FROM $table";
	$key_query		= "SHOW KEYS FROM $table";
	$collation_db	= $engine->load_single("SELECT @@collation_database");

	if ($drop == true) $schema_create .= "DROP TABLE IF EXISTS $table;\n";

	$schema_create .= "CREATE TABLE IF NOT EXISTS `$table` (\n";

	//
	// Ok lets grab the fields...
	//
	$result = $engine->load_all($field_query);

	foreach ($result as $row)
	{
		$schema_create .= '	`' . $row['Field'] . '` ' . $row['Type'];

		if (!empty($row['Default']) && $row['Type'] != 'timestamp')
			$schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';

		if ($row['Null'] != 'YES')
			$schema_create .= ' NOT NULL';

		if ($row['Extra'] != '')
			$schema_create .= ' ' . $row['Extra'];

		$schema_create .= ",\n";
	}
	//
	// Drop the last ',\n' off ;)
	//
	$schema_create = preg_replace('/,'."\n".'$/', "", $schema_create);

	//
	// Get any Indexed fields from the database...
	//
	$result = $engine->load_all($key_query);

	foreach ($result as $row)
	{
		$kname = $row['Key_name'];

		if (($kname != 'PRIMARY') && ($row['Non_unique'] == 0))
			$kname = "UNIQUE|$kname";
		else if ($kname != 'PRIMARY' && $row['Index_type'] == 'FULLTEXT')
			$kname = "FULLTEXT|$kname";

		if(!is_array($index[$kname]))
			$index[$kname] = array();

		$index[$kname][] = '`'.$row['Column_name'].'`'.( $row['Sub_part'] ? '('.$row['Sub_part'].')' : '' );
	}

	while (list($x, $columns) = @each($index))
	{
		$schema_create .= ", \n";

		if ($x == 'PRIMARY')
			$schema_create .= '	PRIMARY KEY (' . implode($columns, ', ') . ')';
		else if (substr($x,0,6) == 'UNIQUE')
			$schema_create .= '	UNIQUE `' . substr($x,7) . '` (' . implode($columns, ', ') . ')';
		else if (substr($x,0,8) == 'FULLTEXT')
			$schema_create .= '	FULLTEXT KEY `' . substr($x,9) . '` (' . implode($columns, ', ') . ')';
		else
			$schema_create .= "	KEY `$x` (" . implode($columns, ', ') . ')';
	}

	$schema_create .= "\n) ENGINE=MyISAM DEFAULT CHARSET={$collation_db['@@collation_database']};"; // TODO: CHARSET per table

	if (get_magic_quotes_runtime())
		return (stripslashes($schema_create));
	else
		return ($schema_create);
}

// extract and compress table dump into the out file
// $tables var is a tables definition array
function GetData(&$engine, &$tables, $pack, $table, $root = '')
{
	$where = '';
	$tweak = '';

	// sql clauses
	if ($root == true && $tables[$engine->config['table_prefix'].$table]['where'] == true)
	{
		if ($table != $engine->config['table_prefix'].'page')	// not page table
			$where = "WHERE {$tables[$table]['where']} LIKE '".quote($engine->dblink, $root)."%' ";
		else
			$where = "WHERE tag LIKE '".quote($engine->dblink, $root)."%' OR comment_on_id LIKE '".quote($engine->dblink, $root)."%' ";
	}
	$order = "ORDER BY {$tables[$table]['order']} ";
	$limit = "LIMIT %1, {$tables[$table]['limit']} ";

	// tweak
	if ($table == $engine->config['table_prefix'].'page') $tweak = true;

	// check file existance
	clearstatcache();
	$filename = $pack.$table.BACKUP_FILE_DUMP_SUFFIX;
	if (file_exists($filename) === true) unlink($filename);

	// open file with writa access
	$file = gzopen($filename, 'ab'.BACKUP_COMPRESSION_RATE);

	// read table data until it's exhausted
	$r = 0;
	$t = 0;
	while (true == $data = $engine->load_all(
	"SELECT * FROM $table ".
	( $where ? $where : "" ).
	$order.
	str_replace('%1', $r, $limit)))
	{
		$i = 0;
		foreach ($data as $row)
		{
			$r++;	// count rows for LIMIT clause

			// storage optimization tweak: don't save `body_r`
			// and `body_toc` fields for `page` table
			if ($tweak === true)
			{
				$row['body_r']		= '';
				$row['body_toc']	= '';
			}

			// escape divider chars
			$row = str_replace("\\", '\\\\', $row);
			$row = str_replace("\n", '\\n',  $row);
			$row = str_replace("\t", '\\t',  $row);

//			// prepare data
//			foreach ($row as $name => $cell)
//			{
//				$row[$name] = ( $cell == '' ? 'null' : $cell );
//			}

			// construct output
			$contents = implode("\t", $row)."\n";

			// write data to the compressed file
			gzwrite($file, $contents);
			$t++;	// total rows processed
		}
	}
	// save and close file
	gzclose($file);
	chmod($filename, 0644);

	return $t;
}

// store compressed openSpace data files into the backup pack
function GetFiles(&$engine, $pack, $dir, $root)
{
	// set file mask for cluster backup
	if ($root == true && $dir == $engine->config['upload_path_per_page'])
		$tag = '@'.str_replace('/', '@', $engine->npj_translit($root)).'@';

	// create write (backup) subdir or restore path recursively if needed
	if (strpos($dir, '/'))
	{
		while ($subdir != $dir)
		{
			$offlen = strpos($dir, '/', $offset);
			$offset = $offlen + 1;

			if ($offlen > 0)	$subdir = substr($dir, 0, $offlen);
			else				$subdir = $dir;

			if (is_dir($pack.$subdir) === false)
			{
				mkdir($pack.$subdir);
				chmod($pack.$subdir, 0755);
			}
		}
	}
	else
	{
		if (is_dir($pack.$dir) === false)
		{
			mkdir($pack.$dir);
			chmod($pack.$dir, 0755);
		}
	}

	// open read (data) dir and run through all files
	$t = 0;
	if ($dh = opendir($dir))
	{
		while (false !== ($filename = readdir($dh)))
		{
			// for cluster backup process only affected cluster files
			if ($root == true && $tag == true && substr($filename, 0, strlen($tag)) != $tag)
				continue;

			// subdirs skipped
			if (is_dir($dir.'/'.$filename) !== true)
			{
				// open input and output files
				$filep = fopen($dir.'/'.$filename, 'rb');
				$filez = gzopen($pack.$dir.'/'.$filename.BACKUP_FILE_GZIP_SUFFIX, 'ab'.BACKUP_COMPRESSION_RATE);
				$r = 0; // round number

				// compress and write data
				while (true == $data = fread($filep, BACKUP_MEMORY_STEP))
				{
					gzwrite($filez, $data);
					fseek($filep, (++$r) * BACKUP_MEMORY_STEP);
				}

				// close files
				gzclose($filez);
				fclose($filep);
				chmod($pack.$dir.'/'.$filename.BACKUP_FILE_GZIP_SUFFIX, 0644);
				$t++;	// total files processed
			}
		}
		closedir($dh);

		return $t;
	}
	else return false;
}

// restore tables structure
function PutTable(&$engine, $pack)
{
	// read sql data
	$dir = $engine->config['upload_path_backup'].'/'.$pack.'/';
	$sql = explode(';', file_get_contents($dir.BACKUP_FILE_STRUCTURE));

	// perform
	$t = 0;
	foreach ($sql as $instruction)
	{
		$engine->query($instruction);
		$t++;
	}

	return $t;
}

// insert table dump into the database
// $mode - sql instruction to be used (i.e. INSERT or REPLACE)
function PutData(&$engine, $pack, $table, $mode)
{
	// open table dump file with read access
	$filename	= $engine->config['upload_path_backup'].'/'.$pack.'/'.$table.BACKUP_FILE_DUMP_SUFFIX;
	$file		= gzopen($filename, 'rb');

	// read and process file in iterations to the end
	$t = 0;
	while (true == $data = gzread($file, BACKUP_MEMORY_STEP))
	{
		// determine length of the uncut data block
		// and sum it to all bytes read previously
		$clean = strrpos($data, "\n");
		$point += $clean + 1;

		// okay, this is it
		$data = substr($data, 0, $clean);
		$data = explode("\n", $data);
		$i = 0;

		// processing...
		foreach ($data as $row)
		{
			// wipe current data row to stay in low memory boundaries
			$data[$i++] = '';

			$row = explode("\t", $row);
			// unescape divider chars
			$row = str_replace('\\\\', "\\", $row);
			$row = str_replace('\\n',  "\n", $row);
			$row = str_replace('\\t',  "\t", $row);

			// prepare data
			$j = 0;
			foreach ($row as $cell)
			{
				$row[$j++] = "'".quote($engine->dblink, $cell)."'";//( $cell == 'null' ? $cell :  "'".quote($engine->dblink, $cell)."'" );
			}

			// run and count sql query
			$engine->query("$mode INTO $table VALUES ( ".implode(', ', $row)." )");
			$t++;	// rows processed
		}
		// set read pointer to the beginning of the next slack row
		gzseek($file, $point);
	}
	// close file
	gzclose($file);

	return $t;
}

// decompress files and restore them into the filesystem
function PutFiles(&$engine, $pack, $dir, $keep = false)
{
	$packdir = $engine->config['upload_path_backup'].'/'.$pack.'/'.$dir;

	// restore files subdir or full path recursively if needed
	if (strpos($dir, '/'))
	{
		while ($subdir != $dir)
		{
			$offlen = strpos($dir, '/', $offset);
			$offset = $offlen + 1;

			if ($offlen > 0)	$subdir = substr($dir, 0, $offlen);
			else				$subdir = $dir;

			if (is_dir($subdir) === false) mkdir($subdir);
		}
	}
	else
	{
		if (is_dir($dir) === false) mkdir($dir);
	}

	// open backup dir and run through all files
	$total = array();
	if ($dh = opendir($packdir))
	{
		while (false !== ($filename = readdir($dh)))
		{
			$plainfile = substr($filename, 0, strpos($filename, BACKUP_FILE_GZIP_SUFFIX));

			// skip subdirs
			if (is_dir($packdir.'/'.$filename) !== true)
			{
				// handle duplicates in target dir
				if (file_exists($dir.'/'.$plainfile) === true)
				{
					if ($keep == true)
					{
						// ignore
						$total[1]++;
						continue;
					}
					else
					{
						// replace
						unlink($dir.'/'.$plainfile);
					}
				}

				// open input and output files
				$filez = gzopen($packdir.'/'.$filename, 'rb');
				$filep = fopen($dir.'/'.$plainfile, 'wb');
				$r = 0; // round number

				// decompress and write data
				while (true == $data = gzread($filez, BACKUP_MEMORY_STEP))
				{
					fwrite($filep, $data);
					gzseek($filez, (++$r) * BACKUP_MEMORY_STEP);
				}

				// close files
				fclose($filep);
				gzclose($filez);
				chmod($dir.'/'.$plainfile, 0644);
				$total[0]++;
			}
		}
		closedir($dh);

		return $total;
	}
	else return false;
}

?>
