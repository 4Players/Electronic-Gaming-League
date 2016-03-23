<h2>Match verwalten</h2>
{include file="etc/message.tpl"}

<script language="javascript" src="javascript/browser_handling.js"></script>

{if $match}
<hr size="1"/>
<table border="0" cellpadding="2" cellspacing="0" width="800" align="center">
 <tr>
 	<td colspan="2" align="center"> 
 		
 		<h2>
 		{if $match->participant_type == $smarty.const.PARTTYPE_TEAM}
 			{if $challenger->participant_clan_id}<i>{$challenger->participant_clan_name|strip_tags|stripslashes}</i> {#arrow_db_right#} {/if} {$challenger->participant_name|strip_tags|stripslashes} <br/>
 			<font color="{#clr_rank_red#}"><b> Vs. </b></font> <br/>
	 		{if $opponent->participant_clan_id} <i>{$opponent->participant_clan_name|strip_tags|stripslashes}</i> {#arrow_db_right#} {/if}{$opponent->participant_name|strip_tags|stripslashes} 
		{else}
			{$challenger->participant_name|strip_tags|stripslashes}
			<font color="{#clr_rank_red#}"><b> Vs. </b> </font>
			{$opponent->participant_name|strip_tags|stripslashes}
		
		 {/if}
		 </h2>

	  	
	 </td>
 </tr>
 <tr>
  	<td valign="top" width="50%" >
  	
  		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_rank_red#}" width="100%">
  		 <tr><td align="center"><b>Contestants</b></td></tr>
  		 <tr>
  		 	<td bgcolor="{#clr_content#}">

  			<table border="0" cellpadding="0" cellspacing="0">
  			 <tr>
  			  	<td valign="top" width="50%"> 	
  			  	
  			  	
  			  		<table border="0" cellpadding="0" cellspacing="4" width="100%%">
  			  		 <tr>
  			  		   	<td valign="top" align="center" width="50%"> 
  			  		   	
  			  		   		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
  			  		   		 <tr><td>
  			  		   			{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
  			  		   				{if $challenger->participant_photo_file != 'non' && $challenger }
							  			<img src="{$path_photos}/{$challenger->participant_photo_file}" width="90" height="120">  
							  		{else}
							  			<img src="images/photo.na.jpg" width="90" height="120">  
							  		{/if}
					  				<!-- <img src="{$path_logos}/members/{$challenger->participant_photo_file}" width="100" height="100">  -->
					  			{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
					  				{if $challenger->participant_logo_file != 'non' && $challenger }
					  					<img src="{$path_logos}/teams/{$challenger->participant_logo_file}" width="100" height="100"/> 
					  				{else}
							  			<img src="images/logo.na.jpg" width="100" height="100">  
					  				{/if}
					  		 	{/if}
					  		 </td></tr>
					  		</table>
					  		
					  		
  			  		   	</td>
  			  		 </tr>
  			  		 <tr>
  			  		 	<td align="center" valign="top">
		  		   		 {if $challenger->country_image_file}
 	  		   		 		<i>(<img src="{$path_country}{$challenger->country_image_file}">{$challenger->country_name})</i>
 			  		   	 {/if}
 			  		   	 
 			  		   	<br/>
  			  		 	<b>
						{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
	 						<A class="href_orange" href="{$url_file}page=cms.member.central&member_id={$challenger->participant_id}">	{$challenger->participant_name|strip_tags|stripslashes} </a>
	 					{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	 						{if $challenger->participant_clan_id} <a href="{$url_file}page=clan.info&clan_id={$challenger->participant_clan_id}">{$challenger->participant_clan_tag}</a> {#arrow_db_right#} {/if}
	 						<A class="href_orange" href="{$url_file}page=cms.team.central&clan_id={$challenger->participant_clan_id}&team_id={$challenger->participant_id}">{$challenger->participant_name|strip_tags|stripslashes} </a>
					 	{/if}
  			  		 	</b>
  			  		 		 </td>
  			  		 </tr>
  			  		</table> 
  			  		
  			  	
  			  		</td>
  			  	<td width="1%"> <b>Vs.</b> </td>
  			  	<td align="center" valign="top">
  			  	
  			  	
  			  		<table border="0" cellpadding="0" cellspacing="2" width="100%">
  			  		 <tr>
  			  		   	<td valign="top" align="center"> 
  			  		   	
  			  		   		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
  			  		   		 </td></tr>
  			  		   		 <tr><td> 
  			  		   		 
	  			  		   		{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
	  			  		   			{if $opponent->participant_photo_file != 'non' && $opponent }
						  				<img src="{$path_photos}/{$opponent->participant_photo_file}" width="90" height="120">  
						  			{else}
							  			<img src="images/photo.na.jpg" width="90" height="120">  
						  			{/if}
						  			<!-- <img src="{$path_logos}/members/{$opponent->participant_photo_file}" width="100" height="100">  -->
						  		{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
						  			{if $opponent->participant_logo_file != 'non' && $opponent }
						  				<img src="{$path_logos}/teams/{$opponent->participant_logo_file}" width="100" height="100">  
					  				{else}
							  			<img src="images/logo.na.jpg" width="100" height="100">  
					  				{/if}
						  		{/if}
					  		 </td></tr>
					  		</table>

					  		
  			  		   	 </td>
  			  		 </tr>
  			  		 <tr>
  			  		 	<td align="center"> 
		  		   		{if $opponent->country_image_file}
		  		   			<i>(<img src="{$path_country}{$opponent->country_image_file}">{$opponent->country_name})</i>
		  		   		{/if}
		  		   		<br/>
		  		   		
  			  		 	<b>
	 					{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
	 						<A class="href_orange" href="{$url_file}page=cms.member.central&member_id={$opponent->participant_id}">	{$opponent->participant_name} </a>
	 					{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	 						{if $opponent->participant_clan_id} <a href="{$url_file}page=clan.info&clan_id={$opponent->participant_clan_id}">{$opponent->participant_clan_tag}</a> {#arrow_db_right#} {/if}
	 						<A class="href_orange" href="{$url_file}page=cms.team.central&clan_id={$opponent->participant_clan_id}&team_id={$opponent->participant_id}">{$opponent->participant_name} </a>
					 	{/if}
  			  		 		</b>
  			  		 		</td>
  			  		 </tr>
  			  		</table> 
  			  	
  			  		</td>
  			 </tr>
  		    <tr>
  			   	<td colspan="4" align="center">
  			   	 <br/><br/> <b>
  			   	 {if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		    		{if $match->winner_id == $challenger->participant_id} <i>`{if $challenger->participant_clan_id}{$challenger->participant_clan_tag} {#arrow_db_right#}{/if}<u>{$challenger->participant_name}</u>` gewinnt. </i>{/if}
		    		{if $match->winner_id == $opponent->participant_id} <i>`{if $opponent->participant_clan_id}{$opponent->participant_clan_tag} {#arrow_db_right#}{/if}<u>{$opponent->participant_name}</u>` gewinnt . </i>{/if}
  			   	 {else}
		    		{if $match->winner_id == $challenger->participant_id} <i>`{$challenger->participant_name}` gewinnt! </i>{/if}
		    		{if $match->winner_id == $opponent->participant_id} <i>`{$opponent->participant_name}` gewinnt! </i>{/if}
		    	{/if}
		    	</b>
		    	<br/><br/><br/>
		    	</td>  			    
		    </tr>
  		</table>
  		
  		
  	</td></tr>
  	</table>	
  			
  		
  	</td>
  	<td valign="top" align="center">
  	
			<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_rank_red#}" width="100%">
			  <tr>
			  	<td align="center" ><b>Parameters</b></td>
			  </tr>
			  <tr>
			  	<td bgcolor="{#clr_content#}">
			  		
			
			  	<form name="fparams" action="{$url_file}page={$url_page}&match_id={$match->id}&a=update_parameters" method="POST">
			  	
		 			<table border="0" cellpadding="5" cellspacing="1" width="100%">
		  			 <tr>
		  			  	<td> <b> MatchId: </td>
		  			  	<td> <b>{$match->id}</b> </td>
		  			 </tr>
		  			 <tr>
		  			  	<td> <b> Status: </td>
		  				  	<td> <select class="egl_select" name="match_status" style="width:100%;">
			  			  	{if $match->status == $smarty.const.MATCH_RUNNING }<option selected value="{$smarty.const.MATCH_RUNNING}">Running</option>{else} <option value="{$smarty.const.MATCH_RUNNING}">Running</option> {/if}
			  			  	{if $match->status == $smarty.const.MATCH_REPORTED }<option selected value="{$smarty.const.MATCH_REPORTED}">Reported</option>{else} <option value="{$smarty.const.MATCH_REPORTED}">Reported</option> {/if}
			  			  	{if $match->status == $smarty.const.MATCH_CLOSED }<option selected value="{$smarty.const.MATCH_CLOSED}">Closed</option>{else} <option value="{$smarty.const.MATCH_CLOSED}">Closed</option> {/if}
			  			  	</td>
		  			 </tr>
		  			 <tr>
		  			  	<td> <b>Challenge: </td>
		  			  	<td> <b> {date timestamp=$match->challenge_time} </b></td>
		  			 </tr>
		  			 <tr>
		  			  	<td><b>Report: </td>
		  			  	<td><select name="report_id" class="egl_select" style="width:100%;">
		  			  			<option value="-1">Kein Report</option>
		  			  			
  			  		   			{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
  			  		   				
							  			<option {if $challenger->participant_id == $match->report_id}selected{/if} value="{$challenger->participant_id}">{$challenger->participant_name|strip_tags|stripslashes}</option>
							  			<option {if $opponent->participant_id == $match->report_id}selected{/if} value="{$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</option>
					  			{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
					  			
							  			<option {if $challenger->participant_id == $match->report_id}selected{/if} value="{$challenger->participant_id}">{$challenger->participant_name|strip_tags|stripslashes}</option>
							  			<option {if $opponent->participant_id == $match->report_id}selected{/if} value="{$opponent->participant_id}">{$opponent->participant_name|strip_tags|stripslashes}</option>
							  			
					  		 	{/if}
		  			  		</select>
		  			  	</td>
		  			 </tr>
		  			 <tr>
		  			  	<td> <b>Calculated: </td>
		  			  	{if $match->evaluated}
		  			  		<td> <b> {date timestamp=$match->evaluate_time} </b></td>
		  			  	{else}
		  			  		<td><b> Not evaluated</b></td>
		  			  	{/if}
		  			 </tr>
		  			 <tr>
		  			 	<!--#<td colspan="2" align="right"><input type="submit" value=" Send " class="egl_button"/></td>#-->
		  			 	<td colspan="2>">{include file="buttons/bt_universal.tpl" caption="abschicken" link="javascript:document.fparams.submit();"}</td>
		  			 </tr>
		  			</table>  
			  	</form>
			  	</td></tr>
			  </table>
	  	 
	  	 
	  	 
  	</td>
 </tr>
 <tr>
	<td valign="top">
	
		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_rank_red#}" width="100%">
		  <tr>
		  	<td align="center" ><b>Ergebnisse</b></td>
		  </tr>
		  <tr>
		  	<td bgcolor="{#clr_content#}">
	
			  <table border="0" cellpadding="5" cellspacing="2" width="100%">
			  <tr>
			  	<td width="50%"> </td>
			  	<td width="1%"> </td>
			  	<td> </td>
			  </tr>

			  	<form name="fresults" action="{$url_file}page={$url_page}&match_id={$match->id}&a=update_score" method="POST">
				{*section name=map_res loop=$match_result->aMapResults*}
				{section name=map_res loop=$match->num_maps}
				
					{* CHECK: Haben die Runden einen bestimmten Namen ?*}
					{if $display_detailed_rounds }
						<tr><td colspan="4">
							<table border="0" cellpadding="0" cellspacing="8" width="100%" style="background-repeat:no-repeat;" background="images/match_admin_map_bg.gif">
							 <tr>
								<td><input name="match_map_{$smarty.section.map_res.index}" size="20" type="text" class="egl_text" size="15" value="{$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes}"/> </td>
								<td width="1%"><a title="Map entfernen" href="{$url_file}page={$url_page}&match_id={$match->id}&a=remove_map&index={$smarty.section.map_res.index}"><img border="0" src="images/edit_remove_small.gif"/></a></td>
								<td width="1%">&nbsp;</td>
								<td width="1%"><a title="Neue Map hier einfügen" href="{$url_file}page={$url_page}&match_id={$match->id}&a=add_map&index={$smarty.section.map_res.index}"><img border="0" src="images/edit_add_small.gif"/></a></td>
							 </tr>
						   	</table>
						</td></tr>
	  					 <!--#<tr><td colspan="3"><b> {$match_result->aMapResults[map_res]->map_name} </b></td></tr>#-->
						{*section name=rnd loop=$match_result->aMapResults[map_res]->aRounds*}
						{section name=rnd loop=$match->num_rounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
	  								<td width="1%"><img src="images/spacer.gif" width="10" height="1"></td>
	  								<td align="left"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name|strip_tags|stripslashes char="#" item="0"} </td>
	  					 			<td width="1%" align="left"><input  style="border-color:red;" align="right" type="text" class="egl_text" name="match_score_{$smarty.section.map_res.index}_round_{$smarty.section.rnd.index}_challenger" value="{$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score|tointeger}" size=5></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b></td>
				  			<td align="left"> <input  style="border-color:red;" type="text" class="egl_text" name="match_score_{$smarty.section.map_res.index}_round_{$smarty.section.rnd.index}_opponent" value="{$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score|tointeger}" size=5> </td>
	  						<td align="right"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name|strip_tags|stripslashes char="#" item="1"} </td>
	  					 </tr>
						{/section}
	
					{else}
						<!--#<tr><td colspan="4"> <input name="match_map_{$smarty.section.map_res.index}" type="text" class="egl_text" size="15" value="{$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes}"/> </td></tr>#-->
						<tr ><td colspan="4">
							<table border="0" cellpadding="0" cellspacing="8" width="100%" style="background-repeat:no-repeat;" background="images/match_admin_map_bg.gif">
							 <tr>
								<td><input name="match_map_{$smarty.section.map_res.index}" size="20" type="text" class="egl_text" size="15" value="{$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes}"/> </td>
								<td width="1%"><a title="Map entfernen" href="{$url_file}page={$url_page}&match_id={$match->id}&a=remove_map&index={$smarty.section.map_res.index}"><img border="0" src="images/edit_remove_small.gif"/></a></td>
								<td width="1%">&nbsp;</td>
								<td width="1%"><a title="Neue Map hier einfügen" href="{$url_file}page={$url_page}&match_id={$match->id}&a=add_map&index={$smarty.section.map_res.index}"><img border="0" src="images/edit_add_small.gif"/></a></td>
							 </tr>
						   	</table>
						</td></tr>
						
						{*section name=rnd loop=$match_result->aMapResults[map_res]->aRounds*}
						{section name=rnd loop=$match->num_rounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
	  								<td align="left"><!--#<b>{$match_result->aMapResults[map_res]->map_name}</b>#--></td>
	  					 			<td width="1%" align="right"><input  style="border-color:red;" align="right" type="text" class="egl_text" name="match_score_{$smarty.section.map_res.index}_round_{$smarty.section.rnd.index}_challenger" value="{$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score|tointeger}" size=5></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b> </td>
				  			<td align="left"><input  style="border-color:red;" align="right" type="text" class="egl_text" name="match_score_{$smarty.section.map_res.index}_round_{$smarty.section.rnd.index}_opponent" value="{$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score|tointeger}" size=5></td>
					  		<td></td>
	  					 </tr>
						{/section}
					{/if} 
				{/section}
				<tr ><td colspan="4">
					<table border="0" cellpadding="0" cellspacing="10" width="100%" style="background-repeat:no-repeat;" background="images/match_admin_map_bg.gif">
					 <tr>
						<td>Map hinzufügen</td>
						<td width="1%"><a title="Neue Map hier einfügen" href="{$url_file}page={$url_page}&match_id={$match->id}&a=add_map&index={$smarty.section.map_res.index}"><img border="0" src="images/edit_add_small.gif"/></a></td>
					 </tr>
				   	</table>
				</td></tr>
  			    <tr>
  			    	<!--# <td colspan="4" align="right"> <br/><input class="egl_button" type="submit" value=" Send "></td> #-->
  			    	<td colspan="4" align="left"> {include file="buttons/bt_universal.tpl" caption="abschicken" link="javascript:document.fresults.submit();"}</td>
				</tr>
				</form>
  			  
				<tr><td colspan="4"> <hr size=1></td></tr>
				<tr>
  			 		<td align="right">	
  			 			<table border="0" width="100%" cellpadding="0" cellspacing="0">
  			 			 <tr>
  			 			 	<td align="left"><b>Total</b>  </td>
  			 			 	<td width="1%" align="right">
  			 			 	{if $match->evaluated}
	 					 		{if $match_result->bchallenger_win}
	 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content="<b>`$match_result->total_challenger_score`</b>"}
	 					 		{elseif $match_result->bopponent_win}
	 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content="<b>`$match_result->total_challenger_score`</b>"}
	 					 		{else}
	 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>`$match_result->total_challenger_score`</b>"}
				 		 		{/if}
  			 			 	{else}
								{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>-</b>"}
  			 			 	{/if}
  			 			 	</td>
  			 			 </tr>
  			 			</table>
  			 		 	</td>
  			 		<td align="center"><b>:</b></td>
	 		 		<td align="left">
	 			 	{if $match->evaluated}
		 		 		{if $match_result->bopponent_win}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content="<b>`$match_result->total_opponent_score`</b>"}
		 		 		{elseif $match_result->bchallenger_win}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content="<b>`$match_result->total_opponent_score`</b>"}
		 		 		{else}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>`$match_result->total_opponent_score`</b>"}
		 		 		{/if}
		 		 	{else}
						{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>-</b>"}  
		 		 	{/if}
 		 			</td>
  			    </tr>
				<tr>
  			 		<td align="right">	
  			 			<table border="0" width="100%" cellpadding="0" cellspacing="0">
  			 			 <tr>
  			 			 	<td align="left"><b>Punkte</b>  </td>
  			 			 	<td width="1%" align="right"><b>
			 			 	{if $match->evaluated}
		 		 				{if $match->challenger_points > 0}
					 		 		{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content="<b>`$match->challenger_points`</b>"}
		 		 				{elseif $match->challenger_points < 0}
					 		 		{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content="<b>`$match->challenger_points`</b>"}
		 				 		{else}
					 		 		{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>`$match->challenger_points`</b>"}
				 		 		{/if}
				 		 	{else}
								{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>?</b>"}  
				 		 	{/if}
  			 			 	</b></td>
  			 			 </tr>
  			 			</table>
  			 		 	</td>
  			 		<td align="center"><b>:</b></td>
	 		 		<td align="left"><b>
	 			 	{if $match->evaluated}
 		 				{if $match->opponent_points > 0}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content="<b>`$match->opponent_points`</b>"}
 		 				{elseif $match->opponent_points < 0}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content="<b>`$match->opponent_points`</b>"}
 				 		{else}
			 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>`$match->opponent_points`</b>"}
		 		 		{/if}
		 		 	{else}
						{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>?</b>"}  
		 		 	{/if}
	 		 		</b></td>
  			    </tr>
  			    </table>	
  			    
  		</td></tr>
  	 </table>	
  			    
  			    	
	</td>
	<td valign="top">
	
		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_rank_red#}" width="100%">
		  <tr>
		  	<td align="center" ><b>Media</b></td>
		  </tr>
	  	<tr><td bgcolor="{#clr_content#}">
	  			<table border="0" cellpadding="2" cellspacing="0" width="100%">
	  			 {section name=media loop=$media_files}
	  			 	<tr>
	  			 		<td width="1%" valign="top"> <img src="images/file_format/{file_extension file=$media_files[media]->file_name}.gif"></td>
	  			 		<td> 
	  			 			<A target="_blank" href="files/media_pool/{$media_files[media]->file_name}"> <b>{$media_files[media]->name}</b> </a> <br/> 
	  			 			<table cellpadding="0" cellspacing="0" width="100%">
	  			 				<tr><td style="font-size:11px"> {filesize file="`$path_media`/`$media_files[media]->file_name`"} Kb, {date timestamp=$media_files[media]->created}, by <A href="{$url_file}page=cms.member.central&member_id={$media_files[media]->member_id}">{$media_files[media]->member_nick}</a>  </td></tr>
	  			 				<tr><td align="right"> [ <A href="{$url_file}page={$url_page}&match_id={$match->id}&media_id={$media_files[media]->id}&a=delete_media"><b>Delete</b></a> ] </td></tr>
	  			 			</table>
	  			 		</td>
	  			 	</tr>
	  			 {/section}
					
	  			</table>
	  	</td></tr>
	  </table>	
  		
	</td>
 
 </tr>
 <tr>
  <td colspan="2">
	  <br/><hr size="1"/>
	  <div align="left">
	  	<table>
	  	 <tr>
	  	 	{if $match->evaluated} <td>{include file="buttons/bt_universal.tpl" caption="zurücksetzen" link="javascript:document.location='`$url_file`&page=`$url_page`&match_id=`$match->id`&a=restore_evaluation';"}</td>{/if}
	  	 	{if !$match->evaluated} <td>{include file="buttons/bt_universal.tpl" caption="auswerten" link="javascript:document.location='`$url_file`&page=`$url_page`&match_id=`$match->id`&a=evaluate_match';"}</td>{/if}
	  	 </tr>
	  	</table>
	  </div> 
  
	  <br/><br/>
	  {section name=rep loop=$reports}
	  	<table border="0" cellpadding="5" cellspacing="0" width="100%" bgcolor="{#clr_content_border#}">
	  	 <tr>
	  	 	<td colspan="2" >Report of
	  	 	<b>
	  	 	
	  	 	{if $reports[rep]->participant_id == $challenger->participant_id }
		  	 	{if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		  	 		{$challenger->participant_clan_tag}:<i>{$challenger->participant_name}</i>
		 		{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		 			{$challenger->participant_name}
		 		{/if}
	  	 	{else if $reports[rep]->participant_id == $opponent->participant_id }
		  	 	{if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		  	 		{$opponent->participant_clan_tag}:<i>{$opponent->participant_name}</i>
		 		{else if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
		 			{$opponent->participant_name}
		 		{/if}
	  	 	{/if}
			</b>	 		
		 	by <A href="{$url_file}page=cms.member.central&member_id={$reports[rep]->member_id}">{$reports[rep]->member_nick}</a>
		 		
		 	</td>
	   	 </tr>
	   	 <tr bgcolor="{#clr_content#}">
	   	 	<td width="1%"> <img src="images/spacer.gif" width="5" height="1"> </td>
	   	 	<td>{$reports[rep]->text} </td>
	  	 </tr>
	   	</table>
	   {/section}
	   
   	
  </td>
 </tr>
 <tr>
 	<td colspan="2">
 	
		<br/><br/>
		
	 	
		<table border="0" width="100%" bgcolor="{#clr_content_border#}" cellpadding="3" cellspacing="0">
		 <tr>
		 	<td align="right"> <A href='{$url_file}page={$url_page}&match_id={$match->id}&comment=write#comment_write'> <b>Kommentare {#clip_start#}{$comment_count}{#clip_end#}</b> </a> </td> 
		 </tr>
		</table>
		
		{include file="etc/comment.show.tpl"}
		<br/>
		{* WRITE ? !! *}
		{include file="etc/comment.write.tpl"}
		 	
 	</td>
  </tr>
</table>

{/if}