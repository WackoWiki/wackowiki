function new_freecap()
{
         thesrc = document.getElementById("freecap").src;
         if (thesrc.indexOf("&") !== -1) 
	    {
         	thesrc = thesrc.substring(0, thesrc.lastIndexOf("&"));
            }
	 document.getElementById("freecap").src = thesrc + "&" + Math.round(Math.random() * 100000);
}