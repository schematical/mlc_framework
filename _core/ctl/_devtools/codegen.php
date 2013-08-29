<?php
define('SKIP_DATALAYER','true');
//First get the build assembly
MLCApplication::InitPackage('MDETools');
MDEApplication::SetActiveApp(MLC_APPLICATION_NAME);
$objMConf = new MConf(__INSTALL_ROOT_DIR__ . '/_mlc/mconf.json');
$objDataModel = $objMConf->DataModels('MDEEntityRelDataModel');
if(false){

    $i = 0;
    $strDBName = 'DB_' . $i;
    while(defined($strDBName)){
        //_dv(constant($strDBName));
        $arrDBData = unserialize(constant($strDBName));
        $arrDBData['hostname'] = $arrDBData['host'];
        $arrDBData['username'] = $arrDBData['user'];
        $arrDBData['password'] = $arrDBData['pass'];
        $arrDBData['dbname'] = $arrDBData['db_name'];

        $arrTableData = $objDataModel->ParseFromActiveDB(
            $strDBName,
            $arrDBData
        );
        $objDataModel->AddAsset(
            $strDBName,
            $arrTableData
        );
        $i += 1;
        $strDBName = 'DB_' . $i;
    }
}else{
    $strDBName = 'DB_1';
    $arrDBData = unserialize(constant($strDBName));
    //_dv($arrDBData);
    $arrDBData['hostname'] = $arrDBData['host'];
    $arrDBData['username'] = $arrDBData['user'];
    $arrDBData['password'] = $arrDBData['pass'];
    $arrDBData['dbname'] = $arrDBData['db_name'];

    $arrTableData = $objDataModel->ParseFromActiveDB(
        $strDBName,
        $arrDBData
    );
    $objDataModel->AddAsset(
        $strDBName,
        $arrTableData
    );
}
$objDataModel->Generate(
    null,
    $objMConf->SaveDriver
);
echo MDEBuildDriver::Report();