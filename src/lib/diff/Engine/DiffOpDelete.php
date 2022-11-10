<?php

class DiffOp_Delete extends DiffOp
{
	public $type = 'delete';

	function __construct($lines)
	{
		$this->orig = $lines;
		$this->final = false;
	}

}
