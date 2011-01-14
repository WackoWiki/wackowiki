<?php
	header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo htmlspecialchars($this->config['wacko_name']); ?> / <?php echo $this->get_page_path(true) ?> (<?php echo $this->get_translation('PrintVersion');?>)</title>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<!-- style sheets attachment -->
<link href="<?php echo $this->config['theme_url'] ?>css/atom.css" rel="stylesheet" type="text/css" media="screen, print" />
<link href="<?php echo $this->config['theme_url'] ?>css/wacko.css" rel="stylesheet" type="text/css" media="screen, print" />
<link href="<?php echo $this->config['theme_url'] ?>css/print.css" rel="stylesheet" type="text/css" media="screen, print" />
<!-- nav destinations -->
<link rel="start" href="/" />
<link rel="credits" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page'])); ?>" />
<link rel="prev" href="<?php echo $this->href() ?>" />
</head>
<body id="print">
<div id="header">
	<div class="container">
		<h1><?php echo $this->config['wacko_name']; ?></h1>
		<a href="/"><?php echo rtrim($this->config['base_url'], '/'); ?></a><?php if ($this->page) { ?>&nbsp;&nbsp;&nbsp;&nbsp;modified: <?php echo $this->get_page_time_formatted(); } ?><br />
		<?php echo $this->get_page_path() ?><br />
		<a href="<?php echo $this->href() ?>">&laquo; back</a>
	</div>
</div>
<div id="content" style="letter-spacing: normal;">
<!-- begin page output -->

