   </div>
    <div id="divModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	  <!--div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Modal header</h3>
      </div-->
      <div class="modal-body">
        <p id='pBody'>One fine body&hellip;</p>
      </div>
      <!--div class="modal-footer">
        <a href="#" class="btn">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a>
      </div-->
    </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-alert.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-modal.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-dropdown.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-scrollspy.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-tab.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-tooltip.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-popover.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-button.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-collapse.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-carousel.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-typeahead.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/bootstrap-affix.js"></script>

    <script src="<?php echo(__ASSETS_JS__); ?>/holder/holder.js"></script>
    <script src="<?php echo(__ASSETS_JS__); ?>/google-code-prettify/prettify.js"></script>

    <script src="<?php echo(__ASSETS_JS__); ?>/application.js"></script>


    <!-- Analytics
    ================================================== -->
    <script>
      var _gauges = _gauges || [];
      (function() {
        var t   = document.createElement('script');
        t.type  = 'text/javascript';
        t.async = true;
        t.id    = 'gauges-tracker';
        t.setAttribute('data-site-id', '4f0dc9fef5a1f55508000013');
        t.src = '//secure.gaug.es/track.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(t, s);
      })();
    </script>


	
       <?php 
			//$strFormState = sprintf('<input type="hidden" name="%s" id="%s" value="%s" />', MJaxFormPostData::MJaxForm__FormState, MJaxFormPostData::MJaxForm__FormState, MJaxForm::Serialize($this));
			//echo($strFormState);
		?>		        
        <?php $this->RenderClassJSCalls(); ?>
        <?php $this->RenderControlRegisterJS(); ?>
        <!---START:MISC JS CALLS--->
        <?php $this->RenderMiscJSCalls(); ?>
        <!---END:MISC JS CALLS--->
    </body>
</html>