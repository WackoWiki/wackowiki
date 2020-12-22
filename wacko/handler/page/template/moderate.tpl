[ === main === ]
	<h3>
		[ ' _t: Moderation ' ] [ ' title ' ]
	</h3>
	[ ' moderate ' ]

	[= subforum _ =
		[''' pagination ''']
		<form action="[ ' href: moderate ' ]" method="post" name="moderate_subforum">
			[ ' csrf: moderate_subforum ' ]

		[= delete _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' _t: ModerateDeleteConfirm ' ]</th></tr>
				<tr><td>
					<em>[ ' text ' ]</em><br>
					<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]"> 
					<a href="[ ' href: moderate ' ]" class="btn-link">
						<input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]">
					</a>
				</td></tr>
			</table><br>
		=]
		[= move _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' _t: ModerateMovesConfirm ' ]</th></tr>
				<tr><td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<em>[ ' text ' ]</em><br>
						<select name="section">
							<option selected></option>
							[= o _ =
								<option value="[ ' tag ' ]">[ ' title | e ' ]</option>
							=]
						</select>
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]">
						<a href="[ ' href: moderate ' ]" class="btn-link">
							<input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]">
						</a>
				</td></tr>
			</table><br>
		=]
		[= rename _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' _t: ModerateRenameConfirm ' ]</th></tr>
				<tr>
					<td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<input type="text" name="new_tag" size="50" maxlength="250" value="[ ' title | e attr ' ]">
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]">
						<a href="[ ' href: moderate ' ]" class="btn-link">
							<input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]">
						</a>
						[= onlyone _ =
							<br><small>[ ' _t: ModerateRename1Only ' ]</small>
						=]
					</td>
				</tr>
			</table><br>
		=]
		[= merge _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' _t: ModerateMergeConfirm ' ]</th></tr>
				<tr>
					<td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<em>[ ' text ' ]</em><br>
						<select name="base">
							<option selected></option>
							[= o _ =
								<option value="[ ' topic ' ]">[ ' text ' ]</option>
							=]
						</select>
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]">
						<a href="[ ' href: moderate ' ]" class="btn-link">
							<input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]">
						</a>
					</td>
				</tr>
			</table><br>
		=]

		<input type="hidden" name="ids" value="[ ' hids ' ]">
		<input type="hidden" name="p" value="[ ' p ' ]">
		<table>
			<tr class="lined">
				<td colspan="5">
					<input type="submit" name="delete" id="submit_delete" value="[ ' _t: ModerateDelete ' ]">
					<input type="submit" name="move" id="submit_move" value="[ ' _t: ModerateMove ' ]"> 
					<input type="submit" name="rename" id="submit_rename" value="[ ' _t: RenameButton ' ]">
					<input type="submit" name="merge" id="submit_merge" value="[ ' _t: ModerateMerge ' ]">
					<input type="submit" name="lock" id="submit_lock" value="[ ' _t: ModerateLock ' ]">
					<input type="submit" name="unlock" id="submit_unlock" value="[ ' _t: ModerateUnlock ' ]">
					<br>
					<input type="submit" name="set" id="submit" value="[ ' _t: ModerateSet ' ]">
						[= set _ =
							<input type="submit" name="reset" id="submit" value="[ ' _t: ResetButton ' ]">
							&nbsp;&nbsp;&nbsp;<small>ids: [ ' ids ' ]</small>
						=]
				</td>
			</tr>
			<tr class="formation">
				<th colspan="2">[ ' _t: ForumTopic ' ]</th>
				<th>[ ' _t: ForumAuthor ' ]</th>
				<th>[ ' _t: ForumReplies ' ]</th>
				<th>[ ' _t: ForumCreated ' ]</th>
			</tr>

			[= n _ =
				<tr class="lined">
					<td class="label a-middle">
						<input type="checkbox" name="[ ' pageid ' ]" value="id" [ ' set | checkbox ' ]>
					</td>
					<td>
						[= locked _ =
							<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: DeleteCommentTip ' ]" alt="[ ' _t: DeleteText ' ]" class="btn-locked">
						=]
						[ ' moderate ' ] <strong>[ ' topic ' ]</strong>
					</td>
					<td class="t-center" title="[ ' ip ' ]"><small>&nbsp;&nbsp;[ ' user ' ]&nbsp;&nbsp;</small></td>
					<td class="t-center"><small>[ ' comments | number 0 , . ' ]</small></td>
					<td class="t-center nowrap"><small>&nbsp;&nbsp;[ ' created | time_formatted ' ]</small></td>
				</tr>
			=]

			</table>
		</form>
		[''' pagination ''']
	=]

	[= forum _ =
		[''' pagination ''']
		<form action="[ ' href: moderate ' ]" method="post" name="moderate_topic">
			[ ' csrf: moderate_topic ' ]

		[= delete _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th> [ ' _t: ModerateDeleteConfirm ' ]</th></tr>
				<tr>
					<td>
						<em>[ ' text ' ]</em><br>
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]">
						<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
					</td>
				</tr>
			</table><br>
		=]
		[= move _ =
			[= forum _ =
				<input type="hidden" name="[ ' action | e attr ' ]" value="1">
				<table class="formation">
					<tr><th> [ ' _t: ModerateMoveConfirm ' ]</th></tr>
					<tr>
						<td>
							[= e _ =
								<span class="cite"><strong>[ ' text ' ]</strong></span><br>
							=]
							<em>[ ' text ' ]</em><br>
							<select name="section">
								<option selected></option>
								[= o _ =
									<option value="[ ' tag ' ]">[ ' title | e ' ]</option>
								=]
							</select> or <input type="text" name="cluster" size="50" maxlength="250"><br>
							<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]"> 
							<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
						</td>
					</tr>
				</table><br>
			=]
			[= page _ =
				<input type="hidden" name="[ ' action | e attr ' ]" value="1">
				<table class="formation">
					<tr><th>[ ' _t: ModeratePgMoveConfirm ' ]</th></tr>
					<tr>
						<td>
							[= e _ =
								<span class="cite"><strong>[ ' text ' ]</strong></span><br>
							=]
						<em>[ ' text ' ]</em><br>
						<input type="text" name="cluster" size="50" maxlength="250">
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]">
						<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
					</td></tr>
				</table><br>
			=]
		=]
		[= rename _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th> [ ' _t: ModerateRenameConfirm ' ]</th></tr>
				<tr>
					<td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<input type="text" name="new_tag" size="50" maxlength="250" value="[ ' title | e attr ' ]"> 
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]"> 
						<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
					</td>
				</tr>
			</table><br>
		=]
		
		[= pdelete _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' confirm ' ]</th></tr>
				<tr>
					<td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]"> 
						<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
					</td>
				</tr>
			</table><br>
		=]
		[= psplit _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr>
					<th>[ ' split ' ]</th>
				</tr>
				<tr>
					<td>
						[= e _ =
							<span class="cite"><strong>[ ' text ' ]</strong></span><br>
						=]
						<input type="text" name="new_tag" size="50" maxlength="250" value=""> 
						<input type="submit" name="accept" id="submit" value="[ ' _t: ModerateAccept ' ]"> 
						<a href="[ ' href: moderate ' ]" class="btn-link"><input type="button" name="cancel" id="button" value="[ ' _t: CancelButton ' ]"></a>
						<br>
						<small>
						<input type="radio" name="scheme" value="after" id="after" [ ' after | checkbox ' ]> 
						<label for="after"> [ ' _t: ModerateSplitAllAfter ' ]</label><br>
						<input type="radio" name="scheme" value="selected" id="selected" [ ' selected | checkbox ' ]> 
						<label for="selected">[ ' count ' ]</label>
						</small>
					</td>
				</tr>
			</table><br>
		=]

		<input type="hidden" name="ids" value="[ ' hids ' ]">
		<input type="hidden" name="p" value="[ ' p ' ]">
		<table>
			<tr class="lined">
				<td colspan="2">
					<input type="submit" name="topic_delete" id="delete-submit" value="[ ' _t: ModerateDeleteTopic ' ]">
					<input type="submit" name="topic_move" id="move-submit" value="[ ' _t: ModerateMove ' ]">
					[= forum _ =
						<input type="submit" name="topic_rename" id="submit" value="[ ' _t: RenameButton ' ]">
						[= unlocked _ =
							<input type="submit" name="topic_lock" id="submit" value="[ ' _t: ModerateLock ' ]">
						=]
						[= locked _ =
							<input type="submit" name="topic_unlock" id="submit" value="[ ' _t: ModerateUnlock ' ]">
						=]
					=]
				</td>
			</tr>
			<tr class="formation">
				<th colspan="2">
					[= locked _ =
						<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: DeleteCommentTip ' ]" alt="[ ' _t: DeleteText ' ]" class="btn-locked">
					=]
					[ ' _t: ForumTopic ' ]
				</th>
			</tr>
			<tr class="lined">
				<td colspan="2" style="padding-bottom:30px;">
					<strong><small>
						[ ' user ' ]
						 ([ ' created | time_formatted ' ])</small></strong>
					<br>[ ' body ' ]
				</td>
			</tr>

		[= comments _ =
			<tr class="lined">
				<td colspan="2">
					<input type="submit" name="posts_delete" id="submit_delete" value="[ ' _t: ModerateDeletePosts ' ]">
					<input type="submit" name="posts_split" id="submit_split" value="[ ' _t: ModerateSplit ' ]">
					<br>
					<input type="submit" name="set" id="submit_set" value="[ ' _t: ModerateSet ' ]">
					[= set _ =
						<input type="submit" name="reset" id="submit_reset" value="[ ' _t: ResetButton ' ]">
						&nbsp;&nbsp;&nbsp;<small>ids: [ ' ids ' ]</small>
					=]
				</td>
			</tr>
			<tr class="formation">
				<th colspan="2"> [ ' _t: ForumComments ' ]</th>
				<th> [ ' _t: ForumAuthor ' ]</th>
				<th> [ ' _t: ForumCreated ' ]</th>
			</tr>
			[= n _ =
				<tr class="lined">
					<td class="label a-middle">
						<input type="checkbox" name="[ ' comment.page_id ' ]" value="id" [ ' set | checkbox ' ]>
					</td>
					<td>
						<strong>[ ' clink ' ]</strong>
						<br>[ ' desc ' ]
					</td>
					<td class="t-center" title="[ ' ip ' ]"><small>&nbsp;&nbsp;[ ' ulink ' ]&nbsp;&nbsp;</small></td>
					<td class="t-center nowrap"><small>&nbsp;&nbsp; [ ' comment.created | time_formatted ' ]</small></td>
				</tr>
			=]
		=]
		</table>
		</form>
		[''' pagination ''']
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
	