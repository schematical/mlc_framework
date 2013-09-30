<?php
abstract class MLCObjectBase{
    protected $blnMapToSetters = true;
    /**
     *TODO: Maybe create a global universal platform entity whole freaking world id
     */
    public function __construct($objData = null){
        if($objData instanceof MData){
            $this->__MUnserialize($objData);
        }
    }
    public function __MSerialize(){
        $arrData = array();
        $arrData['_mclass'] = get_class($this);
        //$arrData['_mpackage'] = null;
        return $arrData;
    }
    public function __MUnserialize($arrData){
        if($this->blnMapToSetters){

            foreach($arrData as $strKey => $mixData){
                error_log('!!!!!' . $strKey );
                $mixMData = _munserialzie($mixData);

                switch($strKey){
                    case('_mclass'):
                    case('_mpackage'):
                    case('_m_clientside_class'):
                    break;
                    default:
                       $this->__set($strKey, $mixMData);
                }
            }
        }
        return $arrData;
    }
}