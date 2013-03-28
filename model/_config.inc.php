<?php
if(!defined('__MLC_INITED__')){
	define('__MLC_INITED__', 1);
	
	require(dirname(__FILE__) . '/env/config.inc.php');
	
	
	require(__MODEL_MLC_CORE__ . '/MLCApplicationBase.class.php');
	
	class MLCApplication extends MLCApplicationBase{
		
	}
	
	spl_autoload_register(array('MLCApplication', 'Autoload'));
	function __ob_callback($strBuffer) {
		error_log($strBuffer);		
		return MLCApplication::OutputPage($strBuffer);
	}
	ob_start('__ob_callback');
	
	require(__MODEL_MLC_CORE__ . '/MLC.inc.php');
	
	if(defined('MLC_APPLICATION_NAME')){
		$strApp = MLC_APPLICATION_NAME;
	}else{
		$strApp = null;
	}
	
	MLCApplication::Init($strApp);
	if(class_exists('MLCAuthDriver')){
		MLCAuthDriver::SetCookieDomain($_SERVER['SERVER_NAME']);
	}
}
