<?php

class DiffOp_Add extends DiffOp
{
	var $type = 'add';

	function __construct($lines)
	{
		$this->final = $lines;
		$this->orig = false;
	}

}