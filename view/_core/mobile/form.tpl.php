<ul data-role="listview">
	<?php foreach($this->arrControls as $intIndex => $objControl){ 
		try{
			if((strtolower($objControl->Style->Display) != 'none')){
			$strCtlHtml = $objControl->Render(false);
	?>
			<li data-role="fieldcontain">
				<?php if(
					(!$objControl instanceof MJaxButton) &&
					(!$objControl instanceof MJaxLinkButton) &&
					(!$objControl instanceof MJaxPanel)
				){ ?>
		    		<label for="name"><?php echo $objControl->Name ?>:</label>
		    	<?php } ?>
				<?php echo $strCtlHtml; ?>
			</li>
	<?php 
			}
		}catch(Exception $e){ }
	} ?>
</ul>
