<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo htmlspecialchars($this->db->site_name, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . " : " . (isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>
	<?php // do not index alternative print pages
	echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";?>
	<meta charset="<?php echo $this->get_charset(); ?>">
	<link rel="stylesheet" href="<?php echo $this->db->theme_url ?>css/print.css">
</head>

<body>
	<div class="header">
		<?php // Print wackoname and wackopath ?>
		<?php echo $this->db->site_name; ?>:
		<?php echo $this->get_page_path(); ?>
	</div>

<!-- End of header //-->
