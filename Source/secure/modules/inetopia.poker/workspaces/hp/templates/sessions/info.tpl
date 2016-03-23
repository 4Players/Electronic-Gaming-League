	<script type="text/javascript">
	{literal}
		function __getaddress(){
			{/literal}
			return "{if strlen($session->street)>0}{$session->street}, {/if}{$session->plz} {$session->city}";
			{literal}
		}
		function __details(){
		{/literal}
			return "{$session->tables} Tische mit {$session->max_players} Plätzen";
		{literal}
		}
	{/literal}


	{if $ROOT_URL == "localhost"}
		{assign var="googlemap_key" value="ABQIAAAACU9p17i1ZWdwQo3L2Zj93BT2yXp_ZAY8_ufC3CFXhHIE1NvwkxSfh4Ih90ksNrAFE3q--9_lHGBzFQ"}
	{else}
		{assign var="googlemap_key" value="ABQIAAAACU9p17i1ZWdwQo3L2Zj93BS-nREOrAUX8o6PAEtG12-vDfmlshSJzN9ttlsc5mp04mutJ8Ew0t1QWA"}
	{/if}
	
	</script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key={$googlemap_key}"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

	var map = null;
	var geocoder = null; 
	var main_point=null;
    
    {literal}
    
    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());        
        geocoder = new GClientGeocoder();
        var address=__getaddress();
	    
		showAddress( address );
     }
   }
   

    function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
              map.setCenter(point, 14);
              var marker = new GMarker(point);
              map.addOverlay(marker);
			  /*marker.openInfoWindowHtml(address+"<br/>"+__details());*/
            }
            }
        );
      }
    }

   {/literal}
   //]]>
   </script>
   
<table height="82" width="100%" cellpadding="5" cellpading="0" background="images/modules/inetopia_poker/info_header_bg.gif">
 <tr>
 	<td align="center" width="33%"
 		><a href=""><font style="font-size:15px;color:#FFFFFF;font-weight:bold;">Übersicht</font></a></td>
 	<td align="center" width="33%"
 		><a href=""><font style="font-size:15px;color:#FFFFFF;font-weight:bold;">Karte</font></a></td>
 	<td align="center" width="33%"
 		><a href=""><font style="font-size:15px;color:#FFFFFF;font-weight:bold;">Forum</font></a></td>
 	
 </tr>
</table>

 

	<!--#
 	{if $session->organiser_id}
	 	Öffenliche Veranstaltung von <A href="{$url_file}page=organiser.info&organiser_id={$session->organiser_id}">{$session->organiser_name}</a><br/>
 	{else}
 		Private Veranstaltung von <A href="{$url_file}page=member.info&member_id={$session->member_id}">{$session->member_nickname}</a> <br/>
	{/if}
	#-->
 	
<fieldset style="border: 2px solid #696C75;">
	<legend>
		<label for="checkbox_htmlword_data"><b>DETAILS</b></label>

	</legend>
	<table cellpadding="5">
	 <tr>
	 	<td>Termin am:</td>
	 	<td>{date}</td>
	 </tr>
	 <tr>
		<td>Entfernung:</td>
		<td>50 Km entfernt ca. 30 Minute mit dem Auto</td>
	 </tr>
	 </table>
</fieldset>
<br/>
<fieldset style="border: 2px solid #696C75;">
	<legend>
		<label for="checkbox_htmlword_data"><b>Eingetragene Spieler</b> ({$session_participants|@count})</label>
		
		<table><tr><td>
		 	{section name=part loop=$session_participants}
		 		<a href="{$url_file}page=member.info&member_id={$session_participants[part]->id}">{$session_participants[part]->nick_name|strip_tags|stripslashes}</a>
		 	{/section}
		 </td></tr>
		</table>

	</legend>
</fieldset>

<div align="right" style="padding:10px;">
 	{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Jetzt teilnehmen" link="javascript:document.location.href='`$url_file`page=`$CURRENT_MODULE_ID`:sessions.join&session_id=`$session->session_id`';"}
</div>    
 
<table bgcolor="#696C75" cellpadding="5" cellspacing="0" width="100%">
	<tr><td><font color="#FFFFFF"><b>{$session->plz} {$session->city}</b>{if strlen($session->street)>0}<br/>{$session->street}{/if}</font></td></tr>
	<tr><td><div id="map" style="width: 100%; height: 300px"></div></td></tr>
</table>

 
