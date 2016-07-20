<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<h3>';
echo $this->get_translation('ClonePage') . ' ' . $this->compose_link_to_page($this->tag, '', '', 0);
echo "</h3>\n<br />\n";

// ensure that's not forum or comment
$this->ensure_page();

if (!$this->has_access('read'))
{
	$this->set_message($this->get_translation('ReadAccessDenied'), 'error');
	$this->show_must_go_on();
}

$from		= $this->tag;
$superfrom	= $this->supertag;
$edit_note	= Ut::perc_replace($this->get_translation('ClonedFrom'), $this->tag);


if (@$_POST['_action'] === 'clone_page')
{
	$to = $_POST['clone_name'];

	if (($error = $this->sanitize_new_pagename($to, $superto, $from)))
	{
		$this->set_message($error, 'error');
		$this->reload_me();
	}

	if (isset($_POST['edit_note']))
	{
		$edit_note = $_POST['edit_note'];
	}

	$jump = $to;

	if (!isset($_POST['massclone']))
	{
		$this->clone_page($from, $to, $superto, $edit_note);

		$this->log(4, Ut::perc_replace($this->get_translation('LogClonedPage', SYSTEM_LANG), $from, $to));

		$this->set_message(Ut::perc_replace($this->get_translation('PageCloned'), $this->link('/'.$to)), 'info');
	}
	else
	{
		//massclone
		echo '<p><strong>' . $this->get_translation('MassCloning') . '</strong><p>';

		$pages = $this->load_all(
			"SELECT page_id, tag, supertag ".
			"FROM {$this->db->table_prefix}page ".
			"WHERE (supertag LIKE ".$this->db->q($superfrom . '/%')." ".
				"OR tag LIKE ".$this->db->q($from . '/%')." ".
				"OR tag = ".$this->db->q($from)." ".
				"OR supertag = ".$this->db->q($superfrom).") ".
				"AND comment_on_id = '0'");

		$slashes = (int) @count_chars($from, 1)['/']; // @ to return 0 when no slashes used
		$work = [];
		foreach ($pages as $page)
		{
			// rebase page to cloned root
			$src = $page['tag'];
			for ($pos = 0, $i = $slashes; ($pos = strpos($src, '/', $pos)) !== false && $i--; ++$pos);
			$dst = $to . ($pos? substr($src, $pos) : '');

			if ($this->load_page($dst, 0, '', LOAD_CACHE, LOAD_META))
			{
				$alredys[] = Ut::perc_replace($this->get_translation('AlredyExists'), $this->compose_link_to_page($dst, '', '', 0));
			}
			else if (!$this->has_access('read', $page['page_id']))
			{
				$this->set_message(
					Ut::perc_replace($this->get_translation('CloneCannotRead'), $this->compose_link_to_page($src, '', '', 0)),
					'error');
				if ($dst === $to)
				{
					$jump = '';
				}
				continue;
			}
			else if (!$this->has_access('create', '', '', 1, $dst))
			{
				$alredys[] = Ut::perc_replace($this->get_translation('CloneCannotCreate'), $this->compose_link_to_page($dst, '', '', 0));
			}

			$work[$src] = $dst;
		}

		if (isset($alredys))
		{
			$error = implode("</li>\n<li>", $alredys);
			$this->set_message('<ol><li>' . $error . '</li></ol>', 'error');
			$this->reload_me();
		}

		foreach ($work as $src => $dst)
		{
			$this->clone_page($src, $dst, '', $edit_note);
			$this->log(4, Ut::perc_replace($this->get_translation('LogClonedPage', SYSTEM_LANG), $src, $dst));
			$log[] = Ut::perc_replace($this->get_translation('PageCloned'), $this->link('/'.$dst));
		}

		if (isset($log))
		{
			echo "$to: <br />\n";

			$log = implode("</li>\n<li>", $log);
			$this->set_message('<ol><li>' . $log . '</li></ol>', 'info');
		}
	}

	// jump to new clone
	$this->redirect($this->href('', $jump));
}

if ($this->check_acl($this->get_user_name(), $this->config['rename_globalacl']))
{
	$klusterwerks = $this->load_single(
		"SELECT COUNT(*) AS n ".
		"FROM {$this->db->table_prefix}page ".
		"WHERE (supertag LIKE ".$this->db->q($superfrom . '/%')." ".
			"OR tag LIKE ".$this->db->q($from . '/%').") ".
			"AND comment_on_id = '0'");

	$do_cluster = (int)$klusterwerks['n'];
}
else
{
	$do_cluster = false;
}

echo $this->get_translation('CloneName');

echo $this->form_open('clone_page', ['page_method' => 'clone']);

?>
<input type="text" name="clone_name" size="40" maxlength="250"/>
<?php
// edit note
if ($this->config['edit_summary'])
{
	echo '<br />';
	echo '<label for="edit_note">'.$this->get_translation('EditNote').':</label><br />'."\n";
	echo '<input type="text" id="edit_note" maxlength="200" value="'.htmlspecialchars($edit_note, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" size="60" name="edit_note"/>'."\n";
}
?>
<br /><br />
<?php
if ($do_cluster)
{
	echo '<input type="checkbox" id="massclone" name="massclone" />'."\n";
	echo ' <label for="massclone">'.$this->get_translation('MassClone').'</label>'."\n";
}
?>
<br /><br />
<input type="submit" name="submit" value="<?php echo $this->get_translation('CloneButton'); ?>" /> &nbsp;
<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" value="<?php echo str_replace("\n", " ", $this->get_translation('EditCancelButton')); ?>"/></a>

<?php

echo $this->form_close();

