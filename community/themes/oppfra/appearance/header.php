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
	<li><?php echo $this->compose_link_to_page($this->config['root_page']);?>:</li>   <li><?php echo $this->get_page_path(); ?></li>
	<li><a title="<?php echo $this->get_translation('SearchTitleTip')?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a></li>
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
	echo "<div class=\"info\">$message</div>";
}
?>
<div class="article_inner">