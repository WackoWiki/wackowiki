[ === main === ]
	<!--notypo-->
	[= closed _ =
		<div class="msg hint">[ ' _t: RegistrationClosed ' ]</div>
	=]
	[= r _ =
		<div class="cssform">
		[= approve _ =
			<div class="msg hint">[ ' _t: UserApprovalInfo ' ]</div>
		=]
		<form action="[ ' form ' ]" method="post" name="register">
			[ ' csrf:  register ' ]
			<h3>[ ' _t: RegistrationWelcome ' ]</h3>
			[= multi _ =
				<p><label for="user_lang">[ ' _t: RegistrationLang ' ]:</label>
				<select id="user_lang" name="user_lang">
				[= l _ =
					<option value="[ ' lang | e attr ' ]"[ ' selected | format ' selected' ' ]>[ ' name ' ] ([ ' lang | e ' ])</option>
				=]
				</select></p>
			=]
			[ ' autocomplete ' ]
			<p><label for="user_name">[ ' _t: UserName ' ]:</label>
			<input type="text" id="user_name" name="user_name" size="25" minlength="[ ' db: username_chars_min ' ]" maxlength="[ ' db: username_chars_max ' ]" value="[ ' username | e attr ' ]" pattern="[ ' pattern | e attr ' ]" title="[ ' only | e attr ' ]" autocomplete="off" required autofocus></p>
			<p>[ ' only ' ]</p>

			<p><label for="password">[ ' _t: RegistrationPassword ' ]:</label>
			<input type="password" id="password" name="password" size="24" minlength="[ ' db: pwd_min_chars ' ]" value="[ ' password | e attr ' ]" autocomplete="off" required>
			</p>

			<p><label for="conf_password">[ ' _t: ConfirmPassword ' ]:</label>
			<input type="password" id="conf_password" name="conf_password" size="24" minlength="[ ' db: pwd_min_chars ' ]" value="[ ' confpassword | e attr ' ]" autocomplete="off" required></p>
			<p>[ ' complexity ' ]</p>

			<p>
			<label for="email">[ ' _t: Email ' ]:</label>
			<input type="email" id="email" name="email" size="30" value="[ ' email | e attr ' ]" required>
			<small> <a title="[ ' _t: RegistrationEmailInfo ' ]">(?)</a></small></p>

			[= terms _ =
				<p>
				<label for="terms_of_use">[ ' _t: TermsOfUse ' ]:</label>
				<input type="checkbox" id="terms_of_use" name="terms_of_use" value="1">
				<small> [ ' _t: AcceptTermsOfUse ' ] [ ' db: site_name | e ' ] <a href="[ ' href ' ]">[ ' _t: TermsOfUse ' ]</a><br></small></p>
			=]
			[= captcha _ =
				<p>[ ' show ' ]</p>
			=]
			<p><input type="submit" class="OkBtn" value="[ ' _t: RegistrationButton ' ]"></p>
		</form>
		</div>
	=]
	<!--/notypo-->
