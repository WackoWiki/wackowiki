/*!
 * WikiEdit v3.22
 * https://wackowiki.org/doc/Dev/Projects/WikiEdit
 *
 * Licensed BSD © Roman Ivanov, Evgeny Nedelko, WackoWiki Team
 */

class WikiEdit extends ProtoEdit
{
	constructor()
	{
		super();

		this.manual			= 'https://wackowiki.org/doc/';

		this.mark			= '##inspoint##';
		this.begin			= '##startpoint##';
		this.rbegin			= new RegExp(this.begin);
		this.end			= '##endpoint##';
		this.rend			= new RegExp(this.end);
		this.rendb			= new RegExp('^' + this.end);
		this.enabled		= true;
		this.tab			= false;
		this.enterpressed	= false;
		this.undostack		= [];
		this.buttons		= [];
	}

	// initialisation
	init(id, imgPath)
	{
		this._init(id);
		// if (!this.area.id) this.area.id = "area_" + String(Math.floor(Math.random() * 10000));
		this.imagesPath	= (imgPath ? imgPath : 'image/');
		this.actionName	= 'document.getElementById(\'' + this.id + '\')._owner.insTag';
		let separator	= '<li><div class="btn-separator"/></div></li>';

		try {
			this.undotext = this.area.value;
			this.undosels = this.area.selectionStart;
			this.undosele = this.area.selectionEnd;
		}
		catch (e) {
		}

		//this.addButton('h1',			lang.Heading1,		'\'==\', \'==\', 0, 1');
		this.addButton('h2',			lang.Heading2,		'\'===\', \'===\', 0, 1');
		this.addButton('h3',			lang.Heading3,		'\'====\', \'====\', 0, 1');
		this.addButton('h4',			lang.Heading4,		'\'=====\', \'=====\', 0, 1');
		this.addButton('h5',			lang.Heading5,		'\'======\', \'======\', 0, 1');
		this.addButton('h6',			lang.Heading6,		'\'=======\', \'=======\', 0, 1');
		this.addButton('customhtml',	separator);

		this.addButton('bold',			lang.Bold,			'\'**\', \'**\'');
		this.addButton('italic',		lang.Italic,		'\'//\', \'//\'');
		this.addButton('underline',		lang.Underline,		'\'__\', \'__\'');
		this.addButton('strike',		lang.Strikethrough,	'\'--\', \'--\'');
		this.addButton('small',			lang.Small,			'\'++\', \'++\'');
		this.addButton('code',			lang.Code,			'\'##\', \'##\'');
		this.addButton('customhtml',	separator);

		//this.addButton('superscript',	lang.Superscript,	"'^^', '^^'");
		//this.addButton('subscript',	lang.Subscript,		"'vv', 'vv'");
		//this.addButton('customhtml',	separator);
		this.addButton('ul',			lang.List,			'\'  * \', \'\', 0, 1, 1');
		this.addButton('ol',			lang.NumberedList,	'\'  1. \', \'\', 0, 1, 1');
		this.addButton('customhtml',	separator);
		//this.addButton('left',		lang.Left,			'\'%%(wacko wrapper=text wrapper_align=left)\', \'%%\', 2');
		this.addButton('center',		lang.Center,		'\'%%(wacko wrapper=text wrapper_align=center)\', \'%%\', 2');
		this.addButton('right',			lang.Right,			'\'%%(wacko wrapper=text wrapper_align=right)\', \'%%\', 2');
		this.addButton('justify',		lang.Justify,		'\'%%(wacko wrapper=text wrapper_align=justify)\', \'%%\', 2');
		this.addButton('customhtml',	separator);

		this.addButton('outdent',		lang.Outdent,		'', 'document.getElementById(\'' + this.id + '\')._owner.unindent');
		this.addButton('indent',		lang.Indent,		'\'  \', \'\', 0, 1');
		this.addButton('customhtml',	separator);

		this.addButton('quote',			lang.Quote,			'\'<[\', \']>\', 2');
		this.addButton('source',		lang.CodeWrapper,	'\'%% \', \' %%\', 2');
		//this.addButton('html',		lang.HTML,			"'<# ', ' #>', 2");
		//this.addButton('action',		lang.Action,		"'{{ ', ' }}', 2");
		this.addButton('hr',			lang.Line,			'\'\', \'\\n----\\n\', 2');
		this.addButton('signature',		lang.Signature,		'\'::@::\', \' \', 1');
		this.addButton('textred',		lang.MarkedText,	'\'!!\', \'!!\', 2');
		this.addButton('highlight',		lang.HighlightText,	'\'??\', \'??\', 2');
		//this.addButton('shade',		lang.Shade,			"'%%(wacko wrapper="shade")', '%%', 2");
		this.addButton('createlink',	lang.Hyperlink,		'', 'document.getElementById(\'' + this.id + '\')._owner.createLink');

		if (this.autocomplete)
		{
			this.autocomplete.addButton();
		}

		this.addButton('footnote',		lang.Footnote,		'\'[[^ \', \']]\', 2');
		this.addButton('createtable',	lang.InsertTable,	'\'\', \'\\n#|\\n|| | ||\\n|| | ||\\n|#\\n\', 2');
		this.addButton('customhtml',	separator);
		this.addButton('customhtml',	'<li class="we-help"><button id="hilfe_' + this.id + '" onmouseover=\'this.className="btn-hover";\' '
			+ 'onmouseout=\'this.className="btn-";\' class="btn-" '
			+ 'onclick="this.className=\'btn-pressed\';window.open(\'' + this.manual + lang.HelpFormattingPage + '\');" '
			+ ' title="' + lang.HelpFormattingTip + '">'
			+ '<img src="' + this.imagesPath + 'spacer.png"' + ' alt="' + lang.HelpFormatting + '" title="' + lang.HelpFormattingTip + '">'
			+ '</button></li>');
		this.addButton('about',			lang.HelpAbout,		'', 'document.getElementById(\'' + this.id + '\')._owner.help');

		try {
			var toolbar			= document.createElement('div');
			toolbar.id			= 'tb_' + this.id;
			this.area.parentNode.insertBefore(toolbar, this.area);
			toolbar				= document.getElementById('tb_' + this.id);
			toolbar.innerHTML	= this.createToolbar(1);
		}
		catch (e) {
		}
	}

