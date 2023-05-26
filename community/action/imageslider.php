<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	images as slider

	The sole condition is that all the images must be exactly the same size.

	version: 0.9

	https://wackowiki.org/doc/Dev/PatchesHacks/ImageSlider
 */

$info = <<<EOD
Description:
	Showing images as slider for uploaded files.

Usage:
	{{imageslider}}

Options:
	[page="PageName" or global=1]
	[order="time|name_desc|size|size_desc|ext"]
	[owner="UserName"]
	[media=1]
	[max=number]
EOD;

// set defaults
$global		??= 0;
$help		??= 0;
$max		??= null;
$media		??= 1;
$order		??= '';
$owner		??= '';
$page		??= '';
$track		??= 0;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'imageslider']);
	return;
}

if ($max)
{
	$limit = $max;
}
else
{
	$limit	= 50;
}

$order_by		= match($order) {
	'ext'			=> 'file_ext ASC',
	'name_desc'		=> 'file_name DESC',
	'size'			=> 'file_size ASC',
	'size_desc'		=> 'file_size DESC',
	'time'			=> 'created ASC',
	'time_desc'		=> 'created DESC',
	default			=> 'file_name ASC',
};

$width_settings			= '100%'; // 100%, 300px, etc.
$files					= [];
$page_id				= null;

// default options for slider
$time_on_slide			= 6;
$time_between_slides	= 1;
$animation_timing		= 'ease';
$slidy_direction		= 'left';
$css_animation_name		= 'slidy';

// options: data-caption, alt, none
$caption_source			= 'data-caption';
$caption_background		= 'rgba(0,0,0,0.3)';
$caption_color			= '#fff';
$caption_font			= 'Avenir, Avenir Next, Droid Sans, DroidSansRegular, Corbel, Tahoma, Geneva, sans-serif';

// options: top, bottom
$caption_position		= 'bottom';

// options: slide, perm, fade
$caption_appear			= 'slide';
$caption_size			= '1.6rem';

// same units
$caption_padding		= '.6rem';

