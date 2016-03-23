<h2>{$LNG_MODULE.c9014}</h2>
<br/>
{include file="devs/message.tpl"}
{if !$SCREEN_LOCKED}
{literal}
<script language="javascript">
</script>
{/literal}

{if !$success}
{if $PROCESS==0}{assign var="PROCESS0_COLOR_WHITE" value="color:white;"}{/if}
{if $PROCESS==1}{assign var="PROCESS1_COLOR_WHITE" value="color:white;"}{/if}
{if $PROCESS==2}{assign var="PROCESS2_COLOR_WHITE" value="color:white;"}{/if}


<table cellpadding="0" cellspacing="0" align="center" width="100%">
 <tr>
 	<!--# STEP 1 #-->
 	<td><img src="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_left.gif"/></td>
 	<td background="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_middle.gif" align="center" width="33%"> 
 		<font style="{$PROCESS0_COLOR_WHITE}font-size:15px;font-weight:bold;">{$LNG_MODULE.c9030}</font><br/>
 		<font style="{$PROCESS0_COLOR_WHITE}font-size:10px;">{$LNG_MODULE.c9031}</font>
 		
 	</td>
 	<!--# STEP 2 #-->
 	<td><img src="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_split.gif"/></td>
 	<td background="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_middle.gif" align="center" width="33%">
 		<font style="{$PROCESS1_COLOR_WHITE}font-size:15px;font-weight:bold;">{$LNG_MODULE.c9040}</font><br/>
 		<font style="{$PROCESS1_COLOR_WHITE}font-size:10px;">{$LNG_MODULE.c9041}</font>
 	
 	</td>
 	<td><img src="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_split.gif"/></td>
 	<td background="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_middle.gif" align="center" width="33%">
 		<font style="{$PROCESS2_COLOR_WHITE}font-size:15px;font-weight:bold;">{$LNG_MODULE.c9050}</font><br/>
 		<font style="{$PROCESS2_COLOR_WHITE}font-size:10px;">{$LNG_MODULE.c9051}</font>
 	
 	</td>
 	<td><img src="images/eglbeta/content/design/{$GLOBAL_COLOR}/longbutton/bt_lb_right.gif"/></td>
 </tr>
</table>
<br/>
{*include file="devs/hr2.tpl" width="100%"*}

<!--# CHALLENGE-TYPE#-->
{if $PROCESS == 0}
	<form name="f" method="POST" action="{$url_file}page={$url_page}&ladderpart_id={$_get.ladderpart_id}&process=1">
	<table width="100%" cellpadding="5">
	 <tr>
		<td>
		 		<table cellpadding="5">
		 		 <tr>
		 		 	<td width="150"><b>{$LNG_MODULE.c9032}</b></td>
		 		 	<td><a href="{$url_file}page=member.info&member_id={$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</a></td>
		 		 </tr>		 		
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9033}</b></td>
		 		 	<td><select name="ctype" class="egl_select">
		 		 			{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_SINGLE_MAP}<option value="singlemap">{$LNG_MODULE.c9070}</option>{/if}
							{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_DOUBLE_MAP}<option value="doublemap">{$LNG_MODULE.c9072}</option>{/if}
							{if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_RANDOM_MAP}<option value="randommap">{$LNG_MODULE.c9071}</option>{/if}
						</select>
		 		 	</td>
		 		 </tr>
		 		</table>
			 			
		</td>
	 </tr>
	 <tr>
	 	<td align="center">
	 		<table><tr>
	 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1101 link="javascript:history.back(1);"}</td>
	 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:document.f.submit();"}</td>
	 		</tr></table>
	 	</td>
	  </tr>
	</table>
	</form>
