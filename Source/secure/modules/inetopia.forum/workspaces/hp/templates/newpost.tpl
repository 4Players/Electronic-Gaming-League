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


<h2>Antworten</h2>
<br/>
<form name="f" action="{$url_file}page={$url_page}&topic_id={$smarty.get.topic_id}&a=go" method="POST">
<table cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content_border#}"><td colspan="2"><img width="1" alt="" height="1"/></td></tr> 
 {if $is_loggedin}
 <input type="hidden" name="member_id" alue="{$member_id}"/>
 <tr bgcolor="{#clr_content#}">
 	<td width="150"><b>Dein Name:</b></td>
 	<td><a href="{$url_file}page=member.info&member_id={$member->id}">{$member->nick_name|strip_tags|stripslashes}</a></td>
 </tr>
 {else}
 <tr bgcolor="{#clr_content#}">
 	<td><b>Dein Name:</b></td>
 	<td><input type="text" name="username" class="egl_text" style="width:100%" value="{$smarty.post.username}"/></td>
 </tr>
 {/if}
 <tr bgcolor="{#clr_content#}">
 	<td><b>Titel:</b></td>
 	<td><input type="text" name="title" class="egl_text" style="width:100%" value="{$smarty.post.title}"/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td valign="top"><b>Nachricht:</b></td>
 	<td><textarea class="egl_text" style="width:100%;" rows="20" name="text">{$smarty.post.text}</textarea></td>
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