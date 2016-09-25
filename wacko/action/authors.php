<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
print page and revisions' authors.
	{{authors [add="(c) 2009 Ivan Ivanov[;(c) 2010 John Smith[;...]]"] [license="CC-BY-NC-SA"] [cluster=0]}}
	add		= semicolon-separated list of original authors (for reprinted work or such),
			  or any appropriate text. wiki-formatting applies.
			  note: every semicolon-separated block is printed on the new line
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
	cluster	= consider all cluster subpages (if = 1) or current page only (0, default)

	https://creativecommons.org/choose/
	https://en.wikipedia.org/wiki/Creative_Commons_license
	https://licensebuttons.net/
*/

if (!isset($add)) $add = '';
if (!isset($license)) $license = (isset($this->db->license) ? $this->db->license : '');
if (!isset($cluster)) $cluster = '';

echo '<small>';

if (!$this->page && !$add && !$license)
{
	// we don't have any input, displaying stub instead until the page is saved for the first time
	echo '<em>'.$this->_t('AuthorsDisplayHint').'</em>';
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
			$add[$i] = $this->format($this->format($str, 'wacko'), 'post_wacko');
		}

		$output[] = implode('<br />', $add);
	}

	// search and process co-authors
	if ($this->page)
	{
		// load overall authors data from revision and page table
		if ($_authors = $this->db->load_all(
		"(SELECT u.user_name AS name, YEAR(r.modified) AS year ".
		"FROM {$this->db->table_prefix}revision r ".
			"INNER JOIN ".$this->db->table_prefix."user u ON (r.user_id = u.user_id) ".
		"WHERE r.supertag = ".$this->db->q($this->supertag)." ".($cluster ? "OR r.supertag LIKE " . $this->db->q($this->supertag . '/%') . " " : '').
		"GROUP BY u.user_name, year ) ".
		"UNION ".
		"( SELECT u.user_name AS name, YEAR(p.modified) AS year ".
		"FROM {$this->db->table_prefix}page p ".
			"LEFT JOIN ".$this->db->table_prefix."user u ON (p.user_id = u.user_id) ".
		"WHERE p.supertag = ".$this->db->q($this->supertag)." ".($cluster ? "OR p.supertag LIKE " . $this->db->q($this->supertag . '/%') . " " : '').
		"GROUP BY u.user_name, year ) ".
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
							'name' => $author['name'],
							'years' => $author['year'],
							'total' => 1
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
							$authors[$author['name']]['years'] .= '-'.$author['year'];
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
						$authors[$author['name']]['years'] .= ', '.$author['year'];
					}

					$authors[$author['name']]['total']++;
				}
			}

			// okey, we've got data, it's time to sort it by working years
			$sort = create_function(
				'$a, $b',	// func params
				'if ($a["total"] == $b["total"]) '.
					'return ( $a["name"] < $b["name"] ? -1 : 1 ); '.
				'else '.
					'return ( $a["total"] < $b["total"] ? 1 : -1 );');

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
						$all_authors[$author['years']] = "&copy; {$author['years']} ";
					}
					else
					{
						$all_authors[$author['years']] .= ', ';
					}

					$all_authors[$author['years']] .= $this->user_link($author['name'], '', true, false);
				}
				else
				{
					$guest_authors = '&copy; '.$author['years'].' '.$this->_t('AnonymousUsers');
					unset($authors[$i]);
				}
			}

			if (isset($guest_authors))
			{
				$all_authors[] = $guest_authors;
			}

			$output[] = implode('<br />', $all_authors);
		}
	}

	if ($license)
	{
		// license names and links to texts
		$licenses = [
			'CC-BY-ND'		=> ['https://creativecommons.org/licenses/by-nd/4.0/',		$this->_t('License')['CC-BY-ND']],
			'CC-BY-NC-SA'	=> ['https://creativecommons.org/licenses/by-nc-sa/4.0/',	$this->_t('License')['CC-BY-NC-SA']],
			'CC-BY-NC-ND'	=> ['https://creativecommons.org/licenses/by-nc-nd/4.0/',	$this->_t('License')['CC-BY-NC-ND']],
			'CC-BY-SA'		=> ['https://creativecommons.org/licenses/by-sa/4.0/',		$this->_t('License')['CC-BY-SA']],
			'CC-BY-NC'		=> ['https://creativecommons.org/licenses/by-nc/4.0/',		$this->_t('License')['CC-BY-NC']],
			'CC-BY'			=> ['https://creativecommons.org/licenses/by/4.0/',			$this->_t('License')['CC-BY']],
			'CC-ZERO'		=> ['https://creativecommons.org/publicdomain/zero/1.0/',	$this->_t('License')['CC-ZERO']],
			'GNU-FDL'		=> ['https://www.gnu.org/licenses/fdl.html',				$this->_t('License')['GNU-FDL']],
			'PD'			=> ['https://creativecommons.org/publicdomain/mark/1.0/',	$this->_t('License')['PD']],
		];

		if (isset($licenses[$license]))
		{
			$icons = '<img src="'.$this->db->base_url.'image/spacer.png" alt="'.$licenses[$license][1].'" title="'.$licenses[$license][1].'" class="license-'.$license.'">';
			// constant license
			$license = '<br />'.$this->_t('DistributedUnder').'<br />'.

			// TODO: rel="license"
			$this->link($licenses[$license][0], '', $licenses[$license][1]).'<br />'.
			'<a rel="license" href="'.$licenses[$license][0].'">'.$icons.'</a>';
		}
		else
		{
			// free-form text
			$license = $this->format($this->format($license, 'wacko'), 'post_wacko');
		}

		$output[] = $license;
	}

	// print results
	if ($output)
	{
		echo implode('<br />', $output);
	}
}

echo '</small>';

?>
