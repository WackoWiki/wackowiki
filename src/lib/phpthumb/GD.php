<?php

namespace PHPThumb;

use Exception;
use InvalidArgumentException;
use RuntimeException;

/**
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
 */

class GD extends PHPThumb
{
	/**
	 * The prior image (before manipulation)
	 *
	 * @var resource
	 */
	protected $old_image;

	/**
	 * The working image (used during manipulation)
	 *
	 * @var resource
	 */
	protected $working_image;

	/**
	 * The current dimensions of the image
	 */
	protected array $current_dimensions;

	/**
	 * The new, calculated dimensions of the image
	 */
	protected array $new_dimensions;

	/**
	 * The options for this class
	 *
	 * This array contains various options that determine the behavior in
	 * various functions throughout the class.  Functions note which specific
	 * option key / values are used in their documentation
	 */
	protected array $options = [];

	/**
	 * The maximum width an image can be after resizing (in pixels)
	 */
	protected int $max_width;

	/**
	 * The maximum height an image can be after resizing (in pixels)
	 */
	protected int $max_height;

	/**
	 * The percentage to resize the image by
	 */
	protected int $percent;

	/**
	 * @throws Exception
	 */
	public function __construct(string $file_name, array $options = [], array $plugins = [])
	{
		parent::__construct($file_name, $options, $plugins);

		$this->determineFormat();
		$this->verifyFormatCompatibility();

		$this->old_image = match ($this->format) {
			'AVIF'		=> imagecreatefromavif		($this->file_name),
			'GIF'		=> imagecreatefromgif		($this->file_name),
			'JPEG'		=> imagecreatefromjpeg		($this->file_name),
			'PNG'		=> imagecreatefrompng		($this->file_name),
			'STRING'	=> imagecreatefromstring	($this->file_name),
			'WEBP'		=> imagecreatefromwebp		($this->file_name),
		};

		$this->current_dimensions = [
			'width'		=> imagesx($this->old_image),
			'height'	=> imagesy($this->old_image)
		];
	}

	public function __destruct()
	{
		if (is_resource($this->old_image))
		{
			imagedestroy($this->old_image);
		}

		if (is_resource($this->working_image))
		{
			imagedestroy($this->working_image);
		}
	}

	/**
	 * Pad an image to desired dimensions. Moves the image into the center and fills the rest with $color.
	 */
	public function pad(int $width, int $height, array $color = [255, 255, 255]): GD
	{
		// no resize - woohoo!
		if ($width == $this->current_dimensions['width'] && $height == $this->current_dimensions['height'])
		{
			return $this;
		}

		// create the working image
		$this->working_image = imagecreatetruecolor($width, $height);

		// create the fill color
		$fill_color = imagecolorallocate(
			$this->working_image,
			$color[0],
			$color[1],
			$color[2]
		);

		// fill our working image with the fill color
		imagefill(
			$this->working_image,
			0,
			0,
			$fill_color
		);

		// copy the image into the center of our working image
		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			intval(($width-$this->current_dimensions['width']) / 2),
			intval(($height-$this->current_dimensions['height']) / 2),
			0,
			0,
			$this->current_dimensions['width'],
			$this->current_dimensions['height'],
			$this->current_dimensions['width'],
			$this->current_dimensions['height']
		);

		// update all the variables and resources to be correct
		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $width;
		$this->current_dimensions['height']	= $height;

