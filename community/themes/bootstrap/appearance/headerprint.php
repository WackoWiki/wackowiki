<?php
header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html>
<html lang="<?php echo $this->page['lang'] ?>">
<head>
<title><?php echo htmlspecialchars(($this->config['site_name']).' : '.(isset($this->page['title']) ? $this->page['title'] : $this->tag), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?></title>
<meta name="robots" content="noindex, nofollow" />
<meta charset="<?php echo $this->get_charset(); ?>" />
<link rel="stylesheet" href="<?php echo $this->config['theme_url'] ?>css/print.css" />

<link rel="start" href="/" />
<link rel="copyright" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
<link rel="prev" href="<?php echo $this->href() ?>" />
</head>
<body id="print">
<div id="header">
	<div class="container">
		<?php // Print wackoname and wackopath ?>
		<h1><?php echo $this->config['site_name']; ?>: <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?></h1>
		<a href="<?php echo $this->config['base_url'] ?>"><?php echo rtrim($this->config['base_url'], "/"); ?></a><?php if ($this->page) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->get_translation('Version').": ".$this->get_page_time_formatted(); } ?><br />
		<?php echo $this->get_page_path() ?><br />
	</div>
</div>
<!-- End of header //-->
