<?php 
class MLCRewriteHandelerBase{
	const ASSETS = 'assets';
    const API = 'api';
	protected $strAssetMode = null;
	public function Handel($strUri){
		$arrParts = explode('/', $strUri);
		if($arrParts[1] == self::ASSETS){
			return self::RunAssets($strUri);
		}
        if($arrParts[1] == self::API){
            MLCApplication::$strCtlFile = __MLC_CORE_CTL__ . '/api/handeler.php';
            return MLCApplication::$strCtlFile;
        }
		if(is_dir(__CTL_ACTIVE_APP_DIR__ . $strUri)){
			$strCtlFile = $strUri . '/index.php';
		}else{
			
			if(strlen($arrParts[count($arrParts) - 1]) == 0){
				$arrParts[count($arrParts) - 1] = 'index.php';
			}
			$strCtlFile = implode('/', $arrParts);
		}
		MLCApplication::$strCtlFile = __CTL_ACTIVE_APP_DIR__ . $strCtlFile;
		
		if(!file_exists(MLCApplication::$strCtlFile)){
			
			if(SERVER_ENV != 'prod'){
				//Allow access to _core control files such as _devtools
				MLCApplication::$strCtlFile = __MLC_CORE_CTL__ . $strCtlFile;
			}
		}
		
	}
	public function RunAssets($strUri){
		switch($this->strAssetMode){
			case(MLCRewriteAssetMode::S3):
				return $this->RunS3Assets($strUri);
			break;
			case(MLCRewriteAssetMode::LOCAL):
			default:
				return $this->RunLocalAssets($strUri);
			break;
		}
	}
	
	public function RunLocalAssets($strUri){
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
		//Check active packages
		$strPackageAssetDir = __PACKAGE_DIR__ . '/' . $strBaseName . '/assets';
		
		if(is_dir($strPackageAssetDir)){
			return MLCApplication::$strCtlFile =  $strPackageAssetDir. $strAssetLoc;
		}
		//Check active packages
		$strPackageAssetDir = __PACKAGE_DIR__ . '/' . $strBaseName . '/_core/assets';
		
		if(is_dir($strPackageAssetDir)){			
			return MLCApplication::$strCtlFile =  $strPackageAssetDir. $strAssetLoc;
		}
		
	}
	public function RunS3Assets($strUri){
		
	}
	public function GetAssetUrl($strUrl, $strNamespace = null){
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
	public function __set($strName, $mixVal){
		switch($strName){
			case('AssetMode'):
				return $this->strAssetMode = $strVal;
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
			default:
				throw new MLCMissingPropertyException($this, $strName);				
		}
	}
}
