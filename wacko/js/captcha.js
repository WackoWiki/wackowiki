function new_freecap()
{
   if(document.getElementById)
      {
         thesrc = document.getElementById("freecap").src;
         thesrc = thesrc.substring(0, thesrc.lastIndexOf(".") + 4);
         document.getElementById("freecap").src = thesrc + "?" + Math.round(Math.random() * 100000);
      }
   else
      {
         alert("<?php echo $this->get_translation('CaptchaReloadWarning');?>");
      }
}