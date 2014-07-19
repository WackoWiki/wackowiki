<?php
header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title><?php echo htmlspecialchars($this->config['site_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)." : ".(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>

</head>

<body>



<div class="">
