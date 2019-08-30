[ === main === ]
	[ ' denied ' ]
	[= l _ =
			<span class="page-lang" title="[ ' language ' ] ([ ' charset ' ])">[ ' lang ' ]</span>
	=]
	[= n _ =
		
		[ '' header '' ]
		<form action="[ ' href: categories ' ]" method="post" name="add_category">
			[ ' csrf: add_category ' ]
			<input type="hidden" name="category_id" value="[ ' parentid | e attr ' ]">
			<table class="formation">
				<tr>
					<td>
						<label for="new_category">[ ' _t: CategoriesAdd ' ]</label>
					</td>
					<td>
						<input type="text" name="category" id="new_category" value="[ ' category | e attr ' ]" size="40" maxlength="100">
					</td>
				</tr>
				<tr>
					<td>
						<label for="category_description">[ ' _t: CategoryDescription ' ]</label>
					</td>
					<td>
						<textarea id="category_description" name="category_description" rows="4" cols="51" maxlength="250"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						[= p _ =
							<input type="radio" id="group1" name="group" value="1" checked>
							<label for="group1">[ ' _t: CategoriesAddGrouped ' ]<code>[ ' category | e ' ]</code>.</label><br>
							<input type="radio" id="group0" name="group" value="0">
							<label for="group0">[ ' _t: CategoriesAddGroupedNo ' ]</label><br><br>
						=]
						<input type="submit" id="submit" name="create" value="[ ' _t: CategoriesSaveButton ' ]">
						<a href="[ ' href: categories ' ]" class="btn-link">
							<input type="button" id="button" value="[ ' _t: CategoriesCancelButton ' ]">
						</a>
					</td>
				</tr>
			</table><br>
		</form>
	=]
	[= r _ =
		[ '' header '' ]
		<form action="[ ' href: categories ' ]" method="post" name="rename_category">
			[ ' csrf: rename_category ' ]
			<input type="hidden" name="category_id" value="[ ' changeid | e attr ' ]">
			<table class="formation">
				<tr>
					<td>
						<label for="new_name">[ ' newname ' ]</label>
					</td>
					<td>
						<input type="text" name="category" id="new_name" value="[ ' category | e attr ' ]" size="40" maxlength="100">
					</td>
				</tr>
				<tr>
					<td>
						<label for="category_description">[ ' _t: CategoryDescription ' ]</label>
					</td>
					<td>
						<textarea id="category_description" name="category_description" rows="4" cols="51" maxlength="250">[ ' description | e ' ]</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<small>[ ' _t: CategoriesRenameInfo ' ]</small><br>
						<input type="submit" name="rename" id="submit_new_name" value="[ ' _t: CategoriesSaveButton ' ]">
						<a href="[ ' href: categories ' ]" class="btn-link">
							<input type="button" id="button" value="[ ' _t: CategoriesCancelButton ' ]">
						</a>
					</td>
				</tr>
			</table><br>
		</form>
	=]
	[= g _ =
		[ '' header '' ]
		<form action="[ ' href: categories ' ]" method="post" name="group_categories">
			[ ' csrf: group_categories ' ]
			<input type="hidden" name="category_id" value="[ ' changeid | e attr ' ]">
			<table class="formation">
				<tr>
					<td>
						<label for="">[ ' group ' ]</label>
						<select name="parent_id">
							<option value="0">[ ' _t: CategoriesNoGroup ' ]</option>
							[= o _ =
								<option value="[ ' id ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' category | e ' ]</option>
							=]
						</select>
						<input type="submit" id="submit" name="ugroup" value="[ ' _t: CategoriesSaveButton ' ]">
						<a href="[ ' href: categories ' ]" class="btn-link">
							<input type="button" id="button" value="[ ' _t: CategoriesCancelButton ' ]">
						</a>
						<br><small>[ ' _t: CategoriesGroupInfo ' ]</small>
					</td>
				</tr>
			</table><br>
		</form>
	=]
	[= d _ =
		[ '' header '' ]
		<form action="[ ' href: categories ' ]" method="post" name="remove_category">
			[ ' csrf: remove_category ' ]
			<input type="hidden" name="category_id" value="[ ' changeid | e attr ' ]">
			<table class="formation">
				<tr>
					<td>
						<label for="">[ ' category ' ]</label> 
						<input type="submit" id="submit_delete" name="delete" value="[ ' _t: DeleteText ' ]">
						<a href="[ ' href: categories ' ]" class="btn-link">
							<input type="button" id="button" value="[ ' _t: CategoriesCancelButton ' ]">
						</a>
						<br><small>[ ' _t: CategoriesDeleteInfo ' ]</small>
					</td>
				</tr>
			</table><br>
		</form>
	=]
	[= a _ =
		[= h _ =
			<h3>[ ' _t: CategoriesFor ' ] [ ' link ' ]</h3>
			<ul class="menu">
				<li class="active">[ ' _t: CategoriesAssign ' ]</li>
					[= edit _ =
						<li><a href="[ ' href ' ]">[ ' _t: CategoriesEdit ' ]</a></li>
					=]
			</ul><br>
		=]
		[ '' header '' ]
		<form action="[ ' href: categories ' ]" method="post" name="assign_categories">
			[ ' csrf: assign_categories ' ]
			[ ' form ' ]
			<br><br>
		</form>
	=]


[ == header == ]
<h3>[ ' _t: CategoriesTip ' ]</h3>
	<ul class="menu">
		<li><a href="[ ' href: categories ' ]">[ ' _t: CategoriesAssign ' ]</a></li>
		<li class="active">[ ' _t: CategoriesEdit ' ]</li>
	</ul><br>