<?php

if (!defined('IN_WACKO'))
{
	exit;
}

interface DbInterface
{
	public function __construct(&$config);
	public function query($query);
	public function quote($string);
	public function free_result($results);
	public function fetch_assoc($results);
	public function affected_rows($results);
}
