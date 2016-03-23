<h2>Updates</h2>

<table width="100%" bgcolor="{#clr_content_border#}" cellpadding="5" cellspacing="1">
 <tr bgcolor="{#clr_content#}">
 	<td>
 		<textarea id="updatedisplay_details" disabled rows="15" style="width:100%"></textarea>
 	</td>
 	<td width="300" valign="top" height="100%">
 	<div>
 	<table width="100%" cellpadding="0" border="0" cellspacing="0" height="100%">
 	 <tr>
 	 	<td valign="top">
 	 		<table cellpadding="5">
 	 		 <tr>
 	 		 	<td><b>Größe:</b></td>
 	 		 	<td><div id="updatedisplay_size"></div></td>
 	 		 </tr>
 	 		 <tr>
 	 		 	<td><b>Version:</b></td>
 	 		 	<td><div id="updatedisplay_version"></div></td>
 	 		 </tr>
 	 		 <tr>
 	 		 	<td><b>Publisher:</b></td>
 	 		 	<td><div id="updatedisplay_publisher"></div></td>
 	 		 </tr> 	 		 
 	 		 <tr>
 	 		 	<td><b>Released:</b></td>
 	 		 	<td><div id="updatedisplay_released"></div></td>
 	 		 </tr>
 	 		 <tr>
 	 		 	<td><b>Update-ID:</b></td>
 	 		 	<td><div id="updatedisplay_id"></div></td>
 	 		 </tr>
 	 		</table>
 	 	
 	 	</td>
 	 </tr>
 	 <tr><td valign="bottom" align="">
 	 	<hr/>
 	 	{include file="buttons/bt_universal.tpl" caption="installieren" link="javascript:install_selected_update();"}
 	 </td></tr>
 	 </table>
	 </div>	
 	
 	</td>
 </tr>
</table>

<table width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content#}">
 <tr bgcolor="{#clr_content_border#}" 
		onclick="javascript:unselect_all_updates();">
	<td width="1%"></td>
 	<td><b>Spezifikation</b></td>
 	<td width="150"><b>Released</b></td>
 </tr>
{section name=lu loop=$latest_updates }
 <tr id="update_{$smarty.section.lu.index}" 
			onclick="javascript:display_update_details('{$latest_updates[lu]->id}'); select_update('update_{$smarty.section.lu.index}', '#FFFFFF');"
			<!--# onmouseover="javascript:assign_update('update_{$smarty.section.lu.index}', '#FFFFFF');" #-->
			onmouseout="javascript:cleanup_assignment('update_{$smarty.section.lu.index}');">
	<td><img src="images/admin/navi/updates.gif"/></td>
	<td>{$latest_updates[lu]->specification}</td>
 	<td>{date timestamp=$latest_updates[lu]->released}</td>
 </tr>
{/section} 
</table>
		
	 


<script language="JavaScript" type="text/javascript" src="javascript/browser_handling.js"></script>

{literal}
<script language="javascript">
	var selected_id	= '';
	var assigned_id = '';
	var selected_update_id = '';

	function unselect_all_updates(){
		for( i=0; i < 10; i++ ){
			var obj = _getElementbyID("update_"+i);
			if( obj ) obj.style.backgroundColor="";
		}
		selected_id='';
		assigned_id='';
	}

	function select_update( id, color ){
		if( id == selected_id ){
			_getElementbyID(id).style.backgroundColor='';
			selected_id='';
		}else {
			unselect_all_updates();
			_getElementbyID(id).style.backgroundColor=color;
			selected_id = id;
		}//if
	}
	
	function assign_update( id, color ){
		if( id != selected_id ){
			_getElementbyID(id).style.backgroundColor=color;
		}//if
	}
	
	function cleanup_assignment( id ){
		if( id != selected_id ){
			_getElementbyID(id).style.backgroundColor='';
		}//if
	}
	
	function display_update_details( update_id ){
		for( i=0; i < num_updates; i++ ){
			if( updates[i]["id"] == update_id ){
				_getElementbyID("updatedisplay_details").value = "Beschreibung:\n-----------\n" + updates[i]["details"];
				_getElementbyID("updatedisplay_size").innerHTML = updates[i]["size"];
				_getElementbyID("updatedisplay_version").innerHTML = updates[i]["version"];
				_getElementbyID("updatedisplay_released").innerHTML = updates[i]["released"];
				_getElementbyID("updatedisplay_publisher").innerHTML = updates[i]["publisher"];
				_getElementbyID("updatedisplay_id").innerHTML = updates[i]["id"];
				selected_update_id = update_id;
			}//if
		}//for
	}
	
	function install_selected_update(){
		document.location=install_location+selected_update_id;
	}
	
</script>
{/literal}

<script language="javascript">
	// ========================================================================
    // copyright (c)2006 by Inetopia. All right reserved. Alle Rechte vorbehalten.
    //
    //
    // visit www.inetpia.de for more information
	// ========================================================================
	var num_updates = {$latest_updates|@count};
	var updates = new Array();
	var install_location = "{$url_file}page=generals.updates.install&update_id=";
	
	
	// create update array
	{section name=lu loop=$latest_updates}
	// 	UPDATE-ID: {$latest_updates[lu]->id}
	updates[{$smarty.section.lu.index}] = new Array();
	updates[{$smarty.section.lu.index}]["id"] = "{$latest_updates[lu]->id}";
	updates[{$smarty.section.lu.index}]["version"] = "{$latest_updates[lu]->version}";
	updates[{$smarty.section.lu.index}]["released"] = "{date timestamp=$latest_updates[lu]->released}";
	updates[{$smarty.section.lu.index}]["publisher"] = "{$latest_updates[lu]->publisher}";
	updates[{$smarty.section.lu.index}]["size"] = "{$latest_updates[lu]->size.value} {$latest_updates[lu]->size.unit}";
	updates[{$smarty.section.lu.index}]["details"] = "{$latest_updates[lu]->details}";
	{/section}
	
</script>
