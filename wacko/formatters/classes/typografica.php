<?php
/*

Typografica library: typografica class.
v.2.5
20 February 2005.

---------

http://www.pixel-apes.com/typografica

Copyright (c) 2004, Kuso Mendokusee <mailto:mendokusee@yandex.ru>
All rights reserved.

*/

class typografica
{

	var $wacko;
	var $skipTags = true;
	var $pPrefix = "<p class=typo>";
	var $pPostfix = "</p>";
	var $Asoft = true;
	var $Indent1 = "images/z.gif width=25 height=1 border=0 alt=\'\' align=top />"; // <->
	var $Indent2 = "images/z.gif width=50 height=1 border=0 alt=\'\' align=top />"; // <-->
	var $FixedSize = 80; // ������������ ������
	var $ignore = "/(<!--notypo-->.*?<!--\/notypo-->)/si"; // regex, ������� ������������.
	var $de_nobr = true;

	var $phonemasks = array(
	array(
                              "/([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/",
                              "/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",
                              "/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})\-([0-9]{2})/",
                              "/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{2})\-([0-9]{2})/",
                              "/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})/",
                              "/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{3})/",
                              "/([0-9]{3})\-([0-9]{2})\-([0-9]{2})/",
                              "/([0-9]{2})\-([0-9]{2})\-([0-9]{2})/",
                              "/([0-9]{1})\-([0-9]{2})\-([0-9]{2})/",
                              "/([0-9]{2})\-([0-9]{3})/",
                              "/([0-9]+)\-([0-9]+)/",
	),
	array(
                              "<nobr>\\1&ndash;\\2&ndash;\\3&nbsp;\\4:\\5:\\6</nobr>",
                              "<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&nbsp;\\2&ndash;\\3&ndash;\\4</nobr>",
                              "<nobr>\\1&nbsp;\\2&ndash;\\3&ndash;\\4</nobr>",
                              "<nobr>\\1&nbsp;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&nbsp;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
                              "<nobr>\\1&ndash;\\2</nobr>",
                              "<nobr>\\1&ndash;\\2</nobr>",
	)
	);

	var $glueleft = array( "���\.", "����\.", "��\.", "��\.", "��\.", "���\.", "��\.", "����", "��\.", "�\." );
	var $glueright = array( "���\.", "���\.", "�\.�\.", "���\." );

	var $settings = array ( "inches" => 1, // ��������������� ����� � &quot;
                          "laquo" => 1,  // �������-������
                          "farlaquo" => 0,  // �������-������ ��� ���� (����� "������-������")
                          "quotes" => 1, // �������-���������� �����
                          "dash" => 1,   // �������� ���� (150)
                          "emdash" => 1, // ������� ���� ����� �������� (151)
                          "(c)" => 1, "(r)" => 1, "(tm)" => 1, "(p)" => 1, "+-" => 1, // �����������, ����� - �������
                          "degrees" => 1, // ���� �������
                          "<-->" => 1,    // ������� $Indent*
                          "dashglue" => 1, "wordglue" => 1, // ������������ ��������� � �������
                          "spacing" => 1, // ������� � �������, ������������
                          "phones" => 1,  // ��������� ���������
                          "fixed" => 0,   // ������ ��� ������������� ������
                          "html" => 0     // ������ ����� html
	);

