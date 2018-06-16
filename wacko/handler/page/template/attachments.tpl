[ === main === ]
	[= a _ =
		<ul class="menu">
			[= notused _ =
				<li class="active">[ ' _t: File ' ]</li>
			=]
			[= upload _ =
				<li><a href="[ ' href: upload ' ]">[ ' _t: UploadFile ' ]</a></li>
			=]
		</ul>
		<h3>[ ' _t: Attachments ' ] &raquo; [ ' header ' ]</h3>
		[ ' tabs ' ]
		<br><br>
		[ ' files ' ]
		<br>
		<a href="[ ' href: ' ]" class="btn_link">
			<input type="button" value="[ ' _t: CancelDifferencesButton ' ]">
		</a>
	=]