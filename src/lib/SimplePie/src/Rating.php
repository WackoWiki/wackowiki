<?php

/**

 * @package SimplePie
 * @copyright 2004-2016 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace SimplePie;

/**
 * Handles `<media:rating>` or `<itunes:explicit>` tags as defined in Media RSS and iTunes RSS respectively
 *
 * Used by {@see \SimplePie\Enclosure::get_rating()} and {@see \SimplePie\Enclosure::get_ratings()}
 *
 * This class can be overloaded with {@see \SimplePie\SimplePie::set_rating_class()}
 *
 * @package SimplePie
 * @subpackage API
 */
class Rating
{
    /**
     * Rating scheme
     *
     * @var string
     * @see get_scheme()
     */
    public $scheme;

    /**
     * Rating value
     *
     * @var string
     * @see get_value()
     */
    public $value;

    /**
     * Constructor, used to input the data
     *
     * For documentation on all the parameters, see the corresponding
     * properties and their accessors
     */
    public function __construct($scheme = null, $value = null)
    {
        $this->scheme = $scheme;
        $this->value = $value;
    }

    /**
     * String-ified version
     *
     * @return string
     */
    public function __toString()
    {
        // There is no $this->data here
        return md5(serialize($this));
    }

    /**
     * Get the organizational scheme for the rating
     *
     * @return string|null
     */
    public function get_scheme()
    {
        if ($this->scheme !== null) {
            return $this->scheme;
        }

        return null;
    }

    /**
     * Get the value of the rating
     *
     * @return string|null
     */
    public function get_value()
    {
        if ($this->value !== null) {
            return $this->value;
        }

        return null;
    }
}

class_alias('SimplePie\Rating', 'SimplePie_Rating');
