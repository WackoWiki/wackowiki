<?php

/**
 * JSON renderer.
 *
 * Based on the HTML renderer by Andrey Demenev.
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
 * @copyright  2006 Stoyan Stefanov
 * @license    https://www.php.net/license/3_0.txt  PHP License
 * @version    Release: 0.8.0
 * @link       https://pear.php.net/package/Text_Highlighter
 */

/**
 * @ignore
 */

class Text_Highlighter_Renderer_JSON extends Text_Highlighter_Renderer_Array
{

	/**
	 * Signals that no more tokens are available
	 *
	 * @abstract
	 * @access public
	 */
	function finalize()
	{
		parent::finalize();
		$output = parent::getOutput();

		$json_array = [];

		foreach ($output as $token)
		{

			if ($this->_enumerated)
			{
				$json_array[] = '["' . $token[0] . '","' . $token[1] . '"]';
			}
			else
			{
				$key = key($token);
				$json_array[] = '{"class": "' . $key . '","content":"' . $token[$key] . '"}';
			}

		}

		$this->_output  = '['. implode(',', $json_array) .']';
		$this->_output = str_replace("\n", '\n', $this->_output);

	}


}
