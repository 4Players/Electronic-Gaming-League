<?php
# ================================ Copyright  2004-2007 Inetopia, All rights reserved. ==========================
# 
#
# Purpose: RuntimeEngine
# ================================================================================================================

# -[ defines ]-
if( !defined('EGL_DIRSEP')) define('EGL_DIRSEP', DIRECTORY_SEPARATOR);
define( 'EGL_NO_ID',				-1 );
define( 'EGL_TIME',					time() );
define( 'EGL_CURRENT_VERSION',		'0.9.5' );
define( 'EGLFILE_PERMISSIONTREE', EGL_SECURE . 'gc'.EGL_DIRSEP.'permissiontree.gc' );

# unknown data for NULL references
$__DATA__	= NULL;


# basic includes, used for the egl-engine (whole)
require( EGL_SECURE.'utils'.EGL_DIRSEP.'string.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'egl_basics.utils.php' );

#============================================
# START SESSION
#============================================
require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Session.class.php' );
Session::Start();

# -[ global variables ] -

#============================================
# Set global template directories/path
#============================================


#============================================
# INIT GLOBAL TB-MANANGEMENT
#============================================
require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'DBTB.class.php' );
new DBTB();




#============================================
# INIT GLOBAL DEBUGGER SYSTEM
#============================================
require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Debugger.class.php' );
require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PHPErrorHandler.class.php' );
//new PHPErrorHandler();


define( 'EGLDIR_PHOTOS',				'files/photo_pool/' );
define( 'EGLDIR_LOGOS',					'files/logo_pool/' );
define( 'EGLDIR_GAMES',					'files/game_pool/' );
define( 'EGLDIR_COUNTRY',				'files/country_pool/' );
define( 'EGLDIR_MEDIA',					'files/media_pool/' );
define( 'EGLDIR_GAMEACC_REPORTS',		'files/gameaccreports_pool/' );
define( 'EGLDIR_NEWS_IMAGES',			'files/news_pool/' );


define( 'EGL_COOKIETIME',				EGL_TIME + 3600*24*31*12 ); /* 1 year */

define( 'EGL_DEBUGSECURITY_LOW',		1 );
define( 'EGL_DEBUGSECURITY_MIDDLE',		2 );
define( 'EGL_DEBUGSECURITY_HIGH',		3 );




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
	var $cScriptProfiler		= NULL;		# Script Profiler
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
	var $sURLFile				= '';		# current loaded file
	var $sURLPage				= '';		# current loaded page
	var $sURLPageSection		= '';
	var $sURLModule				= '';		# current loaded module-id
	var $sURLRealPage			= '';
	var $sURLDomainRoot			= '';		
	#----------------------------------
	
	var $cModuleManager			= NULL;			# Module Managementsystem
	var $oModule				= NULL;			# current module, loaded by url
	var $sModuleId				= EGL_NO_ID;	# current module-id
	var $bModuleActivated		= false;		# module currently loaded, according to url-module-id [page={MODULE_ID}:page_name]
	var $bModuleURLAttempt		= false;		# only on url, module_id
	var $oStatictics			= NULL;	
	var $bAutoloadModules		= true;		
	
	#----------------------------------
	
	var $aLngBuffer				= array();
	var $sLanguage				= '';
	
	function global_vars_t(){
		//$this->pcRuntimeEngine = new RuntimeEngine(NULL);
		
		
	}
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
require_once( EGL_LIBS . 'phpmailer'.EGL_DIRSEP.'class.phpmailer.php');

# [configs]
require( EGL_SECURE.'configs'.EGL_DIRSEP.'db_settings.cfg.php');
require( EGL_SECURE.'configs'.EGL_DIRSEP.'pw_settings.cfg.php' );
require( EGL_SECURE.'configs'.EGL_DIRSEP.'table_settings.cfg.php');
require( EGL_SECURE.'configs'.EGL_DIRSEP.'emails.cfg.php');
require( EGL_SECURE.'configs'.EGL_DIRSEP.'domain.cfg.php');


# [utils]
require( EGL_SECURE.'utils'.EGL_DIRSEP.'math.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'other.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'array.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'smarty_tools.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'module_api.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'time_format.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'system.utils.php' );
require( EGL_SECURE.'utils'.EGL_DIRSEP.'binary.utils.php' );


# ---------------------------------------------
# [EGL STREAM classes]
# ---------------------------------------------

#egl_require( EGL_SECURE."classes/streams/buffer_stream.class.php" );
#egl_require( EGL_SECURE."classes/streams/inputstream.class.php" );
#egl_require( EGL_SECURE."classes/streams/outputstream.class.php" );

#egl_require( EGL_SECURE."classes/streams/socket.class.php" );
#egl_require( EGL_SECURE."classes/streams/client_socket.class.php" );
#egl_require( EGL_SECURE."classes/streams/server_socket.class.php" );

#========================================================================================================================
# [EGL CORE classes]
#========================================================================================================================


