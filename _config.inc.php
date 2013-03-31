<?php

if(!defined('__MLC_INITED__')){
	define('__MLC_INITED__', 1);
	define('__INSTALL_ROOT_DIR__', dirname(__FILE__));
	require(__INSTALL_ROOT_DIR__. '/_core/model/MLCApplicationBase.class.php');
	//Feel free to 
	
	class MLCApplication extends MLCApplicationBase{
		
	}
	
	require(__INSTALL_ROOT_DIR__. '/_core/env.inc.php');
	
	spl_autoload_register(array('MLCApplication', 'Autoload'));
	function __ob_callback($strBuffer) {		
		return MLCApplication::OutputPage($strBuffer);
	}
	ob_start('__ob_callback');
	
	require(__INSTALL_ROOT_DIR__. '/_core/MLC.inc.php');
	
	MLCApplication::Init();
	
		

	if(!defined('__ASSETS_URL__')){
		if(SERVER_ENV =='local'){
			define('__ASSETS_URL__', '//local-assets.schematical.com');	
		}else{
			define('__ASSETS_URL__', '//assets.schematical.com');
		}
	}
	
}
