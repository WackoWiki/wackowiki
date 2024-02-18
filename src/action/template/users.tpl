first really BIG template written

[ === main === ]
	[ ' help ' ]
	[= not _ =
		<div class="msg error">[ ' found ' ]</div>
	=]
	[= disabled _ =
		<div class="msg info">[ ' _t: AccountDisabled ' ]</div>
	=]
	[ ''' u Profile  ''' ]
	[ ''' l UserList ''' ]

[ === // USERPROFILE ---------------------------------------------------------------------------------- === ]

[= Profile =]
	<h1>[ ' username | e ' ]</h1>
	<small><a href="[ ' href ' ]">« [ ' _t: UsersList ' ]</a></small>

	[= tab _ =
		<ul class="menu" id="list">
			[= li _ =
				[ ' commit | void  // alternation hack ' ]
				[= href _ =
					<li><a href="[ ' item.0 ' ]">[ ' item.1 ' ]</a></li>
				=]
				[= active _ =
					<li class="active">[ ' item ' ]</li>
				=]
			=]
		</ul>

		<h2>[ ' heading ' ]</h2>
		[ ' action ' ]
	=]

	[= prof _ =
		<table class="user-profile lined">
			<tr>
				<th scope="row">[ ' _t: RealName ' ]</th>
				<td>[ ' user.real_name | e ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: UsersSignupDate ' ]</th>
				<td>[ ' user.signup_time | time_format ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: UsersLastSession ' ]</th>
				<td>[ ''' last lastSession ''' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: UserSpace ' ]</th>
				[= userPage =
					<td><a href="[ ' href ' ]">[ ' text | e ' ]</a></td>
				=]
			</tr>
			<tr>
				<th scope="row">
					<a href="[ ' groupsPage ' ]">[ ' _t: UsersGroupMembership ' ]</a>
				</th>
				[= userGroups =
					<td>[ ' list ' ][ ' na UsersNA2 ' ]</td>
				=]
			</tr>
		</table>

		[= pm _ =
			<h2 class="heading">[ ' _t: UsersContact ' ]</h2>
			[= not _ =
				<table class="formation">
					<tr>
						<td colspan="2" class="t-center">
							<em>[ ' _t: PMNotLoggedIn ' ]</em>
						</td>
					</tr>
				</table>
			=]
			[= hint _ =
				<div class="msg hint">[ ' _t: IntercomHint ' ]</div>
			=]
			[= pm _ =
				[ ' // contact form ' ]
				<br>
				<form action="[ ' href ' ]" method="post" name="personal_message">
					[ ' csrf: personal_message ' ]
					<input type="hidden" name="profile" value="[ ' username | e attr ' ]">
					[= ref _ =
						<input type="hidden" name="ref" value="[ ' ref | e attr ' ]">
					=]
					<table class="formation">
						[= disabled _ =
							<tr>
								<td class="t-center">
									<strong><em>[ ' _t: IntercomDisabled ' ]</em></strong>
								</td>
							</tr>
						=]
						[= ic _ =
							<tr>
								<td>
									<label for="mail_subject">[ ' _t: IntercomSubject ' ]</label><br>
									<input type="text" id="mail_subject" name="mail_subject" class="cols-80" value="[ ' subj | e attr ' ]" size="80" maxlength="200" required>
									[= ref _ =
										&nbsp;&nbsp; <a href="[ ' href ' ]">[ ' _t: IntercomSubjectN ' ]</a>
									=]
								</td>
							</tr>
							<tr>
								<td>
									<label for="mail_body" class="visuallyhidden">[ ' _t: IntercomMessage ' ]</label>
									<textarea id="mail_body" name="mail_body" class="cols-80" cols="80" rows="15" required>[ ' body | e ' ]</textarea>
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="send_copy" name="send_copy" value="1">
									<label for="send_copy">[ ' _t: IntercomCopy ' ]</label>
								</td>
							</tr>
							<tr>
								<td>
									<button type="submit" id="submit" name="send_pm">[ ' _t: SendButton ' ]</button>
								</td>
							</tr>
							<tr>
								<td>
									<small>[ ' _t: IntercomDesc ' ]</small>
								</td>
							</tr>
						=]
					</table>
				</form>
			=]
		=]

		<h2 id="changes" class="heading">[ ' _t: UsersChanges ' ]</h2>
		<div class="indent"><small>[ ' _t: UsersRevisionsMade ' ] [ ' user.total_revisions | number_format ' ]</small></div><br>

		[ ''' nochanges UsersNA2 ''' ]
		[= changes _ =
			<small>[ '' desc userChangesDesc '' ][ '' asc userChangesAsc '' ]</small>
			[ '' pagination '' ]<br>
			<ul class="ul-list hl-line">
				[= li _ =
					<li>
						<small>[ ' modified | time_format ' ]</small>  — [ ' link ' ]
						[= edit =
							<small><span class="editnote">[[ ' note ' ]]</span></small>
						=]
					</li>
				=]
			</ul>
		=]

		<h2 id="comments" class="heading">[ ' _t: UsersComments ' ]</h2>
		[= cmtdisabled =
			[ ' _t: CommentsDisabled ' ]
		=]
		[= comments _ =
			<div class="indent"><small>[ ' _t: UsersCommentsPosted ' ] [ ' n | number_format ' ]</small></div>
			[ ''' none UsersNA2 ''' ]
			[= c _ =
				[ ''' pagination ''' ]<br>
				<ul class="ul-list hl-line">
					[= li _ =
						<li><small>[ ' created | time_format ' ]</small> — [ ' link ' ]</li>
					=]
				</ul>
			=]
		=]

		<h2 id="pages" class="heading">[ ' _t: UsersPages ' ]</h2>
		<div class="indent"><small>[ ' _t: UsersOwnedPages ' ] [ ' user.total_pages | number_format ' ]</small></div><br>

		[ ''' nopages UsersNA2 ''' ]
		[= pages _ =
			<small>[ '' date userPagesByDate '' ][ '' name userPagesByName '' ]</small>
			[ '' pagination '' ]<br>
			<ul class="ul-list hl-line">
				[= li _ =
					<li><small>[ ' created | time_format ' ]</small>  — [ ' link ' ]</li>
				=]
			</ul>
		=]

		[= files _ =
			<h2 id="uploads" class="heading">[ ' _t: UsersUploads ' ]</h2>
			[= u _ =
				<div class="indent"><small>[ ' _t: UsersFilesUploaded ' ] [ ' n | number_format ' ]</small></div>
				[ ''' none UsersNA2 ''' ]
				[= u2 _ =
					[ ''' pagination ''' ]<br>
					<ul class="ul-list hl-line">
						[= li _ =
							<li>
								<small>[ ' created | time_format ' ]</small>
								— [ ' link ' ]
								. . . . . . . . . . . . . . . .
								[ ' onpage ' ]</span>[ '' // TODO refactor! '' ]
								[ ' descr ' ]
							</li>
						=]
					</ul>
				=]
			=]
		=]
	=]

[ === userPagesByDate === ]
<a href="[ ' href ' ]#pages">[ ' _t: UsersDocsSortCreation ' ]</a>
[ === userPagesByName === ]
<a href="[ ' href ' ]#pages">[ ' _t: UsersDocsSortName ' ]</a>
[ === userChangesAsc === ]
<a href="[ ' href ' ]#changes">[ ' _t: UsersChangesSortAsc ' ]</a>
[ === userChangesDesc === ]
<a href="[ ' href ' ]#changes">[ ' _t: UsersChangesSortDesc ' ]</a>



[ === // USERLIST ------------------------------------------------------------------------------------- === ]

[= UserList =]
	[= groups _ =
		<h2 id="pages">[ ' members | e ' ] [ ' _t: GroupsMembers ' ]</h2>
		<br>
	=]
	[= form _ =
		[ '' // user filter form '' ]
		<form action="[ ' href ' ]" method="get" name="search_user">
			[ ' href | hide_page ' ]
			[= hid _ =
				<input type="hidden" name="[ ' param | e attr ' ]" value="[ ' value | e attr ' ]">
			=]
			<table class="formation">
				<tr>
					<td class="label">
						<label for="search_user" class="visuallyhidden">[ ' _t: UsersSearch ' ]</label>
						<input type="search" id="search_user" name="user" maxchars="40" size="40" value="[ ' user | e attr ' ]" placeholder="[ ' _t: UsersSearch ' ]" required> ['' '']
						<button type="submit" id="submit">[ ' _t: SearchButton ' ]</button> ['' '']
					</td>
				</tr>
			</table><br>
		</form>
	=]
	[ '' pagination '' ]
	<table class="user-table lined hl-line nowrap">
		<colgroup>
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
			<col span="1">
		</colgroup>
		<thead>
			<tr>
				[= s _ =
					<th><a href="[ ' link ' ]">[ ' what ' ][ ''' arrow sortsArr ''' ]</a></th>
				=]
			</tr>
		</thead>
		<tbody>
		[= u _ =
			<tr>
				<td>[ ' link ' ]</td>
				<td>[ ' user.total_pages | number_format ' ]</td>
				<td>[ ' user.total_comments | number_format ' ]</td>
				<td>[ ' user.total_revisions | number_format ' ]</td>
				[= reg _ =
					<td>[ ' user.total_uploads | number_format ' ]</td>
					<td>[ ' user.signup_time | time_format ' ]</td>
					<td>[ ' sess lastSession ' ]</td>
				=]
			</tr>
		=]
		</tbody>
	</table>
	[= none _ =
		<br>[ ' _t: UsersNoMatching ' ]
	=]
	[ '' pagination '' ]

[== sortsArr ==]
&nbsp;[ '' a | replace desc ↑ asc ↓ '' ]



[============================== // assorted utilities ==============================]

[= lastSession =]
[ ''' hidden sessionHidden ''' ][ ''' na sessionNA ''' ][ ''' last sessionTime ''' ]
[== sessionHidden ==]
<em>[ ' _t: UsersSessionHidden ' ]</em>
[== sessionNA ==]
<em>[ ' _t: UsersSessionNA ' ]</em>
[== sessionTime ==]
[ ' visit | time_format ' ]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= UsersNA2 =]
<em>[ ' _t: UsersNA2 ' ]</em>
