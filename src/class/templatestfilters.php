<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	- bytes -- 1.2MB
*/


class TemplatestFilters extends TemplatestEscaper
{
	protected array $filters;

	function __construct()
	{
		$this->filters = [];

		foreach (get_class_methods(self::class) as $meth)
		{
			if (preg_match('/^filter_(\w+?)(_also_(\w+?))?$/', $meth, $match))
			{
				$this->filters[$match[1]] = [$this, $meth];

				if (isset($match[3]))
				{
					$this->filters[$match[3]] = [$this, $meth];
				}
			}
		}
	}

	// add user filter function
	function filter($id, $func)
	{
		$this->filters[$id] = $func;
	}

	function getFilters(): array
	{
		$list = [];

		foreach ($this->filters as $id => $func)
		{
			if (!(is_array($func) && $func[0] === $this))
			{
				$list[$id] = $func;
			}
		}

		return $list;
	}

	function setFilters($list)
	{
		foreach ($list as $id => $func)
		{
			$this->filters[$id] = $func;
		}
	}

	function call_filter($name, $value, $args)
	{
		if (isset($this->filters[$name]) && is_callable($this->filters[$name]))
		{
			array_unshift($args, $value);
			$value = call_user_func_array($this->filters[$name], $args);
		}
		else
		{
			trigger_error('unknown filter ' . $name . ' at ' . $this->loc, E_USER_WARNING);
		}

		return $value;
	}

	function filter_escape_also_e($value, $mode = 'html')
	{
		switch ($mode)
		{
			case 'raw':
				break;

			case 'html':
				$value = $this->escapeHtml($value);
				break;

			case 'js':
				$value = $this->escapeJs($value);
				break;

			case 'css':
				$value = $this->escapeCss($value);
				break;

			case 'url':
				$value = $this->escapeUrl($value);
				break;

			case 'html_attr':
			case 'attr':
				$value = $this->escapeHtmlAttr($value);
				break;

			default:
				trigger_error('invalid escape mode ' . $mode . ' at ' . $this->loc, E_USER_WARNING);
		}

		return $value;
	}

	function filter_default($value, $default)
	{
		($value === null || $value === false) && $value = $default;
		return $value;
	}

	function filter_format($value, $fmt): string
	{
		return sprintf($fmt, $value);
	}

	function filter_stringify($value)
	{
		return Ut::stringify($value);
	}

	function filter_date($value, $fmt): string
	{
		return date($fmt, $value);
	}

	function filter_join($value, $glue = ''): string
	{
		return implode($glue, $value);
	}

	function filter_lower($value): string
	{
		return mb_strtolower($value);
	}

	function filter_upper($value): string
	{
		return mb_strtoupper($value);
	}

	// TODO: localize formatting
	function filter_number($value, $decimals = 0, $dec_point = ',', $thousands_sep = '.'): string
	{
		return number_format($value, (int) $decimals, $dec_point, $thousands_sep);
	}

	function filter_void($value)
	{
		return null;
	}

	function filter_index($value, $path)
	{
		if (str_starts_with($path, '.'))
		{
			$path = substr($path, 1);
		}

		foreach (explode('.', $path) as $idx)
		{
			if (isset($value[$idx]))
			{
				$value = $value[$idx];
			}
			else
			{
				return null;
			}
		}

		return $value;
	}

	function filter_replace()
	{
		$args	= func_get_args();
		$value	= array_shift($args);
		$search	= $replace = [];

		foreach ($args as $i => $str)
		{
			if ($i & 1)
			{
				$replace[] = $str;
			}
			else
			{
				$search[] = $str;
			}
		}

		return str_replace($search, $replace, $value);
	}

	function filter_json_encode()
	{
		$args		= func_get_args();
		$value		= array_shift($args);
		$options	= 0;

		foreach ($args as $option)
		{
			$option = strtoupper($option);

			strncmp($option, 'JSON_', 5) && $option = 'JSON_' . $option;

			if (defined($option))
			{
				$options |= constant($option);
			}
			else
			{
				trigger_error('invalid json_encode option ' . $option . ' at ' . $this->loc, E_USER_WARNING);
			}
		}

		return json_encode($value, $options);
	}

	function filter_json_decode($value)
	{
		return json_decode($value, 1);
	}

	function filter_sp2nbsp($value)
	{
		return preg_replace_callback('# ( +)|^ #',
			function ($x)
			{
				$n = strlen($x[1]);
				return str_repeat('&nbsp; ', $n >> 1) . str_repeat('&nbsp;', $n & 1);
			}, $value);
	}

