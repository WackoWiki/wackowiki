[ === main === ]
	<h3>
		[ ' _t: Moderation ' ] [ ' title ' ]
	</h3>
	[ ' moderate ' ]

	[= subforum _ =
		[ '' pagination '' ]
		<form action="[ ' href: moderate ' ]" method="post" name="moderate_subforum">
			[ ' csrf: moderate_subforum ' ]

		[= delete _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th>[ ' _t: ModerateDeleteConfirm ' ]</th></tr>
				<tr><td>
					<em>[ ' text ' ]</em><br>
					<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button> 
					[ '' cancel '' ]
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
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button>
						[ '' cancel '' ]
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
						<input type="text" name="new_tag" size="50" maxlength="250" value="[ ' title | e attr ' ]" required>
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button>
						[ '' cancel '' ]
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
								<option value="[ ' tag ' ]">[ ' topic ' ]</option>
							=]
						</select>
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button>
						[ '' cancel '' ]
					</td>
				</tr>
			</table><br>
		=]

		<input type="hidden" name="ids" value="[ ' hids ' ]">
		<input type="hidden" name="p" value="[ ' p ' ]">
		<table class="moderate">
			<thead>
				<tr class="lined">
					<td colspan="5">
						<button type="submit" name="delete" id="submit_delete" class="btn-danger">[ ' _t: DeleteButton ' ]</button>
						<button type="submit" name="move" id="submit_move">[ ' _t: ModerateMove ' ]</button> 
						<button type="submit" name="rename" id="submit_rename">[ ' _t: RenameButton ' ]</button>
						<button type="submit" name="merge" id="submit_merge">[ ' _t: ModerateMerge ' ]</button>
						<button type="submit" name="lock" id="submit_lock">[ ' _t: ModerateLock ' ]</button>
						<button type="submit" name="unlock" id="submit_unlock">[ ' _t: ModerateUnlock ' ]</button>
						<br>
						<button type="submit" name="set" id="submit">[ ' _t: SetButton ' ]</button>
							[= set _ =
								<button type="submit" name="reset" id="submit">[ ' _t: ResetButton ' ]</button>
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
			</thead>
			<tbody>
			[= n _ =
				<tr class="lined">
					<td>
						<input type="checkbox" name="id[[ ' n ' ]]" value="[ ' pageid ' ]" [ ' set | checkbox ' ]>
					</td>
					<td>
						[= locked _ =
							<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: ForumLocked ' ]" alt="[ ' _t: ForumLocked ' ]" class="btn-locked btn-sm">
						=]
						[ ' moderate ' ] <strong>[ ' topic ' ]</strong>
					</td>
					<td title="[ ' ip ' ]"><small>[ ' user ' ]</small></td>
					<td><small>[ ' comments | number_format ' ]</small></td>
					<td><small>[ ' created | time_format ' ]</small></td>
				</tr>
			=]
			</tbody>
		</table>
		</form>
		[ '' pagination '' ]
	=]

	[= forum _ =
		[ '' pagination '' ]
		<form action="[ ' href: moderate ' ]" method="post" name="moderate_topic">
			[ ' csrf: moderate_topic ' ]

		[= delete _ =
			<input type="hidden" name="[ ' action | e attr ' ]" value="1">
			<table class="formation">
				<tr><th> [ ' _t: ModerateDeleteConfirm ' ]</th></tr>
				<tr>
					<td>
						<em>[ ' text ' ]</em><br>
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button>
						[ '' cancel '' ]
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
							<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button> 
							[ '' cancel '' ]
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
						<input type="text" name="cluster" size="50" maxlength="250" required>
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button>
						[ '' cancel '' ]
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
						<input type="text" name="new_tag" size="50" maxlength="250" value="[ ' title | e attr ' ]" required> 
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button> 
						[ '' cancel '' ]
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
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button> 
						[ '' cancel '' ]
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
						<button type="submit" name="accept" id="submit">[ ' _t: ModerateAccept ' ]</button> 
						[ '' cancel '' ]
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
		<table class="moderate">
			<thead>
				<tr class="lined">
					<td colspan="2">
						<button type="submit" name="topic_delete" id="delete-submit">[ ' _t: ModerateDeleteTopic ' ]</button>
						<button type="submit" name="topic_move" id="move-submit">[ ' _t: ModerateMove ' ]</button>
						[= forum _ =
							<button type="submit" name="topic_rename" id="submit">[ ' _t: RenameButton ' ]</button>
							[= unlocked _ =
								<button type="submit" name="topic_lock" id="submit">[ ' _t: ModerateLock ' ]</button>
							=]
							[= locked _ =
								<button type="submit" name="topic_unlock" id="submit">[ ' _t: ModerateUnlock ' ]</button>
							=]
						=]
					</td>
				</tr>
				<tr class="formation">
					<th colspan="2">
						[= locked _ =
							<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: ForumLocked ' ]" alt="[ ' _t: ForumLocked ' ]" class="btn-locked btn-sm">
						=]
						[ ' _t: ForumTopic ' ]
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="lined">
					<td colspan="2" style="padding-bottom: 30px;">
						<strong><small>
							[ ' user ' ]
							 ([ ' created | time_format ' ])</small></strong>
						<br>[ ' body ' ]
					</td>
				</tr>
			</tbody>

		[= comments _ =
			<thead>
				<tr class="lined">
					<td colspan="4">
						<button type="submit" name="posts_delete" id="submit_delete">[ ' _t: ModerateDeletePosts ' ]</button>
						<button type="submit" name="posts_split" id="submit_split">[ ' _t: ModerateSplit ' ]</button>
						<br>
						<button type="submit" name="set" id="submit_set">[ ' _t: SetButton ' ]</button>
						[= set _ =
							<button type="submit" name="reset" id="submit_reset">[ ' _t: ResetButton ' ]</button>
							&nbsp;&nbsp;&nbsp;<small>ids: [ ' ids ' ]</small>
						=]
					</td>
				</tr>
				<tr class="formation">
					<th colspan="2"> [ ' _t: ForumComments ' ]</th>
					<th> [ ' _t: ForumAuthor ' ]</th>
					<th> [ ' _t: ForumCreated ' ]</th>
				</tr>
			</thead>
			<tbody>
			[= n _ =
				<tr class="lined">
					<td>
						<input type="checkbox" name="id[[ ' n ' ]]" value="[ ' comment.page_id ' ]" [ ' set | checkbox ' ]>
					</td>
					<td>
						<strong>[ ' clink ' ]</strong>
						<br>[ ' desc ' ]
					</td>
					<td title="[ ' ip ' ]"><small>[ ' ulink ' ]</small></td>
					<td><small>[ ' comment.created | time_format ' ]</small></td>
				</tr>
			=]
			</tbody>
		=]
		</table>
		</form>
		[ '' pagination '' ]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= cancel =]
<a href="[ ' href: moderate ' ]" class="btn-link">
	<button type="button" class="btn-cancel">[ ' _t: CancelButton ' ]</button>
</a>
	