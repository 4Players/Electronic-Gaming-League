<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-
ifndef( "MANAGEDCRON_URI_SERVICE",		1 );
ifndef( "MANAGEDCRON_URI_DYNAMIC",		2 );


# -[ class ] -
class ManagedCronsServer
{
	# -[ variables ]-
	var $pDBInterfaceCon	= NULL;

	
	/**
	 * constructor
	 * 
	 * 
	 */
	function ManagedCronsServer( &$pDBCon )
	{	
		$this->pDBInterfaceCon = &$pDBCon;
		//DBTB::RegisterTB( '','', '' );
	}
	
	/**	
	 * start update
	 * 
	 */
	function Update( $current_tick )
	{
		$cBench = new Bench();	
		$cBench->start();
		$data_send='';
		
		if( !$this->pDBInterfaceCon ){
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't run ManagedCronServer-Update - no db-connection available" );
			return 0;
		}
		
		# step 1
		// list all registered managedcrons
			// get base/global member managedcron service-data (KEY for access)
			// execute each managed cron
		
		$sql_query = 	" SELECT *, mc_tasks.id AS task_id ".
						" FROM `egl_managedcrons_tasks` AS mc_tasks, `egl_managedcrons_user` AS mc_user ".
						" LEFT JOIN `egl_managedcrons` AS mc ".
						" ON mc.id=mc_tasks.mc_id ".
						" WHERE mc_user.member_id=mc_tasks.member_id";
						// left join member-service (to get access key for managed crons
		
		// try fetching cron-list
		$qre = $this->pDBInterfaceCon->Query( $sql_query );
		
		if( !$qre ){
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't create managedcrons list registered - ".$this->pDBInterfaceCon->GetLastError() );
			return 0;
		}else{
			$aCronTasks = $this->pDBInterfaceCon->FetchArrayObject( $qre );
		
			$data_send .= "\nTime-To-Loop: ".$cBench->runTime();
			
			// ----------------------------------------------------
			// update each cron
			// ----------------------------------------------------
			for( $c=0; $c < sizeof($aCronTasks); $c++ )
			{
				// check for update
				if( $current_tick % $aCronTasks[$c]->ticks != 0 )
					continue;	// zum nächsten task, falls nicht richtig :)
				
				//echo "<br>Bearbeite: CRON-".$aCronTasks[$c]->name;
				
				$key 			= $aCronTasks[$c]->remote_key;
				/*$ping_params	= array( 'send_time' 	=> microtime(),
										 'url'			=> PageNavigation::MyURL(),
 										);*/
				//$run_params		= array();
				
				// define service-url
				$service_url = 	$aCronTasks[$c]->url.
								'managedcrons.php'.
								'?page='.
								$aCronTasks[$c]->uri.
								'&key='.$key;

				$f = fopen( $service_url, 'r' );
				fclose($f);
				
				$this->TaskCall_Succeed( $aCronTasks[$c] );
				
				$data_send .= "\n -> Cron:".$aCronTasks[$c]->name.": ".$cBench->runTime();
				
				// check-URL
				// define soap-client
				/*$client = new soapclient( $service_url );
				$ping_result  = $client->call( 	'ping',  $ping_params );
				if( !$ping_params ){
					// error
					DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't ping ManagedCron-Service `{$service_url}`" );

					// call failed
					$this->TaskCall_Failed( $aCronTasks[$c] );
					
				}
				else
				{
					// execution successfuly
					$run_result = $client->call( 'run' );
					if( $client->fault ){
						
						// hier könnte man den fehler auswerten oder an eine andere Stadtion weiterleiten
						// noch nicht integriert
						
						
						// call failed
						$this->TaskCall_Failed( $aCronTasks[$c] );
					}
					else{
						if( !$run_result )
						{
							// fehler
							$this->TaskCall_Failed( $aCronTasks[$c] );
							
							// error
							DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't run ManagedCron-Service `{$service_url}`" );
						}
						else
						{
							// task erfolgreich ausgeführt
							$this->TaskCall_Succeed( $aCronTasks[$c] );
							//echo "success";
						}//if run
					}//if
					
				}//if ping*/
			}//for
		}
		
		//mail( 'bugreport@eglonline.de', 'test', $data_send );
		return 1;
	}
	

	/**	
	 * TaskCall_Failed
	 */
	function TaskCall_Failed( $task_obj ){

		if( $task_obj->calls_failed > 10 ){
			// send mail
			// unregister task
			$this->UnregisterTask( $task_obj->task_id ); 
			// send mail to member
		}//if
		else{
			$update_obj = array( 	'calls_failed'	=> ($task_obj->calls_failed+1),
									'last_call'		=> time(),
								);
			$this->UpdateTaskCall( $update_obj, $task_obj->task_id );
		}//if
		return 1;
	}

