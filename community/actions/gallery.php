<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*!! gallery action :

// requires PHP Thumb Library <http://phpthumb.gxdlabs.com>
// optional fancyBox <http://fancyapps.com/fancybox/>
{{gallery

	Shows photogallery

	[page		= "page_tag"] - call image from another page
	[perrow		= <Number of images per rows> (default = 3)]
	[nodesc		= 1] - hide descriptions
	[title		= "Gallery"] - album title
	[toblank	= "1|new"] - show large images without page (if = "new" in new browser window)
	[nomark		= 1] - hide external border
	[group_id	= "text_group_id"] - group ID of the group, for the organization of scrolling
	[table		= 1] - pictures in table

	[order		= "time|FILENAME|size|size_desc|ext"]
	[owner		= "UserName"]
	[max		= number]
}}

TODO: config settings
- image_processing (boolean)
- thumbnails (boolean)

- generated thumbnails full-blown 32-bit PNGs (or at least 24-bit) resulting in a file size often larger than the original image
- remove thumbs with file or page
- load the JS with the header (themes/_common/_header.php), see flash action (to avoid multiple loads)
- fall back if no JS or Image manipulation library is available

*/

// Include PHP Thumbnailer
require_once 'lib/phpthumb/ThumbLib.inc.php';

?>

<!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/fancybox/jquery-1.9.0.min.js"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<!-- Add fancyBox -->
<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/fancybox/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'];?>js/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'];?>js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/fancybox/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'];?>js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<script type="text/javascript">

	$(document).ready(function() {
		$(".fancybox-thumb").fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'inside'
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
		});
	});

</script>

<?php

// Loading parameters
$thumb_dir	= 'files/thumbs';
$small_id	= 'tn_';
$imgclass	= '';
$img_spacer	= '';
$height		= 150; // $this->config['img_max_thumb_width']

if (!isset($page))		$page = '';
if (!isset($title))		/*$title="Gallery";*/ $nomark = 1;
if (!isset($toblank))	$toblank = ''; #$toblank = 'new';
if (!isset($table))		$table = '';
if (!isset($nodesc))	$nodesc = '';
if (!isset($nomark))	$nomark = '';

if(!isset($group_id))	$group_id	= 'fancybox-thumb';

if (!isset($order))		$order = '';
if (!isset($global))	$global = '';
if (!isset($tag))		$tag = ''; // FIXME: $tag == $page
if (!isset($owner))		$owner = '';
if (!isset($max))		$max = '';

if ($max)
{
	$limit = $max;
}
else
{
	$limit	= 50;
}

if(!isset($perrow))
{
	$images_row = 5;
}
else
{
	$images_row = $perrow;
}

