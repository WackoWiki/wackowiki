<?php

class DiffOp_Copy extends DiffOp
{
	public $type = 'copy';

	function __construct($orig, $final = false)
	{
		if (!is_array($final))
		{
			$final = $orig;
		}

		$this->orig = $orig;
		$this->final = $final;
	}

}
