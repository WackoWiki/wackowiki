<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// engine class
class Wacko
{
	var $charset;
	var $config;							// @deprecated, but will live for a looong time
	var $db;								// new config
	var $http;
	var $sess;
	var $dblink;
	var $page;								// requested page
	var $tag;
	var $method					= '';
	var $supertag;
	var $forum					= false;
	var $categories;
	var $is_watched				= false;
	var $hide_revisions			= false;
	var $_acl					= [];
	var $acl_cache				= [];
	var $page_id_cache			= [];
	var $context				= [];		// page context, used for correct processing of inclusions
	var $current_context		= 0;		// current context level
	var $header_count			= 0;
	var $page_meta				= 'page_id, owner_id, user_id, tag, supertag, created, modified, edit_note, minor_edit, latest, handler, comment_on_id, page_lang, title, keywords, description';
	var $first_inclusion		= [];		// for backlinks
	var $format_safe			= true;		// for htmlspecialchars() in pre_link
	var $unicode_entities		= [];		// common unicode array
	var $toc_context			= [];
	var $search_engines			= ['bot', 'rambler', 'yandex', 'crawl', 'search', 'archiver', 'slurp', 'aport', 'crawler', 'google', 'inktomi', 'spider'];
	var $languages				= null;
	var $translations			= null;
	var $wanted_cache			= null;
	var $page_cache				= null;
	var $_formatter_noautolinks	= null;
	var $numerate_links			= null;
	var $post_wacko_action		= null;
	var $page_lang		 		= null;
	var $html_head				= '';
	var $hide_article_header	= false;
	var $no_way_back			= false;	// set to true to prevent saving page as the goback-after-login
	var $paragrafica_styles		= [
		'before'	=> [
						'_before'	=> '',
						'_after'	=> '',
						'before'	=> '<span class="pmark">[##]</span><br />',
						'after'		=> ''],
		'after'		=> [
						'_before'	=> '',
						'_after'	=> '',
						'before'	=> '',
						'after'		=> '<span class="pmark">[##]</span>'],
		'right'		=> [
						'_before'	=> '<div class="pright"><div class="p-">&nbsp;<span class="pmark">[##]</span></div><div class="pbody-">',
						'_after'	=> '</div></div>',
						'before'	=> '',
						'after'		=> ''],
		'left'		=> [
						'_before'	=> '<div class="pleft"><div class="p-"><span class="pmark">[##]</span>&nbsp;</div><div class="pbody-">',
						'_after'	=> '</div></div>',
						'before'	=> '',
						'after'		=> ''],
	];
	var $paragrafica_patches = [
		'before'	=> ['before'],
		'after'		=> ['after'],
		'right'		=> ['_before'],
		'left'		=> ['_before'],
	];
	var $translit_macros = [
		'âèêè'		=> 'wiki',
		'âàêà'		=> 'wacko',
		'âåá'		=> 'web',
	];
	var $time_intervals = [
		365*DAYSECS	=> 'Year',
		30*DAYSECS	=> 'Month',
		7*DAYSECS	=> 'Week',
		DAYSECS		=> 'Day',
		60*60		=> 'Hour',
		60			=> 'Minute',
	];

	/**
	* CONSTRUCTOR
	*
	* Crates an instance of Wacko object
	* @param array $config Current configuration as map key=value
	*
	* @return Wacko
	*/
	function __construct(&$config, &$http)
	{
		$this->dblink	=						// for quote() calls
		$this->db		=
		$this->config	= & $config;
		$this->http		= & $http;
		$this->sess		= & $http->sess;
	}

	// DATABASE

	// Backward compatibility wrapper for legacy sql functions

	/**
	 * @deprecated use db->sql_query() instead
	 */
	function sql_query($query, $debug = 0)
	{
		return $this->dblink->sql_query($query, $debug);
	}

	/**
	 * @deprecated use db->load_all() instead
	 */
	function load_all($query, $docache = false)
	{
		return $this->dblink->load_all($query, $docache);
	}

	/**
	 * @deprecated use db->load_single() instead
	 */
	function load_single($query, $docache = false)
	{
		return $this->dblink->load_single($query, $docache);
	}

	// MISC
	function get_page_tag($page_id = 0)
	{
		$page = $this->db->load_single(
			"SELECT tag " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE page_id = '" . (int) $page_id . "' " .
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
		{
			if (!isset($this->page_id_cache[$tag]))
			{
				$page = $this->db->load_single(
					"SELECT page_id " .
					"FROM " . $this->db->table_prefix . "page " .
					"WHERE tag = " . $this->db->q($tag) . " " .
					"LIMIT 1");

				$page_id = $page['page_id'];

				// cache it
				$this->page_id_cache[$tag] = $page_id;
			}
			else
			{
				$page_id = $this->page_id_cache[$tag];
			}

			return $page_id;
		}
	}

	function get_wacko_version()
	{
		return WACKO_VERSION;
	}

	// FILE FUNCTIONS

	/**
	* Check if file with filename exists. Check only DB entry,
	* not file in FS
	*
	* @param string $file_name Filename
	* @param string $unwrapped_tag Optional. Unwrapped supertag. If
	* not set, then check if file exists in global space
	* @param boolean $deleted
	*
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
			$file = $this->db->load_single(
				"SELECT file_id, page_id, user_id, file_name, file_size, file_lang, file_description, picture_w, picture_h, file_ext " .
				"FROM " . $this->db->table_prefix . "file " .
				"WHERE page_id = '" . (int) $page_id . "' " .
					"AND file_name = " . $this->db->q($file_name) . " " .
					($deleted != 1
						? "AND deleted <> '1' "
						: "") .
				"LIMIT 1");
		}

		return $file;
	}

	static function get_file_extension($file_name)
	{
		if (strpos($file_name, '.') === false)
		{
			return '';
		}

		$file_name = explode('.', $file_name);
		return array_pop($file_name);
	}

	function upload_quota($user_id = '')
	{
		// get used upload quota
		$files	= $this->db->load_single(
				"SELECT SUM(file_size) AS used_quota " .
				"FROM " . $this->db->table_prefix . "file " .
					($user_id
						? "WHERE user_id = '{$user_id}' "
						: "") .
				"LIMIT 1");

		$used_upload_quota = $files['used_quota'];

		return $used_upload_quota;
	}

	function available_themes()
	{
		$theme_list	= [];

		foreach (Ut::file_glob(THEME_DIR, '*/appearance/header.php') as $file)
		{
			$theme			= substr($file, strlen(THEME_DIR) + 1);
			$theme			= substr($theme, 0, strpos($theme, '/'));
			$theme_list[]	= $theme;
		}

		sort($theme_list, SORT_STRING);

		if (($allow = preg_split('/[\s,]+/', $this->db->allow_themes, -1, PREG_SPLIT_NO_EMPTY)) && $allow[0])
		{
			$theme_list = array_intersect($theme_list, $allow);
		}

		return $theme_list;
	}

	// TIME FUNCTIONS
	function utc2localtime($utc)
	{
		$user	= $this->get_user();
		$tz		= ($user
					? $user['timezone'] + $user['dst']
					: $this->db->timezone + $this->db->dst);

		return $utc + $tz * 3600;
	}

	function sql2localtime($text)
	{
		return $this->db->is_null_date($text)? 0 : $this->utc2localtime(strtotime($text));
	}

	function sql2datetime($text, &$date, &$time)
	{
		$local	= $this->sql2localtime($text);
		$date	= date($this->db->date_format, $local);
		$time	= date($this->db->time_format, $local);
	}

	function sql2precisetime($text)
	{
		$local	= $this->sql2localtime($text);

		return date($this->db->date_format . ' ' . $this->db->time_format_seconds, $local);
	}

	function get_time_formatted($text) // STS: rename to sql_time_formatted
	{
		$local_time = $this->sql2localtime($text);

		// TODO: made format depended from localization and user preferences?
		// default: d.m.Y H:i

		// XXX: testing strftime(), charset issue with CP1251
		#setlocale(LC_TIME, $this->language['locale']);
		#setlocale(LC_TIME, 'ru_RU.UTF-8');
		#return $this->try_utf_decode(strftime('%d. %B %Y' . ' ' . '%H.%M', $local_time));

		$relative_time = 0;

		if ($relative_time)
		{
			return $this->get_time_interval($local_time);
		}
		else
		{
			return date($this->db->date_format . ' ' . $this->db->time_format, $local_time);
		}

		// TODO: add options for ..
		# return $this->get_unix_time_formatted($this->sql2localtime($text));
		# return $this->get_time_interval($local_time, false);
	}

	function get_unix_time_formatted($local)
	{
		return date($this->db->date_format . ' ' . $this->db->time_format_seconds, $local);
	}

