<?php
$vars[0] = $this->UnwrapLink($vars[0]);

if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track)
$this->TrackLinkTo($vars[0]);

if (in_array($vars[0],$this->context)) return;
if ($vars[0] == $this->tag) return;

if (! $this->HasAccess("read",$vars[0])){
   if ($nowarning != 1) echo $this->GetResourceValue("NoAccessToSourcePage");
}else{
   if (!$inc_page = $this->LoadPage($vars[0], $_GET["time"])){
      echo "<em> ".$this->GetResourceValue("SourcePageDoesntExist")."(".$this->Link("/".$vars[0]).")</em>";
   }else{
      if ($inc_page["body_r"]) $strings = $inc_page["body_r"];
      else $strings = $this->Format($inc_page["body"], "wacko");
      $strings = preg_replace("/\¡\¡toc[^\¡]*\¡\¡/i","",$strings);
      $strings = preg_replace("/\¡\¡tableofcontents[^\¡]*\¡\¡/i","",$strings);
      $strings = preg_replace("/\¡\¡p[^\¡]*\¡\¡/i","",$strings);
      $strings = preg_replace("/\¡\¡showparagraphs[^\¡]*\¡\¡/i","",$strings);
      $strings = preg_replace("/\¡\¡redirect[^\¡]*\¡\¡/i","",$strings);
      $strings = preg_replace("/.*\¡\¡a name=\"?$first_anchor\"?\¡\¡(.*)\¡\¡a name=\"?$last_anchor\"?\¡\¡.*$/is","\$1",$strings);

      if (($this->GetMethod() != "print") && ($nomark!=1) && ($nomark!=2 || $this->HasAccess("write", $vars[0])))
      print "<div class=\"include\">"."<div class=\"name\">".$this->Link("/".$vars[0])."&nbsp;&nbsp;::&nbsp;".
                          "<a href=\"".$this->Href("edit", $vars[0])."\">".$this->GetResourceValue("EditIcon")."</a></div>";

      $this->context[++$this->current_context] = $vars[0];
      print $this->Format($strings, "post_wacko");
      $this->context[$this->current_context] = "~~"; // clean stack
      $this->current_context--;

      if (($this->GetMethod() != "print") && ($nomark!=1) && ($nomark!=2 || $this->HasAccess("write", $vars[0])))
      print "<div class=\"name\">".$this->Link("/".$vars[0])."&nbsp;&nbsp;::&nbsp;".
                          "<a href=\"".$this->Href("edit", $vars[0])."\">".$this->GetResourceValue("EditIcon")."</a></div></div>";
   };
}

?>