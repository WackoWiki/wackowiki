<?php

/*
* WackoFormatter.
*
* Formats text with wacko-formatting.
* Links and actions aren't processed. It's processed by PostWacko formatter
*/

class WackoFormatter
{
	public $object;
	public $page_id;
	public $table_scope;
	public int $old_indent_level	= 0;
	public array $indent_closers	= [];
	public int $tdold_indent_level	= 0;
	public array $auto_fn			= [];
	public array $tdindent_closers	= [];
	public bool $br					= true;
	public bool $caption			= false;
	public bool $intable			= false;
	public bool $intable_br			= false;
	public int $cols				= 0;
	public string $LONG_REGEX;
	public string $MIDDLE_REGEX;
	public string $PRE_REGEX;
	public string $INTERWIKI_PATTERN;
	private $tdold_indent_type;
	private $old_indent_type;
	public array $colors			= [
		'blue',
		'green',
		'red',
		'yellow',
	];
	public array $x11_colors		= [
		'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque',
		'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue',
		'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan',
		'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki',
		'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon',
		'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet',
		'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite',
		'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray',
		'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory',
		'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue',
		'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey',
		'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray',
		'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon',
		'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen',
		'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred',
		'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy',
		'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod',
		'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru',
		'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown',
		'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue',
		'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle',
		'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen',
		'xblue', 'xgreen', 'xred', // x-replacement for X11 colors to highlight text
	];

	function __construct( &$object )
	{
		$this->object = &$object;

		// interwiki link: "prefix:target"
		// the target may contain a percent encoded text fragment ("#:~:text=hello%20world"),
		// therefore the percent sign has to be allowed as well
		$this->INTERWIKI_PATTERN = '[[:alnum:]]+:[' . $object::PATTERN['ALPHANUM_P'] . '\!\.][' . $object::PATTERN['ALPHANUM_P'] . '\.\~\!\$\&\'\(\)\*\+\,\;\=\:\@\?\#\%]';


		$this->LONG_REGEX =
			'/(' .
			// escaped text
			"<!--escaped-->.*?<!--escaped-->|" .
			// escaped html <#...#>
			($this->object->db->allow_rawhtml
				? '\<\#.*?\#\>|'
				: '') .
			// html comments
			#"<!--.*-->|" .
			// definition  (?...?)
			"\(\?(\S+?)([ \t]+([^\n]+?))?\?\)|" .
			// bracket links [[tag description]] or ((tag description))
			($this->object->db->disable_bracketslinks
				? ''
				: "\[\[(\S+?)([ \t]+([^\n]+?))?\]\]|" .
				  "\(\((\S+?)([ \t]+([^\n]+?))?\)\)|") .
			// citated  > ... or  >> ...
			"\n[ \t]*>+[^\n]*|" .
			// cite text <[...]>
			"<\[.*?\]>|" .
			// small text ++...++
			"\+\+\S\+\+|" .
			"\+\+(\S[^\n]*?\S)\+\+|" .
			// link ...://... or [mailto|xmpp]:...@...
			"\b[[:alpha:]]+:\/\/" . $object::PATTERN['URI'] . "+|(mailto|xmpp)\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\_\.]+|" .
			// geo: | tel:
			"(geo|tel)\:[" . $object::PATTERN['ALPHANUM_P'] . "\.\~\!\$\&\'\(\)\*\+\,\;\=\:\@\?\#]+|" .
			// highlighting  ??...??
			"\?\?\S\?\?|" .
			"\?\?(\S.*?\S)\?\?|" .
			// \\\\...
			"\\\\\\\\[" . $object::PATTERN['ALPHANUM_P'] . "\-\_\\\!\.]+|" .
			// bold text **...**
			"\*\*[^\n]*?\*\*|" .
			// code ##...##
			"\#\#[^\n]*?\#\#|" .
			// note !!...!!
			"\!\!\S\!\!|" .
			"\!\!(\S.*?\S)\!\!|" .
			// underline __...__
			"__[^\n]*?__|" .
			// superscript ^^...^^
			"\^\^\S*?\^\^|" .
			// subscript ,,...,,
			",,\S*?,,|" .
			// deleted text for diff
			// inserted text for diff
			"<!--markup:1:begin-->\S<!--markup:1:end-->|" .
			"<!--markup:2:begin-->\S<!--markup:2:end-->|" .
			"<!--markup:1:begin-->(\S.*?\S)<!--markup:1:end-->|" .
			"<!--markup:2:begin-->(\S.*?\S)<!--markup:2:end-->|" .
			// tables #|| #| ||...|| ||# |#
			"\#\|\||" .
			"\#\|(?:\((?:\s*\w+\s*=\s*(?:\"([^)\"]+)\"|([^)\s]+))\s*)+\))?|" .
			"\|\|\#|" .
			"\|\#|" .
			"\|\|.*?\|\||" .
			"\*\|.*?\|\*|" .
			// colgroup
			"\!\|.*?\|\!|" .
			"\^\|.*?\|\||" .
			// caption
			"\?\|.*?\|\?|" .
			// symbols < or >
			"<|>|" .
			// italic //...//
			"\/\/[^\n]*?(?<!http:|https:|ftp:|file:|nntp:)\/\/|" .
			// headers
			"\n[ \t]*={2,7}.*?={2,7}|" .
			// separator
			"-{4,}|" .
			// line break
			"---[ \t]*(?=(?<eol>\n))|---[ \t]*|" .
			// strikethrough
			"--\S--|" .
			"--(\S.*?[^- \t\n\r])--|" .
			// list including multilevel
			"\n(\t+|([ ]{2})+)(-|\*|([a-zA-Z]{1,3}|[ivIV]+|(\d{1,3}))[\.\)](\#\d{1,3})?)?|" .
			// media links
			"file:((\.\.|!)?\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/\-\_\.]+\.(" . $object::PATTERN['AUDIO'] . '|' . $object::PATTERN['BITMAP'] . '|' . $object::PATTERN['DRAWING'] . '|' . $object::PATTERN['VIDEO'] . ")(\?[[:alnum:]\&]+)?|" .
			// interwiki links
			"\b" . $this->INTERWIKI_PATTERN . "+|" .
			// disabled WikiNames
			"~([^ \t\n]+)|" .
			// wiki links (beside actions)
			($this->object->db->disable_wikilinks
				? ''
				: "(~?)(?<=[^\." . $object::PATTERN['ALPHANUM_P'] . "]|^)(((\.\.|!)?\/)?" . $object::PATTERN['UPPER'] . $object::PATTERN['LOWER'] . "+" . $object::PATTERN['UPPERNUM'] . $object::PATTERN['ALPHANUM'] . "*)\b|") .
			"\n)/usm";

		$this->PRE_REGEX =
			"/(" .
			// formatter  %%...%% and ``...``
			($this->object->db->disable_formatters
				? ''
				: "``.*?``|" .
				  "\%\%.*?\%\%|") .
			// escaped ~...
			"~([^ \t\n]+)|" .
			// escaped  ""...""
			"\"\".*?\"\"|" .
			// action  {{...}}
			"\{\{.*?\}\}|" .
			// escaped text
			"<!--escaped-->.*?<!--escaped-->" .
			")/usm";

		$this->MIDDLE_REGEX =
			"/(" .
			// centered text  >>...<< (deprecated)
			">>.*?<<|" .
			// escaped  ~...
			"~([^ \t\n]+)|" .
			// escaped text
			"<!--escaped-->.*?<!--escaped-->" .
			")/usm";
	}

