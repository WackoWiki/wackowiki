<?php

// engine class
class Wacko
{
	// VARIABLES
	var $config	= array();
	var $dblink;
	var $page;
	var $tag;
	var $iswatched;
	var $queryTime;
	var $queryLog = array();
	var $interWiki = array();
	var $aclCache = array();
	var $WVERSION; //Wacko version
	var $context = array("");
	var $current_context = 0;
	var $pages_meta = "page_id, owner_id, user_id, tag, supertag, created, modified, edit_note, minor_edit, latest, handler, comment_on_id, lang, title, keywords, description";
	var $first_inclusion = array(); // for backlinks
	var $optionSplitter = "\n"; // if you change this two symbols, settings for all users will be lost.
	var $valueSplitter  = "=";
	var $format_safe = true; //for htmlspecialchars() in PreLink
	var $unicode_entities = array(); //common unicode array
	var $timer;
	var $toc_context = array();
	var $search_engines = array("bot", "rambler", "yandex", "crawl", "search", "archiver", "slurp", "aport", "crawler", "google", "inktomi", "spider", );
	var $_langlist = NULL;
	var $languages = NULL;
	var $resources = NULL;
	var $wantedCache = NULL;
	var $pageCache = NULL;
	var $_formatter_noautolinks = NULL;
	var $numerate_links	= NULL;
	var $post_wacko_action = NULL;
	var $_userhost = NULL;
	var $paragrafica_styles = array(
		"before"	=> array(
						"_before" => "",
						"_after" => "",
						"before" => "<span class='pmark'>[##]</span><br />",
						"after" => ""),
		"after"		=> array(
						"_before" => "",
						"_after" => "",
						"before" => "",
						"after" => "<span class='pmark'>[##]</span>"),
		"right"		=> array(
						"_before" => "<div class='pright'><div class='p-'>&nbsp;<span class='pmark'>[##]</span></div><div class='pbody-'>",
						"_after" => "</div></div>",
						"before" => "",
						"after" => ""),
		"left"		=> array(
						"_before" => "<div class='pleft'><div class='p-'><span class='pmark'>[##]</span>&nbsp;</div><div class='pbody-'>",
						"_after" => "</div></div>",
						"before" => "",
						"after" => ""),
	);
	var $paragrafica_patches = array(
		"before" => array("before"),
		"after"  => array("after"),
		"right"  => array("_before"),
		"left"  => array("_before"),
	);
	var $NpjMacros = array(
		"âèêè" => "wiki", "âàêà" => "wacko", "âåá" => "web"
	);

	// CONSTRUCTOR
	function Wacko($config, $dblink)
	{
		$this->timer = $this->GetMicroTime();
		$this->config = $config;
		$this->dblink 	= $dblink;
		$this->WVERSION = WACKO_VERSION;
	}

	// DATABASE
	function Query($query, $debug = 0)
	{
		if ($debug) echo "((QUERY: $query))";

		if ($this->config['debug'] >= 2)
			$start = $this->GetMicroTime();

		$result = query($this->dblink, $query, $this->config['debug']);

		if ($this->config['debug'] >= 2)
		{
			$time = $this->GetMicroTime() - $start;
			$this->queryTime += $time;

			if ($this->config['debug'] >= 3)
			{
				$this->queryLog[] = array(
					'query'   => $query,
					'time'    => $time
				);
			}
		}

		return $result;
	}

	function LoadAll($query, $docache = 0)
	{
		$data = array();

		// retrieving from cache
		if ($this->config['cache_sql'] && $docache)
		{
			if ($data = $this->cache->LoadSQL($query)) return $data;
		}

		// retrieving from db
		if ($r = $this->Query($query))
		{
			while ($row = fetch_assoc($r)) $data[] = $row;

			free_result($r);
		}

		// saving to cache
		if ($this->config['cache_sql'] && $docache)
		{
			$this->cache->SaveSQL($query, $data);
		}
		if (isset($data))
			return $data;
		else
			return NULL;
	}

	function LoadSingle($query, $docache = 0)
	{
		if ($data = $this->LoadAll($query, $docache))

			if (isset($data))
			{
				return $data[0];
			}
			else
			{
				return NULL;
			}

	}

	// MISC
	function GetMicroTime()
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	function GetCommentOnTag($comment_on_id = 0)
	{
		$comment_on_tag = $this->LoadSingle(
					"SELECT tag FROM ".$this->config["table_prefix"]."pages WHERE page_id = '".$comment_on_id."' LIMIT 1");
					// Get tag value
					$comment_on_tag = $comment_on_tag['tag'];

					return $comment_on_tag;
	}

	function GetPageTag() { return $this->tag; }

	// TODO: same as function GetCommentOnTag, but he use other variable names and this one will probably obsolete if we use page_id in acls table ( ? )
	function GetPageTagById($page_id = 0)
	{
		$tag = $this->LoadSingle(
					"SELECT tag FROM ".$this->config["table_prefix"]."pages WHERE page_id = '".$page_id."' LIMIT 1");
					// Get tag value
					$tag = $tag['tag'];

					return $tag;
	}

	function GetPageId($tag = 0)
	{
		if(!$tag)
		{
			return $this->page["page_id"];
		}
		else
		//Soon we'll need to have page ID when saving a new page to continue working with $ID instead of $tag
		{
			// Returns Array ( [id] => Value )
			$get_page_ID = $this->LoadSingle(
				"SELECT page_id ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag = '".quote($this->dblink, $tag)."' LIMIT 1");

			// Get the_ID value
			$new_page_id = $get_page_ID['page_id'];

			return $new_page_id;
		}
	}
	function GetPageSuperTag() { return $this->supertag; }
	function GetPageTime() { return $this->page["modified"]; }
	function GetPageLastWriter() { return $this->page["user_id"]; }
	function GetMethod() { return $this->method; }
	function GetConfigValue($name) { return isset( $this->config[$name] ) ? $this->config[$name] : ''; }
	function GetWackoName() { return $this->config["wacko_name"]; }
	function GetWackoVersion() { return $this->WVERSION; }

	function CheckFileExists($filename, $unwrapped_tag = "" )
	{
		if ($unwrapped_tag == "")
		{
			$page_id = 0;
		}
		else
		{
			$page = $this->LoadPage($unwrapped_tag, "", LOAD_CACHE, LOAD_META);
			$page_id = $page["page_id"];

			if (!$page_id) return false;
		}

		if (!($file = $this->filesCache[$page_id][$filename]))
		{
			$what = $this->LoadAll(
				"SELECT upload_id, filename, filesize, description, picture_w, picture_h, file_ext ".
				"FROM ".$this->config["table_prefix"]."upload ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
					"AND filename = '".quote($this->dblink, $filename)."'");

			if (sizeof($what) == 0)
				return false;

			$file = $what[0];
			$this->filesCache[$page_id][$filename] = $file;
		}
		return $file;
	}

