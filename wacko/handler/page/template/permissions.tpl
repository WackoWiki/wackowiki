[ === main === ]

	<h3>[ ' title ' ]</h3>
	
	<div class="">
	<form action="[ ' href: permissions ' ]" method="post" name="set_permissions">
		[ ' csrf: set_permissions ' ]
		
		<br>
		<table class="form-tbl">
			<colgroup>
				<col span="1" width="10%">
				<col span="1" width="70%">
			</colgroup>
			<tbody>
				
				<tr>
					<th scope="row">
						<label for="read_acl">[ ' _t: AclRead ' ]</label>
					</th>
					<td>
						<textarea id="read_acl" name="read_acl" rows="4" cols="20">[ ' read | pre ' ]</textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="write_acl">[ ' _t: AclWrite ' ]</label>
					</th>
					<td>
						<textarea id="write_acl" name="write_acl" rows="4" cols="20">[ ' write | pre ' ]</textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="comment_acl">[ ' _t: AclComment ' ]</label>
					</th>
					<td>
						<textarea id="comment_acl" name="comment_acl" rows="4" cols="20">[ ' comment | pre ' ]</textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="create_acl">[ ' _t: AclCreate ' ]</label>
					</th>
					<td>
						<textarea id="create_acl" name="create_acl" rows="4" cols="20">[ ' create | pre ' ]</textarea>
					</td>
				</tr>
				[= u _ =
					<tr>
						<th scope="row">
							<label for="upload_acl">[ ' _t: AclUpload ' ]</label>
						</th>
						<td>
							<textarea id="upload_acl" name="upload_acl" rows="4" cols="20">[ ' upload | pre ' ]</textarea>
						</td>
					</tr>
				=]
				<tr>
					<th scope="row">
					</th>
					<td>
						<input type="checkbox" id="massacls" name="massacls">
						<label for="massacls">[ ' _t: AclForEntireCluster ' ]</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
					</th>
					<td>
						<div class="msg hint">[ ' _t: AclHelp ' ]</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="new_owner_id">[ ' _t: SetOwner ' ]</label>
					</th>
					<td>
						<select id="new_owner_id" name="new_owner_id">
							<option value="">[ ' _t: OwnerDontChange ' ]</option>
							[= l _ =
								<option value="[ ' user.user_id | e attr ' ]">[ ' user.user_name | e ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
					</th>
					<td>
						<br>
						<input type="submit" class="OkBtn" id="submit" value="[ ' _t: SaveButton ' ]" accesskey="s"> &nbsp;
						<a href="[ ' href: ' ]" class="btn-link"><input type="button" class="CancelBtn" id="button" value="[ ' _t: CancelButton ' ]"/></a>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</form>
