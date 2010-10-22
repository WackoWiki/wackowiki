//
//
//  autocomplete for wikiedit testdrive
//
//  (c) 2005 Kuso Mendokusee.
//  mailto:mendokusee@pixel-apes.com

function AutoComplete( wikiedit, handler )
{
  this.wikiedit = wikiedit;
  this.handler  = handler;

  wikiedit.autocomplete = this;

  this.interval  = 500;
  this.wait      = 0;

  this.request_pattern = false;
  this.found_pattern   = "";
  this.found_patterns = false;
  this.found_patterns_selected = -1;
  this.magic_mode = false;

  this.regexp_LinkLetter = /[~a-zA-Z¸¨à-ÿÀ-ß\!\-\.\(\[\/0-9]/;

  this.regexp_LinkWhole  = /^(([\(\[]){2})?((\!\/)|[A-Z¨À-ß\/])[a-zA-Z¸¨à-ÿÀ-ß\-\.\/0-9]+$/;
  this.regexp_LinkCamel  = /[a-z¸à-ÿ\.0-9][A-Z¨À-ß]/;
  this.regexp_LinkStrict = /^([\(\[]){2}.{2,}/;
  this.regexp_LinkSubpage = /^!\/.{2,}/;

}

// add some stuff for visualization
AutoComplete.prototype.addButton = function()
{
  var we = this.wikiedit;
  this.id = "autocomplete_"+this.wikiedit.id;
  we.addButton("customhtml",
              '<li id="'+this.id+'_li" style="display:none"><div style="font:bold 12px Arial; margin:0; padding: 3px 3px 4px 4px;" id="'+this.id + '" '
            + ' onmouseover=\'this.className="btn-pressed";\' '
            + ' onmouseout=\'this.className="btn-";\' class="btn-" '
            + ' onclick="document.getElementById('+"'"+we.id+"')._owner.autocomplete.insertFound();return false;" +'" '
            + ' title="Insert Autocomplete">Autocomplete'
            + '</div>'
            + (isIE?'<div style="display:none" class="autocomplete-inplace" id="'+this.id+'_inplace"><hr /></div>':'')
            + '</li>'
            + '<li id="'+this.id+'_reset" style="display:none"><div style="font:12px Arial; padding: 3px 3px 4px 4px;" '
            + 'onmouseover=\'this.className="btn-hover";\' '
            + 'onmouseout=\'this.className="btn-";\' class="btn-" '
            + ' title="Hide Autocomplete" '
            + 'onclick="document.getElementById('+"'"+we.id+"')._owner.autocomplete.reset();return false;" +'" '
            + '>&times;</div>'
            + '</li>'
            );
}

// ------ inplace specific routines ------ ( MSIE ONLY ) ------
AutoComplete.prototype.selectInplace = function(pos)
{
  if (this.found_patterns === false) return;
  var _pos = this.found_patterns_selected;
  if (_pos >= 0)
  {
    var _item = document.getElementById( this.wikiedit.id+"_item_"+_pos );
    if (_item) _item.className = "";
  }

  if (pos < 0) pos = this.found_patterns.length-1;
  if (pos >= this.found_patterns.length) pos = 0;

  if (pos >= 0)
  {
    var _item = document.getElementById( this.wikiedit.id+"_item_"+pos );
    if (_item) _item.className = "ac-over-";
    this.found_pattern = this.found_patterns[pos];
    this.found_patterns_selected = pos;
    var ac = document.getElementById( this.id );
    ac.innerHTML = this.found_pattern;
  }
}
AutoComplete.prototype.redrawInplace = function()
{
  if (this.found_patterns.length == 0) return;
  if (!isIE) return; // IE ONLY
  var inplace = document.getElementById( this.id + "_inplace" );
  var contents = "";

  // lets prepare content from this.found_patterns
  for( var i in this.found_patterns )
  {
    var pattern = this.found_patterns[i];
    var div = "<div id='"+this.wikiedit.id+"_item_"+i+"'"+
              " onmouseover='document.getElementById("+'"'+this.wikiedit.id+'"'+")._owner.autocomplete.selectInplace("+'"'+i+'"'+");' "+
              " onclick='document.getElementById("+'"'+this.wikiedit.id+'"'+")._owner.autocomplete.insertFound("+'"'+pattern+'"'+");'>"+
              "<img align=right src='"+this.wikiedit.imagesPath+"z.gif' />"+pattern+"&nbsp;&nbsp;</div>";
    contents += div;
  }

  // now we place out stuff form
  var d = document.body;
  if ((document.compatMode) && (document.compatMode == "CSS1Compat")) d = document.documentElement;
  var d_left = d.scrollLeft;
  var d_top  = d.scrollTop;

  var ta = this.wikiedit.area;
  var sel = document.selection;

  // step 1. calculate position for inplace window
  this.wikiedit.area.focus();
  window.scrollTo( d_left, d_top );
  this.wikiedit.getDefines();
  str = this.wikiedit.str;
  { 
    longtext = this.wikiedit.sel1 + this.wikiedit.sel;
    itempos = longtext.lastIndexOf( this.request_pattern );
    if (itempos >= 0)
      _str = longtext.substr(0, itempos) + this.wikiedit.begin +
            this.request_pattern + this.wikiedit.end +
            longtext.substr(itempos+this.request_pattern.length) + 
            this.wikiedit.sel2;
  }
  this.wikiedit.setAreaContent( _str );
  
  var sel2 = document.selection;
  var sel2_range = sel2.createRange();

  // -- calc x y of ta
  z = ta;
  var x=0;
  var y=0;
  do 
  {
    x += parseInt(isNaN(parseInt(z.offsetLeft))?0:z.offsetLeft);
    y += parseInt(isNaN(parseInt(z.offsetTop))?0:z.offsetTop);
  } 
  while (z=z.offsetParent);

  var left = d.scrollLeft + ta.scrollLeft + sel2_range.boundingLeft-2;
  var top  = d.scrollTop  + ta.scrollTop  + sel2_range.boundingTop+15;

  // step 3. draw window itself
  inplace.innerHTML = contents;
  inplace.style.display = "block";
  inplace.style.position = "absolute";
  inplace.style.left = left;
  inplace.style.top  = top;
  this.selectInplace(0);

  // step 2. restore exact selection observed before "inplace magic"
  this.wikiedit.setAreaContent( str );

}
AutoComplete.prototype.hideInplace = function()
{
  if (!isIE) return;
  var inplace = document.getElementById( this.id + "_inplace" );
  inplace.style.display = "none";
}
// -------------------


// reset autocomplete -- hide all stuff, reset patterns
AutoComplete.prototype.reset = function()
{
  this.request_pattern = false;
  this.found_pattern = false;
  this.magic_mode = false;
  this.visualState("hidden");
}

// inserts found pattern right into textarea
AutoComplete.prototype.insertFound = function( foundPattern )
{
  if (foundPattern == undef()) foundPattern = this.found_pattern;

  state = this.visual_state;
  this.visualState("hidden");
  if (this.request_pattern === false) return;

  var d = document.body;
  if ((document.compatMode) && (document.compatMode == "CSS1Compat")) d = document.documentElement;
  var d_left = d.scrollLeft;
  var d_top  = d.scrollTop;

  this.wikiedit.area.focus();
  this.wikiedit.getDefines();

  window.scrollTo( d_left, d_top );

  str = this.wikiedit.str;
 
  if (state == "404") 
  { // just select word
    longtext = this.wikiedit.sel1 + this.wikiedit.sel;
    itempos = longtext.lastIndexOf( this.request_pattern );
    if (itempos >= 0)
      str = longtext.substr(0, itempos) + this.wikiedit.begin +
            this.request_pattern +        this.wikiedit.end   +
            longtext.substr(itempos+this.request_pattern.length) + 
            this.wikiedit.sel2;
  }
  else
  { // replace by proposition
    itempos = this.wikiedit.sel1.lastIndexOf( this.request_pattern );
    foundPattern = this.StrictLink( foundPattern );
    if (itempos >= 0)
      str = this.wikiedit.sel1.substr(0, itempos) + 
            foundPattern +        
            this.wikiedit.sel1.substr(itempos+this.request_pattern.length) + 
            this.wikiedit.begin + this.wikiedit.sel + this.wikiedit.end + 
            this.wikiedit.sel2;
  }

  this.wikiedit.setAreaContent( str );
  this.reset();
}

// keydown handler. Invoked from wikiedit`s keyDown
// its job is:
//  1. if user is likely typing some WikiName, then invoke recongnizer
//  2. if we have found some patterns, allow to select preferrable one with up-down arrows and Enter/Escape as ok/cancel
AutoComplete.prototype.keyDown = function( key, shiftKey )
{
  // first of all -- inplace movements
  if (this.found_pattern)
  {
    switch( key )
    {
      // case 2080: // Ctrl+Space -- removed due to possible double tapping
      case 13: // Enter
                  if (shiftKey) // Shift+Enter resets & skips
                  {  
                    this.reset();
                    return false; 
                  }
                  this.insertFound();
                  return true;
                  break;
      case 27: // Escape
                  this.reset();
                  return true;
                  break;

      case 38: // Up
                  this.selectInplace( this.found_patterns_selected-1 );
                  return true;
                  break;
      case 40: // Down
                  this.selectInplace( this.found_patterns_selected+1 );
                  return true;
                  break;

    }
  }

  // it is magic key (Ctrl+Space)
  if (!this.found_pattern && key == 2080)
  {
    var pattern = this.checkPattern( this.getPattern(), "magic" );
    if (pattern !== false) 
    {
      this.request_pattern = pattern;
      this.magic_mode = true;
      this.tryComplete( "magic" );
    }
    return true;
  }

  // it is [`\-0-9a-z] key
  // fix it to whole russian subset
  if ((key == 192) || (key == 189) || ((key >= 48) && (key <= 57)) || ((key >= 65) && (key <= 90))
      || this.request_pattern )
  {
    // we will work only if user just stopped typing
    // these lines-o-logic should be rewritten to use "timeout entity" feature of setTimeout
    this.wait++;
    var _pattern = this.getPattern();
    var pattern = this.checkPattern( _pattern, this.magic_mode );
    if (pattern !== false) this.request_pattern = pattern;
    setTimeout( "waitAutoComplete('"+this.wikiedit.id+"','"+this.wait+"')", this.interval );
  }

  return false;

}

// trying to recognize partial pattern (known as "request_pattern")
// 1. checking it for WikiName likeliness
// 2. piping it to server thru ajax method in this.requestPattern
// (magic_button_mode is enabled when Ctrl+Space pressed)
AutoComplete.prototype.tryComplete = function( magic_button_mode )
{ 
  this.wait=0;

  if (this.request_pattern === false) 
  {
    this.reset();
    return;
  }

  this.request_pattern = false;
  var _pattern = this.getPattern()
  var pattern = this.checkPattern( _pattern, magic_button_mode );
  if (pattern !== false) 
  {
    if (magic_button_mode)   this.request_pattern = pattern;
    if (pattern.length > 2)  this.request_pattern = pattern;
    if (_pattern.length > 3) this.request_pattern = pattern;
  }

  if (this.request_pattern === false) 
  {
    this.reset();
    return;
  }

  this.visualState( "seeking" );
  this.requestPattern( this.request_pattern );
}

// finishing recognition process after ajax content arrived
// if success, lightup green else go red with "404"
AutoComplete.prototype.finishComplete = function( found_pattern, all_patterns )
{
  this.found_pattern  = found_pattern;
  this.found_patterns = all_patterns;

  if (this.found_pattern === false)
    this.visualState( "404" );
  else
  {
    this.visualState( "found" );
  }
}
                       
// testing given line on WikiName-likeliness
// some regexps as follows:
// (magic_button_mode is enabled when Ctrl+Space pressed)
AutoComplete.prototype.checkPattern = function ( pattern, magic_button_mode )
{
  this.strict_linking_mode = false;
  if (pattern.match( this.regexp_LinkWhole ))
  {
    if ( pattern.match( this.regexp_LinkStrict ) ) 
    {
      this.strict_linking_mode = true;
      return pattern.substr(2);
    }
    if ( pattern.match( this.regexp_LinkSubpage ) ) 
    {
      this.strict_linking_mode = true;
      return pattern;
    }
    if ( pattern.match( this.regexp_LinkCamel  ) || magic_button_mode ) return pattern;
  }
  return false;
}

// strict linking found pattern if it is not a wikilink itself
AutoComplete.prototype.StrictLink = function ( pattern )
{
  if (this.strict_linking_mode) return pattern;
  if ( pattern.match( this.regexp_LinkCamel  ) ) return pattern;
  return "((" + pattern + "))";
}

// receiving pattern from textarea
// some "range" magic
AutoComplete.prototype.getPattern = function ()
{
  if (isIE)
    var Range = document.selection.createRange();
  else
  {
    var start = this.wikiedit.area.selectionStart;
    var end   = this.wikiedit.area.selectionEnd;
  }
  // go left
  var f=1;
  while (f || 
    (isIE  && (Range.text.charAt(0)).match(this.regexp_LinkLetter))
    ||
    (!isIE && (this.wikiedit.area.value.charAt(start)).match(this.regexp_LinkLetter))
    )
  {
    f=0;
    if (isIE) Range.moveStart('character',-1);
    else      start--;
  }
  if (isIE) Range.moveStart('character',1);
  else      start++;

  if (isIE) return Range.text;
  else      return this.wikiedit.area.value.substr(start, end-start);
}

// visual state routine. Sets some different visual widgets according to given state
AutoComplete.prototype.visualState =  function( to )
{
  var reset  = document.getElementById( this.id+"_reset" );
  var li     = document.getElementById( this.id+"_li" );
  var ac     = document.getElementById( this.id );

  switch (to)
  {
    case "seeking" : 
                      if (this.visual_state == "found") break;
                      li.style.display    = "";
                      reset.style.display = "";
                      ac.innerHTML     = "...";
                      ac.style.color   = "#888888";
                      break;
    case "found" : 
                      li.style.display    = "";
                      reset.style.display = "";
                      ac.innerHTML     = this.found_pattern;
                      ac.style.color   = "#ffffff";
                      ac.style.backgroundColor = "#00cc00";
                      this.redrawInplace();
                      break;
    case "404" : 
                      li.style.display    = "";
                      reset.style.display = "";
                      ac.innerHTML     = this.request_pattern;
                      ac.style.color   = "#ffffff";
                      ac.style.backgroundColor = "#FF0000";
                      this.hideInplace();
                      break;

    case "hidden" :   
                      li.style.display    = "none";
                      reset.style.display = "none";
                      this.hideInplace();
                      break;

  }

  this.visual_state = to;
}

// ajax "XmlHttpRequest" routine.
// builds request to server-side, 
var req;
AutoComplete.prototype.requestPattern =  function( pattern )
{
  var href = this.handler + (this.handler.indexOf('?')>=0? '&' : '?') + "q="+escape(pattern)+
            "&ta_id="+escape(this.wikiedit.area.id)+"&_autocomplete=1&rnd="+Math.random();
  req = window.XMLHttpRequest? 
    new XMLHttpRequest() : 
    new ActiveXObject("Microsoft.XMLHTTP");
  req.onreadystatechange = function() 
  {
    if (req)
    if (req.readyState == 4) 
    {
      var items = req.responseText.split("~~~");
      var _items = new Array();
      for(var i=1; i<items.length; i++)
       _items[i-1] = items[i];
      if (items.length < 2) 
      {
        _items[0] = false;
        _items2 = new Array();
      }
      else _items2 = _items;
      launchFinishComplete( items[0], _items[0], _items2 );
    }
  }
  req.open("GET", href, true);
  req.send(null);
}

// ajax XmlHttpRequest helper routine.
// gets invoked after ajax response arrived
// do invoke appropriate autocomplete method
function launchFinishComplete( ta_id, found, out )
{
  var ta = document.getElementById( ta_id );
  var we = ta._owner;
  var ac = we.autocomplete;
  if (found == "") found = false;
  ac.finishComplete(found, out);
}

// lines-o-logic for "wait until users stops typing"
function waitAutoComplete( ta_id, wait )
{
  var ta = document.getElementById( ta_id );
  var we = ta._owner;
  var ac = we.autocomplete;

  if (ac.wait == wait) ac.tryComplete( ac.magic_mode );
}