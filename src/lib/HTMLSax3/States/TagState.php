<?php

namespace HTMLSax3;

/**
 * Decides which state to move one from after StartingState
 * @package HTMLSax3
 * @access protected
 */
class TagState
{
	/**
	 * @param StateParser subclass
	 * @return constant the next state to move into
	 * @access protected
	 */
	function parse(&$context)
	{
		switch ($context->ScanCharacter()) {
			case '/':
				return STATE_CLOSING_TAG;
				break;
			case '?':
				return STATE_PI;
				break;
			case '%':
				return STATE_JASP;
				break;
			case '!':
				return STATE_ESCAPE;
				break;
			default:
				$context->unscanCharacter();
				return STATE_OPENING_TAG;
		}
	}
}
