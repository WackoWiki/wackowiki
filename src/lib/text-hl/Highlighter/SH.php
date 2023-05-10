<?php
/**
 * Auto-generated class. SH syntax highlighting
 *
 * This highlighter is EXPERIMENTAL. It may work incorrectly.
 *	   It is a crude hack of the perl syntax, which itself wasn't so good.
 *	   But this seems to work OK.
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
 * @version	generated from: : sh.xml,v 1.2 2007/06/14 00:15:50 ssttoo Exp
 * @author Noah Spurrier <noah@noah.org>
 *
 */

class Text_Highlighter_SH extends Text_Highlighter
{
	public $_language = 'sh';

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
			-1 => '/((?m)^(#!)(.*))|(\\{)|(\\()|(\\[)|((use)\\s+([\\w:]*))|((?Us)\\b(q[wq]\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|((?Us)\\b(q\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|(#.*)|((?x)(s|tr) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2)((\\\\.|[^\\\\])*?)(\\2[ecgimosx]*))|((?x)(m) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2[ecgimosx]*))|( \\/)|(\\$#?[1-9\'`@!])|((?i)(\\$#?|[@%*])([a-z1-9_]+::)*([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)(\\{)([a-z1-9]+)(\\}))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(`)|(\')|(")|((?i)[a-z_]\\w*)|(\\d*\\.?\\d+)/',
			0 => '/((?m)^(#!)(.*))|(\\{)|(\\()|(\\[)|((use)\\s+([\\w:]*))|((?Us)\\b(q[wq]\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|((?Us)\\b(q\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|(#.*)|((?x)(s|tr) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2)((\\\\.|[^\\\\])*?)(\\2[ecgimosx]*))|((?x)(m) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2[ecgimosx]*))|( \\/)|(\\$#?[1-9\'`@!])|((?i)(\\$#?|[@%*])([a-z1-9_]+::)*([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)(\\{)([a-z1-9]+)(\\}))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(`)|(\')|(")|((?i)[a-z_]\\w*)|(\\d*\\.?\\d+)/',
			1 => '/((?m)^(#!)(.*))|(\\{)|(\\()|(\\[)|((use)\\s+([\\w:]*))|((?Us)\\b(q[wq]\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|((?Us)\\b(q\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|(#.*)|((?x)(s|tr) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2)((\\\\.|[^\\\\])*?)(\\2[ecgimosx]*))|((?x)(m) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2[ecgimosx]*))|( \\/)|((?i)([a-z1-9_]+)(\\s*=>))|(\\$#?[1-9\'`@!])|((?i)(\\$#?|[@%*])([a-z1-9_]+::)*([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)(\\{)([a-z1-9]+)(\\}))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(`)|(\')|(")|((?i)[a-z_]\\w*)|(\\d*\\.?\\d+)/',
			2 => '/((?m)^(#!)(.*))|(\\{)|(\\()|(\\[)|((use)\\s+([\\w:]*))|((?Us)\\b(q[wq]\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|((?Us)\\b(q\\s*((\\{)|(\\()|(\\[)|(\\<)|([\\W\\S])))(?=(.*)((?(3)\\})(?(4)\\))(?(5)\\])(?(6)\\>)(?(7)\\7))))|(#.*)|((?x)(s|tr) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2)((\\\\.|[^\\\\])*?)(\\2[ecgimosx]*))|((?x)(m) ([|#~`!@$%^&*-+=\\\\;:\'",.\\/?])  ((\\\\.|[^\\\\])*?) (\\2[ecgimosx]*))|( \\/)|(\\$#?[1-9\'`@!])|((?i)(\\$#?|[@%*])([a-z1-9_]+::)*([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)(\\{)([a-z1-9]+)(\\}))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(`)|(\')|(")|((?i)[a-z_]\\w*)|(\\d*\\.?\\d+)/',
			3 => '/(\\$#?[1-9\'`@!])|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(\\\\[\\\\"\'`tnr\\$\\{@])/',
			4 => '/(\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			5 => '/(\\\\\\/)/',
			6 => '/(\\$#?[1-9\'`@!])|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			7 => '/(\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			8 => '/(\\$#?[1-9\'`@!])|((?i)\\$([a-z1-9_]+|\\^(?-i)[A-Z]?(?i)))|((?i)[\\$@%]#?\\{[a-z1-9]+\\})|(\\\\[\\\\"\'`tnr\\$\\{@])/',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 2,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 2,
			5 => 9,
			6 => 9,
			7 => 0,
			8 => 8,
			9 => 5,
			10 => 0,
			11 => 0,
			12 => 3,
			13 => 1,
			14 => 3,
			15 => 0,
			16 => 0,
			17 => 0,
			18 => 0,
			19 => 0,
			20 => 0,
		],
		0 =>
		[
			0 => 2,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 2,
			5 => 9,
			6 => 9,
			7 => 0,
			8 => 8,
			9 => 5,
			10 => 0,
			11 => 0,
			12 => 3,
			13 => 1,
			14 => 3,
			15 => 0,
			16 => 0,
			17 => 0,
			18 => 0,
			19 => 0,
			20 => 0,
		],
		1 =>
		[
			0 => 2,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 2,
			5 => 9,
			6 => 9,
			7 => 0,
			8 => 8,
			9 => 5,
			10 => 0,
			11 => 2,
			12 => 0,
			13 => 3,
			14 => 1,
			15 => 3,
			16 => 0,
			17 => 0,
			18 => 0,
			19 => 0,
			20 => 0,
			21 => 0,
		],
		2 =>
		[
			0 => 2,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 2,
			5 => 9,
			6 => 9,
			7 => 0,
			8 => 8,
			9 => 5,
			10 => 0,
			11 => 0,
			12 => 3,
			13 => 1,
			14 => 3,
			15 => 0,
			16 => 0,
			17 => 0,
			18 => 0,
			19 => 0,
			20 => 0,
		],
		3 =>
		[
			0 => 0,
			1 => 1,
			2 => 0,
			3 => 0,
		],
		4 =>
		[
			0 => 0,
		],
		5 =>
		[
			0 => 0,
		],
		6 =>
		[
			0 => 0,
			1 => 1,
			2 => 0,
			3 => 0,
		],
		7 =>
		[
			0 => 0,
		],
		8 =>
		[
			0 => 0,
			1 => 1,
			2 => 0,
			3 => 0,
		],
		];
		$this->_delim = [
			-1 =>
		[
			0 => '',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'brackets',
			4 => '',
			5 => 'quotes',
			6 => 'quotes',
			7 => '',
			8 => '',
			9 => '',
			10 => 'quotes',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => 'quotes',
			17 => 'quotes',
			18 => 'quotes',
			19 => '',
			20 => '',
		],
		0 =>
		[
			0 => '',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'brackets',
			4 => '',
			5 => 'quotes',
			6 => 'quotes',
			7 => '',
			8 => '',
			9 => '',
			10 => 'quotes',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => 'quotes',
			17 => 'quotes',
			18 => 'quotes',
			19 => '',
			20 => '',
		],
		1 =>
		[
			0 => '',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'brackets',
			4 => '',
			5 => 'quotes',
			6 => 'quotes',
			7 => '',
			8 => '',
			9 => '',
			10 => 'quotes',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => '',
			17 => 'quotes',
			18 => 'quotes',
			19 => 'quotes',
			20 => '',
			21 => '',
		],
		2 =>
		[
			0 => '',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'brackets',
			4 => '',
			5 => 'quotes',
			6 => 'quotes',
			7 => '',
			8 => '',
			9 => '',
			10 => 'quotes',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => '',
			16 => 'quotes',
			17 => 'quotes',
			18 => 'quotes',
			19 => '',
			20 => '',
		],
		3 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
		],
		4 =>
		[
			0 => '',
		],
		5 =>
		[
			0 => '',
		],
		6 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
		],
		7 =>
		[
			0 => '',
		],
		8 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'special',
			1 => 'code',
			2 => 'code',
			3 => 'code',
			4 => 'special',
			5 => 'string',
			6 => 'string',
			7 => 'comment',
			8 => 'string',
			9 => 'string',
			10 => 'string',
			11 => 'var',
			12 => 'var',
			13 => 'var',
			14 => 'var',
			15 => 'var',
			16 => 'string',
			17 => 'string',
			18 => 'string',
			19 => 'identifier',
			20 => 'number',
		],
		0 =>
		[
			0 => 'special',
			1 => 'code',
			2 => 'code',
			3 => 'code',
			4 => 'special',
			5 => 'string',
			6 => 'string',
			7 => 'comment',
			8 => 'string',
			9 => 'string',
			10 => 'string',
			11 => 'var',
			12 => 'var',
			13 => 'var',
			14 => 'var',
			15 => 'var',
			16 => 'string',
			17 => 'string',
			18 => 'string',
			19 => 'identifier',
			20 => 'number',
		],
		1 =>
		[
			0 => 'special',
			1 => 'code',
			2 => 'code',
			3 => 'code',
			4 => 'special',
			5 => 'string',
			6 => 'string',
			7 => 'comment',
			8 => 'string',
			9 => 'string',
			10 => 'string',
			11 => 'string',
			12 => 'var',
			13 => 'var',
			14 => 'var',
			15 => 'var',
			16 => 'var',
			17 => 'string',
			18 => 'string',
			19 => 'string',
			20 => 'identifier',
			21 => 'number',
		],
		2 =>
		[
			0 => 'special',
			1 => 'code',
			2 => 'code',
			3 => 'code',
			4 => 'special',
			5 => 'string',
			6 => 'string',
			7 => 'comment',
			8 => 'string',
			9 => 'string',
			10 => 'string',
			11 => 'var',
			12 => 'var',
			13 => 'var',
			14 => 'var',
			15 => 'var',
			16 => 'string',
			17 => 'string',
			18 => 'string',
			19 => 'identifier',
			20 => 'number',
		],
		3 =>
		[
			0 => 'var',
			1 => 'var',
			2 => 'var',
			3 => 'special',
		],
		4 =>
		[
			0 => 'special',
		],
		5 =>
		[
			0 => 'string',
		],
		6 =>
		[
			0 => 'var',
			1 => 'var',
			2 => 'var',
			3 => 'special',
		],
		7 =>
		[
			0 => 'special',
		],
		8 =>
		[
			0 => 'var',
			1 => 'var',
			2 => 'var',
			3 => 'special',
		],
		];
		$this->_end = [
			0 => '/\\}/',
			1 => '/\\)/',
			2 => '/\\]/',
			3 => '/%b2%/',
			4 => '/%b2%/',
			5 => '/\\/[cgimosx]*/',
			6 => '/`/',
			7 => '/\'/',
			8 => '/"/',
		];
		$this->_states = [
		-1 =>
		[
			0 => -1,
			1 => 0,
			2 => 1,
			3 => 2,
			4 => -1,
			5 => 3,
			6 => 4,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => 5,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => 6,
			17 => 7,
			18 => 8,
			19 => -1,
			20 => -1,
		],
		0 =>
		[
			0 => -1,
			1 => 0,
			2 => 1,
			3 => 2,
			4 => -1,
			5 => 3,
			6 => 4,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => 5,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => 6,
			17 => 7,
			18 => 8,
			19 => -1,
			20 => -1,
		],
		1 =>
		[
			0 => -1,
			1 => 0,
			2 => 1,
			3 => 2,
			4 => -1,
			5 => 3,
			6 => 4,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => 5,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => -1,
			17 => 6,
			18 => 7,
			19 => 8,
			20 => -1,
			21 => -1,
		],
		2 =>
		[
			0 => -1,
			1 => 0,
			2 => 1,
			3 => 2,
			4 => -1,
			5 => 3,
			6 => 4,
			7 => -1,
			8 => -1,
			9 => -1,
			10 => 5,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => -1,
			16 => 6,
			17 => 7,
			18 => 8,
			19 => -1,
			20 => -1,
		],
		3 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
		],
		4 =>
		[
			0 => -1,
		],
		5 =>
		[
			0 => -1,
		],
		6 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
		],
		7 =>
		[
			0 => -1,
		],
		8 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
		],
		];
		$this->_keywords = [
		-1 =>
		[
		0 =>
		[
		],
		1 => -1,
		2 => -1,
		3 => -1,
		4 =>
		[
		],
		5 => -1,
		6 => -1,
		7 =>
		[
		],
		8 =>
		[
		],
		9 =>
		[
		],
		10 => -1,
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
		16 => -1,
		17 => -1,
		18 => -1,
		19 =>
		[
			'reserved' => '/^(cd|cp|rm|echo|printf|exit|cut|join|comm|fmt|grep|egrep|fgrep|sed|awk|yes|false|true|test|expr|tee|basename|dirname|pathchk|pwd|stty|tty|env|printenv|id|logname|whoami|groups|users|who|date|uname|hostname|chroot|nice|nohup|sleep|factor|seq|getopt|getopts|options|shift)$/',
			'flowcontrol' => '/^(if|fi|then|else|elif|case|esac|while|done|for|in|function|until|do|select|time|read|set)$/',
		],
		20 =>
		[
		],
		],
		0 =>
		[
		0 =>
		[
		],
		1 => -1,
		2 => -1,
		3 => -1,
		4 =>
		[
		],
		5 => -1,
		6 => -1,
		7 =>
		[
		],
		8 =>
		[
		],
		9 =>
		[
		],
		10 => -1,
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
		16 => -1,
		17 => -1,
		18 => -1,
		19 =>
		[
			'reserved' => '/^(cd|cp|rm|echo|printf|exit|cut|join|comm|fmt|grep|egrep|fgrep|sed|awk|yes|false|true|test|expr|tee|basename|dirname|pathchk|pwd|stty|tty|env|printenv|id|logname|whoami|groups|users|who|date|uname|hostname|chroot|nice|nohup|sleep|factor|seq|getopt|getopts|options|shift)$/',
			'flowcontrol' => '/^(if|fi|then|else|elif|case|esac|while|done|for|in|function|until|do|select|time|read|set)$/',
		],
		20 =>
		[
		],
		],
		1 =>
		[
		0 =>
		[
		],
		1 => -1,
		2 => -1,
		3 => -1,
		4 =>
		[
		],
		5 => -1,
		6 => -1,
		7 =>
		[
		],
		8 =>
		[
		],
		9 =>
		[
		],
		10 => -1,
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
		17 => -1,
		18 => -1,
		19 => -1,
		20 =>
		[
			'reserved' => '/^(cd|cp|rm|echo|printf|exit|cut|join|comm|fmt|grep|egrep|fgrep|sed|awk|yes|false|true|test|expr|tee|basename|dirname|pathchk|pwd|stty|tty|env|printenv|id|logname|whoami|groups|users|who|date|uname|hostname|chroot|nice|nohup|sleep|factor|seq|getopt|getopts|options|shift)$/',
			'flowcontrol' => '/^(if|fi|then|else|elif|case|esac|while|done|for|in|function|until|do|select|time|read|set)$/',
		],
		21 =>
		[
		],
		],
		2 =>
		[
		0 =>
		[
		],
		1 => -1,
		2 => -1,
		3 => -1,
		4 =>
		[
		],
		5 => -1,
		6 => -1,
		7 =>
		[
		],
		8 =>
		[
		],
		9 =>
		[
		],
		10 => -1,
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
		16 => -1,
		17 => -1,
		18 => -1,
		19 =>
		[
			'reserved' => '/^(cd|cp|rm|echo|printf|exit|cut|join|comm|fmt|grep|egrep|fgrep|sed|awk|yes|false|true|test|expr|tee|basename|dirname|pathchk|pwd|stty|tty|env|printenv|id|logname|whoami|groups|users|who|date|uname|hostname|chroot|nice|nohup|sleep|factor|seq|getopt|getopts|options|shift)$/',
			'flowcontrol' => '/^(if|fi|then|else|elif|case|esac|while|done|for|in|function|until|do|select|time|read|set)$/',
		],
		20 =>
		[
		],
		],
		3 =>
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
		],
		4 =>
		[
		0 =>
		[
		],
		],
		5 =>
		[
		0 =>
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
		3 =>
		[
		],
		],
		7 =>
		[
		0 =>
		[
		],
		],
		8 =>
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
		],
		];
		$this->_parts = [
		0 =>
		[
		0 =>
		[
		1 => 'special',
		2 => 'string',
		],
		1 => NULL,
		2 => NULL,
		3 => NULL,
		4 =>
		[
		1 => 'reserved',
		2 => 'special',
		],
		5 => NULL,
		6 => NULL,
		7 => NULL,
		8 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
			6 => 'string',
			8 => 'quotes',
		],
		9 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
		],
		10 => NULL,
		11 => NULL,
		12 => NULL,
		13 => NULL,
		14 =>
		[
		1 => 'brackets',
		2 => 'var',
		3 => 'brackets',
		],
		15 => NULL,
		16 => NULL,
		17 => NULL,
		18 => NULL,
		19 => NULL,
		20 => NULL,
		],
		1 =>
		[
		0 =>
		[
		1 => 'special',
		2 => 'string',
		],
		1 => NULL,
		2 => NULL,
		3 => NULL,
		4 =>
		[
		1 => 'reserved',
		2 => 'special',
		],
		5 => NULL,
		6 => NULL,
		7 => NULL,
		8 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
			6 => 'string',
			8 => 'quotes',
		],
		9 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
		],
		10 => NULL,
		11 =>
		[
			1 => 'string',
			2 => 'code',
		],
		12 => NULL,
		13 => NULL,
		14 => NULL,
		15 =>
		[
		1 => 'brackets',
		2 => 'var',
		3 => 'brackets',
		],
		16 => NULL,
		17 => NULL,
		18 => NULL,
		19 => NULL,
		20 => NULL,
		21 => NULL,
		],
		2 =>
		[
		0 =>
		[
			1 => 'special',
			2 => 'string',
		],
		1 => NULL,
		2 => NULL,
		3 => NULL,
		4 =>
		[
			1 => 'reserved',
			2 => 'special',
		],
		5 => NULL,
		6 => NULL,
		7 => NULL,
		8 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
			6 => 'string',
			8 => 'quotes',
		],
		9 =>
		[
			1 => 'quotes',
			2 => 'quotes',
			3 => 'string',
			5 => 'quotes',
		],
		10 => NULL,
		11 => NULL,
		12 => NULL,
		13 => NULL,
		14 =>
		[
			1 => 'brackets',
			2 => 'var',
			3 => 'brackets',
		],
		15 => NULL,
		16 => NULL,
		17 => NULL,
		18 => NULL,
		19 => NULL,
		20 => NULL,
		],
		3 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
		],
		4 =>
		[
			0 => NULL,
		],
		5 =>
		[
			0 => NULL,
		],
		6 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
		],
		7 =>
		[
			0 => NULL,
		],
		8 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
			3 => NULL,
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
			5 => true,
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
			18 => false,
			19 => false,
			20 => false,
		],
		0 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => true,
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
			18 => false,
			19 => false,
			20 => false,
		],
		1 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => true,
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
			18 => false,
			19 => false,
			20 => false,
			21 => false,
		],
		2 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			5 => true,
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
			18 => false,
			19 => false,
			20 => false,
		],
		3 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
		],
		4 =>
		[
			0 => false,
		],
		5 =>
		[
			0 => false,
		],
		6 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
		],
		7 =>
		[
			0 => false,
		],
		8 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
			'reserved' => 'reserved',
			'flowcontrol' => 'reserved',
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
