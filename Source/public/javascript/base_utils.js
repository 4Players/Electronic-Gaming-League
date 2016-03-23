// ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
// 
//
// Purpose:
// ================================================================================================================


//------------------------------------------------------------------
// Purpose: 
//------------------------------------------------------------------
function OpenPopup( file, page, parameter )
{
	hWindow = window.open( file+"?page="+page+"&"+parameter, "popup", "width=500,height=500,scrollbars" );
	hWindow.focus();
}


//------------------------------------------------------------------
// Purpose: 
//------------------------------------------------------------------
function OpenDetailedPopup( file, page, parameter, width, height )
{
	hWindow = window.open( file+"?page="+page+"&"+parameter, "popup", "resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=1,toolbar=0,width="+width+",height="+height );
	hWindow.focus();
}


//------------------------------------------------------------------
// Purpose: 
//------------------------------------------------------------------
function OpenMatchReport( match_id )
{
	OpenPopup( "popup.php", "match.report", "match_id="+match_id  );
}


//------------------------------------------------------------------
// Purpose: 
//------------------------------------------------------------------
function OpenCupView( file, page, parameter, width, height )
{
	self.name = "egl_main";
	OpenDetailedPopup( file, page, parameter, width, height);
}




//------------------------------------------------------------------------------
// Purpose: sets the bg color of some objects
//  Output: true/false
//------------------------------------------------------------------------------
function setbgColor( color, sp_color, part_id, num_rounds )
{
	if( part_id == -1 || part_id == 0 ) return 0;
	for( var i=0; i < num_rounds; i++ )
	{
		var obj = document.getElementById('enc_'+i+'_'+part_id);
		if( obj )
		{
			if( i == num_rounds-1 )
			{
				obj.style.backgroundColor = color; //sp_color;
			}
			else
			{
				obj.style.backgroundColor = color;
			}
		}
	}//for
	return true;
}// 


function set_style_bg( obj, color )
{
	obj.style.backgroundColor = color;
}




//------------------------------------------------------------------------------
// Purpose: 
//  Output: true
//------------------------------------------------------------------------------
function ClearText( text )
{
	text.value = "";
	return true;
}

/*
document.getElement = function (anElementID) 
{
	return document.getElementById ? document.getElementById(anElementID) : document.all ? document.all[anElementID] : document.layers ? document.layers[anElementID] : 'undefined';
}*/


function textbox_set_style(obj, border_color, bg_color, font_color )
{
	
	obj.style.borderColor 		= border_color;
	obj.style.color 			= "#000000"; //font_color;
	obj.style.backgroundColor 	= bg_color;
}


	
	