	/*function filter_spaceless($value)
	{
		return preg_replace_callback('/>\s+</', function ($m)
			{
				return strpos($m[0], "\n")? '><' : '> <';
			}, $value);
	}*/

	function filter_spaceless($value): string
	{
		if (preg_match_all(
			'@
				<(?<script>script).*?<\/script\s*>|
				<(?<style>style).*?<\/style\s*>|
				<!(?<comment>--).*?-->|
				<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|
				(?<text>((<[^!\/\w.:-])?[^<]*)+)|@xsi',
			$value, $matches, PREG_SET_ORDER) === false)
		{
			return $value;
		}

		$raw_tag = false;
		$html = '';

		foreach ($matches as $token)
		{
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;

			$content	= $token[0];
			$strip		= false;

			if (is_null($tag))
			{
				if (!empty($token['style']))
				{
					$strip = true;
				}
			}
			else
			{
				if ($tag === 'pre' || $tag === 'textarea')
				{
					$raw_tag = $tag;
				}
				else if ($tag === '/pre' || $tag === '/textarea')
				{
					$raw_tag = false;
				}
				else if (!$raw_tag)
				{
					if ($tag !== '')
					{
						$content = preg_replace('#\s+(/?>)#', '$1', $content);
					}
					else
					{
						if (str_ends_with($html, ' ') && ($spaces = strspn($content, " \t\r\n\x0b")) > 0)
						{
							$content = substr($content, $spaces);
						}
					}

					$strip = true;
				}
			}

			if ($strip)
			{
				$content = strtr($content, "\t\r\n\x0b", '    ');

				while (($lesser = str_replace('  ', ' ', $content)) != $content)
				{
					$content = $lesser;
				}
			}

			$html .= $content;
		}

		return $html;
	}

	function filter_regex($value, $re, $to, $limit = -1, $strict = false)
	{
		$value = preg_replace($re, $to, $value, (int) $limit, $count);

		if ($value === null)
		{
			trigger_error('regex ' . $re . ' failed at ' . $this->loc, E_USER_WARNING);
		}
		else if ($strict && !$count)
		{
			$value = null;
		}

		return $value;
	}

	function filter_trim($value, $character_mask = " \t\n\r\0\x0B"): string
	{
		return trim($value, $character_mask);
	}

	function filter_url_encode($value)
	{
		if (!is_array($value))
		{
			return rawurlencode((string) $value);
		}

		$list = [];

		foreach ($value as $id => $val)
		{
			$list[] = Ut::qencode($id, $val);
		}

		return implode('&', $list);
	}

	function filter_striptags($value, $allowable_tags = ''): string
	{
		return strip_tags($value, $allowable_tags);
	}

	function filter_nl2br($value): string
	{
		$list = preg_split('/(?:\r\n|\r|\n){2,}/', $value, -1, PREG_SPLIT_NO_EMPTY);

		foreach ($list as &$p)
		{
			$p = '<p>' . str_replace("\n", "<br>\n", $p) . '</p>';
		}

		return implode("\n\n", $list);
	}

	function filter_truncate($value, $limit, $ellipsis = '...')
	{
		if (strlen($value) > $limit)
		{
			$split	= explode(' ', substr($value, 0, (int) $limit));
			$split1	= array_slice($split, 0, -1);
			$value	= implode(' ', $split1 ?: $split) . $ellipsis;
		}

		return $value;
	}

	function filter_split($value, $delimiter, $limit = PHP_INT_MAX): array
	{
		return Ut::isempty($delimiter)? str_split($value, $limit) : explode($delimiter, $value, $limit);
	}

	function filter_list()
	{
		$args	= func_get_args();
		$value	= (int)array_shift($args);

		return ($value >= 0 && $value < count($args))? $args[$value] : array_pop($args);
	}

	function filter_dbg($value)
	{
		// suppress ALL errors. templatest is meant to be used standalone, and this is LONE dependency on wacko
		@Diag::dbg($this->loc, $value);
		return $value;
	}

	function filter_enclose($value, $pref = '', $post = ''): string
	{
		return $pref . $value . $post;
	}

	function filter_check($value, $on): string
	{
		return ' value="' . (int) $on . '" ' . (((int) $value == (int) $on)? 'checked ' : '');
	}

	function filter_checkbox($value): string
	{
		return (((int) $value)? ' checked ' : '');
	}

	function filter_select($value, $on): string
	{
		return (($value == $on)? ' selected ' : '');
	}

	// FIXME: workaround for pre and textarea
	function filter_pre($value)
	{
		// suppress line break stripping and auto-indent
		$this->pre = true;

		return $value;
	}

}
