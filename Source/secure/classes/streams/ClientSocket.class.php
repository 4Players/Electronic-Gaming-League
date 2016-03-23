<?php
# ================================ Copyright © 2005-2006 iNetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ class ] -
class ClientSocket extends Socket 
{
	# -[ variables ]-
	var $hSocket		= NULL;
	

	var $iPort			= 0;
	var $sLocalAdress	= "unknown";
	var $sRemoteAdress	= "unknown";
	var $bConnected		= false;
	var $bInit			= false;
	
	var $sLastError		= "no error";
	var $iLastErrorcode = null;
	
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function ClientSocket ( $port, $address )
	{
		$this->iPort 			= $port;
		$this->sRemoteAdress 	= $address;
		
		$this->bInit = true;
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: trying to establish connection to remote adress
	// Output : 1/0 (true/false)
	//-------------------------------------------------------------------------------	
	function EstablishConnection( $type ) /* udp, tcp */
	{
		if( !$this->bInit ) return 0;
		
		if( $type == 'TCP' ) $this->hSocket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		else if( $type == 'UDP' ) $this->hSocket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		else return 0;
		
		
	
		# save last error 
		if( $this->FetchLastError() ) return 0;
		
		# establish connection
		if( socket_connect( $this->hSocket, $this->sRemoteAdress, $this->iPort ) )
		{
			if( $this->FetchLastError() ) return 0;
		}		
		
		# set true
		$this->bConnected=true;
		return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function CloseConnection()
	{

		if( $this->bConnected ) 
		{
			@socket_shutdown( $this->hSocket, 2);
			@socket_close( $this->hSocket);
			$this->bConnected=false;
			
			return 1;
			/*
			if( $this->FetchLastError() ) return 0;
			return 1;*/
			
		}//if
		return 0;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: read received buffer
	//   PARAM: $type; PHP_BINARY_READ /  PHP_NORMAL_READ
	// Output : 
	//-------------------------------------------------------------------------------
	function ReceiveBuffer( $size=SOCKET_MAX_BUFFER, $type=PHP_BINARY_READ )
	{
	
		if( !$this->bConnected ) return 0;
		$data=null;
		$data=socket_read( $this->hSocket, $size, $type );
		
		# save last error 
		if( $this->FetchLastError() ) return 0;
		return $data;
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: write binary/char data
	// Output : 1/0
	//-------------------------------------------------------------------------------	
	function SendBuffer( $data, $size=0 )
	{
		if( !$this->bConnected ) return 0;
		if( $size ) @socket_write( $this->hSocket, $data, $size );
		else @socket_write( $this->hSocket, $data, strlen($data) );
		
		# save last error 
		if( $this->FetchLastError() ) return 0;
		return 1;
	}
	
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function FetchLastError()
	{
		if(!$this->hSocket) return 0;
		
		# save last error 
		if( ($this->iLastErrorcode=socket_last_error($this->hSocket)) )
		{
			$this->sLastError = socket_strerror($this->hSocket);
			return 1;
		}
		return 0;		
	}

	
	function &GetSocket(){ return $this->hSocket; }
	function GetLastError() { return  $this->sLastError; }
	function GetLastErrorCode() { return  $this->iLastErrorCode; }
	
};



?>