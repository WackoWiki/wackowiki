<?php

/*

visualize color sets as boxes

{{colorbox background_color="#FDFEB8" border_color="#FFBB00"}}
	$background_color	- background color
	$border_color		- border color
	$text				- description
	$text_color			- text color
	$border_width		- border width
	$width				- width
	$spec				- show color values
*/

// set defaults
$text				??= null;
$border_width		??= '1px';
$background_color	??= '#ffa';
$border_color		??= '#000000';
$text_color			??= '#000000';
$width				??= '200px';
$spec				??= 1;

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

echo '<div style="
	background-color: '	. $sanitize($background_color, 'color') . ';
	border: '			. $sanitize($border_width, 'width') . ' solid ' . $sanitize($border_color, 'color') . ';
	width: ' 			. $sanitize($width, 'width') . ';
	clear: both;
	margin: 10px 0;
	padding: 10px;
	color: ' . $sanitize($text_color, 'color') . ';
	float: left;">' .
	$this->format($text) . ''.
	($spec
		? '<br>' .
		  'background: '	. $sanitize($background_color, 'color') . '<br>' .
		  'border: '		. $sanitize($border_color, 'color') . '<br>' .
		  'color: '			. $sanitize($text_color, 'color') . ''
		: ''
	) . "</div>\n";