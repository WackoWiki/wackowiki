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
		<h3>[ ' _t: Attachments ' ] » [ ' header ' ]</h3>
		[ ' tabs ' ]
		<br><br>
		[ ' files ' ]
		<br>
		<a href="[ ' href: ' ]" class="btn-link">
			<input type="button" value="[ ' _t: CancelDifferencesButton ' ]">
		</a>
	=]