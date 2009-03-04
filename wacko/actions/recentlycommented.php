<?php

if (!function_exists('LoadRecentlyCommented')){
   function LoadRecentlyCommented(&$wacko, $for = "", $limit = 50)
   {
      // NOTE: this is really stupid. Maybe my SQL-Fu is too weak, but apparently there is no easier way to simply select
      //       all comment pages sorted by their first revision's (!) time. ugh!

      // load ids of the first revisions of latest comments. err, huh?
      if ($ids = $wacko->LoadAll("SELECT MIN(id) AS id FROM ".$wacko->config["table_prefix"]."pages WHERE ".
      ($for?"super_comment_on LIKE '".quote($wacko->dblink, $wacko->NpjTranslit($for))."/%' ":"comment_on != '' ").
                "GROUP BY tag ORDER BY id DESC"));
      {
         // load complete comments
         if ($ids)
         foreach ($ids as $id)
         {
            $comment = $wacko->LoadSingle("SELECT * FROM ".$wacko->config["table_prefix"]."pages WHERE id = '".$id["id"]."' LIMIT 1");
            if (!$comments[$comment["comment_on"]] && $num < $limit)
            {
               $comments[$comment["comment_on"]] = $comment;
               $num++;
            }
         }

         // now load pages
         if ($comments)
         {
            // now using these ids, load the actual pages
            foreach ($comments as $comment)
            {
               $page = $wacko->LoadPage($comment["comment_on"]);
               $page["comment_user"] = $comment["user"];
               $page["comment_time"] = $comment["time"];
               $page["comment_tag"] = $comment["tag"];
               $pages[] = $page;
            }
         }
      }
      return $pages;
   }
}

if (!isset($root)) $root = $this->UnwrapLink($vars[0]);
if (!isset($root)) $root = $this->page["tag"];
if (!$max)  $max = 50;

if ($pages = LoadRecentlyCommented($this, $root, (int)$max))
{
   if ($root=="" && !(int)$noxml)  print("<a href=\"".$this->GetConfigValue("root_url")."xml/recentcomment_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name"))).".xml\"><img src=\"".$this->GetConfigValue("theme_url")."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentCommentsXMLTip")."\" alt=\"XML\" /></a><br /><br />");
   foreach ($pages as $page)
   {
      if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
      else $access = true;
      if ($access && $this->UserAllowedComments())
      {
         // day header
         list($day, $time) = explode(" ", $page["comment_time"]);
         if ($day != $curday)
         {
            if ($curday) print("<br />\n");
            print("<strong>$day:</strong><br />\n");
            $curday = $day;
         }

         // print entry
         print("&nbsp;&nbsp;&nbsp;<span class=\"dt\">".$time."</span> &mdash; (<a href=\"".
         $this->href("", $page["tag"], "show_comments=1")."#comments\">".$page["tag"]."</a>".
              ") . . . . . . . . . . . . . . . . <small>".$this->GetTranslation("LatestCommentBy")." ".
         ($this->IsWikiName($page["comment_user"])?$this->Link("/".$page["comment_user"],"",$page["comment_user"] ):$page["comment_user"])."</small><br />\n");
      }
   }
}
else
{
   echo $this->GetTranslation("NoRecentlyCommented");
}

?>