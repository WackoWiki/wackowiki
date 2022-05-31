<?php
/**
 * Auto-generated class. JAVASCRIPT syntax highlighting
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
 * @version	generated from: javascript.xml
 * @author Andrey Demenev <demenev@gmail.com>
 *
 */

class Text_Highlighter_JAVASCRIPT extends Text_Highlighter
{
	public $_language = 'javascript';

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
			-1 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)\')|((?i)\\/\\/)|((?i)[a-z_]\\w*)|((?i)0x\\d*|\\d*\\.?\\d+)/',
			0 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)\')|((?i)\\/\\/)|((?i)[a-z_]\\w*)|((?i)0x\\d*|\\d*\\.?\\d+)/',
			1 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)\')|((?i)\\/\\/)|((?i)[a-z_]\\w*)|((?i)0x\\d*|\\d*\\.?\\d+)/',
			2 => '/((?i)\\{)|((?i)\\()|((?i)\\[)|((?i)\\/\\*)|((?i)")|((?i)\')|((?i)\\/\\/)|((?i)[a-z_]\\w*)|((?i)0x\\d*|\\d*\\.?\\d+)/',
			3 => '/((?i)((https?|ftp):\\/\\/[\\w\\?\\.\\-\\&=\\/%+]+)|(^|[\\s,!?])www\\.\\w+\\.\\w+[\\w\\?\\.\\&=\\/%+]*)|((?i)\\w+[\\.\\w\\-]+@(\\w+[\\.\\w\\-])+)|((?i)\\b(note|fixme):)|((?i)\\$\\w+:.+\\$)/',
			4 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`|\\\\t|\\\\n|\\\\r)/',
			5 => '/((?i)\\\\\\\\|\\\\"|\\\\\'|\\\\`)/',
			6 => '/((?i)((https?|ftp):\\/\\/[\\w\\?\\.\\-\\&=\\/%+]+)|(^|[\\s,!?])www\\.\\w+\\.\\w+[\\w\\?\\.\\&=\\/%+]*)|((?i)\\w+[\\.\\w\\-]+@(\\w+[\\.\\w\\-])+)|((?i)\\b(note|fixme):)|((?i)\\$\\w+:.+\\$)/',
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
			8 => 0,
		],
		0 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
		],
		1 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
		],
		2 =>
		[
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
		],
		3 =>
		[
			0 => 3,
			1 => 1,
			2 => 1,
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
			0 => 3,
			1 => 1,
			2 => 1,
			3 => 0,
		],
		];
		$this->_delim = [
		-1 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'comment',
			7 => '',
			8 => '',
		],
		0 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'comment',
			7 => '',
			8 => '',
		],
		1 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'comment',
			7 => '',
			8 => '',
		],
		2 =>
		[
			0 => 'brackets',
			1 => 'brackets',
			2 => 'brackets',
			3 => 'comment',
			4 => 'quotes',
			5 => 'quotes',
			6 => 'comment',
			7 => '',
			8 => '',
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
		];
		$this->_inner = [
		-1 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'comment',
			7 => 'identifier',
			8 => 'number',
		],
		0 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'comment',
			7 => 'identifier',
			8 => 'number',
		],
		1 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'comment',
			7 => 'identifier',
			8 => 'number',
		],
		2 =>
		[
			0 => 'code',
			1 => 'code',
			2 => 'code',
			3 => 'comment',
			4 => 'string',
			5 => 'string',
			6 => 'comment',
			7 => 'identifier',
			8 => 'number',
		],
		3 =>
		[
			0 => 'url',
			1 => 'url',
			2 => 'inlinedoc',
			3 => 'inlinedoc',
		],
		4 =>
		[
			0 => 'special',
		],
		5 =>
		[
			0 => 'special',
		],
		6 =>
		[
			0 => 'url',
			1 => 'url',
			2 => 'inlinedoc',
			3 => 'inlinedoc',
		],
		];
		$this->_end = [
			0 => '/(?i)\\}/',
			1 => '/(?i)\\)/',
			2 => '/(?i)\\]/',
			3 => '/(?i)\\*\\//',
			4 => '/(?i)"/',
			5 => '/(?i)\'/',
			6 => '/(?mi)$/',
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
			6 => 6,
			7 => -1,
			8 => -1,
		],
		0 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => -1,
			8 => -1,
		],
		1 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => -1,
			8 => -1,
		],
		2 =>
		[
			0 => 0,
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => -1,
			8 => -1,
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
			6 => -1,
			7 =>
			[
				'builtin' => '/^(String|Array|RegExp|Function|Math|Number|Date|Image|window|document|navigator|onAbort|onBlur|onChange|onClick|onDblClick|onDragDrop|onError|onFocus|onKeyDown|onKeyPress|onKeyUp|onLoad|onMouseDown|onMouseOver|onMouseOut|onMouseMove|onMouseUp|onMove|onReset|onResize|onSelect|onSubmit|onUnload)$/',
				'reserved' => '/^(break|continue|do|while|export|for|in|if|else|import|return|label|switch|case|var|with|delete|new|this|typeof|void|abstract|boolean|byte|catch|char|class|const|debugger|default|double|enum|extends|false|final|finally|float|function|implements|goto|instanceof|int|interface|long|native|null|package|private|protected|public|short|static|super|synchronized|throw|throws|transient|true|try|volatile)$/',
			],
			8 =>
			[
			],
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
			7 =>
			[
				'builtin' => '/^(String|Array|RegExp|Function|Math|Number|Date|Image|window|document|navigator|onAbort|onBlur|onChange|onClick|onDblClick|onDragDrop|onError|onFocus|onKeyDown|onKeyPress|onKeyUp|onLoad|onMouseDown|onMouseOver|onMouseOut|onMouseMove|onMouseUp|onMove|onReset|onResize|onSelect|onSubmit|onUnload)$/',
				'reserved' => '/^(break|continue|do|while|export|for|in|if|else|import|return|label|switch|case|var|with|delete|new|this|typeof|void|abstract|boolean|byte|catch|char|class|const|debugger|default|double|enum|extends|false|final|finally|float|function|implements|goto|instanceof|int|interface|long|native|null|package|private|protected|public|short|static|super|synchronized|throw|throws|transient|true|try|volatile)$/',
			],
			8 =>
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
			7 =>
			[
				'builtin' => '/^(String|Array|RegExp|Function|Math|Number|Date|Image|window|document|navigator|onAbort|onBlur|onChange|onClick|onDblClick|onDragDrop|onError|onFocus|onKeyDown|onKeyPress|onKeyUp|onLoad|onMouseDown|onMouseOver|onMouseOut|onMouseMove|onMouseUp|onMove|onReset|onResize|onSelect|onSubmit|onUnload)$/',
				'reserved' => '/^(break|continue|do|while|export|for|in|if|else|import|return|label|switch|case|var|with|delete|new|this|typeof|void|abstract|boolean|byte|catch|char|class|const|debugger|default|double|enum|extends|false|final|finally|float|function|implements|goto|instanceof|int|interface|long|native|null|package|private|protected|public|short|static|super|synchronized|throw|throws|transient|true|try|volatile)$/',
			],
			8 =>
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
			7 =>
			[
				'builtin' => '/^(String|Array|RegExp|Function|Math|Number|Date|Image|window|document|navigator|onAbort|onBlur|onChange|onClick|onDblClick|onDragDrop|onError|onFocus|onKeyDown|onKeyPress|onKeyUp|onLoad|onMouseDown|onMouseOver|onMouseOut|onMouseMove|onMouseUp|onMove|onReset|onResize|onSelect|onSubmit|onUnload)$/',
				'reserved' => '/^(break|continue|do|while|export|for|in|if|else|import|return|label|switch|case|var|with|delete|new|this|typeof|void|abstract|boolean|byte|catch|char|class|const|debugger|default|double|enum|extends|false|final|finally|float|function|implements|goto|instanceof|int|interface|long|native|null|package|private|protected|public|short|static|super|synchronized|throw|throws|transient|true|try|volatile)$/',
			],
			8 =>
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
		],
		0 =>
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
		],
		1 =>
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
		],
		2 =>
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
