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
	public $old_indent_level	= 0;
	public $indent_closers		= [];
	public $tdold_indent_level	= 0;
	public $auto_fn				= [];
	public $tdindent_closers	= [];
	public $br					= true;
	public $intable				= false;
	public $intable_br			= false;
	public $cols				= 0;
	public $LONG_REGEX;
	public $MIDDLE_REGEX;
	public $PRE_REGEX;
	private $tdold_indent_type;
	private $old_indent_type;
	public $colors			= [
		'blue',
		'green',
		'red',
		'yellow',
	];
	public $x11_colors		= [
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
	];

	function __construct( &$object )
	{
		$this->object = &$object;

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
				  "\(\((\S+?)([ \t]+([^\n]+?))?\)\)|" .
				  "\[\*\[(\S+?)([ \t]+(file:[^\n]+?))?\]\*\]|" .
				  "\(\*\((\S+?)([ \t]+(file:[^\n]+?))?\)\*\)|") .
			// citated  > ... or  >> ...
			"\n[ \t]*>+[^\n]*|" .
			// cite text <[...]>
			"<\[.*?\]>|" .
			// small text ++...++
			"\+\+\S\+\+|" .
			"\+\+(\S[^\n]*?\S)\+\+|" .
			// link ...://... or [mailto|xmpp]:...@...
			"\b[[:alpha:]]+:\/\/\S+|(mailto|xmpp)\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\_\.]+|" .
			// highlighting  ??...??
			"\?\?\S\?\?|" .
			"\?\?(\S.*?\S)\?\?|" .
			// \\\\...
			"\\\\\\\\[" . $object::PATTERN['ALPHANUM_P'] . "\-\_\\\!\.]+|" .
			// bold text **...**
			"\*\*[^\n]*?\*\*|" .
			// code ##...##
			"\#\#[^\n]*?\#\#|" .
			// code ¹¹...¹¹
			"\¹\¹[^\n]*?\¹\¹|" .
			// note ''...''
			"\'\'.*?\'\'|" .
			// note !!...!!
			"\!\!\S\!\!|" .
			"\!\!(\S.*?\S)\!\!|" .
			// underline __...__
			"__[^\n]*?__|" .
			// upper and lower indexes ^^...^^ and vv...vv
			"\^\^\S*?\^\^|" .
			"vv\S*?vv|" .
			// deleted text for diff
			// inserted text for diff
			"<!--markup:1:begin-->\S<!--markup:1:end-->|" .
			"<!--markup:2:begin-->\S<!--markup:2:end-->|" .
			"<!--markup:1:begin-->(\S.*?\S)<!--markup:1:end-->|" .
			"<!--markup:2:begin-->(\S.*?\S)<!--markup:2:end-->|" .
			// tables #|| #| ||...|| ||# |#
			"\#\|\||" .
			"\#\||" .
			"\|\|\#|" .
			"\|\#|" .
			"\|\|.*?\|\||" .
			"\*\|.*?\|\*|" .
			// symbols < or >
			"<|>|" .
			// italic //...//
			"\/\/[^\n]*?(?<!http:|https:|ftp:|file:|nntp:)\/\/|" .
			// headers
			"\n[ \t]*={2,7}.*?={2,7}|" .
			// separator
			"-{4,}|" .
			// line break
			"---\n?\s*|" .
			// strikethrough
			"--\S--|" .
			"--(\S.*?[^- \t\n\r])--|" .
			// list including multilevel
			"\n(\t+|([ ]{2})+)(-|\*|([a-zA-Z]{1,3}|[ivIV]+|(\d{1,3}))[\.\)](\#\d{1,3})?)?|" .
			// media links
			"file:((\.\.|!)?\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/\-\_\.]+\.(" . $object::PATTERN['AUDIO'] . '|' . $object::PATTERN['BITMAP'] . '|' . $object::PATTERN['DRAWING'] . '|' . $object::PATTERN['VIDEO'] . ")(\?[[:alnum:]\&]+)?|" .
			// interwiki links
			"\b[[:alnum:]]+:[" . $object::PATTERN['ALPHANUM_P'] . "\!\.][" . $object::PATTERN['ALPHANUM_P'] . "\(\)\-\_\.\+\&\=\#]+|" .
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
			"\{\{[^\n]*?\}\}|" .
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

			if (preg_match('/^\(([^\n]+?)\)(.*)$/us', $code, $matches))
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

						preg_match_all('/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/u', $p, $matches, PREG_SET_ORDER);

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

			$formatter = mb_strtolower($formatter);

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
			return
				'<!--escaped--><ignore><!--notypo--><!--action:begin-->' .
					$matches[1] .
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

		if (isset($wacko->page['page_id']))
		{
			$this->page_id = $wacko->page['page_id'];
		}
		else if (isset($wacko->resync_page_id))
		{
			$this->page_id = $wacko->resync_page_id;
		}

		if (!$this->page_id || $wacko->new_comment)
		{
			// for new page or comment with not yet created db record
			// temporary random hashid for paragrafica (toc, p)
			$this->page_id = substr(hash('crc32', time()), 0, 5);
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
		else if ($thing == '#|')
		{
			$this->br			= false;
			$this->cols			= 0;
			$this->intable_br	= true;
			$this->table_scope	= true;

			return '<table class="usertable">';
		}
		// table end
		else if (($thing == '|#' || $thing == '||#') && $this->table_scope)
		{
			$this->br			= false;
			$this->intable_br	= false;
			$this->table_scope	= false;

			return '</table>';
		}
		// table head
		else if (preg_match('/^\*\|(.*?)\|\*$/us', $thing, $matches) && $this->table_scope)
		{
			return $this->table_rows($matches[1], $callback, true);
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
		else if (  preg_match('/^\#\#(.*?)\#\#$/u', $thing, $matches)
				|| preg_match('/^\¹\¹(.*?)\¹\¹$/u', $thing, $matches))
		{
			return '<code>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</code>';
		}
		// small
		else if (preg_match('/^\+\+(.*?)\+\+$/u', $thing, $matches))
		{
			return '<small>' . preg_replace_callback($this->LONG_REGEX, $callback, $matches[1]) . '</small>';
		}
		// cite
		else if (  preg_match('/^\'\'(.*?)\'\'$/us', $thing, $matches)
				|| preg_match('/^\!\!((\((\S*?)\)(.*?\S))|(\S.*?\S)|(\S))\!\!$/us', $thing, $matches))
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
		else if (  preg_match('/^([[:alpha:]]+:\/\/\S+?)([^[:alnum:]^\/\(\)\-\_\=]?)$/u', $thing, $matches)
				|| preg_match('/^(mailto\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\.\_]+?|xmpp\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\.\_]+?)([^[:alnum:]^\/\-\_\=]?)$/u', $thing, $matches))
		{
			$url = mb_strtolower($matches[1]);

			if (preg_match('/^(https?|ftp):\/\/([^\\s\"<>]+)\.((' . $wacko::PATTERN['AUDIO'] . ')|(' . $wacko::PATTERN['BITMAP'] . '|' . $wacko::PATTERN['DRAWING'] . ')|(' . $wacko::PATTERN['VIDEO'] . '))$/u', $url, $media))
			{
				// audio
				if ($media[4])
				{
					return '<audio src="' . $matches[1] . '" controls></audio>' . $matches[2];
				}
				// image
				if ($media[5])
				{
					return '<img src="' . $matches[1] . '">' . $matches[2];
				}
				// video
				if ($media[6])
				{
					return '<video src="' . $matches[1] . '" controls></video>' . $matches[2];
				}
			}
			// shorten url name if too long
			else if (mb_strlen($url) > 55)
			{
				$url = mb_substr($matches[1], 0, 30) . '[...]' . mb_substr($matches[1], -20);

				return $wacko->pre_link($matches[1], $url) . $matches[2];
			}
			else
			{
				return $wacko->pre_link($matches[1], $matches[1]) . $matches[2];
			}
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
		else if (preg_match('/^vv(.*)vv$/u', $thing, $matches))
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
		else if (preg_match('/^---\n?\s*$/u', $thing, $matches))
		{
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

				return '<dfn title="' . Ut::html($text) . '">' . $def . '</dfn>';
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
							'<a href="#o' . $aname . '" id="' . $aname . '">' . $text . '</a>' .
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
							'<a href="#' . $ahref . '" id="o' . $ahref . '">' . $text . '</a>' .
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
					return $result . $wacko->pre_link($url, $text);
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

			// the order matters for Roman numerals
			if (preg_match('/[*-]/',	$indent_type))
			{
				$new_indent_type = '*';
			}
			else if (preg_match('/\d/',		$indent_type))
			{
				$new_indent_type = '1';	// numbers
			}
			else if (preg_match('/[iv]/',	$indent_type))
			{
				$new_indent_type = 'i';	// lowercase Roman numerals
			}
			else if (preg_match('/[IV]/',	$indent_type))
			{
				$new_indent_type = 'I';	// uppercase Roman numerals
			}
			else if (preg_match('/[a-z]/',	$indent_type))
			{
				$new_indent_type = 'a';	// lowercase letters
			}
			else if (preg_match('/[A-Z]/',	$indent_type))
			{
				$new_indent_type = 'A';	// uppercase letters
			}
			else
			{
				$new_indent_type = '';
			}

			if (!$new_indent_type)
			{
				$opener		= '<div class="indent">';
				$closer		= '</div>' . "\n";
				$this->br	= true;
				$new_type	= 'i';
			}
			else if ($new_indent_type == '*')
			{
				$opener		= '<ul><li>';
				$closer		= '</li></ul>' . "\n";
				$new_type	= '*';
				$li			= 1;
			}
			else
			{
				$opener		= '<ol type="' . $new_indent_type . '">' .
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
		else if (preg_match('/^([[:alnum:]]+:[' . $wacko::PATTERN['ALPHANUM_P'] . '\!\.][' . $wacko::PATTERN['ALPHANUM_P'] . '\(\)\-\_\.\+\&\=\#]+?)([^[:alnum:]^\/\(\)\-\_\=]?)$/us', $thing, $matches))
		{
			#Diag::dbg('GOLD', ' ::iw:: ' . $thing . ' => ' . $matches[1] . ' -> ' . $matches[2]);
			return $wacko->pre_link($matches[1]) . $matches[2];
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

	public function table_rows($matches, $callback, $header = false): string
	{
		$strip_delimiter = function ($string): string
		{
			return str_replace("\u{2592}", '',
				str_replace("\u{2592}" . "<br>\n", '',
					$string));
		};

		$this->br			= true;
		$this->intable		= true;
		$this->intable_br	= false;

		$tag		= $header ? 'th' : 'td';
		$output		= '<tr>';
		$cells		= preg_split('/\|/', $matches);
		$count		= count($cells);
		$count--;

		foreach ($cells as $i => $cell)
		{
			$this->tdold_indent_level	= 0;
			$this->tdindent_closers		= [];
			$colspan					= '';

			if ($cell[0] == "\n")
			{
				$cell = substr($cell, 1);
			}

			if (($i == $count) && ($this->cols <> 0) && ($count < $this->cols))
			{
				$colspan = ' colspan="' . ($this->cols - $count + 1) . '"';
			}

			$output .= $strip_delimiter(
				'<' . $tag . $colspan . '>' .
				preg_replace_callback($this->LONG_REGEX, $callback, "\u{2592}\n" . $cell));


			if ($i != $count)
			{
				$output .= $this->indent_close();
				$output .= '</' . $tag . '>';
			}
		}

		$output .= $this->indent_close();
		$output .= '</' . $tag . '>';
		$output .= '</tr>';

		if ($this->cols == 0) {
			$this->cols = $count;
		}

		$this->intable		= false;
		$this->intable_br	= true;

		return $output;
	}

	public function auto_footnotes($url, $text): string
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
			if (!isset($this->auto_fn['count']))		$this->auto_fn['count']		= 0;
			$this->auto_fn['count']++;

			$fn_count = $this->auto_fn['count'];
		}

		if ($text)
		{
			if (!isset($this->auto_fn['content']))		$this->auto_fn['content']		= null;
			$this->auto_fn['content'][$fn_count] = trim($text);
		}

		return
			'<sup class="footnote">' .
				'<a href="#footnote-' . $fn_count . '" id="footnote-' . $fn_count . '-ref" title="footnote ' . $fn_count . '">' .
					'[' . $fn_count . ']' .
				'</a>' .
			'</sup>';
	}

	public function headers($matches, $wacko, $callback): string
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

}
