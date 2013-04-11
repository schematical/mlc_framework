<?php
define('SKIP_DATALAYER','true');
MLCApplication::InitPackage('MLCCodegen');
$arrOldData = unserialize(constant('DB_1'));
$arrDBData = array(
	1 => array(
		'hostname'=>$arrOldData['host'],
		'username'=>$arrOldData['user'],
		'password'=>$arrOldData['pass'],
		'dbname'=>$arrOldData['db_name']
	)
);

require('/var/www/MLCPackages/mlc_packages/private_packages/MLCCodegen/1.0/config/MDE.inc.php');

MLCGenDriver::Run($arrDBData, $arrXTPLData);
