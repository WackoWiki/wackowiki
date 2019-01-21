[ === main === ]
	<h3>[ ' head ' ]</h3>
	[= e Extended =
		<ul class="menu">
			<li><a href="[ ' href: properties ' ]">[ ' _t: UserSettingsGeneral ' ]</a></li>
			<li class="active">[ ' _t: UserSettingsExtended ' ]</li>
		</ul>
		<br><br>
		[= x _ =
			<div class="page-settings">
			<form action="[ ' href: properties ' ]" method="post" name="extended_properties">
				[ ' csrf: extended_properties ' ]
				<table class="form-tbl">
					<colgroup>
						<col span="1" width="30%">
						<col span="1" width="70%">
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">[ ' _t: MetaComments ' ]</th>
							<td>
								<input type="radio" id="commentsOn"	name="footer_comments"[ ' comments | check 1 ' ]><label for="commentsOn">[ ' _t: MetaOn ' ]</label>
								<input type="radio" id="commentsGuest" name="footer_comments"[ ' comments | check 2 ' ]><label for="commentsGuest">[ ' _t: MetaRegistered ' ]</label>
								<input type="radio" id="commentsOff" name="footer_comments"[ ' comments | check 0 ' ]><label for="commentsOff">[ ' _t: MetaOff ' ]</label>
							</td>
						</tr>
						<tr>
							<th scope="row">[ ' _t: MetaFiles ' ]</th>
							<td>
								<input type="radio" id="filesOn" name="footer_files"[ ' files | check 1 ' ]><label for="filesOn">[ ' _t: MetaOn ' ]</label>
								<input type="radio" id="filesGuest" name="footer_files"[ ' files | check 2 ' ]><label for="filesGuest">[ ' _t: MetaRegistered ' ]</label>
								<input type="radio" id="filesOff" name="footer_files"[ ' files | check 0 ' ]><label for="filesOff">[ ' _t: MetaOff ' ]</label>
							</td>
						</tr>
						[= r _ =
							<tr>
								<th scope="row">[ ' _t: MetaRating ' ]</th>
								<td>
									<input type="radio" id="ratingOn" name="footer_rating"[ ' rating | check 1 ' ]><label for="ratingOn">[ ' _t: MetaOn ' ]</label>
									<input type="radio" id="ratingGuest" name="footer_rating"[ ' rating | check 2 ' ]><label for="ratingGuest">[ ' _t: MetaRegistered ' ]</label>
									<input type="radio" id="ratingOff" name="footer_rating"[ ' rating | check 0 ' ]><label for="ratingOff">[ ' _t: MetaOff ' ]</label>
								</td>
							</tr>
						=]
						[= // hide_toc, hide_index, tree_level: used in custom theme menus =]
						<tr>
							<th scope="row">[ ' _t: MetaToc ' ]</th>
							<td>
								<input type="radio" id="tocOn" name="hide_toc"[ ' hidetoc | check 0 ' ]><label for="tocOn">[ ' _t: MetaOn ' ]</label>
								<input type="radio" id="tocOff" name="hide_toc"[ ' hidetoc | check 1 ' ]><label for="tocOff">[ ' _t: MetaOff ' ]</label>
							</td>
						</tr>
						<tr>
							<th scope="row">[ ' _t: MetaIndex ' ]</th>
							<td>
								<input type="radio" id="indexOn" name="hide_index"[ ' hideindex | check 0 ' ]><label for="indexOn">[ ' _t: MetaOn ' ]</label>
								<input type="radio" id="indexOff" name="hide_index"[ ' hideindex | check 1 ' ]><label for="indexOff">[ ' _t: MetaOff ' ]</label>
							</td>
						</tr>
						<tr>
							<th scope="row">[ ' _t: MetaIndexMode ' ]</th>
							<td>
								<input type="radio" id="indexmodeF" name="tree_level"[ ' treelevel | check 0 ' ]><label for="indexmodeF">[ ' _t: MetaIndexFull ' ]</label>
								<input type="radio" id="indexmodeL" name="tree_level"[ ' treelevel | check 1 ' ]><label for="indexmodeL">[ ' _t: MetaIndexLower ' ]</label>
								<input type="radio" id="indexmodeU" name="tree_level"[ ' treelevel | check 2 ' ]><label for="indexmodeU">[ ' _t: MetaIndexUpper ' ]</label>
							</td>
						</tr>
						[= html _ =
							<tr>
								<th scope="row">[ ' _t: MetaHtml ' ]</th>
								<td>
									<input type="radio" id="htmlOn" name="allow_rawhtml"[ ' raw | check 1 ' ]><label for="htmlOn">[ ' _t: MetaOn ' ]</label>
									<input type="radio" id="htmlOff" name="allow_rawhtml"[ ' raw | check 0 ' ]><label for="htmlOff">[ ' _t: MetaOff ' ]</label>
								</td>
							</tr>
							<tr>
								<th scope="row">[ ' _t: MetaSafeHtml ' ]</th>
								<td>
									<input type="radio" id="safehtmlOn" name="disable_safehtml"[ ' safe | check 0 ' ]><label for="safehtmlOn">[ ' _t: MetaOn ' ]</label>
									<input type="radio" id="safehtmlOff" name="disable_safehtml"[ ' safe | check 1 ' ]><label for="safehtmlOff">[ ' _t: MetaOff ' ]</label>
								</td>
							</tr>
						=]
						<tr>
							<th scope="row">[ ' _t: MetaNoIndex ' ]</th>
							<td>
								<input type="radio" id="noindexOn" name="noindex"[ ' noindex | check 1 ' ]><label for="noindexOn">[ ' _t: MetaOn ' ]</label>
								<input type="radio" id="noindexOff" name="noindex"[ ' noindex | check 0 ' ]><label for="noindexOff">[ ' _t: MetaOff ' ]</label>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input type="submit" class="OkBtn" name="extended" value="[ ' _t: MetaStoreButton ' ]" accesskey="s"> &nbsp;
								<a href="[ ' href: ' ]" class="btn-link"><input type="button" class="CancelBtn" value="[ ' _t: MetaCancelButton ' ]"></a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			</div>
		=]
	=]
	[= g General =
		<ul class="menu">
			<li class="active">[ ' _t: UserSettingsGeneral ' ]</li>
			<li><a href="[ ' href: properties extended ' ]">[ ' _t: UserSettingsExtended ' ]</a></li>
		</ul>
		<br><br>
		<div class="page-settings">
		[= f GenOwner =
			<form action="[ ' href: properties ' ]" method="post" name="general_properties">
				[' csrf: general_properties ']
				<table class="form-tbl">
					<colgroup>
						<col span="1" width="30%">
						<col span="1" width="70%">
					</colgroup>
					<tbody>
						<tr>
							<th scope="row">
								<label for="title">[ ' _t: MetaTitle ' ]</label>
							</th>
							<td>
								<input type="text" id="title" name="title" value="[ ' page.title | e ' ]" size="60" maxlength="250">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="keywords">[ ' _t: MetaKeywords ' ]</label>
							</th>
							<td>
								<textarea id="keywords" name="keywords" rows="4" cols="51" maxlength="250">[ ' page.keywords | e ' ]</textarea>
								[= categories _ =
									<br>
									['' html '']
								=]
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="description">[ ' _t: MetaDescription ' ]</label>
							</th>
							<td>
								<textarea id="description" name="description" rows="4" cols="51" maxlength="250">[ ' page.description | e ' ]</textarea>
							</td>
						</tr>
						[== Commented _ =
							<tr>
								<th scope="row">
									<label for="menu_tag">[ ' _t: SetMenuLabel ' ]</label>
								</th>
								<td>
									<input type="text" id="menu_tag" name="menu_tag" value="[ ' page.menu_tag | e attr ' ]" size="60" maxlength="100">
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="show_menu_tag">[ ' _t: SetShowMenuLabel ' ]</label>
								</th>
								<td>
									<input type="radio" id="menu_tag_on" name="show_menu_tag"[ ' page.show_menu_tag | check 1 ' ]><label for="menu_tag_on">[ ' _t: MetaOn ' ]</label>
									<input type="radio" id="menu_tag_off" name="show_menu_tag"[ ' page.show_menu_tag | check 0 ' ]><label for="menu_tag_off">[ ' _t: MetaOff ' ]</label>
								</td>
							</tr>
						==]
						<tr>
							<th scope="row">
								<label for="page_lang">[ ' _t: SetLang ' ]</label>
							</th>
							<td>
								<select id="page_lang" name="page_lang">
									[= o _ =
										<option value="[ ' lang ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' name ' ] ([ ' lang ' ])</option>
									=]
								</select>
								<div class="hint">[ ' _t: BewareChangeLang ' ]</div>
							</td>
						</tr>
						[= themes _ =
							<tr>
								<th scope="row">
									<label for="theme">[ ' _t: ChooseTheme ' ]</label>
								</th>
								<td>
									<select id="theme" name="theme">
										<option value="">--</option>
										[= o _ =
											<option value="[ ' theme ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' theme ' ]</option>
										=]
									</select>
								</td>
							</tr>
						=]
						[= licenses _ =
							<tr>
								<th scope="row">
									<label for="license">[ ' _t: License ' ]</label>
								</th>
								<td>
									<select id="license" name="license">
										<option value="">--</option>
										[= o _ =
											<option value="[ ' id ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' license | truncate 70' ]</option>
										=]
									</select>
								</td>
							</tr>
						=]
						<tr>
							<th></th>
							<td>
								<input type="submit" class="OkBtn" value="[ ' _t: MetaStoreButton ' ]" accesskey="s"> &nbsp;
								<a href="[ ' href: ' ]" class="btn-link"><input type="button" class="CancelBtn" value="[ ' _t: MetaCancelButton ' ]"></a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		=]
		[= w GenWorld =
			<table class="form-tbl">
				<tr>
					<th scope="row">[ ' _t: MetaTitle ' ]</th>
					<td>[ ' page.title | e ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: MetaKeywords ' ]</th>
					<td>[ ' page.keywords | e ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: MetaDescription ' ]</th>
					<td>[ ' page.description | e ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: SetLang ' ]</th>
					<td>[ ' page.page_lang | e ' ]</td>
				</tr>
			</table>
		=]
		</div>
	=]

	<aside class="page-tools">
		<table class="form-tbl lined">
			<tr>
				<th scope="row">[ ' _t: SettingsID ' ]</th>
				<td>[ ' page.page_id | e ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: Owner ' ]</th>
				<td>[ ' owner ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: SettingsCreated ' ]</th>
				<td>[ ' page.created | time_formatted ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: SettingsCurrent ' ]</th>
				<td>[ ' page.modified | time_formatted ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: SettingsSize ' ]&nbsp;&nbsp;</th>
				<td title="[ ' _t: SettingsSizeTip ' ]">[ ' bodylen ' ] / [ ' bodyrlen ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: Version ' ]</th>
				<td><a href="[ ' href: revisions ' ]" title="[ ' _t: RevisionTip ' ]">[ ' version | number 0 , . ' ]</a></td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: SettingsTotalComs ' ]</th>
				<td><a href="[ ' href: '' show_comments=1#header-comments ' ]" title="[ ' _t: ShowComments ' ]">[ ' page.comments | number 0 , . ' ]</a></td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: SettingsHits ' ]</th>
				<td>[ ' page.hits | number 0 , . ' ]</td>
			</tr>
			[= rat _ =
				<tr>
					<th scope="row">[ ' _t: SettingsRating ' ]</th>
					<td>[ ' ratio ' ] ([ ' _t: RatingVoters ' ]: [ ' voters ' ])</td>
				</tr>
			=]
		</table>
		<br>

		<ul class="page-handler">
			<li class="m-edit"><a href="[ ' href: edit ' ]">[ ' i Icon ' ][ ' _t: SettingsEdit' ]</a></li>
			<li class="m-revisions"><a href="[ ' href: revisions ' ]">[ ' i Icon ' ][ ' _t: SettingsRevisions ' ]</a></li>
			<li class="m-clone"><a href="[ ' href: clone ' ]">[ ' i Icon ' ][ ' _t: SettingsClone ' ]</a></li>
			[= rename _ =
				<li class="m-edit"><a href="[ ' href: rename ' ]">[ ' i Icon ' ][ ' _t: SettingsRename ' ]</a></li>
			=]
			[= remove _ =
				<li class="m-remove"><a href="[ ' href: remove ' ]">[ ' i Icon ' ][ ' _t: SettingsRemove ' ]</a></li>
				<li class="m-purge"><a href="[ ' href: purge ' ]">[ ' i Icon ' ][ ' _t: SettingsPurge ' ]</a></li>
			=]
			[= moder _ =
				<li class="m-moderate"><a href="[ ' href: moderate ' ]">[ ' i Icon ' ][ ' _t: SettingsModerate ' ]</a></li>
			=]
			[= perm _ =
				<li class="m-permissions"><a href="[ ' href: permissions ' ]">[ ' i Icon ' ][ ' _t: SettingsPermissions ' ]</a></li>
			=]
			<li class="m-categories"><a href="[ ' href: categories ' ]">[ ' i Icon ' ][ ' _t: SettingsCategories ' ]</a></li>
			<li class="m-attachments"><a href="[ ' href: attachments ' ]">[ ' i Icon ' ][ ' _t: SettingsAttachments ' ]</a></li>
			<li class="m-upload"><a href="[ ' href: upload ' ]">[ ' i Icon ' ][ ' _t: SettingsUpload ' ]</a></li>
			<li class="m-referrers"><a href="[ ' href: referrers ' ]">[ ' i Icon ' ][ ' _t: SettingsReferrers ' ]</a></li>
			<li class="[ ' watched | list watch-on watch-off ' ]"><a href="[ ' href: watch ' ]">[ ' i Icon ' ][ ' watched | list WatchText UnwatchText | _t ' ]</a></li>
			<li class="m-print"><a href="[ ' href: print ' ]">[ ' i Icon ' ][ ' _t: SettingsPrint ' ]</a></li>
			[== CommentedOut _ =
				<li class="m-word"><a href="[ ' href: wordprocessor ' ]">[ ' i Icon ' ][ ' _t: SettingsWordprocessor ' ]</a></li>
				<li class="m-latex"><a href="[ ' href: latex ' ]">[ ' i Icon ' ][ ' _t: SettingsLatex ' ]') . "</a></li>
				<li class="m-xml"><a href="[ ' href: export.xml ' ]">[ ' i Icon ' ][ ' _t: SettingsXML ' ]') . "</a></li>
			==]
		</ul>
	</aside>

[== Icon ==]
<img src="[ ' db: theme_url ' ]icon/spacer.png">
