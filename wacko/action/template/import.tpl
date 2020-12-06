[ === main === ]
	[= f _ =
		[ ' hint ' ]<br><br>
		<form action="[ ' href ' ]" method="post" name="import_xml" enctype="multipart/form-data">
			[ ' csrf: import_xml ' ]
			<div class="cssform">
				<p>
					<label for="importto">[ ' _t: ImportTo ' ]:</label>
					<input type="text" id="importto" name="_to" size="40" value="">
				</p>
				<p>
					<label for="importwhat">[ ' _t: ImportWhat ' ]:</label>
					<input type="file" id="importwhat" name="_import">
				</p>
				<p>
					<input type="submit" value="[ ' _t: ImportButton ' ]">
				</p>
			</div>
		</form>
	=]
	[= i _ =
		<div class="msg success">
			<em>[ ' message ' ]</em><br>
			<ol>
				[= l _ =
					<li>[ ' page ' ]</li>
				=]
			</ol>
		</div>
	=]