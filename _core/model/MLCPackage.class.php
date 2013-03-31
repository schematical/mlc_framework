<?php
class MLCPackage{
	protected $strPrefix = null;
	protected $strPacakgeName = null;
	protected $strPackageDir = null;
	public function __construct($strPackageName, $strPrefix = null){
		$this->strPacakgeName = $strPackageName;
		$this->strPackageDir = __MODEL_PACKAGE_DIR__ . '/' . $this->strPacakgeName;
		if(is_null($strPrefix)){
			$this->strPrefix = $strPackageName;
		}else{
			$this->strPrefix = $strPrefix;
		}
	}
	public function HasCodeGen(){
		if(file_exists($this->strPackageDir . '/_codegen/_config.inc.php')){
			return true;
		}
		return false;
	}
	public function GetCodeGenTemplates(){
		if(!$this->HasCodeGen()){
			throw new Exception('An error has occured in getting package "%s" template files for CodeGen');
		}
		$arrXTPLData = null;
		require_once($this->strPackageDir . '/_codegen/_config.inc.php');
		if(is_null($arrXTPLData)){
			throw new Exception('An error has occured in getting package "%s" template files for CodeGen', $this->strPacakgeName);
		}
		return $arrXTPLData;
		
	}
	public function Init(){
		if(!file_exists($this->strPackageDir . '/package.inc.php')){
			throw new Exception('An error has occured in getting package "%s" template files for Init', $this->strPacakgeName);
		}
	}
	public function __get($strName){
		switch($strName){
			case('Name'):
				return $this->strPacakgeName;
			break;
			case('Prefix'):
				return $this->strPrefix;
			break;
			case('PackageDir'):
				return $this->strPackageDir;
			break;
			default:
				throw new Exception("No property " . $strName . " in " . __CLASS__);
		}
	}
}
