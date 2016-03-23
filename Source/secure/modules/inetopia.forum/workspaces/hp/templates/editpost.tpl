{literal}
	<script language="javascript">
	<!--
	
	function insertTEXT( t ){
		insertTAG( t, '' );
	}
		
	function insertTAG(aTag, eTag) 
	{
		var input = document.forms['f'].elements['text'];
		input.focus();
  	
  		/* für Internet Explorer */
		if( typeof document.selection != 'undefined') 
		{
	    	/* Einfügen des Formatierungscodes */
	    	var range = document.selection.createRange();
	    	var insText = range.text;
	    	range.text = aTag + insText + eTag;
	    	/* Anpassen der Cursorposition */
	   		range = document.selection.createRange();
	    	if (insText.length == 0) {
	      		range.move('character', -eTag.length);
	    	} else {
	      		range.moveStart('character', aTag.length + insText.length + eTag.length);      
	    	}
	    	range.select();
  		}
  		/* für neuere auf Gecko basierende Browser */
  		else if(typeof input.selectionStart != 'undefined')
  		{
		    /* Einfügen des Formatierungscodes */
			var start = input.selectionStart;
			var end = input.selectionEnd;
			var insText = input.value.substring(start, end);
			input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
		    /* Anpassen der Cursorposition */
			var pos;
			if (insText.length == 0) 
			{
				pos = start + aTag.length;
			} 
			else 
		    {
		     		pos = start + aTag.length + insText.length + eTag.length;
			}
			input.selectionStart = pos;
			input.selectionEnd = pos;
		}
		/* für die übrigen Browser */
		else
		{
			/* Abfrage der Einfügeposition */
			var pos;
			var re = new RegExp('^[0-9]{0,3}$');
			while(!re.test(pos)) {
				pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
			}
			if(pos > input.value.length) 
			{
				pos = input.value.length;
			}
			/* Einfügen des Formatierungscodes */
			var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
			input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
		}
	}//function insert
	
	
	
	function moveTopic( str, base_link){
		var sel = document.forms['fadmin'].elements['move_forumid'];
		var url = base_link+"&new_forumid="+sel.options[sel.selectedIndex].value;
		/*var fRet;
		fRet = confirm(str);
		if( fRet ){
			url = url + "&shadow=yes";
		}*/
		document.location.href=url;
	}
	
	function questionURL( str, url ){
		var fRet;
		fRet = confirm( str );
		if( fRet ){
			document.location.href=url;
		}
	}
	
	function setTopicType( url ){
		var radio = document.forms['fadmin'].elements['topic_type'];
		var radio_value="";
		for( i=0; i < radio.length; i++ )if( radio[i].checked )radio_value = radio[i].value;
		document.location.href=url+"&type="+radio_value;
	}
	
	-->
	</script>
{/literal}

{if isset($forum)}<h2>{$forum->name|strip_tags|stripslashes}</h2>
	<table>
	<tr>
		<td> > <a href="{$url_file}page={$CURRENT_MODULE_ID}:forums">Forumübersicht</a></td>
	</tr>
	{section name=fpath loop=$forum_path}
	{*if !$smarty.section.fpath.first}>{/if*}
	<tr>
	 <td>{section name=s loop=$smarty.section.fpath.index+1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/section} > <a href="{$url_file}page={$CURRENT_MODULE_ID}:forums&forum_id={$forum_path[fpath]->id}">{$forum_path[fpath]->name}</b></a>
	</tr>
	{/section}
	</table>
	<br/>
{/if}

