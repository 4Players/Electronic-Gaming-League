<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -
class cuptree_mask_t
{
	var $aMemberMask	= array(); 		# format: array[round][member]	true/false
	var $aSelectMask	= array(); 		# format: array[round][select]	true/false
	var $aVSMask		= array();		# format: array[round][vs]		true/false
};


# -[ class ] -
class CupTree
{
	# -[ variables ]-
	
	# - - - - - - - - - - - - - - - - - - - - - 
	
	var $oTreeMask		= NULL;
	var $numMembers		= 0;
	var $numRounds		= 0;
	var $maxRounds		= 0;	
	var $startRound		= 0;
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output : -
	//-------------------------------------------------------------------------------
	function CupTree ()
	{
	}

	
	//-------------------------------------------------------------------------------
	// Purpose: creates the whole tree creation mask
	// Output : -
	//-------------------------------------------------------------------------------
	function CreateTreeMask( $numMembers, $rnd_start=0, $rnd_max=5 /*, $memb_start=0,$memb_max=64*/ )
	{
		# create tree mask 
		$this->oTreeMask = & new cuptree_mask_t;
		
		$this->numMembers = $numMembers;
		$numRounds = $this->numRounds = (log($numMembers)/log(2))+1;
	
		
		
		$pMemberMask 	= &$this->oTreeMask->aMemberMask;
		$pSelectMask 	= &$this->oTreeMask->aSelectMask;
		$pVSMask 		= &$this->oTreeMask->aVSMask;
		
		# compute new members / rounds
		
		$numMembers = $this->numMembers = pow( 2, $numRounds-1-$rnd_start );
		$numRounds = $this->numRounds = $this->numRounds = (log($numMembers)/log(2))+1;
		
		$this->maxRounds = $rnd_max;
		$this->startRound = $rnd_start;
		
		# ------------------------
		# establishing tree
		# ------------------------

		for( $i=0; $i < $numRounds; $i++ )
		{
			if( $i > $this->maxRounds ) break;
		
			$numItems 		= 0;
			$bStartSelect 	= false;		# start selecting ?
			$counter		= 0;			# select counter
			$numVSItems		= 0;
			
			## array cnt
			
			$array_cnt_member		= 0;
			$array_cnt_select		= 0;
			$array_cnt_vs			= 0;

			
			# for each member 
			for( $iMember=0; $iMember < 2*$numMembers-1; $iMember++ )
			{
				# erster schritt (von oben)
				if( $numItems==0 )
				{
					$_2_i = 2;
					if( $i==0) $_2_i=1;
					else $_2_i = $_2_i << $i-1;

					if( $iMember >= (int)($_2_i-1) )
					{
						# add 
						$pMemberMask[$i][$array_cnt_member] = true;
						
						# nur wenn nur letzte runde, select starten 
						if( $i < $numRounds-1)
						{
							$bStartSelect = true;
							$counter      = 0;
						}
						$numItems++;
					}
					else
					{
						$pMemberMask[$i][$array_cnt_member] = false;
					}
				}
				else
				{
					if( $numItems % ($_2_i << 1) == 0 )
					{
						# add name
						$pMemberMask[$i][$array_cnt_member] = true;
						
						# nur wenn nur letzte runde, select starten
						if( $i < $numRounds-1)
						if( !$bStartSelect )
						{
							$bStartSelect = true;
							$counter      = 0;
						}
					}
					else
					{
						# no content
						$pMemberMask[$i][$array_cnt_member] = false;
					}
					$numItems++;

				}
				if( !$bSkip ) $array_cnt_member++;
				
			
				# ------------------------------
				# select ?
				# ------------------------------
				if( $bStartSelect )
				{
					if( $counter < (($_2_i << 1)+1) )
					{
						$pSelectMask[$i][$array_cnt_select] = true;
						$counter++;
					}
					else
					{
						$pSelectMask[$i][$array_cnt_select] = 0;
					
						# stop colorizing
						$bStartSelect = false;
					}
				}
				else
				{
					$pSelectMask[$i][$array_cnt_select] = 0;
				}
				$array_cnt_select++;
				


				#------------------
				# VSMask
				#------------------
				if( $numVSItems == 0 )
				{
					if( $iMember >= (int)((($_2_i << 1)-1)) )
					{
						$pVSMask[$i][$array_cnt_vs] = true;
						$numVSItems++;
					}
					else
					{
						$pVSMask[$i][$array_cnt_vs] = 0;
					}
				}
				else
				{

					if( $numVSItems % (($_2_i << 2)) == 0 )
					{
						$pVSMask[$i][$array_cnt_vs] = true;
					}
					else 
					{
						$pVSMask[$i][$array_cnt_vs] = 0;
					}
					$numVSItems++;
				}
				$array_cnt_vs++;
				
				
			}//$iMember
		}//$iRound

		
		#echo nl2br( print_r( $pSelectMask, 1 ));
		#echo nl2br( print_r( $pSelectMask, 1 ));
		#echo nl2br( print_r( $pMemberMask, 1 ));
		
		return 1;
	}
	
	
	/*
	function SpliteTreeMask( $numMembers )
	{
	}*/
	
