<?php

if ($lock_file)
{
	if (!isset($error))
	{
		echo '<div class="msg warning">' . _t('LockedTryLater') . '</div>';
	}
	else
	{
		echo '<div class="msg security">' . _t('LockPasswordInvalid') . '</div>';
	}
	?>
	<div id="loginbox">
		<strong><?php echo _t('LockAuthorization');?></strong><br>
		<?php echo Ut::perc_replace(_t('LockAuthorizationInfo'), '<code>' . SETUP_LOCK . '</code>');?>
		<br><br>
		<form method="post" name="installer_auth">
			<input type="hidden" name="setup_auth" value="1"><br>
			<label for="setup_password"><strong><?php echo _t('LockPassword');?></strong></label>
			<input type="password" id="setup_password" name="password" required>
			<button type="submit" value="Login"><?php echo _t('LockLogin');?></button><br>
		</form>
	</div>
	<?php
}
else
{
	echo
		'<div class="msg security">' .
			Ut::perc_replace(_t('EmptyAuthFile'), '<code>' . SETUP_LOCK . '</code>') .
		'</div>';
}