<?php
/**
 * SafeHTML Parser
 *
 * PHP version 8
 *
 * @category	HTML
 * @package		SafeHTML
 * @author		Roman Ivanov <thingol@mail.ru>
 * @author		Miguel Vazquez Gocobachi <demrit@mx.gnu.org>
 * @copyright	2004-2023 Roman Ivanov, Miguel Vazquez Gocobachi, WackoWiki Team
 * @license		http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version		1.3.13
 * @link		https://wackowiki.org/doc/Dev/Projects/SafeHTML
 */

/**
 * This package requires HTMLSax3 package
 * @see autoload.conf
 */
use HTMLSax3\ {
	HTMLSax3,
};

/**
 * HTML_Safe Parser
 *
 * This parser strips down all potentially dangerous content within HTML:
 * <ul>
 * <li>opening tag without its closing tag</li>
 * <li>closing tag without its opening tag</li>
 * <li>any of these tags: "base", "basefont", "head", "html", "body", "applet",
 * "object", "iframe", "frame", "frameset", "script", "layer", "ilayer", "embed",
 * "bgsound", "link", "meta", "style", "title", "blink", "xml" etc.</li>
 * <li>any of these attributes: on*, data*, dynsrc</li>
 * <li>javascript:/vbscript:/about: etc. protocols</li>
 * <li>expression/behavior etc. in styles</li>
 * <li>any other active content</li>
 * </ul>
 * It also tries to convert code to XHTML valid, but htmltidy is far better
 * solution for this task.
 *
 * <b>Example:</b>
 * <pre>
 * $parser = new SafeHTML();
 * $result = $parser->parse($doc);
 * </pre>
 */

class SafeHTML
{
	/**
	 * Storage for resulting HTML output
	 */
	protected string $xhtml = '';

	/**
	 * Array of counters for each tag
	 */
	protected array $counter = [];

	/**
	 * Stack of unclosed tags
	 */
	protected array $stack = [];

	/**
	 * Array of counters for tags that must be deleted with all content
	 */
	protected array $dcCounter = [];

	/**
	 * Stack of unclosed tags that must be deleted with all content
	 */
	protected array $dcStack = [];

	/**
	 * Stores level of list (ol/ul) nesting
	 */
	protected int $listScope = 0;

	/**
	 * Stack of unclosed list tags
	 */
	protected array $liStack = [];

	/**
	 * Array of prepared regular expressions for protocols (schemas) matching
	 */
	protected array $protoRegexps = [];

	/**
	 * Array of prepared regular expressions for CSS matching
	 */
	protected array $cssRegexps = [];

	/**
	 * Allowed tags
	 */
	protected array $allowTags = [];


	/**
	 * List of single tags ("<tag>")
	 */
	public array $singleTags = ['area', 'br', 'img', 'input', 'hr', 'wbr', ];

	/**
	 * List of dangerous tags (such tags will be deleted)
	 */
	public array $deleteTags = [
		'applet', 'base',   'basefont', 'bgsound', 'blink',  'body',
		'embed',  'frame',  'frameset', 'head',    'html',   'ilayer',
		'iframe', 'layer',  'link',     'meta',    'object', 'style',
		'title',  'script',
	];

	/**
	 * List of dangerous tags (such tags will be deleted, and all content
	 * inside this tags will be also removed)
	 */
	public array $deleteTagsContent = ['script', 'style', 'title', 'xml', ];

	/**
	 * Type of protocols filtering ('white' or 'black')
	 */
	public string $protocolFiltering = 'white';

	/**
	 * List of "dangerous" protocols (used for blacklist-filtering)
	 */
	public array $blackProtocols = [
		'about',   'chrome',     'data',       'disk',     'hcp',
		'help',    'javascript', 'livescript', 'lynxcgi',  'lynxexec',
		'ms-help', 'ms-its',     'mhtml',      'mocha',    'opera',
		'res',     'resource',   'shell',      'vbscript', 'view-source',
		'vnd.ms.radio',          'wysiwyg',
	];

