
[ === main === ]
	[= error _ =
		<div class="error">[ ' message ' ]</div>
	=]
	[= p Profile =
		<h1>[ ' group.group_name |e ' ]</h1>
		<small><a href="[ ' link ']">&laquo; [ ' _t: GroupsList ' ]</a></small>
		<h2>[ ' _t: GroupsProfile ' ]</h2>
		<table>
			<tr class="lined">
				<td class="userprofil">[ ' _t: GroupsDescription ' ]</td>
				<td>[ ' group.description |e ' ]</td>
			</tr>
			<tr class="lined">
				<td class="userprofil">[ ' _t: GroupsCreated ' ]</td>
				<td>[ ' group.created | time_formatted ' ]</td>
			</tr>
			<tr class="lined">
				[== // Have all usergroup pages as sub pages of the current Groups page. ==]
				<td class="userprofil">[ ' _t: GroupSpace ' ]</td>
				<td><a href="[ ' groupspace ' ]">[ ' db: groups_page |e ' ]/[ ' group.group_name |e ' ]</a></td>
			</tr>
		</table>

		[''' include // <--- output of Users sub-action ''']
	=]
	[= l GroupList =
		[== // usergroup filter form ==]
		<table class="formation">
			<tr>
				<td class="label">
					<form action="[ ' href ' ]" method="get" name="search_group">
						[ ' href | hide_page ' ]
						[ ' _t: GroupsSearch ' ]: ['' // </td><td> ??? '']
						<input type="search" name="group" maxchars="40" size="40" value="[ ' group |e attr ' ]" /> ['' '']
						<input type="submit" id="submit" value="[ ' _t: GroupsFilter ' ]" /> ['' '']
						<input type="submit" id="button" value="[ ' _t: GroupsOpenProfile ' ]" name="gotoprofile" />
					</form>
				</td>
			</tr>
		</table>
		<br />
		<table style="width:100%; white-space:nowrap; padding-right:20px;">
			['' pagination '']
			<tr>
				[= head _ =
					<th>[ ' a ' ]</th>
				=]
			</tr>
			[= none _ =
				<tr class="lined"><td colspan="5" style="padding:10px; text-align:center;"><small><em>[ ' _t: GroupsNoMatching ' ]</em></small></td></tr>
			=]
			[= line _ =
				<tr class="lined">
					<td style="padding-left:5px;"><a href="[ ' profile ' ]">[ ' group.group_name |e ' ]</a></td>
					<td style="text-align:center;">[ ' group.members |e ' ]</td>
					[= reg _ =
						<td style="text-align:center;">[ ' group.created | time_formatted ' ]</td>
					=]
				</tr>
			=]
			['' pagination '']
		</table>
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
