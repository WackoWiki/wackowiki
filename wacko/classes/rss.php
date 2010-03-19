<?php

/*

########################################################
##              RSS Channels Constructor              ##
########################################################

*/

class RSS
{
	// VARIABLES
	var $engine;
	var $charset;

	// CONSTRUCTOR
	function RSS(&$engine)
	{
		$this->engine = & $engine;
		$this->engine->LoadResource($this->engine->config['language']);
		$this->charset = $this->engine->languages[$this->engine->config['language']]['charset'];
	}

	function WriteFile($name, $body)
	{
		$filename = 'xml/'.$name.'_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->engine->config['wacko_name'])).'.xml';

		$fp = fopen($filename, 'w');
		if ($fp)
		{
			fwrite($fp, $body);
			fclose($fp);
		}

		@chmod($filename, 0644);
	}

	function Changes()
	{
		$limit	= 30;
		$name = "changes";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->engine->GetCharset()."\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentChangesTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["base_url"]."</link>\n";
		$xml .= "<description>".$this->engine->GetTranslation("RecentChangesXML").$this->engine->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["base_url"]."</link>\n";
		$xml .= "<url>".$this->engine->config["base_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>en-us</language>\n";
		$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

		if ($pages = $this->engine->LoadRecentlyChanged())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->engine->config["hide_locked"])
					$access =$this->engine->HasAccess("read",$page["page_id"],GUEST);

				if ($access && ($count < 30))
				{
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["tag"]."</title>\n";
					$xml .= "<link>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["modified"]))."</link>\n";
					$xml .= "<guid>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["modified"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['modified']))."</pubDate>\n";
					$xml .= "<description>".$page["modified"]." ".$this->engine->GetTranslation("By")." ".$page["user"].($page["edit_note"] ? " [".$page["edit_note"]."]" : "")."</description>\n";
					$xml .= "</item>\n";
				}
			}
		}

		$xml .= "</channel>\n";
		$xml .= "</rss>\n";

		$this->WriteFile($name, $xml);
	}

	function Comments()
	{
		$limit	= 20;
		$name = "comments";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->engine->GetCharset()."\"?>\n";
		$xml .= "<?xml-stylesheet type=\"text/css\" href=\"".$this->engine->config["theme_url"]."css/wacko.css\" media=\"screen\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["base_url"]."</link>\n";
		$xml .= "<description>".$this->engine->GetTranslation("RecentCommentsXML").$this->engine->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["base_url"]."</link>\n";
		$xml .= "<url>".$this->engine->config["base_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>en-us</language>\n";
		$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

		if ( $pages = $this->engine->LoadRecentlyComment() ) {
			foreach ($pages as $i => $page) {
				if ($this->engine->config["hide_locked"]) $access =$this->engine->HasAccess("read",$page["page_id"],GUEST);
				if ( $access && ($count < 30) ) {
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["title"]." ".$this->engine->GetTranslation("To")." ".$this->engine->GetCommentOnTag($page["comment_on_id"])." ".$this->engine->GetTranslation("From")." ".$page["user"]."</title>\n";
					$xml .= "<link>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["modified"]))."</link>\n";
					$xml .= "<guid>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["modified"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['modified']))."</pubDate>\n";
					$xml .= "<dc:creator>".$page["user"]."</dc:creator>\n";
					$text = $this->engine->Format($page["body_r"], "post_wacko");
					$xml .= "<description><![CDATA[".str_replace("]]>", "]]&gt;", $text)."]]></description>\n";
					#$xml .= "<content:encoded><![CDATA[".str_replace("]]>", "]]&gt;", $text)."]]></content:encoded>\n";
					$xml .= "</item>\n";
				}
			}
		}

		$xml .= "</channel>\n";
		$xml .= "</rss>\n";

		$this->WriteFile($name, $xml);
	}

	function News()
	{
		$limit			= 10;
		$name			= 'news';
		$newscluster	= $this->engine->config['news_cluster'];
		$newslevels		= $this->engine->config['news_levels'];

		//  collect data
		$pages = $this->engine->LoadAll(
			"SELECT tag, title, created, body_r ".
			"FROM {$this->engine->config['table_prefix']}pages ".
			"WHERE comment_on_id = '0' ".
				"AND tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"ORDER BY tag");

		// build an array
		foreach ($pages as $page)
		{
			$news_pages[]	= array('tag' => $page['tag'], 'title' => $page['title'], 'modified' => $page['created'],
				'body_r' => $page['body_r'], 'date' => date('Y/m-d', strtotime($page['created'])));
		}

		// sorting function: sorts by dates
		// in tag names in reverse order
		$sort_dates = create_function(
			'$a, $b',	// func params
			'if ($a["date"] == $b["date"]) '.
				'return 0;'.
			'return ($a["date"] < $b["date"] ? 1 : -1);');
		// sort pages array
		usort($news_pages, $sort_dates);

		// build output
		$xml = '<?xml version="1.0" encoding="'.$this->charset.'"?>'."\n".
				"<?xml-stylesheet type=\"text/css\" href=\"".$this->engine->config["theme_url"]."css/wacko.css\" media=\"screen\"?>\n".
				// TODO: atom.css
				'<rss version="2.0">'."\n".
					'<channel>'."\n".
						'<title>'.$this->engine->config['wacko_name'].$this->engine->GetTranslation("RecentNewsTitleXML").'</title>'."\n".
						'<link>'.$this->engine->config['base_url'].str_replace('%2F', '/', rawurlencode($newscluster)).'</link>'."\n".
						'<description>'.$this->engine->GetTranslation("RecentNewsXML").$this->engine->config["wacko_name"].'</description>'."\n".
						'<language>'.$this->engine->config['language'].'</language>'."\n".
						'<pubDate>'.date('r').'</pubDate>'."\n".
						'<lastBuildDate>'.date('r').'</lastBuildDate>'."\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("NewsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["base_url"].str_replace('%2F', '/', rawurlencode($newscluster))."</link>\n";
		$xml .= "<url>".$this->engine->config["base_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";

		$i = 0;
		foreach ($news_pages as $page)
		{
			$i++;

				// this is a news article
				$title	= $page['title'];
				$cat	= substr_replace ($page['tag'], '', 0, strlen ($newscluster) + 1); // removes news cluster name
				$cat	= substr_replace ($cat, '', strpos ($cat, '/')); // removes news page name
				$link	= $this->engine->href('', $page['tag']);
				$pdate	= date("r", strtotime($page['modified']));
				$coms	= $link.'?show_comments=1#comments';
				$body	= $this->engine->LoadPage($page['tag']);
				$text	= $this->engine->Format($page['body_r'], 'post_wacko');


			$xml .= '<item>'."\n".
						'<title>'.$title.'</title>'."\n".
						'<link>'.$link.'</link>'."\n".
						'<guid isPermaLink="true">'.$link.'</guid>'."\n".
						'<description><![CDATA['.str_replace(']]>', ']]&gt;', $text).']]></description>'."\n".
						'<pubDate>'.$pdate.'</pubDate>'."\n".
						'<category>'.str_replace(' ', '', $cat).'</category>'."\n".
						( $coms != '' ? '<comments>'.$coms.'</comments>'."\n" : '' ).
					'</item>'."\n";

			if ($i >= $limit) break;
		}

		$xml .= 	'</channel>'."\n".
				'</rss>';

		$this->WriteFile($name, $xml);
	}

	function SiteMap()
	{
		$xml = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
		$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		if ($pages = $this->engine->LoadAllPagesByTime())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->engine->config["hide_locked"] ? $this->engine->HasAccess("read",$page["page_id"],GUEST) : true)
				{
					$xml .= "<url>\n";
					$xml .= "<loc>".$this->engine->href("", $page["tag"])."</loc>\n";
					$xml .= "<lastmod>". substr($page["modified"], 0, 10) ."</lastmod>\n";

					$daysSinceLastChanged = floor((time() - strtotime(substr($page["modified"], 0, 10)))/86400);

					if($daysSinceLastChanged < 30)
					{
						$xml .= "<changefreq>daily</changefreq>\n";
					}
					else if($daysSinceLastChanged < 60)
					{
						$xml .= "<changefreq>monthly</changefreq>\n";
					}
					else
					{
						$xml .= "<changefreq>yearly</changefreq>\n";
					}

					// The only thing I'm not sure about how to handle dynamically...
					$xml .= "<priority>0.8</priority>\n";
					$xml .= "</url>\n";
				}
			}
		}

		$xml .= "</urlset>\n";

		$filename = "sitemap.xml";

		$fp = @fopen($filename, "w");
		if ($fp)
		{
			fwrite($fp, $xml);
			fclose($fp);
		}
	}
}

?>