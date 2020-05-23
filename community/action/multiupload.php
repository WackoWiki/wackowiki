<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// action - module for bulk upload files on a wacko wiki site with a record in the database.
// version 0.6.beta
// https://wackowiki.org/doc/Dev/PatchesHacks/MultiUpload

$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/jquery.min.js"></script>');
$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/lang/upload.' . $this->user_lang . '.js"></script>');
$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/upload.js"></script>');
$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->theme_url . 'css/upload.css">');

// TODO:
// Content Security Policy: may prevent the loading of the preview tumbs as data:image/jpeg;base64,
// you need to change the image source directive to: img-src 'self' data:;
// JS routine should do a redirect to reload page
// crashed browser while uploading a stack of large files!!!
// encoding issues with page lang != user lang, eg. en -> ru
// provide dummy preview for non image files
// broken global upload

// check who u are, can u upload?
if ($this->can_upload() === true)
{
	/* Form filling mode. */
	if(!isset($_POST['value']))
	{
		echo '<div class="content">' .
				 '<div id="drop-files" ondragover="return false">' .
					'<form id="frm">' .
						'<input type="file" id="uploadbtn" multiple>' .
					$this->form_close() .
				'</div>' .

				'<div id="uploaded-holder"> ' . "\n" .
					'<div id="dropped-files">' . "\n" .
						'<div id="upload-button">' .
							'<span>' . $this->_t('Files_0') . '</span>' .
							'<a href="#" class="delete"><img src="' . $this->db->theme_url . 'icon/delete.svg"> ' . $this->_t('UploadRemove') . '</a>' .
							'<a href="#" class="upload"><img src="' . $this->db->theme_url . 'icon/upload.svg"> ' . $this->_t('UploadButtonText') . '</a>' .
							'<div id="end_space"></div>' . "\n" .

							'<div id="loading">' . "\n" .
								'<div id="loading-bar">' . "\n" .
									'<div class="loading-color"></div>' . "\n" .
								'</div>' . "\n" .
								'<div id="loading-content"></div>' . "\n" .
							'</div>' . "\n" .
						'</div>' . "\n" .
					'</div>' . "\n" .
				'</div>' . "\n" .
			'</div>' . "\n";
	}
	/* Upload Mode. */
	else
	{
		/* There is some evidence of a global variable Waki. */
		$user_id_this		= $this->page['user_id'];
		$language_this		= $this->page['page_lang'];

		/* We get the data sent with the request http. */
		$file				= $_POST['value'];
		$name				= $_POST['name'];
		$file_description	= $_POST['description_edit'];
		$file_name			= $_POST['name_edit'];
		$file_access		= $_POST['access_edit'];

		#$this->set_message(Ut::debug_print_r($file_access));

		/* We get the file extension. */
		$get_extension		= $this->get_extension($name);

		$extension			= $get_extension;

		// 3. extensions
		$extension			= strtolower($extension);
		$banned				= explode('|', $this->db->upload_banned_exts);

		if (in_array($extension, $banned))
		{
			$extension		= $ext . '.txt';
		}

		/* Home's written there by the file extension in the case of editing the field "filename". */
		$get_extension2		= $this->get_extension($file_name);
		$search_ext			= strtolower($get_extension2);

		/* If you do not write - I add for the user. */
		if($search_ext != $extension)
		{
			$file_name = $file_name . '.' . $extension;
		}

		$src		= $_FILES['file']['tmp_name'];
		$mime_type	= mime_content_type($src);

		#$encoding = 'windows-1251';
		$encoding = $this->get_charset();

		/* File names run, because gibberish no one wants to watch. */
		$file_name = iconv('UTF-8', $encoding . '//TRANSLIT' , $file_name);

		/* We remove all invalid characters from the file name and all the letters of the Russian converted into Latin. */
		$file_name = $this->format($file_name, 'translit');

		$data = explode(',', $file);

		// Decode data encoded to MIME base64
		$encodedData = str_replace(' ', '+', $data[1]);
		$decodedData = base64_decode($encodedData);

		/* Assign the path to save the file on the basis of the user's choice. */
		if($file_access == 'global')
		{
			$upload_dir		= UPLOAD_GLOBAL_DIR . '/';
			$page_id_this	= 0;
			$put_name_file	= $file_name;
		}
		else
		{
			$upload_dir		= UPLOAD_PER_PAGE_DIR . '/';
			$page_id_this	= $this->page['page_id'];
			$put_name_file	= '@' . $page_id_this. '@' . $file_name;
		}

		/* Write files to the appointed place on the server. */
		if(file_put_contents($upload_dir . $put_name_file, $decodedData))
		{

			/* Define the resolution of the pictures, if the picture is loaded. */
			$size_file		= filesize($upload_dir . $put_name_file);
			$size_image		= getimagesize($upload_dir . $put_name_file);

			$width_image	= $size_image[0];
			$height_image	= $size_image[1];

			/* Making an entry in the database. */
			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "file
					(	page_id,
						user_id,
						file_lang,
						uploaded_dt,
						modified_dt,
						file_description,
						file_name,
						file_ext,
						mimetype,
						file_size,
						picture_h,
						picture_w)

					VALUES (
						'$page_id_this',
						'$user_id_this',
						'$language_this',
						UTC_TIMESTAMP(),
						UTC_TIMESTAMP(),
						'$file_description',
						'$file_name',
						'$extension',
						'$mime_type',
						'$size_file',
						'$height_image',
						'$width_image')");

		}
	}
}
?>