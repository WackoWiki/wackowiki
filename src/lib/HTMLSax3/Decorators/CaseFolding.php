<?php

namespace HTMLSax3;

/**
 * Coverts tag names to upper case
 * @package HTMLSax3
 * @access protected
 */
class CaseFolding
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	public $orig_obj;
	/**
	 * Original open handler method
	 * @var string
	 * @access private
	 */
	public $orig_open_method;
	/**
	 * Original close handler method
	 * @var string
	 * @access private
	 */
	public $orig_close_method;

	/**
	 * Constructs CaseFolding
	 * @param object $orig_obj handler object being decorated
	 * @param string $orig_open_method original open handler method
	 * @param string $orig_close_method original close handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_open_method, $orig_close_method)
	{
		$this->orig_obj				=& $orig_obj;
		$this->orig_open_method		= $orig_open_method;
		$this->orig_close_method	= $orig_close_method;
	}

	/**
	 * Folds up open tag callbacks
	 * @param HTMLSax3 $parser
	 * @param string $tag tag name
	 * @param array $attrs tag attributes
	 * @param bool $empty
	 * @access protected
	 */
	function foldOpen(&$parser, $tag, $attrs = [], $empty = false): void
	{
		$this->orig_obj->{$this->orig_open_method}($parser, strtoupper($tag), $attrs, $empty);
	}

	/**
	 * Folds up close tag callbacks
	 * @param HTMLSax3 $parser
	 * @param string $tag tag name
	 * @param bool $empty
	 * @access protected
	 */
	function foldClose(&$parser, $tag, $empty = false): void
	{
		$this->orig_obj->{$this->orig_close_method}($parser, strtoupper($tag), $empty);
	}
}
