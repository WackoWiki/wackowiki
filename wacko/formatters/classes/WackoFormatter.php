<?php
/*

WackoFormatter.
v2.2.2.
10 January 2005.

*/
class WackoFormatter
{
	var $object;
	var $oldIndentLevel = 0;
	var $indentClosers = array();
	var $tdoldIndentLevel = 0;
	var $tdindentClosers = array();
	var $br = 1;
	var $intable = 0;
	var $intablebr = 0;
	var $cols = 0;
	var $z_gif = "&nbsp;";
	var $colors = array(
   "indianred" => "indianred" ,
   "lightcoral" => "lightcoral" ,
   "orangered" => "orangered" ,
   "crimson" => "crimson" ,
   "darkred" => "darkred" ,
   "pink" => "pink" ,
   "hotpink" => "hotpink" ,
   "palevioletred" => "palevioletred" ,
   "khaki" => "khaki" ,
   "lightgoldenrodyellow" => "lightgoldenrodyellow" ,
   "lemonchiffon" => "lemonchiffon" ,
   "gold" => "gold" ,
   "moccasin" => "moccasin" ,
   "cyan" => "cyan" ,
   "aquamarine" => "aquamarine" ,
   "mediumturquoise" => "mediumturquoise" ,
   "cadetblue" => "cadetblue" ,
   "lightcyan" => "lightcyan" ,
   "powderblue" => "powderblue" ,
   "steelblue" => "steelblue" ,
   "skyblue" => "skyblue" ,
   "deepskyblue" => "deepskyblue" ,
   "royalblue" => "royalblue" ,
   "dodgerblue" => "dodgerblue" ,
   "mediumblue" => "mediumblue" ,
   "navy" => "navy" ,
   "lightsalmon" => "lightsalmon" ,
   "darkorange" => "darkorange" ,
   "tomato" => "tomato" ,
   "aquamarine" => "aquamarine" ,
   "springgreen" => "springgreen" ,
   "greenyellow" => "greenyellow" ,
   "lawngreen" => "lawngreen" ,
   "lightgreen" => "lightgreen" ,
   "limegreen" => "limegreen" ,
   "darkseagreen" => "darkseagreen" ,
   "seagreen" => "seagreen" ,
   "olivedrab" => "olivedrab" ,
   "darkolivegreen" => "darkolivegreen" ,
   "mediumaquamarine" => "mediumaquamarine" ,
   "lightseagreen" => "lightseagreen" ,
   "teal" => "teal" ,
   "thistle" => "thistle" ,
   "violet" => "violet" ,
   "magenta" => "magenta" ,
   "mediumorchid" => "mediumorchid" ,
   "blueviolet" => "blueviolet" ,
   "mediumpurple" => "mediumpurple" ,
   "purple" => "purple" ,
   "darkslateblue" => "darkslateblue" ,
   "honeydew" => "honeydew" ,
   "azure" => "azure" ,
   "ghostwhite" => "ghostwhite" ,
   "lavenderblush" => "lavenderblush" ,
   "antiquewhite" => "antiquewhite" ,
   "snow" => "snow" ,
   "beige" => "beige" ,
   "oldlace" => "oldlace" ,
   "ivory" => "ivory" ,
   "lightgrey" => "lightgrey" ,
   "darkgray" => "darkgray" ,
   "dimgray" => "dimgray" ,
   "lightslategray" => "lightslategray" ,
   "cornsilk" => "cornsilk" ,
   "bisque" => "bisque" ,
   "wheat" => "wheat" ,
   "goldenrod" => "goldenrod" ,
   "peru" => "peru" ,
   "maroon" => "maroon" ,
   "brown" => "brown" ,
   "darkred" => "darkred" ,
   "tan" => "tan" ,
   "black" => "black" ,
   "darksalmon" => "darksalmon" ,
   "salmon" => "salmon" ,
   "red" => "red" ,
   "firebrick" => "firebrick" ,
   "mediumvioletred" => "mediumvioletred" ,
   "lightpink" => "lightpink" ,
   "deeppink" => "deeppink" ,
   "darkkhaki" => "darkkhaki" ,
   "palegoldenrod" => "palegoldenrod" ,
   "lightyellow" => "lightyellow" ,
   "yellow" => "yellow" ,
   "papayawhip" => "papayawhip" ,
   "peachpuff" => "peachpuff" ,
   "aqua" => "aqua" ,
   "turquoise" => "turquoise" ,
   "darkturquoise" => "darkturquoise" ,
   "slategray" => "slategray" ,
   "paleturquoise" => "paleturquoise" ,
   "lightsteelblue" => "lightsteelblue" ,
   "lightblue" => "lightblue" ,
   "lightskyblue" => "lightskyblue" ,
   "cornflowerblue" => "cornflowerblue" ,
   "mediumslateblue" => "mediumslateblue" ,
   "blue" => "blue" ,
   "darkblue" => "darkblue" ,
   "midnightblue" => "midnightblue" ,
   "orange" => "orange" ,
   "coral" => "coral" ,
   "orangered" => "orangered" ,
   "mediumspringgreen" => "mediumspringgreen" ,
   "palegreen" => "palegreen" ,
   "chartreuse" => "chartreuse" ,
   "lime" => "lime" ,
   "yellowgreen" => "yellowgreen" ,
   "mediumseagreen" => "mediumseagreen" ,
   "forestgreen" => "forestgreen" ,
   "green" => "green" ,
   "olive" => "olive" ,
   "darkgreen" => "darkgreen" ,
   "turquoise" => "turquoise" ,
   "darkcyan" => "darkcyan" ,
   "lavender" => "lavender" ,
   "plum" => "plum" ,
   "fuchsia" => "fuchsia" ,
   "orchid" => "orchid" ,
   "darkorchid" => "darkorchid" ,
   "darkviolet" => "darkviolet" ,
   "slateblue" => "slateblue" ,
   "darkmagenta" => "darkmagenta" ,
   "indigo" => "indigo" ,
   "mintcream" => "mintcream" ,
   "aliceblue" => "aliceblue" ,
   "whitesmoke" => "whitesmoke" ,
   "mistyrose" => "mistyrose" ,
   "seashell" => "seashell" ,
   "white" => "white" ,
   "linen" => "linen" ,
   "floralwhite" => "floralwhite" ,
   "gainsboro" => "gainsboro" ,
   "silver" => "silver" ,
   "gray" => "gray" ,
   "darkslategray" => "darkslategray" ,
   "slategray" => "slategray" ,
   "blanchedalmond" => "blanchedalmond" ,
   "navajowhite" => "navajowhite" ,
   "sandybrown" => "sandybrown" ,
   "darkgoldenrod" => "darkgoldenrod" ,
   "chocolate" => "chocolate" ,
   "saddlebrown" => "saddlebrown" ,
   "sienna" => "sienna" ,
   "burlywood" => "burlywood" ,
   "rosybrown" => "rosybrown" ,
	);

