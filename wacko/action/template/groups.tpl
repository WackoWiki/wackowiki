
[ === main === ]
	[= error _ =
		<div class="msg error">[ ' message ' ]</div>
	=]
	[= p Profile =
		<h1>[ ' group.group_name | e ' ]</h1>
		<small><a href="[ ' link ' ]">« [ ' _t: GroupsList ' ]</a></small>
		<h2>[ ' _t: GroupsProfile ' ]</h2>
		<table class="user-profile lined">
			<tr>
				<th scope="row">[ ' _t: GroupsDescription ' ]</th>
				<td>[ ' group.description | e ' ]</td>
			</tr>
			<tr>
				<th scope="row">[ ' _t: GroupsCreated ' ]</th>
				<td>[ ' group.created | time_formatted ' ]</td>
			</tr>
			<tr>
				[== // Have all usergroup pages as sub pages of the current Groups page. ==]
				<th scope="row">[ ' _t: GroupSpace ' ]</th>
				<td><a href="[ ' groupspace ' ]">[ ' db: groups_page | e ' ]/[ ' group.group_name | e ' ]</a></td>
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
						<input type="search" name="group" maxchars="40" size="40" value="[ ' group | e attr ' ]"> ['' '']
						<input type="submit" id="submit" value="[ ' _t: SearchButton ' ]"> ['' '']
					</form>
				</td>
			</tr>
		</table>
		<br>
		<table class="user-table lined hl-line nowrap">
			['' pagination '']
			<tr>
				[= s _ =
					<th><a href="[ ' link ' ]">[ ' what ' ][''' arrow sortsArr ''']</a></th>
				=]
			</tr>
			[= none _ =
				<tr><td colspan="5" class="t-center"><small><em>[ ' _t: GroupsNoMatching ' ]</em></small></td></tr>
			=]
			[= g _ =
				<tr>
					<td><a href="[ ' profile ' ]">[ ' group.group_name | e ' ]</a></td>
					<td class="t-center">[ ' group.members | e ' ]</td>
					[= reg _ =
						<td class="t-center">[ ' group.created | time_formatted ' ]</td>
					=]
				</tr>
			=]
			['' pagination '']
		</table>
	=]


[== sortsArr ==]
 ['' a | replace desc ↑ asc ↓ '']

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
