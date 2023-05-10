<?php
/**
 * Auto-generated class. HTML syntax highlighting
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * https://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @copyright  2004-2006 Andrey Demenev
 * @license	https://www.php.net/license/3_0.txt  PHP License
 * @link	   https://pear.php.net/package/Text_Highlighter
 * @category   Text
 * @package	Text_Highlighter
 * @version	generated from: : html.xml,v 1.1 2007/06/03 02:35:28 ssttoo Exp
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_HTML extends Text_Highlighter
{
	public $_language = 'html';

	/**
	 *  Constructor
	 *
	 * @param array  $options
	 * @access public
	 */
	function __construct($options = [])
	{
		$this->_options = $options;
		$this->_regs = [
			-1 => '/((?i)\\<!--)|((?i)\\<[\\?\\/]?)|((?i)(&)[\\w\\-\\.]+;)/',
			0 => '//',
			1 => '/((?i)(?<=[\\<\\/?])[\\w\\-\\:]+)|((?i)[\\w\\-\\:]+)|((?i)")/',
			2 => '/((?i)(&)[\\w\\-\\.]+;)/',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 0,
			1 => 0,
			2 => 1,
		],
		0 =>
		[
		],
		1 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
		],
		2 =>
		[
		0 => 1,
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'comment',
			1 => 'brackets',
			2 => '',
		],
		0 =>
		[
		],
		1 =>
		[
			0 => '',
			1 => '',
			2 => 'quotes',
		],
		2 =>
		[
		0 => '',
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'comment',
			1 => 'code',
			2 => 'special',
		],
		0 =>
		[
		],
		1 =>
		[
			0 => 'reserved',
			1 => 'var',
			2 => 'string',
		],
		2 =>
		[
		0 => 'special',
		],
		];
		$this->_end = [
			0 => '/(?i)--\\>/',
			1 => '/(?i)[\\/\\?]?\\>/',
			2 => '/(?i)"/',
		];
		$this->_states = [
		-1 =>
		[
			0 => 0,
			1 => 1,
			2 => -1,
		],
		0 =>
		[
		],
		1 =>
		[
			0 => -1,
			1 => -1,
			2 => 2,
		],
		2 =>
		[
			0 => -1,
		],
		];
		$this->_keywords = [
		-1 =>
		[
			0 => -1,
			1 => -1,
			2 =>
			[
			],
		],
		0 =>
		[
		],
		1 =>
		[
		0 =>
		[
		],
		1 =>
		[
		],
		2 => -1,
		],
		2 =>
		[
		0 =>
		[
		],
		],
		];
		$this->_parts = [
		0 =>
		[
		],
		1 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
		],
		2 =>
		[
		0 => NULL,
		],
		];
		$this->_subst = [
		-1 =>
		[
			0 => false,
			1 => false,
			2 => false,
		],
		0 =>
		[
		],
		1 =>
		[
			0 => false,
			1 => false,
			2 => false,
		],
		2 =>
		[
			0 => false,
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
