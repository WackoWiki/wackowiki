<?php
/*
Oppfra theme.
Common header file.
*/

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<body>
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
<div class="cap" id="menu"><img src="<?php echo $this->db->theme_url ?>icon/logo.png" alt="alternativ Text" align="middle" />

</div>
<!--ENDE: MENUE-->

<!--BEGINN: INHALT-->
<div id="content">
<?php
// here we show messages
$this->output_messages();
?>
<div class="article_inner">