	/**	
	 * TaskCall_Succeed
	 */
	function TaskCall_Succeed( $task_obj ){

		$update_obj = array( 	'calls_failed'	=>  0,
								'calls'			=>	($task_obj->calls+1),
								'last_call'		=>  time(),
							);
		return $this->UpdateTaskCall( $update_obj, $task_obj->task_id );
	}
	
		
	/**	
	 * UpdateTaskCall
	 */
	function UpdateTaskCall( $obj, $task_id ){
		$sql_query = 	$this->pDBInterfaceCon->CreateUpdateQuery( 'egl_managedcrons_tasks', $obj ).
						" WHERE id=".(int)$task_id;
		return $this->pDBInterfaceCon->Query( $sql_query );		
	}
	
	/**	
	 * RegisterService
	 */
	function RegisterTask( $obj ){
		return $this->pDBInterfaceCon->Query( $this->pDBInterfaceCon->CreateInsertQuery( 'egl_managedcrons_tasks', $obj ) );
	}
	
	/**
	 * UnRegisterService
	 */
	function UnregisterTask( $task_id ){
		$sql_query = "DELETE FROM `egl_managedcrons_tasks` WHERE id=".(int)$task_id." ";
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
	
	
	/**
	 * GetService
	 */
	function GetServiceByKey( $key )
	{
		$sql_query =	" SELECT * ".
						" FROM `egl_managedcrons_user` AS mc_user ".
						" WHERE mc_user.remote_key='".$this->pDBInterfaceCon->EscapeString($key)."'";
		return  $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * GetRegisteredManagedCronsFromUser
	 */
	function GetTasksByMemberId( $member_id )
	{
		$sql_query =	" SELECT * ".
						" FROM `egl_managedcrons` AS mc ".
						" LEFT JOIN `egl_managedcrons_tasks` AS mc_tasks ".
						" ON mc_tasks.mc_id=mc.id && mc_tasks.member_id=".(int)$member_id." ".
						" ORDER BY mc.name ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	/**
	 * GetTask
	 */
	function GetTask( $member_id, $managedcron_id )
	{
		$sql_query =	" SELECT * ".
						" FROM `egl_managedcrons` AS mc ".
						" LEFT JOIN `egl_managedcrons_tasks` AS mc_tasks ".
						" ON mc_tasks.mc_id=mc.id && mc_tasks.member_id=".(int)$member_id." ".
						" WHERE mc.managedcron_id=".$this->pDBInterfaceCon->EscapeString($managedcron_id)." ".
						" ORDER BY mc.name ";
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}	
	
	/**
	 * GetManagedCronByID
	 */	
	function GetManagedCronByID( $managedcron_id )
	{
		$sql_query =	" SELECT * ".
						" FROM `egl_managedcrons` AS mc ".
						" WHERE mc.managedcron_id='".$this->pDBInterfaceCon->EscapeString($managedcron_id)."'";
		return  $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * GetManagedCrons
	 */	
	function GetManagedCrons()
	{
		$sql_query =	" SELECT mc.*, COUNT(tasks.id) AS num_tasks ".
						" FROM `egl_managedcrons` AS mc ".
						" LEFT JOIN `egl_managedcrons_tasks` AS tasks ".
						" ON tasks.mc_id=mc.id ".
						" GROUP BY mc.id ";
						
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
		
	/**
	 * GetManagedCronTask
	 */	
	function GetManagedCronTask( $member_id, $mc_id ){
		$sql_query =	" SELECT * ".
						" FROM `egl_managedcrons_tasks` AS mc_tasks ".
						" WHERE mc_tasks.mc_id=".((int)$mc_id)." && mc_tasks.member_id=".((int)$member_id)."";
		return  $this->pDBInterfaceCon->FetchObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
	
	/**
	 * GetManagedCronTask
	 */	
	function GetUsers(){
		$sql_query =	" SELECT mc_users.*, members.nick_name, COUNT(tasks.id) AS num_tasks ".
						" FROM `egl_managedcrons_user` AS mc_users ".
						" LEFT JOIN `egl_managedcrons_tasks` AS tasks ".
						" ON tasks.member_id=mc_users.member_id ".
						" LEFT JOIN `".$GLOBALS['g_egltb_members']."` AS members ".
						" ON members.id=mc_users.member_id ".
						" GROUP BY mc_users.id ";
						
		return $this->pDBInterfaceCon->FetchArrayObject( $this->pDBInterfaceCon->Query( $sql_query ) );
	}
	
			
	/**
	 * AddManagedCron
	 */
	function AddManagedCron( $object ){
			# creat insert query + execute => return true/false
		$sql_query = $this->pDBInterfaceCon->CreateInsertQuery( 'egl_managedcrons', $object );
		return $this->pDBInterfaceCon->Query( $sql_query );
	}
};


?>