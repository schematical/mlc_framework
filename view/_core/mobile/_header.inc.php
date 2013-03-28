<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta charset="utf-8" />
        
        
        <meta property="og:title" content="Time Machine by Schematical" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://timemachine.schematical.com" />
		<meta property="og:site_name" content="Time Machine by Schematical" />
		<meta property="og:image" content="http://timemachine.schematical.com/assets/images/timemachine.200.logo.png"/>
		<meta property="fb:admins" content="100001842107744" />
		  
		  
        <link rel="apple-touch-icon" href="assets/images/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
        	Time Machine
        </title>
        
		<link href="<?php echo(__ASSETS_CSS__); ?>/photoswipe/photoswipe.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo(__ASSETS_CSS__); ?>/jquery.simpleDialog.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo(__ASSETS_CSS__); ?>/styles.css" type="text/css" rel="stylesheet" />
		<!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script-->
        
        <link rel="stylesheet" href="<?php echo(__ASSETS_CSS__); ?>/jquery.mobile-1.1.0.css" />
        <script src="<?php echo(__ASSETS_JS__); ?>/jquery-1.6.3.js"></script>
		<script src="<?php echo(__ASSETS_JS__); ?>/jquery.mobile-1.1.0.js"></script>
		<script type="text/javascript" src="<?php echo(__ASSETS_JS__); ?>/jquery.simpleDialog.js"></script>
		<script src="<?php echo(__ASSETS_JS__); ?>/MJaxMobile.js">
		</script>
		<script>
			$(function(){
				MJaxMobile.Init({
					APP_URL : '<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>'
				});
				MDE.Init();
			});
		</script>
		
		<?php $this->RenderHeaderAssets(); ?>
		<style>
			<?php $this->RenderCssClasses(); ?>
		</style>
	
		<?php //$this->RenderTemplate('_meta'); ?>
		
		
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-25112886-8']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
    </head>
    <body>
     	<div data-role="page" id="mainWindow">
            <div data-role="content">
            	<form>
            	