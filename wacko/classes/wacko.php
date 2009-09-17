<?php

// engine class
class Wacko
{
	// VARIABLES
	var $config	= array();
	var $dblink;
	var $page;
	var $tag;
	var $queryTime;
	var $queryLog = array();
	var $interWiki = array();
	var $aclCache = array();
	var $VERSION;
	var $WVERSION; //Wacko version
	var $context = array("");
	var $current_context = 0;
	var $pages_meta = "id, tag, created, time, edit_note, minor_edit, owner, user, latest, handler, comment_on_id, supertag, lang, title, keywords, description";
	var $first_inclusion = array(); // for backlinks
	var $optionSplitter = "\n"; // if you change this two symbols, settings for all users will be lost.
	var $valueSplitter  = "=";
	var $format_safe = true; //for htmlspecialchars() in PreLink
	var $unicode_entities = array(); //common unicode array
	var $timer;
	var $toc_context = array();
	var $search_engines = array("bot", "rambler", "yandex", "crawl", "search", "archiver", "slurp", "aport", "crawler", "google", "inktomi", "spider", );
	var $_langlist = null;
	var $languages = null;
	var $resources = null;
	var $wantedCache = null;
	var $pageCache = null;
	var $_formatter_noautolinks = null;
	var $numerate_links	= null;
	var $post_wacko_action = null;
	var $_userhost = null;
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
		$this->VERSION = WAKKA_VERSION;
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

