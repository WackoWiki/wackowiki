function undef(param)
{
	return param;
}

// all_init() initializes all js features:
//   * WikiEdit
//   * Doubleclick editing
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

function userSessionHeartbeat(duration, ename)
{
	var sessioncounter = setInterval(function ()
	{
		// 1. Prepare new XMLHttpRequest
		var xhr = new XMLHttpRequest();
		var url = window.location.href + '?_autocomplete=1&rnd=' + Math.random();

		xhr.onreadystatechange = function()
		{
			if (xhr.readyState == 4 && xhr.status != 200)
			{
				// Error handling
				//alert(xhr.status + ': ' + (xhr.statusText ? xhr.statusText : 'Unknown')); // E.g.: 404: Not Found
				var div = document.createElement('div');
				div.className = 'msg error';
				div.innerHTML = lang.SessionExpiredEditor.replace(/\n/g, '<br>');
				alert(lang.SessionExpiredEditor);
				document.getElementsByName(ename)['0'].prepend(div);

				var list;
				list = document.getElementsByClassName('btn-ok');
				for (let value of list)
				{
					value.disabled = true;
				}

				list = document.getElementsByClassName('btn-cancel');
				for (let value of list)
				{
					value.disabled = true;
				}

				clearInterval(sessioncounter);
			}

			if (xhr.status == 200)
			{
				// Response handling
				//alert( xhr.responseText ); // responseText output
			}
		};

		// 2. Configure: GET-request to url in async mode
		xhr.open('GET', url, true);
		// 3. Send heartbeat request
		xhr.send();

	}, duration * 1000);
}
