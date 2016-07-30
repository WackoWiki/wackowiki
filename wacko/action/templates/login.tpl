
[ === main === ]
	<!--notypo-->
	[= u LogoutForm =
		<form action="[ ' href | ' ]" method="get" name="logout">
			[ ' href | hide_page | ' ]
			<input type="hidden" name="action" value="logout" />
			<div class="cssform">
				<h3>[ ' _t: Hello ' ], [ ' link | ' ]!</h3>
				<p>
					<a href="[ ' logout | ' ]" style="text-decoration: none;"><input type="button" class="CancelBtn" value="[ ' _t: LogoutButton ' ]"/></a>
				</p>
				<p>
					[ ' account | ' ] | <a href="[ ' cookies | ' ]">[ ' _t: ClearCookies ' ]</a>
				</p>
			</div>
		</form>
	=]
	[= l LoginForm =
		[= toomuch _ =
			<div class="error">[ ' _t: LoginAttemtsExceeded | ' ]</div>
		=]
		<div class="cssform">
		<h3>[ ' _t: LoginWelcome ' ]</h3>

		<form action="[ ' href | ' ]" method="post" name="login">
			[' csrf: login | ']
			<p>
				<label for="user_name">[ ' format_t: LoginName | ' ]:</label>
				<input type="text" id="user_name" name="user_name" size="25" maxlength="80" value="[ ' username ' ]" tabindex="1" required autofocus />
			</p>
			<p>
				<label for="password">[ ' _t: LoginPassword ' ]:</label>
				<input type="password" id="password" name="password" size="25" tabindex="2" autocomplete="off" required />
				[== // input.verify -> display: none --- anti-bot dummy field feature ==]
				<input type="text" id="email" name="email" class="verify" />
			</p>
			<p>
				<input type="checkbox" id="persistent" name="persistent" tabindex="3"/>
				<label for="persistent">[ ' _t: PersistentCookie ' ]</label>
			</p>
			[= show _ =
				<p>
					[ ' captcha | ' ]
				</p>
			=]
			<p>
				<input type="submit" class="OkBtn" value="[ ' _t: LoginButton ' ]" tabindex="4" />
			</p>
			<p>[ ' format_t: ForgotLink | ' ]</p>
			[= welcome _ =
				<p>[ ' format_t: LoginWelcome2 | ' ]</p>
			=]
		</form>
		</div>
	=]
	<!--/notypo-->
