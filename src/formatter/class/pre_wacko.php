<?php

/**
 * Preformat text before saving page: resolves macros and some more
 */

class PreFormatter
{
	public $object;
	public string $PRE_REGEX;

	function __construct(&$object)
	{
		$this->object		= &$object;
		$this->PRE_REGEX	=
		'/(' .
		// formatter  %%...%% and ``...``  (atomic groups to avoid backtracking)
		'(?>``.*?``)|' .
		'(?>\%\%.*?\%\%)|' .
		// escaped  ""...""
		'(?>\"\".*?\"\")|' .
		// macro  ::...::
		'(?>::(\S)?::)' .
		')/usm';
	}

	function precallback($things)
	{
		$wacko = &$this->object;
		$thing = $things[1];
		$first = $thing[0] ?? '';

		switch ($first)
		{
			case '`':
				// ``...``
				if (isset($thing[1]) && $thing[1] === '`')
				{
					// Keep exactly as matched
					return $thing;
				}
				break;
			case '%':
				// %%...%%
				if (isset($thing[1]) && $thing[1] === '%')
				{
					return $thing;
				}
				break;
			case '"':
				// ""...""
				if (isset($thing[1]) && $thing[1] === '"')
				{
					return $thing;
				}
				break;
			case ':':
				// ::...::
				if (isset($thing[1]) && $thing[1] === ':')
				{
					$len = strlen($thing);
					if ($len === 5 && $thing === ':::::')
					{
						return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . ')):';
					}
					if ($len === 4 && $thing === '::::')
					{
						return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))';
					}
					if ($thing === '::@::')
					{
						return sprintf(
							$wacko->db->name_date_macro,
							'((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))',
							$wacko->date_format(time(), $wacko->db->date_format . ' ' . $wacko->db->time_format)
							);
					}
					if ($thing === '::+::')
					{
						return $wacko->date_format(time(), $wacko->db->date_format . ' ' . $wacko->db->time_format);
					}
				}
				break;
		}

		// fallback – should never happen, but keep original
		return $thing;
	}
}

