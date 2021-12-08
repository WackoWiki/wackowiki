[ === main === ]
	<!--notypo-->
	<h3>[ ' _t: UserSettings ' ] » [ ' header ' ] </h3>
	[ ' tabs ' ]
	<br><br>
	[= menu _ =
		[ ' action ' ]
	=]
	[= n _ =
		<form action="[ ' href: ' ]" method="post" name="user_settings_notifications">
			[ ' csrf: user_settings_notifications ' ]
			<div class="page-settings">
				<table class="form-tbl">
					<colgroup>
						<col span="1" width="30%">
						<col span="1" width="70%">
					</colgroup>
					<tbody>
						[= e _ =
							<tr>
								<th>[ ' _t: UserSettingsEmailMe ' ]&nbsp;</th>
								<td>
									<input type="checkbox" id="send_watchmail" name="send_watchmail"[ ' watchmail | checkbox ' ]>
									<label for="send_watchmail">[ ' _t: SendWatchEmail ' ]</label>
								</td>
							</tr>
							<tr>
								<th>
									<label for="notify_page">[ ' _t: NotifyPageEdit ' ]</label>
								</th>
								<td>
									<input type="radio" id="notify_page0" name="notify_page"[ ' notifypage | check 0 ' ]><label for="notify_page0">[ ' _t: NotifyOff ' ]</label>
									<input type="radio" id="notify_page1" name="notify_page"[ ' notifypage | check 1 ' ]><label for="notify_page1">[ ' _t: NotifyAlways ' ]</label>
									<input type="radio" id="notify_page2" name="notify_page"[ ' notifypage | check 2 ' ]><label for="notify_page2" title="[ ' _t: NotifyPendingPageTip ' ] [ ' _t: NotifyPendingTip ' ]">[ ' _t: NotifyPending ' ]</label>
									[== CommentedOut _ =
										<input type="radio" id="notify_page3" name="notify_page"[ ' notifypage | check 3 ' ]><label for="notify_page3">[ ' _t: NotifyDigest ' ]</label>
									=]
								</td>
							</tr>
							<tr>
								<th>
									<label for="notify_comment">[ ' _t: NotifyComment ' ]</label>
								</th>
								<td>
									<input type="radio" id="notify_comment0" name="notify_comment"[ ' notifycomment | check 0 ' ]><label for="notify_comment0">[ ' _t: NotifyOff ' ]</label>
									<input type="radio" id="notify_comment1" name="notify_comment"[ ' notifycomment | check 1 ' ]><label for="notify_comment1">[ ' _t: NotifyAlways ' ]</label>
									<input type="radio" id="notify_comment2" name="notify_comment"[ ' notifycomment | check 2 ' ]><label for="notify_comment2" title="[ ' _t: NotifyPendingCommentTip ' ] [ ' _t: NotifyPendingTip ' ]">[ ' _t: NotifyPending ' ]</label>
									[== CommentedOut _ =
										<input type="radio" id="notify_comment3" name="notify_comment"[ ' notifycomment | check 3 ' ]><label for="notify_comment3">[ ' _t: NotifyDigest ' ]</label>
									=]
								</td>
							</tr>
							[= m _ =
								<tr>
									<td>&nbsp;</td>
									<td>
										<input type="checkbox" id="notify_minor_edit" name="notify_minor_edit"[ ' minor | checkbox ' ]>
										<label for="notify_minor_edit">[ ' _t: NotifyMinorEdit ' ]</label>
									</td>
								</tr>
							=]
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="checkbox" id="allow_intercom" name="allow_intercom"[ ' intercom | checkbox ' ]>
									<label for="allow_intercom">[ ' _t: AllowIntercom ' ]</label>
								</td>
							</tr>
						=]
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="allow_massemail" name="allow_massemail"[ ' massemail | checkbox ' ]>
								<label for="allow_massemail">[ ' _t: AllowMassemail ' ]</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<button type="submit" class="btn-ok" id="submit" name="submit">[ ' _t: UpdateSettingsButton ' ]</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	=]
	[= e _ =
		<form action="[ ' href: ' ]" method="post" name="user_settings_extended">
			[ ' csrf: user_settings_extended ' ]
			<div class="page-settings">
			<table class="form-tbl">
				<colgroup>
					<col span="1" width="30%">
					<col span="1" width="70%">
				</colgroup>
			<tbody>
				<tr>
					<th scope="row">[ ' _t: UserSettingsOther ' ]</th>
					<td>
						<input type="checkbox" id="doubleclick_edit" name="doubleclick_edit"[ ' doubleclick | checkbox ' ]>
						<label for="doubleclick_edit">[ ' _t: DoubleclickEditing ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="autocomplete" name="autocomplete"[ ' autocomplete | checkbox ' ]>
						<label for="autocomplete">[ ' _t: WikieditAutocomplete ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="numerate_links" name="numerate_links"[ ' numerate | checkbox ' ]>
						<label for="numerate_links">[ ' _t: NumerateLinks ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="show_comments" name="show_comments"[ ' showcomments | checkbox ' ]>
						<label for="show_comments">[ ' _t: DoShowComments ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="show_files" name="show_files"[ ' showfiles | checkbox ' ]>
						<label for="show_files">[ ' _t: DoShowFiles ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="show_spaces" name="show_spaces"[ ' showspaces | checkbox ' ]>
						<label for="show_spaces">[ ' _t: ShowSpaces ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" id="dont_redirect" name="dont_redirect"[ ' noredirect | checkbox ' ]>
						<label for="dont_redirect">[ ' _t: DontRedirect ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" name="validate_ip" id="validate_ip"[ ' validateip | checkbox ' ]>
						<label for="validate_ip">[ ' _t: ValidateIP ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="checkbox" name="hide_lastsession" id="hide_lastsession"[ ' hidesession | checkbox ' ]>
						<label for="hide_lastsession">[ ' _t: HideLastSession ' ]</label>
					</td>
				</tr>
				[= anon _ =
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="checkbox" name="noid_pubs" id="noid_pubs"[ ' hidesession | checkbox ' ]>
							<label for="noid_pubs">[ ' _t: ProfileAnonymousPub ' ]</label>
						</td>
					</tr>
				=]
				<tr>
					<th><label for="default_diff_mode">[ ' _t: DefaultDiffMode ' ]</label></th>
					<td>
						<select id="default_diff_mode" name="diff_mode">
							<option value="">--</option>
							[= o _ =
								<option value="[ ' id ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' mode ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="session_length">[ ' _t: SessionDuration ' ]</label></th>
					<td>
						<input type="radio" id="duration0" name="session_length" value="0"[ ' sessionlength | check 0 ' ]><label for="duration0">[ ' _t: SessionDurationSession ' ]</label>
						<input type="radio" id="duration1" name="session_length" value="1"[ ' sessionlength | check 1 ' ]><label for="duration1">[ ' _t: SessionDurationDay ' ]</label>
						<input type="radio" id="duration7" name="session_length" value="7"[ ' sessionlength | check 7 ' ]><label for="duration7">[ ' _t: SessionDurationWeek ' ]</label>
						<input type="radio" id="duration30" name="session_length" value="30"[ ' sessionlength | check 30 ' ]><label for="duration30">[ ' _t: SessionDurationMonth ' ]</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<button type="submit" class="btn-ok" id="submit" name="submit">[ ' _t: UpdateSettingsButton ' ]</button>
					</td>
				</tr>
			</tbody>
			</table>
			</div>
		</form>
	=]
	[= g _ =
		<form action="[ ' href: ' ]" method="post" name="user_settings_general">
			[ ' csrf: user_settings_general ' ]
			<div class="page-settings">
				<table class="form-tbl">
					<colgroup>
						<col span="1" width="30%">
						<col span="1" width="70%">
					</colgroup>
				<tbody>
					<tr>
						<th scope="row">
							[ ' _t: UserName ' ]
						</th>
						<td>
							<strong>[ ' userlink ' ]</strong>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="real_name">[ ' _t: RealName ' ]</label>
						</th>
						<td>
							<input type="text" id="real_name" name="real_name" value="[ ' realname | e attr ' ]" size="40" maxlength="80">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<a href="[ ' href ' ]">[ ' _t: YouWantChangePassword ' ]</a>
						</th>
						<td>
							<a href="[ ' href ' ]" class="btn-link"><button type="button" id="button" name="_password">[ ' _t: YouWantChangePassword ' ]</button></a>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="email">[ ' _t: EmailAddress ' ]</label>
						</th>
						<td>
							<input type="email" id="email" name="email" value="[ ' email | e attr ' ]" size="40">&nbsp;
							<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' confirm ' ]" title="[ ' confirm ' ]" class="[ ' icon ' ]">
							[= verify _ =
								<div class="msg hint"><strong class="cite">
									[ ' _t: EmailNotVerified ' ]</strong><br>
									<small>
										[ ' _t: EmailNotVerifiedDesc ' ]
										<strong><a href="[ ' href ' ]">[ ' _t: HereLink ' ]</a></strong>
									</small>
								</div>
							=]
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="user_lang">[ ' _t: YourLanguage ' ]</label>
						</th>
						<td>
							[ ' lang ' ]
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="theme">[ ' _t: ChooseTheme ' ]</label>
						</th>
						<td>
							<select id="theme" name="theme">
								<option value="">--</option>
								[= t _ =
									<option value="[ ' theme ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' theme ' ]</option>
								=]
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="timezone">[ ' _t: Timezone ' ]</label>
						</th>
						<td>
							<select id="timezone" name="timezone">
								<option value="">--</option>
								[= z _ =
									<option value="[ ' offset ' ]" [ ' sel | list "" 'selected ' ' ]>[ ' timezone | truncate 50 ' ]</option>
								=]
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="sorting_comments">[ ' _t: SortComment ' ]</label>
						</th>
						<td>
							<select id="sorting_comments" name="sorting_comments">
								<option value="0"[ ' sortcomments | select 0 ' ]>[ ' _t: SortCommentAsc ' ]</option>
								<option value="1"[ ' sortcomments | select 1 ' ]>[ ' _t: SortCommentDesc ' ]</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="menu_items">[ ' _t: MenuItemsShown ' ]</label>
						</th>
						<td>
							<input type="number" id="menu_items" name="menu_items" value="[ ' menuitems ' ]" size="40" min="0" max="20">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="list_count">[ ' _t: RecordsPerPage ' ]</label>
						</th>
						<td>
							<select id="list_count" name="list_count">
								<option value="10"[ ' listcount | select 10 ' ]>10</option>
								<option value="20"[ ' listcount | select 20 ' ]>20</option>
								<option value="30"[ ' listcount | select 30 ' ]>30</option>
								<option value="50"[ ' listcount | select 50 ' ]>50</option>
								<option value="100"[ ' listcount | select 100 ' ]>100</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<button type="submit" class="btn-ok" id="submit" name="submit">[ ' _t: UpdateSettingsButton ' ]</button>
							&nbsp;
							<a href="[ ' logout ' ]" class="btn-link"><button type="button" class="btn-cancel">[ ' _t: LogoutButton ' ]</button></a>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
			<br>
		</form>

		<aside class="sidebar">
			<table class="form-tbl lined">
				<tr>
					<th scope="row">[ ' _t: UserSpace ' ]</th>
					<td><a href="[ ' userpage ' ]">[ ' db: users_page ' ]/[ ' user.user_name ' ]</a></td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UsersSignup ' ]</th>
					<td>[ ' user.signup_time | time_formatted ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UsersLastSession ' ]</th>
					<td>[ ' user.last_visit | time_formatted ' ]</td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UploadQuota ' ]&nbsp;&nbsp;</th>
					<td title="[ ' _t: UploadQuotaTip ' ]"><div class="meter"><span style="width: 25%;">[ ' quota ' ] ([ ' percentage ' ])</span></div></td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UsersPages ' ]</th>
					<td><a href="[ ' pages ' ]" title="[ ' _t: SeeListOfPages ' ]">[ ' user.total_pages | number 0 , . ' ]</a></td>
				</tr>
				[== CommentedOut _ =
					<tr>
						<th scope="row">[ ' _t: UsersRevisions ' ]</th>
						<td><a href="[ ' revisions ' ]" title="[ ' _t: RevisionTip ' ]">[ ' user.total_revisions | number 0 , . ' ]</a></td>
					</tr>
				==]
				<tr>
					<th scope="row">[ ' _t: UsersComments ' ]</th>
					<td><a href="[ ' comments ' ]" title="[ ' _t: ShowComments ' ]">[ ' user.total_comments | number 0 , . ' ]</a></td>
				</tr>
				<tr>
					<th scope="row">[ ' _t: UsersUploads ' ]</th>
					<td><a href="[ ' uploads ' ]" title="[ ' _t: ShowFiles ' ]">[ ' user.total_uploads | number 0 , . ' ]</a></td>
				</tr>
				[== CommentedOut _ =
					<tr>
						<th scope="row">[ ' _t: UsersLogins ' ]</th>
						<td>[ ' user.login_count | number 0 , . ' ]</td>
					</tr>
				==]
			</table>
		</aside>
	=]
	<!--/notypo-->
