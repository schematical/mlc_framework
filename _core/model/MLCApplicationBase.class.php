<?php
abstract class MLCApplicationBase{

	public static $arrPackages = array();
	public static $arrClassFiles = array();
	public static $strInitedApp = null;
	public static $strCtlFile = null;
	public static $arrTriggers = array();
	public static $objRewriteHandeler = null;
	
	public static function Init($strApp = null, $strEnv = null){
		$arrApps = array();
	
		if(!is_null($strApp)){
			MLCApplicationBase::$strInitedApp = $strApp;
			if(!is_null($strEnv)){
				define('SERVER_ENV', $strEnv);
			}			
		}else{
			//Go through each app in the app dir 
			if ($resHandle = opendir(__INSTALL_ROOT_DIR__ . '/apps/')) {
			    /* This is the correct way to loop over the directory. */
			    while (false !== ($strEntry = readdir($resHandle))) {
			    	if(
						($strEntry != '.') &&
						($strEntry != '..')
					){
			       		$arrApps[$strEntry] = $strEntry;
					}
			    }			
			    closedir($resHandle);
			}
			
			foreach($arrApps as $strAppName => $strAppName){
				if(!defined('MLC_APPLICATION_NAME')){
					require(__APP_DIR__ . '/' . $strAppName . '/env.inc.php');
				}
			}
		}
		if(!defined('MLC_APPLICATION_NAME')){
			throw new Exception("Not a valid app name");	
		}else{
			MLCApplicationBase::$strInitedApp =  MLC_APPLICATION_NAME;
			define('__MODEL_' . MLC_APPLICATION_PREFIX . '_APP_DIR__', __APP_DIR__ . '/' . MLC_APPLICATION_NAME . '/model');
			define('__VIEW_' . MLC_APPLICATION_PREFIX . '_APP_DIR__', __APP_DIR__ . '/' . MLC_APPLICATION_NAME .'/view');
			define('__CTL_' . MLC_APPLICATION_PREFIX . '_APP_DIR__', __APP_DIR__ . '/' . MLC_APPLICATION_NAME . '/ctl');
			define('__ASSETS_' . MLC_APPLICATION_PREFIX . '_APP_DIR__', __APP_DIR__ . '/' . MLC_APPLICATION_NAME . '/assets');
			
			define('__MODEL_ACTIVE_APP_DIR__', constant('__MODEL_' . MLC_APPLICATION_PREFIX . '_APP_DIR__'));
			define('__VIEW_ACTIVE_APP_DIR__', constant( '__VIEW_' . MLC_APPLICATION_PREFIX . '_APP_DIR__'));
			define('__CTL_ACTIVE_APP_DIR__', constant( '__CTL_' . MLC_APPLICATION_PREFIX . '_APP_DIR__'));
			define('__ASSETS_ACTIVE_APP_DIR__', constant( '__ASSETS_' . MLC_APPLICATION_PREFIX . '_APP_DIR__'));
		
		}
		if(is_null(MLCApplication::$objRewriteHandeler)){
			MLCApplication::$objRewriteHandeler = new MLCRewriteHandelerBase();
		}
		require_once(__APP_DIR__ . '/' . MLCApplicationBase::$strInitedApp . '/app.inc.php');
	}
	
