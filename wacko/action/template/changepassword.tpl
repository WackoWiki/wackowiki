
[ === main === ]
	<!--notypo-->
	[= c ChangePassword =
		<form action="[ ' form ' ]" method="post" name="change_password">
			[ ' csrf: change_password ' ]
			[ ' autocomplete ' ]
			[= secret _ =
				<input type="hidden" name="secret_code" value="[ ' code | e attr ' ]">
			=]
			<div class="cssform">
				<h3>[ ' title | e ' ]</h3>
				[= current _ =
					<p>
						<label for="password">[ ' _t: CurrentPassword ' ]:</label>
						<input type="password" id="password" name="password" size="24">
					</p>
				=]
				<p>
					<label for="new_password">[ ' _t: NewPassword ' ]:</label>
					<input type="password" id="new_password" name="new_password" minlength="[ ' minchars ' ]" size="24" required autofocus>
				</p>
				<p>
					<label for="conf_password">[ ' _t: ConfirmPassword ']:</label>
					<input type="password" id="conf_password" name="conf_password" minlength="[ ' minchars ' ]" size="24" required>
				</p>
				<p>[ ' complexity ' ]</p>
				<p>
					<input type="submit" class="OkBtn" value="[ ' _t: ChangePasswordButton ' ]">
				</p>
			</div>
		</form>
	=]
	[= f ForgotPassword =
		<form action="[ ' form ' ]" method="post" name="forgot_password">
			[ ' csrf: forgot_password ' ]
			<h3>[ ' format_t: ForgotPassword ' ]</h3>
			<p>[ ' format_t: ForgotPasswordHint ' ]</p>
			<div class="cssform">
			<p>
				<label for="user_name">[ ' format_t: UserName ' ]:</label>
				<input type="text" id="user_name" name="user_name" size="25" minlength="[ ' db: username_chars_min ' ]" maxlength="[ ' db: username_chars_max ' ]" pattern="[ ' pattern | e attr ' ]" title="[ ' only | e attr ' ]" required autofocus><br>
			</p>
			<p>
				<label for="email">[ ' format_t: Email ' ]:</label>
				<input type="email" id="email" name="email" size="30" required>
			</p>
			<p>
				<input type="submit" class="OkBtn" value="[ ' _t: SendButton ' ]">
			</p>
			</div>
		</form>
	=]
	<!--/notypo-->
