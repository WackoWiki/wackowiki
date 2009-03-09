<?php
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title><?php echo $this->GetWackoName()." : ".$this->GetPageTag(); ?></title>
<?php if ($this->GetMethod() != 'show')
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta http-equiv="content-type"
	content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<meta name="keywords"
	content="<?php echo $this->GetConfigValue("meta_keywords") ?>" />
<meta name="description"
	content="<?php echo $this->GetConfigValue("meta_description") ?>" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->GetConfigValue("theme_url") ?>css/msword.css" />
</head>

<body>

<div class="header">
<h1><?php echo $this->config["wacko_name"] ?>: <a
	href="<?php echo $this->config["base_url"] ?>TextSearch?phrase=<?php echo urlencode($this->GetPageTag()); ?>"><?php echo $this->GetPageTag(); ?></a>
</h1>
</div>