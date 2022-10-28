[ === CommentPanel === ]
	[= s _ =
		<section id="section-comments">
			<header id="header-comments">
				[ '' pagination '' ]
				<h1><a href="[ ' href ' ]" title="[ ' title | e attr ' ]">[ ' text ' ]</a></h1>
			</header>
			[= ol _ =
				<ol id="comments">
					[= l _ =
						<li id="[ ' tag ' ]" class="comment">
							<article class="comment-text">
								[= b _ =
									<nav class="comment-tools">
										[= remove _ =
											<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: DeleteCommentTip ' ]" alt="[ ' _t: DeleteText ' ]" class="btn-delete"></a>
										=]
										[= edit _ =
											<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: EditCommentTip ' ]" alt="[ ' _t: EditComment ' ]" class="btn-edit"></a>
										=]
										[= source _ =
											<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: SourceTip ' ]" alt="[ ' _t: SourceText ' ]" class="btn-source"></a>
										=]
									</nav>
								=]
								<header class="comment-title">
									<h2><a href="[ ' href ' ]">[ ' title | e ' ]</a></h2>
								</header>
								[ ' comment ' ]
								<footer>
									<ul class="comment-meta">
										<li>[ ' owner ' ]</li>
										<li><time datetime="[ ' created ' ]">[ ' created | time_formatted ' ]</time></li>
										[= m _ =
											<li><time datetime="[ ' modified ' ]"></time>[ ' modified | time_formatted ' ] [ ' _t: CommentEdited ' ]</li>
										=]
									</ul>
								</footer>
							</article>
						</li>
					=]
				</ol>
			=]
			[ '' pagination '' ]
			[= h _ =
				<div class="commentform" id="commenthint">
				[ ' hint ' ]
				</div>
			=]
			[= f _ =
				<div class="commentform" id="commentform">
					[= p _ =
						<div id="preview" class="preview">
							<p class="preview"><span>[ ' _t: Preview ' ]</span></p>
							<div class="comment-preview">
								<header class="comment-title">
									<h2>[ ' title | e ' ]</h2>
								</header>
								[ ' preview ' ]
							</div>
						</div>
						<br>
					=]
					<form action="[ ' href: addcomment ' ]" method="post" name="add_comment">
						[ ' csrf: add_comment ' ]
						<input type="hidden" name="parent_id" value="[ ' parent ' ]">

						['' // load WikiEdit '']
						<script src="[ ' db: base_path ' ]js/protoedit.js"></script>
						<script src="[ ' db: base_path ' ]js/lang/wikiedit.[ ' userlang ' ].js"></script>
						<script src="[ ' db: base_path ' ]js/wikiedit.js"></script>
						<script src="[ ' db: base_path ' ]js/autocomplete.js"></script>

						<noscript><div class="errorbox-js">[ ' _t: WikiEditInactiveJs ' ]</div></noscript>
						<label for="addcomment_title">[ ' _t: AddCommentTitle ' ]</label><br>
						<input type="text" id="addcomment_title" name="title" class="input-title" size="100" maxlength="250" value="[ ' title | e attr ' ]"><br>
						<br>
						<label for="addcomment">[ ' _t: AddComment ' ]</label><br>
						<textarea id="addcomment" name="body" class="textarea-comment" rows="6" cols="7" required>[ ' payload | pre ' ]</textarea>
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
						<br>
						[ ' captcha ' ]
						<script>
							wE = new WikiEdit();
								[= autocomplete _ =
									if (AutoComplete) { wEaC = new AutoComplete( wE, "[ ' href: show ' ]" ); }
								=]
							wE.init('addcomment', '[ ' wikiedit ' ]');
							[= user _ =
								var timeout = [ ' heartbeat ' ];
								var name = 'add_comment';
							=]
						</script>
						<button type="submit" class="btn-ok" name="save" accesskey="s">[ ' _t: AddCommentButton ' ]</button>
						<button type="submit" class="btn-ok" name="preview">[ ' _t: PreviewButton ' ]</button>
					</form>
				</div>
			=]
		</section>
	=]

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
