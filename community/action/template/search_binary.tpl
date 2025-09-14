[ === main === ]
	[ ' help ' ]
	[ ' message ' ]<br>
	[= search _ =
		<form action="[ ' href: ' ]" method="post" name="select_pages">
			[ ' csrf: select_pages ' ]
			<label for="text_target">[ ' _t: SearchFor ' ]</label><br>
			<textarea id="text_target" name="target" class="cols-100" cols="100" rows="5" title="[ ' _t: ReplaceTextGiveTarget ' ]" required>[ ' target | pre ' ]</textarea><br>
			<input type="checkbox" id="use_regex" name="use_regex"[ ' regex | format ' checked' ' ]>
			<label for="use_regex">[ ' _t: ReplaceTextRegex ' ]</label><br><br>
			<label for="cluster" title="[ ' _t: ReplaceTextCluster ' ]">[ ' _t: Namespace ' ]</label><br>
			<input type="text" id="cluster" name="page" value="[ ' tag | e attr ' ]" size="80" maxlength="255"><br>
			<input type="checkbox" id="pages" name="pages"[ ' pages | format ' checked' ' ]>
			<label for="pages">[ ' _t: SearchInPages ' ]</label><br>
			<input type="checkbox" id="comments" name="comments"[ ' comments | format ' checked' ' ]>
			<label for="comments">[ ' _t: SearchInComments ' ]</label><br>
			<input type="checkbox" id="titles" name="titles"[ ' titles | format ' checked' ' ]>
			<label for="titles">[ ' _t: SearchInPageTitles ' ]</label><br><br>
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
			<br>
			<button type="submit" class="btn-ok">[ ' _t: SearchButton ' ]</button>&nbsp;
			[ '' cancel '' ]<br>
		</form>
		<br>
	=]
	[= matches _ =
		[= warning _ =
			<p class="msg warning">[ ' msg ' ]</p><br>
		=]
		<br><br>
		[ '' pagination '' ]
		[= mark _ =
			<div class="layout-box">
			<p>
				<span>[ ' diag ' ] «<strong>[ ' phrase | e ' ]</strong>» ([ ' count | e ' ]):</span>
			</p>
		=]

		<ol id="search-results" start="[ ' offset ' ]">
		[= l _ =
			[ ' delim | void ' ]
			<li>
				[ '' l SearchItem '' ]
			</li>
		=]
		</ol>
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[ '' pagination '' ]
		<br>
		<br>
	=]

[= cancel =]
<a href="[ ' href: ' ]" class="btn-link">
	<button type="button" class="btn-cancel">[ ' _t: CancelButton ' ]</button>
</a>


[= SearchItem =]
<h3>
	[ ' link ' ]
</h3>
<span class="search-meta">[ ' mtime | time_format ' ] - [ ' userlink ' ] - [ ' psize ' ] [ ' lang ' ]
[= comments =
	- <img src="[ ' db: theme_url ' ]icon/spacer.png" class="btn-comment btn-sm">[ ' n ' ]
=]
</span><br>
[ ' preview | nl2br ' ]

[ ' category ' ]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
