<?php
/* 
 * This file serves as a base for all api functionality
 */
require_once('_config.inc.php');
MLCApplication::InitPackage('MLCEntityModel');
MLCEntityModelDriver::Run('MLCEntityModelHome');
?>
