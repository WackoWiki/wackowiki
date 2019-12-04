<?php

declare(strict_types=1);

namespace PHPDiff\Diff\Renderer\Html;

use PHPDiff\Diff\Renderer\RendererAbstract;

/**
 * Base renderer for rendering HTML based diffs for PHP DiffLib.
 *
 * PHP version 7.1 or greater
 *
 * @package jblond\Diff\Renderer\Html
 * @author Chris Boulton <chris.boulton@interspire.com>
 * @copyright (c) 2009 Chris Boulton
 * @license New BSD License http://www.opensource.org/licenses/bsd-license.php
 * @version 1.14
 * @link https://github.com/JBlond/php-diff
 */
class HtmlArray extends RendererAbstract
{
    /**
     * @var array Array of the default options that apply to this renderer.
     */
    protected $defaultOptions = array(
        'tabSize' => 4,
        'title_a' => 'Old Version',
        'title_b' => 'New Version',
    );

    /**
     * @param string|array $changes
     * @param SideBySide|Inline $object
     * @return string
     */
    public function renderHtml($changes, $object)
    {
        $html = '';
        if (empty($changes)) {
            return $html;
        }

        $html .= $object->generateTableHeader();

        foreach ($changes as $i => $blocks) {
            // If this is a separate block, we're condensing code so output ...,
            // indicating a significant portion of the code has been collapsed as
            // it is the same

            foreach ($blocks as $change) {
                $html .= '<tbody class="Change' . ucfirst($change['tag']) . '">';
                switch ($change['tag']) {
                    // Equal changes should be shown on both sides of the diff
                    case 'equal':
                        $html .= $object->generateTableRowsEqual($change);
                        break;
                    // Added lines only on the right side
                    case 'insert':
                        $html .= $object->generateTableRowsInsert($change);
                        break;
                    // Show deleted lines only on the left side
                    case 'delete':
                        $html .= $object->generateTableRowsDelete($change);
                        break;
                    // Show modified lines on both sides
                    case 'replace':
                        $html .= $object->generateTableRowsReplace($change);
                        break;
                }
                $html .= '</tbody>';
            }
        }
        $html .= '</table>';
        return $html;
    }
    /**
     * Render and return an array structure suitable for generating HTML
     * based differences. Generally called by subclasses that generate a
     * HTML based diff and return an array of the changes to show in the diff.
     *
     * @return array|string An array of the generated changes, suitable for presentation in HTML.
     */
    public function render()
    {
        // As we'll be modifying old & new to include our change markers,
        // we need to get the contents and store them here. That way
        // we're not going to destroy the original data
        $old = $this->diff->getOld();
        $new = $this->diff->getNew();

        $changes = array();
        $opCodes = $this->diff->getGroupedOpcodes();
        foreach ($opCodes as $group) {
            $blocks = array();
            $lastTag = null;
            $lastBlock = 0;
            foreach ($group as $code) {
                list($tag, $i1, $i2, $j1, $j2) = $code;

                if ($tag == 'replace' && $i2 - $i1 == $j2 - $j1) {
                    for ($i = 0; $i < ($i2 - $i1); ++$i) {
                        $fromLine = $old[$i1 + $i];
                        $toLine = $new[$j1 + $i];

                        list($start, $end) = $this->getChangeExtent($fromLine, $toLine);
                        if ($start != 0 || $end != 0) {
                            $realEnd = mb_strlen($fromLine) + $end;

                            $fromLine = mb_substr($fromLine, 0, $start) . "\0" .
                                mb_substr($fromLine, $start, $realEnd - $start) . "\1" . mb_substr($fromLine, $realEnd);

                            $realEnd = mb_strlen($toLine) + $end;

                            $toLine = mb_substr($toLine, 0, $start) .
                                "\0" . mb_substr($toLine, $start, $realEnd - $start) . "\1" .
                                mb_substr($toLine, $realEnd);

                            $old[$i1 + $i] = $fromLine;
                            $new[$j1 + $i] = $toLine;
                        }
                    }
                }

                if ($tag != $lastTag) {
                    $blocks[] = $this->getDefaultArray($tag, $i1, $j1);
                    $lastBlock = count($blocks) - 1;
                }

                $lastTag = $tag;

                if ($tag == 'equal') {
                    $lines = array_slice($old, $i1, ($i2 - $i1));
                    $blocks[$lastBlock]['base']['lines'] += $this->formatLines($lines);
                    $lines = array_slice($new, $j1, ($j2 - $j1));
                    $blocks[$lastBlock]['changed']['lines'] +=  $this->formatLines($lines);
                } else {
                    if ($tag == 'replace' || $tag == 'delete') {
                        $lines = array_slice($old, $i1, ($i2 - $i1));
                        $lines = $this->formatLines($lines);
                        $lines = str_replace(array("\0", "\1"), array('<del>', '</del>'), $lines);
                        $blocks[$lastBlock]['base']['lines'] += $lines;
                    }

                    if ($tag == 'replace' || $tag == 'insert') {
                        $lines = array_slice($new, $j1, ($j2 - $j1));
                        $lines =  $this->formatLines($lines);
                        $lines = str_replace(array("\0", "\1"), array('<ins>', '</ins>'), $lines);
                        $blocks[$lastBlock]['changed']['lines'] += $lines;
                    }
                }
            }
            $changes[] = $blocks;
        }
        return $changes;
    }

