var isDOM=document.getElementById;
var isIE=document.all && document.all.item;
var isMZ=isDOM && (navigator.appName=="Netscape");
var isO=window.opera && isDOM;

function undef(param) { return param; }

// Smooth scrolling on the page
function travelA( Aname, quick, noplus )
{
  if (isMZ && navigator.userAgent.substr(navigator.userAgent.indexOf("Gecko/")+6,4)=="2003" ) isMZ=false;
  if (isMZ && navigator.userAgent.substr(navigator.userAgent.indexOf("Gecko/")+6,4)=="2002" ) isMZ=false;
  if (!isIE && !isMZ) return true;
  var value=10;
  if (noplus) value=0;
  if (document.all)
   z = document.all[Aname];
  else
  {
   a = document.getElementsByTagName("A");
   aLength = a.length;
   for (var i = 0; i < aLength; i++)
   {
    an = a[i].getAttribute("name");
    if (an!=null && an==Aname)
     break;
   }
   z = a[i];
  }
//  z = document.all ? document.all[Aname] : document.getElementById(Aname);
  if (z == undef()) return true;
  var x=0;
  var y=0;
  do {
    x += parseInt(isNaN(parseInt(z.offsetLeft))?0:z.offsetLeft);
    y += parseInt(isNaN(parseInt(z.offsetTop))?0:z.offsetTop);
  } while (z=z.offsetParent)
  travelto( x,  y-value, quick );
  return true;
}

// Auto scroll
function travelto(x, y, quick )
{
  if (document.documentElement) var d = document.documentElement;
  else var d = document.body;
  if (quick)
  {
      ox = d.scrollLeft;
      oy = d.scrollTop;
      dx = (x - ox);
      dx = sign(dx) * Math.ceil(Math.abs(dx));
      dy = (y - oy);
      dy = sign(dy) * Math.ceil(Math.abs(dy));
      window.scrollBy(dx, dy);
    return;
  }
  do
    {
      ox = d.scrollLeft;
      oy = d.scrollTop;
      dx = (x - ox) / 10;
      dx = sign(dx) * Math.ceil(Math.abs(dx));
      dy = (y - oy) / 10;
      dy = sign(dy) * Math.ceil(Math.abs(dy));
      window.scrollBy(dx, dy);
      cx = d.scrollLeft;
      cy = d.scrollTop;
    }
  while (( (ox-cx) != 0 ) || ( (oy-cy) != 0 ));
}

var ok;

function sign(x)
{
  if (x > 0) return 1;
  if (x < 0) return -1;
  return 0;
}


 var wikiedit;
 var dbclick;
 var edit;

 function all_init () // initialization everything
 {
  if (wikiedit)
   we_init(wikiedit);
  if (dbclick)
   dclick(dbclick);
  init_travel();
  crit_init();
 }

 function dclick(frame)
 {
  if (edit)
  if(isIE || isO){
    document.ondblclick=function(){
      op = event.srcElement;
      while (op!=null && op.className!=frame && op.tagName!="BODY")
        op=op.parentElement;
      if (op.className==frame) {
       document.location=edit;
      }
      return true;
    }
  }else if (isMZ) {
  document.addEventListener("dblclick", mouseClick, true);
  }

 }

 function mouseClick(event)
 {
     op = event.target;
     while (op!=null && op.className!=dbclick && op.tagName!="BODY")
       op=op.parentNode;
     if (op!=null && op.className==dbclick) {
      document.location=edit;
     }
 }

 function init_travel()
 {
  a = document.all ? document.all : document.getElementsByTagName("*");
  aLength = a.length;
  l = window.location.href;
  if (l.indexOf("#")!=-1) l = l.substr(0,l.indexOf("#"));
  for (var i = 0; i < aLength; i++)
  {
   if (a[i].tagName == "A" || a[i].tagName == "a")
   {
    ahref = a[i].getAttribute("href");

    if (ahref!=null && ((ahref.substr(0, l.length)==l && ahref.charAt(l.length)=="#") || ahref.charAt(0)=="#"))// && ahref.charAt(l.length+1)=="#")
    {
      if (ahref.charAt(0)=="#") ah = ahref.substr(1, ahref.length-1);
      else ah = ahref.substr(l.length+1, ahref.length-l.length-1);
      a[i].setAttribute("travel", ah);
      a[i].onclick = function (e) { return travel(e); };
//      if (a[i].addEventListener) a[i].addEventListener("click", travel, false);
//      else if (a[i].attachEvent) a[i].attachEvent("onclick", travel);
    }
   }
  }
 }

 function travel(e)
 {
  d = window.event ? window.event.srcElement : e.currentTarget;
  if (!d.getAttribute("travel")) return;
  s = d.getAttribute("travel");
  return travelA(s);
 }

 function weSave()
 {
  if (confirm("Really save?"))
  {
   document.forms.edit[0].click();
  }
 }

var DOTS = "#define x_width 2\n#define x_height 1\nstatic char x_bits[]={0x01}";

// -----------------------------------------------------------------------------------------------
// Confirms leaving the page when there are unsaved changes
// Courtesy of http://htmlcoder.visions.ru/JavaScript/?26
// slightly modified by Kuso Mendokusee
// slightly modified by Kukutz
var root = window.addEventListener || window.attachEvent ? window : document.addEventListener ? document : null;
var cf_modified = false;
var WIN_CLOSE_MSG = "\nYou did not save changes. Are you sure you want to leave?\n";

function set_modified(e, strict_e){
  if (window.event && !strict_e)
   var el = window.event.srcElement;
  else if (e!=null)
   var el = e.currentTarget;
  if (el!=null)
  {
   el.style.borderColor = "#eecc99";
   el.title = "(field is changed, do not forget to save the changes)";
  }
  cf_modified = true;
}

function ignore_modified(){
  if (typeof(root.onbeforeunload) != "undefined") root.onbeforeunload = null;
}

function check_cf(){
  if (cf_modified) return WIN_CLOSE_MSG;
}

function crit_init(){
  if (undef() == root.onbeforeunload) root.onbeforeunload = check_cf;
  else return;

  var thisformcf;
  for (var i = 0; oCurrForm = document.forms[i]; i++){
    if (oCurrForm.getAttribute("cf")) thisformcf=true;
    else thisformcf =false;
    if (oCurrForm.getAttribute("nocf")) thisformcf=false;
    for (var j = 0; oCurrFormElem = oCurrForm.elements[j]; j++){
      if (thisformcf || oCurrFormElem.getAttribute("cf"))
      if (!oCurrFormElem.getAttribute("nocf"))
      {
        if (oCurrFormElem.addEventListener) oCurrFormElem.addEventListener("change", set_modified, false);
        else if (oCurrFormElem.attachEvent) oCurrFormElem.attachEvent("onchange", set_modified);
        if (oCurrFormElem.addEventListener) oCurrFormElem.addEventListener("keypress", set_modified, false);
        else if (oCurrFormElem.attachEvent) oCurrFormElem.attachEvent("onkeypress", set_modified);
      }
    }
    if (oCurrForm.addEventListener) oCurrForm.addEventListener("submit", ignore_modified, false);
    else if (oCurrForm.attachEvent) oCurrForm.attachEvent("onsubmit", ignore_modified);
  }
}

if (root){
  if (root.addEventListener) root.addEventListener("load", crit_init, false);
  else if (root.attachEvent) root.attachEvent("onload", crit_init);
}