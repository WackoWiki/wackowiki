<?php
/**
 * Auto-generated class. RUBY syntax highlighting
 *
 *
 * FIXME:  While this construction : s.split /z/i
 * is valid, regular expression is not recognized as such
 * (/ folowing an identifier or number is not recognized as
 * start of RE), making highlighting improper
 *
 * %q(a (nested) string) does not get highlighted correctly
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
 * @version	generated from: : ruby.xml,v 1.1 2007/06/03 02:35:28 ssttoo Exp
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_RUBY extends Text_Highlighter
{
	public $_language = 'ruby';

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
			-1 => '/((?mi)^__END__$)|((?i)")|((?i)%[Qx]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\')|((?i)%[wq]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\\$(\\W|\\w+))|((?ii)@@?[_a-z][\\d_a-z]*)|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)0[xX][\\da-f]+l?)|((?i)\\d+l?|\\b0l?\\b)|((?i)0[0-7]+l?)|((?mi)^=begin$)|((?i)#)|((?i)\\s*\\/)/',
			0 => '//',
			1 => '/((?i)\\\\.)/',
			2 => '/((?i)\\\\.)/',
			3 => '/((?i)\\\\.)/',
			4 => '/((?i)\\\\.)/',
			5 => '/((?mi)^__END__$)|((?i)")|((?i)%[Qx]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\')|((?i)%[wq]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\\$(\\W|\\w+))|((?ii)@@?[_a-z][\\d_a-z]*)|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)0[xX][\\da-f]+l?)|((?i)\\d+l?|\\b0l?\\b)|((?i)0[0-7]+l?)|((?mi)^=begin$)|((?i)#)|((?i)\\s*\\/)/',
			6 => '/((?mi)^__END__$)|((?i)")|((?i)%[Qx]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\')|((?i)%[wq]([!"#\\$%&\'+\\-*.\\/:;=?@^`|~{<\\[(]))|((?i)\\$(\\W|\\w+))|((?ii)@@?[_a-z][\\d_a-z]*)|((?i)\\()|((?i)\\[)|((?i)[a-z_]\\w*)|((?i)((\\d+|((\\d*\\.\\d+)|(\\d+\\.\\d*)))[eE][+-]?\\d+))|((?i)(\\d*\\.\\d+)|(\\d+\\.\\d*))|((?i)0[xX][\\da-f]+l?)|((?i)\\d+l?|\\b0l?\\b)|((?i)0[0-7]+l?)|((?mi)^=begin$)|((?i)#)|((?i)\\s*\\/)/',
			7 => '/((?i)\\$\\w+\\s*:.+\\$)/',
			8 => '/((?i)\\$\\w+\\s*:.+\\$)/',
			9 => '/((?i)\\\\.)/',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 0,
			1 => 0,
			2 => 1,
			3 => 0,
			4 => 1,
			5 => 1,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 5,
			11 => 2,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 0,
			16 => 0,
			17 => 0,
		],
		0 =>
		[
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
		],
		5 =>
		[
			0 => 0,
			1 => 0,
			2 => 1,
			3 => 0,
			4 => 1,
			5 => 1,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 5,
			11 => 2,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 0,
			16 => 0,
			17 => 0,
		],
		6 =>
		[
			0 => 0,
			1 => 0,
			2 => 1,
			3 => 0,
			4 => 1,
			5 => 1,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 5,
			11 => 2,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 0,
			16 => 0,
			17 => 0,
		],
		7 =>
		[
			0 => 0,
		],
		8 =>
		[
			0 => 0,
		],
		9 =>
		[
			0 => 0,
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'reserved',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'quotes',
			5 => '',
			6 => '',
			7 => 'brackets',
			8 => 'brackets',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => 'comment',
			16 => 'comment',
			17 => 'quotes',
		],
		0 =>
		[
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
			0 => '',
		],
		5 =>
		[
			0 => 'reserved',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'quotes',
			5 => '',
			6 => '',
			7 => 'brackets',
			8 => 'brackets',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => 'comment',
			16 => 'comment',
			17 => 'quotes',
		],
		6 =>
		[
			0 => 'reserved',
			1 => 'quotes',
			2 => 'quotes',
			3 => 'quotes',
			4 => 'quotes',
			5 => '',
			6 => '',
			7 => 'brackets',
			8 => 'brackets',
			9 => '',
			10 => '',
			11 => '',
			12 => '',
			13 => '',
			14 => '',
			15 => 'comment',
			16 => 'comment',
			17 => 'quotes',
		],
		7 =>
		[
			0 => '',
		],
		8 =>
		[
			0 => '',
		],
		9 =>
		[
			0 => '',
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'comment',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'string',
			5 => 'var',
			6 => 'var',
			7 => 'code',
			8 => 'code',
			9 => 'identifier',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'number',
			15 => 'comment',
			16 => 'comment',
			17 => 'string',
		],
		0 =>
		[
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
			0 => 'special',
		],
		5 =>
		[
			0 => 'comment',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'string',
			5 => 'var',
			6 => 'var',
			7 => 'code',
			8 => 'code',
			9 => 'identifier',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'number',
			15 => 'comment',
			16 => 'comment',
			17 => 'string',
		],
		6 =>
		[
			0 => 'comment',
			1 => 'string',
			2 => 'string',
			3 => 'string',
			4 => 'string',
			5 => 'var',
			6 => 'var',
			7 => 'code',
			8 => 'code',
			9 => 'identifier',
			10 => 'number',
			11 => 'number',
			12 => 'number',
			13 => 'number',
			14 => 'number',
			15 => 'comment',
			16 => 'comment',
			17 => 'string',
		],
		7 =>
		[
			0 => 'inlinedoc',
		],
		8 =>
		[
			0 => 'inlinedoc',
		],
		9 =>
		[
			0 => 'special',
		],
		];
		$this->_end = [
			0 => '/(?i)$/',
			1 => '/(?i)"/',
			2 => '/(?i)%b1%/',
			3 => '/(?i)\'/',
			4 => '/(?i)%b1%/',
			5 => '/(?i)\\)/',
			6 => '/(?i)\\]/',
			7 => '/(?mi)^=end$/',
			8 => '/(?mi)$/',
			9 => '/(?i)\\/[iomx]*/',
		];
		$this->_states = [
		-1 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => -1,
			6 => -1,
			7 => 5,
			8 => 6,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => 7,
			16 => 8,
			17 => 9,
		],
		0 =>
		[
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
			0 => -1,
		],
		5 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => -1,
			6 => -1,
			7 => 5,
			8 => 6,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => 7,
			16 => 8,
			17 => 9,
		],
		6 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => -1,
			6 => -1,
			7 => 5,
			8 => 6,
			9 => -1,
			10 => -1,
			11 => -1,
			12 => -1,
			13 => -1,
			14 => -1,
			15 => 7,
			16 => 8,
			17 => 9,
		],
		7 =>
		[
			0 => -1,
		],
		8 =>
		[
			0 => -1,
		],
		9 =>
		[
			0 => -1,
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
			5 =>
		[
		],
		6 =>
		[
		],
		7 => -1,
		8 => -1,
		9 =>
		[
			'reserved' => '/^(__FILE__|require|and|def|end|in|or|self|unless|__LINE__|begin|defined?|ensure|module|redo|super|until|BEGIN|break|do|false|next|rescue|then|when|END|case|else|for|nil|retry|true|while|alias|module_function|private|public|protected|attr_reader|attr_writer|attr_accessor|class|elsif|if|not|return|undef|yield)$/',
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
		15 => -1,
		16 => -1,
		17 => -1,
		],
		0 =>
		[
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
		0 =>
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
			5 =>
		[
		],
		6 =>
		[
		],
		7 => -1,
		8 => -1,
		9 =>
		[
			'reserved' => '/^(__FILE__|require|and|def|end|in|or|self|unless|__LINE__|begin|defined?|ensure|module|redo|super|until|BEGIN|break|do|false|next|rescue|then|when|END|case|else|for|nil|retry|true|while|alias|module_function|private|public|protected|attr_reader|attr_writer|attr_accessor|class|elsif|if|not|return|undef|yield)$/',
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
		15 => -1,
		16 => -1,
		17 => -1,
		],
		6 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => -1,
			5 =>
		[
		],
		6 =>
		[
		],
		7 => -1,
		8 => -1,
		9 =>
		[
			'reserved' => '/^(__FILE__|require|and|def|end|in|or|self|unless|__LINE__|begin|defined?|ensure|module|redo|super|until|BEGIN|break|do|false|next|rescue|then|when|END|case|else|for|nil|retry|true|while|alias|module_function|private|public|protected|attr_reader|attr_writer|attr_accessor|class|elsif|if|not|return|undef|yield)$/',
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
		15 => -1,
		16 => -1,
		17 => -1,
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
		],
		9 =>
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
			15 => NULL,
			16 => NULL,
			17 => NULL,
		],
		6 =>
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
		7 =>
		[
			0 => NULL,
		],
		8 =>
		[
			0 => NULL,
		],
		9 =>
		[
			0 => NULL,
		],
		];
		$this->_subst = [
			-1 =>
		[
			0 => false,
			1 => false,
			2 => true,
			3 => false,
			4 => true,
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
		],
		0 =>
		[
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
		],
		5 =>
		[
			0 => false,
			1 => false,
			2 => true,
			3 => false,
			4 => true,
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
		],
		6 =>
		[
			0 => false,
			1 => false,
			2 => true,
			3 => false,
			4 => true,
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
		],
		7 =>
		[
			0 => false,
		],
		8 =>
		[
			0 => false,
		],
		9 =>
		[
			0 => false,
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
			'reserved' => 'reserved',
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
