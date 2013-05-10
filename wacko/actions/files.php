<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Showing uploaded by {{upload}} files

	{{files
		[page="PageName" or global=1]
		[order="time|FILENAME|size|size_desc|ext"]
		[owner="UserName"]
		[picture=1]
		[max=number]
	}}
 */

$page_id = '';

if (!isset($nomark))	$nomark = '';
if (!isset($order))		$order = '';
if (!isset($global))	$global = '';
if (!isset($tag))		$tag = ''; // FIXME: $tag == $page
if (!isset($owner))		$owner = '';
if (!isset($page))		$page = '';
if (!isset($legend))	$legend = '';
if (!isset($picture))	$picture = null;
if (!isset($max))		$max = '';

if ($max)
{
	$limit = $max;
}
else
{
	$limit	= 50;
}

$order_by = "file_name ASC";
if ($order == 'time')		$order_by = "uploaded_dt DESC";
if ($order == 'size')		$order_by = "file_size ASC";
if ($order == 'size_desc')	$order_by = "file_size DESC";
if ($order == 'ext')		$order_by = "file_ext ASC";

// do we allowed to see?
if (!$global)
{
	if ($page == '')
	{
		$page		= $this->tag;
		$page_id	= $this->page['page_id'];
	}
	else
	{
		$page	= $this->unwrap_link($page);
		$ppage	= '/'.$page;

		if ($_page_id = $this->get_page_id($page))
		{
			$page_id	= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->user_is_owner($page_id);
	$can_delete	= $this->is_admin() || $this->user_is_owner($page_id);
}
else
{
	$can_view	= 1;
	$page		= $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $page))
	{
		$filepage = $this->page;
	}
	else
	{
		$filepage = $this->load_page($page);
	}

	if (!$global && !isset($filepage['page_id']))
	{
		return;
	}

	$count = $this->load_all(
		"SELECT f.upload_id ".
		"FROM ".$this->config['table_prefix']."upload f ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
		"WHERE f.page_id = '". ($global ? 0 : $filepage['page_id'])."' ".
			($owner
				? "AND u.user_name = '".quote($this->dblink, $owner)."' "
				: ''), 1);

	$count		= count($count);
	$pagination = $this->pagination($count, $limit, 'f');

	// load files list
	$files = $this->load_all(
		"SELECT f.upload_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.lang, f.file_name, f.file_description, f.uploaded_dt, u.user_name AS user, f.hits ".
		"FROM ".$this->config['table_prefix']."upload f ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
		"WHERE f.page_id = '". ($global ? 0 : $filepage['page_id'])."' ".
			($owner
				? "AND u.user_name = '".quote($this->dblink, $owner)."' "
				: '')." ".
		"ORDER BY f.".$order_by." ".
		"LIMIT {$pagination['offset']}, {$limit}");

	if (!is_array($files))
	{
		$files = array();
	}

	// display
	$del	= $this->get_translation('UploadRemove');
	$edit	= $this->get_translation('UploadEdit');

	if (!$global)
	{
		$path = '@'.$filepage['page_id'].'@';
	}
	else
	{
		$path = '';
	}

	if (!$global)
	{
		$path2 = 'file:/'.($this->slim_url($page)).'/';
	}
	else
	{
		$path2 = 'file:';
	}

	// !!!!! patch link not to show pictures when not needed
	if ($picture == false)
	{
		$path2 = str_replace('file:', '_file:', $path2);
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo "<span class=\"pagination\">{$pagination['text']}</span><br />\n";
	}

	if (!$nomark)
	{
		$title = $this->get_translation('UploadTitle'.($global ? 'Global' : '') ).' '.($page ? $this->link($ppage, '', $legend) : '');
		echo '<div class="layout-box"><p class="layout-box"><span>'.$title.": </span></p>\n";
	}

	if (count($files))
	{
		echo '<table class="upload" >';
	}

	foreach($files as $file)
	{
		$this->files_cache[$file['page_id']][$file['file_name']] = &$file;

		$dt			= $file['uploaded_dt'];
		$desc		= $this->format($file['file_description'], 'typografica' );

		if ($this->page['lang'] != $file['lang'])
		{
			$desc	= $this->do_unicode_entities($desc, $file['lang']);
		}

		if ($desc == '')
		{
			$desc = "&nbsp;";
		}

		$file_id	= $file['upload_id'];
		$file_name	= $file['file_name'];
		$text		= ($picture == false) ? $file_name : '';
		$file_size	= $this->binary_multiples($file['file_size'], false, true, true);
		$file_ext	= substr($file_name, strrpos($file_name, ".") + 1);
		$link		= $this->link($path2.$file_name, '', $text);

		if ($file_ext != 'gif' && $file_ext != 'jpg' && $file_ext != 'png')
		{
			$hits	= ", ".$file['hits']." ".( $file['hits'] === 1 ? 'hit' : 'hits' );
		}
		else
		{
			$hits	= '';
		}

		if ($this->is_admin() || (!isset($is_global) &&
		($this->get_page_owner_id($page_id) == $this->get_user_id())) ||
		($file['user_id'] == $this->get_user_id()))
		{
			$remove_mode = 1;
		}
		else
		{
			$remove_mode = 0;
		}

		$remove_href	= $this->href('upload', $page, 'remove='.($global ? 'global' : 'local')."&amp;file_id=".$file_id);
		$edit_href		= $this->href('upload', $page, 'edit='.($global ? 'global' : 'local')."&amp;file_id=".$file_id);
?>
		<tr>
			<td class="dt-"><span class="dt2-"><?php echo $this->get_time_string_formatted($dt) ?></span>&nbsp;</td>
<?php
		if ($remove_mode)
		{
			echo '<td class="remove-"><a href="'.$edit_href.'" class="remove2-">'.$edit.'</a>&nbsp;</td>';
			echo '<td class="remove-"><a href="'.$remove_href.'" class="remove2-">'.$del.'</a>&nbsp;</td>';
		}
		else
		{
			echo '<td class="remove-">&nbsp;</td>';
		}
?>
		<td class="size-"><span class="size2-">(<?php echo $file_size; ?>)</span>&nbsp;</td>
		<td class="file-"><?php echo $link; ?></td>
		<td class="desc-"><?php echo $desc; ?></td>
	</tr>
<?php
		unset($link);
		unset($desc);
		#unset($text);
	}

	if (count($files))
	{
		echo '</table>';
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
	}
}
else
{
	echo '<em>'.$this->get_translation('ActionDenied').'</em>';
}

?>