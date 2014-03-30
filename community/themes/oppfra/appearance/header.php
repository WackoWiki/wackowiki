<?php
/*
Oppfra theme.
Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<!--BEGINN: KOPF-->
<div id="header">
<div class="navigation">
<?php
// Outputs page title
?>
<ul>
	<li><?php echo $this->get_page_path($titles = false, $separator = ' &gt; ', $linking = true, true); ?></li>
</ul>
</div></div>
<!--ENDE: KOPF-->
<!--BEGINN: MENUE-->
<div class="cap" id="menu"><img src="<?php echo $this->config['theme_url'] ?>icons/logo.png" alt="alternativ Text" align="middle" />

</div>
<!--ENDE: MENUE-->

<!--BEGINN: INHALT-->
<div id="content">
<?php
// here we show messages
if ($message = $this->get_message())
{
	$this->show_message($message, 'info');
}
?>
<div class="article_inner">