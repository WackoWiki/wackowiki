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
	var $FixedSize = 80; // максимальная ширина
	var $ignore = "/(<!--notypo-->.*?<!--\/notypo-->)/si"; // regex, который игнорируется.
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

	var $glueleft = array( "рис\.", "табл\.", "см\.", "им\.", "ул\.", "пер\.", "кв\.", "офис", "оф\.", "г\." );
	var $glueright = array( "руб\.", "коп\.", "у\.е\.", "мин\." );

	var $settings = array ( "inches" => 1, // преобразовывать дюймы в &quot;
                          "laquo" => 1,  // кавычки-ёлочки
                          "farlaquo" => 0,  // кавычки-ёлочки для фара (знаки "больше-меньше")
                          "quotes" => 1, // кавычки-английские лапки
                          "dash" => 1,   // короткое тире (150)
                          "emdash" => 1, // длинное тире двумя минусами (151)
                          "(c)" => 1, "(r)" => 1, "(tm)" => 1, "(p)" => 1, "+-" => 1, // спецсимволы, какие - понятно
                          "degrees" => 1, // знак градуса
                          "<-->" => 1,    // отступы $Indent*
                          "dashglue" => 1, "wordglue" => 1, // приклеивание предлогов и дефисов
                          "spacing" => 1, // запятые и пробелы, перестановка
                          "phones" => 1,  // обработка телефонов
                          "fixed" => 0,   // подгон под фиксированную ширину
                          "html" => 0     // запрет тагов html
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
		// -2. игнорируем ещё регексп
		$ignored = array();
		{
			$total = preg_match_all($this->ignore, $data, $matches);
			$data = preg_replace($this->ignore, "\201", $data);
			for ($i=0;$i<$total;$i++)
			{
				$ignored[] = $matches[0][$i];
			}
		}

		// -1. запрет тагов html
		if ($this->settings["html"])
		$data = str_replace( "&", "&amp;",  $data );
		// 0. Вырезаем таги
		//  проблема на самом деле в том, на что похожи таги.
		//   вариант 1, простой (закрывающий таг) </abcz>
		//   вариант 2, простой (просто таг)      <abcz>
		//   вариант 3, посложней                 <abcz href="abcz">
		//   вариант 4, простой (просто таг)      <abcz />
		//   вариант 5, вакка                     \xA2\xA2...==
		//   самый сложный вариант - это когда в параметре тага встречается вдруг символ ">"
		//   вот он: <abcz href="abcz>">
		//  как работает вырезание? введём спецсимвол. Да, да, спецсимвол.
		//    нам он ещё вопьётся =)
		//  заменим все таги на спец.символ, запоминая одновременно их в массив.
		//  и будем верить, что спец.символы в дикой природе не встречаются.
		$tags = array();
		if ($this->skipTags)
		{
			$re =  "/<\/?[a-z0-9]+(". // имя тага
                               "\s+(". // повторяющая конструкция: хотя бы один разделитель и тельце
                                      "[a-z]+(". // атрибут из букв, за которым может стоять знак равенства и потом
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

		// 1. Запятые и пробелы
		if ($this->settings["spacing"])
		{
			$data = preg_replace( "/(\s*)([,]*)/i", "\\2\\1", $data );
			$data = preg_replace( "/(\s*)([\.?!]*)(\s*[ЁА-ЯA-Z])/", "\\2\\1\\3", $data );
		}

		// 2. Разбиение на строки длиной не более ХХ символов
		// --- для ваки не портировано ---
		// --- для ваки не портировано ---

		// 3. Спецсимволы
		$data = $this->replaceSpecials( $data );

		// 4. Короткие слова и &nbsp;
		if ($this->settings["wordglue"])
		{

			$data = " ".$data." ";
			$_data = " ".$data." ";
			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace( "/(\s+)([a-zа-яА-Я]{1,2})(\s+)([^\\s$])/i", "\\1\\2&nbsp;\\4", $data );
				$data = preg_replace( "/(\s+)([a-zа-яА-Я]{3})(\s+)([^\\s$])/i",   "\\1\\2&nbsp;\\4", $data );
			}
			foreach ($this->glueleft as $i)
			$data = preg_replace( "/([\\s]+)(".$i.")(\s+)/i", "\\1\\2&nbsp;", $data );
			foreach ($this->glueright as $i)
			$data = preg_replace( "/([\\s]+)(".$i.")(\s+)/i", "&nbsp;\\2\\3", $data );
		}

		// 5. Склейка ласт. Тьфу! дефисов.
		if ($this->settings["dashglue"])
		{
			$data = preg_replace( "/([a-zа-яА-Я0-9]+(\-[a-zа-яА-Я0-9]+)+)/i", "<nobr>\\1</nobr>", $data );
		}

		// 6. Макросы
		$data = $this->replaceMacros( $data, $noParagraph );

		// 7. Переводы строк
		// --- для ваки не портировано ---
		// --- для ваки не портировано ---

		// БЕСКОНЕЧНОСТЬ. Вставляем таги обратно.
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

		// БЕСКОНЕЧНОСТЬ-2. вставляем ещё сигнорированный регексп
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

		// БОНУС: прокручивание ссылок через A(...)
		// --- для ваки не портировано ---
		// --- для ваки не портировано ---

		// фуф, закончили.
		if ($this->de_nobr) $data = str_replace( "<nobr>", "<span class=\"nobr\">", str_replace( "</nobr>", "</span>", $data ));
		return preg_replace( "/^(\s)+/", "",  preg_replace( "/(\s)+$/", "", $data));
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	// -----------------------------------------------------------------------------------
	// Метод для внутреннего использования. Проверяет только спец.символы
	function replaceSpecials( $data )
	{
		//print "(($data))";
		// 0. дюймы с цифрами
		if ($this->settings["inches"])
		$data = preg_replace( "/(?<=\s)(([0-9]{1,2}([\.,][0-9]{1,2})?))\"/i", "\\1&quot;", $data );
		// 1. лапки
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
		// 2. ёлочки
		if ($this->settings["laquo"])
		{
			$data = preg_replace( "/\"\"/i", "&quot;&quot;", $data );
			$data = preg_replace( "/(^|\s|\201|\200|>|\()\"((\201|\200)*[~0-9ёЁA-Za-zА-Яа-я\-:\/\.])/i", "\\1&laquo;\\2", $data );
			// nb: wacko only regexp follows:
			$data = preg_replace( "/(^|\s|\201|\200|>|\()\"((\201|\200|\/&nbsp;|\/|\!)*[~0-9ёЁA-Za-zА-Яа-я\-:\/\.])/i", "\\1&laquo;\\2", $data );
			$_data = "\"\"";
			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace( "/(\&laquo\;([^\"]*)[ёЁA-Za-zА-Яа-я0-9\.\-:\/](\201|\200)*)\"/si", "\\1&raquo;", $data );
				// nb: wacko only regexps follows:
				$data = preg_replace( "/(\&laquo\;([^\"]*)[ёЁA-Za-zА-Яа-я0-9\.\-:\/](\201|\200)*\?(\201|\200)*)\"/si", "\\1&raquo;", $data );
				$data = preg_replace( "/(\&laquo\;([^\"]*)[ёЁA-Za-zА-Яа-я0-9\.\-:\/](\201|\200|\/|\!)*)\"/si", "\\1&raquo;", $data );
			}
		}
		// 2a. ёлочки для FAR manager
		// --- для ваки не портировано ---
		// --- для ваки не портировано ---
		// 2b. одновременно ёлочки и лапки
		if (($this->settings["quotes"]) && (($this->settings["laquo"]) || ($this->settings["farlaquo"])))
		$data = preg_replace( "/(\&\#147\;(([A-Za-z0-9'!\.?,\-&;:]|\s|\200|\201)*)&laquo;(.*)&raquo;)&raquo;/i",
                              "\\1&#148;", $data );
		// 3. тире
		if ($this->settings["dash"])
		$data = preg_replace( "/(\s|;)\-(\s)/i", "\\1&ndash;\\2", $data );
		// 3a. тире длинное
		if ($this->settings["emdash"])
		$data = preg_replace( "/(\s|;)\-\-(\s)/i", "\\1&mdash;\\2", $data );

		// 4. (с)
		if ($this->settings["(c)"])
		$data = preg_replace( "/\([cCсС]\)((?=\w)|(?=\s[0-9]+))/i", "&copy;", $data );
		// 4a. (r)
		if ($this->settings["(r)"])
		$data = preg_replace( "/\(r\)/i", "<sup>&#174;</sup>", $data );
		// 4b. (tm)
		if ($this->settings["(tm)"])
		$data = preg_replace( "/\(tm\)|\(тм\)/i", "&#153;", $data );
		// 4c. (p)
		if ($this->settings["(p)"])
		$data = preg_replace( "/\(p\)/i", "&#167;", $data );

		// 5. +/-
		if ($this->settings["+-"])
		$data = preg_replace( "/\+\-/i", "&#177;", $data );
		// 5a. 12^C
		if ($this->settings["degrees"])
		{
			$data = preg_replace( "/-([0-9])+\^([FCС])/", "&ndash;\\1&#176\\2", $data );
			$data = preg_replace( "/\+([0-9])+\^([FCС])/", "+\\1&#176\\2", $data );
			$data = preg_replace( "/\^([FCС])/", "&#176\\1", $data );
		}

		// 6. телефоны
		if ($this->settings["phones"])
		{
			foreach ($this->phonemasks[0] as $i => $v)
			$data = preg_replace( $v, $this->phonemasks[1][$i], $data );
		}

		return $data;
	}

	// -----------------------------------------------------------------------------------
	// Метод для внутреннего использования. Проверяет только макросы
	function replaceMacros( $data, $noParagraph )
	{
		// 1. Абзацы
		// --- для ваки не портировано ---
		// 2. Красная строка
		if ($this->settings["<-->"])
		{
			$data = preg_replace( "/<\->/i", $this->Indent1, $data );
			$data = preg_replace( "/<\-\->/i", $this->Indent1, $data );
		}
		// 3. mailto:
		// --- для ваки не портировано ---
		// 4. http://
		// --- для ваки не портировано ---
		return $data;
	}

}

?>