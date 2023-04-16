<?php

// WackoWiki Formatter to display graphviz-graphs
// https://wackowiki.org/doc/Dev/PatchesHacks/GraphvizVisualisation

// ported to WackoWiki 5.1.0 by varaha@zaporogom.info 2012/08/27
// ported to WackoWiki 5.5 2019/06/20 - untested
// ported to WackoWiki 6.1 2022/02/05 - untested

// if set to "" we test is the file in PATH
$gv_settings['bindir']	= '';
$gv_settings['filedir']	= UPLOAD_LOCAL_DIR;

// check, if there should be another tool than dot used
$bin = match(key($options)){
	'neato'			=> 'neato',
	'circo'			=> 'circo',
	'twopi'			=> 'twopi',
	'fdp', 'sfdp'	=> 'sfdp',
	'osage'			=> 'osage',
	default			=> 'dot'
};

$gv_settings['bin'] = $gv_settings['bindir'] . $bin;

// write graphviz code to temporary text-file
$tmpname	= tempnam ($gv_settings['filedir'], 'temp');
$tmpfile	= fopen($tmpname, 'w');

fwrite($tmpfile, $text);
fclose($tmpfile);
#$mime_type	= mime_content_type($src);

// check who u are, can u upload?
if ($user = $this->get_user())
{
	$user_id	= $user['user_id'];
}
else
{
	$user_id	= 0;
}

// check user and upload access
if(!$this->check_acl($user, $this->db->upload))
{
	echo $this->_t('UploadForbidden');
}
else
{
	### here starts the big code block ###

	// step 1: convert the source-code to generated source code
	$cmd	= $gv_settings['bin'] . " -Tdot -o$tmpname.dot $tmpname 2>&1";
	$cmdOut	= `{$cmd}`;

	if ($cmdOut != '')
	{
		echo '<i>' . $cmdOut . '</i><br/>';
		unlink($tmpname);
	}
	else
	{
		// extract the name of the graph (second string in first line)
		$gname		= file ("$tmpname.dot");
		$gname		= explode(' ', $gname[0]);
		$gname		= strtolower($gname[1]);
		// the basename is generated in the same way as the upload-handler do this
		$fname		= $gv_settings['filedir'] . '/@' . $this->get_page_id() . '@' . $gname;

		// step 2: prepare and run the image command and put the image in the upload dir and database
		$imagecmd	= $gv_settings['bin'] . ' -Tpng -o $fname.png $tmpname.dot';
		$cmdOut		= `{$imagecmd}`;

		// delelte dublicate images
		if (count($this->db->load_single(
			"SELECT upload_id " .
			"FROM " . $this->prefix . "file " .
			"WHERE page_id		= " . (int) $this->get_page_id() . " " .
			"AND file_name		= " . $this->db->q($gname . '.png') . "")) > 0)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->prefix . "file " .
				"WHERE page_id		= " . (int) $this->get_page_id() . " " .
				"AND file_name		= " . $this->db->q($gname . '.png'));
		}

		$imgurl		= $this->db->base_path . $this->page['tag'] . '/file?get=' . $gname . '.png';
		$imagesize	= getimagesize ($fname . '.png');

		$this->db->sql_query(
			"INSERT INTO " . $this->prefix . "file SET " .
				"page_id			= " . (int) $this->get_page_id() . ", " .
				"user_id			= " . (int) $user_id . ", " .
				"file_name			= " . $this->db->q($gname . '.png') ."', " .
				"file_lang			= " . $this->db->q($this->page_lang) . ", " .
				"file_description	= " . $this->db->q($bin . 'created image (' . date('Y-m-d H:i:s') . ' ' . $imagesize[0] . 'x' . $imagesize[1] . ')' ) . ", " .
				"file_size			= " . (int) filesize($fname . '.png') . ", " .
				"picture_w			= " . (int) $imagesize[0] . ", " .
				"picture_h			= " . (int) $imagesize[1] . ", " .
				"file_ext			= " . $this->db->q('png') . ", ".
				"mime_type			= " . $this->db->q($mime_type) . "," .
				"created			= UTC_TIMESTAMP(), " .
				"modified			= UTC_TIMESTAMP()");

		// step 3: prepare and run the map command
		$mapcmd		= $gv_settings['bin'] . " -Tcmap $tmpname.dot";
		$map		= `{$mapcmd}`;

		if ($map != '')
		{
			$map = iconv('utf-8', $this->get_charset(), $map);

			// output with image map
			echo '<map name="' . $gname . '">' . $map . '</map>';
		}

		echo '<img border="0" usemap="#' . $gname . '" ' . $imagesize[3] . ' src="' . $imgurl . '">' . "\n";

		// clear the directory and vars
		unset($cmdOut); // maybe this can cause trouble if un-unsetted
		unlink($tmpname);
		unlink($tmpname . '.dot');
	}
} ### here ends the big code block ###
