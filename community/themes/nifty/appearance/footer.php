<?php // nifty theme common footer file ?>

		</div>
		<!-- end: main-content-wrapper -->
	</div>
	<!-- end: content -->

	<div id="footer-wrapper">
		<div class="footer">
			<div class="footerlist">
				<ul>
				<li>
				<?php
				// show permalink
				echo $this->action('permalink');
				?>
				</li>
				</ul>
			</div>
		</div>
		<div id="credits">
		<?php
		// comment this out for not showing website policy link at the bottom of your pages
		if ($this->config['policy_page']) echo '<a href="'.htmlspecialchars($this->href('', $this->config['policy_page'])).'">'.$this->get_translation('StandardTerms').'</a><br />';

		if ($this->get_user())
		{
			echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
		}
		?>
		</div>
	</div>
	<!-- end: footer wrapper -->
</div>
<!-- end: mainwrapper -->

<?php
// Wacko adds a debug div if debug mode is set.
// Also, no need to place a final </body></html> here. Wacko closes html automatically.
?>