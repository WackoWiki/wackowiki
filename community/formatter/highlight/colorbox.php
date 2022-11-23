<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*

visualize color sets as boxes

%%(colorbox bg_color="#FDFEB8" border_color="#FFBB00") %%
	bg_color			- background color
	border_color		- border color
	text				- description
	text_color			- text color
	border_width		- border width
	width				- width
	spec				- show color values
*/

// set defaults
$text						??= null;
$options['border_width']	??= '1px';
$options['bg_color']		??= '#ffa';
$options['border_color']	??= '#000000';
$options['text_color']		??= '#000000';
$options['width']			??= '200px';
$options['spec']			??= 1;

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
$tpl->s_bgcolor		= $sanitize($options['bg_color'], 'color');
$tpl->s_bdwidth		= $sanitize($options['border_width'], 'width');
$bdcolor			=
$tpl->s_bdcolor		= $sanitize($options['border_color'], 'color');
$tpl->s_width		= $sanitize($options['width'], 'width');
$color				=
$tpl->s_color		= $sanitize($options['text_color'], 'color');
$tpl->text			= $this->format($text);

if ($options['spec'])
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