	function typografica ( &$wacko )
	{
		$this->wacko = &$wacko;
		$this->Indent1 = "<img src=".$wacko->GetConfigValue("root_url").$this->Indent1;
		$this->Indent2 = "<img src=".$wacko->GetConfigValue("root_url").$this->Indent2;
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function correct( $data, $noParagraph=false )
	{
		// -2. ���������� ��� �������
		$ignored = array();
		{
			$total = preg_match_all($this->ignore, $data, $matches);
			$data = preg_replace($this->ignore, "\201", $data);
			for ($i=0;$i<$total;$i++)
			{
				$ignored[] = $matches[0][$i];
			}
		}

		// -1. ������ ����� html
		if ($this->settings["html"])
		$data = str_replace( "&", "&amp;",  $data );
		// 0. �������� ����
		//  �������� �� ����� ���� � ���, �� ��� ������ ����.
		//   ������� 1, ������� (����������� ���) </abcz>
		//   ������� 2, ������� (������ ���)      <abcz>
		//   ������� 3, ���������                 <abcz href="abcz">
		//   ������� 4, ������� (������ ���)      <abcz />
		//   ������� 5, �����                     \xA2\xA2...==
		//   ����� ������� ������� - ��� ����� � ��������� ���� ����������� ����� ������ ">"
		//   ��� ��: <abcz href="abcz>">
		//  ��� �������� ���������? ����� ����������. ��, ��, ����������.
		//    ��� �� ��� �������� =)
		//  ������� ��� ���� �� ����.������, ��������� ������������ �� � ������.
		//  � ����� ������, ��� ����.������� � ����� ������� �� �����������.
		$tags = array();
		if ($this->skipTags)
		{
			$re =  "/<\/?[a-z0-9]+(". // ��� ����
                               "\s+(". // ����������� �����������: ���� �� ���� ����������� � ������
                                      "[a-z]+(". // ������� �� ����, �� ������� ����� ������ ���� ��������� � �����
                                               "=((\'[^\']*\')|(\"[^\"]*\")|([0-9@\-_a-z:\/?&=\.]+))". // 
                                            ")?".
                                   ")?".
                             ")*\/?>|\xA2\xA2[^\n]*?==/i";
			$total = preg_match_all($re, $data, $matches);
			$data = preg_replace($re, "\200", $data);

			for ($i=0;$i<$total;$i++)
			{
				if ($this->settings["html"])
				$matches[0][$i] = "&lt;"+substr($matches[0][$i],1);
				$tags[] = $matches[0][$i];
			}
		}

		// 1. ������� � �������
		if ($this->settings["spacing"])
		{
			$data = preg_replace( "/(\s*)([,]*)/i", "\\2\\1", $data );
			$data = preg_replace( "/(\s*)([\.?!]*)(\s*[��-�A-Z])/", "\\2\\1\\3", $data );
		}

		// 2. ��������� �� ������ ������ �� ����� �� ��������
		// --- ��� ���� �� ����������� ---
		// --- ��� ���� �� ����������� ---

		// 3. �����������
		$data = $this->replaceSpecials( $data );

		// 4. �������� ����� � &nbsp;
		if ($this->settings["wordglue"])
		{

			$data = " ".$data." ";
			$_data = " ".$data." ";
			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace( "/(\s+)([a-z�-��-�]{1,2})(\s+)([^\\s$])/i", "\\1\\2&nbsp;\\4", $data );
				$data = preg_replace( "/(\s+)([a-z�-��-�]{3})(\s+)([^\\s$])/i",   "\\1\\2&nbsp;\\4", $data );
			}
			foreach ($this->glueleft as $i)
			$data = preg_replace( "/([\\s]+)(".$i.")(\s+)/i", "\\1\\2&nbsp;", $data );
			foreach ($this->glueright as $i)
			$data = preg_replace( "/([\\s]+)(".$i.")(\s+)/i", "&nbsp;\\2\\3", $data );
		}

		// 5. ������� ����. ����! �������.
		if ($this->settings["dashglue"])
		{
			$data = preg_replace( "/([a-z�-��-�0-9]+(\-[a-z�-��-�0-9]+)+)/i", "<nobr>\\1</nobr>", $data );
		}

		// 6. �������
		$data = $this->replaceMacros( $data, $noParagraph );

		// 7. �������� �����
		// --- ��� ���� �� ����������� ---
		// --- ��� ���� �� ����������� ---

		// �������������. ��������� ���� �������.
		if ($this->skipTags)
		{
			$data .= " ";
			$a = explode( "\200", $data );
			if ($a)
			{
				$data = $a[0];
				$size = count($a);
				for ($i=1; $i<$size; $i++)
				{
					$data= $data.$tags[$i-1].$a[$i];
				}
			}
		}

		// �������������-2. ��������� ��� ��������������� �������
		{
			$data .= " ";
			$a = explode( "\201", $data );
			if ($a)
			{
				$data = $a[0];
				$size = count($a);
				for ($i=1; $i<$size; $i++)
				{
					$data= $data.$ignored[$i-1].$a[$i];
				}
			}
		}

		// �����: ������������� ������ ����� A(...)
		// --- ��� ���� �� ����������� ---
		// --- ��� ���� �� ����������� ---

		// ���, ���������.
		if ($this->de_nobr) $data = str_replace( "<nobr>", "<span class=\"nobr\">", str_replace( "</nobr>", "</span>", $data ));
		return preg_replace( "/^(\s)+/", "",  preg_replace( "/(\s)+$/", "", $data));
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	// -----------------------------------------------------------------------------------
	// ����� ��� ����������� �������������. ��������� ������ ����.�������
	function replaceSpecials( $data )
	{
		//print "(($data))";
		// 0. ����� � �������
		if ($this->settings["inches"])
		$data = preg_replace( "/(?<=\s)(([0-9]{1,2}([\.,][0-9]{1,2})?))\"/i", "\\1&quot;", $data );
		// 1. �����
		if ($this->settings["quotes"])
		{
			$data = preg_replace( "/\"\"/i", "&quot;&quot;", $data );
			$data = preg_replace( "/\"\.\"/i", "&quot;.&quot;", $data );
			$_data = "\"\"";
			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace( "/(^|\s|\201|\200|>)\"([0-9A-Za-z\'\!\s\.\?\,\-\&\;\:\_\200\201]+(\"|&#148;))/i", "\\1&#147;\\2", $data );
				$data = preg_replace( "/(\&\#147\;([A-Za-z0-9\'\!\s\.\?\,\-\&\;\:\200\201\_]*).*[A-Za-z0-9][\200\201\?\.\!\,]*)\"/i", "\\1&#148;", $data );
			}
		}
		// 2. ������
		if ($this->settings["laquo"])
		{
			$data = preg_replace( "/\"\"/i", "&quot;&quot;", $data );
			$data = preg_replace( "/(^|\s|\201|\200|>|\()\"((\201|\200)*[~0-9��A-Za-z�-��-�\-:\/\.])/i", "\\1&laquo;\\2", $data );
			// nb: wacko only regexp follows:
			$data = preg_replace( "/(^|\s|\201|\200|>|\()\"((\201|\200|\/&nbsp;|\/|\!)*[~0-9��A-Za-z�-��-�\-:\/\.])/i", "\\1&laquo;\\2", $data );
			$_data = "\"\"";
			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace( "/(\&laquo\;([^\"]*)[��A-Za-z�-��-�0-9\.\-:\/](\201|\200)*)\"/si", "\\1&raquo;", $data );
				// nb: wacko only regexps follows:
				$data = preg_replace( "/(\&laquo\;([^\"]*)[��A-Za-z�-��-�0-9\.\-:\/](\201|\200)*\?(\201|\200)*)\"/si", "\\1&raquo;", $data );
				$data = preg_replace( "/(\&laquo\;([^\"]*)[��A-Za-z�-��-�0-9\.\-:\/](\201|\200|\/|\!)*)\"/si", "\\1&raquo;", $data );
			}
		}
		// 2a. ������ ��� FAR manager
		// --- ��� ���� �� ����������� ---
		// --- ��� ���� �� ����������� ---
		// 2b. ������������ ������ � �����
		if (($this->settings["quotes"]) && (($this->settings["laquo"]) || ($this->settings["farlaquo"])))
		$data = preg_replace( "/(\&\#147\;(([A-Za-z0-9'!\.?,\-&;:]|\s|\200|\201)*)&laquo;(.*)&raquo;)&raquo;/i",
                              "\\1&#148;", $data );
		// 3. ����
		if ($this->settings["dash"])
		$data = preg_replace( "/(\s|;)\-(\s)/i", "\\1&ndash;\\2", $data );
		// 3a. ���� �������
		if ($this->settings["emdash"])
		$data = preg_replace( "/(\s|;)\-\-(\s)/i", "\\1&mdash;\\2", $data );

