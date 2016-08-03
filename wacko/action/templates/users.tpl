first really BIG template written

[ === main === ]
	[= not _ =
		<div class="error">['' found '']</div>
	=]
	[= disabled _ =
		<div class="info">['' _t: AccountDisabled '']</div>
	=]
	[''' u Profile  ''']
	[''' l UserList ''']

[ === // USERPROFILE ---------------------------------------------------------------------------------- === ]

[= Profile =]
	<h1>[ ' user.user_name |e ' ]</h1>
	<small><a href="[ ' href ' ]">&laquo; [ ' _t: UsersList ' ]</a></small>
	<h2>[ ' _t: UsersProfile ' ]</h2>

	<table style="border-spacing: 3px; border-collapse: separate;">
		<tr class="lined">
			<td class="userprofil">[ ' _t: RealName ' ]</td>
			<td>[ ' user.real_name |e ' ]</td>
		</tr>
		<tr class="lined">
			<td class="userprofil">[ ' _t: UsersSignupDate ' ]</td>
			<td>[ ' user.signup_time | time_formatted ' ]</td>
		</tr>
		<tr class="lined">
			<td class="userprofil">[ ' _t: UsersLastSession ' ]</td>
			<td>[ ''' last lastSession ''' ]</td>
		</tr>
		<tr class="lined">
			<td class="userprofil">[ ' _t: UserSpace ' ]</td>
			[= userPage =
				<td><a href="[ ' href ' ]">[ ' text |e ' ]</a></td>
			=]
		</tr>
		<tr class="lined">
			<td class="userprofil"><a href="[ ' groupsPage ' ]">[ ' _t: UsersGroupMembership ' ]</a></td>
			[= userGroups =
				<td>[ ' list ' ][ ' na UsersNA2 ' ]</td>
			=]
		</tr>
	</table>

	[= pm _ =
		<h2>[ ' _t: UsersContact ' ]</h2>
		[= not _ =
			<table class="formation"><tr><td colspan="2" style="text-align:center;"><em>[ ' _t: UsersPMNotLoggedIn ' ]</em></td></tr></table>
		=]
		[= pm _ =
			[ ' // contact form ' ]
			<br />
			<form action="[ ' href ' ]" method="post" name="personal_message">
				[' csrf: personal_message ']
				<input type="hidden" name="profile" value="[ ' username |e attr ' ]" />
				[= ref _ =
					<input type="hidden" name="ref" value="[ ' ref | e attr ' ]" />
				=]
				<table class="formation">
					[= disabled _ =
						<tr><td colspan="2" style="text-align:center;"><strong><em>[ ' _t: UsersIntercomDisabled ' ]</em></strong></td></tr>
					=]
					[= ic _ =
						<tr>
							<td class="label" style="width:50px; white-space:nowrap;">[ ' _t: UsersIntercomSubject ' ]:</td>
							<td>
								<input type="text" name="mail_subject" value="[ ' subj |e attr ' ]" size="60" maxlength="200" />
								[= ref _ =
									&nbsp;&nbsp; <a href="[ ' href ' ]">[ ' _t: UsersIntercomSubjectN ' ]</a>
								=]
							</td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="mail_body" cols="80" rows="15">[ ' body |e ' ]</textarea></td>
						</tr>
						<tr>
							<td><input type="submit" id="submit" name="send_pm" value="[ ' _t: UsersIntercomSend ' ]" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<small>[ ' _t: UsersIntercomDesc ' ]</small>
							</td>
						</tr>
					=]
				</table>
			</form>
		=]
	=]

	<h2 id="pages">[ ' _t: UsersPages ' ]</h2>
	<div class="indent"><small>[ ' _t: UsersOwnedPages ' ]: [ ' user.total_pages |e ' ]
		&nbsp;&nbsp;&nbsp; [ ' _t: UsersRevisionsMade ' ]: [ ' user.total_revisions |e ' ]</small></div><br />

	[ ''' nopages UsersNA2 ''' ]
	[= pages _ =
		<small>[ '' date userPagesByDate '' ][ '' name userPagesByName '' ]</small>
		['' pagination '']
		<ul class="ul_list">
			[= li _ =
				<li class="lined"><small>[ ' created | time_formatted ' ]</small>  &mdash; [ ' link ' ]</li>
			=]
		</ul>
	=]

	<h2 id="comments">[ ' _t: UsersComments ' ]</h2>
	[= cmtdisabled =
		[ ' _t: CommentsDisabled ' ]
	=]
	[= cmt _ =
		<div class="indent"><small>[ ' _t: UsersCommentsPosted ' ]: [ ' n |e ' ]</small></div>
		[ ''' none UsersNA2 ''' ]
		[= c _ =
			[ ''' pagination ''' ]
			<ul class="ul_list">
				[= li _ =
					<li class="lined"><small>[ ' created | time_formatted ' ]</small> &mdash; [ ' link ' ]</li>
				=]
			</ul>
		=]
	=]

	[= up _ =
		<h2 id="uploads">[ ' _t: UsersUploads ' ]</h2>
		[= u _ =
			<div class="indent"><small>[ ' _t: UsersFilesUploaded ' ]: [ ' n |e ' ]</small></div>
			[ ''' none UsersNA2 ''' ]
			[= u2 _ =
				[ ''' pagination ''' ]
				<ul class="ul_list">
					[= li _ =
						<li class="lined">
							<small>[ ' t | time_formatted ' ]</small>
							&mdash; [ ' link ' ]
							. . . . . . . . . . . . . . . .
							[ ' onpage ' ]</span>['' // TODO refactor! '']
							[ ' descr ' ]
						</li>
					=]
				</ul>
			=]
		=]
	=]

[ === userPagesByDate === ]
<a href="[ ' href ' ]#pages">[ ' _t: UsersDocsSortDate ' ]</a>
[ === userPagesByName === ]
<a href="[ ' href ' ]#pages">[ ' _t: UsersDocsSortName ' ]</a>



[ === // USERLIST ------------------------------------------------------------------------------------- === ]

[= UserList =]
	[= groups _ =
		<h2 id="pages">[ ' members |e ' ] [ ' _t: GroupsMembers ' ]</h2>
		<br />
	=]
	[= form _ =
		['' // user filter form '']
		<form action="[ ' href ' ]" method="get" name="search_user">
			[ ' href | hide_page ' ]
			[= hid _ =
				<input type="hidden" name="[ ' param |e attr ' ]" value="[ ' value |e attr ' ]" />
			=]
			<table class="formation"><tr><td class="label">
			[ ' _t: UsersSearch ' ]: </td><td>
			<input type="search" name="user" maxchars="40" size="40" value="[ ' user | e attr ' ]" /> ['' '']
			<input type="submit" id="submit" value="[ ' _t: UsersFilter ' ]" /> ['' '']
			['' // echo <input type="submit" id="button" value="_t('UsersOpenProfile') . '" name="gotoprofile" /> '']
			</td></tr></table><br />
		</form>
	=]
	['' pagination '']
	<table style="width:100%; white-space:nowrap; padding-right:20px;border-spacing: 3px;border-collapse: separate;">
		<tr>
			[= s _ =
				<th><a href="[ ' link ' ]">[ ' what ' ][''' arrow sortsArr ''']</a></th>
			=]
		</tr>

		[= none _ =
			<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>[ ' _t: UsersNoMatching ' ]</em></small></td></tr>
		=]
		[= u _ =
			<tr class="lined">
				<td style="padding-left:5px;">[ ' link ' ]</td>
				<td style="text-align:center;">[ ' user.total_pages |e ' ]</td>
				<td style="text-align:center;">[ ' user.total_comments |e ' ]</td>
				<td style="text-align:center;">[ ' user.total_revisions |e ' ]</td>
				[= reg _ =
					<td style="text-align:center;">[ ' user.total_uploads |e ' ]</td>
					<td style="text-align:center;">[ ' user.signup_time | time_formatted ' ]</td>
					<td style="text-align:center;">[ ' sess lastSession ' ]</td>
				=]
			</tr>
		=]
	</table>
	['' pagination '']

[== sortsArr ==]
&nbsp;&['' a | replace desc uarr asc darr ''];



[============================== // assorted utilities ==============================]

[= lastSession =]
[ ''' hidden sessionHidden ''' ][ ''' na sessionNA ''' ][ ''' last sessionTime ''' ]
[== sessionHidden ==]
<em>[ ' _t: UsersSessionHidden ' ]</em>
[== sessionNA ==]
<em>[ ' _t: UsersSessionNA ' ]</em>
[== sessionTime ==]
[ ' visit | time_formatted ' ]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= UsersNA2 =]
<em>[ ' _t: UsersNA2 ' ]</em>
