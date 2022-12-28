[ === main === ]
[ ' style ' ]
<h2>[ ' mode ' ]</h2>
[ ' tabs ' ]
<br><br>
[= mustlogin _ =
	<em>[ ' _t: SchedMustLogin ' ]</em>
=]

	[= day _ =
		<div class="t-center">
			[ '' nav2 '' ]
			<div class="schdl-day media-center">
				<p>[ ' tasks ' ]</p>
			</div>
		</div>
	=]
	[= month _ =
		<table class="schdl-month">
			<tr>
				<td colspan="7">
					[ '' nav '' ]
				</td>
			</tr>
			<tr class="schdl-2">
			[= n _ =
				<td>[ ' weekday ' ]</td>
			=]
			</tr>
			[= d _ =
				[= first _ =
				<tr class="tr1">
					[= b _ =
					<td>[ ' n | void ' ]</td>
					=]
				=]
				[= tr2 _ =
					<tr class="tr2">
					[ ' nonstatic ' ]
				=]
					<td class="tr-entry">
						<table class="schdl-entry">
							<tr class="schdl-1">
								<td><a href="[ ' href ' ]">[ ' day ' ]</a>[ ' print ' ]</td>
							</tr>
							<tr>
								<td><small>[ ' schedule ' ]</small></td>
							</tr>
						</table>
					</td>
				[= etr _ =
					</tr>
					[ ' nonstatic ' ]
				=]
			=]
			</tr>
		</table>
		<br>
		<div class="t-center">
			<a name="entry-box"></a>
			[ '' nav2 '' ]
			<br><em><small>[ ' _t: SchedCommentsNote ' ]</small></em>
			[ '' form '' ]
		</div>
	=]
	[= default _ =
		<table class="schdl-default">
			<tr>
				<td>

					<table class="schdl-calendar">
						<tr class="schdl-3">
							<td colspan="7">
								[ '' nav '' ]
							</td>
						</tr>
						<tr class="schdl-2">
							[= n _ =
								<td class="schdl-d">[ ' weekday ' ]</td>
							=]
						</tr>
						[= d _ =
							[= first _ =
							<tr class="schdl-3">
								[= b _ =
									<td>[ ' n | void ' ]</td>
								=]
							=]
							[= tr2 _ =
							<tr class="schdl-3">
							[ ' nonstatic ' ]
							=]
								<td>
									<a href="[ ' href ' ]">[ ' day ' ]</a>
								</td>
							[= etr _ =
								</tr>
								[ ' nonstatic ' ]
							=]
						=]
						</tr>
					</table>

				</td>
				<td class="t-center">
				[= f _ =
					[ '' nav2 '' ]
					[ '' form '' ]
				=]
				</td>
			</tr>
		</table>
	=]

[ == form == ]
<form action="[ ' href ' ]" method="post" name="day_schedule">
	[ ' csrf: day_schedule ' ]
	<input type="hidden" name="save" value="true">
	<textarea cols="[ ' cols ' ]" rows="[ ' rows ' ]" name="schedule">[ ' schedule | pre ' ]</textarea><br>
	<button type="submit">[ ' _t: SubmitButton ' ]</button>
</form>

[ == nav == ]
<table class="schdl-nav">
	<tr>
		<td><a href="[ ' prevmonth ' ]">&lt;&lt;&lt;</a></td>
		<td>[ ' label ' ]</td>
		<td><a href="[ ' nextmonth ' ]">&gt;&gt;&gt;</a></td>
	</tr>
</table>

[ == nav2 == ]
<a href="[ ' prevday ' ]">&lt;&lt;</a>
<b>[ ' label ' ]</b>
<a href="[ ' nextday ' ]">&gt;&gt;</a>
								
[ == style == ]
<style>[ ' n css ' ]</style>

[ == css == ]
[ ' nonstatic ' ]
.schdl-1 { background: #e4dfda; }
.schdl-2 { background: #ddccbb; }
.schdl-3 { background: #ffffff; }
.schdl-d { width: 22px; }

.schdl-entry,
.schdl-default,
.schdl-nav {
	width: 100%; 
	border: 0 none;
	margin: 0;
	padding: 0;
}
.schdl-nav td:nth-child(1),
.schdl-nav td:nth-child(3) {
	width: 20px;
}
.schdl-nav td:nth-child(2) {
	text-align: center;
	font-weight: bold;
}
.schdl-entry td,
.schdl-nav td {
	border: 0 none !important;
}
.schdl-default tr {
	vertical-align: top;
}

.schdl-day {
	width: 600px;
	border: 2px solid #ddccbb;
	text-align: center;
}

.schdl-calendar {
	border-collapse: separate;
	border-spacing: 0px;
	padding: 1px;
	background: #ddccbb;
}

.schdl-calendar td {
	border: 1px solid #ddccbb;
	text-align: center;
}

.schdl-month {
	padding: 2px;
}
.schdl-month td {
	border: 1px solid #ddccbb;
}

.tr-entry {
	text-align: left;
	vertical-align: top;
	width: 150px;
	height: 70px;
}