	public static function Autoload($strClassName){
		if(array_key_exists($strClassName, self::$arrClassFiles)){
			require_once(MLCApplicationBase::$arrClassFiles[$strClassName]);
		}elseif(class_exists('CFLoader', false)){
			//MAD FUCKING HACK FOR Amazons lame service
			CFLoader::autoloader($strClassName);
		}else{
			throw new Exception("Can not auto load class '" . $strClassName . "'");
		}
	}
	public static function Run(){
		
	}
	public static function InitPackage($strPackageName){
		//throw new Exception($strPackageName);
		if(array_key_exists($strPackageName, MLCApplicationBase::$arrPackages)){
			return;
			throw new Exception("Package already loaded '" . $strPackageName . "'");
		}
	   $arrMLCClassFiles = array();
	   $strPackageDir = __PACKAGE_DIR__ . '/' . $strPackageName;
	   if(!is_dir($strPackageDir)){
			throw new Exception(sprintf("Package '%s' not found", $strPackageName));
	   }
	   require_once($strPackageDir . '/package.inc.php');
	   if(count($arrMLCClassFiles) > 0){
	   		array_merge(MLCApplicationBase::$arrClassFiles, $arrMLCClassFiles);
	   }
	   MLCApplicationBase::$arrPackages[$strPackageName] = 1;
	   
	}
	public static function GetInstalledPackageNames(){
		$arrInstalledPackages = array();
		if ($resHandeler = opendir(__PACKAGE_DIR__)) {
		   
		    while (false !== ($strFile = readdir($resHandeler))) {
		        //IM A DIR
		        $arrInstalledPackages[] = $strFile;
		    }
			
			closedir($resHandeler);
		}
		return $arrInstalledPackages;
	}
	public static function GetInstalledPackages(){
		$arrInstalledPackageNames = self::GetInstalledPackageNames();
		$arrReturn = array();
		foreach($arrInstalledPackageNames as $intIndex => $strPackage){
			$arrReturn[] = new MLCPackage($strPackage);
		}
		return $arrReturn;
	}
	public static function GetInstalledAppNames(){
		$arrInstalledApps = array();
		if ($resHandeler = opendir(__APPS_DIR__)) {
		   
		    while (false !== ($strFile = readdir($resHandeler))) {
		        //IM A DIR
		        $arrInstalledApps[] = $strFile;
		    }
			
			closedir($resHandeler);
		}
		return $arrInstalledApps;
	}
	public static function OutputPage($strOutput){
		return $strOutput;
	}
	public final static function XmlEscape($strString) {
		if ((strpos($strString, '<') !== false) ||
			(strpos($strString, '&') !== false)) {
			$strString = str_replace(']]>', ']]]]><![CDATA[>', $strString);
			$strString = sprintf('<![CDATA[%s]]>', $strString);
		}

		return $strString;
	}
	public static function RunModRewrite(){
		$strRewrite = $_SERVER['REQUEST_URI'];
		$arrParts = explode('?', $strRewrite);
		$strRewrite = $arrParts[0];
		MLCApplicationBase::$objRewriteHandeler->Handel($strRewrite);
		$strCtlFileLoc = MLCApplication::$strCtlFile;
		$arrPathParts = pathinfo($strCtlFileLoc);
		switch($arrPathParts['extension']){
			case('css'):
				header("Content-type: text/css");
			break;
			case('js'):
				header("content-type: application/x-javascript");
			break;
			
		}
		//die($strCtlFileLoc);
		if(file_exists($strCtlFileLoc)){
			require_once($strCtlFileLoc);
		}else{
			die('404');//TODO: add this
		}
	}
	public static function RunApi(){		
		MLCApplication::InitPackage('MLCApi');
		
		MLCApiDriver::Run('MLCApiHome');
	}
	public static function RunBatch(){
		MLCApplication::InitPackage('MLCBatch');
		MLCBatchDriver::Init();
		require_once(__MODEL_ACTIVE_APP_DIR__ . '/_batch.inc.php');
		MLCBatchDriver::Exicute();
		MLCBatchDriver::Report();
	}
	public static function AddTrigger($strEvent, $objTrigger){
		if(!array_key_exists($strEvent, self::$arrTriggers)){
			self::$arrTriggers[$strEvent] = array();
		}
		self::$arrTriggers[$strEvent][] = $objTrigger;
	}
	public static function Trigger($strEvent, $arrData = null){
		if(!array_key_exists($strEvent, self::$arrTriggers)){
			//_dp(self::$arrTriggers);		
			return false;
		}
		foreach(self::$arrTriggers[$strEvent] as $intIndex => $objTrigger){
			$objTrigger->Trigger($arrData);
		}
	}
	public static function GetAssetUrl($strUrl, $strNamespace = null){
		return self::$objRewriteHandeler->GetAssetUrl($strUrl, $strNamespace);
	}
}
