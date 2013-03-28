<?php

if(file_exists(dirname(__FILE__) .'/conf_generated.inc.php')){
	require(dirname(__FILE__) .'/conf_generated.inc.php');
}else{

	switch(MLC_APPLICATION_NAME){
		case('your_app_name'):	
			define('__ASSETS_URL__', '//assets.schematical.com');
			define('MLC_APPLICATION_PREFIX', 'MDE');
			define('__INSTALL_ROOT_DIR__', '/the/install/dir/of/this/app');
			define('DB_1', serialize(array(
				'host'=>'your_db_host',
				'db_name'=>'your_db',
				'user'=>'your_username',
				'pass'=>'your_password'
			)));
		break;
		default:	
	}
}










