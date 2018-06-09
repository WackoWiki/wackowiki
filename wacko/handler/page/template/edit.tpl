[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<div id="page-edit">
		[ ' message ' ]
		<form action="[ ' href: edit ' ]" method="post" name="edit_page" cf="true">
			[ ' csrf: edit_page ' ]
			[= new _ =
				<input type="hidden" name="page_lang" value="[ ' lang |e attr ' ]">
				<input type="hidden" name="tag" value="[ ' tag |e attr ' ]">
				<input type="hidden" name="add" value="1">
			=]
			[= p _ =
				[ '' buttons '' ]
				<section id="preview" class="preview">
					<p class="preview"><span>[ ' _t: EditPreviewSlim ' ] ([ ' chars ' ] [ ' _t: Chars ' ])</span></p>
					<h1>[ ' title ' ]</h1>
					[ ' preview ' ]
				</section>
				<br>
			=]
			[ '' buttons '' ]
			<br>
			<noscript><div class="errorbox_js">[ ' _t: WikiEditInactiveJs ' ]</div></noscript>
			[= e _ =
				<br>
				<label for="page_title">[ ' label ' ]</label><br>
				<input type="text" id="page_title" maxlength="250" value="[ ' title |e ' ]" size="60" name="title" >
				<br>
			=]
			[= r _ =
				<br>
				<h1>[ ' title ' ]</h1>
			=]
			
			<input type="hidden" name="previous" value="[ ' previous ' ]"><br>
			<textarea id="postText" name="body" rows="40" cols="60" class="TextArea">[ ' body | pre ' ]</textarea>
			<br>
		
			[= n _ =
				<label for="edit_note">[ ' _t: EditNote ' ]:</label><br>
				<input type="text" id="edit_note" maxlength="200" value="[ ' note |e ' ]" size="60" name="edit_note">
				&nbsp;&nbsp;&nbsp;
			=]
			[= minor _ =
				<input type="checkbox" id="minor_edit" value="1" name="minor_edit">
				<label for="minor_edit">[ ' _t: EditMinor ' ]</label>
				<br>
			=]
			[= reviewed _ =
				<input type="checkbox" id="reviewed" value="1" name="reviewed">
				<label for="reviewed">[ ' _t: Reviewed ' ]</label>
				<br>
			=]
			[= a _ =
				<input type="checkbox" name="noid_publication" id="noid_publication" value="[ ' pageid ' ]" [ ' checked ' ]>
				<label for="noid_publication">[ ' _t: PostAnonymously ' ]</label>
				<br>
			=]
			[= w _ =
				<input type="checkbox" name="watchpage" id="watchpage" value="1" [ ' checked ' ]>
				<label for="watchpage">[ ' _t: NotifyMe ' ]</label>
				<br>
			=]
			[= c _ =
				<br>[ ' _t: Categories ' ]: 
				[ ' categories ' ]
			=]
			
			[ ' captcha ' ]
				<script>
					wE = new WikiEdit();
						[= autocomplete _ =
							if (AutoComplete) { wEaC = new AutoComplete( wE, "[ ' href: edit ' ]" ); }
						=]
					wE.init('postText','WikiEdit','edname-w','[ ' wikiedit ' ]');
				</script>
				<br>
			[ '' buttons '' ]
		</form>
	</div>


[= buttons =]
<input type="submit" class="OkBtn_Top" name="save" value="[ ' _t: EditStoreButton ' ]">&nbsp;
<input type="submit" class="OkBtn_Top" name="preview" value="[ ' _t: EditPreviewButton ' ]">&nbsp;
<a href="[ ' href: ' ]" class="btn_link"><input type="button" class="CancelBtn_Top" value="[ ' _t: EditCancelButton ' ]"></a>

	