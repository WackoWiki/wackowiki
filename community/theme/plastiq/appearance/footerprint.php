
<!-- end page output -->
</div>
<div id="footer">
	&copy; <?php echo date('Y'); ?> &quot;<?php echo $this->db->site_name; ?>&quot;.
	<?php echo $this->_t('TermsOfUse');?>: <a href="<?php echo htmlspecialchars($this->href('', $this->db->terms_page), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>"><?php echo $this->db->base_url . $this->db->terms_page; ?></a>
</div>
<?php // do not place closing <body> and <html> tags
       // here - Wacko does this automatically ?>
