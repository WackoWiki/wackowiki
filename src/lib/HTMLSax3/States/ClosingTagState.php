<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Dealing with closing XML tags
 * @package HTMLSax3
 * @access protected
 */
class ClosingTagState
{
	/**
	 * @param StateParser $context subclass
	 * @return int STATE_START
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		$tag = $context->scanUntilCharacters('/>');

		if ($tag !== '')
		{
			$char = $context->scanCharacter();

			if ($char === '/')
			{
				$char = $context->scanCharacter();

				if ($char !== '>')
				{
					$context->unscanCharacter();
				}
			}

			$context->handler_object_element->
			{$context->handler_method_closing}($context->htmlsax, $tag, false);
		}

		return STATE_START;
	}
}