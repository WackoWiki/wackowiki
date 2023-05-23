<?php

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
	 * @return constant STATE_TAG
	 * @access protected
	 */
	function parse(&$context)
	{
		$data = $context->scanUntilString('<');

		if ($data != '')
		{
			$context->handler_object_data->
			{$context->handler_method_data}($context->htmlsax, $data);
		}

		$context->IgnoreCharacter();

		return STATE_TAG;
	}
}
