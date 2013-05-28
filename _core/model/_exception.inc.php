<?php
class MLCMissingPropertyException extends Exception{
	public function __construct($objObject, $strProp){
		parent::__construct(
			sprintf(
				'Class "%s" does not have a property "%s"',
				get_class($objObject),
				$strProp
			)
		);
	}
}
class MLCWrongTypeException extends Exception{
	public function __construct($strFunction, $mixParameter){
		parent::__construct(
			sprintf(
				'Function "%s" parameter %s does not accept this data type',
				$strFunction,
				$mixParameter
			)
		);
	}
}
