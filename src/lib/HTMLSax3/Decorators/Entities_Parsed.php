<?php

declare(strict_types=1);

namespace HTMLSax3;

/**
 * Breaks up data by XML entities and parses them with html_entity_decode(),
 * resulting in additional calls to the data handler<br />
 * @package HTMLSax3
 * @access protected
 */
class Entities_Parsed
{
	/**
	 * Original handler object
	 * @var object
	 * @access private
	 */
	public object $orig_obj;

	/**
	 * Original handler method
	 * @var string
	 * @access private
	 */
	public string $orig_method;

	/**
	 * Constructs Entities_Parsed
	 * @param object $orig_obj handler object being decorated
	 * @param string $orig_method original handler method
	 * @access protected
	 */
	public function __construct(object &$orig_obj, string $orig_method)
	{
		$this->orig_obj    = &$orig_obj;
		$this->orig_method = $orig_method;
	}

	/**
	 * Breaks the data up by XML entities
	 * @param HTMLSax3 $parser
	 * @param string $data element data
	 * @access protected
	 */
	public function breakData(HTMLSax3 $parser, string $data): void
	{
		$chunks = preg_split(
			'/(&.+?;)/',
			$data,
			-1,
			PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY,
			);

		foreach ($chunks as $chunk)
		{
			$decoded = html_entity_decode($chunk, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
			$this->orig_obj->{$this->orig_method}($this, $decoded);
		}
	}
}