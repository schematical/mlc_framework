<?php
function _ak($strKey, $arrArray){
	return array_key_exists($strKey, $arrArray);
}
function _dv($mixVal){
    return die(var_dump($mixVal));
}
function _dk($mixVal, $intDepth = 0){
    error_log('DK: count' . $intDepth);
    if(is_array($mixVal)){
        $mixReturn = array();
        foreach($mixVal as $strKey => $mivVVal){
            error_log('DK: Array' . $strKey);
            $mixReturn[$strKey] =  _dk($mivVVal, ($intDepth + 1));
        }
    }elseif(is_object($mixVal)){
        $mixReturn = get_class($mixVal);
        error_log('DK: Class - ' . $mixReturn);

    }else{
        $mixReturn = $mixVal;
        error_log('DK: Other - ' . $mixReturn);
    }

    if($intDepth == 0){
        _dv($mixReturn);
    }else{
        if($intDepth > 5){
            throw new Exception("Your fucked");
        }
        return $mixReturn;
    }
}
function _jd($strJson){

    $arrJson = json_decode($strJson, true);
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            //echo ' - No errors';
            break;
        case JSON_ERROR_DEPTH:
            throw new Exception(' - Maximum stack depth exceeded');
            break;
        case JSON_ERROR_STATE_MISMATCH:
            throw new Exception(' - Underflow or the modes mismatch');
            break;
        case JSON_ERROR_CTRL_CHAR:
            throw new Exception(' - Unexpected control character found');
            break;
        case JSON_ERROR_SYNTAX:
            throw new Exception(' - Syntax error, malformed JSON');
            break;
        case JSON_ERROR_UTF8:
            throw new Exception(' - Malformed UTF-8 characters, possibly incorrectly encoded');
            break;
        default:
            throw new Exception(' - Unknown error');
            break;
    }
    return $arrJson;
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
    error_log($message . ' - ' . $file . ' - ' . $line);
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
    //die(SERVER_ENV);
    if(
        (defined('MLC_DISPLAY_EXCEPTIONS')) ||
        (!defined('SERVER_ENV'))
    ){
        die(require_once(__MLC_CORE_VIEW__ . '/exception.tpl.php'));
    }else{

        try{
            if(array_key_exists('MDENotificationDriver', MLCApplication::$arrClassFiles)){
                require_once(MLCApplication::$arrClassFiles['MDENotificationDriver']);

                MDENotificationDriver::SendError($_E);
                mlc_show_error_page('500',$_E);
            }else{
                mlc_show_error_page('500',$_E);
            }
        }catch(Exception $e){
            //Shit
            mlc_show_error_page('500', $e);
        }

    }
    mlc_show_error_page('500', $_E);

}