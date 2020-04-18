[ === main === ]
	<h3>[ ' page ' ]</h3>
	<br>
	[= r _ =
		<div class="msg success">
			<strong><code>[ ' tag ' ]</code></strong>
			<ol>
				[= l _ =
					<li>[ ' notice ' ]</li>
				=]
			</ol><br>
			[ ' _t: ActionHaveNoUndo ' ]
			<br>
		</div>
		<br>
		[ ' return ' ]
	=]
	[= f _ =
		[= preview _ =
			<div class="preview">
				[ ' meta ' ]
				<div class="comment-title"><h2>[ ' title | e ' ]</h2></div>
				[ ' text | truncate 250 | e ' ]
			</div><br>
		=]
		[ ' backlinks ' ]
		<br>
		[ ' tree ' ]
		<br>
		[ ' warning ' ]<br>
		<form action="[ ' href: remove ' ]" method="post" name="remove_page">
			[ ' csrf: remove_page ' ]
			[= admin _ =
				[= p _ =
					<input type="checkbox" id="removecluster" name="cluster">
					<label for="removecluster">[ ' _t: RemoveCluster ' ]</label><br>
					[= dontkeep _ =
						<input type="checkbox" id="dontkeep" name="dontkeep">
						<label for="dontkeep">[ ' _t: RemoveDontKeep ' ]</label><br>
					=]
				=]
				[= c _ =
					[= dontkeep _ =
						<input type="checkbox" id="dontkeep" name="dontkeep">
						<label for="dontkeep">[ ' _t: RemoveDontKeepComment ' ]</label><br>
					=]
				=]
			=]
			<br>
			<input type="submit" class="OkBtn" name="submit" value="[ ' _t: RemoveButton ' ]"> &nbsp;
			<a href="[ ' href: ' ]" class="btn-link">
				<input type="button" class="CancelBtn" value="[ ' _t: EditCancelButton ' ]">
			</a>
			<br>
		</form>

	=]
	[= denied _ =
		<div class="msg error">
			[ ' _t: NotOwnerCantDelete ' ]
		</div>
	=]