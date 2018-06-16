[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<?xml version="1.0" encoding="[ ' charset ' ]"?>
	<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
		<channel>
			<title>[ ' db: site_name ' ] - [ ' tag ' ]</title>
			<link>[ ' db: base_url ' ][ ' supertag ' ]</link>
			<description>[ ' _t: PageRevisionsXML ' ] [ ' db: site_name ' ]/[ ' tag ' ]</description>
			<lastBuildDate>[ ' date ' ]</lastBuildDate>
			<image>
				<title>[ ' db: site_name ' ][ ' _t: CommentsTitleXML ' ]</title>
				<link>[ ' db: base_url ' ]</link>
				<url>[ ' db: base_url ' ][ ' logo ' ]</url>
				<width>[ ' db: logo_width ' ]</width>
				<height>[ ' db: logo_height ' ]</height>
			</image>
			<language>[ ' lang ' ]</language>
			[= p _ =
				<item>
					<title>[ ' user ' ]: [ ' note ' ]</title>
					<link>[ ' link ' ]</link>
					<guid isPermaLink="true">[ ' perma ' ]</guid>
					<description>[ ' diff | pre ' ]</description>
					<pubDate>[ ' date ' ]</pubDate>
				</item>
			=]
			[= denied _ =
				<item>
					<title>Error</title>
					<link>[ ' href: show ' ]</link>
					<description>[ ' _t: AccessDeniedXML ' ]</description>
				</item>
			=]
		</channel>
	</rss>