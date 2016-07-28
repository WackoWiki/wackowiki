<?php
header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html>

<html>
<head>
<title><?php echo htmlspecialchars(($this->db->site_name).' : '.(isset($this->page['title']) ? $this->page['title'] : $this->tag), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?></title>
<?php // do not index alternative print pages
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta charset="<?php echo $this->get_charset(); ?>" />
<meta name="keywords" content="<?php echo $this->db->meta_keywords ?>" />
<meta name="description" content="<?php echo $this->db->meta_description ?>" />
<link rel="stylesheet" href="<?php echo $this->db->theme_url ?>css/msword.css" />
</head>

<body>

<div class="header">
<h1><?php echo $this->db->site_name.': '.(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?>
</h1>
</div>