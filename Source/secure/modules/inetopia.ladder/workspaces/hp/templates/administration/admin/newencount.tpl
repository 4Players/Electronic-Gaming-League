<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Neue Begegnung</h2>
{include file="`$page_dir`/laddermenu.tpl"}
<hr size="1"/>
{include file="devs/message.tpl"}

{if $success}
{else}

{literal}
<script language="javascript" src="javascript/browser_handling.js"></script>
{/literal}
<form name="f" action="{$url_file}page={$url_page}&ladder_id={$ladder->id}&a=create" method="post">
<table width="100%" background="images/modules/inetopia_ladder/ladder_encount_add.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Neue Begegnung</b></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Match Struktur:</b></td>
			 	{if isset($matchstructure)}<td>{$matchstructure->name|strip_tags|stripslashes}</td>{/if}
			 	{if !isset($matchstructure)}<td><font color="#A80000">Keine Match-Strukture eingerichtet}</font></td>{/if}
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td width="200"><b>Challenger-ID:</b></td>
				<td><input type="text" class="egl_text" name="challenger_id" value="{$_post.challenger_id}"/></td>
			</tr>
			<tr bgcolor="{#clr_content#}">
				<td><b>Opponent-ID:</b></td>
				<td><input type="text" class="egl_text" name="opponent_id" value="{$_post.opponent_id}"/></td>
			</tr>
			<tr bgcolor="{#clr_content#}">
				<td><b>Termin:</b></td>
			 	<td>
			 		<input size="10" type="text" class="egl_text" value="{date format='%d.%m.%y'}" name="challenge_time_date"/>
			 		<input size="5" type="text" class="egl_text" value="{date format='%H:%M'}" name="challenge_time_clock"/>
			 	</td>
			</tr>
			<tr bgcolor="{#clr_content#}">
				<td><b>Challenge-Modus:</b></td>
				<td>
					<select style="width:200;" class="egl_select" name="challenge_type">
						{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_SINGLE_MAP}<option value="{$smarty.const.CHALLENGETYPE_SINGLE_MAP}">Single-Map</option>{/if}
						{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_DOUBLE_MAP}<option value="{$smarty.const.CHALLENGETYPE_DOUBLE_MAP}">Double-Map</option>{/if}
						{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_RANDOM_MAP}<option value="{$smarty.const.CHALLENGETYPE_RANDOM_MAP}">Random-Map</option>{/if}
					</select>
					<br/>
					
					<table cellpadding="5">
						<tr>
							<td><b>Map1:</b></td>
							<td><input type="text" class="egl_text" name="map1"/></td>
						</tr>
						<tr>
							<td><b>Map2:</b></td>
							<td><input type="text" class="egl_text" name="map2"/> (nur bei Double-Map)</td>
						</tr>
					</table>
					
				</td>
			</tr>
			{if $matchstructure}
			 <tr bgcolor="{#clr_content#}">
			 	<td colspan="2" align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken" link="javascript:document.f.submit();"}</td>
			 </tr>
			 {/if}
		  </table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>

{/if}