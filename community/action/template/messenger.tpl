[ === main === ]
	[= x _ =
		<script>
		<!-- Begin
		function textCounter(field, countfield, maxlimit)
		{
			if (field.value.length> maxlimit)		// if too long...trim it!
				field.value = field.value.substring(0, maxlimit);
					else							// otherwise, update 'characters left' counter
				countfield.value = maxlimit - field.value.length;
		}
		// End -->
		</script>

		[ ' menu ' ]
		[= h _ =
		<br><h3>[ ' header ' ]</h3>
		=]
		<ul class="menu">
			<li><b>[ ' _t: Folder ' ]</b><form action="[ ' href: ' ]" method="post" name="message_folder" style="display: inline;">
					[ ' csrf: message_folder ' ]
					<select name="msg_folder">
						<option value="">-->[ ' // _t: ChooseFolder ' ]</option>
					[= o _ =
						<option value="[ ' info ' ]"[ ' selected ' ]>[ ' info ' ]</option>
					=]
					</select>
					<button type="submit">[ ' _t: View ' ]</button>
				</form>
			</li>
		</ul>

		[ ' // folder ' ]<br><br>
	=]
	[ ' forbidden ' ]
	[= a _ =
		[ ' message ' ]
	=]
	[= b _ =
		<table class="usertable" cellpadding="2" cellspacing="3">
			<tr>
				<td colspan="5">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="400">[ ' _t: Subject ' ]</th>
				<th width="">[ ' _t: Date ' ]</th>
				<th width="100">[ ' _t: Sender ' ]</th>
				<th width="250">[ ' _t: MoveToFolder ' ]</th>
				<th width="80">[ ' _t: Delete ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td>[ ' status ' ][ ' urgent ' ] <a href="[ ' hrefview ' ]">[ ' subject ' ]</a><small>[ ' replied ' ]</small></td>
					<td>[ ' time | time_formatted ' ]</td>
					<td>[ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
					<td width="155">
						<form action="[ ' hrefform ' ]" method="post" name="move_folder">
							[ ' csrf: move_folder ' ]
							<select name="move2folder">
								<option value="">-->[ ' // _t: ChooseFolder ' ]</option>
							[= o _ =
								<option value="[ ' info ' ]">[ ' info ' ]</option>
							=]
							</select>
							<button type="submit">[ ' _t: Move ' ]</button>
						</form>
					</td>
					<td>
						<a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a><br>
					</td>
				</tr>
			=]
			[= none _ =
				<tr>
					<td colspan="5"><br>[ ' _t: NoMessagesInbox ' ]<br><br></td>
				</tr>
			=]
		</table>
	=]
	[= c _ =
		<br><strong>[ ' // _t: ComposeMessage ' ]</strong>
		<form action="[ ' hrefform ' ]" method="post" name="message_store">
			[ ' csrf: message_store ' ]
			<table width="675" class="usertable" style="float: left;">
				<tr>
					<th>[ ' _t: Subject ' ]:</th>
					<td><input type="text" name="subject" maxlength="65" size="30" value="" required></td>
				</tr>
				<tr>
					<th>[ ' _t: Recipient ' ]:</th>
					<td>
						<select name="to" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<th>[ ' _t: Message ' ]:</th>
					<td>
						[ '' textarea '' ]
					</td>
				</tr>
				<tr>
					<td><button type="submit">[ ' _t: Send ' ]</button></td>
					<td align="right">[ ' _t: Urgent ' ] <input type="checkbox" name="urgent" value="1"></td>
				</tr>
			</table>
		</form>

		<aside style="width: 200px; padding-left: 25px; float: right;">
			<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a><br><br>
			<b>[ ' _t: Contacts ' ]:</b><br><small>([ ' _t: ClickName ' ])</small><br><br>
			[= u _ =
				<a href="[ ' hrefcompose ' ]">[ ' username ' ]</a><br>
			=]
		</aside>
	=]
	[= d _ =
		<br><h3>[ ' _t: ReplyToMessage ' ]</h3>
		<form action="[ ' hrefform ' ]" method="post" name="message_reply">
			[ ' csrf: message_reply ' ]
			<table width="400" class="usertable">
				<tr>
					<th>[ ' _t: Subject ' ]:</th>
					<td><input readonly type="text" name="subject" maxlength="65" size="30" value="[ ' subject ' ]" required></td>
				</tr>
				<tr>
					<th>[ ' _t: Recipient ' ]:</th>
					<td>
						<select name="to" readonly required>
							<option value="[ ' userid ' ]">[ ' username ' ]</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>[ ' _t: Message ' ]:</th>
					<td>
						[ '' textarea '' ]
					</td>
				</tr>
				<tr>
					<td><button type="submit">[ ' _t: Send ' ]</button></td>
					<td align="right">[ ' _t: Urgent ' ] <input type="checkbox" name="urgent" value="1"></td>
				</tr>
			</table>
		</form>
	=]
	[= e _ =
		<br><h3>[ ' _t: ForwardMessage ' ]</h3>
		<form action="[ ' hrefform ' ]" method="post" name="message_forward">
			[ ' csrf: message_forward ' ]
			<table width="675" class="usertable" style="float: left;">
				<tr>
					<th>[ ' _t: Subject ' ]:</th>
					<td><input type="text" name="subject" maxlength="65" size="30" value="[ ' subject ' ]" required></td>
				</tr>
				<tr>
					<th>[ ' _t: Recipient ' ]:</th>
					<td>
						<select name="to" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<td>[ ' _t: Message ' ]:</td>
					<td>
						[ '' textarea '' ]
					</td>
				</tr>
				<tr>
					<td><button type="submit">[ ' _t: Send ' ]</button></td>
					<td align="right">[ ' _t: Urgent ' ] <input type="checkbox" name="urgent" value="1"></td>
				</tr>
			</table>
		</form>

		<aside style="width: 200px; padding-left: 25px; float: right;">
			<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a><br><br>
			<b>[ ' _t: Contacts ' ]:</b><br><small>([ ' _t: ClickName ' ])</small><br><br>
			[= u _ =
				<a href="[ ' hrefforward ' ]">[ ' username ' ]</a><br>
			=]
		</aside>
	=]
	[= f _ =
		[= x _ =
			<br><center><span class="cite">Ein Feld wurde nicht ausgefüllt. Es müssen alle Felder ausgefüllt sein!</span></center><br><br>
			<a href="[ ' hrefcompose ' ]">[ ' _t: Back ' ]</a>
		=]
		[= e _ =
			<br><span class="cite">Die Nachricht konnte nicht versendet werden, da der eingetragende Empfänger kein registrierter Benutzer ist.</span><br><br>
			<a href="[ ' hrefcompose ' ]">[ ' _t: Back ' ]</a>
		=]
		[ ' sendto ' ]
	=]
	[= g _ =
		<table class="usertable" cellpadding="2" cellspacing="3" width="100%">
			<tr>
				<td colspan="4">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="400">[ ' _t: Subject ' ]</th>
				<th width="">[ ' _t: Date ' ]</th>
				<th width="100">[ ' _t: Recipient ' ]</th>
				<th width="75">[ ' _t: Read ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td><a href="[ ' hrefview2 ' ]">[ ' subject ' ]</a></td>
					<td>[ ' time | time_formatted ' ]</td>
					<td>[ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
					<td width="50">[ ' status ' ]<br></td>
				</tr>
			=]
		</table>
		[ ' // <br><br>Löscht der Empfänger eine Nachricht, wird sie auch hier automatisch entfernt! ' ]
	=]
	[= h _ =
		<table class="usertable" cellpadding="2" cellspacing="3">
			<tr>
				<td colspan="5">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="400"> [ ' _t: Subject ' ]:</th>
				<th width="">[ ' _t: Date ' ]</th>
				<th width="100"> [ ' _t: Sender ' ]</th>
				<th width="250"> [ ' _t: MoveToFolder ' ]</th>
				<th width="80"> [ ' _t: Delete ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td>
						[ ' status ' ][ ' urgent ' ][ ' replied ' ] <a href="[ ' hrefview ' ]">[ ' subject ' ]</a>
					</td>
					<td>[ ' time | time_formatted ' ]</td>
					<td width="125">[ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
					<td>
						<form action="[ ' hrefform ' ]" method="post" name="move_folder">
							[ ' csrf: move_folder ' ]
							<select name="move2folder">
								<option value="">-->[ ' // _t: ChooseFolder ' ]</option>
							[= o _ =
								<option value="[ ' info ' ]">[ ' info ' ]</option>
							=]
							</select>
							<button type="submit">[ ' _t: Move ' ]</button>
						</form>
					</td>
					<td>
						<a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a><br>
					</td>
				</tr>
			=]
		</table>
		[ ' nomessages ' ]
	=]
	[= i _ =
		[ ' forbidden ' ]
		<table border="1" bordercolor="#666699" width="600" class="usertable">
			<tr>
				<th> [ ' _t: Subject ' ]: </th>
				<td>[ ' subject ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: From ' ]: </th>
				<td>[ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
			</tr>
			<tr>
				<th>[ ' _t: Message ' ]: </th>
				<td>[ ' message ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Date ' ]: </th>
				<td>[ ' replied ' ] [ ' time | time_formatted ' ]</td>
			</tr>
			<tr>
				<td colspan="2">
					<a href="[ ' hrefreply ' ]"> [ ' _t: Reply ' ]</a>
					/ <a href="[ ' hrefforward ' ]">[ ' _t: Forward ' ]</a>
					/ <a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a>
				</td>
			</tr>
		</table><br>
	=]
	[= j _ =
		<table border="1" width="600" class="usertable">
			<tr>
				<th>[ ' _t: Subject ' ]: </th><td>[ ' subject ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Recipient ' ]: </th><td> [ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
			</tr>
			<tr>
				<th>[ ' _t: Message ' ]: </th><td>[ ' message ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Date ' ]: </th><td>[ ' time | time_formatted ' ]</td>
			</tr>
		</table>
	=]
	[= k _ =
		<form action="[ ' hrefdelete ' ]" method="post" name="delete_message">
			[ ' csrf: delete_message ' ]
			[ ' _t: DeleteItem ' ]
			<button type="submit">[ ' _t: Delete ' ]</button>
		</form>
		[ ' message ' ]
	=]
	[= l _ =
		<br>
		<form action="[ ' hrefform ' ]" method="post" name="edit_contacts">
			[ ' csrf: edit_contacts ' ]
			<input type="hidden" name="insert" value="1">
			<table border="1" cellspacing="0" width="70%" class="usertable" style="float: left;">
				<tr>
					<th>[ ' _t: ContactNames ' ]</th>
					<th>[ ' _t: Notes ' ]</th>
					<td> </td>
				</tr>
				<tr>
					<td>
						<select name="field1_value" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
					<td>
						<input type="text" size="35" maxlength="65" name="field2_value">
					</td>
					<td colspan="2">
						<button type="submit">[ ' _t: Add ' ]</button>
					</td>
				</tr>
				[= c _ =
					<tr>
						<td><a href="[ ' hrefcompose ' ]">[ ' username ' ]</a></td>
						<td>[ ' notes ' ]</td>
						<td><a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a></td>
					</tr>
				=]
			</table>

			<aside style="width: 150px; padding-left: 25px; float: right;">
				<span class="cite">[ ' _t: ClickContact ' ]</span><br><br>
				<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a><br><br>
			</aside>
		</form>
	=]
	[= m _ =
		<br>
		<form action="[ ' hrefform ' ]" method="post" name="message_folders">
			[ ' csrf: message_folders ' ]
			<input type="hidden" name="insert" value="1">
			<table border="1" cellspacing='0' width="65%" class="usertable" style="float: left;">
				<tr>
					<th>[ ' _t: Folder ' ]</th>
					<th>[ ' _t: Notes ' ]</th>
					<td> </td>
				</tr>
				<tr>
					<td>
						<input type="text" size="25" maxlength="65" name="field1_value"></td>
					<td>
						<input type="text" size="35" maxlength="65" name="field2_value">
					</td>
					<td colspan="2">
						<button type="submit">[ ' _t: Add ' ]</button>
					</td>
				</tr>
				[= f _ =
					<tr>
						<td><a href="[ ' hreffolder ' ]">[ ' info ' ]</a></td>
						<td>[ ' notes ' ]</td>
						<td>
							<a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a>
						</td>
					</tr>
				=]
			</table>

			<aside style="width: 200px; padding-left: 25px; float: right;">
				<span class="cite">[ ' _t: ClickFolder ' ]</span><br><br><b>[ ' _t: CreateFolder ' ]</b><br><br>
				[ ' _t: CreateFolderHelp ' ]
			</aside>
		</form>
	=]
	[= n _ =
		<br>
		['' pagination '']
		<table width="650" class="usertable" style="float: left;">
			<tr>
				<th>[ ' _t: ContactNames ' ]</th>
			</tr>
			[= u _ =
			<tr>
				<td>
					
						<a href="[ ' hrefcontact ' ]">[ ' username ' ]</a><br>
					
				</td>
			</tr>
			=]
		</table>
		['' pagination '']

		<aside class="cite" style="width: 200px; padding-left: 25px; float: right;">
			[ ' _t: ClickContact2 ' ]
		</aside>
	=]

	[ ' z help ' ]


[ == help == ]
[ ' nonstatic ' ]
<table width="100%">
	<tr>
		<td>
			<a name= anfang></a>
			<h3>Hilfe für das WackoWiki-Message-System</h3>
			<br><br>Auf dieser Seite gibt es einige Hilfestellungen zu den Funktionen des WackoWiki-Message-Systems. Die Erklärungen sind kurz gehalten, da die meisten Funktionen selbsterklärend sind.<br>Nachfolgend findest Du ein Inhaltsverzeichnis zu den hier erläuterten Funktionen:
			<br><br><br>
			<a href=#post>Posteingang</a><br>
			<a href=#verf>Verfassen</a><br>
			<a href=#vers>Postausgang</a><br>
			<a href=#verw>Verwalten</a><br>
				- <a href=#ordn>Ordner</a><br>
				- <a href=#kont>Kontaktliste</a><br>
			<a href=#benu>Benutzer</a><br><br>
			<a name= post><h3>Posteingang</h3></a><br><br>
			Im Posteing werden alle eingetroffenen Nachrichten angezeigt, sowie einige zusätzliche Info`s zu den einzelnen Nachrichten.<br><br>
			In der folgenden Darstellung siehst Du ein Beispiel, wie der Posteingangsordner aussehen kann:<br><br><br>
			<table>
				<tr bgcolor="#93B2DD">
					<td width="400">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr><td width="100"><b> Betreff</b></td></tr>
						</table>
					</td>
					<td width="100"><b> Absender</b></td>
					<td width="250"><b> Verschieben in Ordner</b></td>
					<td width="80"><b> Löschen</b></td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="400">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr><td width="100"><span class="cite">!*</span><a href=#test>Testnachricht</a> (03Jun06 2:57 pm)</td></tr>
						</table>
					</td>
					<td width="100"><a href=#testuser>Testuser</a> [<a href=#pfeil>-></a>]</td>
					<td width="250">
						<form method=post>
							<select name="move2folder"></select>
							<button type="submit">Verschieben</button>
						</form>
					</td>
					<td width="80"><a href=#loeschen>Löschen</a></td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="400">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td width="100">
									<span class="cite">!</span><a href=#test1>Testnachricht1</a><font color= #808080><small><b> beantwortet am:</b> (01Jun06 1:02 pm)</small></font>
								</td>
							</tr>
						</table>
					</td>
					<td width="100"><a href=#testuser>Testuser16</a> [<a href=#pfeil>-></a>]</td>
					<td width="250"><right>
						<form method=post>
							<select name="move2folder"></select>
							<button type="submit">Verschieben</button>
						</form></right>
					</td>
					<td width="80"><a href=#loeschen>Löschen</a></td>
				</tr>
			</table><br>
			<a href=#anfang>Seitenanfang</a><br><br>
			<h4>Was bedeuten die Zeichen vor und hinter den Nachrichten?</h4>
			<br><br> - Das <b><span class="cite">!</span></b> vor einer Nachricht erscheint, wenn der Absender die Nachricht als <b>dringend</b> markiert hat.
			<br><br> - Das <b><span class="cite">*</span></b> vor der Nachricht zeigt an, das die Nachricht noch nicht gelesen wurde. Sobald die Nachricht gelesen wurde verschwindet<br>
			das <b><span class="cite">*</span></b> und der Absender erhält die Information, dass die Nachricht gelesen wurde.<br><br>
			- Die Daten hinter der Nachricht geben an, wann die Nachricht erhalten bzw. gesendet wurde. Ausserdem wird in einer anderen<br>
			Farbe angezeigt ob und wann eine Nachricht beantwortet wurde.<br><br>
			<h4>Wie kann ich eine Nachricht öffnen?</h4><br><br>
			Um eine Nachricht zu lesen muss man auf den <b>Betreff</b> der Nachricht klicken, die geöffnet werden soll. Anschliessend wird die Nachricht<br>
			in einem neuen Fenster dargestellt.<br><br>
			<h4>Nachrichten in andere Ordner verschieben!</h4><br><br>
		</td>
	</tr>
</table>

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= textarea =]
<textarea rows="16" cols="45" name="message" onKeyDown="textCounter(this.form.message,this.form.remLen,2500);" onKeyUp="textCounter(this.form.message,this.form.remLen,2500);">[ ' origmsg | pre ' ]</textarea><br>
<input readonly type="text" name="remLen" size="4" maxlength="4" value="2500"> [ ' _t: CharactersLeft ' ]

