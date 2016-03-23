{include file="devs/message.tpl"}

{if $protest}
	<h2>{$LNG_BASIC.c8250}</h2>
	{include file="devs/hr_black.tpl" type="1" width="100%"}
	
	<table cellpadding="5">
	 <tr>
	 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c8251  link="javascript:document.location.href='`$url_file`page=member.protests';"}</Td>
	 </tr>
	</table>
	
	{include file="devs/hr2.tpl" type="2" width="100%"}
	<table cellpadding="5">
	 <tr>
	 	<td>{lng_parser content=$LNG_BASIC.c8252 member_name="<a href='`$url_file`page=member.info&member_id=`$protest->member_id`'>`$protest->member_nick_name`</a>" member_id=$protest->member_id created_time=$protest->created}</td>
	 </tr>
	 {if $protest->administrated}
	 <tr>
	 	<td>{lng_parser content=$LNG_BASIC.c8253 admin_name="<a href='`$url_file`page=member.info&member_id=`$protest->admin_id`'>`$protest->admin_nick_name`</a>" admin_id=$protest->admin_id admin_time=$protest->created}</td>
	 </tr>
	 {/if}
	</table>
	{include file="devs/hr2.tpl" type="2" width="100%"}
	
	{if $protest}
		<table border="0" width="100%">
			<tr>
				<td width="30%" valign="top" align="center"> 
				
					
				{if $protest->match_id != $smarty.const.EGL_NO_ID } 
					<A href="{$url_file}page=match.info&match_id={$protest->match_id}" ><img border=0 src="images/protests_match_enabled.gif"/></a> 
					<br/>{$LNG_BASIC.c1029}: {$protest->match_id}
				{else}
					<img border=0 src="images/protests_match_disabled.gif"/>
					<br/><i>{$LNG_BASIC.c8258}</i>
				{/if}
	
				</td>
				<td valign="top">
					<br/>
					<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
					 <tr>
					 	<td><b>{$LNG_BASIC.c8254}:</b> </td>
					 </tr>
					 <tr bgcolor="{#clr_content#}">
					 	<td>{$protest->text|strip_tags|stripslashes|nl2br} </td>
					 </tr>
					 </table>
				
					 <br/><br/>
					 
					 <form name="f" action="{$url_file}page={$url_page}&protest_id={$protest->id}&a=go" method="POST">
					<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
					 <tr>
					 	<td><b>{$LNG_BASIC.c8255}:</b> </td>
					 </tr>
					 <tr bgcolor="{#clr_content#}">
					 	<td>{if strlen($protest->admin_text) > 0}<div style="padding:10px;">{$protest->admin_text|nl2br}</div>{else}<i>KEINE ANTWORT VERFÜGBAR{/if}</td>
					 </tr>
					 <tr bgcolor="{#clr_content#}" align="right">
	
					 {if $protest->administrated}
			 			<td align="center"><img src="images/button_ok.gif"/><b>{$LNG_BASIC.c8256}</b></td>
					 {else}
			 			<td align="center"><img src="images/button_cancel.gif"/><b>{$LNG_BASIC.c8257}</b></td>
					 {/if}
					 </tr>
					 </table>
					 </form>
					 
				 	<br/><br/>
				 	
					<table border="0" width="100%" bgcolor="{#clr_content_border#}" cellpadding="3" cellspacing="0">
					 <tr>
					 	<td align="right"> <a href="{$url_file}page={$url_page}&protest_id={$protest->id}&comment=write#comment_write"> <b>{$LNG_BASIC.c4203} {#clip_start#}{$num_comments}{#clip_end#}</b> </a> </td> 
					 </tr>
					</table>
					
					{include file="etc/comment.show.tpl"}
					<br/>
					{include file="etc/comment.write.tpl"}
					 
				</td>
			</tr>
		</table>
	{else}
		<font color="{#clr_rank_red#}"><b>{$LNG_BASIC.c8259}</b></font>
	{/if}
	
{/if}