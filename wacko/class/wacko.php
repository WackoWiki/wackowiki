<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

// engine class
class Wacko
{
	var $config;							// @deprecated, but will live for a looong time
	var $db;								// new config
	var $http;
	var $sess;
	var $dblink;
	var $page;								// Requested page
	var $tag;
	var $supertag;
	var $forum					= false;
	var $categories;
	var $is_watched				= false;
	var $hide_revisions			= false;
	var $_acl					= array();
	var $acl_cache				= array();
	var $page_id_cache			= array();
	var $context				= array();	// Page context. Uses for correct processing of inclusions
	var $current_context		= 0;		// Current context level
	var $header_count			= 0;
	var $page_meta				= 'page_id, owner_id, user_id, tag, supertag, created, modified, edit_note, minor_edit, latest, handler, comment_on_id, page_lang, title, keywords, description';
	var $first_inclusion		= array();	// for backlinks
	var $format_safe			= true;		// for htmlspecialchars() in pre_link
	var $unicode_entities		= array();	// common unicode array
	var $timer;
	var $toc_context			= array();
	var $search_engines			= array('bot', 'rambler', 'yandex', 'crawl', 'search', 'archiver', 'slurp', 'aport', 'crawler', 'google', 'inktomi', 'spider', );
	var $languages				= null;
	var $translations			= null;
	var $wanted_cache			= null;
	var $page_cache				= null;
	var $_formatter_noautolinks	= null;
	var $numerate_links			= null;
	var $post_wacko_action		= null;
	var $html_head				= '';
	var $hide_article_header	= false;
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
	var $translit_macros = array(
		'âèêè' => 'wiki', 'âàêà' => 'wacko', 'âåá' => 'web'
	);
	var $time_intervals = array(
		30*DAYSECS => 'Month',
		7*DAYSECS => 'Week',
		DAYSECS => 'Day',
		60*60 => 'Hour',
		60 => 'Minute'
	);

	/**
	* CONSTRUCTOR
	*
	* Crates an instance of Wacko object
	* @param array $config Current configuration as map key=value
	* @return Wacko
	*/
	function __construct(&$config, &$http)
	{
		$this->timer	= microtime(1);
		$this->dblink	=						// for quote() calls
		$this->db		=
		$this->config	= & $config;
		$this->http		= & $http;
		$this->sess		= & $http->session;
	}

	// DATABASE
	// STS: backward compat
	function sql_query($query, $debug = 0)
	{
		return $this->dblink->sql_query($query, $debug);
	}

	function load_all($query, $docache = false)
	{
		return $this->dblink->load_all($query, $docache);
	}

	function load_single($query, $docache = false)
	{
		return $this->dblink->load_single($query, $docache);
	}

	function q($data)
	{
		return $this->dblink->q($data);
	}

	// MISC
	function get_page_tag($page_id = 0)
	{
		$page = $this->load_single(
			"SELECT tag ".
			"FROM ".$this->config['table_prefix']."page ".
			"WHERE page_id = '".(int)$page_id."' ".
			"LIMIT 1");

		return $page['tag'];
	}

	function get_page_id($tag = '')
	{
		if (!$tag)
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

	/**
	* Check if file with filename exists. Check only DB entry,
	* not file in FS
	* @param string $file_name Filename
	* @param string $unwrapped_tag Optional. Unwrapped supertag. If
	* not set, then check if file exists in global space
	* @param boolean $deleted
	* @return array File description array
	*/
	function check_file_exists($file_name, $unwrapped_tag = '', $deleted = 0)
	{
		if (!$unwrapped_tag)
		{
			$page_id = 0;
		}
		else if (($page = $this->load_page($unwrapped_tag, 0, '', LOAD_CACHE, LOAD_META)))
		{
			$page_id = $page['page_id'];
		}
		else
		{
			return false;
		}

		$file = &$this->files_cache[$page_id][$file_name];
		if (empty($file))
		{
			$file = $this->load_single(
				"SELECT upload_id, page_id, user_id, file_name, file_size, upload_lang, file_description, picture_w, picture_h, file_ext ".
				"FROM ".$this->config['table_prefix']."upload ".
				"WHERE page_id = '".(int)$page_id."' ".
					"AND file_name = '".quote($this->dblink, $file_name)."' ".
					($deleted != 1
						? "AND deleted <> '1' "
						: "").
				"LIMIT 1");
		}

		return $file;
	}

	function upload_quota($user_id = '')
	{
		// get used upload quota
		$files	= $this->load_single(
				"SELECT SUM(file_size) AS used_quota ".
				"FROM ".$this->config['table_prefix']."upload ".
					($user_id
						? "WHERE user_id = '{$user_id}' "
						: "").
				"LIMIT 1");

		$used_upload_quota = $files['used_quota'];

		return $used_upload_quota;
	}

	function available_themes()
	{
		$theme_list	= [];

		foreach (Ut::file_glob(THEME_DIR, '*/appearance/header.php') as $file)
		{
			$theme = substr($file, strlen(THEME_DIR) + 1);
			$theme = substr($theme, 0, strpos($theme, '/'));
			$theme_list[] = $theme;
		}

		sort($theme_list, SORT_STRING);

		if (($allow = preg_split('/[\s,]+/', $this->config->allow_themes, -1, PREG_SPLIT_NO_EMPTY)) && $allow[0])
		{
			$theme_list = array_intersect($theme_list, $allow);
		}

		return $theme_list;
	}

	// TIME FUNCTIONS
	function get_time_tz($time)
	{
		$user			= $this->get_user();
		$timezone		= isset($user['timezone'])	? $user['timezone']	: $this->config['timezone'];
		$dst			= isset($user['dst'])		? $user['dst']		: $this->config['dst'];
		$zone_offset	= ($timezone * 3600) + ($dst * 3600);
		$tz_time		= $time + $zone_offset - date('Z');

		return $tz_time;
	}

	function get_time_formatted($time)
	{
		return $this->get_unix_time_formatted(strtotime($time));
	}

	function get_unix_time_formatted($time)
	{
		$tz_time = $this->get_time_tz($time);

		return date($this->config['date_format'].' '.
			$this->config['time_format_seconds'], $tz_time);
	}

	function get_time_interval($ago, $strip = false)
	{
		$res = 0 . $this->get_translation('FeedMinutesAgo');

		foreach ($this->time_intervals as $val => $name)
		{
			if ($ago >= $val)
			{
				$interval = ($ago - $ago % $val) / $val;
				$res = $interval . $this->get_translation('Feed'.$name.($interval == 1? '' : 's').'Ago');
				break;
			}
		}

		if ($strip)
		{
			// STS: hack! need to patch language files...
			$res = substr($res, 0, strrpos($res, ' '));
		}

		return $res;

	}

	// LANG FUNCTIONS
	function set_translation($lang)
	{
		$this->resource = & $this->translations[$lang];
	}

	function set_language($lang, $set_translation = false)
	{
		$old_lang	= @$this->language['LANG'];
		$lang_list	= $this->available_languages();

		if ($old_lang != $lang && isset($lang_list[$lang]))
		{
			$this->load_translation($lang);
			$this->language = &$this->languages[$lang];

			setlocale(LC_CTYPE, $this->language['locale']);

			$this->language['locale'] = setlocale(LC_CTYPE, 0);
		}

		if ($set_translation)
		{
			$this->set_translation($this->language['LANG']);
		}

		return $old_lang;
	}

	// TODO: refactor / normalize # better load_message_set() ?
	function load_translation($lang)
	{
		if ($lang && !isset($this->translations[$lang]))
		{
			// wacko.xy.php $wacko_translation[]
			$wacko_translation = [];
			$lang_file = Ut::join_path(LANG_DIR, 'wacko.'.$lang.'.php');

			if (@file_exists($lang_file))
			{
				include($lang_file);
			}

			// wacko.all.php $wacko_all_resource[]
			if (!isset($this->translations['all']))
			{
				$wacko_all_resource = [];
				$lang_file = Ut::join_path(LANG_DIR, 'wacko.all.php');

				if (@file_exists($lang_file))
				{
					include($lang_file);
				}

				// stored in object required for merge with all language files,
				// but not with multilanguages off
				$this->translations['all'] = & $wacko_all_resource;
			}

			$ap_translation = [];
			$theme_translation = [];
			$theme_translation0 = [];

			if ($this->config['ap_mode'])
			{
				// ap.xy.php $ap_translation[]
				$lang_file = 'admin/lang/ap.'.$lang.'.php';

				if (@file_exists($lang_file))
				{
					include($lang_file);
				}
			}
			else
			{
				// TODO: only FIRST theme's language loaded.... need to fix for multi-themed sites w/ nonempty theme lang files
				// theme lang files $theme_translation[]
				$lang_file = Ut::join_path(THEME_DIR, $this->config['theme'], 'lang/wacko.'.$lang.'.php');

				if (@file_exists($lang_file))
				{
					include($lang_file);
				}

				$theme_translation0 = $theme_translation;

				// wacko.all theme
				$theme_translation = [];
				$lang_file = Ut::join_path(THEME_DIR, $this->config['theme'], 'lang/wacko.all.php');

				if (@file_exists($lang_file))
				{
					include($lang_file);
				}
			}

			$this->translations[$lang] = array_merge(
				$wacko_translation,
				$this->translations['all'],
				$ap_translation,
				$theme_translation0,
				$theme_translation);

			$this->load_lang($lang);
		}
	}

	/**
	* Loads language file from lang/lang.<lang>.php.
	* @param string $lang Language code
	*/
	function load_lang($lang)
	{
		if ($lang && !isset($this->languages[$lang]))
		{
			$lang_file = Ut::join_path(LANG_DIR, 'lang.' . $lang . '.php');
			$wacko_language = [];
			require($lang_file);

			$wacko_language['LANG']			= $lang;
			$wacko_language['UPPER']		= '[' . $wacko_language['UPPER_P'] . ']';
			$wacko_language['UPPERNUM']		= '[0-9' . $wacko_language['UPPER_P'] . ']';
			$wacko_language['LOWER']		= '[' . $wacko_language['LOWER_P'] . ']';
			$wacko_language['ALPHA']		= '[' . $wacko_language['ALPHA_P'] . ']';
			$wacko_language['ALPHANUM_P']	= '0-9' . $wacko_language['ALPHA_P'];
			$wacko_language['ALPHANUM']		= '[' . $wacko_language['ALPHANUM_P'] . ']';

			$this->languages[$lang] = $wacko_language;

			if (($ue = @array_flip($wacko_language['unicode_entities'])))
			{
				$this->unicode_entities = array_merge($this->unicode_entities, $ue);
			}

			unset($this->unicode_entities[0]);
		}
	}

	/**
	* Get array of available resource translations
	*
	* @param bool $subset, true for allowed_languages only
	* @return Array of language codes
	*/
	function available_languages($subset = true)
	{
		$lang_list = &$this->sess->available_languages;

		if (!isset($lang_list))
		{
			$list = [];

			foreach (Ut::file_glob(LANG_DIR, 'wacko.[a-z][a-z].php') as $file)
			{
				$lang = substr($file, -6, 2);
				$list[$lang] = $lang;
			}

			ksort($list, SORT_STRING);
			$lang_list[false] = $list;

			if (($allow = preg_split('/[\s,]+/', $this->db->allowed_languages, -1, PREG_SPLIT_NO_EMPTY)) && $allow[0])
			{
				$list = array_intersect($list, $allow);
			}

			if (!isset($list[$this->db->language]))
			{
				die('WackoWiki system language is unavailable');
			}

			$lang_list[true] = $list;
		}

		return $lang_list[!!$subset];
	}

	// negotiate language with user's browser
	function user_agent_language()
	{
		$lang = $this->config['language'];

		if ($this->config['multilanguage'] && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$lang_list = $this->available_languages();

			// http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
			preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" .
					"(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/",
					strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']),
					$matches, PREG_SET_ORDER);

			$best = 0;

			foreach ($matches as $i)
			{
				$want1 = $want2 = $i[1];

				if ($i[3])
				{
					$want2 = $want1 . '-' . $i[3];
				}

				$q = ($i[5] !== '')? (float)$i[5] : 1;

				if (isset($lang_list[$want2]) && $q > $best)
				{
					$lang = $want2;
					$best = $q;
				}
				else if (isset($lang_list[$want1]) && $q * 0.9 > $best)
				{
					$lang = $want1;
					$best = $q * 0.9;
				}
			}
		}

		return $lang;
	}

	function get_user_language()
	{
		$user = $this->get_user();
		$lang = @$user['user_lang'];
		$lang_list = $this->available_languages();

		if (!isset($lang_list[$lang]))
		{
			$lang = $this->user_agent_language();
		}
		return $lang;
	}

