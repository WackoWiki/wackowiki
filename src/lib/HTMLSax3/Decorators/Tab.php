<?php

namespace HTMLSax3;

/**
 * Breaks up data by tab characters, resulting in additional
 * calls to the data handler
 * @package HTMLSax3
 * @access protected
 */
class Tab
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	public $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	public $orig_method;

	/**
	 * Constructs Tab
	 * @param object $orig_obj handler object being decorated
	 * @param string $orig_method original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj		=& $orig_obj;
		$this->orig_method	= $orig_method;
	}

	/**
	 * Breaks the data up by linefeeds
	 * @param HTMLSax3 $parser
	 * @param string $data element data
	 * @access protected
	 */
	function breakData(&$parser, $data): void
	{
		$data = explode("\t", $data);

		foreach ($data as $chunk)
		{
			$this->orig_obj->{$this->orig_method}($this, $chunk);
		}
	}
}
