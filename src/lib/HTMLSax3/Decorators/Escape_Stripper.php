<?php

namespace HTMLSax3;

/**
 * Strips the HTML comment markers or CDATA sections from an escape.
 * If XML_OPTIONS_FULL_ESCAPES is on, this decorator is not used.<br />
 * @package HTMLSax3
 * @access protected
 */
class Escape_Stripper
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
	 * Constructs Escape_Stripper
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
	 * Breaks the data up by XML entities
	 * @param HTMLSax3 $parser
	 * @param string $data element data
	 * @access protected
	 */
	function strip(&$parser, $data): void
	{
		// Check for HTML comments first
		if (str_starts_with($data, '--'))
		{
			$patterns = [
				'/^\-\-/',					// Opening comment: --
				'/\-\-$/',					// Closing comment: --
			];
			$data = preg_replace($patterns, '', $data);

			// Check for XML CDATA sections (note: don't do both!)
		}
		else if (str_starts_with($data, '['))
		{
			$patterns = [
				'/^\[.*CDATA.*\[/s',		// Opening CDATA
				'/\].*\]$/s',				// Closing CDATA
			];
			$data = preg_replace($patterns, '', $data);
		}

		$this->orig_obj->{$this->orig_method}($this, $data);
	}
}