	function get_translation($name, $lang = '', $dounicode = true)
	{
		if ($this->db->multilanguage)
		{
			if ($lang === -1) // shortcut for using system language diags
			{
				$lang = $this->db->language;
			}

			if (!$lang && (isset($this->user_lang) && $this->user_lang != $this->page_lang))
			{
				$lang = $this->user_lang;
			}

			if ($lang)
			{
				$this->load_translation($lang);

				if (($text = @$this->translations[$lang][$name]))
				{
					if ($dounicode)
					{
						if (is_array($text))
						{
							foreach ($text as &$one)
							{
								$one = $this->do_unicode_entities($one, $lang);
							}
						}
						else
						{
							$text = $this->do_unicode_entities($text, $lang);
						}
					}
					return $text;
				}
			}
		}

		if (isset($this->resource[$name]))
		{
			return $this->resource[$name];
		}

		// NB: must return NULL if no translation available, it's API
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
		if (@$this->method === 'edit' && @$_GET['add'] == 1)
		{
			$lang = @$_REQUEST['lang'];
		}
		else
		{
			$lang = @$this->page_lang;
		}

		$lang_list = $this->available_languages();
		if (!isset($lang_list[$lang]))
		{
			$lang = $this->get_user_language();
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

	function get_charset($lang = '')
	{
		if (!$lang)
		{
			$lang = $this->determine_lang();
		}

		$this->load_lang($lang);

		return @$this->languages[$lang]['charset'];
	}

	/**
	* Replace symbols in $string to their Html Unicode entity
	*
	* @param string $string Input string
	* @param string $lang Target language code
	* @return string Converted string
	*/
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

		if (isset($this->languages[$lang]['unicode_entities']) && is_array($this->languages[$lang]['unicode_entities']))
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
		$decrement	= array();
		$shift		= array();

		// array used to figure what number to decrement from character order value
		// according to number of characters used to map unicode to ascii by utf-8
		$decrement[4] = 240;
		$decrement[3] = 224;
		$decrement[2] = 192;
		$decrement[1] = 0;

		// the number of bits to shift each char_num by
		$shift[1][0] = 0;
		$shift[2][0] = 6;
		$shift[2][1] = 0;
		$shift[3][0] = 12;
		$shift[3][1] = 6;
		$shift[3][2] = 0;
		$shift[4][0] = 18;
		$shift[4][1] = 12;
		$shift[4][2] = 6;
		$shift[4][3] = 0;

		$pos			= 0;
		$len			= strlen ($source);
		$encoded_string	= '';

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
				$this_pos		= 0;
				$decimal_code	= 0;

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

	/**
	* Transliterate tag to supertag
	*
	* @param string $tag
	* @param int $strtolow Change tag case. TRAN_DONTCHANGE - don't change TRAN_LOWERCASE - convert to lowercase
	* @param unknown_type $donotload WTF: doesn't use
	* @return string
	*/
	function translit($tag, $strtolow = TRANSLIT_LOWERCASE, $donotload = TRANSLIT_LOAD)
	{
		// Lookup transliteration result in the cache and return it if found
		static $translit_cache;
		$cach_key = $tag.$strtolow.$donotload;

		if (isset($translit_cache[$cach_key]))
		{
			return $translit_cache[$cach_key];
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

				if (isset($page['page_lang']))
				{
					$lang = $page['page_lang'];
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
			$tag = @strtr($_tag, $this->translit_macros);
		}
		else
		{
			foreach($this->translit_macros as $macro => $value)
			{
				while (($pos = strpos($_tag, $macro)) !== false)
				{
					$_tag	= substr_replace($_tag, $value, $pos, strlen($macro));
					$tag	= substr_replace($tag, ucfirst($value), $pos, strlen($macro));
				}
			}
		}

		$tag = @strtr($tag, $this->language['TranslitLettersFrom'], $this->language['TranslitLettersTo']);
		$tag = @strtr($tag, $this->language['TranslitBiLetters']);

		if ($strtolow)
		{
			$tag = strtolower($tag);
		}

		if ($_lang)
		{
			$this->set_language($_lang);
		}

		$result = rtrim($tag, '/');

		// Put transliteration result in the cache
		$translit_cache[$cach_key] = $result;

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

		return htmlspecialchars($meta_keywords, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
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

		return htmlspecialchars($meta_description, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
	}

	// wrapper for _load_page
	/**
	* Loads page from DB
	*
	* @param string $tag Page tag or supertag
	* @param int $page_id
	* @param int $revision_id
	* @param int $cache If LOAD_CACHE then tries to load page from cache, if LOAD_NOCACHE - then doesn't.
	* @param int $metadataonly If LOAD_ALL loads all page fields, if LOAD_META - only  pages_meta fields.
	* @param boolean $deleted
	* @return array Loaded page
	*/
	function load_page($tag, $page_id = 0, $revision_id = '', $cache = LOAD_CACHE, $metadata_only = LOAD_ALL, $deleted = 0)
	{
		$page = '';
		#echo '@@ '.$tag.' - '.$deleted.'<br />';
		if ($deleted)
		{
			$cache = false;
		}
		else if ($page_id != 0)
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
			$page = $this->_load_page('', $page_id, $revision_id, $cache, false, $metadata_only, $deleted);
		}

		// 2. search for supertag
		if (!$page)
		{
			$page = $this->_load_page($this->translit($tag, TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD), 0, $revision_id, $cache, true, $metadata_only, $deleted);
		}

		// 3. if not found, search for tag
		if (!$page)
		{
			$page = $this->_load_page($tag, 0, $revision_id, $cache, false, $metadata_only, $deleted);
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

	function _load_page($tag, $page_id = 0, $revision_id = '', $cache = true, $supertagged = false, $metadata_only = 0, $deleted = 0)
	{
		#echo '## '.$deleted.'<br />';
		#$deleted = 1;
		$supertag		= '';
		$cached_page	= '';
		$page			= null;

		if ($page_id == 0 && $tag == '')
		{
			return '';
		}

		if ($page_id == 0)
		{
			(!$supertagged
				? $supertag = $this->translit($tag, TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD)
				: $supertag = $tag
			);
		}

		// retrieve from cache
		if (!$revision_id && $cache && ($cached_page = $this->get_cached_page($supertag, $page_id, $metadata_only)))
		{
			$page = $cached_page;
		}

		// load page
		if ($metadata_only)
		{
			$what_p = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, '.
						'p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, '.
						'p.page_lang, p.keywords, p.description, p.noindex, p.deleted, u.user_name, o.user_name AS owner_name';
			$what_r = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.version_id, '.
						'p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, '.
						'p.page_lang, p.keywords, p.description, s.noindex, p.deleted, u.user_name, o.user_name AS owner_name';
		}
		else
		{
			$what_p = 'p.*, u.user_name, o.user_name AS owner_name';
			$what_r = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.version_id, '.
						'p.body, p.body_r, p.formatting, p.edit_note, p.minor_edit, p.reviewed, p.reviewed_time, '.
						'p.reviewer_id, p.ip, p.latest, p.deleted, p.handler, p.comment_on_id, p.page_lang, '.
						'p.description, p.keywords, s.footer_comments, s.footer_files, s.footer_rating, s.hide_toc, '.
						's.hide_index, s.tree_level, s.allow_rawhtml, s.disable_safehtml, s.noindex, s.theme, '.
						'u.user_name, o.user_name AS owner_name';
		}

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
						? "page_id  = '".(int)$page_id."' "
						: "supertag = '".quote($this->dblink, $supertag)."' " ).
						( $deleted != 1
							? "AND p.deleted <> '1' "
							: "").
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id)
				{
					$this->cache_page($page, $page_id, $metadata_only);

					$page = $this->load_single(
						"SELECT p.revision_id, ".$what_r." ".
						"FROM ".$this->config['table_prefix']."revision p ".
							"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."page s ON (p.page_id = s.page_id) ".
						"WHERE ".( $page_id != 0
							? "p.page_id  = '".(int)$page_id."' "
							: "p.supertag = '".quote($this->dblink, $supertag)."' " ).
							( $deleted != 1
								? "AND p.deleted <> '1' "
								: "").
							"AND revision_id = '".(int)$revision_id."' ".
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
						( $deleted != 1
							? "AND p.deleted <> '1' "
							: "").
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id)
				{
					$this->cache_page($page, $page_id, $metadata_only);

					$page = $this->load_single(
						"SELECT ".$what_r." ".
						"FROM ".$this->config['table_prefix']."revision p ".
							"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
							"LEFT JOIN ".$this->config['table_prefix']."page s ON (p.page_id = s.page_id) ".
						"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
							( $deleted != 1
								? "AND p.deleted <> '1' "
								: "").
							"AND revision_id = '".(int)$revision_id."' ".
						"LIMIT 1");

					$page['owner_id'] = $owner_id;
				}
			}
		}

		// cache result
		if (!$revision_id && !$cached_page)
		{
			$this->cache_page($page, $page_id, $metadata_only);
		}

		return $page;
	}

	/**
	* Get page from cache
	*
	* @param string $tag Page tag
	* @param int $page_id
	* @param boolean $metadataonly Returns only page with equal metadataonly marker. Default value is 0.
	* @return mixed Page from cache or FALSE if not found
	*/
	function get_cached_page($supertag, $page_id = 0, $metadata_only = 0)
	{
		if ($page_id != 0)
		{
			if (isset($this->page_cache['page_id'][$page_id]))
			{
				if (isset($this->page_cache['page_id'][$page_id]['mdonly'])
					&& ($this->page_cache['page_id'][$page_id]['mdonly'] == 0 || $metadata_only == $this->page_cache['page_id'][$page_id]['mdonly']))
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
				if ($this->page_cache['supertag'][$supertag]['mdonly'] == 0 || $metadata_only == $this->page_cache['supertag'][$supertag]['mdonly'])
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

	/**
	* Put page in pageCache.
	*
	* @param array $page Page data
	* @param int $page_id
	* @param boolean $metadataonly Marks that page contains metadata only (all atributes, excepts page body)
	*/
	function cache_page($page, $page_id = 0, $metadata_only = 0)
	{
		#if ($page_id != 0) // cache for both cases to avoid roundtrips
		#{
			$this->page_cache['page_id'][$page['page_id']]				= $page;
			$this->page_cache['page_id'][$page['page_id']]['mdonly']	= $metadata_only;
		#}
		#else
		#{
			if (!$page['supertag'])
			{
				$page['supertag'] = $this->translit($page['tag'], TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD);
			}

			$this->page_cache['supertag'][$page['supertag']]			= $page;
			$this->page_cache['supertag'][$page['supertag']]['mdonly']	= $metadata_only;
		#}
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
		else if ($this->_load_page($tag, $page_id, '', 1, false, 1) == '')
		{
			($page_id != 0
				? $this->wanted_cache['page_id'][$page_id] = 1
				: $this->wanted_cache['tag'][$this->language['code']][$tag] = 1
			);
		}
	}

	/**
	* Clear Wanted cache from tag
	*
	* @param string $tag
	* @param int $page_id
	*/
	function clear_cache_wanted_page($tag, $page_id = 0)
	{
		($page_id != 0
			? $this->wanted_cache['page_id'][$page_id] = 0
			: $this->wanted_cache['tag'][$this->language['code']][$tag] = 0
		);
	}

	/**
	* Check if page is in cache
	*
	* @param unknown_type $tag
	* @param int $page_id
	* @return boolean  Return TRUE if tag in Wanted cache and FALSE if not
	*/
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
		$pages	= '';
		$page_id = array();
		$acl	= '';
		$user	= $this->get_user();
		$lang   = $this->get_user_language();

		// get page links
		if ($links = $this->load_all(
			"SELECT to_tag ".
			"FROM ".$this->config['table_prefix']."link ".
			"WHERE from_page_id = '".$this->page['page_id']."'"))
		{
			foreach ($links as $link)
			{
				$pages[] = $link['to_tag'];
			}
		}

		// get menu links
		if ($menu_items = $this->load_all(
			"SELECT DISTINCT p.tag ".
			"FROM ".$this->config['table_prefix']."menu b ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ON (b.page_id = p.page_id) ".
			// TODO: why IN and not = ??
			"WHERE (b.user_id IN ( '".$this->get_user_id('System')."' ) ".
				($lang
					? "AND b.menu_lang = '".quote($this->dblink, $lang)."' "
					: "").
					") ".
				($user
					? "OR (b.user_id IN ( '".$user['user_id']."' )) "
					: "").
			"", true))
		{
			foreach ($menu_items as $item)
			{
				$pages[] = $item['tag'];
			}
		}

		// get default links
		if(isset($user['user_name']))
		{
			$pages[]	= $this->config['users_page'].'/'.$user['user_name'];
			$pages[]	= $this->get_translation('AccountLink');
		}
		else
		{
			$pages[]	= $this->get_translation('RegistrationPage');
		}

		$pages[]	= $this->config['root_page'];
		$pages[]	= $this->config['users_page'];
		$pages[]	= $this->config['policy_page'];
		$pages[]	= $this->config['permalink_page'];
		$pages[]	= $this->get_translation('LoginPage');
		$pages[]	= $this->get_translation('TextSearchPage');
		$pages[]	= $this->tag;

		#$pages[]	= $this->tag;

		$pages		= array_unique($pages);
		$spages_str	= '';

		foreach ($pages as $page)
		{
			if ($page != '')
			{
				$_spages	= $this->translit($page, TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD);
				$spages[]	= $_spages;
				$spages_str	.= "'".quote($this->dblink, $_spages)."', ";
			}
		}

		$spages_str	= substr($spages_str, 0, strlen($spages_str) - 2);

		if ($links = $this->load_all(
		"SELECT ".$this->page_meta." ".
		"FROM ".$this->config['table_prefix']."page ".
		"WHERE supertag IN (".$spages_str.")", true))
		{
			foreach ($links as $link)
			{
				$this->cache_page($link, 0, 1);
				$this->page_id_cache[$link['tag']] = $link['page_id'];
				$exists[]	= $link['supertag'];
				$page_id[]	= $link['page_id'];
			}
		}

		$notexists = @array_values(@array_diff($spages, $exists));

		foreach ((array)$notexists as $notexist)
		{
			if (isset($pages[array_search($notexist, $spages)]))
			{
				$this->cache_wanted_page($pages[array_search($notexist, $spages)], 0, 1);
				#$this->cache_acl($this->get_page_id($notexist), 'read', 1, $acl);
			}
		}

		$page_ids	= implode(', ', $page_id);

		if ($read_acls = $this->load_all(
		"SELECT page_id, privilege, list ".
		"FROM ".$this->config['table_prefix']."acl ".
		"WHERE page_id IN (".$page_ids.") AND privilege = 'read'", true))
		{
			foreach ($read_acls as $read_acl)
			{
				$this->cache_acl($read_acl['page_id'], 'read', 1, $read_acl);
			}
		}
	}

	function set_page($page)
	{
		$lang_list = $this->available_languages();

		if ($page['deleted'] && !$this->is_admin())
		{
			$page['body']			= '';
			$page['body_r']			= '';
			$page['title']			= '';
			$page['description']	= '';
			$page['keywords']		= '';
			$page['noindex']		= 1;
		}

		$this->page	= $page;

		if ($this->page['tag'])
		{
			$this->tag = $this->page['tag'];
		}

		if ($page['page_lang'] && isset($lang_list[$page['page_lang']]))
		{
			$this->page_lang = $page['page_lang'];
		}
		else if (@$_REQUEST['add'] && isset($lang_list[@$_REQUEST['lang']]))
		{
			$this->page_lang = $_REQUEST['lang'];
		}
		else if (@$_REQUEST['add'])
		{
			$this->page_lang = $this->user_lang;
		}
		else
		{
			$this->page_lang = $this->config['language'];
		}
	}

	// STANDARD QUERIES
	function load_revisions($page_id, $hide_minor_edit = 0, $show_deleted = 0)
	{
		$page_meta = 'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.modified, p.edit_note, p.minor_edit, '.
					 'p.reviewed, p.latest, p.comment_on_id, p.title, u.user_name, o.user_name as reviewer ';

		$revisions = $this->load_all(
			"SELECT p.version_id, p.revision_id, ".$page_meta." ".
			"FROM ".$this->config['table_prefix']."revision p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
			"WHERE p.page_id = '".(int)$page_id."' ".
				($hide_minor_edit
					? "AND p.minor_edit = '0' "
					: "").
				(!$show_deleted
					? "AND p.deleted <> '1' "
					: "").
			"ORDER BY p.modified DESC");

		if ($revisions)
		{
			if (($cur = $this->load_single(
				"SELECT 0 AS revision_id, ".$page_meta." ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
				"WHERE p.page_id = '".(int)$page_id."' ".
					($hide_minor_edit
						? "AND p.minor_edit = '0' "
						: "").
					(!$show_deleted
						? "AND p.deleted <> '1' "
						: "").
				"ORDER BY p.modified DESC ".
				"LIMIT 1")))
			{
				$cur['version_id'] = $revisions[0]['version_id'] + 1;
				array_unshift($revisions, $cur);
			}
		}
		else
		{
			$revisions = $this->load_all(
				"SELECT 1 AS version_id, 0 AS revision_id, ".$page_meta." ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.reviewer_id = o.user_id) ".
				"WHERE p.page_id = '".(int)$page_id."' ".
					(!$show_deleted
						? "AND p.deleted <> '1' "
						: "").
				"ORDER BY p.modified DESC ".
				"LIMIT 1");
		}

		return $revisions;
	}

	function count_revisions($page_id, $hide_minor_edit = 0, $show_deleted = 0)
	{
		$count = $this->load_single(
			"SELECT COUNT(page_id) AS n ".
			"FROM {$this->config->table_prefix}revision ".
			"WHERE page_id = '".(int)$page_id."' ".
				($hide_minor_edit
					? "AND minor_edit = '0' "
					: "").
				(!$show_deleted
					? "AND deleted <> '1' "
					: "").
			"LIMIT 1");

		return $count? $count['n'] : 0;
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
				"(l.to_supertag = '".quote($this->dblink, $this->translit($tag))."') ".
			"ORDER BY tag", true);
	}

	function load_file_usage($file_id, $for = '')
	{
		return $this->load_all(
			"SELECT p.page_id, p.tag AS tag, p.title ".
			"FROM ".$this->config['table_prefix']."file_link l ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (p.page_id = l.page_id) ".
				"INNER JOIN ".$this->config['table_prefix']."upload u ON (u.upload_id = l.file_id) ".
			"WHERE ".($for
					? "p.tag LIKE '".quote($this->dblink, $for)."/%' AND "
					: "").
				"l.file_id = '".(int) $file_id."' ".
			"ORDER BY tag", true);
	}

	function load_changed($limit = 100, $for = '', $from = '', $minor_edit = '', $default_pages = false, $deleted = 0)
	{
		$limit = (int)$limit;

		// count pages
		$count_pages = $this->load_single(
			"SELECT COUNT(p.page_id) AS n ".
			"FROM ".$this->config['table_prefix']."page p ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				($from
					? "AND p.modified <= '".quote($this->dblink, $from)." 23:59:59'"
					: "").
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
					: "").
				($minor_edit
					? "AND p.minor_edit = '0' "
					: "").
				(!$deleted
					? "AND p.deleted <> '1' "
					: "").
				(!$default_pages
					? "AND (u.account_type = '0' OR p.user_id = '0') "
					: "")
			);

		$pagination = $this->pagination($count_pages['n'], $limit);

		if (($pages = $this->load_all(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.title, p.created, p.modified, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.page_lang, u.user_name ".
		"FROM ".$this->config['table_prefix']."page p ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			($from
				? "AND p.modified <= '".quote($this->dblink, $from)." 23:59:59'"
				: "").
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
				: "").
			($minor_edit
				? "AND p.minor_edit = '0' "
				: "").
			(!$deleted
				? "AND p.deleted <> '1' "
				: "").
			(!$default_pages
				? "AND (u.account_type = '0' OR p.user_id = '0') "
				: "").
		"ORDER BY p.modified DESC ".
		"LIMIT {$pagination['offset']}, {$limit}", true)))
		{
			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if (($read_acls = $this->load_all(
			"SELECT a.page_id, a.privilege, a.list ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
					: '').
				"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT {$limit}", true)))
			{
				foreach ($read_acls as $read_acl)
				{
					$this->cache_acl($read_acl['page_id'], 'read', 1, $read_acl);
				}
			}

			return array($pages, $pagination);
		}
	}

	function load_comment($limit = 100, $for = '', $deleted = 0)
	{
		$limit = (int) $limit;

		if ($pages = $this->load_all(
		"SELECT c.page_id, c.owner_id, c.tag, c.supertag, c.title, c.created, c.modified, c.edit_note, c.minor_edit, c.latest, c.handler, c.comment_on_id, c.page_lang, c.body_r, u.user_name, p.title AS page_title, p.tag AS page_tag ".
		"FROM ".$this->config['table_prefix']."page c ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (c.user_id = u.user_id) ".
			"LEFT JOIN ".$this->config['table_prefix']."page p ON (c.comment_on_id = p.page_id) ".
		"WHERE c.comment_on_id <> '0' ".
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
				: "").
			($deleted != 1
				? "AND p.deleted <> '1' AND c.deleted <> '1' "
				: "").
		"ORDER BY c.modified DESC ".
		"LIMIT ".$limit))
		{
			#$count		= count($pages['page_id']);
			#$pagination = $this->pagination($count, $limit);

			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if ($read_acls = $this->load_all(
			"SELECT a.page_id, a.privilege, a.list ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
					($for
						? "AND p.supertag LIKE '".quote($this->dblink, $this->translit($for))."/%' "
						: "").
				"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT {$limit}"))
			{
				foreach ($read_acls as $read_acl)
				{
					$this->cache_acl($read_acl['page_id'], 'read', 1, $read_acl);
				}
			}

			return $pages;
		}
	}

	function load_deleted($limit = 50, $cache = true)
	{
		$deleted = [];
		$pagination	= '';

		$count_deleted = $this->load_single(
			"SELECT COUNT(page_id) AS n ".
			"FROM ".$this->config['table_prefix']."page ".
			"WHERE deleted = '1' LIMIT 1"
			, $cache);

		if ($count_deleted['n'])
		{
			$pagination = $this->pagination($count_deleted['n'], $limit);

			$deleted = $this->load_all(
				"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.created, p.modified, p.edit_note,
						p.minor_edit, p.latest, p.handler, p.comment_on_id, p.page_lang, p.title, p.keywords,
						p.description, u.user_name ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
				"WHERE p.deleted = '1' ".
				"ORDER BY p.modified DESC, p.tag ASC ".
				"LIMIT {$pagination['offset']}, {$limit}", $cache);
		}

		return [$deleted, $pagination];
	}

	function load_categories($tag, $page_id = 0, $cache = false)
	{
		$categories = $this->load_all(
			"SELECT c.category_id, c.category ".
			"FROM {$this->config['table_prefix']}category c ".
				"INNER JOIN {$this->config['table_prefix']}category_page cp ON (c.category_id = cp.category_id) ".
			"WHERE ".( $page_id != 0
				? "cp.page_id  = '".(int)$page_id."' "
				: "cp.supertag = '".quote($this->dblink, $this->translit($tag, TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD))."' " )
			, $cache);

		return $categories;
	}

	function bad_words($text)
	{
		/*
		ANTISPAM

		We load in the external antispam.conf file and then search the entire body content for each of the
		words defined as spam.  If we find any then we return a notice.
		See bug#188 - Enhanced Spam filtering
		*/
		if ($this->config['spam_filter'])
		{
			// TODO: read table word and cache it
			if (($spam = file(Ut::join_path(CONFIG_DIR, 'antispam.conf'))))
			{
				foreach ($spam as $one)
				{
					if (stripos($text, trim($one)) !== false)
					{
						return $this->get_translation('PotentialSpam') . ' : <code>' . $one . '</code>';
					}
				}
			}
		}
	}

	// MAILER
	// $email_to			- recipient address
	// $subject, $message	- self-explaining
	// $email_from			- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	// $xtra_headers		- (array) insert additional mail headers
	// $supress_tls			- don't change all http links to https links in the message body
	function send_mail($email_to, $subject, $body, $email_from = '', $charset = '', $xtra_headers = '', $supress_tls = false)
	{
		if (!$this->config['enable_email'] || ( !$email_to || !$subject || !$body) )
		{
			return;
		}

		if (empty($charset))
		{
			$charset = $this->get_charset();
		}

		$name_to		= '';
		$email_from		= $this->config['admin_email'];
		$name_from		= $this->config['email_from'];

		// in tls mode substitute protocol name in links substrings
		if ($this->db->tls && !$supress_tls)
		{
			$body = str_replace('http://', 'https://' . ($this->db->tls_proxy ? $this->db->tls_proxy . '/' : ''), $body);
		}

		// use phpmailer class
		if ($this->config['phpmailer'] == true)
		{
			// $this->config['phpMailer_method']
			$email = new Email($this);
			$email->php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset, $xtra_headers);
		}
		else
		{
			// use mail() function
			$headers = 'From: =?'. $charset ."?B?". base64_encode($this->config['site_name']) ."?= <".$this->config['admin_email'].">\r\n";
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
	// $parent_id		- commented parent id
	// $lang			- page language
	// $mute			- supress email reminders and xml rss recompilation
	// $user_name		- attach guest pseudonym
	// $user_page		- user is page owner
	function save_page($tag, $title = '', $body, $edit_note = '', $minor_edit = 0, $reviewed = 0, $comment_on_id = 0, $parent_id = 0, $lang = '', $mute = false, $user_name = false, $user_page = false)
	{
		$desc = '';

		// user data
		$ip = $this->get_user_ip();

		if ($user_name == '')
		{
			$user_name = GUEST;
		}

		if ($user_name && $user_name != GUEST)
		{
			$owner_id	= $user_id	= $this->get_user_id($user_name);
			$reg		= true;
		}
		// current user is owner; if user is logged in! otherwise, no owner.
		else if ($this->get_user_name())
		{
			$user_name	= $this->get_user_name();
			$owner_id	= $user_id	= $this->get_user_id();
			$reg		= true;
		}
		else if ($this->forum || $comment_on_id)
		{
			$owner_id	= 0; // GUEST
			$reg		= false;
		}
		else
		{
			$owner_id	= 0;
			$reg		= false;
		}

		$page_id = $this->get_page_id($tag);

		// write tag
		if(isset($_POST['tag']))
		{
			$this->tag		= $tag = $_POST['tag'];
			$this->supertag	= $this->translit($tag);
		}

		if (!$this->translit($tag))
		{
			return;
		}

		// cache handling
		if ($this->config['cache'])
		{
			// page cache
			if ($comment_on_id)
			{
				$this->http->invalidate_page($this->get_page_tag($comment_on_id));
			}
			else
			{
				$this->http->invalidate_page($this->supertag);
			}

			$this->config->invalidate_sql_cache();
		}

		// check privileges
		if ( ($this->page && $this->has_access('write', $page_id))
			|| (!$this->page && $this->has_access('create', '', $user_name)) // TODO: (!$this->page && $this->has_access('create', $tag))
			#	|| $this->is_admin() // XXX: Only for testing - comment out afterwards!
			|| ($comment_on_id && $this->has_access('comment', $comment_on_id))
			|| $user_page == true)
		{
			// for forum topic prepare description
			if (!$comment_on_id && $this->forum)
			{
				$desc = $this->format(substr($body, 0, 500), 'cleanwacko');
				$desc = (strlen($desc) > 240 ? substr($desc, 0, 240).'[..]' : $desc.' [..]');
			}

			// preformatter (macros and such)
			$body = $this->format($body, 'pre_wacko');

			// making page body components
			$body_r		= $this->format($body, 'wacko');
			$body_toc	= '';

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
			if (!($old_page = $this->load_page('', $page_id,'','','', 1)))
			{
				if (empty($lang))
				{
					$lang_list = $this->available_languages();

					if (isset($lang_list[@$_REQUEST['lang']]))
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
				if (!$title)
				{
					if ($comment_on_id)
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
					$write_acl		= $this->load_acl($root_id, 'write');

					while (!empty($write_acl['default']) && $write_acl['default'] == 1)
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

					// forum topic privileges
					if ($this->forum)
					{
						$write_acl		= $user_name;
						$comment_acl	= '*';
						$create_acl		= '';
						$upload_acl		= '';
					}
				}
				else if ($comment_on_id)
				{
					// Give comments the same read rights as their parent page
					$read_acl		= $this->load_acl($comment_on_id, 'read');
					$read_acl		= $read_acl['list'];
					$write_acl		= '';
					$comment_acl	= '';
					$create_acl		= '';
					$upload_acl		= '';
				}
				else
				{
					$read_acl		= $this->config['default_read_acl'];
					$write_acl		= $this->config['default_write_acl'];
					$comment_acl	= $this->config['default_comment_acl'];
					$create_acl		= $this->config['default_create_acl'];
					$upload_acl		= $this->config['default_upload_acl'];
				}

				// determine the depth
				$_depth_array	= explode('/', $tag);
				$depth			= count($_depth_array);

				$this->sql_query(
					"INSERT INTO ".$this->config['table_prefix']."page SET ".
						"comment_on_id 	= '".(int)$comment_on_id."', ".
						(!$comment_on_id ? "description = '".quote($this->dblink, $desc)."', " : "").
						"parent_id 		= '".(int)$parent_id."', ".
						"created		= UTC_TIMESTAMP(), ".
						"modified		= UTC_TIMESTAMP(), ".
						"commented		= UTC_TIMESTAMP(), ".
						"depth			= '".(int)$depth."', ".
						"owner_id		= '".(int)$owner_id."', ".
						"user_id		= '".(int)$user_id."', ".
						"ip				= '".quote($this->dblink, $ip)."', ".
						"latest			= '1', ".
						"tag			= '".quote($this->dblink, $tag)."', ".
						"supertag		= '".quote($this->dblink, $this->translit($tag))."', ".
						"body			= '".quote($this->dblink, $body)."', ".
						"body_r			= '".quote($this->dblink, $body_r)."', ".
						"body_toc		= '".quote($this->dblink, $body_toc)."', ".
						"edit_note		= '".quote($this->dblink, $edit_note)."', ".
						"minor_edit		= '".(int)$minor_edit."', ".
						(isset($reviewed)
							?	"reviewed		= '".(int)$reviewed."', ".
								"reviewed_time	= UTC_TIMESTAMP(), ".
								"reviewer_id	= '".(int)$reviewer_id."', "
							:	"").
						"page_lang		= '".quote($this->dblink, $lang)."', ".
						"title			= '".quote($this->dblink, $title)."'");

				// IMPORTANT! lookup newly created page_id
				$page_id = $this->get_page_id($tag);

				// saving acls
				$this->save_acl($page_id, 'write',		$write_acl);
				$this->save_acl($page_id, 'read',		$read_acl);
				$this->save_acl($page_id, 'comment',	$comment_acl);
				$this->save_acl($page_id, 'create',		$create_acl);
				$this->save_acl($page_id, 'upload',		$upload_acl);

				// log event
				if ($comment_on_id)
				{
					// see add_comment handler
					#$this->log(5, str_replace('%2', $this->tag.' '.$this->page['title'], str_replace('%1', 'Comment'.$num, $this->get_translation('LogCommentPosted', $this->config['language']))));
				}
				else
				{
					// added new page
					$this->log(4, Ut::perc_replace($this->get_translation('LogPageCreated', $this->config['language']), $tag.' '.$title));
				}

				// TODO: move to additional function
				// counters
				if ($comment_on_id)
				{
					// updating comments count for commented page
					$this->sql_query(
						"UPDATE {$this->config['table_prefix']}page SET ".
							"comments	= '".(int)$this->count_comments($comment_on_id)."', ".
							"commented	= UTC_TIMESTAMP() ".
						"WHERE page_id = '".(int)$comment_on_id."' ".
						"LIMIT 1");

					// update user comments count
					$this->sql_query(
						"UPDATE {$this->config['user_table']} SET ".
							"total_comments = total_comments + 1 ".
						"WHERE user_id = '".(int)$owner_id."' ".
						"LIMIT 1");
				}
				else
				{
					// update user pages count
					$this->sql_query(
						"UPDATE {$this->config['user_table']} SET ".
							"total_pages = total_pages + 1 ".
						"WHERE user_id = '".(int)$owner_id."' ".
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

					// subscribe & notify moderators
					if (!$mute)
					{
						$this->notify_moderator($page_id, $tag, $title, $user_name);
					}
				}

				if ($comment_on_id && !$mute)
				{
					// notifying watchers
					$this->notify_watcher($page_id, $comment_on_id, $tag, $title, $body, $user_id, $user_name, false, $minor_edit);
				}
			} // end of new page
			else
			{
				// RESAVING AN OLD PAGE, CREATING REVISION
				$this->set_language($this->page_lang);

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
					$this->sql_query(
						"UPDATE ".$this->config['table_prefix']."page SET ".
							"comment_on_id	= '".(int)$comment_on_id."', ".
							"modified		= UTC_TIMESTAMP(), ".
							"created		= '".quote($this->dblink, $old_page['created'])."', ".
							"owner_id		= '".(int)$owner_id."', ".
							"user_id		= '".(int)$user_id."', ".
							"latest			= '2', ".
							"description	= '".quote($this->dblink, ($old_page['comment_on_id'] || $old_page['description'] ? $old_page['description'] : $desc ))."', ".
							"supertag		= '".quote($this->dblink, $this->translit($tag))."', ".
							"body			= '".quote($this->dblink, $body)."', ".
							"body_r			= '".quote($this->dblink, $body_r)."', ".
							"body_toc		= '".quote($this->dblink, $body_toc)."', ".
							"edit_note		= '".quote($this->dblink, $edit_note)."', ".
							"minor_edit		= '".(int)$minor_edit."', ".
							(isset($reviewed)
								?	"reviewed		= '".(int)$reviewed."', ".
									"reviewed_time	= UTC_TIMESTAMP(), ".
									"reviewer_id	= '".(int)$reviewer_id."', "
								:	"").
							"title			= '".quote($this->dblink, $title)."' ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"LIMIT 1");

					// log event
					if ($this->page['comment_on_id'] != 0)
					{
						// comment modified
						$this->log(6, Ut::perc_replace($this->get_translation('LogCommentEdited', $this->config['language']), $tag.' '.$title));
					}
					else
					{
						// old page modified
						$this->log(6, Ut::perc_replace($this->get_translation('LogPageEdited', $this->config['language']), $tag.' '.$title));
					}

					// Since there's no revision history for comments it's pointless to do the following for them.
					if (!$comment_on_id && !$mute)
					{
						// notifying watchers
						$this->notify_watcher($page_id, $comment_on_id, $tag, $title, null, $user_id, $user_name, true, $minor_edit);
					}
				} // end of new != old
			} // end of existing page
		}

		// writing xmls
		if (!$mute)
		{
			if (!isset($old_page['comment_on_id']) || !$comment_on_id)
			{
				if ($this->config['enable_feeds'])
				{
					$xml = new Feed($this);
					$xml->changes();
					$xml->comments();

					// write news feed
					if ($this->config['news_cluster'])
					{
						if (substr($this->tag, 0, strlen($this->config['news_cluster'].'/')) == $this->config['news_cluster'].'/')
						{
							$xml->feed(); // $this->tag
						}
					}
				}

				$this->update_sitemap();
			}
		}

		return $body_r;
	}

	// create revision of a given page
	function save_revision($old_page)
	{
		// prepare input
		foreach ($old_page as &$val)
		{
			$val = quote($this->dblink, $val);
		}

		// get new version_id
		$_old_version = $this->load_single(
			"SELECT version_id ".
			"FROM {$this->config['table_prefix']}revision ".
			"WHERE page_id = '".$old_page['page_id']."' ".
			"ORDER BY version_id DESC ".
			"LIMIT 1");

		$version_id = $_old_version['version_id'] + 1;

		// move revision
		$this->sql_query(
			"INSERT INTO {$this->config['table_prefix']}revision SET ".
				"page_id		= '{$old_page['page_id']}', ".
				"version_id		= '{$version_id}', ".
				"tag			= '{$old_page['tag']}', ".
				"modified		= '{$old_page['modified']}', ".
				"body			= '{$old_page['body']}', ".
				"body_r			= '', ". // specify value for columns that don't have defaults
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
				"page_lang		= '{$old_page['page_lang']}', ".
				"supertag		= '{$old_page['supertag']}', ".
				"title			= '{$old_page['title']}', ".
				"keywords		= '{$old_page['keywords']}', ".
				"description	= '{$old_page['description']}'");

		// update user statistics for revisions made
		if ($user = $this->get_user())
		{
			$this->sql_query(
				"UPDATE {$this->config['user_table']} SET ".
					"total_revisions = total_revisions + 1 ".
				"WHERE user_id = '".$user['user_id']."' ".
				"LIMIT 1");
		}
	}

	function update_sitemap()
	{
		$this->sess->xml_sitemap_update = 1;
	}

	function write_sitemap()
	{
		if ((@$this->sess->xml_sitemap_update || $this->config['xml_sitemap_update']) && $this->config['xml_sitemap'])
		{
			if (($days = $this->config['xml_sitemap_time']) <= 0)
			{
				// write
			}
			else if (time() > @$this->config['maint_last_xml_sitemap'])
			{
				$this->config->set('xml_sitemap_update', 0, false);
				$this->config->set('maint_last_xml_sitemap', time() + $days * DAYSECS);
			}
			else
			{
				$this->config->set('xml_sitemap_update', 1);
				return;
			}

			$xml = new Feed($this);
			$xml->site_map();
			$this->log(7, 'XML Sitemap generated');
			$this->sess->xml_sitemap_update = 0;
		}
	}

	function add_user_page($user_name, $user_lang = null)
	{
		if (!isset($user_lang))
		{
			$user_lang = $this->config['language'];
		}

		$tag				= $this->config['users_page'].'/'.$user_name;
		// add your user page template here
		$user_page_template	= '**((user:'.$user_name.' '.$user_name.'))** ('.$this->format('::+::', 'pre_wacko').')';
		$change_summary		= $this->get_translation('NewUserAccount'); //'auto created';

		// add user page
		if ($this->load_page($tag, 0, '', LOAD_CACHE, LOAD_META) == false)
		{
			$this->save_page($tag, '', $user_page_template, $change_summary, '', '', '', '', $user_lang, '', $user_name, true);
		}
	}

	function set_account_status($user_id, $account_status)
	{
		// approved
		if ($account_status === false)
		{
			$enabled = 1;
		}
		else
		{
			$enabled = 0;
		}

		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"enabled		= '".(int)$enabled."', ".
				"account_status	= '".(int)$account_status."' ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");
	}

	function approve_user($user_id, $account_status, $user_name, $email, $user_lang)
	{
		$this->set_account_status($user_id, $account_status);

		if ($account_status === false)
		{
			#$this->add_user_page($user_name, $user_lang);

			// send email
			if ($this->config['enable_email'])
			{
				/* TODO: set user language for email encoding */
				$save = $this->set_language($user_lang, true);

				$subject	=	$this->get_translation('RegistrationApproved');
				$body		=	Ut::perc_replace($this->get_translation('UserApprovedInfo'), $this->config['site_name'])."\n\n".
								$this->get_translation('EmailRegisteredLogin')."\n\n";

				$this->send_user_email($user_name, $email, $subject, $body, $user_lang);

				$this->set_language($save, true);
			}
		}
	}

	function send_user_email($user_name, $email, $subject, $body, $user_lang)
	{
		$save = $this->set_language($user_lang, true);

		$subject	=	'['.$this->config['site_name'].'] '.$subject;
		$body		=	$this->get_translation('EmailHello').' '.$user_name.",\n\n".
						$body."\n\n".
						$this->get_translation('EmailDoNotReply')."\n\n".
						$this->get_translation('EmailGoodbye')."\n".
						$this->config['site_name']."\n".
						$this->config['base_url'];

		$this->send_mail($email, $subject, $body, null, $this->get_charset($user_lang));

		$this->set_language($save, true);
	}

	function notify_moderator($page_id, $tag, $title, $user_name)
	{
		// subscribe & notify moderators
		if (is_array($this->config['aliases']))
		{
			$list	= $this->config['aliases'];

			if (isset($list['Moderator']))
			{
				$moderators	= explode("\\n", $list['Moderator']);

				foreach ($moderators as $moderator)
				{
					if ($user_name != $moderator)
					{
						$moderator_id = $this->get_user_id($moderator);

						$user = $this->load_single(
							"SELECT u.user_name, u.email, s.user_lang, u.email_confirm, u.enabled, s.send_watchmail ".
							"FROM " .$this->config['user_table']." u ".
								"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = p.user_id) ".
							"WHERE u.user_id = '".$moderator_id."' ".
							"LIMIT 1");

						if ($this->config['enable_email'] && $this->config['enable_email_notification'] && $user['enabled'] && !$user['email_confirm'] && $user['send_watchmail'])
						{
							$save = $this->set_language($user['user_lang'], true);

							$subject	=	$this->get_translation('NewPageCreatedSubj')." '$title'";
							$body		=	$this->get_translation('EmailModerator').".\n\n".
											Ut::perc_replace($this->get_translation('NewPageCreatedBody'), ( $user_name == GUEST ? $this->get_translation('Guest') : $user_name ))."\n".
											"'$title'\n".
											$this->href('', $tag)."\n\n";

							$this->send_user_email($user['user_name'], $user['email'], $subject, $body, $user['user_lang']);

							$this->set_watch($moderator_id, $page_id);
							$this->set_language($save, true);
						}
					}
				}
			}
		}
	}

	/*
	 * notify watchers on new comment creation or existing page change
	 */
	function notify_watcher($page_id, $comment_on_id, $tag, $title, $page_body, $user_id, $user_name, $minor_edit)
	{
		if (!$title)
		{
			$title = $tag;
		}

		if ($comment_on_id)
		{
			$object_id = $comment_on_id;
			$page_title = $this->get_page_title('', $comment_on_id);
		}
		else
		{
			$object_id			= $page_id;
			// revisions diff
			$page = $this->load_single(
				"SELECT revision_id ".
				"FROM ".$this->config['table_prefix']."revision ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ".
				"ORDER BY modified DESC ".
				"LIMIT 1");

			$_GET['a']			= -1;
			$_GET['b']			= $page['revision_id'];
			$_GET['diffmode']	= 2; // 2 - source diff
			$diff				= $this->method('diff');
		}

		// get watchers
		$watchers	= $this->load_all(
			"SELECT DISTINCT
				w.user_id, w.comment_id, w.pending,
				u.email, u.user_name, u.email_confirm, u.enabled,
				s.user_lang, s.send_watchmail, s.notify_minor_edit, s.notify_page, s.notify_comment ".
			"FROM ".$this->config['table_prefix']."watch w ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (w.user_id = u.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (w.user_id = s.user_id) ".
			"WHERE w.page_id = '".(int)$object_id."'");

		foreach ($watchers as $watcher)
		{
			if ($watcher['user_id'] != $user_id && $watcher['user_name'] != GUEST)
			{
				if ($comment_on_id)
				{
					// assert that user has no comments pending...
					if ($watcher['notify_comment'] > 1)
					{
						// ...and add one if so
						if (!$watcher['comment_id'])
						{
							$this->sql_query(
								"UPDATE {$this->config['table_prefix']}watch SET ".
									"comment_id	= '".(int)$page_id."' ".
								"WHERE page_id = '".(int)$comment_on_id."' ".
									"AND user_id = '".$watcher['user_id']."'");
						}
						else
						{
							continue;	// skip current watcher
						}
					}
					else if (!$watcher['notify_comment'])
					{
						continue;	// skip current watcher
					}
				}
				else
				{
					if (($minor_edit && !$watcher['notify_minor_edit']) || !$watcher['notify_page'])
					{
						continue;	// skip current watcher
					}

					// assert that user has no comments pending...
					if ($watcher['notify_page'] > 1)
					{
						// ...and add one if so
						if (!$watcher['pending'])
						{
							$this->sql_query(
								"UPDATE {$this->config['table_prefix']}watch SET ".
									"pending	= '1' ".
								"WHERE page_id = '".(int)$comment_on_id."' ".
									"AND user_id = '".$watcher['user_id']."'");
						}
						else
						{
							continue;	// skip current watcher
						}
					}
				}

				if (!$this->has_access('read', $object_id, $watcher['user_name']))
				{
					$this->clear_watch($watcher['user_id'], $object_id);
					continue;
				}

				if ($this->config['enable_email']
						&& $this->config['enable_email_notification']
						&& $watcher['enabled']
						&& !$watcher['email_confirm']
						&& $watcher['send_watchmail'])
				{
					$lang = $watcher['user_lang'];
					$save = $this->set_language($lang, true);

					$body = ($user_name == GUEST ? $this->get_translation('Guest') : $user_name);

					if ($comment_on_id)
					{
						$subject = $this->get_translation('CommentForWatchedPage')."'".$page_title."'";

						$body .=
								$this->get_translation('SomeoneCommented')."\n".
								$this->href('', $this->get_page_tag($comment_on_id), '')."\n\n".
								$title."\n".
								"----------------------------------------------------------------------\n\n".
								$page_body."\n\n".
								"----------------------------------------------------------------------\n\n";

						if ($watcher['notify_comment'] == 2)
						{
							$body .= $this->get_translation('FurtherPending')."\n\n";
						}
					}
					else
					{
						$subject = $this->get_translation('WatchedPageChanged')."'".$tag."'";

						$body .=
								$this->get_translation('SomeoneChangedThisPage')."\n".
								$this->href('', $tag)."\n\n".
								$title."\n".
								"======================================================================\n\n".
								$this->format($diff, 'html2mail')."\n\n".
								"======================================================================\n\n";

						if ($watcher['notify_page'] == 2)
						{
							$body .= $this->get_translation('FurtherPending')."\n\n";
						}
					}

					$this->send_user_email($watcher['user_name'], $watcher['email'], $subject, $body, $lang);

					$this->set_language($save, true);
				}
			}
		}
	}

	// COOKIES
	function set_cookie($name, $value, $days = 0, $persistent = false, $secure = 0, $httponly = 1)
	{
		if ($persistent && $this->config['allow_persistent_cookie'] == true)
		{
			// set to default if no period given
			if ($days == 0)
			{
				$days = $this->config['session_length'];
			}

			// persistent cookie
			$expire = time() + $days * 24 * 3600;
		}
		else
		{
			// session cookie
			$expire = 0;
		}

		setcookie($this->config['cookie_prefix'].$name, $value, $expire, $this->config['cookie_path'], '', ( $secure ? true : false ), ( $httponly ? true : false ));
		$_COOKIE[$this->config['cookie_prefix'].$name] = $value;
	}

	function delete_cookie($name, $prefix = true, $postfix = false)
	{
		$prefix	= $prefix?  $this->config['cookie_prefix'] : '';

		$cookie_path	= $this->config['cookie_path'];
		$cookie_name	= $prefix.$name;

		// ensures that cookie expires in browser
		setcookie($cookie_name, '', 1, $cookie_path, '');
		$_COOKIE[$cookie_name] = '';

		// removing cookie
		setcookie($cookie_name, false);

		// removes the cookie from script
		unset($_COOKIE[$cookie_name]);
	}

	// purge cockie_tokens
	//	- user_id
	//	- expired
	//	- purge_days
	function delete_cookie_token($user_id = '', $expired = true, $purge_days = 3)
	{
		$sql = "SELECT user_id, MAX(session_time) AS recent_time
				FROM {$this->config['table_prefix']}auth_token ".
				($expired
					? "WHERE session_time < UTC_TIMESTAMP() "
					: "").
				($user_id
					? "WHERE user_id = '".(int)$user_id."' "
					: "").
				"GROUP BY user_id";

		$sessions = $this->load_all($sql);

		// composing a list of candidates
		if (is_array($sessions))
		{
			#$del_sessions = 0;
			$remove = array();

			foreach ($sessions as $session)
			{
				$sql = "UPDATE {$this->config['table_prefix']}user SET
							session_expire	= 0, ".
							($expired
								? "last_visit	= '".$session['recent_time']."' "
								: "last_visit	= UTC_TIMESTAMP() ").
						"WHERE user_id = '".(int)$session['user_id']."'
						LIMIT 1";

				$this->sql_query($sql);

				// does the session has been deleted earlier than specified number of days ago?
				if (strtotime($session['recent_time']) < (time() - (3600 * 24 * $purge_days)) || !$expired )
				{
					$remove[] = "'".(int)$session['user_id']."'";
				}
			}

			if (count($remove))
			{
				// Delete expired sessions
				$sql = "DELETE FROM {$this->config['table_prefix']}auth_token
						WHERE user_id IN ( ".implode(', ', $remove)." ) ".
						($expired
							? "AND session_time < UTC_TIMESTAMP()"
							: "");

				$this->sql_query($sql);

				unset($remove);
			}
		}
	}

	function get_cookie($name)
	{
		return @$_COOKIE[$this->config['cookie_prefix'] . $name];
	}

	// HTTP/REQUEST/LINK RELATED

	/**
	* set content for a popup message to be shown on opening the next Wacko page
	* (actually just stores the session-value 'message')
	*
	* @param string $message
	* @param string $type
	*/
	function set_message($message, $type = 'info')
	{
		if ($message)
		{
			$this->sess->sticky_messages[] = [$message, $type];
		}
	}

	// output all messages stored in session array
	function output_messages()
	{
		// get system message
		// TODO: set type also via backend and store it [where?]
		if (($message = $this->config['system_message']) && !$this->config['ap_mode'])
		{
			// check current page lang for different charset to do_unicode_entities()
			if (isset($this->page['page_lang']) && $this->page['page_lang'] != $this->config['language'])
			{
				$message = $this->do_unicode_entities($message, $this->config['language']);
			}

			$this->show_message($message, 'sysmessage ' . $this->config['system_message_type']);
		}

		if (isset($this->sess->sticky_messages))
		{
			$messages = $this->sess->sticky_messages;
			unset($this->sess->sticky_messages);

			// TODO: maybe filter?
			// TODO: think about quoting....
			foreach ($messages as $message)
			{
				list($_message, $_type) = $message;

				$this->show_message($_message, $_type);
			}
		}
	}

	function show_message($message, $type = 'info', $show = true)
	{
		if ($message)
		{
			$info_box = '<div class="' . $type . '">' . $message . "</div>\n";

			if ($show)
			{
				echo $info_box;
			}
			else
			{
				return $info_box;
			}
		}
	}

	/**
	* @deprecated: use http->redirect() instead
	*/
	function redirect($url, $permanent = false)
	{
		$this->http->redirect($url, $permanent);
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
			$root		= '';
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\!\/(.*)$/', $tag, $matches))
		{
			$root		= $this->context[$this->current_context];
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

	/**
	* Returns the full URL for a page/method, including any additional URL-parameters and anchor
	*
	* @param string $method Optional Wakka method (default 'show' method added in Run() function)
	* @param string $tag Optional tag. Returns current-page tag if empty
	* @param string $params Optional URL parameters in HTTP name=value[&name=value][...] format (or as list ['a=1', 'b=2'])
	* @param boolean $addpage Optional
	* @param string $anchor Optional HTTP anchor-fragment
	* @return string HREF string adjusted for Apache rewrite_method setting (i.e. Wakka 'rewrite_method' config-parameter)
	*/
	function href($method = '', $tag = '', $params = '', $addpage = false, $anchor = '')
	{
		if (!is_array($params))
		{
			$params = $params? [$params] : [];
		}

		$href = $this->config['base_url'];

		// enable rewrite_mode in ap_mode to avoid href() appends '?page=' (why?)
		if ($this->config['rewrite_mode'] || $this->config['ap_mode'])
		{
			$href .= $this->mini_href($method, $tag, $addpage);
		}
		else
		{
			array_unshift($params, 'page=' . $this->mini_href($method, $tag, $addpage));
		}

		if ($addpage)
		{
			$params[] = 'add=1';
		}

		if ($params)
		{
			$href .= '?' . implode('&amp;', $params);
		}

		if ($anchor)
		{
			$href .= '#' . $anchor;
		}

		return $href;
	}

	// returns just PageName[/method].
	/**
	* Returns value for page 'wakka' parameter, in tag[/method][#anchor] format
	* @param string $method Optional Wacko method (default 'show' method added in Run() function)
	* @param string $tag Optional tag - returns current-page tag if empty
	* @param boolean $addpage Optional
	* @return string String tag[/method]
	*/
	function mini_href($method = '', $tag = '', $addpage = false)
	{
		if (!($tag = trim($tag)))
		{
			$tag = $this->tag;
		}

		if (!$addpage && !$this->config['ap_mode'])
		{
			$tag = $this->slim_url($tag);
		}
		// if (!$addpage)		$tag = $this->translit($tag);

		$tag = trim($tag, '/.');
		// $tag = str_replace(array('%2F', '%3F', '%3D'), array('/', '?', '='), rawurlencode($tag));

		return $tag.($method ? '/'.$method : '');
	}

	/**
	* Convert WikiWord to Wiki_Word in URLs if config value urls_underscores is 1
	*
	* @param string $tag Page tag
	* @return string
	*/
	function slim_url($tag)
	{
		$tag = $this->translit($tag, TRANSLIT_DONTCHANGE); // TODO: set config option ?
		// why we do this, what are the assumptions?
		//	this behavior is unwanted in the AP, it breaks the redirect for e.g. config_basic.php
		//	looks like an undo of the reverse in the tranlit function (?)
		$tag = str_replace('_', "'", $tag);

		if ($this->config['urls_underscores'] == 1)
		{
			$tag = preg_replace('/('.$this->language['ALPHANUM'].')('.$this->language['UPPERNUM'].')/', '\\1¶\\2', $tag);
			$tag = preg_replace('/('.$this->language['UPPERNUM'].')('.$this->language['UPPERNUM'].')/', '\\1¶\\2', $tag);
			$tag = preg_replace('/('.$this->language['UPPER'].')¶(?='.$this->language['UPPER'].'¶'.$this->language['UPPERNUM'].')/', '\\1', $tag);
			$tag = preg_replace('/('.$this->language['UPPER'].')¶(?='.$this->language['UPPER'].'¶\/)/', '\\1', $tag);
			$tag = preg_replace('/('.$this->language['UPPERNUM'].')¶('.$this->language['UPPERNUM'].')($|\b)/', '\\1\\2', $tag);
			$tag = preg_replace('/\/¶('.$this->language['UPPERNUM'].')/', '/\\1', $tag);
			$tag = str_replace('¶', '_', $tag);
		}

		return $tag;
	}

	/**
	* Add spaces and wraps page Href into <a> </a>
	*
	* @param string $tag Page tag.
	* @param string $method Wacko method. Optional, default 'show' method added in Run() function.
	* @param string $text Href text. Optinonal, default is $tag value
	* @param boolean $track Track this link. Optional, default is TRUE
	* @param string $title link title. Optional, default is ''
	* @param string $params additional parameters. Optional, default is ''
	* @return unknown
	*/
	function compose_link_to_page($tag, $method = '', $text = '', $track = 1, $title = '', $params = '')
	{
		if (!$text)
		{
			$text = $this->add_spaces($tag);
		}

		//$text = htmlentities($text, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
		if ($track && $this->link_tracking())
		{
			$this->track_link_to($tag, LINK_PAGE);
		}

		return '<a href="'.$this->href($method, $tag, $params).'"'.($title ? ' title="'.$title.'"' : '').'>'.$text.'</a>';
	}

	// preparing links to save them to body_r
	/**
	* Wraps links in special symbols <!--link:begin-->Link ==Text<!--link:end--> for
	* detection in future (invoking from WackoFormatter).
	*
	* @param string $tag Link
	* @param string $text Link text
	* @param boolean $track Track this link. Optional, default is TRUE
	* @param boolean $img_url
	* @return string Wrapped link
	*/
	function pre_link($tag, $text = '', $track = 1, $img_url = 0)
	{
		// if (!$text) $text = $this->add_spaces($tag);

		if (preg_match('/^[\!\.'.$this->language['ALPHANUM_P'].']+$/', $tag))
		{
			if ($track && $this->link_tracking())
			{
				// it's a Wiki link!
				$this->track_link_to($this->unwrap_link($tag), LINK_PAGE);
			}
		}

		$text = str_replace('%20', ' ', urldecode($text));

		if ($img_url == 1)
		{
			return '<!--imglink:begin-->'.str_replace(' ', '%20', urldecode($tag)).' =='.$text.'<!--imglink:end-->';
		}
		else
		{
			return '<!--link:begin-->'.str_replace(' ', '%20', urldecode($tag))." ==".($this->format_safe ? str_replace('>', "&gt;", str_replace('<', "&lt;", $text)) : $text).'<!--link:end-->';
		}
	}

	/**
	* Returns full <A HREF=".."> or <IMG ...> HTML for Tag
	*
	* @param string $tag Link content - may be Wacko tag, interwiki wikiname:page tag,
	* http/file/ftp/https/mailto/xmpp URL, [=] local or remote image-file for <img> link, or local or
	* remote doc-file; if pagetag is for an external link but not protocol is specified, http:// is prepended
	* @param string $method Optional Wacko method (default 'show' method added in Run() function)
	* @param string $text Optional text or image-file for HREF link (defaults to same as pagetag)
	* @param string $title
	* @param boolean $track Link-tracking used by Wacko's internal link-tracking (inter-page cross-references in LINKS table).
	* Optional, default is TRUE
	* @param boolean $safe If false, then sanitize $text, else no.
	* @param string $link_lang
	* @param string $anchor_link Optional HTTP anchor-fragment
	* @return string full Href link
	*/
	function link($tag, $method = '', $text = '', $title = '', $track = 1, $safe = 0, $link_lang = '', $anchor_link = 1)
	{
		$class		= '';
		$icon		= '';
		$img_link	= false;
		$lang		= '';
		$matches	= array();
		$url		= '';
		$text		= str_replace('"', '&quot;', $text);

		// parse off <img> resizing tags from text: height= / width= / align=
		$_align		= '';
		$_height	= '';
		$_width		= '';
		$resize		= '';
		$trim		= 0;
		$text = preg_replace_callback(
			'/\s*\b([a-z]+)=([0-9a-z%]+)/i',
			function ($mat) use (&$_align, &$_height, &$_width, &$trim)
			{
				if ($mat[1] == 'height')
					$_height = $mat[2];
				else if ($mat[1] == 'width')
					$_width = $mat[2];
				else if ($mat[1] == 'align')
					$_align = $mat[2];
				else
					return $mat[0];
				$trim = 1;
				return '';
			}, $text);
		if ($trim)
		{
			$text = trim($text);
		}
		if ($_width || $_height)
		{
			if (!$_width) {
				$_width = 'auto';
			}
			else if (preg_match('/^[0-9]+$/', $_width))
			{
				$_width .= 'px';
			}
			if (!$_height)
			{
				$_height = 'auto';
			} else if (preg_match('/^[0-9]+$/', $_height))
			{
				$_height .= 'px';
			}
			$resize = " style=\"width:$_width;height:$_height;\"";
		}
		if ($_align)
		{
			$resize .= " align=$_align"; // XXX: deprecated in HTML 4 & 5 though
		}

		if ($track)
		{
			$track = $this->link_tracking();
		}

		if (!$safe)
		{
			$text = htmlspecialchars($text, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
		}

		if ($link_lang)
		{
			$this->set_language($link_lang);
		}

		if (preg_match('/^[\.\-'.$this->language['ALPHANUM_P'].']+\.(gif|jpg|jpe|jpeg|png|svg)$/i', $text))
		{
			$img_link = $this->config['base_url'].'/image/'.$text;
		}
		else if (preg_match('/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png|svg)$/i', preg_replace('/<\/?nobr>/', '', $text)))
		{
			$img_link = $text = preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/', '', $text);
		}

		if (preg_match('/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid Email
			$url	= (isset($matches[1]) && $matches[1] == 'mailto:' ? $tag : 'mailto:'.$tag);
			$title	= $this->get_translation('EmailLink');
			$icon	= $this->get_translation('OuterIcon');
			$class	= '';
			$tpl	= 'email';
		}
		else if (preg_match('/^(xmpp[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid XMPP address
			$url	= (isset($matches[1]) && $matches[1] == 'xmpp:' ? $tag : 'xmpp:'.$tag);
			$title	= $this->get_translation('JabberLink');
			$icon	= $this->get_translation('OuterIcon');
			$class	= '';
			$tpl	= 'jabber';
		}
		else if (preg_match('/^#/', $tag))
		{
			// html-anchor
			$url	= $tag;
			$tpl	= 'anchor';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png|svg)$/i', $tag))
		{
			// external image
			$text	= preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/', '', $text);

			if ($text == $tag)
			{
				return '<img src="'.str_replace('&', '&amp;', str_replace('&amp;', '&', $tag)).'" '.($text ? 'alt="'.$text.'" title="'.$text.'"' : '').$resize.' />';
			}
			else
			{
				$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
				$title	= $this->get_translation('OuterLink2');
				$icon	= $this->get_translation('OuterIcon');
				$tpl	= 'outerlink';
			}
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rpm|gz|tgz|zip|rar|exe|doc|xls|ppt|bz2|7z)$/', $tag))
		{
			// this is a file link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('FileLink');
			$icon	= $this->get_translation('OuterIcon');
			$class	= '';
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/', $tag))
		{
			// this is a PDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('PDFLink');
			$icon	= $this->get_translation('OuterIcon');
			$class	= '';
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/', $tag))
		{
			// this is a RDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->get_translation('RDFLink');
			$icon	= $this->get_translation('OuterIcon');
			$class	= '';
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
				$icon	= $this->get_translation('OuterIcon');
			}
		}
		else if (preg_match('/^(_?)file:([^\\s\"<>\(\)]+)$/', $tag, $matches))
		{
			// this is a uploaded file
			// TODO: add file link tracking
			$noimg			= $matches[1]; // files action: matches '_file:' - patched link to not show pictures when not needed
			$_file_name		= $matches[2];
			$arr			= explode('/', $_file_name);
			$page_tag		= '';
			$class			= 'file-link'; // generic file icon
			$_global		= true;
			$file_access	= false;
			$have_global	= false;

			if (count($arr) == 1) // case 1 -> file:some.zip
			{
				#echo '####1: file:some.zip<br />';
				$file_name = $_file_name;

				if ($file_data = $this->check_file_exists($file_name, $page_tag))
				{
					$url = $this->config['base_url'].Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
					$have_global = true;

					// tracking file link
					if ($track && isset($file_data['upload_id']))
					{
						$this->track_link_to($file_data['upload_id'], LINK_FILE);
					}
				}
			}
			else if (count($arr) == 2 && $arr[0] == '')	// case 2 -> file:/some.zip - global only file
			{
				#echo '####2: file:/some.zip <br />'.$arr[1].'####<br />';
				$file_name = $arr[1];

				if ($file_data = $this->check_file_exists($file_name, $page_tag))
				{
					$url = $this->config['base_url'].Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);

					// tracking file link
					if ($track && isset($file_data['upload_id']))
					{
						$this->track_link_to($file_data['upload_id'], LINK_FILE);
					}
				}
			}

			if (!$url || $have_global) // case 3 -> check for local file
			{
				// keep data from global file, maybe we need it
				if ($have_global)
				{
					$_global_file_name	= $file_name;
					$_global_file_data	= $file_data;
					$_global_url		= $url;
					$url				= '';
				}

				#echo '####3: local file <br />';
				$_global	= false;
				$file_name	= $arr[count($arr) - 1];

				unset($arr[count($arr) - 1]);
				$_page_tag	= implode('/', $arr);

				if ($_page_tag == '')
				{
					$_page_tag = '!/';
				}

				//unwrap tag (check !/, ../ cases)
				$page_tag	= rtrim($this->translit($this->unwrap_link($_page_tag)), './');
				$page_id	= $this->get_page_id($page_tag); // TODO: supertag won't match tag! in cache

				if ($file_data = $this->check_file_exists($file_name, $page_tag))
				{
					$url = $this->href('file', trim($page_tag, '/'), 'get='.$file_name);

					// tracking file link
					if ($track && isset($file_data['upload_id']))
					{
						$this->track_link_to($file_data['upload_id'], LINK_FILE);
					}

					if ($this->is_admin()
					|| ($file_data['upload_id'] && ($this->page['owner_id'] == $this->get_user_id()))
					|| ($this->has_access('read', $page_id))
					|| ($file_data['user_id'] == $this->get_user_id()))
					{
						$file_access = true;
					}
				}

				// no local file available, take the global file
				if (!$url && $have_global)
				{
					$_global	= true;
					$file_name	= $_global_file_name;
					$file_data	= $_global_file_data;
					$url		= $_global_url;

					unset ($_global_url, $_global_file_data, $_global_file_name);
				}
			}

			//try to find in global / local storage and return if success
			if (is_array($file_data))
			{
				#echo '---------------------------<br />';
				// check 403 here!
				if ($_global == true || $file_access == true)
				{
					$title		= $file_data['file_description'].' ('.$this->binary_multiples($file_data['file_size'], false, true, true).')';
					$alt		= $file_data['file_description'];
					$img_link	= false;
					$icon		= $this->get_translation('OuterIcon');
					#$class		= '';
					$tpl		= 'localfile';

					if ( ($file_data['picture_w'] || $file_data['file_ext'] == 'svg') && !$noimg)
					{
						/* if (!$text)
						{
							$text = $title;
						} */

						if ($file_data['file_ext'] == 'svg')
						{
							$scale = '';
						}
						else
						{
							$scale = ' width="'.$file_data['picture_w'].'" height="'.$file_data['picture_h'].'"';
						}

						// direct file access
						if ($_global == true)
						{

							if (!$text)
							{
								$text = $title;
								return '<img src="'.$this->config['base_url'].Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name).'" '.
										($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').$scale.$resize.' />';
							}
							else
							{
								// continue
								#return '<a href="'.$this->config['base_url'].Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name).'" title="'.$title.'">'.$text.'</a>';
							}
						}
						else
						{
							// no direct file access for files per page
							// the file handler checks the access rights
							#return '<img src="'.$this->config['base_url'].Ut::join_path(UPLOAD_PER_PAGE_DIR, '@'.$file_data['page_id'].'@'.$_file).'" '.($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').' width="'.$file_data['picture_w'].'" height="'.$file_data['picture_h'].'" />';
							if (!$text)
							{
								$text = $title;
								return '<img src="'.$this->href('file', trim($page_tag, '/'), 'get='.$file_name).'" '.
										($text ? 'alt="'.$alt.'" title="'.$text.'"' : '').$scale.$resize.' />';
							}
							else
							{
								// continue
								#return '<a href="'.$this->href('file', trim($page_tag, '/'), 'get='.$file_name).'" title="'.$title.'">'.$text.'</a>';
							}
						}
					}
				}
				else //403
				{
					$url		= $this->href('file', trim($page_tag, '/'), 'get='.$file_name);
					$icon		= $this->get_translation('OuterIcon');
					$img_link	= false;
					$tpl		= 'localfile';
					$class		= 'acl-denied';
				}
			}
			else	//404
			{
				$tpl	= 'wlocalfile';
				$url	= '404';

				if ($_global == true)
				{
					$title	= '404: /'.Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
				}
				else
				{
					$title	= '404: /'.trim($page_tag, '/').'/file'.($this->config['rewrite_mode'] ? '?' : '&amp;').'get='.$file_name;
				}
			} //forgot 'bout 403

			unset($file_data);
		}
		else if ($this->config['disable_tikilinks'] != 1 && preg_match('/^('.$this->language['UPPER'].$this->language['LOWER'].$this->language['ALPHANUM'].'*)\.('.$this->language['ALPHA'].$this->language['ALPHANUM'].'+)$/s', $tag, $matches))
		{
			// it`s a Tiki link! (Tiki.Link -> /Tiki/Link)
			$tag	= '/'.$matches[1].'/'.$matches[2];

			if (!$text)
			{
				$text = $this->add_spaces($tag);
			}

			return $this->link($tag, $method, $text, $title, $track, 1);
		}
		else if (preg_match('/^(user)[:](['.$this->language['ALPHANUM_P'].'\-\_\.\+\&\=\#]*)$/', $tag, $matches))
		{
			// user link -> user:UserName
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', rawurlencode($parts[$i]));
			}

			if ($link_lang)
			{
				$text	= $this->do_unicode_entities($text, $link_lang);
			}

			$url	= $this->href('', $this->config['users_page'].'/', 'profile='.implode('/', $parts));

			$class	= 'user-link';
			$icon	= $this->get_translation('OuterIcon');
			$tpl	= 'userlink';
		}
		else if (preg_match('/^(group)[:](['.$this->language['ALPHANUM_P'].'\-\_\.\+\&\=\#]*)$/', $tag, $matches))
		{
			// group link -> group:UserGroup
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', rawurlencode($parts[$i]));
			}

			if ($link_lang)
			{
				$text	= $this->do_unicode_entities($text, $link_lang);
			}

			$url	= $this->href('', $this->config['groups_page'].'/', 'profile='.implode('/', $parts));

			$class	= 'group-link';
			$icon	= $this->get_translation('OuterIcon');
			$tpl	= 'grouplink';
		}
		else if (preg_match('/^([[:alnum:]]+)[:](['.$this->language['ALPHANUM_P'].'\-\_\.\+\&\=\#]*)$/', $tag, $matches))
		{
			// interwiki
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', rawurlencode($parts[$i]));
			}

			if ($link_lang)
			{
				$text	= $this->do_unicode_entities($text, $link_lang);
			}

			$url	= $this->get_inter_wiki_url($matches[1], implode('/', $parts));
			$icon	= $this->get_translation('IwIcon');
			$tpl	= 'interwiki';
		}
		else if (preg_match('/^([\!\.\-'.$this->language['ALPHANUM_P'].']+)(\#['.$this->language['ALPHANUM_P'].'\_\-]+)?$/', $tag, $matches))
		{
			// it's a Wiki link!
			$match	= '';
			$tag	= $otag		= $matches[1];
			$untag	= $unwtag	= $this->unwrap_link($tag);

			$regex_handlers	= '/^(.*?)\/('.$this->config['standard_handlers'].')\/(.*)$/i';
			$ptag			= $this->translit($unwtag);
			$handler		= null;

			if (preg_match( $regex_handlers, '/'.$ptag.'/', $match ))
			{
				$handler	= $match[2];

				if (!isset($_ptag))
				{
					$_ptag = ''; // XXX: ???
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
						$data = ''; // XXX: ???
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

			$this_page		= $this->load_page($unwtag, 0, '', LOAD_CACHE, LOAD_META);

			if (!$this_page && $link_lang)
			{
				$this->set_language($link_lang);
				$lang		= $link_lang;
				$this_page	= $this->load_page($unwtag, 0, '', LOAD_CACHE, LOAD_META);
			}

			if ($this_page)
			{
				$_lang		= $this->language['code'];

				if ($this_page['page_lang'])
				{
					$lang	= $this_page['page_lang'];
				}
				else
				{
					$lang	= $this->config['language'];
				}

				$this->set_language($lang);
				$supertag	= $this->translit($untag);
			}
			else
			{
				$supertag	= $this->translit($untag, TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD);
			}

			$aname = '';

			if (substr($tag, 0, 2) == '!/')
			{
				$icon		= $this->get_translation('ChildIcon');
				$page0		= substr($tag, 2);
				$page		= $this->add_spaces($page0);
				$tpl		= 'childpage';
			}
			else if (substr($tag, 0, 3) == '../')
			{
				$icon		= $this->get_translation('ParentIcon');
				$page0		= substr($tag, 3);
				$page		= $this->add_spaces($page0);
				$tpl		= 'parentpage';
			}
			else if (substr($tag, 0, 1) == '/')
			{
				$icon		= $this->get_translation('RootIcon');
				$page0		= substr($tag, 1);
				$page		= $this->add_spaces($page0);
				$tpl		= 'rootpage';
			}
			else
			{
				$icon		= $this->get_translation('EqualIcon');
				$page0		= $tag;
				$page		= $this->add_spaces($page0);
				$tpl		= 'equalpage';
			}

			if ($img_link)
			{
				$text		= '<img src="'.$img_link.'" title="'.$text.'"'.$resize.' />';
			}

			if ($text)
			{
				if ($title)
				{
					// title="{title}" - alternate title is provided
					$tpl		= 'descrpagealt';
				}
				else
				{
					// title="{pagepath}{page}"
					$tpl		= 'descrpage';
				}

				$icon		= '';
			}

			$page_path		= substr($untag, 0, strlen($untag) - strlen($page0));
			$anchor			= isset($matches[2]) ? $matches[2] : '';
			$tag			= $unwtag;

			// track page link
			if ($track)
			{
				$this->track_link_to($tag, LINK_PAGE);
			}

			// set a anchor once for link at the first appearance
			if ($anchor_link && !isset($this->first_inclusion[$supertag]))
			{
				$aname = 'id="a-'.$supertag.'"';
				$this->first_inclusion[$supertag] = 1;
			}

			if ($this_page)
			{
				$page_link	= $this->href($method, $this_page['tag']).($anchor ? $anchor : '');
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
					$class		= 'acl-denied';
					$accicon	= $this->get_translation('OuterIcon');
				}
				else if ($this->_acl['list'] == '*')
				{
					$class		= '';
					$accicon	= '';
				}
				else
				{
					$class		= 'acl-customsec';
					$accicon	= $this->get_translation('OuterIcon');
				}

				if ($text == trim($otag, '/') || $link_lang)
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
				$tpl		= (isset($this->method) && ($this->method == 'print' || $this->method == 'wordprocessor') ? 'p' : '') . 'w' . $tpl;
				$page_link	= $this->href('edit', $tag, $lang ? 'lang='.$lang : '', 1);
				$accicon	= $this->get_translation('WantedIcon');
				$title		= $this->get_translation('CreatePage');

				if ($link_lang)
				{
					$text	= $this->do_unicode_entities($text, $link_lang);
					$page	= $this->do_unicode_entities($page, $link_lang);
				}
			}

			// XXX: obsolete -> see wacko.css
			#$icon			= str_replace('{theme}', $this->config['theme_url'], $icon);
			#$accicon		= str_replace('{theme}', $this->config['theme_url'], $accicon);

			// see lang/wacko.all.php
			$res			= $this->get_translation('Tpl.'.$tpl);
			$text			= trim($text);

			if ($res)
			{
				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				//TODO: pagepath
				#$aname		= str_replace('/',			'.',		$aname); // FIXME: missmatch id="doc.deutsch" but anchor '#doc/deutsch' - what was the purpose of setting a dot here if it breaks the anchor?
				$res		= str_replace('{aname}',	$aname,		$res);
				$res		= str_replace('{icon}',		$icon,		$res);
				$res		= str_replace('{accicon}',	$accicon,	$res);
				$res		= str_replace('{class}',	$class,		$res);
				$res		= str_replace('{title}',	$title,		$res);
				$res		= str_replace('{pagelink}',	$page_link,	$res);
				$res		= str_replace('{pagepath}',	$page_path,	$res);
				$res		= str_replace('{page}',		$page,		$res);
				$res		= str_replace('{text}',		$text,		$res);

				if (!$text)
				{
					$text	= htmlspecialchars($tag, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
				}

				// disable and visualize self-referencing link
				if ($this->config['youarehere_text'])
				{
					if (isset($this->context[$this->current_context]) && ($this->translit($tag) == $this->translit($this->context[$this->current_context])) )
					{
						$res	= str_replace('####', $text, $this->config['youarehere_text']);
					}
				}

				// numerated wiki-links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $page_link != $text && $title != $this->get_translation('CreatePage'))
				{
					$refnum = &$this->numerate_links[$page_link];
					if (!isset($refnum))
					{
						$refnum = '[link' . count($this->numerate_links) . ']';
					}

					$res .= '<sup class="refnum">' . $refnum . '</sup>';
				}

				return $res;
			}

			die ("ERROR: no link template '$tpl' found.");
		}

		if (!$text) $text	= htmlspecialchars($tag, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);

		if ($url)
		{
			if ($img_link)
			{
				$text		= '<img src="'.$img_link.'" title="'.$text.'"'.$resize.' />';
			}

			// XXX: obsolete -> see wacko.css
			#$icon			= str_replace('{theme}', $this->config['theme_url'], $icon);
			$res			= $this->get_translation('Tpl.'.$tpl);

			if ($res)
			{
				if (!$class)
				{
					$class	= 'external-link';
				}

				if ($this->config['link_target'])
				{
					$target = 'target="_blank"';
				}
				else
				{
					$target = '';
				}

				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				$res		= str_replace('{target}',	$target,	$res);
				$res		= str_replace('{icon}',		$icon,		$res);
				$res		= str_replace('{class}',	$class,		$res);
				$res		= str_replace('{title}',	$title,		$res);
				$res		= str_replace('{url}',		$url,		$res);
				$res		= str_replace('{text}',		$text,		$res);

				// numerated outer links and file links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $url != $text && $url != '404' && $url != '403')
				{
					if (!($refnum = (isset($this->numerate_links[$url]) ? $this->numerate_links[$url] : '')))
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

	// creates a link to the user profile
	function user_link($user_name, $account_lang = '', $linking = true, $add_icon = true)
	{
		if (!$user_name)
		{
			$user_name	= $this->get_translation('Guest');
			$linking	= false;
		}

		// check current page lang for different charset to do_unicode_entities()
		$text = ($this->page['page_lang'] != $account_lang)?  $this->do_unicode_entities($user_name, $account_lang) : $user_name;

		$icon = $add_icon?  '<span class="icon"></span>' : '';

		if ($linking)
		{
			return '<a href="' . $this->href('', $this->config['users_page'], 'profile=' . $user_name) . '" class="user-link">' . $icon . $text . '</a>';
		}
		else
		{
			return '<span class="user-link">' . $icon . $text . '</span>';
		}
	}

	// creates a link to the group profile
	function group_link($group_name, $group_lang = '', $linking = true, $add_icon = true)
	{
		if (!$group_name)
		{
			return false;
		}

		// check current page lang for different charset to do_unicode_entities()
		$text = ($this->page['page_lang'] != $group_lang)?  $this->do_unicode_entities($group_name, $group_lang) : $group_name;

		$icon = $add_icon?  '<span class="icon"></span>' : '';

		#$this->is_admin() ? ' title="'.$comment['ip'].'"' : '' (a | span)
		# $this->href('', '', 'profile='.htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'')

		if ($linking)
		{
			return '<a href="'.$this->href('', $this->config['groups_page'], 'profile='.$group_name).'" class="group-link">'.$icon.$text.'</a>';
		}
		else
		{
			return '<span class="group-link">'.$icon.$group_name.'</span>';
		}
	}

	/**
	* Add spaces to WikiWords (if config parameter show_spaces = 1) and replace
	* relative  path (/ !/ ../) to icons RootLinkIcon, SubLinkIcon, UpLinkIcon
	*
	* @param string $text Text with WikiWords
	* @return string Text with Wiki Words
	*/
	function add_spaces($text)
	{
		if (($user = $this->get_user())?  $user['show_spaces'] : $this->config['show_spaces'])
		{
			$text = $this->add_nbsps($text);
		}

		if (!strncmp($text, '/', 1))
		{
			$text = $this->get_translation('RootLinkIcon') . substr($text, 1);
		}
		else if (!strncmp($text, '!/', 2))
		{
			$text = $this->get_translation('SubLinkIcon') . substr($text, 2);
		}
		else if (!strncmp($text, '../', 3))
		{
			$text = $this->get_translation('UpLinkIcon') . substr($text, 3);
		}

		return $text;
	}

	function add_nbsps($text)
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
		// $text = preg_replace('/([0-9])&nbsp;(?=[0-9])/', '\\1', $text);
		$text = preg_replace('/([0-9])&nbsp;(?!'.$this->language['ALPHA'].')/', '\\1', $text);
		return $text;
	}

	function add_spaces_title($text)
	{
		return preg_replace('/&nbsp;/', ' ', $this->add_nbsps($text));
	}

	function validate_reserved_words( $data )
	{
		$_data = $this->translit( $data );
		$_data = '/'.$_data.'/';

		// Find the string of text
		# $this->REGEX_WACKO_HANDLERS = '/^(.*?)\/'.$this->config['standard_handlers'].'\/(.*)$/i';

		// Find the word
		$this->REGEX_WACKO_HANDLERS = '/\b('.$this->config['standard_handlers'].')\b/i';

		if (preg_match( $this->REGEX_WACKO_HANDLERS, $_data, $match ))
		{
			// message
			return $match[0];
		}

		if (!$this->page['comment_on_id'])
		{
			// disallow pages with Comment[0-9] and all sub pages, we do not want sub pages on a comment.
			if (preg_match( '/\b(Comment([0-9]+))\b/i', $_data, $match ))
			{
				return 'Comment([0-9]+)';
			}
		}

		// TODO: disallow random pages for the first level in the users cluster except the own [UserName].
		/* if (preg_match( '/\b('.$this->config['users_page'].'\/*\/)\b/i', $_data, $match ))
		{
			Ut::debug_print_r($match);
			return "It is not possible to create pages, whose name consists of numbers or begins on them.";
		} */

		/*
		if (preg_match( '/^\/[0-9]+/', $_data, $match ))
		{
			return "It is not possible to create pages, whose name consists of numbers or begins on them.";
			/// !!! to messageset, begins with 0-9
		}
		*/

		return false;
	}

	/**
	* Check if text is WikiName
	*
	* @param string $text Tested text
	* @return boolean True if WikiName? else FALSE
	*/
	function is_wiki_name($text)
	{
		return preg_match('/^'.$this->language['UPPER'].$this->language['LOWER'].'+'.$this->language['UPPERNUM'].$this->language['ALPHANUM'].'*$/', $text);
	}

	// TRACK LINKS

	/**
	* Link-tracking used to collect all links in processed text.
	*
	* @param string $tag
	* @param enum $link_type [LINK_PAGE|LINK_FILE]
	*
	*/
	function track_link_to($tag, $link_type)
	{
		if (isset($this->linktable)) // no linktable? we are not tracking!
		{
			$this->linktable[$link_type][strtolower($tag)] = $tag;
		}
	}

	function start_link_tracking()
	{
		// STS: why in SESSION? is tracking between page instances possible?
		$this->sess->linktracking = 1;
	}

	function stop_link_tracking()
	{
		$this->sess->linktracking = 0;
	}

	function link_tracking()
	{
		return @$this->sess->linktracking;
	}

	/**
	* Write linktable for //$from_page_id// to database
	*
	* @param int $from_page_id
	*/
	function write_link_table($from_page_id)
	{
		// delete related old links in table
		$this->sql_query(
				"DELETE ".
				"FROM ".$this->config['table_prefix']."link ".
				"WHERE from_page_id = '".(int)$from_page_id."'");

		// page link
		if ($link_table = @$this->linktable[LINK_PAGE])
		{
			$query = '';

			foreach ($link_table as $dummy => $to_tag) // discard strtolowered index
			{
				$query .= "('".(int)$from_page_id."', '".$this->get_page_id($to_tag)."', '".
							quote($this->dblink, $to_tag)."', '".quote($this->dblink, $this->translit($to_tag))."'),";
			}

			$this->sql_query(
				"INSERT INTO ".$this->config['table_prefix']."link ".
					"(from_page_id, to_page_id, to_tag, to_supertag) ".
				"VALUES ".rtrim($query, ','));
		}

		// delete page related old file links in table
		$this->sql_query(
				"DELETE ".
				"FROM ".$this->config['table_prefix']."file_link ".
				"WHERE page_id = '".(int)$from_page_id."'");

		// file link
		if ($file_table = @$this->linktable[LINK_FILE])
		{
			$query = '';

			foreach ($file_table as $upload_id => $dummy) // index == value, BTW
			{
				$query .= "('".(int)$from_page_id."', '".(int)$upload_id."'),";
			}

			$this->sql_query(
					"INSERT INTO ".$this->config['table_prefix']."file_link ".
					"(page_id, file_id) ".
					"VALUES ".rtrim($query, ','));
		}
	}

	function update_link_table($page_id, $body_r)
	{
		// now we render it internally so we can write the updated link table.
		if (isset($this->linktable))
		{
			$this->format($body_r, 'post_wacko');
		}
		else
		{
			$this->linktable = array();
			$this->start_link_tracking();
			$this->format($body_r, 'post_wacko');
			$this->stop_link_tracking();
			$this->write_link_table($page_id);
			unset($this->linktable);
		}
	}

	// INTERWIKI STUFF
	function get_inter_wiki_url($name, $tag)
	{
		// cache interwiki data in _SESSION
		$inter_wiki = &$this->sess->interwiki_conf;
		if (!isset($inter_wiki))
		{
			$inter_wiki = [];
			if (($lines = file(Ut::join_path(CONFIG_DIR, 'interwiki.conf'))))
			{
				foreach ($lines as $line)
				{
					if (($line = trim($line)) && !ctype_punct($line[0]))
					{
						list($wiki_name, $wiki_url) = preg_split('/\s+/', $line);
						$inter_wiki[strtolower($wiki_name)] = $wiki_url;
					}
				}
			}
		}

		if (($url = @$inter_wiki[strtolower($name)]))
		{
			// xhtmlisation
			$url = str_replace('&', '&amp;', $url);

			// tls'ing internal links
			if ($this->config['tls'])
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
				$url = $this->config['base_url'].$this->translit($sub);
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
	function form_open($form_name = '', $page_method = '', $form_method = '', $form_token = false, $tag = '', $form_more = '', $href_param = '')
	{
		if (!$form_method)
		{
			$form_method = 'post';
		}

		$add = (@$_GET['add'] || @$_POST['add']);

		$result	= '<form action="' .
			$this->href($page_method, $tag, $href_param, $add) . '" ' .
			$form_more . ' method="' . $form_method . '" ' . ($form_name ? 'name="' . $form_name . '" ' : '') . ">\n";

		if (!($this->config['rewrite_mode'] || $this->config['ap_mode']))
		{
			$result .= '<input type="hidden" name="page" value="' . $this->mini_href($page_method, $tag, $add) . "\" />\n";
		}

		// add form token
		if ($form_token)
		{
			$result .= $this->form_token($form_name);
		}

		if ($this->config['tls'])
		{
			$result = str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $result);
		}

		return $result;
	}

	function form_close()
	{
		return "</form>\n";
	}


	// adds a secret form token
	//		- string $form_name has to match the name used in validate_form_token function
	function form_token($form_name)
	{
		$now		= time();
		$user		= $this->get_user();

		if ($user['user_name'] == '')
		{
			$salt_length			= 10;
			$user['user_name']		= GUEST;
			$user['user_form_salt']	= $this->sess->guest_form_salt = Ut::random_token($salt_length, 3);
		}

		$token_sid	= ($user['user_name'] == GUEST && !empty($this->config['form_token_sid_guests'])) ? $this->sess->id() : ''; #$user['cookie_token']
		$token		= sha1($user['user_form_salt'] . $form_name . $token_sid);

		$data = array('creation_time' => $now);
		$this->sess->formdata[$token] = $data;

		$fields		= '';
		$fields		.= '<input type="hidden" name="form_token" value="'.$token.'" />'."\n";

		return $fields;
	}

	// validate the form token. Required for all altering actions not secured by confirm_box
	//		- string $form_name has to match the name used in form_token function
	//		- int $timespan The maximum acceptable age for a submitted form in seconds
	function validate_form_token($form_name, $timespan = false)
	{
		$user		= $this->get_user();

		if ($user['user_name'] == '')
		{
			$user['user_name']		= GUEST;
			$user['user_form_salt']	= $this->sess->guest_form_salt;
		}

		if ($timespan === false)
		{
			// we enforce a minimum value of 30 seconds
			$timespan = ($this->config['form_token_time'] == -1) ? -1 : max(30, $this->config['form_token_time']);
		}

		if (isset($_POST['form_token']))
		{
			$token			= isset($_POST['form_token']) ? $_POST['form_token'] : '';
			$creation_time	= isset($this->sess->formdata[$token]['creation_time']) ? $this->sess->formdata[$token]['creation_time'] : '';

			$diff = time() - $creation_time;

			// If creation_time and the time() now is zero we can assume it was not a human doing this (the check for if ($diff)...
			if ($diff && ($diff <= $timespan || $timespan === -1))
			{
				$token_sid	= ($user['user_name'] == GUEST && !empty($this->config['form_token_sid_guests'])) ? $this->sess->id() : ''; #$user['cookie_token']
				$key		= sha1($user['user_form_salt'] . $form_name . $token_sid);

				if ($key === $token)
				{

					return true;
				}
				else
				{
					header('HTTP/1.1 400 Bad Request');

					// TODO: token should be reset, generation of per-request tokens as opposed to per-session tokens
					// TODO: suspiciously repeated form requests/form submissions, using Captchas to prevent automatic requests
					$this->log(1, '**!!'.'Potential CSRF attack in progress detected.'.'!!**'.' [[/'.$this->page['tag'].']] '.$form_name); # 'Invalid form token'

					return false;
				}
			}

			// TODO: ? show indication e.g. timeout, pls. resubmit
		}

		return false;
	}

	// REFERRERS
	function log_referrer($page_id = '', $referrer = '')
	{
		// fill values
		if (!($page_id = trim($page_id)))
		{
			$page_id = $this->page['page_id'];
		}

		if (!($referrer = trim($referrer)))
		{
			$referrer	= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		}

		#$user_agent	= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		#$ip			= $this->get_user_ip();

		// check if it's coming from another site
		if ($referrer && !preg_match('/^'.preg_quote($this->config['base_url'], '/').'/', $referrer) && isset($_GET['sid']) === false) // TODO: isset($_GET['PHPSESSID']) === false
		{
			if (!preg_match('`^https?://`', $referrer))
			{
				return;
			}

			if ($this->bad_words($referrer))
			{
				return;
			}

			$this->sql_query(
				"INSERT INTO ".$this->config['table_prefix']."referrer SET ".
					"page_id		= '".(int)$page_id."', ".
					"referrer		= '".quote($this->dblink, $referrer)."', ".
					#"user_agent		= '".quote($this->dblink, (string) trim(substr($user_agent, 0, 149)))."', ".
					#"ip				= '".quote($this->dblink, (string) $ip)."', ".
					"referrer_time	= UTC_TIMESTAMP()");
		}
	}

	/**
	* Loads all referrers to this page from DB
	* @param int $page_id
	* @param int $backdays
	* @return array Array of (referer, num)
	*/
	function load_referrers($page_id = null)
	{
		return $this->load_all(
			"SELECT ".
			(!isset($page_id)
				? "referrer, count(referrer) AS num "
				: "page_id, referrer, count(referrer) AS num ").
			"FROM ".$this->config['table_prefix']."referrer ".
			(!is_null($page_id)
				? "WHERE page_id = '".(int)$page_id."' "
				: "").
			"GROUP BY referrer ".
			"ORDER BY num DESC");
	}

	// PLUGINS
	// variables prefixed by __ to not mess with argument extraction from $vars
	function include_buffered($__filename, $__notfound = '', $__vars = '', $__path = '')
	{
		foreach (($__path? explode(':', $__path) : ['']) as $__dir)
		{
			$__pathname = Ut::join_path($__dir, $__filename);

			if (@file_exists($__pathname))
			{
				if (is_array($__vars))
				{
					extract($__vars, EXTR_SKIP);
				}

				// include_tail is for extensions to use for closing markup tags, i.e. if return'ing early
				$include_tail = '';
				ob_start();
				include($__pathname);
				echo $include_tail;
				$output = ob_get_contents();
				ob_end_clean();

				return $output;
			}
		}

		if ($__notfound)
		{
			return $this->show_message($__notfound, 'error', false);
		}
		else
		{
			return false;
		}
	}

	function theme_header($mod = '')
	{
		$theme_path		= Ut::join_path(THEME_DIR, $this->config['theme'], 'appearance');
		$error_message	= $this->get_translation('ThemeCorrupt').': '.$this->config['theme'];

		return $this->include_buffered('header'.$mod.'.php', $error_message, '', $theme_path);
	}

	function theme_footer($mod = '')
	{
		$theme_path		= Ut::join_path(THEME_DIR, $this->config['theme'], 'appearance');
		$error_message	= $this->get_translation('ThemeCorrupt').': '.$this->config['theme'];

		return $this->include_buffered('footer'.$mod.'.php', $error_message, '', $theme_path);
	}

	/**
	* Invokes {@link WackoWiki:/Dev/Actions Action} and returns its output.
	*
	* @param string $action Action name
	* @param array $params Action parameters
	* @param boolean $force_link_lracking If value is TRUE then all links in acton  will be tracking in table Links.
	* Optional, default value is FALSE.
	* @return string Result of action
	*/
	function action($action, $params = '', $force_link_tracking = 0)
	{
		$action = strtolower(trim($action));
		$errmsg = '<em>' . $this->get_translation('UnknownAction') . ' "<code>' . $action . '</code>"</em>';

		if (!$force_link_tracking)
		{
			$this->stop_link_tracking();
		}

		$result = $this->include_buffered($action . '.php', $errmsg, $params, ACTION_DIR);

		$this->start_link_tracking();
		$this->http->no_cache();

		return $result;
	}

	function method($method)
	{
		if (!($handler = $this->page['handler']))
		{
			$handler = 'page';
		}

		$method_location = Ut::join_path($handler, $method . '.php');
		$errmsg = '<em>' . $this->get_translation('UnknownMethod') . ' "<code>' . $method_location . '</code>"</em>';

		$result = $this->include_buffered($method_location, $errmsg, '', HANDLER_DIR);

		return (!strncmp($result, ADD_NO_DIV, strlen(ADD_NO_DIV)))
			?  substr($result, strlen(ADD_NO_DIV))
			: '<div id="' . $handler . '">' . $result . "</div>\n";
	}

	// wrapper for the next method
	function format($text, $formatter = 'wiki', $options = '')
	{
		return $this->_format($text, $formatter, $options);
	}

	function _format($text, $formatter, &$options)
	{
		$err = '<em>' . Ut::perc_replace($this->get_translation('FormatterNotFound'), $formatter) . '</em>';
		$text = $this->include_buffered(Ut::join_path(FORMATTER_DIR, $formatter . '.php'), $err, compact('text', 'options'));

		if ($formatter == 'wacko' && $this->config['default_typografica'])
		{
			$text = $this->include_buffered(Ut::join_path(FORMATTER_DIR, 'typografica.php'), $err, compact('text'));
		}

		return $text;
	}

	// GROUPS
	function load_usergroup($group_name, $group_id = 0)
	{
		$fiels_default	= 'g.*, u.user_name AS moderator';

		$usergroup = $this->load_single(
			"SELECT {$fiels_default} ".
			"FROM ".$this->config['table_prefix']."usergroup g ".
				"LEFT JOIN ".$this->config['table_prefix']."user u ON (g.moderator_id = u.user_id) ".
			"WHERE ".( $group_id != 0
				? "g.group_id		= '".(int)$group_id."' "
				: "g.group_name		= '".quote($this->dblink, $group_name)."' ").
			"LIMIT 1");

		return $usergroup;
	}

	// USERS
	// check whether defined username is already registered.
	// we add appropriate (but not thorough) transliterations
	// to not allow too similiar names.
	function user_name_exists($user_name)
	{
		if ($user_name == '')
		{
			return false;
		}

		// checking identical name only?
		if (!$this->config['antidupe'])
		{
			if ($this->load_single(
			"SELECT user_id ".
			"FROM {$this->config['user_table']} ".
			"WHERE user_name = '".quote($this->dblink, $user_name)."' ".
			"LIMIT 1"))
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
		$user_name = preg_split('//', $user_name, -1, PREG_SPLIT_NO_EMPTY);

		// let's define characters positions and corresponding substitutions.
		// so we're constructing $p array with username chars needing
		// substitution positions as keys, and corresponding table positions
		// as array values
		$p = array();

		foreach ($user_name as $pos => &$char)
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
		foreach ($table as &$val)
		{
			$val = preg_split('//', $val, -1, PREG_SPLIT_NO_EMPTY);
		}

		// running through all chars positions needing replacement
		foreach ($p as $pos => $sub)
		{
			// what substitution character we have to use?
			if ($user_name[$pos] != $table['cyr'][$sub])
			{
				// constructing cyrillic regexp addition
				$user_name[$pos] = '['.$user_name[$pos].$table['cyr'][$sub].']';
			}
			else if ($user_name[$pos] != $table['lat'][$sub])
			{
				// constructing latin regexp addition
				$user_name[$pos] = '['.$user_name[$pos].$table['lat'][$sub].']';
			}
		}

		// checking database
		if ($this->load_single(
		"SELECT user_id ".
		"FROM {$this->config['user_table']} ".
		"WHERE user_name REGEXP '".quote($this->dblink, implode('', $user_name))."' ".
		"LIMIT 1", true))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// check whether defined email is already in use.
	// Allow e-mail address re-use:
	// Different users can register with the same e-mail address.
	function email_exists($email)
	{
		if ($email == '')
		{
			return false;
		}

		// checking identical name only?
		#if (!$this->config['allow_email_reuse'])
		#{
			if ($this->load_single(
				"SELECT user_id ".
				"FROM {$this->config['user_table']} ".
				"WHERE email = '".quote($this->dblink, $email)."' ".
				"LIMIT 1"))
			{
				return true;
			}
			else
			{
				return false;
			}
		#}
	}

	/**
	 * Loads user data
	 *
	 * @param string $user_name
	 * @param number $user_id
	 * @param string $password
	 * @param string $session_data
	 * @param string $login_token
	 *
	 * @return string
	 */
	function load_user($user_name, $user_id = 0, $password = 0, $session_data = false, $login_token = false)
	{
		$fields_setting	= 's.doubleclick_edit, s.show_comments, s.list_count, s.menu_items, s.user_lang, s.show_spaces, s.typografica,
							s.theme, s.autocomplete, s.numerate_links, s.notify_minor_edit, s.notify_page, s.notify_comment, s.dont_redirect,
							s.send_watchmail, s.show_files, s.allow_intercom, s.allow_massemail, s.hide_lastsession, s.validate_ip, s.noid_pubs,
							s.session_length, s.timezone, s.dst, s.sorting_comments, t.session_time, t.cookie_token ';
		$fields_default	= 'u.*, '.$fields_setting;
		$fields_session	= 'u.user_id, u.user_name, u.real_name, u.account_lang, u.password, u.email, u.enabled, u.user_form_salt, u.email_confirm,
							t.session_time, u.last_visit, u.session_expire, u.last_mark, '.$fields_setting;

		$user = $this->load_single(
			"SELECT ".($session_data
				? $fields_session
				: $fields_default
				).
			"FROM ".$this->config['user_table']." u ".
				"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
				"LEFT JOIN ".$this->config['table_prefix']."auth_token t ON (u.user_id = t.user_id) ".
			"WHERE ".( $user_id
					? "u.user_id		= '".(int)$user_id."' "
					: 	( $login_token !== false
						? "t.cookie_token	= '".quote($this->dblink, $login_token)."' "
						: "u.user_name	= '".quote($this->dblink, $user_name)."' ")).
					"AND u.account_type = '0' ".
			($password === 0
				? ""
				: "AND u.password = '".quote($this->dblink, $password)."'"
				)." ".
			"LIMIT 1");

		if (!$user['session_time'])
		{
			$user['session_time'] = '';
		}

		return $user;
	}

	function get_user_name()
	{
		return $this->get_user_setting('user_name');
	}

	function get_user_ip()
	{
		return $this->http->real_ip;
	}

	// extract user data from the session array
	function get_user()
	{
		return @$this->sess->userprofile;
	}

	// insert user data into the session array
	function set_user($user, $ip = 1)
	{
		$this->sess->userprofile = $user;

		// define current IP for foregoing checks
		if ($ip)
		{
			$this->set_user_setting('ip', $this->get_user_ip());
		}
	}

	// extract specific element from user session array
	function get_user_setting($setting, $guest = 0)
	{
		if ($guest)
		{
			return @$this->sess->guestprofile[$setting];
		}
		else
		{
			return @$this->sess->userprofile[$setting];
		}
	}

	// set/update specific element of user session array
	// !!! BE CAREFUL NOT TO SAVE GUEST VALUES UNDER REGISTERED USER ARRAY !!!
	// this poses a potential security threat
	function set_user_setting($setting, $value, $guest = 0)
	{
		if ($guest)
		{
			$this->sess->guestprofile[$setting] = $value;
		}
		else
		{
			$this->sess->userprofile[$setting] = $value;
		}
	}

	function update_last_mark($user)
	{
		if ($user['user_id'])
		{
			return $this->sql_query(
				"UPDATE {$this->config['user_table']} SET ".
					"last_mark = UTC_TIMESTAMP() ".
				"WHERE user_id = '".$user['user_id']."' ".
				"LIMIT 1");
		}
	}

	// update comments count and date on commented page
	function update_comments_count($comment_on_id)
	{
		// load latest comment
		$comment = $this->load_single(
			"SELECT created ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE comment_on_id = '".(int)$comment_on_id."' ".
			"ORDER BY created DESC ".
			"LIMIT 1");

		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}page SET ".
				"comments	= '".$this->count_comments($comment_on_id)."', ".
				"commented	= '".quote($this->dblink, $comment['created'])."' ".
			"WHERE page_id	= '".(int)$comment_on_id."' ".
			"LIMIT 1");
	}

	function get_list_count($max)
	{
		$user_max = $this->get_user_setting('list_count');
		if (!isset($user_max))
		{
			$user_max = 50;
		}
		else if ($user_max <= 0)
		{
			$user_max = 10;
		}
		else if ($user_max > 100)
		{
			$user_max = 100;
		}

		$max = (int)$max;
		if ($max <= 0 || $max > $user_max)
		{
			$max = $user_max;
		}

		return $max;
	}

	/**
	 * Return unique id
	 */
	function unique_id()
	{
		return Ut::random_token(16);
	}

	function log_user_in($user, $persistent = false, $session_length = 0)
	{
		// cookie elements

		// session length in days
		$session_length			= ($session_length == 0 ? $this->config['session_length'] : $session_length);
		$session_length			= ($persistent ? $session_length : 0.25);
		$session_expire			= time() + $session_length * 24 * 3600;

		//  generate a string to use as the identifier for the login cookie
		$login_token			= $this->unique_id(); // TODO:
		$this->cookie_token		= hash('sha1', $login_token);

		$salt_length			= 10;
		$salt_user_form			= Ut::random_token($salt_length, 3);

		$this->time_now			= date('Y-m-d H:i:s');
		$this->session_time		= date('Y-m-d H:i:s', $session_expire);

		if ($user['user_id'])
		{
			$this->session_last_visit = (!empty($user['session_time']) && $user['session_time'])
											? $user['session_time']
											: ($user['last_visit']
												? $user['last_visit']
												: $this->time_now );
		}
		else
		{
			$this->session_last_visit = $this->time_now;
		}

		#$this->update_session_page	= $update_session_page;
		$this->browser				= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
		#$this->referer				= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
		$this->forwarded_for		= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
		$this->ip					= $this->get_user_ip();

		// cookie MAC
		$time_pad		= str_pad($session_expire, 32, '0', STR_PAD_LEFT);
		$b64password	= base64_encode(hash('sha256', $this->config['system_seed'] ^ $time_pad) ^ $user['password']);
		// authenticating cookie data:
		// seed | login token | composed pwd | raw session time | raw password
		$cookie_mac		= hash('sha1', $this->config['system_seed'].$login_token.$b64password.$session_expire.$user['password']);

		// TODO: use hash_hmac instead
		#$hmac_key		= hash("sha256", $password, true);
		#$cookie_hmac	= hash_hmac('sha256', $login_token|$session_expire, $hmac_key);

		// construct and set cookie
		$cookie_value	= implode(';', array($login_token, $b64password, $session_expire, $cookie_mac));

		// set auth cookie
		$this->set_cookie(AUTH_TOKEN, $cookie_value, $session_length, $persistent, ( $this->config['tls'] ? 1 : 0 ));

		// update session expiry, user_form_salt and clear password recovery
		// code in user data table
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"session_expire		= '".(int) $session_expire."', ".
				"user_form_salt		= '".quote($this->dblink, $salt_user_form)."', ".
				"change_password	= '' ".
			"WHERE user_id		= '".$user['user_id']."' ".
			"LIMIT 1");

		if (empty($user['cookie_token']))
		{
			$this->sql_query(
				"INSERT INTO {$this->config['table_prefix']}auth_token SET ".
					"cookie_token			= '".quote($this->dblink, $this->cookie_token)."', ".
					"user_id				= '".(int)$user['user_id']."', ".
					"session_start			= UTC_TIMESTAMP(), ".
					"session_last_visit		= '".quote($this->dblink, $this->session_last_visit)."', ".
					"session_time			= '".quote($this->dblink, $this->session_time)."', ".
					"session_browser		= '".quote($this->dblink, (string) trim(substr($this->browser, 0, 149)))."', ".
					"session_forwarded_for	= '".quote($this->dblink, (string) $this->forwarded_for)."', ".
					"session_ip				= '".quote($this->dblink, (string) $this->ip)."' ".
					#"session_autologin		= ($session_autologin) ? 1 : 0, ".
					#"session_admin			= ($set_admin) ? 1 : 0 ".
				"");
		}
		else
		{
			$this->sql_query(
				"UPDATE {$this->config['table_prefix']}auth_token SET ".
					"cookie_token			= '".quote($this->dblink, $this->cookie_token)."', ".
					"session_last_visit		= '".quote($this->dblink, $this->session_last_visit)."', ".
					"session_time			= '".quote($this->dblink, $this->session_time)."', ".
					"session_browser		= '".quote($this->dblink, (string) trim(substr($this->browser, 0, 149)))."', ".
					"session_forwarded_for	= '".quote($this->dblink, (string) $this->forwarded_for)."', ".
					"session_ip				= '".quote($this->dblink, (string) $this->ip)."' ".
					#"session_autologin		= ($session_autologin) ? 1 : 0, ".
					#"session_admin			= ($set_admin) ? 1 : 0 ".
				"WHERE user_id			= '".$user['user_id']."' ".
				"LIMIT 1");
		}

		// restart logged in user session with specific session id
		return $this->restart_user_session($user, $session_expire);
	}

	// regenerate session id for registered user
	function restart_user_session($user, $session_expire)
	{
		return $this->sess->restart();
	}

	// restore login_token/password/etc from auth cookie
	function decompose_auth_cookie($name = AUTH_TOKEN)
	{
		$recalc_mac = '';
		$cookie_mac = '';

		// get cookie value
		if (($cookie = $this->get_cookie($name)))
		{
			list($login_token, $b64password, $session_expire, $cookie_mac) = explode(';', $cookie);

			$time_pad	= str_pad($session_expire, 32, '0', STR_PAD_LEFT);
			$password	= hash('sha256', $this->config['system_seed'] ^ $time_pad) ^ base64_decode($b64password);
			$recalc_mac	= hash('sha1', $this->config['system_seed'].$login_token.$b64password.$session_expire.$password);

			return array(
				'login_token'		=> $login_token,
				'password'			=> $password,
				'session_expire'	=> $session_expire,
				'cookie_mac'		=> $cookie_mac,
				'recalc_mac'		=> $recalc_mac
			);
		}
		else
		{
			return null;
		}
	}

	// end user session and free session vars
	function log_user_out()
	{
		if (($user_id = $this->get_user_setting('user_id')))
		{
			// clear session expiry in user data table and cookie_token in auth_token table
			$this->delete_cookie_token($user_id, false);
		}

		$this->delete_cookie(AUTH_TOKEN, true, true);

		$this->sess->restart();
	}

	// Increment the number of times the user has logegd in
	function login_count($user_id)
	{
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"login_count = login_count + 1 ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");

		return true;
	}

	// Increment the failed login count by 1
	function set_failed_user_login_count($user_id)
	{
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"failed_login_count = failed_login_count + 1 ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");

		return true;
	}

	// Reset to zero the failed login attempts
	function reset_failed_user_login_count($user_id)
	{
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"failed_login_count = 0 ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");

		return true;
	}

	// Increment the failed login count by 1
	function set_lost_password_count($user_id)
	{
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"lost_password_request_count = lost_password_request_count + 1 ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");

		return true;
	}

	// Reset to zero the 'lost password' in progress attempts
	function reset_lost_password_count($user_id)
	{
		$this->sql_query(
			"UPDATE {$this->config['user_table']} SET ".
				"lost_password_request_count = 0 ".
			"WHERE user_id = '".(int)$user_id."' ".
			"LIMIT 1");

		return true;
	}

	function load_users()
	{
		return $this->load_all(
			"SELECT user_id, user_name ".
			"FROM ".$this->config['user_table']." ".
			"ORDER BY BINARY user_name");
	}

	function get_user_id($user_name = '')
	{
		if ($user_name !== '')
		{
			$user = $this->load_single(
				"SELECT user_id ".
				"FROM ".$this->config['table_prefix']."user ".
				"WHERE user_name = '".quote($this->dblink, $user_name)."' ".
				"LIMIT 1", true);
		}
		else
		{
			$user = $this->get_user();
		}

		return (int) @$user['user_id']; // 0 if no such user
	}

	// Returns boolean indicating if the current user is allowed to see comments at all
	function user_allowed_comments()
	{
		return $this->config['enable_comments'] != 0 && ($this->config['enable_comments'] != 2 || $this->get_user());
	}

	// COMMENTS AND COUNTS

	// recount all comments for a given page
	function count_comments($comment_on_id, $deleted = 0)
	{
		$count = $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE comment_on_id = '".(int)$comment_on_id."' ".
				($deleted != 1
					? "AND deleted <> '1' "
					: "").
			"LIMIT 1");

		return (int)$count['n'];
	}

	// get current number of comments
	function get_comments_count($page_id = '')
	{
		if ($this->page && $page_id == false)
		{
			return $this->page['comments'];
		}
		else
		{
			$count = $this->load_single(
				"SELECT comments ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE page_id = '".(int)$page_id."' ".
				"LIMIT 1");

			return (int)$count['comments'];
		}

		return false;
	}

	function load_comments($page_id, $limit = 0, $count = 30, $sort = 0, $deleted = 0)
	{
		// avoid results if $page_id is 0 (page does not exists)
		if ($page_id)
		{
			return $this->load_all(
				"SELECT p.page_id, parent_id, p.user_id, p.title, p.tag, p.created, p.modified, p.body, p.body_r, u.user_name, o.user_name as owner_name ".
				"FROM ".$this->config['table_prefix']."page p ".
					"LEFT JOIN ".$this->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"LEFT JOIN ".$this->config['table_prefix']."user o ON (p.owner_id = o.user_id) ".
				"WHERE p.comment_on_id = '".(int)$page_id."' ".
					($deleted != 1
						? "AND p.deleted <> '1' "
						: "").
				"ORDER BY p.created ".
					($sort
						? "DESC "
						: "").
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

		if (isset($this->config['aliases']) && is_array($this->config['aliases']))
		{
			$alias = $this->config['aliases'];
			$admin = explode("\\n", $alias['Admins']);

			if ($admin && in_array($this->get_user_name(), $admin))
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

		if (isset($this->config['aliases']) && is_array($this->config['aliases']))
		{
			$alias = $this->config['aliases'];

			if (isset($alias['Moderator']))
			{
				$moderator = explode("\\n", $alias['Moderator']);

				if ($moderator && in_array($this->get_user_name(), $moderator))
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

		if (isset($this->config['aliases']) && is_array($this->config['aliases']))
		{
			$alias = $this->config['aliases'];

			if (isset($alias['Reviewer']))
			{
				$reviewer = explode("\\n", $alias['Reviewer']);

				if ($reviewer && in_array($this->get_user_name(), $reviewer))
				{
					return true;
				}
			}
		}

		return false;
	}

	// returns true if logged in user is owner of current page, or page specified in $tag
	function is_owner($page_id = '')
	{
		// check if user is logged in
		if (!$this->get_user())
		{
			return false;
		}

		// set default tag
		if (!($page_id = trim($page_id)))
		{
			$page_id = $this->page['page_id'];
		}

		// check if user is owner
		return ($this->get_page_owner_id($page_id) == $this->get_user_id());
	}

	function get_page_owner($tag = '', $page_id = 0, $revision_id = '')
	{
		if (!($tag = trim($tag)))
		{
			if (!$revision_id)
			{
				if (isset($this->page['owner_name']))
				{
					return $this->page['owner_name'];
				}
				else
				{
					return false;
				}
			}
			else
			{
				$tag = $this->tag;
			}
		}

		if (($page = $this->load_page($tag, $page_id, $revision_id, LOAD_CACHE, LOAD_META)))
		{
			return $page['owner_name'];
		}
		else
		{
			return false;
		}
	}

	function get_page_owner_id($page_id = '', $revision_id = '')
	{
		if (!($page_id = trim($page_id)))
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

		if (($page = $this->load_page('', $page_id, $revision_id, LOAD_CACHE, LOAD_META)))
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
		$this->sql_query(
			"UPDATE ".$this->config['table_prefix']."page SET ".
				"owner_id = '".(int)$user_id."' ".
			"WHERE page_id = '".(int)$page_id."' ".
			"LIMIT 1");
	}

	function save_acl($page_id, $privilege, $list)
	{
		if ($this->load_acl($page_id, $privilege, 0, 0, 0))
		{
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."acl SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", '', $list)))."' ".
				"WHERE page_id = '".(int)$page_id."' ".
					"AND privilege = '".quote($this->dblink, $privilege)."' ");
		}
		else
		{
			$this->sql_query(
				"INSERT INTO ".$this->config['table_prefix']."acl SET ".
					"list		= '".quote($this->dblink, trim(str_replace("\r", '', $list)))."', ".
					"page_id	= '".(int)$page_id."', ".
					"privilege	= '".quote($this->dblink, $privilege)."'");
		}
	}

	/**
	* Get ACL for tag from cache
	*
	* @param int $page_id
	* @param string $privilege ACL privilege: read, write, comment, create, upload
	* @param boolean $use_defaults
	* @return array ACL
	*/
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

	/**
	* Add ACL to cache
	*
	* @param int $page_id
	* @param string $privilege ACL privilege: read, write, comment, create, upload
	* @param boolean $use_defaults
	* @param array $acl Access control list
	*/
	function cache_acl($page_id, $privilege, $use_defaults, $acl)
	{
		// $acl array must reflect acls table row structure
		$this->acl_cache[$page_id.'#'.$privilege.'#'.$use_defaults] = $acl;
	}

	// TODO: add bulk option -> load entire page related priveleges at once in obj-cache
	function load_acl($page_id, $privilege, $use_defaults = 1, $use_cache = 1, $use_parent = 1, $new_tag = '')
	{
		$acl = '';

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
				if (!$new_tag)
				{
					$acl = $this->load_single(
						"SELECT page_id, privilege, list ".
						"FROM ".$this->config['table_prefix']."acl ".
						"WHERE page_id = '".(int)$page_id."' ".
							"AND privilege = '".quote($this->dblink, $privilege)."' ".
						"LIMIT 1");
				}

				// if still no acl, use config defaults
				if (!$acl && $use_defaults)
				{
					// First look for parent ACL, so that clusters/subpages
					// work correctly.
					if (!empty($page_id))
					{
						$tag = strtolower($this->get_page_tag($page_id));
					}
					else
					{
						// new page which is to be created
						$tag = strtolower($new_tag);
					}

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
							'page_id' => $page_id,
							'privilege' => $privilege,
							'list' => $this->config['default_'.$privilege.'_acl'],
							'time' => date('YmdHis'),
							'default' => 1
						);
					}
				}

				$this->cache_acl($page_id, $privilege, $use_defaults, $acl);
			}
		}

		return $acl;
	}

	// returns true if $user_name (defaults to the current user) has access to $privilege on $page_id (defaults to the current page)
	function has_access($privilege, $page_id = '', $user_name = '', $use_parent = 1)
	{
		if (!$user_name)
		{
			$user_name = strtolower($this->get_user_name());
		}

		if (!($page_id = trim($page_id)))
		{
			$page_id = $this->page['page_id'];
		}

		// if still no page_id, use tag
		if (empty($page_id))
		{
			// new page which is to be created
			$new_tag = $this->tag;
		}
		else
		{
			$new_tag = '';
		}

		if ($privilege == 'write')
		{
			$use_parent = 0;
		}

		// load acl
		$acl		= $this->load_acl($page_id, $privilege, 1, 1, $use_parent, $new_tag);
		// cache
		$this->_acl	= $acl;

		// lock down to read only
		if ($this->config['acl_lock'] == true && $privilege != 'read')
		{
			return false;
		}

		// if current user is owner or admin, return true. they can do anything!
		if ($user_name == '' && $user_name != GUEST)
		{
			if ($this->is_owner($page_id) || $this->is_admin())
			{
				return true;
			}
		}

		if (isset($acl['list']))
		{
			return $this->check_acl($user_name, $acl['list'], true);
		}
		else
		{
			return false;
		}
	}

	function check_acl($user_name, $acl_list, $copy_to_this_acl = false, $debug = 0)
	{
		if (is_array($user_name))
		{
			$user_name = $user_name['user_name'];
		}

		$user_name = strtolower($user_name);

		// replace groups
		$acl = str_replace(' ', '', strtolower($this->replace_aliases($acl_list)));

		if ($copy_to_this_acl)
		{
			$this->_acl['list'] = $acl;
		}

		$acls = "\n".$acl."\n";

		if ($user_name == GUEST || $user_name == '')
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

		$upos	= strpos($acls, "\n".$user_name."\n");
		$aupos	= strpos($acls, "\n!".$user_name."\n");
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
			if ($user_name == GUEST || $user_name == '')
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
		$aliases = array();

		if (!isset($this->config['aliases']) || !is_array($this->config['aliases']))
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

	// check if user has the right to upload files
	function can_upload($global = false)
	{
		if ($this->get_user())
		{
			$user_name		= strtolower($this->get_user_name());
			$registered		= true;
		}
		else
		{
			$user_name		= GUEST;
			$registered		= false;
		}

		if ($registered)
		{
			if ($global == false)
			{
				if ( ( $this->config['upload'] === true
						|| $this->config['upload'] == 1
						|| $this->check_acl($user_name, $this->config['upload']) )
					&& (   $this->has_access('upload')
						&& $this->has_access('write')
						&& $this->has_access('read')
						|| $this->is_owner()
						|| $this->is_admin() )
						|| (isset($_POST['to']) && $_POST['to'] == 'global') // for action -> upload handler
					)
				{
					#echo '[debug] TRUE local';
					return true;
				}
			}
			else if ($global == true)
			{
				if ( $this->config['upload'] === true
						|| $this->config['upload'] == 1
						|| $this->check_acl($user_name, $this->config['upload'])
						#	|| (isset($_POST['to']) && $_POST['to'] == 'global') // for action -> upload handler
						)
				{
					#echo '[debug] TRUE global';
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	// WATCHES
	function is_watched($user_id, $page_id)
	{
		return $this->load_single(
			"SELECT watch_id ".
			"FROM ".$this->config['table_prefix']."watch ".
			"WHERE user_id		= '".(int)$user_id."' ".
				"AND page_id	= '".(int)$page_id."' ".
			"LIMIT 1");
	}

	function set_watch($user_id, $page_id)
	{
		// Remove old watch first to avoid double watches
		$this->clear_watch($user_id, $page_id);

		if ($this->has_access('read', $page_id))
		{
			$this->sql_query(
				"INSERT INTO ".$this->config['table_prefix']."watch (user_id, page_id) ".
				"VALUES (	'".(int)$user_id."',
							'".(int)$page_id."')" );
				// TIMESTAMP type is filled automatically by MySQL
		}
	}

	function clear_watch($user_id, $page_id)
	{
		return $this->sql_query(
			"DELETE FROM ".$this->config['table_prefix']."watch ".
			"WHERE user_id		= '".(int)$user_id."' ".
				"AND page_id	= '".(int)$page_id."'");
	}

	// REVIEW
	function set_review($reviewer_id, $page_id)
	{
		// set / unset review
		if ($this->has_access('read', $page_id))
		{
			$reviewed = !$this->page['reviewed'];

			return $this->sql_query(
				"UPDATE ".$this->config['table_prefix']."page SET ".
					"reviewed		= '".(int)$reviewed."', ".
					"reviewed_time	= UTC_TIMESTAMP(), ".
					"reviewer_id	= '".(int)$reviewer_id."' ".
				"WHERE page_id = '".(int)$page_id."' ".
				"LIMIT 1");

		}
		else
		{
			return false;
		}
	}

	// MENUS
	function get_default_menu($lang = '')
	{
		if (!$lang)
		{
			$lang = $this->get_user_language();
		}

		$user_id = $this->get_user_id('System');
		return $this->get_user_menu($user_id, $lang);
	}

	function get_user_menu($user_id, $lang = '')
	{
		$user_menu_formatted = array();

		// avoid results if $user_id is 0 (user does not exists)
		if ($user_id)
		{
			$user_menu = $this->load_all(
				"SELECT p.page_id, p.tag, p.title, m.menu_title, m.menu_lang ".
				"FROM ".$this->config['table_prefix']."menu m ".
					"LEFT JOIN ".$this->config['table_prefix']."page p ON (m.page_id = p.page_id) ".
				"WHERE m.user_id = '".(int)$user_id."' ".
					($lang
						? "AND m.menu_lang = '".quote($this->dblink, $lang)."' "
						: "").
				"ORDER BY m.menu_position", true);

			foreach ($user_menu as $menu_item)
			{
				$title = $menu_item['menu_title'];
				if ($title === '')
				{
					$title = $menu_item['title'];
				}
				$user_menu_formatted[] = array(
					$menu_item['page_id'],
					(($title !== '')? $title : $menu_item['tag']),
					'(('.$menu_item['tag'].
						(($title !== '')? ' '.$title : '').
						($menu_item['menu_lang']? ' @@'.$menu_item['menu_lang'] : '').
					'))',
					$menu_item['menu_lang']
				);
			}
		}
		return $user_menu_formatted;
	}

	function set_menu($set = MENU_AUTO, $update = false)
	{
		$menu_page_ids = @$this->sess->menu_page_id ?: [];
		$menu_formatted = @$this->sess->menu ?: [];

		$user = $this->get_user();

		// initial menu table construction
		if ($set != MENU_AUTO || !($menu_formatted || $update) )
		{
			$menu = 0;
			if ($set != MENU_DEFAULT)
			{
				$menu = $this->get_user_menu($user['user_id']);
				$this->sess->menu_default = false;
			}
			if (!$menu)
			{
				$menu = $this->get_default_menu();
				$this->sess->menu_default = true;
			}

			// parsing menu items into link table
			$menu_page_ids = array();
			$menu_formatted = array();
			foreach ($menu as $menu_item)
			{
				$menu_page_ids[] = $menu_item[0];
				$menu_item[2] = $this->format($menu_item[2], 'wacko');
				$menu_formatted[] = $menu_item;
			}
		}

		// adding new menu item
		if (@$_GET['addbookmark'] && $user)
		{
			unset($_GET['addbookmark']);
			// writing menu item
			if (!in_array($this->page['page_id'], $menu_page_ids))
			{
				$position = $this->load_single(
					"SELECT MAX(m.menu_position) AS max_position ".
					"FROM ".$this->config['table_prefix']."menu m ".
					"WHERE m.user_id = '".$user['user_id']."' ", false);
				$position = (int)$position['max_position'];
				if (!$position)
				{
					// prepopulate user menu with default menu items
					foreach ($menu_formatted as $menu_item)
					{
						$this->sql_query(
							"INSERT INTO ".$this->config['table_prefix']."menu SET ".
							"user_id			= '".$user['user_id']."', ".
							"page_id			= '".$menu_item[0]."', ".
							"menu_lang			= '".$menu_item[3]."', ".
							"menu_position		= '".++$position."'");
					}
					$this->sess->menu_default = false;
				}

				$title = $this->get_page_title();
				$lang = ($user['user_lang'] != $this->page_lang)? $this->page_lang : '';
				$menu_page_ids[] = $this->page['page_id'];
				$menu_formatted[] = array(
					$this->page['page_id'],
					($title? $title : $this->tag),
					$this->format('(('.$this->tag.($title? ' '.$title : '').($lang? ' @@'.$lang : '').'))', 'wacko'),
					$lang
				);

				$this->sql_query(
					"INSERT INTO ".$this->config['table_prefix']."menu SET ".
					"user_id			= '".$user['user_id']."', ".
					"page_id			= '".$this->page['page_id']."', ".
					"menu_lang			= '".quote($this->dblink, $lang)."', ".
					"menu_position		= '".++$position."'");
			}
		}

		// removing menu item
		if (@$_GET['removebookmark'] && $user && !$this->sess->menu_default)
		{
			unset($_GET['removebookmark']);
			// rewriting menu table except containing current page tag
			$prev = $menu_formatted;
			$menu_page_ids = array();
			$menu_formatted = array();
			foreach ($prev as $menu_item)
			{
				if ($menu_item[0] != $this->page['page_id'])
				{
					$menu_page_ids[] = $menu_item[0];
					$menu_formatted[] = $menu_item;
				}
			}

			$this->sql_query(
				"DELETE FROM ".$this->config['table_prefix']."menu ".
				"WHERE user_id = '".$user['user_id']."' ".
					"AND page_id = '".$this->page['page_id']."'");
			if (!$menu_formatted)
			{
				$this->set_menu(MENU_DEFAULT);
			}
		}

		$this->sess->menu_page_id = $menu_page_ids;
		$this->sess->menu = $menu_formatted;
	}

	function get_menu()
	{
		return @$this->sess->menu;
	}

	function get_menu_links()
	{
		return @$this->sess->menu_page_id;
	}

	function get_menu_default()
	{
		return (!isset($this->sess->menu_default)) || $this->sess->menu_default;
	}

	// TODO: do not add
	// - comments, system pages, methodes,
	// - url arguments ?profile= array('page_id', 'arguments')
	// - add parameter for trail size in user settings ?
	// parse only once, without included pages (avoid call in run function!)
	//		$size	=
	function set_user_trail($size = 5)
	{
		$page_id = $this->page['page_id'];

		if ( $size )
		{
			#echo '### 1';
			if (isset($this->sess->user_trail))
			{
				$count = count($this->sess->user_trail);
				#echo '### @: ['.$count.']';

				#Ut::debug_print_r($this->sess->user_trail);

				if (isset($this->sess->user_trail[$count - 1][0])
					&&    $this->sess->user_trail[$count - 1][0] == $page_id)
				{
					#echo '### 2: ['.$count.']';
					// nothing
				}
				else
				{
					#echo '### 3';

					if (count($this->sess->user_trail) > $size)
					{
						#echo '### 4';
						$this->sess->user_trail	= array_slice($this->sess->user_trail, -5 );
						#Ut::debug_print_r($this->sess->user_trail);
					}

					#echo '### 5';
					$_user_trail[-1]	= array ($page_id, $this->page['tag'], $this->page['title']);
					$user_trail			= $this->sess->user_trail + $_user_trail;
					$user_trail			= array_values($user_trail);

					$this->sess->user_trail = $user_trail;
				}
			}
			else
			{
				#echo '### 6';
				$this->sess->user_trail[] = array ($page_id, $this->page['tag'], $this->page['title']);
			}
		}
	}

	// USER TRAIL navigation
	//		call this function in your theme header or footer
	//		$separator	= &gt; &raquo;
	function get_user_trail($titles = false, $separator = ' &gt; ', $linking = true, $size)
	{
		// don't call this inside the run function, it will also writes all included pages
		// in the user trail because the engine parses them before it includes them
		$this->set_user_trail($size);

		if (isset($this->sess->user_trail))
		{
			$links		= $this->sess->user_trail;
			#$count		= count($this->sess->user_trail);
			$result		= '';
			$size		= (int)$size;
			$i			= 0;

			#Ut::debug_print_r($links);

			foreach ($links as $link)
			{
				if ($i < $size && $this->page['page_id'] != $link[0])
				{
					if ($titles == false)
					{
						$result .= $this->link($link[1], '', $link[1]).$separator;
					}
					else if ($linking == true)
					{
						$result .= $this->link($link[1], '', $link[2]).$separator;
					}
					else
					{
						$result .= $link[2].' '.$separator.' ';
					}
				}

				$i++;
			}

			if ($titles == false)
			{
				$result .= $this->page['tag'];
			}
			else
			{
				$result .= $this->page['title'];
			}

			return $result;
		}
	}

	// MAINTENANCE

	function maintenance()
	{
		$now = time();
		$update = [];

		// purge referrers (once a day)
		if (($days = $this->config->referrers_purge_time) > 0
				&& $now > $this->config->maint_last_refs)
		{
			$this->sql_query(
				"DELETE FROM ".$this->config->table_prefix."referrer ".
				"WHERE referrer_time < DATE_SUB(UTC_TIMESTAMP(), INTERVAL '".(int)$days."' DAY)");

			$update['maint_last_refs'] = $now + 1 * DAYSECS;
			$this->log(7, 'Maintenance: referrers purged');
		}

		// purge outdated pages revisions (once a week)
		if (($days = $this->config->pages_purge_time) > 0
				&& $now > $this->config->maint_last_oldpages)
		{
			$this->sql_query(
				"DELETE FROM ".$this->config->table_prefix."revision ".
				"WHERE modified < DATE_SUB(UTC_TIMESTAMP(), INTERVAL '".(int)$days."' DAY)");

			$update['maint_last_oldpages'] = $now + 7 * DAYSECS;
			$this->log(7, 'Maintenance: outdated pages revisions purged');
		}

		// purge deleted pages (once per 3 days)
		if (($days = $this->config->keep_deleted_time) > 0
				&& $now > $this->config->maint_last_delpages)
		{
			list($pages, ) = $this->load_deleted(1000, 0);

			$remove = [];
			$past = $now - DAYSECS * $days;
			foreach ($pages as $page)
			{
				if (strtotime($page['modified']) < $past)
				{
					$remove[] = $page['page_id'];
				}
			}

			if ($remove)
			{
				$this->delete_pages($remove);
				$this->log(7, 'Maintenance: deleted pages purged');
			}
			$update['maint_last_delpages'] = $now + 3 * DAYSECS;
		}

		// purge system log entries (once per 3 days)
		if (($days = $this->config->log_purge_time) > 0
				&& $now > $this->config['maint_last_log'])
		{
			$this->sql_query(
				"DELETE FROM {$this->config->table_prefix}log ".
				"WHERE log_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL '".(int)$days."' DAY )");

			$update['maint_last_log'] = $now + 3 * DAYSECS;

			$this->log(7, 'Maintenance: system log purged');
		}

		// remove outdated pages cache, purge sql cache (once per hour)
		if ($now > $this->config->maint_last_cache)
		{
			// pages cache
			if (($ttl = $this->config->cache_ttl) > 0)
			{
				// clear from db
				$this->sql_query(
					"DELETE FROM ".$this->config->table_prefix."cache ".
					"WHERE cache_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL '".(int)$ttl."' SECOND )");

				if (Ut::purge_directory(CACHE_PAGE_DIR, $ttl))
				{
					$this->log(7, 'Maintenance: cached pages purged');
				}
			}

			// sql query cache
			if (($ttl = $this->config->cache_sql_ttl) > 0)
			{
				if (Ut::purge_directory(CACHE_SQL_DIR, $ttl))
				{
					$this->log(7, 'Maintenance: cached sql results purged');
				}
			}

			$update['maint_last_cache'] = $now + 3600;
		}

		// purge expired cookie_tokens (once per 3 days)
		if (($days = 3)
				&& $now > $this->config->maint_last_session)
		{
			$this->delete_cookie_token('', true, $days);

			$update['maint_last_session'] = $now + 3 * DAYSECS;
			$this->log(7, 'Maintenance: expired cookie_tokens purged');
		}

		$this->config->_set($update);
	}

	// MAIN EXECUTION ROUTINE
	function run()
	{
		$tag	= $this->http->page;
		$method	= $this->http->method;

		// mandatory tls?
		if ($this->db->tls_implicit && !$this->http->tls_session)
		{
			$this->http->ensure_tls($this->href($method, $tag));
		}

		// url lang selection
		$url	= explode('@@', $tag);
		$tag	= trim($url[0]);
		$lang	= trim(@$url[1]); // STS: unused! remove?
		$user	= '';

		if (!$tag)
		{
			$tag = $this->config->root_page;
		}

		// autotasks
		if (!(time() % 3))
		{
			$this->maintenance();
		}

		// parse authentication cookie and get user data
		$auth = $this->decompose_auth_cookie();

		if ($auth['login_token'])
		{
			$login_token	= hash('sha1', $auth['login_token']);
			$user			= $this->load_user(false, 0, $auth['password'], true, $login_token );
		}

		// check session validity
		if (isset($user['session_expire']) && $user['session_expire'] != 0
			&& time() < $user['session_expire']
			&& time() < $auth['session_expire']
			&& $user['session_expire'] == $auth['session_expire']
			&& $auth['recalc_mac'] == $auth['cookie_mac'])
		{
			$session = true;
		}
		else
		{
			// log event: invalid auth cookie
			if ($auth['recalc_mac'] != $auth['cookie_mac'])
			{
				$this->log(1, '!!**'.'Malformed/forged user authentication cookie detected. Destroying existing session (if any)'.'!!**');
			}

			$session = false;

			// terminate expired/invalid session
			if ($this->get_user())
			{
				// log event: session expired
				if (time() > $auth['session_expire'])
				{
					$this->log(2, 'Expired user session terminated');
				}

				$this->log_user_out();
				#$this->redirect($this->config['base_url'].$this->config['login_page'].'?goback='.$tag); // TODO: $this->get_translation('LoginPage') and $this->config['login_page'] -> multilanguage: we need encoding related default pages till we use utf-8
				$this->redirect($this->config['base_url'].$this->get_translation('LoginPage').'?goback='.$tag);
			}
		}

		// check IP validity
		if ($this->get_user_setting('validate_ip') && $this->get_user_setting('ip') != $this->get_user_ip())
		{
			$this->log(1, '<strong><span class="cite">'.'User in-session IP change detected '.$this->get_user_setting('ip').' to '.$this->get_user_ip().'</span></strong>');
			$this->log_user_out();
			#$this->redirect($this->config['base_url'].$this->config['login_page'].'?goback='.$tag);
			$this->redirect($this->config['base_url'].$this->get_translation('LoginPage').'?goback='.$tag);
			$session = false;
		}

		// start user session
		if (!$this->get_user() && $session === true && $user == true)
		{
			$this->restart_user_session($user, $auth['session_expire']);
			$this->set_user($user, 1);

			unset($user);
		}

		$user = $this->get_user();

		unset($auth);

		// user settings
		$this->user_lang = $this->get_user_language();
		$this->set_language($this->user_lang, true);

		if (isset($user['theme']))
		{
			$this->config['theme']		= $user['theme'];
			$this->config['theme_url']	= $this->config['base_url'].Ut::join_path(THEME_DIR, $this->config['theme']).'/';
		}

		// SEO
		foreach ($this->search_engines as $engine)
		{
			if (stristr($_SERVER['HTTP_USER_AGENT'], $engine))
			{
				$this->resource['OuterLink2']	= '';
				$this->resource['OuterIcon']	= '';
			}
		}

		// permalink
		$page = 0;
		if ($method == 'Hashid')
		{
			$method = '';
			$ids = explode('x', $tag);
			$revision_id = $this->load_single(
				"SELECT revision_id ".
				"FROM {$this->config['table_prefix']}revision ".
				"WHERE page_id = '".$ids[0]."' ".
					"AND version_id = '".$ids[1]."' ".
				"LIMIT 1");
			$revision_id = $revision_id?  $revision_id['revision_id'] : 0;
			$page = $this->load_page('', $ids[0], $revision_id, '', '', $this->is_admin());
			if ($page)
			{
				$this->method = 'show';
				$this->tag = $page['tag'];
				$this->supertag = $page['supertag'];
				$_GET['revision_id'] = $revision_id;
			}
		}

		if (!$page)
		{
			if (!($this->method = trim($method)))
			{
				$this->method = 'show';
			}

			// normalizing tag name
			if (!preg_match('/^['.$this->language['ALPHANUM_P'].'\!]+$/', $tag))
			{
				$tag = $this->try_utf_decode($tag);
			}

			$tag = str_replace("'", '_', str_replace('\\', '', str_replace('_', '', $tag)));
			$tag = preg_replace('/[^'.$this->language['ALPHANUM_P'].'\_\-\.]/', '', $tag);

			$this->tag		= $tag;
			$this->supertag	= $this->translit($tag);

			$revision_id	= isset($_GET['revision_id']) ? (int)$_GET['revision_id'] : '';

			// show also $deleted = 1
			if ($this->is_admin())
			{
				$page		= $this->load_page($this->tag, 0, $revision_id, '', '', true);
			}
			else
			{
				$page		= $this->load_page($this->tag, 0, $revision_id);
				#$page		= $this->load_page($this->tag, 0, $revision_id, '', '', true);
			}

			// TODO: obsolete? Add description what it does
			// creates dummy array
			if ($this->config['outlook_workaround'] && !$page)
			{
				$page = $this->load_page($this->supertag."'", 0, $revision_id);
			}
		}

		$this->set_page($page); // the only call

		if ($this->config['enable_referrers'])
		{
			$this->log_referrer();
		}

		$this->set_menu();

		// charset
		$this->charset = $this->get_charset();

		if ($this->page)
		{
			// override perpage settings
			$page_options = [
				'footer_comments',
				'footer_files',
				'footer_rating',
				'hide_toc',
				'hide_index',
				'tree_level',
				'allow_rawhtml',
				'disable_safehtml',
				'theme',
			];

			foreach ($page_options as $key)
			{
				// ignore perpage page settings with empty / null as value
				if (!Ut::is_empty($val = $this->page[$key]))
				{
					$this->config[$key] = $val;
				}
			}

			$this->config['theme_url'] = $this->config['base_url'] . Ut::join_path(THEME_DIR, $this->config['theme']) . '/';

			// set page categories. this defines $categories (array) object property
			$categories = $this->load_categories('', $this->page['page_id']);

			foreach ($categories as $word)
			{
				$this->categories[$word['category_id']] = $word['category'];
			}

			unset($categories, $word);
		}

		if (!$user && $this->page['modified'])
		{
			header('Last-Modified: ' . Ut::http_date(strtotime($this->page['modified']) + 120));
		}

		// check page watching
		if ($user && $this->page && $this->is_watched($user['user_id'], $this->page['page_id']))
		{
			$this->is_watched = true;
		}

		// check revision hideing (1 - guests, 2 - registered users)
		$this->hide_revisions = ($this->page && !$this->is_admin() && (
			($this->config['hide_revisions'] == 1 && !$this->get_user()) ||
			($this->config['hide_revisions'] == 2 && !$this->is_owner())));

		// forum page
		$this->forum = !!(preg_match('/'.$this->config['forum_cluster'].'\/.+?\/.+/', $this->tag) ||
			($this->page['comment_on_id'] ? preg_match('/'.$this->config['forum_cluster'].'\/.+?\/.+/', $this->get_page_tag($this->page['comment_on_id'])) : ''));

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
			else if (preg_match('/wordprocessor$/', $this->method))
			{
				$mod = 'wordprocessor';
			}
			else
			{
				$mod = '';
			}

			$this->cache_links();
			$this->current_context++;
			$this->context[$this->current_context] = $this->tag;
			$data = $this->method($this->method);
			$this->current_context--;
			echo $this->theme_header($mod).$data.$this->theme_footer($mod);
		}

		// NB: never been here if redirect() called!
		$this->write_sitemap();

		return $this->tag;
	}

	// TOC MANIPULATIONS
	function set_toc_array($toc)
	{
		$this->body_toc = '';

		foreach ($toc as $k => $v)
		{
			$toc[$k] = implode('<heading,col>', $v);
		}

		$this->body_toc = implode('<heading,row>', $toc);
	}

	function build_toc($tag, $from, $to, $numerate, $link = -1)
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

		$page['body_toc'] = (isset($page['body_toc']) ? $page['body_toc'] : null);

		$toc = explode('<heading,row>', $page['body_toc']);

		foreach ($toc as $k => $toc_item)
		{
			$toc[$k] = explode('<heading,col>', $toc_item);
		}

		$_toc = array();

		foreach ($toc as $k => $toc_item)
		{
			if (isset($toc_item[2]))
			{
				// '(include)' - included toc
				if ($toc_item[2] == 99999)
				{
					if (!in_array($toc_item[0], $this->toc_context))
					{
						if (!($toc_item[0] == $this->tag))
						{
							array_push($this->toc_context, $toc_item[0]);
							$_toc = array_merge($_toc, $this->build_toc($toc_item[0], $from, $to, $numerate, $link));
							array_pop($this->toc_context);
						}
					}
				}
				else
				{
					// '(p)' - paragraph
					if ($toc_item[2] == 77777)
					{
						$toc[$k][3]	= $_link;
						$_toc[]		= &$toc[$k];
					}
					else
					{
						if (($toc_item[2] >= $from) && ($toc_item[2] <= $to))
						{
							$toc[$k][3]	= $_link;
							$_toc[]		= &$toc[$k];
							$toc[$k][1]	= $this->format($toc[$k][1], 'post_wacko');
						}
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
			// #2. find all <hX></hX> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<h([0-9]) id=\"(h[0-9]+-[0-9]+)\">(.*?)</h\\2>)!i",
				array(&$this, 'numerate_toc_callback_toc'), $what);
		}

		if (isset($this->post_wacko_action['p']))
		{
			// #2. find all <p class="auto"> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<p class=\"auto\" id=\"(p[0-9]+-[0-9]+)\">(.+?)</p>)!is",
				array(&$this, 'numerate_toc_callback_p'), $what);
		}

		return $what;
	}

	function numerate_toc_callback_toc($matches)
	{
		return '<h'.$matches[2].' id="'.$matches[3].'">'.
			(isset($this->post_wacko_toc_hash[$matches[3]][1])
				? $this->post_wacko_toc_hash[$matches[3]][1]
				: $matches[4]).
			'</h'.$matches[2].'>';
	}

	function numerate_toc_callback_p($matches)
	{
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

		return $style['_before'].'<p class="auto" id='.$matches[2].'>'.
			$style['before'].$matches[3].$style['after'].
			'</p>'.$style['_after'];
	}

	// BREADCRUMBS -- navigation inside WackoClusters
	function get_page_path($titles = false, $separator = '/', $linking = true, $root_page = false)
	{
		$result = '';

		// check if current page is home page
		$_root_page	= !strcasecmp($this->config['root_page'], $this->tag);

		// adds home page in front of breadcrumbs or current page is home page
		if ($_root_page || $root_page)
		{
			$result .= $this->compose_link_to_page($this->config['root_page']);
		}

		if (!$_root_page)
		{
			$link = '';
			foreach (explode('/', $this->tag) as $step)
			{
				if ($link)
				{
					$link .= '/';
				}
				$link .= $step;

				if ($result)
				{
					$result .= $separator;
				}

				if ($linking && $link != $this->tag)
				{
					$result .= $this->link($link, '', ($titles? $this->get_page_title($link) : $step));
				}
				else
				{
					$result .= $titles? $this->get_page_title($link) : $step;
				}
			}
		}

		return $result;
	}

	// $page_id is preferred, $tag next
	function get_page_title($tag = '', $page_id = 0)
	{
		$tag = trim($tag, '/');
		if ($tag || $page_id)
		{
			$page = $this->load_single(
				"SELECT title ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE ".( $page_id
					? "page_id	= '".(int)$page_id."' "
					: "tag	= '".quote($this->dblink, $tag)."' " ).
				"LIMIT 1");

			$title = $page['title'];
		}
		else
		{
			$title = @$this->page['title'];
		}
		// default page title is just page's WikiName
		return $title? $title : $this->add_spaces_title(trim(substr($this->tag, strrpos($this->tag, '/')), '/'));
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
			$clone_supertag = $this->translit($clone_tag);
		}

		// load page and site information
		$page		= $this->load_page($tag);
		$new_tag	= $clone_tag;

		return
			// save
			$this->save_page($new_tag, $page['title'], $page['body'], $edit_note, 0, 0, 0, 0, $page['page_lang'], false, false);
	}

	function rename_page($tag, $new_tag, $new_supertag = '')
	{
		if (!$tag || !$new_tag)
		{
			return false;
		}

		if ($new_supertag == '')
		{
			$new_supertag = $this->translit($new_tag);
		}

		// determine the depth
		$_depth_array	= explode('/', $new_tag);
		$new_depth		= count($_depth_array);

		return
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."revision SET ".
					"tag		= '".quote($this->dblink, $new_tag)."', ".
					"supertag	= '".quote($this->dblink, $new_supertag)."' ".
				"WHERE tag		= '".quote($this->dblink, $tag)."' ")
			&&
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."page  SET ".
					"tag		= '".quote($this->dblink, $new_tag)."', ".
					"supertag	= '".quote($this->dblink, $new_supertag)."', ".
					"depth	= '".quote($this->dblink, $new_depth)."' ".
				"WHERE tag		= '".quote($this->dblink, $tag)."' ");
	}

	// REMOVALS
	function remove_acls($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$this->sql_query(
			"DELETE a.* ".
			"FROM ".$this->config['table_prefix']."acl a ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (a.page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );

		return true;
	}

	function delete_pages($pages)
	{
		$remove = [];
		$rev = array_flip($this->page_id_cache);
		foreach ($pages as $id)
		{
			$remove[] = "'" . $id . "'";
			unset($this->page_id_cache[@$rev[$id]]);
		}

		$remove = implode(', ', $remove);
		$this->sql_query(
			"DELETE FROM {$this->config['table_prefix']}page ".
			"WHERE page_id IN ( ".$remove." )");
		$this->sql_query(
			"DELETE FROM {$this->config['table_prefix']}revision ".
			"WHERE page_id IN ( ".$remove." )");
	}

	function remove_page($page_id, $comment_on_id = 0, $dontkeep = 0)
	{
		if (!$page_id || !($page = $this->load_page('', $page_id)))
		{
			return false;
		}

		// store a copy in revision
		if ($this->config['store_deleted_pages'] && !$dontkeep)
		{
			// unlink comment tag
			$page['comment_on_id']	= 0;

			// saving original
			$this->save_revision($page);

			// saving updated for the current user and flag it as deleted
			$this->sql_query(
				"UPDATE {$this->config['table_prefix']}page SET ".
					"modified	= UTC_TIMESTAMP(), ".
					"ip			= '".$this->get_user_ip()."', ".
					"deleted	= '1', ".
					// "edit_note	= '".$this->get_user_ip()."', ". // removed
					"user_id	= '".$this->get_user_id()."' ".
				"WHERE page_id	= '".(int)$page_id."' ".
				"LIMIT 1");
		}
		else
		{
			$this->delete_pages([$page_id]);
		}

		// update for removed comment correct comments count and date on commented page
		if ($comment_on_id)
		{
			$this->update_comments_count($comment_on_id);
		}

		return true;
	}

	function remove_revisions($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->sql_query(
			"DELETE FROM {$this->config['table_prefix']}revision ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
				($cluster
					? "OR tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );
	}

	function remove_comments($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		if ($comments = $this->load_all(
		"SELECT a.page_id FROM ".$this->config['table_prefix']."page a ".
			"INNER JOIN ".$this->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
		"WHERE b.tag = '".quote($this->dblink, $tag)."' ".
			($cluster === true
				? "OR b.tag LIKE '".quote($this->dblink, $tag)."/%' "
				: "") )
			)
		{
			foreach ($comments as $comment)
			{
				$this->remove_page($comment['page_id'], '', $dontkeep);
			}
		}

		// reset comments count
		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}page SET ".
				"comments	= '0', ".
				"commented	= created ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );

		return true;
	}

	function remove_menu_items($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->sql_query(
			"DELETE b.* ".
			"FROM ".$this->config['table_prefix']."menu b ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (b.page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );
	}

	function remove_watches($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->sql_query(
			"DELETE w.* ".
			"FROM ".$this->config['table_prefix']."watch w ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (w.page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );
	}

	function remove_ratings($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->load_all(
			"SELECT page_id FROM {$this->config['table_prefix']}page ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );

		foreach ($pages as $page)
		{
			$this->sql_query(
				"DELETE FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = '{$page['page_id']}'");
		}

		return true;
	}

	function remove_links($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->sql_query(
			"DELETE l.* ".
			"FROM ".$this->config['table_prefix']."link l ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (l.from_page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );
	}

	function remove_categories($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$this->sql_query(
			"DELETE k.* ".
			"FROM {$this->config['table_prefix']}category_page k ".
				"LEFT JOIN ".$this->config['table_prefix']."page p ".
					"ON (k.page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );

		return true;
	}

	function remove_referrers($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->sql_query(
			"DELETE ".
				"r.* ".
			"FROM ".$this->config['table_prefix']."referrer r ".
				"INNER JOIN ".$this->config['table_prefix']."page p ON (r.page_id = p.page_id) ".
			"WHERE p.tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR p.tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );
	}

	function remove_files($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->load_all(
			"SELECT page_id ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
				($cluster === true
					? "OR tag LIKE '".quote($this->dblink, $tag)."/%' "
					: "") );

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->load_all(
				"SELECT file_name ".
				"FROM {$this->config['table_prefix']}upload ".
				"WHERE page_id = '".$page['page_id']."'");

			// store a copy in ...
			if ($this->config['store_deleted_pages'] && !$dontkeep)
			{
				// TODO: moved to backup folder
				/*foreach ($files as $file)
				{
					// remove from FS
					$file_name = Ut::join_path(UPLOAD_PER_PAGE_DIR, '@'.
							$page['page_id'].'@'.$file['file_name']);

					@unlink($file_name);
				}*/

				// flag record as deleted in DB
				$this->sql_query(
					"UPDATE {$this->config['table_prefix']}upload SET ".
						"deleted	= '1' ".
					"WHERE page_id = '".$page['page_id']."'");
			}
			else
			{
				foreach ($files as $file)
				{
					// remove from FS
					$file_name = Ut::join_path(UPLOAD_PER_PAGE_DIR, '@'.
						$page['page_id'].'@'.$file['file_name']);

					@unlink($file_name);
				}

				// remove from DB
				$this->sql_query(
					"DELETE FROM {$this->config['table_prefix']}upload ".
					"WHERE page_id = '".$page['page_id']."'");
			}
		}

		return true;
	}

	function restore_page($page_id)
	{
		if (!$page_id)
		{
			return false;
		}

		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}page SET ".
				"deleted	= '0' ".
			"WHERE page_id = '".(int)$page_id."'");
	}

	function restore_file($page_id)
	{
		if (!$page_id)
		{
			return false;
		}

		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}upload SET ".
				"deleted	= '0' ".
			"WHERE page_id = '".(int)$page_id."'");
	}

	// ADDITIONAL METHODS

	// run checks of password complexity under current
	// config settings; returned error diag, or '' if good
	function password_complexity($login, $pwd)
	{
		$unlike_login	= $this->config['pwd_unlike_login'];
		$char_classes	= $this->config['pwd_char_classes'];
		$min_chars		= $this->config['pwd_min_chars'];
		$res			= '';

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
		$error = 0;
		switch ($unlike_login)
		{
			case 2:	// don't run this check if login is much shorter than password or vice versa
				if (($l > 4 && $p > 4) && $r < 4)
				{
					$error += (stristr($login, $pwd) !== false || stristr($pwd, $login) !== false);
				}
			case 1:
				$error += (strcasecmp($login, $pwd) === 0);
		}
		if ($error)
		{
			$res .= $this->get_translation('PwdCplxEquals') . ' ';
		}

		// check password length
		if ($p < $min_chars)
		{
			$res .= $this->get_translation('PwdCplxShort') . ' ';
		}

		// check character classes requirements
		$error = 0;
		switch ($char_classes)
		{
			case 1:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[a-zA-Zà-ÿÀ-ß]+/', $pwd))
				{
					++$error;
				}
				break;

			case 2:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd))
				{
					++$error;
				}
				break;

			case 3:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd) ||
					!preg_match('/[\W]+/', $pwd))
				{
					++$error;
				}
				break;
		}
		if ($error)
		{
			$res .= $this->get_translation('PwdCplxWeak') . ' ';
		}

		if (preg_match('/\s/', $pwd))
		{
			$res .= $this->get_translation('SpacesArentAllowed') . ' ';
		}

		return $res;
	}

	function show_password_complexity()
	{
		if ($this->config['pwd_char_classes'] > 0)
		{
			$pwd_cplx_text = $this->get_translation('PwdCplxDesc4');

			if ($this->config['pwd_char_classes'] == 1)
			{
				$pwd_cplx_text .= $this->get_translation('PwdCplxDesc41');
			}
			else if ($this->config['pwd_char_classes'] == 2)
			{
				$pwd_cplx_text .= $this->get_translation('PwdCplxDesc42');
			}
			else if ($this->config['pwd_char_classes'] == 3)
			{
				$pwd_cplx_text .= $this->get_translation('PwdCplxDesc43');
			}

			$pwd_cplx_text .= '. '.$this->get_translation('PwdCplxDesc5');
		}

		return '<br /><small>'.
			$this->get_translation('PwdCplxDesc1').
			Ut::perc_replace($this->get_translation('PwdCplxDesc2'), $this->config['pwd_min_chars']).
			($this->config['pwd_unlike_login'] > 0
				? ', '.$this->get_translation('PwdCplxDesc3')
				: '').
			($this->config['pwd_char_classes'] > 0
				? ', '.$pwd_cplx_text
				: '')."</small>";
	}

	// pages listing/navigation for multipage lists.
	//		$total		= total elements in the list
	//		$perpage	= total elements on a page
	//		$name		= page number variable in $_GET
	//		$params		= $_GET parameters to be passed with the page link
	// returns an array with 'text' (navigation) and 'offset' (offset value
	// for SQL queries) elements.
	function pagination($total, $perpage = 100, $name = 'p', $params = '', $method = '', $tag = '')
	{
		if ($perpage < 1)
		{
			$perpage = 10; // no division by zero
		}
		if ($total <= $perpage) {
			// single page
			return ['offset' => 0, 'text' => ''];
		}

		// multipage with navigation
		$sep		= ', ';
		$span		= ' ... ' . $sep;
		$total		-= 1;
		$pages		= ($total - $total % $perpage) / $perpage + 1;
		$page		= @$_GET[$name];
		$page		= ($page == 'last')? $pages : (int)$page;

		if ($params)
		{
			$params = '&amp;' . $params;
		}

		if ($page <= 0 || $page > $pages)
		{
			$page = 1;
		}

		$make_link = function ($page, $body = '', $attrs = '') use ($method, $tag, $name, $params)
		{
			return '<a href="' . $this->href($method, $tag, $name . '=' . $page . $params) . '"' . $attrs . '>' .
					($body? $body : $page) . '</a>';
		};

		$make_list = function ($from, $to) use ($page, $pages, $make_link, $sep)
		{
			$list = '';

			for ($p = $from; $p <= $to; $p++)
			{
				$list .= ' ';
				if ($p != $page)
				{
					$list .= $make_link($p);
				}
				else // don't make link for the current page
				{
					$list .= '<strong>' . $p . '</strong>';
				}
				if ($p != $pages)
				{
					$list .= $sep;
				}
			}

			return $list;
		};

		$pagination['offset'] = $perpage * ($page - 1);

		$navigation = $this->get_translation('ToThePage') . ': ';

		if ($page > 1)
		{
			$navigation .= $make_link($page - 1, ('&laquo; ' . $this->get_translation('PrevAcr')), ' rel="prev"') . ' ';
		}

		// pages range links
		if ($pages <= 10)	// not so many pages, list all
		{
			$navigation .= $make_list(1, $pages);
		}
		else if ($page <= 4 || $page > $pages - 4)	// current page is near the beginning or the end
		{
			$navigation .= $make_list(1, 5);
			$navigation .= $span;
			$navigation .= $make_list($pages - 4, $pages);
		}
		else	// current page is in the middle of the list
		{
			$navigation .= $make_list(1, 1);
			$navigation .= $span;
			$navigation .= $make_list($page - 2, $page + 2);
			$navigation .= $span;
			$navigation .= $make_list($pages, $pages);
		}

		// next page shortcut
		if ($page < $pages)
		{
			$navigation .= ' ' . $make_link($page + 1, ($this->get_translation('NextAcr') . ' &raquo;'), 'rel="next"');
		}

		$pagination['text'] = $navigation;
		return $pagination;
	}

	// TODO: option for _comments handler, forum action -> CSS small
	function show_pagination($pagination = '')
	{
		if ($pagination)
		{
			$pagination = '<nav class="pagination">'.$pagination."</nav>\n";
		}
		return $pagination;
	}

	function print_pagination($pagination)
	{
		if (@$pagination['text'])
		{
			echo '<nav class="pagination">' . $pagination['text'] . "</nav>\n";
		}
	}


	// show captcha form on a page. must be incorporated as an input
	// form component in every page that uses captcha testing
	//		$inline	= adds <br /> between elements
	function show_captcha($inline = true)
	{
		// Don't load the captcha at all if the GD extension isn't enabled
		if (extension_loaded('gd'))
		{
			// check whether anonymous user
			// anonymous user has no name
			// if false, we assume it's anonymous
			if ($this->get_user_name() == false)
			{
				// disable server cache for page
				$this->http->no_cache(false);

				echo $inline ? '' : "<br />\n";
				echo '<label for="captcha">'.$this->get_translation('Captcha').":</label>\n";
				echo $inline ? '' : "<br />\n";
				echo '<img src="'.$this->config['base_url'].'lib/captcha/freecap.php?for=' . $this->sess->name().'" id="freecap" alt="'.$this->get_translation('Captcha').'" />'."\n";
				echo '<a href="" onclick="this.blur(); new_freecap(); return false;" title="'.$this->get_translation('CaptchaReload').'">';
				echo '<img src="'.$this->config['base_url'].'image/spacer.png" alt="'.$this->get_translation('CaptchaReload').'" class="btn-reload"/></a>'."<br />\n";
				#echo $inline ? '' : "<br />\n";
				echo '<input type="text" id="captcha" name="captcha" maxlength="6" style="width: 273px;" />';
				echo $inline ? '' : "<br />\n";
			}
		}
	}

	// checks whether user's captcha solution was right. function
	// takes no arguments, instead it recieves user input from
	// HTTP-POST variable 'captcha', submitted through webform.
	function validate_captcha()
	{
		// Don't load the captcha at all if the GD extension isn't enabled
		if (extension_loaded('gd'))
		{
			// check whether anonymous user
			// anonymous user has no name
			// if false, we assume it's anonymous
			if ($this->get_user_name() == false)
			{
				//anonymous user, check the captcha
				if (!empty($this->sess->freecap_word_hash) && !empty($_POST['captcha']))
				{
					if ($this->sess['hash_func'](strtolower($_POST['captcha'])) == $this->sess->freecap_word_hash)
					{
						// reset freecap session vars
						// cannot stress enough how important it is to do this
						// defeats re-use of known image with spoofed session id
						$this->sess->freecap_attempts = 0;
						$this->sess->freecap_word_hash = false;

						// now process form
						$word_ok = true;
					}
					else
					{
						$word_ok = false;
					}
				}
				else
				{
					$word_ok = false;
				}

				return $word_ok;
			}
		}
	}

	// Check for valid email address.
	//		$email_address = email address to check
	// returns boolean
	// true		- valid
	// false	- invalid
	function validate_email($email_address)
	{
		if ($this->config['email_pattern'] == 'html5')
		{
			// Use the pattern given by the HTML5 spec for 'email' type form input elements
			// http://www.w3.org/TR/html5/forms.html#valid-e-mail-address
			$HTML5_email_pattern = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}' .
								'[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/sD';

			return (boolean) preg_match($HTML5_email_pattern, $email_address);
		}
		else
		{
			// Use PHP built-in FILTER_VALIDATE_EMAIL, does not allow 'dotless' domains;
			// http://php.net/filter.filters.validate
			return (boolean) filter_var($email_address, FILTER_VALIDATE_EMAIL);
		}
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
		$this->config['allow_rawhtml'] = 0;			// STS: touching config considered a hack
		$message	= ( isset($this->language) ? $this->format($message, 'wacko') : $message );
		$user_id	= $this->get_user_id();
		$this->config['allow_rawhtml'] = $html;

		// current timestamp set automatically
		return $this->sql_query(
			"INSERT INTO {$this->config['table_prefix']}log SET ".
				"level		= '".(int)$level."', ".
				"user_id	= '".($user_id ? (int)$user_id : 0 )."', ".
				"ip			= '".quote($this->dblink, $this->get_user_ip())."', ".
				"message	= '".quote($this->dblink, $message)."'");
	}

	function get_categories($page_id, $cache = true)
	{
		$_category = '';

		if ($categories	= $this->load_categories('', $page_id, $cache = true))
		{
			foreach ($categories as $id => $category)
			{
				if ($id > 0)
				{
					$_category .= ', ';
				}

				$_category .= '<a href="'.$this->href('', '', 'category='.$category['category_id']).'" class="tag" rel="tag">' .htmlspecialchars($category['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</a>';
			}

			return $_category;
		}
		else
		{
			return false;
		}
	}

	// load categories for the page's particular language.
	// if root string value is passed, returns number of
	// pages under each category and below defined root
	// page
	function get_categories_list($lang, $cache = true, $root = false)
	{
		$categories = array();

		if ($_categories = $this->load_all(
		"SELECT category_id, parent_id, category ".
		"FROM {$this->config['table_prefix']}category ".
		"WHERE category_lang = '".quote($this->dblink, $lang)."' ".
		"ORDER BY parent_id ASC, category ASC", $cache))
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
				"WHERE k.category_lang = '".quote($this->dblink, $lang)."' AND kp.category_id = k.category_id ".
					( $root != ''
						? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) "
						: '' ).
				"GROUP BY category_id", true))
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
					'parent_id'	=> $word['parent_id'],
					'category'	=> $word['category'],
					'n'			=> (isset($counts[$word['category_id']]) ? $counts[$word['category_id']] : '')
				);
			}

			foreach ($categories as $id => $word)
			{
				if (isset($categories[$word['parent_id']]))
				{
					$categories[$word['parent_id']]['childs'][$id] = $word;
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
		$ids = '';
		$values = '';

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
					$values[] = "(".(int)$id.", '".(int)$page_id."')";
				}

				$this->sql_query(
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

	function binary_multiples($size, $prefix = true, $short = true, $rounded = false, $suffix = true)
	{
		if(is_numeric($size))
		{
			if($prefix === true)
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
				$size = round($size, 0);
			}
			else
			{
				$size = sprintf('%01.2f', $size);
			}

			if($suffix === true)
			{
				$size= $size . '&nbsp;' . $norm[$x];
			}

			return $size;
		}
	}

	function binary_multiples_factor ($size, $prefix = true)
	{
		$count	= 9; #count($norm) -1;
		$x		= 0;

		if($prefix === true)
		{
			$factor = 1000;
		}
		else
		{
			$factor = 1024;
		}

		while ($size >= $factor && $x < $count)
		{
			$size /= $factor;
			$x++;
		}

		return $x;
	}

	// to use by actions to add some inside <head> e.g. to adding custom css
	function add_html_head($text)
	{
		$this->html_head .= $text;
	}
}
