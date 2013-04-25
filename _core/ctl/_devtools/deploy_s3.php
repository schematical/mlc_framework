<?php
if(array_key_exists('p', $_GET)){
    $strPath = $_GET['p'];
    MLCPackageManager::DeployAppToAWS($strPath,  $_GET['r']);
}
    $arrApps = MLCApplication::GetInstalledAppNames();
    $arrPackages = MLCApplication::GetInstalledPackageNames();
    //$strPath = '/apps/' . MLC_APPLICATION_NAME;
?>
<h2>Apps</h2>
<?php
foreach($arrApps as $intIndex => $strApp){ ?>
    <a href='?p=/apps/<?php echo $strApp; ?>'><?php echo $strApp; ?></a><br/>
<?php } ?>
<h2>Packages</h2>
<?php
foreach($arrPackages as $strPackage => $strPackageLoc){ ?>
    <a href='?p=<?php echo  $strPackage; ?>&r=<?php echo substr($strPackageLoc, 0, strlen($strPackageLoc) - strlen($strPackage)); ?>'>
        <?php echo $strPackage; ?>
    </a><br/>
<?php } ?>
<script>

</script>

