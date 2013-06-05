<?php 
class MLCRewriteHandelerBase{
	const ASSETS = 'assets';
    const API = 'api';
    const ADMIN = 'admin';
	protected $strAssetMode = null;
    protected $blnIsAsset = false;
	public function Handel($strUri){
		$arrParts = explode('/', $strUri);
		if($arrParts[1] == self::ASSETS){
            $this->blnIsAsset = true;
			return self::RunAssets($strUri);
		}

        if($arrParts[1] == self::API){
            MLCApplication::$strCtlFile = __MLC_CORE_CTL__ . '/api/handeler.php';
            return MLCApplication::$strCtlFile;
        }
        if($arrParts[1] == self::ADMIN){
            return self::SearchInstalledForCtl('ctl/admin', $strUri);
        }
		if(is_dir(__CTL_ACTIVE_APP_DIR__ . $strUri)){
			$strCtlFile = $strUri . '/index.php';
		}else{
			
			if(strlen($arrParts[count($arrParts) - 1]) == 0){
				$arrParts[count($arrParts) - 1] = 'index.php';
			}
			$strCtlFile = implode('/', $arrParts);
		}
        $strExtension = pathinfo($strCtlFile, PATHINFO_EXTENSION);
        $strFileName = pathinfo($strCtlFile, PATHINFO_FILENAME);
        $strDirName = dirname($strCtlFile);
        define("MLC_CALL_EXTENSION", $strExtension);
        $strCtlFile = $strDirName . '/' . $strFileName . '.php';
		MLCApplication::$strCtlFile = __CTL_ACTIVE_APP_DIR__ . $strCtlFile;
		
		if(!file_exists(MLCApplication::$strCtlFile)){
			
			if(SERVER_ENV != 'prod'){
                if(!defined('MLC_DISPLAY_EXCEPTIONS')){
                    define('MLC_DISPLAY_EXCEPTIONS', '1');
                }
				//Allow access to _core control files such as _devtools
				MLCApplication::$strCtlFile = __MLC_CORE_CTL__ . $strCtlFile;
			}
		}
		
	}
	public function RunAssets($strUri){
        //die(SERVER_ENV . ' - ' . $this->strAssetMode);
		switch($this->strAssetMode){
			case(MLCRewriteAssetMode::S3):
				//return $this->RunS3Assets($strUri);
			break;
			case(MLCRewriteAssetMode::LOCAL):
			default:
				return $this->RunLocalAssets($strUri);
			break;
		}
	}
	
	public function RunLocalAssets($strUri){
       return self::SearchInstalledForCtl('assets', $strUri);
    }
    public function SearchInstalledForCtl($strDir, $strUri){
		$arrParts = explode('/', $strUri);
		$strBaseName = $arrParts[2];
		//Check active app
		$arrParts = array_slice($arrParts, 3);
		$strAssetLoc = '/' . implode('/', $arrParts);
		if($strBaseName == MLCApplication::$strInitedApp){
			return MLCApplication::$strCtlFile = __ASSETS_ACTIVE_APP_DIR__ . $strAssetLoc;
		}
		//Check core
		if($strBaseName == '_core'){
			return MLCApplication::$strCtlFile = __MLC_CORE_ASSETS__ . $strAssetLoc;
		}
        $arrPackageDirs = explode(':', __PACKAGE_DIR__);
        foreach($arrPackageDirs as $intIndex => $strPackageDir){
            //Check active packages
            $strPackageAssetDir = $strPackageDir . '/' . $strBaseName . '/' . $strDir;

            if(is_dir($strPackageAssetDir)){
                return MLCApplication::$strCtlFile =  $strPackageAssetDir. $strAssetLoc;
            }
            //Check active packages
            $strPackageAssetDir = $strPackageDir . '/' . $strBaseName . '/_core/' . $strDir;

            if(is_dir($strPackageAssetDir)){
                return MLCApplication::$strCtlFile =  $strPackageAssetDir. $strAssetLoc;
            }
        }
		
	}
	public function GetS3AssetUrl($strUri, $strNamespace = null){
        if(is_null($strNamespace)){
            $strPath = 'apps/' . MLC_APPLICATION_NAME;
        }else{
            $strPath = 'packages/' . $strNamespace;
        }
        //https://s3.amazonaws.com/mlc_mde/apps/mde/assets/js/Home.js
        $strUrl = sprintf(
            "//s3.amazonaws.com/%s/%s/assets%s",
             AWS_BUCKET,
            $strPath,
            $strUri
        );
        return $strUrl;
	}
	public function GetLocalAssetUrl($strUrl, $strNamespace = null){
		if(is_null($strNamespace)){
			$strNamespace = MLCApplication::$strInitedApp;
		}
		$strUrl = sprintf(
			'//%s/%s/%s%s',
			$_SERVER['SERVER_NAME'],
			self::ASSETS,
			$strNamespace,
			$strUrl
		);
		return $strUrl;
	}
    public function GetAssetUrl($strUrl, $strNamespace = null){
        switch($this->strAssetMode){
            case(MLCRewriteAssetMode::S3):
                return $this->GetS3AssetUrl($strUrl, $strNamespace);
            break;
            case(MLCRewriteAssetMode::LOCAL):
            default:
                return $this->GetLocalAssetUrl($strUrl, $strNamespace);
            break;
        }
    }
	public function __set($strName, $mixVal){
		switch($strName){
			case('AssetMode'):
				return $this->strAssetMode = $mixVal;
			break;
			default:
				throw new MLCMissingPropertyException($this, $strName);				
		}
	}
	public function __get($strName){
		switch($strName){
			case('AssetMode'):
				return $this->strAssetMode;
			break;
            case('IsAsset'):
                return $this->blnIsAsset;
                break;
			default:
				throw new MLCMissingPropertyException($this, $strName);				
		}
	}
}
