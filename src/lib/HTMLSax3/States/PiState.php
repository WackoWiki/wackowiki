<?php

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
	 * @return constant STATE_START
	 * @access protected
	 */
	function parse(&$context)
	{
		$target	= $context->scanUntilCharacters(" \n\r\t");
		$data	= $context->scanUntilString('?>');

		if ($data != '')
		{
			$context->handler_object_pi->
			{$context->handler_method_pi}($context->htmlsax, $target, $data);
		}

		$context->IgnoreCharacter();
		$context->IgnoreCharacter();

		return STATE_START;
	}
}
