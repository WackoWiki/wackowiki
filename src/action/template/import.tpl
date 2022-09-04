[ === main === ]
	[= f _ =
		<div class="msg warning">[ ' hint ' ]</div><br>
		<form action="[ ' href: ' ]" method="post" name="import_xml" enctype="multipart/form-data">
			[ ' csrf: import_xml ' ]
			<div class="cssform">
				<p>
					<label for="importto">[ ' _t: ImportTo ' ]</label>
					<input type="text" id="importto" name="_to" size="40" value="" required>
				</p>
				<p>
					<label for="importwhat">[ ' _t: ImportWhat ' ]</label>
					<input type="file" id="importwhat" name="_import" accept=".xml,text/xml" required>
				</p>
				<p>
					<button type="submit">[ ' _t: ImportButton ' ]</button>
				</p>
			</div>
		</form>
	=]
	[= i _ =
		<div class="msg success">
			<em>[ ' _t: ImportSuccess ' ]</em><br>
			<ol>
				[= l _ =
					<li>[ ' page ' ]</li>
				=]
			</ol>
		</div>
	=]
