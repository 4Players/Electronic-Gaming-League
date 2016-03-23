<h2>Sprache wählen</h2>

<form name="f" action="" method="POST">
<table class="content_header" cellpadding="10" cellspacing="0" height="100%" width="100%"><tr>
<td>
	<table cellpadding="5">
	 <tr>
	 	<td>{$LNG_BASIC.c8101}:</td>
		<td><select style="width:200px;" class="egl_section" name="lng">
			{section name=lng loop=$languages}
				<option value="{$languages[lng].token}">{$languages[lng].name}</option>
			{/section}
			</select>
		</td>
		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}
	 </tr>
	</table>

</td></tr></table>
</form>