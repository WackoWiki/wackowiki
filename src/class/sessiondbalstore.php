<?php

class SessionDbalStore extends Session
{
	// config options:
	public $cf_dbal_table_name		= 'sessions_pool';
	public $cf_dbal_lock_timeout	= 60;

	private $db;
	private $created	= false;
	private $lock		= null;
	private $id;

	public function __construct(&$db)
	{
		parent::__construct();
		$this->db = & $db;
	}

	protected function store_open($prefix): bool
	{
		if (!$this->created)
		{
			$this->db->sql_query("
				CREATE TABLE IF NOT EXISTS `{$this->cf_dbal_table_name}` (
					`session_id` varchar(32) NOT NULL default '',
					`session_data` blob NOT NULL,
					`session_expire` int(11) NOT NULL default '0',
					PRIMARY KEY  (`session_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8");

			$this->created = true;
		}

		return true;
	}

	protected function store_close(): bool
	{
		if ($this->lock)
		{
			$this->db->sql_query('SELECT RELEASE_LOCK(' . $this->lock . ')');
			$this->lock = null;
		}
		return true;
	}

	protected function store_destroy(): bool
	{
		if ($this->lock)
		{
			$this->db->sql_query('DELETE FROM ' . $this->cf_dbal_table_name . ' WHERE session_id = "' . $this->id . '"');
			$this->store_close();
		}
		return true;
	}

	protected function store_read($id, $create = false)
	{
		if (!$this->lock($id))
		{
			return false;
		}

		$res = $this->db->load_single('
			SELECT
				session_data
			FROM
				' . $this->cf_dbal_table_name . '
			WHERE
				session_id = "' . $id . '" AND
				session_expire > "' . time() . '"
			LIMIT 1
		');

		return $res? $res['session_data'] : ($create? '' : false);
	}

	protected function store_write($id, $text): bool
	{
		if (!$this->lock($id))
		{
			return false;
		}

		$this->db->sql_query('
			INSERT INTO
				' . $this->cf_dbal_table_name . ' (
					session_id,
					session_data,
					session_expire
				)
			VALUES (
				"' . $id . '",
				' . $this->db->q($text) . ',
				"' . (time() + $this->cf_gc_maxlifetime) . '"
			)
			ON DUPLICATE KEY UPDATE
				session_data = VALUES(session_data),
				session_expire = VALUES(session_expire)
		');

		// $this->db->affected_rows - 2 on update, 1 on insert

		return true;
	}

	protected function store_gc()
	{
		$this->db->sql_query('
			DELETE FROM
				' . $this->cf_dbal_table_name . '
			WHERE
				session_expire < "' . time() . '"
		');

		# Ut::dbg('gc', $this->db->affected_rows);

		return $this->db->affected_rows;
	}

	private function lock(&$id): bool
	{
		if ($this->lock && $this->id == $id)
		{
			return true;
		}

		$this->store_close();

		$id = Ut::http64_encode(hash_hmac('sha1', $id, $this->cf_secret, true));

		$lock = '"session_' . $id . '"';

		$res = $this->db->load_single('SELECT GET_LOCK(' . $lock . ', ' . $this->cf_dbal_lock_timeout . ') AS q');

		if (@$res['q'] == 1)
		{
			$this->lock	= $lock;
			$this->id	= $id;

			return true;
		}

		return false;
	}
}
