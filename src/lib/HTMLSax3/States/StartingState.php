<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * StartingState searches for the start of any XML tag
 * @package HTMLSax3
 * @access protected
 */
class StartingState
{
	/**
	 * @param StateParser $context subclass
	 * @return int STATE_TAG
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		$data = $context->scanUntilString('<');

		if ($data !== '')
		{
			$context->handler_object_data->
			{$context->handler_method_data}($context->htmlsax, $data);
		}

		$context->ignoreCharacter();

		return STATE_TAG;
	}
}
