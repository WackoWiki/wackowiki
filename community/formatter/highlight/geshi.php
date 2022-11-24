<?php

// WackoWiki Wrapper for GeSHi - Generic Syntax Highlighter
// https://wackowiki.org/doc/Dev/PatchesHacks/GeSHi

// GeSHi uses constants outside its class, so autoload will default with:
// PHP Fatal error:  Uncaught Error: Undefined constant "GESHI_NO_LINE_NUMBERS"
require_once 'lib/geshi/geshi.php'; // -> autoload.conf

if ($options['_default'])
{
	$language	= $options['_default'];
	$lines		= [];
	$numbers	= GESHI_NO_LINE_NUMBERS;
	$start		= (int) ($options['start'] ?? 1);
	$header		= GESHI_HEADER_PRE_VALID;

	$geshi = new GeSHi($text, $language);

	if (!empty($options['lines']))
	{
		$lines = array_map('intval', explode(',', $options['lines']));
		$lines = array_unique($lines);
	}

	if (!empty($options['numbers']))
	{
		$numbers = $options['numbers'] ? GESHI_NORMAL_LINE_NUMBERS : GESHI_NO_LINE_NUMBERS;

		$header = match ((int) $options['numbers'])
		{
			1		=> GESHI_HEADER_PRE_VALID,
			2		=> GESHI_HEADER_PRE_TABLE,
			default	=> false,
		};
	}

	$geshi->enable_classes();			// use classes for highlighting (must be first after creating object)
	$geshi->set_overall_class('code');	// enables using a single stylesheet for multiple code fragments
	$geshi->set_tab_width(4);			// default: 8

	$geshi->set_header_type($header);	// GESHI_HEADER_DIV, GESHI_HEADER_PRE_VALID, GESHI_HEADER_PRE_TABLE, GESHI_HEADER_NONE

	$geshi->enable_line_numbers((bool) $numbers); // GESHI_NORMAL_LINE_NUMBERS, GESHI_FANCY_LINE_NUMBERS, 2 GESHI_NO_LINE_NUMBERS
	$geshi->start_line_numbers_at((int) abs($start));
	$geshi->highlight_lines_extra($lines);

	// get the stylesheet
	if (!file_exists($this->db->base_path . Ut::join_path(THEME_DIR, '_common/geshi.css')))
	{
		$tpl->css_styles	= $geshi->get_stylesheet(false);
	}
	else
	{
		$this->geshi = true;
	}

	$tpl->text			= $geshi->parse_code();
}
else
{
	$tpl->text			= Ut::html($text);
}
