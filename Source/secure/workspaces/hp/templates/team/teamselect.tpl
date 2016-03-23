{literal}
<script language="javascript">
	function forward_as_team( string ){
		window.location = string+'&team_id='+document.f.team_id.value;
	}
</script>
{/literal}

<!--# PLEASE CHOSE TEAMN #-->
<h2>{$LNG_BASIC.c1310}</h2>
<form name="f">
<table cellpadding="5" cellspacing="1">
 <tr>
 	<td><select class="egl_select" name="team_id" style="width:300;">
 		{section name=team loop=$teams}
 			<option value="{$teams[team]->id}">{$teams[team]->name|strip_tags|stripslashes} (ID: {$teams[team]->id})</option>
 		{/section}
 	</td>
 	<td>
 	{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:forward_as_team('`$url_file`page=`$_get.page_forward`&`$_get.params`');"}
 	</td>
 </tr>
</table>
</form>