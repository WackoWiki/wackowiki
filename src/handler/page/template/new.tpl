[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<div id="page" class="page">
		[ ' message ' ]
		<h3>[ ' _t: CreateNewPage ' ]</h3>
		<br>
		[= p _ =
			[= d _ =
				[ ' _t: CreateSubPage ' ]:<br>
				[ ' message ' ]
			=]
			[= f _ =
				<form action="[ ' href: new ' ]" method="post" name="sub_page">
					[ ' csrf: sub_page ' ]
					<input type="hidden" name="option" value="1">
					<label for="create_subpage">[ ' _t: CreateSubPage ' ]</label><br>
					<code>[ ' base ' ]/</code>
					<input type="text" id="create_subpage" name="tag" value="[ ' tag | e attr ' ]" size="20" maxlength="255">
					<button type="submit" id="submit_subpage">[ ' _t: CreateButton ' ]</button>
				</form>
				<br>
			=]
		=]
		[= c _ =
			[= d _ =
				[ ' _t: CreatePageParentCluster ' ]:<br>
				[ ' message ' ]
			=]
			[= f _ =
				<form action="[ ' href: new ' ]" method="post" name="parent_cluster_page">
					[ ' csrf: parent_cluster_page ' ]
					<input type="hidden" name="option" value="2">
					<label for="create_parent_cluster_page">[ ' _t: CreatePageParentCluster ' ]</label><br>
					<code>[ ' base ' ]/</code>
					<input type="text" id="create_parent_cluster_page" name="tag" value="[ ' tag | e attr ' ]" size="20" maxlength="255">
					<button type="submit" id="submit_parent_cluster_page">[ ' _t: CreateButton ' ]</button>
				</form>
				<br>
			=]
		=]
		<form action="[ ' href: new ' ]" method="post" name="random_page">
			[ ' csrf: random_page ' ]
			<input type="hidden" name="option" value="3">
			<label for="create_random_page">[ ' _t: CreateRandomPage ' ]</label><br>
			<input type="text" id="create_random_page" name="tag" value="[ ' tag | e attr ' ]" size="60" maxlength="255">
			<button type="submit" id="submit_random_page">[ ' _t: CreateButton ' ]</button>
		</form>
	</div>
