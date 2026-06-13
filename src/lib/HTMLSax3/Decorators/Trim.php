<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Decorators for dealing with parser options
 * @package HTMLSax3
 * @see HTMLSax3::set_option
 */
/**
 * Trims the contents of element data from whitespace at start and end
 * @package HTMLSax3
 * @access protected
 */
class Trim
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	public object $orig_obj;

	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	public string $orig_method;

	/**
	 * Constructs Trim
	 * @param object $orig_obj handler object being decorated
	 * @param string $orig_method original handler method
	 * @access protected
	 */
	public function __construct(object &$orig_obj, string $orig_method)
	{
		$this->orig_obj    = &$orig_obj;
		$this->orig_method = $orig_method;
	}

	/**
	 * Trims the data
	 * @param HTMLSax3 $parser
	 * @param string $data element data
	 * @access protected
	 */
	public function trimData(HTMLSax3 $parser, string $data): void
	{
		$data = trim($data);

		if ($data !== '')
		{
			$this->orig_obj->{$this->orig_method}($parser, $data);
		}
	}
}
