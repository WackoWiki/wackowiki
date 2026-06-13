<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Deals with JASP/ASP markup
 * @package HTMLSax3
 * @access protected
 */
class JaspState
{
	/**
	 * @param StateParser $context subclass
	 * @return int STATE_START
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		$text = $context->scanUntilString('%>');

		if ($text !== '')
		{
			$context->handler_object_jasp->
			{$context->handler_method_jasp}($context->htmlsax, $text);
		}

		$context->ignoreCharacter();
		$context->ignoreCharacter();

		return STATE_START;
	}
}