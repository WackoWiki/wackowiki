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
		[= tree _ =
			[ ' subpages ' ]
			<br>
		=]
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
			<button type="submit" class="btn-danger" name="submit">[ ' _t: DeleteButton ' ]</button> &nbsp;
			<a href="[ ' href: ' ]" class="btn-link">
				<button type="button" class="btn-cancel">[ ' _t: CancelButton ' ]</button>
			</a>
			<br>
		</form>

	=]
	[= denied _ =
		<div class="msg error">
			[ ' _t: NotOwnerCantDelete ' ]
		</div>
	=]