	// switch TAB key interception on and off
	switchTab()
	{
		this.tab = !this.tab;
	}

	// internal functions ----------------------------------------------------
	_LSum(Tag, Text, Skip)
	{
		var q, w;
		
		if (Skip)
		{
			let bb	= /^([ ]*)([*][*])(.*)$/;
			q		= Text.match(bb);

			if (q != null)
			{
				Text = q[1] + Tag + q[2] + q[3];

				return Text;
			}

			w		= /^([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$/u;
			q		= Text.match(w);

			if (q != null)
			{
				Text = q[1] + q[2] + Tag + q[7];

				return Text;
			}
		}

		w		= /^([ ]*)(.*)$/;
		q		= Text.match(w);
		Text	= q[1] + Tag + q[2];

		return Text;
	}

	_RSum(Text, Tag)
	{
		var w	= /^(.*)([ ]*)$/;
		var q	= Text.match(w);
		Text	= q[1] + Tag + q[2];

		return Text;
	}

	_TSum(Text, Tag, Tag2, Skip)
	{
		var bb	= new RegExp('^([ ]*)' + this.begin + '([ ]*)([*][*])(.*)$');
		var q	= Text.match(bb);
		var w;

		if (q != null)
		{
			Text = q[1] + this.begin + q[2] + Tag + q[3] + q[4];
		}
		else
		{
			w	= new RegExp('^([ ]*)' + this.begin + '([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$', 'u');
			q	= Text.match(w);

			if (Skip && q != null)
			{
				Text = q[1] + this.begin + q[2] + q[3] + Tag + q[8];
			}
			else
			{
				w	= new RegExp('^(.*)' + this.begin + '([ ]*)(.*)$');
				q	= Text.match(w);

				if (q != null)
				{
					Text = q[1] + this.begin + q[2] + Tag + q[3];
				}
			}
		}

		w	= new RegExp('([ ]*)' + this.end + '(.*)$');
		q	= Text.match(w);

		if (q != null)
		{
			w		= new RegExp('^(.*)' + this.end);
			var q1	= Text.match(w);

			if (q1 != null)
			{
				var s	= q1[1];
				var ch	= s.substring(s.length - 1, s.length);

				while (ch == ' ')
				{
					s	= s.substring(0, s.length - 1);
					ch	= s.substring(s.length - 1, s.length);
				}

				Text = s + Tag2 + q[1] + this.end + q[2];
			}
		}

		return Text;
	}

	MarkUp(Tag, Text, Tag2, onNewLine, expand, strip)
	{
		var skip	= 0;
		if (expand == 0)
			skip = 1;
		var r		= '';
		var fIn		= false;
		var fOut	= false;
		var add		= 0;
		var f		= false;
		var w		= /^ {2}( *)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))/u;
		Text		= Text.replace(/\r/g, '');
		var lines	= Text.split('\n');

		for (var i = 0; i < lines.length; i++)
		{
			if (this.rbegin.test(lines[i]))
				fIn = true;
			if (this.rendb.test(lines[i]))
				fIn = false;
			if (this.rend.test(lines[i]))
				fOut = true;
			if (this.rendb.test(lines[i + 1]))
			{
				fOut = true;
				lines[i + 1]	= lines[i + 1].replace(this.rend, '');
				lines[i]		= lines[i] + this.end;
			}

			if (r != '')
			{
				r += '\n';
			}

			if (fIn && strip == 1)
			{
				if (this.rbegin.test(lines[i]))
				{
					lines[i]	= lines[i].replace(this.rbegin, '');
					f			= true;
				}
				else
				{
					f = false;
				}

				//	alert(lines[i].replace(new RegExp("\n", "g"), "|").replace(new RegExp(" ", "g"), "_"));
				lines[i]		= lines[i].replace(w, '$1');
				//	alert(lines[i].replace(new RegExp("\n", "g"), "|").replace(new RegExp(" ", "g"), "_"));
				if (f)
				{
					lines[i]	= this.begin + lines[i];
				}
			}

			/*
			fIn &&
			onNewLine == 0 // adding tags
			onNewLine == 1 // adding tags if first line
			onNewLine == 2 // adding tags if first_and_last line, else
			// adding first tag if first or adding last one if last
			// else adding unchanged text
			*/
			if (fIn && (onNewLine == 0 | (onNewLine == 1 && add == 0) | (onNewLine == 2 && (add == 0 || fOut))))
			{
				//adding tags
				if (expand == 1)
				{
					l = lines[i];
					if (add == 0)
						l = this._LSum(Tag, l, skip);
					if (fOut)
						l = this._RSum(l, Tag2);
					if (add != 0 && onNewLine != 2)
						l = this._LSum(Tag, l, skip);
					if (!fOut && onNewLine != 2)
						l = this._RSum(l, Tag2);
					r += l;
				}
				else
				{
					/*
					don't expand. that means
					if first line, replacing first and concatenating second
					if last, concatenating first and replacing second
					if first and last, then replacing both
					else concatenating
					 */
					//	alert(lines[i].replace(/\n/g, '|').replace(/ /g, '_'));
					//	alert(lines[i+1].replace(/\n/g, '|').replace(/ /g, '_'));
					var l = this._TSum(lines[i], Tag, Tag2, skip);

					if (add != 0 && onNewLine != 2)
					{
						l = this._LSum(Tag, l, skip);
					}

					if (!fOut && onNewLine != 2)
					{
						l = this._RSum(l, Tag2);
					}

					r += l;
				}

				add++;
			}
			else
			{
				//adding unchanged text
				r += lines[i];
			}

			if (fOut)
			{
				fIn = false;
			}
		}

		return r;
	}