    /**
     * Given two strings, determine where the changes in the two strings
     * begin, and where the changes in the two strings end.
     *
     * @param string $fromLine The first string.
     * @param string $toLine The second string.
     * @return array Array containing the starting position (0 by default) and the ending position (-1 by default)
     */
    private function getChangeExtent(string $fromLine, string $toLine)
    {
        $start = 0;
        $limit = min(mb_strlen($fromLine), mb_strlen($toLine));
        while ($start < $limit && mb_substr($fromLine, $start, 1) == mb_substr($toLine, $start, 1)) {
            ++$start;
        }
        $end = -1;
        $limit = $limit - $start;
        while (-$end <= $limit && mb_substr($fromLine, $end, 1) == mb_substr($toLine, $end, 1)) {
            --$end;
        }
        return array(
            $start,
            $end + 1
        );
    }

    /**
     * Format a series of lines suitable for output in a HTML rendered diff.
     * This involves replacing tab characters with spaces, making the HTML safe
     * for output, ensuring that double spaces are replaced with &#xA0; etc.
     *
     * @param array $lines Array of lines to format.
     * @return array Array of the formatted lines.
     */
    protected function formatLines(array $lines): array
    {
        if ($this->options['tabSize'] !== false) {
            $lines = array_map(
                function ($item) {
                    return $this->expandTabs($item);
                },
                $lines
            );
        }
        $lines = array_map(
            function ($item) {
                return $this->htmlSafe($item);
            },
            $lines
        );
        foreach ($lines as &$line) {
            $line = preg_replace_callback('# ( +)|^ #', array($this, 'fixSpaces'), $line);
        }
        return $lines;
    }

    /**
     * Replace a string containing spaces with a HTML representation using &#xA0;.
     *
     * @param array $matches The string of spaces.
     * @return string The HTML representation of the string.
     */
    protected function fixSpaces(array $matches): string
    {
        $buffer = '';
        $count = 0;
        foreach ($matches as $spaces) {
            $count = strlen($spaces);
            if ($count == 0) {
                continue;
            }
            $div = (int) ($count / 2);
            $mod = $count % 2;
            $buffer .= str_repeat('&#xA0; ', $div) . str_repeat('&#xA0;', $mod);
        }

        $div = (int) ($count / 2);
        $mod = $count % 2;
        return str_repeat('&#xA0; ', $div) . str_repeat('&#xA0;', $mod);
    }

    /**
     * Replace tabs in a single line with a number of spaces as defined by the tabSize option.
     *
     * @param string $line The containing tabs to convert.
     * @return string The line with the tabs converted to spaces.
     */
    private function expandTabs(string $line): string
    {
        $tabSize    = $this->options['tabSize'];
        while (($pos = strpos($line, "\t")) !== false) {
            $left   = substr($line, 0, $pos);
            $right  = substr($line, $pos + 1);
            $length = $tabSize - ($pos % $tabSize);
            $spaces = str_repeat(' ', $length);
            $line   = $left . $spaces . $right;
        }
        return $line;
    }

    /**
     * Make a string containing HTML safe for output on a page.
     *
     * @param string $string The string.
     * @return string The string with the HTML characters replaced by entities.
     */
    private function htmlSafe(string $string): string
    {
        return htmlspecialchars($string, ENT_NOQUOTES, 'UTF-8');
    }

    /**
     * @param string $tag
     * @param integer $i1
     * @param integer $j1
     * @return array
     */
    private function getDefaultArray(string $tag, int $i1, int $j1): array
    {
        return array
        (
            'tag' => $tag,
            'base' => array(
                'offset' => $i1,
                'lines' => array()
            ),
            'changed' => array(
                'offset' => $j1,
                'lines' => array()
            )
        );
    }
}
