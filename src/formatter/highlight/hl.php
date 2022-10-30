<?php

$hl = new Text_Highlighter();

if ($options['_default'])
{
	$language	= $options['_default'];
	$numbers	= false;
	$start		= (int) ($options['start'] ?? 1);

	if (!empty($options['numbers']))
	{
		// HL_NUMBERS_LI HL_NUMBERS_TABLE FALSE -> 1 2 0
		switch ($options['numbers'])
		{
			case 1:
				$numbers = HL_NUMBERS_LI;
				break;
			case 2:
				$numbers = HL_NUMBERS_TABLE;
				break;
			default:
				$numbers = false;
				break;
		}
	}

	$table = ($numbers == HL_NUMBERS_TABLE);

	$hl =& Text_Highlighter::factory(strtoupper($language), ['numbers' => $numbers, 'numbers_start' => $start]);

	if (!is_object($hl))
	{
		$error = '<em>' . Ut::perc_replace($this->_t('FormatterNotFound'), '<code>Highlighter/' . $hl . '</code>') . '</em>';
		$tpl->error = $this->show_message($error, 'error', false);
	}
	else
	{
		if ($table)
		{
			$tpl->num	= true;
			$tpl->enum	= true;
		}

		$tpl->text = $hl->highlight($text);
	}
}
else
{
	$tpl->text = Ut::html($text);
}
