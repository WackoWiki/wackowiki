<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Visualizes color sets as boxes.

Usage:
	{{colorbox}}

Options:
	[bg_color="#ffa"]		- background color
	[border_color="#000"]	- border color
	[border_width="3px"]	- border width
	[spec=0|1]				- show color values
	[text="description"]	- description
	[text_color="#000"]		- text color
	[width="300px"]			- width
EOD;

// set defaults
$bg_color			??= '#ffa';
$border_color		??= '#000';
$border_width		??= '1px';
$help				??= 0;
$spec				??= 1;
$text				??= null;
$text_color			??= '#000';
$width				??= '200px';

if ($help)
{
	$tpl->help	= $this->help($info, 'colorbox');
	return;
}

$sanitize = function($value, $filter)
{
	switch ($filter)
	{
		case 'color':
			if (preg_match('/^(
				(\#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}))|		# color value
				(rgb\(([0-9]{1,3}%?,){2}[0-9]{1,3}%?\))		# rgb triplet
				)$/x', $value))
			{
				return $value;
			}
			break;
		case 'width':
			if (preg_match('/^\d*\.?\d+(%|px|em|ex|pt|cm|mm|pi|in)$/', $value))
			{
				return $value;
			}
		case 'class':
			if (preg_match('/[^A-Za-z0-9_-]/', $value))
			{
				return $value;
			}
			break;
	}
};

$bgcolor			=
$tpl->s_bgcolor		= $sanitize($bg_color, 'color');
$tpl->s_bdwidth		= $sanitize($border_width, 'width');
$bdcolor			=
$tpl->s_bdcolor		= $sanitize($border_color, 'color');
$tpl->s_width		= $sanitize($width, 'width');
$color				=
$tpl->s_color		= $sanitize($text_color, 'color');
$tpl->text			= $this->format($text);

if ($spec)
{
	$css['background']	= $bgcolor;
	$css['border']		= $bdcolor;
	$css['color']		= $color;

	foreach ($css as $style => $value)
	{
		$tpl->spec_n_style		= $style;
		$tpl->spec_n_value		= $value;
	}
}
