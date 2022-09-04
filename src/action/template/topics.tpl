[ === main === ]
	[ ' message ' ]
	[= topics =
		<div class="[ ' salign ' ] clearfix">
			[ ' search ' ]
		</div>
		[= t =
			<div style="clear: both;">
				<p>
					[= create =
						<strong>
							<small class="cite">
								<a href="#newtopic">[ ' _t: ForumNewTopic ' ]</a>
							</small>
						</strong>
					=]
				</p>
				[ '' pagination '' ]
			</div>
			[= f =
			<table class="topics">
				<thead>
					<tr>
						<th>[ ' _t: ForumTopic ' ]</th>
						<th>[ ' _t: ForumAuthor ' ]</th>
						<th>[ ' _t: ForumReplies ' ]</th>
						<th>[ ' _t: ForumViews ' ]</th>
						<th>[ ' _t: ForumLastComment ' ]</th>
					</tr>
				</thead>
				[= r =
				<tbody>
					<tr class="topic">
						<td>
							[= closed =
								<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: DeleteCommentTip ' ]" alt="[ ' _t: DeleteText ' ]" class="btn-locked">'
							=]
							[= updated =
								<strong><span class="cite" title="[ ' _t: ForumNewPosts ' ]">[[ ' _t: ForumUpdated ' ]]</span></strong> 
							=]
							<strong>[ ' title ' ]</strong>
						</td>
						<td class="nowrap">
							<small title="[ ' ip ' ]">
								[ ' owner ' ]<br>
								[ ' topic.created | time_formatted ' ]
							</small>
						</td>
						<td><small>[ ' topic.comments | number 0 , . ' ]</small></td>
						<td><small>[ ' topic.hits | number 0 , . ' ]</small></td>
						<td>
							[= c =
								<small[ ' style ' ] title="[ ' ip ' ]">
									[ ' user ' ]<br>
									<a href="[ ' href ' ]">[ ' created | time_formatted ' ]</a>
								</small>
							=]
							[= none =
								<small><em>([ ' created | time_formatted ' ])</em></small>
							=]
						</td>
					</tr>
					<tr>
						<td colspan="6" class="description">
							[ ' topic.description ' ]
							[ ' category ' ]
						</td>
					</tr>
				</tbody>
				=]
			</table>
			=]
			[= notopics _ =
			[ ' _t: ForumNoTopics ' ]
			=]

			<div class="clearfix">
				<p>
					[= mark _ =
						<small class="no-print"><a href="[ ' href ' ]">[ ' _t: MarkRead ' ]</a></small>
					=]
				</p>
				[ '' pagination '' ]
			</div>

			[= form _ =
				<form action="[ ' href ' ]" method="post" name="add_topic">
					[ ' csrf: add_topic ' ]
					<br>
					<table id="newtopic" class="formation">
						<tr>
							<td class="label">
								<label for="topictitle">[ ' _t: ForumTopicName ' ]</label>
							</td>
							<td>
								<input type="text" id="topictitle" name="title" size="50" maxlength="250" value="">
								<button type="submit" id="submit">[ ' _t: ForumTopicSubmit ' ]</button>
							</td>
						</tr>
					</table>
				</form>
			=]
		=]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

