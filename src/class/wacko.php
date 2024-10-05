<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// engine class
class Wacko
{
	public const EXT = [
		'audio'			=> ['m4a', 'mka', 'mp3', 'ogg', 'opus'],
		'bitmap'		=> ['avif', 'gif', 'jpeg', 'jpe', 'jpg', 'jxl', 'png', 'webp'],
		'drawing'		=> ['svg'],
		'video'			=> ['av1', 'mkv', 'mp4', 'ogv', 'webm'],
	];
	public const PATTERN = [
		'USER_NAME'		=> '[\p{L}\p{Nd}\.\-]+',
		'USER_NAME_P'	=> '\p{L}\p{Nd}\.\-',

		'TAG'			=> '[\p{L}\p{M}\p{Nd}\.\-\/]',
		'TAG_P'			=> '\p{L}\p{M}\p{Nd}\.\-\/',

		'ACTION'		=> '\p{Latin}\d\_\-',
		'FORMATTER'		=> '\p{Latin}\d\_\-\/',

		'UPPER'			=> '[\p{Lu}]',
		'UPPERNUM'		=> '[\p{Lu}\p{Nd}]',
		'LOWER'			=> '[\p{Ll}\/]',
		'ALPHA'			=> '[\p{L}\_\-\/]',
		'ALPHANUM'		=> '[\p{L}\p{M}\p{Nd}\_\-\/]',
		'ALPHANUM_P'	=> '\p{L}\p{M}\p{Nd}\_\-\/',

		'AUDIO'			=> 'm4a|mka|mp3|ogg|opus',
		'BITMAP'		=> 'avif|gif|jp(?:eg|e|g)|jxl|png|svg|webp',
		'DRAWING'		=> 'svg',
		'VIDEO'			=> 'av1|mkv|mp4|ogv|webm',
	];

	private array $acl				= [];
	private array $acl_cache		= [];
	private array $file_cache		= [];
	private array $page_cache		= [];
	private int $parent_size;
	private array $rev_delta;
	private bool $format_safe		= true;		// for htmlspecialchars() in pre_link
	private array $search_engines	= ['aport', 'archiver', 'baidu', 'bing', 'bot', 'crawl', 'duckduckgo', 'google', 'rambler', 'search', 'slurp', 'spider', 'yandex'];

	public $charset;
	public $config;								// @deprecated, but will live for a looong time
	public $db;									// new config
	public $http;
	public $sess;
	public $prefix;								// alias for table prefix
	public $page;								// requested page
	public $tag;
	public $module;
	public $method					= '';

	public bool $forum				= false;
	public bool $canonical			= false;
	public bool $static_feed		= false;	// disables section edit link in post_wacko
	public $categories;
	public $watch					= [];
	public bool $is_watched			= false;
	public bool $hide_revisions		= false;
	public array $context			= [];		// page context, used for correct processing of inclusions
	public $current_context			= 0;		// current context level

	public $header_count			= 0;
	public $section_count			= 0;
	public $section_tag				= null;
	public $comment_id				= null;
	public bool $new_comment		= false;

	public string $page_meta		= 'page_id, owner_id, user_id, tag, created, modified, edit_note, minor_edit, latest, handler, comment_on_id, page_lang, title, keywords, description';
	public string $file_meta		= 'file_id, page_id, user_id, file_name, file_size, file_lang, file_description, caption, author, source, source_url, license_id, picture_w, picture_h, file_ext, mime_type';
	public array $first_inclusion	= [];		// for backlinks
	public array $toc_context		= [];
	public $body_toc				= null;

	public array $category_cache	= [];
	public array $owner_id_cache	= [];
	public array $page_id_cache		= [];
	public array $page_tag_cache	= [];
	public array $wanted_cache		= [];

	public $lang					= null;
	public $languages				= null;
	public $notify_lang				= null;		// sets language in _t() function for notifications
	public $page_lang				= null;
	public $resource				= null;
	public $translations			= null;
	public $user_lang				= null;
	public $user_lang_dir			= null;

	public $linktable				= null;
	public bool $linktracking		= false;
	public $noautolinks				= null;		// formatter
	public $numerate_links			= null;
	public $tocs					= null;
	public $post_wacko_action		= null;
	public $post_wacko_maxp			= null;
	public $post_wacko_toc			= null;
	public $post_wacko_toc_hash		= null;

	public array $html_addition			= [];
	public bool $hide_article_header	= false;
	public bool $no_way_back			= false;	// set to true to prevent saving page as the goback-after-login
	public array $paragrafica_styles	= [
		'before'	=> [
			'_before'	=> '',
			'_after'	=> '',
			'before'	=> '<span class="pmark">[##]</span><br>',
			'after'		=> ''],
		'after'		=> [
			'_before'	=> '',
			'_after'	=> '',
			'before'	=> '',
			'after'		=> '<span class="pmark">[##]</span>'],
		'right'		=> [
			'_before'	=> '<div class="pright"><div class="p-">' . NBSP . '<span class="pmark">[##]</span></div><div class="pbody-">',
			'_after'	=> '</div></div>',
			'before'	=> '',
			'after'		=> ''],
		'left'		=> [
			'_before'	=> '<div class="pleft"><div class="p-"><span class="pmark">[##]</span>' . NBSP . '</div><div class="pbody-">',
			'_after'	=> '</div></div>',
			'before'	=> '',
			'after'		=> ''],
	];
	public array $paragrafica_patches = [
		'before'	=> ['before'],
		'after'		=> ['after'],
		'right'		=> ['_before'],
		'left'		=> ['_before'],
	];
	public array $time_intervals = [
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
	* @return void
	*/
	function __construct(&$config, &$http)
	{
		$this->db		=
		$this->config	= & $config;
		$this->http		= & $http;
		$this->sess		= & $http->sess;

		$this->prefix	= $this->db->table_prefix;
	}

	// DATABASE

	// TODO: throw error for nested arrays
	function ids_string($ids): ?string
	{
		// sanitize array allow only integer values
		$ids_string = array_map('intval', $ids);

		// implode the array to be used in a SQL statement
		return implode(', ', $ids_string);
	}

	// MISC
	function get_page_tag($page_id = 0): ?string
	{
		if (!$page_id)
		{
			return null;
		}
		else
		{
			if (!isset($this->page_tag_cache[$page_id]))
			{
				$page = $this->db->load_single(
					'SELECT tag ' .
					'FROM ' . $this->prefix . 'page ' .
					'WHERE page_id = ' . (int) $page_id . ' ' .
					'LIMIT 1', true);

				$tag = $page['tag'] ?? null;

				// cache it
				$this->page_tag_cache[$page_id] = $page['tag'];
			}
			else
			{
				$tag = $this->page_tag_cache[$page_id];
			}

			return $tag;
		}
	}

	function get_page_id($tag = ''): ?int
	{
		if (!$tag)
		{
			return (int) $this->page['page_id'];
		}
		else
		{
			if (!isset($this->page_id_cache[$tag]))
			{
				$page = $this->db->load_single(
					'SELECT page_id ' .
					'FROM ' . $this->prefix . 'page ' .
					'WHERE tag = ' . $this->db->q($tag) . ' ' .
					'LIMIT 1');

				$page_id = $page['page_id'] ?? null;

				// cache it
				$this->page_id_cache[$tag] = $page_id;
			}
			else
			{
				$page_id = $this->page_id_cache[$tag];
			}

			return (int) $page_id;
		}
	}

	function get_page_depth($tag): int
	{
		if (!$tag)
		{
			return $this->page['depth'];
		}
		else
		{
			// determine the page depth
			$depth_array	= explode('/', $tag);

			return count($depth_array);
		}
	}

	function get_parent_id($tag = '')
	{
		if (!$tag)
		{
			return $this->page['parent_id'];
		}
		else
		{
			// determine the page_id of the parent page
			if (mb_strstr($tag, '/'))
			{
				$parent_tag	= preg_replace('/^(.*)\\/([^\\/]+)$/u', '$1', $tag);
				$parent_id	= $this->get_page_id($parent_tag);
			}
			else
			{
				$parent_id = 0;
			}

			return $parent_id;
		}
	}

	function get_wacko_version(): string
	{
		return WACKO_VERSION;
	}

	// FILE FUNCTIONS

	/**
	* Check if file with file name exists. Checks only DB entry,
	* not file in FS
	*
	* @param string		$file_name	File name
	* @param int		$page_id	Optional. If not set, then check if file exists in global space.
	* @param bool		$deleted
	*
	* @return array File description array
	*/
	function check_file_record(string $file_name, int $page_id = 0, $deleted = false)
	{
		$file = &$this->file_cache[$page_id][$file_name];

		if (empty($file))
		{
			$file = $this->db->load_single(
				'SELECT ' . $this->file_meta . ' ' .
				'FROM ' . $this->prefix . 'file ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
				'AND file_name = ' . $this->db->q($file_name) . ' ' .
					($deleted
						? ''
						: 'AND deleted <> 1 ') .
				'LIMIT 1');
		}

		if (empty($file))
		{
			return false;
		}
		else
		{
			return $file;
		}
	}

	static function get_file_extension(string $file_name)
	{
		if (!str_contains($file_name, '.'))
		{
			return '';
		}

		$file_name = explode('.', $file_name);

		return array_pop($file_name);
	}

	/**
	 * File extension check
	 *
	 * @param string $file_name		File name.
	 *
	 * @return bool
	 */
	function file_extension_check($file_name): bool
	{
		$allowed_list	= $this->db->upload_allowed_exts;
		$banned_list	= $this->db->upload_banned_exts;

		// get extension
		$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

		// check against disallowed files
		if (!Ut::is_blank($banned_list))
		{
			$banned_exts = $this->get_filetype_list($banned_list);

			foreach ($banned_exts as $extension)
			{
				if (0 == strcasecmp($extension, $file_extension))
				{
					return false;
				}
			}
		}

		// if the allowed list is not populated then the file must be allowed
		if (Ut::is_blank($allowed_list))
		{
			return true;
		}

		// check against allowed files
		$allowed_exts = $this->get_filetype_list($allowed_list);

		foreach ($allowed_exts as $extension)
		{
			if (0 == strcasecmp($extension, $file_extension))
			{
				return true;
			}
		}

		return false;
	}

	function get_filetype_list($filetyp_string)
	{
		return array_map(
			function($types) {
				return strtolower(trim($types));
			},
			explode(',', $filetyp_string));
	}

	function get_extensions_from_mime_type($mime): array
	{
		$mime	= strtolower($mime);
		$exts	= $this->http->mime_types();

		foreach($exts as $ext => $type)
		{
			if ($type == $mime)
			{
				$_exts[] = $ext;
			}
		}

		return $_exts ?? [];
	}

	/**
	 * Checks if the MIME type of the uploaded file matches the file extension.
	 *
	 * @param string $mime			The MIME type of the uploaded file
	 * @param string $extension		The filename extension that the file is to be served with
	 *
	 * @return bool
	 */
	function verify_extension($mime, $extension): ?bool
	{
		$exts = $this->get_extensions_from_mime_type($mime);

		if (!$exts)
		{
			return null; // unknown MIME type
		}

		return in_array(strtolower($extension), $exts);
	}

	/**
	 * Checks if the file type is part of MIME map.
	 *
	 * @param string $extension
	 *
	 * @return bool
	 */
	function validate_extension(string $extension): bool
	{
		$exts	= array_keys($this->http->mime_types());

		if (in_array($extension, $exts))
		{
			return true;
		}

		return false; // unknown file type
	}

	function get_max_upload_size()
	{
		return min(
			$this->db->upload_max_size,
			Ut::shorthand_to_int(ini_get('upload_max_filesize')),
			Ut::shorthand_to_int(ini_get('post_max_size'))
		);
	}

	function upload_quota($user_id = null)
	{
		// get used upload quota
		$files	= $this->db->load_single(
			'SELECT SUM(file_size) AS used_quota ' .
			'FROM ' . $this->prefix . 'file ' .
				($user_id
					? 'WHERE user_id = ' . (int) $user_id . ' '
					: '') .
			'LIMIT 1');

		return $files['used_quota'];
	}

	function available_themes(): array
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

	function validate_theme($theme): string
	{
		return in_array($theme, $this->available_themes()) ? $theme : $this->db->theme;
	}

	// TIME FUNCTIONS
	function utc2time($utc): int|false
	{
		// strtotime requires UTC for IntlDateFormatter
		$tz = date_default_timezone_get();
		date_default_timezone_set('UTC');

		$time = strtotime($utc);

		date_default_timezone_set($tz);

		return $time;
	}

	function sql2time($text): int
	{
		return $this->db->is_null_date($text)? 0 : (int) $this->utc2time($text);
	}

	function sql2datetime($text, &$date, &$time): void
	{
		$date	= $this->date_format($this->sql2time($text), $this->db->date_format);
		$time	= $this->date_format($this->sql2time($text), $this->db->time_format);
	}

	function sql2precisetime($text): string
	{
		return $this->date_format($this->sql2time($text), $this->db->date_format . ' ' . $this->db->time_format_seconds);
	}

	// TODO: make format pattern depended from localization and user preferences?
	function sql_time_format($text): string
	{
		return $this->date_format($this->sql2time($text), $this->db->date_format . ' ' . $this->db->time_format);
	}

	// unix time formatted (must be passed as UTC time)
	function date_format($unix_time, $pattern): string
	{
		$user	= $this->get_user();
		$tz		= $user['timezone'] ?? $this->db->timezone;

		$fmt = new IntlDateFormatter(
			$this->lang['locale'],
			IntlDateFormatter::FULL,
			IntlDateFormatter::FULL,
			$tz,
			null,
			$pattern
		);

		return $fmt->format($unix_time);
	}

	// e.g. <time datetime="2021-03-17T12:34:26+01:00" title="17 March 2021 12:34">3 hours ago</time>
	function get_time_interval($time, $strip = false): string
	{
		$ago = time() - $time;
		$out = 0 . $this->_t('MinutesAgo');

		foreach ($this->time_intervals as $val => $name)
		{
			if ($ago >= $val)
			{
				$interval	= ($ago - $ago % $val) / $val;
				$out		= Ut::perc_replace($this->_t($name . ($interval == 1 ? '' : 's') . 'Ago'), $interval);

				break;
			}
		}

		if ($strip)
		{
			// STS: hack! need to patch language files...
			$out = mb_substr($out, 0, mb_strrpos($out, ' '));
		}

		return $out;
	}

	function timezone_list(): array
	{
		static $timezones = null;

		if ($timezones === null)
		{
			$timezones	= [];
			$offsets	= [];
			$now		= new DateTime('now', new DateTimeZone('UTC'));

			foreach (DateTimeZone::listIdentifiers() as $timezone)
			{
				$now->setTimezone(new DateTimeZone($timezone));
				$offsets[]				= $offset = $now->getOffset();
				$timezones[$timezone]	= '[' . $this->format_UTC_offset($offset) . '] ' . $this->format_timezone_name($timezone);
			}

			array_multisort($offsets, $timezones);
		}

		return $timezones;
	}

	function format_UTC_offset($offset): string
	{
		$hours		= intval($offset / 3600);
		$minutes	= abs(intval($offset % 3600 / 60));

		return 'UTC ' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
	}

	function format_timezone_name($name)
	{
		return str_replace(
			['/',	'_',	'St '],
			[', ',	' ',	'St. '],
			$name);
	}

	function validate_timezone($timezone): string
	{
		return in_array($timezone, DateTimeZone::listIdentifiers()) ? $timezone : 'UTC';
	}

	// check and validate YYYY-MM-DD date
	function validate_date($date): bool
	{
		return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $date, $m)
			&& checkdate(intval($m[2]), intval($m[3]), intval($m[1]));
	}