	// e.g. <time datetime="2017-03-17T12:34:26+01:00" title="17 March 2017 12:34">3 hours ago</time>
	function get_time_interval($text, $strip = false)
	{
		$ago = time() - $text;
		$res = 0 . $this->_t('MinutesAgo');

		foreach ($this->time_intervals as $val => $name)
		{
			if ($ago >= $val)
			{
				$interval	= ($ago - $ago % $val) / $val;
				$res		= Ut::perc_replace($this->_t($name . ($interval == 1 ? '' : 's') . 'Ago'), $interval);

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

		if ($old_lang != $lang && $this->known_language($lang))
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
			$lang_file = Ut::join_path(LANG_DIR, 'wacko.' . $lang . '.php');

			if (@file_exists($lang_file))
			{
				include $lang_file;
			}

			// wacko.all.php $wacko_all_resource[]
			if (!isset($this->translations['all']))
			{
				$wacko_all_resource = [];
				$lang_file = Ut::join_path(LANG_DIR, 'wacko.all.php');

				if (@file_exists($lang_file))
				{
					include $lang_file;
				}

				// stored in object required for merge with all language files,
				// but not with multilanguages off
				$this->translations['all'] = & $wacko_all_resource;
			}

			$ap_translation		= [];
			$theme_translation	= [];
			$theme_translation0	= [];

			if ($this->db->ap_mode)
			{
				// ap.xy.php $ap_translation[]
				$lang_file = 'admin/lang/ap.' . $lang . '.php';

				if (@file_exists($lang_file))
				{
					include $lang_file;
				}
			}
			else
			{
				// TODO: only default and users theme's language loaded.... need to fix for themes_per_page sites w/ nonempty theme lang files
				// theme lang files $theme_translation[]
				$lang_file = Ut::join_path(THEME_DIR, $this->db->theme, 'lang/wacko.' . $lang . '.php');

				if (@file_exists($lang_file))
				{
					include $lang_file;
				}

				$theme_translation0 = $theme_translation;

				// wacko.all theme
				$theme_translation = [];
				$lang_file = Ut::join_path(THEME_DIR, $this->db->theme, 'lang/wacko.all.php');

				if (@file_exists($lang_file))
				{
					include $lang_file;
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
	*
	* @param string $lang Language code
	*/
	function load_lang($lang)
	{
		if ($lang && !isset($this->languages[$lang]))
		{
			$lang_file = Ut::join_path(LANG_DIR, 'lang.' . $lang . '.php');
			$wacko_language = [];
			require $lang_file;

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
	*
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
				// system language is always allowed
				if (!in_array($this->db->language, $allow))
				{
					$allow[] = $this->db->language;
				}

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

	function known_language($lang)
	{
		return array_key_exists($lang, $this->available_languages());
	}

	// negotiate language with user's browser
	function user_agent_language()
	{
		$lang = $this->db->language;

		if ($this->db->multilanguage && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
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
		$lang = $this->get_user_setting('user_lang');

		if (!$this->known_language($lang))
		{
			$lang = $this->user_agent_language();
		}

		return $lang;
	}

	/**
	 * Get translation of available message set
	 *
	 * @param string $name Name of message set
	 * @param string $lang Language code
	 * @param bool $dounicode
	 *
	 * @return string Message set
	 */
	function _t($name, $lang = '', $dounicode = true)
	{
		if ($this->db->multilanguage)
		{
			if ($lang === SYSTEM_LANG)
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

	// wrapper for get and format message set translation
	function format_t($name, $lang = '')
	{
		$string = $this->_t($name, $lang, false);
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

		if (!$this->known_language($lang))
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
	*
	* @return string Converted string
	*/
	function do_unicode_entities($string, $lang)
	{
		if (!$this->db->multilanguage)
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

	function try_utf_decode($string)
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
		$decrement	= [];
		$shift		= [];

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
	*
	* @return string
	*/
	function translit($tag, $strtolow = TRANSLIT_LOWERCASE, $donotload = TRANSLIT_LOAD)
	{
		// Lookup transliteration result in the cache and return it if found
		static $translit_cache;
		$cach_key = $tag . $strtolow . $donotload;

		if (isset($translit_cache[$cach_key]))
		{
			return $translit_cache[$cach_key];
		}

		$_lang = null;

		if (!$this->db->multilanguage)
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
					$lang = $this->db->language;
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
			foreach ($this->translit_macros as $macro => $value)
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
		else if ($this->db->meta_keywords)
		{
			$meta_keywords = $this->db->meta_keywords;
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

		return $meta_keywords;
	}

	function get_description()
	{
		$meta_description = '';

		if ($this->page['description'])
		{
			$meta_description = $this->page['description'];
		}
		else if ($this->db->meta_description)
		{
			$meta_description = $this->db->meta_description;
		}

		return $meta_description;
	}

	// wrapper for _load_page
	/**
	* Loads page from DB
	*
	* @param string $tag Page tag or supertag
	* @param int $page_id
	* @param int $revision_id
	* @param int $cache If LOAD_CACHE then tries to load page from cache, if LOAD_NOCACHE - then doesn't.
	* @param int $metadataonly If LOAD_ALL loads all page fields including page body, if LOAD_META - only page_meta fields.
	* @param boolean $deleted
	*
	* @return array Loaded page
	*/
	function load_page($tag, $page_id = 0, $revision_id = '', $cache = LOAD_CACHE, $metadata_only = LOAD_ALL, $deleted = 0)
	{
		$page = '';

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
			$what_p =	'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, '.
						'p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.latest, p.handler, p.comment_on_id, '.
						'p.page_lang, p.keywords, p.description, p.noindex, p.deleted, u.user_name, o.user_name AS owner_name';
			$what_r =	'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.version_id, '.
						'p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.latest, p.handler, p.comment_on_id, '.
						'p.page_lang, p.keywords, p.description, s.noindex, p.deleted, u.user_name, o.user_name AS owner_name';
		}
		else
		{
			$what_p =	'p.*, u.user_name, o.user_name AS owner_name';
			$what_r =	'p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.title, p.created, p.modified, p.version_id, '.
						'p.body, p.body_r, p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.reviewed_time, '.
						'p.reviewer_id, p.ip, p.latest, p.deleted, p.handler, p.comment_on_id, p.page_lang, '.
						'p.description, p.keywords, s.footer_comments, s.footer_files, s.footer_rating, s.hide_toc, '.
						's.hide_index, s.tree_level, s.allow_rawhtml, s.disable_safehtml, s.noindex, s.theme, '.
						'u.user_name, o.user_name AS owner_name';
		}

		if (!$page)
		{
			if ($supertagged || $page_id)
			{
				$page = $this->db->load_single(
					"SELECT " . $what_p . " " .
					"FROM " . $this->db->table_prefix . "page p " .
						"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
						"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
					"WHERE " . ($page_id != 0
						? "page_id  = '" . (int) $page_id . "' "
						: "supertag = " . $this->db->q($supertag) . " " ) .
						($deleted != 1
							? "AND p.deleted <> '1' "
							: "") .
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id)
				{
					$this->cache_page($page, $page_id, $metadata_only);

					$page = $this->db->load_single(
						"SELECT p.revision_id, " . $what_r . " " .
						"FROM " . $this->db->table_prefix . "revision p " .
							"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
							"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
							"LEFT JOIN " . $this->db->table_prefix . "page s ON (p.page_id = s.page_id) " .
						"WHERE " . ($page_id != 0
							? "p.page_id  = '" . (int) $page_id . "' "
							: "p.supertag = " . $this->db->q($supertag) . " " ) .
							($deleted != 1
								? "AND p.deleted <> '1' "
								: "") .
							"AND revision_id = '" . (int) $revision_id . "' " .
						"LIMIT 1");

					$page['owner_id'] = $owner_id;
				}
			}
			else if (!preg_match('/[^' . $this->language['ALPHANUM_P'] . '\_\-]/', $tag))
			{
				$page = $this->db->load_single(
					"SELECT " . $what_p . " " .
					"FROM " . $this->db->table_prefix . "page p " .
						"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
						"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
					"WHERE tag = " . $this->db->q($tag) . " " .
						($deleted != 1
							? "AND p.deleted <> '1' "
							: "") .
					"LIMIT 1");

				$owner_id = $page['owner_id'];

				if ($revision_id)
				{
					$this->cache_page($page, $page_id, $metadata_only);

					$page = $this->db->load_single(
						"SELECT " . $what_r . " " .
						"FROM " . $this->db->table_prefix . "revision p " .
							"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
							"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
							"LEFT JOIN " . $this->db->table_prefix . "page s ON (p.page_id = s.page_id) " .
						"WHERE p.tag = " . $this->db->q($tag) . " " .
							($deleted != 1
								? "AND p.deleted <> '1' "
								: "") .
							"AND revision_id = '" . (int) $revision_id . "' " .
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
	*
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
	* Put page in page cache.
	*
	* @param array $page Page data
	* @param int $page_id
	* @param boolean $metadataonly Marks that page contains metadata only (all atributes, excepts page body)
	*/
	function cache_page($page, $page_id = 0, $metadata_only = 0)
	{
		// cache for both cases (id + tag) to avoid roundtrips
		$this->page_cache['page_id'][$page['page_id']]				= $page;
		$this->page_cache['page_id'][$page['page_id']]['mdonly']	= $metadata_only;

		if (!$page['supertag'])
		{
			$page['supertag'] = $this->translit($page['tag'], TRANSLIT_LOWERCASE, TRANSLIT_DONTLOAD);
		}

		$this->page_cache['supertag'][$page['supertag']]			= $page;
		$this->page_cache['supertag'][$page['supertag']]['mdonly']	= $metadata_only;
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
	*
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
		$pages		= '';
		$page_id	= [];
		$acl		= '';
		$user		= $this->get_user();
		$lang		= $this->get_user_language();

		// get page links
		if ($links = $this->db->load_all(
			"SELECT to_tag " .
			"FROM " . $this->db->table_prefix . "page_link " .
			"WHERE from_page_id = '" . $this->page['page_id'] . "'"))
		{
			foreach ($links as $link)
			{
				$pages[] = $link['to_tag'];
			}
		}

		// get menu links
		if ($menu_items = $this->db->load_all(
			"SELECT DISTINCT p.tag " .
			"FROM " . $this->db->table_prefix . "menu b " .
				"LEFT JOIN " . $this->db->table_prefix . "page p ON (b.page_id = p.page_id) " .
			"WHERE (b.user_id = '" . $this->get_user_id('System') . "' " .
				($lang
					? "AND b.menu_lang = " . $this->db->q($lang) . " "
					: "") .
					") " .
				($user
					? "OR (b.user_id = '" . $user['user_id'] . "' ) "
					: "") .
			"", true))
		{
			foreach ($menu_items as $item)
			{
				$pages[] = $item['tag'];
			}
		}

		// get default links
		if (isset($user['user_name']))
		{
			$pages[]	= $this->db->users_page . '/' . $user['user_name'];
			$pages[]	= $this->_t('AccountLink');
		}
		else
		{
			$pages[]	= $this->_t('RegistrationPage');
		}

		$pages[]	= $this->db->root_page;
		$pages[]	= $this->db->users_page;
		$pages[]	= $this->db->policy_page;
		$pages[]	= $this->_t('LoginPage');
		$pages[]	= $this->_t('SearchPage');
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
				$spages_str	.= $this->db->q($_spages) . ", ";
			}
		}

		$spages_str	= substr($spages_str, 0, strlen($spages_str) - 2);

		if ($links = $this->db->load_all(
		"SELECT " . $this->page_meta . " " .
		"FROM " . $this->db->table_prefix . "page " .
		"WHERE supertag IN (" . $spages_str . ")", true))
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

		foreach ((array) $notexists as $notexist)
		{
			if (isset($pages[array_search($notexist, $spages)]))
			{
				$this->cache_wanted_page($pages[array_search($notexist, $spages)], 0, 1);
				#$this->cache_acl($this->get_page_id($notexist), 'read', 1, $acl);
			}
		}

		$page_ids	= implode(', ', $page_id);

		// hack to avoid multiple queries to get non-read privileges
		if ($acls = $this->db->load_all(
			"SELECT page_id, privilege, list " .
			"FROM " . $this->db->table_prefix . "acl " .
			"WHERE page_id IN (" . $page_ids . ") " .
			#	"AND privilege = 'read'" .
			"", true))
		{
			foreach ($acls as $acl)
			{
				#$this->cache_acl($acl['page_id'], 'read', 1, $acl);
				$this->cache_acl($acl['page_id'], $acl['privilege'], 1, $acl);
			}
		}
	}

	function set_page($page)
	{
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

		if ($this->known_language($page['page_lang']))
		{
			$this->page_lang = $page['page_lang'];
		}
		else if (@$_REQUEST['add'] && $this->known_language(@$_REQUEST['lang']))
		{
			$this->page_lang = $_REQUEST['lang'];
		}
		else if (@$_REQUEST['add'])
		{
			$this->page_lang = $this->user_lang;
		}
		else
		{
			$this->page_lang = $this->db->language;
		}
	}

	// STANDARD QUERIES
	function load_revisions($page_id, $hide_minor_edit = 0, $show_deleted = 0)
	{
		$page_meta = 'p.page_id, p.version_id, p.owner_id, p.user_id, p.tag, p.supertag, p.modified, p.edit_note, p.minor_edit, '.
					 'p.page_size, p.reviewed, p.latest, p.comment_on_id, p.title, u.user_name, o.user_name as reviewer ';

		$revisions = $this->db->load_all(
			"SELECT p.revision_id, " . $page_meta . " " .
			"FROM " . $this->db->table_prefix . "revision p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.reviewer_id = o.user_id) " .
			"WHERE p.page_id = '" . (int) $page_id . "' " .
				($hide_minor_edit
					? "AND p.minor_edit = '0' "
					: "") .
				(!$show_deleted
					? "AND p.deleted <> '1' "
					: "") .
			"ORDER BY p.modified DESC");

		if ($revisions)
		{
			if (($cur = $this->db->load_single(
				"SELECT 0 AS revision_id, " . $page_meta . " " .
				"FROM " . $this->db->table_prefix . "page p " .
					"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
					"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.reviewer_id = o.user_id) " .
				"WHERE p.page_id = '" . (int) $page_id . "' " .
					($hide_minor_edit
						? "AND p.minor_edit = '0' "
						: "") .
					(!$show_deleted
						? "AND p.deleted <> '1' "
						: "") .
				"ORDER BY p.modified DESC " .
				"LIMIT 1")))
			{
				array_unshift($revisions, $cur);
			}
		}
		else
		{
			$revisions = $this->db->load_all(
				"SELECT 0 AS revision_id, " . $page_meta . " " .
				"FROM " . $this->db->table_prefix . "page p " .
					"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
					"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.reviewer_id = o.user_id) " .
				"WHERE p.page_id = '" . (int) $page_id . "' " .
					(!$show_deleted
						? "AND p.deleted <> '1' "
						: "") .
				"ORDER BY p.modified DESC " .
				"LIMIT 1");
		}

		return $revisions;
	}

	function count_revisions($page_id, $hide_minor_edit = 0, $show_deleted = 0)
	{
		$count = $this->db->load_single(
			"SELECT COUNT(page_id) AS n " .
			"FROM " . $this->db->table_prefix . "revision " .
			"WHERE page_id = '" . (int) $page_id . "' " .
				($hide_minor_edit
					? "AND minor_edit = '0' "
					: "") .
				(!$show_deleted
					? "AND deleted <> '1' "
					: "") .
			"LIMIT 1");

		return $count? $count['n'] : 0;
	}

	function load_pages_linking_to($to_tag, $tag = '')
	{
		return $this->db->load_all(
			"SELECT p.page_id, p.tag AS tag, p.title " .
			"FROM " . $this->db->table_prefix . "page_link l " .
				"INNER JOIN " . $this->db->table_prefix . "page p ON (p.page_id = l.from_page_id) " .
			"WHERE " . ($tag
				? "p.tag LIKE " . $this->db->q($tag . '/%') . " AND "
				: "") .
				"(l.to_supertag = " . $this->db->q($this->translit($to_tag)) . ") " .
			"ORDER BY tag", true);
	}

	function load_file_usage($file_id, $tag = '')
	{
		return $this->db->load_all(
			"SELECT p.page_id, p.tag AS tag, p.title " .
			"FROM " . $this->db->table_prefix . "file_link l " .
				"INNER JOIN " . $this->db->table_prefix . "page p ON (p.page_id = l.page_id) " .
				"INNER JOIN " . $this->db->table_prefix . "file u ON (u.file_id = l.file_id) " .
			"WHERE " . ($tag
					? "p.tag LIKE " . $this->db->q($tag . '/%') . " AND "
					: "") .
				"l.file_id = '" . (int) $file_id . "' " .
			"ORDER BY tag", true);
	}

	function load_changed($limit = 100, $tag = '', $from = '', $minor_edit = '', $default_pages = false, $deleted = 0)
	{
		// count pages
		$count_pages = $this->db->load_single(
			"SELECT COUNT(p.page_id) AS n " .
			"FROM " . $this->db->table_prefix . "page p " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"WHERE p.comment_on_id = '0' " .
				($from
					? "AND p.modified <= " . $this->db->q($from . ' 23:59:59') . " "
					: "") .
				($tag
					? "AND p.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
					: "") .
				($minor_edit
					? "AND p.minor_edit = '0' "
					: "") .
				(!$deleted
					? "AND p.deleted <> '1' "
					: "") .
				(!$default_pages
					? "AND (u.account_type = '0' OR p.user_id = '0') "
					: "")
			);

		$pagination = $this->pagination($count_pages['n'], $limit);

		if (($pages = $this->db->load_all(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.title, p.created, p.modified, p.edit_note, p.minor_edit, p.reviewed, p.latest, p.handler, p.comment_on_id, p.page_lang, p.page_size, r1.page_size as parent_size, u.user_name " .
		"FROM " . $this->db->table_prefix . "page p " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
			"INNER JOIN " . $this->db->table_prefix . "revision r1 ON (p.page_id = r1.page_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "revision r2 ON (p.page_id = r2.page_id AND r1.revision_id < r2.revision_id) " .
		"WHERE p.comment_on_id = '0' " .
			($from
				? "AND p.modified <= " . $this->db->q($from . ' 23:59:59') . " "
				: "") .
			($tag
				? "AND p.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
				: "") .
			($minor_edit
				? "AND p.minor_edit = '0' "
				: "") .
			(!$deleted
				? "AND p.deleted <> '1' "
				: "") .
			(!$default_pages
				? "AND (u.account_type = '0' OR p.user_id = '0') "
				: "") .
			"AND r2.revision_id IS NULL " .
		"ORDER BY p.modified DESC " .
		$pagination['limit'], true)))
		{
			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if (($read_acls = $this->db->load_all(
			"SELECT a.page_id, a.privilege, a.list " .
			"FROM " . $this->db->table_prefix . "acl a " .
				"INNER JOIN " . $this->db->table_prefix . "page p ON (a.page_id = p.page_id) " .
			"WHERE p.comment_on_id = '0' " .
				"AND a.page_id = p.page_id " .
				($tag
					? "AND p.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
					: '') .
				"AND a.privilege = 'read' " .
			"ORDER BY modified DESC " .
			"LIMIT {$pagination['perpage']}", true)))
			{
				foreach ($read_acls as $read_acl)
				{
					$this->cache_acl($read_acl['page_id'], 'read', 1, $read_acl);
				}
			}

			return [$pages, $pagination];
		}
	}

	// used for comment feed
	function load_comment($limit = 100, $tag = '', $deleted = 0)
	{
		$limit = $this->get_list_count($limit);

		if ($pages = $this->db->load_all(
		"SELECT c.page_id, c.owner_id, c.tag, c.supertag, c.title, c.created, c.modified, c.edit_note, c.minor_edit, c.latest, c.handler, c.comment_on_id, c.page_lang, c.body_r, u.user_name, p.title AS page_title, p.tag AS page_tag " .
		"FROM " . $this->db->table_prefix . "page c " .
			"LEFT JOIN " . $this->db->table_prefix . "user u ON (c.user_id = u.user_id) " .
			"LEFT JOIN " . $this->db->table_prefix . "page p ON (c.comment_on_id = p.page_id) " .
		"WHERE c.comment_on_id <> '0' " .
			($tag
				? "AND p.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
				: "") .
			($deleted != 1
				? "AND p.deleted <> '1' AND c.deleted <> '1' "
				: "") .
		"ORDER BY c.modified DESC " .
		"LIMIT " . $limit))
		{
			#$count		= count($pages['page_id']);
			#$pagination = $this->pagination($count, $limit);

			foreach ($pages as $page)
			{
				$this->cache_page($page, 0, 1);
			}

			if ($read_acls = $this->db->load_all(
			"SELECT a.page_id, a.privilege, a.list " .
			"FROM " . $this->db->table_prefix . "acl a " .
				"INNER JOIN " . $this->db->table_prefix . "page p ON (a.page_id = p.page_id) " .
			"WHERE p.comment_on_id = '0' " .
				"AND a.page_id = p.page_id " .
					($tag
						? "AND p.supertag LIKE " . $this->db->q($this->translit($tag) . '/%') . " "
						: "") .
				"AND a.privilege = 'read' " .
			"ORDER BY created DESC " .
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

		$count_deleted = $this->db->load_single(
			"SELECT COUNT(page_id) AS n " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE deleted = '1' LIMIT 1"
			, $cache);

		if ($count_deleted['n'])
		{
			$pagination = $this->pagination($count_deleted['n'], $limit);

			$deleted = $this->db->load_all(
				"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.created, p.modified, p.edit_note,
						p.minor_edit, p.latest, p.handler, p.comment_on_id, p.page_lang, p.title, p.keywords,
						p.description, u.user_name " .
				"FROM " . $this->db->table_prefix . "page p " .
					"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
				"WHERE p.deleted = '1' " .
				"ORDER BY p.modified DESC, p.tag ASC " .
				$pagination['limit'], $cache);
		}

		return [$deleted, $pagination];
	}

	function load_categories($object_id = 0, $type_id = 1, $cache = false)
	{
		$categories = $this->db->load_all(
			"SELECT c.category_id, c.category " .
			"FROM " . $this->db->table_prefix . "category c " .
				"INNER JOIN " . $this->db->table_prefix . "category_assignment ca ON (c.category_id = ca.category_id) " .
			"WHERE ca.object_id  = '" . (int) $object_id . "' " .
			($type_id != 0
				? "AND ca.object_type_id = '" . (int) $type_id . "' "
				: "AND ca.object_type_id = '" . (int) $type_id . "' " ) // TODO: explode array IN
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
		if ($this->db->spam_filter)
		{
			// TODO: read table word and cache it
			if (($spam = file(Ut::join_path(CONFIG_DIR, 'antispam.conf'))))
			{
				foreach ($spam as $one)
				{
					if (stripos($text, trim($one)) !== false)
					{
						return $this->_t('PotentialSpam') . ' : <code>' . $one . '</code>';
					}
				}
			}
		}
	}

	/**
	 * Page saving routine
	 *
	 * @param string	$tag			page address
	 * @param string	$title			page name (metadata)
	 * @param string	$body			page body (plain text)
	 * @param string	$edit_note		edit summary
	 * @param integer	$minor_edit		minor edit
	 * @param integer	$reviewed
	 * @param integer	$comment_on_id	commented page_id
	 * @param integer	$parent_id		commented parent id
	 * @param string	$lang			page language
	 * @param boolean	$mute			supress email reminders and xml rss recompilation
	 * @param string	$user_name		attach guest pseudonym
	 * @param boolean	$user_page		user is page owner
	 *
	 * @return string	$body_r
	 */
	function save_page($tag, $title = '', $body, $edit_note = '', $minor_edit = 0, $reviewed = 0, $comment_on_id = 0, $parent_id = 0, $lang = '', $mute = false, $user_name = '', $user_page = false)
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
		if (isset($_POST['tag']))
		{
			$this->tag		= $tag = $_POST['tag'];
			$this->supertag	= $this->translit($tag);
		}

		if (!$this->translit($tag))
		{
			return;
		}

		// cache handling
		if ($this->db->cache)
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

			$this->db->invalidate_sql_cache();
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
				$desc = (strlen($desc) > 240 ? substr($desc, 0, 240) . '[..]' : $desc . ' [..]');
			}

			// PreFormatter (macros and such)
			$body = $this->format($body, 'pre_wacko');

			// making page body components
			$body_r		= $this->format($body, 'wacko');
			$body_toc	= '';

			if ($this->db->paragrafica && !$comment_on_id)
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
			if (!($old_page = $this->load_page('', $page_id, '', '', '', 1)))
			{
				if (empty($lang))
				{
					$lang = @$_REQUEST['lang'];

					if (!$this->known_language($lang))
					{
						$lang = $this->user_lang;
					}
				}

				if (!$lang)
				{
					$lang = $this->db->language;
				}

				$this->set_language($lang);

				// getting title
				if (!$title)
				{
					if ($comment_on_id)
					{
						$title = $this->_t('Comment') . ' ' . substr($tag, 7);
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

					$acl['write']	= $write_acl['list'];

					$read_acl		= $this->load_acl($root_id, 'read');
					$acl['read']	= $read_acl['list'];

					$comment_acl	= $this->load_acl($root_id, 'comment');
					$acl['comment']	= $comment_acl['list'];

					$create_acl		= $this->load_acl($root_id, 'create');
					$acl['create']	= $create_acl['list'];

					$upload_acl		= $this->load_acl($root_id, 'upload');
					$acl['upload']	= $upload_acl['list'];

					// forum topic privileges
					if ($this->forum)
					{
						$acl['write']	= $user_name;
						$acl['comment']	= $this->db->default_comment_acl;
						$acl['create']	= '';
						$acl['upload']	= '';
					}
				}
				else if ($comment_on_id)
				{
					// Give comments the same read rights as their parent page
					$read_acl		= $this->load_acl($comment_on_id, 'read');
					$acl['read']	= $read_acl['list'];
					$acl['write']	= '';
					$acl['comment']	= '';
					$acl['create']	= '';
					$acl['upload']	= '';
				}
				else
				{
					$acl['read']	= $this->db->default_read_acl;
					$acl['write']	= $this->db->default_write_acl;
					$acl['comment']	= $this->db->default_comment_acl;
					$acl['create']	= $this->db->default_create_acl;
					$acl['upload']	= $this->db->default_upload_acl;
				}

				// determine the depth
				$_depth_array	= explode('/', $tag);
				$depth			= count($_depth_array);

				$this->db->sql_query(
					"INSERT INTO " . $this->db->table_prefix . "page SET " .
						"version_id		= '1', " .
						"comment_on_id	= '" . (int) $comment_on_id . "', " .
						(!$comment_on_id
							? "description = " . $this->db->q($desc) . ", "
							: "") .
						"parent_id		= '" . (int) $parent_id . "', " .
						"created		= UTC_TIMESTAMP(), " .
						"modified		= UTC_TIMESTAMP(), " .
						"commented		= UTC_TIMESTAMP(), " .
						"depth			= '" . (int) $depth . "', " .
						"owner_id		= '" . (int) $owner_id . "', " .
						"user_id		= '" . (int) $user_id . "', " .
						"ip				= " . $this->db->q($ip) . ", " .
						"latest			= '1', " .
						"tag			= " . $this->db->q($tag) . ", " .
						"supertag		= " . $this->db->q($this->translit($tag)) . ", " .
						"body			= " . $this->db->q($body) . ", " .
						"body_r			= " . $this->db->q($body_r) . ", " .
						"body_toc		= " . $this->db->q($body_toc) . ", " .
						"edit_note		= " . $this->db->q($edit_note) . ", " .
						"minor_edit		= '" . (int) $minor_edit . "', " .
						"page_size		= '" . (int) strlen($body) . "', " .
						(isset($reviewed)
							?	"reviewed		= '" . (int) $reviewed . "', " .
								"reviewed_time	= UTC_TIMESTAMP(), " .
								"reviewer_id	= '" . (int) $reviewer_id . "', "
							:	"") .
						"page_lang		= " . $this->db->q($lang) . ", " .
						"title			= " . $this->db->q($title) . " ");

				// IMPORTANT! lookup newly created page_id
				$page_id = $this->get_page_id($tag);

				// saving acls
				$this->save_acl($page_id, 'read',		$acl['read']);
				$this->save_acl($page_id, 'write',		$acl['write']);
				$this->save_acl($page_id, 'comment',	$acl['comment']);
				$this->save_acl($page_id, 'create',		$acl['create']);
				$this->save_acl($page_id, 'upload',		$acl['upload']);

				// log event
				if ($comment_on_id)
				{
					// see add_comment handler
					// $this->log(5, str_replace('%2', $this->tag . ' ' . $this->page['title'], str_replace('%1', 'Comment' . $num, $this->_t('LogCommentPosted', SYSTEM_LANG))));
				}
				else
				{
					// added new page
					$this->log(4, Ut::perc_replace($this->_t('LogPageCreated', SYSTEM_LANG), $tag . ' ' . $title));
				}

				// TODO: move to additional function
				// counters
				if ($comment_on_id)
				{
					// updating comments count for commented page
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "page SET " .
							"comments	= '" . (int) $this->count_comments($comment_on_id) . "', " .
							"commented	= UTC_TIMESTAMP() " .
						"WHERE page_id = '" . (int) $comment_on_id . "' " .
						"LIMIT 1");

					// update user comments count
					$this->db->sql_query(
						"UPDATE " . $this->db->user_table . " SET " .
							"total_comments = total_comments + 1 " .
						"WHERE user_id = '" . (int) $owner_id . "' " .
						"LIMIT 1");
				}
				else
				{
					// update user pages count
					$this->db->sql_query(
						"UPDATE " . $this->db->user_table . " SET " .
							"total_pages = total_pages + 1 " .
						"WHERE user_id = '" . (int) $owner_id . "' " .
						"LIMIT 1");
				}

				// set watch
				if (!$this->db->disable_autosubscribe && !$comment_on_id)
				{
					// subscribe the author
					if ($reg === true)
					{
						$this->set_watch($user_id, $page_id);
					}

					// subscribe & notify moderators
					if (!$mute)
					{
						$this->notify_new_page($page_id, $tag, $title, $user_id, $user_name);
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
						$title = $this->_t('Comment') . ' ' . substr($tag, 7);
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
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "page SET " .
							"version_id		= '" . (int)($old_page['version_id'] + 1) . "', " .
							"comment_on_id	= '" . (int) $comment_on_id . "', " .
							"modified		= UTC_TIMESTAMP(), " .
							"created		= " . $this->db->q($old_page['created']) . ", " .
							"owner_id		= '" . (int) $owner_id . "', " .
							"user_id		= '" . (int) $user_id . "', " .
							"latest			= '2', " .
							"description	= " . $this->db->q(($old_page['comment_on_id'] || $old_page['description'] ? $old_page['description'] : $desc )) . ", " .
							"supertag		= " . $this->db->q($this->translit($tag)) . ", " .
							"body			= " . $this->db->q($body) . ", " .
							"body_r			= " . $this->db->q($body_r) . ", " .
							"body_toc		= " . $this->db->q($body_toc) . ", " .
							"edit_note		= " . $this->db->q($edit_note) . ", " .
							"minor_edit		= '" . (int) $minor_edit . "', " .
							"page_size		= '" . (int) strlen($body) . "', " .
							(isset($reviewed)
								?	"reviewed		= '" . (int) $reviewed . "', " .
									"reviewed_time	= UTC_TIMESTAMP(), " .
									"reviewer_id	= '" . (int) $reviewer_id . "', "
								:	"") .
							"title			= " . $this->db->q($title) . " " .
						"WHERE tag = " . $this->db->q($tag) . " " .
						"LIMIT 1");

					// log event
					if ($this->page['comment_on_id'] != 0)
					{
						// comment modified
						$this->log(6, Ut::perc_replace($this->_t('LogCommentEdited', SYSTEM_LANG), $tag . ' ' . $title));
					}
					else
					{
						// old page modified
						$this->log(6, Ut::perc_replace($this->_t('LogPageEdited', SYSTEM_LANG), $tag . ' ' . $title));
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
				if ($this->db->enable_feeds)
				{
					$xml = new Feed($this);
					$xml->changes();
					$xml->comments();

					// write news feed
					if ($this->db->news_cluster)
					{
						if (substr($this->tag, 0, strlen($this->db->news_cluster . '/')) == $this->db->news_cluster . '/')
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
			$val = $this->db->quote($val);
		}

		// move revision
		$this->db->sql_query(
			"INSERT INTO " . $this->db->table_prefix . "revision SET " .
				"page_id		= '{$old_page['page_id']}', " .
				"version_id		= '{$old_page['version_id']}', " .
				"tag			= '{$old_page['tag']}', " .
				"modified		= '{$old_page['modified']}', " .
				"body			= '{$old_page['body']}', " .
				"body_r			= '', ". // specify value for columns that don't have defaults
				"formatting		= '{$old_page['formatting']}', " .
				"edit_note		= '{$old_page['edit_note']}', " .
				"minor_edit		= '{$old_page['minor_edit']}', " .
				"page_size		= '{$old_page['page_size']}', " .
				"reviewed		= '{$old_page['reviewed']}', " .
				"reviewed_time	= '{$old_page['reviewed_time']}', " .
				"reviewer_id	= '{$old_page['reviewer_id']}', " .
				"ip				= '{$old_page['ip']}', " .
				"owner_id		= '{$old_page['owner_id']}', " .
				"user_id		= '{$old_page['user_id']}', " .
				"latest			= '0', " .
				"handler		= '{$old_page['handler']}', " .
				"comment_on_id	= '{$old_page['comment_on_id']}', " .
				"page_lang		= '{$old_page['page_lang']}', " .
				"supertag		= '{$old_page['supertag']}', " .
				"title			= '{$old_page['title']}', " .
				"keywords		= '{$old_page['keywords']}', " .
				"description	= '{$old_page['description']}'");

		// update user statistics for revisions made
		if ($user = $this->get_user())
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->user_table . " SET " .
					"total_revisions = total_revisions + 1 " .
				"WHERE user_id = '" . $user['user_id'] . "' " .
				"LIMIT 1");
		}
	}

	function update_sitemap()
	{
		$this->sess->xml_sitemap_update = 1;
	}

	function write_sitemap()
	{
		if ((@$this->sess->xml_sitemap_update || $this->db->xml_sitemap_update) && $this->db->xml_sitemap)
		{
			if (($days = $this->db->xml_sitemap_time) <= 0)
			{
				// write
			}
			else if (time() > @$this->db->maint_last_xml_sitemap)
			{
				$this->db->set('xml_sitemap_update', 0, false);
				$this->db->set('maint_last_xml_sitemap', time() + $days * DAYSECS);
			}
			else
			{
				$this->db->set('xml_sitemap_update', 1);
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
			$user_lang = $this->db->language;
		}

		$tag				= $this->db->users_page . '/' . $user_name;
		// add your user page template here
		$user_page_template	= '**((user:' . $user_name . ' ' . $user_name . '))** (' . $this->format('::+::', 'pre_wacko') . ')';
		$change_summary		= $this->_t('NewUserAccount'); //'auto created';

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

		$this->db->sql_query(
			"UPDATE " . $this->db->user_table . " SET " .
				"enabled		= '" . (int) $enabled . "', " .
				"account_status	= '" . (int) $account_status . "' " .
			"WHERE user_id = '" . (int) $user_id . "' " .
			"LIMIT 1");
	}

	function approve_user($user, $account_status)
	{
		$this->set_account_status($user['user_id'], $account_status);

		if ($account_status === false)
		{
			// $this->add_user_page($user['user_name'], $user['user_lang']);

			// send email
			if ($this->db->enable_email)
			{
				$this->notify_approved_account($user);
			}
		}
	}

	// NOTIFICATIONS
	// TODO: move notification functions in own notification class

	// user email wrapper
	function send_user_email($user, $subject, $body, $xtra_headers = [])
	{
		if ($user === 'System')
		{
			$user = [
				'user_name'		=> $this->db->email_from,
				'email'			=> $this->db->admin_email,
				'user_lang'		=> $this->db->language
			];
		}

		$save = $this->set_language($user['user_lang'], true);

		$email_to	=	$user['email'];
		$name_to	=	$user['user_name'];
		$subject	=	'[' . $this->db->site_name . '] ' . $subject;
		$body		=	$this->_t('EmailHello') . $user['user_name'] . ",\n\n" .

						Ut::amp_decode($body) . "\n\n" .

						$this->_t('EmailDoNotReply') . "\n\n" .
						# $this->_t('EmailGoodbye') . "\n" .
						$this->db->site_name . "\n" .
						$this->db->base_url;

		$charset	=	$this->get_charset($user['user_lang']);

		$this->set_language($save, true);

		$email = new Email($this);
		$email->send_mail($email_to, $name_to, $subject, $body, null, $charset, $xtra_headers = []);
	}

	function notify_approved_account($user)
	{
		$save = $this->set_language($user['user_lang'], true);

		$subject	=	$this->_t('RegistrationApproved');
		$body		=	Ut::perc_replace($this->_t('UserApprovedInfo'), $this->db->site_name) . "\n\n" .
						$this->_t('EmailRegisteredLogin') . "\n\n";

		$this->set_language($save, true);

		$this->send_user_email($user, $subject, $body);
	}

	function notify_new_account($user)
	{
		/* TODO: set user language for email encoding */
		$lang_admin	= $this->db->language;
		$save		= $this->set_language($lang_admin, true);

		$subject	=	$this->_t('NewAccountSubject');
		$body		=	$this->_t('NewAccountSignupInfo') . "\n\n" .
						$this->_t('NewAccountUsername') . ' ' .	$user['user_name'] . "\n" .
						$this->_t('RegistrationLang') . ' ' .	$user['user_lang'] . "\n" .
						$this->_t('NewAccountEmail') . ' ' .	$user['email'] . "\n" .
						$this->_t('NewAccountIP') . ' ' .		$user['user_ip'] . "\n\n";

		if ($this->db->approve_new_user)
		{
			$body .= Ut::perc_replace($this->_t('UserRequiresApproval'), $this->db->site_name);
		}

		$this->send_user_email('System', $subject, $body);
		$this->set_language($save, true);
	}

	function notify_new_owner($user)
	{
		$save = $this->set_language($user['user_lang'], true);

		$subject	=	$this->_t('NewPageOwnership');
		// STS TODO ou, pure shit message!
		$body		=	Ut::perc_replace($this->_t('YouAreNewOwner'), $this->get_user_name()) . "\n\n" .
						$user['owned'] . "\n" .
						$this->_t('PageOwnershipInfo') . "\n";

		$this->set_language($save, true);

		$this->send_user_email($user, $subject, $body);
	}

	function notify_user_signup($user)
	{
		$save = $this->set_language($user['user_lang'], true);

		$subject	=	$this->_t('EmailWelcome');
		$body		=	Ut::perc_replace($this->_t('EmailRegistered'),
							$this->db->site_name, $user['user_name'],
							$this->user_email_confirm($user['user_id'])) . "\n\n" .
						($this->db->approve_new_user
							? $this->_t('UserWaitingApproval')
							: $this->_t('EmailRegisteredLogin') ) . "\n\n" .
						$this->_t('EmailRegisteredIgnore') . "\n\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	function notify_password_reset($user, $code)
	{
		$save = $this->set_language($user['user_lang'], true);

		$subject	=	$this->_t('EmailForgotSubject');
		$body		=	Ut::perc_replace($this->_t('EmailForgotMessage'),
							$this->db->site_name,
							$user['user_name'],
							$this->href('', '', 'secret_code=' . $code)) . "\n\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	function notify_pm($user, $subject, $body, $header)
	{
		$save = $this->set_language($user['user_lang'], true);

		$body		=	Ut::perc_replace($this->_t('UsersPMBody'),
							$this->get_user_name()) . "\n\n" .

						'----------------------------------------------------------------------' . "\n" .
						$body . "\n" .
						'----------------------------------------------------------------------' . "\n\n" .

						$this->_t('UsersPMReply') . "\n\n" .
						Ut::amp_decode($this->href('', '',
							['profile' => $this->get_user_name(),
							'ref' => Ut::http64_encode(gzdeflate($msg_id . '@@' . $subject, 9)),
							'#' => 'contacts'])) . "\n\n";

						// XXX: do we really need this, less clutter we want
						# Ut::perc_replace($this->_t('PMAbuseInfo'), $this->db->abuse_email);

		$this->send_user_email($user, $subject, $body, $header);
		$this->set_language($save, true);
	}

	function notify_new_page($page_id, $tag, $title, $user_id, $user_name)
	{
		$subject[]	=	'NewPageCreatedSubj';
		$subject[]	=	$title;

		$body[]		=	'NewPageCreatedBody';
		$body[]		=	$user_name;
		$body[]		=	$title;
		$body[]		=	$tag;

		$this->	notify_moderator($page_id, $user_id, $subject, $body);
	}

	function notify_upload($page_id, $tag, $file_name, $user_id, $user_name, $replace)
	{
		$subject[]	=	'FileUploadedSubj';
		$subject[]	=	$file_name;

		$body[]		=	$replace? 'FileReplacedBody' : 'FileUploadedBody';
		$body[]		=	$user_name;
		$body[]		=	$file_name;
		$body[]		=	$page_id? $tag : $this->_t('UploadGlobal'); // TODO: to page / global

		$this->	notify_moderator($page_id, $user_id, $subject, $body);
	}

	function notify_moderator($page_id, $user_id, $subject, $body)
	{
		// subscribe & notify moderators
		if (is_array($this->db->groups['Moderator']))
		{
			$members = $this->db->load_all(
				"SELECT m.user_id, u.user_name, u.email, s.user_lang, u.email_confirm, u.enabled, s.send_watchmail " .
				"FROM " . $this->db->table_prefix . "usergroup g " .
					"INNER JOIN " . $this->db->table_prefix . "usergroup_member m ON (g.group_id = m.group_id) " .
					"INNER JOIN " . $this->db->table_prefix . "user u ON (m.user_id = u.user_id) " .
					"LEFT JOIN " . $this->db->table_prefix . "user_setting s ON (u.user_id = s.user_id) " .
				"WHERE g.group_name = 'Moderator'");

			foreach ($members as $user)
			{
				if ($user_id != $user['user_id'])
				{
					if ($this->db->enable_email && $this->db->enable_email_notification && $user['enabled'] && !$user['email_confirm'] && $user['send_watchmail'])
					{
						$save = $this->set_language($user['user_lang'], true);

						$_subject	=	$this->_t($subject[0]) . " '$subject[1]'";

						$_body		=	# $this->_t('EmailModerator') . ".\n\n" .
										Ut::perc_replace($this->_t($body[0]), ($body[1] == GUEST ? $this->_t('Guest') : $body[1])) . "\n\n" .
										"'$body[2]'\n" .
										$this->href('', $body[3]) . "\n\n";

						$this->send_user_email($user, $_subject, $_body);

						$this->set_language($save, true);

						if ($page_id)
						{
							$this->set_watch($user['user_id'], $page_id);
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
			$object_id		= $comment_on_id;
			$page_title		= $this->get_page_title('', $comment_on_id);
		}
		else
		{
			$object_id			= $page_id;
			// revisions diff
			$page = $this->db->load_single(
				"SELECT revision_id " .
				"FROM " . $this->db->table_prefix . "revision " .
				"WHERE tag = " . $this->db->q($tag) . " " .
				"ORDER BY modified DESC " .
				"LIMIT 1");

			$_GET['a']			= -1;
			$_GET['b']			= $page['revision_id'];
			$_GET['diffmode']	= 2; // 2 - source diff
			$diff				= $this->method('diff');
		}

		// get watchers
		$watchers	= $this->db->load_all(
			"SELECT DISTINCT
				w.user_id, w.comment_id, w.pending,
				u.email, u.user_name, u.email_confirm, u.enabled,
				s.user_lang, s.send_watchmail, s.notify_minor_edit, s.notify_page, s.notify_comment " .
			"FROM " . $this->db->table_prefix . "watch w " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (w.user_id = u.user_id) " .
				"LEFT JOIN " . $this->db->table_prefix . "user_setting s ON (w.user_id = s.user_id) " .
			"WHERE w.page_id = '" . (int) $object_id . "'");

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
							$this->db->sql_query(
								"UPDATE " . $this->db->table_prefix . "watch SET " .
									"comment_id	= '" . (int) $page_id . "' " .
								"WHERE page_id = '" . (int) $comment_on_id . "' " .
									"AND user_id = '" . $watcher['user_id'] . "'");
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
							$this->db->sql_query(
								"UPDATE " . $this->db->table_prefix . "watch SET " .
									"pending	= '1' " .
								"WHERE page_id = '" . (int) $comment_on_id . "' " .
									"AND user_id = '" . $watcher['user_id'] . "'");
						}
						else
						{
							continue;	// skip current watcher
						}
					}
				}

				// removes user from subscription if access writes were revoked
				if (!$this->has_access('read', $object_id, $watcher['user_name']))
				{
					$this->clear_watch($watcher['user_id'], $object_id);
					continue;
				}

				if ($this->db->enable_email
					&& $this->db->enable_email_notification
					&& $watcher['enabled']
					&& !$watcher['email_confirm']
					&& $watcher['send_watchmail'])
				{
					$lang = $watcher['user_lang'];
					$save = $this->set_language($lang, true);

					$body = ($user_name == GUEST ? $this->_t('Guest') : $user_name);

					if ($comment_on_id)
					{
						$subject = $this->_t('CommentForWatchedPage') . "'" . $page_title . "'";

						$body .=
								$this->_t('SomeoneCommented') . "\n" .
								$this->href('', $this->get_page_tag($comment_on_id), '') . "\n\n" .
								$title . "\n" .
								"----------------------------------------------------------------------\n\n" .
								$page_body . "\n\n" .
								"----------------------------------------------------------------------\n\n";

						if ($watcher['notify_comment'] == 2)
						{
							$body .= $this->_t('FurtherPending') . "\n\n";
						}
					}
					else
					{
						$subject = $this->_t('WatchedPageChanged') . "'" . $tag . "'";

						$body .=
								$this->_t('SomeoneChangedThisPage') . "\n" .
								$this->href('', $tag) . "\n\n" .
								$title . "\n" .
								"======================================================================\n\n" .
								$this->format($diff, 'html2mail') . "\n\n" .
								"======================================================================\n\n";

						if ($watcher['notify_page'] == 2)
						{
							$body .= $this->_t('FurtherPending') . "\n\n";
						}
					}

					$this->send_user_email($watcher, $subject, $body);
					$this->set_language($save, true);
				}
			}
		}
	}

	// generate url for email confirmation, used for registration and email change
	function user_email_confirm($user_id)
	{
		$confirm = Ut::random_token(21);

		$this->db->sql_query(
			"UPDATE " . $this->db->user_table . " SET " .
				"email_confirm = " . $this->db->q(hash_hmac('sha256', $confirm, $this->db->system_seed)) . " " .
			"WHERE user_id = '" . (int) $user_id . "' " .
			"LIMIT 1");

		return $this->href('', '', 'confirm=' . $confirm);
	}

	function user_email_confirm_check($code)
	{
		$hash = $this->db->q(hash_hmac('sha256', $code, $this->db->system_seed));

		if (($user = $this->db->load_single(
			"SELECT user_name, email " .
			"FROM " . $this->db->user_table . " " .
			"WHERE email_confirm = $hash " .
			"LIMIT 1")))
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->user_table . " SET " .
					"email_confirm = '' " .
				"WHERE email_confirm = $hash " .
				"LIMIT 1");

			if ($this->get_user_name() == $user['user_name'])
			{
				$this->set_user_setting('email_confirm', '');
			}

			$this->log(4, Ut::perc_replace($this->_t('LogUserEmailActivated', SYSTEM_LANG), $user['email'], $user['user_name']));
			$this->set_message($this->_t('EmailConfirmed'), 'success');
		}
		else
		{
			$this->set_message(Ut::perc_replace($this->_t('EmailNotConfirmed'),
				$this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), 0)), 'error');
		}
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
			$this->sess->sticky_messages[] = [(string) $message, $type];
		}
	}

	// output all messages stored in session array
	// NB actual output is in theme/default due to templatest
	function output_messages($show = true)
	{
		if (isset($this->sess->sticky_messages))
		{
			$messages = $this->sess->sticky_messages;
			unset($this->sess->sticky_messages);
		}
		else
		{
			$messages = [];
		}

		// get system message
		// TODO: set type also via backend and store it [where?]
		if (($message = $this->db->system_message) && !$this->db->ap_mode)
		{
			// check current page lang for different charset to do_unicode_entities()
			if (isset($this->page['page_lang']) && $this->page['page_lang'] != $this->db->language)
			{
				$message = $this->do_unicode_entities($message, $this->db->language);
			}

			array_unshift($messages, [$message, 'sysmessage ' . $this->db->system_message_type]);
		}

		if ($show)
		{
			// TODO: maybe filter?
			// TODO: think about quoting....
			foreach ($messages as $message)
			{
				list($_message, $_type) = $message;
				$this->show_message($_message, $_type);
			}
		}
		else
		{
			return $messages;
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

	/**
	 * unwrap tag based on $this->context
	 *
	 * looks for tag with relative path and returns tag with absolute path
	 *
	 *	$this->context =	'cluster/base'
	 *		'page'				'cluster/page'
	 *		'../page'			'page'
	 *		'!/page'			'cluster/base/page'
	 *
	 * @param string $tag
	 *
	 * @return string tag with absolute path
	 */
	function unwrap_link($tag)
	{
		if ($tag == '/')										// '/'
		{
			return '';
		}

		if ($tag == '!')										// '!'
		{
			return $this->context[$this->current_context];
		}

		$new_tag = $tag;

		// get root tag
		if (isset($this->context[$this->current_context]) && strstr($this->context[$this->current_context], '/'))
		{
			$root	= preg_replace('/^(.*)\\/([^\\/]+)$/', '$1', $this->context[$this->current_context]);
		}
		else
		{
			$root	= '';
		}

		if (preg_match('/^\.\/(.*)$/', $tag, $matches))			// './tag'
		{
			$root	= '';
		}
		else if (preg_match('/^\/(.*)$/', $tag, $matches))		// '/tag'
		{
			$root		= '';
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\!\/(.*)$/', $tag, $matches))	// '!/tag'
		{
			$root		= $this->context[$this->current_context];
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\.\.\/(.*)$/', $tag, $matches))	// '../tag'
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
			$new_tag = '/' . $new_tag;
		}

		// build tag with absolute path
		$tag = $root . $new_tag;
		$tag = str_replace('//', '/', $tag);

		return $tag;
	}

	/**
	* Returns the full URL for a page/method, including any additional URL-parameters and anchor
	*
	* @param string $method Optional Wacko method (default 'show' method added in run() function)
	* @param string $tag Optional tag. Returns current-page tag if empty
	* @param mixed $params Optional URL parameters in HTTP name=value[&name=value][...] format (or as list ['a=1', 'b=2'] or ['a' => 1, 'b' => 2])
	* @param boolean $addpage Optional
	* @param string $anchor Optional HTTP anchor-fragment
	* @param boolean $alter Optional uses slim_url and translit (turn off for e.g. addpage or hashid routing)
	* @return string HREF string adjusted for Apache rewrite_method setting (i.e. Wacko 'rewrite_method' config-parameter)
	*/
	function href($method = '', $tag = '', $params = [], $addpage = false, $anchor = '', $alter = true)
	{
		if (!is_array($params))
		{
			$params = $params? [$params] : [];
		}

		if ($addpage)
		{
			$params['add']	= 1;
			$alter			= false;
		}

		$href = $this->db->base_url;

		// enable rewrite_mode in ap_mode to avoid href() appends '?page=' (why?)
		if ($this->db->rewrite_mode || $this->db->ap_mode)
		{
			$href .= $this->mini_href($method, $tag, $alter);
		}
		else
		{
			$params['page'] = $this->mini_href($method, $tag, $alter);
		}

		if ($params)
		{
			if (isset($params['#']))
			{
				$anchor = $params['#'];
				unset($params['#']);
			}

			foreach ($params as $i => &$param)
			{
				if (is_string($i))
				{
					$param = Ut::qencode($i, $param);
				}
				else if (($j = strpos($param, '#')) !== false)
				{
					// for some it is easier to bring in anchor in params
					$anchor = substr($param, $j + 1);
					$param = substr($param, 0, $j);
				}
			}

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
	* Returns value for page 'wacko' parameter, in tag[/method][#anchor] format
	*
	* @param string $method Optional Wacko method (default 'show' method added in run() function)
	* @param string $tag Optional tag - returns current-page tag if empty
	* @param boolean $alter Optional
	* @return string String tag[/method]
	*/
	function mini_href($method = '', $tag = '', $alter = true)
	{
		if (!($tag = trim($tag)))
		{
			$tag = $this->tag;
		}

		if ($alter && !$this->db->ap_mode)
		{
			$tag = $this->slim_url($tag);
		}
		// if ($alter)		$tag = $this->translit($tag);

		$tag = trim($tag, '/.');
		// $tag = str_replace(['%2F', '%3F', '%3D'], ['/', '?', '='], rawurlencode($tag));

		return $tag.($method ? '/' . $method : '');
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
		// why we do replace this here?
		//	this behavior is unwanted in the AP, it breaks the redirect for e.g. config_basic.php
		//	looks like a reverse of it in the tranlit function (?)
		$tag = str_replace('_', "'", $tag);

		if ($this->db->urls_underscores == 1)
		{
			$tag = preg_replace('/(' . $this->language['ALPHANUM'] . ')(' . $this->language['UPPERNUM'] . ')/', '\\1¶\\2', $tag);
			$tag = preg_replace('/(' . $this->language['UPPERNUM'] . ')(' . $this->language['UPPERNUM'] . ')/', '\\1¶\\2', $tag);
			$tag = preg_replace('/(' . $this->language['UPPER'] . ')¶(?=' . $this->language['UPPER'] . '¶' . $this->language['UPPERNUM'] . ')/', '\\1', $tag);
			$tag = preg_replace('/(' . $this->language['UPPER'] . ')¶(?=' . $this->language['UPPER'] . '¶\/)/', '\\1', $tag);
			$tag = preg_replace('/(' . $this->language['UPPERNUM'] . ')¶(' . $this->language['UPPERNUM'] . ')($|\b)/', '\\1\\2', $tag);
			$tag = preg_replace('/\/¶(' . $this->language['UPPERNUM'] . ')/', '/\\1', $tag);
			$tag = str_replace('¶', '_', $tag);
		}

		return $tag;
	}

	/**
	* Add spaces and wraps page href into <a> </a>
	*
	* @param string $tag Page tag.
	* @param string $method Wacko method. Optional, default 'show' method added in run() function.
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

		return '<a href="' . $this->href($method, $tag, $params) . '"' . ($title ? ' title="' . $title . '"' : '') . '>' . $text . '</a>';
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

		if (preg_match('/^[\!\.' . $this->language['ALPHANUM_P'] . ']+$/', $tag))
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
			return '<!--imglink:begin-->' . str_replace(' ', '%20', urldecode($tag)) . ' ==' . $text . '<!--imglink:end-->';
		}
		else
		{
			return '<!--link:begin-->' . str_replace(' ', '%20', urldecode($tag)) . " ==" . ($this->format_safe ? str_replace('>', "&gt;", str_replace('<', "&lt;", $text)) : $text) . '<!--link:end-->';
		}
	}

	/**
	* Returns full <a href=".."> or <img ...> HTML for Tag
	*
	* @param string $tag Link content - may be Wacko tag, interwiki wikiname:page tag,
	*	http/file/ftp/https/mailto/xmpp URL, [=] local or remote image-file for <img> link, or local or
	*	remote doc-file; if pagetag is for an external link but not protocol is specified, http:// is prepended
	* @param string $method Optional Wacko method (default 'show' method added in run() function)
	* @param string $text Optional text or image-file for HREF link (defaults to same as pagetag)
	* @param string $title
	* @param boolean $track Link-tracking used by Wacko's internal link-tracking (inter-page cross-references in LINKS table).
	*	Optional, default is TRUE
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
		$matches	= [];
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
				{
					$_height = $mat[2];
				}
				else if ($mat[1] == 'width')
				{
					$_width = $mat[2];
				}
				else if ($mat[1] == 'align')
				{
					$_align = $mat[2];
				}
				else
				{
					return $mat[0];
				}

				$trim = 1;
				return '';
			}, $text);

		if ($trim)
		{
			$text = trim($text);
		}

		if ($_width || $_height)
		{
			if (!$_width)
			{
				$_width = 'auto';
			}
			else if (preg_match('/^[0-9]+$/', $_width))
			{
				$_width .= 'px';
			}

			if (!$_height)
			{
				$_height = 'auto';
			}
			else if (preg_match('/^[0-9]+$/', $_height))
			{
				$_height .= 'px';
			}

			$resize = ' style="width:' . $_width . ';height:' . $_height;
		}

		if ($_align)
		{
			$resize .= ' vertical-align:' . $_align . ';"';
		}
		else if ($resize != '')
		{
			$resize .= ';"';
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

		if (preg_match('/^[\.\-' . $this->language['ALPHANUM_P'] . ']+\.(gif|jpg|jpe|jpeg|png|svg)$/i', $text))
		{
			// ((image.png)) - loads only images from image/ folder
			// XXX: odd behavior, user can't check or upload to image/ folder - how useful is this?
			$img_link = $this->db->base_url . Ut::join_path(IMAGE_DIR, $text);
		}
		else if (preg_match('/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png|svg)$/i', preg_replace('/<\/?nobr>/', '', $text)))
		{
			$img_link = $text = preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/', '', $text);
		}

		if (preg_match('/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid Email
			$url	= (isset($matches[1]) && $matches[1] == 'mailto:' ? $tag : 'mailto:' . $tag);
			$title	= $this->_t('EmailLink');
			$icon	= $this->_t('OuterIcon');
			$class	= '';
			$tpl	= 'email';
		}
		else if (preg_match('/^(xmpp[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/', $tag, $matches))
		{
			// this is a valid XMPP address
			$url	= (isset($matches[1]) && $matches[1] == 'xmpp:' ? $tag : 'xmpp:' . $tag);
			$title	= $this->_t('JabberLink');
			$icon	= $this->_t('OuterIcon');
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
				return '<img src="' . str_replace('&', '&amp;', str_replace('&amp;', '&', $tag)) . '" '.($text ? 'alt="' . $text . '" title="' . $text . '"' : '') . $resize . ' />';
			}
			else
			{
				$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
				$title	= $this->_t('OuterLink2');
				$icon	= $this->_t('OuterIcon');
				$tpl	= 'outerlink';
			}
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rpm|gz|tgz|zip|rar|exe|doc|xls|ppt|bz2|7z)$/', $tag))
		{
			// this is a file link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->_t('FileLink');
			$icon	= $this->_t('OuterIcon');
			$class	= '';
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/', $tag))
		{
			// this is a PDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->_t('PDFLink');
			$icon	= $this->_t('OuterIcon');
			$class	= '';
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/', $tag))
		{
			// this is a RDF link
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= $this->_t('RDFLink');
			$icon	= $this->_t('OuterIcon');
			$class	= '';
			$tpl	= 'file';
		}
		else if (preg_match('/^(http|https|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/', $tag))
		{
			// this is a valid external URL
			$url	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$tpl	= 'outerlink';

			if (!stristr($tag, $this->db->base_url))
			{
				$title	= $this->_t('OuterLink2');
				$icon	= $this->_t('OuterIcon');
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
					$url = $this->db->base_url.Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
					$have_global = true;

					// tracking file link
					if ($track && isset($file_data['file_id']))
					{
						$this->track_link_to($file_data['file_id'], LINK_FILE);
					}
				}
			}
			else if (count($arr) == 2 && $arr[0] == '')	// case 2 -> file:/some.zip - global only file
			{
				#echo '####2: file:/some.zip <br />' . $arr[1] . '####<br />';
				$file_name = $arr[1];

				if ($file_data = $this->check_file_exists($file_name, $page_tag))
				{
					$url = $this->db->base_url.Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);

					// tracking file link
					if ($track && isset($file_data['file_id']))
					{
						$this->track_link_to($file_data['file_id'], LINK_FILE);
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
					$url = $this->href('file', trim($page_tag, '/'), 'get=' . $file_name);

					// tracking file link
					if ($track && isset($file_data['file_id']))
					{
						$this->track_link_to($file_data['file_id'], LINK_FILE);
					}

					if ($this->is_admin()
					|| ($file_data['file_id'] && ($this->page['owner_id'] == $this->get_user_id()))
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
					$title		= $file_data['file_description'] . ' (' . $this->binary_multiples($file_data['file_size'], false, true, true) . ')';
					$alt		= $file_data['file_description'];
					$img_link	= false;
					$icon		= $this->_t('OuterIcon');
					$tpl		= 'localfile';

					if (($file_data['picture_w'] || $file_data['file_ext'] == 'svg') && !$noimg)
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
							$scale = ' width="' . $file_data['picture_w'] . '" height="' . $file_data['picture_h'] . '"';
						}

						// direct file access
						if ($_global == true)
						{

							if (!$text)
							{
								$text = $title;
								return '<img src="' . $this->db->base_url.Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name) . '" '.
										($text ? 'alt="' . $alt . '" title="' . $text . '"' : '') . $scale . $resize . ' />';
							}
							else
							{
								// continue
								# return '<a href="' . $this->db->base_url.Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name) . '" title="' . $title . '">' . $text . '</a>';
							}
						}
						else
						{
							// no direct file access for files per page
							// the file handler checks the access rights
							# return '<img src="' . $this->db->base_url.Ut::join_path(UPLOAD_PER_PAGE_DIR, '@' . $file_data['page_id'] . '@' . $_file) . '" '.($text ? 'alt="' . $alt . '" title="' . $text . '"' : '') . ' width="' . $file_data['picture_w'] . '" height="' . $file_data['picture_h'] . '" />';
							if (!$text)
							{
								$text = $title;
								return '<img src="' . $this->href('file', trim($page_tag, '/'), 'get=' . $file_name) . '" '.
										($text ? 'alt="' . $alt . '" title="' . $text . '"' : '') . $scale . $resize . ' />';
							}
							else
							{
								// continue
								#return '<a href="' . $this->href('file', trim($page_tag, '/'), 'get=' . $file_name) . '" title="' . $title . '">' . $text . '</a>';
							}
						}
					}
				}
				else //403
				{
					$url		= $this->href('file', trim($page_tag, '/'), 'get=' . $file_name);
					$icon		= $this->_t('OuterIcon');
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
					$title	= '404: /' . trim($page_tag, '/') . '/file' . ($this->db->rewrite_mode ? '?' : '&amp;') . 'get=' . $file_name;
				}
			} //forgot 'bout 403

			unset($file_data);
		}
		else if ($this->db->disable_tikilinks != 1 && preg_match('/^(' . $this->language['UPPER'] . $this->language['LOWER'] . $this->language['ALPHANUM'] . '*)\.(' . $this->language['ALPHA'] . $this->language['ALPHANUM'] . '+)$/s', $tag, $matches))
		{
			// it`s a Tiki link! (Tiki.Link -> /Tiki/Link)
			$tag	= '/' . $matches[1] . '/' . $matches[2];

			if (!$text)
			{
				$text = $this->add_spaces($tag);
			}

			return $this->link($tag, $method, $text, $title, $track, 1);
		}
		else if (preg_match('/^(user)[:]([' . $this->language['ALPHANUM_P'] . '\-\_\.\+\&\=\#]*)$/', $tag, $matches))
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

			$url	= $this->href('', $this->db->users_page . '/', 'profile='.implode('/', $parts));

			$class	= 'user-link';
			$icon	= $this->_t('OuterIcon');
			$tpl	= 'userlink';
		}
		else if (preg_match('/^(group)[:]([' . $this->language['ALPHANUM_P'] . '\-\_\.\+\&\=\#]*)$/', $tag, $matches))
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

			$url	= $this->href('', $this->db->groups_page . '/', 'profile='.implode('/', $parts));

			$class	= 'group-link';
			$icon	= $this->_t('OuterIcon');
			$tpl	= 'grouplink';
		}
		else if (preg_match('/^([[:alnum:]]+)[:]([' . $this->language['ALPHANUM_P'] . '\-\_\.\+\&\=\#]*)$/', $tag, $matches))
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
			$icon	= $this->_t('IwIcon');
			$tpl	= 'interwiki';
		}
		else if (preg_match('/^([\!\.\-' . $this->language['ALPHANUM_P'] . ']+)(\#[' . $this->language['ALPHANUM_P'] . '\_\-]+)?$/', $tag, $matches))
		{
			// it's a Wiki link!
			$match			= '';
			$tag			= $otag		= $matches[1];
			$untag			= $unwtag	= $this->unwrap_link($tag);

			$regex_handlers	= '/^(.*?)\/(' . $this->db->standard_handlers . ')\/(.*)$/i';
			$ptag			= $this->translit($unwtag);
			$handler		= null;

			if (preg_match( $regex_handlers, '/' . $ptag . '/', $match ))
			{
				$handler	= $match[2];

				if (!isset($_ptag))
				{
					$_ptag = ''; // XXX: ???
				}

				$ptag		= $match[1];
				$unwtag		= '/' . $unwtag . '/';
				$co			= substr_count($_ptag, '/') - substr_count($ptag, '/');

				for ($i = 0; $i < $co; $i++)
				{
					$unwtag	= substr($unwtag, 0, strrpos($unwtag, '/'));
				}

				// not used ..?
				if ($handler)
				{
					if (!isset($data))
					{
						$data = ''; // XXX: ???
					}

					$opar	= '/' . $untag . '/';

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
					$lang	= $this->db->language;
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
				$icon		= $this->_t('ChildIcon');
				$page0		= substr($tag, 2);
				$page		= $this->add_spaces($page0);
				$tpl		= 'childpage';
			}
			else if (substr($tag, 0, 3) == '../')
			{
				$icon		= $this->_t('ParentIcon');
				$page0		= substr($tag, 3);
				$page		= $this->add_spaces($page0);
				$tpl		= 'parentpage';
			}
			else if (substr($tag, 0, 1) == '/')
			{
				$icon		= $this->_t('RootIcon');
				$page0		= substr($tag, 1);
				$page		= $this->add_spaces($page0);
				$tpl		= 'rootpage';
			}
			else
			{
				$icon		= $this->_t('EqualIcon');
				$page0		= $tag;
				$page		= $this->add_spaces($page0);
				$tpl		= 'equalpage';
			}

			if ($img_link)
			{
				$text		= '<img src="' . $img_link . '" title="' . $text . '"' . $resize . ' />';
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
				$aname = 'id="a-' . $supertag . '"';
				$this->first_inclusion[$supertag] = 1;
			}

			if ($this_page)
			{
				$page_link	= $this->href($method, $this_page['tag']).($anchor ? $anchor : '');
				$page_id	= $this->get_page_id($tag);

				if ($this->db->hide_locked)
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
					$accicon	= $this->_t('OuterIcon');
				}
				else if ($this->_acl['list'] == '*')
				{
					$class		= '';
					$accicon	= '';
				}
				else
				{
					$class		= 'acl-customsec';
					$accicon	= $this->_t('OuterIcon');
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
				$page_link	= $this->href('edit', $tag, $lang ? 'lang=' . $lang : '', 1);
				$accicon	= $this->_t('WantedIcon');
				$title		= $this->_t('CreatePage');

				if ($link_lang)
				{
					$text	= $this->do_unicode_entities($text, $link_lang);
					$page	= $this->do_unicode_entities($page, $link_lang);
				}
			}

			// see lang/wacko.all.php
			$res			= $this->_t('Tpl.' . $tpl);
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
				if ($this->db->youarehere_text)
				{
					if (isset($this->context[$this->current_context]) && ($this->translit($tag) == $this->translit($this->context[$this->current_context])) )
					{
						$res	= str_replace('####', $text, $this->db->youarehere_text);
					}
				}

				// numerated wiki-links
				if ($page_link != $text && $title != $this->_t('CreatePage'))
				{
					$res .= $this->numerate_link($page_link);
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
				$text		= '<img src="' . $img_link . '" title="' . $text . '"' . $resize . ' />';
			}

			$res			= $this->_t('Tpl.' . $tpl);

			if ($res)
			{
				if (!$class)
				{
					$class	= 'external-link';
				}

				if ($this->db->link_target)
				{
					$target = 'target="_blank"';
				}
				else
				{
					$target = '';
				}

				// TODO: refactor, static?
				if ($this->db->noreferrer || $this->db->nofollow)
				{
					if ($this->db->noreferrer)
					{
						$_rel[] = 'noreferrer';
					}

					if ($this->db->nofollow)
					{
						$_rel[] = 'nofollow';
					}

					$rel_separated	= implode(' ', $_rel);
					$rel			= 'rel="' . $rel_separated . '"';
				}
				else
				{
					$rel = '';
				}

				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				$res		= str_replace('{target}',	$target,	$res);
				$res		= str_replace('{rel}',		$rel,		$res);
				$res		= str_replace('{icon}',		$icon,		$res);
				$res		= str_replace('{class}',	$class,		$res);
				$res		= str_replace('{title}',	$title,		$res);
				$res		= str_replace('{url}',		$url,		$res);
				$res		= str_replace('{text}',		$text,		$res);

				// numerated outer links and file links
				if ($url != $text && $url != '404' && $url != '403')
				{
					$res .= $this->numerate_link($url);
				}

				return $res;
			}
		}

		return $text;
	}

	private function numerate_link($url)
	{
		// numerated wiki-links. initialize property as an array to make it work
		if (is_array($this->numerate_links))
		{
			$refnum = &$this->numerate_links[$url];

			if (!isset($refnum))
			{
				$refnum = '[link' . count($this->numerate_links) . ']';
			}

			return '<sup class="refnum">' . $refnum . '</sup>';
		}
	}

	// creates a link to the user profile
	function user_link($user_name, $account_lang = '', $linking = true, $add_icon = true)
	{
		if (!$user_name)
		{
			$user_name	= $this->_t('Guest');
			$linking	= false;
		}

		// check current page lang for different charset to do_unicode_entities()
		$text = ($this->page['page_lang'] != $account_lang)?  $this->do_unicode_entities($user_name, $account_lang) : $user_name;
		$icon = $add_icon?  '<span class="icon"></span>' : '';

		if ($linking)
		{
			return '<a href="' . $this->href('', $this->db->users_page, 'profile=' . $user_name) . '" class="user-link">' . $icon . $text . '</a>';
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

		if ($linking)
		{
			return '<a href="' . $this->href('', $this->db->groups_page, 'profile=' . $group_name) . '" class="group-link">' . $icon . $text . '</a>';
		}
		else
		{
			return '<span class="group-link">' . $icon . $group_name . '</span>';
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
		if (($user = $this->get_user())?  $user['show_spaces'] : $this->db->show_spaces)
		{
			$text = $this->add_nbsps($text);
		}

		if (!strncmp($text, '/', 1))
		{
			$text = $this->_t('RootLinkIcon') . substr($text, 1);
		}
		else if (!strncmp($text, '!/', 2))
		{
			$text = $this->_t('SubLinkIcon') . substr($text, 2);
		}
		else if (!strncmp($text, '../', 3))
		{
			$text = $this->_t('UpLinkIcon') . substr($text, 3);
		}

		return $text;
	}

	function add_nbsps($text)
	{
		$text = preg_replace('/(' . $this->language['ALPHANUM'] . ')(' . $this->language['UPPERNUM'] . ')/', '\\1&nbsp;\\2', $text);
		$text = preg_replace('/(' . $this->language['UPPERNUM'] . ')(' . $this->language['UPPERNUM'] . ')/', '\\1&nbsp;\\2', $text);
		$text = preg_replace('/(' . $this->language['ALPHANUM'] . ')\//', '\\1&nbsp;/', $text);
		$text = preg_replace('/(' . $this->language['UPPER'] . ')&nbsp;(?=' . $this->language['UPPER'] . '&nbsp;' . $this->language['UPPERNUM'] . ')/', '\\1', $text);
		$text = preg_replace('/(' . $this->language['UPPER'] . ')&nbsp;(?=' . $this->language['UPPER'] . '&nbsp;\/)/', '\\1', $text);
		$text = preg_replace('/\/(' . $this->language['ALPHANUM'] . ')/', '/&nbsp;\\1', $text);
		$text = preg_replace('/(' . $this->language['UPPERNUM'] . ')&nbsp;(' . $this->language['UPPERNUM'] . ')($|\b)/', '\\1\\2', $text);
		$text = preg_replace('/([0-9])(' . $this->language['ALPHA'] . ')/', '\\1&nbsp;\\2', $text);
		$text = preg_replace('/(' . $this->language['ALPHA'] . ')([0-9])/', '\\1&nbsp;\\2', $text);
		// $text = preg_replace('/([0-9])&nbsp;(?=[0-9])/', '\\1', $text);
		$text = preg_replace('/([0-9])&nbsp;(?!' . $this->language['ALPHA'] . ')/', '\\1', $text);

		return $text;
	}

	function add_spaces_title($text)
	{
		return preg_replace('/&nbsp;/', ' ', $this->add_nbsps($text));
	}

	function validate_reserved_words( $data )
	{
		$_data = $this->translit( $data );
		$_data = '/' . $_data . '/';

		// Find the string of text
		# $this->REGEX_WACKO_HANDLERS = '/^(.*?)\/' . $this->db->standard_handlers . '\/(.*)$/i';

		// Find the word
		$this->REGEX_WACKO_HANDLERS = '/\b(' . $this->db->standard_handlers . ')\b/i';

		if (preg_match($this->REGEX_WACKO_HANDLERS, $_data, $match))
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
		/* if (preg_match( '/\b(' . $this->db->users_page . '\/*\/)\b/i', $_data, $match ))
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

	// returns error text, or null on OK
	// if old_tag specified - check also for already-namedness & already-existance
	function sanitize_new_pagename(&$tag, &$supertag, $old_tag = false)
	{
		// remove starting/trailing slashes, spaces, and minimize multi-slashes
		$tag = preg_replace_callback('#^/+|/+$|(/{2,})|\s+#',
			function ($x)
			{
				return @$x[1]? '/' : '';
			}, $tag);

		$supertag = $this->translit($tag);

		// - / ' _ .
		// TODO: remove punctuations from language ALPHA* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if (!preg_match('#^([-/\'_.' . $this->language['ALPHANUM_P'] . ']+)$#', $tag))
		{
			return $this->_t('InvalidWikiName');
		}

		if (($result = $this->validate_reserved_words($tag)))
		{
			return Ut::perc_replace($this->_t('PageReservedWord'), $result);
		}

		if ($old_tag)
		{
			if ($tag === $old_tag)
			{
				return Ut::perc_replace($this->_t('AlreadyNamed'), $this->compose_link_to_page($tag, '', '', 0));
			}

			if ($this->supertag != $supertag && $this->load_page($tag, 0, '', LOAD_CACHE, LOAD_META))
			{
				return Ut::perc_replace($this->_t('AlreadyExists'), $this->compose_link_to_page($tag, '', '', 0));
			}
		}

		return null; // it's ok :)
	}

	/**
	* Check if text is WikiName
	*
	* @param string $text Tested text
	* @return boolean True if WikiName? else FALSE
	*/
	function is_wiki_name($text)
	{
		return preg_match('/^' . $this->language['UPPER'] . $this->language['LOWER'] . '+' . $this->language['UPPERNUM'] . $this->language['ALPHANUM'] . '*$/', $text);
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
	* Write link tables for //$from_page_id// to database
	*
	* @param int $from_page_id
	*/
	function write_link_table($from_page_id)
	{
		// delete related old links in table
		$this->db->sql_query(
			"DELETE " .
			"FROM " . $this->db->table_prefix . "page_link " .
			"WHERE from_page_id = '" . (int) $from_page_id . "'");

		// page link
		if ($link_table = @$this->linktable[LINK_PAGE])
		{
			$query = '';

			foreach ($link_table as $dummy => $to_tag) // discard strtolowered index
			{
				$query .= "('" . (int) $from_page_id . "', '" . $this->get_page_id($to_tag) . "', " .
							$this->db->q($to_tag) . ", " . $this->db->q($this->translit($to_tag)) . "),";
			}

			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "page_link " .
					"(from_page_id, to_page_id, to_tag, to_supertag) " .
				"VALUES " . rtrim($query, ','));
		}

		// delete page related old file links in table
		$this->db->sql_query(
			"DELETE " .
			"FROM " . $this->db->table_prefix . "file_link " .
			"WHERE page_id = '" . (int) $from_page_id . "'");

		// file link
		if ($file_table = @$this->linktable[LINK_FILE])
		{
			$query = '';

			foreach ($file_table as $file_id => $dummy) // index == value, BTW
			{
				$query .= "('" . (int) $from_page_id . "', '" . (int) $file_id . "'),";
			}

			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "file_link " .
				"(page_id, file_id) " .
				"VALUES " . rtrim($query, ','));
		}
	}

	function update_link_table($page_id, $body_r)
	{
		// now we render it internally so we can write the updated link tables.
		if (isset($this->linktable))
		{
			$this->format($body_r, 'post_wacko');
		}
		else
		{
			$this->linktable = [];
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
			if ($this->db->tls)
			{
				if (isset($this->db->open_url) && strpos($url, $this->db->open_url) !== false)
				{
					$url = str_replace($this->db->open_url, $this->db->base_url, $url);
				}
			}

			// translit
			if (strpos($url, $this->db->base_url) !== false)
			{
				$sub = substr($url, strlen($this->db->base_url));
				$url = $this->db->base_url . $this->translit($sub);
			}

			// tagging
			if (strpos($url, '%s'))
			{
				return str_replace('%s', $tag, $url);
			}
			else
			{
				return $url . $tag;
			}
		}
	}

	// FORMS
	// parameter: named parameter array
	function form_open($form_name = '', $parameter = [])
	{
		$page_method	= '';
		$form_method	= 'post';
		$form_token		= -1;
		$tag			= '';
		$form_more		= '';
		$href_param		= '';
		extract($parameter, EXTR_IF_EXISTS);

		if ($form_token === -1)
		{
			$form_token = ($form_method == 'post');
		}

		$add = (@$_GET['add'] || @$_POST['add']);

		$result	= '<form action="' .
			$this->href($page_method, $tag, $href_param, $add) . '" ' .
			$form_more . ' method="' . $form_method . '" ' . ($form_name ? 'name="' . $form_name . '" ' : '') . ">\n";

		if (!($this->db->rewrite_mode || $this->db->ap_mode))
		{
			$result .= '<input type="hidden" name="page" value="' . $this->mini_href($page_method, $tag, $add) . "\" />\n";
		}

		// add form token
		if ($form_token)
		{
			// do not cache pages with nonces!
			$this->http->no_cache(false);

			$nonce = $this->sess->create_nonce($form_name,
				(($this->db->form_token_time == -1)? 1000000 : max(30, $this->db->form_token_time)));
				// STS remove -1 from setup

			$result .=
				'<input type="hidden" name="_nonce" value="' . $nonce . '" />' . "\n" .
				'<input type="hidden" name="_action" value="' . $form_name . '" />' . "\n";
		}

		return $result;
	}

	function form_close()
	{
		return "</form>\n";
	}

	function validate_post_token()
	{
		if ($_POST
			&& !$this->sess->verify_nonce(@$_POST['_action'], @$_POST['_nonce']))
		{
			$_POST		= [];
			$_REQUEST	= $_GET;

			$this->set_message($this->_t('FormInvalid'), 'error');

			// TODO diag or not?
			// $this->log(1, '**!!' . 'Potential CSRF attack in progress detected.' . '!!**'.' [[/' . $this->page['tag'] . ']] ' . $form_name); # 'Invalid form token'

			return false;
		}

		return true;
	}

	// REFERRERS
	function log_referrer()
	{
		if ($this->page
			&& ($ref = @$_SERVER['HTTP_REFERER'])
			&& !$this->bad_words($ref)
			&& filter_var($ref, FILTER_VALIDATE_URL))
		{
			$heads		= ['https://' . $this->db->tls_proxy . '/', 'https://', 'http://'];
			$headless	= str_replace($heads, '', $ref);

			if ($ref !== $headless) // if protocol known..
			{
				$we = rtrim(str_replace($heads, '', $this->db->base_url), '/');

				if (strncasecmp($headless, $we, strlen($we))) // if not from ourselves..
				{
					$this->db->sql_query(
						"INSERT INTO " . $this->db->table_prefix . "referrer SET " .
							"page_id		= '" . (int) $this->page['page_id'] . "', " .
							"referrer		= " . $this->db->q($ref) . ", " .
							"ip				= " . $this->db->q($this->http->ip) . ", " .
							"referrer_time	= UTC_TIMESTAMP()");
				}
			}
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
		return $this->db->load_all(
			"SELECT " .
			(!isset($page_id)
				? "referrer, count(referrer) AS num "
				: "page_id, referrer, count(referrer) AS num ") .
			"FROM " . $this->db->table_prefix . "referrer " .
			(!is_null($page_id)
				? "WHERE page_id = '" . (int) $page_id . "' "
				: "") .
			"GROUP BY referrer " .
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
				$__tpl = pathinfo($__pathname);
				$__tpl = Ut::join_path($__tpl['dirname'], 'template', $__tpl['filename'] . '.tpl'); // STS magic string

				if (@file_exists($__tpl))
				{
					$tpl = Templatest::read($__tpl, CACHE_TEMPLATE_DIR);
					$tpl->pull('_t', function ($block, $loc, $str) { return $this->_t($str); });
					$tpl->pull('format_t', function ($block, $loc, $str) { return $this->format_t($str); });
					$tpl->pull('db', function ($block, $loc, $str) { return $this->db[$str]; });
					$tpl->pull('href', function ($block, $loc, $method = '', $param = '') { return $this->href($method, '', $param); });
					$tpl->pull('csrf',
						function ($block, $loc, $action)
						{
							// do not cache pages with nonces!
							$this->http->no_cache(false);

							$nonce = $this->sess->create_nonce($action,
								(($this->db->form_token_time == -1)? 1000000 : max(30, $this->db->form_token_time)));
								// STS remove -1 from setup

							return
								'<input type="hidden" name="_nonce" value="' . $nonce . '" />' . "\n" .
								'<input type="hidden" name="_action" value="' . $action . '" />' . "\n";
						});
					$tpl->setEncoding($this->charset);
					$tpl->filter('time_formatted',
						function ($value)
						{
							return $this->get_time_formatted($value);
						});
					$tpl->filter('hide_page',
						function ($value)
						{
							// for generating method GET forms
							if (preg_match('#\?page=([^&]+)#', $value, $match))
							{
								return '<input type="hidden" name="page" value="' . $match[1] . '" />';
							}
						});
					$tpl->filter('_t', function ($str) { return $this->_t($str); });

					// STS lotta goodies must go there..
				}

				if (is_array($__vars))
				{
					extract($__vars, EXTR_SKIP);
				}

				// include_tail is for extensions to use for closing markup tags, i.e. if return'ing early
				$include_tail = '';
				ob_start();
				include $__pathname;

				if (isset($tpl))
				{
					$output = (string) $tpl;

					if (($spare = ob_get_contents()))
					{
						trigger_error('templated ' . $__pathname . ' also produce echo-output', E_USER_WARNING);
						$output .= $spare;
					}
				}
				else
				{
					echo $include_tail;
					$output = ob_get_contents();
				}

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
		$theme_path		= Ut::join_path(THEME_DIR, $this->db->theme, 'appearance');
		$error_message	= $this->_t('ThemeCorrupt') . ': ' . $this->db->theme;

		return $this->include_buffered('header' . $mod . '.php', $error_message, '', $theme_path);
	}

	function theme_footer($mod = '')
	{
		$theme_path		= Ut::join_path(THEME_DIR, $this->db->theme, 'appearance');
		$error_message	= $this->_t('ThemeCorrupt') . ': ' . $this->db->theme;

		return $this->include_buffered('footer' . $mod . '.php', $error_message, '', $theme_path);
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
	function action($action, $params = [], $force_link_tracking = 0)
	{
		$action = strtolower(trim($action));
		$errmsg = '<em>' . $this->_t('UnknownAction') . ' <code>' . $action . '</code></em>';

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

		$method_location	= Ut::join_path($handler, $method . '.php');
		$errmsg				= '<em>' . $this->_t('UnknownMethod') . ' <code>' . $method_location . '</code></em>';

		$result				= $this->include_buffered($method_location, $errmsg, '', HANDLER_DIR);

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
		$err	= '<em>' . Ut::perc_replace($this->_t('FormatterNotFound'), '<code>' . $formatter . '</code>') . '</em>';
		$text	= $this->include_buffered(Ut::join_path(FORMATTER_DIR, $formatter . '.php'), $err, compact('text', 'options'));

		if ($formatter == 'wacko' && $this->db->default_typografica)
		{
			$text = $this->include_buffered(Ut::join_path(FORMATTER_DIR, 'typografica.php'), $err, compact('text'));
		}

		return $text;
	}

	// GROUPS
	function load_usergroup($group_name, $group_id = 0)
	{
		$fiels_default	= 'g.group_id, g.group_name, g.group_lang, g.description, g.moderator_id, g.created, g.is_system, g.open, g.active, u.user_name AS moderator';

		$usergroup = $this->db->load_single(
			"SELECT {$fiels_default} " .
			"FROM " . $this->db->table_prefix . "usergroup g " .
				"LEFT JOIN " . $this->db->table_prefix . "user u ON (g.moderator_id = u.user_id) " .
			"WHERE " . ( $group_id != 0
				? "g.group_id		= '" . (int) $group_id . "' "
				: "g.group_name		= " . $this->db->q($group_name) . " ") .
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
		if (!$this->db->antidupe)
		{
			if ($this->db->load_single(
			"SELECT user_id " .
			"FROM " . $this->db->user_table . " " .
			"WHERE user_name = " . $this->db->q($user_name) . " " .
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
		$table = [
			'cyr' => 'ÀÂÑÄÅÍÊÌÎÐÒÕÓàñåêìïîðãèòõó0áI1',
			'lat' => 'ABCDEHKMOPTXYacekmnoprutxyÎ6ll',
		];

		// splitting input name into array
		$user_name = preg_split('//', $user_name, -1, PREG_SPLIT_NO_EMPTY);

		// let's define characters positions and corresponding substitutions.
		// so we're constructing $p array with username chars needing
		// substitution positions as keys, and corresponding table positions
		// as array values
		$p = [];

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
				$user_name[$pos] = '[' . $user_name[$pos] . $table['cyr'][$sub] . ']';
			}
			else if ($user_name[$pos] != $table['lat'][$sub])
			{
				// constructing latin regexp addition
				$user_name[$pos] = '[' . $user_name[$pos] . $table['lat'][$sub] . ']';
			}
		}

		// checking database
		if ($this->db->load_single(
		"SELECT user_id " .
		"FROM " . $this->db->user_table . " " .
		"WHERE user_name REGEXP " . $this->db->q(implode('', $user_name)) . " " .
		"LIMIT 1", true))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// check whether email is already registered as one of user's email
	function email_exists($email)
	{
		return !!$this->db->load_single(
			"SELECT user_id " .
			"FROM " . $this->db->user_table . " " .
			"WHERE email = " . $this->db->q($email) . " " .
			"LIMIT 1");
	}

	/**
	 * Loads user data
	 *
	 * @param string $user_name
	 * @param number $user_id
	 *
	 * @return array
	 */
	function load_user($user_name, $user_id = 0)
	{
		return $this->db->load_single(
			"SELECT
				u.user_id, u.user_name, u.real_name, u.account_lang, u.password, u.email, u.account_status, u.account_type,
				u.enabled, u.signup_time, u.change_password, u.user_ip, u.email_confirm, u.last_visit,
				u.session_expire, u.last_mark, u.login_count, u.lost_password_request_count, u.failed_login_count, u.total_pages,
				u.total_revisions, u.total_comments, u.total_uploads, u.fingerprint,
				s.doubleclick_edit, s.show_comments, s.list_count, s.menu_items, s.user_lang, s.show_spaces, s.typografica,
				s.theme, s.autocomplete, s.numerate_links, s.notify_minor_edit, s.notify_page, s.notify_comment, s.dont_redirect,
				s.send_watchmail, s.show_files, s.allow_intercom, s.allow_massemail, s.hide_lastsession, s.validate_ip, s.noid_pubs,
				s.session_length, s.timezone, s.dst, s.sorting_comments " .
			"FROM " . $this->db->user_table . " u " .
				"LEFT JOIN " . $this->db->table_prefix . "user_setting s ON (u.user_id = s.user_id) " .
			"WHERE " . ($user_id
					? "u.user_id		= '" . (int) $user_id . "' "
					: "u.user_name		= " . $this->db->q($user_name) . " ") .
					"AND u.account_type = '0' " .
			"LIMIT 1");
	}

	function get_user_name()
	{
		return $this->get_user_setting('user_name');
	}

	function get_user_ip()
	{
		return $this->http->ip;
	}

	// extract user data from the session array
	function get_user()
	{
		return @$this->sess->userprofile;
	}

	// insert user data into the session array
	function set_user($user)
	{
		$this->sess->userprofile = $user;

		$this->set_user_setting('ip', $this->get_user_ip());

		$this->user_lang = $this->get_user_language();
		$this->set_language($this->user_lang, true);

		$this->set_menu(MENU_USER);
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
		else if (@$this->sess->userprofile)
		{
			$this->sess->userprofile[$setting] = $value;
		}
	}

	function update_last_mark($user)
	{
		if ($user['user_id'])
		{
			return $this->db->sql_query(
				"UPDATE " . $this->db->user_table . " SET " .
					"last_mark = UTC_TIMESTAMP() " .
				"WHERE user_id = '" . $user['user_id'] . "' " .
				"LIMIT 1");
		}
	}

	// update comments count and date on commented page
	function update_comments_count($comment_on_id)
	{
		// load latest comment
		$comment = $this->db->load_single(
			"SELECT created " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE comment_on_id = '" . (int) $comment_on_id . "' " .
			"ORDER BY created DESC " .
			"LIMIT 1");

		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "page SET " .
				"comments	= '" . $this->count_comments($comment_on_id) . "', " .
				"commented	= " . $this->db->q($comment['created']) . " " .
			"WHERE page_id	= '" . (int) $comment_on_id . "' " .
			"LIMIT 1");
	}

	function get_list_count($max)
	{
		$user_max = $this->get_user_setting('list_count');

		if (!isset($user_max))
		{
			// use default as fallback
			$user_max = $this->db->list_count;
		}
		else if ($user_max <= 0)
		{
			$user_max = 10;
		}
		else if ($user_max > 100)
		{
			$user_max = 100;
		}

		$max = (int) $max;

		if ($max <= 0 || $max > $user_max)
		{
			$max = $user_max;
		}

		return $max;
	}

	/*
	 * auth token workshop
	 * https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence,
	 * re "Proactively Secure Long-Term User Authentication"
	 */
	function create_auth_token($user)
	{
		$session_days	= ($user['session_length'] > 0) ? $user['session_length'] : $this->db->session_length;
		$selector		= Ut::http64_encode(Ut::random_bytes(9));
		$authenticator	= Ut::random_bytes(33);

		$this->sess->set_cookie(AUTH_TOKEN, $selector . Ut::http64_encode($authenticator), $session_days);

		$this->db->sql_query(
			"INSERT INTO " . $this->db->table_prefix . "auth_token SET " .
				"selector			= '" . $selector . "', " .
				"token				= '" . hash('sha256', $authenticator) . "', " .
				"user_id			= '" . (int) $user['user_id'] . "', " .
				"token_expires		= '" . $this->db->date(time() + $session_days * DAYSECS) . "'"
			);
	}

	function check_auth_token()
	{
		if (($token = $this->sess->get_cookie(AUTH_TOKEN)))
		{
			$selector		= substr($token, 0, 12);
			$authenticator	= substr($token, 12);

			$token = $this->db->load_single(
				"SELECT auth_token_id, token, user_id " .
				"FROM " . $this->db->table_prefix . "auth_token " .
				"WHERE selector = " . $this->db->q($selector) . " " .
					"AND token_expires > UTC_TIMESTAMP() " .
				"LIMIT 1");

			// STS check for expires also
			if ($token && $token['token'] === hash('sha256', Ut::http64_decode($authenticator)))
			{
				$this->db->sql_query(
					"UPDATE " . $this->db->user_table . " SET " .
						"last_visit = UTC_TIMESTAMP() " .
					"WHERE " .
						"user_id = '" . (int) $token['user_id'] . "' " .
					"LIMIT 1");

				// re-create auth token on successful use, effectively prolonging it expiration
				$this->db->sql_query(
					"DELETE
					FROM " . $this->db->table_prefix . "auth_token
					WHERE auth_token_id = '" . (int) $token['auth_token_id'] . "'");

				if (($user = $this->load_user(0, $token['user_id'])))
				{
					$this->create_auth_token($user);
					return $user;
				}
			}

			// just purge stale auth token
			$this->sess->delete_cookie(AUTH_TOKEN);
		}

		return false;
	}

	function delete_auth_token($user_id)
	{
		// NB there can be many tokens for one user
		$this->db->sql_query(
			"DELETE
			FROM " . $this->db->table_prefix . "auth_token
			WHERE user_id = '" . (int) $user_id . "'");
	}

	// user logs in by explicitly providing password
	function log_user_in($user, $remember_me = false)
	{
		$this->soft_login($user);

		if ($remember_me)
		{
			$this->create_auth_token($user);
		}

		$this->db->sql_query(
			"UPDATE " . $this->db->user_table . " SET " .
				"last_visit						= UTC_TIMESTAMP(), " .
				"change_password				= '', " .
				"login_count					= login_count + 1, " .
				"failed_login_count				= 0, " .
				"lost_password_request_count	= 0 " . // STS value unused
			"WHERE " .
				"user_id						= '" . (int) $user['user_id'] . "' " .
			"LIMIT 1");
	}

	function soft_login($user)
	{
		$this->sess->restart();
		$this->sess->sticky_login = 1;
		$this->set_user($user);
		$this->set_message(Ut::perc_replace($this->_t('WelcomeBack'), $user['user_name']), 'success');
	}

	function session_notice($message)
	{
		// TODO: pass and use user_lang
		if ($message == 'ip')
		{
			$this->set_message(Ut::perc_replace($this->_t('IPAddressChanged', SYSTEM_LANG), $this->http->ip, implode(', ', array_keys($this->sess->sticky__ip))));
		}
		else if ($message && @$this->sess->sticky_login)
		{
			// TODO make message readable
			/*$tr = [
				'replay' => 'replay',
				'obsolete' => 'obsolete',
				'reg_expire' => 'reg_expire',
				'max_session' => 'max_session',
				'max_idle' => 'max_idle', // You have been logged out due to inactivity.
				'ua' => 'ua',
				'tls' => 'tls',
				'ip' => 'ip', // due your IP address changed.
			];*/

			$this->set_message(Ut::perc_replace($this->_t('SessionTerminatedDue', SYSTEM_LANG), $message));
			$this->sess->sticky_login = 0;
		}
	}

	// explicitly end user session and free session vars
	function log_user_out()
	{
		if (($user = $this->get_user()))
		{
			// we destroy ALL user's auth tokens - effectively enforce user to re-login thru password auth
			$this->delete_auth_token($user['user_id']);

			$this->sess->delete_cookie(AUTH_TOKEN);

			$this->sess->restart();
			$this->sess->sticky_login = 0;
			$this->set_menu(MENU_DEFAULT);
			$this->set_message($this->_t('LoggedOut'), 'success');
			$this->log(5, Ut::perc_replace($this->_t('LogUserLoggedOut', SYSTEM_LANG), $user['user_name']));
			// $this->context[++$this->current_context] = '';   <<=== what's that?!
		}
	}

	// here we make all false login attempts last the same amount of time
	// to avoid timing attacks on valid usernames
	function log_user_delay($login_delay = 5) // STS TODO configure
	{
		$exec_limit = ini_get('max_execution_time');
		set_time_limit(0);

		while (($sleep = $login_delay - (microtime(1) - WACKO_STARTED)) > 0)
		{
			// Stall next login for a bit.
			// This will considerably slow down brute force attackers.
			usleep($sleep * 1000000);
		}

		set_time_limit($exec_limit);
	}
	// end auth token stuff

	// Increment the failed login count by 1
	function set_failed_user_login_count($user_id)
	{
		$this->db->sql_query(
			"UPDATE " . $this->db->user_table . " SET " .
				"failed_login_count = failed_login_count + 1 " .
			"WHERE user_id = '" . (int) $user_id . "' " .
			"LIMIT 1");
	}

	function load_users($enabled = 1)
	{
		return $this->db->load_all(
			"SELECT user_id, user_name " .
			"FROM " . $this->db->user_table . " " .
				($enabled
					? "WHERE enabled = '1' "
					: "") .
			"ORDER BY BINARY user_name");
	}

	function get_user_id($user_name = '')
	{
		if ($user_name !== '')
		{
			$user = $this->db->load_single(
				"SELECT user_id " .
				"FROM " . $this->db->table_prefix . "user " .
				"WHERE user_name = " . $this->db->q($user_name) . " " .
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
		return $this->db->enable_comments != 0 && ($this->db->enable_comments != 2 || $this->get_user());
	}

	// COMMENTS AND COUNTS

	// recount all comments for a given page
	function count_comments($comment_on_id, $deleted = 0)
	{
		$count = $this->db->load_single(
			"SELECT COUNT(tag) AS n " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE comment_on_id = '" . (int) $comment_on_id . "' " .
				($deleted != 1
					? "AND deleted <> '1' "
					: "") .
			"LIMIT 1");

		return (int) $count['n'];
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
			$count = $this->db->load_single(
				"SELECT comments " .
				"FROM " . $this->db->table_prefix . "page " .
				"WHERE page_id = '" . (int) $page_id . "' " .
				"LIMIT 1");

			return (int) $count['comments'];
		}

		return false;
	}

	function load_comments($page_id, $limit = 0, $count = 30, $sort = 0, $deleted = 0)
	{
		// avoid results if $page_id is 0 (page does not exists)
		if ($page_id)
		{
			return $this->db->load_all(
				"SELECT p.page_id, parent_id, p.user_id, p.title, p.tag, p.created, p.modified, p.body, p.body_r, u.user_name, o.user_name as owner_name " .
				"FROM " . $this->db->table_prefix . "page p " .
					"LEFT JOIN " . $this->db->table_prefix . "user u ON (p.user_id = u.user_id) " .
					"LEFT JOIN " . $this->db->table_prefix . "user o ON (p.owner_id = o.user_id) " .
				"WHERE p.comment_on_id = '" . (int) $page_id . "' " .
					($deleted != 1
						? "AND p.deleted <> '1' "
						: "") .
				"ORDER BY p.created " .
					($sort
						? "DESC "
						: "") .
				"LIMIT {$limit}, {$count}");
		}
	}

	// ACCESS CONTROL
	function is_admin()
	{
		if (isset($this->sess->admin_it_is))
		{
			return $this->sess->admin_it_is;
		}

		if (isset($this->db->groups['Admins']) && is_array($this->db->groups['Admins']))
		{
			if (in_array($this->get_user_id(), $this->db->groups['Admins']))
			{
				return $this->sess->admin_it_is = 1;
			}
		}

		return $this->sess->admin_it_is = 0;
	}

	function is_moderator()
	{
		if (!$this->get_user())
		{
			return false;
		}

		if (isset($this->db->groups['Moderator']) && is_array($this->db->groups['Moderator']))
		{
			if (in_array($this->get_user_id(), $this->db->groups['Moderator']))
			{
				return true;
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

		if (isset($this->db->groups['Reviewer']) && is_array($this->db->groups['Reviewer']))
		{
			if (in_array($this->get_user_id(), $this->db->groups['Reviewer']))
			{
				return true;
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
		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "page SET " .
				"owner_id = '" . (int) $user_id . "' " .
			"WHERE page_id = '" . (int) $page_id . "' " .
			"LIMIT 1");
	}

	function save_acl($page_id, $privilege, $list)
	{
		if ($this->load_acl($page_id, $privilege, 0, 0, 0))
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "acl SET " .
					"list = " . $this->db->q(trim(str_replace("\r", '', $list))) . " " .
				"WHERE page_id = '" . (int) $page_id . "' " .
					"AND privilege = " . $this->db->q($privilege) . " ");
		}
		else
		{
			// STS: maybe simply ON DUPLICATE KEY UPDATE?
			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "acl SET " .
					"list		= " . $this->db->q(trim(str_replace("\r", '', $list))) . ", " .
					"page_id	= '" . (int) $page_id . "', " .
					"privilege	= " . $this->db->q($privilege) . " ");
		}
	}

	/**
	* Get ACL for tag from cache
	*
	* @param int $page_id
	* @param string $privilege ACL privilege: read, write, comment, create, upload
	* @param boolean $use_defaults
	*
	* @return array ACL
	*/
	function get_cached_acl($page_id, $privilege, $use_defaults)
	{
		if (isset( $this->acl_cache[$page_id . '#' . $privilege . '#' . $use_defaults] ))
		{
			return $this->acl_cache[$page_id . '#' . $privilege . '#' . $use_defaults];
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
		$this->acl_cache[$page_id . '#' . $privilege . '#' . $use_defaults] = $acl;
	}

	/**
	* Load ACL
	*
	* @param int $page_id
	* @param string $privilege ACL privilege: read, write, comment, create, upload
	* @param boolean $use_defaults
	* @param boolean $use_cache
	* @param boolean $use_parent
	* @param string $new_tag
	*
	* @return array $acl Access control list
	*/
	// TODO: add bulk option -> load entire page related privileges at once in obj-cache
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
					$acl = $this->db->load_single(
						"SELECT page_id, privilege, list " .
						"FROM " . $this->db->table_prefix . "acl " .
						"WHERE page_id = '" . (int) $page_id . "' " .
							"AND privilege = " . $this->db->q($privilege) . " " .
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

					if (strstr($tag, '/'))
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
						$acl = [
							'page_id'	=> $page_id,
							'privilege'	=> $privilege,
							'list'		=> $this->db->{'default_' . $privilege . '_acl'},
							'time'		=> date('YmdHis'),
							'default'	=> 1,
						];
					}
				}

				$this->cache_acl($page_id, $privilege, $use_defaults, $acl);
			}
		}

		return $acl;
	}

	/**
	 * check access privilege
	 *
	 * @param string $privilege
	 * @param string $page_id
	 * @param string $user_name
	 * @param int $use_parent
	 * @param string $new_tag
	 *
	 * @return boolean
	 */
	function has_access($privilege, $page_id = '', $user_name = '', $use_parent = 1, $new_tag = '')
	{
		if (!$user_name)
		{
			$user_name = strtolower($this->get_user_name());
		}

		if (!($page_id = trim($page_id)))
		{
			$page_id = @$this->page['page_id'];
		}

		// if still no page_id, use tag
		if (empty($page_id) && !$new_tag)
		{
			// new page which is to be created
			$new_tag = $this->tag;
		}

		if ($privilege == 'write')
		{
			$use_parent = 0;
		}

		// load acl
		$acl		= $this->load_acl($page_id, $privilege, 1, 1, $use_parent, $new_tag);
		// cache
		$this->_acl	= $acl;

		// locked down to read only
		if ($this->db->acl_lock == true && $privilege != 'read')
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

	/**
	 *
	 * @param string $user_name
	 * @param unknown $acl_list
	 * @param boolean $copy_to_this_acl
	 *
	 * @return boolean
	 */
	function check_acl($user_name, $acl_list, $copy_to_this_acl = false)
	{
		if (is_array($user_name))
		{
			$user_name = $user_name['user_name'];
		}

		if (!$user_name)
		{
			$user_name = GUEST;
		}

		$user_name = strtolower($user_name);

		// replace groups
		$acl = str_replace(' ', '', strtolower($this->replace_aliases($acl_list)));

		if ($copy_to_this_acl)
		{
			$this->_acl['list'] = $acl;
		}

		$acls = "\n" . $acl . "\n";

		if ($user_name == GUEST || $user_name == '')
		{
			if (($pos = strpos($acls, '*')) === false)
			{
				return false;
			}

			if ($acls[$pos - 1] != '!')
			{
				return true;
			}

			return false;
		}

		$upos	= strpos($acls, "\n" . $user_name . "\n");
		$aupos	= strpos($acls, "\n!" . $user_name . "\n");
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
			if ($acls[$spos - 1] == '!')
			{
				return false;
			}
		}

		if ($bpos !== false)
		{
			if ($acls[$bpos - 1] == '!')
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
		$aliases = [];

		if (!isset($this->db->aliases) || !is_array($this->db->aliases))
		{
			return $acl;
		}

		foreach ($this->db->aliases as $key => $val)
		{
			$aliases[strtolower($key)] = $val;
		}

		do
		{
			$list		= [];
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
						$list[]	= ($negate ? '!' . $item : $item);
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
				if ( ( $this->db->upload === true
						|| $this->db->upload == 1
						|| $this->check_acl($user_name, $this->db->upload) )
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
				if ( $this->db->upload === true
						|| $this->db->upload == 1
						|| $this->check_acl($user_name, $this->db->upload)
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
		return $this->db->load_single(
			"SELECT watch_id " .
			"FROM " . $this->db->table_prefix . "watch " .
			"WHERE user_id		= '" . (int) $user_id . "' " .
				"AND page_id	= '" . (int) $page_id . "' " .
			"LIMIT 1");
	}

	function set_watch($user_id, $page_id)
	{
		// Remove old watch first to avoid double watches
		$this->clear_watch($user_id, $page_id);

		if ($this->has_access('read', $page_id))
		{
			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "watch (user_id, page_id) " .
				"VALUES (	'" . (int) $user_id . "',
							'" . (int) $page_id . "')" );
				// TIMESTAMP type is filled automatically by MySQL
		}
	}

	function clear_watch($user_id, $page_id)
	{
		return $this->db->sql_query(
			"DELETE FROM " . $this->db->table_prefix . "watch " .
			"WHERE user_id		= '" . (int) $user_id . "' " .
				"AND page_id	= '" . (int) $page_id . "'");
	}

	// REVIEW
	function set_review($reviewer_id, $page_id)
	{
		// set / unset review
		if ($this->has_access('read', $page_id))
		{
			$reviewed = !$this->page['reviewed'];

			return $this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page SET " .
					"reviewed		= '" . (int) $reviewed . "', " .
					"reviewed_time	= UTC_TIMESTAMP(), " .
					"reviewer_id	= '" . (int) $reviewer_id . "' " .
				"WHERE page_id = '" . (int) $page_id . "' " .
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
		$user_menu_formatted = [];

		// avoid results if $user_id is 0 (user does not exists)
		if ($user_id)
		{
			$user_menu = $this->db->load_all(
				"SELECT p.page_id, p.tag, p.title, m.menu_title, m.menu_lang " .
				"FROM " . $this->db->table_prefix . "menu m " .
					"LEFT JOIN " . $this->db->table_prefix . "page p ON (m.page_id = p.page_id) " .
				"WHERE m.user_id = '" . (int) $user_id . "' " .
					($lang
						? "AND m.menu_lang = " . $this->db->q($lang) . " "
						: "") .
				"ORDER BY m.menu_position", true);

			foreach ($user_menu as $menu_item)
			{
				$title = $menu_item['menu_title'];

				if ($title === '')
				{
					$title = $menu_item['title'];
				}

				// [0] - page_id
				// [1] - menu_title
				// [2] - menu_item formatted ((tag menu_title @@menu_lang))
				// [3] - menu_lang
				$user_menu_formatted[] = [
					$menu_item['page_id'],
					(($title !== '')? $title : $menu_item['tag']),
					'((' . $menu_item['tag'] .
						(($title !== '')? ' ' . $title : '') .
						($menu_item['menu_lang']? ' @@' . $menu_item['menu_lang'] : '') .
					'))',
					$menu_item['menu_lang'],
				];
			}
		}

		return $user_menu_formatted;
	}

	function set_menu($set = MENU_AUTO, $update = false)
	{
		$menu_page_ids	= @$this->sess->menu_page_id ?: [];
		$menu_formatted	= @$this->sess->menu ?: [];

		$user = $this->get_user();

		// initial menu table construction
		if ($set != MENU_AUTO || !($menu_formatted || $update))
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

			// parsing menu items into page_link table
			$menu_page_ids	= [];
			$menu_formatted	= [];

			foreach ($menu as $menu_item)
			{
				$menu_page_ids[]	= $menu_item[0];
				$menu_item[2]		= $this->format($menu_item[2], 'wacko');
				$menu_formatted[]	= $menu_item;
			}
		}

		// adding new menu item
		if (@$_GET['addbookmark'] && $user)
		{
			unset($_GET['addbookmark']);

			// writing menu item
			if (!in_array($this->page['page_id'], $menu_page_ids))
			{
				$position = $this->db->load_single(
					"SELECT MAX(m.menu_position) AS max_position " .
					"FROM " . $this->db->table_prefix . "menu m " .
					"WHERE m.user_id = '" . $user['user_id'] . "' ", false);

				$position = (int) $position['max_position'];

				if (!$position)
				{
					// prepopulate user menu with default menu items
					foreach ($menu_formatted as $menu_item)
					{
						$this->db->sql_query(
							"INSERT INTO " . $this->db->table_prefix . "menu SET " .
							"user_id			= '" . $user['user_id'] . "', " .
							"page_id			= '" . $menu_item[0] . "', " .
							"menu_lang			= '" . $menu_item[3] . "', " .
							"menu_title			= '" . $menu_item[1] . "', " .
							"menu_position		= '" . ++$position . "'");
					}

					$this->sess->menu_default = false;
				}

				$title				= $this->get_page_title();
				$lang				= $this->page_lang; // TODO: case -> What if the page_lang of the page itself changes?
				$menu_page_ids[]	= $this->page['page_id'];
				$menu_formatted[]	= [
										$this->page['page_id'],
										($title? $title : $this->tag),
										$this->format('((' . $this->tag . ($title? ' ' . $title : '').($lang? ' @@' . $lang : '') . '))', 'wacko'),
										$lang,
									];

				$this->db->sql_query(
					"INSERT INTO " . $this->db->table_prefix . "menu SET " .
					"user_id			= '" . $user['user_id'] . "', " .
					"page_id			= '" . $this->page['page_id'] . "', " .
					"menu_lang			= " . $this->db->q($lang) . ", " .
					#"menu_title			= " . $this->db->q($title) . ", " .
					"menu_position		= '" . ++$position . "'");
			}
		}

		// removing menu item
		if (@$_GET['removebookmark'] && $user && !$this->sess->menu_default)
		{
			unset($_GET['removebookmark']);
			// rewriting menu table except containing current page tag
			$prev = $menu_formatted;
			$menu_page_ids	= [];
			$menu_formatted	= [];

			foreach ($prev as $menu_item)
			{
				if ($menu_item[0] != $this->page['page_id'])
				{
					$menu_page_ids[]	= $menu_item[0];
					$menu_formatted[]	= $menu_item;
				}
			}

			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "menu " .
				"WHERE user_id = '" . $user['user_id'] . "' " .
					"AND page_id = '" . $this->page['page_id'] . "'");

			if (!$menu_formatted)
			{
				$this->set_menu(MENU_DEFAULT);
			}
		}

		$this->sess->menu_page_id	= $menu_page_ids;
		$this->sess->menu			= $menu_formatted;
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
	// - url arguments ?profile= ['page_id', 'arguments']
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
				#echo '### @: [' . $count . ']';

				#Ut::debug_print_r($this->sess->user_trail);

				if (isset($this->sess->user_trail[$count - 1][0])
					&&    $this->sess->user_trail[$count - 1][0] == $page_id)
				{
					#echo '### 2: [' . $count . ']';
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
					$_user_trail[-1]	= [$page_id, $this->page['tag'], $this->page['title']];
					$user_trail			= $this->sess->user_trail + $_user_trail;
					$user_trail			= array_values($user_trail);

					$this->sess->user_trail = $user_trail;
				}
			}
			else
			{
				#echo '### 6';
				$this->sess->user_trail[] = [$page_id, $this->page['tag'], $this->page['title']];
			}
		}
	}

	// user trail navigation
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
			$size		= (int) $size;
			$i			= 0;

			#Ut::debug_print_r($links);

			foreach ($links as $link)
			{
				if ($i < $size && $this->page['page_id'] != $link[0])
				{
					if ($titles == false)
					{
						$result .= $this->link($link[1], '', $link[1]) . $separator;
					}
					else if ($linking == true)
					{
						$result .= $this->link($link[1], '', $link[2]) . $separator;
					}
					else
					{
						$result .= $link[2] . ' ' . $separator . ' ';
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
		$now	= time();
		$update	= [];

		// purge referrers (once a day)
		if (($days = $this->db->referrers_purge_time) > 0
				&& $now > $this->db->maint_last_refs)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "referrer " .
				"WHERE referrer_time < DATE_SUB(UTC_TIMESTAMP(), INTERVAL '" . (int) $days . "' DAY)");

			$update['maint_last_refs'] = $now + 1 * DAYSECS;
			$this->log(7, 'Maintenance: referrers purged');
		}

		// purge outdated pages revisions (once a week)
		if (($days = $this->db->pages_purge_time) > 0
				&& $now > $this->db->maint_last_oldpages)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "revision " .
				"WHERE modified < DATE_SUB(UTC_TIMESTAMP(), INTERVAL '" . (int) $days . "' DAY)");

			$update['maint_last_oldpages'] = $now + 7 * DAYSECS;
			$this->log(7, 'Maintenance: outdated pages revisions purged');
		}

		// purge deleted pages (once per 3 days)
		if (($days = $this->db->keep_deleted_time) > 0
			&& $now > $this->db->maint_last_delpages)
		{
			list($pages, ) = $this->load_deleted(1000, 0);

			$remove	= [];
			$past	= $now - DAYSECS * $days;

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
		if (($days = $this->db->log_purge_time) > 0
			&& $now > $this->db->maint_last_log)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "log " .
				"WHERE log_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL '" . (int) $days . "' DAY )");

			$update['maint_last_log'] = $now + 3 * DAYSECS;

			$this->log(7, 'Maintenance: system log purged');
		}

		// remove outdated pages cache, purge sql cache (once per hour)
		if ($now > $this->db->maint_last_cache)
		{
			// pages cache
			if (($ttl = $this->db->cache_ttl) > 0)
			{
				// clear from db
				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "cache " .
					"WHERE cache_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL '" . (int) $ttl . "' SECOND )");

				if (Ut::purge_directory(CACHE_PAGE_DIR, $ttl))
				{
					$this->log(7, 'Maintenance: cached pages purged');
				}
			}

			// sql query cache
			if (($ttl = $this->db->cache_sql_ttl) > 0)
			{
				if (Ut::purge_directory(CACHE_SQL_DIR, $ttl))
				{
					$this->log(7, 'Maintenance: cached sql results purged');
				}
			}

			$update['maint_last_cache'] = $now + 3600;
		}

		// purge expired cookie_tokens (once per 3 days)
		if ($now > $this->db->maint_last_session)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "auth_token " .
				"WHERE token_expires < UTC_TIMESTAMP()");

			$update['maint_last_session'] = $now + 3 * DAYSECS;
			$this->log(7, 'Maintenance: expired cookie_tokens purged');
		}

		$this->db->_set($update);
	}

	// MAIN EXECUTION ROUTINE
	function run($tag, $method)
	{
		$this->http->cache_promisc();

		// mandatory tls?
		if ($this->db->tls_implicit && !$this->http->tls_session)
		{
			$this->http->ensure_tls($this->href($method, $tag));
		}

		// clean _POST if no csrf token
		$this->validate_post_token();

		// url lang selection
		$url	= explode('@@', $tag);
		$tag	= trim($url[0]);
		$lang	= trim(@$url[1]); // STS: unused! remove?
		$user	= '';

		if (!$tag)
		{
			$tag = $this->db->root_page;
		}

		// autotasks
		if (Ut::rand(0, 99) < 5)
		{
			$this->maintenance();
		}

		// check IP validity
		if ($this->get_user_setting('validate_ip') && $this->get_user_setting('ip') != $this->get_user_ip())
		{
			// TODO: set and load lang??
			$this->log(1, '<strong><span class="cite">' . Ut::perc_replace($this->_t('LogUserIPSwitched', SYSTEM_LANG), $this->get_user_setting('user_name'), $this->get_user_setting('ip'), $this->get_user_ip()) . '</span></strong>');
			$this->log_user_out();
			$this->login_page();
		}

		// start user session
		if (!($user = $this->get_user()) && ($user = $this->check_auth_token()))
		{
			// re-login by auth token
			$this->soft_login($user);
		}

		// user settings
		// set user theme prior to user_lang to load theme lang files -> load_translation()
		if (isset($user['theme']))
		{
			$this->db->theme		= $user['theme'];
			$this->db->theme_url	= $this->db->base_url . Ut::join_path(THEME_DIR, $this->db->theme) . '/';
		}

		$this->user_lang = $this->get_user_language();
		$this->set_language($this->user_lang, true);

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
			$method			= '';
			$ids			= explode('x', $tag);

			$revision_id	= $this->db->load_single(
				"SELECT revision_id " .
				"FROM " . $this->db->table_prefix . "revision " .
				"WHERE page_id = '" . $ids[0] . "' " .
					"AND version_id = '" . $ids[1] . "' " .
				"LIMIT 1");

			$revision_id	= $revision_id?  $revision_id['revision_id'] : 0;
			$page			= $this->load_page('', $ids[0], $revision_id, '', '', $this->is_admin());

			if ($page)
			{
				$this->method			= 'show';
				$this->tag				= $page['tag'];
				$this->supertag			= $page['supertag'];
				$_GET['revision_id']	= $revision_id;
			}
		}

		if (!$page)
		{
			if (!($this->method = trim($method)))
			{
				$this->method = 'show';
			}

			// normalizing tag name
			if (!preg_match('/^[' . $this->language['ALPHANUM_P'] . '\!]+$/', $tag))
			{
				$tag = $this->try_utf_decode($tag);
			}

			$tag = str_replace("'", '_', str_replace('\\', '', str_replace('_', '', $tag)));
			$tag = preg_replace('/[^' . $this->language['ALPHANUM_P'] . '\_\-\.]/', '', $tag);

			$this->tag		= $tag;
			$this->supertag	= $this->translit($tag);

			$revision_id	= isset($_GET['revision_id']) ? (int) $_GET['revision_id'] : '';

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
			if ($this->db->outlook_workaround && !$page)
			{
				$page = $this->load_page($this->supertag . "'", 0, $revision_id);
			}
		}

		$this->set_page($page); // the only call

		if ($this->db->enable_referrers)
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
					$this->db[$key] = $val;
				}
			}

			// TODO: ['themes_per_page'] load themes language files
			$this->db->theme_url = $this->db->base_url . Ut::join_path(THEME_DIR, $this->db->theme) . '/';

			// set page categories. this defines $categories (array) object property
			$categories = $this->load_categories($this->page['page_id']);

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
		$this->is_watched = ($user && $this->page && $this->is_watched($user['user_id'], $this->page['page_id']));

		// check revision hideing (1 - guests, 2 - registered users)
		$this->hide_revisions = ($this->page && !$this->is_admin()
			&& (($this->db->hide_revisions == 1 && !$this->get_user())
				|| ($this->db->hide_revisions == 2 && !$this->is_owner())));

		// forum page
		$this->forum = !!(preg_match('/' . $this->db->forum_cluster . '\/.+?\/.+/', $this->tag) ||
			($this->page['comment_on_id'] ? preg_match('/' . $this->db->forum_cluster . '\/.+?\/.+/', $this->get_page_tag($this->page['comment_on_id'])) : ''));

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
			echo $this->theme_header($mod) . $data . $this->theme_footer($mod);
		}

		// goback feature
		if ($this->page && !$this->no_way_back && $this->tag != $this->db->root_page)
		{
			$this->sess->sticky_goback = $this->slim_url($this->tag);
		}

		// NB: never been here if redirect() called!
		$this->write_sitemap();
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

		$page['body_toc']	= (isset($page['body_toc']) ? $page['body_toc'] : null);
		$toc				= explode('<heading,row>', $page['body_toc']);

		foreach ($toc as $k => $toc_item)
		{
			$toc[$k] = explode('<heading,col>', $toc_item);
		}

		$_toc = [];

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
		$hash = [];

		foreach ($this->post_wacko_toc as $v)
		{
			$hash[$v[0]] = $v;
		}

		$this->post_wacko_toc_hash = &$hash;

		if (isset($this->post_wacko_action['toc']))
		{
			// #2. find all <hX id="h1249-1" class="heading"></hX> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<h([0-9]) id=\"(h[0-9]+-[0-9]+)\" class=\"heading\">(.*?)</h\\2>)!i",
				[&$this, 'numerate_toc_callback_toc'], $what);
		}

		if (isset($this->post_wacko_action['p']))
		{
			// #2. find all <p id="p1249-1" class="auto"> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<p id=\"(p[0-9]+-[0-9]+)\" class=\"auto\">(.+?)</p>)!is",
				[&$this, 'numerate_toc_callback_p'], $what);
		}

		return $what;
	}

	function numerate_toc_callback_toc($matches)
	{
		return '<h' . $matches[2] . ' id="' . $matches[3] . '" class="heading">' .
			(isset($this->post_wacko_toc_hash[$matches[3]][1])
				? $this->post_wacko_toc_hash[$matches[3]][1]
				: $matches[4]) .
			'</h' . $matches[2] . '>';
	}

	function numerate_toc_callback_p($matches)
	{
		if (!($style = $this->paragrafica_styles[$this->post_wacko_action['p']]))
		{
			$this->post_wacko_action['p'] = 'before';
			$style = $this->paragrafica_styles['before'];
		}

		$len	= strlen($this->post_wacko_maxp);
		$link	= '<a href="#' . $matches[2] . '">' .
			str_pad($this->post_wacko_toc_hash[$matches[2]][66], $len, '0', STR_PAD_LEFT) .
			'</a>';

		foreach ($this->paragrafica_patches[$this->post_wacko_action['p']] as $v)
		{
			$style[$v] = str_replace('##', $link, $style[$v]);
		}

		return $style['_before'] . '<p id=' . $matches[2] . ' class="auto">' .
			$style['before'] . $matches[3] . $style['after'] .
			'</p>' . $style['_after'];
	}

	// BREADCRUMBS -- navigation inside WackoClusters
	function get_page_path($titles = false, $separator = '/', $linking = true, $root_page = false)
	{
		$result = '';

		// check if current page is home page
		$_root_page	= !strcasecmp($this->db->root_page, $this->tag);

		// adds home page in front of breadcrumbs or current page is home page
		if ($_root_page || $root_page)
		{
			$result .= $this->compose_link_to_page($this->db->root_page);
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
			$page = $this->db->load_single(
				"SELECT title " .
				"FROM " . $this->db->table_prefix . "page " .
				"WHERE " . ($page_id
					? "page_id	= '" . (int) $page_id . "' "
					: "tag		= " . $this->db->q($tag) . " ") .
				"LIMIT 1");

			$title = $page['title'];
		}
		else if ($this->page)
		{
			$title = @$this->page['title'];
		}

		// default page title is just page's WikiName
		return $title
				? $title
				: ($tag
					? $this->add_spaces_title(trim(substr($tag, strrpos($tag, '/')), '/'))
					: $this->add_spaces_title(trim(substr($this->tag, strrpos($this->tag, '/')), '/')));
	}

	// CLONE / RENAMING / MOVING

	function clone_page($tag, $clone_tag, $clone_supertag = '', $edit_note = '')
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

		$this->clear_cache_wanted_page($clone_tag);		// STS what's that wanted stuff?!
		$this->clear_cache_wanted_page($clone_supertag);

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
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "revision SET " .
					"tag		= " . $this->db->q($new_tag) . ", " .
					"supertag	= " . $this->db->q($new_supertag) . " " .
				"WHERE tag		= " . $this->db->q($tag) . " ")
			&&
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page  SET " .
					"tag		= " . $this->db->q($new_tag) . ", " .
					"supertag	= " . $this->db->q($new_supertag) . ", " .
					"depth		= " . $this->db->q($new_depth) . " " .
				"WHERE tag		= " . $this->db->q($tag) . " ");
	}

	// REMOVALS
	function remove_acls($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$this->db->sql_query(
			"DELETE a.* " .
			"FROM " . $this->db->table_prefix . "acl a " .
				"LEFT JOIN " . $this->db->table_prefix . "page p " .
					"ON (a.page_id = p.page_id) " .
			"WHERE p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );

		return true;
	}

	function delete_pages($pages)
	{
		$remove	= [];
		$rev	= array_flip($this->page_id_cache);

		foreach ($pages as $id)
		{
			$remove[] = "'" . $id . "'";
			unset($this->page_id_cache[@$rev[$id]]);
		}

		$remove = implode(', ', $remove);

		$this->db->sql_query(
			"DELETE FROM " . $this->db->table_prefix . "page " .
			"WHERE page_id IN ( " . $remove . " )");

		$this->db->sql_query(
			"DELETE FROM " . $this->db->table_prefix . "revision " .
			"WHERE page_id IN ( " . $remove . " )");
	}

	function remove_page($page_id, $comment_on_id = 0, $dontkeep = 0)
	{
		if (!$page_id || !($page = $this->load_page('', $page_id)))
		{
			return false;
		}

		// store a copy in revision
		if ($this->db->store_deleted_pages && !$dontkeep)
		{
			// unlink comment tag
			$page['comment_on_id']	= 0;

			// saving original
			$this->save_revision($page);

			// saving updated for the current user and flag it as deleted
			$this->db->sql_query(
				"UPDATE " . $this->db->table_prefix . "page SET " .
					"modified	= UTC_TIMESTAMP(), " .
					"ip			= '" . $this->get_user_ip() . "', " .
					"deleted	= '1', " .
					// "edit_note	= '" . $this->get_user_ip() . "', " . // removed
					"user_id	= '" . $this->get_user_id() . "' " .
				"WHERE page_id	= '" . (int) $page_id . "' " .
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

		return $this->db->sql_query(
			"DELETE FROM " . $this->db->table_prefix . "revision " .
			"WHERE tag = " . $this->db->q($tag) . " " .
				($cluster
					? "OR tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );
	}

	function remove_comments($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		if ($comments = $this->db->load_all(
		"SELECT a.page_id FROM " . $this->db->table_prefix . "page a " .
			"INNER JOIN " . $this->db->table_prefix . "page b ON (a.comment_on_id = b.page_id) " .
		"WHERE b.tag = " . $this->db->q($tag) . " " .
			($cluster === true
				? "OR b.tag LIKE " . $this->db->q($tag . '/%') . " "
				: "") )
			)
		{
			foreach ($comments as $comment)
			{
				$this->remove_page($comment['page_id'], '', $dontkeep);
			}
		}

		// reset comments count
		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "page SET " .
				"comments	= '0', " .
				"commented	= created " .
			"WHERE tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );

		return true;
	}

	function remove_menu_items($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			"DELETE b.* " .
			"FROM " . $this->db->table_prefix . "menu b " .
				"LEFT JOIN " . $this->db->table_prefix . "page p " .
					"ON (b.page_id = p.page_id) " .
			"WHERE p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );
	}

	function remove_watches($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			"DELETE w.* " .
			"FROM " . $this->db->table_prefix . "watch w " .
				"LEFT JOIN " . $this->db->table_prefix . "page p " .
					"ON (w.page_id = p.page_id) " .
			"WHERE p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );
	}

	function remove_ratings($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->db->load_all(
			"SELECT page_id FROM " . $this->db->table_prefix . "page " .
			"WHERE tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );

		foreach ($pages as $page)
		{
			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "rating " .
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

		return $this->db->sql_query(
			"DELETE l.* " .
			"FROM " . $this->db->table_prefix . "page_link l " .
				"LEFT JOIN " . $this->db->table_prefix . "page p " .
					"ON (l.from_page_id = p.page_id) " .
			"WHERE p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );
	}

	function remove_page_categories($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		$this->db->sql_query(
			"DELETE k.* " .
			"FROM " . $this->db->table_prefix . "category_assignment k " .
				"LEFT JOIN " . $this->db->table_prefix . "page p " .
					"ON (k.object_id = p.page_id) " .
			"WHERE (p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") . ") " .
				"AND k.object_type_id = 1");

		return true;
	}

	function remove_category_assigments($object_id, $type_id)
	{
		if (!$object_id && !$type_id)
		{
			return false;
		}

		$this->db->sql_query(
			"DELETE k.* " .
			"FROM " . $this->db->table_prefix . "category_assignment k " .
			"WHERE k.object_id = '" . (int) $object_id . "' " .
				"AND k.object_type_id = '" . (int) $type_id . "'");

		return true;
	}

	function remove_referrers($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			"DELETE " .
				"r.* " .
			"FROM " . $this->db->table_prefix . "referrer r " .
				"INNER JOIN " . $this->db->table_prefix . "page p ON (r.page_id = p.page_id) " .
			"WHERE p.tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR p.tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );
	}

	function remove_files($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->db->load_all(
			"SELECT page_id " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE tag = " . $this->db->q($tag) . " " .
				($cluster === true
					? "OR tag LIKE " . $this->db->q($tag . '/%') . " "
					: "") );

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->db->load_all(
				"SELECT file_name " .
				"FROM " . $this->db->table_prefix . "file " .
				"WHERE page_id = '" . $page['page_id'] . "'");

			// store a copy in ...
			if ($this->db->store_deleted_pages && !$dontkeep)
			{
				// TODO: moved to backup folder
				/*foreach ($files as $file)
				{
					// remove from FS
					$file_name = Ut::join_path(UPLOAD_PER_PAGE_DIR, '@'.
							$page['page_id'] . '@' . $file['file_name']);

					@unlink($file_name);
				}*/

				// flag record as deleted in DB
				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "file SET " .
						"deleted	= '1' " .
					"WHERE page_id = '" . $page['page_id'] . "'");
			}
			else
			{
				foreach ($files as $file)
				{
					// remove from FS
					$file_name = Ut::join_path(UPLOAD_PER_PAGE_DIR, '@' .
						$page['page_id'] . '@' . $file['file_name']);

					@unlink($file_name);
				}

				// remove from DB
				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "file " .
					"WHERE page_id = '" . $page['page_id'] . "'");
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

		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "page SET " .
				"deleted	= '0' " .
			"WHERE page_id = '" . (int) $page_id . "'");
	}

	function restore_file($page_id)
	{
		if (!$page_id)
		{
			return false;
		}

		$this->db->sql_query(
			"UPDATE " . $this->db->table_prefix . "file SET " .
				"deleted	= '0' " .
			"WHERE page_id = '" . (int) $page_id . "'");
	}

	// ADDITIONAL METHODS
	function password_hash($user, $password)
	{
		return password_hash(base64_encode(hash('sha256', $user['user_name'] . $password, true)), PASSWORD_DEFAULT);
	}

	function password_verify($user, $password)
	{
		return password_verify(base64_encode(hash('sha256', $user['user_name'] . $password, true)), $user['password']);
	}

	/**
	 * Provides dummy fields as workaround to turn autocomplete off for password field
	 *
	 * <form autocomplete="off"> will turn off autocomplete for the form in most browsers
	 * except for username/email/password fields
	 *
	 * @return string dummy username/email/password fields
	 */
	function form_autocomplete_off()
	{
		/* REMARKS
		 *
		 * The situation regarding turning autocomplete off is very dissatisfying.
		 * Right now, the password manager autocomplete into fields with inappropriate values
		 * with all consequences like an unintentional leak of credentials.
		 *
		 * <input autocomplete="nope"> turns off autocomplete on many other browsers that don't respect
		 * the form's "off", but not for "password" inputs.
		 *
		 * <input type="password" autocomplete="new-password" will turn it off for passwords everywhere,
		 * but firefox don't respect that either.
		 *
		 * https://developer.mozilla.org/en-US/docs/Web/Security/Securing_your_site/Turning_off_form_autocompletion
		 **/

		// dummy fields for chrome/firefox/opera autofill getting the wrong fields
		$result =	'<!-- disables autocomplete -->' . "\n" .
					'<input type="text" style="display:none">' . "\n" .
					'<input type="password" style="display:none">' . "\n";

		return $result;
	}

	// run checks of password complexity under current
	// config settings; returned error diag, or '' if good
	function password_complexity($login, $pwd)
	{
		$unlike_login	= $this->db->pwd_unlike_login;
		$char_classes	= $this->db->pwd_char_classes;
		$min_chars		= $this->db->pwd_min_chars;
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
			$res .= $this->_t('PwdCplxEquals') . ' ';
		}

		// check password length
		if ($p < $min_chars)
		{
			$res .= $this->_t('PwdCplxShort') . ' ';
		}

		// check character classes requirements
		$error = 0;

		switch ($char_classes)
		{
			case 1:
				if (   !preg_match('/[0-9]+/',			$pwd)
					|| !preg_match('/[a-zA-Zà-ÿÀ-ß]+/',	$pwd))
				{
					++$error;
				}
				break;

			case 2:
				if (   !preg_match('/[0-9]+/',		$pwd)
					|| !preg_match('/[A-ZÀ-ß]+/',	$pwd)
					|| !preg_match('/[a-zà-ÿ]+/',	$pwd))
				{
					++$error;
				}
				break;

			case 3:
				if (   !preg_match('/[0-9]+/',		$pwd)
					|| !preg_match('/[A-ZÀ-ß]+/',	$pwd)
					|| !preg_match('/[a-zà-ÿ]+/',	$pwd)
					|| !preg_match('/[\W]+/',		$pwd))
				{
					++$error;
				}
				break;
		}
		if ($error)
		{
			$res .= $this->_t('PwdCplxWeak') . ' ';
		}

		return $res;
	}

	function show_password_complexity()
	{
		if ($this->db->pwd_char_classes > 0)
		{
			$pwd_cplx_text = $this->_t('PwdCplxDesc4');

			if ($this->db->pwd_char_classes == 1)
			{
				$pwd_cplx_text .= $this->_t('PwdCplxDesc41');
			}
			else if ($this->db->pwd_char_classes == 2)
			{
				$pwd_cplx_text .= $this->_t('PwdCplxDesc42');
			}
			else if ($this->db->pwd_char_classes == 3)
			{
				$pwd_cplx_text .= $this->_t('PwdCplxDesc43');
			}

			$pwd_cplx_text .= '. ' . $this->_t('PwdCplxDesc5');
		}

		return '<br /><small>' .
			$this->_t('PwdCplxDesc1') .
			Ut::perc_replace($this->_t('PwdCplxDesc2'), $this->db->pwd_min_chars) .
			($this->db->pwd_unlike_login > 0
				? ', ' . $this->_t('PwdCplxDesc3')
				: '') .
			($this->db->pwd_char_classes > 0
				? ', ' . $pwd_cplx_text
				: '') . '</small>';
	}

	// pages listing/navigation for multipage lists.
	//		$total		= total elements in the list
	//		$perpage	= total elements on a page
	//		$name		= page number variable in $_GET
	//		$params		= $_GET parameters to be passed with the page link (as href-formatted array or string)
	// returns an array with 'text' (navigation) and 'offset' (offset value
	// for SQL queries) elements.
	function pagination($total, $perpage = null, $_name = 'p', $params = '', $method = '', $tag = '')
	{
		$total		= (int) $total;
		$name		= 'p';
		$anchor		= '';

		// allow array parameter expansion
		if (is_array($_name))
		{
			extract($parameter, EXTR_IF_EXISTS);
		}
		else
		{
			$name = $_name;
		}

		$perpage = $this->get_list_count($perpage);

		$pagination['offset']	= 0;
		$pagination['text']		= false;
		$pagination['limit']	= '';
		$pagination['perpage']	= $perpage;

		if ($total > $perpage)
		{
			if (!is_array($params))
			{
				$params = $params? [$params] : [];
			}

			// multipage with navigation
			$sep		= ', ';
			$span		= ' ... ' . $sep;
			$total		-= 1;
			$pages		= ($total - $total % $perpage) / $perpage + 1;
			$page		= @$_GET[$name];
			$page		= ($page == 'last')? $pages : (int) $page;

			if ($page <= 0 || $page > $pages)
			{
				$page = 1;
			}

			$make_link = function ($page, $body = '', $attrs = '') use ($method, $tag, $name, $params, $anchor)
			{
				$params[$name] = $page;

				if ($this->method && $this->method != 'show')
				{
					$method = $this->method;
				}

				return '<a href="' . $this->href($method, $tag, $params, false, $anchor) . '"' . $attrs . '>' .
						($body ? $body : $page) . '</a>';
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

			$pagination['offset']	= $perpage * ($page - 1);
			$navigation				= $this->_t('ToThePage') . ': ';

			if ($page > 1)
			{
				$navigation .= $make_link($page - 1, ('&laquo; ' . $this->_t('PrevAcr')), ' rel="prev"') . ' ';
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
				$navigation .= ' ' . $make_link($page + 1, ($this->_t('NextAcr') . ' &raquo;'), ' rel="next"');
			}

			$pagination['text']		= $navigation;
			$pagination['limit']	= "LIMIT {$pagination['offset']}, $perpage";
		}

		return $pagination;
	}

	// TODO: option for _comments handler, forum action -> CSS small
	function print_pagination($pagination)
	{
		if (@$pagination['text'])
		{
			echo '<nav class="pagination">' . $pagination['text'] . "</nav>\n";
		}
	}

	function shorten_string($string, $maxlen = 80)
	{
		return (strlen($string) > $maxlen)?  substr($string, 0, 30) . '[..]' . substr($string, -20) : $string;
	}

	// show captcha form on a page. must be incorporated as an input
	// form component in every page that uses captcha testing
	//		$inline	= adds <br /> between elements
	function show_captcha($inline = true)
	{
		$out = '';

		// captcha is for guests only and if gd available
		if ($this->db->enable_captcha && !$this->get_user() && extension_loaded('gd'))
		{
			// disable server cache for page
			$this->http->no_cache(false);

			$this->sess->freecap_shown = 1;

			$out .= $inline ? '' : "<br />\n";
			$out .= '<label for="captcha">' . $this->_t('Captcha') . ":</label>\n";
			$out .= $inline ? '' : "<br />\n";
			$out .= '<img src="' . $this->db->base_url . '.freecap" id="freecap" alt="' . $this->_t('Captcha') . '" />' . "\n";
			$out .= '<a href="" onclick="this.blur(); new_freecap(); return false;" title="' . $this->_t('CaptchaReload') . '">';
			$out .= '<img src="' . $this->db->base_url . Ut::join_path(IMAGE_DIR, 'spacer.png') . '" alt="' . $this->_t('CaptchaReload') . '" class="btn-reload"/></a>' . "<br />\n";
			// $out .= $inline ? '' : "<br />\n";
			$out .= '<input type="text" id="captcha" name="captcha" maxlength="6" style="width: 273px;" />';
			$out .= $inline ? '' : "<br />\n";
		}

		return $out;
	}

	// checks whether user's captcha solution was right. function
	// takes no arguments, instead it recieves user input from
	// HTTP-POST variable 'captcha', submitted through webform.
	function validate_captcha()
	{
		$word_ok = true;
		if (isset($this->sess->freecap_shown))
		{
			$word_ok = false;
			unset($this->sess->freecap_shown);

			if (!empty($this->sess->freecap_word_hash) && !empty($_POST['captcha'])
				&& $this->sess['hash_func'](strtolower($_POST['captcha'])) === $this->sess->freecap_word_hash)
			{
				unset($this->sess->freecap_attempts);
				$word_ok = true;
			}
		}

		return $word_ok;
	}

	/**
	 * Check for valid email address.
	 *
	 * @param string $email_address = email address to check
	 *
	 * @return boolean email valid or invalid
	 */
	function validate_email($email_address)
	{
		if ($this->db->email_pattern == 'html5')
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
		if (    (int) $this->db->log_level === 0
			|| ((int) $this->db->log_level !== 7
			&& $level > (int) $this->db->log_level))
		{
			return true;
		}

		// TODO: set default lang if !isset($this->language) -> forced logout -> missing format()

		$html			= $this->db->allow_rawhtml;
		$this->db->allow_rawhtml = 0;
		$message		= (isset($this->language) ? $this->format($message, 'wacko') : $message);
		$user_id		= $this->get_user_id();
		$this->db->allow_rawhtml = $html;

		// current timestamp set automatically
		return $this->db->sql_query(
			"INSERT INTO " . $this->db->table_prefix . "log SET " .
				"level		= '" . (int) $level . "', " .
				"user_id	= '" . ($user_id ? (int) $user_id : 0 ) . "', " .
				"ip			= " . $this->db->q($this->get_user_ip()) . ", " .
				"message	= " . $this->db->q($message) . " ");
	}

	function get_categories($page_id, $type_id = null, $cache = true)
	{
		$_category = '';

		if ($categories	= $this->load_categories($page_id, $type_id, $cache = true))
		{
			foreach ($categories as $id => $category)
			{
				if ($id > 0)
				{
					$_category .= ', ';
				}

				$_category .= '<a href="' . $this->href('', '', 'category_id=' . $category['category_id']) . '" class="tag" rel="tag">' . htmlspecialchars($category['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</a>';
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
		$categories = [];

		if ($_categories = $this->db->load_all(
			"SELECT category_id, parent_id, category " .
			"FROM " . $this->db->table_prefix . "category " .
			"WHERE category_lang = " . $this->db->q($lang) . " " .
			"ORDER BY parent_id ASC, category ASC", $cache))
		{
			// process pages count (if have to)
			if ($root !== false)
			{
				if ($_counts = $this->db->load_all(
				"SELECT kp.category_id, COUNT(kp.object_id) AS n " .
				"FROM " . $this->db->table_prefix . "category k , " .
					$this->db->table_prefix . "category_assignment kp " .
					($root != ''
						? "INNER JOIN " . $this->db->table_prefix . "page p ON (kp.object_id = p.page_id) "
						: '' ) .
				"WHERE k.category_lang = " . $this->db->q($lang) . " " .
					"AND	kp.category_id		= k.category_id " .
					"AND	kp.object_type_id	= 1 " .
					($root != ''
						? "AND (p.tag = " . $this->db->q($root) . " OR p.tag LIKE " . $this->db->q($root . '/%') . " ) " .
						  "AND p.deleted <> '1' "
						: '') .
				"GROUP BY kp.category_id", true))
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
				$categories[$word['category_id']] = [
					'parent_id'	=> $word['parent_id'],
					'category'	=> $word['category'],
					'n'			=> (isset($counts[$word['category_id']]) ? $counts[$word['category_id']] : ''),
				];
			}

			foreach ($categories as $id => $word)
			{
				if (isset($categories[$word['parent_id']]))
				{
					$categories[$word['parent_id']]['child'][$id] = $word;
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

	function show_category_form($object_id, $type_id, $can_edit = false)
	{
		$selected = [];

		/////////////////////////////////////////////
		//   building list
		/////////////////////////////////////////////

		// load categories for the page's particular language
		$categories = $this->get_categories_list($this->page['page_lang'], false);

		// get currently selected category_ids
		$_selected = $this->db->load_all(
			"SELECT category_id " .
			"FROM " . $this->db->table_prefix . "category_assignment " .
			"WHERE object_id = '" . (int) $object_id . "' " .
				"AND object_type_id = '" . (int) $type_id ."'");

		// exploding categories into array
		foreach ($_selected as $key => &$val)
		{
			if (is_array($val))
			{
				$selected[$key] = $val['category_id'];
			}
		}

		// print categories list
		if (is_array($categories))
		{
			$i = '';

			$out = '<div class="category_set">' . "\n";
			$out .= '<ul class="ul_list hide_radio lined">' . "\n";

			foreach ($categories as $category_id => $word)
			{
				$out .= '<li><span class="">' . "\n\t";
				$out .= ($can_edit
						? '<input type="radio" id="category' . $category_id . '" name="change_id" value="' . $category_id . '" />'
						: '<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '|' . $word['parent_id'] . '" value="set"' . (is_array($selected) ? (in_array($category_id, $selected) ? ' checked' : '') : '') . ' /> ' . "\n\t") .
					'<label for="category' . $category_id . '"><strong>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</strong></label></span>' . "\n";

				if (isset($word['child']) && $word['child'] == true)
				{
					foreach ($word['child'] as $category_id => $word)
					{
						if ($i++ < 1)
						{
							$out .=  "\t<ul>\n";
						}

						$out .=  "\t\t" . '<li><span class="nobr">' . "\n\t\t\t" .
								($can_edit
									? '<input type="radio" id="category' . $category_id . '" name="change_id" value="' . $category_id . '" />' . "\n\t\t\t"
									: '<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '|' . $word['parent_id'] . '" value="set"' . (is_array($selected) ? (in_array($category_id, $selected) ? ' checked' : '') : '') . ' />' . "\n\t\t\t") .
								'<label for="category' . $category_id . '">' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</label></span>' . "\n\t\t" .
							'&nbsp;&nbsp;&nbsp;</li>' . "\n";
					}
				}

				if ($i > 0)
				{
					$out .=  "\t</ul>\n</li>\n";
				}
				else
				{
					$out .=  "</li>\n";
				}

				$i = 0;
			}

			$out .=  "</ul>\n";
			$out .=  '</div>' . "\n";

			/////////////////////////////////////////////
			//   control buttons
			/////////////////////////////////////////////

			if (!isset($_GET['edit']))
				$out .=  '<br /><br />' .
				'<input type="submit" id="submit" name="save" value="' . $this->_t('CategoriesStoreButton') . '" /> ' .
				'<a href="' . $this->href('') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '"/></a> ' .
				'<small><br />' . $this->_t('CategoriesStoreInfo') . '<br /><br /></small> ';
		}
		else
		{
			// availability depends on the page language and your access rights
			// additionally you need also the right to create new categories
			$out .=  $this->_t('NoCategoriesForThisLang') . '<br /><br /><br />';
			$out .=  '<a href="' . $this->href('') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a><br /><br /> ';
		}

		return $out;
	}

	// save categories selected in webform. ids are
	// passed through POST global array. returns:
	//	true	- if something was saved
	//	false	- if list was empty
	function save_categories_list($object_id, $type_id, $dryrun = 0)
	{
		$set	= '';
		$ids	= '';
		$values	= '';

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
				foreach ($set as $category_id)
				{
					$values[] = '(' . (int) $category_id . ', ' . (int) $object_id . ', ' . (int) $type_id . ')';
				}

				$this->db->sql_query(
					"INSERT INTO " . $this->db->table_prefix . "category_assignment (category_id, object_id, object_type_id) " .
					"VALUES " . implode(', ', $values));
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
		if (is_numeric($size))
		{
			if ($prefix === true)
			{
				// Decimal prefix
				if ($short === true)
				{
					$norm = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
				}
				else
				{
					$norm = ['Byte', 'Kilobyte', 'Megabyte', 'Gigabyte', 'Terabyte', 'Petabyte', 'Exabyte', 'Zettabyte', 'Yottabyte'];
				}

				$factor = 1000;
			}
			else
			{
				// Binary prefix
				if ($short === true)
				{
					$norm = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
				}
				else
				{
					$norm = ['Byte', 'Kibibyte', 'Mebibyte', 'Gibibyte', 'Tebibyte', 'Pebibyte', 'Exbibyte', 'Zebibyte', 'Yobibyte'];
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

			// TODO: $this->_t($norm[$x])
			if ($rounded === true)
			{
				$size = round($size, 0);
			}
			else
			{
				$size = sprintf('%01.2f', $size);
			}

			if ($suffix === true)
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

		if ($prefix === true)
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

	function delta_formatted($size_delta)
	{
		if ($size_delta > 0)
		{
			$diff_class = 'diff-pos';
			$size_delta = '+' . number_format($size_delta, 0, ',', '.');
		}
		else if ($size_delta < 0)
		{
			$diff_class = 'diff-neg';
			$size_delta = number_format($size_delta, 0, ',', '.');
		}
		else
		{
			$diff_class = 'diff-zero';
			$size_delta = '±' . $size_delta;
		}

		return '<span class="' . $diff_class . '">' . $size_delta . '</span>';
	}

	// to use by actions to add some inside <head> e.g. to adding custom css
	function add_html_head($text)
	{
		$this->html_head .= $text;
	}

	// HANDLER HELPERS
	function ensure_page($forums = false)
	{
		if (!($p = $this->page))
		{
			$this->show_must_go_on();
		}
		else if ($p['comment_on_id'])
		{
			// show main page for comment
			$this->http->redirect($this->href('', $this->get_page_tag($p['comment_on_id']), 'show_comments=1', false, $p['tag']));
		}
		else if ($this->forum && !$this->is_admin() && !$forums)
		{
			$this->show_must_go_on();
		}
	}

	function reload_me()
	{
		$this->http->redirect($this->href($this->method));
	}

	function show_must_go_on($param = [])
	{
		$this->http->redirect($this->href('', '', $param));
	}

	function login_page()
	{
		$this->http->redirect($this->href('', $this->_t('LoginPage'), Ut::random_token(4)));
	}

	function go_back($to)
	{
		if (($back = @$this->sess->sticky_goback))
		{
			$to = $back;
			unset($this->sess->sticky_goback);
		}
		$this->http->redirect($this->href('', $to, Ut::random_token(4)));
		// NEVER BEEN HERE
	}
}
