<?php
  header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <title><?php echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>
<?php // do not index alternative print pages
  echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
  <meta name="keywords" content="<?php echo $this->config['meta_keywords'] ?>" />
  <meta name="description" content="<?php echo $this->config['meta_description'] ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
</head>

<body>

<div class="header">
  <h1>
  <?php echo file_exists("images/".$this->config['wacko_name'].".png")?"<img src='/images/".$this->config['wacko_name'].".png' alt='".$this->config['wacko_name']."' />":$this->config['wacko_name'] ?> : <a href="<?php echo $this->config['base_url'] ?>TextSearch?phrase=<?php echo urlencode($this->tag); ?>"><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></a>
  </h1>
</div>