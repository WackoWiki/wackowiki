<?php
/**
 * Auto-generated class. CSS syntax highlighting
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
 * @version	generated from: css.xml
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_CSS extends Text_Highlighter
{
	public $_language = 'css';

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
			-1 => '/((?i)\\/\\*)|((?i)(@[a-z\\d]+))|((?i)(((\\.|#)?[a-z]+[a-z\\d\\-]*(?![a-z\\d\\-]))|(\\*))(?!\\s*:\\s*[\\s\\{]))|((?i):[a-z][a-z\\d\\-]*)|((?i)\\[)|((?i)\\{)/',
			0 => '//',
			1 => '/((?i)\\d*\\.?\\d+(\\%|em|ex|pc|pt|px|in|mm|cm))|((?i)\\d*\\.?\\d+)|((?i)[a-z][a-z\\d\\-]*)|((?i)#([\\da-f]{6}|[\\da-f]{3})\\b)/',
			2 => '/((?i)\')|((?i)")|((?i)[\\w\\-\\:]+)/',
			3 => '/((?i)\\/\\*)|((?i)[a-z][a-z\\d\\-]*\\s*:)|((?i)(((\\.|#)?[a-z]+[a-z\\d\\-]*(?![a-z\\d\\-]))|(\\*))(?!\\s*:\\s*[\\s\\{]))|((?i)\\{)/',
			4 => '/((?i)\\\\[\\\\(\\\\)\\\\])/',
			5 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			6 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`|\\\\t|\\\\n|\\\\r)/',
		];
		$this->_counts = [
		-1 =>
		[
			0 => 0,
			1 => 1,
			2 => 4,
			3 => 0,
			4 => 0,
			5 => 0,
		],
		0 =>
		[
		],
		1 =>
		[
			0 => 1,
			1 => 0,
			2 => 0,
			3 => 1,
		],
		2 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
		],
		3 =>
		[
			0 => 0,
			1 => 0,
			2 => 4,
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
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'comment',
			1 => '',
			2 => '',
			3 => '',
			4 => 'brackets',
			5 => 'brackets',
		],
		0 =>
		[
		],
		1 =>
		[
			0 => '',
			1 => '',
			2 => '',
			3 => '',
		],
		2 =>
		[
			0 => 'quotes',
			1 => 'quotes',
			2 => '',
		],
		3 =>
		[
			0 => 'comment',
			1 => 'reserved',
			2 => '',
			3 => 'brackets',
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
		],
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'comment',
			1 => 'var',
			2 => 'identifier',
			3 => 'special',
			4 => 'code',
			5 => 'code',
		],
		0 =>
		[
		],
		1 =>
		[
			0 => 'number',
			1 => 'number',
			2 => 'code',
			3 => 'var',
		],
		2 =>
		[
			0 => 'string',
			1 => 'string',
			2 => 'var',
		],
		3 =>
		[
			0 => 'comment',
			1 => 'code',
			2 => 'identifier',
			3 => 'code',
		],
		4 =>
		[
			0 => 'string',
		],
		5 =>
		[
			0 => 'special',
		],
		6 =>
		[
			0 => 'special',
		],
		];
		$this->_end = [
			0 => '/(?i)\\*\\//',
			1 => '/(?i)(?=;|\\})/',
			2 => '/(?i)\\]/',
			3 => '/(?i)\\}/',
			4 => '/(?i)\\)/',
			5 => '/(?i)\'/',
			6 => '/(?i)"/',
		];
		$this->_states = [
		-1 =>
		[
			0 => 0,
			1 => -1,
			2 => -1,
			3 => -1,
			4 => 2,
			5 => 3,
		],
		0 =>
		[
		],
		1 =>
		[
			0 => -1,
			1 => -1,
			2 => -1,
			3 => -1,
		],
		2 =>
		[
			0 => 5,
			1 => 6,
			2 => -1,
		],
		3 =>
		[
			0 => 0,
			1 => 1,
			2 => -1,
			3 => 3,
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
		],
		];
		$this->_keywords = [
			-1 =>
		[
		0 => -1,
		1 =>
		[
		],
		2 =>
		[
		],
		3 =>
		[
		],
		4 => -1,
		5 => -1,
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
		2 =>
		[
			'propertyValue' => '/^((?i)far-left|left|center-left|center-right|center|far-right|right-side|right|behind|leftwards|rightwards|inherit|scroll|fixed|transparent|none|repeat-x|repeat-y|repeat|no-repeat|collapse|separate|auto|top|bottom|both|open-quote|close-quote|no-open-quote|no-close-quote|crosshair|default|pointer|move|e-resize|ne-resize|nw-resize|n-resize|se-resize|sw-resize|s-resize|text|wait|help|ltr|rtl|inline|block|list-item|run-in|compact|marker|table|inline-table|table-row-group|table-header-group|table-footer-group|table-row|table-column-group|table-column|table-cell|table-caption|below|level|above|higher|lower|show|hide|caption|icon|menu|message-box|small-caption|status-bar|normal|wider|narrower|ultra-condensed|extra-condensed|condensed|semi-condensed|semi-expanded|expanded|extra-expanded|ultra-expanded|italic|oblique|small-caps|bold|bolder|lighter|inside|outside|disc|circle|square|decimal|decimal-leading-zero|lower-roman|upper-roman|lower-greek|lower-alpha|lower-latin|upper-alpha|upper-latin|hebrew|armenian|georgian|cjk-ideographic|hiragana|katakana|hiragana-iroha|katakana-iroha|crop|cross|invert|visible|hidden|always|avoid|x-low|low|medium|high|x-high|mix?|repeat?|static|relative|absolute|portrait|landscape|spell-out|once|digits|continuous|code|x-slow|slow|fast|x-fast|faster|slower|justify|underline|overline|line-through|blink|capitalize|uppercase|lowercase|embed|bidi-override|baseline|sub|super|text-top|middle|text-bottom|silent|x-soft|soft|loud|x-loud|pre|nowrap|serif|sans-serif|cursive|fantasy|monospace|empty|string|strict|loose|char|true|false|dotted|dashed|solid|double|groove|ridge|inset|outset|larger|smaller|xx-small|x-small|small|large|x-large|xx-large|all|newspaper|distribute|distribute-all-lines|distribute-center-last|inter-word|inter-ideograph|inter-cluster|kashida|ideograph-alpha|ideograph-numeric|ideograph-parenthesis|ideograph-space|keep-all|break-all|break-word|lr-tb|tb-rl|thin|thick|inline-block|w-resize|hand|distribute-letter|distribute-space|whitespace|male|female|child)$/',
			'namedcolor' => '/^((?i)aqua|black|blue|fuchsia|gray|green|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow|activeborder|activecaption|appworkspace|background|buttonface|buttonhighlight|buttonshadow|buttontext|captiontext|graytext|highlight|highlighttext|inactiveborder|inactivecaption|inactivecaptiontext|infobackground|infotext|menu|menutext|scrollbar|threeddarkshadow|threedface|threedhighlight|threedlightshadow|threedshadow|window|windowframe|windowtext)$/',
		],
		3 =>
		[
		],
		],
		2 =>
		[
		0 => -1,
		1 => -1,
		2 =>
		[
		],
		],
		3 =>
		[
		0 => -1,
		1 => -1,
		2 =>
		[
		],
		3 => -1,
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
		],
		];
		$this->_parts = [
		0 =>
		[
		],
		1 =>
		[
		0 =>
		[
		1 => 'string',
		],
			1 => NULL,
			2 => NULL,
			3 => NULL,
		],
		2 =>
		[
			0 => NULL,
			1 => NULL,
			2 => NULL,
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
		],
		0 =>
		[
		],
		1 =>
		[
			0 => false,
			1 => false,
			2 => false,
			3 => false,
		],
		2 =>
		[
			0 => false,
			1 => false,
			2 => false,
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
		],
		];
		$this->_conditions = [
		];
		$this->_kwmap = [
			'propertyValue' => 'string',
			'namedcolor' => 'var',
		];
		$this->_defClass = 'code';
		$this->_checkDefines();
	}

}
