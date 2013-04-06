<?php
if(!defined('SERVER_ENV')){
	switch($_SERVER['SERVER_NAME']){
		case('api.schematical.com'):
			define('SERVER_ENV', 'lab');
		break;
		case('local-api.schematical.com'):
			define('SERVER_ENV', 'local');
		break;
	}
}
define('__TMP_DIR__', __INSTALL_ROOT_DIR__ . '/tmp');
define('__APP_DIR__', __INSTALL_ROOT_DIR__ . '/apps');
switch(SERVER_ENV){
    case('local'):
        define('__PACKAGE_DIR__', '/var/www/MLCPackages/mlc_packages');
    break;
    default:
        define('__PACKAGE_DIR__', __INSTALL_ROOT_DIR__ . '/packages');
}

