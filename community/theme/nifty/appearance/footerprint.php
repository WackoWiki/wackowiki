<div id="footer">
	&copy; <?php echo date("Y"); ?> &quot;<?php echo $this->db->site_name; ?>&quot;.
	<?php echo $this->_t('StandardTerms'); ?>: <a href="<?php echo htmlspecialchars($this->href('', $this->db->policy_page), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>"><?php echo $this->db->base_url . $this->db->policy_page; ?></a>
</div>
<?php
// Don't place final </body></html> here. Wacko closes HTML automatically.
?>