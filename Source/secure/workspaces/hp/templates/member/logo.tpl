<h2>{$LNG_BASIC.c4570}</h2><br/>
{include file="devs/message.tpl"}
		
{if !$logo_success && $account }

	<form name="f" enctype="multipart/form-data" action="{$url_file}page={$url_page}&a=go" method="post" >
	
	<table border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_border#}" width="90%">
	 <tr bgcolor="{#clr_content#}"><td>

	   <table border=0 align="center" bgcolor="{#clr_content#}" cellpadding="5" cellspacing="0">
		<tr>
		 <td colspan=2 align="center">  
				
		 		<i>({$LNG_BASIC.c4571}) </i> <br/>
		 		<table border=0 bgcolor="#000000" cellpadding="0" cellspacing="1">
		 		 <tr><td>
		 		 
		 		 {if $account->logo_file != 'non'}
		 			<img src="{$path_logos}{$account->logo_file}" width="100" height="100">
	 			 {else}
		 			<img src="images/logo.na.jpg" width="100" height="100">
	 			 {/if}
		 		</td></tr>
		 		</table>
		 		<br/><br/>
			
			</td>
		</tr>
		<tr valign="top"> 
		
			<td align="center" width="40%"><b>{$LNG_BASIC.c4572}:</b></td>
			<td><b><input type="file" class="egl_text" name="upload_logo_file"/> </td>			
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" class="egl_checkbox" name="upload_logo_delete" value="1"/> {$LNG_BASIC.c4573}</td>
		</tr>
		<tr>
			<td></td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
		</tr>
	   </table>
		
		
	</td></tr>
	</table>
	</form>
	
{/if}
