<link rel="stylesheet" href="css/egl_design.css" type="text/css"/>

<table border="0" cellpadding="0" cellspacing="10" width="90%">
 <tr><td>

{include file="devs/message.tpl"}
{if $match}
<h2> Match Report</h2>

{if !$participants[0]->participant_id || !$participants[1]->participant_id }	
	Es steht noch keine Begegnung fest!
	
	
{else}
	{************************************************************************************}
	{****************      MATCH CURRENTLY NOT REPORTED ??              *****************}
	{************************************************************************************}
	{if $match->report_id == $smarty.const.EGL_NO_ID } 
	  
		<table border="0" cellpadding="2" cellspacing="5" width="100%" >
		 <tr>
		 {if $match->participant_type == $smarty.const.PARTTYPE_MEMBER }
		 	<td width="50%" align="right"> <h2>{$participants[0]->participant_name} </h2></td>
		 	<td width="1%" align="center" valign="bottom"> <font color="#A8000000"><h2>Vs.</h2> </td>
		 	<td width="50%" align="left"> <h2>{$participants[1]->participant_name} </h2></td>
	 	{elseif $match->participant_type == $smarty.const.PARTTYPE_TEAM }
		 	<td width="50%" align="right"> <h2>{$participants[0]->participant_clan_tag} {#arrow_db_right#} {$participants[0]->participant_name} </h2></td>
		 	<td width="1%" align="center" valign="bottom"> <font color="#A8000000"><h2>Vs.</h2> </td>
		 	<td width="50%" align="left">  <h2>{$participants[1]->participant_clan_tag} {#arrow_db_right#} {$participants[1]->participant_name} </h2></td>
	 	{/if}
		 </tr>
		 <tr>
		  	<td colspan="3" align="center" bgcolor="{#clr_content#}"><b>Ergebnisse</b></td>
		 </tr>
		 <tr>
		 	<td colspan="3"><br/><br/> </td></tr>
		 </tr>  
	
	  <form action="{$url_file}page={$url_page}&match_id={$match->id}&a=report" method="POST">
	  
		 {section name=map loop=$match_struct->num_maps}
		 <!--# DETAILED STRUCTURED #-->
		 {if ($match_struct->num_rounds > 1)  }
		 	<tr><td colspan="3">
		 	<!--# FIXED? #-->
		 	{if $match->fixed}
			 	<b>{$match_struct->aMaps[map]|strip_tags|stripslashes}</b>
			 	<input type="hidden" name="report_map_{$smarty.section.map.index}" value="{$match_struct->aMaps[map]|strip_tags|stripslashes}" />
		 	{else}
			 	{if $MAPS}
			 		<select name="report_map_{$smarty.section.map.index}" class="egl_select" style="width:200px;">

				 		{section name=mapname loop=$MAPS}
				 			<option {if $match_struct->aMaps[map] == $MAPS[mapname]->map_name}selected{/if} value="{$MAPS[mapname]->map_name|strip_tags|stripslashes}">{$MAPS[mapname]->map_name|strip_tags|stripslashes}</option>
				 		{/section}
				 		
			 		</select>
			 	{else}
			 		<input name="report_map_{$smarty.section.map.index}" type="text" class="egl_text" style="width:200px;" value="{$match_struct->aMaps[map]|strip_tags|stripslashes}"/> 
			 	{/if}
			 {/if}
			 
		 	</td></tr>
	 	 	{section name=rnd loop=$match_struct->aRoundNames}
			 <tr>
				<td align="right"> 
			 	 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
			 		 <tr>
			 		 	<td> <table border="0" cellpadding="0" cellspacing="0"> 
			 		 			<tr>
			 		 				<td width="1%"> <img src="images/spacer.gif" width="10" height="1"> </td>
			 		 				<td> {split_str str=$match_struct->aRoundNames[rnd] char="#" item="0"} </td>
			 		 			</tr>
			 		 		  </table>
			 		 	</td>
			 		 	<td width="1%"><input name="report_score_{$smarty.section.map.index}_round_{$smarty.section.rnd.index}_challenger" type="text" class="egl_text" size="2" value="0"/></td>
			 		 </tr>
			 		</table>
		 		</td>
			 	<td align="center"> : </td>
			 	<td>
			 	 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
			 		 <tr>
			 		 	<td width="1%"><input name="report_score_{$smarty.section.map.index}_round_{$smarty.section.rnd.index}_opponent" type="text" class="egl_text" size="2" value="0"/></td>
			 		 	<td> <table border="0" cellpadding="0" cellspacing="0"> 
			 		 			<tr>
			 		 				<td align="right"> {split_str str=$match_struct->aRoundNames[rnd] char="#" item="1"} </td>
			 		 				<td width="1%"> <img src="images/spacer.gif" width="10" height="1"> </td>
			 		 			</tr>
			 		 		  </table>
			 		 	</td>
			 		 </tr>
			 		</table>

			  </td> 		
			 </tr>
			{/section}
			
		 <!--# NOT DETAILED STRUCTURE, ONLY MAP-NAME #-->
		 {else}
		
			 <tr>
				<td align="right"> 
			 	 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
			 		 <tr>
			 		 	<td> <input name="report_map_{$smarty.section.map.index}" type="text" class="egl_text" size="15" value="{$match_struct->aMaps[map]}"/>	</td>
			 		 	<td width="1%"><input name="report_score_{$smarty.section.map.index}_round_0_challenger" type="text" class="egl_text" size="2" value="0"/></td>
			 		 </tr>
			 		</table>
		 			</td>
			 	<td align="center"> : </td>
			 	<td align="left"> <input name="report_score_{$smarty.section.map.index}_round_0_opponent" type="text" class="egl_text" size="2" value="0"/> </td>
			  </tr>
		
		{/if}	 
		{/section}
		</table>
		
		<br/>
	
		<table border="0" cellpadding="0" cellspacing="0">
		 <tr>
		  <td> <b>Bewertung:</b></td>
		 </tr>
		 <tr>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="n2"/> Sehr schlecht </td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="n1"/> Schlecht</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="0" checked /> Neutral</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="1"/> Gut</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="2"/> Sehr gut</td>
		 </tr>
		</table>
			
		<br/>
		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		 <tr>
		  <td> <b>Match-Report:</b></td>
		 </tr>
		 <tr>
		 	<td> <textarea name="report_text" class="egl_textbox" style="width:100%;" rows="5"></textarea> </td>
		 </tr>
		 <tr>
		 	<td> <input type="submit" value="abschicken" class="egl_button"/></td>
		 </tr>
		</table>
		
		</form>
		
		
		
	 {else}
	 {**************************************************************************************************}
	 {************************  MATCH ALREADY REPORTED ?  **********************************************}
	 {**************************************************************************************************}
	
		Für das Match wurde bereits folgender Report eingetragen !
		
		<br/><br/>
	
		<form action="{$url_file}page={$url_page}&match_id={$match->id}&a=report" method="POST">
	
		<table border="0" cellpadding="5" cellspacing="5" width="100%" >
		 {if $parttype == 'member'}
		 	<td width="50%" align="right"> <h2>{$participants[0]->participant_name} </h2></td>
		 	<td width="1%" align="center" valign="bottom"> <font color="#A8000000"><h2>Vs.</h2> </td>
		 	<td width="50%" align="left"> <h2>{$participants[1]->participant_name} </h2></td>
	 	{elseif $parttype == 'team'}
		 	<td width="50%" align="right"> <h2>{$participants[0]->participant_clan_tag} {#arrow_db_right#} {$participants[0]->participant_name} </h2></td>
		 	<td width="1%" align="center" valign="bottom"> <font color="#A8000000"><h2>Vs.</h2> </td>
		 	<td width="50%" align="left">  <h2>{$participants[1]->participant_clan_tag} {#arrow_db_right#} {$participants[1]->participant_name} </h2></td>
	 	{/if}
		 <tr>
		 	<td colspan="3">  
		
				  <table border="0" cellpadding="2" cellspacing="0" width="100%">
				  <tr>
				  	<td colspan="3" align="center" bgcolor="{#clr_content#}"><b>Ergebnisse</b></td>
				  </tr>
				  <tr>
				  	<td width="50%"> </td>
				  	<td width="1%"> </td>
				  	<td width="50%"> </td>
				  </tr>
	
					{section name=map_res loop=$match_result->aMapResults}

						<!--####### DETAILED ROUNDS? #####-->
						{if $display_detailed_rounds }
						
		  					<tr><td colspan="3"><b> {$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes} </b></td></tr>
							{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
		  					 <tr>
				  			 	<td align="right">	
				  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
		  								<td width="1%"><img src="images/spacer.gif" width="10" height="1"></td>
		  								<td align="left">{split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name char="#" item="0"}</td>
		  					 			<td width="1%" align="left">{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score}</td>
				  			 		 </tr></table>
				  			 	 </td>
		  						<td align="center"><b>:</b></td>
					  			<td align="left">
				  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
		  					 			<td width="1%" align="left">{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score}</td>
		  								<td align="right">{split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name char="#" item="1"}</td>
				  			 		 </tr></table>
					  			</td>
		  					 </tr>
							{/section}
		
						{else}
						
						
							{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
		  					 <tr>
				  			 	<td align="right">	
				  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
		  								<td align="left"> {$match_result->aMapResults[map_res]->map_name|strip_tags|stripslashes} </td>
		  					 			<td width="1%" align="right"> <b>
		  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->challenger_score} 
		  					 			</b></td>
				  			 		 </tr></table>
				  			 	 </td>
		  						<td align="center"><b>:</b> </td>
					  			<td align="left"><b>
										{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content=$match_result->aMapResults[map_res]->aRounds[rnd]->opponent_score} 
						  		</b></td>
		  					 </tr>
							{/section}
						{/if} 
	  			 
					{/section}
	  			  
					<tr><td colspan="3"> <br/><br/> </td></tr>
					<tr>
	  			 		<td align="right">	
	  			 			<table border="0" width="100%" cellpadding="0" cellspacing="0">
	  			 			 <tr>
	  			 			 	<td align="left"><b>Total</b>  </td>
	  			 			 	<td width="1%" align="right">
		 					 		{if $match_result->bchallenger_win}
		 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content=$match_result->total_challenger_score}
		 					 		{elseif $match_result->bopponent_win}
		 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content=$match_result->total_challenger_score}
		 					 		{else}
		 					 			{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content=$match_result->total_challenger_score}
					 		 		{/if}
	  			 			 	</td>
	  			 			 </tr>
	  			 			</table>
	  			 		 	</td>
	  			 		<td align="center"><b>:</b></td>
		 		 		<td align="left">
			 		 		{if $match_result->bopponent_win}
				 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_green# content=$match_result->total_opponent_score}
			 		 		{elseif $match_result->bchallenger_win}
				 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# font_color=#clr_rank_red# content=$match_result->total_opponent_score}
			 		 		{else}
				 		 		{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content=$match_result->total_opponent_score}
			 		 		{/if}
	 		 			</td>
	  			    </tr>
	
	  			    </table>			 	
		 	
		 	</td>
		 </tr> 
		 <tr>
		 {if $parttype == 'member'}
		 	<td colspan="3" align="center">   	<i>Der Matchreport wurde von <b><u>{$match_reporter->participant_name}</b></u> eingetragen !</i>   </td>
		 {elseif $parttype == 'team'}
		 	<td colspan="3" align="center">   	<i>Der Matchreport wurde von <b><u>{$match_reporter->participant_clan_tag} {#arrow_db_right#} {$match_reporter->participant_name}</b></u> eingetragen !</i>   </td>
		 {/if}
		 </tr>
		</table>
	
		
	 	
	 	
	 	{* ONLY SHOW IF THE REPORT IS NOT MINE *}
	 	{if !$my_match_report && !$match_reported }
	
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
	 	 <tr>
	 	  <td> <b>Ergebnis:</b> </td>
	 	 </tr>
	 	 <tr>
	 	 	<td>
	 	 		<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#000000">
	 	 		 <tr>
			 	  <td bgcolor="{#clr_rank_green#}" width="50%">  <input name="report_state" type="radio" class="egl_radio" value="accept"/> <font color="#000000"><b> Akzeptieren </b></font> </td>
			 	  <td bgcolor="{#clr_rank_red#}"> <input name="report_state" type="radio" class="egl_radio" value="deny"/> <font color="#000000"> <b>Ablehnen</b></font> </td>
			 	 </tr>
			 	</table>
			</td>
	 	 </tr>
	 	 <tr>
	 	  	<td> <br/>
	 	  	<b><font color="#A80000">ACHTUNG:</b> Dieses Feld <u>nur</u> als Info-Text bei einer Ablehnung verwenden.</font>
	 	  		<textarea class="egl_textbox" name="protest_text" style="width:100%;border-color:A80000;" rows="5" ></textarea>
	 	  	</td>
	 	 </tr>
	 	</table>
	 	
	 
	 
		<br/>
		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		 <tr>
		  <td colspan="5"> <b>Bewertung:</b></td>
		 </tr>
		 <tr>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="n2"/> Sehr schlecht </td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="n1"/> Schlecht</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="0" checked /> Neutral</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="1"/> Gut</td>
		 	<td> <input name="report_rating" type="radio" class="egl_radio" value="2"/> Sehr gut</td>
		 </tr>
		</table>
			
		<br/>
		 	
	 	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		 <tr>
		  <td> <b>Match-Report:</b></td>
		 </tr>
		 <tr>
		 	<td> <textarea name="report_text" style="width:100%;" rows="5"></textarea> </td>
		 </tr>
		 <tr>
		 	<td> <input type="submit" value="abschicken" class="egl_button"/></td>
		 </tr>
		 </table> 	
		 
		 {/if}
		</form>
	 {/if}
		
	<br/>
	<hr size="1"/>
	<br/><br/>
	
	<b>Media-Datei Hochladen:</b>
	<form action="{$url_file}page={$url_page}&match_id={$match->id}&a=media" method="POST" enctype="multipart/form-data">
	 <input type="hidden" name="media_num_uploads" value="{$num_media_files}" />
	 <table border="0" cellpadding="0" cellspacing="5">
	  <tr>
	  	<td width="1%"></td>
	  	<td><b>Name:</b></td>
	  	<td><b></b></td>
	  </tr>
	  	{section name=file loop=$num_media_files}
		  <tr>
		  	<td><i>{$smarty.section.file.index+1}.</i> </td>
		  	<td><input name="media_file_{$smarty.section.file.index}_name" 	class="egl_text" type="text" /> </td>
		  	<td width="1%" align="center"> - </td>
		  	<td><input name="media_file_{$smarty.section.file.index}" 		class="egl_file" type="file" /> </td>
		  </tr>
		{/section}
	  <tr>
	  	<td colspan="3"><br/><input class="egl_button" type="submit" name="submit" value="Hochladen" /> </td>
	  </tr>
	 </table> 
	</form> 

	{/if}
	
{/if}



  </td>
  <tr>
 	<td align="center"> <br><a href="JavaScript:history.back(1)"><b>Zur&uuml;ck</b></a> </td>
  </tr>
 </tr>
</table>