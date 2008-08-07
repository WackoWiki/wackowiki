         <form action="<?php echo myLocation() ?>?installAction=version-check" method="post">
            <p><?php echo $lang["LangDesc"];?></p>
<?php
   // http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
   $lang_codes = array();
   $lang_codes["bg"] = "Bulgarian";
   $lang_codes["bg"] = "Bulgarian";
   $lang_codes["da"] = "Danish";
   $lang_codes["de"] = "German";
   $lang_codes["ee"] = "Ewe";
   $lang_codes["en"] = "English";
   $lang_codes["el"] = "Greek";
   $lang_codes["es"] = "Spanish";
   $lang_codes["fr"] = "French";
   $lang_codes["it"] = "Italian";
   $lang_codes["nl"] = "Dutch";
   $lang_codes["pl"] = "Polish";
   $lang_codes["ru"] = "Russian";

   foreach($lang_codes as $key => $value)
      {
         echo "               <input type=\"radio\" id=\"lang_".$key."\" name=\"config[language]\" value=\"".$key."\"".($wakkaConfig["language"] == $key ? "checked=\"checked\"" : "")." class=\"input_lang\"><label for=\"lang_".$key."\" class=\"label_lang\">".$value." (".$key.")</label>\n<br />\n";
      }
?>
            <input type="submit" value="<?php echo $lang["Continue"];?>" class="next" />
         </form>
