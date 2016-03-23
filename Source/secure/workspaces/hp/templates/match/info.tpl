{include file="devs/message.tpl"}
{if $match}

{*
Description:
------------------------
$challenger	=> challenger
$opponent	=> opponent

*}

<br>

<table border="0" cellpadding="2" cellspacing="0" align="center" width="100%">
 <tr>
 	<td colspan="2" align="center"> 
 		<h2>
 		{if $match->participant_type == $smarty.const.PARTTYPE_TEAM}
 			{if $challenger->participant_clan_id != $smarty.const.EGL_NO_ID}<i>{$challenger->participant_clan_name|strip_tags|stripslashes}</i> {#arrow_db_right#}{/if} {$challenger->participant_name|strip_tags|stripslashes} <br>
 			<font color="{#clr_rank_red#}"><b> {$LNG_BASIC.c8411} </b></font> <br>
	 		{if $opponent->participant_clan_id != $smarty.const.EGL_NO_ID} <i>{$opponent->participant_clan_name|strip_tags|stripslashes}</i> {#arrow_db_right#} {/if}{$opponent->participant_name|strip_tags|stripslashes} 
		{else}
			{$challenger->participant_name|strip_tags|stripslashes}
			<font color="{#clr_rank_red#}"><b> {$LNG_BASIC.c8411} </b> </font>
			{$opponent->participant_name|strip_tags|stripslashes}
		
		 {/if}
		 </h2>
	  	
	 </td>
 </tr>
 <tr>
 	<td colspan="2">{include file="devs/hr_black.tpl" width="100%"}</td>
 </tr>
 <tr>
  	<td valign="top" width="50%" >
  	
  		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
  		 <tr><td align="center"><b>{$LNG_BASIC.c8400}</b></td></tr>
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
					  					<img src="{$path_logos}/teams/{$challenger->participant_logo_file}" width="100" height="100">  
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
	 			  		   	<br/><b>
							{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
		 						<A class="href_orange" href="{$url_file}page=member.info&member_id={$challenger->participant_id}">	{$challenger->participant_name|strip_tags|stripslashes} </a>
		 					{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		 						{if $challenger->participant_clan_id != $smarty.const.EGL_NO_ID} <a href="{$url_file}page=clan.info&clan_id={$challenger->participant_clan_id}">{$challenger->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}
		 						<A class="href_orange" href="{$url_file}page=team.info&clan_id={$challenger->participant_clan_id}&team_id={$challenger->participant_id}" title="{$challenger->participant_name|strip_tags|stripslashes}">{cutstr num=10 text=$challenger->participant_name|strip_tags|stripslashes} </a>
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
		  		   		<br>
		  		   		
  			  		 	<b>
	 					{if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
	 						<A class="href_orange" href="{$url_file}page=member.info&member_id={$opponent->participant_id}">	{$opponent->participant_name|strip_tags|stripslashes} </a>
	 					{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	 						{if $opponent->participant_clan_id != $smarty.const.EGL_NO_ID} <a href="{$url_file}page=clan.info&clan_id={$opponent->participant_clan_id}">{$opponent->participant_clan_tag|strip_tags|stripslashes}</a> {#arrow_db_right#} {/if}
	 						<A class="href_orange" href="{$url_file}page=team.info&clan_id={$opponent->participant_clan_id}&team_id={$opponent->participant_id}" title="{$opponent->participant_name|strip_tags|stripslashes}">{cutstr num=10 text=$opponent->participant_name|strip_tags|stripslashes} </a>
					 	{/if}
  			  		 		</b>
  			  		 		</td>
  			  		 </tr>
  			  		</table> 
  			  	
  			  		</td>
  			 </tr>
  		    <tr>
  			   	<td colspan="4" align="center">
  			   	 <br><br> <b>
  			   	 {if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		    		{if $match->winner_id == $challenger->participant_id} <i>`{if $challenger->participant_clan_id != $smarty.const.EGL_NO_ID}{$challenger->participant_clan_tag|strip_tags|stripslashes} {#arrow_db_right#} {/if}<u>{$challenger->participant_name|strip_tags|stripslashes}</u>` {$LNG_BASIC.c8412} </i>{/if}
		    		{if $match->winner_id == $opponent->participant_id} <i>`{if $opponent->participant_clan_id != $smarty.const.EGL_NO_ID}{$opponent->participant_clan_tag|strip_tags|stripslashes} {#arrow_db_right#} {/if}<u>{$opponent->participant_name|strip_tags|stripslashes}</u>` {$LNG_BASIC.c8412} </i>{/if}
		    		{if $match->winner_id == $smarty.const.EGL_NO_ID && $match->evaluated}{$LNG_BASIC.c8414}{/if}
  			   	 {else}
		    		{if $match->winner_id == $challenger->participant_id} <i>`{$challenger->participant_name|strip_tags|stripslashes}` {$LNG_BASIC.c8412} </i>{/if}
		    		{if $match->winner_id == $opponent->participant_id} <i>`{$opponent->participant_name|strip_tags|stripslashes}` {$LNG_BASIC.c8412} </i>{/if}
		    		{if $match->winner_id == $smarty.const.EGL_NO_ID && $match->evaluated}{$LNG_BASIC.c8414}{/if}
		    	{/if}
		    	</b>
		    	<br><br><br>
		    	</td>  			    
		    </tr>
  		</table>
  		
  		
  	</td></tr>
  	</table>	
  			
  		
  	</td>
  	<td valign="top" align="center">
  	
			<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
			  <tr>
			  	<td align="center" ><b>{$LNG_BASIC.c8415}</b></td>
			  </tr>
			  <tr>
			  	<td bgcolor="{#clr_content#}">
			  		
		 			<table border="0" cellpadding="4" cellspacing="0" width="100%">
		  			 <tr>
		  			  	<td><b>{$LNG_BASIC.c8401}:</td>
		  			  	<td>{$match->id}</td>
		  			 </tr>
		  			 <tr>
		  			  	<td> <b> {$LNG_BASIC.c8402}: </td>
		  			  	{if $match->status == $smarty.const.MATCH_RUNNING}<td>{$LNG_BASIC.c8406}</td>{/if}
		  			  	{if $match->status == $smarty.const.MATCH_LOCKED}<td>{$LNG_BASIC.c8416}</td>{/if}
		  			  	{if $match->status == $smarty.const.MATCH_CLOSED}<td>{$LNG_BASIC.c8405}</td>{/if}
		  			  	{if $match->status == $smarty.const.MATCH_REPORTED}<td>{$LNG_BASIC.c8417}</td>{/if}
		  			 </tr>
		  			 <tr>
		  			  	<td><b>{$LNG_BASIC.c8403}:</td>
		  			  	<td>{date timestamp=$match->challenge_time}</td>
		  			 </tr>
		  			 <tr>
		  			  	<td><b>{$LNG_BASIC.c8404}:</b></td>
		  			  	{if $match->evaluate_time}
		  			  		<td>{date timestamp=$match->evaluate_time}</td>
		  			  	{else}
		  			  		<td>{$LNG_BASIC.c8418}</td>
		  			  	{/if}
		  			 </tr>
		  			</table>  
			  			
			  	</td></tr>
			  </table>
	  	 
	  	 
	  	 
  	</td>
 </tr>
 <tr>
	<td valign="top">
	
		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
		  <tr>
		  	<td align="center"><b>{$LNG_BASIC.c8407}</b></td>
		  </tr>
		  <tr>
		  	<td bgcolor="{#clr_content#}">
	
			  <table border="0" cellpadding="2" cellspacing="0" width="100%">
			  <tr>
			  	<td width="50%"> </td>
			  	<td width="1%"> </td>
			  	<td> </td>
			  </tr>

				{section name=map_res loop=$match_result->aMapResults}
				
					{* CHECK: Haben die Runden einen bestimmten Namen ?*}
					
					{if $display_detailed_rounds }
	  					 <tr><td colspan="3"><b> {$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes} </b></td></tr>
						{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
	  								<td width="1%"><img src="images/spacer.gif" width="10" height="1"></td>
	  								<td align="left"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name|strip_tags char="#" item="0"} </td>
	  					 			<td width="1%" align="left"> <b>
	  					 				{if $match->evaluated}
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score} 
	  					 				{else}
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="-"} 
	  					 				{/if}
	  					 			</b></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b></td>
				  			<td align="left"><b>
				 				{if $match->evaluated}
									{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score} 
					  			{else} 
					  				{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="-"}  
					  			{/if}
				  			</b></td>
	  						<td align="right"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name char="#" item="1"} </td>
	  					 </tr>
						{/section}
	
					{else}
					
					
						{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
	  								<td align="left"> <b>{$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes}</b> </td>
	  					 			<td width="1%" align="right"> <b>
	  					 				{if $match->evaluated}
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score} 
	  					 				{else}
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="-"} 
	  					 				{/if}
	  					 			</b></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b> </td>
				  			<td align="left"><b>
				 				{if $match->evaluated}
									{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score} 
					  			{else} 
					  				{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="-"}  
					  			{/if}
					  		</b></td>
					  		<td></td>
	  					 </tr>
						{/section}
					{/if} 
  			 
				{/section}
				
				<tr><td colspan="4"> {include file="devs/hr_black.tpl" width="100%"}</td></tr>
				<tr>
  			 		<td align="right">	
  			 			<table border="0" width="100%" cellpadding="0" cellspacing="0">
  			 			 <tr>
  			 			 	<td align="left"><b>{$LNG_BASIC.c8408}</b></td>
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
  			 			 	<td align="left"><b>{$LNG_BASIC.c8409}</b></td>
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
	
		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
		  <tr>
		  	<td align="center" ><b>{$LNG_BASIC.c8410}</b></td>
		  </tr>
	  	<tr><td bgcolor="{#clr_content#}">
	  			<table border="0" cellpadding="2" cellspacing="0" width="100%">
	  			 {section name=media loop=$media_files}
	  			 	<tr>
	  			 		<td width="1%"> <img src="images/file_format/{file_extension file=$media_files[media]->file_name}.gif"></td>
	  			 		<td> <A target="_blank" href="files/media_pool/{$media_files[media]->file_name}"> <b>{$media_files[media]->name|strip_tags|stripslashes}</b> </a> <br> 
	  			 			<table cellpadding="0" cellspacing="0">
	  			 				<tr><td style="font-size:11px"><i> {filesize file="`$path_media`/`$media_files[media]->file_name`"} {$LNG_BASIC.c9900}, {date timestamp=$media_files[media]->created}, {$LNG_BASIC.c8419} <a href="{$url_file}page=member.info&member_id={$media_files[media]->member_id}">{$media_files[media]->member_nick|strip_tags|stripslashes}</a> </i> </td></tr>
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
  <br><br>
  
  
  {section name=rep loop=$reports}
  	<table border="0" cellpadding="5" cellspacing="0" width="100%" bgcolor="{#clr_content_border#}">
  	 <tr>
  	 	<td colspan="2" >{$LNG_BASIC.c8420}
  	 	{if $reports[rep]->participant_id == $challenger->participant_id }
	  	 	{if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	  	 		{$challenger->participant_clan_tag|strip_tags|stripslashes}:<i>{$challenger->participant_name|strip_tags|stripslashes}</i>
	 		{else if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	 			{$challenger->participant_name|strip_tags|stripslashes}
	 		{/if}
  	 	{else if $reports[rep]->participant_id == $opponent->participant_id }
	  	 	{if $match->participant_type == $smarty.const.PARTTYPE_TEAM }
	  	 		{$opponent->participant_clan_tag|strip_tags|stripslashes}:<i>{$opponent->participant_name|strip_tags|stripslashes}</i>
	 		{else if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
	 			{$opponent->participant_name|strip_tags|stripslashes}
	 		{/if}
  	 	{/if}
	 	{$LNG_BASIC.c8419} <a href="{$url_file}page=member.info&member_id={$reports[rep]->member_id}">{$reports[rep]->member_nick|strip_tags|stripslashes}</a>
	 		
	 	</td>
   	 </tr>
   	 <tr bgcolor="{#clr_content#}">
   	 	<td width="1%"> <img src="images/spacer.gif" width="5" height="1"> </td>
   	 	<td>{$reports[rep]->text|strip_tags|nl2br} </td>
  	 </tr>
   	</table>
   {/section}
   
   	
  </td>
 </tr>
</table>

	<br><br>
	<table border="0" width="100%" bgcolor="{#clr_content#}" cellpadding="3" cellspacing="0">
	 <tr>
	 	<td align="right"> <a href='{$url_file}page={$url_page}&match_id={$match->id}&comment=write#comment_write'><b>{$LNG_BASIC.c4203} {#clip_start#}{$comment_count}{#clip_end#}</b> </a> </td> 
	 </tr>
	</table>
	
	{include file="etc/comment.show.tpl"}
	<br/>
	{include file="etc/comment.write.tpl"}


{/if}