[ === menu === ]
	[= none _ =
		[ ' _t: BookmarkNone ' ]
	=]
	[= bm _ =
		<form action="[ ' href: ' ]" method="post" name="edit_bookmarks">
			[ ' csrf: edit_bookmarks ' ]
			<input type="hidden" name="_user_menu" value="yes">
			[= lang _ =
				[ ' select ' ]
				<button type="submit" name="update" id="submit">[ ' _t: UpdateButton ' ]</button>
				<br><br>
			=]
			<table class="lined hl-line">
				<tr>
					<th>[ ' _t: BookmarkNumber ' ]</th>
					<th>[ ' _t: BookmarkTitle ' ]</th>
					<th>[ ' _t: BookmarkPage ' ]</th>
					<th>[ ' _t: BookmarkMark ' ]</th>
				</tr>
				[= l _ =
					<tr>
						<td >
							<input type="number" min="0" name="pos_[ ' menuid ' ]" size="2" style="width: 40px;" value="[ ' position ' ]">
						</td>
						<td>
							<input type="text" maxlength="100" name="title_[ ' menuid ' ]" size="40" value="[ ' menutitle ' ]" placeholder="[ ' title | e attr ' ]">
						</td>
						<td>
							<label for="menu_item[ ' menuid ' ]" title="[ ' title | e attr ' ]">» [ ' tag ' ]</label>
						</td>
						<td class="t-center">
							<input type="checkbox" id="menu_item[ ' menuid ' ]" name="delete_[ ' menuid ' ]">
						</td>
					</tr>
				=]
				<tfoot>
					<tr>
						<td colspan="3">
							<button type="submit" name="update_menu">[ ' _t: BookmarkSaveChanges ' ]</button>
						</td>
						<td>
							<button type="submit" name="delete_menu_item">[ ' _t: BookmarkDeleteSelected ' ]</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	=]
	<form action="[ ' href: ' ]" method="post" name="add_bookmark">
		[ ' csrf: add_bookmark ' ]
		<input type="hidden" name="_user_menu" value="yes">
		<input type="hidden" name="menu_lang" value="[ ' menulang ' ]">
		<br><br>
		<label for="add_menu_item">[ ' _t: BookmarksAddPage ' ]:</label><br>
		<input type="text" id="add_menu_item" name="tag" value="" size="60" maxlength="255">
		[= lang _ =
			[ ' select ' ]
		=]
		<button type="submit" name="add_menu_item">[ ' _t: CreateButton ' ]</button>
	</form>
