[ === main === ]
	[= nocluster _ =
		<br><br>[ ' _t: NewsNoClusterDefined ' ]
	=]
	[= n =
		<section class="news">
			<h1>[ ' title ' ]</h1>
			[= xml =
				<span class="desc-rss-feed">
					<a href="[ ' href ' ]">
						<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: NewsXMLTip ' ]" alt="XML" class="btn-feed btn-sm">
					</a>
				</span>
				<br>
			=]
			[= nopages _ =
				<br><br>[ ' _t: NewsNotAvailable ' ]
			=]
			<div class="no-print" style="width:100%;">
				[= access _ =
					<p>
						<strong><small class="cite">
							<a href="#newtopic">[ ' _t: BlogNewTopic ' ]</a>
						</small></strong>
					</p>
				=]
			[= f =
				<form id="newtopic" class="add-topic" action="[ ' href ' ]" method="post" name="add_topic">
					[ ' csrf: add_topic ' ]
					<table class="formation">
						<tr>
							<td class="label"><label for="news-title">[ ' _t: NewsName ' ]</label></td>
							<td>
								<input type="text" id="news-title" name="title" size="50" maxlength="250" value="">
								<button type="submit" id="submit">[ ' _t: CreateButton ' ]</button>
							</td>
						</tr>
					</table>
				</form>
			=]
				[ '' pagination '' ]
				<br style="clear:both; display: none;">
			</div>	

			[= l =
				<article class="newsarticle">
					[= b _ =
						<nav class="page-tools">
							<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: EditTip ' ]" alt="[ ' _t: EditText ' ]" class="btn-edit btn-sm"></a>
						</nav>
					=]
					<h2 class="news-title">
						<a href="[ ' href ' ]">[ ' page.title ' ]</a>
					</h2>
					<div class="news-info">
						<span><time datetime="[ ' page.created ' ]">[ ' page.created | time_formatted ' ]</time> [ ' _t: By ' ] [ ' user ' ]</span>
					</div>
					<div class="newscontent">[ ' include | pre ' ]</div>
					<footer class="news-meta">
						[ '' icon '' ] [ ' category ' ] [ ' edit ' ] <a href="[ ' comments ' ]#header-comments" title="[ ' _t: NewsDiscuss ' ] [ ' page.title ' ]">[ ' page.comments ' ] [ ' _t: Comments ' ] »</a>
					</footer>
				</article>
			=]
			[ '' pagination '' ]

		</section>
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[ === icon === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' _t: Categories ' ]" title="[ ' _t: Categories ' ]" class="btn-tag btn-sm">
