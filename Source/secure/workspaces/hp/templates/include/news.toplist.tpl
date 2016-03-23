						 	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="">
							 	{section name=tn_sec loop=$top_news}
							 	
					 		 	{if $top_news[tn_sec]->btoday}
							 	<tr>
					 		 		<td>
									 	<table border="0" cellpadding="0" cellspacing="0" width="100%" background="images/eglbeta/button_topnews_red.gif" style="background-repeat:no-repeat;">
									 	 <tr>
									 	 	<td width="1%"><img src="images/spacer.gif" width="70" height="32"/></td>
									 	 	<td><font color="#FFFFFF"><b>Heute, {$top_news[tn_sec]->day}.{$top_news[tn_sec]->month}. </b></font></td>
									 	 </tr>
									 	</table>
					 		 		</td>
							 	</tr>
							 	{elseif $top_news[tn_sec]->byesterday}
							 	<tr>
					 		 		<td>
									 	<table border="0" cellpadding="0" cellspacing="0" width="100%" background="images/eglbeta/button_topnews.gif" style="background-repeat:no-repeat;">
									 	 <tr>
									 	 	<td width="1%"><img src="images/spacer.gif" width="70" height="32"/></td>
									 	 	<td><font color="#F0BABA"><b>Gestern, {$top_news[tn_sec]->day}.{$top_news[tn_sec]->month}. </b></font></td>
									 	 </tr>
									 	</table>
					 		 		</td>
							 	</tr>
					 		 	{else}
							 	<tr>
					 		 		<td>
									 	<table border="0" cellpadding="0" cellspacing="0" width="100%" background="images/eglbeta/button_topnews.gif" style="background-repeat:no-repeat;">
									 	 <tr>
									 	 	<td width="1%"><img src="images/spacer.gif" width="70" height="32"/></td>
									 	 	<td><font color="#F0F0F0"><b> {weekday day=$top_news[tn_sec]->weekday}, {$top_news[tn_sec]->day}.{$top_news[tn_sec]->month}. </b></font></td>
									 	 </tr>
									 	</table>
					 		 		</td>
							 	</tr>
					 		 	
					 		 	{/if}
							 	</tr>
							 	{section name=tn loop=$top_news[tn_sec]->news}
								<tr>
									<td> <table border="0">
											<tr><td> <A href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:news.show&news_id={$top_news[tn_sec]->news[tn]->id}" class="top_news"><b>{cutstr num=100 text=$top_news[tn_sec]->news[tn]->title|htmlspecialchars|stripslashes}</b></a> </td></tr>
											<tr><td> <font color="#FFFFFF">{$top_news[tn_sec]->news[tn]->subject} </font> <a href="{$url_file}page={module_getid cname='INETOPIA_NEWS'}:news.show&news_id={$top_news[tn_sec]->news[tn]->id}"><font color="#D0D0D0"><b>Mehr...</b></font></a></td></tr>
										</table>	
									</td>
								</tr> 		
								{if !$smarty.section.tn.last }
									<td><img src="images/spacer.gif" height="3"></td></tr>
								 {/if}
								{/section}
						 	{/section}
						 	</table>