<!--# MAP SELECTION #-->
{elseif $PROCESS == 1}

	{if $challenge_type == "randommap" }
		
		<form name="f" method="POST" action="{$url_file}page={$url_page}&ladderpart_id={$_get.ladderpart_id}&ctype={$challenge_type}&process=2">
		<table width="100%" cellpadding="5">
		 <tr>
		 	<td>
		 	
		 		<table cellpadding="5">
		 		 <tr>
		 		 	<td width="150"><b>{$LNG_MODULE.c9032}</b></td>
		 		 	<td><a href="{$url_file}page=member.info&member_id={$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</a></td>
		 		 </tr>		 		
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9033}</b></td>
		 		 	{if $challenge_type == "singlemap"}<td>{$LNG_MODULE.c9070}</td>{/if}
		 		 	{if $challenge_type == "doublemap"}<td>{$LNG_MODULE.c9072}</td>{/if}
		 		 	{if $challenge_type == "randommap"}<td>{$LNG_MODULE.c9071}</td>{/if}
		 		 </tr>
		 		</table>
		 	
		 	</td>
		 </tr>
		 <tr>
		 	<td align="center">
		 		<table><tr>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1101 link="`$url_file`page=`$url_page`&ladderpart_id=`$_get.ladderpart_id`&process=0"}</td>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:document.f.submit();"}</td>
		 		</tr></table>
		 	</td>
		  </tr>
		</table>
		</form>
	{elseif $challenge_type == "singlemap" }
	
		<form name="f" method="POST" action="{$url_file}page={$url_page}&ladderpart_id={$_get.ladderpart_id}&ctype={$challenge_type}&process=2">
		<table width="100%" cellpadding="5">
		 <tr>
		 	<td>
		 	
		 		<table cellpadding="5">
		 		 <tr>
		 		 	<td width="150"><b>{$LNG_MODULE.c9032}</b></td>
		 		 	<td><a href="{$url_file}page=member.info&member_id={$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</a></td>
		 		 </tr>		 		
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9033}</b></td>
		 		 	{if $challenge_type == "singlemap"}<td>{$LNG_MODULE.c9070}</td>{/if}
		 		 	{if $challenge_type == "doublemap"}<td>{$LNG_MODULE.c9072}</td>{/if}
		 		 	{if $challenge_type == "randommap"}<td>{$LNG_MODULE.c9071}</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td width="50"><b>{$LNG_MODULE.c9034}</b></td>
		 		 	{if isset($MAPS)}
			 		 	<td><select name="map1" class="egl_select" style="width:200px">
			 		 	{section name=map loop=$MAPS}
			 		 		<option value="{$MAPS[map]->map_name}">{$MAPS[map]->map_name|strip_tags|stripslashes}</option>
			 		 	{/section}
			 		 	</select></Td>
		 		 	{else}
		 		 		<td><input type="text" class="egl_text" style="width:200px;" name="map1" value="{$_get.map1|strip_tags|stripslashes}"/></td>
		 		 	{/if}
		 		 	</td>
		 		 </tr>
		 		</table>
		 	
		 	</td>
		 </tr>
		 <tr>
		 	<td align="center">
		 		<table><tr>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1101 link="`$url_file`page=`$url_page`&ladderpart_id=`$_get.ladderpart_id`&process=0"}</td>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:document.f.submit();"}</td>
		 		</tr></table>
		 	</td>
		  </tr>
		</table>
		</form>
	
	{elseif $challenge_type == "doublemap" }
	
		<form name="f" method="POST" action="{$url_file}page={$url_page}&ladderpart_id={$_get.ladderpart_id}&ctype={$challenge_type}&process=2">
		<table width="100%" cellpadding="5">
		 <tr>
		 	<td>
		 	
		 		<table cellpadding="5">
		 		 <tr>
		 		 	<td width="150"><b>{$LNG_MODULE.c9032}</b></td>
		 		 	<td><a href="{$url_file}page=member.info&member_id={$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</a></td>
		 		 </tr>		 		
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9033}</b></td>
		 		 	{if $challenge_type == "singlemap"}<td>{$LNG_MODULE.c9070}</td>{/if}
		 		 	{if $challenge_type == "doublemap"}<td>{$LNG_MODULE.c9072}</td>{/if}
		 		 	{if $challenge_type == "randommap"}<td>{$LNG_MODULE.c9071}</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td width="50"><b>{$LNG_MODULE.c9034}</b></td>
		 		 	{if isset($MAPS)}
			 		 	<td><select name="map1" class="egl_select" style="width:200px">
			 		 	{section name=map loop=$MAPS}
			 		 		<option value="{$MAPS[map]->map_name}">{$MAPS[map]->map_name|strip_tags|stripslashes}</option>
			 		 	{/section}
			 		 	</select></td>
					{else}
			 		 	<td><input type="text" class="egl_text" name="map1" value="{$_get.map1|stripslashes|strip_tags}"/></td>
			 		 {/if}
		 		 </tr>
		 		</table>
		 	
		 	</td>
		 </tr>
		 <tr>
		 	<td align="center">
		 		<table><tr>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1101 link="`$url_file`page=`$url_page`&ladderpart_id=`$_get.ladderpart_id`&process=0"}</td>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:document.f.submit();"}</td>
		 		</tr></table>
		 	</td>
		  </tr>
		</table>
		</form>
		
	
	{/if}


