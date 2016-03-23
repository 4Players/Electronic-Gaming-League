		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%">
		  <tr>
		  	<td align="center" ><b>Ergebnisse</b></td>
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
						{if strlen($match_result->aMapResults[map_res]->map_name) > 0} <tr><td colspan="3"><b> {$match_result->aMapResults[map_res]->map_name|strip_tags} </b></td></tr>{/if}
						{if strlen($match_result->aMapResults[map_res]->map_name) == 0} <tr><td colspan="3"><i> Variable Map</i></td></tr>{/if}
						{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
	  								<td width="1%"><img src="images/spacer.gif" width="10" height="1"></td>
	  								<td align="left"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name|strip_tags char="#" item="0"} </td>
	  					 			<td width="1%" align="left"> <b>
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="-"} 
	  					 			</b></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b></td>
				  			<td align="left"><b>
					  				{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="-"}  
				  			</b></td>
	  						<td align="right"> {split_str str=$match_result->aMapResults[map_res]->aRounds[rnd]->round_name char="#" item="1"} </td>
	  					 </tr>
						{/section}
	
					{else}
					
					
						{section name=rnd loop=$match_result->aMapResults[map_res]->aRounds}
	  					 <tr>
			  			 	<td align="right">	
			  					<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
			  					{if strlen($match_result->aMapResults[map_res]->map_name) > 0}<td align="left"> <b>{$match_result->aMapResults[map_res]->map_name|strip_tags}</b> </td>{/if}
			  					{if strlen($match_result->aMapResults[map_res]->map_name) == 0}<td align="left"> <i>Variable Map</i> </td>{/if}
	  					 			<td width="1%" align="right"> <b>
	  					 					{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="-"} 
	  					 			</b></td>
			  			 		 </tr></table>
			  			 	 </td>
	  						<td align="center"><b>:</b> </td>
				  			<td align="left"><b>
					  				{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="-"}  
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
  			 			 	<td align="left"><b>Total</b>  </td>
  			 			 	<td width="1%" align="right">
								{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>-</b>"}    			 			 	
  			 			 	</td>
  			 			 </tr>
  			 			</table>
  			 		 	</td>
  			 		<td align="center"><b>:</b></td>
	 		 		<td align="left">
						{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>-</b>"}  
 		 			</td>
  			    </tr>
				<tr>
  			 		<td align="right">	
  			 			<table border="0" width="100%" cellpadding="0" cellspacing="0">
  			 			 <tr>
  			 			 	<td align="left"><b>Punkte</b>  </td>
  			 			 	<td width="1%" align="right"><b>
								{include file="devs/box.tpl" align="right" border_width="4" width="30" color=#clr_content_rel# content="<b>?</b>"}  
  			 			 	</b></td>
  			 			 </tr>
  			 			</table>
  			 		 	</td>
  			 		<td align="center"><b>:</b></td>
	 		 		<td align="left"><b>
						{include file="devs/box.tpl" align="left" border_width="4" width="30" color=#clr_content_rel# content="<b>?</b>"}  
	 		 		</b></td>
  			    </tr>
  			    </table>	
  			    
  		</td></tr>
  	 </table>	
  			    