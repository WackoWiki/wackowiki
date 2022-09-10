[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<div id="page" class="page">
		[ ' message ' ]
		<h3>[ ' _t: EmailPage ' ]</h3>
		<br>
		<form action="[ ' href: sendpage ' ]" method="post" name="send_page">
			[ ' csrf: send_page ' ]
			<label for="email_recipient">[ ' _t: WriteEmail ' ]:</label><br>
			<input type="email" id="email_recipient" name="email" size="60" maxlength="255">
			<button type="submit" id="submit_sendpage">[ ' _t: SendButton ' ]</button>
		</form>
		[ ' data | pre ' ]
	</div>