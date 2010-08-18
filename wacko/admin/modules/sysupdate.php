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
			if ($pages = $engine->load_all("SELECT tag FROM {$engine->config['table_prefix']}acl LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					#$engine->query(
					#	"UPDATE {$engine->config['table_prefix']}acl ".
					#	"SET supertag = '".$engine->npj_translit($page['tag'])."' ".
					#	"WHERE tag = '".$page['tag']."'");
				}
				$engine->redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="1"><s>Transliterate field `supertag` in table `acl`</s>.</li>
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
			if ($pages = $engine->load_all("SELECT to_tag FROM {$engine->config['table_prefix']}link LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->query(
						"UPDATE {$engine->config['table_prefix']}link ".
						"SET to_supertag = '".$engine->npj_translit($page['to_tag'])."' ".
						"WHERE to_tag = '".$page['to_tag']."'");
				}
				$engine->redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="2"><s>Transliterate field `to_supertag` in table `link`</s>.</li>
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
			if ($pages = $engine->load_all("SELECT page_id, tag FROM {$engine->config['table_prefix']}page LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->query(
						"UPDATE {$engine->config['table_prefix']}page SET ".
							"supertag = '".$engine->npj_translit($page['tag'])."' ".
						"WHERE page_id = ".$page['page_id']);
				}
				$engine->redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="3"><s>Transliterate field `supertag` and `super_comment_on` in table `page`</s>.</li>
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
			if ($pages = $engine->load_all("SELECT revision_id, tag FROM {$engine->config['table_prefix']}revision LIMIT ".($i*$limit).", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->query(
						"UPDATE {$engine->config['table_prefix']}revision ".
						"SET supertag = '".$engine->npj_translit($page['tag'])."' ".
						"WHERE revision_id = ".$page['revision_id']);
				}
				$engine->redirect('/admin.php?mode='.$module['mode'].'&start=1&step='.$_REQUEST['step'].'&i='.(++$i));
			}
			else
			{
?>
				<ol>
					<li value="4"><s>Transliterate field `supertag` and `super_comment_on` in table `revision`</s>.</li>
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
						rename($dir.'/'.$file, $dir.'/'.$engine->npj_translit($file));
					}
				}
				closedir($dh);
			}

			$version = '4.3.rc2';

			$engine->query(
				"UPDATE {$engine->config['table_prefix']}config ".
				"SET wackowiki_version = '$version'");
			$engine->log(1, 'Upgrading to version WackoWiki '.$version);
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
			<li>Transliterate field `to_supertag` in table `link`.</li>
			<li>Transliterate field `supertag` in table `page`.</li>
			<li>Transliterate field `supertag` in table `revision`.</li>
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