	function indent_close(): string
	{
		$result = '';

		if ($this->intable)
		{
			$closers = &$this->tdindent_closers;
		}
		else
		{
			$closers = &$this->indent_closers;
		}

		$c = count($closers);

		for ($i = 0; $i < $c; $i++)
		{
			$result .= array_pop($closers);
		}

		if ($this->intable)
		{
			$this->tdold_indent_level	= 0;
		}
		else
		{
			$this->old_indent_level		= 0;
		}

		return $result;
	}

	function wacko_preprocess($things)
	{
		$formatter	= '';
		$output		= '';
		$thing		= $things[1];
		$wacko		= &$this->object;
		$callback	= [&$this, 'wacko_preprocess'];

		// escaped ~...
		if (!empty($thing[0]) && $thing[0] == '~')
		{
			if ($thing[1] == '~')
			{
				return '~~' . $this->wacko_preprocess([0, mb_substr($thing, 2)]);
			}
		}

		// escaped text
		if (preg_match('/^<!--escaped-->(.*)<!--escaped-->$/us', $thing, $matches))
		{
			return $matches[1];
		}
		// escaped  ""...""
		else if (preg_match('/^\"\"(.*)\"\"$/us', $thing, $matches))
		{
			return
				'<!--escaped--><!--notypo-->' .
					str_replace("\n", '<br>', Ut::html($matches[1])) .
				'<!--/notypo--><!--escaped-->';
		}
		// formatter text  %%...%% and ``...``
		else if (  preg_match('/^``(.*)``$/us',		$thing, $matches1)
				|| preg_match('/^\%\%(.*)\%\%$/us',	$thing, $matches2))
		{
			// check if a formatter has been specified
			$code = $matches1[1] ?? $matches2[1];

			if (preg_match('/^\(\s*(.*?)\)(.*)$/us', $code, $matches))
			{
				$code = $matches[2];

				if ($matches[1])
				{
					// check for formatter parameters
					$sep = mb_strpos($matches[1], ' ');

					if ($sep === false)
					{
						$formatter	= $matches[1];
						$params		= [];
					}
					else
					{
						$formatter	= mb_substr($matches[1], 0, $sep);
						$p			= ' ' . mb_substr($matches[1], $sep) . ' ';
						$params		= [];
						$c			= 0;

						preg_match_all('/(([^\s=]+)(\s*=\s*((\"(.*?)\")|([^\"\s]+)))?)\s/u', $p, $matches, PREG_SET_ORDER);

						foreach ($matches as $m)
						{
							$value			= isset($m[3]) && $m[3] ? ($m[5] ? $m[6] : $m[7]) : '1';
							$params[$c]		= $value;
							$params[$m[2]]	= $value;

							if ($c == 0)
							{
								$params['_default'] = $m[2];
							}

							$c++;
						}
					}
				}
			}

			// no formatter specified, use default
			if ($formatter == '')
			{
				$formatter = 'code';
			}

			// TODO: Trim empty, whitespace only lines at the beginning
			// disabled trim($code), whitespace (or other characters) might be intentional in code examples
			$code = ltrim($code, "\n\r\0");
			$code = rtrim($code);

			$result = $wacko->_format($code, 'highlight/' . $formatter, $params);

			// add wrapper
			if (isset($params['wrapper']) && ($params['wrapper'] != 'none'))
			{
				$wrapper			= 'wrapper_' . $params['wrapper'];
				$params['wrapper']	= ''; // no recursion
				$result				= $wacko->_format(trim($result), 'highlight/' . $wrapper, $params);
			}

			$output .= $result;

			return '<!--escaped-->' . $output . '<!--escaped-->';
		}
		// action  {{...}}
		else if (preg_match('/^\{\{(.*?)\}\}$/us', $thing, $matches))
		{
			// used in paragrafica, too
			// the action is placed inside an HTML comment and is delimited by markers,
			// it must neither terminate the comment ("-->") nor contain the markers
			// themselves, otherwise the rest of the action would end up as raw HTML
			$action	= str_replace('-->', '--&gt;', str_replace("\n", ' ', $matches[1]));

			return
				'<!--escaped--><ignore><!--notypo--><!--action:begin-->' .
					$action .
				'<!--action:end--><!--/notypo--></ignore><!--escaped-->';
		}

		// if we reach this point, it must have been an accident
		return $thing;
	}

	function wacko_middleprocess($things)
	{
		$thing		= $things[1];
		$wacko		= &$this->object;
		$callback	= [&$this, 'wacko_callback'];

		if (!empty($thing[0]) && $thing[0] == '~')
		{
			if ($thing[1] == '~')
			{
				return '~~' . $this->wacko_middleprocess( [0, mb_substr($thing, 2)] );
			}
		}

		// escaped text
		if (preg_match('/^<!--escaped-->(.*)<!--escaped-->$/us', $thing, $matches))
		{
			return $matches[1];
		}
		// centered text (deprecated)
		else if (preg_match('/^>>(.*)<<$/us', $thing, $matches))
		{
			return
				'<!--escaped--><div class="center">' .
					preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) .
				'</div><!--escaped-->';
		}

