<?php

class DiffOp_Add extends DiffOp
{
	public $type = 'add';

	function __construct($lines)
	{
		$this->final = $lines;
		$this->orig = false;
	}

}
