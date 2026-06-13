<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Default NullHandler for methods which were not set by user
 * @package HTMLSax3
 * @access protected
 */
class NullHandler
{
	/**
	 * Generic handler method which does nothing
	 * Accepts any arguments the framework may forward.
	 *
	 * @param mixed ...$_args variadic to swallow every SAX callback signature
	 * @access protected
	 * @return void
	 */
	public function DoNothing(mixed ...$_args): void
	{
	}
}