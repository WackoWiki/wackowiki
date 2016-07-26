
[ === main === ]
	[= generated =
		<div class="notice">
			'recovery_password' => '[ ' hash ' ]',<br /><br />
		</div>
	=]

	<h2>Generate the password hash for your recovery_password</h2>

	<form action="[ ' href | e html_attr ' ]" method="post" name="generate_hash">
		['' // hide_page: | '']
		['' csrf: generate_hash | '']

		<p><label for="password">[ ' _t: RegistrationPassword ' ]:</label>
		<input type="password" id="recovery_password" name="recovery_password" size="24" value="[ ' password ' ]" />

		['' complexity | '']
		</p>

		<p><label for="confpassword">[ ' _t: ConfirmPassword ' ]:</label>
		<input type="password" id="confpassword" name="confpassword" size="24" value="[ ' confpassword ' ]" /></p>

		<input type="submit" name="preview" value="[ ' _t: CreatePageButton ' ]" />
	</form>
