var treeopened = null;
function opentree(tree)
{
	var cls = '';
	if (document.getElementById) {
		var el = document.getElementById (tree);
		if (el && el.className) {
			el.className = (el.className == 'navOpened') ? 'navClosed' : 'navOpened';
		}
	}
	if (navigator.appName == 'Microsoft Internet Explorer' && document.documentElement && navigator.userAgent.indexOf ('Opera') == -1) setH();
	return false;
}

function setActiveNode(id)
{
	if (activeItem == id) {
		return false;
	}
	if (activeItem != '' ) {
		var cur = document.getElementById(activeItem);
		cur.className = 'node';
	}
	activeItem = id;
	var el = document.getElementById(id);
	el.className='nodeActive';
	
	return false;
}

function openScreen (id, url)
{
	setActiveNode(id);
	top.mainFrame.workFrame.location.href = url;

	return false;
}

function mover (o)
{
	o.className = 'navTitleOver';
}

function mout (o)
{
	o.className = 'navTitle';
}
