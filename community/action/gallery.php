<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* gallery action:
 * https://wackowiki.org/doc/Dev/PatchesHacks/Gallery
 * modify the script for your needs, please conribute your improvements
 *
 * requires PHP Thumb Library <https://github.com/masterexploder/PHPThumb>
 * optional jQuery <https://jquery.com/>
 * optional fancyBox <http://fancyapps.com/fancybox/3/>
 *
 * {{gallery

	Shows image gallery

	[page		= "page_tag"] - call image from another page
	[global		= 0|1] - call global images
	[perrow		= <Number of images per rows> (default = 3)]
	[caption	= 1|2] - 1 show file description, 2 show file caption
	[title		= "Gallery"] - album title
	[target		= 1|2] - show large images without page (if = 2 in new browser window)
	[nomark		= 1] - hide external border
	[table		= 1] - pictures in table

	[order		= "time|name_desc|size|size_desc|ext"]
	[owner		= "UserName"]
	[max		= number]
}}

TODO: config settings
	- image_processing (boolean)
	- thumbnails (boolean)

	- split local and global tumbs -> read access
	- add filter for categories cat="one,two"
	- remove thumbs with file or page
	- fall back if no JS or Image manipulation library is available or disabled
*/

// include PHP Thumbnailer
require_once 'lib/phpthumb/PHPThumb.php';
require_once 'lib/phpthumb/GD.php';

// add jQuery library
$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/jquery-3.6.0.min.js" defer></script>');
// add fancyBox
$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/fancybox/jquery.fancybox.min.js" defer></script>');
$this->add_html('header', '<link rel="stylesheet" media="screen" href="' . $this->db->base_path . 'js/fancybox/jquery.fancybox.min.css">');

// Loading parameters
$file_id		= (int) ($_GET['file_id'] ?? null);
$files			= [];
$thumb_prefix	= 'tn_';
$imgclass		= '';
$width			= $this->db->img_max_thumb_width; // default: 150

if (!isset($page))		$page		= '';
if (!isset($title))		$nomark		= 1;
if (!isset($target))	$target		= 0;
if (!isset($table))		$table		= 1;
if (!isset($caption))	$caption	= 1;
if (!isset($nomark))	$nomark		= 0;

if (!isset($order))		$order		= '';
if (!isset($global))	$global		= 0;
if (!isset($owner))		$owner		= '';
if (!isset($max))		$max		= '';

if ($max)
{
	$limit = $max;
}
else
{
	$limit	= 50;
}

if (!isset($perrow))
{
	$images_row = 5;
}
else
{
	$images_row = $perrow;
}

// we using a parameter token here to sort out multiple instances
$param_token = substr(hash('sha1', $global . $page . $caption . $target . $owner . $order . $max), 0, 8);

$nav_offset		= (int) ($_GET[$param_token] ?? '');

							$order_by = "file_name ASC";
if ($order == 'ext')		$order_by = "file_ext ASC";
if ($order == 'name_desc')	$order_by = "file_name DESC";
if ($order == 'size')		$order_by = "file_size ASC";
if ($order == 'size_desc')	$order_by = "file_size DESC";
if ($order == 'time')		$order_by = "uploaded_dt DESC";