	function WackoFormatter( &$object )
	{
		$this->object = &$object;
		$this->LONGREGEXP =
"/(".
"\xa5\xa5.*?\xa5\xa5|".($this->object->GetConfigValue("allow_rawhtml")==1?"\<\#.*?\#\>|":"").
"\(\?(\S+?)([ \t]+([^\n]+?))?\?\)|".
		($this->object->GetConfigValue("disable_bracketslinks")==1?"":
 "\[\[(\S+?)([ \t]+([^\n]+?))?\]\]|\(\((\S+?)([ \t]+([^\n]+?))?\)\)|"
		).
"\^\^\S*?\^\^|vv\S*?vv|".
"\n[ \t]*>+[^\n]*|".
"<\[.*?\]>|".
"\+\+\S\+\+|\+\+(\S[^\n]*?\S)\+\+|".
"\b[[:alpha:]]+:\/\/\S+|mailto\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\_\.]+|\?\?\S\?\?|\?\?(\S.*?\S)\?\?|".
"\\\\\\\\[".$object->language["ALPHANUM_P"]."\-\_\\\!\.]+|".
"\*\*[^\n]*?\*\*|\#\#[^\n]*?\#\#|\�\�[^\n]*?\�\�|\'\'.*?\'\'|\!\!\S\!\!|\!\!(\S.*?\S)\!\!|__[^\n]*?__|".
"\xA4\xA4\S\xA4\xA4|\xA3\xA3\S\xA3\xA3|\xA4\xA4(\S.*?\S)\xA4\xA4|\xA3\xA3(\S.*?\S)\xA3\xA3|".
"\#\|\||\#\||\|\|\#|\|\#|\|\|.*?\|\||".
"<|>|\/\/[^\n]*?(?<!http:|https:|ftp:|file:|nntp:)\/\/|".
"\n[ \t]*=======.*?={2,7}|\n[ \t]*======.*?={2,7}|\n[ \t]*=====.*?={2,7}|\n[ \t]*====.*?={2,7}|\n[ \t]*===.*?={2,7}|\n[ \t]*==.*?={2,7}|".
"[-]{4,}|---\n?\s*|--\S--|--(\S.*?[^- \t\n\r])--|".
"\n(\t+|([ ]{2})+)(-|\*|([a-zA-Z]|([0-9]{1,3}))[\.\)](\#[0-9]{1,3})?)?|".
"\b[[:alnum:]]+[:][".$object->language["ALPHANUM_P"]."\!\.][".$object->language["ALPHANUM_P"]."\-\_\.\+\&\=\#]+|".
"~([^ \t\n]+)|".
		($this->object->GetConfigValue("disable_tikilinks")==1?
 "":"\b(".$object->language["UPPER"].$object->language["LOWER"].$object->language["ALPHANUM"]."*\.".$object->language["ALPHA"].$object->language["ALPHANUM"]."+)\b|").
		($this->object->GetConfigValue("disable_wikilinks")==1?
 "":"(~?)(?<=[^\.".$object->language["ALPHANUM_P"]."]|^)(((\.\.|!)?\/)?".$object->language["UPPER"].$object->language["LOWER"]."+".$object->language["UPPERNUM"].$object->language["ALPHANUM"]."*)\b|").
		($this->object->GetConfigValue("disable_npjlinks")==1?
 "":"(~?)".$object->language["ALPHANUM"]."+\@".$object->language["ALPHA"]."*(?!".$object->language["ALPHANUM"]."*\.".$object->language["ALPHANUM"]."+)(\:".$object->language["ALPHANUM"]."*)?|".$object->language["ALPHANUM"]."+\:\:".$object->language["ALPHANUM"]."+|").
"\n)/sm";
		$this->NOTLONGREGEXP = "/(".($this->object->GetConfigValue("disable_formatters")==1?"":"\%\%.*?\%\%|").
"~([^ \t\n]+)|".
"\"\".*?\"\"|".
"\{\{[^\n]*?\}\}|".
"\xa5\xa5.*?\xa5\xa5".
")/sm";
		$this->MOREREGEXP = "/(>>.*?<<|".
"~([^ \t\n]+)|".
"\xa5\xa5.*?\xa5\xa5".
")/sm";
	}

