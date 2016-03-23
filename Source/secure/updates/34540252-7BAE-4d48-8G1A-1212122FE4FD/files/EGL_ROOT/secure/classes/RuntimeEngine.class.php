<?php
# ================================ Copyright  2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: RuntimeEngine
# ================================================================================================================

# -[ defines ]-
define( "EGL_NO_ID",			-1 );
define( "EGL_TIME",			time() );
define( "EGL_CURRENT_VERSION",	"0.8.1.0" );
define( "EGLFILE_PERMISSIONTREE", EGL_SECURE . 'gc'.DIRECTORY_SEPARATOR.'permissiontree.gc' );


# unknown data for NULL references
$__DATA__	= NULL;


# basic includes, used for the egl-engine (whole)
require( EGL_SECURE."utils".EGL_DIRSEP.'string.utils.php' );
require( FIX_URL_SEP( EGL_SECURE.'utils'.DIRECTORY_SEPARATOR.'egl_basics.utils.php' ));

#============================================
# START SESSION
#============================================
require( FIX_URL_SEP(EGL_SECURE."classes/core/Session.class.php") );
Session::Start();

# -[ global variables ] -

#============================================
# Set global template directories/path
#============================================


#============================================
# INIT GLOBAL TB-MANANGEMENT
#============================================
require( EGL_SECURE."classes/core/DBTB.class.php" );
new DBTB();


define( 'EGLDIR_PHOTOS',				'files'.DIRECTORY_SEPARATOR.'photo_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_LOGOS',					'files'.DIRECTORY_SEPARATOR.'logo_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_GAMES',					'files'.DIRECTORY_SEPARATOR.'game_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_COUNTRY',				'files'.DIRECTORY_SEPARATOR.'country_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_MEDIA',					'files'.DIRECTORY_SEPARATOR.'media_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_GAMEACC_REPORTS',		'files'.DIRECTORY_SEPARATOR.'gameaccreports_pool'.DIRECTORY_SEPARATOR );
define( 'EGLDIR_NEWS_IMAGES',			'files'.DIRECTORY_SEPARATOR.'news_pool'.DIRECTORY_SEPARATOR );


define( "EGL_COOKIETIME",				EGL_TIME + 3600*24*31*12 ); /* 1 year */

define( "EGL_DEBUGSECURITY_LOW",		1 );
define( "EGL_DEBUGSECURITY_MIDDLE",		2 );
define( "EGL_DEBUGSECURITY_HIGH",		3 );


# -[ objectlist ] -
class egl_statistics_t
{
	var $numMembers	= 0;
	var $numClans	= 0;
	var $numTeams	= 0;
	var $numMatches	= 0;
};



/**
 * global variable storage
 * 
 */
class global_vars_t
{
	var $sWorkspace		= 'unknown';
	var $bOffline		= false;
	
	#----------------------------------
	
	var $cTpl					= NULL;		# Templatesystem (smarty)
	var $cDBInterface			= NULL;		# Global DBMS management system (MySQL|Oracle|PostgreSQL|..)
	var $cBench					= NULL;		# Benchmark management
	var $cLogin					= NULL;		# Member login system
	var $cPageAccess			= NULL;		# PageAccess management
	//var $cPermTree				= NULL;		# permissiontree
	//var $cPageSecure			= NULL;		# Pagesecure management, -> replaced with pageaccess management
	var $cDebugger				= NULL;		# Debuggersystem
	var $cLanguage				= NULL;		# Languagesystem
	var $pcRuntimeEngine 		= NULL;		// pointer to runtimeengine
	
	var $oDBConnectingData		= NULL;		# Containing connectiondata, global is connecting to.
	
	
	#----------------------------------
	var $bPageAccessDisabled	= false;
	
	
	#----------------------------------
	var $cMember				= NULL;		# Member management
	var $oMemberData			= NULL;		# Containing Memberdata, if logged in
	var $iMemberId				= 0;		# Id of current member, logged in
	var $aMemberAccountes		= array();	# Accountlist from current member, logged in [TEAMS,CLANS]
	#----------------------------------
	var $bLoggedIn				= false;			# currently, logged in?
	var $cConfigBuffer			= NULL;		
	
	# URL/Header informations
	#----------------------------------
	var $sURLFile				= '';
	var $sURLPage				= '';
	var $sURLPageSection		= '';
	var $sURLModule				= '';
	#----------------------------------
	
	var $cModuleManager			= NULL;			# Module Managementsystem
	var $oModule				= NULL;			# current module, loaded by url
	var $sModuleId				= EGL_NO_ID;	# current module-id
	var $bModuleActivated		= false;		# module currently loaded, according to url-module-id [page={MODULE_ID}:page_name]
	var $bModuleURLAttempt		= false;		# only on url, module_id
	var $oStatictics			= NULL;			
	
