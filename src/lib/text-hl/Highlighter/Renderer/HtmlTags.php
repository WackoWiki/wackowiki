<?php

/**
 * HTML renderer that uses only basic html tags
 *
 * Based on the "normal" HTML renderer by Andrey Demenev.
 * It's designed to work with user agents that support only a limited number of
 * HTML tags. Like the iPod which supports only b, i, u and a.
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * https://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Text
 * @package    Text_Highlighter
 * @author     Stoyan Stefanov <ssttoo@gmail.com>
 * @copyright  2005 Stoyan Stefanov
 * @license    https://www.php.net/license/3_0.txt  PHP License
 * @version    Release: 0.8.0
 * @link       https://pear.php.net/package/Text_Highlighter
 */

/**
 * @ignore
 */

/**
 * HTML basic tags renderer, based on Andrey Demenev's HTML renderer.
 *
 * Elements of $options argument of constructor (each being optional):
 *
 * - 'numbers' - Line numbering TRUE or FALSE. Default is FALSE.
 * - 'tabsize' - Tab size, default is 4.
 * - 'tags'    - Array, containing the tags to be used for highlighting
 *
 * Here's the listing of the default tags:
 * - 'default'    => '',
 * - 'code'       => '',
 * - 'brackets'   => 'b',
 * - 'comment'    => 'i',
 * - 'mlcomment'  => 'i',
 * - 'quotes'     => '',
 * - 'string'     => 'i',
 * - 'identifier' => 'b',
 * - 'builtin'    => 'b',
 * - 'reserved'   => 'u',
 * - 'inlinedoc'  => 'i',
 * - 'var'		=> 'b',
 * - 'url'		=> 'i',
 * - 'special'    => '',
 * - 'number'     => '',
 * - 'inlinetags' => ''
 */

class Text_Highlighter_Renderer_HtmlTags extends Text_Highlighter_Renderer_Array
{
	/**#@+
	 * @access private
	 */

	/**
	 * Line numbering - will use 'ol' tag
	 *
	 * @var bool
	 */
	public $_numbers = false;

	/**
	 * HTML tags map
	 *
	 * @var array
	 */
	public $_hilite_tags = [
		'default'		=> '',
		'code'			=> '',
		'brackets'		=> 'b',
		'comment'		=> 'i',
		'mlcomment'		=> 'i',
		'quotes'		=> '',
		'string' 		=> 'i',
		'identifier'	=> 'b',
		'builtin'		=> 'b',
		'reserved'		=> 'u',
		'inlinedoc'		=> 'i',
		'var'			=> 'b',
		'url'			=> 'i',
		'special' 		=> '',
		'number'		=> '',
		'inlinetags'	=> '',
	];

	/**#@-*/

	/**
	 * Resets renderer state
	 *
	 * @access protected
	 *
	 *
	 * Descendents of Text_Highlighter call this method from the constructor,
	 * passing $options they get as parameter.
	 */
	function reset()
	{
		parent::reset();

		if (isset($this->_options['numbers']))
		{
			$this->_numbers = $this->_options['numbers'];
		}

		if (isset($this->_options['tags']))
		{
			$this->_hilite_tags = array_merge($this->_tags, $this->_options['tags']);
		}
	}


	/**
	 * Signals that no more tokens are available
	 *
	 * @abstract
	 * @access public
	 *
	 */
	function finalize()
	{
		// get parent's output
		parent::finalize();
		$output = parent::getOutput();

		$html_output = '';

		// loop through each class=>content pair
		foreach ($output as $token)
		{
			if ($this->_enumerated)
			{
				$class		= $token[0];
				$content	= $token[1];
			}
			else
			{
				$key		= key($token);
				$class		= $key;
				$content	= $token[$key];
			}

			$iswhitespace = ctype_space($content);

			if (!$iswhitespace && !empty($this->_hilite_tags[$class]))
			{
				$html_output .= '<'. $this->_hilite_tags[$class] . '>' . $content . '</'. $this->_hilite_tags[$class] . '>';
			}
			else
			{
				$html_output .= $content;
			}
		}

		if ($this->_numbers)
		{
			/* additional whitespace for browsers that do not display
			 empty list items correctly */
			$html_output = '<li>&nbsp;' . str_replace("\n", "</li>\n<li>&nbsp;", $html_output) . '</li>';
			$this->_output = '<ol>' . str_replace(' ', '&nbsp;', $html_output) . '</ol>';
		}
		else
		{
			$this->_output = '<pre>' . $html_output . '</pre>';
		}
	}


}
