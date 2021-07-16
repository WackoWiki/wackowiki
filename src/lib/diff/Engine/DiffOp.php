<?php

class DiffOp
{
	var $type;
	var $orig;
	var $final;

	function norig()
	{
		return $this->orig ? count($this->orig) : 0;
	}

	function nfinal()
	{
		return $this->final ? count($this->final) : 0;
	}
}