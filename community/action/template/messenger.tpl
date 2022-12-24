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
			<li><form action="[ ' href: ' ]" method="post" name="message_folder" style="display: inline;">
					[ ' csrf: message_folder ' ]
					<label for="msg_folder"><b>[ ' _t: Folder ' ]</b></label>
					<select name="msg_folder" id="msg_folder">
						<option value="">-->[ ' // _t: ChooseFolder ' ]</option>
					[= o _ =
						<option value="[ ' info ' ]"[ ' selected ' ]>[ ' info ' ]</option>
					=]
					</select>
					<button type="submit">[ ' _t: View ' ]</button>
				</form>
			</li>
		</ul>

		<br><br>
	=]
	[ ' forbidden ' ]
	[= a _ =
		[ ' message ' ]
	=]
	[= b _ =
		<form action="[ ' href: ' ]" method="post" name="folder_inbox">
			[ ' csrf: folder_inbox ' ]
		<table class="usertable">
			<tr>
				<td colspan="5" style="border: 0;">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="10"></th>
				<th width="600">[ ' _t: Subject ' ]</th>
				<th width="140">[ ' _t: Sender ' ]</th>
				<th width="100">[ ' _t: Date ' ]</th>
				<th width="80">[ ' // _t: Delete ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td><input type="checkbox" name="id[[ ' n ' ]]" value="[ ' msgid ' ]"></td>
					<td>[ ' status ' ][ ' urgent ' ] <a href="[ ' hrefview ' ]">[ ' subject ' ]</a><small>[ ' replied ' ]</small></td>
					<td>[ ' username ' ]</td>
					<td>[ ' time | time_formatted ' ]</td>
					<td><nav class="dt2- file-tools">[ ' i icon ' ]</nav></td>
				</tr>
			=]
			[= none _ =
				<tr>
					<td colspan="5"><br>[ ' _t: NoMessagesInbox ' ]<br><br></td>
				</tr>
			=]
			<tr>
				<td colspan="5" style="border: 0;">[ ' _t: MoveToFolder ' ] [ '' d selectfolder '' ]</td>
			</tr>
		</table>
		</form>
	=]
	[= c _ =
		<br><strong>[ ' // _t: ComposeMessage ' ]</strong>
		<form action="[ ' hrefform ' ]" method="post" name="message_store">
			[ ' csrf: message_store ' ]
			<table width="675" class="usertable" style="float: left;">
				<tr>
					<th><label for="subject">[ ' _t: Subject ' ]</label></th>
					<td><input type="text" id="subject" name="subject" maxlength="65" size="30" value="" required></td>
				</tr>
				<tr>
					<th><label for="to">[ ' _t: Recipient ' ]</label></th>
					<td>
						<select id="to" name="to" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="message">[ ' _t: Message ' ]</label></th>
					<td>
						[ '' textarea '' ]
					</td>
				</tr>
				<tr>
					<td><button type="submit">[ ' _t: Send ' ]</button></td>
					<td align="right">
						<label for="urgent">[ ' _t: Urgent ' ]</label>
						<input type="checkbox" id="urgent" name="urgent" value="1">
					</td>
				</tr>
			</table>
		</form>

		<aside style="width: 200px; padding-left: 25px; float: right;">
			<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a><br><br>
			<b>[ ' _t: Contacts ' ]:</b><br>
			<small>([ ' _t: ClickName ' ])</small><br><br>
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
					<th><label for="subject">[ ' _t: Subject ' ]</label></th>
					<td><input readonly type="text" id="subject" name="subject" maxlength="65" size="30" value="[ ' subject ' ]" required></td>
				</tr>
				<tr>
					<th><label for="to">[ ' _t: Recipient ' ]</label></th>
					<td>
						<select id="to" name="to" readonly required>
							<option value="[ ' userid ' ]">[ ' username ' ]</option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="message">[ ' _t: Message ' ]</label></th>
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
					<th><label for="subject">[ ' _t: Subject ' ]</label></th>
					<td><input type="text" id="subject" name="subject" maxlength="65" size="30" value="[ ' subject ' ]" required></td>
				</tr>
				<tr>
					<th><label for="to">[ ' _t: Recipient ' ]</label></th>
					<td>
						<select id="to" name="to" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="message">[ ' _t: Message ' ]</label></th>
					<td>
						[ '' textarea '' ]
					</td>
				</tr>
				<tr>
					<td><button type="submit">[ ' _t: Send ' ]</button></td>
					<td align="right">
						<label for="urgent">[ ' _t: Urgent ' ]</label>
						<input type="checkbox" id="urgent" name="urgent" value="1">
					</td>
				</tr>
			</table>
		</form>

		<aside style="width: 200px; padding-left: 25px; float: right;">
			<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a><br><br>
			<b>[ ' _t: Contacts ' ]:</b><br>
			<small>([ ' _t: ClickName ' ])</small><br><br>
			[= u _ =
				<a href="[ ' hrefforward ' ]">[ ' username ' ]</a><br>
			=]
		</aside>
	=]
	[= f _ =
		[= x _ =
			<br><span class="cite">Ein Feld wurde nicht ausgefüllt. Es müssen alle Felder ausgefüllt sein!</span><br><br>
			<a href="[ ' hrefcompose ' ]">[ ' _t: Back ' ]</a>
		=]
		[= e _ =
			<br><span class="cite">Die Nachricht konnte nicht versendet werden, da der eingetragende Empfänger kein registrierter Benutzer ist.</span><br><br>
			<a href="[ ' hrefcompose ' ]">[ ' _t: Back ' ]</a>
		=]
		[ ' sendto ' ]
	=]
	[= g _ =
		<table class="usertable" width="100%">
			<tr>
				<td colspan="4" style="border: 0;">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="400">[ ' _t: Subject ' ]</th>
				<th width="100">[ ' _t: Recipient ' ]</th>
				<th width="100">[ ' _t: Date ' ]</th>
				<th width="75">[ ' _t: Read ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td><a href="[ ' hrefview ' ]">[ ' subject ' ]</a></td>
					<td>[ ' username ' ]</td>
					<td>[ ' time | time_formatted ' ]</td>
					<td>[ ' status ' ]</td>
				</tr>
			=]
		</table>
		[ ' // <br><br>Löscht der Empfänger eine Nachricht, wird sie auch hier automatisch entfernt! ' ]
	=]
	[= h _ =
		<form action="[ ' href: ' ]" method="post" name="selected_folder">
			[ ' csrf: selected_folder ' ]
		<table class="usertable">
			<tr>
				<td colspan="5" style="border: 0;">
					[ '' pagination '' ]
				</td>
			</tr>
			<tr>
				<th width="10"></th>
				<th width="600">[ ' _t: Subject ' ]</th>
				<th width="150">[ ' _t: Sender ' ]</th>
				<th width="100">[ ' _t: Date ' ]</th>
				<th width="80">[ ' // _t: Delete ' ]</th>
			</tr>
			[= n _ =
				<tr>
					<td><input type="checkbox" name="id[[ ' n ' ]]" value="[ ' msgid ' ]"></td>
					<td>[ ' status ' ][ ' urgent ' ][ ' replied ' ] <a href="[ ' hrefview ' ]">[ ' subject ' ]</a></td>
					<td>[ ' username ' ]</td>
					<td>[ ' time | time_formatted ' ]</td>
					<td><nav class="dt2- file-tools">[ ' i icon ' ]</nav></td>
				</tr>
			=]
			<tr>
				<td colspan="5" style="border: 0;">[ ' _t: MoveToFolder ' ] [ '' d selectfolder '' ]</td>
			</tr>
		</table>
		</form>
		[ ' nomessages ' ]
	=]
	[= i _ =
		[ ' forbidden ' ]
		<table width="600" class="usertable">
			<tr>
				<th> [ ' _t: Subject ' ]: </th>
				<td>[ ' subject ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: From ' ]: </th>
				<td>[ ' username ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Message ' ]: </th>
				<td>[ ' message | nl2br ' ]</td>
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
		</table>
	=]
	[= j _ =
		<table width="600" class="usertable">
			<tr>
				<th>[ ' _t: Subject ' ]: </th>
				<td>[ ' subject ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Recipient ' ]: </th>
				<td> [ ' username ' ]<small> [<a href="[ ' hrefcontact ' ]">-></a>]</small></td>
			</tr>
			<tr>
				<th>[ ' _t: Message ' ]: </th>
				<td>[ ' message | nl2br ' ]</td>
			</tr>
			<tr>
				<th>[ ' _t: Date ' ]: </th>
				<td>[ ' time | time_formatted ' ]</td>
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
			<table width="70%" class="usertable" style="float: left;">
				<tr>
					<th><label for="field1_value">[ ' _t: ContactNames ' ]</label></th>
					<th><label for="field2_value">[ ' _t: Notes ' ]</label></th>
					<td> </td>
				</tr>
				<tr>
					<td>
						<select id="field1_value" name="field1_value" required>
							<option value="">[ ' _t: ChooseRecipient ' ]</option>
							[= o _ =
								<option value="[ ' userid ' ]"[ ' selected ' ]>[ ' username ' ]</option>
							=]
						</select>
					</td>
					<td>
						<input type="text" id="field2_value" name="field2_value" size="35" maxlength="65">
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
				<a href="[ ' hrefusers ' ]">[ ' _t: AddUserToList ' ]</a>
			</aside>
		</form>
	=]
	[= m _ =
		<br>
		<form action="[ ' hrefform ' ]" method="post" name="message_folders">
			[ ' csrf: message_folders ' ]
			<input type="hidden" name="insert" value="1">
			<table width="65%" class="usertable" style="float: left;">
				<tr>
					<th><label for="field1_value">[ ' _t: Folder ' ]</label></th>
					<th><label for="field2_value">[ ' _t: Notes ' ]</label></th>
					<td> </td>
				</tr>
				<tr>
					<td>
						<input type="text" id="field1_value" name="field1_value" size="25" maxlength="65">
					</td>
					<td>
						<input type="text" id="field2_value" name="field2_value" size="35" maxlength="65">
					</td>
					<td colspan="2">
						<button type="submit">[ ' _t: Add ' ]</button>
					</td>
				</tr>
				[= f _ =
					<tr>
						<td><a href="[ ' hreffolder ' ]">[ ' info ' ]</a></td>
						<td>[ ' notes ' ]</td>
						<td><a href="[ ' hrefdelete ' ]">[ ' _t: Delete ' ]</a></td>
					</tr>
				=]
			</table>

			<aside style="width: 200px; padding-left: 25px; float: right;">
				<span class="cite">[ ' _t: ClickFolder ' ]</span><br><br>
				<b>[ ' _t: CreateFolder ' ]</b><br><br>
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
				<td><a href="[ ' hrefcontact ' ]">[ ' username ' ]</a></td>
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
			<table class="usertable">
				<tr>
					<th width="400"> Betreff</th>
					<th width="100">Absender</th>
					<th width="250">Verschieben in Ordner</th>
					<th width="80">Löschen</th>
				</tr>
				<tr>
					<td><span class="cite">!*</span><a href=#test>Testnachricht</a> (03Jun06 2:57 pm)</td>
					<td><a href=#testuser>Testuser</a> [<a href=#pfeil>-></a>]</td>
					<td>
						<form method=post>
							<select name="move2folder"></select>
							<button type="submit">Verschieben</button>
						</form>
					</td>
					<td><a href=#loeschen>Löschen</a></td>
				</tr>
				<tr>
					<td>
						<span class="cite">!</span><a href=#test1>Testnachricht1</a><span style="color: grey;"><small><b> beantwortet am:</b> (01Jun06 1:02 pm)</small></span>
					</td>
					<td><a href=#testuser>Testuser16</a> [<a href=#pfeil>-></a>]</td>
					<td><right>
						<form method=post>
							<select name="move2folder"></select>
							<button type="submit">Verschieben</button>
						</form></right>
					</td>
					<td><a href=#loeschen>Löschen</a></td>
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
<textarea rows="16" cols="45" id="message" name="message" onKeyDown="textCounter(this.form.message,this.form.remLen,2500);" onKeyUp="textCounter(this.form.message,this.form.remLen,2500);">[ ' origmsg | pre ' ]</textarea><br>
<input readonly type="text" name="remLen" size="4" maxlength="4" value="2500"> [ ' _t: CharactersLeft ' ]

[= selectfolder =]
<form action="[ ' hrefform ' ]" method="post" name="move_folder">
	[ ' csrf: move_folder ' ]
	<select name="move2folder">
		<option value="">-->[ ' // _t: ChooseFolder ' ]</option>
	[= o _ =
		<option value="[ ' info ' ][ ' selected ' ]">[ ' info ' ]</option>
	=]
	</select>
	<button type="submit">[ ' _t: Move ' ]</button>
</form>

[= icon =]
<a href="[ ' info ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' title | e attr ' ]" alt="[ ' title | e attr ' ]" class="btn-[ ' class ' ]"></a>