	keyDown(e)
	{
		if (!this.enabled)
			return;
		if (!e)
			e = window.event;
		var q,
			lines,
			totalLines,
			re,
			str,
			sel,
			q2,
			z;
		var justenter	= false;
		var wasEvent	= false;
		var res			= false;
		var remundo		= false;
		var noscroll	= false;
		var t			= this.area;
		var Key			= e.keyCode;
		if (Key == 0)
			Key = e.key;
		if (Key == 8 || Key == 13 || Key == 32 || (Key > 45 && Key < 91) || (Key > 93 && Key < 112)
			|| (Key > 123 && Key < 144) || (Key > 145 && Key < 255)) {
			remundo = Key;
		}
		if (e.altKey && !e.ctrlKey)
			Key = Key + 4096;
		if (e.ctrlKey)
			Key = Key + 2048;

		if (e.type == 'keypress' && this.checkKey(Key))
		{
			e.preventDefault();
			e.stopPropagation();

			return false;
		}

		if (e.type == 'keyup' && (Key == 9 || Key == 13))
		{
			return false;
		}

		var scroll		= t.scrollTop;
		var undotext	= t.value;
		var undosels	= t.selectionStart;
		var undosele	= t.selectionEnd;

		str				= t.value.substr(t.selectionStart, t.selectionEnd - t.selectionStart);
		sel				= (str.length > 0);

		// take an autocomplete
		if (this.autocomplete)
		{
			if (this.autocomplete.keyDown(Key, e.shiftKey))
			{
				res = true;
				Key = -1;
			}
		}

		switch (Key)
		{
			case 2138: // Z
				if (this.undotext)
				{
					t.value = this.undotext;
					t.setSelectionRange(this.undosels, this.undosele);
					this.undotext = '';
				}
				break;
			case 9: // Tab

			//	case 2132: // T -- disabled because conflict with FireFox Ctrl+T shortcut
			case 4181: // U
			case 4169: // I
				if (this.tab || Key != 9)
				{
					if (e.shiftKey || Key == 4181)
					{
						res = this.unindent();
					}
					else
					{
						res = this.insTag('  ', '', 0, 1);
					}
				}
				break;
			case 2097: // 1
				res = this.insTag('==', '==', 0, 1);
				break;
			case 2098: // 2
				res = this.insTag('===', '===', 0, 1);
				break;
			case 2099: // 3
				res = this.insTag('====', '====', 0, 1);
				break;
			case 2100: // 4
				res = this.insTag('=====', '=====', 0, 1);
				break;
			case 2101: // 5 (broken)
				res = this.insTag('======', '======', 0, 1);
				break;
			//case 2102: // 6 (broken)
			//res = this.insTag('=======', '=======', 0, 1);
			//break;
			case 2109: // =
				if (sel)
					res = this.insTag('++', '++');
				break;
			case 2143: // _
				//	if (sel) //&& e.shiftKey)
				res = this.insTag('', '\n----\n', 2);
				break;
			case 2114: // B
				if (sel)
					res = this.insTag('**', '**');
				break;
			case 2131: // S
				if (sel)
					res = this.insTag('--', '--');
				break;
			case 2133: // U
				if (sel)
					res = this.insTag('__', '__');
				break;
			case 2121: // I
				if (sel)
					res = this.insTag('//', '//');
				break;
			case 2122: // J
				if (sel)
					res = this.insTag('!!', '!!', 2);
				break;
			case 2120: // H
				if (sel)
					res = this.insTag('??', '??', 2);
				break;
			case 4179: // Alt + S
				try {
					if (weSave != null)
						weSave();
				}
				catch (e) {
				}
				break;
			case 2124: // L
			case 4172:
				if (e.shiftKey && e.ctrlKey)
				{
					res = this.insTag('  * ', '', 0, 1, 1);
				}
				else if (e.altKey || e.ctrlKey)
				{
					res = this.createLink(e.altKey);
				}
				break;
			case 2127: // O
			case 2126: // N
				if (e.ctrlKey && e.shiftKey)
				{
					res = this.insTag('  1. ', '', 0, 1, 1);
				}
				break;
			case 13:
			case 2061:
			case 4109:
				if (e.ctrlKey)
				{
					// Ctrl + Enter
					try {
						if (weSave != null)
							weSave();
					}
					catch (e) {
					}
				}
				else if (e.shiftKey)
				{
					// Shift + Enter
					res = false;
				}
				else
				{
					var text	= t.value;
					text		= text.replace(/\r/g, '');
					var sel1	= text.substr(0, t.selectionStart);
					var sel2	= text.substr(t.selectionEnd);

					re			= new RegExp('(^|\n)(( +)((([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))|))(' + (this.enterpressed ? '\\s' : '[^\r\n]') + '*)' + '$', 'u');
					q			= sel1.match(re);

					if (q != null)
					{
						if (!this.enterpressed)
						{
							if (q[3].length % 2 == 1)
							{
								q[2] = '';
							}
							else
							{
								re = /([1-9]\d*)([.]|[)])/;
								q2 = q[2].match(re);

								if (q2 != null)
								{
									q[2] = q[2].replace(re, String(Number(q2[1]) + 1) + q2[2]);
								}
							}
						}
						else
						{
							sel1 = sel1.replace(re, '');
							q[2] = '';
						}

						t.value		= sel1 + '\n' + q[2] + sel2;
						sel			= q[2].length + sel1.length + 1;
						t.setSelectionRange(sel, sel);

						if (t.childNodes[0] != null)
						{
							t.childNodes[0].nodeValue = t.value;
							var temp = document.createRange();
							temp.setStart(t.childNodes[0], sel - 2);
							temp.setEnd(t.childNodes[0], sel);
						}

						// t.scrollIntoView(true);
						z			= t.selectionStart;
						lines		= t.value.substr(0, z).split('\n').length - 1;
						totalLines	= t.value.split('\n').length - 1;

						if (scroll + t.offsetHeight + 25 > Math.floor((t.scrollHeight / (totalLines + 1)) * lines))
						{
							t.scrollTop = Math.floor((t.scrollHeight / (totalLines + 1)) * lines) - t.offsetHeight + 20;
							t.focus();
							noscroll = true;
						}

						res = true;
					}

					justenter = true;
				}

				break;
		}

