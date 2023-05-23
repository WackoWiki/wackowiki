<?php

namespace HTMLSax3;

/**
 * Define parser states
 */
const STATE_STOP			= 0;
const STATE_START			= 1;
const STATE_TAG				= 2;
const STATE_OPENING_TAG		= 3;
const STATE_CLOSING_TAG		= 4;
const STATE_ESCAPE			= 6;
const STATE_JASP			= 7;
const STATE_PI				= 8;

/**
 * Base State Parser
 * @package HTMLSax3
 * @access protected
 * @abstract
 */
class StateParser
{
	/**
	 * Instance of user front end class to be passed to callbacks
	 * @var HTMLSax3
	 * @access private
	 */
	public $htmlsax;
	/**
	 * User defined object for handling elements
	 * @var object
	 * @access private
	 */
	public $handler_object_element;
	/**
	 * User defined open tag handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_opening;
	/**
	 * User defined close tag handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_closing;
	/**
	 * User defined object for handling data in elements
	 * @var object
	 * @access private
	 */
	public $handler_object_data;
	/**
	 * User defined data handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_data;
	/**
	 * User defined object for handling processing instructions
	 * @var object
	 * @access private
	 */
	public $handler_object_pi;
	/**
	 * User defined processing instruction handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_pi;
	/**
	 * User defined object for handling JSP/ASP tags
	 * @var object
	 * @access private
	 */
	public $handler_object_jasp;
	/**
	 * User defined JSP/ASP handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_jasp;
	/**
	 * User defined object for handling XML escapes
	 * @var object
	 * @access private
	 */
	public $handler_object_escape;
	/**
	 * User defined XML escape handler method
	 * @var string
	 * @access private
	 */
	public $handler_method_escape;
	/**
	 * User defined handler object or NullHandler
	 * @var object
	 * @access private
	 */
	public $handler_default;
	/**
	 * Parser options determining parsing behavior
	 * @var array
	 * @access private
	 */
	public $parser_options = [];
	/**
	 * XML document being parsed
	 * @var string
	 * @access private
	 */
	public $rawtext;
	/**
	 * Position in XML document relative to start (0)
	 * @var int
	 * @access private
	 */
	public $position;
	/**
	 * Length of the XML document in characters
	 * @var int
	 * @access private
	 */
	public $length;
	/**
	 * Array of state objects
	 * @var array
	 * @access private
	 */
	public $State = [];

	/**
	 * Constructs StateParser setting up states
	 * @var HTMLSax3 instance of user front end class
	 * @access protected
	 */
	function __construct (& $htmlsax)
	{
		$this->htmlsax = & $htmlsax;
		$this->State[STATE_START]			= new StartingState();

		$this->State[STATE_CLOSING_TAG]		= new ClosingTagState();
		$this->State[STATE_TAG]				= new TagState();
		$this->State[STATE_OPENING_TAG]		= new OpeningTagState();

		$this->State[STATE_PI]				= new PiState();
		$this->State[STATE_JASP]			= new JaspState();
		$this->State[STATE_ESCAPE]			= new EscapeState();

		$this->parser_options['XML_OPTION_TRIM_DATA_NODES']		= 0;
		$this->parser_options['XML_OPTION_CASE_FOLDING']		= 0;
		$this->parser_options['XML_OPTION_LINEFEED_BREAK']		= 0;
		$this->parser_options['XML_OPTION_TAB_BREAK']			= 0;
		$this->parser_options['XML_OPTION_ENTITIES_PARSED']		= 0;
		$this->parser_options['XML_OPTION_ENTITIES_UNPARSED']	= 0;
		$this->parser_options['XML_OPTION_STRIP_ESCAPES']		= 0;
	}

	/**
	 * Moves the position back one character
	 * @access protected
	 * @return void
	 */
	function unscanCharacter(): void
	{
		$this->position -= 1;
	}

	/**
	 * Moves the position forward one character
	 * @access protected
	 * @return void
	 */
	function ignoreCharacter(): void
	{
		$this->position += 1;
	}

