<?php
class MLCApp{
	protected $strPrefix = null;
	protected $strAppName = null;
	protected $strAppDir = null;
	public function __construct($strAppName, $strPrefix = null){
		$this->strAppName = $strAppName;
		$this->strAppDir = __MODEL_APPS_DIR__ . '/' . $this->strAppName;
		if(is_null($strPrefix)){
			$this->strPrefix = substr(strtoupper($this->strAppName),0, 4);
		}else{
			$this->strPrefix = strtoupper($strPrefix);
		}
	}
	public function __get($strName){
		switch($strName){
			case('Name'):
				return $this->strAppName;
			break;
			case('Prefix'):
				return $this->strPrefix;
			break;
			case('AppDir'):
				return $this->strAppDir;
			break;
			default:
				throw new Exception("No property " . $strName . " in " . __CLASS__);
		}
	}
}
