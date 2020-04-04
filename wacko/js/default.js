var isDOM	= document.getElementById;
var isIE	= document.all && document.all.item;
var isMZ	= isDOM && (navigator.appName == 'Netscape');
var isO		= window.opera && isDOM;

function undef(param)
{
	return param;
}

// all_init() initializes all js features:
//   * WikiEdit
//   * Doubleclick editing
window.onload = function ()
{
	// alert('Load Test: OK');
	all_init();
};
var ok;

function sign(x)
{
	if (x > 0) return 1;
	if (x < 0) return - 1;
	return 0;
}

var wikiedit;
var dbclick;
var edit;

//initialization everything
function all_init()
{
	if (wikiedit)
	{
		we_init(wikiedit);
	}

	if (dbclick)
	{
		dclick(dbclick);
	}

	crit_init();
}

// freecap
function new_freecap()
{
	separator	= '?';
	thesrc		= document.getElementById('freecap').src;

	// routing with rewrite OFF
	if (thesrc.indexOf('?page=') !== - 1)
	{
		separator	= '&';
	}

	if (thesrc.indexOf('freecap' + separator) !== - 1)
	{
		thesrc		= thesrc.substring(0, thesrc.lastIndexOf(separator));
	}

	document.getElementById('freecap').src = thesrc + separator + Math.round(Math.random() * 100000);
}

var dbclick = "page";

function dclick(frame)
{
	if (edit)
	if (isIE || isO)
	{
		document.ondblclick = function () {
			op = event.srcElement;

			while (op != null && op.className != frame && op.tagName != 'BODY')
			op = op.parentElement;

			if (op.className == frame)
			{
				document.location = edit;
			}

			return true;
		}
	}
	else if (isMZ)
	{
		document.addEventListener('dblclick', mouseClick, true);
	}
}

function mouseClick(event)
{
	op = event.target;

	while (op != null && op.className != dbclick && op.tagName != 'BODY')
	op = op.parentNode;

	if (op != null && op.className == dbclick)
	{
		document.location = edit;
	}
}

function weSave()
{
	if (confirm(lang.ReallySave))
	{
		document.forms.edit[0].click();
	}
}

var DOTS = '#define x_width 2\n#define x_height 1\nstatic char x_bits[]={0x01}';
// -----------------------------------------------------------------------------------------------
// Confirms leaving the page when there are unsaved changes
// Courtesy of http://htmlcoder.visions.ru/JavaScript/?26
// slightly modified by Kuso Mendokusee
// slightly modified by Kukutz
var root = window.addEventListener || window.attachEvent ? window : document.addEventListener ? document : null;
var cf_modified = false;
var WIN_CLOSE_MSG = '\nYou did not save changes. Are you sure you want to leave?\n';

function set_modified(e, strict_e)
{
	if (window.event && !strict_e)
	{
		var el = window.event.srcElement;
	}
	else if (e != null)
	{
		var el = e.currentTarget;
	}

	if (el != null)
	{
		el.style.borderColor	= '#eecc99';
		el.title				= '(field is changed, do not forget to save the changes)';
	}

	cf_modified = true;
}

function ignore_modified() 
{
	if (typeof (root.onbeforeunload) != 'undefined')
	{
		root.onbeforeunload = null;
	}
}

function check_cf()
{
	if (cf_modified)
	{
		return WIN_CLOSE_MSG;
	}
}

function crit_init()
{
	if (undef() == root.onbeforeunload) root.onbeforeunload = check_cf;
	else return;
	
	var thisformcf;

	for (var i = 0; oCurrForm = document.forms[i]; i++)
	{
		if (oCurrForm.getAttribute('cf'))
		{
			thisformcf = true;
		}
		else
		{
			thisformcf = false;
		}

		if (oCurrForm.getAttribute('nocf'))
		{
			thisformcf = false;
		}

		for (var j = 0; oCurrFormElem = oCurrForm.elements[j]; j++)
		{
			if (thisformcf || oCurrFormElem.getAttribute('cf'))

			if (!oCurrFormElem.getAttribute('nocf'))
			{
				if (oCurrFormElem.addEventListener)
				{
					oCurrFormElem.addEventListener('change', set_modified, false);
				}
				else if (oCurrFormElem.attachEvent)
				{
					oCurrFormElem.attachEvent('onchange', set_modified);
				}

				if (oCurrFormElem.addEventListener)
				{
					oCurrFormElem.addEventListener('keypress', set_modified, false);
				}
				else if (oCurrFormElem.attachEvent)
				{
					oCurrFormElem.attachEvent('onkeypress', set_modified);
				}
			}
		}

		if (oCurrForm.addEventListener) oCurrForm.addEventListener('submit', ignore_modified, false);
		else if (oCurrForm.attachEvent) oCurrForm.attachEvent('onsubmit', ignore_modified);
	}
}

if (root)
{
	if (root.addEventListener) root.addEventListener('load', crit_init, false);
	else if (root.attachEvent) root.attachEvent('onload', crit_init);
}
