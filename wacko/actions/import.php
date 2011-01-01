<?php
/*
	{{import}}
	http://wackowiki.org/somecluster/import --> {{import}}, to = "Test".
	Will be imported at: http://wackowiki.org/Test/*

	i.e. no relative addressing
*/

// TODO: add a step for warning / confirmation (do you want overwrite? / Will add Import under ... [submit] [cancel])
// add better description
// finally localize all new message sets

$t = '';

if ($this->is_admin())
{
	if (!isset($_POST['_to']) || empty($_POST['_to']))
	{
		if (isset($_POST['_to']))
		{
			echo 'Pls. provide an cluster you want to import to, no relative addressing.<br /><br />';
		}
		else
		{
			echo 'Attention: overwrites the same pages in the cluster<br /><br />';
		}
		// show FORM
		echo rawurldecode($this->form_open('', '', 'post', '', ' enctype="multipart/form-data" '));
		?>
		<div class="cssform">
			<p>
				<label for="importto"><?php echo $this->get_translation('ImportTo'); ?>:</label>
				<input type="text" id="importto" name="_to" size="40" value="" />
			</p>
			<p>
				<label for="importwhat"><?php echo $this->get_translation('ImportWhat'); ?>:</label>
				<input type="file" id="importwhat" name="_import" />
			</p>
			<p>
				<input type="submit" value="<?php echo $this->get_translation('ImportButtonText'); ?>" />
			</p>
		</div>
		<?php
		echo $this->form_close();
	}
	if (!empty($_POST['_to']))
	{
		if ($_FILES['_import']['error'] == 0)
		{
			$fd = fopen($_FILES['_import']['tmp_name'], 'r');

			if (!$fd)
			{
				echo '<pre>';
				print_r($_FILES);
				print_r($_POST);
				die('</pre><br />IMPORT failed');
			}

			// check for false and empty strings
			if(($contents = fread($fd, filesize($_FILES['_import']['tmp_name']))) === '')
			{
				return false;
			}

			fclose($fd);

			$this->use_class('utility');
			$items = explode('<item>', $contents);

			array_shift($items);

			foreach ($items as $item)
			{
				$root_tag	= trim($_POST['_to'], '/ ');
				$rel_tag	= trim(Utility::untag($item, 'guid'), '/ ');
				$tag		= $root_tag.( $root_tag && $rel_tag ? '/' : '' ).$rel_tag;
				$page_id	= $this->get_page_id($tag);
				$owner		= Utility::untag($item, 'author');
				$owner_id	= $this->get_user_id_by_name($owner);
				$body		= str_replace(']]&gt;', ']]>', Utility::untag($item, 'description'));
				$title		= html_entity_decode(Utility::untag($item, 'title'));

				$body_r = $this->save_page($tag, $title, $body, '');
				$this->set_page_owner($page_id, $owner_id);
				// now we render it internally in the context of imported
				// page so we can write the updated link table
				$this->context[++$this->current_context] = $tag;
				$this->clear_link_table();
				$this->start_link_tracking();
				$dummy = $this->format($body_r, 'post_wacko');
				$this->stop_link_tracking();
				$this->write_link_table($page_id);
				$this->clear_link_table();
				$this->current_context--;

				// log import
				$this->log(4, str_replace('%1', $tag, $this->get_translation('LogPageImported', $this->config['language'])));

				// count page
				$t++;
				$pages[] = $tag;
			}

			echo '<em>'.str_replace('%1', $t, $this->get_translation('ImportSuccess')).'</em><br />';

			foreach ($pages as $page)
			{
				echo $this->link('/'.$page, '', '', '', 0).'<br />';
			}
		}
		else
		{
			echo '<pre>';
			print_r($_FILES);
			print_r($_POST);
			die('</pre><br />IMPORT failed');
		}
	}
}

?>