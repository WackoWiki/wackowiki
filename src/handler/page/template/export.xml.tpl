[ === main === ]
	[ ' dummy | default * // ADD_NO_DIV ' ]<?xml version="1.0" encoding="utf-8"?>
	<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
		<channel>
			<title>[ ' tag ' ]</title>
			<link>[ ' db: base_url ' ]</link>
			<description>[ ' _t: ExportClusterXML ' ] [ ' db: site_name ' ]/[ ' tag ' ]</description>
			<lastBuildDate>[ ' date ' ]</lastBuildDate>
			<language>[ ' lang ' ]</language>
			[= p _ =
				<item>
					<guid>[ ' tag ' ]</guid>
					<title>[ ' title | e ' ]</title>
					<link>[ ' db: base_url ' ][ ' ptag ' ]</link>
					<description><![CDATA[[ ' body | pre ' ]]]></description>
					<author>[ ' owner ' ]</author>
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