		this.enterpressed = justenter;

		if (!res && remundo)
		{
			// alert(remundo+"|"+Key+"|"+this.undotext1);
			this.undotext = '';
		}

		if (res)
		{
			this.area.focus();

			this.undotext	= undotext;
			this.undosels	= undosels;
			this.undosele	= undosele;
			if (wasEvent)
				return true;
			e.cancelBubble	= true;
			e.preventDefault();
			e.stopPropagation();

			if (!noscroll)
				t.scrollTop = scroll;
			e.returnValue	= false;

			return false;
		}
	}

	getDefines()
	{
		var t			= this.area;
		var text		= t.value;
		this.ss			= t.selectionStart;
		this.se			= t.selectionEnd;
		this.sel1		= text.substr(0, this.ss);
		this.sel2		= text.substr(this.se);
		this.sel		= text.substr(this.ss, this.se - this.ss);
		this.str		= this.sel1 + this.begin + this.sel + this.end + this.sel2;

		this.scroll		= t.scrollTop;
		this.undotext	= t.value;
		this.undosels	= t.selectionStart;
		this.undosele	= t.selectionEnd;
	}

	setAreaContent(str)
	{
		var t		= this.area;
		var q		= str.match(new RegExp('((.|\n)*)' + this.begin)); //?:
		var l		= q[1].length;
		q			= str.match(new RegExp(this.begin + '((.|\n)*)' + this.end));
		var l1		= q[1].length;
		str			= str.replace(this.rbegin, '');
		str			= str.replace(this.rend, '');
		t.value		= str;
		t.setSelectionRange(l, l + l1);

		t.scrollTop	= this.scroll;
	}

	insTag(Tag, Tag2, onNewLine, expand, strip)
	{
		/*
		onNewLine:
			0 - add tags on every line inside selection
			1 - add tags only on the first line of selection
			2 - add tags before and after selection
			//3 - add tags only if there's one line -- not implemented
		
		expand:
			0 - add tags on selection
			1 - add tags on full line(s)
		*/
		if (onNewLine == null)
			onNewLine = 0;
		if (expand == null)
			expand = 0;
		if (strip == null)
			strip = 0;
		var t = this.area;
		t.focus();
		this.getDefines();
		// alert(Tag + " | " + Tag2 + " | " + onNewLine + " | " + expand + " | " + strip);
		var str = this.MarkUp(Tag, this.str, Tag2, onNewLine, expand, strip);
		this.setAreaContent(str);

		return true;
	}

	unindent()
	{
		var t		= this.area;
		t.focus();
		this.getDefines();
		var r		= '';
		var fIn		= false;
		var lines	= this.str.split('\n');
		var rbeginb	= new RegExp('^' + this.begin);

		for (let value of lines)
		{
			var line = value;

			if (this.rbegin.test(line))
			{
				fIn			= true;
				rbeginb		= new RegExp('^' + this.begin + '([ ]*)');
				line		= line.replace(rbeginb, '$1' + this.begin); // catch first line
			}

			if (this.rendb.test(line))
			{
				fIn = false;
			}

			if (r != '')
			{
				r += '\n';
			}

			if (fIn)
			{
				r += line.replace(/^(( {2})|\t)/, '');
			}
			else
			{
				r += line;
			}

			if (this.rend.test(line))
			{
				fIn = false;
			}
		}

		this.setAreaContent(r);

		return true;
	}

	createLink(isAlt)
	{
		var t = this.area;
		t.focus();
		this.getDefines();
		var n = /\n/;

		if (!n.test(this.sel))
		{
			if (!isAlt)
			{
				var lnk = prompt(lang.Link + ':', this.sel);
				if (lnk == null)
					lnk = this.sel;
				var sl = prompt(lang.TextForLinking + ':', this.sel);
				if (sl == null)
					sl = '';
				this.sel = lnk + ' ' + sl;
			}

			let str		= this.sel1 + '((' + this.trim(this.sel) + '))' + this.sel2;
			t.value		= str;
			t.setSelectionRange(this.sel1.length, str.length - this.sel2.length);

			return true;
		}

		return false;
	}

	help()
	{
		var s = '';

		s = '				WikiEdit 3.22 \n';
		s += '	© Roman Ivanov, WackoWiki Team 2003-2023	 \n';
		s += '	https://wackowiki.org/doc/Dev/Projects/WikiEdit \n';
		s += '\n';
		s += lang.HelpAboutTip;

		alert(s);
	}
}
