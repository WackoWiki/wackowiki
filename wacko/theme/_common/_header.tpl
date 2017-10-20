_common include file for themes

[ === HtmlHead === ]
<!DOCTYPE html>
<html lang="[ ' lang ' ]">
<head>
	<meta charset="[ ' charset ' ]">
	<title>[ ' title |e ' ][ ' tag ' ][ ' method | enclose " (" ")" ' ] - [ ' db: site_name |e ' ]</title>
	[= norobots _ =
		['' nonstatic // dummy to make pattern non-static '']
		<meta name="robots" content="noindex, nofollow">
	=]
	[= page _ =
		<meta name="keywords" content="[ ' keywords |e ' ]">
		<meta name="description" content="[ ' description |e ' ]">
	=]
	<meta name="language" content="[ ' lang ' ]">
	<link rel="stylesheet" href="[ ' db: theme_url ' ]css/default.css">
	[= x11 _ =
		<link rel="stylesheet" href="[ ' colors ' ]">
	=]
	<link media="print" rel="stylesheet" href="[ ' db: theme_url ' ]css/print.css">
	<link rel="icon" href="[ ' favicon ' ]" type="image/x-icon">
	<link rel="start" title="[ ' db: root_page ' ]" href="[ ' db: base_url ' ]">
	[= policy _ =
		<link rel="license" href="[ ' href ' ]">
	=]
	[= rss _ =
		<link rel="alternate" type="application/rss+xml" title="[ ' _t: ChangesFeed ' ]" href="[ ' url.0 ' ]changes[ ' url.1 ' ]">
		<link rel="alternate" type="application/rss+xml" title="[ ' _t: CommentsFeed ' ]" href="[ ' url.0 ' ]comments[ ' url.1 ' ]">
		[= news _ =
			<link rel="alternate" type="application/rss+xml" title="[ ' _t: NewsFeed ' ]" href="[ ' url.0 ' ]news[ ' url.1 ' ]">
		=]
		[= revisions _ =
			<link rel="alternate" type="application/rss+xml" title="[ ' _t: RevisionsFeed ' ][ ' tag ' ]" href="[ ' href ' ]">
		=]
	=]
		['' bb2 | '']
	<script src="[ ' db: base_url ' ]js/default.js"></script>
	[= edit _ =
		['' // autocomplete.js, protoedit & wikiedit.js contain classes for WikiEdit editor. We may include them only on method==edit pages. '']
		<script src="[ ' db: base_url ' ]js/protoedit.js"></script>
		<script src="[ ' db: base_url ' ]js/lang/wikiedit.[ ' lang |e ' ].js"></script>
		<script src="[ ' db: base_url ' ]js/wikiedit.js"></script>
		<script src="[ ' db: base_url ' ]js/autocomplete.js"></script>
	=]
	[= doubleclick _ =
		<script>
			var edit = "[ ' href | e js ' ]";
		</script>
	=]
	['' additions '']
</head>
