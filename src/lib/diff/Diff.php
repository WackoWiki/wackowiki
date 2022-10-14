<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Diff.php

 Copyright (C) 1992 Free Software Foundation, Inc. Francois Pinard <pinard@iro.umontreal.ca>.
 Copyright (C) 2000, 2001 Geoffrey T. Dairiki <dairiki@dairiki.org>
 Copyright 2002,2003,2004  David DELON
 Copyright 2002  Patrick PAUL
 Copyright 2003  Eric FELDSTEIN

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */


/** difflib
 *
 * Based on PHP diff engine for phpwiki.
 *
 * Copyright (C) 2000, 2001 Geoffrey T. Dairiki <dairiki@dairiki.org>
 * You may copy this code freely under the conditions of the GPL.
 */

/**
 * Class representing a 'diff' between two sequences of strings.
 */
class Diff2
{
	public $edits;

	/**
	 * Constructor.
	 * Computes diff between sequences of strings.
	 *
	 * @param array $from_lines array An array of strings.
	 *        (Typically these are lines from a file.)
	 * @param array $to_lines array An array of strings.
	 */
	function __construct($from_lines, $to_lines)
	{
		$eng = new DiffEngine;
		$this->edits = $eng->diff($from_lines, $to_lines);
	}

}
