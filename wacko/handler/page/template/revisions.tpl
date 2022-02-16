[ === main === ]
	[ ' message ' ]
	<h3>[ ' head ' ]</h3>
	[= r _ =
		<form action="[ ' href: diff ' ]" method="get" name="diff_versions">
			[ ' csrf: diff_versions ' ]
			[ ' href: diff | hide_page ' ]
			<p>
				<button type="submit">[ ' _t: ShowDifferencesButton ' ]</button>
				[= d _ =
					[ '' placeholder '' ]
					<input type="radio" id="diff_mode_[ ' mode ' ]" name="diffmode" value="[ ' mode ' ]" [ ' checked ' ]>
					<label for="diff_mode_[ ' mode ' ]">[ ' diffmode ' ]</label>
				=]
				[ '' placeholder '' ]
				<a href="[ ' href: revisions.xml ' ]">
					<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: RevisionXMLTip ' ]" alt="XML" class="btn-feed">
				</a>
				[= m _ =
					<input name="minor_edit" value="[ ' minor ' ]" type="hidden">
					<br>
					<a href="[ ' href ' ]">[ ' text ' ]</a>
				=]
			</p>
			[ '' pagination '' ]
			<ul class="revisions">
				[= l _ =
					<li>
						[= del _ =
							[ ' nonstatic ' ]
							<del>
						=]
						<span class="rev-version">[ ' version ' ]</span>
						<input type="radio" name="a" value="[ ' value ' ]" [ ' checkedA ' ]>
						[ '' placeholder '' ]
						<input type="radio" name="b" value="[ ' value ' ]" [ ' checkedB ' ]>
						[ '' placeholder '' ]&nbsp;
						<a href="[ ' href ' ]">[ ' modified | time_formatted ' ]</a>
						<span class="rev-size"> — ([ ' size ' ]) [ ' delta ' ]</span>
						[ '' placeholder '' ] [ ' _t: By ' ] [ ' user ' ] 
						[= n _ =
							<span class="editnote">[[ ' note ' ]]</span>
						=]
						[= m _ =
							<abbr class="minoredit" title="[ ' _t: EditMinor ' ]">[ ' minor ' ]</abbr>
						=]
						[= r _ =
							[= x _ =
								<span class="review">[[ ' _t: ReviewedBy ' ] [ ' user ' ]]</span>
							=]
							[= review _ =
								<span class="review">[ ' _t: Review ' ]</span>
							=]
						=]
						[= edel _ =
							[ ' nonstatic ' ]
							</del>
						=]
					</li>
				=]
			</ul><br>
			[ '' pagination '' ]
			<a href="[ ' href: ' ]" class="btn-link">
				<button type="button">[ ' _t: CancelReturnButton ' ]</button>
			</a>
		</form>
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= placeholder =]
&nbsp;&nbsp;&nbsp;
