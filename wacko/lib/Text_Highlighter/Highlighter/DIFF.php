<?php
/**
 * Auto-generated class. DIFF syntax highlighting
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @copyright  2004-2006 Andrey Demenev
 * @license	http://www.php.net/license/3_0.txt  PHP License
 * @link	   http://pear.php.net/package/Text_Highlighter
 * @category   Text
 * @package	Text_Highlighter
 * @version	generated from: : diff.xml,v 1.1 2007/06/03 02:35:28 ssttoo Exp
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_DIFF extends Text_Highlighter
{
	var $_language = 'diff';

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
			-1 => '/((?m)^\\\\\\sNo\\snewline.+$)|((?m)^\\-\\-\\-$)|((?m)^(diff\\s+\\-|Only\\s+|Index).*$)|((?m)^(\\-\\-\\-|\\+\\+\\+)\\s.+$)|((?m)^\\*.*$)|((?m)^\\+.*$)|((?m)^!.*$)|((?m)^\\<\\s.*$)|((?m)^\\>\\s.*$)|((?m)^\\d+(\\,\\d+)?[acd]\\d+(,\\d+)?$)|((?m)^\\-.*$)|((?m)^\\+.*$)|((?m)^@@.+@@$)|((?m)^d\\d+\\s\\d+$)|((?m)^a\\d+\\s\\d+$)|((?m)^(\\d+)(,\\d+)?(a)$)|((?m)^(\\d+)(,\\d+)?(c)$)|((?m)^(\\d+)(,\\d+)?(d)$)|((?m)^a(\\d+)(\\s\\d+)?$)|((?m)^c(\\d+)(\\s\\d+)?$)|((?m)^d(\\d+)(\\s\\d+)?$)/',
			0 => '//',
			1 => '//',
			2 => '//',
			3 => '//',
			4 => '//',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 0,
			1 => 0,
			2 => 1,
			3 => 1,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 2,
			10 => 0,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 3,
			16 => 3,
			17 => 3,
			18 => 2,
			19 => 2,
			20 => 2,
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
			4 => '',
			5 => '',
			6 => '',
			7 => '',
			8 => '',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => 'code',
			15 => 'code',
			16 => 'code',
			17 => '',
			18 => 'code',
			19 => 'code',
			20 => '',
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'special',
			1 => 'code',
			2 => 'var',
			3 => 'reserved',
			4 => 'quotes',
			5 => 'string',
			6 => 'inlinedoc',
			7 => 'quotes',
			8 => 'string',
			9 => 'code',
			10 => 'quotes',
			11 => 'string',
			12 => 'code',
			13 => 'code',
			14 => 'var',
			15 => 'string',
			16 => 'inlinedoc',
			17 => 'code',
			18 => 'string',
			19 => 'inlinedoc',
			20 => 'code',
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_end = [
			0 => '/(?m)(?=^[ad]\\d+\\s\\d+)/',
			1 => '/(?m)^(\\.)$/',
			2 => '/(?m)^(\\.)$/',
			3 => '/(?m)^(\\.)$/',
			4 => '/(?m)^(\\.)$/',
		];
		$this->_states = [
		-1 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
			5 => -1,
			6 => -1,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => 0,
			15 => 1,
			16 => 2,
			17 => -1,
			18 => 3,
			19 => 4,
			20 => -1,
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_keywords = [
		-1 =>
		[
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		5 =>
		[
		],
		6 =>
		[
		],
		7 =>
		[
		],
		8 =>
		[
		],
		9 =>
		[
		],
		10 =>
		[
		],
		11 =>
		[
		],
		12 =>
		[
		],
		13 =>
		[
		],
		14 => -1,
		15 => -1,
		16 => -1,
		17 =>
		[
		],
		18 => -1,
		19 => -1,
		20 =>
		[
		],
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_parts = [
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_subst = [
		-1 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => false,
			6 => false,
			7 => false,
			8 => false,
			9 => false,
			10 => false,
			11 => false,
			12 => false,
			13 => false,
			14 => false,
			15 => false,
			16 => false,
			17 => false,
			18 => false,
			19 => false,
			20 => false,
		],
		0 =>
		[
		],
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 =>
		[
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
		];
		$this->_defClass = 'default';
		$this->_checkDefines();
	}

}
