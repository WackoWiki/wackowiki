<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Upgrade helper routines.

Usage:
	{{adminupdate}}
EOD;

// set defaults
$help		??= 0;

if ($help)
{
	echo $this->help($info, 'adminupdate');
	return;
}

$prefix			= $this->prefix;
$collation		= 'utf8mb4_unicode_520_ci';



echo '<h2>Upgrade Utilities</h2>';

$sys_info[] = ['WackoWiki version', $this->format('**!!(green)' . $this->db->wacko_version . '!!**', 'wacko')];
$sys_info[] = ['Database charset', $this->db->db_charset];
$sys_info[] = ['Database collation', $this->db->db_collation];

echo '<table style="max-width:800px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation lined">' . "\n";

foreach ($sys_info as $value)
{
	echo '<tr>' .
			'<td class="label"><strong>' . $value[0] . '</strong></td>' .
			'<td> </td>' .
			'<td>' . $value[1] . '</td>' . "\n";
}

echo '</table>' . "\n";

if ($this->is_admin())
{
	echo '<h3>Routines for R6.x</h3>';

	########################################################
	##            Set missing ACL sets                    ##
	########################################################

	echo '<h4>1. Set missing ACL permissions</h4>';

	if (!isset($_POST['set_missing_permissions']))
	{
		echo $this->form_open('set_missing_permissions');
		echo '<button type="submit" name="set_missing_permissions">' .  $this->_t('UpdateButton') . '</button>';
		echo $this->form_close();
	}
	else if (isset($_POST['set_missing_permissions']))
	{
		$pages = $this->db->load_all(
			"SELECT
				p.page_id, p.tag, COUNT(*) AS n
			FROM
				{$prefix}page p
				LEFT JOIN {$prefix}acl a ON (p.page_id = a.page_id)
			GROUP BY p.page_id, p.tag
			HAVING COUNT(p.page_id) < 5
			ORDER BY p.page_id ASC");

		if (!empty($pages))
		{
			echo '<table>
					<tr>
						<th>page_id</th>
						<th>tag</th>
						<th>sets</th>
					</tr>' . "\n";

			foreach ($pages as $page)
			{
				$acl	= [];
				// load acls
				$acl['read']	= $this->load_acl($page['page_id'], 'read',		1, 0);
				$acl['write']	= $this->load_acl($page['page_id'], 'write',	1, 0);
				$acl['comment']	= $this->load_acl($page['page_id'], 'comment',	1, 0);
				$acl['create']	= $this->load_acl($page['page_id'], 'create',	1, 0);
				$acl['upload']	= $this->load_acl($page['page_id'], 'upload',	1, 0);

				// saving acls
				$this->save_acl($page['page_id'], 'read',		$acl['read']['list']);
				$this->save_acl($page['page_id'], 'write',		$acl['write']['list']);
				$this->save_acl($page['page_id'], 'comment',	$acl['comment']['list']);
				$this->save_acl($page['page_id'], 'create',		$acl['create']['list']);
				$this->save_acl($page['page_id'], 'upload',		$acl['upload']['list']);

				echo '<tr>
						<td>' . $page['page_id'] . '</td>
						<td>' . $page['tag'] . '</td>
						<td>' . $page['n'] . '</td>
					</tr>
					<tr>
						<td>create: ' . $acl['create']['list'] . '</td>
						<td>upload: ' . $acl['upload']['list'] . '</td>
						<td>' . $page['n'] . '</td>
					</tr>' . "\n";
			}

			echo '</table>';
			echo '<br>Missing permissions set.';
		}
		else
		{
			echo 'No pages with missing permissions found.';
		}
	}

	########################################################
	##            Set missing MIME type for files         ##
	########################################################

	echo '<h4>2. Set missing MIME type for legacy records in file table</h4>';

	/* The MIME type was added with R5.5 to the file table
	 *
	 * This only affects wikis that were already in use before R5.5.
	 * This mainly serves the purpose that these MIME types are available for filtering in the files action.
	 */

	// load files list
	$files = $this->db->load_all(
		'SELECT file_id, page_id, user_id, file_size, file_ext, file_name ' .
		'FROM ' . $prefix . 'file ' .
		"WHERE mime_type = '' " .
		'ORDER BY file_name ASC ');

	if ($files)
	{
		echo '<table class="usertable">' . "\n" .
				'<tr class="userrow">
					<th>file_id</th>
					<th>file_name</th>
					<th>file_path</th>
					<th>page_id</th>
					<th>created</th>
					<th>file_ext</th>
					<th>mime_type</th>
				</tr>' . "\n";

		foreach ($files as $file)
		{
			$file_path = Ut::join_path(
					($file['page_id']? UPLOAD_LOCAL_DIR : UPLOAD_GLOBAL_DIR),
					($file['page_id']
						? '@' . $file['page_id'] . '@'
						: '') .
					$file['file_name']);

			$mime_type = mime_content_type($file_path);

			if (isset($_POST['set_mime_type']))
			{
				// update database with MIME type
				$this->db->sql_query(
					'UPDATE ' . $prefix . 'file SET ' .
						'mime_type	= ' . $this->db->q($mime_type) . ' ' .
					'WHERE file_id = ' . (int) $file['file_id']);
			}
			else
			{
				echo
					'<tr class="userrow">
						<td>' . $file['file_id'] .	'</td>
						<td>' . $file['file_name'] . '</td>
						<td>' . $file_path . '</td>
						<td>' . $file['page_id'] . '</td>
						<td>' . $file['file_ext'] . '</td>
						<td>' . $mime_type . '</td>
					</tr>' . "\n";
			}
		}

		echo '</table>' . "\n";

		if (!isset($_POST['set_mime_type']))
		{
			echo $this->form_open('set_mime_type');
			echo '<button type="submit" name="set_mime_type">' . $this->_t('UpdateButton') . '</button>' . "\n";
			echo $this->form_close();
		}
	}
	else
	{
		echo 'All good. No records with missing MIME type found.';
	}

	########################################################
	##            Set missing file hash type for files    ##
	########################################################

	echo '<h4>3. Set missing file hash for legacy records in file table</h4>';

	/* The file hash was added with R6.1 to the file table
	 *
	 * This only affects wikis that were already in use before R6.1.19
	 * This mainly serves the purpose to find dublicates of files.
	 */

	// load files list
	$files = $this->db->load_all(
		'SELECT file_id, page_id, user_id, file_name ' .
		'FROM ' . $prefix . 'file ' .
		"WHERE file_hash = '' " .
		'ORDER BY file_name ASC ');

	if ($files)
	{
		echo '<table class="usertable">' . "\n" .
				'<tr class="userrow">
					<th>file_id</th>
					<th>file_name</th>
					<th>page_id</th>
				</tr>' . "\n";

		foreach ($files as $file)
		{
			if (isset($_POST['set_file_hash']))
			{
				$file_path = Ut::join_path(
					($file['page_id']? UPLOAD_LOCAL_DIR : UPLOAD_GLOBAL_DIR),
					($file['page_id']
						? '@' . $file['page_id'] . '@'
						: '') .
					$file['file_name']);

				$file_hash = sha1_file($file_path);

				// update database with the new file hash
				$this->db->sql_query(
					'UPDATE ' . $prefix . 'file SET ' .
						'file_hash	= ' . $this->db->q($file_hash) . ' ' .
					'WHERE file_id = ' . (int) $file['file_id']);
			}
			else
			{
				echo
					'<tr class="userrow">
						<td>' . $file['file_id'] .	'</td>
						<td>' . $file['file_name'] . '</td>
						<td>' . $file['page_id'] . '</td>
					</tr>' . "\n";
			}
		}

		echo '</table>' . "\n";

		if (!isset($_POST['set_file_hash']))
		{
			echo $this->form_open('set_file_hash');
			echo '<button type="submit" name="set_file_hash">' . $this->_t('UpdateButton') . '</button>' . "\n";
			echo $this->form_close();
		}
	}
	else
	{
		echo 'All good. No records with missing file hash found.';
	}

	########################################################
	##   Set missing virtual page_fts table for SQLite    ##
	########################################################
	if ($this->db->is_sqlite)
	{
		echo '<h4>4. Create missing virtual table page_fts for SQLite</h4>';

		/* For converted MySQL database with missing fts5 virtal table
		 *
		 * This is required to use the SQLite full text search using the FTS5 extension.
		 */

		// load files list
		$fts5 = $this->db->load_single(
			"SELECT name " .
			"FROM sqlite_master " .
			"WHERE type='table' " .
			"AND name='{$prefix}page_fts'");

		if (!is_array($fts5))
		{
			if (isset($_POST['set_page_fts']))
			{
				$query = <<<STR
					CREATE VIRTUAL TABLE IF NOT EXISTS "{$prefix}page_fts" USING fts5(
						title,
						body,
						content='{$prefix}page',
						content_rowid='page_id'
				);
				STR;

				$this->db->sql_query($query);
			}

			if (!isset($_POST['set_page_fts']))
			{
				echo $this->form_open('set_page_fts');
				echo '<button type="submit" name="set_page_fts">' . $this->_t('CreateButton') . '</button>' . "\n";
				echo $this->form_close();
			}
		}
		else
		{
			echo 'All good. SQLite virtuale table ' . $prefix . 'page_fts already exist.';
		}
	}
}

