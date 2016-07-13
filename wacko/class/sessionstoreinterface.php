<?php

interface SessionStoreInterface
{
	//public function __construct(); -- do not forget to run parent's constructor!
	//{
	//	parent::__construct();
	//}
	public function store_open($session_name);
	public function store_close();
	public function store_destroy();
	public function store_read($id, $create);
	public function store_write($id, $text);
	public function store_gc();
	public function store_generate_id();
	public function store_validate_id($wouldbeid);
}
