{include file="devs/message.tpl"}

{**********************}
{*Mitglied gefunden ? *}
{**********************}
{if $member_details}

		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		 <tr>
		 	<td><h2>{$member_details->nick_name|strip_tags|stripslashes}</h2></td>
		 	<td width="200">
		 		<!--### START ###-->
		 		<table border="0" cellpadding="0" cellspacing="0">
		 		 <tr>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4270 link="`$url_file`page=member.info&member_id=`$member_details->id`" }</td>
		 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4271 link="`$url_file`page=member.about_me&member_id=`$member_details->id`"}</td>
		 		 </tr>
		 		</table>
		 	</td>
		 </tr>
		</table>
	
	 
		<br/><br/>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr><td><h2>{$LNG_BASIC.c4287}</h2></td></tr>
		 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
		</table>
	 	<table border="0" cellpadding="2" cellspacing="0" width="100%">
 		 <tr><td bgcolor="{#clr_content#}">
			{section name=game loop=$member_games}
				{if $member_games[game]->logo_small_file != 'non'}
					<A title="{$member_games[game]->name}" href="{$url_file}page=game.info&game_id={$member_games[game]->id}"><img border="1" style="border-color:#000000;" alt="{$member_games[game]->name}" src="{$path_games}small/{$member_games[game]->logo_small_file}" width="60" height="80"></a>
				{else}
					<A title="{$member_games[game]->name}" href="{$url_file}page=game.info&game_id={$member_games[game]->id}"><img border="1" style="border-color:#000000;" alt="{$member_games[game]->name}" src="images/logo.na.jpg" width="60" height="80"></a>
				{/if}
			{/section}
						
 		  </td></tr>
 		 </table>	
 		 
 		 <br/> <br/>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr><td><h2>{$LNG_BASIC.c4288}</h2></td></tr>
		 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
		</table>
		<table border="0" cellpadding="3" cellspacing="1" width="100%">
		 <tr>
		 	<td bgcolor="{#clr_content#}" width="30%"> <b>{$LNG_BASIC.c4289}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_cpu|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4290}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_mainboard|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4291}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_graphiccard|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4292}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_soundcard|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4293}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_mouse|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4294}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_mousepad|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4295}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_keyboard|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4296}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_memory|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4297}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_harddisk|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4298}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_monitor|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4299}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_connection|strip_tags|stripslashes}</b> </td>
		 </tr>
		 <tr>
		 	<td bgcolor="{#clr_content#}" > <b>{$LNG_BASIC.c4300}:</b></td>
		 	<td bgcolor="{#clr_content#}"> <b>{$member_details->cd_console|strip_tags|stripslashes}</b> </td>
		 </tr>
		</table>	

	

 	<br/><br/>
	<table border="0" width="100%" bgcolor="{#clr_content#}" cellpadding="3" cellspacing="0">
	 <tr>
	 	<td align="right"> <A href='{$url_file}page={$url_page}&member_id={$member_details->id}&comment=write#comment_write'> <b>{$LNG_BASIC.c4203} {#clip_start#}{$comment_count}{#clip_end#}</b> </a> </td> 
	 </tr>
	</table>

	<!--# COMMENTES #-->	
	{include file="etc/comment.show.tpl"}
	<br/>
	{include file="etc/comment.write.tpl"}


	
{/if}

