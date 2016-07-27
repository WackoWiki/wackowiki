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
	protected $filters;

	function __construct()
	{
		$this->filters = [];
		foreach (get_class_methods(__CLASS__) as $meth)
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

	function getFilters()
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

	function call_filter($name, $value, $block, $loc, $args)
	{
		if (isset($this->filters[$name]) && is_callable($this->filters[$name]))
		{
			array_unshift($args, $value, $block, $loc);
			$value = call_user_func_array($this->filters[$name], $args);
		}
		else
		{
			trigger_error('unknown filter ' . $name . ' at ' . $loc, E_USER_WARNING);
		}

		return $value;
	}

	function filter_escape_also_e($value, $block, $loc, $mode = 'html')
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
				trigger_error('invalid escape mode ' . $mode . ' at ' . $loc, E_USER_WARNING);
		}

		return $value;
	}

	function filter_default($value, $block, $loc, $default)
	{
		($value === null || $value === false) and $value = $default;
		return $value;
	}

	function filter_format($value, $block, $loc, $fmt)
	{
		return sprintf($fmt, $value);
	}

	function filter_stringify($value, $block, $loc)
	{
		return Ut::stringify($value);
	}

	function filter_date($value, $block, $loc, $fmt)
	{
		return date($fmt, $value);
	}

	function filter_join($value, $block, $loc, $glue = '')
	{
		return implode($glue, $value);
	}

	function filter_lower($value, $block, $loc)
	{
		return strtolower($value);
	}

	function filter_upper($value, $block, $loc)
	{
		return strtoupper($value);
	}

	function filter_number($value, $block, $loc, $decimals = 0, $dec_point = '.', $thousands_sep = ',')
	{
		return number_format($value, $decimals, $dec_point, $thousands_sep);
	}

	function filter_void($value, $block, $loc)
	{
		return null;
	}

	function filter_index($value, $block, $loc, $path)
	{
		if (substr($path, 0, 1) == '.')
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
		$args = func_get_args();
		$value = array_shift($args);
		$block = array_shift($args);
		$loc = array_shift($args);

		$search = $replace = [];
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
		$args = func_get_args();
		$value = array_shift($args);
		$block = array_shift($args);
		$loc = array_shift($args);

		$options = 0;
		foreach ($args as $option)
		{
			$option = strtoupper($option);

			strncmp($option, 'JSON_', 5) and $option = 'JSON_' . $option;

			if (defined($option))
			{
				$options |= constant($option);
			}
			else
			{
				trigger_error('invalid json_encode option ' . $option . ' at ' . $loc, E_USER_WARNING);
			}
		}

		return json_encode($value, $options);
	}

	function filter_json_decode($value, $block, $loc)
	{
		return json_decode($value, 1);
	}

	function filter_sp2nbsp($value, $block, $loc)
	{
		return preg_replace_callback('# ( +)|^ #',
			function ($x)
			{
				$n = strlen($x[1]);
				return str_repeat('&nbsp; ', $n >> 1) . str_repeat('&nbsp;', $n & 1);
			}, $value);
	}

	/*function filter_spaceless($value, $block, $loc)
	{
		return preg_replace_callback('/>\s+</', function ($m)
			{
				return strpos($m[0], "\n")? '><' : '> <';
			}, $value);
	}*/

	function filter_spaceless($value, $block, $loc)
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
			
			$content = $token[0];
			
			$strip = false;
			
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
						if (substr($html, -1) === ' ' && ($spaces = strspn($content, " \t\r\n\x0b")) > 0)
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

	function filter_regex($value, $block, $loc, $re, $to, $limit = -1, $strict = false)
	{
		$value = preg_replace($re, $to, $value, $limit, $count);

		if ($value === null)
		{
			trigger_error('regex ' . $re . ' failed at ' . $loc, E_USER_WARNING);
		}
		else if ($strict && !$count)
		{
			$value = null;
		}

		return $value;
	}

	function filter_trim($value, $block, $loc, $character_mask = " \t\n\r\0\x0B")
	{
		return trim($value, $character_mask);
	}

	function filter_url_encode($value, $block, $loc)
	{
		if (!is_array($value))
		{
			return rawurlencode((string) $value);
		}

		$list = [];
		foreach ($value as $id => $val)
		{
			$list[] = rawurlencode($id) . '=' . rawurlencode($val);
		}

		return implode('&', $list);
	}

	function filter_striptags($value, $block, $loc, $allowable_tags = '')
	{
		return strip_tags($value, $allowable_tags);
	}

	function filter_nl2br($value, $block, $loc)
	{
		$list = preg_split('/(?:\r\n|\r|\n){2,}/', $value, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($list as &$p)
		{
			$p = '<p>' . str_replace("\n", "<br />\n", $p) . '</p>';
		}

		return implode("\n\n", $list);
	}

	function filter_truncate($value, $block, $loc, $limit, $ellipsis = '...')
	{
		if (strlen($value) > $limit)
		{
			$split = explode(' ', substr($value, 0, $limit));
			$split1 = array_slice($split, 0, -1);
			$value = implode(' ', $split1 ?: $split) . $ellipsis;
		}

		return $value;
	}

	function filter_split($value, $block, $loc, $delimiter, $limit = PHP_INT_MAX)
	{
		return Ut::isempty($delimiter)? str_split($value, $limit) : explode($delimiter, $value, $limit);
	}

	function filter_dbg($value, $block, $loc)
	{
		// suppress ANY errors. templatest is meant to be used standalone, and this is LONE dependency on wacko
		@Diag::dbg($loc, $value);
		return $value;
	}

	function filter_enclose($value, $block, $loc, $pref = '', $post = '')
	{
		return $pref . $value . $post;
	}
}
