[ === main === ]
	[= s =
		<form action="[ ' href ' ]" method="get" name="file_search">
			[ ' csrf: file_search ' ]
			[ ' href: attachments | hide_page ' ]
			<input type="hidden" name="files" value="[ ' filter | e attr ' ]">
			<table class="formation">
				<tr>
					<td>
						<label for="search_file" class="visuallyhidden">[ ' _t: FileSearch ' ]</label>
						<input type="search" name="phrase" id="search_file" size="40" value="[ ' phrase | e attr ' ]" title="[ ' _t: FileSearch ' ]" placeholder="[ ' _t: FileSearch ' ]">
						<button type="submit">[ ' _t: SearchButton ' ]</button>
					</td>
				</tr>
				[= options _ =
				<tr>
					<td>
						<table>
							<tr>
								[= l _ =
								<td colspan=2>
									<label for="order">[ ' _t: SortBy ' ]</label><br>
									<select name="order">
										[= o _ =
											<option value="[ ' value ' ]"[ ' selected ' ]>[ ' lang ' ]</option>
										=]
									</select>
									<select name="dir">
										[= d _ =
											<option value="[ ' value ' ]"[ ' selected ' ]>[ ' lang ' ]</option>
										=]
									</select>
								</td>
								=]
							</tr>
							<tr>
								[= lang _ =
									<td>
										<label for="file_lang">[ ' _t: Language ' ]</label><br>
										<select id="file_lang" name="lang">
											<option value="">[ ' _t: Any ' ]</option>
											[= o _ =
												<option value="[ ' lang ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' name ' ] ([ ' lang ' ])</option>
											=]
										</select>
									</td>
								=]
								<td>
									<label for="owner">[ ' _t: Owner ' ]</label><br>
									<select id="owner" name="user_id">
										<option value="">[ ' _t: Any ' ]</option>
										[= u _ =
											<option value="[ ' user.user_id | e attr ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' user.user_name | e ' ]</option>
										=]
									</select>
								</td>
								<td>
									<label for="mime_type">[ ' _t: MimeType ' ]</label><br>
									<select id="mime_type" name="mime">
										<option value="">[ ' _t: Any ' ]</option>
										[= m _ =
											<option value="[ ' mime.mime_type | e attr ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' mime.mime_type | e ' ]</option>
										=]
									</select>
								</td>
								<td>
									<label for="category">[ ' _t: Category ' ]</label><br>
									<select id="category" name="category_id">
										<option value="">[ ' _t: Any ' ]</option>
										[= c _ =
											<option value="[ ' category.category_id | e attr ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' category.category | e ' ]</option>
										=]
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				=]
			</table>
			<br />
		</form>
	=]
	[ '' pagination '' ]
	[= mark =
		<div class="layout-box">
			<p><span>[ ' results ' ]: </span></p>
	=]
	[ ' message ' ]
	[= r =
	<table class="[ ' style ' ]">
		[= n =
			<tr>
				<td class="file-">[ ' link ' ]</td>
					[= p =
						<td class="desc-">
							<strong>[ ' name ' ]</strong><br><br>
							[ ' desc ' ]<br><br>
							[ ' meta ' ]<br>
							[ ' size ' ]<br><br>
							[ ' user ' ]<br>
							[ ' created ' ]<br><br>
							[ ' categories ' ]
						</td>
					=]
					[= g =
						<td class="desc-">[ ' desc ' ]</td>
						<td class="size-">
							<span class="size2-">[ ' meta ' ]</span>&nbsp;
						</td>
						<td class="dt-">
							<span class="dt2-">[ ' created ' ]</span>&nbsp;
						</td>
					=]
				<td class="tool-">
					<nav class="dt2- file-tools">[ ' i icon ' ]</nav>
				</td>
			</tr>
		=]
	</table>
	=]
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]
	[ '' pagination '' ]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= icon =]
<a href="[ ' info ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' title | e attr ' ]" alt="[ ' title | e attr ' ]" class="btn-[ ' class ' ]"></a>