	function AvailableThemes()
	{
		$handle = opendir("themes");
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != ".." && is_dir("themes/".$file) && $file != ".svn" && $file != "_common")
				$themelist[] = $file;
		}
		closedir($handle);
		sort($themelist, SORT_STRING);

		if ($allow = trim($this->config["allow_themes"]))
		{
			$ath = explode(",", $allow);

			if (is_array($ath) && $ath[0])
				$themelist = array_intersect ($ath, $themelist);
		}
		return $themelist;
	}

	function GetTimeStringFormatted($time)
	{
		return date($this->config["date_format"]." ".
			$this->config["time_format_seconds"], strtotime($time));
	}

	function GetUnixTimeFormatted($time)
	{
		return date($this->config["date_format"]." ".
			$this->config["time_format_seconds"], $time);
	}

	function GetPageTimeFormatted()
	{
		return $this->GetTimeStringFormatted($this->page["modified"]);
	}

	// LANG FUNCTIONS
	function SetResource($lang)
	{
		$this->resource = & $this->resources[$lang];
	}

	function SetLanguage($lang)
	{
		$this->LoadResource($lang);
		$this->language = &$this->languages[$lang];

		setlocale(LC_CTYPE, $this->language["locale"]);

		$this->language["locale"] = setlocale(LC_CTYPE, 0);
		$this->language["UPPER"]     = "[".$this->language["UPPER_P"]."]";
		$this->language["UPPERNUM"]  = "[0-9".$this->language["UPPER_P"]."]";
		$this->language["LOWER"]     = "[".$this->language["LOWER_P"]."]";
		$this->language["ALPHA"]     = "[".$this->language["ALPHA_P"]."]";
		$this->language["ALPHANUM"]  = "[0-9".$this->language["ALPHA_P"]."]";
		$this->language["ALPHANUM_P"]= "0-9".$this->language["ALPHA_P"];
	}

	function LoadResource($lang)
	{
		if (!isset($this->resources[$lang]))
		{
			$resourcefile = "lang/wacko.".$lang.".php";
			if (@file_exists($resourcefile)) include($resourcefile);

			// wacko.all
			$resourcefile = "lang/wacko.all.php";
			if (!$this->resources["all"])
			{
				if (@file_exists($resourcefile)) include($resourcefile);
				$this->resources["all"] = & $wackoAllResource;
			}
			if (!isset($wackoTranslation)) $wackoTranslation = array();
			$wackoResource = array_merge($wackoTranslation, $this->resources["all"]);

			// theme
			$resourcefile = "themes/".$this->config["theme"]."/lang/wacko.".$lang.".php";
			if (@file_exists($resourcefile)) include($resourcefile);
			if (!isset($themeResource)) $themeResource = "";
			$wackoResource = array_merge((array)$wackoResource, (array)$themeResource);

			// wacko.all theme
			$resourcefile = "themes/".$this->config["theme"]."/lang/wacko.all.php";
			if (@file_exists($resourcefile)) include($resourcefile);
			$wackoResource = array_merge((array)$wackoResource, (array)$themeResource);

			$this->resources[$lang] = $wackoResource;

			$this->LoadLang($lang);
		}
	}

	function LoadLang($lang)
	{
		if (!isset($this->languages[$lang]))
		{
			$resourcefile = "lang/lang.".$lang.".php";
			if (@file_exists($resourcefile)) include($resourcefile);

			$this->languages[$lang] = $wackoLanguage;
			$ue = @array_flip($wackoLanguage["unicode_entities"]);
			if (!isset($ue)) $ue = array();
			$this->unicode_entities = array_merge($this->unicode_entities, $ue);
			unset($this->unicode_entities[0]);
		}
	}

	function LoadAllLanguages()
	{
		if (!$this->config["multilanguage"]) return;

		$langs = $this->AvailableLanguages();
		foreach ($langs as $lang)
		$this->LoadLang($lang);
	}

	function AvailableLanguages()
	{
		if (!$this->_langlist)
		{
			$handle = opendir("lang");
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "."
				&& $file != ".."
				&& $file != "wacko.all.php"
				&& !is_dir("lang/".$file)
				&& 1 == preg_match("/^wacko\.(.*?)\.php$/", $file, $match))
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

	function UserAgentLanguage()
	{
		if ($this->config["multilanguage"])
		{
			if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			{
				$this->userlang = $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

				// Check whether we have language files for this language
				if(!in_array($this->userlang, $this->AvailableLanguages()))
				{
					// The HTTP_ACCEPT_LANGUAGE language doesn't have any language files so use the admin set language instead
					$this->userlang = $lang = $this->config["language"];
				}
			}
			else
			{
				$this->userlang = $lang = $this->config["language"];
			}
		}
		else if (!$lang) $this->userlang = $lang = $this->config["language"];

		return $lang;
	}

	function GetTranslation($name, $lang = "", $dounicode = true)
	{
		if (!$this->config["multilanguage"])
			return $this->resource[$name];

		if (!$lang && $this->userlang != $this->pagelang)
			$lang = $this->userlang;

		if ($lang != "")
		{
			$this->LoadResource($lang);
			return (is_array($this->resources[$lang][$name]))
				? $this->resources[$lang][$name]
				: ($dounicode
					? $this->DoUnicodeEntities($this->resources[$lang][$name], $lang)
					: $this->resources[$lang][$name]);
		}
		return $this->resource[$name];
	}

	function FormatTranslation($name, $lang = "")
	{
		$string = $this->GetTranslation($name, $lang, false);
		$this->format_safe = false;
		$string = $this->Format($string);
		$this->format_safe = true;
		return $string;
	}

	function DetermineLang()
	{
		$langlist = $this->AvailableLanguages();
		//!!!! wrong code, maybe!
		if ($this->GetMethod() == "edit" && (isset($_GET["add"]) && $_GET["add"] == 1))
			if (isset($_REQUEST["lang"]) && $_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
				$lang = $_REQUEST["lang"];
			else
				$lang = $this->userlang;
			else
				$lang = $this->pagelang;

		return $lang;
	}

	function SetPageLang($lang)
	{
		if (!$lang) return false;

		$this->pagelang = $lang;
		$this->SetLanguage($lang);
		return true;
	}

	function GetCharset()
	{
		$lang = $this->DetermineLang();
		$this->LoadResource($lang);
		return $this->languages[$lang]["charset"];
	}

	function DoUnicodeEntities($string, $lang)
	{
		if (!$this->config["multilanguage"]) return $string;

		$_lang = $this->DetermineLang();

		if ($lang == $_lang) return $string;

		$this->LoadResource($lang);

		if (is_array($this->languages[$lang]["unicode_entities"]))
			return @strtr($string, $this->languages[$lang]["unicode_entities"]);
		else
			return $string;
	}

	function tryUtfDecode ($string)
	{
		$t1 = $this->utf8ToUnicodeEntities($string);
		$t2 = @strtr($t1, $this->unicode_entities);
		if (!preg_match("/\&\#[0-9]+\;/", $t2))
			$string = $t2;

		return $string;
	}

	function utf8ToUnicodeEntities($source)
	{
		// array used to figure what number to decrement from character order value
		// according to number of characters used to map unicode to ascii by utf-8
		$decrement[4] = 240; $decrement[3] = 224;
		$decrement[2] = 192; $decrement[1] = 0;

		// the number of bits to shift each charNum by
		$shift[1][0] = 0;  $shift[2][0] = 6;
		$shift[2][1] = 0;  $shift[3][0] = 12;
		$shift[3][1] = 6;  $shift[3][2] = 0;
		$shift[4][0] = 18; $shift[4][1] = 12;
		$shift[4][2] = 6;  $shift[4][3] = 0;

		$pos = 0;
		$len = strlen ($source);
		$encodedString = '';
		while ($pos < $len)
		{
			$asciiPos = ord (substr ($source, $pos, 1));
			if (($asciiPos >= 240) && ($asciiPos <= 255))
			{
				// 4 chars representing one unicode character
				$thisLetter = substr ($source, $pos, 4);
				$pos += 4;
			}
			else if (($asciiPos >= 224) && ($asciiPos <= 239))
			{
				// 3 chars representing one unicode character
				$thisLetter = substr ($source, $pos, 3);
				$pos += 3;
			}
			else if (($asciiPos >= 192) && ($asciiPos <= 223))
			{
				// 2 chars representing one unicode character
				$thisLetter = substr ($source, $pos, 2);
				$pos += 2;
			}
			else
			{
				// 1 char (lower ascii)
				$thisLetter = substr ($source, $pos, 1);
				$pos += 1;
			}

			// process the string representing the letter to a unicode entity
			$thisLen = strlen ($thisLetter);
			if ($thisLen > 1)
			{
				$thisPos = 0;
				$decimalCode = 0;
				while ($thisPos < $thisLen)
				{
					$thisCharOrd = ord (substr ($thisLetter, $thisPos, 1));
					if ($thisPos == 0)
					{
						$charNum = intval ($thisCharOrd - $decrement[$thisLen]);
						$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
					}
					else
					{
						$charNum = intval ($thisCharOrd - 128);
						$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
					}
					$thisPos++;
				}
				$encodedLetter = "&#". $decimalCode . ';';
			}
			else
				$encodedLetter = $thisLetter;
				$encodedString .= $encodedLetter;
		}
		return $encodedString;
	}

	// PAGES
	function NpjTranslit($tag, $strtolow = TRAN_LOWERCASE, $donotload = TRAN_LOAD)
	{
		// Lookup transliteration result in the cache and return it if found
		static $npj_cache;
		$cach_key = $tag.$strtolow.$donotload;

		if (isset($npj_cache[$cach_key]))
		{
			return $npj_cache[$cach_key];
		}

		$_lang = NULL;

		if (!$this->config["multilanguage"]) $donotload = 1;

		if (!$donotload)
		{
			if ($page = $this->LoadPage($tag, "", LOAD_CACHE, LOAD_META))
			{
				$_lang = $this->language["code"];

				if ($page["lang"])
					$lang = $page["lang"];
				else
					$lang = $this->config["language"];

				$this->SetLanguage($lang);
			}
		}

		$tag = str_replace("//", "/", $tag);
		$tag = str_replace("-", "", $tag);
		$tag = str_replace(" ", "", $tag);
		$tag = str_replace("'", "_", $tag);
		$_tag = strtolower($tag);

		if ($strtolow)
		{
			$tag = @strtr($_tag, $this->NpjMacros);
		}
		else
		{
			foreach($this->NpjMacros as $macro => $value)
			{
				while (($pos = strpos($_tag, $macro)) !== false)
				{
					$_tag = substr_replace($_tag, $value, $pos, strlen($macro));
					$tag = substr_replace($tag, ucfirst($value), $pos, strlen($macro));
				}
			}
		}

		$tag = @strtr($tag, $this->language["NpjLettersFrom"], $this->language["NpjLettersTo"]);
		$tag = @strtr($tag, $this->language["NpjBiLetters"]);

		if ($strtolow) $tag = strtolower($tag);

		if ($_lang)
			$this->SetLanguage($_lang);

		$result =  rtrim($tag, "/");

		// Put transliteration result in the cache
		$npj_cache[$cach_key] = $result;

		return $result;
	}

	function GetKeywords()
	{
		if ($this->page["keywords"])
			return $this->page["keywords"];
		else
			return $this->config["meta_keywords"];
	}

	function GetDescription()
	{
		if ($this->page["description"])
			return $this->page["description"];
		else
			return $this->config["meta_description"];
	}

	// wrapper for OldLoadPage
	function LoadPage($tag, $time = "", $cache = LOAD_CACHE, $metadataonly = LOAD_ALL)
	{
		if ($this->GetCachedWantedPage($tag) == 1) return "";

		// 1. search for supertag
		$page = $this->OldLoadPage($this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD), $time, $cache, true, $metadataonly);

		// 2. if not found, search for tag
		if (!$page)
			$page = $this->OldLoadPage($tag, $time, $cache, false, $metadataonly);

		// 3. still nothing? file under wanted
		if (!$page) $this->CacheWantedPage($tag);

		return $page;
	}

	function OldLoadPage($tag, $time = "", $cache = 1, $supertagged = false, $metadataonly = 0)
	{
		if ($tag == "") return "";

		$page = NULL;

		if (!$supertagged)
			$supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);
		else
			$supertag = $tag;

		// retrieve from cache
		if (!$time && $cache && ($cachedPage = $this->GetCachedPage($supertag, $metadataonly)))
			$page = $cachedPage;

		// load page
		if ($metadataonly)
			$what = $this->pages_meta;
		else
			$what = "*";

		if (!$page)
		{
			if ($supertagged)
			{
				$page = $this->LoadSingle(
					"SELECT ".$what." ".
					"FROM ".$this->config["table_prefix"]."pages ".
					"WHERE supertag = '".quote($this->dblink, $supertag)."' ".
					"LIMIT 1");

				$owner_id = $page["owner_id"];

				if ($time && $time != $page["modified"])
				{
					$this->CachePage($page, $metadataonly);

					$page = $this->LoadSingle(
						"SELECT ".$what." ".
						"FROM ".$this->config["table_prefix"]."revisions ".
						"WHERE supertag = '".quote($this->dblink, $supertag)."' ".
							"AND modified = '".quote($this->dblink, $time)."' ".
						"LIMIT 1");

					$page["owner_id"] = $owner_id;
				}
			}
			else if (!preg_match('/[^'.$this->language['ALPHANUM_P'].'\_\-]/', $tag))
			{
				$page = $this->LoadSingle(
					"SELECT ".$what." ".
					"FROM ".$this->config["table_prefix"]."pages ".
					"WHERE tag = '".quote($this->dblink, $tag)."' ".
					"LIMIT 1");

				$owner_id = $page["owner_id"];

				if ($time && $time != $page["modified"])
				{
					$this->CachePage($page, $metadataonly);

					$page = $this->LoadSingle(
						"SELECT ".$what." ".
						"FROM ".$this->config["table_prefix"]."revisions ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
							"AND modified = '".quote($this->dblink, $time)."' ".
						"LIMIT 1");

					$page["owner_id"] = $owner_id;
				}
			}
		}
		// cache result
		if (!$time && !$cachedPage) $this->CachePage($page, $metadataonly);

		return $page;
	}

	function GetCachedPage($supertag, $metadataonly = 0)
	{
		if (isset($this->pageCache[$supertag]))
		{
			if ($this->pageCache[$supertag]["mdonly"] == 0 || $metadataonly == $this->pageCache[$supertag]["mdonly"])
			{
				return $this->pageCache[$supertag];
			}
		}
		else return false;
	}

	function CachePage($page, $metadataonly = 0)
	{
		$page["supertag"] = $this->NpjTranslit($page["supertag"], TRAN_LOWERCASE, TRAN_DONTLOAD);

		$this->pageCache[$page["supertag"]] = $page;
		$this->pageCache[$page["supertag"]]["mdonly"] = $metadataonly;
	}

	function CacheWantedPage($tag, $check = 0)
	{
		if ($check == 0)
			$this->wantedCache[$this->language["code"]][$tag] = 1;
		else if ($this->OldLoadPage($tag, "", 1, false, 1) == "")
			$this->wantedCache[$this->language["code"]][$tag] = 1;
	}

	function ClearCacheWantedPage($tag)
	{
		$this->wantedCache[$this->language["code"]][$tag] = 0;
	}

	function GetCachedWantedPage($tag)
	{
		if (isset( $this->wantedCache[$this->language["code"]][$tag] ))
			return $this->wantedCache[$this->language["code"]][$tag];
		else
			return '';
	}

	function CacheLinks()
	{
		$page_id = $this->GetPageId();
		if ($links = $this->LoadAll(
			"SELECT * ".
			"FROM ".$this->config["table_prefix"]."links ".
			"WHERE from_page_id='".quote($this->dblink, $page_id)."'"))
		{
			$cl = count($links);
			if (!isset($cl))$cl = 0;

			for ($i = 0; $i < $cl; $i++)
			{
				$pages[$i] = $links[$i]["to_tag"];
			}
		}

		$user = $this->GetUser();
		if (!isset($cl))$cl = 0;
		$pages[$cl] = $user["name"];
		$bookm = $this->GetDefaultBookmarks($user["lang"], "site")."\n".
					($user["bookmarks"]
						? $user["bookmarks"]
						: $this->GetDefaultBookmarks($user["lang"]));
		$bookmarks = explode("\n", $bookm);

		for ($i = 0; $i <= count($bookmarks); $i++)
		{
			if (!isset($cl))$cl = 0;
			if (preg_match("/^[\(\[]/", (isset($bookmarks[$i])) ? ($bookmarks[$i]) : "" ))
				$pages[$cl+$i] = preg_replace("/^(.*?)\s.*$/","\\1",preg_replace("/[\[\]\(\)]/","",$bookmarks[$i]));
		}

		$pages[] = $this->GetPageTag();
		$spages = $pages;
		$spages_str = '';
		$pages_str = '';

		foreach ($pages as $page)
		{
			if ($page != '')
			{
				$spages_str	.= "'".quote($this->dblink, $this->NpjTranslit($page, TRAN_LOWERCASE, TRAN_DONTLOAD))."', ";
				$pages_str	.= "'".quote($this->dblink, $page)."', ";
			}
		}

		$spages_str = substr($spages_str, 0, strlen($spages_str) - 2);
		$pages_str = substr($pages_str, 0, strlen($pages_str) - 2);

		if ($links = $this->LoadAll(
		"SELECT ".$this->pages_meta." ".
		"FROM ".$this->config["table_prefix"]."pages ".
		"WHERE supertag IN (".$spages_str.")", 1))
		{
			for ($i = 0; $i < count($links); $i++)
			{
				$this->CachePage($links[$i], 1);
				$exists[] = $links[$i]["supertag"];
			}
		}

		$notexists = @array_values(@array_diff($spages, $exists));
		if (!isset($acl)) $acl = "";

		for ($i = 0; $i < count($notexists); $i++)
		{
			$this->CacheWantedPage($pages[array_search($notexists[$i], $spages)], 1);
			$this->CacheACL($notexists[$i], "read", 1, $acl);
		}

		if ($read_acls = $this->LoadAll(
		"SELECT a.* FROM ".$this->config["table_prefix"]."acls a ".
			"INNER JOIN ".$this->config["table_prefix"]."pages p ON (p.page_id = a.page_id) ".
		"WHERE BINARY p.tag IN (".$pages_str.") AND a.privilege = 'read'", 1))
		{
			for ($i = 0; $i < count($read_acls); $i++)
			{
				$this->CacheACL($read_acls[$i]["supertag"], "read", 1, $read_acls[$i]);
			}
		}
	}

	function SetPage($page)
	{
		$langlist = $this->AvailableLanguages();
		$this->page = $page;

		if ($this->page["tag"])
			$this->tag = $this->page["tag"];

		if ($page["lang"])
			$this->pagelang = $page["lang"];
		else if ($_REQUEST["add"] && $_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
			$this->pagelang = $_REQUEST["lang"];
		else if ($_REQUEST["add"])
			$this->pagelang = $this->userlang;
		else
			$this->pagelang = $this->config["language"];
	}

	// STANDARD QUERIES
	function LoadRevisions($page_id, $minor_edit = "")
	{
		$pages_meta = "p.page_id, p.owner_id, p.user_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.latest, p.handler, p.comment_on_id, p.lang, p.title, u.name as user ";

		$rev = $this->LoadAll(
			"SELECT p.revision_id AS revision_m_id, ".$pages_meta." ".
			"FROM ".$this->config["table_prefix"]."revisions p ".
				"INNER JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
			"WHERE p.page_id = '".quote($this->dblink, $page_id)."' ".
				($minor_edit
					? "AND p.minor_edit = '0' "
					: "").
			"ORDER BY p.modified DESC");

		if ($rev == true)
		{
			if ($cur = $this->LoadSingle(
				"SELECT p.page_id AS revision_m_id, ".$pages_meta." ".
				"FROM ".$this->config["table_prefix"]."pages p ".
					"INNER JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
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
			$rev = $this->LoadAll(
				"SELECT p.page_id AS revision_m_id, ".$pages_meta." ".
				"FROM ".$this->config["table_prefix"]."pages p ".
					"INNER JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
				"WHERE p.page_id = '".quote($this->dblink, $page_id)."' ".
				"ORDER BY p.modified DESC ".
				"LIMIT 1");
		}

		return $rev;
	}

	function LoadPagesLinkingTo($tag, $for = "")
	{
		return $this->LoadAll(
			"SELECT p.tag AS tag ".
			"FROM ".$this->config["table_prefix"]."links l ".
				"INNER JOIN ".$this->config["table_prefix"]."pages p ON (p.page_id = l.from_page_id) ".
			"WHERE ".($for
				? "p.tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
				"(l.to_supertag = '".quote($this->dblink, $this->NpJTranslit($tag))."')".
			" ORDER BY tag", 1);
	}

	function LoadRecentlyChanged($limit = 100, $for = "", $from = "", $minor_edit = "")
	{
		$limit = (int)$limit;

		if ($pages = $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.latest, p.handler, p.comment_on_id, p.lang, p.title, u.name as user ".
		"FROM ".$this->config["table_prefix"]."pages p ".
			"LEFT JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			($from
				? "AND p.modified <= '".quote($this->dblink, $from)." 23:59:59'"
				: "").
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
				: "").
			($minor_edit
				? "AND p.minor_edit = '0' "
				: "").
		"ORDER BY p.modified DESC ".
		"LIMIT ".$limit, 1))
		{
			foreach ($pages as $page)
			{
				$this->CachePage($page, 1);
			}

			if ($read_acls = $this->LoadAll(
			"SELECT a.* ".
			"FROM ".$this->config["table_prefix"]."acls a ".
				"INNER JOIN ".$this->config["table_prefix"]."pages p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
					: "").
			"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT ".$limit, 1))
			{
				for ($i = 0; $i < count($read_acls); $i++)
				{
					$this->CacheACL($read_acls[$i]["page_id"], "read", 1,$read_acls[$i]);
				}
			}
			return $pages;
		}
	}

	function LoadRecentlyComment($limit = 100, $for = "")
	{
		$limit = (int) $limit;

		if ($pages = $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.tag, p.supertag, p.created, p.modified, p.edit_note, p.minor_edit, p.latest, p.handler, p.comment_on_id, p.lang, p.title, p.body_r, u.name as user ".
		"FROM ".$this->config["table_prefix"]."pages p ".
			"LEFT JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
		"WHERE p.comment_on_id != '0' ".
			($for
				? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
				: "").
		"ORDER BY p.modified DESC ".
		"LIMIT ".$limit))
		{
			foreach ($pages as $page)
			{
				$this->CachePage($page, 1);
			}

			if ($read_acls = $this->LoadAll(
			"SELECT a.* ".
			"FROM ".$this->config["table_prefix"]."acls a ".
				"INNER JOIN ".$this->config["table_prefix"]."pages p ON (a.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.page_id = p.page_id ".
					($for
						? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
						: "").
			"AND a.privilege = 'read' ".
			"ORDER BY modified DESC ".
			"LIMIT ".$limit))

			for ($i = 0; $i < count($read_acls); $i++)
			{
				$this->CacheACL($read_acls[$i]["page_id"], "read", 1, $read_acls[$i]);
			}
			return $pages;
		}
	}

	function LoadWantedPages($for = "")
	{
		$pref = $this->config["table_prefix"];
		$sql = "SELECT DISTINCT l.to_tag AS wanted_tag ".
		"FROM ".$pref."links l ".
			"LEFT JOIN ".$pref."pages p ON ".
			"((l.to_tag = p.tag ".
				"AND l.to_supertag = '') ".
				"OR l.to_supertag = p.supertag) ".
		"WHERE ".
			($for
				? "l.to_tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
		"p.tag is NULL GROUP BY wanted_tag ".
		"ORDER BY wanted_tag ASC";
		return $this->LoadAll($sql);
	}

	function LoadOrphanedPages($for = "")
	{
		$pref = $this->config["table_prefix"];
		$sql = "SELECT DISTINCT page_id, tag FROM ".$pref."pages p ".
			"LEFT JOIN ".$pref."links l ON ".
			//     $pref."pages.tag = l.to_tag WHERE ".
			"((l.to_tag = p.tag ".
				"AND l.to_supertag = '') ".
				"OR l.to_supertag = p.supertag) ".
		"WHERE ".
			($for
				? "p.tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
		"l.to_page_id is NULL AND p.comment_on_id = '0' ".
		"ORDER BY tag ".
		"LIMIT 200";
		return $this->LoadAll($sql);
	}

	function LoadPageTitles() { return $this->LoadAll("SELECT DISTINCT tag FROM ".$this->config["table_prefix"]."pages ORDER BY tag"); }
	function LoadAllPages() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE comment_on_id = '0' ORDER BY BINARY tag"); }
	function LoadAllPagesByTime() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE comment_on_id = '0' ORDER BY modified DESC, BINARY tag"); }

	function FullTextSearch($phrase,$filter)
	{
		return $this->LoadAll(
			"SELECT ".$this->pages_meta.", body ".
			"FROM ".$this->config["table_prefix"]."pages ".
			"WHERE (( match(body) against('".quote($this->dblink, $phrase)."') ".
				"OR lower(tag) LIKE lower('%".quote($this->dblink, $phrase)."%')) ".
				($filter
					? "AND comment_on_id = '0'"
					: "").
				" )");
	}

	function TagSearch($phrase) { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE lower(tag) LIKE binary lower('%".quote($this->dblink, $phrase)."%') ORDER BY supertag"); }

	function LoadRecentlyDeleted($limit = 1000, $cache = 1)
	{
		$_metaArr	= explode(',', $this->pages_meta);
		foreach($_metaArr as $_metaStr) $meta[] = $this->config['table_prefix'].'revisions.'.trim($_metaStr);
		$meta		= implode(', ', $meta);

		return $this->LoadAll(
			"SELECT DISTINCT $meta, MAX({$this->config['table_prefix']}revisions.modified) AS date ".
			"FROM {$this->config['table_prefix']}revisions ".
			"LEFT JOIN {$this->config['table_prefix']}pages ON ".
				"({$this->config['table_prefix']}revisions.tag = {$this->config['table_prefix']}pages.tag) ".
			"WHERE {$this->config['table_prefix']}pages.tag IS NULL ".
			"GROUP BY {$this->config['table_prefix']}revisions.tag ".
			"ORDER BY date DESC, {$this->config['table_prefix']}revisions.tag ASC ".
			( $limit > 0 ? "LIMIT $limit" : '' ), $cache);
	}

	// MAILER
	// $email				- recipient address
	// $subject, $message 	- self-explaining
	// $from				- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	// $supress_ssl			- don't change all http links to https links in the message body
	function SendMail($email, $subject, $message, $charset = "")
	{
		if (!$email) return;

		$headers = "From: =?". $this->GetCharset() ."?B?". base64_encode($this->config["wacko_name"]) ."?= <".$this->config["admin_email"].">\r\n";
		#$headers = "From: ".( $from ? $from : '"'.$this->config['wacko_name'].'" <'.$this->config['admin_email'].'>' )."\n";
		$headers .= "X-Mailer: PHP/".phpversion()."\r\n"; //mailer
		$headers .= "X-Priority: 3\r\n"; //1 UrgentMessage, 3 Normal
		$headers .= "X-Wacko: ".$this->config["base_url"]."\r\n";
		$headers .= "Content-Type: text/plain; charset=".$this->GetCharset()."\r\n";
		#$subject =  "=?".$this->GetCharset()."?B?" . base64_encode($subject) . "?=";
		$subject = ( $subject ? "=?".( $charset ? $charset : $this->GetCharset() )."?B?" . base64_encode($subject) . "?=" : "" );

		// in ssl mode substitute protocol name in links substrings
		if ($this->config["ssl"] == true && $supress_ssl === false) $message = str_replace("http://", "https://", $message);

		$message = wordwrap($message, 74, "\n", 0);
		@mail($email, $subject, $message, $headers);
	}

	// PAGE SAVING ROUTINE
	// $tag			- page address
	// $body		- page body (plain text)
	// $edit_note	- edit summary
	// $minor_edit	- minor edit
	// $comment_on_id	- commented page id
	// $title		- page name (metadata)
	// $mute		- supress email reminders and xml rss recompilation
	// $user		- attach guest pseudonym
	function SavePage($tag, $body, $edit_note = "", $minor_edit = "0", $comment_on_id = "0", $title = "", $mute = false, $user = false)
	{
		// user data
		$ip = $this->GetUserIP();

		if ($user === "")
		{
			$user = GUEST;
		}

		// current user is owner; if user is logged in! otherwise, no owner.
		if ($this->GetUserName())
		{
			$owner	= $user = $this->GetUserName();
			$owner_id	= $user_id = $this->GetUserId();
			$reg	= true;
		}
		else if ($comment_on_id)
		{
			$owner	= GUEST;
			$reg	= false;
		}
		else
		{
			$owner	= "";
			$reg	= false;
		}

		$page_id = $this->GetPageId($tag);

		/*
			ANTISPAM

			We load in the external antispam.conf file and then search the entire body content for each of the
			words defined as spam.  If we find any then we return from the function, not saving the changes.
		*/
		$this->spam = file("antispam.conf", 1);

		if ($this->config["spam_filter"] && is_array($this->spam))
		foreach ($this->spam as $spam)
		{
			if (strpos($body, trim($spam))!== false) return 'Error: Identified Potential Spam: '.$spam;
		}

		// write tag
		if($_POST["tag"])
		{
			$this->tag = $tag = $_POST["tag"];
			$this->supertag = $this->NpjTranslit($tag);
		}

		if (!$this->NpjTranslit($tag)) return;

		// cache handling
		if ($this->config["cache"])
		{
			if ($comment_on_id)
			{
				$this->cache->CacheInvalidate($this->GetCommentOnTag($comment_on_tag));
			}
			else
			{
				$this->cache->CacheInvalidate($this->tag);
				$this->cache->CacheInvalidate($this->supertag);
			}
		}

		// check privileges
		if ($this->HasAccess("write", $page_id) || ($comment_on_id && $this->HasAccess("comment", $comment_on_id)))
		{
			// preformatter (macros and such)
			$body = $this->Format($body, "preformat");

			// PAGE DOESN'T EXISTS, SAVING A NEW PAGE
			if (!$oldPage = $this->LoadPage($tag))
			{
				$langlist = $this->AvailableLanguages();

				if ($_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
					$lang = $_REQUEST["lang"];
				else
					$lang = $this->userlang;

				if (!$lang)
					$lang = $this->config["language"];

				$this->SetLanguage($lang);

				// getting title
				if ($title == "")
				{
					if ($comment_on_id == true)
						$title = $this->GetTranslation("Comment")." ".substr($tag, 7);
					else
						$title = $this->GetPageTitle($tag);
				}

				$body_r = $this->Format($body, "wacko");
				if ($this->config["paragrafica"] && !$comment_on_id)
				{
					$body_r = $this->Format($body_r, "paragrafica");
					$body_toc = $this->body_toc;
				}

				// create appropriate acls
				if (strstr($this->context[$this->current_context], "/") && !$comment_on_id)
				{
					$root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context] );
					$root_id = $this->GetPageId($root);
					$write_acl = $this->LoadAcl($this->GetPageId($root), "write");
					while ($write_acl["default"] == 1)
					{
						$_root = $root;
						$root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $root );
						if ($root == $_root) break;
						# $root_id = $this->GetPageId($root); // do we need this?
						$write_acl = $this->LoadAcl($root_id, "write");
					}

					$write_acl = $write_acl["list"];
					$read_acl = $this->LoadAcl($root_id, "read");
					$read_acl = $read_acl["list"];
					$comment_acl = $this->LoadAcl($root_id, "comment");
					$comment_acl = $comment_acl["list"];
				}
				else if ($comment_on_id)
				{
					// Give comments the same rights as their parent page
					$read_acl = $this->LoadAcl($comment_on_id, "read");
					$read_acl = $read_acl["list"];
					$write_acl = $this->LoadAcl($comment_on_id, "write");
					$write_acl = $write_acl["list"];
					$comment_acl = $this->LoadAcl($comment_on_id, "comment");
					$comment_acl = $comment_acl["list"];
				}
				else
				{
					$read_acl  = $this->config["default_read_acl"];
					$write_acl = $this->config["default_write_acl"];
					$comment_acl = $this->config["default_comment_acl"];
				}

				$this->Query(
					"INSERT INTO ".$this->config["table_prefix"]."pages SET ".
						"comment_on_id 	= '".quote($this->dblink, $comment_on_id)."', ".
						"created 		= NOW(), ".
						"modified 			= NOW(), ".
						"owner_id 		= '".quote($this->dblink, $owner_id)."', ".
						"user_id 		= '".quote($this->dblink, $user_id)."', ".
						"ip 			= '".quote($this->dblink, $ip)."', ".
						"latest 		= '1', ".
						"supertag 		= '".quote($this->dblink, $this->NpjTranslit($tag))."', ".
						"body 			= '".quote($this->dblink, $body)."', ".
						"body_r 		= '".quote($this->dblink, $body_r)."', ".
						"body_toc 		= '".quote($this->dblink, $body_toc)."', ".
						"edit_note 		= '".quote($this->dblink, $edit_note)."', ".
						"minor_edit 	= '".quote($this->dblink, $minor_edit)."', ".
						"lang 			= '".quote($this->dblink, $lang)."', ".
						"tag 			= '".quote($this->dblink, $tag)."', ".
						"title 			= '".quote($this->dblink, htmlspecialchars($title))."'");

				// saving acls
				$page_id = $this->GetPageId($tag);
				$this->SaveAcl($page_id, "write", $write_acl);
				$this->SaveAcl($page_id, "read", $read_acl);
				$this->SaveAcl($page_id, "comment", $comment_acl);

				// counters
				if ($comment_on_id)
				{
					// updating comments count for commented page
					$this->Query(
						"UPDATE {$this->config['table_prefix']}pages SET ".
							"comments	= '".(int)$this->CountComments($comment_on_id)."' ".
						"WHERE tag = '".quote($this->dblink, $this->GetCommentOnTag($comment_on_id))."' ".
						"LIMIT 1");

					// update user comments count
					$this->Query(
						"UPDATE {$this->config['user_table']} ".
						"SET total_comments = total_comments + 1 ".
						"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
						"LIMIT 1");
				}
				else
				{
					// update user pages count
					$this->Query(
						"UPDATE {$this->config['user_table']} ".
						"SET total_pages = total_pages + 1 ".
						"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
						"LIMIT 1");
				}

				// set watch
				if (!$this->config["disable_autosubscribe"] && !$comment_on_id)
				{
					// subscribe the author
					if ($reg === true) $this->SetWatch($user_id, $page_id);
				}

				if ($comment_on_id)
				{
					// notifying watchers
					$user_id = $this->GetUserId();
					$username = $this->GetUserName();
					$title = $this->GetPageTitle(0, $comment_on_id);
					$Watchers = $this->LoadAll(
									"SELECT DISTINCT user_id ".
									"FROM ".$this->config["table_prefix"]."watches ".
									"WHERE page_id = '".quote($this->dblink, $comment_on_id)."'");

					if ($Watchers && !$mute) foreach ($Watchers as $Watcher)

					if ($Watcher["user_id"] != $user_id && $Watcher['user'] != GUEST)
					{
						// assert that user has no comments pending...
						$pending = $this->LoadSingle(
							"SELECT comment_id ".
							"FROM {$this->config['table_prefix']}watches ".
							"WHERE page_id = '".quote($this->dblink, $comment_on_id)."' ".
								"AND user_id = '".quote($this->dblink, $Watcher['user_id'])."' ".
							"LIMIT 1");

						// ...and add one if so
						if ($pending['comment_id'] == false)
						{
							$this->Query(
								"UPDATE {$this->config['table_prefix']}watches ".
								"SET comment_id = '".quote($this->dblink, $page_id)."' ".
								"WHERE page_id = '".quote($this->dblink, $comment_on_id)."' ".
									"AND user_id = '".quote($this->dblink, $Watcher['user_id'])."'");
						}
						else continue;	// skip current watcher

						#$_user = $this->GetUser();
						$Watcher["user"] = $this->GetUserNameById($Watcher["user_id"]);
						#$this->SetUser($Watcher, 0);

						if ($this->HasAccess("read", $comment_on_id, $Watcher["user"]))
						{
							$_user = $this->LoadSingle(
								"SELECT email, lang, more, email_confirm ".
								"FROM " .$this->config["user_table"]." ".
								"WHERE user_id = '".quote($this->dblink, $Watcher["user_id"])."'");
							$_user["options"] = $this->DecomposeOptions($_user["more"]);

							if ($_user["email_confirm"] == "" && $_user["options"]["send_watchmail"] != "0")
							{
								$lang = $_user["lang"];
								$this->LoadResource($lang);
								$this->SetResource ($lang);
								$this->SetLanguage ($lang);

								$subject = "[".$this->config["wacko_name"]."] ".$this->GetTranslation("CommentForWatchedPage", $lang)."'".$title."'";
								$message = $this->GetTranslation("EmailHello", $lang). $Watcher["user"].".\n\n".
											$username.
											$this->GetTranslation("SomeoneCommented", $lang)."\n".
											$this->Href("",$this->GetCommentOnTag($comment_on_id),"")."\n\n".
											"----------------------------------------------------------------------\n\n".
											$this->Format($body_r, "post_wacko")."\n\n".
											"----------------------------------------------------------------------\n\n".
											$this->GetTranslation("EmailGoodbye", $lang)."\n".
											$this->config["wacko_name"]."\n".
											$this->config["base_url"];

								$this->SendMail($_user["email"], $subject, $message);
							}
						}
						else
						{
							$this->ClearWatch($Watcher['user_id'], $comment_on_id);
						} // end of hasAccess
					} // end of watchers
					$this->LoadResource($this->userlang);
					$this->SetResource ($this->userlang);
					$this->SetLanguage ($this->userlang);
				} // end of comment_on
			} // end of new page
			// RESAVING AN OLD PAGE, CREATING REVISION
			else
			{
				$this->SetLanguage($this->pagelang);
				$body_r = $this->Format($body, "wacko");

				if ($this->config["paragrafica"])
				{
					$body_r = $this->Format($body_r, "paragrafica");
					$body_toc = $this->body_toc;
				}

				// aha! page isn't new. keep owner!
				$owner_id = $oldPage["owner_id"];

				// only if page has been actually changed
				if ($oldPage['body'] != $body || $oldPage['title'] != $title)
				{
					// Dont save revisions for comments.  Personally I think we should.
					if (!$oldPage[comment_on_id])
					{
						$this->SaveRevision($oldPage);
					}

					// update current page copy
					$this->Query(
						"UPDATE ".$this->config["table_prefix"]."pages SET ".
							"comment_on_id	= '".quote($this->dblink, $comment_on_id)."', ".
							"modified			= NOW(), ".
							"created		= '".quote($this->dblink, $oldPage['created'])."', ".
							"owner_id		= '".quote($this->dblink, $owner_id)."', ".
							"user_id		= '".quote($this->dblink, $user_id)."', ".
							#"description	= '".quote($this->dblink, ($oldPage['comment_on_id'] || $oldPage['description'] ? $oldPage['description'] : $desc ))."', ".
							"supertag		= '".$this->NpjTranslit($tag)."', ".
							"body			= '".quote($this->dblink, $body)."', ".
							"body_r			= '".quote($this->dblink, $body_r)."', ".
							"body_toc		= '".quote($this->dblink, $body_toc)."', ".
							"edit_note		= '".quote($this->dblink, $edit_note)."', ".
							"minor_edit		= '".quote($this->dblink, $minor_edit)."', ".
							"title			= '".quote($this->dblink, htmlspecialchars($title))."' ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"LIMIT 1");
				}

				// Since there's no revision history for comments it's pointless to do the following for them.
				if (!$comment_on_id)
				{
					// revisions diff
					$page = $this->LoadSingle(
						"SELECT ".$this->pages_meta." ".
						"FROM ".$this->config["table_prefix"]."revisions ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"ORDER BY modified DESC");
					$_GET["a"] = -1;
					$_GET["b"] = $page["page_id"];
					$_GET["fastdiff"] = 1;
					$diff = $this->IncludeBuffered("handlers/page/diff.php", "oops", array("source" => 1));

					// notifying watchers
					$page_id = $this->GetPageId($tag);
					$title = $this->GetPageTitle(0, $page_id);
					#$user_id = $this->GetUserId();
					$username = $user;

					$Watchers = $this->LoadAll(
						"SELECT DISTINCT user_id ".
						"FROM ".$this->config["table_prefix"]."watches"." ".
						"WHERE page_id = '".quote($this->dblink, $page_id)."'");

					if ($Watchers && !$mute)
					{
						foreach ($Watchers as $Watcher)
						if ($Watcher["user_id"] !=  $user_id)
						{
							#$_user = $this->GetUser();
							$Watcher["user"] = $this->GetUserNameById($Watcher["user_id"]);
							#$this->SetUser($Watcher, 0);
							$lang = $Watcher["lang"];

							if ($this->HasAccess("read", $page_id, $Watcher["user"]))
							{
								$_user = $this->LoadSingle(
									"SELECT email, lang, more, email_confirm ".
									"FROM " .$this->config["user_table"]." ".
									"WHERE user_id = '".quote($this->dblink, $Watcher["user_id"])."'");

								$_user["options"] = $this->DecomposeOptions($_user["more"]);

								if ($_user["email_confirm"] == "" && $_user["options"]["send_watchmail"] != "0")
								{
									$lang = $_user["lang"];
									$this->LoadResource($lang);
									$this->SetResource ($lang);
									$this->SetLanguage ($lang);

									$subject = "[".$this->config["wacko_name"]."] ".$this->GetTranslation("WatchedPageChanged", $lang)."'".$tag."'";
									$message = $this->GetTranslation("EmailHello", $lang). $Watcher["user"]."\n\n".
										$username.
										$this->GetTranslation("SomeoneChangedThisPage", $lang)."\n".
										$title."\n".
										$this->Href('', $tag)."\n\n".
										"======================================================================".
										$this->Format($diff, "html2mail").
										"\n======================================================================\n\n".
										$this->GetTranslation("EmailGoodbye", $lang)."\n".
										$this->config["wacko_name"]."\n".
										$this->config["base_url"];

									$this->SendMail($_user["email"], $subject, $message);
								}
							} // end of hasaccess
						} // end of watchers
						$this->LoadResource($this->userlang);
						$this->SetResource ($this->userlang);
						$this->SetLanguage ($this->userlang);
					}
				} // end of new != old
			} // end of existing page
		}

		// writing xmls

		if ($mute === false)
		{
			if (!$oldPage['comment_on_id'] || !$comment_on_id)
			{
				$this->UseClass('rss', 'classes/');
				$xml = new RSS($this);
				$xml->Changes();
				$xml->Comments();

				if ($this->config["news_cluster"])
				{
					if (substr($this->tag, 0, strlen($this->config['news_cluster'].'/')) == $this->config['news_cluster'].'/')
						$xml->News();
				}

				if($this->config["xml_sitemap"])
				{
					$this->SiteMap();
				}

				unset($xml);
			}
		}

		return $body_r;
	}

	// create revision of a given page
	function SaveRevision($oldPage)
	{
		if (!$oldPage) return false;

		// prepare input
		foreach ($oldPage as $key => $val)
		{
			$oldPage[$key] = quote($this->dblink, $oldPage[$key]);
		}

		// move revision
		$this->Query(
			"INSERT INTO {$this->config['table_prefix']}revisions (page_id, tag, modified, body, edit_note, minor_edit, owner_id, user_id, latest, handler, comment_on_id, supertag, title, keywords, description) ".
			"VALUES ('{$oldPage['page_id']}','{$oldPage['tag']}', '{$oldPage['modified']}', '{$oldPage['body']}', '{$oldPage['edit_note']}', '{$oldPage['minor_edit']}', '{$oldPage['owner_id']}', '{$oldPage['user_id']}', '0', '{$oldPage['handler']}', '{$oldPage['comment_on_id']}', '{$oldPage['supertag']}', '{$oldPage['title']}', '{$oldPage['keywords']}', '{$oldPage['description']}')");

		// update user statistics for revisions made
		if ($user = $this->GetUser()) $this->Query(
			"UPDATE {$this->config['user_table']} ".
			"SET total_revisions = total_revisions + 1 ".
			"WHERE name = '".quote($this->dblink, $user['name'])."' ".
			"LIMIT 1");
	}

	// update metadata of a given page
	function SaveMeta($page_id, $metadata)
	{
		if ($this->UserIsOwner($page_id) || $this->IsAdmin())
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."pages SET ".
					"lang = '".quote($this->dblink, $metadata["lang"])."', ".
					"title = '".quote($this->dblink, htmlspecialchars($metadata["title"]))."', ".
					"keywords = '".quote($this->dblink, $metadata["keywords"])."', ".
					"description = '".quote($this->dblink, $metadata["description"])."' ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
				"LIMIT 1");
		}
		return true;
	}

	// COOKIES
	function SetSessionCookie($name, $value, $dummy = NULL, $secure = 0, $httponly = 0)
	{
		// The HttpOnly cookie flag is only supported in PHP >= 5.2.0
		$httponly = 1;
		setcookie($this->config["session_prefix"].'_'.$this->config["cookie_prefix"].$name, $value, 0, "/", "", ( $secure ? true : false ), ( $httponly ? true : false ));
		$_COOKIE[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].$name] = $value;
	}

	function SetPersistentCookie($name, $value, $days = 0, $secure = 0, $httponly = 0)
	{
		// set to default if no pediod given
		if ($days == 0) $days = $this->config["cookie_session"];

		// The HttpOnly cookie flag is only supported in PHP >= 5.2.0
		$httponly = 1;
		setcookie($this->config["session_prefix"].'_'.$this->config["cookie_prefix"].$name, $value, time() + $days * 24 * 3600, "/", "", ( $secure ? true : false ), ( $httponly ? true : false ));
		$_COOKIE[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].$name] = $value;
	}

	function DeleteCookie($name, $prefix = false)
	{
		if ($prefix == false)
			$prefix = $this->config["session_prefix"].'_'.$this->config["cookie_prefix"];
		else
			$prefix = "";

		setcookie($prefix.$name, "", 1, "/", "");
		$_COOKIE[$prefix.$name] = "";
	}

	function GetCookie($name)
	{
		return $_COOKIE[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].$name];
	}

	// HTTP/REQUEST/LINK RELATED
	function SetMessage($message)
	{
		$_SESSION[$this->config["session_prefix"].'_'."message"] = $message;
	}

	function GetMessage()
	{
		if (isset($_SESSION[$this->config["session_prefix"].'_'."message"]))
		{
			$message = $_SESSION[$this->config["session_prefix"].'_'."message"];
			$_SESSION[$this->config["session_prefix"].'_'."message"] = "";
			return $message;
		}
		else
		{
			return NULL;
		}
	}

	function Redirect($url, $permanent = false)
	{
		if($permanent)
		{
			header('HTTP/1.1 301 Moved Permanently');
		}
		header("Location: $url");
		exit();
	}

	function NoCache()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 				// Date in the past
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 		// always modified
		header("Cache-Control: no-store, no-cache, must-revalidate");	// HTTP 1.1
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");										// HTTP 1.0
	}

	function UnwrapLink($tag)
	{
		if ($tag == "/") return "";
		if ($tag == "!") return $this->context[$this->current_context];

		$newtag = $tag;

		if (strstr($this->context[$this->current_context], "/"))
			$root = preg_replace("/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context]);
		else
			$root	= "";

		if (preg_match("/^\.\/(.*)$/", $tag, $matches))
		{
			$root	= "";
		}
		else if (preg_match("/^\/(.*)$/", $tag, $matches))
		{
			$root	= "";
			$newtag	= $matches[1];
		}
		else if (preg_match("/^\!\/(.*)$/", $tag, $matches))
		{
			$root	= $this->context[$this->current_context];
			$newtag	= $matches[1];
		}
		else if (preg_match("/^\.\.\/(.*)$/", $tag, $matches))
		{
			$newtag = $matches[1];

			if (strstr($root, "/"))
				$root	= preg_replace("/^(.*)\\/([^\\/]+)$/", "$1", $root);
			else
				$root	= "";
		}

		if ($root != "") $newtag= "/".$newtag;

		$tag = $root.$newtag;
		$tag = str_replace("//", "/", $tag);

		return $tag;
	}

	// returns just PageName[/method].
	function MiniHref($method = "", $tag = "", $addpage = "")
	{
		if (!$tag = trim($tag))	$tag = $this->tag;
		if (!$addpage)			$tag = $this->SlimUrl($tag);
		// if (!$addpage)		$tag = $this->NpjTranslit($tag);

		$tag = trim($tag, "/.");
		// $tag = str_replace(array("%2F", "%3F", "%3D"), array("/", "?", "="), rawurlencode($tag));

		return $tag.($method ? "/".$method : "");
	}

	// returns the full url to a page/method.
	function Href($method = "", $tag = "", $params = "", $addpage = 0)
	{
		$href = $this->config["base_url"].( $this->config["rewrite_mode"] ? "" : "?page=" ).$this->MiniHref($method, $tag, $addpage);

		if ($addpage) $params = "add=1".($params ? "&amp;".$params : "");
		if ($params) $href .= ($this->config["rewrite_mode"] ? "?" : "&amp;").$params;

		return $href;
	}

	function SlimUrl($text)
	{
		#$text = $this->NpjTranslit($text, TRAN_DONTCHANGE);
		$text = str_replace("_", "'", $text);
		if ($this->config["urls_underscores"] == 1)
		{
			$text = preg_replace("/(".$this->language["ALPHANUM"].")(".$this->language["UPPERNUM"].")/","\\1¶\\2",$text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")(".$this->language["UPPERNUM"].")/","\\1¶\\2",$text);
			$text = preg_replace("/(".$this->language["UPPER"].")¶(?=".$this->language["UPPER"]."¶".$this->language["UPPERNUM"].")/","\\1",$text);
			$text = preg_replace("/(".$this->language["UPPER"].")¶(?=".$this->language["UPPER"]."¶\/)/","\\1",$text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")¶(".$this->language["UPPERNUM"].")($|\b)/","\\1\\2",$text);
			$text = preg_replace("/\/¶(".$this->language["UPPERNUM"].")/","/\\1",$text);
			$text = str_replace("¶", "_", $text);
		}
		return $text;
	}

	function ComposeLinkToPage($tag, $method = "", $text = "", $track = 1, $title = "")
	{
		if (!$text) $text = $this->AddSpaces($tag);
		//$text = htmlentities($text);
		if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track)
			$this->TrackLinkTo($tag);

		return '<a href="'.$this->href($method, $tag).'"'.($title ? ' title="'.$title.'"' : '').'>'.$text.'</a>';
	}

	function PreLink($tag, $text = "", $track = 1, $imgurl = 0)
	{
		// if (!$text) $text = $this->AddSpaces($tag);

		if (preg_match("/^[\!\.".$this->language["ALPHANUM_P"]."]+$/", $tag))
		{
			// it's a Wiki link!
			if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track)
				$this->TrackLinkTo($this->UnwrapLink( $tag ));
		}
		if ($imgurl == 1)
			return "<!--imglink:begin-->".str_replace(' ', '+', urldecode($tag)).' =='.$text."<!--imglink:end-->";
		else
			return "<!--link:begin-->".str_replace(' ', '+', urldecode($tag))." ==".($this->format_safe ? str_replace(">", "&gt;", str_replace("<", "&lt;", $text)) : $text)."<!--link:end-->";
	}

	function Link($tag, $method = "", $text = "", $track = 1, $safe = 0, $linklang = "", $anchorlink = 1)
	{
		$class	= '';
		$title	= '';
		$lang	= '';
		$url	= '';
		$imlink	= false;
		$text	= str_replace('"', "&quot;", $text);

		if (!$safe)
			$text = htmlspecialchars($text, ENT_NOQUOTES);

		if ($linklang)
			$this->SetLanguage($linklang);

		if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $text))
		{
			$imlink = $this->config["root_url"]."/images/".$text;
		}
		else if (preg_match("/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", preg_replace("/<\/?nobr>/", "" ,$text)))
		{
			$imlink = $text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
		}

		if (preg_match("/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/", $tag, $matches))
		{
			// this is a valid Email
			$url	= ($matches[1] == "mailto:" ? $tag : "mailto:".$tag);
			$title	= $this->GetTranslation("EmailLink");
			$icon	= $this->GetTranslation("emailicon");
			$tpl	= "email";
		}
		else if (preg_match("/^#/", $tag))
		{
			// html-anchor
			$url	= $tag;
			$tpl	= "anchor";
		}
		else if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
		{
			// image
			$text	= preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
			return "<img src=\"".$this->config["root_url"]."/images/".$tag."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." />";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
		{
			// external image
			$text	= preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
			if ($text == $tag)
			{
				return "<img src=\"".str_replace("&", "&amp;", str_replace("&amp;", "&", $tag))."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." />";
			}
			else
			{
				$url	= str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
				$title	= $this->GetTranslation("OuterLink2");
				$icon	= $this->GetTranslation("outericon");
				$tpl	= "outerlink";
			}
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rpm|gz|tgz|zip|rar|exe|doc|xls|ppt|tgz|bz2|7z)$/", $tag))
		{
			// this is a file link
			$url	= str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title	= $this->GetTranslation("FileLink");
			$icon	= $this->GetTranslation("fileicon");
			$tpl	= "file";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/", $tag)) {
			// this is a PDF link
			$url	= str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title	= $this->GetTranslation("PDFLink");
			$icon	= $this->GetTranslation("pdficon");
			$tpl	= "file";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/", $tag)) {
			// this is a RDF link
			$url	= str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title	= $this->GetTranslation("RDFLink");
			$icon	= $this->GetTranslation("rdficon");
			$tpl	= "file";
		}
		else if (preg_match("/^(http|https|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/", $tag))
		{
			// this is a valid external URL
			$url	= str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$tpl	= "outerlink";
			if (!stristr($tag,$this->config["base_url"]))
			{
				$title	= $this->GetTranslation("OuterLink2");
				$icon	= $this->GetTranslation("outericon");
			}
		}
		else if (preg_match("/^(_?)file:([^\\s\"<>\(\)]+)$/", $tag, $matches))
		{
			// this is a file:
			$noimg	= $matches[1];
			$thing	= $matches[2];
			$arr	= explode("/", $thing);

			if (count($arr) == 1) // file:some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->CheckFileExists($thing);

				if (is_array($desc))
				{
					$title	= $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
					$url	= $this->config["root_url"].$this->config["upload_path"]."/".$thing;
					$icon	= $this->GetTranslation("fileicon");
					$imlink	= false;
					$tpl	= "localfile";
					if ($desc["picture_w"] && !$noimg)
					{
						if (!$text) $text = $title;
						return "<img src=\"".$this->config["root_url"].$this->config["upload_path"]."/".$thing."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
					}
				}
			}

			if (count($arr) == 2 && $arr[0] == "") // file:/some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->CheckFileExists($arr[1]);
				if (is_array($desc))
				{
					$title	= $desc["description"]." (".ceil($desc["filesize"] / 1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
					$url	= $this->config["root_url"].$this->config["upload_path"].$thing;
					$icon	= $this->GetTranslation("fileicon");
					$imlink	= false;
					$tpl	= "localfile";
					if ($desc["picture_w"] && !$noimg)
					{
						if (!$text) $text = $title;
						return "<img src=\"".$this->config["root_url"].$this->config["upload_path"]."/".$thing."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
					}
				}
				else //404
				{
					$tpl	= "wlocalfile";
					$title	= "404: /".$this->config["upload_path"].$thing;
					$url	= "404";
				}
			}

			if (!$url)
			{
				$file		= $arr[count($arr) - 1];
				unset($arr[count($arr) - 1]);
				$_pagetag	= implode("/", $arr);

				if ($_pagetag == "") $_pagetag = "!/";

				//unwrap tag (check !/, ../ cases)
				$pagetag	= rtrim($this->NpjTranslit($this->UnwrapLink($_pagetag)), "./");
				$page_id	= $this->GetPageId($pagetag);

				//try to find in local $tag storage
				$desc		= $this->CheckFileExists($file, $pagetag);

				if (is_array($desc))
				{
					//check 403 here!
					if ($this->IsAdmin() || ($desc["upload_id"] && ($this->GetPageOwnerId($this->GetPageId()) == $this->GetUserId())) ||
					($this->HasAccess("read", $page_id)) || ($desc["user_id"] == $this->GetUserId()))
					{
						$title	= $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
						$url	= $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
						$imlink	= false;
						$icon	= $this->GetTranslation("fileicon");
						$tpl	= "localfile";
						if ($desc["picture_w"] && !$noimg)
						{
							if (!$text)
							{
								$text = $title;
								return "<img src=\"".$this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
							}
							else
							{
								return "<a href=\"".$this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file."\" title=\"".$title."\">".$text."</a>";
							}
						}
					}
					else //403
					{
						$url	= $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
						$icon	= $this->GetTranslation("lockicon");
						$imlink	= false;
						$tpl	= "localfile";
						$class	= "denied";
					}
				}
				else //404
				{
					$title	= "404: /".trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
					$url	= "404";
					$tpl	= "wlocalfile";
				}
			}
			//forgot 'bout 403
		}
		else if ($this->config["disable_tikilinks"] != 1 && preg_match("/^(".$this->language["UPPER"].$this->language["LOWER"].$this->language["ALPHANUM"]."*)\.(".$this->language["ALPHA"].$this->language["ALPHANUM"]."+)$/s", $tag, $matches))
		{
			// it`s a Tiki link!
			$tag	= "/".$matches[1]."/".$matches[2];
			if (!$text) $text = $this->AddSpaces($tag);
			return $this->Link( $tag, $method, $text, $track, 1);
		}
		else if (preg_match("/^([[:alnum:]]+)[:]([".$this->language["ALPHANUM_P"]."\-\_\.\+\&\=\#]*)$/", $tag, $matches))
		{
			// interwiki
			$parts	= explode("/",$matches[2]);

			for ($i = 0; $i < count($parts); $i++)
				$parts[$i] = str_replace("%23", "#", urlencode($parts[$i]));

			if ($linklang)
				$text	= $this->DoUnicodeEntities($text, $linklang);

			$url	= $this->GetInterWikiUrl($matches[1], implode("/",$parts));
			$icon	= $this->GetTranslation("iwicon");
			$tpl	= "interwiki";
		}
		else if (preg_match("/^([\!\.\-".$this->language["ALPHANUM_P"]."]+)(\#[".$this->language["ALPHANUM_P"]."\_\-]+)?$/", $tag, $matches))
		{
			// it's a Wiki link!
			$tag	= $otag		= $matches[1];
			$untag	= $unwtag	= $this->UnwrapLink($tag);

			$regex_handlers	= '/^(.*?)\/('.$this->config["standard_handlers"].')\/(.*)$/i';
			$ptag			= $this->NpjTranslit($unwtag);
			$handler		= NULL;

			if (preg_match( $regex_handlers, "/".$ptag."/", $match ))
			{
				$handler	= $match[2];
				if (!isset($_ptag)) $_ptag = "";

				$ptag		= $match[1];
				$unwtag		= "/".$unwtag."/";
				$co			= substr_count($_ptag, "/") - substr_count($ptag, "/");

				for ($i = 0; $i < $co; $i++)
					$unwtag	= substr($unwtag, 0, strrpos($unwtag, "/"));

				if ($handler)
				{
					if (!isset($data)) $data = "";
					$opar	= "/".$untag."/";

					for ($i = 0; $i < substr_count($data, "/") + 2; $i++)
						$opar = substr($opar, strpos($opar, "/") + 1);

					$params = explode("/", $opar); //there're good params
				}
			}

			$unwtag			= trim($unwtag, "/.");
			$unwtag			= str_replace("_", "", $unwtag);

			if ($handler)
				$method		= $handler;

			$thispage		= $this->LoadPage($unwtag, "", LOAD_CACHE, LOAD_META);

			if (!$thispage && $linklang)
			{
				$this->SetLanguage($linklang);
				$lang		= $linklang;
				$thispage	= $this->LoadPage($unwtag, "", LOAD_CACHE, LOAD_META);
			}

			if ($thispage)
			{
				$_lang		= $this->language["code"];

				if ($thispage["lang"])
					$lang	= $thispage["lang"];
				else
					$lang	= $this->config["language"];

				$this->SetLanguage($lang);
				$supertag	= $this->NpjTranslit($tag);
			}
			else
			{
				$supertag	= $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);
			}

			$aname = "";

			if (substr($tag, 0, 2) == "!/")
			{
				$icon		= $this->GetTranslation("childicon");
				$page0		= substr($tag, 2);
				$page		= $this->AddSpaces($page0);
				$tpl		= "childpage";
			}
			else if (substr($tag, 0, 3) == "../")
			{
				$icon		= $this->GetTranslation("parenticon");
				$page0		= substr($tag, 3);
				$page		= $this->AddSpaces($page0);
				$tpl		= "parentpage";
			}
			else if (substr($tag, 0, 1) == "/")
			{
				$icon		= $this->GetTranslation("rooticon");
				$page0		= substr($tag, 1);
				$page		= $this->AddSpaces($page0);
				$tpl		= "rootpage";
			}
			else
			{
				$icon		= $this->GetTranslation("equalicon");
				$page0		= $tag;
				$page		= $this->AddSpaces($page0);
				$tpl		= "equalpage";
			}

			if ($imlink)
				$text		= "<img src=\"$imlink\" border=\"0\" title=\"$text\" />";

			if ($text)
			{
				$tpl		= "descrpage";
				$icon		= "";
			}

			$pagepath		= substr($untag, 0, strlen($untag) - strlen($page0));
			$anchor			= isset($matches[2]) ? $matches[2] : '';
			$tag			= $unwtag;

			if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track) $this->TrackLinkTo($tag);

			if ($anchorlink && !isset($this->first_inclusion[$supertag]))
			{
				$aname = "name=\"".$supertag."\"";
				$this->first_inclusion[$supertag] = 1;
			}

			if ($thispage)
			{
				$pagelink	= $this->href($method, $thispage["tag"]).$this->AddDateTime($tag).($anchor ? $anchor : "");

				if ($this->config["hide_locked"])
				{
					$page_id = $this->GetPageId($tag);
					$access = $this->HasAccess("read", $page_id);
				}
				else
				{
					$access = true;
					$this->_acl["list"] == "*";
				}

				if (!$access)
				{
					$class		= "denied";
					$accicon	= $this->GetTranslation("lockicon");
				}
				else if ($this->_acl["list"] == "*")
				{
					$class		= "";
					$accicon	= "";
				}
				else
				{
					$class		= "customsec";
					$accicon	= $this->GetTranslation("keyicon");
				}

				if ($text == trim($otag, "/") || $linklang)
					$text = $this->DoUnicodeEntities($text, $lang);

				$page = $this->DoUnicodeEntities($page, $lang);

				if (isset($_lang)) $this->SetLanguage($_lang);
			}
			else
			{
				$tpl		= ($this->method == "print" || $this->method == "msword" ? "p" : "") . "w" . $tpl;
				$pagelink	= $this->href("edit", $tag, $lang ? "lang=".$lang : "", 1);
				$accicon	= $this->GetTranslation("wantedicon");
				$title		= $this->GetTranslation("CreatePage");

				if ($linklang)
				{
					$text	= $this->DoUnicodeEntities($text, $linklang);
					$page	= $this->DoUnicodeEntities($page, $linklang);
				}
			}

			$icon			= str_replace("{theme}", $this->config["theme_url"], $icon);
			$accicon		= str_replace("{theme}", $this->config["theme_url"], $accicon);
			$res			= $this->GetTranslation("tpl.".$tpl);
			$text			= trim($text);

			if ($res)
			{
				if ($this->method == 'print')
					$icon	= '';

				//todo: pagepath
				$aname		= str_replace("/",			".",		$aname);
				$res		= str_replace("{aname}",	$aname,		$res);
				$res		= str_replace("{icon}",		$icon,		$res);
				$res		= str_replace("{accicon}",	$accicon,	$res);
				$res		= str_replace("{class}",	$class,		$res);
				$res		= str_replace("{title}",	$title,		$res);
				$res		= str_replace("{pagelink}",	$pagelink,	$res);
				$res		= str_replace("{pagepath}",	$pagepath,	$res);
				$res		= str_replace("{page}",		$page,		$res);
				$res		= str_replace("{text}",		$text,		$res);

				if (!$text)
					$text = htmlspecialchars($tag, ENT_NOQUOTES);

				if ($this->config["youarehere_text"])
					if ($this->NpjTranslit($tag) == $this->NpjTranslit($this->context[$this->current_context]))
						$res = str_replace("####", $text, $this->config["youarehere_text"]);

				// numerated wiki-links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $pagelink != $text && $title != $this->GetTranslation("CreatePage"))
				{
					if (!$refnum = $this->numerate_links[$pagelink])
					{
						$refnum = "[link".((string)count($this->numerate_links)+1)."]";
						$this->numerate_links[$pagelink] = $refnum;
					}
					$res .= "<sup><strong>".$refnum."</strong></sup>";
				}

				return $res;
			}
			die ("ERROR: no link template '$tpl' found.");
		}

		if (!$text) $text	= htmlspecialchars($tag, ENT_NOQUOTES);

		if ($url)
		{
			if ($imlink)
				$text		= "<img src=\"$imlink\" border=\"0\" title=\"$text\" />";

			$icon			= str_replace("{theme}", $this->config["theme_url"], $icon);
			$res			= $this->GetTranslation("tpl.".$tpl);

			if ($res)
			{
				if (!$class)
					$class	= "outerlink";
				if ($this->method == 'print')
					$icon	= '';

				$res		= str_replace("{icon}",		$icon,	$res);
				$res		= str_replace("{class}",	$class,	$res);
				$res		= str_replace("{title}",	$title,	$res);
				$res		= str_replace("{url}",		$url,	$res);
				$res		= str_replace("{text}",		$text,	$res);

				// numerated outer links and file links. initialize property as an array to make it work
				if (is_array($this->numerate_links) && $url != $text && $url != "404" && $url != "403")
				{
					if (!$refnum = $this->numerate_links[$url])
					{
						$refnum = "[link".((string)count($this->numerate_links)+1)."]";
						$this->numerate_links[$url] = $refnum;
					}
					$res .= "<sup><strong>".$refnum."</strong></sup>";
				}

				return $res;
			}
		}
		return $text;
	}

	function AddDatetime($tag)
	{
		if ($user = $this->GetUser()) $show = $user["show_datetime"];
		if (!isset($show)) $show = $this->config["show_datetime"];
		if (!isset($show)) $show = "1";
		// TODO: double?
		if ($show != "0" && $show != "0")
		{
			$_page = $this->LoadPage($tag, "", LOAD_CACHE, LOAD_META);
			return ($this->config["rewrite_mode"] ? "?" : "&amp;").
			"v=".base_convert($this->crc16(preg_replace("/[ :\-]/","",$_page["modified"])),10,36);
		}
		else return "";
	}

	function crc16($string)
	{
		$crc = 0xFFFF;
		for ($x = 0; $x < strlen ($string); $x++) {
			$crc = $crc ^ ord($string[$x]);
			for ($y = 0; $y < 8; $y++) {
				if (($crc & 0x0001) == 0x0001) {
					$crc = (($crc >> 1) ^ 0xA001);
				} else { $crc = $crc >> 1; }
			}
		}
		return $crc;
	}

	function AddSpaces($text)
	{
		$show = "1";
		if ($user = $this->GetUser()) $show = $user["show_spaces"];
		if (!$show) $show = $this->config["show_spaces"];
		if ($show != "0")
		{
			$text = preg_replace("/(".$this->language["ALPHANUM"].")(".$this->language["UPPERNUM"].")/", "\\1&nbsp;\\2", $text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")(".$this->language["UPPERNUM"].")/", "\\1&nbsp;\\2", $text);
			$text = preg_replace("/(".$this->language["ALPHANUM"].")\//", "\\1&nbsp;/", $text);
			$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;".$this->language["UPPERNUM"].")/", "\\1", $text);
			$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;\/)/", "\\1", $text);
			$text = preg_replace("/\/(".$this->language["ALPHANUM"].")/", "/&nbsp;\\1", $text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")&nbsp;(".$this->language["UPPERNUM"].")($|\b)/", "\\1\\2", $text);
			$text = preg_replace("/([0-9])(".$this->language["ALPHA"].")/", "\\1&nbsp;\\2", $text);
			$text = preg_replace("/(".$this->language["ALPHA"].")([0-9])/", "\\1&nbsp;\\2", $text);
			$text = preg_replace("/([0-9])&nbsp;(?=[0-9])/", "\\1", $text);
		}

		if (strpos($text, "/")   === 0) $text = $this->GetTranslation("RootLinkIcon").substr($text, 1);
		if (strpos($text, "!/")  === 0) $text = $this->GetTranslation("SubLinkIcon").substr($text, 2);
		if (strpos($text, "../") === 0) $text = $this->GetTranslation("UpLinkIcon").substr($text, 3);

		return $text;
	}

	function AddSpacesTitle($text)
	{
		$text = preg_replace("/(".$this->language["ALPHANUM"].")(".$this->language["UPPERNUM"].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language["UPPERNUM"].")(".$this->language["UPPERNUM"].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language["ALPHANUM"].")\//", "\\1 /", $text);
		$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;".$this->language["UPPERNUM"].")/", "\\1", $text);
		$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;\/)/", "\\1", $text);
		$text = preg_replace("/\/(".$this->language["ALPHANUM"].")/", "/&nbsp;\\1", $text);
		$text = preg_replace("/(".$this->language["UPPERNUM"].")&nbsp;(".$this->language["UPPERNUM"].")($|\b)/", "\\1\\2", $text);
		$text = preg_replace("/([0-9])(".$this->language["ALPHA"].")/", "\\1 \\2", $text);
		$text = preg_replace("/(".$this->language["ALPHA"].")([0-9])/", "\\1 \\2", $text);
		$text = preg_replace("/([0-9]) (?!".$this->language["ALPHA"].")/", "\\1", $text);

		if (strpos($text, "/")   === 0) $text = $this->GetTranslation("RootLinkIcon").substr($text, 1);
		if (strpos($text, "!/")  === 0) $text = $this->GetTranslation("SubLinkIcon").substr($text, 2);
		if (strpos($text, "../") === 0) $text = $this->GetTranslation("UpLinkIcon").substr($text, 3);

		return $text;
	}

	function IsWikiName($text)
	{
		return preg_match("/^".$this->language["UPPER"].$this->language["LOWER"]."+".$this->language["UPPERNUM"].$this->language["ALPHANUM"]."*$/", $text);
	}

	function TrackLinkTo($tag)
	{
		$this->linktable[] = $tag;
	}

	function GetLinkTable()
	{
		return $this->linktable;
	}

	function ClearLinkTable()
	{
		$this->linktable = array();
	}

	function StartLinkTracking()
	{
		$_SESSION[$this->config["session_prefix"].'_'."linktracking"] = 1;
	}

	function StopLinkTracking()
	{
		$_SESSION[$this->config["session_prefix"].'_'."linktracking"] = 0;
	}

	function WriteLinkTable($from_tag = "")
	{
		$page_id = $this->GetPageId($tag);

		// delete old link table
		if ($from_tag == "")
			$from_tag = $this->tag;

		$this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."links ".
			"WHERE from_page_id = '".quote($this->dblink, $page_id)."'");

		if ($linktable = $this->GetLinkTable())
		{
			$from_page_id = quote($this->dblink, $this->GetPageId());
			foreach ($linktable as $to_tag)
			{
				$lower_to_tag = strtolower($to_tag);

				if (!$written[$lower_to_tag])
				{
					$query .= "('".$from_page_id."','".quote($this->dblink, $this->GetPageId($to_tag))."', '".quote($this->dblink, $to_tag)."', '".quote($this->dblink, $this->NpjTranslit($to_tag))."'),";
					$written[$lower_to_tag] = 1;
				}
			}
			$this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."links ".
					"(from_page_id, to_page_id, to_tag, to_supertag) ".
				"VALUES ".rtrim($query, ","));
		}
	}

	// INTERWIKI STUFF
	function ReadInterWikiConfig()
	{
		if ($lines = file("interwiki.conf"))
		{
			foreach ($lines as $line)
			{
				if ($line = trim($line))
				{
					list($wikiName, $wikiUrl) = explode(" ", trim($line));
					$this->interWiki[strtolower($wikiName)] = $wikiUrl;
				}
			}
		}
	}

	function GetInterWikiUrl($name, $tag)
	{
		if ($url = $this->interWiki[strtolower($name)])
		{
			// xhtmlisation
			$url = str_replace("&", "&amp;", $url);

			// ssl'ing internal links
			if ($this->config["ssl"] == true)
			{
				if (strpos($url, $this->config["open_url"]) !== false)
				{
					$url = str_replace($this->config["open_url"], $this->config["base_url"], $url);
				}
			}

			// translit
			if (strpos($url, $this->config['base_url']) !== false)
			{
				$sub = substr($url, strlen($this->config['base_url']));
				$url = $this->config['base_url'].$this->NpjTranslit($sub);
			}

			// tagging
			if (strpos($url, "%s"))
			{
				return str_replace("%s", $tag, $url);
			}
			else
			{
				return $url.$tag;
			}
		}
	}

	// FORMS
	function FormOpen($method = "", $tag = "", $formMethod = "post", $formname = "", $formMore = "", $hrefParam = "")
	{
		if (!$formMethod) $formMethod = "post";

		$add = isset($_REQUEST["add"]) ? $_REQUEST["add"] : '';
		$result = "<form action=\"".$this->href($method, $tag, $hrefParam, $add)."\" ".$formMore." method=\"".$formMethod."\" ".($formname ? "name=\"".$formname."\" " : "").">\n";

		if (!$this->config["rewrite_mode"]) $result .= "<input type=\"hidden\" name=\"page\" value=\"".$this->MiniHref($method, $tag, $add)."\" />\n";

		if ($this->config["ssl"] == true) $result = str_replace("http://", "https://", $result);

		return $result;
	}

	function FormClose()
	{
		return "</form>\n";
	}

	// REFERRERS
	function LogReferrer($page_id = "", $referrer = "")
	{
		// fill values
		if (!$page_id = trim($page_id))
			$page_id = $this->page["page_id"];

		if (!$referrer = trim($referrer))
			$referrer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

		// check if it's coming from another site
		if ($referrer && !preg_match("/^".preg_quote($this->config["base_url"], "/")."/", $referrer) && isset($_GET["sid"]) === false) // TODO: isset($_GET["PHPSESSID"]) === false
		{
			$this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."referrers SET ".
					"page_id = '".quote($this->dblink, $page_id)."', ".
					"referrer = '".quote($this->dblink, $referrer)."', ".
					"time = NOW()");
		}
	}

	function LoadReferrers($page_id = "")
	{
		return $this->LoadAll(
			"SELECT referrer, count(referrer) AS num ".
			"FROM ".$this->config["table_prefix"]."referrers ".
			($page_id = trim($page_id)
				? "WHERE page_id = '".quote($this->dblink, $page_id)."'"
				: "").
			"GROUP BY referrer ".
			"ORDER BY num DESC");
	}

	// PLUGINS
	function IncludeBuffered($filename, $notfoundText = "", $vars = "", $path = "")
	{
		if ($path)	$dirs = explode(":", $path);
		else		$dirs = array("");

		foreach($dirs as $dir)
		{
			if ($dir)
				$dir .= "/";
			$fullfilename = $dir.$filename;
			$fullfilename = trim($fullfilename, "./");

			if (@file_exists($fullfilename))
			{
				if (is_array($vars)) extract($vars, EXTR_SKIP);

				ob_start();
				include($fullfilename);
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}
		}
		if ($notfoundText)
			return $notfoundText;
		else
			return false;
	}

	function Header($mod = "")
	{
		return $this->IncludeBuffered("header".$mod.".php", "Theme is corrupt: ".$this->config["theme"], "", "themes/".$this->config["theme"]."/appearance");
	}

	function Footer($mod = "")
	{
		return $this->IncludeBuffered("footer".$mod.".php", "Theme is corrupt: ".$this->config["theme"], "", "themes/".$this->config["theme"]."/appearance");
	}

	function UseClass($class_name, $class_dir = "", $file_name = "")
	{
		if (!class_exists($class_name))
		{
			if ($file_name == "") $file_name = strtolower($class_name);
			if ($class_dir == "") $class_dir = $this->classes_dir;

			$class_file = $class_dir.$file_name.".php";
			$class_file = trim($class_file, "./");

			if (!@is_readable($class_file))
				die("Cannot load class ".$class_name."  from ". $class_file. " (".$class_dir.")");
			else
				require_once($class_file);
		}
	}

	function Action($action, $params = "", $forceLinkTracking = 0)
	{
		$action = trim($action);

		if (!$forceLinkTracking)
			$this->StopLinkTracking();

		$result = $this->IncludeBuffered(strtolower($action).".php", "<i>".$this->GetTranslation("UnknownAction")." \"$action\"</i>", $params, $this->config["action_path"]);

		$this->StartLinkTracking();
		$this->NoCache();
		return $result;
	}

	function Method($method)
	{
		if (!$handler = $this->page["handler"]) $handler = "page";

		$methodLocation = $handler."/".$method.".php";

		return $this->IncludeBuffered($methodLocation, "<i>Unknown method \"$methodLocation\"</i>", "", $this->config["handler_path"]);
	}

	// wrapper for the next method
	function Format($text, $formatter = "wakka", $options = "")
	{
		return $this->_Format($text, $formatter, $options);
	}

	function _Format($text, $formatter, &$options)
	{
		$text = $this->IncludeBuffered("formatters/".$formatter.".php", "<i>Formatter \"$formatter\" not found</i>", compact("text", "options"));

		if ($formatter == "wacko" && $this->config["default_typografica"])
			$text = $this->IncludeBuffered("formatters/typografica.php", "<i>Formatter \"$formatter\" not found</i>", compact("text"));

		return $text;
	}

	// USERS
	// check whether defined username is already registered.
	// we add appropriate (but not thorough) transliterations
	// to not allow too similiar names.
	function UsernameExists($name)
	{
		if ($name == "") return false;

		// checking identical name only?
		if (!$this->config["antidupe"])
		{
			if ($this->LoadSingle(
			"SELECT * FROM {$this->config['user_table']} ".
			"WHERE name = '".quote($this->dblink, $name)."'"))
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
			"cyr" => "ÀÂÑÄÅÍÊÌÎÐÒÕÓàñåêìïîðãèòõó0áI1",
			"lat" => "ABCDEHKMOPTXYacekmnoprutxyÎ6ll"
		);

		// splitting input name into array
		$name = preg_split("//", $name, -1, PREG_SPLIT_NO_EMPTY);

		// let's define characters positions and corresponding substitutions.
		// so we're constructing $p array with username chars needing
		// substitution positions as keys, and corresponding table positions
		// as array values
		$p = array();
		foreach ($name as $pos => &$char)
		{
			if (isset($p[$pos]) === false)
			{
				if		(false !== $sub = strpos($table["lat"], $char))	$p[$pos] = $sub;
				else if	(false !== $sub = strpos($table["cyr"], $char))	$p[$pos] = $sub;
			}
		}

		// exploding substitutions table into array
		foreach ($table as $key => &$val)
		{
			$table[$key] = preg_split("//", $table[$key], -1, PREG_SPLIT_NO_EMPTY);
		}

		// running through all chars positions needing replacement
		foreach ($p as $pos => $sub)
		{
			// what substitution character we have to use?
			if ($name[$pos] != $table["cyr"][$sub])
			{
				// constructing cyrillic regexp addition
				$name[$pos] = "[".$name[$pos].$table["cyr"][$sub]."]";
			}
			else if ($name[$pos] != $table["lat"][$sub])
			{
				// constructing latin regexp addition
				$name[$pos] = "[".$name[$pos].$table["lat"][$sub]."]";
			}
		}

		// checking database
		if ($this->LoadSingle(
		"SELECT * FROM {$this->config['user_table']} ".
		"WHERE name REGEXP '".quote($this->dblink, implode('', $name))."'", 1))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function LoadUser($name, $password = 0)
	{
		$user = $this->LoadSingle(
			"SELECT * FROM ".$this->config["user_table"]." ".
			"WHERE name = '".quote($this->dblink, $name)."' ".
			($password === 0 ? "" : "AND password = '".quote($this->dblink, $password)."'")." ".
			"LIMIT 1");

		if ($user)
			$user["options"] = $this->DecomposeOptions($user["more"]);

		if ($user["session_time"] == SQL_NULLDATE)
			$user["session_time"] = "";

		return $user;
	}

	function GetUserName()
	{
		if ($username = $this->GetUserSetting("name"))
		{
			return $username;
		}
		else
		{
			return NULL;
		}
	}

	function GetUserIP()
	{
		if ($this->_userhost)
		{
			return $this->_userhost;
		}
		else
		{
			return $this->_userhost = $_SERVER['REMOTE_ADDR'];
		}
	}

	// extract user data from the session array
	function GetUser()
	{
		if (isset( $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."user"] ))
			return $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."user"];
		else
			return NULL;
	}

	// extract specific element from user session array
	function GetUserSetting($setting, $option = 0, $guest = 0)
	{
		if (!$option)
			return $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].( !$guest ? "user" : "guest" )][$setting];
		else
			return $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].( !$guest ? "user" : "guest" )]["options"][$setting];
	}

	// set/update specific element of user session array
	// !!! BE CAREFUL NOT TO SAVE GUEST VALUES UNDER REGISTERED USER ARRAY !!!
	// this poses a potential security threat
	function SetUserSetting($setting, $value, $option = 0, $guest = 0)
	{
		if (!$option)
			return $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].( !$guest ? "user" : "guest" )][$setting] = $value;
		else
			return $_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"].( !$guest ? "user" : "guest" )]["options"][$setting] = $value;
	}

	// insert user data into the session array
	function SetUser($user, $ip = 1)
	{
		$_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."user"] = $user;

		// define current IP for foregoing checks
		if ($ip == true) $this->SetUserSetting("ip", $_SERVER["REMOTE_ADDR"]);

		return true;
	}

	// update current session time
	function UpdateSessionTime($user)
	{
		if ($user['name'] == true)
			return $this->Query(
				"UPDATE {$this->config['user_table']} ".
				"SET session_time = NOW() ".
				"WHERE name = '".quote($this->dblink, $user['name'])."' ".
				"LIMIT 1");
	}

	function LogUserIn($user, $persistent = 1, $session = 0)
	{
		// cookie elements
		$session	= ( $session == 0 ? $this->config['cookie_session'] : $session );
		$session	= ( $persistent ? $session : 0.25 );
		$ses_time	= time() + $session * 24 * 3600;

		if ($this->config['strong_cookies'] == true)
		{
			$time_pad	= str_pad($ses_time, 32, '0', STR_PAD_LEFT);
			$username	= $user['name'];
			$password	= base64_encode(md5($this->config['system_seed'] ^ $time_pad) ^ $user['password']);
			// authenticating cookie data:
			// seed | username | composed pwd | raw session time | raw password
			$cookie_mac	= md5($this->config['system_seed'].$username.$password.$ses_time.$user['password']);
			// construct and set cookie
			$cookie		= implode(';', array($username, $password, $ses_time, $cookie_mac));
		}
		else
		{
			$cookie		= implode(';', array($user['name'], $user['password'], $ses_time));
		}

		$this->SetSessionCookie('auth', $cookie, '', ( $this->config['ssl'] == true ? 1 : 0 ));

		if ($persistent)
		{
			$this->SetPersistentCookie('auth', $cookie, $session, ( $this->config['ssl'] == true ? 1 : 0 ));
		}

		// update session expiry and clear password recovery
		// code in user data table
		$this->Query(
			"UPDATE {$this->config['user_table']} SET ".
				"session_expire	= '".quote($this->dblink, $ses_time)."', ".
				"changepassword	= '' ".
			"WHERE name = '".quote($this->dblink, $user['name'])."' ".
			"LIMIT 1");

		// restart logged in user session with specific session id
		return $this->RestartUserSession($user, $ses_time);
	}

	// regenerate session id for registered user
	function RestartUserSession($user, $session_time)
	{
		$this->DeleteCookie('sid', 1);
		unset($_SESSION[$this->config["session_prefix"].'_'.$this->config['cookie_prefix'].'user']);
		session_destroy();
		session_id(md5($this->timer.$this->config['system_seed'].$session_time.$user['name'].$user['password']));
		return session_start();
	}

	// restore username/password/etc from auth cookie
	function DecomposeAuthCookie($name = 'auth')
	{
		if (true == $cookie = $this->GetCookie($name))
		{
			if ($this->config['strong_cookies'] == true)
			{
				list($username, $b64password, $ses_time, $cookie_mac) = explode(';', $cookie);
				$time_pad	= str_pad($ses_time, 32, '0', STR_PAD_LEFT);
				$password	= md5($this->config['system_seed'] ^ $time_pad) ^ base64_decode($b64password);
				$recalc_mac	= md5($this->config['system_seed'].$username.$b64password.$ses_time.$password);
			}
			else
			{
				list($username, $password, $ses_time) = explode(';', $cookie);
			}

			return array(
				'name'			=> $username,
				'password'		=> $password,
				'ses_time'		=> $ses_time,
				'cookie_mac'	=> $cookie_mac,
				'recalc_mac'	=> $recalc_mac
			);
		}
		else return NULL;
	}

	// end user session and free session vars
	function LogoutUser()
	{
		// clear session expiry in user data table
		$this->Query(
			"UPDATE {$this->config['user_table']} ".
			"SET session_expire = 0 ".
			"WHERE name = '".quote($this->dblink, $_SESSION[$this->config["session_prefix"].'_'.$this->config['cookie_prefix'].'user']['name'])."' ".
			"LIMIT 1");

		$this->DeleteCookie('auth');
		$this->DeleteCookie('sid', 1);
		unset($_SESSION[$this->config["session_prefix"].'_'.$this->config['cookie_prefix'].'user']);

		$session_id = md5($this->timer.$this->config['system_seed'].$this->GetUserSetting('password').session_id());

		session_destroy();
		session_start();
		session_id($session_id);
	}

	function LoadUsers()
	{
		return $this->LoadAll(
			"SELECT * FROM ".$this->config["user_table"]." ORDER BY binary name");
	}

	function GetUserNameById($user_id = 0)
	{
		$user = $this->LoadSingle(
					"SELECT name FROM ".$this->config["table_prefix"]."users WHERE user_id = '".$user_id."' LIMIT 1");
					// Get user value
					$user = $user['name'];

					return $user;
	}

	function GetUserId()
	{
		if ($user = $this->GetUser()) $user_id = $user["user_id"];

		if (isset($user_id))
			return $user_id;
		else
			return NULL;
	}

	function GetUserIdByName($user = "")
	{
		$user = $this->LoadSingle(
					"SELECT user_id FROM ".$this->config["table_prefix"]."users WHERE name = '".$user."' LIMIT 1");
					// Get user value
					$user_id = $user['user_id'];

					return $user_id;
	}

	function UserWantsComments()
	{
		if (!$user = $this->GetUser())
			return false;
		return ($user["show_comments"] == "1");
	}

	function UserWantsFiles()
	{
		if (!$user = $this->GetUser())
			return false;

		return ($user["options"]["show_files"] == "1");
	}

	// Returns boolean indicating if the current user is allowed to see comments at all
	function UserAllowedComments()
	{
		return $this->config["hide_comments"] != 1 && ($this->config["hide_comments"] != 2 || $this->GetUser());
	}

	function DecomposeOptions($more)
	{
		$b		= array();
		$opts	= explode($this->optionSplitter, $more);

		foreach ($opts as $o)
		{
			$params			= explode($this->valueSplitter, trim($o));
			$b[$params[0]]	= $params[1];
		}
		return $b;
	}

	function ComposeOptions($options)
	{
		$opts = array();

		foreach ($options as $k => $v)
		{
			$opts[] = $k.$this->valueSplitter.$v;
		}

		return implode($this->optionSplitter, $opts);
	}

	// COMMENTS AND COUNTS
	// recount all user's comments
	function CountUserComments($name)
	{
		$count = $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id <> '0'");
		return (int)$count['n'];
	}

	// recount all user's pages
	function CountUserPages($name)
	{
		$count = $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'");
		return (int)$count['n'];
	}

	// recount all user's page revisions
	function CountUserRevisions($name)
	{
		$count = $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}revisions ".
			"WHERE owner_id = '".quote($this->dblink, $user_id)."' ".
				"AND comment_on_id = '0'");
		return (int)$count['n'];
	}

	// recount all comments for a given page
	function CountComments($comment_on_id)
	{
		$count = $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE comment_on_id = '".quote($this->dblink, $comment_on_id)."'");
		return (int)$count['n'];
	}

	// get current number of comments
	function GetCommentsCount($tag = '')
	{
		if ($this->page && $tag == false)
		{
			return $this->page['comments'];
		}
		else
		{
			$count = $this->LoadSingle(
				"SELECT comments ".
				"FROM {$this->config['table_prefix']}pages ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ".
				"LIMIT 1");
			return $count['comments'];
		}
		return false;
	}

	// returns latest comment tag for a given page
	function LatestComment($comment_on_id)
	{
		if ($tag) $latest = $this->LoadSingle(
			"SELECT tag ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE comment_on_id = '".quote($this->dblink, $comment_on_id)."' ".
			"ORDER BY created DESC ".
			"LIMIT 1");
		return $latest['tag'];
	}

	function LoadComments($page_id, $limit = 0, $count = 30)
	{
		// avoid results if $page_id is 0 (page does not exists)
		if ($page_id)
		{
			return $this->LoadAll(
					"SELECT p.page_id, p.tag, p.created, p.modified, p.body, p.body_r, p.title, u.name AS user ".
					"FROM ".$this->config["table_prefix"]."pages p ".
						"LEFT OUTER JOIN ".$this->config["table_prefix"]."users u ON (p.user_id = u.user_id) ".
					"WHERE p.comment_on_id = '".quote($this->dblink, $page_id)."' ".
					"ORDER BY p.created ".
					"LIMIT {$limit}, {$count}");
		}
	}

	// ACCESS CONTROL
	function IsAdmin()
	{
		if (!$this->GetUser()) return false;

		if (is_array($this->config['aliases']))
		{
			$al = $this->config['aliases'];
			$adm = explode("\n", $al['Admins']);

			if ($adm == true && in_array($this->GetUserName(), $adm))
				return true;
		}
		return false;
	}

	// returns true if logged in user is owner of current page, or page specified in $tag
	function UserIsOwner($page_id = "")
	{
		// check if user is logged in
		if (!$this->GetUser()) return false;

		// set default tag
		if (!$page_id = trim($page_id)) $page_id = $this->page["page_id"];

		// check if user is owner
		if ($this->GetPageOwnerId($page_id) == $this->GetUserId())
			return true;
	}

	function GetPageOwnerFromComment()
	{
		if($this->page["comment_on_id"])
			return $this->GetPageOwner($this->page["comment_on_id"]);
		else
			return false;
	}

	function GetPageOwner($tag = "", $time = "")
	{
		if (!$tag = trim($tag))
		{
			if (!$time) return $this->GetUserNameById($this->page['owner_id']);
			else $tag = $this->tag;
		}

		if ($page = $this->LoadPage($tag, $time, LOAD_CACHE, LOAD_META))
			return $this->GetUserNameById($page["owner_id"]);
	}

	function GetPageOwnerId($page_id = "", $time = "")
	{

		if (!$page_id = trim($page_id))
		{
			if (!$time) return $this->page['owner_id'];
			else $page_id = $this->page['page_id'];
		}
		$tag = $this->GetPageTagById($page_id);
		if ($page = $this->LoadPage($tag, $time, LOAD_CACHE, LOAD_META))
			return $page["owner_id"];
	}

	function SetPageOwner($page_id, $user_id)
	{
		// check if user exists
		$user = $this->GetUserNameById($user_id);
		if (!$this->LoadUser($user)) return;

		// updated latest revision with new owner
		$this->Query(
			"UPDATE ".$this->config["table_prefix"]."pages ".
			"SET owner_id = '".quote($this->dblink, $user_id)."' ".
			"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
			"LIMIT 1");
	}

	function SaveAcl($page_id, $privilege, $list)
	{

		if ($this->LoadAcl($page_id, $privilege, 0))
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."acls SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", "", $list)))."' ".
				"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
					"AND privilege = '".quote($this->dblink, $privilege)."' ");
		}
		else
		{
			$this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."acls SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", "", $list)))."', ".
					"page_id = '".quote($this->dblink, $page_id)."', ".
					"privilege = '".quote($this->dblink, $privilege)."'");
		}
	}

	function GetCachedACL($page_id, $privilege, $useDefaults)
	{
		if (isset( $this->aclCache[$page_id."#".$privilege."#".$useDefaults] ))
			return $this->aclCache[$page_id."#".$privilege."#".$useDefaults];
		else
			return '';
	}

	// $acl array must reflect acls table row structure
	function CacheACL($page_id, $privilege, $useDefaults, $acl)
	{
		$this->aclCache[$page_id."#".$privilege."#".$useDefaults] = $acl;
	}

	function LoadAcl($page_id, $privilege, $useDefaults = 1)
	{
		if (!isset($acl)) $acl = "";

		if ($cachedACL = $this->GetCachedACL($page_id, $privilege, $useDefaults))
			$acl = $cachedACL;

		if (!$acl)
		{
			if ($cachedACL = $this->GetCachedACL($page_id, $privilege, $useDefaults))
				$acl = $cachedACL;

			if (!$acl)
			{

				$acl = $this->LoadSingle(
								"SELECT * ".
								"FROM ".$this->config["table_prefix"]."acls ".
								"WHERE page_id = '".quote($this->dblink, $page_id)."' ".
									"AND privilege = '".quote($this->dblink, $privilege)."' ".
								"LIMIT 1");

				// if still no acl, use config defaults
				if (!$acl && $useDefaults)
				{
					// First look for parent ACL, so that clusters/subpages
					// work correctly.
					$tag = $this->GetPageTagById($page_id);
					if ( strstr($tag, "/") )
					{
						$parent = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $tag );

						// By letting it fetch defaults, it will automatically recurse
						// up the tree of parent pages... fetching the ACL on the root
						// page if necessary.
						$parent_id = $this->GetPageId($parent);
						$acl = $this->LoadAcl( $parent_id, $privilege, 1 );
					}

					if (!$acl)
					{
						$acl = array(
							"page_id" => $page_id,
							"privilege" => $privilege,
							"list" => $this->config["default_".$privilege."_acl"],
							"time" => date("YmdHis"),
							"default" => 1
						);
					}
				}

				$this->CacheACL($page_id, $privilege, $useDefaults, $acl);
			}
		}
		return $acl;
	}

	// returns true if $user (defaults to the current user) has access to $privilege on $page_tag (defaults to the current page)
	function HasAccess($privilege, $page_id = "", $user = "")
	{
		$registered = false;
		// see whether user is registered and logged in
		if ($user != GUEST)
		{
			if ($user = $this->GetUser()) $registered = true;
				$user = strtolower($this->GetUserName());
			if (!$registered)
				$user = GUEST;
		}

		if (!$page_id = trim($page_id)) $page_id = $this->GetPageId();

		// load acl
		$acl = $this->LoadAcl($page_id, $privilege);
		$this->_acl = $acl;

		// if current user is owner or admin, return true. they can do anything!
		if ($user != GUEST)
			if ($this->UserIsOwner($page_id) || $this->IsAdmin())
				return true;

		return $this->CheckACL($user, $acl['list'], true);
	}

	function CheckACL($user, $acl_list, $copy_to_this_acl = false, $debug = 0)
	{
		if (is_array($user)) $user = $user["name"];

		$user = strtolower($user);

		// replace groups
		$acl = str_replace(" ", "", strtolower($this->ReplaceAliases($acl_list)));

		if ($copy_to_this_acl) $this->_acl['list'] = $acl;

		$acls = "\n".$acl."\n";

		if ($user == GUEST || $user == "")
		{
			if (($pos = strpos($acls, '*')) === false)
				return false;

			if ($acls{$pos - 1} != "!")
				return true;

			return false;
		}

		$upos = strpos($acls, "\n".$user."\n");
		$aupos = strpos($acls, "\n!".$user."\n");
		$spos = strpos($acls, '*');
		$bpos = strpos($acls, '$');

		if ($aupos !== false) return false;

		if ($upos !== false)  return true;

		if ($spos !== false)
			if ($acls{$spos - 1} == "!") return false;

		if ($bpos !== false)
			if ($acls{$bpos - 1} == "!") return false;

		if ($spos !== false) return true;

		if ($bpos !== false)
		{
			if ($user == GUEST || $user == "") return false;
			else return true;
		}

		return false;
	}

	// aliases stuff
	function ReplaceAliases($acl)
	{
		if (!is_array($this->config['aliases']))
			return $acl;

		foreach ($this->config['aliases'] as $key => $val)
			$aliases[strtolower($key)] = $val;

		do
		{
			$list = array();
			$lines = explode("\n", $acl);
			$replaced = 0;

			foreach ($lines as $line)
			{
				$linel = $line;
				// check for inversion character "!"
				if (preg_match("/^\!(.*)$/", $line, $matches))
				{
					$negate = 1;
					$linel = $matches[1];
				}
				else
				{
					$negate = 0;
				}

				$linel = strtolower(trim($linel));

				if (isset($aliases[$linel]))
				{
					foreach (explode("\n", $aliases[$linel]) as $item)
					{
						$item = trim($item);
						$list[] = ($negate ? "!".$item : $item);
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
	function IsWatched($user_id, $page_id)
	{
		return $this->LoadSingle(
			"SELECT * FROM ".$this->config["table_prefix"]."watches ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND page_id = '".quote($this->dblink, $page_id)."'");
	}

	function SetWatch($user_id, $page_id)
	{
		// Remove old watch first to avoid double watches
		$this->ClearWatch($user_id, $page_id);

		if ($this->HasAccess('read', $page_id))
			return $this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."watches (user_id, page_id) ".
				"VALUES ( '".quote($this->dblink, $user_id)."', '".quote($this->dblink, $page_id)."')" );
				// TIMESTAMP type is filled automatically by MySQL
		else
			return false;
	}

	function ClearWatch($user_id, $page_id)
	{
		return $this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."watches ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND page_id = '".quote($this->dblink, $page_id)."'");
	}

	// BOOKMARKS
	function GetDefaultBookmarks($lang, $what = "default")
	{
		$lang = $this->UserAgentLanguage();

		if (isset($this->config[$what."_bookmarks"]) &&
		is_array($this->config[$what."_bookmarks"]) &&
		isset($this->config[$what."_bookmarks"][$lang]))
		{
			return $this->config[$what."_bookmarks"][$lang];
		}
		else if (isset($this->config[$what."_bookmarks"]) &&
		!is_array($this->config[$what."_bookmarks"]) &&
		($this->config["language"] == $lang))
		{
			return $this->config[$what."_bookmarks"];
		}
		else
		{
			return $this->GetTranslation($what."_bookmarks", $lang, false);
		}
	}

	function SetBookmarks($set = BM_AUTO)
	{
		$user = $this->GetUser();

		// initial bookmarks table construction
		if ($set || !($bookmarks = $this->GetBookmarks()))
		{
			$bookmarks = ( $user["bookmarks"]
				? $user["bookmarks"]
				: $this->GetDefaultBookmarks($user["lang"]) );

			if ($set == BM_DEFAULT)
				$bookmarks = $this->GetDefaultBookmarks($user["lang"]);

			$dummy = $this->Format($bookmarks, "wacko");
			$this->ClearLinkTable();
			$this->StartLinkTracking();
			$dummy = $this->Format($dummy, "post_wacko");
			$this->StopLinkTracking();
			$bmlinks = $this->GetLinkTable();

			// parsing bookmarks into links table
			$bookmarks = explode("\n", $bookmarks);
			for ($i = 0; $i < count($bmlinks); $i++)
			{
				$bmlinks[$i] = $this->NpjTranslit($bmlinks[$i]);
			}

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"]		= $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"]	= $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"]	= $this->Format(implode(" | ", $bookmarks), "wacko");
		}

		// adding new bookmark
		if (!empty($_REQUEST["addbookmark"]) && $user)
		{
			// writing bookmark
			$bookmark = "((".$this->GetPageTag()." ".$this->GetPageTitle().($user["lang"] != $this->pagelang ? " @@".$this->pagelang : "")."))";

			if (!in_array($bookmark, $bookmarks))
			{
				$bookmarks[] = $bookmark;

				$this->Query(
					"UPDATE ".$this->config["user_table"]." ".
					"SET bookmarks = '".quote($this->dblink, implode("\n", $bookmarks))."' ".
					"WHERE name = '".quote($this->dblink, $user["name"])."' ".
					"LIMIT 1");
			}

			// parsing bookmarks into links table
			$bmlinks = $bookmarks;
			for ($i = 0; $i < count($bmlinks); $i++)
			{
				$bmlinks[$i] = trim($this->NpjTranslit($bmlinks[$i]),"()");
			}

			$this->SetUser($this->LoadUser($user["name"]));

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"]		= $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"]	= $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"]	= $this->Format(implode(" | ", $bookmarks), "wacko");
		}

		// removing bookmark
		if (!empty($_REQUEST["removebookmark"]) && $user)
		{
			foreach ($bookmarks as $bookmark)
			{
				$dummy = $this->Format($bookmark, "wacko");
				$this->ClearLinkTable();
				$this->StartLinkTracking();
				$dummy = $this->Format($dummy, "post_wacko");
				$this->StopLinkTracking();
				$bml = $this->GetLinkTable();
				if ($this->GetPageSuperTag()!=$this->NpjTranslit($bml[0])) $newbookmarks[] = $bookmark;
			}
			$bookmarks = $newbookmarks;

			$this->Query(
				"UPDATE ".$this->config["user_table"]." ".
				"SET bookmarks = '".quote($this->dblink, implode("\n", $bookmarks))."' ".
				"WHERE name = '".quote($this->dblink, $user["name"])."' ".
				"LIMIT 1");

			// parsing bookmarks into links table
			$bmlinks = $bookmarks;
			for ($i = 0; $i < count($bmlinks); $i++)
			{
				$bmlinks[$i] = trim($this->NpjTranslit($bmlinks[$i]),"()");
			}

			$this->SetUser($this->LoadUser($user["name"]));

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"]		= $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"]	= $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"]	= ( $bookmarks ? $this->Format(implode(" | ", $bookmarks), "wacko") : "" );
		}
	}

	function GetBookmarks()
	{
		if (isset($_SESSION[$this->config["session_prefix"].'_'."bookmarks"]))

			return $_SESSION[$this->config["session_prefix"].'_'."bookmarks"];
	}

	function GetBookmarksFormatted()
	{
		if (isset($_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"]))
			return $_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"];
	}

	function GetBookmarkLinks()
	{
		if (isset($_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"]))
			return $_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"];
	}

	// MAINTENANCE
	function Maintenance()
	{
		// purge referrers (once a day)
		if (($days = $this->config["referrers_purge_time"]) && (time() > ($this->config["maint_last_refs"] + 1 * 86400)))
		{
			$this->Query(
				"DELETE FROM ".$this->config["table_prefix"]."referrers ".
				"WHERE time < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");

			$this->Query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE name = 'maint_last_refs'");

			$this->Log(7, 'Maintenance: referrers purged');
		}

		// purge outdated pages revisions (once a week)
		if (($days = $this->config["pages_purge_time"]) && (time() > ($this->config["maint_last_oldpages"] + 7 * 86400)))
		{
			$this->Query(
				"DELETE FROM ".$this->config["table_prefix"]."revisions ".
				"WHERE modified < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");

			$this->Query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE name = 'maint_last_oldpages'");

			$this->Log(7, 'Maintenance: outdated pages revisions purged');
		}

		// purge deleted pages (once per 3 days)
		if (($days = $this->config["keep_deleted_time"]) && (time() > ($this->config["maint_last_delpages"] + 3 * 86400)) &&
		($pages = $this->LoadRecentlyDeleted(1000, 0)))
		{
			// composing a list of candidates
			if (is_array($pages)) foreach ($pages as $page)
			{
				// does the page has been deleted earlier than specified number of days ago?
				if (strtotime($page["date"]) < (time() - (3600 * 24 * $days)))
					$remove[] = "'".quote($this->dblink, $page['tag'])."'";
			}

			if ($remove)
			{
				$this->Query(
					"DELETE FROM {$this->config['table_prefix']}revisions ".
					"WHERE tag IN ( ".implode(', ', $remove)." )");
				unset($remove);
			}

			$this->Query("UPDATE {$this->config['table_prefix']}config SET maint_last_delpages = '".time()."'");

			$this->Log(7, 'Maintenance: deleted pages purged');
		}

		// purge system log entries (once per 3 days)
		if (($days = $this->config["log_purge_time"]) && (time() > ($this->config["maint_last_log"] + 3 * 86400)))
		{
			$this->Query(
				"DELETE FROM {$this->config["table_prefix"]}log ".
				"WHERE time < DATE_SUB( NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY )");

			$this->Query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE name = 'maint_last_log'");

			$this->Log(7, 'Maintenance: system log purged');
		}

		// remove outdated pages cache, purge sql cache,
		if (time() > ($this->config['maint_last_cache'] + 3600))
		{
			// pages
			if ($ttl = $this->config['cache_ttl'])
			{
				// clear from db
				$this->Query(
					"DELETE FROM ".$this->config["table_prefix"]."cache ".
					"WHERE time < DATE_SUB( NOW(), INTERVAL '".quote($this->dblink, $ttl)."' SECOND )");

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

				//$this->Log(7, 'Maintenance: cached pages purged');
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

				//$this->Log(7, 'Maintenance: cached sql results purged');
			}

			$this->Query("UPDATE {$this->config['table_prefix']}config SET value = '".time()."' WHERE name = 'maint_last_cache'");
		}
	}

	// MAIN EXECUTION ROUTINE
	function Run($tag, $method = "")
	{
		// mandatory ssl?
		if ($this->config["ssl"] == true && $this->config["ssl_implicit"] == true && $_SERVER["HTTPS"] != "on")
		{
			$this->Redirect(str_replace('http://', 'https://', $this->href($method, $tag)));
		}

		// url lang selection
		$url	= explode('@@', $tag);
		$tag	= trim($url[0]);
		$lang	= trim($url[1]);

		if (!trim($tag)) $tag = $this->config["root_page"];

		// autotasks
		if (!($this->GetMicroTime() % 3)) $this->Maintenance();

		$this->ReadInterWikiConfig();

		// parse authentication cookie and get user data
		$auth = $this->DecomposeAuthCookie();
		$user = $this->LoadUser($auth["name"], $auth["password"]);

		// run in ssl mode?
		if ($this->config["ssl"] == true && ($_SERVER["HTTPS"] == "on" || $user == true))
		{
			$this->config["open_url"] = $this->config["base_url"];
			$this->config["base_url"] = str_replace("http://", "https://", $this->config["base_url"]);
			$this->config["root_url"] = str_replace("http://", "https://", $this->config["root_url"]);
		}

		// in strong cookie mode check session validity
		if ($this->config["strong_cookies"] == true)
		{
			if ($user["session_expire"] != 0 && time() < $user["session_expire"] &&
			time() < $auth["ses_time"] && $user["session_expire"] == $auth["ses_time"] &&
			$auth["recalc_mac"] == $auth["cookie_mac"])
			{
				$session = true;
			}
			else
			{
				// log event: invalid auth cookie
				if ($auth["recalc_mac"] != $auth["cookie_mac"]) $this->Log(1, '<strong><span class="cite">Malformed/forged user authentication cookie detected. Destroying existing session (if any)</span></strong>');

				$session = false;

				// terminate expired/invalid session
				if ($this->GetUser())
				{
					// log event: session expired
					if (time() > $auth["ses_time"]) $this->Log(2, 'Expired user session terminated');

					$this->LogoutUser();
					$this->Redirect($this->config["base_url"].$this->config["login_page"].'?goback='.$tag);
				}
			}
		}
		else
		{
			$session = true;
		}

		// check IP validity
		if ($this->GetUserSetting("validate_ip", 1) == '1' && $this->GetUserSetting("ip") != $_SERVER["REMOTE_ADDR"])
		{
			$this->Log(1, '<strong><span class="cite">User in-session IP change detected</span></strong>');
			$this->LogoutUser();
			$this->Redirect($this->config["base_url"].$this->config["login_page"].'?goback='.$tag);
			$session = false;
		}

		// start user session
		if (!$this->GetUser() && $session === true && $user == true)
		{
			$this->RestartUserSession($user, $auth["ses_time"]);
			$this->SetUser($user, 1);
			$this->UpdateSessionTime($user);
			unset($user);
		}
		$user = $this->GetUser();

		unset($auth);

		// user preferences
		if(isset($user["lang"]))
		{
			if($user["lang"] == "")
			{
				$this->userlang = $this->config["language"];
			}
			else
			{
				$this->userlang = $user["lang"];
			}
		}
		$this->UserAgentLanguage();

		if (is_array($user) && $user["options"]["theme"])
		{
			$this->config["theme"]		= $user["options"]["theme"];
			$this->config["theme_url"]	= $this->config["root_url"]."themes/".$this->config["theme"]."/";
		}

		if (!$this->config["multilanguage"])
			$this->SetLanguage($this->config["language"]);

		// registering resources
		$this->LoadAllLanguages();
		$this->LoadResource($this->userlang);
		$this->SetResource($this->userlang);
		$this->SetLanguage($this->userlang);

		// SEO
		foreach ($this->search_engines as $engine)
		{
			if (stristr($_SERVER["HTTP_USER_AGENT"], $engine))
			{
				$this->config["default_showdatetime"] = 0;
				$this->config["show_datetime"] = 0;
			}
		}

		if (!$this->method = trim($method)) $this->method = "show";

		// normalizing tag name
		if (!preg_match("/^[".$this->language["ALPHANUM_P"]."\!]+$/", $tag))
			$tag = $this->tryUtfDecode($tag);

		$tag = str_replace("'", "_", str_replace("\\", "", str_replace("_", "", $tag)));
		$tag = preg_replace("/[^".$this->language["ALPHANUM_P"]."\_\-\.]/", "", $tag);

		$this->tag		= $tag;
		$this->supertag	= $this->NpjTranslit($tag);

		$time = isset($_GET["time"]) ? $_GET["time"] : "";

		$page = $this->LoadPage($this->tag, $time);

		if ($this->config["outlook_workaround"] && !$page)
		{
			$page = $this->LoadPage($this->supertag."'", $time);
		}

		$this->SetPage($page);
		$this->LogReferrer();
		$this->SetBookmarks();

		if (!$user && $this->page["modified"])
		{
			header("Last-Modified: ".gmdate("D, d M Y H:i:s", strtotime($this->page["modified"]) + 120)." GMT");
		}

		// check page watching
		if ($user && $this->page) if ($this->IsWatched($user['user_id'], $this->page["page_id"]))
		{
			$this->iswatched = true;
		}

		// display page contents
		if (preg_match("/(\.xml)$/", $this->method))
		{
			print($this->Method($this->method));
		}
		else
		{
			if (preg_match("/print$/", $this->method)) $mod = "print";

			else if (preg_match("/msword$/", $this->method)) $mod = "msword";

			else $mod = '';
			if (!isset($data)) $data = "";

			$this->CacheLinks();
			$this->current_context++;
			$this->context[$this->current_context] = $this->tag;
			$data .= $this->Method($this->method);
			$this->current_context--;
			print($this->Header($mod).$data.$this->Footer($mod));
		}
		return $this->tag;
	}

	// TOC MANIPULATIONS
	function SetTocArray($toc)
	{
		$this->body_toc = "";

		foreach ($toc as $k => $v)
		{
			$toc[$k] = implode("<poloskuns,col>", $v);
		}
		$this->body_toc = implode("<poloskuns,row>", $toc);
	}

	function BuildToc($tag, $from, $to, $num, $link = -1)
	{
		if (isset($this->tocs[$tag])) return $this->tocs[$tag];

		$page = $this->LoadPage($tag);

		if ($link === -1)
			$_link = ($this->page["tag"] != $page["tag"]) ? $this->Href("",$page["tag"]) : "";
		else
			$_link = $link;

		$toc = explode("<poloskuns,row>", $page["body_toc"]);

		foreach ($toc as $k => $v)
		{
			$toc[$k] = explode("<poloskuns,col>", $v);
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
						$_toc = array_merge($_toc, $this->BuildToc($v[0], $from, $to, $num, $link));
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
						$toc[$k][1] = $this->Format($toc[$k][1], "post_wacko");
					}
				}
			}
		}
		$this->tocs[$tag] = $_toc;
		return $_toc;
	}

	// numerating toc using prepared "$this->post_wacko_toc"
	function NumerateToc($what)
	{
		if (!is_array($this->post_wacko_action)) return $what;

		// #1. hash toc
		$hash = array();

		foreach ($this->post_wacko_toc as $v)
		{
			$hash[$v[0]] = $v;
		}

		$this->post_wacko_toc_hash = &$hash;

		if ($this->post_wacko_action["toc"])
		{
			// #2. find all <a></a><hX> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<a name=\"(h[0-9]+-[0-9]+)\"></a><h([0-9])>(.*?)</h\\3>)!i",
				array(&$this, "NumerateTocCallbackToc"), $what);
		}
		if ($this->post_wacko_action["p"])
		{
			// #2. find all <a></a><p...> & guide them in subroutine
			//     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
			$what = preg_replace_callback("!(<a name=\"(p[0-9]+-[0-9]+)\"></a><p([^>]+)>(.+?)</p>)!is",
				array(&$this, "NumerateTocCallbackP"), $what);
		}
		return $what;
	}

	function NumerateTocCallbackToc($matches)
	{
		return '<a name="'.$matches[2].'"></a><h'.$matches[3].'>'.
			($this->post_wacko_toc_hash[$matches[2]][1]
				? $this->post_wacko_toc_hash[$matches[2]][1]
				: $matches[4]).
			'</h'.$matches[3].'>';
	}

	function NumerateTocCallbackP($matches)
	{
		$before = "";
		$after = "";

		if (!($style = $this->paragrafica_styles[$this->post_wacko_action["p"]]))
		{
			$this->post_wacko_action["p"] = "before";
			$style = $this->paragrafica_styles["before"];
		}

		$len = strlen("".$this->post_wacko_maxp);
		$link = '<a href="#'.$matches[2].'">'.
		str_pad($this->post_wacko_toc_hash[$matches[2]][66], $len, "0", STR_PAD_LEFT).
		'</a>';

		foreach ($this->paragrafica_patches[$this->post_wacko_action["p"]] as $v)
		{
			$style[$v] = str_replace("##", $link, $style[$v]);
		}

		return $style["_before"].'<a name="'.$matches[2].'"></a><p'.$matches[3].'>'.
			$style["before"].$matches[4].$style["after"].
			'</p>'.$style["_after"];
	}

	// BREADCRUMBS -- additional navigation added with WackoClusters
	function GetPagePath($titles = false, $separator = '/', $linking = true)
	{
		$steps		= explode('/', $this->tag);
		$links		= array();
		$result		= '';

		for ($i = 0; $i < count($steps) -1; $i++)
		{
			if ($i == 0)	$prev = '';
			else			$prev = $links[$i - 1].$separator;
			$links[] = $prev.$steps[$i];
		}

			# camel case'ing
			$linktext = preg_replace('([A-Z][a-z])', ' ${0}', $steps[$i]);

		for ($i = 0; $i < count($steps) -1; $i++)
		{
			if ($titles == false)
				$result .= $this->Link($links[$i], '', $steps[$i]).$separator;
			else if ($linking == true)
				$result .= $this->Link($links[$i], '', $this->GetPageTitle($steps[$i])).$separator;
			else
				$result .= $this->GetPageTitle($links[$i]).' '.$separator.' ';
		}

		if ($titles == false)
			$result .= $steps[count($steps) - 1];
		else
			$result .= $this->GetPageTitle($this->tag);

		return $result;
	}

	// $id is preferred, $tag next
	function GetPageTitle($tag = '', $id = 0)
	{
		if ($tag) $tag = trim($tag, '/');

		if ($tag == true || $id != 0)
		{
			$page = $this->LoadSingle(
				"SELECT title ".
				"FROM {$this->config['table_prefix']}pages ".
				"WHERE ".( $id != 0
					? "page_id	= '".quote($this->dblink, (int)$id)."' "
					: "tag	= '".quote($this->dblink, $tag)."' " ).
				"LIMIT 1");

			if ($page['title'] == true)
				return $page['title'];
			else
				return $this->AddSpacesTitle(trim(substr($tag, strrpos($tag, '/')), '/'));
		}
		else if ($tag == false && $this->page == true)
		{
			return $this->page['title'];
		}
		else if ($tag == false && $this->page == false)
		{
			return $this->AddSpacesTitle(trim(substr($this->tag, strrpos($this->tag, '/')), '/'));
		}
	}

	// RENAMING / MOVING
	function RenamePage($tag, $NewTag, $NewSuperTag = "")
	{
		if (!$tag || !$NewTag) return false;

		if ($NewSuperTag == "")
			$NewSuperTag = $this->NpjTranslit($NewTag);

		return
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."revisions SET ".
					"tag = '".quote($this->dblink, $NewTag)."', ".
					"supertag = '".quote($this->dblink, $NewSuperTag)."' ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ")
			&&
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."pages  SET ".
					"tag = '".quote($this->dblink, $NewTag)."', ".
					"supertag = '".quote($this->dblink, $NewSuperTag)."' ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ");
	}

	function RenameFiles($tag, $NewTag, $NewSuperTag = "")
	{
		if($NewSuperTag == "")
		$NewSuperTag = $this->NpjTranslit($NewTag);

		$dir = $this->config["upload_path_per_page"]."/";

		$old_name = "@".str_replace("/", "@", $tag)."@";
		$new_name = "@".str_replace("/", "@", $NewSuperTag)."@";

		if($handle = opendir($dir))
		{
			while(false !== ($file = readdir($handle)))
			{
				if($file != "." && $file != "..")
				{
					$pos = stristr($file, $old_name);
					if ($pos !== false)
					{
						rename($dir.$file, $dir.$new_name.substr($file, strlen($old_name)));
					}
				}
			}
			closedir($handle);
		}

		return true;
	}

	// REMOVALS
	function RemoveAcls($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE a.* ".
			"FROM ".$this->config["table_prefix"]."acls a ".
				"LEFT JOIN ".$this->config["table_prefix"]."pages p ".
					"ON (a.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemovePage($tag, $comment_on_id = '0', $dontkeep = 0)
	{
		if (!$tag) return false;

		// store a copy in revisions
		if ($this->config["store_deleted_pages"] && !$dontkeep)
		{
			// loading page
			$page = $this->LoadPage($tag);

			// unlink comment tag
			if ($page['comment_on_id'] != '0')
			{
				$page['comment_on_id']	= '0';
			}

			// saving original
			$this->SaveRevision($page);
			// saving updated for the current user
			$page['modified']	= date(SQL_DATE_FORMAT);
			$page['user']	= $this->GetUserName();
			$page['ip']		= $this->GetUserIP();
			$this->SaveRevision($page);
		}

		// delete page
		$this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."pages ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ");

		// for removed comment correct comments count on commented page
		if ($comment_on_id)
		{
			$this->Query(
				"UPDATE {$this->config['table_prefix']}pages SET ".
					"comments	= '".(int)$this->CountComments($comment_on_id)."' ".
				"WHERE tag = '".quote($this->dblink, $this->GetCommentOnTag($comment_on_id))."' ".
				"LIMIT 1");
		}

		return true;
	}

	function RemoveRevisions($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE FROM {$this->config['table_prefix']}revisions ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveComments($tag, $cluster = false, $dontkeep = 0)
	{
		if (!$tag) return false;

		if ($comments = $this->LoadAll(
		"SELECT a.tag FROM ".$this->config["table_prefix"]."pages a ".
			"INNER JOIN ".$this->config["table_prefix"]."pages b ON (a.comment_on_id = b.page_id) ".
		"WHERE b.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' "))
		{
			foreach ($comments as $comment) $this->RemovePage($comment['tag'], '', $dontkeep);
		}

		// reset comments count
		$this->Query(
			"UPDATE {$this->config['table_prefix']}pages ".
			"SET comments	= '0' ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		return true;
	}

	function RemoveWatches($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE w.* ".
			"FROM ".$this->config["table_prefix"]."watches w ".
				"LEFT JOIN ".$this->config["table_prefix"]."pages p ".
					"ON (w.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveLinks($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."links ".
			"WHERE from_tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveKeywords($tag, $cluster = false)
	{
		if (!$tag) return false;

		$this->Query(
			"UPDATE {$this->config['table_prefix']}pages ".
			"SET keywords = '' ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		$this->Query(
			"DELETE k.* ".
			"FROM {$this->config['table_prefix']}keywords_pages k ".
				"LEFT JOIN ".$this->config["table_prefix"]."pages p ".
					"ON (k.page_id = p.page_id) ".
			"WHERE p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		return true;
	}

	function RemoveReferrers($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE ".
				"r.* ".
			"FROM ".
				$this->config["table_prefix"]."referrers r ".
				"INNER JOIN ".$this->config["table_prefix"]."pages p ON (r.page_id = p.page_id) ".
			"WHERE ".
				"p.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveFiles($tag, $cluster = false)
	{
		if (!$tag) return false;

		$pages = $this->LoadAll(
			"SELECT page_id, supertag ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->LoadAll(
				"SELECT filename ".
				"FROM {$this->config['table_prefix']}upload ".
				"WHERE page_id = '".quote($this->dblink, $page['page_id'])."'");

			foreach ($files as $file)
			{
				// remove from FS
				$filename = $this->config['upload_path_per_page'].'/@'.
					str_replace('/', '@', $page['supertag']).'@'.$file['filename'];
				@unlink($filename);
			}
			// remove from DB
			$this->Query(
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
	function PasswordComplexity($login, $pwd)
	{
		$unlike_login	= $this->config['pwd_unlike_login'];
		$char_classes	= $this->config['pwd_char_classes'];
		$min_chars		= $this->config['pwd_min_chars'];
		$error			= 0;

		$l = strlen($login);
		$p = strlen($pwd);
		if ($l == 0 || $p == 0)
			$r = 0;
		else
			$r = ($p > $l ? $p / $l : $l / $p);

		// check if password is like a login or contains login string
		switch ($unlike_login)
		{
			case 2:	// don't run this check if login is much shorter than password or vice versa
				if (($l > 4 && $p > 4) && $r < 4)
					if (stristr($login, $pwd) !== false || stristr($pwd, $login) !== false)
					{
						$error += 1;
						break;
					}
			case 1:
				if (strcasecmp($login, $pwd) === 0)
					$error += 1;
		}

		// check password length
		if ($p < $min_chars) $error += 2;

		// check character classes requirements
		switch ($char_classes)
		{
			case 1:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[a-zA-Zà-ÿÀ-ß]+/', $pwd))
						$error += 5;
				break;

			case 2:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd))
						$error += 5;
				break;

			case 3:
				if (!preg_match('/[0-9]+/', $pwd) ||
					!preg_match('/[A-ZÀ-ß]+/', $pwd) ||
					!preg_match('/[a-zà-ÿ]+/', $pwd) ||
					!preg_match('/[\W]+/', $pwd))
						$error += 5;
				break;
		}
		return $error;
	}


	// Generate random password of defined $length that satisfise the complexity rules:
	// containing n>0 of uppercase ($uc), lowercase ($lc), digits ($di) and symbols ($sy).
	// The password complexity can be defined in $pwd_complexity :
	// $pwd_complexity = 2 -- password consists of uppercase, lowercase, digits
	// $pwd_complexity = 3 -- password consists of uppercase, lowercase, digits and symbols
	function randomPassword($length, $pwd_complexity)
	{
		$chars_uc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars_lc = 'abcdefghijklmnopqrstuvwxyz';
		$digits = '0123456789';
		$symbols = '-_!@#$%^&*(){}[]|~';
		$uc = 0;
		$lc = 0;
		$di = 0;
		$sy = 0;

		if ($pwd_complexity == 2) $sy = 100;

		while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0) {
			$password = '';
			for ($i=0; $i < $length; $i++) {
				$k = rand(0,$pwd_complexity);  //randomly choose what's next
				if ($k==0) {   //uppercase
					$password .= substr(str_shuffle($chars_uc),rand(0,sizeof($chars_uc)-2),1);
					$uc++;
				}
				if ($k==1) {   //lowercase
					$password .= substr(str_shuffle($chars_lc),rand(0,sizeof($chars_lc)-2),1);
					$lc++;
				}
				if ($k==2) {   //digits
					$password .= substr(str_shuffle($digits),rand(0,sizeof($digits)-2),1);
					$di++;
				}
				if ($k==3) {   //symbols
					$password .= substr(str_shuffle($symbols),rand(0,sizeof($symbols)-2),1);
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
	function Pagination($total, $perpage = 100, $name = 'p', $params = '', $method = '', $tag = '')
	{
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
			$pagination['text'] = $this->GetTranslation('ToThePage').': ';

			// prev page shortcut
			if ($page < 2)
			{
				$pagination['text'] .= '';
			}
			else
			{
				$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.($page - 1).( $params == true ? '&amp;'.$params : '' )).'">&laquo; '.$this->GetTranslation('PrevAcr').'</a>';
			}

			// pages range links
			if ($pages <= 10)	// not so many pages
			{
				for ($p = 1; $p <= $pages; $p++)
				{
					if ($p != $page)
						$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
					else	// don't make link for the current page
						$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
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
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
						else	// don't make link for the current page
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
					}

					// middle skipped
					$pagination['text'] .= ' ... ,';

					// last pages
					for ($p = ($pages - 4); $p <= $pages; $p++)
					{
						if ($p != $page)
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
						else	// don't make link for the current page
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
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
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>,';
						else	// don't make link for the current page
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.$sep;
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
				$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.($page + 1).( $params == true ? '&amp;'.$params : '' )).'">'.$this->GetTranslation('NextAcr').' &raquo;</a>';
			}
		}

		return $pagination;
	}

	// log event into the system journal. $message may use wiki
	// syntax, however if used before locale resources registration,
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
	function Log($level, $message)
	{
		// check input
		if (!is_numeric($level)) return false;

		// check event level: do we have to log it?
		if ((int)$this->config['log_min_level'] === -1 ||
		((int)$this->config['log_min_level'] !== 0 &&
		$level > (int)$this->config['log_min_level']))
		{
			return true;
		}

		$html = $this->config['allow_rawhtml'];
		$this->config['allow_rawhtml'] = 0;
		$message = ( $this->language ? $this->Format($message, 'wacko') : $message );
		$user_id = $this->GetUserId();
		$this->config['allow_rawhtml'] = $html;

		// current timestamp set automatically
		return $this->Query(
			"INSERT INTO {$this->config['table_prefix']}log SET ".
				"level		= '".quote($this->dblink, $level)."', ".
				"user_id		= '".quote($this->dblink, $user_id ? $user_id : 0 )."', ".
				"ip			= '".quote($this->dblink, $this->GetUserIP())."', ".
				"message	= '".quote($this->dblink, $message)."'");
	}

	// load keywords for the page's particular language.
	// if root string value is passed, returns number of
	// pages under each category and below defined root
	// page
	function GetKeywordsList($lang, $cache = 1, $root = false)
	{
		if ($_keywords = $this->LoadAll(
		"SELECT keyword_id, parent, keyword ".
		"FROM {$this->config['table_prefix']}keywords ".
		"WHERE lang = '".quote($this->dblink, $lang)."' ".
		"ORDER BY parent ASC, keyword ASC", $cache))
		{
			// process pages count (if have to)
			if ($root !== false)
			{
				if ($_counts = $this->LoadAll(
				"SELECT kp.keyword_id, COUNT( kp.page_id ) AS n ".
				"FROM {$this->config['table_prefix']}keywords k , ".
					"{$this->config['table_prefix']}keywords_pages kp ".
					( $root != ''
						? "INNER JOIN ".$this->config["table_prefix"]."pages p ON (kp.page_id = p.page_id) "
						: '' ).
				"WHERE k.lang = '".quote($this->dblink, $lang)."' AND kp.keyword_id = k.keyword_id ".
					( $root != ''
						? "AND ( p.tag = '".quote($this->dblink, $root)."' OR p.tag LIKE '".quote($this->dblink, $root)."/%' ) "
						: '' ).
				"GROUP BY keyword_id", 1))
				{
					foreach ($_counts as $count) $counts[$count['keyword_id']] = $count['n'];
				}
			}

			// process categories names
			foreach ($_keywords as $word)
			{
				$keywords[$word['keyword_id']] = array(
					'parent'	=> $word['parent'],
					'keyword'		=> $word['keyword'],
					'n'			=> $counts[$word['keyword_id']]
				);
			}

			foreach ($keywords as $id => $word)
			{
				if ($keywords[$word['parent']])
				{
					$keywords[$word['parent']]['childs'][$id] = $word;
					unset($keywords[$id]);
				}
			}
			return $keywords;
		}
		else return false;
	}

	// save keywords selected in webform. ids are
	// passed through POST global array. returns:
	//	true	- if something was saved
	//	false	- if list was empty
	function SaveKeywordsList($page_id, $dryrun = 0)
	{
		// what's selected
		foreach ($_POST as $key => $val)
		{
			if (preg_match('/^keyword([0-9]+)\|([0-9]+)$/', $key, $ids) && $val == 'set')
			{
				$set[] = $ids[1];

				if ($ids[2] != '0' && !in_array($ids[2], $set)) $set[] = $ids[2];
			}
		}

		// update list if any
		if ($set)
		{
			if (!$dryrun)
			{
				foreach ($set as $id) $values[] = "(".quote($this->dblink, (int)$id).", '".quote($this->dblink, $page_id)."')";

				$this->Query(
					"INSERT INTO {$this->config['table_prefix']}keywords_pages (keyword_id, page_id) ".
					"VALUES ".implode(', ', $values));
				$this->Query(
					"UPDATE {$this->config['table_prefix']}pages ".
					"SET keywords = '".quote($this->dblink, implode(' ', $set))."' ".
					"WHERE page_id = '".quote($this->dblink, $page_id)."' ");
			}
			return true;
		}
		else return false;
	}

}

?>