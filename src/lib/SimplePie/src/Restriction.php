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
 * Handles `<media:restriction>` as defined in Media RSS
 *
 * Used by {@see \SimplePie\Enclosure::get_restriction()} and {@see \SimplePie\Enclosure::get_restrictions()}
 *
 * This class can be overloaded with {@see \SimplePie\SimplePie::set_restriction_class()}
 *
 * @package SimplePie
 * @subpackage API
 */
class Restriction
{
    /**
     * Relationship ('allow'/'deny')
     *
     * @var string
     * @see get_relationship()
     */
    public $relationship;

    /**
     * Type of restriction
     *
     * @var string
     * @see get_type()
     */
    public $type;

    /**
     * Restricted values
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
    public function __construct($relationship = null, $type = null, $value = null)
    {
        $this->relationship = $relationship;
        $this->type = $type;
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
     * Get the relationship
     *
     * @return string|null Either 'allow' or 'deny'
     */
    public function get_relationship()
    {
        if ($this->relationship !== null) {
            return $this->relationship;
        }

        return null;
    }

    /**
     * Get the type
     *
     * @return string|null
     */
    public function get_type()
    {
        if ($this->type !== null) {
            return $this->type;
        }

        return null;
    }

    /**
     * Get the list of restricted things
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

class_alias('SimplePie\Restriction', 'SimplePie_Restriction');