	function IndentClose()
	{
		$result = '';
		if ($this->intable) $Closers = &$this->tdindentClosers;
		else $Closers = &$this->indentClosers;
		$c = count($Closers);
		for ($i = 0; $i < $c; $i++)
		$result .= array_pop($Closers);
		if ($this->intable) $this->tdoldIndentLevel = 0;
		else $this->oldIndentLevel = 0;
		return $result;
	}

	function WackoPreprocess($things)
	{
		$thing = $things[1];
		$wacko = &$this->object;
		$callback = array( &$this, "wackoPreprocess");

		if ($thing{0} == "~")
		if ($thing{1} == "~") return "~~".$this->WackoPreprocess( array(0,substr($thing,2)) );

		// escaped text
		if (preg_match("/^\xa5\xa5(.*)\xa5\xa5$/s", $thing, $matches))
		{
			return $matches[1];
		}
		// escaped text
		else if (preg_match("/^\"\"(.*)\"\"$/s", $thing, $matches))
		{
			return "\xa5\xa5<!--notypo-->".str_replace("\n","<br />",htmlspecialchars($matches[1]))."<!--/notypo-->\xa5\xa5";
		}
		// code text
		else if (preg_match("/^\%\%(.*)\%\%$/s", $thing, $matches))
		{
			// check if a formatter has been specified
			$code = $matches[1];
			if (preg_match("/^\(([^\n]+?)\)(.*)$/s", $code, $matches))
			{
				$code = $matches[2];
				if ($matches[1])
				{
					// check for formatter parameters
					$sep = strpos( $matches[1], " ");
					if ($sep === false)
					{
						$formatter = $matches[1];
						$params = array();
					}
					else
					{
						$formatter = substr( $matches[1], 0, $sep );
						$p = " ".substr( $matches[1], $sep )." ";
						$paramcount = preg_match_all( "/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/", $p,
						$matches, PREG_SET_ORDER );
						$params = array();  $c=0;
						foreach( $matches as $m )
						{
							$value = $m[3]?($m[5]?$m[6]:$m[7]):"1";
							$params[$c] = $value;
							$params[ $m[2] ] = $value;
							if ($c==0) $params["_default"] = $m[2];
							$c++;
						}
					}
				}
			}
			$formatter = strtolower($formatter);
			if ($formatter=="\xF1") $formatter="c";
			if ($formatter=="c") $formatter="comments";
			if ($formatter=="") $formatter="code";

			$res = $wacko->_Format(trim($code), "highlight/".$formatter, $params);

			if ($params["wrapper"] && ($params["wrapper"] != "none"))
			{
				$wrapper = "wrapper_".$params["wrapper"];
				$params["wrapper"]=""; // no recursion
				$res = $wacko->_Format(trim($res), "highlight/".$wrapper, $params);
			}

			$output .= $res;

			return "\xa5\xa5".$output."\xa5\xa5";
		}
		// actions
		else if (preg_match("/^\{\{(.*?)\}\}$/s", $thing, $matches))
		{ // used in paragrafica, too
			return "\xa5\xa5<!--notypo-->\xA1\xA1".$matches[1]."\xA1\xA1<!--/notypo-->\xa5\xa5";
		}
		// if we reach this point, it must have been an accident.
		return $thing;
	}

