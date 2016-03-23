{literal}
<style type="text/css">
	.font_ranking
	{ font-size: 11px; }

	A.hreaf_ranking:link, A.hreaf_ranking:visited
	{ COLOR: #000000;  text-decoration: none;font-size: 11px;FONT-FAMILY: arial;}
	A.hreaf_ranking:active, A.hreaf_ranking:hover
	{ COLOR: #ff6300; text-decoration: none;font-size: 11px; FONT-FAMILY: arial;}
	
	
	A.hreaf_ranking:link, A.hreaf_ranking:visited
	{ COLOR: #000000;  text-decoration: none;font-size: 11px;FONT-FAMILY: arial;}
	A.hreaf_ranking:active, A.hreaf_ranking:hover
	{ COLOR: #ff6300; text-decoration: none;font-size: 11px; FONT-FAMILY: arial;}
	
	.font_ranking_header
	{ font-size:11px;font-weight:bold;}
	
</style>

<script language="javascript">
	function toggle_part_info( name ){
		var obj = document.getElementById( name );
		if( obj ){
			if( obj.style.display == 'block' )obj.style.display = 'none';
			else obj.style.display = 'block';
		}//if
	}//function toggle_part_info
	function review_ranking( link ){
		document.location = link+"&p="+document.forms.f_list.ranking_page.value;
	}// function review_ranking
</script>
{/literal}

<table width="100" cellpadding="0" cellspacing="0">
<tr><td width="650">
	<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
	 <tr>
	 	<td colspan="3">
	 		
	 		<table width="100%">
	 		<tr><td>
		 		<table border="0" cellpadding="5" align="left" width="100%">
		 		<tr>
		 			<!--# SIGN-IN #-->
		 			{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
		 				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:member.enter&ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9018 }</td>
		 			{else}
		 				<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team.enter&params=ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9018 }</td>
		 			{/if}
		 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:rules&ladder_id=`$ladder->id`';" caption=$LNG_MODULE.c9021 }</td>
		 			
		 			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:OpenDetailedPopup( 'popup.php', 'calculator.processor&calculator=`$ladder->calculator`', 'ladder_id=`$ladder->id`', 400, 300 );" caption=$LNG_MODULE.c9024}</td>
		 			
		 		</tr>
		 		</table>
		 	</td>
		 	<td align="right">
		 		<!--# SHOW AFTER FIRST MANAGED-CRON,UPDATE(CHECK BY SERVER) #-->
		 		{if $ladder->fastchallenge_mode && $ladder->fastchallenge_update > 0 }
			 	<table cellpadding="1" cellspacing="1" bgcolor="#000000" width="300">
			 	 <tr><td bgcolor="#FFFFFF" >	
			 		<table cellpadding="5" width="100%" cellspacing="0" background="images/eglbeta/content/design/{$GLOBAL_COLOR}/fastchallenge_bg.gif" style="background-repeat:repeat-x;">
			 		 <tr>
			 		 	<td colspan="2"><i>{$LNG_MODULE.c9800} {$LNG_BASIC.c1400}</i></td>
			 		 </tr>
			 		{if $fc_updatetime_diff <= 0 }
			 			<tr><td colspan="2"><div style="padding:10px;"><b>{$LNG_MODULE.c9025}</b></div></td></tr>
			 		{else}
			 		<tr>
			 			<td width="100"><b>{$LNG_MODULE.c9801}:</b></td>
			 			{if $fc_updatetime_diff <= 0 }
				 			<td>{$LNG_MODULE.c9025}</td>
				 		{else}
				 			<td>{$fc_updatetime_diff_str}</td>
				 		{/if}
			 		</tr>
			 		<tr>
			 			<td><b>{$LNG_BASIC.c1405}:</b></td>
			 			<td>{$fc_num_participants|tointeger} {$LNG_BASIC.c1028}</td>
			 		</tr>
			 		<tr>
			 			{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
			 				<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=`$CURRENT_MODULE_ID`:member.fastchallenge.enter&ladder_id=`$ladder->id`';" caption=$LNG_BASIC.c1406 }</td>
			 			{else}
			 				<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR link="javascript:document.location='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team.fastchallenge.enter&params=ladder_id=`$ladder->id`';" caption=$LNG_BASIC.c1406 }</td>
			 			{/if}
			 		</tr>
			 		{/if}
			 		</table>
		 		 </td></tr>
		 		</table>
		 		{else}
		 		{/if}
		
		 	</td></tr>
		 </table>
		 
	 	</td>
	 </tr>
	 <tr><td colspan="3"><img src="images/spacer.gif" height="10"></td></tr>
	 <tr>
	 	<td colspan="3">{include file="devs/hr2.tpl" width="100%"}</td>
	 </tr>
	 <tr><td colspan="3"><img src="images/spacer.gif" height="10"></td></tr>
	 <tr>
	   	<td valign="bottom">
	   		<!--# RANGLIST {NAME} #-->
			<font style="font-size:22px;"><b>{$LNG_MODULE.c9001}</b></font><br/>
			<b>{$ladder->name|strip_tags|stripslashes}</b>
	 	</td>
	 	<td width="200">
	 	
	 		{if isset($top2[0])}
	 		<table>
	 		 <tr>
	 		 	{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
		  		 	{if $top2[0]->team_logo_file != "non"}
			  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_LOGOS}teams/{$top2[0]->team_logo_file}" width="60" height="60"/></td>
		  		 	{else}
			  		 	<td><img border="1" style="border-color:#000000;" src="images/logo_na.gif" width="60" height="60"/></td>
		  		 	{/if}
		 		 	<td>
		 		 	<h2 style="color:gold; border-color:red; border:1px;">{$LNG_MODULE.c1050}</h2>
		 		 	<b>{$top2[0]->participant_name|strip_tags|stripslashes}</b> <br/>
		 		 	<A href="{$url_file}page=team.info&team_id={$top2[0]->participant_id}">{$LNG_MODULE.c9023}</a>
	 		 	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
		  		 	{if $top2[0]->photo_file != "non"}
			  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_PHOTOS}{$top2[0]->photo_file}" width="45" height="60"/></td>
		  		 	{else}
			  		 	<td><img border="1" style="border-color:#000000;" src="images/photo_na.gif" width="45" height="60"/></td>
		  		 	{/if}
		 		 	<td>
		 		 	<h2 style="color:gold;">1st Place</h2>
		 		 	<b>{$top2[0]->participant_name|strip_tags|stripslashes}</b> <br/>
		 		 	<A href="{$url_file}page=member.info&member_id={$top2[0]->participant_id}">{$LNG_MODULE.c9023}</a> <br/>
			 	{/if}
	 		 	
	 		 	</td>
	 		 </tr>
	 		</table>
	 		{/if}
	 	
	 	</td>
	 	<td width="200">
	
		 	{if isset($top2[1])}
	 		<table>
	 		 <tr>
	 		 	{if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
		  		 	{if $top2[1]->team_logo_file != "non"}
			  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_LOGOS}teams/{$top2[1]->team_logo_file}" width="60" height="60"/></td>
		  		 	{else}
			  		 	<td><img border="1" style="border-color:#000000;" src="images/logo_na.gif" width="60" height="60"/></td>
		  		 	{/if}
		 		 	<td>
		 		 	<h2 style="color:silver;">{$LNG_MODULE.c1051}</h2>
		 		 	<b>{$top2[1]->participant_name|strip_tags|stripslashes}</b> <br/>
		 		 	<A href="{$url_file}page=team.info&team_id={$top2[1]->participant_id}">{$LNG_MODULE.c9023}</a>
	 		 	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
		  		 	{if $top2[1]->photo_file != "non"}
			  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_PHOTOS}{$top2[1]->photo_file}" width="45" height="60"/></td>
		  		 	{else}
			  		 	<td><img border="1" style="border-color:#000000;" src="images/photo_na.gif" width="45" height="60"/></td>
		  		 	{/if}
		 		 	<td>
		 		 	<h2 style="color:silver;">{$LNG_MODULE.c1051}</h2>
		 		 	<b>{$top2[1]->participant_name|strip_tags|stripslashes}</b> <br/>
		 		 	<A href="{$url_file}page=member.info&member_id={$top2[1]->participant_id}">{$LNG_MODULE.c9023}</a> <br/>
			 	{/if}
	 		 	
	 		 	</td>
	 		 </tr>
	 		</table>
		 	{/if}
		 	
	 	</td>
	 </tr>
	</table>
	
	
	<table border="0" cellpadding="0" cellspacing="0" width="650">
	 <tr>
	 	<td><img src="images/modules/inetopia_ladder/ranking_top.gif"/></td>
	 </tr>
	 <tr>
	 	<td bgcolor="#EEEEEE">
			<table border="0" width="100%" cellpadding="1" cellspacing="0">
			 <tr bgcolor="#D6D6D6">
			 	<td width="1"><font class="font_ranking_header">{$LNG_MODULE.c9000}</font></td>
			 	<td width="1%"></td>
			 	<td width="1%"></td>
			 	<td><font class="font_ranking_header">{$LNG_MODULE.c9011}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9002}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9026}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9003}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9027}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9028}</font></td>
			 	<td width="50" align="center"><font class="font_ranking_header">{$LNG_MODULE.c9029}</font></td>
			 	<td width="1"></td>
			 </tr>
			 {section name=part loop=$ladder_participants}
			 <!--# <tr onclick="javascript:document.getElementById('box_{$ladder_participants[part]->participant_id}').style.display='block';" {* onmouseover="javascript:this.style.backgroundColor='ff8342';" onmouseout="javascript:this.style.backgroundColor='';" onclick="javascript:"*} >#-->
	 		<tr>
			  	<td align="center">{$_get.pos+$smarty.section.part.index+1}.</td>
			  	<td align="center"><A href="javascript:toggle_part_info('box_{$ladder_participants[part]->participant_id}');"><img src="images/expand.gif" border="0"/></a>&nbsp;&nbsp;</td>
			  	
		 	   	{if strlen($ladder_participants[part]->country_image_file) > 0}
	   		 	   	<td width="1%"><img src="{$PATH_COUNTRY}{$ladder_participants[part]->country_image_file}" width="15" /></td>
	   		 	{else}
	   		 	   	<td width="1%"><img src="images/spacer.gif" width="15" /></td>
	   		 	{/if}		  	
			  	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
			  		<td><A title="" class="hreaf_ranking" href="{$url_file}page=member.info&member_id={$ladder_participants[part]->participant_id}">{$ladder_participants[part]->participant_name|strip_tags|stripslashes}</a></td>
			  	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
			  		<td>{if $ladder_participants[part]->participant_clan_id}<A class="hreaf_ranking" href="{$url_file}page=clan.info&clan_id={$ladder_participants[part]->participant_clan_id}">{$ladder_participants[part]->participant_clan_tag}</a>&nbsp;&raquo;&nbsp;{/if}<A class="hreaf_ranking" href="{$url_file}page=team.info&team_id={$ladder_participants[part]->participant_id}">{$ladder_participants[part]->participant_name|strip_tags|stripslashes}</a></td>
			  	{/if}
			  	
			  	<td align="center"><font class="font_ranking">{$ladder_participants[part]->points}</font>
			  	
			  	{if $ladder_participants[part]->points > $ladder_participants[part]->last_points && $ladder_participants[part]->matches_all > 0}
			  		<img src="images/rank_up.gif"/>
			  	{elseif $ladder_participants[part]->points < $ladder_participants[part]->last_points && $ladder_participants[part]->matches_all > 0}
			  		<img src="images/rank_down.gif"/>
			  	{else}
			  		<img src="images/spacer.gif" width="9" height="5"/>
			  	{/if}
			  	</td>
			  	
			  	{assign var="ladder_points_dff" value=$ladder_participants[part]->points-$ladder_participants[part]->last_points}
			  	<td align="center"><font class="font_ranking">{$ladder_points_dff|add_match_sign|match_points}</font></td>
			  	
			  	<td align="center"><font class="font_ranking">{$ladder_participants[part]->matches_all|tointeger}</font></td>
			  	<td align="center"><font class="font_ranking">{$ladder_participants[part]->matches_won|tointeger}</font></td>
			  	<td align="center"><font class="font_ranking">{$ladder_participants[part]->matches_draw|tointeger}</font></td>
			  	<td align="center"><font class="font_ranking">{$ladder_participants[part]->matches_lost|tointeger}</font></td>
			  	<!--# DO CHALLENGE #-->
			  	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
			  		<td><A title="" class="hreaf_ranking" href="{$url_file}page={$CURRENT_MODULE_ID}:member.challenge&ladderpart_id={$ladder_participants[part]->id}">{$LNG_MODULE.c9004}!</a></td>
			  	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
			  		<td><A title="" class="hreaf_ranking" href="{$url_file}page=team.teamselect&page_forward={$CURRENT_MODULE_ID}:team.challenge&params=ladder_id={$_get.ladder_id},ladderpart_id={$ladder_participants[part]->id}">{$LNG_MODULE.c9004}!</a></td>
			  	{/if}
			  	
			  </tr>
			  <tr>
			  	<td colspan="11">
			  		<div  style="display:none;" id="box_{$ladder_participants[part]->participant_id}">
			  		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			  		 <tr>
			  		 	<td width="25"><img src="images/spacer.gif" height="1" width="10"/></td>
			  		 	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
				  		 	{if $ladder_participants[part]->photo_file != "non"}
					  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_PHOTOS}{$ladder_participants[part]->photo_file}" width="45" height="60"/></td>
				  		 	{else}
					  		 	<td><img border="1" style="border-color:#000000;" src="images/photo_na.gif" width="45" height="60"/></td>
				  		 	{/if}
				  		 {elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
				  		 	{if $ladder_participants[part]->team_logo_file != "non"}
					  		 	<td><img border="1" style="border-color:#000000;" src="{$PATH_LOGOS}teams/{$ladder_participants[part]->team_logo_file}" width="60" height="60"/></td>
				  		 	{else}
					  		 	<td><img border="1" style="border-color:#000000;" src="images/logo_na.gif" width="60" height="60"/></td>
				  		 	{/if}
				  		 {/if}
			  		 	<td valign="bottom">
				  		 	{lng_parser content=$LNG_MODULE.c9121 time=$ladder_participants[part]->created}
				  		 	<br/><br/>
							<table cellpadding="0" cellspacing="0" border="0">
							<tr>
							  	{if $ladder->participant_type == $smarty.const.PARTTYPE_MEMBER}
							  		<!--# PROFILE #-->
									<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9012 link="`$url_file`page=member.info&member_id=`$ladder_participants[part]->participant_id`"}</td>
							  		<!--# DO CHALLENGE #-->
									<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9004 link="`$url_file`page=`$CURRENT_MODULE_ID`:member.challenge&ladderpart_id=`$ladder_participants[part]->id`&ladder_id=`$ladder_participants[part]->ladder_id`"}</td>
							  	{elseif $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}
							  		<!--# PROFILE #-->
									<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9012 link="`$url_file`page=team.info&team_id=`$ladder_participants[part]->participant_id`"}</td>
							  		<!--# DO CHALLENGE #-->
									<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9004 link="`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team.challenge&params=ladder_id=`$_get.ladder_id`,ladderpart_id=`$ladder_participants[part]->id`,ladder_id=`$ladder_participants[part]->ladder_id`"}</td>
								{/if}
							  		<!--# MATCHES #-->
								<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c9003 link="`$url_file`page=`$CURRENT_MODULE_ID`:matches&ladderpart_id=`$ladder_participants[part]->id`&ladder_id=`$ladder_participants[part]->ladder_id`"}</td>
							</tr>
							</table>
							
						</td>
			  		 </tr>
			  		</table>
			  		</div>
			  	</td>
			  </tr>
			  {if !$smarty.section.part.last}<tr><td colspan="11">{include file="devs/hr_black.tpl" width="100%"}</td></tr>{/if}
			 {/section}
			</table>
			 	
	 	
	 	
	 	</td>
	 </tr>
	 <tr bgcolor="#D6D6D6">
	 	<td>
	 		<form name="f_list" action="javascript:review_ranking('{$url_file}page={$url_page}&ladder_id={$ladder->id}' );">
		 		<table border="0" cellpadding="5" cellspacing="1">
		 		<tr>
		 		<td width="1">
					<select style="width:80;" class="egl_select" onchange="javascript:document.location='{$url_file}page={$url_page}&ladder_id={$ladder->id}&pos='+this.options[this.selectedIndex].value;">
					{section name=p loop=$num_pages}
						{assign var="_start" value=$smarty.section.p.index*$participants_per_page+1}
						{assign var="_tmp" value=$smarty.section.p.index+1}
						{assign var="_end" value=$_tmp*$participants_per_page}
						<option {if $_get.pos == $_start-1}selected{/if} value="{$_start-1}">{$_start} - {$_end}</option>
					{/section}
					</select>
						 		
		 		</td>
		 		<td>Insgesamt {$num_participants|tointeger} eingeschrieben</td>
		 		</tr>
		 		</table>
	 		</form>
	 		
	 	</td>
	 </tr>
	 <tr>
	 	<td><img src="images/modules/inetopia_ladder/ranking_bottom.gif"/></td>
	 </tr>
	</table>
	<br/>
	<table width="650"  border="0">
	 <tr>
	 	<td>
	 	<!--# ADMINS #-->
		<table cellpadding="5"><tr>
		 	<td><b>{$LNG_MODULE.c9019}</b></td>
		 	<td>
			 	{section name=admin loop=$adminlist}
			 		<A href="{$url_file}page=member.info&member_id={$adminlist[admin]->member_id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</a>
			 		{if !$smarty.section.admin.last},{/if}
			 	{/section}
			 	{if sizeof($adminlist)==0}{$LNG_MODULE.c9020}{/if}	
		 	</td>
		 </tr></table>
		
		 <br/><div>{include file="devs/hr2.tpl" width="100%"}</div><br/>
		
		<!--# LAST MATCHES #-->
		<font style="font-size:22px;"><b>{$LNG_MODULE.c9006}</b></font><br/>
		{if count($last_matches) > 0 }
		<table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
		 <tr>
		 	<td><img src="images/modules/inetopia_ladder/ranking_top.gif"/></td>
		 </tr>
		 <tr>
		 	<td bgcolor="#EEEEEE">
		 	
		 		<table width="100%" cellpadding="1" cellspacing="0">
				{section name=result loop=$last_matches}
				 <tr>
				 	<td>{date timestamp=$last_matches[result]->challenge_time format="%d/%m/%y"}<td>
				 	
				 	<td width="45%">
				 		{if $last_matches[result]->winner_id == $last_matches[result]->challenger_id}<img src="images/match.win.gif"/>{/if}
				 		{if $last_matches[result]->winner_id == $last_matches[result]->opponent_id}<img src="images/match.lost.gif"/>{/if}
				 		{if $last_matches[result]->winner_id == $smarty.const.EGL_NO_ID}<img src="images/match.non.gif"/>{/if}
				 		&nbsp;{$last_matches[result]->challenger_participant_name|strip_tags|stripslashes}
				 		({$last_matches[result]->challenger_points|add_match_sign|match_points})
				 		</td>
				 	<td width="1%">&nbsp;vs.&nbsp;</td>
				 	<td width="45%">
				 		{if $last_matches[result]->winner_id == $last_matches[result]->challenger_id}<img src="images/match.lost.gif"/>{/if}
				 		{if $last_matches[result]->winner_id == $last_matches[result]->opponent_id}<img src="images/match.win.gif"/>{/if}
				 		{if $last_matches[result]->winner_id == $smarty.const.EGL_NO_ID}<img src="images/match.non.gif"/>{/if}
				 		&nbsp;{$last_matches[result]->opponent_participant_name|strip_tags|stripslashes}
				 		({$last_matches[result]->opponent_points|add_match_sign|match_points})
				 		</td>
				 	<td><a href="{$url_file}page=match.info&match_id={$last_matches[result]->id}">{$LNG_MODULE.c9009}</a></td>
				 </tr>
		 		 {if !$smarty.section.result.last}<tr><td colspan="9">{include file="devs/hr_black.tpl" width="100%"}</td></tr>{/if}
				 {/section}
				</table>
				
		 	</td>
		 </tr>
		 <tr>
		 	<td><img src="images/modules/inetopia_ladder/ranking_bottom.gif"/></td>
		 </tr>
		</table>
		{else}
			{$LNG_MODULE.c9504}
		{/if}
		
		<br/><br/>
		<!--# NEXT MATCHES #-->
		<font style="font-size:22px;"><b>{$LNG_MODULE.c9007}</b></font><br/>
		{if count($next_matches) > 0 }
		<table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
		 <tr>
		 	<td><img src="images/modules/inetopia_ladder/ranking_top.gif"/></td>
		 </tr>
		 <tr>
		 	<td bgcolor="#EEEEEE">
		 	
		 		<table width="100%" cellpadding="2" cellspacing="0">
				{section name=result loop=$next_matches}
				 <tr>
				 	<td>{date timestamp=$next_matches[result]->challenge_time format="%d/%m/%y"}<td>
				 	<td width="45%"><img src="images/match.non.gif"/>&nbsp;{$next_matches[result]->challenger_participant_name|strip_tags|stripslashes}</td>
				 	<td width="1%">&nbsp;vs.&nbsp;</td>
				 	<td width="45%"><img src="images/match.non.gif"/>&nbsp;{$next_matches[result]->opponent_participant_name|strip_tags|stripslashes}</td>
				 	<td><A href="{$url_file}page=match.info&match_id={$next_matches[result]->id}">{$LNG_MODULE.c9009}</a></td>
				 </tr>
		 		 {if !$smarty.section.result.last}<tr><td colspan="9">{include file="devs/hr_black.tpl" width="100%"}</td></tr>{/if}
				 {/section}
				</table>
				
		 	</td>
		 </tr>
		 <tr>
		 	<td><img src="images/modules/inetopia_ladder/ranking_bottom.gif"/></td>
		 </tr>
		</table>
		{else}
			{$LNG_MODULE.c9502}
		{/if}
		
		<br/><br/><div>{include file="devs/hr2.tpl" width="100%"}</div><br/>
	
		<!--# LAST/TOP NEWS #-->
		<font style="font-size:22px;"><b>{$LNG_MODULE.c9008}</b></font><br/>
		{if count($ladder_news) > 0 }
		<table width="650" cellpadding="5" cellspacing="1">
		{section name=news loop=$ladder_news}
		 <tr>
			<td>
				<table width="100%" cellpadding="2" cellspacing="0">
				<tr><td>
					<A href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$ladder_news[news]->id}"><font style="font-size:16px; font-weight:bold;">{$ladder_news[news]->title|strip_tags|stripslashes}</font></a>
					<br/>
					{$ladder_news[news]->short_text|strip_tags|stripslashes}
					<br/><br/>
					<div align="left" >
					<A href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:show&news_id={$ladder_news[news]->id}"><b>FULL STORY</b></a> |
					<b>{$ladder_news[news]->num_comments} Kommentare</b>
					</div>
				</td>
					{if $ladder_news[news]->image_file != 'non'}
					<td><img border="1" style="border-color:#000000;"src="{$smarty.const.EGLDIR_NEWS_IMAGES}{$ladder_news[news]->image_file}"/></td>
					{/if}
				</tr></table>
			</td>
		 </tr>
		{if !$smarty.section.news.last}<tr><td><hr/></td></tr>{/if}
		{/section}
		</table>
		{else}
			{$LNG_MODULE.c9505}
		{/if}
		
	 </td></tr>
	</table>
</td><td>

</td></tr>
</table>