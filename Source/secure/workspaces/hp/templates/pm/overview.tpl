{include file="pm/pm_header.tpl"}
<br/>

{**************************}
{* SHOW - INPUT Buffer }

{**************************}
{if $pm_input}
	<h2>{$LNG_BASIC.c4902}</h2>
	<form name="input" method="POST" action="{$url_file}page={$url_page}&show=input&a=admin">
	<table border=0 cellpadding="5" cellspacing="1" width='100%' bgcolor="{#clr_content_border#}">
	 <tr>
 		<td width="1%"></td>
	 	<td width="20%"><b>{$LNG_BASIC.c4904}:</b></td>
	 	<td width="50%"><b>{$LNG_BASIC.c4906}:</b></td>
	 	<td><b>{$LNG_BASIC.c4908}.</b></td>
	 </tr>
 
 	{section name=msg loop=$pm_input}
 		{if !($pm_input[msg]->is_read) } 
		 	<tr bgcolor="{#clr_selected#}">
 				<td> <input name="sel_pm_{$smarty.section.msg.index}" value="{$pm_input[msg]->id}" type="checkbox" class="egl_checkbox"/></td>
 				<td><A href='{$url_file}page=member.info&member_id={$pm_input[msg]->sender_id}'>{$pm_input[msg]->sender_name|htmlspecialchars}</a></td>
 				<td><A href='{$url_file}page=pm.show&pm_id={$pm_input[msg]->id}'>{$pm_input[msg]->title|htmlspecialchars}</a></td>
 				<td>{date timestamp=$pm_input[msg]->created format="%H:%M:%S / %d.%m.%Y"}</td>
 			</tr>
 		{else}
 			<tr bgcolor="{#clr_content_rel#}">
 				<td> <input name="sel_pm_{$smarty.section.msg.index}" value="{$pm_input[msg]->id}" type="checkbox" class="egl_checkbox"/></td>
 				<td><A href='{$url_file}page=member.info&member_id={$pm_input[msg]->sender_id}'>{$pm_input[msg]->sender_name|htmlspecialchars}</a></td>
 				<td><A href='{$url_file}page=pm.show&pm_id={$pm_input[msg]->id}'>{$pm_input[msg]->title|htmlspecialchars}</a></td>
 				<td>{date timestamp=$pm_input[msg]->created format="%H:%M:%S / %d.%m.%Y"}</td>
	 		</tr>
 		{/if}
 	{/section}
	<tr><td colspan="4" bgcolor="{#clr_content_rel#}"> <br/> </td></tr>
  	<tr>
  		<td colspan="3">
  			<table>
  			<tr>
  			<td>
  			<b>{$LNG_BASIC.c4909}</b> {#arrow_db_right#}
  			<select class="egl_select" name="pm_action">
  				<option>--- {$LNG_BASIC.c4910} ---</option>
  				<option name="delete">{$LNG_BASIC.c4911}</option>
  			</select></td>
  			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.input.submit();"}</td>
  			<tr>
  			</table>

  		</td>
  		<td align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c4900 link="`$url_file`page=pm.write"}</td>
  	</tr>
 </table>
 </form>
 
 	<br/>
	
	<table border="0" cellpadding="5">
	 <tr>
	 	<td>
			<table cellpadding="10" cellspacing="1" border="0" bgcolor="{#clr_content_border#}">
			<tr><td bgcolor="{#clr_selected#}"> <img src="images/spacer.gif" width="10" height="10"></td></tr></table>
		</td><td><b>{$LNG_BASIC.c4913}</b></td>
	 <td>
			<table cellpadding="10" cellspacing="1" border="0" bgcolor="{#clr_content_border#}">
			<tr><td bgcolor="{#clr_content#}"><img src="images/spacer.gif" width="10" height="10"></td></tr></table>
		</td><td><b>{$LNG_BASIC.c4912}</b></td>
	 </tr>
	</table> 
 
 {else}
 	{if $_get.show == "input" }
 		<br/>
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
		 <tr>
		 	<td align="center"><b>{$LNG_BASIC.c4914}</b></td>
		 </tr>
		</table>
 	{/if}
 
 {/if} 


{**************************}
{* SHOW - OUTPUT Buffer }
{**************************}
{if $pm_output}

	<h2>{$LNG_BASIC.c4903}</h2>
	
	<form name="output" method="POST" action="{$url_file}page={$url_page}&show=output&a=admin">
	<table border=0 cellpadding="5" cellspacing="1" width='100%' bgcolor="{#clr_content_rel_border#}">
	 <tr>
 		<td width="1%"></td>
		<td width="20%"><b>{$LNG_BASIC.c4905}:</b></td>
		<td width="50%"><b>{$LNG_BASIC.c4906}:</b></td>
		<td><b>{$LNG_BASIC.c4907}.</b></td>
	 </tr>
 
 {section name=msg loop=$pm_output}
 	<tr bgcolor="{#clr_content_rel#}">
		<td><input name="sel_pm_{$smarty.section.msg.index}" value="{$pm_output[msg]->id}" type="checkbox" class="egl_checkbox"/></td>
 		<td><A href='{$url_file}page=member.info&member_id={$pm_output[msg]->receiver_id}'>{$pm_output[msg]->receiver_name|htmlspecialchars}</a></td>
 		<td><A href='{$url_file}page=pm.show&pm_id={$pm_output[msg]->id}'>{$pm_output[msg]->title|htmlspecialchars}</a></td>
		<td>{date timestamp=$pm_output[msg]->created format="%H:%M:%S / %d.%m.%Y"}</td>
 	</tr>
 {/section}
 	<tr><td colspan="4" bgcolor="{#clr_content_rel#}"> <br/> </td></tr>
   	<tr>
  		<td colspan="4">
  			<table>
  			<tr><td>
  			<b>{$LNG_BASIC.c4909}</b> {#arrow_db_right#}
  			<select class="egl_select" name="pm_action">
  				<option>--- {$LNG_BASIC.c4910} ---</option>
  				<option name="delete">{$LNG_BASIC.c4911}</option>
  			</select></td>
  			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.output.submit();"}</td>
  			<tr>
  			</table>
  		</td>
  	</tr>
 </table>
 </form>
 
 {else}
 	{if $_get.show == "output" }
 		<br/>
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
		 <tr>
		 	<td align="center"><b>{$LNG_BASIC.c4914}</b></td>
		 </tr>
		</table>
 	{/if}
 
 {/if}
