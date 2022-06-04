<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 7                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject toversion 3.0 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Alexander Zhukov <alex@veresk.ru> Original port from Python |
// | Authors: Harry Fuecks <hfuecks@phppatterns.com> Port to PEAR + more  |
// | Authors: Many @ Sitepointforums Advanced PHP Forums                  |
// +----------------------------------------------------------------------+
//
/**
 * Decorators for dealing with parser options
 * @package XML_HTMLSax3
 * @see XML_HTMLSax3::set_option
 */
/**
 * Trims the contents of element data from whitespace at start and end
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Trim
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_Trim
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Trims the data
	 * @param XML_HTMLSax3
	 * @param string element data
	 * @access protected
	 */
	function trimData(&$parser, $data): void
	{
		$data = trim($data);

		if ($data != '')
		{
			$this->orig_obj->{$this->orig_method}($parser, $data);
		}
	}
}
/**
 * Coverts tag names to upper case
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_CaseFolding
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original open handler method
	 * @var string
	 * @access private
	 */
	private string $orig_open_method;
	/**
	 * Original close handler method
	 * @var string
	 * @access private
	 */
	private string $orig_close_method;
	/**
	 * Constructs XML_HTMLSax3_CaseFolding
	 * @param object handler object being decorated
	 * @param string original open handler method
	 * @param string original close handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_open_method, $orig_close_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_open_method = $orig_open_method;
		$this->orig_close_method = $orig_close_method;
	}
	/**
	 * Folds up open tag callbacks
	 * @param XML_HTMLSax3
	 * @param string tag name
	 * @param array tag attributes
	 * @access protected
	 */
	function foldOpen(&$parser, $tag, $attrs= [], $empty = FALSE): void
	{
		$this->orig_obj->{$this->orig_open_method}($parser, strtoupper($tag), $attrs, $empty);
	}
	/**
	 * Folds up close tag callbacks
	 * @param XML_HTMLSax3
	 * @param string tag name
	 * @access protected
	 */
	function foldClose(&$parser, $tag, $empty = FALSE): void
	{
		$this->orig_obj->{$this->orig_close_method}($parser, strtoupper($tag), $empty);
	}
}
/**
 * Breaks up data by linefeed characters, resulting in additional
 * calls to the data handler
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Linefeed
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_LineFeed
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Breaks the data up by linefeeds
	 * @param XML_HTMLSax3
	 * @param string element data
	 * @access protected
	 */
	function breakData(&$parser, $data): void
	{
		$data = explode("\n", $data);

		foreach ($data as $chunk)
		{
			$this->orig_obj->{$this->orig_method}($parser, $chunk);
		}
	}
}
/**
 * Breaks up data by tab characters, resulting in additional
 * calls to the data handler
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Tab
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_Tab
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Breaks the data up by linefeeds
	 * @param XML_HTMLSax3
	 * @param string element data
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
/**
 * Breaks up data by XML entities and parses them with html_entity_decode(),
 * resulting in additional calls to the data handler<br />
 * Requires PHP 4.3.0+
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Entities_Parsed
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_Entities_Parsed
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Breaks the data up by XML entities
	 * @param XML_HTMLSax3
	 * @param string element data
	 * @access protected
	 */
	function breakData(&$parser, $data): void
	{
		$data = preg_split('/(&.+?;)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		foreach ($data as $chunk)
		{
			$chunk = html_entity_decode($chunk, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
			$this->orig_obj->{$this->orig_method}($this, $chunk);
		}
	}
}
/**
 * Breaks up data by XML entities but leaves them unparsed,
 * resulting in additional calls to the data handler<br />
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Entities_Unparsed
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_Entities_Unparsed
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Breaks the data up by XML entities
	 * @param XML_HTMLSax3
	 * @param string element data
	 * @access protected
	 */
	function breakData(&$parser, $data): void
	{
		$data = preg_split('/(&.+?;)/', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		foreach ($data as $chunk)
		{
			$this->orig_obj->{$this->orig_method}($this, $chunk);
		}
	}
}

/**
 * Strips the HTML comment markers or CDATA sections from an escape.
 * If XML_OPTIONS_FULL_ESCAPES is on, this decorator is not used.<br />
 * @package XML_HTMLSax3
 * @access protected
 */
class XML_HTMLSax3_Escape_Stripper
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	private object $orig_obj;
	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	private string $orig_method;
	/**
	 * Constructs XML_HTMLSax3_Entities_Unparsed
	 * @param object handler object being decorated
	 * @param string original handler method
	 * @access protected
	 */
	function __construct(&$orig_obj, $orig_method)
	{
		$this->orig_obj =& $orig_obj;
		$this->orig_method = $orig_method;
	}
	/**
	 * Breaks the data up by XML entities
	 * @param XML_HTMLSax3
	 * @param string element data
	 * @access protected
	 */
	function strip(&$parser, $data): void
	{
		// Check for HTML comments first
		if (str_starts_with($data, '--'))
		{
			$patterns = [
				'/^\-\-/',				// Opening comment: --
				'/\-\-$/',				// Closing comment: --
			];
			$data = preg_replace($patterns, '', $data);
		}
		// Check for XML CDATA sections (note: don't do both!)
		else if (str_starts_with($data, '['))
		{
			$patterns = [
				'/^\[.*CDATA.*\[/s',	// Opening CDATA
				'/\].*\]$/s',			// Closing CDATA
			];
			$data = preg_replace($patterns, '', $data);
		}

		$this->orig_obj->{$this->orig_method}($this, $data);
	}
}
