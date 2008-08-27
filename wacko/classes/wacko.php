<?php

// constants
define("TRAN_DONTCHANGE", "0");
define("TRAN_LOWERCASE", "1");
define("TRAN_LOAD", "0");
define("TRAN_DONTLOAD", "1");
define("LOAD_NOCACHE", "0");
define("LOAD_CACHE", "1");
define("LOAD_ALL", "0");
define("LOAD_META", "1");
define("BM_AUTO", "0");
define("BM_USER", "1");
define("BM_DEFAULT", "2");
define("ACTIONS4DIFF", "a, anchor, toc"); //allowed actions in DIFF

class Wacko
{
   var $dblink;
   var $page;
   var $tag;
   var $queryLog = array();
   var $interWiki = array();
   var $VERSION;
   var $WVERSION; //Wacko version
   var $context = array("");
   var $current_context = 0;
   var $pages_meta = "id, tag, time, owner, user, latest, handler, comment_on, super_comment_on, supertag, lang, keywords, description";
   var $first_inclusion = array(); // for backlinks
   // if you change this two symbols, settings for all users will be lost.
   var $optionSplitter = "\n";
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
   var $post_wacko_action = null;
   var $_userhost = null;

   // constructor
   function Wacko($config)
   {
      $this->timer = $this->GetMicroTime();
      $this->config = $config;
      $this->dblink = connect($this->config["database_host"], $this->config["database_user"], $this->config["database_password"], $this->config["database_database"], $this->config["db_collation"], $this->config["database_driver"], $this->config["database_port"]);
      $this->VERSION = WAKKA_VERSION;
      $this->WVERSION = WACKO_VERSION;
   }

   // DATABASE
   function Query($query, $debug=0)
   {
      if($this->GetConfigValue("debug")>=1) $start = $this->GetMicroTime();
      $result = query($this->dblink, $query);
      if($this->GetConfigValue("debug")>=1)
      {
         $time = $this->GetMicroTime() - $start;
         $this->queryLog[] = array(
       "query"   => $query,
       "time"    => $time);
      }
      return $result;
   }

   function LoadSingle($query) { if ($data = $this->LoadAll($query)) return $data[0]; }

   function LoadAll($query)
   {
      $data = array();
      if ($r = $this->Query($query))
      {
         while ($row = fetch_assoc($r)) $data[] = $row;
         free_result($r);
      }
      return $data;
   }

   // MISC
   function GetMicroTime() { list($usec, $sec) = explode(" ",microtime()); return ((float)$usec + (float)$sec); }

   function IncludeBuffered($filename, $notfoundText = "", $vars = "", $path = "")
   {
      if ($path) $dirs = explode(":", $path);
      else $dirs = array("");

      foreach($dirs as $dir)
      {
         if ($dir) $dir .= "/";
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
      if ($notfoundText) return $notfoundText;
      else return false;
   }

   // VARIABLES
   function GetPageTag() { return $this->tag; }
   function GetPageSuperTag() { return $this->supertag; }
   function GetPageTime() { return $this->page["time"]; }
   function GetPageLastWriter() { return $this->page["user"]; }
   function GetMethod() { return $this->method; }
   function GetConfigValue($name) { return isset( $this->config[$name] ) ? $this->config[$name] : ''; }
   function SetResource($lang) {$this->resource=&$this->resources[$lang];}

   function SetLanguage($lang)
   {
      //   echo "<b>SetLanguage:</b> ".$lang."<br />";
      $this->LoadResource($lang);
      $this->language = &$this->languages[$lang];
      setlocale(LC_CTYPE,$this->language["locale"]);
      $this->language["locale"] = setlocale(LC_CTYPE,0);
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
         $resourcefile = "lang/wakka.".$lang.".php";
         if (@file_exists($resourcefile)) include($resourcefile);
         // wakka.all
         $resourcefile = "lang/wakka.all.php";
         if (!$this->resources["all"])
         {
            if (@file_exists($resourcefile)) include($resourcefile);
            $this->resources["all"] =& $wackoAllResource;
         }
         $wackoResource = array_merge($wakkaResource, $this->resources["all"]);
         // theme
         $resourcefile = "themes/".$this->config["theme"]."/lang/wakka.".$lang.".php";
         if (@file_exists($resourcefile)) include($resourcefile);
         $wackoResource = array_merge((array)$wackoResource, (array)$themeResource);
         // wakka.all theme
         $resourcefile = "themes/".$this->config["theme"]."/lang/wakka.all.php";
         if (@file_exists($resourcefile)) include($resourcefile);
         $wackoResource = array_merge((array)$wackoResource, (array)$themeResource);

         $this->resources[$lang] = $wackoResource;

         $this->LoadLang($lang);
      }
   }

   function LoadLang($lang)
   {
      if (!isset( $this->languages[$lang] ))
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
      if (!$this->GetConfigValue("multilanguage")) return;
      $langs = $this->AvailableLanguages();
      foreach ($langs as $lang)
      $this->LoadLang($lang);
   }

   function AvailableLanguages()
   {
      if (!$this->_langlist)
      {
         $handle=opendir("lang");
         while (false!==($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "wakka.all.php" && !is_dir("lang/".$file) && 1==preg_match("/^wakka\.(.*?)\.php$/",$file,$match)) {
               $langlist[] = $match[1];
            }
         }
         closedir($handle);
         $this->_langlist = $langlist;
      }
      return $this->_langlist;
   }

   function GetResourceValue($name, $lang="", $dounicode=true)
   {
      if (!$this->GetConfigValue("multilanguage")) return $this->resource[$name];

      //echo "<b>GetResourceValue:</b> $lang + $name + $this->userlang + $this->pagelang<br />";

      if (!$lang && $this->userlang!=$this->pagelang) $lang = $this->userlang;
      if ($lang!="")
      {
         $this->LoadResource($lang);
         return (is_array($this->resources[$lang][$name]))?$this->resources[$lang][$name]:($dounicode?$this->DoUnicodeEntities($this->resources[$lang][$name], $lang):$this->resources[$lang][$name]);
      }
      return $this->resource[$name];
   }

   function FormatResourceValue($name, $lang="")
   {
      $string = $this->GetResourceValue($name, $lang, false);
      $this->format_safe = false;
      $string = $this->Format($string);
      $this->format_safe = true;
      return $string;
   }

   function DetermineLang()
   {
      $langlist = $this->AvailableLanguages();
      //!!!! wrong code, maybe!
      if ($this->GetMethod()=="edit" && $_GET["add"]==1)
      if ($_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
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
      if (!$this->GetConfigValue("multilanguage")) return $string;
      $_lang = $this->DetermineLang();
      if ($lang==$_lang) return $string;

      //    die("<h2>".$lang."<>".$_lang."</h2>");

      $this->LoadResource($lang);
      if (is_array($this->languages[$lang]["unicode_entities"]))
      {
         return @strtr($string, $this->languages[$lang]["unicode_entities"]);
      }
      else return $string;
   }

   function tryUtfDecode ($string)
   {
      $t1 = $this->utf8ToUnicodeEntities($string);
      $t2 = @strtr($t1, $this->unicode_entities);
      //echo "<pre><h1>".$string."|".$t1."|".$t2."</h1></pre>";
      if (!preg_match("/\&\#[0-9]+\;/", $t2))
      $string = $t2;
      return $string;
   }

   function utf8ToUnicodeEntities ($source)
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
         {// 4 chars representing one unicode character
            $thisLetter = substr ($source, $pos, 4);
            $pos += 4;
         }
         else if (($asciiPos >= 224) && ($asciiPos <= 239))
         {// 3 chars representing one unicode character
            $thisLetter = substr ($source, $pos, 3);
            $pos += 3;
         }
         else if (($asciiPos >= 192) && ($asciiPos <= 223))
         {// 2 chars representing one unicode character
            $thisLetter = substr ($source, $pos, 2);
            $pos += 2;
         }
         else
         {// 1 char (lower ascii)
            $thisLetter = substr ($source, $pos, 1);
            $pos += 1;
         }

         // process the string representing the letter to a unicode entity
         $thisLen = strlen ($thisLetter);
         if ($thisLen>1)
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

   function GetWakkaName() { return $this->GetConfigValue("wakka_name"); }
   function GetWakkaVersion() { return $this->VERSION; }
   function GetWackoVersion() { return $this->WVERSION; }

   // PAGES
   // NpjTranslit
   var $NpjMacros = array( "âèêè" => "wiki", "âàêà" => "wacko", "âåá" => "web"
   );

   function NpjTranslit($tag, $strtolow = TRAN_LOWERCASE, $donotload=TRAN_LOAD)
   {
      $_lang = null;
      if (!$this->GetConfigValue("multilanguage")) $donotload = 1;
      if (!$donotload)
      if ($page = $this->LoadPage($tag, "", LOAD_CACHE, LOAD_META))
      {
         $_lang = $this->language["code"];
         if ($page["lang"]) $lang = $page["lang"];
         else $lang = $this->GetConfigValue("language");

         $this->SetLanguage($lang);
      }

      $tag = str_replace( "//", "/", $tag );
      $tag = str_replace( "-", "", $tag );
      $tag = str_replace( " ", "", $tag );
      $tag = str_replace( "'", "_", $tag );
      $_tag = strtolower( $tag );
      if ($strtolow) $tag = @strtr( $_tag, $this->NpjMacros );
      else
      foreach( $this->NpjMacros as $macro=>$value )
      while (($pos = strpos($_tag, $macro)) !== false)
      {
         $_tag = substr_replace( $_tag, $value, $pos, strlen($macro) );
         $tag = substr_replace( $tag, ucfirst($value), $pos, strlen($macro) );
      }

      $tag = @strtr( $tag, $this->language["NpjLettersFrom"], $this->language["NpjLettersTo"] );
      $tag = @strtr( $tag, $this->language["NpjBiLetters"] );
      if ($strtolow) $tag = strtolower( $tag );

      if ($_lang)
      $this->SetLanguage($_lang);
      return rtrim($tag, "/");
   }

   function Translit($tag, $direction=1) { //deprecated
      return $tag;
   }

   function LoadPage($tag, $time = "", $cache = LOAD_CACHE, $metadataonly = LOAD_ALL)
   {
      $supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);

      if ($this->GetCachedWantedPage($supertag)==1) return "";

      $page = $this->OldLoadPage($supertag,$time,$cache, true, $metadataonly);     // 1. search for supertag
      if (!$page)                                      // 2. if not found, search for tag
      //    {
      $page = $this->OldLoadPage($tag,$time,$cache, false, $metadataonly);
      /*      if ($page)                                     // 3. if found, update supertag
       {
       $this->Query( "update ".$this->config["table_prefix"]."pages ".
       "set supertag='".$supertag."' where tag = '".$tag."';" );
       }
       }
       */
      if (!$page) $this->CacheWantedPage($supertag);
      return $page;
   }