	// converts a number to a locale-specific string
	function number_format($number, $precision = 0)
	{
		$lang	= $this->get_user()['user_lang'] ?? $this->db->language;
		$save	= $this->set_language($lang, true, true);

		$numfmt = new NumberFormatter($this->lang['locale'], NumberFormatter::DECIMAL);
		$numfmt->setAttribute(NumberFormatter::ROUNDING_MODE, 0);
		$numfmt->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $precision);
		$numfmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $precision);

		$this->set_language($save, true);

		return $numfmt->format($number);
	}

	// LANG FUNCTIONS
	function set_translation(string $lang): void
	{
		$this->resource = & $this->translations[$lang];
	}

	/**
	 * sets language $this->lang
	 *
	 * @param string	$lang
	 * @param bool		$set_translation
	 * @param bool		$get_translation	sets $this->notify_lang
	 * @param bool		$update				reload for theme per page lang files
	 *
	 * @return string	previous language for reset
	 */
	function set_language($lang, $set_translation = false, $get_translation = false, $update = false)
	{
		$old_lang	= $this->lang['LANG'] ?? null;

		if (($old_lang != $lang || $update) && $this->known_language($lang))
		{
			$this->load_translation($lang, $update);
			$this->lang = &$this->languages[$lang];

			setlocale(LC_CTYPE, $this->lang['locale']);
			setlocale(LC_TIME, $this->lang['locale']);	// sql_time_format()

			mb_internal_encoding('utf-8');
		}

		if ($set_translation)
		{
			$this->set_translation($this->lang['LANG']);
		}

		// substitutes $this->user_lang in _t() function
		$this->notify_lang = $get_translation ? $lang : null;

		return $old_lang;
	}

	/**
	 * loads translation files
	 *
	 * 1. lang/wacko.<lang>.php
	 * 2. lang/wacko.all.php
	 * 3. lang/custom.<lang>.php
	 * 4. admin/lang/ap.<lang>.php
	 * 5. theme/<theme>/lang/wacko.<lang>.php
	 * 6. theme/<theme>/lang/wacko.all.php
	 *
	 * @param string	$lang
	 * @param bool		$update
	 *
	 * @return void
	 */
	function load_translation(string $lang, bool $update = false): void
	{
		if ($lang && (!isset($this->translations[$lang]) || $update))
		{
			// 1. wacko.<lang>.php $wacko_translation[]
			$wacko_translation = [];
			$lang_file = Ut::join_path(LANG_DIR, 'wacko.' . $lang . '.php');

			if (@file_exists($lang_file))
			{
				include $lang_file;
			}

			// 2. wacko.all.php $wacko_all_resource[]
			if (!isset($this->translations['all']))
			{
				$wacko_all_resource = [];
				$lang_file = Ut::join_path(LANG_DIR, 'wacko.all.php');

				if (@file_exists($lang_file))
				{
					include $lang_file;
				}

				// stored in object required for merge with all language files,
				// but not with multi-languages off
				$this->translations['all'] = & $wacko_all_resource;
			}

			// 3. custom.<lang>.php $custom_translation[]
			$custom_translation = [];
			$lang_file = Ut::join_path(LANG_DIR, 'custom.' . $lang . '.php');

			if (@file_exists($lang_file))
			{
				include $lang_file;
			}

			$ap_translation		= [];
			$theme_translation	= [];
			$theme_translation0	= [];

			if ($this->db->ap_mode)
			{
				// 4. ap.<lang>.php $ap_translation[]
				$lang_file = 'admin/lang/ap.' . $lang . '.php';
			}
			else
			{
				// 5. theme lang files $theme_translation[]
				$lang_file = Ut::join_path(THEME_DIR, $this->db->theme, 'lang/wacko.' . $lang . '.php');

				if (@file_exists($lang_file))
				{
					include $lang_file;
				}

				$theme_translation0 = $theme_translation;

				// 6. wacko.all theme
				$theme_translation = [];
				$lang_file = Ut::join_path(THEME_DIR, $this->db->theme, 'lang/wacko.all.php');
			}

			if (@file_exists($lang_file))
			{
				include $lang_file;
			}

			$this->translations[$lang] = array_merge(
				$wacko_translation,
				$this->translations['all'],
				$custom_translation,
				$ap_translation,
				$theme_translation0,
				$theme_translation);

			$this->load_lang($lang);
		}
	}

	/**
	* Loads language scheme.
	*
	* @param string $lang Language code
	*/
	function load_lang($lang): void
	{
		if ($lang && !isset($this->languages[$lang]))
		{
			$scheme						= [];
			$scheme						= $this->translations[$lang]['lang_scheme'];
			$scheme['LANG']				= $lang;

			$this->languages[$lang]		= $scheme;
		}
	}

	function known_language($lang, $subset = true): bool
	{
		return array_key_exists($lang, $this->http->available_languages($subset));
	}

	function validate_language($lang, $subset = true): string
	{
		return $this->known_language($lang, $subset) ? $lang : $this->db->language;
	}

	function get_user_language()
	{
		$lang = $this->get_user_setting('user_lang');

		if (!$this->known_language($lang))
		{
			$lang = $this->http->user_agent_language();
		}

		return $lang;
	}

	/**
	 * Get translation of available message set
	 *
	 * @param string			$name	Name of message set
	 * @param string			$lang	Language code
	 *
	 * @return array|string|null		Message set
	 */
	function _t($name, $lang = '')
	{
		if ($this->db->multilanguage)
		{
			if ($lang === SYSTEM_LANG)
			{
				$lang = $this->db->language;
			}

			if ($this->notify_lang)
			{
				# Diag::dbg('GOLD', 'Message set:', $lang, $name, @$this->user_lang, @$this->page_lang, @$this->notify_lang);
				$lang = $this->notify_lang;
			}

			if (!$lang
				&& (isset($this->user_lang) && $this->user_lang != $this->page_lang))
			{
				$lang = $this->user_lang;
			}

			if ($lang)
			{
				$this->load_translation($lang);

				if ($text = @$this->translations[$lang][$name])
				{
					return $text;
				}
			}
		}

		if (isset($this->resource[$name]))
		{
			return $this->resource[$name];
		}

		// fall back to English
		if ($lang != 'en')
		{
			$save		= $this->set_language('en');

			if ($text = @$this->translations['en'][$name])
			{
				$this->set_language($save, true);

				return $text;
			}
		}

		// NB: must return NULL if no translation available, it's API
	}

	// wrapper for get and format message set translation
	function format_t($name, $lang = ''): string
	{
		$string				= $this->_t($name, $lang);
		$this->format_safe	= false;

		$string				= $this->format($string);
		$this->format_safe	= true;

		return $string;
	}

	function determine_lang(): string
	{
		if (@$this->method === 'edit' && @$_GET['add'] == 1)
		{
			$lang = $_REQUEST['lang'] ?? '';
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

	function set_page_lang($lang): bool
	{
		if (!$lang)
		{
			return false;
		}

		$this->page_lang = $lang;
		$this->set_language($lang);
		return true;
	}

	// utf-8 it is
	function get_charset(): string
	{
		return 'utf-8';
	}

	// shortcut for getting 'dir'
	static function get_direction($lang = ''): string
	{
		return in_array($lang, ['ar', 'fa', 'he', 'ur']) ? 'rtl' : 'ltr';
	}

	function get_favicon(): string
	{
		return $this->db->site_favicon
			? $this->db->base_path . Ut::join_path(IMAGE_DIR, $this->db->site_favicon)
			: $this->db->theme_url . 'icon/favicon.ico';
	}

	function get_xml_file($name): string
	{
		return
			$this->db->base_path . XML_DIR . '/' .
			$name . '_' . preg_replace('/[^a-zA-Z\d]/', '', mb_strtolower($this->db->site_name)) . '.xml';
	}

	// PAGE FUNCTIONS

	function get_keywords(): string
	{
		$meta_keywords = '';

		if (isset($this->page['keywords']))
		{
			$meta_keywords = $this->page['keywords'];
		}

		// add assigned categories
		if (isset($this->categories[OBJECT_PAGE]))
		{
			if (!empty($meta_keywords))
			{
				$meta_keywords .= ', ';
			}

			$meta_keywords .= mb_strtolower(implode(', ', $this->categories[OBJECT_PAGE]));
		}

		return $meta_keywords;
	}

	/**
	* Loads page-data from DB (wrapper)
	*
	* @param string		$tag			Page tag
	* @param int		$page_id
	* @param int		$revision_id
	* @param int		$cache			If LOAD_CACHE then tries to load page from cache, if LOAD_NOCACHE - then doesn't.
	* @param int		$metadata_only	If LOAD_ALL loads all page fields including page body, if LOAD_META - only page_meta fields.
	* @param bool		$deleted
	*
	* @return array|null				Loaded page
	*/
	function load_page($tag, $page_id = 0, $revision_id = null, $cache = LOAD_CACHE, $metadata_only = LOAD_ALL, $deleted = false): ?array
	{
		$page = [];

		if ($deleted)
		{
			$cache = false;
		}
		else if ($page_id)
		{
			if ($this->get_cached_wanted_page('', $page_id) == 1)
			{
				return null;
			}
		}
		else
		{
			if ($this->get_cached_wanted_page($tag) == 1)
			{
				return null;
			}
		}

		// 1. search for page_id (... is preferred, $tag next)
		if ($page_id)
		{
			$page = $this->_load_page('', $page_id, $revision_id, $cache, $metadata_only, $deleted);
		}

		// 2. if not found, search for tag
		if (!$page)
		{
			$page = $this->_load_page($tag, 0, $revision_id, $cache, $metadata_only, $deleted);
		}

		// 3. still nothing? file under wanted
		if (!$page)
		{
			($page_id
				? $this->cache_wanted_page('', $page_id)
				: $this->cache_wanted_page($tag)
			);
		}

		return $page;
	}

	function _load_page($tag, $page_id = 0, $revision_id = null, $cache = true, $metadata_only = false, $deleted = false): ?array
	{
		$cached_page	= [];
		$page			= [];

		if ($page_id == 0 && $tag == '')
		{
			return null;
		}

		// retrieve from cache
		if (!$revision_id && $cache && ($cached_page = $this->get_cached_page($tag, $page_id, $metadata_only)))
		{
			$page = $cached_page;
		}

		// load page
		if (!$page)
		{
			if ($metadata_only)
			{
				$what_p =	'p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.modified, p.version_id, ' .
							'p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.latest, p.handler, p.comment_on_id, ' .
							'p.page_lang, p.keywords, p.description, p.allow_rawhtml, p.disable_safehtml, p.typografica, p.noindex, p.deleted, ' .
							'u.user_name, o.user_name AS owner_name';
				$what_r =	'p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.modified, p.version_id, ' .
							'p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.latest, p.handler, p.comment_on_id, ' .
							'p.page_lang, p.keywords, p.description, s.allow_rawhtml, s.disable_safehtml, s.typografica, s.noindex, p.deleted, ' .
							'u.user_name, o.user_name AS owner_name';
			}
			else
			{
				$what_p =	'p.*, u.user_name, o.user_name AS owner_name';
				$what_r =	'p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.modified, p.version_id, ' .
							'p.body, p.body_r, p.formatting, p.edit_note, p.minor_edit, p.page_size, p.reviewed, p.reviewed_time, ' .
							'p.reviewer_id, p.ip, p.latest, p.deleted, p.handler, p.comment_on_id, p.page_lang, ' .
							'p.description, p.keywords, s.revisions , s.footer_comments, s.footer_files, s.hide_toc, ' .
							's.hide_index, s.tree_level, s.allow_rawhtml, s.disable_safehtml, s.typografica, s.noindex, s.theme, ' .
							'u.user_name, o.user_name AS owner_name';
			}

			if ($page_id || !preg_match('/[^' . self::PATTERN['TAG_P'] . ']/u', $tag))
			{
				$page = $this->db->load_single(
					'SELECT ' . $what_p . ' ' .
					'FROM ' . $this->prefix . 'page p ' .
					'LEFT JOIN ' . $this->prefix . 'user o ON (p.owner_id = o.user_id) ' .
					'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
					'WHERE ' .
						($page_id
							? 'page_id  = ' . (int) $page_id . ' '
							: 'tag = ' . $this->db->q($tag) . ' ') .
						($deleted
							? ''
							: 'AND p.deleted <> 1 ') .
					'LIMIT 1');

				$owner_id = $page['owner_id'] ?? 0;

				if ($revision_id)
				{
					$this->cache_page($page, $metadata_only);

					$page = $this->db->load_single(
						'SELECT p.revision_id, ' . $what_r . ' ' .
						'FROM ' . $this->prefix . 'revision p ' .
						'LEFT JOIN ' . $this->prefix . 'user o ON (p.owner_id = o.user_id) ' .
						'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
						'LEFT JOIN ' . $this->prefix . 'page s ON (p.page_id = s.page_id) ' .
						'WHERE ' .
							($page_id
								? 'p.page_id	= ' . (int) $page_id . ' '
								: 'p.tag		= ' . $this->db->q($tag) . ' ') .
							($deleted
								? ''
								: 'AND p.deleted <> 1 ') .
						'AND revision_id = ' . (int) $revision_id . ' ' .
						'LIMIT 1');

					$page['owner_id'] = $owner_id;
				}
			}
		}

		// cache result
		if (!empty($page) && !$revision_id && !$cached_page)
		{
			$this->cache_page($page, $metadata_only);
		}

		return $page;
	}

	/**
	* Get page from cache
	*
	* @param string		$tag			Page tag
	* @param int		$page_id
	* @param bool		$metadata_only	Returns only page with equal metadata_only marker. Default value is false.
	*
	* @return mixed		Page from cache or FALSE if not found
	*/
	function get_cached_page($tag, $page_id = 0, $metadata_only = false)
	{
		if ($page_id == 0)
		{
			$page_id = $this->page_id_cache[$tag] ?? 0;
		}

		if ($page_id)
		{
			if (isset($this->page_cache[$page_id]))
			{
				if (!$this->page_cache[$page_id]['mdonly']
					|| (isset($this->page_cache[$page_id]['mdonly']) && $this->page_cache[$page_id]['mdonly'] == $metadata_only))
				{
					return $this->page_cache[$page_id];
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
	* @param array	$page			Page data
	* @param bool	$metadata_only	Marks that page contains metadata only (all attributes, excepts page body)
	*/
	function cache_page($page, $metadata_only = false): void
	{
		// do not override current page
		if ((isset($this->page['page_id']) && isset($page['page_id'])
			&& $this->page['page_id'] == $page['page_id']
			&& $metadata_only)
			|| empty($page))
		{
			return;
		}

		// cache page
		$this->page_cache[$page['page_id']]				= $page;
		$this->page_cache[$page['page_id']]['mdonly']	= $metadata_only;

		// cache page_id to avoid roundtrips
		$this->page_id_cache[$page['tag']] = $page['page_id'];
	}

	function cache_wanted_page($tag, $page_id = 0, $check = false): void
	{
		if (!$check)
		{
			($page_id
				? $this->wanted_cache['page_id'][$page_id] = 1
				: $this->wanted_cache['tag'][$tag] = 1
			);

		}
		else if ($this->_load_page($tag, $page_id, null, LOAD_CACHE, LOAD_META) == '')
		{
			($page_id
				? $this->wanted_cache['page_id'][$page_id] = 1
				: $this->wanted_cache['tag'][$tag] = 1
			);
		}
	}

	/**
	* Clear Wanted cache from tag
	*
	* @param string		$tag
	* @param int		$page_id
	*/
	function clear_cache_wanted_page($tag, $page_id = 0): void
	{
		($page_id
			? $this->wanted_cache['page_id'][$page_id] = 0
			: $this->wanted_cache['tag'][$tag] = 0
		);
	}

	/**
	* Check if page is in cache
	*
	* @param string		$tag
	* @param int		$page_id
	*
	* @return bool		Return TRUE if tag in Wanted cache and FALSE if not
	*/
	function get_cached_wanted_page($tag, $page_id = 0)
	{
		if ($page_id)
		{
			return $this->wanted_cache['page_id'][$page_id] ?? '';
		}
		else
		{
			return $this->wanted_cache['tag'][$tag] ?? '';
		}
	}

	function preload_file_links($page_ids)
	{
		if (empty($page_ids))
		{
			return;
		}

		$file_ids		= [];
		$file_page_ids	= [];

		// get file links
		if ($links = $this->db->load_all(
			'SELECT file_id ' .
			'FROM ' . $this->prefix . 'file_link ' .
			'WHERE page_id IN (' . $this->ids_string($page_ids) . ')'))
		{
			foreach ($links as $link)
			{
				$file_ids[] = $link['file_id'];
			}
		}

		if (!empty($file_ids))
		{
			// get and cache file data
			if ($files = $this->db->load_all(
				'SELECT ' . $this->file_meta . ' ' .
				'FROM ' . $this->prefix . 'file ' .
				'WHERE file_id IN (' . $this->ids_string($file_ids) . ') ' .
				'AND deleted <> 1 '
				, true))
			{
				foreach ($files as $file)
				{
					$this->file_cache[$file['page_id']][$file['file_name']] = $file;

					if ($file['page_id'])
					{
						$file_page_ids[] = $file['page_id'];
					}
				}

				return $file_page_ids;
			}
		}
	}

	function preload_links($page_ids, $default = false): void
	{
		if (empty($page_ids) && !$default)
		{
			return;
		}

		$exists		= [];
		$pages		= [];
		$spages		= [];
		$p_ids		= [];
		$user		= $this->get_user();
		$lang		= $this->get_user_language();

		if (!empty($page_ids))
		{
			// cache file links
			if ($file_page_ids = $this->preload_file_links($page_ids))
			{
				$p_ids	= array_merge($page_ids, $file_page_ids);
			}
			else
			{
				$p_ids	= $page_ids;
			}

			// get page links
			if ($links = $this->db->load_all(
				'SELECT to_page_id, to_tag ' .
				'FROM ' . $this->prefix . 'page_link ' .
				'WHERE from_page_id IN (' . $this->ids_string($page_ids) . ')'))
			{
				foreach ($links as $link)
				{
					$p_ids[] = $link['to_page_id'];

					if(!$link['to_page_id'])
					{
						$pages[] = $link['to_tag'];
					}
				}
			}
		}

		if ($default)
		{
			// get menu links
			if ($menu_items = $this->db->load_all(
				'SELECT DISTINCT page_id ' .
				'FROM ' . $this->prefix . 'menu ' .
				'WHERE (user_id = ' . (int) $this->db->system_user_id . ' ' .
					($lang
						? 'AND menu_lang = ' . $this->db->q($lang) . ' '
						: '') .
				') ' .
					($user
						? 'OR (user_id = ' . (int) $user['user_id'] . ' ) '
						: '')
				, true))
			{
				foreach ($menu_items as $item)
				{
					$p_ids[] = $item['page_id'];
				}
			}

			// get default links
			// TODO: parse into link table, page_id we want
			if (isset($user['user_name']))
			{
				$pages[]	= $this->db->users_page . '/' . $user['user_name'];
				$pages[]	= $this->db->account_page;
			}
			else
			{
				$pages[]	= $this->db->registration_page;
			}

			$pages[]	= $this->db->category_page;
			$pages[]	= $this->db->help_page;
			$pages[]	= $this->db->privacy_page;
			$pages[]	= $this->db->root_page;
			$pages[]	= $this->db->users_page;
			$pages[]	= $this->db->terms_page;

			$pages[]	= $this->db->login_page;
			$pages[]	= $this->db->search_page;
			$pages[]	= $this->tag;

			$pages		= array_unique($pages);

			foreach ($pages as $page)
			{
				if ($page != '')
				{
					$spages[]		= $page;
					$q_spages[]		= $this->db->q($page);
				}
			}

			sort($q_spages);
		}

		$p_ids		= array_unique($p_ids);
		sort($p_ids);

		$_page_ids	= [];

		// cache page data
		if ($links = $this->db->load_all(
			'SELECT ' . $this->page_meta . ' ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE page_id IN (' . $this->ids_string($p_ids) . ') ' .
				($default
					? 'OR tag IN ( ' . implode(', ', $q_spages) . ' ) '
					: '')
			, true))
		{
			foreach ($links as $link)
			{
				$this->cache_page($link, true);
				$this->page_id_cache[$link['tag']]	= $link['page_id'];
				$exists[]							= $link['tag'];
				$_page_ids[]						= $link['page_id'];
			}
		}

		// check for wanted pages
		$notexists = @array_values(@array_diff($spages, $exists));

		foreach ((array) $notexists as $notexist)
		{
			if (isset($pages[array_search($notexist, $spages)]))
			{
				$this->cache_wanted_page($pages[array_search($notexist, $spages)], 0, true);
			}
		}

		// cache only read acl
		$this->preload_acl($_page_ids);

		// current page
		if (isset($this->page_id_cache[$this->tag]))
		{
			// cache all acls to avoid multiple queries to get non-read privileges
			$this->preload_acl([$this->page_id_cache[$this->tag]], null);
		}
	}

	function set_page($page): void
	{
		if (isset($page['deleted']) && $page['deleted'] && !$this->is_admin())
		{
			$page['body']			= '';
			$page['body_r']			= '';
			$page['title']			= '';
			$page['description']	= '';
			$page['keywords']		= '';
			$page['noindex']		= 1;
		}

		$this->page	= $page;

		if (isset($this->page['tag']))
		{
			$this->tag = $this->page['tag'];
		}

		$lang	= $_REQUEST['lang']	?? '';
		$add	= $_REQUEST['add']	?? null;

		if (isset($page['page_lang']) && $this->known_language($page['page_lang']))
		{
			$this->page_lang = $page['page_lang'];
		}
		else if ($add && $this->known_language($lang))
		{
			$this->page_lang = $lang;
		}
		else if ($add)
		{
			$this->page_lang = $this->user_lang;
		}
		else
		{
			$this->page_lang = $this->db->language;
		}
	}

	// STANDARD QUERIES
	function load_revisions($page_id, $minor_edit = true, $deleted = false, $limit = 100): array
	{
		$revisions	= [];
		$pagination	= [];

		$page_meta = 'p.page_id, p.version_id, p.owner_id, p.user_id, p.tag, p.modified, p.edit_note, p.minor_edit, ' .
					 'p.page_size, p.reviewed, p.latest, p.deleted, p.comment_on_id, p.title, u.user_name, o.user_name as reviewer ';

		$selector =
			'FROM ' . $this->prefix . 'revision p ' .
			'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
			'LEFT JOIN ' . $this->prefix . 'user o ON (p.reviewer_id = o.user_id) ' .
			'WHERE p.page_id = ' . (int) $page_id . ' ' .
				(!$minor_edit
					? 'AND p.minor_edit = 0 '
					: '') .
				($deleted
					? ''
					: 'AND p.deleted <> 1 ');

		// count pages
		$count_revisions = $this->db->load_single(
			'SELECT COUNT(p.revision_id) AS n ' .
			$selector
			);

		$pagination = $this->pagination($count_revisions['n'], $limit);

		$revisions = $this->db->load_all(
			'SELECT p.revision_id, ' . $page_meta . ' ' .
			$selector .
			'ORDER BY p.modified DESC ' .
			$pagination['limit'], true);

		if ($revisions && !$pagination['offset'])
		{
			if ($cur = $this->db->load_single(
				'SELECT 0 AS revision_id, ' . $page_meta . ' ' .
				'FROM ' . $this->prefix . 'page p ' .
				'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
				'LEFT JOIN ' . $this->prefix . 'user o ON (p.reviewer_id = o.user_id) ' .
				'WHERE p.page_id = ' . (int) $page_id . ' ' .
					(!$minor_edit
						? 'AND p.minor_edit = 0 '
						: '') .
					($deleted
						? ''
						: 'AND p.deleted <> 1 ') .
				'ORDER BY p.modified DESC ' .
				'LIMIT 1'))
			{
				array_unshift($revisions, $cur);
			}
		}
		else if (!$revisions)
		{
			$revisions = $this->db->load_all(
				'SELECT 0 AS revision_id, ' . $page_meta . ' ' .
				'FROM ' . $this->prefix . 'page p ' .
				'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
				'LEFT JOIN ' . $this->prefix . 'user o ON (p.reviewer_id = o.user_id) ' .
				'WHERE p.page_id = ' . (int) $page_id . ' ' .
					($deleted
						? ''
						: 'AND p.deleted <> 1 ') .
				'ORDER BY p.modified DESC ' .
				'LIMIT 1');
		}

		return [$revisions, $pagination];
	}

	function load_pages_linking($to_tag, $tag = '', $limit = 100)
	{
		$selector =
			'FROM ' . $this->prefix . 'page_link l ' .
			'INNER JOIN ' . $this->prefix . 'page p ON (p.page_id = l.from_page_id) ' .
			'WHERE ' . ($tag
				? 'p.tag LIKE ' . $this->db->q($tag . '/%') . ' AND '
				: '') .
			'(l.to_tag = ' . $this->db->q($to_tag) . ') ';

		// count pages
		$count_pages = $this->db->load_single(
			'SELECT COUNT(p.page_id) AS n ' .
			$selector
			);

		$pagination = $this->pagination($count_pages['n'], $limit);

		if ($pages = $this->db->load_all(
			'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang ' .
			$selector .
			'ORDER BY tag COLLATE utf8mb4_unicode_520_ci ' .
			$pagination['limit'], true))
		{
			return [$pages, $pagination];
		}
	}

	function load_page_links($to_tag, $tag = '', $limit = 100)
	{
		$selector =
			'FROM ' . $this->prefix . 'page_link l ' .
			'INNER JOIN ' . $this->prefix . 'page p ON (p.page_id = l.to_page_id) ' .
			'WHERE ' . ($tag
				? 'p.tag LIKE ' . $this->db->q($tag . '/%') . ' AND '
				: '') .
			'(l.from_page_id = ' . (int) $this->get_page_id($to_tag) . ') ';

		// count pages
		$count_pages = $this->db->load_single(
			'SELECT COUNT(p.page_id) AS n ' .
			$selector
			);

		$pagination = $this->pagination($count_pages['n'], $limit);

		if ($pages = $this->db->load_all(
			'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang ' .
			$selector .
			'ORDER BY tag COLLATE utf8mb4_unicode_520_ci ' .
			$pagination['limit'], true))
		{
			return [$pages, $pagination];
		}
	}

	/**
	* Loads all external links of this page from DB
	* @param int $page_id
	* @return array Array of (link, num)
	*/
	function load_external_links($page_ids = null): ?array
	{
		return $this->db->load_all(
			'SELECT ' .
			(!is_null($page_ids)
				? 'page_id, link, COUNT(link) AS num '
				: 'link, COUNT(link) AS num ') .
			'FROM ' . $this->prefix . 'external_link ' .
			(!is_null($page_ids)
				? 'WHERE page_id IN (' . $this->ids_string($page_ids) . ') '
				: '') .
			'GROUP BY ' .
				(!is_null($page_ids)
				? 'page_id, link '
				: 'link ') .
			'ORDER BY num DESC');
	}

	function load_file_links($file_id, $tag = '', $limit = 100, $params = [])
	{
		$selector =
			'FROM ' . $this->prefix . 'file_link l ' .
				'INNER JOIN ' . $this->prefix . 'page p ON (p.page_id = l.page_id) ' .
				'INNER JOIN ' . $this->prefix . 'file u ON (u.file_id = l.file_id) ' .
			'WHERE ' . ($tag
					? 'p.tag LIKE ' . $this->db->q($tag . '/%') . ' AND '
					: '') .
			'l.file_id = ' . (int) $file_id . ' ';

		// count pages
		$count_pages = $this->db->load_single(
			'SELECT COUNT(p.page_id) AS n ' .
			$selector
			);

		$pagination = $this->pagination($count_pages['n'], $limit, 'f', $params);

		if ($pages = $this->db->load_all(
			'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang ' .
			$selector .
			'ORDER BY tag COLLATE utf8mb4_unicode_520_ci ' .
			$pagination['limit'], true))
		{
			return [$pages, $pagination];
		}
	}

	function load_changed($limit = 100, $tag = '', $from = '', $minor_edit = true, $default_pages = false, $deleted = false)
	{
		$pages		= [];
		$pagination	= [];

		$selector =
			'FROM ' . $this->prefix . 'page p ' .
				'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
				'LEFT JOIN ' . $this->prefix . 'revision r1 ON (p.page_id = r1.page_id) ' .
				'LEFT JOIN ' . $this->prefix . 'revision r2 ON (p.page_id = r2.page_id AND r1.revision_id < r2.revision_id) ' .
			'WHERE p.comment_on_id = 0 ' .
				($from
					? 'AND p.modified <= ' . $this->db->q($from . ' 23:59:59') . ' '
					: '') .
				($tag
					? 'AND p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') .
				(!$minor_edit
					? 'AND p.minor_edit = 0 '
					: '') .
				($deleted
					? ''
					: 'AND p.deleted <> 1 ') .
				($default_pages
					? ''
					: 'AND (u.account_type = 0 OR p.user_id = 0) ') .
			'AND r2.revision_id IS NULL ';

		// count pages
		$count_pages = $this->db->load_single(
			'SELECT COUNT(p.page_id) AS n ' .
			$selector
			);

		$pagination = $this->pagination($count_pages['n'], $limit);

		if ($pages = $this->db->load_all(
		'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.modified, p.edit_note, p.minor_edit,
				p.reviewed, p.latest, p.handler, p.comment_on_id, p.page_lang, p.page_size, r1.page_size as parent_size, r1.revision_id, u.user_name ' .
		$selector .
		'ORDER BY p.modified DESC ' .
		$pagination['limit'], true))
		{
			foreach ($pages as $page)
			{
				$this->cache_page($page, true);
				$page_ids[]	= $page['page_id'];
			}

			$this->preload_acl($page_ids);

			return [$pages, $pagination];
		}
	}

	// used for comment feed
	function load_comment(int $limit = 100, $tag = '', $deleted = false): ?array
	{
		$pages	= [];
		$limit	= $this->get_list_count($limit);

		if ($pages = $this->db->load_all(
		'SELECT c.page_id, c.owner_id, c.tag, c.title, c.created, c.modified, c.edit_note, c.minor_edit, c.latest,
				c.handler, c.comment_on_id, c.page_lang, c.body, c.body_r, u.user_name, p.title AS page_title, p.tag AS page_tag ' .
		'FROM ' . $this->prefix . 'page c ' .
			'LEFT JOIN ' . $this->prefix . 'user u ON (c.user_id = u.user_id) ' .
			'LEFT JOIN ' . $this->prefix . 'page p ON (c.comment_on_id = p.page_id) ' .
		'WHERE c.comment_on_id <> 0 ' .
			($tag
				? 'AND p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
				: '') .
			($deleted
				? ''
				: 'AND p.deleted <> 1 AND c.deleted <> 1 ') .
		'ORDER BY c.created DESC ' .
		'LIMIT ' . $limit))
		{
			foreach ($pages as $page)
			{
				$this->cache_page($page, true);
				$page_ids[]	= $page['comment_on_id'];
			}

			$this->preload_acl($page_ids);
		}

		return $pages;
	}

	function load_deleted_files($limit = 50, $cache = true): array
	{
		$deleted	= [];
		$pagination	= [];

		$count_deleted = $this->db->load_single(
			'SELECT COUNT(file_id) AS n ' .
			'FROM ' . $this->prefix . 'file ' .
			'WHERE deleted = 1 LIMIT 1'
			, $cache);

		if ($count_deleted['n'])
		{
			$pagination = $this->pagination($count_deleted['n'], $limit);

			$deleted = $this->db->load_all(
				'SELECT f.file_id, f.page_id, f.user_id, f.file_name, f.created, f.modified, f.file_description,
						f.file_lang, f.caption, u.user_name ' .
				'FROM ' . $this->prefix . 'file f ' .
					'LEFT JOIN ' . $this->prefix . 'user u ON (f.user_id = u.user_id) ' .
				'WHERE f.deleted = 1 ' .
				'ORDER BY f.modified DESC, f.file_name ASC ' .
				$pagination['limit'], $cache);
		}

		return [$deleted, $pagination];
	}

	function load_deleted_pages($limit = 50, $cache = true): array
	{
		$deleted	= [];
		$pagination	= [];

		$count_deleted = $this->db->load_single(
			'SELECT COUNT(page_id) AS n ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE deleted = 1 LIMIT 1'
			, $cache);

		if ($count_deleted['n'])
		{
			$pagination = $this->pagination($count_deleted['n'], $limit);

			$deleted = $this->db->load_all(
				'SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.created, p.modified, p.edit_note,
						p.minor_edit, p.latest, p.handler, p.comment_on_id, p.page_lang, p.title, p.keywords,
						p.description, u.user_name ' .
				'FROM ' . $this->prefix . 'page p ' .
					'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
				'WHERE p.deleted = 1 ' .
				'ORDER BY p.modified DESC, p.tag ASC ' .
				$pagination['limit'], $cache);
		}

		return [$deleted, $pagination];
	}

	function load_deleted_revisions($limit = 50, $cache = true): array
	{
		$deleted	= [];
		$pagination	= [];

		$count_deleted = $this->db->load_single(
			"SELECT COUNT(revision_id) AS n " .
			"FROM " . $this->prefix . "revision " .
			"WHERE deleted = 1 LIMIT 1"
			, $cache);

		if ($count_deleted['n'])
		{
			$pagination = $this->pagination($count_deleted['n'], $limit);

			$deleted = $this->db->load_all(
				'SELECT r.revision_id, r.page_id, r.version_id, r.owner_id, r.user_id, r.tag, r.created, r.modified, r.edit_note,
						r.minor_edit, r.latest, r.handler, r.comment_on_id, r.page_lang, r.title, r.keywords,
						r.description, u.user_name ' .
				'FROM ' . $this->prefix . 'revision r ' .
					'LEFT JOIN ' . $this->prefix . 'user u ON (r.user_id = u.user_id) ' .
				'WHERE r.deleted = 1 ' .
				'ORDER BY r.modified DESC, r.tag ASC ' .
				$pagination['limit'], $cache);
		}

		return [$deleted, $pagination];
	}

	function load_categories($object_id = 0, $type_id = OBJECT_PAGE, $cache = false): array
	{
		return $this->category_cache[$object_id][$type_id] ?? $this->db->load_all(
			'SELECT c.category_id, c.category, c.category_lang ' .
			'FROM ' . $this->prefix . 'category c ' .
				'INNER JOIN ' . $this->prefix . 'category_assignment ca ON (c.category_id = ca.category_id) ' .
			'WHERE ca.object_id  = ' . (int) $object_id . ' ' .
			($type_id
				? 'AND ca.object_type_id = ' . (int) $type_id . ' '
				: 'AND ca.object_type_id = ' . (int) $type_id . ' ') // TODO: explode array IN
			, $cache);
	}

	/**
	 * loads related categories at once in obj-cache
	 *
	 * @param array	$object_ids
	 * @param int	$type_id
	 * @param bool	$cache
	 */
	function preload_categories($object_ids, $type_id = OBJECT_PAGE, $cache = true): void
	{
		if (empty($object_ids))
		{
			return;
		}

		$cache_ids = [];
		sort($object_ids);

		if ($categories = $this->db->load_all(
			'SELECT ca.object_id, ca.object_type_id, c.category_id, c.category, c.category_lang ' .
			'FROM ' . $this->prefix . 'category c ' .
				'INNER JOIN ' . $this->prefix . 'category_assignment ca ON (c.category_id = ca.category_id) ' .
			'WHERE ca.object_id IN (' . $this->ids_string($object_ids) . ') ' .
			($type_id
				? 'AND ca.object_type_id = ' . (int) $type_id . ' '
				: 'AND ca.object_type_id = ' . (int) $type_id . ' ') // TODO: explode array IN
			, $cache))
		{
			foreach ($categories as $category)
			{
				$cache_ids[] = $category['object_id'];
				$this->category_cache[$category['object_id']][$category['object_type_id']][] = $category;
			}
		}

		$empty_results = array_diff($object_ids, $cache_ids);

		foreach ($empty_results as $category_id)
		{
			// also add empty results
			$this->category_cache[$category_id][$type_id] = [];
		}
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
			if ($spam = file(Ut::join_path(CONFIG_DIR, 'antispam.conf')))
			{
				foreach ($spam as $one)
				{
					if (mb_stripos($text, trim($one)) !== false)
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
	 * @param int		$minor_edit		minor edit
	 * @param int		$reviewed
	 * @param int		$comment_on_id	commented page_id
	 * @param int		$parent_id		page_id of related comment or parent page
	 * @param string	$lang			page language
	 * @param bool		$mute			suppress email reminders and xml rss recompilation
	 * @param string	$user_name		attach guest pseudonym
	 * @param bool		$user_page		user is page owner
	 *
	 * @return string|null				body_r - pre-rendered wikitext
	 */
	function save_page($tag, $body, $title = '', $edit_note = '', $minor_edit = false, $reviewed = 0, $comment_on_id = 0, $parent_id = 0, $lang = '', $mute = false, $user_name = '', $user_page = false): ?string
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
			$registered	= true;
		}
		// current user is owner; if user is logged in! otherwise, no owner.
		else if ($this->get_user_name())
		{
			$user_name	= $this->get_user_name();
			$owner_id	= $user_id	= $this->get_user_id();
			$registered	= true;
		}
		else if ($this->forum || $comment_on_id)
		{
			$owner_id	= $user_id	= 0; // GUEST
			$registered	= false;
		}
		else
		{
			$owner_id	= $user_id	= 0;
			$registered	= false;
		}

		$page_id = $this->get_page_id($tag);

		if (!$tag)
		{
			return null;
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
				$this->http->invalidate_page($this->tag);
			}

			$this->db->invalidate_sql_cache();
		}

		// check privileges
		if ( ($this->page && $this->has_access('write', $page_id))
			|| (!$this->page && $this->has_access('create', '', $user_name, '', $tag))
			|| ($comment_on_id && $this->has_access('comment', $comment_on_id))
			|| $user_page)
		{
			// for forum topic prepare description
			if (!$comment_on_id && $this->forum)
			{
				$desc = $this->format(mb_substr($body, 0, 500), 'cleanwacko');
				$desc = (mb_strlen($desc) > 240 ? mb_substr($desc, 0, 240) . '[...]' : $desc);
			}

			// PreFormatter (macros and such)
			$body			= $this->format($body, 'pre_wacko');

			// making page body components
			$paragrafica	= !$comment_on_id;
			$body_r			= $this->compile_body($body, $page_id, $paragrafica);
			$body_toc		= $this->body_toc ?? null;

			$title			= $this->sanitize_text_field($title, true);
			$edit_note		= $this->sanitize_text_field($edit_note, true);

			// review
			if (isset($reviewed))
			{
				$reviewer_id	= $user_id;
			}

			// PAGE DOESN'T EXISTS, SAVING A NEW PAGE
			if (!($old_page = $this->load_page('', $page_id, null, null, null, true)))
			{
				if (empty($lang))
				{
					$lang = $_REQUEST['lang'] ?? '';

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

				if ($comment_on_id)
				{
					$depth = 1;
				}
				else
				{
					// determine the page depth
					$depth = $this->get_page_depth($tag);

					// determine the page_id of the parent page
					$parent_id	= $this->get_parent_id($tag);
				}

				$this->db->sql_query(
					'INSERT INTO ' . $this->prefix . 'page SET ' .
						'version_id		= 1, ' .
						'comment_on_id	= ' . (int) $comment_on_id . ', ' .
						(!$comment_on_id
							? 'description = ' . $this->db->q($desc) . ', '
							: '') .
						'parent_id		= ' . (int) $parent_id . ', ' .
						'created		= UTC_TIMESTAMP(), ' .
						'modified		= UTC_TIMESTAMP(), ' .
						(!$comment_on_id
							? 'commented		= UTC_TIMESTAMP(), '
							: '') .
						'depth			= ' . (int) $depth . ', ' .
						'owner_id		= ' . (int) $owner_id . ', ' .
						'user_id		= ' . (int) $user_id . ', ' .
						'title			= ' . $this->db->q($title) . ', ' .
						'tag			= ' . $this->db->q($tag) . ', ' .
						'body			= ' . $this->db->q($body) . ', ' .
						'body_r			= ' . $this->db->q($body_r) . ', ' .
						'body_toc		= ' . $this->db->q($body_toc) . ', ' .
						'edit_note		= ' . $this->db->q($edit_note) . ', ' .
						'minor_edit		= ' . (int) $minor_edit . ', ' .
						'page_size		= ' . (int) strlen($body) . ', ' .
						($reviewed
							?	'reviewed		= ' . (int) $reviewed . ', ' .
								'reviewed_time	= UTC_TIMESTAMP(), ' .
								'reviewer_id	= ' . (int) $reviewer_id . ', '
							:	'') .
						'latest			= 1, ' . // 1 - new page
						'ip				= ' . $this->db->q($ip) . ', ' .
						'page_lang		= ' . $this->db->q($lang) . ' ');

				// IMPORTANT! lookup newly created page_id
				$page_id = $this->get_page_id($tag);

				// create appropriate acls
				$acl = $this->get_acl_defaults($user_name, $comment_on_id);

				// saving acls
				$this->save_acl($page_id, 'read',		$acl['read']);
				$this->save_acl($page_id, 'write',		$acl['write']);
				$this->save_acl($page_id, 'comment',	$acl['comment']);
				$this->save_acl($page_id, 'create',		$acl['create']);
				$this->save_acl($page_id, 'upload',		$acl['upload']);

				// log event
				if (!$comment_on_id)
				{
					// added new page
					$this->log(4, Ut::perc_replace($this->_t('LogPageCreated', SYSTEM_LANG), $tag . ' ' . $title));
				}

				// counters
				if ($comment_on_id)
				{
					$this->update_comments_count($comment_on_id, $owner_id);
				}
				else
				{
					$this->update_pages_count($owner_id);
				}

				// set watch
				if ($this->db->autosubscribe && !$comment_on_id)
				{
					// subscribe the author
					if ($registered === true)
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
					$this->notify_watcher($page_id, $comment_on_id, $tag, $title, $body, $user_id, $user_name, $minor_edit);
				}
			} // end of new page
			else
			{
				// RESAVING AN OLD PAGE, CREATING REVISION
				$this->set_language($this->page_lang);

				// getting title
				if ($title == '')
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

				// Aha! Page isn't new, keep owner!
				$owner_id = $old_page['owner_id'];

				// only if page has been actually changed
				if ($old_page['body'] != $body || $old_page['title'] != $title)
				{
					// Don't save revisions for comments. Personally I think we should.
					if (!$old_page['comment_on_id'])
					{
						$this->save_revision($old_page);
					}

					// update current page copy
					$this->db->sql_query(
						'UPDATE ' . $this->prefix . 'page SET ' .
							'version_id		= ' . (int)($old_page['version_id'] + 1) . ', ' .
							'comment_on_id	= ' . (int) $comment_on_id . ', ' .
							'modified		= UTC_TIMESTAMP(), ' .
							'owner_id		= ' . (int) $owner_id . ', ' .
							'user_id		= ' . (int) $user_id . ', ' .
							'title			= ' . $this->db->q($title) . ', ' .
							'description	= ' . $this->db->q(($old_page['comment_on_id'] || $old_page['description'] ? $old_page['description'] : $desc)) . ', ' .
							'body			= ' . $this->db->q($body) . ', ' .
							'body_r			= ' . $this->db->q($body_r) . ', ' .
							'body_toc		= ' . $this->db->q($body_toc) . ', ' .
							'edit_note		= ' . $this->db->q($edit_note) . ', ' .
							'minor_edit		= ' . (int) $minor_edit . ', ' .
							'page_size		= ' . (int) strlen($body) . ', ' .
							(isset($reviewed)
								?	'reviewed		= ' . (int) $reviewed . ', ' .
									'reviewed_time	= UTC_TIMESTAMP(), ' .
									'reviewer_id	= ' . (int) $reviewer_id . ', '
								:	'') .
							'latest			= 2 ' . // 2 - modified page
						'WHERE page_id = ' . (int) $page_id . ' ' .
						'LIMIT 1');

					// log event
					if ($this->page['comment_on_id'])
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
						$this->notify_watcher($page_id, $comment_on_id, $tag, $title, null, $user_id, $user_name, $minor_edit);
					}
				} // end of new != old
			} // end of existing page
		}
		else
		{
			$this->log(2, Ut::perc_replace($this->_t('LogSaveNoRights', SYSTEM_LANG), $tag . ' ' . $title));
		}

		// writing xmls
		$this->write_feeds($mute, $comment_on_id);

		return $body_r;
	}

	// create revision of a given page
	function save_revision(array $page): void
	{
		// move revision
		$this->db->sql_query(
			'INSERT INTO ' . $this->prefix . 'revision SET ' .
				'page_id		= ' . (int) $page['page_id'] . ', ' .
				'version_id		= ' . (int) $page['version_id'] . ', ' .
				'owner_id		= ' . (int) $page['owner_id'] . ', ' .
				'user_id		= ' . (int) $page['user_id'] . ', ' .
				'title			= ' . $this->db->q($page['title']) . ', ' .
				'tag			= ' . $this->db->q($page['tag']) . ', ' .
				# "created		= " . $this->db->q($page['created']) . ", " .
				'modified		= ' . $this->db->q($page['modified']) . ', ' .
				'body			= ' . $this->db->q($page['body']) . ', ' .
				"body_r			= '', ". // specify value for columns that don't have defaults
				'formatting		= ' . $this->db->q($page['formatting']) . ', ' .
				'edit_note		= ' . $this->db->q($page['edit_note']) . ', ' .
				'minor_edit		= ' . (int) $page['minor_edit'] . ', ' .
				'page_size		= ' . (int) $page['page_size'] . ', ' .
				($page['reviewed_time']
					?	'reviewed		= ' . (int) $page['reviewed'] . ', ' .
						'reviewed_time	= ' . $this->db->q($page['reviewed_time']) . ', ' .
						'reviewer_id	= ' . (int) $page['reviewer_id'] . ', '
					:	'') .
				'latest			= 0, ' . // 0 - old page
				'ip				= ' . $this->db->q($page['ip']) . ', ' .
				'handler		= ' . $this->db->q($page['handler']) . ', ' .
				'comment_on_id	= ' . (int) $page['comment_on_id'] . ', ' .
				'page_lang		= ' . $this->db->q($page['page_lang']) . ', ' .
				'keywords		= ' . $this->db->q($page['keywords']) . ', ' .
				'description	= ' . $this->db->q($page['description']));

		// update user statistics for revisions made
		$user = $this->get_user();
		$this->update_revisions_count($page['page_id'], $user['user_id'] ?? null);
	}

	/**
	 * Write feeds and update sitemap
	 *
	 * @param bool	$mute
	 * @param int	$comment_on_id
	 *
	 * @return void
	 */
	function write_feeds(bool $mute, int $comment_on_id): void
	{
		if (!$mute)
		{
			if ($this->db->enable_feeds)
			{
				$xml = new Feed($this);

				// comment it is
				if ($comment_on_id)
				{
					$xml->comments();
				}
				else
				{
					$xml->changes();

					// write news feed
					if ($this->db->news_cluster)
					{
						if (mb_substr($this->tag, 0, mb_strlen($this->db->news_cluster . '/')) == $this->db->news_cluster . '/')
						{
							$xml->feed();
						}
					}
				}

				$this->update_sitemap();
			}
		}
	}

	function update_sitemap(): void
	{
		$this->sess->xml_sitemap_update = 1;
	}

	function write_sitemap(): void
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
			$this->log(7, $this->_t('LogXmlSitemapGenerated', SYSTEM_LANG));
			$this->sess->xml_sitemap_update = 0;
		}
	}

	// COUNTER
	// recount all comments for a given page
	function count_comments($page_id, $user_id = null, $deleted = false): int
	{
		$count = $this->db->load_single(
			'SELECT COUNT(page_id) AS n ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE comment_on_id <> 0 ' . // dummy for AND
				($page_id
					? 'AND comment_on_id = ' . (int) $page_id . ' '
					: '') .
				($user_id
					? 'AND owner_id = ' . (int) $user_id . ' '
					: '') .
				($deleted
					? ''
					: 'AND deleted <> 1 ') .
			'LIMIT 1');

		return $count? $count['n'] : 0;
	}

	function count_files($page_id = null, $user_id = null, $deleted = false): int
	{
		$count = $this->db->load_single(
			'SELECT COUNT(file_id) AS n ' .
			'FROM ' . $this->prefix . 'file ' .
			'WHERE 1=1 ' . // dummy for AND
				($page_id
					? 'AND page_id = ' . (int) $page_id . ' '
					: '') .
				($user_id
					? 'AND user_id = ' . (int) $user_id . ' '
					: '') .
				($deleted
					? ''
					: 'AND deleted <> 1 ') .
			'LIMIT 1');

		return $count? $count['n'] : 0;
	}

	function count_pages($user_id = null, $deleted = false): int
	{
		$count = $this->db->load_single(
			'SELECT COUNT(page_id) AS n ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE comment_on_id = 0 ' .
				($user_id
					? 'AND owner_id = ' . (int) $user_id . ' '
					: '') .
				($deleted
					? ''
					: 'AND deleted <> 1 ') .
			'LIMIT 1');

		return $count? $count['n'] : 0;
	}

	function count_revisions($page_id = null, $user_id = null, $minor_edit = true, $deleted = false): int
	{
		$count = $this->db->load_single(
			'SELECT COUNT(revision_id) AS n ' .
			'FROM ' . $this->prefix . 'revision ' .
			'WHERE page_id <> 0 ' . // dummy for AND
				($page_id
					? 'AND page_id = ' . (int) $page_id . ' '
					: '') .
				($user_id
					? 'AND user_id = ' . (int) $user_id . ' '
					: '') .
				(!$minor_edit
					? 'AND minor_edit = 0 '
					: '') .
				($deleted
					? ''
					: 'AND deleted <> 1 ') .
			'LIMIT 1');

		return $count? $count['n'] : 0;
	}

	// COUNTER CACHES
	function update_comments_count($page_id, $user_id, $last_created = false): void
	{
		if ($last_created)
		{
			// load latest comment
			$comment = $this->db->load_single(
				'SELECT created ' .
				'FROM ' . $this->prefix . 'page ' .
				'WHERE comment_on_id = ' . (int) $page_id . ' ' .
					'AND deleted <> 1 ' .
				'ORDER BY created DESC ' .
				'LIMIT 1');
		}

		// update comments count and date on commented page
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'comments	= ' . (int) $this->count_comments($page_id) . ', ' .
				'commented	= ' . ($last_created
									? (isset($comment['created'])
											? $this->db->q($comment['created'])
											: 'NULL')
									: 'UTC_TIMESTAMP()') . ' ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
			'LIMIT 1');

		// update user comments count
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'total_comments = ' . (int) $this->count_comments(null, $user_id) . ' ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');
	}

	function update_files_count($page_id, $user_id): void
	{
		// per page upload
		if ($page_id)
		{
			// update page uploads count
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'page SET ' .
					'files = ' . (int) $this->count_files($page_id) . ' ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
				'LIMIT 1');
		}

		// update user uploads count
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'total_uploads = ' . (int) $this->count_files(null, $user_id) . ' ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');
	}

	function update_pages_count($user_id): void
	{
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'total_pages = ' . (int) $this->count_pages($user_id) . ' ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');
	}

	function update_revisions_count($page_id, $user_id = null): void
	{
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'revisions = ' . (int) $this->count_revisions($page_id) . ' ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
			'LIMIT 1');

		if ($user_id)
		{
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'user SET ' .
					'total_revisions = ' . (int) $this->count_revisions(null, $user_id) . ' ' .
				'WHERE user_id = ' . (int) $user_id . ' ' .
				'LIMIT 1');
		}
	}

	function add_user_page($user_name, $user_lang = null, $mute = true): void
	{
		$user_lang			??= $this->db->language;

		$tag				= $this->db->users_page . '/' . $user_name;
		// add your user page template here
		$user_page_template	= '**((user:' . $user_name . ' ' . $user_name . '))** (' . $this->format('::+::', 'pre_wacko') . ')';
		$change_summary		= $this->_t('NewUserAccount');

		// add user page
		if (!$this->load_page($tag, 0, null, LOAD_CACHE, LOAD_META))
		{
			// profile title = user_name
			$this->save_page($tag, $user_page_template, $user_name, $change_summary, false, 0, 0, 0, $user_lang, $mute, $user_name, true);
		}
	}

	function set_account_status($user_id, $account_status): void
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
			'UPDATE ' . $this->prefix . 'user SET ' .
				'enabled		= ' . (int) $enabled . ', ' .
				'account_status	= ' . (int) $account_status . ' ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');
	}

	function approve_user($user, $account_status): void
	{
		$this->set_account_status($user['user_id'], $account_status);

		if ($account_status === false)
		{
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
	function send_user_email($user, $subject, $body, $xtra_headers = []): void
	{
		if ($user === 'System')
		{
			$user = [
				'user_name'		=> $this->db->admin_name,
				'email'			=> $this->db->admin_email,
				'user_lang'		=> $this->db->language
			];
		}

		$save		= $this->set_language($user['user_lang'], true, true);

		$email_to	= $user['email'];
		$name_to	= $user['user_name'];
		$prefix		= '[' . ($this->db->email_subject_prefix ?: $this->db->site_name) . '] ';

		$subject	= $prefix . $subject;
		$body		= $this->_t('EmailHello') . $user['user_name'] . ",\n\n" .

					Ut::amp_decode($body) . "\n\n" .

					$this->_t('EmailDoNotReply') . "\n\n" .
					$this->db->site_name . "\n" .
					$this->db->base_url;

		$this->set_language($save, true);

		$email = new Email($this);
		$email->send_mail($email_to, $name_to, $subject, $body, null, $xtra_headers);
	}

	function notify_approved_account($user): void
	{
		$save		= $this->set_language($user['user_lang'], true, true);

		$subject	=	$this->_t('RegistrationApproved');
		$body		=	Ut::perc_replace($this->_t('UserApprovedInfo'), $this->db->site_name) . "\n\n" .
						$this->_t('EmailRegisteredLogin') . "\n\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	function notify_new_account($user): void
	{
		$lang_admin	= $this->db->language;
		$save		= $this->set_language($lang_admin, true, true);

		$subject	=	$this->_t('NewAccountSubject');
		$body		=	$this->_t('NewAccountSignupInfo') . "\n\n" .
						$this->_t('NewAccountUsername') . ' ' .	$user['user_name'] . "\n" .
						$this->_t('AccountLanguage') . ' ' .	$user['user_lang'] . "\n" .
						$this->_t('NewAccountEmail') . ' ' .	$user['email'] . "\n" .
						#$this->_t('NewAccountIP') . ' ' .		$user['user_ip'] .
						"\n\n";

		if ($this->db->approve_new_user)
		{
			$body .= Ut::perc_replace($this->_t('UserRequiresApproval'), $this->db->site_name);
		}

		$this->send_user_email('System', $subject, $body);
		$this->set_language($save, true);
	}

	function notify_new_owner($user): void
	{
		$save		= $this->set_language($user['user_lang'], true, true);

		$subject	=	$this->_t('NewPageOwnership');
		// STS TODO ou, pure shit message!
		$body		=	Ut::perc_replace($this->_t('YouAreNewOwner'), $this->get_user_name()) . "\n\n" .
						$user['owned_page'] . "\n" .
						$this->_t('PageOwnershipInfo') . "\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	/**
	 * send signup email to user
	 *
	 * @param array		$user		user data array
	 * @param bool		$verify		set email_confirm token and add link for email verification
	 */
	function notify_user_signup($user, $verify = true): void
	{
		$save		= $this->set_language($user['user_lang'], true, true);

		$subject	=	$this->_t('EmailWelcome') . ' ' . $this->db->base_url; // TODO: customize!
		$body		=	Ut::perc_replace(
							$this->_t('EmailRegistered'),
							$this->db->site_name, $user['user_name']) .
						($verify
							? Ut::perc_replace($this->_t('EmailVerify'), $this->user_email_confirm($user['user_id']))
							: '') . "\n\n" .
						($this->db->approve_new_user
							? $this->_t('UserWaitingApproval')
							: $this->_t('EmailRegisteredLogin') ) . "\n\n" .
						$this->_t('EmailRegisteredIgnore') . "\n\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	function notify_password_reset($user, $code): void
	{
		$save		= $this->set_language($user['user_lang'], true, true);

		$subject	=	$this->_t('EmailForgotSubject') . ' ' . $user['user_name'];
		$body		=	Ut::perc_replace($this->_t('EmailForgotMessage'),
							$this->db->site_name,
							$user['user_name'],
							$this->href('', '', ['secret_code' => $code], null, null, null, true, true)) . "\n\n";

		$this->send_user_email($user, $subject, $body);
		$this->set_language($save, true);
	}

	function notify_pm($user, $subject, $body, $header, $msg_id): void
	{
		$save		= $this->set_language($user['user_lang'], true, true);

		$body		=	Ut::perc_replace($this->_t('PMBody'),
							$this->get_user_name()) . "\n\n" .

						'----------------------------------------------------------------------' . "\n" .
						$body . "\n" .
						'----------------------------------------------------------------------' . "\n\n" .

						$this->_t('PMReply') . "\n\n" .
						Ut::amp_decode($this->href('', '',
							['profile'	=> $this->get_user_name(),
							'ref'		=> Ut::http64_encode(gzdeflate($msg_id . '@@' . $subject, 9)),
							'#'			=> 'contacts'],
							null, null, null, true, true)) . "\n\n";

		$this->send_user_email($user, $subject, $body, $header);
		$this->set_language($save, true);
	}

	function notify_pm_cc($to, $subject, $body, $header, $msg_id): void
	{
		$user		= $this->get_user();
		$save		= $this->set_language($user['user_lang'], true, true);

		$body		=	Ut::perc_replace($this->_t('PMBodyCopy'),
							$to['user_name']) . "\n\n" .

						'----------------------------------------------------------------------' . "\n" .
						$body . "\n" .
						'----------------------------------------------------------------------' . "\n\n" .

						$this->_t('PMReply') . "\n\n" .
						Ut::amp_decode($this->href('', '',
							['profile'	=> $to['user_name'],
							'ref'		=> Ut::http64_encode(gzdeflate($msg_id . '@@' . $subject, 9)),
							'#'			=> 'contacts'],
							null, null, null, true, true)) . "\n\n";

		$this->send_user_email($user, $subject, $body, $header);
		$this->set_language($save, true);
	}

	function notify_new_page($page_id, $tag, $title, $user_id, $user_name): void
	{
		$subject[]	= 'NewPageCreatedSubj';
		$subject[]	= $title;

		$body[]		= 'NewPageCreatedBody';
		$body[]		= $user_name;
		$body[]		= $title;
		$body[]		= $this->href('', $tag, null, null, null, null, true, true);

		$this->notify_moderator($page_id, $user_id, $subject, $body);
	}

	function notify_upload($page_id, $file_id, $tag, $file_name, $user_id, $user_name, $replace): void
	{
		if (!$this->db->notify_upload)
		{
			return;
		}

		$subject[]	= 'FileUploadedSubj';
		$subject[]	= $file_name;

		$body[]		= $replace? 'FileReplacedBody' : 'FileUploadedBody';
		$body[]		= $user_name;
		$body[]		= $file_name . "\n" . $page_id? $tag : $this->_t('UploadGlobal');
		$body[]		= $this->href('filemeta', '', ['m' => 'show', 'file_id' => (int) $file_id], null, null, null, true, true);

		$this->notify_moderator($page_id, $user_id, $subject, $body);
	}

	function notify_moderator($page_id, $user_id, $subject, $body): void
	{
		// subscribe & notify moderators
		if (isset($this->db->groups['Moderator']) && is_array($this->db->groups['Moderator']))
		{
			$members = $this->db->load_all(
				'SELECT m.user_id, u.user_name, u.email, s.user_lang, u.email_confirm, u.enabled, s.send_watchmail ' .
				'FROM ' . $this->prefix . 'usergroup g ' .
					'INNER JOIN ' . $this->prefix . 'usergroup_member m ON (g.group_id = m.group_id) ' .
					'INNER JOIN ' . $this->prefix . 'user u ON (m.user_id = u.user_id) ' .
					'LEFT JOIN ' . $this->prefix . 'user_setting s ON (u.user_id = s.user_id) ' .
				"WHERE g.group_name = 'Moderator'");

			foreach ($members as $user)
			{
				if ($user_id != $user['user_id'])
				{
					if ($this->db->enable_email && $this->db->enable_email_notification && $user['enabled'] && !$user['email_confirm'] && $user['send_watchmail'])
					{
						$save		= $this->set_language($user['user_lang'], true, true);

						$_subject	=	$this->_t($subject[0]) . " '$subject[1]'";

						$_body		=	Ut::perc_replace($this->_t($body[0]), ($body[1] == GUEST ? $this->_t('Guest') : $body[1])) . "\n\n" .
										"'" . $body[2] . "'" . "\n" .
										$body[3] . "\n\n";

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
	function notify_watcher($page_id, $comment_on_id, $tag, $title, $page_body, $user_id, $user_name, $minor_edit): void
	{
		if (!$title)
		{
			$title = $tag;
		}

		if ($comment_on_id)
		{
			$object_id				= $comment_on_id;
			$page_title				= $this->get_page_title('', $comment_on_id);
		}
		else
		{
			$object_id				= $page_id;
			// revisions diff
			$page = $this->db->load_single(
				'SELECT revision_id ' .
				'FROM ' . $this->prefix . 'revision ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
				'ORDER BY modified DESC ' .
				'LIMIT 1');

			// a -> b (old -> new)
			$_GET['a']				= $page['revision_id'];
			$_GET['b']				= -1;
			$_GET['diffmode']		= $this->db->notify_diff_mode;
			$_GET['notification']	= 1;

			$diff					= $this->method('diff');
			$diff					= $this->format($diff, 'html2mail');
		}

		// get watchers
		$watchers	= $this->db->load_all(
			'SELECT DISTINCT
				w.user_id, w.comment_id, w.pending,
				u.email, u.user_name, u.email_confirm, u.enabled,
				s.user_lang, s.send_watchmail, s.notify_minor_edit, s.notify_page, s.notify_comment ' .
			'FROM ' . $this->prefix . 'watch w ' .
				'LEFT JOIN ' . $this->prefix . 'user u ON (w.user_id = u.user_id) ' .
				'LEFT JOIN ' . $this->prefix . 'user_setting s ON (w.user_id = s.user_id) ' .
			'WHERE w.page_id = ' . (int) $object_id . ' ' .
				'AND w.user_id <> ' . (int) $user_id);

		foreach ($watchers as $user)
		{
			if ($comment_on_id)
			{
				// assert that user has no comments pending...
				if ($user['notify_comment'] > 1)
				{
					// ...and add one if so
					if (!$user['comment_id'])
					{
						$this->db->sql_query(
							'UPDATE ' . $this->prefix . 'watch SET ' .
								'comment_id	= ' . (int) $page_id . ' ' .
							'WHERE page_id = ' . (int) $comment_on_id . ' ' .
								'AND user_id = ' . (int) $user['user_id']);
					}
					else
					{
						continue;	// skip watcher
					}
				}
				else if (!$user['notify_comment'])
				{
					continue;	// skip watcher
				}
			}
			else
			{
				if (($minor_edit && !$user['notify_minor_edit']) || !$user['notify_page'])
				{
					continue;	// skip watcher
				}

				// assert that user has no comments pending...
				if ($user['notify_page'] > 1)
				{
					// ...and add one if so
					if (!$user['pending'])
					{
						$this->set_watch_pending($user['user_id'], $comment_on_id);
					}
					else
					{
						continue;	// skip watcher
					}
				}
			}

			// removes user from subscription if access writes were revoked
			if (!$this->has_access('read', $object_id, $user['user_name']))
			{
				$this->clear_watch($user['user_id'], $object_id);
				continue;
			}

			if ($this->db->enable_email
				&& $this->db->enable_email_notification
				&& $user['enabled']
				&& !$user['email_confirm']
				&& $user['send_watchmail'])
			{
				$lang = $user['user_lang'];
				$save = $this->set_language($lang, true, true);

				$body = ($user_name == GUEST ? $this->_t('Guest') : $user_name);

				if ($comment_on_id)
				{
					$subject = $this->_t('CommentForWatchedPage') . "'" . $page_title . "'";

					$body .=
							$this->_t('SomeoneCommented') . "\n" .
							$this->href('', $this->get_page_tag($comment_on_id), null, null, null, null, true, true) . "\n\n" .
							$title . "\n" .
							"----------------------------------------------------------------------\n\n" .
							$page_body . "\n\n" .
							"----------------------------------------------------------------------\n\n";

					if ($user['notify_comment'] == 2)
					{
						$this->set_language($lang, true, true);
						$body .= $this->_t('FurtherPending') . "\n\n";
					}
				}
				else
				{
					$subject		= $this->_t('WatchedPageChanged') . "'" . $title . "'";

					$patterns		= ['/%%SimpleDiffAdditions%%/u',		'/%%SimpleDiffDeletions%%/u'];
					$replacements	= [$this->_t('SimpleDiffAdditions'),	$this->_t('SimpleDiffDeletions')];
					$diff			= preg_replace($patterns, $replacements, $diff);

					$body .=
							$this->_t('SomeoneChangedThisPage') . "\n" .
							$this->href('diff', $tag, ['a' => $page['revision_id'], 'b' => '', 'diffmode' => $this->db->default_diff_mode], null, null, null, true, true) . "\n\n" .
							$title . "\n" .
							"======================================================================\n\n" .
							$diff . "\n\n" .
							"======================================================================\n\n";

					if ($user['notify_page'] == 2)
					{
						$this->set_language($lang, true, true);
						$body .= $this->_t('FurtherPending') . "\n\n";
					}
				}

				$this->send_user_email($user, $subject, $body);
				$this->set_language($save, true);
			}
		}
	}

	// re-send email confirmation code
	function notify_email_confirm($user): void
	{
		if ($this->db->enable_email)
		{
			if ($user['email'])
			{
				$save		=	$this->set_language($user['user_lang'], true);
				$subject	=	$this->_t('EmailConfirm');
				$body		=	Ut::perc_replace($this->_t('EmailReverify'),
									$this->db->site_name,
									$user['user_name'],
									$this->user_email_confirm($user['user_id'])) . "\n\n";

				$this->send_user_email($user, $subject, $body);
				$this->set_language($save, true);

				$message	= $this->_t('EmailConfirmResent');
			}
			else
			{
				$message	= $this->_t('EmailConfirmNotSent');
			}

			$this->set_message($message, 'success');
		}
	}

	// generate url for email confirmation, used for registration and email change
	function user_email_confirm($user_id): string
	{
		$token = Ut::random_token(21);

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'email_confirm = ' . $this->db->q(hash_hmac('sha256', $token, $this->db->system_seed_hash)) . ' ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');

		return $this->href('', $this->db->account_page, ['confirm' => $token], null, null, null, true, true);
	}

	function user_email_confirm_check($token): void
	{
		$hash = $this->db->q(hash_hmac('sha256', $token, $this->db->system_seed_hash));

		if ($user = $this->db->load_single(
			'SELECT user_name, email ' .
			'FROM ' . $this->prefix . 'user ' .
			'WHERE email_confirm = ' . $hash . ' ' .
			'LIMIT 1'))
		{
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'user SET ' .
					"email_confirm = '' " .
				'WHERE email_confirm = ' . $hash . ' ' .
				'LIMIT 1');

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
				$this->compose_link_to_page($this->db->account_page, '', $this->_t('AccountText'))), 'error');
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
	function set_message($message, $type = 'note'): void
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
		if ($message = $this->get_system_message())
		{
			array_unshift($messages, $message);
		}

		if ($show)
		{
			// TODO: maybe filter?
			// TODO: think about quoting....
			foreach ($messages as $message)
			{
				$this->show_message($message[0], $message[1]);
			}
		}
		else
		{
			// do not cache pages with notices!
			if ($messages)
			{
				$this->http->no_cache(false);
			}

			return $messages;
		}
	}

	function show_message($message, $type = 'note', $show = true)
	{
		if ($message)
		{
			$info_box = '<div class="msg ' . $type . '">' . $message . '</div>' . "\n";

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

	function get_system_message()
	{
		if (    $this->db->enable_system_message
			&& ($this->db->system_message)
			&& !$this->db->ap_mode
			&& $this->method == 'show')
		{
			$audience = match ((int) $this->db->system_message_audience) {
				1 => true,						// all
				2 => !$this->get_user_id(),		// guest
				3 => $this->get_user_id(),		// registered
			};

			if ($audience)
			{
				return [
					$this->db->system_message,
					'sys-message ' . $this->db->system_message_type
				];
			}
		}
	}

	function msg_is_comment_on($tag, $title, $user_name, $modified): string
	{
		return
			$this->_t('ThisIsCommentOn') . ' ' .
			$this->compose_link_to_page($tag, '', $title, $tag) . ', ' .
			$this->_t('PostedBy') . ' ' .
			$this->user_link($user_name) . ' ' .
			$this->_t('At') . ' ' . $this->sql_time_format($modified);
	}

	/**
	 * normalizes absolute or relative link
	 *
	 * a) absolute: strips leading slash from link
	 *
	 * 		/cluster/base	->	cluster/base
	 *
	 * b) relative: unwraps link based on $this->context
	 *
	 *		$this->context	=	'cluster/base'
	 *			'page'		->	'cluster/page'
	 *			'../page'	->	'page'
	 *			'!/page'	->	'cluster/base/page'
	 *
	 * @param string $tag
	 *
	 * @return string tag with full path and without leading slash
	 */
	function unwrap_link($tag): string
	{
		if ($tag == '/')											// '/'
		{
			return '';
		}

		if ($tag == '!')											// '!'
		{
			return $this->context[$this->current_context];
		}

		$new_tag = $tag;

		// get root tag
		if (isset($this->context[$this->current_context]) && mb_strstr($this->context[$this->current_context], '/'))
		{
			$root		= preg_replace('/^(.*)\\/([^\\/]+)$/u', '$1', $this->context[$this->current_context]);
		}
		else
		{
			$root		= '';
		}

		if (preg_match('/^\.\/(.*)$/u', $tag, $matches))			// './tag'
		{
			$root		= '';
		}
		else if (preg_match('/^\/(.*)$/u', $tag, $matches))			// '/tag'
		{
			$root		= '';
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\!\/(.*)$/u', $tag, $matches))		// '!/tag'
		{
			$root		= $this->context[$this->current_context];
			$new_tag	= $matches[1];
		}
		else if (preg_match('/^\.\.\/(.*)$/u', $tag, $matches))		// '../tag'
		{
			$new_tag	= $matches[1];

			if (mb_strstr($root, '/'))
			{
				$root	= preg_replace('/^(.*)\\/([^\\/]+)$/u', '$1', $root);
			}
			else
			{
				$root	= '';
			}
		}

		if ($root != '')
		{
			$new_tag	= '/' . $new_tag;
		}

		// tag equivalent to 'tag' in page table
		$tag	= $root . $new_tag;
		$tag	= str_replace('//', '/', $tag);

		return $tag;
	}

	/**
	* Returns the full URL for a page/method, including any additional URL-parameters and anchor
	*
	* @param string		$method		Optional Wacko method (default 'show' method added in run() function)
	* @param string		$tag		Optional tag. Returns current-page tag if empty
	* @param mixed		$params		Optional URL parameters in HTTP name=value[&name=value][...] format
	* 								(or as list ['a=1', 'b=2'] or ['a' => 1, 'b' => 2])
	* @param bool		$addpage	Optional
	* @param string		$anchor		Optional HTTP anchor-fragment
	* @param bool		$alter		Optional uses underscore_url (turn off for e.g. addpage or hashid routing)
	* @param bool		$encode		Optional - percent-encode the non-ASCII bytes (rfc3986)
	* @param bool		$absolute	Optional - uses absolute URL
	*
	* @return string			HREF string adjusted for Apache rewrite_method setting (i.e. Wacko 'rewrite_method' config-parameter)
	*/
	function href($method = '', $tag = '', $params = [], $addpage = false, $anchor = '', $alter = true, $encode = true, $absolute = false): string
	{
		if (!is_array($params))
		{
			$params = $params? [$params] : [];
		}

		if ($this->db->ap_mode)
		{
			if (!$tag)
			{
				$tag = 'admin.php';

				// sets current AP module
				if (isset($this->module) && !isset($params['mode']))
				{
					$params['mode'] = $this->module;
				}
			}
		}

		if ($addpage)
		{
			$params['add']	= 1;
			$alter			= false;
		}

		$href = ($absolute || $this->canonical) ? $this->db->base_url : $this->db->base_path;

		if ($this->db->rewrite_mode)
		{
			$href .= $this->mini_href($method, $tag, $alter, $encode);
		}
		else
		{
			$params['page']	= $this->mini_href($method, $tag, $alter, $encode);

			// reverse order to have 'page' always as first parameter
			$params			= array_reverse($params);
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
					// skip rfc3986 encode for 'page' -> allows IRI format for tag (rewrite_mode off)
					if ($i == 'page')
					{
						$param = $i . '=' . $param;
					}
					else
					{
						$param = Ut::qencode($i, $param);
					}
				}
				else if (($j = strpos($param, '#')) !== false)
				{
					// for some it is easier to bring in anchor in params
					$anchor	= substr($param, $j + 1);
					$param	= substr($param, 0, $j);
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

	/**
	* Returns value for page 'wacko' parameter, in tag[/method][#anchor] format
	*
	* @param string		$method		Optional Wacko method (default 'show' method added in run() function)
	* @param string		$tag		Optional tag - returns current-page tag if empty
	* @param bool		$alter		Optional
	* @param bool		$encode		Optional - percent-encode the non-ASCII bytes (rfc3986)
	*
	* @return string tag[/method]
	*/
	function mini_href($method = '', $tag = '', $alter = true, $encode = true): string
	{
		if (!($tag = trim($tag ?? '')))
		{
			$tag = $this->tag;
		}

		// urls_underscores
		if ($alter && !$this->db->ap_mode)
		{
			$tag = $this->underscore_url($tag);
		}

		$tag = utf8_trim($tag, '/.');

		// percent-encode the non-ASCII bytes (rfc3986)
		if ($encode)
		{
			$tag = str_replace(['%2F', '%3F', '%3D'], ['/', '?', '='], rawurlencode($tag));
		}

		return $tag . ($method ? '/' . $method : '');
	}

	/**
	* Convert WikiWord to Wiki_Word in URLs if config value urls_underscores is 1
	*
	* @param string $tag page tag
	*
	* @return string
	*/
	function underscore_url($tag): ?string
	{
		// - is now allowed in tag, but we do not want Wiki-_Word:
		// uses PATTERN['ALPHANUM'] without -
		if ($this->db->urls_underscores)
		{
			$patterns =[
				['([\p{L}\p{M}\p{Nd}\_\/])(' .             self::PATTERN['UPPERNUM'] . ')',									'\\1¶\\2'],
				['(' . self::PATTERN['UPPERNUM'] . ')(' .  self::PATTERN['UPPERNUM'] . ')',									'\\1¶\\2'],
				['(' . self::PATTERN['UPPER'] . ')¶(?=' .  self::PATTERN['UPPER'] . '¶' . self::PATTERN['UPPERNUM'] . ')',	'\\1'],
				['(' . self::PATTERN['UPPER'] . ')¶(?=' .  self::PATTERN['UPPER'] . '¶\/)',									'\\1'],
				['(' . self::PATTERN['UPPERNUM'] . ')¶(' . self::PATTERN['UPPERNUM'] . ')($|\b)',							'\\1\\2'],
				['\/¶(' . self::PATTERN['UPPERNUM'] . ')',																	'/\\1'],
				['¶',																										'_'],
			];

			foreach ($patterns as $pattern)
			{
				$tag = preg_replace('/' . $pattern[0] . '/u', $pattern[1], $tag);
			}
		}

		return $tag;
	}

	/**
	* Add spaces and wraps page href into <a> </a>
	*
	* @param string		$tag		Page tag.
	* @param string		$method		Wacko method. Optional, default 'show' method added in run() function.
	* @param string		$text 		Href text. Optional, default is $tag value
	* @param bool		$track		Track this link. Optional, default is TRUE
	* @param string		$title		link title. Optional, default is ''
	* @param string		$params		additional parameters. Optional, default is ''
	*
	* @return string
	*/
	function compose_link_to_page($tag, $method = '', $text = '', $title = '', $track = false, $params = ''): string
	{
		if (!$text)
		{
			$text = $this->add_spaces($tag);
		}

		if ($title)
		{
			$title = Ut::html($title, false);
		}

		if ($track && $this->link_tracking())
		{
			$this->track_link($tag, LINK_PAGE);
		}

		return '<a href="' . $this->href($method, $tag, $params) . '"' . ($title ? ' title="' . $title . '"' : '') . '>' . $text . '</a>';
	}

	/**
	 * Check if the image can be scaled up
	 */
	function check_max_img_size(int $max_width, int $max_height, int $width, int $height, bool $resize_up = false): array
	{
		if (!$resize_up)
		{
			$max_height	= ($max_height	> $height)	? $height	: $max_height;
			$max_width	= ($max_width	> $width)	? $width	: $max_width;
		}

		return [$max_width, $max_height];
	}

	/**
	 * Calculates a new width and height for the image based on $max_width and the provided dimensions
	 */
	function calc_img_width(int $max_width, int $width, int $height): array
	{
		$new_width_percentage	= (100 * $max_width) / $width;
		$new_height				= ($height * $new_width_percentage) / 100;

		return [
			$max_width,
			intval($new_height)
		];
	}

	/**
	 * Calculates a new width and height for the image based on $max_height and the provided dimensions
	 */
	function calc_img_height(int $max_height, int $width, int $height): array
	{
		$new_height_percentage	= (100 * $max_height) / $height;
		$new_width				= ($width * $new_height_percentage) / 100;

		return [
			ceil($new_width),
			ceil($max_height)
		];
	}

	/**
	 * Calculates the new image dimensions
	 */
	function calc_img_size(int $max_width, int $max_height, int $width, int $height): array
	{
		$new_size = [
			$width,
			$height
		];

		if ($max_width > 0)
		{
			$new_size = $this->calc_img_width($max_width, $width, $height);

			if ($max_height > 0 && $new_size[1] > $max_height)
			{
				$new_size = $this->calc_img_height($max_height, $new_size[0], $new_size[1]);
			}
		}

		if ($max_height > 0)
		{
			$new_size = $this->calc_img_height($max_height, $width, $height);

			if ($max_width > 0 && $new_size[0] > $max_width)
			{
				$new_size = $this->calc_img_width($max_width, $new_size[0], $new_size[1]);
			}
		}

		return $new_size;
	}

	// get the width and height to display image at
	function get_img_width_height(?int $max_width, ?int $max_height, int $width, int $height): array
	{
		if ($max_height && !$max_width && $height)
		{
			// calculate relative width, e.g. ?0x400
			$width	= round(($max_height * $width) / $height);
			$height	= $max_height;
		}
		else if ($max_width && !$max_height && $height)
		{
			// calculate relative height, e.g. ?600
			$height	= round(($max_width * $height) / $width);
			$width	= $max_width;
		}

		return [$width, $height];
	}

	// parse off <img> resizing tags from text: height= / width= / align=, e.g. ((http://example.com/image.png width=500))
	function parse_img_param($text): array
	{
		$media_class = '';
		$scale		= '';
		$align		= '';
		$height		= '';
		$width		= '';
		$trim		= 0;

		$text = preg_replace_callback(
			'/\s*\b([a-z]+)=([a-z\d%]+)/i',
			function ($mat) use (&$align, &$height, &$width, &$trim)
			{
				if ($mat[1] == 'height')
				{
					$height = $mat[2];
				}
				else if ($mat[1] == 'width')
				{
					$width = $mat[2];
				}
				else if ($mat[1] == 'align')
				{
					$align = $mat[2];
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

		if ($width || $height)
		{
			$_width = match(1){
				preg_match('/^\d+$/', $width)	=> $width . 'px',
				default							=> 'auto',
			};

			$_height = match(1){
				preg_match('/^\d+$/', $height)	=> $height . 'px',
				default							=> 'auto',
			};

			// uses style="..."
			$scale	= ' style=" width: ' . $_width . '; height: ' . $_height . ';"';
		}

		// get alignment type
		if ($align)
		{
			$e_align = match(1){
				preg_match('/center/i', $align)	=> 'center',
				preg_match('/left/i', $align)	=> 'left',
				preg_match('/right/i', $align)	=> 'right',
				default							=> 'default',
			};

			$media_class = 'media-' . $e_align;
		}

		return [$text, $scale, $media_class];
	}

	// parse off [?|&][caption|clear|direct|nolink|linkonly|right|left|20x50] arguments from file:[/|!/|../]image.png?arg1&arg2=
	function parse_media_param($file_name): array
	{
		// split into src and parameters (using the questionmark)
		$pos = mb_strrpos($file_name, '?');

		if($pos !== false)
		{
			$src		= mb_substr($file_name, 0, $pos);
			$param		= mb_substr($file_name, $pos + 1);
		}
		else
		{
			$src		= $file_name;
			$param		= '';
		}

		// parse width and height
		if(preg_match('#(\d+)(x(\d+))?#i', $param, $size))
		{
			$w = $size[1] ?? null;
			$h = $size[3] ?? null;
		}
		else
		{
			$w = null;
			$h = null;
		}

		// get alignment type
		$align = match(1){
			preg_match('/center/i', $param)		=> 'center',
			preg_match('/left/i', $param)		=> 'left',
			preg_match('/right/i', $param)		=> 'right',
			default								=> 'default',
		};

		// get linking type
		$linking = match(1){
			preg_match('/direct/i', $param)		=> 'direct',
			preg_match('/lightbox/i', $param)	=> 'lightbox',
			preg_match('/linkonly/i', $param)	=> 'linkonly',
			preg_match('/nolink/i', $param)		=> 'nolink',
			default								=> 'meta',
		};

		// get caption command
		if (preg_match('/(caption)/i', $param))
		{
			$caption = 'caption'; // true / caption + license
		}

		// get clear command
		if (preg_match('/(clear)/i', $param))
		{
			$clear = 'clear'; // true / clear float
		}

		return [
			'align'		=> $align,
			'caption'	=> $caption ?? null,
			'clear'		=> $clear ?? null,
			'height'	=> $h,
			'linking'	=> $linking,
			'src'		=> $src ?? null,
			'width'		=> $w,
		];
	}

	// preparing links to save them to body_r
	/**
	* Wraps links in special symbols <!--link:begin-->Link ==Text<!--link:end--> for
	* detection in future (invoking from WackoFormatter).
	*
	* @param string		$tag		Link
	* @param string		$text		Link text
	* @param bool		$track		Track this link. Optional, default is TRUE
	* @param int		$media_url
	*
	* @return string	Wrapped link
	*/
	function pre_link($tag, $text = '', $track = true, $media_url = 0): string
	{
		if (preg_match('/^[\!\.' . self::PATTERN['ALPHANUM_P'] . ']+$/u', $tag))
		{
			if ($track && $this->link_tracking())
			{
				// it's a Wiki link!
				$this->track_link($this->unwrap_link($tag), LINK_PAGE);
			}
		}

		$text	= str_replace('%20', ' ', $text);
		$tag	= str_replace(' ', '%20', $tag);

		if ($media_url == 1)
		{
			return '<!--imglink:begin-->' . $tag . ' ==' . $text . '<!--imglink:end-->';
		}
		else if ($media_url == 2)
		{
			// figure loads dynamically: <ignore> is terminator for paragrafica
			return
				'<ignore><!--link:begin-->' .
				$tag . ' ==' . ($this->format_safe
					? str_replace('>', '&gt;', str_replace('<', '&lt;', $text))
					: $text) .
				'<!--link:end--></ignore>';
		}
		else
		{
			return
				'<!--link:begin-->' .
				$tag . ' ==' . ($this->format_safe
					? str_replace('>', '&gt;', str_replace('<', '&lt;', $text))
					: $text) .
				'<!--link:end-->';
		}
	}

	/**
	* Returns full <a href=".."> or <img ...> HTML for Tag
	*
	* @param string		$tag			Link content - may be Wacko tag, interwiki wikiname:page tag,
	*									http/file/ftp/https/mailto/xmpp URL,
	*									local or remote audio/image/video-file for <audio>/<img>/<video> link,
	*									or local or remote doc-file;
	*									if pagetag is for an external link but not protocol is specified, http:// is prepended
	* @param string		$method			Optional Wacko method (default 'show' method added in run() function)
	* @param string		$text			Optional text or image-file for HREF link (defaults to same as pagetag)
	* @param string		$title
	* @param bool		$track			Link-tracking used by Wacko's internal link-tracking (inter-page cross-references in LINK table).
	*									Optional, default is TRUE
	* @param bool		$safe			If false, then sanitize $text, else no.
	* @param bool		$anchor_link	Optional sets <a id="a-154" ...> once for link at the first appearance
	* @param bool		$meta_direct	Links attached files to filemeta handler if TRUE
	*
	* @return string full Href link
	*/
	function link($tag, $method = '', $text = '', $title = '', $track = true, $safe = false, $anchor_link = true, $meta_direct = true): string
	{
		$aname			= '';
		$audio_link		= false;
		$caption		= '';
		$class			= '';
		$clear			= '';
		$href			= '';
		$icon			= '';
		$img_link		= false;
		$lang			= '';
		$matches		= [];
		$media_class	= '';
		$rel			= '';
		$scale			= '';
		$text			= str_replace('"', '&quot;', $text);
		$title			= str_replace('"', '&quot;', $title);
		$video_link		= false;

		if ($text)
		{
			[$text, $scale, $media_class] = $this->parse_img_param($text);
		}

		if ($track)
		{
			$track = $this->link_tracking();

			// tracking external link
			if (preg_match('/^(https?|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/u', $tag))
			{
				if (!mb_stristr($tag, $this->db->base_url))
				{
					$this->track_link($tag, LINK_EXTERNAL);
				}
			}
		}

		if (!$safe)
		{
			$text	= htmlspecialchars($text,  ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
			$title	= htmlspecialchars($title, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
		}

		// external media file
		if (preg_match('/^(https?|ftp):\/\/([^\\s\"<>]+)\.((' . self::PATTERN['AUDIO'] . ')|(' . self::PATTERN['BITMAP'] . '|' . self::PATTERN['DRAWING'] . ')|(' . self::PATTERN['VIDEO'] . '))$/ui', preg_replace('/<\/?nobr>/u', '', $text), $matches))
		{
			// remove typografica glue
			$link = $text = preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/u', '', $text);

			// audio
			if ($matches[4])
			{
				$audio_link = $link;
			}
			// image
			else if ($matches[5])
			{
				$img_link = $link;
			}
			// video
			else if ($matches[6])
			{
				$video_link = $link;
			}
		}

		// Email -> mailto:info@example.com
		if (preg_match('/^(mailto:)?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/u', $tag, $matches))
		{
			$href	= (isset($matches[1]) && $matches[1] == 'mailto:' ? $tag : 'mailto:' . $tag);
			$title	= $this->_t('EmailLink');
			$icon	= $this->_t('Icon.Outer');
			$class	= '';
			$tpl	= 'outerlink';
		}
		// XMPP address -> xmpp:info@example.com
		else if (preg_match('/^xmpp:[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/u', $tag, $matches))
		{
			$href	= $tag;
			$title	= $this->_t('JabberLink');
			$icon	= $this->_t('Icon.Outer');
			$class	= '';
			$tpl	= 'outerlink';
		}
		// HTML anchor #...
		else if (str_starts_with($tag, '#'))
		{
			$href	= $tag;
			$tpl	= 'anchor';
		}
		// external image
		else if (preg_match('/^(https?|ftp|file):\/\/([^\\s\"<>]+)\.(' . self::PATTERN['BITMAP'] . '|' . self::PATTERN['DRAWING'] . ')$/ui', $tag))
		{
			// remove typografica glue
			$text	= preg_replace('/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/u', '', $text);

			if ($text == $tag || (!$text && ($scale || $media_class)))
			{
				return $this->image_link(str_replace('&', '&amp;', str_replace('&amp;', '&', $tag)), $media_class, null, $text, $text, $scale);
			}
			else
			{
				$href	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
				$title	= $this->_t('OuterLink2');
				$icon	= $this->_t('Icon.Outer');
				$tpl	= 'outerlink';
			}
		}
		// file link -> http://example.com/file.zip
		else if (preg_match('/^(https?|ftp|file):\/\/([^\\s\"<>]+)\.(7z|bz2|doc|exe|gz|odt|pdf|ppt|rar|rdf|rpm|tgz|xls|zip)$/u', $tag, $matches))
		{
			$href	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$title	= match($matches[3])
			{
				'pdf'		=> $this->_t('PDFLink'),
				'rdf'		=> $this->_t('RDFLink'),
				default		=> $this->_t('FileLink'),
			};
			$icon	= $this->_t('Icon.Outer');
			$class	= '';
			$tpl	= 'outerlink';
		}
		// external URL
		else if (preg_match('/^(https?|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/u', $tag))
		{
			$href	= str_replace('&', '&amp;', str_replace('&amp;', '&', $tag));
			$tpl	= 'outerlink';

			if (!mb_stristr($tag, $this->db->base_url))
			{
				$title	= $this->_t('OuterLink2');
				$icon	= $this->_t('Icon.Outer');
			}
		}
		// local file -> file:image.png
		else if (preg_match('/^(_?)file:([^\\s\"<>\(\)]+)$/u', $tag, $matches))
		{
			$aname			= '';
			$nomedia		= $matches[1]; // files action: matches '_file:' - patched link to not render media in their tags when not needed
			$_file_name		= $matches[2];
			$file_array		= explode('/', $_file_name);
			$param			= [];
			$page_tag		= '';
			$class			= 'file-link'; // generic file icon
			$global			= true;
			$file_access	= false;

			// 1 -> file:/some.zip (global)
			if (count($file_array) == 2 && $file_array[0] == '')
			{
				$page_tag	= $this->db->ap_mode ? $this->context[$this->current_context] : ''; // prevents that tag is set as 'admin.php' in href()
				$file_name	= $file_array[1];
				$param		= $this->parse_media_param($file_name);

				if ($file_data = $this->check_file_record($param['src']))
				{
					$href	= ($this->canonical ? $this->db->base_url : $this->db->base_path) . Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);

					// tracking file link
					if ($track && isset($file_data['file_id']))
					{
						$this->track_link($file_data['file_id'], LINK_FILE);
					}
				}
			}
			else
			{
				// 2a -> file:some.zip				(local relative)
				// 2b -> file:/cluster/some.zip		(local absolute)
				$local_file	= $file_array;
				$global		= false;
				$file_name	= $local_file[count($local_file) - 1];

				unset($local_file[count($local_file) - 1]);
				$_page_tag	= implode('/', $local_file);

				if ($_page_tag == '')
				{
					$_page_tag = '!/';
				}

				// unwrap relative tag (check !/, ../ cases)
				$uw_tag			= $this->unwrap_link($_page_tag);
				$page_tag		= utf8_rtrim($uw_tag, './');
				$page_id		= $this->get_page_id($page_tag);
				$param			= $this->parse_media_param($file_name);

				if ($file_data = $this->check_file_record($param['src'], $page_id))
				{
					$href = $this->href('file', utf8_trim($page_tag, '/'), ['get' => $file_name]);

					// tracking file link
					if ($track && isset($file_data['file_id']))
					{
						$this->track_link($file_data['file_id'], LINK_FILE);
					}

					// check permissions
					if ($this->is_admin()
					|| ($file_data['file_id'] && ($this->page['owner_id'] == $this->get_user_id()))
					|| ($this->has_access('read', $page_id))
					|| ($file_data['user_id'] == $this->get_user_id()))
					{
						$file_access = true;
					}
				}
			}

			// file in global or local namespace
			if (is_array($file_data))
			{
				// set an anchor once for file link at the first appearance
				if ($anchor_link && !isset($this->first_inclusion[OBJECT_FILE][$file_data['file_id']]))
				{
					$aname = ' id="a-' . $file_data['file_id'] . '"';
					$this->first_inclusion[OBJECT_FILE][$file_data['file_id']] = 1;
				}

				// check 403 here!
				if ($global || $file_access)
				{
					$title		= Ut::html($file_data['file_description']) . ' (' . $this->factor_multiples($file_data['file_size'], 'binary', true, true) . ')';
					$alt		= Ut::html($file_data['file_description']);
					$src		= '';
					$width		= '';
					$height		= '';
					$img_link	= false;
					$icon		= $this->_t('Icon.Outer');
					$tpl		= 'localfile';

					// media it is
					if (in_array($file_data['file_ext'], array_merge(self::EXT['audio'], self::EXT['bitmap'], self::EXT['drawing'], self::EXT['video'])) && !$nomedia)
					{
						if ($file_data['file_ext'] == 'svg')
						{
							if ($param['width'])
							{
								$scale	= ' width="' . $param['width'] . '"';
							}
							else
							{
								$scale = '';
							}
						}
						else
						{
							if ($file_data['picture_w'])
							{
								[$param['width'], $param['height']] = $this->get_img_width_height(
									$param['width'],
									$param['height'],
									$file_data['picture_w'],
									$file_data['picture_h']);

								// takes user provided values else original size
								$width	= $param['width']	?? $file_data['picture_w'];
								$height	= $param['height']	?? $file_data['picture_h'];
							}

							if (in_array($file_data['file_ext'], self::EXT['video']))
							{
								$width	= $param['width'] ?? 800; // default width
								$height	= 0;
							}

							$scale	= ' width="' . $width . '" height="' . $height . '"';
						}

						// show image
						if(!$text)
						{
							$tpl	= 'localimage';
							$icon	= '';

							// $param gets updated via &$param for max_image_width
							$src	= $this->media_src($file_data, $param, $page_tag, $global);
							$href	= $this->href('filemeta', utf8_trim($page_tag, '/'), ['m' => 'show', 'file_id' => $file_data['file_id']]);

							switch ($param['linking'])
							{
								case 'nolink':
									$href	= '';
									break;
								case 'direct':
									$href	= $src;
									break;
								case 'linkonly':
									$href	= $src; // assumes direct link
									$icon	= $this->_t('Icon.Outer');
									$tpl	= 'localfile';
									$text	= $file_data['file_name'];
									break;
							}

							if ($src && !$text)
							{
								$media_class = 'media-' . $param['align'];

								if ($file_data['picture_w'] || $file_data['file_ext'] == 'svg')
								{
									// set new width and height for max_image_width
									$scale	= ' width="' . $param['width'] . '" height="' . $param['height'] . '"';
									$text	= $this->image_link($src, $media_class, $aname, $title, $alt, $scale);
								}
								else if (in_array($file_data['file_ext'], self::EXT['video']))
								{
									$tpl	= '';
									$text	= $this->video_link($src, $media_class, $aname, $title, $scale);
								}
								else if (in_array($file_data['file_ext'], self::EXT['audio']))
								{
									$tpl	= '';
									$text	= $this->audio_link($src, $media_class, $aname, $title);
								}

								// add clearfix
								//		link		-> <a class="... clearfix" ...><img ...></a>
								//		nolink		-> <span class="clearfix"><img ...></span>
								//		caption		-> </figure><span class="clearfix"></span>
								if ($param['clear'])
								{
									$clear = true;

									if (!$param['caption'])
									{
										$class .= ' clearfix'; // add CSS clearfix class
									}
								}

								// add caption
								if (!empty($file_data['caption']) && $param['caption'])
								{
									$caption	=
										'<span class="caption-sub">' . Ut::html($file_data['caption']) . '</span>' . ' ' .
										($file_data['author']
											? '<br><span class="caption-license"><small>' .
												'(' . $this->_t('FileSource') . ': ' .
												($file_data['source_url']
													? '<a href="' . $file_data['source_url'] . '" rel="nofollow" target="_blank">' . Ut::html($file_data['author']) . '</a>'
													: Ut::html($file_data['author'])) .
												($file_data['license_id']
													? ' /' .
														// FIXME; bad .tpl hack to remove line feed and indent stuff
														preg_replace('/[\r\n\t]+/u', '', $this->action('license', ['license_id' => $file_data['license_id'], 'intro' => 0]))
													: '') .
												')</small></span>'
											: '');
								}

								// disables linking also for print handler, first and foremost to prevent those links showing up in numerate_links
								if (!$meta_direct || (isset($this->method) && $this->method == 'print'))
								{
									if ($caption)
									{
										$text = $this->add_caption($text, $caption, $media_class, $clear);
									}

									return $text;
								}
							}
						}
					}
				}
				else // 403
				{
					$href		= $this->href('file', utf8_trim($page_tag, '/'), ['get' => $file_name]);
					$icon		= $this->_t('Icon.Outer');
					$img_link	= false;
					$tpl		= 'localfile';
					$class		= 'acl-denied';
				}
			}
			else	// 404
			{
				$tpl	= 'wlocalfile';
				$href	= '404';

				if ($global)
				{
					$title	= '404: /' . Ut::join_path(UPLOAD_GLOBAL_DIR, $file_name);
				}
				else
				{
					$title	= '404: /' . utf8_trim($page_tag, '/') . '/file' . ($this->db->rewrite_mode ? '?' : '&amp;') . 'get=' . $file_name;
				}
			} // forgot 'bout 403

			unset($file_data);
		}
		// user link -> user:UserName
		else if (preg_match('/^(user):(' . self::PATTERN['USER_NAME'] . ')?$/u', $tag, $matches))
		{
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', $parts[$i]);
			}

			$href	= $this->href('', $this->db->users_page . '/', ['profile' => implode('/', $parts)]);

			$class	= 'user-link';
			$icon	= $this->_t('Icon.Outer');
			$tpl	= 'userlink';
		}
		// group link -> group:UserGroup
		else if (preg_match('/^(group):(' . self::PATTERN['USER_NAME'] . ')?$/u', $tag, $matches))
		{
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', $parts[$i]);
			}

			$href	= $this->href('', $this->db->groups_page . '/', ['profile' => implode('/', $parts)]);

			$class	= 'group-link';
			$icon	= $this->_t('Icon.Outer');
			$tpl	= 'userlink';
		}
		// interwiki -> wiki:page
		else if (preg_match('/^([[:alnum:]]+):([' . self::PATTERN['ALPHANUM_P'] . '\(\)\.\+\&\=\#]*)$/u', $tag, $matches))
		{
			$parts	= explode('/', $matches[2]);

			for ($i = 0; $i < count($parts); $i++)
			{
				$parts[$i] = str_replace('%23', '#', rawurlencode($parts[$i]));
			}

			$href	= $this->get_inter_wiki_url($matches[1], implode('/', $parts));
			$class	= 'iw-' . mb_strtolower($matches[1]);
			$icon	= $this->_t('Icon.Outer');
			$tpl	= 'outerlink';
		}
		// wiki link
		else if (preg_match('/^([\!\.' . self::PATTERN['ALPHANUM_P'] . ']+)(\#[' . self::PATTERN['ALPHANUM_P'] . ']+)?$/u', $tag, $matches))
		{
			$aname			= '';
			$match			= '';
			$tag			= $matches[1];
			$untag			= $unwrap_tag	= $this->unwrap_link($tag);

			$regex_handlers	= '/^(.*?)\/(' . $this->db->standard_handlers . ')\/(.*)$/ui';
			$handler		= null;

			// detecting page handler
			if (preg_match($regex_handlers, '/' . $untag . '/', $match))
			{
				$handler	= $match[2];

				$_ptag		??= ''; // XXX: ???

				$ptag		= $match[1];
				$unwrap_tag	= '/' . $unwrap_tag . '/';
				$co			= mb_substr_count($_ptag, '/') - mb_substr_count($ptag, '/');

				for ($i = 0; $i < $co; $i++)
				{
					$unwrap_tag	= mb_substr($unwrap_tag, 0, mb_strrpos($unwrap_tag, '/'));
				}
			}

			$unwrap_tag			= utf8_trim($unwrap_tag, '/.');
			$unwrap_tag			= str_replace('_', '', $unwrap_tag);

			if ($handler)
			{
				// strip handler from page tag
				$unwrap_tag	= mb_substr($unwrap_tag, 0, - (mb_strlen($handler) + 1));
				$method		= $handler;
			}

			$this_page		= $this->load_page($unwrap_tag, 0, null, LOAD_CACHE, LOAD_META);

			if (mb_substr($tag, 0, 2) == '!/')
			{
				$icon		= $this->_t('Icon.Child');
				$page0		= mb_substr($tag, 2);
				$page		= $this->add_spaces($page0, true);
				$tpl		= 'page';
			}
			else if (mb_substr($tag, 0, 3) == '../')
			{
				$icon		= $this->_t('Icon.Parent');
				$page0		= mb_substr($tag, 3);
				$page		= $this->add_spaces($page0, true);
				$tpl		= 'page';
			}
			else if (mb_substr($tag, 0, 1) == '/')
			{
				$icon		= $this->_t('Icon.Root');
				$page0		= mb_substr($tag, 1);
				$page		= $this->add_spaces($page0, true);
				$tpl		= 'page';
			}
			else
			{
				$icon		= $this->_t('Icon.Equal');
				$page0		= $tag;
				$page		= $this->add_spaces($page0, true);
				$tpl		= 'page';
			}

			if ($img_link)
			{
				$text		= $this->image_link($img_link, $media_class, null, $text, $text, $scale);
			}

			if ($text)
			{
				// take page title instead of pagepath when only tag is provided, e.g. ((/Root/Page))
				if (!$title && $tag == $text)
				{
					$title = $this_page['title'] ?? '';
				}

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

			$page_path		= mb_substr($untag, 0, mb_strlen($untag) - mb_strlen($page0));
			$anchor			= $matches[2] ?? '';
			$tag			= $unwrap_tag;

			// track page link
			if ($track)
			{
				$this->track_link($tag, LINK_PAGE);
			}

			if ($this_page)
			{
				$page_link	= $this->href($method, $this_page['tag']) . ($anchor ?: '');
				$page_id	= $this_page['page_id'];

				// set an anchor once for page link at the first appearance
				if ($anchor_link && !isset($this->first_inclusion[OBJECT_PAGE][$page_id]))
				{
					$aname = ' id="a-' . $page_id . '"';
					$this->first_inclusion[OBJECT_PAGE][$page_id] = 1;
				}

				if ($this->db->hide_locked)
				{
					$access		= $this->has_access('read', $page_id);
				}
				else
				{
					$access		= true;

					if (!$this->has_access('read', $page_id))
					{
						$this->acl['list'] = '';
					}
				}

				# Ut::debug_print_r($this->acl['list']);
				$acl = explode("\n", $this->acl['list']);

				if (!$access || $this->acl['list'] == '')
				{
					$class		= 'acl-denied';
					$rel		= 'nofollow';
					$accicon	= $this->_t('Icon.Outer');
				}
				else if (in_array('*', $acl))
				{
					$class		= '';
					$accicon	= '';
				}
				else
				{
					$class		= 'acl-customsec';
					$rel		= 'nofollow';
					$accicon	= $this->_t('Icon.Outer');
				}
			}
			else
			{
				$tpl		= (isset($this->method) && in_array($this->method, ['print', 'wordprocessor']) ? 'p' : '') . 'w' . $tpl;
				$page_link	= $this->href('edit', $tag, $lang ? 'lang=' . $lang : '', 1);
				$accicon	= $this->_t('Icon.Wanted');
				$title		= $this->_t('CreatePage');
			}

			// load and parse link template (see lang/wacko.all.php)
			$res			= $this->_t('Tpl.' . $tpl);
			$text			= trim($text);

			// make HTML link
			if ($res)
			{
				// do not set empty class=""
				if ($class)
				{
					$class	= ' class="' . $class . '"';
				}

				// sets only 'nofollow' as link type to internal links for protected pages
				if ($rel)
				{
					$rel	= ' rel="' . $rel . '"';
				}

				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				$templates = [
					'{aname}'		=> $aname,
					'{rel}'			=> $rel,
					'{icon}'		=> $icon,
					'{accicon}'		=> $accicon,
					'{class}'		=> $class,
					'{title}'		=> $title,
					'{pagelink}'	=> $page_link,
					'{pagepath}'	=> $page_path,
					'{page}'		=> $page,
					'{text}'		=> $text,
				];

				// process template for internal link
				foreach ($templates as $template => $element)
				{
					$res = str_replace($template, $element, $res);
				}

				if (!$text)
				{
					$text	= htmlspecialchars($tag, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
				}

				// disable and visualize self-referencing link
				if ($this->db->youarehere_text && !$handler)
				{
					if (isset($this->context[$this->current_context]) && ($tag == $this->context[$this->current_context]) )
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

		if (!$text)
		{
			$text = htmlspecialchars($tag, ENT_NOQUOTES, HTML_ENTITIES_CHARSET);
		}

		// external link
		if ($href)
		{
			if ($img_link)
			{
				$text		= $this->image_link($img_link, $media_class, $aname, $text, $text, $scale);
				$tpl		= 'outerimg';
			}
			else if ($audio_link)
			{
				return		$this->audio_link($audio_link, $media_class, $aname, $text);
			}
			else if ($video_link)
			{
				return		$this->video_link($video_link, $media_class, $aname, $text, $scale);
			}

			$res			= $this->_t('Tpl.' . $tpl);

			if ($res)
			{
				if (!$class)
				{
					$class	= 'external-link';
				}

				// do not set empty class=""
				if ($class)
				{
					$class	= ' class="' . $class . '"';
				}

				if ($this->db->link_target)
				{
					$target = ' target="_blank"';
				}
				else
				{
					$target = '';
				}

				// https://developer.mozilla.org/en-US/docs/Web/HTML/Link_types
				if ($this->db->noreferrer || $this->db->nofollow)
				{
					$_rel = [];

					if ($this->db->link_target)
					{
						$_rel[] = 'noopener';
					}

					if ($this->db->nofollow)
					{
						$_rel[] = 'nofollow';
					}

					if ($this->db->noreferrer)
					{
						$_rel[] = 'noreferrer';
					}

					$rel_separated	= implode(' ', $_rel);
					$rel			= ' rel="' . $rel_separated . '"';
				}
				else
				{
					$rel = '';
				}

				if (isset($this->method) && $this->method == 'print')
				{
					$icon	= '';
				}

				$templates = [
					'{aname}'		=> $aname,
					'{target}'		=> $target,
					'{rel}'			=> $rel,
					'{icon}'		=> $icon,
					'{class}'		=> $class,
					'{title}'		=> $title,
					'{href}'		=> $href,
					'{text}'		=> $text,
				];

				// process template for external link
				foreach ($templates as $template => $element)
				{
					$res = str_replace($template, $element, $res);
				}

				// numerated outer links and file links
				if ($href != $text && $href != '404' && $href != '403')
				{
					$res .= $this->numerate_link($href);
				}

				if ($caption)
				{
					$res	= $this->add_caption($res, $caption, $media_class, $clear);
				}

				return $res;
			}
		}

		// file:image.png + ?nolink + &caption
		if ($caption)
		{
			return $this->add_caption($text, $caption, $media_class, $clear);
		}

		if ($clear)
		{
			$text = '<span class="clearfix">' . $text . '</span>';
		}

		return $text;
	}

	private function numerate_link($url, $decode = true)
	{
		// numerated wiki-links, initialize property as an array to make it work
		if (is_array($this->numerate_links))
		{
			// for better readability in print output
			if ($decode)
			{
				$url = rawurldecode($url);
			}

			$refnum		= &$this->numerate_links[$url];
			$refnum		??= '[link' . count($this->numerate_links) . ']';

			return '<sup class="refnum">' . $refnum . '</sup>';
		}
	}

	function add_caption($text, $caption, $class, $clear = false): string
	{
		$figure =
			'<figure class="caption ' . $class . '">' . "\n" .
				$text . "\n" .
				'<figcaption>' . $caption . '</figcaption>' . "\n" .
			'</figure>';

		// center requires additional wrapper
		if ($class == 'media-center')
		{
			$figure = '<div class="figure-center-wrp">' . $figure . '</div>';
		}

		// add clearfix
		if ($clear)
		{
			$figure .= '<span class="clearfix"></span>';
		}

		return $figure;
	}

	function media_src($file, &$param, $tag, $global): string
	{
		$thumb = false;

		// check for thumbnail
		if ($this->db->create_thumbnail
			&& $this->thumbnail_image_area($file['picture_w'], $file['picture_h']))
		{
			if ($file['picture_h'] && $param['width']
				&& $file['picture_w'] - $this->db->min_thumbnail_distance > $param['width'])
			{
				$thumb		= true;
				$thumb_name	= $this->thumb_name($file['file_name'], $param['width'], $param['height'], $file['file_ext']);
			}
			else if ($this->db->max_image_width && $file['picture_h']
				&& $file['picture_w'] - $this->db->min_thumbnail_distance > $this->db->max_image_width)
			{
				$thumb		= true;
				[$param['width'], $param['height']]	= $this->get_img_width_height($this->db->max_image_width, 0, $file['picture_w'], $file['picture_h']);
				$thumb_name							= $this->thumb_name($file['file_name'], $param['width'], $param['height'], $file['file_ext']);
			}
		}

		// [a] direct file access for global file
		if ($global)
		{
			if ($thumb)
			{
				$tbn_image	= Ut::join_path(THUMB_DIR, $thumb_name);
				$src_image	= Ut::join_path(UPLOAD_GLOBAL_DIR, $file['file_name']);
				$src_name	= $tbn_image;
			}
			else
			{
				$src_name	= Ut::join_path(UPLOAD_GLOBAL_DIR, $file['file_name']);
			}

			$src	= ($this->canonical ? $this->db->base_url : $this->db->base_path) . $src_name;
		}
		// [b] no direct file access for local file, the file handler checks the access right first
		else
		{
			if ($thumb)
			{
				$tbn_image	= Ut::join_path(THUMB_LOCAL_DIR, '@' . $file['page_id'] . '@' . $thumb_name);
				$src_image	= Ut::join_path(UPLOAD_LOCAL_DIR, '@' . $file['page_id'] . '@' . $file['file_name']);
				$src_thumb	= ['tbn' => $param['width'] . 'x' . $param['height']];
			}
			else
			{
				$src_thumb		= [];
			}

			$src	= $this->href('file', utf8_trim($tag, '/'), ['get' => $file['file_name']] + $src_thumb);
		}

		if ($thumb)
		{
			$this->create_thumbnail($tbn_image, $src_image, $param['width'], $param['height']);
		}

		return $src;
	}

	function thumb_name($name, int $width, int $height, $ext): string
	{
		$suffix =
			'.thumb.' .
			$width . 'x' . $height .
			'.' . $ext;

		return hash('sha1', $name) . $suffix;
	}

	/**
	 * Check if the file is smaller than the maximum image area for thumbnailing.
	 *
	 * This provides a limit on memory usage for the decompression side of the image scaler.
	 */
	public function thumbnail_image_area($width, $height): bool
	{
		$max_image_area = $this->db->max_image_area;

		// no image size check before attempting to scale it
		if ($max_image_area == -1)
		{
			return true;
		}

		// dynamic determination
		if (!$max_image_area)
		{
			$memory = Ut::shorthand_to_int(ini_get('memory_limit'));
			// cap memory usage, e.g. max 80%
			$memory *= 0.8;
			// factor to MiB
			$memory /= 1024 * 1024;
			// MiB if decompressed to RGBA form
			$max_image_area = $memory * 245000;

			// keep value
			$this->db->max_image_area = $max_image_area;
		}

		if ($width * $height > $max_image_area)
		{
			return false;
		}

		return true;
	}

	function create_thumbnail($tbn_image, $src_image, $width, $height): void
	{
		if (!file_exists($tbn_image))
		{
			@set_time_limit(0);
			@ignore_user_abort(true);

			try
			{
				$thumb = new PHPThumb\GD($src_image);
			}
			catch (Exception $e)
			{
				// handle error here however you'd like
			}

			if (is_object($thumb))
			{
				$start = microtime(true);

				$thumb->setOptions(['jpegQuality' => (int) $this->db->jpeg_quality]);
				$thumb->resize($width, $height);

				// requires correct write permissions!
				$thumb->save($tbn_image);

				$time = microtime(true) - $start;
				$this->log(5, Ut::perc_replace($this->_t('LogThumbnailGeneration'), $this->number_format($time, 3)) . ' -> ' . $src_image . ' (' . $width . '×' . $height . ')');
			}
		}
	}

	function image_link($src, $class, $id, $title, $alt = null, $scale = null): string
	{
		// inline element (paragrafica!)
		return
				'<img src="' . $src . '" loading="lazy"' . $id . ' class="' . $class . '" title="' . $title . '" alt="' . $alt . '" ' . $scale . '>';
	}

	function audio_link($src, $class, $id, $title): string
	{
		// inline element (paragrafica!)
		$fallback	= '<span>Your browser doesn\'t support HTML5 audio. Here is a <a href="' . $src . '" title="' . $title . '">link to the audio</a> instead.</span>';

		return
				'<audio src="' . $src . '"' . $id . ' class="' . $class . '" title="' . $title . '" controls>' . "\n" .
					$fallback . "\n" .
				'</audio>';
	}

	function video_link($src, $class, $id, $title, $scale = null): string
	{
		// inline element (paragrafica!)
		$fallback	= '<span>Your browser doesn\'t support HTML5 video. Here is a <a href="' . $src . '" title="' . $title . '">link to the video</a> instead.</span>';

		return
				'<video src="' . $src . '"' . $id . ' class="' . $class . '" title="' . $title . '" ' . $scale . ' controls>' . "\n" .
					$fallback . "\n" .
				'</video>';
	}

	// creates a link to the user profile
	function user_link($user_name, $linking = true, $add_icon = true): string
	{
		if (!$user_name)
		{
			$user_name	= $this->_t('Guest');
			$linking	= false;
		}

		$text = $user_name;
		$icon = $add_icon?  '<span class="icon"></span>' : '';

		if ($linking)
		{
			return '<a href="' . $this->href('', $this->db->users_page, ['profile' => $user_name]) . '" class="user-link">' . $icon . $text . '</a>';
		}
		else
		{
			return '<span class="user-link">' . $icon . $text . '</span>';
		}
	}

	// creates a link to the group profile
	function group_link($group_name, $linking = true, $add_icon = true)
	{
		if (!$group_name)
		{
			return false;
		}

		$text = $group_name;
		$icon = $add_icon?  '<span class="icon"></span>' : '';

		if ($linking)
		{
			return '<a href="' . $this->href('', $this->db->groups_page, ['profile' => $group_name]) . '" class="group-link">' . $icon . $text . '</a>';
		}
		else
		{
			return '<span class="group-link">' . $icon . $group_name . '</span>';
		}
	}

	/**
	* Add spaces to WikiWords (if config parameter show_spaces = 1) and replace
	* relative  path (/ !/ ../) to icons Icon.RootLink, Icon.SubLink, Icon.UpLink
	*
	* @param	string		$text	Text with WikiWords
	* @param	bool		$icon	adds Link icon as prefix
	*
	* @return	string|null			Text with Wiki Words
	*/
	function add_spaces($text, $icon = false): ?string
	{
		if (($user = $this->get_user()) ? $user['show_spaces'] : $this->db->show_spaces)
		{
			$text = $this->add_nbsps($text);
		}

		if ($icon)
		{
			if (!strncmp($text, '/', 1))
			{
				$text = $this->_t('Icon.RootLink') . mb_substr($text, 1);
			}
			else if (!strncmp($text, '!/', 2))
			{
				$text = $this->_t('Icon.SubLink') . mb_substr($text, 2);
			}
			else if (!strncmp($text, '../', 3))
			{
				$text = $this->_t('Icon.UpLink') . mb_substr($text, 3);
			}
		}

		return $text;
	}

	function add_nbsps($text): string
	{
		// pattern without hyphen-minus (to keep Wiki-Word unchanged)
		$PATTERN = [
			'ALPHA'		=> '[\p{L}\_\/]',
			'ALPHANUM'	=> '[\p{L}\p{M}\p{Nd}\_\/]',
		];

		$patterns =[
			['(' . $PATTERN['ALPHANUM'] . ')(' . self::PATTERN['UPPERNUM'] . ')', 													'\\1' . NBSP . '\\2'],
			['(' . self::PATTERN['UPPERNUM'] . ')(' . self::PATTERN['UPPERNUM'] . ')',												'\\1' . NBSP . '\\2'],
			['(' . $PATTERN['ALPHANUM'] . ')\/',																					'\\1' . NBSP . '/'],
			['(' . self::PATTERN['UPPER'] . ')' . NBSP . '(?=' . self::PATTERN['UPPER'] . NBSP . self::PATTERN['UPPERNUM'] . ')',	'\\1'],
			['(' . self::PATTERN['UPPER'] . ')' . NBSP . '(?=' . self::PATTERN['UPPER'] . NBSP . '\/)',								'\\1'],
			['\/(' . $PATTERN['ALPHANUM'] . ')',																					'/' . NBSP . '\\1'],
			['(' . self::PATTERN['UPPERNUM'] . ')' . NBSP . '(' . self::PATTERN['UPPERNUM'] . ')($|\b)',							'\\1\\2'],
			['(\d)(' . $PATTERN['ALPHA'] . ')',																						'\\1' . NBSP . '\\2'],
			['(' . $PATTERN['ALPHA'] . ')(\d)',																						'\\1' . NBSP . '\\2'],
			# ['(\d)' . NBSP . '(?=\d)',																							'\\1'],
			['(\d)' . NBSP . '(?!' . self::PATTERN['ALPHA'] . ')',																	'\\1'],
		];

		foreach ($patterns as $pattern)
		{
			$text = preg_replace('/' . $pattern[0] . '/u', $pattern[1], $text);
		}

		return $text;
	}

	function add_spaces_title($text): string
	{
		return preg_replace('/' . NBSP . '/', ' ', $this->add_nbsps($text));
	}

	function validate_reserved_words($data)
	{
		$_data = '/' . $data . '/';

		// find the word
		if (preg_match('/\b(' . $this->db->standard_handlers . ')\b/ui', $_data, $match))
		{
			// message
			return $match[0];
		}

		if (isset($this->page['comment_on_id']) && !$this->page['comment_on_id'])
		{
			// disallow pages with Comment[0-9] and all sub-pages, we do not want sub-pages on a comment.
			if (preg_match('/\b(Comment(\d+))\b/ui', $_data, $match))
			{
				return 'Comment([0-9]+)';
			}
		}

		return false;
	}

	// checks for an accent and case-insensitive version of the tag
	function similar_page_exists($tag)
	{
		return $this->db->load_all(
			'SELECT page_id, tag ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE tag = ' . $this->db->q($tag) . ' ' .
				'COLLATE utf8mb4_general_ci ' .
			'ORDER BY tag COLLATE utf8mb4_unicode_520_ci');
	}

	function sanitize_page_tag(&$tag): void
	{
		if (!$tag)
		{
			return;
		}

		// normalizing tag name
		$tag = Ut::normalize($tag);

		// remove invalid characters
		$tag = preg_replace('/[^' . self::PATTERN['TAG_P'] . ']/u', '', $tag);

		// remove starting/trailing slashes, spaces, and minimize multi-slashes
		$tag = preg_replace_callback('#^/+|/+$|(/{2,})|\s+#u',
			function ($x)
			{
				return @$x[1]? '/' : '';
			}, $tag);

		// allow full stop and hyphen-minus as part of the page tag,
		// but ONLY as single character AND only between alphanumeric characters
		// to not mess with the wiki syntax as well as the wiki link path
		// e.g. page/sub-page/6.1/details
		$cluster = [];

		// parent-tags (cluster recursive)
		foreach (explode('/', $tag) as $string)
		{
			// strip full stop and hyphen-minus from the beginning and end of the string
			$string = utf8_trim($string, '.-');

			// remove multi full stop and hyphen-minus
			$string = preg_replace('/(-{2,})/u', '-', $string);
			$string = preg_replace('/(\.{2,})/u', '.', $string);

			// remove consecutive occurrences (.- / -.)
			$string = str_replace(['.-', '-.'], '', $string);

			if ($string)
			{
				$cluster[] = $string;
			}
		}

		$tag = implode('/', $cluster);
	}

	// returns error text, or null on OK
	// if old_tag specified - check also for already-namedness & already-existence
	function sanitize_new_page_tag(&$tag, $old_tag = false): ?string
	{
		$this->sanitize_page_tag($tag);

		// - / ' _ .
		if (!preg_match('/^([' . self::PATTERN['TAG_P'] . ']+)$/u', $tag))
		{
			return $this->_t('InvalidWikiName');
		}

		if ($result = $this->validate_reserved_words($tag))
		{
			return Ut::perc_replace($this->_t('PageReservedWord'), '<code>' . $result .'</code>');
		}

		if ($old_tag)
		{
			if ($tag === $old_tag)
			{
				return Ut::perc_replace($this->_t('AlreadyNamed'), '<strong>' . $this->compose_link_to_page($tag) . '</strong>');
			}

			if ($this->tag != $tag && $this->load_page($tag, 0, null, LOAD_CACHE, LOAD_META))
			{
				return Ut::perc_replace($this->_t('AlreadyExists'), '<strong>' . $this->compose_link_to_page($tag) . '</strong>');
			}
		}

		return null; // it's ok :)
	}

	/**
	 * Sanitize a string
	 *
	 * @param string	$string		String to sanitize.
	 * @param bool		$remove_nl	optional Whether to keep newlines. Default: false.
	 *
	 * @return string Sanitized string.
	 */
	function sanitize_text_field($string, $remove_nl = false): string
	{
		return Ut::strip_all_tags($string, $remove_nl);
	}

	function sanitize_username($user_name): string
	{
		$user_name = Ut::strip_spaces($user_name);
		// strip -_'./\
		$user_name = str_replace(['-', '.', '/', "'", '\\', '_'], '', $user_name);

		return Ut::normalize($user_name);
	}

	// returns error text, or null on OK
	function validate_username($user_name, $create = true): ?string
	{
		// check if name is WikiName style
		if (!$this->is_wiki_name($user_name) && $this->db->disable_wikiname === false)
		{
			return $this->_t('MustBeWikiName') . ' ';
		}
		else if (mb_strlen($user_name) < $this->db->username_chars_min)
		{
			return Ut::perc_replace($this->_t('NameTooShort'), 0, $this->db->username_chars_min) . ' ';
		}
		else if (mb_strlen($user_name) > $this->db->username_chars_max)
		{
			return Ut::perc_replace($this->_t('NameTooLong'), 0, $this->db->username_chars_max) . ' ';
		}
		// check if valid username (and disallow '/')
		else if (!preg_match('/^(' . self::PATTERN['USER_NAME'] . ')$/u', $user_name))
		{
			return $this->_t('InvalidUserName') . ' ';
		}
		// check if reserved word
		else if ($result = $this->validate_reserved_words($user_name))
		{
			return Ut::perc_replace($this->_t('UserReservedWord'), '<code>' . $result . '</code>');
		}
		// if username already exists
		else if ($this->user_name_exists($user_name) && $create)
		{
			$this->log(2, Ut::perc_replace($this->_t('LogUserSimilarName', SYSTEM_LANG), $user_name));

			return $this->_t('UserNameOwned');
		}

		return null; // it's ok :)
	}

	/**
	* Check if text is WikiName
	*
	* @param string $text Tested text
	*
	* @return bool
	*/
	function is_wiki_name($text)
	{
		return preg_match('/^' . self::PATTERN['UPPER'] . self::PATTERN['LOWER'] . '+' . self::PATTERN['UPPERNUM'] . self::PATTERN['ALPHANUM'] . '*$/u', $text);
	}

	// TRACK LINKS

	/**
	* Link-tracking used to collect all links in processed text.
	*
	* @param string		$tag
	* @param int		$link_type	[LINK_PAGE|LINK_FILE]
	*
	*/
	function track_link($tag, $link_type): void
	{
		if (isset($this->linktable)) // no linktable? we are not tracking!
		{
			$this->linktable[$link_type][$tag] = $tag;
		}
	}

	function start_link_tracking(): void
	{
		$this->linktracking = true;
	}

	function stop_link_tracking(): void
	{
		$this->linktracking = false;
	}

	function link_tracking(): bool
	{
		return $this->linktracking;
	}

	/**
	* Write link tables for //$from_page_id// to database
	*
	* @param int $from_page_id
	*/
	function write_link_table($from_page_id): void
	{
		// delete related old links in table
		$this->db->sql_query(
			'DELETE ' .
			'FROM ' . $this->prefix . 'page_link ' .
			'WHERE from_page_id = ' . (int) $from_page_id);

		// page link
		if ($link_table = @$this->linktable[LINK_PAGE])
		{
			$query = '';

			foreach ($link_table as $to_tag)
			{
				$query .= '(' .
						(int) $from_page_id . ', ' .
						(int) $this->get_page_id($to_tag) . ', ' .
						$this->db->q($to_tag) . '),';
			}

			$this->db->sql_query(
				'INSERT INTO ' . $this->prefix . 'page_link ' .
					'(	from_page_id,
						to_page_id,
						to_tag) ' .
				'VALUES ' . utf8_rtrim($query, ','));
		}

		// delete page related old file links in table
		$this->db->sql_query(
			'DELETE ' .
			'FROM ' . $this->prefix . 'file_link ' .
			'WHERE page_id = ' . (int) $from_page_id);

		// file link
		if ($file_table = @$this->linktable[LINK_FILE])
		{
			$query = '';

			foreach (array_keys($file_table) as $file_id) // index == value, BTW
			{
				$query .= '(	' . (int) $from_page_id . ',
								' . (int) $file_id . '),';
			}

			$this->db->sql_query(
				'INSERT INTO ' . $this->prefix . 'file_link ' .
					'(page_id, file_id) ' .
				'VALUES ' . utf8_rtrim($query, ','));
		}

		// delete page related old external links in table
		$this->db->sql_query(
			'DELETE ' .
			'FROM ' . $this->prefix . 'external_link ' .
			'WHERE page_id = ' . (int) $from_page_id);

		// external link
		if ($external_table = @$this->linktable[LINK_EXTERNAL])
		{
			$query = '';

			foreach ($external_table as $link)
			{
				if (filter_var($link, FILTER_VALIDATE_URL))
				{
					$query .= '(	' . (int) $from_page_id . ',
									' . $this->db->q($link) . '),';
				}
			}

			$this->db->sql_query(
				'INSERT INTO ' . $this->prefix . 'external_link ' .
					'(page_id, link) ' .
				'VALUES ' . utf8_rtrim($query, ','));
		}
	}

	function update_link_table($page_id, $body_r): void
	{
		// now we render it internally, so we can write the updated link tables.
		if (isset($this->linktable))
		{
			$this->format($body_r, 'post_wacko');
		}
		else
		{
			$this->linktable = [];
			$this->start_link_tracking();
			$this->track_breadcrumbs($this->tag);
			$this->format($body_r, 'post_wacko');
			$this->stop_link_tracking();
			$this->write_link_table($page_id); // the only call!
			unset($this->linktable);
		}
	}

	// track breadcrumbs for preload functions
	function track_breadcrumbs($tag): void
	{
		$page = '';

		foreach (explode('/', $tag) as $n => $step)
		{
			if ($n > 0)
			{
				$page .= '/';
			}

			$page .= $step;

			if ($page !== $tag)
			{
				$this->track_link($page, LINK_PAGE);
			}
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

			if ($lines = file(Ut::join_path(CONFIG_DIR, 'interwiki.conf')))
			{
				foreach ($lines as $line)
				{
					if (($line = trim($line)) && !ctype_punct($line[0]))
					{
						[$wiki_name, $wiki_url] = preg_split('/\s+/', $line);
						$inter_wiki[mb_strtolower($wiki_name)] = $wiki_url;
					}
				}
			}
		}

		if ($url = @$inter_wiki[mb_strtolower($name)])
		{
			// xhtmlisation
			$url = str_replace('&', '&amp;', $url);

			// tls'ing internal links
			if ($this->db->tls)
			{
				if (isset($this->db->open_url) && str_contains($url, $this->db->open_url))
				{
					$url = str_replace($this->db->open_url, $this->db->base_url, $url);
				}
			}

			if (str_contains($url, $this->db->base_url))
			{
				$sub = mb_substr($url, mb_strlen($this->db->base_url));
				$url = $this->db->base_url . $sub;
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
	function form_open($form_name = '', $parameter = []): string
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

		// new page it is
		$add = (@$_GET['add'] || @$_POST['add']);

		$result	=
			'<form ' .
				'action="' .	$this->href($page_method, $tag, $href_param, $add) . '" ' .
				'method="' .	$form_method . '" ' .
				'name="' .		($form_name ?: '') . '" ' .
				$form_more .
			">\n";

		if (!($this->db->rewrite_mode))
		{
			$result .= '<input type="hidden" name="page" value="' . $this->mini_href($page_method, $tag, $add) . '">' . "\n";
		}

		// add form token
		if ($form_token)
		{
			// do not cache pages with nonces!
			$this->http->no_cache(false);

			// we enforce a minimum value of 30 seconds
			$nonce = $this->sess->create_nonce($form_name, max(30, $this->db->form_token_time));

			$result .=
				'<input type="hidden" name="_nonce" value="' . $nonce . '">' . "\n" .
				'<input type="hidden" name="_action" value="' . $form_name . '">' . "\n";
		}

		return $result;
	}

	function form_close(): string
	{
		return "</form>\n";
	}

	function validate_post_token($tag = null): bool
	{
		if ($_POST
			&& !$this->sess->verify_nonce(@$_POST['_action'], @$_POST['_nonce']))
		{
			$form_name	= (string) ($_POST['_action'] ?? '');
			$used_tag	= $tag ? ' -> <code>' . $tag . '</code>' : '';
			$_POST		= [];
			$_REQUEST	= $_GET;

			$this->set_message($this->_t('FormInvalid'), 'error');
			$this->log(1, Ut::perc_replace(
				$this->_t('LogInvalidFormToken', SYSTEM_LANG),
				'<code>' . $form_name . '</code>' . $used_tag));

			return false;
		}

		return true;
	}

	// REFERRERS
	function log_referrer(): void
	{
		$se = 'https://www.google.';

		if ($this->page
			&& ($ref = @$_SERVER['HTTP_REFERER'])
			&& !$this->bad_words($ref)
			&& (stripos($ref, $se) === false) // cast away pointless www.google.[]
			&& filter_var($ref, FILTER_VALIDATE_URL))
		{
			$heads		= ['https://', 'http://'];
			$headless	= str_replace($heads, '', $ref);

			if ($ref !== $headless) // if protocol known..
			{
				$we = utf8_rtrim(str_replace($heads, '', $this->db->base_url), '/');

				if (strncasecmp($headless, $we, strlen($we))) // if not from ourselves..
				{
					#$ua	= $_SERVER['HTTP_USER_AGENT'] ?? null;

					$this->db->sql_query(
						'INSERT INTO ' . $this->prefix . 'referrer SET ' .
							'page_id		= ' . (int) $this->page['page_id'] . ', ' .
							'referrer		= ' . $this->db->q($ref) . ', ' .
							#"ip				= " . $this->db->q($this->get_user_ip()) . ", " .
							#"user_agent		= " . $this->db->q($ua) . ", " .
							'referrer_time	= UTC_TIMESTAMP()');
				}
			}
		}
	}

	/**
	* Loads all referrers to this page from DB
	* @param int	$page_id
	*
	* @return array|null	Array of (referer, num)
	*/
	function load_referrers($page_ids = null): ?array
	{
		return $this->db->load_all(
			'SELECT ' .
			(!is_null($page_ids)
				? 'page_id, referrer, count(referrer) AS num '
				: 'referrer, count(referrer) AS num ') .
			'FROM ' . $this->prefix . 'referrer ' .
			(!is_null($page_ids)
				? 'WHERE page_id IN (' . $this->ids_string($page_ids) . ') '
				: '') .
			'GROUP BY ' .
				(!is_null($page_ids)
				? 'page_id, referrer '
				: 'referrer ') .
			'ORDER BY num DESC');
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

					// pull
					$tpl->pull('_t',		function ($block, $loc, $str)						{ return $this->_t($str); });
					$tpl->pull('db',		function ($block, $loc, $str)						{ return $this->db[$str]; });
					$tpl->pull('format_t',	function ($block, $loc, $str)						{ return $this->format_t($str); });
					$tpl->pull('href',		function ($block, $loc, $method = '', $param = '')	{ return $this->href($method, '', $param); });
					$tpl->pull('csrf',
						function ($block, $loc, $action)
						{
							// do not cache pages with nonces!
							$this->http->no_cache(false);

							// we enforce a minimum value of 30 seconds
							$nonce = $this->sess->create_nonce($action, max(30, $this->db->form_token_time));

							return
								'<input type="hidden" name="_nonce" value="' . $nonce . '">' . "\n" .
								'<input type="hidden" name="_action" value="' . $action . '">' . "\n";
						});

					$tpl->setEncoding($this->charset);

					// filter
					$tpl->filter('_t',				function ($str)						{ return $this->_t($str); });
					$tpl->filter('hide_page',
						function ($value)
						{
							// for generating method GET forms
							if (preg_match('#\?page=([^&]+)#', $value, $match))
							{
								return '<input type="hidden" name="page" value="' . $match[1] . '">';
							}
						});
					$tpl->filter('number_format',	function ($value, $decimal = 0)		{ return $this->number_format($value, $decimal); });
					$tpl->filter('time_format',		function ($value)					{ return $this->sql_time_format($value); });

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

					if ($spare = ob_get_contents())
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

	function theme_template($section, $mod = ''): string
	{
		$theme_path		= Ut::join_path(THEME_DIR, $this->db->theme, 'appearance');
		$error			= $this->_t('ThemeCorrupt') . ': ' . $this->db->theme;

		return $this->include_buffered($section . $mod . '.php', $error, '', $theme_path);
	}

	// help action wrapper
	function help(string $info, string $action): string
	{
		return $this->action('help', ['info' => $info, 'action' => $action]);
	}

	/**
	* Invokes Action and returns its output.
	*
	* @param string		$action					Action name
	* @param array		$params					Action parameters
	* @param bool		$link_tracking			If value is TRUE then all links in the action will be tracked in the links_* tables.
	* 											Optional, default value is FALSE.
	* @return string	Result of action
	*/
	function action(string $action, array $params = [], bool $link_tracking = false): string
	{
		// remove invalid characters
		$action	= preg_replace('/[^' . self::PATTERN['ACTION'] . ']/u', '', $action);
		$action	= mb_strtolower(trim($action));
		$error	= '<em>' . $this->_t('UnknownAction') . ' <code>' . $action . '</code></em>';

		if (!$link_tracking)
		{
			$this->stop_link_tracking();
		}

		$result = $this->include_buffered($action . '.php', $error, $params, ACTION_DIR);

		$this->start_link_tracking();
		$this->http->no_cache();

		return $result;
	}

	function method($method): string
	{
		if (!($handler = $this->page['handler'] ?? null))
		{
			$handler = 'page';
		}

		$method_location	= Ut::join_path($handler, $method . '.php');
		$error				= '<em>' . $this->_t('UnknownMethod') . ' <code>' . $method_location . '</code></em>';

		$result				= $this->include_buffered($method_location, $error, '', HANDLER_DIR);

		return (!strncmp($result, ADD_NO_DIV, strlen(ADD_NO_DIV)))
			? mb_substr($result, strlen(ADD_NO_DIV))
			: '<div id="' . $handler . '">' . $result . "</div>\n";
	}

	// wrapper for the next method
	function format($text, $formatter = 'wiki', $options = []): string
	{
		return $this->_format($text, $formatter, $options);
	}

	function _format($text, $formatter, &$options): string
	{
		// remove invalid characters
		$formatter	= preg_replace('/[^' . self::PATTERN['FORMATTER'] . ']/u', '', $formatter);
		$formatter	= mb_strtolower(trim($formatter));
		$error		= '<em>' . Ut::perc_replace($this->_t('FormatterNotFound'), '<code>' . $formatter . '</code>') . '</em>';

		$text		= $this->include_buffered(Ut::join_path(FORMATTER_DIR, $formatter . '.php'), $error, compact('text', 'options'));

		if ($formatter == 'wacko' && $this->db->typografica)
		{
			$text = $this->include_buffered(Ut::join_path(FORMATTER_DIR, 'typografica.php'), $error, compact('text'));
		}

		return $text;
	}

	/**
	 * compile body
	 *
	 * renders body with [wacko|...] formatter
	 *
	 * @param string	$body
	 * @param int		$page_id
	 * @param bool		$paragrafica	disable paragrafica for comments and include action
	 * @param bool		$store			stores rendered body in database
	 *
	 * @return void|string
	 */
	function compile_body($body, $page_id = 0, $paragrafica = false, $store = false)
	{
		if (!$body)
		{
			return;
		}

		// build html body
		$body_r		= $this->format($body, 'wacko');
		$body_toc	= '';

		// build toc
		if ($this->db->paragrafica && $paragrafica)
		{
			$body_r		= $this->format($body_r, 'paragrafica');
			$body_toc	= $this->body_toc;
		}
		else
		{
			// remove obsolete <ignore> tags
			$body_r = str_replace(['<ignore>', '</ignore>'], '', $body_r);
		}

		// store to DB ($this->page['latest'] != 0)
		if ($store && $page_id)
		{
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'page SET ' .
					'body_r		= ' . $this->db->q($body_r) . ', ' .
					'body_toc	= ' . $this->db->q($body_toc) . ' ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
				'LIMIT 1');

			#$page = $this->load_page(null, $page_id, null, LOAD_NOCACHE);
		}

		return $body_r;
	}

	// SECTIONS

	/**
	 * Parses wikitext into sections, and either pull or replace some particular section's text.
	 *
	 * External callers should use the get_section and replace_section methods.
	 *
	 * Extracts body sections and optionaly merges all nested sections with the selected section.
	 * The section number 0 pulls the text before the first heading; other numbers will
	 * pull the given section along with its lower-level subsections.
	 *
	 * Section 0 is always considered to exist, even if it only contains the empty
	 * string.
	 *
	 * @param string		$body			wikitext
	 * @param int			$section_id		section number
	 * @param string		$mode			'get' or 'replace'
	 * @param array|false	$new_section	replacement array with [title, body] for section data
	 *
	 * @return array|null					section array with [level, title, body]
	 */
	function extract_sections($body, $section_id, $mode, $new_section = ''): ?array
	{
		/**
		 * [0] start
		 * -----------------
		 * [1] === (header level)
		 * [2] title
		 * [3] body
		 * -----------------
		 * ...
		 */
		// h2 - h6, syntax accepts also only two == closing signs
		// adds dummy \n before $body for regex to ensure section 0 before the first heading, strips it afterwards;
		// \n? would break matches with the delimiter inside the text itself
		$_body = preg_split("/\n[ \t]*(={3,7})(.*?)={2,7}/u", "\n" . $body, 0, PREG_SPLIT_DELIM_CAPTURE);

		# Ut::debug_print_r($_body);
		$a = 0;	// value [0|1|2]
		$s = 0;	// section_id
		$n = 0;

		foreach ($_body as $i => $value)
		{
			if ($i == 0)
			{
				$p[] = [
					'h'		=> 0,
					'body'	=> preg_replace("/^\n/", '', $value),	// strip dummy \n
					'title'	=> '',
				];
			}
			else
			{
				// reset after every third loop
				if ($n % 3 == 0)
				{
					$a = 0;
					$s++;
				}

				$name = match($a){
					0 => 'h',
					1 => 'title',
					2 => 'body',
				};

				$p[$s][$name]	= $value;

				$a++;
				$n++;
			}
		}

		unset($_body);

		// get body section with nested sections (smaller headers)
		$__body = [];

		foreach ($p as $sec => $value)
		{
			if ($sec < $section_id)
			{
				continue;
			}

			if ($sec == $section_id)
			{
				// get section level (smaller value means bigger header)
				$h_level	= substr_count($value['h'], '=');
				$__body[]	= $value['body'];
			}
			else if ($h_level < substr_count($value['h'], '='))
			{
				// merge nested sections
				if (!$new_section)
				{
					$__body[]	= "\n" . $value['h'] . $value['title'] . $value['h'];
					$__body[]	= $value['body'];
				}

				unset($p[$sec]);
			}
			else
			{
				break;
			}
		}

		if ($mode === 'replace' && $new_section)
		{
			// replace section
			$p[$section_id] = [
				'h'		=> $p[$section_id]['h'],
				'title'	=> $new_section['title'],
				'body'	=> "\n" . $new_section['body'],
			];
		}
		else
		{
			// merge selected section with nested sections
			$p[$section_id]['body'] = implode('', $__body);
		}

		// pull section
		if ($mode === 'get')
		{
			return $p[$section_id];
		}

		return $p;
	}

	/**
	 * Merges sections to wikitext
	 *
	 * Section number 0 contains the text before the first heading.
	 *
	 * @param array		$sections		array with section data [level, title, body]
	 *
	 * @return string					wikitext body
	 */
	function merge_sections($sections): string
	{
		$body	= [];

		foreach ($sections as $i => $section)
		{
			// set original line break
			// for first header, if section 0 is empty, there is none
			$nl = ($i == 1 && $sections[0]['body'] == '' ? '' : "\n");

			if ($section['title'])
			{
				$body[] = $nl . $section['h'] . $section['title'] . $section['h'];
			}

			$body[] = $section['body'];
		}

		unset($sections);

		return implode('', $body);
	}

	/**
	 * Returns the text of a section, specified by a number ($section_id).
	 * A section is text under a heading like == Heading ==, or
	 * the first section before any such heading (section 0).
	 *
	 * If a section contains subsections, these are also returned.
	 *
	 * @param string	$body			Wikitext to look in
	 * @param int		$section_id		Section identifier
	 *
	 * @return array|null				Section array with [level, title, body] of the requested section
	 */
	function get_section($body, $section_id): ?array
	{
		return $this->extract_sections($body, $section_id, 'get');
	}

	function replace_section($body, $section_id, $new_section): string
	{
		return $this->merge_sections(
			$this->extract_sections(
				$body,
				$section_id,
				'replace',
				$new_section)
			);
	}

	// GROUPS
	function load_usergroup($group_name, $group_id = 0)
	{
		return $this->db->load_single(
			'SELECT g.group_id, g.group_name, g.description, g.moderator_id, g.created, g.is_system, g.open, g.active, u.user_name AS moderator ' .
			'FROM ' . $this->prefix . 'usergroup g ' .
				'LEFT JOIN ' . $this->prefix . 'user u ON (g.moderator_id = u.user_id) ' .
			'WHERE ' . ( $group_id
				? 'g.group_id		= ' . (int) $group_id . ' '
				: 'g.group_name		= ' . $this->db->q($group_name) . ' ') .
			'LIMIT 1');
	}

	// USERS
	// check whether defined username is already registered.
	function user_name_exists($user_name): bool
	{
		if ($user_name == '')
		{
			return false;
		}

		// checking for identical name (case-insensitive, not BINARY)
		if ($this->db->load_single(
			'SELECT user_id ' .
			'FROM ' . $this->prefix . 'user ' .
			'WHERE user_name = ' . $this->db->q($user_name) . ' ' .
			'LIMIT 1'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// check whether email is already registered as one of user's email
	function email_exists($email): bool
	{
		return (bool) $this->db->load_single(
			'SELECT user_id ' .
			'FROM ' . $this->prefix . 'user ' .
			'WHERE email = ' . $this->db->q($email) . ' ' .
			'LIMIT 1');
	}

	/**
	 * Loads user data
	 *
	 * @param string $user_name
	 * @param number $user_id
	 *
	 * @return array
	 */
	function load_user($user_name, $user_id = 0): ?array
	{
		return $this->db->load_single(
			'SELECT
				u.user_id, u.user_name, u.real_name, u.password, u.email, u.account_status, u.account_type,
				u.enabled, u.signup_time, u.change_password, u.user_ip, u.email_confirm, u.last_visit,
				u.last_mark, u.login_count, u.password_request_count, u.failed_login_count, u.total_pages,
				u.total_revisions, u.total_comments, u.total_uploads,
				s.doubleclick_edit, s.show_comments, s.list_count, s.menu_items, s.user_lang, s.show_spaces, s.theme,
				s.autocomplete, s.numerate_links, s.diff_mode, s.notify_minor_edit, s.notify_page, s.notify_comment, s.dont_redirect,
				s.send_watchmail, s.show_files, s.allow_intercom, s.allow_massemail, s.hide_lastsession, s.validate_ip, s.noid_pubs,
				s.session_length, s.timezone, s.sorting_comments ' .
			'FROM ' . $this->prefix . 'user u ' .
				'LEFT JOIN ' . $this->prefix . 'user_setting s ON (u.user_id = s.user_id) ' .
			'WHERE ' . ($user_id
					? 'u.user_id		= ' . (int) $user_id . ' '
					: 'u.user_name		= ' . $this->db->q($user_name) . ' ') .
				'AND u.account_type = 0 ' .
			'LIMIT 1');
	}

	function get_user_name(): ?string
	{
		return $this->get_user_setting('user_name');
	}

	// anonymize user IP address
	function get_user_ip(): string
	{
		if ($this->db->anonymize_ip)
		{
			return '0.0.0.0';
		}
		else
		{
			return $this->http->ip;
		}
	}

	// extract user data from the session array
	function get_user()
	{
		return $this->sess->user_profile ?? null;
	}

	// insert user data into the session array
	function set_user($user): void
	{
		$this->sess->user_profile = $user;

		$this->set_user_setting('ip', $this->http->ip);

		$this->user_lang		= $this->get_user_language();
		$this->user_lang_dir	= static::get_direction($this->user_lang);
		$this->set_language($this->user_lang, true);

		$this->set_menu(MENU_USER);
	}

	// extract specific element from user session array
	function get_user_setting($setting, $guest = false)
	{
		if ($guest)
		{
			return @$this->sess->guest_profile[$setting];
		}
		else
		{
			return @$this->sess->user_profile[$setting];
		}
	}

	// set/update specific element of user session array
	// !!! BE CAREFUL NOT TO SAVE GUEST VALUES UNDER REGISTERED USER ARRAY !!!
	// this poses a potential security threat
	function set_user_setting($setting, $value, $guest = false): void
	{
		if ($guest)
		{
			$this->sess->guest_profile[$setting] = $value;
		}
		else if (@$this->sess->user_profile)
		{
			$this->sess->user_profile[$setting] = $value;
		}
	}

	function update_last_mark($user)
	{
		if ($user['user_id'])
		{
			return $this->db->sql_query(
				'UPDATE ' . $this->prefix . 'user SET ' .
					'last_mark = UTC_TIMESTAMP() ' .
				'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
				'LIMIT 1');
		}
	}

	function mark_read(&$user)
	{
		if (isset($_GET['markread']) && $user)
		{
			$this->update_last_mark($user);

			// requires UTC timestamps
			$tz = date_default_timezone_get();
			date_default_timezone_set('UTC');

			$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));

			date_default_timezone_set($tz);

			// return updated user settings
			$user = $this->get_user();
		}
	}

	function get_list_count(int $max): int
	{
		$user_max = $this->get_user_setting('list_count') ?? $this->db->list_count;

		$user_max = match(true)
		{
			$user_max <= 0		=> 10,
			$user_max > 100		=> 100,
			default				=> $user_max,
		};

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
	function create_auth_token($user): void
	{
		$session_days	= ($user['session_length'] > 0) ? $user['session_length'] : $this->db->session_length;
		$selector		= Ut::http64_encode(Ut::random_bytes(9));
		$authenticator	= Ut::random_bytes(33);
		$token_expires	= $this->db->date(time() + $session_days * DAYSECS);

		$this->sess->set_cookie(AUTH_TOKEN, $selector . Ut::http64_encode($authenticator), $session_days);

		$this->db->sql_query(
			'INSERT INTO ' . $this->prefix . 'auth_token SET ' .
				'selector			= ' . $this->db->q($selector) . ', ' .
				'token				= ' . $this->db->q(hash('sha256', $authenticator)) . ', ' .
				'user_id			= ' . (int) $user['user_id'] . ', ' .
				'token_expires		= ' . $this->db->q($token_expires)
			);
	}

	function check_auth_token()
	{
		if ($token = $this->sess->get_cookie(AUTH_TOKEN))
		{
			$selector		= substr($token, 0, 12);
			$authenticator	= substr($token, 12);

			$token = $this->db->load_single(
				'SELECT auth_token_id, token, user_id ' .
				'FROM ' . $this->prefix . 'auth_token ' .
				'WHERE selector = ' . $this->db->q($selector) . ' ' .
					'AND token_expires > UTC_TIMESTAMP() ' .
				'LIMIT 1');

			// STS check for expires also
			if ($token && $token['token'] === hash('sha256', Ut::http64_decode($authenticator)))
			{
				$this->db->sql_query(
					'UPDATE ' . $this->prefix . 'user SET ' .
						'last_visit = UTC_TIMESTAMP() ' .
					'WHERE ' .
						'user_id = ' . (int) $token['user_id'] . ' ' .
					'LIMIT 1');

				// re-create auth token on successful use, effectively prolonging it expiration
				$this->db->sql_query(
					'DELETE
					FROM ' . $this->prefix . 'auth_token
					WHERE auth_token_id = ' . (int) $token['auth_token_id']);

				if ($user = $this->load_user('', $token['user_id']))
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

	function delete_auth_token($user_id): void
	{
		// NB there can be many tokens for one user
		$this->db->sql_query(
			'DELETE
			FROM ' . $this->prefix . 'auth_token
			WHERE user_id = ' . (int) $user_id);
	}

	// user logs in by explicitly providing password
	function login_user($user, $remember_me = false): void
	{
		$this->soft_login($user);

		if ($remember_me)
		{
			$this->create_auth_token($user);
		}

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'last_visit					= UTC_TIMESTAMP(), ' .
				"change_password			= '', " .
				'login_count				= login_count + 1, ' .
				'failed_login_count			= 0, ' .
				'password_request_count		= 0 ' . // STS value unused
			'WHERE ' .
				'user_id					= ' . (int) $user['user_id'] . ' ' .
			'LIMIT 1');
	}

	function soft_login($user): void
	{
		$this->sess->restart();
		$this->sess->sticky_login = 1;
		$this->set_user($user);

		if ($this->db->login_notice)
		{
			$this->set_message(Ut::perc_replace($this->_t('WelcomeBack'), $user['user_name']), 'success');
		}
	}

	function session_notice($message): void
	{
		$lang			= !empty($this->user_lang) ? $this->user_lang : SYSTEM_LANG;
		$show_notice	=
				$this->db->session_notice == 1
			|| ($this->db->session_notice == 2 && $this->is_admin());

		if ($message == 'ip' & $show_notice)
		{
			$this->set_message(Ut::perc_replace(
				$this->_t('IPAddressChanged', $lang),
				$this->http->ip, implode(', ', array_keys($this->sess->sticky__ip))));
		}
		else if ($message && @$this->sess->sticky_login)
		{
			// Session terminated due to ...
			$tr = [
				'replay'		=> 'Replay',
				'obsolete'		=> 'Obsolete',
				'reg_expire'	=> 'Expired',
				'max_session'	=> 'Timeout',
				'max_idle'		=> 'Inactivity',
				'ua'			=> 'UaChange',
				'tls'			=> 'TLSChange',
				'ip'			=> 'IPChange',
			];

			if ($show_notice)
			{
				$this->set_message($this->_t('Session' . $tr[$message], $lang));
			}

			$this->sess->sticky_login = 0;
		}
	}

	// explicitly end user session and free session vars
	function logout_user(): void
	{
		if ($user = $this->get_user())
		{
			// we destroy ALL user's auth tokens - effectively enforce user to re-login thru password auth
			$this->delete_auth_token($user['user_id']);

			$this->sess->delete_cookie(AUTH_TOKEN);

			$this->sess->restart();
			$this->sess->sticky_login = 0;
			$this->set_menu(MENU_DEFAULT);
			$this->set_message($this->_t('LoggedOut'), 'success');
			$this->log(5, Ut::perc_replace($this->_t('LogUserLoggedOut', SYSTEM_LANG), $user['user_name']));
		}
	}

	// here we make all false login attempts last the same amount of time
	// to avoid timing attacks on valid usernames
	function login_delay($login_delay = 5): void // STS TODO configure
	{
		$exec_limit = ini_get('max_execution_time');
		set_time_limit(0);

		while (($sleep = round($login_delay - (microtime(true) - WACKO_STARTED))) > 0)
		{
			// Stall next login for a bit.
			// This will considerably slow down brute force attackers.
			usleep($sleep * 1000000);
		}

		set_time_limit($exec_limit);
	}
	// end auth token stuff

	// Increment the failed login count by 1
	function set_failed_login_count($user_id): void
	{
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user SET ' .
				'failed_login_count = failed_login_count + 1 ' .
			'WHERE user_id = ' . (int) $user_id . ' ' .
			'LIMIT 1');
	}

	function load_users($enabled = true): ?array
	{
		return $this->db->load_all(
			'SELECT user_id, user_name ' .
			'FROM ' . $this->prefix . 'user ' .
				($enabled
					? 'WHERE enabled = 1 '
					: '') .
			'ORDER BY user_name');
	}

	function get_user_id($user_name = ''): int
	{
		if ($user_name !== '')
		{
			$user = $this->db->load_single(
				'SELECT user_id ' .
				'FROM ' . $this->prefix . 'user ' .
				'WHERE user_name = ' . $this->db->q($user_name) . ' ' .
				'LIMIT 1', true);
		}
		else
		{
			$user = $this->get_user();
		}

		return (int) @$user['user_id']; // 0 if no such user
	}

	// Returns boolean indicating if the current user is allowed to see comments at all
	function user_allowed_comments(): bool
	{
		return $this->db->enable_comments && ($this->db->enable_comments != 2 || $this->get_user());
	}

	// COMMENTS AND COUNTS
	function load_comments($page_id, $limit = 0, $count = 30, $sort = 0, $deleted = false): ?array
	{
		// avoid results if $page_id is 0 (page does not exist)
		if ($page_id)
		{
			return $this->db->load_all(
				'SELECT p.page_id, parent_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.modified, p.body, p.body_r, p.page_lang, u.user_name, o.user_name as owner_name ' .
				'FROM ' . $this->prefix . 'page p ' .
					'LEFT JOIN ' . $this->prefix . 'user u ON (p.user_id = u.user_id) ' .
					'LEFT JOIN ' . $this->prefix . 'user o ON (p.owner_id = o.user_id) ' .
				'WHERE p.comment_on_id = ' . (int) $page_id . ' ' .
					($deleted
						? ''
						: 'AND p.deleted <> 1 ') .
				'ORDER BY p.created ' .
					($sort
						? 'DESC '
						: '') .
				"LIMIT {$limit}, {$count}");
		}
	}

	// ACCESS CONTROL
	function is_admin(): int
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

	function is_moderator(): bool
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

	function is_reviewer(): bool
	{
		if (!$this->get_user())
		{
			return false;
		}

		if (isset($this->db->groups['Reviewer']) && is_array($this->db->groups['Reviewer'])
			&& in_array($this->get_user_id(), $this->db->groups['Reviewer']))
		{
			return true;
		}

		return false;
	}

	/**
	 * checks if user is owner of the current page, or a page specified via $page_id
	 *
	 * @param int	$page_id
	 *
	 * @return bool	returns true
	 */
	function is_owner($page_id = null): bool
	{
		// check if user is logged in
		if (!$this->get_user())
		{
			return false;
		}

		// set default tag
		if (!$page_id)
		{
			$page_id = $this->page['page_id'] ?? null;
		}

		// check if user is owner
		return ($this->get_page_owner_id($page_id) == $this->get_user_id());
	}

	function get_page_owner($tag = '', $page_id = 0, $revision_id = null)
	{
		if (!($tag = trim($tag)))
		{
			if (!$revision_id)
			{
				return $this->page['owner_name'] ?? false;
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
		else
		{
			return false;
		}
	}

	function get_page_owner_id($page_id = null, $revision_id = null): ?int
	{
		if (!$page_id)
		{
			if (!$revision_id)
			{
				return $this->page['owner_id'] ?? null;
			}
			else
			{
				$page_id = $this->page['page_id'] ?? null;
			}
		}

		if (isset($this->owner_id_cache[$page_id]))
		{
			return (int) $this->owner_id_cache[$page_id];
		}
		else if ($page = $this->load_page('', $page_id, $revision_id, LOAD_CACHE, LOAD_META))
		{
			return (int) ($page['owner_id'] ?? null);
		}

		return null;
	}

	function set_page_owner($page_id, $user_id): void
	{
		// check if user exists
		if (!$this->load_user('', $user_id))
		{
			return;
		}

		// updated the latest revision with new owner
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'owner_id = ' . (int) $user_id . ' ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
			'LIMIT 1');
	}

	// ACLS

	function sanitize_acl_syntax($list): string
	{
		$lines	= explode("\n", $list);

		$_lines = array_map(
			function($lines) {
				return $this->sanitize_username($lines);
			},
			$lines
		);

		return implode("\n", $_lines);
	}

	// check for acl syntax errors
	function validate_acl_syntax($list, $privilege): bool
	{
		$error	= null;
		$lines	= explode("\n", $list);

		foreach ($lines as $line)
		{
			if (!( preg_match('/^([(\!)?' . self::PATTERN['USER_NAME_P'] . ']*)$/u', $line)
				|| preg_match('/^((\!)?[(\*|\$)])$/u', $line) ))
			{
				$error	.= '<code>' . $line . '</code><br>';
			}
		}

		if ($error)
		{
			$this->set_message($this->_t('AclSyntaxError') . ': <code>' . $privilege . '</code><br>' . $error, 'error');
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * get default page permissions
	 *
	 * @param string|null	$user_name
	 * @param int			$comment_on_id
	 *
	 * @return array		['read', 'write', 'comment', 'create', 'upload']
	 */
	function get_acl_defaults($user_name, $comment_on_id): array
	{
		$acl	= [];

		if (mb_strstr($this->context[$this->current_context], '/') && !$comment_on_id)
		{
			$root			= preg_replace('/^(.*)\\/([^\\/]+)$/u', '$1', $this->context[$this->current_context]);
			$root_id		= $this->get_page_id($root);
			$write_acl		= $this->load_acl($root_id, 'write');

			while (!empty($write_acl['default']) && $write_acl['default'] == 1)
			{
				$_root		= $root;
				$root		= preg_replace('/^(.*)\\/([^\\/]+)$/u', '$1', $root);

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
			// give comments the same read rights as their parent page
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

		return $acl;
	}

	function save_acl($page_id, $privilege, $list): void
	{
		$list = trim(str_replace("\r", '', $list));
		$list = $this->sanitize_acl_syntax($list);

		// validate
		if (!$this->validate_acl_syntax($list, $privilege))
		{
			return;
		}

		$this->db->sql_query('
			INSERT INTO ' . $this->prefix . 'acl (
				page_id,
				privilege,
				list
			)
			VALUES (
				' . (int) $page_id . ',
				' . $this->db->q($privilege) . ',
				' . $this->db->q($list) . '
			)
			ON DUPLICATE KEY UPDATE
				privilege	= VALUES(privilege),
				list		= VALUES(list)
		');
	}

	/**
	* Get ACL for tag from cache
	*
	* @param int		$page_id
	* @param string		$privilege		ACL privilege: read, write, comment, create, upload
	* @param bool		$use_defaults
	*
	* @return array		ACL
	*/
	function get_cached_acl($page_id, $privilege, $use_defaults): array
	{
		return $this->acl_cache[$page_id . '#' . $privilege . '#' . $use_defaults] ?? [];
	}

	/**
	* Add ACL to cache
	*
	* @param int		$page_id
	* @param string		$privilege		ACL privilege: read, write, comment, create, upload
	* @param bool		$use_defaults
	* @param array		$acl			Access control list
	*/
	function cache_acl($page_id, $privilege, $use_defaults, $acl): void
	{
		// $acl array must reflect acls table row structure
		$this->acl_cache[$page_id . '#' . $privilege . '#' . $use_defaults] = $acl;
	}

	/**
	 * loads related privileges at once in obj-cache
	 *
	 * @param array $page_ids
	 * @param array $privileges
	 */
	function preload_acl($page_ids, $privileges = ['read']): void
	{
		if (empty($page_ids))
		{
			return;
		}

		if ($privileges)
		{
			$default_privileges	= ['read', 'write', 'create', 'upload', 'comment'];

			foreach ($privileges as $privilege)
			{
				if (in_array($privilege, $default_privileges))
				{
					$q_privilege[]	= $this->db->q($privilege);
				}
			}
		}

		$page_ids = array_unique($page_ids);
		sort($page_ids);

		if ($acls = $this->db->load_all(
			'SELECT page_id, privilege, list ' .
			'FROM ' . $this->prefix . 'acl ' .
			'WHERE page_id IN (' . $this->ids_string($page_ids) . ') ' .
				($privileges
					? 'AND privilege IN ( ' . implode(', ', $q_privilege) . ' ) '
					: '')
			, true))
		{
			foreach ($acls as $acl)
			{
				$this->cache_acl($acl['page_id'], $acl['privilege'], 1, $acl);
			}
		}
	}

	/**
	* Load ACL
	*
	* @param int		$page_id
	* @param string		$privilege		ACL privilege: read, write, comment, create, upload
	* @param bool		$use_defaults
	* @param bool		$use_cache
	* @param bool		$use_parent
	* @param string		$new_tag
	*
	* @return array		$acl			Access control list
	*/
	function load_acl($page_id, $privilege, $use_defaults = true, $use_cache = true, $use_parent = true, $new_tag = ''): array
	{
		$acl = [];

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
						'SELECT page_id, privilege, list ' .
						'FROM ' . $this->prefix . 'acl ' .
						'WHERE page_id = ' . (int) $page_id . ' ' .
							'AND privilege = ' . $this->db->q($privilege) . ' ' .
						'LIMIT 1');
				}

				// if still no acl, use config defaults
				if (!$acl && $use_defaults)
				{
					// First look for parent ACL, so that clusters/subpages
					// work correctly.
					if (!empty($page_id))
					{
						$tag = $this->get_page_tag($page_id);
					}
					else
					{
						// new page which is to be created
						$tag = $new_tag;
					}

					if ($parent_id = $this->get_parent_id($tag))
					{
						// By letting it fetch defaults, it will automatically recurse
						// up the tree of parent pages... fetching the ACL on the root
						// page if necessary.
						$acl = $this->load_acl($parent_id, $privilege);
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
	 * @param string	$privilege
	 * @param int		$page_id
	 * @param string	$user_name
	 * @param bool		$use_parent
	 * @param string	$new_tag
	 *
	 * @return bool
	 */
	function has_access($privilege, $page_id = null, $user_name = '', $use_parent = true, $new_tag = ''): bool
	{
		if (!$user_name)
		{
			$user_name = mb_strtolower(($this->get_user_name() ?? ''));
		}

		if (!($page_id = (int) $page_id))
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
		$acl		= $this->load_acl($page_id, $privilege, true, true, $use_parent, $new_tag);
		// cache
		$this->acl	= $acl;

		// locked down to read only
		if ($this->db->acl_lock && $privilege != 'read')
		{
			return false;
		}

		// if current user is owner or admin, return true. they can do anything!
		if (!in_array($user_name, ['', GUEST])
			&& ($this->is_owner($page_id) || $this->is_admin()))
		{
			$acl = explode("\n", $this->acl['list']);

			if (!in_array('*', $acl) && !in_array('$', $acl))
			{
				$this->acl['list']	.= (!empty($this->acl['list']) ? "\n" : '') . $user_name;
			}

			return true;
		}

		return isset($acl['list'])
			&& $this->check_acl($user_name, $acl['list'], true);
	}

	/**
	 *
	 * @param string	$user_name
	 * @param string	$acl_list
	 * @param bool		$copy_to_this_acl
	 *
	 * @return bool
	 */
	function check_acl($user_name, $acl_list, $copy_to_this_acl = false): bool
	{
		if (is_array($user_name))
		{
			$user_name = $user_name['user_name'];
		}

		if (!$user_name)
		{
			$user_name = GUEST;
		}

		$user_name = mb_strtolower($user_name);

		// replace groups
		$acl = str_replace(' ', '', mb_strtolower($this->replace_aliases($acl_list)));

		if ($copy_to_this_acl)
		{
			$this->acl['list'] = $acl;
		}

		$acls = "\n" . $acl . "\n";

		if ($user_name == GUEST || $user_name == '')
		{
			if (($pos = mb_strpos($acls, '*')) === false)
			{
				return false;
			}

			if ($acls[$pos - 1] != '!')
			{
				return true;
			}

			return false;
		}

		$u_pos	= mb_strpos($acls, "\n" . $user_name . "\n");
		$au_pos	= mb_strpos($acls, "\n!" . $user_name . "\n");
		$s_pos	= mb_strpos($acls, '*');
		$b_pos	= mb_strpos($acls, '$');

		if ($au_pos !== false)
		{
			return false;
		}

		if ($u_pos !== false)
		{
			return true;
		}

		if ($s_pos !== false)
		{
			if ($acls[$s_pos - 1] == '!')
			{
				return false;
			}
		}

		if ($b_pos !== false)
		{
			if ($acls[$b_pos - 1] == '!')
			{
				return false;
			}
		}

		if ($s_pos !== false)
		{
			return true;
		}

		if ($b_pos !== false)
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
			$aliases[mb_strtolower($key)] = $val;
		}

		do
		{
			$list		= [];
			$lines		= explode("\n", $acl);
			$replaced	= 0;

			foreach ($lines as $line)
			{
				$line_lo = $line;

				// check for inversion character "!"
				if (preg_match('/^\!(.*)$/u', $line, $matches))
				{
					$negate		= 1;
					$line_lo	= $matches[1];
				}
				else
				{
					$negate		= 0;
				}

				$line_lo = mb_strtolower(trim($line_lo));

				if (isset($aliases[$line_lo]))
				{
					foreach (explode("\\n", $aliases[$line_lo]) as $item)
					{
						$item	= trim($item);
						$list[]	= ($negate ? '!' : '') . $item;
					}

					$replaced++;
				}
				else
				{
					$list[] = $line;
				}
			}

			$acl = implode("\n", $list);
		}

		while ($replaced > 0);

		return $acl;
	}

	// check if user has the right to upload files
	function can_upload($global = false): bool
	{
		$user_name		= GUEST;
		$registered		= false;

		if ($this->get_user())
		{
			$user_name		= mb_strtolower($this->get_user_name());
			$registered		= true;
		}

		if ($registered)
		{
			if ($global)
			{
				return
					(  $this->db->upload === true
					|| $this->db->upload == 1
					|| ($this->db->upload && $this->is_admin())
					|| $this->check_acl($user_name, $this->db->upload)
					);
			}
			else
			{
				return
					(  $this->db->upload === true
					|| $this->db->upload == 1
					|| ($this->db->upload && $this->is_admin())
					|| $this->check_acl($user_name, $this->db->upload) )
					&& (   $this->has_access('upload')
						&& $this->has_access('write')
						&& $this->has_access('read')
						|| $this->is_owner()
						|| $this->is_admin() )
						|| (isset($_POST['upload_to']) && $_POST['upload_to'] == 'global' // for action -> upload handler
					);
			}
		}
		else
		{
			return false;
		}
	}

	function show_access_mode($page_id = null, $tag = '',  $privilege = 'read'): string
	{
		if (!$page_id)	{$page_id	= $this->page['page_id']	?? null;}
		if (!$tag)		{$tag		= $this->page['tag']		?? null;}

		$user		= $this->get_user();
		$link		= $this->href('permissions', $tag);

		$acl_modes = [
			'denied'		=> 'AccessDenied',
			'public'		=> 'AccessPublic',
			'registered'	=> 'AccessRegistered',
			'private'		=> 'AccessPrivate',
			'custom'		=> 'AccessCustom',
		];

		// load $this->acl['list'] for specified privilege
		$access		= $this->has_access($privilege, $page_id);
		$acl		= [];
		$acl		= explode("\n", $this->acl['list']);

		if (in_array('', $acl))
		{
			$mode = 'denied';
		}
		else if (in_array('*', $acl))
		{
			$mode = 'public';
		}
		else if (in_array('$', $acl))
		{
			$mode = 'registered';
		}
		else if (in_array(mb_strtolower($user['user_name']), $acl) && count($acl) == 1)
		{
			$mode = 'private';
		}
		else
		{
			$mode = 'custom';
		}

		return
			'<a href="' . $link . '" title="' . $this->_t('AccessMode') . '" class="tag acl-' . $mode . '">' .
				$this->_t($acl_modes[$mode]) .
			'</a>';
	}

	// WATCHES
	function is_watched($user_id, $page_id)
	{
		return $this->db->load_single(
			'SELECT watch_id, comment_id, pending ' .
			'FROM ' . $this->prefix . 'watch ' .
			'WHERE user_id		= ' . (int) $user_id . ' ' .
				'AND page_id	= ' . (int) $page_id . ' ' .
			'LIMIT 1');
	}

	function set_watch($user_id, $page_id): void
	{
		// remove old watch first to avoid double watches
		$this->clear_watch($user_id, $page_id);

		if ($this->has_access('read', $page_id))
		{
			$this->db->sql_query(
				'INSERT INTO ' . $this->prefix . 'watch (user_id, page_id, watch_time) ' .
				'VALUES (	' . (int) $user_id . ',
							' . (int) $page_id . ',
							UTC_TIMESTAMP())');
		}
	}

	function clear_watch($user_id, $page_id)
	{
		return $this->db->sql_query(
			'DELETE FROM ' . $this->prefix . 'watch ' .
			'WHERE user_id		= ' . (int) $user_id . ' ' .
				'AND page_id	= ' . (int) $page_id);
	}

	function clear_watch_pending($user_id, $page_id)
	{
		return $this->db->sql_query(
			'UPDATE ' . $this->prefix . 'watch SET ' .
				'pending = 0 ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
				'AND user_id = ' . (int) $user_id);
	}

	function set_watch_pending($user_id, $page_id)
	{
		return $this->db->sql_query(
			'UPDATE ' . $this->prefix . 'watch SET ' .
				'pending	= 1 ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
				'AND user_id = ' . (int) $user_id);
	}

	// REVIEW
	function set_review($reviewer_id, $page_id)
	{
		// set / unset review
		if ($this->has_access('read', $page_id))
		{
			$reviewed = !$this->page['reviewed'];

			return $this->db->sql_query(
				'UPDATE ' . $this->prefix . 'page SET ' .
					'reviewed		= ' . (int) $reviewed . ', ' .
					'reviewed_time	= UTC_TIMESTAMP(), ' .
					'reviewer_id	= ' . (int) $reviewer_id . ' ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
				'LIMIT 1');
		}
		else
		{
			return false;
		}
	}

	// MENUS
	function get_default_menu($lang = ''): array
	{
		if (!$lang)
		{
			$lang = $this->get_user_language();
		}

		$user_id = $this->db->system_user_id;

		return $this->get_user_menu($user_id, $lang, true);
	}

    function get_user_menu($user_id, $lang = '', $public = false): array
    {
        $user_menu_formatted = [];

        // avoid results if $user_id is 0 (user does not exist)
        if ($user_id)
        {
            $this->get_user_id() > 1        // can't use $user_id here as the function get_user_menu() called once for registered user, and if he has no menu, called again for system user id = 1. Registered users have id > 1, anonymous users have id = 1.
                ? $rights = "(a.list = '*' OR a.list = '$')"        // registered users can see read * (public) and $ (for registered users) ACL pages in the default top menu
                : $rights = "a.list = '*'";                         // anonymous users can see only read * (public) ACL pages in the default top menu

            $user_menu = $this->db->load_all(
                'SELECT p.page_id, p.tag, p.title, m.menu_title, m.menu_lang ' .
                'FROM ' . $this->prefix . 'menu m ' .
                    ($public
                        ? 'LEFT JOIN ' . $this->prefix . 'acl a ON (m.page_id = a.page_id) '
                        : '') .
                'LEFT JOIN ' . $this->prefix . 'page p ON (m.page_id = p.page_id) ' .
                'WHERE m.user_id = ' . (int) $user_id . ' ' .
                    ($lang
                        ? 'AND m.menu_lang = ' . $this->db->q($lang) . ' '
                        : '') .
                    ($public
                        ? "AND a.privilege = 'read' " .
                          "AND " . $rights . " " // assumes '*' for anonymous, '*' and '$' for registered users 
                        : '') .
                'ORDER BY m.menu_position', true);

            foreach ($user_menu as $menu_item)
            {
                $title = $menu_item['menu_title'];

                if ($title === '')
                {
                    $title = $menu_item['title'];
                }

                // [0] - page_id
                // [1] - menu_title
                // [2] - menu_item formatted ((tag menu_title))
                // [3] - menu_lang
                $user_menu_formatted[] = [
                    $menu_item['page_id'],
                    (($title !== '')? $title : $menu_item['tag']),
                    '((' . $menu_item['tag'] .
                    (($title !== '')? ' ' . $title : '') .
                    '))',
                    $menu_item['menu_lang'],
                ];
            }
        }

        return $user_menu_formatted;
    }

	function set_menu($set = MENU_AUTO, $update = false): void
	{
		$menu_page_ids	= $this->sess->menu_page_id ?? [];
		$menu_formatted	= $this->sess->menu ?? [];

		$user			= $this->get_user();

		// update menu if guest client language has changed
		if (isset($this->sess->menu_lang) && $this->sess->menu_lang != $this->user_lang)
		{
			$menu_formatted = [];
		}

		// initial menu table construction
		if ($set != MENU_AUTO || !($menu_formatted || $update))
		{
			$menu = 0;

			if (isset($user['user_id']) && $set != MENU_DEFAULT)
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
		if (@$_GET['addbookmark'] && $user && !empty($this->page['page_id']))
		{
			unset($_GET['addbookmark']);

			// writing menu item
			if (!in_array($this->page['page_id'], $menu_page_ids))
			{
				$position = $this->db->load_single(
					'SELECT MAX(m.menu_position) AS max_position ' .
					'FROM ' . $this->prefix . 'menu m ' .
					'WHERE m.user_id = ' . (int) $user['user_id'] . ' ', false);

				$position = (int) $position['max_position'];

				if (!$position)
				{
					// prepopulate user menu with default menu items
					foreach ($menu_formatted as $menu_item)
					{
						$this->db->sql_query(
							'INSERT INTO ' . $this->prefix . 'menu SET ' .
								'user_id			= ' . (int) $user['user_id'] . ', ' .
								'page_id			= ' . (int) $menu_item[0] . ', ' .
								'menu_lang			= ' . $this->db->q($menu_item[3]) . ', ' .
								'menu_title			= ' . $this->db->q($menu_item[1]) . ', ' .
								'menu_position		= ' . ++$position);
					}

					$this->sess->menu_default = false;
				}

				$title				= $this->get_page_title();
				$lang				= $this->page_lang; // TODO: case -> What if the page_lang of the page itself changes?
				$menu_page_ids[]	= $this->page['page_id'];
				$menu_formatted[]	= [
										$this->page['page_id'],
										($title ?: $this->tag),
										$this->format('((' . $this->tag . ($title? ' ' . $title : '') . '))', 'wacko'),
										$lang,
									];

				$this->db->sql_query(
					'INSERT INTO ' . $this->prefix . 'menu SET ' .
						'user_id			= ' . (int) $user['user_id'] . ', ' .
						'page_id			= ' . (int) $this->page['page_id'] . ', ' .
						'menu_lang			= ' . $this->db->q($lang) . ', ' .
						#"menu_title			= " . $this->db->q($title) . ", " .
						'menu_position		= ' . ++$position);
			}
		}

		// removing menu item
		if (@$_GET['removebookmark'] && $user && !$this->sess->menu_default)
		{
			unset($_GET['removebookmark']);

			// rewriting menu table except containing current page tag
			$prev			= $menu_formatted;
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
				'DELETE FROM ' . $this->prefix . 'menu ' .
				'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
					'AND page_id = ' . (int) $this->page['page_id']);

			if (!$menu_formatted)
			{
				$this->set_menu(MENU_DEFAULT);
			}
		}

		$this->sess->menu			= $menu_formatted;
		$this->sess->menu_lang		= $this->user_lang;
		$this->sess->menu_page_id	= $menu_page_ids;
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

	// TODO:
	//	- comments, system pages, methods (?)
	//	- url arguments ?profile= ['page_id', 'arguments']
	//	- add parameter for trail size in user settings ?
	// parse only once, without included pages (avoid call in run function!)
	//		$size	=
	function set_user_trail($size = 5): void
	{
		$page_id = $this->page['page_id'];

		if ($size)
		{
			if (isset($this->sess->user_trail))
			{
				$count = count($this->sess->user_trail);

				if (!(isset($this->sess->user_trail[$count - 1][0])
					&&      $this->sess->user_trail[$count - 1][0] == $page_id))
				{
					// this is about navigation, remove double entries
					foreach ($this->sess->user_trail as $link)
					{
						if ($page_id != $link[0])
						{
							$trail[] = $link;
						}
					}

					if (count($trail) > $size)
					{
						$trail	= array_slice($trail, -$size);
					}

					$trail[-1]					= [$page_id, $this->page['tag'], $this->page['title']];
					$this->sess->user_trail		= $trail;
				}
			}
			else
			{
				$this->sess->user_trail[] = [$page_id, $this->page['tag'], $this->page['title']];
			}
		}
	}

	// user trail navigation
	//		call this function in your theme header or footer
	//		$separator	= &gt; »
	function get_user_trail($title = false, $separator = ' &gt; ', $linking = true, $size = null): string
	{
		// don't call this inside the run function, it will also write all included pages
		// in the user trail because the engine parses them before it includes them
		$this->set_user_trail($size);

		if (isset($this->sess->user_trail))
		{
			$result		= [];
			$size		= (int) $size + 1;
			$i			= 0;

			foreach ($this->sess->user_trail as $link)
			{
				if ($i < $size)
				{
					$item = $title ? $link[2] : $link[1];

					if ($linking
						&& (	$this->page['page_id'] != $link[0]
							|| ($this->page['page_id'] == $link[0]) && $this->method != 'show'))
					{
						$item = $this->link($link[1], '', $item);
					}

					$result[] = '<bdi>' . $item . '</bdi>';
				}

				$i++;
			}

			return implode($separator, $result);
		}
	}

	// MAINTENANCE
	function maintenance(): void
	{
		$now	= time();
		$update	= [];

		// purge referrers (once a day)
		if (($days = $this->db->referrers_purge_time) > 0
				&& $now > $this->db->maint_last_refs)
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'referrer ' .
				'WHERE referrer_time < DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . (int) $days . ' DAY)');

			$update['maint_last_refs'] = $now + 1 * DAYSECS;
			$this->log(7, $this->_t('LogReferrersPurged', SYSTEM_LANG));
		}

		// purge outdated pages revisions (once a week)
		if (($days = $this->db->pages_purge_time) > 0
				&& $now > $this->db->maint_last_oldpages)
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'revision ' .
				'WHERE modified < DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . (int) $days . ' DAY)');

			$update['maint_last_oldpages'] = $now + 7 * DAYSECS;
			$this->log(7, $this->_t('LogRevisionsPurged', SYSTEM_LANG));
		}

		// purge deleted pages (once per 3 days)
		if (($days = $this->db->keep_deleted_time) > 0
			&& $now > $this->db->maint_last_delpages)
		{
			[$pages, ] = $this->load_deleted_pages(1000, 0);

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
				$this->log(7, $this->_t('LogDeletedPagesPurged', SYSTEM_LANG));
			}

			$update['maint_last_delpages'] = $now + 3 * DAYSECS;
		}

		// purge system log entries (once per 3 days)
		if (($days = $this->db->log_purge_time) > 0
			&& $now > $this->db->maint_last_log)
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'log ' .
				'WHERE log_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL ' . (int) $days . ' DAY )');

			$update['maint_last_log'] = $now + 3 * DAYSECS;

			$this->log(7, $this->_t('LogSystemLogPurged', SYSTEM_LANG));
		}

		// remove outdated pages cache, purge sql cache (once per hour)
		if ($now > $this->db->maint_last_cache)
		{
			// pages cache
			if (($ttl = $this->db->cache_ttl) > 0)
			{
				// clear from db
				$this->db->sql_query(
					'DELETE FROM ' . $this->prefix . 'cache ' .
					'WHERE cache_time < DATE_SUB( UTC_TIMESTAMP(), INTERVAL ' . (int) $ttl . ' SECOND )');

				if (Ut::purge_directory(CACHE_PAGE_DIR, $ttl))
				{
					$this->log(7, $this->_t('LogCachedPagesPurged', SYSTEM_LANG));
				}
			}

			// sql query cache
			if (($ttl = $this->db->cache_sql_ttl) > 0)
			{
				if (Ut::purge_directory(CACHE_SQL_DIR, $ttl))
				{
					$this->log(7, $this->_t('LogSqlCachePurged', SYSTEM_LANG));
				}
			}

			$update['maint_last_cache'] = $now + 3600;
		}

		// purge expired cookie_tokens (once per 3 days)
		if ($now > $this->db->maint_last_session)
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'auth_token ' .
				'WHERE token_expires < UTC_TIMESTAMP()');

			$update['maint_last_session'] = $now + 3 * DAYSECS;
			$this->log(7, $this->_t('LogExpiredTokensPurged', SYSTEM_LANG));
		}

		$this->db->_set($update);
	}

	// MAIN EXECUTION ROUTINE
	function run($tag, $method): void
	{
		$this->http->cache_promisc();

		// mandatory tls?
		if ($this->db->tls_implicit && !$this->http->tls_session)
		{
			$this->http->ensure_tls($this->href($method, $tag));
		}

		// clean _POST without csrf token
		$this->validate_post_token($tag);

		$user	= [];

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
		if ($this->get_user_setting('validate_ip') && $this->get_user_setting('ip') != $this->http->ip)
		{
			// TODO: set and load lang??
			$this->log(1, '<strong><span class="cite">' . Ut::perc_replace(
					$this->_t('LogUserIPSwitched', SYSTEM_LANG),
					'<code>' . $this->get_user_setting('user_name') . '</code>',
					'<code>' . $this->get_user_setting('ip') . '</code>',
					'<code>' . $this->http->ip . '</code>'
					) . '</span></strong>');
			$this->logout_user();
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
		if (!empty($user['theme']))
		{
			$this->db->theme		= $user['theme'];
			$this->db->theme_url	= $this->db->base_path . Ut::join_path(THEME_DIR, $this->db->theme) . '/';
		}

		$this->user_lang		= $this->get_user_language();
		$this->user_lang_dir	= static::get_direction($this->user_lang);
		$this->set_language($this->user_lang, true);

		// SEO
		if (isset($_SERVER['HTTP_USER_AGENT']))
		{
			# preg_match('/robot|spider|crawler|curl|^$/i', $_SERVER['HTTP_USER_AGENT']));
			foreach ($this->search_engines as $engine)
			{
				if (stristr($_SERVER['HTTP_USER_AGENT'], $engine))
				{
					$this->resource['OuterLink2']	= '';
					$this->resource['Icon.Outer']	= '';
				}
			}
		}

		$page = $this->get_page($tag, $method);

		// create $this->page
		$this->set_page($page); // the only call

		if ($this->db->enable_referrers)
		{
			$this->log_referrer();
		}

		$this->set_menu();
		$this->set_page_settings();

		$this->charset = $this->get_charset();

		if (!$user && isset($this->page['modified']))
		{
			header('Last-Modified: ' . Ut::http_date(strtotime($this->page['modified']) + 120));
		}

		if ($user && isset($this->page['page_id']))
		{
			$this->watch = $this->is_watched($user['user_id'], $this->page['page_id']);
		}

		// check page watching
		$this->is_watched =
			($user
			&& $this->page
			&& (isset($this->watch['watch_id']) && $this->watch['watch_id']));

		// check revision hideing (1 - guests, 2 - registered users)
		$this->hide_revisions =
			($this->page
			&& !$this->is_admin()
			&& (   ($this->db->hide_revisions == 1 && !$this->get_user())
				|| ($this->db->hide_revisions == 2 && !$this->is_owner())));

		// forum page
		$this->forum =
			(bool) (preg_match('/' . $this->db->forum_cluster . '\/.+?\/.+/u', $this->tag)
			|| (isset($this->page['comment_on_id']) && $this->page['comment_on_id']
				? preg_match('/' . $this->db->forum_cluster . '\/.+?\/.+/u', $this->get_page_tag($this->page['comment_on_id']))
				: ''));

		// display page contents
		if (str_ends_with($this->method, '.xml'))
		{
			echo $this->method($this->method);
		}
		else
		{
			$mode = match($this->method) {
				'print'				=> 'print',
				'wordprocessor'		=> 'wordprocessor',
				default				=> '',
			};

			// preload all links
			if (in_array($this->method, ['print', 'show', 'wordprocessor']))
			{
				$this->preload_links([($this->page['page_id'] ?? null)], true);
			}
			// preload only default links
			else
			{
				$this->preload_links([], true);
			}

			$this->current_context++;
			$this->context[$this->current_context] = $this->tag;
			$data = $this->method($this->method);
			$this->current_context--;

			echo
				$this->theme_template('header', $mode) .
				$data .
				$this->theme_template('footer', $mode);
		}

		// goback feature
		if ($this->page && !$this->no_way_back && $this->tag != $this->db->root_page)
		{
			$this->sess->sticky_goback = $this->underscore_url($this->tag);
		}

		// NB: never been here if redirect() called!
		$this->write_sitemap();
	}

	function get_page($tag, $method)
	{
		$page = 0;

		// permalink
		if ($method == 'hashid')
		{
			$method			= '';
			$ids			= explode('x', $tag);

			$revision_id	= $this->db->load_single(
				'SELECT revision_id ' .
				'FROM ' . $this->prefix . 'revision ' .
				'WHERE page_id = ' . (int) $ids[0] . ' ' .
					'AND version_id = ' . (int) $ids[1] . ' ' .
				'LIMIT 1');

			$revision_id	= $revision_id ? $revision_id['revision_id'] : 0;
			$page			= $this->load_page('', $ids[0], $revision_id, null, null, $this->is_admin());

			if ($page)
			{
				$this->method			= 'show';
				$this->tag				= $page['tag'];
				$_GET['revision_id']	= $revision_id;
			}
		}

		if (!$page)
		{
			if (!($this->method = trim($method)))
			{
				$this->method = 'show';
			}

			// normalize & sanitize tag name
			$this->sanitize_page_tag($tag);

			$revision_id	= (int) ($_GET['revision_id'] ?? '');
			$deleted		= $this->is_admin();

			// load page
			$page			= $this->load_page($tag, 0, $revision_id, null, null, $deleted);

			// no available revision
			if ($revision_id && empty($page['tag']))
			{
				$page		= $this->load_page($tag, 0, 0, null, null, $deleted);
			}

			// invalid namespace
			if (empty($page) && !$tag)
			{
				$this->http->status(404);
				$this->set_message($this->_t('InvalidNamespace'), 'error');
				$this->ensure_page();
			}

			$this->tag		= $tag;
		}

		return $page;
	}

	function set_page_settings(): void
	{
		if ($this->page)
		{
			// override with perpage settings
			$page_options = [
				'allow_rawhtml',
				'disable_safehtml',
				'footer_comments',
				'footer_files',
				'hide_index',
				'hide_toc',
				'theme',
				'tree_level',
				'typografica',
			];

			foreach ($page_options as $key)
			{
				// ignore perpage page settings with empty / null as value
				if (!Ut::is_empty($val = $this->page[$key]))
				{
					$this->db[$key] = $val;
				}
			}

			if ($this->page['theme'])
			{
				$this->db->theme_url = $this->db->base_path . Ut::join_path(THEME_DIR, $this->db->theme) . '/';
				// reload theme language files
				$this->set_language($this->user_lang, true, false, true);
			}

			// set page categories, this defines the $categories object property array
			$categories = $this->load_categories($this->page['page_id']);

			foreach ($categories as $word)
			{
				$this->categories[OBJECT_PAGE][$word['category_id']] = $word['category'];
			}

			unset($categories, $word);
		}
	}

	// TOC MANIPULATIONS
	function set_toc_array($toc): void
	{
		$this->body_toc = '';

		foreach ($toc as $k => $v)
		{
			$toc[$k] = implode('<h-item>', $v);
		}

		// the last <h-end> ensures there is no empty body_toc in database
		$this->body_toc = implode('<h-end>' . "\n", $toc) . '<h-end>' . "\n";
	}

	function build_toc($tag, $from, $to, $link = -1)
	{
		$_toc = [];

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

		$page['body_toc']	= $page['body_toc'] ?? '';
		$toc				= explode('<h-end>' . "\n", $page['body_toc']);

		foreach ($toc as $k => $toc_item)
		{
			$toc[$k] = explode('<h-item>', $toc_item);
		}

		foreach ($toc as $k => $toc_item)
		{
			if (isset($toc_item[2]))
			{
				// '(include)' - included toc
				if ($toc_item[2] == IS_INCLUDE)
				{
					if (!in_array($toc_item[0], $this->toc_context))
					{
						if ($toc_item[0] != $this->tag)
						{
							$this->toc_context[] = $toc_item[0];
							$_toc = array_merge($_toc, $this->build_toc($toc_item[0], $from, $to, $link));
							array_pop($this->toc_context);
						}
					}
				}
				else
				{
					// '(p)' - paragraph
					if ($toc_item[2] == IS_PARAGRAPH)
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
			//	notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback(
				"!(<h(\d) id=\"(h\d+-\d+)\" class=\"heading\">(.*?)" .
					"<a class=\"self-link\" href=\"#h\d+-\d+\"></a>)!i",
				[&$this, 'numerate_toc_callback_toc'], $what);
		}

		if (isset($this->post_wacko_action['p']))
		{
			// #2. find all <p id="p1249-1" class="auto"> & guide them in subroutine
			//	notice that complex regexp is copied & duplicated in formatter/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<p id=\"(p\d+-\d+)\" class=\"auto\">(.+?)</p>)!is",
				[&$this, 'numerate_toc_callback_p'], $what);
		}

		return $what;
	}

	function numerate_toc_callback_toc($matches): string
	{
		return
			'<h' . $matches[2] . ' id="' . $matches[3] . '" class="heading">' .
				($this->post_wacko_toc_hash[$matches[3]][1] ?? $matches[4]) .
				'<a class="self-link" href="#' . $matches[3] . '"></a>';
	}

	function numerate_toc_callback_p($matches): string
	{
		if (!($style = $this->paragrafica_styles[$this->post_wacko_action['p']]))
		{
			$this->post_wacko_action['p'] = 'before';
			$style = $this->paragrafica_styles['before'];
		}

		$len	= strlen((string) $this->post_wacko_maxp);
		$link	= '<a href="#' . $matches[2] . '">' .
					utf8_str_pad($this->post_wacko_toc_hash[$matches[2]][66], $len, '0', STR_PAD_LEFT) .
				  '</a>';

		foreach ($this->paragrafica_patches[$this->post_wacko_action['p']] as $v)
		{
			$style[$v] = str_replace('##', $link, $style[$v]);
		}

		return
			$style['_before'] .
			'<p id=' . $matches[2] . ' class="auto">' .
				$style['before'] . $matches[3] . $style['after'] .
			'</p>' .
			$style['_after'];
	}

	// BREADCRUMBS -- navigation inside WackoClusters
	function get_page_path($tag = '', $titles = false, $separator = '/', $linking = true, $root_page = false): string
	{
		$tag		??= $this->tag;
		$result		= [];
		$is_root	= false;

		// check if current page is home page
		if ($this->db->root_page == $this->tag)
		{
			$is_root = true;
		}

		// adds home page in front of breadcrumbs or current page is home page
		if ($is_root || $root_page)
		{
			$result[] = $this->compose_link_to_page($this->db->root_page);
		}

		if (!$is_root)
		{
			$link = '';

			foreach (explode('/', $tag) as $n => $step)
			{
				if ($link)
				{
					$link .= '/';
				}

				$link .= $step;

				// skip if current page is home page
				if ($root_page && $n < 1 && !strcasecmp($this->db->root_page, $step))
				{
					continue;
				}

				$item = $titles? $this->get_page_title($link) : $this->add_spaces($step);

				if ($linking
					&& (	$link != $this->tag
						|| ($link == $this->tag && $this->method != 'show')))
				{
					$item = $this->link($link, '', $item);
				}
				else
				{
					$item = $this->add_spaces($item);
				}

				$result[] = '<bdi>' . $item . '</bdi>';
			}
		}

		return implode($separator, $result);
	}

	// $page_id is preferred, $tag next
	function get_page_title($tag = '', $page_id = 0): string
	{
		$tag = utf8_trim($tag, '/');

		if ($tag || $page_id)
		{
			$page = $this->db->load_single(
				'SELECT title ' .
				'FROM ' . $this->prefix . 'page ' .
				'WHERE ' . ($page_id
					? 'page_id	= ' . (int) $page_id . ' '
					: 'tag		= ' . $this->db->q($tag) . ' ') .
				'LIMIT 1');

			$title = $page['title'] ?? null;
		}
		else if ($this->page)
		{
			$title = @$this->page['title'];
		}

		// default page title is just page's WikiName
		return $title
				?: $this->create_title_from_tag(($tag ?: $this->tag));
	}

	// creates page title from tag: /Path/To/WikiName -> Wiki Name
	function create_title_from_tag($tag): string
	{
		return $this->add_spaces_title(utf8_trim(mb_substr($tag, mb_strrpos($tag, '/')), '/'));
	}

	// CLONE / RENAMING / MOVING

	function clone_page($tag, $clone_tag, $edit_note = '')
	{
		if (!$tag || !$clone_tag)
		{
			return false;
		}

		// load page and site information
		$page		= $this->load_page($tag);
		$new_tag	= $clone_tag;

		$this->clear_cache_wanted_page($clone_tag);		// STS what's that wanted stuff?!

		return
			// save
			$this->save_page($new_tag, $page['body'], $page['title'], $edit_note, false, 0, 0, 0, $page['page_lang'], false, false);
	}

	function rename_page($tag, $new_tag)
	{
		if (!$tag || !$new_tag)
		{
			return false;
		}

		// determine the page depth
		$new_depth = $this->get_page_depth($new_tag);

		// determine the page_id of the parent page
		$parent_id	= $this->get_parent_id($new_tag);

		return
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'revision SET ' .
					'tag		= ' . $this->db->q($new_tag) . ' ' .
				'WHERE tag		= ' . $this->db->q($tag) . ' ')
			&&
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'page SET ' .
					'tag		= ' . $this->db->q($new_tag) . ', ' .
					'parent_id	= ' . (int) $parent_id . ', ' .
					'depth		= ' . (int) $new_depth . ' ' .
				'WHERE tag		= ' . $this->db->q($tag) . ' ');
	}

	function set_noindex($page_id)
	{
		return $this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'noindex	= 1 ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
			'LIMIT 1');
	}

	// REMOVALS
	function remove_acls($tag, $cluster = false): bool
	{
		if (!$tag)
		{
			return false;
		}

		$this->db->sql_query(
			'DELETE a.* ' .
			'FROM ' . $this->prefix . 'acl a ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (a.page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );

		return true;
	}

	function delete_acls($page_ids, $dontkeep = false): void
	{
		if ($dontkeep)
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'acl ' .
				'WHERE page_id IN (' . $this->ids_string($page_ids) . ')');
		}
	}

	function delete_pages($pages): void
	{
		$rev	= count($this->page_id_cache) > 1 ? array_flip($this->page_id_cache) : false;

		foreach ($pages as $page_id)
		{
			$page_ids[] = (int) $page_id;
			unset($this->page_id_cache[@$rev[$page_id]]);
		}

		$this->db->sql_query(
			'DELETE FROM ' . $this->prefix . 'page ' .
			'WHERE page_id IN (' . $this->ids_string($page_ids) . ')');

		$this->db->sql_query(
			'DELETE FROM ' . $this->prefix . 'revision ' .
			'WHERE page_id IN (' . $this->ids_string($page_ids) . ')');
	}

	function remove_page($page_id, $comment_on_id = 0, $dontkeep = false): bool
	{
		if (!$page_id || !($page = $this->load_page('', $page_id)))
		{
			return false;
		}

		// store a copy in revision
		if ($this->db->store_deleted_pages && !$dontkeep)
		{
			// unlink comment tag
			$page['comment_on_id']	= 0; // XXX: obsolete

			// saving original
			$this->save_revision($page);

			// saving updated for the current user and flag it as deleted
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'page SET ' .
					'modified	= UTC_TIMESTAMP(), ' .
					'ip			= ' . $this->db->q($this->get_user_ip()) . ', ' .
					'deleted	= 1, ' .
					'user_id	= ' . (int) $this->get_user_id() . ' ' .
				'WHERE page_id	= ' . (int) $page_id . ' ' .
				'LIMIT 1');
		}
		else
		{
			$this->delete_pages([$page_id]);
		}

		// update comments count and date of last commented page
		if ($comment_on_id)
		{
			$this->update_comments_count($comment_on_id, null, true);
		}

		return true;
	}

	function remove_revision($page_id, $revision_id, $dontkeep = 0): bool
	{
		if (!$page_id)
		{
			return false;
		}

		if ($this->db->store_deleted_pages && !$dontkeep)
		{
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'revision SET ' .
					'deleted	= 1 ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
					'AND revision_id = ' . (int) $revision_id . ' ' .
				'LIMIT 1');
		}
		else
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'revision ' .
				'WHERE page_id = ' . (int) $page_id . ' ' .
					'AND revision_id = ' . (int) $revision_id . ' ' .
				'LIMIT 1');
		}

		return true;
	}

	function remove_revisions($tag, $cluster = false, $dontkeep = false): bool
	{
		if (!$tag)
		{
			return false;
		}

		if ($this->db->store_deleted_pages && !$dontkeep)
		{
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'revision SET ' .
					'deleted	= 1 ' .
				'WHERE tag = ' . $this->db->q($tag) . ' ' .
					($cluster === true
						? 'OR tag LIKE ' . $this->db->q($tag . '/%') . ' '
						: '') );
		}
		else
		{
			$this->db->sql_query(
				'DELETE FROM ' . $this->prefix . 'revision ' .
				'WHERE tag = ' . $this->db->q($tag) . ' ' .
					($cluster
						? 'OR tag LIKE ' . $this->db->q($tag . '/%') . ' '
						: ''));
		}

		return true;
	}

	function remove_comments($tag, $cluster = false, $dontkeep = false): bool
	{
		if (!$tag)
		{
			return false;
		}

		if ($comments = $this->db->load_all(
			'SELECT a.page_id ' .
			'FROM ' . $this->prefix . 'page a ' .
				'INNER JOIN ' . $this->prefix . 'page b ON (a.comment_on_id = b.page_id) ' .
			'WHERE b.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR b.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') )
			)
		{
			foreach ($comments as $comment)
			{
				$page_ids[] = (int) $comment['page_id'];
				$this->remove_page($comment['page_id'], '', $dontkeep);
			}

			$this->delete_acls($page_ids, $dontkeep);
		}

		// reset comments count
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'comments	= 0, ' .
				'commented	= NULL ' .
			'WHERE tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );

		return true;
	}

	function remove_menu_items($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			'DELETE b.* ' .
			'FROM ' . $this->prefix . 'menu b ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (b.page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );
	}

	function remove_watches($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			'DELETE w.* ' .
			'FROM ' . $this->prefix . 'watch w ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (w.page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );
	}

	// removes all associated page links
	function remove_links($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		// external links
		$this->db->sql_query(
			'DELETE l.* ' .
			'FROM ' . $this->prefix . 'external_link l ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (l.page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );

		// file links
		$this->remove_file_link(null, $tag, $cluster);

		// internal links
		$this->db->sql_query(
			'DELETE l.* ' .
			'FROM ' . $this->prefix . 'page_link l ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (l.from_page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );
	}

	function remove_file_link($file_id = null, $tag = null, $cluster = false)
	{
		if ($tag)
		{
			return $this->db->sql_query(
				'DELETE l.* ' .
				'FROM ' . $this->prefix . 'file_link l ' .
					'LEFT JOIN ' . $this->prefix . 'page p ' .
						'ON (l.page_id = p.page_id) ' .
				'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
					($cluster === true
						? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
						: '') );
		}
		else if ($file_id)
		{
			return $this->db->sql_query(
				'DELETE l.* ' .
				'FROM ' . $this->prefix . 'file_link l ' .
				'WHERE l.file_id = ' . (int) $file_id . ' ');
		}
		else
		{
			return false;
		}
	}

	function remove_page_categories($tag, $cluster = false): bool
	{
		if (!$tag)
		{
			return false;
		}

		$this->db->sql_query(
			'DELETE k.* ' .
			'FROM ' . $this->prefix . 'category_assignment k ' .
				'LEFT JOIN ' . $this->prefix . 'page p ' .
					'ON (k.object_id = p.page_id) ' .
			'WHERE (p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') . ') ' .
				'AND k.object_type_id = 1');

		return true;
	}

	function remove_category_assignments($object_id, $type_id): bool
	{
		if (!$object_id && !$type_id)
		{
			return false;
		}

		$this->db->sql_query(
			'DELETE k.* ' .
			'FROM ' . $this->prefix . 'category_assignment k ' .
			'WHERE k.object_id = ' . (int) $object_id . ' ' .
				'AND k.object_type_id = ' . (int) $type_id);

		return true;
	}

	function remove_referrers($tag, $cluster = false)
	{
		if (!$tag)
		{
			return false;
		}

		return $this->db->sql_query(
			'DELETE ' .
				'r.* ' .
			'FROM ' . $this->prefix . 'referrer r ' .
				'INNER JOIN ' . $this->prefix . 'page p ON (r.page_id = p.page_id) ' .
			'WHERE p.tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR p.tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );
	}

	// removes all files attached to a page
	function remove_files_perpage($tag, $cluster = false, $dontkeep = false): bool
	{
		if (!$tag)
		{
			return false;
		}

		$pages = $this->db->load_all(
			'SELECT page_id ' .
			'FROM ' . $this->prefix . 'page ' .
			'WHERE tag = ' . $this->db->q($tag) . ' ' .
				($cluster === true
					? 'OR tag LIKE ' . $this->db->q($tag . '/%') . ' '
					: '') );

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->db->load_all(
				'SELECT file_id, page_id, user_id, file_name, file_ext ' .
				'FROM ' . $this->prefix . 'file ' .
				'WHERE page_id = ' . (int) $page['page_id']);

			// store a copy in ...
			if ($this->db->store_deleted_pages && !$dontkeep)
			{
				// TODO: moved file to backup folder
				foreach ($files as $file)
				{
					// moved file to backup folder

					$this->remove_file_meta($file);
				}

				// flag record as deleted in DB
				$this->db->sql_query(
					'UPDATE ' . $this->prefix . 'file SET ' .
						'deleted	= 1 ' .
					'WHERE page_id = ' . (int) $page['page_id']);
			}
			else
			{
				foreach ($files as $file)
				{
					// remove from FS
					$file_name = Ut::join_path(UPLOAD_LOCAL_DIR, '@' .
						$page['page_id'] . '@' . $file['file_name']);

					@unlink($file_name);

					$this->remove_file_meta($file);
				}

				clearstatcache();

				// remove from DB
				$this->db->sql_query(
					'DELETE ' .
					'FROM ' . $this->prefix . 'file ' .
					'WHERE page_id = ' . (int) $page['page_id']);
			}

			$this->update_files_count($page['page_id'], 0);
		}

		return true;
	}

	function remove_file($file_id, $dontkeep = false): bool
	{
		$message = '';

		if (!$file_id)
		{
			return false;
		}

		// get filenames
		$file = $this->db->load_single(
			'SELECT file_id, page_id, user_id, file_name, file_ext ' .
			'FROM ' . $this->prefix . 'file ' .
			'WHERE file_id = ' . (int) $file_id);

		if ($this->db->store_deleted_pages && !$dontkeep)
		{
			// TODO: moved file to backup folder

			// flag record as deleted in DB
			$this->db->sql_query(
				'UPDATE ' . $this->prefix . 'file SET ' .
					'deleted	= 1 ' .
				'WHERE file_id = ' . (int) $file['file_id'] . ' ' .
				'LIMIT 1');
		}
		else
		{
			// remove from FS
			$file_name = ($file['page_id']
				? UPLOAD_LOCAL_DIR . '/@' . $file['page_id'] . '@'
				: UPLOAD_GLOBAL_DIR . '/') .
				$file['file_name'];

			if (@unlink($file_name))
			{
				clearstatcache();

				$message .= $this->_t('FileRemovedFromFS') . '<br>';
			}
			else
			{
				$this->set_message($this->_t('FileRemovedFromFSError'), 'error');
			}

			$message .= $this->_t('FileRemovedFromDB') . '<br>';

			// remove from DB
			$this->db->sql_query(
				'DELETE ' .
				'FROM ' . $this->prefix . 'file ' .
				'WHERE file_id = ' . (int) $file['file_id']);

			if ($message)
			{
				$this->set_message($message, 'success');
			}
		}

		$this->remove_file_meta($file);
		$this->update_files_count($file['page_id'], $file['user_id']);

		return true;
	}

	function remove_file_meta($file): bool
	{
		if ($this->db->create_thumbnail && in_array($file['file_ext'], self::EXT['bitmap']))
		{
			$this->purge_thumbnails($file['file_name'], $file['page_id'], $file['file_ext']);
		}

		$this->remove_file_link($file['file_id']);
		$this->remove_category_assignments($file['file_id'], OBJECT_FILE);

		return true;
	}

	function purge_thumbnails($name, int $page_id, $ext)
	{
		$n			= 0;
		$pattern	= hash('sha1', $name) . '.thumb.*.' . $ext;

		$list		= Ut::file_glob(
						($page_id
							? THUMB_LOCAL_DIR . '/@' . $page_id . '@'
							: THUMB_DIR . '/') .
						$pattern);

		foreach ($list as $file)
		{
			if (unlink($file))
			{
				++$n;
			}
		}

		return $n;
	}

	// RESTORE
	function restore_page($page_id): bool
	{
		if (!$page_id)
		{
			return false;
		}

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'page SET ' .
				'deleted	= 0 ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
			'LIMIT 1');

		return true;
	}

	function restore_revision($page_id, $revision_id): bool
	{
		if (!$page_id)
		{
			return false;
		}

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'revision SET ' .
				'deleted	= 0 ' .
			'WHERE page_id = ' . (int) $page_id . ' ' .
				'AND revision_id = ' . (int) $revision_id . ' ' .
			'LIMIT 1');

		return true;
	}

	function restore_file($file_id)
	{
		if (!$file_id)
		{
			return false;
		}

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'file SET ' .
				'deleted	= 0 ' .
			'WHERE file_id = ' . (int) $file_id . ' ' .
			'LIMIT 1');
	}

	function restore_files_perpage($page_id): bool
	{
		if (!$page_id)
		{
			return false;
		}

		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'file SET ' .
				'deleted	= 0 ' .
			'WHERE page_id = ' . (int) $page_id);

		return true;
	}

	// ADDITIONAL METHODS
	function password_hash($user, $password): string
	{
		return password_hash(base64_encode(hash('sha256', $user['user_name'] . $password, true)), PASSWORD_DEFAULT);
	}

	function password_verify($user, $password): bool
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
	function form_autocomplete_off(): string
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
		return	'<!-- disables autocomplete -->' . "\n" .
				'<input type="text" class="verify">' . "\n" .
				'<input type="password" class="verify">' . "\n";
	}

	// run checks of password complexity under current
	// config settings; returned error diag, or '' if good
	function password_complexity($login, $pwd): string
	{
		$unlike_login	= $this->db->pwd_unlike_login;
		$char_classes	= $this->db->pwd_char_classes;
		$min_chars		= $this->is_admin() ? $this->db->pwd_admin_min_chars : $this->db->pwd_min_chars;
		$out			= '';

		$l = mb_strlen($login);
		$p = mb_strlen($pwd);

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
					$error += (mb_stristr($login, $pwd) !== false || mb_stristr($pwd, $login) !== false);
				}
			case 1:
				$error += (strcasecmp($login, $pwd) === 0);
		}

		if ($error)
		{
			$out .= $this->_t('PwdCplxEquals') . ' ';
		}

		// check password length
		if ($p < $min_chars)
		{
			$out .= $this->_t('PwdCplxShort') . ' ';
		}

		// check character classes requirements
		$error = 0;

		switch ($char_classes)
		{
			case 1:
				if (   !preg_match('/\p{N}+/',					$pwd)
					|| !preg_match('/\p{L}+/u',					$pwd))
				{
					++$error;
				}
				break;

			case 2:
				if (   !preg_match('/\pN+/',					$pwd)
					|| !preg_match('/\p{Lu}+/u',				$pwd)
					|| !preg_match('/\p{Ll}+/u',				$pwd))
				{
					++$error;
				}
				break;

			case 3:
				if (   !preg_match('/\p{N}+/',					$pwd)
					|| !preg_match('/\p{Lu}+/u',				$pwd)
					|| !preg_match('/\p{Ll}+/u',				$pwd)
					|| !preg_match('/[\p{Z}\p{S}\p{P}]+/',		$pwd))
				{
					++$error;
				}
				break;
		}

		if ($error)
		{
			$out .= $this->_t('PwdCplxWeak') . ' ';
		}

		return $out;
	}

	function show_password_complexity(): string
	{
		$min_chars = $this->is_admin()
						? $this->db->pwd_admin_min_chars
						: $this->db->pwd_min_chars;

		if ($this->db->pwd_char_classes > 0)
		{
			$text = $this->_t('PwdCplxDesc4');

			if ($this->db->pwd_char_classes == 1)
			{
				$text .= $this->_t('PwdCplxDesc41');
			}
			else if ($this->db->pwd_char_classes == 2)
			{
				$text .= $this->_t('PwdCplxDesc42');
			}
			else if ($this->db->pwd_char_classes == 3)
			{
				$text .= $this->_t('PwdCplxDesc43');
			}

			$text .= '. ' . $this->_t('PwdCplxDesc5');
		}

		return
			$this->_t('PwdCplxDesc1') .
			Ut::perc_replace($this->_t('PwdCplxDesc2'), $min_chars) .
			($this->db->pwd_unlike_login > 0
				? ', ' . $this->_t('PwdCplxDesc3')
				: '') .
			($this->db->pwd_char_classes > 0
				? ', ' . $text
				: '');
	}

	/**
	 * pages listing/navigation for multipage lists.
	 *
	 * @param int			$total		total elements in the list
	 * @param int			$perpage	total elements on a page
	 * @param string		$_name		page number variable in $_GET
	 * @param array|string	$params		$_GET parameters to be passed with the page link (as href-formatted array or string)
	 * @param string		$method
	 * @param bool			$tag
	 *
	 * @return array					array with 'text' (navigation) and 'offset' (offset value for SQL queries) elements.
	 */
	function pagination($total, $perpage = 10, $_name = 'p', $params = '', $method = '', $tag = ''): array
	{
		$total		= (int) $total;
		$name		= 'p';
		$anchor		= '';

		// allow array parameter expansion
		if (is_array($_name))
		{
			extract($params, EXTR_IF_EXISTS);
		}
		else
		{
			$name = $_name;
		}

		$perpage = $this->get_list_count((int) $perpage);

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
			$page		= $_GET[$name] ?? '';
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
						($body ?: $page) . '</a>';
			};

			$make_list = function ($from, $to) use ($page, $pages, $make_link, $sep)
			{
				$list = '';

				for ($p = $from; $p <= $to; $p++)
				{
					$list .= ' ';

					// don't make link for the current page
					if ($p == $page)
					{
						$list .= '<strong>' . $p . '</strong>';
					}
					else
					{
						$list .= $make_link($p);
					}

					if ($p != $pages)
					{
						$list .= $sep;
					}
				}

				return $list;
			};

			$pagination['offset']	= $perpage * ($page - 1);
			$text					= $this->_t('ToThePage') . ' ';

			if ($page > 1)
			{
				$text .= $make_link($page - 1, ('« ' . $this->_t('PrevAcr')), ' rel="prev"') . ' ';
			}

			// pages range links
			if ($pages <= 10)	// not so many pages, list all
			{
				$text .= $make_list(1, $pages);
			}
			else if ($page <= 4 || $page > $pages - 4)	// current page is near the beginning or the end
			{
				$text .= $make_list(1, 5);
				$text .= $span;
				$text .= $make_list($pages - 4, $pages);
			}
			else	// current page is in the middle of the list
			{
				$text .= $make_list(1, 1);
				$text .= $span;
				$text .= $make_list($page - 2, $page + 2);
				$text .= $span;
				$text .= $make_list($pages, $pages);
			}

			// next page shortcut
			if ($page < $pages)
			{
				$text .= ' ' . $make_link($page + 1, ($this->_t('NextAcr') . ' »'), ' rel="next"');
			}

			$pagination['text']		= $text;
			$pagination['limit']	= "LIMIT {$pagination['offset']}, $perpage";
		}

		return $pagination;
	}

	function print_pagination($pagination): void
	{
		if (@$pagination['text'])
		{
			echo '<nav class="pagination">' . $pagination['text'] . "</nav>\n";
		}
	}

	// show captcha form on a page. must be incorporated as an input
	// form component in every page that uses captcha testing
	//		$inline	= adds <br> between elements
	function show_captcha($inline = true): string
	{
		$out = '';

		// captcha is for guests only and if gd available
		if ($this->db->enable_captcha && !$this->get_user() && extension_loaded('gd'))
		{
			// disable server cache for page
			$this->http->no_cache(false);

			$this->sess->freecap_shown = 1;

			$out .=
				($inline ? '' : "<br>\n") .
				'<label for="captcha">' . $this->_t('Captcha') . "</label>\n" .
				($inline ? '' : "<br>\n") .
				// href('', '.freecap') won't work, because mini_href() would strip the DOT
				'<img src="' . $this->db->base_path . ($this->db->rewrite_mode ? '' : '?page=') . '.freecap" id="freecap" alt="' . $this->_t('Captcha') . '">' . "\n" .
				'<a href="" onclick="this.blur(); new_freecap(); return false;" title="' . $this->_t('CaptchaReload') . '">' .
				'<img src="' . $this->db->base_path . Ut::join_path(IMAGE_DIR, 'spacer.png') . '" alt="' . $this->_t('CaptchaReload') . '" class="btn-reload btn-md"></a>' . "<br>\n" .
				'<input type="text" id="captcha" name="captcha" maxlength="6" required>' .
				($inline ? '' : "<br>\n");
		}

		return $out;
	}

	// checks whether user's captcha solution was right. function
	// takes no arguments, instead it receives user input from
	// HTTP-POST variable 'captcha', submitted through webform.
	function validate_captcha(): bool
	{
		$word_ok = true;

		if (isset($this->sess->freecap_shown))
		{
			$word_ok = false;
			unset($this->sess->freecap_shown);

			if (!empty($this->sess->freecap_word_hash) && !empty($_POST['captcha'])
				&& hash($this->sess['hash_algo'], strtolower($_POST['captcha'])) === $this->sess->freecap_word_hash)
			{
				unset($this->sess->freecap_attempts);
				$word_ok = true;
			}
		}

		return $word_ok;
	}

	// returns error text, or null on OK
	function validate_email($email, $create = true): ?string
	{
		// no email given
		if ($email == '')
		{
			return $this->_t('SpecifyEmail') . ' ';
		}
		// invalid email
		else if (!$this->validate_email_address($email))
		{
			return $this->_t('NotAEmail') . ' ';
		}
		// no email reuse allowed
		else if (!$this->db->allow_email_reuse && $this->email_exists($email) && $create)
		{
			return $this->_t('EmailTaken') . ' ';
		}
		else if (!empty($this->db->allowed_email_domains) && !$this->validate_email_domain($email, $this->db->allowed_email_domains))
		{
			return Ut::perc_replace($this->_t('EmailDomainNotAllowed'), '<code>' . $email . '</code>') . ' ';
		}
		else if (!empty($this->db->forbidden_email_domains) && $this->validate_email_domain($email, $this->db->forbidden_email_domains, false))
		{
			return Ut::perc_replace($this->_t('EmailDomainNotAllowed'), '<code>' . $email . '</code>') . ' ';
		}

		return null; // it's ok :)
	}

	/**
	 * Check for valid email address.
	 *
	 * @param string	$email_address = email address to check
	 *
	 * @return bool		email valid or invalid
	 */
	function validate_email_address($email_address): bool
	{
		if ($this->db->email_pattern == 'html5')
		{
			// Use the pattern given by the HTML5 spec for 'email' type form input elements
			// http://www.w3.org/TR/html5/forms.html#valid-e-mail-address
			$pattern = '/^[a-zA-Z\d.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z\d](?:[a-zA-Z\d-]{0,61}' .
						'[a-zA-Z\d])?(?:\.[a-zA-Z\d](?:[a-zA-Z\d-]{0,61}[a-zA-Z\d])?)*$/sD';

			return (bool) preg_match($pattern, $email_address);
		}
		else
		{
			// Use PHP built-in FILTER_VALIDATE_EMAIL, does not allow 'dotless' domains;
			// http://php.net/filter.filters.validate
			return (bool) filter_var($email_address, FILTER_VALIDATE_EMAIL);
		}
	}

	// only allow and send email to addresses in the given domain(s)
	function validate_email_domain($email_address, $email_domains, $allowed = true): ?bool
	{
		$domain = substr($email_address, strpos($email_address, '@') + 1);

		// see if we're limited to a set of known domains
		if(!empty($email_domains))
		{
			$allowed_domains = preg_split('/[\s,]+/', $email_domains, -1, PREG_SPLIT_NO_EMPTY);

			foreach($allowed_domains as $email_domain)
			{
				if( 0 == strcasecmp($email_domain, $domain))
				{
					return true;
				}
			}

			if ($allowed)
			{
				$this->log(2, Ut::perc_replace($this->_t('LogUserEmailNotAllowed', SYSTEM_LANG), $email_address));
			}

			return false;
		}
	}

	/**
	 * log event into the system journal
	 *
	 * event classes are:
	 * 	1. critical		- admin action, object deletion, suspected hacking attempt
	 * 	2. highest		- locking, acl change, unsuccessful user login
	 * 	3. high			- page renaming/moving/splitting/merging,
	 * 					  user password change/reminder, successful user login
	 * 	4. medium		- page creation (settings change), file upload, pm sending,
	 * 					  user registration and email activation, page ownership claim
	 * 	5. low			- comment posting, user logout
	 * 	6. lowest		- page edit, user settings update
	 * 	7. debugging	- everything, where logging is necessary
	 *
	 * @param int		$level		denotes event priority with 1 = highest
	 * @param string	$message	may use wiki syntax, however if used before locale translations registration,
	 * 								will be saved in plain text only
	 *
	 * @return bool|array			array with logged events
	 */
	function log($level, $message)
	{
		// check input
		if (!is_numeric($level))
		{
			return false;
		}

		// check event level: do we have to log it?
		if (	(int) $this->db->log_level === 0
			|| ((int) $this->db->log_level !== 7
					&& $level > (int) $this->db->log_level))
		{
			return true;
		}

		// TODO: set default lang if !isset($this->lang) -> forced logout -> missing format()
		//		##value## -> <code>value</code>

		$html			= $this->db->allow_rawhtml;
		$this->db->allow_rawhtml = 0;
		$message		= (isset($this->lang) ? $this->format($message, 'wacko') : $message);
		$user_id		= $this->get_user_id();
		$this->db->allow_rawhtml = $html;

		return $this->db->sql_query(
			'INSERT INTO ' . $this->prefix . 'log SET ' .
				'log_time	= UTC_TIMESTAMP(), ' .
				'level		= ' . (int) $level . ', ' .
				'user_id	= ' . (int) ($user_id ?: 0) . ', ' .
				'ip			= ' . $this->db->q($this->http->ip) . ', ' .
				'message	= ' . $this->db->q($message) . ' ');
	}

	/**
	 * creates tab menu
	 *
	 * @param array		$tabs
	 * @param string	$active
	 * @param string	$handler
	 * @param array		$params
	 * @param string	$mod_selector
	 *
	 * @return bool|string
	 */
	function tab_menu($tabs, $active, $handler = '', $params = [], $mod_selector = 'm')
	{
		if ($tabs)
		{
			$out = '<ul class="menu">' . "\n";

			foreach ($tabs as $i => $text)
			{
				if ($active != $i)
				{
					$out .= '<li><a href="' . $this->href($handler, '', $params + ($i? [$mod_selector => $i] : [])) . '">';
				}
				else
				{
					$out .= '<li class="active">';
				}

				$out .= $this->_t($text);

				if ($active != $i)
				{
					$out .= '</a>';
				}

				$out .= "</li>\n";
			}

			$out .= "</ul>\n";

			return $out;
		}
		else
		{
			return false;
		}
	}

	function get_categories($object_id, $type_id = null, $method = '', $tag = '', $params = [], $cache = true)
	{
		$out			= '';
		$category_id	= (int) @$_GET['category_id'];

		if ($categories = $this->load_categories($object_id, $type_id, $cache))
		{
			foreach ($categories as $n => $category)
			{
				if ($n > 0)
				{
					$out .= ', ';
				}

				if ($category_id == $category['category_id']) // TODO: might be an array!
				{
					$out .= '<span class="tag" rel="tag">' . $category['category'] . '</span>';
				}
				else
				{
					$out .= '<a href="' . $this->href($method, $tag, ['category_id' => $category['category_id']] + $params) . '" class="tag" rel="tag">' . $category['category'] . '</a>';
				}
			}

			return $out;
		}
		else
		{
			return false;
		}
	}

	// load categories for the page's particular language.
	// if root string value is passed, returns number of
	// pages under each category and below defined root page
	function get_categories_list($lang, $cache = true, $root = false, $empty = true)
	{
		$categories = [];

		if ($_categories = $this->db->load_all(
			'SELECT category_id, parent_id, category_lang, category ' .
			'FROM ' . $this->prefix . 'category ' .
			'WHERE category_lang = ' . $this->db->q($lang) . ' ' .
			'ORDER BY parent_id ASC, category ASC', $cache))
		{
			// process pages count (if have to)
			if ($root !== false)
			{
				if ($_counts = $this->db->load_all(
				'SELECT kp.category_id, COUNT(kp.object_id) AS n ' .
				'FROM ' . $this->prefix . 'category k , ' .
					$this->prefix . 'category_assignment kp ' .
					($root != ''
						? 'INNER JOIN ' . $this->prefix . 'page p ON (kp.object_id = p.page_id) '
						: '' ) .
				'WHERE k.category_lang = ' . $this->db->q($lang) . ' ' .
					'AND	kp.category_id		= k.category_id ' .
					'AND	kp.object_type_id	= 1 ' .
					($root != ''
						? 'AND (p.tag = ' . $this->db->q($root) . ' OR p.tag LIKE ' . $this->db->q($root . '/%') . ' ) ' .
						  'AND p.deleted <> 1 '
						: '') .
				'GROUP BY kp.category_id', true))
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
				if ($empty || !empty($counts[$word['category_id']]))
				{
					$categories[$word['category_id']] = [
						'parent_id'	=> $word['parent_id'],
						'lang'		=> $word['category_lang'],
						'category'	=> $word['category'],
						'n'			=> ($counts[$word['category_id']] ?? ''),
					];
				}
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

	function show_category_form($lang, $object_id = null, $type_id = null, $can_edit = false, $buttons = true, $pre_selected = []): string
	{
		$assigned	= [];
		$selected	= [];
		$out		= '';

		// load categories for the page's particular language
		$categories = $this->get_categories_list($lang, false);

		// get currently assigned category_ids
		if ($object_id && $type_id)
		{
			$assigned = $this->db->load_all(
				'SELECT category_id ' .
				'FROM ' . $this->prefix . 'category_assignment ' .
				'WHERE object_id = ' . (int) $object_id . ' ' .
					'AND object_type_id = ' . (int) $type_id);
		}

		// assigned categories
		foreach ($assigned as $key => &$val)
		{
			if (is_array($val))
			{
				$selected[$key] = $val['category_id'];
			}
		}

		// pre-selected categories
		foreach ($pre_selected as $key => $val)
		{
			$selected[$key] = $val;
		}

		$checked = function ($category_id) use ($selected)
		{
			return
				is_array($selected)
					? (in_array($category_id, $selected) ? ' checked' : '')
					: '';
		};

		// print categories list
		if (is_array($categories))
		{
			$total	= ceil(count($categories) / 4);
			$i		= 0;
			$n		= 1;

			$out = '<div class="set-category">' . "\n";
			$out .= '<table class="category-browser">' . "\n";
			$out .= "\t<tr>\n" . "\t\t<td>\n";
			$out .= '<ul class="ul-list hl-line">' . "\n"; // hide-radio

			foreach ($categories as $category_id => $word)
			{
				$out .= '<li>' . "\n\t";
				$out .= ($can_edit
							? '<input type="radio" id="category' . $category_id . '" name="category_id" value="' . $category_id . '">'
							: '<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '" value="set"' . $checked($category_id) . '> ' . "\n\t") .
						'<label for="category' . $category_id . '"><strong>' . Ut::html($word['category']) . '</strong></label>' . "\n";

				if (isset($word['child']) && $word['child'])
				{
					foreach ($word['child'] as $category_id => $word)
					{
						if ($i++ < 1)
						{
							$out .= "\t<ul>\n";
						}

						$out .= "\t\t" .
							'<li>' . "\n\t\t\t" . // TODO: CSS white-space: nowrap;
								($can_edit
									? '<input type="radio" id="category' . $category_id . '" name="category_id" value="' . $category_id . '">' . "\n\t\t\t"
									: '<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '" value="set"' . $checked($category_id) . '>' . "\n\t\t\t") .
								'<label for="category' . $category_id . '">' . Ut::html($word['category']) . '</label>' . "\n\t\t" .
							'</li>' . "\n";
					}
				}

				if ($i > 0)
				{
					$out .= "\t</ul>\n</li>\n";
				}
				else
				{
					$out .= "</li>\n";
				}

				// modulus operator: every n loop add a break
				if ($n % $total == 0)
				{
					$out .= "</ul>\n";
					$out .= "\t\t</td>\n\t\t<td>\n";
					$out .= '<ul class="ul-list hl-line">' . "\n"; // hide-radio
				}

				$i = 0;
				$n++;
			}

			$out .= "</ul>\n";
			$out .= "\t\t</td>\n\t</tr>\n</table>\n";
			$out .= "</div>\n";

			// control buttons
			if (!($can_edit || !$buttons))
			{
				$out .= '<button type="submit" id="submit" name="save">' . $this->_t('CategoriesStoreButton') . '</button> ' .
						'<a href="' . $this->href() . '" class="btn-link">' .
							'<button type="button" class="btn-cancel">' . $this->_t('CancelButton') . '</button>' .
						'</a>' . "<br>\n" .
						'<small>' . $this->_t('CategoriesStoreInfo') . '</small>' . "\n";
			}
		}
		else
		{
			// availability depends on the page language and your access rights
			// additionally you need also the right to create new categories
			$out .= $this->_t('NoCategoriesForThisLang') . "<br><br><br>\n";

			if ($buttons)
			{
				$out .=
					'<a href="' . $this->href() . '" class="btn-link">' .
						'<button type="button" class="btn-cancel">' . $this->_t('CancelButton') . '</button>' .
					'</a>' . "\n";
			}
		}

		// edit control buttons
		if ($can_edit && $buttons)
		{
			$out .= '<button type="submit" id="add-button" name="create">' . $this->_t('AddButton') . '</button> ' .
					'<button type="submit" id="rename-button" name="rename">' . $this->_t('RenameButton') . '</button> ' .
					'<button type="submit" id="group-button" name="ungroup">' . $this->_t('CategoriesGroupButton') . '</button> ' .
					'<button type="submit" id="remove-button" name="delete" class="btn-danger">' . $this->_t('RemoveButton') . '</button> ' .
					'<small><br>' . $this->_t('CategoriesEditInfo') . '</small>';
		}

		return $out;
	}

	// save categories selected in webform. ids are
	// passed through POST global array. returns:
	//	true	- if something was saved
	//	false	- if list was empty
	function save_categories_list($object_id, $type_id, $dryrun = false): bool
	{
		$set	= [];
		$ids	= [];
		$values	= [];

		// what's selected
		foreach ($_POST as $key => $val)
		{
			if (preg_match('/^category(\d+)$/', $key, $ids) && $val == 'set')
			{
				$set[] = $ids[1];
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
					'INSERT INTO ' . $this->prefix . 'category_assignment ' .
						'(category_id, object_id, object_type_id) ' .
					'VALUES ' . implode(', ', $values));
			}

			return true;
		}
		else
		{
			return false;
		}
	}

	function show_select_license($name, $license, $label = false): string
	{
		$out		= '';
		$licenses	= [];

		if ($label)
		{
			$out .= '<label for="' . $name . '">' . $this->_t('DefaultLicense') . ' </label>';
		}

		$out .= '<select id="license" name="license">' . "\n";
		$out .= '<option value="">--</option>' . "\n";
		$licenses = $this->_t('LicenseArray');

		foreach ($licenses as $offset => $text)
		{
			if (mb_strlen($text) > 50)
			{
				$text = mb_substr($text, 0, 45 ) . '...';
			}

			$out .= '<option value="' . $offset . '" ' .
				($license == $offset
					? 'selected '
					: '') .
				'>' . '[ ' . $this->_t('LicenseIds')[$offset][0] . ' ] ' . $text . "</option>\n";
		}

		$out .= "</select>\n";

		return $out;
	}

	/**
	 * show select for available languages
	 *
	 * @param string	$name	name for select
	 * @param string	$lang	current language
	 * @param bool		$label	display label
	 */
	function show_select_lang($name, $lang, $label = false): string
	{
		$out		= '';
		$langs		= [];
		$languages	= [];

		if ($label)
		{
			$out .= '<label for="' . $name . '">' . $this->_t('YourLanguage') . ' </label>';
		}

		$out .= '<select id="' . $name . '" name="' . $name . '">' . "\n";

		$languages	= $this->_t('LanguageArray');
		$langs		= $this->db->multilanguage
						? $this->http->available_languages()
						: [$this->db->language];

		foreach ($langs as $_lang)
		{
			$out .= '<option value="' . $_lang . '" ' . ($lang == $_lang ? 'selected ' : '') . '>' . $languages[$_lang] . ' (' . $_lang . ")</option>\n";
		}

		$out .= "</select>\n";

		return $out;
	}

	/**
	 *
	 * @param int		$size
	 * @param string	$prefix		'decimal' or 'binary'
	 * @param bool		$short
	 * @param bool		$rounded
	 * @param bool		$suffix
	 * @param string	$norm
	 *
	 * @return string|number
	 */
	function factor_multiples($size, $prefix = 'decimal', $short = true, $rounded = false, $suffix = true, $norm = 'bytes')
	{
		if (is_numeric($size))
		{
			if ($prefix == 'decimal')
			{
				// decimal prefix
				$factor	= 1000;
				$norm	= match($norm) {
					'bytes' => $this->_t('ByteDecimal'  . ($short ? 'Short' : 'Long')),
					'pixel' => $this->_t('PixelDecimal' . ($short ? 'Short' : 'Long')),
				};
			}
			else
			{
				// binary prefix
				$factor	= 1024;
				$norm	= $this->_t('ByteBinary' . ($short ? 'Short' : 'Long'));
			}

			$count	= 8;
			$x		= 0;

			while ($size >= $factor && $x < $count)
			{
				$size /= $factor;
				$x++;
			}

			if ($rounded)
			{
				// for MiB and bigger use two decimal places
				# $precision	= $x > 1 ? 2 : 0;
				$precision	= 1;
				$size		= $this->number_format($size, $precision);
			}
			else
			{
				$size		= $this->number_format($size, 2); #sprintf('%01.2f', $size);
			}

			if ($suffix)
			{
				$size		= $size . NBSP . $norm[$x];
			}

			return $size;
		}
	}

	function multiples_factor($size, $prefix = 'decimal'): int
	{
		$count	= 9;
		$x		= 0;

		$factor = match($prefix) {
			'binary'	=> 1024,
			default		=> 1000,
		};

		while ($size >= $factor && $x < $count)
		{
			$size /= $factor;
			$x++;
		}

		return $x;
	}

	function delta_formatted($size_delta): string
	{
		if ($size_delta > 0)
		{
			$diff_class = 'diff-pos';
			$size_delta = '+' . $this->number_format($size_delta);
		}
		else if ($size_delta < 0)
		{
			$diff_class = 'diff-neg';
			$size_delta = $this->number_format($size_delta);
		}
		else
		{
			$diff_class = 'diff-zero';
			$size_delta = '±' . $size_delta;
		}

		return '<span class="' . $diff_class . '">' . $size_delta . '</span>';
	}

	// to use by actions to add some inside <head> or above </body>
	//	e.g. to adding custom CSS or JS
	function add_html($location, $text): void
	{
		if (! in_array($text, $this->html_addition[$location] ?? []))
		{
			$this->html_addition[$location][] = $text;
		}
	}

	function get_html_addition($location): string
	{
		return implode("\n", $this->html_addition[$location] ?? []);
	}

	// HANDLER HELPERS
	function ensure_page($forums = false): void
	{
		if (!($p = $this->page))
		{
			$this->show_must_go_on();
		}
		else if ($p['comment_on_id'])
		{
			// show main page for comment
			$this->http->redirect($this->href('', $this->get_page_tag($p['comment_on_id']), ['show_comments' => 1], false, $p['tag']));
		}
		else if ($this->forum && !$this->is_admin() && !$forums)
		{
			$this->show_must_go_on();
		}
	}

	function reload_me(): void
	{
		$this->http->redirect($this->href($this->method));
	}

	function show_must_go_on($param = []): void
	{
		$this->http->redirect($this->href('', '', $param));
	}

	function login_page(): void
	{
		$this->http->redirect($this->href('', $this->db->login_page, Ut::random_token(4)));
	}

	function go_back($to): void
	{
		if ($back = @$this->sess->sticky_goback)
		{
			$to = $back;
			unset($this->sess->sticky_goback);
		}

		$this->http->redirect($this->href('', $to, Ut::random_token(4)));
		// NEVER BEEN HERE
	}
}
