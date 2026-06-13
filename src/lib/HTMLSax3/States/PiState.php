<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Deals with XML processing instructions
 * @package HTMLSax3
 * @access protected
 */
class PiState
{
	/**
	 * @param StateParser $context subclass
	 * @return int STATE_START
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		$target = $context->scanUntilCharacters(" \n\r\t");
		$data   = $context->scanUntilString('?>');

		if ($data !== '')
		{
			$context->handler_object_pi->
			{$context->handler_method_pi}($context->htmlsax, $target, $data);
		}

		$context->ignoreCharacter();
		$context->ignoreCharacter();

		return STATE_START;
	}
}
