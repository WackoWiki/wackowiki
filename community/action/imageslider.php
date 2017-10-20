<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Showing images as slider for uploaded by {{upload}} files

	version: 0.5

	{{imageslider
		[page="PageName" or global=1]
		[order="time|FILENAME|size|size_desc|ext"]
		[owner="UserName"]
		[picture=1]
		[max=number]
	}}
 */

// The sole condition is that all the images must be exactly the same size.

$page_id = '';

if (!isset($nomark))	$nomark = '';
if (!isset($order))		$order = '';
if (!isset($global))	$global = '';
if (!isset($tag))		$tag = ''; // FIXME: $tag == $page
if (!isset($owner))		$owner = '';
if (!isset($page))		$page = '';
if (!isset($ppage))		$ppage = '';
if (!isset($legend))	$legend = '';
if (!isset($deleted))	$deleted = 0;
if (!isset($track))		$track = 0;
if (!isset($picture))	$picture = '1';
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

$width_settings			= '100%'; // 100%, 300px, etc.

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
		$ppage	= '/' . $page;

		if ($_page_id = $this->get_page_id($page))
		{
			$page_id	= $_page_id;
		}
	}

	$can_view	= $this->has_access('read', $page_id) || $this->is_admin() || $this->is_owner($page_id);
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

	$count = $this->db->load_all(
		"SELECT f.file_id " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE f.page_id = '" . ($global ? 0 : $filepage['page_id']) . "' " .
			"AND f.picture_w <> '0' " .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '') .
			($deleted != 1
				? "AND f.deleted <> '1' "
				: ""), true);

	$count		= count($count);
	$pagination = $this->pagination($count, $limit, 'f');

	// load files list
	$files = $this->db->load_all(
		"SELECT f.file_id, f.page_id, f.user_id, f.file_size, f.picture_w, f.picture_h, f.file_ext, f.file_lang, f.file_name, f.file_description, f.uploaded_dt, u.user_name AS user, f.hits " .
		"FROM " . $this->db->table_prefix . "file f " .
			"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
		"WHERE f.page_id = '" . ($global ? 0 : $filepage['page_id']) . "' " .
			"AND f.picture_w <> '0' " .
			($owner
				? "AND u.user_name = " . $this->db->q($owner) . " "
				: '') . " " .
			($deleted != 1
			? "AND f.deleted <> '1' "
					: "") .
		"ORDER BY f." . $order_by . " " .
		"LIMIT {$pagination['offset']}, {$limit}");

	if (!is_array($files))
	{
		$files = [];
	}

	// display

	if (!$global)
	{
		$path2 = 'file:/' . ($this->slim_url($page)) . '/';
	}
	else
	{
		$path2 = 'file:/';
	}

	if (!$nomark)
	{
		$title = $this->_t('UploadTitle'.($global ? 'Global' : '') ) . ' '.($page ? $this->link($ppage, '', $legend) : '');
		#echo '<div class="layout-box"><p class="layout-box"><span>' . $title.": </span></p>\n";
	}

	if ($factor = count($files))
	{
		// calculate data for image slider CSS

		// count the number of images in the slide, including the new cloned element
		$img_count			= $factor + 1;
		// calculate the total length of the animation by multiplying the number of _actual_ images by the amount of time for both static display of each image and motion between them
		$total_time			= ($time_on_slide + $time_between_slides) * ($img_count - 1);
		#$_totalTime	= ($time_on_slide + $time_between_slides) * ($img_count);
		// determine the percentage of time an individual image is held static during the animation
		$slide_ratio		= ($time_on_slide / $total_time) * 100;
		// determine the percentage of time for an individual movement
		$move_ratio			= ($time_between_slides / $total_time) * 100;
		// work out how wide each image should be in the slidy, as a percentage.
		$base_percentage	= 100 / $img_count;
		// set the initial position of the slidy element
		$position			= 0;

		// debug info
		#echo 'imgCount: ' . $img_count . '<br>';
		#echo 'totalTime: ' . $total_time . '<br>';
		#echo 'slideRatio: ' . $slide_ratio . '<br>';
		#echo 'moveRatio: ' . $move_ratio . '<br>';
		#echo 'basePercentage: ' . $base_percentage . '<br>';
		#echo 'totalTime: ' . $total_time . '<br>';
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

				$this->files_cache[$file['page_id']][$file['file_name']] = $file;

				$dt			= $file['uploaded_dt'];
				$desc		= $this->format($file['file_description'], 'typografica' );

				if ($this->page['page_lang'] != $file['file_lang'])
				{
					$desc	= $this->do_unicode_entities($desc, $file['file_lang']);
				}

				if ($desc == '')
				{
					$desc = "&nbsp;";
				}

				$file_id	= $file['file_id'];
				$file_name	= $file['file_name'];
				$text		= ($picture == false) ? $file_name : '';
				$file_size	= $this->binary_multiples($file['file_size'], false, true, true);
				$link		= $this->link($path2 . $file_name, '', $text, '', $track);

				?>
				<figure>
				<?php echo $link; ?>
					<figcaption><?php echo $n . '/' . $count . ' ' . $desc; ?></figcaption>
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

	if (!$nomark)
	{
		#echo "</div>\n";
	}
}
else
{
	echo '<em>' . $this->_t('ActionDenied') . '</em>';
}

?>