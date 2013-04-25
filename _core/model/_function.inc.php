<?php
function _ak($strKey, $arrArray){
	return array_key_exists($strKey, $arrArray);
}
function _dv($mixVal){
    return die(var_dump($mixVal));
}


function mlc_error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting()){
        return;
    }
    throw new ErrorException($message, 0, $code, $file, $line);
}
function mlc_exception_handler($_E){
    //Put something in for dev vs prod etc
    require_once(__MLC_CORE_VIEW__ . '/exception.tpl.php');

}