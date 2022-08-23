[ === main === ]
	[ '' pagination '' ]
	[= s =
		<form action="[ ' href: attachments ' ]" method="get" name="file_search">
			[ ' csrf: file_search ' ]
			[ ' href: attachments | hide_page ' ]
			<input type="hidden" name="files" value="[ ' filter | e attr ' ]">
			<table class="formation">
				<tr>
					<td class="label">
						<label for="search_file">[ ' _t: FileSearch ' ]</label>
					</td>
					<td>
						<input type="search" name="phrase" id="search_file" size="40" value="[ ' phrase | e attr ' ]">
						<button type="submit">[ ' _t: SearchButton ' ]</button>
					</td>
				</tr>
				[= options _ =
					[= l _ =
					<td class="label">
						<label for="order">[ ' _t: SortBy ' ]</label>
					</td>
					<td>
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
				=]
			</table>
			<br />
		</form>
	=]
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
