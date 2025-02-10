<?php

/**

 * @package SimplePie
 * @copyright 2004-2016 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace SimplePie;

use Exception as NativeException;

/**
 * General SimplePie exception class
 *
 * @package SimplePie
 */
class Exception extends NativeException
{
}

class_alias('SimplePie\Exception', 'SimplePie_Exception');
