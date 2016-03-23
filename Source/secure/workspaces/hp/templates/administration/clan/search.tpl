<h2>Clan - Verwaltung</h2>

<form name="f" action="{$url_file}page={$url_page}" method="post">
<table border="0" bgcolor="{#clr_content_border#}" cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content#}">
	<td><b>ID:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="id" value="{$_post.id}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>{$LNG_BASIC.c4721}:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="name" value="{$_post.name}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>{$LNG_BASIC.c4722}:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="tag" value="{$_post.tag}"></td> 
 </tr>
 <tr bgcolor="{#clr_content_rel#}">
 	<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" link="javascript:document.f.submit();" caption=$LNG_BASIC.c1018 color=$GLOBAL_COLOR}</td>
 </tr>
</table>

</form>

{if $search_success}
<br>
<h2>Ergebnisse</h2>

	<table border="0" width="100%">
		{section name=clan loop=$results}
		 <tr><td><hr size=1></td></tr>
		 <tr><td>
		 
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 <tr>		 
				<td valign="top"> 
				
				 		{* ID *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>{$LNG_BASIC.c4726}</i></font></td>
				 		 </tr>
				 		 <tr>
				 		 	<td><b>{$results[clan]->id}</b></td>
				 		 </tr>
				 		</table>	
				
				 	
				 		{* Name *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>{$LNG_BASIC.c4721}</i></font></td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <b>{$results[clan]->name|strip_tags|stripslashes}</b>
									{section name=country loop=$countries} {if $countries[country]->id==$results[clan]->country_id}<img src="{$path_country}{$countries[clan]->image_file}">{/if} {/section}	
				 		 	</td>
				 		 </tr>
				 		</table>	
				 					
				</td>
				<td valign="top"> 
				
				
				 		<table border="0">
				 		 <tr>
				 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2500 link="javascript:document.location.href='`$url_file`page=administration.clan.profile&clan_id=`$results[clan]->id`';"}</td>
				 		 </tr>
				 		 <tr>
				 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c8014 link="javascript:document.location.href='`$url_file`page=administration.clan.central&clan_id=`$results[clan]->id`';"}</td>
				 		 </tr>
				 		</table>	

				 		
				 					
				</td>
			<tr>
			</table>
			
		</td></tr>
		{/section}
		
	</table>
	
	 

{/if}