<!--# ACCEPT CHALLENGE #-->
{elseif $PROCESS == 2}
		 <form name="f" method="POST" action="{$url_file}page={$url_page}&ladderpart_id={$_get.ladderpart_id}&ctype={$challenge_type}&map1={$map1|stripslashes|strip_tags}&process=3">
		<table width="100%" cellpadding="5">
		 <tr>
		 	<td>
		 	
		 		<table cellpadding="5">
		 		 <tr>
		 		 	<td width="150"><b>{$LNG_MODULE.c9032}</b></td>
		 		 	<td><a href="{$url_file}page=member.info&member_id={$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</a></td>
		 		 </tr>		 		
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9033}</b></td>
		 		 	{if $challenge_type == "singlemap"}<td>{$LNG_MODULE.c9070}</td>{/if}
		 		 	{if $challenge_type == "doublemap"}<td>{$LNG_MODULE.c9072}</td>{/if}
		 		 	{if $challenge_type == "randommap"}<td>{$LNG_MODULE.c9071}</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td width="100"><b>{$LNG_MODULE.c9034}</b></td>
		 		 	{if strlen($map1)==0 && $challenge_type != "randommap"}<td><font color="red">{$LNG_BASIC.c1300}</font></td>{/if}
		 		 	{if $challenge_type == "randommap"}<td>Unbekannt</td>{/if}
		 		 	{if $challenge_type != "randommap"}<td>{$map1|strip_tags}</td>{/if}
		 		 </tr>
		 		 <tr>
		 		 	<td><b>{$LNG_MODULE.c9035}</b></td>
		 		 	<td><input name="challenge_date" value="{date format='%d.%m.%y' timestamp=$smarty.const.EGL_TIME+7200}" size="10" type="text" class="egl_text"/> um <input name="challenge_time" type="text" value="{date format='%H:%M' timestamp=$smarty.const.EGL_TIME+7200}" size="5" class="egl_text"/> Uhr
		 		 	</td>
		 		 </tr>
		 		</table>
		 		
		 	</td>
		 </tr>
		 <tr>
		 	<td align="center">
		 		<table><tr>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1101 link="`$url_file`page=`$url_page`&ladderpart_id=`$_get.ladderpart_id`&process=1&ctype=`$_get.ctype`&map1=`$map1`"}</td>
		 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1100 link="javascript:document.f.submit();"}</td>
		 		</tr></table>
		 	</td>
		  </tr>
		</table>
		</form>
{elseif $PROCESS == 3}


{else}
{/if} 

{/if} <!--#!ŚUCCESS#-->

{/if} <!--#LOCKED SCREEN#-->