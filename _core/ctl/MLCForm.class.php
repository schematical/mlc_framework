<?php
class MLCForm extends MJaxForm{
    public $objEntityManager = null;
	public function Form_Create(){
		parent::Form_Create();

		$this->strAssetMode = MJaxAssetMode::WWW;
		//MJaxForm::DefineAssetDir($this->strAssetMode);
		
		//$this->strTemplate =  __VIEW_ACTIVE_APP_DIR__  . '/www'. str_replace(__CTL_ACTIVE_APP_DIR__, '', MLCApplication::$strCtlFile);
		$this->strTemplate =  MLCForm::LocateTemplate(MLCApplication::$strCtlFile, $this->strAssetMode);

		$this->AddHeaderAsset(new MJaxJSHeaderAsset(
			MLCApplication::GetAssetUrl('/js/' . MLC_APPLICATION_PREFIX . '.js')
		));
		//$this->AddJSCall(MLC_APPLICATION_PREFIX . '.Init();');

	}
	public static function LocateTemplate($strFileLoc, $strAssetMode = 'www'){
		$strFileName = str_replace('.class.php', '', $strFileLoc);
        $strFileName = str_replace('.php', '', $strFileName);
        $strFileName = str_replace(__CTL_ACTIVE_APP_DIR__, __VIEW_ACTIVE_APP_DIR__ . '/' . $strAssetMode, $strFileName);
        
        return $strFileName . '.tpl.php';
	}
	

	
	public function RenderHeader(){
		require_once(__MDE_CORE_VIEW__ . '/_header.tpl.php');
	}
	public function Redirect($strLocation, $arrQSData = array()){
		if(count($arrQSData) > 0){
			$strQS = '?';
			
			foreach($arrQSData as $strKey=>$mixValue){
				$strQS .= $strKey . '=' . $mixValue . "&";
			}
			//die($strQS);
			$strQS = substr($strQS, 0, strlen($strQS) -1);
			$strLocation .= $strQS;
		}
		if($this->strCallType != MJaxCallType::Ajax){
			header('location:' . $strLocation);
			exit();
		}else{
			$strJS = sprintf("document.location.href = '%s';", $strLocation);
			$this->AddJSCall($strJS);
			
		}
	}
}

