<?php

namespace HTMLSax3;

/**
 * Deals with XML escapes handling comments and CDATA correctly
 * @package HTMLSax3
 * @access protected
 */
class EscapeState
{
	/**
	 * @param StateParser $context subclass
	 * @return constant STATE_START
	 * @access protected
	 */
	function parse(&$context)
	{
		$char = $context->ScanCharacter();

		if ($char == '-')
		{
			$char = $context->ScanCharacter();

			$context->unscanCharacter();

			if ($char == '-')
			{
				$context->unscanCharacter();
				$text = $context->scanUntilString('-->');
				$text .= $context->scanCharacter();
				$text .= $context->scanCharacter();
			}
			else
			{
				$text = $context->scanUntilString('>');
			}
		}
		else if ($char == '[')
		{
			$context->unscanCharacter();
			$text = $context->scanUntilString(']>');
			$text .= $context->scanCharacter();
		}
		else
		{
			$context->unscanCharacter();
			$text = $context->scanUntilString('>');
		}

		$context->IgnoreCharacter();

		if ($text != '')
		{
			$context->handler_object_escape->
			{$context->handler_method_escape}($context->htmlsax, $text);
		}

		return STATE_START;
	}
}
