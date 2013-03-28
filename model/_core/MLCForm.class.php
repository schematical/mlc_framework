<?php
class MLCForm extends MJaxForm{
	
	public function Form_Create(){
		parent::Form_Create();
		$this->strAssetMode = MJaxAssetMode::WWW;
		MJaxForm::DefineAssetDir($this->strAssetMode);
		
		$this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/' . $this->strAssetMode . $this->LocateTemplate(MLCApplication::$strCtlFile, $this->strAssetMode);
		//die($this->strTemplate);
		$this->AddHeaderAsset(new MJaxJSHeaderAsset(__ASSETS_JS__ . '/' . MLC_APPLICATION_PREFIX .'/App.js'));
		$this->AddJSCall(MLC_APPLICATION_PREFIX . '.Init();');
		
		
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

