
.include _files.tpl
.include _comments.tpl
.include _rating.tpl

[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<article id="page-show" class="page" data-dbclick1="page">
		[= n _ =
			[ ' message ' ]
		=]

		[ ' restore ' ]
		[ ' reedit ' ]

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


[= reedit =]
<div class="revision-info">
	[ ' message ' ]
	<br><br>
	<form action="[ ' href ' ]" method="post" name="edit_revision">
		[ ' csrf: edit_revision ' ]
		<input type="hidden" name="previous" value="[ ' modified ' ]">
		<input type="hidden" name="id" value="[ ' pageid ' ]">
		<input type="submit" value="[ ' _t: ReEditOldRevision ' ]">
		<a href="[ ' href: ' ]" class="btn_link">
			<input type="button" name="cancel" id="button" value="[ ' _t: EditCancelButton ' ]">
		</a>
	</form>
</div>

[= restore =]
<div class="warning">
	[ ' _t: PageDeletedInfo ' ]
	<br><br>
	<form action="[ ' href: restore ' ]" method="post" name="restore_page">
		[ ' csrf: restore_page ' ]
		<input type="hidden" name="id" value="[ ' pageid ' ]">
		<input type="submit" value="[ ' _t: RestoreButton ' ]">
	</form>
</div>