# ---------------------------------------------
# CORE - System
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'DBConnection.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'DBInterfaceFactory.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'UnknownSQLCon.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'db'.EGL_DIRSEP.'DBConfigs.class.php' );		# egl config class


# ---------------------------------------------
# CORE - System
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'system'.EGL_DIRSEP.'IniFile.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'system'.EGL_DIRSEP.'MyDirectory.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'system'.EGL_DIRSEP.'FileManager.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'system'.EGL_DIRSEP.'File.class.php' );


# ---------------------------------------------
# CORE - Template
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'template'.EGL_DIRSEP.'Templates.class.php' );



# ---------------------------------------------
# CORE - Scheduler
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'schedule'.EGL_DIRSEP.'Timer.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'schedule'.EGL_DIRSEP.'Bench.class.php' );



# ---------------------------------------------
# CORE - Callbacks
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'callback'.EGL_DIRSEP.'CallbackManager.class.php' );


# ---------------------------------------------
# CORE - Module
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'module'.EGL_DIRSEP.'Module.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'module'.EGL_DIRSEP.'ModuleManager.class.php' );


# ---------------------------------------------
# SOAP/Client,Server Service
# ---------------------------------------------
//egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'soap'.EGL_DIRSEP.'ServiceClient.class.php' );
//egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'soap'.EGL_DIRSEP.'ServiceServer.class.php' );


# ---------------------------------------------
# CORE - Loader
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'loader'.EGL_DIRSEP.'LicenseLoader.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'loader'.EGL_DIRSEP.'FunctionLoaderFactory.class.php' );


# ---------------------------------------------
# CORE
# ---------------------------------------------
//egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Debugger.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Logs.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Document.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PermissionTree.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PageAccess.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PAEvaluator.class.php' );

#egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'ConfigLoader.class.php' );
#egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Download.class.php' );
#egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PageSecure.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Language.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'Mails.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'WebcomInterface.class.php' );
//egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'PHPErrorHandler.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'ScriptProfiler.class.php' );


# ---------------------------------------------
# Update'.EGL_DIRSEP.'Upgrade
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'update'.EGL_DIRSEP.'InstallFactory.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'update'.EGL_DIRSEP.'UpdateFactory.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'update'.EGL_DIRSEP.'UpdateProtocol.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'core'.EGL_DIRSEP.'update'.EGL_DIRSEP.'UpdateScriptCaller.class.php' );


# ---------------------------------------------
# XML
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'xml'.EGL_DIRSEP.'XMLReaderFactory.class.php' );




#========================================================================================================================
# [EGL CMS BASICS classes]
#========================================================================================================================
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'OnlineList.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'UploadFile.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Protests.class.php' );

egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Administrator.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Login.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Member.class.php' );		
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'MemberHistory.class.php' );		
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Team.class.php' );		
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'PM.class.php' );	
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Photo.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Logo.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Clan.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Comments.class.php' );

egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'GamePool.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Country.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Match.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'MatchReports.class.php' );

egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Media.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'GameAccounts.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'MatchStructures.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'MyCategory.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'DownloadManager.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'Calculator.class.php' );
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'AttachmentEngine.class.php' );

egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'MapCollections.class.php' );


egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'cms'.EGL_DIRSEP.'PageNavigation.class.php' );

