<?php
/**
 * Auto-generated class. PYTHON syntax highlighting
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
 * @version	generated from: : python.xml,v 1.1 2007/06/03 02:35:28 ssttoo Exp
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_PYTHON extends Text_Highlighter
{
	public $_language = 'python';

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
			-1 => '/((?i)\'\'\')|((?i)""")|((?i)")|((?i)\')|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*(?=\\s*\\())|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)((\\d*\\.\\d+)|(\\d+\\.\\d*)|(\\d+))j)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)\\d+l?|\\b0l?\\b)|((?i)0[xX][\\da-f]+l?)|((?i)0[0-7]+l?)|((?i)#.+)/',
			0 => '/((?i)\\\\.)/',
			1 => '/((?i)\\\\.)/',
			2 => '/((?i)\\\\.)/',
			3 => '/((?i)\\\\.)/',
			4 => '/((?i)\'\'\')|((?i)""")|((?i)")|((?i)\')|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*(?=\\s*\\())|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)((\\d*\\.\\d+)|(\\d+\\.\\d*)|(\\d+))j)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)\\d+l?|\\b0l?\\b)|((?i)0[xX][\\da-f]+l?)|((?i)0[0-7]+l?)|((?i)#.+)/',
			5 => '/((?i)\'\'\')|((?i)""")|((?i)")|((?i)\')|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*(?=\\s*\\())|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)((\\d*\\.\\d+)|(\\d+\\.\\d*)|(\\d+))j)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)\\d+l?|\\b0l?\\b)|((?i)0[xX][\\da-f]+l?)|((?i)0[0-7]+l?)|((?i)#.+)/',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 5,
			9 => 4,
			10 => 2,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
		],
		0 =>
		[
			0 => 0,
		],
		1 =>
		[
			0 => 0,
		],
		2 =>
		[
			0 => 0,
		],
		3 =>
		[
			0 => 0,
		],
		4 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 5,
			9 => 4,
			10 => 2,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
		],
		5 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 5,
			9 => 4,
			10 => 2,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'quotes',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'brackets',
			5 => 'brackets',
			6 => '',
			7 => '',
			8 => '',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
		],
		0 =>
		[
			0 => '',
		],
		1 =>
		[
			0 => '',
		],
		2 =>
		[
			0 => '',
		],
		3 =>
		[
			0 => '',
		],
		4 =>
		[
			0 => 'quotes',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'brackets',
			5 => 'brackets',
			6 => '',
			7 => '',
			8 => '',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
		],
		5 =>
		[
			0 => 'quotes',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'brackets',
			5 => 'brackets',
			6 => '',
			7 => '',
			8 => '',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'string',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'code',
			5 => 'code',
			6 => 'identifier',
			7 => 'identifier',
			8 => 'number',
			9 => 'number',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'comment',
		],
		0 =>
		[
			0 => 'special',
		],
		1 =>
		[
			0 => 'special',
		],
		2 =>
		[
			0 => 'special',
		],
		3 =>
		[
			0 => 'special',
		],
		4 =>
		[
			0 => 'string',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'code',
			5 => 'code',
			6 => 'identifier',
			7 => 'identifier',
			8 => 'number',
			9 => 'number',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'comment',
		],
		5 =>
		[
			0 => 'string',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'code',
			5 => 'code',
			6 => 'identifier',
			7 => 'identifier',
			8 => 'number',
			9 => 'number',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'comment',
		],
		];
		$this->_end = [
			0 => '/(?i)\'\'\'/',
			1 => '/(?i)"""/',
			2 => '/(?i)"/',
			3 => '/(?i)\'/',
			4 => '/(?i)\\)/',
			5 => '/(?i)\\]/',
		];
		$this->_states = [
		-1 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => -1,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
		],
		0 =>
		[
			0 => -1,
		],
		1 =>
		[
			0 => -1,
		],
		2 =>
		[
			0 => -1,
		],
		3 =>
		[
			0 => -1,
		],
		4 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => -1,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
		],
		5 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => -1,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
		],
		];
		$this->_keywords = [
		-1 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
			5 => -1,
			6 =>
		[
			'builtin' => '/^(__import__|abs|apply|basestring|bool|buffer|callable|chr|classmethod|cmp|coerce|compile|complex|delattr|dict|dir|divmod|enumerate|eval|execfile|file|filter|float|getattr|globals|hasattr|hash|help|hex|id|input|int|intern|isinstance|issubclass|iter|len|list|locals|long|map|max|min|object|oct|open|ord|pow|property|range|raw_input|reduce|reload|repr|round|setattr|slice|staticmethod|sum|super|str|tuple|type|unichr|unicode|vars|xrange|zip)$/',
		],
		7 =>
		[
			'reserved' => '/^(and|del|for|is|raise|assert|elif|from|lambda|return|break|else|global|not|try|class|except|if|or|while|continue|exec|import|pass|yield|def|finally|in|print|False|True|None|NotImplemented|Ellipsis|Exception|SystemExit|StopIteration|StandardError|KeyboardInterrupt|ImportError|EnvironmentError|IOError|OSError|WindowsError|EOFError|RuntimeError|NotImplementedError|NameError|UnboundLocalError|AttributeError|SyntaxError|IndentationError|TabError|TypeError|AssertionError|LookupError|IndexError|KeyError|ArithmeticError|OverflowError|ZeroDivisionError|FloatingPointError|ValueError|UnicodeError|UnicodeEncodeError|UnicodeDecodeError|UnicodeTranslateError|ReferenceError|SystemError|MemoryError|Warning|UserWarning|DeprecationWarning|PendingDeprecationWarning|SyntaxWarning|OverflowWarning|RuntimeWarning|FutureWarning)$/',
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
		14 =>
		[
		],
		],
		0 =>
		[
		0 =>
		[
		],
		],
		1 =>
		[
		0 =>
		[
		],
		],
		2 =>
		[
		0 =>
		[
		],
		],
		3 =>
		[
		0 =>
		[
		],
		],
		4 =>
		[
		0 => -1,
		1 => -1,
		2 => -1,
		3 => -1,
		4 => -1,
		5 => -1,
		6 =>
		[
			'builtin' => '/^(__import__|abs|apply|basestring|bool|buffer|callable|chr|classmethod|cmp|coerce|compile|complex|delattr|dict|dir|divmod|enumerate|eval|execfile|file|filter|float|getattr|globals|hasattr|hash|help|hex|id|input|int|intern|isinstance|issubclass|iter|len|list|locals|long|map|max|min|object|oct|open|ord|pow|property|range|raw_input|reduce|reload|repr|round|setattr|slice|staticmethod|sum|super|str|tuple|type|unichr|unicode|vars|xrange|zip)$/',
		],
		7 =>
		[
			'reserved' => '/^(and|del|for|is|raise|assert|elif|from|lambda|return|break|else|global|not|try|class|except|if|or|while|continue|exec|import|pass|yield|def|finally|in|print|False|True|None|NotImplemented|Ellipsis|Exception|SystemExit|StopIteration|StandardError|KeyboardInterrupt|ImportError|EnvironmentError|IOError|OSError|WindowsError|EOFError|RuntimeError|NotImplementedError|NameError|UnboundLocalError|AttributeError|SyntaxError|IndentationError|TabError|TypeError|AssertionError|LookupError|IndexError|KeyError|ArithmeticError|OverflowError|ZeroDivisionError|FloatingPointError|ValueError|UnicodeError|UnicodeEncodeError|UnicodeDecodeError|UnicodeTranslateError|ReferenceError|SystemError|MemoryError|Warning|UserWarning|DeprecationWarning|PendingDeprecationWarning|SyntaxWarning|OverflowWarning|RuntimeWarning|FutureWarning)$/',
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
		14 =>
		[
		],
		],
		5 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
			5 => -1,
			6 =>
		[
			'builtin' => '/^(__import__|abs|apply|basestring|bool|buffer|callable|chr|classmethod|cmp|coerce|compile|complex|delattr|dict|dir|divmod|enumerate|eval|execfile|file|filter|float|getattr|globals|hasattr|hash|help|hex|id|input|int|intern|isinstance|issubclass|iter|len|list|locals|long|map|max|min|object|oct|open|ord|pow|property|range|raw_input|reduce|reload|repr|round|setattr|slice|staticmethod|sum|super|str|tuple|type|unichr|unicode|vars|xrange|zip)$/',
		],
		7 =>
		[
			'reserved' => '/^(and|del|for|is|raise|assert|elif|from|lambda|return|break|else|global|not|try|class|except|if|or|while|continue|exec|import|pass|yield|def|finally|in|print|False|True|None|NotImplemented|Ellipsis|Exception|SystemExit|StopIteration|StandardError|KeyboardInterrupt|ImportError|EnvironmentError|IOError|OSError|WindowsError|EOFError|RuntimeError|NotImplementedError|NameError|UnboundLocalError|AttributeError|SyntaxError|IndentationError|TabError|TypeError|AssertionError|LookupError|IndexError|KeyError|ArithmeticError|OverflowError|ZeroDivisionError|FloatingPointError|ValueError|UnicodeError|UnicodeEncodeError|UnicodeDecodeError|UnicodeTranslateError|ReferenceError|SystemError|MemoryError|Warning|UserWarning|DeprecationWarning|PendingDeprecationWarning|SyntaxWarning|OverflowWarning|RuntimeWarning|FutureWarning)$/',
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
		14 =>
		[
		],
		],
		];
		$this->_parts = [
			0 =>
		[
			0 => NULL,
		],
		1 =>
		[
			0 => NULL,
		],
		2 =>
		[
			0 => NULL,
		],
		3 =>
		[
			0 => NULL,
		],
		4 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
			4 => NULL,
			5 => NULL,
			6 => NULL,
			7 => NULL,
			8 => NULL,
			9 => NULL,
			10 => NULL,
			11 => NULL,
			12 => NULL,
			13 => NULL,
			14 => NULL,
		],
		5 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
			4 => NULL,
			5 => NULL,
			6 => NULL,
			7 => NULL,
			8 => NULL,
			9 => NULL,
			10 => NULL,
			11 => NULL,
			12 => NULL,
			13 => NULL,
			14 => NULL,
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
		],
		0 =>
		[
			0 => false,
		],
		1 =>
		[
			0 => false,
		],
		2 =>
		[
			0 => false,
		],
		3 =>
		[
			0 => false,
		],
		4 =>
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
		],
		5 =>
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
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
			'builtin' => 'builtin',
			'reserved' => 'reserved',
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
