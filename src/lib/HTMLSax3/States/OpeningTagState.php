<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Dealing with opening XML tags
 * @package HTMLSax3
 * @access protected
 */
class OpeningTagState
{
	/** @var array<string,string|null> */
	private array $attrs = [];

	/**
	 * Handles attributes
	 * @param StateParser $context parser state
	 * @return array<string,string|null>
	 * @access protected
	 */
	public function parseAttributes(StateParser $context): array
	{
		$Attributes = [];

		$context->ignoreWhitespace();
		$attributename = $context->scanUntilCharacters("=/> \n\r\t");

		while ($attributename !== '')
		{
			$attributevalue = null;
			$context->ignoreWhitespace();
			$char = $context->scanCharacter();

			if ($char === '=')
			{
				$context->ignoreWhitespace();
				$char = $context->scanCharacter();

				if ($char === '"')
				{
					$attributevalue = $context->scanUntilString('"');
					$context->ignoreCharacter();
				}
				else if ($char === "'")
				{
					$attributevalue = $context->scanUntilString("'");
					$context->ignoreCharacter();
				}
				else
				{
					$context->unscanCharacter();
					$attributevalue =
					$context->scanUntilCharacters("> \n\r\t");
				}
			}
			else if ($char !== null)
			{
				$attributevalue = null;
				$context->unscanCharacter();
			}

			$Attributes[$attributename] = $attributevalue;

			$context->ignoreWhitespace();
			$attributename = $context->scanUntilCharacters("=/> \n\r\t");
		}

		return $Attributes;
	}

	/**
	 * @param StateParser $context subclass
	 * @return int STATE_START
	 * @access protected
	 */
	public function parse(StateParser $context): int
	{
		$tag = $context->scanUntilCharacters("/> \n\r\t");

		if ($tag !== '')
		{
			$this->attrs    = [];
			$Attributes     = $this->parseAttributes($context);
			$char           = $context->scanCharacter();

			if ($char === '/')
			{
				$char = $context->scanCharacter();

				if ($char !== '>')
				{
					$context->unscanCharacter();
				}

				$context->handler_object_element->
				{$context->handler_method_opening}($context->htmlsax, $tag,
				$Attributes, true);
				$context->handler_object_element->
				{$context->handler_method_closing}($context->htmlsax, $tag,
				true);
			}
			else
			{
				$context->handler_object_element->
				{$context->handler_method_opening}($context->htmlsax, $tag,
				$Attributes, false);
			}
		}

		return STATE_START;
	}
}
