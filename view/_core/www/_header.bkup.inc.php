<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="en-us" http-equiv="Content-Language">
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title></title>
	
	<!-- MJax Core scripts -->
	<script language="javascript" src="<?php echo(__ASSETS_JS__); ?>/_core/MJax.js"></script>
	<script language="javascript" src="<?php echo(__ASSETS_JS__); ?>/_core/jquery/jquery-1.6.3.js"></script>
	<script language="javascript" src="<?php echo(__ASSETS_JS__); ?>/_core/jquery/jquery.easing.1.3.js"></script>
	<script language="javascript" src="<?php echo(__ASSETS_JS__); ?>/_core/jquery/jquery.timers-1.2.js"></script>
	<script language="javascript">
	    $('document').ready(function(){ 
	        MJax.Init();
	    });
	</script>
	<?php 
		$this->RenderControlJSCalls();
		$this->RenderClassJSCalls();
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo(__ASSETS_CSS__); ?>/reset.css">

	<?php $this->RenderHeaderAssets(); ?>
	<style>
		<?php $this->RenderCssClasses(); ?>
	</style>

	<script type='text/javascript' src='<?php echo(__ASSETS_JS__); ?>/jquery.dropdown.js'></script>
<?php if(defined('__GOOGLE_ANALYTICS_CODE__')){ ?>
	<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo __GOOGLE_ANALYTICS_CODE__; ?>']);
		  _gaq.push(['_setDomainName', 'snowshoestamp.com']);
		  _gaq.push(['_trackPageview']);
		  
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
<?php } ?>
</head>
<body>
  <div id='mainWindow'>