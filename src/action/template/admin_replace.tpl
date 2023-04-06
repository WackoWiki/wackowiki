[ === main === ]
	<h2>[ ' _t: ReplaceText ' ]</h2>
	[ ' message ' ]<br>
	[= search _ =
		<form action="[ ' href: ' ]" method="post" name="select_pages">
			[ ' csrf: select_pages ' ]
			<label for="text_target">[ ' _t: TextOriginal ' ]</label><br>
			<textarea id="text_target" name="target" class="cols-100" cols="100" rows="5" title="[ ' _t: ReplaceTextGiveTarget ' ]" required>[ ' target | pre ' ]</textarea><br>
			<label for="text_replacement">[ ' _t: TextReplacement ' ]</label><br>
			<textarea id="text_replacement" name="replacement" class="cols-100" cols="100" rows="5">[ ' replacement | pre ' ]</textarea><br>
			<input type="checkbox" id="use_regex" name="use_regex"[ ' regex | format ' checked' ' ]>
			<label for="use_regex">[ ' _t: ReplaceTextRegex ' ]</label><br><br>
			<label for="cluster" title="[ ' _t: ReplaceTextCluster ' ]">[ ' _t: Namespace ' ]</label><br>
			<input type="text" id="cluster" name="page" value="[ ' tag | e attr ' ]" size="80" maxlength="255"><br>
			<input type="checkbox" id="edit_pages" name="edit_pages"[ ' editpages | format ' checked' ' ]>
			<label for="edit_pages">[ ' _t: ReplaceTextEditPages ' ]</label><br>
			<input type="checkbox" id="edit_comments" name="edit_comments"[ ' editcomments | format ' checked' ' ]>
			<label for="edit_comments">[ ' _t: ReplaceTextEditComments ' ]</label><br>
			<input type="checkbox" id="edit_titles" name="edit_titles"[ ' edittitles | format ' checked' ' ]>
			<label for="edit_titles">[ ' _t: ReplaceTextEditTitles ' ]</label><br><br>
			[= options _ =
				<details open>
					<summary>[ ' _t: OptionalFilters ' ]</summary>
					<div class="form-options">
				[= l _ =
					<label for="language">[ ' _t: AccountLanguage ' ]</label><br>
					<select id="language" name="lang">
						<option value=""[ ' selected ' ]>[ ' _t: Any ' ]</option>
						[= o _ =
							<option value="[ ' iso ' ]"[ ' selected ' ]>[ ' lang ' ] ([ ' iso ' ])</option>
						=]
					</select><br>
				=]
				[= c _ =
					<br>[ ' _t: Categories ' ]:
					[ ' categories ' ]
				=]
				</div>
				</details><br>
			=]
			[= n _ =
				<label for="edit_note">[ ' _t: EditNote ' ]</label><br>
				<input type="text" id="edit_note" name="edit_note" value="[ ' note | e attr ' ]" size="80" maxlength="255"><br>
			=]
			[= minor _ =
				<input type="checkbox" id="minor_edit" name="minor_edit"[ ' minor | format ' checked' ' ]>
				<label for="minor_edit">[ ' _t: EditMinor ' ]</label>
				<br>
			=]
			<br>
			<button type="submit" class="btn-ok">[ ' _t: ContinueButton ' ]</button>&nbsp;
			[ '' cancel '' ]<br>
		</form>
		<br>
	=]
	[= select _ =
		<form action="[ ' href: ' ]" method="post" id="replace_text" name="replace_text">
		[ ' csrf: replace_text ' ]
		[= hidden _ =
			<input type="hidden" name="[ ' name ' ]" value="[ ' value | e attr ' ]">
		=]
		[= warning _ =
			<p class="msg warning">[ ' msg ' ]</p><br>
		=]
		[ '' invert '' ]
		[ '' replace '' ]
		[ '' cancel '' ]<br><br>
		[= mark _ =
			<div class="layout-box">
			<p>
				<span>[ ' diag ' ]</span>
			</p>
		=]

		[= ul _ =
			<ul id="search-results">
			[= l _ =
				[ ' delim | void ' ]
				<li>
					[= l SearchItem =
						<h3>
							<input type="checkbox" tabindex="0" name="id[[ ' pageid ' ]]" value="[ ' pageid ' ]" checked="checked">
							[ ' link ' ]
						</h3>
						<span class="search-meta">[ ' mtime | time_formatted ' ] - [ ' userlink ' ] - [ ' psize ' ] [ ' lang ' ]
						[= comments =
							- <img src="[ ' db: theme_url ' ]icon/spacer.png" class="btn-comment">[ ' n ' ]
						=]
						</span><br>
						[ ' preview | nl2br ' ]

						[ ' category ' ]
					=]
				</li>
			=]
			</ul>
		=]
		<ol id="search-results" start="[ ' offset ' ]">
		[= l _ =
			[ ' delim | void ' ]
			<li>
				['' l SearchItem '']
			</li>
		=]
		</ol>
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		<br>
		[ '' replace '' ]
		[ '' cancel '' ]
		<br>
		</form>
	=]

[= cancel =]
<a href="[ ' href: ' ]" class="btn-link">
	<button type="button" class="btn-cancel">[ ' _t: CancelButton ' ]</button>
</a>

[= invert =]
<a tabindex="0" id="invert-selections" class="btn-link btn-right" onclick="invertSelections('replace_text')">
	<button type="button" class="btn-cancel">[ ' _t: InvertSelection ' ]</button>
</a>

[= replace =]
<button type="submit" class="btn-ok" name="replace">[ ' _t: ReplaceTextReplace ' ]</button>&nbsp;
<button type="submit" class="btn-ok" name="back">[ ' _t: ReplaceTextReturn ' ]</button>&nbsp;