	#----------------------------------
	
	var $aLngBuffer				= array();
	var $sLanguage				= 'unknown';
	
	function global_vars_t(){}
};

/*****************************************************************************************************************/
/* Provisorische globale werte festlegung => wird sp�er dynamisch ber datenbank festgelegt ber CDBConfigLoader*/
/*****************************************************************************************************************/
$gl_oVars = new global_vars_t;
$gl_oVars->oConfigs->max_inactive_time = 3600; //1h




#================================
# Global includes
#================================

# [Smarty-Egnine]
require_once( SMARTY_DIR . 'Smarty.class.php');


# [phpMailer-Egnine]
require_once( EGL_LIBS . 'phpmailer/class.phpmailer.php');

# [configs]
require( FIX_URL_SEP(EGL_SECURE."configs/db_settings.cfg.php") );
require( FIX_URL_SEP(EGL_SECURE."configs/pw_settings.cfg.php") );
require( FIX_URL_SEP(EGL_SECURE."configs/table_settings.cfg.php") );
require( FIX_URL_SEP(EGL_SECURE."configs/emails.cfg.php") );
require( FIX_URL_SEP(EGL_SECURE."configs/domain.cfg.php") );


# [utils]
require( FIX_URL_SEP(EGL_SECURE."utils/math.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/other.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/array.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/smarty_tools.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/module_api.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/time_format.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/system.utils.php" ));
require( FIX_URL_SEP(EGL_SECURE."utils/binary.utils.php" ));


# ---------------------------------------------
# [EGL STREAM classes]
# ---------------------------------------------

#egl_require( EGL_SECURE."classes/streams/buffer_stream.class.php" );
#egl_require( EGL_SECURE."classes/streams/inputstream.class.php" );
#egl_require( EGL_SECURE."classes/streams/outputstream.class.php" );

#egl_require( EGL_SECURE."classes/streams/socket.class.php" );
#egl_require( EGL_SECURE."classes/streams/client_socket.class.php" );
#egl_require( EGL_SECURE."classes/streams/server_socket.class.php" );

# ---------------------------------------------
# [EGL CORE classes]
# ---------------------------------------------

egl_require( EGL_SECURE."classes/core/File.class.php" );
egl_require( EGL_SECURE."classes/core/Debugger.class.php" );


egl_require( EGL_SECURE."classes/core/DBConnection.class.php" );
egl_require( EGL_SECURE."classes/core/DBInterfaceFactory.class.php" );

//egl_require( EGL_SECURE."classes/dbcon/MySQLCon.class.php" );
#egl_require( EGL_SECURE."classes/dbcon/PostgreSQLCon.class.php" );



egl_require( EGL_SECURE."classes/core/UnknownSQLCon.class.php" );
egl_require( EGL_SECURE."classes/core/PHPErrorHandler.class.php" );
egl_require( EGL_SECURE."classes/core/IniFile.class.php" );
egl_require( EGL_SECURE."classes/core/MyDirectory.class.php" );
egl_require( EGL_SECURE."classes/core/Templates.class.php" );
egl_require( EGL_SECURE."classes/core/Document.class.php" );
egl_require( EGL_SECURE."classes/core/DBConfigs.class.php" );		# egl config class
egl_require( EGL_SECURE."classes/core/PermissionTree.class.php" );
egl_require( EGL_SECURE."classes/core/PageAccess.class.php" );
egl_require( EGL_SECURE."classes/core/PAEvaluator.class.php" );
egl_require( EGL_SECURE."classes/core/Timer.class.php" );
egl_require( EGL_SECURE."classes/core/Logs.class.php" );
#egl_require( EGL_SECURE."classes/core/ConfigLoader.class.php" );
#egl_require( EGL_SECURE."classes/core/Download.class.php" );
#egl_require( EGL_SECURE."classes/core/PageSecure.class.php" );

egl_require( EGL_SECURE."classes/core/Language.class.php" );
egl_require( EGL_SECURE."classes/core/Mails.class.php" );
egl_require( EGL_SECURE."classes/core/Bench.class.php" );

egl_require( EGL_SECURE."classes/core/Module.class.php" );
egl_require( EGL_SECURE."classes/core/ModuleManager.class.php" );

egl_require( EGL_SECURE."classes/core/WebcomInterface.class.php" );
egl_require( EGL_SECURE."classes/core/LicenseLoader.class.php" );


egl_require( EGL_SECURE."classes/core/FunctionLoaderFactory.class.php" );
egl_require( EGL_SECURE."classes/core/AttachmentEngine.class.php" );
egl_require( EGL_SECURE."classes/core/CallbackManager.class.php" );



