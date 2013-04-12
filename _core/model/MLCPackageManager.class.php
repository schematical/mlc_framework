<?php
abstract class MLCPackageManager{
    public static function UpdateDependancies(){

        //Curl out and get the repo url
        foreach(MLCApplication::$arrPackages as $strPackageName => $intIgnore){
            MLCPackageManager::InstallPackage($strPackageName, __INSTALL_ROOT_DIR__);
        }
    }

    protected static function _sh($strShell){
        return shell_exec($strShell);
    }

    public static function InstallApp($strApp, $strRootDir = null){
        if(defined('__INSTALL_ROOT_DIR__')){
            $strRootDir;
        }elseif(is_null($strRootDir)){
            throw new Exception("Undefined RootDir!!");
        }
        $arrAppData = MLCPackageManager::CurlHome(
            '/apps/'. $strApp
        );
        $strAppDir = $strRootDir . '/apps/' . $strApp;
        if(is_dir($strAppDir)){
            $strRollBackDir = $strAppDir . '_' . date("Y-m-d H:i:s");
            rename($strAppDir, $strRollBackDir);
            error_log("Roll back dir: " . $strRollBackDir);
        }
        if(strlen($arrAppData['repoUrl']) < 2){
            throw new Exception("Not a valid repo url for app '" . $strApp . '"');
        }
        MLCPackageManager::_sh(
            sprintf(
                "git clone %s %s",
                $arrAppData['repoUrl'],
                $strAppDir
            )
        );
    }
    public static function DeployAppToAWS(){
        if(defined('__INSTALL_ROOT_DIR__')){
            $strRootDir;
        }elseif(is_null($strRootDir)){
            throw new Exception("Undefined RootDir!!");
        }
        $strAppDir = $strRootDir . '/apps/' . $strApp;


        $this->blnSuccess = MLCAWSDriver::S3()->putObjectFile(
            $strAppDir .'/_core/assets',
            AWS_ASSET_PATH,
            $this->S3FullPath,
            $this->strS3Mode
        );
    }
    public static function InstallPackage($strPackageName, $strRootDir){
        $arrPackageData = MLCPackageManager::CurlHome('/packages/' . $strPackageName);
        $strPackageDir = $strRootDir . '/packages/' . $strPackageName;
        if(is_dir($strPackageDir)){
            $strRollBackDir = $strPackageDir . '_' . date("Y-m-d H:i:s");
            rename($strPackageDir, $strRollBackDir);
            error_log("Roll back dir: " . $strRollBackDir);
        }
        if(strlen($arrPackageData['repoUrl']) < 2){
            throw new Exception("Not a valid repo url for package '" . $strPackageName . '"');
        }
        MLCPackageManager::_sh(
            sprintf(
                "git clone %s %s",
                $arrPackageData['repoUrl'],
                $strPackageDir
            )
        );
    }
    protected static function CurlHome($strEndpoint, $arrData = array()){
        $tuCurl = curl_init();
        $strUrl = "http://mde.schematical.com/api" . $strEndpoint;
        error_log($strUrl);
        curl_setopt($tuCurl, CURLOPT_URL, $strUrl);
        curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
        curl_setopt($tuCurl, CURLOPT_HEADER, 0);
        curl_setopt($tuCurl, CURLOPT_POST, 0);
        curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $arrData);

        $strData = curl_exec($tuCurl);
        error_log($strData);
        $arrData =  json_decode($strData, true);
        if(array_key_exists('error', $arrData['head'])){
            throw new Exception($arrData['head']['error']);
        }
        return $arrData['body'];
    }
}