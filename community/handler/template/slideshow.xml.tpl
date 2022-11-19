[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<!DOCTYPE html>
	<html dir="[ ' dir ' ]" lang="[ ' lang ' ]">
	<head>
		<meta charset="[ ' charset ' ]">
		<title>[ ' title | e ' ][ ' tag ' ][ ' method | enclose " (" ")" ' ] - [ ' db: site_name | e ' ]</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow, noarchive">
		<meta name="language" content="[ ' lang ' ]">
		<link rel="stylesheet" href="[ ' db: theme_url ' ]css/default.css">
		[= unused _ =
			<link rel="stylesheet" href="[ ' db: theme_url ' ]css/wacko.css">
		=]
		<link rel="icon" href="[ ' favicon ' ]" type="image/x-icon">
		[= css _ =
		<style>
			.slide { font-size: 160%; margin: 1% 3%; background-color: #fff; padding: 30px; border: 1px inset; line-height: 1.5; min-height: 500px;}
			.slide ul, li, .slide p { font-size: 100%; }
			.slide li li { font-size: 90% }
			.sl_nav p { text-decoration: none; text-align: right; font-size: 80%; line-height: 0.4; }
			.sl_nav a { text-decoration: none; }
			.sl_nav a:hover { color: #CF8888 }
			div.sl_nav  { padding: 10px 20px 10px 0; }
			.page { background-color: #d1d1d1 }
			.sum { font-size: 8px; }
			br { display:none; }
		</style>
		=]
	</head>
	<body >
		[ '' nav navigation '' ]
		<div class="slide">
			[ ' body | pre ' ]<br><br>
		</div>
		[ '' nav navigation '' ]
	</body>
	</html>


[ == navigation == ]
<div class="sl_nav">
	<p>
		[= p _ =
			<a href="[ ' hrefprev ' ]">« [ ' _t: PrevAcr ' ]</a>
			<a href="[ ' hrefstart ' ]">[Start]</a> 
		=]
		[= n _ =
			<a href="[ ' hrefnext ' ]">[ ' _t: NextAcr ' ] »</a>
		=]
	</p>	
	<p>
		<a href="[ ' href ' ]">[ ' _t: EditText ' ] </a> ·
		<a href="[ ' href: ' ]">[ ' _t: CancelButton ' ]</a>
	</p>
</div>
