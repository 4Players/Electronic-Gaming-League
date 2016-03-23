
/**
* get elements by id
*/
function _getElementbyID( id ){
	return document.getElementById( id )
}

/**
* message check
*/
function MessageCheckAction( message, url ){
	var fRet;
	fRet = confirm(message);
	if( fRet )document.location = url;
}

/**
* replaceIt
*/
function replaceIt(string,suchen,ersetzen) {
	ausgabe = "" + string;
	while (ausgabe.indexOf(suchen)>-1){
		pos= ausgabe.indexOf(suchen);
		ausgabe = "" + (ausgabe.substring(0, pos) + ersetzen +
		ausgabe.substring((pos + suchen.length), ausgabe.length));
	}
	return ausgabe;
}

/**
* add_current_to_pagestore
*/
function add_current_to_pagestore(){
	var url = parent.page.location.href;
	url=replaceIt( url, String.fromCharCode(38), String.fromCharCode(33));		// '&'	=> '|'
	url=replaceIt( url, String.fromCharCode(63), String.fromCharCode(36));		// '?'	=> '$'
	parent.navi.location.href = parent.navi.location.href + "&save_page="+url;
}