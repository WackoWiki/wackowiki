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
				<input type="submit" name="update" id="submit" value="[ ' _t: UpdateButton ' ]">
				<br><br>
			=]
			<table class="lined">
				<tr>
					<th>[ ' _t: BookmarkNumber ' ]</th>
					<th>[ ' _t: BookmarkTitle ' ]</th>
					<th>[ ' _t: BookmarkPage ' ]</th>
					<th>[ ' _t: BookmarkMark ' ]</th>
					<!--<th>Display</th>-->
				</tr>
				[= l _ =
					<tr>
						<td >
							<input type="number" min="0" name="pos_[ ' menuid ' ]" size="2" style="width: 40px;" value="[ ' position ' ]">
						</td>
						<td>
							<input type="text" maxlength="100" name="title_[ ' menuid ' ]" size="40" value="[ ' menutitle ' ]" placeholder="[ ' title ' ]">
						</td>
						<td>
							[= nouse _ =
								<!--<input type="radio" id="menu_item[ ' menuid ' ]" name="change" value="[ ' menuid ' ]"> -->
							=]
							<label for="menu_item[ ' menuid ' ]" title="[ ' title ' ]">» [ ' tag ' ]</label>
						</td>
						<td class="t-center">
							<input type="checkbox" id="menu_item[ ' menuid ' ]" name="delete_[ ' menuid ' ]">
						</td>
					</tr>
				=]
				<tfoot>
					<tr>
						<td colspan="3">
							<input type="submit" name="update_menu" value="[ ' _t: BookmarkSaveChanges ' ]">
						</td>
						<td>
							<input type="submit" name="delete_menu_item" value="[ ' _t: BookmarkDeleteSelected ' ]">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	=]
	<form action="[ ' href: ' ]" method="post" name="add_bookmark">
		[ ' csrf: add_bookmark ' ]
		<input type="hidden" name="_user_menu" value="yes">
		<br><br>
		<label for="add_menu_item">[ ' _t: BookmarksAddPage ' ]:</label><br>
		<input type="text" id="add_menu_item" name="tag" value="" size="60" maxlength="255">
		[= lang _ =
			[ ' select ' ]
		=]
		<input type="submit" name="add_menu_item" value="[ ' _t: CreatePageButton ' ]">
	</form>
