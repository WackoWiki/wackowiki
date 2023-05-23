<?php

namespace HTMLSax3;

/**
 * Dealing with opening XML tags
 * @package HTMLSax3
 * @access protected
 */
class OpeningTagState
{
	private array $attrs;

	/**
	 * Handles attributes
	 * @param string attribute name
	 * @param string attribute value
	 * @return void
	 * @access protected
	 * @see AttributeStartState
	 */
	function parseAttributes(&$context)
	{
		$Attributes = [];

		$context->ignoreWhitespace();
		$attributename = $context->scanUntilCharacters("=/> \n\r\t");

		while ($attributename != '')
		{
			$attributevalue = null;
			$context->ignoreWhitespace();
			$char = $context->scanCharacter();

			if ($char == '=')
			{
				$context->ignoreWhitespace();
				$char = $context->ScanCharacter();

				if ($char == '"')
				{
					$attributevalue = $context->scanUntilString('"');
					$context->IgnoreCharacter();
				}
				else if ($char == "'")
				{
					$attributevalue = $context->scanUntilString("'");
					$context->IgnoreCharacter();
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
	 * @return constant STATE_START
	 * @access protected
	 */
	function parse(&$context)
	{
		$tag = $context->scanUntilCharacters("/> \n\r\t");

		if ($tag != '')
		{
			$this->attrs = [];
			$Attributes = $this->parseAttributes($context);
			$char = $context->scanCharacter();

			if ($char == '/')
			{
				$char = $context->scanCharacter();

				if ($char != '>')
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