	/**
	 * List of "safe" protocols (used for whitelist-filtering)
	 */
	public array $whiteProtocols = [
		'ed2k',   'file', 'ftp',  'gopher', 'http',   'https',
		'irc',    'mailto', 'news', 'nntp', 'telnet', 'webcal',
		'xmpp',   'callto',
	];

	/**
	 * List of attributes that can contain protocols
	 */
	public array $protocolAttributes = [
		'action', 'background', 'codebase', 'dynsrc', 'href', 'lowsrc', 'src',
	];

	/**
	 * List of dangerous CSS keywords
	 *
	 * Whole style="" attribute will be removed, if parser will find one of
	 * these keywords
	 */
	public array $cssKeywords = [
		'absolute', 'behavior',       'behaviour',   'content', 'expression',
		'fixed',    'include-source', 'moz-binding',
	];

	/**
	 * List of tags that can have no "closing tag"
	 *
	 * @deprecated XHTML does not allow such tags
	 */
	public array $noClose = [];

	/**
	 * List of block-level tags that terminates paragraph
	 *
	 * Paragraph will be closed when this tags opened
	 */
	public array $closeParagraph = [
		'address',	'article',	'aside',		'blockquote',	'details',	'div',
		'dl',		'fieldset',	'figcaption',	'figure',		'footer',	'form',
		'h1',		'h2',		'h3',			'h4',			'h5',		'h6',
		'header',	'hgroup',	'hr',			'main',			'menu',		'nav',
		'ol',		'p',		'pre',			'section',		'table',	'ul',
	];

	/**
	 * List of table tags, all table tags outside a table will be removed
	 */
	public array $tableTags = [
		'caption', 'col', 'colgroup', 'tbody', 'td', 'tfoot', 'th',
		'thead',   'tr',
	];

	/**
	 * List of list tags
	 */
	public array $listTags = ['menu', 'ol', 'ul', 'dl', ];

	/**
	 * List of dangerous attributes
	 */
	public array $attributes = ['dynsrc', 'id', 'name', ];

	/**
	 * List of allowed "namespaced" attributes
	 */
	public array $attributesNS = ['xml:lang', ];

	/**
	 * Constructs class
	 */
	public function __construct()
	{
		//making regular expressions based on Proto & CSS arrays
		foreach ($this->blackProtocols as $proto)
		{
			$preg = "/[\s\x01-\x1F]*";

			for ($i = 0; $i < strlen($proto); $i++)
			{
				$preg .= $proto[$i] . "[\s\x01-\x1F]*";
			}

			$preg .= ":/i";
			$this->protoRegexps[] = $preg;
		}

		foreach ($this->cssKeywords as $css)
		{
			$this->cssRegexps[] = '/' . $css . '/i';
		}

		return true;
	}

	/**
	 * Handles the writing of attributes - called from $this->openHandler()
	 *
	 * @param array $attrs array of attributes $name => $value
	 */
	protected function writeAttrs(array $attrs): bool
	{
		if (is_array($attrs))
		{
			foreach ($attrs as $name => $value)
			{
				$name = strtolower($name);

				if (str_starts_with($name, 'on'))
				{
					continue;
				}

				if (str_starts_with($name, 'data'))
				{
					continue;
				}

				if (in_array($name, $this->attributes))
				{
					continue;
				}

				if (!preg_match('/^[a-z\d]+$/i', $name))
				{
					if (!in_array($name, $this->attributesNS))
					{
						continue;
					}
				}

				if (($value === true) || (is_null($value)))
				{
					$value = $name;
				}

				if ($name == 'style')
				{
					// removes insignificant backslashes
					$value = str_replace("\\", '', $value);

					// removes CSS comments
					while (1)
					{
						$_value = preg_replace('!/\*.*?\*/!s', '', $value);

						if ($_value == $value)
						{
							break;
						}

						$value = $_value;
					}

					// replace all & to &amp;
					$value = str_replace('&amp;', '&', $value);
					$value = str_replace('&', '&amp;', $value);

					foreach ($this->cssRegexps as $css)
					{
						if (preg_match($css, $value))
						{
							continue 2;
						}
					}

					foreach ($this->protoRegexps as $proto)
					{
						if (preg_match($proto, $value))
						{
							continue 2;
						}
					}
				}

				$tempval = preg_replace_callback('/&#(\d+);?/m', function ($matches) { return chr($matches[1]); }, $value); //"'
				$tempval = preg_replace_callback(
					'/&#x([a-f\d]+);?/mi',
					function ($matches) { return chr(hexdec($matches[1])); },
					$tempval
				);

				if ((in_array($name, $this->protocolAttributes))
					&& (str_contains($tempval, ':'))
				)
				{
					if ($this->protocolFiltering == 'black')
					{
						foreach ($this->protoRegexps as $proto)
						{
							if (preg_match($proto, $tempval))
							{
								continue 2;
							}
						}
					}
					else
					{
						$_tempval	= explode(':', $tempval);
						$proto		= $_tempval[0];

						if (!in_array($proto, $this->whiteProtocols))
						{
							continue;
						}
					}
				}

				$value		  = str_replace("\"", '&quot;', $value);
				$this->xhtml .= ' ' . $name . '="' . $value . '"';
			}
		}

		return true;
	}