   function OldLoadPage($tag, $time = "", $cache = 1, $supertagged = false, $metadataonly = 0)
   {
      $page = null;
      if (!$supertagged) $supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);
      else $supertag=$tag;
      // retrieve from cache
      if (!$time && $cache && ($cachedPage = $this->GetCachedPage($supertag, $metadataonly))) $page = $cachedPage;
      // load page
      if ($metadataonly) $what = $this->pages_meta;
      else $what = "*";
      if (!$page)
      {
         if ($supertagged) {
            $page = $this->LoadSingle("SELECT ".$what." FROM ".$this->config["table_prefix"]."pages WHERE supertag='".quote($this->dblink, $tag)."' AND latest = 'Y' LIMIT 1");
            if ($time && $time!=$page["time"]) {
               $this->CachePage($page, $metadataonly);
               $page = $this->LoadSingle("SELECT ".$what." FROM ".$this->config["table_prefix"]."revisions WHERE supertag='".quote($this->dblink, $tag)."' AND time = '".quote($this->dblink, $time)."' limit 1");
            }
         }
         else {
            $page = $this->LoadSingle("SELECT ".$what." FROM ".$this->config["table_prefix"]."pages WHERE tag='".quote($this->dblink, $tag)."' AND latest = 'Y' LIMIT 1");
            if ($time && $time!=$page["time"]) {
               $this->CachePage($page, $metadataonly);
               $page = $this->LoadSingle("SELECT ".$what." FROM ".$this->config["table_prefix"]."revisions WHERE tag='".quote($this->dblink, $tag)."' AND time = '".quote($this->dblink, $time)."' LIMIT 1");
            }
         }
      }// cache result
      if (!$time && !$cachedPage) $this->CachePage($page, $metadataonly);
      return $page;
   }

   function GetCachedPage($tag, $metadataonly=0) {
      if (isset( $this->pageCache[$tag] ))
      if ($this->pageCache[$tag]["mdonly"]==0 || $metadataonly==$this->pageCache[$tag]["mdonly"])
      return $this->pageCache[$tag];
      return false;
   }

   function CachePage($page, $metadataonly=0) {
      $page["supertag"] = $this->NpjTranslit($page["supertag"], TRAN_LOWERCASE, TRAN_DONTLOAD);
      $this->pageCache[$page["supertag"]] = $page;
      $this->pageCache[$page["supertag"]]["mdonly"] = $metadataonly;
   }

   function CacheWantedPage($tag, $check = 0) {
      if ($check==0)
      $this->wantedCache[$this->language["code"]][$tag] = 1;
      else if ($this->OldLoadPage($tag, "", 1, false, 1)=="")
      $this->wantedCache[$this->language["code"]][$tag] = 1;
   }

   function ClearCacheWantedPage($tag){
      $this->wantedCache[$this->language["code"]][$tag] = 0;
   }

   function GetCachedWantedPage($tag)
   {
      if (isset( $this->wantedCache[$this->language["code"]][$tag] ))
      return $this->wantedCache[$this->language["code"]][$tag];
      else
      return '';
   }

   function GetCachedACL($tag, $privilege, $useDefaults)
   {
      if (isset( $this->aclCache[$tag."#".$privilege."#".$useDefaults] ))
      return $this->aclCache[$tag."#".$privilege."#".$useDefaults];
      else
      return '';
   }
   function CacheACL($tag, $privilege, $useDefaults, $acl) { $this->aclCache[$tag."#".$privilege."#".$useDefaults] = $acl; }

   function CacheLinks()
   {
      if ($links = $this->LoadAll("SELECT * FROM ".$this->config["table_prefix"]."links WHERE from_tag='".quote($this->dblink, $this->GetPageTag())."'"))
      {
         $cl = count($links);
         for ($i=0; $i<$cl; $i++)
         $pages[$i] = $links[$i]["to_tag"];
      }

      $user = $this->GetUser();
      $pages[$cl] = $user["name"];


      $bookm = $this->GetDefaultBookmarks($user["lang"], "site")."\n".($user["bookmarks"] ? $user["bookmarks"] : $this->GetDefaultBookmarks($user["lang"]));
      $bookmarks = explode("\n", $bookm);
      for ($i=0; $i<=count($bookmarks); $i++)
      $pages[$cl+$i] = preg_replace("/^(.*?)\s.*$/","\\1",preg_replace("/[\[\]\(\)]/","",$bookmarks[$i]));

      $pages[]=$this->GetPageTag();

      $spages_str = ''; $pages_str = '';
      for ($i=0; $i<count($pages); $i++)
      {
         $spages[$i] = $this->NpjTranslit($pages[$i], TRAN_LOWERCASE, TRAN_DONTLOAD);
         $spages_str .= "'".quote($this->dblink, $spages[$i])."', ";
         $pages_str .= "'".quote($this->dblink, $pages[$i])."', ";
      }

      $spages_str=substr($spages_str,0,strlen($spages_str)-2);
      $pages_str=substr($pages_str,0,strlen($pages_str)-2);

      if ($links = $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE supertag IN (".$spages_str.")"))
      for ($i=0; $i<count($links); $i++)
      {
         $this->CachePage($links[$i], 1);
         $exists[] = $links[$i]["supertag"];
      }
      $notexists = @array_values(@array_diff($spages, $exists));
      for ($i=0; $i<count($notexists); $i++)
      {
         $this->CacheWantedPage($pages[array_search($notexists[$i],$spages)], 1);
         $this->CacheACL($notexists[$i], "read", 1, $acl);
      }

      //   unset($exists);
      if ($read_acls = $this->LoadAll("SELECT * FROM ".$this->config["table_prefix"]."acls WHERE BINARY page_tag IN (".$pages_str.") AND privilege = 'read'"))
      for ($i=0; $i<count($read_acls); $i++)
      {
         $this->CacheACL($read_acls[$i]["supertag"], "read", 1, $read_acls[$i]);
         //       $exists[] = $read_acls[$i]["tag"];
      }
      /*
       $notexists = @array_values(@array_diff($pages, $exists));
       for ($i=0; $i<count($notexists); $i++)
       {
       $acl = array("supertag" => $notexists[$i], "page_tag" => $notexists[$i], "privilege" => "read", "list" => "*", "time" => date("YmdHis"));
       $this->CacheACL($notexists[$i], "read", 1, $acl);
       }
       */
      $ddd = $this->GetMicroTime();
      $this->queryLog[] = array(
    "query"   => "<b>end caching links</b>",
    "time"    => $this->GetResourceValue("MeasuredTime").": ".(number_format(($ddd-$this->timer),3))." s");
   }

   function SetPage($page)
   {
      $langlist = $this->AvailableLanguages();
      $this->page = $page;
      if ($this->page["tag"]) $this->tag = $this->page["tag"];
      if ($page["lang"])
      $this->pagelang = $page["lang"];
      else if ($_REQUEST["add"] && $_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
      $this->pagelang = $_REQUEST["lang"];
      else if ($_REQUEST["add"])
      $this->pagelang = $this->userlang;
      else
      $this->pagelang = $this->GetConfigValue("language");
   }

   function LoadPageById($id)
   {
      if ($id!="-1")
      return $this->LoadSingle("SELECT * FROM ".$this->config["table_prefix"]."revisions WHERE id = '".quote($this->dblink, $id)."' LIMIT 1");
      else
      return $this->LoadSingle("SELECT * FROM ".$this->config["table_prefix"]."pages WHERE tag='".quote($this->dblink, $this->GetPageTag())."' AND latest='Y' LIMIT 1");
   }

   function LoadRevisions($page)
   {
      $rev = $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."revisions WHERE tag='".quote($this->dblink, $page)."' ORDER BY time DESC");
      if (is_array($rev)) array_unshift($rev, $this->LoadSingle("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE tag='".quote($this->dblink, $page)."' ORDER BY time DESC  LIMIT 1"));
      else $rev[] = $this->LoadSingle("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE tag='".quote($this->dblink, $page)."' ORDER BY time DESC  LIMIT 1");
      return $rev;
   }

   function LoadPagesLinkingTo($tag, $for="")
   {
      return $this->LoadAll("SELECT from_tag AS tag FROM ".$this->config["table_prefix"]."links WHERE ".
      ($for?"from_tag LIKE '".quote($this->dblink, $for)."/%' AND ":"").
   "((to_supertag='' AND to_tag='".quote($this->dblink, $tag)."') OR to_supertag='".quote($this->dblink, $this->NpJTranslit($tag))."')".
   " ORDER BY tag");
   }

   function LoadRecentlyChanged($limit=70, $for="", $from="")
   {
      $limit= (int) $limit;
      if ($pages =
      $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages ".
       "WHERE latest = 'Y' AND comment_on = '' ".($from?"AND time<='".quote($this->dblink, $from)." 23:59:59'":"").
      ($for?"AND supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' ":"").
       "ORDER BY time DESC  LIMIT ".$limit))
      {
         foreach ($pages as $page)
         {
            $this->CachePage($page, 1);
         }

         if ($read_acls = $this->LoadAll("SELECT a.* "
         ."FROM ".$this->config["table_prefix"]."acls a, ".$this->config["table_prefix"]."pages p "
         ."WHERE p.latest = 'Y' "
         ."AND p.comment_on = '' "
         ."AND a.supertag = p.supertag "
         .($for?"AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' ":"")
         ."AND privilege = 'read' "
         ."ORDER BY time DESC LIMIT ".$limit))
         for ($i=0; $i<count($read_acls); $i++) {
            $this->CacheACL($read_acls[$i]["supertag"], "read", 1,$read_acls[$i]);
         }

         return $pages;
      }
   }

   function LoadRecentlyComment($limit=70, $for="", $from="") {
      $limit= (int) $limit;
      if ($pages =
      $this->LoadAll("SELECT ".$this->pages_meta.",`body_r` FROM ".$this->config["table_prefix"]."pages ".
       "WHERE latest = 'Y' AND comment_on != '' ".($from?"AND time<='".quote($this->dblink, $from)." 23:59:59'":"").
      ($for?"AND supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' ":"").
       "ORDER BY time DESC  LIMIT ".$limit))
      {
         foreach ($pages as $page)
         {
            $this->CachePage($page, 1);
         }

         if ($read_acls = $this->LoadAll("SELECT a.* "
         ."FROM ".$this->config["table_prefix"]."acls a, ".$this->config["table_prefix"]."pages p "
         ."WHERE p.latest = 'Y' "
         ."AND p.comment_on = '' "
         ."AND a.supertag = p.supertag "
         .($for?"AND p.supertag LIKE '".quote($this->dblink, $this->NpjTranslit($for))."/%' ":"")
         ."AND privilege = 'read' "
         ."ORDER BY time DESC LIMIT ".$limit))
         for ($i=0; $i<count($read_acls); $i++) {
            $this->CacheACL($read_acls[$i]["supertag"], "read", 1,$read_acls[$i]);
         }

         return $pages;
      }
   }

   function LoadWantedPages($for="")
   {
      $pref = $this->config["table_prefix"];
      $sql = "SELECT DISTINCT ".$pref."links.to_tag AS tag,count(".$pref."links.from_tag) AS count ".
    "FROM ".$pref."links LEFT JOIN ".$pref."pages ON ".
    "((".$pref."links.to_tag = ".$pref."pages.tag AND ".$pref."links.to_supertag='') ".
    " OR ".$pref."links.to_supertag=".$pref."pages.supertag) ".
    "WHERE ".($for?$pref."links.to_tag LIKE '".quote($this->dblink, $for)."/%' AND ":"").
      $pref."pages.tag is NULL GROUP BY tag ORDER BY count DESC, tag asc LIMIT 200";
      return $this->LoadAll($sql);
   }

   function LoadOrphanedPages($for="")
   {
      $pref = $this->config["table_prefix"];
      $sql = "SELECT DISTINCT tag FROM ".$pref."pages LEFT JOIN ".$pref."links ON ".
      //     $pref."pages.tag = ".$pref."links.to_tag where ".
    "((".$pref."links.to_tag = ".$pref."pages.tag AND ".$pref."links.to_supertag='') ".
    " OR ".$pref."links.to_supertag=".$pref."pages.supertag) WHERE ".
      ($for?$pref."pages.tag LIKE '".quote($this->dblink, $for)."/%' AND ":"").
      $pref."links.to_tag is NULL AND ".$pref."pages.comment_on = '' ".
    "ORDER BY tag LIMIT 200";
      return $this->LoadAll($sql);
   }

   function LoadPageTitles() { return $this->LoadAll("SELECT DISTINCT tag FROM ".$this->config["table_prefix"]."pages ORDER BY tag"); }
   function LoadAllPages() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE latest = 'Y' AND comment_on = '' ORDER BY BINARY tag"); }
   function LoadAllPagesByTime() { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE latest = 'Y' AND comment_on = '' ORDER BY time DESC, BINARY tag"); }

   function FullTextSearch($phrase,$filter)
   {
      return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"].
                        "pages WHERE latest = 'Y' AND (( match(body) against('".quote($this->dblink, $phrase)."') ".
                        "OR lower(tag) LIKE lower('%".quote($this->dblink, $phrase)."%')) ".($filter?"AND comment_on=''":"")." )");
   }

   function TagSearch($phrase) { return $this->LoadAll("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."pages WHERE latest = 'Y' AND lower(tag) LIKE binary lower('%".quote($this->dblink, $phrase)."%') ORDER BY supertag"); }

   function SendMail($email,$subject, $message) {
      $headers = "From: =?". $this->GetCharset() ."?B?". base64_encode($this->GetConfigValue("wakka_name")) ."?= <".$this->GetConfigValue("admin_email").">\r\n";
      $headers .= "X-Mailer: PHP/".phpversion()."\r\n"; //mailer
      $headers .= "X-Priority: 3\r\n"; //1 UrgentMessage, 3 Normal
      $headers .= "X-Wacko: ".$this->GetConfigValue("base_url")."\r\n";
      $headers .= "Content-Type: text/html; charset=".$this->GetCharset()."\r\n";
      $subject =  "=?".$this->GetCharset()."?B?" . base64_encode($subject) . "?=";
      @mail($email, $subject, "<html><head></head><body>".$message."</body></html>", $headers);
   }

   function SavePage($tag, $body, $comment_on = "")
   {
      // get current user
      $user = $this->GetUserName();

      /*
         ANTISPAM

         We load in the external antispam.conf file and then search the entire body content for each of the
         words defined as spam.  If we find any then we return from the function, not saving the changes.
      */
      $this->spam = file("antispam.conf", 1);

      if ($this->GetConfigValue("spam_filter") && is_array($this->spam))
      foreach ($this->spam as $spam)
      {
         if (strpos($body, trim($spam))!==false) return 'Error: Identified Potential Spam: '.$spam;
      }

      if($_POST["tag"])
      {
         $this->tag = $tag = $_POST["tag"];
         $this->supertag = $this->NpjTranslit($tag);
      }

      if (!$this->NpjTranslit($tag)) return;

      if ($this->GetConfigValue("cache"))
      if ($comment_on) $this->cache->CacheInvalidate($comment_on);
      else
      {
         $this->cache->CacheInvalidate($this->tag);
         $this->cache->CacheInvalidate($this->supertag);
      }

      if ($this->HasAccess("write", $tag) || ($comment_on && $this->HasAccess("comment", $comment_on)))
      {
         $body = $this->Format($body, "preformat");
         // is page new?
         if (!$oldPage = $this->LoadPage($tag))
         {
            $langlist = $this->AvailableLanguages();
            if ($_REQUEST["lang"] && in_array($_REQUEST["lang"], $langlist))
            $lang = $_REQUEST["lang"];
            else
            $lang = $this->userlang;

            if (!$lang) $lang = $this->GetConfigValue["language"];

            $this->SetLanguage($lang);

            $body_r = $this->Format($body, "wacko");
            if ($this->GetConfigValue("paragrafica") && !$comment_on)
            {
               $body_r = $this->Format($body_r, "paragrafica");
               $body_toc = $this->body_toc;
            }
            // create default write acl. store empty write ACL for comments.
            // get default acl for root.
            if (strstr($this->context[$this->current_context], "/") || $comment_on)
            {
               $root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context] );
               $write_acl = $this->LoadAcl($root, "write");
               while ($write_acl["default"]==1)
               {
                  $_root = $root;
                  $root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $root );
                  if ($root == $_root) break;
                  $write_acl = $this->LoadAcl($root, "write");
               }

               $write_acl = $comment_on == "" ? $write_acl["list"] : '';
               $read_acl = $this->LoadAcl($root, "read");
               $read_acl = $read_acl["list"];
               $comment_acl = $this->LoadAcl($root, "comment");
               $comment_acl = $comment_acl["list"];
            }
            else
            {
               $write_acl = $this->GetConfigValue("default_write_acl");
               $read_acl  = $this->GetConfigValue("default_read_acl");
               $comment_acl = $this->GetConfigValue("default_comment_acl");
            }

            // current user is owner; if user is logged in! otherwise, no owner.
            if ($this->GetUser()) $owner = $user;

            $this->Query("INSERT INTO ".$this->config["table_prefix"]."pages SET ".
            ($comment_on ? "comment_on = '".quote($this->dblink, $comment_on)."', " : "").
            ($comment_on ? "super_comment_on = '".quote($this->dblink, $this->NpjTranslit($comment_on))."', " : "").
         "time = now(), ".
         "owner = '".quote($this->dblink, $owner)."', ".
         "user = '".quote($this->dblink, $user)."', ".
         "latest = 'Y', ".
         "supertag = '".quote($this->dblink, $this->NpjTranslit($tag))."', ".
         "body = '".quote($this->dblink, $body)."', ".
         "body_r = '".quote($this->dblink, $body_r)."', ".
         "body_toc = '".quote($this->dblink, $body_toc)."', ".
         "lang = '".quote($this->dblink, $lang)."', ".
         "tag = '".quote($this->dblink, $tag)."'");

            $this->SaveAcl($tag, "write", ($comment_on ? "" : $write_acl));
            $this->SaveAcl($tag, "read", $read_acl);
            $this->SaveAcl($tag, "comment", ($comment_on ? "" : $comment_acl));

            if ($this->GetUser() && !$this->GetConfigValue("disable_autosubscribe"))
            $this->SetWatch($this->GetUserName(), $this->GetPageTag());

            if ($comment_on) {
               $username = $this->GetUserName();
               $Watchers = $this->LoadAll("SELECT DISTINCT user FROM ".$this->config["table_prefix"]."pagewatches WHERE tag = '".quote($this->dblink, $comment_on)."'");
               foreach ($Watchers as $Watcher)
               if ($Watcher["user"] !=  $username)
               {
                  $_user = $this->GetUser();
                  $Watcher["name"] = $Watcher["user"];
                  $this->SetUser($Watcher, 0);

                  if ($this->HasAccess("read", $comment_on, $Watcher["user"]))
                  {
                     $User = $this->LoadSingle("SELECT email, lang, more, email_confirm FROM " .$this->config["user_table"]." WHERE name = '".quote($this->dblink, $Watcher["user"])."'");
                     $User["options"] = $this->DecomposeOptions($User["more"]);
                     if ($User["email_confirm"]=="" && $User["options"]["send_watchmail"]!="N")
                     {
                        $lang = $User["lang"];
                        $subject = $this->GetResourceValue("CommentForWatchedPage",$lang)."'".$comment_on."'";
                        $message = $this->GetResourceValue("MailHello",$lang). $Watcher["user"].".<br /> <br /> ";
                        $message .=   $username.
                        $this->GetResourceValue("SomeoneCommented",$lang)."<br />  * <a href=\"".$this->Href("",$comment_on,"")."\">".$this->Href("",$comment_on,"")."</a><br />";
                        $message .= "<hr />".$this->Format($body_r, "post_wacko")."<hr />";
                        $message .= "<br />".$this->GetResourceValue("MailGoodbye",$lang)." ".$this->GetConfigValue("wakka_name");
                        $this->SendMail($User["email"], $subject, $message);
                     }
                  }
                  $this->SetUser($_user, 0);
               }
            }
         }
         else
         {
            $this->SetLanguage($this->pagelang);
            $body_r = $this->Format($body, "wacko");
            if ($this->GetConfigValue("paragrafica"))
            {
               $body_r = $this->Format($body_r, "paragrafica");
               $body_toc = $this->body_toc;
            }
            // aha! page isn't new. keep owner!
            $owner = $oldPage["owner"];
            if ($oldPage['body'] != $body)
            {
               // move revision
               $this->Query("INSERT INTO ".$this->config["table_prefix"]."revisions (tag, time, body, owner, user, latest, handler, comment_on, supertag, keywords, description) ".
            "SELECT tag, time, body, owner, user, 'N', handler, comment_on, supertag, keywords, description FROM ".$this->config["table_prefix"]."pages WHERE tag = '".quote($this->dblink, $tag)."' AND latest='Y' LIMIT 1");

               // add new revision
               $this->Query("UPDATE ".$this->config["table_prefix"]."pages SET ".
               ($comment_on ? "comment_on = '".quote($this->dblink, $comment_on)."', " : "").
               ($comment_on ? "super_comment_on = '".quote($this->dblink, $this->NpjTranslit($comment_on))."', " : "").
          "time = now(), ".
          "owner = '".quote($this->dblink, $owner)."', ".
          "user = '".quote($this->dblink, $user)."', ".
          "supertag = '".$this->NpjTranslit($tag)."', ".
          "body = '".quote($this->dblink, $body)."', ".
          "body_toc = '".quote($this->dblink, $body_toc)."', ".
          "body_r = '".quote($this->dblink, $body_r)."' ".
          "WHERE tag = '".quote($this->dblink, $tag)."' AND latest='Y' LIMIT 1");
            }

            $username = $this->GetUserName();
            $Watchers = $this->LoadAll("SELECT DISTINCT user FROM ".$this->config["table_prefix"]."pagewatches WHERE tag = '".quote($this->dblink, $tag)."'");
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
                     $User = $this->LoadSingle("SELECT email, lang, more, email_confirm FROM " .$this->config["user_table"]." WHERE name = '".quote($this->dblink, $Watcher["user"])."'");
                     $User["options"] = $this->DecomposeOptions($User["more"]);
                     if ($User["email_confirm"]=="" && $User["options"]["send_watchmail"]!="N")
                     {
                        $lang = $User["lang"];
                        $subject = $this->GetResourceValue("WatchedPageChanged",$lang)."'".$tag."'";
                        $message = "<style>.additions {color: #008800;}\n.deletions {color: #880000;}</style>";
                        $message .= $this->GetResourceValue("MailHello",$lang). $Watcher["user"].".<br /> <br /> ";
                        $message .=   $username.
                        $this->GetResourceValue("SomeoneChangedThisPage",$lang)."<br />  ";//* <a href=\"".$this->Href("",$tag,"")."\">".$this->Href("",$tag,"")."</a><br />";
                        $_GET["fastdiff"] = 1;
                        $_GET["a"] = -1;
                        $page = $this->LoadSingle("SELECT ".$this->pages_meta." FROM ".$this->config["table_prefix"]."revisions WHERE tag='".quote($this->dblink, $tag)."' ORDER BY time DESC");
                        $_GET["b"] = $page["id"];
                        $message .= "<hr />".$this->IncludeBuffered("handlers/page/diff.php", "oops")."<hr />";
                        $message .= "<br />".$this->GetResourceValue("MailGoodbye",$lang)." ".$this->GetConfigValue("wakka_name");
                        $this->SendMail($User["email"], $subject, $message);
                     }
                  }
                  $this->SetUser( $_user, 0 );
               }
            }
            $this->SetLanguage($this->userlang);
         }
      }

      $this->WriteRecentChangesXML();
      $this->WriteRecentCommentsXML();
      $this->WriteSiteMapXML();

      return $body_r;
   }

   function SaveMeta($tag, $metadata)
   {
      if ($this->UserIsOwner($tag))
      {
         // update
         $this->Query("UPDATE ".$this->config["table_prefix"]."pages SET ".
        "lang = '".quote($this->dblink, $metadata["lang"])."', ".
        "keywords = '".quote($this->dblink, $metadata["keywords"])."', ".
        "description = '".quote($this->dblink, $metadata["description"])."' ".
        "WHERE tag = '".quote($this->dblink, $tag)."' AND latest='Y' LIMIT 1");
      }
      return true;
   }

   // COOKIES
   function SetSessionCookie($name, $value) { SetCookie($this->config["cookie_prefix"].$name, $value, 0, "/"); $_COOKIE[$this->config["cookie_prefix"].$name] = $value; }
   function SetPersistentCookie($name, $value, $remember = 1) { SetCookie($this->config["cookie_prefix"].$name, $value, time() + ($remember ? 90*24*60*60 : 60 * 60), "/"); $_COOKIE[$this->config["cookie_prefix"].$name] = $value; }
   function DeleteCookie($name) { SetCookie($this->config["cookie_prefix"].$name, "", 1, "/"); $_COOKIE[$this->config["cookie_prefix"].$name] = ""; }
   function GetCookie($name) { return $_COOKIE[$this->config["cookie_prefix"].$name]; }

   // HTTP/REQUEST/LINK RELATED
   function SetMessage($message) { $_SESSION["message"] = $message; }
   function GetMessage() { $message = $_SESSION["message"]; $_SESSION["message"] = ""; return $message; }
   function Redirect($url) { header("Location: $url"); exit; }

   function UnwrapLink( $tag )
   {
      if ($tag=="/") return "";
      if ($tag=="!") return $this->tag;

      $newtag = $tag;

      if (strstr($this->context[$this->current_context], "/"))
      $root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $this->context[$this->current_context] );
      else $root = "";
      if (preg_match("/^\.\/(.*)$/", $tag, $matches)) { $root=""; }
      else if (preg_match("/^\/(.*)$/", $tag, $matches)) { $root = ""; $newtag = $matches[1]; }
      else if (preg_match("/^\!\/(.*)$/", $tag, $matches))
      {
         $root = $this->context[$this->current_context];
         $newtag = $matches[1];
      }
      else if (preg_match("/^\.\.\/(.*)$/", $tag, $matches))
      {
         $newtag = $matches[1];
         if (strstr($root, "/"))
         $root = preg_replace( "/^(.*)\\/([^\\/]+)$/", "$1", $root );
         else $root = "";
      }
      if ($root != "") $newtag= "/".$newtag;
      $tag = $root.$newtag;
      $tag = str_replace( "//", "/", $tag );
      return $tag;
   }

   // returns just PageName[/method].
   function MiniHref($method = "", $tag = "", $addpage = "")
   {
      if (!$tag = trim($tag)) $tag = $this->tag;
      if (!$addpage) $tag=$this->SlimUrl($tag);
      //$tag = $this->Translit($tag, 0);
      $tag = trim( $tag, "/." );
      return $tag.($method ? "/".$method : "");
   }

   // returns the full url to a page/method.
   function Href($method = "", $tag = "", $params = "", $addpage=0)
   {
      $href = $this->config["base_url"].$this->MiniHref($method, $tag, $addpage);
      if ($addpage) $params="add=1".($params?"&amp;".$params:"");
      if ($params)
      {
         $href .= ($this->config["rewrite_mode"] ? "?" : "&amp;").$params;
      }
      return $href;
   }

   function ComposeLinkToPage($tag, $method = "", $text = "", $track = 1)
   {
      if (!$text) $text = $this->AddSpaces($tag);
      //$text = htmlentities($text);
      if ($_SESSION["linktracking"] && $track)
      $this->TrackLinkTo($tag);
      return '<a href="'.$this->href($method, $tag).'">'.$text.'</a>';
   }

   function PreLink($tag, $text = "", $track = 1)
   {
      //    if (!$text) $text = $this->AddSpaces($tag);

      if (preg_match("/^[\!\.".$this->language["ALPHANUM_P"]."]+$/", $tag))
      {// it's a Wiki link!
         if ($_SESSION["linktracking"] && $track) $this->TrackLinkTo($this->UnwrapLink( $tag ));
      }
      return "\xA2\xA2".$tag." ==".($this->format_safe?str_replace(">", "&gt;", str_replace("<", "&lt;", $text)):$text)."\xAF\xAF";
   }

   // <?
   function Link($tag, $method = "", $text = "", $track = 1, $safe=0, $linklang="")
   {
      $class = '';   $title = '';  $lang = '';

      $text = str_replace('"', "&quot;", $text);

      if (!$safe)
      $text = htmlspecialchars($text, ENT_NOQUOTES);

      if ($linklang)
      $this->SetLanguage($linklang);

      $imlink = false;
      if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $text))
      $imlink = $this->GetConfigValue("root_url")."/images/".$text;
      else if (preg_match("/^(http|https|ftp):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", preg_replace("/<\/?nobr>/", "" ,$text)))
      $imlink = $text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
      $url = '';

      if (preg_match("/^(mailto[:])?[^\\s\"<>&\:]+\@[^\\s\"<>&\:]+\.[^\\s\"<>&\:]+$/", $tag, $matches))
      {// this is a valid Email
         $url = ($matches[1]=="mailto:" ? $tag : "mailto:".$tag);
         $title = $this->GetResourceValue("MailLink");
         $icon = $this->GetResourceValue("mailicon");
         $tpl = "email";
      }
      else if (preg_match("/^#/", $tag))
      {// html-anchor
         $url = $tag;
         $tpl = "anchor";
      }
      else if (preg_match("/^[\.\-".$this->language["ALPHANUM_P"]."]+\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
      {// image
         $text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
         return "<img src=\"".$this->GetConfigValue("root_url")."/images/".$tag."\" ".($text?"alt=\"".$text."\" title=\"".$text."\"":"")." />";
      }
      else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(gif|jpg|jpe|jpeg|png)$/i", $tag))
      {// external image
         $text = preg_replace("/(<|\&lt\;)\/?span( class\=\"nobr\")?(>|\&gt\;)/", "" ,$text);
         return "<img src=\"".str_replace("&", "&amp;", str_replace("&amp;", "&", $tag))."\" ".($text?"alt=\"".$text."\" title=\"".$text."\"":"")." />";
      }
      else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rpm|gz|tgz|zip|rar|exe|doc|xls|ppt|tgz|bz2|7z)$/", $tag))
      {// this is a file link
         $url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
         $title= $this->GetResourceValue("FileLink");
         $icon = $this->GetResourceValue("fileicon");
         $tpl = "file";
      }
      else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(pdf)$/", $tag)) {
         // this is a PDF link
         $url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
         $title= $this->GetResourceValue("PDFLink");
         $icon = $this->GetResourceValue("pdficon");
         $tpl = "file";
      }
      else if (preg_match("/^(http|https|ftp|file):\/\/([^\\s\"<>]+)\.(rdf)$/", $tag)) {
         // this is a RDF link
         $url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
         $title= $this->GetResourceValue("RDFLink");
         $icon = $this->GetResourceValue("rdficon");
         $tpl = "file";
      }
      else if (preg_match("/^(http|https|ftp|file|nntp|telnet):\/\/([^\\s\"<>]+)$/", $tag))
      {// this is a valid external URL
         $url = str_replace("&", "&amp;", str_replace("&amp;", "&", $tag));
         if (!stristr($tag,$this->config["base_url"]))
         {
            $title= $this->GetResourceValue("OuterLink2");
            $icon = $this->GetResourceValue("outericon");
         }
         $tpl = "outerlink";
      }
      else if (preg_match("/^(_?)file:([^\\s\"<>\(\)]+)$/", $tag, $matches))
      {// this is a file:
         $noimg = $matches[1];
         $thing = $matches[2];
         $arr = explode("/", $thing);
         //echo($thing."<br />");
         if (count($arr)==1)                // file:shit.zip
         {
            //    echo ($thing."<br />");
            //try to find in global storage and return if success
            $desc = $this->CheckFileExists($thing);
            //    print_r($desc);
            if (is_array($desc))
            {
               $title = $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetResourceValue("UploadKB").")";
               if ($desc["picture_w"] && !$noimg)
               {
                  if (!$text) $text = $title;
                  return "<img src=\"".$this->GetConfigValue("root_url").$this->config["upload_path"]."/".$thing."\" ".($text?"alt=\"".$text."\" title=\"".$text."\"":"")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
               }
               $url = $this->GetConfigValue("root_url").$this->config["upload_path"]."/".$thing;
               $icon = $this->GetResourceValue("fileicon");
               $imlink = false;
               $tpl = "localfile";
            }
         }
         if (count($arr)==2 && $arr[0]=="") // file:/shit.zip
         {
            //try to find in global storage and return if success
            $desc = $this->CheckFileExists($arr[1]);
            if (is_array($desc))
            {
               $title = $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetResourceValue("UploadKB").")";
               if ($desc["picture_w"] && !$noimg)
               {
                  if (!$text) $text = $title;
                  return "<img src=\"".$this->GetConfigValue("root_url").$this->config["upload_path"]."/".$thing."\" ".($text?"alt=\"".$text."\" title=\"".$text."\"":"")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
               }
               $url = $this->GetConfigValue("root_url").$this->config["upload_path"].$thing;
               $imlink = false;
               $icon = $this->GetResourceValue("fileicon");
               $tpl = "localfile";
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
            $file = $arr[count($arr)-1];
            unset($arr[count($arr)-1]);
            $_pagetag = implode("/", $arr);
            if ($_pagetag=="") $_pagetag = "!/";
            //unwrap tag (check !/, ../ cases)
            $pagetag = $this->UnwrapLink( $_pagetag );
            //try to find in local $tag storage
            $desc = $this->CheckFileExists($file, $pagetag);
            if (is_array($desc))
            {
               //check 403 here!
               if ($this->IsAdmin() || ($desc["id"] && ($this->GetPageOwner($this->tag) == $this->GetUserName())) ||
               ($this->HasAccess("read", $pagetag)) || ($desc["user"] == $this->GetUserName()) )
               {
                  $title = $desc["description"]." (".ceil($desc["filesize"]/1024)."&nbsp;".$this->GetResourceValue("UploadKB").")";
                  if ($desc["picture_w"] && !$noimg)
                  {
                     if (!$text) $text = $title;
                     return "<img src=\"".$this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file."\" ".($text?"alt=\"".$text."\" title=\"".$text."\"":"")." width='".$desc["picture_w"]."' height='".$desc["picture_h"]."' />";
                  }
                  $url = $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
                  $imlink = false;
                  $icon = $this->GetResourceValue("fileicon");
                  $tpl = "localfile";
               }
               else //403
               {
                  $url = $this->config["base_url"].trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
                  $imlink = false;
                  $icon = $this->GetResourceValue("lockicon");
                  $tpl = "localfile";
                  $class = "denied";
               }
            }
            else //404
            {
               $tpl = "wlocalfile";
               $title = "404: /".trim($pagetag,"/")."/files".($this->config["rewrite_mode"] ? "?" : "&amp;")."get=".$file;
               $url = "404";
            }

         }
         //forgot 'bout 403
      }
      else if ($this->GetConfigValue("disable_tikilinks")!=1 && preg_match("/^(".$this->language["UPPER"].$this->language["LOWER"].$this->language["ALPHANUM"]."*)\.(".$this->language["ALPHA"].$this->language["ALPHANUM"]."+)$/s", $tag, $matches))
      {// it`s a Tiki link!
         if (!$text) $text = $this->AddSpaces($tag);
         $tag = "/".$matches[1]."/".$matches[2];
         return $this->Link( $tag, $method, $text, $track, 1);
      }
      else if (preg_match("/^([[:alnum:]]+)[:]([".$this->language["ALPHANUM_P"]."\-\_\.\+\&\=\#]*)$/", $tag, $matches))
      {// interwiki
         $parts = explode("/",$matches[2]);
         for ($i=0;$i<count($parts);$i++) $parts[$i] = str_replace("%23", "#", urlencode($parts[$i]));
         $url = $this->GetInterWikiUrl($matches[1], implode("/",$parts));
         $icon = $this->GetResourceValue("iwicon");
         $tpl = "interwiki";
         if ($linklang)
         $text = $this->DoUnicodeEntities($text, $linklang);
      }
      else if (preg_match("/^([\!\.".$this->language["ALPHANUM_P"]."]+)(\#[".$this->language["ALPHANUM_P"]."\_\-]+)?$/", $tag, $matches))
      {// it's a Wiki link!
         $tag = $otag = $matches[1];
         $untag = $unwtag = $this->UnwrapLink( $tag );

         $regex_handlers = '/^(.*?)\/('.$this->GetConfigValue("standard_handlers").')\/(.*)$/i';
         $ptag = $this->NpjTranslit($unwtag);
         $handler = null;
         if (preg_match( $regex_handlers, "/".$ptag."/", $match ))
         {
            $handler = $match[2];
            $ptag = $match[1];
            $unwtag = "/".$unwtag."/";
            $co = substr_count($_ptag, "/") - substr_count($ptag, "/");
            for ($i=0; $i<$co; $i++) $unwtag = substr($unwtag,0,strrpos($unwtag,"/"));
            if ($handler)
            {
               $opar = "/".$untag."/";
               for ($i=0; $i<substr_count($data, "/")+2; $i++) $opar = substr($opar,strpos($opar,"/")+1);
               $params = explode("/", $opar); //there're good params
            }
         }
         $unwtag = trim($unwtag, "/.");
         $unwtag = str_replace( "_", "", $unwtag );
         if ($handler) $method = $handler;
         //if ($tag=="!/edit") echo "{".$tag."|".$untag."|".$unwtag."|".$handler."}";

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
            if ($thispage["lang"]) $lang = $thispage["lang"];
            else $lang = $this->GetConfigValue("language");

            $this->SetLanguage($lang);
            $supertag = $this->NpjTranslit($tag);
            //       echo "<h1>".$_lang."|".$lang."|".$supertag."</h1>";
         }
         else
         {
            $supertag = $this->NpjTranslit($tag, TRAN_LOWERCASE, TRAN_DONTLOAD);
         }


         $aname="";
         if (substr($tag,0,2)=="!/")
         {
            $icon = $this->GetResourceValue("childicon");
            $page0 = substr($tag,2);
            $page = $this->AddSpaces($page0);
            $tpl = "childpage";
         }
         else if (substr($tag,0,3)=="../")
         {
            $icon = $this->GetResourceValue("parenticon");
            $page0 = substr($tag,3);
            $page = $this->AddSpaces($page0);
            $tpl = "parentpage";
         }
         else if (substr($tag,0,1)=="/")
         {
            $icon = $this->GetResourceValue("rooticon");
            $page0 = substr($tag,1);
            $page = $this->AddSpaces($page0);
            $tpl = "rootpage";
         }
         else
         {
            $icon = $this->GetResourceValue("equalicon");
            $page0 = $tag;
            $page = $this->AddSpaces($page0);
            $tpl = "equalpage";
         }
         if ($imlink) $text="<img src=\"$imlink\" border=\"0\" title=\"$text\" />";
         if ($text)
         {
            $tpl = "descrpage";
            $icon = "";
         }
         $pagepath = substr($untag,0, strlen($untag) - strlen($page0));
         $anchor = isset( $matches[2] ) ? $matches[2] : '';
         $tag = $unwtag;
         if ($_SESSION["linktracking"] && $track) $this->TrackLinkTo($tag);

         if (!isset( $this->first_inclusion[ $supertag ] )) $aname = "name=\"".$supertag."\"";
         $this->first_inclusion[ $supertag ] = 1;

         if ($thispage)
         {
            $pagelink = $this->href($method, $thispage["tag"]).$this->AddDateTime($tag).($anchor?$anchor:"");
            if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$tag);
            else
            {
               $access = true;
               $this->_acl["list"]=="*";
            }
            if (!$access)
            {
               $class="denied";
               $accicon = $this->GetResourceValue("lockicon");
            }
            else if ($this->_acl["list"]=="*")
            {
               $class = "";
               $accicon = "";
            }
            else
            {
               $class="customsec";
               $accicon = $this->GetResourceValue("keyicon");
            }
            // language
            //        echo "<< ".$lang.":".$_lang.":".$otag."|$linklang >>";
            //        if ($lang!=$this->pagelang)
            //        {
            if ($text==trim($otag,"/") || $linklang)
            $text = $this->DoUnicodeEntities($text, $lang);
            //         echo "< ".$text.":".$otag." >";
            $page = $this->DoUnicodeEntities($page, $lang);
            //        }
            if (isset($_lang)) $this->SetLanguage($_lang);
         }
         else
         {
            $tpl = ($this->method=="print" || $this->method=="msword"?"p":"")."w".$tpl;
            $pagelink = $this->href("edit", $tag, $lang?"lang=".$lang:"", 1);
            $accicon = $this->GetResourceValue("wantedicon");
            $title = $this->GetResourceValue("CreatePage");
            if ($linklang)
            {
               $text = $this->DoUnicodeEntities($text, $linklang);
               $page = $this->DoUnicodeEntities($page, $linklang);
            }
         }

         $icon = str_replace("{theme}", $this->GetConfigValue("theme_url"), $icon);
         $accicon = str_replace("{theme}", $this->GetConfigValue("theme_url"), $accicon);
         $res = $this->GetResourceValue("tpl.".$tpl);
         $text = trim($text);
         if ($res)
         {
            //todo: pagepath
            $aname = str_replace("/", ".", $aname);
            $res = str_replace("{aname}",  $aname,  $res);
            $res = str_replace("{icon}",   $icon,   $res);
            $res = str_replace("{accicon}",$accicon,$res);
            $res = str_replace("{class}",  $class,  $res);
            $res = str_replace("{title}",  $title,  $res);
            $res = str_replace("{pagelink}", $pagelink, $res);
            $res = str_replace("{pagepath}", $pagepath, $res);
            $res = str_replace("{page}",   $page,  $res);
            $res = str_replace("{text}",   $text,  $res);
            //      if ($linklang)  {echo("{aname}".  $aname);echo("{icon}".   $icon);echo("{accicon}".$accicon);echo("{class}".  $class);echo("{title}".  $title);echo("{pagelink}". $pagelink);echo("{pagepath}". $pagepath);echo("{page}".   $page);echo("{text}".   $text);}

            if (!$text) $text = htmlspecialchars($tag, ENT_NOQUOTES);
            if ($this->GetConfigValue("youarehere_text"))
            if ($this->NpjTranslit($tag) == $this->NpjTranslit($this->context[$this->current_context]))
            $res = str_replace("####", $text, $this->GetConfigValue("youarehere_text"));
            return $res;
         }
         die ("ERROR: no tpl '$tpl'!");
      }
      if (!$text) $text = htmlspecialchars($tag, ENT_NOQUOTES);
      if ($url)
      {
         if ($imlink) $text="<img src=\"$imlink\" border=\"0\" title=\"$text\" />";
         $icon = str_replace("{theme}", $this->GetConfigValue("theme_url"), $icon);
         $res = $this->GetResourceValue("tpl.".$tpl);
         if ($res)
         {
            if (!$class) $class="outerlink";
            $res = str_replace("{icon}",  $icon,  $res);
            $res = str_replace("{class}", $class, $res);
            $res = str_replace("{title}", $title, $res);
            $res = str_replace("{url}",   $url,   $res);
            $res = str_replace("{text}",  $text,  $res);
            return $res;
         }
      }
      //echo ("<br>".$tag."<br>");
      //die("^([[:alnum:]]+)[:]([".$this->language["ALPHANUM_P"]."\-\_\.\+\&\=]*)$");
      return $text;
   }

   function AddDatetime($tag)
   {
      if ($user = $this->GetUser()) $show = $user["showdatetime"];
      if (!$show) $show=$this->GetConfigValue("show_datetime");
      if (!$show) $show = "Y";
      if ($show!="N" && $show!="0")
      {
         $_page = $this->LoadPage($tag, "", LOAD_CACHE, LOAD_META);
         return ($this->config["rewrite_mode"] ? "?" : "&amp;").
       "v=".base_convert($this->crc16(preg_replace("/[ :\-]/","",$_page["time"])),10,36);
      } else return "";
   }

   function crc16($string) {
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
      $show = "Y";
      if ($user = $this->GetUser()) $show = $user["show_spaces"];
      if (!$show) $show=$this->GetConfigValue("show_spaces");
      if ($show!="N") {
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
      if (strpos($text, "/")===0) $text = $this->GetResourceValue("RootLinkIcon").substr($text, 1);
      if (strpos($text, "!/")===0) $text = $this->GetResourceValue("SubLinkIcon").substr($text, 2);
      if (strpos($text, "../")===0) $text = $this->GetResourceValue("UpLinkIcon").substr($text, 3);
      return $text;
   }

   function SlimUrl($text)
   {
      $text = $this->NpjTranslit($text, TRAN_DONTCHANGE);
      $text = str_replace("_", "'", $text);
      if ($this->config["urls_underscores"]==1)
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

   function IsWikiName($text) { return preg_match("/^".$this->language["UPPER"].$this->language["LOWER"]."+".$this->language["UPPERNUM"].$this->language["ALPHANUM"]."*$/", $text); }
   function TrackLinkTo($tag) { $this->linktable[] = $tag; }
   function GetLinkTable() { return $this->linktable; }
   function ClearLinkTable() { $this->linktable = array(); }
   function StartLinkTracking() { $_SESSION["linktracking"] = 1; }
   function StopLinkTracking() { $_SESSION["linktracking"] = 0; }

   function WriteLinkTable()
   {
      // delete old link table
      $this->Query("DELETE FROM ".$this->config["table_prefix"]."links WHERE from_tag = '".quote($this->dblink, $this->GetPageTag())."'");
      if ($linktable = $this->GetLinkTable())
      {
         $from_tag = quote($this->dblink, $this->GetPageTag());
         foreach ($linktable as $to_tag)
         {
            $lower_to_tag = strtolower($to_tag);
            if (!$written[$lower_to_tag])
            {
               $query.="('".$from_tag."', '".quote($this->dblink, $to_tag)."', '".quote($this->dblink, $this->NpjTranslit($to_tag))."'),";
               $written[$lower_to_tag] = 1;
            }
         }
         $this->Query("INSERT INTO ".$this->config["table_prefix"]."links (from_tag, to_tag, to_supertag) VALUES ".rtrim($query,","));
      }
   }

   function Header($mod="") {
      //    $this->StopLinkTracking();
      $result = $this->IncludeBuffered("header".$mod.".php", "Theme is corrupt: ".$this->GetConfigValue("theme"), "", "themes/".$this->GetConfigValue("theme")."/appearance");
      //    $this->StartLinkTracking();
      return $result;
   }

   function Footer($mod="") {
      //    $this->StopLinkTracking();
      $result = $this->IncludeBuffered("footer".$mod.".php", "Theme is corrupt: ".$this->GetConfigValue("theme"), "", "themes/".$this->GetConfigValue("theme")."/appearance");
      //    $this->StartLinkTracking();
      return $result;
   }

   function UseClass($class_name, $class_dir="", $file_name="" )
   {
      if(!class_exists($class_name))
      {
         if ($file_name == "") $file_name=$class_name;
         if ($class_dir == "") $class_dir=$this->classes_dir;
         $class_file = $class_dir.$file_name.".php";
         $class_file = trim($class_file, "./");

         if (!@is_readable($class_file))
         die("Cannot load class ".$class_name."  from ". $class_file. " (".$class_dir.")");
         else require_once($class_file);
      }
   }

   // tabbed theme output routine
   function EchoTab( $link, $hint, $text, $selected=false, $bonus="" )
   {
      $xsize = $selected?7:8;
      $ysize = $selected?25:30;
      if ($text == "") return; // no tab;
      if ($selected) $text = "<a href=\"$link\" title=\"$hint\">".$text."</a>";
      if (!$selected) echo "<div class='TabSelected$bonus' style='background-image:url(".$this->GetConfigValue("theme_url")."icons/tabbg.gif);' >";
      else echo "<div class='Tab$bonus' style='background-image:url(".$this->GetConfigValue("theme_url")."icons/tabbg".($bonus=="2a"?"del":"1").".gif);'>";
      $bonus2 = $bonus=="2a"?"del":"";

      echo '<table cellspacing="0" cellpadding="0" border="0" ><tr>';
      echo "<td><img src='".
      $this->GetConfigValue("theme_url").
           "icons/tabr$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";
      if (!$selected) echo "<td>"; else echo "<td valign='top'>";
      echo "<div class='TabText'>".$text."</div>";
      echo "</td>";
      echo "<td><img src='".
      $this->GetConfigValue("theme_url").
           "icons/tabl$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";
      echo '</tr></table>';
      echo "</div>";
   }

   // FORMS
   function FormOpen($method = "", $tag = "", $formMethod = "post", $formname="", $formMore="")
   {
      $add = isset( $_REQUEST["add"] ) ? $_REQUEST["add"] : '';
      $result = "<form action=\"".$this->href($method, $tag, "", $add)."\" ".$formMore." method=\"".$formMethod."\" ".($formname?"name=\"".$formname."\" ":"").">\n";
      if (!$this->config["rewrite_mode"]) $result .= "<input type=\"hidden\" name=\"page\" value=\"".$this->MiniHref($method, $tag, $add)."\" />\n";
      return $result;
   }

   function FormClose()
   {
      return "</form>\n";
   }

   function NoCache()
   {
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
      header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");                          // HTTP/1.0
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
               $this->AddInterWiki($wikiName, $wikiUrl);
            }
         }
      }
   }

   function AddInterWiki($name, $url)
   {
      $this->interWiki[strtolower($name)] = $url;
   }

   function GetInterWikiUrl($name, $tag)
   {
      if ($url = $this->interWiki[strtolower($name)])
      {
         $url = str_replace("&", "&amp;", $url); //xhtmlisation
         if (strpos($url, "%s")) {
            return str_replace("%s", $tag, $url);
         } else {
            return $url.$tag;
         }
      }
   }

   // REFERRERS
   function LogReferrer($tag = "", $referrer = "")
   {
      // fill values
      if (!$tag = trim($tag)) $tag = $this->GetPageTag();
      if (!$referrer = trim($referrer)) $referrer = isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '';

      // check if it's coming from another site
      if ($referrer && !preg_match("/^".preg_quote($this->GetConfigValue("base_url"), "/")."/", $referrer))
      {
         $this->Query("INSERT INTO ".$this->config["table_prefix"]."referrers SET ".
       "page_tag = '".quote($this->dblink, $tag)."', ".
       "referrer = '".quote($this->dblink, $referrer)."', ".
       "time = now()");
      }
   }

   function LoadReferrers($tag = "")
   {
      return $this->LoadAll("SELECT referrer, count(referrer) AS num FROM ".$this->config["table_prefix"]."referrers ".($tag = trim($tag) ? "WHERE page_tag = '".quote($this->dblink, $tag)."'" : "")." GROUP BY referrer ORDER BY num DESC");
   }

   // PLUGINS
   function Action($action, $params, $forceLinkTracking = 0)
   {
      $action = trim($action);

      if (!$forceLinkTracking) $this->StopLinkTracking();
      $result = $this->IncludeBuffered(strtolower($action).".php", "<i>".$this->GetResourceValue("UnknownAction")." \"$action\"</i>", $params, $this->config["action_path"]);
      $this->StartLinkTracking();
      $this->NoCache();
      return $result;
   }

   function Method($method)
   {
      if ($method=="show") $this->CacheLinks();
      if (!$handler = $this->page["handler"]) $handler = "page";
      $methodLocation = $handler."/".$method.".php";
      return $this->IncludeBuffered($methodLocation, "<i>Unknown method \"$methodLocation\"</i>", "", $this->config["handler_path"]);
   }

   function Format($text, $formatter = "wakka", $options = "")
   {
      return $this->_Format($text, $formatter, $options);
   }

   function _Format($text, $formatter, &$options)
   {
      $text = $this->IncludeBuffered("formatters/".$formatter.".php",
     "<i>Formatter \"$formatter\" not found</i>", compact("text", "options"));
      if ($formatter == "wacko" && $this->GetConfigValue("default_typografica"))
      $text = $this->IncludeBuffered("formatters/typografica.php", "<i>Formatter \"$formatter\" not found</i>", compact("text"));
      return $text;
   }

   // USERS
   function LoadUser($name, $password = 0)
   {
      $user = $this->LoadSingle("SELECT * FROM ".$this->config["user_table"]." WHERE name = '".
      quote($this->dblink, $name)."' ".($password === 0 ? "" : "AND password = '".quote($this->dblink, $password)."'")." LIMIT 1");
      if ($user) $user["options"] = $this->DecomposeOptions($user["more"]);
      return $user;
   }

   function LoadUsers() { return $this->LoadAll("SELECT * FROM ".$this->config["user_table"]." ORDER BY binary name"); }

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

   function _gethostbyaddr($ip) {if ($this->GetConfigValue("allow_gethostbyaddr")) return gethostbyaddr($ip); else return false;}
   function GetUser()
   {
      if (isset( $_SESSION[$this->config["cookie_prefix"]."user"] ))
      return $_SESSION[$this->config["cookie_prefix"]."user"];
      else
      return null;
   }

   function SetUser($user, $setcookie=1)
   {
      $_SESSION[$this->config["cookie_prefix"]."user"] = $user;
      if ($setcookie) $this->SetPersistentCookie("name", $user["name"], 1);
   }

   function LogUserIn($user)
   {
      $this->SetPersistentCookie("name", $user["name"], 1);
      $this->SetPersistentCookie("password", $user["password"]);
   }

   function LogoutUser() { $_SESSION[$this->config["cookie_prefix"]."user"] = ""; $this->DeleteCookie("name"); $this->DeleteCookie("password"); }
   function UserWantsComments() { if (!$user = $this->GetUser()) return false; return ($user["show_comments"] == "Y"); }
   function UserWantsFiles()    { if (!$user = $this->GetUser()) return false; return ($user["options"]["show_files"] == "Y"); }

   // Returns boolean indicating if the current user is allowed to see comments at all
   function UserAllowedComments() { return $this->GetConfigValue("hide_comments") != 1 && ($this->GetConfigValue("hide_comments") != 2 || $this->GetUser()); }

   function DecomposeOptions( $more )
   {
      $b = array();
      $opts = explode( $this->optionSplitter, $more );
      foreach( $opts as $o )
      {
         $params = explode( $this->valueSplitter, trim($o) );
         $b[ $params[0] ] = $params[1];
      }
      return $b;
   }

   function ComposeOptions( $options )
   {
      $opts = array();
      foreach ($options as $k=>$v)
      $opts[] = $k.$this->valueSplitter.$v;
      return implode( $this->optionSplitter, $opts );
   }

   // COMMENTS
   function LoadComments($tag) { return $this->LoadAll("SELECT * FROM ".$this->config["table_prefix"]."pages WHERE comment_on = '".quote($this->dblink, $tag)."' AND latest = 'Y' ORDER BY time"); }

   // ACCESS CONTROL
   function IsAdmin()
   {
      if (is_array($this->config['aliases']))
      {
         $al = $this->config['aliases'];
         $adm = explode("\n", $al['Admins']);
         if (in_array($this->GetUserName(),$adm))
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
      if ($this->GetPageOwner($tag) == $this->GetUserName()) return true;
   }

   function GetPageOwnerFromComment()  {  if($this->page["comment_on"]) return $this->GetPageOwner($this->page["comment_on"]); return false; }
   function GetPageOwner($tag = "", $time = "") { if (!$tag = trim($tag)) $tag = $this->GetPageTag(); if ($page = $this->LoadPage($tag, $time, LOAD_CACHE, LOAD_META)) return $page["owner"]; }

   function SetPageOwner($tag, $user)
   {
      // check if user exists
      if (!$this->LoadUser($user)) return;

      // updated latest revision with new owner
      $this->Query("UPDATE ".$this->config["table_prefix"]."pages SET owner = '".quote($this->dblink, $user)."' WHERE tag = '".quote($this->dblink, $tag)."' AND latest = 'Y' LIMIT 1");
   }

   function LoadAcl($tag, $privilege, $useDefaults = 1)
   {
      $supertag = $this->NpjTranslit($tag);
      if ($cachedACL = $this->GetCachedACL($supertag, $privilege, $useDefaults)) $acl = $cachedACL;
      if (!$acl)
      {
         if ($cachedACL = $this->GetCachedACL($tag, $privilege, $useDefaults)) $acl = $cachedACL;

         if (!$acl)
         {

            $acl = $this->LoadSingle("SELECT * FROM ".$this->config["table_prefix"]."acls WHERE ".
                                "supertag = '".quote($this->dblink, $supertag)."' ".
                                "AND privilege = '".quote($this->dblink, $privilege)."' LIMIT 1");
            if (!$acl)
            {
               $acl = $this->LoadSingle("SELECT * FROM ".$this->config["table_prefix"]."acls WHERE ".
                                  "page_tag = '".quote($this->dblink, $tag)."' ".
                                  "AND privilege = '".quote($this->dblink, $privilege)."' LIMIT 1");
               /*        if ($acl)
                {
                $this->Query( "update ".$this->config["table_prefix"]."acls ".
                "set supertag='".$supertag."' where page_tag = '".$tag."';" );
                $acl["supertag"]=$supertag;
                }
                */      }
               if (!$acl && $useDefaults)
               {
                  $acl = array("supertag" => $supertag, "page_tag" => $tag,
                      "privilege" => $privilege,
                      "list" => $this->GetConfigValue("default_".$privilege."_acl"),
                      "time" => date("YmdHis"),
                      "default" => "1"
                      );
               }
               $this->CacheACL($supertag, $privilege, $useDefaults,$acl);
         }
      }
      return $acl;
   }

   function SaveAcl($tag, $privilege, $list) {

      $supertag = $this->NpjTranslit($tag);
      if ($this->LoadAcl($tag, $privilege, 0))
      $this->Query("UPDATE ".$this->config["table_prefix"]."acls SET list = '".
      quote($this->dblink, trim(str_replace("\r", "", $list)))."' WHERE supertag = '".quote($this->dblink, $supertag)."' AND privilege = '".quote($this->dblink, $privilege)."' ");
      else
      $this->Query("INSERT INTO ".$this->config["table_prefix"]."acls SET list = '".
      quote($this->dblink, trim(str_replace("\r", "", $list)))."', ".
         "supertag = '".quote($this->dblink, $supertag)."', ".
         "page_tag = '".quote($this->dblink, $tag)."', ".
         "privilege = '".quote($this->dblink, $privilege)."'");

   }

   function RemoveAcls($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."acls  WHERE page_tag = '".quote($this->dblink, $tag)."' ");
   }

   function RemovePage($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."revisions  WHERE tag = '".quote($this->dblink, $tag)."' ") &&
      $this->Query("DELETE FROM ".$this->config["table_prefix"]."pages  WHERE tag = '".quote($this->dblink, $tag)."' ");
   }

   function RemoveComments($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."pages  WHERE comment_on = '".quote($this->dblink, $tag)."' ");
   }

   function RemoveWatches($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."pagewatches  WHERE tag = '".quote($this->dblink, $tag)."' ");
   }

   function RemoveLinks($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."links  WHERE from_tag = '".quote($this->dblink, $tag)."' ");
   }

   function RemoveReferrers($tag) {
      return $this->Query("DELETE FROM ".$this->config["table_prefix"]."referrers WHERE page_tag = '".quote($this->dblink, $tag)."' ");
   }

   // WATCHES
   function IsWatched($user, $tag) {
      return $this->LoadSingle("SELECT * FROM ".$this->config["table_prefix"]."pagewatches WHERE user = '".quote($this->dblink, $user)."' AND tag = '".quote($this->dblink, $tag)."'");
   }

   function SetWatch($user, $tag) {
      // Remove old watch first to avoid double watches
      $this->ClearWatch($user, $tag);
      return $this->Query( "INSERT INTO ".$this->config["table_prefix"]."pagewatches (user,tag) VALUES ( '".quote($this->dblink, $user)."', '".quote($this->dblink, $tag)."')" );
      // TIMESTAMP type is filled automatically by MySQL
   }

   function ClearWatch($user, $tag){
      return $this->Query( "DELETE FROM ".$this->config["table_prefix"]."pagewatches WHERE user = '".quote($this->dblink, $user)."' AND tag = '".quote($this->dblink, $tag)."'");
   }

   //aliases stuff
   function ReplaceAliases ($acl)
   {
      if (!is_array($this->config['aliases'])) return $acl;

      foreach ($this->config['aliases'] as $key => $val) $aliases[strtolower($key)]=$val;

      do
      {
         $list = array();
         $replaced = 0;
         $lines = explode("\n", $acl);
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
            $negate = 0;

            $linel = strtolower(trim($linel));

            if (isset( $aliases[$linel] ))
            {
               foreach (explode("\n", $aliases[$linel]) as $item)
               {
                  $item = trim($item);
                  $list[] = ($negate) ? "!".$item : $item;
               }
               $replaced++;
            }
            else
            $list[] = $line;
         }
         $acl = join("\n", $list);
      } while ($replaced > 0);
      return $acl;
   }

   // returns true if $user (defaults to current user) has access to $privilege on $page_tag (defaults to current page)
   function HasAccess($privilege, $tag = "", $user = "")
   {
      $registered = false;
      // see whether user is registered and logged in
      if ($user!="guest@wacko")
      {
         if ($user = $this->GetUser()) $registered = true;
         $user = strtolower($this->GetUserName());
         if (!$registered) $user="guest@wacko";
      }
      if (!$tag = trim($tag)) $tag = $this->GetPageTag();

      // load acl
      $acl = $this->LoadAcl($tag, $privilege);
      $this->_acl = $acl;

      // if current user is owner, return true. owner can do anything!
      if ($user!="guest@wacko") if ($this->UserIsOwner($tag))
      return true;

      return $this->CheckACL($user, $acl['list'], true);
   }

   function CheckACL($user, $acl_list, $copy_to_this_acl = false, $debug=0)
   {
      if (is_array($user)) $user = $user["name"];
      $user = strtolower($user);

      // replace groups
      $acl = str_replace(" ", "", strtolower($this->ReplaceAliases($acl_list)));
      if ($copy_to_this_acl) $this->_acl['list'] = $acl;
      $acls = "\n".$acl."\n";

      if ($user=="guest@wacko" || $user=="")
      {
         if (($pos=strpos($acls, '*'))===false) return false;
         if ($acls{$pos-1}!="!") return true;
         return false;
      }

      $upos =strpos($acls, "\n".$user."\n");
      $aupos=strpos($acls, "\n!".$user."\n");
      $spos =strpos($acls, '*');
      $bpos =strpos($acls, '$');
      $bpos2=strpos($acls, '§'); //deprecate it!!

      if ($aupos!==false) return false;

      if ($upos!==false)  return true;

      if ($spos!==false)
      if ($acls{$spos-1}=="!") return false;

      if ($bpos!==false)
      if ($acls{$bpos-1}=="!") return false;

      if ($bpos2!==false)
      if ($acls{$bpos2-1}=="!") return false;

      if ($spos!==false) return true;
      if ($bpos!==false) if ($user=="guest@wacko" || $user=="") return false;
      else return true;
      if ($bpos2!==false) if ($user=="guest@wacko" || $user=="") return false;
      else return true;

      return false;
   }

   // XML
   function WriteRecentChangesXML()
   {
      $xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
      $xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
      $xml .= "<channel>\n";
      $xml .= "<title>".$this->GetConfigValue("wakka_name").$this->GetResourceValue("RecentChangesTitleXML")."</title>\n";
      $xml .= "<link>".$this->GetConfigValue("root_url")."</link>\n";
      $xml .= "<description>".$this->GetResourceValue("RecentChangesXML").$this->GetConfigValue("wakka_name")." </description>\n";
      $xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
     $xml .= "<image>\n";
      $xml .= "<title>".$this->GetConfigValue("wakka_name").$this->GetResourceValue("RecentCommentsTitleXML")."</title>\n";
      $xml .= "<link>".$this->GetConfigValue("root_url")."</link>\n";
      $xml .= "<url>".$this->GetConfigValue("root_url")."files/wacko4.gif"."</url>\n";
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
               $xml .= "<description>".$page["time"]." by ".$page["user"]."</description>\n";
               $xml .= "</item>\n";
            }
         }
      }

      $xml .= "</channel>\n";
      $xml .= "</rss>\n";

      $filename = "xml/recentchanges_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name"))).".xml";

      $fp = @fopen($filename, "w");
      if ($fp)
      {
         fwrite($fp, $xml);
         fclose($fp);
      }
   }

   function WriteRecentCommentsXML() {
      $xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
      $xml .= "<?xml-stylesheet type=\"text/css\" href=\"".$this->GetConfigValue("theme_url")."css/wakka.css\" media=\"screen\"?>\n";
      $xml .= "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
      $xml .= "<channel>\n";
      $xml .= "<title>".$this->GetConfigValue("wakka_name").$this->GetResourceValue("RecentCommentsTitleXML")."</title>\n";
      $xml .= "<link>".$this->GetConfigValue("root_url")."</link>\n";
      $xml .= "<description>".$this->GetResourceValue("RecentCommentsXML").$this->GetConfigValue("wakka_name")." </description>\n";
      $xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
      $xml .= "<image>\n";
      $xml .= "<title>".$this->GetConfigValue("wakka_name").$this->GetResourceValue("RecentCommentsTitleXML")."</title>\n";
      $xml .= "<link>".$this->GetConfigValue("root_url")."</link>\n";
      $xml .= "<url>".$this->GetConfigValue("root_url")."files/wacko4.gif"."</url>\n";
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
               $xml .= "<title>".$page["tag"]." ".$this->GetResourceValue("To")." ".$page["comment_on"]." ".$this->GetResourceValue("From")." ".$page["user"]."</title>\n";
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

      $filename = "xml/recentcomment_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name"))).".xml";

      $fp = @fopen($filename, "w");
      if ($fp)  {
         fwrite($fp, $xml);
         fclose($fp);
      }
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

   // MAINTENANCE
   function Maintenance()
   {
      // purge referrers
      if ($days = $this->GetConfigValue("referrers_purge_time")) {
         $this->Query("DELETE FROM ".$this->config["table_prefix"]."referrers WHERE time < date_sub(now(), interval '".quote($this->dblink, $days)."' day)");
      }

      // purge old page revisions
      if ($days = $this->GetConfigValue("pages_purge_time")) {
         $this->Query("DELETE FROM ".$this->config["table_prefix"]."revisions WHERE time < date_sub(now(), interval '".quote($this->dblink, $days)."' day) AND latest = 'N'");
      }
   }

   //BOOKMARKS
   function GetDefaultBookmarks($lang, $what="default")
   {
      if($this->GetConfigValue("multilanguage"))
         {
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
               {
                  $this->userlang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

                  // Check whether we have language files for this language
                  if(!in_array($this->userlang, $this->AvailableLanguages()))
                     {
                        // The HTTP_ACCEPT_LANGUAGE language doesn't have any language files so use the admin set language instead
                        $this->userlang = $this->GetConfigValue("language");
                     }
               }
            else
               {
                  $this->userlang = $this->GetConfigValue("language");
               }
         }
      else if (!$lang) $lang = $this->config["language"];

      if (isset($this->config[$what."_bookmarks"]) && is_array($this->config[$what."_bookmarks"]) && isset($this->config[$what."_bookmarks"][$lang]))
      return $this->config[$what."_bookmarks"][$lang];
      else if (isset($this->config[$what."_bookmarks"]) && !is_array($this->config[$what."_bookmarks"]) && ($this->config["language"]==$lang))
      return $this->config[$what."_bookmarks"];
      else
      return $this->GetResourceValue($what."_bookmarks", $lang, false);
   }

   function SetBookmarks($set=BM_AUTO)
   {
      $user = $this->GetUser();

      if ($set || !($bookmarks=$this->GetBookmarks()))
      {
         $bookmarks = $user["bookmarks"] ? $user["bookmarks"] : $this->GetDefaultBookmarks($user["lang"]);
         if ($set==BM_DEFAULT) $bookmarks = $this->GetDefaultBookmarks($user["lang"]);
         $dummy = $this->Format($bookmarks, "wacko");
         $this->ClearLinkTable();
         $this->StartLinkTracking();
         $dummy = $this->Format($dummy, "post_wacko");
         $this->StopLinkTracking();
         $bmlinks = $this->GetLinkTable();
         $bookmarks = explode("\n", $bookmarks);
         for ($i=0;$i<count($bmlinks);$i++) $bmlinks[$i] = $this->NpjTranslit($bmlinks[$i]);
         $_SESSION["bookmarks"] = $bookmarks;
         $_SESSION["bookmarklinks"] = $bmlinks;
         $_SESSION["bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
      }

      if (!empty( $_REQUEST["addbookmark"] ) && $user)
      {
         $bookmark="((".$this->GetPageTag().($user["lang"]!=$this->pagelang?" @@".$this->pagelang:"")."))";
         if (!in_array($bookmark,$bookmarks))
         {
            $bookmarks[] = $bookmark;

            $this->Query("UPDATE ".$this->config["user_table"]." SET ".
            "bookmarks = '".quote($this->dblink, implode("\n", $bookmarks))."' ".
            "WHERE name = '".quote($this->dblink, $user["name"])."' LIMIT 1");

            $this->SetUser($this->LoadUser($user["name"]));
         }
         $_SESSION["bookmarks"] = $bookmarks;
         //$_SESSION["bookmarksfmt"] = $this->Format($this->Format(implode(" | ", $bookmarks), "wacko"), "post_wacko");
         $_SESSION["bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
         $bmlinks = $bookmarks;
         for ($i=0;$i<count($bmlinks);$i++) $bmlinks[$i] = trim($this->NpjTranslit($bmlinks[$i]),"()");
         $_SESSION["bookmarklinks"] = $bmlinks;
      }

      if (!empty( $_REQUEST["removebookmark"] ) && $user)
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
         $this->Query("UPDATE ".$this->config["user_table"]." SET ".
          "bookmarks = '".quote($this->dblink, implode("\n", $bookmarks))."' ".
          "WHERE name = '".quote($this->dblink, $user["name"])."' LIMIT 1");

         $this->SetUser($this->LoadUser($user["name"]));
         $_SESSION["bookmarks"] = $bookmarks;
         //    $_SESSION["bookmarksfmt"] = $this->Format($this->Format(implode(" | ", $bookmarks), "wacko"), "post_wacko");
         $_SESSION["bookmarksfmt"] = $this->Format(implode(" | ", $bookmarks), "wacko");
         $bmlinks = $bookmarks;
         for ($i=0;$i<count($bmlinks);$i++) $bmlinks[$i] = trim($this->NpjTranslit($bmlinks[$i]),"()");
         $_SESSION["bookmarklinks"] = $bmlinks;
      }
   }

   function GetBookmarks()  { return $_SESSION["bookmarks"]; }
   function GetBookmarksFormatted() { return $_SESSION["bookmarksfmt"]; }
   function GetBookmarkLinks()  { return $_SESSION["bookmarklinks"]; }

   // THE BIG EVIL NASTY ONE!
   function Run($tag, $method = "")
   {
      if(!($this->GetMicroTime()%3)) $this->Maintenance();
      $this->ReadInterWikiConfig();

      foreach ($this->search_engines as $engine)
      {
         if (stristr($_SERVER["HTTP_USER_AGENT"], $engine))
         {
            $this->config["default_showdatetime"] = 0;
            $this->config["show_datetime"] = "N";
         }
      }

      // do our stuff!
      if ((!$this->GetUser() && isset( $_COOKIE[$this->config["cookie_prefix"]."name"] )) && ($user = $this->LoadUser($_COOKIE[$this->config["cookie_prefix"]."name"], $_COOKIE[$this->config["cookie_prefix"]."password"]))) $this->SetUser($user);
      $user = $this->GetUser();

      if(isset($user["lang"]))
         {
            if($user["lang"] == "")
               {
                  $this->userlang = $this->GetConfigValue("language");
               }
            else
               {
                  $this->userlang = $user["lang"];
               }
         }
      else if($this->GetConfigValue("multilanguage"))
         {
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
               {
                  $this->userlang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

                  // Check whether we have language files for this language
                  if(!in_array($this->userlang, $this->AvailableLanguages()))
                     {
                        // The HTTP_ACCEPT_LANGUAGE language doesn't have any language files so use the admin set language instead
                        $this->userlang = $this->GetConfigValue("language");
                     }
               }
            else
               {
                  $this->userlang = $this->GetConfigValue("language");
               }
         }
      else
         {
            $this->userlang = $this->GetConfigValue("language");
         }

      if($this->GetConfigValue("debug") >= 2)
         {
            echo '<span class="debug">Multilanguage: '.$this->GetConfigValue("multilanguage").'<br/>';
            echo 'HTTP_ACCEPT_LANGUAGE set: '.isset($_SERVER['HTTP_ACCEPT_LANGUAGE']).'<br />';
            echo 'HTTP_ACCEPT_LANGUAGE value: '.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'<br />';
            echo 'HTTP_ACCEPT_LANGUAGE chopped value: '.strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)).'<br />';
            echo 'User language set: '.isset($user["lang"]).'<br />';
            echo 'User language: '.$user["lang"].'<br />';
            echo 'Config language: '.$this->GetConfigValue("language").'<br />';
            echo 'Current language: '.$this->userlang.'<br />';
            echo '</span>';
         }

      if (is_array($user) && $user["options"]["theme"])
      {
         $this->config["theme"] = $user["options"]["theme"];
         $this->config["theme_url"]=$this->config["root_url"]."themes/".$this->config["theme"]."/";
      }

      if (!$this->GetConfigValue("multilanguage")) $this->SetLanguage($this->GetConfigValue("language"));

      $this->LoadAllLanguages();
      $this->LoadResource($this->userlang);
      $this->SetResource($this->userlang);
      $this->SetLanguage($this->userlang);

      $wacko = &$this;

      if (!$this->method = trim($method)) $this->method = "show";
      if (!$this->tag = trim($tag)) $this->Redirect($this->href("", $this->config["root_page"]));

      if (!preg_match("/^[".$this->language["ALPHANUM_P"]."\!]+$/", $tag))
      $tag = $this->tryUtfDecode($tag);
      //    if (!$_REQUEST["add"]=="1" || $this->method=="watch" )
      $tag = str_replace("'", "_", str_replace("\\", "", str_replace("_", "", $tag)));
      $tag = preg_replace("/[^".$this->language["ALPHANUM_P"]."\_\-\.]/", "", $tag);

      //$this->tag=$this->Translit($tag, 1);
      $this->tag = $tag;
      $this->supertag = $this->NpjTranslit($tag);
      $time = isset( $_GET["time"] ) ? $_GET["time"] : "";
      $page = $this->LoadPage($this->tag, $time);
      if ($this->GetConfigValue("outlook_workaround") && !$page)
      {
         $page = $this->LoadPage($this->supertag."'", $time);
      }
      $this->SetPage($page);
      $this->LogReferrer();
      $this->SetBookmarks();

      if (!$this->GetUser() && $this->page["time"])
      header("Last-Modified: ".gmdate("D, d M Y H:i:s", strtotime($this->page["time"])+120)." GMT");;
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
         $this->current_context++;
         $this->context[$this->current_context] = $this->tag;
         $data = $this->Method($this->method);
         $this->current_context--;
         print($this->Header().$data.$this->Footer());
      }
      return $this->tag;
   }

   function AvailableThemes()
   {
      $handle=opendir("themes");
      while (false!==($file = readdir($handle))) {
         if ($file != "." && $file != ".." && is_dir("themes/".$file) && $file != ".svn" && $file != "_common")
         $themelist[] = $file;
      }
      closedir($handle);
      if ($allow = $this->GetConfigValue("allow_themes"))
      {
         $ath = explode(",",$allow);
         if (is_array($ath) && $ath[0])
         $themelist = array_intersect ($ath, $themelist);
      }
      return $themelist;
   }

   // TOC manipulations
   function SetTocArray( $toc )
   {
      $this->body_toc = "";
      foreach($toc as $k=>$v)
      $toc[$k] = implode("<poloskuns,col>", $v);
      $this->body_toc = implode("<poloskuns,row>", $toc);
   }

   function BuildToc( $tag, $from, $to, $num, $link=-1 )
   {
      if (isset($this->tocs[ $tag ])) return $this->tocs[ $tag ];
      $page = $this->LoadPage( $tag );
      if ($link === -1)
      $_link = ($this->page["tag"] != $page["tag"])?$this->Href("",$page["tag"]):"";
      else $_link = $link;
      $toc = explode( "<poloskuns,row>", $page["body_toc"] );
      foreach($toc as $k=>$v)
      $toc[$k] = explode("<poloskuns,col>", $v);
      $_toc = array();
      foreach($toc as $k=>$v)
      if ($v[2] == 99999)
      {
         if (!in_array($v[0],$this->toc_context))
         if (!($v[0] == $this->tag))
         {
            array_push($this->toc_context, $v[0]);
            $_toc = array_merge( $_toc, $this->BuildToc( $v[0], $from, $to, $num, $link ) );
            array_pop($this->toc_context);
         }
      }
      else
      if ($v[2] == 77777)
      {
         $toc[$k][3] = $_link;
         $_toc[] = &$toc[$k];
      }
      else
      if (($v[2] >= $from) && ($v[2] <= $to))
      {
         $toc[$k][3] = $_link;
         $_toc[] = &$toc[$k];
         $toc[$k][1] = $this->Format($toc[$k][1], "post_wacko");
      }
      $this->tocs[ $tag ] = $_toc;
      return $_toc;
   }

   function NumerateToc( $what ) // numerating toc using prepared "$this->post_wacko_toc"
   { if (!is_array($this->post_wacko_action)) return $what;
   // #1. hash toc
   $hash = array();
   foreach( $this->post_wacko_toc as $v )
   $hash[ $v[0] ] = $v;
   $this->post_wacko_toc_hash = &$hash;
   if ($this->post_wacko_action["toc"])
   {
      // #2. find all <a></a><hX> & guide them in subroutine
      //     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
      $what = preg_replace_callback( "!(<a name=\"(h[0-9]+-[0-9]+)\"></a><h([0-9])>(.*?)</h\\3>)!i",
      array( &$this, "NumerateTocCallbackToc"), $what );
   }
   if ($this->post_wacko_action["p"])
   {
      // #2. find all <a></a><p...> & guide them in subroutine
      //     notice that complex regexp is copied & duplicated in formatters/paragrafica (subject to refactor)
      $what = preg_replace_callback( "!(<a name=\"(p[0-9]+-[0-9]+)\"></a><p([^>]+)>(.+?)</p>)!is",
      array( &$this, "NumerateTocCallbackP"), $what );
   }
   return $what;
   }

   function NumerateTocCallbackToc( $matches )
   {
      return '<a name="'.$matches[2].'"></a><h'.$matches[3].'>'.
      ($this->post_wacko_toc_hash[$matches[2]][1]?$this->post_wacko_toc_hash[$matches[2]][1]:$matches[4]).
          '</h'.$matches[3].'>';
   }

   var $paragrafica_styles = array(
    "before"  =>
   array( "_before"=>"", "_after"=>"", "before"=> "<span class='pmark'>[##]</span><br />", "after"=>"" ),
    "after"  =>
   array( "_before"=>"", "_after"=>"", "before"=> "", "after"=>" <span class='pmark'>[##]</span>" ),
    "right" =>
   array( "_before"=>"<div class='pright'><div class='p-'>&nbsp;<span class='pmark'>[##]</span></div><div class='pbody-'>", "_after"=>"</div></div>", "before"=> "", "after"=>"" ),
    "left" =>
   array( "_before"=>"<div class='pleft'><div class='p-'><span class='pmark'>[##]</span>&nbsp;</div><div class='pbody-'>", "_after"=>"</div></div>", "before"=> "", "after"=>"" ),
   );
   var $paragrafica_patches = array(
    "before" => array("before"),
    "after"  => array("after"),
    "right"  => array("_before"),
    "left"  => array("_before"),
   );
   function NumerateTocCallbackP( $matches )
   {
      $before=""; $after="";
      if (!($style = $this->paragrafica_styles[ $this->post_wacko_action["p"] ]))
      { $this->post_wacko_action["p"] = "before";
      $style = $this->paragrafica_styles[ "before" ];
      }
      $len = strlen("".$this->post_wacko_maxp);
      $link = '<a href="#'.$matches[2].'">'.
      str_pad($this->post_wacko_toc_hash[$matches[2]][66],$len,"0",STR_PAD_LEFT).
           '</a>';
      foreach ( $this->paragrafica_patches[ $this->post_wacko_action["p"] ] as $v )
      $style[$v] = str_replace( "##", $link, $style[$v] );

      return $style["_before"].'<a name="'.$matches[2].'"></a><p'.$matches[3].'>'.
      $style["before"].$matches[4].$style["after"].
          '</p>'.$style["_after"];
   }

   // BREADCRUMBS -- additional navigation added with WackoClusters
   function GetPagePath($separator='/') {
      $steps = explode('/', $this->tag);
      $result = '';

      for ($i=0;$i<count($steps);$i++)
      {
         $link = '';
         for($j=0;$j<$i+1;$j++)
         $link .= '/'.$steps[$j];

         # camel case'ing
         $linktext = preg_replace('([A-Z][a-z])', ' ${0}', $steps[$i]);

         if ($i == count($steps)-1)
         $result .= $linktext;
         else
         $result .= $this->Link($link, '', $linktext) . $separator;
      }
      return $result;
   }


   function RenamePage($tag, $NewTag, $NewSuperTag="")
   {
      if ($NewSuperTag=="")
      $NewSuperTag = $this->NpjTranslit($NewTag);

      return $this->Query("UPDATE ".$this->config["table_prefix"]."revisions SET tag = '".quote($this->dblink, $NewTag)."', supertag = '".quote($this->dblink, $NewSuperTag)."' WHERE tag = '".quote($this->dblink, $tag)."' ") &&
      $this->Query("UPDATE ".$this->config["table_prefix"]."pages  SET tag = '".quote($this->dblink, $NewTag)."', supertag = '".quote($this->dblink, $NewSuperTag)."' WHERE tag = '".quote($this->dblink, $tag)."' ");
   }

   function RenameFiles($tag, $NewTag, $NewSuperTag="")
   {
      if($NewSuperTag=="")
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

   function RenameAcls($tag, $NewTag, $NewSuperTag="") {
      if ($NewSuperTag=="")
      $NewSuperTag = $this->NpjTranslit($NewTag);
      return $this->Query("UPDATE ".$this->config["table_prefix"]."acls SET page_tag = '".quote($this->dblink, $NewTag)."', supertag = '".quote($this->dblink, $NewSuperTag)."' WHERE page_tag = '".quote($this->dblink, $tag)."' ");
   }

   function RenameComments($tag, $NewTag, $NewSuperTag="") {
      return $this->Query("UPDATE ".$this->config["table_prefix"]."pages SET comment_on = '".quote($this->dblink, $NewTag)."'  WHERE comment_on = '".quote($this->dblink, $tag)."' ");
   }

   function RenameWatches($tag, $NewTag, $NewSuperTag="") {
      return $this->Query("UPDATE ".$this->config["table_prefix"]."pagewatches SET tag = '".quote($this->dblink, $NewTag)."' WHERE tag = '".quote($this->dblink, $tag)."' ");
   }

   function RenameLinks($tag) {
      return $this->Query("UPDATE ".$this->config["table_prefix"]."links SET from_tag = '".quote($this->dblink, $NewTag)."' WHERE from_tag = '".quote($this->dblink, $tag)."' ");
   }

   function CheckFileExists( $filename, $unwrapped_tag = "" )
   {
      if ($unwrapped_tag == "") $page_id=0;
      else
      { $page = $this->LoadPage($unwrapped_tag, "", LOAD_CACHE, LOAD_META);
      $page_id=$page["id"];
      if (!$page_id) return false;
      }
      if (!($file = $this->filesCache[$page_id][$filename]))
      {
         $what = $this->LoadAll( "SELECT id, filename, filesize, description, picture_w, picture_h, file_ext FROM ".$this->config["table_prefix"]."upload WHERE ".
                            "page_id = '".quote($this->dblink, $page_id)."' AND filename='".quote($this->dblink, $filename)."'");
         if (sizeof($what) == 0) return false;
         $file = $what[0];
         $this->filesCache[$page_id][$filename] = $file;
      }
      return $file;
   }

   function GetKeywords()
   {
      if ($this->page["keywords"]) return $this->page["keywords"];
      else return $this->GetConfigValue("meta_keywords");
   }

   function GetDescription()
   {
      if ($this->page["description"]) return $this->page["description"];
      else return $this->GetConfigValue("meta_description");
   }

}
?>