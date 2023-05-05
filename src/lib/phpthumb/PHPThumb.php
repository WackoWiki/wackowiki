<?php

namespace PHPThumb;

use InvalidArgumentException;

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

abstract class PHPThumb
{
	/**
	 * The name of the file we're manipulating
	 * This must include the path to the file (absolute paths recommended)
	 */
	protected string $file_name;

	/**
	 * What the file format is (mime-type)
	 */
	protected string $format;

	/**
	 * Whether or not the image is hosted remotely
	 */
	protected bool $remote_image;

	/**
	 * An array of attached plugins to execute in order.
	 */
	protected array $plugins;

	public function __construct(string $file_name, array $options = [], array $plugins = [])
	{
		$this->file_name	= $file_name;
		$this->remote_image	= false;

		if(!$this->validateRequestedResource($file_name))
		{
			throw new InvalidArgumentException('Image file not found: ' . $file_name);
		}

		$this->setOptions($options);

		$this->plugins = $plugins;
	}

	abstract public function setOptions(array $options = []);

	/**
	 * Check the provided filename/url. If it is an url, validate that it is properly
	 * formatted. If it is a file, check to make sure that it actually exists on
	 * the filesystem.
	 */
	protected function validateRequestedResource(string $filename): bool
	{
		if (false !== filter_var($filename, FILTER_VALIDATE_URL))
		{
			$this->remote_image = true;
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
	 */
	public function getFileName(): string
	{
		return $this->file_name;
	}

	/**
	 * Sets the filename.
	 */
	public function setFileName(string $file_name): PHPThumb
	{
		$this->file_name = $file_name;

		return $this;
	}

	/**
	 * Returns the format.
	 */
	public function getFormat(): string
	{
		return $this->format;
	}

	/**
	 * Sets the format.
	 */
	public function setFormat(string $format): PHPThumb
	{
		$this->format = $format;

		return $this;
	}

	/**
	 * Returns whether the image exists remotely, i.e. it was loaded via a URL.
	 */
	public function getIsRemoteImage(): bool
	{
		return $this->remote_image;
	}
}