	/**
	 * Opening tag handler - called from HTMLSax
	 */
	public function openHandler(object &$parser, string $name, array $attrs): bool
	{
		$name = strtolower($name);

		if (in_array($name, $this->deleteTagsContent))
		{
			$this->dcStack[] = $name;
			$this->dcCounter[$name] = isset($this->dcCounter[$name])
				? $this->dcCounter[$name] + 1
				: 1;
		}

		if (count($this->dcStack) != 0)
		{
			return true;
		}

		if (    in_array($name, $this->deleteTags)
			&& !in_array($name, $this->allowTags)
		)
		{
			return true;
		}

		if (!preg_match('/^[a-z\d]+$/i', $name))
		{
			if (preg_match('!(?:\@|://)!i', $name))
			{
				$this->xhtml .= '&lt;' . $name . '&gt;';
			}

			return true;
		}

		if (in_array($name, $this->singleTags))
		{
			$this->xhtml .= '<' . $name;
			$this->writeAttrs($attrs);
			$this->xhtml .= ' />';

			return true;
		}

		// TABLES: cannot open table elements when we are not inside table
		if ((isset($this->counter['table']))
			&& ($this->counter['table'] <= 0)
			&& (in_array($name, $this->tableTags))
		)
		{
			return true;
		}

		// PARAGRAPHS: close paragraph when closeParagraph tags opening
		if ((in_array($name, $this->closeParagraph))
			&& (in_array('p', $this->stack))
		)
		{
			$this->closeHandler($parser, 'p');
		}

		// LISTS: we should close <li> if <li> of the same level opening
		if (($name == 'li') && count($this->liStack)
			&& ($this->listScope == $this->liStack[count($this->liStack) - 1])
		)
		{
			$this->closeHandler($parser, 'li');
		}

		// LISTS: we want to know on what nesting level of lists we are
		if (in_array($name, $this->listTags))
		{
			++$this->listScope;
		}

		if ($name == 'li')
		{
			$this->liStack[] = $this->listScope;
		}

		$this->xhtml .= '<' . $name;
		$this->writeAttrs($attrs);
		$this->xhtml .= '>';
		$this->stack[] = $name;
		$this->counter[$name] = isset($this->counter[$name])
			? ($this->counter[$name] + 1)
			: 1;

		return true;
	}

	/**
	 * Closing tag handler - called from HTMLSax
	 */
	public function closeHandler(object &$parser, string $name): bool
	{
		$name = strtolower($name);

		if (isset($this->dcCounter[$name])
			&& ($this->dcCounter[$name] > 0)
			&& (in_array($name, $this->deleteTagsContent))
		)
		{
			while ($name != ($tag = array_pop($this->dcStack)))
			{
				--$this->dcCounter[$tag];
			}

			--$this->dcCounter[$name];
		}

		if (count($this->dcStack) != 0)
		{
			return true;
		}

		if ((isset($this->counter[$name])) && ($this->counter[$name] > 0))
		{
			while ($name != ($tag = array_pop($this->stack)))
			{
				$this->closeTag($tag);
			}

			$this->closeTag($name);
		}

		return true;
	}

