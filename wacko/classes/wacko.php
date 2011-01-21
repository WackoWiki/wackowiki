<?php

// engine class
class Wacko
{
	// VARIABLES
	var $config					= array();
	var $dblink;
	var $page;
	var $tag;
	var $supertag;
	var $forum;
	var $categories;
	var $iswatched;
	var $query_time;
	var $query_log				= array();
	var $inter_wiki				= array();
	var $_acl					= array();
	var $acl_cache				= array();
	var $context				= array();
	var $current_context		= 0;
	var $pages_meta				= 'page_id, owner_id, user_id, tag, supertag, created, modified, edit_note, minor_edit, latest, handler, comment_on_id, lang, title, keywords, description';
	var $first_inclusion		= array();	// for backlinks
	var $format_safe			= true;		//for htmlspecialchars() in pre_link
	var $unicode_entities		= array();	//common unicode array
	var $timer;
	var $toc_context			= array();
	var $search_engines			= array('bot', 'rambler', 'yandex', 'crawl', 'search', 'archiver', 'slurp', 'aport', 'crawler', 'google', 'inktomi', 'spider', );
	var $_langlist				= null;
	var $languages				= null;
	var $translations			= null;
	var $wanted_cache			= null;
	var $page_cache				= null;
	var $_formatter_noautolinks	= null;
	var $numerate_links			= null;
	var $post_wacko_action		= null;
	var $_userhost				= null;
	var $paragrafica_styles		= array(
		'before'	=> array(
						'_before'	=> '',
						'_after'	=> '',
						'before'	=> '<span class="pmark">[##]</span><br />',
						'after'		=> ''),
		'after'		=> array(
						'_before'	=> '',
						'_after'	=> '',
						'before'	=> '',
						'after'		=> '<span class="pmark">[##]</span>'),
		'right'		=> array(
						'_before'	=> '<div class="pright"><div class="p-">&nbsp;<span class="pmark">[##]</span></div><div class="pbody-">',
						'_after'	=> '</div></div>',
						'before'	=> '',
						'after'		=> ''),
		'left'		=> array(
						'_before'	=> '<div class="pleft"><div class="p-"><span class="pmark">[##]</span>&nbsp;</div><div class="pbody-">',
						'_after'	=> '</div></div>',
						'before'	=> '',
						'after'		=> ''),
	);
	var $paragrafica_patches = array(
		'before'	=> array('before'),
		'after'		=> array('after'),
		'right'		=> array('_before'),
		'left'		=> array('_before'),
	);
	var $npj_macros = array(
		'âèêè' => 'wiki', 'âàêà' => 'wacko', 'âåá' => 'web'
	);

	// CONSTRUCTOR
	function __construct($config, $dblink)
	{
		$this->timer	= $this->get_micro_time();
		$this->config	= $config;
		$this->dblink	= $dblink;
	}

	// DATABASE
	function query($query, $debug = 0)
	{
		if ($debug)
		{
			echo "(QUERY: $query)";
		}

		if ($this->config['debug'] >= 2)
		{
			$start = $this->get_micro_time();
		}

		$result = query($this->dblink, $query, $this->config['debug']);

		if ($this->config['debug'] >= 2)
		{
			$time = $this->get_micro_time() - $start;
			$this->query_time += $time;

			if ($this->config['debug'] >= 3)
			{
				$this->query_log[] = array(
					'query'		=> $query,
					'time'		=> $time
				);
			}
		}

		return $result;
	}

	function load_all($query, $docache = 0)
	{
		$data	= array();

		// retrieving from cache
		if ($this->config['cache_sql'] && $docache)
		{
			if ($data = $this->cache->load_sql($query))
			{
				return $data;
			}
		}

		// retrieving from db
		if ($r = $this->query($query))
		{
			while ($row = fetch_assoc($r))
			{
				$data[] = $row;
			}

			free_result($r);
		}

		// saving to cache
		if ($this->config['cache_sql'] && $docache)
		{
			$this->cache->save_sql($query, $data);
		}

		if (isset($data))
		{
			return $data;
		}
		else
		{
			return null;
		}
	}

	function load_single($query, $docache = 0)
	{
		if ($data = $this->load_all($query, $docache))

			if (isset($data))
			{
				return $data[0];
			}
			else
			{
				return null;
			}
	}

