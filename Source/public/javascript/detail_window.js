
	var IE = document.all?true:false;
	if (!IE) document.captureEvents(Event.MOUSEMOVE)
	document.onmousemove = getMouseXY;
	var tempX = 0;
	var tempY = 0;
	
	function getMouseXY(e) 
	{
		if (IE) 
		{
			tempX = event.clientX + document.body.scrollLeft;
			tempY = event.clientY + document.body.scrollTop;
		}
		else 
		{
			tempX = e.pageX;
			tempY = e.pageY;
		}  
		if (tempX < 0){tempX = 0;}
		if (tempY < 0){tempY = 0;}  
		
		/*
		document.Show.MouseX.value = tempX;
		document.Show.MouseY.value = tempY;*/
		return true;
	}
	
	
	function detailwindow_getdiv(name,divDOM) {
	   var divID=null;
	   switch (divDOM) 
	   {
	      case 'NN4': divID = document.layers[name]; 		 break;
	      case 'IE4': divID = document.all[name]; 			 break;
	      case 'DOM': divID = document.getElementById(name); break;
	   }
	   return divID;
	}	
	
	
	function detailwindow_showdiv( name ){
		var div = detailwindow_getdiv(name, 'DOM');
		if( div )
		{
			div.style.left  =  tempX+10;
			div.style.top   =  tempY+10;
	   		div.style.visibility   =  "visible";	   	
		}
	}
	
	function detailwindow_hidediv( name ){
		var div = detailwindow_getdiv(name, 'DOM');
		if( div )
		{
			div.style.left  =  0;
			div.style.top   =  0;
	   		div.style.visibility   =  "hidden";
		}
	}