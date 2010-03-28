<?php
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<title><?php echo $this->GetWackoName()." : ".$this->GetPageTag(); ?></title>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/print.css" />

<link rel="start" href="/" />
<link rel="prev" href="<?php echo $this->href() ?>" />
</head>
<body id="print">
<div id="header">
	<div class="container">
		<?php // Print wackoname and wackopath ?>
		<h1><?php echo $this->config["wacko_name"]; ?>: <?php echo $this->GetPagePath(); ?></h1>
		<a href="/"><?php echo rtrim($this->config["base_url"], "/"); ?></a><?php if ($this->page) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->GetTranslation("Version").": ".$this->GetPageTimeFormatted(); } ?><br />
		<?php echo $this->GetPagePath() ?><br />
	</div>
</div>
<!-- End of header //-->
