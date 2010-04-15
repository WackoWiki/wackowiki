<?php
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<title><?php echo $this->config["wacko_name"]." : ".$this->tag; ?></title>
<?php if ($this->method != 'show')
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta http-equiv="content-type"
	content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config["theme_url"] ?>css/print.css" />
</head>
<body>
<div class="header">
  <?php // Print wackoname and wackopath ?>
  <?php echo $this->config["wacko_name"]; ?>: <?php echo $this->GetPagePath(); ?> </div>
<!-- End of header //-->
