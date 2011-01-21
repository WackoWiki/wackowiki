<div id="page">
<h3><?php echo $this->get_translation('ClonePage') ?> <?php echo $this->compose_link_to_page($this->tag, '', '', 0) ?></h3>
<br />
<?php

$output = '';

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}
// and for forum page
else if ($this->forum === true && !$this->is_admin())
{
	$this->redirect($this->href());
}

if ($user = $this->get_user())
{
	$user = strtolower($this->get_user_name());
	$registered = true;
}
else
$user = GUEST;

$edit_note = str_replace('%1', $this->tag, $this->get_translation('ClonedFrom'));

if ($this->user_is_owner() || $this->is_admin() || $this->has_access('write', $this->page['page_id']))
{
	if (isset($_POST['newname']) && $_POST['clone'] == 1)
	{
		// clone or massclone
		$need_massclone = 0;
		if (isset($_POST['massclone']) && $_POST['massclone'] == 'on')
		{
			$need_massclone = 1;
		}

		// clone
		if ($need_massclone == 0)
		{
			// strip whitespaces
			$new_name		= preg_replace('/\s+/', '', $_POST['newname']);
			$new_name		= trim($new_name, '/');
			$supernewname	= $this->npj_translit($new_name);
			$edit_note		= isset($_POST['edit_note']) ? $_POST['edit_note'] : $edit_note;

			if (!preg_match('/^([\_\.\-'.$this->language['ALPHANUM_P'].']+)$/', $new_name))
			{
				print($this->get_translation('BadName')."<br />\n");
			}
			//     if ($this->supertag == $supernewname)
			else if ($this->tag == $new_name)
			{
				print(str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlreadyNamed'))."<br />\n");
			}
			else
			{
				if ($this->supertag != $supernewname && $page = $this->load_page($supernewname, 0, '', LOAD_CACHE, LOAD_META))
				{
					print(str_replace('%1', $this->compose_link_to_page($new_name, '', '', 0), $this->get_translation('AlredyExists'))."<br />\n");
				}
				else
				{
					if ($this->clone_page($this->tag, $new_name, $supernewname, $edit_note))
					{
						$need_redirect = '';

						// log event
						$this->log(4, str_replace('%2', $new_name, str_replace('%1', $this->tag, $this->get_translation('LogClonedPage', $this->config['language']))) );

						if (isset($_POST['redirect']) && $_POST['redirect'] == 'on')
						{
							$need_redirect = 1;
						}

						if ($need_redirect == 1)
						{
							$this->set_message($edit_note);
							$this->redirect($this->href('edit', $new_name));
						}
						else
						{
							print(str_replace('%1', $new_name, $this->get_translation('PageCloned'))."<br />\n");
						}
					}
				}
			}
		}
		//massclone
		if ($need_massclone == 1)
		{
			// TODO: clone all sheeps and optional ACLs
			print "<p><b>".$this->get_translation('MassCloning')."</b><p>";   //!!!
			#recursive_move($this, $this->tag );
		}
	}
	else
	{
		echo $this->get_translation('CloneName');
		echo $this->form_open('clone');

		?>
		<input type="hidden" name="clone" value="1" />
		<input name="newname" size="40"/><br />
		<?php
		// edit note
		if ($this->config['edit_summary'] != 0)
		{
			$output .= "<label for=\"edit_note\">".$this->get_translation('EditNote').":</label><br />";
			$output .= "<input id=\"edit_note\" maxlength=\"200\" value=\"".htmlspecialchars($edit_note)."\" size=\"60\" name=\"edit_note\"/>";

			echo $output;
		}
		?>
		<br />
		<?php echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" ";  echo " /> <label for=\"redirect\">".$this->get_translation('ClonedRedirect')."</label>"; ?>
		<br /><br />
		<input name="submit" type="submit" value="<?php echo $this->get_translation('CloneButton'); ?>" /> &nbsp;
		<input type="button" value="<?php echo str_replace("\n", " ", $this->get_translation('EditCancelButton')); ?>"
		onclick="document.location='<?php echo addslashes($this->href(''))?>';" />

		<?php
		echo $this->form_close();

	}
}
else
{
	echo "<div class=\"error\">Warning: The page handler \"clone\" is only for Wiki Admin</div>";
	echo $this->get_translation('ReadAccessDenied');
}

//$this->redirect($this->href());

?>
</div>
