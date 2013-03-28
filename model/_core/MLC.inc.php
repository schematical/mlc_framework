<?php


MLCApplicationBase::$arrClassFiles['MLCServer'] = __MODEL_MLC_CORE__ . '/MLCServer.class.php';
MLCApplicationBase::$arrClassFiles['MLCPackage'] = __MODEL_MLC_CORE__ . '/MLCPackage.class.php';
MLCApplicationBase::$arrClassFiles['MLCForm'] = __MODEL_MLC_CORE__ . '/MLCForm.class.php';
MLCApplicationBase::$arrClassFiles['MLCApp'] = __MODEL_MLC_CORE__ . '/MLCApp.class.php';

require_once(__MODEL_MLC_CORE__ . '/_enum.inc.php');
require_once(__MODEL_MLC_CORE__ . '/_exception.inc.php');
require_once(__MODEL_MLC_CORE__ . '/_function.inc.php');
