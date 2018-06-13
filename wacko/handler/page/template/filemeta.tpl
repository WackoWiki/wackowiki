[ === main === ]
	[ ' navigation ' ]
	<h3>[ ' _t: File ' ] &raquo; [ ' mode ' ]</h3>
	[ ' tabs ' ]
	<br>
	[= r _ =
		<div class="fileinfo">
			<h4>[ ' link ' ]</h4>
			<form action="[ ' href: filemeta ' ]" method="post" name="remove_file">
			[ ' csrf: remove_file ' ]
			<table class="upload tbl_fixed">
				<tr>
					<th scope="row">[ ' _t: FileDesc ' ]:</th>
					<td>[ ' file.file_description ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileSize ' ]:</th>
					<td>[ ' size ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UploadBy ' ]:</th>
					<td>[ ' user ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileAdded ' ]:</th>
					<td>[ ' file.uploaded_dt | time_formatted ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileAttachedTo ' ]:</th>
					<td>[ ' location ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileUsage ' ]:</th>
					<td>[ ' fileusage ' ]</td>
				</tr>
			</table>
			[ ' notice ' ]

			<br>
			<input type="hidden" name="remove" value="">
			<input type="hidden" name="file_id" value="[ ' file.file_id | e attr ' ]">
			[= dontkeep _ =
				<input type="checkbox" id="dontkeep" name="dontkeep">
				<label for="dontkeep">[ ' _t: RemoveDontKeepFile ' ]</label><br>
				<br>
			=]

			<input type="submit" class="OkBtn" name="submit" value="[ ' _t: RemoveButton ' ]">
			&nbsp;
			<a href="[ ' href: ' ]" class="btn_link">
				<input type="button" class="CancelBtn" value="[ ' _t: EditCancelButton ' ]">
			</a>
			<br>
			<br>
		</form>
		</div>
	=]
	[= l _ =
		<h4>[ ' link ' ]</h4>
		
		<form action="[ ' href: filemeta ' ]" method="post" name="assign_categories">
			[ ' csrf: assign_categories ' ]
			[ ' category ' ]
			<input type="hidden" name="label" value="">
			<input type="hidden" name="file_id" value="[ ' fileid ' ]">
		</form>
	=]
	[= s _ =
		<div class="fileinfo">
			<h4>[ ' link ' ]</h4>
			[= i _ =
				<span class="show-image"><a href="[ ' href ' ]">[ ' image ' ]</a></span>
			=]
			<table class="upload tbl_fixed">
				<tr>
					<th scope="row">[ ' _t: FileSyntax ' ]:</th>
					<td><code>[ ' syntax ' ]</code></td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileDesc ' ]:</th>
					<td><strong>[ ' desc ' ]</strong></td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileCaption ' ]:</th>
					<td>[ ' caption | nl2br ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileSize ' ]:</th>
					<td>[ ' size ' ]</td>
				</tr>
				[= p _ =
					<tr>
						<th scope="row">[ ' _t: FileDimension ' ]:</th>
						<td>[ ' width | number 0 , . ' ' ] &times; [ ' height | number 0 , . ' ' ] px</td>
					</tr>
				=]
				<tr>
					<th scope="row">[ ' _t: MimeType ' ]:</th>
					<td>[ ' mime ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UploadBy ' ]:</th>
					<td>[ ' user ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileAdded ' ]:</th>
					<td>[ ' time ' ]</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				[= l _ =
					<tr>
						<th scope="row">[ ' _t: License ' ]:</th>
						<td>[ ' license ' ]</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				=]
				<tr>
					<th scope="row">[ ' _t: FileAttachedTo ' ]:</th>
					<td>[ ' location ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: FileUsage ' ]:</th>
					<td>[ ' fileusage ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: Categories ' ]:</th>
					<td>[ ' categories ' ]</td>
				</tr>
			</table>

			<br>
			<a href="[ ' href: ' ]" class="btn_link">
				<input type="button" value="[ ' _t: CancelDifferencesButton ' ]">
			</a>
			<br>
			<br>
		</div>
	=]
	[= e _ =
		<div class="fileinfo">
			<h4>[ ' link ' ]</h4>
			<form action="[ ' href: filemeta ' ]" method="post" name="edit_file">
				[ ' csrf: edit_file ' ]
				<table class="upload">
					<tr>
						<th scope="row">[ ' _t: FileDesc ' ]:</th>
						<td><input type="text" maxlength="250" name="file_description" id="UploadDesc" size="80" value="[ ' desc | e attr ' ]"></td>
					</tr>
					<tr>
						<th scope="row">[ ' _t: FileCaption ' ]:</th>
						<td><textarea id="file_caption" name="caption" rows="6" cols="70">[ ' caption | pre ' ]</textarea></td>
					</tr>
					<tr>
						<th scope="row">
							<label for="license">[ ' _t: License ' ]</label>
						</th>
						<td>
							[ ' license ' ]
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="file_lang">[ ' _t: YourLanguage ' ]</label>
						</th>
						<td>
							[ ' lang ' ]
						</td>
					</tr>
				</table>
				<br>
				<input type="hidden" name="edit" value="">
				<input type="hidden" name="file_id" value="[ ' fileid ' ]">
				<input type="submit" class="OkBtn" name="submit" value="[ ' _t: EditStoreButton ' ]">
				&nbsp;
				<a href="[ ' href: ' ]" class="btn_link">
					<input type="button" class="CancelBtn" value="[ ' _t: EditCancelButton ' ]">
				</a>
				<br>
				<br>
			</form>
		</div>
	=]

		