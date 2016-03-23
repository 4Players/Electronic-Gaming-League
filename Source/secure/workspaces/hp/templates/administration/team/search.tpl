<h2>Team - Verwaltung</h2>

<form name="f" action="{$url_file}page={$url_page}" method="post">
<table border="0" bgcolor="{#clr_content_border#}" cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content#}">
	<td><b>ID:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="id" value="{$_post.id}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>Name:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="name" value="{$_post.name}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>Kürzel:</b></td> 
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
		{section name=team loop=$results}
		 <tr><td><hr size=1></td></tr>
		 <tr><td>
		 
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 <tr>		 
				<td valign="top" width="50%"> 
				
				 		{* ID *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>ID, Identity</font></i> </td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <b>{$results[team]->id}</b></td>
				 		 </tr>
				 		</table>	
				
				 	
				 		{* Name *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>Team-Name</font></i> </td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <b> {$results[team]->name|strip_tags|stripslashes}</b>
									{section name=country loop=$countries} {if $countries[country]->id==$results[team]->country_id}<img src="{$path_country}{$countries[team]->image_file}">{/if} {/section}	
				 		 	</td>
				 		 </tr>
				 		</table>	
				 					
				</td>
				<td valign="top"> 
				
				 		{* Administration *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>Administration</i></font> </td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <A href="{$url_file}page=administration.team.profile&team_id={$results[team]->id}"><b>Profil</b></a></td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <A href="{$url_file}page=administration.team.permissions&team_id={$results[team]->id}"><b>Permissions</b></a></td>
				 		 </tr>
				 		</table>	
				 					
				</td>
			<tr>
			</table>
			
		</td></tr>
		{/section}
		
	</table>
		 

{/if}