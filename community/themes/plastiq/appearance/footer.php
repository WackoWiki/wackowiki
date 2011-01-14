
<!-- end page output -->
						</div></div>
					</td>
				</tr>
				<tr>
					<td height="25" colspan="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="25" height="25" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botleft.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="25" height="1" /></td>
								<td width="100%" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botmid.png); background-repeat:repeat-x;"></td>
								<td width="60" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_botright.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="50" height="1" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td rowspan="2" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_4.png);"><div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_right_1.png); background-repeat:no-repeat; height:311px;"></div></td>
	</tr>
	<tr>
		<td height="25" valign="bottom" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_2.png); background-repeat:repeat-y;"><div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_3.png); height:25px;"></div></td>
	</tr>
	<tr>
		<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_0.png); background-repeat:no-repeat;"></td>
		<td colspan="2" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_2.png); background-repeat:repeat-x;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="25" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_1.png); background-repeat:no-repeat;"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="25" height="1" /></td>
					<td>
						<div id="credits">
<?php
							// comment this out for not showing website policy link at the bottom of your pages
							if ($this->config['policy_page']) echo '<a href="'.$this->href('', $this->config['policy_page']).'">'.$this->get_translation('TermsOfUse').'</a><br />';
							 ?>
						</div>
					</td>
					<td width="50" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_3.png); background-repeat:no-repeat;"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="25" height="1" /></td>
				</tr>
			</table>
		</td>
		<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_bottom_4.png);"></td>
	</tr>
</table>
<?php // do not place closing <body> and <html> tags
       // here - Wacko does this automatically ?>
