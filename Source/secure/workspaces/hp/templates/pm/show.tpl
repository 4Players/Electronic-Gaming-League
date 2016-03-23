{include file="pm/pm_header.tpl"}<br>
{include file="devs/message.tpl"}

{* no errors occured?*}
{if $msg_type != 'error'}
	
	<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td width="80"><b>{$LNG_BASIC.c4920}</b></td>
	 	<td><b>{$LNG_BASIC.c4917}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td valign="top"> 
	 			<table border=0>
	 			 <tr><td>
	 			 
			 		{if $pm_data->logo_file != 'non' AND strlen($pm_data->logo_file) > 0}
				 		<img src="{$path_logos}members/{$pm_data->logo_file}" width="100" height="100" border="0">
				 		<br>
			 		{/if}
			 		
	 			 	<A href='{$url_file}page=member.info&member_id={$pm_data->sender_id}'> <b>{$pm_data->sender_name|strip_tags}</b> </a>
	 			 	<br><br><br>
	 			 </td></tr>
	 			</table>
	 	</td>
	 	<td valign="top" width="80%" height="200"> 
	 			<table border=0 width="100%" cellpadding="5" cellspacing="0" align="center">
	 			 <tr><td colspan="2">
	 			 	{$LNG_BASIC.c4906}: {$pm_data->title|strip_tags}
	 			 	{include file="devs/hr_black.tpl" width="100%"}
	 			 </td></tr>
	 			 <tr><td width="1%"><img src="images/spacer.gif" width="10"></td><td>
	 			  {$pm_data->text|strip_tags|nl2br}
	 			 </td></tr>
	 			</table>
	 		
	 		</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td> <b>{date timestamp=$pm_data->created format="%d.%m.%y - <u>%H:%M</u>"} </b></td>
	 	<td align="right">
		 	<table cellpadding="0" cellspacing="0"><tr>
		 	{if $pm_input }
			 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4919 link="javascript:document.location.href='`$url_file`page=pm.write&member_id=`$pm_data->sender_id`&pm_id=`$pm_data->id`';"}</td>
		 	{/if}
			</table>					 
		</td>
	 </tr>
	</table>

{/if}