	/**
	 * Closes tag
	 */
	protected function closeTag(string $tag): bool
	{
		if (!in_array($tag, $this->noClose))
		{
			$this->xhtml .= '</' . $tag . '>';
		}

		--$this->counter[$tag];

		if (in_array($tag, $this->listTags))
		{
			--$this->listScope;
		}

		if ($tag == 'li')
		{
			array_pop($this->liStack);
		}

		return true;
	}

	/**
	 * Character data handler - called from HTMLSax
	 */
	public function dataHandler(object &$parser, string $data): bool
	{
		if (count($this->dcStack) == 0)
		{
			$this->xhtml .= $data;
		}

		return true;
	}

	/**
	 * Escape handler - called from HTMLSax
	 */
	public function escapeHandler(object &$parser, string $data): bool
	{
		return true;
	}

	/**
	 * Allow tags
	 *
	 * Example:
	 * <pre>
	 * $safe = new SafeHTML();
	 * $safe->setAllowTags(['body']);
	 * </pre>
	 */
	public function setAllowTags(array $tags = []): void
	{
		if (is_array($tags))
		{
			$this->allowTags = $tags;
		}
	}

	/**
	 * Returns the allowed tags
	 */
	public function getAllowTags(): array
	{
		return $this->allowTags;
	}

	/**
	 * Reset the allowed tags
	 */
	public function resetAllowTags(): void
	{
		$this->allowTags = [];
	}

	/**
	 * Returns the (X)HTML document
	 */
	public function getXHTML(): string
	{
		while ($tag = array_pop($this->stack))
		{
			$this->closeTag($tag);
		}

		return $this->xhtml;
	}

	/**
	 * Clears current document data
	 */
	public function clear(): bool
	{
		$this->xhtml = '';

		return true;
	}

	/**
	 * Main parsing function
	 *
	 * @param string $doc HTML document for processing
	 *
	 * @return string Processed (X)HTML document
	 */
	public function parse(string $doc): string
	{
		$result = '';

		// Save all '<' symbols
		$doc = preg_replace('/<(?=[^a-zA-Z\/\!\?\%])/', '&lt;', $doc);

		// UTF7 pack
		$doc = $this->repackUTF7($doc);

		// Instantiate the parser
		$parser = new HTMLSax3();

		// Set up the parser
		$parser->set_object($this);

		$parser->set_element_handler('openHandler', 'closeHandler');
		$parser->set_data_handler('dataHandler');
		$parser->set_escape_handler('escapeHandler');

		$parser->parse($doc);

		$result = $this->getXHTML();

		$this->clear();

		return $result;
	}

	/**
	 * UTF-7 decoding function
	 *
	 * @param string $str HTML document for recode ASCII part of UTF-7 back to ASCII
	 * @return string Decoded document
	 */
	private function repackUTF7(string $str): string
	{
		return preg_replace_callback('!\+([a-zA-Z\d/]+)\-!', [$this, 'repackUTF7Callback'], $str);
	}

	/**
	 * Additional UTF-7 decoding function
	 *
	 * @param string $str String for recode ASCII part of UTF-7 back to ASCII
	 * @return string Recoded string
	 */
	private function repackUTF7Callback(string $str): string
	{
		$str = base64_decode($str[1]);
		$str = preg_replace_callback('/^((?:\x00.)*)((?:[^\x00].)+)/', [$this, 'repackUTF7Back'], $str);

		return preg_replace('/\x00(.)/', '$1', $str);
	}

	/**
	 * Additional UTF-7 encoding function
	 *
	 * @param string $str String for recode ASCII part of UTF-7 back to ASCII
	 * @return string Recoded string
	 */
	private function repackUTF7Back(string $str): string
	{
		return $str[1] . '+' . rtrim(base64_encode($str[2]), '=') . '-';
	}
}

