[ === main === ]
	<h3>[ ' _t: RenamePage ' ] [ ' page ' ]</h3><br>
	[= f _ =
		[ ' _t: NewName ' ]
		<form action="[ ' href: rename ' ]" method="post" name="rename_page">
			[ ' csrf: rename_page ' ]
			<input type="text" maxlength="250" name="new_tag" value="[ ' tag | e attr ' ]" size="60">
			<br>
			<br>
			<input type="checkbox" id="redirect" name="redirect"[ ' checked ' ]>
			<label for="redirect">[ ' _t: NeedRedirect ' ]</label><br>
			[= global _ =
				<input type="checkbox" id="massrename" name="massrename">
				<label for="massrename">[ ' _t: MassRename ' ]</label>
			=]
			<br>
			<br>
			[ ' backlinks ' ]
			<br>
			[ ' tree ' ]
			<br>
			<br>
			<input type="submit" class="OkBtn" name="submit" value="[ ' _t: RenameButton ' ]"> &nbsp;
			<a href="[ ' href: ' ]" class="btn-link">
				<input type="button" class="CancelBtn" value="[ ' _t: EditCancelButton ' ]">
			</a>
			<br>
			<br>
		</form>
	=]
	[= denied _ =
		<div class="info">
			[ ' _t: NotOwnerCantRename ' ]
		</div>
	=]