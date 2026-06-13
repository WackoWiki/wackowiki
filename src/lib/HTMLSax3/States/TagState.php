<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Decides which state to move one from after StartingState
 * @package HTMLSax3
 * @access protected
 */
class TagState
{
	/**
	 * @param StateParser $context subclass
	 * @return int the next state to move into
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		return match ($context->scanCharacter())
		{
			'/'     => STATE_CLOSING_TAG,
			'?'     => STATE_PI,
			'%'     => STATE_JASP,
			'!'     => STATE_ESCAPE,
			default => tap(STATE_OPENING_TAG, static function () use ($context): void
			{
				$context->unscanCharacter();
		}),
		};
	}
}