if (!$global)
{
	if ($page == '')
	{
		$tag		= $this->tag;
		$page_id	= $this->page['page_id'];
	}
	else
	{
		$tag		= $this->unwrap_link($page);

		if ($_page_id = $this->get_page_id($tag))
		{
			$page_id	= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
}
else
{
	$can_view	= 1;
	$tag		= $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $this->tag))
	{
		$filepage = $this->page;
	}
	else
	{
		$filepage = $this->load_page($tag, 0, null, LOAD_CACHE, LOAD_META);
	}

	if (!$global && !isset($filepage['page_id']))
	{
		return;
	}

	$selector =
		"FROM " . $this->prefix . "file f " .
			"INNER JOIN " . $this->prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE f.page_id = " . ($global ? 0 : (int) $filepage['page_id']) . " " .
			"AND f.picture_w <> 0 " .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '') .
			"AND f.deleted <> 1 ";

	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'f');

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.created, u.user_name AS user " .
		$selector .
		"ORDER BY f." . $order_by . " " .
		"LIMIT {$pagination['offset']}, {$limit}", true);

	// display
	if (!$global)
	{
		$path2 = 'file:/' . $tag . '/';
	}
	else
	{
		$path2 = 'file:/';
	}

	if ($factor = count($files))
	{
		// calculate data for image slider CSS

		// count the number of images in the slide, including the new cloned element
		$img_count			= $factor + 1;
		// calculate the total length of the animation by multiplying the number of _actual_ images by the amount of time for both static display of each image and motion between them
		$total_time			= ($time_on_slide + $time_between_slides) * ($img_count - 1);
		// determine the percentage of time an individual image is held static during the animation
		$slide_ratio		= ($time_on_slide / $total_time) * 100;
		// determine the percentage of time for an individual movement
		$move_ratio			= ($time_between_slides / $total_time) * 100;
		// work out how wide each image should be in the slidy, as a percentage.
		$base_percentage	= 100 / $img_count;
		// set the initial position of the slidy element
		$position			= 0;

		$img_width	= $img_count * 100;
		$slidy		= '';

		if ($slidy_direction == 'right')
		{
			$slidy .= "0% \t{ left: -" . (($img_count - 1) * 100) . "%; }\n";

			for ($i = $img_count - 1; $i > 0; $i--)
			{
				$position += $slide_ratio;
				// make the keyframe the position of the image
				$slidy .= "\t\t" . $position . "% \t{ left: -" . ($i * 100) . "%; }\n";
				$position += $move_ratio;
				// make the postion for the _next_ slide
				$slidy .= "\t\t" . $position . "% \t{ left: -" . (($i - 1) * 100) . "%; }\n";
			}
		}
		else
		{
			$slidy .= "0% \t{ left: 0%; }\n";

			// the slider is moving to the left
			for ($i = 0; $i < ($img_count - 1); $i++)
			{
				$position += $slide_ratio;
				// make the keyframe the position of the image
				$slidy .= "\t\t" . $position . "% \t{ left: -" . ($i * 100) . "%; }\n";
				$position += $move_ratio;
				// make the postion for the _next_ slide
				$slidy .= "\t\t" . $position . "% \t{ left: -" . (($i + 1) * 100) . "%; }\n";
			}
		}

		$tpl->css = <<<EOD
	<style>

	div#captioned-gallery {
		width: 100%;
		overflow: hidden;
	}
	figure {
		margin: 0;
	}
	figure.slider {
		position: relative;
		width: {$img_width}%;
		font-size: 0;
		animation: {$total_time}s {$animation_timing} slidy infinite;
	}
	figure.slider:hover {
		/* animation: animation 1s  16 ease; */
		animation-play-state: paused;
	}
	figure.slider figure {
		width: {$base_percentage}%;
		height: auto;
		display: inline-block;
		position: inherit;
	}
	figure.slider img {
		width: {$width_settings};
		height: auto;
	}
	figure.slider figure figcaption {
		position: absolute;
		bottom: 0;
		background: rgba(0,0,0,0.3);
		color: #fff;
		width: 100%;
		font-size: 1rem;
		padding: .6rem;
	}
	div#slider figure {
		position: relative;
		width: {$img_width}%;
		margin: 0;
		padding: 0;
		font-size: 0;
		left: 0;
		text-align: left;
		animation: {$total_time}s {$animation_timing} slidy infinite;
	}

	@media screen and (max-width: 500px) {
		figure.slider figure figcaption {
			font-size: 1.2rem;
		}
	}

	/* figure.slider figure figcaption {
		position: absolute;
		bottom: -3.5rem;
		background: rgba(0,0,0,0.3);
		color: #fff;
		width: 100%;
		font-size: 2rem;
		padding: .6rem;
		transition: .5s bottom;
	}
	figure.slider figure:hover figcaption {
		bottom: 0;
	}

	figure.slider figure:hover + figure figcaption {
		bottom: 0;
	} */

	@keyframes slidy {
		{$slidy}
	}

	</style>
EOD;

		// adding at the end a clone of the first array for transition loop
		$files[]	= $files[0];
		$n			= 0;

		$tpl->enter('n_');

		foreach($files as $file)
		{
			if ($file['picture_h']) // missing: svg!
			{
				$n++;

				$this->file_cache[$file['page_id']][$file['file_name']] = $file;

				$desc		= $this->format($file['file_description'], 'typografica', ['lang' => $file['file_lang']]);

				if ($desc == '')
				{
					$desc = NBSP;	// No-Break Space
				}

				$file_name		= $file['file_name'];
				$text			= $media ? '' : $file_name;

				$tpl->image		= $this->link($path2 . $file_name, '', $text, '', $track);
				$tpl->n			= $n;
				$tpl->count		= $count['n'];
				$tpl->desc		= $desc;
			}
		}

		$tpl->leave();	// n
	}
	else
	{
		$tpl->nofile =  $this->_t('FileNotFound');
	}

	unset($files);
}
else
{
	$tpl->noaccess = true;
}
