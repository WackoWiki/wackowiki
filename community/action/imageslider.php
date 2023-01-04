<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Showing images as slider for uploaded by {{upload}} files

	The sole condition is that all the images must be exactly the same size.

	version: 0.7

	{{imageslider
		[page="PageName" or global=1]
		[order="time|name_desc|size|size_desc|ext"]
		[owner="UserName"]
		[media=1]
		[max=number]
	}}

	https://wackowiki.org/doc/Dev/PatchesHacks/ImageSlider
 */

$page_id = '';

if (!isset($order))		$order		= '';
if (!isset($global))	$global		= 0;
if (!isset($owner))		$owner		= '';
if (!isset($page))		$page		= '';
if (!isset($deleted))	$deleted	= 0;
if (!isset($track))		$track		= 0;
if (!isset($media))		$media		= 1;
if (!isset($max))		$max		= null;

if ($max)
{
	$limit = $max;
}
else
{
	$limit	= 50;
}

							$order_by = "file_name ASC";
if ($order == 'ext')		$order_by = "file_ext ASC";
if ($order == 'name_desc')	$order_by = "file_name DESC";
if ($order == 'size')		$order_by = "file_size ASC";
if ($order == 'size_desc')	$order_by = "file_size DESC";
if ($order == 'time')		$order_by = "uploaded_dt DESC";

$width_settings			= '100%'; // 100%, 300px, etc.
$files					= [];

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
		$ppage		= '/' . $tag;

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
		$filepage = $this->load_page($tag);
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
			($deleted != 1
				? "AND f.deleted <> 1 "
				: "");

	$count = $this->db->load_single(
		"SELECT COUNT(f.file_id) AS n " .
		$selector, true);

	$pagination = $this->pagination($count['n'], $limit, 'f');

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, u.user_name AS user " .
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

		// debug info
		#echo 'imgCount: '			. $img_count . '<br>';
		#echo 'totalTime: '			. $total_time . '<br>';
		#echo 'slideRatio: '		. $slide_ratio . '<br>';
		#echo 'moveRatio: '			. $move_ratio . '<br>';
		#echo 'basePercentage: '	. $base_percentage . '<br>';
		#echo 'totalTime: '			. $total_time . '<br>';
		?>

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
			width: <?php echo $img_count * 100; ?>%;
			font-size: 0;
			animation: <?php echo $total_time . 's ' . $animation_timing; ?> slidy infinite;
		}
		figure.slider:hover {
			/* animation: animation 1s  16 ease; */
			animation-play-state: paused;
		}
		figure.slider figure {
			width: <?php echo $base_percentage; ?>%;
			height: auto;
			display: inline-block;
			position: inherit;
		}
		figure.slider img {
			width: <?php echo $width_settings; ?>;
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
			width: <?php echo $img_count * 100; ?>%;
			margin: 0;
			padding: 0;
			font-size: 0;
			left: 0;
			text-align: left;
			animation: <?php echo $total_time . 's ' . $animation_timing; ?> slidy infinite;
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

			<?php
			if ($slidy_direction == 'right')
			{
				echo "0% \t{ left: -" . (($img_count - 1) * 100) . "%; }\n";

				for ($i = $img_count - 1; $i > 0; $i--)
				{
					$position += $slide_ratio;
					// make the keyframe the position of the image
					echo "\t\t" . $position . "% \t{ left: -" . ($i * 100) . "%; }\n";
					$position += $move_ratio;
					// make the postion for the _next_ slide
					echo "\t\t" . $position . "% \t{ left: -" . (($i - 1) * 100) . "%; }\n";
				}
			}
			else
			{
				echo "0% \t{ left: 0%; }\n";

				// the slider is moving to the left
				for ($i = 0; $i < ($img_count - 1); $i++)
				{
					$position += $slide_ratio;
					// make the keyframe the position of the image
					echo "\t\t" . $position . "% \t{ left: -" . ($i * 100) . "%; }\n";
					$position += $move_ratio;
					// make the postion for the _next_ slide
					echo "\t\t" . $position . "% \t{ left: -" . (($i + 1) * 100) . "%; }\n";
				}
			}?>

		}

		</style>

		<div id="captioned-gallery">
			<figure class="slider">
			<?php
			// adding at the end a clone of the first array for transition loop
			$files[]	= $files[0];
			$n			= 0;
			#Ut::debug_print_r($files);

			foreach($files as $file)
			{
				if ($file['picture_h']) // missing: svg!
				{
					$n++;

					$this->file_cache[$file['page_id']][$file['file_name']] = $file;

					$desc		= $this->format($file['file_description'], 'typografica' );

					if ($desc == '')
					{
						$desc = "\u{00A0}";	// \u{00A0} No-Break Space (NBSP)
					}

					$file_name	= $file['file_name'];
					$text		= $media ? '' : $file_name;
					$link		= $this->link($path2 . $file_name, '', $text, '', $track);

					?>
					<figure>
						<?php echo $link; ?>
						<figcaption><?php echo $n . '/' . $count['n'] . ' ' . $desc; ?></figcaption>
					</figure>
		<?php
				}
			}?>
			</figure>
		</div>
	<?php
	}
	else
	{
		echo '<em>' . $this->_t('FileNotFound') . '</em>';
	}

	unset($files);
}
else
{
	echo '<em>' . $this->_t('ActionDenied') . '</em>';
}
