<?php
abstract class MLCApplicationBase{
	public static $arrPackages = array();
	public static $arrClassFiles = array();
	public static $strInitedApp = null;
	public static $strCtlFile = null;
	
	public static function Init($strApp = 'main'){
		
		MLCApplicationBase::$strInitedApp = $strApp;
		
		require_once(__MODEL_APPS_DIR__ . '/' . MLCApplicationBase::$strInitedApp . '/app.inc.php');
		
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
	   $strPackageDir = __MODEL_PACKAGE_DIR__ . '/' . $strPackageName;
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
		if ($resHandeler = opendir(__MODEL_PACKAGE_DIR__)) {
		   
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
		if ($resHandeler = opendir(__MODEL_APPS_DIR__)) {
		   
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
		
		if($strRewrite == '/'){
			$strRewrite = '/index.php';
		}
		MLCApplication::$strCtlFile = $strRewrite;
		require_once(__CTL_ACTIVE_APP_DIR__ . $strRewrite);
	}
	public static function RunApi(){
		MLCApplication::InitPackage('MLCApi');
		MLCApiDriver::Run('MLCApiHome');
	}
}
