<?php

########################################################
##   Common database backup variables and functions   ##
########################################################

// define db tables
// we really want this up to date
if (isset($tables, $directories) !== true)
{
	$tables	= array(
			$engine->config['table_prefix'].'acls' => array(
				'name'	=> $engine->config['table_prefix'].'acls',
				'where'	=> 'tag',
				'order'	=> 'tag',
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
				'order'	=> 'id',
				'limit' => 1
			),
			$engine->config['table_prefix'].'groups' => array(
				'name'	=> $engine->config['table_prefix'].'groups',
				'where'	=> false,
				'order'	=> 'name',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'keywords' => array(
				'name'	=> $engine->config['table_prefix'].'keywords',
				'where'	=> false,
				'order'	=> 'id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'keywordspages' => array(
				'name'	=> $engine->config['table_prefix'].'keywordspages',
				'where'	=> 'tag',
				'order'	=> 'tag',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'links' => array(
				'name'	=> $engine->config['table_prefix'].'links',
				'where'	=> 'from_tag',
				'order'	=> 'from_tag',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'log' => array(
				'name'	=> $engine->config['table_prefix'].'log',
				'where'	=> false,
				'order'	=> 'time',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'pages' => array(
				'name'	=> $engine->config['table_prefix'].'pages',
				'where'	=> true,
				'order'	=> 'tag',
				'limit' => 500
			),
			$engine->config['table_prefix'].'watches' => array(
				'name'	=> $engine->config['table_prefix'].'watches',
				'where'	=> 'tag',
				'order'	=> 'tag',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'polls' => array(
				'name'	=> $engine->config['table_prefix'].'polls',
				'where'	=> false,
				'order'	=> 'id, v_id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'rating' => array(
				'name'	=> $engine->config['table_prefix'].'rating',
				'where'	=> false,
				'order'	=> 'id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'referrers' => array(
				'name'	=> $engine->config['table_prefix'].'referrers',
				'where'	=> 'page_tag',
				'order'	=> 'page_tag',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'revisions' => array(
				'name'	=> $engine->config['table_prefix'].'revisions',
				'where'	=> 'tag',
				'order'	=> 'tag',
				'limit' => 500
			),
			$engine->config['table_prefix'].'signed' => array(
				'name'	=> $engine->config['table_prefix'].'signed',
				'where'	=> false,
				'order'	=> 'id',
				'limit' => 500
			),
			$engine->config['table_prefix'].'upload' => array(
				'name'	=> $engine->config['table_prefix'].'upload',
				'where'	=> false,
				'order'	=> 'id',
				'limit' => 1000
			),
			$engine->config['table_prefix'].'users' => array(
				'name'	=> $engine->config['table_prefix'].'users',
				'where'	=> false,
				'order'	=> 'name',
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

?>