egl_require( EGL_SECURE."classes/xml/XMLReader.class.php" );



# ---------------------------------------------
# [EGL CMS BASICS classes]
# ---------------------------------------------

egl_require( EGL_SECURE."classes/cms/OnlineList.class.php" );
egl_require( EGL_SECURE."classes/cms/UploadFile.class.php" );
egl_require( EGL_SECURE."classes/cms/Protests.class.php" );

egl_require( EGL_SECURE."classes/cms/Administrator.class.php" );
egl_require( EGL_SECURE."classes/cms/Login.class.php" );
egl_require( EGL_SECURE."classes/cms/Member.class.php" );		
egl_require( EGL_SECURE."classes/cms/MemberHistory.class.php" );		
egl_require( EGL_SECURE."classes/cms/Team.class.php" );		
egl_require( EGL_SECURE."classes/cms/PM.class.php" );	
egl_require( EGL_SECURE."classes/cms/Photo.class.php" );
egl_require( EGL_SECURE."classes/cms/Logo.class.php" );
egl_require( EGL_SECURE."classes/cms/Clan.class.php" );
egl_require( EGL_SECURE."classes/cms/Comments.class.php" );

egl_require( EGL_SECURE."classes/cms/GamePool.class.php" );
egl_require( EGL_SECURE."classes/cms/Country.class.php" );
egl_require( EGL_SECURE."classes/cms/Match.class.php" );
egl_require( EGL_SECURE."classes/cms/MatchReports.class.php" );

egl_require( EGL_SECURE."classes/cms/Media.class.php" );
egl_require( EGL_SECURE."classes/cms/GameAccounts.class.php" );
egl_require( EGL_SECURE."classes/cms/MatchStructures.class.php" );
egl_require( EGL_SECURE."classes/cms/MyCategory.class.php" );
egl_require( EGL_SECURE."classes/cms/DownloadManager.class.php" );

# ---------------------------------------------
# [EGL CMS ENVIRONMENT classes]
# ---------------------------------------------

egl_require( EGL_SECURE."classes/environment/BrowserSettings.class.php" );


/**
* RuntimeEngine for running workspaces
* @author 		Inetopia
* @copyright 	Inetopia
**/
class RuntimeEngine
{
	# -[ variables ]-
	var $sWorkspaceName		= "Unknown";
	var $sRuntimeName		= "Unknown";
	var $bSystemSopped		= false;
	
	//var $cBench			= NULL;
	//var $cLogin			= NULL;

	
	//var $cLanguage		= NULL;
	//var $sRelDir		= 'unknown';
	
			/*
				const	=> Language
				---------------------------
				de 		=> Deutsch
				eng 	=> Englisch
				fr		=> Franz�isch
			*/
	
	
	# =========================================================================
	# FUNCTIONS
	# =========================================================================
	
