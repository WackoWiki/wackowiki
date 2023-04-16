<?php

namespace PHPThumb;

use Exception;
use InvalidArgumentException;
use RuntimeException;

/**
 * PhpThumb : PHP Thumb Library <https://github.com/PHPThumb/PHPThumb>
 * Copyright (c) 2009, Ian Selby/Gen X Design
 *
 * Author(s): Ian Selby <ianrselby@gmail.com>
 *
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Ian Selby <ianrselby@gmail.com>
 * @copyright Copyright (c) 2009 Gen X Design
 * @link https://github.com/PHPThumb/PHPThumb
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class GD extends PHPThumb
{
	/**
	 * The prior image (before manipulation)
	 *
	 * @var resource
	 */
	protected $oldImage;

	/**
	 * The working image (used during manipulation)
	 *
	 * @var resource
	 */
	protected $workingImage;

	/**
	 * The current dimensions of the image
	 *
	 * @var array
	 */
	protected array $currentDimensions;

	/**
	 * The new, calculated dimensions of the image
	 *
	 * @var array
	 */
	protected array $newDimensions;

	/**
	 * The options for this class
	 *
	 * This array contains various options that determine the behavior in
	 * various functions throughout the class.  Functions note which specific
	 * option key / values are used in their documentation
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * The maximum width an image can be after resizing (in pixels)
	 *
	 * @var int
	 */
	protected int $maxWidth;

	/**
	 * The maximum height an image can be after resizing (in pixels)
	 *
	 * @var int
	 */
	protected int $maxHeight;

	/**
	 * The percentage to resize the image by
	 *
	 * @var int
	 */
	protected int $percent;

	/**
	 * @param string $fileName
	 * @param array $options
	 * @param array $plugins
	 * @throws Exception
	 */
	public function __construct($fileName, array $options = [], array $plugins = [])
	{
		parent::__construct($fileName, $options, $plugins);

		$this->determineFormat();
		$this->verifyFormatCompatiblity();

		$this->oldImage = match ($this->format) {
			'AVIF'		=> imagecreatefromavif		($this->fileName),
			'GIF'		=> imagecreatefromgif		($this->fileName),
			'JPEG'		=> imagecreatefromjpeg		($this->fileName),
			'PNG'		=> imagecreatefrompng		($this->fileName),
			'STRING'	=> imagecreatefromstring	($this->fileName),
			'WEBP'		=> imagecreatefromwebp		($this->fileName),
		};

		$this->currentDimensions = [
			'width'		=> imagesx($this->oldImage),
			'height'	=> imagesy($this->oldImage)
		];
	}

	public function __destruct()
	{
		if (is_resource($this->oldImage))
		{
			imagedestroy($this->oldImage);
		}

		if (is_resource($this->workingImage))
		{
			imagedestroy($this->workingImage);
		}
	}

	/**
	 * Pad an image to desired dimensions. Moves the image into the center and fills the rest with $color.
	 * @param $width
	 * @param $height
	 * @param array $color
	 * @return GD
	 */
	public function pad($width, $height, array $color = [255, 255, 255]): GD
	{
		// no resize - woohoo!
		if ($width == $this->currentDimensions['width'] && $height == $this->currentDimensions['height'])
		{
			return $this;
		}

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($width, $height);
		}
		else
		{
			$this->workingImage = imagecreate($width, $height);
		}

		// create the fill color
		$fillColor = imagecolorallocate(
			$this->workingImage,
			$color[0],
			$color[1],
			$color[2]
		);

		// fill our working image with the fill color
		imagefill(
			$this->workingImage,
			0,
			0,
			$fillColor
		);

		// copy the image into the center of our working image
		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			intval(($width-$this->currentDimensions['width']) / 2),
			intval(($height-$this->currentDimensions['height']) / 2),
			0,
			0,
			$this->currentDimensions['width'],
			$this->currentDimensions['height'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height']
		);

		// update all the variables and resources to be correct
		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $width;
		$this->currentDimensions['height']	= $height;

		return $this;
	}

	/**
	 * Check if the image can be scaled up
	 *
	 * @param int $maxWidth
	 * @param int $maxHeight
	 */
	private function checkingMaxSize(int $maxWidth, int $maxHeight): void
	{
		if ($this->options['resizeUp'] === false)
		{
			$this->maxHeight	= ($maxHeight > $this->currentDimensions['height']) ? $this->currentDimensions['height'] : $maxHeight;
			$this->maxWidth		= ($maxWidth > $this->currentDimensions['width']) ? $this->currentDimensions['width'] : $maxWidth;
		}
		else
		{
			$this->maxHeight	= $maxHeight;
			$this->maxWidth		= $maxWidth;
		}
	}

	/**
	 * Resizes an image to be no larger than $maxWidth or $maxHeight
	 *
	 * If either param is set to zero, then that dimension will not be considered as a part of the resize.
	 * Additionally, if $this->options['resizeUp'] is set to true (false by default), then this function will
	 * also scale the image up to the maximum dimensions provided.
	 *
	 * @param int $maxWidth  The maximum width of the image in pixels
	 * @param int $maxHeight The maximum height of the image in pixels
	 * @return GD
	 */
	public function resize(int $maxWidth = 0, int $maxHeight = 0): GD
	{
		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($maxWidth, $maxHeight);

		// get the new dimensions...
		$this->calcImageSize($this->currentDimensions['width'], $this->currentDimensions['height']);

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);
		}
		else
		{
			$this->workingImage = imagecreate($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);
		}

		$this->preserveAlpha();

		// and create the newly sized image
		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newDimensions['newWidth'],
			$this->newDimensions['newHeight'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height']
		);

		// update all the variables and resources to be correct
		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $this->newDimensions['newWidth'];
		$this->currentDimensions['height']	= $this->newDimensions['newHeight'];

		return $this;
	}

	/**
	 * Adaptively Resizes the Image
	 *
	 * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
	 * remaining overflow (from the center) to get the image to be the size specified
	 *
	 * @param int $width
	 * @param int $height
	 * @return GD
	 */
	public function adaptiveResize(int $width, int $height): GD
	{
		// make sure our arguments are valid
		if ($width == 0 && $height == 0)
		{
			throw new InvalidArgumentException('$width and $height must be numeric and greater than zero');
		}

		if ($width == 0)
		{
			$width = intval(($height * $this->currentDimensions['width']) / $this->currentDimensions['height']);
		}

		if ($height == 0)
		{
			$height = intval(($width * $this->currentDimensions['height']) / $this->currentDimensions['width']);
		}

		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($width, $height);

		$this->calcImageSizeStrict($this->currentDimensions['width'], $this->currentDimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($this->maxWidth, $this->maxHeight);
		}
		else
		{
			$this->workingImage = imagecreate($this->maxWidth, $this->maxHeight);
		}

		$this->preserveAlpha();

		$cropWidth	= $this->maxWidth;
		$cropHeight	= $this->maxHeight;
		$cropX		= 0;
		$cropY		= 0;

		// now, figure out how to crop the rest of the image...
		if ($this->currentDimensions['width'] > $this->maxWidth)
		{
			$cropX = intval(($this->currentDimensions['width'] - $this->maxWidth) / 2);
		}
		else if ($this->currentDimensions['height'] > $this->maxHeight)
		{
			$cropY = intval(($this->currentDimensions['height'] - $this->maxHeight) / 2);
		}

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$cropX,
			$cropY,
			$cropWidth,
			$cropHeight,
			$cropWidth,
			$cropHeight
		);

		// update all the variables and resources to be correct
		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $this->maxWidth;
		$this->currentDimensions['height']	= $this->maxHeight;

		return $this;
	}

	/**
	 * Adaptively Resizes the Image and Crops Using a Percentage
	 *
	 * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
	 * remaining overflow using a provided percentage to get the image to be the size specified.
	 *
	 * The percentage mean different things depending on the orientation of the original image.
	 *
	 * For Landscape images:
	 * ---------------------
	 *
	 * A percentage of 1 would crop the image all the way to the left, which would be the same as
	 * using adaptiveResizeQuadrant() with $quadrant = 'L'
	 *
	 * A percentage of 50 would crop the image to the center which would be the same as using
	 * adaptiveResizeQuadrant() with $quadrant = 'C', or even the original adaptiveResize()
	 *
	 * A percentage of 100 would crop the image to the image all the way to the right, etc., etc.
	 * Note that you can use any percentage between 1 and 100.
	 *
	 * For Portrait images:
	 * --------------------
	 *
	 * This works the same as for Landscape images except that a percentage of 1 means top and 100 means bottom
	 *
	 * @param int $width
	 * @param int $height
	 * @param int $percent
	 * @return GD
	 */
	public function adaptiveResizePercent(int $width, int $height, int $percent = 50): GD
	{
		// make sure our arguments are valid
		if ($width == 0)
		{
			throw new InvalidArgumentException('$width must be numeric and greater than zero');
		}

		if ($height == 0)
		{
			throw new InvalidArgumentException('$height must be numeric and greater than zero');
		}

		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($width, $height);

		$this->calcImageSizeStrict($this->currentDimensions['width'], $this->currentDimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($this->maxWidth, $this->maxHeight);
		}
		else
		{
			$this->workingImage = imagecreate($this->maxWidth, $this->maxHeight);
		}

		$this->preserveAlpha();

		$cropWidth	= $this->maxWidth;
		$cropHeight	= $this->maxHeight;
		$cropX		= 0;
		$cropY		= 0;

		// Crop the rest of the image using the quadrant

		if ($percent > 100)
		{
			$percent = 100;
		}
		else if ($percent < 1)
		{
			$percent = 1;
		}

		if ($this->currentDimensions['width'] > $this->maxWidth)
		{
			// Image is landscape
			$maxCropX	= $this->currentDimensions['width'] - $this->maxWidth;
			$cropX		= intval(($percent / 100) * $maxCropX);

		}
		else if ($this->currentDimensions['height'] > $this->maxHeight)
		{
			// Image is portrait
			$maxCropY	= $this->currentDimensions['height'] - $this->maxHeight;
			$cropY		= intval(($percent / 100) * $maxCropY);
		}

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$cropX,
			$cropY,
			$cropWidth,
			$cropHeight,
			$cropWidth,
			$cropHeight
		);

		// update all the variables and resources to be correct
		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $this->maxWidth;
		$this->currentDimensions['height']	= $this->maxHeight;

		return $this;
	}

	/**
	 * Adaptively Resizes the Image and Crops Using a Quadrant
	 *
	 * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
	 * remaining overflow using the quadrant to get the image to be the size specified.
	 *
	 * The quadrants available are Top, Bottom, Center, Left, and Right:
	 *
	 *
	 * +---+---+---+
	 * |   | T |   |
	 * +---+---+---+
	 * | L | C | R |
	 * +---+---+---+
	 * |   | B |   |
	 * +---+---+---+
	 *
	 * Note that if your image is Landscape and you choose either of the Top or Bottom quadrants (which won't
	 * make sense since only the Left and Right would be available, then the Center quadrant will be used
	 * to crop. This would have exactly the same result as using adaptiveResize().
	 * The same goes if your image is portrait and you choose either the Left or Right quadrants.
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $quadrant  T, B, C, L, R
	 * @return GD
	 */
	public function adaptiveResizeQuadrant(int $width, int $height, string $quadrant = 'C'): GD
	{
		// make sure our arguments are valid
		if ($width == 0)
		{
			throw new InvalidArgumentException('$width must be numeric and greater than zero');
		}

		if ($height == 0)
		{
			throw new InvalidArgumentException('$height must be numeric and greater than zero');
		}

		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($width, $height);

		$this->calcImageSizeStrict($this->currentDimensions['width'], $this->currentDimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($this->maxWidth, $this->maxHeight);
		}
		else
		{
			$this->workingImage = imagecreate($this->maxWidth, $this->maxHeight);
		}

		$this->preserveAlpha();

		$cropWidth	= $this->maxWidth;
		$cropHeight	= $this->maxHeight;
		$cropX		= 0;
		$cropY		= 0;

		// Crop the rest of the image using the quadrant

		if ($this->currentDimensions['width'] > $this->maxWidth)
		{
			// Image is landscape
			$cropX = match ($quadrant) {
				'L'		=> 0,
				'R'		=> intval(($this->currentDimensions['width'] - $this->maxWidth)),
				default	=> intval(($this->currentDimensions['width'] - $this->maxWidth) / 2),
			};
		}
		else if ($this->currentDimensions['height'] > $this->maxHeight)
		{
			// Image is portrait
			$cropY = match ($quadrant) {
				'T'		=> 0,
				'B'		=> intval(($this->currentDimensions['height'] - $this->maxHeight)),
				default	=> intval(($this->currentDimensions['height'] - $this->maxHeight) / 2),
			};
		}

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$cropX,
			$cropY,
			$cropWidth,
			$cropHeight,
			$cropWidth,
			$cropHeight
		);

		// update all the variables and resources to be correct
		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $this->maxWidth;
		$this->currentDimensions['height']	= $this->maxHeight;

		return $this;
	}

	/**
	 * Resizes an image by a given percent uniformly,
	 * Percentage should be whole number representation (i.e. 1-100)
	 *
	 * @param int $percent
	 * @return GD
	 * @throws InvalidArgumentException
	 */
	public function resizePercent(int $percent = 0): GD
	{
		$this->percent = $percent;

		$this->calcImageSizePercent($this->currentDimensions['width'], $this->currentDimensions['height']);

		return $this->resize($this->newDimensions['newWidth'], $this->newDimensions['newHeight']);
	}

	/**
	 * Crops an image from the center with provided dimensions
	 *
	 * If no height is given, the width will be used as a height, thus creating a square crop
	 *
	 * @param int $cropWidth
	 * @param int|null $cropHeight
	 * @return GD
	 */
	public function cropFromCenter(int $cropWidth, int $cropHeight = 0): GD
	{
		if ($cropHeight == 0)
		{
			$cropHeight = $cropWidth;
		}

		$cropWidth	= ($this->currentDimensions['width'] < $cropWidth)		? $this->currentDimensions['width']		: $cropWidth;
		$cropHeight	= ($this->currentDimensions['height'] < $cropHeight)	? $this->currentDimensions['height']	: $cropHeight;

		$cropX = intval(($this->currentDimensions['width'] - $cropWidth) / 2);
		$cropY = intval(($this->currentDimensions['height'] - $cropHeight) / 2);

		$this->crop($cropX, $cropY, $cropWidth, $cropHeight);

		return $this;
	}

	/**
	 * Vanilla Cropping - Crops from x,y with specified width and height
	 *
	 * @param int $startX
	 * @param int $startY
	 * @param int $cropWidth
	 * @param int $cropHeight
	 * @return GD
	 */
	public function crop(int $startX, int $startY, int $cropWidth, int $cropHeight): GD
	{
		// do some calculations
		$cropWidth	= ($this->currentDimensions['width'] < $cropWidth) ? $this->currentDimensions['width'] : $cropWidth;
		$cropHeight	= ($this->currentDimensions['height'] < $cropHeight) ? $this->currentDimensions['height'] : $cropHeight;

		// ensure everything's in bounds
		if (($startX + $cropWidth) > $this->currentDimensions['width'])
		{
			$startX = ($this->currentDimensions['width'] - $cropWidth);
		}

		if (($startY + $cropHeight) > $this->currentDimensions['height'])
		{
			$startY = ($this->currentDimensions['height'] - $cropHeight);
		}

		if ($startX < 0)
		{
			$startX = 0;
		}

		if ($startY < 0)
		{
			$startY = 0;
		}

		// create the working image
		if (function_exists('imagecreatetruecolor'))
		{
			$this->workingImage = imagecreatetruecolor($cropWidth, $cropHeight);
		}
		else
		{
			$this->workingImage = imagecreate($cropWidth, $cropHeight);
		}

		$this->preserveAlpha();

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$startX,
			$startY,
			$cropWidth,
			$cropHeight,
			$cropWidth,
			$cropHeight
		);

		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= $cropWidth;
		$this->currentDimensions['height']	= $cropHeight;

		return $this;
	}

	/**
	 * Rotates image either 90 degrees clockwise or counter-clockwise
	 *
	 * @param string $direction
	 * @return GD
	 */
	public function rotateImage(string $direction = 'CW'): GD
	{
		if ($direction == 'CW')
		{
			$this->rotateImageNDegrees(90);
		}
		else
		{
			$this->rotateImageNDegrees(-90);
		}

		return $this;
	}

	/**
	 * Rotates image specified number of degrees
	 *
	 * @param int $degrees
	 * @return GD
	 */
	public function rotateImageNDegrees(int $degrees): GD
	{
		if (!function_exists('imagerotate'))
		{
			throw new RuntimeException('Your version of GD does not support image rotation');
		}

		$this->workingImage = imagerotate($this->oldImage, $degrees, 0);

		$this->oldImage						= $this->workingImage;
		$this->currentDimensions['width']	= imagesx($this->workingImage);
		$this->currentDimensions['height']	= imagesy($this->workingImage);

		return $this;
	}

	/**
	 * Applies a filter to the image
	 *
	 * @param int $filter
	 * @param bool $arg1
	 * @param bool $arg2
	 * @param bool $arg3
	 * @param bool $arg4
	 * @return GD
	 */
	public function imageFilter(int $filter, bool $arg1 = false, bool $arg2 = false, bool $arg3 = false, bool $arg4 = false): GD
	{
		if (!function_exists('imagefilter'))
		{
			throw new RuntimeException('Your version of GD does not support image filters');
		}

		if ($arg1 === false)
		{
			$result = imagefilter($this->oldImage, $filter);
		}
		else if ($arg2 === false)
		{
			$result = imagefilter($this->oldImage, $filter, $arg1);
		}
		else if ($arg3 === false)
		{
			$result = imagefilter($this->oldImage, $filter, $arg1, $arg2);
		}
		else if ($arg4 === false)
		{
			$result = imagefilter($this->oldImage, $filter, $arg1, $arg2, $arg3);
		}
		else
		{
			$result = imagefilter($this->oldImage, $filter, $arg1, $arg2, $arg3, $arg4);
		}

		if (!$result)
		{
			throw new RuntimeException('GD imagefilter failed');
		}

		$this->workingImage = $this->oldImage;

		return $this;
	}

	/**
	 * Shows an image
	 *
	 * This function will show the current image by first sending the appropriate header
	 * for the format, and then outputting the image data. If headers have already been sent,
	 * a runtime exception will be thrown
	 *
	 * @param bool $rawData Whether or not the raw image stream should be output
	 * @return GD
	 */
	public function show(bool $rawData = false): GD
	{
		//Execute any plugins
		if ($this->plugins)
		{
			foreach ($this->plugins as $plugin)
			{
				/* @var $plugin PluginInterface */
				$plugin->execute($this);
			}
		}

		if (headers_sent() && php_sapi_name() != 'cli')
		{
			throw new RuntimeException('Cannot show image, headers have already been sent');
		}

		// When the interlace option equals true or false call imageinterlace else leave it to default
		if ($this->options['interlace'] === true)
		{
			imageinterlace($this->oldImage, 1);
		}
		else if ($this->options['interlace'] === false)
		{
			imageinterlace($this->oldImage, 0);
		}

		switch ($this->format) {
			case 'AVIF':
				if ($rawData === false)
				{
					header('Content-type: image/avif');
				}
				imageavif($this->oldImage);
				break;
			case 'GIF':
				if ($rawData === false)
				{
					header('Content-type: image/gif');
				}
				imagegif($this->oldImage);
				break;
			case 'JPEG':
				if ($rawData === false)
				{
					header('Content-type: image/jpeg');
				}
				imagejpeg($this->oldImage, null, $this->options['jpegQuality']);
				break;
			case 'PNG':
			case 'STRING':
				if ($rawData === false)
				{
					header('Content-type: image/png');
				}
				imagepng($this->oldImage);
				break;
			case 'WEBP':
				if ($rawData === false)
				{
					header('Content-type: image/webp');
				}
				imagewebp($this->oldImage);
				break;
		}

		return $this;
	}

	/**
	 * Returns the Working Image as a String
	 *
	 * This function is useful for getting the raw image data as a string for storage in
	 * a database, or other similar things.
	 *
	 * @return string
	 */
	public function getImageAsString(): string
	{
		ob_start();
		$this->show(true);
		$data = ob_get_contents();
		ob_end_clean();

		return $data;
	}

	/**
	 * Saves an image
	 *
	 * This function will make sure the target directory is writeable, and then save the image.
	 *
	 * If the target directory is not writeable, the function will try to correct the permissions (if allowed, this
	 * is set as an option ($this->options['correctPermissions']).  If the target cannot be made writeable, then a
	 * \RuntimeException is thrown.
	 *
	 * @param string $fileName The full path and filename of the image to save
	 * @param string|null $format   The format to save the image in (optional, must be one of [AVIF, GIF, JPEG, JPG, PNG, WEBP]
	 * @return GD
	 */
	public function save(string $fileName, string $format = null): GD
	{
		$validFormats	= ['AVIF', 'GIF', 'JPEG', 'JPG', 'PNG', 'WEBP'];
		$format			= ($format !== null) ? strtoupper($format) : $this->format;

		if (!in_array($format, $validFormats))
		{
			throw new InvalidArgumentException('Invalid format type specified in save function: ' . $format);
		}

		// make sure the directory is writeable
		if (!is_writeable(dirname($fileName)))
		{
			// try to correct the permissions
			if ($this->options['correctPermissions'] === true)
			{
				@chmod(dirname($fileName), 0777);

				// throw an exception if not writeable
				if (!is_writeable(dirname($fileName)))
				{
					throw new RuntimeException('File is not writeable, and could not correct permissions: ' . $fileName);
				}
			}
			else
			{ // throw an exception if not writeable
				throw new RuntimeException('File not writeable: ' . $fileName);
			}
		}

		// When the interlace option equals true or false call imageinterlace else leave it to default
		if ($this->options['interlace'] === true)
		{
			imageinterlace($this->oldImage, 1);
		}
		else if ($this->options['interlace'] === false)
		{
			imageinterlace($this->oldImage, 0);
		}

		switch ($format) {
			case 'AVIF':
				imageavif($this->oldImage, $fileName);
				break;
			case 'GIF':
				imagegif($this->oldImage, $fileName);
				break;
			case 'JPEG':
			case 'JPG':
				imagejpeg($this->oldImage, $fileName, $this->options['jpegQuality']);
				break;
			case 'PNG':
				imagepng($this->oldImage, $fileName);
				break;
			case 'WEBP':
				imagewebp($this->oldImage, $fileName);
				break;
		}

		return $this;
	}

	#################################
	# ----- GETTERS / SETTERS ----- #
	#################################

	/**
	 * Sets options for all operations.
	 * @param array $options
	 * @return GD
	 */
	public function setOptions(array $options = []): GD
	{
		// we've yet to init the default options, so create them here
		if (count($this->options) == 0)
		{
			$defaultOptions = [
				'resizeUp'				=> false,
				'jpegQuality'			=> 100,
				'correctPermissions'	=> false,
				'preserveAlpha'			=> true,
				'alphaMaskColor'		=> [255, 255, 255],
				'preserveTransparency'	=> true,
				'transparencyMaskColor'	=> [0, 0, 0],
				'interlace'				=> null
			];
		}
		else
		{
			// otherwise, let's use what we've got already
			$defaultOptions = $this->options;
		}

		$this->options = array_merge($defaultOptions, $options);

		return $this;
	}

	/**
	 * Returns $currentDimensions.
	 *
	 * @see GD
	 */
	public function getCurrentDimensions(): array
	{
		return $this->currentDimensions;
	}

	/**
	 * @param $currentDimensions
	 * @return GD
	 */
	public function setCurrentDimensions($currentDimensions): GD
	{
		$this->currentDimensions = $currentDimensions;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getMaxHeight(): int
	{
		return $this->maxHeight;
	}

	/**
	 * @param $maxHeight
	 * @return GD
	 */
	public function setMaxHeight($maxHeight): GD
	{
		$this->maxHeight = $maxHeight;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getMaxWidth(): int
	{
		return $this->maxWidth;
	}

	/**
	 * @param $maxWidth
	 * @return GD
	 */
	public function setMaxWidth($maxWidth): GD
	{
		$this->maxWidth = $maxWidth;

		return $this;
	}

	/**
	 * Returns $newDimensions.
	 *
	 * @see GD
	 */
	public function getNewDimensions(): array
	{
		return $this->newDimensions;
	}

	/**
	 * Sets $newDimensions.
	 *
	 * @param array $newDimensions
	 * @return GD
	 * @see GD
	 */
	public function setNewDimensions(array $newDimensions): GD
	{
		$this->newDimensions = $newDimensions;

		return $this;
	}

	/**
	 * Returns $options.
	 *
	 * @see GD
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	/**
	 * Returns $percent.
	 *
	 * @see GD
	 */
	public function getPercent(): int
	{
		return $this->percent;
	}

	/**
	 * Sets $percent.
	 *
	 * @param int $percent
	 * @return GD
	 * @see GD
	 */
	public function setPercent(int $percent): GD
	{
		$this->percent = $percent;

		return $this;
	}

	/**
	 * Returns $oldImage.
	 *
	 * @see GD
	 */
	public function getOldImage()
	{
		return $this->oldImage;
	}

	/**
	 * Sets $oldImage.
	 *
	 * @param object $oldImage
	 * @return GD
	 * @see GD
	 */
	public function setOldImage(object $oldImage): GD
	{
		$this->oldImage = $oldImage;

		return $this;
	}

	/**
	 * Returns $workingImage.
	 *
	 * @see GD
	 */
	public function getWorkingImage()
	{
		return $this->workingImage;
	}

	/**
	 * Sets $workingImage.
	 *
	 * @param object $workingImage
	 * @return GD
	 * @see GD
	 */
	public function setWorkingImage(object $workingImage): GD
	{
		$this->workingImage = $workingImage;

		return $this;
	}


	#################################
	# ----- UTILITY FUNCTIONS ----- #
	#################################

	/**
	 * Calculates a new width and height for the image based on $this->maxWidth and the provided dimensions
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	protected function calcWidth(int $width, int $height): array
	{
		$newWidthPercentage	= (100 * $this->maxWidth) / $width;
		$newHeight			= ($height * $newWidthPercentage) / 100;

		return [
			'newWidth'	=> $this->maxWidth,
			'newHeight'	=> intval($newHeight)
		];
	}

	/**
	 * Calculates a new width and height for the image based on $this->maxWidth and the provided dimensions
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	protected function calcHeight(int $width, int $height): array
	{
		$newHeightPercentage	= (100 * $this->maxHeight) / $height;
		$newWidth				= ($width * $newHeightPercentage) / 100;

		return [
			'newWidth'	=> ceil($newWidth),
			'newHeight'	=> ceil($this->maxHeight)
		];
	}

	/**
	 * Calculates a new width and height for the image based on $this->percent and the provided dimensions
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	protected function calcPercent(int $width, int $height): array
	{
		$newWidth	= ($width * $this->percent) / 100;
		$newHeight	= ($height * $this->percent) / 100;

		return [
			'newWidth'	=> ceil($newWidth),
			'newHeight'	=> ceil($newHeight)
		];
	}

	/**
	 * Calculates the new image dimensions
	 *
	 * These calculations are based on both the provided dimensions and $this->maxWidth and $this->maxHeight
	 *
	 * @param int $width
	 * @param int $height
	 */
	protected function calcImageSize(int $width, int $height): void
	{
		$newSize = [
			'newWidth'	=> $width,
			'newHeight'	=> $height
		];

		if ($this->maxWidth > 0)
		{
			$newSize = $this->calcWidth($width, $height);

			if ($this->maxHeight > 0 && $newSize['newHeight'] > $this->maxHeight)
			{
				$newSize = $this->calcHeight($newSize['newWidth'], $newSize['newHeight']);
			}
		}

		if ($this->maxHeight > 0)
		{
			$newSize = $this->calcHeight($width, $height);

			if ($this->maxWidth > 0 && $newSize['newWidth'] > $this->maxWidth)
			{
				$newSize = $this->calcWidth($newSize['newWidth'], $newSize['newHeight']);
			}
		}

		$this->newDimensions = $newSize;
	}

	/**
	 * Calculates new image dimensions, not allowing the width and height to be less than either the max width or height
	 *
	 * @param int $width
	 * @param int $height
	 */
	protected function calcImageSizeStrict(int $width, int $height): void
	{
		$newDimensions = $this->getCurrentDimensions();

		// first, we need to determine what the longest resize dimension is..
		if ($this->maxWidth >= $this->maxHeight)
		{
			// and determine the longest original dimension
			if ($width > $height)
			{
				$newDimensions = $this->calcHeight($width, $height);

				if ($newDimensions['newWidth'] < $this->maxWidth)
				{
					$newDimensions = $this->calcWidth($width, $height);
				}
			}
			else if ($height >= $width)
			{
				$newDimensions = $this->calcWidth($width, $height);

				if ($newDimensions['newHeight'] < $this->maxHeight)
				{
					$newDimensions = $this->calcHeight($width, $height);
				}
			}
		}
		else if ($this->maxHeight > $this->maxWidth)
		{
			if ($width >= $height)
			{
				$newDimensions = $this->calcWidth($width, $height);

				if ($newDimensions['newHeight'] < $this->maxHeight)
				{
					$newDimensions = $this->calcHeight($width, $height);
				}
			}
			else if ($height > $width)
			{
				$newDimensions = $this->calcHeight($width, $height);

				if ($newDimensions['newWidth'] < $this->maxWidth)
				{
					$newDimensions = $this->calcWidth($width, $height);
				}
			}
		}

		$this->newDimensions = $newDimensions;
	}

	/**
	 * Calculates new dimensions based on $this->percent and the provided dimensions
	 *
	 * @param int $width
	 * @param int $height
	 */
	protected function calcImageSizePercent(int $width, int $height): void
	{
		if ($this->percent > 0)
		{
			$this->newDimensions = $this->calcPercent($width, $height);
		}
	}

	/**
	 * Determines the file format by mime-type
	 *
	 * This function will throw exceptions for invalid images / mime-types
	 *
	 * @throws Exception
	 */
	protected function determineFormat(): void
	{
		$formatInfo = getimagesize($this->fileName);

		// non-image files will return false
		if ($formatInfo === false)
		{
			if ($this->remoteImage)
			{
				throw new Exception('Could not determine format of remote image: ' . $this->fileName);
			}
			else
			{
				throw new Exception('File is not a valid image: ' . $this->fileName);
			}
		}

		$mimeType = $formatInfo['mime'] ?? null;

		$this->format = match ($mimeType) {
			'image/avif'	=> 'AVIF',
			'image/gif'		=> 'GIF',
			'image/jpeg'	=> 'JPEG',
			'image/png'		=> 'PNG',
			'image/webp'	=> 'WEBP',
			default			=> throw new \Exception('Image format not supported: ' . $mimeType),
		};
	}

	/**
	 * Makes sure the correct GD implementation exists for the file type
	 *
	 * @throws Exception
	 */
	protected function verifyFormatCompatiblity(): void
	{
		$gdInfo = gd_info();

		$isCompatible = match ($this->format) {
			'AVIF'	=> $gdInfo[$this->format . ' Support'],
			'GIF'	=> $gdInfo['GIF Create Support'],
			'JPEG'	=> isset($gdInfo['JPG Support']) || isset($gdInfo['JPEG Support']),
			'PNG'	=> $gdInfo[$this->format . ' Support'],
			'WEBP'	=> $gdInfo['WebP Support'],
			default	=> false,
		};

		$suffix = strtolower($this->format);

		$isCompatible =
			   function_exists('image' . $suffix)
			&& function_exists('imagecreatefrom' . $suffix)
			&& $isCompatible;

		if (!$isCompatible)
		{
			throw new Exception('Your GD installation does not support ' . $this->format . ' image types');
		}
	}

	/**
	 * Preserves the alpha or transparency for PNG and GIF files
	 *
	 * Alpha / transparency will not be preserved if the appropriate options are set to false.
	 * Also, the GIF transparency is pretty skunky (the results aren't awesome), but it works like a
	 * champ... that's the nature of GIFs tho, so no huge surprise.
	 *
	 * This functionality was originally suggested by commenter Aimi (no links / site provided) - Thanks! :)
	 *
	 */
	protected function preserveAlpha(): void
	{
		if ($this->format == 'PNG' && $this->options['preserveAlpha'] === true)
		{
			imagealphablending($this->workingImage, false);

			$colorTransparent = imagecolorallocatealpha(
				$this->workingImage,
				$this->options['alphaMaskColor'][0],
				$this->options['alphaMaskColor'][1],
				$this->options['alphaMaskColor'][2],
				0
			);

			imagefill($this->workingImage, 0, 0, $colorTransparent);
			imagesavealpha($this->workingImage, true);
		}

		// preserve transparency in GIFs... this is usually pretty rough tho
		if ($this->format == 'GIF' && $this->options['preserveTransparency'] === true)
		{
			$colorTransparent = imagecolorallocate(
				$this->workingImage,
				$this->options['transparencyMaskColor'][0],
				$this->options['transparencyMaskColor'][1],
				$this->options['transparencyMaskColor'][2]
			);

			imagecolortransparent($this->workingImage, $colorTransparent);
			imagetruecolortopalette($this->workingImage, true, 256);
		}
	}
}