		return $this;
	}

	/**
	 * Check if the image can be scaled up
	 */
	private function checkingMaxSize(int $max_width, int $max_height): void
	{
		if ($this->options['resizeUp'] === false)
		{
			$this->max_height	= ($max_height > $this->current_dimensions['height'])	? $this->current_dimensions['height']	: $max_height;
			$this->max_width	= ($max_width > $this->current_dimensions['width'])		? $this->current_dimensions['width']	: $max_width;
		}
		else
		{
			$this->max_height	= $max_height;
			$this->max_width	= $max_width;
		}
	}

	/**
	 * Resizes an image to be no larger than $max_width or $max_height
	 *
	 * If either param is set to zero, then that dimension will not be considered as a part of the resize.
	 * Additionally, if $this->options['resizeUp'] is set to true (false by default), then this function will
	 * also scale the image up to the maximum dimensions provided.
	 *
	 * @param int $max_width  The maximum width of the image in pixels
	 * @param int $max_height The maximum height of the image in pixels
	 */
	public function resize(int $max_width = 0, int $max_height = 0): GD
	{
		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($max_width, $max_height);

		// get the new dimensions...
		$this->calcImageSize($this->current_dimensions['width'], $this->current_dimensions['height']);

		// create the working image
		$this->working_image = imagecreatetruecolor($this->new_dimensions['new_width'], $this->new_dimensions['new_height']);

		$this->preserveAlpha();

		// and create the newly sized image
		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			0,
			0,
			0,
			0,
			$this->new_dimensions['new_width'],
			$this->new_dimensions['new_height'],
			$this->current_dimensions['width'],
			$this->current_dimensions['height']
		);

		// update all the variables and resources to be correct
		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $this->new_dimensions['new_width'];
		$this->current_dimensions['height']	= $this->new_dimensions['new_height'];

		return $this;
	}

	/**
	 * Adaptively Resizes the Image
	 *
	 * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
	 * remaining overflow (from the center) to get the image to be the size specified
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
			$width = intval(($height * $this->current_dimensions['width']) / $this->current_dimensions['height']);
		}

		if ($height == 0)
		{
			$height = intval(($width * $this->current_dimensions['height']) / $this->current_dimensions['width']);
		}

		// make sure we're not exceeding our image size if we're not supposed to
		$this->checkingMaxSize($width, $height);

		$this->calcImageSizeStrict($this->current_dimensions['width'], $this->current_dimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->new_dimensions['new_width'], $this->new_dimensions['new_height']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		$this->working_image = imagecreatetruecolor($this->max_width, $this->max_height);

		$this->preserveAlpha();

		$crop_width		= $this->max_width;
		$crop_height	= $this->max_height;
		$crop_x			= 0;
		$crop_y			= 0;

		// now, figure out how to crop the rest of the image...
		if ($this->current_dimensions['width'] > $this->max_width)
		{
			$crop_x = intval(($this->current_dimensions['width'] - $this->max_width) / 2);
		}
		else if ($this->current_dimensions['height'] > $this->max_height)
		{
			$crop_y = intval(($this->current_dimensions['height'] - $this->max_height) / 2);
		}

		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			0,
			0,
			$crop_x,
			$crop_y,
			$crop_width,
			$crop_height,
			$crop_width,
			$crop_height
		);

		// update all the variables and resources to be correct
		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $this->max_width;
		$this->current_dimensions['height']	= $this->max_height;

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

		$this->calcImageSizeStrict($this->current_dimensions['width'], $this->current_dimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->new_dimensions['new_width'], $this->new_dimensions['new_height']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		$this->working_image = imagecreatetruecolor($this->max_width, $this->max_height);

		$this->preserveAlpha();

		$crop_width		= $this->max_width;
		$crop_height	= $this->max_height;
		$crop_x			= 0;
		$crop_y			= 0;

		// Crop the rest of the image using the quadrant

		if ($percent > 100)
		{
			$percent = 100;
		}
		else if ($percent < 1)
		{
			$percent = 1;
		}

		if ($this->current_dimensions['width'] > $this->max_width)
		{
			// Image is landscape
			$max_crop_x	= $this->current_dimensions['width'] - $this->max_width;
			$crop_x		= intval(($percent / 100) * $max_crop_x);

		}
		else if ($this->current_dimensions['height'] > $this->max_height)
		{
			// Image is portrait
			$max_crop_y	= $this->current_dimensions['height'] - $this->max_height;
			$crop_y		= intval(($percent / 100) * $max_crop_y);
		}

		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			0,
			0,
			$crop_x,
			$crop_y,
			$crop_width,
			$crop_height,
			$crop_width,
			$crop_height
		);

		// update all the variables and resources to be correct
		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $this->max_width;
		$this->current_dimensions['height']	= $this->max_height;

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

		$this->calcImageSizeStrict($this->current_dimensions['width'], $this->current_dimensions['height']);

		// resize the image to be close to our desired dimensions
		$this->resize($this->new_dimensions['new_width'], $this->new_dimensions['new_height']);

		// reset the max dimensions...
		$this->checkingMaxSize($width, $height);

		// create the working image
		$this->working_image = imagecreatetruecolor($this->max_width, $this->max_height);


		$this->preserveAlpha();

		$crop_width		= $this->max_width;
		$crop_height	= $this->max_height;
		$crop_x			= 0;
		$crop_y			= 0;

		// Crop the rest of the image using the quadrant

		if ($this->current_dimensions['width'] > $this->max_width)
		{
			// Image is landscape
			$crop_x = match ($quadrant) {
				'L'		=> 0,
				'R'		=> intval(($this->current_dimensions['width'] - $this->max_width)),
				default	=> intval(($this->current_dimensions['width'] - $this->max_width) / 2),
			};
		}
		else if ($this->current_dimensions['height'] > $this->max_height)
		{
			// Image is portrait
			$crop_y = match ($quadrant) {
				'T'		=> 0,
				'B'		=> intval(($this->current_dimensions['height'] - $this->max_height)),
				default	=> intval(($this->current_dimensions['height'] - $this->max_height) / 2),
			};
		}

		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			0,
			0,
			$crop_x,
			$crop_y,
			$crop_width,
			$crop_height,
			$crop_width,
			$crop_height
		);

		// update all the variables and resources to be correct
		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $this->max_width;
		$this->current_dimensions['height']	= $this->max_height;

		return $this;
	}

	/**
	 * Resizes an image by a given percent uniformly,
	 * Percentage should be whole number representation (i.e. 1-100)
	 *
	 * @throws InvalidArgumentException
	 */
	public function resizePercent(int $percent = 0): GD
	{
		$this->percent = $percent;

		$this->calcImageSizePercent($this->current_dimensions['width'], $this->current_dimensions['height']);

		return $this->resize($this->new_dimensions['new_width'], $this->new_dimensions['new_height']);
	}

	/**
	 * Crops an image from the center with provided dimensions
	 *
	 * If no height is given, the width will be used as a height, thus creating a square crop
	 */
	public function cropFromCenter(int $crop_width, ?int $crop_height = 0): GD
	{
		if ($crop_height == 0)
		{
			$crop_height = $crop_width;
		}

		$crop_width		= ($this->current_dimensions['width'] < $crop_width)	? $this->current_dimensions['width']	: $crop_width;
		$crop_height	= ($this->current_dimensions['height'] < $crop_height)	? $this->current_dimensions['height']	: $crop_height;

		$crop_x = intval(($this->current_dimensions['width'] - $crop_width) / 2);
		$crop_y = intval(($this->current_dimensions['height'] - $crop_height) / 2);

		$this->crop($crop_x, $crop_y, $crop_width, $crop_height);

		return $this;
	}

	/**
	 * Vanilla Cropping - Crops from x,y with specified width and height
	 */
	public function crop(int $start_x, int $start_y, int $crop_width, int $crop_height): GD
	{
		// do some calculations
		$crop_width		= ($this->current_dimensions['width'] < $crop_width)	? $this->current_dimensions['width']	: $crop_width;
		$crop_height	= ($this->current_dimensions['height'] < $crop_height)	? $this->current_dimensions['height']	: $crop_height;

		// ensure everything's in bounds
		if (($start_x + $crop_width) > $this->current_dimensions['width'])
		{
			$start_x = ($this->current_dimensions['width'] - $crop_width);
		}

		if (($start_y + $crop_height) > $this->current_dimensions['height'])
		{
			$start_y = ($this->current_dimensions['height'] - $crop_height);
		}

		if ($start_x < 0)
		{
			$start_x = 0;
		}

		if ($start_y < 0)
		{
			$start_y = 0;
		}

		// create the working image
		$this->working_image = imagecreatetruecolor($crop_width, $crop_height);

		$this->preserveAlpha();

		imagecopyresampled(
			$this->working_image,
			$this->old_image,
			0,
			0,
			$start_x,
			$start_y,
			$crop_width,
			$crop_height,
			$crop_width,
			$crop_height
		);

		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= $crop_width;
		$this->current_dimensions['height']	= $crop_height;

		return $this;
	}

	/**
	 * Rotates image either 90 degrees clockwise or counter-clockwise
	 */
	public function rotateImage(string $direction = 'CW'): GD
	{
		$degrees = match($direction) {
			'CW'		=> 90,
			default		=> -90,
		};

		$this->rotateImageNDegrees($degrees);

		return $this;
	}

	/**
	 * Rotates image specified number of degrees
	 */
	public function rotateImageNDegrees(int $degrees): GD
	{
		if (!function_exists('imagerotate'))
		{
			throw new RuntimeException('Your version of GD does not support image rotation');
		}

		$this->working_image = imagerotate($this->old_image, $degrees, 0);

		$this->old_image					= $this->working_image;
		$this->current_dimensions['width']	= imagesx($this->working_image);
		$this->current_dimensions['height']	= imagesy($this->working_image);

		return $this;
	}

	/**
	 * Applies a filter to the image
	 */
	public function imageFilter(int $filter, bool $arg1 = false, bool $arg2 = false, bool $arg3 = false, bool $arg4 = false): GD
	{
		if (!function_exists('imagefilter'))
		{
			throw new RuntimeException('Your version of GD does not support image filters');
		}

		if ($arg1 === false)
		{
			$result = imagefilter($this->old_image, $filter);
		}
		else if ($arg2 === false)
		{
			$result = imagefilter($this->old_image, $filter, $arg1);
		}
		else if ($arg3 === false)
		{
			$result = imagefilter($this->old_image, $filter, $arg1, $arg2);
		}
		else if ($arg4 === false)
		{
			$result = imagefilter($this->old_image, $filter, $arg1, $arg2, $arg3);
		}
		else
		{
			$result = imagefilter($this->old_image, $filter, $arg1, $arg2, $arg3, $arg4);
		}

		if (!$result)
		{
			throw new RuntimeException('GD imagefilter failed');
		}

		$this->working_image = $this->old_image;

		return $this;
	}

	/**
	 * Shows an image
	 *
	 * This function will show the current image by first sending the appropriate header
	 * for the format, and then outputting the image data. If headers have already been sent,
	 * a runtime exception will be thrown
	 *
	 * @param bool $raw_data Whether or not the raw image stream should be output
	 */
	public function show(bool $raw_data = false): GD
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
			imageinterlace($this->old_image, 1);
		}
		else if ($this->options['interlace'] === false)
		{
			imageinterlace($this->old_image, 0);
		}

		switch ($this->format) {
			case 'AVIF':
				if ($raw_data === false)
				{
					header('Content-type: image/avif');
				}
				imageavif($this->old_image);
				break;
			case 'GIF':
				if ($raw_data === false)
				{
					header('Content-type: image/gif');
				}
				imagegif($this->old_image);
				break;
			case 'JPEG':
				if ($raw_data === false)
				{
					header('Content-type: image/jpeg');
				}
				imagejpeg($this->old_image, null, $this->options['jpegQuality']);
				break;
			case 'PNG':
			case 'STRING':
				if ($raw_data === false)
				{
					header('Content-type: image/png');
				}
				imagepng($this->old_image);
				break;
			case 'WEBP':
				if ($raw_data === false)
				{
					header('Content-type: image/webp');
				}
				imagewebp($this->old_image);
				break;
		}

		return $this;
	}

	/**
	 * Returns the Working Image as a String
	 *
	 * This function is useful for getting the raw image data as a string for storage in
	 * a database, or other similar things.
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
	 * @param string		$file_name	The full path and filename of the image to save
	 * @param string|null	$format		The format to save the image in (optional, must be one of [AVIF, GIF, JPEG, JPG, PNG, WEBP]
	 */
	public function save(string $file_name, string $format = null): GD
	{
		$validFormats	= ['AVIF', 'GIF', 'JPEG', 'JPG', 'PNG', 'WEBP'];
		$format			= ($format !== null) ? strtoupper($format) : $this->format;

		if (!in_array($format, $validFormats))
		{
			throw new InvalidArgumentException('Invalid format type specified in save function: ' . $format);
		}

		// make sure the directory is writeable
		if (!is_writeable(dirname($file_name)))
		{
			// try to correct the permissions
			if ($this->options['correctPermissions'] === true)
			{
				@chmod(dirname($file_name), 0777);

				// throw an exception if not writeable
				if (!is_writeable(dirname($file_name)))
				{
					throw new RuntimeException('File is not writeable, and could not correct permissions: ' . $file_name);
				}
			}
			else
			{ // throw an exception if not writeable
				throw new RuntimeException('File not writeable: ' . $file_name);
			}
		}

		// When the interlace option equals true or false call imageinterlace else leave it to default
		if ($this->options['interlace'] === true)
		{
			imageinterlace($this->old_image, 1);
		}
		else if ($this->options['interlace'] === false)
		{
			imageinterlace($this->old_image, 0);
		}

		$save = match ($format) {
			'AVIF'			=> imageavif	($this->old_image, $file_name),
			'GIF'			=> imagegif		($this->old_image, $file_name),
			'JPEG', 'JPG'	=> imagejpeg	($this->old_image, $file_name, $this->options['jpegQuality']),
			'PNG'			=> imagepng		($this->old_image, $file_name),
			'WEBP'			=> imagewebp	($this->old_image, $file_name),
		};

		return $this;
	}

	#################################
	# ----- GETTERS / SETTERS ----- #
	#################################

	/**
	 * Sets options for all operations.
	 */
	public function setOptions(array $options = []): GD
	{
		// we've yet to init the default options, so create them here
		if (count($this->options) == 0)
		{
			$default_options = [
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
			$default_options = $this->options;
		}

		$this->options = array_merge($default_options, $options);

		return $this;
	}

	/**
	 * Returns $current_dimensions.
	 *
	 * @see GD
	 */
	public function getCurrentDimensions(): array
	{
		return $this->current_dimensions;
	}

	public function setCurrentDimensions(array $current_dimensions): GD
	{
		$this->current_dimensions = $current_dimensions;

		return $this;
	}

	public function getMaxHeight(): int
	{
		return $this->max_height;
	}

	public function setMaxHeight(int $max_height): GD
	{
		$this->max_height = $max_height;

		return $this;
	}

	public function getMaxWidth(): int
	{
		return $this->max_width;
	}

	public function setMaxWidth(int $max_width): GD
	{
		$this->max_width = $max_width;

		return $this;
	}

	/**
	 * Returns $new_dimensions.
	 *
	 * @see GD
	 */
	public function getNewDimensions(): array
	{
		return $this->new_dimensions;
	}

	/**
	 * Sets $new_dimensions.
	 *
	 * @see GD
	 */
	public function setNewDimensions(array $new_dimensions): GD
	{
		$this->new_dimensions = $new_dimensions;

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
	 * @see GD
	 */
	public function setPercent(int $percent): GD
	{
		$this->percent = $percent;

		return $this;
	}

	/**
	 * Returns $old_image.
	 *
	 * @see GD
	 */
	public function getOldImage()
	{
		return $this->old_image;
	}

	/**
	 * Sets $old_image.
	 *
	 * @see GD
	 */
	public function setOldImage(object $old_image): GD
	{
		$this->old_image = $old_image;

		return $this;
	}

	/**
	 * Returns $working_image.
	 *
	 * @see GD
	 */
	public function getWorkingImage()
	{
		return $this->working_image;
	}

	/**
	 * Sets $working_image.
	 *
	 * @see GD
	 */
	public function setWorkingImage(object $working_image): GD
	{
		$this->working_image = $working_image;

		return $this;
	}


	#################################
	# ----- UTILITY FUNCTIONS ----- #
	#################################

	/**
	 * Calculates a new width and height for the image based on $this->max_width and the provided dimensions
	 */
	protected function calcWidth(int $width, int $height): array
	{
		$new_width_percentage	= (100 * $this->max_width) / $width;
		$new_height				= ($height * $new_width_percentage) / 100;

		return [
			'new_width'		=> $this->max_width,
			'new_height'	=> intval($new_height)
		];
	}

	/**
	 * Calculates a new width and height for the image based on $this->max_height and the provided dimensions
	 */
	protected function calcHeight(int $width, int $height): array
	{
		$new_height_percentage	= (100 * $this->max_height) / $height;
		$new_width				= ($width * $new_height_percentage) / 100;

		return [
			'new_width'		=> ceil($new_width),
			'new_height'	=> ceil($this->max_height)
		];
	}

	/**
	 * Calculates a new width and height for the image based on $this->percent and the provided dimensions
	 */
	protected function calcPercent(int $width, int $height): array
	{
		$new_width	= ($width * $this->percent) / 100;
		$new_height	= ($height * $this->percent) / 100;

		return [
			'new_width'		=> ceil($new_width),
			'new_height'	=> ceil($new_height)
		];
	}

	/**
	 * Calculates the new image dimensions
	 *
	 * These calculations are based on both the provided dimensions and $this->max_width and $this->max_height
	 */
	protected function calcImageSize(int $width, int $height): void
	{
		$new_size = [
			'new_width'		=> $width,
			'new_height'	=> $height
		];

		if ($this->max_width > 0)
		{
			$new_size = $this->calcWidth($width, $height);

			if ($this->max_height > 0 && $new_size['new_height'] > $this->max_height)
			{
				$new_size = $this->calcHeight($new_size['new_width'], $new_size['new_height']);
			}
		}

		if ($this->max_height > 0)
		{
			$new_size = $this->calcHeight($width, $height);

			if ($this->max_width > 0 && $new_size['new_width'] > $this->max_width)
			{
				$new_size = $this->calcWidth($new_size['new_width'], $new_size['new_height']);
			}
		}

		$this->new_dimensions = $new_size;
	}

	/**
	 * Calculates new image dimensions, not allowing the width and height to be less than either the max width or height
	 */
	protected function calcImageSizeStrict(int $width, int $height): void
	{
		$new_dimensions = $this->getCurrentDimensions();

		// first, we need to determine what the longest resize dimension is..
		if ($this->max_width >= $this->max_height)
		{
			// and determine the longest original dimension
			if ($width > $height)
			{
				$new_dimensions = $this->calcHeight($width, $height);

				if ($new_dimensions['new_width'] < $this->max_width)
				{
					$new_dimensions = $this->calcWidth($width, $height);
				}
			}
			else if ($height >= $width)
			{
				$new_dimensions = $this->calcWidth($width, $height);

				if ($new_dimensions['new_height'] < $this->max_height)
				{
					$new_dimensions = $this->calcHeight($width, $height);
				}
			}
		}
		else if ($this->max_height > $this->max_width)
		{
			if ($width >= $height)
			{
				$new_dimensions = $this->calcWidth($width, $height);

				if ($new_dimensions['new_height'] < $this->max_height)
				{
					$new_dimensions = $this->calcHeight($width, $height);
				}
			}
			else if ($height > $width)
			{
				$new_dimensions = $this->calcHeight($width, $height);

				if ($new_dimensions['new_width'] < $this->max_width)
				{
					$new_dimensions = $this->calcWidth($width, $height);
				}
			}
		}

		$this->new_dimensions = $new_dimensions;
	}

	/**
	 * Calculates new dimensions based on $this->percent and the provided dimensions
	 */
	protected function calcImageSizePercent(int $width, int $height): void
	{
		if ($this->percent > 0)
		{
			$this->new_dimensions = $this->calcPercent($width, $height);
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
		$format_info = getimagesize($this->file_name);

		// non-image files will return false
		if ($format_info === false)
		{
			if ($this->remote_image)
			{
				throw new Exception('Could not determine format of remote image: ' . $this->file_name);
			}
			else
			{
				throw new Exception('File is not a valid image: ' . $this->file_name);
			}
		}

		$mime_type = $format_info['mime'] ?? null;

		$this->format = match ($mime_type) {
			'image/avif'	=> 'AVIF',
			'image/gif'		=> 'GIF',
			'image/jpeg'	=> 'JPEG',
			'image/png'		=> 'PNG',
			'image/webp'	=> 'WEBP',
			default			=> throw new Exception('Image format not supported: ' . $mime_type),
		};
	}

	/**
	 * Makes sure the correct GD implementation exists for the file type
	 *
	 * @throws Exception
	 */
	protected function verifyFormatCompatibility(): void
	{
		$gd_info = gd_info();

		$is_compatible = match ($this->format) {
			'AVIF'	=> $gd_info[$this->format . ' Support'],
			'GIF'	=> $gd_info['GIF Create Support'],
			'JPEG'	=> $gd_info[$this->format . ' Support'],
			'PNG'	=> $gd_info[$this->format . ' Support'],
			'WEBP'	=> $gd_info['WebP Support'],
			default	=> false,
		};

		$suffix = strtolower($this->format);

		$is_compatible =
			   function_exists('image' . $suffix)
			&& function_exists('imagecreatefrom' . $suffix)
			&& $is_compatible;

		if (!$is_compatible)
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
	 */
	protected function preserveAlpha(): void
	{
		if ($this->format == 'PNG' && $this->options['preserveAlpha'] === true)
		{
			imagealphablending($this->working_image, false);

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

		// preserve transparency in GIFs... this is usually pretty rough tho
		if ($this->format == 'GIF' && $this->options['preserveTransparency'] === true)
		{
			$color_transparent = imagecolorallocate(
				$this->working_image,
				$this->options['transparencyMaskColor'][0],
				$this->options['transparencyMaskColor'][1],
				$this->options['transparencyMaskColor'][2]
			);

			imagecolortransparent	($this->working_image, $color_transparent);
			imagetruecolortopalette	($this->working_image, true, 256);
		}
	}
}