	/*
	* Constructor RuntimeEngine::RuntimeEngine()
	* 
	* @param 	string		name of whole runtime, not workspace specified
	**/
	function RuntimeEngine ( $runtime_name='' )
	{
		global $gl_oVars;


		// start bencher
		$gl_oVars->cBench 			= new Bench();
		$gl_oVars->pcRuntimeEngine 	= &$this;
		
		#-----------------------------------------------
		# define global variables
		#-----------------------------------------------
		
		if( strlen($runtime_name) > 0 )
		{
			$this->sRuntimeName = $runtime_name;
			
			# initialise debugger instance
			$gl_oVars->cDebugger	= new Debugger( true, "{$runtime_name}.debugger" /* set as complex file */ );
			
		}
		else
		{
			# initialise debugger instance
			$gl_oVars->cDebugger	= new Debugger( true, "EGL.unknown.debuger" /* set as complex file */ );
		}

		# try init debugger
		if( $gl_oVars->cDebugger->Init( $this ) )
		{
			# define debug output destination path
			$gl_oVars->cDebugger->SetOutputDir( 'output/' );

			# set template vars
			$gl_oVars->cDebugger->SetTemplateValues( 'output.tpl',
													 EGL_SECURE.'debug/templates/',
													 EGL_SECURE.'configs/',
													 EGL_SECURE.'debug/templates_c/',
													 EGL_SECURE.'debug/cache/' );

		}
		else
		{
			# ERROR ?
		}
		
		
		# start bench & setup debugger bench
		$gl_oVars->cBench->start();
		$gl_oVars->cDebugger->SetBenchTimer( $gl_oVars->cBench );

		

		#---------------------------------------------------
		# declare database interface
		#---------------------------------------------------
		$gl_oVars->cDBInterface	= DBInterfaceFactory::DBInterfaceFactory( varofclass( 'db_connecting_data', 'dbbib') /*'MySQLCon'classname*/ );
		# (2) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'PostgreSQLCon' );*/
		# (3) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'ODBCCon' );		=> not implemented*/
		# (4) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'OracleCon' );	=> not implemented*/
		
		
		//$gl_oVars->oDBConnectingData	= new db_connection();

		#---------------------------------------------------
		# declare objets
		#---------------------------------------------------
		$gl_oVars->cTpl 			= new Templates();
		$gl_oVars->cLogin			= new Login( $gl_oVars->cDBInterface );
		$gl_oVars->cModuleManager	= new ModuleManager( $gl_oVars->cDBInterface );
		$gl_oVars->cMember			= new Member( $gl_oVars->cDBInterface );
		$gl_oVars->cPageAccess		= new PageAccess( $gl_oVars->cMember, $gl_oVars->cDBInterface );
		//$gl_oVars->cPageSecure		= new PageSecure();
		$gl_oVars->cLanguage		= new Language();
	
		
		# init templates
		if( !$gl_oVars->cTpl->Init() )
		{
			/* templates initialisation failed: return error*/
			// return 0;
		}

		# load configurtions
	
		
		
		# set configurations
		$this->SetDebugSecurity( EGL_DEBUGSECURITY_MIDDLE );

		// constructor doesn't return a value
		// return 1;
	}
	
	
	//-------------------------------------------------------------------------------
	// Purpose: initialise page 
	// Output : true/false
	//-------------------------------------------------------------------------------	
	/**
	* initialise workspace & runtime
	*
	* @param 	string	workspacename, located in EGL_ROOT/workspaces/
	* @return	boolean	true(1)/false(0)
	**/
	function Init( $workspace )
	{

		#CSession::Start( 'egl.'.$rel_dir.'.session' );
		
		if( !$this->FirstInits() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't run first inits `RuntimeEngine::FirstInits()`" );
			return 0;
		}
		
		
		
		$workspace_root = EGL_SECURE.'workspaces/'.$workspace.'/';
		if( !is_dir( $workspace_root ))
		{
			//print "<br>Fatal error - RuntimeEngine couldn't read from workspace root";
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "RuntimeEngine couldn't read from workspace root `{$workspace_root}`" );
			return 0;
		}
	

		#-----------------------------------------------
		# define global variables
		#-----------------------------------------------
		global $gl_oVars;

	
		#-----------------------------------------------
		# base URL sets
		#-----------------------------------------------

		
		# Description: 
		# -------------------------
		# relativ file_path containg the page files/data

		$gl_oVars->sWorkspace			= $workspace;
		

		# [save values]
		
		if( isset($_GET['page']) )		
			$gl_oVars->sURLPage 			= htmlentities( $_GET['page'] );				# get current page (str/int)
		//$gl_oVars->sURLPageSection 		= $gl_oVars->sURLSection = substr( $gl_oVars->sURLPage, 0, strpos( $gl_oVars->sURLPage, '/' ) );
		$gl_oVars->aPageSections		= db_read_array_string( $gl_oVars->sURLPage, '.' );
		$gl_oVars->sURLFile				= $_SERVER['PHP_SELF'];							# set current base file
		$gl_oVars->sLanguage			= $_SESSION['usr']['language'];					# get language


		// module activated??
		$strlen_sURLPage = strlen($gl_oVars->sURLPage);
		if( $strlen_sURLPage > (MODULE_ID_LENGTH+1) && $gl_oVars->sURLPage[MODULE_ID_LENGTH] == ':' )
		{
			$gl_oVars->bModuleURLAttempt	= true;			# module activated ?
			$gl_oVars->sModuleId			= substr( $gl_oVars->sURLPage, 0, MODULE_ID_LENGTH);		# module ID
			$gl_oVars->sURLPage				= substr( $gl_oVars->sURLPage, MODULE_ID_LENGTH+1, $strlen_sURLPage-(MODULE_ID_LENGTH+1));
			$gl_oVars->oModule				= NULL;
			

		}
		else
		{
			$gl_oVars->bModuleURLAttempt	= false;			# module activated ?
			$gl_oVars->oModule				= NULL;				# current selected module ??
			$gl_oVars->sModuleId			= '';				# module ID
		}
		
		
		# if the language value isn't set => set german(de) as default
		if( !$gl_oVars->sLanguage )	$gl_oVars->sLanguage = 'de';
	

