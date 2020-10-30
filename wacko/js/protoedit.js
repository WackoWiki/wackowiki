/* 
////////////////////////////////////////////////////////////////////////
// ProtoEdit                                                          //
// v. 2.20                                                            //
////////////////////////////////////////////////////////////////////////

For license see LICENSE.TXT
*/
var isDOM		= document.getElementById; // DOM1 browser
var ua			= navigator.userAgent.toLowerCase();
var ProtoEdit	= function () {
	this.enabled	= true;
	this.buttons	= [];
};

ProtoEdit.prototype._init = function (id, rte)
{
	this.id				= id; // id - id of textarea
	this.area			= document.getElementById(id); // area - textarea object
	this.area._owner	= this; // area._owner - this

	// rte - id of rte frame 
	if (rte)
	{
		document.getElementById(rte).contentWindow.document.addEventListener('keypress', function (ev){
			document.getElementById(id)._owner.keyDown(ev)
		}, true);
		document.getElementById(rte).contentWindow.document.addEventListener('keyup', function (ev) {
			document.getElementById(id)._owner.keyDown(ev)
		}, true);
	} 
	else
	{
		this.area.addEventListener('keypress', function (ev) {
			this._owner.keyDown(ev)
		}, true);
		this.area.addEventListener('keyup', function (ev) {
			this._owner.keyDown(ev)
		}, true);
	}
};

ProtoEdit.prototype.enable = function ()
{
	this.enabled = true;
};

ProtoEdit.prototype.disable = function ()
{
	this.enabled = false;
};

ProtoEdit.prototype.KeyDown = function ()
{
	if (!this.enabled) return;
	return true;
};

ProtoEdit.prototype.insTag = function (Tag, Tag2)
{
	if (isMZ)
	{
		var ss			= this.area.scrollTop;
		sel1			= this.area.value.substr(0, this.area.selectionStart);
		sel2			= this.area.value.substr(this.area.selectionEnd);
		sel				= this.area.value.substr(this.area.selectionStart, this.area.selectionEnd - this.area.selectionStart);
		this.area.value	= sel1 + Tag + sel + Tag2 + sel2;
		selPos			= Tag.length + sel1.length + sel.length + Tag2.length;
		this.area.setSelectionRange(sel1.length, selPos);
		this.area.scrollTop = ss;
	} 
	else
	{
		this.area.focus();
		sel			= document.selection.createRange();
		sel.text	= Tag + sel.text + Tag2;
		this.area.focus();
	}

	return true;
};

ProtoEdit.prototype.createToolbar = function (id)
{
	wh		= '';
	html	= '<ul id="buttons_' + id + '" class="toolbar">' + '  ';

	for (var i = 0; i < this.buttons.length; i++)
	{
		var btn = this.buttons[i];

		if (btn.name == ' ')
		{
			html += ' <li> </li>\n';
		}
		else if (btn.name == 'customhtml')
		{
			html += btn.desc;
		}
		else
		{
			html += ' <li class="we-'+ btn.name + '"><div id="' + btn.name + '_' + id + '" onmouseover=\'this.className="btn-hover";\' '
				+ 'onmouseout=\'this.className="btn-";\' class="btn-" '
				+ 'onclick="this.className=\'btn-pressed\';' + btn.actionName + '('
				+ btn.actionParams + ')"><img src="' + this.imagesPath
				+ 'spacer.png" ' + wh + ' alt="' + btn.desc + '" title="' + btn.desc
				+ '"></div></li>\n';
		}
	}

	html += '</ul>\n';

	return html;
};

ProtoEdit.prototype.addButton = function (name, desc, actionParams, actionName)
{
	if (actionName == null)
	{
		actionName = this.actionName;
	}

	var i							= this.buttons.length;
	this.buttons[i]					= {};
	this.buttons[i].name			= name;
	this.buttons[i].desc			= desc;
	this.buttons[i].actionName		= actionName;
	this.buttons[i].actionParams	= actionParams;
};

ProtoEdit.prototype.checkKey = function (k)
{
	if (k == 85 + 4096 || k == 73 + 4096 || k == 49 + 2048 || k == 50 + 2048 || k == 51 + 2048 || k == 52 + 2048 || k == 53 + 2048 || k == 54 + 2048 ||
		k == 76 + 4096 || k == 76 + 2048 || k == 78 + 2048 || k == 79 + 2048 || k == 66 + 2048 || k == 83 + 2048 ||
		k == 85 + 2048 || k == 72 + 2048 || k == 73 + 2048 || k == 74 + 2048 || k == 84 + 2048 || k == 2109 ||
		k == 2124 + 32 || k == 2126 + 32 || k == 2127 + 32 || k == 2114 + 32 || k == 2131 + 32 ||
		k == 2133 + 32 || k == 2121 + 32 || k == 2120 + 32 || k == 2122 + 32)
	{
		return true;
	}
	else
	{
		return false;
	}
};

ProtoEdit.prototype.addEvent = function (el, evname, func)
{
	el.addEventListener(evname, func, true);
};

ProtoEdit.prototype.trim = function (s2)
{
	if (typeof s2 != 'string')
	{
		return s2;
	}

	var s	= s2;
	var ch	= s.substring(0, 1);

	// check for spaces at the beginning of the string
	while (ch == ' ')
	{
		s	= s.substring(1, s.length);
		ch	= s.substring(0, 1);
	}

	ch = s.substring(s.length - 1, s.length);

	// check for spaces at the end of the string
	while (ch == ' ')
	{
		s	= s.substring(0, s.length - 1);
		ch	= s.substring(s.length - 1, s.length);
	}

	// note that there are two spaces in the string - look for multiple spaces within the string
	while (s.indexOf('  ') != - 1)
	{
		// again, there are two spaces in each of the strings
		s	= s.substring(0, s.indexOf('  ')) + s.substring(s.indexOf('  ') + 1, s.length);
	}

	return s; // return the trimmed string back to the user
};
