<?php

namespace HTMLSax3;

/**
 * Deals with JASP/ASP markup
 * @package HTMLSax3
 * @access protected
 */
class JaspState
{
	/**
	 * @param StateParser subclass
	 * @return constant STATE_START
	 * @access protected
	 */
	function parse(&$context)
	{
		$text = $context->scanUntilString('%>');

		if ($text != '')
		{
			$context->handler_object_jasp->
			{$context->handler_method_jasp}($context->htmlsax, $text);
		}

		$context->IgnoreCharacter();
		$context->IgnoreCharacter();

		return STATE_START;
	}
}
