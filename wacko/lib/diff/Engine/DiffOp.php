<?php

class DiffOp
{
	var $type;
	var $orig;
	var $final;

	function norig()
	{
		return $this->orig ? sizeof($this->orig) : 0;
	}

	function nfinal()
	{
		return $this->final ? sizeof($this->final) : 0;
	}
}