	function WackoMiddleprocess($things)
	{
		$thing = $things[1];
		$wacko = &$this->object;
		$callback = array( &$this, "WackoCallback");

		if ($thing{0} == "~")
		if ($thing{1} == "~") return "~~".$this->WackoMiddleprocess( array(0,substr($thing,2)) );

		// escaped text
		if (preg_match("/^\xa5\xa5(.*)\xa5\xa5$/s", $thing, $matches))
		{
			return $matches[1];
		}
		// centered text
		else if (preg_match("/^>>(.*)<<$/s", $thing, $matches))
		{
			return "\xa5\xa5<div class=\"center\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</div>\xa5\xa5";
		}
		return $thing;
	}

	function WackoCallback($things)
	{
		$result = null;
		$thing = $things[1];

		$wacko = &$this->object;
		$callback = array( &$this, "WackoCallback");

		$this->page_id = $wacko->page["id"];
		if (!$this->page_id) $this->page_id = trim(substr(crc32(time()),0,5),"-");

		// convert HTML thingies
		if ($thing == "<")
		return "&lt;";
		else if ($thing == ">")
		return "&gt;";
		// escaped text
		else if (preg_match("/^\xa5\xa5(.*)\xa5\xa5$/s", $thing, $matches))
		{
			return $matches[1];
		}
		// escaped html
		else if (preg_match("/^\<\#(.*)\#\>$/s", $thing, $matches))
		{
			if ($this->object->GetConfigValue("disable_safehtml"))
			return "<!--notypo-->".$matches[1]."<!--/notypo-->";
			else
			return "<!--notypo-->".$wacko->Format($matches[1], "safehtml")."<!--/notypo-->";
		}
		//table begin
		else if ($thing == "#||")
		{
			$this->br = 0;
			$this->cols = 0;
			$this->intablebr = true;
			$this->tableScope = true;
			return "<table class=\"dtable\" border=\"0\">";
		}
		else if ($thing == "#|")
		{
			$this->br = 0;
			$this->cols = 0;
			$this->intablebr = true;
			$this->tableScope = true;
			return "<table class=\"usertable\" border=\"1\">";
		}
		//table end
		else if (($thing == "|#" || $thing == "||#") && $this->tableScope)
		{
			$this->br = 0;
			$this->intablebr = false;
			$this->tableScope = false;
			return "</table>";
		}
		//
		else if (preg_match("/^\|\|(.*?)\|\|$/s", $thing, $matches) && $this->tableScope)
		{
			$this->br = 1;
			$this->intable = true;
			$this->intablebr = false;

			$output = "<tr class=\"userrow\">";
			$cells = split("\|", $matches[1]);
			$count = count($cells);
			$count--;

			for ($i=0; $i<$count;$i++)
			{
				$this->tdoldIndentLevel = 0;
				$this->tdindentClosers = array();
				if ($cells[$i]{0}=="\n") $cells[$i] = substr($cells[$i], 1);
				$output .= str_replace("\177","",str_replace("\177"."<br />\n","","<td class=\"usercell\">".preg_replace_callback($this->LONGREGEXP, $callback, "\177\n".$cells[$i])));
				$output .= $this->IndentClose();
				$output .= "</td>";
			}
			if (($this->cols <> 0) and ($count<$this->cols))
			{
				$this->tdoldIndentLevel = 0;
				$this->tdindentClosers = array();
				if ($cells[$i]{0}=="\n") $cells[$count] = substr($cells[$count], 1);
				$output .= str_replace("\177","",str_replace("\177"."<br />\n","","<td class=\"usercell\" colspan=\"".($this->cols-$count+1)."\">".preg_replace_callback($this->LONGREGEXP, $callback, "\177\n".$cells[$count])));
				$output .= $this->IndentClose();
				$output .= "</td>";
			}
			else
			{
				$this->tdoldIndentLevel = 0;
				$this->tdindentClosers = array();
				if ($cells[$i]{0}=="\n") $cells[$count] = substr($cells[$count], 1);
				$output .= str_replace("\177","",str_replace("\177"."<br />\n","","<td  class=\"usercell\">".preg_replace_callback($this->LONGREGEXP, $callback, "\177\n".$cells[$count])));
				$output .= $this->IndentClose();
				$output .= "</td>";
			}
			$output .= "</tr>";

			if ($this->cols == 0)
			{
				$this->cols = $count;
			}
			$this->intablebr = true;
			$this->intable = false;
			return $output;
		}
		// Deleted
		else if (preg_match("/^\xA4\xA4((\S.*?\S)|(\S))\xA4\xA4$/s", $thing, $matches))
		{
			$this->br = 0;
			return "<span class=\"del\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</span>";
		}
		// Inserted
		else if (preg_match("/^\xA3\xA3((\S.*?\S)|(\S))\xA3\xA3$/s", $thing, $matches))
		{
			$this->br = 0;
			return "<span class=\"add\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</span>";
		}
		// bold
		else if (preg_match("/^\*\*(.*?)\*\*$/", $thing, $matches))
		{
			return "<strong>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</strong>";
		}
		// italic
		else if (preg_match("/^\/\/(.*?)\/\/$/", $thing, $matches))
		{
			return "<em>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</em>";
		}
		// underlinue
		else if (preg_match("/^__(.*?)__$/", $thing, $matches))
		{
			return "<u>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</u>";
		}
		// monospace
		else if (preg_match("/^\#\#(.*?)\#\#$/", $thing, $matches) ||
		preg_match("/^\�\�(.*?)\�\�$/", $thing, $matches))
		{
			return "<tt>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</tt>";
		}
		// small
		else if (preg_match("/^\+\+(.*?)\+\+$/", $thing, $matches))
		{
			return "<small>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</small>";
		}
		// cite
		else if (preg_match("/^\'\'(.*?)\'\'$/s", $thing, $matches) ||
		preg_match("/^\!\!((\((\S*?)\)(.*?\S))|(\S.*?\S)|(\S))\!\!$/s", $thing, $matches))
		{
			$this->br = 1;
			if ($matches[3] && $color = $this->colors[$matches[3]])
			{
				return "<span class=\"cl-".$color."\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[4])."</span>";
			}
			return "<span class=\"cite\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</span>";
		}
		else if (preg_match("/^\?\?((\((\S*?)\)(.*?\S))|(\S.*?\S)|(\S))\?\?$/s", $thing, $matches))
		{
			$this->br = 1;
			if ($matches[3] && $color = $this->colors[$matches[3]])
			{
				return "<span class=\"mark-".$color."\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[4])."</span>";
			}
			return "<span class=\"mark\">".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</span>";
		}
		// urls
		else if (preg_match("/^([[:alpha:]]+:\/\/\S+?|mailto\:[[:alnum:]\-\_\.]+\@[[:alnum:]\-\.\_]+?)([^[:alnum:]^\/\-\_\=]?)$/", $thing, $matches)) {
			$url = strtolower($matches[1]);
			if (substr($url,-4)==".jpg" || substr($url,-4)==".gif" || substr($url,-4)==".png" || substr($url,-4)==".jpe"
			|| substr($url,-5)==".jpeg") return "<img src=\"".$matches[1]."\" />".$matches[2];
			else return $wacko->PreLink($matches[1]).$matches[2];
		}
		// lan path
		else if (preg_match("/^\\\\\\\\([".$wacko->language["ALPHANUM_P"]."\\\!\.\-\_]+)$/", $thing, $matches)) {//[[:alnum:]\\\!\.\_\-]+\\
			return "<a href=\"file://///".str_replace("\\","/",$matches[1])."\">\\\\".$matches[1]."</a>";
		}
		// citated
		else if (preg_match("/^\n[ \t]*(>+)(.*)$/s", $thing, $matches))
		{
			return "<div class=\"email".strlen($matches[1])." email-".(strlen($matches[1])%2?"odd":"even")."\">".htmlspecialchars($matches[1]).preg_replace_callback($this->LONGREGEXP, $callback, $matches[2])."</div>";
		}
		// blockquote
		else if (preg_match("/^<\[(.*)\]>$/s", $thing, $matches))
		{
			//$this->br = 0;
			$result = preg_replace_callback($this->LONGREGEXP, $callback, $matches[1]);
			$result = preg_replace( "/^(<br \/>)+/i", "", $result );
			$result = preg_replace( "/(<br \/>)+$/i", "", $result );
			// These regexp needed for workaround MSIE bug (</ul></blockquote>)
			if (preg_match( "/<\/ul>[\s\r\t\n]*$/i", $result)) $result.= $this->z_gif;
			return "<blockquote>".$result."</blockquote>";
		}
		// super
		else if (preg_match("/^\^\^(.*)\^\^$/", $thing, $matches))
		{
			return "<sup>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</sup>";
		}
		// sub
		else if (preg_match("/^vv(.*)vv$/", $thing, $matches))
		{
			return "<sub>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</sub>";
		}
		// headers
		else if (preg_match("/\n[ \t]*=======(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h6>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h6>";
		}
		else if (preg_match("/\n[ \t]*======(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h5>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h5>";
		}
		else if (preg_match("/\n[ \t]*=====(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h4>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h4>";
		}
		else if (preg_match("/\n[ \t]*====(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h3>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h3>";
		}
		else if (preg_match("/\n[ \t]*===(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h2>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h2>";
		}
		else if (preg_match("/\n[ \t]*==(.*?)={2,7}$/", $thing, $matches))
		{
			$result = $this->IndentClose();
			$this->br = 0; $wacko->headerCount++;
			return $result."<a name=\"h".$this->page_id."-".$wacko->headerCount."\"></a><h1>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</h1>";
		}
		// separators
		else if (preg_match("/^[-]{4,}$/", $thing))
		{
			$this->br = 0;
			return "<hr noshade=\"noshade\" size=\"1\" />";
		}
		// forced line breaks
		else if (preg_match("/^---\n?\s*$/", $thing, $matches))
		{
			return "<br />\n";
		}
		// strike
		else if (preg_match("/^--((\S.*?\S)|(\S))--$/s", $thing, $matches))    //NB: wrong
		{
			return "<s>".preg_replace_callback($this->LONGREGEXP, $callback, $matches[1])."</s>";
		}
		// definitions
		else if ((preg_match("/^\(\?(.+?)(==|\|\|)(.*)\?\)$/", $thing, $matches)) ||
		(preg_match("/^\(\?(\S+)(\s+(.+))?\?\)$/", $thing, $matches)))
		{
			list (, $def, ,$text) = $matches;
			if ($def)
			{
				if ($text == "") $text = $def;
				$text=preg_replace("/\xA4\xA4|__|\[\[|\(\(/","",$text);
				return "<dfn title=\"".htmlspecialchars($text)."\">".$def."</dfn>";
			}
			return "";
		}
		// forced links & footnotes
		else if ((preg_match("/^\[\[(.+)(==|\|)(.*)\]\]$/", $thing, $matches)) ||
		(preg_match("/^\(\((.+)(==|\|)(.*)\)\)$/", $thing, $matches)) ||
		(preg_match("/^\[\[(\S+)(\s+(.+))?\]\]$/", $thing, $matches)) ||
		(preg_match("/^\(\((\S+)(\s+(.+))?\)\)$/", $thing, $matches)))
		{
			$url = isset( $matches[1] ) ? $matches[1] : '';
			$text = isset( $matches[3] ) ? $matches[3] : '';
			if ($url)
			if ($url{0}=="*")
			{
				$sup = 1;
				if (preg_match("/^\*+$/", $url)) {
					$aname = "ftn".strlen($url);
					if (!$text) $text = $url;
				}
				else if (preg_match("/^\*\d+$/", $url)) $aname = "ftnd".substr($url, 1);
				else {
					$aname = htmlspecialchars(substr($url, 1));
					$sup = 0;
				}
				if (!$text) $text = substr($url, 1);
				return ($sup?"<sup>":"")."<a href=\"#o".$aname."\" name=\"".$aname."\">".$text."</a>".($sup?"</sup>":"");
			}
			else if ($url{0}=="#")
			{
				$anchor = substr($url, 1);
				$sup = 1;
				if (preg_match("/^\*+$/", $anchor)) $ahref = "ftn".strlen($anchor);
				else if (preg_match("/^\d+$/", $anchor)) $ahref = "ftnd".$anchor;
				else {
					$ahref = htmlspecialchars($anchor);
					$sup = 0;
				}
				if (!$text) $text = substr($url, 1);
				return ($sup?"<sup>":"")."<a href=\"#".$ahref."\" name=\"o".$ahref."\">".$text."</a>".($sup?"</sup>":"");
			}
			else
			{
				if ($url!=($url=(preg_replace("/\xA4\xA4|\xA3\xA3|\[\[|\(\(/","",$url)))) $result="</span>";
				if ($url{0}=="(") {$url=substr($url,1); $result.="(";}
				if ($url{0}=="[") {$url=substr($url,1); $result.="[";}
				if (!$text) $text = $url;
				$url = str_replace( " ", "", $url );
				$text=preg_replace("/\xA4\xA4|\xA3\xA3|\[\[|\(\(/","",$text);
				return $result.$wacko->PreLink($url, $text);
			}
			return "";
		}
		// indented text
		else if (preg_match("/(\n)(\t+|(?:[ ]{2})+)(-|\*|([a-zA-Z]|[0-9]{1,3})[\.\)](\#[0-9]{1,3})?)?(\n|$)/s", $thing, $matches))
		{
			// new line
			$result .= ($this->br ? "<br />\n" : "\n");
			//intable or not?
			if ($this->intable)
			{
				$Closers = &$this->tdindentClosers;
				$oldlevel = &$this->tdoldIndentLevel;
				$oldtype = &$this->tdoldIndentType;
			}
			else
			{
				$Closers = &$this->indentClosers;
				$oldlevel = &$this->oldIndentLevel;
				$oldtype = &$this->oldIndentType;
			}

			// we definitely want no line break in this one.
			$this->br = 0;

			//#18 syntax support
			if ($matches[5])
			$start = substr($matches[5], 1);
			else
			$start = "";

			// find out which indent type we want
			$newIndentType = $matches[3][0];
			if (!$newIndentType) { $opener = "<div class=\"indent\">"; $closer = "</div>"; $this->br = 1; $newtype = "i"; }
			else if ($newIndentType == "-" || $newIndentType == "*") { $opener = "<ul><li>"; $closer = "</li></ul>"; $li = 1; $newtype="*"; }
			else { $opener = "<ol type=\"".$newIndentType."\"><li".($start?" value=\"".$start."\"":"").">"; $closer = "</li></ol>"; $li = 1; $newtype="1";}

			// get new indent level
			if ($matches[2][0]==" ")
			$newIndentLevel = (int) (strlen($matches[2])/2);
			else
			$newIndentLevel = strlen($matches[2]);

			if ($newIndentLevel > $oldlevel)
			{
				for ($i = 0; $i < $newIndentLevel - $oldlevel; $i++)
				{
					$result .= $opener;
					array_push($Closers, $closer);
				}
			}
			else if ($newIndentLevel < $oldlevel)
			{
				for ($i = 0; $i < $oldlevel - $newIndentLevel; $i++)
				{
					$result .= array_pop($Closers);
				}
			}
			else if ($newIndentLevel == $oldlevel && $oldtype!=$newtype)
			{
				$result .= array_pop($Closers);
				$result .= $opener;
				array_push($Closers, $closer);
			}

			$oldlevel = $newIndentLevel;
			$oldtype  = $newtype;

			if ($li && !preg_match("/".str_replace(")", "\)", $opener)."$/", $result))
			{
				$result .= "</li><li".($start?" value=\"".$start."\"":"").">";
			}

			return $result;
		}
		// new lines
		else if ($thing == "\n" && !$this->intablebr)
		{
			// if we got here, there was no tab in the next line; this means that we can close all open indents.
			$result = $this->IndentClose();
			if ($result) $this->br = 0;

			$result .= $this->br ? "<br />\n" : "\n";
			$this->br = 1;
			return $result;
		}
		// interwiki links
		else if (preg_match("/^([[:alnum:]]+[:][".$wacko->language["ALPHANUM_P"]."\!\.][".$wacko->language["ALPHANUM_P"]."\-\_\.\+\&\=\#]+?)([^[:alnum:]^\/\-\_\=]?)$/s", $thing, $matches))
		{
			return $wacko->PreLink($matches[1]).$matches[2];
		}
		// tikiwiki links
		else if ((!$wacko->_formatter_noautolinks) && $wacko->GetConfigValue("disable_tikilinks")!=1 &&
		(preg_match("/^(".$wacko->language["UPPER"].$wacko->language["LOWER"].$wacko->language["ALPHANUM"]."*\.".$wacko->language["ALPHA"].$wacko->language["ALPHANUM"]."+)$/s", $thing, $matches)))
		{
			return $wacko->PreLink($thing);
		}
		// npj links
		else if ((!$wacko->_formatter_noautolinks) &&
		(preg_match("/^(~?)(".$wacko->language["ALPHANUM"]."+\@".$wacko->language["ALPHA"]."*(\:".$wacko->language["ALPHANUM"]."*)?|".$wacko->language["ALPHANUM"]."+\:\:".$wacko->language["ALPHANUM"]."+)$/s", $thing, $matches)))
		{
			if ($matches[1]=="~")
			return $matches[2];
			return $wacko->PreLink($thing);
		}
		// wacko links!
		else if ((!$wacko->_formatter_noautolinks) &&
		(preg_match("/^(((\.\.)|!)?\/?|~)?(".$wacko->language["UPPER"].$wacko->language["LOWER"]."+".$wacko->language["UPPERNUM"].$wacko->language["ALPHANUM"]."*)$/s", $thing, $matches)))
		{
			if ($matches[1]=="~")
			return $matches[4];
			return $wacko->PreLink($thing);
		}
		if (($thing[0] == "~") && ($thing[1] != "~")) $thing=ltrim($thing, "~");
		if (($thing[0] == "~") && ($thing[1] == "~")) return "~".preg_replace_callback($this->LONGREGEXP, $callback, substr($thing,2));
		// if we reach this point, it must have been an accident.
		return htmlspecialchars($thing);
	}
}

?>