<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: Establish a socket-connection to local egl-client core. Transmit & Receive commands
# ================================================================================================================


# -[ defines ]-
define( "WEBCOM_TRASMISSION_PORT",		3392 );
define( "WEBCOM_TRASMISSION_ADDRESS",	'192.168.2.107' );

	
# -[ objectlist ] -



# -[ class ] -
class WebComInterface
{
	# -[ variables ]-
	var $oClientSocket			= NULL;
	var $bChannelOpened			= false;
	
	
	var $RecvBuffer				= NULL;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function WebComInterface ()
	{
		// init sockets for webcominterface transmition
		$this->oClientSocket = new CClientSocket( 	WEBCOM_TRASMISSION_PORT, 
													WEBCOM_TRASMISSION_ADDRESS );
		
		DEBUG( MSGTYPE_INFO, __FILE__, __FILE__, 'WebComInterface::WebComInterface() - sockets created' );
	}
	
	
	
	//-------------------------------------------------------------------------------
	// Purpose: create transmition
	// Output : true/false
	//-------------------------------------------------------------------------------
	function InitTransmission()
	{
		if( !$this->oClientSocket->EstablishConnection( 'TCP' ) )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "WebComInterface::InitTransmission(), ClientSocket::EstablishConnection() failed; MSG: ".$this->oClientSocket->GetLastError() ); 
			return 0;
		}else 
		{	
			DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "WebComInterface::InitTransmission() - connection to eglclient_core  establised!" ); 
		}

		
		# successed
		$this->bChannelOpened=true;
		return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function ShutdownTransmission()
	{
		if( $this->bChannelOpened )
		{
			// close connection
			if( $this->oClientSocket->CloseConnection() )
			{
				DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "WebComInterface::InitTransmission() - connection closed!" ); 
				
				// closed
				$this->bChannelOpened = false;
				return 0;
			}
			else 
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "WebComInterface::ShutdownTransmission(), CClientSocket::CloseConnection() failed - connection couldn't be closed!" ); 
			}
		}
		return 0;		
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose:
	// Output :
	//-------------------------------------------------------------------------------
	function TransmitCommand( $command )
	{
		if( $this->bChannelOpened )
		{
			if( $this->oClientSocket->SendBuffer($command."\n"))
			{
				
				DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "WebComInterface::TransmitCommand(), command has beend sent!" );

				define( "COMINT_TRANSMITTYPE_COMMAND", 11 );
				define( "SQL_QUERY", 12 );
				
				$in = new CInputStream( $this->oClientSocket );
				$out = new COutputStream( $this->oClientSocket );
				
				$package = new inout_package_t;
				$package->id 		= 1;
				$package->type 		= COMINT_TRANSMITTYPE_COMMAND;
				$package->buf		= " SELECT member.id FROM egl_members AS member".
									  " LEFT JOIN egl_blocklist AS bl".
									  " ON members.id=bl.member_id ".
									  " LEFT JOIN egl_setfreelist AS sfl ".
									  " ON sfl.member_id=member.id ".
									  " ORDER BY sfl.created ASC ";
				$package->length	= strlen($package->buf);
				
				# versende packet
				//$out->writeIOPackage( $package );
		
				
				/*
				$id = $in->readInt();
				$type = $in->readInt();
				$length = $in->readInt();
				$buf = $in->readString($length);
				
				
				echo "Id: ".$id;
				echo "Type: ".$type;
				echo "Length: ".$length;
				echo "Buf: ".$buf;
				$out->writeInt( 5 );
				*/
				
				return 1;
			}//if
			else
			{
				DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "WebComInterface::TransmitCommand(), CClientSocket::SendBuffer() failed; MSG: ".$this->oClientSocket->GetLastError() ); 
				return 0;
			}
		}//if
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "WebComInterface::TransmitCommand(), - no channel currently available, sending a command!" ); 
			return 0;
		}
	}
	

};



?>