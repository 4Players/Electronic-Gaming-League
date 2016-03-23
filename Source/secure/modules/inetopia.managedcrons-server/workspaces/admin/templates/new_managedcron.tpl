<h2>Neuer ManagedCron</h2>
{include file="etc/message.tpl"}
{if !$success}
<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
<table cellpadding="5">
 <tr>
 	<td>Service-Name</td>
 	<td><input type="text" style="width:200px;" class="egl_text" name="name"/></td>
 </tr>
 <tr>
 	<td>ManagedCron-ID</td>
 	<td><input type="text" style="width:200px;" class="egl_text" name="managedcron_id"/></td>
 </tr>
 <tr>
 	<td>Module-ID (Voraussetzung)</td>
 	<td><input type="text" style="width:200px;" class="egl_text" name="required_moduleid"/></td>
 </tr>
 <tr>
 	<td>Version (Voraussetzung)</td>
 	<td><input value="0.0.0" type="text" style="width:200px;" class="egl_text" name="required_version"/></td>
 </tr>
 <tr>
 	<td>Tick-Rate</td>
 	<td><input type="text" style="width:200px;" class="egl_text" name="tick_rate"/> (Minuten)</td>
 </tr>
 <tr>
 	<td>URI</td>
 	<td><input type="text" style="width:200px;" class="egl_text" name="uri"/></td>
 </tr>
 <tr>	
 	<td colspan="2">{include file="buttons/bt_universal.tpl" caption="hinzufügen" link="javascript:document.f.submit();"}</td>
 </tr>
</table>
</form>
{/if}