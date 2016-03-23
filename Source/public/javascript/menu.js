/* COPYRIGHT 2002(C) INETOPIA. ALL RIGHTS RESERVED. ALLE RECHTE VORBEHALTEN. */

var divDOM = '';
var timer  = 0;
var _div   = new Array(); 
var _ver = parseInt( navigator.appVersion );
var _num_div=0;

function _div_anz()
{
  return _num_div;
}

function _div_getdiv_(name) 
{
   var divID=null;
   switch (divDOM) 
   {
      case 'NN4': divID = document.layers[name]; 		 break;
      case 'IE4': divID = document.all[name]; 			 break;
      case 'DOM': divID = document.getElementById(name); break;
   }
   return divID;
}

function _div_hide( id )
{
  switch( divDOM )
  {
    case 'NN4': document.layers[ id ].visibility    = "hidden";  break;
	case 'DOM': _div_getdiv_( id ).style.visibility = "hidden";  break;//_div_getdiv_( id ).style.visible = "show";  break;
	case 'IE4': _div_getdiv_( id ).style.visible    = "hide";    break;
  }
}

function _div_resize()
{
   if( divDOM == 'DOM' || divDOM == 'IE4' )
   {
    for( var i=1; i<=_div_anz(); i++ )
	{
	   _div_getdiv_("d"+i).style.left  =  _div_getdiv_("m"+i).offsetLeft;
	   _div_getdiv_("d"+i).style.top   =  _div_getdiv_("m"+i).offsetTop;
  
	   //if( _ver >= 5 )
	   //{
	     _div_getdiv_("d"+i).style.top   =  _div_getdiv_("m"+i).offsetTop + _div_getdiv_("m"+i).offsetHeight;		
	   //}
	}
  }
  else if( divDOM == 'NN4' )
  {
    for( var i=1; i<=_div_anz(); i++ )
	{
      document.layers["d"+i].top  = document.layers["m"+i].pageY + document.layers["m"+i].document.height;
	  document.layers["d"+i].left = document.layers["m"+i].pageX;
	}
  }
  else
  {
	//alert("error");
  }
}

function _div_show( id )
{
  _div_hideMenus();
  _div_resize();
  switch( divDOM )
  {
      case 'NN4': document.layers[ id ].visibility    = "show";    break;
	  case 'DOM': _div_getdiv_( id ).style.visibility = "visible"; break;//_div_getdiv_( id ).style.visible = "show";  break;
 	  case 'IE4': _div_getdiv_( id ).style.visible    = "show";    break;
  }
}

function _div_InitEvents()
{
  /*Überwachung von Internet Explorer initialisieren*/
  if(!window.Weite && document.body && document.body.offsetWidth)
  {
     window.onresize = _div_resize;
  }
  /*Überwachung von Netscape initialisieren*/
  if(!window.Weite && window.innerWidth)
  {
    window.onresize = _div_resize;
  }

}


function _div_init( anz_div ) 
{
  _num_div = anz_div;

  divDOM='NON';
  if (document.layers)  		divDOM = 'NN4'; 
  if (document.all) 			divDOM = 'IE4'; 
  if (document.getElementById)  divDOM = 'DOM';
  _div_InitEvents();
  _div_resize(); 
  _div_hideMenus();
}

function _div_hideMenus()
{
  for( var i=1; i<=_div_anz(); i++ )
  {
     _div_hide( "d"+i );
  }//for
}


function startTime()
{
    clearTimeout( timer );
    timer = setTimeout("_div_hideMenus()", 300 );
}

function stopTime()
{
  clearTimeout( timer );
}

/*
  function On(img,name,nr,Text) 
  {
    var p=getPic(name+nr);
    if (p && ver) p.src=img[parseInt(nr)].src;
    window.status=Text;
    return true;
  }

  function Off(name,nr) 
  {        
    var p=getPic(name+nr);
    if (p && ver) p.src=off.src;
    window.status='';
    return true;
  }

*/
function getPic(n)  
{
    var p=document[n];
	for( var i=1; i<=_div_anz(); i++ )
	{
	  if (!p) p=document['d'+i].document[n]; 
	}
    return p;
}

function On( img, nr, text )
{
   var p=getPic( img+nr );
   if( p ) p.src = ".../pics/arrow.gif";
   window.status = text;
    return true;
}

function Off(img, nr)
{
   var p=getPic( img+nr );
   if( p ) p.src = ".../pics/leer.gif";
   window.status = '';
    return true;
}