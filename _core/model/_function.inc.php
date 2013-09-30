<?php
function _ak($strKey, $arrArray){
	return array_key_exists($strKey, $arrArray);
}
function _dv($mixVal){
    return die(var_dump($mixVal));
}
function _mserialzie($mixData){

    if(is_array($mixData)){
        $mixReturn = array();
        foreach($mixData as $strKey => $mixData){
            $mixReturn[$strKey] = _mserialzie($mixData);
        }
    }elseif(is_object($mixData)){
        if(method_exists($mixData, '__MSerialize')){
            $mixReturn = $mixData->__MSerialize();
        }elseif(method_exists($mixData, '__toJson')){
            $mixReturn = json_decode($mixData->__toJson(), true);
        }else{
            throw new Exception("Objects passed in to function '" . __FUNCTION__ . "' must have a '__MSerialize' or '__toJson' method");
        }
    }else{
        $mixReturn = $mixData;
    }

    return $mixReturn;
}
function _munserialzie($mixData){

    if(is_array($mixData)){
        if(array_key_exists('_mclass', $mixData)){
            $strClassName = $mixData['_mclass'];
            if(array_key_exists('_mpackage', $mixData)){
                $strPackage = $mixData['_mpackage'];
            }else{
                $strPackage = null;
            }
            if(m_class_exists($strClassName, $strPackage)){
                /*error_log("Unserializing: " . $strClassName);
                if($strClassName == 'MJaxServerControlAction'){
                    _dv($mixData);
                }*/
                $objMClass = new $strClassName(
                    new MData($mixData)
                );

                $mixReturn =  $objMClass;
            }else{
                throw new Exception("Failed to MUnserialize: " . $strClassName);
            }
        }else{
            $mixReturn = array();
            foreach($mixData as $strKey => $mixSubData){
                $mixReturn[$strKey] = _munserialzie($mixSubData);
            }
        }
    }else{
        $mixReturn = $mixData;
    }

    return $mixReturn;
}
function m_class_exists($strClass, $strPackage = null){

    if(!is_null($strPackage)){
        MLCApplication::InitPackage($strPackage);//Eventually strip out and make package loadable with out a permanint load
    }
    if(class_exists($strClass, false)){
        return true;
    }
    if(array_key_exists($strClass, MLCApplication::$arrClassFiles)){
        return true;
    }
    return false;
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
function mlc_error_handler($code, $message, $file, $line, $vars)
{

    error_log($message . ' - ' . $file . ' - ' . $line);

    if (0 == error_reporting()){
        return;
    }
    mlc_log_exception($code, $message, $file, $line, $vars);
    mlc_show_error_page('500');
    //throw new ErrorException($message, 0, $code, $file, $line);
}
function mlc_exception_handler(Exception $_E){
    error_log("Exception Hit");
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

        mlc_log_exception(
            $_E->getCode(),
            $_E->getMessage(),
            $_E->getFile(),
            $_E->getLine()
        );

    }
    mlc_show_error_page('500', $_E);

}
function mlc_log_exception($code, $message, $file, $line, $vars  = array()){
    try{
        /*if(array_key_exists('MDENotificationDriver', MLCApplication::$arrClassFiles)){
            require_once(MLCApplication::$arrClassFiles['MDENotificationDriver']);

            MDENotificationDriver::SendError($_E);
            mlc_show_error_page('500',$_E);
        }else{
            mlc_show_error_page('500',$_E);
        }*/
        $email = "
                <p>An error ($code) occurred on line
                <strong>$line</strong> and in the <strong>file: $file.</strong>
                <p> $message </p>";

        $email .= "<pre>" . print_r($vars, 1) . "</pre>";

        $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Email the error to someone...
        error_log($email, 1, 'log@mattleaconsulting.com', $headers);
    }catch(Exception $e){
        //Shit
        error_log($e->getMessage() . ' !!!!!');
        mlc_show_error_page('500', $e);
    }

}