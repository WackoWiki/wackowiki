<?php

class DiffOp_Delete extends DiffOp
{
	var $type = 'delete';

	function __construct($lines)
	{
		$this->orig = $lines;
		$this->final = false;
	}

}