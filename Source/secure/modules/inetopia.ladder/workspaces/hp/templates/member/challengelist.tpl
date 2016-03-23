<h2>{$LNG_MODULE.c9083}</h2> <!--# Challenges Header #-->

<table align="center">
	<tr>
	{if $_get.dir=="out"}
		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9080 link="`$url_file`page=`$url_page`&dir=in"}</td>
		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9082 selected="true" link="`$url_file`page=`$url_page`&dir=out"}</td>
	{else}
		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9080 selected="true" link="`$url_file`page=`$url_page`&dir=in"}</td>
		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9082 link="`$url_file`page=`$url_page`&dir=out"}</td>
	{/if}
	</tr>
</table>

<!--# Incoming #-->
{if $_get.dir=="out"}

<!--# Outcoming #-->
<table cellpadding="5" width="100%" border="0">
<tr>
	<td></td>
</tr>
{section name=outc loop=$out_challenges}
	<tr>
		<td width="40"><A href="{$url_file}page=gameview.summary&game_id={$out_challenges[outc]->game_id}"><img border="1" style="border-color:#000000;" width="60" height="80" src="{$PATH_GAMES}small/{$out_challenges[outc]->game_logo_small_file}" title="{$out_challenges[outc]->game_name}"/></a></td>	
		<td>
			<h2>{$out_challenges[outc]->ladder_name}</h2>
			<table cellpadding="0" width="100%">
			 <tr>
				<td width="25%"><b>{$LNG_MODULE.c9017}</b><br/> <!--# Opponent #-->
				<A href="{$url_file}page=member.info&member_id={$out_challenges[outc]->opponent_id}">{$out_challenges[outc]->opponent_name}</a>
				</td>				
				<td  width="25%"><b>{$LNG_MODULE.c9034} ({$LNG_MODULE.c9033})</b><br/> <!--# Challenge Mode #-->
				{if $out_challenges[outc]->challenge_type == $smarty.const.CHALLENGETYPE_SINGLE_MAP}{$out_challenges[outc]->map1} ({$LNG_MODULE.c9070}){/if}
				{if $out_challenges[outc]->challenge_type == $smarty.const.CHALLENGETYPE_DOUBLR_MAP}{$out_challenges[outc]->map1} ({$LNG_MODULE.c9072}){/if}
				{if $out_challenges[outc]->challenge_type == $smarty.const.CHALLENGETYPE_RANDOM_MAP} ({$LNG_MODULE.c9071}){/if}
				</td>
				<td  width="25%"><b>Match {$LNG_MODULE.c9036}</b><br/> <!--# Challenge Time #-->
				{date timestamp=$out_challenges[outc]->challenge_time}
				<!--##
				<table cellpadding="0" cellspacing="0">
				 <tr>
				 	<td><input type="text" size="5" class="egl_text" value="{date timestamp=$out_challenges[outc]->challenge_time format='%d.%m.%y'}"/></td>
				 	<td><input type="text" size="5" class="egl_text" value="{date timestamp=$out_challenges[outc]->challenge_time format='%H:%M'}"/></td>
				 </tr>
				</table>
				##-->
				
				</td>				
				<td  width="25%"><b>Status</b><br/>
				{if $out_challenges[outc]->state == $smarty.const.CHALLENGESTATE_CHALLENGING}<font color="blue">{$LNG_MODULE.c9110}</font>{/if}
				{if $out_challenges[outc]->state == $smarty.const.CHALLENGESTATE_ACCEPTED}<font color="green">{$LNG_MODULE.c9111}</font>{/if}
				{if $out_challenges[outc]->state == $smarty.const.CHALLENGESTATE_DENIED}<font color="red">{$LNG_MODULE.c9112}</font>{/if}
				</td>				
			 </tr>
			 <tr>
			 	<td colspan="4">
			 		<table cellpadding="5" align="right">
			 		<tr>
			 			<!--#<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="annehmen" link="`$url_file`page=`$CURRENT_MODULE_ID`:member.accept&challenge_id=`$out_challenges[outc]->id`"}</td>#-->
			 			<!--#<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="ablehnen" link="`$url_file`page=`$CURRENT_MODULE_ID`:member.deny&challenge_id=`$out_challenges[outc]->id`"}</td>#-->
 			 			{if $out_challenges[outc]->match_id != $smarty.const.EGL_NO_ID }<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1104 link="`$url_file`page=match.info&match_id=`$out_challenges[outc]->match_id`"}</td>{/if}
			 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="`$LNG_BASIC.c1203`.." link="`$url_file`page=`$CURRENT_MODULE_ID`:member.challengedetails&challenge_id=`$out_challenges[outc]->id`"}</td>
			 		</tr>
			 		</table>
			 		<br/>
			 		<font style="font-size:11px">{lng_parser content=$LNG_MODULE.c9120 num_comments=$out_challenges[outc]->num_comments}</font>
			 	</td>
			 </tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3">{include file="devs/hr2.tpl" width="100%"}</td>
{/section}
</table>