	// MISC
	function get_micro_time()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}

	function get_page_tag_by_id($page_id = 0)
	{
		$page = $this->load_single(
					"SELECT tag ".
					"FROM ".$this->config['table_prefix']."page ".
					"WHERE page_id = '".$page_id."' ".
					"LIMIT 1");

		return $page['tag'];;
	}

	function get_page_id($tag = 0)
	{
		if(!$tag)
		{
			return $this->page['page_id'];
		}
		else
		//Soon we'll need to have page_id when saving a new page to continue working with $page_id instead of $tag
		{
			if (!isset($this->page_id_cache[$tag]))
			{
				// Returns Array ( [id] => Value )
				$get_page_id = $this->load_single(
					"SELECT page_id ".
					"FROM ".$this->config['table_prefix']."page ".
					"WHERE tag = '".quote($this->dblink, $tag)."' ".
					"LIMIT 1");

				// Get page_ID value
				$new_page_id = $get_page_id['page_id'];

				$this->page_id_cache[$tag] = $new_page_id;
			}
			else
			{
				$new_page_id = $this->page_id_cache[$tag];
			}

			return $new_page_id;
		}
	}

	function get_wacko_version()
	{
		return WACKO_VERSION;
	}

	// checks if the parameter is an empty string or a string containing only whitespace
	function is_blank( $variable )
	{
		if( trim( $variable ) == '' )
		{
			return true;
		}

		return false;
	}

	function check_file_exists($file_name, $unwrapped_tag = '' )
	{
		if ($unwrapped_tag == '')
		{
			$page_id = 0;
		}
		else
		{
			$page		= $this->load_page($unwrapped_tag, 0, '', LOAD_CACHE, LOAD_META);
			$page_id	= $page['page_id'];

			if (!$page_id)
			{
				return false;
			}
		}

		$file = (isset($this->filesCache[$page_id][$file_name]) ? $this->filesCache[$page_id][$file_name] : '');

		if (!($file))
		{
			$what = $this->load_all(
				"SELECT upload_id, file_name, file_size, description, picture_w, picture_h, file_ext ".
				"FROM ".$this->config['table_prefix']."upload ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
					"AND file_name = '".quote($this->dblink, $file_name)."'");

			if (sizeof($what) == 0)
			{
				return false;
			}

			$file = $what[0];
			$this->filesCache[$page_id][$file_name] = $file;
		}

		return $file;
	}

	function available_themes()
	{
		$handle	= opendir('themes');

		while (false !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..' && is_dir('themes/'.$file) && $file != '_common')
			{
				$themelist[] = $file;
			}
		}

		closedir($handle);
		sort($themelist, SORT_STRING);

		if ($allow = trim($this->config['allow_themes']))
		{
			$ath = explode(',', $allow);

			if (is_array($ath) && $ath[0])
			{
				$themelist = array_intersect ($ath, $themelist);
			}
		}

		return $themelist;
	}

	function get_time_string_formatted($time)
	{
		return date($this->config['date_format'].' '.
			$this->config['time_format_seconds'], strtotime($time));
	}

	function get_unix_time_formatted($time)
	{
		return date($this->config['date_format'].' '.
			$this->config['time_format_seconds'], $time);
	}

	function get_page_time_formatted()
	{
		return $this->get_time_string_formatted($this->page['modified']);
	}

	// LANG FUNCTIONS
	function set_translation($lang)
	{
		$this->resource = & $this->translations[$lang];
	}

	function set_language($lang)
	{
		$this->load_translation($lang);
		$this->language = &$this->languages[$lang];

		setlocale(LC_CTYPE, $this->language['locale']);

		$this->language['locale']		= setlocale(LC_CTYPE, 0);
		$this->language['UPPER']		= '['.$this->language['UPPER_P'].']';
		$this->language['UPPERNUM']		= '[0-9'.$this->language['UPPER_P'].']';
		$this->language['LOWER']		= '['.$this->language['LOWER_P'].']';
		$this->language['ALPHA']		= '['.$this->language['ALPHA_P'].']';
		$this->language['ALPHANUM']		= '[0-9'.$this->language['ALPHA_P'].']';
		$this->language['ALPHANUM_P']	= '0-9'.$this->language['ALPHA_P'];
	}

	function load_translation($lang)
	{
		if (!isset($this->translations[$lang]))
		{
			$resourcefile = 'lang/wacko.'.$lang.'.php';

			if (@file_exists($resourcefile))
			{
				include($resourcefile);
			}

			// wacko.all
			$resourcefile = 'lang/wacko.all.php';

			if (!$this->translations['all'])
			{
				if (@file_exists($resourcefile))
				{
					include($resourcefile);
				}

				$this->translations['all'] = & $wacko_all_resource;
			}

			if (!isset($wacko_translation))
			{
				$wacko_translation = array();
			}

			$wacko_resource = array_merge($wacko_translation, $this->translations['all']);

			// theme
			$resourcefile = 'themes/'.$this->config['theme'].'/lang/wacko.'.$lang.'.php';

			if (@file_exists($resourcefile))
			{
				include($resourcefile);
			}
			if (!isset($theme_translation))
			{
				$theme_translation = '';
			}

			$wacko_resource = array_merge((array)$wacko_resource, (array)$theme_translation);

			// wacko.all theme
			$resourcefile = 'themes/'.$this->config['theme'].'/lang/wacko.all.php';

			if (@file_exists($resourcefile))
			{
				include($resourcefile);
			}

			$wacko_resource = array_merge((array)$wacko_resource, (array)$theme_translation);

			$this->translations[$lang] = $wacko_resource;
			$this->load_lang($lang);
		}
	}

	function load_lang($lang)
	{
		$wacko_language = '';

		if (!isset($this->languages[$lang]))
		{
			$resourcefile = 'lang/lang.'.$lang.'.php';

			if (@file_exists($resourcefile))
			{
				include($resourcefile);
			}

			$this->languages[$lang] = $wacko_language;
			$ue = array();
			$ue = @array_flip($wacko_language['unicode_entities']);

			if (!isset($ue))
			{
				$ue = array();
			}

			$this->unicode_entities = array_merge($this->unicode_entities, (array)$ue);
			unset($this->unicode_entities[0]);
		}
	}

	function load_all_languages()
	{
		if (!$this->config['multilanguage'])
		{
			return;
		}

		$langs = $this->available_languages();

		foreach ($langs as $lang)
		{
			$this->load_lang($lang);
		}
	}

	function available_languages()
	{
		if (!$this->_langlist)
		{
			$handle = opendir('lang');

			while (false !== ($file = readdir($handle)))
			{
				if ($file != '.'
				&& $file != '..'
				&& $file != 'wacko.all.php'
				&& !is_dir('lang/'.$file)
				&& 1 == preg_match('/^wacko\.(.*?)\.php$/', $file, $match))
				{
					$langlist[] = $match[1];
				}
			}

			closedir($handle);
			sort($langlist, SORT_STRING);
			$this->_langlist = $langlist;
		}

		return $this->_langlist;
	}

	function user_agent_language()
	{
		$lang = '';

		if ($this->config['multilanguage'])
		{
			if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			{
				$this->user_lang = $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

				// Check whether we have language files for this language
				if(!in_array($this->user_lang, $this->available_languages()))
				{
					// The HTTP_ACCEPT_LANGUAGE language doesn't have any language files so use the admin set language instead
					$this->user_lang = $lang = $this->config['language'];
				}
			}
			else
			{
				$this->user_lang = $lang = $this->config['language'];
			}
		}
		else if (!$lang)
		{
			$this->user_lang = $lang = $this->config['language'];
		}

		return $lang;
	}

	function get_translation($name, $lang = '', $dounicode = true)
	{
		if (!$this->config['multilanguage'])
		{
			return $this->resource[$name];
		}

		if (!$lang && (isset($this->user_lang) && $this->user_lang != $this->page_lang))
		{
			$lang = $this->user_lang;
		}

		if ($lang != '')
		{
			$this->load_translation($lang);

			if (isset($this->translations[$lang][$name]))
			{
				return (is_array($this->translations[$lang][$name]))
					? $this->translations[$lang][$name]
					: ($dounicode
						? $this->do_unicode_entities($this->translations[$lang][$name], $lang)
						: $this->translations[$lang][$name]);
			}
		}

		if (isset($this->resource[$name]))
		{
			return $this->resource[$name];
		}
	}

	function format_translation($name, $lang = '')
	{
		$string = $this->get_translation($name, $lang, false);
		$this->format_safe = false;
		$string = $this->format($string);
		$this->format_safe = true;
		return $string;
	}

	function determine_lang()
	{
		$langlist = $this->available_languages();

		//!!!! wrong code, maybe!
		if ((isset($this->method) && $this->method == 'edit') && (isset($_GET['add']) && $_GET['add'] == 1))
		{
			if (isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], $langlist))
			{
				$lang = $_REQUEST['lang'];
			}
			else
			{
				$lang = $this->user_lang;
			}
		}
		else
		{
			$lang = (isset($this->page_lang) ? $this->page_lang : null);
		}

		return $lang;
	}

	function set_page_lang($lang)
	{
		if (!$lang)
		{
			return false;
		}

		$this->page_lang = $lang;
		$this->set_language($lang);
		return true;
	}

	function get_charset()
	{
		$lang = $this->determine_lang();
		$this->load_translation($lang);

		if (isset($this->languages[$lang]['charset']))
		{
			return $this->languages[$lang]['charset'];
		}
		else
		{
			null;
		}
	}

	function do_unicode_entities($string, $lang)
	{
		if (!$this->config['multilanguage'])
		{
			return $string;
		}

		$_lang = $this->determine_lang();

		if ($lang == $_lang)
		{
			return $string;
		}

		$this->load_translation($lang);

		if (is_array($this->languages[$lang]['unicode_entities']))
		{
			return @strtr($string, $this->languages[$lang]['unicode_entities']);
		}
		else
		{
			return $string;
		}
	}

	function try_utf_decode ($string)
	{
		$t1 = $this->utf8_to_unicode_entities($string);
		$t2 = @strtr($t1, $this->unicode_entities);

		if (!preg_match('/\&\#[0-9]+\;/', $t2))
		{
			$string = $t2;
		}

		return $string;
	}

	function utf8_to_unicode_entities($source)
	{
		// array used to figure what number to decrement from character order value
		// according to number of characters used to map unicode to ascii by utf-8
		$decrement[4] = 240; $decrement[3] = 224;
		$decrement[2] = 192; $decrement[1] = 0;

		// the number of bits to shift each char_num by
		$shift[1][0] = 0;  $shift[2][0] = 6;
		$shift[2][1] = 0;  $shift[3][0] = 12;
		$shift[3][1] = 6;  $shift[3][2] = 0;
		$shift[4][0] = 18; $shift[4][1] = 12;
		$shift[4][2] = 6;  $shift[4][3] = 0;

		$pos = 0;
		$len = strlen ($source);
		$encoded_string = '';

		while ($pos < $len)
		{
			$ascii_pos = ord (substr ($source, $pos, 1));

			if (($ascii_pos >= 240) && ($ascii_pos <= 255))
			{
				// 4 chars representing one unicode character
				$this_letter = substr ($source, $pos, 4);
				$pos += 4;
			}
			else if (($ascii_pos >= 224) && ($ascii_pos <= 239))
			{
				// 3 chars representing one unicode character
				$this_letter = substr ($source, $pos, 3);
				$pos += 3;
			}
			else if (($ascii_pos >= 192) && ($ascii_pos <= 223))
			{
				// 2 chars representing one unicode character
				$this_letter = substr ($source, $pos, 2);
				$pos += 2;
			}
			else
			{
				// 1 char (lower ascii)
				$this_letter = substr ($source, $pos, 1);
				$pos += 1;
			}

			// process the string representing the letter to a unicode entity
			$this_len = strlen ($this_letter);

			if ($this_len > 1)
			{
				$this_pos = 0;
				$decimal_code = 0;

				while ($this_pos < $this_len)
				{
					$this_char_ord = ord (substr ($this_letter, $this_pos, 1));

					if ($this_pos == 0)
					{
						$char_num = intval ($this_char_ord - $decrement[$this_len]);
						$decimal_code += ($char_num << $shift[$this_len][$this_pos]);
					}
					else
					{
						$char_num = intval ($this_char_ord - 128);
						$decimal_code += ($char_num << $shift[$this_len][$this_pos]);
					}

					$this_pos++;
				}

				$encoded_letter = '&#'. $decimal_code . ';';
			}
			else
			{
				$encoded_letter = $this_letter;
			}

			$encoded_string .= $encoded_letter;
		}

		return $encoded_string;
	}

	// PAGES
	function npj_translit($tag, $strtolow = TRAN_LOWERCASE, $donotload = TRAN_LOAD)
	{
		// Lookup transliteration result in the cache and return it if found
		static $npj_cache;
		$cach_key = $tag.$strtolow.$donotload;

		if (isset($npj_cache[$cach_key]))
		{
			return $npj_cache[$cach_key];
		}

		$_lang = null;

		if (!$this->config['multilanguage'])
		{
			$donotload = 1;
		}

		if (!$donotload)
		{
			if ($page = $this->load_page($tag, 0, '', LOAD_CACHE, LOAD_META))
			{
				$_lang = $this->language['code'];

				if (isset($page['lang']))
				{
					$lang = $page['lang'];
				}
				else
				{
					$lang = $this->config['language'];
				}

				$this->set_language($lang);
			}
		}

		$tag	= str_replace('//',		'/',	$tag);
		$tag	= str_replace('-',		'',		$tag);
		$tag	= str_replace(' ',		'',		$tag);
		$tag	= str_replace("'",		'_',	$tag);
		$_tag	= strtolower($tag);

		if ($strtolow)
		{
			$tag = @strtr($_tag, $this->npj_macros);
		}
		else
		{
			foreach($this->npj_macros as $macro => $value)
			{
				while (($pos = strpos($_tag, $macro)) !== false)
				{
					$_tag	= substr_replace($_tag, $value, $pos, strlen($macro));
					$tag	= substr_replace($tag, ucfirst($value), $pos, strlen($macro));
				}
			}
		}

		$tag = @strtr($tag, $this->language['NpjLettersFrom'], $this->language['NpjLettersTo']);
		$tag = @strtr($tag, $this->language['NpjBiLetters']);

		if ($strtolow)
		{
			$tag = strtolower($tag);
		}

		if ($_lang)
		{
			$this->set_language($_lang);
		}

		$result =  rtrim($tag, '/');

		// Put transliteration result in the cache
		$npj_cache[$cach_key] = $result;

		return $result;
	}

	function get_keywords()
	{
		$meta_keywords = '';

		if (isset($this->page['keywords']))
		{
			$meta_keywords = $this->page['keywords'];
		}
		else if ($this->config['meta_keywords'])
		{
			$meta_keywords = $this->config['meta_keywords'];
		}

		// add assigned categories
		if (isset($this->categories))
		{
			if (!empty($meta_keywords))
			{
				$meta_keywords .= ', ';
			}

			$meta_keywords .= strtolower(implode(', ', $this->categories));
		}

		return htmlspecialchars($meta_keywords);
	}

	function get_description()
	{
		$meta_description = '';

		if ($this->page['description'])
		{
			$meta_description = $this->page['description'];
		}
		else if ($this->config['meta_description'])
		{
			$meta_description = $this->config['meta_description'];
		}

		return htmlspecialchars($meta_description);
	}

	// wrapper for old_load_page
	function load_page($tag, $page_id = 0, $revision_id = '', $cache = LOAD_CACHE, $metadataonly = LOAD_ALL)
	{
		$page = '';

		if ($page_id != 0)
		{
			if ($this->get_cached_wanted_page('', $page_id) == 1)
			{
				return '';
			}
		}
		else
		{
			if ($this->get_cached_wanted_page($tag) == 1)
			{
				return '';
			}
		}

		// 1. search for page_id (... is preferred, $supertag next)
		if ($page_id != 0)
		{
			$page = $this->old_load_page('', $page_id, $revision_id, $cache, false, $metadataonly);
		}

		// 2. search for supertag
		if (!$page)
		{
			$page = $this->old_load_page($this->npj_translit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD), 0, $revision_id, $cache, true, $metadataonly);
		}

		// 3. if not found, search for tag
		if (!$page)
		{
			$page = $this->old_load_page($tag, 0, $revision_id, $cache, false, $metadataonly);
		}

		// 4. still nothing? file under wanted
		if (!$page)
		{
			($page_id != 0
				? $this->cache_wanted_page('', $page_id)
				: $this->cache_wanted_page($tag)
			);
		}

		return $page;
	}

	function old_load_page($tag, $page_id = 0, $revision_id = '', $cache = 1, $supertagged = false, $metadataonly = 0)
	{
		$supertag = '';

		if ($page_id == 0 && $tag == '')
		{
			return '';
		}

		$page = null;

		if ($page_id == 0)
		{
			(!$supertagged
				? $supertag = $this->npj_translit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD)
				: $supertag = $tag
			);
		}

		// retrieve from cache
		if (!$revision_id && $cache && ($cached_page = $this->get_cached_page($supertag, $page_id, $metadataonly)))
		{
			$page = $cached_page;
		}

		// load page
		if ($metadataonly)
		{
			$what_p = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.lang, p.keywords, p.description, p.noindex, u.user_name, o.user_name AS owner_name';
			$what_r = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.lang, p.keywords, p.description, s.noindex, u.user_name, o.user_name AS owner_name';
		}
		else
		{
			$what_p = 'p.*, u.user_name, o.user_name AS owner_name';
			$what_r = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.body, p.body_r, p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.reviewed_time, p.reviewer_id, p.ip, p.latest, p.handler, p.comment_on_id, p.lang, p.description, p.keywords, s.hide_comments, s.hide_files, s.hide_rating, s.hide_toc, s.hide_index, s.tree_level, s.allow_rawhtml, s.disable_safehtml, s.noindex, s.theme, u.user_name, o.user_name AS owner_name';
		}

		//
		$settings = '';

		if (!$page)
		{
			if ($supertagged || $page_id)
			{
				$page = $this->load_single(
					"SELECT ".$what_p." ".
					"FROM ".$this->config['table_prefix']."page p ".
						"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
						"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE ".( $page_id != 0
						? "page_id  = '".quote($this->dblink, $page_id)."' "
						: "supertag = '".quote($this->dblink, $supertag)."' " ).
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id && $revision_id != $page['page_id'])
				{
					$this->cache_page($page, $page_id, $metadataonly);

					$page = $this->load_single(
						"SELECT p.revision_id, ".$what_r." ".
						"FROM ".$this->config['table_prefix']."revision p ".
							"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."page s ON (p.page_id = s.page_id) ".
						"WHERE ".( $page_id != 0
							? "p.page_id  = '".quote($this->dblink, $page_id)."' "
							: "p.supertag = '".quote($this->dblink, $supertag)."' " ).
							"AND revision_id = '".quote($this->dblink, $revision_id)."' ".
						"LIMIT 1");

					$page['owner_id'] = $owner_id;
				}
			}
			else if (!preg_match('/[^'.$this->language['ALPHANUM_P'].'\_\-]/', $tag))
			{
				$page = $this->load_single(
					"SELECT ".$what_p." ".
					"FROM ".$this->config['table_prefix']."page p ".
						"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
						"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE tag = '".quote($this->dblink, $tag)."' ".
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id && $revision_id != $page['page_id'])
				{
					$this->cache_page($page, $page_id, $metadataonly);

					$page = $this->load_single(
						"SELECT ".$what_r." ".
						"FROM ".$this->config['table_prefix']."revision p ".
							"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."page s ON (p.page_id = s.page_id) ".
						"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
							"AND revision_id = '".quote($this->dblink, $revision_id)."' ".
						"LIMIT 1");

					$page['owner_id'] = $owner_id;
				}
			}
		}
		// cache result
		if (!$revision_id && !$cached_page)
		{
			$this->cache_page($page, $page_id, $metadataonly);
		}

		return $page;
	}

	function get_cached_page($supertag, $page_id = 0, $metadataonly = 0)
	{
		if ($page_id != 0)
		{
			if (isset($this->page_cache['page_id'][$page_id]))
			{
				if ($this->page_cache['page_id'][$page_id]['mdonly'] == 0 || $metadataonly == $this->page_cache['page_id'][$page_id]['mdonly'])
				{
					return $this->page_cache['page_id'][$page_id];
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			if (isset($this->page_cache['supertag'][$supertag]))
			{
				if ($this->page_cache['supertag'][$supertag]['mdonly'] == 0 || $metadataonly == $this->page_cache['supertag'][$supertag]['mdonly'])
				{
					return $this->page_cache['supertag'][$supertag];
				}
			}
			else
			{
				return false;
			}
		}
	}

	function cache_page($page, $page_id = 0, $metadataonly = 0)
	{
		if ($page_id != 0)
		{
			$this->page_cache['page_id'][$page['page_id']]				= $page;
			$this->page_cache['page_id'][$page['page_id']]['mdonly']	= $metadataonly;
		}
		else
		{
			if (!$page['supertag'])
			{
				$page['supertag'] = $this->npj_translit($page['tag'], TRAN_LOWERCASE, TRAN_DONTLOAD);
			}

			$this->page_cache['supertag'][$page['supertag']]			= $page;
			$this->page_cache['supertag'][$page['supertag']]['mdonly']	= $metadataonly;
		}
	}

	function cache_wanted_page($tag, $page_id = 0, $check = 0)
	{
		if ($check == 0)
		{
			($page_id != 0
				? $this->wanted_cache['page_id'][$page_id] = 1
				: $this->wanted_cache['tag'][$this->language['code']][$tag] = 1
			);

		}
		else if ($this->old_load_page($tag, $page_id, '', 1, false, 1) == '')
		{
			($page_id != 0
				? $this->wanted_cache['page_id'][$page_id] = 1
				: $this->wanted_cache['tag'][$this->language['code']][$tag] = 1
			);
		}
	}

	function clear_cache_wanted_page($tag, $page_id = 0)
	{
		($page_id != 0
			? $this->wanted_cache['page_id'][$page_id] = 0
			: $this->wanted_cache['tag'][$this->language['code']][$tag] = 0
		);
	}

	function get_cached_wanted_page($tag, $page_id = 0)
	{
		if ($page_id != 0)
		{
			if (isset( $this->wanted_cache['page_id'][$page_id] ))
			{
				return $this->wanted_cache['page_id'][$page_id];
			}
			else
			{
				return '';
			}
		}
		else
		{
			if (isset( $this->wanted_cache['tag'][$this->language['code']][$tag] ))
			{
				return $this->wanted_cache['tag'][$this->language['code']][$tag];
			}
			else
			{
				return '';
			}
		}
	}

	function cache_links()
	{
		if ($links = $this->load_all(
			"SELECT * ".
			"FROM ".$this->config['table_prefix']."link ".
			"WHERE from_page_id = '".quote($this->dblink, $this->page['page_id'])."'"))
		{
			$cl = count($links);

			if (!isset($cl))
			{
				$cl = 0;
			}

			for ($i = 0; $i < $cl; $i++)
			{
				$pages[$i] = $links[$i]['to_tag'];
			}
		}

		$user		= $this->get_user();
		$user_bm	= $this->get_user_bookmarks($user['user_id']);

		if (!isset($cl))
		{
			$cl = 0;
		}

		$pages[$cl]	= $user['user_name'];
		$bookm		= $this->get_default_bookmarks($user['lang'])."\n".
					($user_bm
						? $user_bm
						: '');
		$bookmarks	= explode("\n", $bookm);

		for ($i = 0; $i <= count($bookmarks); $i++)
		{
			if (!isset($cl))
			{
				$cl = 0;
			}

			if (preg_match('/^[\(\[]/', (isset($bookmarks[$i])) ? ($bookmarks[$i]) : '' ))
			{
				$pages[$cl + $i] = preg_replace('/^(.*?)\s.*$/', '\\1', preg_replace('/[\[\]\(\)]/', '', $bookmarks[$i]));
			}
		}

		$pages[]	= $this->tag;
		$spages		= $pages;
		$spages_str	= '';
		$pages_str	= '';

		foreach ($pages as $page)
		{
			if ($page != '')
			{
				$spages_str	.= "'".quote($this->dblink, $this->npj_translit($page, TRAN_LOWERCASE, TRAN_DONTLOAD))."', ";
				$pages_str	.= "'".quote($this->dblink, $page)."', ";
			}
		}

		$spages_str	= substr($spages_str, 0, strlen($spages_str) - 2);
		$pages_str	= substr($pages_str, 0, strlen($pages_str) - 2);

		if ($links = $this->load_all(
		"SELECT ".$this->pages_meta." ".
		"FROM ".$this->config['table_prefix']."page ".
		"WHERE supertag IN (".$spages_str.")", 1))
		{
			for ($i = 0; $i < count($links); $i++)
			{
				$this->cache_page($links[$i], 0, 1);
				$exists[] = $links[$i]['supertag'];
			}
		}

		$notexists = @array_values(@array_diff($spages, $exists));

		if (!isset($acl))
		{
			$acl = '';
		}

		for ($i = 0; $i < count($notexists); $i++)
		{
			$this->cache_wanted_page($pages[array_search($notexists[$i], $spages)], 0, 1);
			$this->cache_acl($this->get_page_id($notexists[$i]), 'read', 1, $acl);
		}

		if ($read_acls = $this->load_all(
		"SELECT a.* FROM ".$this->config['table_prefix']."acl a ".
			"INNER JOIN ".$this->config['table_prefix']."page p ON (p.page_id = a.page_id) ".
		"WHERE BINARY p.tag IN (".$pages_str.") AND a.privilege = 'read'", 1))
		{
			for ($i = 0; $i < count($read_acls); $i++)
			{
				$this->cache_acl($read_acls[$i]['page_id'], 'read', 1, $read_acls[$i]);
			}
		}
	}

	function set_page($page)
	{
		$langlist	= $this->available_languages();
		$this->page	= $page;

		if ($this->page['tag'])
		{
			$this->tag = $this->page['tag'];
		}

		if ($page['lang'])
		{
			$this->page_lang = $page['lang'];
		}
		else if (isset($_REQUEST['add']) && isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], $langlist))
		{
			$this->page_lang = $_REQUEST['lang'];
		}
		else if (isset($_REQUEST['add']))
		{
			$this->page_lang = $this->user_lang;
		}
		else
		{
			$this->page_lang = $this->config['language'];
		}
	}

	// STANDARD QUERIES
	function load_revisions($page_id, $minor_edit = '')
	{
		$pages_meta = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.lang, p.title, u.user_name as user, o.user_name as reviewer ';

		$rev = $this->load_all(
			"SELECT p.revision_id AS revision_m_id, ".$pages_meta." ".
			"FROM ".$this->config['table_prefix']."revision p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
			"WHERE p.page_id = '".quote($this->dblink, $page_id)."' ".
				($minor_edit
					? "AND p.minor_edit = '0' "
					: "").
			"ORDER BY p.modified DESC");

		if ($rev == true)
		{
			if ($cur = $this->load_single(
				"SELECT p.page_id AS revision_m_id, ".$pages_meta." ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
				"WHERE p.page_id = '".quote($this->dblink, $page_id)."' ".
					($minor_edit
						? "AND p.minor_edit = '0' "
						: "").
				"ORDER BY p.modified DESC ".
				"LIMIT 1"))
			{
				array_unshift($rev, $cur);
			}
		}
		else
		{
			$rev = $this->load_all(
				"SELECT p.page_id AS revision_m_id, ".$pages_meta." ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
				"WHERE p.page_id = '".quote($this->dblink, $page_id)."' ".
				"ORDER BY p.modified DESC ".
				"LIMIT 1");
		}

		return $rev;
	}

	function load_pages_linking_to($tag, $for = '')
	{
		return $this->load_all(
			"SELECT p.page_id, p.tag AS tag, p.title ".
			"FROM ".$this->config['table_prefix']."link l ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (p.page_id = l.from_page_id) ".
			"WHERE ".($for
				? "p.tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
				"(l.to_supertag = '".quote($this->dblink, $this->npj_translit($tag))."')".
			" ORDER BY tag", 1);
	}

	function load_recently_changed($limit = 100, $for = '', $from = '', $minor_edit = '', $default_pages = false)
	{
		$limit = (int)$limit;

		// count pages
		$count_pages = $this->load_all(
			"SELECT p.page_id, u.user_name as user ".
			"FROM ".$this->config['table_prefix']."page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				($from
					? "AND p.modified <= '".quote($this->dblink, $from)." 23:59:59'"
					: "").
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
					: "").
				($minor_edit
					? "AND p.minor_edit = '0' "
					: "").
				($default_pages == false
					? "AND u.account_type = '0' "
					: "")
			);

		$count		= count($count_pages);
		$pagination = $this->pagination($count, $limit);

		if ($pages = $this->load_all(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.lang, p.title, u.user_name as user ".
		"FROM ".$this->config['table_prefix']."page p ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			($from
				? "AND p.modified <= '".quote($this->dblink, $from)." 23:59:59'"
				: "").
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
				: "").
			($minor_edit
				? "AND p.minor_edit = '0' "
				: "").
			($default_pages == false
				? "AND u.account_type = '0' "
				: "").
		"ORDER BY p.modified DESC ".
		"LIMIT {$pagination['offset']}, {$limit}", 1))
		{
			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if ($read_acls = $this->load_all(
			"SELECT a.* ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
					: '').
			"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT {$limit}", 1))
			{
				for ($i = 0; $i < count($read_acls); $i++)
				{
					$this->cache_acl($read_acls[$i]['page_id'], 'read', 1,$read_acls[$i]);
				}
			}
			return array($pages, $pagination);
		}
	}

	function load_recently_comment($limit = 100, $for = '')
	{
		$limit = (int) $limit;

		if ($pages = $this->load_all(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.latest, p.handler, p.comment_on_id, p.lang, p.title, p.body_r, u.user_name as user ".
		"FROM ".$this->config['table_prefix']."page p ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
		"WHERE p.comment_on_id != '0' ".
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
				: "").
		"ORDER BY p.modified DESC ".
		"LIMIT ".$limit))
		{
			#$count		= count($pages['page_id']);
			#$pagination = $this->pagination($count, $limit);

			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if ($read_acls = $this->load_all(
			"SELECT a.* ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
					($for
						? "AND p.supertag LIKE '".quote($this->dblink, $this->npj_translit($for))."/%' "
						: "").
			"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT {$limit}"))
			{
				for ($i = 0; $i < count($read_acls); $i++)
				{
					$this->cache_acl($read_acls[$i]['page_id'], 'read', 1, $read_acls[$i]);
				}
			}

			return $pages;
		}
	}

	function load_all_pages_by_time()
	{
		return $this->load_all(
			"SELECT page_id, tag, modified ".
			"FROM ".$this->config['table_prefix']."page ".
			"WHERE comment_on_id = '0' ".
			"ORDER BY modified DESC, BINARY tag");
	}

	function load_recently_deleted($limit = 1000, $cache = 1)
	{
		$meta = 'r.page_id, r.owner_id, r.user_id, r.tag, r.supertag, r.created, r.modified, r.edit_note, r.minor_edit, r.latest, r.handler, r.comment_on_id, r.lang, r.title, r.keywords, r.description';

		return $this->load_all(
			"SELECT DISTINCT $meta, MAX(r.modified) AS date ".
			"FROM {$this->config['table_prefix']}revision r ".
			"LEFT JOIN {$this->config['table_prefix']}page p ON ".
				"(r.tag = p.tag) ".
			"WHERE p.tag IS NULL ".
			"GROUP BY r.tag ".
			"ORDER BY date DESC, r.tag ASC ".
			( $limit > 0 ? "LIMIT $limit" : '' ), $cache);
	}

	// MAILER
	// $email_to			- recipient address
	// $subject, $message 	- self-explaining
	// $email_from			- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	// $xtra_headers		- (array) insert additional mail headers
	// $supress_tls			- don't change all http links to https links in the message body
	function send_mail($email_to, $subject, $body, $email_from = '', $charset = '', $xtra_headers = '', $supress_tls = false)
	{
		if (!$email_to || !$subject || !$body)
		{
			return;
		}

		if (empty($charset)) $charset = $this->get_charset();
		$name_to		= '';
		$email_from		= $this->config['admin_email'];
		$name_from		= $this->config['wacko_name'];

		// in tls mode substitute protocol name in links substrings
		if ($this->config['tls'] == true && $supress_tls === false)
		{
			$body = str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $body);
		}

		// use phpmailer class
		if ($this->config['phpmailer'] == true)
		{
			// $this->config['phpMailer_method']
			$this->use_class('email');
			$email = new email($this);
			$email->php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset, $xtra_headers);
		}
		else
		{
			// use mail() function
			$headers = 'From: =?'. $charset ."?B?". base64_encode($this->config['wacko_name']) ."?= <".$this->config['admin_email'].">\r\n";
			$headers .= "X-Mailer: PHP/".phpversion()."\r\n"; //mailer
			$headers .= "X-Priority: 3\r\n"; //1 UrgentMessage, 3 Normal
			$headers .= "X-Wacko: ".$this->config['base_url']."\r\n";
			$headers .= "Content-Type: text/plain; charset=".$charset."\r\n";
			$headers .= ( is_array($xtra_headers) ? implode("\n", $xtra_headers)."\n" : '' );	// additional headers
			$subject = ($subject ? "=?".$charset."?B?" . base64_encode($subject) . "?=" : '');

			$body = wordwrap($body, 74, "\n", 0);
			@mail($email_to, $subject, $body, $headers);
		}
	}

	// PAGE SAVING ROUTINE
	// $tag				- page address
	// $title			- page name (metadata)
	// $body			- page body (plain text)
	// $edit_note		- edit summary
	// $minor_edit		- minor edit
	// $comment_on_id	- commented page id
	// $lang			- page language
	// $mute			- supress email reminders and xml rss recompilation
	// $user			- attach guest pseudonym
	function save_page($tag, $title = '', $body, $edit_note = '', $minor_edit = 0, $reviewed = 0, $comment_on_id = 0, $lang = false, $mute = false, $user = false)
	{
		$desc = '';
		// user data
		$ip = $this->get_user_ip();

		if ($user === '')
		{
			$user = GUEST;
		}

		// current user is owner; if user is logged in! otherwise, no owner.
		if ($this->get_user_name())
		{
			$owner		= $user		= $this->get_user_name();
			$owner_id	= $user_id	= $this->get_user_id();
			$reg		= true;
		}
		else if ($this->forum === true || $comment_on_id)
		{
			$owner	= GUEST;
			$reg	= false;
		}
		else
		{
			$owner	= '';
			$reg	= false;
		}

		$page_id = $this->get_page_id($tag);

		/*
			ANTISPAM

			We load in the external antispam.conf file and then search the entire body content for each of the
			words defined as spam.  If we find any then we return from the function, not saving the changes.
		*/
		$this->spam = file('config/antispam.conf', 1);

		if ($this->config['spam_filter'] && is_array($this->spam))
		{
			foreach ($this->spam as $spam)
			{
				if (strpos($body, trim($spam))!== false)
				{
					return 'Error: Identified Potential Spam: '.$spam;
				}
			}
		}

		// write tag
		if(isset($_POST['tag']))
		{
			$this->tag		= $tag = $_POST['tag'];
			$this->supertag	= $this->npj_translit($tag);
		}

		if (!$this->npj_translit($tag))
		{
			return;
		}

		// cache handling
		if ($this->config['cache'])
		{
			if ($comment_on_id)
			{
				$this->cache->cache_invalidate($this->get_page_tag_by_id($comment_on_tag));
			}
			else
			{
				$this->cache->cache_invalidate($this->tag);
				$this->cache->cache_invalidate($this->supertag);
			}
		}

		// check privileges
		if ( ($this->page && $this->has_access('write', $page_id))
			|| (!$this->page && $this->has_access('create', $tag))
			|| ($comment_on_id && $this->has_access('comment', $comment_on_id)) )
		{
			// for forum topic prepare description
			if (!$comment_on_id)
			{
				$desc = $this->format(substr($body, 0, 500), 'cleanwacko');
				$desc = ( strlen($desc) > 240 ? substr($desc, 0, 240).'...' : $desc.' (-)' );
			}

			// preformatter (macros and such)
			$body = $this->format($body, 'pre_wacko');

			// making page body components
			$body_r = $this->format($body, 'wacko');

			if ($this->config['paragrafica'] && !$comment_on_id)
			{
				$body_r		= $this->format($body_r, 'paragrafica');
				$body_toc	= $this->body_toc;
			}

			// review
			if (isset($reviewed))
			{
				$reviewer_id	= $user_id;
			}

			// PAGE DOESN'T EXISTS, SAVING A NEW PAGE
			if (!$old_page = $this->load_page($tag))
			{
				if (!isset($lang))
				{
					$langlist = $this->available_languages();

					if ($_REQUEST['lang'] && in_array($_REQUEST['lang'], $langlist))
					{
						$lang = $_REQUEST['lang'];
					}
					else
					{
						$lang = $this->user_lang;
					}
				}

				if (!$lang)
				{
					$lang = $this->config['language'];
				}

				$this->set_language($lang);

				// getting title
				if ($title == '')
				{
					if ($comment_on_id == true)
					{
						$title = $this->get_translation('Comment').' '.substr($tag, 7);
					}
					else
					{
						$title = $this->get_page_title($tag);
					}
				}

				// create appropriate acls
				if (strstr($this->context[$this->current_context], '/') && !$comment_on_id)
				{
					$root			= preg_replace( '/^(.*)\\/([^\\/]+)$/', '$1', $this->context[$this->current_context] );
					$root_id		= $this->get_page_id($root);
					$write_acl		= $this->load_acl($this->get_page_id($root), 'write');

					while ($write_acl['default'] == 1)
					{
						$_root		= $root;
						$root		= preg_replace( '/^(.*)\\/([^\\/]+)$/', '$1', $root );

						if ($root == $_root)
						{
							break;
						}

						$root_id	= $this->get_page_id($root); // do we need this?
						$write_acl	= $this->load_acl($root_id, 'write');
					}

					$write_acl		= $write_acl['list'];
					$read_acl		= $this->load_acl($root_id, 'read');
					$read_acl		= $read_acl['list'];
					$comment_acl	= $this->load_acl($root_id, 'comment');
					$comment_acl	= $comment_acl['list'];
					$create_acl		= $this->load_acl($root_id, 'create');
					$create_acl		= $create_acl['list'];
					$upload_acl		= $this->load_acl($root_id, 'upload');
					$upload_acl		= $upload_acl['list'];
				}
				else if ($comment_on_id)
				{
					// Give comments the same rights as their parent page
					$read_acl		= $this->load_acl($comment_on_id, 'read');
					$read_acl		= $read_acl['list'];
					$write_acl		= $this->load_acl($comment_on_id, 'write');
					$write_acl		= $write_acl['list'];
					$comment_acl	= $this->load_acl($comment_on_id, 'comment');
					$comment_acl	= $comment_acl['list'];
				}
				else
				{
					$read_acl		= $this->config['default_read_acl'];
					$write_acl		= $this->config['default_write_acl'];
					$comment_acl	= $this->config['default_comment_acl'];
					$create_acl		= $this->config['default_create_acl'];
					$upload_acl		= $this->config['default_upload_acl'];
				}

				$this->query(
					"INSERT INTO ".$this->config['table_prefix']."page SET ".
						"comment_on_id 	= '".quote($this->dblink, $comment_on_id)."', ".
						(!$comment_on_id ? "description = '".quote($this->dblink, $desc)."', " : "").
						"created		= NOW(), ".
						"modified		= NOW(), ".
						"commented		= NOW(), ".
						"owner_id		= '".quote($this->dblink, $owner_id)."', ".
						"user_id		= '".quote($this->dblink, $user_id)."', ".
						"ip				= '".quote($this->dblink, $ip)."', ".
						"latest			= '1', ".
						"tag			= '".quote($this->dblink, $tag)."', ".
						"supertag		= '".quote($this->dblink, $this->npj_translit($tag))."', ".
						"body			= '".quote($this->dblink, $body)."', ".
						"body_r			= '".quote($this->dblink, $body_r)."', ".
						"body_toc		= '".quote($this->dblink, $body_toc)."', ".
						"edit_note		= '".quote($this->dblink, $edit_note)."', ".
						"minor_edit		= '".quote($this->dblink, $minor_edit)."', ".
						(isset($reviewed)
							?	"reviewed		= '".quote($this->dblink, $reviewed)."', ".
								"reviewed_time	= NOW(), ".
								"reviewer_id	= '".quote($this->dblink, $reviewer_id)."', "
							:	"").
						"lang			= '".quote($this->dblink, $lang)."', ".

						"title			= '".quote($this->dblink, htmlspecialchars($title))."'");

				// IMPORTANT! lookup newly created page_id
				$page_id = $this->get_page_id($tag);

				// saving acls
				$this->save_acl($page_id, 'write', $write_acl);
				$this->save_acl($page_id, 'read', $read_acl);
				$this->save_acl($page_id, 'comment', $comment_acl);
				$this->save_acl($page_id, 'create', $create_acl);
				$this->save_acl($page_id, 'upload', $upload_acl);

				// counters
				if ($comment_on_id)
				{
					// updating comments count for commented page
					$this->query(
						"UPDATE {$this->config['table_prefix']}page SET ".
							"comments	= '".(int)$this->count_comments($comment_on_id)."', ".
							"commented	= NOW() ".
						"WHERE page_id = '".quote($this->dblink, $comment_on_id)."' ".
						"LIMIT 1");

					// update user comments count
					$this->query(
						"UPDATE {$this->config['user_table']} ".
						"SET total_comments = total_comments + 1 ".
						"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
						"LIMIT 1");
				}
				else
				{
					// update user pages count
					$this->query(
						"UPDATE {$this->config['user_table']} ".
						"SET total_pages = total_pages + 1 ".
						"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
						"LIMIT 1");
				}

				// set watch
				if (!$this->config['disable_autosubscribe'] && !$comment_on_id)
				{
					// subscribe the author
					if ($reg === true)
					{
						$this->set_watch($user_id, $page_id);
					}
				}

				if ($comment_on_id)
				{
					// notifying watchers
					$user_name	= $user;
					$title		= $this->get_page_title(0, $comment_on_id);
					$watchers	= $this->load_all(
									"SELECT DISTINCT w.user_id, u.user_name ".
									"FROM ".$this->config['table_prefix']."watch w ".
										"LEFT JOIN ".$this->config['table_prefix']."user u ON (w.user_id = u.user_id) ".
									"WHERE w.page_id = '".quote($this->dblink, $comment_on_id)."'");

					if ($watchers && !$mute)
					{
						foreach ($watchers as $watcher)
						{
							if ($watcher['user_id'] != $user_id && $watcher['user'] != GUEST)
							{
								// assert that user has no comments pending...
								$pending = $this->load_single(
									"SELECT comment_id ".
									"FROM {$this->config['table_prefix']}watch ".
									"WHERE page_id = '".quote($this->dblink, $comment_on_id)."' ".
										"AND user_id = '".quote($this->dblink, $watcher['user_id'])."' ".
									"LIMIT 1");

								// ...and add one if so
								if ($pending['comment_id'] == false)
								{
									$this->query(
										"UPDATE {$this->config['table_prefix']}watch ".
										"SET comment_id = '".quote($this->dblink, $page_id)."' ".
										"WHERE page_id = '".quote($this->dblink, $comment_on_id)."' ".
											"AND user_id = '".quote($this->dblink, $watcher['user_id'])."'");
								}
								else
								{
									continue;	// skip current watcher
								}

								if ($this->has_access('read', $comment_on_id, $watcher['user_name']))
								{
									$_user = $this->load_single(
										"SELECT u.email, p.lang, u.email_confirm, u.enabled, p.send_watchmail ".
										"FROM " .$this->config['user_table']." u ".
											"LEFT JOIN ".$this->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
										"WHERE u.user_id = '".quote($this->dblink, $watcher['user_id'])."'");

									if ($_user['enabled'] == true && $_user['email_confirm'] == '' && $_user['send_watchmail'] != 0)
									{
										$lang = $_user['lang'];
										$this->load_translation($lang);
										$this->set_translation ($lang);
										$this->set_language ($lang);

										$subject = '['.$this->config['wacko_name'].'] '.$this->get_translation('CommentForWatchedPage', $lang)."'".$title."'";
										$body = $this->get_translation('EmailHello', $lang). $watcher['user_name'].".\n\n".
													$user_name.
													$this->get_translation('SomeoneCommented', $lang)."\n".
													$this->href('', $this->get_page_tag_by_id($comment_on_id), '')."\n\n".
													"----------------------------------------------------------------------\n\n".
													$this->format($body_r, 'post_wacko')."\n\n".
													"----------------------------------------------------------------------\n\n".
													$this->get_translation('EmailGoodbye', $lang)."\n".
													$this->config['wacko_name']."\n".
													$this->config['base_url'];

										$this->send_mail($_user['email'], $subject, $body);
									}
								}
								else
								{
									$this->clear_watch($watcher['user_id'], $comment_on_id);
								} // end of has_access
							}
						}// end of watchers
					}
					$this->load_translation($this->user_lang);
					$this->set_translation($this->user_lang);
					$this->set_language($this->user_lang);
				} // end of comment_on
			} // end of new page
			// RESAVING AN OLD PAGE, CREATING REVISION
			else
			{
				$this->set_language($this->page_lang);

				// aha! page isn't new. keep owner!
				$owner_id = $old_page['owner_id'];

				// only if page has been actually changed
				if ($old_page['body'] != $body || $old_page['title'] != $title)
				{
					// Dont save revisions for comments.  Personally I think we should.
					if (!$old_page['comment_on_id'])
					{
						$this->save_revision($old_page);
					}

					// update current page copy
					$this->query(
						"UPDATE ".$this->config['table_prefix']."page SET ".
							"comment_on_id	= '".quote($this->dblink, $comment_on_id)."', ".
							"modified		= NOW(), ".
							"created		= '".quote($this->dblink, $old_page['created'])."', ".
							"owner_id		= '".quote($this->dblink, $owner_id)."', ".
							"user_id		= '".quote($this->dblink, $user_id)."', ".
							"description	= '".quote($this->dblink, ($old_page['comment_on_id'] || $old_page['description'] ? $old_page['description'] : $desc ))."', ".
							"supertag		= '".$this->npj_translit($tag)."', ".
							"body			= '".quote($this->dblink, $body)."', ".
							"body_r			= '".quote($this->dblink, $body_r)."', ".
							"body_toc		= '".quote($this->dblink, $body_toc)."', ".
							"edit_note		= '".quote($this->dblink, $edit_note)."', ".
							"minor_edit		= '".quote($this->dblink, $minor_edit)."', ".
							(isset($reviewed)
								?	"reviewed		= '".quote($this->dblink, $reviewed)."', ".
									"reviewed_time	= NOW(), ".
									"reviewer_id	= '".quote($this->dblink, $reviewer_id)."', "
								:	"").
							"title			= '".quote($this->dblink, htmlspecialchars($title))."' ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"LIMIT 1");
				}

				// Since there's no revision history for comments it's pointless to do the following for them.
				if (!$comment_on_id)
				{
					// revisions diff
					$page = $this->load_single(
						"SELECT ".$this->pages_meta." ".
						"FROM ".$this->config['table_prefix']."revision ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"ORDER BY modified DESC");
					$_GET['a'] = -1;
					$_GET['b'] = $page['page_id'];
					$_GET['fastdiff'] = 1;
					$diff = $this->include_buffered('handlers/page/diff.php', 'oops', array('source' => 1));

					// notifying watchers
					$title		= $this->get_page_title(0, $page_id);
					$user_name	= $user;

					$watchers	= $this->load_all(
						"SELECT DISTINCT w.user_id, u.user_name ".
						"FROM ".$this->config['table_prefix']."watch w ".
							"LEFT JOIN ".$this->config['table_prefix']."user u ON (w.user_id = u.user_id) ".
						"WHERE w.page_id = '".quote($this->dblink, $page_id)."'");

					if ($watchers && !$mute)
					{
						foreach ($watchers as $watcher)
						{
							if ($watcher['user_id'] !=  $user_id)
							{
								if ($this->has_access('read', $page_id, $watcher['user_name']))
								{
									$_user = $this->load_single(
										"SELECT u.email, p.lang, u.email_confirm, u.enabled, p.send_watchmail ".
										"FROM " .$this->config['user_table']." u ".
											"LEFT JOIN ".$this->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
										"WHERE u.user_id = '".quote($this->dblink, $watcher['user_id'])."'");

									if ($_user['enabled'] == true && $_user['email_confirm'] == '' && $_user['send_watchmail'] != 0)
									{
										$lang = $_user['lang'];
										$this->load_translation($lang);
										$this->set_translation ($lang);
										$this->set_language ($lang);

										$subject = '['.$this->config['wacko_name'].'] '.$this->get_translation('WatchedPageChanged', $lang)."'".$tag."'";
										$body = $this->get_translation('EmailHello', $lang). $watcher['user_name']."\n\n".
											$user_name.
											$this->get_translation('SomeoneChangedThisPage', $lang)."\n".
											$title."\n".
											$this->href('', $tag)."\n\n".
											"======================================================================".
											$this->format($diff, 'html2mail').
											"\n======================================================================\n\n".
											$this->get_translation('EmailGoodbye', $lang)."\n".
											$this->config['wacko_name']."\n".
											$this->config['base_url'];

										$this->send_mail($_user['email'], $subject, $body);
									}
								} // end of has_access()
							} // end of watchers
						}
						$this->load_translation($this->user_lang);
						$this->set_translation ($this->user_lang);
						$this->set_language ($this->user_lang);
					}
				} // end of new != old
			} // end of existing page
		}

		// writing xmls
		if ($mute === false)
		{
			if (!isset($old_page['comment_on_id']) || !$comment_on_id)
			{
				$this->use_class('rss');
				$xml = new rss($this);
				$xml->changes();
				$xml->comments();

				if ($this->config['news_cluster'])
				{
					if (substr($this->tag, 0, strlen($this->config['news_cluster'].'/')) == $this->config['news_cluster'].'/')
					{
						$xml->news();
					}
				}

				if($this->config['xml_sitemap'])
				{
					$xml->site_map();
				}

				unset($xml);
			}
		}

		return $body_r;
	}

	// create revision of a given page
	function save_revision($old_page)
	{
		if (!$old_page)
		{
			return false;
		}

		// prepare input
		foreach ($old_page as $key => $val)
		{
			$old_page[$key] = quote($this->dblink, $old_page[$key]);
		}

		// move revision
		$this->query(
			"INSERT INTO {$this->config['table_prefix']}revision SET ".
				"page_id		= '{$old_page['page_id']}', ".
				"tag			= '{$old_page['tag']}', ".
				"modified		= '{$old_page['modified']}', ".
				"body			= '{$old_page['body']}', ".
				"formatting		= '{$old_page['formatting']}', ".
				"edit_note		= '{$old_page['edit_note']}', ".
				"minor_edit		= '{$old_page['minor_edit']}', ".
				"reviewed		= '{$old_page['reviewed']}', ".
				"reviewed_time	= '{$old_page['reviewed_time']}', ".
				"reviewer_id	= '{$old_page['reviewer_id']}', ".
				"ip				= '{$old_page['ip']}', ".
				"owner_id		= '{$old_page['owner_id']}', ".
				"user_id		= '{$old_page['user_id']}', ".
				"latest			= '0', ".
				"handler		= '{$old_page['handler']}', ".
				"comment_on_id	= '{$old_page['comment_on_id']}', ".
				"supertag		= '{$old_page['supertag']}', ".
				"title			= '{$old_page['title']}', ".
				"keywords		= '{$old_page['keywords']}', ".
				"description	= '{$old_page['description']}'");

		// update user statistics for revisions made
		if ($user = $this->get_user())
		{
			$this->query(
				"UPDATE {$this->config['user_table']} ".
				"SET total_revisions = total_revisions + 1 ".
				"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
				"LIMIT 1");
		}
	}

	// COOKIES
	function set_session_cookie($name, $value, $dummy = null, $secure = 0, $httponly = 1)
	{
		setcookie($this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash'], $value, 0, $this->config['cookie_path'], '', ( $secure ? true : false ), ( $httponly ? true : false ));
		$_COOKIE[$this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash']] = $value;
	}

	function set_persistent_cookie($name, $value, $days = 0, $secure = 0, $httponly = 1)
	{
		// set to default if no pediod given
		if ($days == 0)
		{
			$days = $this->config['session_expiration'];
		}

		setcookie($this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash'], $value, time() + $days * 24 * 3600, $this->config['cookie_path'], '', ( $secure ? true : false ), ( $httponly ? true : false ));
		$_COOKIE[$this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash']] = $value;
	}

	function delete_cookie($name, $prefix = true, $postfix = false)
	{
		($prefix == true
			? $prefix	= $this->config['cookie_prefix']
			: $prefix	= ''
		);

		($postfix == true
			? $cookie_hash	= '_'.$this->config['cookie_hash']
			: $cookie_hash	= ''
		);

		$cookie_path	= $this->config['cookie_path'];

		setcookie($prefix.$name.$cookie_hash, '', 1, $cookie_path, '');
		$_COOKIE[$prefix.$name.$cookie_hash] = '';
	}

	function get_cookie($name)
	{
		if (isset($_COOKIE[$this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash']]))
		{
			return $_COOKIE[$this->config['cookie_prefix'].$name.'_'.$this->config['cookie_hash']];
		}
	}

	// HTTP/REQUEST/LINK RELATED
	function set_message($message)
	{
		$_SESSION[$this->config['session_prefix'].'_'.'message'] = $message;
	}

	function get_message()
	{
		if (isset($_SESSION[$this->config['session_prefix'].'_'.'message']))
		{
			$message = $_SESSION[$this->config['session_prefix'].'_'.'message'];
			$_SESSION[$this->config['session_prefix'].'_'.'message'] = '';
			return $message;
		}
		else
		{
			return null;
		}
	}

	function redirect($url, $permanent = false)
	{
		if ( !headers_sent() )
		{
			if($permanent)
			{
				header('HTTP/1.1 301 Moved Permanently');
			}
			header("Location: $url");
			exit();
		}
	}

	// Set security headers (frame busting, clickjacking/XSS/CSRF protection)
	function http_security_headers()
	{
		if ( !headers_sent() )
		{
			#	if (isset($this->config['xframeoptions']))
			header( 'X-Frame-Options: DENY' ); // or SAMEORIGIN
			header( "X-Content-Security-Policy: allow 'self'; script-src 'self'; options inline-script; img-src *;" );
		}
	}

	function no_cache()
	{
		if ( !headers_sent() )
		{
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');				// Date in the past
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');		// always modified
			header('Cache-Control: no-store, no-cache, must-revalidate');	// HTTP 1.1
			header('Cache-Control: post-check=0, pre-check=0', false);
			header('Pragma: no-cache');										// HTTP 1.0
		}
	}

	function unwrap_link($tag)
	{
		if ($tag == '/')
		{
			return '';
		}
		if ($tag == '!')
		{
			return $this->context[$this->current_context];
		}

		$new_tag = $tag;

		if (isset($this->context[$this->current_context]) && strstr($this->context[$this->current_context], '/'))
		{
			$root	= preg_replace('/^(.*)\\/([^\\/]+)$/', '$1', $this->context[$this->current_context]);
		}
		else
		{
			$root	= '';
		}

		if (preg_match('/^\.\/(.*)$/', $tag, $matches))
		{
			$root	= '';
		}
		else if (preg_match('/^\/(.*)$/', $tag, $matches))
		{
			$root	= '';
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\!\/(.*)$/', $tag, $matches))
		{
			$root	= $this->context[$this->current_context];
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\.\.\/(.*)$/', $tag, $matches))
		{
			$new_tag	= $matches[1];

			if (strstr($root, '/'))
			{
				$root	= preg_replace('/^(.*)\\/([^\\/]+)$/', '$1', $root);
			}
			else
			{
				$root	= '';
			}
		}

		if ($root != '')
		{
			$new_tag = '/'.$new_tag;
		}

		$tag = $root.$new_tag;
		$tag = str_replace('//', '/', $tag);

		return $tag;
	}

	// returns just PageName[/method].
	function mini_href($method = '', $tag = '', $addpage = 0)
	{
		if (!$tag = trim($tag))
		{
			$tag = $this->tag;
		}
		if (!$addpage)
		{
			$tag = $this->slim_url($tag);
		}
		// if (!$addpage)		$tag = $this->npj_translit($tag);

		$tag = trim($tag, '/.');
		// $tag = str_replace(array('%2F', '%3F', '%3D'), array('/', '?', '='), rawurlencode($tag));

		return $tag.($method ? '/'.$method : '');
	}

	// returns the full url to a page/method.
	function href($method = '', $tag = '', $params = '', $addpage = 0)
	{
		$href = $this->config['base_url'].( $this->config['rewrite_mode'] ? '' : '?page=' ).$this->mini_href($method, $tag, $addpage);

		if ($addpage)
		{
			$params = 'add=1'.($params ? '&amp;'.$params : '');
		}
		if ($params)
		{
			$href .= ($this->config['rewrite_mode'] ? '?' : '&amp;').$params;
		}

		return $href;
	}

	function slim_url($text)
	{
		# $text = $this->npj_translit($text, TRAN_DONTCHANGE);
		$text = str_replace('_', "'", $text);

		if ($this->config['urls_underscores'] == 1)
		{
			$text = preg_replace('/('.$this->language['ALPHANUM'].')('.$this->language['UPPERNUM'].')/', '\\1¶\\2', $text);
			$text = preg_replace('/('.$this->language['UPPERNUM'].')('.$this->language['UPPERNUM'].')/', '\\1¶\\2', $text);
			$text = preg_replace('/('.$this->language['UPPER'].')¶(?='.$this->language['UPPER'].'¶'.$this->language['UPPERNUM'].')/', '\\1', $text);
			$text = preg_replace('/('.$this->language['UPPER'].')¶(?='.$this->language['UPPER'].'¶\/)/', '\\1', $text);
			$text = preg_replace('/('.$this->language['UPPERNUM'].')¶('.$this->language['UPPERNUM'].')($|\b)/', '\\1\\2', $text);
			$text = preg_replace('/\/¶('.$this->language['UPPERNUM'].')/', '/\\1', $text);
			$text = str_replace('¶', '_', $text);
		}
		return $text;
	}

	function compose_link_to_page($tag, $method = '', $text = '', $track = 1, $title = '')
	{
		if (!$text)
		{
			$text = $this->add_spaces($tag);
		}
		//$text = htmlentities($text);
		if (isset($_SESSION[$this->config['session_prefix'].'_'.'linktracking']) && $track)
		{
			$this->track_link_to($tag);
		}

		return '<a href="'.$this->href($method, $tag).'"'.($title ? ' title="'.$title.'"' : '').'>'.$text.'</a>';
	}

	function pre_link($tag, $text = '', $track = 1, $imgurl = 0)
	{
		// if (!$text) $text = $this->add_spaces($tag);

		if (preg_match('/^[\!\.'.$this->language['ALPHANUM_P'].']+$/', $tag))
		{
			if (isset($_SESSION[$this->config['session_prefix'].'_'.'linktracking']) && $track)
			{
				// it's a Wiki link!
				$this->track_link_to($this->unwrap_link( $tag ));
			}
		}
		if ($imgurl == 1)
		{
			return '<!--imglink:begin-->'.str_replace(' ', '+', urldecode($tag)).' =='.$text.'<!--imglink:end-->';
		}
		else
		{
			return '<!--link:begin-->'.str_replace(' ', '+', urldecode($tag))." ==".($this->format_safe ? str_replace('>', "&gt;", str_replace('<', "&lt;", $text)) : $text).'<!--link:end-->';
		}
	}

	function link($tag, $method = '', $text = '', $title = '', $track = 1, $safe = 0, $linklang = '', $anchorlink = 1)
	{
		$class	= '';
		$icon	= '';
		$lang	= '';
		$desc	= '';
		$url	= '';
		$imlink	= false;
		$text	= str_replace('"', '&quot;', $text);

		if (!$safe)
		{
			$text = htmlspecialchars($text, ENT_NOQUOTES);
		}

		if ($linklang)
		{
			$this->set_language($linklang);
		}

		if (preg_match('/^[\.\-'.$this->language['ALPHANUM_P'].']+\.(gif|jpg|jpe|jpeg|png)$/i', $text))
		{
			$imlink = $this->config['base_url'].'/images/'.$text;
		}
		else if (preg_match('/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i', preg_replace('/<\/?nobr>/', '', $text)))
		{
			$imlink = $text = preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/', '', $text);
		}

		if (preg_match('/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid Email
			$url	= (isset($matches[1]) && $matches[1] == 'mailto:' ? $tag : 'mailto:'.$tag);
			$title	= $this->get_translation('EmailLink');
			$icon	= $this->get_translation('emailicon');
			$tpl	= 'email';
		}
		else if (preg_match('/^(xmpp[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid XMPP address
			$url	= (isset($matches[1]) && $matches[1] == 'xmpp:' ? $tag : 'xmpp:'.$tag);
			$title	= $this->get_translation('JabberLink');
			$icon	= $this->get_translation('jabbericon');
			$tpl	= 'jabber';
		}
		else if (preg_match('/^#/', $tag))
		{
			// html-anchor
			$url	= $tag;
			$tpl	= 'anchor';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i', $tag))
		{
			// external image
			$text	= preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/', '', $text);

			if ($text == $tag)
			{
				return '<img src="'.str_replace('&', '&amp;', str_replace('&amp;', '&', $tag)).'" '.($text ? 'alt="'.$text.'" title="'.$text.'"' : '').' />';
			}
			else
			{
				$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
				$title	= $this->get_translation('OuterLink2');
				$icon	= $this->get_translation('outericon');
				$tpl	= 'outerlink';
			}
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rpm|gz|tgz|zip|rar|exe|doc|xls|ppt|tgz|bz2|7z)$/', $tag))
		{
			// this is a file link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('FileLink');
			$icon	= $this->get_translation('fileicon');
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/', $tag))
		{
			// this is a PDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('PDFLink');
			$icon	= $this->get_translation('pdficon');
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/', $tag))
		{
			// this is a RDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('RDFLink');
			$icon	= $this->get_translation('rdficon');
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/', $tag))
		{
			// this is a valid external URL
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$tpl	= 'outerlink';

			if (!stristr($tag, $this->config['base_url']))
			{
				$title	= $this->get_translation('OuterLink2');
				$icon	= $this->get_translation('outericon');
			}
		}
		else if (preg_match('/^(_?)file:([^\\s\"<>\(\)]+)$/', $tag, $matches))
		{
			// this is a file:
			$noimg	= $matches[1];
			$thing	= $matches[2];
			$arr	= explode('/', $thing);

			if (count($arr) == 1) // file:some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->check_file_exists($thing);

				if (is_array($desc))
				{
					$title	= $desc['description'].' ('.$this->binary_multiples($desc['file_size'], true, true, true).')';
					$alt	= $desc['description'];
					$url	= $this->config['base_url'].$this->config['upload_path'].'/'.$thing;

					if ($desc['file_ext'] == 'pdf')
					{
						$icon	= $this->get_translation('pdficon');
					}
					else if ($desc['file_ext'] == 'txt')
					{
						$icon	= $this->get_translation('texticon');
					}
					else if ($desc['file_ext'] == ('png' || 'jpg' || 'gif'))
					{
						$icon	= $this->get_translation('imageicon');
					}
					else
					{
						$icon	= $this->get_translation('fileicon');
					}

					$imlink	= false;
					$tpl	= 'localfile';

					if ($desc['picture_w'] && !$noimg)
					{
						if (!$text)
						{
							$text = $title;
						}
						return '<img src="'.$this->config['base_url'].$this->config['upload_path'].'/'.$thing.'" '.($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').' width="'.$desc['picture_w'].'" height="'.$desc['picture_h'].'" />';
					}
				}
				unset($desc);
			}

			if (count($arr) == 2 && $arr[0] == '')	// file:/some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->check_file_exists($arr[1]);

				if (is_array($desc))
				{
					$title	= $desc['description'].' ('.$this->binary_multiples($desc['file_size'], true, true, true).')';
					$alt	= $desc['description'];
					$url	= $this->config['base_url'].$this->config['upload_path'].$thing;

					if ($desc['file_ext'] == 'pdf')
					{
						$icon	= $this->get_translation('pdficon');
					}
					else if ($desc['file_ext'] == 'txt')
					{
						$icon	= $this->get_translation('texticon');
					}
					else if ($desc['file_ext'] == ('png' || 'jpg' || 'gif'))
					{
						$icon	= $this->get_translation('imageicon');
					}
					else
					{
						$icon	= $this->get_translation('fileicon');
					}

					$imlink	= false;
					$tpl	= 'localfile';

					if ($desc['picture_w'] && !$noimg)
					{
						if (!$text)
						{
							$text = $title;
						}
						return '<img src="'.$this->config['base_url'].$this->config['upload_path'].'/'.$thing.'" '.($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').' width="'.$desc['picture_w'].'" height="'.$desc['picture_h'].'" />';
					}
				}
				else	//404
				{
					$tpl	= 'wlocalfile';
					$title	= '404: /'.$this->config['upload_path'].$thing;
					$url	= '404';
				}
				unset($desc);
			}

			if (!$url)
			{
				$file		= $arr[count($arr) - 1];
				unset($arr[count($arr) - 1]);
				$_pagetag	= implode('/', $arr);

				if ($_pagetag == '')
				{
					$_pagetag = '!/';
				}

				//unwrap tag (check !/, ../ cases)
				$pagetag	= rtrim($this->npj_translit($this->unwrap_link($_pagetag)), './');
				$page_id	= $this->get_page_id($pagetag);

				//try to find in local $tag storage
				$desc		= $this->check_file_exists($file, $pagetag);

				if (is_array($desc))
				{
					//check 403 here!
					if ($this->is_admin() || (
					$desc['upload_id'] && (
					$this->page['owner_id'] == $this->get_user_id())) || (
					$this->has_access('read', $page_id)) || (
					$desc['user_id'] == $this->get_user_id()))
					{
						$title	= $desc['description'].' ('.$this->binary_multiples($desc['file_size'], true, true, true).')';
						$alt	= $desc['description'];
						$url	= $this->href('files', trim($pagetag, '/')).($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file;
						$imlink	= false;

						if ($desc['file_ext'] == 'pdf')
						{
							$icon	= $this->get_translation('pdficon');
						}
						else if ($desc['file_ext'] == 'txt')
						{
							$icon	= $this->get_translation('texticon');
						}
						else if ($desc['file_ext'] == ('png' || 'jpg' || 'gif'))
						{
							$icon	= $this->get_translation('imageicon');
						}
						else
						{
							$icon	= $this->get_translation('fileicon');
						}

						$tpl	= 'localfile';

						if ($desc['picture_w'] != 0 && !$noimg)
						{
							if (!$text)
							{
								$text = $title;
								return '<img src="'.$this->href('files', trim($pagetag, '/')).($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file.'" '.($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').' width="'.$desc['picture_w'].'" height="'.$desc['picture_h'].'" />';
							}
							else
							{
								return '<a href="'.$this->href('files', trim($pagetag, '/')).($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file.'" title="'.$title.'">'.$text.'</a>';
							}
						}
						# $this->debug_print_r($desc);
					}
					else //403
					{
						$url	= $this->href('files', trim($pagetag, '/')).($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file;
						$icon	= $this->get_translation('lockicon');
						$imlink	= false;
						$tpl	= 'localfile';
						$class	= 'denied';
					}
				}
				else //404
				{
					$title	= '404: /'.trim($pagetag, '/').'/files'.($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file;
					$url	= '404';
					$tpl	= 'wlocalfile';
				}
				unset($desc);
			}
			//forgot 'bout 403
		}
		else if ($this->config['disable_tikilinks'] != 1 && preg_match('/^('.$this->language['UPPER'].$this->language['LOWER'].$this->language['ALPHANUM'].'*)\.('.$this->language['ALPHA'].$this->language['ALPHANUM'].'+)$/s', $tag, $matches))
		{
			// it`s a Tiki link!
			$tag	= '/'.$matches[1].'/'.$matches[2];

			if (!$text)
			{
				$text = $this->add_spaces($tag);
			}

			return $this->link( $tag, $method, $text, $title, $track, 1);
		}
		else if (preg_match('/^([[:alnum:]]+)[:](['.$this->language['ALPHANUM_P'].'\-\_\.\+\&\=\#]*)$/', $tag, $matches))
		{
			// interwiki
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', urlencode($parts[$i]));
			}

			if ($linklang)
			{
				$text	= $this->do_unicode_entities($text, $linklang);
			}

			$url	= $this->get_inter_wiki_url($matches[1], implode('/', $parts));
			$icon	= $this->get_translation('iwicon');
			$tpl	= 'interwiki';
		}
		else if (preg_match('/^([\!\.\-'.$this->language['ALPHANUM_P'].']+)(\#['.$this->language['ALPHANUM_P'].'\_\-]+)?$/', $tag, $matches))
		{
			// it's a Wiki link!
			$tag	= $otag		= $matches[1];
			$untag	= $unwtag	= $this->unwrap_link($tag);

			$regex_handlers	= '/^(.*?)\/('.$this->config['standard_handlers'].')\/(.*)$/i';
			$ptag			= $this->npj_translit($unwtag);
			$handler		= null;

			if (preg_match( $regex_handlers, '/'.$ptag.'/', $match ))
			{
				$handler	= $match[2];

				if (!isset($_ptag))
				{
					$_ptag = '';
				}

				$ptag		= $match[1];
				$unwtag		= '/'.$unwtag.'/';
				$co			= substr_count($_ptag, '/') - substr_count($ptag, '/');

				for ($i = 0; $i < $co; $i++)
				{
					$unwtag	= substr($unwtag, 0, strrpos($unwtag, '/'));
				}

				if ($handler)
				{
					if (!isset($data))
					{
						$data = '';
					}

					$opar	= '/'.$untag.'/';

					for ($i = 0; $i < substr_count($data, '/') + 2; $i++)
					{
						$opar = substr($opar, strpos($opar, '/') + 1);
					}

					$params = explode('/', $opar); //there're good params
				}
			}

			$unwtag			= trim($unwtag, '/.');
			$unwtag			= str_replace('_', '', $unwtag);

			if ($handler)
			{
				$method		= $handler;
			}

			$thispage		= $this->load_page($unwtag, 0, '', LOAD_CACHE, LOAD_META);

			if (!$thispage && $linklang)
			{
				$this->set_language($linklang);
				$lang		= $linklang;
				$thispage	= $this->load_page($unwtag, 0, '', LOAD_CACHE, LOAD_META);
			}

			if ($thispage)
			{
				$_lang		= $this->language['code'];

				if ($thispage['lang'])
				{
					$lang	= $thispage['lang'];
				}
				else
				{
					$lang	= $this->config['language'];
				}

				$this->set_language($lang);
				$supertag	= $this->npj_translit($untag);
			}
			else
			{
				$supertag	= $this->npj_translit($untag, TRAN_LOWERCASE, TRAN_DONTLOAD);
			}

			$aname = '';

			if (substr($tag, 0, 2) == '!/')
			{
				$icon		= $this->get_translation('childicon');
				$page0		= substr($tag, 2);
				$page		= $this->add_spaces($page0);
				$tpl		= 'childpage';
			}
			else if (substr($tag, 0, 3) == '../')
			{
				$icon		= $this->get_translation('parenticon');
				$page0		= substr($tag, 3);
				$page		= $this->add_spaces($page0);
				$tpl		= 'parentpage';
			}
			else if (substr($tag, 0, 1) == '/')
			{
				$icon		= $this->get_translation('rooticon');
				$page0		= substr($tag, 1);
				$page		= $this->add_spaces($page0);
				$tpl		= 'rootpage';
			}
			else
			{
				$icon		= $this->get_translation('equalicon');
				$page0		= $tag;
				$page		= $this->add_spaces($page0);
				$tpl		= 'equalpage';
			}

			if ($imlink)
			{
				$text		= '<img src="'.$imlink.'" border="0" title="'.$text.'" />';
			}

			if ($text)
			{
				$tpl		= 'descrpage';
				$icon		= '';
			}

			$pagepath		= substr($untag, 0, strlen($untag) - strlen($page0));
			$anchor			= isset($matches[2]) ? $matches[2] : '';
			$tag			= $unwtag;

			if (isset($_SESSION[$this->config['session_prefix'].'_'.'linktracking']) && $track)
			{
				$this->track_link_to($tag);
			}

			if ($anchorlink && !isset($this->first_inclusion[$supertag]))
			{
				$aname = 'name="'.$supertag.'"';
				$this->first_inclusion[$supertag] = 1;
			}

			if ($thispage)
			{
				$pagelink	= $this->href($method, $thispage['tag']).($anchor ? $anchor : '');
				$page_id	= $this->get_page_id($tag);

				if ($this->config['hide_locked'])
				{
					$access		= $this->has_access('read', $page_id);
				}
				else
				{
					$access		= true;

					if ($this->has_access('read', $page_id) == false)
					{
						$this->_acl['list'] = '';
					}
				}

				if (!$access || $this->_acl['list'] == '')
				{
					$class		= 'denied';
					$accicon	= $this->get_translation('lockicon');
				}
				else if ($this->_acl['list'] == '*')
				{
					$class		= '';
					$accicon	= '';
				}
				else
				{
					$class		= 'customsec';
					$accicon	= $this->get_translation('keyicon');
				}

				if ($text == trim($otag, '/') || $linklang)
				{
					$text = $this->do_unicode_entities($text, $lang);
				}

				$page = $this->do_unicode_entities($page, $lang);

				if (isset($_lang))
				{
					$this->set_language($_lang);
				}
			}
			else
			{
				$tpl		= (isset($this->method) && ($this->method == 'print' || $this->method == 'msword') ? 'p' : '') . 'w' . $tpl;
				$pagelink	= $this->href('edit', $tag, $lang ? 'lang='.$lang : '', 1);
				$accicon	= $this->get_translation('wantedicon');
				$title		= $this->get_translation('CreatePage');

				if ($linklang)
				{
					$text	= $this->do_unicode_entities($text, $linklang);
					$page	= $this->do_unicode_entities($page, $linklang);
				}
			}

			$icon			= str_replace('{theme}', $this->config['theme_url'], $icon);
			$accicon		= str_replace('{theme}', $this->config['theme_url'], $accicon);
			$res			= $this->get_translation('tpl.'.$tpl);
			$text			= trim($text);

			if ($res)
			{
				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				//TODO: pagepath
				$aname		= str_replace('/',			'.',		$aname);
				$res		= str_replace('{aname}',	$aname,		$res);
				$res		= str_replace('{icon}',		$icon,		$res);
				$res		= str_replace('{accicon}',	$accicon,	$res);
				$res		= str_replace('{class}',	$class,		$res);
				$res		= str_replace('{title}',	$title,		$res);
				$res		= str_replace('{pagelink}',	$pagelink,	$res);
				$res		= str_replace('{pagepath}',	$pagepath,	$res);
				$res		= str_replace('{page}',		$page,		$res);
				$res		= str_replace('{text}',		$text,		$res);

				if (!$text)
				{
					$text	= htmlspecialchars($tag, ENT_NOQUOTES);
				}

				if ($this->config['youarehere_text'])
				{
					if ($this->npj_translit($tag) == $this->npj_translit($this->context[$this->current_context]))
					{
						$res	= str_replace('####', $text, $this->config['youarehere_text']);
					}
				}

				// numerated wiki-links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $pagelink != $text && $title != $this->get_translation('CreatePage'))
				{
					if (!$refnum = (isset($this->numerate_links[$pagelink]) ? $this->numerate_links[$pagelink] : ''))
					{
						$refnum = '[link'.((string)count($this->numerate_links) + 1).']';
						$this->numerate_links[$pagelink] = $refnum;
					}
					$res .= '<sup class="refnum">'.$refnum.'</sup>';
				}

				return $res;
			}
			die ("ERROR: no link template '$tpl' found.");
		}

		if (!$text) $text	= htmlspecialchars($tag, ENT_NOQUOTES);

		if ($url)
		{
			if ($imlink)
			{
				$text		= '<img src="'.$imlink.'" border="0" title="'.$text.'" />';
			}

			$icon			= str_replace('{theme}', $this->config['theme_url'], $icon);
			$res			= $this->get_translation('tpl.'.$tpl);

			if ($res)
			{
				if (!$class)
				{
					$class	= 'outerlink';
				}

				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				$res		= str_replace('{icon}',		$icon,	$res);
				$res		= str_replace('{class}',	$class,	$res);
				$res		= str_replace('{title}',	$title,	$res);
				$res		= str_replace('{url}',		$url,	$res);
				$res		= str_replace('{text}',		$text,	$res);

				// numerated outer links and file links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $url != $text && $url != '404' && $url != '403')
				{
					if (!$refnum = (isset($this->numerate_links[$url]) ? $this->numerate_links[$url] : ''))
					{
						$refnum = '[link'.((string)count($this->numerate_links) + 1).']';
						$this->numerate_links[$url] = $refnum;
					}

					$res .= '<sup class="refnum">'.$refnum.'</sup>';
				}

				return $res;
			}
		}
		return $text;
	}

	function add_spaces($text)
	{
		$show = 1;

		if ($user = $this->get_user())
		{
			$show = (isset($user['show_spaces']) ? $user['show_spaces'] : null);
		}
		if (!$show)
		{
			$show = $this->config['show_spaces'];
		}
		if ($show != 0)
		{
			$text = preg_replace('/('.$this->language['ALPHANUM'].')('.$this->language['UPPERNUM'].')/', '\\1&nbsp;\\2', $text);
			$text = preg_replace('/('.$this->language['UPPERNUM'].')('.$this->language['UPPERNUM'].')/', '\\1&nbsp;\\2', $text);
			$text = preg_replace('/('.$this->language['ALPHANUM'].')\//', '\\1&nbsp;/', $text);
			$text = preg_replace('/('.$this->language['UPPER'].')&nbsp;(?='.$this->language['UPPER'].'&nbsp;'.$this->language['UPPERNUM'].')/', '\\1', $text);
			$text = preg_replace('/('.$this->language['UPPER'].')&nbsp;(?='.$this->language['UPPER'].'&nbsp;\/)/', '\\1', $text);
			$text = preg_replace('/\/('.$this->language['ALPHANUM'].')/', '/&nbsp;\\1', $text);
			$text = preg_replace('/('.$this->language['UPPERNUM'].')&nbsp;('.$this->language['UPPERNUM'].')($|\b)/', '\\1\\2', $text);
			$text = preg_replace('/([0-9])('.$this->language['ALPHA'].')/', '\\1&nbsp;\\2', $text);
			$text = preg_replace('/('.$this->language['ALPHA'].')([0-9])/', '\\1&nbsp;\\2', $text);
			$text = preg_replace('/([0-9])&nbsp;(?=[0-9])/', '\\1', $text);
		}

		if (strpos($text, '/')   === 0)
		{
			$text = $this->get_translation('RootLinkIcon').substr($text, 1);
		}
		if (strpos($text, '!/')  === 0)
		{
			$text = $this->get_translation('SubLinkIcon').substr($text, 2);
		}
		if (strpos($text, '../') === 0)
		{
			$text = $this->get_translation('UpLinkIcon').substr($text, 3);
		}

		return $text;
	}

	function add_spaces_title($text)
	{
		$text = preg_replace("/(".$this->language['ALPHANUM'].")(".$this->language['UPPERNUM'].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language['UPPERNUM'].")(".$this->language['UPPERNUM'].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language['ALPHANUM'].")\//", "\\1 /", $text);
		$text = preg_replace("/(".$this->language['UPPER'].")&nbsp;(?=".$this->language['UPPER']."&nbsp;".$this->language['UPPERNUM'].")/", "\\1", $text);
		$text = preg_replace("/(".$this->language['UPPER'].")&nbsp;(?=".$this->language['UPPER']."&nbsp;\/)/", "\\1", $text);
		$text = preg_replace("/\/(".$this->language['ALPHANUM'].")/", "/&nbsp;\\1", $text);
		$text = preg_replace("/(".$this->language['UPPERNUM'].")&nbsp;(".$this->language['UPPERNUM'].")($|\b)/", "\\1\\2", $text);
		$text = preg_replace("/([0-9])(".$this->language['ALPHA'].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language['ALPHA'].")([0-9])/", "\\1 \\2", $text);
		$text = preg_replace("/([0-9]) (?!".$this->language['ALPHA'].")/", "\\1", $text);

		if (strpos($text, '/')   === 0)
		{
			$text = $this->get_translation('RootLinkIcon').substr($text, 1);
		}
		if (strpos($text, '!/')  === 0)
		{
			$text = $this->get_translation('SubLinkIcon').substr($text, 2);
		}
		if (strpos($text, '../') === 0)
		{
			$text = $this->get_translation('UpLinkIcon').substr($text, 3);
		}

		return $text;
	}

	function validate_reserved_words( $data )
	{
		$_data = $this->npj_translit( $data );
		$_data = '/'.$_data.'/';

		// Find the string of text
		# $this->REGEX_WACKO_FUNCTIONS = '/^(.*?)\/'.STANDARD_HANDLERS.'\/(.*)$/i';
		// Find the word
		$this->REGEX_WACKO_FUNCTIONS = '/\b('.STANDARD_HANDLERS.')\b/i';

		echo $this->REGEX_WACKO_FUNCTIONS;

		if (preg_match( $this->REGEX_WACKO_FUNCTIONS, $_data, $match ))
		{
			return $message = "As the part of the address you used the reserved word, do not make thus.";
			/// !!! to messageset, function found
		}
		/*
		if (preg_match( $this->REGEX_WACKO_SPACES, $_data, $match ))
		{
		  return "As the part of the address you used the reserved word, do not make thus.";
		  /// !!! to messageset, subspace found
		}

		if (preg_match( '/^\/[0-9]+/', $_data, $match ))
		{
		  return "It is not possible to create pages, whose name consists of numbers or begins on them.";
		  /// !!! to messageset, begins with 0-9
		}
		*/
		return 0;
	}

	function is_wiki_name($text)
	{
		return preg_match('/^'.$this->language['UPPER'].$this->language['LOWER'].'+'.$this->language['UPPERNUM'].$this->language['ALPHANUM'].'*$/', $text);
	}

	function track_link_to($tag)
	{
		$this->linktable[] = $tag;
	}

	function get_link_table()
	{
		return $this->linktable;
	}

	function clear_link_table()
	{
		$this->linktable = array();
	}

	function start_link_tracking()
	{
		$_SESSION[$this->config['session_prefix'].'_'.'linktracking'] = 1;
	}

	function stop_link_tracking()
	{
		$_SESSION[$this->config['session_prefix'].'_'.'linktracking'] = 0;
	}

	function write_link_table($from_page_id = '')
	{
		$query = '';

		// delete old link table
		if ($from_page_id == '')
		{
			$from_page_id = $this->page['page_id'];
		}

		$this->query(
			"DELETE FROM ".$this->config['table_prefix']."link ".
			"WHERE from_page_id = '".quote($this->dblink, $from_page_id)."'");

		if ($linktable = $this->get_link_table())
		{
			foreach ($linktable as $to_tag)
			{
				$lower_to_tag = strtolower($to_tag);

				if (!isset($written[$lower_to_tag]))
				{
					$query .= "('".quote($this->dblink, $from_page_id)."','".quote($this->dblink, $this->get_page_id($to_tag))."', '".quote($this->dblink, $to_tag)."', '".quote($this->dblink, $this->npj_translit($to_tag))."'),";
					$written[$lower_to_tag] = 1;
				}
			}
			$this->query(
				"INSERT INTO ".$this->config['table_prefix']."link ".
					"(from_page_id, to_page_id, to_tag, to_supertag) ".
				"VALUES ".rtrim($query, ','));
		}
	}

	// INTERWIKI STUFF
	function read_inter_wiki_config()
	{
		if ($lines = file('config/interwiki.conf'))
		{
			foreach ($lines as $line)
			{
				if ($line = trim($line))
				{
					list($wikiName, $wikiUrl) = explode(' ', trim($line));
					$this->inter_wiki[strtolower($wikiName)] = $wikiUrl;
				}
			}
		}
	}

	function get_inter_wiki_url($name, $tag)
	{
		$url = (isset($this->inter_wiki[strtolower($name)]) ? $this->inter_wiki[strtolower($name)] : '');

		if ($url)
		{
			// xhtmlisation
			$url = str_replace('&', '&amp;', $url);

			// tls'ing internal links
			if ($this->config['tls'] == true)
			{
				if (isset($this->config['open_url']) && strpos($url, $this->config['open_url']) !== false)
				{
					$url = str_replace($this->config['open_url'], $this->config['base_url'], $url);
				}
			}

			// translit
			if (strpos($url, $this->config['base_url']) !== false)
			{
				$sub = substr($url, strlen($this->config['base_url']));
				$url = $this->config['base_url'].$this->npj_translit($sub);
			}

			// tagging
			if (strpos($url, '%s'))
			{
				return str_replace('%s', $tag, $url);
			}
			else
			{
				return $url.$tag;
			}
		}
	}

	// FORMS
	function form_open($method = '', $tag = '', $formMethod = 'post', $formname = '', $formMore = '', $hrefParam = '')
	{
		if (!$formMethod)
		{
			$formMethod = 'post';
		}

		$add	= isset($_REQUEST['add']) ? $_REQUEST['add'] : '';
		$result	= '<form action="'.$this->href($method, $tag, $hrefParam, $add).'" '.$formMore.' method="'.$formMethod.'" '.($formname ? 'name="'.$formname.'" ' : '').">\n";

		if (!$this->config['rewrite_mode'])
		{
			$result .= '<input type="hidden" name="page" value="'.$this->mini_href($method, $tag, $add)."\" />\n";
		}

		if ($this->config['tls'] == true)
		{
			$result = str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $result);
		}

		return $result;
	}

	function form_close()
	{
		return "</form>\n";
	}

	// REFERRERS
	function log_referrer($page_id = '', $referrer = '')
	{
		// fill values
		if (!$page_id = trim($page_id))
		{
			$page_id = $this->page['page_id'];
		}

		if (!$referrer = trim($referrer))
		{
			$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		}

		// check if it's coming from another site
		if ($referrer && !preg_match('/^'.preg_quote($this->config['base_url'], '/').'/', $referrer) && isset($_GET['sid']) === false) // TODO: isset($_GET['PHPSESSID']) === false
		{
			$this->query(
				"INSERT INTO ".$this->config['table_prefix']."referrer SET ".
					"page_id		= '".quote($this->dblink, $page_id)."', ".
					"referrer		= '".quote($this->dblink, $referrer)."', ".
					"referrer_time	= NOW()");
		}
	}

	function load_referrers($page_id = '')
	{
		return $this->load_all(
			"SELECT page_id, referrer, count(referrer) AS num ".
			"FROM ".$this->config['table_prefix']."referrer ".
			($page_id = trim($page_id)
				? "WHERE page_id = '".quote($this->dblink, $page_id)."'"
				: "").
			"GROUP BY referrer ".
			"ORDER BY num DESC");
	}

	// PLUGINS
	function include_buffered($filename, $notfoundText = '', $vars = '', $path = '')
	{
		if ($path)
		{
			$dirs = explode(':', $path);
		}
		else
		{
			$dirs = array('');
		}

		foreach($dirs as $dir)
		{
			if ($dir)
			{
				$dir .= '/';
			}

			$fullfilename = $dir.$filename;
			$fullfilename = trim($fullfilename, './');

			if (@file_exists($fullfilename))
			{
				if (is_array($vars))
				{
					extract($vars, EXTR_SKIP);
				}

				ob_start();
				include($fullfilename);
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}
		}
		if ($notfoundText)
		{
			return $notfoundText;
		}
		else
		{
			return false;
		}
	}

	function header($mod = '')
	{
		return $this->include_buffered('header'.$mod.'.php', 'Theme is corrupt: '.$this->config['theme'], '', 'themes/'.$this->config['theme'].'/appearance');
	}

	function footer($mod = '')
	{
		return $this->include_buffered('footer'.$mod.'.php', 'Theme is corrupt: '.$this->config['theme'], '', 'themes/'.$this->config['theme'].'/appearance');
	}

	function use_class($class_name, $class_dir = '', $file_name = '')
	{
		if (!class_exists($class_name))
		{
			if ($file_name == '')
			{
				$file_name = strtolower($class_name);
			}

			if ($class_dir == '')
			{
				$class_dir = $this->config['classes_path'];
			}

			$class_file = $class_dir.'/'.$file_name.'.php';
			$class_file = trim($class_file, './');

			if (!@is_readable($class_file))
			{
				die('Cannot load class '.$class_name.'  from '. $class_file. ' ('.$class_dir.')');
			}
			else
			{
				require_once($class_file);
			}
		}
	}

	function action($action, $params = '', $force_link_tracking = 0)
	{
		$action = trim($action);

		if (!$force_link_tracking)
		{
			$this->stop_link_tracking();
		}

		$result = $this->include_buffered(strtolower($action).'.php', "<i>".$this->get_translation('UnknownAction')." \"$action\"</i>", $params, $this->config['action_path']);

		$this->start_link_tracking();
		$this->no_cache();
		return $result;
	}

	function method($method)
	{
		if (!$handler = $this->page['handler'])
		{
			$handler = 'page';
		}

		$methodLocation = $handler.'/'.$method.'.php';

		return $this->include_buffered($methodLocation, "<i>Unknown method \"$methodLocation\"</i>", '', $this->config['handler_path']);
	}

	// wrapper for the next method
	function format($text, $formatter = 'wiki', $options = '')
	{
		return $this->_format($text, $formatter, $options);
	}

	function _format($text, $formatter, &$options)
	{
		$text = $this->include_buffered('formatters/'.$formatter.'.php', "<i>Formatter \"$formatter\" not found</i>", compact('text', 'options'));

		if ($formatter == 'wacko' && $this->config['default_typografica'])
		{
			$text = $this->include_buffered('formatters/typografica.php', "<i>Formatter \"$formatter\" not found</i>", compact('text'));
		}

		return $text;
	}

	// USERS
	// check whether defined username is already registered.
	// we add appropriate (but not thorough) transliterations
	// to not allow too similiar names.
	function user_name_exists($name)
	{
		if ($name == '')
		{
			return false;
		}

		// checking identical name only?
		if (!$this->config['antidupe'])
		{
			if ($this->load_single(
			"SELECT * FROM {$this->config['user_table']} ".
			"WHERE user_name = '".quote($this->dblink, $name)."'"))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// substitutions table
		$table = array(
			'cyr' => 'ÀÂÑÄÅÍÊÌÎÐÒÕÓàñåêìïîðãèòõó0áI1',
			'lat' => 'ABCDEHKMOPTXYacekmnoprutxyÎ6ll'
		);

		// splitting input name into array
		$name = preg_split('//', $name, -1, PREG_SPLIT_NO_EMPTY);

		// let's define characters positions and corresponding substitutions.
		// so we're constructing $p array with username chars needing
		// substitution positions as keys, and corresponding table positions
		// as array values
		$p = array();

		foreach ($name as $pos => &$char)
		{
			if (isset($p[$pos]) === false)
			{
				if (false !== $sub = strpos($table['lat'], $char))
				{
					$p[$pos] = $sub;
				}
				else if (false !== $sub = strpos($table['cyr'], $char))
				{
					$p[$pos] = $sub;
				}
			}
		}

		// exploding substitutions table into array
		foreach ($table as $key => &$val)
		{
			$table[$key] = preg_split('//', $table[$key], -1, PREG_SPLIT_NO_EMPTY);
		}

		// running through all chars positions needing replacement
		foreach ($p as $pos => $sub)
		{
			// what substitution character we have to use?
			if ($name[$pos] != $table['cyr'][$sub])
			{
				// constructing cyrillic regexp addition
				$name[$pos] = '['.$name[$pos].$table['cyr'][$sub].']';
			}
			else if ($name[$pos] != $table['lat'][$sub])
			{
				// constructing latin regexp addition
				$name[$pos] = '['.$name[$pos].$table['lat'][$sub].']';
			}
		}

		// checking database
		if ($this->load_single(
		"SELECT * FROM {$this->config['user_table']} ".
		"WHERE user_name REGEXP '".quote($this->dblink, implode('', $name))."'", 1))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function load_user($user_name, $user_id = 0, $password = 0)
	{
		$fiels_default = 'u.*, s.doubleclick_edit, s.show_comments, s.revisions_count, s.changes_count, s.lang, s.show_spaces, s.typografica, s.theme, s.autocomplete, s.numerate_links, s.dont_redirect, s.send_watchmail, s.show_files, s.allow_intercom, s.hide_lastsession, s.validate_ip, s.noid_pubs';
		// TODO: add option for session to load only a subset of fields
		$fields_session = 'u.user_id, u.user_name, u.real_name, u.password, u.salt,u.email, u.enabled, u.email_confirm, u.session_time, u.session_time, u.last_mark, s.doubleclick_edit, s.show_comments, s.revisions_count, s.changes_count, s.lang, s.show_spaces, s.typografica, s.theme, s.autocomplete, s.numerate_links, s.dont_redirect, s.send_watchmail, s.show_files, s.allow_intercom, s.hide_lastsession, s.validate_ip, s.noid_pubs';

		$user = $this->load_single(
			"SELECT {$fiels_default} ".
			"FROM ".$this->config['user_table']." u ".
				"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
			"WHERE ".( $user_id != 0
					? "u.user_id		= '".quote($this->dblink, $user_id)."' "
					: "u.user_name	= '".quote($this->dblink, $user_name)."' ").
					"AND u.account_type = '0' ".
			($password === 0
				? ""
				: "AND u.password = '".quote($this->dblink, $password)."'"
				)." ".
			"LIMIT 1");

		if ($user['session_time'] == SQL_NULLDATE)
		{
			$user['session_time'] = '';
		}

		return $user;
	}

	function get_user_name()
	{
		if ($user_name = $this->get_user_setting('user_name'))
		{
			return $user_name;
		}
		else
		{
			return null;
		}
	}

	function get_user_ip()
	{
		if ($this->_userhost)
		{
			return $this->_userhost;
		}
		else
		{
			//only accept http_x for tls-proxy
			return $this->_userhost = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ($_SERVER['HTTP_HOST'] == $this->config['tls_proxy']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
		}
	}

	// extract user data from the session array
	function get_user()
	{
		if (isset( $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.'user'] ))
		{
			return $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.'user'];
		}
		else
		{
			return null;
		}
	}

	// extract specific element from user session array
	function get_user_setting($setting, $option = 0, $guest = 0)
	{
		if (!$option)
		{
			if (isset($_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )][$setting]))
			{
				return $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )][$setting];
			}
		}
		else
		{
			if (isset($_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )]['options'][$setting]))
			{
				return $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )]['options'][$setting];
			}
		}
	}

	// set/update specific element of user session array
	// !!! BE CAREFUL NOT TO SAVE GUEST VALUES UNDER REGISTERED USER ARRAY !!!
	// this poses a potential security threat
	function set_user_setting($setting, $value, $option = 0, $guest = 0)
	{
		if (!$option)
		{
			return $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )][$setting] = $value;
		}
		else
		{
			return $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.( !$guest ? 'user' : 'guest' )]['options'][$setting] = $value;
		}
	}

	// insert user data into the session array
	function set_user($user, $ip = 1)
	{
		$_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.'user'] = $user;

		// define current IP for foregoing checks
		if ($ip == true)
		{
			$this->set_user_setting('ip', (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ($_SERVER['HTTP_HOST'] == $this->config['tls_proxy']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']) );
		}

		return true;
	}

	// update current session time
	function update_session_time($user)
	{
		if ($user['user_name'] == true)
		{
			return $this->query(
				"UPDATE {$this->config['user_table']} ".
				"SET session_time = NOW() ".
				"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
				"LIMIT 1");
		}
	}

	function update_last_mark($user)
	{
		if ($user['user_name'] == true)
		{
			return $this->query(
				"UPDATE {$this->config['user_table']} ".
				"SET last_mark = NOW() ".
				"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
				"LIMIT 1");
		}
	}

	function log_user_in($user, $persistent = 1, $session = 0)
	{
		// cookie elements
		$session	= ( $session == 0 ? $this->config['session_expiration'] : $session );
		$session	= ( $persistent ? $session : 0.25 );
		$ses_time	= time() + $session * 24 * 3600;

		if ($this->config['session_encrypt_cookie'] == true)
		{
			$time_pad	= str_pad($ses_time, 32, '0', STR_PAD_LEFT);
			$user_name	= $user['user_name'];
			$password	= base64_encode(hash('sha1', $this->config['system_seed'] ^ $time_pad) ^ $user['password']);
			// authenticating cookie data:
			// seed | username | composed pwd | raw session time | raw password
			$cookie_mac	= hash('sha1', $this->config['system_seed'].$user_name.$password.$ses_time.$user['password']);
			// construct and set cookie
			$cookie		= implode(';', array($user_name, $password, $ses_time, $cookie_mac));
		}
		else
		{
			$cookie		= implode(';', array($user['user_name'], $user['password'], $ses_time));
		}

		$this->set_session_cookie('auth', $cookie, '', ( $this->config['tls'] == true ? 1 : 0 ));

		if ($persistent)
		{
			$this->set_persistent_cookie('auth', $cookie, $session, ( $this->config['tls'] == true ? 1 : 0 ));
		}

		// update session expiry and clear password recovery
		// code in user data table
		$this->query(
			"UPDATE {$this->config['user_table']} SET ".
				"session_expire		= '".quote($this->dblink, $ses_time)."', ".
				"change_password	= '' ".
			"WHERE user_name		= '".quote($this->dblink, $user['user_name'])."' ".
			"LIMIT 1");

		// restart logged in user session with specific session id
		return $this->restart_user_session($user, $ses_time);
	}

	// regenerate session id for registered user
	function restart_user_session($user, $session_time)
	{
		$this->delete_cookie('sid', true, false);
		unset($_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'user']);
		session_destroy(); // destroy session data in storage

		session_id(hash('sha1', $this->timer.$this->config['system_seed'].$session_time.$user['user_name'].$user['password']));
		return session_start();
	}

	// restore username/password/etc from auth cookie
	function decompose_auth_cookie($name = 'auth')
	{
		$recalc_mac = '';
		$cookie_mac = '';

		if (true == $cookie = $this->get_cookie($name))
		{
			if ($this->config['session_encrypt_cookie'] == true)
			{
				list($user_name, $b64password, $ses_time, $cookie_mac) = explode(';', $cookie);
				$time_pad	= str_pad($ses_time, 32, '0', STR_PAD_LEFT);
				$password	= hash('sha1', $this->config['system_seed'] ^ $time_pad) ^ base64_decode($b64password);
				$recalc_mac	= hash('sha1', $this->config['system_seed'].$user_name.$b64password.$ses_time.$password);
			}
			else
			{
				list($user_name, $password, $ses_time) = explode(';', $cookie);
			}

			return array(
				'user_name'		=> $user_name,
				'password'		=> $password,
				'ses_time'		=> $ses_time,
				'cookie_mac'	=> $cookie_mac,
				'recalc_mac'	=> $recalc_mac
			);
		}
		else
		{
			return null;
		}
	}

	// end user session and free session vars
	function logout_user()
	{
		// clear session expiry in user data table
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET session_expire = 0 ".
			"WHERE user_name = '".quote($this->dblink, $_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'user']['user_name'])."' ".
			"LIMIT 1");

		$this->delete_cookie('auth', true, true);
		$this->delete_cookie('sid', true, false);
		unset($_SESSION[$this->config['session_prefix'].'_'.$this->config['cookie_hash'].'_'.'user']);

		$session_id = hash('sha1', $this->timer.$this->config['system_seed'].$this->get_user_setting('password').session_id());

		session_destroy(); // destroy session data in storage

		session_start();
		session_id($session_id);
	}

	// Increment the number of times the user has logegd in
	function login_count($user_id)
	{
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET login_count = login_count+1 ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
			"LIMIT 1");

		return true;
	}

	// Increment the failed login count by 1
	function set_failed_user_login_count($user_id)
	{
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET failed_login_count = failed_login_count+1 ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
			"LIMIT 1");

		return true;
	}

	// Reset to zero the failed login attempts
	function reset_failed_user_login_count($user_id)
	{
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET failed_login_count = 0 ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
			"LIMIT 1");

		return true;
	}

	// Increment the failed login count by 1
	function set_lost_password_count($user_id)
	{
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET lost_password_request_count = lost_password_request_count+1 ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
			"LIMIT 1");

		return true;
	}

	// Reset to zero the 'lost password' in progress attempts
	function reset_lost_password_count($user_id)
	{
		$this->query(
			"UPDATE {$this->config['user_table']} ".
			"SET lost_password_request_count = 0 ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
			"LIMIT 1");

		return true;
	}

	function load_users()
	{
		return $this->load_all(
			"SELECT * FROM ".$this->config['user_table']." ORDER BY binary user_name");
	}

	function get_user_id()
	{
		if ($user = $this->get_user())
		{
			$user_id = (isset($user['user_id']) ? $user['user_id'] : null);
		}

		if (isset($user_id))
		{
			return $user_id;
		}
		else
		{
			return null;
		}
	}

	function get_user_id_by_name($user = '')
	{
		$user = $this->load_single(
					"SELECT user_id FROM ".$this->config['table_prefix']."user WHERE user_name = '".$user."' LIMIT 1");
					// Get user value
					$user_id = $user['user_id'];

		return $user_id;
	}

	function user_wants_comments()
	{
		if (!$user = $this->get_user())
		{
			return false;
		}

		return ($user['show_comments'] == 1);
	}

	function user_wants_files()
	{
		if (!$user = $this->get_user())
		{
			return false;
		}

		return (isset($user['show_files']) && $user['show_files'] == 1);
	}

	// Returns boolean indicating if the current user is allowed to see comments at all
	function user_allowed_comments()
	{
		return $this->config['hide_comments'] != 1 && ($this->config['hide_comments'] != 2 || $this->get_user());
	}

	// COMMENTS AND COUNTS
	// recount all user's comments
	function count_user_comments($name)
	{
		$count = $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id <> '0'");

		return (int)$count['n'];
	}

	// recount all user's pages
	function count_user_pages($name)
	{
		$count = $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'");

		return (int)$count['n'];
	}

	// recount all user's page revisions
	function count_user_revisions($name)
	{
		$count = $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}revision ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'");

		return (int)$count['n'];
	}

	// recount all comments for a given page
	function count_comments($comment_on_id)
	{
		$count = $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE comment_on_id = '".quote($this->dblink, $comment_on_id)."'");
		return (int)$count['n'];
	}

	// get current number of comments
	function get_comments_count($tag = '')
	{
		if ($this->page && $tag == false)
		{
			return $this->page['comments'];
		}
		else
		{
			$count = $this->load_single(
				"SELECT comments ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ".
				"LIMIT 1");

			return $count['comments'];
		}
		return false;
	}

	// returns latest comment tag for a given page
	function latest_comment($comment_on_id)
	{
		if (comment_on_id) // XXX: for moderation or obsolete function?
		{
			$latest = $this->load_single(
			"SELECT tag ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE comment_on_id = '".quote($this->dblink, $comment_on_id)."' ".
			"ORDER BY created DESC ".
			"LIMIT 1");
		}
		return $latest['tag'];
	}

	function load_comments($page_id, $limit = 0, $count = 30)
	{
		// avoid results if $page_id is 0 (page does not exists)
		if ($page_id)
		{
			return $this->load_all(
					"SELECT p.page_id, p.tag, p.created, p.modified, p.body, p.body_r, p.title, u.user_name AS user ".
					"FROM ".$this->config['table_prefix']."page p ".
						"LEFT OUTER JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE p.comment_on_id = '".quote($this->dblink, $page_id)."' ".
					"ORDER BY p.created ".
					"LIMIT {$limit}, {$count}");
		}
	}

	// ACCESS CONTROL
	function is_admin()
	{
		if (!$this->get_user())
		{
			return false;
		}

		if (is_array($this->config['aliases']))
		{
			$al = $this->config['aliases'];
			$adm = explode("\\n", $al['Admins']);

			if ($adm == true && in_array($this->get_user_name(), $adm))
			{
				return true;
			}
		}

		return false;
	}

	function is_moderator()
	{
		if (!$this->get_user())
		{
			return false;
		}

		if (is_array($this->config['aliases']))
		{
			$al  = $this->config['aliases'];

			if(isset($al['Moderator']))
			{
				$mod = explode("\\n", $al['Moderator']);

				if ($mod == true && in_array($this->get_user_name(), $mod))
				{
					return true;
				}
			}
		}

		return false;
	}

	function is_reviewer()
	{
		if (!$this->get_user())
		{
			return false;
		}

		if (is_array($this->config['aliases']))
		{
			$al  = $this->config['aliases'];

			if (isset($al['Reviewer']))
			{
				$mod = explode("\\n", $al['Reviewer']);

				if ($mod == true && in_array($this->get_user_name(), $mod))
				{
					return true;
				}
			}
		}

		return false;
	}

	// returns true if logged in user is owner of current page, or page specified in $tag
	function user_is_owner($page_id = '')
	{
		// check if user is logged in
		if (!$this->get_user())
		{
			return false;
		}

		// set default tag
		if (!$page_id = trim($page_id))
		{
			$page_id = $this->page['page_id'];
		}

		// check if user is owner
		if ($this->get_page_owner_id($page_id) == $this->get_user_id())
		{
			return true;
		}
	}

	function get_page_owner_from_comment()
	{
		if($this->page['comment_on_id'])
		{
			return $this->get_page_owner('', $this->page['comment_on_id']);
		}
		else
		{
			return false;
		}
	}

	function get_page_owner($tag = '', $page_id = 0, $revision_id = '')
	{
		if (!$tag = trim($tag))
		{
			if (!$revision_id)
			{
				return $this->page['owner_name'];
			}
			else
			{
				$tag = $this->tag;
			}
		}

		if ($page = $this->load_page($tag, $page_id, $revision_id, LOAD_CACHE, LOAD_META))
		{
			return $page['owner_name'];
		}
	}

	function get_page_owner_id($page_id = '', $revision_id = '')
	{

		if (!$page_id = trim($page_id))
		{
			if (!$revision_id)
			{
				return $this->page['owner_id'];
			}
			else
			{
				$page_id = $this->page['page_id'];
			}
		}

		if ($page = $this->load_page('', $page_id, $revision_id, LOAD_CACHE, LOAD_META))
		{
			return $page['owner_id'];
		}
	}

	function set_page_owner($page_id, $user_id)
	{
		// check if user exists
		if (!$this->load_user(0, $user_id))
		{
			return;
		}

		// updated latest revision with new owner
		$this->query(
			"UPDATE ".$this->config['table_prefix']."page ".
			"SET owner_id = '".quote($this->dblink, $user_id)."' ".
			"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
			"LIMIT 1");
	}

	function save_acl($page_id, $privilege, $list)
	{

		if ($this->load_acl($page_id, $privilege, 0, 0, 0))
		{
			$this->query(
				"UPDATE ".$this->config['table_prefix']."acl SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", '', $list)))."' ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
					"AND privilege = '".quote($this->dblink, $privilege)."' ");
		}
		else
		{
			$this->query(
				"INSERT INTO ".$this->config['table_prefix']."acl SET ".
					"list		= '".quote($this->dblink, trim(str_replace("\r", '', $list)))."', ".
					"page_id	= '".quote($this->dblink, $page_id)."', ".
					"privilege	= '".quote($this->dblink, $privilege)."'");
		}
	}

	function get_cached_acl($page_id, $privilege, $use_defaults)
	{
		if (isset( $this->acl_cache[$page_id.'#'.$privilege.'#'.$use_defaults] ))
		{
			return $this->acl_cache[$page_id.'#'.$privilege.'#'.$use_defaults];
		}
		else
		{
			return '';
		}
	}

	// $acl array must reflect acls table row structure
	function cache_acl($page_id, $privilege, $use_defaults, $acl)
	{
		$this->acl_cache[$page_id.'#'.$privilege.'#'.$use_defaults] = $acl;
	}

	function load_acl($page_id, $privilege, $use_defaults = 1, $use_cache = 1, $use_parent = 1)
	{
		if (!isset($acl))
		{
			$acl = '';
		}

		if ($use_cache && $use_parent)
		{
			if ($cached_acl = $this->get_cached_acl($page_id, $privilege, $use_defaults))
			{
				$acl = $cached_acl;
			}
		}

		if (!$acl)
		{
			if ($cached_acl = $this->get_cached_acl($page_id, $privilege, $use_defaults))
			{
				$acl = $cached_acl;
			}

			if (!$acl)
			{
				$acl = $this->load_single(
					"SELECT * ".
					"FROM ".$this->config['table_prefix']."acl ".
					"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
						"AND privilege = '".quote($this->dblink, $privilege)."' ".
					"LIMIT 1");

				// if still no acl, use config defaults
				if (!$acl && $use_defaults)
				{
					// First look for parent ACL, so that clusters/subpages
					// work correctly.
					$tag = strtolower($this->get_page_tag_by_id($page_id));

					if ( strstr($tag, '/') )
					{
						$parent_tag = preg_replace('/^(.*)\\/([^\\/]+)$/', '$1', $tag);

						// By letting it fetch defaults, it will automatically recurse
						// up the tree of parent pages... fetching the ACL on the root
						// page if necessary.
						$parent_id	= $this->get_page_id($parent_tag);
						$acl		= $this->load_acl($parent_id, $privilege, 1);
					}

					// if still no acl, use config defaults
					if (!$acl)
					{
						$acl = array(
							"page_id" => $page_id,
							"privilege" => $privilege,
							"list" => $this->config['default_'.$privilege.'_acl'],
							"time" => date('YmdHis'),
							"default" => 1
						);
					}
				}

				$this->cache_acl($page_id, $privilege, $use_defaults, $acl);
			}
		}

		return $acl;
	}

	// returns true if $user (defaults to the current user) has access to $privilege on $page_tag (defaults to the current page)
	function has_access($privilege, $page_id = '', $user = '', $use_parent = 1)
	{
		if ($user == '')
		{
			$user_name = strtolower($this->get_user_name());
		}
		else if ($user == GUEST)
		{
			$user_name = GUEST;
		}
		else
		{
			$user_name = $user;
		}

		if (!$page_id = trim($page_id))
		{
			$page_id = $this->page['page_id'];
		}

		if ($privilege == 'write')
		{
			$use_parent = 0;
		}

		// load acl
		$acl		= $this->load_acl($page_id, $privilege, 1, 1, $use_parent);
		$this->_acl	= $acl;

		// if current user is owner or admin, return true. they can do anything!
		if ($user == '' && $user_name != GUEST)
		{
			if ($this->user_is_owner($page_id) || $this->is_admin())
			{
				return true;
			}
		}

		return $this->check_acl($user_name, $acl['list'], true);
	}

	function check_acl($user, $acl_list, $copy_to_this_acl = false, $debug = 0)
	{
		if (is_array($user))
		{
			$user = $user['user_name'];
		}

		$user = strtolower($user);

		// replace groups
		$acl = str_replace(' ', '', strtolower($this->replace_aliases($acl_list)));

		if ($copy_to_this_acl)
		{
			$this->_acl['list'] = $acl;
		}

		$acls = "\n".$acl."\n";

		if ($user == GUEST || $user == '')
		{
			if (($pos = strpos($acls, '*')) === false)
			{
				return false;
			}

			if ($acls{$pos - 1} != '!')
			{
				return true;
			}

			return false;
		}

		$upos	= strpos($acls, "\n".$user."\n");
		$aupos	= strpos($acls, "\n!".$user."\n");
		$spos	= strpos($acls, '*');
		$bpos	= strpos($acls, '$');

		if ($aupos !== false)
		{
			return false;
		}

		if ($upos !== false)
		{
			return true;
		}

		if ($spos !== false)
		{
			if ($acls{$spos - 1} == '!')
			{
				return false;
			}
		}

		if ($bpos !== false)
		{
			if ($acls{$bpos - 1} == '!')
			{
				return false;
			}
		}

		if ($spos !== false)
		{
			return true;
		}

		if ($bpos !== false)
		{
			if ($user == GUEST || $user == '')
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		return false;
	}

	// aliases stuff
	function replace_aliases($acl)
	{
		if (!is_array($this->config['aliases']))
		{
			return $acl;
		}

		foreach ($this->config['aliases'] as $key => $val)
		{
			$aliases[strtolower($key)] = $val;
		}

		do
		{
			$list		= array();
			$lines		= explode("\n", $acl);
			$replaced	= 0;

			foreach ($lines as $line)
			{
				$linel = $line;

				// check for inversion character "!"
				if (preg_match('/^\!(.*)$/', $line, $matches))
				{
					$negate	= 1;
					$linel	= $matches[1];
				}
				else
				{
					$negate = 0;
				}

				$linel = strtolower(trim($linel));

				if (isset($aliases[$linel]))
				{
					foreach (explode("\\n", $aliases[$linel]) as $item)
					{
						$item	= trim($item);
						$list[]	= ($negate ? '!'.$item : $item);
					}

					$replaced++;
				}
				else
				{
					$list[] = $line;
				}
			}
			$acl = join("\n", $list);
		}
		while ($replaced > 0);

		return $acl;
	}

	// WATCHES
	function is_watched($user_id, $page_id)
	{
		return $this->load_single(
			"SELECT * FROM ".$this->config['table_prefix']."watch ".
			"WHERE user_id		= '".quote($this->dblink, $user_id)."' ".
				"AND page_id	= '".quote($this->dblink, $page_id)."'");
	}

	function set_watch($user_id, $page_id)
	{
		// Remove old watch first to avoid double watches
		$this->clear_watch($user_id, $page_id);

		if ($this->has_access('read', $page_id))
		{
			return $this->query(
				"INSERT INTO ".$this->config['table_prefix']."watch (user_id, page_id) ".
				"VALUES ( '".quote($this->dblink, $user_id)."', '".quote($this->dblink, $page_id)."')" );
				// TIMESTAMP type is filled automatically by MySQL
		}
		else
		{
			return false;
		}
	}

	function clear_watch($user_id, $page_id)
	{
		return $this->query(
			"DELETE FROM ".$this->config['table_prefix']."watch ".
			"WHERE user_id		= '".quote($this->dblink, $user_id)."' ".
				"AND page_id	= '".quote($this->dblink, $page_id)."'");
	}

	// REVIEW
	function set_review($reviewer_id, $page_id)
	{
		// set / unset review
		$this->page['reviewed'] == 1 ? $reviewed = 0 : $reviewed = 1;

		if ($this->has_access('read', $page_id))
		{
			return $this->query(
				"UPDATE ".$this->config['table_prefix']."page SET ".
					"reviewed		= '".quote($this->dblink, $reviewed)."', ".
					"reviewed_time	= NOW(), ".
					"reviewer_id	= '".quote($this->dblink, $reviewer_id)."' ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
				"LIMIT 1");

		}
		else
		{
			return false;
		}
	}

	// BOOKMARKS
	function get_default_bookmarks($lang = false)
	{
		if (!isset($lang))
		{
			$user = $this->get_user();

			if(isset($user['lang']))
			{
				$lang = $user['lang'];
			}
			else if (isset($this->config['multilanguage']))
			{
				$lang = $this->user_agent_language();
			}
			else
			{
				$lang = $this->config['language'];
			}
		}

		$user_id	= $this->get_user_id_by_name('System');
		$default_bm	= $this->get_user_bookmarks($user_id, $lang);
		#$this->debug_print_r($default_bm);

		return $default_bm;
	}

	function get_user_bookmarks($user_id, $lang = '')
	{
		$user_bm = '';

		// avoid results if $user_id is 0 (user does not exists)
		if ($user_id)
		{
			$_bookmarks = $this->load_all(
					"SELECT p.tag, p.title, b.bm_title, b.lang ".
					"FROM ".$this->config['table_prefix']."bookmark b ".
						"LEFT JOIN ".$this->config['table_prefix']."page p ON (b.page_id = p.page_id) ".
					"WHERE b.user_id = '".quote($this->dblink, $user_id)."' ".
						($lang
							? "AND b.lang = '".quote($this->dblink, $lang)."' "
							: "").
					"ORDER BY b.bm_position", 1);

			if ($_bookmarks)
			{
				foreach($_bookmarks as $_bookmark)
				{
					$user_bm .= "((".$_bookmark['tag'].
						(!empty($_bookmark['bm_title'])
							? " ".$_bookmark['bm_title']
							: (!empty($_bookmark['title'])
								? " ".$_bookmark['title']
								: " ".$_bookmark['tag']
								)
						).
						(!empty($_bookmark['lang'])
							? " @@".$_bookmark['lang']
							: "").
					"))\n";
				}
			}

			return $user_bm;
		}
	}

	function set_bookmarks($set = BM_AUTO)
	{
		$user = $this->get_user();

		// initial bookmarks table construction
		if ($set || !($bookmarks = $this->get_bookmarks()))
		{
			$user_bm = $this->get_user_bookmarks($user['user_id']);
			$bookmarks = ( $user_bm
				? $user_bm
				: $this->get_default_bookmarks($user['lang']) );

			if ($set == BM_DEFAULT)
			{
				$bookmarks = $this->get_default_bookmarks($user['lang']);
			}

			// parsing bookmarks into link table
			$bookmarks	= explode("\n", $bookmarks);
			$bm_links = $this->parsing_bookmarks($bookmarks);

			$_SESSION[$this->config['session_prefix'].'_'.'bookmarks']		= $bookmarks;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarklinks']	= $bm_links;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarksfmt']	= $this->format(implode("\n", $bookmarks), 'wacko');
		}

		// adding new bookmark
		if (!empty($_GET['addbookmark']) && $user)
		{
			// writing bookmark
			$bookmark = '(('.$this->tag.' '.($this->get_page_title() ? $this->get_page_title() : $this->tag).($user['lang'] != $this->page_lang ? ' @@'.$this->page_lang : '').'))';

			if (!in_array($bookmark, $bookmarks))
			{
				$bookmarks[] = $bookmark;

				$_bm_position = $this->load_all(
					"SELECT b.bookmark_id ".
					"FROM ".$this->config['table_prefix']."bookmark b ".
					"WHERE b.user_id = '".quote($this->dblink, $user['user_id'])."' ", 0);
				$_bm_count = count($_bm_position);

				$this->query(
					"INSERT INTO ".$this->config['table_prefix']."bookmark SET ".
					"user_id			= '".quote($this->dblink, $user['user_id'])."', ".
					"page_id			= '".quote($this->dblink, $this->page['page_id'])."', ".
					"lang				= '".quote($this->dblink, ($user['lang'] != $this->page_lang ? $this->page_lang : ""))."', ".
					"bm_position		= '".quote($this->dblink, ($_bm_count + 1))."'");
			}

			// parsing bookmarks into link table
			$bm_links = $this->parsing_bookmarks($bookmarks);

			$this->set_user_setting('bookmarks', implode("\n", $bookmarks));

			$_SESSION[$this->config['session_prefix'].'_'.'bookmarks']		= $bookmarks;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarklinks']	= $bm_links;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarksfmt']	= $this->format(implode("\n", $bookmarks), 'wacko');
		}

		// removing bookmark
		if (!empty($_GET['removebookmark']) && $user)
		{
			// rewriting bookmarks table except containing current page tag
			foreach ($bookmarks as $bookmark)
			{
				if ($bookmark && substr($bookmark, 2, strpos($bookmark, ' ', 2) - 2) != $this->tag)
				{
					$newbookmarks[] = $bookmark;
				}
			}

			if (count($newbookmarks) < 1)
			{
				$newbookmarks[] = '';
			}

			$bookmarks = $newbookmarks;

			$this->query(
				"DELETE FROM ".$this->config['table_prefix']."bookmark ".
				"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"AND page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
				"LIMIT 1");

			// parsing bookmarks into link table
			$bm_links = $this->parsing_bookmarks($bookmarks);

			$this->set_user_setting('bookmarks', ( $bookmarks ? implode("\n", $bookmarks) : '' ));

			$_SESSION[$this->config['session_prefix'].'_'.'bookmarks']		= $bookmarks;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarklinks']	= $bm_links;
			$_SESSION[$this->config['session_prefix'].'_'.'bookmarksfmt']	= ( $bookmarks ? $this->format(implode("\n", $bookmarks), 'wacko') : '' );
		}
	}

	function parsing_bookmarks($bookmarks)
	{
		// parsing bookmarks into link table
		$bm_links = $bookmarks;

		for ($i = 0; $i < count($bm_links); $i++)
		{
			if (strpos($bm_links[$i], '[') === 0 || strpos($bm_links[$i], '(') === 0)
			{
				if (($space = strpos($bm_links[$i], ' ')) == true)
				{
					$bm_links[$i] = substr($bm_links[$i], 0, $space);
				}
				else
				{
					$bm_links[$i] = substr($bm_links[$i], 0);
				}

				$bm_links[$i] = trim($bm_links[$i], '[( )]');
				#$bm_links[$i] = $this->npj_translit($bm_links[$i]);
			}
			else
			{
				$bm_links[$i] = '';
			}
		}

		return $bm_links;
	}

	function get_bookmarks()
	{
		if (isset($_SESSION[$this->config['session_prefix'].'_'.'bookmarks']))
		{
			return $_SESSION[$this->config['session_prefix'].'_'.'bookmarks'];
		}
	}

	function get_bookmarks_formatted()
	{
		if (isset($_SESSION[$this->config['session_prefix'].'_'.'bookmarksfmt']))
		{
			return $_SESSION[$this->config['session_prefix'].'_'.'bookmarksfmt'];
		}
	}

	function get_bookmark_links()
	{
		if (isset($_SESSION[$this->config['session_prefix'].'_'.'bookmarklinks']))
		{
			return $_SESSION[$this->config['session_prefix'].'_'.'bookmarklinks'];
		}
	}

	// MAINTENANCE
	function maintenance()
	{
		// purge referrers (once a day)
		if (($days = $this->config['referrers_purge_time']) && (time() > ($this->config['maint_last_refs'] + 1 * 86400)))
		{
			$this->query(
				"DELETE FROM ".$this->config['table_prefix']."referrer ".
				"WHERE referrer_time < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");

			$this->query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE config_name = 'maint_last_refs'");

			$this->log(7, 'Maintenance: referrers purged');
		}

		// purge outdated pages revisions (once a week)
		if (($days = $this->config['pages_purge_time']) && (time() > ($this->config['maint_last_oldpages'] + 7 * 86400)))
		{
			$this->query(
				"DELETE FROM ".$this->config['table_prefix']."revision ".
				"WHERE modified < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");

			$this->query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE config_name = 'maint_last_oldpages'");

			$this->log(7, 'Maintenance: outdated pages revisions purged');
		}

		// purge deleted pages (once per 3 days)
		if (($days = $this->config['keep_deleted_time']) && (time() > ($this->config['maint_last_delpages'] + 3 * 86400)) &&
		($pages = $this->load_recently_deleted(1000, 0)))
		{
			// composing a list of candidates
			if (is_array($pages)) foreach ($pages as $page)
			{
				// does the page has been deleted earlier than specified number of days ago?
				if (strtotime($page['date']) < (time() - (3600 * 24 * $days)))
				{
					$remove[] = "'".quote($this->dblink, $page['tag'])."'";
				}
			}

			if ($remove)
			{
				$this->query(
					"DELETE FROM {$this->config['table_prefix']}revision ".
					"WHERE tag IN ( ".implode(', ', $remove)." )");
				unset($remove);
			}

			$this->query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE config_name = 'maint_last_delpages'");

			$this->log(7, 'Maintenance: deleted pages purged');
		}

		// purge system log entries (once per 3 days)
		if (($days = $this->config['log_purge_time']) && (time() > ($this->config['maint_last_log'] + 3 * 86400)))
		{
			$this->query(
				"DELETE FROM {$this->config['table_prefix']}log ".
				"WHERE log_time < DATE_SUB( NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY )");

			$this->query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE config_name = 'maint_last_log'");

			$this->log(7, 'Maintenance: system log purged');
		}

		// remove outdated pages cache, purge sql cache,
		if (time() > ($this->config['maint_last_cache'] + 3600))
		{
			// pages
			if ($ttl = $this->config['cache_ttl'])
			{
				// clear from db
				$this->query(
					"DELETE FROM ".$this->config['table_prefix']."cache ".
					"WHERE cache_time < DATE_SUB( NOW(), INTERVAL '".quote($this->dblink, $ttl)."' SECOND )");

				// delete from fs
				clearstatcache();
				$handle = opendir(rtrim($this->config['cache_dir'].CACHE_PAGE_DIR, '/'));

				while (false !== ($file = readdir($handle)))
				{
					if (is_file($this->config['cache_dir'].CACHE_PAGE_DIR.$file) &&
					((time() - @filemtime($this->config['cache_dir'],CACHE_PAGE_DIR.$file)) > $ttl))
					{
						@unlink($this->config['cache_dir'].CACHE_PAGE_DIR.$file);
					}
				}

				closedir($handle);

				//$this->log(7, 'Maintenance: cached pages purged');
			}

			// query results
			if ($ttl = $this->config['cache_sql_ttl'])
			{
				// delete from fs
				clearstatcache();
				$handle = opendir(rtrim($this->config['cache_dir'].CACHE_SQL_DIR, '/'));

				while (false !== ($file = readdir($handle)))
				{
					if (is_file($this->config['cache_dir'].CACHE_SQL_DIR.$file) &&
					((time() - @filemtime($this->config['cache_dir'].CACHE_SQL_DIR.$file)) > $ttl))
					{
						@unlink($this->config['cache_dir'].CACHE_SQL_DIR.$file);
					}
				}

				closedir($handle);

				//$this->log(7, 'Maintenance: cached sql results purged');
			}

			$this->query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE config_name = 'maint_last_cache'");
		}
	}

	// MAIN EXECUTION ROUTINE
	function run($tag, $method = '')
	{
		// mandatory tls?
		if ($this->config['tls'] == true && $this->config['tls_implicit'] == true && ( ($_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
		{
			$this->redirect(str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->href($method, $tag)));
		}

		// url lang selection
		$url	= explode('@@', $tag);
		$tag	= trim($url[0]);
		$lang	= (isset($url[1]) ? trim($url[1]) : null);

		if (!trim($tag))
		{
			$tag = $this->config['root_page'];
		}

		// autotasks
		if (!($this->get_micro_time() % 3))
		{
			$this->maintenance();
		}

		$this->read_inter_wiki_config();

		// parse authentication cookie and get user data
		$auth = $this->decompose_auth_cookie();
		$user = $this->load_user($auth['user_name'], 0, $auth['password']);

		// run in tls mode?
		if ($this->config['tls'] == true && (( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] == '443' ) || $user == true))
		{
			$this->config['open_url']		= $this->config['base_url'];
			$this->config['base_url']		= str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->config['base_url']);
			$this->config['theme_url']		= $this->config['base_url'].'themes/'.$this->config['theme'].'/';
			$this->config['cookie_path']	= preg_replace('|https?://[^/]+|i', '', $this->config['base_url'].'');
		}

		// in strong cookie mode check session validity
		if ($this->config['session_encrypt_cookie'] == true)
		{
			if ($user['session_expire'] != 0 && time() < $user['session_expire'] &&
			time() < $auth['ses_time'] && $user['session_expire'] == $auth['ses_time'] &&
			$auth['recalc_mac'] == $auth['cookie_mac'])
			{
				$session = true;
			}
			else
			{
				// log event: invalid auth cookie
				if ($auth['recalc_mac'] != $auth['cookie_mac'])
				{
					$this->log(1, '<strong><span class="cite">Malformed/forged user authentication cookie detected. Destroying existing session (if any)</span></strong>');
				}

				$session = false;

				// terminate expired/invalid session
				if ($this->get_user())
				{
					// log event: session expired
					if (time() > $auth['ses_time'])
					{
						$this->log(2, 'Expired user session terminated');
					}

					$this->logout_user();
					$this->redirect($this->config['base_url'].$this->config['login_page'].'?goback='.$tag);
				}
			}
		}
		else
		{
			$session = true;
		}

		// check IP validity
		if ($this->get_user_setting('validate_ip', 1) == 1 && $this->get_user_setting('ip') != (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ($_SERVER['HTTP_HOST'] == $this->config['tls_proxy']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']) )
		{
			$this->log(1, '<strong><span class="cite">User in-session IP change detected</span></strong>');
			$this->logout_user();
			$this->redirect($this->config['base_url'].$this->config['login_page'].'?goback='.$tag);
			$session = false;
		}

		// start user session
		if (!$this->get_user() && $session === true && $user == true)
		{
			$this->restart_user_session($user, $auth['ses_time']);
			$this->set_user($user, 1);
			$this->update_session_time($user);
			unset($user);
		}

		$user = $this->get_user();

		unset($auth);

		// user settings
		if(isset($user['lang']))
		{
			if($user['lang'] == '')
			{
				$this->user_lang = $this->config['language'];
			}
			else
			{
				$this->user_lang = $user['lang'];
			}
		}
		else
		{
			$this->user_agent_language();
		}

		if (is_array($user) && isset($user['theme']))
		{
			$this->config['theme']		= $user['theme'];
			$this->config['theme_url']	= $this->config['base_url'].'themes/'.$this->config['theme'].'/';
		}

		if (!$this->config['multilanguage'])
		{
			$this->set_language($this->config['language']);
		}

		// registering translations
		$this->load_all_languages();
		$this->load_translation($this->user_lang);
		$this->set_translation($this->user_lang);
		$this->set_language($this->user_lang);

		// SEO
		foreach ($this->search_engines as $engine)
		{
			if (stristr($_SERVER['HTTP_USER_AGENT'], $engine))
			{
				$this->resource['OuterLink2']	= '';
				$this->resource['outericon']	= '';
			}
		}

		if (!$this->method	= trim($method))
		{
			$this->method	= 'show';
		}

		// normalizing tag name
		if (!preg_match('/^['.$this->language['ALPHANUM_P'].'\!]+$/', $tag))
		{
			$tag = $this->try_utf_decode($tag);
		}

		$tag = str_replace("'", '_', str_replace('\\', '', str_replace('_', '', $tag)));
		$tag = preg_replace('/[^'.$this->language['ALPHANUM_P'].'\_\-\.]/', '', $tag);

		$this->tag		= $tag;
		$this->supertag	= $this->npj_translit($tag);

		$revision_id	= isset($_GET['revision_id']) ? $_GET['revision_id'] : '';
		$page			= $this->load_page($this->tag, 0, $revision_id);

		if ($this->config['outlook_workaround'] && !$page)
		{
			$page = $this->load_page($this->supertag."'", 0, $revision_id);
		}

		$this->set_page($page);
		$this->log_referrer();
		$this->set_bookmarks();

		if ($this->page)
		{
			// override perpage settings
			$this->page['options'] = array(
				'hide_comments'		=> $this->page['hide_comments'],
				'hide_files'		=> $this->page['hide_files'],
				'hide_rating'		=> $this->page['hide_rating'],
				'hide_toc'			=> $this->page['hide_toc'],
				'hide_index'		=> $this->page['hide_index'],
				'tree_level'		=> $this->page['tree_level'],
				'allow_rawhtml'		=> $this->page['allow_rawhtml'],
				'disable_safehtml'	=> $this->page['disable_safehtml'],
				'theme'				=> $this->page['theme']
				);

			foreach ($this->page['options'] as $key => $val)
			{
				if ($key && $val == true)
				{
					$this->config[$key] = $val;
				}
			}

			$this->config['theme_url']	= $this->config['base_url'].'themes/'.$this->config['theme'].'/';

			// set page categories. this defines $categories (array) object property
			#if ($this->page['categories'])
			#{
				$categories = $this->load_all(
					"SELECT k.category_id, k.category
					FROM {$this->config['table_prefix']}category k
						INNER JOIN {$this->config['table_prefix']}category_page kp ON (k.category_id = kp.category_id)
					WHERE kp.page_id = '{$this->page['page_id']}' ");

				foreach ($categories as $word)
				{
					$this->categories[$word['category_id']] = $word['category'];
				}
				unset($categories, $word);
			#}
		}

		if (!$user && $this->page['modified'])
		{
			header("Last-Modified: ".gmdate("D, d M Y H:i:s", strtotime($this->page['modified']) + 120)." GMT");
		}

		$this->http_security_headers();

		// check page watching
		if ($user && $this->page)
		{
			if ($this->is_watched($user['user_id'], $this->page['page_id']))
			{
				$this->iswatched = true;
			}
		}

		// forum page
		if (preg_match('/'.$this->config['forum_cluster'].'\/.+?\/.+/', $this->tag) ||
		($this->page['comment_on_id'] ? preg_match('/'.$this->config['forum_cluster'].'\/.+?\/.+/', $this->get_page_tag_by_id($this->page['comment_on_id'])) : ''))
		{
			$this->forum = true;
		}
		else
		{
			$this->forum = false;
		}

		// display page contents
		if (preg_match('/(\.xml)$/', $this->method))
		{
			echo $this->method($this->method);
		}
		else
		{
			if (preg_match('/print$/', $this->method))
			{
				$mod = 'print';
			}
			else if (preg_match('/msword$/', $this->method))
			{
				$mod = 'msword';
			}
			else
			{
				$mod = '';
			}

			if (!isset($data))
			{
				$data = '';
			}

			$this->cache_links();
			$this->current_context++;
			$this->context[$this->current_context] = $this->tag;
			$data .= $this->method($this->method);
			$this->current_context--;
			echo $this->header($mod).$data.$this->footer($mod);
		}
		return $this->tag;
	}

	// TOC MANIPULATIONS
	function set_toc_array($toc)
	{
		$this->body_toc = '';

		foreach ($toc as $k => $v)
		{
			$toc[$k] = implode('<poloskuns,col>', $v);
		}

		$this->body_toc = implode('<poloskuns,row>', $toc);
	}

	function build_toc($tag, $from, $to, $num, $link = -1)
	{
		if (isset($this->tocs[$tag]))
		{
			return $this->tocs[$tag];
		}

		$page = $this->load_page($tag);

		if ($link === -1)
		{
			$_link = ($this->page['tag'] != $page['tag']) ? $this->href('', $page['tag']) : '';
		}
		else
		{
			$_link = $link;
		}

		$toc = explode('<poloskuns,row>', $page['body_toc']);

		foreach ($toc as $k => $v)
		{
			$toc[$k] = explode('<poloskuns,col>', $v);
		}

		$_toc = array();

		foreach ($toc as $k => $v)
		{
			if ($v[2] == 99999)
			{
				if (!in_array($v[0], $this->toc_context))
				{
					if (!($v[0] == $this->tag))
					{
						array_push($this->toc_context, $v[0]);
						$_toc = array_merge($_toc, $this->build_toc($v[0], $from, $to, $num, $link));
						array_pop($this->toc_context);
					}
				}
			}
			else
			{
				if ($v[2] == 77777)
				{
					$toc[$k][3] = $_link;
					$_toc[] = &$toc[$k];
				}
				else
				{
					if (($v[2] >= $from) && ($v[2] <= $to))
					{
						$toc[$k][3] = $_link;
						$_toc[] = &$toc[$k];
						$toc[$k][1] = $this->format($toc[$k][1], 'post_wacko');
					}
				}
			}
		}

		$this->tocs[$tag] = $_toc;
		return $_toc;
	}

	// numerating toc using prepared "$this->post_wacko_toc"
	function numerate_toc($what)
	{
		if (!is_array($this->post_wacko_action))
		{
			return $what;
		}

		// #1. hash toc
		$hash = array();

		foreach ($this->post_wacko_toc as $v)
		{
			$hash[$v[0]] = $v;
		}

		$this->post_wacko_toc_hash = &$hash;

		if (isset($this->post_wacko_action['toc']))
		{
			// #2. find all <a></a><hX> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<a name=\"(h[0-9]+-[0-9]+)\"></a><h([0-9])>(.*?)</h\\3>)!i",
				array(&$this, 'numerate_toc_callback_toc'), $what);
		}

		if (isset($this->post_wacko_action['p']))
		{
			// #2. find all <a></a><p...> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<a name=\"(p[0-9]+-[0-9]+)\"></a><p([^>]+)>(.+?)</p>)!is",
				array(&$this, 'numerate_toc_callback_p'), $what);
		}

		return $what;
	}

	function numerate_toc_callback_toc($matches)
	{
		return '<a name="'.$matches[2].'"></a><h'.$matches[3].'>'.
			(isset($this->post_wacko_toc_hash[$matches[2]][1])
				? $this->post_wacko_toc_hash[$matches[2]][1]
				: $matches[4]).
			'</h'.$matches[3].'>';
	}

	function numerate_toc_callback_p($matches)
	{
		$before	= '';
		$after	= '';

		if (!($style = $this->paragrafica_styles[$this->post_wacko_action['p']]))
		{
			$this->post_wacko_action['p'] = 'before';
			$style = $this->paragrafica_styles['before'];
		}

		$len	= strlen($this->post_wacko_maxp);
		$link	= '<a href="#'.$matches[2].'">'.
			str_pad($this->post_wacko_toc_hash[$matches[2]][66], $len, '0', STR_PAD_LEFT).
			'</a>';

		foreach ($this->paragrafica_patches[$this->post_wacko_action['p']] as $v)
		{
			$style[$v] = str_replace('##', $link, $style[$v]);
		}

		return $style['_before'].'<a name="'.$matches[2].'"></a><p'.$matches[3].'>'.
			$style['before'].$matches[4].$style['after'].
			'</p>'.$style['_after'];
	}

	// BREADCRUMBS -- additional navigation added with WackoClusters
	function get_page_path($titles = false, $separator = '/', $linking = true, $root_page = false)
	{
		$result		= '';
		$_root_page	= '';

		// check if current page is home page
		if ($this->config['root_page'] == $this->tag)
		{
			$_root_page = true;
		}

		// adds home page in front of breadcrumbs or current page is home page
		if ($_root_page == true || $root_page == true)
		{
			$result .= $this->compose_link_to_page($this->config['root_page']).($_root_page == true ? '' : ' '.$separator.' ');
		}

		if ($_root_page == false)
		{
			$steps		= explode('/', $this->tag);
			$links		= array();

			for ($i = 0; $i < count($steps) -1; $i++)
			{
				if ($i == 0)
				{
					$prev = '';
				}
				else
				{
					$prev = $links[$i - 1].'/';
				}

				$links[] = $prev.$steps[$i];
			}

			# camel case'ing
			$linktext = preg_replace('([A-Z][a-z])', ' ${0}', $steps[$i]);

			for ($i = 0; $i < count($steps) -1; $i++)
			{
				if ($titles == false)
				{
					$result .= $this->link($links[$i], '', $steps[$i]).$separator;
				}
				else if ($linking == true)
				{
					$result .= $this->link($links[$i], '', $this->get_page_title($steps[$i])).$separator;
				}
				else
				{
					$result .= $this->get_page_title($links[$i]).' '.$separator.' ';
				}
			}

			if ($titles == false)
			{
				$result .= $steps[count($steps) - 1];
			}
			else
			{
				$result .= $this->get_page_title($this->tag);
			}
		}

		return $result;
	}

	// $page_id is preferred, $tag next
	function get_page_title($tag = '', $page_id = 0)
	{
		if ($tag)
		{
			$tag = trim($tag, '/');
		}

		if ($tag == true || $page_id != 0)
		{
			$page = $this->load_single(
				"SELECT title ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE ".( $page_id != 0
					? "page_id	= '".quote($this->dblink, (int)$page_id)."' "
					: "tag	= '".quote($this->dblink, $tag)."' " ).
				"LIMIT 1");

			if ($page['title'] == true)
			{
				return $page['title'];
			}
			else
			{
				return $this->add_spaces_title(trim(substr($tag, strrpos($tag, '/')), '/'));
			}
		}
		else if ($tag == false && $this->page == true)
		{
			return $this->page['title'];
		}
		else if ($tag == false && $this->page == false)
		{
			return $this->add_spaces_title(trim(substr($this->tag, strrpos($this->tag, '/')), '/'));
		}
	}

	// CLONE / RENAMING / MOVING

	function clone_page($tag, $clone_tag, $clone_supertag = '', $edit_note)
	{
		if (!$tag || !$clone_tag)
		{
			return false;
		}

		if ($clone_supertag == '')
		{
			$clone_supertag = $this->npj_translit($clone_tag);
		}

		// load page and site information
		$page = $this->load_page($tag);
		$new = $clone_tag;

		return
			// save
			$this->save_page($new, $title = $page['title'], $page['body'], $edit_note, $minor_edit = 0, $reviewed = 0, $comment_on_id = 0, $lang = $page['lang'], $mute = false, $user = false);
	}

	function rename_page($tag, $new_tag, $new_supertag = '')
	{
		if (!$tag || !$new_tag)
		{
			return false;
		}

		if ($new_supertag == '')
		{
			$new_supertag = $this->npj_translit($new_tag);
		}

		return
			$this->query(
				"UPDATE ".$this->config['table_prefix']."revision SET ".
					"tag		= '".quote($this->dblink, $new_tag)."', ".
					"supertag	= '".quote($this->dblink, $new_supertag)."' ".
				"WHERE tag		= '".quote($this->dblink, $tag)."' ")
			&&
			$this->query(
				"UPDATE ".$this->config['table_prefix']."page  SET ".
					"tag		= '".quote($this->dblink, $new_tag)."', ".
					"supertag	= '".quote($this->dblink, $new_supertag)."' ".
				"WHERE tag		= '".quote($this->dblink, $tag)."' ");
	}

	// REMOVALS
	function remove_acls($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE a.* ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (a.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_page($tag, $comment_on_id = 0, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		// store a copy in revision
		if ($this->config['store_deleted_pages'] && !$dontkeep)
		{
			// loading page
			$page = $this->load_page($tag);

			// unlink comment tag
			if ($page['comment_on_id'] != 0)
			{
				$page['comment_on_id']	= 0;
			}

			// saving original
			$this->save_revision($page);

			// saving updated for the current user
			$page['modified']	= date(SQL_DATE_FORMAT);
			$page['user']		= $this->get_user_name();
			$page['ip']			= $this->get_user_ip();
			$this->save_revision($page);
		}

		// delete page
		$this->query(
			"DELETE FROM ".$this->config['table_prefix']."page ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ");

		// for removed comment correct comments count and date on commented page
		if ($comment_on_id)
		{
			// load latest comment
			$comment = $this->load_single(
				"SELECT created ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE comment_on_id = '".quote($this->dblink, $comment_on_id)."' ".
				"ORDER BY created DESC ".
				"LIMIT 1");

			$this->query(
				"UPDATE {$this->config['table_prefix']}page SET ".
					"comments	= '".(int)$this->count_comments($comment_on_id)."', ".
					"commented	= '".quote($this->dblink, $comment['created'])."' ".
				"WHERE page_id	= '".quote($this->dblink, $comment_on_id)."' ".
				"LIMIT 1");
		}

		return true;
	}

	function remove_revisions($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE FROM {$this->config['table_prefix']}revision ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_comments($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		if ($comments = $this->load_all(
		"SELECT a.tag FROM ".$this->config['table_prefix']."page a ".
			"INNER JOIN ".$this->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
		"WHERE b.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' "))
		{
			foreach ($comments as $comment)
			{
				$this->remove_page($comment['tag'], '', $dontkeep);
			}
		}

		// reset comments count
		$this->query(
			"UPDATE {$this->config['table_prefix']}page SET ".
				"comments	= '0', ".
				"commented	= created ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		return true;
	}

	function remove_bookmarks($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE b.* ".
			"FROM ".$this->config['table_prefix']."bookmark b ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (b.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_watches($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE w.* ".
			"FROM ".$this->config['table_prefix']."watch w ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (w.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_ratings($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$ids = $this->load_all(
			"SELECT page_id FROM {$this->config['table_prefix']}page ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		foreach ($ids as $id)
		{
			$this->query(
				"DELETE FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = '{$id['page_id']}'");
		}
		return true;
	}

	function remove_links($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE l.* ".
			"FROM ".$this->config['table_prefix']."link l ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (l.from_page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_categories($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$this->query(
			"DELETE k.* ".
			"FROM {$this->config['table_prefix']}category_page k ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (k.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		return true;
	}

	function remove_referrers($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->query(
			"DELETE ".
				"r.* ".
			"FROM ".
				$this->config['table_prefix']."referrer r ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (r.page_id = p.page_id) ".
			"WHERE ".
				"p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function remove_files($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->load_all(
			"SELECT page_id ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->load_all(
				"SELECT file_name ".
				"FROM {$this->config['table_prefix']}upload ".
				"WHERE page_id = '".quote($this->dblink, $page['page_id'])."'");

			foreach ($files as $file)
			{
				// remove from FS
				$file_name = $this->config['upload_path_per_page'].'/@'.
					$page['page_id'].'@'.$file['file_name'];
				@unlink($file_name);
			}
			// remove from DB
			$this->query(
				"DELETE FROM {$this->config['table_prefix']}upload ".
				"WHERE page_id = '".quote($this->dblink, $page['page_id'])."'");
		}
		return true;
	}

	// ADDITIONAL METHODS

	// run checks of password complexity under current
	// config settings; returned error codes (or a sum of):
	//		1 = password contains login
	//		2 = not enough chars
	//		5 = too weak (chars classes requirement)
	//		0 (false) = good password
	function password_complexity($login, $pwd)
	{
		$unlike_login	= $this->config['pwd_unlike_login'];
		$char_classes	= $this->config['pwd_char_classes'];
		$min_chars		= $this->config['pwd_min_chars'];
		$error			= 0;

		$l = strlen($login);
		$p = strlen($pwd);

		if ($l == 0 || $p == 0)
		{
			$r = 0;
		}
		else
		{
			$r = ($p > $l ? $p / $l : $l / $p);
		}

		// check if password is like a login or contains login string
		switch ($unlike_login)
		{
			case 2:	// don't run this check if login is much shorter than password or vice versa
				if (($l > 4 && $p > 4) && $r < 4)
				{
					if (stristr($login, $pwd) !== false || stristr($pwd, $login) !== false)
					{
						$error += 1;
						break;
					}
				}
			case 1:
				if (strcasecmp($login, $pwd) === 0)
				{
					$error += 1;
				}
		}

		// check password length
		if ($p < $min_chars)
		{
			$error += 2;
		}

		// check character classes requirements
		switch ($char_classes)
		{
			case 1:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[a-zA-Zà-ÿÀ-ß]+/', $pwd))
				{
					$error += 5;
				}
				break;

			case 2:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd))
				{
					$error += 5;
				}
				break;

			case 3:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd) ||
					!preg_match('/[\W]+/', $pwd))
				{
					$error += 5;
				}
				break;
		}
		return $error;
	}


	// Generate random password of defined $length that satisfise the complexity rules:
	// containing n>0 of uppercase ($uc), lowercase ($lc), digits ($di) and symbols ($sy).
	// The password complexity can be defined in $pwd_complexity :
	// $pwd_complexity = 2 -- password consists of uppercase, lowercase, digits
	// $pwd_complexity = 3 -- password consists of uppercase, lowercase, digits and symbols
	function random_password($length, $pwd_complexity)
	{
		$chars_uc	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars_lc	= 'abcdefghijklmnopqrstuvwxyz';
		$digits		= '0123456789';
		$symbols	= '-_!@#%^&*(){}[]|~'; // removed '$'
		$uc = 0;
		$lc = 0;
		$di = 0;
		$sy = 0;

		if ($pwd_complexity == 2)
		{
			$sy = 100;
		}

		while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0)
		{
			$password = '';

			for ($i = 0; $i < $length; $i++)
			{
				$k = rand(0, $pwd_complexity); //randomly choose what's next

				if ($k == 0)
				{
					//uppercase
					$password .= substr(str_shuffle($chars_uc), rand(0, sizeof($chars_uc) - 2), 1);
					$uc++;
				}
				if ($k == 1)
				{
					//lowercase
					$password .= substr(str_shuffle($chars_lc), rand(0, sizeof($chars_lc) - 2), 1);
					$lc++;
				}
				if ($k == 2)
				{
					//digits
					$password .= substr(str_shuffle($digits), rand(0, sizeof($digits) - 2), 1);
					$di++;
				}
				if ($k == 3)
				{
					//symbols
					$password .= substr(str_shuffle($symbols), rand(0, sizeof($symbols) - 2), 1);
					$sy++;
				}
			}
		}

		return $password;
	}

	// pages listing/navigation for multipage lists.
	// 		$total		= total elements in the list
	// 		$perpage	= total elements on a page
	// 		$name		= page number variable in $_GET
	// 		$params		= $_GET parameters to be passed with the page link
	// returns an array with 'text' (navigation) and 'offset' (offset value
	// for SQL queries) elements.
	function pagination($total, $perpage = 100, $name = 'p', $params = '', $method = '', $tag = '')
	{
		if ($perpage == 0)
		{
			$perpage = 10; // no division by zero
		}

		$sep	= ', ';		// page links divider
		$pages	= ceil($total / $perpage);
		$page	= ((isset($_GET[$name])) && $_GET[$name] == true			// if page param = 'last' magic word,
					? ($_GET[$name] == 'last'	// then open last page of the list
						? ($pages > 0
							? $pages
							: 1)
						: (int)$_GET[$name])
					: 1);

		$pagination['offset'] = $perpage * ($page - 1);

		// display navigation if there are pages to navigate in
		if ($pages > 1)
		{
			$pagination['text'] = $this->get_translation('ToThePage').': ';

			// prev page shortcut
			if ($page < 2)
			{
				$pagination['text'] .= '';
			}
			else
			{
				$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.($page - 1).( $params == true ? '&amp;'.$params : '' )).'">&laquo; '.$this->get_translation('PrevAcr').'</a>';
			}

			// pages range links
			if ($pages <= 10)	// not so many pages
			{
				for ($p = 1; $p <= $pages; $p++)
				{
					if ($p != $page)
					{
						$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
					}
					else	// don't make link for the current page
					{
						$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
					}
				}
			}
			else	// really many pages!
			{
				if ($page <= 4 || $page > ($pages - 4))	// current page is near the beginning or the end
				{
					// first pages
					for ($p = 1; $p <= 5; $p++)
					{
						if ($p != $page)
						{
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
						}
						else	// don't make link for the current page
						{
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
						}
					}

					// middle skipped
					$pagination['text'] .= ' ... ,';

					// last pages
					for ($p = ($pages - 4); $p <= $pages; $p++)
					{
						if ($p != $page)
						{
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
						}
						else	// don't make link for the current page
						{
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
						}
					}
				}
				else	// current page is in the middle of the list
				{
					// first page
					$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'=1'.( $params == true ? '&amp;'.$params : '' )).'">1</a>'.$sep.' ... '.$sep;

					// middle pages
					for ($p = ($page - 2); $p <= ($page + 2); $p++)
					{
						if ($p != $page)
						{
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>,';
						}
						else	// don't make link for the current page
						{
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.$sep;
						}
					}

					// last page
					$pagination['text'] .= ' ... '.$sep.'<a href="'.$this->href($method, $tag, $name.'='.$pages.( $params == true ? '&amp;'.$params : '' )).'">'.$pages.'</a>';
				}
			}

			// next page shortcut
			if ($page >= $pages)
			{
				$pagination['text'] .= '';
			}
			else
			{
				$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.($page + 1).( $params == true ? '&amp;'.$params : '' )).'">'.$this->get_translation('NextAcr').' &raquo;</a>';
			}
		}

		return $pagination;
	}

	// log event into the system journal. $message may use wiki
	// syntax, however if used before locale translations registration,
	// will be saved in plain text only.
	// $level denotes event priority with 1 = highest.
	// event classes are:
	//		1. critical	- admin action, object deletion, suspected
	//					  hacking attempt
	//		2. highest	- locking, acl change, unsuccessful user login
	//		3. high		- page renaming/moving/splitting/merging,
	//					  user password change/reminder, successful
	//					  user login
	//		4. medium	- page creation (settings change), poll action,
	//					  file upload, pm sending, user registration and
	//					  email activation, page ownership claim
	//		5. low		- comment posting, user logout
	//		6. lowest	- page edit, user settings update
	//		7. debugging- everything, where logging is necessary
	function log($level, $message)
	{
		// check input
		if (!is_numeric($level))
		{
			return false;
		}

		// check event level: do we have to log it?
		if ((int)$this->config['log_level'] === 0 ||
		((int)$this->config['log_level'] !== 7 &&
		$level > (int)$this->config['log_level']))
		{
			return true;
		}

		$html		= $this->config['allow_rawhtml'];
		$this->config['allow_rawhtml'] = 0;
		$message	= ( isset($this->language) ? $this->format($message, 'wacko') : $message );
		$user_id	= $this->get_user_id();
		$this->config['allow_rawhtml'] = $html;

		// current timestamp set automatically
		return $this->query(
			"INSERT INTO {$this->config['table_prefix']}log SET ".
				"level		= '".quote($this->dblink, $level)."', ".
				"user_id	= '".quote($this->dblink, $user_id ? $user_id : 0 )."', ".
				"ip			= '".quote($this->dblink, $this->get_user_ip())."', ".
				"message	= '".quote($this->dblink, $message)."'");
	}

	// load categories for the page's particular language.
	// if root string value is passed, returns number of
	// pages under each category and below defined root
	// page
	function get_categories_list($lang, $cache = 1, $root = false)
	{
		if ($_categories = $this->load_all(
		"SELECT category_id, parent, category ".
		"FROM {$this->config['table_prefix']}category ".
		"WHERE lang = '".quote($this->dblink, $lang)."' ".
		"ORDER BY parent ASC, category ASC", $cache))
		{
			// process pages count (if have to)
			if ($root !== false)
			{
				if ($_counts = $this->load_all(
				"SELECT kp.category_id, COUNT( kp.page_id ) AS n ".
				"FROM {$this->config['table_prefix']}category k , ".
					"{$this->config['table_prefix']}category_page kp ".
					( $root != ''
						? "INNER JOIN ".$this->config['table_prefix']."page p ON (kp.page_id = p.page_id) "
						: '' ).
				"WHERE k.lang = '".quote($this->dblink, $lang)."' AND kp.category_id = k.category_id ".
					( $root != ''
						? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) "
						: '' ).
				"GROUP BY category_id", 1))
				{
					foreach ($_counts as $count)
					{
						$counts[$count['category_id']] = $count['n'];
					}
				}
			}

			// process categories names
			foreach ($_categories as $word)
			{
				$categories[$word['category_id']] = array(
					'parent'	=> $word['parent'],
					'category'	=> $word['category'],
					'n'			=> (isset($counts[$word['category_id']]) ? $counts[$word['category_id']] : '')
				);
			}

			foreach ($categories as $id => $word)
			{
				if (isset($categories[$word['parent']]))
				{
					$categories[$word['parent']]['childs'][$id] = $word;
					unset($categories[$id]);
				}
			}

			return $categories;
		}
		else
		{
			return false;
		}
	}

	// save categories selected in webform. ids are
	// passed through POST global array. returns:
	//	true	- if something was saved
	//	false	- if list was empty
	function save_categories_list($page_id, $dryrun = 0)
	{
		$set = '';

		// what's selected
		foreach ($_POST as $key => $val)
		{
			if (preg_match('/^category([0-9]+)\|([0-9]+)$/', $key, $ids) && $val == 'set')
			{
				$set[] = $ids[1];

				if ($ids[2] != 0 && !in_array($ids[2], $set))
				{
					$set[] = $ids[2];
				}
			}
		}

		// update list if any
		if ($set)
		{
			if (!$dryrun)
			{
				foreach ($set as $id)
				{
					$values[] = "(".quote($this->dblink, (int)$id).", '".quote($this->dblink, $page_id)."')";
				}

				$this->query(
					"INSERT INTO {$this->config['table_prefix']}category_page (category_id, page_id) ".
					"VALUES ".implode(', ', $values));
			}

			return true;
		}
		else
		{
			return false;
		}
	}

	function binary_multiples($size, $praefix = true, $short = true, $rounded = false)
	{
		if(is_numeric($size))
		{
			if($praefix === true)
			{
				// Decimal prefix
				if($short === true)
				{
					$norm = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				}
				else
				{
					$norm = array('Byte', 'Kilobyte', 'Megabyte', 'Gigabyte', 'Terabyte', 'Petabyte', 'Exabyte', 'Zettabyte', 'Yottabyte');
				}

				$factor = 1000;
			}
			else
			{
				// Binary prefix
				if($short === true)
				{
					$norm = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
				}
				else
				{
					$norm = array('Byte', 'Kibibyte', 'Mebibyte', 'Gibibyte', 'Tebibyte', 'Pebibyte', 'Exbibyte', 'Zebibyte', 'Yobibyte');
				}

				$factor = 1024;
			}

			$count	= count($norm) -1;
			$x		= 0;

			while ($size >= $factor && $x < $count)
			{
				$size /= $factor;
				$x++;
			}

			// TODO: $this->get_translation($norm[$x])
			if ($rounded === true)
			{
				$size = round($size, 0) . '&nbsp;' . $norm[$x];
			}
			else
			{
				$size = sprintf('%01.2f', $size) . '&nbsp;' . $norm[$x];
			}

			return $size;
		}
	}

	function debug_print_r ($array)
	{
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}

}

?>