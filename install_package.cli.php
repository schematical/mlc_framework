#!/php -q
<?php
if(count($argv) > 1){
    $strPackage = $argv[1];
}else{
    throw new Exception("You need to pass in an app name");
}
require_once(dirname(__FILE__) . '/_core/model/MLCPackageManager.class.php');
MLCPackageManager::InstallPackage($strPackage, dirname(__FILE__));
