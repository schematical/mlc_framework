<?php


$arrPackageData = MLCPackageManager::ListPackages();
$arrInstalledPackageData = MLCApplication::GetInstalledPackageNames();
//die(json_encode($arrInstalledPackageData));
foreach($arrPackageData as $intIndex => $arrPackage){
    if(array_key_exists($arrPackage['namespace'], $arrInstalledPackageData)){
        unset($arrInstalledPackageData[$arrPackage['namespace']]);
        $arrPackageData[$intIndex]['_installed'] = true;
    }else{
        $arrPackageData[$intIndex]['_installed'] = false;
    }
}

if(array_key_exists('p', $_GET)){
    if($_GET['p'] == '__ALL__'){
        foreach($arrPackageData as $intIndex => $arrPackage){
            if($arrPackage['_installed']){
                if(array_key_exists($_GET['p'], $arrInstalledPackageData)){
                    $strPackageLoc = $arrInstalledPackageData[$_GET['p']];
                }else{
                    $strPackageLoc = null;
                }
                MLCPackageManager::InstallPackage($arrPackage['namespace'], __INSTALL_ROOT_DIR__);
            }
        }
    }
    if($_GET['a'] == 'push'){

    }else{
        //Pull
        if(array_key_exists($_GET['p'], $arrInstalledPackageData)){
            $strPackageLoc = $arrInstalledPackageData[$_GET['p']];
        }else{
            $strPackageLoc = null;
        }
        MLCPackageManager::InstallPackage(
            $_GET['p'],
            $strPackageLoc
        );
    }
}
?>
<h1>Package Manager</h1>

<h3>Official Schematical Packages</h3>
<?php foreach($arrPackageData as $intIndex => $arrPackage){ ?>
    <?php echo $arrPackage['namespace']; ?>
    <a href='?p=<?php echo $arrPackage['namespace']; ?>&a=pull'>Pull</a>
        <?php if(
            ($arrPackage['_installed']) &&
            (array_key_exists('MLCGit', $arrInstalledPackageData))
        ){ ?>
            - <a href='?p=<?php echo $arrPackage['namespace']; ?>&a=push'>Push</a>
        <?php } ?>
    <br/>
<?php } ?>
<h3>
    <a href='?p=_ALL_'>Update All Installed</a>
</h3>
<h3>Other Packages</h3>
<?php
foreach($arrInstalledPackageData as $strPackage => $strPackageLoc){ ?>
    <?php echo $strPackage; ?>
    <a href='?p=<?php echo  $strPackage; ?>&a=pull'>
        Pull
    </a> -
    <a href='?p=<?php echo  $strPackage; ?>&a=pull'>
        Push
    </a>

    <br/>
<?php } ?>

//die(json_encode($arrPackageData, JSON_PRETTY_PRINT));