		return $data;
	}

	function LoadSingle($query, $docache = 0)
	{
		if ($data = $this->LoadAll($query, $docache)) return $data[0];
	}

	// MISC
	function GetMicroTime()
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	function GetPageTag() { return $this->tag; }
	function GetPageId($tag = 0)
	{
		if(!$tag)
		{
			return $this->page["id"];
		}
		else
		//Soon we'll need to have page ID when saving a new page to continue working with $ID instead of $tag
		{
			// Returns Array ( [id] => Value )
			$get_page_ID = $this->LoadSingle(
				"SELECT id ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag = '".quote($this->dblink, $tag)."' LIMIT 1");

			// Get the_ID value
			$new_page_id = $get_page_ID['id'];

			return $new_page_id;
		}
	}
	function GetPageSuperTag() { return $this->supertag; }
	function GetPageTime() { return $this->page["time"]; }
	function GetPageLastWriter() { return $this->page["user"]; }
	function GetMethod() { return $this->method; }
	function GetConfigValue($name) { return isset( $this->config[$name] ) ? $this->config[$name] : ''; }
	function GetWackoName() { return $this->config["wacko_name"]; }
	function GetWakkaVersion() { return $this->VERSION; }
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
			$page_id = $page["id"];

			if (!$page_id) return false;
		}

		if (!($file = $this->filesCache[$page_id][$filename]))
		{
			$what = $this->LoadAll(
				"SELECT id, filename, filesize, description, picture_w, picture_h, file_ext ".
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
		return $this->GetTimeStringFormatted($this->page["time"]);
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
		if (!$this->resources[$lang])
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
			$wackoResource = array_merge($wackoTranslation, $this->resources["all"]);

			// theme
			$resourcefile = "themes/".$this->config["theme"]."/lang/wacko.".$lang.".php";
			if (@file_exists($resourcefile)) include($resourcefile);
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
				$this->userlang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

				// Check whether we have language files for this language
				if(!in_array($this->userlang, $this->AvailableLanguages()))
				{
					// The HTTP_ACCEPT_LANGUAGE language doesn't have any language files so use the admin set language instead
					$this->userlang = $this->config["language"];
				}
			}
			else
			{
				$this->userlang = $this->config["language"];
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
		if ($this->GetMethod() == "edit" && (isset($_GET["add"]) && $_GET["add"] == 1 ))
			if (isset($_REQUEST["lang"]) && in_array(isset($_REQUEST["lang"]), $langlist))
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

		$tag = str_replace( "//", "/", $tag );
		$tag = str_replace( "-", "", $tag );
		$tag = str_replace( " ", "", $tag );
		$tag = str_replace( "'", "_", $tag );
		$_tag = strtolower( $tag );

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

	function LoadPageById($id)
	{
		if ($id != "-1")
			return $this->LoadSingle(
				"SELECT * ".
				"FROM ".$this->config["table_prefix"]."revisions ".
				"WHERE id = '".quote($this->dblink, $id)."' ".
				"LIMIT 1");
		else
			return $this->LoadSingle(
				"SELECT * ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag='".quote($this->dblink, $this->GetPageTag())."' ".
				"LIMIT 1");
	}

	// wrapper for OldLoadPage
	function LoadPage($tag, $time = "", $cache = LOAD_CACHE, $metadataonly = LOAD_ALL)
	{
		$supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);

		if ($this->GetCachedWantedPage($supertag) == 1) return "";

		// 1. search for supertag
		$page = $this->OldLoadPage($supertag, $time, $cache, true, $metadataonly);

		// 2. if not found, search for tag
		if (!$page)
		//	{
			$page = $this->OldLoadPage($tag, $time, $cache, false, $metadataonly);
		/*
		// 3. if found, update supertag
		if ($page)
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."pages ".
				"SET supertag='".$supertag."' WHERE tag = '".$tag."';" );
		}
		}
		*/

		// 3. still nothing? file under wanted
		if (!$page) $this->CacheWantedPage($supertag);

		return $page;
	}

	function OldLoadPage($tag, $time = "", $cache = 1, $supertagged = false, $metadataonly = 0)
	{
		if ($tag == "") return "";

		$page = null;

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
					"WHERE supertag='".quote($this->dblink, $tag)."' ".
					"LIMIT 1");

				if ($time && $time != $page["time"])
				{
					$this->CachePage($page, $metadataonly);

					$page = $this->LoadSingle(
						"SELECT ".$what." ".
						"FROM ".$this->config["table_prefix"]."revisions ".
						"WHERE supertag='".quote($this->dblink, $tag)."' ".
							"AND time = '".quote($this->dblink, $time)."' ".
						"LIMIT 1");
				}
			}
			else
			{
				$page = $this->LoadSingle(
					"SELECT ".$what." ".
					"FROM ".$this->config["table_prefix"]."pages ".
					"WHERE tag='".quote($this->dblink, $tag)."' ".
					"LIMIT 1");

				if ($time && $time != $page["time"])
				{
					$this->CachePage($page, $metadataonly);

					$page = $this->LoadSingle(
						"SELECT ".$what." ".
						"FROM ".$this->config["table_prefix"]."revisions ".
						"WHERE tag='".quote($this->dblink, $tag)."' ".
							"AND time = '".quote($this->dblink, $time)."' ".
						"LIMIT 1");

				}
			}
		}
		// cache result
		if (!$time && !$cachedPage) $this->CachePage($page, $metadataonly);

		return $page;
	}

	function GetCachedPage($tag, $metadataonly = 0)
	{
		if (isset( $this->pageCache[$tag] ))
		{
			if ($this->pageCache[$tag]["mdonly"] == 0 || $metadataonly == $this->pageCache[$tag]["mdonly"])
			{
				return $this->pageCache[$tag];
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
		if ($links = $this->LoadAll(
		"SELECT * FROM ".$this->config["table_prefix"]."links ".
		"WHERE from_tag='".quote($this->dblink, $this->GetPageTag())."'"))
		{
			$cl = count($links);

			for ($i = 0; $i < $cl; $i++)
			{
				$pages[$i] = $links[$i]["to_tag"];
			}
		}

		$user = $this->GetUser();
		$pages[$cl] = $user["name"];
		$bookm = $this->GetDefaultBookmarks($user["lang"], "site")."\n".
					($user["bookmarks"]
						? $user["bookmarks"]
						: $this->GetDefaultBookmarks($user["lang"]));
		$bookmarks = explode("\n", $bookm);

		for ($i = 0; $i <= count($bookmarks); $i++)
		{
			if (preg_match("/^[\(\[]/", $bookmarks[$i]))
				$pages[$cl+$i] = preg_replace("/^(.*?)\s.*$/","\\1",preg_replace("/[\[\]\(\)]/","",$bookmarks[$i]));
		}

		$pages[] = $this->GetPageTag();
		$spages	= $pages;
		$spages_str = '';
		$pages_str = '';

		for ($i = 0; $i < count($pages); $i++)
		{
			$spages[$i] = $this->NpjTranslit($pages[$i], TRAN_LOWERCASE, TRAN_DONTLOAD);
			$spages_str .= "'".quote($this->dblink, $spages[$i])."', ";
			$pages_str .= "'".quote($this->dblink, $pages[$i])."', ";
		}

		$spages_str=substr($spages_str, 0, strlen($spages_str) - 2);
		$pages_str=substr($pages_str, 0, strlen($pages_str) - 2);

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

		for ($i = 0; $i < count($notexists); $i++)
		{
			$this->CacheWantedPage($pages[array_search($notexists[$i], $spages)], 1);
			$this->CacheACL($notexists[$i], "read", 1, $acl);
		}

		//   unset($exists);
		if ($read_acls = $this->LoadAll(
		"SELECT * FROM ".$this->config["table_prefix"]."acls ".
		"WHERE BINARY page_tag IN (".$pages_str.") AND privilege = 'read'", 1))
		{
			for ($i = 0; $i < count($read_acls); $i++)
			{
				$this->CacheACL($read_acls[$i]["supertag"], "read", 1, $read_acls[$i]);
				//       $exists[] = $read_acls[$i]["tag"];
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
	function LoadRevisions($page)
	{
		$rev = $this->LoadAll(
			"SELECT ".$this->pages_meta." ".
			"FROM ".$this->config["table_prefix"]."revisions ".
			"WHERE tag='".quote($this->dblink, $page)."' ".
			"ORDER BY time DESC");

		if ($rev == true)
		{
			if ($cur = $this->LoadSingle(
				"SELECT ".$this->pages_meta." ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag='".quote($this->dblink, $page)."' ".
				"ORDER BY time DESC ".
				"LIMIT 1"))
			{
				array_unshift($rev, $cur);
			}
		}
		else
		{
			$rev = $this->LoadAll(
				"SELECT ".$this->pages_meta." ".
				"FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag='".quote($this->dblink, $page)."' ".
				"ORDER BY time DESC ".
				"LIMIT 1");
		}
		return $rev;
	}

	function LoadPagesLinkingTo($tag, $for = "")
	{
		return $this->LoadAll(
			"SELECT from_tag AS tag ".
			"FROM ".$this->config["table_prefix"]."links ".
			"WHERE ".($for
				? "from_tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
				"((to_supertag='' AND to_tag='".quote($this->dblink, $tag)."') OR to_supertag='".quote($this->dblink, $this->NpJTranslit($tag))."')".
			" ORDER BY tag", 1);
	}

	function LoadRecentlyChanged($limit = 100, $for = "", $from = "")
	{
		$limit = (int)$limit;

		if ($pages = $this->LoadAll(
		"SELECT ".$this->pages_meta." ".
		"FROM ".$this->config["table_prefix"]."pages ".
		"WHERE comment_on_id = '0' ".
			($from
				? "AND time <= '".quote($this->dblink, $from)." 23:59:59'"
				: "").
			($for
				? "AND supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
				: "").
		"ORDER BY time DESC ".
		"LIMIT ".$limit, 1))
		{
			foreach ($pages as $page)
			{
				$this->CachePage($page, 1);
			}

			if ($read_acls = $this->LoadAll(
			"SELECT a.* ".
			"FROM ".$this->config["table_prefix"]."acls a, ".$this->config["table_prefix"]."pages p ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.supertag = p.supertag ".
				($for
					? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
					: "").
			"AND privilege = 'read' ".
			"ORDER BY time DESC ".
			"LIMIT ".$limit, 1))
			{
				for ($i = 0; $i < count($read_acls); $i++)
				{
					$this->CacheACL($read_acls[$i]["supertag"], "read", 1,$read_acls[$i]);
				}
			}
			return $pages;
		}
	}

	function LoadRecentlyComment($limit = 100, $for="", $from="")
	{
		$limit = (int) $limit;

		if ($pages = $this->LoadAll(
		"SELECT ".$this->pages_meta.", body_r FROM ".$this->config["table_prefix"]."pages ".
		"WHERE comment_on_id != '0' ".
			($from
				? "AND time<='".quote($this->dblink, $from)." 23:59:59'"
				: "").
			($for
				? "AND supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
				: "").
		"ORDER BY time DESC ".
		"LIMIT ".$limit))
		{
			foreach ($pages as $page)
			{
				$this->CachePage($page, 1);
			}

			if ($read_acls = $this->LoadAll(
			"SELECT a.* ".
			"FROM ".$this->config["table_prefix"]."acls a, ".$this->config["table_prefix"]."pages p ".
			"WHERE p.comment_on_id = '0' ".
				"AND a.supertag = p.supertag ".
					($for
						? "AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' "
						: "").
			"AND privilege = 'read' ".
			"ORDER BY time DESC ".
			"LIMIT ".$limit))

			for ($i = 0; $i < count($read_acls); $i++)
			{
				$this->CacheACL($read_acls[$i]["supertag"], "read", 1, $read_acls[$i]);
			}
			return $pages;
		}
	}

	function LoadWantedPages($for = "")
	{
		$pref = $this->config["table_prefix"];
		$sql = "SELECT DISTINCT ".$pref."links.to_tag AS wanted_tag ".
		"FROM ".$pref."links ".
			"LEFT JOIN ".$pref."pages ON ".
			"((".$pref."links.to_tag = ".$pref."pages.tag ".
				"AND ".$pref."links.to_supertag='') ".
				"OR ".$pref."links.to_supertag=".$pref."pages.supertag) ".
		"WHERE ".
			($for
				? $pref."links.to_tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
		$pref."pages.tag is NULL GROUP BY wanted_tag ".
		"ORDER BY wanted_tag ASC";
		return $this->LoadAll($sql);
	}

	function LoadOrphanedPages($for = "")
	{
		$pref = $this->config["table_prefix"];
		$sql = "SELECT DISTINCT tag FROM ".$pref."pages ".
			"LEFT JOIN ".$pref."links ON ".
			//     $pref."pages.tag = ".$pref."links.to_tag WHERE ".
			"((".$pref."links.to_tag = ".$pref."pages.tag ".
				"AND ".$pref."links.to_supertag='') ".
				"OR ".$pref."links.to_supertag=".$pref."pages.supertag) ".
		"WHERE ".
			($for
				? $pref."pages.tag LIKE '".quote($this->dblink, $for)."/%' AND "
				: "").
		$pref."links.to_tag is NULL AND ".$pref."pages.comment_on_id = '0' ".
		"ORDER BY tag ".
		"LIMIT 200";
		return $this->LoadAll($sql);
	}

	function LoadPageTitles() { return $this->LoadAll("SELECT DISTINCT tag FROM ".$this->config["table_prefix"]."pages ORDER BY tag"); }
	function LoadAllPages() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE comment_on_id = '0' ORDER BY BINARY tag"); }
	function LoadAllPagesByTime() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE comment_on_id = '0' ORDER BY time DESC, BINARY tag"); }

	function FullTextSearch($phrase,$filter)
	{
		return $this->LoadAll("SELECT ".$this->pages_meta.", body FROM ".$this->config["table_prefix"]."pages WHERE (( match(body) against('".quote($this->dblink, $phrase)."') OR lower(tag) LIKE lower('%".quote($this->dblink, $phrase)."%')) ".($filter?"AND comment_on_id='0'":"")." )");

		/*return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"].
						"pages WHERE (( match(body) against('".quote($this->dblink, $phrase)."') ".
						"OR lower(tag) LIKE lower('%".quote($this->dblink, $phrase)."%')) ".($filter?"AND comment_on_id='0'":"")." )");*/
	}

	function TagSearch($phrase) { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE lower(tag) LIKE binary lower('%".quote($this->dblink, $phrase)."%') ORDER BY supertag"); }

	// MAILER
	// $email				- recipient address
	// $subject, $message 	- self-explaining
	// $from				- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	function SendMail($email, $subject, $message)
	{
		if (!$email) return;

		$headers = "From: =?". $this->GetCharset() ."?B?". base64_encode($this->config["wacko_name"]) ."?= <".$this->config["admin_email"].">\r\n";
		$headers .= "X-Mailer: PHP/".phpversion()."\r\n"; //mailer
		$headers .= "X-Priority: 3\r\n"; //1 UrgentMessage, 3 Normal
		$headers .= "X-Wacko: ".$this->config["base_url"]."\r\n";
		$headers .= "Content-Type: text/html; charset=".$this->GetCharset()."\r\n";
		$subject =  "=?".$this->GetCharset()."?B?" . base64_encode($subject) . "?=";
		@mail($email, $subject, "<html><head></head><body>".$message."</body></html>", $headers);
	}

	// PAGE SAVING ROUTINE
	// $tag			- page address
	// $body		- page body (plain text)
	// $edit_note	- edit summary
	// $minor_edit	- minor edit
	// $comment_on	- commented page id
	// $title		- page name (metadata)
	function SavePage($tag, $body, $edit_note = "", $minor_edit = "0", $comment_on = "0", $title = "")
	{
		// get current user
		$user = $this->GetUserName();
		$user_id = $this->GetUserId();

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
			if ($comment_on)
			{
				$this->cache->CacheInvalidate($comment_on);
			}
			else
			{
				$this->cache->CacheInvalidate($this->tag);
				$this->cache->CacheInvalidate($this->supertag);
			}
		}

		// check privileges
		if ($this->HasAccess("write", $tag) || ($comment_on && $this->HasAccess("comment", $comment_on)))
		{
			$body = $this->Format($body, "preformat");
			// is page new?
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

				$body_r = $this->Format($body, "wacko");
				if ($this->config["paragrafica"] && !$comment_on)
				{
					$body_r = $this->Format($body_r, "paragrafica");
					$body_toc = $this->body_toc;
				}

            // Manage ACLs
				if (strstr($this->context[$this->current_context], "/") && !$comment_on)
				{
					$root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context] );
					$write_acl = $this->LoadAcl($root, "write");
					while ($write_acl["default"] == 1)
					{
						$_root = $root;
						$root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $root );
						if ($root == $_root) break;
						$write_acl = $this->LoadAcl($root, "write");
					}

					$write_acl = $write_acl["list"];
					$read_acl = $this->LoadAcl($root, "read");
					$read_acl = $read_acl["list"];
					$comment_acl = $this->LoadAcl($root, "comment");
					$comment_acl = $comment_acl["list"];
				}
            else if ($comment_on)
            {
               // Give comments the same rights as their parent page
					$write_acl = $this->LoadAcl($comment_on, "write");
					$write_acl = $write_acl["list"];
					$read_acl = $this->LoadAcl($comment_on, "read");
					$read_acl = $read_acl["list"];
					$comment_acl = $this->LoadAcl($comment_on, "comment");
					$comment_acl = $comment_acl["list"];
            }
				else
				{
					$write_acl = $this->config["default_write_acl"];
					$read_acl  = $this->config["default_read_acl"];
					$comment_acl = $this->config["default_comment_acl"];
				}

				// current user is owner; if user is logged in! otherwise, no owner.
				if ($this->GetUser()) $owner = $user;
				if ($this->GetUser()) $owner_id = $user_id;

				$this->Query(
					"INSERT INTO ".$this->config["table_prefix"]."pages SET ".
						"comment_on_id = '".quote($this->dblink, $comment_on)."', ".
						"created = NOW(), ".
						"time = NOW(), ".
						"owner = '".quote($this->dblink, $owner)."', ".
						"owner_id = '".quote($this->dblink, $owner_id)."', ".
						"user = '".quote($this->dblink, $user)."', ".
						"user_id = '".quote($this->dblink, $user_id)."', ".
						"latest = '1', ".
						"supertag = '".quote($this->dblink, $this->NpjTranslit($tag))."', ".
						"body = '".quote($this->dblink, $body)."', ".
						"body_r = '".quote($this->dblink, $body_r)."', ".
						"body_toc = '".quote($this->dblink, $body_toc)."', ".
						"edit_note = '".quote($this->dblink, $edit_note)."', ".
						"minor_edit = '".quote($this->dblink, $minor_edit)."', ".
						"lang = '".quote($this->dblink, $lang)."', ".
						"tag = '".quote($this->dblink, $tag)."'");

               	// saving acls
				// $this->SaveAcl($tag, "write", ($comment_on ? "" : $write_acl));
				$this->SaveAcl($tag, "write", $write_acl);
				$this->SaveAcl($tag, "read", $read_acl);
				// $this->SaveAcl($tag, "comment", ($comment_on ? "" : $comment_acl));
				$this->SaveAcl($tag, "comment", $comment_acl);

				// set watch
				if ($this->GetUser() && !$this->config["disable_autosubscribe"])
					$this->SetWatch($this->GetUserId(), $this->GetPageId($tag));

				if ($comment_on)
				{
					// notifying watchers
					$user_id = $this->GetUserId();
					$Watchers = $this->LoadAll(
									"SELECT DISTINCT user_id ".
									"FROM ".$this->config["table_prefix"]."pagewatches ".
									"WHERE page_id = '".quote($this->dblink, $comment_on)."'");

					foreach ($Watchers as $Watcher)

					if ($Watcher["user_id"] !=  $user_id)
					{
						$_user = $this->GetUser();
						$Watcher["name"] = $Watcher["user"];
						$this->SetUser($Watcher, 0);

						if ($this->HasAccess("read", $comment_on, $Watcher["user"]))
						{
							$User = $this->LoadSingle(
								"SELECT email, lang, more, email_confirm ".
								"FROM " .$this->config["user_table"]." ".
								"WHERE name = '".quote($this->dblink, $Watcher["user"])."'");
							$User["options"] = $this->DecomposeOptions($User["more"]);

							if ($User["email_confirm"] == "" && $User["options"]["send_watchmail"] != "N")
							{
								$lang = $User["lang"];
								$this->LoadResource($lang);
								$this->SetResource ($lang);
								$this->SetLanguage ($lang);

								$subject = $this->GetTranslation("CommentForWatchedPage",$lang)."'".$comment_on."'";
								$message = $this->GetTranslation("MailHello",$lang). $Watcher["user"].".\n\n".
											$username.
											$this->GetTranslation("SomeoneCommented",$lang)."<br />  * <a href=\"".$this->Href("",$comment_on,"")."\">".$this->Href("",$comment_on,"")."</a><br /><hr />".
											$this->Format($body_r, "post_wacko")."<hr /><br />".
											$this->GetTranslation("MailGoodbye",$lang)."\n".
											$this->config["wacko_name"]."\n".
											$this->config["base_url"];

								$this->SendMail($User["email"], $subject, $message);
							}
						}
						$this->SetUser($_user, 0);
					}
				}
			}
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
				$owner = $oldPage["owner"];
				$owner_id = $oldPage["owner_id"];

				// only if page has been actually changed
				if ($oldPage['body'] != $body)
				{
					// move revision
					$this->Query(
							"INSERT INTO ".$this->config["table_prefix"]."revisions (tag, time, body, edit_note, minor_edit, owner, owner_id, user, user_id, latest, handler, comment_on_id, supertag, title, keywords, description) ".
							"SELECT tag, time, body, edit_note, minor_edit, owner, owner_id, user, user_id, 'N', handler, comment_on_id, supertag, title, keywords, description ".
							"FROM ".$this->config["table_prefix"]."pages ".
							"WHERE tag = '".quote($this->dblink, $tag)."' LIMIT 1");

					// add new revision
					$this->Query(
						"UPDATE ".$this->config["table_prefix"]."pages SET ".
							"comment_on_id = '".quote($this->dblink, $comment_on)."', ".
							"time = NOW(), ".
							"created = '".quote($this->dblink, $oldPage['created'])."', ".
							"owner = '".quote($this->dblink, $owner)."', ".
							"owner_id = '".quote($this->dblink, $owner_id)."', ".
							"user = '".quote($this->dblink, $user)."', ".
							"user_id = '".quote($this->dblink, $user_id)."', ".
							"supertag = '".$this->NpjTranslit($tag)."', ".
							"body = '".quote($this->dblink, $body)."', ".
							"body_r = '".quote($this->dblink, $body_r)."', ".
							"body_toc = '".quote($this->dblink, $body_toc)."', ".
							"edit_note = '".quote($this->dblink, $edit_note)."', ".
							"minor_edit = '".quote($this->dblink, $minor_edit)."' ".
						"WHERE tag = '".quote($this->dblink, $tag)."' ".
						"LIMIT 1");
				}

				// revisions diff
				$page = $this->LoadSingle(
					"SELECT ".$this->pages_meta." ".
					"FROM ".$this->config["table_prefix"]."revisions ".
					"WHERE tag='".quote($this->dblink, $tag)."' ".
					"ORDER BY time DESC");
				$_GET["a"] = -1;
				$_GET["b"] = $page["id"];
				$_GET["fastdiff"] = 1;
				$diff = $this->IncludeBuffered("handlers/page/diff.php", "oops");

				// notifying watchers
				$username = $this->GetUserName();
				$Watchers = $this->LoadAll(
					"SELECT DISTINCT user ".
					"FROM ".$this->config["table_prefix"]."pagewatches"." ".
					"WHERE tag = '".quote($this->dblink, $tag)."'");

				if ($Watchers)
				{
					foreach ($Watchers as $Watcher)
					if ($Watcher["user"] !=  $username)
					{
						$_user = $this->GetUser();
						$Watcher["name"] = $Watcher["user"];
						$this->SetUser($Watcher, 0);
						$lang = $Watcher["lang"];

						if ($this->HasAccess("read", $tag, $Watcher["user"]))
						{
							$User = $this->LoadSingle(
								"SELECT email, lang, more, email_confirm ".
								"FROM " .$this->config["user_table"]." ".
								"WHERE name = '".quote($this->dblink, $Watcher["user"])."'");

							$User["options"] = $this->DecomposeOptions($User["more"]);

							if ($User["email_confirm"] == "" && $User["options"]["send_watchmail"] != "N")
							{
								$lang = $User["lang"];
								$this->LoadResource($lang);
								$this->SetResource ($lang);
								$this->SetLanguage ($lang);

								$subject = $this->GetTranslation("WatchedPageChanged",$lang)."'".$tag."'";
								$message = "<style>.additions {color: #008800;}\n.deletions {color: #880000;}</style>".
											$this->GetTranslation("MailHello",$lang). $Watcher["user"]."\n\n".
											$username.
											$this->GetTranslation("SomeoneChangedThisPage",$lang)."\n". //* <a href=\"".$this->Href("",$tag,"")."\">".$this->Href("",$tag,"")."</a><br />";
											"<hr />".$diff."<hr />".
											"<br />".$this->GetTranslation("MailGoodbye",$lang)."\n".
											$this->config["wacko_name"]."\n".
											$this->config["base_url"];

								$this->SendMail($User["email"], $subject, $message);
							}
						}
						$this->SetUser($_user, 0);
					}
				}
				$this->LoadResource($this->userlang);
				$this->SetResource ($this->userlang);
				$this->SetLanguage ($this->userlang);
			}
		}

		// writing xmls
		$this->WriteRecentChangesXML();
		$this->WriteRecentCommentsXML();

		if($this->config["xml_sitemap"])
		{
			$this->WriteSiteMapXML();
		}

		return $body_r;
	}

	// update metadata of a given page
	function SaveMeta($tag, $metadata)
	{
		if ($this->UserIsOwner($tag) || $this->IsAdmin())
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."pages SET ".
					"lang = '".quote($this->dblink, $metadata["lang"])."', ".
					"title = '".quote($this->dblink, htmlspecialchars($metadata["title"]))."', ".
					"keywords = '".quote($this->dblink, $metadata["keywords"])."', ".
					"description = '".quote($this->dblink, $metadata["description"])."' ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ".
				"LIMIT 1");
		}
		return true;
	}

	// COOKIES
	function SetSessionCookie($name, $value)
	{
		SetCookie($this->config["cookie_prefix"].$name, $value, 0, "/");
		$_COOKIE[$this->config["cookie_prefix"].$name] = $value;
	}

	function SetPersistentCookie($name, $value, $remember = 1)
	{
		SetCookie($this->config["cookie_prefix"].$name, $value, time() + ($remember ? 90*24*60*60 : 60 * 60), "/");
		$_COOKIE[$this->config["cookie_prefix"].$name] = $value;
	}

	function DeleteCookie($name)
	{
		SetCookie($this->config["cookie_prefix"].$name, "", 1, "/");
		$_COOKIE[$this->config["cookie_prefix"].$name] = "";
	}

	function GetCookie($name)
	{
		return $_COOKIE[$this->config["cookie_prefix"].$name];
	}

	// HTTP/REQUEST/LINK RELATED
	function SetMessage($message)
	{
		$_SESSION[$this->config["session_prefix"].'_'."message"] = $message;
	}

	function GetMessage()
	{
		$message = $_SESSION[$this->config["session_prefix"].'_'."message"];
		$_SESSION[$this->config["session_prefix"].'_'."message"] = "";
		return $message;
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
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");                          // HTTP/1.0
	}

	function UnwrapLink($tag)
	{
		if ($tag == "/") return "";
		if ($tag == "!") return $this->context[$this->current_context];

		$newtag = $tag;

		if (strstr($this->context[$this->current_context], "/"))
			$root = preg_replace("/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context]);
		else
			$root = "";

		if (preg_match("/^\.\/(.*)$/", $tag, $matches))
		{
			$root = "";
		}
		else if (preg_match("/^\/(.*)$/", $tag, $matches))
		{
			$root = "";
			$newtag = $matches[1];
		}
		else if (preg_match("/^\!\/(.*)$/", $tag, $matches))
		{
			$root = $this->context[$this->current_context];
			$newtag = $matches[1];
		}
		else if (preg_match("/^\.\.\/(.*)$/", $tag, $matches))
		{
			$newtag = $matches[1];

			if (strstr($root, "/"))
				$root = preg_replace("/^(.*)\\/([^\\/]+)$/", "$1", $root);
			else
				$root = "";
		}

		if ($root != "") $newtag= "/".$newtag;

		$tag = $root.$newtag;
		$tag = str_replace("//", "/", $tag);

		return $tag;
	}

	// returns just PageName[/method].
	function MiniHref($method = "", $tag = "", $addpage = "")
	{
		if (!$tag = trim($tag)) $tag = $this->tag;
		if (!$addpage) $tag = $this->SlimUrl($tag);
		// if (!$addpage) $tag = $this->NpjTranslit($tag);

		$tag = trim($tag, "/.");
		// $tag = str_replace(array("%2F", "%3F", "%3D"), array("/", "?", "="), rawurlencode($tag));

		return $tag.($method ? "/".$method : "");
	}

	// returns the full url to a page/method.
	function Href($method = "", $tag = "", $params = "", $addpage = 0)
	{
		$href = $this->config["base_url"].$this->MiniHref($method, $tag, $addpage);

		if ($addpage) $params = "add=1".($params ? "&amp;".$params : "");
		if ($params)
		{
			$href .= ($this->config["rewrite_mode"] ? "?" : "&amp;").$params;
		}
		return $href;
	}

	function SlimUrl($text)
	{
		$text = $this->NpjTranslit($text, TRAN_DONTCHANGE);
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
		//    if (!$text) $text = $this->AddSpaces($tag);

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
		$class = '';
		$title = '';
		$lang = '';
		$url = '';
		$imlink = false;
		$text = str_replace('"', "&quot;", $text);

		if (!$safe)
			$text = htmlspecialchars($text, ENT_NOQUOTES);

		if ($linklang)
			$this->SetLanguage($linklang);

		if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $text))
		{
			$imlink = $this->config["base_url"]."/images/".$text;
		}
		else if (preg_match("/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", preg_replace("/<\/?nobr>/", "" ,$text)))
		{
			$imlink = $text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
		}

		if (preg_match("/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/", $tag, $matches))
		{
			// this is a valid Email
			$url = ($matches[1] == "mailto:" ? $tag : "mailto:".$tag);
			$title = $this->GetTranslation("MailLink");
			$icon = $this->GetTranslation("mailicon");
			$tpl = "email";
		}
		else if (preg_match("/^#/", $tag))
		{
			// html-anchor
			$url = $tag;
			$tpl = "anchor";
		}
		else if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
		{
			// image
			$text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
			return "<img src=\"".$this->config["base_url"]."/images/".$tag."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." />";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
		{
			// external image
			$text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
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
			$url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title= $this->GetTranslation("FileLink");
			$icon = $this->GetTranslation("fileicon");
			$tpl = "file";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/", $tag)) {
			// this is a PDF link
			$url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title= $this->GetTranslation("PDFLink");
			$icon = $this->GetTranslation("pdficon");
			$tpl = "file";
		}
		else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/", $tag)) {
			// this is a RDF link
			$url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$title= $this->GetTranslation("RDFLink");
			$icon = $this->GetTranslation("rdficon");
			$tpl = "file";
		}
		else if (preg_match("/^(http|https|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/", $tag))
		{
			// this is a valid external URL
			$url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
			$tpl = "outerlink";
			if (!stristr($tag,$this->config["base_url"]))
			{
				$title= $this->GetTranslation("OuterLink2");
				$icon = $this->GetTranslation("outericon");
			}
		}
		else if (preg_match("/^(_?)file:([^\\s\"<>\(\)]+)$/", $tag, $matches))
		{
			// this is a file:
			$noimg = $matches[1];
			$thing = $matches[2];
			$arr = explode("/", $thing);

			if (count($arr) == 1)                // file:some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->CheckFileExists($thing);

				if (is_array($desc))
				{
					$title = $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
					$url = $this->config["base_url"].$this->config["upload_path"]."/".$thing;
					$icon = $this->GetTranslation("fileicon");
					$imlink = false;
					$tpl = "localfile";
					if ($desc["picture_w"] && !$noimg)
					{
						if (!$text) $text = $title;
						return "<img src=\"".$this->config["base_url"].$this->config["upload_path"]."/".$thing."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
					}
				}
			}

			if (count($arr) == 2 && $arr[0] == "") // file:/some.zip
			{
				//try to find in global storage and return if success
				$desc = $this->CheckFileExists($arr[1]);
				if (is_array($desc))
				{
					$title = $desc["description"]." (".ceil($desc["filesize"] / 1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
					$url = $this->config["base_url"].$this->config["upload_path"].$thing;
					$icon = $this->GetTranslation("fileicon");
					$imlink = false;
					$tpl = "localfile";
					if ($desc["picture_w"] && !$noimg)
					{
						if (!$text) $text = $title;
						return "<img src=\"".$this->config["base_url"].$this->config["upload_path"]."/".$thing."\" ".($text ? "alt=\"".$text."\" title=\"".$text."\"" : "")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
					}
				}
				else //404
				{
					$tpl = "wlocalfile";
					$title = "404: /".$this->config["upload_path"].$thing;
					$url = "404";
				}
			}

			if (!$url)
			{
				$file = $arr[count($arr) - 1];
				unset($arr[count($arr) - 1]);
				$_pagetag = implode("/", $arr);

				if ($_pagetag == "") $_pagetag = "!/";

				//unwrap tag (check !/, ../ cases)
				$pagetag = rtrim($this->NpjTranslit($this->UnwrapLink($_pagetag)), "./");

				//try to find in local $tag storage
				$desc = $this->CheckFileExists($file, $pagetag);

				if (is_array($desc))
				{
					//check 403 here!
					if ($this->IsAdmin() || ($desc["id"] && ($this->GetPageOwnerId($this->tag) == $this->GetUserId())) ||
					($this->HasAccess("read", $pagetag)) || ($desc["user_id"] == $this->GetUserId()))
					{
						$title = $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetTranslation("UploadKB").")";
						$url = $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
						$imlink = false;
						$icon = $this->GetTranslation("fileicon");
						$tpl = "localfile";
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
						$url = $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
						$icon = $this->GetTranslation("lockicon");
						$imlink = false;
						$tpl = "localfile";
						$class = "denied";
					}
				}
				else //404
				{
					$title = "404: /".trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
					$url = "404";
					$tpl = "wlocalfile";
				}
			}
			//forgot 'bout 403
		}
		else if ($this->config["disable_tikilinks"] != 1 && preg_match("/^(".$this->language["UPPER"].$this->language["LOWER"].$this->language["ALPHANUM"]."*)\.(".$this->language["ALPHA"].$this->language["ALPHANUM"]."+)$/s", $tag, $matches))
		{
			// it`s a Tiki link!
			$tag = "/".$matches[1]."/".$matches[2];
			if (!$text) $text = $this->AddSpaces($tag);
			return $this->Link( $tag, $method, $text, $track, 1);
		}
		else if (preg_match("/^([[:alnum:]]+)[:]([".$this->language["ALPHANUM_P"]."\-\_\.\+\&\=\#]*)$/", $tag, $matches))
		{
			// interwiki
			$parts = explode("/",$matches[2]);

			for ($i = 0; $i < count($parts); $i++)
				$parts[$i] = str_replace("%23", "#", urlencode($parts[$i]));

			if ($linklang)
				$text = $this->DoUnicodeEntities($text, $linklang);

			$url = $this->GetInterWikiUrl($matches[1], implode("/",$parts));
			$icon = $this->GetTranslation("iwicon");
			$tpl = "interwiki";
		}
		else if (preg_match("/^([\!\.\-".$this->language["ALPHANUM_P"]."]+)(\#[".$this->language["ALPHANUM_P"]."\_\-]+)?$/", $tag, $matches))
		{
			// it's a Wiki link!
			$tag = $otag = $matches[1];
			$untag = $unwtag = $this->UnwrapLink($tag);

			$regex_handlers = '/^(.*?)\/('.$this->config["standard_handlers"].')\/(.*)$/i';
			$ptag = $this->NpjTranslit($unwtag);
			$handler = null;

			if (preg_match( $regex_handlers, "/".$ptag."/", $match ))
			{
				$handler = $match[2];
				$ptag = $match[1];
				$unwtag = "/".$unwtag."/";
				$co = substr_count($_ptag, "/") - substr_count($ptag, "/");

				for ($i = 0; $i < $co; $i++)
					$unwtag = substr($unwtag, 0, strrpos($unwtag, "/"));

				if ($handler)
				{
					$opar = "/".$untag."/";

					for ($i = 0; $i < substr_count($data, "/") + 2; $i++)
						$opar = substr($opar, strpos($opar, "/") + 1);

					$params = explode("/", $opar); //there're good params
				}
			}

			$unwtag = trim($unwtag, "/.");
			$unwtag = str_replace("_", "", $unwtag);

			if ($handler)
				$method = $handler;

			$thispage = $this->LoadPage($unwtag, "", LOAD_CACHE, LOAD_META);

			if (!$thispage && $linklang)
			{
				$this->SetLanguage($linklang);
				$lang = $linklang;
				$thispage = $this->LoadPage($unwtag, "", LOAD_CACHE, LOAD_META);
			}

			if ($thispage)
			{
				$_lang = $this->language["code"];

				if ($thispage["lang"])
					$lang = $thispage["lang"];
				else
					$lang = $this->config["language"];

				$this->SetLanguage($lang);
				$supertag = $this->NpjTranslit($tag);
			}
			else
			{
				$supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);
			}

			$aname = "";

			if (substr($tag, 0, 2) == "!/")
			{
				$icon = $this->GetTranslation("childicon");
				$page0 = substr($tag, 2);
				$page = $this->AddSpaces($page0);
				$tpl = "childpage";
			}
			else if (substr($tag, 0, 3) == "../")
			{
				$icon = $this->GetTranslation("parenticon");
				$page0 = substr($tag, 3);
				$page = $this->AddSpaces($page0);
				$tpl = "parentpage";
			}
			else if (substr($tag, 0, 1) == "/")
			{
				$icon = $this->GetTranslation("rooticon");
				$page0 = substr($tag, 1);
				$page = $this->AddSpaces($page0);
				$tpl = "rootpage";
			}
			else
			{
				$icon = $this->GetTranslation("equalicon");
				$page0 = $tag;
				$page = $this->AddSpaces($page0);
				$tpl = "equalpage";
			}

			if ($imlink)
				$text = "<img src=\"$imlink\" border=\"0\" title=\"$text\" />";

			if ($text)
			{
				$tpl = "descrpage";
				$icon = "";
			}

			$pagepath = substr($untag, 0, strlen($untag) - strlen($page0));
			$anchor = isset($matches[2]) ? $matches[2] : '';
			$tag = $unwtag;

			if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track) $this->TrackLinkTo($tag);

			if ($anchorlink && !isset($this->first_inclusion[$supertag]))
			{
				$aname = "name=\"".$supertag."\"";
				$this->first_inclusion[$supertag] = 1;
			}

			if ($thispage)
			{
				$pagelink = $this->href($method, $thispage["tag"]).$this->AddDateTime($tag).($anchor ? $anchor : "");

				if ($this->config["hide_locked"])
				{
					$access = $this->HasAccess("read", $tag);
				}
				else
				{
					$access = true;
					$this->_acl["list"] == "*";
				}

				if (!$access)
				{
					$class = "denied";
					$accicon = $this->GetTranslation("lockicon");
				}
				else if ($this->_acl["list"] == "*")
				{
					$class = "";
					$accicon = "";
				}
				else
				{
					$class = "customsec";
					$accicon = $this->GetTranslation("keyicon");
				}

				if ($text == trim($otag, "/") || $linklang)
					$text = $this->DoUnicodeEntities($text, $lang);

				$page = $this->DoUnicodeEntities($page, $lang);

				if (isset($_lang)) $this->SetLanguage($_lang);
			}
			else
			{
				$tpl = ($this->method == "print" || $this->method == "msword" ? "p" : "") . "w" . $tpl;
				$pagelink = $this->href("edit", $tag, $lang ? "lang=".$lang : "", 1);
				$accicon = $this->GetTranslation("wantedicon");
				$title = $this->GetTranslation("CreatePage");

				if ($linklang)
				{
					$text = $this->DoUnicodeEntities($text, $linklang);
					$page = $this->DoUnicodeEntities($page, $linklang);
				}
			}

			$icon = str_replace("{theme}", $this->config["theme_url"], $icon);
			$accicon = str_replace("{theme}", $this->config["theme_url"], $accicon);
			$res = $this->GetTranslation("tpl.".$tpl);
			$text = trim($text);

			if ($res)
			{
				if ($this->method == 'print')
					$icon	= '';

				//todo: pagepath
				$aname = str_replace("/", ".", $aname);
				$res = str_replace("{aname}",  $aname,  $res);
				$res = str_replace("{icon}",   $icon,   $res);
				$res = str_replace("{accicon}", $accicon, $res);
				$res = str_replace("{class}",  $class,  $res);
				$res = str_replace("{title}",  $title,  $res);
				$res = str_replace("{pagelink}", $pagelink, $res);
				$res = str_replace("{pagepath}", $pagepath, $res);
				$res = str_replace("{page}",   $page,  $res);
				$res = str_replace("{text}",   $text,  $res);

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
			die ("ERROR: no link template '$tpl' found!");
		}

		if (!$text) $text = htmlspecialchars($tag, ENT_NOQUOTES);

		if ($url)
		{
			if ($imlink)
				$text = "<img src=\"$imlink\" border=\"0\" title=\"$text\" />";

			$icon = str_replace("{theme}", $this->config["theme_url"], $icon);
			$res = $this->GetTranslation("tpl.".$tpl);

			if ($res)
			{
				if (!$class)
					$class = "outerlink";
				if ($this->method == 'print')
					$icon	= '';

				$res = str_replace("{icon}",  $icon,  $res);
				$res = str_replace("{class}", $class, $res);
				$res = str_replace("{title}", $title, $res);
				$res = str_replace("{url}",   $url,   $res);
				$res = str_replace("{text}",  $text,  $res);

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
		if (!$show) $show = "1";
		// TODO: double?
		if ($show != "0" && $show != "0")
		{
			$_page = $this->LoadPage($tag, "", LOAD_CACHE, LOAD_META);
			return ($this->config["rewrite_mode"] ? "?" : "&amp;").
			"v=".base_convert($this->crc16(preg_replace("/[ :\-]/","",$_page["time"])),10,36);
		} else return "";
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
		if ($show != "0") {
			$text = preg_replace("/(".$this->language["ALPHANUM"].")(".$this->language["UPPERNUM"].")/","\\1&nbsp;\\2",$text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")(".$this->language["UPPERNUM"].")/","\\1&nbsp;\\2",$text);
			$text = preg_replace("/(".$this->language["ALPHANUM"].")\//","\\1&nbsp;/",$text);
			$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;".$this->language["UPPERNUM"].")/","\\1",$text);
			$text = preg_replace("/(".$this->language["UPPER"].")&nbsp;(?=".$this->language["UPPER"]."&nbsp;\/)/","\\1",$text);
			$text = preg_replace("/\/(".$this->language["ALPHANUM"].")/","/&nbsp;\\1",$text);
			$text = preg_replace("/(".$this->language["UPPERNUM"].")&nbsp;(".$this->language["UPPERNUM"].")($|\b)/","\\1\\2",$text);
			$text = preg_replace("/([0-9])(".$this->language["ALPHA"].")/","\\1&nbsp;\\2",$text);
			$text = preg_replace("/(".$this->language["ALPHA"].")([0-9])/","\\1&nbsp;\\2",$text);
			$text = preg_replace("/([0-9])&nbsp;(?=[0-9])/","\\1",$text);
		}

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
			"WHERE from_tag = '".quote($this->dblink, $from_tag)."'");

		if ($linktable = $this->GetLinkTable())
		{
			$from_tag = quote($this->dblink, $this->GetPageTag());
			foreach ($linktable as $to_tag)
			{
				$lower_to_tag = strtolower($to_tag);

				if (!$written[$lower_to_tag])
				{
					$query .= "('".$from_tag."','".$page_id."', '".quote($this->dblink, $to_tag)."', '".quote($this->dblink, $this->NpjTranslit($to_tag))."'),";
					$written[$lower_to_tag] = 1;
				}
			}
			$this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."links ".
					"(from_tag, from_page_id, to_tag, to_supertag) ".
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
	function FormOpen($method = "", $tag = "", $formMethod = "post", $formname="", $formMore="")
	{
		if (!$formMethod) $formMethod = "post";

		$add = isset($_REQUEST["add"]) ? $_REQUEST["add"] : '';
		$result = "<form action=\"".$this->href($method, $tag, "", $add)."\" ".$formMore." method=\"".$formMethod."\" ".($formname ? "name=\"".$formname."\" " : "").">\n";

		if (!$this->config["rewrite_mode"]) $result .= "<input type=\"hidden\" name=\"page\" value=\"".$this->MiniHref($method, $tag, $add)."\" />\n";

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
			$page_id = $this->page["id"];

		if (!$referrer = trim($referrer))
			$referrer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

		// check if it's coming from another site
		if ($referrer && !preg_match("/^".preg_quote($this->config["base_url"], "/")."/", $referrer) && isset($_GET["sid"]) === false)
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
		if ($path) $dirs = explode(":", $path);
		else $dirs = array("");

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
		$result = $this->IncludeBuffered("header".$mod.".php", "Theme is corrupt: ".$this->config["theme"], "", "themes/".$this->config["theme"]."/appearance");
		return $result;
	}

	function Footer($mod = "")
	{
		$result = $this->IncludeBuffered("footer".$mod.".php", "Theme is corrupt: ".$this->config["theme"], "", "themes/".$this->config["theme"]."/appearance");
		return $result;
	}

	function UseClass($class_name, $class_dir = "", $file_name = "")
	{
		if (!class_exists($class_name))
		{
			if ($file_name == "") $file_name = $class_name;
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
		if ($method == "show") $this->CacheLinks();
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
	function LoadUser($name, $password = 0)
	{
		$user = $this->LoadSingle(
			"SELECT * FROM ".$this->config["user_table"]." ".
			"WHERE name = '".
				quote($this->dblink, $name)."' ".($password === 0 ? "" : "AND password = '".quote($this->dblink, $password)."'")." ".
			"LIMIT 1");

		if ($user)
			$user["options"] = $this->DecomposeOptions($user["more"]);

		return $user;
	}

	function LoadUsers()
	{
		return $this->LoadAll(
			"SELECT * FROM ".$this->config["user_table"]." ORDER BY binary name");
	}

	function GetUserName()
	{
		if ($user = $this->GetUser()) $name = $user["name"];
		else if ($this->_userhost) $name = $this->_userhost;
		else
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') $name = $_SERVER["REMOTE_ADDR"];
			else if (!$name = $this->_gethostbyaddr($_SERVER["REMOTE_ADDR"])) $name = $_SERVER["REMOTE_ADDR"];
			$this->_userhost = $name;
		}
		return $name;
	}

	function GetUserId()
	{
		if ($user = $this->GetUser()) $user_id = $user["id"];

		return $user_id;
	}

	function _gethostbyaddr($ip)
	{
		if ($this->config["allow_gethostbyaddr"])
		{
			return gethostbyaddr($ip);
		}
		else
		{
			return false;
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

	// insert user data into the session array
	function SetUser($user, $setcookie = 1)
	{
		$_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."user"] = $user;
		if ($setcookie) $this->SetPersistentCookie("name", $user["name"], 1);
	}

	function LogUserIn($user)
	{
		$this->SetPersistentCookie("name", $user["name"], 1);
		$this->SetPersistentCookie("password", $user["password"]);
	}

	// end user session and free session vars
	function LogoutUser()
	{
		$_SESSION[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."user"] = "";
		$this->DeleteCookie("name");
		$this->DeleteCookie("password");
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

		return ($user["options"]["show_files"] == "Y");
	}

	// Returns boolean indicating if the current user is allowed to see comments at all
	function UserAllowedComments()
	{
		return $this->config["hide_comments"] != 1 && ($this->config["hide_comments"] != 2 || $this->GetUser());
	}

	function DecomposeOptions($more)
	{
		$b = array();
		$opts = explode($this->optionSplitter, $more);

		foreach ($opts as $o)
		{
			$params = explode($this->valueSplitter, trim($o));
			$b[$params[0]] = $params[1];
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

	// COMMENTS
	function LoadComments($tag)
	{
		return $this->LoadAll(
				"SELECT * FROM ".$this->config["table_prefix"]."pages ".
				"WHERE comment_on_id = '".quote($this->dblink, $tag)."' ".
				"ORDER BY time");
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
	function UserIsOwner($tag = "")
	{
		// check if user is logged in
		if (!$this->GetUser()) return false;

		// set default tag
		if (!$tag = trim($tag)) $tag = $this->GetPageTag();

		// check if user is owner
		if ($this->GetPageOwner($tag) == $this->GetUserName())
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
			if (!$time) return $this->page['owner'];
			else $tag = $this->GetPageTag();
		}

		if ($page = $this->LoadPage($tag, $time, LOAD_CACHE, LOAD_META))
			return $page["owner"];
	}

	function GetPageOwnerId($tag = "", $time = "")
	{
		if (!$tag = trim($tag))
		{
			if (!$time) return $this->page['owner_id'];
			else $tag = $this->GetPageTag();
		}

		if ($page = $this->LoadPage($tag, $time, LOAD_CACHE, LOAD_META))
			return $page["owner_id"];
	}

	function SetPageOwner($tag, $user)
	{
		// check if user exists
		if (!$this->LoadUser($user)) return;

		// updated latest revision with new owner
		$this->Query(
			"UPDATE ".$this->config["table_prefix"]."pages ".
			"SET owner = '".quote($this->dblink, $user)."' ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
			"LIMIT 1");
	}

	function SaveAcl($tag, $privilege, $list)
	{
		$page_id = $this->GetPageId($tag);
		$supertag = $this->NpjTranslit($tag);

		if ($this->LoadAcl($tag, $privilege, 0))
		{
			$this->Query(
				"UPDATE ".$this->config["table_prefix"]."acls SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", "", $list)))."' ".
				"WHERE supertag = '".quote($this->dblink, $supertag)."' ".
					"AND privilege = '".quote($this->dblink, $privilege)."' ");
		}
		else
		{
			$this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."acls SET ".
					"list = '".quote($this->dblink, trim(str_replace("\r", "", $list)))."', ".
					"supertag = '".quote($this->dblink, $supertag)."', ".
					"page_tag = '".quote($this->dblink, $tag)."', ".
					"page_id = '".quote($this->dblink, $page_id)."', ".
					"privilege = '".quote($this->dblink, $privilege)."'");
		}
	}

	function GetCachedACL($tag, $privilege, $useDefaults)
	{
		if (isset( $this->aclCache[$tag."#".$privilege."#".$useDefaults] ))
			return $this->aclCache[$tag."#".$privilege."#".$useDefaults];
		else
			return '';
	}

	function CacheACL($tag, $privilege, $useDefaults, $acl)
	{
		$this->aclCache[$tag."#".$privilege."#".$useDefaults] = $acl;
	}

	function LoadAcl($tag, $privilege, $useDefaults = 1)
	{
		if (!isset($acl)) $acl = "";

		$supertag = $this->NpjTranslit($tag);

		if ($cachedACL = $this->GetCachedACL($supertag, $privilege, $useDefaults))
			$acl = $cachedACL;

		if (!$acl)
		{
			if ($cachedACL = $this->GetCachedACL($tag, $privilege, $useDefaults))
				$acl = $cachedACL;

			if (!$acl)
			{

				$acl = $this->LoadSingle(
								"SELECT * ".
								"FROM ".$this->config["table_prefix"]."acls ".
								"WHERE supertag = '".quote($this->dblink, $supertag)."' ".
									"AND privilege = '".quote($this->dblink, $privilege)."' ".
								"LIMIT 1");
				if (!$acl)
				{
					$acl = $this->LoadSingle(
									"SELECT * FROM ".$this->config["table_prefix"]."acls ".
									"WHERE page_tag = '".quote($this->dblink, $tag)."' ".
										"AND privilege = '".quote($this->dblink, $privilege)."' ".
									"LIMIT 1");
					/*        if ($acl)
					 {
					 $this->Query(
						"UPDATE ".$this->config["table_prefix"]."acls ".
					 	"SET supertag='".$supertag."' ".
						"WHERE page_tag = '".$tag."';" );
						$acl["supertag"]=$supertag;
					 }
					 */
				}

				// if still no acl, use config defaults
				if (!$acl && $useDefaults)
				{
					// First look for parent ACL, so that clusters/subpages
					// work correctly.
					if ( strstr($tag, "/") )
					{
						$parent = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $tag );

						// By letting it fetch defaults, it will automatically recurse
						// up the tree of parent pages... fetching the ACL on the root
						// page if necessary.
						$acl = $this->LoadAcl( $parent, $privilege, 1 );
					}

					if (!$acl)
					{
						$acl = array(
							"supertag" => $supertag,
							"page_tag" => $tag,
							"privilege" => $privilege,
							"list" => $this->config["default_".$privilege."_acl"],
							"time" => date("YmdHis"),
							"default" => 1
						);
					}
				}

				$this->CacheACL($supertag, $privilege, $useDefaults, $acl);
			}
		}
		return $acl;
	}

	// returns true if $user (defaults to the current user) has access to $privilege on $page_tag (defaults to the current page)
	function HasAccess($privilege, $tag = "", $user = "")
	{
		$registered = false;
		// see whether user is registered and logged in
		if ($user != "guest@wacko")
		{
			if ($user = $this->GetUser()) $registered = true;
				$user = strtolower($this->GetUserName());
			if (!$registered)
				$user = "guest@wacko";
		}

		if (!$tag = trim($tag)) $tag = $this->GetPageTag();

		// load acl
		$acl = $this->LoadAcl($tag, $privilege);
		$this->_acl = $acl;

		// if current user is owner, return true. owner can do anything!
		if ($user != "guest@wacko")
			if ($this->UserIsOwner($tag))
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

		if ($user == "guest@wacko" || $user == "")
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
			if ($user == "guest@wacko" || $user == "") return false;
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

	// XML
	function WriteFile($name, $body)
	{
		$filename = "xml/".$name."_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"])).".xml";

		$fp = fopen($filename, "w");
		if ($fp)
		{
			fwrite($fp, $body);
			fclose($fp);
		}

		@chmod($filename, 0644);
	}

	function WriteRecentChangesXML()
	{
		$name = "recentchanges";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->config["wacko_name"].$this->GetTranslation("RecentChangesTitleXML")."</title>\n";
		$xml .= "<link>".$this->config["base_url"]."</link>\n";
		$xml .= "<description>".$this->GetTranslation("RecentChangesXML").$this->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->config["wacko_name"].$this->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->config["base_url"]."</link>\n";
		$xml .= "<url>".$this->config["base_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>en-us</language>\n";
		$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

		if ($pages = $this->LoadRecentlyChanged())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->config["hide_locked"]) $access =$this->HasAccess("read",$page["tag"],"guest@wacko");
				if ($access && ($count < 30))
				{
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["tag"]."</title>\n";
					$xml .= "<link>".$this->href("show", $page["tag"], "time=".urlencode($page["time"]))."</link>\n";
					$xml .= "<guid>".$this->href("show", $page["tag"], "time=".urlencode($page["time"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['time']))."</pubDate>\n";
					$xml .= "<description>".$page["time"]." ".$this->GetTranslation("By")." ".$page["user"].($page["edit_note"] ? " [".$page["edit_note"]."]" : "")."</description>\n";
					$xml .= "</item>\n";
				}
			}
		}

		$xml .= "</channel>\n";
		$xml .= "</rss>\n";

		$this->WriteFile($name, $xml);
	}

	function WriteRecentCommentsXML()
	{
		$name = "recentcomment";

		$xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
		$xml .= "<?xml-stylesheet type=\"text/css\" href=\"".$this->config["theme_url"]."css/wacko.css\" media=\"screen\"?>\n";
		$xml .= "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		$xml .= "<channel>\n";
		$xml .= "<title>".$this->config["wacko_name"].$this->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->config["base_url"]."</link>\n";
		$xml .= "<description>".$this->GetTranslation("RecentCommentsXML").$this->config["wacko_name"]." </description>\n";
		$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
		$xml .= "<image>\n";
		$xml .= "<title>".$this->config["wacko_name"].$this->GetTranslation("RecentCommentsTitleXML")."</title>\n";
		$xml .= "<link>".$this->config["base_url"]."</link>\n";
		$xml .= "<url>".$this->config["base_url"]."files/wacko4.gif"."</url>\n";
		$xml .= "<width>108</width>\n";
		$xml .= "<height>50</height>\n";
		$xml .= "</image>\n";
		$xml .= "<language>en-us</language>\n";
		$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
		$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

		if ( $pages = $this->LoadRecentlyComment() ) {
			foreach ($pages as $i => $page) {
				if ($this->config["hide_locked"]) $access =$this->HasAccess("read",$page["tag"],"guest@wacko");
				if ( $access && ($count < 30) ) {
					$count++;
					$xml .= "<item>\n";
					$xml .= "<title>".$page["tag"]." ".$this->GetTranslation("To")." ".$page["comment_on_id"]." ".$this->GetTranslation("From")." ".$page["user"]."</title>\n";
					$xml .= "<link>".$this->href("show", $page["tag"], "time=".urlencode($page["time"]))."</link>\n";
					$xml .= "<guid>".$this->href("show", $page["tag"], "time=".urlencode($page["time"]))."</guid>\n";
					$xml .= "<pubDate>".date('r', strtotime($page['time']))."</pubDate>\n";
					$xml .= "<dc:creator>".$page["user"]."</dc:creator>\n";
					$text = $this->Format($page["body_r"], "post_wacko");
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

	function WriteSiteMapXML()
	{
		$xml = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
		$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		if ($pages = $this->LoadAllPagesByTime())
		{
			foreach ($pages as $i => $page)
			{
				if ($this->config["hide_locked"] ? $this->HasAccess("read",$page["tag"],"guest@wacko") : true)
				{
					$xml .= "<url>\n";
					$xml .= "<loc>".$this->href("", $page["tag"])."</loc>\n";
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

	// WATCHES
	function IsWatched($user_id, $page_id)
	{
		return $this->LoadSingle(
			"SELECT * FROM ".$this->config["table_prefix"]."pagewatches ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND page_id = '".quote($this->dblink, $page_id)."'");
	}

	function SetWatch($user_id, $page_id)
	{
		// Remove old watch first to avoid double watches
		$this->ClearWatch($user_id, $page_id);

		if ($this->HasAccess('read', $tag))
			return $this->Query(
				"INSERT INTO ".$this->config["table_prefix"]."pagewatches (user_id, page_id) ".
				"VALUES ( '".quote($this->dblink, $user_id)."', '".quote($this->dblink, $page_id)."')" );
				// TIMESTAMP type is filled automatically by MySQL
		else
			return false;
	}

	function ClearWatch($user_id, $page_id)
	{
		return $this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."pagewatches ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."' ".
				"AND page_id = '".quote($this->dblink, $page_id)."'");
	}

	// BOOKMARKS
	function GetDefaultBookmarks($lang, $what = "default")
	{
		$this->UserAgentLanguage();

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
		if ($set || !($bookmarks=$this->GetBookmarks()))
		{
			$bookmarks = $user["bookmarks"]
				? $user["bookmarks"]
				: $this->GetDefaultBookmarks($user["lang"]);

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

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"] = $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"] = $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
		}

		// adding new bookmark
		if (!empty($_REQUEST["addbookmark"]) && $user)
		{
			// writing bookmark
			$bookmark = "((".$this->GetPageTag().($user["lang"] != $this->pagelang ? " @@".$this->pagelang : "")."))";

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

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"] = $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"] = $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
		}

		// removing bookmark
		if (!empty($_REQUEST["removebookmark"]) && $user)
		{
			foreach ($bookmarks as $bm)
			{
				$dummy = $this->Format($bm, "wacko");
				$this->ClearLinkTable();
				$this->StartLinkTracking();
				$dummy = $this->Format($dummy, "post_wacko");
				$this->StopLinkTracking();
				$bml = $this->GetLinkTable();
				if ($this->GetPageSuperTag()!=$this->NpjTranslit($bml[0])) $newbm[] = $bm;
			}
			$bookmarks = $newbm;
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

			$_SESSION[$this->config["session_prefix"].'_'."bookmarks"] = $bookmarks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"] = $bmlinks;
			$_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
		}
	}

	function GetBookmarks()
	{
		return $_SESSION[$this->config["session_prefix"].'_'."bookmarks"];
	}

	function GetBookmarksFormatted()
	{
		return $_SESSION[$this->config["session_prefix"].'_'."bookmarksfmt"];
	}

	function GetBookmarkLinks()
	{
		return $_SESSION[$this->config["session_prefix"].'_'."bookmarklinks"];
	}

	// MAINTENANCE
	function Maintenance()
	{
		// purge referrers (once a day)
		if ($days = $this->config["referrers_purge_time"])
		{
			$this->Query(
				"DELETE FROM ".$this->config["table_prefix"]."referrers ".
				"WHERE time < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");
		}

		// purge old page revisions
		if ($days = $this->config["pages_purge_time"])
		{
			$this->Query(
				"DELETE FROM ".$this->config["table_prefix"]."revisions ".
				"WHERE time < DATE_SUB(NOW(), INTERVAL '".quote($this->dblink, $days)."' DAY)");
		}

		// remove outdated pages cache
/*		if (time() > ($this->config['maint_last_cache'] + 3600))
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

			$this->Query("UPDATE {$this->config['table_prefix']}config SET maint_last_cache = '".time()."'");
		}
		*/
	}

	// MAIN EXECUTION ROUTINE
	function Run($tag, $method = "")
	{
		// autotasks
		if (!($this->GetMicroTime() % 3)) $this->Maintenance();

		$this->ReadInterWikiConfig();

		// do our stuff!
		if ((!$this->GetUser() && isset( $_COOKIE[$this->config["cookie_prefix"]."name"] )) && ($user = $this->LoadUser($_COOKIE[$this->config["cookie_prefix"]."name"], $_COOKIE[$this->config["cookie_prefix"]."password"]))) $this->SetUser($user);
		$user = $this->GetUser();

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

		if($this->config["debug"] >= 2)
		{
			if (($this->config["debug_admin_only"] == true && $this->IsAdmin() === true) || $this->config["debug_admin_only"] == false)
			{
				$lang_debug = '<span class="debug">Multilanguage: '.$this->config["multilanguage"].'<br/>';
				$lang_debug .= 'HTTP_ACCEPT_LANGUAGE set: '.isset($_SERVER['HTTP_ACCEPT_LANGUAGE']).'<br />';
				$lang_debug .= 'HTTP_ACCEPT_LANGUAGE value: '.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'<br />';
				$lang_debug .= 'HTTP_ACCEPT_LANGUAGE chopped value: '.strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)).'<br />';
				$lang_debug .= 'User language set: '.isset($user["lang"]).'<br />';
				$lang_debug .= 'User language: '.$user["lang"].'<br />';
				$lang_debug .= 'Config language: '.$this->config["language"].'<br />';
				$lang_debug .= 'Current language: '.$this->userlang.'<br />';
				$lang_debug .= '</span>';
				echo $lang_debug;
			}
		}

		if (is_array($user) && $user["options"]["theme"])
		{
			$this->config["theme"] = $user["options"]["theme"];
			$this->config["theme_url"]=$this->config["base_url"]."themes/".$this->config["theme"]."/";
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

		$wacko = &$this;

		if (!$this->method = trim($method)) $this->method = "show";

		if (!$this->tag = trim($tag)) $this->Redirect($this->href("", $this->config["root_page"]));

		// normalizing tag name
		if (!preg_match("/^[".$this->language["ALPHANUM_P"]."\!]+$/", $tag))
			$tag = $this->tryUtfDecode($tag);

		$tag = str_replace("'", "_", str_replace("\\", "", str_replace("_", "", $tag)));
		$tag = preg_replace("/[^".$this->language["ALPHANUM_P"]."\_\-\.]/", "", $tag);

		//$this->tag=$this->Translit($tag, 1);
		$this->tag = $tag;
		$this->supertag = $this->NpjTranslit($tag);

		$time = isset($_GET["time"]) ? $_GET["time"] : "";

		$page = $this->LoadPage($this->tag, $time);

		if ($this->config["outlook_workaround"] && !$page)
		{
			$page = $this->LoadPage($this->supertag."'", $time);
		}

		$this->SetPage($page);
		$this->LogReferrer();
		$this->SetBookmarks();

		if (!$this->GetUser() && $this->page["time"])
		{
			header("Last-Modified: ".gmdate("D, d M Y H:i:s", strtotime($this->page["time"])+120)." GMT");;
		}

		// display page contents
		if (preg_match("/(\.xml)$/", $this->method))
		{
			print($this->Method($this->method));
		}
		else if (preg_match("/print$/", $this->method))
		{
			print($this->Header("print").$this->Method($this->method).$this->Footer("print"));
		}
		else if (preg_match("/msword$/", $this->method))
		{
			print($this->Header("msword").$this->Method($this->method).$this->Footer("print"));
		}
		else
		{
			$this->CacheLinks();
			$this->current_context++;
			$this->context[$this->current_context] = $this->tag;
			$data .= $this->Method($this->method);
			$this->current_context--;
			print($this->Header().$data.$this->Footer());
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
			$_link = ($this->page["tag"] != $page["tag"])?$this->Href("",$page["tag"]):"";
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
	function GetPagePath($separator='/')
	{
		$steps = explode('/', $this->tag);
		$result = '';

		for ($i = 0; $i < count($steps); $i++)
		{
			$link = '';
			for($j = 0; $j < $i + 1; $j++)
			$link .= '/'.$steps[$j];

			# camel case'ing
			$linktext = preg_replace('([A-Z][a-z])', ' ${0}', $steps[$i]);

			if ($i == count($steps) - 1)
			$result .= $linktext;
			else
				$result .= $this->Link($link, '', $linktext) . $separator;
		}
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
					? "id	= '".quote($this->dblink, (int)$id)."' "
					: "tag	= '".quote($this->dblink, $tag)."' " ).
				"LIMIT 1");

			if ($page['title'] == true)
				return $page['title'];
			else
				return $this->AddSpaces(trim(substr($tag, strrpos($tag, '/')), '/'));
		}
		else if ($tag == false && $this->page == true)
		{
			return $this->page['title'];
		}
		else if ($tag == false && $this->page == false)
		{
			return $this->AddSpaces(trim(substr($this->tag, strrpos($this->tag, '/')), '/'));
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

	function RenameAcls($tag, $NewTag, $NewSuperTag = "")
	{
		if (!$tag || !$NewTag) return false;

		if ($NewSuperTag == "")
			$NewSuperTag = $this->NpjTranslit($NewTag);

		return $this->Query(
			"UPDATE ".$this->config["table_prefix"]."acls SET ".
				"page_tag = '".quote($this->dblink, $NewTag)."', ".
				"supertag = '".quote($this->dblink, $NewSuperTag)."' ".
			"WHERE page_tag = '".quote($this->dblink, $tag)."' ");
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
			"DELETE FROM ".$this->config["table_prefix"]."acls ".
			"WHERE page_tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemovePage($tag)
	{
		if (!$tag) return false;

		// delete page
		return $this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."revisions ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ") &&
			$this->Query(
				"DELETE FROM ".$this->config["table_prefix"]."pages ".
				"WHERE tag = '".quote($this->dblink, $tag)."' ");
	}

	function RemoveRevisions($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE FROM {$this->config['table_prefix']}revisions ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveComments($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE a.* FROM ".$this->config["table_prefix"]."pages a ".
				"INNER JOIN ".$this->config["table_prefix"]."pages b ON (a.comment_on_id = b.id) ".
			"WHERE b.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveWatches($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE FROM ".$this->config["table_prefix"]."pagewatches ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
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
			"DELETE FROM {$this->config['table_prefix']}keywords_pages ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		return true;
	}

	function RemoveReferrers($tag, $cluster = false)
	{
		if (!$tag) return false;

		return $this->Query(
			"DELETE ".
				$this->config["table_prefix"]."referrers ".
		 	"FROM ".
				$this->config["table_prefix"]."referrers ".
				"INNER JOIN ".$this->config["table_prefix"]."pages ON (".$this->config["table_prefix"]."referrers.page_id = ".$this->config["table_prefix"]."pages.id)".
			"WHERE "
				.$this->config["table_prefix"]."pages.tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");
	}

	function RemoveFiles($tag, $cluster = false)
	{
		if (!$tag) return false;

		$pages = $this->LoadAll(
			"SELECT id, supertag ".
			"FROM {$this->config['table_prefix']}pages ".
			"WHERE tag ".($cluster === true ? "LIKE" : "=")." '".quote($this->dblink, $tag.($cluster === true ? "/%" : ""))."' ");

		foreach ($pages as $page)
		{
			// get filenames
			$files = $this->LoadAll(
				"SELECT filename ".
				"FROM {$this->config['table_prefix']}upload ".
				"WHERE page_id = '".quote($this->dblink, $page['id'])."'");

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
				"WHERE page_id = '".quote($this->dblink, $page['id'])."'");
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
		$page	= (	$_GET[$name] == true ?			// if page param = 'last' magic word,
					(								// then open last page of the list
						$_GET[$name] == 'last' ?
						(
							$pages > 0 ? $pages : 1
						)
						: (int)$_GET[$name]
					)
					: 1 );

		$pagination['offset'] = $perpage * ($page - 1);

		// display navigation if there are pages to navigate in
		if ($pages > 1)
		{
			$pagination['text'] = $this->GetTranslation('ToThePage').': ';

			// pages range links
			if ($pages <= 10)	// not so many pages
			{
				for ($p=1; $p<=$pages; $p++)
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
					for ($p=1; $p<=5; $p++)
					{
						if ($p != $page)
							$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.$p).( $params == true ? '&amp;'.$params : '' ).'">'.$p.'</a>'.( $p != $pages ? $sep : '' );
						else	// don't make link for the current page
							$pagination['text'] .= ' <strong>'.$p.'</strong>'.( $p != $pages ? $sep : '' );
					}

					// middle skipped
					$pagination['text'] .= ' ... ,';

					// last pages
					for ($p=($pages-4); $p<=$pages; $p++)
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
					for ($p=($page-2); $p<=($page+2); $p++)
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
				$pagination['text'] .= ' '.$this->GetTranslation('NextAcr');
			}
			else
			{
				$pagination['text'] .= ' <a href="'.$this->href($method, $tag, $name.'='.($page + 1).( $params == true ? '&amp;'.$params : '' )).'">'.$this->GetTranslation('NextAcr').'</a>';
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
		$user = $this->GetUserName();
		$this->config['allow_rawhtml'] = $html;

		// current timestamp set automatically
		return $this->Query(
			"INSERT INTO {$this->config['table_prefix']}log SET ".
				"level		= '".quote($this->dblink, $level)."', ".
				"user		= '".quote($this->dblink, $user ? $user : GUEST )."', ".
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
		"SELECT id, parent, name ".
		"FROM {$this->config['table_prefix']}keywords ".
		"WHERE lang = '".quote($this->dblink, $lang)."' ".
		"ORDER BY parent ASC, name ASC", $cache))
		{
			// process pages count (if have to)
			if ($root !== false)
			{
				if ($_counts = $this->LoadAll(
				"SELECT keyword, COUNT( tag ) AS n ".
				"FROM {$this->config['table_prefix']}keywords, ".
					"{$this->config['table_prefix']}keywords_pages ".
				"WHERE lang = '".quote($this->dblink, $lang)."' AND keyword_id = id ".
					( $root != '' ? "AND ( tag = '".quote($this->dblink, $root)."' OR tag LIKE '".quote($this->dblink, $root)."/%' ) " : '' ).
				"GROUP BY keyword", 1))
				{
					foreach ($_counts as $count) $counts[$count['keyword']] = $count['n'];
				}
			}

			// process categories names
			foreach ($_keywords as $word)
			{
				$keywords[$word['id']] = array(
					'parent'	=> $word['parent'],
					'name'		=> $word['name'],
					'n'			=> $counts[$word['id']]
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
	function SaveKeywordsList($tag, $dryrun = 0)
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
				foreach ($set as $id) $values[] = "(".quote($this->dblink, (int)$id).", '".quote($this->dblink, $this->page["id"])."')";

				$this->Query(
					"INSERT INTO {$this->config['table_prefix']}keywords_pages (keyword_id, page_id) ".
					"VALUES ".implode(', ', $values));
				$this->Query(
					"UPDATE {$this->config['table_prefix']}pages ".
					"SET keywords = '".quote($this->dblink, implode(' ', $set))."' ".
					"WHERE id = '".quote($this->dblink, $this->page["id"])."' ");
			}
			return true;
		}
		else return false;
	}

}

?>