[ === main === ]

<h2>[ ' mode ' ]</h2>
[ ' tabs ' ]
<br><br>
[= mustlogin _ =
	<em>[ ' _t: SchedMustLogin ' ]</em>
=]
<div class="t-center">
	<table border=0 width=100%>
	<tr>
		<td>
			<div class="t-center">

		[= day _ =
			<div class="t-center">
				<a href="[ ' prevday ' ]"><<</a>
				<b>[ ' label ' ]</b>
				<a href="[ ' nextday ' ]">>></a>

				<table class='box' width='600' border='1' cellspacing='1' cellpadding='7' bgcolor='#ddccbb'>
					<tr>
						<td>
							<p></p>
							<table class='box' width='100%' border='0' cellspacing='0' cellpadding='2' bgcolor='#ffffff'>
								<tr align='left'>
									<td>
										<p>[ ' tasks ' ]</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			</div>
		=]
		[= month _ =
			<table>
				<tr>
					<td valign="top">
						<table cellpadding="2" cellspacing="0" border="1">
							<tr>
								<td colspan="7">
									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
											<td width="20"><a href="[ ' prevmonth ' ]"><<<</a></td>
											<td class="t-center"><strong>[ ' label ' ]</strong></td>
											<td width="20"><a href="[ ' nextmonth ' ]">>>></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr bgcolor="#ddccbb">
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
									<td valign=top align=left width=150 height=70>
										<table width="100%">
											<tr bgcolor="#E4DFDA">
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
				</td>
			</tr>
		</table>
			</div>
		</td>
	</tr>
	<tr>
		<td widht=500>
			<p></p>

			<div class="t-center">
				<a name="entry-box"></a>
				<a href="[ ' prevday ' ]"><<</a>
				<b>[ ' dlabel ' ]</b>
				<a href="[ ' nextday ' ]">>></a>
				<br><em><small>[ ' _t: SchedCommentsNote ' ]</small></em>
				[ '' form '' ]
			</div>
		=]
		[= default _ =
			<table bgcolor="#ddccbb">
				<tr>
					<td valign="top">

						<table cellpadding="2" cellspacing="0" border="1">
							<tr bgcolor="#ffffff">
								<td colspan="7">
									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr bgcolor="#ffffff">
											<td width="20"><a href="[ ' prevmonth ' ]"><<<</a></td>
											<td class="t-center">[ ' month ' ]</td>
											<td width="20"><a href="[ ' nextmonth ' ]">>>></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr bgcolor="#ddccbb">
							[= n _ =
								<td width="22">[ ' weekday ' ]</td>
							=]
							</tr>
						[= d _ =
							[= first _ =
							<tr bgcolor="#ffffff">
								[= b _ =
								<td>[ ' n | void ' ]</td>
								=]
							=]
							[= tr2 _ =
							<tr bgcolor="#ffffff">
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
				</tr>
			</table>
			</div>
		</td>
		<td width=500>
		[= f _ =
			<br>
			<a href="[ ' prevday ' ]"><<</a>
			<b>[ ' label ' ]</b>
			<a href="[ ' nextday ' ]">>></a>
			[ '' form '' ]
		=]
	=]

		</td>
	</tr>
</table>
</div>

[= form =]
<form action="[ ' href ' ]" method="post" name="day_schedule">
	[ ' csrf: day_schedule ' ]
	<input type="hidden" name="save" value="true">
	<textarea cols="[ ' cols ' ]" rows="[ ' rows ' ]" name="schedule">[ ' schedule ' ]</textarea><br>
	<button type="submit">[ ' _t: SubmitButton ' ]</button>
</form>