		return $thing;
	}

	function wacko_callback($things)
	{
		$result		= null;
		$li			= '';
		$thing		= $things[1];
		$wacko		= & $this->object;
		$callback	= [&$this, 'wacko_callback'];

		// Resolve page_id for header anchors with explicit priority:
		// 1. formatter_page_id: explicit override for compilation context
		//    (comments being rendered outside the active page context, bulk resync)
		// 2. page['page_id']: the currently active page (normal rendering)
		if (isset($wacko->formatter_page_id))
		{
			$this->page_id = $wacko->formatter_page_id;
		}
		else if (isset($wacko->page['page_id']))
		{
			$this->page_id = $wacko->page['page_id'];
		}

		if (!$this->page_id || $wacko->new_comment)
		{
			// for new page or comment with not yet created db record
			// temporary random hashid for paragrafica (toc, p)
			$this->page_id = substr((string) hash('crc32', (string) time()), 0, 5);
		}

		// convert HTML thingies
		if ($thing == '<')
		{
			return '&lt;';
		}
		else if ($thing == '>')
		{
			return '&gt;';
		}
		// escaped text
		else if (preg_match('/^<!--escaped-->(.*)<!--escaped-->$/us', $thing, $matches))
		{
			return $matches[1];
		}
		// escaped html
		else if (preg_match('/^\<\#(.*)\#\>$/us', $thing, $matches))
		{
			if ($wacko->db->disable_safehtml)
			{
				return '<!--notypo-->' . $matches[1] . '<!--/notypo-->';
			}
			else
			{
				return '<!--notypo-->' . $wacko->format($matches[1], 'safehtml') . '<!--/notypo-->';
			}
		}
		// table begin
		else if ($thing == '#||')
		{
			$this->br			= false;
			$this->cols			= 0;
			$this->intable_br	= true;
			$this->table_scope	= true;

			return '<table class="dtable">';
		}
		else if (preg_match('/^\#\|((?:\((?:\s*\w+\s*=\s*(?:\"([^)\"]+)\"|([^)\s]+))\s*)+\)))?$/us', $thing, $matches))
		{
			$this->br			= false;
			$this->cols			= 0;
			$this->intable_br	= true;
			$this->table_scope	= true;

			$attr[] = 'class="usertable"';

			if (isset($matches[1]))
			{
				[$attr, ]			= $this->table_attr($matches[1], 'table');
			}

			return '<table ' . implode('', $attr ?? []) . '>';
		}
		// table end
		else if (($thing == '|#' || $thing == '||#') && $this->table_scope)
		{
			$this->br			= false;
			$this->caption		= false;
			$this->intable_br	= false;
			$this->table_scope	= false;

			return '</table>';
		}
		// table colgroup
		else if (preg_match('/^\!\|(.*?)\|\!$/us', $thing, $matches) && $this->table_scope)
		{
			return $this->table_cols($matches[1]);
		}
		// table caption
		else if (preg_match('/^\?\|(.*?)\|\?$/us', $thing, $matches) && $this->table_scope)
		{
			if ($this->caption)
			{
				return; // there can be only one caption
			}

			$this->caption	= true;
			$attr			= [];
			[$attr, $data]	= $this->table_attr($matches[1], 'caption');

			// FIXME: returns null when (attr) is missing for data
			return "\t" . '<caption ' . implode('', $attr ?? []) . '>' . preg_replace_callback($this->LONG_REGEX, $callback, $data ?? $matches[1]) . '</caption>';
		}
		// table head columns
		else if (preg_match('/^\*\|(.*?)\|\*$/us', $thing, $matches) && $this->table_scope)
		{
			return $this->table_rows($matches[1], $callback, 1);
		}
		// table head column or head row
		else if (preg_match('/^\^\|(.*?)\|\|$/us', $thing, $matches) && $this->table_scope)
		{
			return $this->table_rows($matches[1], $callback, 2);
		}
		// table row and cells
		else if (preg_match('/^\|\|(.*?)\|\|$/us', $thing, $matches) && $this->table_scope)
		{
			return $this->table_rows($matches[1], $callback);
		}
		// deleted
		else if (preg_match('/^<!--markup:1:begin-->((\S.*?\S)|(\S))<!--markup:1:end-->$/us', $thing, $matches))
		{
			$this->br = false;

			return '<del class="diff">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</del>';
		}
		// inserted
		else if (preg_match('/^<!--markup:2:begin-->((\S.*?\S)|(\S))<!--markup:2:end-->$/us', $thing, $matches))
		{
			$this->br = false;

			return '<ins class="diff">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</ins>';
		}
		// bold
		else if (preg_match('/^\*\*(.*?)\*\*$/u', $thing, $matches))
		{
			return '<strong>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</strong>';
		}
		// italic
		else if (preg_match('/^\/\/(.*?)\/\/$/u', $thing, $matches))
		{
			return '<em>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</em>';
		}
		// underline
		else if (preg_match('/^__(.*?)__$/u', $thing, $matches))
		{
			return '<span class="underline">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</span>';
		}
		// code
		else if (preg_match('/^\#\#(.*?)\#\#$/u', $thing, $matches))
		{
			return '<code>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</code>';
		}
		// small
		else if (preg_match('/^\+\+(.*?)\+\+$/u', $thing, $matches))
		{
			return '<small>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</small>';
		}
		// cite
		else if (preg_match('/^\!\!((\((\S*?)\)(.*?\S))|(\S.*?\S)|(\S))\!\!$/us', $thing, $matches))
		{
			$this->br = true;

			if (isset($matches[3])
				&& $color = in_array($matches[3], ($wacko->db->allow_x11colors ? $this->x11_colors : $this->colors)) ? $matches[3] : '')
			{
				return '<span class="cl-' . $color . '">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[4]) . '</span>';
			}

			return '<span class="cite">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</span>';
		}
		// mark
		else if (preg_match('/^\?\?((\((\S*?)\)(.*?\S))|(\S.*?\S)|(\S))\?\?$/us', $thing, $matches))
		{
			$this->br = true;

			if (isset($matches[3])
				&& $color = in_array($matches[3], ($wacko->db->allow_x11colors ? $this->x11_colors : $this->colors)) ? $matches[3] : '')
			{
				return '<mark class="mark-' . $color . '">' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[4]) . '</mark>';
			}

			return '<mark>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</mark>';
		}
		// urls
		else if (  preg_match('/^([[:alpha:]]+:\/\/' . $wacko::PATTERN['URI'] . '+?)([^[:alnum:]^\/\(\)\-\_\=]?)$/u', $thing, $matches)
				|| preg_match('/^(mailto\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\.\_]+?|xmpp\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\.\_]+?)([^[:alnum:]^\/\-\_\=]?)$/u', $thing, $matches))
		{
			// trailing punctuation ("http://example.com...", "http://example.com).'") belongs
			// to the text and must not be swallowed by the link, therefore the complete
			// token is split and not only the part which the regex has separated
			[$link, $punctuation] = $this->split_url_punctuation($thing);

			// an URL with an invalid host (e.g. "http://example..com") is no link at all
			if (!$this->is_valid_url($link))
			{
					return Ut::html($thing);
			}

			$url = mb_strtolower($link);

			if (preg_match('/^(https?|ftps?):\/\/([^\\s\"<>]+)\.((' . $wacko::PATTERN['AUDIO'] . ')|(' . $wacko::PATTERN['BITMAP'] . '|' . $wacko::PATTERN['DRAWING'] . ')|(' . $wacko::PATTERN['VIDEO'] . '))$/u', $url, $media))
			{
				// audio
				if ($media[4])
				{
					return '<audio src="' . Ut::html($link) . '" controls></audio>' . $punctuation;
				}
				// image
				if ($media[5])
				{
					return '<img src="' . Ut::html($link) . '">' . $punctuation;
				}
				// video
				if ($media[6])
				{
					return '<video src="' . Ut::html($link) . '" controls></video>' . $punctuation;
				}
			}
			// shorten url name if too long
			else if (mb_strlen($url) > 55)
			{
				$short = mb_substr($link, 0, 30) . '[...]' . mb_substr($link, -20);

				// the label is escaped here, because link() is called with $safe = true
				// by PostWacko and does not escape it
				return $wacko->pre_link($link, Ut::html($short)) . $punctuation;
			}
			else
			{
				return $wacko->pre_link($link, Ut::html($link)) . $punctuation;
			}
		}
		else if (preg_match('/^((geo|tel)\:[' . $wacko::PATTERN['URI'] . '+?)([^[:alnum:]^\/\(\)\-\_\=]?)$/us', $thing, $matches))
		{
			[$link, $punctuation] = $this->split_url_punctuation($thing);

			return $wacko->pre_link($link, Ut::html($link)) . $punctuation;
		}
		// lan path
		else if (preg_match('/^\\\\\\\\([' . $wacko::PATTERN['ALPHANUM_P'] . '\\\!\.\-\_]+)$/u', $thing, $matches))
		{
			return '<a href="file://///' . str_replace('\\', '/', $matches[1]) . '">\\\\' . $matches[1] . '</a>';
		}
		// citated
		else if (preg_match('/^\n[ \t]*(>+)(.*)$/us', $thing, $matches))
		{
			return
				'<div class="email' . strlen($matches[1]) . ' email-' . (strlen($matches[1]) % 2 ? 'odd' : 'even') . '">' .
					Ut::html($matches[1]) . preg_replace_callback($this->LONG_REGEX, $callback, $matches[2]) .
				'</div>';
		}
		// blockquote
		else if (preg_match('/^<\[(.*)\]>$/us', $thing, $matches))
		{
			// trivial substitution (is there a security hole?)
			$matches[0] = str_replace('<[', '<!--escaped--><blockquote><!--escaped-->', $matches[0]);
			$matches[0] = str_replace(']>', '<!--escaped--></blockquote><!--escaped-->', $matches[0]);

			$result = preg_replace_callback($this->LONG_REGEX, $callback, $matches[0]);
			$result = preg_replace('/^(<br>)+/i', '', $result );
			$result = preg_replace('/(<br>)+$/i', '', $result );

			return $result;
		}
		// super
		else if (preg_match('/^\^\^(.*)\^\^$/u', $thing, $matches))
		{
			return '<sup>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</sup>';
		}
		// sub
		else if (preg_match('/^,,(.*),,$/u', $thing, $matches))
		{
			return '<sub>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</sub>';
		}
		// headers (h1 - h6)
		else if (preg_match('/\n[ \t]*(={2,7})(.*?)={2,7}$/', $thing, $matches))
		{
			return $this->headers($matches, $wacko, $callback);
		}
		// separators
		else if (preg_match('/^-{4,}$/u', $thing))
		{
			$this->br = false;

			return "<hr>\n";
		}
		// forced line breaks
		else if (preg_match('/^---[ \t]*$/u', $thing))
		{
			if (!empty($things['eol']))
			{
				// the marker ends the line: the newline which follows is matched
				// separately and must not produce a second break
				$this->br = false;

				return '<br>';
			}

			// the marker is used inside a line
			return "<br>\n";
		}
		// strike
		else if (preg_match('/^--((\S.*?\S)|(\S))--$/us', $thing, $matches))    //NB: wrong
		{
			return '<del>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</del>';
		}
		// definitions
		else if (  preg_match('/^\(\?(.+?)(==|\|\|)(.*)\?\)$/u', $thing, $matches)
				|| preg_match('/^\(\?(\S+)(\s+(.+))?\?\)$/u', $thing, $matches))
		{
			[, $def, , $text] = $matches;

			if ($def)
			{
				if ($text == '')
				{
					$text = $def;
				}

				$text = preg_replace('/<!--markup:1:[\w]+-->|__|\[\[|\(\(/u', '', $text);

				// the defined term is user input and must not be interpreted as HTML
				return '<dfn title="' . Ut::html($text) . '">' . Ut::html($def) . '</dfn>';
			}

			return '';
		}
		// forced links & footnotes
		else if (  preg_match('/^\[\[(.+)(==|\|)(.*)\]\]$/u', $thing, $matches)
				|| preg_match('/^\(\((.+)(==|\|)(.*)\)\)$/u', $thing, $matches)
				|| preg_match('/^\[\[(\S+)(\s+(.+))?\]\]$/u', $thing, $matches)
				|| preg_match('/^\(\((\S+)(\s+(.+))?\)\)$/u', $thing, $matches))
		{
			$url	= $matches[1] ?? '';
			$text	= $matches[3] ?? '';

			if ($url)
			{
				// footnote [[*]], [[**]], [[*1]], [[*2]]
				if ($url[0] == '*')
				{
					$sup = 1;

					if (preg_match('/^\*+$/u', $url))
					{
						$aname	= 'ftn' . mb_strlen($url);

						if (!$text)
						{
							$text = $url;
						}
					}
					else if (preg_match('/^\*\d+$/u', $url))
					{
						$aname	= 'ftnd' . mb_substr($url, 1);
					}
					else
					{
						$aname	= Ut::html(mb_substr($url, 1));
						$sup	= 0;
					}

					if (!$text)
					{
						$text = mb_substr($url, 1);
					}

					return
						($sup ? '<sup>' : '') .
							// the link text is user input and must not be interpreted as HTML
							'<a href="#o' . $aname . '" id="' . $aname . '">' . Ut::html($text) . '</a>' .
						($sup ? '</sup>' : '');
				}
				// footnote [[#*]], [[#**]], [[#1]], [[#2]]
				else if ($url[0] == '#')
				{
					$anchor	= mb_substr($url, 1);
					$sup	= 1;

					if (preg_match('/^\*+$/u', $anchor))
					{
						$ahref	= 'ftn' . mb_strlen($anchor);
					}
					else if (preg_match('/^\d+$/u', $anchor))
					{
						$ahref	= 'ftnd' . $anchor;
					}
					else
					{
						$ahref	= Ut::html($anchor);
						$sup	= 0;
					}

					if (!$text)
					{
						$text = mb_substr($url, 1);
					}

					return
						($sup ? '<sup>' : '') .
							// the link text is user input and must not be interpreted as HTML
							'<a href="#' . $ahref . '" id="o' . $ahref . '">' . Ut::html($text) . '</a>' .
						($sup ? '</sup>' : '');
				}
				// auto-generated footnote [[^ footnote here]]
				else if ($url[0] == '^')
				{
					return $this->auto_footnotes($url, $text);
				}
				// forced links
				else
				{
					if ($url != ($url = (preg_replace('/<!--markup:1:[\w]+-->|<!--markup:2:[\w]+-->|\[\[|\(\(/u', '', $url))))
					{
						$result	= '</span>';
					}

					if ($url[0] == '(')
					{
						$url	= mb_substr($url, 1);
						$result	.= '(';
					}

					if ($url[0] == '[')
					{
						$url	= mb_substr($url, 1);
						$result	.= '[';
					}

					if (!$text)
					{
						$text = $url;
					}

					$url	= str_replace(' ', '', $url);
					$text	= preg_replace('/<!--markup:1:[\w]+-->|<!--markup:2:[\w]+-->|\[\[|\(\(/u', '', $text);

					#Diag::dbg('GOLD', ' ::forced:: ' . $thing . ' => ' . $url . ' -> ' . $text);
					// the link text is user input and must not be interpreted as HTML
					// (the link handler is called with $safe = true and does not escape it)
					return $result . $wacko->pre_link($url, Ut::html($text));
				}
			}

			return '';
		}
		// indented text
		else if (preg_match('/(\n)(\t+|(?:[ ]{2})+)(-|\*|([a-zA-Z]{1,3}|[ivIV]+|\d{1,3})[\.\)](\#\d{1,3})?)?(\n|$)/us', $thing, $matches))
		{
			// new line
			$result .= ($this->br ? "<br>\n" : "\n");

			// intable or not?
			if ($this->intable)
			{
				$closers	= &$this->tdindent_closers;
				$old_level	= &$this->tdold_indent_level;
				$old_type	= &$this->tdold_indent_type;
			}
			else
			{
				$closers	= &$this->indent_closers;
				$old_level	= &$this->old_indent_level;
				$old_type	= &$this->old_indent_type;
			}

			// we definitely want no line break in this one.
			$this->br = false;

			// #18 syntax support
			if ($matches[5])
			{
				$start = mb_substr($matches[5], 1);
			}
			else
			{
				$start = '';
			}

			// find out which indent type we want
			$indent_type = $matches[3][0] ?? '';

			// TODO: set list-style-type via predefined CSS class, e.g. for 'lower-greek'

			// the order matters for Roman numerals
			$new_indent_type = match(1){
				preg_match('/[*-]/',	$indent_type)	=> '*',
				preg_match('/\d/',		$indent_type)	=> '1',	// numbers
				preg_match('/[iv]/',	$indent_type)	=> 'i',	// lowercase Roman numerals
				preg_match('/[IV]/',	$indent_type)	=> 'I',	// uppercase Roman numerals
				preg_match('/[a-z]/',	$indent_type)	=> 'a',	// lowercase letters
				preg_match('/[A-Z]/',	$indent_type)	=> 'A',	// uppercase letters
				default									=> '',
			};

			if (!$new_indent_type)
			{
				$opener		= '<div class="indent">';
				$closer		= '</div>';
				$this->br	= true;
				$new_type	= 'i';
			}
			else if ($new_indent_type == '*')
			{
				$opener		= '<ul class="text-secondary"><li>';
				$closer		= '</li></ul>' . "\n";
				$new_type	= '*';
				$li			= 1;
			}
			else
			{
				$opener		= '<ol type="' . $new_indent_type . '" class="text-secondary">' .
							  '<li' . ($start ? ' value="' . $start . '"' : '') . '>';
				$closer		= '</li></ol>' . "\n";
				$new_type	= 1;
				$li			= 1;
			}

			// get new indent level
			if ($matches[2][0] == ' ')
			{
				$new_indent_level = mb_strlen($matches[2]) / 2;
			}
			else
			{
				$new_indent_level = mb_strlen($matches[2]);
			}

			if ($new_indent_level > $old_level)
			{
				for ($i = 0; $i < $new_indent_level - $old_level; $i++)
				{
					$result .= $opener;
					$closers[] = $closer;
				}
			}
			else if ($new_indent_level < $old_level)
			{
				for ($i = 0; $i < $old_level - $new_indent_level; $i++)
				{
					$result .= array_pop($closers);
				}
			}
			else if ($new_indent_level == $old_level && $old_type != $new_type)
			{
				$result .= array_pop($closers);
				$result .= $opener;
				$closers[] = $closer;
			}

			$old_level	= $new_indent_level;
			$old_type	= $new_type;

			if ($li && !preg_match('/' . str_replace(')', '\)', $opener) . '$/u', $result))
			{
				$result .= '</li>' . "\n" . '<li' . ($start ? ' value="' . $start . '"' : '') . '>';
			}

			return $result;
		}
		// new lines
		else if ($thing == "\n" && !$this->intable_br)
		{
			// if we got here, there was no tab in the next line;
			// this means that we can close all open indents.
			$result = $this->indent_close();

			if ($result)
			{
				$this->br = false;
			}

			$result .= $this->br ? "<br>\n" : "\n";

			$this->br = true;

			return $result;
		}
		// media file links
		else if (preg_match('/^file:((\.\.|!)?\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/\-\_\.]+\.(' . $wacko::PATTERN['AUDIO'] . '|' . $wacko::PATTERN['BITMAP'] . '|' . $wacko::PATTERN['DRAWING'] . '|' . $wacko::PATTERN['VIDEO'] . ')(\?[[:alnum:]\&]+)?$/us', $thing, $matches))
		{
			$caption = 0;

			if(!empty($matches[4]) && preg_match('/caption/ui', $matches[4]))
			{
				$caption = 2;
			}

			#Diag::dbg('GOLD', ' ::fileimg:: ' . $thing . ' => ' . $matches[1] . ' -> ' . $matches[2]);
			return $wacko->pre_link($thing, '', true, $caption);
		}
		// interwiki links
		else if (preg_match('/^(' . $this->INTERWIKI_PATTERN . '+?)([^[:alnum:]^\/\(\)\-\_\=]?)$/us', $thing, $matches))
		{
			#Diag::dbg('GOLD', ' ::iw:: ' . $thing . ' => ' . $matches[1] . ' -> ' . $matches[2]);
			// trailing punctuation belongs to the text and must not become part of the link
			[$link, $punctuation] = $this->split_url_punctuation($thing);

			// the text fragment directive ("#:~:text=from,to") is not part of the label
			$label = $link;

			if (preg_match('/^(.*?)(#:~:.*)$/us', $link, $fragment_matches))
			{
					$label = $fragment_matches[1];
			}

			// the target is passed unchanged, the link handler builds the URL from it
			return $wacko->pre_link($link, Ut::html($label)) . $punctuation;
		}
		// wacko links!
		else if ((!$wacko->noautolinks)
			&& (preg_match('/^(((\.\.)|!)?\/?|~)?(' . $wacko::PATTERN['UPPER'] . $wacko::PATTERN['LOWER'] . '+' . $wacko::PATTERN['UPPERNUM'] . $wacko::PATTERN['ALPHANUM'] . '*)$/us', $thing, $matches)))
		{
			if ($matches[1] == '~')
			{
				return $matches[4];
			}

			return $wacko->pre_link($thing);
		}

		if (($thing[0] == '~') && ($thing[1] != '~'))
		{
			$thing = ltrim($thing, '~');
		}

		if (($thing[0] == '~') && ($thing[1] == '~'))
		{
			return '~' . preg_replace_callback($this->LONG_REGEX, $callback, mb_substr($thing, 2));
		}

		// if we reach this point, it must have been an accident.
		return Ut::html($thing);
	}

	public function table_cols($string): string
	{
		$tag		= 'col';
		$output		= "\t" . '<colgroup>' . "\n";

		$pattern	= '/\|/';
		$result		= preg_split($pattern, $string, -1, PREG_SPLIT_DELIM_CAPTURE);

		// remove empty values if any
		$result		= array_filter($result, 'strlen');

		// rebuild into [key][delimiter, result]
		$cols		= [];
		$delimiter	= null;

		foreach ($result as $token)
		{
			if ($token === '|')
			{
				$delimiter	= $token;
			}
			else
			{
				$cols[]		= [$delimiter, $token];
				$delimiter	= null;
			}
		}

		foreach ($cols as $col)
		{
			$attr		= [];
			[$attr, ]	= $this->table_attr($col[1], $tag);

			if ($col[1][0] == "\n")
			{
				$col[1] = substr($col[1], 1);
			}

			$output .=
			"\t\t" .
			'<' .
				$tag .
				implode('', $attr ?? []) .
			'>' .
			"\n";
		}

		$output .= "\t" . '</colgroup>';

		return $output;
	}

	public function table_rows($string, array $callback, int $header = 0): string
	{
		$strip_delimiter = function ($string): string
		{
			return str_replace("\u{2592}", '',
				str_replace("\u{2592}" . "<br>\n", '',
					$string));
		};

		// auto footnotes (e.g. [[^ footnote]] or ((^ footnote))) contain a caret which
		// must not be taken for a cell delimiter - mask them while the row is split
		// into cells and restore them in every cell afterwards
		$auto_fn_mask	= [];
		$mask_auto_fn	= function (string $string) use (&$auto_fn_mask): string
		{
			return (string) preg_replace_callback(
				'/\[\[\^.*?\]\]|\(\(\^.*?\)\)/us',
				function (array $matches) use (&$auto_fn_mask): string
				{
					$mask				= "\u{E000}" . count($auto_fn_mask) . "\u{E001}";
					$auto_fn_mask[$mask]	= $matches[0];

					return $mask;
				},
				$string
			);
		};

		$this->br			= true;
		$this->intable		= true;
		$this->intable_br	= false;

		$tag		= $header === 1 ? 'th' : 'td';
		$output		= "\t" . '<tr>' . "\n";

		// hide the auto footnotes from the cell splitting
		$string	= $mask_auto_fn($string);

		// ensures the ^ is not preceded or followed by another ^, matches only isolated ^ characters
		$pattern	= '/((?<!\^)\^(?!\^)|\|)/';
		$result		= preg_split($pattern, $string, -1, PREG_SPLIT_DELIM_CAPTURE);

		// remove empty values if any
		$result		= array_filter($result, 'strlen');

		// rebuild into [key][delimiter, result]
		$cells		= [];
		$delimiter	= null;

		foreach ($result as $token)
		{
			if (in_array($token, ['^', '|']))
			{
				$delimiter	= $token;
			}
			else
			{
				$cells[]	= [$delimiter, $token];
				$delimiter	= null;
			}
		}

		$count		= count($cells);
		$count--;

		foreach ($cells as $i => $cell)
		{
			$this->tdold_indent_level	= 0;
			$this->tdindent_closers		= [];

			// restore the auto footnotes hidden above
			$cell[1]	= strtr($cell[1], $auto_fn_mask);

			$attr		= [];

			if (!$header)
			{
				$tag = match($cell[0])
				{
					'^'			=> 'th',
					default		=> 'td'
				};
			}
			else if ($header === 2)
			{
				$tag = $i === 0 ? 'th' : 'td';
			}

			if ([$attr, $data] = $this->table_attr($cell[1], $tag))
			{
				$cell[1]	= $data ?? '';
			}

			if ($cell[1][0] == "\n")
			{
				$cell[1] = substr($cell[1], 1);
			}

			$output .=
				"\t\t" .
				'<' .
					$tag .
					implode('', $attr ?? []) .
				'>' .
				$strip_delimiter(
					preg_replace_callback($this->LONG_REGEX, $callback, "\u{2592}\n" . $cell[1]));

			if ($i != $count)
			{
				$output .= $this->indent_close();
				$output .= '</' . $tag . '>' . "\n";
			}
		}

		$output .= $this->indent_close();
		$output .= '</' . $tag . '>' . "\n";
		$output .= "\t" . '</tr>';

		if ($this->cols == 0)
		{
			$this->cols = $count;
		}

		$this->intable		= false;
		$this->intable_br	= true;

		return $output;
	}

	public function table_attr(string $string, $tag = 'row'): ?array
	{
		$wacko		= & $this->object;

		$attr		= [];
		$class		= [];
		$params		= [];
		$pattern	= '/^\(((?:\s*(\w+)\s*=\s*(?:\"([^)\"]+)\"|([^)\s]+))\s*)+)\)(.*)/usm';

		if (preg_match($pattern, $string, $matches))
		{
			$params_str		= $matches[1];
			$param_pattern	= '/(\w+)\s*=\s*(?:\"([^)\"]+)\"|([^)\s]+))/';

			preg_match_all($param_pattern, $params_str, $param_matches, PREG_SET_ORDER);

			foreach ($param_matches as $pair)
			{
				$params[$pair[1]] = $pair[2] ?: $pair[3];;
			}

			// assign attributes
			if ($tag === 'table')
			{
				if (isset($params['type'], $params['class'])
					&& preg_match('/^[\w-]+$/', $params['class']))
				{
					$class[] = ' ' . $params['class'];
				}
				else
				{
					$class[] = ' usertable';
				}
			}

			// [1] align
			if (isset($params['align']))
			{
				if (in_array($tag, ['table'])
					&& in_array($params['align'], ['center', 'left', 'right']))
				{
					$class[] = ' table-' . $params['align'];
				}
				else if (in_array($tag, ['th', 'td', 'caption'])
					&& in_array($params['align'], ['center', 'left', 'right', 'justify']))
				{
					$class[] = ' text-' . $params['align'];
				}
			}

			// [2] bgcolor
			if (isset($params['bgcolor'])
				&& in_array($params['bgcolor'], ($wacko->db->allow_x11colors ? $this->x11_colors : $this->colors)))
			{
				$class[] = ' mark-' . $params['bgcolor'];
			}

			// [3] class
			if (isset($params['class'])
				&& preg_match('/^(?:[\w_-]*)(?:\s+[\w_-]*)*$/', $params['class']))
			{
				$class[] = ' ' . $params['class'];
			}

			// [4] colspan
			if (isset($params['colspan'])
				&& in_array($tag, ['th', 'td']))
			{
				$attr[] = ' colspan="' . (int)	$params['colspan'] . '"';
			}

			// [5] id
			if (isset($params['id'])
				&& preg_match('/^[\w-]+$/', $params['id']))
			{
				$attr[] = ' id="' . $params['id'] . '"';
			}

			// [6] rowspan
			if (isset($params['rowspan'])
				&& in_array($tag, ['th', 'td']))
			{
				$attr[] = ' rowspan="' . (int)	$params['rowspan'] . '"';
			}

			// [7] scope
			if (isset($params['scope'])
				&& in_array($tag, ['th'])
				&& in_array($params['scope'], ['row', 'col', 'rowgroup', 'colgroup']))
			{
				$attr[] = ' scope="' . $params['scope'] . '"';
			}

			// [8] side
			if (isset($params['side'])
				&& in_array($tag, ['caption'])
				&& in_array($params['side'], ['top', 'bottom']))
			{
				$class[] = ' side-' . $params['side'];
			}

			// [9] span
			if (isset($params['span'])
				&& in_array($tag, ['col']))
			{
				$attr[] = ' span="' . (int)	$params['span'] . '"';
			}

			// [10] valign
			if (isset($params['valign'])
				&& in_array($tag, ['td', 'th'])
				&& in_array($params['valign'], ['top', 'middle', 'bottom']))
			{
				$class[] = ' vertical-' . $params['valign'];
			}

			// [11] width
			if (isset($params['width'])
				&& preg_match('/^(?:\d+|0\.\d+)(?:px|%|em|rem)$/', $params['width']))
			{
				$attr[] = ' style="width: ' . $params['width'] . ';"';
			}

			// compile class
			if ($class)
			{
				$attr[] = ' class="' . trim(implode('', $class ?? [])) . '"';
			}

			return [$attr, $matches[5] ?? ''];
		}

		return null;
	}

	public function auto_footnotes(string $url, string $text): string
	{
		$anchor = mb_substr($url, 1);

		// #18 syntax support
		if (preg_match('/^\#\d{1,3}$/u', $anchor))
		{
			$this->auto_fn['count'] = mb_substr($anchor, 1) - 1;
		}

		// validate and sanitize $anchor
		if (!preg_match('/^([\p{L}\d*†‡§‖¶])*$/u', $anchor))
		{
			$anchor = '';
		}
		// discard already set denominators, simple and neat
		else if (isset($this->auto_fn['content'][$anchor]) && $text)
		{
			$anchor = '';
		}

		// set denominator
		if ($anchor)
		{
			$fn_count = $anchor;
		}
		else
		{
			$this->auto_fn['count'] ??= 0;
			$this->auto_fn['count']++;

			$fn_count = $this->auto_fn['count'];
		}

		if ($text)
		{
			$this->auto_fn['content'] ??= null;
			$this->auto_fn['content'][$fn_count] = trim($text);
		}

		// the denominator is restricted to "[\p{L}\d*†‡§‖¶]" (see above), escape it
		// nevertheless for the HTML output
		$fn	= Ut::html((string) $fn_count);

		return
			'<sup class="footnote">' .
				'<a href="#footnote-' . $fn . '" id="footnote-' . $fn . '-ref" title="footnote ' . $fn . '">' .
					'[' . $fn . ']' .
				'</a>' .
			'</sup>';
	}

	public function headers(array $matches, $wacko, array $callback): string
	{
		$h_level	= substr_count($matches[1], '=') - 1;
		$result		= $this->indent_close();
		$this->br	= false;
		$wacko->header_count++;
		$header_id	= 'h' . $this->page_id . '-' . $wacko->header_count;

		if ($wacko->db->section_edit
			&& $h_level > 1
			&& !isset($_POST['preview'])
			&& (in_array($wacko->method, ['addcomment', 'edit', 'show']) || $wacko->db->ap_mode))
		{
			$wacko->section_count++;
			$section_tag = $wacko->section_tag
							?? (isset($wacko->page['comment_on_id']) && $wacko->page['comment_on_id']
								? $wacko->page['tag']
								: '');

			// non-static section edit link via action
			$section_edit =
				'<!--notypo--><!--action:begin-->' .
					'editsection ' .
					($section_tag
						? 'page=' . '/' . $section_tag . ' '
						: '') .
						'section=' . $wacko->section_count .
				'<!--action:end--><!--/notypo-->';
		}

		return $result .
			'<h' . $h_level . ' id="' . $header_id . '" class="heading">' .
				preg_replace_callback($this->LONG_REGEX, $callback, $matches[2]) .
				'<a class="self-link" href="#' . $header_id . '"></a>' .

				($section_edit ?? '') .

			'</h' . $h_level . '>';
	}

	/**
	 * Split trailing punctuation off an URL.
	 *
	 * Punctuation at the end of an URL belongs to the surrounding text and must
	 * not become part of the link ("http://example.com...", "http://example.com).'").
	 *
	 * The rules follow CommonMark: the characters "?!.,:*" and the quotes are
	 * never part of the link, a closing bracket is only part of the link when
	 * the brackets are balanced.
	 *
	 * The fragment is never touched - a text fragment directive
	 * ("#:~:text=from,to") may legitimately end with such characters.
	 *
	 * @param string $url
	 * @return array [string $url, string $trailing]
	 */
	private function split_url_punctuation(string $url): array
	{
		// a text fragment directive ("#:~:text=from,to") is opaque, its content may
		// legitimately end with punctuation which is part of the selection,
		// every other fragment ("#Section") is ordinary text
		$pos		= strpos($url, '#');
		$fragment	= '';

		if ($pos !== false && str_starts_with(substr($url, $pos), '#:~:'))
		{
			$fragment	= substr($url, $pos);
			$url		= substr($url, 0, $pos);
		}

		$trailing	= '';

		while ($url !== '')
		{
			$last = mb_substr($url, -1);

			// brackets are only part of the URL when they are balanced
			if (str_contains('()[]{}', $last))
			{
				$pairs		= ['(' => ')', '[' => ']', '{' => '}'];
				$reverse	= array_flip($pairs);

				$balance	= isset($pairs[$last])
					? mb_substr_count($url, $last) - mb_substr_count($url, $pairs[$last])
					: mb_substr_count($url, $reverse[$last]) - mb_substr_count($url, $last);

				if ($balance == 0)
				{
					break;		// balanced -> it belongs to the URL
				}

				$trailing	= $last . $trailing;
				$url		= mb_substr($url, 0, -1);
				continue;
			}

			// punctuation which is never the ending of an URL
			if (!str_contains('?!.,:*\'"', $last))
			{
				break;
			}

			$trailing	= $last . $trailing;
			$url		= mb_substr($url, 0, -1);
		}

		return [$url . $fragment, $trailing];
	}

	/**
	 * Split an URL into its components.
	 *
	 * Uses the URI extension (PHP 8.5) when it is available, otherwise parse_url().
	 *
	 * @param string $url
	 * @return array|null
	 */
	private function url_parts(string $url): ?array
	{
		// PHP 8.5 URI extension
		if (class_exists('\Uri\WhatWg\Uri'))
		{
			try
			{
				$uri = \Uri\WhatWg\Uri::parse($url);

				return [
					'scheme'	=> $uri->getScheme(),
					'host'		=> $uri->getHost(),
					'port'		=> $uri->getPort(),
				];
			}
			catch (\Throwable $e)
			{
				return null;
			}
		}

		// fallback for PHP < 8.5
		$parts = parse_url($url);

		return $parts === false ? null : $parts;
	}

	/**
	 * Check whether an URL may be turned into a link.
	 *
	 * The syntax of the URL is checked with parse_url() (or the URI extension),
	 * the host name with filter_var(FILTER_VALIDATE_DOMAIN), which enforces the
	 * label rules of RFC 1034: a host like "example..com" contains an empty
	 * label, can never be resolved and must therefore not be linked.
	 *
	 * @param string $url
	 * @return bool
	 */
	private function is_valid_url(string $url): bool
	{
		$parts = $this->url_parts($url);

		if ($parts === null || empty($parts['scheme']))
		{
			return false;
		}

		// port
		if (isset($parts['port']) && ($parts['port'] < 1 || $parts['port'] > 65535))
		{
			return false;
		}

		// schemes with an authority component need a host
		if (in_array(mb_strtolower($parts['scheme']), ['http', 'https', 'ftp', 'ftps', 'ws', 'wss'], true)
			&& !isset($parts['host']))
		{
			return false;
		}

		// no authority component (mailto:, tel:, geo:) - nothing to check
		if (!isset($parts['host']))
		{
			return true;
		}

		return $this->is_valid_host($parts['host']);
	}

	/**
	 * Check a host name.
	 *
	 * The labels are checked according to RFC 1034: a host with an empty label
	 * ("example..com") can never be resolved and must not be linked.
	 *
	 * @param string $host
	 * @return bool
	 */
	private function is_valid_host(string $host): bool
	{
		// IPv6 literal
		if (str_starts_with($host, '['))
		{
			return (bool) preg_match('/^\[[0-9a-f:.]+](?::\d{1,5})?$/i', $host);
		}

		// a fully qualified domain name may end with the root label
		$host = rtrim($host, '.');

		if ($host === '')
		{
			return false;
		}

		// internationalized domain names have to be converted to punycode first,
		// because filter_var(FILTER_VALIDATE_DOMAIN) only accepts ASCII
		if (preg_match('/[^\x00-\x7f]/', $host))
		{
			if (!function_exists('idn_to_ascii'))
			{
				// no intl extension available: check the unicode labels ourselves
				return $this->is_valid_unicode_host($host);
			}

			$variant	= defined('INTL_IDNA_VARIANT_UTS46') ? INTL_IDNA_VARIANT_UTS46 : 0;
			$ascii		= idn_to_ascii($host, IDNA_DEFAULT, $variant);

			if ($ascii === false || $ascii === '')
			{
				return false;
			}

			$host = $ascii;
		}

		// every label of the host must be valid (RFC 1034)
		// FILTER_FLAG_HOSTNAME additionally allows the underscore ("_dmarc.example.com")
		return filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) !== false;
	}

	/**
	 * Check the labels of an internationalized host name without the intl extension.
	 *
	 * @param string $host
	 * @return bool
	 */
	private function is_valid_unicode_host(string $host): bool
	{
		if (mb_strlen($host) > 253)
		{
			return false;
		}

		foreach (explode('.', $host) as $label)
		{
			// a label must not be empty, must not exceed 63 octets and must not
			// start or end with a hyphen
			if ($label === ''
				|| strlen($label) > 63
				|| !preg_match('/^[\p{L}\p{Nd}]([\p{L}\p{Nd}\-]*[\p{L}\p{Nd}])?$/u', $label))
			{
				return false;
			}
		}

		return true;
	}

}
