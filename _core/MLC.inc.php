<?php

define('__MLC_CORE__', dirname(__FILE__));
define('__MLC_CORE_MODEL__', __MLC_CORE__ . '/model');
define('__MLC_CORE_CTL__', __MLC_CORE__ . '/ctl');
define('__MLC_CORE_VIEW__', __MLC_CORE__ . '/view');
define('__MLC_CORE_ASSETS__', __MLC_CORE__ . '/assets');

MLCApplicationBase::$arrClassFiles['MLCServer'] = __MLC_CORE_MODEL__ . '/MLCServer.class.php';
MLCApplicationBase::$arrClassFiles['MLCPackage'] = __MLC_CORE_MODEL__ . '/MLCPackage.class.php';
MLCApplicationBase::$arrClassFiles['MLCApp'] = __MLC_CORE_MODEL__ . '/MLCApp.class.php';
MLCApplicationBase::$arrClassFiles['MLCTriggerBase'] = __MLC_CORE_MODEL__ . '/MLCTriggerBase.class.php';
MLCApplicationBase::$arrClassFiles['MLCRewriteHandelerBase'] = __MLC_CORE_MODEL__ . '/MLCRewriteHandelerBase.class.php';
//Ctl
MLCApplicationBase::$arrClassFiles['MLCForm'] = __MLC_CORE_CTL__ . '/MLCForm.class.php';
require_once(__MLC_CORE_MODEL__ . '/_enum.inc.php');
require_once(__MLC_CORE_MODEL__ . '/_exception.inc.php');
require_once(__MLC_CORE_MODEL__ . '/_function.inc.php');
