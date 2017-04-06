<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

/*

########################################################
##              Feed Channels Constructor             ##
########################################################

*/

class Feed
{
	// VARIABLES
	var $engine;
	var $lang;
	var $charset;

	// CONSTRUCTOR
	function __construct(&$engine)
	{
		$this->engine	= & $engine;
		$this->lang		= $this->engine->db->language;
		$this->engine->load_translation($this->lang);
		$this->charset	= $this->engine->get_charset($this->lang);
	}

	function write_file($name, $body)
	{
		$file_name = Ut::join_path(XML_DIR, $name . '_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->engine->db->site_name)) . '.xml');
		@file_put_contents($file_name, $body);
		@chmod($file_name, 0644);
	}

	function changes()
	{
		$limit	= 30;
		$name	= 'changes';
		$count	= '';

		$xml = "<?xml version=\"1.0\" encoding=\"" . $this->charset."\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>" . $this->engine->db->site_name . $this->engine->_t('RecentChangesTitleXML') . "</title>\n";
		$xml .= "<link>" . $this->engine->db->base_url . "</link>\n";
		$xml .= "<description>" . $this->engine->_t('RecentChangesXML') . $this->engine->db->site_name." </description>\n";
		$xml .= '<copyright>' . $this->engine->href('', $this->engine->db->policy_page) . '</copyright>' . "\n";
		$xml .= "<lastBuildDate>" . date('r') . "</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>" . $this->engine->db->site_name . $this->engine->_t('RecentCommentsTitleXML') . "</title>\n";
		$xml .= "<link>" . $this->engine->db->base_url . "</link>\n";
		$xml .= "<url>" . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo)  . "</url>\n";
		$xml .= "<width>" . $this->engine->db->logo_width ."</width>\n";
		$xml .= "<height>" . $this->engine->db->logo_height . "</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>" . $this->lang . "</language>\n";
		#$xml .= "<docs>http://www.rssboard.org/rss-specification</docs>\n";
		#$xml .= "<generator>WackoWiki " . WACKO_VERSION . "</generator>\n";//!!!

		if (list ($pages, $pagination) = $this->engine->load_changed())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->engine->db->hide_locked)
				{
					$access = $this->engine->has_access('read', $page['page_id'], GUEST);
				}
				else
				{
					$access = true;
				}

