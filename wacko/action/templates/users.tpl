first really BIG template written

[ === main === ]
[ ''' notFound ''' ]
[ ''' Disabled ''' ]
[ ''' u Profile ''' ]
[ ''' l UserList ''' ]

[ === notFound === ]
<div class="error">['' diag | '']</div>
[ === Disabled === ]
<div class="info">['' _t: AccountDisabled '']</div>

[ === lastSession === ]
<td>
	[ ''' hidden sessionHidden ''' ]
	[ ''' na sessionNA ''' ]
	[ ''' last sessionTime ''' ]
</td>
[ === sessionHidden === ]
<em>['' _t: UsersSessionHidden '']</em>
[ === sessionNA === ]
<em>['' _t: UsersSessionNA '']</em>
[ === sessionTime === ]
['' visit | time_formatted '']

[ === userPage === ]
<td><a href="['' href | e attr '']">['' text '']</a></td>

[ === userGroups === ]
<td>['' list | '']['' na userGroupsNA '']</td>
[ === userGroupsNA === ]
<em>['' _t: UsersNA2 '']</em>

[ === userPM === ]
<h2>['' _t: UsersContact '']</h2>
[ ''' pm userContact ''' ]
[ ''' not userContactNotLoggedIn ''' ]

[ === userContactNotLoggedIn === ]
<table class="formation"><tr><td colspan="2" style="text-align:center;"><em>['' _t: UsersPMNotLoggedIn '']</em></td></tr></table>

[ === userContactRef === ]
<input type="hidden" name="ref" value="['' ref | e attr '']" />

[ === userContactIntercom === ]
<tr>
	<td class="label" style="width:50px; white-space:nowrap;">['' _t: UsersIntercomSubject '']:</td>
	<td>
		<input type="text" name="mail_subject" value="['' subj '']" size="60" maxlength="200" />
		[ ''' ref intercomRef ''' ]
	</td>
</tr>
<tr>
	<td colspan="2"><textarea name="mail_body" cols="80" rows="15">['' body '']</textarea></td>
</tr>
<tr>
	<td><input type="submit" id="submit" name="send_pm" value="['' _t: UsersIntercomSend' '']" /></td>
</tr>
<tr>
	<td colspan="2">
		<small>['' _t: UsersIntercomDesc '']</small>
	</td>
</tr>

[ === intercomRef === ]
&nbsp;&nbsp; <a href="['' href | e attr '']">['' _t: UsersIntercomSubjectN '']</a>

[ === userContactDisabled === ]
<tr><td colspan="2" style="text-align:center;"><strong><em>['' _t: UsersIntercomDisabled '']</em></strong></td></tr>