{if !count($out_challenges)}{$LNG_MODULE.c9105}{/if} <!--# No challenges available #-->

{else}

<table cellpadding="5" width="100%" border="0">
<tr>
	<td></td>
</tr>
{section name=inc loop=$in_challenges}
	<tr>
		<td width="40"><A href="{$url_file}page=gameview.summary&game_id={$in_challenges[inc]->game_id}"><img border="1" style="border-color:#000000;" width="60" height="80" src="{$PATH_GAMES}small/{$in_challenges[inc]->game_logo_small_file}" title="{$in_challenges[inc]->game_name}"/></a></td>	
		<td>
			<h2>{$in_challenges[inc]->ladder_name}</h2>
			<table cellpadding="0" width="100%">
			 <tr>
				<td width="25%"><b>{$LNG_MODULE.c9016}</b><br/>
				<A href="{$url_file}page=member.info&member_id={$in_challenges[inc]->challenger_id}">{$in_challenges[inc]->challenger_name}</a>
				</td>				
				<td  width="25%"><b>{$LNG_MODULE.c9034} ({$LNG_MODULE.c9033})</b><br/>
				{if $in_challenges[inc]->challenge_type == $smarty.const.CHALLENGETYPE_SINGLE_MAP}{$in_challenges[inc]->map1} ({$LNG_MODULE.c9070}){/if}
				{if $in_challenges[inc]->challenge_type == $smarty.const.CHALLENGETYPE_DOUBLR_MAP}{$in_challenges[inc]->map1} ({$LNG_MODULE.c9072}){/if}
				{if $in_challenges[inc]->challenge_type == $smarty.const.CHALLENGETYPE_RANDOM_MAP} ({$LNG_MODULE.c9071}){/if}
				</td>
				<td  width="25%"><b>Match {$LNG_MODULE.c9036}</b><br/>
				{date timestamp=$in_challenges[inc]->challenge_time}
				<!--##
				<table cellpadding="0" cellspacing="0">
				 <tr>
				 	<td><input type="text" size="5" class="egl_text" value="{date timestamp=$in_challenges[inc]->challenge_time format='%d.%m.%y'}"/></td>
				 	<td><input type="text" size="5" class="egl_text" value="{date timestamp=$in_challenges[inc]->challenge_time format='%H:%M'}"/></td>
				 </tr>
				</table>
				##-->
				
				</td>				
				<td  width="25%"><b>{$LNG_BASIC.c1103}:</b><br/>
				{if $in_challenges[inc]->state == $smarty.const.CHALLENGESTATE_CHALLENGING}<font color="blue">{$LNG_MODULE.c9110}</font>{/if}
				{if $in_challenges[inc]->state == $smarty.const.CHALLENGESTATE_ACCEPTED}<font color="green">{$LNG_MODULE.c9111}</font>{/if}
				{if $in_challenges[inc]->state == $smarty.const.CHALLENGESTATE_DENIED}<font color="red">{$LNG_MODULE.c9112}</font>{/if}
				</td>				
			 </tr>
			 <tr>
			 	<td colspan="4">
			 		<table cellpadding="5" align="right">
			 		<tr>
			 			<!--#<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="annehmen" link="`$url_file`page=`$CURRENT_MODULE_ID`:member.accept&challenge_id=`$in_challenges[inc]->id`"}</td>#-->
			 			<!--#<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="ablehnen" link="`$url_file`page=`$CURRENT_MODULE_ID`:member.deny&challenge_id=`$in_challenges[inc]->id`"}</td>#-->
			 			{if $in_challenges[inc]->match_id != $smarty.const.EGL_NO_ID }<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1104 link="`$url_file`page=match.info&match_id=`$in_challenges[inc]->match_id`"}</td>{/if}
			 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="`$LNG_BASIC.c1203`.." link="`$url_file`page=`$CURRENT_MODULE_ID`:member.challengedetails&challenge_id=`$in_challenges[inc]->id`"}</td>
			 		</tr>
			 		</table>
			 		<br/>
					<font style="font-size:11px">{lng_parser content=$LNG_MODULE.c9120 num_comments=$in_challenges[inc]->num_comments}</font>
			 	</td>
			 </tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3">{include file="devs/hr2.tpl" width="100%"}</td>
{/section}
</table>
{if !count($in_challenges)}{$LNG_MODULE.c9105}{/if} <!--# No challenges available #-->

{/if}