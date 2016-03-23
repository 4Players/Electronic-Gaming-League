<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ class ] -
class ManagedCronsServerTimer
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronsServerTimer( &$pDBCon )
	{
		$this->pDBInterfaceCon = &$pDBCon;
		//DBTB::RegisterTB( '','', '' );
	}
	
	/**
	 * constructor
	 * 
	 * 
	 */
	function CheckTickCounter(){
		$cDBConfigs = new DBConfigs( $this->pDBInterfaceCon );
		$tick_cnt 	= (int)$cDBConfigs->GetConfig( 'managedcron_sever_ticks' );
		$last_tick 	= (int)$cDBConfigs->GetConfig( 'managedcron_sever_last_tick' );

		// erster tick => abbrehcen
		if( $last_tick == 0 ) return 0;
		
		$tick_time	= 60; //seconds
		$rel_time	= 10; // seconds
		
		$timediff = (EGL_TIME-$last_tick);
		
		// es ist mehr zeit als für 1 tick vergangen
			// noch im Rahmen der relativen mess-zeit?
		if( (($timediff-$rel_time)/$tick_time) > 1 )
		{
			// reset counter
			$curr_min 	= (int)strftime( '%M', EGL_TIME );
			$curr_tick 	= (60*24*31)+$curr_min; // 31 days
			$cDBConfigs->SetConfig( 'managedcron_sever_ticks', 		$curr_tick );
			$cDBConfigs->SetConfig( 'managedcron_sever_last_tick', 	EGL_TIME );
			
			$data = '';
			$data .= "\nTime: ".EGL_TIME;
			$data .= "\nLast-Tick; ".$last_tick;
			$data .= "\nDiff; ".$timediff;
			$data .= "\nRelative-Zeit; ".$rel_time;
			$data .= "\New-Tick-Cnt; ".$curr_tick;

						//echo "<br/>Zuvorgehender Tick!: ".(($timediff-$rel_time)/$tick_time);
			//@mail( 'bug-report@eglonline.de', 'ManagedCron-Server - Tick fehler', 'Es ist ein Problem aufgetreten. Der letzt Tick wurde nicht innerhalt der relativen Zeit ausgeführt.'."\n\n".$data );
			return 1;
		}
		else
		{
			$curr_min 	= (int)strftime( '%M', EGL_TIME );
		}
		return 0;
	}
	
	/**
	 * IncrementTicks
	 * 
	 * 
	 */	
	function IncrementTicks(){
		// update ticker
		$cDBConfigs = new DBConfigs( $this->pDBInterfaceCon );
		$tick_cnt = (int)$cDBConfigs->GetConfig( 'managedcron_sever_ticks' );
		$cDBConfigs->SetConfig( 'managedcron_sever_ticks', $tick_cnt+1 );

		// save last tick
		$cDBConfigs->SetConfig( 'managedcron_sever_last_tick', EGL_TIME );
		return ($tick_cnt+1);
	}
	
	
	/**
	 * ManagedCronsServerTimer::Run
	 * 
	 * 
	 */
	function RunTimer(){
		if( !$this->CheckTickCounter() )
		{
			$this->IncrementTicks();
		}
		
		// execute 
		$cDBConfigs = new DBConfigs( $this->pDBInterfaceCon );
		$current_tick = (int)$cDBConfigs->GetConfig( 'managedcron_sever_ticks' );
		$cMCServer = new ManagedCronsServer( $this->pDBInterfaceCon );
		$cMCServer->Update( $current_tick );
	}
	
};

?>