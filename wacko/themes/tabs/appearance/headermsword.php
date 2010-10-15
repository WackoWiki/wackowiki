<?php
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<title><?php echo $this->GetWakkaName()." : ".$this->GetPageTag(); ?></title>
<?php // do not index alternative print pages
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<meta name="keywords" content="<?php echo $this->GetConfigValue("meta_keywords") ?>" />
<meta name="description" content="<?php echo $this->GetConfigValue("meta_description") ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/msword.css" />
</head>

<body>

<div class="header">
<h1><?php echo $this->config["wakka_name"] ?>: <?php echo $this->ComposeLinkToPage($this->NpjTranslit($this->GetPageTag()), "", $this->GetPageTag()); ?>
(<?php echo $this->GetResourceValue("MsWordVersion");?>)</h1>
</div>