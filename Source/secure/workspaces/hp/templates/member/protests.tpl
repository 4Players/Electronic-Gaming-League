{include file="devs/message.tpl"}
<h2>{$LNG_BASIC.c8220}</h2>

<table>
 <tr>
 	<td><select class="egl_select" style:150px;" ONCHANGE="location=this.options[this.selectedIndex].value;" style="width:350;">>
 		<option {if $smarty.get.display == 'open' || $smarty.get.display == ''}selected{/if} value="{$url_file}page={$url_page}&display=open">{$LNG_BASIC.c8223}</option>
 		<option {if $smarty.get.display == 'closed' }selected{/if} value="{$url_file}page={$url_page}&display=closed">{$LNG_BASIC.c8224}</option>
 		<option {if $smarty.get.display == 'all'  }selected{/if} value="{$url_file}page={$url_page}&display=all">{$LNG_BASIC.c8225}</option>
 	</select></td>
 </tr>
</table>
<hr size="1" />
<table border="0" width="100%" cellpadding="5" cellspacing="0">
<tr bgcolor="{#clr_content#}">
	<td width="32" align="center"></td>
	<td width="32" align="center"></td>
	<td><b>{$LNG_BASIC.c1014}</b></td>
	<td><b>{$LNG_BASIC.c8222}:</b></td>
	<td align="center"><b>{$LNG_BASIC.c8221}:</b></td>
</tr>
	{section name=protest loop=$protests}
		<tr>
			<td align="center">
				{if $protests[protest]->administrated}
					<img border=0 src="images/button_ok.gif"/>
				{else}
					<img border=0 src="images/button_cancel.gif"/>
				{/if}
			</td>
			<td align="center"><a href="{$url_file}page=member.viewprotest&protest_id={$protests[protest]->id}"><img border=0 src="images/button_edit.gif"/></a></td>
			<td><A href="{$url_file}page=member.info&member_id={$protests[protest]->member_id}">{$protests[protest]->member_nick_name|strip_tags|stripslashes}</a></td>
			<td>{date timestamp=$protests[protest]->created}</td>
			<td align="center">  
			{if $protests[protest]->match_id != $smarty.const.EGL_NO_ID} 
				<a href="{$url_file}page=administration.match.admin&match_id={$protests[protest]->match_id}"><img border=0 src="images/button_match.gif"/></a>
			{/if}
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="4">{$LNG_BASIC.c8201}: {$protests[protest]->subject|strip_tags|stripslashes}</td>
		</tr>
		<tr><td colspan="6"><hr size="1"/></td></tr>
	{/section}
</table>