<?php
if(array_key_exists('p', $_GET)){
    $strNamespace = $_GET['n'];
    $strPath = $_GET['p'];
    if(array_key_exists('r', $_GET)){
        $strRoot = $_GET['r'];
    }else{
        $strRoot = __INSTALL_ROOT_DIR__ . '/apps/';
    }
    MLCPackageManager::DeployAppToAWS($strNamespace, $strPath,  $strRoot);
}
    $arrApps = MLCApplication::GetInstalledAppNames();
    $arrPackages = MLCApplication::GetInstalledPackageNames();
    //$strPath = '/apps/' . MLC_APPLICATION_NAME;
?>
<h2>Apps</h2>
<?php
foreach($arrApps as $intIndex => $strApp){ ?>
    <a href='?n=<?php echo $strApp; ?>&p=/apps/<?php echo $strApp; ?>'><?php echo $strApp; ?></a><br/>
<?php } ?>
<h2>Packages</h2>
<?php
foreach($arrPackages as $strPackage => $strPackageLoc){ ?>
    <a href='?n=<?php echo  $strPackage; ?>&p=/packages/<?php echo  $strPackage; ?>&r=<?php echo substr($strPackageLoc, 0, strlen($strPackageLoc) - strlen($strPackage)); ?>'>
        <?php echo $strPackage; ?>
    </a><br/>
<?php } ?>
<script>

</script>

