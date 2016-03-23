<table class="content_header" cellpadding="0" cellspacing="0"><tr>
	<td><img src="images/installwizard/password.gif"/></td>
	<td><img src="images/spacer.gif" height="1" width="20"/></td>
	<td><b>{$LNG_BASIC.c2100}</b></td>
</tr></table>
<table cellpadding="10" class="content"><tr><td>


<table>
 <tr>
 	<td width="150">{$LNG_BASIC.c2101}:</td>
 	<td><select name="dbinterface" class="egl_select">
 		{section name=dbi loop=$dbinterfaces}
 			<option value="{$dbinterfaces[dbi]}">{$dbinterfaces[dbi]}</option>
 		{/section}
 		</select>
 	</td>
 </tr>
 <tr>
 	<td>{$LNG_BASIC.c2102}:</td>
	<td><input type="text" name="server" value="localhost" class="egl_text"/></td>
 </tr>
 <tr>
 	<td>{$LNG_BASIC.c2103}:</td>
	<td><input type="text" name="database" value="egl_beta2" class="egl_text"/></td>
 </tr>
 <tr>
 	<td>{$LNG_BASIC.c1002}:</td>
	<td><input type="text" name="username" class="egl_text"/></td>
 </tr>
 <tr>
 	<td>{$LNG_BASIC.c1003}:</td>
	<td><input type="password" name="password" class="egl_text"/></td>
 </tr>
</table>

</td></tr></table>