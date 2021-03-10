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
						<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: NewsXMLTip ' ]" alt="XML" class="btn-feed">
					</a>
				</span>
				<br><br>
			=]
			[= nopages _ =
				<br><br>[ ' _t: NewsNotAvailable ' ]
			=]
			[''' pagination ''']
			[= l =
				<article class="newsarticle">
					<h2 class="news-title">
						<a href="[ ' href ' ]">[ ' page.title ' ]</a>
					</h2>
					<div class="news-info">
						<span><time datetime="[ ' page.created ' ]">[ ' page.created | time_formatted ' ]</time> [ ' _t: By ' ] [ ' user ' ]</span>
					</div>
					<div class="newscontent">[ ' include | pre ' ]</div>
					<footer class="news-meta">
						[ ' category ' ] [ ' edit ' ] <a href="[ ' comments ' ]#header-comments" title="[ ' _t: NewsDiscuss ' ] [ ' page.title ' ]">[ ' page.comments ' ] [ ' _t: Comments ' ] »</a>
					</footer>
				</article>
			=]
			[''' pagination ''']
			[= f =
				<br><br>
				<a id="newtopic"></a><br>
				<form action="[ ' href ' ]" method="post" name="add_topic">
					[ ' csrf: add_topic ' ]
					<label for="news-title">[ ' _t: NewsName ' ]:</label>
					<input type="text" id="news-title" name="title" size="50" maxlength="250" value="">
					<button type="submit" id="submit">[ ' _t: CreateButton ' ]</button>
				</form>
			=]
		</section>
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>