	/**
	 * Returns the next character from the XML document or void if at end
	 * @access protected
	 * @return string|void
	 */
	function scanCharacter()
	{
		if ($this->position < $this->length)
		{
			return $this->rawtext[$this->position++];
		}
	}

	/**
	 * Returns a string from the current position to the next occurance
	 * of the supplied string
	 * @param string $string to search until
	 * @access protected
	 * @return string
	 */
	function scanUntilString($string): string
	{
		$start = $this->position;
		$this->position = strpos($this->rawtext, $string, $start);

		if ($this->position === false)
		{
			$this->position = $this->length;
		}

		return substr($this->rawtext, $start, $this->position - $start);
	}

	/**
	 * Returns a string from the current position until the first instance of
	 * one of the characters in the supplied string argument.
	 * @param string $string to search until
	 * @access protected
	 * @return string
	 */
	function scanUntilCharacters($string): string
	{
		$startpos = $this->position;
		$length = strcspn($this->rawtext, $string, $startpos);
		$this->position += $length;

		return substr($this->rawtext, $startpos, $length);
	}

	/**
	 * Moves the position forward past any whitespace characters
	 * @access protected
	 * @return void
	 */
	function ignoreWhitespace(): void
	{
		$this->position += strspn($this->rawtext, " \n\r\t", $this->position);
	}

	/**
	 * Begins the parsing operation, setting up any decorators, depending on
	 * parse options invoking _parse() to execute parsing
	 * @param string $data XML document to parse
	 * @access protected
	 * @return void
	 */
	function parse($data): void
	{
		if ($this->parser_options['XML_OPTION_TRIM_DATA_NODES'] == 1)
		{
			$decorator = new Trim(
				$this->handler_object_data,
				$this->handler_method_data);
			$this->handler_object_data =& $decorator;
			$this->handler_method_data = 'trimData';
		}

		if ($this->parser_options['XML_OPTION_CASE_FOLDING'] == 1)
		{
			$open_decor = new CaseFolding(
				$this->handler_object_element,
				$this->handler_method_opening,
				$this->handler_method_closing);
			$this->handler_object_element =& $open_decor;
			$this->handler_method_opening ='foldOpen';
			$this->handler_method_closing ='foldClose';
		}

		if ($this->parser_options['XML_OPTION_LINEFEED_BREAK'] == 1)
		{
			$decorator = new Linefeed(
				$this->handler_object_data,
				$this->handler_method_data);
			$this->handler_object_data =& $decorator;
			$this->handler_method_data = 'breakData';
		}

		if ($this->parser_options['XML_OPTION_TAB_BREAK'] == 1)
		{
			$decorator = new Tab(
				$this->handler_object_data,
				$this->handler_method_data);
			$this->handler_object_data =& $decorator;
			$this->handler_method_data = 'breakData';
		}

		if ($this->parser_options['XML_OPTION_ENTITIES_UNPARSED'] == 1)
		{
			$decorator = new Entities_Unparsed(
				$this->handler_object_data,
				$this->handler_method_data);
			$this->handler_object_data =& $decorator;
			$this->handler_method_data = 'breakData';
		}

		if ($this->parser_options['XML_OPTION_ENTITIES_PARSED'] == 1)
		{
			$decorator = new Entities_Parsed(
				$this->handler_object_data,
				$this->handler_method_data);
			$this->handler_object_data =& $decorator;
			$this->handler_method_data = 'breakData';
		}

		// Note switched on by default
		if ($this->parser_options['XML_OPTION_STRIP_ESCAPES'] == 1)
		{
			$decorator = new Escape_Stripper(
				$this->handler_object_escape,
				$this->handler_method_escape);
			$this->handler_object_escape =& $decorator;
			$this->handler_method_escape = 'strip';
		}

		$this->rawtext	= $data;
		$this->length	= strlen($data);
		$this->position	= 0;
		$this->_parse();
	}

	/**
	 * Performs the parsing itself, delegating calls to a specific parser
	 * state
	 * @param constant $state object to parse with
	 * @access protected
	 * @return void
	 */
	function _parse($state = STATE_START): void
	{
		do {
			$state = $this->State[$state]->parse($this);
		} while ($state != STATE_STOP &&
		$this->position < $this->length);
	}
}
