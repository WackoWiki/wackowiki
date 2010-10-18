<?php
header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title><?php echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>
<style type="text/css"><!--
body {
	background-color:	#fff;
	color:			#000;
	font-family:		Verdana, "Bitstream Vera Sans", sans, sans-serif;
	font-size:		small;
	margin:			20px;
}
.hidecontent {
	display:		none;
}
//--></style>
</head>

<body>

<b>Ever heard of OpenOffice.org?</b><br />
<br />
OpenOffice.org is a multiplatform and multilingual office suite and an
open-source project. Compatible with all other major office suites, the product
is free to download, use, and distribute.<br />
<br />
Better use the <a href="http://www.openoffice.org/">OpenOffice Suite</a>
instead of <a href="http://slashdot.org/articles/00/05/02/158204.shtml?tid=109">
Microsoft Office</a>!

<div class="hidecontent">