		# init databasesystem
		if( !$this->InitDatabase() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Database system couldn't be initialised." );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;

		}
		else
		{
			DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Database initialised successfully" );
		}
		
		
		#-----------------------------------------------
		# establish database connection
		#-----------------------------------------------
		if( !$this->InitDBConnectionSystem() )
		{
			# ERROR
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "DB-connection couldn't be loaded." );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			//return 0;
		}
		
		#-------------------------------------------------------------------------------------
		#-------------------------------------------------------------------------------------
		

		
		# init template-system
		if( !$this->InitTemplateSystem( $gl_oVars->sWorkspace ) )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Templatesystem couldn't be initialised" );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;
		}
		else
		{
			DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Template System initialised" );
		}
			


		# init module-system
		if( !$this->InitModuleSystem() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Modulesystem couldn't be initialised." );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;

		}
		else
		{
			DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Modulesystem initialised successfully" );
		}


		# ----------------------------------------------------------
		# ----------------------------------------------------------
		# Load basic language-file
		# ----------------------------------------------------------
		# ----------------------------------------------------------
		$gl_oVars->cTpl->assign( 'LANGUAGE', $gl_oVars->sLanguage );
		if( $gl_oVars->cLanguage->SetLanguage( $gl_oVars->sLanguage ) )	# set language
		{
			// success?
		}

		


		# parsing language file, receiving output to '$gl_oVars->aLngBuffer['basic']'
		if( !$gl_oVars->cLanguage->ParseFile( WORKSPACE_DIR.$gl_oVars->sWorkspace.EGL_DIRSEP.'languages'.EGL_DIRSEP, $gl_oVars->aLngBuffer['basic'] ) )
		{
			# DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Couldn't load basic language file" );
			#
			#	do not abort
			#
			
		} else DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "Basic language file loaded." );
		
		
		#--------------------------------------
		# have to be the last !!!!
		#--------------------------------------
		if( !$this->EvaluateLoginState() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't evaluate login-state `RuntimeEngine::EvaluateLoginState()`" );
			return 0;
		}
		
		
		# init page, replaced by parent class
		#-------------------------------------
		if( !$this->InitPage() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't init page `RuntimeEngine::InitPage()`" );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;
		}

	
	
		#--------------------------------------
		# have to be the last !!!!
		#--------------------------------------
		if( !$this->ConfigureDocument() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't configure document `RuntimeEngine::ConfigureDocument()`" );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;
		}
		
	
		#--------------------------------------
		# last inits
		#--------------------------------------
		if( !$this->LastInits() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't run last inits `RuntimeEngine::LastInits()`" );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;
		}
		
		
		# Overloaded: Final loads by head class
		if( !$this->FinalLoads() )
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't run final loading `RuntimeEngine::FinalLoads()`" );
			//print( "RuntimeEngine stopped. For more information see debug files!" );
			return 0;
		}
		
		
		
		DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "RuntimeEngine initialised" );
		
		
		
		
		// set up debugger vars
		$gl_oVars->cDebugger->AssignVar( "page", $gl_oVars->sURLPage );
		$gl_oVars->cDebugger->AssignVar( "module_id", $gl_oVars->sModuleId );
		$gl_oVars->cDebugger->AssignVar( "workspace", $gl_oVars->sWorkspace );
		
		return 1;
	}
	
	

	/**
	* first inits for overloaded class / processed the first time of RuntimeEngine::Init() method
	*
	* @return 	boolean true(1)/false(0)
	**/
	function FirstInits(){return 1;}

	/**
	* last inits for overloaded class / processed after Runtime::Init() method
	*
	*
	* @return 	boolean true(1)/false(0)
	**/
	function LastInits() {return 1;}// function LastInits()
	
	
	/**
	* initialise whole page, runs 
	*
	* @return 	boolean true(1)/false(0)
	**/
	function InitPage(){return 1;}
	
	
	/**
	* member login evaluator
	*
	* @return 	boolean true(1)/false(0)
	**/	
	function EvaluateLoginState(){ return 1;}
	
	/**
	* init database by setting up database configurations (connection), by running RuntimeEngine::SetDatabaseConnectingData()
	*
	* @return 	boolean true(1)/false(0)
	**/
	function InitDatabase(){return 1;}

	
	
	/**
	* setting up database connection data
	* 
	* @param	db_connecting_data	object, containing connection data
	* @return	boolean				true(1)/false(0)
	**/
	function SetDatabaseConnectingData( $oConnectingData )
	{
		global $gl_oVars;
		if( is_a( $oConnectingData, 'db_connecting_data' ) )
		{
			$gl_oVars->oDBConnectingData = $oConnectingData;
			return 1;
		}
		else
		{
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DatabaseConnectingData must be typed by `db_connecting_data`" );
			return 0;
		}
	}
	
	/**
	* Debugger-Mode behavior
	* 
	* @param 	integer		Debugger-Mode EGL_DEBUGSECURITY_LOW | EGL_DEBUGSECURITY_MIDDLE | EGL_DEBUGSECURITY_HIGH 
	* @return 	boolean		true(1)/false(0)
	**/
	function SetDebugSecurity($debugmode)
	{
		global $gl_oVars;
		if( $gl_oVars->cDebugger) return $gl_oVars->cDebugger->SetDebugSecurity($debugmode);
		return 0;
	}
	function GetDebugSecurtiy(){ return $this->iDebugSecurity;}
	function SystemSopped(){ $this->bSystemSopped=true; return 1;}
 	
	/**
	* initialise the basics of current page
	*	(a) setting up url page
	* 
	* @return boolean true(1)/false(0)
	**/
	function ConfigureDocument()
	{
		global $gl_oVars;		
		
		/*
			Configure-Page:
			declare loaded templates/documents & load document
			
			setting up		-> 	loaded page
							->  
			
		*/
		$document = new Document( $gl_oVars );
		return $document->ConfigurePage();
	}
	

	/**
	* final load after RuntimeEngine::LastInits()
	* 
	* @return boolean true(1)/false(0)
	**/
	function FinalLoads()
	{
		global $gl_oVars;		
		
		
		#==========================================================================================
		# ADD TEMPLATE VARS
		#==========================================================================================
		
	
		/*
		$gl_oVars->cTpl->assign( 'LNG_BASIC', $this->oVars->aLngBuffer['basic'] );
		$gl_oVars->cTpl->assign( 'LNG_MODULE', $this->oVars->aLngBuffer['module'] );
		*/
		
		$gl_oVars->cTpl->assign( 'LNG_BASIC', $gl_oVars->aLngBuffer['basic'] );
		$gl_oVars->cTpl->assign( 'LNG_MODULE',$gl_oVars->aLngBuffer['module'] );
		
		return 1;
	}
	
	
	
	
	/**
	* initialise DBInterface, DBConnectionSystem
	* 	(a) loading selected database library
	*	(b) try open connection to remote database
	*
	* @return boolean true(1)/false(0)
	**/
	function InitDBConnectionSystem()
	{
		global $gl_oVars;
		#----------------------------------------------
		# try to establish database connection
		#----------------------------------------------
		if( isset($gl_oVars->oDBConnectingData) )
		{
			# check connection type data
			if( is_a( $gl_oVars->oDBConnectingData, 'db_connecting_data') )
			{
				# check connectiondata
				if( $gl_oVars->cDBInterface && get_class($gl_oVars->cDBInterface) != 'unknownsqlcon' )
				{
					# try opening connection to remote database
					if( !$gl_oVars->cDBInterface->__OpenConnection( $gl_oVars->oDBConnectingData ) )
					{
						//sDEBUG
						DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DatabaseInterface - couldn't be initialised, DB-Message:`".$gl_oVars->cDBInterface->GetLastError()."`" );
						return 0;
					}
					else
					{
						// success
						return 1;
					}
				}
				else
				{
					DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "DatabaseInterface - couldn't open connection on using an NULL instance " );
				}
			}//if db_connection object ?
			else
			{
				DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Wrong database connection data `oDBConnectingData`" );
				print "RuntimeEngine stopped. Fore more informaton see debug files! " ;
				return 0;
			}
		}// dbconnetion exists??
		else
		{
			return 1;
		}
		
		return 0;
	}
		
	
	/**
	* initialise Templatesystem [ Smarty Engine - visit smarty.php.met ]
	* 	(a) setting up template/config/compile/cache directory
	*	(b) assign standard variables to template engine
	*
	* @param 	string		wokspace name
	* @return 	boolean 	true(1)/false(0)
	**/
	function InitTemplateSystem( $workspace )
	{
		#-----------------------------------------------
		# define global variables
		#-----------------------------------------------
		global $gl_oVars;
				
			
		#-----------------------------
		# set up/init smarty values
		#-----------------------------
		$gl_oVars->cTpl->template_dir 	= EGL_SECURE.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'templates'.EGL_DIRSEP;
		$gl_oVars->cTpl->config_dir 	= EGL_SECURE.'configs'.EGL_DIRSEP;
		$gl_oVars->cTpl->compile_dir 	= EGL_SECURE.'data'.EGL_DIRSEP.'smarty'.EGL_DIRSEP.'templates_c'.EGL_DIRSEP.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP;
		$gl_oVars->cTpl->cache_dir	 	= EGL_SECURE.'data'.EGL_DIRSEP.'smarty'.EGL_DIRSEP.'cache'.EGL_DIRSEP.$workspace.EGL_DIRSEP;
		
		#$gl_oVars->cTpl->caching 		= true; // activate caching
		
		#==========================================
		# load smarty configs
		#==========================================
		#$gl_oVars->cTpl->config_load( "permission_tree.conf" );	# load clan/team permissions
		#$gl_oVars->cTpl->config_load( "pages.access.conf" );		# page accesses clan/team page permissions
		#$gl_oVars->cTpl->config_load( "pages.secure.conf" );		# login/logout permissions
		$gl_oVars->cTpl->config_load( "alias.conf" );				# alias, like split chars...aso
		
		
		#===========================================
		# relativ files
		#===========================================
		
		if( file_exists(WORKSPACE_DIR.$workspace.EGL_DIRSEP.'configs'.EGL_DIRSEP.'colors.conf') )
		{
			$gl_oVars->cTpl->config_load( WORKSPACE_DIR .$workspace.EGL_DIRSEP.'configs'.EGL_DIRSEP.'colors.conf' );	# load colors
		}
		else
		{
			DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Warning - couldn't find color configurations in workspace directory `configs/colors.conf`" );
		}
				
		
		# save config-var-buffer to $gl_oVars->aTplVars
		$gl_oVars->aTplVars = & $gl_oVars->cTpl->get_config_vars();
		
		
		#===========================================
		# variables
		#===========================================
		

		$gl_oVars->cTpl->assign( 'path_photos', 			EGLDIR_PHOTOS );
		$gl_oVars->cTpl->assign( 'path_logos', 				EGLDIR_LOGOS );
		$gl_oVars->cTpl->assign( 'path_games', 				EGLDIR_GAMES );
		$gl_oVars->cTpl->assign( 'path_country',		 	EGLDIR_COUNTRY );
		$gl_oVars->cTpl->assign( 'path_media', 				EGLDIR_MEDIA );
		$gl_oVars->cTpl->assign( 'path_gameacc_reports', 	EGLDIR_GAMEACC_REPORTS );
		
		
		/////////////////////////////////////////////////////////////////////////////////////
		
		$gl_oVars->cTpl->assign( 'PATH_PHOTOS', 			EGLDIR_PHOTOS );
		$gl_oVars->cTpl->assign( 'PATH_LOGOS', 				EGLDIR_LOGOS );
		$gl_oVars->cTpl->assign( 'PATH_GAMES', 				EGLDIR_GAMES );
		$gl_oVars->cTpl->assign( 'PATH_COUNTRY',		 	EGLDIR_COUNTRY );
		$gl_oVars->cTpl->assign( 'PATH_MEDIA', 				EGLDIR_MEDIA );
		$gl_oVars->cTpl->assign( 'PATH_GAMEACC_REPORTS', 	EGLDIR_GAMEACC_REPORTS );
		
		
		
		$gl_oVars->cTpl->assign( 'time', 					EGL_TIME );					# time()
		$gl_oVars->cTpl->assign( 'TIME', 					EGL_TIME );					# time()
		$gl_oVars->cTpl->assign( 'URL_PARAMS',				print_url_params(NULL));
		
		
		
		# add defines
		$gl_oVars->cTpl->assign( '_EGL_NO_ID_', 			EGL_NO_ID );
		
		
		$gl_oVars->cTpl->assign( 'DESIGN_HEADER_COLOR', 	"#FFBA00" );


		# sabe post & get var into template system
		$gl_oVars->cTpl->assign_by_ref( '_post', 			$_POST ); 
		$gl_oVars->cTpl->assign_by_ref( '_get', 			$_GET ); 
		$gl_oVars->cTpl->assign_by_ref( '_session', 		$_SESSION ); 
		
		$gl_oVars->cTpl->assign( 'session_id',				 Session::GetId() ); 
		
		$gl_oVars->cTpl->assign( 'PAGE_SECTIONS',			$gl_oVars->aPageSections ); 

		$gl_oVars->cTpl->assign( 'EGL_CURRENT_VERSION',		EGL_CURRENT_VERSION ); 

		return 1;
	}//InitTemplateSystem
	
	
	
	
	/**
	* initialise Modulesystem (Manager)
	* 	(a) setting up template/config/compile/cache directory
	*	(b) assign standard variables to template engine
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function InitModuleSystem()
	{
		# 
		global $gl_oVars;
		
		
		#===================================================
		# INIT & LOAD cMod API
		#===================================================
		if( !$gl_oVars->cModuleManager->Init() )
		{
			# couln't init cmod manager !!
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "Couldn't init ModuleManager `ModuleManager::Init()`" );
			return 0;
		}

		# get current mod_data
		if( module_checkid($gl_oVars->sModuleId) )
		{

			# try to get CModdata
			
			# module currently exists ??
			if( !($gl_oVars->oModule = $gl_oVars->cModuleManager->GetModule( $gl_oVars->sModuleId )))
			{
				# disable module
				$gl_oVars->bModuleActivated = false;
				
				DEBUG( MSGTYPE_WARNING, __FILE__, __LINE__, "Module URL-Loading failed" );
			}
			else
			{
				# module installed ?
				if( $gl_oVars->oModule->bInstalled && $gl_oVars->oModule->bActivated )
				{
					/*
					# define new loaction of templates (=> to cmod templates)
					$g_sTplAppendix = EGL_SECURE.'cmods/'.$g_oCMod->sCModPath.'/';
					*/
					
					$gl_oVars->bModuleActivated = true;
				}
				else 
				{
			
					# reset vars
					//$gl_oVars->oModule 				= NULL;
					$gl_oVars->bModuleActivated = false;
					
				}//if bInstalled
			}//if get module
		}//if bModuleActivated
		
		DEBUG( MSGTYPE_INFO, __FILE__, __LINE__, "ModuleManager initialised" );
		return 1; 
	}//InitModule-System
	
	
	
	
	/**
	* run configured workspace runtime
	* 	(a) check settings
	* 	(b) try displaying templates, based on current file
	*
	* @param 	string		base template file
	* @return 	boolean 	true(1)/false(0)
	**/
	function Run( $base_file )
	{
		return $this->Display( $base_file );
	}//Run
	
	
	
	/**
	* run/display configured workspace runtime
	* 	(a) check settings
	* 	(b) try displaying templates, based on current file
	*
	* @param 	string		base template file
	* @return 	boolean 	true(1)/false(0)
	**/
	function Display( $base_file )
	{
		global $gl_oVars;
		
		/* CHECK Template file */
		/*
		$aModules = $gl_oVars->cModuleManager->GetActivatedModules();
		for( $i=0; $i < sizeof($aModules); $i++ )
		{
			
		}//for*/
		
		
		if( !$gl_oVars->cTpl->template_exists( $base_file ))
		{
			print "<br>Fatal error - RuntimeEngine couldn't load base file `{$base_file}`";
			DEBUG( MSGTYPE_ERROR, __FILE__, __LINE__, "RuntimeEngine couldn't load base file `{$base_file}`" );
			return 0;
		}
		else
		{
			$gl_oVars->cTpl->assign( "BENCH_TIME", round( $gl_oVars->cBench->runTime(), 2) );
			# catch output
			$this->ParseSoftwareDetails();
			
			// $gl_oVars->cTpl->fetch( $base_fileEGL_ROOT."secure/modules/inetopia.cup/templates/attachments/cup.details.tpl" );
			
			
			$gl_oVars->cTpl->display( $base_file );
			
			
			return 1;
		}
	}
	
	
	/**
	* release initialised runtime
	* 	(a) bench
	*	(b) debugger
	*
	* @param 	string		base template file
	* @return 	boolean 	true(1)/false(0)
	**/
	function Release()
	{
		global $gl_oVars;
		
		# stop timer 
		$gl_oVars->cBench->stop();
		$gl_oVars->cDebugger->SetBenchTime( $gl_oVars->cBench->diff() );
		
		# release debuggger
		$gl_oVars->cDebugger->BuildOutput();
		
		//$gl_oVars->cDebugger->ShowDebugFile();
		$gl_oVars->cDebugger->Release();
	
		return 1;	
	}//Release
	
	
	/**
	* shutdown egl system core
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function Shutdown()
	{
	}
	
	
	/**
	* shutdown egl system core
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function ParseSoftwareDetails()
	{
		$aLicenseProperties = LicenseLoader::GetLicenseData();
		$hashed_license_key = md5( $aLicenseProperties['key']['value'] );
		
		print( "<!--" );
		print( "\n #####################################################################" );
		print( "\n EGL.net - Electronic Gaming League, generated with v".EGL_CURRENT_VERSION." - ".strftime("%d.%m%y %H:%M:%S", EGL_TIME ));
		print( "\n Copyright(c) 2005-2006 by �Inetopia. Professional E-Sport Solutions. Visit www.inetopia.de" );
		print( "\n Used License {$hashed_license_key} " );
		print( "\n" );
		print( "\n Project & support - http://www.electronicgamingleague.de" );
		print( "\n Forum - http://www.electronicgamingleague.de/forum/" );
		print( "\n Development & Publishment 2006 by �Inetopia. All rights reserved. Alle recht vorbehalten." );
		print( "\n #####################################################################" );
		print( "\n-->\n\n" );
	}


	/**
	* select language buffer, stored in language files
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function SelectLanguage( $lng )
	{
	}
	
	
	
	/**
	* parse cookie buffer
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function ParseCookieBuffer()
	{
	}
	
	
	
	/**
	* check offline mode??
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function IsOfflineMode()
	{
		return 0;
	}
};
?>