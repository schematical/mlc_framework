<?php
define('__MODEL_APP_DATALAYER_DIR__', __MODEL_MDE_APP_DIR__ . '/data_classes');

define('__MODEL_APP_CONTROL__', __MODEL_MDE_APP_DIR__ . '/ctl_classes');

define('__MODEL_APP_API__', __MODEL_MDE_APP_DIR__ . '/api_classes');
define('__MODEL_APP_ENTITY_MODEL__', __MODEL_MDE_APP_DIR__ . '/entity_model');
if(!defined('SKIP_DATALAYER')){
	require_once(__MODEL_APP_DATALAYER_DIR__ . '/base_classes/Conn.inc.php');
	require_once(__MODEL_APP_CONTROL__ . '/base_classes/ControlConn.inc.php');
	if(file_exists(__MODEL_APP_CONTROL__ . '/Jetstrap.inc.php')){
		require_once(__MODEL_APP_CONTROL__ . '/Jetstrap.inc.php');
	}
}
require_once(__MODEL_MDE_APP_DIR__ . '/_enum.inc.php');
MLCApplication::InitPackage('MJax');
MLCApplication::InitPackage('MJaxBootstrap');
MLCApplication::InitPackage('MLCAuth');
MLCApplication::InitPackage('MDETools');
MLCApplication::InitPackage('MLCDataLayer');
MLCApplication::InitPackage('MJaxTracking');
MLCApplication::InitPackage('MLCJetstrap');
MLCApplication::InitPackage('MLCSalesTools');
//MLCApplicationBase::$arrClassFiles['CustomClass'] = __MODEL_MDE_APP_DIR__ . '/CustomClass.class.php';

if(class_exists('MLCAuthDriver')){
	MLCAuthDriver::SetCookieDomain('schematical.com');
}
switch(SERVER_ENV){
    case('local'):
        MLCApplication::$objRewriteHandeler->AssetMode = MLCRewriteAssetMode::LOCAL;
    break;
    default:
    case('prod'):
        MLCApplication::$objRewriteHandeler->AssetMode = MLCRewriteAssetMode::S3;
    break;
}
define('__ASSETS_URL__', MLCApplication::GetAssetUrl(''));
define('__ASSETS__', __ASSETS_URL__ . '');
define('__ASSETS_JS__', __ASSETS__ . '/js');
define('__ASSETS_CSS__', __ASSETS__ . '/css');
define('__ASSETS_IMG__', __ASSETS__ . '/imgs');



