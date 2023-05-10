<?php
/**
 * Auto-generated class. PHP syntax highlighting
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
 * @version	generated from: : php.xml,v 1.1 2007/06/03 02:35:28 ssttoo Exp
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_PHP extends Text_Highlighter
{
	public $_language = 'php';

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
			-1 => '/((?i)\\<\\?(php|=)?)/',
			0 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)`)|((?mi)\\<\\<\\<[\\x20\\x09]*(\\w+)$)|((?i)\')|((?i)(#|\\/\\/))|((?i)[a-z_]\\w*)|((?i)\\((array|int|integer|string|bool|boolean|object|float|double)\\))|((?i)0[xX][\\da-f]+)|((?i)\\$[a-z_]\\w*)|((?i)\\d\\d*|\\b0\\b)|((?i)0[0-7]+)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))/',
			1 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)`)|((?mi)\\<\\<\\<[\\x20\\x09]*(\\w+)$)|((?i)\')|((?i)(#|\\/\\/))|((?i)[a-z_]\\w*)|((?i)\\((array|int|integer|string|bool|boolean|object|float|double)\\))|((?i)\\?\\>)|((?i)0[xX][\\da-f]+)|((?i)\\$[a-z_]\\w*)|((?i)\\d\\d*|\\b0\\b)|((?i)0[0-7]+)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))/',
			2 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)`)|((?mi)\\<\\<\\<[\\x20\\x09]*(\\w+)$)|((?i)\')|((?i)(#|\\/\\/))|((?i)[a-z_]\\w*)|((?i)\\((array|int|integer|string|bool|boolean|object|float|double)\\))|((?i)0[xX][\\da-f]+)|((?i)\\$[a-z_]\\w*)|((?i)\\d\\d*|\\b0\\b)|((?i)0[0-7]+)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))/',
			3 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)`)|((?mi)\\<\\<\\<[\\x20\\x09]*(\\w+)$)|((?i)\')|((?i)(#|\\/\\/))|((?i)[a-z_]\\w*)|((?i)\\((array|int|integer|string|bool|boolean|object|float|double)\\))|((?i)0[xX][\\da-f]+)|((?i)\\$[a-z_]\\w*)|((?i)\\d\\d*|\\b0\\b)|((?i)0[0-7]+)|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))/',
			4 => '/((?i)\\s@\\w+\\s)|((?i)((https?|ftp):\\/\\/[\\w\\?\\.\\-\\&=\\/%+]+)|(^|[\\s,!?])www\\.\\w+\\.\\w+[\\w\\?\\.\\&=\\/%+]*)|((?i)\\w+[\\.\\w\\-]+@(\\w+[\\.\\w\\-])+)|((?i)\\bnote:)|((?i)\\$\\w+\\s*:.*\\$)/',
			5 => '/((?i)\\\\[\\\\"\'`tnr\\$\\{])|((?i)\\{\\$[a-z_].*\\})|((?i)\\$[a-z_]\\w*)/',
			6 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`)|((?i)\\{\\$[a-z_].*\\})|((?i)\\$[a-z_]\\w*)/',
			7 => '/((?i)\\\\[\\\\"\'`tnr\\$\\{])|((?i)\\{\\$[a-z_].*\\})|((?i)\\$[a-z_]\\w*)/',
			8 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			9 => '/((?i)\\s@\\w+\\s)|((?i)((https?|ftp):\\/\\/[\\w\\?\\.\\-\\&=\\/%+]+)|(^|[\\s,!?])www\\.\\w+\\.\\w+[\\w\\?\\.\\&=\\/%+]*)|((?i)\\w+[\\.\\w\\-]+@(\\w+[\\.\\w\\-])+)|((?i)\\bnote:)|((?i)\\$\\w+\\s*:.*\\$)/',
			10 => '//',
		];
		$this->_counts = [
		-1 =>
		[
		0 => 1,
		],
		0 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 1,
			7 => 0,
			8 => 1,
			9 => 0,
			10 => 1,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 2,
			16 => 5,
		],
		1 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 1,
			7 => 0,
			8 => 1,
			9 => 0,
			10 => 1,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 0,
			16 => 2,
			17 => 5,
		],
		2 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 1,
			7 => 0,
			8 => 1,
			9 => 0,
			10 => 1,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 2,
			16 => 5,
		],
		3 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 1,
			7 => 0,
			8 => 1,
			9 => 0,
			10 => 1,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 2,
			16 => 5,
		],
		4 =>
		[
			0 => 0,
			1 => 3,
			2 => 1,
			3 => 0,
			4 => 0,
		],
		5 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
		],
		6 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
		],
		7 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
		],
		8 =>
		[
		0 => 0,
		],
		9 =>
		[
			0 => 0,
			1 => 3,
			2 => 1,
			3 => 0,
			4 => 0,
		],
		10 =>
		[
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'inlinetags',
		],
		0 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'quotes',
			7 => 'quotes',
			8 => 'comment',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => '',
		],
		1 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'quotes',
			7 => 'quotes',
			8 => 'comment',
			9 => '',
			10 => '',
			11 => 'inlinetags',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => '',
			17 => '',
		],
		2 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'quotes',
			7 => 'quotes',
			8 => 'comment',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => '',
		],
		3 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'quotes',
			7 => 'quotes',
			8 => 'comment',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => '',
		],
		4 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
			4 => '',
		],
		5 =>
		[
			0 => '',
			1 => '',
			2 => '',
		],
		6 =>
		[
			0 => '',
			1 => '',
			2 => '',
		],
		7 =>
		[
			0 => '',
			1 => '',
			2 => '',
		],
		8 =>
		[
		0 => '',
		],
		9 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
			4 => '',
		],
		10 =>
		[
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'code',
		],
		0 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'string',
			7 => 'string',
			8 => 'comment',
			9 => 'identifier',
			10 => 'reserved',
			11 => 'number',
			12 => 'var',
			13 => 'number',
			14 => 'number',
			15 => 'number',
			16 => 'number',
		],
		1 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'string',
			7 => 'string',
			8 => 'comment',
			9 => 'identifier',
			10 => 'reserved',
			11 => 'default',
			12 => 'number',
			13 => 'var',
			14 => 'number',
			15 => 'number',
			16 => 'number',
			17 => 'number',
		],
		2 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'string',
			7 => 'string',
			8 => 'comment',
			9 => 'identifier',
			10 => 'reserved',
			11 => 'number',
			12 => 'var',
			13 => 'number',
			14 => 'number',
			15 => 'number',
			16 => 'number',
		],
		3 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'string',
			7 => 'string',
			8 => 'comment',
			9 => 'identifier',
			10 => 'reserved',
			11 => 'number',
			12 => 'var',
			13 => 'number',
			14 => 'number',
			15 => 'number',
			16 => 'number',
		],
		4 =>
		[
			0 => 'inlinedoc',
			1 => 'url',
			2 => 'url',
			3 => 'inlinedoc',
			4 => 'inlinedoc',
		],
		5 =>
		[
			0 => 'special',
			1 => 'var',
			2 => 'var',
		],
		6 =>
		[
			0 => 'special',
			1 => 'var',
			2 => 'var',
		],
		7 =>
		[
			0 => 'special',
			1 => 'var',
			2 => 'var',
		],
		8 =>
		[
			0 => 'special',
		],
		9 =>
		[
			0 => 'inlinedoc',
			1 => 'url',
			2 => 'url',
			3 => 'inlinedoc',
			4 => 'inlinedoc',
		],
		10 =>
		[
		],
		];
		$this->_end = [
			0 => '/(?i)\\?\\>/',
			1 => '/(?i)\\}/',
			2 => '/(?i)\\)/',
			3 => '/(?i)\\]/',
			4 => '/(?i)\\*\\//',
			5 => '/(?i)"/',
			6 => '/(?i)`/',
			7 => '/(?mi)^%1%;?$/',
			8 => '/(?i)\'/',
			9 => '/(?mi)$|(?=\\?\\>)/',
			10 => '/(?i)\\<\\?(php|=)?/',
		];
		$this->_states = [
		-1 =>
		[
		0 => 0,
		],
		0 =>
		[
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 5,
			5 => 6,
			6 => 7,
			7 => 8,
			8 => 9,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => -1,
		],
		1 =>
		[
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 5,
			5 => 6,
			6 => 7,
			7 => 8,
			8 => 9,
			9 => -1,
			10 => -1,
			11 => 10,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => -1,
			17 => -1,
		],
		2 =>
		[
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 5,
			5 => 6,
			6 => 7,
			7 => 8,
			8 => 9,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => -1,
		],
		3 =>
		[
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 5,
			5 => 6,
			6 => 7,
			7 => 8,
			8 => 9,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => -1,
		],
		4 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
		],
		5 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
		],
		6 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
		],
		7 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
		],
		8 =>
		[
		0 => -1,
		],
		9 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
		],
		10 =>
		[
		],
		];
		$this->_keywords = [
		-1 =>
		[
		0 => -1,
		],
		0 =>
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
			9 =>
			[
				'constants' => '/^(DIRECTORY_SEPARATOR|PATH_SEPARATOR)$/',
				'reserved' => '/^((?i)echo|foreach|else|if|elseif|for|as|while|break|continue|class|const|declare|switch|case|endfor|endswitch|endforeach|endif|array|default|do|enddeclare|eval|exit|die|extends|function|global|include|include_once|require|require_once|isset|empty|list|new|static|unset|var|return|try|catch|final|throw|public|private|protected|abstract|interface|implements|define|__file__|__line__|__class__|__method__|__function__|null|true|false|and|or|xor)$/',
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
		15 =>
		[
		],
		16 =>
		[
		],
		],
		1 =>
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
			9 =>
			[
				'constants' => '/^(DIRECTORY_SEPARATOR|PATH_SEPARATOR)$/',
				'reserved' => '/^((?i)echo|foreach|else|if|elseif|for|as|while|break|continue|class|const|declare|switch|case|endfor|endswitch|endforeach|endif|array|default|do|enddeclare|eval|exit|die|extends|function|global|include|include_once|require|require_once|isset|empty|list|new|static|unset|var|return|try|catch|final|throw|public|private|protected|abstract|interface|implements|define|__file__|__line__|__class__|__method__|__function__|null|true|false|and|or|xor)$/',
			],
		10 =>
		[
		],
		11 => -1,
		12 =>
		[
		],
		13 =>
		[
		],
		14 =>
		[
		],
		15 =>
		[
		],
		16 =>
		[
		],
		17 =>
		[
		],
		],
		2 =>
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
			9 =>
			[
				'constants' => '/^(DIRECTORY_SEPARATOR|PATH_SEPARATOR)$/',
				'reserved' => '/^((?i)echo|foreach|else|if|elseif|for|as|while|break|continue|class|const|declare|switch|case|endfor|endswitch|endforeach|endif|array|default|do|enddeclare|eval|exit|die|extends|function|global|include|include_once|require|require_once|isset|empty|list|new|static|unset|var|return|try|catch|final|throw|public|private|protected|abstract|interface|implements|define|__file__|__line__|__class__|__method__|__function__|null|true|false|and|or|xor)$/',
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
		15 =>
		[
		],
		16 =>
		[
		],
		],
		3 =>
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
			9 =>
			[
				'constants' => '/^(DIRECTORY_SEPARATOR|PATH_SEPARATOR)$/',
				'reserved' => '/^((?i)echo|foreach|else|if|elseif|for|as|while|break|continue|class|const|declare|switch|case|endfor|endswitch|endforeach|endif|array|default|do|enddeclare|eval|exit|die|extends|function|global|include|include_once|require|require_once|isset|empty|list|new|static|unset|var|return|try|catch|final|throw|public|private|protected|abstract|interface|implements|define|__file__|__line__|__class__|__method__|__function__|null|true|false|and|or|xor)$/',
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
		15 =>
		[
		],
		16 =>
		[
		],
		],
		4 =>
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
		],
		5 =>
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
		],
		6 =>
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
		],
		7 =>
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
		],
		8 =>
		[
		0 =>
		[
		],
		],
		9 =>
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
		],
		10 =>
		[
		],
		];
		$this->_parts = [
		0 =>
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
			15 => NULL,
			16 => NULL,
		],
		1 =>
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
			15 => NULL,
			16 => NULL,
			17 => NULL,
		],
		2 =>
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
			15 => NULL,
			16 => NULL,
		],
		3 =>
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
			15 => NULL,
			16 => NULL,
		],
		4 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
			4 => NULL,
		],
		5 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
		],
		6 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
		],
		7 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
		],
		8 =>
		[
			0 => NULL,
		],
		9 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
			4 => NULL,
		],
		10 =>
		[
		],
		];
		$this->_subst = [
		-1 =>
		[
			0 => false,
		],
		0 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => false,
			6 => true,
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
		],
		1 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => false,
			6 => true,
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
		],
		2 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => false,
			6 => true,
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
		],
		3 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => false,
			6 => true,
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
		],
		4 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
		],
		5 =>
		[
			0 => false,
			1 => false,
			2 => false,
		],
		6 =>
		[
			0 => false,
			1 => false,
			2 => false,
		],
		7 =>
		[
			0 => false,
			1 => false,
			2 => false,
		],
		8 =>
		[
			0 => false,
		],
		9 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
		],
		10 =>
		[
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
			'constants' => 'reserved',
			'reserved' => 'reserved',
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
