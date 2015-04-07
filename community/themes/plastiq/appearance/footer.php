
<!-- end page output -->
						</div></div>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="height:25;">
						<table style="width:100%;">
							<tr>
								<td style="width:25; height:25; background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botleft.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.png" width="25" height="1" /></td>
								<td style="width:100%; background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botmid.png); background-repeat:repeat-x;"></td>
								<td style="width:60; background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botright.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.png" width="50" height="1" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td rowspan="2" style="vertical-align:top; background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_4.png);"><div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_right_1.png); background-repeat:no-repeat; height:311px;"></div></td>
	</tr>
	<tr>
		<td style="height:25; vertical-align:bottom; background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_2.png); background-repeat:repeat-y;"><div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_3.png); height:25px;"></div></td>
	</tr>
	<tr>
		<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_0.png); background-repeat:no-repeat;"></td>
		<td colspan="2" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_2.png); background-repeat:repeat-x;">
			<table style="width:100%;">
				<tr>
					<td style="width:25; background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_1.png); background-repeat:no-repeat;"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.png" width="25" height="1" /></td>
					<td>
						<div id="credits">
<?php
							// comment this out for not showing website policy link at the bottom of your pages
							if ($this->config['policy_page']) echo '<a href="'.$this->href('', $this->config['policy_page']).'">'.$this->get_translation('TermsOfUse').'</a><br />';
							 ?>
						</div>
					</td>
					<td style="width:50; background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_3.png); background-repeat:no-repeat;"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.png" width="25" height="1" /></td>
				</tr>
			</table>
		</td>
		<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_4.png);"></td>
	</tr>
</table>
<?php // do not place closing <body> and <html> tags
       // here - Wacko does this automatically ?>
