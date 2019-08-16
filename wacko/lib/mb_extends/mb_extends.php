<?php

function mb_strtr($str, $from, $to ,$chars = 'undefined')
{
	$chars = mb_internal_encoding();
	$_str = '';
	$len = mb_strlen($str, $chars);

	for($i = 0; $i < $len; $i++)
	{
		$flag = false;

		for ($q = 0, $sf = mb_strlen($from, $chars), $st = mb_strlen($to, $chars); $q < $sf && $q < $st; $q++)
		{
			if (mb_substr($str, $i, 1, $chars) == mb_substr($from, $q, 1, $chars))
			{
				$_str = $_str . mb_substr($to, $q, 1, $chars);
				$flag = true;
				break;
			}
		}

		if(!$flag)
		{
			$_str = $_str . mb_substr($str, $i, 1, $chars);
		}
	}

	return $_str;
}

function mb_replace($search, $replace, $subject, &$count=0)
{
	if (!is_array($search) && is_array($replace))
	{
		return false;
	}

	if (is_array($subject))
	{
		// call mb_replace for each single string in $subject
		foreach ($subject as &$string)
		{
			$string = &mb_replace($search, $replace, $string, $c);
			$count += $c;
		}
	}
	else if (is_array($search))
	{
		if (!is_array($replace))
		{
			foreach ($search as &$string)
			{
				$subject = mb_replace($string, $replace, $subject, $c);
				$count += $c;
			}
		}
		else
		{
			$n = max(count($search), count($replace));

			while ($n--)
			{
				$subject = mb_replace(current($search), current($replace), $subject, $c);
				$count += $c;
				next($search);
				next($replace);
			}
		}
	}
	else
	{
		$parts = mb_split(preg_quote($search), $subject);
		$count = count($parts) - 1;
		$subject = implode($replace, $parts);
	}

	return $subject;
}
