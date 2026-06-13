<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Execute $callback with $value, then return $value.
 *
 * Inspired by Laravel's Higher Order helper of the same name; this is a
 * tiny local replacement because PHP itself does not ship a `tap()`
 * function.
 *
 * Useful for side-effect expressions inside `match` arms:
 *
 *   return match ($char) {
 *       '/' => STATE_CLOSING_TAG,
 *       default => tap(STATE_OPENING_TAG, fn() => $context->unscanCharacter()),
 *   };
 *
 * @template T
 * @param T $value
 * @param callable(...mixed): mixed $callback
 * @return T
 */
function tap(mixed $value, callable $callback): mixed
{
	$callback($value);

	return $value;
}
