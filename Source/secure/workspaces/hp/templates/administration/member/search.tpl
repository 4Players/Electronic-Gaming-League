<h2>{$LNG_BASIC.c8010}</h2>

<form name="f" action="{$url_file}page={$url_page}" method="post">
<table border="0" bgcolor="{#clr_content_border#}" cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content#}">
	<td width="150"><b>{$LNG_BASIC.c1022}:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="id" value="{$_post.id}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>{$LNG_BASIC.c1007}:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="email" value="{$_post.email}"></td> 
 </tr>
 <tr bgcolor="{#clr_content#}">
	<td><b>{$LNG_BASIC.c1020}:</b></td> 
	<td><input type="text" class="egl_text" style="width:100%" name="nick_name" value="{$_post.nick_name}"></td> 
 </tr>
 <tr bgcolor="{#clr_content_rel#}">
 	<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
 </tr>

</table>

</form>


{if $search_success}
<br/>
<h2>Ergebnisse</h2>

	<table border="0" width="100%">
		{section name=member loop=$results}
		 <tr><td><hr size=1></td></tr>
		 <tr><td>
		 
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 <tr>		 
				<td valign"top" width="33%"> 
				
				 		{* ID *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size=1><i>{$LNG_BASIC.c1022}, {$LNG_BASIC.c4251}</i></font> </td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <b>{$results[member]->id}</b></td>
				 		 </tr>
				 		</table>	
				
				 	
				 		{* Nick-Name *}
				 		<table border="0">
				 		 <tr>
				 		 	<td><font size="1"><i>{$LNG_BASIC.c1020}</i></font></td>
				 		 </tr>
				 		 <tr>
				 		 	<td> <A href="{$url_file}page=member.info&member_id={$results[member]->id}"><b>{$results[member]->nick_name|strip_tags|stripslashes}</b></a>
								 {section name=country loop=$countries} {if $countries[country]->id==$results[member]->country_id}<img src="{$path_country}{$countries[member]->image_file}"/>{/if} {/section}
				 		 	</td>
				 		 </tr>
				 		</table>	
				 					
			
				
				</td>
				<td width="33%">
						
						
			 		{* registered *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><font size="1"><i>{$LNG_BASIC.c2618}</i></font></td>
			 		 </tr>
			 		 <tr>
			 		 	<td> <b>{date timestamp=$results[member]->created format="%d.%m.%Y"}</b></td>
			 		 </tr>
			 		</table>
			 		
			 		{* last login *}
			 		<table border="0">
			 		 <tr>
			 		 	<td><font size="1"><i>{$LNG_BASIC.c4273}</i></font></td>
			 		 </tr>
			 		 <tr>
			 		 	<td> 
			 		 	<b>{date timestamp=$results[member]->last_login format="%d.%m.%Y"}</b>
			 		 	</td>
			 		 </tr>
			 		</table>
				
				</td>
				<td valign="top"> 
				
				 		{* Administration *}
				 		<table border="0">
				 		 <tr>
				 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c2500 link="javascript:document.location.href='`$url_file`page=administration.member.profile&member_id=`$results[member]->id`';"}</td>
				 		 </tr>
				 		 <tr>
				 		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c8014 link="javascript:document.location.href='`$url_file`page=administration.member.central&member_id=`$results[member]->id`';"}</td>
				 		 </tr>
				 		</table>	
				 					
				</td>
			<tr>
			</table>
			
		</td></tr>
		{/section}
		
	</table>
		 

{/if}