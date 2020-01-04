[ === CommentPanel === ]
	[= s _ =
		<section id="section-comments">
			<header id="header-comments">
				[''' pagination ''']
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
										[= s _ =
											<li>[ ' _t: UsersComments ' ]: [ ' comments ' ] - [ ' _t: UsersPages ' ]: [ ' pages ' ] - [ ' _t: UsersRevisions ' ]: [ ' revisions ' ]</li>
										=]
									</ul>
								</footer>
							</article>
						</li>
					=]
				</ol>
			=]
			[''' pagination ''']
			[= f _ =
				<div class="commentform" id="commentform">
					<form action="[ ' href: addcomment ' ]" method="post" name="add_comment">
						[ ' csrf: add_comment ' ]
						<input type="hidden" name="parent_id" value="[ ' parent ' ]">
						[= p _ =
							<div id="preview" class="preview">
								<p class="preview"><span>[ ' _t: EditPreview ' ]</span></p>
								<div class="comment-preview">
									<header class="comment-title">
										<h2>[ ' title | e ' ]</h2>
									</header>
									[ ' preview ' ]
								</div>
							</div>
							<br>
						=]
						['' // load WikiEdit '']
						<script src="[ ' db: base_url ' ]js/protoedit.js"></script>
						<script src="[ ' db: base_url ' ]js/lang/wikiedit.[ ' userlang ' ].js"></script>
						<script src="[ ' db: base_url ' ]js/wikiedit.js"></script>
						<script src="[ ' db: base_url ' ]js/autocomplete.js"></script>

						<noscript><div class="errorbox-js">[ ' _t: WikiEditInactiveJs ' ]</div></noscript>
						<label for="addcomment_title">[ ' _t: AddCommentTitle ' ]</label><br>
						<input type="text" id="addcomment_title" name="title" size="60" maxlength="250" value="[ ' title | e attr ' ]"><br>
						<br>
						<label for="addcomment">[ ' _t: AddComment ' ]</label><br>
						<textarea id="addcomment" name="body" rows="6" cols="7">[ ' payload | pre ' ]</textarea>
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
							wE.init('addcomment','WikiEdit','edname-w','[ ' wikiedit ' ]');
						</script>
						<input type="submit" name="save" value="[ ' _t: AddCommentButton ' ]" accesskey="s">
						<input type="submit" name="preview" value="[ ' _t: EditPreviewButton ' ]">
					</form>
				</div>
			=]
		</section>
	=]

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
