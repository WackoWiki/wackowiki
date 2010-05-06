<?php

########################################################
##   DB Update                                        ##
########################################################

$module['sysupdate'] = array(
		'order'	=> 10,
		'cat'	=> 'Database',
		'mode'	=> 'sysupdate',
		'name'	=> 'Update',
		'title'	=> 'Update the structure and contents of the database',
	);

########################################################

function admin_sysupdate(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	if (isset($_REQUEST['start']))
	{
		$limit = 1500;

		if (isset($_REQUEST['i'])) $i = $_REQUEST['i'];
		else $i = 0;

		// acls
		if ((int)$_REQUEST['step'] === 1)
		{
			if ($pages = $engine->LoadAll("SELECT tag FROM {$engine->config['table_prefix']}acls LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					#$engine->Query(
					#	"UPDATE {$engine->config['table_prefix']}acls ".
					#	"SET supertag = '".$engine->NpjTranslit($page['tag'])."' ".
					#	"WHERE tag = '".$page['tag']."'");
				}
				$engine->Redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="1"><s>Transliterate field `supertag` in table `acls`</s>.</li>
				</ol>
				<br />
				<form action="admin.php" method="post" name="sysupdate">
					<input type="hidden" name="mode" value="sysupdate" />
					<input type="hidden" name="step" value="2" />
					<input name="start" id="submit" type="submit" value="continue" />
				</form>
<?php
			}
		}
		// links
		else if ((int)$_REQUEST['step'] === 2)
		{
			if ($pages = $engine->LoadAll("SELECT to_tag FROM {$engine->config['table_prefix']}links LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->Query(
						"UPDATE {$engine->config['table_prefix']}links ".
						"SET to_supertag = '".$engine->NpjTranslit($page['to_tag'])."' ".
						"WHERE to_tag = '".$page['to_tag']."'");
				}
				$engine->Redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="2"><s>Transliterate field `to_supertag` in table `links`</s>.</li>
				</ol>
				<br />
				<form action="admin.php" method="post" name="sysupdate">
					<input type="hidden" name="mode" value="sysupdate" />
					<input type="hidden" name="step" value="3" />
					<input name="start" id="submit" type="submit" value="continue" />
				</form>
<?php
			}
		}
		// pages
		else if ((int)$_REQUEST['step'] === 3)
		{
			if ($pages = $engine->LoadAll("SELECT page_id, tag FROM {$engine->config['table_prefix']}pages LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->Query(
						"UPDATE {$engine->config['table_prefix']}pages SET ".
							"supertag = '".$engine->NpjTranslit($page['tag'])."' ".
						"WHERE page_id = ".$page['page_id']);
				}
				$engine->Redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="3"><s>Transliterate field `supertag` and `super_comment_on` in table `pages`</s>.</li>
				</ol>
				<br />
				<form action="admin.php" method="post" name="sysupdate">
					<input type="hidden" name="mode" value="sysupdate" />
					<input type="hidden" name="step" value="4" />
					<input name="start" id="submit" type="submit" value="continue" />
				</form>
<?php
			}
		}
		// revisions
		else if ((int)$_REQUEST['step'] === 4)
		{
			if ($pages = $engine->LoadAll("SELECT revision_id, tag FROM {$engine->config['table_prefix']}revisions LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->Query(
						"UPDATE {$engine->config['table_prefix']}revisions ".
						"SET supertag = '".$engine->NpjTranslit($page['tag'])."' ".
						"WHERE revision_id = ".$page['revision_id']);
				}
				$engine->Redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="4"><s>Transliterate field `supertag` and `super_comment_on` in table `revisions`</s>.</li>
				</ol>
				<br />
				<form action="admin.php" method="post" name="sysupdate">
					<input type="hidden" name="mode" value="sysupdate" />
					<input type="hidden" name="step" value="5" />
					<input name="start" id="submit" type="submit" value="continue" />
				</form>
<?php
			}
		}
		// files
		else if ((int)$_REQUEST['step'] === 5)
		{
			$dir = $engine->config['upload_path_per_page'];
			if ($dh = opendir($dir))
			{
				while (false !== ($file = readdir($dh)))
				{
					if (is_dir($dir.'/'.$file) !== true && $file != '.htaccess')
					{
						chmod($dir.'/'.$file, 0755);
						rename($dir.'/'.$file, $dir.'/'.$engine->NpjTranslit($file));
					}
				}
				closedir($dh);
			}

			$version = '4.3.rc2';

			$engine->Query(
				"UPDATE {$engine->config['table_prefix']}config ".
				"SET wackowiki_version = '$version'");
			$engine->Log(1, 'Upgrading to version WackoWiki '.$version);
?>
			<ol>
				<li value="5"><s>Transliterate the names of attached files</s>.</li>
			</ol>
			<br />
			<p>
				The procedure for renewal is completed.
			</p>
<?php
		}
	}
	else
	{
?>
		<ol>
			<li>empty</li>
			<li>Transliterate field `to_supertag` in table `links`.</li>
			<li>Transliterate field `supertag` in table `pages`.</li>
			<li>Transliterate field `supertag` in table `revisions`.</li>
			<li>Transliterate the names of attached files.</li>
		</ol>
		<br />
		<form action="admin.php" method="post" name="sysupdate">
			<input type="hidden" name="mode" value="sysupdate" />
			<input type="hidden" name="step" value="1" />
			<input name="start" id="submit" type="submit" value="Start" />
		</form>
<?php
	}
}

?>