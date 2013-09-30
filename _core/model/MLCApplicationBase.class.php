<?php
abstract class MLCApplicationBase{
    public static $strPackageRequireMode = 'FAIL_IF_NOT_FOUND';
	public static $arrPackages = array();
	public static $arrClassFiles = array();
	public static $strInitedApp = null;
	public static $strCtlFile = null;
	public static $arrTriggers = array();
	public static $objRewriteHandeler = null;
	
	public static function Init($strApp = null, $strEnv = null){

        if(
            (array_key_exists('REQUEST_URI', $_SERVER)) &&
            ($_SERVER['REQUEST_URI'] == '/_lb.html')
        ){
            //TODO Fix this
            die("DOING FINE!");
        }
	
		if(
            (!is_null($strApp))
        ){
			MLCApplicationBase::$strInitedApp = $strApp;
            define('MLC_APPLICATION_NAME', MLCApplicationBase::$strInitedApp);
			if(!is_null($strEnv)){
				define('SERVER_ENV', $strEnv);
			}			
		}elseif(defined('MLC_APPLICATION_NAME')){
            MLCApplicationBase::$strInitedApp = MLC_APPLICATION_NAME;
            $strEnvLoc = __APP_DIR__ . '/' . MLCApplicationBase::$strInitedApp . '/env.inc.php';
            if(file_exists($strEnvLoc)){
                require($strEnvLoc);
            }
        }else{
           $arrApps = MLCApplication::GetInstalledAppNames();
			
			foreach($arrApps as $strAppName => $strAppName){
				if(!defined('MLC_APPLICATION_NAME')){
                    $strEnvLoc =__APP_DIR__ . '/' . $strAppName . '/env.inc.php';
                    if(file_exists($strEnvLoc)){
					    require($strEnvLoc);
                    }
				}
			}
		}
		if(!defined('MLC_APPLICATION_NAME')){
			throw new Exception("No app registered to: " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
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
        //error_log("Autoloading: " . $strClassName);
		if(array_key_exists($strClassName, self::$arrClassFiles)){
			require_once(MLCApplicationBase::$arrClassFiles[$strClassName]);
		}elseif(class_exists('CFLoader', false)){
			//MAD HACK FOR Amazons lame service
			CFLoader::autoloader($strClassName);
		}else{
			throw new Exception("Can not auto load class '" . $strClassName . "'");
		}
	}
	public static function Run(){
		
	}
	public static function InitPackage($strPackageName){

            if(array_key_exists($strPackageName, MLCApplicationBase::$arrPackages)){
                return;
                throw new Exception("Package already loaded '" . $strPackageName . "'");
            }
           $_MLC_CLASSES = array();
           $arrPackageDirs = explode(':', __PACKAGE_DIR__);
           $strPackageDir = null;
           foreach($arrPackageDirs as $intIndex => $strDir){
               if(is_dir($strDir . '/' . $strPackageName)){
                   $strPackageDir = $strDir . '/' . $strPackageName;
               }
           }
           if(is_null($strPackageDir)){
               if(MLCApplication::$strPackageRequireMode == MLCPackageRequireMode::FAIL_IF_NOT_FOUND){
                    throw new Exception(sprintf("Package '%s' not found", $strPackageName . ' - ' . MLCApplication::$strPackageRequireMode));
               }elseif(MLCApplication::$strPackageRequireMode == MLCPackageRequireMode::FORCE_PULL_FROM_GIT){
                   MLCPackageManager::InstallPackage($strPackageName, __INSTALL_ROOT_DIR__);
                   if(!file_exists($strPackageDir . '/package.inc.php')){
                       throw new Exception("Failed to pull down application");
                   }
               }
           }

           require_once($strPackageDir . '/package.inc.php');

            if(count($_MLC_CLASSES) > 0){
                MLCApplicationBase::$arrClassFiles = array_merge(MLCApplicationBase::$arrClassFiles, $_MLC_CLASSES);
           }
           MLCApplicationBase::$arrPackages[$strPackageName] = 1;

	   
	}
	public static function GetInstalledPackageNames(){
		$arrInstalledPackages = array();
        $arrPackageDirs = explode(':', __PACKAGE_DIR__);
        $strPackageDir = null;
        foreach($arrPackageDirs as $intIndex => $strDir){
            if(
                (is_dir($strDir)) &&
                ($resHandeler = opendir($strDir))
            ){

                while (false !== ($strFile = readdir($resHandeler))) {
                    //IM A DIR
                    if(
                        (substr($strFile,0,1) != '.')
                    ){
                        //$arrInstalledPackages[$strFile] = str_replace(__INSTALL_ROOT_DIR__, '', $strdir) . '/' . $strFile;
                        $arrInstalledPackages[$strFile] =  $strDir . '/' . $strFile;
                    }
                }

                closedir($resHandeler);
            }
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
		if ($resHandeler = opendir(__APP_DIR__)) {
		   
		    while (false !== ($strFile = readdir($resHandeler))) {
		        //IM A DIR
                if(
                    ($strFile != '.') &&
                    ($strFile != '..')
                ){
		            $arrInstalledApps[$strFile] = $strFile;
                }
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
    public static function QS($strName){
        if(!array_key_exists($strName, $_GET)){
            return null;
        }
        return $_GET[$strName];
    }
	public static function RunModRewrite(){
		$strRewrite = $_SERVER['REQUEST_URI'];
		$arrParts = explode('?', $strRewrite);
		$strRewrite = $arrParts[0];
		MLCApplicationBase::$objRewriteHandeler->Handel($strRewrite);
		$strCtlFileLoc = MLCApplication::$strCtlFile;


		if(file_exists($strCtlFileLoc)){

            if(MLCApplicationBase::$objRewriteHandeler->IsAsset){

                $arrPathParts = pathinfo($strCtlFileLoc);
                
                if(array_key_exists('extension', $arrPathParts)){

                    switch($arrPathParts['extension']){
                        case('css'): header("Content-type: text/css"); break;
                        case('js'):  header("content-type: application/x-javascript");break;
                        case "pdf":  header("application/pdf"); break;
                        case "exe":  header("content-type: application/octet-stream"); break;
                        case "zip":  header("content-type: application/zip"); break;
                        case "doc":  header("content-type: application/msword"); break;
                        case "xls":  header("content-type: application/vnd.ms-excel"); break;
                        case "ppt":  header("content-type: application/vnd.ms-powerpoint"); break;
                        case "gif":  header("content-type: image/gif"); break;
                        case "png":  header("content-type: image/png"); break;
                        case "jpeg":
                        case "jpg":  header("content-type: image/jpg"); break;
                    }
                }
                die(file_get_contents($strCtlFileLoc));

            }else{

			    die(require_once($strCtlFileLoc));
            }
		}else{
            header("HTTP/1.0 404 Not Found");
            $str404Loc = __CTL_ACTIVE_APP_DIR__ . '/_404.php';
            if(!file_exists($str404Loc)){
                $str404Loc = __MLC_CORE_VIEW__ . '/404.html';
            }
            die(require_once($str404Loc));
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
    public static function FindPackageDir($strPackageName){
        $arrPackageDirs = explode(':', __PACKAGE_DIR__);
        foreach($arrPackageDirs as $intIndex => $strPackageDir){
            $strFullPackageDir = $strPackageDir . '/' . $strPackageName;
            if(is_dir($strFullPackageDir)){
                return $strFullPackageDir;
            }
        }
        return null;
    }

}