# ---------------------------------------------
# [EGL CMS ENVIRONMENT classes]
# ---------------------------------------------
egl_require( EGL_SECURE.'classes'.EGL_DIRSEP.'environment'.EGL_DIRSEP.'BrowserSettings.class.php' );



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
		//$gl_oVars->pcRuntimeEngine	= new RuntimeEngine( $runtime_name );
		$GLOBALS['gl_oVars']->pcRuntimeEngine 	= &$this;
		
		
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
			$gl_oVars->cDebugger->SetOutputDir( 'output'.EGL_DIRSEP );

			# set template vars
			$gl_oVars->cDebugger->SetTemplateValues( 'output.tpl',
													 EGL_SECURE.'debug'.EGL_DIRSEP.'templates'.EGL_DIRSEP,
													 EGL_SECURE.'configs'.EGL_DIRSEP,
													 EGL_SECURE.'debug'.EGL_DIRSEP.'templates_c'.EGL_DIRSEP,
													 EGL_SECURE.'debug'.EGL_DIRSEP.'cache'.EGL_DIRSEP );

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
		// (2) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'PostgreSQLCon' );*/
		// (3) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'ODBCCon' );		=> not implemented*/
		// (4) => $gl_oVars->cDBInterface	= DBInterface::DBInterface( 'OracleCon' );	=> not implemented*/
		// $gl_oVars->oDBConnectingData	= new db_connection();

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
		
		
		
		$workspace_root = EGL_SECURE.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP;
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
		$gl_oVars->sURLRealPage			= $gl_oVars->sURLPage;
		$gl_oVars->aPageSections		= explode( '.', $gl_oVars->sURLPage );
		$gl_oVars->sURLFile				= $_SERVER['PHP_SELF'];							# set current base file
		$gl_oVars->sURLDomainRoot		= 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';
		
		//$gl_oVars->sLanguage			= $_SESSION['usr']['language'];					# get language
		//$gl_oVars->sURLPageSection 	= $gl_oVars->sURLSection = substr( $gl_oVars->sURLPage, 0, strpos( $gl_oVars->sURLPage, '/' ) );
		
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
		if( !$this->GetSelectedLanguage() ){
			$this->SelectLanguage( 'de' );
		}
	

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
		/*$gl_oVars->cTpl->assign( 'LANGUAGE', $this->GetSelectedLanguage() );
		if( $gl_oVars->cLanguage->SetLanguage( $this->GetSelectedLanguage() ) )	# set language
		{
			// success?
		}*/

		
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


		# parsing language file, receiving output to '$gl_oVars->aLngBuffer['basic']'
		$gl_oVars->cLanguage->SetLanguage( $this->GetSelectedLanguage() );
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
	* if current page has been accessed by the PageAccess protocol, the last check is based on that routine
	* normaly it returns 1 for success
	*
	*
	**/
	function PageAccessCheck(){return 1;}

	
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
		
		$gl_oVars->cTpl->assign( 'LANGUAGE', $this->GetSelectedLanguage() );
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

		# ----------------------------------------------
		# load modules
		# ----------------------------------------------
		if( $gl_oVars->bAutoloadModules )
		{
			// load modules
			$gl_oVars->cModuleManager->LoadModules();
			
			
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
		}// load modules
			
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
			$gl_oVars->cTpl->assign( "BENCH_TIME", round( $gl_oVars->cBench->runTime(), 3) );
			# catch output
			$this->ReleaseShutdown();
			
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
		$this->ReleaseShutdown();
	}
	
	
	/**
	* shutdown egl system core
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function ReleaseShutdown()
	{
		$aLicenseProperties = LicenseLoader::GetLicenseData();
		$hashed_license_key = md5( $aLicenseProperties['key']['value'] );
		
		print( "<!--" );
		print( "\n #########################################################################################################################" );
		print( "\n EGL.net - Electronic Gaming League, generated with v".EGL_CURRENT_VERSION." - ".strftime("%d.%m.%y %H:%M:%S", EGL_TIME ));
		print( "\n Copyright(c) 2004-2007 by Inetopia. Professional E-Sport Solutions. Visit www.inetopia.de" );
		print( "\n Used license {$hashed_license_key} " );
		print( "\n" );
		print( "\n Project & support - http://www.electronicgamingleague.de" );
		print( "\n Forums - http://www.electronicgamingleague.de/forum/" );
		print( "\n Development & Publishment 2004-2007 by Inetopia. All rights reserved. Alle Rechte vorbehalten." );
		print( "\n #########################################################################################################################" );
		print( "\n-->\n\n" );
		
		global $gl_oVars;
		if( $gl_oVars->sWorkspace != 'admin' &&
			$gl_oVars->sWorkspace != 'services' &&
			$gl_oVars->sWorkspace != 'managedcrons' &&
			$this->CheckV() != md5('aA2dsa284mkdf94d004axmyn74zruepand') ){
			//$this->content_check($hashed_license_key);
			

		}//if
	}
	
	
	/**
	 * GetHeaderAdvertisement
	 */
	/*
	function content_check($string)
	{
		// Advertisement
		$advertisement_domain	= 'electronicgamingleague.de';
		$advertisement_url 		= 'http://localhost/EGL/Beta2/Source/Web/EGL_ROOT/public/advertisement.php?license_key='.$string;
		
		if( domain_check($advertisement_domain,1) == 'ok'){
			$f = @fopen( $advertisement_url, "r" );
			if( $f ){
				$html='';
				while (!feof($f)){ $html.=@fread($f, (1*(1024*1024)));  }
				print($html);
				fclose($f);
			}//if
		}//if domain available
		else{
			// check failed
		}
	}*/


	/**
	* select language buffer, stored in language files
	*
	* @return 	boolean 	true(1)/false(0)
	**/
	function SelectLanguage( $lng )
	{
		global $gl_oVars;
		$gl_oVars->sLanguage = $lng;
		$_SESSION['member']['lng'] = $lng;
		return true;
	}
	
	
	/**
	* get selected language
	*
	* @return 	language-token-string - e. 'de', 'eng'
	**/
	function GetSelectedLanguage(){
		global $gl_oVars;
		if( !$gl_oVars->sLanguage ) 
			if( $_SESSION['member']['lng'] )
				$gl_oVars->sLanguage = $_SESSION['member']['lng'];
			else 
				$this->DefaultLanguage();
		return $gl_oVars->sLanguage;
	}
	
	/**
	 * setup default language
	 */
	function DefaultLanguage(){
		$this->SelectLanguage( 'de' );
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
	function IsOfflineMode(){
		
		
		return 0;
	}
	
	
	function CheckV(){ return '';}
};
?>