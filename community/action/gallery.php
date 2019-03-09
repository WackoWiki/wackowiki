<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/* gallery action :
 * https://wackowiki.org/doc/Dev/PatchesHacks/Gallery
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

	[order		= "time|FILENAME|size|size_desc|ext"]
	[owner		= "UserName"]
	[max		= number]
}}

TODO: config settings
- image_processing (boolean)
- thumbnails (boolean)

- split local and global tumbs -> read access
- add filter for categories cat="one,two"
- generated thumbnails full-blown 32-bit PNGs (or at least 24-bit) resulting in a file size often larger than the original image
- remove thumbs with file or page
- fall back if no JS or Image manipulation library is available or disabled

*/

$get_file = function ($file_id)
{
	$file = $this->db->load_single(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.file_lang, f.file_size, f.file_description, f.caption, f.uploaded_dt, f.picture_w, f.picture_h, f.file_ext, u.user_name, p.supertag, p.title " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "page p ON (f.page_id = p.page_id) " .
		"WHERE f.file_id = " . (int) $file_id . " " .
		"LIMIT 1", true);

	return $file;
};

// Include PHP Thumbnailer
require_once 'lib/phpthumb/PHPThumb.php';
require_once 'lib/phpthumb/GD.php';

// Add jQuery library
$this->add_html('footer', '<script src="' . $this->db->base_url . 'js/jquery-3.2.1.min.js"></script>');
// Add fancyBox
$this->add_html('footer', '<script src="' . $this->db->base_url . 'js/fancybox/jquery.fancybox.min.js"></script>');
$this->add_html('header', '<link rel="stylesheet" media="screen" href="' . $this->db->base_url . 'js/fancybox/jquery.fancybox.min.css">');

// Loading parameters
$files			= [];
$thumb_prefix	= 'tn_';
$imgclass		= '';
$img_spacer		= '';
$width			= $this->db->img_max_thumb_width; // default: 150

if (!isset($page))		$page		= '';
if (!isset($title))		/*$title="Gallery";*/ $nomark = 1;
if (!isset($target))	$target		= '';
if (!isset($table))		$table		= 1;
if (!isset($caption))	$caption	= 1;
if (!isset($nomark))	$nomark		= '';

