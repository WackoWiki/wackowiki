<?php

// {{Redirect to="!/NewPage" permanent="0 or 1"}}

$page = $this->UnwrapLink($vars[0]);
$is_permanent = $vars[1];

if ($page)
   {
      if ($is_permanent)
         {
            header("HTTP/1.0 301 Moved Permanently");
         }

      if ($this->LoadPage($page, "", LOAD_CACHE, LOAD_META))
         {
            if ($user = $this->GetUser())
               {
                  if ($user["options"]["dont_redirect"] == "Y" || $_REQUEST["redirect"] == "no")
                     {
                        print ("<br /><br /><br />".$this->GetTranslation("PageMoved")." ".$this->Link("/".$page)."<br /><br /><br />");
                     }
                  else
                     $this->Redirect($this->href("", $page));
               }
            else
               $this->Redirect($this->href("", $page));
         }
      else
         {
            print ("<i>".$this->GetTranslation("WrongPage4Redirect")."</i>");
         };
   };
?>