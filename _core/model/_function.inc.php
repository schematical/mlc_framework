<?php
function _ak($strKey, $arrArray){
	return array_key_exists($strKey, $arrArray);
}
function _dv($mixVal){
    return die(var_dump($mixVal));
}

function mlc_show_error_page($intNumber, $_E = null){

    if(defined('__CTL_ACTIVE_APP_DIR__')){
        $strPageLoc = __CTL_ACTIVE_APP_DIR__ . '/_' . $intNumber. '.php';
        if(file_exists($strPageLoc)){
            die(require_once($strPageLoc));
        }
    }
    die(require_once(__MLC_CORE_VIEW__ . '/' . $intNumber  . '.html'));
}
function mlc_error_handler($code, $message, $file, $line)
{
    if (0 == error_reporting()){
        return;
    }
    throw new ErrorException($message, 0, $code, $file, $line);
}
function mlc_exception_handler($_E){

    function done($code, $message, $file, $line){
        die($code . ' - ' . $message . ' - ' . $file . ' - ' . $line);
        mlc_show_error_page('500');
    }
    set_error_handler('done');
    //Put something in for dev vs prod etc
    if(defined('MLC_DISPLAY_EXCEPTIONS')){
        die(require_once(__MLC_CORE_VIEW__ . '/exception.tpl.php'));
    }else{
        try{
            if(array_key_exists('MDENotificationDriver', MLCApplication::$arrClassFiles)){
                require_once(MLCApplication::$arrClassFiles['MDENotificationDriver']);
                MDENotificationDriver::SendError($_E);
            }else{
                mlc_show_error_page('500');
            }
        }catch(Exception $e){
            //Shit
            mlc_show_error_page('500');
        }

    }
    mlc_show_error_page('500', $_E);

}