// we using a parameter token here to sort out multiple instances
$param_token = substr(hash('md5', $global.$page.$nodesc.$toblank.$owner.$order.$max), 0, 8);

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

		$source_page_tag	= $this->tag;
	}
	else
	{
		$page = $this->unwrap_link($page);

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

	$source_page_tag	= '/';
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

	// TODO: we want only image files -> AND f.picture_w <> '0'
	$count = $this->load_all(
			"SELECT f.upload_id ".
			"FROM ".$this->config['table_prefix']."upload f ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
			"WHERE f.page_id = '". ($global ? 0 : $filepage['page_id'])."' ".
				"AND f.picture_w <> '0' ".
			($owner
					? "AND u.user_name = '".quote($this->dblink, $owner)."' "
					: ''), 1);

	$count		= count($count);
	$pagination = $this->pagination($count, $limit, $param_token);

	// load files list
	$files = $this->load_all(
			"SELECT f.upload_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.lang, f.file_name, f.file_description, f.uploaded_dt, u.user_name AS user, f.hits ".
			"FROM ".$this->config['table_prefix']."upload f ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
			"WHERE f.page_id = '". ($global ? 0 : $filepage['page_id'])."' ".
				"AND f.picture_w <> '0' ".
			($owner
					? "AND u.user_name = '".quote($this->dblink, $owner)."' "
					: '')." ".
			"ORDER BY f.".$order_by." ".
			"LIMIT {$pagination['offset']}, {$limit}");

	if (!is_array($files))
	{
		$files = array();
	}

	// Making an gallery
	$cur = 0;

	// pagination
	if (isset($pagination['text']))
	{
		echo "<span class=\"pagination\">{$pagination['text']}</span><br />\n";
	}

	if (!$nomark)
	{
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".htmlspecialchars($title, NULL, '').":</span></p>\n";
	}

	if (!isset($_GET['photo']) || (isset($_GET['token']) && $_GET['token'] != $param_token))
	{
		if ($table)
		{
			echo '<table align="center" width="100%">';
		}
		else
		{
			echo '<div class="gallery" align="center">'."\n";
		}

		foreach ($files as $file)
		{
			$this->files_cache[$file['page_id']][$file['file_name']] = &$file;

			$file_name			= $file['file_name'];
			$file_width			= ''; // $file['picture_w'];
			$file_height		= ''; // $file['picture_h'];
			$prefix_global		= '';
			$tnb_name			= $small_id.$file_name;
			$linkto				= $file_name;

			$file_description	= $this->format($file['file_description'], 'typografica' );

			if ($this->page['lang'] != $file['lang'])
			{
				$file_description	= $this->do_unicode_entities($file_description, $file['lang']);
			}

			// check for upload location: global / per page
			if ($file['page_id'] == '0')
			{
				$tnb_path	= $thumb_dir.'/'.$prefix_global.'@'.$tnb_name;
				$url		= $this->config['base_url'].$this->config['upload_path'].'/'.$file_name;

			}
			else
			{
				$tnb_path	= $thumb_dir.'/@'.$filepage['page_id'].'@'.$tnb_name;
				$url		= $this->href('file', $source_page_tag, 'get='.$file_name);
			}

			$img	= '<img src="'.$this->config['base_url'].$tnb_path.'" '.($file['file_description'] ? 'alt="'.$file_description.'" title="'.$file_description.'"' : '').' width="'.$file_width.'" height="'.$file_height.'" '.($imgclass ? 'class="'.$imgclass.'"' : '').'/>';

			$caption = '<br><figcaption>'.
					'<span>'.$file_description.'</span> '.'<br />'.
					#$file['user'].'<br />'.
					#$file['picture_w'].'x'.$file['picture_h'].'<br />'.
					#$file['hits'].'<br />'. // we do exclude images from hit cout atm -> see file handler
				'</figcaption>';

			if (file_exists($tnb_path))
			{
				if ($table)
				{
					if($cur == 0)
					{
						echo '<tr>';
					}

					echo '<td align="center">';
				}
				else
				{
					echo $img_spacer;
				}

				echo '<figure class="zoom">';

				if (!$toblank)
				{
					echo "<a href=\"".$this->href('', $this->tag, 'photo='.$linkto.'&amp;token='.$param_token.'#'.$param_token)."\">".$img."</a>\n";
				}
				else
				{
					if ($toblank == 'new')
					{
						echo "<a href=\"".$url."\" class=\"fancybox-thumb\" ".($group_id ? "rel=\"".$group_id."\"" : "")." ".($file['file_description'] ? "alt=\"".$file_description."\" title=\"".$file_description."\"" : "").">".$img."</a>\n";
					}
					else
					{
						echo "<a href=\"".$url."\">".$img."</a>\n";
					}
				}

				if (!$nodesc)
				{
					echo $caption;
				}

				echo '</figure>';

				if ($table)
				{
					echo "</td>\n";
				}

				$cur = ($cur + 1) % $images_row;

				if ($cur == 0)
				{
					echo ($table ? '</tr>' : '<br />');
				}
				else
				{
					echo $img_spacer;
				}
			}
			else
			{
				if (!file_exists($thumb_dir.'/@'.$filepage['page_id'].'@'.$small_id.$file_name))
				{
					@set_time_limit(0);
					@ignore_user_abort(true);

					if ($file['page_id'] == 0)
					{
						$src_image		= $this->config['upload_path'].'/'.$file_name;
						$new_filename	= $thumb_dir.'/'.$prefix_global.'@'.$small_id.$file_name;
					}
					else
					{
						$src_image		= $this->config['upload_path_per_page'].'/@'.$filepage['page_id'].'@'.$file_name;
						$new_filename	= $thumb_dir.'/@'.$filepage['page_id'].'@'.$small_id.$file_name;
					}

					## thumbnail library will do all of this math, but in case you’re stuck ...

					// Original values obtained from the top image
					// can come from getimagesize(), imagesx()/imagesy(), or similar
					/*
					$source_width		= 66;
					$source_height		= 100;
					$thumbnail_width	= 50;
					$thumbnail_height	= 100;

					// Compute aspect ratios
					$source_ar			= $source_width / $source_height;
					$thumbnail_ar		= $thumbnail_width / $thumbnail_height;

					// Compute the output width and height based on the
					// comparison of aspect ratios
					if ($source_ar > $thumbnail_ar)
					{
						// Use the thumbnail width
						$output_width	= $thumbnail_width;
						$output_height	= round($original_height
											/ $original_width * $thumbnail_width);
					}
					else
					{
						// Use the thumbnail height
						$output_height	= $thumbnail_height;
						$output_width	= round($original_width
											/ $original_height * $thumbnail_height);
					} */

					try
					{
						$thumb = PhpThumbFactory::create($src_image);
					}
					catch (Exception $e)
					{
						// handle error here however you'd like
					}

					// TODO: trusting blindly the db record can cause -> Fatal error: Call to a member function resize() on a non-object in /wacko/actions/gallery.php
					// $thumb->resize(100, 100);
					 $thumb->resize($height, $height);

					// $thumb->resizePercent(50);

					// $thumb->adaptiveResize(175, 175);
					#$thumb->adaptiveResize($height, $height);

					// $thumb->cropFromCenter(200, 100);

					// $thumb->save($thumb_dir.$file); // requires correct write permissions!
					$thumb->save($new_filename);

					// a rather less good idea, for tracking pherhaps with an additional field like 'tumbnail' in the upload table, remember we can have many derived versions from the original image
					/* $this->sql_query(
						"INSERT INTO ".$this->config['table_prefix']."upload SET ".
						"user_id			= '".(int)$file['user_id']."', ".
						"page_id			= '".(int)$filepage['page_id']."', ".
						"file_name			= '".quote($this->dblink, $small_id.$file_name)."', ".
						"file_description	= '".quote($this->dblink, $file['file_description'])."', ".
						"uploaded_dt		= '".quote($this->dblink, date("Y-m-d H:i:s"))."', ".
						"file_size			= '".(int)sizeof($newfilename)."', ".
						"picture_w			= '".(int)$diw."', ".
						"picture_h			= '".(int)$height."', ".
						"file_ext			= '".quote($this->dblink, $filepage['file_ext'])."'"); */

					if($table)
					{
						if ($cur == 0)
						{
							echo '<tr>';
						}

						echo '<td align="center">';
					}
					else
					{
						echo $img_spacer;
					}

					echo '<figure class="zoom">';

					if(!$toblank)
					{
						echo "<a href=\"".$this->href('', $this->tag, 'photo='.$linkto.'&amp;token='.$param_token)."\">".$img."</a>\n";
					}
					else
					{
						if ($toblank == 'new')
						{
							echo "<a href=\"".$url."\" class=\"fancybox-thumb\" ".($group_id ? "rel=\"lightbox[".$group_id."]\"" : "rel=\"lightbox\"")." ".($file['file_description']?"alt=\"".$file_description."\" title=\"".$file_description."\"":"").">".$img."</a>\n";
						}
						else
						{
							echo "<a href=\"".$url."\">".$img."</a>\n";
						}

						if(!$nodesc)
						{
							echo $caption;
						}

						echo '</figure>';

						if($table)
						{
							echo("</td>\n");
						}

						$cur = ($cur + 1) % $images_row;

						if ($cur == 0)
						{
							echo ($table ? '</tr>' : '<br />');
						}
						else
						{
							echo $img_spacer;
						}
					}
				}
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
		// We choose one photo

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

		echo '<div align="center" id="'.$param_token.'">';

		$path2	= 'file:';
		$link	= $this->link($path2.$_GET['photo'], '', '', $_GET['photo']);

		echo $link;
		echo '<br /><br />';
		echo '<a href="'.$this->href('', $source_page_tag, '').'">&lt; Back</a>';
		echo "</div>\n";
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