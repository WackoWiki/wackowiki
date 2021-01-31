[ === main === ]
	<h3>[ ' _t: PurgePage ' ] [ ' page ' ]</h3>
	[= p _ =
		<div class="msg success">
			<ol>
				[= l _ =
					<li>[ ' notice ' ]</li>
				=]
			</ol><br>
			[ ' _t: ActionHaveNoUndo ' ]
		</div>
	=]
	[= f _ =
		<div class="msg warning">[ ' _t: ReallyPurge ' ]</div><br>
		<form action="[ ' href: purge ' ]" method="post" name="purge_data">
			[ ' csrf: purge_data ' ]
			<strong>[ ' _t: SelectPurgeOptions ' ]</strong><br>

			<input type="checkbox" id="purgecomments" name="comments">
			<label for="purgecomments">[ ' _t: PurgeComments ' ]</label><br>

			<input type="checkbox" id="purgefiles" name="files">
			<label for="purgefiles">[ ' _t: PurgeFiles ' ]</label><br>

			[= admin _ =
				<input type="checkbox" id="purgerevisions" name="revisions">
				<label for="purgerevisions">[ ' _t: PurgeRevisions ' ]</label><br>

				[= dontkeep _ =
					<br>
					<input type="checkbox" id="dontkeep" name="dontkeep">
					<label for="dontkeep">[ ' _t: RemoveDontKeep ' ]</label><br>
				=]
			=]
			<br>
			<button type="submit" id="submit" name="submit">[ ' _t: PurgeButton ' ]</button>
			<a href="[ ' href: properties ' ]" class="btn-link">
				<button type="button" id="button">[ ' _t: CancelButton ' ]</button>
			</a>
			<br>
		</form>
	=]