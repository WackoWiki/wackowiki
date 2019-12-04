<?php

declare(strict_types=1);

namespace PHPDiff\Diff;

/**
 * Sequence matcher for Diff
 *
 * PHP version 7.1 or greater
 *
 * @package jblond\Diff
 * @author Chris Boulton <chris.boulton@interspire.com>
 * @copyright (c) 2009 Chris Boulton
 * @license New BSD License http://www.opensource.org/licenses/bsd-license.php
 * @version 1.14
 * @link https://github.com/JBlond/php-diff
 */
class SequenceMatcher
{
    /**
     * @var string|array Either a string or an array containing a callback function to determine
     * if a line is "junk" or not.
     */
    private $junkCallback = null;

    /**
     * @var array The first sequence to compare against.
     */
    private $old = array();

    /**
     * @var array The second sequence.
     */
    private $new = array();

    /**
     * @var array Array of characters that are considered junk from the second sequence. Characters are the array key.
     */
    private $junkDict = array();

    /**
     * @var array Array of indices that do not contain junk elements.
     */
    private $b2j = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var null|array
     */
    private $opCodes;

    /**
     * @var null|array
     */
    private $matchingBlocks;

    /**
     * @var null|array
     */
    private $fullBCount;

    /**
     * @var array
     */
    private $defaultOptions = array(
        'ignoreNewLines' => false,
        'ignoreWhitespace' => false,
        'ignoreCase' => false
    );

