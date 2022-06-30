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
	public $engine;
	public $lang;
	public $charset;

	// CONSTRUCTOR
	function __construct(&$engine)
	{
		$this->engine	= & $engine;
		$this->lang		= $this->engine->db->language;
		$this->engine->set_language($this->lang, true, true);
		$this->charset	= $this->engine->get_charset($this->lang);
	}

	function write_file($name, $body): void
	{
		$file_name = Ut::join_path(XML_DIR, $name . '_' . preg_replace('/[^a-zA-Z\d]/', '', mb_strtolower($this->engine->db->site_name)) . '.xml');
		@file_put_contents($file_name, $body);
		@chmod($file_name, CHMOD_FILE);
	}

	function changes(): void
	{
		$limit	= 30;
		$name	= 'changes';
		$count	= '';

		$this->engine->canonical = true;

		$xml =
			'<?xml version="1.0" encoding="' . $this->charset . '"?>' . "\n" .
			'<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n" .
			'<channel>' . "\n" .
				'<title>' . $this->engine->db->site_name . $this->engine->_t('ChangesTitleXML') . '</title>' . "\n" .
				'<link>' . $this->engine->db->base_url . '</link>' . "\n" .
				'<description>' . $this->engine->_t('ChangesXML') . $this->engine->db->site_name . '</description>' . "\n" .
				'<copyright>' . $this->engine->href('', $this->engine->db->terms_page) . '</copyright>' . "\n" .
				'<language>' . $this->lang . '</language>' . "\n" .
				'<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n" .
				'<image>' . "\n" .
					'<title>' . $this->engine->db->site_name . $this->engine->_t('ChangesTitleXML') . '</title>' . "\n" .
					'<link>' . $this->engine->db->base_url . '</link>' . "\n" .
					'<url>' . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo)  . '</url>' . "\n" .
					'<width>' . $this->engine->db->logo_width . '</width>' . "\n" .
					'<height>' . $this->engine->db->logo_height . '</height>' . "\n" .
				'</image>' . "\n";

		if ([$pages, ] = $this->engine->load_changed())
		{
			foreach ($pages as $page)
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
					$xml .=
						'<item>' . "\n" .
							'<title>' . $page['tag'] . '</title>' . "\n" .
							'<link>' . $this->engine->href('', $page['tag']) . '</link>' . "\n" .
							'<guid>' . $this->engine->href('', $page['tag']) . '</guid>' . "\n" .
							'<pubDate>' . date('r', strtotime($page['modified'])) . '</pubDate>' . "\n" .
							'<description>' . $page['modified'] . ' ' . $this->engine->_t('By') . ' ' .
							($page['user_name'] ?: $this->engine->_t('Guest')) .
							($page['edit_note']
								? ' [' . $page['edit_note'] . ']'
								: '') .
							'</description>' . "\n" .
						'</item>' . "\n";
				}
			}
		}

		$xml .= '</channel>' . "\n";
		$xml .= '</rss>';

		$this->write_file($name, $xml);
		$this->engine->canonical = false;
	}

	function feed($feed_cluster = ''): void
	{
		$limit			= 10;
		$name			= 'news';
		$news_cluster	= empty($feed_cluster) ? $this->engine->db->news_cluster : $feed_cluster;
		$news_levels	= $this->engine->db->news_levels;
		$prefix			= $this->engine->db->table_prefix;

		$this->engine->canonical = true;

		// collect data
		$pages = $this->engine->db->load_all(
			"SELECT p.page_id, p.tag, p.title, p.created, p.body, p.body_r, p.comments, p.page_lang " .
			"FROM {$prefix}page p, " .
				"{$prefix}acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'read' AND a.list = '*' " .
				"AND p.comment_on_id = 0 " .
				"AND p.noindex <> 1 " .
				"AND p.deleted <> 1 " .
				"AND p.tag REGEXP '^{$news_cluster}{$news_levels}$' " .
			"ORDER BY p.created DESC " .
			"LIMIT " . (int) $limit);

		if ($pages)
		{
			// build an array
			foreach ($pages as $page)
			{
				$object_ids[] = $page['page_id'];
			}

			$this->engine->preload_categories($object_ids, OBJECT_PAGE);
			$this->engine->preload_file_links($object_ids);
		}

		// build output
		$xml =
			'<?xml version="1.0" encoding="' . $this->charset . '"?>' . "\n" .
			'<?xml-stylesheet type="text/css" href="' . $this->engine->db->theme_url . 'css/wacko.css" media="screen"?>' . "\n" .
			'<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/"> ' . "\n" .
			'<channel>' . "\n" .
				'<title>' . $this->engine->db->site_name . $this->engine->_t('NewsTitleXML') . '</title>' . "\n" .
				'<link>' . $this->engine->db->base_url . str_replace('%2F', '/', rawurlencode($news_cluster)) . '</link>' . "\n" .
				'<description>' . $this->engine->_t('NewsXML') . $this->engine->db->site_name . '</description>' . "\n" .
				'<copyright>' . $this->engine->href('', $this->engine->db->terms_page) . '</copyright>' . "\n" .
				'<language>' . $this->lang . '</language>' . "\n" .
				'<pubDate>' . date('r') . '</pubDate>' . "\n" .
				'<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n" .
				'<image>' . "\n" .
					'<title>' . $this->engine->db->site_name . $this->engine->_t('NewsTitleXML') . '</title>' . "\n" .
					'<link>' . $this->engine->db->base_url . str_replace('%2F', '/', rawurlencode($news_cluster)) . '</link>' . "\n" .
					'<url>' . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo) . '</url>' . "\n" .
					'<width>' . $this->engine->db->logo_width . '</width>' . "\n" .
					'<height>' . $this->engine->db->logo_height . '</height>' . "\n" .
				'</image>' . "\n";

		$i = 0;

		if ($pages)
		{
			foreach ($pages as $page)
			{
				$i++;

				$categories	= $this->engine->load_categories($page['page_id'], OBJECT_PAGE, false);

				// this is a news article
				$title	= $page['title'];
				$link	= $this->engine->href('', $page['tag']);
				$pdate	= date('r', strtotime($page['created']));
				$coms	= $this->engine->href('', $page['tag'], ['show_comments' => 1, '#' => 'header-comments']);

				// recompile if necessary
				if ($page['body_r'] == '')
				{
					# $page['body_r'] = $this->engine->compile_body($page['body'], $page['page_id'], true, true); // requiers 'body'
				}

				// TODO: format -> add ['feed' => true]
				$this->engine->context[++$this->engine->current_context] = $page['tag'];
				$text	= $this->engine->format($page['body_r'], 'post_wacko');
				$this->engine->current_context--;

				$xml .=
					'<item>' . "\n" .
						'<title>' . $title . '</title>' . "\n" .
						'<link>' . $link . '</link>' . "\n" .
						'<guid isPermaLink="true">' . $link . '</guid>' . "\n" .
						'<description><![CDATA[' . str_replace(']]>', ']]&gt;', $text) . ']]></description>' . "\n" .
						'<pubDate>' . $pdate . '</pubDate>' . "\n";

				foreach ($categories as $category)
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

		$xml .=		'</channel>' . "\n";
		$xml .= '</rss>';

		$this->write_file($name, $xml);
		$this->engine->canonical = false;
	}

	function comments(): void
	{
		$limit	= 20;
		$name	= 'comments';
		$count	= '';
		$access	= '';

		$this->engine->canonical = true;

		// build output
		$xml =
			'<?xml version="1.0" encoding="' . $this->charset . '"?>' . "\n" .
			'<?xml-stylesheet type="text/css" href="' . $this->engine->db->theme_url . 'css/wacko.css" media="screen"?>' . "\n" .
			'<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n" .
			'<channel>' . "\n" .
				'<title>' . $this->engine->db->site_name . $this->engine->_t('CommentsTitleXML') . "</title>\n" .
				'<link>' . $this->engine->db->base_url . "</link>\n" .
				'<description>' . $this->engine->_t('CommentsXML') . $this->engine->db->site_name . "</description>\n" .
				'<copyright>' . $this->engine->href('', $this->engine->db->terms_page) . '</copyright>' . "\n" .
				'<language>' . $this->lang . '</language>' . "\n" .
				'<lastBuildDate>' . date('r') . "</lastBuildDate>\n" .
				'<image>' . "\n" .
					'<title>' . $this->engine->db->site_name . $this->engine->_t('CommentsTitleXML') . '</title>' . "\n" .
					'<link>' . $this->engine->db->base_url . '</link>' . "\n" .
					'<url>' . $this->engine->db->base_url . Ut::join_path(IMAGE_DIR, $this->engine->db->site_logo) . '</url>' . "\n" .
					'<width>' . $this->engine->db->logo_width . '</width>' . "\n" .
					'<height>' . $this->engine->db->logo_height . '</height>' . "\n" .
				'</image>' . "\n";

		if ($comments = $this->engine->load_comment())
		{
			$reset_tag = $this->engine->tag;

			foreach ($comments as $comment)
			{
				$access = $this->engine->has_access('read', $comment['comment_on_id'], GUEST);

				if ( $access && ($count < $limit) )
				{
					$count++;

					// recompile if necessary
					if ($comment['body_r'] == '')
					{
						$comment['body_r'] = $this->engine->compile_body($comment['body'], $comment['page_id'], false, true);
					}

					// set page context
					$this->engine->tag = $comment['page_tag'];
					$this->engine->context[++$this->engine->current_context] = $comment['page_tag'];
					$text = $this->engine->format($comment['body_r'], 'post_wacko', ['strip_notypo' => true]);
					$this->engine->current_context--;

					$xml .=
						'<item>' . "\n" .
							'<title>' . Ut::html($comment['title']) . ' ' . $this->engine->_t('To') . ' ' . Ut::html($comment['page_title']) . ' ' . $this->engine->_t('From') . ' ' .
							($comment['user_name'] ?: $this->engine->_t('Guest')) .
							'</title>' . "\n" .
							'<link>' . $this->engine->href('', $comment['tag']) . '</link>' . "\n" .
							'<guid>' . $this->engine->href('', $comment['tag']) . '</guid>' . "\n" .
							'<pubDate>' . date('r', strtotime($comment['created'])) . '</pubDate>' . "\n" .
							'<dc:creator>' . $comment['user_name'] . '</dc:creator>' . "\n" .
							'<description><![CDATA[' . str_replace(']]>', ']]&gt;', $text) . ']]></description>' . "\n" .
							#'<content:encoded><![CDATA[' . str_replace(']]>', ']]&gt;', $text) . ']]></content:encoded>' . "\n" .
						'</item>' . "\n";
				}
			}

			$this->engine->tag = $reset_tag;
		}

		$xml .= '</channel>' . "\n";
		$xml .= '</rss>';

		$this->write_file($name, $xml);
		$this->engine->canonical = false;
	}

	// Sitemaps XML file: http://www.sitemaps.org
	function site_map(): void
	{
		$prefix		= $this->engine->db->table_prefix;

		// collect data
		$pages = $this->engine->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.modified, p.page_lang " .
			"FROM {$prefix}page p, " .
				"{$prefix}acl AS a " .
			"WHERE p.page_id = a.page_id " .
				"AND a.privilege = 'read' AND a.list = '*' " .
				"AND p.comment_on_id = 0 " .
				"AND p.noindex <> 1 " .
				"AND p.deleted <> 1 " .
			"ORDER BY p.modified DESC, BINARY p.tag");

		$xml  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$xml .= $this->engine->db->xml_sitemap_gz
				? ''
				: '<?xml-stylesheet type="text/xsl" href="' . $this->engine->db->base_url . Ut::join_path(THEME_DIR, '_common/sitemap.xsl') . '"?>' . "\n";
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

		if ($pages)
		{
			foreach ($pages as $page)
			{
				// for href()
				$this->engine->cache_page($page, true);

				$xml .= '<url>' . "\n";

				$xml .= '<loc>' . $this->engine->href('', $page['tag'], null, null, null, null, false, true) . '</loc>' . "\n";
				$xml .= '<lastmod>' . substr($page['modified'], 0, 10)  . '</lastmod>' . "\n";

				$days_since_last_changed = (time() - strtotime($page['modified'])) / DAYSECS;

				if ($days_since_last_changed < 15)
				{
					$freq = 'daily';
				}
				else if ($days_since_last_changed < 30)
				{
					$freq = 'weekly';
				}
				else if ($days_since_last_changed < 60)
				{
					$freq = 'monthly';
				}
				else
				{
					$freq = 'yearly';
				}

				$xml .= '<changefreq>' . $freq . '</changefreq>' . "\n";

				// TODO: The only thing I'm not sure about how to handle dynamically...
				# $xml .= '<priority>0.8</priority>' . "\n";

				$xml .= '</url>' . "\n";
			}
		}

		$xml .= '</urlset>';

		if ($this->engine->db->xml_sitemap_gz)
		{
			$file_name	= Ut::join_path(XML_DIR, SITEMAP_XML . '.gz');
			$file		= gzopen($file_name, 'wb' . BACKUP_COMPRESSION_RATE);
			gzwrite($file, $xml);
			gzclose($file);
		}
		else
		{
			$file_name	= Ut::join_path(XML_DIR, SITEMAP_XML);
			file_put_contents($file_name, $xml);
		}

		@chmod($file_name, CHMOD_FILE);
	}

	// OpenSearch XML description file
	function open_search(): void
	{
		$this->engine->canonical = true;

		$xml =
			'<?xml version="1.0"?>' . "\n" .
			'<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">' . "\n" .
				'<ShortName>' . $this->engine->db->site_name . '</ShortName>' . "\n" .
				'<Description>' . $this->engine->db->site_name . '</Description>' . "\n" .
				'<InputEncoding>UTF-8</InputEncoding>' . "\n" .
				'<Image height="16" width="16" type="image/x-icon">' . $this->engine->get_favicon() . '</Image>' . "\n" .
				'<Url type="text/html" method="get" template="' . $this->engine->href('', $this->engine->db->search_page) . '?phrase={searchTerms}" />' . "\n" .
			'</OpenSearchDescription>';

		$file_name = Ut::join_path(XML_DIR, 'opensearch.xml');
		file_put_contents($file_name, $xml);
		@chmod('opensearch.xml', CHMOD_FILE);
		$this->engine->canonical = false;
	}
}