if (!isset($order))		$order		= '';
if (!isset($global))	$global		= 0;
if (!isset($tag))		$tag		= ''; // FIXME: $tag = $page
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
		$page				= $this->tag;
		$source_page_tag	= $this->tag;
		$page_id			= $this->page['page_id'];
	}
	else
	{
		$page				= $this->unwrap_link($page);
		$source_page_tag	= $page;

		if ($_page_id = $this->get_page_id($page))
		{
			$page_id		= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
}
else
{
	$can_view			= 1;
	$page				= $this->tag;
	$source_page_tag	= '/';
}

if ($can_view)
{
	if ($global || ($tag == $page))
	{
		$file_page = $this->page;
	}
	else
	{
		$file_page = $this->load_page($page);
	}

	if (!$global && !isset($file_page['page_id']))
	{
		return;
	}

	$selector =
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE f.page_id = '". ($global ? 0 : $file_page['page_id']) . "' " .
			"AND f.picture_w <> 0 " .
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
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.caption, f.uploaded_dt, u.user_name AS user, f.hits " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		"LIMIT {$pagination['offset']}, {$limit}", true);

	// Making an gallery
	$cur = 0;

	// pagination
	$this->print_pagination($pagination);

	if (!$nomark)
	{
		echo '<div class="layout-box"><p><span>' . htmlspecialchars($title, null, '') . ":</span></p>\n";
	}

	if (!isset($_GET['file_id']) || (isset($_GET['token']) && $_GET['token'] != $param_token))
	{
		if ($table)
		{
			echo '<table class="t-center" style="width:100%;">';
		}
		else
		{
			echo '<div class="gallery t-center">' . "\n";
		}

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

			if ($this->page['page_lang'] != $file['file_lang'])
			{
				$file_description	= $this->do_unicode_entities($file_description, $file['file_lang']);
			}

			// check for upload location: global / per page
			if ($file['page_id'] == '0')
			{
				$tnb_path		= Ut::join_path(THUMB_DIR, $prefix_global . '@' . $tnb_name);
				$url			= $this->db->base_url . Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
			}
			else
			{
				$tnb_path		= Ut::join_path(THUMB_DIR, '@' . $file_page['page_id'] . '@' . $tnb_name);
				$url			= $this->href('file', $source_page_tag, ['get' => $file_name]);
			}

			$img	= '<img src="' . $this->db->base_url . $tnb_path . '" ' . ($file['file_description'] ? 'alt="' . $file_description . '" title="' . $file_description . '"' : '') . ' width="' . $file_width . '" height="' . $file_height . '" ' . ($imgclass ? 'class="' . $imgclass . '"' : '') . '>';

			$figcaption = '<br>' .
				'<figcaption>' .
					'<span>' . $file_description . '</span> ' . '<br>' .
					#$file['user'] . '<br>' .
					#$file['picture_w'] . 'x' . $file['picture_h'] . '<br>' .
					#$file['hits'] . '<br>' .  // we do exclude images from hit cout atm -> see file handler
				"</figcaption>\n";

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
					echo '<tr>';
				}

				echo '<td class="t-center">';
			}
			else
			{
				echo $img_spacer;
			}

			echo '<figure class="zoom">';

			if (!$target)
			{
				echo '<a href="' . $this->href('', $this->tag, ['file_id' => $file['file_id'], 'token' => $param_token, '#' => $param_token]) . '">' . $img . "</a>\n";
			}
			else
			{
				if ($target == 2)
				{
					echo '<a href="' . $url . '" data-fancybox="'. $param_token .'" data-caption="' . $file_description . '" '.($file['file_description'] ? 'alt="' . $file_description . '" title="' . $file_description . '"' : '') . '>' . $img . "</a>\n";
				}
				else
				{
					echo '<a href="' . $url . '">' . $img . "</a>\n";
				}
			}

			if ($caption)
			{
				echo $figcaption;
			}

			echo "</figure>\n";

			if ($table)
			{
				echo "</td>\n";
			}

			$cur = ($cur + 1) % $images_row;

			if ($cur == 0)
			{
				echo ($table ? '</tr>' : '<br>');
			}
			else
			{
				echo $img_spacer;
			}
		}

		if ($table)
		{
			echo "</table>\n";
		}
		else
		{
			echo "</div>\n";
		}
	}
	else
	{
		// We choose one image
		$file = $get_file((int) $_GET['file_id']);

		/* 	<figure class="zoom">
			<a class="inline" href="#gallery:zoom_123">
				<img alt="File description" src="http://images.123.jpg">
			</a>
			<figcaption>
				<a class="inline" href="#gallery:zoom_123">
					<span>
						File description
						<small>(Image: Author</small>
					</span>
				</a>
			</figcaption>
		</figure> */

		echo '<div id="' . $param_token . '" class="t-center">';

		if (count($file) > 0)
		{
			if ($file['page_id'])
			{
				$path = 'file:/' . $file['supertag'] . '/';
			}
			else
			{
				$path = 'file:/';
			}

			// show image
			if ($file['picture_w'] || $file['file_ext'] == 'svg')
			{
				echo $this->link($path . $file['file_name']);
			}

			echo '<br><br>';
			echo '<a href="' . $this->href('', $this->tag, '') . '">&lt;' . $this->_t('Back') . '</a>';
		}

		echo "</div>\n";
	}

	if (!$nomark)
	{
		echo "</div>\n";
	}

	// pagination
	$this->print_pagination($pagination);
}
else
{
	echo '<em>' . $this->_t('ActionDenied') . '</em>';
}

?>