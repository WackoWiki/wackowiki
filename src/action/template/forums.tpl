[ === main === ]
	[ ' help ' ]
	[ ' message ' ]
	[= forum =
		<div class="[ ' salign ' ] clearfix">
			[ ' search ' ]
		</div>
		[= t =
			<table class="forum lined">
				<colgroup>
					<col span="1">
					<col span="1">
					<col span="1">
					<col span="1">
				</colgroup>
				<thead>
					<tr>
						<th>[ ' _t: ForumSubforums ' ]</th>
						<th>[ ' _t: ForumTopics ' ]</th>
						<th>[ ' _t: ForumPosts ' ]</th>
						<th>[ ' _t: ForumLastComment ' ]</th>
					</tr>
				</thead>
				[= f =
					<tbody>
						<tr>
							<td>
								[= closed =
									<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: ForumLocked ' ]" alt="[ ' _t: ForumLocked ' ]" class="btn-locked btn-sm">'
								=]
								[= updated =
									<strong class="cite" title="[ ' _t: ForumNewPosts ' ]">[updated]</strong>
								=]
								<strong>[ ' link ' ]</strong><br>
								<small>[ ' description ' ]</small>
							</td>
							<td>[ ' counter.topics_total | number_format ' ]</td>
							<td>[ ' counter.posts_total | number_format ' ]</td>
							[= c =
								<td>
									<small>
										<a href="[ ' href ' ]">[ ' title | e ' ]</a><br>
										[ ' user ' ] ([ ' comment.created | time_format ' ])
									</small>
							=]
							[= none =
								<td>
									<small><em>[ ' _t: ForumNoComments ' ]</em></small>
							=]
							</td>
						</tr>
					</tbody>
				=]
			</table>
			<br>

			[= mark _ =
				<small class="no-print"><a href="[ ' href ' ]">[ ' _t: MarkRead ' ]</a></small>
			=]
		=]
		[= xml =
			<span class="desc-rss-feed">
				<a href="[ ' href ' ]">
					<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: CommentsXMLTip ' ]" alt="XML" class="btn-feed btn-sm">
				</a>
			</span>
			<br><br>
		=]
	=]	