	/*
	function CreateHTMLOutput()
	{
 
		
		$pMemberMask 	= &$this->oTreeMask->aMemberMask;
		$pSelectMask 	= &$this->oTreeMask->aSelectMask;
		$pVSMask 		= &$this->oTreeMask->aVSMask;
				

		#--------------------------------------------------------

		
		$str = "";
		
		$str.= "<table border='0' cellpadding=0 cellspacing=0 >";
		$str.= "<tr>";
		
		for( $iR=0; $iR < $this->numRounds; $iR++ )
		{
			if( $iR == $this->numRounds-1 )
			{
				$str.= 	"<td bgcolor='#CFCFCF'>
						<table border='0' width='90'><tr><td>
						<font color='#000000'><b>Gewinner</b> </td></tr></table>
						</td>";
			}
			else
			{
				$str.= 	"<td bgcolor='#CFCFCF'>
						<table border='0' width='90'><tr><td>
						<font color='#000000'><b>Runde ".($this->startRound+$iR+1)." </b></td></tr></table>
						</td>";
			}
			$str.= "<td></td>";
		}
		$str.= "</tr>";
		$str .="<tr><td><img src='images/spacer.gif' width='20'></td></tr>";
		
		for( $iM=0; $iM < sizeof($pMemberMask[0]); $iM++ )
		{
				
			$str.= "<tr>";
			for( $iR=0; $iR < $this->numRounds; $iR++ )
			{
				if( $iR > $this->maxRounds ) break;				
				if( $pMemberMask[$iR][$iM] )
				{
					$str.= "<td bgcolor='#000000'>
							<table border='0'><tr><td>
					
						<table border=0 cellpadding=0 cellspacing=0><tr><td>
					
						<font size=2> <img src='images/country/germany.gif'> <A href=''>Cenetix</a> </td></tr></table>
					
						</td></tr>
					   </table>
					</td>";
				}
				else
				{
					if( $pVSMask[$iR][$iM] )
					{
						$str.= "<td align='right'> <A href=''><b>vs</b></a> </td>";
					}
					else
						$str.= "<td><img src='images/spacer.gif' height=10 width='1'></td>";
				}
			
			
				if( $pSelectMask[$iR][$iM] )
				{
					$str.= "<td bgcolor='#FF9000'><img src='images/spacer.gif' width=1></td>";
				}
				else
				{
					$str.= "<td></td>";
				}
				
			}
			$str.= "</tr>";
		}
	
		$str.= "</table>";


		return $str;
				
	#	echo nl2br( print_r( $pMemberMask, 1 ));
		
	}*/
	
};

?>