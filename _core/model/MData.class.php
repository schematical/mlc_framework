<?php
class MData  implements arrayaccess, Iterator, countable{
    protected $arrData = null;
    public function __construct($arrData){
        $this->arrData = $arrData;
    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {

            default:
                if(array_key_exists($strName, $this->arrData)){
                    return $this->arrData[$strName];
                }else{
                    throw new MLCMissingPropertyException($this, $strName);
                }
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            default:

            if(array_key_exists($strName, $this->arrData)){
                return $this->arrData[$strName] = $mixValue;
            }else{
                throw new MLCMissingPropertyException($this, $strName);
            }
        }
    }
    public function count()
    {
        return count($this->arrData);
    }
    public function removeByIndex($intIndex){
        unset($this->arrData[$intIndex]);
    }
    public function offsetSet($strKey, $mixValue) {
        if (is_null($strKey)) {
            $this->arrData[] = $mixValue;
        } else {
            $this->arrData[$strKey] = $mixValue;
        }
    }
    public function offsetExists($strKey) {
        error_log('Offset Exists:' . $strKey . ' - ' . $this->arrData['_mclass']);
        return array_key_exists($strKey, $this->arrData);
    }
    public function offsetUnset($strOffset) {
        unset($this->arrData[$strOffset]);
    }
    public function offsetGet($strOffset) {
        if(array_key_exists($strOffset, $this->arrData)){
            return $this->arrData[$strOffset];
        }else{
            return null;
        }
    }
    public function rewind()
    {
        reset($this->arrData);
    }

    public function current()
    {
        $var = current($this->arrData);
        return $var;
    }

    public function key()
    {
        $var = key($this->arrData);

        return $var;
    }

    public function next()
    {
        $var = next($this->arrData);
        return $var;
    }

    public function valid()
    {
        $key = key($this->arrData);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
}