<?php

namespace PHPThumb\Plugins;

use PHPThumb\PHPThumb;
use PHPThumb\PluginInterface;

/**
 * GD Reflection Lib Plugin Definition File
 *
 * This file contains the plugin definition for the GD Reflection Lib for PHP Thumb
 *
 * PHP Version 8 with GD 2.3+
 * PhpThumb : PHP Thumb Library <https://github.com/PHPThumb/PHPThumb>
 * Copyright (c) 2009, Ian Selby
 *
 * Author(s): Ian Selby <ianrselby@gmail.com>
 *
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Ian Selby <ianrselby@gmail.com>
 * @copyright Copyright (c) 2009 Ian Selby
 * @link https://github.com/PHPThumb/PHPThumb
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 3.0
 * @package PhpThumb
 * @filesource
 */

/**
 * GD Reflection Lib Plugin
 *
 * This plugin allows you to create those fun Apple(tm)-style reflections in your images
 *
 * @package PhpThumb
 * @subpackage Plugins
 */
class Reflection implements PluginInterface
{
	protected array $current_dimensions;
	protected $working_image;
	protected object $new_image;
	protected array $options;

	protected int $percent;
	protected $reflection;
	protected $white;
	protected $border;
	protected $border_color;

	public function __construct($percent, $reflection, $white, $border, $border_color)
	{
		$this->percent		= $percent;
		$this->reflection	= $reflection;
		$this->white		= $white;
		$this->border		= $border;
		$this->border_color	= $border_color;
	}

	public function execute(PHPThumb $phpthumb): PHPThumb
	{
		$this->current_dimensions	= $phpthumb->getcurrent_dimensions();
		$this->working_image		= $phpthumb->getworking_image();
		$this->new_image			= $phpthumb->getOldImage();
		$this->options				= $phpthumb->getOptions();

		$width						= $this->current_dimensions['width'];
		$height						= $this->current_dimensions['height'];
		$reflection_height			= intval($height * ($this->reflection / 100));
		$new_height					= $height + $reflection_height;
		$reflected_part				= $height * ($this->percent / 100);

		$this->working_image = imagecreatetruecolor($width, $new_height);

		imagealphablending($this->working_image, true);

		$color_to_paint = imagecolorallocatealpha(
			$this->working_image,
			255,
			255,
			255,
			0
		);

		imagefilledrectangle(
			$this->working_image,
			0,
			0,
			$width,
			$new_height,
			$color_to_paint
		);

		imagecopyresampled(
			$this->working_image,
			$this->new_image,
			0,
			0,
			0,
			$reflected_part,
			$width,
			$reflection_height,
			$width,
			($height - $reflected_part)
		);

		$this->imageFlipVertical();

		imagecopy(
			$this->working_image,
			$this->new_image,
			0,
			0,
			0,
			0,
			$width,
			$height
		);

		imagealphablending($this->working_image, true);

		for ($i = 0; $i < $reflection_height; $i++)
		{
			$color_to_paint = imagecolorallocatealpha(
				$this->working_image,
				255,
				255,
				255,
				($i / $reflection_height * -1 + 1) * $this->white
			);

			imagefilledrectangle(
				$this->working_image,
				0,
				$height + $i,
				$width,
				$height + $i,
				$color_to_paint
			);
		}

		if ($this->border)
		{
			$rgb			= $this->hex2rgb($this->border_color, false);
			$color_to_paint	= imagecolorallocate($this->working_image, $rgb[0], $rgb[1], $rgb[2]);

			//top line
			imageline(
				$this->working_image,
				0,
				0,
				$width,
				0,
				$color_to_paint
			);

			//bottom line
			imageline(
				$this->working_image,
				0,
				$height,
				$width,
				$height,
				$color_to_paint
			);

			//left line
			imageline(
				$this->working_image,
				0,
				0,
				0,
				$height,
				$color_to_paint
			);

			//right line
			imageline(
				$this->working_image,
				$width - 1,
				0,
				$width - 1,
				$height,
				$color_to_paint
			);
		}

		if ($phpthumb->getFormat() == 'PNG')
		{
			$color_transparent = imagecolorallocatealpha(
				$this->working_image,
				$this->options['alphaMaskColor'][0],
				$this->options['alphaMaskColor'][1],
				$this->options['alphaMaskColor'][2],
				0
			);

			imagefill		($this->working_image, 0, 0, $color_transparent);
			imagesavealpha	($this->working_image, true);
		}

		$phpthumb->setOldImage($this->working_image);
		$this->current_dimensions['width']  = $width;
		$this->current_dimensions['height'] = $new_height;
		$phpthumb->setCurrentDimensions($this->current_dimensions);

		return $phpthumb;
	}

	/**
	 * Flips the image vertically
	 *
	 */
	protected function imageFlipVertical (): void
	{
		$x_i = imagesx($this->working_image);
		$y_i = imagesy($this->working_image);

		for ($x = 0; $x < $x_i; $x++)
		{
			for ($y = 0; $y < $y_i; $y++)
			{
				imagecopy(
					$this->working_image,
					$this->working_image,
					$x,
					$y_i - $y - 1,
					$x,
					$y,
					1,
					1
				);
			}
		}
	}

	/**
	 * Converts a hex color to rgb tuples
	 */
	protected function hex2rgb (string $hex, bool $as_string = false): string|array
	{
		// strip off any leading #
		if (str_starts_with($hex, '#'))
		{
			$hex = substr($hex, 1);
		}
		else if (str_starts_with($hex, '&H'))
		{
			$hex = substr($hex, 2);
		}

		// break into hex 3-tuple
		$cutpoint	= ceil(strlen($hex) / 2)-1;
		$rgb		= explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 3);

		// convert each tuple to decimal
		$rgb[0] = (isset($rgb[0]) ? hexdec($rgb[0]) : 0);
		$rgb[1] = (isset($rgb[1]) ? hexdec($rgb[1]) : 0);
		$rgb[2] = (isset($rgb[2]) ? hexdec($rgb[2]) : 0);

		return ($as_string ? "$rgb[0] $rgb[1] $rgb[2]" : $rgb);
	}
}
