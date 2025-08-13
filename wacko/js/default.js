function undef(param)
{
	return param;
}

// all_init() initializes all js features:
//   * WikiEdit
//   * Double click editing
//   * Session heart beat
window.onload = function ()
{
	all_init();
};

var ok;
var wikiedit;
var dbclick = 'page';
var edit;
var timeout;
var ename;

// initialize everything
function all_init()
{
	if (wikiedit)
	{
		we_init(wikiedit);
	}

	if (dbclick)
	{
		dclick();
	}

	if (timeout)
	{
		userSessionHeartbeat(timeout, ename);
	}

	crit_init();
}

// freecap
function new_freecap()
{
	var separator	= '?';
	var thesrc		= document.getElementById('freecap').src;

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

function dclick()
{
	if (edit)
	{
		// skip double-click editing for pages having forms
		const pageShow	= document.getElementById('page-show');
		const form		= pageShow.querySelector('form');

		if (form)
		{
			return;
		}

		document.addEventListener('dblclick', mouseClick, true);
	}
}

function mouseClick(event)
{
	var op = event.target;

	while (op != null && op.className != dbclick && op.tagName != 'BODY')
	{
		op = op.parentNode;
	}

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

// confirms leaving the page when there are unsaved changes
var root = window.addEventListener || window.attachEvent ? window : document.addEventListener ? document : null;
var cf_modified = false;

function set_modified(e, strict_e)
{
	var el;

	if (window.event && !strict_e)
	{
		el = window.event.target;
	}
	else if (e != null)
	{
		el = e.currentTarget;
	}

	if (el != null)
	{
		el.style.borderColor	= '#eecc99';
		el.title				= lang.ModifiedHint;
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
		return '\n' + lang.NotSavedWarning + '\n';
	}
}

function crit_init()
{
	if (undef() == root.onbeforeunload) root.onbeforeunload = check_cf;
	else return;

	var thisformcf, oCurrForm, oCurrFormElem;

	for (var i = 0; oCurrForm = document.forms[i]; i++)
	{
		thisformcf = !!oCurrForm.getAttribute('cf');

		if (oCurrForm.getAttribute('nocf'))
		{
			thisformcf = false;
		}

		for (var j = 0; oCurrFormElem = oCurrForm.elements[j]; j++)
		{
			if (thisformcf || oCurrFormElem.getAttribute('cf'))
			{
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
