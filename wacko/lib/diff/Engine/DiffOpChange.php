<?php

class DiffOp_Change extends DiffOp
{
	var $type = 'change';

	function __construct($orig, $final)
	{
		$this->orig = $orig;
		$this->final = $final;
	}

}