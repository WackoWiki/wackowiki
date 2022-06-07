<?php

namespace PHPThumb;

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
 * @link https://github.com/masterexploder/PHPThumb
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

abstract class PHPThumb
{
	/**
	 * The name of the file we're manipulating
	 * This must include the path to the file (absolute paths recommended)
	 *
	 * @var string
	 */
	protected string $fileName;

	/**
	 * What the file format is (mime-type)
	 *
	 * @var string
	 */
	protected string $format;

	/**
	 * Whether or not the image is hosted remotely
	 *
	 * @var bool
	 */
	protected bool $remoteImage;

	/**
	 * An array of attached plugins to execute in order.
	 * @var array
	 */
	protected array $plugins;

	/**
	 * @param $fileName
	 * @param array $options
	 * @param array $plugins
	 */
	public function __construct($fileName, array $options = [], array $plugins = [])
	{
		$this->fileName		= $fileName;
		$this->remoteImage	= false;

		if(!$this->validateRequestedResource($fileName))
		{
			throw new \InvalidArgumentException('Image file not found: ' . $fileName);
		}

		$this->setOptions($options);

		$this->plugins = $plugins;
	}

	abstract public function setOptions(array $options = []);

	/**
	 * Check the provided filename/url. If it is an url, validate that it is properly
	 * formatted. If it is a file, check to make sure that it actually exists on
	 * the filesystem.
	 *
	 * @param $filename
	 * @return bool
	 */
	protected function validateRequestedResource($filename): bool
	{
		if (false !== filter_var($filename, FILTER_VALIDATE_URL))
		{
			$this->remoteImage = true;
			return true;
		}

		if (file_exists($filename))
		{
			return true;
		}

		return false;
	}

	/**
	 * Returns the filename.
	 * @return string
	 */
	public function getFileName(): string
	{
		return $this->fileName;
	}

	/**
	 * Sets the filename.
	 * @param $fileName
	 * @return PHPThumb
	 */
	public function setFileName($fileName): PHPThumb
	{
		$this->fileName = $fileName;

		return $this;
	}

	/**
	 * Returns the format.
	 * @return string
	 */
	public function getFormat(): string
	{
		return $this->format;
	}

	/**
	 * Sets the format.
	 * @param $format
	 * @return PHPThumb
	 */
	public function setFormat($format): PHPThumb
	{
		$this->format = $format;

		return $this;
	}

	/**
	 * Returns whether the image exists remotely, i.e. it was loaded via a URL.
	 * @return bool
	 */
	public function getIsRemoteImage(): bool
	{
		return $this->remoteImage;
	}
}
