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

namespace SimplePie;

/**
 * Handles the injection of Registry into other class
 *
 * {@see \SimplePie\SimplePie::get_registry()}
 *
 * @package SimplePie
 */
interface RegistryAware
{
    /**
     * Set the Registry into the class
     *
     * @param Registry $registry
     *
     * @return void
     */
    public function set_registry(Registry $registry)/* : void */;
}
