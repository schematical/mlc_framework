<?php
define('__MLC_LOCATION__', dirname(__FILE__));
if(!defined('__MLC_DB_MANAGER__')){
	MLCApplication::InitPackage('MLCDBManager');
}
define('__MLC_LOCATION_CORE__', __MLC_LOCATION__ . '/_core');
define('__MLC_LOCATION_CORE_CTL__', __MLC_LOCATION_CORE__ . '/ctl');
define('__MLC_LOCATION_CORE_MODEL__', __MLC_LOCATION_CORE__ . '/model');
define('__MLC_LOCATION_CORE_VIEW__', __MLC_LOCATION_CORE__ . '/view');
MLCApplicationBase::$arrClassFiles['MLCLocation'] = __MLC_LOCATION_CORE_MODEL__ . '/data_layer/MLCLocation.class.php';
MLCApplicationBase::$arrClassFiles['MJaxGoogleMapMarker'] = __MLC_LOCATION_CORE_CTL__ . '/MJaxGoogleMapMarker.class.php';
MLCApplicationBase::$arrClassFiles['MJaxGoogleMapPanel'] = __MLC_LOCATION_CORE_CTL__ . '/MJaxGoogleMapPanel.class.php';
MLCApplicationBase::$arrClassFiles['MLCLocationEditPanel'] = __MLC_LOCATION_CORE_CTL__ . '/MLCLocationEditPanel.class.php';
MLCApplicationBase::$arrClassFiles['MLCLocationListPanel'] = __MLC_LOCATION_CORE_CTL__ . '/MLCLocationListPanel.class.php';

require_once(__MLC_LOCATION_CORE_CTL__ . '/_events.inc.php');
//require_once(__MLC_LOCATION_CORE__ . '/_enum.inc.php');
//require_once(__MLC_LOCATION_CORE__ . '/_exception.inc.php');
