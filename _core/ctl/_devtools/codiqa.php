<?php
require_once('_config.inc.php');
MLCApplication::InitPackage('MDE');
MLCApplication::InitPackage('MLCCodiqa');
$objCodiqaData = MLCCodiqaDriver::ParseJSON(file_get_contents(__MLC_CODIQA_CORE__ . '/SchematicalTest1.cdqa'));
MLCCodiqaDriver::GenerateMJaxControlModel($objCodiqaData);
die();