[ === userContact === ]
['' // contact form '']
<br />
<form action="[' href | e html_attr']" method="post" name="personal_message">
	[' // hide_page: | ']
	[' csrf: personal_message | ']
	<input type="hidden" name="profile" value="['' username '']" />
	[ ''' ref userContactRef ''' ]
	<table class="formation">
		[ ''' ic userContactIntercom ''' ]
		[ ''' userContactDisabled ''' ]
	</table>
</form>

[ === pagination === ]
<nav class="pagination">['' text | '']</nav>

[ === userPagesByDate === ]
<a href="['' href | e attr '']#pages">['' _t: UsersDocsSortDate '']
[ === userPagesByName === ]
<a href="['' href | e attr '']#pages">['' _t: UsersDocsSortName '']

[ === userPageLi === ]
<li class="lined"><small>['' created | time_formatted '']</small>  &mdash; ['' link | '']</li>

[ === userPages === ]
['' // sorting and pagination '']
<small>[ '' date userPagesByDate '' ][ '' name userPagesByName '' ]</small>
['' pagination '']
<ul class="ul_list">
	['' li userPageLi '']
</ul>

[ === userPagesNA === ]
<em>['' _t: UsersNA2 '']</em>

[ === CommentsDisabled === ]
['' _t: CommentsDisabled '']
[ === userComments === ]
<div class="indent"><small>['' _t: UsersCommentsPosted '']: ['' n '']</small></div>
[ ''' c userComments2 ''' ]
[ ''' none userPagesNA // reuse! ''' ]
[ === userComments2 === ]
[ ''' pagination ''' ]
<ul class="ul_list">
	[ ''' li userCommentsLi ''' ]
</ul>
[ === userCommentsLi === ]
<li class="lined"><small>['' created | time_formatted '']</small> &mdash; ['' link | '']</li>

[ === uploads === ]
<h2 id="uploads">['' _t: UsersUploads '']</h2>
[ ''' u uploads2 ''' ]
[ === uploads2 === ]
<div class="indent"><small>['' _t: UsersFilesUploaded '']: ['' n '']</small></div>
[ ''' u2 uploads3 ''' ]
[ ''' none userPagesNA // reuse! ''' ]
[ === uploads3 === ]
[ ''' pagination ''' ]
<ul class="ul_list">
	[ ''' li uploadsLi ''' ]
</ul>
[ === uploadsLi === ]
<li class="lined"><small>['' t | time_formatted '']
</small>  &mdash; ['' link | '']
['' Separator ''] ['' onpage | '']</span>['' descr | '']</li>
[ === Separator === ]
 . . . . . . . . . . . . . . . . ['' '']

[ === Profile === ]
<h1>['' user.user_name '']</h1>
<small><a href="['' href | e attr'']">&laquo; ['' _t: UsersList '']</a></small>
<h2>['' _t: UsersProfile '']</h2>
[''
	// basic info
'']
<table style="border-spacing: 3px; border-collapse: separate;">
	<tr class="lined">
		<td class="userprofil">['' _t: RealName '']</td>
		<td>['' user.real_name '']</td>
	</tr>
	<tr class="lined">
		<td class="userprofil">['' _t: UsersSignupDate '']</td>
		<td>['' user.signup_time | time_formatted '']</td>
	</tr>
	<tr class="lined">
		<td class="userprofil">['' _t: UsersLastSession '']</td>
		[ ''' last lastSession ''' ]
	</tr>
	<tr class="lined">
		<td class="userprofil">['' _t: UserSpace '']</td>
		[ ''' userPage ''' ]
	</tr>
	<tr class="lined">
		<td class="userprofil"><a href="['' groupsPage | e attr '']">['' _t: UsersGroupMembership '']</a></td>
		[ ''' userGroups ''' ]
	</tr>
</table>

[ ''' pm userPM ''' ]

<h2 id="pages">['' _t: UsersPages '']</h2>
<div class="indent"><small>['' _t: UsersOwnedPages '']: ['' user.total_pages '']
	&nbsp;&nbsp;&nbsp; ['' _t: UsersRevisionsMade '']: ['' user.total_revisions '']</small></div><br />

[ ''' pages userPages ''' ]
[ ''' userPagesNA ''' ]

<h2 id="comments">['' _t: UsersComments '']</h2>

[ ''' cmt userComments ''' ]
[ ''' CommentsDisabled ''' ]

[ ''' up uploads ''' ]

[ ''' # USERLIST then ------------------------------------------------------------------------------------- ''' ]
[ === Sorts === ]
<th><a href="['' link | '']">['' what '']['' arrow sortsArr '']</a></th>
[ === sortsArr === ]
&nbsp;&['' a | replace desc uarr asc darr ''];
[ === usersNone === ]
<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>['' _t: UsersNoMatching '']</em></small></td></tr>
[ === lastSessionReuse === ]
[ ''' hidden sessionHidden ''' ]
[ ''' na sessionNA ''' ]
[ ''' last sessionTime ''' ]
[ === usersOneRegistered === ]
<td style="text-align:center;">['' user.total_uploads '']</td>
<td style="text-align:center;">['' user.signup_time | time_formatted '']</td>
<td style="text-align:center;">['' sess lastSessionReuse '']</td>
[ === usersOne === ]
<tr class="lined">
	<td style="padding-left:5px;">['' link | '']</td>
	<td style="text-align:center;">['' user.total_pages '']</td>
	<td style="text-align:center;">['' user.total_comments '']</td>
	<td style="text-align:center;">['' user.total_revisions '']</td>
	[ ''' reg usersOneRegistered ''' ]
</tr>

[ === UserList === ]
['' // user filter form '']
<form action="[' href | e html_attr']" method="get" name="search_user">
	[' hide_page: | ']
	<table class="formation"><tr><td class="label">
	['' _t: UsersSearch '']: </td><td>
	<input type="search" required="required" name="user" maxchars="40" size="40" value="['' user0 '']" /> ['' '']
	<input type="submit" id="submit" value="['' _t: UsersFilter '']" /> ['' '']
	['' // echo <input type="submit" id="button" value="_t('UsersOpenProfile') . '" name="gotoprofile" /> '']
	</td></tr></table><br />
</form>

['' pagination '']
<table style="width:100%; white-space:nowrap; padding-right:20px;border-spacing: 3px;border-collapse: separate;">
	<tr>
		['' s Sorts '']
	</tr>

	[ ''' none usersNone ''' ] 
	[ ''' u usersOne ''' ] 
</table>
['' pagination '']
