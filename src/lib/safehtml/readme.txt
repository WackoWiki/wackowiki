SafeHTML
--------
Version 1.3.12.
https://wackowiki.org/doc/Dev/Projects/SafeHTML
--------

This parser strips down all potentially dangerous content within HTML:
  * opening tag without its closing tag
  * closing tag without its opening tag
  * any of these tags: "base", "basefont", "head", "html", "body", "applet", "object", 
    "iframe", "frame", "frameset", "script", "layer", "ilayer", "embed", "bgsound", 
    "link", "meta", "style", "title", "blink", "xml" etc.
  * any of these attributes: on*, data*, dynsrc
  * javascript:/vbscript:/about: etc. protocols
  * expression/behavior etc. in styles
  * any other active content
It also tries to convert code to XHTML valid, but htmltidy is far better solution for this task.

If you found any bugs in this parser, please file an issue -- https://wackowiki.org/bugs/

Please, subscribe to https://wackowiki.org/doc/Dev/Projects/SafeHTML in order to receive notices 
when SAFEHTML will be updated.

-- Roman Ivanov.
-- Pixel-Apes ( http://pixel-apes.com ).
-- JetStyle ( http://jetstyle.ru/ ).



--------
Version history:
--------
1.3.12
 * added missing HTML5 tag terminators for paragraph
 * removed obsolete and deprecated HTML elements
1.3.11.
 * added new HTML5 Block-level elements
1.3.10.
 * Replaced preg_replace() e modifier with preg_replace_callback
1.3.9.
 * UTF-7 XSS vulnerability fixed
1.3.8.
 * Allowed tags with setAllowTags() method.
 * AllowTags can be disabled using resetAllowTags()
1.3.7.
 * Added 'dl' to the list of 'lists' tags.
 * Added 'callto' to the white list of protocols.
 * Added white list of "namespaced" attributes.
1.3.6.
 * More accurate UTF-7 decoding.
1.3.5.
 * Two serious security flaws fixed: UTF-7 XSS and CSS comments handling.
1.3.2.
 * Security flaw (improper quotes handling in attributes' values) fixed. Big thanks to Nick Cleaton.
1.3.1.
 * Dumb bug fixed (some closing tags were ignored).
1.3.0.
 * Two holes (with decimal HTML entities and with \x00 symbol) fixed.
 * Class rewritten under PEAR coding standards.
 * Class now uses unmodified HTMLSax3 from PEAR.
 * To the list of table tags added: "caption", "col", "colgroup".
1.2.1.
 * It was possible to create XSS with hexadecimal HTML entities. Fixed. Big thanks to Christian Stocker.
1.2.0.
 * "id" and "name" attributes added to dangerous attributes list, because malefactor can broke legal javascript by spoofing ID or NAME of some element.
 * New method parse() allows to do all parsing process in two lines of code. Examples also updated.
 * New array, closeParagraph, contains list of block-level elements. When we open such element, we should close paragraph before. . It allows SafeHTML to produce more XHTML compliant code.
 * Added "webcal" to white list of protocols for those who uses calendar programs (Mozilla/iCal/etc).
 * Now SafeHTML strips down table elements when we are not inside table.
 * Now SafeHTML correctly closes unclosed "li" tags: before opening "li" of the same nesting level.
1.1.0.
 * New "dangerous" protocols: hcp, ms-help, help, disk, vnd.ms.radio, opera, res, resource, chrome, mocha, livescript.
 * <XML> tag was moved from "tags for deletion" to "tags for deletion with content".
 * New "dangerous" CSS instruction "include-source" (NN4 specific).
 * New array, Attributes, contains list of attributes for removal. If you need to remove "id" or "name" attribute, 
 just add it to this array.
 * Now it is possible to choose between white-list and black-list filtering of protocols. Defaults are "white-list".
 This list is: "http", "https", "ftp", "telnet", "news", "nntp", "gopher", "mailto", "file".
 * For speed purposes, we now filter protocols only from these attributes: src, href, action, lowsrc, dynsrc, 
 background, codebase.
 * Opera6 XSS bug ([\xC0][\xBC]script>alert(1)[\xC0][\xBC]/script> [UTF-8] workarounded.
1.0.4.
 New "dangerous" tag: plaintext.
1.0.3.
 Added array of elements that can have no closing tag.
1.0.2.
 Bug fix: <img src="&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;alert(1);"> attack.
 Thanks to shmel.
1.0.1.
 Bug fix: safehtml hangs on <style></style></style> code.
 Thanks to lj user=electrocat.
1.0.0.
 First public release
