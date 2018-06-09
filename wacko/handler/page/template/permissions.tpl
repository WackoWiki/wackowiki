[ === main === ]

	<h3>[ ' title ' ]</h3>

	<form action="[ ' href: permissions ' ]" method="post" name="set_permissions">
		[ ' csrf: set_permissions ' ]
		<input type="checkbox" id="massacls" name="massacls">
		<label for="massacls">[ ' _t: AclForEntireCluster ' ]</label>
		<br>
		<div class="cssform">
			<p>
				<label for="read_acl"><strong>[ ' _t: ACLRead ' ]</strong></label>
				<textarea id="read_acl" name="read_acl" rows="4" cols="20">[ ' read | pre ' ]</textarea>
			</p>
			<p>
				<label for="write_acl"><strong>[ ' _t: ACLWrite ' ]</strong></label>
				<textarea id="write_acl" name="write_acl" rows="4" cols="20">[ ' write | pre ' ]</textarea>
			</p>
			<p>
				<label for="comment_acl"><strong>[ ' _t: ACLComment ' ]</strong></label>
				<textarea id="comment_acl" name="comment_acl" rows="4" cols="20">[ ' comment | pre ' ]</textarea>
			</p>
			<p>
				<label for="create_acl"><strong>[ ' _t: ACLCreate ' ]</strong></label>
				<textarea id="create_acl" name="create_acl" rows="4" cols="20">[ ' create | pre ' ]</textarea>
			</p>
			[= u _ =
				<p>
					<label for="upload_acl"><strong>[ ' _t: ACLUpload ' ]</strong></label>
					<textarea id="upload_acl" name="upload_acl" rows="4" cols="20">[ ' upload | pre ' ]</textarea>
				</p>
			=]
			<p>
				<label for="new_owner_id"><strong>[ ' _t: SetOwner ' ]</strong></label>
				<select id="new_owner_id" name="new_owner_id">
					<option value="">[ ' _t: OwnerDontChange ' ]</option>
					[= l _ =
						<option value="[ ' user.user_id | e attr ' ]">[ ' user.user_name | e ' ]</option>
					=]
				</select>
			</p>
			<p>
				<input type="submit" class="OkBtn" id="submit" value="[ ' _t: ACLStoreButton ' ]" accesskey="s"> &nbsp;
				<a href="[ ' href: ' ]" class="btn_link"><input type="button" class="CancelBtn" id="button" value="[ ' _t: ACLCancelButton ' ]"/></a>
			</p>
		</div>
	</form>
