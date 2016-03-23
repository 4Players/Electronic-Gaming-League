<!--# Challenge details #-->
<h2>{$LNG_MODULE.c9081}</h2>
{include file="devs/message.tpl"}

{if $success}
{else}
<form name="f" action="{$url_file}page={$url_page}&challenge_id={$challenge->id}&a=accept" method="POST">
 <table width="95%" align="center">
  <tr><td>
	<table cellpadding="5">
	 <tr>
	 	<td><b>{$LNG_MODULE.c9015}:</b></td>
	 	<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:overview&ladder_id={$challenge->ladder_id}">{$challenge->ladder_name|strip_tags|stripslashes}</a></td>
	 </tr>
	 
	 <!--# Mode #-->
	 <tr>
	 	<td><b>{$LNG_MODULE.c9033}:</b></td>
	 	{if $challenge->challenge_type == $smarty.const.CHALLENGETYPE_SINGLE_MAP}<td>{$LNG_MODULE.c9070}</td>{/if}
	 	{if $challenge->challenge_type == $smarty.const.CHALLENGETYPE_DOUBLE_MAP}<td>{$LNG_MODULE.c9072}</td>{/if}
	 	{if $challenge->challenge_type == $smarty.const.CHALLENGETYPE_RANDOM_MAP}<td>{$LNG_MODULE.c9071}</td>{/if}
	 </tr>
	 
	  <!--# Random Challenge Mode #-->
	 {if $challenge->challenge_type == $smarty.const.CHALLENGETYPE_RANDOM_MAP}
	 <tr>
	 	<td><b>{$LNG_MODULE.c9034}1:</b></td> <!--# Unknown Map #-->
		{if strlen($challenge->map1) == 0}
		 	<td>{$LNG_BASIC.c1200}</td>
		{else}
		 	<td>{$challenge->map1|strip_tags|stripslashes}</td>
		{/if}
	 </tr>
	 {else}
		 <tr>
		 	<td><b>{$LNG_MODULE.c9034}1:</b></td> <!--# First map input, by challenger #-->
		 	{if !$CHALLENGE_LOCKED}
		 		{if $challenge->react_id == $member->id && ($member->id == $challenge->challenger_id || $challenge->challenge_type == $smarty.const.CHALLENGETYPE_SINGLE_MAP) }
		 		 	{if isset($MAPS)}
			 		 	<td><select name="map1" class="egl_select" style="width:200px">
			 		 	{section name=map loop=$MAPS}
			 		 		<option {if $MAPS[map]->map_name==$challenge->map1}selected{/if} value="{$MAPS[map]->map_name}">{$MAPS[map]->map_name|strip_tags|stripslashes}</option>
			 		 	{/section}
			 		 	</select></td>
		 		 	{else}
		 				<td><input type="text" class="egl_text" name="map1" value="{$challenge->map1|strip_tags|stripslashes}"/></td>
		 		 	{/if}
		 		 	
	 			{else}
				 	<td>{$challenge->map1|strip_tags|stripslashes}</td>
				 	<input type="hidden" name="map1" value="{$challenge->map1|strip_tags|stripslashes}"/>
	 			{/if}
		 	{else}
			 	<td>{$challenge->map1|strip_tags|stripslashes}</td>
			 	<input type="hidden" name="map1" value="{$challenge->map1|strip_tags|stripslashes}"/>
		 	{/if}
		 </tr>
	 {/if}
	 
	 <!--# MAP 2 #-->
	 {if $challenge->challenge_type == $smarty.const.CHALLENGETYPE_DOUBLE_MAP} <!--# Dualmap Mode #-->
	 
		 <tr>
		 	<td><b>{$LNG_MODULE.c9034|strip_tags}2:</b></td> <!--# Second map input #-->
		 	{if !$CHALLENGE_LOCKED}
		 		{if $challenge->react_id == $member->id && $member->id == $challenge->opponent_id }
		 		 	{if isset($MAPS)}
			 		 	<td><select name="map2" class="egl_select" style="width:200px">
			 		 	{section name=map loop=$MAPS}
			 		 		<option {if $MAPS[map]->map_name==$challenge->map2}selected{/if} value="{$MAPS[map]->map_name}">{$MAPS[map]->map_name|strip_tags|stripslashes}</option>
			 		 	{/section}
			 		 	</select></td>
		 		 	{else}	 		
				 		<td><input type="text" class="egl_text" name="map2" value="{$challenge->map2|strip_tags|stripslashes}"//></td>
				 	{/if}
			 	{else}
			 		<td>{$challenge->map2|strip_tags|stripslashes}</td>
				 	<input type="hidden" name="map2" value="{$challenge->map2|strip_tags|stripslashes}"/>
			 	{/if}
		 	{else}
		 		<td>{$challenge->map2|strip_tags|stripslashes}</td>
			 	<input type="hidden" name="map2" value="{$challenge->map2|strip_tags|stripslashes}"/>
		 	{/if}
		 </tr>
		 
	 {/if}
	 
	 
	 <tr>
 	 <!--# Challenger name <nick-name> #-->
		 {if $challenge->challenger_id == $member->id}<td><b>{$LNG_MODULE.c9017}:</b></td>{/if}
		 {if $challenge->opponent_id == $member->id}<td><b>{$LNG_MODULE.c9016}:</b></td>{/if}
		 	{if $challenge->challenger_id == $member->id}<td><A href="{$url_file}page=member.info&member_id={$challenge->opponent_id}">{$challenge->opponent_name|strip_tags|stripslashes}</a></td>{/if}
		 	{if $challenge->opponent_id == $member->id}<td><A href="{$url_file}page=member.info&member_id={$challenge->challenger_id}">{$challenge->challenger_name|strip_tags|stripslashes}</a></td>{/if}
	 </tr>
	 <tr>
	 	<td><b>{$LNG_MODULE.c9036}:</b></td> <!--# Challenge date #-->
	 	<td>
	 	{if !$CHALLENGE_LOCKED}
	 		{if $challenge->react_id == $member->id}
		 		<input type="text" size="10" class="egl_text" name="challengetime_date" value="{date timestamp=$challenge->challenge_time format='%d.%m.%y'}"/>
		 		<input type="text" size="5" class="egl_text" name="challengetime_time" value="{date timestamp=$challenge->challenge_time format='%H:%M'}"/>
	 		{else}
	 			{date timestamp=$challenge->challenge_time format='%d.%m.%y'} / {date timestamp=$challenge->challenge_time format='%H:%M'}
	 		{/if}
	 	{else}
	 		{date timestamp=$challenge->challenge_time format='%d.%m.%y'} / {date timestamp=$challenge->challenge_time format='%H:%M'}
	 	{/if}
	 	</td>
	 </tr>
	 <tr>
	 	<td><b>{$LNG_BASIC.c1103}:</b></td>
		<td>
				{if $challenge->state == $smarty.const.CHALLENGESTATE_CHALLENGING}<font color="blue">{$LNG_MODULE.c9110}</font>{/if}
				{if $challenge->state == $smarty.const.CHALLENGESTATE_ACCEPTED}<font color="green">{$LNG_MODULE.c9111}</font>{/if}
				{if $challenge->state == $smarty.const.CHALLENGESTATE_DENIED}<font color="red">{$LNG_MODULE.c9112}</font>{/if}
		</td>			 	
	 </tr>
	</table>
 </td>
 <td width="100" valign="top">
	
	<table cellpadding="5">
	<!--# Accept #-->
	{if !$CHALLENGE_LOCKED} {if $challenge->react_id == $member->id} <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9101 link="javascript:document.f.submit();"}</td></tr> {/if} {/if}
	 <!--# Deny #-->
	{if !$CHALLENGE_LOCKED} {if $challenge->react_id == $member->id} <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9102 link="`$url_file`page=`$CURRENT_MODULE_ID`:member.deny&challenge_id=`$challenge->id`"}</td></tr> {/if} {/if}
	<!--# Match #-->
	{if $challenge->state == $smarty.const.CHALLENGESTATE_ACCEPTED} <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9113 link="`$url_file`page=match.info&match_id=`$challenge->match_id`"}</td></tr> {/if}
	</table>
	
	
	<br/><br/>
	<table cellpadding="5">
	<!--# jump to [challenge]overview #-->
	 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9103 link="`$url_file`page=`$CURRENT_MODULE_ID`:member.challengelist"}</td></tr>
	</table>
	
 </td></tr>
</table>
</form>

	<table border="0" width="100%" cellpadding="3" cellspacing="0">
	 <tr bgcolor="{#clr_content#}">
	 	<td align="right"> <A href='{$url_file}page={$url_page}&challenge_id={$challenge->id}&comment=write'> <b>{$LNG_MODULE.c9104} {#clip_start#}{$comment_count}{#clip_end#}</b> </a> </td> 
	 </tr>
	</table>
	
	{include file="etc/comment.show.tpl"}
	<br/>
	{* WRITE ? !! *}
	{include file="etc/comment.write.tpl"}

{/if}