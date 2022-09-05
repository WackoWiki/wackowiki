[ === PrinterHead === ]
<!DOCTYPE html>
<html lang="[ ' lang | e ' ]">
	<head>
		<meta charset="[ ' charset | e ' ]">
		<meta name="language" content="[ ' lang | e ' ]">
		<title>[ ' title | e ' ] (print) - [ ' db: site_name | e ' ]</title>
		<meta name="robots" content="noindex, nofollow">
		<link rel="stylesheet" href="[ ' db: theme_url ' ]css/print.css">
		<link rel="start" title="[ ' db: root_page ' ]" href="[ ' db: base_path ' ]">
		<link rel="icon" href="[ ' favicon ' ]" type="image/x-icon">
		[= terms _ =
			<link rel="license" href="[ ' url ' ]">
		=]
		<link rel="prev" href="[ ' href: ' ]">
	</head>
	<body id="print">
		<header>
			<div class="container">
				[== // Print wackoname and wackopath ==]
				<h1>[ ' db: site_name | e ' ]: [ ' title | e ' ]</h1>
				<a href="[ ' db: base_url ' ]">[ ' db: base_url | trim / | e ' ]</a>
				[= ver _ =
					&nbsp;&nbsp;&nbsp;&nbsp;[ ' _t: Version ' ]: [ ' version ' ] ([ ' mtime | time_formatted ' ])
				=]
				<br>
				[ ' path ' ]
			</div>
		</header>
<!-- End of header //-->
