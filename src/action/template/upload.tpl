[ === main === ]
	[ ' help ' ]
	[ ' message ' ]
	[= u _ =
		<form action="[ ' href: upload ' ]" method="post" name="upload" enctype="multipart/form-data" data-base-path="[ ' basepath ' ]">
			[ ' csrf: upload ' ]
			<input type="hidden" name="upload" value="1">
			[= s _ =
				<input type="hidden" name="maxsize" value="[ ' maxsize ' ]">
			=]
			<input type="hidden" name="MAX_FILE_SIZE" value="[ ' maxfilesize ' ]">

			<!-- Tabs: AJAX (modern) vs Classic (no-JS fallback) -->
			<div class="upload-tabs">
				<button type="button" class="tab-btn" data-tab="ajax">JavaScript</button>
				<button type="button" class="tab-btn active" data-tab="classic">Classic</button>
			</div>

			<!-- AJAX Tab - hidden by default (for no-JS fallback) -->
			<div id="tab-ajax" class="upload-tab-content hidden">
				<div class="upload-dropzone" aria-label="Drop files here to upload - multiple files supported">
					<div class="dropzone-inner">
						<p><strong>Drop files here to upload</strong></p>
						<!-- Multiple files supported • Paste from clipboard (Ctrl+V) -->
						<p class="msg hint">[ ' _t: UploadMax ' ] [ ' size ' ]</p>
						<button type="button" class="btn-select-files">Select files</button>

						<div class="upload-location">
							<label class="radio-line"><input type="radio" name="upload_to" value="local" checked> [ ' _t: UploadLocalText ' ]</label>
							<label class="radio-line"><input type="radio" name="upload_to" value="global"> [ ' _t: UploadGlobalText ' ]</label>
						</div>
					</div>
				</div>

				<!-- Status list will be inserted here by JS -->
				<div class="upload-status-list"></div>
			</div>

			<!-- Classic Tab - visible by default (no-JS) -->
			<div id="tab-classic" class="upload-tab-content">
			<table class="upload-table">
				<tr>
					<th>
						<label for="file_upload">[ ' _t: UploadFor ' ]&nbsp;</label>
					</th>
					<td class="nowrap">
						<input type="file" name="file" id="file_upload" [ ' accecpt ' ] required>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="msg hint">
						[ ' _t: UploadMax ' ] [ ' size ' ]<br>
						[= d _ =
							<details>
								<summary>[ ' _t: PermittedFiletype ' ]</summary>
								[ ' allowed | e ' ]
							</details>
						=]
					</td>
				</tr>
				[= global _ =
					<tr>
						<td></td>
						<td>
							<input type="radio" name="_upload_to" disabled checked value="global" id="upload_global_disabled">
							<input type="hidden" name="upload_to" value="global"> [ ' _t: UploadGlobalText ' ]
						</td>
					</tr>
				=]
				[= local _ =
					<tr>
						<td></td>
						<td>
							<input type="radio" name="upload_to" id="upload_global" value="global">
							<label for="upload_global">[ ' _t: UploadGlobalText ' ]</label><br>
							<input type="radio" name="upload_to" id="upload_local" value="local" checked>
							<label for="upload_local">[ ' _t: UploadLocalText ' ]</label>
						</td>
					</tr>
				=]
				[= rename _ =
					[ ' // optional ' ]
					<tr>
						<th>
							<label for="upload_dest_file">[ ' _t: UploadAsName ' ]</label>
						</th>
						<td>
							<input type="text" name="file_dest_name" id="upload_dest_file" size="80" maxlength="250" value="">
						</td>
					</tr>
				=]
				[= desc _ =
					<tr>
						<th>
							<label for="upload_desc">[ ' _t: FileDesc ' ]</label>
						</th>
						<td>
							<textarea type="text" name="file_description" id="upload_desc" class="cols-80" cols="80" rows="6" maxlength="250"></textarea>
						</td>
					</tr>
				=]
				<tr>
					<td></td>
					<td>
						<input type="checkbox" name="file_overwrite" id="upload_overwrite" value="1">
						<label for="upload_overwrite">[ ' _t: UploadOverwrite ' ]</label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit">[ ' _t: UploadButton ' ]</button>
					</td>
				</tr>
			</table>
			</div>
			<noscript>
				<div class="errorbox-js">
					<strong>JavaScript is disabled.</strong><br>
					The modern drag & drop upload is not available.<br>
					Please use the <strong>Single File Upload (Classic)</strong> option above.
				</div>
			</noscript>
		</form>
		
	=]