    /**
     * The constructor. With the sequences being passed, they'll be set for the
     * sequence matcher and it will perform a basic cleanup & calculate junk
     * elements.
     *
     * @param string|array $old A string or array containing the lines to compare against.
     * @param string|array $new A string or array containing the lines to compare.
     * @param array $options
     * @param string|array|null $junkCallback Either an array or string that references a callback function
     * (if there is one) to determine 'junk' characters.
     */
    public function __construct($old, $new, array $options, $junkCallback = null)
    {
        $this->old = array();
        $this->new = array();
        $this->junkCallback = $junkCallback;
        $this->setOptions($options);
        $this->setSequences($old, $new);
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->defaultOptions, $options);
    }

    /**
     * Set the first and second sequences to use with the sequence matcher.
     *
     * @param string|array $partA A string or array containing the lines to compare against.
     * @param string|array $partB A string or array containing the lines to compare.
     */
    public function setSequences($partA, $partB)
    {
        $this->setSeq1($partA);
        $this->setSeq2($partB);
    }

    /**
     * Set the first sequence ($partA) and reset any internal caches to indicate that
     * when calling the calculation methods, we need to recalculate them.
     *
     * @param string|array $partA The sequence to set as the first sequence.
     */
    public function setSeq1($partA)
    {
        if (!is_array($partA)) {
            $partA = str_split($partA);
        }
        if ($partA == $this->old) {
            return;
        }

        $this->old = $partA;
        $this->matchingBlocks = null;
        $this->opCodes = null;
    }

    /**
     * Set the second sequence ($partB) and reset any internal caches to indicate that
     * when calling the calculation methods, we need to recalculate them.
     *
     * @param string|array $partB The sequence to set as the second sequence.
     */
    public function setSeq2($partB)
    {
        if (!is_array($partB)) {
            $partB = str_split($partB);
        }
        if ($partB == $this->new) {
            return;
        }

        $this->new = $partB;
        $this->matchingBlocks = null;
        $this->opCodes = null;
        $this->fullBCount = null;
        $this->chainB();
    }

    /**
     * Generate the internal arrays containing the list of junk and non-junk
     * characters for the second ($b) sequence.
     */
    private function chainB()
    {
        $length = count($this->new);
        $this->b2j = array();
        $popularDict = array();

        for ($i = 0; $i < $length; ++$i) {
            $char = $this->new[$i];
            if (isset($this->b2j[$char])) {
                if ($length >= 200 && count($this->b2j[$char]) * 100 > $length) {
                    $popularDict[$char] = 1;
                    unset($this->b2j[$char]);
                } else {
                    $this->b2j[$char][] = $i;
                }
            } else {
                $this->b2j[$char] = array(
                    $i
                );
            }
        }

        // Remove leftovers
        foreach (array_keys($popularDict) as $char) {
            unset($this->b2j[$char]);
        }

        $this->junkDict = array();
        if (is_callable($this->junkCallback)) {
            foreach (array_keys($popularDict) as $char) {
                if (call_user_func($this->junkCallback, $char)) {
                    $this->junkDict[$char] = 1;
                    unset($popularDict[$char]);
                }
            }

            foreach (array_keys($this->b2j) as $char) {
                if (call_user_func($this->junkCallback, $char)) {
                    $this->junkDict[$char] = 1;
                    unset($this->b2j[$char]);
                }
            }
        }
    }

    /**
     * Checks if a particular character is in the junk dictionary
     * for the list of junk characters.
     *
     * @param string $bString
     * @return bool $b True if the character is considered junk. False if not.
     */
    private function isBJunk(string $bString): bool
    {
        if (isset($this->junkDict[$bString])) {
            return true;
        }

        return false;
    }

    /**
     * Find the longest matching block in the two sequences, as defined by the
     * lower and upper constraints for each sequence. (for the first sequence,
     * $alo - $ahi and for the second sequence, $blo - $bhi)
     *
     * Essentially, of all of the maximal matching blocks, return the one that
     * starts earliest in $a, and all of those maximal matching blocks that
     * start earliest in $a, return the one that starts earliest in $b.
     *
     * If the junk callback is defined, do the above but with the restriction
     * that the junk element appears in the block. Extend it as far as possible
     * by matching only junk elements in both $a and $b.
     *
     * @param int $alo The lower constraint for the first sequence.
     * @param int $ahi The upper constraint for the first sequence.
     * @param int $blo The lower constraint for the second sequence.
     * @param int $bhi The upper constraint for the second sequence.
     * @return array Array containing the longest match that includes the starting position in $a,
     * start in $b and the length/size.
     */
    public function findLongestMatch(int $alo, int $ahi, int $blo, int $bhi): array
    {
        $old = $this->old;
        $new = $this->new;

        $bestI = $alo;
        $bestJ = $blo;
        $bestSize = 0;

        $j2Len = array();
        $nothing = array();

        for ($i = $alo; $i < $ahi; ++$i) {
            $newJ2Len = array();
            $jDict = $this->arrayGetDefault($this->b2j, $old[$i], $nothing);
            foreach ($jDict as $jKey => $j) {
                if ($j < $blo) {
                    continue;
                } elseif ($j >= $bhi) {
                    break;
                }

                $k = $this->arrayGetDefault($j2Len, $j - 1, 0) + 1;
                $newJ2Len[$j] = $k;
                if ($k > $bestSize) {
                    $bestI = $i - $k + 1;
                    $bestJ = $j - $k + 1;
                    $bestSize = $k;
                }
            }

            $j2Len = $newJ2Len;
        }

        while (
            $bestI > $alo &&
            $bestJ > $blo &&
            !$this->isBJunk($new[$bestJ - 1]) &&
            !$this->linesAreDifferent($bestI - 1, $bestJ - 1)
        ) {
                --$bestI;
                --$bestJ;
                ++$bestSize;
        }

        while (
            $bestI + $bestSize < $ahi &&
            ($bestJ + $bestSize) < $bhi &&
            !$this->isBJunk($new[$bestJ + $bestSize]) &&
            !$this->linesAreDifferent($bestI + $bestSize, $bestJ + $bestSize)
        ) {
                ++$bestSize;
        }

        while (
            $bestI > $alo &&
            $bestJ > $blo &&
            $this->isBJunk($new[$bestJ - 1]) &&
            !$this->linesAreDifferent($bestI - 1, $bestJ - 1)
        ) {
                --$bestI;
                --$bestJ;
                ++$bestSize;
        }

        while (
            $bestI + $bestSize < $ahi &&
            $bestJ + $bestSize < $bhi &&
            $this->isBJunk($new[$bestJ + $bestSize]) &&
            !$this->linesAreDifferent($bestI + $bestSize, $bestJ + $bestSize)
        ) {
                    ++$bestSize;
        }

        return array(
            $bestI,
            $bestJ,
            $bestSize
        );
    }

    /**
     * Check if the two lines at the given indexes are different or not.
     *
     * @param int $aIndex Line number to check against in a.
     * @param int $bIndex Line number to check against in b.
     * @return bool True if the lines are different and false if not.
     */
    public function linesAreDifferent(int $aIndex, int $bIndex): bool
    {
        $lineA = $this->old[$aIndex];
        $lineB = $this->new[$bIndex];

        if ($this->options['ignoreWhitespace']) {
            $replace = array("\t", ' ');
            $lineA = str_replace($replace, '', $lineA);
            $lineB = str_replace($replace, '', $lineB);
        }

        if ($this->options['ignoreCase']) {
            $lineA = strtolower($lineA);
            $lineB = strtolower($lineB);
        }

        if ($lineA != $lineB) {
            return true;
        }

        return false;
    }

    /**
     * Return a nested set of arrays for all of the matching sub-sequences
     * in the strings $a and $b.
     *
     * Each block contains the lower constraint of the block in $a, the lower
     * constraint of the block in $b and finally the number of lines that the
     * block continues for.
     *
     * @return array Nested array of the matching blocks, as described by the function.
     */
    public function getMatchingBlocks(): array
    {
        if (!empty($this->matchingBlocks)) {
            return $this->matchingBlocks;
        }

        $aLength = count($this->old);
        $bLength = count($this->new);

        $queue = array(
            array(
                0,
                $aLength,
                0,
                $bLength
            )
        );

        $matchingBlocks = array();
        while (!empty($queue)) {
            list($alo, $ahi, $blo, $bhi) = array_pop($queue);
            $longestMatch = $this->findLongestMatch($alo, $ahi, $blo, $bhi);
            list($list1, $list2, $list3) = $longestMatch;
            if ($list3) {
                $matchingBlocks[] = $longestMatch;
                if ($alo < $list1 && $blo < $list2) {
                    $queue[] = array(
                        $alo,
                        $list1,
                        $blo,
                        $list2
                    );
                }

                if ($list1 + $list3 < $ahi && $list2 + $list3 < $bhi) {
                    $queue[] = array(
                        $list1 + $list3,
                        $ahi,
                        $list2 + $list3,
                        $bhi
                    );
                }
            }
        }

        usort(
            $matchingBlocks,
            function ($aArray, $bArray) {
                return $this->tupleSort($aArray, $bArray);
            }
        );

        $i1 = 0;
        $j1 = 0;
        $k1 = 0;
        $nonAdjacent = array();
        foreach ($matchingBlocks as $block) {
            list($list4, $list5, $list6) = $block;
            if ($i1 + $k1 == $list4 && $j1 + $k1 == $list5) {
                $k1 += $list6;
            } else {
                if ($k1) {
                    $nonAdjacent[] = array(
                        $i1,
                        $j1,
                        $k1
                    );
                }

                $i1 = $list4;
                $j1 = $list5;
                $k1 = $list6;
            }
        }

        if ($k1) {
            $nonAdjacent[] = array(
                $i1,
                $j1,
                $k1
            );
        }

        $nonAdjacent[] = array(
            $aLength,
            $bLength,
            0
        );

        $this->matchingBlocks = $nonAdjacent;
        return $this->matchingBlocks;
    }

    /**
     * Return a list of all of the op codes for the differences between the
     * two strings.
     *
     * The nested array returned contains an array describing the op code
     * which includes:
     * 0 - The type of tag (as described below) for the op code.
     * 1 - The beginning line in the first sequence.
     * 2 - The end line in the first sequence.
     * 3 - The beginning line in the second sequence.
     * 4 - The end line in the second sequence.
     *
     * The different types of tags include:
     * replace - The string from $i1 to $i2 in $a should be replaced by
     *           the string in $b from $j1 to $j2.
     * delete -  The string in $a from $i1 to $j2 should be deleted.
     * insert -  The string in $b from $j1 to $j2 should be inserted at
     *           $i1 in $a.
     * equal  -  The two strings with the specified ranges are equal.
     *
     * @return array Array of the opcodes describing the differences between the strings.
     */
    public function getOpCodes(): array
    {
        if (!empty($this->opCodes)) {
            return $this->opCodes;
        }

        $i = 0;
        $j = 0;
        $this->opCodes = array();

        $blocks = $this->getMatchingBlocks();
        foreach ($blocks as $block) {
            list($ai, $bj, $size) = $block;
            $tag = '';
            if ($i < $ai && $j < $bj) {
                $tag = 'replace';
            } elseif ($i < $ai) {
                $tag = 'delete';
            } elseif ($j < $bj) {
                $tag = 'insert';
            }

            if ($tag) {
                $this->opCodes[] = array(
                    $tag,
                    $i,
                    $ai,
                    $j,
                    $bj
                );
            }

            $i = $ai + $size;
            $j = $bj + $size;

            if ($size) {
                $this->opCodes[] = array(
                    'equal',
                    $ai,
                    $i,
                    $bj,
                    $j
                );
            }
        }
        return $this->opCodes;
    }

    /**
     * Return a series of nested arrays containing different groups of generated
     * op codes for the differences between the strings with up to $context lines
     * of surrounding content.
     *
     * Essentially what happens here is any big equal blocks of strings are stripped
     * out, the smaller subsets of changes are then arranged in to their groups.
     * This means that the sequence matcher and diffs do not need to include the full
     * content of the different files but can still provide context as to where the
     * changes are.
     *
     * @param int $context The number of lines of context to provide around the groups.
     * @return array Nested array of all of the grouped op codes.
     */
    public function getGroupedOpcodes(int $context = 3): array
    {
        $opCodes = $this->getOpCodes();
        if (empty($opCodes)) {
            $opCodes = array(
                array(
                    'equal',
                    0,
                    1,
                    0,
                    1
                )
            );
        }

        if ($opCodes['0']['0'] == 'equal') {
            $opCodes['0'] = array(
                $opCodes['0']['0'],
                max($opCodes['0']['1'], $opCodes['0']['2'] - $context),
                $opCodes['0']['2'],
                max($opCodes['0']['3'], $opCodes['0']['4'] - $context),
                $opCodes['0']['4']
            );
        }

        $lastItem = count($opCodes) - 1;
        if ($opCodes[$lastItem]['0'] == 'equal') {
            list($tag, $i1, $i2, $j1, $j2) = $opCodes[$lastItem];
            $opCodes[$lastItem] = array(
                $tag,
                $i1,
                min($i2, $i1 + $context),
                $j1,
                min($j2, $j1 + $context)
            );
        }

        $maxRange = $context * 2;
        $groups = array();
        $group = array();

        foreach ($opCodes as $code) {
            list($tag, $i1, $i2, $j1, $j2) = $code;
            if ($tag == 'equal' && $i2 - $i1 > $maxRange) {
                $group[] = array(
                    $tag,
                    $i1,
                    min($i2, $i1 + $context),
                    $j1,
                    min($j2, $j1 + $context)
                );
                $groups[] = $group;
                $group = array();
                $i1 = max($i1, $i2 - $context);
                $j1 = max($j1, $j2 - $context);
            }
            $group[] = array(
                $tag,
                $i1,
                $i2,
                $j1,
                $j2
            );
        }

        if (!empty($group) && !(count($group) == 1 && $group[0][0] == 'equal')) {
            $groups[] = $group;
        }

        return $groups;
    }

    /**
     * Helper function that provides the ability to return the value for a key
     * in an array of it exists, or if it doesn't then return a default value.
     * Essentially cleaner than doing a series of if (isset()) {} else {} calls.
     *
     * @param array $array The array to search.
     * @param string|int $key The key to check that exists.
     * @param mixed $default The value to return as the default value if the key doesn't exist.
     * @return mixed The value from the array if the key exists or otherwise the default.
     */
    private function arrayGetDefault(array $array, $key, $default)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return $default;
    }

    /**
     * Sort an array by the nested arrays it contains. Helper function for getMatchingBlocks
     *
     * @param array $aArray First array to compare.
     * @param array $bArray Second array to compare.
     * @return int -1, 0 or 1, as expected by the usort function.
     */
    private function tupleSort(array $aArray, array $bArray): int
    {
        $max = max(count($aArray), count($bArray));
        for ($counter = 0; $counter < $max; ++$counter) {
            if ($aArray[$counter] < $bArray[$counter]) {
                return -1;
            } elseif ($aArray[$counter] > $bArray[$counter]) {
                return 1;
            }
        }

        if (count($aArray) == count($bArray)) {
            return 0;
        }
        if (count($aArray) < count($bArray)) {
            return -1;
        }
        return 1;
    }
}
