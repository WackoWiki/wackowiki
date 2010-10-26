<?php
/*
print document and revisions' authors.
	{{authors [add="(c) 2009 Ivan Ivanov[;(c) 2010 John Smith[;...]]"] [license="CC-BY-NC-SA"] [cluster=0]}}
	add		= semicolon-separated list of original authors (for reprinted work or such),
			  or any appropriate text. wiki-formatting applies.
			  note: every semicolon-separated block is printed on the new line
	license	= some free-form text (wiki-formatting applies) or one of predefined constants:
				- CC-BY-ND         (CreativeCommons-Attribution-NoDerivatives)
				- CC-BY-NC-SA      (CreativeCommons-Attribution-NonCommercial-ShareAlike)
				- CC-BY-NC-ND      (CreativeCommons-Attribution-Non-Commercial No Derivatives)
				- CC-BY-SA         (CreativeCommons-Attribution-ShareAlike)
				- CC-BY-NC         (CreativeCommons-Attribution Non-Commercial)
				- CC-BY            (CreativeCommons-Attribution)
				- GNU-FDL          (GNU Free Documentation License)
				- PD               (Public Domain)
	cluster	= consider all cluster subpages (if = 1) or current page only (0, default)
*/

if (!isset($add)) $add = '';
if (!isset($license)) $license = (isset($this->config['license']) ? $this->config['license'] : '');
if (!isset($cluster)) $cluster = '';

echo '<small>';

if (!$this->page && !$add && !$license)
{
	// we don't have any input, displaying stub instead until the page is saved for the first time
	echo '<em>(The list of authors will be displayed when saving a document.)</em>'; // ru: —писок авторов будет отображен при сохранении документа.
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
		if ($_authors = $this->load_all(
		"( SELECT u.user_name AS name, YEAR(r.modified) AS year ".
		"FROM {$this->config['table_prefix']}revision r ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (r.user_id = u.user_id) ".
		"WHERE r.supertag = '".quote($this->dblink, $this->supertag)."' ".( $cluster ? "OR r.supertag LIKE '".quote($this->dblink, $this->supertag)."/%' " : '' ).
		"GROUP BY u.user_name, year ) ".
		"UNION ".
		"( SELECT u.user_name AS name, YEAR(p.modified) AS year ".
		"FROM {$this->config['table_prefix']}page p ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
		"WHERE p.supertag = '".quote($this->dblink, $this->supertag)."' ".( $cluster ? "OR p.supertag LIKE '".quote($this->dblink, $this->supertag)."/%' " : '' ).
		"GROUP BY u.user_name, year ) ".
		"ORDER BY name ASC, year ASC", 1))
		{
			// rewriting results
			foreach ($_authors as $author)
			{
				// defining or modifying?
				if (!isset($authors[$author['name']]))
				{
					// new entry
					$authors[$author['name']] = array('name' => $author['name'], 'years' => $author['year'], 'total' => 1);
				}
				else
				{
					// existing entry
					// are revision years consequent?..
					if ((int)substr($authors[$author['name']]['years'], -4) === $author['year']-1)
					{
						// ...consequent, this will be a years range
						if (substr($authors[$author['name']]['years'], -5, 1) != '-')
							// print range for the first time
							$authors[$author['name']]['years'] .= '-'.$author['year'];
						else
							// we already have years range, let's rewrite a second year in the range
							$authors[$author['name']]['years'] = substr($authors[$author['name']]['years'], 0, -4).$author['year'];
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
					$all_authors[$author['years']] .= '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$author['name']).'">'.$author['name'].'</a>';
				}
				else
				{
					$guest_authors = '&copy; '.$author['years'].' Anonymous users'; // ru: јнонимные пользователи
					unset($authors[$i]);
				}
			}

			if (isset($guest_authors)) $all_authors[] = $guest_authors;
			$output[] = implode('<br />', $all_authors);
		}
	}

	if ($license)
	{
		// license names and links to texts
		$licenses = array(
			'CC-BY-ND'		=> array('http://creativecommons.org/licenses/by-nd/3.0/',		'CreativeCommons-Attribution-NoDerivatives'),
			'CC-BY-NC-SA'	=> array('http://creativecommons.org/licenses/by-nc-sa/3.0/',	'CreativeCommons-Attribution-NonCommercial-ShareAlike'),
			'CC-BY-NC-ND'	=> array('http://creativecommons.org/licenses/by-nc-nd/3.0/',	'CreativeCommons-Attribution-Non-Commercial No Derivatives'),
			'CC-BY-SA'		=> array('http://creativecommons.org/licenses/by-sa/3.0/',		'CreativeCommons-Attribution-ShareAlike'),
			'CC-BY-NC'		=> array('http://creativecommons.org/licenses/by-nc/3.0/',		'CreativeCommons-Attribution-Non-Commercial'),
			'CC-BY'		=> array('http://creativecommons.org/licenses/by/3.0/',		'Creative Commons Attribution License'),
			'GNU-FDL'		=> array('http://www.gnu.org/licenses/fdl.html',				'GNU Free Documentation License'),
			'PD'			=> array('http://creativecommons.org/publicdomain/mark/1.0/',			'Public Domain / Free Use'),
		);

		if (isset($licenses[$license]))
		{
			// constant license
			$license = '<br />Material is distributed under<br />'. // ru]: ћатериал распростран€етс€ на услови€х
				$this->link($licenses[$license][0], '', $licenses[$license][1]).'<br />'.
				$this->link('file:'.strtolower(str_replace('-', '_', $license)).'.png', '', $licenses[$license][1]);
		}
		else
		{
			// free-form text
			$license = $this->format($this->format($license, 'wacko'), 'post_wacko');
		}

		$output[] = $license;
	}

	// print results
	if ($output) echo implode('<br />', $output);
}

echo '</small>';

?>