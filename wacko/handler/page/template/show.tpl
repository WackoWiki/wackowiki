
.include _files.tpl
.include _comments.tpl
.include _rating.tpl

[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<article id="page-show">
		[= n _ =
			[ ' message ' ]
		=]
		[= nav _ =
			[ ' a revmeta ' ]
		=]
		[ ' restore ' ]
		[ ' reedit ' ]

		[= h _ =
			<header>
				<h1>[ ' title | e ' ]</h1>
			</header>
		=]
		<section id="section-content" class="page" data-dbclick="page">
			[ ' data | pre ' ]
		</section>
		[= p _ =
			<nav class="category">[ ' category ' ]</nav>
		=]

		[''' fp FilePanel ''']
		[''' cp CommentPanel ''']
		[''' rp RatingPanel ''']

	</article>

[= reedit =]
<div class="msg revision-info">
	[ ' message ' ]
	<br><br>
	<form action="[ ' href ' ]" method="post" name="edit_revision">
		[ ' csrf: edit_revision ' ]
		<input type="hidden" name="previous" value="[ ' modified ' ]">
		<input type="hidden" name="id" value="[ ' pageid ' ]">
		<button type="submit">[ ' _t: ReEditOldRevision ' ]</button>
		<a href="[ ' href: ' ]" class="btn-link">
			<button type="button" name="cancel" id="button">[ ' _t: CancelButton ' ]</button>
		</a>
	</form>
</div>

[= restore =]
<div class="msg warning">
	[ ' _t: PageDeletedInfo ' ]
	<br><br>
	<form action="[ ' href: restore ' ]" method="post" name="restore_page">
		[ ' csrf: restore_page ' ]
		<input type="hidden" name="id" value="[ ' pageid ' ]">
		<button type="submit">[ ' _t: RestoreButton ' ]</button>
	</form>
</div>

[= revmeta =]
<!--<div class="msg notice">--><div class="msg notice">
[= prev _ =
	(<a href="[ ' diff ' ]">[ ' _t: Diff ' ]</a>) 
	<a href="[ ' href ' ]">← [ ' _t: PreviousVersion ' ]</a> 
	| 
=]
[= latest _ =
	<a href="[ ' href ' ]">[ ' _t: LatestVersion ' ]</a> 
	(<a href="[ ' diff ' ]">[ ' _t: Diff ' ]</a>) 
=]
[= next _ =
	| 
	<a href="[ ' href ' ]">[ ' _t: NextVersion ' ] →</a> 
	(<a href="[ ' diff ' ]">[ ' _t: Diff ' ]</a>)
=]
<br>
<div class="diffdown">
	<span>[ ' version ' ]</span>
	<a href="[ ' href ' ]">
		[ ' modified | time_formatted ' ]
		<span class="dropdown-arrow">▼</span>
	</a>
	<div class="diffdown-content">
		[= r _ =
			<a href="[ ' href ' ]" [ ' class ' ]>
				<span><strong>[ ' version ' ]</strong></span>
				[ ' modified | time_formatted ' ]
				[ ' username ' ]
				[ ' editnote | enclose " [" "]" ' ]
			</a>
		=]
	</div><br>
	[ ' username ' ]<br>
	[= m _ =
		<abbr class="minoredit" title="[ ' _t: EditMinor ' ]">[ ' minor ' ]</abbr>
	=]
	[= n _ =
		<span class="editnote">[ ' note | enclose " [" "]" ' ]</span>
	=]
</div>
<!--</div>--></div>
