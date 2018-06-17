
.include _files.tpl
.include _comments.tpl
.include _rating.tpl

[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<article id="page-show" class="page" data-dbclick1="page">
		[ ' message ' ]
		[= h _ =
			<header>
				<h1>[ ' title ' ]</h1>
			</header>
		=]
		<section id="section-content">
			[ ' data | pre ' ]
			[ ' // edit via double click ' ]
			<script>var dbclick = "page";</script>
		</section>
		[= p _ =
			<nav class="category">[ ' category ' ]</nav>
		=]

		[''' fp FilePanel ''']
		[''' cp CommentPanel ''']
		[''' rp RatingPanel ''']

	</article>
