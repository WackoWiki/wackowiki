<?php
/**
 * Highlight XHTML Markup
 *
 * @author Davey Shafik <davey@php.net>
 * @copyright Copyright 2003 Davey Shafik and Synaptic Media. All Rights Reserved.
 */
$options['color']['tags'] = "#000080";
$options['color']['attributes'] = "#800000";
$options['color']['other'] = "#A6A6A6";
$options['color']['comment'] = "gray";
$options['color']['attributevalues'] = "blue";
$options['color']['entities'] = "orange";
$options['line_numbers'] = false;

$xhtml_tags = array(
  "!DOCTYPE",
  "a",
  "abbr",
  "acronym",
  "address",
  "applet",
  "area",
  "b",
  "base",
  "basefont",
  "bgsound",
  "bdo",
  "big",
  "blink",
  "blockquote",
  "body",
  "br",
  "button",
  "caption",
  "center",
  "cite",
  "code",
  "col",
  "colgroup",
  "comment",
  "dd",
  "del",
  "dfn",
  "dir",
  "div",
  "dl",
  "dt",
  "em",
  "embed",
  "fieldset",
  "font",
  "form",
  "frame",
  "frameset",
  "h",
  "h1",
  "h2",
  "h3",
  "h4",
  "h5",
  "h6",
  "head",
  "hr",
  "hta:application",
  "html",
  "i",
  "iframe",
  "img",
  "input",
  "ins",
  "isindex",
  "kbd",
  "label",
  "legend",
  "li",
  "link",
  "listing",
  "map",
  "marquee",
  "menu",
  "meta",
  "multicol",
  "nextid",
  "nobr",
  "noframes",
  "noscript",
  "object",
  "ol",
  "optgroup",
  "option",
  "p",
  "param",
  "plaintext",
  "pre",
  "q",
  "s",
  "samp",
  "script",
  "select",
  "server",
  "small",
  "sound",
  "spacer",
  "span",
  "strike",
  "strong",
  "style",
  "sub",
  "sup",
  "table",
  "tbody",
  "td",
  "textarea",
  "textflow",
  "tfoot",
  "th",
  "thead",
  "title",
  "tr",
  "tt",
  "u",
  "ul",
  "var",
  "wbr",
  "xmp"
  );

  $source = htmlspecialchars($text);

  $source = preg_replace(
             '/&lt;!--(.*?)--&gt;/es',
             '"<span style=\"color: ".$options["color"]["comment"].";\">&lt;!--".
             str_replace("&lt;","&lt;<!-- -->",
             str_replace("=","=<!-- -->",
             "$1")).
             "--&gt;</span>"',
  $source);

  $source = preg_replace(
             '/(&lt;style.*?&gt;)(.*?)&lt;\/style&gt;/es',
             '"$1".
             $this->format("$2", "highlight/css", array("nopre" => true, "notypo" => false)).
             "&lt;/style&gt;"',
  $source);

  foreach($xhtml_tags as $i) {
   $source = preg_replace('/&lt;' . $i . '(&gt;|[[:space:]])/', '<span style="color: ' .$options['color']['tags']. ';font-weight:bold;">&lt;' .$i. '\\1</span>', $source);
   $source = str_replace('&lt;/' .$i. '&gt;','<span style="color: ' .$options['color']['tags']. ';font-weight:bold;">&lt;/' .$i. '&gt;</span>',$source);
  }

  $source = str_replace('/&gt;','<span style="color: ' .$options['color']['tags']. ';font-weight:bold;">/&gt;</span>',$source);
  $source = preg_replace(
  '/([[:space:]]|&quot;|\'|\?)&gt;/',
  '\\1<span style="color: ' .$options['color']['tags']. ';font-weight:bold;">&gt;</span>',
  $source);

  $source = preg_replace( "/([a-z-]+)=(&quot;|\')(.*?)\\2/i",
             '<span style="color: ' .$options['color']['attributes']. ';font-weight:bold;">$1=</span><span style="color: '
             .$options['color']['attributevalues']. ';">$2$3$2</span>', $source);
             $source = preg_replace("/&amp;([a-z0-9]*?;)/i", '&amp;<span style="color: ' .$options['color']['entities']. ';">$1</span>', $source);

             if ($options['line_numbers'] == true) {
             	$lines = preg_split("/(\n|<br \/>)/s",$source);
             	$source = '<ol>';
             	$i = 0;
             	foreach ($lines as $line) {
             		$i += 1;
             		$source .= '<li id="l' .$i. '">' .rtrim($line). "</li>";
             	}
             	$source .= '</ol>';
             }

             echo "<!--no"."typo-->";
             echo "<pre class=\"code\">";
             echo  str_replace("\t","  ",$source);
             echo "</pre>";
             echo "<!--/no"."typo-->";
             ?>
