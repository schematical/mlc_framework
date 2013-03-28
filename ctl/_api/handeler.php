<?php
/* 
 * This file serves as a base for all api functionality
 */
$arrParts = explode('/',$_SERVER['REQUEST_URI']);
define('MLC_APPLICATION_NAME', $arrParts[1]);
require_once('_config.inc.php');
MLCApplication::RunApi();
?>
