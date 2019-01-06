[ === main === ]
	[ ' message ' ]
	[= u _ =
		<form action="[ ' href: upload ' ]" method="post" name="upload" enctype="multipart/form-data">
			[ ' csrf: upload ' ]
			<input type="hidden" name="upload" value="1">
			[= s _ =
				<input type="hidden" name="maxsize" value="[ ' maxsize ' ]">
			=]
			<input type="hidden" name="MAX_FILE_SIZE" value="[ ' maxfilesize ' ]">
			<table>
				<tr>
					<td>
						<label for="file_upload">[ ' _t: UploadFor ' ]:&nbsp;</label>
					</td>
					<td class="nowrap">
						<input type="file" name="file" id="file_upload" [ ' accecpt ' ]>&nbsp;([ ' _t: UploadMax ' ] [ ' size ' ])
					</td>
				</tr>
				[= global _ =
					<tr>
						<td>&nbsp;</td>
						<td>
							<div>
								<input type="radio" name="_to" disabled checked value="global" id="upload_global_disabled">
								<input type="hidden" name="to" value="global"> [ ' _t: UploadGlobalText ' ]
							</div>
						</td>
					</tr>
				=]
				[= local _ =
					<tr>
						<td>&nbsp;</td>
						<td>
							<div>
								<input type="radio" name="to" value="global" id="upload_global">
								<label for="upload_global">[ ' _t: UploadGlobalText ' ]</label>
							</div>
							<div>
								<input type="radio" name="to" value="here" checked id="upload_to_page">
								<label for="upload_to_page">[ ' _t: UploadHereText ' ]</label>
							</div>
						</td>
					</tr>
				=]
				[= rename _ =
					[ ' // not in use ' ]
					<tr>
						<td class="t-right">
							<label for="upload_dest_file">[ ' _t: UploadAsName ' ]:&nbsp;</label>
						</td>
						<td>
							<input type="text" name="file_dest_name" id="upload_dest_file" size="60" maxlength="250" value="">
						</td>
					</tr>
				=]
				[= desc _ =
					<tr>
						<td class="t-right">
							<label for="upload_desc">[ ' _t: FileDesc ' ]:&nbsp;</label>
						</td>
						<td>
							<input type="text" name="file_description" id="upload_desc" size="60" maxlength="250">
						</td>
					</tr>
				=]
				
				<tr>
					<td class="t-right">
					</td>
					<td>
						<input type="checkbox" name="file_overwrite" id="upload_overwrite" value="1">
						<label for="upload_overwrite">[ ' _t: UploadOverwrite ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div style="padding-top: 5px;">
							<input type="submit" value="[ ' _t: UploadButton ' ]">
						</div>
					</td>
				</tr>
			</table>
			
		</form>
	=]
	