[ === main === ]
	[ ' message ' ]
	[= mark =
		<small class="no-print"><a href="[ ' href ' ]">[ ' _t: MarkRead ' ]</a></small>
	=]
	[= xml =
		<span class="desc-rss-feed">
			<a href="[ ' href ' ]">
				<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: CommentsXMLTip ' ]" alt="XML" class="btn-feed">
			</a>
		</span>
		<br><br>
	=]
	[= nopages _ =
		[ ' _t: NoRecentComments ' ]
	=]
	[''' pagination ''']
	<ul class="ul-list">
		[= page _ =
			<li><strong>[ ' day ' ]</strong>
				<ul class="hl-line">
					[= l _ =
						<li[ ' viewed ' ]>
							<span class="dt">[ ' time ' ]</span> — [ ' page ' ]
							 . . . . . . . . . . . . . . . . 
							<small>
								[ ' // _t: LatestCommentBy ' ]
								[ ' user ' ]
							</small>
						</li>
					=]
				</ul>
			<br></li>
		=]
	</ul>

	[''' pagination ''']


[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
