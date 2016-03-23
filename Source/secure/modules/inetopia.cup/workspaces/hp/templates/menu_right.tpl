 	<table width="100%" height="300" border="0" cellpadding="0" cellspacing="0" background="images/eglbeta/content/design/{$GLOBAL_COLOR}/bg_right.gif" style="background-repeat:no-repeat;">
 	 <tr><td valign="top" align="center">
 		<table border="0" width="260" cellpadding="10"><tr><td align="center">
 		
 			<br/>
 			<table cellpadding="0" cellspacing="1" bgcolor="#000000"><tr><td><img src="{$path_games}small/{$cup->game_logo}" width="100"/></td></tr></table>
 			<br/><br/>
			<table>
			 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1020  	link="`$url_file`page=`$CURRENT_MODULE_ID`:info&cup_id=`$cup->id`"}</td></tr>
			 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1021  	link="`$url_file`page=`$CURRENT_MODULE_ID`:participants&cup_id=`$cup->id`"}</td></tr>
			 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1022 	link="`$url_file`page=`$CURRENT_MODULE_ID`:cuptree&cup_id=`$cup->id`"}</td></tr>
			 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1023 	link="`$url_file`page=`$CURRENT_MODULE_ID`:encounts&cup_id=`$cup->id`"}</td></tr>
			 <tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1024 	link="`$url_file`page=`$CURRENT_MODULE_ID`:rules&cup_id=`$cup->id`"}</td></tr>
			 <tr><td>&nbsp;</td></tr>
			{if !$cup->encounts_created && $cup->is_public }
				{if $smarty.const.EGL_TIME >= $cup->start_time- ($cup->checkin_time*60) }
					{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER}
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1050 link="javascript:document.location.href='`$url_file`page=`$CURRENT_MODULE_ID`:member_join&cup_id=`$cup->id`&a=check_in';"}</td></tr>
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1051 link="javascript:document.location.href='`$url_file`page=`$CURRENT_MODULE_ID`:member_join&cup_id=`$cup->id`&a=check_out';"}</td></tr>
					{/if}
					{if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1050 link="javascript:document.location.href='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team_join&params=cup_id=`$cup->id`,a=check_in';"}</td></tr>
					<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1051 link="javascript:document.location.href='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team_join&params=cup_id=`$cup->id`,a=check_out';"}</td></tr>
					{/if}
				{else}
					{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER}
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1052 link="javascript:document.location.href='`$url_file`page=`$CURRENT_MODULE_ID`:member_join&cup_id=`$cup->id`&a=enter';"}</td></tr>
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1053 link="javascript:document.location.href='`$url_file`page=`$CURRENT_MODULE_ID`:member_join&cup_id=`$cup->id`&a=quit';"}</td></tr>
					{/if}
					{if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1052 link="javascript:document.location.href='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team_join&params=cup_id=`$cup->id`,a=enter';"}</td></tr>
						<tr><td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_MODULE.c1053 link="javascript:document.location.href='`$url_file`page=team.teamselect&page_forward=`$CURRENT_MODULE_ID`:team_join&params=cup_id=`$cup->id`,a=quit';"}</td></tr>
					{/if}
				{/if}
			{/if}	 		 	
			</table>
		 	
		 </td></tr>
		</table>
	 	
 	</td></tr>
 	</table>
 	