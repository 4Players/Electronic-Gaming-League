<?php
# ================================ Copyright (c) 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================





/**
* Class Calculator
*
* @package	
* @author	Inetopia.
*/
class Calculator
{
	# -[ variables ]-
	
	# -[ functions ]-

	/**
	* Constructor
	* 
	*/
	function Calculator ()
	{
	}
	

	/**
	* Calculator::GetCalculator()
	*
	* @return array caluclator-list
	*/
	function GetCalculator()
	{
		/*
		$aCalculator 	= array();
		$cMyDir 		= new MyDirectory();
		# try opening caclulator dir
		
		# ----------------------------------
		# add section func
		# ----------------------------------
		if( $cMyDir->Open( Calculator::GetCalculatorDir()) )
		{
			$aSections = $cMyDir->GetDirs();
			for( $i=0; $i < sizeof($aSections); $i++ )
			{
				$cFuncDir = new MyDirectory();
				if($cFuncDir->Open( Calculator::GetCalculatorDir().$aSections[$i].EGL_DIRSEP ))
				{
					$aFunctions = $cFuncDir->GetFiles( array('php') );
					for( $f=0; $f < sizeof($aFunctions); $f++ )
					{
						if (preg_match("/^callback\.([a-zA-Z0-9]+)\.([a-zA-Z0-9]+)\.php$/", "callbacker.section1.func1.php")) 
						{
						
						}
						else 
						{
						
						}
						
						$pC = &$cCalculator[sizeof($cCalculator)];
						$pC = new calculator_t();
						//$pC->func = $aFunctions[$f]
						
					}//for
					
					$cFuncDir->Close();
				}//if
				
			}//for
			
			$cMyDir->Close();
		}//if
		*/
		
		
		$aCalculator = array();
		$this->search_calculator( $this->GetCalculatorDir(), '', $aCalculator );
		return $aCalculator;
	}
	
	
	
	/**
	* Calculator::search_calculator
	*
	* @param string	calculator-root
	* @param string	function: sampple - "elo.standard"
	* @param array	caclulator buffer
	* @return void
	*/
	function search_calculator( $dir, $func, &$aCalculator )
	{
		$cDir = new MyDirectory();
		if( $cDir->Open( $dir ))
		{
			$aDirs = $cDir->GetDirs();
			foreach ( $aDirs as $subdir )
			{	
				if( $func == '' ) $next_func = $subdir;
				else $next_func = $func.'.'.$subdir;
				
				$this->search_calculator( $dir .$subdir.EGL_DIRSEP, $next_func, $aCalculator );		
			}//foreach
			
			$aFiles = $cDir->GetFiles();
			
			//if( is_array($aFiles) )
			//{
				foreach ( $aFiles as $file_func )
				{
					if (preg_match("/^([a-zA-Z0-9|\-|\_]+)\.callback\.php$/", $file_func)) 
					{
						if( $func == '' ) $_func = substr( $file_func, 0, strlen($file_func)-strlen('.callback.php'));
						else $_func = $func.'.'.substr( $file_func, 0, strlen($file_func)-strlen('.callback.php'));
						$aCalculator[sizeof($aCalculator)] = $_func;
					}//if
					
				}//foreach
			//}//if
			//else
			//{
				
			//}
		}//if
		
	}//function
	
	
	
	/**
	* get current calculator dir
	* 
	* @return string calculator-dir
	*/
	function GetCalculatorDir()
	{
		return EGL_SECURE.'calculator'.EGL_DIRSEP;
	}
};
?>