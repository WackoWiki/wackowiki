<?php
/**

 * @package SimplePie
 * @copyright 2004-2022 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace SimplePie\Cache;

/**
 * Interface for creating a cache filename
 *
 * @package SimplePie
 * @subpackage Caching
 */
interface NameFilter
{
    /**
     * Method to create cache filename with.
     *
     * The returning name MUST follow the rules for keys in PSR-16.
     *
     * @link https://www.php-fig.org/psr/psr-16/
     *
     * The returning name MUST be a string of at least one character
     * that uniquely identifies a cached item, MUST only contain the
     * characters A-Z, a-z, 0-9, _, and . in any order in UTF-8 encoding
     * and MUST not longer then 64 characters. The following characters
     * are reserved for future extensions and MUST NOT be used: {}()/\@:
     *
     * A provided implementing library MAY support additional characters
     * and encodings or longer lengths, but MUST support at least that
     * minimum.
     *
     * @param string $name The name for the cache will be most likly an url with query string
     *
     * @return string the new cache name
     */
    public function filter(string $name): string;
}
