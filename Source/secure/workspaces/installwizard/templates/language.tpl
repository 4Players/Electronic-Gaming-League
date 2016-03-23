<table class="content_header" cellpadding="10" cellspacing="0" height="100%" width="100%"><tr>
<td>
	<table width="100%">
	 <tr>
	 	<td>{$LNG_BASIC.c2600}:</td>
		<td><select class="egl_section" name="lng">
			{section name=lng loop=$languages}
				<option value="{$languages[lng].token}">{$languages[lng].name}</option>
			{/section}
			</select>
		</td> 
	 </tr>
	</table>

</td></tr></table>