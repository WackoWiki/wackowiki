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
	
	[= tab _ =
		<ul class="menu" id="list">
			<li><a href="[ ' href0 ' ]">[ ' _t: UsersProfile ' ]</a></li>
			<li><a href="[ ' href1 ' ]">[ ' _t: UsersPages ' ]</a></li>
			<li><a href="[ ' href2 ' ]">[ ' _t: UsersChanges ' ]</a></li>
			<li><a href="[ ' href3 ' ]">[ ' _t: UsersSubscription ' ]</a></li>
			<li><a href="[ ' href4 ' ]">[ ' _t: UsersWatches ' ]</a></li>
		</ul>

		<h2>[ ' heading ' ]</h2>
		[ ' action ' ]
	=]

	[= prof _ =

	<table class="userprofile lined">
		<tr>
			<th scope="row">[ ' _t: RealName ' ]</th>
			<td>[ ' user.real_name |e ' ]</td>
		</tr>
		<tr>
			<th scope="row">[ ' _t: UsersSignupDate ' ]</th>
			<td>[ ' user.signup_time | time_formatted ' ]</td>
		</tr>
		<tr>
			<th scope="row">[ ' _t: UsersLastSession ' ]</th>
			<td>[ ''' last lastSession ''' ]</td>
		</tr>
		<tr>
			<th scope="row">[ ' _t: UserSpace ' ]</th>
			[= userPage =
				<td><a href="[ ' href ' ]">[ ' text |e ' ]</a></td>
			=]
		</tr>
		<tr>
			<th scope="row"><a href="[ ' groupsPage ' ]">[ ' _t: UsersGroupMembership ' ]</a></th>
			[= userGroups =
				<td>[ ' list ' ][ ' na UsersNA2 ' ]</td>
			=]
		</tr>
	</table>

	[= pm _ =
		<h2>[ ' _t: UsersContact ' ]</h2>
		[= not _ =
			<table class="formation"><tr><td colspan="2" class="t_center"><em>[ ' _t: UsersPMNotLoggedIn ' ]</em></td></tr></table>
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
						<tr><td colspan="2" class="t_center"><strong><em>[ ' _t: UsersIntercomDisabled ' ]</em></strong></td></tr>
					=]
					[= ic _ =
						<tr>
							<td class="label nowrap" style="width:50px;">[ ' _t: UsersIntercomSubject ' ]:</td>
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
		['' pagination '']<br />
		<ul class="ul_list lined">
			[= li _ =
				<li><small>[ ' created | time_formatted ' ]</small>  &mdash; [ ' link ' ]</li>
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
			[ ''' pagination ''' ]<br />
			<ul class="ul_list lined">
				[= li _ =
					<li><small>[ ' created | time_formatted ' ]</small> &mdash; [ ' link ' ]</li>
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
				[ ''' pagination ''' ]<br />
				<ul class="ul_list lined">
					[= li _ =
						<li>
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
			<table class="formation">
				<tr>
					<td class="label">
						[ ' _t: UsersSearch ' ]:
					</td>
					<td>
						<input type="search" name="user" maxchars="40" size="40" value="[ ' user | e attr ' ]" /> ['' '']
						<input type="submit" id="submit" value="[ ' _t: UsersFilter ' ]" /> ['' '']
						['' // echo <input type="submit" id="button" value="_t('UsersOpenProfile') . '" name="gotoprofile" /> '']
					</td>
				</tr>
			</table><br />
		</form>
	=]
	['' pagination '']
	<table class="lined nowrap" style="width:100%; padding-right:20px;border-spacing: 3px;border-collapse: separate;">
		<colgroup>
			<col span="1" style="padding-left:5px;">
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
					<th><a href="[ ' link ' ]">[ ' what ' ][''' arrow sortsArr ''']</a></th>
				=]
			</tr>
		</thead>
		<tbody>
		[= none _ =
			<tr><td colspan="5" class="t_center" style="padding:10px;"><small><em>[ ' _t: UsersNoMatching ' ]</em></small></td></tr>
		=]
		[= u _ =
			<tr>
				<td style="padding-left:5px;">[ ' link ' ]</td>
				<td class="t_center">[ ' user.total_pages |e ' ]</td>
				<td class="t_center">[ ' user.total_comments |e ' ]</td>
				<td class="t_center">[ ' user.total_revisions |e ' ]</td>
				[= reg _ =
					<td class="t_center">[ ' user.total_uploads |e ' ]</td>
					<td class="t_center">[ ' user.signup_time | time_formatted ' ]</td>
					<td class="t_center">[ ' sess lastSession ' ]</td>
				=]
			</tr>
		=]
		</tbody>
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
