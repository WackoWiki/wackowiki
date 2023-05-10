[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<article class="page">
	[ = rev RevisionInfo =
		<div class="revision-info">
			[ ' text ' ]
		</div>
	=]
	<h1>[ ' title ' ]</h1>
	[ ' body ' ]
	<br>
	[= c Comments =
		<br>
		<section id="comments">
			<header class="header-comments">
				[ ' _t: Comments ' ]
			</header>
			[= cmt _ =
				<article class="comment">
					<span class="comment-meta">
						<strong>— [ ' user ' ]</strong> ([ ' created | time_format ' ][ ' edit CmtEdited ' ])&nbsp;&nbsp;&nbsp;
					</span>
					<br>
					['' body '']
				</article>
			=]
		</section>
	=]
	</article>

[== CmtEdited ==]
, [ ' _t: CommentEdited ' ] [ ' time | time_format ' ]
