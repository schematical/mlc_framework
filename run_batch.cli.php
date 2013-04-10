#!/php -q
<?php

//populate packages

if(count($argv) > 1){
	$strApp = $argv[1];
}else{
	throw new Exception("You need to pass in an app name");
}
if(count($argv) > 2){
	$strEnv = $argv[2];
}
require_once(dirname(__FILE__) . '/_config.inc.php');
MLCApplication::RunBatch();
