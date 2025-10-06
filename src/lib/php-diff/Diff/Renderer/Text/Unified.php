<?php

declare(strict_types=1);

namespace PHPDiff\Diff\Renderer\Text;

use PHPDiff\Diff\Renderer\MainRendererAbstract;

/**
 * Unified diff generator for PHP DiffLib.
 *
 * PHP version 7.3 or greater
 *
 * @package         jblond\Diff\Renderer\Text
 * @author          Chris Boulton <chris.boulton@interspire.com>
 * @author          Mario Brandt <leet31337@web.de>
 * @copyright   (c) 2020 Mario Brandt
 * @license         New BSD License http://www.opensource.org/licenses/bsd-license.php
 * @version         2.4.0
 * @link            https://github.com/JBlond/php-diff
 */

/**
 * Class Diff_Renderer_Text_Unified
 */
class Unified extends MainRendererAbstract
{
    /**
     * Render and return a unified diff.
     *
     * @return string|false The generated diff-view or false when there's no difference.
     */
    public function render()
    {
        $diff    = false;
        $opCodes = $this->diff->getGroupedOpCodes();
        foreach ($opCodes as $key => $group) {
            if ($key % 2) {
                // Skip lines which are Out Of Context.
                continue;
            }
            $lastItem = array_key_last($group);
            $iGroup1       = $group[0][1];
            $iGroup2       = $group[$lastItem][2];
            $jGroup1       = $group[0][3];
            $jGroup2       = $group[$lastItem][4];

            if ($iGroup1 == 0 && $iGroup2 == 0) {
                $iGroup1 = -1;
                $iGroup2 = -1;
            }

            $diff .= '@@ -' . ($iGroup1 + 1) . ',' . ($iGroup2 - $iGroup1) . ' +' . ($jGroup1 + 1)
                . ',' . ($jGroup2 - $jGroup1) . " @@\n";
            foreach ($group as [$tag, $iGroup1, $iGroup2, $jGroup1, $jGroup2]) {
                if ($tag == 'equal') {
                    $diff .= ' ' .
                        implode(
                            "\n ",
                            $this->diff->getArrayRange($this->diff->getVersion1(), $iGroup1, $iGroup2)
                        ) . "\n";
                    continue;
                }
                if ($tag == 'replace' || $tag == 'delete') {
                    $diff .= '-' .
                        implode(
                            "\n-",
                            $this->diff->getArrayRange($this->diff->getVersion1(), $iGroup1, $iGroup2)
                        ) . "\n";
                }
                if ($tag == 'replace' || $tag == 'insert') {
                    $diff .= '+' .
                        implode(
                            "\n+",
                            $this->diff->getArrayRange($this->diff->getVersion2(), $jGroup1, $jGroup2)
                        ) . "\n";
                }
            }
        }

        return $diff;
    }
}
