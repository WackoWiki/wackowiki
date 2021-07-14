<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
print page and revisions authors.
	{{authors [add="2009 Ivan Ivanov[;2010 John Smith[;...]]"] [license="CC-BY-SA"] [cluster=0]}}
	add		= semicolon-separated list of original authors (for reprinted work or such),
			  or any appropriate text. wiki-formatting applies.
			  note: every semicolon-separated block is printed on the new line
	add_only = takes only authors from add= parameter
	license	= some free-form text (wiki-formatting applies) or one of predefined constants:
				- CC-BY-ND			(CreativeCommons-Attribution-NoDerivatives)
				- CC-BY-NC-SA		(CreativeCommons-Attribution-NonCommercial-ShareAlike)
				- CC-BY-NC-ND		(CreativeCommons-Attribution-Non-Commercial No Derivatives)
				- CC-BY-SA			(CreativeCommons-Attribution-ShareAlike)
				- CC-BY-NC			(CreativeCommons-Attribution Non-Commercial)
				- CC-BY				(CreativeCommons-Attribution)
				- CC-Zero			(CreativeCommons-Zero / public domain)
				- GNU-FDL			(GNU Free Documentation License)
				- PD				(Public Domain)
				- CR				(All Rights Reserved)
	cluster	= consider all cluster subpages (if = 1) or current page only (0, default)

	https://creativecommons.org/choose/
	https://en.wikipedia.org/wiki/Creative_Commons_license
*/

// set defaults
$add		??= '';
$add_only	??= 0;
$license	??= '';
$license_id	??= null;
$cluster	??= 0;

$copysign	= '©';

// check for license_id
if (empty($license) && !isset($license_id))
{
	$license_id	= $this->db->allow_license_per_page
					? ($this->page['license_id'] ?: ($this->db->license ?? ''))
					: ($this->db->license ?? '');
}

if (!$this->page && !$add && !$license)
{
	// we don't have any input, displaying stub instead until the page is saved for the first time
	$tpl->hint = true;
}
else
{
	// process added strings, trivial
	if ($add)
	{
		// FYI: in principle, new-lines can be separated with wiki-syntax triple-dash: ---
		$add = explode(';', $add);

		foreach ($add as $i => $str)
		{
			$output[$i] = $copysign . ' ' . $this->format($this->format($str, 'wacko'), 'post_wacko');
		}
	}

	// search and process co-authors
	if ($this->page && !$add_only)
	{
		$prefix		= $this->db->table_prefix;

		// load overall authors data from revision and page table
		if ($_authors = $this->db->load_all(
		"(SELECT u.user_name AS name, YEAR(r.modified) AS year " .
		"FROM " . $prefix . "revision r " .
			"INNER JOIN " . $prefix . "user u ON (r.user_id = u.user_id) " .
		"WHERE r.tag = " . $this->db->q($this->tag) . " " .
			($cluster
				? "OR r.tag LIKE " . $this->db->q($this->tag . '/%') . " "
				: '') .
		"GROUP BY u.user_name, year ) " .
		"UNION " .
		"(SELECT u.user_name AS name, YEAR(p.modified) AS year " .
		"FROM " . $prefix . "page p " .
			"LEFT JOIN " . $prefix . "user u ON (p.user_id = u.user_id) " .
		"WHERE p.tag = " . $this->db->q($this->tag) . " " .
			($cluster
				? "OR p.tag LIKE " . $this->db->q($this->tag . '/%') . " "
				: '') .
		"GROUP BY u.user_name, year ) " .
		"ORDER BY name ASC, year ASC", true))
		{
			// rewriting results
			foreach ($_authors as $author)
			{
				// defining or modifying?
				if (!isset($authors[$author['name']]))
				{
					// new entry
					$authors[$author['name']] = [
						'name'	=> $author['name'],
						'years'	=> $author['year'],
						'total'	=> 1
					];
				}
				else
				{
					// existing entry
					// are revision years consequent?..
					if ((int)substr($authors[$author['name']]['years'], -4) === $author['year'] - 1)
					{
						// ...consequent, this will be a years range
						if (substr($authors[$author['name']]['years'], -5, 1) != '-')
						{
							// print range for the first time
							$authors[$author['name']]['years'] .= '-' . $author['year'];
						}
						else
						{
							// we already have years range, let's rewrite a second year in the range
							$authors[$author['name']]['years'] = substr($authors[$author['name']]['years'], 0, -4) . $author['year'];
						}
					}
					else
					{
						// ...not consequent, this will be a list of years instead of a range
						$authors[$author['name']]['years'] .= ', ' . $author['year'];
					}

					$authors[$author['name']]['total']++;
				}
			}

			// okey, we've got data, it's time to sort it by working years
			$sort = function($a, $b)
			{
				if ($a['total'] == $b['total'])
				{
					return ($a['name'] < $b['name'] ? -1 : 1);
				}
				else
				{
					return ($a['total'] < $b['total'] ? 1 : -1);
				}
			};

			usort($authors, $sort);
			unset($_authors, $sort);

			// writing output author strings. while we're doing so
			// let's place guest entry at the bottom of the list
			foreach ($authors as $i => $author)
			{
				if ($author['name'] != GUEST)
				{
					if (!isset($all_authors[$author['years']]))
					{
						$all_authors[$author['years']] = $copysign . ' ' . $author['years'] . ' ';
					}
					else
					{
						$all_authors[$author['years']] .= ', ';
					}

					$all_authors[$author['years']] .= $this->user_link($author['name'], true, false);
				}
				else
				{
					$guest_authors = $copysign . ' ' . $author['years'] . ' ' . $this->_t('AnonymousUsers');
					unset($authors[$i]);
				}
			}

			if (isset($guest_authors))
			{
				$all_authors[] = $guest_authors;
			}

			$output[] = implode('<br>', $all_authors);
		}
	}

	// add a license
	if ($license || $license_id)
	{
		$tpl->license_text = $this->action('license', ['license_id' => $license_id, 'license' => $license, 'icon' => 1]);
	}

	// print results
	if ($output)
	{
		$tpl->authors = implode('<br>', $output);
	}
}
