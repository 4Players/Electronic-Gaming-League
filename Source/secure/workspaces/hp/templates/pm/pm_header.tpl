

	<table width="100%" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="{#clr_content_border#}">
	 <tr>
		<td valign="top">
		
			<table border="0" cellpadding="5" cellspacing="1" width="100%" bgcolor="{#clr_content_border#}">
			<tr>
				<td align="center"><b><A href="{$url_file}page=pm.write">{$LNG_BASIC.c4900}</a></b></td>
				<td align="center"><b><A href="{$url_file}page=list.members">{$LNG_BASIC.c4901}</a></b></td>
			</tr>
			 <tr  bgcolor="{#clr_content_rel#}">
			 {if $_get.show == 'input'}
				<td bgcolor="{#clr_selected#}" align="center"> <b><A href="{$url_file}page=pm.overview&show=input">{$LNG_BASIC.c4902}</a></b> </td>
			 {else}
				<td align="center"> <b><A href="{$url_file}page=pm.overview&show=input">{$LNG_BASIC.c4902}</a></b> </td>
			 {/if}

			 {if $_get.show == 'output'}
				 <td bgcolor="{#clr_selected#}" align="center"> <b><A href="{$url_file}page=pm.overview&show=output">{$LNG_BASIC.c4903}</a></b> </td>
			 {else}
				 <td align="center"> <b><A href="{$url_file}page=pm.overview&show=output">{$LNG_BASIC.c4903}</a></b> </td>
			 {/if}
			 
			</tr>
		   </table>
			
		</td>
	</tr>
   </table>
    
