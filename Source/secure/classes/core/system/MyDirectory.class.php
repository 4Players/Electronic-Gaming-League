<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-


# -[ objectlist ] -





# -[ class ] -
class MyDirectory
{
	# -[ variables ]-
	var	$sDir		= "unknown";
	var $bOpened	= false;
	
	var $hDir		= NULL;
	
	
	# -[ functions ]-
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function MyDirectory ()
	{
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: open  directory
	// Output : -1, currently opened, 0 wrong path, 1 success
	//-------------------------------------------------------------------------------
	function Open( $dir )
	{
		$this->sDir = FIX_URL_SEP($dir.'/');
		if( $this->bOpened ) return -1;
		if( !is_dir( $this->sDir ) ) return 0;
		
		if( ($this->hDir=opendir( $this->sDir )) )
		{
			$this->bOpened = true;
			return 1;
		}
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function Close()
	{
		# currently opened ?
		if( $this->bOpened )
		{
			# close dir 
			if( @closedir( $this->hDir ) )
			{
				$this->bOpened = false;
				$hDir = NULL;
				$this->sDir = "";
				return 1;
			}else return 0;
		}
		return 0;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : -
	//-------------------------------------------------------------------------------
	function GetFiles( $aExtensions=NULL )
	{
		$aFiles = array();
		if( $this->bOpened )
		{
			$num_extensions=sizeof($aExtensions);
			$file = null;
			while( ($file=$this->Next()) != false )
			{
				if( !@is_dir( $this->sDir.$file ) && ($file != '.' && $file!='..'))
				{
					// extension check
					if( $aExtensions != NULL && $num_extensions > 0 )
					{
						for( $i=0; $i < $num_extensions; $i++ )
							if( $aExtensions[$i] == get_file_extension($file, 0 ) )
								$aFiles[sizeof($aFiles)] = $file;
					}
					else 
					{
						$aFiles[sizeof($aFiles)] = $file;
					}// extension check
					
				}//if
			}//while
		}//if
		rewinddir($this->hDir );
		return $aFiles;
	}
	

	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : -
	//-------------------------------------------------------------------------------
	function GetDirs()
	{
		$aDirs = array();
		if( $this->bOpened )
		{
			$file = null;
			while( ($file=$this->Next()) != false )
			{
				if( @is_dir( $this->sDir.$file ) && ($file != '.'&&$file!='..'))
					$aDirs[sizeof($aDirs)] = $file;
			}//while
		}//if
		rewinddir($this->hDir );
		return $aDirs;
	}
	
	//-------------------------------------------------------------------------------
	// Purpose: 
	// Output : -
	//-------------------------------------------------------------------------------
	function Next()
	{
		$file = 'unknown';
		if( ($file=@readdir( $this->hDir )) != false )
		{
			return $file;
		}
		return false;
	}
};

?>