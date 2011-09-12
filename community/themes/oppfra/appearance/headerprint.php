<?php
  header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <title><?php echo htmlspecialchars($this->config['site_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>
<meta name="robots" content="noindex, nofollow" />
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
  <meta name="keywords" content="<?php echo $this->config['meta_keywords'] ?>" />
  <meta name="description" content="<?php echo $this->config['meta_description'] ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
</head>

<body>
<!--BEGINN: SEITE-->
<div id="page"><div class="header">
  <h1>
  <?php echo file_exists("images/".$this->config['site_name'].".png")?"<img src='/images/".$this->config['site_name'].".png' alt='".$this->config['site_name']."' />":$this->config["site_name"] ?> : <?php echo $this->tag ?>
  </h1>
</div>