				if ($access && ($count < $limit))
				{
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>" . $page['tag'] . "</title>\n";
					$xml .= "<link>" . $this->engine->href('', $page['tag'], '') . "</link>\n";
					$xml .= "<guid>" . $this->engine->href('', $page['tag'], '') . "</guid>\n";
					$xml .= "<pubDate>" . date('r', strtotime($page['modified'])) . "</pubDate>\n";
					$xml .= "<description>" . $page['modified'] . " " . $this->engine->_t('By') . " " .
						($page['user_name']
							? $page['user_name']
							: $this->engine->_t('Guest')) .
						($page['edit_note']
							? ' [' . $page['edit_note'] . ']'
							: '') .
						"</description>\n";
					$xml .= "</item>\n";
				}
			}
		}

		$xml .= "</channel>\n";
		$xml .= "</rss>\n";

		$this->write_file($name, $xml);
	}

	function feed($feed_cluster = '')
	{
		$limit			= 10;
		$name			= 'news';
		$news_cluster	= empty($feed_cluster) ? $this->engine->db->news_cluster : $feed_cluster;
		$news_levels	= $this->engine->db->news_levels;
		$feed_pages		= [];
		$prefix			= $this->engine->db->table_prefix;

		//  collect data
		$pages = $this->engine->load_all(
			"SELECT p.page_id, p.tag, p.title, p.created, p.body, p.body_r, p.comments, p.page_lang " .
			"FROM {$prefix}page p, " .
				"{$prefix}acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'read' AND a.list = '*' " .
				"AND p.comment_on_id = '0' " .
				"AND p.noindex <> '1' " .
				"AND p.deleted <> '1' " .
				"AND p.tag REGEXP '^{$news_cluster}{$news_levels}$' " .
			"ORDER BY p.tag");

		if ($pages)
		{
			// build an array
			foreach ($pages as $page)
			{
				#$access = $this->engine->has_access('read', $page['page_id'], GUEST);

				#if ($access === true)
				#{
					$feed_pages[]	= [
						'page_id'	=> $page['page_id'],
						'tag'		=> $page['tag'],
						'title'		=> $page['title'],
						'modified'	=> $page['created'],
						'body_r'	=> $page['body_r'],
						'comments'	=> $page['comments'],
						'page_lang'	=> $page['page_lang'],
						'date'		=> date('Y/m-d', strtotime($page['created']))

					];
				#}
			}

			// sorting function: sorts by dates
			// in tag names in reverse order
			$sort_dates = create_function(
				'$a, $b',	// func params
				'if ($a["date"] == $b["date"]) '.
					'return 0;'.
				'return ($a["date"] < $b["date"] ? 1 : -1);');
			// sort pages array
			usort($feed_pages, $sort_dates);
		}

		// build output
		$xml = '<?xml version="1.0" encoding="' . $this->charset . '"?>' . "\n" .
				"<?xml-stylesheet type=\"text/css\" href=\"" . $this->engine->db->theme_url . "css/wacko.css\" media=\"screen\"?>\n" .
				// TODO: atom.css
				'<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/"> ' . "\n" .
					'<channel>' . "\n" .
						'<title>' . $this->engine->db->site_name . $this->engine->_t('RecentNewsTitleXML') . '</title>' . "\n" .
						'<link>' . $this->engine->db->base_url . str_replace('%2F', '/', rawurlencode($news_cluster)) . '</link>' . "\n" .
						'<description>' . $this->engine->_t('RecentNewsXML') . $this->engine->db->site_name . '</description>' . "\n" .
						'<copyright>' . $this->engine->href('', $this->engine->db->policy_page) . '</copyright>' . "\n" .
						'<language>' . $this->lang . '</language>' . "\n" .
						'<pubDate>' . date('r') . '</pubDate>' . "\n" .
						'<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";
		$xml .= "<image>\n";
		$xml .= "<title>" . $this->engine->db->site_name . $this->engine->_t('RecentNewsTitleXML') . "</title>\n";
		$xml .= "<link>" . $this->engine->db->base_url . str_replace('%2F', '/', rawurlencode($news_cluster)) . "</link>\n";
		$xml .= "<url>" . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo) . "</url>\n";
		$xml .= "<width>" . $this->engine->db->logo_width ."</width>\n";
		$xml .= "<height>" . $this->engine->db->logo_height . "</height>\n";
		$xml .= "</image>\n";
		#$xml .= "<docs>http://www.rssboard.org/rss-specification</docs>\n";
		#$xml .= "<generator>WackoWiki " . WACKO_VERSION . "</generator>\n";//!!!

		$i = 0;

		if ($feed_pages)
		{
			foreach ($feed_pages as $page)
			{
				$i++;

				$categories	= $this->engine->load_categories($page['page_id'], '', false);

				// this is a news article
				$title	= $page['title'];
				$link	= $this->engine->href('', $page['tag']);
				$pdate	= date('r', strtotime($page['modified']));
				$coms	= $this->engine->href('', $page['tag'], 'show_comments=1#header-comments');

				// recompile if necessary
				if ($page['body_r'] == '')
				{
					$page['body_r'] = $this->engine->compile_body($page['body'], $page['page_id'], false, true);
				}

				// TODO: format -> add ['feed' => true]
				$text	= $this->engine->format($page['body_r'], 'post_wacko');

				// check current page lang for different charset to do_unicode_entities() against
				if ($this->lang != $page['page_lang'])
				{
					$title	= $this->engine->do_unicode_entities($title, $page['page_lang']);
					$text	= $this->engine->do_unicode_entities($text, $page['page_lang']);
				}

				$xml .= '<item>' . "\n" .
							'<title>' . $title . '</title>' . "\n" .
							'<link>' . $link . '</link>' . "\n" .
							'<guid isPermaLink="true">' . $link . '</guid>' . "\n" .
							'<description><![CDATA[' . str_replace(']]>', ']]&gt;', $text) . ']]></description>' . "\n" .
							'<pubDate>' . $pdate . '</pubDate>' . "\n";

				foreach ($categories as $id => $category)
				{
					$xml .= '<category>' . $category['category'] . '</category>' . "\n";
				}

				$xml .= 	($coms != '' ? '<comments>' . $coms . '</comments>' . "\n" : '');
				$xml .= 	($coms != '' ? '<slash:comments>' . $page['comments'] . '</slash:comments>' . "\n" : '');
				$xml .=  '</item>' . "\n";

				if ($i >= $limit)
				{
					break;
				}
			}
		}

		$xml .= 	'</channel>' . "\n" .
				'</rss>';

		$this->write_file($name, $xml);
	}

	function comments()
	{
		$limit	= 20;
		$name	= 'comments';
		$count	= '';
		$access	= '';

		// build output
		$xml = "<?xml version=\"1.0\" encoding=\"" . $this->charset."\"?>\n";
		$xml .= "<?xml-stylesheet type=\"text/css\" href=\"" . $this->engine->db->theme_url . "css/wacko.css\" media=\"screen\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>" . $this->engine->db->site_name . $this->engine->_t('RecentCommentsTitleXML') . "</title>\n";
		$xml .= "<link>" . $this->engine->db->base_url . "</link>\n";
		$xml .= "<description>" . $this->engine->_t('RecentCommentsXML') . $this->engine->db->site_name." </description>\n";
		$xml .= '<copyright>' . $this->engine->href('', $this->engine->db->policy_page) . '</copyright>' . "\n";
		$xml .= "<lastBuildDate>" . date('r') . "</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>" . $this->engine->db->site_name . $this->engine->_t('RecentCommentsTitleXML') . "</title>\n";
		$xml .= "<link>" . $this->engine->db->base_url . "</link>\n";
		$xml .= "<url>" . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo) . "</url>\n";
		$xml .= "<width>" . $this->engine->db->logo_width ."</width>\n";
		$xml .= "<height>" . $this->engine->db->logo_height . "</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>" . $this->lang . "</language>\n";
		#$xml .= "<docs>http://www.rssboard.org/rss-specification</docs>\n";
		#$xml .= "<generator>WackoWiki " . WACKO_VERSION . "</generator>\n";//!!!

		if ($comments = $this->engine->load_comment())
		{
			foreach ($comments as $i => $comment)
			{
				if ($this->engine->db->hide_locked)
				{
					$access = $this->engine->has_access('read', $comment['page_id'], GUEST);
				}
				else
				{
					$access = true;
				}

				if ( $access && ($count < $limit) )
				{
					$count++;

					// recompile if necessary
					if ($comment['body_r'] == '')
					{
						$comment['body_r'] = $this->engine->compile_body($comment['body'], $comment['page_id'], true, true);
					}

					$text = $this->engine->format($comment['body_r'], 'post_wacko');

					// check current page lang for different charset to do_unicode_entities() against
					if ($this->lang != $comment['page_lang'])
					{
						$text					= $this->engine->do_unicode_entities($text, $comment['page_lang']);
						$comment['title']		= $this->engine->do_unicode_entities($comment['title'], $comment['page_lang']);
						$comment['page_title']	= $this->engine->do_unicode_entities($comment['page_title'], $comment['page_lang']);
					}

					$xml .= "<item>\n";
					$xml .= "<title>" . $comment['title'] . " " . $this->engine->_t('To') . " " . $comment['page_title'] . " " . $this->engine->_t('From') . " " .
						($comment['user_name']
							? $comment['user_name']
							: $this->engine->_t('Guest')) .
						"</title>\n";
					$xml .= "<link>" . $this->engine->href('', $comment['tag'], '') . "</link>\n";
					$xml .= "<guid>" . $this->engine->href('', $comment['tag'], '') . "</guid>\n";
					$xml .= "<pubDate>" . date('r', strtotime($comment['modified'])) . "</pubDate>\n";
					$xml .= "<dc:creator>" . $comment['user_name'] . "</dc:creator>\n";

					$xml .= "<description><![CDATA[" . str_replace("]]>", "]]&gt;", $text) . "]]></description>\n";
					# $xml .= "<content:encoded><![CDATA[" . str_replace("]]>", "]]&gt;", $text) . "]]></content:encoded>\n";
					$xml .= "</item>\n";
				}
			}
		}

		$xml .= "</channel>\n";
		$xml .= "</rss>\n";

		$this->write_file($name, $xml);
	}

	function site_map()
	{
		$prefix		= $this->engine->db->table_prefix;

		//  collect data
		$pages = $this->engine->load_all(
			"SELECT p.page_id, p.tag, p.modified " .
			"FROM {$prefix}page p, " .
				"{$prefix}acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'read' AND a.list = '*' " .
				"AND p.comment_on_id = '0' " .
				"AND p.noindex <> '1' " .
				"AND p.deleted <> '1' " .
			"ORDER BY p.modified DESC, BINARY p.tag");

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		if ($pages)
		{
			foreach ($pages as $page)
			{
				$xml .= "<url>\n";
				$xml .= "<loc>" . $this->engine->href('', $page['tag']) . "</loc>\n";
				$xml .= "<lastmod>" . substr($page['modified'], 0, 10)  . "</lastmod>\n";

				$days_since_last_changed = (time() - strtotime($page['modified'])) / DAYSECS;

				if ($days_since_last_changed < 30)
				{
					$xml .= "<changefreq>daily</changefreq>\n";
				}
				else if ($days_since_last_changed < 60)
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

		$xml .= "</urlset>\n";

		file_put_contents(SITEMAP_XML, $xml);
		@chmod(SITEMAP_XML, 0644);
	}
}
