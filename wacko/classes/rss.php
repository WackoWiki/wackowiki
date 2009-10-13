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
		$name = "recentchanges";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->engine->GetCharset()."\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentChangesTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["root_url"]."</link>\n";
		$xml .= "<description>".$this->engine->GetTranslation("RecentChangesXML").$this->engine->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["root_url"]."</link>\n";
		$xml .= "<url>".$this->engine->config["root_url"]."files/wacko4.gif"."</url>\n";
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
					$access =$this->engine->HasAccess("read",$page["tag"],"guest@wacko");

				if ($access && ($count < 30))
				{
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["tag"]."</title>\n";
					$xml .= "<link>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["time"]))."</link>\n";
					$xml .= "<guid>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["time"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['time']))."</pubDate>\n";
					$xml .= "<description>".$page["time"]." ".$this->engine->GetTranslation("By")." ".$page["user"].($page["edit_note"] ? " [".$page["edit_note"]."]" : "")."</description>\n";
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
		$name = "recentcomment";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->engine->GetCharset()."\"?>\n";
		$xml .= "<?xml-stylesheet type=\"text/css\" href=\"".$this->engine->config["theme_url"]."css/wacko.css\" media=\"screen\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["root_url"]."</link>\n";
		$xml .= "<description>".$this->engine->GetTranslation("RecentCommentsXML").$this->engine->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->engine->config["wacko_name"].$this->engine->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->engine->config["root_url"]."</link>\n";
		$xml .= "<url>".$this->engine->config["root_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>en-us</language>\n";
		$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

		if ( $pages = $this->engine->LoadRecentlyComment() ) {
			foreach ($pages as $i => $page) {
				if ($this->engine->config["hide_locked"]) $access =$this->engine->HasAccess("read",$page["tag"],"guest@wacko");
				if ( $access && ($count < 30) ) {
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["tag"]." ".$this->engine->GetTranslation("To")." ".$this->engine->GetCommentOnTag($page["comment_on_id"])." ".$this->engine->GetTranslation("From")." ".$page["user"]."</title>\n";
					$xml .= "<link>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["time"]))."</link>\n";
					$xml .= "<guid>".$this->engine->href("show", $page["tag"], "time=".urlencode($page["time"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['time']))."</pubDate>\n";
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

	function SiteMap()
	{
		$xml = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
		$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		if ($pages = $this->engine->LoadAllPagesByTime())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->engine->config["hide_locked"] ? $this->engine->HasAccess("read",$page["tag"],"guest@wacko") : true)
				{
					$xml .= "<url>\n";
					$xml .= "<loc>".$this->engine->href("", $page["tag"])."</loc>\n";
					$xml .= "<lastmod>". substr($page["time"], 0, 10) ."</lastmod>\n";

					$daysSinceLastChanged = floor((time() - strtotime(substr($page["time"], 0, 10)))/86400);

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