<h2>Nachricht bearbeiten</h2>
<br/>
<form name="f" action="{$url_file}page={$url_page}&post_id={$smarty.get.post_id}&a=edit" method="POST">
<table cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content_border#}"><td colspan="2"><img width="1" alt="" height="1"/></td></tr> 
 {if $post->member_id != $smarty.const.EGL_NO_ID}
 <input type="hidden" name="member_id" alue="{$member_id}"/>
 <tr bgcolor="{#clr_content#}">
 	<td width="150"><b>Dein Name:</b></td>
 	<td><a href="{$url_file}page=member.info&member_id={$post->member_id}">{$post->member_nickname|strip_tags|stripslashes}</a></td>
 </tr>
 {else}
 <tr bgcolor="{#clr_content#}">
 	<td><b>Dein Name:</b></td>
 	<td><input type="text" name="username" class="egl_text" style="width:100%" value="{$post.username|strip_tags|stripslashes}"/></td>
 </tr>
 {/if}
 <tr bgcolor="{#clr_content#}">
 	<td><b>Titel:</b></td>
 	<td><input type="text" name="title" class="egl_text" style="width:100%" value="{$post->title|strip_tags|stripslashes}"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td valign="top"><b>Nachricht:</b></td>
 	<td><textarea class="egl_text" style="width:100%;" rows="20" name="text">{$post->text|strip_tags|stripslashes}</textarea></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td></td>
 	<td>
 		<table>
 			<tr>
 				<td><a href="javascript:insertTEXT(':)');"><img border="0" src="images/smilies/smile.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(';)');"><img border="0" src="images/smilies/wink.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':D');"><img border="0" src="images/smilies/bigsmile.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':rolleyes:');"><img border="0" src="images/smilies/rolleyes.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':angry:');"><img border="0" src="images/smilies/mad.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':thumb:');"><img border="0" src="images/smilies/thumb.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':cool:');"><img border="0" src="images/smilies/cool.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':lol:');"><img border="0" src="images/smilies/s_lol.gif"/></a></td>
 				<td><a href="javascript:insertTEXT(':what:');"><img border="0" src="images/smilies/s_what.gif"/></a></td>
 			</tr>
 		</table>
 	
 	</td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td colspan="2" align="center">
	 	<table cellpadding="0" cellspacing="0"><tr>
 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken"	link="javascript:document.f.submit();"}</td>
 		</tr></table>
 	</td>
 </tr>
</table>
</form>

<br/><br/>
<form name="fadmin">
{if in_array( "master", $admin_permissions) OR 
	in_array( "cms", $admin_permissions) OR 
	in_array( "forum.global.moderator", $admin_permissions) OR 
	in_array( "forum.moderator", $admin_permissions)
	}
	{if $head_post}
	<!--# POST FOR MODIFY #-->
	
		<table cellpadding="5" width="100%" border="0" >
		 <tr>
		 	<td><b>Verschieben nach</b></td>
			<td><select style="width:100%;" name="move_forumid" class="egl_select">
					<option value="-1">Kein Forum ausgewählt</option>					
					<option disabled >------------------------------------</option>
						
					{defun name="testrecursion2" catroot=$forumtree level="0"}
					    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $post->forum_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
						{foreach from=$catroot->aNodes item=node} 
							{fun name="testrecursion2" catroot=$node level=$level+1 }
						{/foreach}
					{/defun}
			 </select>		
			</td>	 
		 	<td width="150">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:moveTopic('Möchten Sie auf dem aktuellen Forum eine Verlinkung hinterlassen?','`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=move');" caption="verschieben"}
	 	 </tr>
	 	 <tr>
			<td colspan="2">
				<table cellpadding="2" border="0" align="">
				 <tr>
				 	<td><input type="radio" {if $topic->type == $smarty.const.EGL_TOPICTYPE_NORMAL}checked{/if} name="topic_type" value="normal"/>
				 	<td><b>Normal</b></td>
				 	<td>&nbsp;&nbsp;</td>
				 	<td><input type="radio" {if $topic->type == $smarty.const.EGL_TOPICTYPE_IMPORTANT}checked{/if} name="topic_type" value="important"/>
				 	<td><b>Wichtig</b></td>
				 	<td>&nbsp;&nbsp;</td>
				 	<td><input type="radio" {if $topic->type == $smarty.const.EGL_TOPICTYPE_NOTICE}checked{/if} name="topic_type" value="notice"/>
				 	<td><b>Ankündigung</b></td>
				 </tr>
				</table>			
			</td> 	 
		 	<td width="150">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:setTopicType('`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=settype');" caption="bearbeiten"}
	 	 </tr>
		</table>
			
		<br/>
		<table cellpadding="5">
		 <tr>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Thema löschen" link="javascript:questionURL('Soll dieses Thema jetzt gelöscht werden?','`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=deltopic');"}</td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Beitrag löschen" link="javascript:questionURL('Soll dieser Beitrag jetzt gelöscht werden?','`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=delpost');"}</td>
			{if $topic->locked}
				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Entsperren" link="javascript:questionURL('Soll dieses Thema jetzt entsperrt werden?','`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=unlock');"}</td>
			{else}
				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Sperren" link="javascript:questionURL('Soll dieses Thema jetzt gesperrt werden?','`$url_file`page=`$url_page`&post_id=`$smarty.get.post_id`&a=lock');"}</td>
			{/if}
		 </tr>
		</table>		
		
	{/if}
{/if}
</form>