// do we allowed to see?
if (!$global)
{
	if ($page == '')
	{
		$tag				= $this->tag;
		$source_page_tag	= $this->tag;
		$page_id			= $this->page['page_id'];
	}
	else
	{
		$tag				= $this->unwrap_link($page);
		$source_page_tag	= $tag;

		if ($_page_id = $this->get_page_id($tag))
		{
			$page_id		= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
}
else
{
	$can_view			= 1;
	$tag				= $this->tag;
	$source_page_tag	= '/';
}

if ($can_view)
{
	if ($global || ($tag == $this->tag))
	{
		$file_page = $this->page;
	}
	else
	{
		$file_page = $this->load_page($tag);
	}

	if (!$global && !isset($file_page['page_id']))
	{
		return;
	}

	$selector =
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
		"WHERE f.page_id = '" . (int) ($global ? 0 : $file_page['page_id']) . "' " .
			"AND f.picture_w <> 0 " .
			"AND f.deleted <> 1 " .
		($owner
			? "AND u.user_name = " . $this->db->q($owner) . " "
			: '');

	// load only image files -> AND f.picture_w <> 0
	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, $param_token);

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.caption, f.uploaded_dt, u.user_name AS user, p.tag " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		"LIMIT {$pagination['offset']}, {$limit}", true);

	// Making an gallery
	$cur = 0;

	if (!$nomark)
	{
		$tpl->mark			= true;
		$tpl->mark_title	= $title;
		$tpl->emark			= true;
	}

	if (!isset($_GET['file_id']) || (isset($_GET['token']) && $_GET['token'] != $param_token))
	{
		if (!empty($files))
		{
			// pagination
			$tpl->pagination_text = $pagination['text'];

			if ($table)
			{
				$tpl->table		= true;
				$tpl->etable	= true;
			}
			else
			{
				$tpl->div		= true;
				$tpl->ediv		= true;
			}

			$tpl->enter('items_');

			foreach ($files as $file)
			{
				$this->files_cache[$file['page_id']][$file['file_name']] = $file;

				$file_name			= $file['file_name'];
				$file_width			= ''; // $file['picture_w'];
				$file_height		= ''; // $file['picture_h'];
				$prefix_global		= '';
				$tnb_name			= $thumb_prefix . $file['file_id'] . '.' . $file['file_ext'];

				if ($caption == 1)
				{
					$file_description	= $file['file_description'];
				}
				else if ($caption == 2)
				{
					$file_description	= $file['caption'];
				}

				$file_description	= $this->format($file_description, 'typografica' );

				// check for upload location: global / per page
				if ($file['page_id'] == '0')
				{
					$tnb_path		= Ut::join_path(THUMB_DIR, $prefix_global . '@' . $tnb_name);
					$url			= $this->db->base_path . Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
				}
				else
				{
					$tnb_path		= Ut::join_path(THUMB_DIR, '@' . $file_page['page_id'] . '@' . $tnb_name);
					$url			= $this->href('file', $source_page_tag, ['get' => $file_name]);
				}

				$tpl->img	= '<img src="' . $this->db->base_path . $tnb_path . '" ' .
					'loading="lazy" ' .
					($file['file_description'] ? 'alt="' . $file_description . '" title="' . $file_description . '"' : '') .
					' width="' . $file_width . '" height="' . $file_height . '" ' .
					($imgclass ? 'class="' . $imgclass . '"' : '') . '>';

				if (!file_exists($tnb_path))
				{
					if ($file['page_id'] == 0)
					{
						$src_image		= Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
						$thumb_name		= Ut::join_path(THUMB_DIR, $prefix_global . '@' . $tnb_name);
					}
					else
					{
						$src_image		= Ut::join_path(UPLOAD_PER_PAGE_DIR, '@' . $file_page['page_id'] . '@' . $file_name);
						$thumb_name		= Ut::join_path(THUMB_DIR, '@' . $file_page['page_id'] . '@' . $tnb_name);
					}

					if (file_exists($src_image))
					{
						// check for missing source image, we can't trust db record
						if (!file_exists($thumb_name) && file_exists($src_image))
						{
							// create tumbnail
							@set_time_limit(0);
							@ignore_user_abort(true);

							try
							{
								$thumb = new PHPThumb\GD($src_image);
							}
							catch (Exception $e)
							{
								// handle error here however you'd like
							}

							if (is_object($thumb))
							{
								$thumb->resize($width, $width);

								// requires correct write permissions!
								$thumb->save($thumb_name);
							}
						}
					}

					// IDEA: adding an additional field like 'tumbnail' in the 'file' table for tracking,
					// there might be many derived tumbs from the original image
				}

				if ($table)
				{
					if ($cur == 0)
					{
						$tpl->row	= '<tr>';
					}

					$tpl->table = true;
				}

				if (!$target)
				{
					$tpl->href	= $this->href('', $this->tag, ['file_id' => $file['file_id'], $param_token  => $nav_offset, 'token' => $param_token, '#' => $param_token]);
				}
				else
				{
					// show file via JS with data-attributes
					$tpl->href			= $url;

					if ($target == 2)
					{
						$tpl->description	= $file_description;
						$tpl->alt			= $file_description;
						$tpl->datafancybox	= ' data-fancybox="' . $param_token . '"';
						$tpl->datacaption	= ' data-caption="' . $file_description . '"';
					}
				}

				// figcaption
				if ($caption)
				{
					$tpl->enter('caption_');

					$tpl->description	= $file_description;
					#$tpl->user			= $file['user'];
					#$tpl->dimension	= $file['picture_w'] . 'x' . $file['picture_h'];

					$tpl->leave();
				}

				$cur = ($cur + 1) % $images_row;

				if ($cur == 0)
				{
					$tpl->next	= ($table ? '</tr>' : '<br>');
				}
			}

			$tpl->leave();	// items
		}
	}
	else
	{
		// selected image
		$key		= array_search($file_id, array_column($files, 'file_id'));
		$file		= $files[$key];

		if ($file)
		{
			$tpl->enter('item_');

			if ($caption == 1)
			{
				$file_description	= $file['file_description'];
			}
			else if ($caption == 2)
			{
				$file_description	= $file['caption'];
			}

			$file_description	= $this->format($file_description, 'typografica' );

			$tpl->token			= $param_token;
			$tpl->description	= $file_description;

			if ($file['page_id'])
			{
				$path = 'file:/' . $file['tag'] . '/';
			}
			else
			{
				$path = 'file:/';
			}

			// show image
			if ($file['picture_w'] || $file['file_ext'] == 'svg')
			{
				$tpl->img		=  $this->link($path . $file['file_name']);
			}

			// backlink
			$tpl->href		= $this->href('', $this->tag, [$param_token  => $nav_offset]);

			$tpl->enter('navigation_');

			if (array_key_exists($key - 1, $files))
			{
				$tpl->prev_href	= $this->href('', $this->tag, ['file_id' => $files[$key - 1]['file_id'], $param_token  => $nav_offset, 'token' => $param_token, '#' => $param_token]);
			}

			if (array_key_exists($key - 1, $files) && array_key_exists($key + 1, $files))
			{
				$tpl->separator	= true;
			}

			if (array_key_exists($key + 1, $files))
			{
				$tpl->next_href	= $this->href('', $this->tag, ['file_id' => $files[$key + 1]['file_id'], $param_token  => $nav_offset, 'token' => $param_token, '#' => $param_token]);
			}

			$tpl->leave();	// navigation
			$tpl->leave();	// item
		}
	}
}
else
{
	$tpl->noaccess = true;
}