		// 4. (�)
		if ($this->settings["(c)"])
		$data = preg_replace( "/\([cC��]\)((?=\w)|(?=\s[0-9]+))/i", "&copy;", $data );
		// 4a. (r)
		if ($this->settings["(r)"])
		$data = preg_replace( "/\(r\)/i", "<sup>&#174;</sup>", $data );
		// 4b. (tm)
		if ($this->settings["(tm)"])
		$data = preg_replace( "/\(tm\)|\(��\)/i", "&#153;", $data );
		// 4c. (p)
		if ($this->settings["(p)"])
		$data = preg_replace( "/\(p\)/i", "&#167;", $data );

		// 5. +/-
		if ($this->settings["+-"])
		$data = preg_replace( "/\+\-/i", "&#177;", $data );
		// 5a. 12^C
		if ($this->settings["degrees"])
		{
			$data = preg_replace( "/-([0-9])+\^([FC�])/", "&ndash;\\1&#176\\2", $data );
			$data = preg_replace( "/\+([0-9])+\^([FC�])/", "+\\1&#176\\2", $data );
			$data = preg_replace( "/\^([FC�])/", "&#176\\1", $data );
		}

		// 6. ��������
		if ($this->settings["phones"])
		{
			foreach ($this->phonemasks[0] as $i => $v)
			$data = preg_replace( $v, $this->phonemasks[1][$i], $data );
		}

		return $data;
	}

	// -----------------------------------------------------------------------------------
	// ����� ��� ����������� �������������. ��������� ������ �������
	function replaceMacros( $data, $noParagraph )
	{
		// 1. ������
		// --- ��� ���� �� ����������� ---
		// 2. ������� ������
		if ($this->settings["<-->"])
		{
			$data = preg_replace( "/<\->/i", $this->Indent1, $data );
			$data = preg_replace( "/<\-\->/i", $this->Indent1, $data );
		}
		// 3. mailto:
		// --- ��� ���� �� ����������� ---
		// 4. http://
		// --- ��� ���� �� ����������� ---
		return $data;
	}

}

?>